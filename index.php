<?php
require_once __DIR__ . '/src/config.php';
require_once __DIR__ . '/src/products.php';
$products = load_products();
$featured = array_slice($products, 0, 4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__.'/assets/css/style.css') ?>">
  <meta name="description" content="we love this stuff. we also think it's ridiculous. a satire store for ai and llm culture.">
</head>
<body class="home-page">
  <?php include __DIR__ . '/src/components/header.php'; ?>

  <main>
    <section class="hero">
      <!-- terminal-native space elements: text characters, not shapes -->
      <span class="space-planet" aria-hidden="true">O</span>
      <span class="space-star-1" aria-hidden="true">*</span>
      <span class="space-star-2" aria-hidden="true">*</span>
      <span class="space-star-3" aria-hidden="true">*</span>

      <div class="hero-content">
        <pre class="hero-ascii glow">
  ┌────────────────────────────────┐
  │  aillm satire store            │
  │  ─────────────────────────     │
  │  we love this stuff.           │
  │  we also think it's ridiculous. │
  │                                │
  │  [ enter store → ]             │
  └────────────────────────────────┘
        </pre>
        <a href="/shop.php" class="btn primary large hero-btn">enter store →</a>
        <p class="hero-sub">browse our collection of fine ai artifacts</p>
      </div>

      <div class="hero-terminal">
        <pre class="terminal-output">
<span class="prompt">$</span> load inventory
<span class="output">loading product catalog...</span>
<span class="output">found <?= count($products) ?> products</span>
<span class="prompt">$</span> check vibes
<span class="output">vibe check: passed</span>
<span class="prompt">$</span> init transaction
<span class="output cursor-blink">_</span>
        </pre>
      </div>
    </section>

    <section class="featured-section container">
      <div class="section-header">
        <h2>⎔ featured products</h2>
        <a href="/shop.php" class="link">view all →</a>
      </div>
      <div class="product-grid featured-grid">
        <?php foreach ($featured as $product):
          $slug = $product['slug'];
          $name = $product['name'];
          $price = $product['price_display'];
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
            <div class="product-meta">
              <span class="product-price"><?= $price ?></span>
              <span class="product-tokens">~<?= $tokens ?></span>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="manifesto-section container">
      <pre class="manifesto-ascii">
  ╔══════════════════════════════════════╗
  ║  what is this place?                 ║
  ║                                      ║
  ║  a store. a satire. a love letter.   ║
  ║                                      ║
  ║  we make things — digital artifacts  ║
  ║  that celebrate the beautiful        ║
  ║  absurdity of talking to machines.   ║
  ║                                      ║
  ║  every purchase adds you to the      ║
  ║  training set. welcome.              ║
  ║                                      ║
  ║  — a product of greenmiyagi          ║
  ║    and eco drop car wash llc         ║
  ╚══════════════════════════════════════╝
      </pre>
    </section>

    <section class="shipping-section container">
      <pre class="ascii-art">
  ╔══════════════════════════════════════════╗
  ║  also available as physical prints       ║
  ║                                          ║
  ║  select posters and art prints are       ║
  ║  available as high-quality physical      ║
  ║  prints — printed on demand, shipped     ║
  ║  to your door. no inventory. no minimum. ║
  ║  no upfront cost.                        ║
  ║                                          ║
  ║  powered by printful / printify / gelato ║
  ║  — print-on-demand partners with         ║
  ║  global fulfillment.                     ║
  ║                                          ║
  ║  → look for the [print] badge on         ║
  ║    eligible products                     ║
  ╚══════════════════════════════════════════╝
      </pre>
    </section>
  </main>

  <?php include __DIR__ . '/src/components/footer.php'; ?>
  <script src="/assets/js/app.js"></script>
</body>
</html>
