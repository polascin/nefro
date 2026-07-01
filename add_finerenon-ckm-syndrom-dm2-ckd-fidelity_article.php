<?php
/**
 * add_finerenon-ckm-syndrom-dm2-ckd-fidelity_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): finerenón naprieč štádiami CKM
 * syndrómu u DM2 + CKD — post-hoc analýza FIDELITY. Slovenské spracovanie zdroja
 * (Medscape Medical News / JAMA Cardiology). Pôvodní autori v source_authors.php.
 *
 * Postup:
 *   1. git add + git commit  →  deploy hook nahrá súbor na server
 *   2. Spusti cez SSH:
 *      ssh websupport \
 *        "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_finerenon-ckm-syndrom-dm2-ckd-fidelity_article.php"
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
    'title'        => 'Finerenón naprieč štádiami kardiovaskulárno-obličkovo-metabolického (CKM) syndrómu u pacientov s DM2 a CKD: čo prináša post-hoc analýza FIDELITY',
    'slug'         => 'finerenon-ckm-syndrom-dm2-ckd-fidelity',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Post-hoc združená analýza FIDELITY (12 990 pacientov s DM2 a CKD): finerenón znižoval kardiovaskulárne aj renálne príhody konzistentne naprieč štádiami CKM syndrómu, s priaznivejšou dynamikou CKM (regresia III→II) a porovnateľnou bezpečnosťou vrátane hyperkaliémie.',
    'content'      => <<<'HTML'
<p>Pacienti s diabetes mellitus 2. typu (DM2) a chronickou chorobou obličiek (CKD) tvoria skupinu
s vysokým rizikom kardiovaskulárnych aj renálnych príhod. V praxi je však diagnostika a riziková
stratifikácia často „fragmentovaná": nefrológ rieši obličky, kardiológ srdce a metabolické faktory
idú mimo hlavného rozhodovacieho rámca.</p>

<p>V tomto kontexte dáva zmysel koncept CKM syndrómu (cardiovascular-kidney-metabolic), ktorý spája
obezitu/metabolické riziká, diabetes, CKD a kardiovaskulárne ochorenie do jedného klinického rámca.
Medscape článok sumarizuje výsledky post-hoc analýzy dvoch randomizovaných FIDELITY štúdií, v ktorej
sa hodnotilo, či liečba finerenónom prináša konzistentný prínos naprieč CKM štádiami.</p>

<h2>Dizajn a populácia</h2>
<ul>
  <li>Ide o <strong>post-hoc združenú (pooled) analýzu dvoch fáz 3 randomizovaných, dvojito zaslepených, placebom
      kontrolovaných štúdií FIDELITY</strong>.</li>
  <li>Zaradených bolo <strong>12 990 pacientov</strong> (priemerný vek 64,8 roka; 70 % mužov), so sérovým
      <strong>K+ ≤ 4,8 mmol/l</strong> a liečených <strong>maximálne tolerovanou inhibíciou RAAS</strong>.</li>
  <li>Symptomatické <strong>HFrEF</strong> boli zo štúdií vylúčené.</li>
  <li>Pacienti boli podľa <strong>CKM štádia východiskovo</strong> rozdelení na:
    <ul>
      <li><strong>štádium II</strong>: metabolické rizikové faktory alebo stredné až vysoké riziko CKD (n = 3864)</li>
      <li><strong>štádium III</strong>: veľmi vysoké riziko CKD (n = 3275)</li>
      <li><strong>štádium IV</strong>: klinické kardiovaskulárne ochorenie (n = 5851)</li>
    </ul>
  </li>
  <li>Primárne sledované boli:
    <ul>
      <li><strong>kardiovaskulárny kompozit</strong> (kardiovaskulárna smrť, nefatálny IM, nefatálna CMP,
          hospitalizácia pre zlyhávanie srdca)</li>
      <li><strong>renálny kompozit</strong> (zlyhanie obličiek, pretrvávajúci pokles eGFR o ≥ 57 % oproti
          východisku po ≥ 4 týždňoch alebo smrť z renálneho zlyhania)</li>
    </ul>
  </li>
  <li>Medián sledovania bol <strong>3 roky</strong>.</li>
</ul>

<h2>Kľúčové výsledky</h2>

<h3>1) Vyššie CKM štádium znamená vyššie riziko</h3>
<p>CKM <strong>štádium IV</strong> bolo spojené s vyšším rizikom oproti štádiu II:</p>
<ul>
  <li><strong>kardiovaskulárny kompozit</strong>: aHR <strong>1,87</strong> (95 % IS 1,56–2,24)</li>
  <li><strong>renálny kompozit</strong>: aHR <strong>1,96</strong> (95 % IS 1,43–2,69)</li>
</ul>
<p>To zodpovedá klinickému očakávaniu, ale dôležité je, že rámec CKM štádia sa správa konzistentne aj
v prostredí klinického skúšania.</p>

<h3>2) Finerenón znižoval riziko nezávisle od CKM štádia</h3>
<p>Finerenón znížil:</p>
<ul>
  <li><strong>kardiovaskulárny kompozit</strong> aj pri rôznych CKM štádiách (P pre interakciu <strong>0,86</strong>)</li>
  <li><strong>renálny kompozit</strong> naprieč CKM štádiami (P pre interakciu <strong>0,65</strong>)</li>
</ul>
<p>Čiže prínos bol „robustný" naprieč východiskovým rizikovým profilom podľa CKM.</p>

<h3>3) Okrem prínosu v príhodách: aj priaznivejšia dynamika CKM</h3>
<p>V skupine na finerenóne sa pozorovala priaznivejšia zmena CKM stavu v čase:</p>
<ul>
  <li><strong>CKM regresia zo štádia III do II</strong>: vyššia pravdepodobnosť pri finerenóne
      (odds ratio 1,66; <strong>P &lt; 0,001</strong>)</li>
  <li><strong>CKM progresia</strong>: menej častá, ale štatisticky to vyšlo len na hranici
      (aOR 0,89; <strong>P = 0,05</strong>)</li>
</ul>

<h3>4) Bezpečnosť naprieč CKM štádiami</h3>
<p>Bezpečnostný profil finerenónu bol <strong>podobný naprieč CKM štádiami</strong> a nebol pozorovaný
diferencovaný nárast rizika <strong>hyperkaliémie podľa štádia</strong>.</p>

<h2>Prečo je to zaujímavé pre nefrológiu</h2>
<p>Z nefrologického pohľadu je prakticky dôležité, že tento výsledok podporuje myšlienku, že finerenón
nie je „len renálny" liek alebo „len kardiálny" liek, ale pravdepodobne zasahuje spoločné dráhy, ktoré
vedú k renálnym aj kardiovaskulárnym príhodám. CKM rámec navyše naznačuje, že pacient môže mať komplexné
riziko aj bez toho, aby bolo v klinickej dokumentácii explicitne pomenované ako jedna jednotka.</p>
<p>Napriek tomu treba mať na pamäti, že ide o post-hoc analýzu a nie primárny cieľový ukazovateľ štúdie pre CKM
štádiá.</p>

<h2>Limity a interpretácia opatrne</h2>
<p>Medscape aj pôvodná práca zdôrazňujú obmedzenia:</p>
<ul>
  <li><strong>FIDELITY štúdie neboli pôvodne dizajnované na skúmanie účinkov finerenónu na CKM
      syndróm</strong>, takže niektoré podskupiny majú obmedzené počty a nie všetky potrebné premenné
      boli systematicky zbierané pre úplnú klasifikáciu CKM štádií.</li>
  <li>Post-hoc charakter znižuje istotu kauzality a robí z výsledkov skôr potvrdenie konzistencie než
      „definitívny dôkaz" pre CKM rámec ako liečebný cieľ.</li>
</ul>

<h2>Záver</h2>
<p>V post-hoc združenej analýze FIDELITY finerenón <strong>znižoval kardiovaskulárne aj renálne príhody
konzistentne naprieč CKM štádiami</strong> u pacientov s DM2 a CKD. Štádium IV bolo spojené s vyšším
rizikom, no prínos finerenónu sa ukázal aj u pacientov s vyššou východiskovou záťažou. Navyše sa
pozorovala priaznivejšia dynamika CKM (regresia zo štádia III do II) a bezpečnosť vrátane rizika
hyperkaliémie bola porovnateľná naprieč štádiami.</p>

<hr>

<p><em><strong>Zdroj:</strong> Kevin Bryan Lo, John W. Ostrominski, et al. (FIDELITY post-hoc analýza),
<em>JAMA Cardiology</em> (2026) — spracované v <em>Medscape Medical News</em>: „Finerenone Benefits
Patients With T2D, CKD Across Cardiovascular-Kidney-Metabolic…".
<a href="https://www.medscape.com/viewarticle/finerenone-benefits-patients-t2d-ckd-across-cardiovascular-2026a1000m3s" target="_blank" rel="noopener noreferrer">Medscape</a> ·
<a href="https://pubmed.ncbi.nlm.nih.gov/42234437/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše článok (regenerácia).
// Newsletter avízo LEN pri prvom vložení (rc === 1).
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
                error_log('add_finerenon_ckm newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_finerenon_ckm pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_finerenon_ckm pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_finerenon_ckm migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
