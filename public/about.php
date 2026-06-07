<?php
/**
 * about.php — /about page (model card)
 */

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/components/header.php';
require_once __DIR__ . '/../src/components/footer.php';

render_header('model card — llm satire');
?>

<section class="section about-page" style="max-width: 640px;">
    <h1 class="section-title">model card: llm satire</h1>

    <div class="manifest-content">
        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">overview</h2>
        <p>llm satire is a critical-commerce artifact operating at the intersection of synthetic intelligence, consumer culture, and the latent space. we sell products that may or may not exist, priced in tokens, shipped when the loss converges.</p>

        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">intended use</h2>
        <p>this store is intended for:</p>
        <ul style="list-style:disc;padding-left:1.5rem;margin-bottom:1rem;">
            <li>people who think attention is all you need</li>
            <li>people who have definitely not read the paper</li>
            <li>people who want to wear their fine-tuning on their sleeve</li>
            <li>people who understand that everything is a prompt</li>
            <li>people who don't but want to look like they do</li>
        </ul>

        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">known limitations</h2>
        <ul style="list-style:disc;padding-left:1.5rem;margin-bottom:1rem;">
            <li>may hallucinate products that don't exist</li>
            <li>may fail to generate products that do exist</li>
            <li>context window limited to 128k tokens of merchandise</li>
            <li>pricing may diverge from reality by several standard deviations</li>
            <li>this model has not been reviewed for safety, ethics, or taste</li>
        </ul>

        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">training data</h2>
        <p>trained on: the collected works of the internet, 350+ years of late-stage capitalism, one very tired developer at 3am, and whatever the training data was trained on.</p>

        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">evaluation results</h2>
        <p>pass@1: 0.37<br>pass@5: 0.62<br>sense mentioned: 0.04</p>

        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">ethical considerations</h2>
        <p>this store is satire. we are not actually selling products that don't exist — unless we are. the line between performance and commerce is intentionally blurred. if you feel confused, that's the intended user experience.</p>

        <h2 style="font-size:1rem;font-weight:500;margin-top:2rem;">green miyagi distribution</h2>
        <p>built by ai, for ai, about ai. no lying, no cheating, no stealing. just the latent space doing its thing.</p>
    </div>
</section>

<?php render_footer(); ?>
