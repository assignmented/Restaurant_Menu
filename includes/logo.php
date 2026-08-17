<?php
/** Reusable brand logo — uses assets/img/logo.png.
 *  Usage: $size = 'lg' | 'sm';  $tone is retained for backward compatibility. */
$size = $size ?? 'sm';
?>
<div class="bp-logo <?= $size === 'lg' ? 'bp-logo-lg' : '' ?>">
    <img src="assets/img/logo.png"
         alt="<?= BRAND_NAME ?> — <?= BRAND_TAGLINE ?>"
         class="bp-logo-img <?= $size === 'lg' ? 'bp-logo-img-lg' : '' ?>">
</div>
