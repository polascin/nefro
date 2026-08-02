<?php
/**
 * add_ckd-mozog-kognitivne-poruchy-cievne-poskodenie_article.php
 * Idempotentny UPSERT odborneho clanku o kognitivnych a cerebrovaskularnych
 * dosledkoch chronickej choroby obliciek.
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

// Data clanku

$articles = [];

$articles[] = [
    'title'        => 'Chronická choroba obličiek postihuje aj mozog: kognitívne poruchy, cievne poškodenie a klinické dôsledky',
    'slug'         => 'ckd-mozog-kognitivne-poruchy-cievne-poskodenie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'CKD sa spája s kognitívnou poruchou, cerebrálnou chorobou malých ciev a mozgovou príhodou. Klinicky rozhoduje cielené vyšetrenie, lieková bezpečnosť a ochrana perfúzie pri dialýze.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CKD) nie je izolovaným ochorením jedného orgánu. Spája sa s vyšším rizikom cievnej mozgovej príhody, poškodenia drobných mozgových ciev a kognitívnej poruchy. Tieto komplikácie môžu zhoršiť bezpečné užívanie liekov, adherenciu, samostatnosť aj schopnosť porozumieť zložitým rozhodnutiam o dialýze, konzervatívnej liečbe alebo transplantácii.</p>

<p>Vzťah obličiek a mozgu je multifaktoriálny. Zahŕňa spoločné cievne rizikové faktory, poškodenie mikrocirkulácie, zápal, uremické a metabolické prostredie, liekovú toxicitu a pri hemodialýze aj opakovanú obehovú záťaž. <strong>Žiadny jediný mechanizmus zatiaľ nevysvetľuje celé spektrum neurologických prejavov CKD.</strong></p>

<h2>Najprv presne: čo je CKD a čo je progresia</h2>

<p>KDIGO definuje CKD ako abnormalitu štruktúry alebo funkcie obličiek trvajúcu najmenej tri mesiace a majúcu dôsledky pre zdravie. Diagnóza sa neopiera iba o odhadovanú glomerulovú filtráciu (eGFR). Môže ju určovať aj albuminúria, abnormalita močového sedimentu, histologický alebo zobrazovací nález, tubulárna porucha či stav po transplantácii obličky.</p>

<p>CKD nevedie u každého pacienta k zlyhaniu obličiek. Priebeh závisí od príčiny, kategórie eGFR a albuminúrie, diabetu, krvného tlaku, fajčenia, prekonaných epizód akútneho poškodenia obličiek a účinnosti nefroprotektívnej liečby. Náhle zhoršenie funkcie obličiek počas hodín až dní nie je „rýchlou progresiou CKD“, ale vyžaduje hodnotenie akútneho poškodenia obličiek alebo akútneho ochorenia obličiek.</p>

<h2>Ako častá je kognitívna porucha</h2>

<p>Metaanalýza 50 štúdií so 25 289 pacientmi s CKD odhadla súhrnnú prevalenciu kognitívnej poruchy na 40 % (95 % interval spoľahlivosti 33 až 46 %). Podľa typu liečby boli súhrnné odhady 32 % bez dialýzy, 53 % pri hemodialýze, 39 % pri peritoneálnej dialýze a 26 % po transplantácii obličky.</p>

<p>Tieto čísla nemožno zamieňať za prevalenciu demencie. Zahrnuté štúdie používali rozdielne skríningové nástroje, diagnostické prahy a populácie, preto bola heterogenita vysoká. Odhad 53 % pri hemodialýze znamená, že určitý stupeň kognitívnej poruchy je v tejto skupine častý, nie že polovica dialyzovaných pacientov má demenciu alebo stratila schopnosť rozhodovať.</p>

<p>Najčastejšie bývajú postihnuté pozornosť, rýchlosť spracovania informácií a exekutívne funkcie. Pacient môže pôsobiť orientovane a viesť bežný rozhovor, no mať problém s dávkovaním liekov, kontrolou hmotnosti, plánovaním dopravy na dialýzu alebo porovnaním viacerých liečebných možností.</p>

<h2>Spoločná zraniteľnosť drobných ciev</h2>

<p>Obličky aj mozog majú hustú mikrocirkuláciu citlivú na hypertenziu, diabetes, aterosklerózu a arteriálnu tuhosť. Pri poškodení mozgových arteriol a kapilár sa na magnetickej rezonancii môžu objaviť hyperintenzity bielej hmoty, lakúny a mikrokrvácania. Tieto nálezy patria do spektra cerebrálnej choroby malých ciev.</p>

<p>Aktualizovaná metaanalýza 63 observačných štúdií so 57 030 osobami zistila pri eGFR nižšej ako 60 ml/min/1,73 m<sup>2</sup> asociáciu s mikrokrvácaniami, hyperintenzitami bielej hmoty a lakunárnymi infarktmi. Proteinúria sa takisto spájala s väčšou záťažou chorobou malých ciev. Ide o observačné údaje. Podporujú spoločný mikrovaskulárny mechanizmus, ale samy nedokazujú, že znížená eGFR priamo spôsobila konkrétny mozgový nález.</p>

<h2>Hematoencefalická bariéra: ľudský signál, nie hotové vysvetlenie</h2>

<p>Hematoencefalickú bariéru tvorí funkčná neurovaskulárna jednotka zahŕňajúca endotel mozgových kapilár s tesnými spojmi, bazálnu membránu, pericyty a výbežky astrocytov. Experimentálne modely naznačujú, že uremické prostredie, zápal a oxidačný stres môžu narušiť jej funkciu.</p>

<p>Malá prospektívna štúdia BREIN porovnala 15 pacientov so zlyhaním obličiek so 14 zdravými kontrolami. U pacientov zistila vyššiu priepustnosť hematoencefalickej bariéry a nižšie skóre MoCA; oba ukazovatele spolu korelovali. Výsledok je dôležitým dôkazom biologického signálu u človeka, ale vzorka bola veľmi malá, týkala sa zlyhania obličiek a nepreukázala smer kauzality. Nemožno ho preto zovšeobecniť na všetky štádiá CKD ani použiť ako základ konkrétnej liečby.</p>

<h2>Uremické a metabolické prostredie</h2>

<p>Pri poklese funkcie obličiek sa hromadia látky, ktoré môžu podporovať endotelovú dysfunkciu, oxidačný stres a zápal. Skúma sa najmä indoxylsulfát, p-krezylsulfát, guanidínové zlúčeniny, asymetrický dimetylarginín a ďalšie retenčné solúty. Pri väčšine z nich však nie je u človeka dokázané, že samy osebe priamo spôsobujú kognitívny pokles. Ich koncentrácia môže zároveň odrážať závažnosť CKD, zápal, výživu a črevný metabolizmus.</p>

<p>K poruche kognície môžu prispieť aj anémia, poruchy sodíka, kalcia alebo glukózy, acidobázická porucha, poruchy spánku, depresia, malnutrícia a senzorický deficit. Pri náhlej zmene vedomia preto nie je bezpečné uzavrieť stav ako „urémiu“ bez diferenciálnej diagnostiky.</p>

<h2>Hemodialýza: prínos eliminácie a riziko obehovej záťaže</h2>

<p>Hemodialýza koriguje uremické a elektrolytové prostredie, počas procedúry však mení cirkulujúci objem, osmolalitu a krvný tlak. Cerebrálny prietok môže počas dialýzy klesať, najmä pri vyššej ultrafiltrácii a výraznejšom poklese tlaku.</p>

<p>V prospektívnej observačnej kohorte 121 starších hemodialyzovaných pacientov klesala stredná rýchlosť prietoku v mozgových artériách počas procedúry. Väčší pokles sa spájal so zhoršením niektorých kognitívnych skóre počas 12 mesiacov. Štúdia podporuje význam obehovej záťaže, ale nedokazuje, že intradialyzačná hypotenzia priamo spôsobuje demenciu. Krvný tlak je navyše iba nepriamym ukazovateľom cerebrálnej perfúzie a individuálna autoregulácia sa líši.</p>

<p>Praktickým cieľom je obmedziť opakovanú hemodynamickú intoleranciu: realisticky stanoviť cieľovú hmotnosť, predchádzať nadmernému medzidialyzačnému prírastku, podľa potreby predĺžiť čas liečby, znížiť ultrafiltračnú rýchlosť a individuálne posúdiť načasovanie antihypertenzív. Nie je však preukázané, že jediný konkrétny dialyzačný zásah spoľahlivo zabráni kognitívnemu poklesu.</p>

<h2>Riziko cievnej mozgovej príhody nie je jedno číslo</h2>

<p>Riziko mozgovej príhody rastie s klesajúcou GFR aj so stúpajúcou albuminúriou. Metaanalýza 83 štúdií s viac ako 2,25 milióna účastníkov zistila pri každom poklese GFR o 10 ml/min/1,73 m<sup>2</sup> relatívne zvýšenie rizika mozgovej príhody o 7 %. Zvýšenie pomeru albumínu ku kreatinínu o 25 mg/mmol sa spájalo s relatívnym zvýšením rizika o 10 %, nezávisle od GFR.</p>

<p>Ide o priemerné populačné asociácie, nie predpoveď pre jednotlivca. Paušálne tvrdenie, že každý pacient s CKD má trojnásobné riziko mozgovej príhody, je nesprávne. Absolútne riziko závisí od veku, štádia CKD, albuminúrie, krvného tlaku, diabetu, fibrilácie predsiení, fajčenia, predchádzajúcej príhody a dialyzačného statusu.</p>

<h2>Neurotoxicita liekov: častá a niekedy prehliadnutá príčina</h2>

<p>Pri CKD sa môže liek alebo jeho aktívny metabolit hromadiť pre znížený renálny klírens. Riziko sa mení aj pri akútnom poškodení obličiek, sarkopénii a počas dialýzy. Príznakmi môžu byť ospalosť, dezorientácia, halucinácie, afázia, myoklonus, tremor, epileptické záchvaty alebo nekonvulzívny status epilepticus.</p>

<div class="table-responsive" role="region" aria-label="Príklady liekov s rizikom neurotoxicity pri chronickej chorobe obličiek" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina alebo liek</th>
      <th scope="col">Typické riziko</th>
      <th scope="col">Praktický dôsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Cefepím, ďalšie betalaktámy</td>
      <td>Encefalopatia, myoklonus, afázia, záchvaty</td>
      <td>Upraviť dávku a interval podľa funkcie obličiek; pri nových neurologických príznakoch liek aktívne zaradiť do diferenciálnej diagnostiky</td>
    </tr>
    <tr>
      <td>Aciklovir a valaciklovir</td>
      <td>Zmätenosť, agitácia, halucinácie, tremor</td>
      <td>Zohľadniť renálny klírens, hydratáciu a možnosť súčasného poškodenia obličiek</td>
    </tr>
    <tr>
      <td>Gabapentín, pregabalín a baklofén</td>
      <td>Somnolencia, ataxia, myoklonus až útlm vedomia</td>
      <td>Pri pokročilej CKD používať výrazne redukované dávky alebo vhodnú alternatívu podľa lieku a indikácie</td>
    </tr>
    <tr>
      <td>Morfín a iné lieky s renálne eliminovanými aktívnymi metabolitmi</td>
      <td>Predĺžená sedácia, delírium, respiračný útlm</td>
      <td>Vybrať liek aj dávku podľa funkcie obličiek a pravidelne prehodnocovať účinok a toxicitu</td>
    </tr>
    <tr>
      <td>Sedatíva a anticholínergiká</td>
      <td>Delírium, pády a zhoršenie už prítomnej kognitívnej poruchy</td>
      <td>Minimalizovať kumulatívnu záťaž a odstrániť lieky bez jasného prínosu</td>
    </tr>
  </tbody>
</table>
</div>

<p>Systematický prehľad 135 prípadov neurotoxicity cefepímu ukázal renálnu dysfunkciu u 80 % pacientov. Približne štvrtina prípadov vznikla napriek dávkovaniu hodnotenému ako primerané. Úprava dávky teda riziko znižuje, ale nevylučuje. Pri nestabilnej funkcii obličiek treba sledovať trend, klinický stav a podľa dostupnosti aj koncentráciu lieku.</p>

<h2>Ako kognitívnu poruchu zachytiť</h2>

<p>Nízky prah na cielené vyšetrenie je vhodný pri zabúdaní liekov alebo termínov, opakovaných nedorozumeniach, strate schopnosti zvládať bežné činnosti, po cievnej mozgovej príhode, pri pádoch alebo pred zložitým rozhodovaním o liečbe.</p>

<p>Montreal Cognitive Assessment (MoCA) je citlivejší na exekutívne a zrakovo-priestorové poruchy než samotný Mini-Mental State Examination. V štúdii 150 hemodialyzovaných pacientov mal MoCA spomedzi šiestich krátkych testov najlepšiu schopnosť zachytiť ťažkú kognitívnu poruchu. <strong>Neexistuje však jeden univerzálny prah vhodný pre všetkých pacientov s CKD.</strong> Výsledok ovplyvňuje jazyk, vzdelanie, vek, zrak, sluch, depresia, únava a klinický stav.</p>

<p>Na porovnateľné výsledky treba štandardizovať čas testovania. Pri rozhodnutiach s veľkým dosahom je vhodné vyšetrenie zopakovať alebo potvrdiť v stabilnom stave, mimo akútneho ochorenia a výraznej únavy po dialýze. Pozitívny skríning nie je diagnózou demencie. Vyžaduje klinické zhodnotenie, liekovú revíziu, funkčnú anamnézu od pacienta a so súhlasom aj od blízkej osoby; podľa nálezu neuropsychologické, neurologické alebo geriatrické vyšetrenie.</p>

<h2>Akútna zmätenosť je delírium, kým sa nepreukáže opak</h2>

<p>Náhla alebo kolísavá zmena pozornosti a vedomia si vyžaduje pátranie po akútnej, často liečiteľnej príčine. Treba posúdiť najmä infekciu, hypoxémiu, hypo- alebo hyperglykémiu, poruchy sodíka a kalcia, liekovú toxicitu, cievnu mozgovú príhodu, subdurálny hematóm, epileptický záchvat, hypertenznú encefalopatiu a nedostatočnú dialýzu. Pri nedávnom začatí alebo veľmi intenzívnej dialýze patrí do diferenciálnej diagnostiky aj dialyzačný dysekvilibračný syndróm.</p>

<p>Delírium je akútny a kolísavý syndróm; demencia je chronický kognitívny syndróm. Môžu sa však vyskytovať súčasne a už existujúca kognitívna porucha zvyšuje náchylnosť na delírium.</p>

<h2>Alzheimerova choroba, cievna porucha alebo zmiešaný obraz</h2>

<p>Pri CKD je najkonzistentnejšie doložená asociácia s cievnym poškodením a s deficitmi pozornosti a exekutívnych funkcií. CKD nemožno považovať za dokázanú priamu príčinu Alzheimerovej choroby. U starších pacientov je navyše častá zmiešaná patológia a rovnaké rizikové faktory, najmä vek, hypertenzia, diabetes a fajčenie, podporujú poškodenie obličiek aj mozgu.</p>

<p>Charakter kognitívneho profilu môže nasmerovať ďalšie vyšetrenie, sám však neurčuje etiológiu. Výrazná porucha epizodickej pamäti, fokálny neurologický nález, rýchla progresia alebo atypický priebeh sú dôvodom na širšie neurologické zhodnotenie.</p>

<h2>Kognícia po transplantácii obličky</h2>

<p>Metaanalýza desiatich štúdií zistila po transplantácii zlepšenie celkového kognitívneho stavu, rýchlosti spracovania, priestorového usudzovania a verbálnej aj vizuálnej pamäti. Príjemcovia však v niektorých doménach naďalej zaostávali za zdravými kontrolami a zahrnuté štúdie mali krátke sledovanie a obmedzené testové batérie.</p>

<p>Transplantáciu preto nemožno prezentovať ako liečbu demencie. Môže odstrániť časť reverzibilného uremického a dialyzačného zaťaženia, no nezvratné cievne poškodenie, predchádzajúca mozgová príhoda alebo neurodegeneratívne ochorenie môžu pretrvať. Po transplantácii treba myslieť aj na infekcie, metabolické komplikácie a neurotoxicitu imunosupresív.</p>

<h2>Praktický postup v nefrologickej starostlivosti</h2>

<ol>
  <li><strong>Rozpoznať zmenu:</strong> pýtať sa na lieky, termíny, financie, varenie, dopravu a ďalšie komplexné každodenné činnosti.</li>
  <li><strong>Vylúčiť reverzibilnú príčinu:</strong> akútnu chorobu, metabolickú odchýlku, liekovú toxicitu, depresiu, poruchu spánku a senzorický deficit.</li>
  <li><strong>Urobiť cielený skríning:</strong> použiť jazykovo a vzdelanostne primeraný nástroj a interpretovať ho v klinickom kontexte.</li>
  <li><strong>Zjednodušiť liečbu:</strong> odstrániť zbytočné lieky, zjednotiť dávkovacie časy a používať písomný plán alebo dávkovač.</li>
  <li><strong>Overiť porozumenie:</strong> požiadať pacienta, aby vlastnými slovami vysvetlil, čo a prečo má urobiť.</li>
  <li><strong>Zapojiť podporu:</strong> so súhlasom pacienta prizvať blízku osobu a presne určiť, s čím má pomáhať.</li>
  <li><strong>Chrániť cievy a perfúziu:</strong> liečiť krvný tlak, diabetes a dyslipidémiu podľa celkového rizika, podporiť nefajčenie a pri dialýze obmedzovať hemodynamickú intoleranciu.</li>
  <li><strong>Posúdiť rozhodovaciu schopnosť konkrétne:</strong> kognitívna porucha sama osebe neznamená stratu schopnosti rozhodovať.</li>
</ol>

<h2>Čo dôkazy podporujú a čo zostáva neisté</h2>

<ul>
  <li><strong>Dobre podložené:</strong> kognitívna porucha je pri CKD častá, najmä pri hemodialýze; nižšia eGFR a vyššia albuminúria sa spájajú s cievnou mozgovou príhodou a znakmi choroby malých ciev.</li>
  <li><strong>Podporené observačnými údajmi:</strong> pokles cerebrálneho prietoku počas hemodialýzy sa spája s ultrafiltráciou, poklesom tlaku a následným kognitívnym zhoršením.</li>
  <li><strong>Predbežné mechanistické dôkazy:</strong> pri zlyhaní obličiek môže byť zvýšená priepustnosť hematoencefalickej bariéry; dostupná ľudská štúdia je veľmi malá.</li>
  <li><strong>Nepreukázané:</strong> jeden konkrétny uremický toxín, porucha bariéry alebo intradialyzačná hypotenzia samy osebe vysvetľujú demenciu; jeden dialyzačný zásah jej spoľahlivo predchádza.</li>
</ul>

<h2>Záver</h2>

<p>CKD je významným markerom zvýšeného rizika kognitívnej poruchy, cerebrálnej choroby malých ciev a cievnej mozgovej príhody. Spojenie obličiek a mozgu vzniká súbehom cievnych, metabolických, zápalových, liekových a pri hemodialýze aj hemodynamických faktorov.</p>

<p>Najväčší okamžitý prínos pre prax neprináša jeden nový biomarker, ale systematická pozornosť: cielené vyšetrenie pri zmene fungovania, dôsledná lieková revízia, rýchle rozpoznanie delíria, zrozumiteľná komunikácia a individualizácia dialyzačnej liečby. Zároveň treba zachovať mieru dôkazov: porucha hematoencefalickej bariéry a jednotlivé uremické toxíny sú dôležité výskumné smery, nie potvrdené samostatné terapeutické ciele.</p>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Bobot M. Kidney Disease Is Also a Brain Disease. Here's Why. The Conversation. 29. júla 2026. <a href="https://theconversation.com/kidney-disease-is-also-a-brain-disease-heres-why-288234" target="_blank" rel="noopener noreferrer">The Conversation</a>.</em></small></li>
  <li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(Suppl 4S):S117-S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
  <li><small><em>Zhang J, Wu L, Wang P, a kol. Prevalence of Cognitive Impairment and Its Predictors Among Chronic Kidney Disease Patients: A Systematic Review and Meta-Analysis. PLoS One. 2024;19(6):e0304762. DOI: 10.1371/journal.pone.0304762. <a href="https://pubmed.ncbi.nlm.nih.gov/38829896/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Xiao CY, Ma YH, Ou YN, a kol. Association Between Kidney Function and the Burden of Cerebral Small Vessel Disease: An Updated Meta-Analysis and Systematic Review. Cerebrovascular Diseases. 2023;52(4):376-386. DOI: 10.1159/000527069. <a href="https://pubmed.ncbi.nlm.nih.gov/36599326/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Bobot M, Guedj E, Resseguier N, a kol. Increased Blood-Brain Barrier Permeability and Cognitive Impairment in Patients With ESKD. Kidney International Reports. 2024;9(10):2988-2995. DOI: 10.1016/j.ekir.2024.07.021. <a href="https://pubmed.ncbi.nlm.nih.gov/39430169/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Guo Y, Cui W, Ye P, Luo Y. Association Between Cerebral Blood Flow Variation and Cognitive Decline in Older Patients Undergoing Hemodialysis. Frontiers in Aging Neuroscience. 2024;16:1457675. DOI: 10.3389/fnagi.2024.1457675. <a href="https://pubmed.ncbi.nlm.nih.gov/39355539/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Masson P, Webster AC, Hong M, a kol. Chronic Kidney Disease and the Risk of Stroke: A Systematic Review and Meta-Analysis. Nephrology Dialysis Transplantation. 2015;30(7):1162-1169. DOI: 10.1093/ndt/gfv009. <a href="https://pubmed.ncbi.nlm.nih.gov/25681099/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Drew DA, Tighiouart H, Rollins J, a kol. Evaluation of Screening Tests for Cognitive Impairment in Patients Receiving Maintenance Hemodialysis. Journal of the American Society of Nephrology. 2020;31(4):855-864. DOI: 10.1681/ASN.2019100988. <a href="https://pubmed.ncbi.nlm.nih.gov/32132197/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Payne LE, Gagnon DJ, Riker RR, a kol. Cefepime-Induced Neurotoxicity: A Systematic Review. Critical Care. 2017;21(1):276. DOI: 10.1186/s13054-017-1856-1. <a href="https://pubmed.ncbi.nlm.nih.gov/29137682/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Joshee P, Wood AG, Wood ER, Grunfeld EA. Meta-Analysis of Cognitive Functioning in Patients Following Kidney Transplantation. Nephrology Dialysis Transplantation. 2018;33(7):1268-1277. DOI: 10.1093/ndt/gfx240. <a href="https://pubmed.ncbi.nlm.nih.gov/28992229/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// Vkladanie do databazy

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
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
    echo "------------------------------------------------------\n";
    echo "Migracia clanku: " . $articles[0]['title'] . "\n";
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
