<?php

/**
 * Bartterov syndróm: diagnostika, genetická klasifikácia a dlhodobá liečba.
 *
 * Pôvodní autori kľúčového spracovaného zdroja sú uvedení v source_authors.php.
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
    'title'        => 'Bartterov syndróm: diagnostika, genetické formy a dlhodobá liečba renálnej straty solí',
    'slug'         => 'bartterov-syndrom-diagnostika-geneticke-formy-liecba',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Bartterov syndróm je geneticky heterogénna tubulopatia. Článok spája genotyp s fenotypom, ponúka diagnostický algoritmus a vysvetľuje suplementáciu, úlohu NSAID aj riziká dlhodobej liečby.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Bartterov syndróm nie je jediná choroba, ale skupina zriedkavých dedičných tubulopatií. Spája ich renálna strata chloridu sodného, sekundárna aktivácia systému renín – angiotenzín – aldosterón, hypokaliemická hypochloremická metabolická alkalóza a spravidla normálny alebo nízky krvný tlak. Genetický typ však zásadne ovplyvňuje vek manifestácie, kalciúriu, sluch, závažnosť liečby aj dlhodobé renálne riziko.</em></p>

<p>Tradičné delenie na „antenatálny“ a „klasický“ Bartterov syndróm už na presnú diagnostiku nestačí. Fenotypy sa prekrývajú, ten istý gén môže viesť k rozdielne závažnému obrazu a pacient s variantmi <em>CLCNKB</em> môže klinicky pripomínať Gitelmanov syndróm. Diagnóza preto vyžaduje spojenie klinického obrazu, acidobázických pomerov, dôkazu renálnej straty chloridov, zobrazovacích nálezov a molekulárno-genetického vyšetrenia.</p>

<h2>Fyziologický podklad ochorenia</h2>

<p>V hrubej časti vzostupného ramienka Henleho slučky sa reabsorbuje približne 20 až 30&nbsp;% filtrovaného chloridu sodného. Na apikálnej membráne tento transport zabezpečuje kotransportér NKCC2. Draslík sa vracia do tubulárneho lúmenu cez kanál ROMK a chloridy opúšťajú bunku na bazolaterálnej strane najmä cez kanály ClC-Ka a ClC-Kb, ktorých funkcia závisí od podjednotky barttín.</p>

<p>Recyklácia draslíka vytvára pozitívny elektrický potenciál v lúmene, ktorý podporuje paracelulárnu reabsorpciu vápnika a horčíka. Porucha transportu preto môže okrem strát sodíka, chloridov a draslíka viesť k hyperkalciúrii, nefrokalcinóze a zhoršenej koncentračnej schopnosti obličiek.</p>

<p>Objemová kontrakcia aktivuje renín a aldosterón. Zvýšená distálna dodávka sodíka následne podporuje jeho výmenu za draslík a vodíkové ióny, čím vzniká hypokaliémia a metabolická alkalóza. Súčasne sa zvyšuje renálna tvorba prostaglandínu E<sub>2</sub>, ktorý podporuje renálny prietok, sekréciu renínu, polyúriu a ďalšie straty soli. Tento mechanizmus vysvetľuje účinnosť inhibítorov cyklooxygenázy, ale aj riziko ich dlhodobého používania.</p>

<h2>Súčasná genetická klasifikácia</h2>

<h3>Typ 1: SLC12A1 a NKCC2</h3>

<p>Bialelické patogénne varianty génu <strong><em>SLC12A1</em></strong> poškodzujú kotransportér NKCC2. Ochorenie sa často prejaví už počas gravidity polyhydramniónom a predčasným pôrodom. Po narodení dominujú výrazná polyúria, strata solí, dehydratácia, hyperkalciúria a vznik medulárnej nefrokalcinózy.</p>

<h3>Typ 2: KCNJ1 a ROMK</h3>

<p>Typ 2 spôsobujú bialelické varianty <strong><em>KCNJ1</em></strong>, ktorý kóduje kanál ROMK. Fenotyp sa podobá typu 1, ale v prvých dňoch života sa môže prechodne objaviť hyperkaliémia. ROMK sa totiž podieľa aj na distálnej sekrécii draslíka. S dozrievaním ďalších kaliových kanálov sa zvyčajne rozvinie typická hypokaliémia.</p>

<h3>Typ 3: CLCNKB a ClC-Kb</h3>

<p>Pri type 3 ide o bialelické varianty <strong><em>CLCNKB</em></strong>. Klinický obraz je mimoriadne variabilný: od antenatálneho priebehu cez klasickú manifestáciu v detstve až po mierny Gitelmanov fenotyp s hypomagneziémiou a hypokalciúriou. Kalciúria sa môže líšiť aj medzi príbuznými s rovnakým genotypom a meniť sa v čase. Klinické rozlíšenie od Gitelmanovho syndrómu preto niekedy nie je možné bez genetického vyšetrenia.</p>

<h3>Typ 4A a 4B: barttín a chloridové kanály</h3>

<p>Typ 4A spôsobujú bialelické varianty <strong><em>BSND</em></strong>, ktorý kóduje barttín. Typ 4B vzniká kombinovaným poškodením génov <strong><em>CLCNKA</em></strong> a <strong><em>CLCNKB</em></strong>. ClC-Ka, ClC-Kb a barttín sú potrebné aj pre homeostázu iónov vo vnútornom uchu, preto je pre tieto formy charakteristická vrodená senzorineurálna porucha sluchu. Renálny fenotyp býva závažný a riziko chronickej choroby obličiek môže byť vyššie.</p>

<h3>Typ 5: prechodná forma spojená s MAGED2</h3>

<p>Hemizygotné patogénne varianty <strong><em>MAGED2</em></strong> spôsobujú X-viazaný prechodný antenatálny Bartterov syndróm, ktorý sa v súčasnej nomenklatúre označuje ako typ 5. Typický je veľmi skorý a závažný polyhydramnión, extrémna prematurita a masívne novorodenecké straty vody a solí. U prežívajúcich detí tubulárna porucha spravidla spontánne ustúpi v priebehu týždňov až mesiacov, často približne okolo pôvodne očakávaného termínu pôrodu.</p>

<p>Označenie „prechodný“ nesmie viesť k podceneniu ochorenia. Prenatálna a novorodenecká fáza môže byť život ohrozujúca. Väčšina postihnutých je mužského pohlavia, hoci prejavy sa môžu výnimočne vyskytnúť aj u nositeliek variantu.</p>

<h3>Prečo už CASR nie je Bartterov syndróm typu 5</h3>

<p>Aktivujúce varianty génu <strong><em>CASR</em></strong> môžu vyvolať Bartterovmu syndrómu podobný obraz s hypokalciémiou, nízkou alebo neprimerane normálnou koncentráciou PTH a hyperkalciúriou. Staršia literatúra tento stav označovala ako Bartterov syndróm typu 5. Podľa súčasnej nomenklatúry však ide o autozómovo dominantnú hypokalciémiu s Bartterovým fenotypom; označenie typ 5 patrí prechodnej forme spojenej s <em>MAGED2</em>.</p>

<h2>Klinický obraz a dôležité výnimky</h2>

<p>Závažnosť siaha od život ohrozujúcej novorodeneckej straty tekutín až po miernu chronickú hypokaliémiu diagnostikovanú v dospelosti. Medzi typické prejavy patria:</p>

<ul>
  <li>polyhydramnión fetálneho pôvodu a predčasný pôrod,</li>
  <li>polyúria, polydipsia, zvýšená potreba soli a opakovaná dehydratácia,</li>
  <li>neprospievanie, porucha rastu, únava, svalová slabosť a kŕče,</li>
  <li>hypokaliemická hypochloremická metabolická alkalóza, hyperreninémia a hyperaldosteronizmus,</li>
  <li>hyperkalciúria, nefrokalcinóza alebo nefrolitiáza, najmä pri typoch 1 a 2,</li>
  <li>senzorineurálna porucha sluchu pri type 4.</li>
</ul>

<p>Krvný tlak je zvyčajne normálny alebo nízky, nie však nevyhnutne hypotenzný. V novorodeneckom období nemusí byť typická alkalóza ihneď prítomná, napríklad pri akútnom poškodení obličiek z dehydratácie. Pri type 2 môže byť prvým elektrolytovým nálezom prechodná hyperkaliémia. Ani jeden izolovaný laboratórny znak preto diagnózu nepotvrdzuje ani nevylučuje.</p>

<h2>Diagnostický postup</h2>

<h3>1. Potvrdiť fenotyp a renálnu stratu solí</h3>

<p>Vstupné vyšetrenie má zahŕňať anamnézu polyhydramniónu, prematurity, rastu a rodinného výskytu, stav hydratácie a krvný tlak. Z laboratórnych parametrov treba vyšetriť sodík, draslík, chloridy, bikarbonát alebo krvné plyny, vápnik, horčík, kreatinín a veku primeraný odhad glomerulovej filtrácie, renín a aldosterón. V moči sa hodnotí chlorid, sodík, draslík, pomer vápnika ku kreatinínu a podľa situácie frakčná exkrécia chloridu. Súčasťou vstupného posúdenia je ultrazvuk obličiek.</p>

<p>Pri objemovej deplécii je renálna exkrécia chloridov neprimerane vysoká. Jednorazová koncentrácia chloridov v moči však závisí od hydratácie, prietoku moču, suplementácie a liekov. Pri nejasnom náleze je vhodný opakovaný odber a interpretácia spolu s frakčnou exkréciou. Nízka exkrécia chloridov podporuje extrarenálnu stratu, napríklad vracanie alebo žalúdočnú drenáž.</p>

<h3>2. Aktívne vylúčiť získané a pseudo-Bartterove príčiny</h3>

<p>Kľučkové diuretiká napodobňujú poruchu NKCC2 a tiazidy Gitelmanov syndróm. Nedávne užitie diuretika môže prechodne zvýšiť močový chlorid, zatiaľ čo pri kolísavom užívaní sa výsledky menia. Ak je anamnéza nejasná, má zmysel toxikologický skríning moču na diuretiká, podľa možnosti z čerstvej a niekedy opakovanej vzorky.</p>

<p>Pseudo-Bartterov fenotyp môže vzniknúť pri chronickom vracaní, kongenitálnej chloridovej hnačke, cystickej fibróze s veľkými stratami chloridov potom, zneužívaní diuretík alebo laxatív, poruchách príjmu potravy, závažnej podvýžive či pri výžive s nedostatočným obsahom chloridov. Pri hypertenzii treba uprednostniť diagnostiku mineralokortikoidového nadbytku, Liddleovho syndrómu, zdanlivého nadbytku mineralokortikoidov alebo Cushingovho syndrómu.</p>

<h3>3. Využiť kalciúriu a magnézium, ale nepreceňovať ich</h3>

<p>Hyperkalciúria a nefrokalcinóza podporujú najmä typy 1 a 2. Hypomagneziémia s hypokalciúriou je typickejšia pre Gitelmanov syndróm, no hranice nie sú absolútne. Typ 3 môže Gitelmanov syndróm presvedčivo napodobniť a ani normálna magnéziémia Gitelmanov syndróm nevylučuje.</p>

<h3>4. Potvrdiť diagnózu geneticky</h3>

<p>Pri dôvodnom klinickom podozrení odporúča európsky konsenzus genetické potvrdenie vždy, keď je dostupné. Panel má pokrývať minimálne <em>SLC12A1</em>, <em>KCNJ1</em>, <em>CLCNKA</em>, <em>CLCNKB</em>, <em>BSND</em>, <em>MAGED2</em> a <em>SLC12A3</em>, ideálne aj gény dôležitých diferenciálnych diagnóz vrátane <em>CASR</em>, <em>KCNJ10</em>, <em>SLC26A3</em> a <em>CLDN10</em>.</p>

<p>Analýza musí zachytiť aj delécie a duplikácie, ktoré sú časté najmä v <em>CLCNKB</em>. Negatívny panel diagnózu úplne nevylučuje: príčinou môže byť technicky nezachytený variant, komplexná prestavba, hlboký intrónový variant alebo iný mechanizmus. Funkčné testy s furosemidom alebo tiazidom sa pri dostupnom genetickom vyšetrení rutinne neodporúčajú.</p>

<h2>Liečba: nahradiť straty bez vytvorenia ďalšieho rizika</h2>

<p>Dôkazy o liečbe pochádzajú prevažne z malých observačných súborov, kazuistík a expertnej zhody. Režim sa preto prispôsobuje genotypu, veku, polyúrii, rastu, funkcii obličiek, tolerancii a aktuálnym stratám. Cieľom nie je za každú cenu normalizovať každý laboratórny parameter, ale udržať bezpečnú hydratáciu a elektrolytovú rovnováhu, podporiť rast a predchádzať arytmiám a poškodeniu obličiek.</p>

<h3>Tekutiny a chlorid sodný</h3>

<p>Základom je voľný prístup k tekutinám a primeraná náhrada chloridu sodného. Konsenzus odporúča pri Bartterovom syndróme zvážiť farmakologické dávky NaCl približne 5–10&nbsp;mmol/kg/deň, rozdelené do viacerých dávok. Nejde o univerzálny predpis: potreba sa výrazne mení podľa veku, genetického typu, strát močom, klímy, rastu a ďalšej liečby.</p>

<p>Dôležitou výnimkou je sekundárny nefrogénny diabetes insipidus. Ďalšie osmotické zaťaženie soľou môže v tejto situácii zhoršiť polyúriu, preto konsenzus rutinnú suplementáciu NaCl neodporúča. Počas horúčky, gastroenteritídy, vracania alebo obmedzeného príjmu sa môže stav rýchlo dekompenzovať a perorálnu liečbu môže byť potrebné dočasne nahradiť intravenóznou.</p>

<h3>Draslík a horčík</h3>

<p>Ak je potrebná substitúcia draslíka, preferuje sa <strong>chlorid draselný</strong>. Citrátové a bikarbonátové soli môžu prehlbovať alkalózu. Dennú dávku je vhodné rozdeliť čo najrovnomernejšie, pretože vysoké jednotlivé dávky zhoršujú gastrointestinálnu toleranciu a vedú k väčšiemu kolísaniu kaliémie.</p>

<p>Úplná normalizácia draslíka často nie je realistická ani žiaduca za cenu neprimeranej liekovej záťaže. Bezpečný cieľ sa určuje podľa príznakov, EKG, súbežnej hypomagneziémie, funkcie obličiek a rizika arytmie. Hypomagneziémiu treba korigovať, pretože zvyšuje renálne straty draslíka a sťažuje jeho doplnenie; dávku horčíka limituje najmä hnačka.</p>

<h3>Nesteroidové protizápalové lieky</h3>

<p>Indometacín, ibuprofén alebo celekoxib môžu u symptomatických pacientov, najmä v ranom detstve, znížiť prostaglandínmi podmienenú polyúriu a straty solí a podporiť rast. Neexistuje však dostatok údajov na určenie jedného najlepšieho NSAID. Liečba sa nemá začínať ani udržiavať mechanicky iba podľa diagnózy.</p>

<p>Riziká zahŕňajú poškodenie gastrointestinálnej sliznice a krvácanie, zníženie glomerulovej filtrácie, akútne poškodenie obličiek pri dehydratácii, retenciu tekutín a kardiovaskulárne komplikácie. U predčasne narodených detí treba myslieť aj na črevnú perforáciu a nekrotizujúcu enterokolitídu. Pri neselektívnom inhibítore COX konsenzus odporúča gastroprotekciu. Jej voľba má zohľadniť, že inhibítory protónovej pumpy môžu zhoršovať hypomagneziémiu.</p>

<p>Pred začatím a počas liečby treba sledovať hydratáciu, krvný tlak, funkciu obličiek, elektrolyty a gastrointestinálne ťažkosti. NSAID môžu tlmiť horúčku a zakryť závažnosť infekcie. Pri vracaní, hnačke alebo dehydratácii je potrebný vopred dohodnutý postup vrátane dočasného prerušenia rizikových liekov a včasnej kontroly.</p>

<h3>Draslík šetriace diuretiká a blokáda RAAS</h3>

<p>Spironolaktón, eplerenón, amilorid, inhibítory ACE a blokátory receptorov angiotenzínu môžu zvýšiť kaliémiu, ale zároveň prehĺbiť renálnu stratu sodíka, polyúriu, hypotenziu a riziko akútneho poškodenia obličiek. Európsky konsenzus preto <strong>neodporúča ich rutinné používanie</strong>. Výnimočné nasadenie patrí do špecializovaného centra po optimalizácii tekutín a soli, s tesným sledovaním tlaku, kreatinínu a elektrolytov.</p>

<p>Tiazidy sa nemajú používať na znižovanie hyperkalciúrie pri Bartterovom syndróme, pretože môžu nebezpečne zhoršiť objemovú depléciu a straty solí.</p>

<h3>Výživa a porucha rastu</h3>

<p>Pri neprospievaní treba najprv optimalizovať hydratáciu, kalorický a bielkovinový príjem, elektrolyty a kontrolu hyperprostaglandinizmu. U dojčiat môže byť potrebná enterálna podpora, ktorá uľahčí aj podávanie soli. Rastový hormón nie je štandardnou liečbou Bartterovho syndrómu; možno ho zvážiť iba po endokrinologickom vyšetrení u vybraného pacienta, keď je metabolická kontrola primeraná.</p>

<h2>Prenatálna diagnostika a liečba</h2>

<p>Skorý závažný polyhydramnión fetálneho pôvodu bez anatomickej príčiny má vzbudiť podozrenie na antenatálny Bartterov syndróm. Stanovenie elektrolytov alebo aldosterónu v plodovej vode nemá dostatočnú diskriminačnú schopnosť a konsenzus ho neodporúča. Najspoľahlivejšie potvrdenie poskytuje cielená genetická diagnostika, ak je známy rodinný variant alebo je invazívne vyšetrenie po genetickom poradenstve odôvodnené. Ak genetika nie je dostupná, možno v špecializovanom centre zvážiť takzvaný Bartterov index založený na alfa-fetoproteíne a celkovom proteíne v plodovej vode.</p>

<p>Opakovaná amnioredukcia alebo prenatálne NSAID môžu znížiť množstvo plodovej vody a oddialiť pôrod, dôkazy sú však obmedzené. Indometacín môže spôsobiť konstrikciu alebo predčasný uzáver ductus arteriosus a ďalšie fetálne či novorodenecké komplikácie. Takáto liečba nie je rutinná a patrí výlučne multidisciplinárnemu tímu fetálnej medicíny, neonatológie, detskej nefrológie a pri NSAID aj detskej kardiológie.</p>

<h2>Dlhodobé sledovanie</h2>

<p>Dojčatá a malé deti majú byť podľa závažnosti kontrolované aspoň každé 3 až 6 mesiacov, stabilné staršie deti a dospelí každých 6 až 12 mesiacov. Interval sa skracuje pri zmenách liečby, raste, tehotenstve, interkurentnom ochorení alebo zhoršení funkcie obličiek.</p>

<p>Pri kontrolách treba cielene hodnotiť:</p>

<ul>
  <li>rast, hmotnosť, výživu, pubertálny vývoj a kvalitu života,</li>
  <li>stav hydratácie, krvný tlak, polyúriu, svalovú slabosť, únavu a palpitácie,</li>
  <li>acidobázický stav, sodík, draslík, chloridy, bikarbonát, horčík, vápnik a podľa kontextu fosfáty a PTH,</li>
  <li>kreatinín alebo cystatín C, eGFR a albuminúriu či proteinúriu,</li>
  <li>kalciúriu a nežiaduce účinky liekov, najmä NSAID,</li>
  <li>sluch pri type 4 a EKG pri diagnóze, závažnej hypokaliémii, palpitáciách alebo synkope.</li>
</ul>

<p>Ultrazvuk obličiek sa odporúča približne každých 12 až 24 mesiacov na sledovanie nefrokalcinózy, kameňov a sekundárnej obštrukcie pri výraznej polyúrii. Frekvencia sa individualizuje podľa nálezu.</p>

<h2>Prognóza a riziko chronickej choroby obličiek</h2>

<p>Bartterov syndróm nemožno automaticky považovať za benígne ochorenie. V multicentrickej retrospektívnej kórejskej kohorte 54 pacientov malo po mediáne ôsmich rokov sledovania 11&nbsp;% pacientov CKD G3 až G5 a 41&nbsp;% nízky vzrast pod tretím percentilom. Kohorta bola malá, geneticky neúplná a dominoval v nej typ 3, preto tieto podiely nemožno preniesť na každého pacienta ani na všetky genotypy.</p>

<p>Medzi možné mechanizmy renálneho poškodenia patria prematurita a nižší počet nefrónov, opakovaná dehydratácia a akútne poškodenie obličiek, nefrokalcinóza, chronická hyperfiltrácia a proteinúria, dlhodobá expozícia NSAID a závažný genetický fenotyp. Úloha samotnej chronickej hypokaliémie nie je u ľudí spoľahlivo dokázaná a pozorované asociácie nepreukazujú kauzalitu.</p>

<p>Pri zlyhaní obličiek transplantácia nahradí tubuly s genetickým defektom a v publikovaných prípadoch odstránila polyúriu aj elektrolytové poruchy bez recidívy základnej tubulopatie. Preventívna nefrektómia a transplantácia pred rozvojom zlyhania obličiek sa však rutinne neodporúčajú.</p>

<h2>Bartterov syndróm diagnostikovaný v dospelosti</h2>

<p>Diagnóza sa môže potvrdiť až v dospelosti, najmä pri type 3 alebo miernom variante. Pri novovzniknutej hypokaliemickej alkalóze je však získaná príčina oveľa pravdepodobnejšia než vrodený Bartterov syndróm. Pred genetickým záverom treba dôsledne vylúčiť vracanie, diuretiká a laxatíva, poruchu príjmu potravy, extrarenálne straty chloridov, liekové príčiny a mineralokortikoidový nadbytok.</p>

<p>Neskoré rozpoznanie dedičnej tubulopatie podporujú celoživotná potreba soli, chronická polyúria, nízky krvný tlak, porucha rastu, nefrokalcinóza, prekonaná prematurita alebo podobný rodinný fenotyp. Aj vtedy však klinický obraz určuje podozrenie, nie definitívny genotyp.</p>

<h2>Praktický postup pre ambulanciu</h2>

<ol>
  <li><strong>Potvrďte metabolickú alkalózu a renálnu stratu chloridov.</strong> Jednorazová kaliémia ani močový chlorid samy nestačia.</li>
  <li><strong>Zohľadnite krvný tlak a renínovo-aldosterónový profil.</strong> Hypertenzia presúva diferenciálnu diagnostiku k mineralokortikoidovému nadbytku.</li>
  <li><strong>Vylúčte diuretiká a extrarenálne straty.</strong> Pri rozpore medzi anamnézou a nálezom použite správne načasovaný toxikologický skríning.</li>
  <li><strong>Vyšetrite kalciúriu, horčík a obličky ultrazvukom.</strong> Pomáhajú fenotypizovať ochorenie, nie však spoľahlivo určiť gén.</li>
  <li><strong>Potvrďte diagnózu geneticky.</strong> Panel musí zachytiť aj delécie a duplikácie a má pokrývať relevantné diferenciálne diagnózy.</li>
  <li><strong>Nahrádzajte chlorid, nie iba draslík.</strong> Dávky tekutín, NaCl, KCl a horčíka rozdeľte počas dňa a prispôsobte skutočným stratám.</li>
  <li><strong>NSAID používajte cielene.</strong> Pravidelne prehodnocujte rast, polyúriu, gastrointestinálne riziko, hydratáciu a funkciu obličiek.</li>
  <li><strong>Pripravte plán pre akútne ochorenie.</strong> Vracanie, hnačka, horúčka alebo nemožnosť piť môžu rýchlo viesť k dehydratácii, arytmii a AKI.</li>
</ol>

<h2>Záver</h2>

<p>Bartterov syndróm je geneticky aj klinicky heterogénna skupina tubulopatií. Spoločný laboratórny obraz nevylučuje významné rozdiely medzi poruchou NKCC2, ROMK, ClC-Kb, barttínu, kombinovanou poruchou ClC-Ka/ClC-Kb a prechodnou formou spojenou s <em>MAGED2</em>. Aktuálna nomenklatúra vyhradzuje označenie typ 5 pre <em>MAGED2</em>; aktivujúce varianty <em>CASR</em> patria medzi autozómovo dominantné hypokalciemické poruchy.</p>

<p>Diagnóza má vychádzať z acidobázického stavu, renálnej straty chloridov, kalciúrie, liekovej a rodinnej anamnézy, ultrazvuku a genetického potvrdenia. Liečba je dlhodobá a podporná: náhrada tekutín, chloridu sodného, chloridu draselného a podľa potreby horčíka, u vybraných symptomatických pacientov NSAID a dôsledné sledovanie rastu, sluchu, srdcového rytmu a funkcie obličiek. Najlepší výsledok neprináša mechanická normalizácia laboratórnych hodnôt, ale individualizovaná rovnováha medzi náhradou strát a rizikami liečby.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=cheatsheet-acidobaza">Acidobázická rovnováha: praktický ťahák</a></li>
  <li><a href="article.php?slug=cheatsheet-elektrolyty">Elektrolyty: praktický ťahák pre klinickú prax</a></li>
  <li><a href="article.php?slug=environmentalne-toxiny-poskodenie-obliciek-nefrolog">Environmentálne toxíny a poškodenie obličiek</a></li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Martin Konrad, Tom Nijenhuis, Gema Ariceta, Aurelia Bertholet-Thomas, Lorenzo A. Calò, Giovambattista Capasso, Francesco Emma, Karl P. Schlingmann, Mandeep Singh, Francesco Trepiccione, Stephen B. Walsh, Kirsty Whitton, Rosa Vargas-Poussou, Detlef Bockenhauer.</strong> <em>Diagnosis and management of Bartter syndrome: executive summary of the consensus and recommendations from the European Rare Kidney Disease Reference Network Working Group for Tubular Disorders.</em> Kidney International. 2021;99(2):324–335. doi: 10.1016/j.kint.2020.10.035. <a href="https://doi.org/10.1016/j.kint.2020.10.035" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33509356/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://www.erknet.org/fileadmin/files/user_upload/Bartter_syndrome_consensus_paper__extended_version_.pdf" target="_blank" rel="noopener noreferrer">Rozšírená verzia ERKNet</a>.</li>
  <li><strong>Naye Choi, Seong Heon Kim, Eun Hui Bae, Eun Mi Yang, Keum Hwa Lee, Sang-Ho Lee, Joo Hoon Lee, Yo Han Ahn, Hae Il Cheong, Hee Gyung Kang, Hye Sun Hyun, Ji Hyun Kim.</strong> <em>Long-term outcome of Bartter syndrome in 54 patients: a multicenter study in Korea.</em> Frontiers in Medicine. 2023;10:1099840. doi: 10.3389/fmed.2023.1099840. <a href="https://doi.org/10.3389/fmed.2023.1099840" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36993809/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.3389/fmed.2023.1225353" target="_blank" rel="noopener noreferrer">Corrigendum</a>.</li>
  <li><strong>Kamel Laghmani et al.</strong> <em>Polyhydramnios, Transient Antenatal Bartter's Syndrome, and MAGED2 Mutations.</em> The New England Journal of Medicine. 2016;374(19):1853–1863. doi: 10.1056/NEJMoa1507629. <a href="https://doi.org/10.1056/NEJMoa1507629" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/27120771/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Tânia D. S. Cunha, Ita Pfeferman Heilberg.</strong> <em>Bartter syndrome: causes, diagnosis, and treatment.</em> International Journal of Nephrology and Renovascular Disease. 2018;11:291–301. doi: 10.2147/IJNRD.S155397. <a href="https://doi.org/10.2147/IJNRD.S155397" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6233707/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>David B. Simon et al.</strong> Pôvodné genetické práce o <em>SLC12A1</em>, <em>KCNJ1</em> a <em>CLCNKB</em>. Nature Genetics. 1996–1997. <a href="https://doi.org/10.1038/ng0696-183" target="_blank" rel="noopener noreferrer">NKCC2</a>. <a href="https://doi.org/10.1038/ng1096-152" target="_blank" rel="noopener noreferrer">ROMK</a>. <a href="https://doi.org/10.1038/ng1097-171" target="_blank" rel="noopener noreferrer">ClC-Kb</a>.</li>
  <li><strong>Lynda A. Frassetto, Lowell J. Lo; chief editor Vecihi Batuman.</strong> <em>Bartter Syndrome.</em> Medscape Drugs &amp; Diseases. Klinický sekundárny prehľad. <a href="https://emedicine.medscape.com/article/238670-overview" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Nosným podkladom článku je konsenzus pracovnej skupiny ERKNet. Väčšina liečebných odporúčaní má pre zriedkavosť ochorenia iba nízku až strednú istotu a opiera sa o observačné údaje a expertizu. Medscape slúžil ako orientačný sekundárny zdroj; pri rozpore v číslovaní genetických foriem dostala prednosť súčasná nomenklatúra ERKNet/OMIM. Dávkovanie a monitorovanie patria do rúk pracoviska so skúsenosťou s dedičnými tubulopatiami.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_bartterov-syndrom-diagnostika-geneticke-formy-liecba_article',
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
