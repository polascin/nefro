<?php
/**
 * Odborne a jazykovo revidovaný článok o prevalencii a meraní pruritu spojeného
 * s chronickou chorobou obličiek u hemodialyzovaných. Spracovaná štúdia
 * J Ren Care 2026;52(3):e70075; pôvodné autorky sú uvedené v source_authors.php.
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

$articles = [];

$articles[] = [
    'title'        => 'Svrbenie na dialýze: prečo sa udávaná prevalencia líši dvojnásobne a čo pacient sám nepovie',
    'slug'         => 'ckd-ap-pruritus-hemodialyza-prevalencia-meranie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Turecká štúdia udáva stredne ťažký až ťažký pruritus u 16,3 % dialyzovaných, iné kohorty u 23 až 40 %. Rozdiel nevzniká v pacientoch, ale v použitom nástroji – a najcennejšia časť práce je celkom inde než v číslach.',
    'content'      => <<<'HTML'
<p>Pruritus spojený s chronickou chorobou obličiek patrí k symptómom, ktoré dialyzovaného pacienta obťažujú najviac a v ambulancii sa spomenú najmenej. Nová turecká štúdia s kombinovaným kvantitatívno-kvalitatívnym dizajnom priniesla údaj, ktorý sa rýchlo rozšíril: stredne ťažké až ťažké svrbenie malo <strong>16,3 %</strong> hemodialyzovaných.</p>

<p>To číslo je vecne správne – a zároveň sa nedá použiť ako odpoveď na otázku „koľko našich pacientov svrbí“. Dôvod je poučný a týka sa každého symptómového ukazovateľa, ktorý meriame dotazníkom.</p>

<h2>Čo štúdia urobila</h2>

<p>Autorky použili sekvenčný vysvetľujúci zmiešaný dizajn: prierezovú kvantitatívnu fázu a na ňu nadväzujúcu kvalitatívnu fázu s reflexívnou tematickou analýzou. Prebehla v troch dialyzačných strediskách pridružených k univerzitnej nemocnici v Ankare od októbra 2025 do januára 2026. Z približne 520 dialyzovaných dospelých sa zúčastnilo <strong>294 (56,5 %)</strong>; dôvody neúčasti zvyšných pacientov práca neuvádza.</p>

<p>Závažnosť sa merala tureckou verziou päťdimenzionálnej škály svrbenia (5-D), ktorá hodnotí trvanie, intenzitu, vývoj, obmedzenie činností a rozsah postihnutia. Priemerné skóre bolo 8,00 ± 3,21 pri nameranom rozsahu 5,00 až 19,75 a vnútornej konzistencii 0,77.</p>

<div class="table-responsive" role="region" aria-label="Rozdelenie závažnosti svrbenia podľa škály 5-D v súbore 294 hemodialyzovaných" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kategória podľa 5-D</th>
      <th scope="col">Skóre</th>
      <th scope="col">Počet</th>
      <th scope="col">Podiel</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">„Bez pruritu“</th>
      <td>5–8</td>
      <td>193</td>
      <td>65,6 %</td>
    </tr>
    <tr>
      <th scope="row">Mierny</th>
      <td>9–11</td>
      <td>53</td>
      <td>18,0 %</td>
    </tr>
    <tr>
      <th scope="row">Stredne ťažký</th>
      <td>12–17</td>
      <td>37</td>
      <td>12,6 %</td>
    </tr>
    <tr>
      <th scope="row">Ťažký</th>
      <td>18–21</td>
      <td>11</td>
      <td>3,7 %</td>
    </tr>
    <tr>
      <th scope="row">Veľmi ťažký</th>
      <td>≥ 22</td>
      <td>0</td>
      <td>0 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Svrbenie akéhokoľvek stupňa teda malo 101 pacientov (34,4 %) a stredne ťažké až ťažké 48 pacientov (16,3 %). Údaj 34,4 % pritom v abstrakte nie je – kto cituje len abstrakt, nájde tam iba 16,3 %.</p>

<h2>Prečo 16,3 % nie je „prevalencia svrbenia pri dialýze“</h2>

<ol>
  <li><strong>Kategória „bez pruritu“ neznamená, že pacient nesvrbí.</strong> Znamená skóre 5 až 8 na škále, ktorej minimum je 5. Pacient, ktorý svrbí občas a mierne, sa do tejto kategórie dostane bez ťažkostí.</li>
  <li><strong>Hranica pre „stredne ťažký až ťažký“ nepochádza z pôvodnej publikácie škály.</strong> Práca, ktorá 5-D zaviedla, uvádza len teoretický rozsah 5 až 25 a žiadne kategórie závažnosti nedefinuje. Použitý prah pochádza z neskoršej taiwanskej práce, ktorá kategórie odvodila lineárnou regresiou voči číselnej škále u 409 dialyzovaných v jedinom centre – bez analýzy ROC a bez uvedenia senzitivity či špecificity. V tejto štúdii sa navyše skóre 11,5 zaokrúhľovalo nahor na 12, takže skutočný prah bol 11,5.</li>
  <li><strong>Škála 5-D bola vyvinutá na meranie zmeny, nie na skríning.</strong> Jej pôvodným určením bolo sledovať vývoj svrbenia v čase v klinických skúšaniach u pacientov, ktorí pruritus <em>majú</em> – prítomnosť svrbenia bola vstupným kritériom. Použitie ako prevalenčného skríningu v neselektovanej dialyzačnej populácii je mimo overeného účelu nástroja.</li>
  <li><strong>Vylučovacie kritériá súbor systematicky očistili.</strong> Vyradení boli pacienti s psychiatrickou diagnózou alebo klinicky zjavným psychiatrickým stavom, s aktívnym dermatologickým ochorením, s cholestázou, s malignitou, s akútnou infekciou a tí, ktorí v poslednom mesiaci začali novú systémovú antipruritickú liečbu. Vzniká tak „čistý“ obraz, ktorý sa vzďaľuje bežnej ambulancii – a vylúčenie psychiatrickej komorbidity pravdepodobne záťaž symptómom podhodnocuje, keďže depresia a úzkosť vnímanie aj hlásenie svrbenia priamo ovplyvňujú.</li>
  <li><strong>Iné kohorty udávajú výrazne viac.</strong> Francúzska prospektívna multicentrická štúdia so systematickým skríningom udáva stredne ťažký až ťažký pruritus u 23,5 %, novšie európske prehľady 31 až 40 %. Rozdiel autorky samy pripisujú odlišným nástrojom a prahom.</li>
</ol>

<p>Praktický dôsledok: <strong>prevalencia symptómu je funkciou toho, čím a s akou hranicou ho meriame.</strong> Číslo 16,3 % platí pre túto škálu, tento prah a tento súbor. Prenášať ho na slovenskú dialyzačnú populáciu ako „každý šiesty“ by bolo nepresné oboma smermi.</p>

<h2>Čo je na práci naozaj cenné</h2>

<p>Ťažisko hodnoty nie je v prevalencii, ale v dvoch iných zisteniach.</p>

<p><strong>Prvé: liečba, ktorú pacienti dostávajú, im väčšinou nepomáha.</strong> Nejaký liek na svrbenie pravidelne užívalo 212 z 294 pacientov (72,1 %), z toho perorálne antihistaminiká 143 (48,6 %) a krémy alebo emolienciá 96 (32,7 %). Účinok hodnotili takto:</p>

<div class="table-responsive" role="region" aria-label="Hodnotenie účinku užívanej liečby svrbenia medzi 212 užívateľmi liekov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Vnímaný účinok</th>
      <th scope="col">Počet</th>
      <th scope="col">Podiel z 212 užívateľov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Žiadny</th>
      <td>100</td>
      <td>47,2 %</td>
    </tr>
    <tr>
      <th scope="row">Krátkodobý (≤ 24 h)</th>
      <td>78</td>
      <td>36,8 %</td>
    </tr>
    <tr>
      <th scope="row">Dlhodobejší (&gt; 24 h)</th>
      <td>34</td>
      <td>16,0 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Takmer polovica liečených teda nemá zo svojej liečby žiaden úžitok, pričom najčastejšie predpisovanou skupinou sú antihistaminiká – lieky, ktorých neúčinnosť pri uremickom prurite je patofyziologicky očakávaná, pretože svrbenie tu nie je histamínovo sprostredkované.</p>

<p><em>Poznámka k údajom: pôvodná tabuľka uvádza tieto podiely vztiahnuté na celý súbor 294 pacientov (34,0 %, 26,5 % a 11,6 %). Vyššie uvedené podiely sú prepočítané na 212 skutočných užívateľov liekov, čo je klinicky zmysluplnejší menovateľ.</em></p>

<p><strong>Druhé: pacienti symptóm nehlásia.</strong> Kvalitatívna fáza zahrnula všetkých 48 osôb so stredne ťažkým až ťažkým svrbením, každú aspoň v dvoch pološtruktúrovaných rozhovoroch. Vynorili sa štyri témy: bremeno pruritu (narušený spánok, emočná záťaž, stigma, kolísanie intenzity a jeho prijímanie ako nevyhnutnej súčasti liečby), zvládacie stratégie (chlad, emolienciá, lieky s útlmom), <strong>bariéry v komunikácii</strong> (váhanie ozvať sa, keď je personál zaneprázdnený, alebo keď má pacient pocit, že sa symptóm zľahčuje) a očakávania od starostlivosti (rozpor medzi očakávaným riešením a vnímaným dočasným efektom).</p>

<p>Práve táto časť vysvetľuje, prečo je pruritus v dokumentácii podhodnotený: nejde o to, že pacienti nesvrbia, ale že sa nepýtame a oni sami tému neotvoria.</p>

<h2>Asociácie, ktoré sa nesmú prečítať naopak</h2>

<p>Vo viacrozmernom modeli boli s vyšším rizikom stredne ťažkého až ťažkého svrbenia spojené komorbidné chronické ochorenie (pomer šancí 2,399; 95 % IS 1,126–5,112) a <em>predchádzajúca edukácia o prurite</em> (3,145; 1,258–7,859), s nižším rizikom manželský stav (0,418; 0,202–0,867). Pohlavie ani vek významné neboli.</p>

<ul>
  <li><strong>Edukácia svrbenie nezhoršuje.</strong> Ide o učebnicovú protopatickú zaujatosť: edukáciu dostali práve tí, ktorí mali ťažšie príznaky. Autorky to samy pripúšťajú a označujú za reaktívne poskytovanie starostlivosti. Číslo nemožno interpretovať prognosticky ani kauzálne.</li>
  <li><strong>Manželstvo je zástupná premenná</strong> pre psychosociálnu podporu, možno aj pre ochotu symptóm nahlásiť – nie ochranný faktor.</li>
  <li><strong>„Komorbidita“ je binárny súhrn</strong> spájajúci diabetes, hypertenziu a srdcové ochorenie; nehovorí, ktorá z nich je relevantná.</li>
  <li><strong>Model je poddimenzovaný.</strong> Na 48 udalostí pripadá šesť prediktorových stupňov voľnosti a odhad pre edukáciu stojí na deviatich udalostiach v 27-člennej exponovanej skupine, čomu zodpovedajú aj široké intervaly.</li>
  <li><strong>Chýba adjustácia na klinické determinanty.</strong> V práci sa nevyskytuje Kt/V, fosfát, vápnik, parathormón, albumín, β2-mikroglobulín, hemoglobín ani xeróza – teda presne tie premenné, ktoré pri uremickom prurite zvažujeme ako prvé.</li>
</ul>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o prevalencii a meraní pruritu pri hemodialýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Stredne ťažký až ťažký pruritus malo 16,3 % pacientov</th>
      <td>Potvrdené</td>
      <td>48 zo 294 pri prahu 5-D ≥ 11,5. Platí pre tento nástroj a prah, nie ako všeobecná prevalencia.</td>
    </tr>
    <tr>
      <th scope="row">Svrbenie akéhokoľvek stupňa malo 34,4 %</th>
      <td>Potvrdené</td>
      <td>101 z 294. Údaj je len v plnom texte, nie v abstrakte.</td>
    </tr>
    <tr>
      <th scope="row">Zvyšných 65,6 % pacientov nesvrbí</th>
      <td>Nesprávne</td>
      <td>Kategória zodpovedá skóre 5–8 na škále s minimom 5; mierne alebo občasné svrbenie do nej spadá.</td>
    </tr>
    <tr>
      <th scope="row">Prah ≥ 12 pochádza z pôvodnej publikácie škály 5-D</th>
      <td>Nesprávne</td>
      <td>Pôvodná práca kategórie závažnosti nedefinuje. Prah pochádza z neskoršej jednocentrickej taiwanskej práce bez analýzy ROC.</td>
    </tr>
    <tr>
      <th scope="row">Predchádzajúca edukácia je spojená s ťažším svrbením</th>
      <td>Potvrdené, ale zavádzajúco</td>
      <td>Ide o obrátenú príčinnosť: edukáciu dostali pacienti s horšími príznakmi. Autorky to samy uvádzajú.</td>
    </tr>
    <tr>
      <th scope="row">Takmer polovica liečených nemá zo svojej liečby účinok</th>
      <td>Potvrdené</td>
      <td>100 z 212 užívateľov liekov; najčastejšie sa podávajú antihistaminiká, ktoré pri uremickom prurite nemajú patofyziologické opodstatnenie.</td>
    </tr>
    <tr>
      <th scope="row">Štúdia hodnotí modernú liečbu (difelikefalín, gabapentinoidy, fototerapiu)</th>
      <td>Nesprávne</td>
      <td>Tieto možnosti sa v práci vôbec nevyskytujú. Nemožno ju citovať v terapeutickom kontexte.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo z toho vyplýva pre dialyzačnú ambulanciu</h2>

<ol>
  <li><strong>Pýtať sa aktívne a pravidelne.</strong> Bez cielenej otázky sa symptóm nedozvieme – to je najlepšie doložené zistenie celej práce. Stačí jedna otázka pri mesačnej kontrole.</li>
  <li><strong>Použiť jeden nástroj a držať sa ho.</strong> Číselná škála 0 až 10 alebo 5-D sú obe použiteľné; dôležitejšie než výber je, aby sa u toho istého pacienta nemenil a aby sa hodnota zaznamenávala.</li>
  <li><strong>Nezostať pri antihistaminikách.</strong> Ich rozšírené podávanie je zvyk, nie dôkaz; polovica liečených z nich nemá úžitok a u starších pacientov prinášajú útlm a riziko pádov.</li>
  <li><strong>Prejsť odstrániteľné príčiny.</strong> Xerózu, dávku dialýzy, fosfátovo-kalciovú rovnováhu a parathormón, anémiu, liekovú anamnézu a kožné ochorenie, ktoré s obličkami nesúvisí.</li>
  <li><strong>Vedieť, že existujú cielené možnosti.</strong> Súčasné európske prehľady k liečbe pruritu pri dialýze uvádzajú aj gabapentinoidy, fototerapiu a agonisty κ-opioidných receptorov – tieto údaje však pochádzajú z inej literatúry než z opisovanej štúdie.</li>
  <li><strong>Zmeniť prostredie rozhovoru.</strong> Ak pacient váha ozvať sa, keď je personál zaneprázdnený, pomôže zaradiť otázku na svrbenie do pevnej štruktúry kontroly, nie ju ponechať na jeho iniciatívu.</li>
</ol>

<h2>Poznámka k spoľahlivosti zdroja</h2>

<p>Práca je voľne dostupná a jej kvalitatívna časť je poctivo urobená, obsahuje však aj nezrovnalosti, ktoré redakčná kontrola nezachytila: vekové kategórie sú v dvoch tabuľkách obsadené navzájom opačne a časť podielov v tabuľke liečby má odlišné menovatele bez upozornenia. Z tohto dôvodu tento text nepreberá zo štúdie žiadne vekové údaje. Sekundárna spravodajská správa o štúdii navyše pripisuje autorkám tvrdenie o prenositeľnosti na severoamerickú populáciu, ktoré sa v pôvodnom článku nenachádza.</p>

<h2>Záver</h2>

<p>Zo štúdie si netreba odniesť číslo, ale mechanizmus. Prevalencia symptómu závisí od nástroja a prahu, takže rozdiel medzi 16 a 40 % nie je sporom o pacientov, ale o meranie. Klinicky použiteľné zistenie je iné a nemenej dôležité: <strong>pacienti o svrbení nehovoria, dostávajú liečbu, ktorá im v polovici prípadov nepomáha, a s oboma vecami vieme niečo urobiť hneď.</strong></p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=neuroimunitna-architektura-uremickeho-pruritu-ckd-ap">Neuroimunitná architektúra uremického pruritu: model štyroch uzlov a jeho terapeutické dôsledky</a></li>
  <li><a href="article.php?slug=krce-kostroveho-svalstva-dialyza-prevalencia-metaanalyza">Kŕče kostrového svalstva pri dialýze: globálna prevalencia 55 % a čo s tým v praxi</a></li>
  <li><a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">Stanovenie suchej váhy (EDW) pri hemodialýze: klinický odhad, BCM, BVM a POCUS</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Turgay G, Özdemir Eler Ç. Chronic Kidney Disease-Associated Pruritus in Haemodialysis: A Mixed-Methods Study of Symptom Burden and Patient Experience. <em>Journal of Renal Care</em>. 2026;52(3):e70075. doi: 10.1111/jorc.70075. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13417541/" target="_blank" rel="noopener noreferrer">Plný text</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42522761/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Pôvodná publikácia škály 5-D:</strong> Elman S, Hynan LS, Gabriel V, Mayo MJ. The 5-D itch scale: a new measure of pruritus. <em>British Journal of Dermatology</em>. 2010;162(3):587–593. doi: 10.1111/j.1365-2133.2009.09586.x. <a href="https://pubmed.ncbi.nlm.nih.gov/19995367/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Zdroj použitých hraníc závažnosti:</strong> Lai JW, Chen HC, Chou CY, Yen HR, Li TC, Sun MF, Chang HH, Huang CC, Tsai FJ, Tschen J, Chang CT. Transformation of 5-D itch scale and numerical rating scale in chronic hemodialysis patients. <em>BMC Nephrology</em>. 2017;18(1):56. doi: 10.1186/s12882-017-0475-z. <a href="https://pubmed.ncbi.nlm.nih.gov/28178931/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Porovnávacia prevalencia:</strong> Lanot A, Bataille S, Rostoker G, Bataille P, Chauveau P, Touzot M, Misery L. Moderate-to-severe pruritus in untreated or non-responsive hemodialysis patients: results of the French prospective multicenter observational study Prurit-HD. <em>Clinical Kidney Journal</em>. 2023;16(7):1102–1112. doi: 10.1093/ckj/sfad032. <a href="https://pubmed.ncbi.nlm.nih.gov/37398693/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Súčasný prehľad diagnostiky a liečby:</strong> Latus J, Lanot A, Ständer S, Sanchez-Alvarez E, Aucella F, Yosipovitch G. CKD-associated pruritus in haemodialysis: a road map for diagnosis and treatment. <em>Clinical Kidney Journal</em>. 2025;18(5):sfaf096. doi: 10.1093/ckj/sfaf096. <a href="https://doi.org/10.1093/ckj/sfaf096" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, autorstvo aj všetky číselné výsledky boli overené 23. augusta 2026 z otvoreného plného textu spracovanej práce, z PubMedu a z Crossrefu. Podiely vnímaného účinku liečby sú vlastným prepočtom na počet skutočných užívateľov liekov; pôvodná práca ich vzťahuje na celý súbor. Vekové údaje sa z dôvodu vnútornej nezrovnalosti v pôvodných tabuľkách neuvádzajú.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckd_ap_pruritus_prevalencia',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
