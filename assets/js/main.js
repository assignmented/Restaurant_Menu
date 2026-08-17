/* The Black Perch — shared interactions */
(function () {
    'use strict';

    /* ---- Password show/hide toggles ---- */
    document.querySelectorAll('[data-toggle-pwd]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-toggle-pwd');
            var input = document.getElementById(id);
            if (!input) return;
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                if (icon) icon.className = 'fa-solid fa-eye-slash';
            } else {
                input.type = 'password';
                if (icon) icon.className = 'fa-solid fa-eye';
            }
        });
    });

    /* ---- OTP auto-advance ---- */
    var otpBoxes = document.querySelectorAll('.otp-box');
    if (otpBoxes.length) {
        otpBoxes.forEach(function (box, i) {
            box.addEventListener('input', function () {
                box.value = box.value.replace(/\D/g, '').slice(0, 1);
                if (box.value && i < otpBoxes.length - 1) otpBoxes[i + 1].focus();
            });
            box.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !box.value && i > 0) otpBoxes[i - 1].focus();
            });
            box.addEventListener('paste', function (e) {
                var data = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                if (!data) return;
                e.preventDefault();
                data.split('').forEach(function (ch, j) {
                    if (otpBoxes[j]) otpBoxes[j].value = ch;
                });
                var last = Math.min(data.length, otpBoxes.length) - 1;
                if (otpBoxes[last]) otpBoxes[last].focus();
            });
        });
    }

    /* ---- Quantity steppers ---- */
    document.querySelectorAll('[data-stepper]').forEach(function (wrap) {
        var valEl = wrap.querySelector('.val');
        var min = parseInt(wrap.getAttribute('data-min') || '1', 10);
        var max = parseInt(wrap.getAttribute('data-max') || '99', 10);
        var price = parseFloat(wrap.getAttribute('data-price') || '0');
        var val = parseInt(valEl.textContent, 10) || min;
        wrap.querySelector('.minus').addEventListener('click', function () {
            if (val > min) val--;
            render();
        });
        wrap.querySelector('.plus').addEventListener('click', function () {
            if (val < max) val++;
            render();
        });
        function render() {
            valEl.textContent = val;
            var totalEl = document.getElementById('stepperTotal');
            if (totalEl && price) totalEl.textContent = 'KSh. ' + (price * val).toFixed(2);
            var qtyInput = document.getElementById('qtyInput');
            if (qtyInput) qtyInput.value = val;
        }
    });

    /* ---- Splash redirect ---- */
    var splash = document.getElementById('splashRedirect');
    if (splash) {
        var url = splash.getAttribute('data-url');
        var delay = parseInt(splash.getAttribute('data-delay') || '2000', 10);
        setTimeout(function () { window.location.href = url; }, delay);
    }
})();

/* ---- Live search (AJAX, no submit) ----
 * Any input.js-live-search queries search.php as the user types and renders
 * results into its sibling .search-results dropdown. Clicking a result opens
 * the product page. */
(function () {
    'use strict';

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    var inputs = document.querySelectorAll('.js-live-search');
    Array.prototype.forEach.call(inputs, function (input) {
        var wrap = input.closest('.search-input');
        if (!wrap) return;
        var box = wrap.querySelector('.search-results');
        if (!box) {
            box = document.createElement('div');
            box.className = 'search-results';
            wrap.appendChild(box);
        }

        var timer = null;
        var seq = 0; // guard against out-of-order responses

        function render(items) {
            if (!items || !items.length) {
                box.innerHTML = '<div class="sr-empty">No matching items</div>';
                box.classList.add('open');
                return;
            }
            box.innerHTML = items.map(function (it) {
                return '<a class="sr-item" href="product.php?id=' + encodeURIComponent(it.id) + '">' +
                    '<img src="' + escapeHtml(it.img) + '" alt="" loading="lazy">' +
                    '<div class="sr-info">' +
                    '<div class="sr-name">' + escapeHtml(it.name) + '</div>' +
                    '<div class="sr-meta"><i class="fa-solid fa-star"></i> ' + escapeHtml(String(it.rating)) +
                    ' &middot; KSh. ' + escapeHtml(String(it.price)) + '</div>' +
                    '</div></a>';
            }).join('');
            box.classList.add('open');
        }

        function run(term) {
            var params = 'q=' + encodeURIComponent(term);
            var sub = input.getAttribute('data-subcat');
            var cat = input.getAttribute('data-cat');
            if (sub) params += '&subcat=' + encodeURIComponent(sub);
            if (cat) params += '&cat=' + encodeURIComponent(cat);
            var mine = ++seq;
            fetch('search.php?' + params)
                .then(function (r) { return r.json(); })
                .then(function (data) { if (mine === seq) render(data); })
                .catch(function () { if (mine === seq) render([]); });
        }

        input.addEventListener('input', function () {
            var term = input.value.trim();
            clearTimeout(timer);
            if (term.length < 2) {
                box.classList.remove('open');
                box.innerHTML = '';
                return;
            }
            timer = setTimeout(function () { run(term); }, 220);
        });
        input.addEventListener('focus', function () {
            if (box.innerHTML.trim() !== '') box.classList.add('open');
        });
        input.addEventListener('blur', function () {
            // delay so a click on a result registers before we hide
            setTimeout(function () { box.classList.remove('open'); }, 180);
        });
        // allow re-opening by click within the field
        wrap.addEventListener('mousedown', function (e) {
            if (e.target.closest('.sr-item')) return; // let the link navigate
            if (box.innerHTML.trim() !== '') box.classList.add('open');
        });
    });
})();

/* ---- Dining / Rider pill toggle (my-order) ----
 * Mirrors the index.html order-toggle-wrap: <button>s swap the .active pill
 * instantly (no reload), reveal a contextual note + the rider block, and update
 * the delivery cost / total / checkout link live. The choice is persisted to the
 * session via a fire-and-forget GET (my-order.php sets $_SESSION from GET up top)
 * so it survives the +/- quantity reloads. */
(function () {
    'use strict';
    var wrap = document.getElementById('diningToggle');
    if (!wrap) return;

    var DELIVERY_FEE = 2.50;
    var sub = parseFloat(wrap.getAttribute('data-sub')) || 0;
    var diningWrap = document.getElementById('diningWrap');
    var riderBlock = document.getElementById('riderBlock');
    var riderWrap = document.getElementById('riderWrap');
    var noteSpans = wrap.querySelectorAll('.order-note-text');
    var sumDelivery = document.getElementById('sumDelivery');
    var sumTotal = document.getElementById('sumTotal');
    var checkoutLink = document.getElementById('checkoutLink');

    var state = {
        dining: wrap.getAttribute('data-dining') || 'takeaway',
        rider: wrap.getAttribute('data-rider') || 'send'
    };

    function fmt(n) { return 'KSh. ' + n.toFixed(2); }
    function deliveryFor(d, r) {
        if (d === 'eat_in') return 0;
        return r === 'own' ? 0 : DELIVERY_FEE;
    }

    /* Slide the gold thumb to the active button's slot (switch feel). */
    function moveThumb(wrapEl, attr, val) {
        var thumb = wrapEl.querySelector('.order-toggle-thumb');
        if (!thumb) return;
        var idx = 0;
        var btns = wrapEl.querySelectorAll('.order-toggle-btn');
        Array.prototype.forEach.call(btns, function (b, i) {
            if (b.getAttribute(attr) === val) idx = i;
        });
        thumb.style.transform = 'translateX(' + (idx * 100) + '%)';
    }

    function render() {
        Array.prototype.forEach.call(diningWrap.querySelectorAll('.order-toggle-btn'), function (b) {
            b.classList.toggle('active', b.getAttribute('data-dining') === state.dining);
        });
        moveThumb(diningWrap, 'data-dining', state.dining);
        if (riderWrap) {
            Array.prototype.forEach.call(riderWrap.querySelectorAll('.order-toggle-btn'), function (b) {
                b.classList.toggle('active', b.getAttribute('data-rider') === state.rider);
            });
            moveThumb(riderWrap, 'data-rider', state.rider);
        }
        if (riderBlock) riderBlock.hidden = (state.dining !== 'takeaway');
        Array.prototype.forEach.call(noteSpans, function (s) {
            s.hidden = s.getAttribute('data-note') !== state.dining;
        });
        var delivery = deliveryFor(state.dining, state.rider);
        if (sumDelivery) sumDelivery.textContent = fmt(delivery);
        if (sumTotal) sumTotal.textContent = fmt(sub + delivery);
        if (checkoutLink) {
            checkoutLink.href = (state.dining === 'takeaway' && state.rider === 'send')
                ? 'add-delivery-location.php?dining=takeaway&rider=send'
                : 'checkout.php?dining=' + encodeURIComponent(state.dining) + '&rider=' + encodeURIComponent(state.rider);
        }
    }

    function persist() {
        var params = 'dining=' + encodeURIComponent(state.dining);
        if (state.dining === 'takeaway') params += '&rider=' + encodeURIComponent(state.rider);
        fetch('my-order.php?' + params, { credentials: 'same-origin' }).catch(function () {});
    }

    diningWrap.addEventListener('click', function (e) {
        var btn = e.target.closest('.order-toggle-btn');
        if (!btn) return;
        state.dining = btn.getAttribute('data-dining');
        render();
        persist();
    });
    if (riderWrap) {
        riderWrap.addEventListener('click', function (e) {
            var btn = e.target.closest('.order-toggle-btn');
            if (!btn) return;
            state.rider = btn.getAttribute('data-rider');
            render();
            persist();
        });
    }
})();

