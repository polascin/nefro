<?php
/**
 * add_chia-seed-internal-shower-medicina-vs-marketing_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_chia-seed-internal-shower-medicina-vs-marketing_article.php"
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
    'title'        => '„Chia seed internal shower“: čo na tom je a čo nie z pohľadu medicíny',
    'slug'         => 'chia-seed-internal-shower-medicina-vs-marketing',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Trend „internal shower“ sľubuje „vyčistenie“ čriev pomocou chia semienok vo vode. Nutričná hodnota chia (najmä vláknina) je reálna, no klinické dôkazy o „čistení“ čreva nad rámec účinku bežnej vlákniny chýbajú – a náhle zvýšenie dávky môže symptómy zhoršiť.',
    'content'      => <<<'HTML'
<figure><a href="img/chia-seed-internal-shower-medicina-vs-marketing.webp" rel="noopener noreferrer" target="_blank"><img src="img/chia-seed-internal-shower-medicina-vs-marketing.webp" alt="Napučané semená v pohári vody s prehnaným leskom, zatiaľ čo svetlo vstupujúce do čreva je obyčajné" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna. Vláknina s vodou má svoj zmysel – účinok je však bežný, nie zázračný.</figcaption></figure>

<p>Pacienti prichádzajú do ambulancie často s konkrétnou otázkou: „Pomohlo by mi pitie chia semienok na vyčistenie čriev?“ Trend „internal shower“ (ráno zjesť alebo zaliať chia semienka vodou, aby sa „vypláchol“ tráviaci systém) sa online šíri veľmi rýchlo. Medzi tým, čo chia skutočne ponúka nutrične, a tým, čo trend sľubuje, je však veľký rozdiel.</p>

<h2>Čo je na chia semienkach reálne dobré</h2>

<p>Chia semienka (<em>Salvia hispanica</em>) majú reálnu nutričnú hodnotu. V zdrojovom článku sa zdôrazňuje najmä:</p>

<ul>
  <li>vysoký obsah vlákniny (2 polievkové lyžice približne 10 g vlákniny),</li>
  <li>omega-3 mastné kyseliny (alfa-linolénová),</li>
  <li>bielkoviny a minerály.</li>
</ul>

<p>Keď sa chia zmieša s vodou, rozpustná vláknina vytvorí viskózny gél. Ten môže:</p>

<ul>
  <li>pridať objem do stolice,</li>
  <li>zjemniť konzistenciu,</li>
  <li>podporiť prechod črevným traktom.</li>
</ul>

<p>Toto nie je marketing. Je to bežná fyziológia vlákniny.</p>

<h2>Kde sa medicína a marketing rozchádzajú</h2>

<p>Sľub „internal shower“ vychádza z predstavy, že organizmus má „upchaté“ alebo „znečistené“ črevo a treba ho pravidelne „vypláchnuť zvnútra“. Pacientom treba povedať priamo: telo nie je upchatý odtok. Detoxikačné procesy prebiehajú priebežne a bez pitia chia vody ich netreba „spúšťať“.</p>

<p>Zdrojový materiál to hovorí jasne:</p>

<ul>
  <li>neexistuje recenzovaný (peer-reviewed) dôkaz, že voda s chia semienkami „čistí“ črevo viac, než by to dokázala bežná diétna vláknina.</li>
</ul>

<p>Inými slovami: ak chia pacientovi pomôže, je to v prvom rade preto, že prijal vlákninu, nie preto, že by sa mu „vypláchol“ tráviaci systém.</p>

<h2>Vláknina nie je pre všetkých rovnaká</h2>

<p>Klinicky podstatný je typ vlákniny a to, ako ju črevo znáša, najmä pri:</p>

<ul>
  <li>zápche,</li>
  <li>syndróme dráždivého čreva (IBS),</li>
  <li>nadúvaní a kŕčoch.</li>
</ul>

<p>V zdrojovom článku sa uvádza, že:</p>

<ul>
  <li><strong>psyllium</strong> má najsilnejšiu dôkaznú bázu pre zlepšenie frekvencie a konzistencie stolice pri chronickej zápche,</li>
  <li><strong>nerozpustné vlákniny</strong> (napr. pšeničné otruby) môžu u niektorých pacientov zhoršiť nadúvanie a diskomfort pri IBS,</li>
  <li>chia obsahuje rozpustnú aj nerozpustnú vlákninu, prevažuje však rozpustná zložka – mnohým pacientom to vyhovuje, ale nie každému.</li>
</ul>

<p>Praktický dôsledok: odporúčanie „len pridajte vlákninu“ bez upresnenia typu a bez postupného zvyšovania dávky je zbytočné riziko. Najmä pri IBS môže ťažkosti zhoršiť.</p>

<h2>Prečo môže chia trend pacientovi uškodiť</h2>

<p>Podľa zdrojového materiálu je typický scenár takýto:</p>

<ul>
  <li>pacient začne nárazovo (napr. „z nuly na plnú dávku“),</li>
  <li>do približne 72 hodín môže dôjsť k výraznému nadúvaniu, kŕčom a paradoxne aj k zhoršeniu zápchy.</li>
</ul>

<p>Dôvod je jednoduchý: črevný mikrobiom potrebuje čas prispôsobiť sa zvýšenému prísunu fermentovateľného substrátu a náhle zvýšenie môže zmeniť plynatosť aj motilitu.</p>

<h2>Ako to komunikovať pacientovi v ambulancii (konkrétne odporúčanie)</h2>

<p>Ak pacient chce chia napriek tomu vyskúšať, bezpečnejšie je dávku postupne titrovať:</p>

<ul>
  <li>začať <strong>0,5 až 1 polievkovou lyžicou denne</strong>,</li>
  <li>dávku zvyšovať <strong>postupne v priebehu niekoľkých týždňov</strong>,</li>
  <li>a najmä <strong>zabezpečiť dostatočný príjem tekutín</strong>.</li>
</ul>

<p>Pacientovi to treba povedať jasne: vláknina bez tekutín ťažkosti zhoršuje a môže zhoršiť pasáž.</p>

<p>Rozhovor možno zároveň presmerovať na postupy s oporou v dôkazoch:</p>

<ul>
  <li>denný cieľ vlákniny sa v zdrojovom článku uvádza približne <strong>25 až 35 g denne</strong> z rôznych potravín,</li>
  <li>pri zápche má psyllium silnú oporu v štúdiách,</li>
  <li>ako doplnok v praxi môžu fungovať aj konkrétne potraviny (napr. slivky, kiwi, ovos),</li>
  <li>na motilitu má podstatný vplyv aj pohyb a denný režim.</li>
</ul>

<h2>Kedy nepokračovať v trende a riešiť príčinu</h2>

<p>Zdrojový článok upozorňuje aj na druhú, klinicky veľmi dôležitú rovinu: ak pacient používa wellness trend na dlhšie trvajúce ťažkosti, môže oddialiť vyšetrenie.</p>

<p>Varovnými signálmi sú najmä:</p>

<ul>
  <li>zápcha, ktorá pretrváva,</li>
  <li>snaha vyriešiť ťažkosti, ktoré trvajú mesiace, „receptom“ zo sociálnych sietí,</li>
  <li>príznaky, pri ktorých treba myslieť na liekovú príčinu, endokrinnú poruchu alebo funkčnú poruchu defekácie.</li>
</ul>

<p>V takých prípadoch treba hľadať príčinu, nie iba zvyšovať vlákninu.</p>

<h2>Osobitné poznámky pre nefrologických pacientov (CKD, dialýza)</h2>

<p>Na toto trend často zabúda. Pri ochoreniach obličiek sa tekutinový režim môže líšiť podľa štádia a liečby. Preto:</p>

<ul>
  <li>odporúčanie „zabezpečte dostatok tekutín“ treba pre nefrologických pacientov preložiť do reality ich <strong>individuálneho tekutinového limitu</strong>,</li>
  <li>pri dialýze je obzvlášť dôležité, aby pacient chia skúšal len v rámci odporúčaného režimu a po dohode s ošetrujúcim tímom,</li>
  <li>ak sa objaví zhoršenie nadúvania, kŕčov alebo pasáže stolice, trend treba zastaviť a prehodnotiť stratégiu zápchy.</li>
</ul>

<p>Nejde o to, že chia „je zakázaná“, ale o to, že v nefrologickej starostlivosti sa praktické detaily (najmä príjem tekutín) často musia upraviť, aby sa riziko minimalizovalo.</p>

<h2>Zhrnutie</h2>

<p>„Chia seed internal shower“ je typický príklad trendu, pri ktorom:</p>

<ul>
  <li><strong>nutričná hodnota chia je skutočná</strong> (najmä vláknina),</li>
  <li><strong>sľub „vyčistenia čriev“ nie je podporený klinickými dôkazmi</strong>, ktoré by išli nad rámec účinku vlákniny,</li>
  <li>náhle zvýšenie dávky môže zhoršiť symptómy,</li>
  <li>najlepšie funguje individuálny prístup: postupná titrácia, dostatočná hydratácia podľa tolerancie a pri potrebe aj voľba vlákniny s lepšou dôkaznou oporou (napr. psyllium).</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, článok „Chia Seed Cleanse: Where Medicine and Marketing Part Ways“ (2026). <a href="https://www.medscape.com/viewarticle/chia-seed-cleanse-where-medicine-and-marketing-part-ways-2026a1000j5a" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
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
