<?php
/**
 * Odborne a jazykovo revidovaný článok o urinárnom podocalyxíne ako biomarkeri
 * diabetickej nefropatie. Spracovaná štúdia PLOS One 2026;21(7):e0347975;
 * pôvodní autori sú uvedení v source_authors.php.
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
    'title'        => 'Podocalyxín v moči pri diabetickej nefropatii: pozoruhodné čísla, ktoré zatiaľ nemožno preniesť k lôžku',
    'slug'         => 'urinarny-podocalyxin-diabeticka-nefropatia-biomarker',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Podocalyxín v moči odlíšil diabetikov s albuminúriou od tých bez nej s plochou pod krivkou 0,96. Čísla sú však vnútorne validované na 88 ľuďoch a samotné ochorenie bolo definované práve tým, čo mal marker predpovedať.',
    'content'      => <<<'HTML'
<p>Albuminúria je pri diabetickej chorobe obličiek nenahraditeľná, no má známu slabinu: objaví sa až vtedy, keď je poškodenie glomerulu už rozvinuté, a časť pacientov progreduje do zlyhania obličiek bez toho, aby ňou kedy prešla. Hľadanie skoršieho ukazovateľa je preto legitímne a podocyt je logickým miestom, kde ho hľadať – ide o terminálne diferencovanú bunku s obmedzenou schopnosťou regenerácie, ktorej strata je pri diabetickej glomerulopatii jedným z najskorších štrukturálnych nálezov.</p>

<p>Podocalyxín je silne sialylovaný glykoproteín apikálnej membrány podocytu. Udržiava negatívny náboj, ktorý bráni splynutiu susediacich pedicel, a pri poškodení sa jeho fragmenty objavujú v moči. Štúdia publikovaná v júli 2026 v časopise <em>PLOS One</em> tento marker hodnotila u diabetikov 2. typu a priniesla nezvyčajne priaznivé čísla. Práve preto si zaslúži pozorné čítanie.</p>

<h2>Ako bola štúdia postavená</h2>

<p>Ide o prierezovú analytickú štúdiu z jedného pracoviska – oddelenia vnútorného lekárstva Bangabandhu Sheikh Mujib Medical University v Dháke. Zaradených bolo <strong>88 dospelých vo veku od 40 rokov</strong>: 59 s diabetom 2. typu a 29 zdravých kontrol z radov personálu a sprevádzajúcich príbuzných. Nábor prebiehal od 25. marca 2023 do 3. augusta 2024.</p>

<p>Diabetici boli podľa pomeru albumínu ku kreatinínu (uACR) z jednorazovej vzorky moču rozdelení podľa KDIGO na normoalbuminúriu (&lt; 30 mg/g; 29 osôb), mikroalbuminúriu (30–300 mg/g; 15 osôb) a makroalbuminúriu (&gt; 300 mg/g; 15 osôb). Pre analýzu diagnostickej výkonnosti sa mikroalbuminúria a makroalbuminúria zlúčili ako <em>diabetická nefropatia</em> (30 osôb) a normoalbuminurickí diabetici spolu s kontrolami ako skupina bez nej.</p>

<p>Podocalyxín sa meral nepriamou kompetitívnou metódou ELISA (Exocell) z 10 ml stredného prúdu moču, v riedení 1 : 2 a v duplikátoch; variačný koeficient v rámci aj medzi meraniami bol pod 8 %. Vzorky sa centrifugovali a skladovali pri −80 °C.</p>

<p>Kľúčové vylučovacie kritérium je pritom v podklade často opomínané: <strong>zo štúdie boli vylúčení všetci pacienti liečení inhibítormi angiotenzín konvertujúceho enzýmu, sartanmi aj blokátormi kalciových kanálov spomaľujúcimi frekvenciu</strong>. Autori výslovne uvádzajú, že preto nebolo potrebné žiadne vymývacie obdobie – nikto z účastníkov tieto lieky neužíval.</p>

<h2>Výsledky</h2>

<div class="table-responsive" role="region" aria-label="Koncentrácia podocalyxínu v moči podľa stupňa albuminúrie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina</th>
      <th scope="col">Počet</th>
      <th scope="col">Podocalyxín v moči (ng/ml)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Diabetici s normoalbuminúriou</th>
      <td>29</td>
      <td>1,16 ± 0,39</td>
    </tr>
    <tr>
      <th scope="row">Diabetici s albuminúriou spolu</th>
      <td>30</td>
      <td>5,48 ± 2,89</td>
    </tr>
    <tr>
      <th scope="row">Z toho makroalbuminúria</th>
      <td>15</td>
      <td>7,28 ± 2,05</td>
    </tr>
  </tbody>
</table>
</div>

<p>Vzostup naprieč kategóriami bol štatisticky významný (p &lt; 0,001). Podocalyxín koreloval s uACR (Pearsonovo r = 0,79) a nepriamo s odhadovanou filtráciou (r = −0,51), obe p &lt; 0,001. Menej citovaný, ale metodicky dôležitý údaj: rovnaká práca uvádza aj Kendallovo τ-b, ktoré je podstatne nižšie – <strong>0,61 pre uACR a −0,36 pre eGFR</strong>. Rozdiel medzi oboma mierami naznačuje, že Pearsonovu koreláciu poháňajú extrémne hodnoty v skupine s makroalbuminúriou.</p>

<h2>Diagnostická výkonnosť</h2>

<div class="table-responsive" role="region" aria-label="Hraničné hodnoty podocalyxínu v moči a ich diagnostická výkonnosť" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Porovnanie</th>
      <th scope="col">Prah</th>
      <th scope="col">Senzitivita / špecificita</th>
      <th scope="col">Plocha pod krivkou</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Kontroly verzus diabetici bez albuminúrie</th>
      <td>0,80 ng/ml</td>
      <td>100,0 % / 96,4 %</td>
      <td>0,989</td>
    </tr>
    <tr>
      <th scope="row">Bez albuminúrie verzus mikroalbuminúria</th>
      <td>1,60 ng/ml</td>
      <td>86,7 % / 93,1 %</td>
      <td>0,918</td>
    </tr>
    <tr>
      <th scope="row">Mikroalbuminúria verzus makroalbuminúria</th>
      <td>5,51 ng/ml</td>
      <td>86,7 % / 93,3 %</td>
      <td>0,893</td>
    </tr>
    <tr>
      <th scope="row">Celková diskriminácia nefropatie</th>
      <td>2,92 ng/ml</td>
      <td>86,7 % / 100,0 %</td>
      <td>0,96 (95 % IS 0,90–1,00)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pri prahu 2,92 ng/ml práca uvádza pozitívnu prediktívnu hodnotu 100,0 %, negatívnu 89,9 % a presnosť 93,2 %. Vo Firthovej penalizovanej logistickej regresii – použitej pre kvázi úplnú separáciu skupín – bolo každé zvýšenie o 1 ng/ml spojené s upraveným pomerom šancí 22,67 (95 % IS 2,47–208,09; p = 0,006) po úprave na vek, pohlavie, trvanie diabetu a systolický tlak. Sami autori tento odhad pre extrémne široký interval označujú za exploračný.</p>

<h2>Prečo tieto čísla nemožno čítať ako diagnostickú validáciu</h2>

<ol>
  <li><strong>Referenčný štandard je totožný s tým, čo sa má predpovedať.</strong> Diabetická nefropatia tu nebola potvrdená biopsiou ani dlhodobým priebehom – bola <em>definovaná</em> hodnotou uACR. Podocalyxín teda nepredpovedá ochorenie, ale zaraďuje pacienta do kategórie albuminúrie. Plocha pod krivkou 0,96 hovorí o zhode dvoch ukazovateľov poškodenia glomerulu meraných v tej istej vzorke moču v ten istý deň.</li>
  <li><strong>Prahy pochádzajú z toho istého súboru, v ktorom sa aj testovali.</strong> Bootstrapová korekcia optimizmu s 2 000 opakovaniami je správny krok a ukázala minimálny optimizmus, no ide stále o <em>internú</em> validáciu. Externú validáciu v nezávislej kohorte autori sami označujú za podmienku klinického použitia.</li>
  <li><strong>Označenie „skorý biomarker“ ide nad rámec dizajnu.</strong> Prierezová štúdia nevie ukázať, že marker stúpa <em>skôr</em> než albuminúria – na to treba longitudinálne sledovanie normoalbuminurických diabetikov až po vznik albuminúrie alebo po pokles filtrácie.</li>
  <li><strong>Vylúčenie blokády RAAS zásadne obmedzuje prenositeľnosť.</strong> V bežnej nefrologickej ambulancii je pacient s diabetom 2. typu a albuminúriou takmer vždy liečený sartanom alebo ACE inhibítorom, čoraz častejšie aj inhibítorom SGLT2 alebo finerenónom. Presne táto populácia v štúdii chýba, pričom všetky uvedené lieky albuminúriu znižujú a s ňou pravdepodobne aj koncentráciu podocytárnych fragmentov.</li>
  <li><strong>Prediktívne hodnoty závisia od prevalencie.</strong> Pozitívna prediktívna hodnota 100 % je výsledkom súboru, kde má „ochorenie“ zhruba polovica testovaných. V populácii skrínovaných diabetikov, kde je albuminúria oveľa zriedkavejšia, by pri rovnakej senzitivite a špecificite klesla podstatne nižšie.</li>
  <li><strong>Drobná nezrovnalosť v samotnej práci.</strong> Pri uvádzaných počtoch správne klasifikovaných (26 z 30 s nefropatiou a 29 z 29 bez nej) vychádza negatívna prediktívna hodnota približne 88 %, nie 89,9 %. Senzitivita, špecificita, pozitívna prediktívna hodnota aj presnosť 93,2 % sedia. Ide zjavne o preklep, ktorý však prevzali aj sekundárne správy.</li>
  <li><strong>Súbor je malý a jednocentrický.</strong> Osemdesiatosem ľudí, z toho 30 s cieľovým stavom, je rozsah vhodný na prieskumnú prácu, nie na stanovenie prahov pre prax.</li>
</ol>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o podocalyxíne v moči" tabindex="0">
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
      <th scope="row">Podocalyxín v moči stúpa s narastajúcou albuminúriou</th>
      <td>Potvrdené</td>
      <td>Z 1,16 ± 0,39 na 7,28 ± 2,05 ng/ml; p &lt; 0,001 pre trend.</td>
    </tr>
    <tr>
      <th scope="row">Koreluje s uACR (r = 0,79) a nepriamo s eGFR (r = −0,51)</th>
      <td>Potvrdené s výhradou</td>
      <td>Ide o Pearsonove koeficienty. Kendallovo τ-b je 0,61 a −0,36, čo naznačuje vplyv extrémnych hodnôt.</td>
    </tr>
    <tr>
      <th scope="row">Plocha pod krivkou 0,96 dokazuje vysokú diagnostickú presnosť</th>
      <td>Zavádzajúce</td>
      <td>Referenčným štandardom bola samotná albuminúria meraná súčasne. Ide o zhodu dvoch markerov, nie o overenie voči nezávislej diagnóze.</td>
    </tr>
    <tr>
      <th scope="row">Ide o „skorý“ biomarker</th>
      <td>Neisté</td>
      <td>Mechanisticky vierohodné, no prierezový dizajn časovú následnosť ani predikciu nepreukazuje.</td>
    </tr>
    <tr>
      <th scope="row">Pomer šancí 22,67 znamená silnú nezávislú asociáciu</th>
      <td>Neisté</td>
      <td>Interval spoľahlivosti 2,47–208,09 je taký široký, že veľkosť účinku nemožno určiť. Autori odhad označujú za exploračný.</td>
    </tr>
    <tr>
      <th scope="row">Výsledky sú použiteľné na skríning v ambulancii</th>
      <td>Nesprávne</td>
      <td>Chýba externá validácia, prahy sú vnútorne odvodené a pacienti na blokáde RAAS boli vylúčení.</td>
    </tr>
    <tr>
      <th scope="row">Negatívna prediktívna hodnota je 89,9 %</th>
      <td>Nepresné</td>
      <td>Z uvádzaných počtov vychádza približne 88 %. Rozdiel je malý, ale číslo prevzali aj sekundárne správy.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo by musel marker splniť, aby sa dostal do praxe</h2>

<ol>
  <li><strong>Longitudinálny dôkaz predikcie.</strong> U normoalbuminurických diabetikov ukázať, že vyššia východisková hodnota predpovedá vznik albuminúrie alebo pokles filtrácie o vopred určenú veličinu.</li>
  <li><strong>Externú validáciu prahov</strong> v nezávislej kohorte, iným laboratóriom a ideálne inou súpravou.</li>
  <li><strong>Pridanú hodnotu nad rámec uACR a eGFR.</strong> Nestačí dobrá plocha pod krivkou samotného markera – treba ukázať zlepšenie diskriminácie, kalibrácie alebo reklasifikácie oproti modelu, ktorý albuminúriu a filtráciu už obsahuje.</li>
  <li><strong>Správanie pri liečbe.</strong> Ako sa hodnota mení pri blokáde RAAS, inhibítoroch SGLT2 a finerenóne – a či zmena markera zodpovedá zmene prognózy.</li>
  <li><strong>Analytickú štandardizáciu.</strong> Porovnateľnosť medzi súpravami, referenčný materiál, stabilitu vzorky a spôsob normalizácie na kreatinín v moči.</li>
  <li><strong>Rozhodovací dôsledok.</strong> Otázka nie je „koreluje“, ale „zmení sa vďaka nemu liečba a zlepší sa tým výsledok pacienta“.</li>
</ol>

<h2>Praktický záver</h2>

<p>Podocalyxín v moči je mechanisticky presvedčivý kandidát a táto práca je poctivo urobená prieskumná štúdia, ktorá navyše vlastné limity priznáva. Jej výsledky sa však nedajú preložiť do vety „nový test odhalí diabetickú nefropatiu skôr“. Ukazujú niečo skromnejšie a stále užitočné: <strong>množstvo podocytárnych fragmentov v moči odstupňovane odráža závažnosť glomerulového poškodenia u diabetikov neliečených blokádou RAAS.</strong></p>

<p>Pre nefrologickú prax sa dnes nemení nič. Skríning diabetickej choroby obličiek stojí naďalej na uACR a eGFR, ich pravidelnom opakovaní a na včasnom nasadení liečby s doloženým prínosom. Podocytárne markery sledujme ako sľubný smer výskumu – nie ako test, ktorý by sme mali objednávať.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=perzistujuca-mikroskopicka-hematuria-podocytopatie-prognoza">Perzistujúca mikroskopická hematúria pri podocytopatiách: prognostický signál, nie terapeutický cieľ</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=diabeticka-choroba-obliciek-bez-zahad">Diabetická choroba obličiek bez záhad</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Hossain MS, Dwipi ST, Ahmed N, Murshed KM, Aftab KA, Al Mahdi A, Hoque MM, Taraq MJH, Hussain MZ, Azad MAK. Urinary podocalyxin as an early biomarker for diabetic nephropathy. <em>PLOS One</em>. 2026;21(7):e0347975. doi: 10.1371/journal.pone.0347975. <a href="https://journals.plos.org/plosone/article?id=10.1371/journal.pone.0347975" target="_blank" rel="noopener noreferrer">Plný text</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42490553/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Nefrologické odporúčanie:</strong> Kidney Disease: Improving Global Outcomes CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný autorský zoznam aj všetky číselné výsledky boli overené 23. augusta 2026 priamo z otvoreného plného textu práce, z PubMedu a z Crossrefu. Prepočet negatívnej prediktívnej hodnoty na približne 88 % je vlastným výpočtom z počtov uvedených autormi. Uvedené hraničné hodnoty sú výskumné a nie sú určené na klinické rozhodovanie.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_urinarny_podocalyxin_dn',
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
