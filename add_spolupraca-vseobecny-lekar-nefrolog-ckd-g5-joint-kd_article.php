<?php
/**
 * add_spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): spolupráca lekára primárnej
 * starostlivosti a nefrológa pri CKD G5 podľa kohorty JOINT-KD.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd_article.php"
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
    'title'        => 'Spolupráca všeobecného lekára a nefrológa pri CKD G5: poučenie zo štúdie JOINT-KD',
    'slug'         => 'spolupraca-vseobecny-lekar-nefrolog-ckd-g5-joint-kd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Japonská kohorta JOINT-KD naznačuje, že spolupráca primárnej starostlivosti a nefrológa pri CKD G5 síce neoddialila dialýzu, ale bola spojená s nižším rizikom infekčných hospitalizácií.',
    'content'      => <<<'HTML'
<p>Manažment pacienta s chronickou chorobou obličiek v štádiu G5 nie je iba otázkou rozhodnutia, kedy začať dialýzu. Ide o komplexnú starostlivosť o človeka s vysokým rizikom hospitalizácie, infekcií, kardiovaskulárnych komplikácií, nutričných problémov, polyfarmácie, frailty a zhoršenej kvality života.</p>

<p>Štúdia JOINT-KD publikovaná v <em>Journal of Nephrology</em> sa venovala prakticky dôležitej otázke: má spolupráca medzi lekárom primárnej starostlivosti a nefrológom merateľný klinický prínos u pacientov s CKD v štádiu G5?</p>

<p>Zadaný zdroj je formálne oprava článku publikovaná v roku 2026. Opravovaný pôvodný článok vyšiel v roku 2025 a obsahuje hlavné klinické výsledky, z ktorých vychádza tento odborný text. Oprava sa týka rozšírenia etickej deklarácie a nemení interpretáciu hlavných klinických výsledkov.</p>

<h2>Prečo je táto téma dôležitá</h2>

<p>Pacienti s CKD G5 sú často sledovaní nefrológom, ale ich zdravotný stav presahuje rámec jednej špecializácie. Mávajú diabetes, hypertenziu, srdcové zlyhávanie, anémiu, poruchy minerálového metabolizmu, infekčné komplikácie, krehkosť, sociálne problémy a vysokú liekovú záťaž.</p>

<p>V takomto kontexte môže mať všeobecný lekár alebo lekár primárnej starostlivosti významnú úlohu. Často je bližšie k pacientovi, pozná jeho domáce a sociálne zázemie, rieši akútne ťažkosti medzi nefrologickými kontrolami a môže včas zachytiť zhoršenie celkového stavu.</p>

<p>Primárna starostlivosť môže pomáhať najmä pri prevencii a skorom zachytení infekcií, očkovaní, sledovaní komorbidít, koordinácii liekov, prevencii polyfarmácie a rozhodovaní, kedy je potrebné kontaktovať nefrológa alebo odoslať pacienta na urgentné vyšetrenie.</p>

<h2>Dizajn štúdie</h2>

<p>Autori vykonali retrospektívnu kohortovú štúdiu u dospelých ambulantných pacientov s CKD v štádiu G5 sledovaných v deviatich nefrologických centrách v Japonsku.</p>

<p>Hlavným sledovaným faktorom bola spolupráca lekára primárnej starostlivosti s nefrológom. Autori porovnávali pacientov manažovaných v spolupráci primárneho lekára a nefrológa s pacientmi sledovanými iba nefrológom.</p>

<p>Hodnotené boli najmä začatie dialýzy, hospitalizácie súvisiace s CKD, kardiovaskulárne hospitalizácie a hospitalizácie pre infekcie. Pri analýze boli použité modely zohľadňujúce konkurenčné riziká, napríklad úmrtie alebo preemptívnu transplantáciu obličky.</p>

<h2>Charakteristika súboru</h2>

<p>Do analýzy bolo zahrnutých 570 pacientov s CKD G5. Z nich 91 pacientov, teda 16,0 %, malo spoluprácu medzi lekárom primárnej starostlivosti a nefrológom. Ostatní pacienti boli sledovaní nefrológom bez takejto formálnej spolupráce.</p>

<p>Medián sledovania bol 1,4 roka. Počas sledovania 399 pacientov, teda 70,0 %, začalo dialýzu. Preemptívnu transplantáciu obličky podstúpilo 11 pacientov, teda 1,9 %, a 53 pacientov, teda 9,3 %, zomrelo.</p>

<p>Ide teda o populáciu s veľmi pokročilým ochorením obličiek, v ktorej je prirodzene vysoká pravdepodobnosť začatia náhrady funkcie obličiek alebo závažných klinických udalostí.</p>

<h2>Hlavné výsledky</h2>

<p>Spolupráca primárneho lekára a nefrológa nebola spojená s oddialením začatia dialýzy. Upravený subdistribučný hazard ratio bol 0,89 s 95 % intervalom spoľahlivosti 0,64 až 1,23.</p>

<p>Podobne nebol zistený významný rozdiel pri hospitalizáciách súvisiacich s CKD ani pri kardiovaskulárnych hospitalizáciách.</p>

<p>Významný rozdiel sa však ukázal pri hospitalizáciách pre infekcie. Spolupráca lekára primárnej starostlivosti a nefrológa bola spojená s nižším rizikom infekčnej hospitalizácie. Upravený subdistribučný hazard ratio bol 0,36 s 95 % intervalom spoľahlivosti 0,15 až 0,87.</p>

<p>To znamená, že pacienti manažovaní v spolupráci primárneho lekára a nefrológa mali v tejto kohorte nižšie riziko hospitalizácie pre infekciu. Výsledok treba interpretovať observačne, ale klinický signál je relevantný.</p>

<h2>Klinická interpretácia</h2>

<p>Výsledok je zaujímavý práve preto, že spolupráca primárnej a špecializovanej starostlivosti nezmenila všetky sledované ukazovatele. Neoddialila dialýzu a nepreukázala jasný vplyv na kardiovaskulárne hospitalizácie. Jej prínos sa však prejavil v oblasti infekcií.</p>

<p>To dáva klinický zmysel. Infekčné komplikácie u pacientov s pokročilou CKD často začínajú ako zdanlivo bežné ambulantné problémy: infekcia močových ciest, pneumónia, kožná infekcia, respiračné ochorenie, febrilita, dehydratácia alebo nešpecifické zhoršenie celkového stavu.</p>

<p>Ak je pacient zachytený skoro, môže sa znížiť riziko ťažkého priebehu a potreby hospitalizácie. Lekár primárnej starostlivosti môže v tomto smere dopĺňať nefrológa, pretože je pre pacienta často dostupnejší medzi špecializovanými kontrolami.</p>

<h2>Primárna starostlivosť nenahrádza nefrológa</h2>

<p>Dôležité je nevnímať výsledok ako argument za presun pokročilej CKD do primárnej starostlivosti. Pacient s CKD G5 potrebuje nefrologické vedenie: prípravu na dialýzu alebo transplantáciu, manažment anémie, poruchy minerálovo-kostného metabolizmu, metabolickej acidózy, hyperkaliémie, objemu a antihypertenzívnej liečby.</p>

<p>Prínos spolupráce pravdepodobne vzniká vtedy, keď sa obe úrovne starostlivosti dopĺňajú. Nefrológ riadi obličkové ochorenie a prípravu na náhradu funkcie obličiek. Primárny lekár pomáha so skorým zachytením infekcií, komorbiditami, očkovaním, liekovou bezpečnosťou a kontinuálnym kontaktom s pacientom.</p>

<p>Najväčšia hodnota nie je v tom, že pacient má „viac lekárov“, ale že má koordinovaný plán a každý člen tímu vie, čo má sledovať a kedy má reagovať.</p>

<h2>Infekcie ako slabé miesto CKD G5</h2>

<p>Pacienti s pokročilou CKD majú zvýšené riziko infekcií z viacerých dôvodov. Prítomná je porucha imunity spojená s urémiou, vyšší vek, diabetes, malnutrícia, anémia, opakované kontakty so zdravotníckym systémom a často aj budúca potreba cievneho prístupu alebo dialýzy.</p>

<p>Infekčná hospitalizácia pritom nie je banálna epizóda. U pacienta s CKD G5 môže viesť k akcelerácii poklesu renálnej funkcie, urgentnému začatiu dialýzy, delíriu, poklesu funkčnej kapacity, kardiovaskulárnym komplikáciám a zvýšenej mortalite.</p>

<p>Ak koordinovaná starostlivosť znižuje riziko infekčných hospitalizácií, ide o klinicky relevantný benefit aj vtedy, keď neovplyvní samotný čas začatia dialýzy.</p>

<h2>Význam pre nefrologickú prax</h2>

<p>Pre nefrológa je hlavné posolstvo praktické: pacient s CKD G5 by nemal byť izolovaný iba v špecializovanej nefrologickej ambulancii. Aj pri pokročilom ochorení obličiek má zmysel koordinovaná spolupráca s primárnou starostlivosťou.</p>

<p>Takýto model môže byť dôležitý najmä u pacientov vo vyššom veku, s viacerými komorbiditami, častými infekciami, sociálnou alebo logistickou bariérou dostupnosti nefrológa, polyfarmáciou, frailty alebo v období prípravy na dialýzu.</p>

<p>Kľúčové je jasné rozdelenie kompetencií. Primárny lekár má vedieť, kedy pacienta riešiť ambulantne, kedy kontaktovať nefrológa a kedy pacienta odoslať na urgentné vyšetrenie. Nefrológ má poskytnúť zrozumiteľný plán starostlivosti vrátane cieľových hodnôt, varovných príznakov, úpravy liekov a plánu prípravy na dialýzu alebo transplantáciu.</p>

<h2>Praktická organizácia spolupráce</h2>

<p>Zo štúdie nemožno priamo odvodiť univerzálny model pre všetky zdravotnícke systémy, ale pre prax sú rozumné tieto princípy:</p>

<ul>
  <li>pacient s CKD G5 má mať jasne definovaného nefrológa aj lekára primárnej starostlivosti,</li>
  <li>medzi lekármi má byť zdieľaný plán sledovania a liečby,</li>
  <li>treba aktívne riešiť očkovanie, infekčné riziká a skoré príznaky infekcie,</li>
  <li>liekové zmeny majú zohľadňovať aktuálnu eGFR, hyperkaliémiu, objemový stav a riziko nefrotoxicity,</li>
  <li>pacient má vedieť, koho kontaktovať pri horúčke, dyspnoe, zhoršení diurézy, edémoch, slabosti alebo známkach infekcie,</li>
  <li>príprava na dialýzu má byť koordinovaná včas, nie až pri urgentnej dekompenzácii.</li>
</ul>

<p>V slovenskej praxi môže byť dôležitá aj dostupnosť nefrologickej ambulancie, vzdialenosť pacienta, kapacita primárnej starostlivosti a kvalita komunikácie cez výmenné lístky, elektronickú dokumentáciu alebo priame konzultácie.</p>

<h2>Čo má obsahovať zdieľaný plán</h2>

<p>Pri CKD G5 by zdieľaný plán nemal byť len všeobecnou poznámkou, že pacient je sledovaný nefrológom. Prakticky má obsahovať:</p>

<ol>
  <li><strong>Aktuálny nefrologický stav.</strong> eGFR alebo kreatinín, trend, albuminúria alebo proteinúria, komplikácie CKD a plán náhrady funkcie obličiek.</li>
  <li><strong>Lieky a riziká.</strong> Čo neupravovať bez konzultácie, ktoré lieky sú rizikové pri zhoršení stavu a aké sú limity pre draslík, tlak alebo objem.</li>
  <li><strong>Varovné príznaky.</strong> Horúčka, dyspnoe, zmätenosť, oligúria, rýchly nárast edémov, hypotenzia, hyperkaliemické príznaky alebo známky infekcie.</li>
  <li><strong>Kontakt a eskalácia.</strong> Kedy volať nefrológa, kedy poslať pacienta na urgentný príjem a kedy stačí ambulantná kontrola.</li>
  <li><strong>Prevencia.</strong> Očkovanie, nutričné odporúčania, prevencia pádov, infekčná prevencia a plán kontroly komorbidít.</li>
</ol>

<h2>Limity štúdie</h2>

<p>Štúdia bola retrospektívna a observačná. Preto nemožno s istotou tvrdiť, že samotná spolupráca primárneho lekára a nefrológa spôsobila nižšie riziko infekčných hospitalizácií. Môžu existovať rozdiely medzi pacientmi, ktorí takúto spoluprácu mali, a tými, ktorí boli sledovaní iba nefrológom.</p>

<p>Sledovanie bolo relatívne krátke, s mediánom 1,4 roka. Výsledky pochádzajú z japonského zdravotníckeho systému, ktorý sa môže líšiť od európskej alebo slovenskej organizácie starostlivosti.</p>

<p>Napriek týmto limitom je štúdia cenná, pretože sa venuje veľmi praktickej otázke organizácie starostlivosti o pacientov s najpokročilejšou CKD pred začatím dialýzy.</p>

<h2>Záver</h2>

<p>Štúdia JOINT-KD ukazuje, že spolupráca medzi lekárom primárnej starostlivosti a nefrológom u pacientov s CKD G5 pravdepodobne nevedie k oddialeniu dialýzy, ale môže byť spojená s nižším rizikom hospitalizácie pre infekcie.</p>

<p>Pre klinickú prax je to dôležitý signál. Kvalitná starostlivosť o pacienta s pokročilou CKD nie je iba otázkou nefrologickej expertízy, ale aj dobrej koordinácie, dostupnosti, prevencie a včasného zachytenia komplikácií.</p>

<p>Najmä infekcie predstavujú oblasť, kde môže primárna starostlivosť v spolupráci s nefrológom priniesť reálny benefit. Cieľom nemá byť presun zodpovednosti, ale spoločný plán, ktorý pacienta zachytí skôr, než sa ambulantný problém zmení na hospitalizáciu.</p>

<hr>

<p><em><strong>Zdroj:</strong> Murakami M, Aoki T, Sugiyama Y, Sasaki S, Nishiwaki H, Yazawa M, Raita Y, Kawarazaki H, Shimizu H, Nakamura Y, Saka Y, Matsushima M. Association between primary care physician-nephrologist collaboration and clinical outcomes in patients with stage 5 chronic kidney disease: a JOINT-KD cohort study. <em>Journal of Nephrology</em>. 2025;38(5):1385-1394. doi:10.1007/s40620-025-02299-1. PMID: 40338420. <a href="https://pubmed.ncbi.nlm.nih.gov/40338420/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Oprava zdroja:</strong> Correction to: Association between primary care physician-nephrologist collaboration and clinical outcomes in patients with stage 5 chronic kidney disease: a JOINT-KD cohort study. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajag167. doi:10.1093/joneph/aajag167. PMID: 42360783. <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag167/8719061" target="_blank" rel="noopener noreferrer">Oxford Academic</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42360783/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_joint_kd newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_joint_kd pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_joint_kd pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_joint_kd migration error: ' . $e->getMessage());
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
