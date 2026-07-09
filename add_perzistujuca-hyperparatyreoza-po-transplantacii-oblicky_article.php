<?php
/**
 * add_perzistujuca-hyperparatyreoza-po-transplantacii-oblicky_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: Perzistujúca hyperparatyreóza po transplantácii obličky
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_perzistujuca-hyperparatyreoza-po-transplantacii-oblicky_article.php"
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

$articles = [];

$articles[] = [
    'title'        => 'Perzistujúca hyperparatyreóza po transplantácii obličky ako rizikový marker mortality a zlyhania štepu',
    'slug'         => 'perzistujuca-hyperparatyreoza-po-transplantacii-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Metaanalýza v Clinical Kidney Journal ukazuje, že perzistujúca posttransplantačná hyperparatyreóza je konzistentným rizikovým markerom mortality a zlyhania štepu.',
    'content'      => <<<'HTML'
<p>Hyperparatyreóza patrí medzi najčastejšie prejavy poruchy minerálovo-kostného metabolizmu pri chronickej chorobe obličiek. U časti pacientov pretrváva aj po úspešnej transplantácii obličky. Klinicky nejde len o laboratórnu odchýlku: pretrvávajúca posttransplantačná hyperparatyreóza môže byť spojená s hyperkalcémiou, hypofosfatémiou, kostnými komplikáciami, vaskulárnou kalcifikáciou a potenciálne aj horšími výsledkami štepu.</p>

<p>Systematický prehľad a metaanalýza publikovaná v <em>Clinical Kidney Journal</em> hodnotili, či hyperparatyreóza pred transplantáciou a perzistujúca hyperparatyreóza po transplantácii súvisia s mortalitou a výsledkami transplantovanej obličky. Téma je prakticky dôležitá, pretože definície posttransplantačnej hyperparatyreózy nie sú jednotné a rozhodovanie o liečbe, vrátane cinakalcetu alebo paratyreoidektómie, zostáva v mnohých situáciách nejednoznačné.</p>

<h2>Prečo môže hyperparatyreóza pretrvávať aj po transplantácii</h2>

<p>Po úspešnej transplantácii sa zvyčajne zlepší fosfátová retencia, metabolizmus vitamínu D aj uremické prostredie, ktoré pred transplantáciou podporovalo sekundárnu hyperparatyreózu. Napriek tomu u časti pacientov pretrváva zvýšená sekrécia parathormónu.</p>

<p>Dôvodom býva dlhodobá stimulácia prištítnych teliesok počas chronickej choroby obličiek, difúzna alebo nodulárna hyperplázia a pri pokročilých formách aj znížená citlivosť na regulačné mechanizmy. V takom prípade transplantácia samotná nemusí viesť k úplnej normalizácii funkcie prištítnych teliesok. Klinicky sa tento stav často označuje ako <strong>perzistujúca posttransplantačná hyperparatyreóza</strong>; pri hyperkalcémii sa v praxi používa aj pojem terciárna hyperparatyreóza.</p>

<h2>Cieľ systematického prehľadu a metaanalýzy</h2>

<p>Autori analyzovali observačné štúdie u dospelých príjemcov transplantovanej obličky. Hodnotili vplyv predtransplantačnej hyperparatyreózy, perzistujúcej posttransplantačnej hyperparatyreózy a hladín parathormónu hodnotených kategoricky alebo kontinuálne.</p>

<p>Sledované výsledky zahŕňali:</p>

<ul>
  <li>celkovú mortalitu,</li>
  <li>celkové zlyhanie štepu,</li>
  <li>zlyhanie štepu cenzorované na úmrtie pacienta.</li>
</ul>

<p>Metaanalýza bola vykonaná v súlade s metodikou PRISMA 2020 a protokol bol registrovaný v databáze PROSPERO pod číslom CRD420261293712. Autori prehľadali databázy PubMed/MEDLINE a Embase od ich vzniku do 9. februára 2026. Riziko skreslenia hodnotili pomocou nástroja QUIPS.</p>

<h2>Rozsah analyzovaných údajov</h2>

<p>Do systematického prehľadu bolo zaradených <strong>23 štúdií</strong>. Do metaanalýz prispelo <strong>19 štúdií</strong> s celkovým počtom <strong>26 266 príjemcov transplantovanej obličky</strong>.</p>

<p>Z toho 3 štúdie hodnotili predtransplantačnú hyperparatyreózu u 12 819 pacientov a 16 štúdií hodnotilo posttransplantačnú hyperparatyreózu u 13 447 pacientov. Ide teda o pomerne rozsiahly súbor observačných údajov. Zároveň platí, že ani veľká metaanalýza observačných štúdií sama osebe nedokazuje kauzalitu.</p>

<h2>Predtransplantačná hyperparatyreóza: neistý prognostický význam</h2>

<p>Predtransplantačná hyperparatyreóza nebola v metaanalýze spojená so zvýšenou celkovou mortalitou. Uvádzaný pomer rizík pre mortalitu bol HR 0,80, čo nenaznačuje jednoznačný nepriaznivý vplyv.</p>

<p>Pri zlyhaní štepu cenzorovanom na úmrtie sa v hlavnej analýze objavila asociácia s vyšším rizikom, HR 1,42. Táto asociácia však stratila štatistickú významnosť po použití Hartungovej-Knappovej citlivostnej úpravy.</p>

<p>Praktický záver je preto opatrný: samotná zvýšená hladina parathormónu pred transplantáciou môže byť rizikovým signálom, ale dostupné údaje nie sú dostatočne robustné na jednoznačné tvrdenie, že predtransplantačná hyperparatyreóza samostatne predpovedá horšie výsledky po transplantácii.</p>

<h2>Perzistujúca posttransplantačná hyperparatyreóza: konzistentný rizikový marker</h2>

<p>Najdôležitejším zistením metaanalýzy je, že <strong>perzistujúca hyperparatyreóza po transplantácii</strong> bola konzistentne spojená s nepriaznivými výsledkami.</p>

<p>Pri kategorickom hodnotení bola spojená so zvýšeným rizikom:</p>

<ul>
  <li>celkovej mortality, HR 1,74,</li>
  <li>celkového zlyhania štepu, HR 2,16,</li>
  <li>zlyhania štepu cenzorovaného na úmrtie, HR 1,92.</li>
</ul>

<p>Tieto výsledky zostali konzistentné aj pri Hartungovej-Knappovej citlivostnej analýze. Zvyšuje to dôveryhodnosť záveru, že perzistujúca hyperparatyreóza po transplantácii nie je iba nepodstatná biochemická abnormalita, ale klinicky relevantný rizikový marker.</p>

<h2>Normokalcemická verzus hyperkalcemická forma</h2>

<p>Zaujímavým výsledkom bola analýza podľa fenotypu hyperparatyreózy. Autori pozorovali gradient rizika zlyhania štepu: pri normokalcemickej hyperparatyreóze bolo HR 1,66, kým pri hyperkalcemickej hyperparatyreóze bolo HR 2,67.</p>

<p>Tento gradient je klinicky dôležitý. Naznačuje, že najvyššie riziko môže mať skupina pacientov s pretrvávajúcou zvýšenou hladinou parathormónu a súčasnou hyperkalcémiou. Zároveň však ani normokalcemická hyperparatyreóza nemusí byť úplne benígny stav.</p>

<p>Pre nefrológa to znamená, že po transplantácii nestačí sledovať iba kreatinín a hladiny imunosupresív. Súčasťou dlhodobého sledovania má byť aj kalcium, fosfát, parathormón, vitamín D, alkalická fosfatáza a celkové hodnotenie CKD-MBD profilu.</p>

<h2>Možné mechanizmy poškodenia štepu</h2>

<p>Mechanizmy, ktorými môže perzistujúca hyperparatyreóza nepriaznivo ovplyvňovať transplantovanú obličku, nie sú definitívne objasnené. Pravdepodobne nejde o jeden izolovaný mechanizmus.</p>

<p>Možné vysvetlenia zahŕňajú:</p>

<ul>
  <li>hyperkalcémiu a riziko kalcium-fosfátových depozitov v štepe,</li>
  <li>tubulointersticiálne poškodenie pri poruche minerálového metabolizmu,</li>
  <li>vplyv PTH a FGF23 na kardiovaskulárny systém,</li>
  <li>podporu vaskulárnej kalcifikácie,</li>
  <li>horší kostný metabolizmus a vyššie riziko fraktúr,</li>
  <li>nepriamu súvislosť s dlhším trvaním dialýzy a ťažšou predtransplantačnou CKD-MBD záťažou.</li>
</ul>

<p>Dôležité je rozlišovať, či je hyperparatyreóza priamo kauzálnym faktorom, alebo skôr markerom celkovo nepriaznivého metabolického a vaskulárneho profilu pacienta. Táto metaanalýza podporuje jej prognostický význam, ale definitívne nepotvrdzuje, že liečba hyperparatyreózy automaticky zlepší prežívanie štepu.</p>

<h2>Klinické dôsledky pre transplantovaného pacienta</h2>

<p>Výsledky podporujú aktívne sledovanie minerálovo-kostného metabolizmu po transplantácii. Pacienti s pretrvávajúcou hyperparatyreózou by nemali byť ponechaní bez systematického hodnotenia len preto, že majú funkčný štep.</p>

<p>V praxi je vhodné sledovať najmä:</p>

<ul>
  <li>trend PTH po transplantácii,</li>
  <li>sérové kalcium a fosfát,</li>
  <li>25-OH vitamín D,</li>
  <li>renálnu funkciu a proteinúriu,</li>
  <li>kostné komplikácie a príznaky hyperkalcémie,</li>
  <li>sonografický alebo scintigrafický obraz prištítnych teliesok, ak je indikovaný.</li>
</ul>

<p>Osobitnú pozornosť si zaslúžia pacienti s hyperkalcémiou, výrazne zvýšeným PTH, pretrvávaním poruchy aj po prvom roku od transplantácie, zhoršovaním funkcie štepu, nefrokalcinózou, fraktúrami alebo ťažkou predtransplantačnou sekundárnou hyperparatyreózou.</p>

<h2>Liečebné možnosti: cinakalcet alebo paratyreoidektómia</h2>

<p>Liečba perzistujúcej hyperparatyreózy po transplantácii musí byť individualizovaná. Konzervatívny postup môže zahŕňať korekciu deficitu vitamínu D, sledovanie kalciofosfátového metabolizmu, úpravu liekov a režimové opatrenia.</p>

<p>Pri závažnejšej alebo hyperkalcemickej forme sa zvažuje <strong>cinakalcet</strong> alebo <strong>paratyreoidektómia</strong>. Cinakalcet môže znížiť kalcium a PTH, no otázka jeho dlhodobého vplyvu na prežívanie štepu a tvrdé klinické výsledky zostáva nedoriešená.</p>

<p>Paratyreoidektómia môže byť účinná najmä pri nodulárnej hyperplázii a refraktérnej hyperkalcemickej hyperparatyreóze. Na druhej strane ide o chirurgický výkon s vlastnými rizikami vrátane hypokalcémie a syndrómu hladnej kosti. Indikácia má byť preto starostlivo zvážená v spolupráci nefrológa, transplantačného centra, endokrinológa a skúseného chirurga.</p>

<h2>Čo výsledky nehovoria</h2>

<p>Metaanalýza nepreukazuje, že každé zvýšenie PTH po transplantácii musí byť okamžite agresívne liečené. Neurčuje ani jednotnú cieľovú hladinu PTH pre všetkých transplantovaných pacientov.</p>

<p>Autori upozorňujú, že kontinuálne analýzy PTH vykazovali značnú heterogenitu a neboli robustné v citlivostných analýzach. Samotná číselná hodnota PTH bez kontextu preto nemusí byť spoľahlivým univerzálnym prognostickým nástrojom.</p>

<p>Rozhodovanie má zohľadniť čas od transplantácie, dynamiku PTH, prítomnosť hyperkalcémie, hladinu fosfátu, funkciu štepu, klinické komplikácie, predtransplantačný priebeh CKD-MBD, predchádzajúcu liečbu a celkové riziko pacienta.</p>

<h2>Limity dostupných dôkazov</h2>

<p>Hlavným limitom je observačný charakter zaradených štúdií. Aj pri veľkom počte pacientov zostáva riziko reziduálneho skreslenia. Pacienti s perzistujúcou hyperparatyreózou sa môžu od ostatných líšiť dĺžkou dialyzačnej liečby, závažnosťou CKD-MBD, vekom, komorbiditami, typom darcu, imunosupresívnym režimom alebo kvalitou posttransplantačného sledovania.</p>

<p>Ďalším problémom je nejednotná definícia hyperparatyreózy. Štúdie používali rôzne prahové hodnoty PTH, rôzne časové body merania a odlišne zohľadňovali kalcium. To komplikuje priame porovnávanie výsledkov.</p>

<p>Metaanalýza preto poskytuje silný prognostický signál, nie však definitívny dôkaz kauzality ani jednoznačný terapeutický algoritmus.</p>

<h2>Praktické odporúčanie pre nefrologickú prax</h2>

<p>Z hľadiska klinickej praxe je rozumné vnímať perzistujúcu hyperparatyreózu po transplantácii ako rizikový marker, ktorý si vyžaduje aktívne sledovanie a individuálne riešenie.</p>

<p>Najpraktickejší prístup možno zhrnúť takto:</p>

<ul>
  <li>pred transplantáciou identifikovať pacientov s ťažkou sekundárnou hyperparatyreózou,</li>
  <li>po transplantácii pravidelne sledovať PTH, kalcium a fosfát,</li>
  <li>nehodnotiť PTH izolovane, ale vždy spolu s kalciom, fosfátom a funkciou štepu,</li>
  <li>venovať zvýšenú pozornosť hyperkalcemickej forme,</li>
  <li>pri pretrvávaní poruchy konzultovať transplantačné centrum a podľa potreby endokrinológa,</li>
  <li>pri refraktérnej hyperkalcemickej hyperparatyreóze zvážiť paratyreoidektómiu,</li>
  <li>podporovať prospektívne štúdie, ktoré ukážu, či liečba zlepší tvrdé klinické výsledky.</li>
</ul>

<h2>Záver</h2>

<p>Perzistujúca hyperparatyreóza po transplantácii obličky je podľa tejto systematickej metaanalýzy konzistentne spojená s vyššou mortalitou a horšími výsledkami štepu. Najvyššie riziko sa zdá byť pri hyperkalcemickej forme, ale ani normokalcemická hyperparatyreóza nemusí byť bez klinického významu.</p>

<p>Predtransplantačná hyperparatyreóza má menej jednoznačný prognostický význam. Výsledky naznačujú potrebu lepšej štandardizácie definícií, jednotného sledovania a prospektívnych štúdií, ktoré rozlíšia, či je hyperparatyreóza po transplantácii iba markerom rizika, alebo aj modifikovateľným terapeutickým cieľom.</p>

<p>Pre nefrológa je hlavné posolstvo praktické: po transplantácii obličky treba minerálovo-kostný metabolizmus sledovať systematicky a dlhodobo. Funkčný štep neznamená automaticky vyriešenú CKD-MBD poruchu.</p>

<hr>

<p><em><strong>Zdroj:</strong> Vetrano D, Barbuto S, Aguanno F, Mastromauro P, Grandinetti V, Comai G, La Manna G, Cianciolo G. Pre-transplant and persistent post-transplant hyperparathyroidism and kidney transplant outcomes: a systematic review and meta-analysis. <em>Clinical Kidney Journal</em>. 2026;19(7):sfag205. Publikované online 15. júna 2026. DOI: <a href="https://doi.org/10.1093/ckj/sfag205" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag205</a>. PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/42389195/" target="_blank" rel="noopener noreferrer">42389195</a>.</em></p>
HTML,
];

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

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
