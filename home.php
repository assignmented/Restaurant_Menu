<?php
/** Home dashboard. */
require_once __DIR__ . '/config.php';
$greeting = getTheTimeOfDay();
//$user = current_user();
//$subcats = subcategories();
$rests = restaurants();
$active = 'home';
$pageTitle = 'Home';
$metaDescription = 'Order food online in Meru, Kenya with The Black Perch. Browse top restaurants, Sri Lankan, Italian, Indian, Chinese, burgers & desserts. Fast delivery, live tracking, pay with M-Pesa.';
$canonical = 'home.php';
include __DIR__ . '/includes/header.php';
?>
<!-- Top bar -->
<div class="d-flex align-items-center gap-3 px-3 pt-4">
    <div class="flex-grow-1">
        <h2 class="fw-bold mb-0" style="font-size:1.4rem;">
            Good <?= $greeting ?>, 
            <?//= //htmlspecialchars(ucfirst($user['user_name'])) ?></h2>
        <div class="text-muted-2 d-flex align-items-center gap-1" style="font-size:.85rem;">
            <i class="fa-solid fa-location-dot text-primary-2"></i> 
            Delivering to
            <select class="bg-transparent border-0 text-white fw-semibold" style="font-size:.85rem;">
                <option>Current Location</option>
                <option>14 Harborline Wharf</option>
                <option>Office</option>
            </select>
            <i class="fa-solid fa-chevron-down" style="font-size:.7rem;"></i>
        </div>
    </div>
    <a href="cart.php" class="btn-icon position-relative" aria-label="Cart">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (cart_count() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
        <?php endif; ?>
    </a>
</div>

<!-- Search -->
<div class="px-3 mt-3">
    <div class="search-input">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" class="js-live-search" placeholder="Search food" autocomplete="off">
        <div class="search-results" aria-live="polite"></div>
    </div>
</div>

<!-- Categories -->
<div class="px-3 mt-4">
    
    <div class="section-title">
        <h2>Categories</h2>
        <a href="menu-categories.php">View all</a>
    </div>
    <div class="cat-scroll">
        <?php 
            $subcat_sql = "SELECT * FROM subcategories WHERE subcat_status = '1' AND subcat_cat_id != '4' ORDER BY subcat_name ASC LIMIT 10";
            $subcat_query = mysqli_query($conx, $subcat_sql);
            while($subcat_result = $subcat_query->fetch_assoc()): ?>
            <a href="category.php?type=<?= $subcat_result['subcat_name']; ?>&id=<?= $subcat_result['subcat_id']; ?>" class="cat-pill">
                <i class="fa-solid <?= $subcat_result['subcat_image']; ?>"></i>
                <div class="fw-semibold" style="font-size:.8rem;">
                    <?= htmlspecialchars($subcat_result['subcat_slug']); ?>
                </div>
                <div class="n"><?= $subcat_result['subcat_count']; ?> items</div>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<!-- Our Menu -->
<div class="px-3 mt-4">
    <div class="section-title">
        <h2>Our Menu</h2>
        <a href="menu-categories.php">View all</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-3" style="padding-bottom:3rem;">
        <?php 
            $items_sql = "SELECT * FROM items INNER JOIN brands ON item_brand_id = brand_id WHERE item_status = '1' AND item_cat_id != '4' AND (item_id = 31 || item_id = 36 || item_id = 37 || item_id = 38 || item_id = 39 ) ORDER BY item_review DESC LIMIT 9";
            $items_query = mysqli_query($conx, $items_sql);
            while($items_result = $items_query->fetch_assoc()): 
        ?>
            <div class="col">
                <a href="product.php?id=<?= $items_result['item_id'] ?>" class="rest-card d-block">
                    <img src="assets/img/img/menu/<?= $items_result['item_image'] ?>" class="thumb" alt="<?= htmlspecialchars($items_result['item_name']) ?>" loading="lazy">
                    <div class="body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($items_result['item_name']) ?></h6>
                        </div>
                        <div class="mt-2">
                            <span class="tag-chip"><?= $items_result['brand_name'] ?></span>
                        </div>
                        <div class="text-muted-2 mt-2" style="font-size:.8rem;">
                            <i class="fa-solid fa-clock me-1"></i>                        
                            <?= $items_result['item_time'] ?> Min
                        </div>
                        <div class="text-muted-2 mt-2" style="font-size:.8rem;">
                            <span class="rating-badge">
                                <i class="fa-solid fa-star"></i> 
                                <?= $items_result['item_rating'] ?> (<?= $items_result['item_review'] ?> Reviews)
                            </span>
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

    <!--<div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-3">
        <?php foreach ($rests as $r): ?>
            <div class="col">
                <a href="product.php?id=<?= $r['id']+100 ?>" class="rest-card d-block">
                    <img src="<?= $r['img'] ?>" class="thumb" alt="<?= htmlspecialchars($r['name']) ?>" loading="lazy">
                    <div class="body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($r['name']) ?></h6>
                            <span class="rating-badge"><i class="fa-solid fa-star"></i> <?= $r['rating'] ?></span>
                        </div>
                        <div class="mt-2">
                            <?php foreach ($r['cuisine'] as $t): ?><span class="tag-chip"><?= $t ?></span><?php endforeach; ?>
                        </div>
                        <div class="text-muted-2 mt-2" style="font-size:.8rem;"><i class="fa-solid fa-clock me-1"></i><?= $r['time'] ?> · <?= $r['reviews'] ?> reviews</div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>-->
</div>

<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
