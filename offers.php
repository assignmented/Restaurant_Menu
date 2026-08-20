<?php
/** Latest Offers. */
require_once __DIR__ . '/config.php';
$rests = restaurants();
$active = 'offers';
$pageTitle = 'Latest Offers';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="home.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Latest Offers</h1>
    <span class="spacer"></span>
    <a href="cart.php" class="btn-icon position-relative" aria-label="Cart">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (cart_count() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
        <?php endif; ?>
    </a>
</div>

<div class="px-3">
    <p class="text-muted-2 mb-3">Find discounts, offers, special meals and more!</p>

    <a href="#" class="d-block mb-4 p-4 text-center fw-bold" style="background:var(--bp-primary); color:var(--bp-dark); border-radius:20px;">
        <i class="fa-solid fa-percent me-2"></i> Check Offers
    </a>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <?php foreach ($rests as $r): ?>
            <div class="col">
                <a href="product.php?id=<?= $r['id']+100 ?>" class="rest-card d-block">
                    <img src="<?= $r['img'] ?>" class="thumb" alt="<?= htmlspecialchars($r['name']) ?>" loading="lazy">
                    <div class="body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($r['name']) ?></h6>
                            <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= $r['rating'] ?></span>
                        </div>
                        <div class="mt-2">
                            <?php foreach ($r['cuisine'] as $t): ?><span class="tag-chip"><?= $t ?></span><?php endforeach; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pb-4"></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
