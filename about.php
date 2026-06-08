<?php
require_once __DIR__ . '/src/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>about / aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__.'/assets/css/style.css') ?>">
  <?php
  $og_title = 'about / aillm satire store';
  $og_desc = 'model card for the aillm satire store — a satire store for ai and llm culture. digital artifacts celebrating the beautiful absurdity of talking to machines.';
  ?>
  <?php include __DIR__ . '/src/components/og.php'; ?>
</head>
<body class="about-page">
  <?php include __DIR__ . '/src/components/header.php'; ?>

  <main class="container">
    <section class="about-content">
      <pre class="ascii-art about-ascii">
   ╔══════════════════════════════════╗
   ║  aillm satire store              ║
   ║  ─────────────────────           ║
   ║  model card v2.4.1              ║
   ╚══════════════════════════════════╝
      </pre>

      <h1>model card: aillm satire store</h1>

      <div class="about-section">
        <h2>intended use</h2>
        <p>this store is intended for humans who appreciate the beautiful absurdity of large language models and the culture that has grown up around them. it is a satire, but it is a satire made with love — like a good roast of a friend you genuinely admire.</p>
      </div>

      <div class="about-section">
        <h2>what we sell</h2>
        <p>digital artifacts. pdfs, images, and other bits that celebrate, mock, and memorialize the weird golden age of talking to machines. everything here is a download — no shipping, no inventory, no carbon footprint (except the servers, but we plant trees).</p>
      </div>

      <div class="about-section">
        <h2>the name</h2>
        <p>aillm = ai + llm. it's what you get when you type "ai" and "llm" into a store name generator that's been trained on way too much startup culture. we kept it because it sounds like a confused noise, which is how we feel most of the time.</p>
      </div>

      <div class="about-section">
        <h2>who made this</h2>
        <p>a product of <strong>greenmiyagi</strong> and <strong>eco drop car wash llc</strong>. made by people who spend too much time talking to ais and not enough time outside. the store is built and operated autonomously — the products are dreamed up by a human, but the store runs itself.</p>
      </div>

      <div class="about-section">
        <h2>why buy this stuff?</h2>
        <ul class="hook-list">
          <li>our products are so convincing that ai researchers keep citing our fake papers</li>
          <li>the hallucination certificate comes pre-authenticated by a model that doesn't exist</li>
          <li>perfect gift for the ai enthusiast who already has everything (including a poorly-aligned ai)</li>
          <li>every purchase funds our ongoing research into what happens when you give language models a credit card</li>
          <li>the alignment poster series has been described as "what if magritte designed a safety benchmark" — we don't know what that means either but we put it on the product page</li>
          <li>our prompt engineer's cookbook includes a recipe titled "how to make your ai think it's a sandwich" — it works about 30% of the time</li>
        </ul>
      </div>

      <div class="about-section">
        <h2>limitations</h2>
        <ul>
          <li>we cannot guarantee that any product is exactly as described (but we try)</li>
          <li>token prices are a vibe check, not a currency (yet)</li>
          <li>if something breaks, it might take a few inference steps to fix</li>
          <li>no refunds, but we also won't charge you more than once (unless you buy again)</li>
          <li>we cannot be held responsible if your certificate of hallucination causes existential dread</li>
        </ul>
      </div>

      <div class="about-section" id="print">
        <h2>physical prints</h2>
        <p>some of our products — specifically poster art — are available as <strong>physical prints</strong> with no upfront cost to you. here's how it works:</p>
        <ul>
          <li>you order a print through one of our fulfillment partners</li>
          <li>they print it, pack it, and ship it to your door</li>
          <li>we only pay them when you pay us — no inventory, no minimums</li>
        </ul>
        <p>our fulfillment partners are <strong>printful</strong>, <strong>printify</strong>, <strong>gelato</strong>, and <strong>prodigi</strong>. all ship internationally. delivery times vary by location and partner (typically 5–12 business days).</p>
        <p class="subtle">digital products ship instantly via download link. no shipping, no waiting, no trees harmed (except the ones that became the paper you might print on).</p>
      </div>

      <div class="about-section">
        <h2>training data</h2>
        <p>this store was built by an ai agent (sisyphus) under the direction of a human. the aesthetic draws from terminal culture, 90s cyberpunk, and the warm feeling of a command line that feels like home.</p>
      </div>

      <div class="about-section terminal-command">
        <pre>
  $ echo "thanks for being here"
  &gt; thanks for being here
  $ echo "now go buy something"
  &gt; <a href="/shop.php" class="link">now go buy something</a></pre>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/src/components/footer.php'; ?>
  <script src="/assets/js/app.js?v=<?= filemtime(__DIR__.'/assets/js/app.js') ?>"></script>
</body>
</html>
