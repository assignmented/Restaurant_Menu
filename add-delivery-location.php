<?php
/** Delivery location picker — drop a pin for "Send your rider" orders.
 *  Reached from my-order.php when dining=takeaway & rider=send. The picked
 *  address is stored in $_SESSION['delivery_address'] and the user continues
 *  to checkout. */
require_once __DIR__ . '/config.php';

// AJAX: store the picked delivery address in session (called by confirmLocation()).
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'])) {
    $_SESSION['delivery_address'] = [
        'address' => trim((string) $_POST['address']),
        'lat'     => isset($_POST['lat']) ? (float) $_POST['lat'] : null,
        'lng'     => isset($_POST['lng']) ? (float) $_POST['lng'] : null,
    ];
    header('Content-Type: application/json');
    echo json_encode(['ok' => true]);
    exit;
}

$dining = $_GET['dining'] ?? ($_SESSION['dining'] ?? 'takeaway');
if (!in_array($dining, ['eat_in', 'takeaway'], true)) {
    $dining = 'takeaway';
}
$rider = $_GET['rider'] ?? ($_SESSION['rider'] ?? 'send');
if (!in_array($rider, ['own', 'send'], true)) {
    $rider = 'send';
}

$active = '';
$pageTitle = 'Delivery Location';
$canonical = 'add-delivery-location.php';
include __DIR__ . '/includes/header.php';
?>
<div class="app-bar">
    <a href="my-order.php" class="btn-icon" aria-label="Back"><i class="fa-solid fa-arrow-left"></i></a>
    <h1>Delivery Location</h1>
    <span class="spacer"></span>
</div>

<div class="delivery-map-wrap">
    <!-- Search + locate -->
    <div class="delivery-top">
        <div class="delivery-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="addressInput" placeholder="Search for an address or area…" autocomplete="off">
        </div>
        <button type="button" class="map-btn" id="currentLocationBtn" title="Use my location" aria-label="Use my location">
            <i class="fa-solid fa-location-crosshairs"></i>
            <span class="map-btn-label">Use my location</span>
        </button>
    </div>

    <div id="map"></div>

    <!-- Floating centre pin: stays fixed while the map pans under it -->
    <div class="picker-pin" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="56" viewBox="0 0 40 52">
            <path d="M20 0C9 0 0 9 0 20c0 14 20 32 20 32s20-18 20-32C40 9 31 0 20 0z" fill="#f5b942" stroke="#fff" stroke-width="2.5"/>
            <circle cx="20" cy="20" r="8" fill="#3f2d16"/>
        </svg>
    </div>

    <!-- Bottom sheet: selected address + continue -->
    <div class="delivery-sheet glass-card">
        <div class="result" id="result">
            <strong>Locating…</strong>
            <span>Drag the pin, search, or use your current location.</span>
        </div>
        
        <?php if (cart_count() > 0): ?>        
            <button type="button" class="btn-primary-2" id="confirmBtn" disabled>Confirm &amp; Continue to Checkout</button>
        <?php endif; ?>
    </div>
</div>

<script>
    const CHECKOUT_URL = 'checkout.php?dining=<?= htmlspecialchars($dining) ?>&rider=<?= htmlspecialchars($rider) ?>';
    // Fallback centre if geolocation is unavailable — Meru, Kenya.
    const DEFAULT_CENTER = { lat: 0.0470, lng: 37.6559 };

    let map, geocoder, autocomplete;
    let picked = null; // { address, lat, lng }
    let nextSource = 'pin'; // source badge for the next idle reverse-geocode

    // Custom map style (clean & property-friendly) — ported from test2.php.
    const customMapStyles = [
        { featureType: "administrative", elementType: "geometry.fill", stylers: [{ color: "#d6e2e6" }] },
        { featureType: "administrative", elementType: "geometry.stroke", stylers: [{ color: "#cddbe0" }] },
        { featureType: "administrative", elementType: "labels.text.fill", stylers: [{ color: "#7492a8" }] },
        { featureType: "administrative.neighborhood", elementType: "labels.text.fill", stylers: [{ lightness: 25 }] },
        { featureType: "administrative.land_parcel", elementType: "labels", stylers: [{ visibility: "off" }] },
        { featureType: "landscape.man_made", elementType: "geometry.fill", stylers: [{ color: "#d6e2e6" }] },
        { featureType: "landscape.man_made", elementType: "geometry.stroke", stylers: [{ color: "#cddbe0" }] },
        { featureType: "landscape.natural", elementType: "geometry.fill", stylers: [{ color: "#dae6eb" }] },
        { featureType: "landscape.natural", elementType: "labels.text.fill", stylers: [{ color: "#7492a8" }] },
        { featureType: "landscape.natural.terrain", elementType: "all", stylers: [{ visibility: "off" }] },
        { featureType: "poi", elementType: "geometry.fill", stylers: [{ color: "#d6e2e6" }] },
        { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#588ca4" }] },
        { featureType: "poi", elementType: "labels.icon", stylers: [{ saturation: -100 }] },
        { featureType: "poi.park", elementType: "geometry.fill", stylers: [{ color: "#cae7a8" }] },
        { featureType: "poi.park", elementType: "geometry.stroke", stylers: [{ color: "#bae6a1" }] },
        { featureType: "poi.sports_complex", elementType: "geometry.fill", stylers: [{ color: "#c6e8b3" }] },
        { featureType: "poi.sports_complex", elementType: "geometry.stroke", stylers: [{ color: "#bae6a1" }] },
        { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#41626b" }] },
        { featureType: "road", elementType: "labels.icon", stylers: [{ saturation: -45 }, { lightness: 10 }, { visibility: "off" }] },
        { featureType: "road.highway", elementType: "geometry.fill", stylers: [{ color: "#f7fdff" }] },
        { featureType: "road.highway", elementType: "geometry.stroke", stylers: [{ color: "#beced4" }] },
        { featureType: "road.arterial", elementType: "geometry.fill", stylers: [{ color: "#eef3f5" }] },
        { featureType: "road.arterial", elementType: "geometry.stroke", stylers: [{ color: "#cddbe0" }] },
        { featureType: "road.local", elementType: "geometry.fill", stylers: [{ color: "#edf3f5" }] },
        { featureType: "road.local", elementType: "geometry.stroke", stylers: [{ color: "#cddbe0" }] },
        { featureType: "road.local", elementType: "labels", stylers: [{ visibility: "off" }] },
        { featureType: "transit", elementType: "labels.icon", stylers: [{ saturation: -70 }] },
        { featureType: "transit.line", elementType: "labels.text.fill", stylers: [{ color: "#588ca4" }] },
        { featureType: "transit.station", elementType: "labels.text.fill", stylers: [{ color: "#008cb5" }] },
        { featureType: "transit.station.airport", elementType: "geometry.fill", stylers: [{ saturation: -100 }, { lightness: -5 }] },
        { featureType: "water", elementType: "geometry.fill", stylers: [{ color: "#a6cbe3" }] }
    ];

    function toast(msg, isError) {
        const existing = document.querySelector('.notification-toast');
        if (existing) existing.remove();
        const t = document.createElement('div');
        t.className = 'notification-toast';
        t.textContent = msg;
        t.style.cssText = 'position:fixed;left:50%;bottom:140px;transform:translateX(-50%);background:' +
            (isError ? '#C5221F' : 'var(--bp-card-2)') + ';color:#fff;padding:10px 16px;border-radius:999px;' +
            'font-size:.85rem;z-index:2000;box-shadow:0 4px 14px rgba(0,0,0,.4);border:1px solid var(--bp-line);';
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 2600);
    }

    // Surface a fatal map error in the bottom sheet so the cause is visible.
    function fatalMapError(msg) {
        console.error('[map] ' + msg);
        const r = document.getElementById('result');
        if (r) r.innerHTML = '<strong>Map error</strong><span>' + msg + '</span>';
        const btn = document.getElementById('confirmBtn');
        if (btn) btn.disabled = true;
        const locBtn = document.getElementById('currentLocationBtn');
        if (locBtn) locBtn.disabled = true;
    }

    // Google calls this when the API key is rejected (invalid / referrer not
    // allowed / billing or API not enabled). Same key works for /Shift, so the
    // usual cause here is a referrer restriction that doesn't include Black Perch.
    window.gm_authFailure = function () {
        fatalMapError('Google Maps rejected the API key. In Google Cloud Console → APIs & Services → Credentials, ' +
            'edit the key and add this site to the allowed referrers: http://localhost/Black%20Perch/* ' +
            '(or broaden to http://localhost/*).');
    };

    window.initMap = function () {
      try {
        geocoder = new google.maps.Geocoder();

        map = new google.maps.Map(document.getElementById('map'), {
            center: DEFAULT_CENTER,
            zoom: 15,
            disableDefaultUI: true,
            zoomControl: true,
            styles: customMapStyles,
            gestureHandling: 'greedy'
        });

        // The picker is a fixed, floating pin at the map's centre (an overlay,
        // not a map marker) — you drag the map under it. Reverse-geocode the
        // centre whenever the map settles, so the card updates as you pan.
        map.addListener('idle', () => {
            reverseGeocode(map.getCenter(), nextSource);
            nextSource = 'pin';
        });

        // Address search (Places Autocomplete).
        const input = document.getElementById('addressInput');
        if (google.maps.places && google.maps.places.Autocomplete) {
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;
                nextSource = 'pin';
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            });
        } else {
            fatalMapError('Places library failed to load. Enable the Places API for this key in Google Cloud Console.');
        }

        document.getElementById('currentLocationBtn').addEventListener('click', () => useMyLocation(false));
        document.getElementById('confirmBtn').addEventListener('click', confirmLocation);

        // Auto-center on the user's current location on load (indicated on the
        // card). useMyLocation falls back to the default centre if geolocation
        // is unavailable/denied.
        document.getElementById('result').innerHTML =
            '<strong>Locating your current location…</strong><span>Allow location access to centre the map on you.</span>';
        useMyLocation(true);
      } catch (e) {
        fatalMapError('initMap failed: ' + (e && e.message ? e.message : e));
      }
    };

    function reverseGeocode(latLng, source) {
        geocoder.geocode({ location: latLng }, (results, status) => {
            if (status === 'OK' && results[0]) {
                setResult(results[0].formatted_address, latLng, source);
            } else {
                setResult('Address not found — pin saved by coordinates.', latLng, source);
            }
        });
    }

    function setResult(address, latLng, source) {
        const lat = typeof latLng.lat === 'function' ? latLng.lat() : latLng.lat;
        const lng = typeof latLng.lng === 'function' ? latLng.lng() : latLng.lng;
        picked = { address, lat, lng };
        const badge = source === 'current'
            ? '<div class="loc-badge"><i class="fa-solid fa-location-crosshairs"></i> Current location</div>'
            : '';
        document.getElementById('result').innerHTML =
            badge + '<strong>' + address + '</strong><span>Lat ' + lat.toFixed(5) + ', Lng ' + lng.toFixed(5) + '</span>';
        document.getElementById('confirmBtn').disabled = false;
    }

    function useMyLocation(silent) {
        if (!navigator.geolocation) {
            if (!silent) toast('Geolocation not supported', true);
            return;
        }
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const p = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                nextSource = 'current';
                map.setCenter(p);
                map.setZoom(17); // idle fires → reverseGeocode(center, 'current')
            },
            () => { if (!silent) toast('Could not get your location. Allow access or drag the pin.', true); },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    }

    function confirmLocation() {
        if (!picked) return;
        const btn = document.getElementById('confirmBtn');
        btn.disabled = true;
        btn.textContent = 'Saving…';
        const body = new URLSearchParams({ address: picked.address, lat: picked.lat, lng: picked.lng });
        fetch('add-delivery-location.php', { method: 'POST', body: body, credentials: 'same-origin' })
            .then((r) => r.json())
            .then(() => { window.location.href = CHECKOUT_URL; })
            .catch(() => {
                toast('Could not save location. Try again.', true);
                btn.disabled = false;
                btn.textContent = 'Confirm & Continue to Checkout';
            });
    }

    function showKeyMissing() {
        document.getElementById('result').innerHTML =
            '<strong>Map unavailable</strong><span>Set a Google Maps API key (GOOGLE_MAPS_API_KEY in .env or env) to enable the map.</span>';
        document.getElementById('currentLocationBtn').disabled = true;
    }

    async function loadGoogleMaps() {
        try {
            const response = await fetch('maps-config.php');
            const config = await response.json();
            if (!config.googleMapsKey) { showKeyMissing(); return; }
            const s = document.createElement('script');
            s.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(config.googleMapsKey) +
                    '&libraries=places,geometry&callback=initMap';
            s.async = true;
            s.defer = true;
            document.head.appendChild(s);
        } catch (e) {
            showKeyMissing();
        }
    }
    loadGoogleMaps();
</script>

<style>
    .delivery-map-wrap{position:relative;height:calc(100dvh - 160px);overflow:hidden;background:var(--bp-card);}
    #map{position:absolute;inset:0;width:100%;height:100%;background:var(--bp-card);}
    .picker-pin{position:absolute;top:50%;left:50%;transform:translate(-50%,-100%);z-index:4;pointer-events:none;
        filter:drop-shadow(0 6px 8px rgba(0,0,0,.45));animation:pinDrop .35s ease;}
    @keyframes pinDrop{from{transform:translate(-50%,-160%);opacity:0;}to{transform:translate(-50%,-100%);opacity:1;}}
    .delivery-top{position:absolute;top:12px;left:12px;right:12px;z-index:5;display:flex;gap:8px;}
    .delivery-search{position:relative;flex:1;display:flex;align-items:center;gap:.5rem;
        padding:.6rem .9rem;background:var(--bp-card);border:1px solid var(--bp-line);
        border-radius:999px;box-shadow:0 4px 14px rgba(0,0,0,.35);}
    .delivery-search i{color:var(--bp-muted);}
    .delivery-search input{flex:1;background:transparent;border:0;outline:0;color:#fff;font-size:.95rem;min-width:0;}
    .delivery-search input::placeholder{color:var(--bp-muted);}
    .map-btn{flex:0 0 auto;width:44px;height:44px;border-radius:50%;border:1px solid var(--bp-line);
        background:var(--bp-card);color:var(--bp-primary);cursor:pointer;box-shadow:0 4px 14px rgba(0,0,0,.35);
        display:flex;align-items:center;justify-content:center;font-size:1rem;white-space:nowrap;}
    .map-btn .map-btn-label{display:none;}
    .map-btn:hover{background:#222227;}
    .map-btn:disabled{opacity:.4;cursor:not-allowed;}
    @media (min-width:992px){
        .map-btn{width:auto;height:44px;padding:0 1rem;border-radius:999px;gap:.5rem;}
        .map-btn .map-btn-label{display:inline;font-size:.85rem;font-weight:600;}
    }
    .delivery-sheet{position:absolute;left:12px;right:12px;bottom:calc(74px + env(safe-area-inset-bottom));
        z-index:5;padding:1rem;border-radius:20px;}
    .delivery-sheet .result{margin-bottom:.75rem;}
    .delivery-sheet .result strong{display:block;color:#fff;font-size:.95rem;margin-bottom:.2rem;}
    .delivery-sheet .result span{color:var(--bp-muted);font-size:.78rem;}
    .delivery-sheet .loc-badge{display:inline-flex;align-items:center;gap:.3rem;font-size:.7rem;font-weight:700;
        color:var(--bp-primary);background:rgba(255,209,104,.12);border:1px solid rgba(255,209,104,.35);
        padding:.2rem .55rem;border-radius:999px;margin-bottom:.45rem;}
    @media (min-width:992px){ .delivery-sheet{bottom:12px;} }
</style>
<?php include __DIR__ . '/includes/footer.php'; ?>
