<?php
/**
 * add_proteinuria-preeklampsia-hypertenzia-ckd-riziko_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_proteinuria-preeklampsia-hypertenzia-ckd-riziko_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Proteinúria pri preeklampsii môže signalizovať vyššie dlhodobé riziko hypertenzie a CKD',
    'slug'         => 'proteinuria-preeklampsia-hypertenzia-ckd-riziko',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dánska populačná kohortová štúdia naznačuje, že stredne ťažká alebo ťažká proteinúria pri preeklampsii pomáha identifikovať ženy s vyšším dlhodobým rizikom hypertenzie a chronickej choroby obličiek. Jasná súvislosť s kardiovaskulárnym rizikom sa nepotvrdila.',
    'content'      => <<<'HTML'
<p>Preeklampsia sa nemá chápať len ako akútna komplikácia gravidity. Čoraz viac údajov ukazuje, že môže byť aj varovným signálom budúceho kardiometabolického a renálneho rizika. Nová dánska populačná kohortová štúdia pridáva dôležitý detail: závažnosť proteinúrie pri preeklampsii môže pomôcť odhadnúť, ktoré ženy majú po pôrode vyššie riziko neskoršej hypertenzie a chronickej choroby obličiek.</p>

<p>Hlavné posolstvo je praktické. Ženy s preeklampsiou a stredne ťažkou alebo ťažkou proteinúriou mali v dlhodobom sledovaní vyššie riziko novovzniknutej hypertenzie a CKD než ženy bez preeklampsie. Naopak, jasná súvislosť medzi mierou proteinúrie a rizikom kardiovaskulárneho ochorenia sa v tejto analýze nepotvrdila.</p>

<h2>Čo skúmala dánska kohorta</h2>

<p>Výskumníci analyzovali údaje z Danish Medical Birth Register. Do populačnej kohortovej štúdie zaradili 286 078 žien vo veku 15 rokov a viac, ktoré mali graviditu trvajúcu aspoň 20 týždňov v rokoch 1998 až 2018. Medián sledovania bol 6,4 roka.</p>

<p>Cieľom bolo zistiť, či miera vylučovania bielkovín močom pri preeklampsii súvisí s dlhodobým rizikom troch výsledkov:</p>

<ul>
  <li>novovzniknutej hypertenzie,</li>
  <li>chronickej choroby obličiek,</li>
  <li>kardiovaskulárneho ochorenia.</li>
</ul>

<p>Ženy s preeklampsiou boli rozdelené podľa najvyššieho zaznamenaného stupňa proteinúrie medzi 20. týždňom gravidity a 6. týždňom po pôrode. Za žiadnu alebo miernu proteinúriu sa považoval pomer albumín/kreatinín v moči pod 30 mg/g alebo negatívny test močovým prúžkom. Za stredne ťažkú alebo ťažkú proteinúriu sa považoval pomer albumín/kreatinín aspoň 30 mg/g alebo pozitívny test močovým prúžkom.</p>

<h2>Preeklampsia nebola zriedkavá, proteinúria bola častá</h2>

<p>Preeklampsia sa v sledovanej populácii vyskytla u 3,3 % gravidných žien. Z nich malo 58,3 % žiadnu alebo miernu proteinúriu a 41,7 % malo stredne ťažkú alebo ťažkú proteinúriu.</p>

<p>Tento údaj je klinicky zaujímavý. Proteinúria pri preeklampsii nie je len diagnostický parameter počas gravidity. Môže niesť informáciu o budúcom riziku, najmä z hľadiska krvného tlaku a obličkových funkcií.</p>

<h2>Riziko hypertenzie bolo výrazne vyššie</h2>

<p>Najvýraznejší signál sa týkal hypertenzie. Ženy s preeklampsiou a stredne ťažkou alebo ťažkou proteinúriou mali odhadované 10-ročné riziko hypertenzie 16,0 %. U žien bez preeklampsie bolo toto riziko 3,6 %.</p>

<p>Rozdiel pretrvával aj pri dlhšom horizonte. Odhadované 15-ročné riziko hypertenzie bolo 22,6 % u žien s preeklampsiou a stredne ťažkou alebo ťažkou proteinúriou, zatiaľ čo u žien bez preeklampsie bolo 7,2 %.</p>

<p>Tieto čísla neznamenajú, že každá žena po preeklampsii bude mať hypertenziu. Znamenajú však, že ide o skupinu, ktorú nemožno po pôrode jednoducho „prepustiť zo sledovania“ bez jasného plánu ďalšej kontroly.</p>

<h2>Vyššie bolo aj riziko chronickej choroby obličiek</h2>

<p>Druhým dôležitým výsledkom bolo riziko CKD. Ženy s preeklampsiou a stredne ťažkou alebo ťažkou proteinúriou mali odhadované 10-ročné riziko CKD 5,1 %. U žien bez preeklampsie bolo toto riziko 0,4 %.</p>

<p>Podobný rozdiel sa pozoroval aj pri 15-ročnom horizonte.</p>

<p>Z nefrologického pohľadu je to dôležité. Preeklampsia je stav spojený s endoteliálnou dysfunkciou, glomerulárnym poškodením a hemodynamickým stresom. U časti žien môže odhaliť predispozíciu k budúcej hypertenzii alebo renálnemu ochoreniu. U iných môže byť samotná graviditná komplikácia súčasťou dlhodobejšej cievnej a obličkovej vulnerability.</p>

<h2>Kardiovaskulárne riziko: signál nebol jasný</h2>

<p>Na rozdiel od hypertenzie a CKD sa v tejto štúdii nepotvrdila jasná súvislosť medzi úrovňou proteinúrie pri preeklampsii a rizikom kardiovaskulárneho ochorenia.</p>

<p>To neznamená, že preeklampsia nie je relevantná pre kardiovaskulárne riziko. Iné údaje podporujú jej význam ako markeru budúceho rizika. Táto konkrétna analýza však neukázala, že samotná miera proteinúrie pri preeklampsii jednoznačne stratifikuje kardiovaskulárne udalosti tak, ako to naznačuje pri hypertenzii a CKD.</p>

<p>Tu treba rozlišovať medzi dvoma vecami: preeklampsia ako rizikový marker celkovo a závažnosť proteinúrie ako samostatný prediktor konkrétnych výsledkov. V tejto práci bola proteinúria najsilnejšie použiteľná najmä pre hypertenziu a CKD.</p>

<h2>Čo z toho vyplýva pre popôrodné sledovanie</h2>

<p>Autori zdôrazňujú potrebu štruktúrovaného sledovania žien po preeklampsii, zvlášť ak mali stredne ťažkú alebo ťažkú proteinúriu. Prakticky by to malo znamenať, že po skončení šestonedelia sa starostlivosť nemá uzavrieť iba konštatovaním, že gravidita sa skončila.</p>

<p>Rozumný popôrodný plán by mal zahŕňať:</p>

<ul>
  <li>kontrolu krvného tlaku,</li>
  <li>vyšetrenie sérového kreatinínu a odhadovanej glomerulárnej filtrácie,</li>
  <li>kontrolu albuminúrie alebo proteinúrie,</li>
  <li>posúdenie ďalších rizikových faktorov, napríklad obezity, diabetu, fajčenia a rodinnej anamnézy,</li>
  <li>jasné odporúčanie, kto a kedy bude pacientku ďalej sledovať.</li>
</ul>

<p>Nie každá žena po preeklampsii potrebuje nefrológa. Ak však pretrváva hypertenzia, albuminúria, proteinúria, znížená eGFR alebo sú prítomné ďalšie rizikové faktory, nefrologické alebo interné sledovanie je opodstatnené.</p>

<h2>Limity štúdie</h2>

<p>Ide o veľkú populačnú štúdiu, čo je jej silná stránka. Zároveň však platia obmedzenia typické pre observačné registre.</p>

<p>Výsledky testovania moču prúžkom neboli v Dánsku vždy konzistentne zaznamenané v laboratórnych databázach. V niektorých pôrodniciach sa používalo iba prúžkové vyšetrenie moču. To môže viesť k nepresnostiam pri klasifikácii proteinúrie.</p>

<p>Ďalším limitom je, že identifikácia CKD bola založená na klinických laboratórnych údajoch. Asymptomatické alebo nediagnostikované prípady chronickej choroby obličiek mohli uniknúť.</p>

<p>Preto treba výsledky chápať ako silný observačný signál, nie ako dôkaz priamej kauzality. Napriek tomu je signál klinicky dostatočne dôležitý na to, aby podporil systematickejší prístup k následnej starostlivosti.</p>

<h2>Praktický klinický záver</h2>

<p>Proteinúria pri preeklampsii nie je len údaj do pôrodníckej dokumentácie. Stredne ťažká alebo ťažká proteinúria môže pomôcť identifikovať ženy s vyšším dlhodobým rizikom hypertenzie a chronickej choroby obličiek.</p>

<p>Najpraktickejší záver je jednoduchý: žena po preeklampsii, najmä ak mala významnejšiu proteinúriu, potrebuje jasný plán popôrodného sledovania krvného tlaku a obličkových parametrov. Nejde o strašenie pacientky, ale o prevenciu a včasný záchyt problémov, ktoré sa dajú lepšie ovplyvniť, keď sa nájdu včas.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Proteinuria in Preeclampsia Tied to Hypertension, CKD Risks</em> (2026). <a href="https://www.medscape.com/viewarticle/proteinuria-preeclampsia-tied-hypertension-ckd-risks-2026a1000hy9" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
