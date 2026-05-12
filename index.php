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
          <h2>Tirzepatid verzus semaglutid: nižšia mortalita a menej gastrointestinálnych komplikácií?</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-11">11. máj 2026</time>
          </p>
        </header>
        <p><strong>Tirzepatid bol vo veľkej observačnej analýze z reálnej klinickej praxe spojený s nižšou celkovou mortalitou a s menším výskytom niektorých gastrointestinálnych nežiaducich udalostí v porovnaní so semaglutidom. Výsledky boli prezentované na Digestive Disease Week 2026 a môžu byť zaujímavé najmä pre diabetológov, internistov, nefrológov, kardiológov a lekárov starajúcich sa o pacientov s obezitou a diabetom 2. typu.</strong></p>
        <p>Tirzepatid a semaglutid patria medzi lieky, ktoré výrazne zmenili manažment diabetu 2. typu a obezity. Semaglutid pôsobí ako agonista GLP-1 receptorov, zatiaľ čo tirzepatid je duálny inkretínový agonista s účinkom na receptory GIP a GLP-1. Oba lieky zlepšujú glykemickú kontrolu, podporujú redukciu telesnej hmotnosti a majú potenciálne kardiometabolické benefity.</p>
        <p>Nové údaje z veľkej globálnej kohorty však naznačujú, že medzi týmito dvoma molekulami môžu existovať rozdiely nielen v účinnosti, ale aj v bezpečnostnom profile.</p>

        <h3>Veľká analýza z reálnej klinickej praxe</h3>
        <p>Výskumníci využili databázu <strong>TriNetX Global Collaborative Network</strong>, ktorá umožňuje analyzovať veľké súbory pacientov z bežnej praxe. Do štúdie zaradili pacientov s nadváhou alebo obezitou a diabetom 2. typu, ktorí začali liečbu buď tirzepatidom, alebo semaglutidom.</p>
        <p>Po párovaní podľa propensity score vznikli dve veľké, porovnateľné skupiny:</p>
        <ul>
          <li><strong>126 971 pacientov</strong> iniciujúcich tirzepatid,</li>
          <li><strong>126 971 pacientov</strong> iniciujúcich semaglutid.</li>
        </ul>
        <p>Pacienti, ktorí užívali oba lieky, boli z analýzy vylúčení. Sledované obdobie sa pohybovalo od 1 dňa do 5 rokov po začiatku liečby.</p>
        <p>Autori hodnotili najmä:</p>
        <ul>
          <li>celkovú mortalitu,</li>
          <li>gastroparézu,</li>
          <li>paralytický ileus alebo intestinálnu obštrukciu,</li>
          <li>aspiračnú pneumonitídu.</li>
        </ul>

        <h3>Nižšia celková mortalita pri tirzepatide</h3>
        <p>Najvýraznejší rozdiel sa týkal celkovej mortality. V skupine s tirzepatidom bolo zaznamenaných <strong>1182 úmrtí</strong>, zatiaľ čo v skupine so semaglutidom <strong>1998 úmrtí</strong>.</p>
        <p>V percentách to predstavovalo:</p>
        <ul>
          <li><strong>0,9 % pri tirzepatide</strong>,</li>
          <li><strong>1,6 % pri semaglutide</strong>.</li>
        </ul>
        <p>Relatívne riziko bolo <strong>0,59</strong>, čo naznačuje približne <strong>41 % relatívne nižšie riziko celkovej mortality</strong> u pacientov liečených tirzepatidom v porovnaní so semaglutidom.</p>
        <p>Treba však zdôrazniť, že ide o observačné údaje. Takýto typ analýzy vie ukázať asociáciu, nie definitívnu kauzalitu. Inými slovami, výsledok neznamená automaticky, že tirzepatid sám osebe „spôsobil" nižšiu mortalitu. Môžu sa uplatniť aj rozdiely v charakteristikách pacientov, predpisovacej praxi, dávkach, adherencii či dostupnosti zdravotnej starostlivosti.</p>

        <h3>Menej ileu, črevnej obštrukcie a aspiračnej pneumonitídy</h3>
        <p>Tirzepatid bol spojený aj s nižším rizikom niektorých gastrointestinálnych komplikácií.</p>
        <p>Výskyt paralytického ileu alebo intestinálnej obštrukcie bol:</p>
        <ul>
          <li><strong>0,9 % pri tirzepatide</strong>,</li>
          <li><strong>1,0 % pri semaglutide</strong>,</li>
        </ul>
        <p>s relatívnym rizikom <strong>0,84</strong>.</p>
        <p>Aspiračná pneumonitída bola tiež menej častá pri tirzepatide:</p>
        <ul>
          <li><strong>0,3 % pri tirzepatide</strong>,</li>
          <li><strong>0,4 % pri semaglutide</strong>,</li>
        </ul>
        <p>s relatívnym rizikom <strong>0,69</strong>.</p>
        <p>Riziko gastroparézy bolo medzi skupinami podobné:</p>
        <ul>
          <li><strong>1,0 % pri tirzepatide</strong>,</li>
          <li><strong>1,1 % pri semaglutide</strong>,</li>
        </ul>
        <p>s relatívnym rizikom <strong>0,95</strong>.</p>
        <p>Tieto rozdiely sú numericky malé, ale pri veľmi veľkých populáciách môžu byť klinicky významné, najmä ak ide o pacientov s vyšším rizikom gastrointestinálnych komplikácií, aspiračných udalostí alebo perioperačných problémov.</p>

        <h3>Prečo je to prekvapivé?</h3>
        <p>Podľa hlavnej riešiteľky Aasmy Shaukat, MD, z NYU Langone Health v New Yorku bolo prekvapivé, že tirzepatid bol napriek duálnemu inkretínovému mechanizmu spojený s menším počtom nežiaducich udalostí.</p>
        <p>Pri inkretínovej liečbe sa často diskutuje spomalenie vyprázdňovania žalúdka, nauzea, vracanie, gastroparéza a potenciálne aspiračné riziko pri anestézii alebo endoskopii. Dalo by sa preto očakávať, že silnejší alebo širší inkretínový efekt môže priniesť viac gastrointestinálnych problémov. Táto analýza však naznačuje opak, aspoň v sledovaných parametroch.</p>
        <p>Autori posteru uviedli, že tirzepatid môže v rutinnej praxi ponúkať priaznivejší pomer benefitu a rizika, kombinujúci silnejšie metabolické účinky so zachovanou žalúdočnou motilitou a nižším aspiračným rizikom.</p>

        <h3>Čo z toho vyplýva pre klinickú prax?</h3>
        <p>Výsledky môžu podporiť preferenciu tirzepatidu u vhodných pacientov s diabetom 2. typu a obezitou, najmä ak je cieľom výrazná metabolická intervencia a zároveň minimalizácia niektorých gastrointestinálnych rizík.</p>
        <p>Pre nefrologickú a internistickú prax je táto téma zaujímavá z viacerých dôvodov. Pacienti s diabetom 2. typu, obezitou, chronickou chorobou obličiek a vysokým kardiovaskulárnym rizikom často potrebujú liečbu, ktorá presahuje samotné zníženie HbA1c. Inkretínová terapia je čoraz viac vnímaná ako súčasť komplexnej kardiorenálno-metabolickej ochrany.</p>
        <p>Pri výbere medzi semaglutidom a tirzepatidom však treba zohľadniť:</p>
        <ul>
          <li>indikáciu liečby,</li>
          <li>dostupnosť a úhradu,</li>
          <li>renálnu funkciu,</li>
          <li>kardiovaskulárne riziko,</li>
          <li>telesnú hmotnosť a metabolické ciele,</li>
          <li>predchádzajúcu toleranciu liečby,</li>
          <li>gastrointestinálne príznaky,</li>
          <li>perioperačné alebo endoskopické riziko,</li>
          <li>pacientove preferencie a adherenciu.</li>
        </ul>

        <h3>Opatrnosť pri interpretácii</h3>
        <p>Napriek veľkému počtu pacientov má štúdia dôležité limity. Ide o observačnú analýzu z databázy reálnej klinickej praxe, nie o randomizovanú kontrolovanú štúdiu. Aj po párovaní pacientov môže pretrvávať reziduálne skreslenie. Niektoré premenné môžu byť neúplne zachytené alebo nesprávne kódované. Dôležité môže byť aj dávkovanie, dĺžka liečby, adherencia a dôvod výberu konkrétneho lieku.</p>
        <p>Samotní autori zdôraznili, že výsledky si vyžadujú potvrdenie v ďalších kohortách a v prospektívnych štúdiách. Plánujú tiež skúmať vzťah medzi dávkou a odpoveďou.</p>

        <h3>Praktický záver</h3>
        <p>Táto veľká globálna analýza naznačuje, že <strong>tirzepatid bol v reálnej praxi spojený s nižšou celkovou mortalitou, nižším rizikom ileu alebo črevnej obštrukcie a nižším výskytom aspiračnej pneumonitídy v porovnaní so semaglutidom</strong>. Riziko gastroparézy bolo medzi oboma liekmi podobné.</p>
        <p>Tieto výsledky sú klinicky zaujímavé, ale zatiaľ by nemali viesť k zjednodušenému záveru, že tirzepatid je univerzálne lepšou voľbou pre každého pacienta. Skôr podporujú individualizovaný výber liečby, pri ktorom sa hodnotí nielen HbA1c a telesná hmotnosť, ale aj celkový kardiorenálno-metabolický profil, gastrointestinálna tolerancia a konkrétne riziká pacienta.</p>
        <p>
          <em>Zdroj: Spracované podľa Medscape Medical News: „Tirzepatide Tied to Less Mortality and AEs Than Semaglutide", 2026.</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <!-- <article>: Nezávislý obsah, ktorý má zmysel sám o sebe (napr. článok, blogpost) -->
      <article class="primary-article">
        <header>
          <h2>GLP-1 agonisty pred operáciou: vysadiť alebo pokračovať?</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-11">11. máj 2026</time>
          </p>
        </header>
        <p><strong>Moderné antidiabetiká a antiobezitiká zo skupiny agonistov GLP-1 receptorov priniesli výrazný pokrok v liečbe diabetu 2. typu, obezity aj kardiorenálnej ochrany. V perioperačnej medicíne však otvorili praktickú otázku: majú sa pred plánovaným výkonom vysadiť, alebo je bezpečnejšie v liečbe pokračovať?</strong></p>
        <p>Agonisty GLP-1 receptorov, medzi ktoré patria napríklad semaglutid, liraglutid, dulaglutid či tirzepatid s účinkom na inkretínový systém, znižujú glykémiu, tlmia chuť do jedla a podporujú redukciu hmotnosti. Ich účinok na tráviaci trakt však môže byť významný aj z pohľadu anestéziológie. Spomaľujú vyprázdňovanie žalúdka, čím môžu u niektorých pacientov zvyšovať objem reziduálneho žalúdočného obsahu pred anestéziou.</p>

        <h3>Prečo je to dôležité pred operáciou?</h3>
        <p>Pri celkovej anestézii je jednou z obáv aspirácia žalúdočného obsahu do dýchacích ciest. Ide síce o zriedkavú komplikáciu, no potenciálne závažnú. Práve preto sa pred operačnými výkonmi dodržiavajú pravidlá predoperačného hladovania.</p>
        <p>Novšie údaje ukazujú, že pacienti liečení GLP-1 agonistami môžu mať vyšší reziduálny objem žalúdka. Tento efekt sa pozoruje pri krátkodobo aj dlhodobo pôsobiacich prípravkoch, pričom výraznejší môže byť pri dlhodobo pôsobiacich liekoch podávaných raz týždenne. Zaujímavé je, že spomalené vyprázdňovanie žalúdka môže pretrvávať aj viac ako 7 dní po prerušení liečby.</p>
        <p>Riziko môže byť vyššie najmä:</p>
        <ul>
          <li>pri vyšších dávkach,</li>
          <li>počas úvodnej titrácie dávky,</li>
          <li>u pacientov s gastrointestinálnymi príznakmi,</li>
          <li>pri diabetickej autonómnej neuropatii,</li>
          <li>pri súbežnom užívaní liekov spomaľujúcich motilitu tráviaceho traktu, napríklad opioidov.</li>
        </ul>

        <h3>Vyšší objem žalúdka neznamená automaticky vyššiu aspiráciu</h3>
        <p>Kľúčový problém spočíva v tom, že vyšší reziduálny objem žalúdka síce bol opakovane popísaný, ale jednoznačný nárast klinicky potvrdených aspirácií sa zatiaľ nepreukázal.</p>
        <p>Aspirácia pri modernej anestézii zostáva zriedkavá, s odhadovanou incidenciou približne 0,05 až 0,20 %. Viaceré metaanalýzy nepreukázali jasné zvýšenie rizika aspirácie u pacientov užívajúcich GLP-1 agonisty, hoci žalúdočný objem môže byť vyšší. Niektoré práce naznačujú možný nárast rizika, ale dôkazy sú zatiaľ limitované a metodicky rôznorodé.</p>

        <h3>Má zmysel liečbu pred operáciou prerušiť?</h3>
        <p>Staršie odporúčania navrhovali vysadiť denné prípravky približne 24 hodín pred výkonom a týždenné prípravky niekoľko dní pred operáciou. Tento prístup sa však v súčasnosti prehodnocuje.</p>
        <p>Dostupné údaje totiž neukazujú jasný vzťah medzi dĺžkou prerušenia liečby a poklesom reziduálneho žalúdočného objemu. Stabilizácia vyprázdňovania žalúdka môže trvať niekoľko týždňov, nie iba niekoľko dní. Navyše neexistuje presvedčivý dôkaz, že krátkodobé vysadenie GLP-1 agonistu pred výkonom reálne znižuje výskyt aspirácie.</p>
        <p>Na druhej strane vysadenie liečby môže mať svoje nevýhody:</p>
        <ul>
          <li>zhoršenie glykemickej kontroly,</li>
          <li>potrebu úpravy antidiabetickej liečby,</li>
          <li>stratu časti kardiovaskulárneho a renálneho benefitu,</li>
          <li>vyššiu organizačnú záťaž pre pacienta aj lekára.</li>
        </ul>
        <p>Pre nefrologickú prax je tento aspekt mimoriadne dôležitý. Mnohí pacienti s diabetom 2. typu, chronickou chorobou obličiek, obezitou a vysokým kardiovaskulárnym rizikom môžu z GLP-1 liečby profitovať. Automatické vysadzovanie bez individuálneho posúdenia preto nemusí byť optimálne.</p>

        <h3>Predlžovať hladovanie? Zatiaľ nie</h3>
        <p>Aktuálne dôkazy nepodporujú rutinné predlžovanie predoperačného hladovania u pacientov užívajúcich GLP-1 agonisty. Dlhšie hladovanie nemusí zlepšiť vyprázdňovanie žalúdka a môže viesť k dehydratácii, nauzee, úzkosti a celkovému diskomfortu.</p>
        <p>Štandardné pravidlá predoperačného hladovania by sa mali dodržiavať, pokiaľ nie je podozrenie na gastroparézu alebo iný klinicky významný problém s vyprázdňovaním žalúdka.</p>

        <h3>Úloha ultrazvuku žalúdka</h3>
        <p>Jedným z praktických riešení môže byť predoperačná ultrasonografia žalúdka. Ide o neinvazívne vyšetrenie, ktoré umožňuje zhodnotiť obsah žalúdka krátko pred výkonom. Ak je nález rizikový alebo nejasný, anestéziológ môže upraviť stratégiu, napríklad zvoliť rýchlu sekvenčnú indukciu, zvýšené aspiračné opatrenia alebo preferovať regionálnu anestéziu, ak je to vhodné.</p>

        <h3>Súčasný trend: individuálne rozhodovanie</h3>
        <p>Novšie odporúčania zdôrazňujú personalizovaný prístup. Francúzske odborné odporúčania z roku 2025, pripravené anestéziologickou a diabetologickou odbornou spoločnosťou, neodporúčajú rutinné vysadenie dlhodobo pôsobiacich GLP-1 agonistov do 7 dní pred operáciou u nízkorizikových pacientov.</p>
        <p>Rozhodovanie by malo zohľadniť:</p>
        <ul>
          <li>typ GLP-1 lieku a dávkovací režim,</li>
          <li>fázu liečby, najmä titráciu dávky,</li>
          <li>prítomnosť nauzey, vracania, pocitu plnosti alebo iných príznakov gastroparézy,</li>
          <li>diabetickú neuropatiu,</li>
          <li>obezitu a pridružené ochorenia,</li>
          <li>súbežnú liečbu ovplyvňujúcu motilitu tráviaceho traktu,</li>
          <li>typ výkonu a plánovaný spôsob anestézie.</li>
        </ul>

        <h3>Praktický záver</h3>
        <p>GLP-1 agonisty pred operáciou nemožno posudzovať jednoduchým pravidlom „vysadiť všetkým" alebo „pokračovať u všetkých". Dôkazy naznačujú zvýšený reziduálny žalúdočný objem, ale zatiaľ nepreukazujú jednoznačné zvýšenie výskytu aspirácie. Krátkodobé prerušenie liečby nemusí spoľahlivo odstrániť riziko, no môže zhoršiť metabolickú stabilitu pacienta.</p>
        <p>Najrozumnejším prístupom je individuálne zhodnotenie rizika v spolupráci anestéziológa, diabetológa, internistu, prípadne nefrológa. U nízkorizikových pacientov môže byť pokračovanie v liečbe primerané. U pacientov s príznakmi gastroparézy, počas titrácie dávky alebo pri ďalších rizikových faktoroch je vhodné zvážiť špecifické anestéziologické opatrenia, prípadne ultrazvukové posúdenie žalúdka.</p>
        <p>
          <em>Zdroj: Spracované podľa Medscape, článok „GLP-1 Drugs and Surgery: Stop or Continue?", 2026.</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

      <!-- <article>: Nezávislý obsah, ktorý má zmysel sám o sebe (napr. článok, blogpost) -->
      <article class="primary-article">
        <header>
          <h2>10 najčastejších chýb pri predpisovaní SGLT2 inhibítorov a GLP-1 agonistov</h2>
          <p class="meta">
            Publikované:&nbsp; <time datetime="2026-05-11">11. máj 2026</time>
          </p>
        </header>
        <p><strong>SGLT2 inhibítory a agonisty GLP-1 receptorov zásadne zmenili liečbu diabetu 2. typu, obezity, chronickej choroby obličiek aj srdcového zlyhávania. Ich význam dnes ďaleko presahuje samotné znižovanie glykémie. Pri nesprávnom používaní však môžeme pacienta pripraviť o časť kardiorenálneho benefitu alebo ho vystaviť zbytočnému riziku.</strong></p>
        <p>Moderná liečba diabetu 2. typu sa už nedá hodnotiť iba cez prizmu HbA1c. SGLT2 inhibítory a GLP-1 agonisty priniesli nový terapeutický jazyk: ochranu obličiek, srdca, ciev a metabolického zdravia. Práve v bežnej ambulantnej praxi však vznikajú opakovateľné chyby. Niektoré vedú k predčasnému vysadeniu účinnej liečby, iné k podceneniu nežiaducich účinkov alebo kontraindikácií.</p>
        <p>Nasledujúci prehľad zhŕňa desať prakticky dôležitých omylov, ktorým sa oplatí vyhnúť.</p>

        <h3>1. Pozerať sa iba na HbA1c a ignorovať kardiorenálne indikácie</h3>
        <p>Najväčšou chybou je vnímať SGLT2 inhibítory a GLP-1 agonisty výlučne ako antidiabetiká určené až do neskorších línií liečby. Súčasné odporúčania kladú dôraz na orgánovú ochranu.</p>
        <p>SGLT2 inhibítory majú významné miesto pri chronickej chorobe obličiek a srdcovom zlyhávaní, často nezávisle od hodnoty HbA1c a dokonca aj nezávisle od prítomnosti diabetu. GLP-1 agonisty, napríklad semaglutid, znižujú riziko veľkých kardiovaskulárnych príhod a prinášajú priaznivé účinky aj na renálne a kardiálne parametre.</p>
        <p>V praxi to znamená, že pri pacientovi s diabetom 2. typu, chronickou chorobou obličiek, albuminúriou, obezitou alebo srdcovým zlyhávaním sa nemáme pýtať iba: „Aký má HbA1c?" Rovnako dôležitá otázka znie: „Aké orgány potrebujeme chrániť?"</p>

        <h3>2. Nesprávne interpretovať počiatočný pokles eGFR po nasadení SGLT2 inhibítora</h3>
        <p>Po začatí liečby SGLT2 inhibítorom sa často objaví mierny prechodný pokles eGFR, typicky približne o 10 až 15 % oproti východiskovej hodnote. Nejde o prejav nefrotoxicity. Ide o očakávaný hemodynamický efekt v glomerule, ktorý súvisí s dlhodobou renálnou ochranou.</p>
        <p>Chybou je automaticky vysadiť liek pri každom poklese eGFR. Pokles do 30 % počas prvých troch mesiacov liečby sa všeobecne považuje za akceptovateľný. Ak je však pokles väčší ako 30 %, alebo sa renálna funkcia ďalej zhoršuje, treba hľadať iné príčiny: hypovolémiu, hypotenziu, nadmernú diuretickú liečbu, užívanie nesteroidových antiflogistík alebo inú interkurentnú patológiu.</p>
        <p>Pre nefrologickú prax je toto mimoriadne dôležité. Predčasné vysadenie SGLT2 inhibítora pre „kozmetický" pokles eGFR môže pacienta pripraviť o dlhodobú nefroprotekciu.</p>

        <h3>3. Zle manažovať genitálne a močové nežiaduce účinky SGLT2 inhibítorov</h3>
        <p>Najčastejším nežiaducim účinkom SGLT2 inhibítorov sú genitálne mykotické infekcie, najmä kandidózy. Môžu sa vyskytnúť až u približne 10 % pacientov, častejšie pri obezite alebo pri anamnéze mykotických infekcií.</p>
        <p>Chybou je považovať každú mykotickú infekciu za dôvod na definitívne vysadenie liečby. Pacienta treba už pri začatí liečby poučiť o riziku, hygiene a potrebe včasnej liečby príznakov. Pri prvých prejavoch je vhodná lokálna antimykotická liečba, pri potrebe aj systémová liečba, často bez nutnosti prerušiť SGLT2 inhibítor.</p>
        <p>Riziko infekcií močových ciest sa javí ako malé a týka sa najmä žien. Rutinná antibiotická profylaxia sa neodporúča.</p>

        <h3>4. Podceniť euglykemickú ketoacidózu pri SGLT2 inhibítoroch</h3>
        <p>Euglykemická ketoacidóza je zradná práve tým, že glykémia nemusí byť výrazne zvýšená. Môže sa objaviť aj pri relatívne nízkych hodnotách glukózy. Vyskytuje sa takmer výlučne u pacientov s diabetom, najmä pri nedostatočnej dávke inzulínu alebo pri záťažových situáciách.</p>
        <p>Rizikovými faktormi sú:</p>
        <ul>
          <li>dlhšie hladovanie,</li>
          <li>ketogénna alebo veľmi nízkosacharidová diéta,</li>
          <li>nadmerný príjem alkoholu,</li>
          <li>infekcia,</li>
          <li>operačný výkon,</li>
          <li>dehydratácia,</li>
          <li>nedostatočná inzulinizácia.</li>
        </ul>
        <p>Pacient musí poznať takzvané „sick day rules". Pri akútnom ochorení, vracaní, dehydratácii alebo výraznom obmedzení príjmu potravy má dočasne prerušiť SGLT2 inhibítor, zabezpečiť príjem tekutín a sacharidov a pri riziku monitorovať ketolátky.</p>
        <p>Treba tiež pripomenúť, že SGLT2 inhibítory nie sú štandardne indikované pri diabete 1. typu.</p>

        <h3>5. Nedostatočne riešiť perioperačné vysadenie SGLT2 inhibítorov</h3>
        <p>Perioperačné obdobie je typickou situáciou, v ktorej môže vzniknúť euglykemická ketoacidóza. Preto sa SGLT2 inhibítory pred plánovaným operačným výkonom dočasne vysadzujú.</p>
        <p>Praktické pravidlo je jednoduché: liečba sa má prerušiť 3 dni pred výkonom. Do tohto obdobia sa zahŕňa deň pred operáciou, deň operácie a deň po operácii. Liečbu možno obnoviť až vtedy, keď pacient normálne prijíma potravu a už nie je riziko dehydratácie.</p>
        <p>Pri urgentných výkonoch je potrebná vyššia pozornosť k hydratácii, acidobázickej rovnováhe a ketolátkam.</p>

        <h3>6. Rutinne vysadzovať GLP-1 agonisty pred operáciou</h3>
        <p>Na rozdiel od SGLT2 inhibítorov nie je pri GLP-1 agonistoch potrebné rutinné vysadenie pred operáciou alebo endoskopiou. Hlavnou obavou je spomalené vyprázdňovanie žalúdka, ktoré môže zvýšiť riziko reziduálneho žalúdočného obsahu.</p>
        <p>Väčšina pacientov však môže v liečbe pokračovať. Dočasné prerušenie má zmysel zvažovať individuálne, najmä pri:</p>
        <ul>
          <li>známej gastroparéze,</li>
          <li>výraznej nauzee alebo vracaní,</li>
          <li>aktívnych gastrointestinálnych príznakoch,</li>
          <li>nedávnej eskalácii dávky.</li>
        </ul>
        <p>Ak existuje neistota, praktickým kompromisom môže byť číra tekutá diéta počas 24 hodín pred výkonom. Rozhodnutie by malo vzniknúť v spolupráci s anestéziológom a lekárom, ktorý liečbu indikuje.</p>

        <h3>7. Ignorovať retinopatiu pri rýchlom poklese HbA1c po semaglutide</h3>
        <p>Pri semaglutide bol v niektorých štúdiách pozorovaný mierny nárast komplikácií diabetickej retinopatie u pacientov s veľmi vysokým rizikom. Pravdepodobne nejde o priamu toxickú retinálnu reakciu, ale skôr o efekt rýchleho zlepšenia glykémie, podobne ako pri intenzifikácii inzulínovej liečby.</p>
        <p>Rizikoví sú najmä pacienti s výrazne zle kontrolovaným diabetom a preproliferatívnou alebo proliferatívnou retinopatiou. Pred začatím liečby je vhodný skríning retinopatie, opatrná titrácia dávky a úzka oftalmologická kontrola.</p>

        <h3>8. Kombinovať GLP-1 agonistu s DPP-4 inhibítorom</h3>
        <p>Kombinácia GLP-1 agonistu a DPP-4 inhibítora neprináša významný dodatočný klinický benefit. Obe skupiny pôsobia cez inkretínový systém, ale GLP-1 agonisty majú výraznejší účinok.</p>
        <p>Ak je indikovaný GLP-1 agonista, DPP-4 inhibítor sa má zvyčajne vysadiť. Ich kombinovanie zvyšuje náklady bez adekvátneho prínosu a veľké odporúčania ho všeobecne neodporúčajú.</p>

        <h3>9. Neupraviť ostatnú antidiabetickú liečbu pri nasadení GLP-1 agonistu</h3>
        <p>GLP-1 agonisty majú samy osebe nízke riziko hypoglykémie, pretože ich účinok je glukózovo závislý. Riziko sa však zvyšuje pri kombinácii s inzulínom, sulfonylureou alebo glinidmi.</p>
        <p>Častou chybou je pridať GLP-1 agonistu bez úpravy existujúcej liečby. Rozumným prístupom môže byť zníženie dávky sulfonylurey alebo bazálneho inzulínu približne o 50 % pri začatí liečby, s následnou úpravou podľa domácich glykémií. Samozrejme, treba zohľadniť východiskovú kompenzáciu diabetu, renálnu funkciu, vek pacienta a riziko hypoglykémie.</p>

        <h3>10. Prehliadnuť kontraindikácie a dôležité upozornenia pri GLP-1 agonistoch</h3>
        <p>GLP-1 agonisty sú účinné lieky, ale nie sú vhodné pre každého pacienta. Semaglutid sa neodporúča počas gravidity. Ženy vo fertilnom veku majú počas liečby používať účinnú antikoncepciu a pri plánovaní gravidity sa má semaglutid vysadiť aspoň 2 mesiace pred počatím.</p>
        <p>Absolútnou kontraindikáciou je osobná alebo rodinná anamnéza medulárneho karcinómu štítnej žľazy alebo syndrómu mnohopočetnej endokrinnej neoplázie typu 2.</p>
        <p>Pri predpisovaní je preto potrebné cielene sa pýtať na relevantnú osobnú a rodinnú anamnézu, nie iba mechanicky pridať liek do chronickej medikácie.</p>

        <h3>Praktický záver pre ambulanciu</h3>
        <p>SGLT2 inhibítory a GLP-1 agonisty patria medzi najvýznamnejšie liekové skupiny modernej metabolickej, kardiologickej a nefrologickej medicíny. Ich správne používanie vyžaduje zmenu myslenia: od samotnej glykémie k orgánovej ochrane.</p>
        <p>Pri SGLT2 inhibítoroch treba rátať s očakávaným úvodným poklesom eGFR, správne manažovať genitálne mykózy, myslieť na euglykemickú ketoacidózu a liek dočasne vysadiť pred operáciou alebo pri akútnom ochorení s rizikom dehydratácie.</p>
        <p>Pri GLP-1 agonistoch je dôležité nevysadzovať ich automaticky pred výkonom, nekombinovať ich s DPP-4 inhibítormi, upraviť rizikovú antidiabetickú liečbu a nezabudnúť na retinopatiu, graviditu a kontraindikácie.</p>
        <p>Dobre indikovaná a dobre vedená liečba týmito liekmi môže pacientom s diabetom 2. typu, chronickou chorobou obličiek, obezitou alebo srdcovým zlyhávaním priniesť výrazný kardiorenálny benefit. Rovnako však platí, že najväčší úžitok vzniká až vtedy, keď liek nepredpisujeme iba „podľa schémy", ale podľa konkrétneho pacienta.</p>
        <p>
          <em>Zdroj: Spracované podľa Medscape: „Avoid These 10 Mistakes When Prescribing SGLT2 Inhibitor and GLP-1 RA", 2026.</em>
        </p>
        <footer>
          <p class="author">
            Autor: <span class="authorname">Dr. Ľubomír Polaščín</span>
          </p>
        </footer>
      </article>

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
          <li><a href="https://kdigo.org/guidelines/" target="_blank" rel="noopener noreferrer">KDIGO Guidelines</a></li>
          <li><a href="https://www.era-online.org/guidelines/" target="_blank" rel="noopener noreferrer">ERA Guidelines</a></li>
          <li><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology (ISN)</a></li>
          <li><a href="https://www.kidney.org/professionals/guidelines" target="_blank" rel="noopener noreferrer">National Kidney Foundation (KDOQI)</a></li>
          <li><a href="https://www.niddk.nih.gov/health-information/kidney-disease" target="_blank" rel="noopener noreferrer">NIDDK: Kidney Disease Resources</a></li>
          <li><a href="https://www.escardio.org/Guidelines" target="_blank" rel="noopener noreferrer">ESC Guidelines</a></li>
          <li><a href="https://pubmed.ncbi.nlm.nih.gov/?term=nephrology" target="_blank" rel="noopener noreferrer">PubMed: Nephrology</a></li>
          <li><a href="https://clinicaltrials.gov/search?cond=Kidney%20Diseases" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov: Kidney Diseases</a></li>
        </ul>
      </div>
    </aside>
  </main>

  <?php include 'footer.php'; ?>