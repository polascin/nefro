<?php
/**
 * add_wearables-chronicke-ochorenia-protokoly-klinicky-zmysel_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_wearables-chronicke-ochorenia-protokoly-klinicky-zmysel_article.php"
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
    'title'        => 'Wearables pri chronických ochoreniach: viac dát nestačí, rozhodujú protokoly a klinický zmysel',
    'slug'         => 'wearables-chronicke-ochorenia-protokoly-klinicky-zmysel',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nositeľné zariadenia majú pri chronických ochoreniach veľký potenciál, no samy osebe medicínu nezlepšia. Užitočným nástrojom sa stávajú až ako súčasť systému s validovanými meraniami, klinickými protokolmi, edukáciou pacienta a jasnou zodpovednosťou za reakciu na abnormality.',
    'content'      => <<<'HTML'
<p>Nositeľné zariadenia už nie sú iba doplnkom pre športovcov a technologických nadšencov. Smart hodinky, fitness náramky, kontinuálne glukózové senzory a ďalšie zariadenia dnes dokážu priebežne zbierať údaje o pulze, fyzickej aktivite, krvnom tlaku, saturácii kyslíka, teplote, spánku či glykemických trendoch. Pri chronických ochoreniach to otvára novú možnosť: sledovať pacienta nielen počas ambulantnej návštevy, ale aj v jeho bežnom živote.</p>

<p>Hlavné klinické posolstvo je však triezve. Wearable technológie majú veľký potenciál, ale samy osebe medicínu nezlepšia. Ak sa z nich má stať užitočný nástroj chronickej starostlivosti, musia byť súčasťou premysleného systému, ktorý zahŕňa edukáciu pacienta, validované merania, klinické protokoly, bezpečné spracovanie dát a jasnú zodpovednosť za reakciu na abnormality.</p>

<h2>Chronické ochorenia nie sú jedna kategória</h2>

<p>O chronických ochoreniach sa často hovorí ako o jednom veľkom bloku, ale z klinického hľadiska ide o veľmi rôznorodú skupinu. Nie každé ochorenie profituje z nositeľných technológií rovnako. Najväčší prínos sa ukazuje tam, kde má priebežné sledovanie fyziologických parametrov priamy vplyv na rozhodovanie.</p>

<p>Výrazný príklad predstavuje diabetes. Kontinuálne monitorovanie glukózy zásadne zmenilo spôsob, akým pacient aj lekár vnímajú glykemickú kontrolu. Namiesto izolovaného HbA1c alebo občasného merania glykémie máme k dispozícii trendy, čas v cieľovom rozmedzí, nočné hypoglykémie, postprandiálne výkyvy a reakcie na stravu, pohyb či liečbu.</p>

<p>Podobne veľký potenciál majú wearables pri kardiovaskulárnych ochoreniach, najmä pri srdcovom zlyhávaní, hypertenzii, fibrilácii predsiení a iných arytmiách. V respiračnej medicíne môžu pomáhať pri chronickej obštrukčnej chorobe pľúc a ďalších chronických pľúcnych ochoreniach. Sľubné oblasti zahŕňajú aj obezitu, chronickú chorobu obličiek, poruchy spánku a niektoré neurologické ochorenia.</p>

<h2>Najväčšia zmena je presun dát mimo ambulancie</h2>

<p>Tradičná medicína pracuje s údajmi získanými v konkrétnom čase a na konkrétnom mieste. Pacient príde do ambulancie, odmeria sa tlak, pulz, saturácia, hmotnosť, laboratóriá, lekár sa opýta na ťažkosti a na základe toho upraví liečbu. Tento model má svoje limity. Zachytí len malý výsek reality.</p>

<p>Wearables menia situáciu tým, že prinášajú údaje z každodenného života. Pri srdcovom zlyhávaní môže byť dôležité, ako sa mení fyzická kapacita, pokojová frekvencia, spánok alebo tolerancia záťaže. Pri diabetikovi môžu dáta ukázať, kedy vznikajú hypoglykémie alebo ako konkrétne jedlo ovplyvňuje glykemický profil. Pri respiračnom ochorení môže byť dôležitá saturácia, aktivita alebo zhoršovanie tolerancie námahy.</p>

<p>To môže podporiť skorší záchyt zhoršenia, lepšiu prevenciu dekompenzácií a kontinuálnejší kontakt medzi pacientom a zdravotníckym systémom.</p>

<h2>Dôkazy pribúdajú, ale nie sú rovnaké pre všetky použitia</h2>

<p>Systematický prehľad publikovaný v časopise <em>JMIR mHealth and uHealth</em> uvádza, že nositeľné zariadenia dokážu zbierať údaje o fyzickej aktivite, srdcovej frekvencii, telesnej teplote, krvnom tlaku a periférnej saturácii kyslíka. Tieto dáta môžu podporiť sledovanie neurologických a kardiovaskulárnych parametrov.</p>

<p>Pri diabete pribúdajú dôkazy, že kombinácia digitálnej edukácie a podpory self-manažmentu s kontinuálnym monitorovaním glukózy môže pomôcť dospelým s diabetom 2. typu lepšie zvládať ochorenie a potenciálne znižovať riziko dlhodobých komplikácií.</p>

<p>Pri srdcovom zlyhávaní sa objavujú údaje, že smart hodinky môžu podporiť diaľkové sledovanie exacerbácií. Dáta zo spotrebiteľských nositeľných zariadení pri každodenných aktivitách vykazovali dobrú zhodu s meraniami z kardiopulmonálneho záťažového testovania, čo naznačuje potenciál na odhad kardiorespiračnej zdatnosti a monitorovanie pacienta na diaľku.</p>

<p>Treba však povedať jasne: potenciál nie je to isté ako univerzálne odporúčanie. Validita zariadení, presnosť merania, klinická interpretácia a spôsob použitia sa líšia podľa diagnózy, parametra aj konkrétneho zariadenia.</p>

<h2>Problémom už nie je len zber dát, ale ich význam</h2>

<p>Wearable zariadenia môžu podľa citovaných údajov generovať viac než 5 GB dát na pacienta týždenne. To je obrovské množstvo informácií, ktoré žiadny lekár nemôže ručne prechádzať v bežnej ambulantnej praxi.</p>

<p>Tu vstupuje do hry umelá inteligencia. Moderné metódy, najmä hlboké učenie, môžu pomáhať rozpoznávať vzorce, biomarkerové podpisy a rizikové trendy. V ideálnom prípade by systém nemal lekára zaplavovať tisíckami dátových bodov, ale upozorniť ho na klinicky relevantnú zmenu: rastúce riziko dekompenzácie, podozrenie na arytmiu, zhoršenie tolerancie záťaže alebo opakované hypoglykémie.</p>

<p>Umelá inteligencia však nie je magické riešenie. Ak sú vstupné dáta nekvalitné, nevalidované alebo zle interpretované, algoritmus môže vytvárať falošné poplachy alebo prehliadnuť dôležitý signál. Preto musia byť algoritmy testované, transparentne hodnotené a zapojené do klinických protokolov.</p>

<h2>Wearable bez stratégie je len drahý zberač dát</h2>

<p>Kľúčová myšlienka článku je praktická: nestačí dať pacientovi zariadenie a považovať problém za vyriešený. Nositeľné technológie sú užitočné vtedy, keď sú súčasťou multidisciplinárnej stratégie.</p>

<p>Táto stratégia musí obsahovať aspoň štyri prvky:</p>

<ul>
  <li>pacient musí vedieť, čo zariadenie meria a čo nemeria,</li>
  <li>tím musí vedieť, ktoré hodnoty sú klinicky relevantné,</li>
  <li>musí existovať protokol, kto reaguje na odchýlky,</li>
  <li>dáta musia byť integrované do zdravotnej starostlivosti, nie uložené v izolovanej aplikácii.</li>
</ul>

<p>Ak tieto podmienky chýbajú, vznikne problém. Pacient môže byť úzkostný z každého výkyvu, lekár môže byť zahltený nerelevantnými upozorneniami a zdravotnícky systém môže niesť zodpovednosť za dáta, ktoré reálne nikto systematicky nesleduje.</p>

<h2>Bezpečnosť, interoperabilita a zodpovednosť</h2>

<p>Ďalšou výzvou je interoperabilita. Dáta z rôznych zariadení, aplikácií a platforiem musia byť použiteľné v klinickom systéme. Ak ostanú mimo zdravotnej dokumentácie alebo v neprehľadných exportoch, ich praktická hodnota je obmedzená.</p>

<p>Rovnako dôležitá je bezpečnosť dát. Wearables pracujú s citlivými zdravotnými údajmi. Preto nestačí technické nadšenie. Potrebné sú pravidlá pre ochranu súkromia, súhlas pacienta, zdieľanie údajov a určenie zodpovednosti.</p>

<p>Klinicky zásadná je aj otázka reakcie. Ak systém zachytí možnú dekompenzáciu srdcového zlyhávania alebo závažnú arytmiu, kto má konať? Praktický lekár, špecialista, telemonitoringové centrum, urgentná služba alebo samotný pacient podľa vopred daného návodu? Bez odpovede na túto otázku môže byť aj veľmi presné meranie organizačne nebezpečné.</p>

<h2>Význam pre chronickú chorobu obličiek</h2>

<p>Chronická choroba obličiek sa v článku spomína ako jedna z oblastí, kde môžu mať wearables potenciál. Treba však rozlišovať. Samotné hodinky nezmerajú eGFR ani albuminúriu. Môžu však nepriamo pomáhať sledovať parametre, ktoré sú pre pacienta s CKD dôležité: krvný tlak, fyzickú aktivitu, pulz, spánok, hmotnosť alebo prípadne saturáciu kyslíka pri komorbiditách.</p>

<p>U dialyzovaných pacientov by teoreticky mohli byť dôležité aj trendy medzi dialýzami, napríklad tolerancia záťaže, nočné symptómy, srdcová frekvencia alebo arytmie. Zatiaľ však treba byť opatrný. Kým neexistujú jasné validované protokoly, wearables môžu byť doplnkom sledovania, nie náhradou klinického vyšetrenia, laboratórií, merania tlaku a posúdenia objemového stavu.</p>

<h2>Praktický klinický záver</h2>

<p>Wearables prinášajú medicíne veľkú príležitosť: vidieť pacienta nielen v ambulancii, ale aj v každodennom živote. Najväčší potenciál majú pri diabete, srdcovom zlyhávaní, arytmiách, hypertenzii, respiračných ochoreniach, obezite, poruchách spánku a vybraných neurologických stavoch.</p>

<p>Zároveň platí, že viac dát automaticky neznamená lepšiu starostlivosť. Rozhodujú validované zariadenia, správna interpretácia, klinické protokoly, edukácia pacienta, bezpečné spracovanie údajov a jasné určenie, kto má na rizikové signály reagovať.</p>

<p>Najrozumnejší prístup je preto pragmatický: používať wearables tam, kde majú konkrétny klinický cieľ, a nenechať sa uniesť predstavou, že samotná technológia vyrieši chronickú starostlivosť. Technológia môže byť veľmi užitočný nástroj, ale medicínsky zmysel jej dáva až dobre organizovaný systém starostlivosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Wearables Generate Data. What’s Next for Chronic Care?</em> (2026). <a href="https://www.medscape.com/viewarticle/wearables-generate-data-whats-next-chronic-care-2026a1000j4l" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
