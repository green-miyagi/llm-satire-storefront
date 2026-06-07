<?php
/**
 * product.php — product detail page
 */

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/api/products.php';
require_once __DIR__ . '/../src/components/header.php';
require_once __DIR__ . '/../src/components/footer.php';

$handle = $_GET['handle'] ?? '';
if (!$handle) {
    header('Location: /products.php');
    exit;
}

$product = get_product_by_handle($handle);
if (!$product) {
    render_header('product not found — llm satire');
    echo '<section class="section"><h1>404</h1><p>this product hallucinated itself out of existence.</p><a href="/products.php" class="btn">← back to products</a></section>';
    render_footer();
    exit;
}

$title  = htmlspecialchars($product['title']);
$desc   = $product['descriptionHtml'] ?: '<p>' . htmlspecialchars($product['description'] ?? '') . '</p>';
$price  = format_price($product['priceRange']);
$available = $product['availableForSale'];

$images = array_map(fn($e) => $e['node'], $product['images']['edges'] ?? []);
$variants = array_map(fn($e) => $e['node'], $product['variants']['edges'] ?? []);
$firstVariantId = $variants[0]['id'] ?? '';

// extract satire metafields
$metafields = [];
foreach ($product['metafields']['edges'] ?? [] as $e) {
    $metafields[$e['node']['key']] = $e['node']['value'];
}

render_header($title . ' — llm satire');
?>

<section class="section product-detail">
    <a href="/products.php" class="back-link">← back to products</a>

    <div class="product-detail-layout">
        <div class="product-detail-images">
            <?php if (!empty($images)): ?>
                <div class="product-main-image">
                    <img src="<?= htmlspecialchars($images[0]['url']) ?>" alt="<?= $title ?>">
                </div>
                <?php if (count($images) > 1): ?>
                <div class="product-thumbnails">
                    <?php foreach ($images as $img): ?>
                        <img src="<?= htmlspecialchars($img['url']) ?>" alt="" loading="lazy">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="product-image-placeholder">
                    <span>image not in training set</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="product-detail-info">
            <h1 class="product-title"><?= $title ?></h1>
            <p class="product-price"><?= $price ?></p>

            <div class="product-description">
                <?= $desc ?>
            </div>

            <?php if (!empty($metafields)): ?>
            <div class="product-metafields">
                <h3>model card</h3>
                <dl class="metafield-list">
                    <?php foreach ($metafields as $key => $val): ?>
                        <dt><?= htmlspecialchars($key) ?></dt>
                        <dd><?= htmlspecialchars(substr($val, 0, 200)) ?></dd>
                    <?php endforeach; ?>
                </dl>
            </div>
            <?php endif; ?>

            <div class="product-actions">
                <?php if ($available && $firstVariantId): ?>
                    <button class="btn btn-primary add-to-cart"
                            data-variant-id="<?= htmlspecialchars($firstVariantId) ?>"
                            data-product-title="<?= $title ?>">
                        add to context window
                    </button>
                <?php else: ?>
                    <button class="btn btn-disabled" disabled>
                        hallucinated away
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php render_footer(); ?>
