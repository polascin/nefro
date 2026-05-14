<?php
/**
 * add_eco2026_articles.php
 * Pridanie troch nových článkov o ECO 2026 a liečbe obezity
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

// ── Dáta článkov ──────────────────────────────────────────────────────────────

$articles = [];

// ── Článok 1: ECO 2026 – Európsky kongres o obezite ──────────────────────────
$articles[] = [
    'title'        => 'ECO 2026: Európsky kongres o obezite sa uskutoční v Istanbule',
    'slug'         => 'eco-2026-europsky-kongres-obezite-istanbul',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-12',
    'is_top'       => 0,
    'excerpt'      => 'V dňoch 12. až 15. mája 2026 sa v Istanbule uskutoční 33. ročník Európskeho kongresu o obezite, ECO 2026. Ide o jedno z najvýznamnejších európskych odborných podujatí venovaných obezite, jej prevencii, diagnostike a liečbe.',
    'content'      => <<<'HTML'
<h2>ECO 2026: Európsky kongres o obezite sa uskutoční v Istanbule</h2>

<p><strong>Dátum konania:</strong> 12. až 15. máj 2026<br>
<strong>Miesto konania:</strong> Istanbul, Turecko<br>
<strong>Podujatie:</strong> 33. European Congress on Obesity, ECO 2026<br>
<strong>Organizátor:</strong> European Association for the Study of Obesity, EASO</p>

<h3>Krátka správa</h3>

<p>V dňoch <strong>12. až 15. mája 2026</strong> sa v Istanbule uskutoční <strong>33. ročník Európskeho kongresu o obezite, ECO 2026</strong>. Ide o jedno z najvýznamnejších európskych odborných podujatí venovaných obezite, jej prevencii, diagnostike, liečbe a širším metabolickým, kardiovaskulárnym aj renálnym súvislostiam.</p>

<p>Kongres je určený lekárom, výskumníkom, odborníkom v oblasti verejného zdravia, dietológom, psychológom, farmaceutom a ďalším profesionálom, ktorí sa venujú problematike obezity a jej komplikácií.</p>

<h3>Prečo je ECO 2026 dôležitý aj pre nefrológiu</h3>

<p>Obezita patrí medzi významné rizikové faktory chronickej choroby obličiek. Podieľa sa na vzniku a progresii hypertenzie, diabetu 2. typu, albuminúrie, glomerulárnej hyperfiltrácie a obezitou asociovanej glomerulopatie. U pacientov s pokročilým ochorením obličiek zároveň ovplyvňuje transplantačnú prípravu, dialyzačnú liečbu, nutričný stav a celkové kardiovaskulárne riziko.</p>

<p>Z pohľadu nefrológa je preto sledovanie noviniek v liečbe obezity mimoriadne dôležité. Moderná obezitológia dnes už nie je len otázkou redukcie hmotnosti, ale aj komplexného ovplyvnenia metabolického, cievneho a renálneho rizika.</p>

<h3>Hlavné témy očakávané na kongrese</h3>

<p>Medzi dôležité oblasti, ktoré budú pravdepodobne súčasťou odborného programu, patria:</p>

<ul>
<li>epidemiológia a prevencia obezity,</li>
<li>farmakologická liečba obezity,</li>
<li>metabolické a kardiovaskulárne komplikácie,</li>
<li>vzťah obezity k diabetu 2. typu,</li>
<li>obezita a chronická choroba obličiek,</li>
<li>bariatrická a metabolická chirurgia,</li>
<li>výživa, pohybová aktivita a behaviorálne intervencie,</li>
<li>nové liečivá a výsledky klinických štúdií,</li>
<li>verejno-zdravotné stratégie a multidisciplinárna starostlivosť.</li>
</ul>

<h3>Obezita, obličky a každodenná klinická prax</h3>

<p>V nefrologickej ambulancii sa s dôsledkami obezity stretávame veľmi často. Pacienti s obezitou mávajú vyššie riziko hypertenzie, inzulínovej rezistencie, diabetickej choroby obličiek a kardiovaskulárnych komplikácií. U dialyzovaných pacientov je hodnotenie telesného zloženia zložitejšie, pretože samotný index telesnej hmotnosti nemusí spoľahlivo odrážať nutričný stav, sarkopéniu ani zápalovú záťaž.</p>

<p>Práve preto sú odborné kongresy ako ECO 2026 dôležitým miestom, kde sa prepája výskum, klinická prax a multidisciplinárny prístup k pacientovi. Vývoj nových liekov na liečbu obezity, najmä inkretínovo orientovaných terapií, prináša otázky aj pre nefrológiu: bezpečnosť pri zníženej glomerulovej filtrácii, vplyv na albuminúriu, krvný tlak, kardiovaskulárne výsledky a kvalitu života pacientov.</p>

<h3>Záver</h3>

<p>ECO 2026 v Istanbule bude významnou odbornou udalosťou pre všetkých, ktorí sa venujú obezite a jej komplikáciám. Pre nefrológiu má táto téma osobitný význam, pretože obezita je úzko prepojená s chronickou chorobou obličiek, diabetom, hypertenziou a kardiovaskulárnou morbiditou.</p>

<p>Sledovanie výstupov z kongresu môže priniesť cenné poznatky pre každodennú starostlivosť o pacientov s ochorením obličiek, najmä v oblasti prevencie, metabolickej liečby a komplexného manažmentu rizikových faktorov.</p>

<hr>

<p><em><strong>Zdroj:</strong> European Congress on Obesity, ECO 2026, oficiálna stránka kongresu; European Association for the Study of Obesity, EASO; LinkedIn príspevok Dr. Suzan Gharaibeh o ECO 2026.</em></p>
HTML,
];

// ── Článok 2: 5 hlavných noviniek v liečbe obezity z ECO 2026 ──────────────────
$articles[] = [
    'title'        => '5 hlavných noviniek v liečbe obezity z ECO 2026',
    'slug'         => '5-noviniek-liebe-obezity-eco-2026',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-12',
    'is_top'       => 1,
    'excerpt'      => 'ECO 2026 priniesol viaceré dôležité poznatky z oblasti modernej farmakologickej liečby obezity. Najvýraznejšie dáta pochádzajú zo štúdií SURMOUNT-MAINTAIN, ATTAIN-MAINTAIN a ďalších zameraných na dlhodobú liečbu a nové perorálne liečivá.',
    'content'      => <<<'HTML'
<h2>5 hlavných noviniek v liečbe obezity z ECO 2026</h2>

<p><strong>Kľúčové zistenia prezentované 12. mája 2026</strong></p>

<p>ECO 2026, teda 33. Európsky kongres o obezite, sa koná v Istanbule od 12. do 15. mája 2026. Prezentovaný text sumarizuje päť významných noviniek v modernej farmakologickej liečbe obezity.</p>

<hr>

<h3>1. SURMOUNT-MAINTAIN</h3>

<p>Dospelí pacienti najprv chudli počas <strong>60 týždňov</strong> pri liečbe liekom <strong>Zepbound</strong> (tirzepatid). Následne boli randomizovaní na pokračovanie v plnej dávke, zníženie dávky na 5 mg alebo prechod na placebo počas ďalších <strong>52 týždňov</strong>.</p>

<h4>Zmena telesnej hmotnosti počas 112 týždňov</h4>

<p><strong>Priemerná percentuálna zmena oproti východiskovej hodnote</strong></p>

<h5>Obdobie chudnutia na liečbe Zepboundom, 0 až 60 týždňov</h5>
<ul>
<li><strong>-22,1 %</strong> v 60. týždni<br>Koniec obdobia chudnutia na liečbe Zepboundom.</li>
</ul>

<h5>Udržiavacie obdobie, randomizovaná liečba, 60 až 112 týždňov</h5>
<ul>
<li>Pokračovanie v Zepbounde v maximálnej tolerovanej dávke 10 až 15 mg: <strong>-22,4 %</strong></li>
<li>Zníženie dávky Zepboundu na 5 mg: <strong>-16,6 %</strong></li>
<li>Prechod na placebo, so záchrannou liečbou/imputáciou: <strong>-10,1 %</strong></li>
<li>Odhadované placebo bez záchrannej liečby: <strong>-4,8 %</strong></li>
</ul>

<h5>Priemerná zmena hmotnosti počas udržiavacieho obdobia, 60 až 112 týždňov</h5>
<ul>
<li><strong>Pokračovanie v Zepbounde v dávke 10 až 15 mg:</strong> pacienti si udržali celý predchádzajúci úbytok hmotnosti.</li>
<li><strong>Zníženie dávky Zepboundu na 5 mg:</strong> pacienti opäť pribrali približne <strong>12 libier</strong>, teda asi <strong>5,4 kg</strong>.</li>
<li><strong>Prechod na placebo so záchrannou liečbou/imputáciou:</strong> pacienti opäť pribrali približne <strong>30 libier</strong>, teda asi <strong>13,6 kg</strong>.</li>
<li><strong>Odhadované placebo bez záchrannej liečby:</strong> pacienti opäť pribrali približne <strong>43 libier</strong>, teda asi <strong>19,5 kg</strong>.</li>
</ul>

<p><strong>67 % účastníkov v placebovej skupine potrebovalo záchrannú liečbu.</strong></p>

<hr>

<h3>2. ATTAIN-MAINTAIN</h3>

<p>Účastníci, ktorí predtým schudli pri liečbe liekom <strong>Wegovy, semaglutid</strong>, alebo <strong>Zepbound, tirzepatid</strong>, boli randomizovaní na prechod na perorálny liek <strong>Foundayo, orforglipron</strong>, alebo na placebo počas <strong>52 týždňov</strong>.</p>

<h4>Wegovy → Foundayo</h4>

<h5>Obdobie chudnutia na Wegovy, 0 až 72 týždňov</h5>
<ul>
<li><strong>-17,1 %</strong> v 72. týždni<br>Koniec obdobia chudnutia na liečbe Wegovy.</li>
</ul>

<h5>Udržiavacie obdobie na Foundayo, 72 až 124 týždňov</h5>
<ul>
<li><strong>-15,1 %</strong></li>
</ul>

<h4>Zepbound → Foundayo</h4>

<h5>Obdobie chudnutia na Zepbounde, 0 až 72 týždňov</h5>
<ul>
<li><strong>-22,0 %</strong> v 72. týždni<br>Koniec obdobia chudnutia na liečbe Zepboundom.</li>
</ul>

<h5>Udržiavacie obdobie na Foundayo, 72 až 124 týždňov</h5>
<ul>
<li><strong>-16,8 %</strong></li>
</ul>

<h4>Priemerný opätovný prírastok hmotnosti počas 52 týždňov</h4>

<h5>Wegovy → Foundayo</h5>
<ul>
<li>Opätovný prírastok približne <strong>2 libry</strong>, teda asi <strong>0,9 kg</strong>.</li>
<li>Placebová skupina pribrala významne viac.</li>
</ul>

<h5>Zepbound → Foundayo</h5>
<ul>
<li>Opätovný prírastok približne <strong>11 libier</strong>, teda asi <strong>5,0 kg</strong>.</li>
<li>Placebová skupina pribrala významne viac.</li>
</ul>

<p><strong>Foundayo pomohol udržať väčšinu dosiahnutého úbytku hmotnosti v porovnaní s placebom v oboch skupinách.</strong></p>

<h5>Dizajn štúdie</h5>

<p>Po <strong>72 týždňoch</strong> predchádzajúcej liečby Wegovy alebo Zepboundom boli účastníci randomizovaní na perorálny Foundayo alebo placebo počas <strong>52 týždňov</strong>, spolu do <strong>124. týždňa</strong>.</p>

<hr>

<h3>3. Vysokodávkový Wegovy 7,2 mg (semaglutid) – skorí respondéri</h3>

<p><strong>Štúdia STEP UP:</strong> Dospelí bez diabetu boli liečení semaglutidom v dávke <strong>7,2 mg</strong> v porovnaní s dávkou <strong>2,4 mg</strong> a placebom počas <strong>72 týždňov</strong>.</p>

<h4>Skorí respondéri</h4>
<p><strong>≥15 % úbytok hmotnosti v 72. týždni</strong></p>
<ul>
<li><strong>7,2 mg:</strong> 27,7 %</li>
<li><strong>2,4 mg:</strong> 24,8 %</li>
</ul>

<p>Skorí respondéri na dávke <strong>7,2 mg</strong> schudli do 72. týždňa v priemere <strong>27,7 % telesnej hmotnosti</strong>.</p>

<hr>

<h3>4. Wegovy v tabletovej forme (perorálny semaglutid 25 mg) – skorí respondéri</h3>

<p><strong>Štúdia OASIS 4:</strong> Dospelí bez diabetu boli liečení perorálnym semaglutidom <strong>25 mg</strong> alebo placebom počas <strong>64 týždňov</strong>.</p>

<h4>Skorí respondéri</h4>
<p><strong>≥10 % úbytok hmotnosti v 64. týždni</strong></p>
<ul>
<li><strong>Perorálny semaglutid 25 mg:</strong> 21,6 %</li>
<li><strong>Celková placebová skupina:</strong> 2,7 %</li>
</ul>

<p>Skorí respondéri na tabletovej forme Wegovy schudli v priemere <strong>21,6 % telesnej hmotnosti</strong> do 64. týždňa. Celková placebová skupina schudla v priemere <strong>2,7 %</strong>.</p>

<hr>

<h3>5. Údaje o telesnom zložení (semaglutid 2,4 mg a 7,2 mg)</h3>

<p><strong>Subanalýza štúdie STEP UP s použitím MRI vo vybranej podskupine účastníkov.</strong></p>

<ul>
<li>Približne <strong>84 % úbytku hmotnosti</strong> pochádzalo z <strong>tukovej hmoty</strong>.</li>
<li><strong>Viscerálny tuk</strong> sa znížil o viac ako <strong>30 %</strong>.</li>
<li>Došlo k určitej strate beztukovej hmoty, približne <strong>10 %</strong>, ale <strong>svalová funkcia bola zachovaná</strong>.</li>
<li>Svalová sila hodnotená testom vstávania zo stoličky bola pred liečbou a po liečbe podobná v porovnaní s placebom.</li>
</ul>

<hr>

<h3>Hlavné posolstvo</h3>

<p>Dlhodobá liečba, flexibilita dávkovania a nové perorálne možnosti formujú budúcnosť starostlivosti o pacientov s obezitou. Tieto údaje podporujú význam personalizovaných a udržateľných stratégií, ktoré prinášajú najlepšie výsledky.</p>

<p><strong>Autor obrázka/dát:</strong> Joseph Zucchi, PA-C</p>

<hr>

<p><em><strong>Zdroj:</strong> Prezentácie z ECO 2026, 12. až 15. máj 2026, Istanbul; klinické štúdie SURMOUNT-MAINTAIN, ATTAIN-MAINTAIN, STEP UP a OASIS 4.</em></p>
HTML,
];

// ── Článok 3: Zhrnutie správy ────────────────────────────────────────────────
$articles[] = [
    'title'        => 'ECO 2026 priniesol nové údaje o dlhodobej liečbe obezity',
    'slug'         => 'eco-2026-novinky-dlhodoba-liebe-obezity',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-14',
    'is_top'       => 0,
    'excerpt'      => 'Na Európskom kongrese o obezite ECO 2026 boli prezentované viaceré dôležité poznatky z oblasti modernej farmakologickej liečby obezity. Súhrn prezentovaných údajov poukazuje na význam dlhodobej liečby, udržiavacej terapie a nových perorálnych možností.',
    'content'      => <<<'HTML'
<h2>ECO 2026 priniesol nové údaje o dlhodobej liečbe obezity</h2>

<h3>Správa z kongresu</h3>

<p>Na Európskom kongrese o obezite ECO 2026 (12. až 15. máj 2026, Istanbul) boli prezentované viaceré dôležité poznatky z oblasti modernej farmakologickej liečby obezity. Súhrn piatich hlavných noviniek poukazuje najmä na významnosť dlhodobej liečby, udržiavacej terapie a nových perorálnych možností.</p>

<h3>Najvýznamnejšie zjavenije: SURMOUNT-MAINTAIN</h3>

<p>Najvýraznejšie dáta pochádzajú zo štúdie SURMOUNT-MAINTAIN. Pacienti, ktorí po úvodnom výraznom schudnutí pokračovali v liečbe tirzepatidom, si dokázali udržať takmer celý dosiahnutý úbytok hmotnosti. Naopak, pri prechode na placebo dochádzalo k významným opätovným prírastkom hmotnosti. Tieto výsledky podporujú chápanie obezity ako <strong>chronického ochorenia</strong>, ktoré si často vyžaduje dlhodobú a kontinuálnu liečbu.</p>

<h3>Nové perorálne liečivá</h3>

<p>Dôležité sú aj údaje zo štúdie ATTAIN-MAINTAIN, v ktorej sa hodnotil prechod pacientov z injekčnej liečby semaglutidom alebo tirzepatidom na perorálny orforglipron. Výsledky naznačujú, že perorálna liečba dokáže pomôcť udržať veľkú časť predchádzajúceho úbytku hmotnosti a môže predstavovať praktickú alternatívu pre pacientov preferujúcich tabletovú formu liečby.</p>

<h3>Vysoké dávky a telesné zloženie</h3>

<p>Ďalšie prezentované údaje sa týkali vyššej dávky semaglutidu 7,2 mg, perorálneho semaglutidu 25 mg a vplyvu liečby na telesné zloženie. Podľa analýz väčšina redukovanej hmotnosti pochádzala z tukovej hmoty, pričom <strong>svalová funkcia zostala zachovaná</strong>. Viscerálny tuk sa znížil o viac ako 30 %, čo má osobitný klinický a metabolický význam.</p>

<h3>Implikácie pre klinickú prax</h3>

<p>Pre klinickú prax je hlavným odkazom z ECO 2026 potreba:</p>

<ul>
<li><strong>Individualizovať liečbu obezity</strong> na základe terapeutických cieľov a preferencií pacienta,</li>
<li><strong>Sledovať dlhodobú udržateľnosť</strong> redukcie hmotnosti a výsledky,</li>
<li>Vnímať redukciu hmotnosti nie len ako estetický alebo metabolický cieľ, ale aj ako <strong>významný faktor ovplyvňujúci kardiovaskulárne, diabetologické a renálne riziko</strong>,</li>
<li>Zvážiť nové perorálne možnosti pre pacientov s nedostatočným adherenčou na injekčné liečivá,</li>
<li>Komplexne hodnotiť telesné zloženie a jeho zmeny počas liečby.</li>
</ul>

<h3>Relevancia pre nefrológiu</h3>

<p>Poznatky z ECO 2026 sú osobitne relevantné aj pre nefrológiu. Obezita je úzko prepojená s chronickou chorobou obličiek, diabetom, hypertenziou a kardiovaskulárnou morbiditou. Nové poznatky o dlhodobej účinnosti liečby obezity a jej vplyve na telesné zloženie prináša možnosti pre komplexnú starostlivosť o pacientov s renálnym ochorením, kde je metabolické zdravie a kardiovaskulárny status rozhodujúcimi faktormi prognózy.</p>

<h3>Záver</h3>

<p>ECO 2026 v Istanbule prináša jasný odkaz: obezita je chronické ochorenie, ktoré sa má liečiť kontinuálne, cielene a s personalizovaným prístupom. Budúcnosť liečby obezity spočíva v kombinácii farmakologických, behaviorálnych a nutričných prístupov, s podporou viacerých liekov a foriem podávania. Tieto poznatky sú dôležité pre všetkých klínických špecialista vrátane nefrológov, ktorí majú potrebu komplexného pochopenia a manažmentu obezity a jej metabolických komplikácií.</p>

<hr>

<p><em><strong>Zdroj:</strong> European Congress on Obesity 2026, Official Proceedings; prezentácie z kongresu (12.–15. máj 2026, Istanbul); klinické štúdie SURMOUNT-MAINTAIN, ATTAIN-MAINTAIN, STEP UP a OASIS 4.</em></p>
HTML,
];

// ── Vkladanie do databázy ─────────────────────────────────────────────────────

$inserted = 0;
$skipped  = 0;
$errors   = [];

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        if ($stmt->rowCount() > 0) {
            $inserted++;
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_eco2026_articles error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článkov ECO 2026\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    // ── HTML výstup pre webový prístup ──────────────────────────────────
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia – ECO 2026 články</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – ECO 2026 články</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
          </div>

          <p>Vstavané články o ECO 2026 a liečbe obezity:</p>
          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo nechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
