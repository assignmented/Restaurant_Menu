<?php
    // mpesa_callback.php
    require_once __DIR__ . '/../config.php';
    
    // Database connection
    $conn = new mysqli($local_host, $local_root, $local_pass, $local_data);

    function logMessage($message) {
        $logFile = __DIR__ . '/transaction_log.txt';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
    }

    if ($conn->connect_error) {
        logMessage("DB connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the response from M-Pesa
    $mpesa_response = file_get_contents('php://input');
    $callbackContent = json_decode($mpesa_response);
    logMessage("Received callback: " . $mpesa_response);

    if ($callbackContent === null && json_last_error() !== JSON_ERROR_NONE) {
        logMessage("Invalid JSON in callback body: " . json_last_error_msg());
    }

    // Check if the callback content is valid
    if (isset($callbackContent->Body->stkCallback->ResultCode)) {
        $result_code = $callbackContent->Body->stkCallback->ResultCode;
        $checkout_request_id = $callbackContent->Body->stkCallback->CheckoutRequestID;

        if ($result_code == 0) {
            // Payment successful
            $status = 'COMPLETED';
            $mpesa_receipt_number = $callbackContent->Body->stkCallback->CallbackMetadata->Item[1]->Value ?? null;

            if ($mpesa_receipt_number === null) {
                logMessage("Payment marked successful but no receipt number found in callback metadata: CheckoutRequestID: $checkout_request_id");
            } else {
                logMessage("Payment successful: CheckoutRequestID: $checkout_request_id, M-Pesa Receipt: $mpesa_receipt_number");
            }
        } else {
            // Payment failed
            $status = 'FAILED';
            $mpesa_receipt_number = null;
            $result_desc = $callbackContent->Body->stkCallback->ResultDesc ?? 'No description provided';
            logMessage("Payment failed: CheckoutRequestID: $checkout_request_id, Result Code: $result_code, Reason: $result_desc");
        }

        // Update the payment status in the database
        $sql = "UPDATE payments SET pay_status = ?, pay_mpesa_receipt = ? WHERE pay_checkout_req_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            logMessage("Failed to prepare UPDATE statement: " . $conn->error);
        } else {
            $stmt->bind_param("sss", $status, $mpesa_receipt_number, $checkout_request_id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows === 0) {
                    // Query succeeded but matched no row — usually means the
                    // checkout_request_id doesn't exist, which is worth its own log line.
                    logMessage("No matching payment row for CheckoutRequestID: $checkout_request_id (0 rows affected)");
                } else {
                    logMessage("Payment status updated in database: $checkout_request_id - $status");
                }
            } else {
                logMessage("Error updating payment status: " . $stmt->error);
            }
        }
    } else {
        logMessage("Invalid callback content received: " . $mpesa_response);
    }

    $conn->close();

    // Respond to M-Pesa
    $response = array(
        'ResultCode' => 0,
        'ResultDesc' => 'Confirmation received successfully'
    );
    header('Content-Type: application/json');
    echo json_encode($response);