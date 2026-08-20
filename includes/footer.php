<?php
/** Closes chrome (sidebar/main) opened by header, adds bottom nav + scripts.
 *  Vars (optional): $active (passed to navbar-bottom), $chrome (default true)
 */
$chrome = $chrome ?? true;
$active = $active ?? '';
?>
<?php if ($chrome): ?>
    <?php if (!isset($sidebar) || $sidebar): ?>
        </main><!-- /.app-main -->
    </div><!-- /.app-shell -->
    <?php endif; ?>
    <?php include __DIR__ . '/navbar-bottom.php'; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/qrcode.min.js"></script>
<script src="assets/js/main.js?v=<?= filemtime(__DIR__ . '/../assets/js/main.js') ?>"></script>
</body>
</html>
