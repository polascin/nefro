<?php

/**
 * add_ckm-syndrom-stadia-skrining-liecba-usmernenie-2026_article.php
 * CKM syndrom - stadia 0-4, skrining a liecba podla usmernenia AHA/ACC/ADA/ASN 2026.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
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
    'title'        => 'CKM syndróm: štádiá 0 až 4, skríning a liečba podľa usmernenia AHA/ACC/ADA/ASN 2026',
    'slug'         => 'ckm-syndrom-stadia-skrining-liecba-usmernenie-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Systematický prehľad všetkých piatich štádií CKM syndrómu vrátane často opomínaného štádia 0, konkrétnych prahov pre štádium 3, skríningového panelu a liečby podľa jednotlivých liekových skupín — a toho, čo staging nedokáže.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Usmernenie AHA, ACC, ADA a ASN z roku 2026 nahradilo pohľad na obezitu, diabetes, chronickú chorobu obličiek a kardiovaskulárne ochorenie ako na samostatné diagnózy jedným kontinuom rizika. Tento článok prechádza systematicky celý rámec — všetkých päť štádií vrátane často vynechávaného štádia 0, konkrétne prahové hodnoty, skríningový panel aj hranice použiteľnosti stagingu.</em></p>

<p>Kardiovaskulárne ochorenia, chronická choroba obličiek, obezita, diabetes mellitus 2. typu, artériová hypertenzia a poruchy metabolizmu lipidov sa tradične hodnotili oddelene. V skutočnosti ich spája spoločná patofyziológia: rovnaké mechanizmy poškodzujú cievy, srdce, obličky aj pečeň a spoločne zvyšujú riziko predčasného úmrtia.</p>

<p>Tento pohľad vyjadruje pojem <strong>kardiovaskulárno-obličkovo-metabolický syndróm</strong> (<em>cardiovascular-kidney-metabolic syndrome</em>, CKM). Usmernenie publikované v <em>Circulation</em> v roku 2026 je prvým spoločným klinickým dokumentom štyroch odborných spoločností pre jeho prevenciu, detekciu, hodnotenie a liečbu.</p>

<p><em>Poznámka: tento článok je systematickým referenčným prehľadom rámca. Súhrn noviniek a desiatich hlavných odporúčaní, pohľad na CKM ako pracovný postup v ambulancii a rozbor typických chýb v manažmente sú spracované v samostatných článkoch uvedených na konci.</em></p>

<h2>Čo CKM syndróm je a čo nie je</h2>

<p>Usmernenie definuje CKM syndróm ako systémovú poruchu vznikajúcu z patofyziologických interakcií medzi metabolickými rizikovými faktormi, chronickou chorobou obličiek a kardiovaskulárnym systémom, ktorej dôsledkom môže byť multiorgánová dysfunkcia a vysoké riziko nepriaznivých príhod.</p>

<p>Nejde o zavedenie ďalšej izolovanej diagnózy. Ide o uznanie toho, že:</p>

<ul>
  <li>viscerálna a dysfunkčná tuková masa podporuje inzulínovú rezistenciu, zápal a hemodynamické zaťaženie;</li>
  <li>diabetes a hypertenzia urýchľujú poškodenie obličiek a ciev;</li>
  <li>chronická choroba obličiek výrazne zvyšuje kardiovaskulárne riziko;</li>
  <li>srdcové zlyhávanie a poškodenie obličiek sa navzájom zhoršujú;</li>
  <li>tá istá liečba môže priaznivo ovplyvniť viaceré zložky naraz.</li>
</ul>

<p>CKM syndróm preto nie je súčtom diagnóz, ale <strong>kontinuom rizika a orgánového poškodenia</strong>.</p>

<h2>Je adipozita jedinou príčinou?</h2>

<p>V popularizačných zhrnutiach sa nadmerná, najmä viscerálna adipozita označuje za základnú príčinu CKM syndrómu. Toto zjednodušenie správne vystihuje jej význam, ale pri doslovnom čítaní je príliš kategorické.</p>

<p>Dysfunkčná tuková masa je nepochybne jedným z najdôležitejších mechanizmov — cez inzulínovú rezistenciu, chronický zápal nízkeho stupňa, aktiváciu sympatikového a renín-angiotenzín-aldosterónového systému, endotelovú dysfunkciu a ektopické ukladanie tuku. Nie je však jediným. CKM fenotyp významne formujú aj genetická predispozícia, vek, sociálne a ekonomické determinanty zdravia, kvalita stravy a pohybová aktivita, fajčenie, poruchy spánku, primárne ochorenia obličiek, lieky a ďalšie pridružené ochorenia.</p>

<p>Presnejšie je preto hovoriť o adipozite ako o <strong>ústrednom a často modifikovateľnom mechanizme</strong>, nie ako o univerzálnej jedinej príčine. Rozdiel nie je akademický: u štíhleho pacienta s CKM fenotypom vedie prvá formulácia k tomu, že sa riziko podcení.</p>

<h2>Päť štádií, nie štyri</h2>

<p>Zhrnutia usmernenia nezriedka uvádzajú štyri štádiá. Úplná klasifikácia ich má <strong>päť — od štádia 0 po štádium 4</strong>. Vynechanie štádia 0 nie je detail, pretože práve ono definuje skupinu, u ktorej má prevencia najväčší zmysel.</p>

<h3>Štádium 0: bez identifikovaných rizikových faktorov</h3>

<p>Pacient nemá nadmernú ani dysfunkčnú adipozitu, metabolické rizikové faktory, chronickú chorobu obličiek ani klinické či subklinické kardiovaskulárne ochorenie. Cieľom je udržanie tohto stavu — kvalitná strava, pravidelná pohybová aktivita, nefajčenie, primeraná telesná hmotnosť, dostatočný spánok a periodické prehodnotenie rizika.</p>

<h3>Štádium 1: nadmerná alebo dysfunkčná adipozita a prediabetes</h3>

<p>Prítomná je nadmerná alebo funkčne nepriaznivá tuková masa, prípadne prediabetes, zatiaľ bez pokročilejších komplikácií.</p>

<p>Index telesnej hmotnosti a obvod pása poskytujú vzájomne sa dopĺňajúce údaje. Index telesnej hmotnosti nerozlíši tukovú a svalovú hmotu ani distribúciu tuku; obvod pása lepšie vystihuje centrálnu adipozitu, jeho hraničné hodnoty však závisia od pohlavia a etnickej príslušnosti. Uplatňuje sa intenzívna úprava životného štýlu a podľa rizika aj farmakologická alebo chirurgická liečba obezity.</p>

<h3>Štádium 2: metabolické rizikové faktory alebo chronická choroba obličiek</h3>

<p>Pacienti s jedným alebo viacerými manifestnými metabolickými rizikovými faktormi — artériovou hypertenziou, diabetom, hypertriglyceridémiou alebo inou aterogénnou dyslipidémiou, metabolickým syndrómom — alebo s chronickou chorobou obličiek, ktorá ešte nedosahuje veľmi vysoké riziko zodpovedajúce štádiu 3.</p>

<p>Usmernenie tu zdôrazňuje <strong>každoročné vyšetrenie pomeru albumínu ku kreatinínu v moči (uACR)</strong> u rizikových pacientov. Samotný sérový kreatinín nestačí — albuminúria môže signalizovať glomerulárne a cievne poškodenie ešte pred poklesom odhadovanej glomerulárnej filtrácie.</p>

<h3>Štádium 3: subklinické kardiovaskulárne ochorenie alebo rizikový ekvivalent</h3>

<p>Pacienti bez klinicky manifestného kardiovaskulárneho ochorenia, ktorí však majú jeho subklinické prejavy alebo rizikový ekvivalent. Prahové hodnoty sú konkrétne:</p>

<ul>
  <li><strong>subklinické koronárne ochorenie</strong> — kalciové skóre koronárnych artérií nad 100;</li>
  <li><strong>subklinické srdcové zlyhávanie</strong> — NT-proBNP ≥ 125 pg/ml spolu s echokardiografickým dôkazom komorovej dysfunkcie;</li>
  <li><strong>chronická choroba obličiek s veľmi vysokým rizikom</strong> podľa kombinácie eGFR a albuminúrie v tabuľke KDIGO, prípadne štádium G4 alebo G5;</li>
  <li><strong>vysoké predikované riziko</strong> — desaťročné riziko nad 20 % podľa rovníc PREVENT.</li>
</ul>

<p>Kalciové skóre, natriuretické peptidy ani echokardiografia však nie sú vyšetreniami pre každého. Zmysel majú vtedy, keď výsledok môže zmeniť intenzitu liečby alebo pomôcť pri spoločnom rozhodovaní s pacientom.</p>

<h3>Štádium 4: klinicky manifestné kardiovaskulárne ochorenie</h3>

<p>Ischemická choroba srdca alebo prekonaný infarkt myokardu, srdcové zlyhávanie, cievna mozgová príhoda, periférne artériové ochorenie, fibrilácia predsiení. Cieľom už nie je primárna prevencia, ale sekundárna prevencia, spomalenie progresie orgánového poškodenia, zníženie počtu hospitalizácií a mortality a zlepšenie kvality života.</p>

<h2>Skríningový panel</h2>

<p>Integrovaný skríning CKM rizika nekončí meraním tlaku krvi, glykémie a indexu telesnej hmotnosti. Podľa veku, kontextu a rizikového profilu má zahŕňať:</p>

<ul>
  <li>osobnú anamnézu kardiovaskulárnych, renálnych a metabolických ochorení a rodinnú anamnézu;</li>
  <li>fajčenie, pohybovú aktivitu, stravu a spánok;</li>
  <li>telesnú hmotnosť, index telesnej hmotnosti a obvod pása;</li>
  <li>tlak krvi;</li>
  <li>lipidový profil;</li>
  <li>glykémiu nalačno alebo HbA<sub>1c</sub>;</li>
  <li>sérový kreatinín a eGFR;</li>
  <li><strong>uACR</strong>;</li>
  <li>posúdenie celkového kardiovaskulárneho rizika;</li>
  <li>podľa indikácie hodnotenie metabolickej steatotickej choroby pečene.</li>
</ul>

<h3>Prečo súčasne eGFR aj uACR</h3>

<p>Obidva parametre zachytávajú odlišné, hoci prepojené rozmery poškodenia. Pacient môže mať významnú albuminúriu pri zachovanej eGFR aj nízku eGFR bez výraznej albuminúrie. Riziko progresie sa preto hodnotí podľa kombinácie príčiny ochorenia, kategórie eGFR, kategórie albuminúrie, trendu oboch parametrov v čase a pridružených faktorov.</p>

<p>Jednorazový patologický výsledok spravidla nestačí. Chronickosť sa preukazuje trvaním odchýlky najmenej tri mesiace, ak klinický kontext nesvedčí jednoznačne pre chronické poškodenie.</p>

<h2>Liečba podľa liekových skupín</h2>

<h3>Životný štýl a liečba adipozity</h3>

<p>Základom zostáva kvalitná strava, primeraná energetická bilancia, pravidelná aeróbna aj silová aktivita, nefajčenie a liečba porúch spánku. Odporúčanie „schudnúť“ bez konkrétnej podpory nie je liečbou. Manažment obezity zahŕňa štruktúrovanú behaviorálnu intervenciu, farmakoterapiu, nutričné poradenstvo a u vybraných pacientov metabolickú alebo bariatrickú chirurgiu. Cieľom nie je číslo na váhe, ale zníženie orgánového rizika pri zachovaní svalovej hmoty a primeranej výživy.</p>

<h3>Tlak krvi a blokáda RAAS</h3>

<p>Dôsledná liečba hypertenzie znižuje riziko cievnej mozgovej príhody, srdcového zlyhávania aj progresie chronickej choroby obličiek. Inhibítory ACE alebo sartany majú osobitný význam pri albuminurickej chronickej chorobe obličiek; ich použitie vyžaduje sledovanie kreatinínu, eGFR, draslíka, tlaku krvi a objemového stavu. <strong>Kombinácia inhibítora ACE so sartanom sa rutinne neodporúča</strong> pre zvýšené riziko hyperkaliémie a akútneho poškodenia obličiek.</p>

<h3>Inhibítory SGLT2</h3>

<p>Význam presahuje zníženie glykémie. U vhodne vybraných pacientov znižujú riziko progresie chronickej choroby obličiek, hospitalizácie pre srdcové zlyhávanie aj závažných kardiovaskulárnych príhod, pričom renálny a kardiálny prínos sa preukázal aj v niektorých skupinách bez diabetu. Indikácia závisí od konkrétneho liečiva, eGFR, albuminúrie, prítomnosti diabetu a srdcového zlyhávania a od platných regulačných podmienok.</p>

<h3>Agonisty receptora GLP-1</h3>

<p>U vhodných pacientov znižujú telesnú hmotnosť, zlepšujú glykemickú kontrolu, znižujú výskyt závažných kardiovaskulárnych príhod a priaznivo ovplyvňujú niektoré renálne ukazovatele. Sledovať treba toleranciu, rýchlosť poklesu hmotnosti, gastrointestinálne nežiaduce účinky, hydratáciu, nutričný stav a stratu svalovej hmoty. Samotná príslušnosť k určitému štádiu nie je automatickou indikáciou.</p>

<h3>Nesteroidné antagonisty mineralokortikoidových receptorov</h3>

<p>U vybraných pacientov s diabetom 2. typu, chronickou chorobou obličiek a pretrvávajúcou albuminúriou napriek štandardnej liečbe znižujú kardiovaskulárne a renálne riziko. Podmienkou je primeraná funkcia obličiek a dôsledná kontrola kaliémie — hyperkaliémia zostáva klinicky významným rizikom.</p>

<h3>Lipidy a antitrombotická liečba</h3>

<p>Statíny sú základom liečby aterosklerotického rizika; intenzita sa riadi celkovým rizikom, prítomnosťou klinického alebo subklinického ochorenia, diabetom, chronickou chorobou obličiek a toleranciou. <strong>Kyselina acetylsalicylová nemá byť podávaná automaticky</strong> každému pacientovi s CKM syndrómom — pri primárnej prevencii treba individuálne zvážiť prínos oproti riziku krvácania.</p>

<h2>Model PREVENT a doplňujúce vyšetrenia</h2>

<p>Rovnice PREVENT odhadujú kardiovaskulárne riziko s využitím údajov relevantných pre CKM kontinuum a oproti starším modelom lepšie integrujú renálne a metabolické charakteristiky. Rizikový model však nenahrádza klinický úsudok — výsledok ovplyvňuje kvalita vstupných údajov, populácia, v ktorej bol model validovaný, vek pacienta, pridružené ochorenia aj faktory, ktoré model nezahŕňa.</p>

<p>Kalciové skóre pomáha najmä pri neistote o intenzite hypolipidemickej liečby; NT-proBNP a echokardiografia môžu u vybraných vysokorizikových pacientov odhaliť preklinické srdcové zlyhávanie. Ani jedno nie je plošným vyšetrením pre všetkých asymptomatických.</p>

<h2>Čo staging dokáže a čo nie</h2>

<p>Staging prináša spoločný jazyk pre kardiológov, nefrológov, diabetológov, obezitológov a všeobecných lekárov a pomáha identifikovať pacientov, u ktorých treba liečbu zintenzívniť skôr, než vznikne manifestné poškodenie. Má však hranice:</p>

<ol>
  <li><strong>Nie je biologicky absolútny.</strong> Jednotlivé štádiá zahŕňajú heterogénne skupiny.</li>
  <li><strong>Progresia nemusí byť lineárna.</strong> Pacient nemusí prejsť každým štádiom postupne — predstava nevyhnutného sledu štádií je zjednodušením, ktoré usmernenie nepodporuje.</li>
  <li><strong>Štádium nenahrádza diagnózu.</strong> Etiológia chronickej choroby obličiek, typ srdcového zlyhávania či mechanizmus obezity zostávajú rozhodujúce.</li>
  <li><strong>Nie každý marker patrí do plošného skríningu.</strong> Vyšetrenie má mať vopred definovaný klinický dôsledok.</li>
  <li><strong>Odporúčania nemožno mechanicky prenášať.</strong> Liečba závisí od indikácie, kontraindikácií, tolerancie, funkcie obličiek a preferencií pacienta.</li>
</ol>

<h2>Význam pre nefrologickú prax</h2>

<p>CKM koncept posúva nefrológiu k skoršej prevencii. Nefrológ nemá hodnotiť len eGFR a čas do zlyhania obličiek — rovnako významné sú albuminúria, kardiovaskulárne riziko, srdcové zlyhávanie, obezita a telesná kompozícia, diabetes, tlak krvi, metabolická steatotická choroba pečene a bezpečná kombinácia orgánovo protektívnych liekov.</p>

<p>Rovnako dôležité je zabrániť terapeutickej zotrvačnosti. Pacient s albuminurickou chronickou chorobou obličiek, diabetom a vysokým kardiovaskulárnym rizikom potrebuje spravidla viac než kontrolu glykémie a tlaku krvi — rozhodujúca je kombinovaná redukcia reziduálneho renálneho aj kardiovaskulárneho rizika.</p>

<h2>Záver</h2>

<p>Najväčším prínosom CKM rámca je presun pozornosti od liečby už vzniknutých komplikácií k včasnej identifikácii rizika. Prakticky najdôležitejšie sú súčasné hodnotenie eGFR a uACR, dôsledná liečba hypertenzie a dyslipidémie, aktívny manažment obezity a diabetu a využívanie liekov s preukázaným kardiálnym a renálnym účinkom podľa konkrétnych indikácií.</p>

<p>Staging má pritom slúžiť ako organizačný a rozhodovací rámec, nie ako náhrada individuálnej diagnostiky. Kvalitná starostlivosť zostáva založená na etiológii ochorenia, absolútnom riziku, kontraindikáciách, preferenciách pacienta a koordinácii viacerých odborností.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=ckm-syndrom-prva-multidisciplinarna-smernica-2026">Prvá multidisciplinárna CKM smernica (AHA/ACC/ADA/ASN 2026)</a> — čo je nové a desať hlavných odporúčaní.</li>
  <li><a href="article.php?slug=ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia">CKM syndróm ako jeden rámec</a> — čo usmernenia znamenajú pre nefrologickú ambulanciu.</li>
  <li><a href="article.php?slug=5-kritickych-chyb-manazment-ckm-syndromu-nefrologia">5 kritických chýb v manažmente CKM syndrómu</a>.</li>
  <li><a href="article.php?slug=finerenon-ckm-syndrom-dm2-ckd-fidelity">Finerenón pri CKM syndróme</a> — analýza FIDELITY.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Chiadi E. Ndumele, Fatima Rodriguez, Dave L. Dixon, Sadiya S. Khan, Debabrata Mukherjee, Mandeep Bajaj, Sripal Bangalore, Biykem Bozkurt, Khadijah Breathett, Shoa L. Clarke, Ian H. de Boer, David H. Ellison, Lorraine S. Evangelista, Sean P. Heffron, Dhruv S. Kazi, Ambar Kulshreshtha, Ildiko Lingvay, Cecilia C. Low Wang, Claudia A. Mercado, John Magaña Morton, Ian J. Neeland, Neha Pagidipati, Tiffany M. Powell-Wiley, Janani Rangaswami, Goutham Rao, Nosheen Reza, Anum Saeed, Wendy St Peter, J. Bradley Starks, Madeline Sterling, Amy W. Talbot, Andrew H. Tran, Katherine R. Tuttle, Lisa B. VanWagner, Amanda R. Vest, Salim S. Virani.</strong> <em>2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome.</em> Circulation. 2026;154(4):e50–e158. doi: 10.1161/CIR.0000000000001453. <a href="https://pubmed.ncbi.nlm.nih.gov/42263157/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1161/CIR.0000000000001453" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Neil Skolnik.</strong> <em>CKM Syndrome: Staging, Screening, and Treatment.</em> Medscape, 2026. <a href="https://www.medscape.com/viewarticle/ckm-syndrome-staging-screening-and-treatment-2026a1000oc0" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>American Heart Association.</strong> <em>First-ever clinical guideline issued for cardiovascular-kidney-metabolic (CKM) syndrome.</em> Newsroom, 2026. <a href="https://newsroom.heart.org/news/first-ever-guideline-on-cardiovascular-kidney-metabolic-syndrome-issued" target="_blank" rel="noopener noreferrer">AHA Newsroom</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje usmernenia vrátane kompletného autorstva písacieho výboru boli overené v Europe PMC (Circulation 2026;154(4):e50–e158, PMID 42263157). Prahové hodnoty pre štádium 3 — kalciové skóre nad 100, NT-proBNP ≥ 125 pg/ml s echokardiografickým dôkazom komorovej dysfunkcie, veľmi vysoké riziko chronickej choroby obličiek podľa tabuľky KDIGO a desaťročné riziko nad 20 % podľa rovníc PREVENT — boli overené proti publikovanému opisu stagingu. Plné znenie usmernenia je rozsiahly dokument a nebolo pri príprave článku prečítané v celom rozsahu; jednotlivé odporúčania preto nie sú citované s uvedením triedy odporúčania a úrovne dôkazov. Dve spresnenia oproti populárnym zhrnutiam — že klasifikácia má <strong>päť</strong> štádií vrátane štádia 0 (nie štyri) a že adipozita je ústredným, <strong>nie jediným</strong> mechanizmom — sú vlastnou korekciou. Časti o hraniciach stagingu a o význame pre nefrologickú prax sú vlastným odborným spracovaním.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ckm-syndrom-stadia-skrining-liecba-usmernenie-2026_article',
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
