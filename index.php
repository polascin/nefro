<?php
require_once 'auth.php';
require_once 'db_config.php';
// Bezpečnostné HTTP hlavičky
header_remove("X-Powered-By");
header("X-Frame-Options: SAMEORIGIN"); // Ochrana pred Clickjackingom
header("X-XSS-Protection: 0"); // Legacy hlavička, moderné prehliadače používajú CSP
header("X-Content-Type-Options: nosniff"); // Zabránenie MIME-sniffingu
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload"); // Vynútenie HTTPS
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

$monthsLocative = [
  1 => 'januári',
  2 => 'februári',
  3 => 'marci',
  4 => 'apríli',
  5 => 'máji',
  6 => 'júni',
  7 => 'júli',
  8 => 'auguste',
  9 => 'septembri',
  10 => 'októbri',
  11 => 'novembri',
  12 => 'decembri',
];
$currentMonth = (int) date('n');
$currentYear = date('Y');
$currentMonthYearLocative = ($monthsLocative[$currentMonth] ?? '') . ' ' . $currentYear;
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
  <meta name="description" content="Nefro-projekt Slovensko. Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu. MUDr. Ľubomír Polaščín. https://nefro.polascin.net/">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="keywords" content="nefrológia, Slovensko, CKD, dialýza, IgAN, gliflozíny, MUDr. Ľubomír Polaščín">
  <meta name="author" content="Dr. Ľubomír Polaščín">
  <link rel="canonical" href="https://nefro.polascin.net/">
  <link rel="alternate" hreflang="sk-SK" href="https://nefro.polascin.net/">

  <!-- Open Graph (Social SEO) -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="Nefro-projekt Slovensko">
  <meta property="og:description" content="Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.">
  <meta property="og:url" content="https://nefro.polascin.net/">
  <meta property="og:site_name" content="Nefro-projekt Slovensko">
  <meta property="og:locale" content="sk_SK">
  <meta property="og:image" content="https://nefro.polascin.net/img/nps-logo.gif">
  <meta property="og:image:alt" content="Logo Nefro-projekt Slovensko">

  <!-- Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Nefro-projekt Slovensko">
  <meta name="twitter:description" content="Dynamická renesancia nefrológie a moderné prístupy v liečbe.">
  <meta name="twitter:image" content="https://nefro.polascin.net/img/nps-logo.gif">

  <title>Nefro-projekt Slovensko</title>

  <!-- JSON-LD Štruktúrované dáta pre lepšie vyhľadávanie -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalOrganization",
      "name": "Nefro-projekt Slovensko",
      "url": "https://nefro.polascin.net/",
      "logo": "https://nefro.polascin.net/img/nps-logo.gif",
      "description": "Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.",
      "medicalSpecialty": "https://en.wikipedia.org/wiki/Nephrology",
      "founder": {
        "@type": "Person",
        "name": "MUDr. Ľubomír Polaščín",
        "jobTitle": "Lekár, Nefrológ",
        "url": "https://polascin.com/"
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

  <!-- <header>: Hlavička stránky alebo sekcie, zvyčajne obsahuje logo a hlavný nadpis -->
  <?php
  $headerTitle = 'Nefro-projekt Slovensko';
  $headerIntro = 'Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.';
  $showLogo = true;
  include 'header.php';
  ?>

  <!-- <nav>: Hlavná navigácia stránky (menu) -->
  <nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
      <ul>
        <li><a href="#domov" class="active" aria-current="page">Domov</a></li>
        <li><a href="#sluzby">Služby</a></li>
        <li><a href="#o-nas">O nás</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
        <?php if (isLoggedIn()): ?>
          <?php if (isAdmin()): ?>
            <li><a href="admin.php">Admin panel</a></li>
          <?php endif; ?>
          <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? 'Profil') ?>)</a></li>
        <?php else: ?>
          <li><a href="login.php">Prihlásenie</a></li>
          <li><a href="register.php">Registrácia</a></li>
        <?php endif; ?>
      </ul>

    </div>
  </nav>

  <!-- <main>: Hlavný obsah stránky, ktorý je pre daný dokument unikátny -->
  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">

      <!-- <article>: Nezávislý obsah, ktorý má zmysel sám o sebe (napr. článok, blogpost) -->
      <article class="primary-article">
        <header>
          <h2>IgA nefropatia: úloha APRIL v štvorzásahovom modeli patogenézy</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-11">11. máj 2026</time>
          </p>
        </header>
        <p>
          IgA nefropatia patrí medzi najčastejšie primárne glomerulonefritídy na svete. V posledných rokoch sa pohľad na jej vznik a progresiu výrazne spresnil. Kľúčovým konceptom je štvorzásahový model patogenézy, v ktorom dôležitú úlohu zohráva cytokín APRIL.
        </p>
        <p>
          Ochorenie dnes nechápeme iba ako pasívne ukladanie IgA v mezangiu, ale ako komplexný imunologický proces: od poruchy slizničnej imunity, cez tvorbu abnormálneho IgA1 a autoprotilátok, až po vznik imunitných komplexov, zápal a poškodenie glomerulov.
        </p>
        <h3>Čo je APRIL a prečo je dôležitý</h3>
        <p>
          APRIL (A Proliferation-Inducing Ligand) je cytokín podporujúci prežívanie a diferenciáciu B buniek a plazmatických buniek. Pri IgA nefropatii je významný tým, že môže podporovať tvorbu IgA a najmä patologického galaktózovo deficitného IgA1 (Gd-IgA1), ktorý stojí na začiatku patogenetickej kaskády.
        </p>
        <p>
          Z pohľadu kliniky ide o upstream mechanizmus. To znamená, že cielenie APRIL môže potenciálne zasiahnuť ochorenie vyššie v patogenetickom reťazci, nie iba tlmiť jeho neskoré dôsledky.
        </p>
        <h3>Štvorzásahový model IgA nefropatie</h3>
        <p>
          Patogenéza IgA nefropatie sa často vysvetľuje 4-hit modelom. V prvom kroku vzniká Gd-IgA1. V druhom kroku sa tvoria autoprotilátky proti tomuto abnormálnemu IgA1. V treťom kroku vznikajú cirkulujúce imunitné komplexy. V štvrtom kroku sa tieto komplexy ukladajú v mezangiu, aktivujú lokálny zápal, komplement a vedú k progresívnemu glomerulovému poškodeniu.
        </p>
        <p>
          Klinickým dôsledkom sú hematúria, proteinúria, pokles eGFR a pri progresívnom priebehu aj chronická choroba obličiek až zlyhanie obličiek.
        </p>
        <h3>Pacient za diagnózou: variabilita rizika</h3>
        <p>
          IgA nefropatia má veľmi heterogénny priebeh. U časti pacientov je zachytená náhodne pri mikroskopickej hematúrii, iní prichádzajú s epizódami makroskopickej hematúrie po infekcii horných dýchacích ciest, ďalší už pri diagnóze majú významnú proteinúriu, hypertenziu alebo zníženú eGFR.
        </p>
        <p>
          Preto je rozhodujúca stratifikácia rizika podľa proteinúrie, krvného tlaku, hodnoty a dynamiky eGFR, histologického nálezu a celkového klinického kontextu.
        </p>
        <h3>Liečba: od nefroprotekcie k mechanistickému cielenému prístupu</h3>
        <p>
          Základom zostáva optimalizovaná nefroprotekcia: kontrola krvného tlaku, blokáda RAAS pomocou ACE inhibítorov alebo sartanov, redukcia proteinúrie, režimové opatrenia a manažment komplikácií CKD.
        </p>
        <p>
          Súčasne pribúdajú liečebné stratégie zamerané na konkrétne mechanizmy ochorenia vrátane osí APRIL/BAFF, komplementu, slizničnej tvorby IgA a endotelínovej cesty. Tento posun umožňuje individualizovanejšie rozhodovanie u pacientov s vyšším rizikom progresie.
        </p>
        <h3>Praktické posolstvo pre nefrológa</h3>
        <p>
          Moderný manažment IgA nefropatie stojí na troch pilieroch: presnej diagnostike (vrátane biopsie), dôslednej stratifikácii rizika a individualizovanej liečbe. APRIL zapadá do tohto rámca ako významný biologický faktor, ktorý môže udržiavať aktivitu ochorenia a predstavuje racionálny terapeutický cieľ.
        </p>
        <p>
          <em>Zdroj: ReachMD, program „Navigating IgA Nephropathy: Pathogenesis, The Role Of APRIL &amp; The 4-Hit Process, &amp; A Patient Case Study“</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <article class="primary-article">
        <header>
          <h2>IgA nefropatia v ére nových terapeutických možností: od podpornej liečby k cielenej terapii</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-11">11. máj 2026</time>
          </p>
        </header>
        <p>
          IgA nefropatia patrí medzi najčastejšie glomerulové ochorenia na svete. Napriek tomu, že je známa desaťročia, jej liečba prechádza jednou z najvýznamnejších zmien. Nové poznatky o patogenéze a nové lieky posúvajú klinickú prax od všeobecnej nefroprotekcie k cielenej terapii zasahujúcej konkrétne mechanizmy ochorenia.
        </p>
        <p>
          Klinický priebeh je veľmi variabilný: od dlhodobo miernych foriem až po progresiu do chronickej choroby obličiek a terminálneho zlyhania. Typickým prejavom u mladších pacientov býva synfaryngitická makroskopická hematúria, u starších skôr mikroskopická hematúria s rôznym stupňom proteinúrie.
        </p>
        <h3>Štvorzásahový model: prečo ochorenie progreduje</h3>
        <p>
          Súčasné chápanie IgA nefropatie vychádza zo štvorzásahového modelu: tvorba galaktózovo deficitného IgA1, vznik autoprotilátok, tvorba imunitných komplexov a ich ukladanie v mezangiu glomerulov. Následne sa aktivuje zápal, komplement a procesy vedúce k postupnému poškodeniu obličkového tkaniva.
        </p>
        <p>
          Práve tento patofyziologický rámec umožnil vývoj liekov, ktoré cielia slizničnú produkciu patologického IgA, B-bunkové signály, komplementové dráhy aj mechanizmy spojené s proteinúriou a fibrózou.
        </p>
        <h3>Proteinúria ako hlavný terapeutický cieľ</h3>
        <p>
          Nové odporúčania KDIGO kladú dôraz na prísnejšie ciele proteinúrie. U pacientov s rizikom progresie má byť cieľom znížiť proteinúriu aspoň pod <strong>0,5 g/deň</strong>, ideálne pod <strong>0,3 g/deň</strong>. Tento cieľ má praktický význam, pretože proteinúria je dôležitý marker aktivity ochorenia aj prediktor budúceho poklesu renálnej funkcie.
        </p>
        <h3>Základ zostáva rovnaký: kvalitná nefroprotekcia</h3>
        <p>
          Podporná liečba zostáva základom manažmentu IgA nefropatie a má byť optimalizovaná včas. Kľúčové sú najmä ACE inhibítory alebo sartany, dôsledná kontrola krvného tlaku, inhibítory SGLT2 u vhodných pacientov, režimové opatrenia a systematické znižovanie proteinúrie.
        </p>
        <p>
          Dáta zo štúdií DAPA-CKD a EMPA-KIDNEY podporujú nefroprotektívny účinok SGLT2 inhibítorov aj pri proteinurických fenotypoch vrátane IgA nefropatie.
        </p>
        <h3>Nové cielené možnosti liečby</h3>
        <p>
          Medzi dôležité novinky patria antagonisty endotelínového receptora. <strong>Sparsentan</strong> ako duálny antagonista angiotenzínového a endotelínového receptora viedol v štúdii PROTECT k výraznejšiemu poklesu proteinúrie než irbesartan. <strong>Atrasentan</strong> (štúdia ALIGN) priniesol významné zníženie proteinúrie oproti placebu, pri liečbe je však potrebné sledovať najmä retenciu tekutín.
        </p>
        <p>
          <strong>Cielený budezonid</strong> využíva črevno-obličkovú os a uvoľňuje sa v distálnom ileu, kde pôsobí na Peyerove plaky. Štúdia NefIgArd ukázala zníženie proteinúrie a priaznivejší vývoj eGFR v porovnaní s placebom.
        </p>
        <p>
          <strong>Iptakopan</strong>, inhibítor faktora B alternatívnej komplementovej dráhy, v štúdii APPLAUSE-IgAN významne znížil proteinúriu. Pri tejto liečbe je dôležitá prevencia infekcií opuzdrenými baktériami vrátane adekvátneho očkovania.
        </p>
        <p>
          Významnú pozornosť pútajú aj lieky cieliace APRIL/BAFF osi. <strong>Sibeprenlimab</strong> (anti-APRIL protilátka) podľa dostupných údajov vedie k významnému poklesu proteinúrie. Ďalšie molekuly, ako atacicept alebo povetacicept, sú vo vývoji.
        </p>
        <h3>Individualizácia rozhodovania v praxi</h3>
        <p>
          Moderná liečba IgA nefropatie si vyžaduje individualizáciu podľa výšky proteinúrie, dynamiky eGFR, krvného tlaku, histologického nálezu, veku, komorbidít, rizika nežiaducich účinkov, plánovania tehotenstva, dostupnosti liečby a preferencií pacienta.
        </p>
        <p>
          Diagnóza ostáva postavená na renálnej biopsii a prognostickom hodnotení (vrátane MEST-C), pričom výber liečby nemá byť mechanický, ale klinicky cielený.
        </p>
        <h3>Záver</h3>
        <p>
          IgA nefropatia vstupuje do novej terapeutickej éry. Podporná liečba zostáva nevyhnutným základom, no už nie je jedinou možnosťou. Kombinácia nefroprotekcie a cielenej imunomodulácie umožňuje presnejší zásah do biologického podkladu ochorenia a otvára priestor pre lepšie dlhodobé renálne výsledky.
        </p>
        <p>
          <em>Zdroj: odborné zhrnutie aktuálnych terapeutických trendov v IgA nefropatii, vrátane odporúčaní KDIGO a dát zo štúdií PROTECT, ALIGN, NefIgArd, APPLAUSE-IgAN, DAPA-CKD a EMPA-KIDNEY</em>
        </p>
        <p>
          <em>Zdroj:</em> <a href="https://luxsci.com/Yitu_rBoGz7CuP_NI_ebd1/email-link/194531/2894/take-me?v1=D26CE1E28C708445834C87CFA4E08141EE90A2D8&amp;n1=1778498451&amp;to=https://reachmd.com/segment/54415/%3fautoplay%3d1%26utm_source%3d30%26utm_medium%3d20%26utm_campaign%3d1502324%26utm_brand%3d1%26rmd_token%3d4e71790cab6d42ea4c12cc13b19b7ae7052250b1b0f16f438ebfd47a89dd195a%26utm_segment%3d%26campaign%3dWNLMKT" target="_blank" rel="noopener noreferrer">ReachMD - pôvodný odkaz</a>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <article class="primary-article">
        <header>
          <h2>Konzervatívnejšia dialyzačná stratégia pri AKI môže podporiť obnovu funkcie obličiek</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-11">11. máj 2026</time>
          </p>
        </header>
        <p>
          Nová randomizovaná klinická štúdia publikovaná v časopise <em>JAMA</em> naznačuje, že u hospitalizovaných pacientov s akútnym poškodením obličiek (AKI), ktorí vyžadujú dialýzu, môže byť konzervatívnejší prístup k dialýze spojený s častejšou obnovou funkcie obličiek pri prepustení z nemocnice.
        </p>
        <p>
          V praxi sa často rieši otázka, ako intenzívne a ako často dialyzovať pacienta v období, keď ešte existuje šanca na regeneráciu vlastnej renálnej funkcie. Tieto dáta prinášajú dôležitý pohľad: dialýza podávaná pri jasných metabolických alebo klinických indikáciách môže byť u vybraných pacientov výhodnejšia než rutinné plánované dialyzovanie trikrát týždenne.
        </p>
        <h3>Čo štúdia sledovala</h3>
        <p>
          Multicentrická randomizovaná klinická štúdia porovnávala dve stratégie u hospitalizovaných dospelých pacientov s AKI vyžadujúcim dialýzu. Konzervatívna stratégia znamenala vykonanie dialýzy iba pri splnení konkrétnych metabolických alebo klinických kritérií. Konvenčná stratégia využívala pravidelnú dialýzu trikrát týždenne až do splnenia kritérií obnovy diurézy alebo klírensu kreatinínu.
        </p>
        <p>
          Do štúdie bolo zaradených 221 pacientov v štyroch centrách v USA, pričom intervenciu dostalo 220 účastníkov. Priemerný vek bol 56 rokov, približne dve tretiny tvorili muži a priemerná východisková eGFR dosiahla 64,8 ml/min/1,73 m². Randomizácia prebehla mediánovo 9 dní po začatí náhrady funkcie obličiek.
        </p>
        <h3>Hlavný výsledok: obnova funkcie obličiek</h3>
        <p>
          Primárnym ukazovateľom bola obnova funkcie obličiek pri prepustení z nemocnice, definovaná ako stav, keď bol pacient nažive, bez potreby dialýzy a mal minimálne 14 po sebe nasledujúcich dní bez dialýzy (vrátane obdobia po prepustení).
        </p>
        <ul>
          <li><strong>64 % pacientov</strong> v konzervatívnej skupine dosiahlo obnovu funkcie obličiek.</li>
          <li><strong>50 % pacientov</strong> v konvenčnej skupine dosiahlo obnovu funkcie obličiek.</li>
        </ul>
        <p>
          Absolútny rozdiel bol 13,8 %. V neupravenej analýze bol rozdiel štatisticky významný, no v predšpecifikovanej upravenej analýze sa štatistická významnosť nepotvrdila. Veľkosť účinku preto zostáva neistá a vyžaduje potvrdenie vo väčších štúdiách.
        </p>
        <h3>Menej dialýz a viac dní bez dialýzy</h3>
        <p>
          Konzervatívny prístup bol spojený s nižším počtom dialyzačných procedúr: mediánovo <strong>1,8 dialýzy týždenne</strong> oproti <strong>3,1 dialýzy týždenne</strong> v konvenčnej skupine.
        </p>
        <p>
          Výrazný rozdiel sa ukázal aj v počte dní bez dialýzy do 28. dňa: konzervatívna skupina mala medián <strong>21 po sebe nasledujúcich dní bez dialýzy</strong>, zatiaľ čo konvenčná skupina iba <strong>5 dní</strong>.
        </p>
        <h3>Menej epizód intradialytickej hypotenzie</h3>
        <p>
          Dôležitým klinickým zistením bol nižší výskyt hypotenzie spojenej s dialýzou: v konzervatívnej skupine bolo zaznamenaných 69 príhod oproti 97 príhodám v konvenčnej skupine.
        </p>
        <p>
          Hypotenzia počas dialýzy môže zhoršovať perfúziu obličiek a potenciálne negatívne ovplyvniť ich regeneráciu. Aj preto je primeraná intenzita dialyzačnej liečby pri AKI klinicky zásadná.
        </p>
        <h3>Čo z toho vyplýva pre klinickú prax</h3>
        <p>
          U hemodynamicky stabilných pacientov s dialyzačne liečeným AKI nemusí byť automatické pokračovanie v pravidelnej dialýze trikrát týždenne vždy optimálnou stratégiou. Konzervatívnejší, indikačne cielený prístup môže byť spojený s vyšším podielom obnovy funkcie obličiek v neupravenej analýze, menším počtom dialýz, väčším počtom dní bez dialýzy a nižším výskytom hypotenzie.
        </p>
        <p>
          Zároveň však treba výsledky interpretovať opatrne, keďže upravená analýza hlavného výsledku nedosiahla štatistickú významnosť.
        </p>
        <p>
          <em>Zdroj: ReachMD, podľa randomizovanej klinickej štúdie publikovanej v JAMA</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <article class="primary-article">
        <header>
          <h2>Znižovanie krvného tlaku u pacientov s chronickým ochorením obličiek: metaanalýza</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-08">8. máj 2026</time>
          </p>
        </header>
        <p>
          V apríli 2026 časopis <em>The Lancet</em> publikoval individuálnu metaanalýzu dát (individual-participant data meta-analysis), ktorá skúmala, či znižovanie krvného tlaku prináša rovnaký kardiovaskulárny prínos pacientom s chronickým ochorením obličiek (CKD) aj pacientom bez CKD. Ide o doteraz najrozsiahlejšiu analýzu tohto typu.
        </p>
        <h3>Dizajn a populácia</h3>
        <p>
          Vedci z Blood Pressure Lowering Treatment Trialists' Collaboration analyzovali údaje zo 46 randomizovaných štúdií zahŕňajúcich <strong>285 124 účastníkov</strong>. Z nich malo 20,7 % CKD a 30,2 % diabetes 2. typu. Medián sledovania bol 4,4 roka. Primárnym sledovaným ukazovateľom boli závažné kardiovaskulárne príhody (fatálna alebo nefatálna cievna mozgová príhoda, ischemická choroba srdca, hospitalizácia alebo úmrtie pre srdcové zlyhanie).
        </p>
        <h3>Hlavné výsledky</h3>
        <p>
          <strong>Konzistentný prínos naprieč štádiami CKD</strong> – Každé zníženie systolického tlaku o 5 mm Hg bolo spojené s približne 9 – 10 % relatívnym znížením rizika závažných kardiovaskulárnych príhod. Tento efekt bol prakticky rovnaký u pacientov s CKD (HR 0,91; 95 % CI 0,87 – 0,94) aj bez CKD (HR 0,90; 95 % CI 0,88 – 0,93). Nezistila sa heterogenita účinku naprieč štádiami CKD vrátane štádií 4 – 5 ani podľa prítomnosti proteinúrie.
        </p>
        <p>
          <strong>Efekt aj pri nízkom východiskovom tlaku</strong> – Prínos pretrvával aj u pacientov s východiskovým tlakom pod 120/70 mm Hg, čo naznačuje, že neexistuje jasný „prah“, pod ktorým by liečba strácala zmysel.
        </p>
        <p>
          <strong>Triedy liekov</strong> – Sieťová metaanalýza ukázala, že hlavné triedy antihypertenzív (ACE inhibítory, blokátory receptorov angiotenzínu, blokátory kalciových kanálov, diuretiká, betablokátory) mali podobný relatívny účinok voči placebu. Prínos teda nie je viazaný na konkrétnu triedu, ale na samotné zníženie tlaku.
        </p>
        <p>
          <strong>Výnimka – pacienti s CKD a diabetom</strong> – V rámci podskupiny CKD bol účinok liečby významne slabší u pacientov s diabetom (HR 0,96; 95 % CI 0,90 – 1,02) oproti pacientom s CKD bez diabetu (HR 0,88; 95 % CI 0,84 – 0,93). Interakcia bola štatisticky významná (p = 0,044). Tento signál vyžaduje ďalšie overenie.
        </p>
        <h3>Čo to znamená v praxi?</h3>
        <p>
          Zistenia podporujú <strong>univerzálne znižovanie kardiovaskulárneho rizika</strong> pomocou antihypertenzívnej liečby u pacientov s CKD – bez ohľadu na štádium ochorenia, východiskový tlak alebo triedu lieku. Výnimku môžu tvoriť pacienti s kombináciou CKD a diabetu, kde je prínos menej výrazný a rozhodovanie by malo byť individuálne.
        </p>
        <p>
          Autori zdôrazňujú, že liečba by sa nemala odkladať ani u pacientov s pokročilým CKD (štádium 4 – 5), ktorí sú často z kardiovaskulárnych štúdií vylučovaní.
        </p>
        <p>
          <em>Zdroj: ReachMD / The Lancet, publikované v apríli 2026</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <article class="primary-article">
        <header>
          <h2>Porovnávacia účinnosť liečby IgA nefropatie: sieťová metaanalýza</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-08">8. máj 2026</time>
          </p>
        </header>
        <p>
          V apríli 2026 bola publikovaná bayesovská sieťová metaanalýza, ktorá porovnala konvenčné imunosupresíva s novšími cielenými liekmi pri liečbe IgA nefropatie (IgAN) u dospelých. Vedci prehľadali databázy PubMed, Cochrane Library, Web of Science, Scopus a Embase od začiatku do marca 2025 a do analýzy zaradili 17 randomizovaných klinických štúdií.
        </p>
        <h3>Aké lieky sa porovnávali?</h3>
        <ul>
          <li>Metylprednizolón</li>
          <li>Mykofenolát mofetil</li>
          <li>Takrolimus</li>
          <li>Nefecon (budezonid s cieleným uvoľňovaním)</li>
          <li>Iptakopan</li>
          <li>Sibeprenlimab</li>
        </ul>
        <p>
          Všetky lieky sa porovnávali s placebom alebo štandardnou podpornou liečbou. Sledovali sa renálne funkcie (eGFR slope), proteinúria (pomer bielkovín a kreatínu v moči – UPCR) a závažné nežiaduce udalosti.
        </p>
        <h3>Hlavné výsledky</h3>
        <p>
          <strong>Funkcia obličiek (eGFR slope)</strong> – Nefecon dosiahol najpriaznivejší bodový odhad a najvyššie SUCRA hodnotenie, čo naznačuje potenciálne priaznivý signál. 95 % intervaly dôveryhodnosti však zahŕňali nulový efekt, takže nemožno hovoriť o preukázanej nadradenosti.
        </p>
        <p>
          <strong>Proteinúria</strong> – Metylprednizolón viedol k najväčšiemu zníženiu pomeru bielkovín a kreatínu v moči (UPCR) v porovnaní s placebom. Aj iptakopan a sibeprenlimab boli spojené so znížením proteinúrie. Viaceré liečby teda vykázali prínos, no ich vzájomné postavenie zostáva neisté.
        </p>
        <p>
          <strong>Bezpečnosť</strong> – Porovnania závažných nežiaducich udalostí boli prevažne nepresvedčivé, keďže údajov bolo málo a intervaly neistoty široké. Iptakopan vykázal numericky nižší výskyt závažných nežiaducich udalostí, ale aj tento signál zostáva neistý.
        </p>
        <p>
          <strong>Podskupiny</strong> – Analýzy nepreukázali, že by bol účinok liečby výrazne ovplyvnený vstupnou funkciou obličiek (eGFR pod alebo nad 60 ml/min/1,73 m²).
        </p>
        <h3>Čo to znamená v praxi?</h3>
        <p>
          Autori zdôrazňujú, že ide o <strong>exploratívne zistenia</strong>, nie o dôkaz nadradenosti niektorej liečby. Sieť porovnaní bola riedka, režimy liečby heterogénne a sledovanie krátke. Na jednoznačné závery sú potrebné väčšie a dlhšie štúdie s priamym porovnávaním liekov a tvrdými renálnymi ukazovateľmi (napr. zlyhanie obličiek).
        </p>
        <p>
          Napriek obmedzeniam môžu tieto signály pomôcť pri <strong>individualizovanom rozhodovaní</strong> o liečbe u konkrétnych pacientov s IgA nefropatiou.
        </p>
        <p>
          <em>Zdroj: ReachMD, zverejnené 24. apríla 2026</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <article class="primary-article">
        <header>
          <h2>Kardio-nefro-metabolická revolúcia beží na plné obrátky</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-04-25">25. Apríl 2026</time>
          </p>
        </header>
        <p>
          SGLT2 inhibítory (gliflozíny) už dnes vnímame ako absolútny štandard a základný kameň terapie. Skutočným zemetrasením posledných mesiacov však bola ofenzíva GLP-1 receptorových agonistov. Po prelomových dátach zo štúdie FLOW sa v rokoch 2025 a 2026 indikácie molekúl ako semaglutid oficiálnerozšírili priamo na spomalenie progresie chronického ochorenia obličiek (CKD). Keď tento prístup elegantne skombinujeme s nesteroidnými antagonistami mineralokortikoidových receptorov (ako je finerenón) a novými inhibítormi aldosterón syntázy, máme v rukách nefarmakologický a farmakologický arzenál, ktorý mení prirodzený priebeh diabetickej aj nediabetickej nefropatie.
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <!-- Ďalší <article> v hlavnom obsahu -->
      <article class="primary-article">
        <header>
          <h2>Zlatý vek pre IgA nefropatiu a zriedkavé glomerulopatie</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-04-25">25. Apríl 2026</time>
          </p>
        </header>
        <p>
          Roky sme boli odkázaní na neselektívnu imunosupresiu kortikoidmi so všetkými jej devastačnými vedľajšími účinkami. Súčasnosť patrí precíznej medicíne. V poslednom období sa schválili a do praxe zaviedli lieky zasahujúce priamo do patogenézy. Či už hovoríme o duálnych antagonistoch receptorov pre endotelín a angiotenzín (sparsentan), alebo o fascinujúcej biologickej liečbe. Modulácia komplementovej kaskády (napríklad iptakopan) a blokátory dráh APRIL/BAFF (sibeprenlimab) postupne menia prognózu pacientov s IgAN z fatálnej na chronicky manažovateľnú.
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <!-- Ďalší <article> v hlavnom obsahue -->
      <article class="primary-article">
        <header>
          <h2>Inovácie v dialýze a manažmente anémie</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-04-25">25. Apríl 2026</time>
          </p>
        </header>
        <p>
          V oblasti dialýzy sú kľúčové najnovšie odporúčania z jari 2026 týkajúce sa inkrementálnej peritoneálnej dialýzy. Tento koncept naberá na obrovskej popularite, pretože je šetrnejší k pacientom, predlžuje zachovanie reziduálnej renálnej funkcie a zlepšuje kvalitu života. Čo sa týka anémie pri CKD, v praxi sa definitívne etablujú HIF-PH inhibítory (ako roxadustat či daprodustat). Princíp oklamania senzoru pre hypoxiu v tele bez nutnosti injekčného podávania erytropoézu stimulujúcich látok (ESA) je fyziologicky čistým riešením. Pre pacienta to znamená obrovský komfort perorálnej liečby a pre personál menej logistickej záťaže.
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <!-- Ďalší <article> v hlavnom obsahu -->
      <article class="primary-article">
        <header>
          <h2>Keď sa nefrológia stretne s kódom</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-04-25">25. Apríl 2026</time>
          </p>
        </header>
        <p>
          Nefrológia a dialýza generujú gigantické množstvo dát z laboratórnych výsledkov, monitorovania tlaku krvi, pulzu, parametrov ultrafiltrácie a mnohých ďalších. Dnes vidíme masívny nástup prediktívnych modelov, ktoré dokážu na základe zdanlivo nesúvisiacich premenných predpovedať trajektóriu poklesu eGFR alebo riziko intradialytickej hypotenzie.
        </p>
        <p>
          <strong>Programátori a lekári.</strong> Schopnosť spojiť prísny klinický úsudok lekára s algoritmickým myslením programátora je dnes neuveriteľne vzácna. S technologickým stackom (PHP, JS, Python, HTML, CSS) môže byť jeden v dokonalej pozícii nielen konzumovať medicínske vedomosti, ale rovno budovať vlastné nástroje a aplikácie. Môže vytvárať systémy na mieru pre svoje dialyzačné stredisko, ktoré budú analyzovať trendy pacientov a automatizovať administratívu.
        </p>
        <p>
          Je fascinujúce sledovať, ako sa jazyk medicíny a jazyk kódu prelínajú do jedného zmysluplného celku. Aký je váš pohľad na integráciu týchto nových technológií alebo liekov priamo vo vašom stredisku? Vidíte už niektoré z týchto inovácií reálne rezonovať na oddelení alebo v praxi aj na Slovensku?
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <!-- Sekcia Služby -->
      <section class="features-section" id="sluzby">
        <h2>Poskytované služby a expertíza</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Nefrológia a Dialýza</h3>
            <p>
              Komplexná starostlivosť. Špecializácia na liečbu obličkových chorôb, renálnu nahradzujúcu liečbu (hemodialýza, hemodiafiltrácia, peritoneálna dialýza), ultrasonografiu orgánov brucha so zameraním na uropoetický systém, ultrasonografiu cievnych prístupov a mimotelové eliminačné metódy.
            </p>
          </div>
          <div class="feature-card">
            <h3>Lektorstvo a vzdelávanie</h3>
            <p>
              Rozsiahle skúsenosti s výučbou a odborným prednášaním predovšetkým v oblasti nefrológie a vnútorného lekárstva pre odbornú ale aj laickú verejnosť. Dlhodobá spolupráca s univerzitnými pracoviskami ako aj so spoločnosťami zaoberajúcimi sa vzdelávaním zdravotníckeho personálu.
            </p>
          </div>
          <div class="feature-card">
            <h3>Medicínske preklady</h3>
            <p>
              Špecializované preklady medicínskych dokumentov a lokalizácia softvéru (AJ/SJ) s maximálnym dôrazom na presnú klinickú terminológiu. Preklady sú vždy na vysokej odbornej úrovni, bez gramatických chýb a s dôrazom na detail.
            </p>
          </div>
          <div class="feature-card">
            <h3>IT a AI riešenia</h3>
            <p>
              Vývoj na mieru šitých medicínskych aplikácií, integrácia AI nástrojov pre spracovanie dát a modernizácia zdravotníckych systémov.
            </p>
          </div>
        </div>
      </section>

      <!-- Sekcia O nás -->
      <section class="features-section" id="o-nas">
        <h2>O mne</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Kto som</h3>
            <p>
              Som <strong>MUDr. Ľubomír Polaščín</strong> — lekár so špecializáciou v nefrológii a vnútornom lekárstve. Okrem medicíny sa aktívne venujem písaniu beletrie i odbornej literatúry a s vášňou vyvíjam webové riešenia a aplikácie. Moja práca stojí na prieniku zdravotníctva, literatúry a moderných IT technológií.
            </p>
          </div>
          <div class="feature-card">
            <h3>Odborná prax</h3>
            <p>
              Promoval som v odbore Všeobecné lekárstvo (1995), mám atestáciu z interného lekárstva (1998) a špecializáciu v nefrológii (2009). Dlhodobo sa zameriavam na dialýzu a o.i. som od roku 2013 do 2022 pôsobil ako primár a vedúci lekár v dvoch dialyzačných strediskách v Bratislave.
            </p>
          </div>
        </div>
      </section>

      <!-- Ďalšia nezávislá <section> v hlavnom obsahu -->
      <section class="features-section" id="kontakt">
        <h2>Kontakty a spolupráca</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Máte otázky alebo sa chcete zapojiť?</h3>
            <p>
              Radi uvítame akúkoľvek formu diskusie, spolupráce či dotazov. Neváhajte nás kedykoľvek kontaktovať.
            </p>
            <a href="mailto:nefro@polascin.net" class="btn-primary">Napísať e-mail</a>
          </div>
          <div class="feature-card">
            <h3>Staňte sa súčasťou komunity</h3>
            <p>
              Zaregistrujte sa a získajte prístup k obsahu. Pri registrácii si môžete zvoliť súhlas so zasielaním noviniek a my vás budeme ihneď informovať o najnovších príspevkoch a analýzach.
            </p>
            <?php if (!isLoggedIn()): ?>
              <br><a href="register.php" class="btn-primary mt-15 d-inline-block">Registrovať sa</a>
            <?php else: ?>
              <div class="badge-highlight">Ste prihlásený</div>
            <?php endif; ?>
          </div>
        </div>
      </section>
    </div>

    <!-- <aside>: Bočný panel, obsah, ktorý len okrajovo súvisí s hlavným obsahom -->
    <aside class="sidebar">
      <div class="widget">
        <h3>Náhodný obrázok</h3>
        <?php
        // Získanie všetkých obrázkov zodpovedajúcich štruktúre
        $images = glob('./img/nefro_*.png');
        if ($images && count($images) > 0) {
          // Výber náhodného obrázka
          $randomIndex = array_rand($images);
          $randomImagePath = $images[$randomIndex];

          echo '<a href="' . htmlspecialchars($randomImagePath) . '" id="randomImageLink" target="_blank" rel="noopener noreferrer" title="Zobraziť obrázok v plnej veľkosti" aria-label="Zobraziť náhodný abstraktný obrázok v plnej veľkosti">';
          echo '<img id="randomImage" src="' . htmlspecialchars($randomImagePath) . '" alt="Náhodný abstraktný obrázok Nefro">';
          echo '</a>';
        } else {
          echo "<p>\n";
          echo "Žiadne obrázky neboli nájdené.\n";
          echo "</p>";
        }
        ?>
      </div>

      <div class="widget">
        <img src="./img/nps.gif" alt="Nefro-projekt Slovensko Logo" class="header-logo">
        <h3>O projekte</h3>
        <p>
          Ako nefrológa a nadšenca pre internú medicínu ma fascinuje, akou obrovskou a dynamickou renesanciou prechádza naša nefrologická špecializácia. Sme v <?= htmlspecialchars($currentMonthYearLocative, ENT_QUOTES, 'UTF-8') ?> a nefrológia sa rozvíja míľovými krokmi. Nie je to už len o manažovaní terminálneho zlyhania obličiek a čakaní na transplantáciu. Zažívame doslova explóziu inovácií, od molekulárnej biológie až po umelú inteligenciu.
        </p>
      </div>
      <div class="widget">
        <h3>Užitočné odkazy</h3>
        <ul>
          <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element" target="_blank" rel="noopener noreferrer">MDN: HTML
              Elementy</a></li>
          <li><a href="https://html.spec.whatwg.org/" target="_blank" rel="noopener noreferrer">HTML
              Špecifikácia</a></li>
          <li><a href="https://tc39.es/ecma262/" target="_blank" rel="noopener noreferrer">JavaScript
              (ECMAScript) Špecifikácia</a></li>
          <li><a href="https://www.php.net/manual/en/langref.php" target="_blank" rel="noopener noreferrer">PHP
              Špecifikácia
              (Manual)</a></li>
          <li><a href="https://docs.python.org/3/reference/" target="_blank" rel="noopener noreferrer">Python
              Špecifikácia jazyka</a>
          </li>
          <li><a href="https://sk.polascin.net/" target="_blank" rel="noopener noreferrer">Polascin.net
              (SK)</a></li>
          <li><a href="https://nephrosite.polascin.net/" target="_blank" rel="noopener noreferrer">Nephrosite</a></li>
          <li><a href="https://polascin.net/" target="_blank" rel="noopener noreferrer">Polascin.net (EN)</a>
          </li>
          <li><a href="https://polascin.com/" target="_blank" rel="noopener noreferrer">Polascin.com</a></li>
          <li><a href="https://books.polascin.net/" target="_blank" rel="noopener noreferrer">Polascin
              Books</a></li>
        </ul>
      </div>
    </aside>
  </main>

  <?php include 'footer.php'; ?>