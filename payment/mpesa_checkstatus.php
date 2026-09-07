<?php
    // mpesa_checkstatus.php

    header('Content-Type: application/json');
    
    // Database connection    
    require_once __DIR__ . '/../config.php';
    
    
    if ($conx->connect_error) {
        die(json_encode(['success' => false, 'message' => "Connection failed: " . $conx->connect_error]));
    }
    
    if (isset($_GET['checkout_request_id'])) {
        $checkout_request_id = $_GET['checkout_request_id'];
        
        $sql = "SELECT pay_status, pay_mpesa_receipt, pay_amount, pay_orderid FROM payments WHERE pay_checkout_req_id = ?";
        $stmt = $conx->prepare($sql);
        $stmt->bind_param("s", $checkout_request_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if ($row['pay_status'] == 'COMPLETED') {
                // Safaricom confirmed — finalize the payment as Paid.
                $sql = "UPDATE payments SET pay_status = 'Paid' WHERE pay_checkout_req_id = ?";
                $stmt = $conx->prepare($sql);
                $stmt->bind_param("s", $checkout_request_id);
                if (!$stmt->execute()) {
                    error_log('mpesa_checkstatus: failed to set pay_status=Paid for ' . $checkout_request_id . ': ' . $stmt->error);
                }

                $order_id = (int) $row['pay_orderid'];

                $sql = "UPDATE orders SET order_status = 'Pending' WHERE order_id = ?";
                $stmt = $conx->prepare($sql);
                $stmt->bind_param("i", $order_id);
                if (!$stmt->execute()) {
                    error_log('mpesa_checkstatus: failed to set order_status=Pending for ' . $order_id . ': ' . $stmt->error);
                }

                // Order is live — create a kitchen ticket so prep can begin.
                // pay_orderid came from the SELECT above; only kitchen_orderid
                // is required here — station/status/timestamps default on the
                // table ('Main Kitchen', 'New', now()).
                $sql = "INSERT INTO kitchen_tickets (kitchen_orderid) VALUES (?)";
                $stmt = $conx->prepare($sql);
                $stmt->bind_param("i", $order_id);
                if (!$stmt->execute()) {
                    error_log('mpesa_checkstatus: failed to insert kitchen ticket for order ' . $order_id . ': ' . $stmt->error);
                    // Payment already succeeded — log only, don't fail the response.
                }
                
                echo json_encode([
                    'success' => true,
                    'status' => 'COMPLETED',
                    'message' => 'Payment completed successfully',
                    'mpesa_receipt' => $row['pay_mpesa_receipt'],
                    'amount' => $row['pay_amount']
                ]);
                $_SESSION['pay_mpesa_receipt'] = $row['pay_mpesa_receipt'];
                $_SESSION['pay_amount'] = $row['pay_amount'];
            } elseif ($row['pay_status'] == 'FAILED') {
                echo json_encode([
                    'success' => false,
                    'status' => 'FAILED',
                    'message' => 'Payment failed'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'status' => 'PENDING',
                    'message' => 'Payment is still pending'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Transaction not found'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Missing checkout_request_id parameter'
        ]);
    }
    
    $conx->close();
    exit;