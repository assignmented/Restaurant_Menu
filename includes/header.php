<?php
/** Shared <head> + opening body + optional desktop topnav/sidebar.
 *  Vars (all optional):
 *    $pageTitle  string
 *    $active     string  (home|offers|profile|more) — highlights nav
 *    $chrome     bool    default true. false = no nav (splash/onboard/auth)
 *    $sidebar    bool    default true on lg when chrome on
 */
require_once __DIR__ . '/../config.php';
$pageTitle = ($pageTitle ?? BRAND_NAME) . ' · ' . BRAND_TAGLINE;
$active    = $active ?? '';
$chrome    = $chrome ?? true;
$sidebar   = $sidebar ?? true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="theme-color" content="#010101">
    <?php include __DIR__ . '/seo.php'; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/black_perch.png">
    <link rel="apple-touch-icon" href="assets/img/black_perch.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>
<?php if ($chrome): ?>
    <!-- Desktop top nav -->
    <div class="bp-topnav">
        <?php $size='sm'; include __DIR__ . '/logo.php'; ?>
        <nav class="links">
            <a href="home.php" class="<?= $active==='home'?'active':'' ?>">Home</a>
            <a href="offers.php" class="<?= $active==='offers'?'active':'' ?>">Offers</a>
            <a href="cart.php" class="<?= $active==='cart'?'active':'' ?>">Cart</a>
            <a href="profile.php" class="<?= $active==='profile'?'active':'' ?>">Profile</a>
            <a href="more.php" class="<?= $active==='more'?'active':'' ?>">More</a>
        </nav>
        <span class="spacer"></span>
        <a href="cart.php" class="btn-icon position-relative" aria-label="Cart">
            <i class="fa-solid fa-bag-shopping"></i>
            <?php if (cart_count() > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
            <?php endif; ?>
        </a>
    </div>

    <?php if ($sidebar): ?>
    <div class="app-shell" style="background-image: url('assets/img/startup.png'); background-repeat: repeat;height: auto;">
        <aside class="bp-sidebar">
            <?php $size='sm'; include __DIR__ . '/logo.php'; ?>
            <div class="mt-4 d-flex flex-column gap-1">
                <a href="home.php" class="side-link <?= $active==='home'?'active':'' ?>"><i class="fa-solid fa-house"></i> Home</a>
                <a href="offers.php" class="side-link <?= $active==='offers'?'active':'' ?>"><i class="fa-solid fa-tag"></i> Offers</a>
                <a href="cart.php" class="side-link <?= $active==='cart'?'active':'' ?>"><i class="fa-solid fa-bag-shopping"></i> Cart</a>
                <a href="profile.php" class="side-link <?= $active==='profile'?'active':'' ?>"><i class="fa-solid fa-user"></i> Profile</a>
                <a href="more.php" class="side-link <?= $active==='more'?'active':'' ?>"><i class="fa-solid fa-table-cells"></i> More</a>
            </div>
        </aside>
        <main class="app-main">
    <?php endif; ?>
<?php endif; ?>
