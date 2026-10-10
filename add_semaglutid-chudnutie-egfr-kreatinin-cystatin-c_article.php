<?php

/**
 * Odborný článok o interpretácii eGFR po úbytku hmotnosti pri semaglutide.
 */

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
    'title'        => 'Pacient schudol pri liečbe semaglutidom: môžeme dôverovať jeho eGFR?',
    'slug'         => 'semaglutid-chudnutie-egfr-kreatinin-cystatin-c',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Úbytok svalovej hmoty môže nadhodnotiť kreatinínovú eGFR. Analýza SMART skúmala, či približne 10 % pokles hmotnosti pri semaglutide skresľuje odhad alebo meranie GFR.',
    'content'      => <<<'HTML'
<figure><a href="img/semaglutid-chudnutie-egfr-kreatinin-cystatin-c.webp" target="_blank" rel="noopener noreferrer"><img src="img/semaglutid-chudnutie-egfr-kreatinin-cystatin-c.webp" alt="Poloschematická oblička a glomerulus s odlišnými prúdmi kreatinínu zo svalstva a cystatínu C z telesných tkanív pri úbytku hmotnosti" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Konceptuálne znázornenie neobličkových determinantov filtračných markerov pri zmene telesného zloženia. Farebné častice a ukazovatele sú symbolické; nejde o diagnostický obraz ani tvrdenie, že cystatín C je bez zdrojov skreslenia.</figcaption></figure>

<p>Pokles telesnej hmotnosti počas liečby agonistom receptora GLP-1 môže sprevádzať zmena odhadovanej glomerulovej filtrácie (eGFR). Zdanlivo priaznivý výsledok však vyvoláva otázku: zlepšila sa skutočne funkcia obličiek, alebo pacient tvorí menej kreatinínu v dôsledku zmeny telesného zloženia?</p>

<p>Vopred plánovaná analýza štúdie SMART prináša čiastočne upokojujúce údaje. Pri približne 10 % úbytku hmotnosti počas 24-týždňovej liečby semaglutidom sa v hlavných analýzach nezistila korelácia medzi zmenami hmotnosti či telesného zloženia a zmenami kreatinínovej alebo cystatínovej eGFR ani meranej GFR. Výsledok však nie je univerzálnym potvrdením presnosti eGFR pri každom rozsahu chudnutia a u každého pacienta. [1]</p>

<h2>Prečo môže chudnutie ovplyvniť eGFR</h2>

<p>Sérový kreatinín nie je priamym meraním glomerulovej filtrácie. Jeho koncentrácia závisí od filtrácie, tvorby kreatinínu, tubulárnej sekrécie, príjmu mäsa, niektorých liekov a ďalších okolností. Pri úbytku svalovej hmoty môže tvorba kreatinínu klesnúť. Kreatinínová rovnica potom môže ukázať vyššiu eGFR aj bez zodpovedajúceho zvýšenia skutočnej filtrácie.</p>

<p><strong>Úbytok telesnej hmotnosti však nie je synonymom úbytku svalov.</strong> Zahŕňa zmeny tukovej hmoty, vody aj beztukovej hmoty. Ani beztuková hmota nie je totožná s kostrovým svalstvom: zahŕňa ďalšie tkanivá a jej bioimpedančný odhad ovplyvňuje hydratácia.</p>

<p>Cystatín C je menej závislý od svalovej hmoty než kreatinín, nie je však čistým markerom filtrácie. Jeho koncentrácia môže súvisieť s adipózitou, zápalom, fajčením, poruchou funkcie štítnej žľazy a liečbou systémovými glukokortikoidmi. Kombinovaná rovnica z kreatinínu a cystatínu C zvyčajne zmierňuje vplyv neobličkových determinantov každého samostatného markera, no ani ona nie je bezchybná. [2]</p>

<h2>Čo skúmala analýza SMART</h2>

<p>Išlo o vopred plánovanú analýzu randomizovanej, dvojito zaslepenej, placebom kontrolovanej štúdie u 101 dospelých s CKD, nadváhou alebo obezitou a bez diabetu. Účastníci mali BMI ≥27 kg/m<sup>2</sup>, eGFR ≥25 ml/min/1,73 m<sup>2</sup> a pomer albumínu ku kreatinínu v moči 30–3 500 mg/g. Semaglutid dostávalo 51 účastníkov a placebo 50. Dávka sa titrovala na 2,4 mg podkožne raz týždenne a liečba trvala 24 týždňov. [1]</p>

<p>Výskumníci hodnotili kreatinínovú eGFR, cystatínovú eGFR, telesné zloženie pomocou bioimpedančnej spektroskopie a meranú GFR pomocou plazmatického klírensu iohexolu. <strong>Meraná GFR bola dostupná iba v podskupine 47 účastníkov</strong>, čo výrazne obmedzuje istotu záverov o individuálnej presnosti odhadových rovníc. [1]</p>

<h2>Hlavné výsledky po 24 týždňoch</h2>

<div class="table-responsive" role="region" aria-label="Zmeny telesného zloženia a krvného tlaku v analýze SMART" tabindex="0">
<table>
  <thead><tr><th scope="col">Parameter</th><th scope="col">Rozdiel v zmene medzi skupinami</th><th scope="col">95 % interval spoľahlivosti</th></tr></thead>
  <tbody>
    <tr><th scope="row">Telesná hmotnosť</th><td>−9,1 kg</td><td>−11,0 až −7,2 kg</td></tr>
    <tr><th scope="row">Beztuková hmota</th><td>−2,5 kg</td><td>−6,6 až 1,6 kg</td></tr>
    <tr><th scope="row">Tuková hmota</th><td>−3,9 kg</td><td>−7,8 až 0,0 kg</td></tr>
    <tr><th scope="row">Extracelulárna voda</th><td>−0,9 l</td><td>−1,6 až −0,1 l</td></tr>
    <tr><th scope="row">Systolický krvný tlak</th><td>−6,3 mmHg</td><td>−10,9 až −1,7 mmHg</td></tr>
  </tbody>
</table>
</div>

<p>Ide o rozdiely medzi liečebnými skupinami, nie o priemernú zmenu každého človeka užívajúceho semaglutid. Interval spoľahlivosti pri beztukovej hmote zahŕňal nulu, takže rozdiel oproti placebu nebol presne odhadnutý. To však nie je dôkaz úplného zachovania svalstva. Štúdia priamo nemerala objem kostrového svalstva, svalovú silu ani fyzickú výkonnosť. [1]</p>

<p>V Spearmanových korelačných analýzach neboli zmeny celkovej hmotnosti, beztukovej hmoty ani tukovej hmoty spojené so zmenami kreatinínovej eGFR, cystatínovej eGFR alebo meranej GFR; všetky korelačné koeficienty boli menšie než 0,23. Podobný záver uviedli autori aj po multivariabilnej úprave. [1]</p>

<h2>Prečo výsledok nemožno formulovať absolútne</h2>

<h3>Chýbajúca korelácia nie je validáciou každého jednotlivého výsledku</h3>

<p>Nezistenie štatisticky významnej korelácie v malom súbore nevylučuje slabšiu asociáciu ani skreslenie v rizikovej podskupine. Korelačná analýza tiež nie je plnohodnotným hodnotením presnosti, ktoré by vyžadovalo napríklad individuálny bias a podiel odhadov v akceptovanom rozmedzí od meranej GFR.</p>

<p>Údaje preto podporujú záver, že štúdia nezistila jasný signál systematického skreslenia pri približne 10 % redukcii hmotnosti. Neoprávňujú tvrdiť, že kreatinínová eGFR presne odráža filtráciu u každého jednotlivca.</p>

<h3>Nie všetky štatistické výstupy sú úplne súhlasné</h3>

<p>V tabuľke 2 pôvodnej publikácie sa pri niektorých upravených modeloch objavujú hodnoty <em>P</em> = 0,03, hoci súhrnný text opisuje analýzy ako bez významných asociácií. Tento nesúlad nemení hlavný smer výsledkov, vyžaduje však opatrnú formuláciu: <strong>hlavné korelačné analýzy súvislosť nepreukázali, nie všetky jednotlivé modely jednoznačne vylúčili akúkoľvek súvislosť.</strong> [1]</p>

<h3>Bioimpedancia nie je priame meranie svalstva</h3>

<p>Bioimpedančný odhad telesného zloženia závisí od modelových predpokladov a hydratácie. V štúdii sa súčasne zmenšila extracelulárna voda. Autori tiež uvádzajú, že súčet odhadovaných zmien tukovej a beztukovej hmoty sa nerovnal zmene celkovej hmotnosti, čo pripisujú malému súboru a neistote meraní. [1]</p>

<h3>Rozsah a trvanie boli obmedzené</h3>

<p>Sledovanie trvalo 24 týždňov a populácia nezahŕňala pacientov s diabetom. Výsledky nemožno bez ďalších údajov prenášať na podstatne väčší alebo rýchlejší úbytok hmotnosti, dlhodobú liečbu, bariatrickú chirurgiu, iné inkretínové lieky ani na krehkých či výrazne sarkopenických pacientov.</p>

<h2>Vyššia eGFR nemusí znamenať ústup CKD</h2>

<p>Prekročenie hranice 60 ml/min/1,73 m<sup>2</sup> samo osebe nepreukazuje vymiznutie chronickej choroby obličiek. Pri pretrvávajúcej albuminúrii, štruktúrnom náleze alebo inom dôkaze chronického poškodenia môže pacient naďalej spĺňať kritériá CKD. Hodnotiť treba príčinu, kategóriu GFR, kategóriu albuminúrie a trvanie nálezu. [2]</p>

<p>Rovnako nemožno vzostup eGFR automaticky považovať za pravdivé zlepšenie len preto, že semaglutid má v určitých populáciách preukázané priaznivé obličkové účinky. Účinnosť lieku na klinické výsledky a presnosť konkrétneho laboratórneho odhadu sú dve odlišné otázky.</p>

<h2>Kedy doplniť cystatín C</h2>

<p>KDIGO 2024 odporúča pri riziku nepresnosti kreatinínovej eGFR a v situácii, keď presnosť ovplyvní klinické rozhodnutie, použiť kombinovanú eGFR z kreatinínu a cystatínu C. Doplnenie cystatínu C je obzvlášť užitočné pri výraznej zmene svalovej hmoty, sarkopénii, malnutrícii, amputácii alebo nesúlade výsledku s klinickým obrazom. [2] Prakticky ide najmä o tieto situácie:</p>

<ul>
  <li>výrazný alebo rýchly úbytok hmotnosti,</li>
  <li>podozrenie na sarkopéniu, krehkosť alebo malnutríciu,</li>
  <li>nečakane veľká zmena kreatinínovej eGFR,</li>
  <li>výsledok blízko rozhodovacej hranice pre liek alebo výkon,</li>
  <li>nesúlad eGFR s albuminúriou, klinickým stavom alebo predchádzajúcim priebehom.</li>
</ul>

<p>Ak sú dostupné oba markery, má sa vypočítať validovaná kombinovaná rovnica. Nejde o aritmetický priemer dvoch samostatných eGFR. Pri rozhodnutí vyžadujúcom vysokú presnosť možno zvážiť meranú GFR pomocou exogénneho filtračného markera. [2]</p>

<h2>Praktický postup pri zmene eGFR</h2>

<ol>
  <li><strong>Overiť opakovateľnosť a kontext.</strong> Posúdiť časový priebeh kreatinínu, hmotnosti, hydratácie, krvného tlaku, príjmu potravy a interkurentných ochorení.</li>
  <li><strong>Rozlíšiť smer zmeny.</strong> Úbytok svalstva by pri nezmenenej filtrácii skôr znižoval kreatinín. Jeho vzostup preto nemožno vysvetliť stratou svalov.</li>
  <li><strong>Vylúčiť akútnu situáciu.</strong> Nauzea, vracanie a obmedzený príjem tekutín môžu viesť k hypovolémii a akútnemu poškodeniu obličiek. Pri nestabilnom kreatiníne rovnice eGFR nevyjadrujú aktuálnu filtráciu spoľahlivo.</li>
  <li><strong>Skontrolovať lieky a hemodynamiku.</strong> Zohľadniť diuretiká, blokátory renínovo-angiotenzínového systému, inhibítory SGLT2, nesteroidové antiflogistiká a nedávne zmeny dávok.</li>
  <li><strong>Určiť potrebnú presnosť.</strong> Pri dávkovaní lieku s úzkym terapeutickým rozmedzím alebo pri rozhodovaní na hranici indikácie je namieste nižší prah na použitie eGFR z kreatinínu a cystatínu C alebo meranej GFR.</li>
  <li><strong>Sledovať poškodenie obličiek aj funkčný stav.</strong> UACR nenahrádza GFR, ale dopĺňa rizikovú stratifikáciu. Pri chudnutí treba hodnotiť výživu, svalovú silu, mobilitu a funkčnosť.</li>
</ol>

<h2>Dávkovanie liekov: indexovaná a absolútna hodnota</h2>

<p>Laboratórna eGFR sa štandardne uvádza v ml/min/1,73 m<sup>2</sup>. Niektoré dávkovacie rozhodnutia však vychádzajú z absolútnej GFR v ml/min alebo z kreatinínového klírensu podľa konkrétneho registračného dokumentu. Pri výraznej zmene telesnej veľkosti možno indexovanú hodnotu prepočítať:</p>

<p><strong>GFR v ml/min = eGFR v ml/min/1,73 m<sup>2</sup> × povrch tela / 1,73.</strong></p>

<p>Deindexácia však neopraví chybu samotného filtračného markera a pri extrémnej obezite môže priniesť ďalšiu neistotu. Pri dávkovaní sa treba riadiť aktuálnym súhrnom charakteristických vlastností konkrétneho lieku; kreatinínový klírens podľa Cockcrofta a Gaulta nie je totožný s laboratórnou eGFR.</p>

<h2>Záver</h2>

<p>Štúdia SMART nepodporuje paušálne odmietanie kreatinínovej eGFR u každého pacienta, ktorý pri semaglutide schudne približne o desatinu pôvodnej hmotnosti. Zároveň neposkytuje dôvod ignorovať individuálne zdroje nepresnosti. Vhodný je odstupňovaný postup: kreatinínová eGFR ako základ, kombinácia s cystatínom C pri relevantnej neistote a meraná GFR pri rozhodnutiach vyžadujúcich vyššiu presnosť.</p>

<p><strong>Vyššia eGFR po schudnutí je výsledok, ktorý treba interpretovať, nie automatický dôkaz regenerácie obličiek ani automatický laboratórny artefakt.</strong></p>

<hr>

<p><em><strong>Literatúra</strong></em></p>
<ol>
  <li><em>Heerspink HJL, Soler M, Beernink JM, et al. Effects of Semaglutide on Body Composition and GFR: A Prespecified Analysis of the SMART Trial. Clinical Journal of the American Society of Nephrology. 2026;21(7):1149–1158. DOI: <a href="https://doi.org/10.2215/CJN.0000001051" target="_blank" rel="noopener noreferrer">10.2215/CJN.0000001051</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/42308057/" target="_blank" rel="noopener noreferrer">42308057</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13379112/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Oficiálna stránka a dokumenty</a>.</em></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_semaglutid_chudnutie_egfr',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <ul><?php foreach ($articles as $a): ?><li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li><?php endforeach; ?></ul>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>&nbsp; <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
