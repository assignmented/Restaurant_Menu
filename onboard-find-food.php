<?php
/** Onboarding slide 1 of 3 — Find Food You Love. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Find Food You Love';
$canonical = 'onboard-find-food.php';
include __DIR__ . '/includes/header.php';
?>
<div class="onboard-screen">
    <div class="onboard-art">
        <!-- bag of food + clock illustration -->
        <svg class="art" viewBox="0 0 300 280" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="150" cy="140" r="120" fill="#1a1a1e"/>
            <g stroke="#ffd168" stroke-width="2" opacity=".4">
                <path d="M40 40l10 10M260 50l-10 10M50 240l10-10M250 230l-10-10"/>
            </g>
            <!-- bag -->
            <path d="M95 110h110l-10 120H105z" fill="#ffd168"/>
            <path d="M115 110v-8a35 30 0 0 1 70 0v8" fill="none" stroke="#ffd168" stroke-width="6"/>
            <rect x="125" y="140" width="50" height="40" rx="8" fill="#3f2d16"/>
            <!-- clock -->
            <circle cx="190" cy="120" r="30" fill="#010101" stroke="#fff" stroke-width="4"/>
            <path d="M190 120v-14M190 120l10 6" stroke="#ffd168" stroke-width="3" stroke-linecap="round"/>
            <text x="150" y="172" font-size="22" text-anchor="middle" fill="#3f2d16" font-family="Poppins">🍔</text>
        </svg>
    </div>

    <div class="dots"><span class="on"></span><span></span><span></span></div>
    <h2 class="text-center fw-bold">Find Food You Love</h2>
    <p class="text-center text-muted-2 mb-4">Discover the best foods from our curated selection and fast delivery to your doorstep.</p>
    <a href="onboard-fast-delivery.php" class="btn-primary-2 text-center">Next</a>
    <div class="home-indicator"></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
