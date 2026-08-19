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
            $delivery = ($rider === 'own') ? 0.00 : 2.50;
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

        $active = 'cart';
        $pageTitle = 'Checkout';
        $canonical = 'checkout.php';
        include __DIR__ . '/includes/header.php';
    ?>

    <div class="app-bar">
        <a href="cart.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Checkout</h1>
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
                <a href="<?= $changeAddrHref ?>" style="font-size:.85rem;">Change</a>
            </div>
            <p class="text-muted-2 mb-0"><?= htmlspecialchars($deliveryAddr) ?></p>
        </div>
        <?php endif; ?>

        <!-- Payment method -->
        <form id="paymentForm">
            <div class="glass-card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">Payment method</h6>
                    <a href="add-card.php" style="font-size:.85rem;">+ Add Card</a>
                </div>

                <label class="payment-option">
                    <input type="radio" name="payment" value="mpesa" checked>
                    <span class="po-icon" style="color:#33b541;"><i class="fa-solid fa-mobile-screen-button"></i></span>
                    <span class="po-body">
                        <span class="po-title">M-Pesa</span>
                        <span class="po-sub">STK push to your phone</span>
                    </span>
                    <span class="po-brand" style="background:#33b541;">M-PESA</span>
                </label>
                <div class="po-extra" id="mpesaPhoneWrap" hidden>
                    <label class="po-field-label" for="mpesaPhone">M-Pesa phone number</label>
                    <input type="tel" id="mpesaPhone" name="mpesa_phone" class="form-control-2" placeholder="07xx xxx xxx" inputmode="tel" autocomplete="tel">
                </div>

                <label class="payment-option">
                    <input type="radio" name="payment" value="visa">
                    <span class="po-icon"><i class="fa-solid fa-credit-card"></i></span>
                    <span class="po-body">
                        <span class="po-title">Visa</span>
                        <span class="po-sub">Coming soon</span>
                    </span>
                    <span class="po-brand" style="background:#1a1a72;">VISA</span>
                </label>

                <label class="payment-option is-disabled">
                    <input type="radio" name="payment" value="paypal" disabled>
                    <span class="po-icon" style="color:#169bd7;"><i class="fa-brands fa-paypal"></i></span>
                    <span class="po-body">
                        <span class="po-title">PayPal</span>
                        <span class="po-sub">Coming soon</span>
                    </span>
                    <span class="po-brand" style="background:#003087;">PayPal</span>
                </label>
            </div>

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

            <div id="statusMessage"></div>
            <?php if (cart_count() > 0): ?>        
                <button type="submit" class="btn-primary-2 text-center">Send Order</button>
            <?php endif; ?>
        </form>

        <div id="successCard" class="hidden mt-3"></div>
    </div>
    <div class="pb-4"></div>

    <!-- Floating loading modal (payment in progress) -->
    <div class="modal-overlay" id="loadingOverlay">
        <div class="loading-modal">
            <div class="spinner"></div>
            <div class="loading-text" id="loadingText">Processing payment...</div>
            <div class="loading-subtext" id="loadingSubtext">Check your phone for the M-Pesa prompt</div>
        </div>
    </div>

    <script>
        (function () {
            var wrap = document.getElementById('mpesaPhoneWrap');
            if (!wrap) return;
            var radios = document.querySelectorAll('input[name="payment"]');
            function sync() {
                var sel = document.querySelector('input[name="payment"]:checked');
                wrap.hidden = !(sel && sel.value === 'mpesa');
            }
            radios.forEach(function (r) { r.addEventListener('change', sync); });
            sync();
        })();
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let checkoutRequestId = null;
            let retryCount = 0;
            const maxRetries = 10;
            const retryInterval = 5000; // 5 seconds

            const $overlay = $('#loadingOverlay');
            const $loadingText = $('#loadingText');
            const $loadingSubtext = $('#loadingSubtext');

            function showLoadingModal(text, subtext) {
                $loadingText.text(text || 'Processing payment...');
                $loadingSubtext.removeClass('is-error').text(subtext || '');
                $overlay.addClass('active');
            }

            function updateLoadingModal(subtext, isError) {
                $loadingSubtext.toggleClass('is-error', !!isError).text(subtext || '');
            }

            function hideLoadingModal() {
                $overlay.removeClass('active');
            }

            $('#paymentForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'payment/mpesa_stkpush.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#statusMessage').empty();
                        showLoadingModal('Processing payment...', 'Check your phone for the M-Pesa prompt');
                    },
                    success: function(response) {
                        if (response.success) {
                            updateLoadingModal(response.message, false);
                            checkoutRequestId = response.checkout_request_id;
                            retryCount = 0;
                            pollTransactionStatus();
                        } else {
                            updateLoadingModal(response.message, true);
                            setTimeout(hideLoadingModal, 2500);
                        }
                    },
                    error: function() {
                        updateLoadingModal('An error occurred. Please try again.', true);
                        setTimeout(hideLoadingModal, 2500);
                    }
                });
            });

            function pollTransactionStatus() {
                if (!checkoutRequestId) return;

                $.ajax({
                    url: 'payment/mpesa_checkstatus.php',
                    type: 'GET',
                    data: { checkout_request_id: checkoutRequestId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'COMPLETED') {
                            hideLoadingModal();
                            displaySuccessCard(response.mpesa_receipt, response.amount);
                        } else if (response.status === 'FAILED') {
                            updateLoadingModal(response.message, true);
                            setTimeout(hideLoadingModal, 2500);
                        } else if (retryCount < maxRetries) {
                            updateLoadingModal('Payment is being processed. Please wait...', false);
                            retryCount++;
                            setTimeout(pollTransactionStatus, retryInterval);
                        } else {
                            updateLoadingModal('Payment status check timed out. Please check your M-Pesa for the transaction status.', true);
                            setTimeout(hideLoadingModal, 3000);
                        }
                    },
                    error: function() {
                        updateLoadingModal('Error checking payment status.', true);
                        if (retryCount < maxRetries) {
                            retryCount++;
                            setTimeout(pollTransactionStatus, retryInterval);
                        } else {
                            setTimeout(hideLoadingModal, 2500);
                        }
                    }
                });
            }

            function displaySuccessCard(mpesaReceipt, amount) {
                const successCard = `
                    <div class="card w-96 bg-base-100 shadow-xl mx-auto fade-in">
                        <div class="card-body items-center text-center">
                            <div class="text-6xl mb-4">🎉</div>
                            <h2 class="card-title text-success">Payment Successful!</h2>
                            <p>Your payment of KES ${amount} has been processed.</p>
                            <div class="bg-gray-100 p-4 rounded-lg mt-4">
                                <p class="text-sm text-gray-600">Transaction Code</p>
                                <p class="text-lg font-semibold">${mpesaReceipt}</p>
                            </div>
                        </div>
                    </div>
                `;
                $('#successCard').html(successCard).removeClass('hidden');
                $('#statusMessage').html('');
                $('#paymentForm').hide();
            }
        });
    </script>
<?php include __DIR__ . '/includes/footer.php'; ?>
