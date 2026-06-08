<?php
// Product card component
// Expects $product (array) and optional $compact (bool) in scope.
// Compact mode (index.php): no description, no temperature.
// Full mode (shop.php): includes description snippet and temperature.
?>
<div class="product-card">
  <a href="/product/<?= urlencode($product['slug']) ?>" class="product-card-link">
    <div class="product-card-visual">
      <?php
      $imgPath = __DIR__ . '/../../assets/images/' . ($product['image'] ?? '') . '.png';
      if (!empty($product['image']) && file_exists($imgPath)):
      ?>
      <img src="/assets/images/<?= $product['image'] ?>.png" alt="<?= htmlspecialchars($product['name']) ?>" width="1024" height="1024" class="product-card-image" loading="lazy">
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
      <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
      <?php if (empty($compact)): ?>
      <p class="product-desc"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>…</p>
      <?php endif; ?>
      <div class="product-meta">
        <span class="product-price"><?= $product['price_display'] ?></span>
        <span class="product-tokens">~<?= $product['token_price'] ?> tokens</span>
        <?php if (empty($compact)): ?>
        <span class="product-temp">τ=<?= $product['temperature'] ?></span>
        <?php endif; ?>
      </div>
    </div>
  </a>
  <button class="card-add-btn" data-slug="<?= htmlspecialchars($product['slug']) ?>" onclick="addToCartFromCard('<?= htmlspecialchars($product['slug']) ?>', this)">+ add</button>
</div>
