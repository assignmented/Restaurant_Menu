<?php
/** Notifications. */
require_once __DIR__ . '/config.php';
$notifs = [
    ['title'=>'Your order has been delivered','body'=>'Order #BP-2048 from Pizzeria Marino.','time'=>'2 days ago'],
    ['title'=>'Your order has been picked up','body'=>'The rider is on the way. ETA 18 minutes.','time'=>'2 days ago'],
    ['title'=>'Order confirmed','body'=>'Pizzeria Marino is preparing your order.','time'=>'25 Aug 2020'],
    ['title'=>'Promo unlocked','body'=>'You earned 30% off your next order. Enjoy!','time'=>'20 Aug 2020'],
];
$active = '';
$pageTitle = 'Notifications';
    $canonical = 'notifications.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="more.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Notifications</h1>
    <span class="spacer"></span>
</div>

<div class="px-3">
    <div class="list-group">
        <?php foreach ($notifs as $n): ?>
            <div class="list-group-item-2 align-items-start">
                <span class="ic mt-1"><i class="fa-solid fa-bell"></i></span>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between gap-2">
                        <span class="fw-bold"><?= htmlspecialchars($n['title']) ?></span>
                        <small class="text-muted-2" style="font-size:.7rem;white-space:nowrap;"><?= htmlspecialchars($n['time']) ?></small>
                    </div>
                    <small class="text-muted-2"><?= htmlspecialchars($n['body']) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
