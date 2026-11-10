<?php
/**
 * Pôvodný odborný prehľad bylinných prípravkov pri CKD.
 * Bez pacientskych údajov. Avíza nie sú vyžiadané.
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Bylinné prípravky pri CKD: dôkazy, interakcie a hranice bezpečnosti',
    'slug'         => 'bylinne-pripravky-ckd-dokazy-interakcie-bezpecnost',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Ako posudzovať viaczložkové bylinné prípravky pri CKD: rozdiel medzi klinickým dôkazom a experimentom, liekové interakcie, kvalita výrobku a rozhodovanie podľa štádia choroby.',
    'content'      => <<<'HTML'
<figure><a href="img/bylinne-pripravky-ckd-dokazy-interakcie-bezpecnost.webp" target="_blank" rel="noopener noreferrer"><img src="img/bylinne-pripravky-ckd-dokazy-interakcie-bezpecnost.webp" alt="Poloschematická oblička vedľa laboratórnych misiek s rastlinnými surovinami a granulátom" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna. Nezobrazuje konkrétneho pacienta, výrobok ani liečebný účinok.</figcaption></figure>

<p>Pri posudzovaní bylinného prípravku u pacienta s chronickou chorobou obličiek (CKD) nestačí poznať zoznam rastlín. Rozhoduje botanická identita, použitá časť rastliny, spôsob spracovania, skutočná dávka extraktu, kvalita šarže a súbežná liečba. Bez týchto údajov nemožno bezpečnosť odvodiť z nízkej hmotnosti granulátu ani z jeho predchádzajúcej subjektívne dobrej tolerancie.</p>

<p>Rovnako nepresné by bolo označiť všetky bylinné zmesi za nefrotoxické. Pre niektoré konkrétne receptúry existujú klinické údaje, pri iných máme iba experimentálne poznatky alebo bezpečnostné hlásenia. Nefrologické rozhodnutie musí vychádzať z dôkazov o danom prípravku a z rizika konkrétneho pacienta, nie z jeho „prírodného“ pôvodu. [1, 2]</p>

<h2>Čo odporúča KDIGO</h2>

<p>Praktický bod 4.1.3 odporúčania KDIGO 2024 žiada preverovať a obmedzovať voľnopredajné lieky, výživové doplnky a bylinné prípravky, ktoré môžu škodiť ľuďom s CKD. Bod 4.1.2 zdôrazňuje sledovanie odhadovanej glomerulovej filtrácie (eGFR), elektrolytov a podľa potreby hladín rizikových liekov. Nejde o plošný zákaz všetkých rastlinných prípravkov ani o ich schválenie. [1]</p>

<p>KDIGO neurčuje univerzálnu „renálnu dávku“ viaczložkových bylinných extraktov. Z klinického hľadiska preto neznámy prípravok nemožno upraviť jednoduchým znížením dávky podľa kategórie G. Na oficiálnej stránke KDIGO bola k 10. novembru 2026 aktualizácia liečebnej časti označená ako návrh odporúčania 2027 na verejné pripomienkovanie; nasledujúce posúdenie sa opiera o finálne odporúčanie 2024. [1]</p>

<h2>Zoznam surovín ešte neurčuje dávku</h2>

<p>Gramáž rastlinnej drogy, množstvo suchého extraktu a hmotnosť hotového granulátu sú rozdielne údaje. Označenie pomeru droga : extrakt, zvyčajne skratkou DER, treba interpretovať spolu s údajom o extrakčnom rozpúšťadle, obsahu nosičov a štandardizácii. Ak výrobca mieša samostatné extrakty s odlišnými pomermi, samotný súčet navážok pôvodných drog neumožňuje vypočítať dennú expozíciu. [2, 10]</p>

<p>Ilustračný výpočet ukazuje rozdiel: 1 g čistého suchého extraktu s DER 5 : 1 predstavuje ekvivalent 5 g východiskovej drogy, pri DER 10 : 1 ide o 10 g. Ani rovnaký ekvivalent drogy však nezaručuje rovnaké koncentrácie farmakologicky účinných látok, najmä pri inom rozpúšťadle alebo spracovaní. Výpočet nie je návodom na dávkovanie pri CKD.</p>

<p>Výrobca má uviesť úplný latinský názov, použitú časť rastliny, technologickú úpravu a podiel jednotlivých extraktov. Dve odlišne spracované formy toho istého druhu môžu byť zámernou súčasťou receptúry, ale treba preveriť ich spoločnú expozíciu. Tradičná úprava parením, pražením alebo vínom sama osebe nedokazuje odstránenie nefrotoxicity či bezpečnosť pri pokročilej CKD. [2]</p>

<h2>Klinické štúdie poskytujú signály, nie schválenie ľubovoľnej zmesi</h2>

<p>Štúdia SCHEMATIC randomizovala 148 dospelých s diabetom 2. typu, eGFR od 30 do 90 ml/min/1,73 m² a výraznou albuminúriou na prídavnú liečbu receptúrami založenými na Rehmannia-6 alebo štandardnú starostlivosť. Počas 48 týždňov bol rozdiel v odhadovanom ročnom poklese eGFR 2,7 ml/min/1,73 m² v prospech intervencie, s 95 % intervalom spoľahlivosti od 0,1 do 5,3; p = 0,04. Rozdiel v albuminúrii nebol štatisticky významný, p = 0,28. [3]</p>

<p>Hodnotitelia boli zaslepení, pacienti a ošetrujúci lekári nie. Skúmali sa protokolom určené receptúry a primárny výsledok bol náhradným ukazovateľom. Štúdia nepreukázala zníženie potreby dialýzy alebo úmrtnosti a nezahŕňala pacientov s eGFR pod 30 ml/min/1,73 m². Neoprávňuje odporučiť inú zmes v kategórii G4. [3]</p>

<p>Aj aktuálny prehľad publikovaný v <em>Nephrology Dialysis Transplantation</em> v roku 2026 upozorňuje, že sľubné výsledky niekoľkých skúšaných prípravkov vyžadujú nezávislé potvrdenie a hodnotenie jednotlivých výrobkov. Tradičná čínska medicína nie je jedna farmakologicky homogénna intervencia. [9]</p>

<h2>Interakcie treba posudzovať podľa látky, druhu a úrovne dôkazu</h2>

<h3>Berberín a Coptis chinensis</h3>

<p>Berberín je alkaloid prítomný aj v <em>Coptis chinensis</em>. V randomizovanej krížovej štúdii, ktorú dokončilo 17 zdravých mužov, podávanie berberínu 300 mg trikrát denne počas dvoch týždňov znížilo aktivitu CYP2D6, CYP2C9 a CYP3A4. Ide o humánny dôkaz interakčného potenciálu pri známej dávke. Neurčuje však rozsah účinku neštandardizovaného granulátu s neznámym obsahom berberínu. [4]</p>

<p>Zo samotnej inhibície CYP nemožno odvodiť klinicky významnú interakciu so všetkými liekmi pacienta. Treba preveriť konkrétny substrát, terapeutické rozmedzie a ďalšie eliminačné mechanizmy. Časový odstup medzi dávkami navyše nemusí zabrániť interakcii sprostredkovanej zmenou aktivity enzýmov.</p>

<h3>Klanopraška a imunosupresíva</h3>

<p><em>Schisandra chinensis</em> a <em>Schisandra sphenanthera</em> nie sú totožné druhy. V kultúrach ľudských hepatocytov extrakty oboch druhov ovplyvnili metabolizmus sprostredkovaný CYP3A4/5. Klinická štúdia s 12 zdravými dobrovoľníkmi preukázala zvýšenie expozície takrolimu pri extrakte <em>S. sphenanthera</em>. Výsledok nemožno číselne preniesť na <em>S. chinensis</em> ani na inú receptúru. [5, 6]</p>

<p>Pri transplantovanej obličke je však neistota spojená s úzkym terapeutickým rozmedzím imunosupresív dostatočným dôvodom, aby sa podobný prípravok nezačínal bez transplantačného tímu. Treba preveriť aj dôsledok jeho vysadenia, pretože odstránenie interakcie môže opäť zmeniť koncentráciu lieku.</p>

<h3>Pivónie a funkcia trombocytov</h3>

<p>Pri paeonifloríne z <em>Paeonia suffruticosa</em> bola opísaná inhibícia agregácie ľudských trombocytov vyvolanej šmykovým napätím <em>in vitro</em> a antitrombotický účinok u potkanov. V zvieracom modeli sa pritom nepredĺžil čas krvácania. To nedokazuje klinické krvácanie pri kombinácii pivónie s kyselinou acetylsalicylovou, ale ani bezpečnosť takejto kombinácie pri pokročilej CKD. [8]</p>

<p>Pri súbežnej antiagregačnej alebo antikoagulačnej liečbe treba zaznamenať celý prípravok a sledovať krvácavé prejavy. Normálny medzinárodný normalizovaný pomer (INR) nevylučuje poruchu funkcie trombocytov. Predpísaná antiagregačná liečba sa nemá rušiť len preto, aby bolo možné pridať prípravok s nedoloženým prínosom.</p>

<h2>Bezpečnosť sa netýka iba obličiek</h2>

<p>Pri prípravkoch obsahujúcich šišiak bajkalský, <em>Scutellaria baicalensis</em>, boli publikované prípady poškodenia pečene. Kazuistika Yang a spoluautorov opisuje ústup hepatitídy po vysadení viaczložkového doplnku a jej opakovanie po opätovnom užití. Podporuje súvislosť s výrobkom, ale bez analýzy jednotlivých zložiek neurčuje spoľahlivo vinníka ani incidenciu reakcie. [7]</p>

<p>Dobrá tolerancia počas niekoľkých týždňov nevylučuje laboratórne zachytiteľné alebo oneskorené poškodenie. Pri zhoršení funkcie obličiek či pečene treba zistiť začiatok užívania, skutočnú dávku, súbežné lieky a konkrétnu šaržu. Opätovná expozícia na potvrdenie príčiny nie je prijateľným bežným klinickým postupom. [7]</p>

<p>Riziko môže byť aj nepriame. Vracanie, hnačka, znížený príjem a hypotenzia môžu viesť k hypovolémii a akútnemu poškodeniu obličiek. Pri inhibítore renínovo-angiotenzínového systému, diuretiku alebo inhibítore sodíkovo-glukózového kotransportéra 2 (SGLT2) treba posúdiť hemodynamickú situáciu a plán postupu pri akútnom ochorení. To nie je dôkaz, že daná bylina priamo farmakokineticky interaguje so všetkými týmito liekmi. Pri dapagliflozíne oficiálne informácie o lieku upozorňujú na depléciu objemu a potrebu dočasného prerušenia pri jej vzniku. [2, 11]</p>

<h2>Minerály a kontaminanty sa majú merať</h2>

<p>Neznámy obsah draslíka nie je synonymom vysokej draslíkovej záťaže. Rovnako nízka hmotnosť granulátu nedokazuje zanedbateľný obsah minerálov. Pri pokročilej CKD je vhodné žiadať údaj o draslíku, sodíku, vápniku, horčíku a fosfore v skutočnej dennej dávke hotového výrobku. Potrebu obmedzenia treba vzťahovať na výsledok analýzy, laboratórny nález a ostatný príjem pacienta.</p>

<p>Kontrola kvality zahŕňa identitu surovín, štandardizáciu, mikrobiálnu čistotu, pesticídy, mykotoxíny, toxické prvky a podľa výrobného postupu aj zvyškové rozpúšťadlá. Protokol má patriť ku konkrétnej šarži a uvádzať metódy, jednotky a limity stanoviteľnosti. Všeobecné označenie „laboratórne testované“ tieto údaje nenahrádza. [10]</p>

<p>Nefropatia spôsobená kyselinami aristolochovými je vážnym príkladom poškodenia pri určitých rastlinných produktoch a zámenách surovín. Nie je však dôkazom, že každá čínska bylinná zmes obsahuje tieto látky. Požiadavka na ich vylúčenie podľa rizika pôvodu sa má odlišovať od tvrdenia o preukázanej kontaminácii konkrétneho výrobku. Ani vyhovujúca kvalita sama osebe nepreukazuje klinickú účinnosť. [2, 10]</p>

<h2>Ako sa mení rozhodovanie podľa štádia CKD</h2>

<p>Tabuľka používa kategórie G podľa KDIGO. Závery sa týkajú viaczložkového prípravku s neúplnou špecifikáciou a nedoloženým prínosom. Sú klinickou interpretáciou, nie osobitným odporúčaním KDIGO pre jednotlivé byliny. Pri G1 a G2 samotná hodnota eGFR bez ďalšieho markeru poškodenia obličiek diagnózu CKD nezakladá. [1]</p>

<div class="table-responsive" role="region" aria-label="Posudzovanie neštandardizovaných bylinných prípravkov podľa kategórie CKD" tabindex="0"><table><thead><tr><th scope="col">Kategória</th><th scope="col">eGFR v ml/min/1,73 m²</th><th scope="col">Praktický dôsledok</th></tr></thead><tbody>
<tr><th scope="row">G1 a G2</th><td>≥90; od 60 do 89</td><td>Zachovaná filtrácia nevylučuje hepatotoxicitu ani interakcie. Bez dôkazu účinku neodporúčať ako liečbu CKD.</td></tr>
<tr><th scope="row">G3a</th><td>Od 45 do 59</td><td>Rutinne nezačínať nešpecifikovaný prípravok. Vyžadovať produktové údaje a individuálne preverenie liečby.</td></tr>
<tr><th scope="row">G3b</th><td>Od 30 do 44</td><td>Nižšia funkčná rezerva zvyšuje význam neistoty. Bez jasného prínosu a bezpečnostných údajov použitie neodporúčať.</td></tr>
<tr><th scope="row">G4 a G5 bez dialýzy</th><td>Od 15 do 29; &lt;15</td><td>Nezačínať neštandardizovanú zmes bez doloženej indikácie a bezpečnosti. Neexistuje univerzálna úprava dávky podľa eGFR.</td></tr>
<tr><th scope="row">G5D</th><td>Dialyzačná liečba</td><td>Dialýza nezaručuje odstránenie zložiek. Bez údajov o dialyzovateľnosti nemožno navrhnúť načasovanie či doplnkovú dávku.</td></tr>
<tr><th scope="row">Transplantovaná oblička</th><td>Kategória G s označením T</td><td>Rozhoduje transplantačný tím a preverenie interakcií s imunosupresívami vrátane dôsledkov vysadenia prípravku.</td></tr>
</tbody></table></div>

<p>Albuminúria, dynamika eGFR, prekonané akútne poškodenie obličiek, krehkosť, hepatopatia, krvácanie a kolísanie tlaku môžu zvýšiť riziko aj pri relatívne zachovanej filtrácii. Samotná kategória G preto nestačí na rozhodnutie o bezpečnosti. Pri dialýze a transplantácii ide navyše o osobitné populácie, na ktoré nemožno bez overenia prenášať výsledky skúšaní u nedialyzovaných pacientov.</p>

<h2>Čo má obsahovať nefrologické posúdenie</h2>

<p>Prvým krokom je pomenovať očakávaný prínos: má sa liečiť konkrétny príznak alebo spomaľovať progresia CKD? Nasleduje identifikácia výrobku a zosúladenie všetkých liekov a doplnkov. Až potom možno posúdiť interakcie a primeranosť expozície. Neznámy výrobok sa nestáva overeným tým, že sa vynechá jedna podozrivá zložka. [1, 2]</p>

<p>Pri pokročilej CKD treba poznať aktuálny kreatinín a trend eGFR, elektrolyty, acidobázický stav, kalciémiu a fosfatémiu; pri prípravku s hepatálnym bezpečnostným signálom aj pečeňové testy. Rozsah dopĺňa klinický nález, liečba a plánované trvanie. Nie je stanovený univerzálny harmonogram odberov, ktorý by zaručil bezpečnosť ľubovoľnej zmesi. Laboratórne sledovanie nenahrádza dôkaz účinnosti ani kontrolu kvality.</p>

<p>Ak pacient prípravok už užíva, treba zaznamenať názov, šaržu, dávku a časový priebeh. Pri podozrení na poškodenie sa prípravok preruší a hodnotí sa aj iná možná príčina zhoršenia. Pri poklese diurézy, synkope, iktere, krvácaní, pretrvávajúcom vracaní alebo vyrážke so systémovými prejavmi sa nečaká na plánovanú kontrolu. Príjem tekutín sa upravuje podľa hydratácie, diurézy a srdcového stavu, nie paušálnym pokynom „viac piť“.</p>

<h2>Limity a klinický záver</h2>

<p>Dostupné dôkazy sú nerovnomerné: malé klinické štúdie skúmajú konkrétne extrakty, experimenty opisujú mechanizmy a kazuistiky upozorňujú na možné toxicity. Ani jedna z týchto vrstiev neoprávňuje vyhlásiť všetky bylinné prípravky za účinné alebo všetky za škodlivé. Pri mnohozložkovej zmesi bez určiteľnej expozície a prínosu však neistota sama vstupuje do pomeru prínosu a rizika.</p>

<p>V pokročilej CKD je preto obhájiteľné takýto prípravok nezačať. Zmyslom konzultácie je pacientovi vysvetliť konkrétne chýbajúce údaje, preveriť dôvod jeho záujmu o doplnkovú liečbu a ponúknuť postup s lepšie doloženým prínosom. Predpísaná liečba sa nemá oslabovať len preto, aby sa vytvoril priestor pre neoverenú zmes.</p>

<hr>
<p><em>Článok je určený zdravotníckym pracovníkom. Neobsahuje údaje o konkrétnom pacientovi ani návod na individuálnu preskripciu.</em></p>

<h2>Literatúra</h2>
<ol>
<li><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney International. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Úplné odporúčanie</a>. <a href="https://kdigo.org/guidelines/ckd--evaluation-and-management/" target="_blank" rel="noopener noreferrer">Stav aktualizácie</a>.</em></small></li>
<li><small><em>Bo Yang; Yun Xie; Maojuan Guo; Mitchell H Rosner; Hongtao Yang; Claudio Ronco. Nephrotoxicity and Chinese Herbal Medicine. Clinical Journal of the American Society of Nephrology. 2018;13(10):1605-1611. <a href="https://doi.org/10.2215/CJN.11571017" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/29615394/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6218812/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Kam Wa Chan; Alfred Siu Kei Kwong; Kathryn Choon Beng Tan; Sing Leung Lui; Gary C W Chan; Tai Pang Ip; Wai Han Yiu; Benjamin John Cowling; Vivian Taam Wong; Lixing Lao; Yibin Feng; Kar Neng Lai; Sydney C W Tang. Add-on Rehmannia-6-Based Chinese Medicine in Type 2 Diabetes and CKD: A Multicenter Randomized Controlled Trial. Clinical Journal of the American Society of Nephrology. 2023;18(9):1163-1174. <a href="https://doi.org/10.2215/CJN.0000000000000199" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37307005/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10564374/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Ying Guo; Yao Chen; Zhi-Rong Tan; Curtis D Klaassen; Hong-Hao Zhou. Repeated administration of berberine inhibits cytochromes P450 in humans. European Journal of Clinical Pharmacology. 2012;68(2):213-7. <a href="https://doi.org/10.1007/s00228-011-1108-2" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/21870106/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4898966/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Jonathan P Jackson; Kimberly M Freeman; Weslyn W Friley; Ashley G Herman; Christopher B Black; Kenneth R Brouwer; Amy L Roe. Prediction of Clinically Relevant Herb-Drug Clearance Interactions Using Sandwich-Cultured Human Hepatocytes: Schisandra spp. Case Study. Drug Metabolism and Disposition. 2017;45(9):1019-1026. <a href="https://doi.org/10.1124/dmd.117.075408" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28698304/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Hua-Wen Xin; Xiao-Chun Wu; Qing Li; Ai-Rong Yu; Min Zhu; Yang Shen; Dan Su; Lei Xiong. Effects of Schisandra sphenanthera extract on the pharmacokinetics of tacrolimus in healthy volunteers. British Journal of Clinical Pharmacology. 2007;64(4):469-75. <a href="https://doi.org/10.1111/j.1365-2125.2007.02922.x" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/17506780/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC2048562/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Leslie Yang; Andrew Aronsohn; John Hart; Donald Jensen. Herbal hepatoxicity from Chinese skullcap: A case report. World Journal of Hepatology. 2012;4(7):231-3. <a href="https://doi.org/10.4254/wjh.v4.i7.231" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/22855699/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3409358/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Thien Ngo; Keunyoung Kim; Yiying Bian; Hakjun Noh; Kyung-Min Lim; Jin-Ho Chung; Ok-Nam Bae. Antithrombotic Effects of Paeoniflorin from Paeonia suffruticosa by Selective Inhibition on Shear Stress-Induced Platelet Aggregation. International Journal of Molecular Sciences. 2019;20(20):5040. <a href="https://doi.org/10.3390/ijms20205040" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31614534/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6834133/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></li>
<li><small><em>Qi Chen; Yingnan Liang; Jiajia Bai; Zhenjie Chen; Jingwei Zhou. Traditional Chinese medicine in CKD: myths, facts, and evidence. Nephrology Dialysis Transplantation. 2026:gfag247. Publikované online 26. októbra 2026. <a href="https://doi.org/10.1093/ndt/gfag247" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42931903/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>World Health Organization. WHO guidelines for assessing quality of herbal medicines with reference to contaminants and residues. Geneva: WHO; 2007. ISBN 9789241594448. <a href="https://www.who.int/publications/i/item/9789241594448" target="_blank" rel="noopener noreferrer">Oficiálny zdroj</a>.</em></small></li>
<li><small><em>European Medicines Agency; AstraZeneca AB. Forxiga, product information. Časti 4.4 a 4.5. <a href="https://www.ema.europa.eu/en/documents/product-information/forxiga-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Informácie o lieku</a>. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/forxiga" target="_blank" rel="noopener noreferrer">Registračný prehľad EMA</a>.</em></small></li>
</ol>

<p><em>Podklady a interpretácia: Ide o pôvodný odborný prehľad, nie o kazuistiku. Klinické príklady boli zovšeobecnené bez zverejnenia individuálnej receptúry či liekového zoznamu. Hodnotenie podľa štádií CKD je klinickou syntézou, nie klasifikáciou bylín vydanou KDIGO. Pri prehľade Chen a spoluautorov a experimentálnej práci Jackson a spoluautorov boli overené bibliografické údaje a abstrakty; hlavné výsledky SCHEMATIC a humánnej štúdie berberínu boli skontrolované aj v dostupnom plnom texte. Stav podkladov: 10. novembra 2026.</em></p>

<h3>Súvisiace články</h3>
<ul><li><a href="article.php?slug=cholin-l-karnitin-doplnky-diabeticka-nefropatia-tmao">Cholín, L-karnitín a výživové doplnky pri diabetickej nefropatii</a></li><li><a href="article.php?slug=uran-a-oblicky-nefrotoxicita-radiacne-poskodenie-kovy">Urán a obličky: nefrotoxicita a poškodenie kovmi</a></li></ul>

HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_bylinne-pripravky-ckd-dokazy-interakcie-bezpecnost_article',
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
