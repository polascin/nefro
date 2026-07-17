<?php
/**
 * add_extremne-horucavy-riziko-ckd-dialyza_article.php
 * Idempotentný UPSERT odborného článku o renálnych rizikách extrémnych horúčav.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Extrémne horúčavy: rastúce riziko pre pacientov s ochorením obličiek',
    'slug'         => 'extremne-horucavy-riziko-ckd-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Extrémne horúčavy zvyšujú renálne riziko pri CKD aj dialýze, no prevencia neznamená paušálne „viac piť“ ani svojvoľne vysádzať lieky. Rozhoduje individuálny objemový a liekový plán.',
    'content'      => <<<'HTML'
<p>Extrémne horúčavy nie sú iba otázkou komfortu. U zraniteľného pacienta môžu viesť k dehydratácii, hypotenzii, akútnemu poškodeniu obličiek (AKI), poruchám vnútorného prostredia alebo dekompenzácii srdcového zlyhávania. Riziko narastá s vekom, polymorbiditou, chronickou chorobou obličiek (CKD), diabetom, kardiovaskulárnym ochorením a potrebou dialyzačnej liečby.</p>

<p>Komentár Roberty Villovej v portáli Medscape upozorňuje na rastúci zdravotný dosah horúčav v Európe. Pre nefrologickú prax je jeho najdôležitejším odkazom potreba pripraviť rizikových pacientov ešte pred vlnou horúčav. <strong>Prevencia však nesmie byť redukovaná na univerzálne „pite viac“ ani na paušálne vysadzovanie liekov.</strong> Rozhodujú objemový stav, diuréza, reziduálna funkcia obličiek, srdcové zlyhávanie, dialyzačný režim a vopred dohodnutý postup pri akútnom ochorení.</p>

<h2>Európske údaje ukazujú rastúcu expozíciu aj mortalitu</h2>

<p>Správa <em>Lancet Countdown in Europe 2026</em> odhadla v Európe za rok 2024 celkovo 62 775 úmrtí pripísateľných teplu. Pri porovnaní období 1991–2000 a 2015–2024 sa mortalita pripísateľná teplu zvýšila v 820 z 823 sledovaných regiónov; priemerný nárast predstavoval 52 úmrtí na milión obyvateľov ročne (95 % CI 43–59).</p>

<p>V roku 2024 dosiahla expozícia dojčiat a ľudí vo veku ≥65 rokov vlnám horúčav 2,3 miliardy osobodní. Priemerná ročná expozícia týchto skupín bola v rokoch 2015–2024 o 254 % vyššia než v období 1991–2000. Nárast však nevysvetľuje iba častejší výskyt vĺn horúčav: podieľa sa na ňom aj rast počtu ľudí v zraniteľných vekových skupinách.</p>

<p>Tieto čísla sú výsledkom epidemiologického modelovania, nie súčtom úmrtí označených na úmrtnom liste ako „následok horúčavy“. Model odhaduje časť mortality pripísateľnú teplote na populačnej úrovni. Výsledok preto závisí od definície expozície, referenčnej teploty, zahrnutých regiónov a použitej metodiky. Neumožňuje určiť príčinu úmrtia konkrétneho človeka, presvedčivo však ukazuje rozsah a trend zdravotného rizika.</p>

<h2>Prečo sú obličky počas horúčav zraniteľné</h2>

<p>Termoregulácia presúva časť krvného prietoku do kože a potenie zvyšuje straty vody aj elektrolytov. Ak príjem nestačí alebo sa pridá hnačka, vracanie či febrilita, môže klesnúť efektívny cirkulujúci objem. Aktivácia sympatika a renínovo-angiotenzínovo-aldosterónového systému (RAAS) pomáha krátkodobo udržať tlak, no renálna perfúzia a glomerulová filtrácia môžu klesnúť.</p>

<p>Pri ťažkej hypertermii sa pridáva priame bunkové poškodenie, systémová zápalová odpoveď, porucha koagulácie a niekedy rabdomyolýza. Dôsledkom môže byť kombinácia prerenálnej hypoperfúzie a intrarenálneho poškodenia. Nedostatočná náhrada vody môže podporiť hypernatriémiu; neuvážený príjem veľkého množstva hypotonickej tekutiny zasa môže prispieť k hyponatriémii.</p>

<p>CKD znižuje schopnosť kompenzovať náhle hemodynamické a elektrolytové zmeny. V post hoc analýze štúdie DAPA-CKD u 4 017 účastníkov bolo viac dní s tepelným indexom &gt;30 °C spojených s rýchlejším poklesom eGFR. Išlo o observačnú analýzu expozície v rámci randomizovanej štúdie, preto sama nedokazuje kauzalitu a jej odhad nemožno mechanicky preniesť na každého pacienta. Podporuje však klinický predpoklad, že opakovaná tepelná záťaž môže mať pri už prítomnej CKD aj dlhodobejší význam.</p>

<h2>Najväčšia praktická chyba: jedna rada pre všetkých</h2>

<p>Pacient s CKD môže byť počas horúčav ohrozený dvoma protichodnými stavmi: hypovolémiou s renálnou hypoperfúziou a objemovým preťažením po neprimeranom zvýšení príjmu. Medzi týmito pólmi nemožno rozhodovať iba podľa teploty vzduchu.</p>

<div class="table-responsive" role="region" aria-label="Individualizácia príjmu tekutín počas horúčav" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klinická situácia</th>
      <th scope="col">Hlavné riziko</th>
      <th scope="col">Praktický princíp</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>CKD so zachovanou diurézou bez kongescie</td>
      <td>Nedostatočná náhrada strát, hypotenzia a AKI</td>
      <td>Vopred určiť primeraný príjem podľa strát, tlaku a klinického stavu; pri rizikovom pacientovi sa nespoliehať iba na pocit smädu</td>
    </tr>
    <tr>
      <td>Pokročilá CKD alebo srdcové zlyhávanie</td>
      <td>Hypovolémia aj pľúcna alebo periférna kongescia</td>
      <td>Svojvoľne nemeniť predpísaný tekutinový ani diuretický režim; sledovať hmotnosť, tlak, dyspnoe, opuchy a diurézu</td>
    </tr>
    <tr>
      <td>Anúria alebo hemodialýza</td>
      <td>Objemové preťaženie a vysoká ultrafiltračná záťaž</td>
      <td>Preventívne neliberalizovať príjem bez dohody so strediskom; hodnotiť medzidialyzačnú hmotnosť spolu s príznakmi hypovolémie a kongescie</td>
    </tr>
    <tr>
      <td>Peritoneálna dialýza</td>
      <td>Dehydratácia pri zvýšenej ultrafiltrácii alebo preťaženie pri nedostatočnej ultrafiltrácii</td>
      <td>Sledovať hmotnosť, tlak, opuchy, diurézu a ultrafiltračnú bilanciu; zmenu predpisu riešiť s dialyzačným pracoviskom</td>
    </tr>
  </tbody>
</table>
</div>

<p>U starších ľudí môže byť pocit smädu oslabený a kognitívna porucha sťažuje dodržiavanie plánu. Naopak, anurický pacient nemá možnosť nadbytočnú vodu vylúčiť. Bezpečný pokyn preto musí obsahovať nielen orientačný denný režim, ale aj hranice, pri ktorých má pacient kontaktovať ambulanciu alebo dialyzačné stredisko.</p>

<h2>Dialýza: riziko je reálne, mechanizmus nie je jednoduchý</h2>

<p>V americkej kohorte 945 251 ľudí liečených udržiavacou dialýzou bola expozícia extrémnemu vlhkému teplu spojená s 18 % vyšším relatívnym rizikom úmrtia (adjustovaný HR 1,18; 95 % CI 1,15–1,20). Vo francúzskom registri REIN bola maximálna denná teplota &gt;32,5 °C spojená s vyššou mortalitou dialyzovaných pacientov (IR 1,09; 95 % CI 1,04–1,15); rovnaká asociácia sa v tejto analýze nepotvrdila u príjemcov transplantátu. Ide o observačné asociácie, ktoré môžu ovplyvňovať komorbidity, socioekonomické podmienky, kvalita bývania, znečistenie ovzdušia aj dostupnosť dopravy a zdravotnej starostlivosti.</p>

<p>Z týchto údajov nemožno vyvodiť, že vyššia vonkajšia teplota automaticky zvyšuje medzidialyzačný prírastok hmotnosti alebo výskyt intradialyzačnej hypotenzie. Vzťah medzi ročným obdobím, príjmom, potením, ultrafiltráciou a tlakom je komplexný; niektoré observačné štúdie dokonca zaznamenali viac hypotenzných epizód pri nižšej okolitej teplote. Klinický postup sa preto má opierať o konkrétne údaje pacienta, nie o jednoduchú sezónnu domnienku.</p>

<p>Počas horúčav má dialyzačné pracovisko venovať pozornosť trendu predialyzačnej hmotnosti a tlaku, príznakom hypovolémie aj kongescie, reziduálnej diuréze, tolerancii ultrafiltrácie a načasovaniu antihypertenzív. Súčasťou bezpečnosti je aj chladené prostredie, spoľahlivá doprava na dialýzu, telefonický kontakt a plán kontinuity prevádzky pri výpadku elektriny alebo extrémnom počasí.</p>

<h2>Lieky: horúčava sama nie je „sick day“</h2>

<p>Diuretiká, inhibítory ACE, sartany, inhibítory SGLT2, metformín a nesteroidové antiflogistiká môžu pri dehydratácii alebo AKI zvyšovať riziko komplikácií odlišnými mechanizmami. To však neznamená, že ich má pacient pri každom teplom dni preventívne vysadiť. Paušálne alebo dlhodobé prerušenie nefroprotektívnej liečby môže zvýšiť kardiovaskulárne a renálne riziko.</p>

<p>KDIGO 2024 pripúšťa dočasné prerušenie vybraných liekov pri <strong>akútnom dehydratujúcom ochorení</strong>, napríklad pri vracaní, hnačke, febrilite, výrazne zníženom príjme alebo symptomatickej hypotenzii. Zároveň upozorňuje, že dôkazy o prínose všeobecných „sick day rules“ sú obmedzené a najčastejšou chybou je zabudnuté opätovné nasadenie liečby.</p>

<ul>
  <li><strong>Inhibítory RAAS a diuretiká:</strong> postup závisí od tlaku a objemového stavu; pri kongescii môže byť svojvoľné vysadenie diuretika škodlivé.</li>
  <li><strong>Inhibítory SGLT2:</strong> pri akútnom ochorení, hladovaní alebo riziku dehydratácie sa uplatňuje vopred dohodnuté dočasné prerušenie pre riziko ketoacidózy a objemovej deplécie.</li>
  <li><strong>Metformín:</strong> pri AKI alebo významnej dehydratácii rastie riziko akumulácie a laktátovej acidózy.</li>
  <li><strong>NSAID:</strong> pri CKD a objemovej deplécii môžu zhoršiť renálnu perfúziu; pacient má poznať bezpečnejšiu analgetickú alternatívu podľa svojho klinického stavu.</li>
</ul>

<p>Každé dočasné prerušenie má mať zdokumentované podmienky opätovného nasadenia a kontakt pre nejasné situácie. Po závažnejšej epizóde je vhodná kontrola liekov, tlaku, objemového stavu a podľa rizika aj kreatinínu a elektrolytov. Samotné ustúpenie horúčav ešte nepotvrdzuje, že funkcia obličiek a vnútorné prostredie sú stabilné.</p>

<h2>Praktický plán pre nefrologickú ambulanciu</h2>

<ol>
  <li><strong>Identifikovať vysoké riziko:</strong> vyšší vek, CKD G4–G5, predchádzajúce AKI, srdcové zlyhávanie, diabetes, syndróm krehkosti, kognitívna porucha, dialýza, polyfarmácia, osamelosť a bývanie bez možnosti účinného chladenia.</li>
  <li><strong>Určiť osobný tekutinový režim:</strong> zapísať zrozumiteľný plán podľa diurézy, objemového stavu, krvného tlaku a dialyzačnej liečby; vyhnúť sa všeobecnému pokynu „piť čo najviac“.</li>
  <li><strong>Urobiť liekovú revíziu:</strong> vysvetliť, ktoré lieky sa užívajú ďalej, ktoré môže pacient dočasne prerušiť iba pri presne definovanom akútnom stave a kedy ich znovu nasadiť.</li>
  <li><strong>Dohodnúť monitorovanie:</strong> hmotnosť, tlak, diuréza a symptómy; laboratórnu kontrolu cieliť podľa klinického rizika, zmien liečby a prekonanej dehydratácie.</li>
  <li><strong>Overiť sociálnu uskutočniteľnosť:</strong> dostupnosť chladeného priestoru, tekutín, pomoci blízkej osoby, dopravy na dialýzu a funkčného telefonického kontaktu.</li>
  <li><strong>Stanoviť eskalačný plán:</strong> pacient aj opatrovateľ majú vedieť, koho kontaktovať a pri ktorých príznakoch nečakať na plánovanú kontrolu.</li>
</ol>

<h2>Varovné príznaky, ktoré vyžadujú rýchle zhodnotenie</h2>

<p>Urgentné klinické posúdenie si vyžadujú zmätenosť, synkopa, výrazná slabosť, bolesť na hrudníku, nová dýchavica, pretrvávajúce vracanie, veľmi nízky tlak, výrazný pokles diurézy, rýchla zmena hmotnosti alebo príznaky tepelného úpalu. U dialyzovaného pacienta sú dôležité aj vynechanie liečby, nemožnosť dostať sa do strediska, progresívne opuchy a intolerancia obvyklej ultrafiltrácie.</p>

<p>Tmavý moč môže signalizovať koncentrovaný moč, ale v kontexte svalových bolestí a hypertermie aj myoglobinúriu pri rabdomyolýze. Naopak, dyspnoe a rast hmotnosti môžu znamenať objemové preťaženie, pri ktorom ďalšie zvyšovanie príjmu tekutín nie je riešením.</p>

<h2>Čo dôkazy podporujú a čo zostáva neisté</h2>

<p>Populačné štúdie konzistentne spájajú vysokú teplotu s vyššou renálnou morbiditou a u dialyzovaných pacientov aj s mortalitou. Post hoc analýza DAPA-CKD pridáva signál možného rýchlejšieho poklesu eGFR pri opakovanej tepelnej expozícii. Tieto práce však väčšinou nie sú randomizovanými skúškami preventívnych zásahov a jednotlivé prahové teploty závisia od regiónu, aklimatizácie a použitého indexu.</p>

<p>Medscape je odborný spravodajský komentár, nie klinické odporúčanie. Správa <em>Lancet Countdown</em> poskytuje kvalitný populačný rámec, ale nerieši individuálny nefrologický manažment. Praktické odporúčania v tomto texte preto kombinujú výsledky epidemiologických štúdií s princípmi objemového a liekového manažmentu CKD. Nie sú náhradou vyšetrenia ani univerzálnym predpisom príjmu tekutín.</p>

<h2>Záver</h2>

<p>Extrémne horúčavy predstavujú rastúce a klinicky relevantné riziko pre ľudí s CKD aj pre dialyzovanú populáciu. Obličky ohrozuje najmä objemová deplécia, hemodynamický pokles GFR, poruchy elektrolytov a pri ťažkej hypertermii aj systémové a svalové poškodenie. U pokročilej CKD a dialýzy však neprimeraná liberalizácia tekutín môže viesť k opačnému problému – objemovému preťaženiu.</p>

<p>Najbezpečnejšou stratégiou nie je jedna univerzálna rada, ale plán pripravený pred horúčavou: individualizovaný príjem tekutín, presné pravidlá pre lieky, sledovanie hmotnosti, tlaku, diurézy a symptómov, dostupný kontakt a včasná kontrola po dehydratácii alebo klinickom zhoršení.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Villa R. Extreme Heat: Is Health Toll Worse Than We Think? Medscape; 7. júla 2026. Odborný spravodajský komentár. <a href="https://www.medscape.com/viewarticle/extreme-heat-health-toll-worse-than-we-think-2026a1000mol" target="_blank" rel="noopener noreferrer">Medscape</a>.<br>
<strong>Európske údaje:</strong> Kriit HK, Chen-Xu J, Semenza JC, et al. The 2026 Europe report of the Lancet Countdown on health and climate change: narrowing window for decisive health action. <em>Lancet Public Health</em>. 2026;11. DOI: 10.1016/S2468-2667(26)00025-3. <a href="https://doi.org/10.1016/S2468-2667(26)00025-3" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://lancetcountdown.org/europe/2026-report/" target="_blank" rel="noopener noreferrer">správa</a>.<br>
<strong>CKD a tepelná expozícia:</strong> Zhang Z, et al. Ambient heat exposure and kidney function in patients with chronic kidney disease: a post-hoc analysis of the DAPA-CKD trial. <em>Lancet Planet Health</em>. 2024;8(4):e225–e233. DOI: 10.1016/S2542-5196(24)00026-3. <a href="https://pubmed.ncbi.nlm.nih.gov/38580424/" target="_blank" rel="noopener noreferrer">PubMed</a>.<br>
<strong>Dialýza:</strong> Blum MF, et al. Extreme Humid-Heat Exposure and Mortality Among Patients Receiving Dialysis. <em>Am J Kidney Dis</em>. 2024;84(5):582–592.e1. DOI: 10.1053/j.ajkd.2024.04.010. <a href="https://pubmed.ncbi.nlm.nih.gov/38876272/" target="_blank" rel="noopener noreferrer">PubMed</a> · Couchoud C, et al. Moderately elevated ambient temperature is associated with mortality in dialysis patients, but not in transplant patients. <em>Clin Kidney J</em>. 2025;18(2):sfae428. DOI: 10.1093/ckj/sfae428. <a href="https://pubmed.ncbi.nlm.nih.gov/40235630/" target="_blank" rel="noopener noreferrer">PubMed</a>.<br>
<strong>Okolitá teplota a intradialyzačná hypotenzia:</strong> He Y, et al. Effect of Ambient Temperature on Intradialytic Hypotension in Hemodialysis Patients: A Retrospective Cohort Study. <em>Kidney Med</em>. 2026;8(7):101413. DOI: 10.1016/j.xkme.2026.101413. <a href="https://pubmed.ncbi.nlm.nih.gov/42328687/" target="_blank" rel="noopener noreferrer">PubMed</a>.<br>
<strong>Liekový manažment:</strong> Kidney Disease: Improving Global Outcomes. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney Int</em>. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_extreme_heat_ckd newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_extreme_heat_ckd pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_extreme_heat_ckd pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_extreme_heat_ckd migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    ?>
    <!DOCTYPE html>
    <html lang="sk">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Migrácia článku</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    </head>
    <body>
      <main class="container pt-60 pb-60">
        <div class="auth-container">
          <h2>Migrácia článku</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
              <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endif; ?>

          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?>
              <p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p>
            <?php endif; ?>
          </div>

          <ul>
            <?php foreach ($articles as $a): ?>
              <li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li>
            <?php endforeach; ?>
          </ul>

          <p class="mt-30">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
