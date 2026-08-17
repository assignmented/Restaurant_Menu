<?php
/** OTP verification screen. */
require_once __DIR__ . '/config.php';
$chrome = false;
$pageTitle = 'Verify OTP';
$pending = $_SESSION['pending_mobile'] ?? '07*********';
include __DIR__ . '/includes/header.php';
?>
<div class="phone-stage">
    <div class="phone-card p-4 p-md-5">
        <h2 class="fw-bold mb-1">We have sent an OTP to your Mobile</h2>
        <p class="text-muted-2 mb-4">Please check your mobile number <span class="text-primary-2"><?= htmlspecialchars($pending) ?></span> and continue to reset your password</p>

        <form action="#" method="post" novalidate>
            <div class="otp-row mb-4">
                <input class="otp-box" name="otp1" inputmode="numeric" required>
                <input class="otp-box" name="otp2" inputmode="numeric" required>
                <input class="otp-box" name="otp3" inputmode="numeric" required>
                <input class="otp-box" name="otp4" inputmode="numeric" required>
            </div>
            <button type="submit" class="btn-primary-2">Next</button>
        </form>

        <p class="text-center mt-4 mb-0">Didn't Receive? <a href="#" class="fw-bold">Click Here</a></p>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
