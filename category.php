<?php
/** Category listing (e.g. Desserts). */
require_once __DIR__ . '/config.php';
$type = $_GET['type'] ?? 'desserts';
$id = $_GET['id'] ?? 'desserts';
$label = ucfirst(str_replace('-', ' ', $type));
$items = products_by_category($type);
if (!$items) { $items = products(); } // fallback: show all
$active = '';
$pageTitle = $label . ' delivery in Meru · ' . BRAND_NAME;
$metaDescription = 'Browse and order ' . $label . ' for fast delivery in Meru, Kenya on The Black Perch. Top-rated restaurants, real-time tracking, pay with M-Pesa.';
$canonical = 'category.php?type=' . urlencode($type) . '&id=' . urlencode($id);
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="home.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1><?= htmlspecialchars($label) ?></h1>
    <span class="spacer"></span>
    <a href="my-order.php" class="btn-icon position-relative" aria-label="Cart">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (cart_count() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
        <?php endif; ?>
    </a>
</div>

<div class="px-3" style="padding-bottom:4rem;">
    <div class="search-input mb-3">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" class="js-live-search" placeholder="Search <?= htmlspecialchars(strtolower($label)) ?>" autocomplete="off"<?= ctype_digit((string)$type) ? ' data-subcat="' . htmlspecialchars($type) . '"' : '' ?>>
        <div class="search-results" aria-live="polite"></div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <?php 
            $items_sql = "SELECT * FROM items INNER JOIN brands ON item_brand_id = brand_id WHERE item_status = '1' AND item_subcat_id = '$id' ORDER BY item_review DESC";
            $items_query = mysqli_query($conx, $items_sql);
            while($items_result = $items_query->fetch_assoc()): ?>
            <div class="col">
                <a href="product.php?id=<?= $items_result['item_id'] ?>" class="food-row">
                    <img src="assets/img/img/menu/<?= $items_result['item_image'] ?>" class="thumb" alt="<?= htmlspecialchars($items_result['item_name']) ?>" loading="lazy">
                    <div class="flex-grow-1">
                        <div class="fw-semibold"><?= htmlspecialchars($items_result['item_name']) ?></div>
                        <div class="mt-1">
                            <span class="tag-chip">
                                <?= htmlspecialchars($items_result['brand_name']) ?>
                            </span>
                        </div>                        
                        <div class="text-muted-2 mt-2" style="font-size:.8rem;">
                            <i class="fa-solid fa-clock me-1"></i>                        
                            <?= $items_result['item_time'] ?> Min
                        </div>                        
                        <div class="text-muted-2 mt-2" style="font-size:.8rem;">
                            <i class="fa-solid fa-star"></i> 
                            <?= $items_result['item_rating'] ?> (<?= $items_result['item_review'] ?> Reviews)
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold">
                                KSh. <?= htmlspecialchars($items_result['item_price']) ?>
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="pb-4"></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
