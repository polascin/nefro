<?php
/**
 * add_nove-odporucania-hypertenzia-meranie-rozhodnutia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_nove-odporucania-hypertenzia-meranie-rozhodnutia_article.php"
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
    'title'        => 'Nové odporúčania pre hypertenziu: menej improvizácie, viac presného merania a praktických rozhodnutí',
    'slug'         => 'nove-odporucania-hypertenzia-meranie-rozhodnutia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nové odporúčania pre hypertenziu kladú dôraz na presné meranie krvného tlaku, rozhodovanie podľa celkového kardiovaskulárneho rizika a racionálne skoršie použitie kombinovanej liečby. Bezmanžetové technológie zatiaľ nemajú nahrádzať validované manžetové meranie.',
    'content'      => <<<'HTML'
<p>Liečba hypertenzie sa často začína jedným číslom v ambulancii. Problém je, že toto číslo nemusí byť spoľahlivé. Nové odporúčania a ich praktická interpretácia pripomínajú jednoduchú, ale zásadnú vec: ak krvný tlak meriame zle, môžeme nesprávne diagnostikovať, zbytočne liečiť alebo neprimerane zvyšovať dávky liekov.</p>

<p>Hlavné posolstvo je veľmi praktické. Predtým, než pacienta označíme za hypertonika alebo mu pridáme ďalší liek, musíme sa uistiť, že meranie bolo technicky správne. Až potom má zmysel hovoriť o životnom štýle, diéte, alkohole, sodíku, draslíku a farmakoterapii.</p>

<h2>Presné meranie tlaku nie je formalita</h2>

<p>Krvný tlak v ambulancii je citlivý na detaily. Poloha ruky, opora chrbta, poloha nôh, predchádzajúca káva, jedlo alebo nikotín môžu významne ovplyvniť výsledok. Podľa diskutovaných údajov môže byť rozdiel medzi meraním s rukou položenou v lone a rukou vo výške srdca klinicky významný. Ešte horšie je, ak ruka voľne visí pozdĺž tela.</p>

<p>Správne meranie má vyzerať jednoducho, ale dôsledne:</p>

<ul>
  <li>pacient sedí pokojne,</li>
  <li>chrbát má opretý,</li>
  <li>chodidlá sú položené na podlahe,</li>
  <li>nohy nie sú prekrížené,</li>
  <li>rameno je podopreté vo výške srdca,</li>
  <li>meranie sa nerobí bezprostredne po káve, fajčení, jedle alebo fyzickej námahe.</li>
</ul>

<p>V praxi je veľmi časté, že prvý tlak nameraný pri triedení pacienta je vyšší než opakované meranie po niekoľkých minútach pokoja. To nie je drobnosť. Rozdiel môže rozhodnúť o tom, či pacient dostane liek, vyššiu dávku alebo novú diagnózu.</p>

<h2>Bezmanžetové zariadenia zatiaľ nestačia</h2>

<p>Inteligentné hodinky a bezmanžetové zariadenia sú technologicky lákavé, ale zatiaľ nemajú byť náhradou štandardného merania krvného tlaku. V článku sa uvádza, že technológia využívaná napríklad v hodinkách Apple Watch na odhad hypertenzie zatiaľ nie je dostatočne spoľahlivá. Spomínaná senzitivita 41 % na detekciu vysokého krvného tlaku je na klinické rozhodovanie slabá.</p>

<p>To neznamená, že tieto technológie nemajú budúcnosť. Znamená to iba toľko, že dnes by sa podľa nich nemala nastavovať liečba hypertenzie. Na diagnostiku a úpravu liečby zostáva potrebné validované manžetové meranie, ideálne doplnené domácim meraním alebo ambulantným 24-hodinovým monitorovaním, ak je to klinicky vhodné.</p>

<h2>Alkohol a tlak: čím menej, tým lepšie</h2>

<p>Nové odporúčania American Heart Association a American College of Cardiology zdôrazňujú, že pre kontrolu krvného tlaku je optimálny nulový príjem alkoholu. Vzťah medzi množstvom alkoholu a krvným tlakom je lineárny. Čím viac alkoholu, tým vyššie riziko zvýšeného tlaku.</p>

<p>Pre pacientov to nemusí byť populárne posolstvo, ale je jasné. Ak má pacient hypertenziu alebo vysoké kardiovaskulárne riziko, zníženie alkoholu patrí medzi rozumné nefarmakologické opatrenia. U niektorých pacientov bude realistickým cieľom abstinencia, u iných aspoň významná redukcia.</p>

<h2>Sodík zostáva kľúčový, ale nie je to len o slánke</h2>

<p>Odporúčanie pre príjem sodíka zostáva prísne. Cieľom je dostať sa pod 2300 mg sodíka denne a ideálne smerovať ešte nižšie, približne k 1500 mg denne. Prakticky to znamená, že nestačí prestať dosáľať jedlo. Veľká časť sodíka prichádza z priemyselne spracovaných potravín, pečiva, syrov, údenín, hotových jedál, instantných výrobkov a reštauračnej stravy.</p>

<p>DASH diéta a diéty s nižším obsahom sodíka majú preukázateľný účinok na krvný tlak. Pre pacienta je však dôležité podať to prakticky. Menej soli neznamená nevýrazné jedlo. Pomôcť môžu bylinky, kyslosť, cesnak, cibuľa, korenie, kvalitné základné potraviny a postupná adaptácia chuti.</p>

<h2>Draslík môže pomáhať, ale nie u každého rovnako</h2>

<p>Zaujímavým bodom nových odporúčaní je väčší dôraz na príjem draslíka. Vyšší príjem draslíka v strave môže pomáhať znižovať krvný tlak, ak ho pacient toleruje a nemá kontraindikáciu.</p>

<p>Preferovaným zdrojom má byť potrava, nie automaticky tabletová suplementácia. Vhodné potraviny s vyšším obsahom draslíka môžu byť súčasťou zdravého jedálnička. Samotný článok však správne pripomína, že banány nie sú ideálnou „prvou voľbou“ pre každého, keďže prinášajú aj vyšší obsah cukrov. Draslík sa dá prijímať aj z iných rastlinných potravín.</p>

<p>Tu treba byť klinicky opatrný. U pacientov s chronickou chorobou obličiek, pokročilým CKD, pri liečbe inhibítormi renín-angiotenzín-aldosterónového systému, mineralokortikoidnými antagonistami alebo pri anamnéze hyperkaliémie sa nedá paušálne odporučiť zvyšovanie draslíka bez kontroly laboratórnych hodnôt. V bežnej populácii s hypertenziou môže byť vyšší príjem draslíka prospešný, ale u nefrologických pacientov musí byť individualizovaný.</p>

<h2>Hypertenzia 1. stupňa: rozhoduje aj kardiovaskulárne riziko</h2>

<p>Pri hypertenzii 1. stupňa, teda pri systolickom tlaku 130 až 139 mm Hg alebo diastolickom tlaku 80 až 89 mm Hg, už nejde len o samotné číslo. Nové odporúčania viac pracujú s celkovým kardiovaskulárnym rizikom.</p>

<p>Ak má pacient známe kardiovaskulárne ochorenie, diabetes alebo 10-ročné kardiovaskulárne riziko podľa kalkulátora PREVENT nad 7,5 %, je dôvod začať farmakologickú liečbu skôr. Ak je riziko nízke, môže byť rozumné najskôr cielene pracovať so životným štýlom a následne tlak prehodnotiť.</p>

<p>Toto je praktický posun. Hypertenzia sa nelieči izolovane od pacienta. Iný význam má tlak 134/84 mm Hg u mladého nízkorizikového človeka a iný u pacienta s diabetom, albuminúriou alebo už prekonanou kardiovaskulárnou príhodou.</p>

<h2>Hypertenzia 2. stupňa: skôr kombinácia než maximálna dávka jedného lieku</h2>

<p>Pri hypertenzii 2. stupňa, teda pri tlaku nad 140/90 mm Hg, odporúčania podporujú skoršie použitie kombinovanej liečby. Dôvod je praktický aj farmakologický. Nízke až stredné dávky viacerých liekov často prinesú lepší pokles tlaku s menším počtom nežiaducich účinkov než vytláčanie jedného lieku do maximálnej dávky.</p>

<p>V článku sa spomína skoršie nasadenie dvojkombinácií a v niektorých prípadoch aj trojkombinácií, napríklad kombinácia blokátora angiotenzínového receptora, blokátora kalciového kanála a tiazidového alebo tiazidu podobného diuretika. Takýto prístup môže zlepšiť adherenciu, najmä ak je dostupný v jednej tablete.</p>

<p>Samozrejme, výber liekov musí zohľadniť vek, obličkové funkcie, elektrolyty, albuminúriu, srdcové zlyhávanie, ischemickú chorobu srdca, dnu, ortostatické ťažkosti, graviditu alebo liekové interakcie.</p>

<h2>Praktická interpretácia pre ambulanciu</h2>

<p>Najväčšia hodnota týchto odporúčaní nie je v jednej novej molekule ani v revolučnom postupe. Je v zlepšení každodennej disciplíny.</p>

<p>Pred úpravou liečby by sme mali najskôr skontrolovať, či bol tlak meraný správne. Potom posúdiť domáce merania, adherenciu, príjem soli, alkohol, hmotnosť, spánok, fyzickú aktivitu a lieky zvyšujúce tlak, napríklad nesteroidové antiflogistiká, dekongestíva, stimulanty alebo niektoré hormonálne prípravky.</p>

<p>Až potom má zmysel meniť farmakoterapiu. Pri nižšom riziku a miernej hypertenzii môže byť prvým krokom životný štýl. Pri vyššom riziku alebo hypertenzii 2. stupňa je vhodné neodkladať liečbu a často začať kombináciou.</p>

<h2>Záver</h2>

<p>Nové odporúčania pre hypertenziu sú praktické najmä v troch oblastiach. Po prvé, zdôrazňujú presné meranie krvného tlaku. Po druhé, posúvajú rozhodovanie pri hypertenzii 1. stupňa smerom k celkovému kardiovaskulárnemu riziku. Po tretie, podporujú racionálne skoršie použitie kombinovanej liečby pri vyšších hodnotách tlaku.</p>

<p>Pre pacienta je dôležité jednoduché vysvetlenie: tlak treba merať správne, nespoliehať sa na neoverené bezmanžetové technológie, znížiť alkohol a sodík, u vhodných pacientov zvýšiť príjem draslíka a liečbu prispôsobiť celkovému riziku, nie iba jednému číslu z ambulancie.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>Translating Hypertension Guidelines Into Clinical Practice</em> (2026). <a href="https://www.medscape.com/viewarticle/translating-hypertension-guidelines-clinical-practice-2026a1000hd7" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
