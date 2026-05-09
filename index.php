<?php
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

$csp = "default-src 'self'; "
  . "img-src 'self' data: https:; "
  . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
  . "font-src 'self' https://fonts.gstatic.com; "
  . "script-src 'self' https://www.googletagmanager.com https://www.google-analytics.com; "
  . "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net; "
  . "base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; upgrade-insecure-requests; block-all-mixed-content";
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
  <script src="privacy-manager.v2.js?v=20260509-2&cb=<?= filemtime('privacy-manager.v2.js') ?>" defer></script>
  <script src="cookie-settings-fallback.v2.js?v=20260509-2&cb=<?= filemtime('cookie-settings-fallback.v2.js') ?>" defer></script>
</head>

<body>
  <!-- Skip to content (A11y) -->
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <!-- <header>: Hlavička stránky alebo sekcie, zvyčajne obsahuje logo a hlavný nadpis -->
  <header class="site-header" id="domov" role="banner">
    <div class="container">
      <h1>Nefro-projekt Slovensko</h1>
      <img src="./img/nps-logo.gif" alt="Nefro-projekt Slovensko Logo" class="header-logo">
      <p class="intro">
        Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.
      </p>
    </div>
  </header>

  <!-- <nav>: Hlavná navigácia stránky (menu) -->
  <nav class="main-nav" aria-label="Hlavná navigácia">
    <div class="container">
      <ul>
        <li><a href="#domov" class="active" aria-current="page">Domov</a></li>
        <li><a href="#sluzby">Služby</a></li>
        <li><a href="#o-nas">O nás</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
      </ul>
      <div class="theme-toggle-container">
        <button id="themeToggleBtn" class="theme-toggle" type="button" aria-label="Prepnúť režim osvetlenia" title="Prepnúť režim osvetlenia" aria-pressed="false">
        </button>
      </div>
    </div>
  </nav>

  <!-- <main>: Hlavný obsah stránky, ktorý je pre daný dokument unikátny -->
  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">

      <!-- <article>: Nezávislý obsah, ktorý má zmysel sám o sebe (napr. článok, blogpost) -->
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
        <!-- <section>: Tematické rozdelenie obsahu, zvyčajne s vlastným nadpisom 
                <section class="content-section">
                    <h3>Podsekcia článku</h3>
                    <p>Pomocou elementu <code>&lt;section&gt;</code> rozdeľujeme obsah do logických celkov. Táto časť sa
                        venuje detailnejšiemu popisu problematiky a je súčasťou väčšieho článku.</p>
                </section>-->
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
            <h3>Kedy očakávame ďalší príspevok?</h3>
            <p>
              Pravidelne pripravujeme nové klinické dáta a analýzy.
            </p>
            <div class="badge-highlight">Predpoklad: Začiatok júna 2026</div>
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

          echo '<a href="' . htmlspecialchars($randomImagePath) . '" id="randomImageLink" target="_blank" rel="noopener noreferrer" title="Zobraziť obrázok v plnej veľkosti">';
          echo '<img id="randomImage" src="' . htmlspecialchars($randomImagePath) . '" alt="Náhodný obrázok">';
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

  <!-- <footer>: Pätička stránky alebo sekcie, obsahuje autorské práva, dôležité odkazy atď. -->
  <footer class="site-footer" role="contentinfo">
    <div class="container">
      <p>
        &copy; 2026 Ľubomír Polaščín. Vytvorené s využitím moderných štandardov a s dôrazom na prístupnosť.
      </p>
      <p class="site-footer__updated">
        Posledná aktualizácia stránky: <?= htmlspecialchars($pageLastUpdated, ENT_QUOTES, 'UTF-8') ?> (časové pásmo: <?= htmlspecialchars($pageTimeZone, ENT_QUOTES, 'UTF-8') ?>)
      </p>
      <p class="site-footer__links">
        <a href="privacy.php" class="site-footer__link">Ochrana osobných údajov (Privacy Policy)</a> | <a href="#cookie-settings" class="cookie-settings-trigger site-footer__link" aria-haspopup="dialog" aria-controls="cookieConsentModal">Nastavenia Cookies</a>
      </p>
    </div>
  </footer>
</body>

</html>