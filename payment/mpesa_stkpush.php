<?php
    //mpesa_stkpush.php
    // Database connection 
    require_once __DIR__ . '/../config.php';
    $cart = cart(); //Fetch order items from the cart
    
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

        //COST CALCULATION + DELIVERY COST + TAX
        $deliveryCost = $_SESSION['delivery_address']['delivery_cost'] ?? null;
        $sub = cart_total();
        //$amount = $sub + (number_format($deliveryCost,0) ?? 0);
        $amount = '1';
        $order_type = $_SESSION['dining'];
        $sub_total = $sub * 0.84;
        $delivery_subtotal = ($deliveryCost ?? 0) * 0.84;
        $tax = $amount * 0.16;

        //GET DATE AND TIME FOR ORDER NUMBER TO SET AS ORDER NUMBER
        $dateObj = DateTime::createFromFormat('U.u', microtime(TRUE));
        $dateObj->setTimeZone(new DateTimeZone('Africa/Nairobi'));
        $date = $dateObj->format('YmdHisu');

        //ORDER NUMBER IS SET AS DATE AND TIME IN YMDHISU FORMAT
        $order_number = $date;
        $order_customertype = 'Online';
        $order_status = 'Unpaid';
        //$amount = '1';

        // ADD TO ORDERS TABLE
        $sql = "INSERT INTO orders (order_number, order_customertype, order_type, order_subtotalamt, order_deliveryamt, order_taxamt, order_totalamt, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conx->prepare($sql);
        $stmt->bind_param("ssssdddd", $order_number, $order_customertype, $order_type, $sub_total, $delivery_subtotal, $tax, $amount, $order_status);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;
        }else {
            log_payment_error('DB insert failed for order record', [
                'mysqli_error' => $stmt->error,
                'order_number' => $order_number,
            ]);
            echo json_encode(['success' => false, 'message' => 'Error saving order details.']);
            $conx->close();
            exit;
        }

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
            $merchant_request_id = $stk_push_response->MerchantRequestID;
            $sql = "INSERT INTO payments (pay_orderid, pay_phone_number, pay_amount, pay_checkout_req_id, pay_merchant_req_id, pay_status, pay_method) VALUES (?, ?, ?, ?, ?, 'PENDING', 'M-PESA')";
            $stmt = $conx->prepare($sql);
            $stmt->bind_param("ssdss", $order_id, $phone_number, $amount, $checkout_request_id, $merchant_request_id);

            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Payment request sent. Please check your phone to complete the transaction.',
                    'checkout_request_id' => $checkout_request_id,
                    'merchant_request_id' => $merchant_request_id
                ]);
            } else {
                log_payment_error('DB insert failed for payment record', [
                    'mysqli_error' => $stmt->error,
                    'checkout_request_id' => $checkout_request_id,
                    'merchant_request_id' => $merchant_request_id
                ]);
                echo json_encode(['success' => false, 'message' => 'Error saving payment details.']);
            }

            foreach ($cart as $item) {
                $sql = "INSERT INTO order_items (order_item_orderid, order_item_itemid, order_item_quantity, order_item_unitprice,order_item_subtotalprice) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conx->prepare($sql);
                $subtotal = round($item['price'] * $item['qty'], 2);
                $stmt->bind_param("iiidd", $order_id, $item['id'], $item['qty'], $item['price'], $subtotal);

                if (!$stmt->execute()) {
                    log_payment_error('DB insert failed for order_items record', [
                        'mysqli_error' => $stmt->error,
                        'order_id' => $order_id,
                        'item_id' => $item['id'],
                    ]);
                    // Response already sent — log only, don't echo/exit here.
                }
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
