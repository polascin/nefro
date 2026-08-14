<?php

/**
 * add_neceliakalna-citlivost-psenica-gluten-fruktany_article.php
 * Odborný článok o diagnostike a liečbe neceliakálnej citlivosti na pšenicu.
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
    'title'        => 'Neceliakálna citlivosť na pšenicu: spúšťačom nemusí byť iba glutén',
    'slug'         => 'neceliakalna-citlivost-psenica-gluten-fruktany',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Neceliakálna citlivosť na pšenicu nemá validovaný biomarker. Príznaky môžu súvisieť s gluténom, fruktánmi, ďalšími zložkami pšenice aj nocebo efektom.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Zlepšenie po vylúčení pšenice samo osebe nepotvrdzuje „gluténovú intoleranciu“. Neceliakálna citlivosť na pšenicu je heterogénny klinický syndróm bez validovaného biomarkera. Uvažovať o nej možno až po riadnom vylúčení celiakie, alergie na pšenicu a iných relevantných ochorení, ideálne ešte počas konzumácie gluténu.</em></p>

<p>Mnohí ľudia opisujú nafukovanie, bolesti brucha, zmenu stolice, únavu alebo „mozgovú hmlu“ po jedle s obsahom pšenice. Po bezgluténovej diéte sa môžu cítiť lepšie, ale súčasne z jedálneho lístka odstránia viacero ďalších látok, zmenia množstvo vlákniny, fermentovateľných sacharidov aj skladbu priemyselne spracovaných potravín. Otvorená eliminačná skúška preto nedokáže určiť, ktorá zmena pomohla.</p>

<p>Najdôležitejšou praktickou chybou je začať bezgluténovú diétu <strong>pred vyšetrením celiakie</strong>. Sérológia aj duodenálna histológia sa môžu po obmedzení gluténu normalizovať a výsledok potom môže byť falošne negatívny.</p>

<h2>Tri odlišné skupiny ochorení</h2>

<p>Ťažkosti súvisiace s pšenicou treba rozdeliť aspoň do troch základných skupín:</p>

<ol>
  <li><strong>Celiakia</strong> je imunitne sprostredkované systémové ochorenie vyvolané gluténom a príbuznými prolamínmi u geneticky predisponovaných osôb. Môže viesť k poškodeniu sliznice tenkého čreva, malabsorpcii a extraintestinálnym komplikáciám.</li>
  <li><strong>Alergia na pšenicu</strong> je najmä IgE sprostredkovaná reakcia, ktorá môže vyvolať urtikáriu, angioedém, bronchospazmus, vracanie, hypotenziu alebo anafylaxiu. Existujú aj iné alergické fenotypy, napríklad profesionálna respiračná alergia či pšenicou a fyzickou námahou podmienená anafylaxia.</li>
  <li><strong>Neceliakálna citlivosť na pšenicu</strong> (NCWS, z angl. <em>non-coeliac wheat sensitivity</em>) označuje reprodukovateľné črevné alebo mimočrevné ťažkosti po pšenici u človeka bez potvrdenej celiakie a alergie na pšenicu, po vylúčení významných organických gastrointestinálnych ochorení.</li>
</ol>

<p>V literatúre sa používajú aj skratky NCGS a NCGWS. Označenie „citlivosť na pšenicu“ je biologicky opatrnejšie než „gluténová senzitivita“, pretože glutén nemusí byť jediným ani hlavným spúšťačom.</p>

<h2>Ako častý je tento problém</h2>

<p>Metaanalýza publikovaná v roku 2025 zahrnula 25 štúdií so 49 476 účastníkmi zo 16 krajín. Subjektívnu citlivosť na glutén alebo pšenicu uvádzalo súhrnne 10,3 % populácie (95 % interval spoľahlivosti 7,0 až 14,0 %). Ide však o <strong>vlastné hlásenie príznakov</strong>, nie o prevalenciu objektívne potvrdenej NCWS.</p>

<p>Rozdiel je klinicky podstatný. V systematickom prehľade dvojito zaslepených, placebom kontrolovaných provokácií malo medzi 231 osobami s kvalitatívne vyhodnotiteľným výsledkom iba 16 % príznaky špecifické pre glutén. Až 40 % reagovalo rovnako alebo výraznejšie na placebo. Staršie štúdie pritom používali rozdielne dávky gluténu, trvanie skúšky aj zloženie placeba, preto čísla nemožno považovať za univerzálnu diagnostickú pravdepodobnosť.</p>

<h2>Čo môže byť skutočným spúšťačom</h2>

<h3>Glutén</h3>

<p>Glutén je komplex zásobných proteínov pšenice. Pri celiakii je jeho úloha presne definovaná. Pri NCWS sa špecifická reakcia na glutén u časti pacientov nedá vylúčiť, chýba však jednotný mechanizmus aj reprodukovateľný diagnostický marker. Výsledky zaslepených provokačných štúdií sú heterogénne.</p>

<h3>Fruktány</h3>

<p>Pšenica obsahuje fruktány, fermentovateľné oligosacharidy zo skupiny FODMAP. V tenkom čreve sa vstrebávajú neúplne, zvyšujú osmotické zaťaženie a v hrubom čreve podliehajú bakteriálnej fermentácii. U citlivého človeka môžu zvyšovať tvorbu plynov, distenziu, bolesť a meniť stolicu.</p>

<p>V randomizovanej dvojito zaslepenej skríženej štúdii u ľudí so samostatne udávanou neceliakálnou gluténovou senzitivitou vyvolali fruktány viac gastrointestinálnych príznakov než glutén; medzi gluténom a placebom sa významný rozdiel nepreukázal. Jedna štúdia však nevysvetľuje všetky fenotypy NCWS a fruktánová intolerancia nie je synonymom citlivosti na pšenicu.</p>

<h3>Inhibítory amylázy a trypsínu</h3>

<p>Pšeničné inhibítory amylázy a trypsínu (ATI) sú proteíny odolné proti tráveniu. Experimentálne práce im pripisovali aktiváciu vrodenej imunity cez komplex TLR4-MD2-CD14. Klinická kauzalita u človeka však nie je potvrdená. Práca z roku 2025 navyše ukázala, že väčšina signálu TLR4 v skúmanej frakcii mohla pochádzať z kontaminácie lipopolysacharidom. ATI preto zostávajú zaujímavou hypotézou, nie rutinne preukázaným spúšťačom.</p>

<h3>Interakcia čreva a mozgu</h3>

<p>Klinický obraz sa výrazne prekrýva so syndrómom dráždivého čreva a ďalšími poruchami interakcie čreva a mozgu. Viscerálna hypersenzitivita, motilita, pozornosť venovaná telesným podnetom a očakávanie reakcie môžu meniť intenzitu príznakov.</p>

<p>V randomizovanej štúdii so 84 účastníkmi mala kombinácia očakávania gluténu a jeho skutočnej konzumácie najväčší vplyv na gastrointestinálne ťažkosti. Výsledok podporuje význam nocebo efektu, hoci dodatočný biologický účinok gluténu nevylučuje. <strong>Nocebo neznamená simulovanie:</strong> príznaky sú reálne, iba ich mechanizmus nemusí byť špecifickou toxickou reakciou na glutén.</p>

<h2>Klinický obraz a varovné príznaky</h2>

<p>NCWS nemá patognomický príznak. Najčastejšie sa opisujú:</p>

<ul>
  <li>nafukovanie, meteorizmus a bolesti brucha,</li>
  <li>hnačka, zápcha alebo striedanie konzistencie stolice,</li>
  <li>dyspepsia, nauzea a epigastrická bolesť,</li>
  <li>únava, bolesti hlavy a subjektívne spomalenie myslenia,</li>
  <li>bolesti svalov alebo kĺbov a nešpecifické kožné ťažkosti.</li>
</ul>

<p>Mimočrevné prejavy majú bez reprodukovateľného časového vzťahu k pšenici nízku diagnostickú špecificitu. Nasledujúce nálezy naopak vyžadujú širšie a často urýchlené vyšetrenie:</p>

<ul>
  <li>neúmyselný úbytok hmotnosti, gastrointestinálne krvácanie alebo významná anémia,</li>
  <li>dysfágia, opakované vracanie, nočné príznaky alebo pretrvávajúca horúčka,</li>
  <li>hypoalbuminémia, závažná či chronická hnačka a známky malabsorpcie,</li>
  <li>nový vznik ťažkostí vo vyššom veku,</li>
  <li>rodinná anamnéza celiakie, zápalového ochorenia čreva alebo gastrointestinálneho nádoru.</li>
</ul>

<h2>Diagnostika krok za krokom</h2>

<h3>1. Najprv zdokumentovať stravu a príznaky</h3>

<p>Treba zistiť konkrétne jedlá, množstvo, latenciu, trvanie a reprodukovateľnosť ťažkostí. Dôležité je odlíšiť okamžitú alergickú reakciu od neskorších gastrointestinálnych príznakov a overiť, či pacient stále pravidelne konzumuje glutén.</p>

<h3>2. Vylúčiť celiakiu ešte počas konzumácie gluténu</h3>

<p>Prvou voľbou u väčšiny dospelých je stanovenie <strong>IgA protilátok proti tkanivovej transglutamináze 2 (anti-TG2)</strong> spolu s celkovou koncentráciou IgA. Pri deficite IgA sa používajú validované testy triedy IgG, najmä IgG anti-TG2 alebo IgG proti deamidovaným gliadínovým peptidom.</p>

<p>Duodenálna histológia zostáva referenčnou diagnostickou metódou. Európske odporúčanie ESsCD 2025 však podmienečne pripúšťa nebioptický postup u vybraných dospelých mladších ako 45 rokov, ak koncentrácia IgA anti-TG2 dosahuje najmenej desaťnásobok hornej hranice normy a výsledok sa potvrdí z druhej vzorky. Rozhodnutie patrí do sekundárnej gastroenterologickej starostlivosti, nevzťahuje sa na pacientov s varovnými príznakmi a pacient musí až do potvrdenia diagnózy pokračovať v konzumácii gluténu.</p>

<p>Pri nižších titroch alebo nejasnom náleze sa diagnóza spravidla potvrdzuje gastroskopiou s viacerými biopsiami z bulbu aj distálnejšieho duodéna. Samotné zlepšenie po diéte celiakiu nepotvrdzuje ani nevylučuje.</p>

<h3>3. Ak pacient už glutén vylúčil</h3>

<p>Negatívna sérológia po dlhšej bezgluténovej diéte nemá dostatočnú výpovednú hodnotu. HLA-DQ2/DQ8 genotypizácia nie je vhodným prvým skríningovým testom, ale v tejto situácii môže pomôcť: negatívny výsledok robí celiakiu prakticky vylúčenou, pozitívny ju pre nízku špecificitu nepotvrdzuje.</p>

<p>Ak je diagnostické potvrdenie potrebné, ESsCD 2025 odporúča u dospelých po spoločnom rozhodnutí zvážiť najmenej <strong>3 g gluténu denne počas 6 týždňov</strong>; vyššia dávka alebo dlhšie trvanie zvyšujú diagnostickú presnosť, ak ich pacient toleruje. Preferovaným cieľom je duodenálna histológia. Režim treba individualizovať a viesť gastroenterológom. Pôvodný údaj o „46 týždňoch“ v zdrojovom texte bol redakčnou chybou, nie platným odporúčaním.</p>

<h3>4. Vylúčiť alergiu na pšenicu</h3>

<p>Na IgE sprostredkovanú alergiu treba myslieť najmä pri rýchlom vzniku urtikárie, angioedému, rinokonjunktivitídy, bronchospazmu, vracania, hypotenzie alebo anafylaxie. Diagnostika vychádza z alergologickej anamnézy, kožných testov a špecifických IgE; samotná senzibilizácia bez zodpovedajúcej klinickej reakcie alergiu nepotvrdzuje.</p>

<p>Pri podozrení na pšenicou a fyzickou námahou podmienenú anafylaxiu môže byť užitočné IgE proti omega-5 gliadínu (Tri a 19). Výber komponentov sa riadi fenotypom, nejde o povinný panel pri každej nešpecifickej reakcii na pšenicu. Provokačný test pri riziku systémovej reakcie patrí výhradne na špecializované pracovisko.</p>

<h3>5. Zvážiť alternatívne diagnózy</h3>

<p>Podľa klinického obrazu treba pátrať po syndróme dráždivého čreva, laktózovej alebo inej sacharidovej intolerancii, zápalovom ochorení čreva, mikroskopickej kolitíde, infekcii, exokrinnej insuficiencii pankreasu, poruche štítnej žľazy, eozinofilovom gastrointestinálnom ochorení, malabsorpcii, nežiaducich účinkoch liekov alebo malignite.</p>

<h3>6. Až potom eliminačná a provokačná skúška</h3>

<p>Po vylúčení celiakie, alergie a relevantných organických ochorení možno vykonať približne šesťtýždňovú štruktúrovanú eliminačnú fázu. Ešte pred ňou treba vybrať hlavné príznaky a jednotný spôsob ich hodnotenia. Počas skúšky sa nemá súčasne meniť viacero ďalších faktorov.</p>

<p>Salernské kritériá navrhujú u respondérov dvojito zaslepenú, placebom kontrolovanú skríženú provokáciu. Je metodicky najspoľahlivejšia, no v bežnej ambulancii ťažko realizovateľná a samotný protokol má limity. Praktickou alternatívou je vopred naplánované otvorené opätovné zaradenie pšenice s denníkom príznakov, podľa možnosti opakované. Takáto skúška pomáha pri rozhodovaní o diéte, ale nie je definitívnym dôkazom mechanizmu.</p>

<h2>Čo na diagnostiku nepoužívať</h2>

<p>NCWS v súčasnosti nemá validovaný krvný, stolicový, genetický ani histologický biomarker. Na rutinné potvrdenie diagnózy nie sú vhodné:</p>

<ul>
  <li>panely potravinových IgG alebo IgG4 protilátok,</li>
  <li>staršie protilátky proti natívnemu gliadínu ako izolovaný test,</li>
  <li>komerčné meranie „sérového zonulínu“,</li>
  <li>spotrebiteľské analýzy črevného mikrobiómu,</li>
  <li>neštandardizované testy „črevnej priepustnosti“.</li>
</ul>

<p>Potravinové IgG najčastejšie odrážajú kontakt s potravinou a imunologickú toleranciu, nie patologickú intoleranciu. Ich použitie môže viesť k zbytočne rozsiahlym eliminačným diétam.</p>

<h2>Liečba: najmenšia účinná reštrikcia</h2>

<p>Na rozdiel od potvrdenej celiakie nie je pri NCWS dokázaná potreba absolútnej celoživotnej eliminácie stopových množstiev gluténu. Cieľom je <strong>najmenej reštriktívna strava, ktorá reprodukovateľne kontroluje príznaky a zostáva nutrične primeraná</strong>. Potrebu aj rozsah obmedzenia treba pravidelne prehodnocovať kontrolovanou reintrodukciou.</p>

<p>Ak obraz pripomína syndróm dráždivého čreva alebo sa podozrenie sústreďuje na fruktány, môže pomôcť riadený nízko-FODMAP postup. Plná reštrikčná fáza má byť časovo obmedzená, spravidla na 2 až 6 týždňov. Pri zlepšení nasleduje systematické opätovné zavádzanie jednotlivých skupín FODMAP a dlhodobá personalizácia, ideálne pod vedením nutričného terapeuta.</p>

<p>Neodborne zostavená bezgluténová diéta môže znížiť príjem vlákniny, folátu, tiamínu, železa a ďalších mikronutrientov. Priemyselné bezgluténové výrobky môžu mať viac cukru, tuku, sodíka alebo fosfátových aditív a menej vlákniny. Označenie „bez gluténu“ preto nie je synonymom výživovej kvality.</p>

<h2>Nefrologické súvislosti</h2>

<h3>Celiakia, IgA nefropatia a bezgluténová diéta</h3>

<p>Celiakia sa v observačných prácach spája s niektorými renálnymi ochoreniami vrátane IgA nefropatie. Asociácia však neznamená, že glutén je všeobecnou príčinou primárnej IgA nefropatie. Aktuálne odporúčanie KDIGO 2025 bezgluténovú diétu medzi štandardnú liečbu IgA nefropatie nezaraďuje. Je indikovaná pri súčasne potvrdenej celiakii, nie ako empirická nefroprotektívna intervencia.</p>

<h3>Anémia</h3>

<p>Deficit železa môže byť prvým prejavom celiakie aj bez výrazných gastrointestinálnych príznakov. Anémia pri chronickej chorobe obličiek (CKD) býva multifaktoriálna. Pred jej automatickým pripísaním CKD treba podľa kontextu posúdiť zásoby železa, krvné straty, celiakiu, deficit vitamínu B12 alebo folátu, zápal, hemolýzu a hematologické ochorenie.</p>

<h3>Eliminačná diéta pri CKD</h3>

<p>Kombinácia renálnych a bezgluténových obmedzení môže neprimerane zúžiť jedálny lístok a zvýšiť riziko nedostatočného príjmu energie, proteínovo-energetickej malnutrície, sarkopénie, zápchy a mikronutričných deficitov. Plán musí zohľadniť štádium CKD, albuminúriu, draslík, fosfor, acidobázickú rovnováhu, diabetes, telesnú kompozíciu a prípadnú dialýzu. Paušálne vylučovanie celozrnných obilnín, strukovín, ovocia a zeleniny bez konkrétnej indikácie nie je vhodné.</p>

<h2>Praktický ambulantný algoritmus</h2>

<ol>
  <li>Presne zdokumentovať jedlo, dávku, latenciu a charakter príznakov.</li>
  <li>Overiť, či pacient stále konzumuje glutén.</li>
  <li>Ešte pred elimináciou vyšetriť celiakiu pomocou IgA anti-TG2 a celkového IgA.</li>
  <li>Pri okamžitej alebo systémovej reakcii zabezpečiť alergologické vyšetrenie.</li>
  <li>Aktívne pátrať po varovných znakoch a alternatívnych diagnózach.</li>
  <li>Až po vylúčení celiakie a alergie zaviesť časovo obmedzenú eliminačnú skúšku.</li>
  <li>Odpoveď objektivizovať rovnakou škálou alebo denníkom.</li>
  <li>Vykonať plánovanú reintrodukciu a podľa možností ju zopakovať.</li>
  <li>Pri podozrení na fruktány zvážiť trojfázový nízko-FODMAP postup.</li>
  <li>Pri dlhšom obmedzení kontrolovať nutričnú primeranosť, pri CKD osobitne dôsledne.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Neceliakálna citlivosť na pšenicu je klinicky použiteľné označenie pre pravdepodobne viacero odlišných fenotypov. U niektorých ľudí môže byť spúšťačom glutén, u iných fruktány, ďalšie zložky pšenice, porucha interakcie čreva a mozgu alebo kombinácia biologických mechanizmov a očakávania.</p>

<p>Správny diagnostický záver preto nie je „pacientovi je lepšie bez chleba, teda netoleruje glutén“. Najprv treba počas konzumácie gluténu vylúčiť celiakiu, podľa fenotypu alergiu na pšenicu a následne významné organické ochorenia. Až potom má zmysel štruktúrovaná eliminácia s kontrolovaným opätovným zaradením.</p>

<p>Dlhodobým cieľom nie je čo najprísnejšia diéta, ale čo najpresnejšie určenie tolerancie pri zachovaní pestrej a nutrične primeranej stravy. Pri CKD je tento princíp obzvlášť dôležitý, pretože kumulácia reštrikcií môže byť nebezpečnejšia než samotná podozrivá potravina.</p>
</div>

<div class="pdf-avoid-break">
<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">IgA nefropatia podľa KDIGO 2025 a komentára KDOQI</a> – aktuálna nefroprotektívna a imunologická liečba.</li>
  <li><a href="article.php?slug=vyssi-prijem-bielkovin-merana-gfr-renis">Vyšší príjem bielkovín a funkcia obličiek</a> – interpretácia výživových údajov bez paušálnych zákazov.</li>
  <li><a href="article.php?slug=kreatin-ochorenia-obliciek-bezpecnost-benefit">Kreatín v ochoreniach obličiek</a> – kritické hodnotenie doplnku a renálnych rizík.</li>
</ul>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Medscape Professional Network; Univadis Italy.</strong> <em>Wheat Sensitivity: Is Gluten the Only Trigger?</em> Medscape. 2026. Individuálny autor nebol vo verejne dostupnom zobrazení spoľahlivo uvedený. <a href="https://www.medscape.com/viewarticle/wheat-sensitivity-gluten-only-trigger-2026a1000rnd" target="_blank" rel="noopener noreferrer">Východiskový odborný článok</a>.</li>
  <li><strong>Al-Toma A, Volta U, Auricchio R, et al.</strong> <em>European Society for the Study of Coeliac Disease 2025 Updated Guidelines on the Diagnosis and Management of Coeliac Disease in Adults. Part 1: Diagnostic Approach.</em> United European Gastroenterol J. 2025. doi: 10.1002/ueg2.70119. <a href="https://doi.org/10.1002/ueg2.70119" target="_blank" rel="noopener noreferrer">Odporúčanie ESsCD 2025</a>.</li>
  <li><strong>Shiha MG, Manza F, Figueroa-Salcido OG, et al.</strong> <em>Global prevalence of self-reported non-coeliac gluten and wheat sensitivity: a systematic review and meta-analysis.</em> Gut. 2025. doi: 10.1136/gutjnl-2025-336304. <a href="https://pubmed.ncbi.nlm.nih.gov/41151790/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Molina-Infante J, Carroccio A.</strong> <em>Suspected Nonceliac Gluten Sensitivity Confirmed in Few Patients After Gluten Challenge in Double-Blind, Placebo-Controlled Trials.</em> Clin Gastroenterol Hepatol. 2017;15(3):339–348. doi: 10.1016/j.cgh.2016.08.007. <a href="https://pubmed.ncbi.nlm.nih.gov/27523634/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Skodje GI, Sarna VK, Minelle IH, et al.</strong> <em>Fructan, Rather Than Gluten, Induces Symptoms in Patients With Self-Reported Non-Celiac Gluten Sensitivity.</em> Gastroenterology. 2018;154(3):529–539.e2. doi: 10.1053/j.gastro.2017.10.040. <a href="https://pubmed.ncbi.nlm.nih.gov/29102613/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>de Graaf MCG, Lawton CL, Croden F, et al.</strong> <em>The effect of expectancy versus actual gluten intake on gastrointestinal and extra-intestinal symptoms in non-coeliac gluten sensitivity.</em> Lancet Gastroenterol Hepatol. 2024;9(2):110–123. doi: 10.1016/S2468-1253(23)00317-5. <a href="https://pubmed.ncbi.nlm.nih.gov/38040019/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Catassi C, Elli L, Bonaz B, et al.</strong> <em>Diagnosis of Non-Celiac Gluten Sensitivity (NCGS): The Salerno Experts' Criteria.</em> Nutrients. 2015;7(6):4966–4977. doi: 10.3390/nu7064966. <a href="https://pubmed.ncbi.nlm.nih.gov/26096570/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Krouch D, Vreeke GJC, America AHP, et al.</strong> <em>Amylase trypsin inhibitors activation of toll-like receptor 4 revisited: The dominance of lipopolysaccharides contamination.</em> Int J Biol Macromol. 2025;310(Pt 4):143378. doi: 10.1016/j.ijbiomac.2025.143378. <a href="https://pubmed.ncbi.nlm.nih.gov/40288707/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Santos AF, Riggioni C, Agache I, et al.</strong> <em>EAACI guidelines on the diagnosis of IgE-mediated food allergy.</em> Allergy. 2023;78(12):3057–3076. doi: 10.1111/all.15902. <a href="https://pubmed.ncbi.nlm.nih.gov/37815205/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>American Academy of Allergy, Asthma &amp; Immunology.</strong> <em>The Myth of IgG Food Panel Testing.</em> Aktualizované v roku 2026. <a href="https://www.aaaai.org/tools-for-the-public/conditions-library/allergies/igg-food-test" target="_blank" rel="noopener noreferrer">AAAAI</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes.</strong> <em>KDIGO 2025 Clinical Practice Guideline for the Management of IgA Nephropathy and IgA Vasculitis.</em> Kidney Int. 2025;108(Suppl 4S):S1–S71. <a href="https://kdigo.org/guidelines/iga-nephropathy/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(Suppl 4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO 2024</a>.</li>
</ol>
</div>

<p><em><strong>Poznámka k interpretácii:</strong> Článok bol vecne overený podľa európskeho odporúčania ESsCD 2025, odborných alergologických odporúčaní, primárnych provokačných štúdií a aktuálnych nefrologických odporúčaní. Východiskový článok Medscape je sekundárny klinický prehľad a jeho chybný údaj „46 týždňov“ bol nahradený aktuálnym režimom gluténovej provokácie pre dospelých. Diagnostika aj diétna intervencia sa musia prispôsobiť veku, závažnosti príznakov, nutričnému stavu a miestnym odborným postupom.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_neceliakalna-citlivost-psenica-gluten-fruktany_article',
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
