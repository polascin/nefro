<?php

declare(strict_types=1);

/**
 * Zdieľaná hlavička pre právne stránky (privacy.php, cookies.php, terms.php).
 * Vykreslí <head> so SEO/OG/JSON-LD, otvorí <body>, skip-link a hlavičku webu.
 *
 * Pred include nastav:
 *   $legalTitle        — názov stránky (<title>, OG, Twitter)
 *   $legalDescription  — meta popis
 *   $legalSlug         — názov súboru pre canonical (napr. 'privacy.php')
 *   $legalHeaderTitle  — podnadpis v hlavičke webu
 *   $legalHeaderIntro  — krátky úvod v hlavičke webu (voliteľné)
 *   $legalLastUpdated  — naformátovaný dátum poslednej aktualizácie
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/legal_data.php';

$info = legalInfo();

$legalTitle       = $legalTitle       ?? 'Právne informácie';
$legalDescription = $legalDescription ?? '';
$legalSlug        = $legalSlug        ?? basename((string) ($_SERVER['PHP_SELF'] ?? 'privacy.php'));
$legalHeaderTitle = $legalHeaderTitle ?? $legalTitle;
$legalHeaderIntro = $legalHeaderIntro ?? '';
$legalCanonical   = $info['url'] . '/' . $legalSlug;
$legalSiteName    = $info['entity'];
$legalFullTitle   = $legalTitle . ' | ' . $legalSiteName;
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- Logika pre Tmavý režim (na začiatku kvôli prevencii FOUC) -->
    <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bezpečnostné hlavičky (Security) -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <!-- SEO & Metadata -->
    <meta name="description" content="<?= htmlspecialchars($legalDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= htmlspecialchars($legalCanonical, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="alternate" hreflang="sk-SK" href="<?= htmlspecialchars($legalCanonical, ENT_QUOTES, 'UTF-8') ?>">

    <!-- Open Graph (Social SEO) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($legalFullTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($legalDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:url" content="<?= htmlspecialchars($legalCanonical, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($legalSiteName, ENT_QUOTES, 'UTF-8') ?>">
    <meta property="og:locale" content="sk_SK">
    <meta property="og:image" content="<?= htmlspecialchars($info['url'], ENT_QUOTES, 'UTF-8') ?>/img/nps-logo.gif">
    <meta property="og:image:alt" content="Logo Nefro-projekt Slovensko">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= htmlspecialchars($legalFullTitle, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($legalDescription, ENT_QUOTES, 'UTF-8') ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($info['url'], ENT_QUOTES, 'UTF-8') ?>/img/nps-logo.gif">

    <title><?= htmlspecialchars($legalFullTitle, ENT_QUOTES, 'UTF-8') ?></title>

    <!-- JSON-LD Štruktúrované dáta -->
    <script type="application/ld+json">
        <?= json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'WebPage',
            'name'        => $legalFullTitle,
            'url'         => $legalCanonical,
            'description' => $legalDescription,
            'inLanguage'  => 'sk-SK',
            'isPartOf'    => [
                '@type' => 'WebSite',
                'name'  => $legalSiteName,
                'url'   => $info['url'] . '/',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
    </script>

    <!-- Favikony (PWA, Apple, Android, Windows) -->
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- CSS (Inter self-hosted v index.css) -->
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">

    <!-- Cookie Consent & GA4 Consent Mode v2 -->
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>

<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = $legalHeaderTitle;
    $headerIntro = $legalHeaderIntro;
    $showLogo = false;
    include 'header.php';
    ?>
