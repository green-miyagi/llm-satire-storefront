<?php
/**
 * header.php — site header / layout opener
 * green miyagi style: minimal, low-gloss, breathing space
 */

function render_header(string $title = 'llm satire', string $meta = ''): void {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="an llm satire store. products that may or may not exist. we are not sure either.">
    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?= $meta ?>
</head>
<body>
    <header class="site-header">
        <nav class="nav">
            <a href="/" class="logo">llm satire</a>
            <div class="nav-links">
                <a href="/products.php">products</a>
                <a href="/collections.php">collections</a>
                <a href="/cart.php" class="cart-link">
                    cart
                    <span id="cart-count" class="cart-count">0</span>
                </a>
            </div>
        </nav>
    </header>
    <main class="main">
<?php
}
