<?php
/** Inbox. */
require_once __DIR__ . '/config.php';
$messages = [
    ['title'=>'MealMonkey Promotions','preview'=>'Get 30% off your next three orders. Tap to claim your promo code before it expires this weekend!','date'=>'25 Aug 2020','icon'=>'bi-megaphone'],
    ['title'=>'Order Delivered','preview'=>'Your order from Pizzeria Marino has been delivered. Rate your experience to earn reward points.','date'=>'22 Aug 2020','icon'=>'bi-bag-check'],
    ['title'=>'New on The Black Perch','preview'=>'Discover 40 new restaurants now delivering to your area. Fresh cuisines added weekly.','date'=>'18 Aug 2020','icon'=>'bi-stars'],
    ['title'=>'MealMonkey Promotions','preview'=>'Refer a friend and you both get KSh. 5 off. Share your code today.','date'=>'10 Aug 2020','icon'=>'bi-megaphone'],
];
$active = '';
$pageTitle = 'Inbox';
    $canonical = 'inbox.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="more.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Inbox</h1>
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
        <?php foreach ($messages as $m): ?>
            <a href="#" class="list-group-item-2 align-items-start">
                <span class="ic mt-1"><i class="bi <?= $m['icon'] ?>"></i></span>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold"><?= htmlspecialchars($m['title']) ?></span>
                        <small class="text-muted-2" style="font-size:.7rem;white-space:nowrap;"><?= htmlspecialchars($m['date']) ?></small>
                    </div>
                    <small class="text-muted-2" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= htmlspecialchars($m['preview']) ?></small>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
