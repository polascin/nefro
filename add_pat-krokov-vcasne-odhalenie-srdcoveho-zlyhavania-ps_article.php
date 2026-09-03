<?php
/**
 * add_pat-krokov-vcasne-odhalenie-srdcoveho-zlyhavania-ps_article.php
 * Odborný článok: päťkrokový diagnostický rámec včasného záchytu srdcového
 * zlyhávania v primárnej starostlivosti (spracovanie Medscape).
 *
 * Pôvodný autor spracovaného zdroja je uvedený v source_authors.php.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_pat-krokov-vcasne-odhalenie-srdcoveho-zlyhavania-ps_article.php"
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
    'title'        => 'Päť krokov k včasnému odhaleniu srdcového zlyhávania v primárnej starostlivosti: praktický diagnostický rámec',
    'slug'         => 'pat-krokov-vcasne-odhalenie-srdcoveho-zlyhavania-ps',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Päťkrokový rámec včasného záchytu srdcového zlyhávania v primárnej starostlivosti: anamnéza, natriuretické peptidy s výhradou pri CKD, rizikové skupiny, včasná echokardiografia a komorbidity.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Srdcové zlyhávanie sa často rozvíja postupne a v primárnej starostlivosti ostáva dlho nediagnostikované — najmä fenotyp so zachovanou ejekčnou frakciou. Tento článok je slovenské spracovanie praktického päťkrokového rámca z Medscape pre včasný záchyt. Ide o diagnostickú triáž pri podozrení na srdcové zlyhávanie, nie o dôkaz príčiny ťažkostí. Prahové hodnoty natriuretických peptidov sú overené proti otvoreným zdrojom; pri chronickej chorobe obličiek žiadny univerzálny prah nestačí.</em></p>

<p>Srdcové zlyhávanie (HF, z angl. <em>heart failure</em>) často vzniká pozvoľna. Mnohí pacienti si ho uvedomia až vtedy, keď je funkcia srdca už výrazne zhoršená alebo keď sa opakujú epizódy dekompenzácie. Včasná diagnóza pritom umožňuje skôr začať liečbu podľa odporúčaní, zlepšiť kvalitu života a znížiť riziko hospitalizácií.</p>

<p>Nasledujúcich päť krokov pomáha lekárovi v primárnej starostlivosti — a rovnako nefrológovi pri pacientovi s chronickou chorobou obličiek (CKD) — spoznať včasné HF a nasmerovať ďalšie vyšetrenia. Samotný laboratórny výsledok ani jeden príznak diagnózu nenesú.</p>

<h2>Krok 1: Cielená anamnéza, nielen „únava z veku“</h2>

<p>Diagnostika začína dôkladnou anamnézou. Starší ľudia často pripisujú dýchavicu, únavu alebo postupný pokles výkonnosti veku a tieto ťažkosti sami nespomenú. Treba sa teda <strong>aktívne pýtať</strong> na varovné príznaky:</p>

<ul>
  <li>námahová dýchavica,</li>
  <li>nočná dýchavica a paroxyzmálna nočná dyspnoe,</li>
  <li>ortopnoe (dýchavica v ľahu, úľava v sede),</li>
  <li>rýchla unaviteľnosť a znížená záťažová tolerancia,</li>
  <li>opuchy členkov,</li>
  <li>nevysvetlený nárast hmotnosti,</li>
  <li>opakované respiračné infekcie alebo obmedzenie dennej pohybovej aktivity.</li>
</ul>

<p>Pri srdcovom zlyhávaní so zachovanou ejekčnou frakciou (HFpEF) bývajú ťažkosti postupné a dlho nešpecifické. Usmernenia Európskej kardiologickej spoločnosti (ESC) odporúčajú hodnotiť typické príznaky spolu s klinickým vyšetrením a biomarkermi — nie izolovane.</p>

<h2>Krok 2: BNP alebo NT-proBNP — na vylúčenie, nie ako jediný dôkaz</h2>

<p>Natriuretické peptidy patria k najužitočnejším laboratórnym nástrojom pri podozrení na chronické HF. ESC odporúča stanoviť B-typ natriuretický peptid (BNP) alebo N-terminálny fragment prohormónu B-typu natriuretického peptidu (NT-proBNP), len čo je chronické HF v hre.</p>

<p><strong>Veľmi nízke hodnoty robia klinicky významné HF nepravdepodobným</strong> a šetria zbytočné odoslania. Zvýšené koncentrácie odôvodňujú promptnú ďalšiu diagnostiku, predovšetkým echokardiografiu. Výsledok treba čítať v kontexte veku, obličiek, srdcového rytmu, obezity a klinického obrazu — nie ako kauzálny dôkaz.</p>

<p>Cielená aktualizácia ESC z roku 2023 (McDonagh a spol.) zmenila najmä liečbu (inhibítory sodíkovo-glukózového kotransportéra 2, SGLT2, pri HFpEF a pri HF s mierne zníženou ejekčnou frakciou) a <strong>diagnostické prahy natriuretických peptidov nemenila</strong>. V auguste 2026 ESC vydala nové usmernenie pre manažment HF (Køber, Adamo a spol.), ktoré 2021 dokument nahrádza. Tabuľkové prahy nižšie sú tie, ktoré sú v otvorených zdrojoch overiteľné z ESC 2021 a z konsenzu Heart Failure Association (HFA) ESC 2023; plný diagnostický algoritmus dokumentu 2026 tu necitujeme po jednotlivých číslach, pretože ako otvorený plný text nebol pri príprave článku k dispozícii.</p>

<div class="table-responsive" role="region" aria-label="Prahové hodnoty natriuretických peptidov podľa ESC 2021" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Kontext</th>
      <th scope="col">BNP</th>
      <th scope="col">NT-proBNP</th>
      <th scope="col">Ako čítať</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Chronické / ambulantné podozrenie (ESC 2021)</th>
      <td>&lt;35 pg/ml robí HF nepravdepodobným</td>
      <td>&lt;125 pg/ml robí HF nepravdepodobným</td>
      <td>Nízky prah na <strong>vylúčenie</strong>; hodnoty nad prahom sú dôvod na echokardiografiu, nie na automatickú diagnózu</td>
    </tr>
    <tr>
      <th scope="row">Akútne / dekompenzácia (ESC 2021)</th>
      <td>&lt;100 pg/ml</td>
      <td>&lt;300 pg/ml</td>
      <td>Ak je dostupný aj midregionálny pro-atriálny natriuretický peptid (MR-proANP), prah na vylúčenie je &lt;120 pg/ml. Akútne prahy sú vyššie ako ambulantné — nesmú sa zamieňať</td>
    </tr>
    <tr>
      <th scope="row">HFpEF: sínusový rytmus vs. fibrilácia predsiení (ESC 2021)</th>
      <td>&gt;35 pg/ml (sínus) alebo &gt;105 pg/ml (AF)</td>
      <td>&gt;125 pg/ml (sínus) alebo &gt;365 pg/ml (AF)</td>
      <td>Doplnkové kritérium pri podozrení na HFpEF, nie náhrada jednoduchého vylučovacieho prahu 35 / 125 pg/ml. Až približne 20 % pacientov s invazívne potvrdeným HFpEF má hodnoty pod diagnostickými prahmi, najmä pri obezite</td>
    </tr>
  </tbody>
</table>
</div>

<p>Jednotka pg/ml je pri týchto peptidoch totožná s ng/l. Britské usmernenie NICE pre chronické HF používa vyšší odosielací prah NT-proBNP (≥400 ng/l) — to nie je prah ESC a na Slovensku sa ním neriadime ako náhradou ESC 2021.</p>

<p>Konsenzus HFA ESC z roku 2023 (Bayes-Genis a spol.), na ktorý odkazuje aj spracovaný článok Medscape, navrhuje v ambulancii <strong>vekovo prispôsobené prahy na „rule-in“</strong> NT-proBNP: ≥125 pg/ml pred 50. rokom, ≥250 pg/ml vo veku 50–75 rokov a ≥500 pg/ml nad 75 rokov. Tieto čísla <strong>neznižujú</strong> klasický vylučovací prah 125 pg/ml u mladších; pri starších zvyšujú špecificitu za cenu citlivosti. Pri obezite HFA navrhuje <strong>znížiť</strong> prah NT-proBNP o približne 25 % pri indexe telesnej hmotnosti (BMI) 30,0–34,9 kg/m<sup>2</sup>, o 30 % pri 35,0–39,9 kg/m<sup>2</sup> a o 40 % pri BMI ≥40 kg/m<sup>2</sup>. Presné číselné korekcie pre renálnu insuficienciu a fibriláciu predsiení v tomto konsenze tu neuvádzame, ak nie sú v otvorenom texte jednoznačne tabulované — HFA ich však explicitne žiada zohľadniť.</p>

<h3>Prečo pri CKD nestačí jeden univerzálny prah</h3>

<p>Pre nefrologickú ambulanciu je to kľúčová výhrada. CKD natriuretické peptidy <strong>zvyšuje</strong>: znížený renálny klírens, retencia sodíka a vody a časté sprievodné faktory (hypertenzia, diabetes, objemové preťaženie). Všeobecné ambulantné prahy 35 / 125 pg/ml <strong>nie sú CKD-špecifické</strong>. Konferencia KDIGO o chorobe obličiek a srdcovom zlyhávaní preto žiada prahy prispôsobené CKD. Prakticky:</p>

<ul>
  <li>skutočne nízka hodnota stále pomáha HF <strong>vylúčiť</strong> — aj pri CKD;</li>
  <li>zvýšená hodnota diagnózu <strong>nepotvrdzuje</strong>: môže odrážať znížený klírens, objem, fibriláciu predsiení alebo vek;</li>
  <li>pri G4–G5 a u dialyzovaných je špecificita slabá; užitočnejšie sú dôkazy zvýšených plniacich tlakov (echokardiografia, v vybraných situáciách invazívna hemodynamika) než jeden laboratórny prah;</li>
  <li>NT-proBNP závisí od renálneho klírensu viac ako BNP; niektoré konsenzy pre primárnu starostlivosť preto pri poruche obličiek preferujú BNP, ale ESC 2021 používa oba peptidy s rovnakou logikou vylúčenia;</li>
  <li>eurázijsko-turecký konsenzus pre primárnu starostlivosť (PMC11881534) meranie natriuretických peptidov u dialyzovaných <strong>neodporúča</strong> — to nie je zákaz ESC, ale výstižne upozorňuje, že pri dialýze je interpretácia veľmi obmedzená a kolíše s objemom.</li>
</ul>

<p>Sekundárna analýza TOPCAT (Myhre a spol., <em>JAMA Cardiology</em> 2018) u HFpEF ukázala, že koncentrácie peptidov sú vyššie pri nižšej odhadovanej glomerulárnej filtrácii (eGFR) a pri fibrilácii predsiení a nižšie pri vyššom BMI. Išlo o <strong>prognostický</strong> vzťah u už diagnostikovaného HFpEF, nie o odvodenie diagnostických prahov. Záver je však pre prax zhodný: jeden absolútny prah podhodnotí niektoré podskupiny (obezita) a nadhodnotí iné (CKD, fibrilácia predsiení).</p>

<div class="table-responsive" role="region" aria-label="Faktory, ktoré posúvajú natriuretické peptidy" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Faktor</th>
      <th scope="col">Typický vplyv na BNP / NT-proBNP</th>
      <th scope="col">Praktický dôsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">CKD, klesajúca eGFR</th>
      <td>Zvýšenie (znížený klírens, objem, komorbidity)</td>
      <td>Nespoliehať sa na univerzálny prah; nízka hodnota vylučuje lepšie, ako vysoká potvrdzuje</td>
    </tr>
    <tr>
      <th scope="row">Fibrilácia predsiení</th>
      <td>Zvýšenie</td>
      <td>Viac falošne pozitívnych odoslaní; pri HFpEF ESC uvádza vyššie doplnkové prahy</td>
    </tr>
    <tr>
      <th scope="row">Vek</th>
      <td>Zvýšenie</td>
      <td>HFA 2023: vekovo vyššie prahy na rule-in, nie na vylúčenie u mladších</td>
    </tr>
    <tr>
      <th scope="row">Obezita</th>
      <td>Zníženie („deficit BNP“)</td>
      <td>Klasický prah 125 pg/ml môže HF prehliadnuť; zvážiť zníženie prahu podľa HFA a nenechať sa odradiť „normálnym“ výsledkom pri typickej klinike</td>
    </tr>
    <tr>
      <th scope="row">HFpEF</th>
      <td>Často nižšie hodnoty než pri zníženej ejekčnej frakcii</td>
      <td>Normálny peptid HFpEF nevylučuje spoľahlivo, najmä pri obezite</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Krok 3: Nesledujte každého rovnako — rizikové skupiny</h2>

<p>Nie každý pacient potrebuje cielené pátranie po HF. Zvýšenú pozornosť si zaslúžia ľudia s:</p>

<ul>
  <li>artériovou hypertenziou,</li>
  <li>ischemickou chorobou srdca,</li>
  <li>diabetes mellitus,</li>
  <li>CKD,</li>
  <li>obezitou,</li>
  <li>fibriláciou predsiení,</li>
  <li>prekonaným infarktom myokardu,</li>
  <li>potenciálne kardiotoxickou onkologickou liečbou.</li>
</ul>

<p>V týchto skupinách natriuretické peptidy pomáhajú odhadnúť, koho poslať na echokardiografiu skôr. CKD tu nie je „len komorbidita“: je samostatným rizikovým faktorom HF, s najsilnejšou väzbou práve na HFpEF.</p>

<h2>Krok 4: Echokardiografiu neodkladajte</h2>

<p>Transthorakálna echokardiografia je <strong>kľúčové vyšetrenie</strong> na potvrdenie štrukturálnej alebo funkčnej abnormality srdca — pumpovacia funkcia, kinetika stien, chlopne, diastolická funkcia — a na odlíšenie HF so zníženou, mierne zníženou a zachovanou ejekčnou frakciou. V jazyku usmernení to nie je univerzálny „zlatý štandard“ v zmysle jediného dôkazu; diagnóza HF ostáva klinickým syndrómom, ktorý echo <strong>podporuje a spresňuje</strong>.</p>

<p>ESC odporúča ponúknuť echokardiografiu <strong>čo najskôr</strong> pacientom s typickými príznakmi a zvýšeným BNP alebo NT-proBNP. Cieľom je stanoviť diagnózu ešte pred prvou dekompenzáciou. Pri pokročilej CKD a u hemodialyzovaných treba zobrazenie podľa možnosti plánovať na deň bez dialýzy; ľavokomorová hypertrofia je pri pokročilej CKD častá a sama osebe HF nediagnostikuje.</p>

<h2>Krok 5: Vždy myslite na komorbidity</h2>

<p>HF zriedka stojí osamote. Väčšina pacientov má viacero chronických ochorení, ktoré menia diagnostiku aj liečbu:</p>

<ul>
  <li>CKD mení koncentrácie natriuretických peptidov,</li>
  <li>diabetes výrazne zvyšuje riziko HF,</li>
  <li>fibrilácia predsiení sťažuje výklad dýchavice a zníženej záťažovej tolerancie,</li>
  <li>obezita skresľuje biomarkery aj fyzikálny nález.</li>
</ul>

<p>ESC zdôrazňuje, že každé HF treba hodnotiť v kontexte viacerých súčasných ochorení. Pre nefrológa to znamená súčasne merať eGFR aj pomer albumín/kreatinín v moči (UACR), nielen kreatinín, a nespájať opuchy automaticky len s retenciou pri CKD.</p>

<h2>Čo z toho vyplýva v ambulancii</h2>

<ol>
  <li>Pýtajte sa na námahovú a nočnú dýchavicu, ortopnoe, opuchy a nevysvetlený nárast hmotnosti — nenechajte ich splynúť s vekom ani s „obvyklou“ CKD.</li>
  <li>Pri podozrení stanovte BNP alebo NT-proBNP. Nízka hodnota HF spochybňuje; vysoká je dôvod na echo, nie na razantný záver.</li>
  <li>Pri CKD, fibrilácii predsiení, veku a obezite interpretujte peptid opatrne. Pri G4–G5 a dialýze nečakajte, že jeden prah rozhodne.</li>
  <li>Echokardiografiu pri typickej klinike a zvýšenom peptide neodkladajte.</li>
  <li>Hľadajte HF v rizikových skupinách a vždy v kontexte komorbidít — ide o triáž, nie o dôkaz príčiny.</li>
</ol>

<h2>Limitácie</h2>

<p>Primárnym spracovaným zdrojom je praktický článok Medscape, nie nové usmernenie. Čísla prahov sú z ESC 2021 a z konsenzu HFA 2023, overené v otvorených sekundárnych zdrojoch a v PMC. Nové ESC usmernenie z 28. augusta 2026 dokument z roku 2021 nahrádza; jeho plné diagnostické tabuľky tu nie sú citované ako overený primárny text. Analýza TOPCAT opisuje prognózu, nie diagnostické prahy. Observačné asociácie (CKD a vznik HFpEF) nedokazujú kauzalitu. Tento rámec nenahrádza individuálne klinické rozhodnutie ani lokálne indikačné obmedzenia echokardiografie.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026">Srdcové zlyhávanie a CKD: závery KDIGO konferencie</a> — prečo všeobecné prahy natriuretických peptidov nie sú CKD-špecifické.</li>
  <li><a href="article.php?slug=ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register">Chronická choroba obličiek a vznik srdcového zlyhávania: najsilnejšia väzba smeruje k HFpEF</a>.</li>
  <li><a href="article.php?slug=pohybova-aktivita-fibrilacia-predsieni-cmp-mortalita">Pohybová aktivita pri fibrilácii predsiení: nižšie riziko cievnej mozgovej príhody a úmrtia</a>.</li>
  <li><a href="article.php?slug=ckm-syndrom-stadia-skrining-liecba-usmernenie-2026">CKM syndróm: štádiá 0 až 4, skríning a liečba</a>.</li>
  <li><a href="article.php?slug=oblicka-v-centre-ckm-syndromu-kdigo">Oblička v centre kardiovaskulárno-obličkovo-metabolického syndrómu</a>.</li>
  <li><a href="article.php?slug=ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia">CKM syndróm ako „jeden rámec“ pre nefrologickú prax</a>.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Michael van den Heuvel. <em>Five Steps to Earlier Heart Failure Detection.</em> Medscape, 2026. <a href="https://www.medscape.com/viewarticle/five-steps-earlier-heart-failure-detection-2026a1000ryx" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<h2>Zdroje</h2>

<ol>
  <li><strong>Michael van den Heuvel.</strong> <em>Five Steps to Earlier Heart Failure Detection.</em> Medscape, 2026. Autor je verejne uvedený na stránke článku. <a href="https://www.medscape.com/viewarticle/five-steps-earlier-heart-failure-detection-2026a1000ryx" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>McDonagh TA, Metra M, Adamo M, et al.; ESC Scientific Document Group.</strong> <em>2021 ESC Guidelines for the diagnosis and treatment of acute and chronic heart failure.</em> Eur Heart J. 2021;42(36):3599–3726. doi: 10.1093/eurheartj/ehab368. PMID 34447992. <a href="https://doi.org/10.1093/eurheartj/ehab368" target="_blank" rel="noopener noreferrer">DOI (EHJ)</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/34447992/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>McDonagh TA, Metra M, Adamo M, et al.; ESC Scientific Document Group.</strong> <em>2023 Focused Update of the 2021 ESC Guidelines for the diagnosis and treatment of acute and chronic heart failure.</em> Eur Heart J. 2023;44(37):3627–3639. doi: 10.1093/eurheartj/ehad195. PMID 37622666. Cielená aktualizácia liečby; diagnostické prahy natriuretických peptidov nemenila. <a href="https://doi.org/10.1093/eurheartj/ehad195" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37622666/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Køber L, Adamo M, Ruwald AC, Tomasoni D, et al.</strong> <em>2026 ESC Guidelines for the management of heart failure.</em> Eur Heart J. 2026. doi: 10.1093/eurheartj/ehag100. PMID 42661420. Nahrádza dokument z roku 2021; publikované 28. augusta 2026. <a href="https://doi.org/10.1093/eurheartj/ehag100" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42661420/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.escardio.org/Guidelines/Clinical-Practice-Guidelines/Acute-and-Chronic-Heart-Failure" target="_blank" rel="noopener noreferrer">stránka ESC</a>.</li>
  <li><strong>Bayes-Genis A, Docherty KF, Petrie MC, Januzzi JL, Mueller C, Anderson L, et al.</strong> <em>Practical algorithms for early diagnosis of heart failure and heart stress using NT-proBNP: a clinical consensus statement from the Heart Failure Association of the ESC.</em> Eur J Heart Fail. 2023;25(11):1891–1898. doi: 10.1002/ejhf.3036. PMID 37712339. Vekovo prispôsobené prahy a úpravy pri obezite. <a href="https://doi.org/10.1002/ejhf.3036" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37712339/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Çelik A, Öztürk GZ, Çavuşoğlu Y, et al.</strong> <em>Guideline for the Use of Natriuretic Peptides in the Early Diagnosis and Management of Heart Failure in Primary Care (Joint Consensus Report by the Eurasian Society of Heart Failure and the Turkish Association of Family Medicine).</em> Balkan Med J. 2025;42(2):94–107. doi: 10.4274/balkanmedj.galenos.2025.2024-12-110. PMID 40033605. PMC11881534. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC11881534/" target="_blank" rel="noopener noreferrer">PMC (voľne dostupný text)</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40033605/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Myhre PL, Vaduganathan M, Claggett BL, et al.</strong> <em>Association of Natriuretic Peptides With Cardiovascular Prognosis in Heart Failure With Preserved Ejection Fraction: Secondary Analysis of the TOPCAT Randomized Clinical Trial.</em> JAMA Cardiol. 2018;3(10):1000–1005. doi: 10.1001/jamacardio.2018.2568. PMID 30140899. JAMA Network ID 2697771. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6233827/" target="_blank" rel="noopener noreferrer">PMC (voľne dostupný text)</a>; <a href="https://doi.org/10.1001/jamacardio.2018.2568" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/30140899/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Taylor CJ, Ordóñez-Mena JM, Lay-Flurrie SL, et al.</strong> <em>Age-adjusted natriuretic peptide thresholds for a diagnosis of heart failure in the community: diagnostic accuracy study.</em> ESC Heart Fail. 2025. Validácia vekových prahov HFA 2023. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC12450762/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Damman K, Ter Maaten JM, Mayne KJ, et al.</strong> <em>2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease, in collaboration with the European Renal Association (ERA).</em> Eur Heart J. 2026. doi: 10.1093/eurheartj/ehag098. PMID 42661426. Súbežné usmernenie ESC/ERA z 28. augusta 2026; nie je spracovaným zdrojom tohto článku. <a href="https://doi.org/10.1093/eurheartj/ehag098" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42661426/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Päť krokov (cielená anamnéza vrátane námahovej a nočnej dýchavice, ortopnoe, únavy, opuchov členkov, nevysvetleného nárastu hmotnosti a opakovaných respiračných infekcií; natriuretické peptidy; rizikové skupiny; včasná echokardiografia; komorbidity) je spracovaním verejne dostupného textu Medscape (autor Michael van den Heuvel). Autori ESC task force nie sú autormi spracovaného zdroja a vo widgete „Zúčastnení autori“ sa neuvádzajú. Ambulantné prahy BNP &lt;35 pg/ml a NT-proBNP &lt;125 pg/ml a akútne prahy BNP &lt;100 pg/ml a NT-proBNP &lt;300 pg/ml sú z ESC 2021 a zhodne ich cituje PMC11881534. Doplnkové prahy pri HFpEF podľa rytmu (125 / 365 a 35 / 105 pg/ml) sú z ESC 2021. Vekové prahy 125 / 250 / 500 pg/ml a percentuálne zníženie prahu pri obezite sú z konsenzu HFA 2023 (PMID 37712339) a z otvorenej validačnej práce Taylorovej a spol. Analýza TOPCAT (PMID 30140899) je prognostická, nie diagnostická. Plný text ESC 2026 (PMID 42661420) nebol pri príprave čítaný ako otvorený dokument — preto sa z neho neodvádzajú nové prahy.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_pat-krokov-vcasne-odhalenie-srdcoveho-zlyhavania-ps_article',
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
