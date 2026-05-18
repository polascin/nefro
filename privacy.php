<?php
require_once 'auth.php';
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
  . "style-src 'self' https://fonts.googleapis.com; "
  . "font-src 'self' https://fonts.gstatic.com; "
  . "script-src 'self' https://www.googletagmanager.com https://www.google-analytics.com; "
  . "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; "
  . "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests";
header("Content-Security-Policy: " . $csp);
$pageLastUpdated = date('d.m.Y', filemtime(__FILE__));
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
    <meta name="description" content="Zásady ochrany osobných údajov a Cookie Policy pre Nefro-projekt Slovensko — informácie o spracúvaní údajov, Google Analytics 4 a právach dotknutých osôb (GDPR).">
    <meta name="robots" content="noindex, follow">
    <link rel="canonical" href="https://nefro.polascin.net/privacy.php">
    <link rel="alternate" hreflang="sk-SK" href="https://nefro.polascin.net/privacy.php">

    <!-- Open Graph (Social SEO) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Ochrana osobných údajov | Nefro-projekt Slovensko">
    <meta property="og:description" content="Zásady ochrany osobných údajov a Cookie Policy pre Nefro-projekt Slovensko.">
    <meta property="og:url" content="https://nefro.polascin.net/privacy.php">
    <meta property="og:site_name" content="Nefro-projekt Slovensko">
    <meta property="og:locale" content="sk_SK">
    <meta property="og:image" content="https://nefro.polascin.net/img/nps-logo.gif">
    <meta property="og:image:alt" content="Logo Nefro-projekt Slovensko">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Ochrana osobných údajov | Nefro-projekt Slovensko">
    <meta name="twitter:description" content="Zásady ochrany osobných údajov a Cookie Policy pre Nefro-projekt Slovensko.">
    <meta name="twitter:image" content="https://nefro.polascin.net/img/nps-logo.gif">

    <title>Ochrana osobných údajov | Nefro-projekt Slovensko</title>

    <!-- JSON-LD Štruktúrované dáta -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Ochrana osobných údajov | Nefro-projekt Slovensko",
            "url": "https://nefro.polascin.net/privacy.php",
            "description": "Zásady ochrany osobných údajov a Cookie Policy pre Nefro-projekt Slovensko.",
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

    <!-- CSS -->
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">

    <!-- Cookie Consent & GA4 Consent Mode v2 -->
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>

<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Zásady ochrany osobných údajov';
    $headerIntro = 'Privacy Policy & Cookie Policy';
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
                        Posledná aktualizácia:&nbsp;
                        <time datetime="2026-05-15"><?= $pageLastUpdated ?></time>
                    </p>
                </header>

                <!-- 1. ÚVODNÉ USTANOVENIA -->
                <h3>1. Úvodné ustanovenia a prevádzkovateľ</h3>
                <p>
                    Tieto Zásady ochrany osobných údajov (<em>ďalej len „Zásady"</em>) vysvetľujú,
                    ako webová lokalita <strong>Nefro-projekt Slovensko</strong>
                    (<code>https://nefro.polascin.net</code>) zhromažďuje, používa a chráni
                    vaše osobné údaje v súlade s:
                </p>
                <ul>
                    <li>Nariadením (EÚ) 2016/679 (GDPR),</li>
                    <li>zákonom č. 18/2018 Z. z. o ochrane osobných údajov,</li>
                    <li>smernicou ePrivacy (2002/58/ES v znení 2009/136/ES),</li>
                    <li>požiadavkami CCPA/CPRA pre návštevníkov z Kalifornie.</li>
                </ul>
                <p>
                    <strong>Prevádzkovateľ:</strong> MUDr. Ľubomír Polaščín<br>
                    <strong>Kontakt:</strong> <code>nefro@polascin.net</code>
                </p>

                <!-- 2. AKÉ ÚDAJE ZHROMAŽĎUJEME -->
                <h3>2. Aké osobné údaje spracúvame</h3>

                <h4 class="privacy-subheading">2a. Registrovaní používatelia</h4>
                <p>
                    Pri registrácii a používaní konta spracúvame:
                </p>
                <ul>
                    <li><strong>Identifikačné údaje:</strong> meno, priezvisko, používateľské meno, e-mailová adresa, voliteľne mobilné telefónne číslo.</li>
                    <li><strong>Profesijné údaje:</strong> titul pred menom / za menom, pracovná funkcia, organizácia, pracovný e-mail, pracovný mobil, webová adresa organizácie (voliteľné polia v profile).</li>
                    <li><strong>Autentifikačné údaje:</strong> hašované heslo (bcrypt), čas posledného prihlásenia, IP adresa pri prihlásení.</li>
                    <li><strong>Avatar:</strong> voliteľne nahraná profilová fotografia uložená na serveri.</li>
                    <li><strong>Klinické výsledky kalkulačiek:</strong> výsledky výpočtov uložené na žiadosť lekára spolu s anonymizovanými pacientskymi identifikátormi (meno, dátum narodenia, rodné číslo, kód poisťovne — vkladá ich výhradne prihlásený lekár, sú asociované s jeho kontom).</li>
                </ul>
                <p>
                    <strong>Právny základ:</strong> plnenie zmluvy (čl. 6 ods. 1 písm. b) GDPR),
                    oprávnený záujem na bezpečnosti systému (čl. 6 ods. 1 písm. f) GDPR).
                </p>

                <h4 class="privacy-subheading">2b. Všetci návštevníci</h4>
                <ul>
                    <li><strong>Prevádzkové záznamy (server logy):</strong> IP adresa, typ prehliadača, operačný systém, URL požiadavky, čas prístupu — uchovávané z dôvodu bezpečnosti a ladenia.</li>
                    <li><strong>Analytické dáta (GA4):</strong> iba so súhlasom — anonymizované štatistiky návštevnosti cez Google Analytics 4 (pozri sekciu 5).</li>
                    <li><strong>Nastavenia súkromia:</strong> váš cookie-súhlas uložený v <code>localStorage</code> a cookie <code>nps_cookie_consent</code> (platnosť 365 dní).</li>
                </ul>

                <!-- 3. SPRACOVANIE A VYUŽITIE -->
                <h3>3. Účely a právne základy spracúvania</h3>
                <ul>
                    <li>Zabezpečenie fungovania, integrity a bezpečnosti webovej lokality.</li>
                    <li>Správa používateľských kont, autentifikácia a obnova hesla.</li>
                    <li>Ukladanie a zobrazovanie výsledkov klinických kalkulačiek na žiadosť lekára.</li>
                    <li>Zasielanie e-mailových notifikácií o nových článkoch a aktualizáciách (newsletter) — iba so súhlasom a s možnosťou odhlásenia.</li>
                    <li>Analýza návštevnosti a zlepšovanie obsahu (iba so súhlasom, cez GA4).</li>
                </ul>
                <p>
                    <strong>Vaše osobné údaje nepredávame, neobchodujeme s nimi ani ich neprenajímame
                    tretím stranám.</strong> (<em>„We do not sell your personal information"</em>
                    v zmysle CCPA/CPRA.)
                </p>

                <!-- 4. PRÁVA DOTKNUTÝCH OSÔB -->
                <h3>4. Vaše práva (GDPR)</h3>
                <p>V zmysle GDPR máte nasledujúce práva:</p>
                <ul>
                    <li><strong>Právo na prístup</strong> — môžete požiadať o kópiu vašich osobných údajov.</li>
                    <li><strong>Právo na opravu</strong> — nepresné údaje môžete opraviť priamo v profile.</li>
                    <li><strong>Právo na vymazanie</strong> — môžete požiadať o zmazanie konta a všetkých súvisiacich údajov.</li>
                    <li><strong>Právo na obmedzenie spracúvania</strong> — za určitých podmienok môžete požiadať o pozastavenie spracúvania.</li>
                    <li><strong>Právo na prenosnosť údajov</strong> — môžete požiadať o export vašich údajov v štruktúrovanom formáte.</li>
                    <li><strong>Právo namietať</strong> — môžete namietať spracúvanie na základe oprávneného záujmu.</li>
                    <li><strong>Právo odvolať súhlas</strong> — súhlas s cookies môžete kedykoľvek zmeniť (tlačidlo nižšie).</li>
                </ul>
                <p>
                    Pre uplatnenie týchto práv nás kontaktujte na: <code>nefro@polascin.net</code>.
                    Máte tiež právo podať sťažnosť na Úrad na ochranu osobných údajov SR
                    (<a href="https://www.uoou.sk" target="_blank" rel="noopener noreferrer">www.uoou.sk</a>).
                </p>

                <!-- 4a. GDPR DOLOŽKA -->
                <h3>4a. GDPR doložka</h3>
                <p>
                    V prípade spracúvania osobných údajov postupujeme v súlade s GDPR
                    a uplatňujeme tieto právne základy:
                </p>
                <ul>
                    <li>
                        <strong>Plnenie zmluvy</strong> (čl. 6 ods. 1 písm. b GDPR) – spracúvanie
                        údajov pre registráciu, prihlásenie, nahrávanie a spracovanie výsledkov
                        kalkulačiek a poskytovanie služieb prihlásenému používateľovi.
                    </li>
                    <li>
                        <strong>Oprávnený záujem</strong> (čl. 6 ods. 1 písm. f GDPR) – prevádzka
                        bezpečného webu, ochrana pred zneužitím, detekcia útokov, audit a
                        zabezpečenie integrity aplikácie.
                    </li>
                    <li>
                        <strong>Súhlas</strong> (čl. 6 ods. 1 písm. a GDPR) – spracúvanie analytických
                        cookies, marketingových nastavení a newsletterov na základe dobrovoľného
                        udelenia súhlasu.
                    </li>
                </ul>
                <p>
                    Osobné údaje získavame priamo od vás pri registrácii, pri úprave profilu,
                    pri zasielaní formulárov a pri používaní stránky prostredníctvom cookies.
                </p>
                <p>
                    Príjemcami údajov sú výlučne interné systémy služby a dôveryhodné tretie
                    strany, ktoré poskytujú technickú infraštruktúru, analytiku, e-mailové služby
                    a bezpečnosť. Medzi ne patria napríklad Google Analytics 4 a iné služby,
                    ktoré spracúvajú údaje výlučne na základe nášho pokynu.
                </p>
                <p>
                    Prenosy údajov mimo Európskej únie sú realizované výhradne na základe
                    platných právnych mechanizmov GDPR, vrátane štandardných zmluvných doložiek
                    (SCC) alebo iných vhodných ochranných opatrení.
                </p>
                <p>
                    Doba uchovávania jednotlivých kategórií údajov je opísaná v sekcii 6.
                    Uchovávame ich len po dobu nevyhnutnú na naplnenie účelu spracovania.
                </p>
                <p>
                    V prípade zmeny zásad alebo aktualizácie verzie súhlasu platí, že systém
                    automaticky vyžiada nový súhlas používateľa pre analytické a marketingové
                    cookies. Toto je v súlade s čl. 7 ods. 3 GDPR.
                </p>

                <!-- 5. COOKIES & GA4 -->
                <h3>5. Súbory cookies a Google Analytics 4</h3>
                <p>
                    Naša stránka používa súbory cookies a podobné technológie ukladania (vrátane
                    <code>localStorage</code>). Pri prvej návšteve sa zobrazí banner, kde si môžete
                    zvoliť kategórie cookies.
                </p>

                <h4 class="privacy-subheading">Kategórie cookies</h4>
                <ul>
                    <li>
                        <strong>Nevyhnutné (Strictly Necessary):</strong> zabezpečujú základné
                        fungovanie webu (prihlásenie, CSRF ochrana, uloženie tohto súhlasu
                        v <code>nps_cookie_consent</code>). Nie je možné ich vypnúť.
                    </li>
                    <li>
                        <strong>Analytické (Analytics):</strong> <em>len so súhlasom.</em>
                        Používame <strong>Google Analytics 4</strong> (merací ID:
                        <code>G-0JT5VMQ61K</code>), ktorý zhromažďuje anonymizované štatistiky
                        návštevnosti (počet relácií, zobrazenia stránok, typ zariadenia).
                        GA4 je implementovaný cez <strong>Google Consent Mode v2</strong> —
                        skript sa načíta vždy, no odosielanie dát je podmienené vaším súhlasom
                        (<code>analytics_storage: granted/denied</code>).
                        Dáta spracúva Google LLC, USA; prenos je krytý štandardnými zmluvnými
                        doložkami (SCC) podľa čl. 46 GDPR.
                        Viac info:
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google Privacy Policy</a>,
                        <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer">Google Analytics Opt-out</a>.
                    </li>
                    <li>
                        <strong>Marketingové (Marketing):</strong> <em>len so súhlasom.</em>
                        Kontrolujú parametre GA4 <code>ad_storage</code>,
                        <code>ad_user_data</code> a <code>ad_personalization</code>.
                        Aktuálne nie sú aktívne žiadne reklamné kampane.
                    </li>
                    <li>
                        <strong>Preferenčné (Preferences):</strong> <em>len so súhlasom.</em>
                        Uchovávajú vaše nastavenia rozhrania (napr. tmavý režim).
                    </li>
                </ul>

                <h4 class="privacy-subheading">Uloženie súhlasu</h4>
                <p>
                    Váš súhlas sa ukladá do <code>localStorage</code> prehliadača (primárne)
                    a zálohou do cookie <code>nps_cookie_consent</code> s platnosťou
                    <strong>365 dní</strong>, <code>SameSite=Lax; Secure</code>.
                    Súhlas môžete kedykoľvek zmeniť alebo odvolať:
                </p>
                <button class="cookie-settings-trigger btn-outline btn-outline--mt"
                        type="button"
                        aria-haspopup="dialog"
                        aria-controls="cookieConsentModal">
                    Otvoriť nastavenia cookies
                </button>

                <!-- 6. UCHOVÁVANIE ÚDAJOV -->
                <h3>6. Doba uchovávania údajov</h3>
                <ul>
                    <li><strong>Používateľské kontá:</strong> po dobu aktívneho používania; na žiadosť možné okamžité vymazanie.</li>
                    <li><strong>Výsledky kalkulačiek:</strong> uchované, kým ich používateľ nevymaže alebo nepožiada o zmazanie konta.</li>
                    <li><strong>Server logy:</strong> maximálne 90 dní, potom automaticky mazané.</li>
                    <li><strong>GA4 dáta:</strong> štandardne 14 mesiacov v Google Analytics (nastaviteľné v konzole GA4); Google ich môže anonymizovať po uplynutí lehoty.</li>
                    <li><strong>Cookie súhlas:</strong> 365 dní (po uplynutí sa banner znova zobrazí).</li>
                </ul>

                <!-- 7. BEZPEČNOSŤ -->
                <h3>7. Bezpečnosť údajov</h3>
                <p>
                    Webová lokalita využíva HTTPS (HSTS), hašovanie hesiel (bcrypt),
                    CSRF tokeny vo formulároch, parametrizované SQL dopyty (PDO),
                    striktné HTTP bezpečnostné hlavičky (CSP, X-Frame-Options, HSTS)
                    a overenie e-mailovej adresy pri registrácii.
                </p>

                <!-- 8. ZMENY -->
                <h3>8. Zmeny týchto Zásad</h3>
                <p>
                    Tieto Zásady môžeme aktualizovať. Dátum poslednej aktualizácie je uvedený
                    v záhlaví dokumentu a je automaticky generovaný podľa dátumu poslednej
                    úpravy súboru. Pri podstatných zmenách vás upozorníme bannerom alebo
                    e-mailom (ak ste registrovaní).
                </p>
                <p>
                    <strong>Automatické opätovné vyžiadanie súhlasu:</strong>
                    Náš systém správy cookies uchováva verziu platného súhlasu.
                    Pri každej podstatnej zmene týchto Zásad sa verzia aktualizuje
                    a všetkým návštevníkom sa automaticky znova zobrazí banner
                    na potvrdenie nových podmienok — bez ohľadu na predtým udelený súhlas.
                    Toto je v súlade s čl. 7 ods. 3 GDPR.
                </p>

            </article>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>