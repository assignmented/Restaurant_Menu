<?php
require_once __DIR__ . '/../config.php';
/* payment/add-card-process.php — placeholder; just return to payment details */
$_SESSION['flash'] = 'Card added.';
header('Location: ../payment-details.php');
exit;
