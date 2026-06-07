<?php
/**
 * index.php — home page
 */

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/api/products.php';
require_once __DIR__ . '/../src/components/header.php';
require_once __DIR__ . '/../src/components/footer.php';
require_once __DIR__ . '/../src/components/product-card.php';

$featured = get_products(null, 8);

render_header('llm satire — products may or may not exist');
?>

<section class="hero">
    <h1 class="hero-title">welcome to the latent space</h1>
    <p class="hero-sub">
        a shop where products are generated, hallucinated, and occasionally real.
        <br>priced in tokens. shipped when the loss converges.
    </p>
    <div class="hero-stats">
        <span class="stat"><strong>∞</strong> possible products</span>
        <span class="stat"><strong>?</strong> actually in stock</span>
        <span class="stat"><strong>0.73</strong> confidence score</span>
    </div>
    <a href="/products.php" class="btn">browse products</a>
</section>

<section class="section featured-products">
    <h2 class="section-title">recently generated →</h2>
    <div class="product-grid">
        <?php foreach ($featured['products'] as $p): ?>
            <?php render_product_card($p); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="section manifest">
    <h2 class="section-title">manifest.manifest</h2>
    <div class="manifest-content">
        <p><strong>llm satire</strong> is a critical artifact at the intersection of commerce, culture, and the latent space.</p>
        <p>every product is a commentary on what it means to generate, to consume, to desire in an age of synthetic intelligence. we are not a brand. we are a training run.</p>
        <p class="manifest-signature">— trained on a distributed cluster of vibes</p>
    </div>
</section>

<?php render_footer(); ?>
