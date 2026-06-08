<meta property="og:site_name" content="aillm satire">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_US">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@aillm_satire">
<?php if (isset($og_title) && $og_title): ?>
<meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
<meta name="twitter:title" content="<?= htmlspecialchars($og_title) ?>">
<?php else: ?>
<meta property="og:title" content="aillm satire store — we love this stuff. we also think it's ridiculous.">
<meta name="twitter:title" content="aillm satire store — we love this stuff. we also think it's ridiculous.">
<?php endif; ?>
<?php if (isset($og_desc) && $og_desc): ?>
<meta property="og:description" content="<?= htmlspecialchars($og_desc) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($og_desc) ?>">
<?php else: ?>
<meta property="og:description" content="a satire store for ai and llm culture. digital artifacts that celebrate the beautiful absurdity of talking to machines.">
<meta name="twitter:description" content="a satire store for ai and llm culture. digital artifacts that celebrate the beautiful absurdity of talking to machines.">
<?php endif; ?>
<?php
$site_url_og = getenv('SITE_URL') ?: 'https://aillm.space';
// if SITE_URL is localhost (dev), detect production URL from request
if (str_starts_with($site_url_og, 'http://localhost') || str_starts_with($site_url_og, 'http://127.')) {
  $host = $_SERVER['HTTP_HOST'] ?? 'aillm.space';
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'https';
  $site_url_og = $scheme . '://' . $host;
}
$og_img_abs = '';
if (isset($og_image) && $og_image) {
  $og_img_abs = str_starts_with($og_image, 'http') ? $og_image : rtrim($site_url_og, '/') . '/' . ltrim($og_image, '/');
} else {
  $og_img_abs = rtrim($site_url_og, '/') . '/assets/images/favicon.svg';
}
?>
<meta property="og:image" content="<?= htmlspecialchars($og_img_abs) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($og_img_abs) ?>">
<?php if (isset($og_url) && $og_url): ?>
<meta property="og:url" content="<?= htmlspecialchars($og_url) ?>">
<?php endif; ?>
