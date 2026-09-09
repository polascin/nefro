<?php
/**
 * Odborný článok: PPI verzus H2-antihistaminiká u pacientov s CKD užívajúcich NSAID.
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
    'title'        => 'Inhibítory protónovej pumpy verzus H2-antihistaminiká u pacientov s CKD užívajúcich nesteroidové antiflogistiká',
    'slug'         => 'ppi-h2-antihistaminika-nsaid-ckd-progresia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V juhokórejskej kohorte bolo užívanie PPI spojené s 38 % vyšším relatívnym rizikom progresie CKD než H2-antihistaminiká. Hlavným modifikovateľným problémom však zostáva samotné nesteroidové antiflogistikum.',
    'content'      => <<<'HTML'
<p>Tradičné nesteroidové antiflogistiká (NSAID) patria medzi lieky, ktoré si pri chronickej chorobe obličiek (CKD) vyžadujú mimoriadnu opatrnosť. Inhibícia renálnej syntézy prostaglandínov môže znížiť prietok krvi obličkami, vyvolať retenciu sodíka a vody, zhoršiť hypertenziu a prispieť k akútnemu poškodeniu obličiek. Riziko stúpa pri vyššom veku, dehydratácii, srdcovom zlyhávaní a pri súbežnom užívaní diuretík alebo inhibítorov systému renín-angiotenzín.</p>

<p>Na prevenciu alebo liečbu gastrointestinálnych komplikácií sa k NSAID často pridávajú inhibítory protónovej pumpy (PPI). Ich dlhodobé používanie sa však v observačných štúdiách spája s akútnou tubulointersticiálnou nefritídou, akútnym poškodením obličiek aj s vyšším rizikom vzniku a progresie CKD.</p>

<p>Juhokórejská retrospektívna kohortová štúdia publikovaná v <em>Journal of Nephrology</em> preto porovnala riziko progresie CKD pri PPI a pri antagonistoch histamínových receptorov H2 (H2RA) práve u pacientov užívajúcich tradičné NSAID. Výsledky naznačujú nižšie riziko pri H2-antihistaminikách — pre observačný dizajn však nepreukazujú príčinnú súvislosť.</p>

<h2>Usporiadanie štúdie</h2>

<p>Autori použili celoštátne juhokórejské údaje zdravotných poisťovní z rokov 2018 až 2023. Z <strong>141 093 pacientov s CKD, ktorí začali užívať tradičné NSAID</strong>, do porovnania vstúpili tí, ktorým bola súčasne predpísaná liečba potláčajúca sekréciu žalúdočnej kyseliny:</p>

<ul>
  <li>5 315 pacientov s PPI,</li>
  <li>7 112 pacientov s H2-antihistaminikom.</li>
</ul>

<p>Porovnávaná kohorta teda zahŕňala 12 427 pacientov, čo je necelých 9 % z pôvodného súboru užívateľov NSAID. Väčšina pacientov s CKD, ktorým bolo NSAID predpísané, gastroprotekciu nedostala — samo osebe zaujímavé číslo.</p>

<p>Na vyváženie pozorovaných rozdielov medzi skupinami autori použili stabilizované inverzné váženie podľa pravdepodobnosti liečby. Nelineárne vzťahy medzi kumulatívnou expozíciou liekom a progresiou CKD analyzovali Coxovým modelom s obmedzenými kubickými splajnami. Analýzy citlivosti zamerané na prípady s nešpecifikovaným štádiom CKD podľa autorov potvrdili robustnosť hlavného nálezu.</p>

<h2>Hlavný výsledok</h2>

<p>Používanie PPI bolo v porovnaní s H2-antihistaminikami spojené s vyšším rizikom progresie CKD: <strong>upravený pomer hazardu 1,38 (95 % interval spoľahlivosti 1,10 – 1,74)</strong>. Relatívne riziko bolo teda približne o 38 % vyššie a interval spoľahlivosti neprechádzal jednotkou.</p>

<p>Tento údaj však nevyjadruje absolútny nárast rizika. Bez počtu udalostí, incidencie na pacientoroky a absolútneho rozdielu medzi skupinami nemožno určiť, koľkým prípadom progresie by sa zámenou PPI za H2-antihistaminikum teoreticky dalo predísť. Pri dolnej hranici intervalu 1,10 navyše nemožno vylúčiť, že skutočný efekt je podstatne menší než bodový odhad.</p>

<p>Rovnako podstatná je presná definícia progresie CKD. Z publikovaného súhrnu nie je zrejmé, či bola založená na prechode do vyššieho štádia, na diagnostických kódoch, na začatí náhrady funkcie obličiek alebo na inom administratívnom ukazovateli. Bez tejto informácie nemožno posúdiť klinickú závažnosť výsledku ani riziko nesprávnej klasifikácie.</p>

<h2>Ostatné faktory v modeli</h2>

<div class="table-responsive" role="region" aria-label="Faktory spojené s progresiou chronickej choroby obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Faktor</th>
      <th scope="col">Upravený pomer hazardu</th>
      <th scope="col">95 % interval spoľahlivosti</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">PPI verzus H2-antihistaminikum</th>
      <td>1,38</td>
      <td>1,10 – 1,74</td>
    </tr>
    <tr>
      <th scope="row">Arteriálna hypertenzia</th>
      <td>2,03</td>
      <td>1,37 – 2,99</td>
    </tr>
    <tr>
      <th scope="row">Predchádzajúce užívanie diuretika</th>
      <td>2,00</td>
      <td>1,56 – 2,58</td>
    </tr>
    <tr>
      <th scope="row">Diabetes mellitus</th>
      <td>1,69</td>
      <td>1,29 – 2,21</td>
    </tr>
    <tr>
      <th scope="row">Anamnéza ochorenia obličiek</th>
      <td>1,43</td>
      <td>1,13 – 1,81</td>
    </tr>
    <tr>
      <th scope="row">Dapagliflozín alebo empagliflozín</th>
      <td>0,49</td>
      <td>0,27 – 0,89</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tieto výsledky sú klinicky uveriteľné, nemožno ich však automaticky interpretovať ako nezávislé príčinné účinky jednotlivých diagnóz alebo liekov.</p>

<p>Najzreteľnejšie to platí pre <strong>diuretiká</strong>. Diuretikum môže byť markerom srdcového zlyhávania, objemového preťaženia, rezistentnej hypertenzie alebo pokročilejšej choroby obličiek. Asociácia s dvojnásobným rizikom preto neznamená, že vysadenie diuretika renálnu prognózu zlepší — u pacienta s kongesciou by neodôvodnené vysadenie mohlo stav naopak zhoršiť.</p>

<h3>Inhibítory SGLT2</h3>

<p>Približne 51-percentné relatívne zníženie rizika pri dapagliflozíne alebo empagliflozíne je v súlade so známym nefroprotektívnym účinkom tejto skupiny. V tejto štúdii však nešlo o randomizované porovnanie s placebom a výsledok mohli ovplyvniť rozdielne indikácie a kontraindikácie, výber pacientov s vhodnejšou funkciou obličiek, lepšia dostupnosť modernej liečby, vyššia adherencia, intenzívnejšie sledovanie aj časové zaradenie expozície.</p>

<p>Nefroprotekciu inhibítorov SGLT2 podporujú randomizované štúdie; veľkosť účinku z tejto administratívnej kohorty však nemožno považovať za nový príčinný odhad.</p>

<h2>Podskupiny a problém krátkej expozície</h2>

<p>Relatívne vyššie riziko pri PPI bolo najvýraznejšie u žien, u pacientov s CKD v štádiu G3, vo veku 71 rokov a viac a pri liečbe trvajúcej 1 až 15 dní.</p>

<p>Podskupinové výsledky treba interpretovať opatrne. Štatistická významnosť v jednej podskupine a jej neprítomnosť v druhej sama osebe nedokazuje, že sa účinok medzi skupinami skutočne líši — na také tvrdenie je potrebný významný test interakcie.</p>

<p>Osobitne problematická je asociácia už pri <strong>jedno- až pätnásťdňovej</strong> liečbe. Taký krátky interval je biologicky málo presvedčivý ako príčina skutočnej progresie chronického ochorenia. Pravdepodobnejšie odráža:</p>

<ul>
  <li>akútne poškodenie obličiek nesprávne klasifikované ako progresia CKD,</li>
  <li>závažnosť akútneho ochorenia, pre ktoré bol PPI predpísaný,</li>
  <li>hospitalizáciu alebo krvácanie,</li>
  <li>intenzívnejšie laboratórne a diagnostické sledovanie u chorejších pacientov,</li>
  <li>reverznú kauzalitu,</li>
  <li>nepresné zachytenie expozície v administratívnych údajoch.</li>
</ul>

<p>Tento nález teda skôr <em>oslabuje</em> jednoduchú príčinnú interpretáciu, než by dokazoval skorú nefrotoxicitu PPI.</p>

<h2>Možné renálne účinky PPI</h2>

<h3>Akútna tubulointersticiálna nefritída</h3>

<p>Najlepšie doložený renálny nežiaduci účinok PPI. Môže sa prejaviť akútnym alebo subakútnym vzostupom kreatinínu, často bez klasickej triády horúčky, exantému a eozinofílie. Pri oneskorenej diagnóze nemusí dôjsť k úplnej úprave funkcie obličiek a opakované alebo nerozpoznané epizódy by teoreticky mohli prispievať k chronickému tubulointersticiálnemu poškodeniu. Ide o najpravdepodobnejší mechanizmus spájajúci PPI s dlhodobým renálnym rizikom.</p>

<h3>Hypomagneziémia</h3>

<p>Dlhodobé používanie PPI môže viesť k hypomagneziémii, najmä pri súbežnom užívaní diuretík. Následkom môže byť svalová slabosť, kŕče, arytmie a ďalšie elektrolytové poruchy. Hypomagneziémia však sama osebe nevysvetľuje všetky pozorované asociácie medzi PPI a CKD.</p>

<h3>Ďalšie hypotézy</h3>

<p>Diskutuje sa aj o zmenách črevného mikrobiómu, endotelovej dysfunkcii, oxidačnom strese a poruchách metabolizmu mikronutrientov. Tieto mechanizmy zostávajú menej presvedčivo doložené a nemožno ich považovať za potvrdené vysvetlenie epidemiologických nálezov.</p>

<h3>Kontext skorších prác</h3>

<p>Zistenie nestojí osamotene. Analýza kohorty ARIC publikovaná v roku 2016 zistila vyššie riziko incidentnej CKD u používateľov PPI a v tom istom roku veľká kohorta veteránov opísala vyššie riziko incidentnej CKD aj progresie do zlyhania obličiek. Všetky tieto práce sú však observačné a zdieľajú rovnaké obmedzenia — vrátane skreslenia indikáciou.</p>

<h2>Hlavným modifikovateľným problémom zostáva samotné NSAID</h2>

<p>Porovnanie PPI a H2-antihistaminík nesmie zatieniť základnú otázku: <strong>potrebuje pacient s CKD tradičné nesteroidové antiflogistikum vôbec?</strong></p>

<p>PPI chráni pred časťou horných gastrointestinálnych komplikácií NSAID, ale:</p>

<ul>
  <li>nechráni obličky pred hemodynamickým účinkom NSAID,</li>
  <li>nezabraňuje retencii sodíka a vody,</li>
  <li>nezabraňuje zhoršeniu hypertenzie,</li>
  <li>neodstraňuje riziko akútneho poškodenia obličiek,</li>
  <li>neposkytuje úplnú ochranu pred gastrointestinálnym krvácaním,</li>
  <li>nechráni spoľahlivo dolnú časť tráviaceho traktu.</li>
</ul>

<p>Pred predpisom NSAID treba posúdiť štádium a dynamiku CKD, albuminúriu, objemový stav, srdcové zlyhávanie, krvný tlak, vek a krehkosť, riziko gastrointestinálneho krvácania, súbežné diuretikum, inhibítor ACE alebo blokátor receptorov angiotenzínu, antikoagulačnú a protidoštičkovú liečbu a dostupnosť menej rizikovej analgézie.</p>

<p>Kombinácia NSAID, diuretika a inhibítora systému renín-angiotenzín predstavuje klasickú trojicu s výrazne zvýšeným rizikom akútneho hemodynamického poškodenia obličiek.</p>

<h2>Je H2-antihistaminikum bezpečnejšou alternatívou?</h2>

<p>Výsledky podporujú zváženie H2-antihistaminika vtedy, keď je supresia žalúdočnej kyseliny skutočne indikovaná, PPI nie je nevyhnutný, očakávaná intenzita gastroprotekcie postačuje a nie sú prítomné závažné refluxné alebo ulcerózne komplikácie vyžadujúce PPI. Presne tak formulujú svoj záver aj autori — H2-antihistaminikum ako možná bezpečnejšia alternatíva tam, kde PPI <em>nie je nevyhnutný</em>.</p>

<p>Štúdia však nedokazuje, že H2-antihistaminiká sú všeobecne bezpečnejšie ani rovnako účinné vo všetkých gastroenterologických indikáciách. PPI zostávajú vhodné napríklad pri liečbe a prevencii recidívy krvácajúceho peptického vredu, pri závažnej erozívnej ezofagitíde, pri Barrettovom pažeráku podľa individuálnej indikácie, pri hypersekrečných stavoch, v niektorých režimoch eradikácie <em>Helicobacter pylori</em> a pri vysokej potrebe gastroprotekcie počas pokračujúcej rizikovej liečby.</p>

<h3>Vlastné obmedzenia H2-antihistaminík</h3>

<p>Zámena nie je bez nákladov. Viaceré H2-antihistaminiká sa eliminujú obličkami a pri zníženej glomerulovej filtrácii vyžadujú <strong>úpravu dávky</strong>. Pri akumulácii sa môže objaviť zmätenosť, delírium alebo iné neurologické nežiaduce účinky, najmä u starších pacientov — teda práve v skupine, kde bola v tejto štúdii asociácia s PPI najvýraznejšia.</p>

<p>Treba pamätať aj na to, že zloženie skupiny sa v čase zmenilo: ranitidín bol v roku 2020 pre kontamináciu nitrózamínom (NDMA) stiahnutý z väčšiny trhov, takže praktickou voľbou je dnes najmä famotidín. Skupinový výsledok z rokov 2018 až 2023 preto nemusí zodpovedať dnešnému spektru predpisovaných liečiv.</p>

<h2>Kritické zhodnotenie štúdie</h2>

<h3>Observačný dizajn</h3>

<p>Štúdia preukazuje asociáciu, nie príčinnosť. Inverzné váženie podľa pravdepodobnosti liečby vyvažuje iba premenné dostupné a správne zaznamenané v databáze; nezohľadnené alebo nepresne zachytené rozdiely môžu pretrvávať.</p>

<h3>Skreslenie indikáciou</h3>

<p>PPI a H2-antihistaminiká sa nepredpisujú rovnakým pacientom. PPI môžu častejšie dostávať pacienti s anamnézou vredu alebo krvácania, s vyššou komorbiditou, po hospitalizácii, s intenzívnejšou protidoštičkovou či antikoagulačnou liečbou, s vyšším gastrointestinálnym rizikom a s polyfarmáciou. Vyššie renálne riziko tak môže sčasti odrážať klinický profil pacienta, nie samotné liečivo.</p>

<h3>Obmedzenia administratívnych údajov</h3>

<p>Databázy poisťovní spoľahlivo zachytávajú predpis alebo výdaj lieku, nie však skutočné užívanie a adherenciu, voľnopredajné NSAID a PPI, sérový kreatinín a eGFR, albuminúriu, objemový stav, krvný tlak, fajčenie, telesnú hmotnosť, stravu a hydratáciu ani závažnosť akútneho ochorenia. Diagnostické kódy CKD a jej štádia môžu byť neúplné — čo je aj dôvod, prečo autori robili samostatnú analýzu citlivosti pre prípady s nešpecifikovaným štádiom.</p>

<h3>Časovo závislá expozícia</h3>

<p>Pri liekoch, ktorých užívanie sa opakovane začína a prerušuje, je rozhodujúce, ako sa definoval začiatok, kumulatívna dávka a dĺžka expozície. Nesprávne časové priradenie môže viesť ku skresleniu nesmrteľným časom, ku skresleniu časovým oknom alebo k reverznej kauzalite.</p>

<h3>Heterogenita skupín</h3>

<p>Ani PPI, ani H2-antihistaminiká nie sú homogénne skupiny. Rozdiely môžu existovať medzi jednotlivými liečivami, dávkami, trvaním liečby a mierou renálnej eliminácie. Skupinový výsledok nemožno bez podrobnejšej analýzy prenášať na konkrétny liek.</p>

<h2>Praktické dôsledky</h2>

<ol>
  <li>Overiť, či je NSAID stále potrebné.</li>
  <li>Použiť najnižšiu účinnú dávku počas čo najkratšieho obdobia.</li>
  <li>Zvážiť menej rizikovú analgetickú alternatívu.</li>
  <li>Overiť indikáciu liečby potláčajúcej sekréciu kyseliny.</li>
  <li>Nepokračovať v PPI zo zotrvačnosti bez platnej indikácie.</li>
  <li>Zvážiť H2-antihistaminikum tam, kde poskytne postačujúcu ochranu.</li>
  <li>Upraviť dávku H2-antihistaminika podľa funkcie obličiek a sledovať neurologické nežiaduce účinky u starších pacientov.</li>
  <li>Sledovať kreatinín, eGFR, draslík, sodík a objemový stav.</li>
  <li>Pri dlhodobom PPI zvážiť kontrolu magnézia podľa rizikového profilu.</li>
  <li>Poučiť pacienta o riziku voľnopredajných NSAID, ktoré databázy ani lekár nemusia zachytiť.</li>
</ol>

<p>PPI sa nemá náhle vysadiť bez posúdenia indikácie a rizika návratovej hypersekrécie. U vhodného pacienta možno dávku znižovať, prejsť na intermitentné podávanie alebo liečbu ukončiť kontrolovane.</p>

<h2>Záver</h2>

<p>V juhokórejskej retrospektívnej kohorte pacientov s CKD užívajúcich tradičné NSAID bolo používanie PPI v porovnaní s H2-antihistaminikami spojené s 38 % vyšším relatívnym rizikom progresie choroby obličiek (upravený pomer hazardu 1,38; 95 % interval spoľahlivosti 1,10 – 1,74).</p>

<p>Výsledok podporuje racionálnu revíziu indikácie PPI a zváženie H2-antihistaminika tam, kde PPI nie je nevyhnutný. Neoprávňuje však k plošnému vysadzovaniu PPI ani nedokazuje, že ich nahradenie H2-antihistaminikami progresii CKD zabráni — najmä keď sa najsilnejšia asociácia objavila už pri liečbe kratšej než dva týždne, čo je pre skutočnú progresiu chronického ochorenia biologicky ťažko obhájiteľné.</p>

<p>Najvýznamnejším preventívnym opatrením zostáva minimalizácia expozície nesteroidovým antiflogistikám. Pri každom pacientovi treba najskôr posúdiť potrebu samotného NSAID a až potom zvoliť primeranú gastroprotekciu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=bolest-driekovej-oblasti-ischias-diagnostika-liecba-ckd">Bolesť v driekovej oblasti a ischias: diagnostika, liečba a bezpečnosť analgetík pri CKD</a></li>
  <li><a href="article.php?slug=nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki">Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou: príčiny, diagnostika a klinický postup</a></li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a></li>
  <li><a href="article.php?slug=postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema">Postmarketingové bezpečnostné zlyhania liekov: analýza 10 liekov s fatálnymi dôsledkami</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Park S, Chun P. Chronic kidney disease progression with proton pump inhibitors versus H2 receptor antagonists in NSAID users. Journal of Nephrology. 2026. doi: 10.1093/joneph/aajag176. PMID 42687760. <a href="https://pubmed.ncbi.nlm.nih.gov/42687760/" target="_blank" rel="noopener noreferrer">PubMed</a>. Hlavný spracovaný zdroj; v čase spracovania publikácia pred zaradením do čísla.</em></small></li>
  <li><small><em>Lazarus B, Chen Y, Wilson FP, Sang Y, Chang AR, Coresh J, Grams ME. Proton Pump Inhibitor Use and the Risk of Chronic Kidney Disease. JAMA Internal Medicine. 2016;176(2):238–246. doi: 10.1001/jamainternmed.2015.7193. PMID 26752337. <a href="https://pubmed.ncbi.nlm.nih.gov/26752337/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4772730/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>.</em></small></li>
  <li><small><em>Xie Y, Bowe B, Li T, Xian H, Balasubramanian S, Al-Aly Z. Proton Pump Inhibitors and Risk of Incident CKD and Progression to ESRD. Journal of the American Society of Nephrology. 2016;27(10):3153–3163. doi: 10.1681/ASN.2015121377. PMID 27080976. <a href="https://pubmed.ncbi.nlm.nih.gov/27080976/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5042677/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. PMID 38490803. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">stránka odporúčania</a>.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ppi-h2-antihistaminika-nsaid-ckd-progresia_article',
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
