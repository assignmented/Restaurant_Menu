<?php
/**
 * The Black Perch — global config.
 *
 * The project's PHP focuses on three flows: the splash screen, the onboarding
 * slides, and adding to cart. This file boots the session, defines the brand +
 * onboarding cookie helpers, the session-backed cart helpers, and the mock
 * catalog the browse/cart pages render. There is no database or auth layer.
 */

/* ---------- Session ----------
 * One shared session for the cart (and the onboarding visit cookie state).
 * Cookie is httponly + SameSite=Strict; secure when served over TLS. The ID is
 * rotated once per session to limit fixation windows. */
$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'); // behind a TLS proxy in prod

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,                 // session cookie (cleared on browser close)
        'path'     => '/',
        'httponly' => true,
        'secure'   => $is_https,
        'samesite' => 'Strict',
    ]);
    session_start();

    if (empty($_SESSION['_booted'])) {
        session_regenerate_id(true);
        $_SESSION['_booted'] = true;
    }
}

/**
 * Force HTTPS in production. No-op on localhost (where XAMPP often runs plain
 * HTTP), so dev isn't broken. Call once at the top of any entry page if you
 * want a hard redirect to https:// — login-process.php is the critical one.
 *
 * NOTE: this only helps once the server actually has a TLS cert configured.
 * On XAMPP, enable Apache mod_ssl + the default cert, or front the app with
 * a TLS-terminating proxy in production.
 */
function enforce_https(): void {
    $is_localhost = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
    $already_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    if ($already_https || $is_localhost) {
        return;
    }
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $uri  = $_SERVER['REQUEST_URI'] ?? '';
    header('Location: https://' . $host . $uri, true, 301);
    exit;
}

/* ---------- Database (PDO singleton) ----------
 * Centralized connection so every page/handler gets the same instance.
 * Credentials live here for now; move to a .env + getenv() before this
 * leaves your local machine. utf8mb4 matches the schema in assets/db/db.sql.
 */
    $envPath = __DIR__ . '/.env';
    if (!file_exists($envPath)) {
        die("Unable to locate .env file at: $envPath");
    }

    $env = parse_ini_file($envPath);
    
    // Daraja API configuration
    $consumer_key = $env["SECURE_CK"];
    $consumer_secret = $env["SECURE_CS"];
    $business_short_code = '6205829'; //Store Number
    $passkey = $env["SECURE_PK"];
    $callback_url = 'https://theblackperch.co.ke/payment/mpesa_callback.php';

    $local_host = $env["LOCAL_HOST"];
    $local_root = $env["LOCAL_ROOT"];
    $local_pass = $env["LOCAL_PASS"];
    $local_data = $env["LOCAL_DATA"];

    $conx = mysqli_connect($local_host, $local_root, $local_pass, $local_data);
    $conx->set_charset("utf8");

    if (!$conx) {
        die("Connection failed: " . mysqli_connect_error());
    }


/* ---------- Brand ---------- */
define('BRAND_NAME', 'The Black Perch');
define('BRAND_TAGLINE', 'FOOD DELIVERY');
define('BRAND_PRIMARY', '#ffd168');     // orange
define('BRAND_PRIMARY_DK', '#f5b942');
define('BRAND_DARK', '#3f2d16');        // dark text
define('BRAND_MUTED', '#9CA3AF');
define('BRAND_BG', '#010101');

/* ---------- Onboarding cookie ----------
 * So returning visitors skip the onboarding slides. index.php (splash) reads
 * has_onboarded() to route; onboard-live-tracking.php calls mark_onboarded(). */
define('ONBOARD_COOKIE', 'tbp_onboarded');   // set once onboarding completes
define('VISIT_COOKIE', 'tbp_visited');       // set on first splash visit
define('COOKIE_DAYS', 30);

/** True if this visitor has seen the onboarding before (cookie present). */
function has_onboarded(): bool {
    return isset($_COOKIE[ONBOARD_COOKIE]) && $_COOKIE[ONBOARD_COOKIE] === '1';
}

/** Mark onboarding complete so the slides are never shown again. */
function mark_onboarded(): void {
    setcookie(ONBOARD_COOKIE, '1', time() + (COOKIE_DAYS * 86400), '/');
    $_COOKIE[ONBOARD_COOKIE] = '1';
}

/** Mark the visitor as having visited (used by splash to decide routing). */
function mark_visited(): void {
    if (!isset($_COOKIE[VISIT_COOKIE])) {
        setcookie(VISIT_COOKIE, '1', time() + (COOKIE_DAYS * 86400), '/');
        $_COOKIE[VISIT_COOKIE] = '1';
    }
}

/*----------------FUNCTION CHECK IF ITS MORNING, AFTERNOON OR EVENING--------------------*/
function getTheTimeOfDay(): string {
    date_default_timezone_set('Africa/Nairobi');

    // 2. Get the current hour in 24-hour format (0 through 23)
    $current_hour = (int)date('G');

    // 3. Evaluate the time period
    if ($current_hour >= 5 && $current_hour < 12) {
        return 'Morning';
    } elseif ($current_hour >= 12 && $current_hour < 16) {
        return 'Afternoon';
    } elseif ($current_hour >= 16 && $current_hour < 21) {
        return 'Evening';
    } else {
        return 'Night';
    }
}

/* ---------- Cart helpers (session-backed) ----------
 * $_SESSION['cart'] is keyed by item id; each entry holds id, name, price, img,
 * qty. cart/add.php, cart/update.php, and cart/remove.php mutate it. */
function cart(): array {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}
function cart_count(): int {
    return array_sum(array_column(cart(), 'qty')) ?: 0;
}
function cart_total(): float {
    $total = 0;
    foreach (cart() as $item) {
        $total += $item['price'] * $item['qty'];
    }
    return $total;
}

/* ---------- Placeholder user ----------
 * No auth exists; this just feeds checkout.php / profile.php static placeholder
 * values so their design renders. */
function current_user(): array {
    return [
        'user_name'     => 'Guest',
        'user_email'    => 'guest@example.com',
        'user_address'  => '14 Harborline Wharf, Dockside District',
        'user_mobile'   => '071 234 5678',
    ];
}

/* ---------- Catalog (mock data) ----------
 * Static data the browse + cart pages render until a real backend exists. */

function subcategories(){
    $stmt = db()->prepare(
        'SELECT *
         FROM subcategories
         ORDER BY subcat_name ASC
         WHERE subcat_status = :email'
    );
    $stmt->execute([':email' => 1]);
    $subcats = $stmt->fetch();
}


/* ---------- Categories ---------- */
function categories() {
    return [
        ['slug'=>'offers',     'name'=>'Offers',      'icon'=>'bi-tag-fill',         'count'=>25],
        ['slug'=>'sri-lankan', 'name'=>'Sri Lankan',  'icon'=>'bi-egg-fried',        'count'=>140],
        ['slug'=>'italian',    'name'=>'Italian',     'icon'=>'bi-pie-chart-fill',   'count'=>86],
        ['slug'=>'indian',     'name'=>'Indian',      'icon'=>'bi-cup-straw',        'count'=>64],
        ['slug'=>'desserts',   'name'=>'Desserts',    'icon'=>'bi-cake2-fill',       'count'=>55],
        ['slug'=>'beverages',  'name'=>'Beverages',   'icon'=>'bi-cup-hot-fill',     'count'=>40],
        ['slug'=>'burgers',    'name'=>'Burgers',     'icon'=>'bi-egg-fill',         'count'=>38],
        ['slug'=>'chinese',    'name'=>'Chinese',     'icon'=>'bi-bowl-rice',        'count'=>72],
    ];
}

/* ---------- Restaurants ---------- */
function restaurants() {
    return [
        ['id'=>1,'name'=>'Byte & Grill',      'rating'=>4.8,'reviews'=>230,'cuisine'=>['Burgers','Grill'],'time'=>'25 min','img'=>'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80'],
        ['id'=>2,'name'=>'Golden Wok',        'rating'=>4.6,'reviews'=>180,'cuisine'=>['Chinese','Asian'],'time'=>'30 min','img'=>'https://images.unsplash.com/photo-1525755662778-989d0524087e?w=600&q=80'],
        ['id'=>3,'name'=>'Pizzeria Marino',   'rating'=>4.9,'reviews'=>412,'cuisine'=>['Italian','Pizza'],'time'=>'22 min','img'=>'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&q=80'],
        ['id'=>4,'name'=>'Spice Route',       'rating'=>4.5,'reviews'=>156,'cuisine'=>['Indian','Curry'],'time'=>'35 min','img'=>'https://images.unsplash.com/photo-1585937421612-70a0080a4fdf?w=600&q=80'],
        ['id'=>5,'name'=>'Sugar & Co',        'rating'=>4.7,'reviews'=>98, 'cuisine'=>['Desserts','Bakery'],'time'=>'20 min','img'=>'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=600&q=80'],
        ['id'=>6,'name'=>'Harbor Bowls',      'rating'=>4.4,'reviews'=>121,'cuisine'=>['Healthy','Bowls'],'time'=>'28 min','img'=>'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=600&q=80'],
    ];
}

/* ---------- Products ---------- */
function products() {
    return [
        ['id'=>101,'name'=>'Beef Burger',        'by'=>'Byte & Grill',    'cat'=>'Burgers','price'=>16.00,'img'=>'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&q=80','rating'=>4.8],
        ['id'=>102,'name'=>'Margherita Pizza',   'by'=>'Pizzeria Marino', 'cat'=>'Italian','price'=>18.50,'img'=>'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&q=80','rating'=>4.9],
        ['id'=>103,'name'=>'Chicken Kottu',      'by'=>'Spice Route',     'cat'=>'Sri Lankan','price'=>9.50,'img'=>'https://images.unsplash.com/photo-1631292784640-2b24be784d5d?w=600&q=80','rating'=>4.6],
        ['id'=>104,'name'=>'Veg Fried Rice',     'by'=>'Golden Wok',      'cat'=>'Chinese','price'=>8.00,'img'=>'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80','rating'=>4.5],
        ['id'=>105,'name'=>'Butter Chicken',     'by'=>'Spice Route',     'cat'=>'Indian','price'=>12.00,'img'=>'https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?w=600&q=80','rating'=>4.7],
        ['id'=>106,'name'=>'Chocolate Lava Cake','by'=>'Sugar & Co',      'cat'=>'Desserts','price'=>7.00,'img'=>'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=600&q=80','rating'=>4.8],
        ['id'=>107,'name'=>'Dragon Bowl',        'by'=>'Harbor Bowls',    'cat'=>'Healthy','price'=>13.50,'img'=>'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=600&q=80','rating'=>4.4],
        ['id'=>108,'name'=>'Pepperoni Pizza',    'by'=>'Pizzeria Marino', 'cat'=>'Italian','price'=>19.00,'img'=>'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=600&q=80','rating'=>4.7],
    ];
}

/** Find a single product by id. */
function find_product($id) {
    foreach (products() as $p) if ($p['id'] == $id) return $p;
    return null;
}

/**
 * Fetch a single item from the `items` table by id, mapped to the same shape
 * the mock products() use (id/name/img/price/rating/by/cat) plus a description.
 * Category + brand names come in via JOINs. Returns null if not found.
 */
function find_item($id) {
    global $conx;
    if (!isset($conx) || !$conx) {
        return null;
    }
    $id = (int) $id;
    $stmt = $conx->prepare(
        'SELECT i.item_id, i.item_name, i.item_price, i.item_image, i.item_rating,
                i.item_description, c.cat_name, b.brand_name
         FROM items i
         LEFT JOIN category c ON c.cat_id = i.item_cat_id
         LEFT JOIN brands   b ON b.brand_id = i.item_brand_id
         WHERE i.item_id = ? AND i.item_status = "1"
         LIMIT 1'
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if (!$r) {
        return null;
    }
    return [
        'id'     => (int) $r['item_id'],
        'name'   => $r['item_name'],
        'img'    => $r['item_image'] !== ''
            ? 'assets/img/img/menu/' . $r['item_image']
            : 'assets/img/black_perch.png',
        'price'  => (float) str_replace(',', '', $r['item_price']),
        'rating' => (float) $r['item_rating'],
        'by'     => $r['brand_name'] ?? '',
        'cat'    => $r['cat_name'] ?? '',
        'desc'   => $r['item_description'] ?? '',
    ];
}

/** Products filtered by category slug/name (case-insensitive match). */
function products_by_category($type) {
    $map = ['desserts'=>'Desserts','beverages'=>'Beverages','italian'=>'Italian','indian'=>'Indian','sri-lankan'=>'Sri Lankan','chinese'=>'Chinese','burgers'=>'Burgers','offers'=>'Offers'];
    $want = $map[strtolower($type)] ?? ucfirst($type);
    return array_values(array_filter(products(), fn($p)=>strcasecmp($p['cat'],$want)===0));
}
