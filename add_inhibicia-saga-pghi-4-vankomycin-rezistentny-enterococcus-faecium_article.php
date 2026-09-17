<?php
/**
 * Odborný komentár: inhibícia SagA a pghi-4 pri VREfm.
 * Vecná a slovenská jazyková revízia: 12. september 2026.
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
    'title'        => 'Inhibícia SagA môže zvýšiť účinok vankomycínu proti rezistentnému Enterococcus faecium',
    'slug'         => 'inhibicia-saga-pghi-4-vankomycin-rezistentny-enterococcus-faecium',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Experimentálna látka pghi-4 zvyšuje aktivitu vankomycínu proti VREfm. Čo ukázala predklinická štúdia a aké otázky účinnosti a renálnej bezpečnosti zostávajú otvorené?',
    'content'      => <<<'HTML'
<p><strong>Inhibícia prestavby bakteriálnej bunkovej steny môže posilniť účinok antibiotika, voči ktorému je mikroorganizmus rezistentný. Štúdia publikovaná v júni 2026 v časopise Nature Communications ukazuje takýto účinok experimentálnej látky pghi-4 v kombinácii s vankomycínom proti vankomycín-rezistentnému Enterococcus faecium. Ide o predklinický výskum: zatiaľ nepreukazuje účinnosť ani bezpečnosť tejto kombinácie u pacientov.</strong> <a href="#zdroj-1">[1]</a> </p>

<p>Pre nefrológiu je tento výskumný smer významný najmä v súvislosti s infekciami u dialyzovaných a transplantovaných pacientov. Prípadné rozšírenie účinnosti vankomycínu by však samo osebe neodstránilo jeho nefrotoxický potenciál. Pri novej látke treba ešte charakterizovať farmakokinetiku, toxicitu aj správanie pri poruche funkcie obličiek.</p>

<div class="pdf-avoid-break">
<h2>Prečo je VREfm klinicky dôležitý</h2>
<p>Enterokoky môžu byť súčasťou črevnej mikrobioty bez toho, aby vyvolávali ochorenie. Pri narušení slizničnej bariéry, imunosupresii alebo prítomnosti invazívnych pomôcok však môžu spôsobovať závažné infekcie. Druhy <em>Enterococcus faecalis</em> a <em>Enterococcus faecium</em> sa líšia epidemiológiou aj profilom rezistencie. Skratka <strong>VREfm</strong> označuje výlučne vankomycín-rezistentný <em>E. faecium</em>, nie všetky vankomycín-rezistentné enterokoky. <a href="#zdroj-2">[2]</a> <a href="#zdroj-3">[3]</a> </p>
</div>

<p>Nemocničné línie <em>E. faecium</em> bývajú rezistentné na viaceré antibiotiká vrátane ampicilínu. Môžu vyvolať bakteriémiu, infekcie súvisiace s katétrami, intraabdominálne infekcie aj endokarditídu. Biofilm na cudzorodom materiáli môže prispievať k pretrvávaniu infekcie. WHO zaradila VREfm v zozname z roku 2024 medzi patogény s <strong>vysokou prioritou</strong> pre výskum a vývoj nových antibiotík. <a href="#zdroj-2">[2]</a> <a href="#zdroj-4">[4]</a> </p>

<p>Nefrologickí pacienti môžu mať súčasne viacero rizikových expozícií: opakované hospitalizácie, antibiotickú liečbu, cievne vstupy a po transplantácii dlhodobú imunosupresiu. <strong>Samotná kolonizácia VRE nie je indikáciou na antibiotickú liečbu.</strong> Pozitívny skríningový nález treba odlíšiť od infekcie podľa miesta odberu, klinických prejavov a ďalších vyšetrení. Kolonizácia je pritom dôležitá pre prevenciu prenosu v zdravotníckom zariadení. <a href="#zdroj-5">[5]</a> </p>

<div class="pdf-avoid-break">
<h2>Ako rezistencia mení účinok vankomycínu</h2>
<p>Vankomycín sa viaže na zakončenie <strong>D-alanyl-D-alanín (D-Ala-D-Ala)</strong> v prekurzoroch peptidoglykánu a bráni správnej syntéze bunkovej steny. Pri rezistencii typu VanA alebo VanB baktéria vytvára prekurzory zakončené D-Ala-D-laktátom. Táto zmena výrazne oslabuje väzbu antibiotika; afinita k takto zmenenému cieľu klesá približne o tri rády. <a href="#zdroj-2">[2]</a> <a href="#zdroj-3">[3]</a> </p>
</div>

<p>Nejde o jednoduché mechanické „odpudzovanie“ antibiotika. Menia sa vodíkové väzby a ďalšie interakcie vo väzbovom mieste. Ani následok inhibície syntézy bunkovej steny nemožno zovšeobecniť na okamžité usmrtenie baktérie: enterokoky môžu vykazovať toleranciu k baktericídnemu pôsobeniu antibiotík. Zastavenie rastu a usmrtenie mikroorganizmu sú odlišné výsledky. <a href="#zdroj-2">[2]</a> <a href="#zdroj-3">[3]</a> </p>

<div class="pdf-avoid-break">
<h2>SagA ako cieľ antibiotického adjuvans</h2>
<p>SagA, z anglického <em>secreted antigen A</em>, je peptidoglykánová hydroláza z rodiny NlpC/P60. Podieľa sa na prestavbe bunkovej steny a oddeľovaní dcérskych buniek. Genetické odstránenie <em>sagA</em> v skúmanom kmeni VREfm narušilo rast a delenie buniek a zvýšilo väzbu fluorescenčne označeného vankomycínu. Genetická výbava pre rezistenciu typu VanA pritom zostala zachovaná. <a href="#zdroj-1">[1]</a> </p>
</div>

<p>Ovplyvnenie SagA teda nie je totožné s odstránením génov rezistencie <em>van</em> ani s úplným návratom všetkých prekurzorov bunkovej steny k D-Ala-D-Ala. Výsledky podporujú úlohu prestavby peptidoglykánu vo výslednom rezistentnom fenotype. Účinok úplného odstránenia génu však nemožno automaticky stotožniť s účinkom jeho dočasnej farmakologickej inhibície. <a href="#zdroj-1">[1]</a> </p>

<p>Výskumníci preverili knižnicu <strong>616 zlúčenín</strong> pripravených pomocou click chémie a následnými testami identifikovali päť kovalentných inhibítorov peptidoglykánových hydroláz. Látka pghi-4 patrí medzi β-chlóroalkenylsulfonylfluoridy. Najvýraznejšie sa uplatnila v následných testoch kombinácie s vankomycínom; to neznamená, že mala najnižšiu biochemickú IC<sub>50</sub> zo všetkých inhibítorov. <a href="#zdroj-1">[1]</a> </p>

<p>Tvorbu kovalentného aduktu s katalytickým cysteínom SagA podporili výsledky hmotnostnej spektrometrie. Po 16 hodinách sa množstvo aduktu znižovalo a pribúdali produkty hydrolýzy. <strong>Pghi-4 navyše inhibovala aj príbuznú hydrolázu PGH2.</strong> Účinok preto nemožno pripísať výlučne selektívnej inhibícii SagA. Pre vývoj liečiva bude rozhodujúce určiť trvanie inhibície, ďalšie bakteriálne ciele a prípadné interakcie s ľudskými proteínmi. <a href="#zdroj-1">[1]</a> </p>

<p>Vankomycín zostáva v tejto kombinácii chemicky nezmenený. Pghi-4 má úlohu <strong>antibiotického adjuvans</strong> – pomocnej látky zvyšujúcej účinok antibiotika. Toto označenie samo osebe nevypovedá o jej bezpečnosti.</p>

<div class="pdf-avoid-break">
<h2>Čo znamená osemnásobný pokles MIC</h2>
<p>V kombinovanom mikrodilučnom teste s kmeňom ERV165 sa minimálna inhibičná koncentrácia (MIC) vankomycínu pri pghi-4 znížila až osemnásobne, v závislosti od koncentrácie inhibítora. Zlepšenie aktivity sa pozorovalo aj pri geneticky odlišných klinických izolátoch, jeho veľkosť však nebola rovnaká. <a href="#zdroj-1">[1]</a> </p>
</div>

<p>MIC je najnižšia koncentrácia antibiotika, ktorá za definovaných podmienok zabráni viditeľnému rastu baktérie. Jej pokles je potrebné odlíšiť od obnovenia klinickej kategórie citlivosti, baktericídneho účinku a napokon od vyliečenia pacienta. Na posúdenie kombinácie sú potrebné aj koncentrácie oboch látok, časový priebeh účinku a dosiahnuteľná expozícia.</p>

<div class="pdf-avoid-break">
<h3>Ilustračný výpočet a aktuálne hranice EUCAST</h3>
<p>Ak by východisková MIC bola 256 mg/l, osemnásobný pokles by znamenal <strong>256 ÷ 8 = 32 mg/l</strong>. Na pokles z 256 na 2 mg/l by bolo potrebné 128-násobné zníženie. Ide o vysvetľujúci príklad, nie o opis východiskovej MIC všetkých izolátov v štúdii.</p>
</div>

<p>EUCAST vo verzii <strong>16.1, platnej od 24. júna 2026</strong>, uvádza pre vankomycín a <em>E. faecalis/E. faecium</em> hranice <strong>S ≤ 4 mg/l a R &gt; 4 mg/l</strong>. Hodnota 32 mg/l teda zodpovedá rezistencii; hodnota 2 mg/l patrí pri štandardnom vyšetrení do kategórie citlivosti. Pre experimentálnu kombináciu s pghi-4 však tieto hranice nie sú validovaným potvrdením klinickej účinnosti. <a href="#zdroj-6">[6]</a> </p>

<p>Samotný násobok poklesu MIC neoprávňuje označiť všetky pôvodne rezistentné izoláty za klinicky citlivé. Rovnako neukazuje, či sa potrebná koncentrácia inhibítora dá u človeka bezpečne dosiahnuť.</p>

<div class="pdf-avoid-break">
<h2>Čo preukázal pokus na myšiach</h2>
<p>V kombinovanom liečebnom experimente výskumníci podali myšiam intraperitoneálne baktérie aj skúmanú liečbu súčasne. Použili vankomycín v dávke 100 mg/kg a pghi-4 v dávke 25 mg/kg; druhú dávku podali o 24 hodín. Počas 48-hodinového sledovania kombinácia zmiernila úbytok hmotnosti a znížila počet kultivovateľných baktérií v pečeni a slezine oproti kontrolnej skupine. Samostatné látky nemali významný účinok na bakteriálnu nálož v orgánoch. <a href="#zdroj-1">[1]</a> </p>
</div>

<p>V jednotlivých skupinách bolo šesť myší. Rozdelenie bolo náhodné, zber a analýza údajov však neboli zaslepené. Jednodávkový režim v skorších časových bodoch významne neznížil počet baktérií v orgánoch. Výsledok preto treba viazať na konkrétny dvojdávkový protokol a jeho krátke sledovanie. <a href="#zdroj-1">[1]</a> </p>

<p><strong>Začatie liečby súčasne s infekciou neoveruje záchrannú liečbu už rozvinutej sepsy.</strong> Pokles bakteriálnej nálože a menší úbytok hmotnosti tiež nie sú dôkazom zníženia mortality, sterilizácie orgánov či účinnosti pri endokarditíde a katétrovom biofilme. Dávky v mg/kg nemožno priamo prenášať z myši na človeka: rozhodujú dosiahnuté koncentrácie, spôsob podania a druhové rozdiely vo farmakokinetike.</p>

<div class="pdf-avoid-break">
<h2>Rozšírený gén nezaručuje univerzálny účinok</h2>
<p>Gén <em>sagA</em> bol prítomný vo všetkých 559 analyzovaných genómoch <em>E. faecium</em> z 99 sekvenčných typov. Súbor však nezahŕňal len VREfm: tvorilo ho 395 genotypovo vankomycín-rezistentných a 164 genotypovo citlivých izolátov. Tento výsledok podporuje rozšírenosť cieľa v rámci druhu, nie rovnakú liečebnú odpoveď každého izolátu. <a href="#zdroj-1">[1]</a> </p>
</div>

<p>Účinok môžu meniť expresia SagA, ďalšie hydrolázy, rastové podmienky, biofilm aj mechanizmy rezistencie. Prítomnosť génu preto nenahrádza mikrobiologické testovanie. Výsledky nemožno automaticky rozšíriť na <em>E. faecalis</em> ani vykladať ako dôkaz, že proti inhibítoru nevznikne rezistencia.</p>

<div class="pdf-avoid-break">
<h2>Čo ešte chýba pred klinickým použitím</h2>
<p>Nasledujúce otázky predstavujú požiadavky na ďalší vývoj, nie už preukázané vlastnosti pghi-4:</p>
</div>
<ul>
<li><strong>Selektivita a reprodukovateľnosť:</strong> určiť podiel jednotlivých bakteriálnych cieľov na účinku a potvrdiť výsledky nezávislými experimentmi.</li>
<li><strong>Farmakokinetika a farmakodynamika:</strong> charakterizovať absorpciu, distribúciu, väzbu na bielkoviny, metabolizmus, elimináciu a potrebné súčasné expozície oboch látok v ložisku infekcie.</li>
<li><strong>Bezpečnosť:</strong> preskúmať toxicitu opakovaného podávania vrátane účinkov na obličky, pečeň, krvotvorbu, ľudské proteíny a mikrobiotu. Obmedzené testy cytotoxicity nenahrádzajú toxikologický program.</li>
<li><strong>Realistickejšie infekčné modely:</strong> overiť oneskorené začatie liečby, dlhšie sledovanie a infekcie s vysokou bakteriálnou náložou alebo biofilmom.</li>
<li><strong>Vznik rezistencie:</strong> merať frekvenciu a mechanizmy úniku pred účinkom kombinácie aj biologické dôsledky adaptačných zmien.</li>
<li><strong>Prínos pre pacienta:</strong> v primerane navrhnutých klinických skúšaniach porovnať bezpečnosť, klinické vyliečenie, relapsy a podľa indikácie mortalitu s vhodnou štandardnou liečbou.</li>
</ul>

<div class="pdf-avoid-break">
<h2>Nefrologický pohľad: expozícia a bezpečnosť</h2>
<p>Vankomycín sa významne eliminuje obličkami. Jeho dávkovanie a monitorovanie musia zohľadňovať funkciu obličiek, jej zmeny v čase, klinický stav a spôsob náhrady funkcie obličiek. Nadmerná expozícia zvyšuje riziko akútneho poškodenia obličiek. Pridanie adjuvans nie je samo osebe dôkazom zníženia tohto rizika. <a href="#zdroj-7">[7]</a> </p>
</div>

<p>Odporúčania z roku 2020 pre závažné infekcie spôsobené MRSA uprednostňujú monitorovanie vankomycínu podľa plochy pod krivkou koncentrácie v čase (AUC). <strong>Expozičné ciele odvodené pre MRSA nemožno bez validácie preniesť na vankomycín s pghi-4 proti VREfm.</strong> Ani vysokú MIC nemožno bezmedzne kompenzovať zvyšovaním dávky vankomycínu. <a href="#zdroj-7">[7]</a> </p>

<p>Pri pghi-4 treba osobitne objasniť renálnu elimináciu a prípadnú kumuláciu látky či jej metabolitov, odstrániteľnosť dialýzou, interakcie s imunosupresívami a vplyv na expozíciu vankomycínu. Z dostupného krátkodobého experimentu nemožno určiť bezpečný režim pre pacienta s chronickým ochorením obličiek, akútnym poškodením obličiek alebo po transplantácii.</p>

<div class="pdf-avoid-break">
<h2>Čo dnes platí pre liečbu infekcie VREfm</h2>
<p>Opísané výsledky nemenia potrebu liečiť závažnú infekciu podľa druhu mikroorganizmu, miesta infekcie, výsledkov citlivosti a stavu pacienta, ideálne v spolupráci s infektológom a klinickým mikrobiológom. <strong>Neodôvodňujú podanie samotného vankomycínu proti klinicky rezistentnému izolátu.</strong> Pghi-4 je zatiaľ predklinickým kandidátom; jej použitie v rutinnej liečbe nemá oporu v klinických dôkazoch.</p>
</div>

<p><strong>Linezolid</strong> patrí medzi používané možnosti liečby VREfm. Podľa dávkovacích informácií sa pri poruche funkcie obličiek rutinná úprava dávky nevyžaduje. To však nevylučuje zvýšené riziko trombocytopénie a ďalšej hematologickej toxicity. Potrebné je sledovanie krvného obrazu; pri rizikových pacientoch môže individualizáciu liečby podporiť terapeutické monitorovanie koncentrácií. Konkrétna indikácia a režim sa musia posúdiť podľa použitého lieku a klinickej situácie. <a href="#zdroj-8">[8]</a> <a href="#zdroj-9">[9]</a> </p>

<p><strong>Daptomycín</strong> sa používa aj pri závažných enterokokových infekciách, ale liečba VREfm bakteriémie je mimo schválených indikácií Cubicinu. EUCAST pre enterokoky neustanovil klinické hraničné hodnoty daptomycínu a upozorňuje na obmedzenia dôkazov. Rozhodnutie preto vyžaduje odbornú interpretáciu MIC a liečebného režimu. Treba sledovať svalové príznaky a kreatínkinázu, ako aj funkciu obličiek; pri renálnej dysfunkcii a dialýze režim individualizovať. <a href="#zdroj-10">[10]</a> <a href="#zdroj-11">[11]</a> </p>

<p>Pri vybraných závažných alebo perzistujúcich infekciách možno zvažovať synergické kombinácie. Rezistencia enterokokov na cefalosporíny v monoterapii nevylučuje úlohu niektorých betalaktámov v presne zvolenej kombinácii. Neznamená to však samostatnú účinnosť cefalosporínu ani potrebu dvoch liekov pri každej enterokokovej infekcii. <a href="#zdroj-3">[3]</a> <a href="#zdroj-11">[11]</a> </p>

<p>Antibiotiká nenahrádzajú <strong>kontrolu zdroja infekcie</strong>: podľa nálezu odstránenie infikovaného katétra, drenáž ložiska a vyšetrenie príčiny pretrvávajúcej bakteriémie vrátane možnej endokarditídy. <a href="#zdroj-2">[2]</a> </p>

<div class="pdf-avoid-break">
<h2>Systémová liečba nie je črevná dekolonizácia</h2>
<p>Účinok v krvi a orgánoch sa nemusí zhodovať s účinkom v črevnom lúmene. Zníženie bakteriálnej nálože v pečeni a slezine preto nedokazuje odstránenie črevnej kolonizácie ani obnovu zdravého mikrobiómu. Pri inhibícii bakteriálnych hydroláz treba navyše zohľadniť možné zmeny mikrobiálnych signálov ovplyvňujúcich imunitu. Dekolonizačný účinok a dôsledky pre mikrobiotu by vyžadovali samostatné štúdie. <a href="#zdroj-1">[1]</a> <a href="#zdroj-5">[5]</a> </p>
</div>

<div class="pdf-avoid-break">
<h2>Význam pre prax</h2>
<p>Pghi-4 podporuje koncept zvýšenia účinku antibiotika zásahom do prestavby peptidoglykánu. <strong>Pokles MIC a priaznivý výsledok krátkodobého pokusu na myšiach však zatiaľ nepreukazujú klinickú účinnosť ani bezpečnosť.</strong> Pre nefrologických pacientov bude rozhodujúce, či sa potrebná expozícia dosiahne bez neprijateľnej toxicity a či kombinácia prinesie výhodu oproti existujúcej liečbe.</p>
</div>

<hr>
<div class="pdf-avoid-break">
<h2>Zdroje</h2>
<p><em>Odborný komentár k štúdii Fam a spoluautorov, doplnený o klinický a nefrologický kontext. Zdroje a liekové informácie overené k 12. septembru 2026.</em></p>
</div>
<ol>
<li id="zdroj-1">Kyong T. Fam; Pavan Kumar Chodisetti; Zifei Wang; Joshua A. Homer; Christopher J. Smedley; Seiya Kitamura; Benjamin Silva; Yijun Xiong; Althea Hansel-Harris; Matthew Holcomb; Simeon Babarinde; Adrianna M. Turner; Daria Van Tyne; Ian A. Wilson; Stefano Forli; Benjamin F. Cravatt; Donghyun Park; Dennis W. Wolan; John E. Moses; Howard C. Hang. Genetic and pharmacological inactivation of peptidoglycan remodeling increases antibiotic susceptibility of vancomycin-resistant Enterococcus faecium. <em>Nature Communications.</em> 2026;17:7581. <a href="https://doi.org/10.1038/s41467-026-74057-1" target="_blank" rel="noopener noreferrer">DOI: 10.1038/s41467-026-74057-1</a>.</li>
<li id="zdroj-2">Cesar A. Arias; Barbara E. Murray. The rise of the Enterococcus: beyond vancomycin resistance. <em>Nature Reviews Microbiology.</em> 2012;10(4):266–278. <a href="https://doi.org/10.1038/nrmicro2761" target="_blank" rel="noopener noreferrer">DOI: 10.1038/nrmicro2761</a>.</li>
<li id="zdroj-3">Brian L. Hollenbeck; Louis B. Rice. Intrinsic and acquired resistance mechanisms in enterococcus. <em>Virulence.</em> 2012;3(5):421–433. <a href="https://doi.org/10.4161/viru.21282" target="_blank" rel="noopener noreferrer">DOI: 10.4161/viru.21282</a>.</li>
<li id="zdroj-4">World Health Organization. WHO updates list of drug-resistant bacteria most threatening to human health. 17. 5. 2024. <a href="https://www.who.int/news/item/17-05-2024-who-updates-list-of-drug-resistant-bacteria-most-threatening-to-human-health" target="_blank" rel="noopener noreferrer">Zoznam prioritných patogénov WHO</a>.</li>
<li id="zdroj-5">Centers for Disease Control and Prevention. Vancomycin-resistant Enterococci (VRE) Basics. <a href="https://www.cdc.gov/vre/about/index.html" target="_blank" rel="noopener noreferrer">Kolonizácia, infekcia a prevencia prenosu VRE</a>.</li>
<li id="zdroj-6">The European Committee on Antimicrobial Susceptibility Testing. <em>Breakpoint tables for interpretation of MICs and zone diameters.</em> Verzia 16.1, 2026, platná od 24. 6. 2026; tabuľka Enterococcus spp. <a href="https://www.eucast.org/fileadmin/eucast/pdf/breakpoints/v_16.1_Breakpoint_Tables.pdf" target="_blank" rel="noopener noreferrer">EUCAST 16.1 (PDF)</a>.</li>
<li id="zdroj-7">Michael J. Rybak; Jennifer Le; Thomas P. Lodise; Donald P. Levine; John S. Bradley; Catherine Liu; Bruce A. Mueller; Manjunath P. Pai; Annie Wong-Beringer; John C. Rotschafer; Keith A. Rodvold; Holly D. Maples; Benjamin M. Lomaestro. Therapeutic monitoring of vancomycin for serious methicillin-resistant Staphylococcus aureus infections: A revised consensus guideline and review by the American Society of Health-System Pharmacists, the Infectious Diseases Society of America, the Pediatric Infectious Diseases Society, and the Society of Infectious Diseases Pharmacists. <em>American Journal of Health-System Pharmacy.</em> 2020;77(11):835–864. <a href="https://doi.org/10.1093/ajhp/zxaa036" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ajhp/zxaa036</a>.</li>
<li id="zdroj-8">Ryan L. Crass; Pier Giorgio Cojutti; Manjunath P. Pai; Federico Pea. Reappraisal of Linezolid Dosing in Renal Impairment To Improve Safety. <em>Antimicrobial Agents and Chemotherapy.</em> 2019;63(8):e00605-19. <a href="https://doi.org/10.1128/AAC.00605-19" target="_blank" rel="noopener noreferrer">DOI: 10.1128/AAC.00605-19</a>.</li>
<li id="zdroj-9">Amarox Limited. <em>Linezolid 600 mg Film-Coated Tablets: Summary of Product Characteristics.</em> Electronic Medicines Compendium, aktualizované 17. 6. 2026. Najmä časti 4.2, 4.4 a 5.2. <a href="https://www.medicines.org.uk/emc/product/13583/smpc" target="_blank" rel="noopener noreferrer">Súhrn charakteristických vlastností lieku</a>.</li>
<li id="zdroj-10">European Medicines Agency. <em>Cubicin (daptomycín): súhrn charakteristických vlastností lieku.</em> Najmä časti 4.1, 4.2 a 4.4. <a href="https://www.ema.europa.eu/sk/documents/product-information/cubicin-epar-product-information_sk.pdf" target="_blank" rel="noopener noreferrer">Slovenské SPC (PDF)</a>.</li>
<li id="zdroj-11">The European Committee on Antimicrobial Susceptibility Testing. <em>Daptomycin to treat infections with enterococci or coagulase-negative staphylococci.</em> November 2025, revidovaná verzia z 2. 12. 2025. <a href="https://www.eucast.org/fileadmin/eucast/pdf/guidance_documents/Daptomycin_guidance_revised_20251202.pdf" target="_blank" rel="noopener noreferrer">Odborné stanovisko EUCAST (PDF)</a>.</li>
</ol>
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
    'log_prefix' => 'add_inhibicia-saga-pghi-4-vankomycin-rezistentny-enterococcus-faecium_article',
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
