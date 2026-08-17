<?php
/** My Order / cart summary. */
require_once __DIR__ . '/config.php';
$cart = cart();
// seed a sample item if cart is empty so the screen isn't blank on first visit
/*if (!$cart) {
    $sample = products()[0];
    $_SESSION['cart'][$sample['id']] = [
        'id'=>$sample['id'],'name'=>$sample['name'],'price'=>$sample['price'],'img'=>$sample['img'],'qty'=>1
    ];
    $cart = cart();
}*/
// Dining choice: eat-in (no delivery fee) vs take-away. Under take-away, the
// rider sub-choice decides the fee: "I have a rider" = no fee (customer's own
// rider), "Send your rider" = the delivery fee applies. No discount on either.
// Persisted in session so it survives the +/- qty reloads (cart/update.php).
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
// "Send your rider" needs a delivery address first; everything else goes
// straight to checkout. dining/rider are passed along so the next step keeps
// the selection in sync.
$checkoutHref = ($dining === 'takeaway' && $rider === 'send')
    ? 'add-delivery-location.php?dining=takeaway&rider=send'
    : 'checkout.php?dining=' . $dining . '&rider=' . $rider;
$active = 'cart';
$pageTitle = 'My Order';
$canonical = 'my-order.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="home.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>My Order</h1>
    <span class="spacer"></span>
</div>

<div class="px-3" style="padding-bottom: 3rem;">
    <!-- Restaurant header -->
    <!-- Items -->
    <div class="glass-card p-3 mb-3">
        <?php foreach ($cart as $item): ?>
            <div class="d-flex align-items-center gap-3 py-2 border-bottom border-secondary" style="border-color:var(--bp-line)!important;">
                <img src="<?= htmlspecialchars($item['img']) ?>" style="width:52px;height:52px;border-radius:10px;object-fit:cover;" alt="">
                <div class="flex-grow-1">
                    <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?> <span class="text-muted-2">x<?= (int)$item['qty'] ?></span></div>
                    <small class="text-primary-2 fw-bold">KSh. <?= number_format($item['price']*$item['qty'], 2) ?></small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="cart/update.php?id=<?= urlencode($item['id']) ?>&qty=<?= max(1,$item['qty']-1) ?>" class="btn-icon" style="width:32px;height:32px;">−</a>
                    <a href="cart/update.php?id=<?= urlencode($item['id']) ?>&qty=<?= $item['qty']+1 ?>" class="btn-icon" style="width:32px;height:32px;">+</a>
                    <a href="cart/remove.php?id=<?= urlencode($item['id']) ?>" class="btn-icon" style="width:32px;height:32px;color:#ef4444;"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>
            <a href="#" class="text-primary-2 d-block py-1" style="font-size:.8rem;">+ Add Notes</a>
        <?php endforeach; ?>
    </div>

    <!-- Summary -->
    <div class="glass-card p-3 mb-3">
        <div class="mb-3 dining-toggle" id="diningToggle"
             data-sub="<?= htmlspecialchars($sub) ?>"
             data-dining="<?= $dining ?>"
             data-rider="<?= $rider ?>">
            <label class="form-label-2 d-block mb-2">Dining Option</label>
            <div class="order-toggle-wrap" role="group" id="diningWrap">
                <span class="order-toggle-thumb" aria-hidden="true" style="transform:translateX(<?= $dining==='takeaway'?'100%':'0' ?>)"></span>
                <button type="button" class="order-toggle-btn<?= $dining==='eat_in'?' active':'' ?>" data-dining="eat_in">Eat In</button>
                <button type="button" class="order-toggle-btn<?= $dining==='takeaway'?' active':'' ?>" data-dining="takeaway">Take Away</button>
            </div>
            <div class="order-note mt-2">
                <span class="order-note-text" data-note="eat_in"<?= $dining==='eat_in'?'':' hidden' ?>>We'll ask for your table number at checkout.</span>
                <span class="order-note-text" data-note="takeaway"<?= $dining==='takeaway'?'':' hidden' ?>>We'll ask when to have it ready and a number to reach you.</span>
            </div>

            <div id="riderBlock" class="mt-3"<?= $dining==='takeaway'?'':' hidden' ?>>
                <label class="form-label-2 d-block mb-2">Rider</label>
                <div class="order-toggle-wrap" role="group" id="riderWrap">
                    <span class="order-toggle-thumb" aria-hidden="true" style="transform:translateX(<?= $rider==='send'?'100%':'0' ?>)"></span>
                    <button type="button" class="order-toggle-btn<?= $rider==='own'?' active':'' ?>" data-rider="own">I have a rider</button>
                    <button type="button" class="order-toggle-btn<?= $rider==='send'?' active':'' ?>" data-rider="send">Send your rider</button>
                </div>
            </div>
        </div>
        <label class="form-label-2">Delivery Instructions</label>
        <input type="text" class="form-control-2 mb-3" placeholder="e.g. leave at the door">
        <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Sub Total</span><span id="sumSub">KSh. <?= number_format($sub, 2) ?></span></div>
        <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Delivery Cost</span><span id="sumDelivery">KSh. <?= number_format($delivery, 2) ?></span></div>
        <div class="divider-line"></div>
        <div class="d-flex justify-content-between fw-bold"><span>Total</span><span class="text-primary-2" id="sumTotal">KSh. <?= number_format($total, 2) ?></span></div>
    </div>

    <a href="<?= $checkoutHref ?>" class="btn-primary-2 text-center" id="checkoutLink">Checkout</a>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
