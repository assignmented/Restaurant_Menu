<?php
/** Onboarding slide 2 of 3 — Fast Delivery. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Fast Delivery';
$canonical = 'onboard-fast-delivery.php';
include __DIR__ . '/includes/header.php';
?>
<div class="onboard-screen">
    <div class="onboard-art">
        <!-- delivery rider on scooter -->
        <svg class="art" viewBox="0 0 300 280" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="150" cy="140" r="120" fill="#1a1a1e"/>
            <path d="M70 210h160" stroke="#ffd168" stroke-width="3" opacity=".3" stroke-dasharray="6 8"/>
            <!-- scooter body -->
            <path d="M90 200c0-14 12-24 26-24h60c20 0 34 12 40 28" fill="none" stroke="#ffd168" stroke-width="8" stroke-linecap="round"/>
            <circle cx="100" cy="210" r="22" fill="#010101" stroke="#ffd168" stroke-width="6"/>
            <circle cx="100" cy="210" r="6" fill="#ffd168"/>
            <circle cx="200" cy="210" r="22" fill="#010101" stroke="#ffd168" stroke-width="6"/>
            <circle cx="200" cy="210" r="6" fill="#ffd168"/>
            <!-- rider -->
            <circle cx="150" cy="150" r="16" fill="#ffd168"/>
            <path d="M150 166v34M134 180l16 8 16-8" stroke="#ffd168" stroke-width="6" stroke-linecap="round" fill="none"/>
            <rect x="135" y="120" width="30" height="14" rx="7" fill="#3f2d16"/>
            <!-- delivery bag -->
            <rect x="168" y="150" width="26" height="30" rx="5" fill="#3f2d16"/>
            <path d="M174 150v-6a6 6 0 0 1 12 0v6" fill="none" stroke="#3f2d16" stroke-width="3"/>
        </svg>
    </div>

    <div class="dots"><span></span><span class="on"></span><span></span></div>
    <h2 class="text-center fw-bold">Fast Delivery</h2>
    <p class="text-center text-muted-2 mb-4">Fast food delivery to your home, office wherever you are.</p>
    <a href="onboard-live-tracking.php" class="btn-primary-2 text-center">Next</a>
    <div class="home-indicator"></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
