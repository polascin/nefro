<?php

/** Publikačný skript odborného článku. Avíza sa zámerne neposielajú. */
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
    'title' => 'Dlhé formy kardiálneho troponínu T pri chronickej chorobe obličiek',
    'slug' => 'dlhe-formy-troponinu-t-chronicka-choroba-obliciek',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Komerčný hs-cTnT pri nižšej glomerulovej filtrácii často stúpa aj bez infarktu. Dlhé formy cTnT u 1811 ľudí na urgentnom príjme túto väzbu nemali a infarkt odlíšili lepšie. V bežnom laboratóriu zatiaľ nie sú.',
    'content' => <<<'HTML'
<figure>
  <a href="img/dlhe-formy-troponinu-t-chronicka-choroba-obliciek.webp" rel="noopener noreferrer" target="_blank">
    <picture>
      <source srcset="img/dlhe-formy-troponinu-t-chronicka-choroba-obliciek.webp" type="image/webp">
      <img src="img/dlhe-formy-troponinu-t-chronicka-choroba-obliciek.png" alt="Priesvitné srdce a oblička v tme, medzi nimi súvislé svetelné vlákno a roztrúsené krátke úlomky" width="1600" height="1000" loading="lazy" decoding="async">
    </picture>
  </a>
  <figcaption>Ilustračná poloschematická scéna, nie snímka pacienta ani laboratórnej súpravy. Dlhá forma troponínu T je tu súvislé vlákno medzi srdcom a obličkou, krátke fragmenty sú červené úlomky. Takto súprava v skutočnosti nevyzerá.</figcaption>
</figure>

<p>Jedna hodnota komerčného vysokosenzitívneho kardiálneho troponínu T (hs-cTnT) u človeka s chronickou chorobou obličiek (CKD) infarkt myokardu neuzatvára. Horná referenčná medza 14 ng/l býva pri nižšej odhadovanej glomerulovej filtrácii (eGFR) prekročená aj bez akútnej ischémie. Hellman a spolupracovníci v práci z 16. októbra 2026 ukázali, že dlhé formy kardiálneho troponínu T (long cTnT) sa u ľudí bez infarktu od eGFR neodvíjajú tak ako komerčný hs-cTnT a že infarkt odlíšia lepšie práve pri horšej filtrácii. Metóda zatiaľ nie je bežná laboratórna súprava. Jedno číslo nad 14 ng/l diagnózu nerobí. Kým long cTnT nie je lokálne overený, ostáva séria odberov, elektrokardiogram a zobrazovanie.</p>

<p>Rozdiel medzi oboma testami nie je nový prah na katetrizáciu. Je to oddelenie zvýšenia viazaného na funkciu obličiek od zvýšenia pri infarkte, a aj to len v súbore, ktorý štúdia skutočne mala. Prognóza pred dialýzou a postup bez novej súpravy majú iné medze.</p>

<h2>Čo komerčný test meria a čo meria long cTnT</h2>

<p>Komerčný vysokosenzitívny test na troponín T zachytáva naraz neporušené aj rôzne naštiepené molekuly. Práce z Turku ho preto volajú celkový cTnT. Long cTnT je výskumný imunotest zameraný na neporušené alebo len mierne naštiepené, teda dlhé molekuly. Zámer je odlíšiť akútne uvoľnenie pri infarkte od zvýšenia, ktoré s akútnou oklúziou koronárnej tepny nemusí súvisieť.</p>

<p>Nie je preukázané, že by pri CKD v krvi jednoducho prevažovali krátke fragmenty. Abstrakt štúdie o funkcii obličiek to nehovorí. Hovorí niečo užšie. U ľudí bez infarktu sa s funkciou obličiek hýbe komerčný hs-cTnT, nie long cTnT. Taký rozdiel zodpovedá predstave, že podiel viazaný na obličky tvoria formy, ktoré dlhá metóda nemeria. Je to výklad výsledku, nie priamy opis fragmentov v plazme.</p>

<h2>Štúdia na urgentnom príjme</h2>

<p>Hellman a spolupracovníci prospektívne zaradili 1811 po sebe idúcich pacientov urgentného príjmu s hs-cTnT najmenej 14 ng/l. Infarkt myokardu malo 205 ľudí (11,3 %). Anamnézu CKD malo 204 ľudí (11,3 %). To nie je súbor zložený z ľudí s CKD. Je to súbor ľudí s už zvýšeným komerčným troponínom, v ktorom je CKD v anamnéze menšina. Filtrácia bola napriek tomu často znížená. Medián eGFR z kreatinínu bol 71 ml/min/1,73 m² (medzikvartilové rozpätie 51 až 87), z cystatínu C 52 (36 až 69) a z oboch markerov 63 (44 až 79).</p>

<p>U ľudí bez infarktu long cTnT s funkciou obličiek konzistentne nesúvisel. Regresný koeficient voči eGFR bol 0,0008 pri rovnici z kreatinínu (P = 0,050), 0,0005 pri rovnici z cystatínu C (P = 0,222) a 0,0006 pri kombinovanej rovnici (P = 0,182). Hodnota P = 0,050 pri kreatinínovej rovnici leží na hranici obvyklého prahu. Abstrakt preto hovorí o chýbaní konzistentnej súvislosti, nie o dôkaze, že funkcia obličiek long cTnT neovplyvňuje vôbec. Komerčný hs-cTnT sa správal opačne: pri vyššej eGFR bol nižší. Koeficienty boli 0,0032, 0,0035 a 0,0035 so záporným znamienkom, všetky P &lt; 0,001.</p>

<p>Long cTnT odlíšil infarkt lepšie než hs-cTnT (P &lt; 0,001). Výhoda sa s klesajúcou eGFR zväčšovala, a to pri všetkých troch rovniciach. Štúdia hodnotila infarkt typu 1 aj akýkoľvek infarkt. Abstrakt však neuvádza plochu pod krivkou osobitne pre tieto dve otázky v pásmach eGFR. Zverejnený súhrn je lepšia detekcia infarktu, s najväčším rozdielom pri nižšej eGFR. Ročník, číslo a strany časopisu Nephrology Dialysis Transplantation k 28. októbru 2026 pridelené neboli. Článok vyšiel online 16. októbra 2026.</p>

<p>Rovnaký nábor, 1811 ľudí s hs-cTnT najmenej 14 ng/l, opisuje štúdia SuperTROPO v European Heart Journal. Teppo a spolupracovníci v nej súpravu pomenúvajú: Roche Diagnostics. V celom súbore, bez členenia podľa eGFR, bola plocha pod krivkou long cTnT pre akýkoľvek infarkt 0,833 (interval spoľahlivosti 0,804 až 0,863) a pre komerčný hs-cTnT 0,782 (0,744 až 0,819). Pre infarkt typu 1 to bolo 0,839 (0,807 až 0,872) oproti 0,777 (0,735 až 0,819). Obe porovnania mali P &lt; 0,001. Z 205 infarktov bolo 148 typu 1. V najnižšej tretine long cTnT, pod 3,7 ng/l, mal infarkt typu 1 len 0,7 % ľudí. Tieto plochy nehovoria, ako sa test správa pri eGFR 20 ml/min/1,73 m². To je otázka práce Hellmana, a tá plochy po pásmach filtrácie v abstrakte neuvádza.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie dvoch prospektívnych prác o dlhých formách troponínu T" tabindex="0">
<table>
<thead>
<tr>
<th scope="col">Otázka</th>
<th scope="col">Hellman a spolupracovníci, 2026</th>
<th scope="col">Salonenová a spolupracovníci, 2026</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row">Kto bol zaradený</th>
<td>1811 ľudí na urgentnom príjme s hs-cTnT najmenej 14 ng/l. Anamnéza CKD u 204 (11,3 %).</td>
<td>136 ľudí s CKD G4 až G5, zatiaľ bez dialýzy.</td>
</tr>
<tr>
<th scope="row">Čo sa meralo</th>
<td>Long cTnT oproti komerčnému hs-cTnT. Infarkt malo 205 ľudí (11,3 %).</td>
<td>Long cTnT aj celkový cTnT výskumnými imunotestami, nie komerčnou súpravou z príjmu.</td>
</tr>
<tr>
<th scope="row">Hlavný výsledok</th>
<td>U ľudí bez infarktu long cTnT s eGFR konzistentne nesúvisel, hs-cTnT áno. Výhoda pri detekcii infarktu rástla s nižšou eGFR.</td>
<td>Po úprave o vek, pohlavie a ischemickú chorobu srdca long cTnT súvisel s úmrtím, novou fibriláciou predsiení a zloženým výsledkom, nie s veľkou nepriaznivou kardiovaskulárnou alebo cerebrovaskulárnou udalosťou.</td>
</tr>
</tbody>
</table>
</div>

<h2>Zvýšenie pri CKD nie je len zlyhanie klírensu</h2>

<p>Staršie vysvetlenie dávalo chronické zvýšenie troponínu T najmä zníženému renálnemu klírensu fragmentov. Van der Lindenová a spolupracovníci to v roku 2017 skúšali na dennom rytme. Kardiálny troponín T cez deň klesá a v noci stúpa. Ak by bol hlavný problém hromadenie pre pomalý klírens, amplitúda rytmu by sa zmenšila. Hodinovými odbermi počas 24 hodín porovnali 20 ľudí s mediánom eGFR 82,8 ml/min/1,73 m² a 24 ľudí s eGFR pod 60, medián 18,3. Amplitúda bola 12,0 % (smerodajná odchýlka 0,5) a 11,4 % (smerodajná odchýlka 0,5), P = 0,53. Model pritom čakal pokles zhruba z 12 % na 8 %, ak by sa eliminácia znížila o 80 %. Rytmus nezoslabol. Malá účasť obličky na odstraňovaní troponínu T tým vylúčená nie je. Znížený klírens však podľa autorov nie je hlavné vysvetlenie trvalo zvýšenej koncentrácie. Skôr ide o zvýšené uvoľňovanie zo srdca, vrátane subklinického poškodenia myokardu. Súbor má 44 ľudí. Práca je krátky list a klinické udalosti nesleduje.</p>

<p>Braghieri a spolupracovníci v prehľade z roku 2023 pokladajú za zdroje pretrvávajúceho uvoľňovania mikrovaskulárne postihnutie, hypertrofiu ľavej komory, hypoperfúziu pri hypotenzii alebo anémii a urémické kardiotoxické vplyvy. Osobitne uvádzajú experimentálny údaj, že regenerujúci kostrový sval môže znovu exprimovať embryonálne formy troponínu T, nie troponínu I. Je to hypotéza o krížovej reakcii súpravy, nie dôkaz, že long cTnT tento podiel odstraňuje. Prehľad je naratívny. Nie je to odporúčanie Európskej kardiologickej spoločnosti ani KDIGO.</p>

<h2>Prognóza pred začatím dialýzy</h2>

<p>Salonenová a spolupracovníci sledovali 136 ľudí s CKD štádia G4 až G5, zatiaľ bez dialýzy. Priemerný vek bol 61 rokov (smerodajná odchýlka 13), 47 bolo žien (34,6 %). Long cTnT aj celkový cTnT merali pred začatím dialýzy výskumnými imunotestami pripravenými na pracovisku autorov. Medián long cTnT bol 1,9 ng/l (1,3 až 3,0), medián celkového cTnT 37 ng/l (23 až 66). Za medián 6,2 roka (4,6 až 7,7) zomrelo 62 ľudí (45,6 %), veľkú nepriaznivú kardiovaskulárnu alebo cerebrovaskulárnu udalosť (MACCE) malo 36 (26,5 %) a zložený výsledok, úmrtie alebo MACCE, 76 (55,9 %). Novú fibriláciu predsiení udávajú u 28 ľudí (23,3 %). Tento podiel nie je 28 zo 136. Abstrakt menovateľ neuvádza.</p>

<p>V Coxových modeloch s úpravou o vek, pohlavie a ischemickú chorobu srdca súviseli long cTnT aj celkový cTnT s úmrtím z akejkoľvek príčiny, s novou fibriláciou predsiení a so zloženým výsledkom. S MACCE súvisel len celkový cTnT. Long cTnT v týchto modeloch s MACCE spojený nebol. Keď sa úprava o ischemickú chorobu srdca nahradila úpravou o transplantáciu obličky, významnosť súvislostí zoslabla. Ide o asociácie v jednom preddialyzačnom súbore, nie o dôkaz, že meranie long cTnT mení rozhodnutie o liečbe. Štúdia je v registri ClinicalTrials.gov pod číslom NCT04223726. Zápis je spätný, z 10. decembra 2019.</p>

<h2>Kým long cTnT v laboratóriu nie je</h2>

<p>Braghieri a spolupracovníci pre prax bez tejto metódy navrhujú rámec, ktorý treba čítať ako návrh prehľadu, nie ako európsky postup pri bolesti na hrudníku. Jednotlivá hodnota má nízku pozitívnu prediktívnu hodnotu, ak východisková koncentrácia nie je známa. Odporúčajú sledovať vzostup a pokles, pri vysokosenzitívnej súprave počas 3 hodín, pri konvenčnej počas 6 hodín a pri konečnom štádiu choroby obličiek až do 9 hodín, skôr než jedna hodnota alebo zmena za jednu hodinu. Odvolávajú sa pritom na americké národné postupy. Miestny protokol urgentného príjmu tým nahradený nie je.</p>

<p>Ak je východisková koncentrácia už nad 99. percentilom, prehľad pokladá vzostup o 20 % v sérii za primeraný znak pokračujúceho poškodenia myokardu pri podozrení na akútny koronárny syndróm. Pri len miernom zvýšení, v príklade prehľadu pri hs-cTnT pod 20 ng/l, má znepokojovať absolútna zmena väčšia ako 5 ng/l alebo väčšia ako 10 ng/l. Prehľad tiež uvádza, že akútne poškodenie obličiek so vzostupom kreatinínu o 40 až 60 % môže sprevádzať asi 20 % vzostup troponínu a potom pokles. Obraz sa potom podobá infarktu, hoci mechanizmus je iný. Číslo o kreatiníne preberá prehľad z inej práce. Tú som v plnom texte nečítal, preto ju tu nepoužívam ako samostatný dôkaz.</p>

<p>K hodnote patria príznaky a ich čas, zmeny na elektrokardiograme a echokardiografia. Nová elevácia úseku ST pri presvedčivom klinickom obraze vedie na katetrizačnú sálu bez ohľadu na troponín. Prehľad pripomína, že súpravy nie sú zameniteľné a že troponín I býva funkciou obličiek ovplyvnený menej než troponín T. Je to zhrnutie starších pozorovaní, nie výsledok long cTnT. Skorú invazívnu stratégiu pri ťažkej CKD ten istý text neberie ako samozrejmosť a sám uvádza medze registra, o ktorý sa opiera. Algoritmus katetrizácie z neho nepreberám.</p>

<h2>Čo z toho urobiť pri lôžku</h2>

<p>Pri podozrení na akútny koronárny syndróm rozhoduje súlad príznakov, elektrokardiogramu a zobrazovania s dynamikou troponínu. Samotné prekročenie 14 ng/l u človeka s CKD takým súladom nie je.</p>

<p>Ak je long cTnT dostupný, podľa Hellmana od neho netreba čakať rovnakú väzbu na eGFR ako od komerčného hs-cTnT. Diagnostická výhoda v tejto štúdii rástla práve pri horšej filtrácii. Platí to pre súpravu a prahy, ktoré použili autori. Iné protilátky a iná kalibrácia môžu dať iné číslo. Lokálne referenčné medze sa z abstraktu odpísať nedajú.</p>

<p>Prognostický údaj Salonenovej je užší. V preddialyzačnom CKD G4 až G5 long cTnT súvisel s úmrtím a s novou fibriláciou predsiení, nie s MACCE, a súvislosť zoslabla po úprave o transplantáciu. Na ľudí už liečených dialýzou sa tento výsledok preniesť nedá. Vplyv dialýzy a načasovania odberu je podľa prehľadu Braghieriho sporný a štúdia Salonenovej ho neskúmala.</p>

<p>Long cTnT v týchto dátach lepšie odlíšil infarkt tam, kde komerčný hs-cTnT stúpa s klesajúcou filtráciou. Nie je dôvod čakať, že číslo samo vyberie človeka na katetrizáciu.</p>

<h2>Limity</h2>

<p>Tvrdenia o práci Hellmana a o štúdii SuperTROPO stoja na abstraktoch a na bibliografických záznamoch. Plný text som nečítal. Plochy pod krivkou podľa pásiem eGFR zverejnené nie sú. SuperTROPO dáva plochy pre celý súbor so zvýšeným hs-cTnT, nie pre podskupinu s CKD. Salonenová má 136 ľudí, výskumné imunotesty a chýbajúcu väzbu long cTnT na MACCE. Van der Lindenová má 44 ľudí v krátkom liste. Braghieri je naratívny prehľad s americkým časovaním odberov. Long cTnT v týchto prácach nie je súčasťou odporúčania odbornej spoločnosti pre bežnú prax.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani platné odporúčania.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Tapio Hellman, Konsta Teppo, Anna Linko-Parvinen, Hanna-Mari Pallari, Helea Junes, Tuulia Tuominen, Selma Salonen, Tuomas Paana, Samuli Jaakkola, Marjatta Strandberg, Tuija Vasankari, K. E. Juhani Airaksinen, Saara Wittfooth. Long forms of cardiac troponin T are independent of kidney function and improve the diagnosis of myocardial infarction. <em>Nephrology Dialysis Transplantation.</em> Online 16. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. DOI: <a href="https://doi.org/10.1093/ndt/gfag239" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag239</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42886060/" target="_blank" rel="noopener noreferrer">PubMed PMID 42886060</a>.</small></li>
  <li><small>Konsta Teppo, K. E. Juhani Airaksinen, Tuija Vasankari, Anna Linko-Parvinen, Hanna-Mari Pallari, Tuomas Paana, Samuli Jaakkola, Helea Junes, Selma Salonen, Tuulia Tuominen, Sara Simonen, Marjatta Strandberg, Tapio Hellman, Saara Wittfooth. Long forms of cardiac troponin T for myocardial infarction diagnosis: the SuperTROPO study. <em>European Heart Journal.</em> 2026;47(4):490 až 499. Online 5. decembra 2025. DOI: <a href="https://doi.org/10.1093/eurheartj/ehaf975" target="_blank" rel="noopener noreferrer">10.1093/eurheartj/ehaf975</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41579023/" target="_blank" rel="noopener noreferrer">PubMed PMID 41579023</a>.</small></li>
  <li><small>Selma Salonen, Emilia Kaipainen, Markus Hakamäki, Niilo Liuhto, Noora Manni, Tomi Toukola, Jonna Virtanen, Roosa Lankinen, Kaj Metsärinne, Tuija Vasankari, K. E. Juhani Airaksinen, Mikko J. Järvisalo, Saara Wittfooth, Tapio Hellman. Association of long cardiac troponin T forms with adverse long-term outcomes in patients with advanced chronic kidney disease. <em>BMC Nephrology.</em> 2026;27:159. Online 6. februára 2026. DOI: <a href="https://doi.org/10.1186/s12882-026-04803-6" target="_blank" rel="noopener noreferrer">10.1186/s12882-026-04803-6</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41652572/" target="_blank" rel="noopener noreferrer">PubMed PMID 41652572</a>.</small></li>
  <li><small>Noreen van der Linden, Tom Cornelis, Dorien M. Kimenai, Lieke J.J. Klinkenberg, Judith M. Hilderink, Sarah Lück, Elisabeth J. R. Litjens, Frederique E.C.M. Peeters, Alexander S. Streng, Tobias Breidthardt, Luc J.C. van Loon, Otto Bekers, Jeroen P. Kooman, Pål O. Westermark, Christian Mueller, Steven J.R. Meex. Origin of Cardiac Troponin T Elevations in Chronic Kidney Disease. <em>Circulation.</em> 2017;136(11):1073 až 1075. DOI: <a href="https://doi.org/10.1161/CIRCULATIONAHA.117.029986" target="_blank" rel="noopener noreferrer">10.1161/CIRCULATIONAHA.117.029986</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/28893963/" target="_blank" rel="noopener noreferrer">PubMed PMID 28893963</a>.</small></li>
  <li><small>Lorenzo Braghieri, Osamah Z. Badwan, Warren Skoza, Maan Fares, Venu Menon. Evaluating troponin elevation in patients with chronic kidney disease and suspected acute coronary syndrome. <em>Cleveland Clinic Journal of Medicine.</em> 2023;90(8):483 až 489. DOI: <a href="https://doi.org/10.3949/ccjm.90a.23012" target="_blank" rel="noopener noreferrer">10.3949/ccjm.90a.23012</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37527874/" target="_blank" rel="noopener noreferrer">PubMed PMID 37527874</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Autori, poradie, DOI a dátum online publikovania práce Hellmana sú z Crossref k DOI 10.1093/ndt/gfag239. Čísla 1811, 205, 204, mediány eGFR, regresné koeficienty, hodnoty P a veta o rastúcej výhode pri nižšej eGFR sú zo štruktúrovaného abstraktu PubMed PMID 42886060. Plný text tejto práce je uzavretý a v tomto kole sa nečítal. Ročník a strany pridelené neboli. Plochy pod krivkou štúdie SuperTROPO, počty 148 a 0,7 %, prah 3,7 ng/l a názov súpravy Roche Diagnostics sú z abstraktu PubMed PMID 41579023. Bibliografia European Heart Journal, ročník 47, číslo 4, strany 490 až 499 a dátum 5. decembra 2025, je z Crossref k DOI 10.1093/eurheartj/ehaf975. Plný text SuperTROPO sa nečítal. Tieto plochy sa v článku neprenášajú na pásma eGFR. Údaje Salonenovej, vrátane 136, veku, podielu žien, mediánov, sledovania, počtov udalostí, úpravy modelov a vety, že s MACCE súvisel len celkový cTnT, sú z abstraktu PubMed PMID 41652572 a zo stránky vydavateľa k DOI 10.1186/s12882-026-04803-6. Autorský zoznam a článok číslo 159 v ročníku 27 sú z Crossref. Plný text sa nečítal stranu po strane, pomery hazardov abstrakt neuvádza, preto v článku nie sú. Práca van der Lindenovej: autori a strany 1073 až 1075 sú z Crossref, počty 20 a 24, mediány eGFR, amplitúdy, P = 0,53, modelový pokles z 12 % na 8 % a záver o klírense sú z textu práce v inštitucionálnom repozitári. Nie je to veľká kohorta. Prehľad Braghieriho sa čítal v znení na stránke Cleveland Clinic Journal of Medicine, DOI 10.3949/ccjm.90a.23012, strany 483 až 489, PMID 37527874. Časovanie 3, 6 a 9 hodín, prah 20 % pri koncentrácii už nad 99. percentilom, absolútne zmeny 5 a 10 ng/l a veta o vzostupe kreatinínu o 40 až 60 % sú z tohto prehľadu. Primárna práca, z ktorej prehľad berie údaj o kreatiníne, sa nečítala. Predloha zlievala štúdiu Hellmana so SuperTROPO, plochami pod krivkou pre typ 1 a pre akýkoľvek infarkt a s názvom SuperTROPO. Fragmentačný profil pripisovala práci van der Lindenovej, ktorá skúmala denný rytmus a klírens, nie zloženie foriem. Pri Salonenovej zmäkčovala chýbajúcu väzbu long cTnT na MACCE. V bibliografii mala neúplné autorské zoznamy, pri Salonenovej chýbal správny DOI a na konci ostala redakčná poznámka. Do článku neprešla. Autor projektu doplnil oddelenie súborov, hranicu P = 0,050, podmienku 20 % vzostupu a výhradu, že americký časový rámec nenahrádza miestny protokol.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026">Srdcové zlyhávanie a CKD: závery KDIGO konferencie o obojsmernom zaťažení, GDMT a koordinovanej starostlivosti</a></li>
  <li><a href="article.php?slug=esc-era-2026-kardiorenalne-odporucania">Odporúčania ESC/ERA 2026: spoločný plán starostlivosti o srdce a obličky</a></li>
  <li><a href="article.php?slug=progresia-kalcifikacie-koronarnych-arterii-ckd-horcik-pth">Progresia kalcifikácie koronárnych artérií pri zhoršovaní funkcie obličiek: úloha sérového horčíka a parathormónu</a></li>
  <li><a href="article.php?slug=aki-rizikovy-model-starsi-zlyhavanie-srdca">Riziko akútneho poškodenia obličiek u starších hospitalizovaných pacientov so zlyhávaním srdca: model z údajov pri prijatí</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dlhe-formy-troponinu-t-chronicka-choroba-obliciek_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
