<?php
// Bezpečnostné HTTP hlavičky
header_remove("X-Powered-By");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 0");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Robots-Tag: noindex, follow", true);
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=()");
header("Cross-Origin-Opener-Policy: same-origin");
header("X-Permitted-Cross-Domain-Policies: none");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, private");
header("Pragma: no-cache");
header("Expires: 0");
header("Surrogate-Control: no-store");

$csp = "default-src 'self'; "
  . "img-src 'self' data: https:; "
  . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
  . "font-src 'self' https://fonts.gstatic.com; "
  . "script-src 'self' https://www.googletagmanager.com https://www.google-analytics.com; "
  . "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; "
  . "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests";
header("Content-Security-Policy: " . $csp);
$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';
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
    <meta name="description" content="Zásady ochrany osobných údajov pre projekt Nefro-projekt Slovensko.">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://nefro.polascin.net/privacy.php">
    <link rel="alternate" hreflang="sk-SK" href="https://nefro.polascin.net/privacy.php">

    <!-- Open Graph (Social SEO) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Privacy Policy | Nefro-projekt Slovensko">
    <meta property="og:description" content="Zásady ochrany osobných údajov pre projekt Nefro-projekt Slovensko.">
    <meta property="og:url" content="https://nefro.polascin.net/privacy.php">
    <meta property="og:site_name" content="Nefro-projekt Slovensko">
    <meta property="og:locale" content="sk_SK">
    <meta property="og:image" content="https://nefro.polascin.net/img/nps-logo.gif">
    <meta property="og:image:alt" content="Logo Nefro-projekt Slovensko">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Privacy Policy | Nefro-projekt Slovensko">
    <meta name="twitter:description" content="Zásady ochrany osobných údajov pre projekt Nefro-projekt Slovensko.">
    <meta name="twitter:image" content="https://nefro.polascin.net/img/nps-logo.gif">

    <title>Privacy Policy | Nefro-projekt Slovensko</title>

    <!-- JSON-LD Štruktúrované dáta -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Privacy Policy | Nefro-projekt Slovensko",
            "url": "https://nefro.polascin.net/privacy.php",
            "description": "Zásady ochrany osobných údajov pre projekt Nefro-projekt Slovensko.",
            "isPartOf": {
                "@type": "WebSite",
                "name": "Nefro-projekt Slovensko",
                "url": "https://nefro.polascin.net/"
            }
        }
    </script>

    <!-- Favikony (PWA, Apple, Android, Windows) -->
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">
    <link rel="shortcut icon" href="./favicon.ico">

    <!-- Prepojenie na externý CSS súbor pre moderný dizajn -->
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">

    <!-- Google Fonts pre modernú typografiu -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">

    <!-- Skript pre Privacy Manager (Cookies) -->
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>

<body>
    <!-- Skip to content (A11y) -->
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Zásady ochrany osobných údajov';
    $headerIntro = 'Privacy Policy &amp; Cookie Policy';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Návrat na Domov</a></li>
            </ul>

        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <article class="primary-article">
                <header>
                    <h2>Ochrana osobných údajov (Privacy Policy)</h2>
                    <p class="meta">
                      Posledná aktualizácia:&nbsp; <time datetime="2026-04-26">26. Apríl 2026</time>
                    </p>
                </header>

                <h3>1. Úvodné ustanovenia</h3>
                <p>
                  Tieto Zásady ochrany osobných údajov ("Privacy Policy") vysvetľujú, ako zhromažďujeme, používame, zverejňujeme a chránime vaše informácie pri návšteve našej webovej stránky (ďalej len "Stránka"). Dodržiavame Nariadenie (EÚ) 2016/679 (GDPR), smernicu ePrivacy, a tiež zohľadňujeme medzinárodné štandardy vrátane CCPA/CPRA, pokiaľ ide o návštevníkov z príslušných regiónov.
                </p>

                <h3>2. Aké údaje zhromažďujeme</h3>
                <p>
                  Môžeme o vás zhromažďovať informácie rôznymi spôsobmi:
                </p>
                <ul>
                    <li><strong>Osobné údaje:</strong> Meno, e-mailová adresa alebo iné kontaktné údaje, ktoré nám dobrovoľne poskytnete pri kontaktovaní.</li>
                    <li><strong>Derivované dáta:</strong> Informácie, ktoré naše servery automaticky zhromažďujú, ako je IP adresa, typ prehliadača, operačný systém, čas prístupu a stránky, ktoré ste si prezerali priamo pred a po prístupe na Stránku (prostredníctvom nevyhnutných aj analytických cookies).</li>
                </ul>

                <h3>3. Spracovanie a využitie vašich údajov</h3>
                <p>
                  Vaše údaje používame predovšetkým na nasledujúce účely:
                </p>
                <ul>
                    <li>Zabezpečenie plynulého a bezpečného fungovania Stránky.</li>
                    <li>Vylepšovanie používateľského zážitku a analýza návštevnosti (na základe vášho súhlasu).</li>
                    <li>Komunikácia s vami (ak nás priamo kontaktujete).</li>
                </ul>
                <p>
                  <strong>Zdieľanie údajov:</strong> Vaše osobné údaje nepredávame, neobchodujeme s nimi ani ich neprenajímame tretím stranám. ("We do not sell your personal information" podľa CCPA/CPRA).
                </p>

                <h3>4. Práva dotknutých osôb (GDPR)</h3>
                <p>
                  V zmysle GDPR máte nasledujúce práva:
                </p>
                <ul>
                    <li><strong>Právo na prístup:</strong> Máte právo požadovať kópiu svojich osobných údajov.</li>
                    <li><strong>Právo na opravu:</strong> Máte právo požadovať opravu nepresných údajov.</li>
                    <li><strong>Právo na vymazanie (právo „na zabudnutie"):</strong> Môžete požiadať o vymazanie svojich údajov.</li>
                    <li><strong>Právo na obmedzenie spracúvania a prenosnosť údajov.</strong></li>
                </ul>
                <p>
                  Pre uplatnenie týchto práv nás kontaktujte na e-mailovej adrese: <code>nefro@polascin.net</code>.
                </p>

                <h3>5. Pravidlá používania súborov Cookies (Cookie Policy)</h3>
                <p>
                  Naša stránka používa cookies. Pri prvej návšteve sa vám zobrazí banner, ktorý vám umožní vybrať si, ktoré kategórie cookies chcete povoliť.
                </p>
                <ul>
                    <li><strong>Nevyhnutné (Strictly Necessary):</strong> Tieto cookies sú potrebné pre fungovanie webových stránok a nemožno ich vypnúť v našich systémoch (napr. zapamätanie si samotného súhlasu).</li>
                    <li><strong>Analytické (Analytics):</strong> Umožňujú nám počítať návštevy a zdroje návštevnosti, aby sme mohli merať a zlepšovať výkonnosť našej stránky. Zbierané dáta sú agregované a anonymné.</li>
                    <li><strong>Marketingové (Marketing):</strong> Môžu byť nastavené našimi reklamnými partnermi na vytvorenie profilu vašich záujmov.</li>
                    <li><strong>Preferenčné (Preferences):</strong> Umožňujú stránke poskytovať vylepšenú funkcionalitu a prispôsobenie (napr. jazyk).</li>
                </ul>
                <p>
                  Svoj súhlas môžete kedykoľvek zmeniť alebo odvolať kliknutím na odkaz "Nastavenia Cookies" v pätičke stránky.
                </p>
                <button class="cookie-settings-trigger btn-outline btn-outline--mt" type="button" aria-haspopup="dialog" aria-controls="cookieConsentModal">Otvoriť nastavenia cookies</button>

                <h3>6. Zmeny v týchto pravidlách</h3>
                <p>
                  Tieto Zásady ochrany osobných údajov môžeme z času na čas aktualizovať, aby odrážali zmeny v našich postupoch alebo z iných prevádzkových, právnych alebo regulačných dôvodov. Odporúčame vám, aby ste túto stránku pravidelne kontrolovali.
                </p>

            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>