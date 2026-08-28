<?php
/**
 * add_tirzepatid-diabeticka-retinopatia-surpass-cvot_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_tirzepatid-diabeticka-retinopatia-surpass-cvot_article.php"
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
    'title'        => 'Tirzepatid nezvýšil riziko diabetickej retinopatie u rizikových pacientov',
    'slug'         => 'tirzepatid-diabeticka-retinopatia-surpass-cvot',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Retina substúdia SURPASS-CVOT ukázala, že tirzepatid nebol spojený so zvýšeným rizikom vzniku ani progresie diabetickej retinopatie u vysokorizikových pacientov s diabetom 2. typu — napriek výraznejšiemu poklesu HbA1c oproti dulaglutidu.',
    'content'      => <<<'HTML'
<p>Tirzepatid, známy aj pod obchodným názvom Mounjaro, nebol v retina substúdii SURPASS-CVOT spojený so zvýšeným rizikom vzniku alebo progresie diabetickej retinopatie u vysokorizikových pacientov s diabetom 2. typu. Výsledky boli prezentované na kongrese American Diabetes Association 2026 Scientific Sessions.</p>

<p>Tento výsledok je klinicky dôležitý, pretože tirzepatid dokáže viesť k výraznému a pomerne rýchlemu poklesu HbA1c. Práve rýchle zlepšenie glykemickej kontroly bolo v minulosti v niektorých štúdiách spojené s prechodným zhoršením diabetickej retinopatie. Pri tirzepatide sa preto prirodzene objavila otázka, či intenzívna metabolická účinnosť nemôže mať nepriaznivý dopad na sietnicu.</p>

<p>Podľa dostupných údajov zo substúdie sa takéto zvýšené riziko nepotvrdilo.</p>

<h2>Prečo bola táto otázka dôležitá</h2>

<p>Diabetická retinopatia je dôsledkom chronickej hyperglykémie a patrí medzi najzávažnejšie mikrovaskulárne komplikácie diabetu. Dlhodobé zlepšenie glykemickej kontroly riziko retinopatie znižuje. Zároveň však platí, že pri rýchlej korekcii výraznej hyperglykémie sa môže u niektorých pacientov objaviť prechodné zhoršenie retinopatie.</p>

<p>Tento jav bol opísaný najmä pri intenzifikácii liečby inzulínom a v niektorých predchádzajúcich štúdiách s modernými antidiabetikami. Mechanizmus nie je úplne jednoduchý, ale klinický odkaz je praktický: pri výraznom zlepšovaní glykemickej kontroly treba dbať aj na očné sledovanie, najmä u pacientov s už prítomnou retinopatiou.</p>

<p>Tirzepatid je veľmi účinný liek. Kombinuje účinok na receptory GIP a GLP-1 a často vedie k výraznému poklesu HbA1c aj telesnej hmotnosti. Preto bolo potrebné overiť, či jeho metabolický efekt nie je sprevádzaný zvýšeným rizikom progresie retinopatie.</p>

<h2>Ako bola substúdia navrhnutá</h2>

<p>Retina substúdia bola súčasťou veľkej štúdie SURPASS-CVOT. Do nej boli zaradení pacienti s diabetom 2. typu a kardiovaskulárnym ochorením. Keďže išlo o vysokorizikových pacientov, ako porovnávacia liečba bol použitý dulaglutid, nie placebo.</p>

<p>Do retina substúdie bolo zahrnutých 920 pacientov z celkového počtu 13 165 účastníkov štúdie. Zaradení boli pacienti, ktorí mali na začiatku diabetickú retinopatiu alebo makulárny edém aspoň na jednom oku, prípadne boli považovaní za vysokorizikových na základe trvania diabetu 2. typu 15 rokov alebo viac a vstupného HbA1c aspoň 8,0 %.</p>

<p>Z nich 449 pacientov dostávalo tirzepatid v dávke až 15 mg týždenne a 471 pacientov dostávalo dulaglutid v dávke 1,5 mg týždenne. Stav sietnice sa hodnotil štandardizovanými fundus fotografiami na začiatku a následne po 12, 18, 24 a 36 mesiacoch.</p>

<h2>Tirzepatid znížil HbA1c výraznejšie</h2>

<p>Vstupná hodnota HbA1c bola v oboch skupinách rovnaká, 8,69 %. Po šiestich mesiacoch bol pokles HbA1c výraznejší pri tirzepatide než pri dulaglutide.</p>

<p>Pokles bol:</p>

<ul>
  <li>2,18 percentuálneho bodu pri tirzepatide,</li>
  <li>1,28 percentuálneho bodu pri dulaglutide.</li>
</ul>

<p>Rozdiel bol štatisticky významný. To potvrdzuje, že tirzepatid priniesol intenzívnejšie zlepšenie glykemickej kontroly. Dôležité však je, že toto výraznejšie zníženie HbA1c nebolo sprevádzané zhoršením retinálneho nálezu v porovnaní s dulaglutidom.</p>

<h2>Progresia retinopatie sa nezvýšila</h2>

<p>Hlavným sledovaným ukazovateľom bolo zhoršenie o dva alebo viac stupňov podľa škály Early Treatment Diabetic Retinopathy Study, známej ako ETDRS, po 36 mesiacoch.</p>

<p>Výsledky boli veľmi podobné:</p>

<ul>
  <li>21,3 % pacientov v skupine s tirzepatidom,</li>
  <li>23,3 % pacientov v skupine s dulaglutidom.</li>
</ul>

<p>Odds ratio bolo 0,89 a rozdiel nebol štatisticky významný. Ani čas do prvého výskytu progresie o dva alebo viac stupňov sa medzi skupinami významne nelíšil.</p>

<p>Inými slovami, napriek výraznejšiemu poklesu HbA1c pri tirzepatide sa nezistil signál vyššieho rizika zhoršenia diabetickej retinopatie.</p>

<h2>Nebol rozdiel ani v závažných očných udalostiach</h2>

<p>Medzi skupinami sa nelíšili ani sekundárne očné ukazovatele. Hodnotený bol kombinovaný endpoint zahŕňajúci:</p>

<ul>
  <li>retinálnu fotokoaguláciu,</li>
  <li>krvácanie do sklovca,</li>
  <li>intravitreálnu anti-VEGF liečbu,</li>
  <li>vitrektómiu,</li>
  <li>významnú stratu zrakovej ostrosti.</li>
</ul>

<p>Celkový hazard ratio bol 1,1, bez významného rozdielu medzi tirzepatidom a dulaglutidom. Rozdiel sa nezistil ani pri hodnotení podľa toho, či pacienti mali alebo nemali diabetickú retinopatiu už na začiatku.</p>

<p>Progresia retinálnych zmien bola v oboch skupinách postupná a zodpovedala prirodzenému priebehu ochorenia.</p>

<h2>Čo hovoria odborníci</h2>

<p>Vedúci skúšajúci David M. D’Alessio uviedol, že tirzepatid priniesol väčšie zlepšenie glykémie bez zhoršenia stavu sietnice v porovnaní s dulaglutidom počas 36 mesiacov sledovania. Podľa neho tieto údaje poskytujú klinikom určitú mieru uistenia, no zároveň pripomenul, že diabetická retinopatia môže mať závažné následky a pacienti majú naďalej absolvovať pravidelný očný skríning.</p>

<p>Oftalmológ Lloyd Paul Aiello, ktorý výsledky komentoval, upozornil, že prechodné zhoršenie retinopatie pri rýchlom poklese HbA1c sa častejšie pozorovalo pri diabete 1. typu než pri diabete 2. typu a len zriedkavo má klinicky významné dôsledky. Podľa neho je zlepšenie glykemickej kontroly z dlhodobého hľadiska stále lepšie než jej nezlepšovanie, aj keď sa môže objaviť krátkodobé zhoršenie retinopatie.</p>

<p>Zároveň pripomenul, že pri sprísňovaní glykemickej kontroly je vhodné postupovať podobne ako pri nasadzovaní inzulínu: zabezpečiť primeranú oftalmologickú starostlivosť podľa platných odporúčaní.</p>

<h2>Čo to znamená pre klinickú prax</h2>

<p>Výsledky substúdie sú povzbudivé. U vysokorizikových pacientov s diabetom 2. typu, vrátane pacientov s existujúcou retinopatiou alebo makulárnym edémom, tirzepatid nezvýšil riziko progresie diabetickej retinopatie v porovnaní s dulaglutidom.</p>

<p>To však neznamená, že očné sledovanie možno zanedbať. Naopak, pri pacientoch s dlhodobým diabetom, vyšším HbA1c, existujúcou retinopatiou alebo pri rýchlom zlepšovaní glykemickej kontroly zostáva pravidelný skríning sietnice nevyhnutný.</p>

<p>Prakticky možno povedať:</p>

<ul>
  <li>tirzepatid v tejto substúdii nezhoršil retinálny stav oproti dulaglutidu,</li>
  <li>znížil HbA1c výraznejšie,</li>
  <li>nebol spojený s vyššou potrebou očných intervencií,</li>
  <li>pravidelné očné kontroly zostávajú nutné,</li>
  <li>pri náhlej poruche videnia má pacient vyhľadať lekára bez odkladu.</li>
</ul>

<h2>Praktický záver</h2>

<p>Retina substúdia SURPASS-CVOT prináša upokojujúce údaje: tirzepatid nebol spojený so zvýšeným rizikom vzniku alebo progresie diabetickej retinopatie u vysokorizikových pacientov s diabetom 2. typu v porovnaní s dulaglutidom.</p>

<p>Výsledok podporuje bezpečnosť tirzepatidu z hľadiska sledovaných retinálnych ukazovateľov počas 36 mesiacov. Neznižuje však význam pravidelného očného skríningu, najmä u pacientov s dlhším trvaním diabetu, vyšším HbA1c alebo už prítomnou retinopatiou.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>No Increased Retinopathy Risk Seen With Tirzepatide</em> (2026). <a href="https://www.medscape.com/viewarticle/no-increased-retinopathy-risk-seen-tirzepatide-2026a1000iyc" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author), content = VALUES(content),
        excerpt = VALUES(excerpt), is_top = VALUES(is_top), is_published = VALUES(is_published),
        updated_at = NOW()"
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

        // Newsletter avízo LEN pri prvom vložení, nikdy pri regenerácii/update.
        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
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
