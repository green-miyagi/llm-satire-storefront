<?php
// JSON product data endpoint for JS cart rendering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../src/config.php';
require_once __DIR__ . '/../../src/products.php';

$all = load_products();

// If specific slugs requested, filter
$slugs = isset($_GET['slugs']) ? array_filter(explode(',', $_GET['slugs'])) : [];
if (!empty($slugs)) {
    $result = [];
    foreach ($all as $p) {
        if (in_array($p['slug'], $slugs)) {
            $result[$p['slug']] = $p;
        }
    }
    echo json_encode($result);
    exit;
}

// Single slug lookup
$slug = $_GET['slug'] ?? '';
if ($slug) {
    $product = get_product_by_slug($slug);
    if ($product) {
        echo json_encode($product);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'not found']);
    }
    exit;
}

// Return all products keyed by slug
$indexed = [];
foreach ($all as $p) {
    $indexed[$p['slug']] = $p;
}
echo json_encode($indexed);
