<?php
/**
 * collections.php — collection listing page
 */

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/api/collections.php';
require_once __DIR__ . '/../src/components/header.php';
require_once __DIR__ . '/../src/components/footer.php';

$collections = get_collections();

render_header('collections — llm satire');
?>

<section class="section">
    <h1 class="section-title">collections</h1>
    <p class="section-sub">latent groupings. clusters of meaning.</p>

    <div class="collection-grid">
        <?php if (empty($collections)): ?>
            <p class="empty-state">no collections yet. the clustering algorithm is still running.</p>
        <?php else: ?>
            <?php foreach ($collections as $c): ?>
                <?php
                    $handle = htmlspecialchars($c['handle']);
                    $title  = htmlspecialchars($c['title']);
                    $desc   = htmlspecialchars($c['description'] ?? '');
                    $count  = $c['productsCount'] ?? 0;
                    $imgUrl = $c['image']['url'] ?? '';
                ?>
                <a href="/products.php?collection=<?= $handle ?>" class="collection-card">
                    <div class="collection-card-image">
                        <?php if ($imgUrl): ?>
                            <img src="<?= $imgUrl ?>" alt="<?= $title ?>" loading="lazy">
                        <?php else: ?>
                            <div class="collection-card-placeholder">
                                <span>{ · · · }</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="collection-card-body">
                        <h3><?= $title ?></h3>
                        <p><?= $desc ?: $count . ' items' ?></p>
                        <span class="badge"><?= $count ?> products</span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php render_footer(); ?>
