<?php
/**
 * Odborný článok: pioglitazón pri MASLD/MASH, diabete a CKD.
 */

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
    'title'        => 'Pioglitazón pri MASLD a MASH: histologický prínos verzus kardiorenálne riziko',
    'slug'         => 'pioglitazon-masld-mash-diabetes-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pioglitazón môže pri diabete a biopsiou potvrdenej MASH zlepšiť aktivitu steatohepatitídy. Nie je však spoľahlivo antifibrotický a pri CKD treba vážiť edémy, srdcové zlyhávanie a zlomeniny.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pioglitazón patrí medzi málo starších antidiabetík s randomizovaným histologickým signálom pri steatohepatitíde. Tento prínos však nemožno zjednodušiť na tvrdenie, že „lieči MASLD“ alebo spoľahlivo zvracia fibrózu. Pri chronickej chorobe obličiek (CKD) navyše rozhoduje jeho schopnosť zadržiavať sodík a vodu, zvyšovať hmotnosť a zhoršiť srdcové zlyhávanie. Správna otázka preto nie je, či je pioglitazón dobrý alebo zlý liek, ale či má konkrétny pacient profil, pri ktorom jeho metabolický a pečeňový prínos preváži nad objemovým a kostným rizikom.</em></p>

<p>Pioglitazón je tiazolidíndión a agonista receptora PPAR-γ. Zvyšuje citlivosť tukového tkaniva, pečene a kostrového svalstva na inzulín, znižuje lipolýzu a presúva ukladanie lipidov smerom od viscerálneho a ektopického tuku. Práve zlepšenie inzulínovej rezistencie je biologickým dôvodom, prečo môže ovplyvniť diabetes aj metabolicky asociovanú steatohepatitídu (MASH).</p>

<p>Biologická vierohodnosť však nie je náhradou klinického výsledku. Treba rozlišovať:</p>

<ul>
  <li><strong>MASLD</strong> – steatotickú chorobu pečene spojenú s metabolickou dysfunkciou,</li>
  <li><strong>MASH</strong> – zápalový fenotyp s balónovým poškodením hepatocytov,</li>
  <li><strong>fibrózu</strong> – hlavný histologický ukazovateľ dlhodobej pečeňovej prognózy,</li>
  <li><strong>klinické udalosti</strong> – dekompenzáciu cirhózy, transplantáciu a mortalitu.</li>
</ul>

<p>Zlepšenie steatózy alebo aminotransferáz automaticky nepotvrdzuje ústup MASH a ústup MASH automaticky nedokazuje zlepšenie fibrózy ani dlhodobého prežívania.</p>

<h2>Čo ukázali hlavné randomizované štúdie</h2>

<div class="table-responsive" role="region" aria-label="Hlavné randomizované údaje o pioglitazóne pri steatohepatitíde" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Štúdia</th>
        <th scope="col">Populácia a liečba</th>
        <th scope="col">Hlavný výsledok</th>
        <th scope="col">Kľúčový limit</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">PIVENS</th>
        <td>247 dospelých bez diabetu; pioglitazón 30 mg, vitamín E alebo placebo počas 96 týždňov</td>
        <td>Primárny výsledok pri pioglitazóne nesplnil vopred určenú hranicu významnosti; zlepšila sa steatóza a lobulárny zápal, nie fibróza</td>
        <td>Bez diabetu, staršia definícia NASH a kompozitný histologický cieľ</td>
      </tr>
      <tr>
        <th scope="row">Cusi et al.</th>
        <td>101 pacientov s prediabetom alebo diabetom 2. typu a biopsiou potvrdenou NASH; pioglitazón 45 mg alebo placebo</td>
        <td>58 % dosiahlo primárny histologický cieľ a 51 % ústup NASH; rozdiel fibrózneho skóre bol malý</td>
        <td>Jedno centrum, malá vzorka a primárne náhradné histologické ukazovatele</td>
      </tr>
    </tbody>
  </table>
</div>

<h3>PIVENS: často citovaný, ale často nesprávne interpretovaný</h3>

<p>PIVENS zaradila 247 dospelých s biopsiou potvrdenou NASH bez diabetu. Pioglitazón 30 mg denne užívalo 80 účastníkov, vitamín E 84 a placebo 83 počas 96 týždňov. Pre dve plánované primárne porovnania sa za štatisticky významnú považovala hodnota p &lt;0,025.</p>

<p>Primárne histologické zlepšenie nastalo pri pioglitazóne u 34 % a pri placebe u 19 % pacientov, ale p = 0,04 nesplnilo vopred určenú hranicu. Pioglitazón znížil aminotransferázy, steatózu a lobulárny zápal; skóre fibrózy sa významne nezlepšilo. Pacienti na pioglitazóne viac pribrali.</p>

<p>Preto nie je korektné tvrdiť, že PIVENS „dokázala účinnosť pioglitazónu na fibrózu“. Ukázala priaznivé sekundárne histologické a biochemické účinky, no nie úspech primárneho výsledku podľa protokolu.</p>

<h3>Pacienti s prediabetom alebo diabetom: silnejší signál, stále nie definitívny</h3>

<p>Jednocentrová štúdia Kennetha Cusiho a spolupracovníkov zaradila 101 pacientov s prediabetom alebo diabetom 2. typu a biopsiou potvrdenou NASH. Po hypokalorickej diéte dostávali pioglitazón 45 mg denne alebo placebo počas 18 mesiacov; nasledovala otvorená fáza s pioglitazónom.</p>

<p>Primárny cieľ – pokles skóre aktivity najmenej o dva body v dvoch histologických kategóriách bez zhoršenia fibrózy – dosiahlo 58 % pacientov na pioglitazóne. Ústup NASH nastal u 51 %. Priemerný rozdiel skóre fibrózy bol −0,5 bodu (95 % interval spoľahlivosti −0,9 až 0,0; p = 0,039) a prírastok hmotnosti bol o 2,5 kg vyšší než pri placebe.</p>

<p>Výsledok podporuje možný prínos u pacientov s diabetom alebo prediabetom a MASH. Malá jednocentrová štúdia však nepreukazuje zníženie cirhózy, transplantácie, kardiovaskulárnych udalostí ani mortality.</p>

<h2>Prečo sa americké a európske odporúčania líšia</h2>

<p>AASLD v usmernení z roku 2023 uvádza, že pioglitazón zlepšuje NASH a možno ho zvážiť u pacientov s NASH v kontexte diabetu 2. typu. Zároveň výslovne upozorňuje, že dostupné údaje nepreukazujú spoľahlivý antifibrotický prínos.</p>

<p>Spoločné európske odporúčanie EASL–EASD–EASO z roku 2024 pioglitazón nepovažuje za štandardnú cielenú farmakoterapiu MASH, pretože chýba robustné potvrdenie vo veľkých štúdiách fázy 3 a dôkaz o dlhodobých pečeňových výsledkoch. Nejde o tvrdenie, že liek nemá žiadny histologický účinok; ide o vyššiu požadovanú úroveň dôkazu pre cielenú liečbu MASH.</p>

<p>Pioglitazón je liekom na diabetes 2. typu. Jeho použitie pre MASH nie je samostatnou európskou hepatologickou indikáciou a nemá sa zamieňať s liekmi schválenými pre presne vymedzenú populáciu s necirhotickou MASH a významnou fibrózou.</p>

<h2>Kardiovaskulárny prínos existuje, ale nie bez ceny</h2>

<p>Štúdia IRIS zaradila 3 876 pacientov bez diabetu, ktorí mali inzulínovú rezistenciu po nedávnej ischemickej cievnej mozgovej príhode alebo tranzitórnom ischemickom ataku. Po mediáne 4,8 roka sa cievna mozgová príhoda alebo infarkt myokardu vyskytli u 9,0 % pacientov na pioglitazóne a u 11,8 % na placebe (pomer rizík 0,76; 95 % interval spoľahlivosti 0,62 až 0,93).</p>

<p>Súčasne sa však častejšie vyskytli:</p>

<ul>
  <li>prírastok hmotnosti nad 4,5 kg: 52,2 % oproti 33,7 %,</li>
  <li>edémy: 35,6 % oproti 24,9 %,</li>
  <li>zlomeniny vyžadujúce operáciu alebo hospitalizáciu: 5,1 % oproti 3,2 %.</li>
</ul>

<p>IRIS nepodporuje plošné predpisovanie pioglitazónu každému pacientovi s MASLD. Išlo o špecifickú sekundárnu prevenciu po cerebrovaskulárnej udalosti u ľudí bez diabetu a so selekciou znižujúcou riziko srdcového zlyhávania.</p>

<h2>Prečo je CKD osobitný bezpečnostný kontext</h2>

<p>Pioglitazón sa nemetabolizuje primárne obličkami a samotný pokles eGFR zvyčajne nevyžaduje rovnaké dávkové obmedzenie ako pri liekoch eliminovaných močom. To však neznamená, že je pri CKD automaticky bezpečný. Pacienti s CKD majú často vyššie riziko retencie tekutín, srdcového zlyhávania, anémie, krehkosti a zlomenín.</p>

<p>Aktivácia PPAR-γ podporuje retenciu sodíka a vody. Klinicky sa môže prejaviť:</p>

<ul>
  <li>nárastom hmotnosti,</li>
  <li>periférnymi edémami,</li>
  <li>hemodilúciou a poklesom hemoglobínu,</li>
  <li>vznikom alebo zhoršením srdcového zlyhávania.</li>
</ul>

<p>Americká informácia o lieku obsahuje rámcové varovanie pred kongestívnym srdcovým zlyhávaním. Európske a národné súhrny charakteristických vlastností treba kontrolovať pre konkrétny prípravok; srdcové zlyhávanie alebo jeho anamnéza sú zásadným dôvodom liek nepoužiť.</p>

<p>Pioglitazón zároveň <strong>nie je nefroprotektívnym pilierom</strong>. Nemá nahradiť inhibítor SGLT2, blokádu systému renín–angiotenzín, finerenón alebo liečbu agonistom GLP-1 tam, kde sú indikované a tolerované. Rozhodnutie má vychádzať z cieľov diabetu, pečene, srdca a obličiek spolu.</p>

<h2>Ďalšie bezpečnostné otázky</h2>

<h3>Zlomeniny</h3>

<p>Riziko zlomenín je konzistentným signálom triedy tiazolidíndiónov. Nie je obmedzené iba na laboratórny pokles kostnej denzity; v IRIS pribudli závažnejšie zlomeniny. Opatrnosť je potrebná pri osteoporóze, predchádzajúcej fragilitnej zlomenine, vysokej pádovej záťaži a u krehkých starších pacientov.</p>

<h3>Karcinóm močového mechúra</h3>

<p>Údaje o karcinóme močového mechúra nie sú úplne jednotné. Niektoré observačné analýzy a meta-analýzy naznačili malé časovo alebo dávkovo závislé riziko, iné veľké kohorty nepotvrdili významnú asociáciu. Liek sa nemá používať pri aktívnom karcinóme močového mechúra a nevysvetlená makroskopická hematúria si vyžaduje vyšetrenie, nie empirické pokračovanie liečby.</p>

<h3>Hmotnosť a hypoglykémia</h3>

<p>Pioglitazón sám osebe má nízke riziko hypoglykémie, ale v kombinácii s inzulínom alebo derivátom sulfonylurey môže byť potrebná úprava dávky. Nárast hmotnosti nie je iba retencia vody; podieľa sa na ňom aj zmena tukového tkaniva. Pri MASH a obezite môže byť tento efekt v rozpore s cieľom redukcie hmotnosti.</p>

<h2>Komu môže pioglitazón dávať zmysel</h2>

<p>O jeho použití možno uvažovať najmä vtedy, keď pacient:</p>

<ul>
  <li>má diabetes 2. typu alebo prediabetes s výraznou inzulínovou rezistenciou,</li>
  <li>má dôveryhodne potvrdenú MASH, nie iba ultrazvukovú steatózu,</li>
  <li>nemá srdcové zlyhávanie, objemové preťaženie ani vysoké riziko edémov,</li>
  <li>nemá vysoké riziko zlomeniny alebo aktívny karcinóm močového mechúra,</li>
  <li>rozumie, že pečeňový prínos nie je to isté ako dokázaná regresia fibrózy,</li>
  <li>má jasný plán monitorovania a liečba zapadá do celkovej kardiorenálnej stratégie.</li>
</ul>

<p>Samotná prítomnosť MASLD, mierne zvýšená ALT alebo echogénna pečeň nie sú dostatočnou indikáciou. U pacienta s obezitou, CKD alebo aterosklerotickým ochorením môžu mať iné antidiabetiká silnejšie dôkazy pre redukciu hmotnosti, srdcové zlyhávanie alebo progresiu CKD.</p>

<h2>Čo sledovať po začatí</h2>

<ul>
  <li><strong>Hmotnosť a edémy:</strong> najmä rýchlu zmenu v prvých týždňoch a po zvýšení dávky.</li>
  <li><strong>Dýchavicu a príznaky kongescie:</strong> nový ortopnoický alebo námahový symptóm vyžaduje promptné prehodnotenie.</li>
  <li><strong>Glykémiu a HbA<sub>1c</sub>:</strong> s úpravou inzulínu alebo sulfonylurey podľa potreby.</li>
  <li><strong>Pečeňové testy:</strong> pred liečbou a pri klinickom podozrení na hepatálne poškodenie; normalizácia ALT nie je potvrdením ústupu MASH.</li>
  <li><strong>Kostné riziko:</strong> pády, predchádzajúce zlomeniny a indikáciu denzitometrie.</li>
  <li><strong>Močové príznaky:</strong> makroskopickú hematúriu treba vyšetriť.</li>
</ul>

<h2>Praktické rozhodovanie</h2>

<ol>
  <li><strong>Najprv potvrdiť, čo liečime.</strong> Steatóza, MASH a fibróza nie sú zameniteľné diagnózy.</li>
  <li><strong>Určiť hlavný terapeutický cieľ.</strong> Glykemická kontrola, ústup MASH, redukcia hmotnosti, prevencia srdcového zlyhávania a nefroprotekcia môžu viesť k odlišnému výberu lieku.</li>
  <li><strong>Vylúčiť objemové a kostné riziko.</strong> Nízka eGFR sama osebe nie je hlavným problémom; kongescia často je.</li>
  <li><strong>Nesľubovať antifibrotický účinok.</strong> Histologická aktivita sa môže zlepšiť, dôkaz na fibrózu a klinické pečeňové udalosti je nedostatočný.</li>
  <li><strong>Prínos pravidelne prehodnocovať.</strong> Pokračovanie bez glykemického alebo klinického prínosu pri rastúcej hmotnosti či edémoch nie je rozumné.</li>
</ol>

<h2>Záver</h2>

<p>Pioglitazón má pri MASH reálny biologický aj klinický signál, najmä u pacientov s prediabetom alebo diabetom 2. typu. Dôkaz je však postavený prevažne na histológii, menších štúdiách a staršej nomenklatúre. Nejde o spoľahlivo antifibrotický liek ani o univerzálnu liečbu MASLD.</p>

<p>Pri CKD treba jeho použitie posudzovať predovšetkým cez riziko retencie tekutín, srdcového zlyhávania, hmotnosti a zlomenín. Dobrý kandidát nie je pacient, ktorý „má stukovatenú pečeň“, ale starostlivo vybraný človek s jasným metabolickým cieľom, potvrdenou pečeňovou diagnózou a nízkym objemovým rizikom.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">MASLD: diagnostika a fibróza v nefrologickej praxi</a></li>
  <li><a href="article.php?slug=inkretinove-agonisty-masld-mash-pecen-ckd">Inkretínové agonisty pri MASLD a MASH</a></li>
  <li><a href="article.php?slug=steatoticke-ochorenie-pecene-riziko-ckd">Steatotické ochorenie pečene a riziko CKD</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<ol>
  <li><strong>Sanyal AJ, Chalasani N, Kowdley KV, et al.</strong> <em>Pioglitazone, Vitamin E, or Placebo for Nonalcoholic Steatohepatitis.</em> New England Journal of Medicine. 2010;362:1675–1685. doi: 10.1056/NEJMoa0907929. <a href="https://pubmed.ncbi.nlm.nih.gov/20427778/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Cusi K, Orsak B, Bril F, et al.</strong> <em>Long-Term Pioglitazone Treatment for Patients With Nonalcoholic Steatohepatitis and Prediabetes or Type 2 Diabetes Mellitus.</em> Annals of Internal Medicine. 2016;165:305–315. doi: 10.7326/M15-1774. <a href="https://pubmed.ncbi.nlm.nih.gov/27322798/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Rinella ME, Neuschwander-Tetri BA, Siddiqui MS, et al.</strong> <em>AASLD Practice Guidance on the clinical assessment and management of nonalcoholic fatty liver disease.</em> Hepatology. 2023;77:1797–1835. doi: 10.1097/HEP.0000000000000323. <a href="https://pubmed.ncbi.nlm.nih.gov/36727674/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>European Association for the Study of the Liver, European Association for the Study of Diabetes, European Association for the Study of Obesity.</strong> <em>EASL–EASD–EASO Clinical Practice Guidelines on the management of metabolic dysfunction-associated steatotic liver disease.</em> Journal of Hepatology. 2024;81:492–542. doi: 10.1016/j.jhep.2024.04.031. <a href="https://pubmed.ncbi.nlm.nih.gov/38851997/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kernan WN, Viscoli CM, Furie KL, et al.</strong> <em>Pioglitazone after Ischemic Stroke or Transient Ischemic Attack.</em> New England Journal of Medicine. 2016;374:1321–1331. doi: 10.1056/NEJMoa1506930. <a href="https://pubmed.ncbi.nlm.nih.gov/26886418/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Tang H, Shi W, Fu S, et al.</strong> <em>Pioglitazone and bladder cancer risk: a systematic review and meta-analysis.</em> Cancer Medicine. 2018;7:1070–1080. doi: 10.1002/cam4.1354. <a href="https://pubmed.ncbi.nlm.nih.gov/29476615/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>U.S. National Library of Medicine.</strong> <em>Pioglitazone: current U.S. prescribing information.</em> <a href="https://dailymed.nlm.nih.gov/dailymed/search.cfm?query=pioglitazone" target="_blank" rel="noopener noreferrer">DailyMed</a>.</li>
</ol>

<p><em><strong>Poznámka k vecnej kontrole:</strong> Text rozlišuje štatisticky neúspešný primárny výsledok PIVENS od priaznivých sekundárnych ukazovateľov, neprezentuje malý rozdiel fibrózneho skóre ako dokázanú antifibrotickú liečbu a neextrapoluje kardiovaskulárny výsledok IRIS na každého pacienta s MASLD. Americké a európske odporúčania sú uvedené oddelene.</em></p>

<p><em>Text má odborný informačný charakter. Indikáciu, kontraindikácie a aktuálny súhrn charakteristických vlastností konkrétneho prípravku treba overiť pred predpísaním.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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