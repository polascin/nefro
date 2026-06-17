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
    'excerpt'      => 'Trend „internal shower“ sľubuje „vyčistenie“ čriev pomocou chia semienok vo vode. Nutričná hodnota chia (najmä vláknina) je reálna, no klinické dôkazy o „čistení“ čreva nad rámec účinku bežnej vlákniny chýbajú — a náhle zvýšenie dávky môže symptómy zhoršiť.',
    'content'      => <<<'HTML'
<p>Keď pacienti prídu do ambulancie, často si nesú konkrétnu otázku: „Pomohlo by mi pitie chia semienok na vyčistenie čriev?“ Trend „internal shower“ (ráno zjesť alebo zaliať chia semienka vodou, aby sa „vypláchol“ tráviaci systém) sa šíri online neuveriteľne rýchlo. Zároveň však existuje výrazný rozdiel medzi tým, čo je na chia nutrične pravdivé, a tým, čo trend sľubuje.</p>

<h2>Čo je na chia semienkach reálne dobré</h2>

<p>Chia semienka (<em>Salvia hispanica</em>) majú reálnu nutričnú hodnotu. V zdrojovom článku sa zdôrazňuje najmä:</p>

<ul>
  <li>vysoký obsah vlákniny (2 polievkové lyžice približne 10 g vlákniny),</li>
  <li>omega-3 mastné kyseliny (alfa-linolénová),</li>
  <li>bielkoviny a minerály.</li>
</ul>

<p>Keď sa chia zmieša s vodou, rozpustná vláknina vytvorí viskózny gél. Takýto mechanizmus môže:</p>

<ul>
  <li>pridať objem do stolice,</li>
  <li>zjemniť konzistenciu,</li>
  <li>podporiť prechod črevným traktom.</li>
</ul>

<p>Toto nie je marketing. Je to bežná fyziológia vlákniny.</p>

<h2>Kde sa medicína a marketing rozchádzajú</h2>

<p>Sľub „internal shower“ vychádza z predstavy, že organizmus má „upchaté“ alebo „znečistené“ črevo a treba ho pravidelne „vypláchnuť zvnútra“. Klinicky je potrebné pacientom povedať priamo: telo nevnímajte ako upchatý odtok. Detoxikačné procesy prebiehajú priebežne a bez pitia chia vody ich netreba „spúšťať“.</p>

<p>V zdrojovom materiáli sa zároveň uvádza jasná pointa:</p>

<ul>
  <li>neexistuje peer-reviewed dôkaz, že chia seed water má efekt „čistenia“ čreva nad rámec toho, čo by poskytla bežná diétna vláknina.</li>
</ul>

<p>Inými slovami: ak pacientovi pomôže, je to v prvom rade preto, že prijal vlákninu, nie preto, že by sa „vypláchol“ vnútorný systém.</p>

<h2>Vláknina nie je pre všetkých rovnaká</h2>

<p>Jedna z najdôležitejších klinických nuáns je typ vlákniny a tolerancia v črevách, najmä pri:</p>

<ul>
  <li>zápche,</li>
  <li>syndróme dráždivého čreva (IBS),</li>
  <li>nadúvaní a kŕčoch.</li>
</ul>

<p>V zdrojovom článku sa uvádza, že:</p>

<ul>
  <li><strong>psyllium</strong> má najsilnejšiu dôkaznú bázu pre zlepšenie frekvencie a konzistencie stolice pri chronickej zápche,</li>
  <li><strong>nerozpustné vlákniny</strong> (napr. pšeničné otruby) môžu u niektorých pacientov zhoršiť nadúvanie a diskomfort pri IBS,</li>
  <li>chia obsahuje rozpustnú aj nerozpustnú vlákninu, pričom primárne ide skôr o rozpustnú zložku, čo môže byť pre viacerých pacientov v poriadku, ale nie pre každého.</li>
</ul>

<p>Praktický dôsledok: odporúčanie „len pridajte vlákninu“ bez špecifikácie a bez titrácie je zbytočné riziko. Najmä u pacientov s IBS môže viesť k horšej symptomatike.</p>

<h2>Prečo môže chia trend pacientovi uškodiť</h2>

<p>Podľa zdrojového materiálu typický scenár v praxi vyzerá takto:</p>

<ul>
  <li>pacient začne nárazovo (napr. „z nuly na plnú dávku“),</li>
  <li>do približne 72 hodín môže dôjsť k výraznému nadúvaniu, kŕčom a paradoxne aj k zhoršeniu zápchy.</li>
</ul>

<p>Dôvod je jednoduchý: črevný mikrobiom potrebuje čas prispôsobiť sa zvýšenému prísunu fermentovateľného substrátu a náhle zvýšenie môže zmeniť plynatosť aj motilitu.</p>

<h2>Ako to komunikovať pacientovi v ambulancii (konkrétne odporúčanie)</h2>

<p>Ak pacient trvá na skúšaní, zmysluplný a bezpečnejší rámec vychádza z praktickej titrácie:</p>

<ul>
  <li>začať <strong>0,5 až 1 polievkovou lyžicou denne</strong>,</li>
  <li>dávku zvyšovať <strong>postupne v priebehu niekoľkých týždňov</strong>,</li>
  <li>a najmä <strong>zabezpečiť dostatočný príjem tekutín</strong>.</li>
</ul>

<p>Dôležitá praktická veta pre pacienta: vláknina bez tekutín je recept na zhoršenie a riziko zhoršenej pasáže.</p>

<p>Zároveň môžete využiť „preorientovanie“ na dôkazy:</p>

<ul>
  <li>denný cieľ vlákniny sa v zdrojovom článku uvádza približne <strong>25 až 35 g denne</strong> z rôznych potravín,</li>
  <li>pri zápche má psyllium silnú oporu v štúdiách,</li>
  <li>ako doplnok v praxi môžu fungovať aj konkrétne potraviny (napr. slivky, kiwi, ovos),</li>
  <li>pohyb a režim sú podstatnou súčasťou motility.</li>
</ul>

<h2>Kedy nepokračovať v trende a riešiť príčinu</h2>

<p>Zdrojový článok upozorňuje aj na druhú, klinicky veľmi dôležitú rovinu: ak pacient používa wellness trend na dlhšie trvajúce ťažkosti, môže oddialiť vyšetrenie.</p>

<p>Varovný signál je najmä:</p>

<ul>
  <li>zápcha, ktorá pretrváva,</li>
  <li>potreba „social media fixu“ na symptomatický problém, ktorý trvá mesiace,</li>
  <li>príznaky, pri ktorých treba myslieť na liekovú príčinu, endokrinnú poruchu alebo funkčnú poruchu defekácie.</li>
</ul>

<p>V takých situáciách treba riešiť etiologicky, nie iba zvyšovať vlákninu.</p>

<h2>Osobitné poznámky pre nefrologických pacientov (CKD, dialýza)</h2>

<p>Toto je bod, ktorý trend často ignoruje. Pri ochoreniach obličiek sa tekutinový režim môže líšiť podľa štádia a liečby. Preto:</p>

<ul>
  <li>odporúčanie „zabezpečte dostatok tekutín“ treba pre nefrologických pacientov preložiť do reality ich <strong>individuálneho tekutinového limitu</strong>,</li>
  <li>pri dialýze je obzvlášť dôležité, aby pacient chia skúšal len v rámci odporúčaného režimu a po dohode s ošetrujúcim tímom,</li>
  <li>ak sa objaví zhoršenie nadúvania, kŕčov alebo pasáže stolice, trend treba zastaviť a prehodnotiť stratégiu zápchy.</li>
</ul>

<p>Nejde o to, že chia „je zakázaná“, ale o to, že nefrologická starostlivosť často mení praktické detaily (najmä tekutiny), aby sa minimalizovalo riziko.</p>

<h2>Zhrnutie</h2>

<p>„Chia seed internal shower“ je typický príklad, kde:</p>

<ul>
  <li><strong>nutričná hodnota chia je skutočná</strong> (najmä vláknina),</li>
  <li><strong>sľub „vyčistenia čriev“ nie je podporený klinickými dôkazmi</strong>, ktoré by išli nad rámec účinku vlákniny,</li>
  <li>náhle zvýšenie dávky môže zhoršiť symptómy,</li>
  <li>najlepšie funguje princíp individualizácie: postupná titrácia, dostatočná hydratácia podľa tolerancie a pri potrebe aj voľba vlákniny s lepšou dôkaznou oporou (napr. psyllium).</li>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
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
