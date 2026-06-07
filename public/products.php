<?php
/**
 * products.php — product listing page
 */

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/api/products.php';
require_once __DIR__ . '/../src/components/header.php';
require_once __DIR__ . '/../src/components/footer.php';
require_once __DIR__ . '/../src/components/product-card.php';

$search = $_GET['q'] ?? '';
$collection = $_GET['collection'] ?? '';

// fetch all products (pagination with cursor)
$allProducts = [];
$cursor = null;
$hasMore = true;
$pageSize = 24;

while ($hasMore && count($allProducts) < 50) {
    $result = get_products($cursor, $pageSize);
    $allProducts = array_merge($allProducts, $result['products']);
    $hasMore = $result['pageInfo']['hasNextPage'] ?? false;
    $cursor = $result['pageInfo']['endCursor'] ?? null;
}

render_header('products — llm satire');
?>

<section class="section">
    <h1 class="section-title">products</h1>
    <p class="section-sub"><?= count($allProducts) ?> items in the training set</p>

    <div class="product-grid">
        <?php if (empty($allProducts)): ?>
            <p class="empty-state">no products loaded. the model didn't converge yet.</p>
        <?php else: ?>
            <?php foreach ($allProducts as $p): ?>
                <?php render_product_card($p); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php render_footer(); ?>
