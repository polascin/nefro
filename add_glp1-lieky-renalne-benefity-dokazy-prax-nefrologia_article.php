<?php

/**
 * add_glp1-lieky-renalne-benefity-dokazy-prax-nefrologia_article.php
 * Odborný článok o renálnych benefitoch agonistov GLP-1 v randomizovaných štúdiách.
 * Pôvodný autor spracovaného zdroja je uvedený v source_authors.php.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-lieky-renalne-benefity-dokazy-prax-nefrologia_article.php"
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
    'title'        => 'Sú GLP-1 lieky už „lieky na obličky“? Renálne benefity v dôkazoch posledných rokov (a ako to premeniť na prax)',
    'slug'         => 'glp1-lieky-renalne-benefity-dokazy-prax-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Agonisty GLP-1 už nie sú len diabetologická téma. FLOW, SELECT, analýzy so SGLT2 a signál z SURMOUNT ukazujú renálnu ochranu v randomizovaných dátach – s dôležitými rozdielmi medzi tvrdými endpointmi a biomarkermi.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Srdcovocievne a metabolické liečby sa v CKD takmer vždy premietnu do obličiek. Posledné dva roky však priniesli silný signál, že agonisty receptora GLP-1 (a v širšom kontexte aj duálne incretinové látky) v klinických štúdiách opakovane prinášajú renálnu ochranu – nielen u diabetu 2. typu, ale aj u vybraných populácií bez diabetu.</em></p>

<p>V komentári na Medscape nefrológ Kashif J. Piracha upozorňuje, že väčšina lekárov stále zaradzuje agonisty GLP-1 do kategórie „diabetologických“ alebo „obezitologických“ liekov. Randomizované dáta z posledných 24 mesiacov však podporujú iný klinický rámec: pri vhodných pacientoch ide o lieky s preukázaným renálnym prínosom, ktoré sa v CKD manažmente majú uvažovať popri blokáde renínovo-angiotenzínového systému (RAS) a inhibítoroch SGLT2.</p>

<p>Nižšie zhrnieme štyri kľúčové klinické scenáre, navrhnuté mechanizmy a praktické body pre ambulanciu. Dôraz je na presných formuláciách: randomizovaný dôkaz nie je to isté ako kauzalita v reálnom svete a pokles UACR nie je ekvivalentom tvrdého renálneho endpointu.</p>

<h2>Prečo sa o tom oplatí hovoriť nefrológom</h2>

<p>Chronická choroba obličiek (CKD) pri diabete 2. typu zostáva jednou z najzávažnejších komplikácií. Agonisty GLP-1 znižujú glykémiu, podporujú redukciu telesnej hmotnosti a pri vybraných molekulách znižujú kardiovaskulárne riziko. Štúdia FLOW však prvýkrát v cielenej renálnej populácii preukázala, že semaglutid spomaľuje progresiu CKD a znižuje riziko závažných obličkových udalostí.</p>

<p>Pre nefrológiu je dôležité, že signál nie je obmedzený na jediný fenotyp. Objavuje sa u pacientov s diabetom 2. typu a CKD, u osôb s nadváhou alebo obezitou a etablovaným kardiovaskulárnym ochorením bez diabetu, pri súbežnej liečbe inhibítorom SGLT2 aj – s inou silou dôkazu – ako zmena albuminúrie u populácií bez východiskovej CKD. To mení načasovanie a prioritu rozhodnutia: u vhodného pacienta už nie je rozumné pasívne čakať, kým glykémia „dopadne“ na endokrinológa.</p>

<h2>Čo znamená „CKD framing“ agonistov GLP-1</h2>

<p>Pointa nie je slogan „GLP-1 sú obličkové lieky“. Presnejšie formulácie sú:</p>

<ul>
  <li>agonisty GLP-1 v randomizovaných štúdiách prinášajú renálnu ochranu v presne definovaných populáciách,</li>
  <li>účinky na obličky sú podložené tvrdými endpointmi alebo – v iných scenároch – biomarkermi,</li>
  <li>nejde o dôkaz univerzálnej kauzality v každej ambulantnej populácii, ale o robustnú evidenciu z klinických skúšaní.</li>
</ul>

<p>Ak agonista GLP-1 znižuje tvrdé renálne endpointy alebo spomaľuje pokles eGFR v randomizovaných štúdiách, má v klinickom rozhodovaní miesto nielen „na cukor“ alebo „na váhu“, ale aj v stratégii nefroprotekcie – vždy v rámci schválenej indikácie, tolerancie a ostatných pilierov liečby CKD.</p>

<h2>Štyri klinické scenáre s renálnym signálom</h2>

<div class="table-responsive" role="region" aria-label="Prehľad štyroch klinických scenárov s renálnym signálom agonistov GLP-1" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Scenár</th>
      <th scope="col">Štúdia / analýza</th>
      <th scope="col">Hlavný výsledok</th>
      <th scope="col">Sila dôkazu</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Diabetes 2. typu + CKD</th>
      <td>FLOW (semaglutid 1,0 mg týždenne)</td>
      <td>Primárny renálny kompozit −24 % (HR 0,76); pomalší pokles eGFR o 1,16 ml/min/1,73 m² ročne; celková mortalita −20 %</td>
      <td>Randomizovaná renálna štúdia, tvrdé endpointy</td>
    </tr>
    <tr>
      <th scope="row">Bez diabetu, nadváha/obezita + ASCVD</th>
      <td>SELECT – renálna analýza (semaglutid 2,4 mg)</td>
      <td>Renálny kompozit HR 0,78; pri eGFR &lt;60 ml/min/1,73 m² rozdiel eGFR o 2,19 ml/min/1,73 m² v prospech semaglutidu</td>
      <td>Predšpecifikovaná analýza, tvrdé endpointy</td>
    </tr>
    <tr>
      <th scope="row">Súbežná liečba inhibítorom SGLT2</th>
      <td>FLOW – podľa baseline SGLT2</td>
      <td>Celkový benefit semaglutidu; v podskupine na SGLT2 štatisticky významný rozdiel nepreukázaný (malá veľkosť vzorky)</td>
      <td>Podskupinová analýza, obmedzená štatistická sila</td>
    </tr>
    <tr>
      <th scope="row">Bez východiskovej CKD</th>
      <td>SURMOUNT-1/‑2 – tirzepatid</td>
      <td>Pokles UACR; pri východiskovom UACR ≥30 mg/g placebo‑korigovaná redukcia ~42 % (SURMOUNT‑1) a ~55 % (SURMOUNT‑2) po 72 týždňoch</td>
      <td>Biomarker, post hoc analýza</td>
    </tr>
  </tbody>
</table>
</div>

<h3>1. Diabetes 2. typu a CKD: štúdia FLOW</h3>

<p>Štúdia FLOW randomizovala 3 533 pacientov s diabetom 2. typu a CKD definovanou podľa eGFR a UACR na subkutánny semaglutid 1,0 mg týždenne alebo placebo. Po mediáne 3,4 roka sledovania riziko primárneho kompozitu (zlyhanie obličiek, pokles eGFR ≥50 %, úmrtie z obličkových alebo kardiovaskulárnych príčin) kleslo o 24 % (HR 0,76; 95 % CI 0,66–0,88). Priaznivý bol aj kompozit pozostávajúci iba z obličkových zložiek (HR 0,79; 95 % CI 0,66–0,94).</p>

<p>Ročný sklon eGFR bol v prospech semaglutidu o 1,16 ml/min/1,73 m². Riziko úmrtia z akejkoľvek príčiny sa znížilo o 20 % (HR 0,80; 95 % CI 0,67–0,95) a závažné nežiaduce udalosti boli častejšie v placebovej skupine (53,8 % vs 49,6 %). Ide o vysoko klinicky relevantný dôkaz v populácii, ktorú nefrológovia pravidelne vidia v ambulancii.</p>

<h3>2. Bez diabetu: renálna analýza SELECT</h3>

<p>Štúdia SELECT skúmala semaglutid 2,4 mg u osôb s nadváhou alebo obezitou a etablovaným kardiovaskulárnym ochorením bez diabetu. Predšpecifikovaná renálna analýza ukázala nižší výskyt hlavného obličkového kompozitu (1,8 % vs 2,2 %; HR 0,78; 95 % CI 0,63–0,96). Po 104 týždňoch bol rozdiel eGFR v prospech semaglutidu 0,75 ml/min/1,73 m² celkovo a 2,19 ml/min/1,73 m² u pacientov s východiskovým eGFR &lt;60 ml/min/1,73 m².</p>

<p>Renálny benefit teda nebol obmedzený na diabetickú populáciu. Neznamená to však, že každý pacient bez diabetu získa rovnaký prínos – rozhoduje indikácia, absolútne riziko, tolerancia a celkový klinický kontext.</p>

<h3>3. Pacient už liečený inhibítorom SGLT2</h3>

<p>Podskupinová analýza FLOW podľa súbežného užívania inhibítora SGLT2 je pre prax kľúčová. Celkový benefit semaglutidu oproti placebu zostal (HR 0,76). V podskupine 550 účastníkov na inhibítore SGLT2 pri východisku však rozdiel v primárnom kompozite nebol štatisticky významný (HR 1,07; 95 % CI 0,69–1,67), zatiaľ čo v skupine bez SGLT2 bol HR 0,73 (95 % CI 0,63–0,85). Interakcia nebola signifikantná (P = 0,109) a autori upozorňujú na obmedzenú štatistickú silu v menšej podskupine.</p>

<p>Bezpečnejšia interpretácia znie: v analýzach sa benefit semaglutidu objavoval bez dôkazu škodlivého interakčného efektu so SGLT2, no v už liečenej podskupine nie je preukázaný samostatný prírastkový efekt nad rámec toho, čo už inhibítor SGLT2 poskytuje. Mechanizmy oboch tried sa prekrývajú len čiastočne – v praxi ide skôr o komplementárne než o zameniteľné pôsobenie.</p>

<h3>4. Bez východiskovej CKD: biomarkerový signál tirzepatidu</h3>

<p>Pooled post hoc analýza SURMOUNT‑1 a SURMOUNT‑2 ukázala, že tirzepatid znižoval UACR u osôb s nadváhou alebo obezitou s diabetom aj bez neho. Pri východiskovom UACR ≥30 mg/g boli placebo‑korigované redukcie po 72 týždňoch približne 42 % v SURMOUNT‑1 a 55 % v SURMOUNT‑2.</p>

<p>UACR je dôležitý prognostický biomarker, ale nie je to istý typ dôkazu ako zlyhanie obličiek alebo trvalý pokles eGFR ≥50 %. Signál je biologicky a rizikovo priaznivý, no neumožňuje tvrdiť, že tirzepatid u každého pacienta bez CKD „zaručene zabráni“ vzniku CKD.</p>

<h2>Navrhované mechanizmy</h2>

<p>Renálny benefit agonistov GLP-1 sa nedá vysvetliť iba poklesom glykémie. Vo FLOW pretrvával aj u pacientov, u ktorých sa trajektória HbA1c nelíšila od placeba. Pravdepodobné cesty zahŕňajú:</p>

<ul>
  <li>redukciu telesnej hmotnosti a zlepšenie metabolického profilu,</li>
  <li>nižší krvný tlak a priaznivejšie intrarenálne hemodynamické zmeny,</li>
  <li>priame protizápalové účinky na glomerulus a podocyty.</li>
</ul>

<p>Ide o navrhované mechanizmy podporované klinickými a experimentálnymi dátami, nie o definitívne dokázanú kauzálnu reťazec u každého jednotlivca. Analógia z komentára na Medscape je užitočná: blokáda RAS a statíny posilňujú „hradzbu“, inhibítor SGLT2 otvára „úľavový ventil“ a agonista GLP-1 znižuje „hladinu vody za hrádzou“. Tri rôzne úlohy – často potrebné súčasne.</p>

<h2>Čo z toho premeniť na prax</h2>

<ol>
  <li><strong>Skoršie zváženie agonisty GLP-1.</strong> U vhodného pacienta s diabetom 2. typu a CKD má zmysel uvažovať o agoniste GLP-1 v kontexte štandardnej vrstvenej nefroprotekcie (RAS, SGLT2, prípadne finerenón podľa indikácie) – nie ako o lieku, ktorý má čakať na endokrinologické rozhodnutie.</li>
  <li><strong>UACR v rizikových skupinách.</strong> Biomarkerový signál z programu SURMOUNT podporuje východiskové a kontrolné meranie UACR u pacientov s obezitou a kardiometabolickým rizikom, najmä ak už majú zvýšenú albuminúriu alebo pokles eGFR. Nie je to automatický štandard pre každú populáciu.</li>
  <li><strong>Gastrointestinálna edukácia od prvého dňa.</strong> Nauzea sa vyskytuje približne u 20–30 % pacientov podľa režimu a titračného schémy. Včasné poučenie, pomalá eskalácia dávky a realistické očakávania zlepšujú adherenciu a znižujú riziko predčasného vysadenia.</li>
  <li><strong>Hypoglykémia pri kombinácii s inzulínom alebo sulfonylureou.</strong> Pri začatí agonisty GLP-1 u pacienta na bazálnom inzulíne s HbA1c &lt;8 % sa v štúdiách často znižoval bazálny inzulín približne o 20 % (napr. SUSTAIN‑5). Pri sulfonylureách zvážte redukciu dávky a častejšie monitorovanie glykémie; konkrétny postup individualizujte podľa rizika hypoglykémie.</li>
</ol>

<p>Pozor na objemový stav: výrazná nauzea, vracanie alebo hnačka môžu viesť k hypovolémii a akútnemu poškodeniu obličiek, najmä pri súbežnej liečbe diuretikom, blokátormi RAS alebo inhibítormi SGLT2.</p>

<h2>Záver</h2>

<p>V randomizovaných dôkazoch sa semaglutid a ďalšie incretinové lieky ukazujú ako schopné spomaliť renálne zhoršovanie alebo zlepšiť renálne rizikové markery naprieč viacerými klinickými fenotypmi. „GLP-1 framing“ ako renálne prínosných liekov je pre nefrológiu klinicky užitočný: pomáha nastaviť správnu prioritu v CKD manažmente.</p>

<p>Zároveň treba zachovať presnosť. Tvrdé renálne endpointy z FLOW a SELECT nie sú zameniteľné s poklesom UACR v post hoc analýzach obezitných štúdií. Kombinácia s inhibítorom SGLT2 je logická a v celkovej populácii FLOW podporovaná, no prírastkový efekt v už liečenej podskupine zostáva štatisticky nepreukázaný. Praktický prínos vznikne až vtedy, keď sa dôkazy pretavia do individuálneho plánu: správna indikácia, vrstvená nefroprotekcia, monitorovanie UACR a eGFR, edukácia k gastrointestinálnym nežiaducim účinkom a bezpečná úprava súbežnej antidiabetickej liečby.</p>

<hr>

<p><em><strong>Zdroj:</strong> Kashif J. Piracha, <em>Are GLP-1 Drugs Now Kidney Drugs?</em>, Medscape (2026). <a href="https://www.medscape.com/viewarticle/are-glp-1-drugs-now-kidney-drugs-2026a1000sv9" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>

<h2>Ďalšie referencie</h2>

<ol>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, et al.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> New England Journal of Medicine. 2024;391:109–121. doi: 10.1056/NEJMoa2403347. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Colhoun HM, Lingvay I, Brown PM, et al.</strong> <em>Long-term kidney outcomes of semaglutide in obesity and cardiovascular disease in the SELECT trial.</em> Nature Medicine. 2024;30:2058–2066. doi: 10.1038/s41591-024-03015-5. <a href="https://pubmed.ncbi.nlm.nih.gov/38796653/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1038/s41591-024-03015-5" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Mann JFE, Rossing P, Bakris G, et al.</strong> <em>Effects of semaglutide with and without concomitant SGLT2 inhibitor use in participants with type 2 diabetes and chronic kidney disease in the FLOW trial.</em> Nature Medicine. 2024;30:2849–2856. doi: 10.1038/s41591-024-03133-0. <a href="https://pubmed.ncbi.nlm.nih.gov/38914124/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1038/s41591-024-03133-0" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Heerspink HJL, Friedman AN, Bjornstad P, et al.</strong> <em>Kidney parameters with tirzepatide in obesity with or without type 2 diabetes.</em> Journal of the American Society of Nephrology. 2025;36:2190–2200. doi: 10.1681/ASN.0000000764. <a href="https://pubmed.ncbi.nlm.nih.gov/40512543/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1681/ASN.0000000764" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Rodbard HW, Aroda VR, Rosenstock J, et al.</strong> <em>Semaglutide Added to Basal Insulin in Type 2 Diabetes (SUSTAIN 5).</em> Diabetes Care. 2018;41(7):1508–1516. doi: 10.2337/dc17-2696. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5991220/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_glp1-lieky-renalne-benefity-dokazy-prax-nefrologia_article',
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
