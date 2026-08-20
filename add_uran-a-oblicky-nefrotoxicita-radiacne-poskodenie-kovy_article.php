<?php
/**
 * add_uran-a-oblicky-nefrotoxicita-radiacne-poskodenie-kovy_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT odborného článku o uránovej nefrotoxicite, radiačnej
 * nefropatii, environmentálnych kovoch a klinickom biomonitorovaní.
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Urán a obličky: chemická nefrotoxicita, radiačné poškodenie a riziká environmentálnych kovov',
    'slug'         => 'uran-a-oblicky-nefrotoxicita-radiacne-poskodenie-kovy',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,
    'excerpt'      => 'Urán poškodzuje najmä proximálny tubulus chemickou toxicitou; radiačná nefropatia vzniká iným mechanizmom. Prehľad dôkazov, limitov vody, máp, diagnostiky a biomonitorovania.',
    'content'      => <<<'HTML'
<h2>Súhrn</h2>
<p>Urán je prirodzene sa vyskytujúci rádioaktívny aktinoid a zároveň toxický kov. Pri bežnej environmentálnej expozícii, najmä po dlhodobom príjme z kontaminovanej podzemnej alebo studničnej vody, predstavuje pre obličky spravidla väčší problém jeho chemická toxicita než rádioaktivita. Najcitlivejším miestom sú bunky proximálneho tubulu. Vysoká dávka rozpustných zlúčenín uránu môže vyvolať akútne tubulárne poškodenie až akútne poškodenie obličiek; pri dlhodobej nízkej expozícii sa opisujú jemné poruchy tubulárnej funkcie a zmeny biomarkerov. Dôkaz, že bežná nízka environmentálna expozícia sama osebe často vedie ku klinicky manifestnému zlyhaniu obličiek, však zostáva neúplný. Nové observačné štúdie z roku 2025 naznačili asociáciu aj pri koncentráciách pod súčasným limitom 30 µg/l, ale zatiaľ nedokazujú príčinnosť ani neurčujú novú bezpečnú hranicu.</p>
<p>Radiačná nefropatia je odlišný mechanizmus. Vzniká po podstatne vyššej absorbovanej dávke ionizujúceho žiarenia do obličiek, typicky pri rádioterapii, celotelovom ožiarení alebo niektorých rádionuklidových liečbach, nie pri obyčajnom dotyku s kusom prírodného či ochudobneného uránu. Rádium sa ukladá najmä do kostí a radón poškodzuje predovšetkým pľúca; ich úloha pri chronickej chorobe obličiek nie je presvedčivo preukázaná. Spomedzi nerádioaktívnych kovov majú najlepšie doloženú nefrotoxicitu kadmium, olovo a anorganická ortuť.</p>
<h2>Dve toxicity toho istého prvku</h2>
<p>Pri uráne treba od začiatku oddeliť dva druhy rizika:</p>
<ol>
<li><strong>Chemická toxicita uranylového iónu a ďalších rozpustných foriem uránu.</strong> Závisí najmä od hmotnostnej dávky, chemickej formy, rozpustnosti, cesty vstupu a rýchlosti vylučovania. Cieľovým orgánom sú obličky.</li>
<li><strong>Rádiologická toxicita.</strong> Závisí od izotopového zloženia, aktivity v becquereloch, druhu žiarenia, biokinetiky a absorbovanej dávky v tkanive. Prirodzený aj ochudobnený urán sú prevažne alfa žiariče. Alfa častice majú veľmi malý dosah a neprechádzajú cez neporušenú kožu, po vdýchnutí, prehltnutí alebo zanesení do rany však môžu ožarovať tkanivo z bezprostrednej blízkosti.</li>
</ol>
<p>Tieto veličiny nie sú zameniteľné. Údaj v µg/l vyjadruje hmotnostnú koncentráciu, kým Bq/l počet rádioaktívnych premien za sekundu v litri. Rovnaká hmotnosť rôznych izotopov preto nemusí mať rovnakú aktivitu. Naopak, chemická toxicita jednotlivých izotopov uránu je pri rovnakej chemickej forme v zásade podobná.</p>
<p>Ochudobnený urán má približne 60 % rádioaktivity prírodného uránu na jednotku hmotnosti, nie je však chemicky „zneškodnený“. Jeho toxicita ako kovu zostáva porovnateľná. Obohatený urán alebo zmesi s vyšším podielom izotopov s vyššou špecifickou aktivitou prinášajú väčšiu rádiologickú zložku rizika.</p>
<h2>Ako sa urán dostáva do organizmu</h2>
<h3>Pitná voda a potrava</h3>
<p>Najvýznamnejšou environmentálnou cestou je pitie vody zo zdroja, v ktorom sa urán uvoľňuje z horninového podložia alebo z banských a priemyselných rezíduí. Riziko je typické najmä pre niektoré podzemné zdroje a súkromné studne; vzhľad, chuť ani zápach vody ho spoľahlivo neodhalia. WHO odhaduje priemernú gastrointestinálnu absorpciu uránu približne na 1 až 2 %, pričom závisí od rozpustnosti zlúčeniny a ďalších podmienok. Väčšina prehltnutého uránu teda odíde stolicou, no absorbovaná časť prechádza do krvi, kostí a obličiek.</p>
<p>Sprchovanie alebo kúpanie vo vode s uránom nie je porovnateľné s jej dlhodobým pitím. Preniknutie cez neporušenú kožu je malé. Výnimkou môže byť pracovný kontakt s koncentrovanými rozpustnými zlúčeninami, poškodená koža alebo kontaminovaná rana.</p>
<h3>Vdýchnutie prachu a aerosólu</h3>
<p>K expozícii dochádza v baniach, pri spracovaní rudy a paliva, pri brúsení alebo požiari materiálu s obsahom uránu a po náraze munície z ochudobneného uránu. Rozpustné inhalované zlúčeniny sa môžu vstrebávať do krvi a zasiahnuť obličky. Málo rozpustné oxidy zostávajú dlhšie v pľúcach, preto sa pri nich zvyšuje význam lokálneho pľúcneho a rádiologického rizika.</p>
<h3>Kontaminovaná rana a zadržané kovové fragmenty</h3>
<p>Fragmenty ochudobneného uránu v mäkkých tkanivách vytvárajú neobvyklú dlhodobú vnútornú expozíciu. Urán sa z fragmentu môže pomaly uvoľňovať a roky sa objavovať v moči. Tridsaťročné sledovanie malej kohorty veteránov s vysokou expozíciou však preukázalo iba málo klinicky významných nálezov v typických cieľových orgánoch; pretrvávali skôr signály súvisiace s kostným metabolizmom. Tento výsledok je upokojujúci, ale pre malý a špecifický súbor sa nedá jednoducho preniesť na všetky expozičné situácie.</p>
<h3>Vonkajší kontakt</h3>
<p>Samotný krátky dotyk s kovovým uránom bez kontaminácie prachom, poranenia alebo požitia nie je pravdepodobnou príčinou zlyhania obličiek. Pri externom ožiarení sú dôležitejšie prenikavejšie beta a gama zložky a dcérske produkty rozpadového radu. Praktické posúdenie preto musí vychádzať z merania kontaminácie a dávky, nie iba zo slovného údaja, že človek bol „pri uráne“.</p>
<h2>Prečo je proximálny tubulus najzraniteľnejší</h2>
<p>Po vstupe do krvi sa rozpustný urán vyskytuje najmä v podobe komplexov uranylového iónu. Časť sa filtruje v glomeruloch a koncentruje v kôre obličky. Viaže sa na kefkový lem proximálnych tubulov a vstupuje do buniek okrem iného endocytózou a cez sodíkovo-fosfátový kotransportér NaPi-IIa.</p>
<p>Experimentálne údaje podporujú viacero vzájomne prepojených mechanizmov:</p>
<ul>
<li>poruchu mitochondriálneho prenosu elektrónov a pokles membránového potenciálu,</li>
<li>tvorbu reaktívnych foriem kyslíka a oxidačný stres,</li>
<li>poškodenie DNA a narušenie jej opravy,</li>
<li>stres endoplazmatického retikula,</li>
<li>aktiváciu dráh Nrf2 a NF-κB, zápalovej odpovede, apoptózy a pri vyššej dávke nekrózy,</li>
<li>poruchu transportu glukózy, fosfátu, aminokyselín a nízkomolekulových bielkovín.</li>
</ul>
<p>Výsledkom býva najmä poškodenie segmentov S2 a S3 proximálneho tubulu. Pri ťažkej intoxikácii sa pridáva pokles glomerulovej filtrácie, akútna tubulárna nekróza, intersticiálny zápal a potenciálne nezvratná strata funkčných nefrónov. Pri nižšej dávke môže byť prvým prejavom iba zmena tubulárnych biomarkerov bez vzostupu kreatinínu.</p>
<h2>Klinický obraz</h2>
<h3>Akútna vysoká expozícia</h3>
<p>Akútna intoxikácia rozpustnou zlúčeninou uránu môže viesť k:</p>
<ul>
<li>proteinúrii, najmä tubulárneho typu,</li>
<li>normoglykemickej glykozúrii, aminoacidúrii a fosfatúrii,</li>
<li>strate bikarbonátu, urátu a ďalších solútov, teda k neúplnému alebo úplnému obrazu Fanconiho syndrómu,</li>
<li>poruche koncentračnej schopnosti obličiek,</li>
<li>vzostupu sérového kreatinínu a rozvoju AKI,</li>
<li>poruchám vnútorného prostredia a v najťažších prípadoch k potrebe náhrady funkcie obličiek.</li>
</ul>
<p>Tubulárne bunky majú určitú regeneračnú schopnosť. Po zastavení expozície môže dôjsť k čiastočnému alebo výraznému zotaveniu, najmä po ľahšom poškodení. Ťažká nekróza, opakovaná expozícia alebo súčasná hypovolémia, sepsa a ďalšie nefrotoxíny však zvyšujú riziko prechodu do chronickej choroby obličiek.</p>
<h3>Chronická nízka alebo stredná expozícia</h3>
<p>Chronická expozícia sa nemusí prejaviť príznakmi. Skôr než eGFR sa môžu meniť ukazovatele proximálneho tubulu, napríklad β2-mikroglobulín v moči, retinol viažuci proteín, α1-mikroglobulín, N-acetyl-β-D-glukozaminidáza, frakčná exkrécia fosfátu alebo vápnika. Tieto markery však nie sú špecifické pre urán a ich interpretáciu ovplyvňujú pH moču, koncentrácia moču, vek, hypertenzia, diabetes, iné kovy a preexistujúce ochorenie obličiek.</p>
<p>Preto platí dôležitá zásada: <strong>zvýšený urán v moči dokazuje expozíciu, nie automaticky poškodenie obličiek; abnormálny tubulárny marker dokazuje poškodenie, nie automaticky jeho uránovú príčinu.</strong></p>
<h3 id="fanconiho-syndrom">Fanconiho syndróm a jeho vzťah k uránu</h3><p>Fanconiho syndróm je generalizovaná porucha reabsorpcie v proximálnom tubule, nie Fanconiho anémia. Za <strong>úplný obraz</strong> sa považuje súčasná porucha viacerých transportných funkcií: normoglykemická glykozúria, generalizovaná aminoacidúria, fosfatúria s hypofosfatémiou, bikarbonatúria vedúca k proximálnej renálnej tubulárnej acidóze typu 2, urikozúria s hypourikémiou a nízkomolekulová proteinúria. Pridružiť sa môžu straty sodíka, draslíka, vápnika a horčíka, polyúria, polydipsia, dehydratácia, svalová slabosť a pri dlhšom trvaní rachitída u detí alebo osteomalácia a zlomeniny u dospelých. <strong>Neúplný alebo parciálny Fanconiho obraz</strong> znamená, že je prítomná iba časť porúch, napríklad izolovaná nízkomolekulová proteinúria s fosfatúriou, normoglykemická glykozúria alebo bikarbonátové straty, pričom eGFR môže byť ešte normálna. Univerzálny minimálny počet znakov pre „neúplný“ syndróm nie je ustálený. Uránom vyvolaná proximálna tubulopatia môže sama vytvoriť neúplný až úplný získaný Fanconiho fenotyp. Rovnaký obraz však spôsobujú aj tenofovir, ifosfamid, cisplatina, aminoglykozidy, monoklonové gamapatie, cystinóza a ďalšie dedičné choroby či iné toxické kovy. Fanconiho laboratórny obraz teda uránové poškodenie nielen napodobňuje, ale môže byť aj jeho priamym prejavom; bez preukázanej expozície a vylúčenia iných príčin neurčuje etiológiu. Pozri zdroje 37 a 38. </p><h2>Čo ukazujú štúdie u ľudí</h2>
<p>Epidemiologické údaje nie sú jednotné.</p>
<p>Staršie štúdie ľudí používajúcich vodu z vrtov s vyššou koncentráciou uránu našli slabé zmeny frakčnej exkrécie vápnika a fosfátu alebo nízkomolekulových bielkovín, často bez poklesu glomerulovej filtrácie. Následná fínska štúdia z roku 2006 nenašla presvedčivé cytotoxické poškodenie obličiek ani pri pomerne vysokej dlhodobej expozícii. Práve tieto údaje podporili súčasnú dočasnú smernú hodnotu WHO 30 µg/l.</p>
<p>Systematický prehľad a metaanalýza z roku 2024 zahrnuli 36 štúdií. Nezistili zvýšenú mortalitu na nádory obličiek ani chronickú nefritídu alebo nefrózu v uránom exponovaných populáciách. Väčšinu súborov však tvorili pracovníci, takže výsledok mohol skresliť efekt zdravého pracovníka; analýza funkčných biomarkerov bola nepresná pre malý počet štúdií a účastníkov.</p>
<p>V roku 2025 pribudli dva dôležité, ale zatiaľ nie definitívne signály:</p>
<ul>
<li>V podskupine 461 účastníkov štúdie MESA bez diabetu, CKD a kardiovaskulárneho ochorenia bola vyššia koncentrácia uránu v moči spojená s vyššími hodnotami KIM-1 a MCP-1, nie však s eGFR, albuminúriou ani viacerými ďalšími tubulárnymi biomarkermi.</li>
<li>V prospektívnej California Teachers Study so 88 185 ženami bola vyššia dlhodobá koncentrácia uránu vo verejnej pitnej vode spojená s vyšším rizikom hospitalizačne zachytenej stredne ťažkej až terminálnej CKD. Pri 10 až menej ako 15 µg/l bolo relatívne riziko oproti koncentrácii pod 2 µg/l vyššie približne o tretinu. Štúdia však nepoznala individuálnu spotrebu vody, mala obmedzenú prenosnosť na mužov a iné populácie a ako observačná štúdia nemôže sama dokázať príčinnosť.</li>
</ul>
<p>Nové výsledky preto spochybňujú predstavu úplne bezrizikovej expozície pod 30 µg/l, ale ešte neoprávňujú tvrdenie, že voda s 10 až 30 µg/l nevyhnutne poškodzuje obličky alebo že limit treba bez ďalšieho zmeniť. Potrebné sú replikácie, individuálna biomonitorácia, opakované meranie funkcie obličiek a lepšia kontrola súbežných kontaminantov.</p>
<h2>Urán v pitnej vode: limit nie je biologický prah</h2>
<p>WHO v aktuálnom vydaní smerníc naďalej uvádza dočasnú smernú hodnotu <strong>30 µg/l</strong>, odvodenú pre chemickú, nie rádiologickú toxicitu. Označenie „dočasná“ odráža neistotu toxikologických a epidemiologických údajov. WHO zároveň upozorňuje, že sa nepodarilo spoľahlivo určiť koncentráciu bez akéhokoľvek účinku.</p>
<p>Na Slovensku vyhláška Ministerstva zdravotníctva SR č. 91/2023 Z. z. stanovuje pre urán chemickú najvyššiu medznú hodnotu <strong>30 µg/l</strong>. Od 13. januára 2026 sa skríning prítomnosti rádionuklidov vykonáva stanovením celkovej objemovej aktivity alfa; pri výsledku nad 0,1 Bq/l sa určujú jednotlivé rádionuklidy podľa predpisov radiačnej ochrany. Poznámka vyhlášky považuje za prekročenie aj výsledok U-238 nad 0,3 Bq/l, ktorý uvádza ako ekvivalent 24 µg/l. Hmotnostná koncentrácia a objemová aktivita však nie sú zameniteľné veličiny. Pri konkrétnom náleze preto treba zohľadniť laboratórnu metódu, izotopové zloženie a výklad príslušného orgánu verejného zdravotníctva.</p>
<p>Prekročenie limitu nie je dôkazom, že už vzniklo poškodenie obličiek, ale je dôvodom na potvrdenie výsledku, vyšetrenie zdroja a obmedzenie dlhodobej expozície. Rovnako koncentrácia tesne pod limitom nie je zárukou nulového individuálneho rizika. Pre dojčatá, tehotné osoby, pacientov s CKD alebo jedinou funkčnou obličkou alebo súbežnou expozíciou ďalším nefrotoxínom je rozumný opatrnejší prístup, hoci presný osobitný prah pre tieto skupiny nie je určený.</p>
<p>Varenie urán z vody neodstráni; odparenie ho môže koncentrovať. Účinná býva reverzná osmóza, aniónová výmena a niektoré centrálne úpravárenské postupy. Zariadenie musí byť určené na daný kontaminant, odborne prevádzkované a jeho účinnosť treba potvrdiť analýzou vody po úprave. Zachytený urán sa koncentruje vo filtri alebo regeneráte, preto sa musí bezpečne zneškodniť.</p>
<h2>Urán a prirodzená rádioaktivita na území Slovenska a Česka</h2>
<h3>Ako správne čítať mapy</h3>
<p>Geologická mapa výskytu uránu nie je mapou poškodenia obličiek. Medzi uránonosnou horninou a dávkou prijatou človekom stoja hydrogeológia, rozpustnosť konkrétnych zlúčenín, úprava vody, prašnosť, spôsob využitia územia, čas expozície a individuálne správanie. Na úrovni Slovenska ani Česka nie je k dispozícii validovaná mapa prípadov „uránovej nefropatie“. Nasledujúce mapy preto zobrazujú <strong>geogénny expozičný potenciál</strong>, historickú alebo súčasnú banskú a sanačnú záťaž a regionálne radiačné pozadie. Nezobrazujú individuálnu dávku, koncentráciu v konkrétnej studni ani zdravotný následok.</p>
<h3>Slovensko</h3>
<p>Uránové zrudnenia na Slovensku sú viazané na geologicky pestré prostredie Západných Karpát. Odborná literatúra historicky eviduje viac ako 40 ložísk a výskytov v siedmich oblastiach. Najvýraznejší pás leží vo východnej časti Slovenského rudohoria. Patrí sem <strong>Novoveská Huta</strong> pri Spišskej Novej Vsi, kde sa urán v minulosti dobýval, a <strong>Kurišková</strong>, označovaná aj podľa blízkej Jahodnej, približne 7 km severozápadne od Košíc. Kurišková je významné preskúmané, ale neťažené ložisko.</p>
<p>Ďalšie uránové alebo uránovo-molybdénové prejavy sú známe v oblasti <strong>Kálnice v Považskom Inovci</strong>, pri <strong>Dúbrave v Nízkych Tatrách</strong>, na <strong>Vikartovskom chrbte</strong> a lokálne v ďalších kryštalinických, sedimentárnych a vulkanických komplexoch. Environmentálny význam konkrétnej lokality sa nedá odvodiť iba z tonáže ložiska. Pre človeka môže byť dôležitejší menší, ale rozpustnejší zdroj napojený na používanú podzemnú vodu alebo staré banské dielo než veľké, mineralogicky pevne viazané ložisko bez expozičnej cesty.</p>
<h3>Česko</h3>
<p>České krajiny majú vzhľadom na rozsiahle granitoidné a metamorfované komplexy Českého masívu početnejšie uránové revíry a dlhšiu históriu ťažby. Medzi hlavné patria <strong>Jáchymov</strong>, <strong>Horní Slavkov</strong>, <strong>Zadní Chodov</strong>, <strong>Příbram</strong>, <strong>Stráž pod Ralskem a Hamr na Jezeře</strong>, <strong>Rožná a Dolní Rožínka</strong>, <strong>Okrouhlá Radouň</strong> a juhočeské spracovateľské a odkaliskové areály pri <strong>Mydlovaroch</strong>. <strong>Brzkov</strong> je preskúmané, no pri príprave tejto syntézy neťažené ložisko.</p>
<p>Komerčná ťažba uránu sa v Česku skončila 31. decembra 2016. Štátny podnik DIAMO však naďalej vykonáva likvidáciu a sanáciu starých baní, chemickej ťažby a odkalísk; urán sa môže získavať ako vedľajší produkt sanačných vôd v Stráži pod Ralskem a pri čistení banských vôd v oblastiach Příbrami a Rožnej. Ide o kontrolované priemyselné situácie, nie o dôkaz plošnej expozície obyvateľstva.</p>
<p>Český právny limit uránu v pitnej vode je <strong>15 µg/l</strong>, teda nižší než slovenských a WHO odporúčaných 30 µg/l. Rozdiel medzi limitmi neznamená rozdielnu biologickú citlivosť obyvateľstva. Ide o odlišné národné regulačné rozhodnutie v oblasti neistoty a realizovateľnosti úpravy vody. Český Štátny ústav radiačnej ochrany upozorňuje, že pri podzemných vodách môže byť zvýšená celková alfa aktivita často spôsobená práve uránom. Verejné zdroje podliehajú kontrole; lokálne najväčšiu informačnú medzeru predstavujú individuálne studne bez pravidelnej analýzy.</p>
<div aria-hidden="true" class="pdf-page-break"></div><figure><a href="img/uran-slovensko-cesko.webp" rel="noopener noreferrer" target="_blank"><img alt="Orientačná mapa uránových oblastí, historickej ťažby a sanačných lokalít na Slovensku a v Česku" decoding="async" height="2300" loading="lazy" src="img/uran-slovensko-cesko.webp" width="3750"/></a><figcaption>Výberová regionálna syntéza uránových oblastí, historickej ťažby a sanačných lokalít na Slovensku a v Česku. Mapa neurčuje koncentráciu v konkrétnej vode ani individuálne zdravotné riziko.</figcaption></figure>
<h3>Radón: plošná mapa je iba prvý filter</h3>
<p>Na Slovensku bola oficiálna mapa radónového rizika zostavená z 9 219 referenčných plôch. V použitej databáze bolo 36,7 % plôch zaradených do nízkeho, 63,0 % do stredného a 0,3 % do vysokého radónového rizika. Lokálne vysoké hodnoty sa vyskytujú napríklad pri uránonosných dolomitoch v okolí Brezovej pod Bradlom a Vrbového, v oblasti Kálnice, pri novobanských ryolitoch, v častiach Nízkych Tatier a najrozsiahlejšie v pásme Spišsko-gemerského rudohoria medzi Spišskou Novou Vsou, Rožňavou a Košicami. Bodové anomálie sú známe aj inde, preto farebná kategória regiónu nevylučuje problém na konkrétnej parcele.</p>
<p>V Česku je priemerná objemová aktivita radónu v obydliach približne <strong>118 Bq/m³</strong>, čo krajinu radí medzi štáty s vyššou priemernou vnútornou expozíciou. Zvýšený potenciál je rozšírený najmä v granitoidných a metamorfovaných oblastiach Českého masívu. Geologická prognóza však nevie nahradiť dlhodobé meranie v budove. Prienik radónu ovplyvňujú pukliny, priepustnosť podložia, základy, tlakové pomery, vetranie aj stavebné úpravy.</p>
<p>Z nefrologického hľadiska je podstatné, že tieto mapy nepredstavujú mapy rizika zlyhania obličiek. Radón je predovšetkým dokázaný pľúcny karcinogén. Súčasné epidemiologické údaje neposkytujú presvedčivý dôkaz, že by bežná domová expozícia radónu bola samostatnou príčinou CKD.</p>
<div aria-hidden="true" class="pdf-page-break"></div><figure><a href="img/radon-slovensko-cesko.webp" rel="noopener noreferrer" target="_blank"><img alt="Orientačná mapa radónového potenciálu Slovenska a Česka" decoding="async" height="2300" loading="lazy" src="img/radon-slovensko-cesko.webp" width="3750"/></a><figcaption>Orientačná regionálna syntéza radónového potenciálu Slovenska a Česka. Nenahrádza dlhodobé meranie v budove ani radónový index konkrétneho pozemku.</figcaption></figure>
<h3>Prirodzené gama pozadie a ďalšie rádionuklidy</h3>
<p>Terestrické gama pozadie nevytvára iba urán. Významne k nemu prispievajú <strong>draslík-40</strong>, uránové a tóriové rozpadové rady a geochemické vlastnosti hornín a pôd. V Česku sa v celoštátnej rádiometrickej syntéze uvádza príkon absorbovanej dávky terestrického gama žiarenia vo vzduchu približne <strong>6 až 245 nGy/h</strong>, s priemerom <strong>65,6 ± 19 nGy/h</strong>; 90 % hodnôt ležalo medzi 31 a 88 nGy/h. Zvýšené hodnoty sú viazané napríklad na stredočeský plutón, Karlovarsko a Jáchymovsko, krkonošsko-jizerské granitoidy a niektoré masívy Vysočiny. Nízke hodnoty sa častejšie objavujú na pieskovcoch, kremencoch a niektorých bázických horninách.</p>
<p>Na Slovensku oficiálna rádiometrická mapa zvýrazňuje najmä kryštalinické a vulkanické komplexy, vrátane častí Nízkych Tatier, novobanských ryolitov a Spišsko-gemerského rudohoria. V použitých verejných podkladoch však nebola nájdená jednotná, metodicky porovnateľná celoštátna priemerná hodnota, preto mapa používa kvalitatívne triedy a nepredstiera presnosť, ktorú zdroje neposkytujú. Európsky atlas prirodzenej rádioaktivity je vhodný na regionálne porovnanie, nie na posúdenie domu, studne alebo pracoviska.</p>
<div aria-hidden="true" class="pdf-page-break"></div><figure><a href="img/prirodzena-radioaktivita-slovensko-cesko.webp" rel="noopener noreferrer" target="_blank"><img alt="Orientačná mapa prirodzeného terestrického gama pozadia Slovenska a Česka" decoding="async" height="2300" loading="lazy" src="img/prirodzena-radioaktivita-slovensko-cesko.webp" width="3750"/></a><figcaption>Orientačná regionálna syntéza prirodzeného terestrického gama pozadia. Farebné plochy nie sú odčítateľnou dozimetriou ani mapou poškodenia obličiek.</figcaption></figure>
<h2>Urán, radón a prirodzená rádioaktivita v Európskej únii</h2>
<h3>Rozsah a obmedzenia európskych máp</h3>
<p>Európsky atlas prirodzenej rádioaktivity, ktorý spravuje Spoločné výskumné centrum Európskej komisie (EC-JRC), harmonizuje údaje s rozdielnym pôvodom a kvalitou. Mapa uránu v pôde používa sieť 10 × 10 km, mapa uránu v horninovom podloží priemery v geologických jednotkách a mapa radónu priemerné ročné koncentrácie namerané v prízemných miestnostiach, agregované do siete 10 × 10 km. Pôvodné merania zostávajú u národných poskytovateľov a európska mapa sa aktualizuje nepravidelne. Posledná uvedená aktualizácia mapy vnútorného radónu je z 11. novembra 2024.</p>
<p>Nasledujúce mapy zobrazujú európske územie 27 členských štátov EÚ. Najvzdialenejšie zámorské regióny nie sú zahrnuté do hlavného výrezu a malé ostrovné štáty majú obmedzenú kartografickú čitateľnosť. Farebné plochy sú odbornou regionálnou syntézou atlasových a národných údajov, nie reprodukciou odčítateľnej dátovej vrstvy. Neumožňujú určiť koncentráciu v studni, dávku obličiek ani počet ochorení.</p>
<h3>Uránové oblasti a banské dedičstvo EÚ</h3>
<p>Geogénne zvýšené koncentrácie uránu sa v EÚ viažu najmä na staré kryštalinické masívy, granitoidy, metamorfované komplexy, niektoré permské vulkanosedimentárne panvy a lokálne pieskovcové ložiská. Výraznejšie oblasti tvoria <strong>Iberský masív</strong> v Portugalsku a západnom Španielsku, <strong>Armorický a Centrálny masív</strong> vo Francúzsku, <strong>Český masív a Krušné hory</strong> na styku Česka, Nemecka, Poľska a Rakúska, <strong>Fenoskandijský štít</strong> vo Švédsku a Fínsku a karpatsko-balkánske komplexy Slovenska, Maďarska, Rumunska a Bulharska.</p>
<p>Mapa vyznačuje iba reprezentatívny výber významných oblastí. K najväčším historickým a sanačným komplexom patria Urgeiriça v Portugalsku, Saelices el Chico a Andújar v Španielsku, francúzske lokality v Limousine a ďalších oblastiach, nemecké komplexy Wismut v Sasku a Durínsku, české revíry, poľské Kowary, maďarský Mecsek, slovinský Žirovski vrh, rumunské oblasti Crucea, Băița a Banát a bulharské Buhovo. Vo Francúzsku Orano uvádza stovky bývalých lokalít pod environmentálnym dohľadom; v Nemecku pokračuje rozsiahla sanácia Wismut. V Česku sa urán získava už iba ako vedľajší produkt sanačných a banských vôd. Historická ťažba alebo existencia odkaliska automaticky neznamená súčasnú expozíciu obyvateľov, ale je dôvodom na dlhodobý monitoring vôd, prachu, radónu a potravinového reťazca.</p>
<div aria-hidden="true" class="pdf-page-break"></div><figure><a href="img/uran-europska-unia.webp" rel="noopener noreferrer" target="_blank"><img alt="Orientačná mapa uránových oblastí a banského dedičstva Európskej únie" decoding="async" height="3125" loading="lazy" src="img/uran-europska-unia.webp" width="4000"/></a><figcaption>Výberová regionálna syntéza uránonosných oblastí, historickej ťažby, spracovania a sanácie v EÚ. Nezobrazuje všetky lokality ani individuálnu expozíciu.</figcaption></figure>
<h3>Radón v EÚ</h3>
<p>Vyššie priemerné vnútorné koncentrácie a geogénny potenciál sa vyskytujú mozaikovito v Iberskom masíve, Bretónsku a Centrálnom masíve, Ardenách, Schwarzwalde, Krušných horách a Českom masíve, v častiach Rakúska a Álp, vo Fenoskandii, v slovensko-rumunskom karpatskom oblúku, Slovinsku, Chorvátsku a lokálne na Balkáne. Aj v prevažne nízkorizikovom regióne môže jednotlivá budova dosiahnuť vysokú koncentráciu a naopak. Rozhodujúce je dlhodobé meranie v používanej miestnosti.</p>
<p>Smernica 2013/59/Euratom vyžaduje, aby členské štáty stanovili národnú referenčnú úroveň ročného priemeru radónu v budovách, ktorá nemá byť vyššia ako <strong>300 Bq/m³</strong>, prijali národné radónové akčné plány a identifikovali oblasti, kde sa očakáva prekročenie referenčnej úrovne vo významnom počte budov. Ide o referenčnú úroveň na riadenie a znižovanie expozície, nie o ostrú hranicu medzi bezpečnosťou a poškodením.</p>
<div aria-hidden="true" class="pdf-page-break"></div><figure><a href="img/radon-europska-unia.webp" rel="noopener noreferrer" target="_blank"><img alt="Orientačná mapa radónového potenciálu Európskej únie" decoding="async" height="3125" loading="lazy" src="img/radon-europska-unia.webp" width="4000"/></a><figcaption>Orientačná regionálna syntéza radónového potenciálu v EÚ podľa údajov EC-JRC. Koncentráciu v konkrétnej budove možno určiť iba meraním.</figcaption></figure>
<h3>Prirodzené terestrické gama pozadie v EÚ</h3>
<p>Terestrické gama žiarenie pochádza najmä z draslíka-40 a uránových a tóriových rozpadových radov. Zvýšené regionálne hodnoty sa častejšie viažu na granitoidy Iberského, Armorického, Centrálneho a Českého masívu, Fenoskandijský štít, časti Álp, Karpát a Balkánu. Nižšie hodnoty bývajú v mladých sedimentárnych panvách a nížinách, napríklad v častiach severoeurópskej nížiny, Panónskej panvy a Pádskej nížiny. Tieto vzťahy majú početné lokálne výnimky.</p>
<p>Mapa terestrického gama pozadia nie je mapou celkovej ročnej efektívnej dávky. Nezahŕňa automaticky radón v budove, kozmické žiarenie, medicínske vyšetrenia ani vnútorný príjem rádionuklidov. Európska vrstva navyše kombinuje údaje vyjadrené podľa štátu ako príkon absorbovanej dávky alebo okolitého dávkového ekvivalentu, pričom JRC upozorňuje na metodické rozdiely a potrebu harmonizácie.</p>
<div aria-hidden="true" class="pdf-page-break"></div><figure><a href="img/prirodzena-radioaktivita-europska-unia.webp" rel="noopener noreferrer" target="_blank"><img alt="Orientačná mapa prirodzeného terestrického gama pozadia Európskej únie" decoding="async" height="3125" loading="lazy" src="img/prirodzena-radioaktivita-europska-unia.webp" width="4000"/></a><figcaption>Orientačná regionálna syntéza prirodzeného terestrického gama pozadia v EÚ. Nezahŕňa automaticky radón v budovách, kozmické žiarenie ani medicínske expozície.</figcaption></figure>
<h3>Pitná voda a európske regulačné minimum</h3>
<p>Smernica 2013/51/Euratom stanovuje pre rádioaktívne látky v pitnej vode parametrickú hodnotu <strong>100 Bq/l pre radón</strong>, <strong>100 Bq/l pre trícium</strong> a <strong>0,10 mSv za rok pre indikatívnu dávku</strong> z relevantných rádionuklidov. Odporúčané skríningové úrovne sú 0,1 Bq/l pre celkovú alfa aktivitu a 1,0 Bq/l pre celkovú beta aktivitu; prekročenie vedie k stanoveniu konkrétnych rádionuklidov. Členské štáty môžu pre radón vo vode určiť národnú hodnotu vyššiu než 100 Bq/l, najviac však 1 000 Bq/l.</p>
<p>EÚ nemá jednotnú chemickú koncentráciu uránu v pitnej vode porovnateľnú so smernou hodnotou WHO 30 µg/l. Členské štáty preto používajú vlastné chemické limity alebo posudzujú urán prostredníctvom národných vodárenských a radiačno-hygienických pravidiel. To vysvetľuje, prečo sa česká hodnota 15 µg/l líši od slovenskej hodnoty 30 µg/l bez toho, aby išlo o rozdielnu biologickú citlivosť populácií.</p>
<h2>Kedy poškodzuje obličky samotné ionizujúce žiarenie</h2>
<p>Radiačná nefropatia je samostatná klinicko-patologická jednotka. Po dostatočnej dávke žiarenia vzniká poškodenie glomerulových a peritubulárnych endoteliálnych buniek, mikrovaskulárne zmeny, trombotická mikroangiopatia, glomeruloskleróza, tubulárna atrofia a intersticiálna fibróza. Klinicky sa po latencii mesiacov až rokov objavuje hypertenzia, proteinúria, pokles GFR a niekedy anémia.</p>
<p>ICRP uvádza približný prah klinicky významnej reakcie celej obličky okolo 7 až 8 Gy pri akútnej expozícii a približne 18 až 20 Gy pri dávke rozdelenej do 2-Gy frakcií. Tieto hodnoty vychádzajú najmä z rádioterapie a nemožno ich mechanicky prepočítať na nerovnomerné ožiarenie alfa časticami z vnútorného kontaminantu. Poskytujú však dôležitú mierku: absorbované dávky schopné vyvolať klasickú radiačnú nefropatiu sú spravidla rádovo vyššie než dávky obličiek z bežného príjmu prírodného uránu v životnom prostredí. Pri takejto environmentálnej expozícii preto dominuje chemická nefrotoxicita.</p>
<h2>Rádium, radón a ďalšie prírodné rádionuklidy</h2>
<h3>Rádium</h3>
<p>Rádium vzniká v rozpadových radoch uránu a tória a môže sa nachádzať v horninách, banských odpadoch aj podzemnej vode. Chemicky sa podobá vápniku a po absorpcii sa ukladá najmä do kostí. Historicky jednoznačne doloženými následkami vysokej vnútornej expozície boli poškodenie kostí, osteosarkómy a nádory niektorých štruktúr hlavy. Oblička nie je jeho klasickým cieľovým orgánom a dostupné údaje nepodporujú rádium ako bežnú príčinu tubulopatie alebo CKD. Pri masívnej kontaminácii môže byť súčasťou celkovej radiačnej záťaže, no mechanizmus a distribúcia sa zásadne líšia od uránu.</p>
<h3>Radón</h3>
<p>Radón je rádioaktívny plyn vznikajúci najmä z rádia v zemskej kôre. Hlavnou cestou expozície je vdýchnutie radónu a jeho krátkožijúcich dcérskych produktov v budovách a baniach; najlepšie dokázaným následkom je karcinóm pľúc. Metaanalýza observačných štúdií nenašla jasnú asociáciu s karcinómom obličky a dôkazy o radóne ako príčine CKD alebo zlyhania obličiek chýbajú. Radón rozpustený vo vode sa pri sprchovaní a používaní vody uvoľňuje do vzduchu; po prehltnutí sa radiačná dávka týka skôr tráviaceho traktu než selektívne obličiek.</p>
<h3>Ostatné rádionuklidy</h3>
<p>Tórium, polónium, rádionuklidy cézia a stroncia či transurány majú odlišnú biokinetiku. Stroncium a rádium sú prevažne kostné depozitá, cézium sa distribuuje v mäkkých tkanivách a niektoré izotopy polónia alebo plutónia sa hromadia v pečeni, kostiach a ďalších orgánoch. Pri veľkej vnútornej kontaminácii alebo celotelovom ožiarení môže vzniknúť multiorgánové poškodenie vrátane AKI. To však nie je dôkaz, že nízka prirodzená koncentrácia týchto prvkov v prostredí je častou samostatnou príčinou chronického zlyhania obličiek.</p>
<h2>Porovnanie s ďalšími nefrotoxickými kovmi</h2>
<div class="table-responsive" role="region" aria-label="Porovnanie s ďalšími nefrotoxickými kovmi" tabindex="0">
<table>
<thead>
<tr>
<th scope="col">Kov alebo metaloid</th>
<th scope="col">Typický zdroj</th>
<th scope="col">Prevažujúci obličkový účinok</th>
<th scope="col">Poznámka</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Kadmium</strong></td>
<td>tabakový dym, hutníctvo, batérie, kontaminovaná potrava a voda</td>
<td>chronická proximálna tubulopatia, nízkomolekulová proteinúria, Fanconiho syndróm, pokles GFR</td>
<td>kumuluje sa veľmi dlho; tubulopatia zvyšuje straty vápnika a fosfátu a môže zhoršiť kostné ochorenie</td>
</tr>
<tr>
<td><strong>Olovo</strong></td>
<td>staré nátery a potrubia, batérie, priemysel, strelnice</td>
<td>akútna proximálna tubulopatia; chronická tubulointersticiálna nefritída, hypertenzia, hyperurikémia</td>
<td>vyššie riziko pri dlhodobej pracovnej expozícii a súbežných kardiovaskulárnych faktoroch</td>
</tr>
<tr>
<td><strong>Anorganická ortuť</strong></td>
<td>priemysel, niektoré tradičné prípravky a krémy, nehody</td>
<td>akútne tubulárne poškodenie až AKI; pri chronickej expozícii aj glomerulárne ochorenie, napríklad membranózna nefropatia</td>
<td>metylortuť je primárne neurotoxická; klinika závisí od chemickej formy</td>
</tr>
<tr>
<td><strong>Arzén</strong></td>
<td>kontaminovaná podzemná voda, hutníctvo, pesticídne rezíduá</td>
<td>pri vysokej dávke AKI; pri chronickej expozícii možná asociácia s albuminúriou a CKD</td>
<td>epidemiologické výsledky pri nízkej dávke sú heterogénne a často ich mätú ďalšie kontaminanty</td>
</tr>
<tr>
<td><strong>Chróm VI</strong></td>
<td>galvanizácia, pigmenty, kožiarsky a kovospracujúci priemysel</td>
<td>pri akútnej vysokej expozícii akútna tubulárna nekróza a AKI</td>
<td>chróm III má inú biologickú úlohu a toxicitu; rozhoduje oxidačný stav</td>
</tr>
<tr>
<td><strong>Urán</strong></td>
<td>geologické podložie a studne, bane, jadrový cyklus, ochudobnený urán</td>
<td>proximálna tubulopatia; pri vysokej dávke AKI, pri chronickej expozícii možné skoré tubulárne zmeny a riziko CKD</td>
<td>pri bežnej environmentálnej expozícii je chemické riziko pre obličky významnejšie než radiačné</td>
</tr>
</tbody>
</table>
</div>
<p>Zmesi kovov môžu pôsobiť aditívne, synergicky alebo niekedy menej než aditívne. Pri kontaminovanej vode preto nestačí vyšetriť iba urán; podľa geologického a priemyselného kontextu treba zvážiť arzén, kadmium, olovo, chróm, mangán, rádium a ďalšie látky.</p>
<h2>Praktický návod pre klinického nefrológa</h2>
<h3>U ktorých pacientov treba cielene myslieť na environmentálnu alebo pracovnú nefrotoxicitu</h3>
<p>Plošný skríning uránu alebo všetkých kovov u každého pacienta s CKD nie je odôvodnený. Cielené vyšetrenie má najvyššiu výťažnosť vtedy, keď sa spája <strong>kompatibilný obličkový fenotyp</strong> s <strong>vierohodnou expozičnou cestou</strong> a primeraným časovým vzťahom.</p>
<div class="table-responsive" role="region" aria-label="U ktorých pacientov treba cielene myslieť na environmentálnu alebo pracovnú nefrotoxicitu" tabindex="0">
<table>
<thead>
<tr>
<th scope="col">Klinická situácia</th>
<th scope="col">Prečo je podozrivá</th>
<th scope="col">Bezprostredný praktický krok</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Nová normoglykemická glykozúria, hypofosfatémia, hypourikémia, hyperchloremická acidóza alebo nízkomolekulová proteinúria</strong></td>
<td>typický proximálny tubulárny alebo Fanconiho fenotyp, ktorý môže vyvolať urán, kadmium, olovo, ortuť aj lieky</td>
<td>súčasne odobrať krv a moč na kreatinín, glukózu, fosfát, urát, bikarbonát a elektrolyty; vypočítať frakčné exkrécie a cielene doplniť expozičnú anamnézu</td>
</tr>
<tr>
<td><strong>Celková proteinúria je zreteľne vyššia než albuminúria</strong></td>
<td>bežný močový prúžok a ACR môžu prehliadnuť tubulárne nízkomolekulové bielkoviny</td>
<td>doplniť PCR, α1- alebo β2-mikroglobulín v moči, elektroforézu a pri dospelom aj vyšetrenie monoklonálnej gamapatie</td>
</tr>
<tr>
<td><strong>Nevysvetlené AKI po pracovnej nehode, požiari, demolácii, brúsení, tavení, expozícii prachu, chemikáliám alebo kontaminovanej vode</strong></td>
<td>môže ísť o akútnu vysokú expozíciu rozpustnému uránu, chrómu VI, anorganickej ortuti, kadmiu, arzénu alebo zmesi látok</td>
<td>stabilizovať pacienta, kontaktovať toxikológa a pracovné lekárstvo, uchovať vhodné vzorky ešte pred dialýzou alebo veľkou infúznou liečbou, ak to neodkladá urgentnú starostlivosť</td>
</tr>
<tr>
<td><strong>Nevysvetlená CKD alebo tubulointersticiálne ochorenie u pracovníka v rizikovom odvetví</strong></td>
<td>chronické expozície bývajú klinicky tiché a eGFR klesá neskoro</td>
<td>vypracovať pracovný časový profil, získať výsledky pracovného biomonitoringu a vybrať biomarker podľa konkrétneho kovu</td>
</tr>
<tr>
<td><strong>CKD u používateľa individuálnej studne v uránonosnej, banskej alebo priemyselne zaťaženej oblasti</strong></td>
<td>podzemná voda môže obsahovať urán, arzén, rádium, mangán alebo zmes kovov bez zmeny chuti a zápachu</td>
<td>analyzovať samotnú vodu v akreditovanom laboratóriu; miesto bydliska bez analýzy vody nie je dôkazom expozície</td>
</tr>
<tr>
<td><strong>Hypertenzia, hyperurikémia alebo dna s chronickou tubulointersticiálnou nefritídou a expozíciou olovu</strong></td>
<td>klasická, hoci nešpecifická kombinácia pri chronickej olovnatej nefropatii</td>
<td>stanoviť olovo vo venóznej plnej krvi a pátrať po pracovnom, hobby alebo domácom zdroji</td>
</tr>
<tr>
<td><strong>Tubulopatia s bolesťami kostí, osteomaláciou, zlomeninami alebo výraznou fosfatúriou</strong></td>
<td>dlhodobé straty fosfátu sú typické pre Fanconiho fenotyp; kadmium súčasne poškodzuje tubuly a kostný metabolizmus</td>
<td>doplniť fosfátový metabolizmus, vitamín D, PTH, ALP, frakčnú exkréciu fosfátu a cielený test kadmia</td>
</tr>
<tr>
<td><strong>AKI alebo proteinúria spolu s tremorom, eretizmom, poruchou citlivosti, stomatitídou alebo expozíciou ortuti</strong></td>
<td>anorganická ortuť môže poškodiť tubuly aj glomeruly; neurologické prejavy posilňujú expozičnú hypotézu</td>
<td>podľa formy expozície odobrať moč alebo plnú krv na ortuť a konzultovať toxikológa</td>
</tr>
<tr>
<td><strong>AKI s gastrointestinálnymi ťažkosťami, neuropatiou, kožnými zmenami alebo epidemiologickou väzbou na vodu a arzén</strong></td>
<td>vysoká expozícia arzénu môže spôsobiť multiorgánovú toxicitu; chronická expozícia má systémové prejavy</td>
<td>odobrať moč na celkový arzén a špeciáciu, zaznamenať konzumáciu morských živočíchov a vyšetriť vodu</td>
</tr>
<tr>
<td><strong>Nová hypertenzia, proteinúria, anémia a pokles GFR po ožiarení oboch obličiek, celotelovom ožiarení alebo vybranej rádionuklidovej liečbe</strong></td>
<td>kompatibilný obraz radiačnej nefropatie s latenciou mesiacov až rokov</td>
<td>vyžiadať rádioterapeutický plán a orgánovú dozimetriu, overiť dávku do každej obličky a vylúčiť trombotickú mikroangiopatiu a iné príčiny</td>
</tr>
<tr>
<td><strong>Zadržaný kovový fragment po zásahu alebo výbuchu, najmä s podozrením na ochudobnený urán</strong></td>
<td>fragment môže predstavovať dlhodobý vnútorný zdroj, hoci riziko závisí od zloženia, rozpustnosti a polohy</td>
<td>neodstraňovať automaticky; vykonať zobrazovanie, toxikologické a chirurgické posúdenie a organizovať močový urán s izotopovým pomerom</td>
</tr>
<tr>
<td><strong>Viacerí podobne postihnutí ľudia zo spoločného pracoviska, domácnosti alebo vodného zdroja</strong></td>
<td>zhluk zvyšuje pravdepodobnosť spoločnej environmentálnej príčiny</td>
<td>koordinovať verejné zdravotníctvo, pracovné lekárstvo, toxikológiu a akreditované environmentálne odbery</td>
</tr>
</tbody>
</table>
</div>
<p>Samotné bývanie v oblasti označenej na mape ako uránonosná alebo radónová, nešpecifická únava, izolovane zvýšený kreatinín alebo pozitívny komerčný vlasový test predstavujú <strong>nízku predtestovú pravdepodobnosť</strong>. Bez kompatibilného fenotypu a overenej expozičnej cesty môžu široké panely viesť k falošne pozitívnym výsledkom a nesprávnej chelatácii.</p>
<h3>Expozičná anamnéza, ktorú sa oplatí viesť systematicky</h3>
<p>Nefrológ má zaznamenať nielen názov povolania, ale konkrétnu činnosť, materiál, ochranné pomôcky, vetranie, dĺžku práce a čas od poslednej expozície. Dôležité sú najmä:</p>
<ul>
<li>baníctvo, razenie tunelov, geologický prieskum, drvenie rudy, sanácia baní a odkalísk, jadrový palivový cyklus a práca s fosfátmi;</li>
<li>hutníctvo, zváranie, galvanizácia, chrómovanie, výroba pigmentov, skla, keramiky, batérií, elektroniky a recyklácia elektroodpadu;</li>
<li>strelnice, odlievanie závaží a projektilov, brúsenie starých náterov, renovácie, vitráže, glazúry a hobby chémia;</li>
<li>vojenská služba, zásahové miesta, požiare skladov, munícia, kovové fragmenty a prašné demolácie;</li>
<li>zdroj pitnej vody, hĺbka a vek studne, sezónnosť, úprava vody, predchádzajúce rozbory a používanie vody na varenie;</li>
<li>fajčenie a pasívne fajčenie, ktoré sú významným zdrojom kadmia a mätúcim faktorom pri jeho biomonitorovaní;</li>
<li>ryby a morské plody, tradičné a ajurvédske prípravky, neoverené doplnky, bieliace krémy, keramické nádoby a domáca destilácia;</li>
<li>lieky schopné vyvolať Fanconiho fenotyp, najmä tenofovir, ifosfamid, cisplatina, aminoglykozidy a niektoré staršie tetracyklíny;</li>
<li>rádioterapia, celotelové ožiarenie pred transplantáciou, rádionuklidová liečba a dostupná orgánová dozimetria.</li>
</ul>
<p>Časový údaj je rozhodujúci. Krvný marker môže odrážať posledné dni alebo týždne, močový marker buď nedávnu expozíciu, alebo pri niektorých kovoch telesnú nálož. Výsledok odobratý dlho po ukončení práce nemusí rekonštruovať historickú dávku.</p>
<h3>Praktický postup pri prvej nefrologickej návšteve</h3>
<ol>
<li><strong>Najprv klasifikovať poškodenie.</strong> Určiť AKI, AKD alebo CKD, tlak, objemový stav a urgentné komplikácie. Expozícia nesmie odviesť pozornosť od sepsy, obštrukcie, glomerulonefritídy, rabdomyolýzy alebo liekovej toxicity.</li>
<li><strong>Odobrať základný párový profil krvi a moču.</strong> Kreatinín, urea, glukóza, sodík, draslík, chloridy, bikarbonát alebo ABR, fosfát, horčík, vápnik a urát; v tom istom čase moč na chemické vyšetrenie, sediment, glukózu, kreatinín, albumín a celkovú bielkovinu.</li>
<li><strong>Vyhodnotiť proximálny tubulus.</strong> ACR porovnať s PCR, vypočítať frakčné exkrécie fosfátu a urátu a podľa obrazu sodíka, draslíka a horčíka. Doplniť α1- alebo správne odobratý β2-mikroglobulín v moči. Pri nevysvetlenej fosfatúrii možno vypočítať tubulárnu reabsorpciu fosfátu alebo TmP/GFR.</li>
<li><strong>Vylúčiť bežnejšie napodobeniny.</strong> HbA1c, lieky, sérová a močová imunofixácia a voľné ľahké reťazce podľa veku a obrazu, autoimunitná diagnostika podľa kliniky a ultrazvuk obličiek a močových ciest.</li>
<li><strong>Až potom vybrať toxikologický test.</strong> Test sa volí podľa konkrétnej látky a času od expozície, nie ako univerzálny „panel ťažkých kovov“. Pred neobvyklým odberom treba telefonicky potvrdiť materiál, nádobu, konzerváciu, transport, akreditáciu metódy a referenčné medze.</li>
<li><strong>Zdroj vyšetriť oddelene od pacienta.</strong> Voda, pracovný prach, náter alebo doplnok výživy sú environmentálne vzorky. Výsledok zdroja podporuje expozičnú cestu, ale nenahrádza biomonitorovanie ani dôkaz poškodenia obličiek.</li>
<li><strong>Naplánovať dynamiku.</strong> Opakovať kreatinín, elektrolyty, ACR/PCR a tubulárne ukazovatele po odstránení zdroja. Zlepšenie po deexpozícii podporuje kauzalitu, ale nie je samo osebe špecifické.</li>
</ol>
<h3>Cielený biomonitoring podľa podozrivej látky</h3>
<div class="table-responsive" role="region" aria-label="Cielený biomonitoring podľa podozrivej látky" tabindex="0">
<table>
<thead>
<tr>
<th scope="col">Podozrivá látka</th>
<th scope="col">Preferovaný biologický test</th>
<th scope="col">Čo výsledok približne odráža</th>
<th scope="col">Najdôležitejšie úskalie</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Urán</strong></td>
<td>celkový urán v moči pomocou ICP-MS, podľa situácie 24-hodinový zber alebo bodová vzorka s kreatinínom; izotopový pomer</td>
<td>vnútornú, prevažne nedávnu alebo pokračujúcu expozíciu; izotopový pomer môže určiť typ uránu</td>
<td>bežné slovenské klinické laboratóriá test rutinne neponúkajú; metóda pre vodu nie je automaticky validovaná pre ľudský moč</td>
</tr>
<tr>
<td><strong>Olovo</strong></td>
<td>olovo vo venóznej plnej krvi</td>
<td>recentnú a pokračujúcu expozíciu, nie presnú celoživotnú kostnú nálož</td>
<td>kapilárny skríning sa môže kontaminovať; „provokovaný“ moč po chelátore nie je diagnostický test</td>
</tr>
<tr>
<td><strong>Kadmium</strong></td>
<td>kadmium v moči korigované na kreatinín a kadmium v plnej krvi</td>
<td>moč pri stabilnej funkcii obličiek skôr kumulatívnu telesnú nálož, krv recentnú expozíciu</td>
<td>fajčenie zvyšuje hodnoty; pokročilé tubulárne poškodenie a zmenená GFR komplikujú interpretáciu močového kadmia</td>
</tr>
<tr>
<td><strong>Anorganická alebo elementárna ortuť</strong></td>
<td>ortuť v moči, často 24-hodinovom alebo korigovanom na kreatinín</td>
<td>expozíciu anorganickej a elementárnej ortuti</td>
<td>vzorka a čas odberu sa majú dohodnúť pred liečbou; forma ortuti rozhoduje o vhodnom médiu</td>
</tr>
<tr>
<td><strong>Metylortuť</strong></td>
<td>ortuť v plnej krvi, podľa potreby špeciácia</td>
<td>nedávnu expozíciu organickej ortuti, najmä z potravy</td>
<td>celková ortuť bez špeciácie môže miešať potravinový a pracovný zdroj; vlas nie je vhodný univerzálny klinický test nefrotoxicity</td>
</tr>
<tr>
<td><strong>Arzén</strong></td>
<td>arzén v moči so špeciáciou, bodová vzorka s kreatinínom alebo 24-hodinový zber</td>
<td>nedávnu expozíciu a po špeciácii toxikologicky relevantné anorganické formy a metabolity</td>
<td>morské živočíchy môžu výrazne zvýšiť netoxické organické formy; treba zaznamenať stravu a podľa pokynu laboratória odber zopakovať po ich vynechaní</td>
</tr>
<tr>
<td><strong>Chróm VI</strong></td>
<td>chróm v moči, prípadne v krvi, pri jasnej nedávnej pracovnej udalosti</td>
<td>najmä recentnú expozíciu</td>
<td>neexistuje spoľahlivý biomarker dávnej nízkej expozície ani test, ktorý by sám dokázal renálnu kauzalitu</td>
</tr>
<tr>
<td><strong>Radón</strong></td>
<td>dlhodobé meranie objemovej aktivity v budove; pri pracovnej expozícii osobná alebo pracovisková dozimetria</td>
<td>expozíciu v priestore, nie „hladinu radónu v obličke“</td>
<td>krvný alebo močový test radónu nemá úlohu v bežnej nefrologickej diagnostike; súvis s CKD nie je preukázaný</td>
</tr>
<tr>
<td><strong>Vonkajšie ionizujúce žiarenie</strong></td>
<td>rádioterapeutický plán, osobný dozimeter, rekonštrukcia orgánovej dávky</td>
<td>absorbovanú dávku do obličiek</td>
<td>všeobecný údaj o „ožiarení“ bez dávky, objemu obličky a frakcionácie nestačí na diagnózu radiačnej nefropatie</td>
</tr>
</tbody>
</table>
</div>
<h3>Ako formulovať záver o príčinnej súvislosti</h3>
<p>Za <strong>silnú klinickú podporu</strong> uránovej alebo kovovej nefrotoxicity možno považovať kompatibilný tubulárny či glomerulový fenotyp, analyticky potvrdenú vnútornú expozíciu, jasný zdroj, vhodný časový vzťah, vyššiu expozíciu než v referenčnej populácii a neprítomnosť pravdepodobnejšej príčiny. <strong>Možná súvislosť</strong> znamená kompatibilný fenotyp a zdroj, ale chýbajúce alebo oneskorené biomonitorovanie. <strong>Nepravdepodobná súvislosť</strong> je vtedy, keď existuje iba geologická lokalita alebo nevalidovaný test bez expozičnej cesty a bez typického obličkového obrazu.</p>
<p>Negatívny močový urán mesiace po jednorazovej expozícii nemusí historickú udalosť vylúčiť. Naopak, merateľný urán v moči môže pochádzať z bežnej potravy a vody a sám nedokazuje poškodenie. Kauzálny záver sa preto nemá opierať o jeden výsledok.</p>
<h3>Kedy konať urgentne</h3>
<p>Urgentná toxikologická a nefrologická koordinácia je potrebná pri oligoanúrii, rýchlom vzostupe kreatinínu, ťažkej acidóze, hyperkaliémii, symptomatickej hypokalémii alebo hypofosfatémii, pľúcnom poškodení po inhalácii kovového dymu, neurologických príznakoch, hemolýze, šoku, masívnom požití alebo kontaminovanej rane. Dialýza sa indikuje podľa klinických komplikácií AKI; nemožno predpokladať, že spoľahlivo odstráni kov uložený v tkanivách. Chelátor alebo alkalinizácia moču sa nemajú začínať empiricky bez identifikácie látky a toxikologickej konzultácie.</p>
<h2>Laboratórne vyšetrenia a biomonitorovanie na Slovensku</h2>
<p>Nasledujúci prehľad vychádza z verejne dostupných katalógov a laboratórnych príručiek slovenských nemocničných a súkromných pracovísk, skontrolovaných k 11. júlu 2026. Dostupnosť sa môže meniť podľa odberového miesta, indikujúcej odbornosti, zmluvy so zdravotnou poisťovňou a preanalytických podmienok. Uvedenie vyšetrenia v katalógu preto nie je zárukou, že ho možno vykonať bez žiadanky alebo v každom odberovom mieste.</p>
<div class="table-responsive" role="region" aria-label="Laboratórne vyšetrenia a biomonitorovanie na Slovensku" tabindex="0">
<table>
<thead>
<tr>
<th scope="col">Vyšetrenie alebo skupina markerov</th>
<th scope="col">Klinický význam</th>
<th scope="col">Reálna dostupnosť na Slovensku</th>
<th scope="col">Praktické obmedzenie</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Kreatinín, eGFR, urea</strong></td>
<td>glomerulová funkcia a závažnosť AKI alebo CKD</td>
<td>rutinne dostupné v nemocničných aj súkromných laboratóriách po celom Slovensku</td>
<td>normálny kreatinín nevylučuje skorú proximálnu tubulopatiu; eGFR nie je validovaná pri rýchlej zmene kreatinínu</td>
</tr>
<tr>
<td><strong>Cystatín C, prípadne eGFR z cystatínu C</strong></td>
<td>doplnenie odhadu GFR pri neistej interpretácii kreatinínu</td>
<td>stanovenie cystatínu C uvádzajú katalógy veľkých sietí Medirex, Unilabs a SYNLAB; automatický výpočet eGFR závisí od pracoviska</td>
<td>koncentráciu cystatínu C ovplyvňujú zápal, funkcia štítnej žľazy, kortikosteroidy a ďalšie faktory; nie je markerom špecifickým pre urán ani proximálny tubulus</td>
</tr>
<tr>
<td><strong>Sodík, draslík, chloridy, fosfát, horčík, vápnik, urát, glukóza a kreatinín v sére a moči</strong></td>
<td>dôkaz renálnych strát a výpočet frakčných exkrécií</td>
<td>široko dostupné; Medirex a Unilabs verejne uvádzajú aj viaceré vypočítané frakčné exkrécie</td>
<td>krv a moč sa majú odobrať časovo čo najbližšie; výsledok menia infúzie, diuretiká, výživa a aktuálna GFR</td>
</tr>
<tr>
<td><strong>Bikarbonát alebo acidobázická rovnováha</strong></td>
<td>proximálna tubulárna acidóza, hyperchloremická metabolická acidóza s normálnym aniónovým rozdielom</td>
<td>rutinne dostupné najmä v nemocničných a väčších biochemických laboratóriách</td>
<td>vzorka na ABR vyžaduje anaeróbny odber a rýchle spracovanie; oneskorenie môže výsledok znehodnotiť</td>
</tr>
<tr>
<td><strong>Moč chemicky, sediment, glukóza v moči, celková bielkovina, kreatinín, ACR a podľa pracoviska pomer proteín/kreatinín (PCR)</strong></td>
<td>glykozúria pri normálnej glykémii, albuminúria, tubulárna alebo zmiešaná proteinúria</td>
<td>rutinná celoštátna dostupnosť; ACR a základný močový profil uvádzajú Medirex aj Unilabs</td>
<td>bežný prúžok reaguje najmä na albumín a môže podhodnotiť nízkomolekulovú tubulárnu proteinúriu</td>
</tr>
<tr>
<td><strong>α1-mikroglobulín v moči</strong></td>
<td>stabilnejší marker nízkomolekulovej tubulárnej proteinúrie</td>
<td>je uvedený vo verejnom katalógu Medirexu; dostupnosť treba potvrdiť pre konkrétne odberové miesto</td>
<td>nie je špecifický pre urán; interpretuje sa vo vzťahu ku kreatinínu v moči a celému klinickému obrazu</td>
</tr>
<tr>
<td><strong>β2-mikroglobulín v moči</strong></td>
<td>citlivý marker poruchy proximálnej reabsorpcie nízkomolekulových bielkovín</td>
<td>aktuálny cenník SYNLAB platný od 1. januára 2026 ho uvádza pre moč; uvádzal ho aj verejný katalóg Unilabs. Vykonanie a podmienky odberu treba vopred overiť</td>
<td>v kyslom moči je nestabilný; laboratórium musí určiť vhodnú nádobu, úpravu pH, teplotu a čas transportu. Sérový β2-mikroglobulín nemožno zamieňať s močovým tubulárnym markerom</td>
</tr>
<tr>
<td><strong>Retinol viažuci proteín a N-acetyl-β-D-glukozaminidáza v moči</strong></td>
<td>doplnkové markery proximálnej tubulopatie</td>
<td>v preskúmaných verejných katalógoch neboli potvrdené ako všeobecne rutinné; možné je individuálne referenčné alebo zahraničné vyšetrenie</td>
<td>pred odberom treba dohodnúť laboratórium, metódu, stabilitu vzorky a referenčné medze</td>
</tr>
<tr>
<td><strong>Aminokyseliny v moči</strong></td>
<td>generalizovaná aminoacidúria pri úplnom Fanconiho syndróme</td>
<td>dostupné skôr ako špecializovaný metabolický profil na vybraných pediatrických, genetických alebo akademických pracoviskách</td>
<td>nejde o bežný skríningový močový test; indikáciu a odber má koordinovať nefrológ alebo lekár pre metabolické choroby</td>
</tr>
<tr>
<td><strong>KIM-1, MCP-1 a močový NGAL</strong></td>
<td>experimentálne alebo kontextovo používané markery tubulárneho poškodenia a zápalu</td>
<td>v preskúmaných verejných katalógoch neboli doložené ako štandardný klinický panel pre uránovú expozíciu; môžu byť dostupné vo výskumnom alebo individuálnom režime</td>
<td>pre uránovú intoxikáciu nemajú validované diagnostické prahy; pozitívny výsledok nie je dôkazom uránovej príčiny</td>
</tr>
<tr>
<td><strong>Urán v moči metódou ICP-MS a izotopový pomer</strong></td>
<td>dôkaz vnútornej expozície a rozlíšenie prírodného, ochudobneného alebo obohateného uránu</td>
<td>vo verejných slovenských klinických katalógoch sa nenašlo rutinne objednateľné vyšetrenie; musí sa vopred koordinovať s klinickým toxikológom, pracovným lekárstvom a pracoviskom radiačnej ochrany, prípadne odoslať do zahraničného referenčného laboratória</td>
<td>laboratórium musí mať validovanú metódu pre <strong>ľudský moč</strong>, nie iba pre vodu alebo pôdu; treba dohodnúť typ zberu, korekciu na kreatinín, medzu stanoviteľnosti, kontrolu kontaminácie a interpretáciu času od expozície</td>
</tr>
</tbody>
</table>
</div>
<p>Analýza uránu v pitnej vode je na Slovensku dostupnejšia prostredníctvom akreditovaných environmentálnych laboratórií, ale výsledok vody nemožno zameniť za biomonitorovanie človeka. Voda dokladá možný zdroj a koncentráciu v čase odberu; moč dokladá vnútornú expozíciu ovplyvnenú príjmom, absorpciou, časom a funkciou obličiek. Pri klinickom podozrení je preto praktické najprv zabezpečiť rutinný nefrologický a proximálny tubulárny profil, uchovať vhodnú vzorku podľa pokynov toxikológa a až potom organizovať špecializované stanovenie uránu.</p>
<h3>Biomonitorovanie uránu</h3>
<p>Urán v moči, ideálne stanovený metódou ICP-MS, je najpraktickejší marker vnútornej expozície. Pri akútnej expozícii má zmysel časovaný alebo 24-hodinový zber po konzultácii s toxikológom. Izotopový pomer môže odlíšiť prírodný, ochudobnený a obohatený urán. Interpretácia musí zohľadniť čas od expozície, koncentráciu moču a funkciu obličiek. Bežné nemocničné laboratóriá vyšetrenie spravidla nevykonávajú.</p>
<p>Meranie uránu vo vlasoch bez validovaného odberu, kontroly externej kontaminácie a toxikologickej interpretácie nie je vhodné na diagnostiku nefrotoxicity. Rovnako nevhodné je robiť záver z nešpecifického komerčného „panelu ťažkých kovov“ bez overenia konkrétnej expozičnej hypotézy.</p>
<h3>Diferenciálna diagnostika</h3>
<p>Diabetes, hypertenzia, monoklonálna gamapatia, liekové tubulopatie, Sjögrenov syndróm, tenofovir, ifosfamid, aminoglykozidy, obštrukcia, sepsa, rabdomyolýza a ďalšie kovy môžu vytvárať podobný obraz. Kauzálny záver si preto vyžaduje časovú väzbu, dôkaz expozície, biologickú vierohodnosť a vylúčenie pravdepodobnejších príčin.</p>
<h2>Liečba a prevencia</h2>
<p>Najdôležitejším opatrením je okamžité prerušenie expozície a dekontaminácia. Pri akútnej významnej udalosti treba kontaktovať klinického toxikológa a pracovisko radiačnej ochrany. Kontaminovaná koža sa šetrne umyje, rana sa odborne vyčistí a zadržané fragmenty sa posudzujú individuálne podľa anatomického rizika ich odstránenia.</p>
<p>Liečba AKI je podporná: optimalizácia cirkulujúceho objemu bez preťaženia tekutinami, korekcia elektrolytov a acidobázickej poruchy, vysadenie ďalších nefrotoxínov a náhrada funkcie obličiek pri štandardných indikáciách. Dialýza rieši urémiu, hyperkaliémiu, acidózu alebo preťaženie, nie je však spoľahlivou metódou odstránenia uránu uloženého v tkanivách.</p>
<p>Staršie odporúčania a materiály pre radiačné nehody uvádzajú skorú hydratáciu a alkalinizáciu moču hydrogénuhličitanom sodným, ktorá má stabilizovať uranylovo-karbonátové komplexy. Klinický dôkaz je prevažne historický a experimentálny; takýto postup patrí do rúk toxikológa, pretože neprimerané podávanie tekutín alebo bikarbonátu môže spôsobiť objemové preťaženie, alkalózu, hypernatriémiu či hypokaliémiu. Rutinná „nútená diuréza“ nie je bezpečná univerzálna rada.</p>
<p>Pre urán neexistuje všeobecne schválené a klinicky overené chelatačné antidotum. Viaceré chelátory znižovali tkanivovú nálož v experimentoch, no Ca-DTPA, EDTA ani iné prípravky sa nemajú empiricky podávať mimo špecializovaného rozhodnutia; niektoré komplexy môžu zhoršiť renálnu alebo kostnú distribúciu kovu.</p>
<h2>Záver</h2>
<p>Urán môže poškodiť obličky, ale mechanizmus a pravdepodobnosť závisia od chemickej formy, rozpustnosti, dávky, cesty vstupu a trvania expozície. Pri prírodnom a ochudobnenom uráne je pri väčšine environmentálnych scenárov rozhodujúca chemická toxicita pre proximálny tubulus. Akútna vysoká dávka môže vyvolať AKI až zlyhanie obličiek. Pri dlhodobej nízkej expozícii sú biologicky vierohodné a v niektorých štúdiách doložené skoré tubulárne zmeny; rozsah, v akom vedú ku klinicky významnej CKD v bežnej populácii, sa ešte len spresňuje.</p>
<p>Rádioaktivita uránu nesmie byť ignorovaná, no klasická radiačná nefropatia vyžaduje podstatne vyššiu dávku do obličiek, než akú prináša bežná kontaminácia vody prírodným uránom. Rádium je primárne kostný rádionuklid a radón predovšetkým pľúcny karcinogén; ani jeden sa dnes nepovažuje za dobre doloženú bežnú príčinu CKD. Pri environmentálnom vyšetrovaní treba myslieť na zmesi kontaminantov a najmä na kadmium, olovo, anorganickú ortuť, arzén a chróm VI.</p>
<p>Praktický postup má stáť na troch pilieroch: potvrdiť a odstrániť zdroj, objektivizovať expozíciu validovanou analýzou a cielene vyšetriť glomerulovú aj proximálnu tubulárnu funkciu. Ani samotný nález uránu v moči, ani izolovaný nešpecifický biomarker nestačí na kauzálnu diagnózu.</p>
<h2>Relevantné zdroje</h2>
<ol>
<li>World Health Organization. <em>Guidelines for drinking-water quality: fourth edition incorporating the first, second and third addenda. Chemical fact sheets: Uranium.</em> 2026. <a href="https://cdn.who.int/media/docs/default-source/wash-documents/water-safety-and-quality/dwq-guidelines-4/gdwq_4ed_with_third-addenda_chemical-fact-sheets.pdf" rel="noopener noreferrer" target="_blank">cdn.who.int</a></li>
<li>World Health Organization. <em>Uranium in Drinking-water: Background document for development of WHO Guidelines for Drinking-water Quality.</em> 2012. <a href="https://cdn.who.int/media/docs/default-source/wash-documents/wash-chemicals/background-uranium-rev-1.pdf" rel="noopener noreferrer" target="_blank">cdn.who.int</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Uranium.</em> 2013. <a href="https://www.atsdr.cdc.gov/toxprofiles/tp150.pdf" rel="noopener noreferrer" target="_blank">atsdr.cdc.gov</a></li>
<li>Guéguen Y, Frerejacques M. Review of Knowledge of Uranium-Induced Kidney Toxicity for the Development of an Adverse Outcome Pathway to Renal Impairment. <em>Int J Mol Sci.</em> 2022;23(8):4397. <a href="https://doi.org/10.3390/ijms23084397" rel="noopener noreferrer" target="_blank">DOI: 10.3390/ijms23084397</a></li>
<li>Horvit AM, Molony DA. A systematic review and meta-analysis of mortality and kidney function in uranium-exposed individuals. <em>Environmental Research.</em> 2024;248:118224. <a href="https://doi.org/10.1016/j.envres.2024.118224" rel="noopener noreferrer" target="_blank">DOI: 10.1016/j.envres.2024.118224</a></li>
<li>Anderson WA, et al. Uranium exposure and kidney tubule biomarkers in the Multi-Ethnic Study of Atherosclerosis (MESA). <em>Environmental Research.</em> 2025. <a href="https://pubmed.ncbi.nlm.nih.gov/39922262/" rel="noopener noreferrer" target="_blank">pubmed.ncbi.nlm.nih.gov</a></li>
<li>Medgyesi DN, et al. Long-Term Exposure to Uranium and Arsenic in Community Drinking Water and CKD Risk Among California Women. <em>American Journal of Kidney Diseases.</em> 2025. <a href="https://doi.org/10.1053/j.ajkd.2025.04.008" rel="noopener noreferrer" target="_blank">DOI: 10.1053/j.ajkd.2025.04.008</a></li>
<li>Kurttio P, et al. Renal effects of uranium in drinking water. <em>Environmental Health Perspectives.</em> 2002;110(4):337-342. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC1240795/" rel="noopener noreferrer" target="_blank">pmc.ncbi.nlm.nih.gov</a></li>
<li>Kurttio P, et al. Kidney toxicity of ingested uranium from drinking water. <em>American Journal of Kidney Diseases.</em> 2006;47(6):972-982. <a href="https://pubmed.ncbi.nlm.nih.gov/16731292/" rel="noopener noreferrer" target="_blank">pubmed.ncbi.nlm.nih.gov</a></li>
<li>Vicente-Vicente L, Quiros Y, Pérez-Barriocanal F, López-Novoa JM, López-Hernández FJ, Morales AI. Nephrotoxicity of Uranium: Pathophysiological, Diagnostic and Therapeutic Perspectives. <em>Toxicological Sciences.</em> 2010;118(2):324-347. <a href="https://doi.org/10.1093/toxsci/kfq178" rel="noopener noreferrer" target="_blank">DOI: 10.1093/toxsci/kfq178</a></li>
<li>McDiarmid MA, et al. Thirty years of surveillance of depleted uranium-exposed Gulf War veterans demonstrate continued effects to bone health. <em>J Toxicol Environ Health A.</em> 2025;88(5):209-225. <a href="https://doi.org/10.1080/15287394.2024.2432021" rel="noopener noreferrer" target="_blank">DOI: 10.1080/15287394.2024.2432021</a></li>
<li>World Health Organization. <em>Depleted uranium: sources, exposure and health effects.</em> 2001. <a href="https://www.who.int/news/item/26-04-2001-who-makes-recommendations-on-depleted-uranium-and-health-in-new-monograph" rel="noopener noreferrer" target="_blank">who.int</a></li>
<li>International Commission on Radiological Protection. <em>ICRP Publication 118: ICRP Statement on Tissue Reactions and Early and Late Effects of Radiation in Normal Tissues and Organs.</em> 2012. <a href="https://www.icrp.org/publication.asp?id=ICRP%20Publication%20118" rel="noopener noreferrer" target="_blank">icrp.org</a></li>
<li>Klaus R, Niyazi M, Lange-Sperandio B. Radiation-induced kidney toxicity: molecular and cellular pathogenesis. <em>Radiation Oncology.</em> 2021;16:43. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7905925/" rel="noopener noreferrer" target="_blank">pmc.ncbi.nlm.nih.gov</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Radium.</em> <a href="https://www.ncbi.nlm.nih.gov/books/NBK595997/" rel="noopener noreferrer" target="_blank">ncbi.nlm.nih.gov</a></li>
<li>Chen B, et al. Exposure to Radon and Kidney Cancer: A Systematic Review and Meta-analysis of Observational Epidemiological Studies. <em>Biomedical and Environmental Sciences.</em> 2018;31(11):805-815. <a href="https://doi.org/10.3967/bes2018.108" rel="noopener noreferrer" target="_blank">DOI: 10.3967/bes2018.108</a></li>
<li>Reddy A, et al. Residential radon exposure and cancer. <em>Oncology Reviews.</em> 2022. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8977862/" rel="noopener noreferrer" target="_blank">pmc.ncbi.nlm.nih.gov</a></li>
<li>Balali-Mood M, Naseri K, Tahergorabi Z, Khazdair MR, Sadeghi M. Toxic Mechanisms of Five Heavy Metals: Mercury, Lead, Chromium, Cadmium, and Arsenic. <em>Front Pharmacol.</em> 2021;12:643972. <a href="https://doi.org/10.3389/fphar.2021.643972" rel="noopener noreferrer" target="_blank">DOI: 10.3389/fphar.2021.643972</a></li>
<li>Moody EC, Coca SG, Sanders AP. Toxic Metals and Chronic Kidney Disease: a Systematic Review of Recent Literature. <em>Curr Environ Health Rep.</em> 2018;5:453-463. <a href="https://doi.org/10.1007/s40572-018-0212-1" rel="noopener noreferrer" target="_blank">DOI: 10.1007/s40572-018-0212-1</a></li>
<li>Kidney Disease: Improving Global Outcomes. Preventing chronic kidney disease and maintaining kidney health: conclusions from a KDIGO Controversies Conference. <em>Kidney International.</em> 2025;108:555-571. <a href="https://kdigo.org/wp-content/uploads/2022/12/KDIGO-2025-Preventing-CKD-and-Maintaining-Kidney-Health-Controversies-Conference-Report_Final.pdf" rel="noopener noreferrer" target="_blank">kdigo.org</a></li>
<li>Ministerstvo zdravotníctva Slovenskej republiky. Vyhláška č. 91/2023 Z. z., ktorou sa ustanovujú ukazovatele a limitné hodnoty kvality pitnej vody a kvality teplej vody. <a href="https://www.slov-lex.sk/pravne-predpisy/SK/ZZ/2023/91/" rel="noopener noreferrer" target="_blank">slov-lex.sk</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Uranium Toxicity: Clinical Assessment and Treatment.</em> <a href="https://archive.cdc.gov/www_atsdr_cdc_gov/csem/uranium/clinical_assessment.html" rel="noopener noreferrer" target="_blank">archive.cdc.gov</a> a <a href="https://archive.cdc.gov/www_atsdr_cdc_gov/csem/uranium/treatment.html" rel="noopener noreferrer" target="_blank">archive.cdc.gov</a></li>
<li>Dahlkamp FJ. Slovak Republic. In: <em>Uranium Deposits of the World: Europe.</em> Springer; 2016:551-567. <a href="https://link.springer.com/rwe/10.1007/978-3-540-78554-5_14" rel="noopener noreferrer" target="_blank">link.springer.com</a></li>
<li>Kohút M, Trubač J, Novotný L, et al. Geology and Re-Os molybdenite geochronology of the Kurišková U-Mo deposit (Western Carpathians, Slovakia). <em>Journal of Geosciences.</em> 2013;58:271-282. <a href="https://doi.org/10.3190/jgeosci.150" rel="noopener noreferrer" target="_blank">DOI: 10.3190/jgeosci.150</a></li>
<li>Michaeli E, Solár V, Ivanová M, Fazekašová D. Current status the bearings of uranium ores in the Slovak Republic. <em>Journal of International Scientific Publications: Ecology and Safety.</em> 2014;8:304-310. <a href="https://www.scientific-publications.net/en/article/1000102/1000001-1401631260721469.pdf" rel="noopener noreferrer" target="_blank">scientific-publications.net</a></li>
<li>Štátny geologický ústav Dionýza Štúra. <em>Prírodná rádioaktivita: radónové riziko a rádiometria Slovenskej republiky.</em> <a href="https://apl.geology.sk/radio/" rel="noopener noreferrer" target="_blank">apl.geology.sk</a> a <a href="https://apl.geology.sk/mapportal/img/pdf/gf500/Radiometria%20-%20Prirodna%20radioaktivita%20-%20Podny%20vzduch.pdf" rel="noopener noreferrer" target="_blank">apl.geology.sk</a></li>
<li>DIAMO, státní podnik. <em>Těžba uranu</em> a <em>Spravované lokality.</em> <a href="https://www.diamo.cz/cs/tezba" rel="noopener noreferrer" target="_blank">diamo.cz</a> a <a href="https://www.diamo.cz/cs/spravovane-lokality" rel="noopener noreferrer" target="_blank">diamo.cz</a></li>
<li>Státní ústav radiační ochrany. <em>Radioactivity in water and possible remedial measures.</em> <a href="https://www.suro.cz/en/prirodnioz/radioactivity-in-water-and-possible-remedial-measures" rel="noopener noreferrer" target="_blank">suro.cz</a></li>
<li>Vyhláška Ministerstva zdravotnictví ČR č. 252/2004 Sb. v účinném znění, příloha č. 1, ukazatel uran 15 µg/l. <a href="https://www.zakonyprolidi.cz/cs/2004-252" rel="noopener noreferrer" target="_blank">zakonyprolidi.cz</a></li>
<li>Radonový program České republiky. <em>Radon v ČR</em> a interaktívna mapa radónového indexu Českej geologickej služby. <a href="https://www.radonovyprogram.cz/radon-v-cr" rel="noopener noreferrer" target="_blank">radonovyprogram.cz</a> a <a href="https://mapy.geology.cz/radon/" rel="noopener noreferrer" target="_blank">mapy.geology.cz</a></li>
<li>Matolín M. Verification of the radiometric map of the Czech Republic. <em>Journal of Environmental Radioactivity.</em> 2017;166:289-295. <a href="https://doi.org/10.1016/j.jenvrad.2016.04.013" rel="noopener noreferrer" target="_blank">DOI: 10.1016/j.jenvrad.2016.04.013</a></li>
<li>European Commission, Joint Research Centre. <em>European Atlas of Natural Radiation: Terrestrial gamma dose rate.</em> <a href="https://data.jrc.ec.europa.eu/dataset/jrc-eanr-07_terrestrial-gamma-dose" rel="noopener noreferrer" target="_blank">data.jrc.ec.europa.eu</a></li>
<li>Medirex, a. s. <em>Cenník laboratórnych vyšetrení</em>, verejný katalóg klinickej biochémie: cystatín C, sérové a močové elektrolyty, frakčné exkrécie, ACR a α1-mikroglobulín v moči. <a href="https://static.medirex.sk/storage/app/media/Kontent%20pre%20lekarsku%20cast/Pre%20lekarov/Cennik/MXG_08487_cennik_LEKAR_OKT_v3.pdf" rel="noopener noreferrer" target="_blank">static.medirex.sk</a></li>
<li>Unilabs Slovensko. <em>Výsledky do 24 hodín</em> a verejný katalóg vyšetrení: základný močový profil, ACR, sérové a močové elektrolyty, frakčné exkrécie, cystatín C a β2-mikroglobulín. <a href="https://www.unilabs.sk/vysledky-do-24-hodin" rel="noopener noreferrer" target="_blank">unilabs.sk</a> a <a href="https://www.unilabs.sk/media/2021/12/1/2/2019-04-cennik-a5-0.pdf" rel="noopener noreferrer" target="_blank">unilabs.sk</a></li>
<li>SYNLAB Slovakia. <em>Cenník laboratórnych vyšetrení, biochémia</em>, platný od 1. januára 2026. <a href="https://www.synlab.sk/fileadmin/user_upload/Cennik_BIO_1.1.2026.pdf" rel="noopener noreferrer" target="_blank">synlab.sk</a></li>
<li>Univerzitná nemocnica Martin. <em>Ústav klinickej biochémie: diagnostika.</em> <a href="https://www.unm.sk/kliniky-oddelenia/ustav-klinickej-biochemie/diagnostika" rel="noopener noreferrer" target="_blank">unm.sk</a></li>
<li>Matarneh AS, Matarneh B, Rout P, et al. Fanconi Syndrome. <em>StatPearls.</em> Aktualizované 2025. <a href="https://www.ncbi.nlm.nih.gov/books/NBK534872/" rel="noopener noreferrer" target="_blank">ncbi.nlm.nih.gov</a></li>
<li>Merck Manual Professional Edition. <em>Fanconi Syndrome.</em> Revidované 2024. <a href="https://www.merckmanuals.com/professional/nephrology/renal-transport-abnormalities/fanconi-syndrome" rel="noopener noreferrer" target="_blank">merckmanuals.com</a></li>
<li>European Commission, Joint Research Centre. <em>Digital Atlas of Natural Radiation</em>: indoor radon, uranium, thorium and potassium in soil and bedrock, terrestrial gamma dose and geogenic radon. <a href="https://remon.jrc.ec.europa.eu/About/Atlas-of-Natural-Radiation/Digital-Atlas" rel="noopener noreferrer" target="_blank">remon.jrc.ec.europa.eu</a></li>
<li>International Atomic Energy Agency. <em>World Distribution of Uranium Deposits (UDEPO) with Uranium Deposit Classification.</em> IAEA-TECDOC-1629. <a href="https://www-pub.iaea.org/MTCD/Publications/PDF/TE_1629_web.pdf" rel="noopener noreferrer" target="_blank">www-pub.iaea.org</a></li>
<li>Rada Európskej únie. Smernica Rady 2013/59/Euratom, základné bezpečnostné normy ochrany pred ionizujúcim žiarením, najmä články 54, 74 a 103. <a href="https://eur-lex.europa.eu/eli/dir/2013/59/oj" rel="noopener noreferrer" target="_blank">eur-lex.europa.eu</a></li>
<li>Rada Európskej únie. Smernica Rady 2013/51/Euratom o ochrane zdravia obyvateľstva pred rádioaktívnymi látkami vo vode určenej na ľudskú spotrebu. <a href="https://eur-lex.europa.eu/eli/dir/2013/51/oj" rel="noopener noreferrer" target="_blank">eur-lex.europa.eu</a></li>
<li>Wismut GmbH. <em>Mining remediation: taking responsibility, shaping the future.</em> 2023. <a href="https://www.wismut.de/fileadmin/user_upload/PDF/BMWK/wismut-mining-remediation_2023_engl.pdf" rel="noopener noreferrer" target="_blank">wismut.de</a></li>
<li>Orano Mining. <em>Annual Activity Report 2024</em> a informácie o sanácii a monitorovaní bývalých uránových lokalít vo Francúzsku. <a href="https://www.orano.group/finance-raa2024/en/183/" rel="noopener noreferrer" target="_blank">orano.group</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Lead.</em> <a href="https://www.atsdr.cdc.gov/toxprofiles/tp13.pdf" rel="noopener noreferrer" target="_blank">atsdr.cdc.gov</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Cadmium.</em> <a href="https://www.atsdr.cdc.gov/toxprofiles/tp5.pdf" rel="noopener noreferrer" target="_blank">atsdr.cdc.gov</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Mercury.</em> <a href="https://www.atsdr.cdc.gov/toxprofiles/tp46.pdf" rel="noopener noreferrer" target="_blank">atsdr.cdc.gov</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Arsenic.</em> <a href="https://www.atsdr.cdc.gov/toxprofiles/tp2.pdf" rel="noopener noreferrer" target="_blank">atsdr.cdc.gov</a></li>
<li>Agency for Toxic Substances and Disease Registry. <em>Toxicological Profile for Chromium.</em> <a href="https://www.atsdr.cdc.gov/toxprofiles/tp7.pdf" rel="noopener noreferrer" target="_blank">atsdr.cdc.gov</a></li>
</ol>
<hr/>
<p><em>Odborná poznámka: Text je syntézou toxikologických, epidemiologických a nefrologických údajov dostupných k 11. júlu 2026. Nie je náhradou individuálneho toxikologického, nefrologického ani radiačno-hygienického posúdenia konkrétnej expozície.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
