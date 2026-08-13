<?php
/**
 * Odborne a jazykovo revidovaný článok o MASLD.
 *
 * Text je syntézou inštitucionálnych odporúčaní a regulačných dokumentov.
 * Nejde o spracovanie jednej publikácie s osobným autorstvom, preto sa autori
 * citovaných prác nepridávajú do source_authors.php.
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
    'title'        => 'Metabolicky asociovaná steatotická choroba pečene: diagnostika, hodnotenie fibrózy a význam pre nefrologickú prax',
    'slug'         => 'masld-diagnostika-fibroza-nefrologicka-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'MASLD je systémové metabolické ochorenie. Praktický prehľad ukazuje, koho cielene vyšetrovať, ako hodnotiť fibrózu a čo sa mení pri súčasnej CKD.',
    'content'      => <<<'HTML'
<p>Metabolicky asociovaná steatotická choroba pečene (MASLD) patrí medzi najčastejšie chronické choroby pečene. Je úzko prepojená s abdominálnou obezitou, diabetom 2. typu, dyslipidémiou, artériovou hypertenziou, kardiovaskulárnymi ochoreniami a chronickou chorobou obličiek (CKD).</p>

<p>Klinické riziko neurčuje iba množstvo tuku v pečeni. Najdôležitejším prognostickým ukazovateľom pečeňových komplikácií je štádium fibrózy, zatiaľ čo celkovú prognózu často ovplyvňujú kardiovaskulárne príhody, malignity a ochorenie obličiek. Súčasný prístup sa preto nesústreďuje na plošné vyhľadávanie steatózy, ale na cielené rozpoznanie pacientov s pokročilou fibrózou.</p>

<h2>Od NAFLD a NASH k MASLD a MASH</h2>

<p>Nová nomenklatúra z roku 2023 zaviedla zastrešujúci pojem <em>steatotická choroba pečene</em> (SLD). MASLD označuje SLD pri prítomnosti najmenej jedného kardiometabolického rizikového faktora a bez konzumácie alkoholu v rozsahu zodpovedajúcom inej kategórii SLD. Metabolicky asociovaná steatohepatitída (MASH) je progresívny zápalový fenotyp so steatózou, balónovým poškodením hepatocytov a lobulárnym zápalom, s fibrózou alebo bez nej.</p>

<p>Nejde iba o kozmetické premenovanie starších pojmov NAFLD a NASH. MASLD používa pozitívne metabolické kritériá a nová klasifikácia osobitne rozlišuje napríklad kombináciu metabolickej dysfunkcie so zvýšenou konzumáciou alkoholu (MetALD). Výsledky starších štúdií zostávajú dôležité, ale ich populácie sa nemusia úplne prekrývať s dnešnou definíciou MASLD.</p>

<h2>Steatóza nie je automaticky MASLD</h2>

<p>Pri náleze tuku v pečeni treba zhodnotiť množstvo a vzorec konzumácie alkoholu, lieky a alternatívne alebo súčasne prítomné choroby pečene. Podľa klinického kontextu diferenciálna diagnostika zahŕňa najmä:</p>

<ul>
  <li>alkoholovú chorobu pečene a MetALD,</li>
  <li>vírusové hepatitídy,</li>
  <li>liekové poškodenie pečene,</li>
  <li>Wilsonovu chorobu a iné monogénne metabolické ochorenia,</li>
  <li>celiakiu, hypotyreózu a lipodystrofie,</li>
  <li>podvýživu, rýchly úbytok hmotnosti a parenterálnu výživu.</li>
</ul>

<p>So steatózou alebo steatohepatitídou sa môžu spájať napríklad amiodarón, tamoxifén, metotrexát, valproát a niektoré režimy systémových kortikosteroidov. Kauzalitu treba hodnotiť podľa dávky, dĺžky expozície, časovej súvislosti a metabolického rizika.</p>

<p>Alkohol a metabolické faktory sa nevylučujú a môžu pôsobiť synergicky. Európske odporúčania od konzumácie alkoholu odrádzajú všetkých pacientov so SLD; pri pokročilej fibróze alebo cirhóze odporúčajú úplnú a trvalú abstinenciu.</p>

<h2>Koho cielene vyšetrovať</h2>

<p>Európske odporúčania EASL–EASD–EASO neodporúčajú populačný skríning. Viacstupňové hodnotenie rizika pokročilej fibrózy má byť zamerané najmä na dospelých s:</p>

<ul>
  <li>diabetom 2. typu,</li>
  <li>abdominálnou obezitou a najmenej jedným ďalším kardiometabolickým rizikovým faktorom,</li>
  <li>pretrvávajúco zvýšenými pečeňovými enzýmami,</li>
  <li>náhodne zistenou steatózou pečene, ak majú relevantný rizikový profil.</li>
</ul>

<p>Samotný index telesnej hmotnosti nevystihuje riziko. MASLD sa vyskytuje aj u ľudí s normálnou hmotnosťou, najmä pri viscerálnej adipóznosti, sarkopénii, inzulínovej rezistencii alebo genetickej predispozícii. CKD sama osebe nie je samostatným vstupným kritériom algoritmu EASL, ale v kombinácii s diabetom, obezitou alebo ďalšími metabolickými faktormi zvyšuje klinickú naliehavosť hodnotenia.</p>

<h2>Normálne aminotransferázy nevylučujú pokročilú fibrózu</h2>

<p>Pacient s významnou MASH, pokročilou fibrózou alebo cirhózou môže mať normálne alebo iba mierne zvýšené hodnoty ALT a AST. Aminotransferázy preto nemožno používať ako jediný skríningový test, na vylúčenie závažnej choroby ani ako spoľahlivý ukazovateľ histologickej odpovede.</p>

<p>Vstupné vyšetrenie má podľa situácie zahŕňať krvný obraz s trombocytmi, AST, ALT, GGT, alkalickú fosfatázu, bilirubín, albumín, parametre syntetickej funkcie pečene, glykémiu alebo HbA1c, lipidový profil, kreatinín s eGFR a albuminúriu. Cielené vyšetrenia vírusových, autoimunitných, metabolických a liekových príčin sa volia podľa anamnézy a klinického obrazu.</p>

<h2>Ultrasonografia nepotvrdzuje ani nevylučuje fibrózu</h2>

<p>Konvenčná ultrasonografia dokáže zachytiť najmä stredne výraznú až výraznú steatózu. Jej citlivosť klesá pri miernej steatóze a u niektorých pacientov s obezitou, takže negatívny výsledok MASLD nevylučuje. Zároveň nedokáže spoľahlivo určiť prítomnosť MASH ani štádium fibrózy.</p>

<p>Kontrolovaný parameter útlmu pri prechodnej elastografii môže odhadnúť steatózu. Pre prognózu je však podstatnejšie meranie tuhosti pečene a jeho interpretácia v sekvenčnom algoritme.</p>

<h2>Viacstupňové hodnotenie fibrózy</h2>

<h3>Prvý krok: FIB-4</h3>

<p>FIB-4 je dostupné skóre vypočítané z veku, AST, ALT a počtu trombocytov:</p>

<p class="pdf-avoid-break"><strong>FIB-4 = vek &times; AST / (počet trombocytov &times; &radic;ALT)</strong></p>

<p>Vek sa zadáva v rokoch, AST a ALT v U/l a počet trombocytov v 10<sup>9</sup>/l. U dospelých vo veku do 65 rokov vrátane sa prakticky používa:</p>

<ul>
  <li><strong>FIB-4 &lt; 1,3:</strong> nízke riziko pokročilej fibrózy; pri pretrvávajúcom riziku sa skóre opakuje,</li>
  <li><strong>FIB-4 1,3 až 2,67:</strong> nejednoznačný výsledok, ktorý vyžaduje druhý krok,</li>
  <li><strong>FIB-4 &gt; 2,67:</strong> vysoké riziko a dôvod na hepatologické posúdenie.</li>
</ul>

<p>U osôb starších ako 65 rokov sa ako spodná hranica zvýšeného rizika používa 2,0, pretože vek zvyšuje počet falošne pozitívnych výsledkov. U ľudí mladších ako 35 rokov má FIB-4 nízku presnosť. Skóre sa nemá interpretovať počas akútneho ochorenia alebo pri výraznom prechodnom vzostupe aminotransferáz a jeho výsledok môžu skresliť hematologické ochorenia či trombocytopénia iného pôvodu.</p>

<p>Nízky FIB-4 je vhodnejší na vylúčenie pokročilej fibrózy než vysoký FIB-4 na jej potvrdenie. Ani nízky výsledok nie je absolútnou zárukou; algoritmus EASL upozorňuje, že môže prehliadnuť približne desatinu pacientov s pokročilou fibrózou.</p>

<h3>Druhý krok: elastografia alebo ELF</h3>

<p>Pri FIB-4 od 1,3 do 2,67 možno podľa klinického rizika a dostupnosti zvoliť jednu z dvoch ciest:</p>

<ol>
  <li>vykonať prechodnú elastografiu bez odkladu, najmä pri hodnote blízkej 2,67 alebo pri vysokom klinickom riziku, alebo</li>
  <li>zintenzívniť liečbu metabolických faktorov a zopakovať FIB-4 najneskôr o rok; pri pretrvávajúcej hodnote najmenej 1,3 doplniť elastografiu.</li>
</ol>

<p>Pri prechodnej elastografii hodnota tuhosti pečene pod 8 kPa podporuje nízke riziko pokročilej fibrózy. Hodnota najmenej 8 kPa nie je sama osebe histologickou diagnózou, ale vyžaduje ďalšie zhodnotenie. Meranie môžu zvýšiť akútny zápal, cholestáza, venózna kongescia a nedávne jedlo; technickú úspešnosť znižuje výrazná obezita.</p>

<p>Test ELF, ktorý kombinuje tri markery metabolizmu extracelulárnej matrix, môže byť alternatívou alebo doplnkom elastografie. Prahy sa nesmú nekriticky prenášať medzi rôznymi algoritmami. Hodnota 10,51 pochádza zo staršieho špecifického postupu NICE a nie je univerzálnym prahom pre každý klinický kontext.</p>

<h3>Kedy je potrebná biopsia</h3>

<p>Biopsia pečene nie je potrebná u väčšiny pacientov. Zvažuje sa pri rozporných neinvazívnych výsledkoch, podozrení na inú alebo kombinovanú chorobu pečene, potrebe definitívne potvrdiť MASH alebo ak histológia môže zmeniť terapeutické rozhodnutie. Umožňuje hodnotiť balónové poškodenie, lobulárny zápal a štádium fibrózy, je však invazívna a zaťažená vzorkovacou chybou.</p>

<h2>NICE: starší algoritmus zatiaľ nebol nahradený</h2>

<p>K 13. augustu 2026 zostáva na stránke NICE platné odporúčanie NG49 pod názvom NAFLD, publikované 6. júla 2016 a naposledy preskúmané 24. októbra 2024. NICE pripravuje čiastočnú aktualizáciu pre MASLD, jej oficiálna stránka však uvádza očakávané publikovanie 27. júla 2027.</p>

<p>Starší postup NICE kladie dôraz na ELF a prah 10,51. Údaj na sekundárnej stránke Medscape o aktualizácii NICE z 31. júla 2026 nemožno považovať za vydanie nového odporúčania, pretože mu nezodpovedá verejný stav oficiálneho dokumentu. V tomto článku má pri súčasnom viacstupňovom hodnotení prednosť európske odporúčanie EASL–EASD–EASO z roku 2024.</p>

<h2>Liečba začína znížením metabolického rizika</h2>

<h3>Redukcia hmotnosti</h3>

<p>U pacientov s nadváhou alebo obezitou má byť cieľom udržateľný pokles hmotnosti. Európske odporúčania uvádzajú orientačné ciele:</p>

<ul>
  <li>najmenej 5 % na zníženie množstva tuku v pečeni,</li>
  <li>7 až 10 % na zlepšenie zápalovej aktivity,</li>
  <li>najmenej 10 % na najväčšiu pravdepodobnosť zlepšenia fibrózy.</li>
</ul>

<p>Nejde o zaručené prahy účinku pre jednotlivca. Pri CKD, cirhóze, vyššom veku alebo sarkopénii treba chrániť svalovú hmotu, individualizovať príjem bielkovín a vyhnúť sa nekontrolovanej rýchlej redukcii.</p>

<h3>Stravovanie a pohyb</h3>

<p>Vhodný je dlhodobo udržateľný model podobný stredomorskej strave s vyšším zastúpením zeleniny, strukovín, celozrnných potravín, orechov, rýb a nenasýtených tukov. Obmedziť treba sladené nápoje, ultraspracované potraviny, nadbytok nasýtených tukov a energeticky koncentrovanú stravu.</p>

<p>Pohybová aktivita má byť prispôsobená možnostiam pacienta, prednostne viac ako 150 minút stredne intenzívnej alebo 75 minút intenzívnej aktivity týždenne, doplnenej odporovým cvičením. Znižuje steatózu aj bez výrazného poklesu hmotnosti; dôkazy o priamej regresii pokročilej fibrózy sú slabšie než dôkazy o kardiometabolickom prínose.</p>

<h2>Farmakologická liečba v roku 2026</h2>

<p>Liečba diabetu, obezity, dyslipidémie, hypertenzie, srdcového zlyhávania a CKD zostáva základom. Účinok na hmotnosť, aminotransferázy alebo pečeňový tuk sa však nesmie automaticky vydávať za dokázaný antifibrotický alebo prognostický účinok.</p>

<h3>Dve liečby MASH s podmienečným povolením v EÚ</h3>

<p>K 13. augustu 2026 majú v Európskej únii podmienené povolenie na uvedenie na trh dva lieky určené spolu s diétou a pohybovou aktivitou pre dospelých s necirhotickou MASH a fibrózou F2 až F3:</p>

<ul>
  <li><strong>Rezdiffra (resmetirom)</strong>, s povolením vydaným 18. augusta 2025,</li>
  <li><strong>Kayshild (semaglutid)</strong>, s povolením vydaným 26. marca 2026.</li>
</ul>

<p>Obe povolenia vychádzajú z histologických náhradných ukazovateľov: vymiznutia MASH bez zhoršenia fibrózy a zlepšenia fibrózy bez zhoršenia MASH. Zatiaľ nepreukazujú, že liečba znižuje dekompenzáciu cirhózy, potrebu transplantácie alebo mortalitu; dlhodobé výsledky sa naďalej zbierajú. Centralizované povolenie na uvedenie na trh zároveň neznamená automatickú úhradu ani bežnú dostupnosť v každom slovenskom pracovisku.</p>

<p>Indikácia Kayshildu sa nesmie automaticky prenášať na všetky prípravky so semaglutidom ani na všetky inkretínové lieky. Ostatné agonisty receptora GLP-1 a duálne inkretínové lieky sa majú používať podľa vlastnej schválenej indikácie pre diabetes alebo obezitu.</p>

<h3>Čo je dôležité pre nefrológa</h3>

<ul>
  <li>Pri resmetirome európska informácia o lieku nevyžaduje úpravu dávky pri eGFR 15 až 89 ml/min, treba však skontrolovať interakcie s inhibítormi CYP2C8 a limitovanie dávok niektorých statínov.</li>
  <li>Pri Kayshilde sa dávka pri miernom ani stredne závažnom poškodení funkcie obličiek neupravuje, liek sa však pre obmedzené skúsenosti neodporúča pri eGFR &lt; 30 ml/min/1,73 m<sup>2</sup> ani pri zlyhaní obličiek.</li>
  <li>Nauzea, vracanie a hnačka pri semaglutide môžu viesť k dehydratácii a zhoršeniu funkcie obličiek; rizikový pacient potrebuje poučenie a plán kontroly.</li>
  <li>Pri dialýze alebo nestabilnej funkcii obličiek sa výber cielenej liečby musí opierať o aktuálny súhrn charakteristických vlastností lieku a multidisciplinárne rozhodnutie.</li>
</ul>

<h3>Ďalšie metabolické lieky</h3>

<p>Inhibítory SGLT2 nie sú cielenou liečbou MASH, ale pri diabete 2. typu, srdcovom zlyhávaní alebo CKD znižujú kardiorenálne riziko a majú sa používať podľa týchto indikácií. Pioglitazón môže zlepšiť steatohepatitídu, jeho použitie však obmedzuje prírastok hmotnosti, retencia tekutín, riziko srdcového zlyhávania a zlomenín. EASL ho pre nedostatok robustných údajov z veľkých štúdií fázy III neodporúča ako cielenú liečbu MASH.</p>

<p>Vitamín E môže u vybraných pacientov bez diabetu a bez cirhózy zlepšiť histologickú aktivitu, nepreukázal však spoľahlivý antifibrotický ani klinický prognostický účinok. Európske odporúčania ho nepovažujú za štandardnú cielenú liečbu MASH.</p>

<h2>Statíny sa pre samotnú MASLD nevysadzujú</h2>

<p>Statíny sú pri MASLD vo všeobecnosti bezpečné vrátane kompenzovanej cirhózy a majú sa používať podľa kardiovaskulárnej indikácie. Mierne stabilné zvýšenie aminotransferáz bez známok akútneho poškodenia pečene nie je automatickým dôvodom na ich vysadenie. Statíny však nie sú liečbou MASH ani fibrózy.</p>

<p>Výnimkou nie je samotná MASLD, ale konkrétna lieková interakcia. Pri súbežnom resmetirome treba skontrolovať aktuálne dávkové limity pre simvastatín, rosuvastatín, pravastatín a atorvastatín podľa súhrnu charakteristických vlastností lieku.</p>

<h2>MASLD a chronická choroba obličiek</h2>

<p>MASLD a CKD zdieľajú obezitu, inzulínovú rezistenciu, hypertenziu, dyslipidémiu, endotelovú dysfunkciu a chronický zápal nízkej intenzity. Metaanalýzy a veľké kohorty spájajú MASLD s vyšším rizikom novovzniknutej CKD; riziko sa zvyšuje so závažnosťou steatózy a fibrózy. Observačná asociácia však sama osebe nedokazuje jednoduchý kauzálny vzťah, pretože významnú časť rizika tvoria spoločné determinanty a reziduálne skreslenie.</p>

<p>Nefrologické hodnotenie pacienta s MASLD má zahŕňať:</p>

<ul>
  <li>kreatinín, eGFR a albuminúriu,</li>
  <li>krvný tlak, glykemický stav a lipidový profil,</li>
  <li>telesnú hmotnosť, obvod pása a známky sarkopénie,</li>
  <li>kardiovaskulárne riziko a srdcové zlyhávanie,</li>
  <li>liekové interakcie a bezpečnosť vzhľadom na funkciu obličiek.</li>
</ul>

<h3>Limity FIB-4 a elastografie pri CKD</h3>

<p>FIB-4 neobsahuje kreatinín ani eGFR, CKD však môže nepriamo ovplyvniť všetky jeho laboratórne zložky. Trombocytopénia môže súvisieť s liekmi, infekciou, hematologickou chorobou alebo dialyzačnou liečbou. U hemodialyzovaných pacientov bývajú AST a ALT nižšie než u ľudí s normálnou funkciou obličiek, čo môže skóre skresliť.</p>

<p>Tradičné prahy FIB-4 nie sú dostatočne validované ako samostatný diagnostický nástroj pre pacientov na dialýze. Ani elastografiu nemožno interpretovať mechanicky: venózna kongescia, objemové preťaženie a čas merania vo vzťahu k ultrafiltrácii môžu meniť tuhosť pečene. Pri významnom metabolickom riziku alebo nejednoznačnom výsledku je vhodná štandardizovaná elastografia a hepatologické posúdenie.</p>

<h2>Monitorovanie a odoslanie k hepatológovi</h2>

<p>Pri FIB-4 pod 1,3 odporúča EASL opakovanie približne každé 1 až 3 roky podľa rizika. AASLD spresňuje interval na 1 až 2 roky pri prediabete, diabete 2. typu alebo najmenej dvoch metabolických rizikových faktoroch a na 2 až 3 roky pri nižšom riziku. Kontrola má byť skoršia pri zmene klinického stavu alebo laboratórnych výsledkov.</p>

<p>Hepatologické vyšetrenie je vhodné najmä pri FIB-4 nad 2,67, zvýšenej tuhosti pečene, rozporných neinvazívnych testoch, známkach portálnej hypertenzie, poruche syntetickej funkcie pečene alebo podozrení na inú chorobu pečene.</p>

<p>Pri cirhóze sa odporúča pravidelné sledovanie na včasný záchyt hepatocelulárneho karcinómu a komplikácií portálnej hypertenzie. Pri necirhotickej fibróze F3 možno sledovanie HCC zvážiť individuálne; pri fibróze F0 až F2 sa rutinne neodporúča.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<ol>
  <li><strong>Identifikovať riziko:</strong> diabetes 2. typu, abdominálna obezita, ďalšie metabolické faktory, zvýšené pečeňové enzýmy alebo náhodná steatóza.</li>
  <li><strong>Vylúčiť zjavné alternatívy:</strong> alkohol, lieky, vírusové a ďalšie choroby podľa kontextu.</li>
  <li><strong>Vypočítať FIB-4:</strong> nie počas akútneho ochorenia a s ohľadom na vek, trombocyty a špecifiká CKD.</li>
  <li><strong>Doplniť druhý test:</strong> pri nejednoznačnom alebo vysokom riziku elastografia alebo ELF, prípadne odoslanie k hepatológovi.</li>
  <li><strong>Liečiť spoločné riziká:</strong> obezitu, diabetes, krvný tlak, dyslipidémiu, srdcové zlyhávanie, CKD, fajčenie a konzumáciu alkoholu.</li>
  <li><strong>Pred cielenou liečbou MASH:</strong> potvrdiť vhodné štádium, skontrolovať aktuálnu indikáciu, eGFR, interakcie, dostupnosť a úhradu.</li>
</ol>

<h2>Záver</h2>

<p>MASLD je systémové metabolické ochorenie s pečeňovými, kardiovaskulárnymi a renálnymi dôsledkami. Normálne aminotransferázy ani negatívna konvenčná ultrasonografia nevylučujú pokročilú fibrózu. Najpraktickejší súčasný postup tvorí cielené vyhľadávanie rizikových pacientov, FIB-4 a následná elastografia alebo test ELF.</p>

<p>V roku 2026 už majú v EÚ dve liečby necirhotickej MASH s fibrózou F2 až F3 podmienečné povolenie na uvedenie na trh: resmetirom a semaglutid Kayshild. Ich použitie však vyžaduje presnú stratifikáciu fibrózy, rešpektovanie súhrnu charakteristických vlastností lieku a vedomie, že dlhodobý vplyv na dekompenzáciu, transplantáciu a prežívanie zatiaľ nie je potvrdený.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=oblicka-v-centre-ckm-syndromu-kdigo">Oblička v centre kardiovaskulárno-obličkovo-metabolického syndrómu</a></li>
  <li><a href="article.php?slug=tukove-tkanivo-obezita-kardiorenalne-riziko-biologia">Tukové tkanivo, obezita a kardiorenálne riziko</a></li>
  <li><a href="article.php?slug=dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax">Dyslipidémia pri chronickej chorobe obličiek</a></li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>European Association for the Study of the Liver, European Association for the Study of Diabetes, European Association for the Study of Obesity.</strong> <em>EASL–EASD–EASO Clinical Practice Guidelines on the management of metabolic dysfunction-associated steatotic liver disease (MASLD).</em> Journal of Hepatology. 2024;81(3):492–542. doi: 10.1016/j.jhep.2024.04.031. <a href="https://doi.org/10.1016/j.jhep.2024.04.031" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38851997/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://easlcampus.eu/sites/default/files/2024-06/EASL_CPGs_on_MASLD.pdf" target="_blank" rel="noopener noreferrer">Plné odporúčanie EASL</a>.</li>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Non-alcoholic fatty liver disease: assessment and management.</em> NICE Guideline NG49. Publikované 6. júla 2016, naposledy preskúmané 24. októbra 2024. <a href="https://www.nice.org.uk/guidance/ng49" target="_blank" rel="noopener noreferrer">NG49</a>. <a href="https://www.nice.org.uk/guidance/indevelopment/gid-ng10434" target="_blank" rel="noopener noreferrer">Pripravovaná aktualizácia MASLD</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Rezdiffra (resmetirom): European public assessment report and product information.</em> Podmienené povolenie na uvedenie na trh v EÚ od 18. augusta 2025. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/rezdiffra" target="_blank" rel="noopener noreferrer">EMA EPAR</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/rezdiffra-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Informácia o lieku</a>. <a href="https://www.sukl.sk/hlavna-stranka/slovenska-verzia/pomocne-stranky/detail-lieku?lie_id=1292F&amp;page_id=386" target="_blank" rel="noopener noreferrer">ŠÚKL</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Kayshild (semaglutide): European public assessment report and product information.</em> Podmienené povolenie na uvedenie na trh v EÚ od 26. marca 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kayshild" target="_blank" rel="noopener noreferrer">EMA EPAR</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/kayshild-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Informácia o lieku</a>. <a href="https://www.sukl.sk/kayshild-24-mg-injekcny-roztok-v-naplnenom-pere-3408f" target="_blank" rel="noopener noreferrer">ŠÚKL</a>.</li>
  <li><strong>Mary E. Rinella, Brent A. Neuschwander-Tetri, Mohammad S. Siddiqui, Manal F. Abdelmalek, Stephen Caldwell, Diana Barb, David E. Kleiner, Rohit Loomba.</strong> <em>AASLD Practice Guidance on the clinical assessment and management of nonalcoholic fatty liver disease.</em> Hepatology. 2023;77(5):1797–1835. doi: 10.1097/HEP.0000000000000323. <a href="https://doi.org/10.1097/HEP.0000000000000323" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36727674/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Mary E. Rinella et al.; NAFLD Nomenclature Consensus Group.</strong> <em>A multisociety Delphi consensus statement on new fatty liver disease nomenclature.</em> Hepatology. 2023;78(6):1966–1986. doi: 10.1097/HEP.0000000000000520. <a href="https://doi.org/10.1097/HEP.0000000000000520" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37363821/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Alessandro Mantovani, Giorgia Petracca, Alessandro Beatrice, Alessandro Csermely, Andrea Lonardo, Jörn M. Schattenberg, Herbert Tilg, Christopher D. Byrne, Giovanni Targher.</strong> <em>Non-alcoholic fatty liver disease and risk of incident chronic kidney disease: an updated meta-analysis.</em> Gut. 2022;71(1):156–162. doi: 10.1136/gutjnl-2020-323082. <a href="https://doi.org/10.1136/gutjnl-2020-323082" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Luís Henrique Bezerra Cavalcanti Sette, Edmundo Pessoa de Almeida Lopes.</strong> <em>Liver enzymes serum levels in patients with chronic kidney disease on hemodialysis: a comprehensive review.</em> Clinics. 2014;69(4):271–278. doi: 10.6061/clinics/2014(04)09. <a href="https://doi.org/10.6061/clinics/2014(04)09" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3971360/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Karem Awad, Fadi Abu Baker, Mahmoud Foqara, Alexander Shtarkman, Abdellatif Zhalka, Tor Regev-Sadeh, Rawi Hazzan.</strong> <em>Liver Stiffness Variability and Limited Performance of Non-Invasive Fibrosis Scores in Hemodialysis: A Prospective Study.</em> Diagnostics. 2026;16(13):2080. doi: 10.3390/diagnostics16132080. <a href="https://doi.org/10.3390/diagnostics16132080" target="_blank" rel="noopener noreferrer">DOI</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42449861/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Medscape Reference Editorial Staff.</strong> <em>Metabolic dysfunction-associated steatotic liver disease: assessment and management.</em> Sekundárne spracovanie, ktoré nenahrádza konečné odporúčanie NICE. <a href="https://reference.medscape.com/cc2/p10/non-alcoholic-fatty-liver-disease-nafld-assessment-and-2022a10019uf" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom a aktuálnosti:</strong> Diagnostický algoritmus vychádza prednostne z odporúčania EASL–EASD–EASO z roku 2024. Regulačný stav cielenej liečby a európske informácie o lieku boli overené 13. augusta 2026 na stránkach EMA a ŠÚKL. Registrácia, úhrada a dostupnosť sa môžu meniť; pred predpísaním treba skontrolovať aktuálny súhrn charakteristických vlastností lieku a slovenské kategorizačné podmienky. Sekundárne spracovanie Medscape obsahovalo časový údaj o NICE, ktorý sa nezhodoval s oficiálnou stránkou, preto nebolo použité ako autoritatívny podklad.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_masld-diagnostika-fibroza-nefrologicka-prax_article',
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
