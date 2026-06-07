<?php
// Digital file delivery endpoint
// Verifies purchase via Stripe session, then serves the file

require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/stripe.php';
require_once __DIR__ . '/src/products.php';

$session_id = $_GET['session'] ?? '';
$product_slug = $_GET['product'] ?? '';

if (!$session_id || !$product_slug) {
    http_response_code(400);
    echo "missing parameters";
    exit;
}

// Verify the Stripe session was paid
$session = retrieve_checkout_session($session_id);
if (isset($session['error']) || ($session['payment_status'] ?? '') !== 'paid') {
    http_response_code(403);
    echo "purchase not verified";
    exit;
}

// Load product
$product = get_product_by_slug($product_slug);
if (!$product) {
    http_response_code(404);
    echo "product not found";
    exit;
}

// Get file content
$content = get_download_content($product);

// Determine filename and MIME type
$ext = $product['type'] ?? 'md';
$filename = ($product['slug'] ?? 'download') . '.' . $ext;
$content_type = 'text/markdown; charset=utf-8';

switch ($ext) {
    case 'pdf':
        $content_type = 'application/pdf';
        break;
    case 'json':
        $content_type = 'application/json';
        break;
    case 'csv':
        $content_type = 'text/csv';
        break;
    case 'txt':
        $content_type = 'text/plain; charset=utf-8';
        break;
    case 'html':
        $content_type = 'text/html; charset=utf-8';
        break;
    case 'md':
    default:
        $content_type = 'text/markdown; charset=utf-8';
        break;
}

header('Content-Type: ' . $content_type);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($content));
header('Cache-Control: no-cache, must-revalidate');
header('X-Robots-Tag: noindex');

echo $content;
