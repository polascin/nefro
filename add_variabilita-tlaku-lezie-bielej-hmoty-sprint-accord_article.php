<?php
/**
 * Odborny clanok: variabilita systolickeho tlaku medzi navstevami a progresia lezii bielej hmoty
 * (zdruzena analyza SPRINT MIND a ACCORD MIND).
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_variabilita-tlaku-lezie-bielej-hmoty-sprint-accord_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Variabilita systolického tlaku medzi návštevami a rýchlejšia progresia lézií bielej hmoty: čo z toho plynie pre nefrologickú prax',
    'slug'         => 'variabilita-tlaku-lezie-bielej-hmoty-sprint-accord',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Združená analýza štúdií SPRINT MIND a ACCORD MIND spojila vyššiu variabilitu systolického tlaku medzi návštevami s rýchlejšou progresiou lézií bielej hmoty. Variabilita však vysvetlila iba asi 9 % ochranného účinku intenzívnej kontroly tlaku.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>V združenej analýze individuálnych údajov z dvoch randomizovaných štúdií bola vyššia variabilita systolického krvného tlaku medzi návštevami nezávisle spojená s rýchlejšou progresiou abnormalít bielej hmoty. Intenzívne znižovanie systolického tlaku progresiu spomalilo, pričom variabilita tlaku tento účinok sprostredkovala iba čiastočne — podľa autorov približne z deviatich percent.</em></p>

<h2>Prečo je téma zaujímavá</h2>

<p>Lézie bielej hmoty mozgu sú markerom cerebrálneho ochorenia malých ciev. Spájajú sa s kognitívnym poklesom, poruchami chôdze, depresiou a rizikom cievnej mozgovej príhody. Ich progresia je pomalá a merateľná na magnetickej rezonancii, čo z nich robí užitočný náhradný ukazovateľ pri hodnotení cievnej ochrany mozgu.</p>

<p>Otázka, či záleží nielen na <em>priemernej výške</em> krvného tlaku, ale aj na jeho <em>stabilite</em>, je stará a doteraz nebola presvedčivo zodpovedaná. Predchádzajúce práce boli nekonzistentné a metodologicky heterogénne.</p>

<p>Pre nefrológiu je téma dvojnásobne relevantná: pacienti s chronickou chorobou obličiek majú vyššie kardiovaskulárne riziko, častejšiu nestabilitu tlaku a zároveň vyšší výskyt cerebrálneho ochorenia malých ciev. Uvedený dôkaz sa však týka populácie s vysokým kardiovaskulárnym rizikom, nie špecificky kohorty s CKD.</p>

<h2>Dizajn analýzy</h2>

<div class="table-responsive" role="region" aria-label="Základné parametre združenej analýzy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Údaj</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Dizajn</th><td>post hoc združená analýza individuálnych údajov účastníkov</td></tr>
    <tr><th scope="row">Zdroje údajov</th><td>podštúdie s magnetickou rezonanciou zo štúdií ACCORD MIND a SPRINT MIND</td></tr>
    <tr><th scope="row">Zaradenie</th><td>dostupná východisková aj kontrolná magnetická rezonancia a najmenej 3 merania tlaku od 3-mesačnej návštevy</td></tr>
    <tr><th scope="row">Počet účastníkov</th><td>952</td></tr>
    <tr><th scope="row">Expozícia</th><td>variabilita systolického tlaku medzi návštevami; primárnou metrikou bola vopred stanovená VIM</td></tr>
    <tr><th scope="row">Výsledok</th><td>progresia objemu abnormálnej bielej hmoty; primárne ako celková zmena transformovaná funkciou asinh</td></tr>
    <tr><th scope="row">Štatistika</th><td>viacrozmerná lineárna regresia a kauzálna mediačná analýza</td></tr>
  </tbody>
</table>
</div>

<p>Priemerný vek účastníkov bol 64,8 roka (smerodajná odchýlka 7,1) a ženy tvorili 42 % (400 z 952). Medián počtu meraní tlaku na účastníka bol 12 (medzikvartilové rozpätie 10 až 14).</p>

<h3>Dve metodické rozhodnutia, ktoré stojí za to vysvetliť</h3>

<p><strong>Prvé: výpočet variability až od tretieho mesiaca.</strong> Merania z prvých troch mesiacov boli vynechané zámerne. V tom období sa liečba ešte titruje a tlak prirodzene kolíše, takže by sa do „variability“ započítalo doladenie režimu namiesto skutočnej nestability.</p>

<p><strong>Druhé: metrika VIM.</strong> Skratka VIM označuje <em>variation independent of mean</em>, teda variabilitu nezávislú od priemeru. Bežné miery rozptylu, ako smerodajná odchýlka alebo variačný koeficient, s priemernou hodnotou tlaku korelujú — kto má vyšší tlak, má spravidla aj väčší rozptyl. VIM je matematicky konštruovaná tak, aby táto závislosť odpadla, a preto umožňuje oddeliť účinok nestability od účinku samotnej výšky tlaku. Ostatné metriky (smerodajná odchýlka, variačný koeficient, ARV) slúžili na overenie robustnosti.</p>

<h2>Hlavné výsledky</h2>

<p>Medián objemu abnormálnej bielej hmoty vzrástol z 1,69 ml na 2,58 ml, teda o 0,43 ml za rok (smerodajná odchýlka 0,84).</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky združenej analýzy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Vzťah</th>
      <th scope="col">Odhad</th>
      <th scope="col">95 % interval spoľahlivosti</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Vyššia variabilita systolického tlaku a rýchlejšia progresia</th><td>β = 0,017</td><td>0,001 až 0,033</td></tr>
    <tr><th scope="row">Intenzívna kontrola tlaku a pomalšia progresia</th><td>β = −0,270</td><td>−0,393 až −0,146</td></tr>
    <tr><th scope="row">Priemerný kauzálny mediačný účinok variability</th><td>0,014 (9,15 % celkového účinku)</td><td>0,001 až 0,034</td></tr>
  </tbody>
</table>
</div>

<p>Účastníci v najvyššom tercile variability mali v surovom ročnom vyjadrení o <strong>0,160 ml za rok</strong> rýchlejšiu progresiu než účastníci v najnižšom tercile. Vzhľadom na priemernú ročnú progresiu 0,43 ml ide o rozdiel zodpovedajúci zhruba tretine typického ročného prírastku — v relatívnom vyjadrení teda nejde o zanedbateľnú hodnotu.</p>

<div class="pdf-avoid-break">
<h3>Prečo sú hodnoty β také malé a čo znamená deväť percent</h3>

<p>Regresné koeficienty vyzerajú nepatrne, pretože primárny ukazovateľ bol transformovaný inverznou hyperbolickou funkciou sínus (asinh). Táto transformácia stláča veľké hodnoty a umožňuje pracovať aj s nulovými a veľmi malými objemami. Koeficienty preto nemožno čítať priamo ako mililitre — na to slúži uvedené surové ročné vyjadrenie po terciloch.</p>

<p>Podstatnejší je iný údaj. <strong>Mediačná analýza pripísala variabilite tlaku 9,15 % celkového ochranného účinku intenzívnej kontroly tlaku.</strong> Inak povedané: viac než deväť desatín prínosu intenzívnej liečby sa variabilitou nevysvetlilo. Stabilita tlaku teda podľa týchto údajov nie je hlavným mechanizmom, ktorým intenzívna liečba chráni bielu hmotu — je jedným z viacerých, a nie tým najvýznamnejším.</p>

<p>Za povšimnutie stojí aj krehkosť hlavnej asociácie: dolná hranica intervalu spoľahlivosti pre β je 0,001, teda tesne nad nulou. To isté platí pre mediačný účinok (dolná hranica 0,001). Ide o štatisticky významné, ale nie robustné nálezy — pri mierne odlišnej analýze by sa hranica významnosti mohla ľahko prekročiť opačným smerom.</p>
</div>

<h2>Metodologické zhodnotenie</h2>

<h3>Silné stránky</h3>

<ul>
  <li>zdrojom sú dve veľké randomizované štúdie, takže priradenie k intenzívnej alebo štandardnej kontrole tlaku bolo randomizované,</li>
  <li>združenie individuálnych údajov účastníkov je metodologicky silnejšie než zlučovanie publikovaných súhrnov,</li>
  <li>objektívny zobrazovací ukazovateľ s automatizovanou segmentáciou,</li>
  <li>vopred stanovená primárna metrika variability (VIM) navrhnutá tak, aby bola nezávislá od priemeru tlaku,</li>
  <li>vylúčenie prvých troch mesiacov, čím sa obmedzil vplyv úvodnej titrácie liečby,</li>
  <li>overenie robustnosti alternatívnymi metrikami variability,</li>
  <li>dostatočný počet meraní tlaku na účastníka (medián 12),</li>
  <li>transparentné uvedenie podielu mediácie namiesto samotného konštatovania „čiastočnej mediácie“.</li>
</ul>

<h3>Obmedzenia</h3>

<ol>
  <li><strong>Post hoc dizajn.</strong> Analýza nebola cieľom pôvodných štúdií. Randomizácia sa vzťahuje na intenzitu kontroly tlaku, nie na variabilitu — tá zostáva observačnou expozíciou.</li>
  <li><strong>Náhradný ukazovateľ.</strong> Hodnotila sa subklinická progresia lézií bielej hmoty, nie klinické príhody, ako sú cievna mozgová príhoda alebo demencia.</li>
  <li><strong>Malý podiel mediácie.</strong> Deväť percent celkového účinku znamená, že hlavný mechanizmus prínosu intenzívnej liečby zostáva nevysvetlený.</li>
  <li><strong>Krehká štatistická významnosť.</strong> Dolné hranice intervalov spoľahlivosti tesne nad nulou znižujú istotu záveru.</li>
  <li><strong>Reziduálne konfundovanie.</strong> Samotné liečebné režimy a spôsob ich titrácie môžu variabilitu ovplyvňovať, takže účinok liečby a variabilita nie sú úplne oddelené.</li>
  <li><strong>Obrátená príčinnosť.</strong> Už prítomné zmeny bielej hmoty môžu prispievať k dysregulácii tlaku, napríklad poruchou autonómnej regulácie, a tým variabilitu zvyšovať.</li>
  <li><strong>Variabilita medzi návštevami nie je to isté ako 24-hodinová variabilita.</strong> Zachytáva iné časové okno a iné mechanizmy než ambulantné monitorovanie tlaku.</li>
  <li><strong>Neistá prenositeľnosť na CKD.</strong> Zloženie kohorty podľa funkcie obličiek publikovaný abstrakt neuvádza; ide o populáciu s vysokým kardiovaskulárnym rizikom, nie o kohortu vybranú podľa eGFR.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie hlavných tvrdení o združenej analýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Vyššia variabilita systolického tlaku medzi návštevami je spojená s rýchlejšou progresiou lézií bielej hmoty</td><td><strong>Potvrdené</strong></td><td>β = 0,017 (95 % IS 0,001 až 0,033) pri metrike nezávislej od priemeru tlaku; významnosť je však tesná</td></tr>
    <tr><td>Intenzívna kontrola systolického tlaku spomaľuje progresiu</td><td><strong>Potvrdené</strong></td><td>β = −0,270 (95 % IS −0,393 až −0,146); ide o randomizovanú expozíciu, teda o najsilnejší nález analýzy</td></tr>
    <tr><td>Časť účinku intenzívnej kontroly je sprostredkovaná variabilitou tlaku</td><td><strong>Podporené, ale malá časť</strong></td><td>Mediačný účinok 0,014 (95 % IS 0,001 až 0,034), teda 9,15 % celkového účinku</td></tr>
    <tr><td>Variabilita tlaku je hlavným mechanizmom prínosu intenzívnej liečby</td><td><strong>Nie</strong></td><td>Vyše 90 % účinku sa variabilitou nevysvetlilo</td></tr>
    <tr><td>Variabilita tlaku je overeným cieľom liečby</td><td><strong>Nedokázané</strong></td><td>Ide o post hoc analýzu; žiadna intervencia zameraná priamo na variabilitu nebola testovaná</td></tr>
    <tr><td>Výsledky možno priamo použiť na nastavenie cieľov tlaku u pacientov s CKD</td><td><strong>Príliš silné tvrdenie</strong></td><td>Kohorta bola vybraná podľa kardiovaskulárneho rizika; pri CKD sa uplatňujú aj iné mechanizmy, diuretiká, ortostatika a dialyzačný kontext</td></tr>
    <tr><td>Analýza dokazuje zníženie rizika cievnej mozgovej príhody</td><td><strong>Nie</strong></td><td>Hodnotil sa zobrazovací náhradný ukazovateľ, nie klinické príhody</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Nefrologické súvislosti</h2>

<p>Výsledok je pre nefrológiu zaujímavý v troch rovinách.</p>

<h3>Variabilita ako rizikový marker</h3>

<p>Kolísanie systolického tlaku medzi návštevami môže odrážať vaskulárnu dysreguláciu, ale aj celkom prozaické veci: nepravidelné užívanie liekov, chyby v titrácii, kolísanie objemového stavu, ortostatickú dysreguláciu, interkurentné ochorenia alebo nesprávnu techniku merania. U pacienta s chronickou chorobou obličiek sú prvé aj druhé mimoriadne časté.</p>

<p>Praktický dôsledok je jednoduchý: opakovane „skákajúci“ tlak medzi kontrolami si zaslúži pozornosť sám osebe, nie iba priemer zapísaný v dekurze.</p>

<h3>Variabilita ako potenciálne modifikovateľný mechanizmus</h3>

<p>Keďže intenzívna kontrola tlaku spomalila progresiu čiastočne aj cez zníženie variability, výsledok podporuje myšlienku, že cieľom má byť <em>stabilný</em> tlak, nie len priemerne nižší. Podiel 9 % však bráni tomu, aby sa stabilita vyhlásila za hlavný mechanizmus ochrany.</p>

<h3>Čo z toho pre prax pri CKD</h3>

<ul>
  <li>dôsledná a nie skoková titrácia antihypertenzív, s dostatočným časom na dosiahnutie ustáleného účinku,</li>
  <li>overenie adherencie a načasovania dávok pred tým, než sa liečba označí za neúčinnú,</li>
  <li>domáce alebo ambulantné monitorovanie tlaku tam, kde je dostupné, ako doplnok ordinačných meraní,</li>
  <li>riešenie faktorov nestability: diuretická stratégia a objemový stav, ortostatická hypotenzia, interkurentné ochorenia, liekové interakcie,</li>
  <li>u dialyzovaných pacientov osobitná pozornosť intradialytickému a interdialytickému kolísaniu tlaku, ktoré má vlastnú dynamiku a nie je totožné s variabilitou medzi ambulantnými návštevami,</li>
  <li>opatrnosť pri prílišnom znižovaní tlaku u krehkých pacientov s rizikom pádov.</li>
</ul>

<p>Zdôraznime však, že štúdia <strong>nie je dôkazom</strong>, že intervencia zameraná výlučne na variabilitu tlaku zníži výskyt cievnej mozgovej príhody alebo zlepší obličkové výsledky u pacientov s CKD.</p>

<h2>Praktický záver</h2>

<p>V populácii s vysokým kardiovaskulárnym rizikom bola vyššia variabilita systolického tlaku medzi návštevami nezávisle spojená s rýchlejšou progresiou abnormalít bielej hmoty. Intenzívne znižovanie systolického tlaku progresiu spomalilo a mediačná analýza naznačila, že variabilita tvorí súčasť mechanizmu — avšak len jeho menšiu časť.</p>

<p>Pre nefrologickú prax to podporuje dôraz na <strong>stabilitu krvného tlaku popri dosahovaní cieľovej priemernej hodnoty</strong>, s individualizáciou podľa komorbidít, rizika hypotenzie a ortostatiky a podľa možností monitorovania. Nepodporuje to však zavedenie variability tlaku ako samostatného terapeutického cieľa — na to by bola potrebná intervenčná štúdia, ktorá by variabilitu priamo ovplyvňovala a merala klinické výsledky.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek postihuje aj mozog: kognitívne poruchy, cievne poškodenie a klinické dôsledky</a></li>
  <li><a href="article.php?slug=implementacia-intenzivnej-kontroly-tlaku-esprit-nefrologia">Implementačné stratégie intenzívnej kontroly krvného tlaku: čo sa môžeme naučiť pre bežnú klinickú prax</a></li>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu: menej improvizácie, viac presného merania a praktických rozhodnutí</a></li>
  <li><a href="article.php?slug=renalna-denervacia-rezistentna-hypertenzia">Renálna denervácia pri rezistentnej hypertenzii: nádejná metóda, ale nie skratka v liečbe</a></li>
  <li><a href="article.php?slug=pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita">Pohybová aktivita pri fibrilácii predsiení: nižšie riziko cievnej mozgovej príhody a úmrtia</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Zhao W, Qiao Y, Sun Z, Harshfield EL, Cai L, Ji X, Markus HS.</strong> <em>Visit-to-Visit Blood Pressure Variability and Cerebral White Matter Lesion Progression: A Pooled Individual Patient Data Analysis of 2 Trials.</em> Neurology. 2026;107(3):e218302. doi: 10.1212/WNL.0000000000218302. <a href="https://doi.org/10.1212/WNL.0000000000218302" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42430676/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>SPRINT MIND Investigators for the SPRINT Research Group.</strong> <em>Association of Intensive vs Standard Blood Pressure Control With Cerebral White Matter Lesions.</em> JAMA. 2019;322(6):524–534. doi: 10.1001/jama.2019.10551. Zdrojová štúdia pre podštúdiu s magnetickou rezonanciou. <a href="https://doi.org/10.1001/jama.2019.10551" target="_blank" rel="noopener noreferrer">SPRINT MIND MRI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/31408137/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Williamson JD, Launer LJ, Bryan RN, a spol.; Action to Control Cardiovascular Risk in Diabetes Memory in Diabetes Investigators.</strong> <em>Cognitive function and brain structure in persons with type 2 diabetes mellitus after intensive lowering of blood pressure and lipid levels: a randomized clinical trial.</em> JAMA Intern Med. 2014;174(3):324–333. doi: 10.1001/jamainternmed.2013.13656. Zdrojová štúdia ACCORD MIND. <a href="https://doi.org/10.1001/jamainternmed.2013.13656" target="_blank" rel="noopener noreferrer">ACCORD MIND</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/24493100/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Blood Pressure Work Group.</strong> <em>KDIGO 2021 Clinical Practice Guideline for the Management of Blood Pressure in Chronic Kidney Disease.</em> Kidney Int. 2021;99(3S):S1–S87. doi: 10.1016/j.kint.2020.11.003. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/blood-pressure-in-ckd/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Blood Pressure Variability Linked to Faster White Matter Lesion Progression.</em> Medscape, 2026. Sekundárny spravodajský zdroj použitý ako východisko, nie ako hlavný dôkaz. <a href="https://www.medscape.com/viewarticle/blood-pressure-variability-linked-faster-white-matter-lesion-2026a1000rji" target="_blank" rel="noopener noreferrer">Spravodajské spracovanie</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Dizajn, zaraďovacie podmienky, počet účastníkov, vek a zastúpenie žien, medián počtu meraní tlaku, vývoj objemu abnormálnej bielej hmoty, hodnoty β s intervalmi spoľahlivosti pre variabilitu aj pre intenzívnu kontrolu tlaku, rozdiel medzi tercilmi (0,160 ml za rok) a mediačný účinok vrátane podielu 9,15 % boli overené priamo proti abstraktu publikácie v časopise Neurology (PubMed, PMID 42430676). Úplný autorský zoznam bol overený cez Crossref a PubMed — ide o sedem autorov, prvým je Wenbo Zhao a posledným Hugh S. Markus; mená neboli dopĺňané odhadom. Podrobnosti o zozname kovariát, o dĺžke intervalu medzi vyšetreniami magnetickou rezonanciou v jednotlivých štúdiách a o počte simulácií pri bootstrappingu publikovaný abstrakt neuvádza, preto sa v texte neuvádzajú. Prepočet rozdielu medzi tercilmi voči priemernej ročnej progresii je vlastný orientačný výpočet.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Ide o post hoc analýzu s náhradným zobrazovacím ukazovateľom. Variabilita krvného tlaku v nej nebola randomizovanou expozíciou, preto z výsledku nemožno odvodiť, že intervencia zameraná priamo na jej zníženie zlepší klinické výsledky. Cieľové hodnoty krvného tlaku pri chronickej chorobe obličiek treba stanoviť podľa platných odporúčaní KDIGO a individuálneho rizika pacienta.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_variabilita-tlaku-lezie-bielej-hmoty-sprint-accord_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
