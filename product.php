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
  echo '</pre><a href="/shop" class="btn primary">← back to shop</a></section></main>';
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
  <?php
  $og_title = $name . ' / aillm satire';
  $og_desc = $desc;
  $og_image = '/assets/images/' . $product['image'] . '.png';
  ?>
  <?php include __DIR__ . '/src/components/og.php'; ?>
</head>
<body class="product-page">
  <?php include __DIR__ . '/src/components/header.php'; ?>

  <main class="container product-detail">
    <nav class="breadcrumb">
      <a href="/shop" class="link">← shop</a>
    </nav>

    <div class="product-detail-layout">
      <div class="product-visual">
        <?php if (!empty($product['images'])):
        // Multi-image gallery (e.g. poster series)
        ?>
        <div class="image-gallery">
          <?php foreach ($product['images'] as $img):
            $galleryPath = __DIR__ . '/assets/images/' . $img . '.png';
            if (!file_exists($galleryPath)) continue;
          ?>
          <div class="gallery-item">
            <img src="/assets/images/<?= $img ?>.png" alt="<?= htmlspecialchars($name) ?> — <?= htmlspecialchars($img) ?>" width="1024" height="1024" class="gallery-image" loading="lazy">
          </div>
          <?php endforeach; ?>
        </div>
        <?php else:
        $imgPath = __DIR__ . '/assets/images/' . $product['image'] . '.png';
        if (file_exists($imgPath)):
        ?>
        <img src="/assets/images/<?= $product['image'] ?>.png" alt="<?= htmlspecialchars($name) ?>" width="1024" height="1024" class="product-image-detail">
        <?php endif; endif; ?>
        <div class="model-card-frame">
          <div class="model-card-header">
            <span class="model-label">model card</span>
            <span class="model-version">v<?= abs(crc32($slug)) % 9 + 1 ?>.<?= abs(crc32($slug . '_minor')) % 10 ?>.<wbr><?= abs(crc32($slug . '_patch')) % 100 ?></span>
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
        <p class="subtle">instant digital delivery · no shipping · no wait</p>
        <?php if (($product['category'] ?? '') === 'art'): ?>
        <div class="pods-badge">
          ⎔ also available as a <a href="/about#print">physical print</a> — no upfront cost, shipped globally
        </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php
  $all = load_products();
  $related = array_filter($all, function($p) use ($product) {
    return ($p['category'] ?? '') === ($product['category'] ?? '')
        && $p['slug'] !== $product['slug'];
  });
  $related = array_slice(array_values($related), 0, 4);
  ?>
  <?php if (!empty($related)): ?>
  <section class="related-products container">
    <h2 class="related-title">↗ similar artifacts</h2>
    <div class="related-grid">
      <?php foreach ($related as $rp):
        $rSlug = $rp['slug'];
        $rName = $rp['name'];
        $rPrice = $rp['price_display'];
      ?>
      <div class="related-card-wrapper">
        <a href="/product/<?= urlencode($rSlug) ?>" class="related-card">
          <div class="related-card-image">
            <?php if (!empty($rp['image']) && file_exists(__DIR__ . '/assets/images/' . $rp['image'] . '.png')): ?>
            <img src="/assets/images/<?= $rp['image'] ?>.png" alt="<?= htmlspecialchars($rName) ?>" width="1024" height="1024" loading="lazy">
            <?php else: ?>
            <div class="related-card-placeholder">⎔</div>
            <?php endif; ?>
          </div>
          <div class="related-card-body">
            <span class="related-card-name"><?= htmlspecialchars($rName) ?></span>
            <span class="related-card-price"><?= $rPrice ?></span>
          </div>
        </a>
        <button class="card-add-btn" data-slug="<?= htmlspecialchars($rSlug) ?>" onclick="addToCartFromCard('<?= htmlspecialchars($rSlug) ?>', this)">+ add</button>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php include __DIR__ . '/src/components/footer.php'; ?>
  <script src="/assets/js/app.js?v=<?= filemtime(__DIR__.'/assets/js/app.js') ?>"></script>
</body>
</html>
