  <?php
        $env = parse_ini_file('.env');

        $consumer_key = $env["SECURE_CK"];
        $consumer_secret = $env["SECURE_CS"];
        $business_short_code = '6205829'; //Store Number
        $passkey = $env["SECURE_PK"];
        $callback_url = 'https://gida.tronsart.com/includes/mpesa_callback.php';
        
        // ================== STEP 1: ACCESS TOKEN ==================
        
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
        
        $access_token = getAccessToken($consumer_key, $consumer_secret);
    
        // Initiate STK Push
        $stk_push_response = initiateSTKPush($access_token, $business_short_code, $passkey, $amount, $phone_number, $callback_url);
        
        
        if ($stk_push_response->ResponseCode === "0") {
            // Payment request successful, save to database
            $checkout_request_id = $stk_push_response->CheckoutRequestID;
            $merchant_request_id = $stk_push_response->MerchantRequestID;
            $status = "0";
            
            $sql = "INSERT INTO house_transactions(hst_userid ,hst_phone, tran_amount, tran_status, CheckoutRequestId, MerchantRequestID) VALUES (?, ?, ?, ? , ? , ?)";
            $stmt = $conx->prepare($sql);
            $stmt->bind_param("ssssss",$subscriptionUser, $phone_number, $amount, $status,$checkout_request_id,$merchant_request_id);
            
            $checkout_request_idX = mb_convert_encoding(base64_encode($checkout_request_id), 'UTF-8');
            
            if ($stmt->execute()) {
                $response = [
                                'success' => "success",
                                'message' => "Payment request sent. Please check your phone.",
                                'value' => $checkout_request_idX
                            ];
            } else {
                $response = [
                                'success' => "failed",
                                'message' => "Error saving payment details.",
                                'value' => '0'
                            ];
            }
        } else {
            $response = [
                            'success' => "failed",
                            'message' => "Failed to initiate payment. Please try again",
                            'value' => '0'
                        ];
        }