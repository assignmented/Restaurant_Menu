<?php
require_once __DIR__ . '/../config.php';
/* cart/update.php — change quantity (?id=&qty=) or remove (?remove=id) */
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qty = max(1, (int)($_GET['qty'] ?? 1));
    if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['qty'] = $qty;
}
header('Location: ../my-order.php');
exit;
