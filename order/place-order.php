<?php
require_once __DIR__ . '/../config.php';
/* order/place-order.php — clear cart, redirect to confirmation */
$_SESSION['last_order'] = ['total'=>cart_total(), 'id'=>'BP-'.rand(1000,9999)];
$_SESSION['cart'] = [];
header('Location: ../order-confirmation.php');
exit;
