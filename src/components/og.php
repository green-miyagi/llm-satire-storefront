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
<?php if (isset($og_image) && $og_image): ?>
<meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($og_image) ?>">
<?php else: ?>
<meta property="og:image" content="/assets/images/favicon.svg">
<meta name="twitter:image" content="/assets/images/favicon.svg">
<?php endif; ?>
<?php if (isset($og_url) && $og_url): ?>
<meta property="og:url" content="<?= htmlspecialchars($og_url) ?>">
<?php endif; ?>
