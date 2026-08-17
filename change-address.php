<?php
/** Change Address. */
require_once __DIR__ . '/config.php';
$saved = [
    ['name'=>'Home','addr'=>'14 Harborline Wharf, Dockside District','icon'=>'bi-house'],
    ['name'=>'Office','addr'=>'22 Market Street, 5th Floor','icon'=>'bi-building'],
    ['name'=>'Met Foodmarkets','addr'=>'9 Old Mill Road','icon'=>'bi-shop'],
];
$active = '';
$pageTitle = 'Change Address';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="checkout.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Change Address</h1>
    <span class="spacer"></span>
</div>

<!-- Map -->
<div style="position:relative;">
    <iframe title="map" src="https://www.openstreetmap.org/export/embed.html?bbox=-0.12%2C51.503%2C-0.08%2C51.515&layer=mapnik&marker=51.509%2C-0.10"
        style="width:100%;height:240px;border:0;filter:grayscale(1) invert(.9) contrast(.9);"></iframe>
    <div class="glass-card p-2 d-inline-flex align-items-center gap-2" style="position:absolute;top:12px;left:12px;">
        <i class="fa-solid fa-crosshair text-primary-2"></i> <span style="font-size:.8rem;">Your Current Location</span>
    </div>
</div>

<div class="px-3 mt-3">
    <div class="search-input mb-3">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Search address">
    </div>

    <h6 class="text-muted-2 text-uppercase" style="font-size:.75rem;letter-spacing:1px;">Saved places</h6>
    <div class="list-group">
        <?php foreach ($saved as $s): ?>
            <a href="checkout.php" class="list-group-item-2">
                <span class="ic"><i class="bi <?= $s['icon'] ?>"></i></span>
                <div><div class="fw-semibold"><?= htmlspecialchars($s['name']) ?></div><small class="text-muted-2"><?= htmlspecialchars($s['addr']) ?></small></div>
                <i class="fa-solid fa-bookmark chev"></i>
            </a>
        <?php endforeach; ?>
    </div>
    <a href="#" class="text-primary-2 d-block text-center mt-3 fw-semibold">Choose a saved place</a>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
