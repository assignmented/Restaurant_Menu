<?php
require_once __DIR__ . '/../config.php';
/* profile/update.php — save profile fields into session user */
$_SESSION['user']['name']    = trim($_POST['name'] ?? $_SESSION['user']['name']);
$_SESSION['user']['email']   = trim($_POST['email'] ?? $_SESSION['user']['email']);
$_SESSION['user']['address'] = trim($_POST['address'] ?? $_SESSION['user']['address']);
$_SESSION['flash'] = 'Profile saved.';
header('Location: ../profile.php');
exit;
