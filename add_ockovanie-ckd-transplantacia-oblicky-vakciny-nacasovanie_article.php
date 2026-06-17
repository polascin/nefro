<?php
/**
 * add_ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie_article.php"
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
    'title'        => 'Očkovanie pri chronickom ochorení obličiek (CKD) a po transplantácii obličky: praktický prehľad vakcín a načasovania',
    'slug'         => 'ockovanie-ckd-transplantacia-oblicky-vakciny-nacasovanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pacienti s CKD a najmä po transplantácii obličky majú vyššie riziko závažných infekcií. Praktický prehľad indikácií, načasovania a typu vakcín podľa prehľadu AJKD — vrátane ambulantnej pomôcky s tabuľkami pre CKD aj transplantovaných pacientov.',
    'content'      => <<<'HTML'
<p>Pacienti s chronickým ochorením obličiek a najmä po transplantácii obličky majú vyššie riziko závažných infekcií. Dôvodom je kombinácia zhoršenej imunitnej odpovede pri CKD a imunosupresie po transplantácii, plus časté zdravotnícke kontakty (dialýza, ambulantné sledovanie). Očkovanie preto patrí medzi základné preventívne kroky.</p>

<p>Nižšie sumarizujem odporúčania uvedené v prehľade „Vaccinations to Prevent Infections in Adult Individuals With CKD and After Kidney Transplantation“ so zameraním na indikácie, načasovanie a typ vakcíny.</p>

<h2>Kľúčové princípy pri CKD a po transplantácii</h2>

<p>V prehľade sa opakovane zdôrazňuje, že:</p>

<ul>
  <li>očkovanie sa má realizovať podľa rizika (CKD štádium, vek, dialýza, typ imunitnej supresie),</li>
  <li>po transplantácii treba načasovať očkovanie tak, aby pacient dostal vakcínu vo vhodnom intervale po zákroku,</li>
  <li>pri transplantovaných pacientoch treba brať do úvahy špecifiká imunitnej odpovede a typ vakcíny (napr. pri chrípke sa uvádza zákaz živých vakcín).</li>
</ul>

<h2>Prehľad vakcín podľa infekcie</h2>

<h3>Influenza (chrípka)</h3>

<ul>
  <li><strong>Indikácia pre CKD aj transplant:</strong> pre všetkých pacientov <strong>každoročne</strong>.</li>
  <li><strong>Po transplantácii:</strong> začať <strong>4 týždne po transplantácii</strong>, pričom sa uvádza <em>„no live vaccine“</em> (t. j. nepoužívať živé vakcíny).</li>
  <li><strong>Veková prax v texte pre transplant:</strong>
    <ul>
      <li><strong>vek &lt; 60 rokov:</strong> štandardná jednorazová očkovacia schéma,</li>
      <li><strong>vek ≥ 60 rokov:</strong> <em>high-dose</em> (jednorazová schéma).</li>
    </ul>
  </li>
</ul>

<h3>Pneumokok (Pneumococcus)</h3>

<ul>
  <li><strong>Indikácia pre CKD:</strong> všetci pacienti <strong>vo veku ≥ 19 rokov</strong>.</li>
  <li><strong>Po transplantácii:</strong> začať <strong>6 mesiacov po transplantácii</strong>.</li>
  <li><strong>Schéma podľa predchádzajúceho očkovania (podľa textu):</strong>
    <ul>
      <li>ak pacient <strong>ešte nebol očkovaný:</strong> <strong>1× PCV</strong>,</li>
      <li>ak pacient <strong>už dostal PPSV23:</strong> <strong>1× PCV booster</strong> <strong>&gt; 1 rok po PPSV23</strong>.</li>
    </ul>
  </li>
</ul>

<h3>RSV (respiračný syncyciálny vírus)</h3>

<ul>
  <li><strong>CKD:</strong> všetci vo veku <strong>≥ 75 rokov</strong>, pri ktorých ide o <strong>CKD 3+</strong>.</li>
  <li><strong>Dialýza:</strong> všetci vo veku <strong>≥ 60 rokov</strong>.</li>
  <li><strong>Po transplantácii:</strong> všetci vo veku <strong>≥ 60 rokov</strong>, začať <strong>6 mesiacov po transplantácii</strong>.</li>
  <li><strong>V texte uvedené:</strong> <strong>jedna dávka</strong> a bez preferencie typu vakcíny.</li>
</ul>

<h3>SARS-CoV-2 (COVID-19)</h3>

<ul>
  <li><strong>CKD:</strong> pre všetkých pacientov <strong>každoročné revakcinácie</strong>.</li>
  <li><strong>Po transplantácii:</strong> rovnako <strong>každoročná revakcinácia</strong>, pri úvahe sa spomína <strong>interval 6 mesiacov</strong>.</li>
  <li><strong>Typ:</strong> <strong>jednodávková mRNA vakcína</strong> s <strong>aktuálnym variantom vírusu</strong> (<em>most recent virus variant</em>).</li>
</ul>

<h3>Hepatitída B</h3>

<ul>
  <li><strong>CKD:</strong> všetci pacienti so <strong>CKD 3b–5</strong>.</li>
  <li><strong>Po transplantácii:</strong> v prehľade sa pri špecifikách uvádza <em>„No specific recommendation“</em>.</li>
  <li><strong>Schéma pri CKD (a z kontextu aj princíp prípravy):</strong>
    <ul>
      <li><strong>3 až 4 injekcie</strong> buď bežnej, alebo <strong>dvojitej dávky</strong> (podľa labelu príslušného prípravku),</li>
      <li><strong>sérologické monitorovanie</strong> a následné <strong>preočkovanie (booster)</strong> ako stratégia.</li>
    </ul>
  </li>
</ul>

<h3>Herpes zoster (pásový opar)</h3>

<ul>
  <li><strong>CKD populácia podľa veku v prehľade:</strong>
    <ul>
      <li><strong>ACIP:</strong> od <strong>≥ 50 rokov</strong>,</li>
      <li><strong>RKI:</strong> od <strong>60 rokov</strong>,</li>
      <li><strong>NHS:</strong> od <strong>65 rokov</strong>.</li>
    </ul>
  </li>
  <li><strong>Pri imunokompromitovaných:</strong> pacienti <strong>≥ 19 rokov</strong> s <strong>terapeutickou imunosupresiou</strong>.</li>
  <li><strong>Po transplantácii:</strong> v prehľade je uvedené, že očkovanie sa týka <strong>všetkých vo veku ≥ 19 rokov</strong> (s výnimkou režimu RKI, kde je hranica <strong>≥ 50 rokov</strong>).</li>
  <li><strong>Schéma:</strong> <strong>2 dávky rekombinantnej vakcíny</strong> podané <strong>2 až 6 mesiacov</strong> od seba.</li>
</ul>

<h3>Meningokok</h3>

<ul>
  <li><strong>CKD:</strong> len pri <strong>špecifických rizikách</strong>, napr.:
    <ul>
      <li>asplénia,</li>
      <li>inhibícia komplementu,</li>
      <li>cestovanie do endemických oblastí.</li>
    </ul>
  </li>
  <li><strong>Po transplantácii:</strong> rovnaký princíp špecifického rizika.</li>
  <li><strong>Typ vakcíny v texte:</strong> <strong>MenB alebo MenACWY</strong> podľa epidemiologickej situácie.</li>
  <li><strong>V texte uvedené:</strong> <strong>jedna dávka</strong>, a treba <strong>vyhodnotiť potrebu dodatočnej antibiotickej profylaxie</strong>.</li>
</ul>

<h3>HPV (ľudský papilomavírus)</h3>

<ul>
  <li><strong>CKD:</strong> v texte je uvedené pre <strong>deti 9–14 rokov</strong>, „catch-up“ až do <strong>26 rokov</strong>.</li>
  <li><strong>Schéma:</strong> rozšírená očkovacia schéma = <strong>3 injekcie</strong> v mesiacoch <strong>0, 2, 6</strong>.</li>
</ul>

<h3>Tetanus, diftéria, pertusis (Tdap/Td)</h3>

<ul>
  <li><strong>Indikácia:</strong> všetci pacienti <strong>každých 5 až 10 rokov</strong> (rovnako uvedené pre CKD aj po transplantácii).</li>
  <li><strong>V texte:</strong> <strong>jednorazová kombinovaná vakcína</strong>.</li>
</ul>

<h2>Praktické zhrnutie pre nefrologickú ambulanciu</h2>

<p>Najväčšia hodnota tohto prehľadu pre prax je v tom, že dáva jasnú „kalendárovú“ predstavu pre dospelých s CKD a pre načasovanie po transplantácii: chrípka po transplantácii od 4 týždňov, pneumokok od 6 mesiacov, RSV od 6 mesiacov, a pri vybraných vakcínach schémy dávok s explicitnými časovými intervalmi.</p>

<hr>

<h2>Ambulantná pomôcka: očkovanie dospelých s CKD a po transplantácii</h2>

<p><em>Použite ako rýchly „check“ v ambulancii. Pri konkrétnom produkte, dávke a dostupnosti vždy dolaďte podľa miestnych/produktových odporúčaní.</em></p>

<h3>1) Dospelý s CKD (chronické ochorenie obličiek)</h3>

<table>
  <thead>
    <tr>
      <th>Infekcia</th>
      <th>Kedy je indikované</th>
      <th>Schéma podľa prehľadu</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Influenza</strong></td>
      <td><strong>všetci</strong>, <strong>každoročne</strong></td>
      <td><strong>1× ročne</strong></td>
    </tr>
    <tr>
      <td><strong>Pneumokok</strong></td>
      <td><strong>vek ≥ 19 rokov</strong></td>
      <td>podľa predchádzajúceho očkovania: buď <strong>1× PCV</strong> (ak nikdy), alebo <strong>1× PCV booster &gt; 1 rok po PPSV23</strong></td>
    </tr>
    <tr>
      <td><strong>RSV</strong></td>
      <td><strong>vek ≥ 75 rokov</strong>, pri <strong>CKD 3+</strong></td>
      <td><strong>1 dávka</strong></td>
    </tr>
    <tr>
      <td><strong>SARS-CoV-2 (COVID-19)</strong></td>
      <td><strong>všetci</strong>, <strong>každoročne</strong></td>
      <td><strong>1× ročne</strong>, podľa aktuálneho variantu</td>
    </tr>
    <tr>
      <td><strong>Hepatitída B</strong></td>
      <td><strong>CKD 3b–5</strong></td>
      <td><strong>3–4 injekcie</strong> (bežná alebo dvojitá dávka podľa konkrétnej vakcíny), so <strong>sérologickým monitorovaním a boosterom</strong></td>
    </tr>
    <tr>
      <td><strong>Herpes zoster (pásový opar)</strong></td>
      <td>vekové hranice podľa jurisdikcie v prehľade (ACIP ≥ 50, RKI ≥ 60, NHS ≥ 65)</td>
      <td><strong>2× rekombinantná vakcína</strong>, <strong>2–6 mesiacov</strong> od seba</td>
    </tr>
    <tr>
      <td><strong>Meningokok</strong></td>
      <td>len <strong>pri špecifických rizikách</strong> (napr. asplénia, inhibícia komplementu, cestovanie)</td>
      <td><strong>podľa rizika</strong>; v prehľade <strong>MenB alebo MenACWY</strong>, hodnotiť aj potrebu antibiotickej profylaxie</td>
    </tr>
    <tr>
      <td><strong>HPV</strong></td>
      <td>v prehľade <strong>9–14 rokov</strong> a catch-up do <strong>26 rokov</strong></td>
      <td><strong>3 injekcie</strong> (mesiace <strong>0, 2, 6</strong>)</td>
    </tr>
    <tr>
      <td><strong>Tetanus/diftéria/pertusis (Tdap/Td)</strong></td>
      <td><strong>všetci</strong>, každých <strong>5–10 rokov</strong></td>
      <td><strong>1×</strong> kombinovaná vakcína</td>
    </tr>
  </tbody>
</table>

<h3>2) Pacient po transplantácii obličky</h3>

<table>
  <thead>
    <tr>
      <th>Infekcia</th>
      <th>Kedy začať po transplantácii</th>
      <th>Schéma podľa prehľadu</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Influenza</strong></td>
      <td><strong>od 4 týždňov</strong></td>
      <td><strong>každoročne</strong>; <strong>nie živá vakcína</strong>; vek &lt; 60 štandardná, vek ≥ 60 <strong>high-dose</strong></td>
    </tr>
    <tr>
      <td><strong>Pneumokok</strong></td>
      <td><strong>od 6 mesiacov</strong></td>
      <td>podľa histórie: <strong>1× PCV</strong> ak nikdy, alebo <strong>1× PCV booster &gt; 1 rok po PPSV23</strong></td>
    </tr>
    <tr>
      <td><strong>RSV</strong></td>
      <td><strong>od 6 mesiacov</strong>; vek ≥ 60</td>
      <td><strong>1 dávka</strong> (typ vakcíny v prehľade bez preferencie)</td>
    </tr>
    <tr>
      <td><strong>SARS-CoV-2</strong></td>
      <td>v prehľade ako každoročné revakcinovanie</td>
      <td><strong>1× ročne</strong>, <strong>mRNA</strong>, <em>most recent virus variant</em>; pri úvahe sa spomína interval <strong>~6 mesiacov</strong></td>
    </tr>
    <tr>
      <td><strong>Hepatitída B</strong></td>
      <td>pre transplantáty: v prehľade <strong>bez špecifického odporúčania</strong></td>
      <td>sledujte podľa predošlej imunity a lokálnych protokolov</td>
    </tr>
    <tr>
      <td><strong>Herpes zoster</strong></td>
      <td>očkuje sa v prehľade plošne podľa veku</td>
      <td><strong>všetci ≥ 19 rokov</strong> (okrem výnimky pri RKI v prehľade); <strong>2 dávky</strong> s intervalom <strong>2–6 mesiacov</strong></td>
    </tr>
    <tr>
      <td><strong>Meningokok</strong></td>
      <td>len pri špecifických rizikách</td>
      <td><strong>MenB alebo MenACWY</strong> podľa situácie; zhodnotiť antibiotickú profylaxiu</td>
    </tr>
    <tr>
      <td><strong>Tdap/Td</strong></td>
      <td>bez špecifického odkladu v prehľade</td>
      <td><strong>1×</strong> každých <strong>5–10 rokov</strong></td>
    </tr>
  </tbody>
</table>

<h3>Rýchly „workflow“ v ambulancii (1 minúta)</h3>

<ol>
  <li><strong>Zistiť diagnózu a režim:</strong> CKD (štádium) alebo transplantácia (imunosupresia).</li>
  <li><strong>Vybrať skupinu:</strong> CKD tabuľka alebo transplant tabuľka.</li>
  <li><strong>Skontrolovať históriu očkovania</strong> (najmä pneumokok, hepatitída B, zoster).</li>
  <li><strong>Doplniť, čo chýba</strong> podľa časových odkladov po transplantácii (najmä chrípka 4 týždne, pneumokok/RSV 6 mesiacov).</li>
</ol>

<hr>

<p><em><strong>Zdroj:</strong> American Journal of Kidney Diseases (AJKD): „Vaccinations to Prevent Infections in Adult Individuals With CKD and After Kidney Transplantation: A Review“. <a href="https://www.ajkd.org/article/S0272-6386(26)00709-2/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
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
