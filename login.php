<?php
/** Login screen. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Login';
    $canonical = 'login.php';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage" style="background-image: url('assets/img/startup.png')">
    <div class="phone-card p-4 p-md-5">
        <h2 class="fw-bold mb-1">Login</h2>
        <p class="text-muted-2 mb-4">Add your details to login</p>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="bp-toast mb-3"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($_SESSION['flash']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="#" method="post" novalidate>
            <div class="mb-3">
                <label class="form-label-2" for="email">Email</label>
                <input type="email" class="form-control-2" id="email" name="email" placeholder="your@email.com" required>
            </div>
            <div class="mb-2">
                <label class="form-label-2" for="password">Password</label>
                <div class="input-pwd">
                    <input type="password" class="form-control-2" id="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle" data-toggle-pwd="password" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="text-end mb-4">
                <a href="reset-password.php" style="font-size:.85rem;">Forgot password?</a>
            </div>
            <button type="submit" class="btn-primary-2">Login</button>
        </form>

        <div class="or-divider"><span>or Login With</span></div>

        <div class="d-grid gap-3">
            <button type="button" class="btn-fb"><i class="fa-brands fa-facebook-f me-2"></i> Login with Facebook</button>
            <button type="button" class="btn-google"><i class="fa-brands fa-google me-2"></i> Login with Google</button>
        </div>

        <p class="text-center mt-4 mb-0">Don't have an account? <a href="signup.php" class="fw-bold">Sign Up</a></p>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
