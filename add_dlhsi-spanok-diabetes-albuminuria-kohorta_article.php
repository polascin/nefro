<?php
// Prospektivna kohorta, plnotextova kontrola. Aviza ani newsletter nie su povolene.
if (PHP_SAPI !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';
$articles = [[
    'title' => 'Dĺžka spánku a albuminúria pri diabete 2. typu: čo ukázala japonská kohorta',
    'slug' => 'dlhsi-spanok-diabetes-albuminuria-kohorta',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Japonská kohorta našla súvislosť dlhšieho spánku s albuminúriou. Význam výsledku obmedzuje spôsob analýzy aj jednorazové ročné meranie albumínu v moči.',
    'content' => <<<'HTML'
<figure><a href="img/dlhsi-spanok-diabetes-albuminuria-kohorta.webp" target="_blank" rel="noopener noreferrer"><img src="img/dlhsi-spanok-diabetes-albuminuria-kohorta.webp" alt="Poloschematické obličky v pokojnej nočnej scéne s posteľou a mesiacom" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Symbolická ilustrácia súvislosti spánku a zdravia obličiek. Nezobrazuje konkrétneho pacienta ani mechanizmus poškodenia.</figcaption></figure>
<p><strong>V japonskej kohorte pacientov s diabetom 2. typu sa dlhší udávaný spánok spájal s častejším vznikom alebo zhoršením albuminúrie. Výsledok však závisel od spôsobu analýzy: pri rozdelení spánku do kategórií bola asociácia štatisticky významná, pri jeho hodnotení ako spojitej premennej nie. Štúdia nepreukazuje, že dlhý spánok poškodzuje obličky, ani že jeho skrátenie znižuje riziko.</strong> [1]</p>

<h2>Čo štúdia skutočne sledovala</h2>
<p>Autori analyzovali 678 ambulantných pacientov z troch japonských pracovísk. Účastníci boli zaradení od júna 2013 do januára 2014. Do tejto analýzy vstúpili pacienti bez výrazne zvýšenej albuminúrie na začiatku, s dostupným vstupným a aspoň jedným následným vyšetrením albumínu v moči. Priemerné sledovanie trvalo 6,0 ± 2,7 roka. [1]</p>

<p>Spánok nebol meraný aktigrafiou ani polysomnografiou. Účastníci udávali priemernú dĺžku nočného spánku za predchádzajúci mesiac pri vstupe a po dvoch a piatich rokoch. Autori použili priemer dostupných údajov získaných do udalosti alebo do konca sledovania. Opakované zisťovanie je výhodou oproti jedinej vstupnej otázke, stále však ide o subjektívny údaj, ktorý nezachytáva všetky poruchy spánku. [1]</p>

<p>Výsledkovým ukazovateľom bol prvý prechod do vyššej kategórie albuminúrie: vznik stredne alebo výrazne zvýšenej albuminúrie u pacienta s pôvodne nízkou albuminúriou, prípadne prechod zo stredne na výrazne zvýšenú albuminúriu. Nebol to zložený ukazovateľ zlyhania obličiek, dialýzy alebo potvrdeného poklesu glomerulovej filtrácie. Označenie „diabetická nefropatia“ v názve pôvodnej práce preto treba čítať podľa tejto konkrétnej definície. [1]</p>

<h2>Výsledky a ich štatistická hranica</h2>
<p>Výsledkovú udalosť zaznamenali u 215 pacientov, teda u 31,7 % kohorty. Pri analýze kategórií dĺžky spánku bol jeden pacient vyradený, pretože pred udalosťou nemal dostupný údaj o spánku. Nasledujúca tabuľka preto zahŕňa 677 osôb a 214 udalostí. Referenčnou skupinou boli pacienti, ktorí udávali spánok kratší než šesť hodín. [1]</p>

<div class="table-responsive" role="region" aria-label="Dĺžka spánku a prvý prechod do vyššej kategórie albuminúrie" tabindex="0"><table><thead><tr><th scope="col">Priemerný nočný spánok</th><th scope="col">Udalosti / účastníci</th><th scope="col">Upravený pomer hazardov (95 % interval spoľahlivosti)</th></tr></thead><tbody>
<tr><th scope="row">Menej než 6 hodín</th><td>49 / 174</td><td>1,00, referencia</td></tr>
<tr><th scope="row">Od 6 do menej než 7 hodín</th><td>76 / 273</td><td>1,08 (0,74 až 1,57)</td></tr>
<tr><th scope="row">Od 7 do menej než 8 hodín</th><td>63 / 170</td><td>1,56 (1,05 až 2,31)</td></tr>
<tr><th scope="row">Aspoň 8 hodín</th><td>26 / 60</td><td>1,92 (1,15 až 3,19)</td></tr>
</tbody></table></div>

<p>Hodnota p pre trend bola 0,003. Model zohľadňoval vek, pohlavie, vybrané faktory životného štýlu, trvanie diabetu, glykovaný hemoglobín, systolický tlak, laboratórne ukazovatele vrátane vstupnej albuminúrie a vybranú vstupnú liečbu. Pomer hazardov 1,92 neznamená, že takmer dvojnásobok pacientov nevyhnutne dostane chorobu obličiek. Opisuje relatívny hazard definovanej albuminurickej udalosti pri danom modeli. [1]</p>

<p><strong>V úvodnom viacpremennom modeli so spánkom ako spojitou premennou bol pomer hazardov na ďalšiu hodinu 1,13, s 95 % intervalom spoľahlivosti od 0,98 do 1,30 a p = 0,082.</strong> Následné kategorizovanie malo preskúmať možnú nelineárnu súvislosť. Autori zároveň uvádzajú, že početné kategóriové, podskupinové a citlivostné analýzy neboli formálne korigované na viacnásobné testovanie. Pozitívne výsledky preto treba považovať za podnet na ďalší výskum, nie za potvrdenie jedinej optimálnej dĺžky spánku. [1]</p>

<h2>Albuminúria vyžaduje potvrdenie</h2>
<p>Albumín v moči sa hodnotil z jednej náhodnej vzorky pri ročnej návšteve. Prechod do vyššej kategórie sa nemusel potvrdiť opakovanými odbermi v krátkom odstupe. To je zásadný rozdiel oproti klinickej diagnostike, pretože albuminúria biologicky kolíše a môže sa prechodne zvýšiť. Jednorazový nález tak môže nadhodnotiť počet nových prípadov alebo progresií. [1]</p>

<p>Odporúčania Americkej diabetologickej asociácie pre rok 2026 uvádzajú, že pred označením stredne alebo výrazne zvýšenej albuminúrie majú byť patologické aspoň dve z troch vzoriek pomeru albumínu ku kreatinínu v moči (UACR) odobratých počas troch až šiestich mesiacov. [2] Výsledkovú udalosť tejto kohorty preto nemožno automaticky stotožniť s potvrdenou progresiou chronickej choroby obličiek.</p>

<h2>Prečo dlhší spánok nemusí byť príčinou</h2>
<p>Pacienti s dlhším spánkom boli už pri vstupe starší a mali nižšiu odhadovanú glomerulovú filtráciu (eGFR). Aj po štatistickom zohľadnení vybraných premenných môže zostať vplyv komorbidít, krehkosti, porúch spánku alebo ďalších nemeraných faktorov. Dlhšie spanie môže byť následkom zhoršeného zdravia alebo jeho sprievodným znakom. Hypotézy o zápale či krehkosti autori diskutujú, štúdia však taký mechanizmus nepreukázala. [1]</p>

<p>Pri interpretácii treba zohľadniť aj liečbu. Na začiatku nikto neužíval inhibítor sodíkovo-glukózového kotransportéra 2 (SGLT2). Zmeny nefroprotektívnej liečby počas ďalších rokov neboli komplexne zachytené. Prenositeľnosť výsledkov na dnešnú populáciu liečenú modernými nefroprotektívnymi liekmi je preto neistá. Malé podskupiny a početné porovnania navyše neumožňujú vyvodiť spoľahlivý individuálny postup podľa veku alebo eGFR. [1]</p>

<p>Výsledky ďalších kohort nie sú úplne rovnaké. V analýze 24 081 účastníkov UK Biobank s diabetom 2. typu sa s diabetickou chorobou obličiek spájal krátky aj dlhý spánok v porovnaní so siedmimi hodinami. [3] Rozdielne populácie, referenčné kategórie a definície výsledku neumožňujú tieto odhady mechanicky spájať.</p>

<h2>Čo má význam v ambulancii</h2>
<p>Otázka na spánok môže doplniť anamnézu, ale nenahrádza UACR, eGFR ani hodnotenie celkového stavu. Z tejto práce nemožno odvodiť nový skríningový interval alebo cieľ skrátiť pacientovi spánok. Rovnako nemožno označiť spánok kratší než šesť hodín za ochranný len preto, že slúžil ako referenčná kategória.</p>

<p>Konsenzus American Academy of Sleep Medicine a Sleep Research Society pre zdravých dospelých vo veku od 18 do 60 rokov odporúča pravidelne aspoň sedem hodín spánku. [4] Potreba spánku je individuálna a uvedené vekové vymedzenie nemožno bez ďalšieho prenášať na každého staršieho či chorého pacienta. Japonská kohorta podporuje opatrnú interpretáciu dlhšieho spánku ako možného ukazovateľa zdravotnej záťaže, nie zásah do jeho trvania.
</p>
<hr><p><small><em>Text je určený zdravotníckym pracovníkom. Hlavná štúdia bola hodnotená podľa plného textu, doplňujúca britská kohorta podľa abstraktu. Samostatné doplnkové tabuľky japonskej práce neboli dostupné na kontrolu; závery, ktoré by vyžadovali ich nezávislé overenie, sa nepreberajú.</em></small></p>
<h2>Zdroje</h2><ol>
<li><small><em>Fuki Ikeda, Tomoya Mita, Yusuke Osonoi, Yuki Someya, Takeshi Osonoi, Miyoko Saito, Shiho Nakayama, Hidenori Ishida, Ryota Ishii, Masahiko Gosho, Hirotaka Watada. Longer sleep duration and the incidence and progression of diabetic nephropathy: a prospective cohort study. Journal of the Endocrine Society. 2026;10(11):bvag201. DOI: <a href="https://doi.org/10.1210/jendso/bvag201" target="_blank" rel="noopener noreferrer">10.1210/jendso/bvag201</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42852320/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.1210/jendso/bvag201" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>American Diabetes Association Professional Practice Committee for Diabetes. 11. Chronic Kidney Disease and Risk Management: Standards of Care in Diabetes-2026. Diabetes Care. 2026;49(Suppl 1):S246-S260. DOI: <a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">10.2337/dc26-S011</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41358881/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.2337/dc26-S011" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>Xiaoge Niu, Hongwei Liu, Yanxi Wang, Yanfang Lu, Xiaojing Jiao, Yafeng Ren, Lei Yan, Shaokai Zhang, Huixia Cao, Fengmin Shao. Sleep duration, mediating biomarkers, and risk of microvascular complications among individuals with type 2 diabetes: A prospective cohort study. Diabetes Research and Clinical Practice. 2025;221:112026. DOI: <a href="https://doi.org/10.1016/j.diabres.2025.112026" target="_blank" rel="noopener noreferrer">10.1016/j.diabres.2025.112026</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39929336/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.1016/j.diabres.2025.112026" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>Nathaniel F Watson, M Safwan Badr, Gregory Belenky, Donald L Bliwise, Orfeu M Buxton, Daniel Buysse, David F Dinges, James Gangwisch, Michael A Grandner, Clete Kushida, Raman K Malhotra, Jennifer L Martin, Sanjay R Patel, Stuart F Quan, Esra Tasali. Recommended Amount of Sleep for a Healthy Adult: A Joint Consensus Statement of the American Academy of Sleep Medicine and Sleep Research Society. Sleep. 2015;38(6):843-844. DOI: <a href="https://doi.org/10.5665/sleep.4716" target="_blank" rel="noopener noreferrer">10.5665/sleep.4716</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/26039963/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.5665/sleep.4716" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>Batya Swift Yasgur. Longer Sleep Linked to Diabetic Nephropathy Risk. Medscape Medical News, 20. november 2026. <a href="https://www.medscape.com/viewarticle/longer-sleep-duration-may-be-tied-higher-diabetic-2026a1001971" target="_blank" rel="noopener noreferrer">Východisková správa</a>.</em></small></li>
</ol>

HTML,
]];
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dlhsi_spanok_diabetes',
]);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL;
if (!empty($result['errors'])) {
    exit(1);
}
