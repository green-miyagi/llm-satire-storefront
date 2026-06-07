<?php
require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/products.php';

$products = load_products();
$category = $_GET['category'] ?? '';
$search = trim($_GET['q'] ?? '');

if ($category) {
    $products = get_products_by_category($category);
}
if ($search) {
    $products = array_values(array_filter($products, function($p) use ($search) {
        $s = strtolower($search);
        return str_contains(strtolower($p['name']), $s)
            || str_contains(strtolower($p['description']), $s)
            || str_contains(strtolower($p['category'] ?? ''), $s);
    }));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>shop / aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="shop-page">
  <?php include __DIR__ . '/../src/components/header.php'; ?>

  <main class="container">
    <section class="page-header">
      <h1>⎔ products</h1>
      <p class="subtitle">select items to add to your context window</p>

      <form class="search-bar" method="GET" action="/shop.php">
        <input type="text" name="q" placeholder="search products..." value="<?= htmlspecialchars($search) ?>" class="search-input">
        <button type="submit" class="search-btn">→</button>
        <?php if ($search): ?>
          <a href="/shop.php" class="search-clear">×</a>
        <?php endif; ?>
      </form>
    </section>

    <section class="product-grid">
      <?php if (empty($products)): ?>
      <div class="empty-state">
        <pre class="ascii-art">
  ┌─────────────────────┐
  │                     │
  │  no results for     │
  │  "<?= htmlspecialchars($search) ?>"    │
  │                     │
  │  the model          │
  │  hallucinated.      │
  │  try again.         │
  │                     │
  └─────────────────────┘
        </pre>
      </div>
      <?php else: ?>
        <?php foreach ($products as $product):
          $slug = $product['slug'];
          $name = $product['name'];
          $price = $product['price_display'];
          $temp = $product['temperature'];
          $tokens = $product['token_price'];
        ?>
        <a href="/product/<?= urlencode($slug) ?>" class="product-card">
          <div class="product-card-visual">
            <?php
            $imgPath = __DIR__ . '/assets/images/' . ($product['image'] ?? '') . '.png';
            if (!empty($product['image']) && file_exists($imgPath)):
            ?>
            <img src="/assets/images/<?= $product['image'] ?>.png" alt="<?= htmlspecialchars($name) ?>" class="product-card-image" loading="lazy">
            <?php else: ?>
            <div class="product-card-grid">
              <div class="grid-dot"></div><div class="grid-dot"></div><div class="grid-dot"></div>
              <div class="grid-dot"></div><div class="grid-cell"><?= htmlspecialchars($product['category'][0] ?? '?') ?></div><div class="grid-dot"></div>
              <div class="grid-dot"></div><div class="grid-dot"></div><div class="grid-dot"></div>
          </div>
            <?php endif; ?>
            <div class="product-type-badge"><?= $product['type'] ?? 'pdf' ?></div>
          </div>
          <div class="product-card-body">
            <h3 class="product-name"><?= htmlspecialchars($name) ?></h3>
            <p class="product-desc"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>…</p>
            <div class="product-meta">
              <span class="product-price"><?= $price ?></span>
              <span class="product-tokens">~<?= $tokens ?> tokens</span>
              <span class="product-temp">τ=<?= $temp ?></span>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
  </main>

  <?php include __DIR__ . '/../src/components/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
