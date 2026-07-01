<?php
/**
 * add_glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie/aktualizácia článku do DB (UPSERT → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia_article.php"
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
    'title'        => 'Éra GLP-1 si žiada nový model starostlivosti o obezitu (a čo z toho plynie pre nefrológiu)',
    'slug'         => 'glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Medscape upozorňuje, že samotný recept na agonisty GLP-1 receptorov nestačí. Obezita je chronické metabolické ochorenie s relapsom po vysadení a vyžaduje dlhodobý program: metabolické ciele, výživu a svaly, kontinuitu aj riešenie bariér prístupu. Pre nefrológiu jasný signál o kardiometabolickom riziku.',
    'content'      => <<<'HTML'
<p>Tlak na predpisovanie agonistov GLP-1 receptorov (GLP-1 RA) sa v posledných mesiacoch a rokoch výrazne zrýchlil. Medscape však v kontexte konferencie HLTH Europe 2026 upozorňuje na problém, ktorý je väčší než samotný liek: medzi tým, čo pacienti spravidla potrebujú dlhodobo, tým, ako je nastavená zdravotnícka infraštruktúra, a tým, ako spoločnosť vníma obezitu, vznikol výrazný nesúlad.</p>

<p>Ak chceme z liečby GLP-1 RA získať reálne a udržateľné metabolické benefity, nestačí „napísať recept“. Potrebujeme nový model chronickej starostlivosti o obezitu, ktorý bude riešiť správanie, výživu, udržanie svalovej hmoty, adherenciu aj bariéry prístupu.</p>

<h2>Už nejde len o redukciu hmotnosti</h2>

<p>Panelisti sa zhodli, že klinický príbeh sa mení. Zameranie sa posúva od samotného poklesu hmotnosti ku komplexnej stratégii „metabolického zdravia“.</p>

<p>Prakticky to znamená, že v ordinácii už nejde iba o energetický deficit. Dôležitou otázkou je, ako pacientom pomôcť udržať adekvátnu výživu — dostatok vlákniny a bielkovín — a zároveň aktívne pracovať na retencii svalov a kvalite telesnej kompozície. Ako zdôraznila Kim Boyd (MD), v prostredí „sveta GLP-1“ treba správanie a životný štýl prispôsobiť tomu, čo je pre úspech naozaj podstatné.</p>

<p>Z nefrologického pohľadu je to dôležité dvojnásobne. U mnohých pacientov sa obezita premieta do kardiometabolického rizika, ktoré následne zvyšuje pravdepodobnosť progresie chronických ochorení obličiek alebo komplikuje ich manažment. Ak redukcia hmotnosti prebieha bez pozornosti venovanej svalovej hmote, môže zhoršiť funkčnú rezervu, toleranciu ochorenia a celkový zdravotný stav.</p>

<h2>Bariéry prístupu nie sú len logistické</h2>

<p>Medscape opisuje tri typické brzdy širšieho využívania GLP-1 RA.</p>

<p>Prvou je stigma. Dennis Ballwieser (MD) upozornil, že obezita je v niektorých systémoch právne aj kultúrne rámcovaná ako „výber životného štýlu“, a nie ako chronické ochorenie. Takýto rámec mení správanie pacientov, obmedzuje ochotu lekárov a znižuje šancu, že sa terapia bude poskytovať konzistentne a dlhodobo.</p>

<p>Druhou brzdou je dostupnosť. Panelisti diskutovali o situáciách, keď časť pacientov môže narážať na obmedzenia štandardnej verejnej starostlivosti, zatiaľ čo iní si liečbu riešia súkromne.</p>

<p>Treťou je ekonomika. V článku sa uvádza príklad Spojeného kráľovstva, kde je cieľom NHS rozširovať prístup pre obmedzený počet pacientov za určité obdobie, zatiaľ čo súčasne existuje vysoký počet súkromne platených predpisov. Výsledkom je nerovnosť v tom, kto dostane metabolickú intervenciu včas.</p>

<h2>Prečo „krátkodobý fix“ nestačí</h2>

<p>Ďalší kľúčový bod článku: bez zmien v životnom štýle je dlhodobý úspech obmedzený. A údaje o prerušení liečby podľa panelistov ukazujú, že pacienti často znovu priberú väčšinu stratenej hmotnosti približne do 18 mesiacov od ukončenia.</p>

<p>To korešponduje s myšlienkou, že GLP-1 RA sa nemajú vnímať len ako dočasná kúra. Ak sa obezita správa ako chronický stav s relapsom pri prerušení liečby, potom aj starostlivosť musí byť navrhnutá ako chronická. Inak povedané, musí existovať plán pokračovania, podpornej fázy a priebežného merania výsledkov, nie iba „štart“ terapie.</p>

<h2>Ekonomické modelovanie je často mimo reality</h2>

<p>Panelisti tvrdia, že tradičné ekonomické hodnotenia často pracujú s príliš zastaranými klinickými predpokladmi. V článku sa spomína britský model NICE, ktorý pre podporu terapie počítal s vysokým počtom stretnutí v primárnej starostlivosti.</p>

<p>Myšlienka je jednoduchá: ak možno starostlivosť riadiť prostredníctvom digitálnych platforiem a virtuálnej starostlivosti, dá sa bezpečne zvládnuť väčší objem pacientov s nižšími nákladmi. A nejde len o náklady na zdravotníctvo. V texte sa uvádza, že štruktúrovaná liečba GLP-1 viedla k zníženiu dní pracovnej neschopnosti približne o 50 % do 6 mesiacov.</p>

<p>Zároveň sa očakáva tlak trhu na znižovanie cien v horizonte 5 až 10 rokov, a to aj vďaka rastúcej konkurencii, viacerým formuláciám a postupnému príchodu generík. Kai Eberhardt (PhD) rámcuje budúcnosť tak, že lieky na obezitu by sa mohli stať „bazálnym preventívnym“ nástrojom kardiometabolického zdravia podobne, ako spoločnosť dnes vníma statíny.</p>

<h2>Čo by mal „nový model starostlivosti“ znamenať pre nefrológov</h2>

<p>Ak prijmeme perspektívu, že ide o chronické metabolické ochorenie, nefrológovia sa stávajú prirodzenými partnermi multidisciplinárneho tímu. Nie preto, že by sme „nahradili“ obezitologickú ambulanciu, ale preto, že máme jedinečný pohľad na riziká viažuce sa na obezitu a kardiometabolický profil.</p>

<p>Nový model môže v praxi zahŕňať:</p>

<ul>
  <li><strong>Posun cieľov z hmotnosti na metabolické výsledky.</strong> To znamená sledovať nielen váhu, ale aj výživu, telesnú kompozíciu a rizikové faktory relevantné pre obličky a cievy.</li>
  <li><strong>Systematickú podporu výživy a svalov.</strong> Keďže klinickou prioritou je udržať adekvátny príjem bielkovín a vlákniny, tím by mal mať jasný postup, ako pacientovi pomôcť.</li>
  <li><strong>Kontinuálny manažment namiesto epizód.</strong> Ak je predpoklad relapsu po ukončení, je logické mať plán dlhodobého sledovania a podpornej fázy.</li>
  <li><strong>Prepojenie s digitálnymi formami sledovania.</strong> Článok poukazuje na to, že virtuálne a digitálne platformy môžu znižovať tlak na systém bez straty bezpečnosti.</li>
  <li><strong>Aktívne riešenie bariér prístupu.</strong> Stigma a ekonomické nerovnosti môžu viesť k tomu, že pacienti dostanú liečbu neskoro alebo prerušovane.</li>
</ul>

<h2>Praktické implikácie pre kvalitu starostlivosti</h2>

<p>Z pohľadu nefrológie sa oplatí uvažovať v dvoch rovinách: kvalita výsledkov a bezpečnosť v kontexte komorbidít.</p>

<p>Po stránke kvality výsledkov dáva zmysel, aby pacient s obezitou a kardiometabolickým rizikom nedostal „liečbu v zmysle predpisu“, ale liečbu v zmysle programu: nutričné vedenie, sledovanie funkcie obličiek a telesnej kompozície a jasný spôsob, ako manažovať vedľajšie účinky tak, aby sa neohrozila adherencia.</p>

<p>Po stránke bezpečnosti je dôležité, aby sa o GLP-1 RA rozhodovalo s ohľadom na celkový klinický obraz. V praxi to znamená koordináciu s ďalšími liekmi, komorbiditami a stavmi, ktoré môžu meniť toleranciu alebo hydratáciu pacienta.</p>

<p>Článok sám osebe nie je nefrologickým usmernením, ale poskytuje rámec s priamym dopadom na nefrológiu: ak je cieľom zlepšiť metabolické zdravie a znížiť riziko relapsu, starostlivosť musí byť nastavená ako dlhodobý program, nie ako jednorazový zásah.</p>

<h2>Záver</h2>

<p>Medscape v článku o ére GLP-1 ukazuje, že „nová biológia“ sama osebe nestačí. Ak sa má liečba pretaviť do dlhodobých benefitov, musí sa zmeniť model starostlivosti: od redukcie hmotnosti k metabolickému manažmentu, od epizód k chronickej koordinovanej podpore a od rigidných bariér k systémom, ktoré umožnia kontinuitu.</p>

<p>Pre nefrológiu to znamená jasný signál: obezita nie je len sprievodný problém. Je to chronický stav s dopadom na kardiometabolické riziko a potenciálne aj na priebeh ochorení obličiek. Čím lepšie budeme prepojení s multidisciplinárnym tímom, tým väčšiu šancu máme, že výsledky budú realistické, udržateľné a bezpečné.</p>

<hr>

<p><em><strong>Zdroj:</strong> Manuela Callari, <em>GLP-1 Era Demands New Model Obesity Care</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/glp-1-era-demands-new-model-obesity-care-2026a1000kwg?ecd=a2a" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
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
