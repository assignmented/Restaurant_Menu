<?php
require_once __DIR__ . '/../config.php';
/* cart/add.php — add (or increment) an item in $_SESSION['cart'] */
$id = $_POST['id'] ?? '';
if ($id !== '') {
    $qty = max(1, (int)($_POST['qty'] ?? 1));
    $name = $_POST['name'] ?? 'Item';
    $price = (float)($_POST['price'] ?? 0);
    $img = $_POST['img'] ?? '';
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$id] = compact('id','name','price','img','qty');
    }
}
header('Location: ../cart.php');
exit;
