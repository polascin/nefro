<?php
/**
 * Odborný článok: Čas v cieľovom rozmedzí HbA1c a systolického tlaku a renálne výsledky (post hoc ACCORD).
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
    'title'        => 'Čas v cieľovom rozmedzí HbA1c a systolického tlaku a renálne výsledky: post hoc analýza štúdie ACCORD',
    'slug'         => 'cas-v-cielovom-rozmedzi-hba1c-tlak-renalne-vysledky-accord',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dlhší čas HbA1c aj systolického tlaku v cieľovom rozmedzí počas prvého roka bol v post hoc analýze ACCORD spojený s nižším rizikom kombinovaného renálneho výsledku. Ide o asociáciu, nie o dôkaz kauzality.',
    'content'      => <<<'HTML'
<p>Metabolická a tlaková kompenzácia sa v praxi zvyčajne posudzuje podľa poslednej nameranej hodnoty glykovaného hemoglobínu (HbA1c) alebo krvného tlaku. Jediné meranie však nevystihuje dlhodobú stabilitu ochorenia ani kolísanie liečebnej odpovede. Post hoc analýza randomizovanej štúdie ACCORD, publikovaná v <em>American Journal of Kidney Diseases</em>, preto skúmala, či dlhšie zotrvanie HbA1c a systolického krvného tlaku (STK) v cieľovom rozmedzí súvisí s nižším rizikom nepriaznivých renálnych výsledkov.</p>

<p>Ukazovateľ „čas v cieľovom rozmedzí“ (<em>time in target range</em>, TTR) spája do jedného čísla informáciu o priemernej úrovni aj o variabilite hodnôt v čase. Najvýraznejšia asociácia sa v tejto analýze pozorovala u pacientov, ktorí mali <strong>obe</strong> hodnoty v cieľovom rozmedzí počas viac než 80 % prvého roka sledovania.</p>

<p>Výsledky podporujú sledovanie dlhodobých trendov. Nemožno ich však interpretovať ako dôkaz, že mechanické dosahovanie konkrétnej cieľovej hodnoty samo osebe zlepšuje renálnu prognózu.</p>

<h2>Usporiadanie analýzy a populácia</h2>

<p>Išlo o post hoc observačnú kohortovú analýzu údajov zo štúdie ACCORD (<em>Action to Control Cardiovascular Risk in Diabetes</em>). Zahrnutých bolo <strong>6542 účastníkov</strong> s diabetes mellitus 2. typu a prítomným kardiovaskulárnym ochorením alebo viacerými kardiovaskulárnymi rizikovými faktormi, ktorí mali počas prvých 12 mesiacov po randomizácii najmenej <strong>tri merania</strong> HbA1c aj STK.</p>

<p>ACCORD používala faktoriálne usporiadanie s dvoma liečebnými cieľmi:</p>

<div class="table-responsive" role="region" aria-label="Liečebné ciele v štúdii ACCORD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Doména</th>
      <th scope="col">Intenzívna liečba</th>
      <th scope="col">Štandardná liečba</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Glykémia</th>
      <td>HbA1c pod 6,0 %</td>
      <td>HbA1c 7,0 až 7,9 %</td>
    </tr>
    <tr>
      <th scope="row">Krvný tlak</th>
      <td>STK pod 120 mmHg</td>
      <td>STK pod 140 mmHg</td>
    </tr>
  </tbody>
</table>
</div>

<p>Treba pritom pamätať, že tlaková vetva ACCORD zahrnula 4733 účastníkov, zatiaľ čo glykemická vetva 10 251. Verejne dostupný súhrn analýzy neuvádza, ako presne bolo cieľové rozmedzie definované pre jednotlivé randomizačné vetvy ani ako sa postupovalo u účastníkov, ktorí neboli randomizovaní v tlakovej vetve. Pri preberaní konkrétnych prahov je preto namieste opatrnosť.</p>

<h3>Ako sa čas v cieľovom rozmedzí kategorizoval</h3>

<p>HbA1c-TTR a STK-TTR sa hodnotili počas prvých 12 mesiacov po randomizácii. Každý ukazovateľ bol samostatne rozdelený na hodnotu <strong>100 %</strong> a na <strong>tercily medzi zvyšnými účastníkmi</strong>. Referenčnou skupinou pre jednotlivé porovnania bol teda najnižší tercil <em>spomedzi tých, ktorí nedosiahli 100 %</em> — nie najnižší tercil celej kohorty.</p>

<p>Pre spoločné hodnotenie autori vytvorili <strong>štyri kategórie</strong>:</p>

<ol>
  <li>HbA1c-TTR aj STK-TTR najviac 80 %,</li>
  <li>HbA1c-TTR najviac 80 % a STK-TTR nad 80 %,</li>
  <li>HbA1c-TTR nad 80 % a STK-TTR najviac 80 %,</li>
  <li>HbA1c-TTR aj STK-TTR nad 80 %.</li>
</ol>

<p>Asociácie sa hodnotili Coxovými modelmi proporcionálnych hazardov.</p>

<h2>Hodnotený renálny výsledok</h2>

<p>Primárnym kombinovaným renálnym výsledkom bol vznik albuminúrie, pokles odhadovanej glomerulovej filtrácie (eGFR) najmenej o 40 % oproti východiskovej hodnote alebo zlyhanie obličiek.</p>

<p>Takto zostavený kompozit treba interpretovať opatrne. Novovzniknutá albuminúria je klinicky významný marker poškodenia obličiek, ale predstavuje odlišný typ udalosti než trvalý pokles filtrácie či zlyhanie obličiek. Keďže je zároveň najčastejšou zložkou, výsledok kompozitu ju spravidla odráža najsilnejšie. Práve preto sú dôležité aj samostatné analýzy jednotlivých zložiek, uvedené nižšie.</p>

<h2>Hlavné výsledky</h2>

<div class="table-responsive" role="region" aria-label="Asociácia času v cieľovom rozmedzí s kombinovaným renálnym výsledkom" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Porovnanie</th>
      <th scope="col">Referenčná skupina</th>
      <th scope="col">Pomer hazardu (95 % IS)</th>
      <th scope="col">Relatívne zníženie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">HbA1c-TTR 100 %</th>
      <td>najnižší tercil, najviac 49,6 %</td>
      <td>0,80 (0,68 – 0,94)</td>
      <td>o 20 %</td>
    </tr>
    <tr>
      <th scope="row">STK-TTR 100 %</th>
      <td>najnižší tercil, najviac 50,7 %</td>
      <td>0,68 (0,58 – 0,80)</td>
      <td>o 32 %</td>
    </tr>
    <tr>
      <th scope="row">HbA1c-TTR aj STK-TTR nad 80 %</th>
      <td>obe hodnoty najviac 80 %</td>
      <td>0,71 (0,61 – 0,83)</td>
      <td>o 29 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Kombinovaný čas v cieľovom rozmedzí nad 80 % bol oproti referenčnej kategórii spojený aj s priaznivejšími sekundárnymi výsledkami:</p>

<ul>
  <li>približne o <strong>43 %</strong> nižšie riziko celkovej mortality,</li>
  <li>približne o <strong>33 %</strong> nižšie riziko albuminúrie,</li>
  <li>približne o <strong>18 %</strong> nižšie riziko kombinácie poklesu eGFR najmenej o 40 % alebo zlyhania obličiek.</li>
</ul>

<p>Pri samostatnom hodnotení <strong>makroalbuminúrie</strong> a <strong>zlyhania obličiek</strong> sa štatisticky významná asociácia nepreukázala. Autori to pripisujú nízkemu počtu týchto udalostí a s ním spojenej nedostatočnej štatistickej sile. Výsledky boli vo všeobecnosti podobné aj v podskupine pacientov s chronickou chorobou obličiek na začiatku sledovania.</p>

<h3>Prečo sa asociácia nepozorovala v intenzívnej tlakovej vetve</h3>

<p>V podskupine randomizovanej do intenzívnej kontroly STK sa asociácie nepozorovali. Autori to vysvetľujú menšou variabilitou tlaku v tejto skupine, čo viedlo k užšiemu rozdeleniu STK-TTR a k menšiemu kontrastu medzi kategóriami. Ako ďalšie obmedzenie uvádzajú nízky počet udalostí v tejto podskupine.</p>

<p>Ide o dôležitú pripomienku: <strong>neprítomnosť štatisticky významnej asociácie nie je dôkazom neprítomnosti účinku.</strong> Ak je expozícia v celej skupine takmer rovnaká, štúdia jednoducho nemá čo porovnávať.</p>

<h2>Prečo pomer hazardu z tejto analýzy nie je liečebný účinok</h2>

<h3>Post hoc charakter</h3>

<p>Analýza nebola vopred navrhnutá ako štúdia hodnotiaca čas v cieľovom rozmedzí. Randomizácia v ACCORD sa týkala <em>intenzity liečby</em>, nie dosiahnutého podielu času v cieľovom rozmedzí. Vzhľadom na to, že TTR je výsledkom liečby aj priebehu ochorenia, porovnanie kategórií TTR nie je randomizovaným porovnaním a asociácie nemožno interpretovať ako kauzálny účinok.</p>

<h3>Reziduálne skreslenie</h3>

<p>Pacienti, ktorí dlhodobo zostávajú v cieľovom rozmedzí, môžu byť celkovo zdravší, adherentnejší a menej krehkí, môžu mať lepšiu vstupnú funkciu obličiek, stabilnejší priebeh ochorenia, lepšiu sociálnu podporu aj vyššiu zdravotnú gramotnosť. Aj po štatistickej úprave preto môže pretrvávať zmätočný vplyv týchto faktorov. Čas v cieľovom rozmedzí tak môže byť nielen prognostickým faktorom, ale aj <strong>markerom celkového zdravotného stavu</strong>.</p>

<p>Nápadne veľký rozdiel v celkovej mortalite (o 43 %) je s touto interpretáciou konzistentný. Renálne mechanizmy samy osebe by taký rozsiahly účinok na úmrtnosť vysvetlili len ťažko.</p>

<h3>Nejasný pojem synergie</h3>

<p>Autori hovoria o možnom synergickom prínose súbežného udržiavania oboch parametrov v cieľovom rozmedzí. Samotná skutočnosť, že kombinovaný ukazovateľ súvisel s nižším rizikom než jednotlivé zložky, však synergiu nedokazuje.</p>

<p>Na jej doloženie by bola potrebná formálna analýza interakcie a dôkaz, že spoločný účinok prekračuje očakávanie zo súčtu jednotlivých komponentov. Bez týchto údajov je presnejšie hovoriť o <em>priaznivej asociácii kombinovaného ukazovateľa</em>.</p>

<h2>Ciele z ACCORD nemožno prevziať mechanicky</h2>

<p>Toto je pri interpretácii najdôležitejšie. Pôvodná glykemická vetva ACCORD ukázala, že intenzívna liečba s cieľom HbA1c pod 6,0 % <strong>neznížila</strong> primárny kardiovaskulárny výsledok a bola spojená so <strong>zvýšenou celkovou mortalitou</strong>; táto vetva bola preto predčasne ukončená. Zistenia novej analýzy nemožno použiť ako argument pre univerzálne dosahovanie HbA1c pod 6,0 %.</p>

<p>Podobne tlaková vetva ACCORD nepreukázala, že cieľ STK pod 120 mmHg znižuje výskyt zloženého kardiovaskulárneho ukazovateľa oproti cieľu pod 140 mmHg (pomer hazardu 0,88; 95 % interval spoľahlivosti 0,73 – 1,06; P = 0,20). Znížil sa výskyt cievnej mozgovej príhody, ale závažné nežiaduce udalosti pripísané antihypertenzívnej liečbe boli v intenzívnej vetve podstatne častejšie (3,3 % oproti 1,3 %; P &lt; 0,001).</p>

<p>Cieľová hodnota HbA1c aj krvného tlaku musí byť individualizovaná podľa veku, trvania diabetu, rizika hypoglykémie, kognitívneho a funkčného stavu, prítomnosti chronickej choroby obličiek a očakávanej dĺžky života.</p>

<h2>V čom sa tento ukazovateľ líši od „time in range“ pri kontinuálnom monitorovaní glukózy</h2>

<p>Pojem <em>time in range</em> sa v diabetológii najčastejšie používa v súvislosti s kontinuálnym monitorovaním glukózy, kde vyjadruje percento času s glykémiou v stanovenom rozmedzí, typicky za dva až dvanásť týždňov. Analogicky sa 24-hodinové ambulantné monitorovanie krvného tlaku týka jediného dňa.</p>

<p>V tejto analýze vychádzal čas v cieľovom rozmedzí z <strong>opakovaných klinických meraní počas 12 mesiacov</strong>. Nešlo o kontinuálny záznam. Ukazovateľ preto zachytáva stabilitu <em>medzi návštevami</em> v priebehu roka, nie skutočný čas strávený v cieľovom rozmedzí v každom dni. Autori tento rozdiel sami zdôrazňujú a uvádzajú, že krátkodobé metriky naopak nezachytávajú variabilitu za hranicami krátkeho monitorovacieho obdobia. Obe rodiny ukazovateľov teda merajú niečo iné a nie sú zameniteľné.</p>

<p>Pri STK to znamená aj to, že klinické merania nemusia zachytiť nočnú hypertenziu, ranný vzostup tlaku, maskovanú hypertenziu ani domáce hodnoty.</p>

<h2>Význam pre nefrologickú prax</h2>

<p>Hlavné posolstvo je metodické skôr než terapeutické: renálne riziko pravdepodobne nesúvisí iba s poslednou nameranou hodnotou, ale aj s dlhodobou stabilitou oboch parametrov. Opakované obdobia hyperglykémie, zvýšeného tlaku alebo výraznej variability môžu byť silnejším prognostickým signálom než izolovaná hodnota v deň ambulantnej kontroly.</p>

<p>Čas v cieľovom rozmedzí však nemožno vnímať ako samostatný terapeutický cieľ bez ohľadu na klinický kontext. Príliš intenzívna liečba môže viesť k hypoglykémii, ortostatickej hypotenzii, akútnemu poškodeniu obličiek alebo zhoršeniu kvality života. To platí najmä u starších pacientov, pri pokročilej chronickej chorobe obličiek, autonómnej dysfunkcii a polymorbidite.</p>

<p>Pri každej kontrole je preto vhodné hodnotiť:</p>

<ol>
  <li>trend HbA1c za posledných 6 až 12 mesiacov, nie iba poslednú hodnotu,</li>
  <li>opakované ambulantné alebo domáce merania krvného tlaku,</li>
  <li>albuminúriu a jej vývoj,</li>
  <li>eGFR a rýchlosť jej poklesu,</li>
  <li>hypoglykémie a symptomatické hypotenzie,</li>
  <li>adherenciu a toleranciu liečby,</li>
  <li>riziko akútneho poškodenia obličiek,</li>
  <li>vek, krehkosť, komorbidity a preferencie pacienta.</li>
</ol>

<p>U pacientov s diabetom 2. typu a chronickou chorobou obličiek zostávajú základom nefroprotekcie intervencie s preukázaným klinickým prínosom — najmä inhibícia systému renín-angiotenzín pri albuminúrii, inhibítor SGLT2 pri vhodnej funkcii obličiek a podľa indikácie finerenón. Metabolická a tlaková kontrola má byť súčasťou tejto komplexnej liečby, nie jej náhradou ani izolovaným cieľom.</p>

<h2>Čo analýza preukázala a čo nie</h2>

<p>Analýza preukázala:</p>

<ul>
  <li>dlhší čas HbA1c aj STK v cieľovom rozmedzí počas prvého roka bol spojený s nižším rizikom kombinovaného renálneho výsledku;</li>
  <li>najsilnejšia asociácia sa týkala súbežného zotrvania oboch parametrov nad 80 % času;</li>
  <li>kombinovaný ukazovateľ súvisel aj s nižšou celkovou mortalitou a nižším rizikom albuminúrie;</li>
  <li>výsledky boli podobné v podskupine s chronickou chorobou obličiek na začiatku.</li>
</ul>

<p>Analýza nepreukázala:</p>

<ul>
  <li>že dlhší čas v cieľovom rozmedzí renálne riziko <em>spôsobuje</em> znižovať — TTR nebol randomizovaný;</li>
  <li>synergiu v štatistickom ani biologickom zmysle — chýba formálna analýza interakcie;</li>
  <li>prínos pre tvrdé renálne výsledky posudzované samostatne — makroalbuminúria ani zlyhanie obličiek významnú asociáciu nevykázali;</li>
  <li>že ciele HbA1c pod 6,0 % alebo STK pod 120 mmHg sú vhodné pre bežnú prax — pôvodné vetvy ACCORD to nepodporujú;</li>
  <li>prenositeľnosť na populácie mimo vysokorizikovej kohorty ACCORD.</li>
</ul>

<h2>Záver</h2>

<p>V post hoc analýze štúdie ACCORD u 6542 pacientov s diabetom 2. typu a hypertenziou bol dlhší čas HbA1c aj systolického tlaku v cieľovom rozmedzí spojený s nižším rizikom kombinovaného renálneho výsledku. Súbežné zotrvanie oboch parametrov nad 80 % času počas prvého roka znamenalo o 29 % nižšie riziko (pomer hazardu 0,71; 95 % interval spoľahlivosti 0,61 – 0,83) v porovnaní s pacientmi, u ktorých boli obe hodnoty v cieli najviac 80 % času.</p>

<p>Výsledky podporujú sledovanie dlhodobých trendov a stability liečby namiesto reagovania na jedinú poslednú hodnotu. Ide však o observačnú post hoc analýzu staršej vysokorizikovej populácie s liečebnými cieľmi, ktoré samotná ACCORD v pôvodných vetvách nepotvrdila ako prospešné. Zistenia môžu byť ovplyvnené reziduálnym skreslením a čas v cieľovom rozmedzí môže sčasti odrážať celkový zdravotný stav pacienta, nie iba kvalitu liečby.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=variabilita-tlaku-lezie-bielej-hmoty-sprint-accord">Variabilita systolického tlaku medzi návštevami a rýchlejšia progresia lézií bielej hmoty: čo z toho plynie pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=kontinualne-monitorovanie-glukozy-diabetes-2-typu-bez-inzulinu">Kontinuálne monitorovanie glukózy môže pomôcť aj pacientom s diabetom 2. typu bez inzulínu</a></li>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu: menej improvizácie, viac presného merania a praktických rozhodnutí</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Meng X, Wang Y, Zhang X, Wang S, Tan Z, Wang K, Zhao X, Li M, Wang T, Zhao Z, Lu J, Xu M, Zheng J, Wang W, Ning G, Bi Y, Xu Y. Time in Target Range for Hemoglobin A1c and Systolic Blood Pressure: Association With Adverse Kidney Events. American Journal of Kidney Diseases. 2026. doi: 10.1053/j.ajkd.2026.05.009. PMID 42468834. <a href="https://pubmed.ncbi.nlm.nih.gov/42468834/" target="_blank" rel="noopener noreferrer">PubMed</a>. Hlavný spracovaný zdroj. Prvým autorom je podľa záznamov PubMed aj Crossref Xi Meng; Guang Ning je pätnástym a zároveň korešpondujúcim autorom.</em></small></li>
  <li><small><em>Action to Control Cardiovascular Risk in Diabetes Study Group; Gerstein HC, Miller ME, Byington RP, Goff DC Jr, Bigger JT, a spol. Effects of intensive glucose lowering in type 2 diabetes. The New England Journal of Medicine. 2008;358(24):2545–2559. doi: 10.1056/NEJMoa0802743. PMID 18539917. <a href="https://pubmed.ncbi.nlm.nih.gov/18539917/" target="_blank" rel="noopener noreferrer">PubMed</a>. Glykemická vetva ACCORD.</em></small></li>
  <li><small><em>ACCORD Study Group; Cushman WC, Evans GW, Byington RP, Goff DC Jr, Grimm RH Jr, a spol. Effects of intensive blood-pressure control in type 2 diabetes mellitus. The New England Journal of Medicine. 2010;362(17):1575–1585. doi: 10.1056/NEJMoa1001286. PMID 20228401. ClinicalTrials.gov NCT00000620. <a href="https://pubmed.ncbi.nlm.nih.gov/20228401/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4123215/" target="_blank" rel="noopener noreferrer">plný text v PMC</a>. Tlaková vetva ACCORD.</em></small></li>
  <li><small><em>Buckley LF, Baker WL, Van Tassell BW, Cohen JB, Alkhezi O, Bress AP, Dixon DL. Systolic Blood Pressure Time in Target Range and Major Adverse Kidney and Cardiovascular Events. Hypertension. 2023;80(2):305–313. doi: 10.1161/HYPERTENSIONAHA.122.20141. <a href="https://doi.org/10.1161/HYPERTENSIONAHA.122.20141" target="_blank" rel="noopener noreferrer">DOI</a>. Skoršia práca o čase v cieľovom rozmedzí systolického tlaku a renálnych výsledkoch.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. PMID 38490803. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Melville NA. Combined A1c, BP Time in Range Predicts Kidney Outcomes. Medscape Medical News, 8. septembra 2026. <a href="https://www.medscape.com/viewarticle/combined-a1c-bp-time-range-predicts-kidney-outcomes-2026a1000x89" target="_blank" rel="noopener noreferrer">Medscape</a>. Zdroj údajov o sekundárnych výsledkoch a o podskupinových analýzach.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cas-v-cielovom-rozmedzi-hba1c-tlak-renalne-vysledky-accord_article',
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
