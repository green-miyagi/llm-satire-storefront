<?php
require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/products.php';

$slug = $_GET['slug'] ?? '';
$product = get_product_by_slug($slug);

if (!$product) {
  http_response_code(404);
  require __DIR__ . '/src/components/header.php';
  echo '<main class="container"><section class="error-page"><pre class="ascii-art">';
  echo '  (  )   (  )';
  echo "\n   ( ) ( )";
  echo "\n     ( )";
  echo "\n    /|\\";
  echo "\n   / | \\";
  echo "\n      |";
  echo "\n     / \\";
  echo "\n  [product not found]";
  echo '</pre><a href="/shop.php" class="btn primary">← back to shop</a></section></main>';
  require __DIR__ . '/src/components/footer.php';
  exit;
}

$name = $product['name'];
$price = $product['price_display'];
$tokens = $product['token_price'];
$temp = $product['temperature'];
$desc = $product['description'];
$features = $product['features'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($name) ?> / aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__.'/assets/css/style.css') ?>">
</head>
<body class="product-page">
  <?php include __DIR__ . '/src/components/header.php'; ?>

  <main class="container product-detail">
    <nav class="breadcrumb">
      <a href="/shop.php" class="link">← shop</a>
    </nav>

    <div class="product-detail-layout">
      <div class="product-visual">
        <?php
        $imgPath = __DIR__ . '/assets/images/' . $product['image'] . '.png';
        if (file_exists($imgPath)):
        ?>
        <img src="/assets/images/<?= $product['image'] ?>.png" alt="<?= htmlspecialchars($name) ?>" class="product-image-detail">
        <?php endif; ?>
        <div class="model-card-frame">
          <div class="model-card-header">
            <span class="model-label">model card</span>
            <span class="model-version">v<?= rand(1,9) ?>.<?= rand(0,9) ?>.<wbr><?= rand(0,99) ?></span>
          </div>
          <div class="model-card-body">
            <div class="model-name"><?= htmlspecialchars($name) ?></div>
            <div class="model-specs">
              <div class="spec-row"><span class="spec-label">temperature</span><span class="spec-value"><?= $temp ?></span></div>
              <div class="spec-row"><span class="spec-label">parameters</span><span class="spec-value"><?= htmlspecialchars($product['parameters'] ?? 'unknown') ?></span></div>
              <div class="spec-row"><span class="spec-label">context window</span><span class="spec-value"><?= htmlspecialchars($product['context_window'] ?? 'n/a') ?></span></div>
              <div class="spec-row"><span class="spec-label">training data</span><span class="spec-value"><?= htmlspecialchars($product['training_data'] ?? 'unknown') ?></span></div>
            </div>
          </div>
          <div class="model-card-footer">
            <span class="model-id"><?= $product['id'] ?></span>
            <span class="model-type"><?= $product['type'] ?? 'digital' ?></span>
          </div>
        </div>
      </div>

      <div class="product-info">
        <h1 class="product-title"><?= htmlspecialchars($name) ?></h1>
        <p class="product-description"><?= htmlspecialchars($desc) ?></p>

        <?php if (!empty($features)): ?>
        <div class="product-features">
          <h3>⎔ features</h3>
          <ul>
            <?php foreach ($features as $f): ?>
              <li><?= htmlspecialchars($f) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($product['stories'] ?? [])): ?>
        <div class="product-features">
          <h3>⎔ stories</h3>
          <ul>
            <?php foreach ($product['stories'] as $s): ?>
              <li><?= htmlspecialchars($s) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($product['scenarios'] ?? [])): ?>
        <div class="product-features">
          <h3>⎔ scenarios</h3>
          <ul>
            <?php foreach ($product['scenarios'] as $s): ?>
              <li><?= htmlspecialchars($s) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($product['recipes'] ?? [])): ?>
        <div class="product-features">
          <h3>⎔ recipes</h3>
          <ul>
            <?php foreach ($product['recipes'] as $r): ?>
              <li><?= htmlspecialchars($r) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <div class="product-pricing">
          <div class="price-row">
            <span class="price-label">price</span>
            <span class="price-amount"><?= $price ?></span>
          </div>
          <div class="price-row token-row">
            <span class="price-label">token equivalent</span>
            <span class="price-tokens">~<?= $tokens ?> tokens</span>
          </div>
          <div class="price-row temperature-row">
            <span class="price-label">temperature</span>
            <span class="price-temp">τ = <?= $temp ?></span>
          </div>
        </div>

        <button class="btn primary large add-to-cart-btn" onclick="addToCart('<?= htmlspecialchars($product['slug']) ?>')">
          + add to context window
        </button>
        <p class="subtle text-center" style="margin-top:0.75rem">instant digital delivery · no shipping · no wait</p>
        <?php if (($product['category'] ?? '') === 'art'): ?>
        <div class="pods-badge">
          ⎔ also available as a <a href="/about.php#print">physical print</a> — no upfront cost, shipped to your door
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/src/components/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
