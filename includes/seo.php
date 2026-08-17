<?php
/**
 * The Black Perch — SEO metadata partial.
 *
 * Include inside <head> (after $pageTitle is set). Pages may override the
 * defaults by setting any of these BEFORE including includes/header.php:
 *
 *   $metaDescription  string   page-specific description
 *   $metaKeywords     string   page-specific keywords
 *   $canonical        string   path only, e.g. 'home.php' or 'product.php?id=101'
 *   $metaImage        string   root-relative or absolute image URL
 *   $ogType           string   'website' (default) | 'article' (product/detail)
 *   $noindex          bool     true to keep a page out of the index
 *
 * Brand: The Black Perch — food delivery in Meru, Kenya.
 * TODO: replace SITE_URL with the live domain before going to production.
 */

if (!defined('SITE_URL')) {
    define('SITE_URL', 'https://www.theblackperch.co.ke');
}
if (!defined('SITE_LOGO')) {
    define('SITE_LOGO', SITE_URL . '/assets/img/black_perch.png');
}

/* ---- Defaults (Meru food-delivery positioning) ---- */
$metaDescription = $metaDescription ?? (
    BRAND_NAME . ' — Meru\'s premier food delivery app. '
    . 'Indian, Nyama Choma, Pizzas, Burgers, French Fries & beverages from the top restaurant in Meru, '
    . 'Kenya. Fast doorstep delivery, real-time order tracking, pay with M-Pesa.'
);

$metaKeywords = $metaKeywords ?? (
    'Meru, Kinoru, MEWASS, Villa Vista, Villa Vista Meru, BVB Meru, The Pin,The Pin Meru,'
    . 'Jazz, Jazz Meru, Tash Aqua, Tash Aqua Meru, 7/11, 7/11 Meru, Chill Spot, Meru Slopes,'
    . 'Alba Hotel, The Hotel Ezri, Three Steers Meru, Paramount Hotel, West Wind Hotel,'
    . 'Food delivery Meru, Meru food delivery, order food online Meru Kenya, '
    . 'The Black Perch, restaurant delivery Meru town, nyama choma Meru, mukimo, '
    . 'Clubs in Meru, Best Clubs in Meru, Barbershop, Car Services, githeri, irio, fast food Meru, M-Pesa food delivery, online food order Kenya,'
    . 'Spa, Coffee, Ice Cream,Ice Cream Parlor, Meru Restaurant, Restaurants in Meru, '
    . 'pizza delivery Meru, burger delivery Meru, late night food Meru'
);

$script   = ltrim(basename($_SERVER['SCRIPT_NAME'] ?? ''), '/');
$query    = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== ''
    ? '?' . $_SERVER['QUERY_STRING']
    : '';
$canonical = $canonical
    ? SITE_URL . '/' . ltrim($canonical, '/')
    : SITE_URL . '/' . $script . $query;

$ogType    = $ogType ?? 'website';
$noindex   = $noindex ?? false;
$metaImage = isset($metaImage)
    ? (preg_match('#^https?://#', $metaImage) ? $metaImage : SITE_URL . '/' . ltrim($metaImage, '/'))
    : SITE_LOGO;

$escDesc = htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8');
$robots  = $noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large, max-snippet:-1';
?>
    <meta name="description" content="<?= $escDesc ?>">
    <meta name="keywords" content="<?= htmlspecialchars($metaKeywords, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="author" content="<?= htmlspecialchars(BRAND_NAME) ?>">
    <meta name="robots" content="<?= $robots ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">

    <!-- Geo: anchors the brand to Meru, Kenya for local search -->
    <meta name="geo.region" content="KE">
    <meta name="geo.placename" content="Meru, Kenya">
    <meta name="geo.position" content="-0.0463;37.6459">
    <meta name="ICBM" content="-0.0463, 37.6459">

    <!-- Open Graph -->
    <meta property="og:site_name" content="<?= htmlspecialchars(BRAND_NAME) ?>">
    <meta property="og:type" content="<?= htmlspecialchars($ogType) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= $escDesc ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($metaImage, ENT_QUOTES) ?>">
    <meta property="og:image:alt" content="<?= htmlspecialchars(BRAND_NAME) ?> — food delivery in Meru, Kenya">
    <meta property="og:locale" content="en_KE">
    <meta property="og:price_currency" content="KES">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
    <meta name="twitter:description" content="<?= $escDesc ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($metaImage, ENT_QUOTES) ?>">
    <meta name="twitter:image:alt" content="<?= htmlspecialchars(BRAND_NAME) ?> — food delivery in Meru, Kenya">

    <!-- JSON-LD: Restaurant (LocalBusiness) -->
    <script type="application/ld+json">
    <?= json_encode([
        '@context' => 'https://schema.org',
        '@type'    => 'Restaurant',
        'name'     => BRAND_NAME,
        'image'    => SITE_LOGO,
        'logo'     => SITE_LOGO,
        'url'      => SITE_URL,
        'telephone'=> '+254712345678',
        'servesCuisine' => ['Sri Lankan','Italian','Indian','Chinese','Burgers','Desserts','Beverages','Kenyan'],
        'priceRange' => 'KSh',
        'currenciesAccepted' => 'KES',
        'paymentAccepted'    => 'M-Pesa, Cash, Card',
        'acceptsReservations'=> 'False',
        'address' => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Meru Town',
            'addressLocality' => 'Meru',
            'addressRegion'   => 'Meru County',
            'postalCode'      => '60200',
            'addressCountry'  => 'KE',
        ],
        'geo' => ['@type' => 'GeoCoordinates', 'latitude' => -0.0463, 'longitude' => 37.6459],
        'openingHoursSpecification' => [[
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
            'opens'     => '08:00',
            'closes'    => '23:00',
        ]],
        'areaServed' => ['@type' => 'City', 'name' => 'Meru'],
        'sameAs'     => [],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
    </script>

    <!-- JSON-LD: WebSite + search action -->
    <script type="application/ld+json">
    <?= json_encode([
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => BRAND_NAME,
        'url'      => SITE_URL,
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => SITE_URL . '/search.php?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
    </script>
