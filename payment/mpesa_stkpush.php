<?php
    //mpesa_stkpush.php
    // Database connection 
    require_once __DIR__ . '/../config.php';
    
    if ($conx->connect_error) {
        log_payment_error('DB connection failed: ' . $conx->connect_error);
        die("Connection failed: " . $conx->connect_error);
    }


    /**
     * Append a line to the STK push error log.
     * Creates the logs directory on first use if it doesn't exist.
     */
    function log_payment_error($message, array $context = []) {
        $logDir = __DIR__ . '/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/mpesa_errors.log';

        $line = '[' . date('Y-m-d H:i:s') . '] ' . $message;
        if (!empty($context)) {
            $line .= ' | ' . json_encode($context);
        }
        $line .= PHP_EOL;

        // Falls back to PHP's configured error_log if the file can't be written
        // (e.g. permissions issue), so the failure is never silently dropped.
        if (@file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX) === false) {
            error_log('mpesa_stkpush: ' . $line);
        }
    }

    // Function to generate access token
    function getAccessToken($consumer_key, $consumer_secret) {
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        session_write_close(); // Close the session to avoid blocking other requests while waiting for the cURL response
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($curl);
        $curl_error = curl_error($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($result === false) {
            log_payment_error('getAccessToken cURL failed', ['curl_error' => $curl_error]);
            return null;
        }

        $decoded = json_decode($result);
        if (!isset($decoded->access_token)) {
            log_payment_error('getAccessToken: no access_token in response', [
                'http_status' => $status,
                'raw_response' => $result,
            ]);
            return null;
        }

        return $decoded->access_token;
    }

    // Function to initiate STK Push
    function initiateSTKPush($access_token, $business_short_code, $passkey, $amount, $phone_number, $callback_url) {
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = date('YmdHis');
        $password = base64_encode($business_short_code . $passkey . $timestamp);

        session_write_close(); // Close the session to avoid blocking other requests while waiting for the cURL response

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);

        $curl_post_data = array(
            'BusinessShortCode' => $business_short_code,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerBuyGoodsOnline',
            'Amount' => $amount,
            'PartyA' => $phone_number,
            'PartyB' => '8188320',
            'PhoneNumber' => $phone_number,
            'CallBackURL' => $callback_url,
            'AccountReference' => 'SHIFT',
            'TransactionDesc' => 'Payment of Subscrption'
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $curl_response = curl_exec($curl);
        $curl_error = curl_error($curl);
        curl_close($curl);

        if ($curl_response === false) {
            log_payment_error('initiateSTKPush cURL failed', [
                'curl_error' => $curl_error,
                'request' => $curl_post_data,
            ]);
            return null;
        }

        $decoded = json_decode($curl_response);

        if (!isset($decoded->ResponseCode) || $decoded->ResponseCode != "0") {
            // This is the log entry that was missing: the raw Daraja response
            // for every non-success STK push attempt.
            log_payment_error('STK push rejected by Daraja', [
                'phone' => $phone_number,
                'amount' => $amount,
                'raw_response' => $curl_response,
            ]);
        }

        return $decoded;
    }


    // Process the payment
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $phone_number = $_POST['mpesa_phone'];
        function normalizePhoneNumber($phone) {
            // Strip spaces, dashes, and any non-digit/plus characters
            $phone = preg_replace('/[^\d+]/', '', $phone);
            if (strpos($phone, '+254') === 0) {
                // +254712345678 -> 254712345678
                $phone = substr($phone, 1);
            } elseif (strpos($phone, '0') === 0) {
                // 0712345678 -> 254712345678
                $phone = '254' . substr($phone, 1);
            } elseif (strpos($phone, '254') === 0) {
                // already 254712345678
                // no change needed
            }  elseif (preg_match('/^[17]\d{8}$/', $phone)) {
                // 712345678 or 112345678 -> 254712345678
                $phone = '254' . $phone;
            } else {
                // Unexpected format, return as-is (will likely fail Safaricom validation)
            }
            return $phone;
        }
        $phone_number = normalizePhoneNumber($phone_number);
        //$amount = $_POST['amount'];
        $amount = '1';

        // Get access token
        $access_token = getAccessToken($consumer_key, $consumer_secret);

        if ($access_token === null) {
            echo json_encode(['success' => false, 'message' => 'Failed to initiate payment. Please try again.']);
            $conx->close();
            exit;
        }

        // Initiate STK Push
        $stk_push_response = initiateSTKPush($access_token, $business_short_code, $passkey, $amount, $phone_number, $callback_url);

        if ($stk_push_response !== null && isset($stk_push_response->ResponseCode) && $stk_push_response->ResponseCode == "0") {
            // Payment request successful, save to database
            $checkout_request_id = $stk_push_response->CheckoutRequestID;
            $sql = "INSERT INTO payments (pay_phone_number, pay_amount, pay_checkout_req_id, pay_status) VALUES (?, ?, ?, 'PENDING')";
            $stmt = $conx->prepare($sql);
            $stmt->bind_param("sds", $phone_number, $amount, $checkout_request_id);

            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Payment request sent. Please check your phone to complete the transaction.',
                    'checkout_request_id' => $checkout_request_id
                ]);
            } else {
                log_payment_error('DB insert failed for payment record', [
                    'mysqli_error' => $stmt->error,
                    'checkout_request_id' => $checkout_request_id,
                ]);
                echo json_encode(['success' => false, 'message' => 'Error saving payment details.']);
            }
        } else {
            // Note: initiateSTKPush() already logged the raw failure reason above.
            echo json_encode(['success' => false, 'message' => 'Failed to initiate payment. Please try again.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }

    $conx->close();
?>
