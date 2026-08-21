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

        $defaults = [
            'receipt_no'     => 'TBP-' . date('YmdHis'),
            'date'           => date('d/m/Y'),
            'time'           => date('H:i'),
            'cust_name'      => 'Walk-in Customer',
            'served_by'      => 'Online Order',
            'dining'         => 'takeaway',
            'rider'          => 'send',
            'delivery_fee'   => '250.00',
            'payment_method' => 'M-Pesa',
        ];

        $data = $defaults;

        $watermark_path = __DIR__ . '/watermarks/black_perch_b64.txt';
        $watermark_b64 = is_file($watermark_path) ? trim(file_get_contents($watermark_path)) : '';
        $watermark_data_uri = $watermark_b64 !== '' ? 'data:image/png;base64,' . $watermark_b64 : '';

        
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
        .payment-option{display:flex;align-items:center;gap:.75rem;padding:.7rem .8rem;border:1px solid var(--bp-line);
            border-radius:14px;margin-bottom:.5rem;cursor:pointer;transition:border-color .2s ease,background .2s ease;background:var(--bp-card);}
        .payment-option:last-child{margin-bottom:0;}
        .payment-option input{position:absolute;opacity:0;pointer-events:none;width:0;height:0;}
        .payment-option:hover{border-color:var(--bp-primary);}
        .payment-option:has(input:checked){border-color:var(--bp-primary);background:rgba(255,209,104,.08);}
        .payment-option .po-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;
            background:var(--bp-card-2);font-size:1.1rem;flex:0 0 auto;}
        .payment-option .po-body{flex:1;min-width:0;}
        .payment-option .po-title{display:block;font-weight:600;color:#fff;font-size:.92rem;}
        .payment-option .po-sub{display:block;color:var(--bp-muted);font-size:.72rem;}
        .payment-option .po-brand{flex:0 0 auto;font-size:.62rem;font-weight:700;color:#fff;padding:.25rem .5rem;border-radius:5px;letter-spacing:.03em;}
        .payment-option.is-disabled{opacity:.5;cursor:not-allowed;}
        .payment-option.is-disabled:hover{border-color:var(--bp-line);}
        .payment-option.is-disabled:has(input:checked){border-color:var(--bp-line);background:var(--bp-card);}
        .po-extra{margin:0 0 .6rem .25rem;padding-left:3.5rem;}
        .po-field-label{display:block;font-size:.72rem;color:var(--bp-muted);margin-bottom:.35rem;}

        /* --- Floating loading modal --- */
        .modal-overlay{
            position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(10,10,20,.55);backdrop-filter:blur(4px);
            display:flex;align-items:center;justify-content:center;
            opacity:0;visibility:hidden;transition:opacity .25s ease,visibility .25s ease;
            z-index:1000;
        }
        .modal-overlay.active{opacity:1;visibility:visible;}
        .loading-modal{
            background:var(--bp-card,#fff);border-radius:16px;padding:32px 40px;
            display:flex;flex-direction:column;align-items:center;gap:14px;
            box-shadow:0 20px 50px rgba(0,0,0,.35);
            transform:translateY(20px) scale(.95);transition:transform .3s ease;
            animation:bp-float 3s ease-in-out infinite;min-width:220px;text-align:center;
        }
        .modal-overlay.active .loading-modal{transform:translateY(0) scale(1);}
        @keyframes bp-float{0%,100%{transform:translateY(0);}50%{transform:translateY(-8px);}}
        .loading-modal .spinner{
            width:44px;height:44px;border:5px solid rgba(255,209,104,.25);
            border-top-color:var(--bp-primary,#ffd168);border-radius:50%;
            animation:bp-spin .9s linear infinite;
        }
        @keyframes bp-spin{to{transform:rotate(360deg);}}
        .loading-modal .loading-text{font-size:15px;font-weight:600;color:#111;}
        .loading-modal .loading-subtext{font-size:13px;color:#777;margin-top:-4px;}
        .loading-modal .loading-subtext.is-error{color:#d33;font-weight:600;}
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

        <button type="button" id="downloadReceiptBtn" class="btn-primary-2 text-center w-100 mb-3">
            <i class="fa-solid fa-download me-1"></i> Download Receipt
        </button>
    </div>
    <div class="pb-4"></div>

    <!-- ===================================================================
         Hidden receipt template. Kept out of the visible layout (positioned
         off-canvas, not display:none, so html2canvas can still render it)
         and only ever touched by the download script below. -->
    <div id="receiptTemplate" style="position:absolute; left:-9999px; top:0; width:340px;">
        <div style="background-image: url('assets/img/black_perch.png'); background-size: contain; background-repeat: no-repeat; color:#111; font-family:'Courier New',Courier,monospace; font-size:12px; line-height:1.5; padding:20px 18px;">
            <div style="text-align:center; font-weight:700; font-size:14px; letter-spacing:.04em;">THE BLACK PERCH</div>
            <div style="text-align:center; color:#555; font-size:11px; margin-bottom:8px;">Order Receipt</div>
            <div style="border-top:1px dashed #999; margin:8px 0;"></div>

            <div>Date: <?= htmlspecialchars($orderDate) ?></div>
            <div>Dining: <?= $dining === 'eat_in' ? 'Eat-in' : ('Take Away · ' . ($rider === 'own' ? 'I have a rider' : 'Send your rider')) ?></div>
            <?php if ($dining === 'takeaway' && $rider === 'send'): ?>
                <div>Delivery to: <?= htmlspecialchars($deliveryAddr) ?></div>
            <?php endif; ?>

            <div style="border-top:1px dashed #999; margin:8px 0;"></div>

            <?php foreach ($cart as $item): ?>
                <div style="display:flex; justify-content:space-between;">
                    <span><?= htmlspecialchars($item['name']) ?> x<?= (int)$item['qty'] ?></span>
                    <span>KSh <?= number_format($item['price'] * $item['qty'], 2) ?></span>
                </div>
            <?php endforeach; ?>

            <div style="border-top:1px dashed #999; margin:8px 0;"></div>

            <div style="display:flex; justify-content:space-between;"><span>Sub Total</span><span>KSh <?= number_format($sub, 2) ?></span></div>
            <div style="display:flex; justify-content:space-between;"><span>Delivery Cost</span><span>KSh <?= number_format($delivery, 2) ?></span></div>
            <div style="display:flex; justify-content:space-between; font-weight:700;"><span>Total</span><span>KSh <?= number_format($total, 2) ?></span></div>

            <div style="border-top:1px dashed #999; margin:8px 0;"></div>

            <div style="display:flex; justify-content:space-between;"><span>Payment Method</span><span>M-Pesa</span></div>
            <div style="display:flex; justify-content:space-between;"><span>M-Pesa Receipt</span><span><?= $mpesaReceipt !== '' ? htmlspecialchars($mpesaReceipt) : 'PENDING' ?></span></div>
            <div style="display:flex; justify-content:space-between;"><span>Amount Paid</span><span>KSh <?= number_format($amountPaid, 2) ?></span></div>

            <div style="border-top:1px dashed #999; margin:8px 0;"></div>
            <div style="text-align:center; color:#777; font-size:10.5px;">Thank you for ordering with The Black Perch</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script>
    (function () {
        var btn = document.getElementById('downloadReceiptBtn');
        var template = document.getElementById('receiptTemplate');
        if (!btn || !template) return;

        btn.addEventListener('click', function () {
            var originalLabel = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Preparing receipt…';

            html2canvas(template, { scale: 2, backgroundColor: '#ffffff' }).then(function (canvas) {
                var imgData = canvas.toDataURL('image/png');
                var jsPDFCtor = window.jspdf && window.jspdf.jsPDF;

                if (!jsPDFCtor) {
                    // Fallback: download the receipt as a PNG if the PDF
                    // library failed to load, so the button still works.
                    var link = document.createElement('a');
                    link.href = imgData;
                    link.download = 'black-perch-receipt.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    return;
                }

                var pdfWidth = canvas.width / 2; // scale:2 above
                var pdfHeight = canvas.height / 2;
                var pdf = new jsPDFCtor({
                    orientation: 'portrait',
                    unit: 'pt',
                    format: [pdfWidth, pdfHeight]
                });
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('black-perch-receipt.pdf');
            }).catch(function (err) {
                console.error('Receipt generation failed:', err);
                alert('Could not generate the receipt. Please try again.');
            }).finally(function () {
                btn.disabled = false;
                btn.innerHTML = originalLabel;
            });
        });
    })();
    </script>
<?php include __DIR__ . '/includes/footer.php'; ?>
