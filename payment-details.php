<?php
/** Payment Details. */
require_once __DIR__ . '/config.php';
$active = '';
$pageTitle = 'Payment Details';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="more.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Payment Details</h1>
    <span class="spacer"></span>
</div>

<div class="px-3">
    <p class="text-muted-2 mb-3">Customize your payment method</p>

    <div class="glass-card p-3 mb-3 d-flex align-items-center gap-3">
        <span class="ic" style="width:38px;height:38px;border-radius:10px;background:var(--bp-card-2);display:flex;align-items:center;justify-content:center;color:var(--bp-green)"><i class="fa-solid fa-circle-check"></i></span>
        <div class="flex-grow-1"><div class="fw-semibold">Cash / Card on delivery</div></div>
    </div>

    <div class="glass-card p-3 mb-4 d-flex align-items-center gap-3">
        <span style="width:46px;height:30px;background:#1a1a72;border-radius:5px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.7rem;">VISA</span>
        <div class="flex-grow-1">
            <div class="fw-semibold">•••• •••• •••• 2187</div>
        </div>
        <a href="#" class="text-primary-2" style="font-size:.85rem;">Remove Card</a>
    </div>

    <h6 class="text-muted-2 text-uppercase" style="font-size:.75rem;letter-spacing:1px;">Other Methods</h6>
    <a href="add-card.php" class="btn-outline-primary-2 text-center mt-2"><i class="fa-solid fa-plus me-1"></i> Add Another Credit/Debit Card</a>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
