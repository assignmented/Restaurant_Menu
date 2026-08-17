<?php
/** Welcome screen — shown after onboarding. Single call-to-action into the app. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Welcome';
$canonical = 'welcome.php';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage"  style="background-image: url('assets/img/startup.png')">
    <div class="phone-card">
        <!-- Orange hero panel -->
        <div class="welcome-hero">
            <div style="position:relative; z-index:1;">
                <img src="assets/img/black_perch.png" alt="<?= BRAND_NAME ?>" class="bp-logo-img bp-logo-img-lg" style="margin:0 auto;">
            </div>
        </div>

        <!-- Body -->
        <div class="p-4">
            <h4 class="text-center fw-bold mb-3" style="line-height:1.35;">
                Discover the best foods from our curated selection and fast delivery to your doorstep
            </h4>
            <div class="d-grid gap-3 mt-4">
                <a href="home.php" class="btn-primary-2 text-center">Get Started</a>
            </div>
            <p class="text-center text-muted-2 mt-4 mb-0" style="font-size:.8rem;">
                By continuing you agree to our <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>.
            </p>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
