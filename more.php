<?php
/** More / settings menu. */
require_once __DIR__ . '/config.php';
$active = 'more';
$pageTitle = 'More';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <h1>More</h1>
    <span class="spacer"></span>
    <a href="cart.php" class="btn-icon position-relative" aria-label="Cart">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (cart_count() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
        <?php endif; ?>
    </a>
</div>

<div class="px-3">
    <div class="list-group">
        <a href="payment-details.php" class="list-group-item-2">
            <span class="ic"><i class="fa-solid fa-credit-card"></i></span>
            <div class="fw-semibold">Payment Details</div>
            <i class="fa-solid fa-chevron-right chev"></i>
        </a>
        <a href="cart.php" class="list-group-item-2">
            <span class="ic"><i class="fa-solid fa-bag-shopping"></i></span>
            <div class="fw-semibold">My Orders</div>
            <i class="fa-solid fa-chevron-right chev"></i>
        </a>
        <a href="notifications.php" class="list-group-item-2">
            <span class="ic"><i class="fa-solid fa-bell"></i></span>
            <div class="fw-semibold">Notifications</div>
            <span class="badge-notif">3</span>
        </a>
        <a href="inbox.php" class="list-group-item-2">
            <span class="ic"><i class="fa-solid fa-comment-dots"></i></span>
            <div class="fw-semibold">Inbox</div>
            <i class="fa-solid fa-chevron-right chev"></i>
        </a>
        <a href="about.php" class="list-group-item-2">
            <span class="ic"><i class="fa-solid fa-circle-info"></i></span>
            <div class="fw-semibold">About Us</div>
            <i class="fa-solid fa-chevron-right chev"></i>
        </a>
    </div>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
