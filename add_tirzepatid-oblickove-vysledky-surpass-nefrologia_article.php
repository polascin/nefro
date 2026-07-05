<?php
/**
 * add_tirzepatid-oblickove-vysledky-surpass-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): tirzepatid, obličkové
 * výsledky v programe SURPASS a praktický nefrologický pohľad.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_tirzepatid-oblickove-vysledky-surpass-nefrologia_article.php"
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
    'title'        => 'Tirzepatid a obličkové výsledky v programe SURPASS: čo znamenajú pre nefrológiu',
    'slug'         => 'tirzepatid-oblickove-vysledky-surpass-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Tirzepatid prináša v programe SURPASS priaznivé signály pre eGFR, albuminúriu a renálne endpointy. Pre nefrológiu je dôležité rozlíšiť sľubný kardiorenálny účinok od definitívne dokázanej renoprotekcie.',
    'content'      => <<<'HTML'
<p>Tirzepatid sa pôvodne dostal do klinickej pozornosti najmä ako veľmi účinný liek na zníženie HbA1c a telesnej hmotnosti u pacientov s diabetes mellitus 2. typu. Postupne sa však ukazuje, že jeho význam môže presahovať samotnú glykemickú kontrolu a manažment obezity. Obličkové analýzy z programu SURPASS naznačujú priaznivý vplyv na albuminúriu, rýchlosť poklesu eGFR a zložené renálne ukazovatele.</p>

<p>Z nefrologického hľadiska ide o mimoriadne praktickú tému. Diabetes mellitus 2. typu zostáva jednou z hlavných príčin chronickej choroby obličiek (CKD) a zlyhania obličiek. Každá liečba, ktorá okrem zlepšenia metabolického profilu dokáže priaznivo ovplyvniť albuminúriu, pokles eGFR alebo riziko progresie CKD, môže mať veľký klinický význam. Zároveň však platí, že „renálny signál“ zo sekundárnych alebo exploračných analýz ešte nie je to isté ako definitívne dokázaná renoprotekcia v špecializovanej výsledkovej štúdii zameranej na obličky.</p>

<h2>Duálny agonista GIP a GLP-1 receptorov</h2>

<p>Tirzepatid je duálny agonista receptorov pre glukózodependentný inzulínotropný polypeptid (GIP) a glukagónu podobný peptid 1 (GLP-1). Nejde teda o „klasického“ agonistu GLP-1 receptora, ale o liek zasahujúci dve inkretínové dráhy. Klinicky sa to prejavuje výrazným poklesom HbA1c, redukciou telesnej hmotnosti, zlepšením krvného tlaku a priaznivým metabolickým profilom.</p>

<p>Tieto účinky sú relevantné aj pre obličky. Diabetická choroba obličiek nie je iba dôsledkom hyperglykémie. Podieľajú sa na nej obezita, inzulínová rezistencia, hypertenzia, albuminúria, glomerulárna hyperfiltrácia, zápal, endoteliálna dysfunkcia a zvýšené kardiovaskulárne riziko. Liek, ktorý naraz ovplyvňuje viacero z týchto dráh, môže mať renálny prínos aj mimo samotného zníženia glykémie.</p>

<h2>SURPASS-4: prvý silný renálny signál</h2>

<p>Z nefrologického pohľadu bola dôležitá najmä post hoc analýza štúdie SURPASS-4. V nej bol tirzepatid porovnaný s titrovaným inzulínom glargínom u pacientov s diabetes mellitus 2. typu a vysokým kardiovaskulárnym rizikom. Pri vstupe mali účastníci priemernú eGFR 81,3 ml/min/1,73 m² a medián UACR 15 mg/g, teda nešlo primárne o štúdiu pokročilej CKD.</p>

<p>Analýza ukázala tri prakticky dôležité signály:</p>

<ul>
  <li><strong>pomalší pokles eGFR</strong> – ročný pokles eGFR bol −1,4 ml/min/1,73 m² pri tirzepatide oproti −3,6 ml/min/1,73 m² pri inzulíne glargíne, s rozdielom 2,2 ml/min/1,73 m² za rok,</li>
  <li><strong>priaznivejší vývoj albuminúrie</strong> – UACR pri inzulíne glargíne stúpol o 36,9 %, zatiaľ čo pri tirzepatide sa nezvýšil; rozdiel medzi skupinami bol približne −31,9 %,</li>
  <li><strong>nižší výskyt zloženého renálneho ukazovateľa</strong> – kompozit zahŕňal ≥40 % pokles eGFR, terminálne zlyhanie obličiek, úmrtie z renálnej príčiny alebo vznik makroalbuminúrie; hazard ratio bolo 0,58 v prospech tirzepatidu.</li>
</ul>

<p>Dôležité je povedať aj limitáciu: SURPASS-4 nebola primárne renálna štúdia. Obličkové výsledky boli analyzované post hoc, pričom porovnávacím liekom bol inzulín glargín. Výsledky preto podporili hypotézu renálneho prínosu, ale samy osebe ešte neurčili konečné miesto tirzepatidu v renoprotekcii.</p>

<h2>SURPASS-CVOT: aktívny komparátor a dlhšie sledovanie</h2>

<p>Novšie údaje priniesla predšpecifikovaná exploračná analýza SURPASS-CVOT. Štúdia porovnávala tirzepatid s dulaglutidom u pacientov s diabetes mellitus 2. typu a aterosklerotickým kardiovaskulárnym ochorením. Ide o dôležitý metodologický rozdiel: dulaglutid je aktívny GLP-1 receptorový agonista s dokázaným kardiovaskulárnym prínosom, takže porovnanie nie je proti placebu ani proti inzulínu.</p>

<p>Po mediáne sledovania 4,0 roka bol primárny zložený renálny ukazovateľ nižší pri tirzepatide než pri dulaglutide: 6,0 % oproti 7,6 %, hazard ratio 0,77. Kompozit zahŕňal perzistujúcu makroalbuminúriu, perzistujúci pokles eGFR o ≥50 %, zlyhanie obličiek alebo úmrtie z renálnej príčiny.</p>

<p>Účinok sa líšil podľa východiskového renálneho rizika. V populácii s nízkym až stredným rizikom CKD bol prínos dominantne ťahaný nižším výskytom novej perzistujúcej makroalbuminúrie. V skupine s vysokým rizikom CKD bol dôležitejší pomalší pokles eGFR. Celkovo bol ročný pokles eGFR pri tirzepatide miernejší než pri dulaglutide; rozdiel bol 0,29 ml/min/1,73 m² za rok v celkovej populácii a 0,93 ml/min/1,73 m² za rok vo vysokorizikovej CKD skupine.</p>

<p>Pre nefrológa je práve toto zaujímavé: tirzepatid nepriniesol len metabolickú účinnosť, ale v aktívne kontrolovanej štúdii ukázal priaznivý renálny signál oproti etablovanému GLP-1 receptorovému agonistovi. Zároveň treba ostať presný: išlo o predšpecifikovanú exploračnú renálnu analýzu v kardiovaskulárnej outcome štúdii, nie o primárne obličkovú štúdiu typu DAPA-CKD, EMPA-KIDNEY alebo FLOW.</p>

<h2>Možné mechanizmy renálneho prínosu</h2>

<p>Renálny účinok tirzepatidu pravdepodobne nevychádza z jedného mechanizmu. Ide skôr o kombináciu metabolických, hemodynamických a protizápalových efektov.</p>

<h3>Redukcia telesnej hmotnosti</h3>

<p>Obezita zvyšuje riziko glomerulárnej hyperfiltrácie, hypertenzie, albuminúrie a progresie CKD. Výrazný pokles hmotnosti pri tirzepatide môže znižovať metabolické aj hemodynamické zaťaženie obličiek. Tento mechanizmus je zvlášť relevantný pri diabetickej chorobe obličiek spojenej s obezitou.</p>

<h3>Zlepšenie glykemickej kontroly</h3>

<p>Lepšia kontrola hyperglykémie znižuje glukotoxické poškodenie glomerulov a tubulointerstícia. Pri moderných inkretínových liekoch však samotný pokles HbA1c pravdepodobne nevysvetľuje celý kardiorenálny prínos.</p>

<h3>Pokles krvného tlaku a albuminúrie</h3>

<p>Aj mierne zníženie systolického tlaku môže byť u pacienta s CKD významné. Albuminúria navyše nie je iba marker poškodenia glomerulárnej bariéry. Je aj aktívnym rizikovým faktorom tubulointersticiálneho zápalu a fibrózy. Ak liečba znižuje UACR alebo bráni vzniku makroalbuminúrie, môže tým nepriamo ovplyvňovať progresiu CKD.</p>

<h3>Metabolické a protizápalové účinky</h3>

<p>Inkretínové terapie môžu ovplyvňovať zápal, oxidačný stres, endoteliálnu dysfunkciu a tukovú distribúciu. Pri tirzepatide sa časť renálneho signálu môže viazať na zlepšenie celého kardio-renálno-metabolického prostredia, nie na izolovaný účinok na glomerulus.</p>

<h2>Kde môže byť tirzepatid klinicky najzaujímavejší</h2>

<p>V praxi sa tirzepatid javí najzaujímavejšie u pacienta s diabetes mellitus 2. typu, nadváhou alebo obezitou, albuminúriou a vysokým kardiovaskulárnym rizikom. V takomto profile sa stretáva viacero dráh, ktoré liek dokáže ovplyvniť naraz: glykémia, hmotnosť, tlak, albuminúria a celkové kardiorenálne riziko.</p>

<p>Nemal by však nahrádzať overené piliere liečby diabetickej choroby obličiek. Skôr patrí do premyslenej kombinovanej stratégie, ktorá zahŕňa:</p>

<ul>
  <li>optimálnu kontrolu krvného tlaku,</li>
  <li>blokádu systému renín-angiotenzín-aldosterón pri albuminúrii, ak je tolerovaná,</li>
  <li>inhibítor SGLT2, ak nie je kontraindikovaný,</li>
  <li>zváženie nesteroidového antagonistu mineralokortikoidného receptora pri vhodnom profile albuminurickej diabetickej CKD,</li>
  <li>individualizovanú glykemickú kontrolu,</li>
  <li>liečbu obezity a zníženie kardiovaskulárneho rizika,</li>
  <li>nefroprotektívny životný štýl vrátane obmedzenia nadmerného príjmu soli.</li>
</ul>

<p>Prakticky povedané: tirzepatid nie je náhrada za SGLT2 inhibítor alebo RAAS blokádu. Môže však byť dôležitým doplnením u pacienta, ktorého renálne riziko je úzko prepojené s obezitou, metabolickou dysreguláciou a vysokým kardiovaskulárnym rizikom.</p>

<h2>Bezpečnostné poznámky pri CKD</h2>

<p>Pri liečbe tirzepatidom treba myslieť najmä na gastrointestinálne nežiaduce účinky: nauzeu, vracanie a hnačku. V SURPASS-CVOT boli tieto príhody častejšie pri tirzepatide než pri dulaglutide. U pacienta s CKD môže byť dehydratácia klinicky významná, pretože môže viesť k prechodnému zhoršeniu funkcie obličiek, najmä pri súčasnom užívaní diuretík, RAAS blokátorov alebo SGLT2 inhibítorov.</p>

<p>Dôležité je sledovať:</p>

<ul>
  <li>toleranciu liečby a príjem tekutín,</li>
  <li>telesnú hmotnosť a známky dehydratácie,</li>
  <li>eGFR a UACR,</li>
  <li>krvný tlak, najmä pri súčasnej antihypertenzívnej liečbe,</li>
  <li>riziko hypoglykémie pri kombinácii s inzulínom alebo derivátmi sulfonylurey,</li>
  <li>potrebu úpravy ostatnej antidiabetickej liečby pri rýchlom zlepšení glykémie.</li>
</ul>

<p>Samotný tirzepatid má nízke riziko hypoglykémie, ale toto riziko rastie pri kombinácii s inzulínom alebo sulfonylureou. Pri výraznom poklese hmotnosti, znížení príjmu jedla alebo gastrointestinálnej intolerancii treba myslieť aj na praktické „sick day“ odporúčania, najmä ak pacient užíva SGLT2 inhibítor alebo diuretiká.</p>

<h2>Čo zatiaľ nevieme</h2>

<p>Dostupné údaje sú povzbudivé, no viaceré otázky zostávajú otvorené. Nie je úplne jasné, aká časť renálneho prínosu je nezávislá od redukcie hmotnosti, poklesu HbA1c a krvného tlaku. Rovnako potrebujeme viac údajov u pacientov s pokročilejšou CKD, vysokou albuminúriou, krehkosťou, polyfarmáciou a vyšším rizikom akútnych komplikácií.</p>

<p>Ďalšou otázkou je optimálna kombinácia tirzepatidu so SGLT2 inhibítormi a ďalšími nefroprotektívnymi liekmi. SURPASS-CVOT naznačuje prínos aj v ére modernej liečby, no špecifická stratégia vrstvenia terapie bude musieť vychádzať z ďalších dát, tolerancie pacienta a lokálnej dostupnosti liekov.</p>

<h2>Praktický nefrologický záver</h2>

<p>Tirzepatid predstavuje významný posun v liečbe pacientov s diabetes mellitus 2. typu a obezitou. Obličkové analýzy zo SURPASS-4 a SURPASS-CVOT ukazujú priaznivý účinok na eGFR, albuminúriu a zložené renálne ukazovatele. Najnovšie údaje zo SURPASS-CVOT sú obzvlášť zaujímavé, pretože porovnávajú tirzepatid s aktívnym GLP-1 receptorovým agonistom, nie s placebom.</p>

<p>Pre nefrologickú prax je najdôležitejšie toto: tirzepatid môže byť vhodným doplnením komplexnej nefroprotektívnej stratégie u pacienta s diabetom 2. typu, obezitou, albuminúriou a vysokým kardiorenálnym rizikom. Nemal by však nahrádzať osvedčené piliere liečby CKD. Jeho použitie má byť individualizované, s dôrazom na hydratáciu, toleranciu, eGFR, UACR a riziko hypoglykémie pri kombinovanej antidiabetickej liečbe.</p>

<h2>Záver</h2>

<p>Inkretínová liečba vstupuje do fázy, v ktorej už nejde iba o HbA1c a hmotnosť. Pri tirzepatide sa čoraz jasnejšie ukazuje kardiorenálno-metabolický potenciál: spomalenie poklesu eGFR, priaznivý vývoj albuminúrie a nižší výskyt zložených renálnych ukazovateľov v programe SURPASS.</p>

<p>Doterajšie údaje sú povzbudivé, ale nefrologická interpretácia má ostať presná. Tirzepatid má sľubné renálne účinky a môže významne doplniť liečbu vybraných pacientov s diabetom 2. typu a CKD. Definitívne postavenie v renoprotekcii však bude závisieť od ďalších dlhodobých a špecificky obličkovo zameraných štúdií.</p>

<hr>

<p><em><strong>Zdroj:</strong> DocWire News. Kidney Outcomes in SURPASS: Exploring Tirzepatide’s Broader Impact. 2026. <a href="https://www.docwirenews.com/post/kidney-outcomes-in-surpass-exploring-tirzepatides-broader-impact" target="_blank" rel="noopener noreferrer">DocWire News</a>.</em></p>

<p><em><strong>Primárne odborné zdroje:</strong> Heerspink HJL, Sattar N, Pavo I, Haupt A, Duffin KL, Yang Z, Wiese RJ, Tuttle KR, Cherney DZI. Effects of tirzepatide versus insulin glargine on kidney outcomes in type 2 diabetes in the SURPASS-4 trial. <em>The Lancet Diabetes &amp; Endocrinology</em>. 2022;10(11):774–785. doi:10.1016/S2213-8587(22)00243-1. Zoungas S, D’Alessio D, Pavo I, Bhatt DL, Buse JB, Del Prato S, Kahn SE, Lincoff AM, McGuire DK, Nauck MA, Nissen SE, Sattar N, Zinman B, Ceriello A, Stechemesser L, Verhaegen A, Broder JC, Wolfe R, Miller D, Nishiyama H, Wang X, Weerakkody G, Wiese RJ, Nicholls SJ. A comparison of the effects of tirzepatide and dulaglutide on major kidney events in people with type 2 diabetes. <em>The Lancet Diabetes &amp; Endocrinology</em>. 2026;14(7):544–557. doi:10.1016/S2213-8587(26)00032-X.</em></p>
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
                error_log('add_tirzepatid_surpass_kidney newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_tirzepatid_surpass_kidney pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_tirzepatid_surpass_kidney pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_tirzepatid_surpass_kidney migration error: ' . $e->getMessage());
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
