<?php
    /** Checkout. */
    require_once __DIR__ . '/config.php';
    $user = current_user();
    $cart = cart();
    // Honor the dining + rider choices made on my-order.php (session, with a
    // query-string override from the Checkout link). Eat-in = no delivery fee;
    // take-away + "I have a rider" = no fee; take-away + "Send your rider" = fee.
    // No discount on either selection.
    $dining = $_GET['dining'] ?? ($_SESSION['dining'] ?? 'takeaway');
    if (!in_array($dining, ['eat_in', 'takeaway'], true)) {
        $dining = 'takeaway';
    }
    $_SESSION['dining'] = $dining;

    $rider = $_GET['rider'] ?? ($_SESSION['rider'] ?? 'send');
    if (!in_array($rider, ['own', 'send'], true)) {
        $rider = 'send';
    }
    $_SESSION['rider'] = $rider;

    if ($dining === 'eat_in') {
        $delivery = 0.00;
    } else {
        $delivery = ($rider === 'own') ? 0.00 : 250;
    }
    $sub = cart_total();
    $total = $sub + $delivery;

    // Delivery address to show: the map-picked address for "Send your rider"
    // orders, otherwise the user's saved address.
    $deliveryAddr = $user['user_address'] ?? '';
    $changeAddrHref = 'change-address.php';
    if ($dining === 'takeaway' && $rider === 'send' && !empty($_SESSION['delivery_address']['address'])) {
        $deliveryAddr = $_SESSION['delivery_address']['address'];
        $changeAddrHref = 'add-delivery-location.php?dining=takeaway&rider=send';
    }

    if (isset($_SESSION['latlng'])) {
        $lat = $_SESSION['latlng']['lat'];
        $lng = $_SESSION['latlng']['lng'];
    }

    function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

    function random_code($len, $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789') {
        $out = '';
        for ($i = 0; $i < $len; $i++) {
            $out .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $out;
    }

    $defaults = [
        'receipt_no'     => 'TBP-' . date('YmdHis'),
        'date'           => date('d/m/Y'),
        'time'           => date('H:i'),
        'cust_name'      => 'Walk-in Customer',
        'served_by'      => 'Online Order',
        'dining'         => 'takeaway',
        'rider'          => 'send',
        'delivery_addr'  => 'Njoro Rd, Meru Town',
        'payment_method' => 'M-Pesa',
        'mpesa_receipt'  => 'SFA' . random_code(7, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),
    ];

    $data = $defaults;

    $watermark_path = __DIR__ . '/assets/watermarks/black_perch_b64.txt';
    $watermark_b64 = is_file($watermark_path) ? trim(file_get_contents($watermark_path)) : '';
    $watermark_data_uri = $watermark_b64 !== '' ? 'data:image/png;base64,' . $watermark_b64 : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($defaults as $key => $def) {
            if (isset($_POST[$key]) && $_POST[$key] !== '') {
                $data[$key] = trim($_POST[$key]);
            }
        }
        $generated = true;
    }

    $watermark_path = __DIR__ . '/assets/watermarks/black_perch_b64.txt';
    $watermark_b64 = is_file($watermark_path) ? trim(file_get_contents($watermark_path)) : '';
    $watermark_data_uri = $watermark_b64 !== '' ? 'data:image/png;base64,' . $watermark_b64 : '';


    $dining_label = $data['dining'] === 'eat_in'
        ? 'Eat-in'
        : ('Take Away · ' . ($data['rider'] === 'own' ? 'I have a rider' : 'Send your rider'));

    function money($n) {
        return number_format((float) $n, 2);
    }

    // Set by payment/mpesa_checkstatus.php once Safaricom confirms the
    // transaction. Empty if the order page is viewed before payment
    // completes (receipt section below just won't have a receipt no.).
    $mpesaReceipt = $_SESSION['pay_mpesa_receipt'] ?? '';
    $amountPaid   = $_SESSION['pay_amount'] ?? $total;
    $orderDate    = date('d M Y, H:i');

    $active = '';
    $pageTitle = 'View Order';
    $canonical = 'order-view.php';
    include __DIR__ . '/includes/header.php';
?>

    <div class="app-bar">
        <a href="cart.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>View Order</h1>
        <span class="spacer"></span>
    </div>

    <style>
        :root {
            --ink: #1b1f23;
            --paper: #fdfdf9;
            --muted: #6b7280;
            --accent: #b8860b;
            --line: #d8d8d0;
            --bg: #17181a;
        }
        .receipt-wrap { flex: 0 0 320px; display: flex; flex-direction: column; align-items: center; }
        .receipt {
            position: relative; width: 300px; background: var(--paper);
            box-shadow: 0 4px 18px rgba(0,0,0,0.35); padding: 18px 16px 22px;
            font-family: 'Courier New', Courier, monospace; font-size: 11.5px;
            line-height: 1.45; color: #111; overflow: hidden;
        }
        .receipt::before, .receipt::after {
        content: ""; position: absolute; left: 0; right: 0; height: 10px;
        background: repeating-linear-gradient(-45deg, var(--paper) 0 4px, transparent 4px 8px), var(--bg);
        background-size: 16px 16px, auto;
      }
      .receipt::before { top: -10px; }
      .receipt::after  { bottom: -10px; }
      .watermark-layer {
        position: absolute; inset: 0; background-image: var(--watermark-img);
        background-repeat: no-repeat; background-size: 70% auto; background-position: center;
        opacity: 0.07; pointer-events: none; z-index: 1;
      }
      .receipt > *:not(.watermark-layer) { position: relative; z-index: 2; }
      .center { text-align: center; }
      .bold { font-weight: 700; }
      .dashed { border-top: 1px dashed #999; margin: 8px 0; }
      table.items { width: 100%; border-collapse: collapse; margin-top: 4px; }
      table.items td { padding: 1px 0; }
      table.items td.num { text-align: right; }
      .logo-img { width: 46px; height: 46px; object-fit: contain; display: block; margin: 0 auto 4px; }
      .flag {
        display: inline-block; margin-top: 10px; font-family: Arial, sans-serif; font-size: 10px;
        color: var(--accent); border: 1px solid var(--accent); border-radius: 4px; padding: 3px 8px; text-align: center;
      }
      .actions { margin-top: 14px; display: flex; gap: 8px; }
      .actions button { margin-top: 0; background: #333; color: #fff; }
      @media print {
        body * { visibility: hidden; }
        .receipt, .receipt * { visibility: visible; }
        .receipt { position: absolute; top: 0; left: 0; box-shadow: none; }
        .flag, .actions { display: none !important; }
        .watermark-layer { -webkit-print-color-adjust: exact; print-color-adjust: exact; visibility: visible !important; }
      }
    </style>
    <div class="px-3">
        <?php if ($dining === 'takeaway' && $rider === 'send'): ?>
        <!-- Delivery address (only needed when the restaurant sends a rider) -->
        <div class="glass-card p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h6 class="fw-bold mb-0">Delivery address</h6>
                <a target="_blank" href="https://www.google.com/maps/dir/0.054297, 37.641386/<?= $lat ?>,<?= $lng ?>" style="font-size:.85rem;">View on Maps</a>
            </div>
            <p class="text-muted-2 mb-0"><?= htmlspecialchars($deliveryAddr) ?></p>
        </div>
        <?php endif; ?>

            <!-- Order summary -->
        <div class="glass-card p-3 mb-3">
            <?php 
                //var_dump($cart); exit;
                foreach ($cart as $item): ?>
                <div class="d-flex justify-content-between text-muted-2 mb-2">
                    <span><?= htmlspecialchars($item['name']) ?> x<?= (int)$item['qty'] ?></span>
                    <span>KSh. <?= number_format($item['price']*$item['qty'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="divider-line"></div>
            <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Sub Total</span><span>KSh. <?= number_format($sub, 2) ?></span></div>
            <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Dining</span><span><?= $dining === 'eat_in' ? 'Eat-in' : ('Take Away · ' . ($rider === 'own' ? 'I have a rider' : 'Send your rider')) ?></span></div>
            <div class="d-flex justify-content-between text-muted-2 mb-2"><span>Delivery Cost</span><span>KSh. <?= number_format($delivery, 2) ?></span></div>
            <div class="d-flex justify-content-between fw-bold"><span>Total</span><span class="text-primary-2">KSh. <?= number_format($total, 2) ?></span></div>
            <input type="hidden" name="amount" value="<?= number_format($total, 0) ?>">
        </div>

        <div class="glass-card p-3 mb-3">
            <div class="d-flex justify-content-between text-muted-2 mb-2">
                <span>M-PESA Receipt No.</span>
                <span><?= $mpesaReceipt !== '' ? htmlspecialchars($mpesaReceipt) : '—' ?></span>
            </div>
            <div class="d-flex justify-content-between text-muted-2 mb-2">
                <span>Amount Paid</span>
                <span>KSh. <?= number_format($amountPaid, 2) ?></span>
            </div>
            <div class="d-flex justify-content-between text-muted-2 mb-2">
                <span>Delivery Cost</span>
                <span>KSh. <?= number_format($delivery, 2) ?></span>
            </div>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span class="text-primary-2">KSh. <?= number_format($total, 2) ?></span>
            </div>
            <input type="hidden" name="amount" value="<?= number_format($total, 0) ?>">
        </div>

        <div class="receipt-wrap">
            <div class="receipt" id="receipt-print-area" style="--watermark-img: url('<?= e($watermark_data_uri) ?>');position:absolute; left:-9999px; top:0;">
            <div class="watermark-layer" aria-hidden="true"></div>

            <?php if ($watermark_data_uri !== ''): ?>
                <img class="logo-img" src="<?= e($watermark_data_uri) ?>" alt="The Black Perch">
            <?php endif; ?>
            <div class="center bold">THE BLACK PERCH</div>
            <div class="center">Order Receipt</div>

            <div class="dashed"></div>

            <div><b>Receipt No:</b> <?= e($data['receipt_no']) ?></div>
            <div><b>Date:</b> <?= e($data['date']) ?> &nbsp;<?= e($data['time']) ?></div>
            <div><b>Customer:</b> <?= e($data['cust_name']) ?></div>
            <?php if ($data['served_by'] !== ''): ?>
                <div><b>Served By:</b> <?= e($data['served_by']) ?></div>
            <?php endif; ?>
            <div><b>Dining:</b> <?= e($dining_label) ?></div>

            <div class="dashed"></div>

            <table class="items">
                <tr>
                <td><b>ITEM</b></td>
                <td class="num"><b>QTY</b></td>
                <td class="num"><b>AMT</b></td>
                <td class="num"><b>TOTAL</b></td>
                </tr>
                <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?= e($item['name']) ?></td>
                    <td class="num"><?= (int)$item['qty'] ?></td>
                    <td class="num"><?= number_format($item['price'], 0) ?></td>
                    <td class="num"><?= number_format($item['qty'] * $item['price'], 0) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <div class="dashed"></div>

            <div style="display:flex; justify-content:space-between;"><span>Sub Total</span><span><?= number_format($sub, 2) ?></span></div>
            <div style="display:flex; justify-content:space-between;"><span>Delivery Cost</span><span><?= number_format($delivery, 2) ?></span></div>
            <div style="display:flex; justify-content:space-between;" class="bold"><span>Total</span><span><?= number_format($total, 2) ?></span></div>

            <div class="dashed"></div>

            <div style="display:flex; justify-content:space-between;"><span>Payment Method</span><span><?= $mpesaReceipt !== '' ? 'M-Pesa' : '—' ?></span></div>
            <div style="display:flex; justify-content:space-between;"><span>M-Pesa Receipt</span><span><?= $mpesaReceipt !== '' ? htmlspecialchars($mpesaReceipt) : '—' ?></span></div>
            <div style="display:flex; justify-content:space-between;" class="bold"><span>Amount Paid</span><span><?= $mpesaReceipt !== '' ? number_format($amountPaid, 2) : '—' ?></span></div>

            <div class="dashed"></div>

            <div id="qrcode-container" style="margin:10px auto 4px; width:100px; height:100px;"></div>
            <div class="center" style="font-size:9.5px; color:#666;">Scan to view your order</div>

            <div class="dashed"></div>
            <div class="center" style="color:#666;">Thank you for ordering with The Black Perch</div>
        </div>
        <button type="button" id="downloadReceiptBtn" style="margin-top: 14px;" class="btn-primary-2 text-center w-100 mb-3">
            <i class="fa-solid fa-download me-1"></i> Download Receipt
        </button>
      </div>
    </div>
    <div class="pb-4"></div>

    <script src="assets/js/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script>
      // Download button: snapshot the receipt element and save it as a
      // PDF directly, no print dialog. Falls back to a PNG download if
      // the PDF library fails to load for any reason.
      (function () {
        var btn = document.getElementById('downloadReceiptBtn');
        var receipt = document.getElementById('receipt-print-area');
        if (!btn || !receipt) return;

        btn.addEventListener('click', function () {
          var originalLabel = btn.innerHTML;
          btn.disabled = true;
          btn.innerHTML = 'Preparing receipt…';

          html2canvas(receipt, { scale: 2, backgroundColor: '#fdfdf9' }).then(function (canvas) {
            var imgData = canvas.toDataURL('image/png');
            var jsPDFCtor = window.jspdf && window.jspdf.jsPDF;

            if (!jsPDFCtor) {
              var link = document.createElement('a');
              link.href = imgData;
              link.download = 'black-perch-receipt.png';
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
              return;
            }

            var pdfWidth = canvas.width / 2;   // matches scale:2 above
            var pdfHeight = canvas.height / 2;
            var pdf = new jsPDFCtor({ orientation: 'portrait', unit: 'pt', format: [pdfWidth, pdfHeight] });
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('black-perch-receipt.pdf');
          }).catch(function (err) {
            console.error('Receipt download failed:', err);
            alert('Could not generate the receipt. Please try again.');
          }).finally(function () {
            btn.disabled = false;
            btn.innerHTML = originalLabel;
          });
        });
      })();
    </script>
    <script>
      // QR points at a real order-reference string, not a fabricated
      // tax/verification code — this receipt makes no fiscal claims.
      const qrPayload = <?= json_encode(
          "https://www.google.com/maps/dir/0.054297, 37.641386/$lat,$lng"
      ) ?>;

      const qrContainer = document.getElementById('qrcode-container');

      if (typeof QRCode === 'undefined') {
        qrContainer.textContent = 'QR unavailable';
        qrContainer.style.cssText += 'display:flex;align-items:center;justify-content:center;' +
          'font-family:Arial,sans-serif;font-size:10px;color:#a33;border:1px dashed #a33;';
        console.error('QRCode library not loaded — check that vendor/qrcode/qrcode.min.js exists and is served correctly.');
      } else {
        QRCode.toCanvas(
          document.createElement('canvas'),
          qrPayload,
          { width: 100, margin: 1 },
          function (err, canvas) {
            if (err) {
              qrContainer.textContent = 'QR error';
              console.error('QR generation failed:', err);
              return;
            }
            qrContainer.appendChild(canvas);
          }
        );
      }
    </script>
<?php include __DIR__ . '/includes/footer.php'; ?>
