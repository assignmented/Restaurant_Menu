<?php
/** About Us. */
require_once __DIR__ . '/config.php';
$active = '';
$pageTitle = 'About Us';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="more.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>About Us</h1>
    <span class="spacer"></span>
</div>

<div class="px-3" style="max-width:640px;">
    <h4 class="fw-bold text-primary-2"><?= BRAND_NAME ?></h4>
    <p class="text-muted-2">Discover the best foods from over 1,000 restaurants and fast delivery to your doorstep. We connect hungry people with the kitchens they love — quickly, reliably, and with care.</p>

    <h6 class="fw-bold mt-4">Our Mission</h6>
    <p class="text-muted-2">To make great food accessible to everyone, everywhere. Whether it's a quiet night in or a busy lunch at the office, we bring your favorite meals to you in record time.</p>

    <h6 class="fw-bold mt-4">Why choose us</h6>
    <ul class="text-muted-2">
        <li>1,000+ partner restaurants across the city</li>
        <li>Real-time order tracking from kitchen to door</li>
        <li>Exclusive offers and daily deals</li>
        <li>Secure payments &amp; cash on delivery</li>
    </ul>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
