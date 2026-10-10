<?php
/**
 * add_preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Zdroj: Reischig T. Preemptivní transplantace – optimální způsob náhrady
 *        funkce ledvin. Postgraduální nefrologie 2026;24(2):3–8.
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
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Preemptívna transplantácia – optimálny spôsob náhrady funkcie obličiek',
    'slug'         => 'preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Preemptívna transplantácia obličky – vykonaná pred začatím dialyzačnej liečby pri poklese eGFR pod 10 ml/min/1,73 m² – je asociovaná s lepším prežívaním pacientov aj štepu v porovnaní s transplantáciou po dialýze. Napriek priaznivým dôkazom je preemptívnych transplantácií v celej Európe stále málo; kľúčom je včasná edukácia pacienta.',
    'content'      => <<<'HTML'
<figure><a href="img/preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin.webp" rel="noopener noreferrer" target="_blank"><img src="img/preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin.webp" alt="Žiariaca oblička na krátkej priamej svetelnej ceste, vedľa nej nepoužitá tmavá chodba s dialyzačnými hadičkami" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna. Preemptívna transplantácia nie je skratkou navyše – je cestou, ktorá dialyzačné obdobie obchádza celé.</figcaption></figure>

<p>Transplantácia obličky je optimálnym spôsobom náhrady funkcie obličiek u pacientov s chronickým zlyhávaním obličiek (CKD – chronic kidney disease). Z pohľadu prežívania pacientov, kvality života aj ekonomickej efektívnosti prekonáva hemodialýzu aj peritoneálnu dialýzu. V porovnaní s pacientmi, ktorí zostávajú na čakacej listine, je jej prínos zrejmý vo všetkých vekových skupinách.</p>

<p>Preemptívna transplantácia je transplantácia vykonaná <em>pred</em> začatím akejkoľvek dialyzačnej liečby. Tento prehľad vychádza z českého odborného článku prof. MUDr. Tomáša Reischiga, Ph.D. (Postgraduální nefrologie, 2026) a zhŕňa dostupné dôkazy vrátane ich obmedzení.</p>

<h2>Výhody preemptívnej transplantácie – čo hovoria observačné štúdie</h2>

<p>Viaceré rozsiahle observačné štúdie a registrové analýzy identifikovali dĺžku dialyzačnej liečby pred transplantáciou ako významný rizikový faktor zvýšenej mortality a zlyhania štepu – a to pri transplantácii od živého aj zosnulého darcu.</p>

<p>Súhrnne platí, že preemptívna transplantácia je asociovaná s <strong>nižšou mortalitou a lepším prežívaním štepu</strong> v porovnaní s transplantáciou vykonanou po začatí dialýzy. Ukazujú to dve novšie metaanalýzy aj jednotlivé registrové štúdie z USA, Francúzska a ďalších krajín. Napríklad vo francúzskom registri (viac ako 20 000 pacientov) bolo desaťročné prežívanie štepu pri preemptívnej transplantácii 80 % oproti 61 % pri transplantácii po začatí dialýzy; významný rozdiel sa pritom ukázal aj pri veľmi krátkom trvaní dialýzy (menej ako 6 mesiacov).</p>

<p>Podobné výhody boli pozorované aj pri <strong>preemptívnej retransplantácii</strong>: novšie registrové analýzy z USA a Francúzska ukazujú nižšiu mortalitu a lepšie prežívanie štepu v porovnaní s retransplantáciou po dialýze, aj keď staršie práce prinášali nejednoznačné výsledky, najmä pri skorom (do 12 mesiacov) zlyhaní prvého štepu.</p>

<p>V súlade s týmito údajmi KDIGO odporúčajú preemptívnu transplantáciu (prednostne od živého darcu) ako silné odporúčanie s vysokou kvalitou dôkazov (stupeň 1A).</p>

<h2>Obmedzenia dôkazovej bázy – čo treba mať na pamäti</h2>

<p><strong>Všetky dostupné štúdie sú observačné</strong>. Randomizovaná štúdia porovnávajúca dĺžku dialyzačnej liečby pred transplantáciou nie je eticky uskutočniteľná. Observačné dáta sú preto zaťažené viacerými typmi skreslenia:</p>

<ul>
  <li><strong>Lead-time bias (skreslenie načasovania sledovania):</strong> Pacienti po preemptívnej transplantácii sú sledovaní od skoršieho časového bodu ako pacienti transplantovaní po dialýze. Toto asymetrické zahrnutie predtransplantačného obdobia môže nadhodnocovať benefit preemptívnej transplantácie. Austrálska registrová analýza naznačila, že po korekcii na lead-time bias nebol rozdiel v prežívaní pacientov po preemptívnej transplantácii od živého darcu a po transplantácii s veľmi krátkou predchádzajúcou dialýzou štatisticky významný.</li>
  <li><strong>Selekčné skreslenie:</strong> Pacienti indikovaní na preemptívnu transplantáciu sú spravidla mladší, s menej závažnými komorbiditami, s polycystickou chorobou obličiek a s vyšším socioekonomickým statusom. Aj po korekcii na dostupné kovariáty je reziduálne skreslenie pravdepodobné.</li>
  <li><strong>Heterogenita štúdií:</strong> Definície, populácie a metodiky sa medzi štúdiami líšia, čo sťažuje priame porovnania.</li>
</ul>

<p>Zhoda nálezov v desiatkach štúdií a dvoch metaanalýzach má napriek týmto obmedzeniam svoju váhu. Kauzálny mechanizmus je biologicky hodnoverný, definitívny dôkaz však chýba.</p>

<h2>Možné mechanizmy benefitu</h2>

<p>Na vysvetlenie lepších výsledkov preemptívnej transplantácie sa navrhuje viacero mechanizmov, ich relatívny podiel však nie je definitívne objasnený:</p>

<ul>
  <li><strong>Prevencia kardiovaskulárnych komplikácií dialýzy:</strong> Hemodialyzačné procedúry sú asociované so subklinickými epizódami segmentárnej myokardiálnej ischémie, kumulatívnou fibróznou prestavbou myokardu a poklesom systolickej funkcie ľavej komory. Podobné hemodynamické účinky boli opísané aj pri peritoneálnej dialýze. Ak sa pacient dialýze vyhne, môže to znižovať kardiovaskulárnu mortalitu.</li>
  <li><strong>Urémia a systémový zápal:</strong> Dlhodobá urémia vedie k malnutrícii, chronickému zápalu a kostnej chorobe, ktoré nepriaznivo ovplyvňujú výsledky transplantácie.</li>
  <li><strong>Imunologické faktory:</strong> Niektoré pilotné štúdie naznačili nižší výskyt akútnej rejekcie pri preemptívnej transplantácii od živého darcu, čo nebolo konzistentne potvrdené pri transplantáciách od zosnulých darcov ani novšími metaanalýzami.</li>
  <li><strong>Lead-time bias</strong> (pozri vyššie) – čiastočne prispieva k zdanlivému benefitu.</li>
</ul>

<h2>Načasovanie preemptívnej transplantácie</h2>

<p>KDIGO odporúčajú preemptívnu transplantáciu pri <strong>eGFR &lt; 10 ml/min/1,73 m²</strong>, prípadne skôr pri prítomnosti symptómov terminálneho zlyhania obličiek. Zodpovedá to odporúčaniam Českej transplantačnej spoločnosti.</p>

<p>Transplantácia pri vyššej reziduálnej funkcii (eGFR &gt; 10–20 ml/min/1,73 m²) nevedie k ďalšiemu zlepšeniu výsledkov – prežívanie štepu aj mortalita sú porovnateľné v pomerne širokom rozsahu eGFR pri preemptívnej transplantácii (&lt; 10 ml/min/1,73 m² až &gt; 20 ml/min/1,73 m²). Príliš skoré začatie náhrady funkcie obličiek (vrátane transplantácie) nie je odôvodnené – randomizovaná štúdia IDEAL nepreukázala benefit skorého začatia hemodialýzy.</p>

<h2>Zastúpenie preemptívnych transplantácií v praxi</h2>

<p>Napriek priaznivej dôkazovej báze zostáva zastúpenie preemptívnych transplantácií v celosvetovom meradle nízke:</p>

<ul>
  <li>V USA: okolo 9 % pri transplantáciách od zosnulého darcu a 33 % od živého darcu; tento podiel stagnuje.</li>
  <li>V Európe (ERA register, 2023): preemptívnou transplantáciou začalo náhradu funkcie obličiek len 6 % pacientov (19 % zo všetkých transplantácií), s výraznými rozdielmi medzi krajinami. V rokoch 2000–2019 bol v Európe zrejmý rastúci trend (zo 7 % na 18 %).</li>
  <li>V Českej republike: podmienky sú teoreticky priaznivé vďaka krátkej čakacej dobe (medián 5 mesiacov v roku 2024). Napriek tomu zaostáva preemptívne zaradenie pacientov na čakaciu listinu – iba v niektorých centrách je preemptívne zaradených aspoň 30 % pacientov. Dlhodobé skúsenosti transplantačného centra FN Plzeň ukazujú, že systematickou edukáciou a spoluprácou s dialyzačnými strediskami možno dosiahnuť preemptívne zastúpenie presahujúce 25 %.</li>
</ul>

<h2>Prekážky a cesty k zvýšeniu počtu preemptívnych transplantácií</h2>

<p>Kľúčovými prekážkami sú nedostatočná a príliš neskorá edukácia pacientov a ich ošetrujúcich lekárov. K ďalším bariéram patrí neskoré odoslanie pacienta do transplantačného centra, dlhé čakacie doby (tam, kde existujú), zdĺhavé vyšetrovanie živých darcov a nedostatok orgánov od zosnulých darcov.</p>

<p>Edukáciu sa odporúča začať pri eGFR &lt; 30 ml/min/1,73 m² a metódu náhrady funkcie obličiek vybrať pri eGFR &lt; 20 ml/min/1,73 m². V malej randomizovanej štúdii viedla posilnená starostlivosť stredného zdravotníckeho personálu, zameraná na opakovanú edukáciu, k vyššiemu počtu preemptívnych transplantácií aj peritoneálnych dialýz.</p>

<h2>Záver</h2>

<p>Preemptívna transplantácia – od živého aj zosnulého darcu – je asociovaná s nižšou mortalitou a lepším prežívaním štepu v porovnaní s transplantáciou vykonanou po začatí dialýzy. Tento záver sa konzistentne opakuje v rozsiahlych observačných štúdiách aj v dvoch metaanalýzach a KDIGO ho hodnotia ako silné odporúčanie s vysokou kvalitou dôkazov (1A).</p>

<p>Ide však o observačné údaje so všetkými obmedzeniami, ktoré k nim patria, vrátane lead-time bias a selekčného skreslenia. Optimálne načasovanie je pri eGFR &lt; 10 ml/min/1,73 m² – transplantácia pri vyššej reziduálnej funkcii neprináša ďalší benefit. Zvýšenie podielu preemptívnych transplantácií vyžaduje systematickú a včasnú edukáciu pacientov aj lekárov primárnej a sekundárnej starostlivosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> Reischig T. Preemptivní transplantace – optimální způsob náhrady funkce ledvin. <em>Postgraduální nefrologie</em> 2026;24(2):3–8. <a href="https://www.postgradualninefrologie.cz/cislo-xxiv-2/preemptivn-transplantace-optimln-zpsob-nhrady-funkce-ledvin/" target="_blank" rel="noopener noreferrer">Odkaz na zdroj</a>.</em></p>

<p><em>Slovenské spracovanie a odborná redakcia: MUDr. Ľubomír Polaščín. Článok sumarizuje kľúčové body zdrojového prehľadu; niektoré číselné údaje (napr. percentá prežívania) pochádzajú priamo z registrových štúdií citovaných v pôvodnom texte a sú uvedené pre ilustráciu, nie ako definitívne populačné hodnoty.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_preemptivna-transplantacia-optimalny-sposob-nahrady-funkcie-ledvin_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

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
