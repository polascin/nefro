<?php
/**
 * head_meta.php — Centralized <head> section for Nefro-projekt Slovensko
 * Provides SEO, Social Metadata, JSON-LD support, and common assets.
 */

// Basic site configuration
$siteName = 'Nefro-projekt Slovensko';
$baseUrl = 'https://nefro.polascin.net/';
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Default SEO values (should be overridden by individual pages)
$pageTitle = $pageTitle ?? $siteName;
$seoDescription = $seoDescription ?? 'Odborný portál pre nefrológov a lekárov so zameraním na CKD, dialýzu a moderné klinické kalkulačky.';
$seoKeywords = $seoKeywords ?? 'nefrológia, CKD, chronické ochorenie obličiek, KDIGO, eGFR, dialýza, transplantácia obličiek, Slovensko';
$canonicalUrl = $canonicalUrl ?? $currentUrl;
$robotsMeta = $robotsMeta ?? 'index, follow, max-image-preview:large';
$ogType = $ogType ?? 'website';
$ogImage = $ogImage ?? ($baseUrl . 'img/nps-logo.gif');

// Helper for Schema.org
$structuredData = $structuredData ?? [];
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="referrer" content="strict-origin-when-cross-origin">

<!-- Cache Control -->
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<!-- SEO Metadata -->
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES) ?></title>
<meta name="description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
<meta name="keywords" content="<?= htmlspecialchars($seoKeywords, ENT_QUOTES) ?>">
<meta name="author" content="MUDr. Ľubomír Polaščín">
<meta name="robots" content="<?= htmlspecialchars($robotsMeta, ENT_QUOTES) ?>">
<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?= htmlspecialchars($ogType, ENT_QUOTES) ?>">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
<meta property="og:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($siteName, ENT_QUOTES) ?>">
<meta property="og:locale" content="sk_SK">
<meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
<meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">

<!-- Structured Data (Schema.org) -->
<?php if (!empty($structuredData)): ?>
<script type="application/ld+json">
<?= json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php endif; ?>

<!-- Favicons & Manifest -->
<link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
<link rel="manifest" href="./site.webmanifest">
<link rel="shortcut icon" href="./favicon.ico">
<meta name="theme-color" content="#2563eb">

<!-- Assets with Cache-Busting -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">

<!-- KaTeX for mathematical formulas -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css" integrity="sha384-n9jH451W31ALuDQF6V/MInIX++7H6G4pzSj6V454ec3j817ExgD605ER047PtcWv" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.js" integrity="sha384-7zk9W9fkTim/umWJJSUndd1tqZpW1M9NLW2P16SJC8uPAfK9tMUEG2L179WmU9gL" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/contrib/auto-render.min.js" integrity="sha384-43gviWU0YVjaDtb/GhzOouOXtZMP/7XUzwPTstBeZFe/+rCMvRwr4yROQP43s0Xk" crossorigin="anonymous"
    onload="renderMathInElement(document.body, {
        delimiters: [
            {left: '$$', right: '$$', display: true},
            {left: '$', right: '$', display: false},
            {left: '\\(', right: '\\)', display: false},
            {left: '\\[', right: '\\]', display: true}
        ],
        throwOnError: false
    });"></script>

<link rel="stylesheet" href="index.css?v=<?= filemtime('index.css') ?>">
<script src="theme.js?v=<?= filemtime('theme.js') ?>"></script>
<script src="ui-preferences.js?v=<?= filemtime('ui-preferences.js') ?>" defer></script>
<script src="ui-preferences-fallback.js?v=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
