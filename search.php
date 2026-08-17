<?php
/**
 * Live-search endpoint.
 *
 * GET q=<term> [&cat=<item_cat_id>] [&subcat=<item_subcat_id>]
 * Returns up to 12 active items whose name matches, as JSON.
 */
require_once __DIR__ . '/config.php';
header('Content-Type: application/json; charset=utf-8');

$q      = isset($_GET['q']) ? trim($_GET['q']) : '';
$cat    = isset($_GET['cat'])    ? (int) $_GET['cat']    : 0;
$subcat = isset($_GET['subcat']) ? (int) $_GET['subcat'] : 0;

// Need at least 2 chars to avoid dumping the whole table.
if ($q === '' || mb_strlen($q) < 2) {
    echo json_encode([]);
    exit;
}

$like   = '%' . $q . '%';
$sql    = 'SELECT item_id, item_name, item_price, item_image, item_rating, item_review, item_time
           FROM items
           WHERE item_status = "1" AND item_name LIKE ?';
$params = [$like];
$types   = 's';
if ($cat > 0) {
    $sql .= ' AND item_cat_id = ?';
    $params[] = $cat;
    $types   .= 'i';
}
if ($subcat > 0) {
    $sql .= ' AND item_subcat_id = ?';
    $params[] = $subcat;
    $types   .= 'i';
}
$sql .= ' ORDER BY item_name ASC LIMIT 12';

$stmt = $conx->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

$out = [];
while ($r = $res->fetch_assoc()) {
    $img = $r['item_image'] !== ''
        ? 'assets/img/img/menu/' . $r['item_image']
        : 'assets/img/black_perch.png'; // placeholder for image-less items
    $out[] = [
        'id'     => (int) $r['item_id'],
        'name'   => $r['item_name'],
        'price'  => (float) $r['item_price'],
        'img'    => $img,
        'rating' => (float) $r['item_rating'],
        'review' => (int) $r['item_review'],
        'time'   => $r['item_time'],
    ];
}
echo json_encode($out);
