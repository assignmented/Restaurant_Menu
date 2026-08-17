<?php
/** Order Tracking — live tracking. */
require_once __DIR__ . '/config.php';
$active = '';
$pageTitle = 'Track Order';
$canonical = 'order-tracking.php';
include __DIR__ . '/includes/header.php';
?>
<div style="position:relative; min-height:100vh;">
    <!-- Map background -->
    <iframe title="tracking map" src="https://www.openstreetmap.org/export/embed.html?bbox=-0.13%2C51.502%2C-0.07%2C51.516&layer=mapnik"
        style="width:100%;height:100vh;border:0;filter:grayscale(1) invert(.9) contrast(.9); position:absolute; inset:0;"></iframe>

    <!-- Rider icon -->
    <div style="position:absolute; top:42%; left:50%; transform:translate(-50%,-50%); z-index:3;">
        <span class="btn-icon" style="width:48px;height:48px;background:var(--bp-primary);color:var(--bp-dark);font-size:1.3rem;"><i class="fa-solid fa-bicycle"></i></span>
    </div>

    <!-- Back -->
    <a href="home.php" class="btn-icon" style="position:absolute; top:1rem; left:1rem; z-index:5;" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>

    <!-- Bottom sheet -->
    <div class="show-lg" style="position:fixed; left:0; right:0; bottom:0; z-index:4;">
        <div class="glass-card m-2 p-3" style="border-radius:24px;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=120&q=80" style="width:52px;height:52px;border-radius:50%;object-fit:cover;" alt="">
                <div class="flex-grow-1">
                    <div class="fw-bold">Sam Perera</div>
                    <small class="text-muted-2">Your rider · ETA 12 min</small>
                </div>
                <a href="tel:+15550142780" class="btn-icon" aria-label="Call rider"><i class="fa-solid fa-phone text-primary-2"></i></a>
            </div>

            <!-- progress stepper -->
            <div class="d-flex justify-content-between position-relative mb-2" style="--bs-gutter-x:0;">
                <div style="height:3px;background:var(--bp-line);position:absolute;left:8%;right:8%;top:8px;z-index:0;"></div>
                <div style="height:3px;background:var(--bp-primary);position:absolute;left:8%;width:60%;top:8px;z-index:1;"></div>
                <?php
                $steps = [['Preparing','bi-bag'],['Picked Up','bi-box-seam'],['On the way','bi-bicycle'],['Delivered','bi-check-circle']];
                foreach ($steps as $i=>$s): ?>
                    <div class="text-center" style="flex:1; position:relative; z-index:2;">
                        <span class="btn-icon <?= $i<=2?'':'' ?>" style="width:28px;height:28px;font-size:.8rem; <?= $i<=2?'background:var(--bp-primary);color:var(--bp-dark);border:0;':'' ?>"><i class="bi <?= $s[1] ?>"></i></span>
                        <small class="d-block mt-1 <?= $i<=2?'text-primary-2':'text-muted-2' ?>" style="font-size:.65rem;"><?= $s[0] ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
