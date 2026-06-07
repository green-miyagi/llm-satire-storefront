<?php
/**
 * product-card.php — renders a single product card
 */

function render_product_card(array $product): void {
    $handle = htmlspecialchars($product['handle']);
    $title  = htmlspecialchars($product['title']);
    $price  = '';
    if (isset($product['priceRange'])) {
        $min = $product['priceRange']['minVariantPrice'];
        $sym = $min['currencyCode'] === 'USD' ? '$' : $min['currencyCode'] . ' ';
        $price = $sym . number_format((float)$min['amount'], 2);
    }

    $imgUrl = '';
    $imgAlt = 'product image';
    if (!empty($product['images']['edges'])) {
        $imgUrl = $product['images']['edges'][0]['node']['url'];
        $imgAlt = htmlspecialchars($product['images']['edges'][0]['node']['altText'] ?: $title);
    }

    $available = $product['availableForSale'] ?? true;
?>
<a href="/product.php?handle=<?= $handle ?>" class="product-card <?= $available ? '' : 'sold-out' ?>">
    <div class="product-card-image">
        <?php if ($imgUrl): ?>
            <img src="<?= $imgUrl ?>" alt="<?= $imgAlt ?>" loading="lazy">
        <?php else: ?>
            <div class="product-card-placeholder">
                <span>∅</span>
            </div>
        <?php endif; ?>
    </div>
    <div class="product-card-body">
        <h3 class="product-card-title"><?= $title ?></h3>
        <p class="product-card-price"><?= $price ?></p>
        <?php if (!$available): ?>
            <span class="badge badge-out">hallucinated away</span>
        <?php endif; ?>
    </div>
</a>
<?php
}
