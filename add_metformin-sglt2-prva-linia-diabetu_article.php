<?php
/**
 * add_metformin-sglt2-prva-linia-diabetu_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku o metformíne s predĺženým uvoľňovaním
 * a inhibítore SGLT2 v prvej línii liečby diabetu 2. typu (NICE / Medscape).
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
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
    'title'        => 'Metformín s predĺženým uvoľňovaním a inhibítor SGLT2 ako nová prvá línia liečby diabetu 2. typu',
    'slug'         => 'metformin-sglt2-prva-linia-diabetu-2-typu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Aktualizované odporúčanie NICE posúva liečbu diabetu 2. typu ku kardiorenálnej ochrane: metformín s predĺženým uvoľňovaním plus inhibítor SGLT2 v prvej línii u väčšiny pacientov, nasadzované postupne.',
    'content'      => <<<'HTML'
<p>Liečba diabetu 2. typu sa posúva od úzkeho zamerania na glykémiu k širšiemu prístupu, ktorý berie do úvahy kardiovaskulárne, renálne a metabolické riziko pacienta. Tento posun dobre ilustruje aktualizované odporúčanie britského <strong>National Institute for Health and Care Excellence</strong>, známeho ako NICE.</p>

<p>Podľa správy publikovanej na portáli Medscape by u väčšiny ľudí s diabetom 2. typu mala byť liečba začatá <strong>metformínom s predĺženým uvoľňovaním</strong> a následne doplnená o <strong>inhibítor SGLT2</strong>. Ide o zmenu, ktorá môže mať významný dopad na každodennú klinickú prax.</p>

<h2>Prečo metformín s predĺženým uvoľňovaním</h2>

<p>Metformín patrí už roky medzi základné lieky diabetu 2. typu. Tradične sa často používala forma s okamžitým uvoľňovaním. Aktualizované odporúčanie NICE však uprednostňuje formu s predĺženým, respektíve modifikovaným uvoľňovaním.</p>

<p>Dôvod je praktický. Metformín s predĺženým uvoľňovaním môže mať menej gastrointestinálnych nežiaducich účinkov, najmä menej nevoľnosti, hnačiek, nafukovania a brušného diskomfortu. To môže zlepšiť toleranciu liečby a tým aj adherenciu pacienta.</p>

<p>Dôležité je, že nejde o tvrdenie, že bežný metformín prestal byť účinný alebo vhodný. Ak pacient užíva štandardný metformín, dobre ho toleruje a dosahuje dobrú kontrolu ochorenia, nie je automaticky potrebné liečbu meniť. Zmena má zmysel najmä pri intolerancii, zlej adherencii alebo pri začatí novej liečby podľa aktuálneho algoritmu.</p>

<h2>Prečo pridať inhibítor SGLT2</h2>

<p>Inhibítory SGLT2 sa pôvodne vnímali najmä ako antidiabetiká, ktoré znižujú glykémiu zvýšeným vylučovaním glukózy močom. Dnes je ich význam širší.</p>

<p>Veľké klinické štúdie ukázali, že táto skupina liekov má dôležité <strong>kardiovaskulárne a renálne prínosy</strong>. U vhodne vybraných pacientov môžu znižovať riziko hospitalizácie pre srdcové zlyhávanie, spomaľovať progresiu chronickej choroby obličiek a priaznivo ovplyvňovať kardiometabolické riziko.</p>

<p>Práve preto sa inhibítory SGLT2 dostávajú v odporúčaniach čoraz skôr do liečebného algoritmu. Nejde iba o lieky na zníženie cukru v krvi. Sú súčasťou modernej kardiorenálno-metabolickej ochrany.</p>

<h2>Nie je to iba „liečba cukru“</h2>

<p>Podľa odborníkov citovaných v článku Medscape sa manažment diabetu 2. typu mení. Starší prístup sa sústreďoval najmä na dosiahnutie cieľovej hodnoty HbA1c. Novší prístup je komplexnejší.</p>

<p>Cieľom liečby je:</p>

<ul>
  <li>predchádzať mikrovaskulárnym a makrovaskulárnym komplikáciám,</li>
  <li>chrániť srdce a obličky,</li>
  <li>ovplyvniť telesnú hmotnosť,</li>
  <li>znižovať riziko hypoglykémie,</li>
  <li>zlepšiť kvalitu života,</li>
  <li>prispôsobiť liečbu konkrétnemu pacientovi.</li>
</ul>

<p>Tento pohľad je zvlášť dôležitý pre pacientov s chronickou chorobou obličiek, srdcovým zlyhávaním, aterosklerotickým kardiovaskulárnym ochorením alebo obezitou. Pri nich môže byť výber antidiabetickej liečby rozhodujúci nielen pre glykémiu, ale aj pre dlhodobú prognózu.</p>

<h2>Liečba sa má začínať postupne</h2>

<p>Jedným z praktických bodov aktualizovaného odporúčania je, že lieky sa nemajú začínať všetky naraz. Odporúča sa postupný prístup.</p>

<p>Najskôr sa začne jedna liečba, dávka sa titruje na najvyššiu tolerovanú dávku a až potom sa pridáva ďalší liek. Tento postup umožňuje lepšie posúdiť účinnosť, toleranciu a nežiaduce účinky jednotlivých liekov.</p>

<p>V praxi to znamená, že ani kombinácia metformínu s predĺženým uvoľňovaním a inhibítora SGLT2 sa nemá chápať ako nekritické nasadenie dvoch nových liekov v jeden deň. Rozhodnutie má byť individualizované a pacient má byť do rozhodovania aktívne zapojený.</p>

<h2>Kedy treba byť opatrný</h2>

<p>Ani nové odporúčania neznamenajú, že inhibítor SGLT2 je vhodný pre každého pacienta. Pred nasadením treba zohľadniť kontraindikácie, renálne funkcie, riziko dehydratácie, infekcií urogenitálneho traktu, ketoacidózy a celkový klinický stav.</p>

<p>Pri chronickej chorobe obličiek sa v odporúčaní NICE spomína hranica odhadovanej glomerulovej filtrácie nad <strong>30 ml/min/1,73 m²</strong>. U krehkých pacientov treba osobitne posúdiť pomer prínosu a rizika. Dôležitá je aj edukácia pacienta, najmä pri akútnom ochorení, zníženom príjme tekutín, vracaní, hnačke alebo pred plánovaným operačným výkonom.</p>

<p>V týchto situáciách môže byť potrebné dočasné prerušenie liečby inhibítorom SGLT2 podľa lokálnych odporúčaní a klinického posúdenia.</p>

<h2>Čo pri aterosklerotickom kardiovaskulárnom ochorení</h2>

<p>Aktualizované odporúčanie NICE ide ešte ďalej pri pacientoch s diabetom 2. typu a aterosklerotickým kardiovaskulárnym ochorením. U tejto skupiny odporúča trojkombináciu:</p>

<ul>
  <li>metformín s predĺženým uvoľňovaním,</li>
  <li>inhibítor SGLT2,</li>
  <li>subkutánny semaglutid v dávke do 1 mg týždenne.</li>
</ul>

<p>Aj tu platí, že liečba sa má začínať postupne a nie naraz. Zaujímavé je, že NICE v tomto prípade prvýkrát odporúča konkrétny liek, nie iba celú liekovú skupinu.</p>

<p>Agonisty receptora GLP-1 alebo tirzepatid majú svoje miesto aj pri skorom nástupe diabetu 2. typu a pri obezite, najmä ak sa nedosiahnu glykemické ciele po úvodnej liečbe a po dostatočnom čase na zhodnotenie účinku.</p>

<h2>Pacient nemá mať pocit zlyhania</h2>

<p>Diabetes 2. typu je progresívne ochorenie. Mnohí pacienti budú časom potrebovať intenzifikáciu liečby, niekedy aj inzulín. To neznamená, že pacient „zlyhal“. Znamená to, že ochorenie sa biologicky vyvíja a liečbu treba prispôsobiť jeho aktuálnemu stavu.</p>

<p>Otvorená komunikácia je preto kľúčová. Pacient má rozumieť, prečo sa liek pridáva, aký má očakávaný prínos, aké sú riziká a kedy má vyhľadať lekára.</p>

<h2>Praktický záver</h2>

<p>Aktualizované odporúčanie NICE potvrdzuje trend, ktorý je v modernej diabetológii čoraz zreteľnejší: liečba diabetu 2. typu už nie je iba liečbou hyperglykémie. Je to prevencia komplikácií, ochrana srdca a obličiek, manažment telesnej hmotnosti a znižovanie celkového kardiometabolického rizika.</p>

<p>Metformín s predĺženým uvoľňovaním a inhibítor SGLT2 sa podľa NICE dostávajú do prvej línie u väčšiny pacientov s diabetom 2. typu. Vhodnosť takejto liečby však musí vždy posúdiť lekár podľa konkrétneho pacienta, jeho obličkových funkcií, komorbidít, tolerancie liečby a rizika nežiaducich účinkov.</p>

<p>Pre nefrologickú prax je toto odporúčanie obzvlášť dôležité. Potvrdzuje, že pri diabete 2. typu treba od začiatku myslieť kardiorenálne, nie až vtedy, keď sa objaví pokročilá chronická choroba obličiek alebo srdcové zlyhávanie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, „MR Metformin and SGLT2i Now First-Line for Type 2 Diabetes“. <a href="https://www.medscape.com/viewarticle/mr-metformin-and-sglt2i-now-first-line-type-2-diabetes-2026a1000h4s" target="_blank" rel="noopener noreferrer">medscape.com</a>.</em></p>
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
