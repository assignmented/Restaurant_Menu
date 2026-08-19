<?php
/** Order confirmation — Thank You. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Thank You';
$canonical = 'onboard-live-tracking.php';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage">
    <div class="phone-card p-5 text-center">
        <!-- success illustration -->
        <svg width="180" height="180" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="mb-3" aria-hidden="true">
            <circle cx="100" cy="100" r="90" fill="#0d0d0f" stroke="#ffd168" stroke-width="2" opacity=".4"/>
            <rect x="55" y="70" width="90" height="70" rx="10" fill="#ffd168"/>
            <path d="M75 70v-8a25 25 0 0 1 50 0v8" fill="none" stroke="#ffd168" stroke-width="5"/>
            <path d="M80 105l14 14 28-28" fill="none" stroke="#3f2d16" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="100" cy="100" r="92" fill="none" stroke="#22C55E" stroke-width="4" stroke-dasharray="580" stroke-dashoffset="0" opacity=".6"/>
        </svg>

        <h2 class="fw-bold mb-2">Thank You!</h2>
        <p class="text-muted-2 mb-4">For your order — your order is being processed and we will let you know once it's picked from the outlet. Check the status of your order.</p>

        <?php if (!empty($_SESSION['last_order'])): ?>
            <p class="text-primary-2 fw-bold mb-4">Order <?= htmlspecialchars($_SESSION['last_order']['id']) ?></p>
        <?php endif; ?>

        <a href="order-view.php" class="btn-primary-2 text-center mb-3">View My Order</a>
        <a href="home.php" class="d-block text-muted-2">Back To Home</a>
    </div>
</div>

<?php if (!empty($_SESSION['last_order'])): ?>
    <script>
        setTimeout(function () {
            window.location.href = 'order-view.php';
        }, 3500);
    </script>
<?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
