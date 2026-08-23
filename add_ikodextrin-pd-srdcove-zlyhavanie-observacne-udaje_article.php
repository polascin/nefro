<?php
/**
 * add_ikodextrin-pd-srdcove-zlyhavanie-observacne-udaje_article.php
 * Idempotentný UPSERT skript pre odborne a jazykovo korigovaný článok
 * o ikodextríne pri peritoneálnej dialýze a srdcovom zlyhávaní.
 * Pôvodní autori zdroja sú evidovaní aj v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Ikodextrín pri peritoneálnej dialýze a srdcovom zlyhávaní: ako čítať nové observačné údaje',
    'slug'         => 'ikodextrin-pd-srdcove-zlyhavanie-observacne-udaje',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 20:03:14',
    'is_top'       => 0,
    'excerpt'      => 'Taiwanská kohorta 1 800 pacientov spájala používanie ikodextrínu s nižšou mortalitou a menším počtom MACE. Veľkosť efektu však treba čítať v kontexte observačného dizajnu a reziduálneho skreslenia.',
    'content'      => <<<'HTML'
<p>U pacientov liečených <strong>peritoneálnou dialýzou (PD)</strong>, ktorí majú súčasne srdcové zlyhávanie, je spoľahlivá kontrola objemu jednou z kľúčových podmienok úspešnej liečby. Bežné roztoky s glukózou vytvárajú kryštaloidný osmotický gradient, ktorý počas dlhej výmeny postupne slabne, pretože sa glukóza vstrebáva. Opakovaná expozícia vysokým koncentráciám glukózy navyše zvyšuje metabolickú záťaž a môže nepriaznivo vplývať na peritoneálnu membránu.</p>

<p><strong>Ikodextrín</strong> je 7,5 % izoosmolárny roztok obsahujúci vysokomolekulový polymér glukózy odvodený od škrobu. Ultrafiltráciu zabezpečuje koloidnou osmózou, vďaka čomu dokáže počas dlhej, približne 12- až 16-hodinovej doby zotrvania roztoku v peritoneálnej dutine (ďalej „dlhá výmena“) udržiavať stabilnejší odvod tekutiny a podporovať odstraňovanie sodíka. Fyziologické odôvodnenie jeho použitia pri objemovom preťažení je presvedčivé, dôkazy o vplyve na mortalitu a závažné kardiovaskulárne príhody však boli doteraz obmedzené.</p>

<p>Nová retrospektívna kohortová štúdia publikovaná v časopise <em>Nephrology Dialysis Transplantation</em> skúmala súvislosť medzi používaním ikodextrínu a klinickými výsledkami u pacientov na PD s už prítomným srdcovým zlyhávaním. Výsledky sú pozoruhodné, ale ich veľkosť si vyžaduje mimoriadne opatrnú interpretáciu.</p>

<h2>Ako bola štúdia navrhnutá</h2>

<p>Autori využili databázu Chang Gung Research Database, ktorá združuje elektronické zdravotné záznamy zo siedmich nemocníc na Taiwane. Zaradili dospelých pacientov so zlyhaním obličiek, ktorí začali PD v rokoch 2005 až 2022, boli ňou liečení najmenej 90 dní a mali diagnostikované srdcové zlyhávanie. Sledovanie sa skončilo 30. júna 2023.</p>

<p>Analyzovaných bolo <strong>1 800 pacientov</strong>: 1 102 bolo podľa hlavnej definície zaradených medzi používateľov ikodextrínu a 698 medzi nepoužívateľov. Za používateľa sa považoval pacient, ktorý dostával ikodextrín aspoň počas 50 % celkového trvania PD. Toto rozdelenie neznamenalo jednoduché porovnanie „vždy“ oproti „nikdy“: 792 používateľov začalo ikodextrín až po začatí PD a 321 pacientov zaradených medzi nepoužívateľov ho dostávalo kratšie než počas polovice trvania PD.</p>

<p>V hlavnej analýze autori modelovali expozíciu ako časovo premennú. Obdobia pred začatím liečby, počas nej a po jej prípadnom ukončení sa priraďovali k aktuálnemu expozičnému stavu. Modely upravili o viaceré demografické, klinické, laboratórne a liekové premenné. Robustnosť nálezov skúmali aj emuláciou cieľovej štúdie v 72 štvrťročných kohortách a alternatívnou analýzou, ktorá rozdelila sledovanie na trojmesačné intervaly.</p>

<p>Taiwanské pravidlá úhrady umožňovali predpísať ikodextrín raz denne najmä pri HbA1c nad 7 %, potrebe častých výmen s 2,5 % alebo 4,25 % glukózou alebo pri vysokom či vysokopriemernom transporte peritonea. Samotná indikácia preto už vopred súvisela s klinickým stavom pacienta a s rozhodnutím ošetrujúceho lekára.</p>

<h2>Hlavné výsledky</h2>

<p>Primárnymi sledovanými výsledkami boli celková mortalita, kardiovaskulárna mortalita, náhla smrť a veľké nežiaduce kardiovaskulárne príhody (MACE). Kompozit MACE zahŕňal kardiovaskulárne úmrtie, hospitalizáciu pre srdcové zlyhávanie, infarkt myokardu a ischemickú cievnu mozgovú príhodu.</p>

<table>
  <thead>
    <tr>
      <th scope="col">Sledovaný výsledok</th>
      <th scope="col">Príhody na 100 pacientorokov<br>ikodextrín / porovnávacia skupina</th>
      <th scope="col">Upravený HR (95 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Celková mortalita</td>
      <td>3,2 / 14,0</td>
      <td>0,16 (0,13–0,20)</td>
    </tr>
    <tr>
      <td>Kardiovaskulárna mortalita</td>
      <td>1,0 / 3,4</td>
      <td>0,20 (0,13–0,30)</td>
    </tr>
    <tr>
      <td>Náhla smrť</td>
      <td>2,3 / 11,0</td>
      <td>0,15 (0,11–0,19)</td>
    </tr>
    <tr>
      <td>MACE</td>
      <td>9,9 / 11,6</td>
      <td>0,68 (0,58–0,80)</td>
    </tr>
  </tbody>
</table>

<p><em>HR – pomer okamžitých rizík (z angl. <span lang="en">hazard ratio</span>); IS – interval spoľahlivosti.</em></p>

<p>Používanie ikodextrínu teda bolo spojené s výrazne nižším pomerom okamžitých rizík úmrtia a s miernejšie nižším pomerom okamžitých rizík kompozitu MACE. Emulácia cieľovej štúdie priniesla podobné odhady: HR pre celkovú mortalitu 0,15, pre kardiovaskulárnu mortalitu 0,11, pre náhlu smrť 0,16 a pre MACE 0,69. Aj analýza trojmesačných intervalov ukázala výsledky rovnakým smerom.</p>

<h2>Čo sa neznížilo</h2>

<p>Pri interpretácii kompozitu MACE je dôležité pozrieť sa na jeho jednotlivé zložky. Medzi skupinami sa nepreukázal štatisticky významný rozdiel v hospitalizáciách pre srdcové zlyhávanie (upravený HR 1,06), infarkte myokardu (HR 0,94) ani ischemickej cievnej mozgovej príhode (HR 1,39). Nižší výskyt MACE bol preto podľa autorov poháňaný predovšetkým rozdielom v kardiovaskulárnej mortalite, najmä v náhlej smrti. Rozdiel sa nepreukázal ani pri novodiagnostikovaných nádorových ochoreniach v hlavnej analýze.</p>

<p>Tento nesúlad je klinicky podstatný. Ak by ikodextrín v sledovanej populácii skutočne vyvolával taký veľký pokles mortality, bolo by vhodné vysvetliť, prečo sa súčasne neznížili hospitalizácie pre srdcové zlyhávanie ani ďalšie nefatálne kardiovaskulárne príhody. Observačné údaje na túto otázku neposkytujú definitívnu odpoveď.</p>

<h2>Sekundárne výsledky: technické prežívanie, EPS a transplantácia</h2>

<p>Používanie ikodextrínu bolo v hlavnej analýze spojené aj s nižším pomerom okamžitých rizík prechodu na hemodialýzu (HR 0,52) a enkapsulujúcej peritoneálnej sklerózy (EPS; HR 0,40). Tieto nálezy nemožno automaticky vysvetliť ochranným účinkom roztoku. Ikodextrín sa často nasadzuje pri poruche ultrafiltrácie a dlhšom trvaní PD, čo samo osebe súvisí s rizikom EPS; v literatúre sú navyše výsledky o vzťahu ikodextrínu a EPS rozporné. Autori preto správne požadujú ďalšie skúmanie.</p>

<p>V skupine používateľov bol zároveň nižší pomer okamžitých rizík transplantácie obličky (HR 0,22). Nejde o dôkaz, že by ikodextrín zhoršoval vhodnosť pacienta na transplantáciu. Pravdepodobnejšie ide o vplyv nemeraných klinických a sociálnych faktorov, dostupnosti žijúcich darcov alebo rozhodovania o zaradení na čakaciu listinu. Rozdielna frekvencia transplantácie môže navyše ovplyvniť dĺžku a štruktúru ďalšieho sledovania oboch skupín.</p>

<h2>Prečo veľmi nízke HR neznamenajú 80-percentný liečebný účinok</h2>

<p>Hodnota HR 0,16 znamená, že v použitom štatistickom modeli bol okamžitý pomer rizika úmrtia u exponovaných pacientov približne o 84 % nižší. <strong>Nie je to však dôkaz, že predpísanie ikodextrínu zníži individuálne riziko úmrtia o 84 %</strong>, ani údaj o absolútnom prínose liečby. Takýto kauzálny záver by si vyžadoval spoľahlivé vylúčenie systematických rozdielov medzi skupinami, čo retrospektívna štúdia nedokáže zabezpečiť.</p>

<p>Skupiny sa na začiatku významne líšili. Používatelia ikodextrínu mali častejšie diabetes a hypertenziu, o niečo nižšie koncentrácie albumínu a hemoglobínu a častejšie používali viaceré kardiovaskulárne lieky. Zároveň častejšie začínali PD v novšom kalendárnom období. Štatistická úprava tieto rozdiely zmierňuje, ale neodstraňuje vplyv nemeraných premenných ani zmeny kvality starostlivosti v priebehu rokov.</p>

<p>Časovo premenné modelovanie a emulácia cieľovej štúdie znižujú riziko zámeny expozičného času a skreslenia nesmrteľným časom. Emulácia však nebola randomizovanou štúdiou: v jednotlivých štvrťročiach sa exponovaní a neexponovaní pacienti párovali podľa veku a pohlavia a zvyšné rozdiely sa riešili modelovou úpravou. Zhodné výsledky viacerých analýz preto posilňujú konzistentnosť asociácie, nie istotu kauzality.</p>

<p>Ďalšími limitmi sú retrospektívne používanie diagnostických kódov, dostupnosť iba primárnej príčiny smrti z registra, chýbajúce údaje o socioekonomickom postavení, stravovaní, adherencii a fyzickej aktivite, ako aj osobitné taiwanské pravidlá úhrady ikodextrínu. Väčšina pacientov mala zachovanú ejekčnú frakciu nad 60 % a priemerné sledovanie trvalo približne 3,5 roka; prenos výsledkov na iné populácie a systémy úhrady preto nie je samozrejmý.</p>

<h2>Biologické odôvodnenie je presvedčivé, mechanizmus však štúdia nedokázala</h2>

<p>Stabilnejšia ultrafiltrácia počas dlhej výmeny, účinnejšie odstraňovanie sodíka a nižšia expozícia glukóze môžu podporiť kontrolu objemu a metabolickú stabilitu. Ide o biologicky prijateľné vysvetlenia, nie o preukázanú sprostredkujúcu cestu pozorovaného rozdielu v mortalite.</p>

<p>Štúdia systematicky nehodnotila stav hydratácie bioimpedančnou spektroskopiou ani biomarkery, ako je BNP, a nepreukázala, že rozdiel v prežívaní bol spôsobený zlepšením objemového stavu. Tvrdenia o priaznivom vplyve na remodeláciu myokardu, arytmogénny substrát alebo fibriláciu predsiení by preto išli nad rámec tejto analýzy.</p>

<h2>Praktický význam pre nefrológa</h2>

<p>Výsledky podporujú klinickú úvahu o ikodextríne u pacienta na PD so srdcovým zlyhávaním, najmä ak je problémom dlhá výmena, nedostatočná ultrafiltrácia, objemové preťaženie, vysoký transport peritonea alebo potreba obmedziť glukózovú záťaž. Nepredstavujú však nový dôkaz, na základe ktorého by sa mal ikodextrín bez rozdielu predpisovať všetkým pacientom s vysokým kardiovaskulárnym rizikom.</p>

<p>Predpis má zostať individualizovaný podľa objemového stavu, transportných vlastností peritonea, reziduálnej funkcie obličiek, zloženia ostatných výmen, glykémie a tolerancie liečby. Ikodextrín je súčasťou komplexného predpisu PD a nenahrádza štandardnú farmakologickú ani nefarmakologickú liečbu srdcového zlyhávania.</p>

<p><strong>Dôležitá bezpečnostná zásada:</strong> maltóza vznikajúca pri metabolizme ikodextrínu môže pri nekompatibilných glukomeroch a testovacích prúžkoch spôsobiť falošne vysoké hodnoty glykémie, zakryť skutočnú hypoglykémiu a viesť k podaniu nadmernej dávky inzulínu. Používať sa má iba metóda špecifická pre glukózu. Nevhodné sú systémy založené na GDH-PQQ a GDO a interferovať môžu aj niektoré systémy GDH-FAD; kompatibilitu konkrétneho glukomera a prúžkov treba overiť v dokumentácii výrobcu. Interferencia môže pretrvávať až dva týždne po ukončení ikodextrínu.</p>

<h2>Záver</h2>

<p>V taiwanskej kohorte 1 800 pacientov na peritoneálnej dialýze so srdcovým zlyhávaním bolo používanie ikodextrínu konzistentne spojené s nižšou celkovou a kardiovaskulárnou mortalitou, nižším výskytom náhlej smrti a menším počtom MACE. Veľmi nízke hodnoty HR pre mortalitu sú klinicky nápadné, ale pre observačný dizajn ich nemožno považovať za veľkosť liečebného účinku.</p>

<p>Štúdia posilňuje biologický a klinický podklad na používanie ikodextrínu pri vhodne zvolených pacientoch. Definitívne posúdenie jeho vplyvu na prežívanie si však vyžaduje prospektívne, ideálne randomizované štúdie s priamym hodnotením objemového stavu a vopred definovanými kardiovaskulárnymi výsledkami.</p>

<hr>

<p><em><strong>Zdroj:</strong> Ma L-Y, Tu Y-R, Chan M-J, Chan CI, Chen J-J, Lee C-C, Wu VC-C, Chu P-H, Hsu H-H, Chang C-H. The effect of icodextrin on peritoneal dialysis patients with congestive heart failure: a time-varying exposure design and target trial emulation approach. <em>Nephrology Dialysis Transplantation</em>. 2026;41(7):1313–1321. Publikované online 13. decembra 2025. <a href="https://academic.oup.com/ndt/article/41/7/1313/8379437" target="_blank" rel="noopener noreferrer">Oxford Academic – plný text</a>. doi: <a href="https://doi.org/10.1093/ndt/gfaf265" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfaf265</a>. PMID 41388906: <a href="https://pubmed.ncbi.nlm.nih.gov/41388906/" target="_blank" rel="noopener noreferrer">PubMed</a>. PMCID PMC13314375: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13314375/" target="_blank" rel="noopener noreferrer">PubMed Central – plný otvorený text</a>.</em></p>

<p><em><strong>Autori zdrojového článku:</strong> Li-Yi Ma; Yi-Ran Tu; Ming-Jen Chan; Chan Ip Chan; Jia-Jin Chen; Cheng-Chia Lee; Victor Chien-Chia Wu; Pao-Hsien Chu; Hsiang-Hao Hsu; Chih-Hsiang Chang.</em></p>

<p><em><strong>Financovanie a konflikt záujmov:</strong> Štúdia bola čiastočne podporená výskumným grantom spoločnosti Vantive Healthcare. Chan Ip Chan je zamestnancom Vantive Healthcare; ostatní autori nedeklarovali ďalší konflikt záujmov.</em></p>

<p><em><strong>Doplňujúci bezpečnostný zdroj:</strong> EXTRANEAL (icodextrin 7.5%) – Summary of Product Characteristics. <a href="https://www.medicines.org.uk/emc/product/1819/smpc" target="_blank" rel="noopener noreferrer">Aktuálne odborné informácie o lieku</a>.</em></p>
HTML,
];

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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

        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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
