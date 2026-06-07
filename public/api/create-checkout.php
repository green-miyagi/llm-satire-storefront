<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'method not allowed']);
    exit;
}

require_once __DIR__ . '/../../src/config.php';
require_once __DIR__ . '/../../src/stripe.php';
require_once __DIR__ . '/../../src/products.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || empty($input['items'])) {
    http_response_code(400);
    echo json_encode(['error' => 'no items']);
    exit;
}

$base_url = getenv('SITE_URL') ?: 'http://localhost:8080';
$site_name = getenv('SITE_NAME') ?: 'aillm satire';

$line_items = [];
$total_tokens = 0;
$product_names = [];

foreach ($input['items'] as $item) {
    $product = get_product_by_slug($item['slug']);
    if (!$product) continue;

    $qty = max(1, (int)($item['quantity'] ?? 1));
    $line_items[] = [
        'name' => $product['name'],
        'description' => $product['description'],
        'amount_cents' => $product['price_cents'],
        'quantity' => $qty,
        'slug' => $product['slug'],
    ];

    $total_tokens += (int)str_replace('.', '', str_replace('k', '', $product['token_price'])) * $qty;
    $product_names[] = $product['name'];
}

if (empty($line_items)) {
    http_response_code(400);
    echo json_encode(['error' => 'no valid products']);
    exit;
}

$success_url = rtrim($base_url, '/') . '/checkout.php?session_id={CHECKOUT_SESSION_ID}';
$cancel_url = rtrim($base_url, '/') . '/cart.php';

$result = create_checkout_session($line_items, $success_url, $cancel_url);

if (isset($result['error'])) {
    http_response_code(500);
    echo json_encode(['error' => $result['error']]);
    exit;
}

echo json_encode([
    'url' => $result['url'],
    'session_id' => $result['id'],
    'total_tokens' => $total_tokens . 'k',
]);
