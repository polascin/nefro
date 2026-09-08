<?php
/**
 * Odborne a jazykovo revidovaný článok o rozdieloch medzi kyselinou
 * ursodeoxycholovou a kyselinou ursolovou.
 *
 * Text je viaczdrojovou syntézou odborných odporúčaní, slovenskej informácie
 * o lieku, bibliografických databáz a klinických prehľadov. Nejde o spracovanie
 * jednej publikácie, preto sa autori citovaných prác nepridávajú do
 * source_authors.php.
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
    'title'        => 'Kyselina ursodeoxycholová a kyselina ursolová: podobné názvy, zásadne odlišný klinický význam',
    'slug'         => 'kyselina-ursodeoxycholova-a-ursolova-rozdiely-klinicky-vyznam',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kyselina ursodeoxycholová je liečivo zo skupiny žlčových kyselín s etablovaným využitím pri PBC. Kyselina ursolová je rastlinný triterpenoid bez porovnateľne preukázaného klinického účinku.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Kyselina ursodeoxycholová (UDCA) a kyselina ursolová (UA) nie sú synonymá ani terapeuticky zameniteľné látky. UDCA je žlčová kyselina a liečivo obsiahnuté v liekoch registrovaných na Slovensku s presne vymedzenými indikáciami. UA je rastlinný pentacyklický triterpenoid, ktorého biologické účinky sa skúmajú prevažne v predklinických modeloch a malých klinických štúdiách. Podobnosť názvov preto nesmie viesť k náhrade predpísanej liečby výživovým doplnkom.</em></p>

<p>Názvy oboch látok sa podobajú pre spoločný prvok <em>urso-</em>. Táto názvová podobnosť však neznamená chemickú, farmakologickú ani klinickú príbuznosť. UDCA a UA majú odlišnú chemickú štruktúru, pôvod, metabolizmus aj možnosti použitia.</p>

<h2>Dve odlišné molekuly</h2>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Porovnanie kyseliny ursodeoxycholovej a kyseliny ursolovej" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Charakteristika</th>
        <th scope="col">Kyselina ursodeoxycholová</th>
        <th scope="col">Kyselina ursolová</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Skratka</th>
        <td>UDCA</td>
        <td>UA</td>
      </tr>
      <tr>
        <th scope="row">Molekulový vzorec</th>
        <td>C<sub>24</sub>H<sub>40</sub>O<sub>4</sub></td>
        <td>C<sub>30</sub>H<sub>48</sub>O<sub>3</sub></td>
      </tr>
      <tr>
        <th scope="row">Chemická skupina</th>
        <td>Dihydroxyžlčová kyselina so steroidným skeletom</td>
        <td>Pentacyklický triterpenoid ursánového typu</td>
      </tr>
      <tr>
        <th scope="row">Biologický pôvod</th>
        <td>Prirodzená minoritná zložka ľudského súboru žlčových kyselín; vzniká bakteriálnou premenou primárnych žlčových kyselín</td>
        <td>Sekundárny rastlinný metabolit prítomný napríklad v šupke jabĺk, rozmaríne a tymiane</td>
      </tr>
      <tr>
        <th scope="row">Farmakokinetický kontext</th>
        <td>Po absorpcii sa konjuguje najmä s glycínom a taurínom a vstupuje do enterohepatálneho obehu</td>
        <td>Má nízku rozpustnosť vo vode, nízku črevnú priepustnosť a slabú, premenlivú perorálnu biologickú dostupnosť</td>
      </tr>
      <tr>
        <th scope="row">Klinické postavenie</th>
        <td>Liečivo obsiahnuté v registrovaných liekoch viazaných na lekársky predpis; indikácie a dávkovanie určuje informácia o konkrétnom lieku</td>
        <td>Citované dostupné klinické dôkazy nepodporujú jej použitie pri primárnej biliárnej cholangitíde ani pri inom hepatobiliárnom ochorení</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Kyselina ursodeoxycholová: žlčová kyselina s klinickým využitím</h2>

<p>UDCA, v americkej nomenklatúre označovaná aj ako ursodiol, je 7β-epimérom kyseliny chenodeoxycholovej. V porovnaní s viacerými hydrofóbnymi žlčovými kyselinami je menej hydrofóbna a menej cytotoxická. Pri dlhodobom podávaní sa stáva významnou súčasťou cirkulujúcich žlčových kyselín. Jej účinky zahŕňajú zmenu ich zloženia, stimuláciu hepatobiliárnej sekrécie a ochranu hepatocytov a cholangiocytov pred poškodením súvisiacim s cholestázou. Mechanizmus nie je jediný a nemožno ho redukovať na jednoduché „prečistenie pečene“.</p>

<h3>Primárna biliárna cholangitída</h3>

<p>Pri primárnej biliárnej cholangitíde (PBC) je UDCA liečbou prvej línie. Odporúčania Európskej asociácie pre štúdium pečene uvádzajú dávku <strong>13 až 15 mg/kg/deň</strong> pre pacientov s PBC; pri dobrej tolerancii sa liečba zvyčajne podáva dlhodobo až celoživotne. Slovenský súhrn charakteristických vlastností lieku Ursofalk 250 mg kapsuly uvádza pri symptomatickej PBC bez dekompenzovanej cirhózy dávku 14 ± 2 mg/kg/deň, pričom konkrétny počet kapsúl sa zaokrúhľuje podľa telesnej hmotnosti.</p>

<p>Biochemická odpoveď sa štandardne hodnotí po 12 mesiacoch, hoci skoršie hodnotenie môže poskytnúť prognostickú informáciu. Dôležité sú najmä alkalická fosfatáza a bilirubín spolu so štádiom ochorenia. Nedostatočná odpoveď znamená vyššie riziko progresie a je dôvodom na špecializované prehodnotenie ďalšej liečby. Nie je dôvodom nahradiť UDCA kyselinou ursolovou.</p>

<h3>Vybrané cholesterolové žlčníkové kamene</h3>

<p>UDCA možno použiť na rozpúšťanie starostlivo vybraných cholesterolových žlčníkových kameňov. Podľa slovenského súhrnu charakteristických vlastností lieku musia byť kamene röntgenovo nekontrastné, nesmú byť väčšie ako 15 mm a žlčník musí zostať funkčný. Liečba zvyčajne trvá 6 až 24 mesiacov; ak sa kamene po 12 mesiacoch nezmenšujú, v liečbe sa nemá pokračovať.</p>

<p>Citovaný liek sa nemá používať pri kalcifikovaných kameňoch, obštrukcii žlčových ciest, akútnom zápale žlčníka alebo žlčových ciest, častých biliárnych kolikách ani pri narušenej kontraktilite žlčníka. Nejde teda o univerzálnu konzervatívnu liečbu každého pacienta so žlčníkovými kameňmi.</p>

<h3>Indikácie, bezpečnosť a sledovanie liečby závisia od konkrétneho lieku</h3>

<p>Rozsah schválených indikácií sa líši podľa lieku a jurisdikcie. Slovenský súhrn charakteristických vlastností lieku Ursofalk 250 mg kapsuly okrem PBC a vybraných žlčníkových kameňov uvádza biliárnu refluxnú gastritídu a hepatobiliárne poruchy pri cystickej fibróze u detí vo veku od 6 rokov do menej ako 18 rokov. Z toho nemožno vyvodiť, že UDCA je účinná pri každej cholestáze alebo pri každom ochorení pečene.</p>

<p>Najčastejším nežiaducim účinkom uvedeným v slovenskej informácii o lieku je mäkká stolica alebo hnačka. Pri pretrvávajúcej hnačke môže byť potrebné zníženie dávky alebo ukončenie liečby. Pri PBC sa môže na začiatku zriedkavo zintenzívniť svrbenie. Ošetrujúci lekár má podľa citovaného súhrnu kontrolovať AST, ALT a GGT každé štyri týždne počas prvých troch mesiacov a potom každé tri mesiace.</p>

<p>Cholestyramín, kolestipol a antacidá obsahujúce hydroxid alebo oxid hlinitý môžu znižovať vstrebávanie UDCA; ak sú potrebné, majú sa podať najmenej dve hodiny pred ňou alebo po nej. Klinicky významné môžu byť aj ďalšie interakcie, napríklad s cyklosporínom. Liečba preto patrí pod dohľad lekára.</p>

<h2>Kyselina ursolová: zaujímavá výskumná látka, nie náhrada lieku</h2>

<p>Kyselina ursolová nie je žlčovou kyselinou ani prirodzenou súčasťou súboru žlčových kyselín. Ide o lipofilný rastlinný triterpenoid. V bunkových kultúrach a zvieracích modeloch sa skúmali jej protizápalové, metabolické, antimikrobiálne, antioxidačné a protinádorové účinky. Takéto výsledky však dokazujú biologickú aktivitu v konkrétnom modeli, nie klinický prínos pre pacienta.</p>

<p>Vývoj možného klinického použitia obmedzuje nízka rozpustnosť, slabá črevná priepustnosť a nízka perorálna biologická dostupnosť. Skúmajú sa preto nanočastice, lipozómy a ďalšie nosiče. Výsledky získané s experimentálnou intravenóznou formuláciou však nemožno preniesť na kapsulu alebo rastlinný extrakt užívaný ústami.</p>

<h3>Čo ukázali klinické štúdie</h3>

<p>V publikovanej štúdii fázy I dostalo 24 zdravých dobrovoľníkov jednorazovú intravenóznu dávku nanolipozomálnej kyseliny ursolovej a osem pacientov s pokročilými solídnymi nádormi dostávalo opakované dávky počas 14 dní. Farmakokinetika bola v skúmanom rozmedzí približne lineárna a väčšina súvisiacich nežiaducich udalostí bola mierna až stredne závažná. Štúdia však nebola navrhnutá na preukázanie protinádorovej účinnosti, dlhodobej bezpečnosti ani účinku pri hepatobiliárnom ochorení.</p>

<p>Systematický prehľad a metaanalýza z roku 2024 zahrnuli šesť klinických prác so suplementáciou UA v dávkach približne 51 až 450 mg/deň. Súhrnná analýza nepreukázala významnú zmenu hodnotených antropometrických, glykemických, lipidových ani tlakových ukazovateľov oproti kontrolným skupinám. Malý počet a heterogenita štúdií neumožňujú vylúčiť každý možný účinok, neposkytujú však podklad na tvrdenie o širokom klinickom prínose.</p>

<h3>Bezpečnosť a doplnky výživy</h3>

<p>Dlhodobé údaje o bezpečnosti kyseliny ursolovej u ľudí sú obmedzené a nemožno z nich odvodiť štandardnú terapeutickú dávku pre PBC ani iné hepatobiliárne ochorenie. Označenie „prírodná“ neznamená automaticky účinná alebo bezpečná.</p>

<p>Doplnky výživy v Európskej únii podliehajú potravinovému právu a pravidlám bezpečnosti a označovania. Nie sú však schvaľované rovnakým postupom ako lieky a ich označenie ani reklama im nesmú pripisovať schopnosť predchádzať chorobe, liečiť ju alebo ju vyliečiť. Uvedenie doplnku na trh preto nie je dôkazom klinickej účinnosti porovnateľným s registráciou lieku.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<ul>
  <li><strong>Kontrolovať celý názov účinnej látky.</strong> „Ursodeoxycholová“ a „ursolová“ označujú dve odlišné molekuly.</li>
  <li><strong>Kyselinou ursolovou nenahrádzať UDCA.</strong> Citované dostupné klinické dôkazy nepodporujú použitie UA pri PBC ani vybraných cholesterolových žlčníkových kameňoch.</li>
  <li><strong>UDCA nepovažovať za univerzálny liek na cholestázu.</strong> Vhodnosť závisí od diagnózy, konkrétneho lieku, odporúčaní a klinického stavu.</li>
  <li><strong>Výživový doplnok zapísať do liekovej anamnézy.</strong> Pri komorbiditách a súbežnej liečbe treba posúdiť jeho zloženie, očakávaný prínos, neistoty aj možné interakcie.</li>
  <li><strong>Predpísanú liečbu nemeniť svojvoľne.</strong> O dávke, sledovaní a prípadnej druhej línii liečby PBC rozhoduje lekár podľa odpovede pacienta a aktuálnych odporúčaní.</li>
</ul>

<h2>Záver</h2>

<p>Kyselina ursodeoxycholová je žlčová kyselina a liečivo s etablovaným klinickým použitím; pri PBC zostáva liečbou prvej línie. Kyselina ursolová je chemicky aj farmakologicky odlišný rastlinný triterpenoid. Citované dostupné klinické dôkazy nepodporujú jej použitie pri PBC, cholestatických ochoreniach ani žlčníkových kameňoch.</p>

<p>Najdôležitejším praktickým pravidlom je preto nezamieňať podobne znejúce názvy. UA nie je „prírodná UDCA“ a výživový doplnok s kyselinou ursolovou nemá nahrádzať predpísanú liečbu.</p>

<h2>Súvisiaci článok</h2>

<ul>
  <li><a href="article.php?slug=htd1801-berberin-ursodeoxycholat-diabetes-2-typu">HTD1801 pri diabete 2. typu: výsledky štúdie SYMPHONY-2 a hranice dôkazov</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>European Association for the Study of the Liver.</strong> <em>EASL Clinical Practice Guidelines: The diagnosis and management of patients with primary biliary cholangitis.</em> J Hepatol. 2017;67(1):145–172. doi: <a href="https://doi.org/10.1016/j.jhep.2017.03.022" target="_blank" rel="noopener noreferrer">10.1016/j.jhep.2017.03.022</a>. PMID 28427765. <a href="https://pubmed.ncbi.nlm.nih.gov/28427765/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://easl.eu/wp-content/uploads/2018/10/PBC-English-report.pdf" target="_blank" rel="noopener noreferrer">plný text EASL</a>.</li>
  <li><strong>Štátny ústav pre kontrolu liečiv.</strong> <em>Ursofalk 250 mg kapsuly: súhrn charakteristických vlastností lieku.</em> Schválený text 06/2025. <a href="https://www.sukl.sk/document/download?dok_id=863851&amp;dok_sec=887a177273c78ff79dc02b494a0c8b8b" target="_blank" rel="noopener noreferrer">SPC</a>; <a href="https://www.sukl.sk/ursofalk-250-mg-kapsuly-27028" target="_blank" rel="noopener noreferrer">detail registrovaného lieku</a>.</li>
  <li><strong>Hofmann AF.</strong> <em>Pharmacology of ursodeoxycholic acid, an enterohepatic drug.</em> Scand J Gastroenterol Suppl. 1994;204:1–15. doi: <a href="https://doi.org/10.3109/00365529409103618" target="_blank" rel="noopener noreferrer">10.3109/00365529409103618</a>. PMID 7824870. <a href="https://pubmed.ncbi.nlm.nih.gov/7824870/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Paumgartner G, Beuers U.</strong> <em>Ursodeoxycholic acid in cholestatic liver disease: mechanisms of action and therapeutic use revisited.</em> Hepatology. 2002;36(3):525–531. doi: <a href="https://doi.org/10.1053/jhep.2002.36088" target="_blank" rel="noopener noreferrer">10.1053/jhep.2002.36088</a>. PMID 12198643. <a href="https://pubmed.ncbi.nlm.nih.gov/12198643/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>National Center for Biotechnology Information.</strong> PubChem Compound Summary: <em>Ursodeoxycholic Acid</em> (CID 31401) a <em>Ursolic Acid</em> (CID 64945). <a href="https://pubchem.ncbi.nlm.nih.gov/compound/Ursodiol" target="_blank" rel="noopener noreferrer">UDCA</a>; <a href="https://pubchem.ncbi.nlm.nih.gov/compound/ursolic_acid" target="_blank" rel="noopener noreferrer">UA</a>.</li>
  <li><strong>Sun Q, He M, Zhang M, et al.</strong> <em>Ursolic acid: A systematic review of its pharmacology, toxicity and rethink on its pharmacokinetics based on PK–PD model.</em> Fitoterapia. 2020;147:104735. doi: <a href="https://doi.org/10.1016/j.fitote.2020.104735" target="_blank" rel="noopener noreferrer">10.1016/j.fitote.2020.104735</a>. PMID 33010369. <a href="https://pubmed.ncbi.nlm.nih.gov/33010369/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Zhu Z, Qian Z, Yan Z, Zhao C, Wang H, Ying G.</strong> <em>A phase I pharmacokinetic study of ursolic acid nanoliposomes in healthy volunteers and patients with advanced solid tumors.</em> Int J Nanomedicine. 2013;8:129–136. doi: <a href="https://doi.org/10.2147/IJN.S38271" target="_blank" rel="noopener noreferrer">10.2147/IJN.S38271</a>. PMID 23319864. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3540956/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Nguyen HN, Ullevig SL, Short JD, Wang L, Ahn YJ, Asmis R.</strong> <em>Ursolic Acid and Related Analogues: Triterpenoids with Broad Health Benefits.</em> Antioxidants. 2021;10(8):1161. doi: <a href="https://doi.org/10.3390/antiox10081161" target="_blank" rel="noopener noreferrer">10.3390/antiox10081161</a>. PMID 34439409. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8388988/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Rafiee P, Rasaei N, Amini MR, et al.</strong> <em>The effects of ursolic acid on cardiometabolic risk factors: a systematic review and meta-analysis.</em> Future Cardiol. 2024;20(3):151–161. doi: <a href="https://doi.org/10.1080/14796678.2024.2349476" target="_blank" rel="noopener noreferrer">10.1080/14796678.2024.2349476</a>. PMID 38923885. <a href="https://pubmed.ncbi.nlm.nih.gov/38923885/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>European Commission.</strong> <em>Food supplements.</em> <a href="https://food.ec.europa.eu/food-safety/labelling-and-nutrition/food-supplements_en" target="_blank" rel="noopener noreferrer">Prehľad pravidiel EÚ</a>; <strong>Európsky parlament a Rada.</strong> Smernica 2002/46/ES o aproximácii právnych predpisov členských štátov týkajúcich sa potravinových doplnkov. <a href="https://eur-lex.europa.eu/eli/dir/2002/46/2024-07-17/eng" target="_blank" rel="noopener noreferrer">Konsolidované znenie</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografická identita publikácií bola overená v PubMed a Crossref; slovenské indikácie, dávkovanie, kontraindikácie, interakcie a pravidlá sledovania boli overené podľa SPC dostupného v databáze ŠÚKL. Regulačné informácie boli skontrolované 8. septembra 2026. Text rozlišuje schválené použitie lieku, odborné odporúčanie, klinický výskum a predklinické mechanizmy.</em></p>

<p><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie, aktuálnu informáciu o lieku ani odborné odporúčania.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kyselina_ursodeoxycholova_a_ursolova_rozdiely_klinicky_vyznam_article',
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
      <link rel="stylesheet" href="index.css?v=20260509-1&amp;cb=<?= filemtime('index.css') ?>">
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
