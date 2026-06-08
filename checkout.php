<?php
require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/stripe.php';
require_once __DIR__ . '/src/products.php';

$session_id = $_GET['session_id'] ?? '';
$order = null;
$error = '';

if ($session_id) {
    $session = retrieve_checkout_session($session_id);
    if (isset($session['error'])) {
        $error = 'could not verify payment. but if it went through, thank you.';
    } elseif (($session['payment_status'] ?? '') === 'paid') {
        $order = $session;
    } else {
        $error = 'payment not confirmed yet. give it a moment — attention takes time.';
    }
}

// calculate total tokens from line items
$total_tokens = 0;
$purchased_products = [];
if ($order && isset($order['line_items']['data'])) {
    foreach ($order['line_items']['data'] as $li) {
        $slug = $li['price']['product']['metadata']['product_slug'] ?? '';
        $qty = $li['quantity'] ?? 1;
        if ($slug) {
            $product = get_product_by_slug($slug);
            if ($product) {
                $purchased_products[] = [
                    'product' => $product,
                    'quantity' => $qty,
                ];
                $token_val = (int)str_replace('.', '', str_replace('k', '', $product['token_price']));
                $total_tokens += $token_val * $qty;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>checkout / aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__.'/assets/css/style.css') ?>">
  <?php
  $og_title = $order ? 'thank you / aillm satire' : 'checkout / aillm satire';
  $og_desc = $order ? 'your purchase has been added to the training set. download your products.' : 'complete your purchase at the aillm satire store.';
  ?>
  <?php include __DIR__ . '/src/components/og.php'; ?>
</head>
<body class="checkout-page">
  <?php include __DIR__ . '/src/components/header.php'; ?>

  <main class="container">
    <?php if ($error && !$order): ?>
      <section class="checkout-result">
        <div class="terminal-bracket">
          <pre class="ascii-art">   .--.
  |o_o |
  |:_/ |
 //   \ \
(|     | )
/'\_   _/`\
\___)=(___/</pre>
          <h1>hmm.</h1>
          <p class="subtle"><?= htmlspecialchars($error) ?></p>
          <p class="subtle">if you think it went through, check your email for the download. otherwise, <a href="/cart.php" class="link">try again</a>.</p>
        </div>
      </section>

    <?php elseif ($order): ?>
      <section class="checkout-result success">
        <div class="terminal-bracket">
          <pre class="ascii-art glow">   .
  / \
 / _ \
| (_) |
 \___/
  _|_
 /   \
|     |
 \___/</pre>
          <h1>training data received.</h1>
          <p class="subtitle">thank you. your contribution has been added to the corpus.</p>
          <p class="subtle">order confirmed · <?= htmlspecialchars($order['id']) ?></p>
          <p class="token-count">≈ <?= number_format($total_tokens) ?>k tokens processed</p>
        </div>

        <?php if (!empty($purchased_products)): ?>
          <div class="downloads-section">
            <h2>↓ your downloads</h2>
            <p class="subtle">these files are available now. you can always come back to this page (check your email for the link).</p>
            <div class="downloads-grid">
              <?php foreach ($purchased_products as $item):
                $p = $item['product'];
                $slug = $p['slug'];
                $qty = $item['quantity'];
              ?>
                <div class="download-card">
                  <div class="download-card-header">
                    <span class="download-icon">⎔</span>
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                  </div>
                  <?php if ($qty > 1): ?>
                    <span class="qty-badge">×<?= $qty ?></span>
                  <?php endif; ?>
                  <span class="file-type">.<?= $p['type'] ?? 'pdf' ?></span>
                  <a href="/download.php?session=<?= urlencode($session_id) ?>&product=<?= urlencode($slug) ?>" class="download-btn" download>download</a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="checkout-footer">
          <pre class="receipt-ascii">
  ┌─────────────────────────────────┐
  │  receipt #<?= str_pad(substr($order['id'], -8), 8, '0', STR_PAD_LEFT) ?>              │
  │                                 │
  │  this purchase has been added   │
  │  to your permanent record.      │
  │  you now exist in the training  │
  │  set. congratulations.          │
  │                                 │
  │  — aillm satire                 │
  └─────────────────────────────────┘
          </pre>
          <a href="/shop.php" class="btn primary">← continue browsing</a>
        </div>
      </section>

    <?php else: ?>
      <section class="checkout-result">
        <div class="terminal-bracket">
          <h1>no session</h1>
          <p class="subtle">nothing to see here. <a href="/shop.php" class="link">start shopping</a> or <a href="/" class="link">go home</a>.</p>
        </div>
      </section>
    <?php endif; ?>
  </main>

  <?php include __DIR__ . '/src/components/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
