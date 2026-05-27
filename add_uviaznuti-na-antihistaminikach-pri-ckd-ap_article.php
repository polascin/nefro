<?php
/**
 * add_uviaznuti-na-antihistaminikach-pri-ckd-ap_article.php
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

$articles = [];

$articles[] = [
    'title'        => 'Uviaznutí na antihistaminikách pri CKD-aP? Čas na prehodnotenie',
    'slug'         => 'uviaznuti-na-antihistaminikach-pri-ckd-ap-cas-na-prehodnotenie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-05-27',
    'is_top'       => 0,
    'excerpt'      => 'Antihistaminiká pri CKD-aP (svrbenie pri chronickom obličkovom ochorení) zvyčajne nepomáhajú, lebo signál svrbenia ide cez nehistamínové dráhy. Čo dnes vieme o mechanizmoch a ako difelikefalin mení prax pri liečbe svrbenia u hemodialyzovaných pacientov.',
    'content'      => <<<'HTML'
<p>Chronické svrbenie u pacientov s chronickým obličkovým ochorením (CKD) alebo u dialyzovaných je príliš často prehliadané. A keď sa už zistí, stále sa neraz siahne po antihistaminikách ako po „prvom riešení". V praxi však môže ísť o úplne iný mechanizmus svrbenia, takže aj dobrý úmysel skončí bez účinku.</p>

<p>V tomto článku vychádzam zo vzdelávacej aktivity zameranej na CKD-aP (CKD-associated pruritus, svrbenie pri CKD) a na to, prečo antihistaminiká často netrafia podstatu problému.</p>

<h2>Prípad z praxe: silné svrbenie, ktoré nikto „nechytil" včas</h2>

<p>V dialyzačnej jednotke bol identifikovaný 62-ročný muž s polycystickým ochorením obličiek na hemodialýze približne 1 rok. Svrbenie bolo závažné a trvalo minimálne 3 mesiace, pričom pacient o ňom nikdy nehovoril ani zdravotníkom na vizitách.</p>

<p>Pri vyšetrení boli kožné lézie zjavne druhotné, typicky z následkov škrabania (excoriácie, prurigo lézie). Po vylúčení iných príčin chronického pruritu sa potvrdilo CKD-aP. Pacient dosiahol WI-NRS 7/10 a svrbenie výrazne znižovalo kvalitu života, sprevádzal ho aj spánkový deficit, úzkosť a výrazná spoločenská izolácia. Antihistaminiká boli predtým nasadené, ale bez efektu.</p>

<p>Tento prípad dobre ilustruje dve veci: CKD-aP môže byť „neviditeľné", ak sa aktívne nepýta, a antihistaminiká nemusia zasiahnuť správnu dráhu svrbenia.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Prečo antihistaminiká pri CKD-aP zvyčajne nepomáhajú</h2>

<p>Kľúčové posolstvo je, že svrbenie pri CKD-aP nie je primárne histamínom sprostredkované. Svrbiaci signál ide skôr cez nehistamínové nervové dráhy. Preto antihistaminiká síce môžu u niektorých pacientov navodiť sedáciu, ale „nezasiahnu jadro" patofyziológie CKD-aP.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<p>Ďalší praktický detail: väčšina pacientov má generalizované svrbenie, nie lokálny problém. To znižuje pravdepodobnosť, že by pomohli len lokálne opatrenia, a ešte viac to zvyšuje potrebu cielenejšej liečby.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Čo dnes vieme o mechanizmoch CKD-aP</h2>

<p>Za posledné roky sa lepšie pochopila patogenéza. V aktivite sa zdôrazňuje:</p>

<ul>
  <li><strong>ne-histamínová neuro-drátová signalizácia</strong> pri CKD-aP,</li>
  <li>zapojenie <strong>interleukínov</strong>, najmä <strong>IL-31</strong>,</li>
  <li><strong>nerovnováha medzi mu a kappa opioidnými receptormi</strong>, kde prevláda mu-sprostredkovaná pro-svrbivá signalizácia.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<p>Táto zmena paradigmy otvorila priestor pre liečby, ktoré nie sú „len antihistamínový zvyk", ale cielene zasahujú príslušné dráhy.</p>

<h2>Základ, ktorý treba zvládnuť každopádne</h2>

<p>Aj pri cielenej liečbe platí, že „univerzálne" opatrenia sa nepodceňujú. V aktivite zaznelo:</p>

<ol>
  <li><strong>denné používanie emoliencií a zvlhčovanie kože</strong> (moisturizers),</li>
  <li><strong>adekvátna dialýza</strong>, s cieľom <strong>single-pool Kt/V 1,4</strong> u hemodialyzovaných.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ol>

<p>Tieto kroky nevyriešia všetko, ale znižujú premenlivé faktory, ktoré môžu svrbenie zhoršovať.</p>

<h2>Difelikefalin: presun od symptomatických „skúšok" k cielenej terapii</h2>

<p>V rozhovore sa difelikefalin (DFK) predstavuje ako liečba s odporúčaním v európskych smerniciach pre chronický pruritus a ako „štandard of care" pri CKD-aP u hemodialyzovaných. Hlavný dôvod je, že cieli <strong>kappa-opioidné receptory</strong> a obnovuje rovnováhu voči mu-receptorom.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h3>Mechanizmus účinku v skratke</h3>

<ul>
  <li>DFK je <strong>selektívny agonista kappa-opioidných receptorov</strong> na senzorických neurónoch aj v imunitnom systéme.</li>
  <li>Má pôsobenie <strong>periférne</strong>, bez typických centrálnych opioidných problémov.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<h3>Klinický dôkaz: KALM-1 a KALM-2</h3>

<p>V aktivite sa uvádza, že fáza 3 (KALM-1 a KALM-2) bola konzistentná. Spolu bolo hodnotených <strong>851 účastníkov</strong> s miernym až závažným CKD-aP. V zovretom výsledku dosiahlo <strong>aspoň 3-bodové zníženie WI-NRS</strong>:</p>

<ul>
  <li><strong>51 %</strong> u pacientov liečených DFK</li>
  <li>vs. <strong>35 %</strong> v skupine placeba.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ul>

<p>Pozitívny trend sa neobmedzil len na intenzitu svrbenia, ale zahŕňal aj zlepšenie spánku a kvality života v škálach (napr. 5-D Itch a Skindex-10). Výsledky sa oddeľovali <strong>už v 1. týždni</strong>.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h3>Objav: aj biologická stopa zápalu</h3>

<p>Zaujímavý je aj doplnkový pohľad na zápalové markery. V aktivite sa spomína analýza 20 cirkulujúcich zápalových markerov, kde sa pri reagujúcich pacientoch po 12 týždňoch liečby pozorovalo <strong>pokles biomarkerov</strong> (najmä IL-31, CCL2, CXCL10, TSLP a nerve growth factor), zatiaľ čo u nereagujúcich alebo v placebovej skupine nie. To podporuje hypotézu, že DFK zasahuje nielen senzorickú dráhu svrbenia, ale aj neuroimunitné mechanizmy.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h3>Bezpečnosť a obava z opioidov</h3>

<p>V diskusii sa explicitne rieši obava z „opioidov" v kontexte závislosti. V aktivite zaznelo, že kappa-opioidy <strong>nie sú návykové</strong> (neaktivujú „reward" mechanizmus) a majú dobrý bezpečnostný profil, pričom nečakáte typické centrálne opioidné nežiadúce účinky.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></p>

<h2>Praktický záver: pravidelne sa pýtaj, meraj a lieč cielene</h2>

<p>Dva praktické take-home message, ktoré v aktivite zazneli:</p>

<ol>
  <li><strong>CKD-aP treba aktívne vyhľadávať</strong>: podstatné je pýtať sa na svrbenie v pravidelných intervaloch (v dialýze typicky každé 3 mesiace), <strong>merať závažnosť</strong> a následne liečiť.</li>
  <li>Ak má pacient CKD-aP, <strong>antihistaminiká často nemajú racionálne miesto ako prvá línia</strong>, lebo nezasahujú hlavnú cestu svrbenia. Dôležitý je prechod na liečby, ktoré sú cielené na patofyziológiu.<sup><a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">[1]</a></sup></li>
</ol>

<hr>

<p><em><strong>Zdroj:</strong> Medtelligence CE na ReachMD, „Stuck on Antihistamines for Managing Patients With CKD-aP? Time to Reconsider!" (transkript aktivity). <a href="https://reachmd.com/programs/cme/stuck-on-antihistamines-for-managing-patients-with-ckd-ap-time-to-reconsider/37607/transcript/83434/" target="_blank" rel="noopener noreferrer">Zdroj aktivity</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
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
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
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

          <p style="margin-top:30px;">
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
