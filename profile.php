<?php
/** Profile. */
require_once __DIR__ . '/config.php';
$user = current_user();
$active = 'profile';
$pageTitle = 'Profile';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <h1>Profile</h1>
    <span class="spacer"></span>
    <a href="cart.php" class="btn-icon position-relative" aria-label="Cart">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if (cart_count() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary-2" style="font-size:.6rem"><?= cart_count() ?></span>
        <?php endif; ?>
    </a>
</div>

<div class="px-3 text-center mt-3">
    <div class="position-relative d-inline-block">
        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200&q=80" alt="Avatar"
             style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:3px solid var(--bp-primary);">
        <span class="btn-icon position-absolute bottom-0 end-0" style="width:34px;height:34px;background:var(--bp-primary);color:var(--bp-dark);border:0;"><i class="fa-solid fa-camera"></i></span>
    </div>
    <p class="mt-3 mb-0">Hi there, <?= htmlspecialchars(ucfirst($user['user_name'])) ?>!
        <a href="#" class="fw-bold text-primary-2" style="font-size:.85rem;">Sign Out</a>
    </p>
</div>

<div class="px-3 mt-4">
    <form action="#" method="post">
        <div class="mb-3">
            <label class="form-label-2">Name</label>
            <input type="text" class="form-control-2" name="name" value="<?= htmlspecialchars($user['user_name']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label-2">Email</label>
            <input type="email" class="form-control-2" name="email" value="<?= htmlspecialchars($user['user_email']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label-2">Address</label>
            <input type="text" class="form-control-2" name="address" value="<?= htmlspecialchars($user['user_address']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label-2">Password</label>
            <div class="input-pwd">
                <input type="password" class="form-control-2" id="pwd" name="password" value="secret123">
                <button type="button" class="toggle" data-toggle-pwd="pwd"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label-2">Confirm Password</label>
            <div class="input-pwd">
                <input type="password" class="form-control-2" id="cpwd" name="confirm" value="secret123">
                <button type="button" class="toggle" data-toggle-pwd="cpwd"><i class="fa-solid fa-eye"></i></button>
            </div>
        </div>
        <button type="submit" class="btn-primary-2">Save</button>
    </form>
</div>
<div class="pb-4"></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
