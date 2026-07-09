<?php
/**
 * add_dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: Dialyzačný dysekvilibračný syndróm pri začiatku hemodialýzy
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy_article.php"
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
    'title'        => 'Dialyzačný dysekvilibračný syndróm: poddiagnostikovaná komplikácia začiatku hemodialýzy',
    'slug'         => 'dialyzacny-dysekvilibracny-syndrom-zaciatok-hemodialyzy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prospektívna štúdia v Clinical Kidney Journal naznačuje, že dialyzačný dysekvilibračný syndróm môže byť častejší a že kľúčovým signálom je intradialyzačná hypertenzia.',
    'content'      => <<<'HTML'
<p>Dialyzačný dysekvilibračný syndróm je neurologická komplikácia, ktorá sa môže objaviť počas iniciácie hemodialýzy alebo krátko po nej. Tradične sa vysvetľoval najmä rýchlym poklesom urey v krvi pri pomalšej úprave osmotických pomerov v centrálnom nervovom systéme. Novšia práca publikovaná v <em>Clinical Kidney Journal</em> však naznačuje, že tento pohľad môže byť príliš zjednodušený.</p>

<p>Prospektívna observačná štúdia francúzskych autorov ukázala, že dialyzačný dysekvilibračný syndróm môže byť častejší, než sa v bežnej klinickej praxi predpokladá. Zároveň identifikovala <strong>intradialyzačnú hypertenziu</strong> ako nezávislý rizikový faktor. To je prakticky významné: pri začiatku hemodialyzačnej liečby sa pozornosť často sústreďuje na ureu, ultrafiltráciu a dĺžku prvej dialýzy, zatiaľ čo vývoj krvného tlaku počas výkonu môže zostať v úzadí.</p>

<h2>Čo je dialyzačný dysekvilibračný syndróm</h2>

<p>Dialyzačný dysekvilibračný syndróm, skrátene <strong>DDS</strong>, je súbor neurologických príznakov vznikajúcich v súvislosti s hemodialýzou, najmä pri jej začatí u pacientov s pokročilým zlyhaním obličiek. Klinický obraz môže byť mierny, ale aj závažný.</p>

<p>Medzi typické prejavy patria:</p>

<ul>
  <li>bolesť hlavy,</li>
  <li>nauzea a vracanie,</li>
  <li>nepokoj alebo závrat,</li>
  <li>rozmazané videnie,</li>
  <li>zmätenosť a porucha koncentrácie,</li>
  <li>svalové kŕče,</li>
  <li>porucha vedomia,</li>
  <li>zriedkavo kŕče, edém mozgu alebo herniácia.</li>
</ul>

<p>V praxi sa DDS často nediagnostikuje, najmä ak má mierny priebeh. Príznaky sa môžu pripísať únave po dialýze, uremickému stavu, hypotenzii, hypertenzii, poruche vnútorného prostredia alebo celkovej záťaži pri hospitalizácii. Práve preto je dôležité cielene porovnávať stav pacienta pred dialýzou a po nej.</p>

<h2>Cieľ štúdie</h2>

<p>Autori si položili praktickú otázku: ako často sa DDS vyskytuje u dospelých pacientov začínajúcich hemodialýzu a ktoré faktory sú s jeho vznikom spojené?</p>

<p>Doterajšie údaje u dospelých boli obmedzené. Mnohé odporúčania pre prevenciu DDS sú založené na patofyziologických úvahách, kazuistikách, pediatrických skúsenostiach alebo starších prácach. Prospektívne údaje z reálnej dospelej populácie preto majú osobitnú klinickú hodnotu, hoci pri malej monocentrickej štúdii musia byť interpretované opatrne.</p>

<h2>Dizajn a metodika</h2>

<p>Išlo o <strong>prospektívnu observačnú monocentrickú štúdiu</strong> realizovanú od februára 2021 do februára 2022. Zaradených bolo <strong>48 pacientov</strong>, ktorí začínali hemodialyzačnú liečbu.</p>

<p>DDS sa hodnotil pomocou štandardizovaného skóre závažnosti od 0 do 3 pred a po každej z prvých štyroch hemodialyzačných procedúr. Za DDS autori považovali akékoľvek zvýšenie skóre po dialýze oproti stavu pred dialýzou, teda <strong>Δ skóre ≥ 1</strong>.</p>

<p>Rizikové faktory boli hodnotené univariačnou a multivariačnou logistickou regresiou. Tento prístup umožnil odlíšiť jednoduché asociácie od faktorov, ktoré zostali významné aj po zohľadnení ďalších premenných.</p>

<h2>Výskyt DDS v štúdii</h2>

<p>Zo 48 pacientov bolo <strong>70,8 % mužov</strong> a medián veku bol <strong>67 rokov</strong>. DDS sa vyskytol u <strong>22,9 % pacientov</strong>. Dvaja pacienti mali viac než jednu epizódu.</p>

<p>Tento údaj je klinicky dôležitý. Ak sa DDS systematicky vyhľadáva, nemusí ísť o raritnú komplikáciu. Mierne formy môžu byť pri začiatku dialýzy pomerne časté. Neznamená to, že každý pacient má vysoké riziko ťažkého neurologického poškodenia, ale znamená to, že lekár a dialyzačný tím by mali pri prvých procedúrach cielene sledovať neurologické príznaky.</p>

<h2>Rizikové faktory v univariačnej analýze</h2>

<p>V univariačnej analýze boli s DDS spojené viaceré faktory:</p>

<ul>
  <li>užívanie centrálne pôsobiacich liekov: 45,5 % vs. 8,1 %, P = 0,01,</li>
  <li>prevodnenie: 45,4 % vs. 13,5 %, P = 0,03,</li>
  <li>nižšie predialyzačné pH: 7,28 vs. 7,37, P = 0,04,</li>
  <li>vyšší chlorid: 100 vs. 94 mmol/l, P = 0,01.</li>
</ul>

<p>Tieto výsledky naznačujú, že na vzniku DDS sa môžu podieľať nielen osmotické zmeny spojené s uremickými toxínmi, ale aj stav hydratácie, acidobázická rovnováha, lieky ovplyvňujúce centrálny nervový systém a mechanizmy regulácie intrakraniálneho tlaku.</p>

<h2>Urea nebola prediktorom DDS</h2>

<p>Jedným z najzaujímavejších výsledkov je, že <strong>predialyzačná koncentrácia urey nebola spojená so vznikom DDS</strong>. Hodnota P bola 0,15, teda bez štatistickej významnosti.</p>

<p>Tento nález je dôležitý, pretože klasická koncepcia DDS často stavia ureu do centra patofyziológie. Rýchly pokles urey počas dialýzy môže viesť k osmotickému gradientu medzi krvou a mozgom, s presunom vody do mozgového tkaniva. Táto teória však zrejme nevysvetľuje všetky prípady DDS.</p>

<p>Štúdia preto podporuje širší pohľad: DDS môže byť výsledkom kombinácie osmotických, acidobázických, hemodynamických a neurovaskulárnych mechanizmov.</p>

<h2>Intradialyzačná hypertenzia ako nezávislý rizikový faktor</h2>

<p>V multivariačnej analýze bola ako nezávislý rizikový faktor identifikovaná <strong>intradialyzačná hypertenzia</strong>. Pomer šancí bol OR 4,43, 95 % interval spoľahlivosti 1,38 až 18,15, P = 0,01.</p>

<p>Intradialyzačná hypertenzia sa vyskytla v <strong>78,6 % dialyzačných sedení s DDS</strong> oproti <strong>40,0 % sedení bez DDS</strong>.</p>

<p>Tento výsledok má praktické dôsledky. V bežnej dialyzačnej praxi sa riziko neurologických komplikácií pri začiatku dialýzy často spája hlavne s rýchlou dialyzačnou účinnosťou a vysokou uremickou záťažou. Štúdia však upozorňuje, že vzostup krvného tlaku počas výkonu môže byť významným varovným signálom alebo súčasťou patofyziologického procesu.</p>

<h2>Možný patofyziologický model</h2>

<p>Autori navrhujú, že DDS nemožno chápať iba ako dôsledok solutového gradientu. Výsledky skôr podporujú model, v ktorom majú význam:</p>

<ul>
  <li>acidobázické zmeny,</li>
  <li>intradialyzačná hypertenzia,</li>
  <li>regulácia intrakraniálneho tlaku,</li>
  <li>stav hydratácie,</li>
  <li>citlivosť centrálneho nervového systému,</li>
  <li>možné narušenie hematoencefalickej bariéry pri uremickom prostredí.</li>
</ul>

<p>Nižšie predialyzačné pH u pacientov s DDS je zaujímavé najmä preto, že rýchle korekcie acidózy môžu ovplyvňovať mozgové pH, ventiláciu, cievny tonus a distribúciu vody medzi kompartmentmi. Vyšší chlorid môže byť markerom špecifickej acidobázickej situácie alebo celkového stavu vnútorného prostredia.</p>

<p>Prevodnenie môže prispievať k hypertenzii, poruche autoregulácie a vyššiemu riziku cerebrálneho edému. Centrálne pôsobiace lieky môžu znižovať prah pre neurologické príznaky, zhoršovať vigilitu alebo maskovať skoré prejavy DDS.</p>

<h2>Praktický význam pre začiatok hemodialýzy</h2>

<p>Začiatok hemodialýzy by mal byť u rizikových pacientov opatrný. V praxi sa často používa kratšia prvá dialýza, nižší prietok krvi, miernejší dialyzačný cieľ a postupné zvyšovanie dialyzačnej dávky počas nasledujúcich procedúr.</p>

<p>Na základe tejto štúdie je vhodné venovať zvýšenú pozornosť najmä pacientom s:</p>

<ul>
  <li>výraznou metabolickou acidózou,</li>
  <li>prevodnením,</li>
  <li>nestabilným alebo stúpajúcim krvným tlakom počas dialýzy,</li>
  <li>užívaním centrálne pôsobiacich liekov,</li>
  <li>neurologickými príznakmi už pred dialýzou,</li>
  <li>vyšším vekom a polymorbiditou.</li>
</ul>

<p>Dôležitý je aj systematický neurologický skríning pred prvými dialýzami a po nich. Mierne zhoršenie bolesti hlavy, nauzey, dezorientácie alebo nepokoja môže byť pri retrospektívnom hodnotení ľahko prehliadnuté.</p>

<h2>Čo má sledovať dialyzačný tím</h2>

<p>Pri prvých dialyzačných procedúrach by personál nemal sledovať iba krvný tlak, ultrafiltráciu, prietoky a laboratórne parametre. Potrebné je aktívne sa pýtať na neurologické príznaky a porovnať stav pred dialýzou a po nej.</p>

<p>Prakticky je vhodné dokumentovať:</p>

<ul>
  <li>bolesť hlavy, nauzeu, vracanie a závrat,</li>
  <li>nepokoj, zmeny správania a poruchu koncentrácie,</li>
  <li>zmätenosť, poruchu vedomia alebo kŕče,</li>
  <li>vývoj krvného tlaku počas výkonu,</li>
  <li>zmeny pH, bikarbonátu a osmolality, ak sú dostupné.</li>
</ul>

<p>Pri podozrení na DDS treba znížiť intenzitu dialýzy, podľa závažnosti zvážiť prerušenie procedúry, zabezpečiť neurologické vyšetrenie pri ťažších prejavoch a myslieť aj na diferenciálnu diagnostiku.</p>

<h2>Diferenciálna diagnostika</h2>

<p>DDS je klinická diagnóza, ale nesmie byť stanovená automaticky pri každom neurologickom príznaku počas dialýzy. Diferenciálne treba zvážiť:</p>

<ul>
  <li>hypoglykémiu alebo hyperglykémiu,</li>
  <li>hypertenznú encefalopatiu,</li>
  <li>intrakraniálne krvácanie,</li>
  <li>ischemickú cievnu mozgovú príhodu,</li>
  <li>epileptický záchvat inej etiológie,</li>
  <li>hyponatriémiu alebo iné elektrolytové poruchy,</li>
  <li>sepsu,</li>
  <li>intoxikáciu alebo sedatívny účinok liekov,</li>
  <li>uremickú encefalopatiu,</li>
  <li>syndróm zadnej reverzibilnej encefalopatie.</li>
</ul>

<p>Pri závažných alebo atypických príznakoch je potrebné postupovať urgentne, nie iba predpokladať benígny DDS.</p>

<h2>Limity štúdie</h2>

<p>Štúdia má viacero limitov. Bola monocentrická a zahŕňala iba 48 pacientov, čo obmedzuje štatistickú silu a generalizovateľnosť výsledkov. Definícia DDS bola citlivá, pretože za syndróm sa považovalo akékoľvek zvýšenie skóre o jeden bod. To môže zachytiť aj mierne alebo nešpecifické príznaky.</p>

<p>Na druhej strane práve táto citlivosť môže odhaliť poddiagnostikované prípady, ktoré by v bežnej praxi zostali nepovšimnuté. Výsledky preto treba chápať ako dôležitý signál, nie ako definitívny dôkaz univerzálne platného rizikového modelu.</p>

<p>Autori správne zdôrazňujú potrebu multicentrických štúdií, ktoré by potvrdili zistenia, spresnili rizikové faktory a pomohli optimalizovať protokoly pre bezpečný začiatok hemodialýzy.</p>

<h2>Praktické odporúčanie pre nefrologickú prax</h2>

<p>Najväčší prínos štúdie je v upozornení, že DDS môže byť častejší a komplexnejší, než sa tradične predpokladalo. Pri iniciácii hemodialýzy je rozumné:</p>

<ul>
  <li>nezačať príliš agresívnou dialýzou u rizikového pacienta,</li>
  <li>sledovať nielen ureu, ale aj pH, hydratáciu a krvný tlak,</li>
  <li>venovať pozornosť intradialyzačnej hypertenzii,</li>
  <li>cielene hodnotiť neurologické príznaky pred výkonom a po ňom,</li>
  <li>postupne zvyšovať dialyzačnú dávku,</li>
  <li>individualizovať ultrafiltráciu,</li>
  <li>opatrne hodnotiť pacientov užívajúcich centrálne pôsobiace lieky.</li>
</ul>

<p>Klasická zásada „začať pomaly a bezpečne“ zostáva platná, ale táto štúdia ju dopĺňa o dôležitý dôraz na hemodynamiku a acidobázickú rovnováhu.</p>

<h2>Záver</h2>

<p>Dialyzačný dysekvilibračný syndróm nie je iba historická alebo raritná komplikácia. V prospektívnej monocentrickej štúdii sa vyskytol u takmer štvrtiny pacientov začínajúcich hemodialýzu, prevažne vo forme zachytenej systematickým hodnotením príznakov.</p>

<p>Najvýznamnejším nezávislým rizikovým faktorom bola intradialyzačná hypertenzia. Predialyzačná urea naopak nebola prediktorom DDS. Tieto zistenia podporujú širší patofyziologický model, v ktorom majú význam acidobázické zmeny, hydratácia, krvný tlak a regulácia intrakraniálneho tlaku.</p>

<p>Pre klinickú prax je hlavné posolstvo jednoduché: pri začiatku hemodialýzy treba pacienta sledovať neurologicky, hemodynamicky aj metabolicky. Bezpečný štart dialýzy nie je len otázkou pomalého poklesu urey, ale komplexného manažmentu rizika.</p>

<hr>

<p><em><strong>Zdroj:</strong> Servan-Schreiber T, Lano G, Giot M, Jehel O, Pelletier M, Sallée M, Brunet P, Burtey S, Robert T. Dialysis disequilibrium syndrome: an underdiagnosed condition? Results from a monocentric observational study. <em>Clinical Kidney Journal</em>. 2026;19(7):sfag171. Publikované online 27. mája 2026. DOI: <a href="https://doi.org/10.1093/ckj/sfag171" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag171</a>. PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/42389196/" target="_blank" rel="noopener noreferrer">42389196</a>.</em></p>
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
