<?php
/**
 * head_meta.php — Centralized <head> section for Nefro-projekt Slovensko
 * Provides SEO, Social Metadata, JSON-LD support, and common assets.
 */

// Basic site configuration
$siteName = 'Nefro-projekt Slovensko';
$baseUrl = 'https://nefro.polascin.net/';
// Bezpečná konštrukcia currentUrl — validujeme host voči pevnej konfigurácii
// (ochrana pred Host Header Injection → SEO poisoning)
$_allowedHost = 'nefro.polascin.net';
$_scheme = (isset($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
$_requestUri = filter_var($_SERVER['REQUEST_URI'] ?? '/', FILTER_SANITIZE_URL) ?: '/';
$currentUrl = $_scheme . '://' . $_allowedHost . $_requestUri;

// Default SEO values (should be overridden by individual pages)
$pageTitle = $pageTitle ?? $siteName;
$seoDescription = $seoDescription ?? 'Odborný portál pre nefrológov a lekárov so zameraním na CKD, dialýzu a moderné klinické kalkulačky.';
$seoKeywords = $seoKeywords ?? 'nefrológia, CKD, chronické ochorenie obličiek, KDIGO, eGFR, dialýza, transplantácia obličiek, Slovensko';
$canonicalUrl = $canonicalUrl ?? $currentUrl;
$robotsMeta = $robotsMeta ?? 'index, follow, max-image-preview:large';
$ogType = $ogType ?? 'website';
// OG obrázok: odporúčané minimum pre sociálne siete je 1200×630 px, formát JPG/PNG
$ogImage = $ogImage ?? ($baseUrl . 'img/og-default.jpg');
$ogImageWidth = $ogImageWidth ?? 1200;
$ogImageHeight = $ogImageHeight ?? 630;

// Helper for Schema.org
$structuredData = $structuredData ?? [];

$katexBase = 'assets/katex/0.16.11';
$katexCss = $katexBase . '/katex.min.css';
$katexJs = $katexBase . '/katex.min.js';
$katexAutoRender = $katexBase . '/contrib/auto-render.min.js';
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
<link rel="alternate" hreflang="sk" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="<?= htmlspecialchars($ogType, ENT_QUOTES) ?>">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
<meta property="og:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonicalUrl, ENT_QUOTES) ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($siteName, ENT_QUOTES) ?>">
<meta property="og:locale" content="sk_SK">
<meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
<meta property="og:image:alt" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
<meta property="og:image:width" content="<?= (int)($ogImageWidth ?? 1200) ?>">
<meta property="og:image:height" content="<?= (int)($ogImageHeight ?? 630) ?>">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($seoDescription, ENT_QUOTES) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">

<!-- Structured Data (Schema.org) -->
<?php if (!empty($structuredData)): ?>
<script type="application/ld+json" nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
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

<!-- KaTeX for mathematical formulas (self-hosted) -->
<link rel="stylesheet" href="<?= htmlspecialchars($katexCss) ?>?v=<?= filemtime($katexCss) ?>">
<script defer src="<?= htmlspecialchars($katexJs) ?>?v=<?= filemtime($katexJs) ?>"></script>
<script defer src="<?= htmlspecialchars($katexAutoRender) ?>?v=<?= filemtime($katexAutoRender) ?>"></script>
<script defer src="formula-math.js?v=<?= filemtime('formula-math.js') ?>"></script>

<link rel="stylesheet" href="index.css?v=<?= filemtime('index.css') ?>">
<?php
// Sync server-side theme_auto preference → localStorage pred theme.js
$_themeAuto = 1; // default: auto (sleduj systém)
if (function_exists('isLoggedIn') && isLoggedIn()) {
    if (isset($_SESSION['theme_auto'])) {
        $_themeAuto = (int) $_SESSION['theme_auto'];
    } elseif (isset($pdo)) {
        try {
            $_taStmt = $pdo->prepare("SELECT theme_auto FROM users WHERE id = :id LIMIT 1");
            $_taStmt->execute(['id' => $_SESSION['user_id']]);
            $_taRow = $_taStmt->fetch(PDO::FETCH_ASSOC);
            $_themeAuto = (int) ($_taRow['theme_auto'] ?? 1);
            $_SESSION['theme_auto'] = $_themeAuto;
        } catch (\Throwable $_taEx) {
            error_log('head_meta: theme_auto load failed for user_id=' . ($_SESSION['user_id'] ?? '?') . ': ' . $_taEx->getMessage());
        }
    }
}
?>
<script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">try{localStorage.setItem('nps_theme_auto','<?= (int)$_themeAuto ?>');}catch(_e){}</script>
<script src="theme.js?v=<?= filemtime('theme.js') ?>"></script>
<script src="ui-preferences.js?v=<?= filemtime('ui-preferences.js') ?>" defer></script>
<script src="ui-preferences-fallback.js?v=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
<script src="nefro-ui.js?v=<?= filemtime(__DIR__ . '/nefro-ui.js') ?>" defer></script>
<?php if (str_starts_with(basename($_SERVER['PHP_SELF'] ?? ''), 'calculator')): ?>
<script src="calculator.js?v=<?= filemtime(__DIR__ . '/calculator.js') ?>" defer></script>
<?php endif; ?>
