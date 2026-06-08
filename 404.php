<?php
require_once __DIR__ . '/src/config.php';
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 / aillm satire</title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__.'/assets/css/style.css') ?>">
  <?php
  $og_title = '404 / aillm satire — model not found';
  $og_desc = 'the page you\'re looking for failed to load into context window. temperature of this page: τ = 0.0 (very certain it\'s lost).';
  ?>
  <?php include __DIR__ . '/src/components/og.php'; ?>
</head>
<body>
  <?php include __DIR__ . '/src/components/header.php'; ?>
  <main class="container error-page">
    <pre>
  ┌──────────────────────────────┐
  │  ERROR 404                   │
  │  model not found             │
  │                              │
  │  the page you're looking for │
  │  failed to load into         │
  │  context window.             │
  │                              │
  │  temperature of this page:   │
  │  τ = 0.0     (very certain   │
  │               it's lost)     │
  │                              │
  │  possible causes:            │
  │  • typo in your prompt       │
  │  • page was pruned from      │
  │    context                   │
  │  • hallucination (yours)     │
  │  • hallucination (ours)      │
  └──────────────────────────────┘
    </pre>
    <p><a href="/shop.php" class="btn primary">← return to shop</a></p>
  </main>
  <?php include __DIR__ . '/src/components/footer.php'; ?>
</body>
</html>
