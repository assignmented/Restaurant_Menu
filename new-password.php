<?php
/** New password screen. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'New Password';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage">
    <div class="phone-card p-4 p-md-5">
        <h2 class="fw-bold mb-1">New Password</h2>
        <p class="text-muted-2 mb-4">Please enter your email to receive a link to create new password via email</p>

        <form action="#" method="post" novalidate>
            <div class="mb-3">
                <label class="form-label-2" for="password">New Password</label>
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
            <button type="submit" class="btn-primary-2">Next</button>
        </form>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
