<?php
/**
 * add_lipoprotein-a-kardiovaskularne-riziko-primarna-starostlivost_article.php
 * Odborný článok o skríningu, interpretácii a manažmente zvýšeného Lp(a).
 * Pôvodný autor spracovaného zdroja je uvedený v source_authors.php.
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
    'title'        => 'Lipoproteín(a): kardiovaskulárny rizikový faktor, ktorý v primárnej starostlivosti často prehliadame',
    'slug'         => 'lipoprotein-a-kardiovaskularne-riziko-primarna-starostlivost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Jedno stanovenie Lp(a) môže odhaliť celoživotné genetické riziko ASCVD a aortálnej stenózy. Ako správne čítať mg/dl a nmol/l a čo po vysokom výsledku zmeniť aj pri CKD.',
    'content'      => <<<'HTML'
<p>Lipoproteín(a), Lp(a), patrí medzi najčastejšie prehliadané kardiovaskulárne rizikové faktory. Jeho koncentrácia sa v bežnom lipidovom profile nemeria a z hodnoty LDL cholesterolu ju nemožno spoľahlivo odvodiť. Pacient preto môže mať prijateľný LDL cholesterol, zdravý životný štýl a napriek tomu niesť významné, prevažne vrodené reziduálne riziko.</p>

<p>Aktuálne európske aj americké odporúčania podporujú stanovenie Lp(a) aspoň raz u každého dospelého. Výsledok nie je samoúčelný: môže spresniť celkové aterosklerotické kardiovaskulárne riziko, viesť k dôslednejšiemu znižovaniu LDL cholesterolu a kontrole ďalších ovplyvniteľných rizikových faktorov a upozorniť na potrebu vyšetriť blízkych príbuzných. Pri chronickej chorobe obličiek (CKD) však treba navyše rozlíšiť vrodenú zložku od možného získaného zvýšenia Lp(a).</p>

<h2>Čo je Lp(a)</h2>

<p>Lp(a) je častica podobná LDL. Obsahuje apolipoproteín B-100, na ktorý je disulfidovou väzbou naviazaný apolipoproteín(a), apo(a). Veľkosť apo(a) je geneticky variabilná a výrazne ovplyvňuje koncentráciu aj laboratórne meranie Lp(a). O koncentrácii Lp(a) preto viac než pri väčšine ostatných lipoproteínov rozhoduje genetická výbava, najmä varianty génu <em>LPA</em>.</p>

<p>Lp(a) prenáša cholesterol a oxidované fosfolipidy a má proaterogénne, prozápalové a prokalcifikačné účinky. Epidemiologické a genetické údaje presvedčivo podporujú jeho kauzálnu úlohu pri aterosklerotickom kardiovaskulárnom ochorení (ASCVD) a kalcifikujúcej aortálnej stenóze. Najsilnejší vzťah sa pozoruje pri infarkte myokardu a aortálnej stenóze; vzťah k ischemickej cievnej mozgovej príhode je slabší a vysoký Lp(a) sa nepovažuje za preukázaný kauzálny rizikový faktor žilového tromboembolizmu.</p>

<p>Riziko rastie kontinuálne, nie až po prekročení jedného biologického prahu. Rovnaká koncentrácia preto nemá rovnaký absolútny význam pre mladého človeka bez ďalších rizík a pre pacienta s prekonaným infarktom, diabetom alebo CKD. Prahové hodnoty slúžia na praktické rozhodovanie, nie na rozdelenie ľudí na skupiny „bez rizika“ a „s rizikom“.</p>

<h2>Komu a kedy Lp(a) stanoviť</h2>

<p>Odporúčania ACC/AHA z roku 2026 aj súčasný európsky rámec podporujú aspoň jedno stanovenie Lp(a) počas dospelosti, ideálne spolu s prvým komplexným lipidovým profilom. Samotné vyšetrenie Lp(a) nevyžaduje odber nalačno.</p>

<p>Vyšetrenie je mimoriadne dôležité pri:</p>

<ul>
  <li>predčasnom alebo opakovanom ASCVD, najmä ak nezodpovedá bežnému rizikovému profilu,</li>
  <li>rodinnej anamnéze predčasného ASCVD alebo známeho vysokého Lp(a),</li>
  <li>podozrení na familiárnu hypercholesterolémiu,</li>
  <li>progresii aterosklerózy napriek dobre kontrolovanému LDL cholesterolu,</li>
  <li>kalcifikujúcej aortálnej stenóze v neobvykle mladom veku,</li>
  <li>rozhodovaní o intenzite prevencie u človeka na hranici liečebného prahu.</li>
</ul>

<p>Ak sa zistí výrazne zvýšený Lp(a), má zmysel kaskádové vyšetrenie príbuzných prvého stupňa. Meranie koncentrácie je pre klinické posúdenie spravidla dostatočné; genotypizácia <em>LPA</em> ani určovanie veľkosti izoforiem apo(a) sa rutinne nevyžadujú.</p>

<h2>Jednotky mg/dl a nmol/l sa nesmú mechanicky prepočítavať</h2>

<p>Laboratóriá môžu Lp(a) uvádzať ako hmotnostnú koncentráciu v mg/dl alebo ako molárnu koncentráciu častíc v nmol/l. Pre rozdielnu veľkosť izoforiem apo(a) medzi nimi neexistuje univerzálny presný prepočítavací koeficient. Hodnotu treba interpretovať v jednotke, v ktorej bola metóda kalibrovaná, a pri sledovaní preferovať rovnaké laboratórium a rovnakú metódu.</p>

<div class="table-responsive" role="region" aria-label="Praktické pásma koncentrácie lipoproteínu a podľa konsenzu EAS a NLA" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Praktická kategória</th>
      <th scope="col">Hmotnostná koncentrácia</th>
      <th scope="col">Molárna koncentrácia</th>
      <th scope="col">Klinický význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Nízka</th>
      <td>&lt;30 mg/dl</td>
      <td>&lt;75 nmol/l</td>
      <td>Významné riziko pripísateľné Lp(a) je menej pravdepodobné</td>
    </tr>
    <tr>
      <th scope="row">Hraničná, „sivá zóna“</th>
      <td>30–50 mg/dl</td>
      <td>75–125 nmol/l</td>
      <td>Význam závisí od celkového rizika a ďalších rizikových faktorov</td>
    </tr>
    <tr>
      <th scope="row">Vysoká</th>
      <td>≥50 mg/dl</td>
      <td>≥125 nmol/l</td>
      <td>Faktor zvyšujúci riziko, ktorý môže zmeniť intenzitu prevencie</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tabuľka uvádza pragmatické pásma konsenzu EAS a stanoviska NLA, nie matematické ekvivalenty. Dokumenty používajú mierne odlišné molárne prahy: aktualizácia ESC/EAS 2025 označuje za klinicky významný modifikátor rizika hodnotu &gt;50 mg/dl alebo ≥105 nmol/l, kým ACC/AHA 2026 používa ≥50 mg/dl alebo ≥125 nmol/l. Tento rozdiel je ďalším dôvodom, prečo výsledok neprepočítavať svojpomocne.</p>

<p>Podľa ACC/AHA 2026 je Lp(a) ≥125 nmol/l alebo ≥50 mg/dl spojený približne s 1,4-násobným odhadovaným rizikom ASCVD a hodnota ≥250 nmol/l alebo ≥100 mg/dl približne s dvojnásobným rizikom. Ide o priemerný relatívny odhad; individuálne absolútne riziko naďalej určujú vek, už prítomné ASCVD, LDL cholesterol, krvný tlak, fajčenie, diabetes, funkcia obličiek a ďalšie okolnosti.</p>

<h2>Kedy jednorazové meranie nestačí</h2>

<p>U väčšiny stabilných dospelých sa Lp(a) počas života mení iba málo, preto rutinné opakované kontroly neprinášajú ďalšiu prognostickú informáciu. Výnimkou sú stavy, ktoré môžu koncentráciu sekundárne ovplyvniť, alebo situácie, keď sa zásadne zmení klinický kontext.</p>

<p>Opakované stanovenie možno zvážiť najmä vtedy, ak bol prvý odber vykonaný:</p>

<ul>
  <li>počas akútnej infekcie alebo výrazného zápalového stavu,</li>
  <li>pri aktívnom nefrotickom syndróme alebo veľkej proteinúrii,</li>
  <li>pri nestabilnej či výrazne sa meniacej funkcii obličiek alebo pečene,</li>
  <li>pred a po zásadnej zmene stavu, napríklad po remisii nefrotického syndrómu alebo transplantácii obličky, ak výsledok ovplyvní rozhodovanie,</li>
  <li>po začatí špecifickej liečby ovplyvňujúcej Lp(a), ak sa taká liečba používa v schválenej indikácii alebo klinickej štúdii.</li>
</ul>

<p>Opakovanie má zmysel aj pri neočakávanom alebo klinicky nepravdepodobnom výsledku, najmä ak nie je známa použitá metóda. Laboratórium by malo preferovať metódu čo najmenej citlivú na veľkosť izoforiem apo(a), metrologicky nadviazanú na uznávaný referenčný materiál.</p>

<h2>Čo má vysoký výsledok zmeniť</h2>

<p>Vysoký Lp(a) nie je dôvodom na rezignáciu ani na liečbu izolovaného laboratórneho čísla. Je signálom, že celoživotné riziko bolo pravdepodobne podhodnotené a ostatné ovplyvniteľné faktory treba riešiť skôr a dôslednejšie.</p>

<ol>
  <li><strong>Určiť celkové riziko.</strong> Zohľadniť klinické ASCVD, vek, rodinnú anamnézu, LDL-C, non-HDL cholesterol alebo apoB, krvný tlak, diabetes, fajčenie, CKD a podľa situácie subklinickú aterosklerózu.</li>
  <li><strong>Znížiť aterogénnu záťaž.</strong> Dosiahnuť cieľ LDL-C podľa rizikovej kategórie a pri potrebe včas pridať ezetimib, inhibítor PCSK9 alebo inú liečbu s preukázaným výsledkovým prínosom a vhodnou indikáciou.</li>
  <li><strong>Liečiť všetky ďalšie riziká.</strong> Optimalizovať krvný tlak a glykémiu, nefajčiť, podporiť pohyb, primeranú hmotnosť, zdravú výživu a adherenciu.</li>
  <li><strong>Vyšetriť rodinu.</strong> Ponúknuť jednorazové stanovenie Lp(a) príbuzným prvého stupňa, najmä pri veľmi vysokej hodnote alebo predčasnom ASCVD.</li>
  <li><strong>Zvážiť konzultáciu lipidológa alebo kardiológa.</strong> Najmä pri veľmi vysokom Lp(a), predčasnom či progredujúcom ASCVD, podozrení na familiárnu hypercholesterolémiu alebo nejasnej interpretácii.</li>
</ol>

<p>Vysoký Lp(a) sám osebe nie je indikáciou na rutinné podávanie kyseliny acetylsalicylovej v primárnej prevencii ani na skríningovú echokardiografiu bez šelestu, symptómov alebo inej klinickej indikácie. Takisto sa rutinne neodporúča odpočítavať od LDL-C odhadovaný cholesterol obsiahnutý v Lp(a), pretože jeho podiel je výrazne variabilný.</p>

<h2>Životný štýl je dôležitý, hoci Lp(a) výrazne nezníži</h2>

<p>Úprava stravy, pohyb ani redukcia hmotnosti zvyčajne nemenia geneticky určenú koncentráciu Lp(a) natoľko, aby odstránili riziko. To však neznamená, že sú zbytočné. Priaznivý životný štýl znižuje krvný tlak, inzulínovú rezistenciu, aterogénne lipoproteíny, zápalovú záťaž aj pravdepodobnosť ďalších kardiometabolických ochorení, a tým znižuje celkové absolútne riziko.</p>

<p>Pacientovi treba vysvetliť rozdiel medzi „neznižuje samotný biomarker“ a „neznižuje celkové riziko“. Druhé tvrdenie by bolo nesprávne a mohlo by viesť k strate motivácie.</p>

<h2>Čo dokáže súčasná liečba</h2>

<div class="table-responsive" role="region" aria-label="Vplyv dostupných liečebných možností na lipoproteín a" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečba</th>
      <th scope="col">Vplyv na Lp(a)</th>
      <th scope="col">Praktický význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Statín</th>
      <td>Spravidla neznižuje Lp(a), niekedy ho mierne zvýši</td>
      <td>Nevysádzať pre tento laboratórny efekt; prínos zníženia LDL-C spravidla výrazne prevažuje</td>
    </tr>
    <tr>
      <th scope="row">Ezetimib</th>
      <td>Malý alebo neutrálny priamy účinok</td>
      <td>Má význam na dosiahnutie cieľa LDL-C, nie ako špecifická liečba Lp(a)</td>
    </tr>
    <tr>
      <th scope="row">Monoklonálne protilátky proti PCSK9</th>
      <td>Priemerne znižujú Lp(a) približne o 20–30 %</td>
      <td>Indikácia sa riadi najmä LDL-C a celkovým rizikom; výsledkový prínos nemožno pripísať iba poklesu Lp(a)</td>
    </tr>
    <tr>
      <th scope="row">Niacín</th>
      <td>Lp(a) môže znížiť</td>
      <td>Pre chýbajúci výsledkový prínos a nežiaduce účinky sa na tento účel neodporúča</td>
    </tr>
    <tr>
      <th scope="row">Lipoproteínová aferéza</th>
      <td>Výrazný, ale prechodný pokles</td>
      <td>Možnosť iba pre veľmi vybraných pacientov s progresívnym ASCVD; kritériá a dostupnosť sa medzi krajinami líšia</td>
    </tr>
  </tbody>
</table>
</div>

<p>Cielené antisense oligonukleotidy a malé interferujúce RNA, napríklad pelakarsen a olpasiran, dokážu v skorších štúdiách znížiť Lp(a) približne o 70–98 %. Pokles biomarkera však ešte nie je dôkazom poklesu infarktov, cievnych mozgových príhod alebo mortality.</p>

<p>K 22. augustu 2026 nemala výsledková štúdia Lp(a)HORIZON s pelakarsenom v registri ClinicalTrials.gov zverejnené výsledky a štúdia OCEAN(a)-Outcomes s olpasiranom naďalej prebiehala bez výsledkov. Cielené lieky preto ešte nie sú súčasťou bežnej klinickej praxe ako liečba s preukázaným znížením kardiovaskulárnych príhod.</p>

<h2>Osobitosti pri chronickej chorobe obličiek</h2>

<p>Pri CKD môže výsledok Lp(a) odrážať nielen genetiku. Obličky sa podieľajú na metabolizme apo(a) a pri poklese funkcie obličiek môžu koncentrácie stúpať, hoci rozsah závisí aj od veľkosti izoforiem. Pri nefrotickom syndróme a peritoneálnej dialýze s významnými stratami bielkovín sa Lp(a) môže zvýšiť bez ohľadu na izoformu; toto získané zvýšenie môže po remisii nefrotického syndrómu alebo po úspešnej transplantácii ustúpiť.</p>

<p>To neznamená, že vysoký Lp(a) pri CKD možno ignorovať. Pacient už má zvýšené základné kardiovaskulárne riziko a Lp(a) môže upozorniť na ďalšiu aterogénnu záťaž. Výsledok však treba interpretovať spolu s eGFR, albuminúriou alebo proteinúriou, dialyzačnou modalitou, zápalovým stavom a časom odberu. Pri aktívnom nefrotickom syndróme je rozumné zvážiť kontrolu po remisii, ak by pretrvávanie vysokej hodnoty zmenilo dlhodobý plán.</p>

<p>Samotná vysoká koncentrácia Lp(a) nemení dôkazový základ hypolipidemickej liečby pri dialýze a nie je dôvodom na mechanické začatie statínu či aferézy. O liečbe rozhodujú klinické ASCVD, štádium CKD, vek, očakávaný prínos, súčasné odporúčania a preferencie pacienta.</p>

<h2>Praktický algoritmus pre ambulanciu</h2>

<ol>
  <li>Stanoviť Lp(a) aspoň raz u každého dospelého a výsledok trvalo zaznamenať spolu s jednotkou.</li>
  <li>Neprepočítavať mg/dl na nmol/l pevným koeficientom a pri nejasnosti overiť laboratórnu metódu.</li>
  <li>Výsledok hodnotiť kontinuálne a v kontexte celkového rizika, nie izolovane podľa jedného prahu.</li>
  <li>Pri vysokej hodnote skontrolovať LDL-C, non-HDL cholesterol alebo apoB, krvný tlak, diabetes, fajčenie, funkciu obličiek, albuminúriu a rodinnú anamnézu.</li>
  <li>Intenzifikovať ovplyvniteľné rizikové faktory podľa platných odporúčaní a zvážiť kaskádové vyšetrenie rodiny.</li>
  <li>Meranie rutinne neopakovať; zopakovať ho iba pri klinicky významnej zmene stavu, možnom sekundárnom ovplyvnení alebo špecifickej liečbe.</li>
</ol>

<h2>Záver</h2>

<p>Lp(a) je prevažne geneticky určený, kauzálny a často nezistený rizikový faktor ASCVD a kalcifikujúcej aortálnej stenózy. Jedno správne interpretované meranie môže odhaliť celoživotné riziko, ktoré bežný lipidový profil nezachytí. Význam výsledku rastie spolu s celkovým kardiovaskulárnym rizikom a nemá sa redukovať na jediný univerzálny prah.</p>

<p>Kým výsledkové štúdie cielenej liečby neprinesú presvedčivé údaje, najdôležitejším dôsledkom vysokého Lp(a) je skoršia a dôslednejšia kontrola LDL cholesterolu, krvného tlaku, diabetu, fajčenia a ďalších ovplyvniteľných rizík. Pri CKD treba navyše myslieť na možné získané zvýšenie pri poklese funkcie obličiek, nefrotickom syndróme a peritoneálnej dialýze.</p>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Dhami R. Lipoprotein(a): The Risk Factor We Miss in Primary Care. <em>Medscape</em>. Publikované 20. augusta 2026. <a href="https://www.medscape.com/viewarticle/lipoprotein-risk-factor-we-miss-primary-care-2026a1000s6i" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></small></p>

<p><small><em><strong>Európsky konsenzus:</strong> Kronenberg F, Mora S, Stroes ESG, et al. Lipoprotein(a) in atherosclerotic cardiovascular disease and aortic stenosis: a European Atherosclerosis Society consensus statement. <em>European Heart Journal</em>. 2022;43:3925–3946. DOI: 10.1093/eurheartj/ehac361. <a href="https://pubmed.ncbi.nlm.nih.gov/36036785/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Európske odporúčania:</strong> Mach F, Koskinas KC, et al. 2025 Focused Update of the 2019 ESC/EAS Guidelines for the management of dyslipidaemias. <em>European Heart Journal</em>. 2025;46:4359–4378. DOI: 10.1093/eurheartj/ehaf190. <a href="https://www.escardio.org/guidelines/clinical-practice-guidelines/all-esc-practice-guidelines/dyslipidaemias/" target="_blank" rel="noopener noreferrer">ESC</a>.</em></small></p>

<p><small><em><strong>Americké odporúčania:</strong> Blumenthal RS, Morris PB, Gaudino M, et al. 2026 ACC/AHA/AACVPR/ABC/ACPM/ADA/AGS/APhA/ASPC/NLA/PCNA Guideline on the Management of Dyslipidemia. <em>Circulation</em>. 2026;153:e1154–e1276. DOI: 10.1161/CIR.0000000000001423. <a href="https://pubmed.ncbi.nlm.nih.gov/41824552/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Klinická interpretácia:</strong> Koschinsky ML, Bajaj A, Boffa MB, et al. A focused update to the 2019 NLA scientific statement on use of lipoprotein(a) in clinical practice. <em>Journal of Clinical Lipidology</em>. 2024;18:e308–e319. DOI: 10.1016/j.jacl.2024.03.001. <a href="https://pubmed.ncbi.nlm.nih.gov/38565461/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Nefrologický kontext:</strong> Hopewell JC, Haynes R, Baigent C. The role of lipoprotein(a) in chronic kidney disease. <em>Journal of Lipid Research</em>. 2018;59:577–585. DOI: 10.1194/jlr.R083626. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5880503/" target="_blank" rel="noopener noreferrer">PMC</a>.</em></small></p>

<p><small><em><strong>Stav výsledkových štúdií k 22. augustu 2026:</strong> <a href="https://clinicaltrials.gov/study/NCT04023552" target="_blank" rel="noopener noreferrer">Lp(a)HORIZON, NCT04023552</a> · <a href="https://clinicaltrials.gov/study/NCT05581303" target="_blank" rel="noopener noreferrer">OCEAN(a)-Outcomes, NCT05581303</a>.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_lipoprotein_a_kardiovaskularne_riziko',
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
