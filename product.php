<?php
/** Product detail. */
require_once __DIR__ . '/config.php';
$id = (int)($_GET['id'] ?? 0);
$p = find_item($id) ?: find_product($id) ?: products()[0];
$active = '';
$pageTitle = $p['name'] . ' · Order on ' . BRAND_NAME;
$metaDescription = 'Order ' . $p['name'] . ' for fast delivery in Meru, Kenya on The Black Perch. '
    . ($p['by'] ?? '') . ' · KSh ' . number_format((float)($p['price'] ?? 0), 2)
    . ' · ' . ($p['cat'] ?? '') . ' · pay with M-Pesa, track live.';
$canonical = 'product.php?id=' . $id;
$ogType = 'article';
$metaImage = isset($p['img']) && $p['img'] !== '' ? $p['img'] : null;
include __DIR__ . '/includes/header.php';
?>
<!-- Hero image -->
<div class="product-hero">
    <img src="<?= $p['img'] ?>" alt="<?= htmlspecialchars($p['name']) ?>">
    <a href="javascript:history.back()" class="float-btn" style="left:1rem;" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <button type="button" class="float-btn" style="right:1rem;" aria-label="Favourite"><i class="fa-solid fa-heart"></i></button>
</div>

<div class="p-3" style="padding: 3rem !important;background: var(--bp-card);border-radius: 0 028px 28px;">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold mb-1" style="font-size:1.5rem;"><?= htmlspecialchars($p['name']) ?></h2>
            <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= $p['rating'] ?> · by <?= htmlspecialchars($p['by']) ?></span>
        </div>
        <div class="text-primary-2 fw-bold" style="font-size:1.5rem;">KSh. <?= number_format($p['price'], 2) ?></div>
    </div>

    <div class="mt-4">
        <h6 class="fw-bold mb-2">Description</h6>
        <p class="text-muted-2"><?= !empty($p['desc']) ? htmlspecialchars($p['desc']) : 'A signature ' . htmlspecialchars($p['cat']) . ' favourite, prepared fresh with quality ingredients and delivered hot to your door. Made to order by ' . htmlspecialchars($p['by']) . ' — light, flavorful and generously portioned.' ?></p>
    </div>

    <div class="mt-4">
        <h6 class="fw-bold mb-3">Customize Your Order</h6>
        <div class="mb-3">
            <label class="form-label-2">Select the size of portion</label>
            <select class="form-select-2">
                <option>Regular</option>
                <option>Large (+$3.00)</option>
                <option>Family (+$6.00)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label-2">Select the ingredients</label>
            <select class="form-select-2">
                <option>Extra cheese</option>
                <option>No onions</option>
                <option>Spicy</option>
                <option>Extra sauce</option>
            </select>
        </div>
    </div>

    <!-- Quantity stepper -->
    <div class="d-flex align-items-center gap-3 mb-2">
        <div class="qty-stepper" data-stepper data-min="1" data-max="20" data-price="<?= $p['price'] ?>">
            <button type="button" class="minus">−</button>
            <span class="val">1</span>
            <button type="button" class="plus">+</button>
        </div>
        <span class="text-muted-2" style="font-size:.85rem;">Quantity</span>
    </div>

    <form action="cart/add.php" method="post" style="padding-top:1rem !important;">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($p['name']) ?>">
        <input type="hidden" name="price" value="<?= $p['price'] ?>">
        <input type="hidden" name="img" value="<?= $p['img'] ?>">
        <input type="hidden" name="qty" id="qtyInput" value="1">
        <div class="sticky-buy">
            <div class="total">
                <small>Total Price</small>
                <b id="stepperTotal">KSh. <?= number_format($p['price'], 2) ?></b>
            </div>
            <button type="submit" class="btn-primary-2" style="width:auto; padding-left:2rem; padding-right:2rem;">Add to Cart</button>
        </div>
    </form>
</div>

<!-- Sticky add-to-cart bar -->


<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
