<?php
/**
 * add_atacicept-trutakna-iga-nefropatia-fda-proteinuria_article.php
 * Odborný článok o zrýchlenom schválení ataciceptu pri primárnej IgA nefropatii.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Atacicept pri primárnej IgA nefropatii: čo znamená zrýchlené schválenie FDA',
    'slug'         => 'atacicept-trutakna-iga-nefropatia-fda-proteinuria',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'FDA schválila Trutaknu na zníženie proteinúrie pri primárnej IgA nefropatii. Čo ukázala štúdia ORIGIN 3, aké sú bezpečnostné riziká a čo ešte nevieme.',
    'content'      => <<<'HTML'
<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) udelil 7. júla 2026 lieku Trutakna (atacicept-vymj) zrýchlené schválenie na zníženie proteinúrie u dospelých s primárnou IgA nefropatiou, ktorí sú ohrození progresiou ochorenia. Odporúčaná dávka je 150 mg podkožne raz týždenne; liek sa podáva pomocou jednodávkového naplneného autoinjektora.</p>

<p>Ide o prvý liek schválený FDA pri IgA nefropatii, ktorý súčasne inhibuje signálne dráhy BAFF a APRIL. Regulačné rozhodnutie však neznamená, že atacicept už preukázal spomalenie dlhodobého poklesu glomerulovej filtrácie alebo prevenciu zlyhania obličiek. Schválená indikácia je založená na redukcii proteinúrie a jej ďalšie trvanie môže závisieť od potvrdenia klinického prínosu v pokračujúcej štúdii ORIGIN 3.</p>

<h2>Čo presne FDA schválila</h2>

<div class="table-responsive" role="region" aria-label="Základné údaje o americkom schválení ataciceptu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Oblasť</th>
      <th scope="col">Regulačný údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Liek</td>
      <td>Trutakna (atacicept-vymj)</td>
    </tr>
    <tr>
      <td>Indikácia v USA</td>
      <td>zníženie proteinúrie u dospelých s primárnou IgA nefropatiou a rizikom progresie</td>
    </tr>
    <tr>
      <td>Dávkovanie</td>
      <td>150 mg podkožne raz týždenne</td>
    </tr>
    <tr>
      <td>Typ schválenia</td>
      <td>zrýchlené schválenie na základe redukcie proteinúrie</td>
    </tr>
    <tr>
      <td>Nepotvrdený prínos</td>
      <td>dlhodobé spomalenie poklesu funkcie obličiek a prevencia zlyhania obličiek</td>
    </tr>
    <tr>
      <td>Potvrdzujúce hodnotenie</td>
      <td>pokračujúca zaslepená časť ORIGIN 3 s hodnotením zmeny eGFR</td>
    </tr>
  </tbody>
</table>
</div>

<p>Formulácia „u pacientov s rizikom progresie“ v americkej indikácii neobsahuje presnú hranicu proteinúrie ani eGFR. Tieto hranice však mala registračná štúdia, preto ich treba poznať pri posudzovaní prenositeľnosti výsledkov na konkrétneho pacienta.</p>

<h2>Mechanizmus: rozpustný receptor TACI-Fc</h2>

<p>Atacicept-vymj je rekombinantný fúzny glykoproteín TACI-Fc. Obsahuje extracelulárnu časť receptora TACI viažucu ligandy a Fc časť ľudského IgG1. Viaže faktor aktivujúci B-lymfocyty BAFF, označovaný aj ako BLyS, a ligand APRIL, čím znižuje ich signalizáciu.</p>

<p>BAFF a APRIL podporujú prežívanie, maturáciu a diferenciáciu B-lymfocytov a plazmatických buniek. Pri IgA nefropatii sa podieľajú na tvorbe galaktozodeficientného IgA1 (Gd-IgA1) a protilátok proti nemu. Následné imunokomplexy sa ukladajú v mezangiu, aktivujú zápalové a komplementové dráhy a prispievajú ku glomerulovému poškodeniu.</p>

<p>Atacicept tak zasahuje vyššie v patogenetickej kaskáde než čisto hemodynamická alebo antiproteinurická liečba. Biologická racionalita však sama osebe nedokazuje klinický prínos. Rozhodujúce sú výsledky kontrolovaných štúdií a ich trvanie.</p>

<h2>ORIGIN 3: koho vlastne skúmali</h2>

<p>ORIGIN 3 (NCT04716231) je pokračujúca globálna, multicentrická, randomizovaná, dvojito zaslepená a placebom kontrolovaná štúdia fázy 3. Účastníci dostávali atacicept 150 mg podkožne raz týždenne alebo zodpovedajúce placebo. Predbežne špecifikovaná analýza účinnosti zahŕňala prvých 203 pacientov, ktorí dosiahli 36. týždeň: 106 v skupine s ataciceptom a 97 v skupine s placebom.</p>

<p>Podľa americkej preskripčnej informácie boli zaradení dospelí s:</p>

<ul>
  <li>biopticky potvrdenou primárnou IgA nefropatiou,</li>
  <li>eGFR najmenej 30 ml/min/1,73 m²,</li>
  <li>UPCR najmenej 1 g/g v 24-hodinovej vzorke alebo proteinúriou najmenej 1 g za 24 hodín,</li>
  <li>stabilnou maximálne tolerovanou dávkou inhibítora systému renín-angiotenzín,</li>
  <li>možnosťou súbežnej stabilnej liečby inhibítorom SGLT2 a/alebo antagonistom mineralokortikoidného receptora.</li>
</ul>

<p>Pacienti s inou glomerulopatiou alebo so systémovou imunosupresívnou liečbou počas 12 týždňov pred skríningom boli vylúčení. Priemerná východisková eGFR bola 65 ml/min/1,73 m² a geometrický priemer UPCR 1,5 g/g. Takmer všetci užívali inhibítor ACE a/alebo sartán a 53 % užívalo inhibítor SGLT2.</p>

<p>Tieto údaje sú pre prax podstatné. Výsledok nevznikol pri neselektovanej populácii so všetkými štádiami IgA nefropatie, ale u pacientov s pretrvávajúcou proteinúriou napriek nastavenej podpornej liečbe a s eGFR najmenej 30 ml/min/1,73 m².</p>

<h2>Primárny výsledok: výrazná redukcia proteinúrie</h2>

<p>Primárnym ukazovateľom bola percentuálna zmena UPCR z 24-hodinového zberu moču od východiskovej hodnoty do 36. týždňa. Výsledky boli:</p>

<ul>
  <li><strong>46 % redukcia UPCR</strong> v skupine s ataciceptom (95 % interval spoľahlivosti 38 až 53 %),</li>
  <li><strong>7 % redukcia UPCR</strong> v skupine s placebom (95 % interval spoľahlivosti −8 až 19 %),</li>
  <li><strong>42 % relatívna redukcia oproti placebu</strong> (95 % interval spoľahlivosti 29 až 52 %; p &lt; 0,0001).</li>
</ul>

<p>Nejde teda o odčítanie 46 mínus 7 percentuálnych bodov, ale o modelovaný pomer geometrických priemerov. Účinok na proteinúriu bol v preddefinovaných podskupinách vo všeobecnosti konzistentný vrátane pacientov s a bez súbežného inhibítora SGLT2. Podskupinové analýzy však nemožno automaticky chápať ako dôkaz rovnakej účinnosti v každej malej klinickej podskupine.</p>

<h2>Biomarkery podporujú mechanizmus, nenahrádzajú klinický výsledok</h2>

<p>Do 36. týždňa sa pri atacicepte znížila priemerná sérová koncentrácia Gd-IgA1 približne o 68 %. Klesli aj celkové koncentrácie IgA, IgG a IgM. Tento farmakodynamický profil podporuje očakávaný účinok inhibície BAFF a APRIL.</p>

<p>Redukcia Gd-IgA1 však bola sekundárnym biomarkerovým výsledkom a podľa zverejnených údajov nebola zahrnutá do testovania s kontrolou multiplicity. Nemožno ju preto interpretovať ako samostatný dôkaz, že liek predchádza dialýze, transplantácii alebo úmrtiu. Biomarker ukazuje zásah do predpokladaného mechanizmu; klinický prínos musí potvrdiť vývoj eGFR a dlhodobé výsledky.</p>

<h2>Prečo je schválenie zrýchlené</h2>

<p>Program zrýchleného schvaľovania umožňuje FDA schváliť liečbu závažného ochorenia na základe ukazovateľa, o ktorom sa odôvodnene predpokladá, že predpovedá klinický prínos. Pri Trutakne bola takýmto ukazovateľom redukcia proteinúrie.</p>

<p>Proteinúria je pri IgA nefropatii významným prognostickým aj liečebným ukazovateľom. Napriek tomu zníženie proteinúrie po 36 týždňoch nie je totožné s dôkazom dlhodobého zachovania funkcie obličiek. FDA preto výslovne uvádza, že zatiaľ nebolo preukázané, či Trutakna dlhodobo spomaľuje pokles funkcie obličiek.</p>

<p>Pokračujúca zaslepená štúdia ORIGIN 3 hodnotí anualizovanú zmenu eGFR po 52 a 104 týždňoch. Spoločnosť avizovala analýzu eGFR v treťom štvrťroku 2026, tento časový údaj však nie je výsledkom ani zárukou plného schválenia. Až údaje z potvrdzujúcej časti ukážu, či antiproteinurický účinok sprevádza klinicky významné spomalenie straty funkcie obličiek.</p>

<h2>Bezpečnosť: infekcie a lokálne reakcie</h2>

<p>Bezpečnostná analýza ORIGIN 3 zahŕňala 428 pacientov, po 214 v každej skupine. Najčastejšie nežiaduce reakcie boli:</p>

<ul>
  <li>infekcie: 32 % pri atacicepte oproti 28 % pri placebe,</li>
  <li>lokálne reakcie po podaní: 30 % oproti 5 %,</li>
  <li>infekcia horných dýchacích ciest: 12 % oproti 9 %,</li>
  <li>reakcia v mieste vpichu: 19 % oproti 2 %,</li>
  <li>erytém v mieste vpichu: 6 % oproti 1 %.</li>
</ul>

<p>Väčšina reakcií bola mierna alebo stredne závažná a ustúpila bez prerušenia alebo ukončenia liečby. Trvanie expozície v registračnej bezpečnostnej analýze však bolo obmedzené; medián predstavoval 34 týždňov pri atacicepte a 31 týždňov pri placebe. Menej časté alebo neskoré nežiaduce účinky preto môže spoľahlivejšie charakterizovať až dlhšie sledovanie a farmakovigilancia.</p>

<p>Trutakna je kontraindikovaná pri závažnej precitlivenosti na atacicept-vymj alebo ktorúkoľvek pomocnú látku. Pred začatím liečby treba posúdiť aktívnu infekciu a podanie odložiť, kým infekcia neustúpi alebo nie je primerane liečená. Pri závažnej infekcii počas liečby sa má zvážiť dočasné prerušenie.</p>

<p>Súbežné podávanie s inými imunomodulačnými liekmi nebolo vyhodnotené. Kombinácia s liekmi ovplyvňujúcimi imunitný systém vrátane systémových kortikosteroidov môže zvyšovať infekčné riziko. Tento údaj je dôležitý najmä pri plánovaní sekvenčnej alebo kombinovanej liečby IgA nefropatie.</p>

<h2>Očkovanie a osobitné populácie</h2>

<p>Pred začatím liečby sa majú dokončiť očkovania primerané veku podľa aktuálnych odporúčaní. Živé vakcíny sa neodporúčajú počas 30 dní pred prvou dávkou ani počas liečby, pretože atacicept môže oslabiť imunitnú odpoveď na vakcíny a zvýšiť riziko infekcie po živej vakcíne.</p>

<p>Údaje o použití v gravidite nie sú dostatočné na spoľahlivé posúdenie rizika. Vzhľadom na mechanizmus účinku sa má zohľadniť možná imunosupresia dieťaťa exponovaného in utero. Nie sú dostupné údaje o prítomnosti lieku v ľudskom mlieku a jeho bezpečnosť ani účinnosť u detí neboli stanovené. V štúdiách tiež nebol dostatok pacientov vo veku najmenej 65 rokov na spoľahlivé posúdenie odlišnej odpovede.</p>

<h2>Miesto v liečebnej stratégii</h2>

<p>Atacicept nenahrádza základnú nefroprotektívnu liečbu. Registračná štúdia ho skúmala na podklade stabilnej maximálne tolerovanej blokády systému renín-angiotenzín, pričom viac ako polovica pacientov užívala aj inhibítor SGLT2. Naďalej zostáva potrebná dôsledná kontrola krvného tlaku, obmedzenie sodíka, nefajčenie, primeraná pohybová aktivita, liečba kardiometabolických rizík a pravidelné sledovanie proteinúrie a eGFR.</p>

<p>Pri budúcom rozhodovaní o atacicepte bude dôležité posúdiť:</p>

<ul>
  <li>bioptické potvrdenie primárnej IgA nefropatie a vylúčenie sekundárnej príčiny,</li>
  <li>výšku a trend proteinúrie napriek optimalizovanej podpornej liečbe,</li>
  <li>eGFR a rýchlosť jej doterajšieho poklesu,</li>
  <li>predchádzajúcu a plánovanú imunosupresiu,</li>
  <li>infekčnú anamnézu, očkovací status a riziko precitlivenosti,</li>
  <li>graviditu, reprodukčné plány a preferencie pacienta,</li>
  <li>regulačnú dostupnosť, úhradu a lokálne odporúčania.</li>
</ul>

<p>Priame porovnanie s inými cielenými liekmi pri IgA nefropatii zatiaľ chýba. Rozdiely medzi štúdiami v populácii, podpornej liečbe, dĺžke sledovania a definícii ukazovateľov neumožňujú zostaviť spoľahlivý rebríček účinnosti jednoduchým porovnaním percent redukcie proteinúrie.</p>

<h2>Európa a Slovensko: americké schválenie nestačí</h2>

<p>Rozhodnutie FDA platí v Spojených štátoch a samo osebe neoprávňuje na rutinné uvádzanie lieku na trh v Európskej únii. Európska lieková agentúra udelila ataciceptu v novembri 2024 štatút lieku na ojedinelé ochorenia (<em>orphan designation</em>) pre liečbu primárnej IgA nefropatie. Tento štatút poskytuje podporu vývoju lieku, ale podľa EMA neznamená registráciu ani dostupnosť lieku.</p>

<p>Pre slovenskú prax preto zatiaľ nejde o štandardne registrovanú a hradenú možnosť. Prípadné budúce použitie bude závisieť od európskeho regulačného rozhodnutia, slovenských podmienok kategorizácie a úhrady, aktuálnych odborných odporúčaní a individuálneho klinického posúdenia.</p>

<h2>Čo je dôkaz a čo zatiaľ iba predpoklad</h2>

<div class="table-responsive" role="region" aria-label="Rozlíšenie potvrdených a zatiaľ neistých poznatkov o atacicepte" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Podložené dostupnými údajmi</th>
      <th scope="col">Zatiaľ nepotvrdené</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>významná redukcia UPCR po 36 týždňoch oproti placebu</td>
      <td>dlhodobé spomalenie poklesu eGFR</td>
    </tr>
    <tr>
      <td>pokles Gd-IgA1 a sérových imunoglobulínov</td>
      <td>zníženie potreby dialýzy alebo transplantácie</td>
    </tr>
    <tr>
      <td>častejšie lokálne reakcie a mierne vyšší výskyt infekcií</td>
      <td>úplný profil zriedkavých a dlhodobých nežiaducich účinkov</td>
    </tr>
    <tr>
      <td>americká indikácia na redukciu proteinúrie</td>
      <td>registrácia a úhrada v Európskej únii alebo na Slovensku</td>
    </tr>
    <tr>
      <td>účinnosť v skúmanej populácii na podpornej liečbe</td>
      <td>priamy porovnávací prínos oproti iným cieleným terapiám</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Limity hlavného zdroja</h2>

<p>Hlavným spracovaným zdrojom je krátka správa agentúry Reuters. Správne zachytáva regulačné rozhodnutie a základný výsledok štúdie, nemôže však nahradiť úplnú preskripčnú informáciu, regulačný dokument ani recenzovanú publikáciu.</p>

<p>Preto som indikáciu, dávkovanie, vstupné kritériá, výsledky a bezpečnostné upozornenia overil v oznámení FDA, americkej preskripčnej informácii a publikácii ORIGIN 3 v <em>New England Journal of Medicine</em>. Európsky stav je interpretovaný podľa záznamu EMA o štatúte lieku na ojedinelé ochorenia.</p>

<h2>Záver</h2>

<p>Atacicept prináša pri primárnej IgA nefropatii biologicky cielenú inhibíciu BAFF a APRIL. V predbežne špecifikovanej analýze ORIGIN 3 znížil proteinúriu po 36 týždňoch o 42 % oproti placebu, čo viedlo k zrýchlenému schváleniu FDA na redukciu proteinúrie u dospelých s rizikom progresie.</p>

<p>Najdôležitejšia otázka zostáva otvorená: či tento účinok dlhodobo spomalí pokles eGFR a zníži riziko zlyhania obličiek. Kým nebudú známe potvrdzujúce výsledky, treba atacicept opisovať ako schválenú antiproteinurickú liečbu v USA, nie ako preukázanú prevenciu dialýzy alebo transplantácie.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Mahatole S, Singh P. US FDA Approves Vera’s Kidney Disease Drug. <em>Reuters</em>. 7. júla 2026. <a href="https://www.medscape.com/s/viewarticle/us-fda-approves-veras-kidney-disease-drug-2026a1000mz7" target="_blank" rel="noopener noreferrer">Odkaz na spracovaný zdroj</a>.</em></p>

<p><em><strong>Regulačné zdroje:</strong> U.S. Food and Drug Administration. FDA Approves New Treatment to Reduce Proteinuria in Adults With Primary Immunoglobulin A Nephropathy. 7. júla 2026. <a href="https://www.fda.gov/drugs/news-events-human-drugs/fda-approves-new-treatment-reduce-proteinuria-adults-primary-immunoglobulin-nephropathy" target="_blank" rel="noopener noreferrer">FDA</a> · Trutakna (atacicept-vymj), úplná americká preskripčná informácia, júl 2026. <a href="https://webfiles.veratx.com/docs/TRUTAKNA_Prescribing_Information.pdf" target="_blank" rel="noopener noreferrer">Preskripčná informácia</a>.</em></p>

<p><em><strong>Klinická štúdia:</strong> Lafayette R, Barbour SJ, Brenner RM, et al. A Phase 3 Trial of Atacicept in Patients with IgA Nephropathy. <em>New England Journal of Medicine</em>. 2026;394:647–657. DOI: 10.1056/NEJMoa2510198. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2510198" target="_blank" rel="noopener noreferrer">Publikácia</a> · ORIGIN 3, NCT04716231. <a href="https://clinicaltrials.gov/study/NCT04716231" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</em></p>

<p><em><strong>Európsky regulačný stav:</strong> European Medicines Agency. EU/3/24/2985, orphan designation for treatment of primary IgA nephropathy. <a href="https://www.ema.europa.eu/en/medicines/human/orphan-designations/eu-3-24-2985" target="_blank" rel="noopener noreferrer">EMA</a>.</em></p>
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
                error_log('add_atacicept newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_atacicept pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_atacicept pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_atacicept migration error: ' . $e->getMessage());
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
