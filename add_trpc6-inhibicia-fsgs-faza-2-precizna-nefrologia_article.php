<?php
/**
 * add_trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript na vloženie/regeneráciu článku.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia_article.php"
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
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'TRPC6 inhibícia pri fokálnej segmentálnej glomeruloskleróze (FSGS): čo prináša randomizovaná fáza 2 a prečo je to významný krok k precíznej nefrológii',
    'slug'         => 'trpc6-inhibicia-fsgs-faza-2-precizna-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Randomizovaná fáza 2 s perorálnym inhibítorom TRPC6 (BI 764198) pri FSGS: placebom korigované zníženie proteinúrie v 12. týždni a 100 % odpoveď u pacientov s patogénnymi variantmi TRPC6 – krok k precíznej nefrológii.',
    'content'      => <<<'HTML'
<p>Fokálna segmentálna glomeruloskleróza (FSGS) je histopatologický vzorec poškodenia obličkových glomerulov, no klinicky ide najčastejšie o <strong>primárnu podocytopatiu</strong>. Podocyty sú terminálne diferencované bunky tvoriace filtračnú bariéru, takže ich priame poškodenie vedie k <strong>proteinúrii až nefrotickému syndrómu</strong>. Dôležité je, že poškodenie podocytov má rôzne spúšťače: od imunitne sprostredkovaných mechanizmov cez maladaptívnu hemodynamiku až po genetické príčiny.</p>

<p>Klasifikácia podocytopatií podľa KDIGO umožňuje presnejšie triedenie príčin (primárne, genetické, sekundárne a nejasné), čo otvára cestu k <strong>mechanizmovo cielenej liečbe namiesto necielenej imunosupresie</strong> vo vybraných skupinách pacientov.</p>

<h2>TRPC6: mechanistické prepojenie génu so stresom podocytu</h2>

<p>TRPC6 je iónový kanál z rodiny TRP kanálov, ktorý je <strong>priepustný pre vápnikové ióny (Ca²⁺)</strong>. V podocytoch môže jeho nadmerná aktivita spustiť kaskádu vedúcu k strate integrity filtračnej bariéry. Mechanistický rámec uvedený v texte je nasledovný:</p>

<ol>
  <li>TRPC6 sprostredkuje <strong>zvýšený prísun Ca²⁺ do bunky</strong>,</li>
  <li>aktivuje <strong>kalcineurín/NFAT</strong>,</li>
  <li>podporuje transkripčné programy vrátane mechanizmu s pozitívnou spätnou väzbou (feed-forward) so zvýšenou expresiou TRPC6,</li>
  <li>zasahuje aj do dráh závislých od <strong>RhoA</strong>,</li>
  <li>výsledkom je <strong>zníženie expresie proteínov štrbinovej membrány (slit diaphragm)</strong> – napríklad nefrínu a synaptopodínu – zotretie (effacement) nožičkových výbežkov podocytov a <strong>proteinúria</strong>.</li>
</ol>

<p>Predklinické dáta podporujú kauzalitu: zmena TRPC6 sa spája s FSGS fenotypom, podocytovo špecifická expresia môže navodiť experimentálne ochorenie a naopak, genetická deplécia TRPC6 je v modeloch poškodenia glomerulov protektívna.</p>

<h2>Čo testovala štúdia: fáza 2 s liekom BI 764198 (inhibítor TRPC6)</h2>

<p>Zdrojový materiál rozoberá fázu 2 skúšajúcu <strong>BI 764198</strong> – perorálny <strong>selektívny inhibítor TRPC6 podávaný 1× denne</strong>. Štúdia bola <strong>randomizovaná, placebom kontrolovaná</strong>.</p>

<h3>Dizajn a populácia</h3>

<ul>
  <li><strong>Dávky:</strong> 20 mg, 40 mg, 80 mg oproti placebu.</li>
  <li><strong>Trvanie:</strong> 12 týždňov.</li>
  <li><strong>Populácia:</strong> 62 pacientov s FSGS potvrdenou biopsiou.</li>
  <li><strong>Zahrnutí:</strong> pacienti s <strong>primárnou FSGS</strong> (definovanou nie „klasickým“ imunologickým kontextom KDIGO, ale skôr neprítomnosťou klinických dôkazov sekundárnej príčiny) alebo s <strong>genetickou FSGS</strong> podmienenou patogénnym variantom TRPC6.</li>
  <li><strong>Vylúčení:</strong> pacienti s histologickými alebo klinickými znakmi sekundárnej FSGS, prípadne s monogénnymi príčinami inými než TRPC6.</li>
</ul>

<p>Pacienti boli randomizovaní v pomere <strong>1:1:1:1</strong> do troch aktívnych ramien a placeba.</p>

<h3>Primárny cieľový ukazovateľ</h3>

<p>Primárnym cieľom bol podiel pacientov, ktorí v <strong>12. týždni</strong> dosiahnu <strong>≥ 25 % zníženie pomeru bielkovín ku kreatinínu v moči (UPCR)</strong> oproti východisku.</p>

<h2>Výsledky: signál účinnosti malý v celej kohorte, presvedčivý v genetickej podskupine</h2>

<h3>Odpoveď na liečbu podľa primárneho prahu</h3>

<ul>
  <li>v aktívnych dávkach dohromady dosiahlo odpoveď <strong>35 %</strong> účastníkov,</li>
  <li>v placebe <strong>7 %</strong>.</li>
</ul>

<p>Ide o oddelenie od placeba už na relatívne krátkom horizonte 12 týždňov; v kontexte fázy 2 je to klinicky relevantný signál, hoci nejde o vysokú mieru odpovede v celom súbore.</p>

<h3>Presná odpoveď pri patogénnych variantoch TRPC6</h3>

<p>Podskupinová analýza ukázala, že:</p>

<ul>
  <li>všetci <strong>4</strong> pacienti s patogénnymi variantmi TRPC6 liečení liekom BI 764198 splnili ≥ 25 % pokles UPCR v 12. týždni (<strong>100 %</strong>),</li>
  <li>v placebovom ramene tejto podskupiny nebol nikto s odpoveďou (<strong>0/3</strong>).</li>
</ul>

<p>Štatistická sila tejto časti je pre malý počet obmedzená, no výsledok je mechanisticky veľmi konzistentný s hypotézou <strong>presnej, génom podmienenej terapie</strong>.</p>

<h3>Absolútne zníženie UPCR v 24-hodinovom zbere</h3>

<p>Placebom korigovaná percentuálna zmena UPCR v 12. týždni bola <strong>27 %</strong> pre všetkých pacientov, ktorí dostávali skúšaný liek.</p>

<h3>Dávkovo závislý efekt, ktorý môže naznačovať plató</h3>

<p>Najvýraznejší antiproteinurický efekt sa zaznamenal v skupine <strong>20 mg</strong>:</p>

<ul>
  <li>odpoveď <strong>44 %</strong>,</li>
  <li>približne <strong>40 % zníženie UPCR</strong> oproti placebu.</li>
</ul>

<p>Autori interpretujú možný <strong>nelineárny vzťah dávka – účinnosť</strong> a existenciu efektu „plató“ už pri najnižšej testovanej dávke.</p>

<h3>Bezpečnosť a znášanlivosť</h3>

<p>Liečba bola vo všeobecnosti dobre znášaná:</p>

<ul>
  <li>výskyt nežiaducich udalostí bol <strong>porovnateľný</strong> v aktívnych skupinách aj v placebe,</li>
  <li>najčastejšie hlásené nežiaduce účinky: <strong>bolesť hlavy</strong>, <strong>periférne edémy</strong>, <strong>hypertenzia</strong>,</li>
  <li>prerušenie liečby pre nežiaduce udalosti bolo zriedkavé (len <strong>3</strong> pacienti),</li>
  <li>v jednom prípade išlo o prerušenie pre relaps FSGS, nie pre zjavnú liekovú toxicitu.</li>
</ul>

<h2>Ako to zapadá do kontextu: prečo je štúdia dôležitá aj napriek limitom</h2>

<p>Ide o <strong>prvú randomizovanú kontrolovanú štúdiu</strong> pri FSGS, ktorá testuje liek zacielený na <strong>gén spôsobujúci ochorenie</strong>.</p>

<p>Porovnanie s inými mechanistickými prístupmi je však obmedzené:</p>

<ul>
  <li>štúdia s inaxaplínom bola zameraná na <strong>varianty APOL1</strong>, kde klinický fenotyp často vyžaduje „druhý zásah“ (second hit) a ochorenie nie je obmedzené iba na FSGS,</li>
  <li>pri TRPC6 je genetická príčina fenotypovo užšia a mechanizmus je priamo vo vápnikovom signálnom programe podocytu, čo robí prenos mechanizmu do klinického efektu intuitívnejším.</li>
</ul>

<p>Zároveň treba pripomenúť, že FDA schválila na liečbu FSGS sparsentan (duálny antagonista endotelínového a angiotenzínového receptora), ktorého prínos sa viaže na zníženie proteinúrie. Porovnávať „absolútne čísla“ s inhibíciou TRPC6 je však metodicky problematické, pretože dráhy a mechanizmy sú odlišné.</p>

<h2>Posolstvo pre nefrológov: heterogenita FSGS a budúcnosť precíznej selekcie</h2>

<p>V celom súbore je odpoveď len 35 %, čo môže na prvý pohľad pôsobiť skromne. Materiál však uvádza viacero dôvodov, prečo to nie je „márne“:</p>

<ul>
  <li>ide o 12-týždňovú fázu 2 s konzervatívnym prahom odpovede,</li>
  <li>oddelenie od placeba je výrazné (7 % oproti 35 %) a konzistentné v sekundárnych analýzach,</li>
  <li>bezpečnostný profil je priaznivý,</li>
  <li>geneticky obohatená podskupina (varianty TRPC6) má 100 % odpoveď, čo podporuje koncept presného mechanizmu.</li>
</ul>

<h3>Možná ďalšia cesta: biomarkery profilu aktivácie TRPC6</h3>

<p>Autori upozorňujú, že účinnosť by mohla byť vyššia, ak by sa pacienti vyberali podľa <strong>určitých biomarkerových profilov</strong> – napríklad močových alebo sérologických markerov aktivácie TRPC6. Prebiehajúce práce v spolupráci so sieťou NEPTUNE majú overiť, či takýto biomarkerový profil súvisí s odpoveďou na liečbu.</p>

<h2>Praktické limity: čo ešte nevieme</h2>

<p>Výstup je silný v mechanizmovej interpretácii, ale stále limitovaný:</p>

<ul>
  <li>malý počet účastníkov a podskupín,</li>
  <li>krátke sledovanie (12 týždňov), takže nevieme, ako sa to premieta do dlhodobého renálneho prežívania,</li>
  <li>nejasná hranica, kto z pacientov bez variantov TRPC6 bude mať klinicky významnú odpoveď (hoci aj v populácii „bez variantu“ sa zníženie proteinúrie pozorovalo).</li>
</ul>

<h2>Záver</h2>

<p>FSGS je ochorenie s rôznymi príčinami, ale spoločným dôsledkom je dysfunkcia podocytovej filtračnej bariéry. Mechanistická racionalita a výsledky fázy 2 s <strong>BI 764198</strong> ukazujú:</p>

<ul>
  <li><strong>placebom korigovaný signál</strong> zníženia proteinúrie v 12. týždni,</li>
  <li><strong>výrazne lepšiu odpoveď</strong> u pacientov s <strong>patogénnymi variantmi TRPC6</strong> (4/4),</li>
  <li>celkovo priaznivú znášanlivosť.</li>
</ul>

<p>Pre klinickú prax to znamená, že presnejšie triedenie pacientov (geneticky a potenciálne aj biomarkerom) môže časom posunúť inhibíciu TRPC6 zo „zaujímavého signálu“ na režim cielenej liečby. Výsledky programov fázy 3 a validácia biomarkerových profilov budú rozhodujúce, aby sa tento mechanizmový prístup stal praktickým nástrojom nefrológa.</p>

<hr>

<p><em><strong>Zdroj:</strong> American Journal of Kidney Diseases (AJKD), 2026 (plný text). <a href="https://www.ajkd.org/article/S0272-6386(26)00922-4/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
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
