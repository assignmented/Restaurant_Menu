<?php
/** Reset password — request link. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Reset Password';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage">
    <div class="phone-card p-4 p-md-5">
        <h2 class="fw-bold mb-1">Reset Password</h2>
        <p class="text-muted-2 mb-4">Please enter your email to receive a link to create new password via email</p>

        <form action="#" method="post" novalidate>
            <div class="mb-4">
                <label class="form-label-2" for="email">Email</label>
                <input type="email" class="form-control-2" id="email" name="email" placeholder="your@email.com" required>
            </div>
            <button type="submit" class="btn-primary-2">Send</button>
        </form>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
