<?php
    // process_payment.php
    $env = parse_ini_file('../.env');
    
    // Database connection
    $servername = $env["LOCAL_HOST"];
    $username = $env["LOCAL_ROOT"];
    $password = $env["LOCAL_PASS"];
    $dbname = $env["LOCAL_DATA"];
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Daraja API configuration
    $consumer_key = 'GiwmpoeMf2K5llRh1Gt8bLMSdI2fHIy2';
    $consumer_secret = 'G7R8dGda67Ghgu0T';
    $business_short_code = '6205829'; //Store Number
    $passkey = '0f612f5c2e507632c614670f67cfeda96afeb69f5e0cdfc6be7296e0c13e8581';
    $callback_url = 'https://mpesa.tronsart.com/callback.php';
    
    // Function to generate access token
    function getAccessToken($consumer_key, $consumer_secret) {
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        return $result->access_token;
    }
    
    // Function to initiate STK Push
    function initiateSTKPush($access_token, $business_short_code, $passkey, $amount, $phone_number, $callback_url) {
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $timestamp = date('YmdHis');
        $password = base64_encode($business_short_code . $passkey . $timestamp);
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
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
        return json_decode($curl_response);
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
            } else {
                // Unexpected format, return as-is (will likely fail Safaricom validation)
            }
            return $phone;
        }
        $phone_number = normalizePhoneNumber($phone_number);

        $amount = $_POST['amount'];
        
        // Get access token
        $access_token = getAccessToken($consumer_key, $consumer_secret);
        
        // Initiate STK Push
        $stk_push_response = initiateSTKPush($access_token, $business_short_code, $passkey, $amount, $phone_number, $callback_url);
        
        if (isset($stk_push_response->ResponseCode) && $stk_push_response->ResponseCode == "0") {
            // Payment request successful, save to database
            $checkout_request_id = $stk_push_response->CheckoutRequestID;
            $sql = "INSERT INTO payments (pay_phone_number, pay_amount, pay_checkout_req_id, pay_status) VALUES (?, ?, ?, 'PENDING')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sds", $phone_number, $amount, $checkout_request_id);
            
            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Payment request sent. Please check your phone to complete the transaction.',
                    'checkout_request_id' => $checkout_request_id
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error saving payment details.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to initiate payment. Please try again.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
    
    $conn->close();
?>
                ];
        }*/
    }                ];
        }*/
    }