<?php
/** Sign Up screen. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Sign Up';
    $canonical = 'signup.php';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage" style="background-image: url('assets/img/startup.png')">
    <div class="phone-card p-4 p-md-5">
        <h2 class="fw-bold mb-1">Sign Up</h2>
        <p class="text-muted-2 mb-4">Add your details to sign up</p>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="bp-toast mb-3"><i class="fa-solid fa-circle-check"></i> 
            <?= htmlspecialchars($_SESSION['flash']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form action="./signup.php" method="post" novalidate>
            <div class="mb-3">
                <label class="form-label-2" for="name">Name</label>
                <input type="text" class="form-control-2" id="name" name="name" placeholder="Your name" required>
            </div>
            <div class="mb-3">
                <label class="form-label-2" for="email">Email</label>
                <input type="email" class="form-control-2" id="email" name="email" placeholder="your@email.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label-2" for="mobile">Mobile No</label>
                <input type="tel" class="form-control-2" id="mobile" name="mobile" placeholder="07X XXX XXXX" required>
            </div>
            <div class="mb-3">
                <label class="form-label-2" for="address">Address</label>
                <input type="text" class="form-control-2" id="address" name="address" placeholder="Delivery address" required>
            </div>
            <div class="mb-3">
                <label class="form-label-2" for="password">Password</label>
                <div class="input-pwd">
                    <input type="password" class="form-control-2" id="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle" data-toggle-pwd="password" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label-2" for="confirm">Confirm Password</label>
                <div class="input-pwd">
                    <input type="password" class="form-control-2" id="confirm" name="confirm" placeholder="••••••••" required>
                    <button type="button" class="toggle" data-toggle-pwd="confirm" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <button name="signup" type="submit" class="btn-primary-2">Sign Up</button>
        </form>

        <p class="text-center mt-4 mb-0">Already have an account? <a href="login.php" class="fw-bold">Login</a></p>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
