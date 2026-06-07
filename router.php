<?php
// PHP built-in dev server router
// Mirrors .htaccess rewrite rules for local development
// Usage: php -S localhost:8080 -t . router.php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Serve existing files directly
$file = __DIR__ . $uri;
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

// Pretty product URLs: /product/slug → product.php?slug=slug
if (preg_match('#^/product/([a-zA-Z0-9_-]+)$#', $uri, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/product.php';
    return true;
}

// Route /api/products.json → products.json.php
if ($uri === '/api/products.json') {
    require __DIR__ . '/api/products.json.php';
    return true;
}

// Default: serve index.php
require __DIR__ . '/index.php';
return true;
