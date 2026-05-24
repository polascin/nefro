<?php
/**
 * add_strava_tuky_ckd_article.php
 * Pridanie článku o strave, tukoch a kardiovaskulárnom riziku pri CKD
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
    'title'        => 'Strava, tuky a kardiovaskulárne riziko pri chronickom ochorení obličiek (CKD): čo dáva zmysel v praxi',
    'slug'         => 'strava-tuky-kardiovaskularne-riziko-ckd-co-dava-zmysel-praxi',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-24',
    'is_top'       => 0,
    'excerpt'      => 'Kardiovaskulárne ochorenia sú najčastejšou príčinou úmrtí u pacientov s CKD, no výskum v tejto oblasti trpí chronickým nedostatkom dôkazov. Článok vysvetľuje, prečo je v praxi zmysluplnejšie odporúčať diétne vzorce (mediteránsky režim, DASH) ako presné percentá mastných kyselín, a prečo je kľúčová individualizovaná nutričná starostlivosť.',
    'content'      => <<<'HTML'
<p>Kardiovaskulárne ochorenia (KVO) sú podľa článku <strong>najčastejšou príčinou úmrtí</strong> u pacientov s chronickým ochorením obličiek (CKD) naprieč celým spektrom závažnosti. Práve preto je znižovanie kardiovaskulárneho rizika jedna z najurgentnejších priorít nefrológie. Zároveň však doterajší výskum naráža na veľkú „medzeru v dôkazoch" a z nej vyplýva aj to, prečo je tak ťažké nájsť jednoduchú, univerzálne fungujúcu stratégiu.</p>

<h2>Prečo je to v CKD komplikované</h2>

<p>Článok zdôrazňuje, že mnohé štúdie o srdcovo-cievnom riziku historicky <strong>nezahŕňali</strong> ľudí s CKD (alebo zahŕňali len okrajovo a dialyzovaných väčšinou vynechávali). Klinici potom musia výsledky zovšeobecňovať z populácií bez CKD, čo nemusí zachytiť špecifiká tohto ochorenia.</p>

<p>CKD mení „pozadie", v ktorom sa KVO rozvíja. Faktory ako zápal, oxidačný stres, diabetes, poruchy lipidov, hypertenzia alebo obezita sa v CKD správajú inak, pretože do hry vstupujú aj ďalšie mechanizmy typické pre obličkové ochorenie, napríklad minerálovo-kostové poruchy, uremické toxíny a hemodynamické zmeny.</p>

<p>Výsledkom je, že aj keď intervencie v CKD často zlepšia <strong>surrogátne ukazovatele</strong> (napríklad LDL, krvný tlak, fosfor, CRP či telesnú hmotnosť), nie vždy sa to preloží do jednoznačného poklesu „tvrdých" klinických end-pointov ako úmrtia na KVO.</p>

<h2>Tuky v strave ako rozumný východiskový bod</h2>

<p>Keď sa rieši výživa a srdce, tuky sa tradične riešia veľmi skoro. Článok však jasne pripomína, že odporúčania sa vyvíjali a aktuálne smerovanie je pomerne konzistentné: <strong>zvýšiť príjem polynenasýtených mastných kyselín (PUFA)</strong>.</p>

<p>V CKD sa opakovane pozoruje <strong>nižší obsah PUFA</strong> v porovnaní so všeobecnou populáciou. Podľa článku výskum naznačuje, že PUFA môžu pomôcť spomaliť progresiu CKD a zároveň znížiť kardiovaskulárne riziko v priebehu choroby. Pri niektorých študijných nastaveniach sa spomína aj znížená mortalita pri pravidelnom jedle rýb. Rovnako sa rieši pomer MUFA ku PUFA a jeho potenciálny význam.</p>

<p>Napriek tomu autori upozorňujú, že obraz nie je úplne jednoznačný, lebo zlepšenie lipidových parametrov alebo iných ukazovateľov nie je automaticky to isté ako zníženie mortality. Do toho sa často pridáva problém adherencie: ľudia musia súčasne zvládať lieky, diétne obmedzenia aj zmeny životného štýlu.</p>

<h2>Prechod od nutrientov k jedálničku (diétnym vzorcom)</h2>

<p>Článok ide ďalej a veľmi prakticky vysvetľuje, prečo je v reálnom živote ťažké dávať presné odporúčania typu „koľko % energie tvoria konkrétne podtypy mastných kyselín". Je to náročné na výživovú gramotnosť, logovanie jedla a výpočty.</p>

<p>Jednoduchšia a klinicky použiteľnejšia cesta je zamerať sa na <strong>diétne vzorce</strong>, ktoré prirodzene zvyšujú PUFA a zároveň obsahujú aj ďalšie kardioprotektívne zložky, ako antioxidanty, vlákninu či polyfenoly. V CKD sa študujú najmä:</p>

<ul>
  <li><strong>mediteránsky diétny režim</strong></li>
  <li><strong>DASH (Dietary Approaches to Stop Hypertension)</strong></li>
</ul>

<p>Tieto prístupy majú podľa článku často lepšiu toleranciu a adherenciu ako tradičné striktne obličkové obmedzenia, a zároveň zasahujú viac rizikových dráh naraz.</p>

<h3>A čo draslík v rastlinnej strave?</h3>

<p>Jedna z bežných obáv pacientov aj klinikov je hyperkaliémia pri strave s vyšším obsahom draslíkovo bohatých potravín (ovocie a zelenina). Článok uvádza, že korelácia medzi príjmom draslíka v potrave a sérovým draslíkom býva prekvapivo slabá a že štúdie sledujúce DASH či mediteránsky režim v CKD nezaznamenali zvýšené riziko hyperkaliémie. To dáva väčší priestor odporúčať tieto vzorce s dôveryhodnejším základom.</p>

<p>Zároveň mediteránsky režim nie je „nízkotučný": typicky obsahuje najmenej približne 35 % energie z tukov. Preto môže byť vhodný aj pre ľudí, ktorí riešia skôr nižší príjem sacharidov alebo bielkovín, no potrebujú udržať dostatočný energetický príjem a predísť malnutrícii alebo svalovému úbytku.</p>

<h2>Prečo je kľúčová výživa vedená dietológom</h2>

<p>Najdôležitejší praktický posun v článku je, že najlepšie výsledky neprináša jednostranná „diétna rada", ale <strong>individualizovaná nutričná starostlivosť</strong> pod vedením registrovaného dietológa.</p>

<p>Dôvod je jednoduchý: top priorita pacienta v oblasti KVO výživy nemusí byť „zvýšiť PUFA". Môže to byť:</p>

<ul>
  <li>finančná dostupnosť jedla,</li>
  <li>udržanie zdržanlivosti od fajčenia alebo abstinencie od alkoholu,</li>
  <li>konzistentnejšia kontrola glykémie,</li>
  <li>alebo proste reálne nastavenie zmeny, ktorú človek vie dlhodobo udržať.</li>
</ul>

<p>Dietológ dokáže urobiť nutričné vyšetrenie, stanoviť realistické ciele a zosúladiť odporúčania naprieč tímom. Článok tiež zdôrazňuje, že pri CKD sú dôležité kultúrne a ekonomické faktory — inak odporúčanie v praxi nedrží.</p>

<h2>Zhrnutie</h2>

<p>Podľa textu platí:</p>

<ul>
  <li>KVO je v CKD dominantná príčina úmrtí, a preto je výživa relevantná.</li>
  <li>Tuky, najmä <strong>PUFA</strong>, sú rozumný cieľ, ale nie jediná odpoveď.</li>
  <li>Praktickejšie a často úspešnejšie je odporúčať <strong>diétne vzorce</strong> (mediteránsky, DASH), než príliš presne kalkulovať konkrétne percentá mastných kyselín.</li>
  <li>Najväčší klinický prínos vzniká pri spolupráci nefrológa s dietológom, aby bol plán komplexný, personalizovaný a udržateľný.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Renal &amp; Urology News – „Chronic Kidney Disease, Dietary Fat &amp; Cardiovascular Risk Treatment". <a href="https://www.renalandurologynews.com/features/chronic-kidney-disease-dietary-fat-cardiovascular-risk-treatment/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

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
                error_log('add_strava_tuky_ckd_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_strava_tuky_ckd_article error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: Strava, tuky a kardiovaskulárne riziko pri CKD\n";
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
      <title>Migrácia – Strava, tuky a kardiovaskulárne riziko pri CKD</title>
      <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    </head>
    <body>
      <main class="container" style="padding-top:60px;padding-bottom:60px;">
        <div class="auth-container">
          <h2>Migrácia – Strava, tuky a kardiovaskulárne riziko pri CKD</h2>

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
