<?php
/**
 * add_zelenina_ckd_article.php
 * Pridanie článku o zelenine vhodnej pri chronickom ochorení obličiek (CKD)
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Zelenina pre lepšie zdravie obličiek (CKD): 5 druhov, ktoré odporúčajú dietológovia',
    'slug'         => 'zelenina-pre-lepsie-zdravie-obliciek-ckd-5-druhov-dietologovia',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Pri chronickom ochorení obličiek (CKD) môže strava bohatá na rastlinné potraviny a antioxidanty podporiť zdravie obličiek. Dietológovia odporúčajú zaradiť najmä červenú repu, brukvovitú zeleninu, červené papriky, cesnak s cibuľou a zelené fazuľové struky.',
    'content'      => <<<'HTML'
<p>Obličky pracujú nepretržite: filtrujú odpadové látky, pomáhajú udržiavať rovnováhu tekutín a elektrolytov a súvisia aj s reguláciou krvného tlaku. Pri chronickom ochorení obličiek (CKD) môže mať výživa veľký vplyv na to, ako sa cítime a ako sa darí chrániť ich funkciu.</p>

<p>Dobrou správou je, že strava bohatá na rastlinné potraviny a antioxidanty môže podporiť zdravie obličiek. Zároveň ale platí, že pri CKD je dôležité všímať si konkrétne nutrienty, najmä sodík, draslík, fosfor a hydratáciu. Presné hodnoty pre vás majú vychádzať z odporúčaní lekára alebo dietológa.</p>

<p>Nižšie je 5 druhov zeleniny, ktoré dietológovia odporúčajú zaradiť častejšie.</p>

<h2>1) Červená repa (beets)</h2>

<p>Červená repa je bohatá na látky, ktoré môžu podporovať zdravie obličiek, najmä v oblasti regulácie krvného tlaku a zápalových procesov. Obsahuje dusičnany, ktoré sa v tele menia na oxid dusnatý. Ten podporuje rozšírenie ciev a môže pomôcť pri nižšom krvnom tlaku.</p>

<p>Repa zároveň obsahuje betalaíny, antioxidanty, ktoré pomáhajú znižovať oxidačný stres a chronický zápal, často spájané s poškodením tkanív a progresiou CKD.</p>

<p><strong>Ako ju zaradiť:</strong> pečená repa do šalátov, do smoothie alebo ako súčasť „grain bowls" (misiek s prílohou).</p>

<h2>2) Brukvovitá zelenina (brokolica, karfiol, kapusta)</h2>

<p>Brukvovitá zelenina (čeľaď Brassicaceae) zahŕňa napríklad brokolicu, karfiol a kapustu. Typické sú pre ňu látky ako glukozinoláty a sulforafán, ktoré môžu podporovať znižovanie zápalu a oxidačného stresu.</p>

<p>V článku sa ako praktická „kľúčová" voľba uvádza najmä karfiol. Dôvodom je, že pri CKD sa často sleduje najmä draslík a karfiol býva voľbou, ktorá môže pomôcť držať draslík v rozumnej miere, pričom stále prináša vlákninu a vitamíny (napríklad vitamín C a folát).</p>

<p><strong>Ako ju zaradiť:</strong> pečený karfiol alebo brokolica, do jedál pridaný karfiol (aj v mrazenej forme), prípadne výmena klasickej prílohy (napr. zemiakov) za karfiolovú alternatívu.</p>

<h2>3) Červené papriky</h2>

<p>Červená paprika je zdrojom vitamínu C a vitamínu A a zároveň má v porovnaní s mnohými inými druhmi zeleniny často relatívne nižší obsah draslíka. Podľa článku je zároveň veľmi nízky aj obsah fosforu.</p>

<p>Okrem toho dodáva antioxidanty, ako je lykopén a beta-karotén. Tie môžu pomáhať znižovať oxidačný stres, ktorý sa spája s progresiou CKD.</p>

<p>Praktická výhoda: dodá jedlu farbu, chuť a chrumkavosť bez toho, aby ste museli siahať po slaných dochucovadlách s vyšším obsahom sodíka.</p>

<p><strong>Ako ju zaradiť:</strong> do šalátov v plátkoch, pečená s ďalšou zeleninou alebo ako súčasť „kidney-friendly" snacku.</p>

<h2>4) Cesnak a cibuľa</h2>

<p>Cesnak a cibuľa sú podľa článku výborné na dochutenie jedál bez toho, aby bolo treba zvyšovať príjem soli. Dôvod je jednoduchý: vysoký príjem sodíka môže zvyšovať krvný tlak a dlhodobo tak zaťažovať aj obličky.</p>

<p>Cesnak aj cibuľa obsahujú organosírové zlúčeniny s protizápalovými a antioxidačnými vlastnosťami. Hodia sa do takmer každodenných jedál ako základ polievok, miešaných jedál (stir-fries), pečených jedál alebo omáčok a marinád.</p>

<h2>5) Zelené fazuľové struky (green beans)</h2>

<p>Zelené fazuľové struky sa spomínajú ako vhodná voľba, pretože bývajú nízke v draslíku a navyše majú aj nižší obsah vody, čo môže byť pre niekoho praktická výhoda pri plánovaní jedál.</p>

<p>Pri CKD je draslík dôležitý sledovať, pretože obličky nemusia zvládať odstraňovať nadbytočný draslík tak efektívne. Preto sa odporúča brať zelené fazuľové struky ako jedlo, ktoré sa dá zaradiť pomerne jednoducho, pričom konkrétne množstvo by malo zodpovedať vašim individuálnym cieľom.</p>

<p><strong>Ako ich pripraviť:</strong> parené ako príloha, pečené s olivovým olejom a cesnakom, alebo pridané do miešaných jedál a šalátov.</p>

<h2>Ďalšie tipy na podporu zdravia obličiek</h2>

<p>Popri samotnej zelenine odporúčajú dietológovia aj tieto praktické kroky:</p>

<ul>
  <li><strong>Strážte sodík:</strong> vysokosodíkové jedlá môžu prispievať k zvýšenému tlaku krvi a dlhodobo tak škodiť obličkám. Ako alternatívu skúste dochutiť bylinkami, koreninami a zeleninou.</li>
  <li><strong>Pite podľa vašich potrieb:</strong> hydratácia pomáha obličkám odstraňovať odpadové látky a podporuje rovnováhu tekutín. Pri CKD však môže byť potrebné prispôsobiť množstvo tekutín štádiu ochorenia.</li>
  <li><strong>Kontrolujte cukor a krvný tlak:</strong> diabetes a hypertenzia patria medzi časté príčiny a rizikové faktory CKD. Pomáhajú vyvážené jedlá, pohyb a dodržiavanie liečebného plánu.</li>
</ul>

<h2>Záver</h2>

<p>Zelenina ako <strong>červená repa</strong>, <strong>brukvovitá zelenina (napr. brokolica a karfiol)</strong>, <strong>červené papriky</strong>, <strong>cesnak a cibuľa</strong> a <strong>zelené fazuľové struky</strong> môže priniesť živiny a antioxidanty, ktoré podporujú zdravý krvný tlak a pomáhajú znižovať oxidačný stres spájaný s progresiou CKD.</p>

<p>Pri pokročilejšom ochorení však treba mať väčší dôraz na <strong>draslík a sodík</strong> (prípadne aj ďalšie faktory) a prispôsobiť konkrétne porcie vašim cieľom.</p>

<hr>

<p><em><strong>Zdroj:</strong> EatingWell – „Vegetables for Better Kidney Health (According to Experts)". <a href="https://www.eatingwell.com/vegetables-for-better-kidney-health-11975337" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<p><em><strong>Upozornenie:</strong> Tento článok bol osobne spracovaný aj s pomocou rozličných nástrojov tzv. umelej inteligencie (AI).</em></p>
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
                error_log('add_zelenina_ckd_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_zelenina_ckd_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: Zelenina pre lepšie zdravie obličiek (CKD)\n";
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
      <title>Migrácia – Zelenina pre zdravie obličiek (CKD)</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Zelenina pre zdravie obličiek (CKD)</h2>

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

          <p style="margin-top:30px;">
            <a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
            &nbsp;
            <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
          </p>

          <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
            Tento súbor môžete po úspešnej migrácii odstrániť alebo ponechať – je idempotentný (vkladá len chýbajúce záznamy).
          </p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
