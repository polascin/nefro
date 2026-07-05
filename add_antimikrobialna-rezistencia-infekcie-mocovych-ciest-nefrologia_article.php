<?php
/**
 * add_antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): globálna záťaž
 * antimikrobiálnej rezistencie pri infekciách močových ciest a praktický
 * nefrologický pohľad.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia_article.php"
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
    'title'        => 'Antimikrobiálna rezistencia pri infekciách močových ciest: globálna záťaž a nefrologický pohľad',
    'slug'         => 'antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Infekcie močových ciest sú častým rezervoárom antimikrobiálnej rezistencie. U pacientov s CKD, katétrami a po transplantácii obličky rozhoduje presná indikácia liečby, kultivácia, dávka podľa eGFR a včasná deeskalácia.',
    'content'      => <<<'HTML'
<p>Infekcie močových ciest patria medzi najčastejšie bakteriálne infekcie v ambulantnej aj nemocničnej praxi. Ich manažment sa však v posledných rokoch významne komplikuje narastajúcou antimikrobiálnou rezistenciou. Rezistentné uropatogény už dávno nie sú problémom iba intenzívnej medicíny alebo nemocničnej epidemiológie. Čoraz častejšie sa objavujú aj u ambulantných pacientov, u polymorbídnych chorých, u osôb s permanentnými katétrami, po opakovanej antibiotickej liečbe a u imunokompromitovaných pacientov vrátane príjemcov transplantovanej obličky.</p>

<p>Pre nefrológiu je táto téma mimoriadne praktická. Infekcia močových ciest (IMC; angl. UTI) nie je u rizikového pacienta len „banálna cystitída“. Môže viesť k pyelonefritíde, urosepse, akútnemu poškodeniu obličiek, dekompenzácii chronickej choroby obličiek a pri transplantovanej obličke aj k poškodeniu štepu. Prehľadový článok v <em>Nephrology Dialysis Transplantation</em> preto pripomína, že antimikrobiálnu rezistenciu pri IMC treba chápať ako výsledok súhry baktérie, pacienta, močových ciest, mikrobiómu a farmakokinetiky liečiva.</p>

<h2>Prečo sú infekcie močových ciest rezervoárom rezistencie</h2>

<p>Väčšina IMC je spôsobená gramnegatívnymi baktériami, najmä uropatogénnymi kmeňmi <em>Escherichia coli</em>, ale aj ďalšími enterobaktériami a niektorými nefermentujúcimi gramnegatívnymi baktériami. Tieto mikroorganizmy majú vysokú schopnosť získavať gény rezistencie, šíriť ich horizontálnym prenosom a zároveň si zachovávať virulenčné vlastnosti potrebné na kolonizáciu močových ciest.</p>

<p>Rezistencia pri uropatogénoch nevzniká izolovane. Podporuje ju selekčný tlak antibiotík, opakovaná expozícia liečbe, kolonizácia čreva, kontakt s nemocničným prostredím, invazívne pomôcky a porucha prirodzeného toku moču. Močové cesty preto nemožno oddeľovať od črevného a genitálneho mikrobiómu. Uropatogén, ktorý sa klinicky prejaví v moči, môže byť súčasťou širšej kolonizačnej ekológie pacienta.</p>

<p>Dôležitý je aj objem predpisovania antibiotík. IMC patria medzi diagnózy, pri ktorých sa antibiotiká používajú veľmi často, niekedy aj pri nejasných alebo minimálnych príznakoch. Každá zbytočná liečba asymptomatickej bakteriúrie alebo príliš široká empirická voľba zvyšuje selekčný tlak a podporuje prežívanie rezistentných kmeňov.</p>

<h2>Mechanizmy rezistencie a klinický dôsledok</h2>

<p>Autori zdôrazňujú viacero mechanizmov, ktorými uropatogény unikajú účinku antimikrobiálnych liekov. Patria sem najmä:</p>

<ul>
  <li><strong>produkcia β-laktamáz</strong>, vrátane enzýmov schopných inaktivovať širokospektrálne β-laktámové antibiotiká,</li>
  <li><strong>modifikácia cieľových štruktúr</strong>, na ktoré sa antibiotikum viaže,</li>
  <li><strong>zmeny porínov</strong>, ktoré znižujú vstup antibiotika do bakteriálnej bunky,</li>
  <li><strong>aktivácia efluxných púmp</strong>, ktoré antibiotikum aktívne odstraňujú z bunky,</li>
  <li><strong>prepojenie rezistencie a virulencie</strong>, pri ktorom baktéria nie je iba odolnejšia voči liečbe, ale zároveň lepšie kolonizuje alebo poškodzuje hostiteľské tkanivo.</li>
</ul>

<p>Osobitne problematická je rozmanitosť β-laktamáz. Klinicky sa premieta do zlyhania bežnej empirickej liečby, potreby rýchlejšej mikrobiologickej diagnostiky a opatrnejšej interpretácie predchádzajúcich kultivačných nálezov. U pacienta s opakovanými IMC už nie je otázkou iba „aká baktéria“, ale aj „aký predchádzajúci rezistenčný vzorec a aká posledná antibiotická expozícia“.</p>

<h2>Kto je rizikový pacient</h2>

<p>Riziko rezistentnej IMC nie je rovnaké u všetkých pacientov. Vyššie riziko majú najmä pacienti:</p>

<ul>
  <li>po nedávnej alebo opakovanej antibiotickej liečbe,</li>
  <li>s recidivujúcimi infekciami močových ciest,</li>
  <li>s permanentným močovým katétrom alebo opakovanou katetrizáciou,</li>
  <li>s obštrukciou močových ciest, reziduálnym močom, refluxom alebo poruchou vyprázdňovania močového mechúra,</li>
  <li>s chronickou chorobou obličiek, diabetes mellitus alebo klinickou krehkosťou,</li>
  <li>po transplantácii obličky alebo pri inej významnej imunosupresii,</li>
  <li>po častých hospitalizáciách alebo pobyte v zariadeniach dlhodobej starostlivosti.</li>
</ul>

<p>V nefrologickej ambulancii sa tieto faktory často kumulujú. Pacient s diabetickou chorobou obličiek, zníženou eGFR, opakovanými hospitalizáciami a predchádzajúcou antibiotickou liečbou predstavuje úplne inú klinickú situáciu než mladý zdravý pacient s prvou nekomplikovanou cystitídou. Rovnaký kultivačný nález preto nemusí mať rovnaký klinický význam.</p>

<h2>Katétre, biofilm a transplantovaná oblička</h2>

<p>Katétrové infekcie močových ciest predstavujú osobitný problém. Katéter narúša prirodzené obranné mechanizmy, umožňuje tvorbu biofilmu a zvyšuje riziko kolonizácie rezistentnými baktériami. Biofilm znižuje účinnosť antibiotík, podporuje perzistenciu infekcie a často znemožňuje eradikáciu bez odstránenia alebo výmeny pomôcky.</p>

<p>U pacientov po transplantácii obličky je situácia ešte citlivejšia. Infekcia môže prebiehať atypicky, zápalová odpoveď je ovplyvnená imunosupresiou a nesprávne liečená pyelonefritída štepu môže ohroziť jeho funkciu. Zároveň treba zohľadniť liekové interakcie, nefrotoxicitu, riziko hyperkaliémie pri niektorých režimoch a potrebu úpravy dávkovania podľa aktuálnej funkcie obličiek.</p>

<p>Praktický dôsledok je jednoduchý: pri transplantovanom pacientovi, pri CKD s pokročilým poklesom eGFR alebo pri katétrovej IMC má mikrobiologická dokumentácia oveľa vyššiu hodnotu než pri nekomplikovanej cystitíde. Kultivácia pred antibiotikom, znalosť predchádzajúcej kolonizácie a následná deeskalácia sú kľúčové prvky bezpečnej liečby.</p>

<h2>Močový tok a farmakokinetika nie sú detaily</h2>

<p>Prehľadový článok pripomína, že prevalenciu rezistencie neovplyvňuje iba baktéria a antibiotikum, ale aj fyziológia močových ciest. Normálny prietok moču je významný ochranný mechanizmus. Stáza moču, reziduálny moč, obštrukcia, reflux alebo cudzie teleso v močových cestách zvyšujú riziko pretrvávania infekcie aj selekcie rezistentných kmeňov.</p>

<p>Dôležitá je aj farmakokinetika. Nie každé antibiotikum s dobrou sérovou aktivitou dosiahne primeranú koncentráciu v moči alebo v renálnom parenchýme. Pri pyelonefritíde a komplikovanej infekcii treba rozlišovať medzi liekom vhodným pre dolné močové cesty a liekom, ktorý spoľahlivo pôsobí v tkanive obličky. Pri CKD sa k tomu pridáva potreba upraviť dávku podľa eGFR, ale zároveň sa vyhnúť subterapeutickému dávkovaniu pri závažnej infekcii.</p>

<h2>Prečo nestačí „silnejšie antibiotikum“</h2>

<p>Riešením antimikrobiálnej rezistencie nemôže byť automatická eskalácia na širšie antibiotikum. Takýto reflex môže krátkodobo pôsobiť bezpečne, ale dlhodobo urýchľuje selekciu rezistentných baktérií a zužuje budúce možnosti liečby.</p>

<p>Racionálny prístup zahŕňa:</p>

<ul>
  <li>rozlíšenie kolonizácie, asymptomatickej bakteriúrie a skutočnej infekcie,</li>
  <li>vyhýbanie sa liečbe asymptomatickej bakteriúrie, ak nejde o jasnú indikáciu,</li>
  <li>odber močovej kultivácie pred liečbou pri komplikovaných infekciách, pyelonefritíde, katétroch, transplantácii alebo zlyhaní empirickej liečby,</li>
  <li>zohľadnenie predchádzajúcich kultivácií a lokálnych rezistenčných dát,</li>
  <li>úpravu dávky podľa eGFR a závažnosti infekcie,</li>
  <li>cielenú deeskaláciu po obdržaní citlivosti,</li>
  <li>odstránenie alebo výmenu katétra pri katétrovej infekcii,</li>
  <li>riešenie urologického faktora, ak infekciu udržiava obštrukcia, reziduum alebo cudzie teleso.</li>
</ul>

<p>Pre nefrológa je zvlášť dôležité vyhnúť sa zbytočne nefrotoxickej liečbe, ak existuje bezpečnejšia alternatíva, no zároveň neznížiť dávku natoľko, že pri ťažkej infekcii nedosiahne účinnú expozíciu. Dávkovanie pri CKD má byť presné, nie iba „opatrné“.</p>

<h2>Nové prístupy: predikcia rizika, peptidy a bakteriofágy</h2>

<p>Článok sa venuje aj inovatívnym možnostiam, ktoré môžu v budúcnosti pomôcť pri manažmente rezistentných IMC. Jednou z nich sú predikčné nástroje vrátane modelov umelej inteligencie. Tie by mohli pomôcť odhadnúť riziko rezistentného uropatogénu ešte pred výsledkom kultivácie a tým lepšie zvoliť empirickú liečbu u komplikovaných pacientov.</p>

<p>Ďalšou perspektívou sú antimikrobiálne peptidy. Ide o molekuly s mechanizmami účinku odlišnými od klasických antibiotických tried, teoreticky použiteľné najmä tam, kde bežné antibiotiká zlyhávajú alebo kde je potrebné znížiť selekčný tlak tradičných režimov.</p>

<p>Zaujímavou možnosťou je aj bakteriofágová liečba. Bakteriofágy sú vírusy schopné cielene napádať baktérie. Pri multirezistentných infekciách môžu predstavovať doplnkovú alebo alternatívnu stratégiu, ich širšie klinické využitie však vyžaduje štandardizáciu, kvalitné klinické dáta, dostupnú diagnostiku a jasné regulačné ukotvenie.</p>

<h2>Praktický nefrologický záver</h2>

<p>Pre nefrologickú prax je kľúčové hodnotiť IMC v kontexte konkrétneho pacienta. Iný prístup je potrebný pri prvej nekomplikovanej cystitíde, iný pri pacientovi s CKD, diabetom, katétrom, transplantovanou obličkou alebo opakovanou antibiotickou expozíciou.</p>

<p>Antimikrobiálna rezistencia pri IMC je výsledkom kombinácie mikrobiologických, klinických, farmakologických a anatomických faktorov. Nestačí poznať názov baktérie. Treba rozumieť pacientovi, jeho urologickému riziku, predchádzajúcej liečbe, funkcii obličiek a pravdepodobnosti rezistencie.</p>

<p>Najlepšou stratégiou nie je automaticky silnejšia liečba, ale presnejšia liečba: správna indikácia, správny odber kultivácie, správna dávka, primeraná dĺžka liečby a včasná deeskalácia. Pri rizikovom nefrologickom pacientovi treba rezistentnú IMC predvídať, ale antibiotikum používať cielene a racionálne.</p>

<h2>Záver</h2>

<p>Antimikrobiálna rezistencia pri infekciách močových ciest predstavuje rastúci klinický problém s priamym významom pre nefrológiu. Gramnegatívne uropatogény využívajú viaceré mechanizmy rezistencie a ich výskyt ovplyvňuje antibiotický tlak, močový tok, mikrobióm, katétre, komorbidity a farmakokinetika liečiv.</p>

<p>Budúcnosť manažmentu IMC pravdepodobne nebude stáť iba na nových antibiotikách. Potrebné budú presnejšie rizikové modely, lepšia antimikrobiálna stratégia, dôsledná prevencia katétrových infekcií a nové neantibiotické prístupy vrátane antimikrobiálnych peptidov a bakteriofágov.</p>

<hr>

<p><em><strong>Zdroj:</strong> von Vietinghoff S, Shevchuk O, Dobrindt U, Engel DR, Jorch SK, Kurts C, Miethke T, Wagenlehner F. The global burden of antimicrobial resistance – urinary tract infections. <em>Nephrology Dialysis Transplantation</em>. 2024;39(4):581–588. doi:10.1093/ndt/gfad233. <a href="https://academic.oup.com/ndt/article/39/4/581/7331453" target="_blank" rel="noopener noreferrer">Oxford Academic</a>.</em></p>
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
                error_log('add_amr_uti newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_amr_uti pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_amr_uti pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_amr_uti migration error: ' . $e->getMessage());
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
