<?php
/** Add Card. */
require_once __DIR__ . '/config.php';
$active = '';
$pageTitle = 'Add Card';
    $canonical = 'add-card.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="payment-details.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Payment Details</h1>
    <span class="spacer"></span>
    <a href="payment-details.php" class="btn-icon" aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
</div>

<div class="px-3">
    <p class="text-muted-2 mb-4">Customize your payment method</p>

    <form action="#" method="post">
        <div class="mb-3">
            <label class="form-label-2">Card Number</label>
            <input type="text" class="form-control-2" name="card" placeholder="0000 0000 0000 0000" inputmode="numeric">
        </div>
        <div class="row g-3 mb-3">
            <div class="col-6"><label class="form-label-2">Expiry (MM)</label><input type="text" class="form-control-2" name="mm" placeholder="MM" maxlength="2"></div>
            <div class="col-6"><label class="form-label-2">(YY)</label><input type="text" class="form-control-2" name="yy" placeholder="YY" maxlength="2"></div>
        </div>
        <div class="mb-3">
            <label class="form-label-2">Security Code</label>
            <input type="text" class="form-control-2" name="cvv" placeholder="CVV" maxlength="4" inputmode="numeric">
        </div>
        <div class="row g-3 mb-3">
            <div class="col-6"><label class="form-label-2">First Name</label><input type="text" class="form-control-2" name="first" placeholder="John"></div>
            <div class="col-6"><label class="form-label-2">Last Name</label><input type="text" class="form-control-2" name="last" placeholder="Doe"></div>
        </div>
        <p class="text-muted-2" style="font-size:.8rem;">You can remove this card at any time.</p>
        <button type="submit" class="btn-primary-2 mt-2"><i class="fa-solid fa-plus me-1"></i> Add Card</button>
    </form>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
