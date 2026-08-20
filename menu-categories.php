art.php<?php
/** Menu Categories — slide-out category menu.
 *  Implemented as a Bootstrap offcanvas that opens on load, with the same
 *  content also rendered as a static fallback list. */
require_once __DIR__ . '/config.php';
$cats = categories();
$active = 'menu';
$pageTitle = 'Menu';
$canonical = 'menu-categories.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="home.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Categories</h1>
    <span class="spacer"></span>
    <a href="cart.php" class="btn-icon position-relative" aria-label="Cart">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (cart_count() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
        <?php endif; ?>
    </a>
</div>

<div class="px-3" style="padding-bottom:4rem;">
    <p class="text-muted-2">Browse the menu by category</p>
    <div class="list-group">
        <?php 
            $subcat_sql = "SELECT * FROM subcategories WHERE subcat_status = '1' ORDER BY subcat_name ASC";
            $subcat_query = mysqli_query($conx, $subcat_sql);
            while($subcat_result = $subcat_query->fetch_assoc()): ?>
            <a href="category.php?type=<?= $subcat_result['subcat_name']; ?>&id=<?= $subcat_result['subcat_id']; ?>" class="list-group-item-2">
                <span class="ic"><i class="fa-solid <?= $subcat_result['subcat_image'] ?>"></i></span>
                <div>
                    <div class="fw-semibold"><?= htmlspecialchars($subcat_result['subcat_name']) ?></div>
                    <small class="text-muted-2">Food · <?= $subcat_result['subcat_count'] ?> items</small>
                </div>
                <i class="fa-solid fa-chevron-right chev"></i>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<!-- Offcanvas version (auto-opens on first load via JS) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="catCanvas" style="background:var(--bp-card); color:#fff; width:300px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title">Categories</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <?php foreach ($cats as $c): ?>
            <a href="category.php?type=<?= $c['slug'] ?>" class="list-group-item-2">
                <span class="ic"><i class="bi <?= $c['icon'] ?>"></i></span>
                <div><div class="fw-semibold"><?= htmlspecialchars($c['name']) ?></div><small class="text-muted-2"><?= $c['count'] ?> items</small></div>
                <i class="fa-solid fa-chevron-right chev"></i>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<script>
    // Open the slide-out on desktop; static list suffices on mobile.
    if (window.innerWidth >= 992) {
        var oc = bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('catCanvas'));
        oc.show();
    }
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
