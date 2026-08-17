<?php
/** Onboarding slide 3 of 3 — Live Tracking.
 *  On reaching this final slide we mark onboarding complete (cookie) so the
 *  onboarding flow is never shown again to this visitor.
 */
require_once __DIR__ . '/config.php';
mark_onboarded();   // <-- cookie set: returning visitors will skip onboarding

$chrome = false;
$pageTitle = 'Live Tracking';
$canonical = 'onboard-live-tracking.php';
include __DIR__ . '/includes/header.php';
?>
<div class="onboard-screen">
    <div class="onboard-art">
        <!-- hand holding phone with live map pin -->
        <svg class="art" viewBox="0 0 300 280" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="150" cy="140" r="120" fill="#1a1a1e"/>
            <!-- phone -->
            <rect x="108" y="70" width="84" height="130" rx="16" fill="#010101" stroke="#ffd168" stroke-width="4"/>
            <rect x="120" y="84" width="60" height="84" rx="6" fill="#1a1a1e"/>
            <!-- map grid -->
            <g stroke="#ffd168" stroke-width="1.5" opacity=".5">
                <path d="M120 110h60M120 130h60M140 84v84M160 84v84"/>
            </g>
            <!-- pin -->
            <path d="M150 110c-9 0-16 7-16 16 0 11 16 24 16 24s16-13 16-24c0-9-7-16-16-16z" fill="#ffd168"/>
            <circle cx="150" cy="126" r="5" fill="#010101"/>
            <!-- hand -->
            <path d="M96 200c20 0 26-6 40-6h40c8 0 8 12 0 12h-26c-2 0-2 4 0 4h34c8 0 8 12 0 12h-30c-2 0-2 4 0 4h22c8 0 8 10 0 10h-40c-16 0-26-10-40-10z" fill="#3f2d16"/>
        </svg>
    </div>

    <div class="dots"><span></span><span></span><span class="on"></span></div>
    <h2 class="text-center fw-bold">Live Tracking</h2>
    <p class="text-center text-muted-2 mb-4">Real time tracking of your food on the app once you've placed the order.</p>
    <a href="welcome.php" class="btn-primary-2 text-center">Next</a>
    <div class="home-indicator"></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
