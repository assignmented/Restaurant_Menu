<?php
/** Splash screen — auto-redirects after 2s.
 *  Routing:
 *    - First-time visitor: mark visited, go to onboarding slide 1.
 *    - Returning visitor (onboarding cookie set): skip onboarding → welcome.php.
 */
require_once __DIR__ . '/config.php';
mark_visited();

if (has_onboarded()) {
    $next = 'home.php';
} else {
    $next = 'onboard-find-food.php';
}
$chrome = false;
$pageTitle = 'Welcome';
$canonical = 'index.php';
include __DIR__ . '/includes/header.php';
?>
<div class="splash" id="splashRedirect" data-url="<?= $next ?>" data-delay="3200">
    <?php $size = 'lg'; include __DIR__ . '/includes/logo.php'; ?>
    <div class="mt-4">
        <div class="spinner-border" style="color:<?= BRAND_PRIMARY ?>" role="status">
            <span class="visually-hidden">Loading…</span>
        </div>
    </div>
    <!-- noscript fallback -->
    <noscript><meta http-equiv="refresh" content="2;url=<?= $next ?>"></noscript>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
