<?php
/** Checkout. */
require_once __DIR__ . '/config.php';
$user = current_user();
$cart = cart();
// Honor the dining + rider choices made on my-order.php (session, with a
// query-string override from the Checkout link). Eat-in = no delivery fee;
// take-away + "I have a rider" = no fee; take-away + "Send your rider" = fee.
// No discount on either selection.
$dining = $_GET['dining'] ?? ($_SESSION['dining'] ?? 'takeaway');
if (!in_array($dining, ['eat_in', 'takeaway'], true)) {
    $dining = 'takeaway';
}
$_SESSION['dining'] = $dining;

$rider = $_GET['rider'] ?? ($_SESSION['rider'] ?? 'send');
if (!in_array($rider, ['own', 'send'], true)) {
    $rider = 'send';
}
$_SESSION['rider'] = $rider;

if ($dining === 'eat_in') {
    $delivery = 0.00;
} else {
    $delivery = ($rider === 'own') ? 0.00 : 2.50;
}
$sub = cart_total();
$total = $sub + $delivery;

// Delivery address to show: the map-picked address for "Send your rider"
// orders, otherwise the user's saved address.
$deliveryAddr = $user['user_address'] ?? '';
$changeAddrHref = 'change-address.php';
if ($dining === 'takeaway' && $rider === 'send' && !empty($_SESSION['delivery_address']['address'])) {
    $deliveryAddr = $_SESSION['delivery_address']['address'];
    $changeAddrHref = 'add-delivery-location.php?dining=takeaway&rider=send';
}

$active = 'cart';
$pageTitle = 'Checkout';
$canonical = 'checkout.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="my-order.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Checkout</h1>
    <span class="spacer"></span>
</div>

<style>
    .payment-option{display:flex;align-items:center;gap:.75rem;padding:.7rem .8rem;border:1px solid var(--bp-line);
        border-radius:14px;margin-bottom:.5rem;cursor:pointer;transition:border-color .2s ease,background .2s ease;background:var(--bp-card);}
    .payment-option:last-child{margin-bottom:0;}
    .payment-option input{position:absolute;opacity:0;pointer-events:none;width:0;height:0;}
    .payment-option:hover{border-color:var(--bp-primary);}
    .payment-option:has(input:checked){border-color:var(--bp-primary);background:rgba(255,209,104,.08);}
    .payment-option .po-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;
        background:var(--bp-card-2);font-size:1.1rem;flex:0 0 auto;}
    .payment-option .po-body{flex:1;min-width:0;}
    .payment-option .po-title{display:block;font-weight:600;color:#fff;font-size:.92rem;}
    .payment-option .po-sub{display:block;color:var(--bp-muted);font-size:.72rem;}
    .payment-option .po-brand{flex:0 0 auto;font-size:.62rem;font-weight:700;color:#fff;padding:.25rem .5rem;border-radius:5px;letter-spacing:.03em;}
    .payment-option.is-disabled{opacity:.5;cursor:not-allowed;}
    .payment-option.is-disabled:hover{border-color:var(--bp-line);}
    .payment-option.is-disabled:has(input:checked){border-color:var(--bp-line);background:var(--bp-card);}
    .po-extra{margin:0 0 .6rem .25rem;padding-left:3.5rem;}
    .po-field-label{display:block;font-size:.72rem;color:var(--bp-muted);margin-bottom:.35rem;}
</style>
<div class="px-3">
    <?php if ($dining === 'takeaway' && $rider === 'send'): ?>
    <!-- Delivery address (only needed when the restaurant sends a rider) -->
    <div class="glass-card p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h6 class="fw-bold mb-0">Delivery address</h6>
            <a href="<?= $changeAddrHref ?>" style="font-size:.85rem;">Change</a>
        </div>
        <p class="text-muted-2 mb-0"><?= htmlspecialchars($deliveryAddr) ?></p>
    </div>
    <?php endif; ?>

    <!-- Payment method -->
    <form action="payment/mpesa_stkpush.php" method="post">
        <div class="glass-card p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Payment method</h6>
                <a href="add-card.php" style="font-size:.85rem;">+ Add Card</a>
            </div>

            <label class="payment-option">
                <input type="radio" name="payment" value="mpesa" checked>
                <span class="po-icon" style="color:#33b541;"><i class="fa-solid fa-mobile-screen-button"></i></span>
                <span class="po-body">
                    <span class="po-title">M-Pesa</span>
                    <span class="po-sub">STK push to your phone</span>
                </span>
                <span class="po-brand" style="background:#33b541;">M-PESA</span>
            </label>
            <div class="po-extra" id="mpesaPhoneWrap" hidden>
                <label class="po-field-label" for="mpesaPhone">M-Pesa phone number</label>
                <input type="tel" id="mpesaPhone" name="mpesa_phone" class="form-control-2" placeholder="07xx xxx xxx" inputmode="tel" autocomplete="tel">
            </div>

            <label class="payment-option">
                <input type="radio" name="payment" value="visa">
                <span class="po-icon"><i class="fa-solid fa-credit-card"></i></span>
                <span class="po-body">
                    <span class="po-title">Visa</span>
                    <span class="po-sub">Coming soon</span>
                </span>
                <span class="po-brand" style="background:#1a1a72;">VISA</span>
            </label>

            <label class="payment-option is-disabled">
                <input type="radio" name="payment" value="paypal" disabled>
                <span class="po-icon" style="color:#169bd7;"><i class="fa-brands fa-paypal"></i></span>
                <span class="po-body">
                    <span class="po-title">PayPal</span>
                    <span class="po-sub">Coming soon</span>
                </span>
                <span class="po-brand" style="background:#003087;">PayPal</span>
            </label>
        </div>

        <!-- Order summary -->
        <div class="glass-card p-3 mb-3">
            <?php foreach ($cart as $item): ?>
                <div class="d-flex justify-content-between text-muted-2 mb-2">
                    <span><?= htmlspecialchars($item['name']) ?> x<?= (int)$item['qty'] ?></span>
                    <span>KSh. <?= number_format($item['price']*$item['qty'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="divider-line"></div>
            <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Sub Total</span><span>KSh. <?= number_format($sub, 2) ?></span></div>
            <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Dining</span><span><?= $dining === 'eat_in' ? 'Eat-in' : ('Take Away · ' . ($rider === 'own' ? 'I have a rider' : 'Send your rider')) ?></span></div>
            <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Delivery Cost</span><span>KSh. <?= number_format($delivery, 2) ?></span></div>
            <div class="d-flex justify-content-between fw-bold"><span>Total</span><span class="text-primary-2">KSh. <?= number_format($total, 2) ?></span></div>
        </div>

        <button type="submit" class="btn-primary-2 text-center">Send Order</button>
    </form>
</div>
<div class="pb-4"></div>
<script>
(function () {
    var wrap = document.getElementById('mpesaPhoneWrap');
    if (!wrap) return;
    var radios = document.querySelectorAll('input[name="payment"]');
    function sync() {
        var sel = document.querySelector('input[name="payment"]:checked');
        wrap.hidden = !(sel && sel.value === 'mpesa');
    }
    radios.forEach(function (r) { r.addEventListener('change', sync); });
    sync();
})();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>
