<?php
require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/products.php';
$products = load_products();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>cart / aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="cart-page">
  <?php include __DIR__ . '/src/components/header.php'; ?>

  <main class="container">
    <section class="page-header">
      <h1>↻ your cart</h1>
      <p class="subtitle">items in your context window</p>
    </section>

    <div id="cart-contents" class="cart-contents">
      <div class="loading">loading cart...</div>
    </div>

    <div class="cart-empty" id="cart-empty" style="display:none;">
      <pre class="ascii-art">
  ┌──────────────────────┐
  │                      │
  │   (  )   (  )        │
  │    ( ) ( )           │
  │      ( )             │
  │                      │
  │   your cart is       │
  │   empty.             │
  │                      │
  │   like a null         │
  │   output.            │
  │                      │
  └──────────────────────┘
      </pre>
      <p class="subtle">nothing in your context window yet. <a href="/shop.php" class="link">browse products</a></p>
    </div>

    <div id="cart-summary" class="cart-summary" style="display:none;">
      <div class="summary-row">
        <span>subtotal</span>
        <span id="cart-subtotal">$0.00</span>
      </div>
      <div class="summary-row">
        <span>token total</span>
        <span id="cart-tokens">0 tokens</span>
      </div>
      <div class="summary-row delivery-note">
        <span>delivery</span>
        <span>digital · instant</span>
      </div>

      <button id="checkout-btn" class="btn primary large" onclick="handleCheckout()">
        checkout →
      </button>
      <p class="subtle text-center secure-note">secured by stripe · we never see your payment info</p>
      <p class="subtle text-center token-note">prices shown in usd · tokens are a vibe check</p>
    </div>
  </main>

  <div id="checkout-overlay" class="overlay" style="display:none;">
    <div class="overlay-content">
      <pre class="thinking-animation">
╔══════════════════════╗
║  processing tokens   ║
║  ░░░░░░░░░░░░░░░░    ║
║  estimating cost...  ║
╚══════════════════════╝
      </pre>
    </div>
  </div>

  <?php include __DIR__ . '/src/components/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
