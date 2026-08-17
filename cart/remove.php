<?php
require_once __DIR__ . '/../config.php';
/* cart/remove.php — drop an item */
if (isset($_GET['id'])) unset($_SESSION['cart'][$_GET['id']]);
header('Location: ../my-order.php');
exit;
