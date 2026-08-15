<?php
/**
 * add_postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie článku: Postmarketingové bezpečnostné zlyhania liekov (FDA/EMA).
 * Autor projektu: MUDr. Ľubomír Polaščín. Pôvodná syntéza (nie preklad jedného
 * zdroja) → source_authors.php sa nedopĺňa.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'Postmarketingové bezpečnostné zlyhania liekov: hĺbková analýza 10 liekov s fatálnymi dôsledkami v regulačnom prostredí FDA a EMA',
    'slug'         => 'postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Hĺbková analýza desiatich liekov stiahnutých z trhu pre závažné postmarketingové bezpečnostné zlyhania — od Vioxxu po Zantac. Rozoberá kauzalitu, typy dôkazov, časové intervaly do stiahnutia a rozdiely v prístupe FDA a EMA, vrátane odporúčaní pre farmakovigilanciu.',
    'content'      => <<<'HTML'
<p>Schválenie lieku regulačným orgánom nie je zárukou jeho dlhodobej bezpečnosti. Táto hĺbková analýza desiatich liekov s fatálnymi postmarketingovými zlyhaniami ukazuje, kde a prečo zlyháva dohľad nad liekmi po ich uvedení na trh — a čo z toho vyplýva pre prax.</p>

<nav aria-label="Obsah článku">
  <h2>Obsah</h2>
  <ol>
    <li><a href="#uvod">Úvod a metodika</a></li>
    <li><a href="#prehlad">Prehľadová tabuľka analyzovaných liekov</a></li>
    <li><a href="#analyzy">Hĺbkové analýzy jednotlivých liekov</a></li>
    <li><a href="#synteza">Analytická syntéza — kauzalita, dôkazy a regulačné rozdiely</a></li>
    <li><a href="#diskusia">Diskusia: <em>Primum non nocere</em> v ére zrýchlených schvaľovacích procesov</a></li>
    <li><a href="#zaver">Záver a odporúčania</a></li>
    <li><a href="#literatura">Zoznam citovanej literatúry</a></li>
  </ol>
</nav>

<h2 id="uvod">1. Úvod a metodika</h2>

<p>Schválenie lieku regulačnými orgánmi, akými sú americký Úrad pre potraviny a liečivá (FDA) a Európska agentúra pre lieky (EMA), predstavuje vyvrcholenie rozsiahleho výskumu, klinických skúšaní a regulačného dohľadu. Lieky schválené týmito orgánmi sa následne považujú za bezpečné na klinické použitie. Historické dôkazy však ukazujú, že schválenie nezaručuje dlhodobú bezpečnosť a účinnosť. Postmarketingový dohľad odhalil bezpečnostné obavy a nepredvídané riziká spojené s mnohými liekmi, čo niekedy viedlo k ich stiahnutiu z trhu alebo k obmedzeniu používania.</p>

<p>Táto hĺbková analýza sa zameriava na 10 vybraných liekov, u ktorých došlo po uvedení na trh k závažným bezpečnostným zlyhaniam vrátane fatálnych následkov, kardiovaskulárnych príhod, hepatotoxicity, karcinogenity a ďalších závažných nežiaducich udalostí. Analyzujeme regulačné prostredie FDA aj EMA, typy dôkazov, ktoré viedli k regulačným opatreniam, a rozdiely v prístupe medzi jednotlivými jurisdikciami.</p>

<p>Metodologicky vychádzame z viacerých zdrojov vrátane systematického prehľadu 462 liekov stiahnutých z trhu pre nežiaduce liekové reakcie, kohortovej štúdie Yale School of Medicine o bezpečnostných problémoch liekov schválených FDA v rokoch 2001 – 2010, verejných zoznamov stiahnutých liekov a ďalších odborných publikácií. Každý liek hodnotíme z hľadiska kauzality, kvality dôkazov a regulačného kontextu s cieľom identifikovať systémové nedostatky v postmarketingovom dohľade.</p>

<h2 id="prehlad">2. Prehľadová tabuľka analyzovaných liekov</h2>

<div class="table-responsive" role="region" aria-label="Prehľadová tabuľka analyzovaných liekov" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liek (INN)</th>
      <th scope="col">Indikácia</th>
      <th scope="col">Rok schválenia</th>
      <th scope="col">Závažné riziká</th>
      <th scope="col">Regulačné opatrenie</th>
      <th scope="col">Istota kauzality</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Rofekoxib</strong> (Vioxx)</td>
      <td>Artritída, bolesť</td>
      <td>1999 (FDA)</td>
      <td>Infarkt myokardu, cievna mozgová príhoda</td>
      <td>Stiahnutie z trhu (2004)</td>
      <td>Vysoká — RCT a observačné štúdie</td>
    </tr>
    <tr>
      <td><strong>Troglitazón</strong> (Rezulin)</td>
      <td>Diabetes mellitus 2. typu</td>
      <td>1997 (FDA)</td>
      <td>Hepatotoxicita, zlyhanie pečene</td>
      <td>Stiahnutie z trhu (2000)</td>
      <td>Vysoká — kazuistiky a observačné štúdie</td>
    </tr>
    <tr>
      <td><strong>Cerivastatín</strong> (Baycol/Lipobay)</td>
      <td>Hypercholesterolémia</td>
      <td>1998 (FDA)</td>
      <td>Rabdomyolýza, zlyhanie obličiek</td>
      <td>Stiahnutie z trhu (2001)</td>
      <td>Vysoká — kazuistiky a farmakoepidemiológia</td>
    </tr>
    <tr>
      <td><strong>Cisaprid</strong> (Propulsid)</td>
      <td>Gastroezofageálny reflux</td>
      <td>1993 (FDA)</td>
      <td>Fatálne srdcové arytmie</td>
      <td>Obmedzenie indikácií, neskôr stiahnutie (2000)</td>
      <td>Vysoká — kazuistiky a farmakovigilančné signály</td>
    </tr>
    <tr>
      <td><strong>Valdekoxib</strong> (Bextra)</td>
      <td>Artritída, bolesť</td>
      <td>2001 (FDA)</td>
      <td>Infarkt myokardu, cievna mozgová príhoda, Stevensov-Johnsonov syndróm</td>
      <td>Stiahnutie z trhu (2004)</td>
      <td>Stredná až vysoká — RCT a observačné štúdie</td>
    </tr>
    <tr>
      <td><strong>Tegaserod</strong> (Zelnorm)</td>
      <td>Syndróm dráždivého čreva</td>
      <td>2002 (FDA)</td>
      <td>Kardiovaskulárne príhody</td>
      <td>Stiahnutie (2007), neskôr obmedzené znovuuvedenie (2019)</td>
      <td>Stredná — observačné štúdie</td>
    </tr>
    <tr>
      <td><strong>Fenfluramín</strong> (Pondimin)</td>
      <td>Obezita</td>
      <td>1973 (FDA)</td>
      <td>Srdcová valvulopatia, pľúcna hypertenzia</td>
      <td>Stiahnutie z trhu (1997)</td>
      <td>Vysoká — observačné štúdie a echokardiografia</td>
    </tr>
    <tr>
      <td><strong>Sibutramín</strong> (Meridia/Reductil)</td>
      <td>Obezita</td>
      <td>1997 (FDA), 1999 (EMA)</td>
      <td>Infarkt myokardu, cievna mozgová príhoda</td>
      <td>Stiahnutie z trhu (2010)</td>
      <td>Vysoká — RCT (štúdia SCOUT)</td>
    </tr>
    <tr>
      <td><strong>Natalizumab</strong> (Tysabri)</td>
      <td>Roztrúsená skleróza</td>
      <td>2004 (FDA)</td>
      <td>Progresívna multifokálna leukoencefalopatia (PML)</td>
      <td>Dočasné stiahnutie (2005), obmedzené znovuuvedenie (2006)</td>
      <td>Vysoká — kazuistiky a klinické skúšania</td>
    </tr>
    <tr>
      <td><strong>Ranitidín</strong> (Zantac)</td>
      <td>Peptický vred, GERD</td>
      <td>1983 (FDA)</td>
      <td>Karcinogenita (NDMA)</td>
      <td>Celosvetové stiahnutie (2020)</td>
      <td>Vysoká — analytické štúdie kontaminácie</td>
    </tr>
  </tbody>
</table>
</div>

<h2 id="analyzy">3. Hĺbkové analýzy jednotlivých liekov</h2>

<h3 id="rofekoxib">3.1 Rofekoxib (Vioxx)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Rofekoxib, predávaný pod obchodným názvom Vioxx, bol selektívnym inhibítorom cyklooxygenázy-2 (COX-2) a nesteroidným protizápalovým liekom. Pôvodne bol schválený na liečbu bolesti u pacientov s artritídou. Jeho mechanizmus účinku spočíval v selektívnej inhibícii enzýmu COX-2, čo malo teoreticky priniesť protizápalový účinok bez gastrointestinálnych vedľajších účinkov spojených s neselektívnymi NSAID.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>V čase schválenia FDA v roku 1999 boli k dispozícii klinické skúšania, ktoré preukázali znížený výskyt gastrointestinálnych komplikácií v porovnaní s tradičnými NSAID. Kardiovaskulárne riziko nebolo v predregistračných štúdiách dostatočne identifikované pre relatívne krátke trvanie štúdií a obmedzenú veľkosť súboru.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa objavili signály o zvýšenom kardiovaskulárnom riziku. Následná placebom kontrolovaná štúdia APPROVe (Adenomatous Polyp Prevention on Vioxx) bola predčasne ukončená, keď sa zistilo, že rofekoxib zdvojnásobuje riziko kardiovaskulárnych príhod. Výsledky ukázali, že liek zvyšoval riziko infarktu myokardu a cievnej mozgovej príhody.</p>

<h4>Dôkazy o kardiovaskulárnych komplikáciách a mortalite</h4>
<p>Metaanalýzy a observačné štúdie potvrdili, že rofekoxib signifikantne zvyšoval riziko kardiovaskulárnych príhod. Odhaduje sa, že celosvetovo bolo s užívaním Vioxxu spojených 88 000 až 140 000 prípadov závažných kardiovaskulárnych ochorení, z ktorých približne 30 – 40 % bolo fatálnych.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>Spoločnosť Merck dobrovoľne stiahla Vioxx z celosvetového trhu v septembri 2004. Toto rozhodnutie bolo prijaté po zverejnení výsledkov štúdie APPROVe. FDA následne vydala varovanie a začala preskúmavanie celej triedy COX-2 inhibítorov.</p>

<h4>Aktuálny stav</h4>
<p>Rofekoxib zostáva stiahnutý z trhu vo všetkých krajinách. Prípad Vioxxu sa stal symbolom potreby prísnejšieho postmarketingového dohľadu a viedol k významným zmenám v regulačných postupoch vrátane posilnenia požiadaviek na bezpečnostné štúdie po uvedení lieku na trh.</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je podporená randomizovanými kontrolovanými štúdiami, observačnými štúdiami a biologickou plauzibilitou.</p>

<h3 id="troglitazon">3.2 Troglitazón (Rezulin)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Troglitazón, predávaný pod názvom Rezulin, bol prvým liekom v triede tiazolidíndiónov (glitazónov) schváleným na liečbu diabetes mellitus 2. typu. Pôsobil ako agonista receptorov PPAR-γ, čím zvyšoval citlivosť tkanív na inzulín.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>Predregistračné klinické skúšania nezachytili plný rozsah hepatotoxicity. Štúdie boli relatívne krátkodobé a zahŕňali obmedzený počet pacientov, čo neumožnilo identifikovať zriedkavé, ale závažné pečeňové reakcie.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa začali hromadiť hlásenia o závažnom poškodení pečene vrátane fatálneho zlyhania pečene. Postmarketingové údaje ukázali významný nárast prípadov zlyhania pečene spojených s užívaním Rezulinu. FDA evidovala desiatky prípadov akútneho zlyhania pečene, ktoré si vyžiadali transplantáciu alebo viedli k smrti.</p>

<h4>Dôkazy o hepatotoxicite a mortalite</h4>
<p>Kazuistiky a observačné štúdie identifikovali mechanizmus hepatotoxicity zahŕňajúci mitochondriálnu dysfunkciu a steatózu pečene. Niektorí pacienti vykazovali prudký nárast pečeňových enzýmov už po niekoľkých týždňoch liečby. Odhaduje sa, že troglitazón spôsobil desiatky úmrtí na zlyhanie pečene.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>FDA spočiatku reagovala varovaniami a odporúčaniami na monitorovanie pečeňových funkcií. V marci 2000 bol Rezulin stiahnutý z amerického trhu. Európske krajiny postupovali podobne, pričom niektoré stiahli liek ešte pred FDA.</p>

<h4>Aktuálny stav</h4>
<p>Troglitazón bol nahradený bezpečnejšími tiazolidíndiónmi (pioglitazón, rosiglitazón), aj keď aj tieto lieky mali neskôr svoje bezpečnostné problémy (rosiglitazón bol v roku 2010 stiahnutý z európskeho trhu pre kardiovaskulárne riziko).</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Podporený rozsiahlymi kazuistikami, observačnými štúdiami a patofyziologickým mechanizmom.</p>

<h3 id="cerivastatin">3.3 Cerivastatín (Baycol/Lipobay)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Cerivastatín, predávaný pod názvami Baycol a Lipobay, bol statín (inhibítor HMG-CoA reduktázy) určený na zníženie hladiny cholesterolu. Patril medzi najúčinnejšie statíny v znižovaní LDL cholesterolu.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>V čase schválenia FDA v roku 1998 boli známe riziká spojené so statínmi vrátane myopatie a zriedkavej rabdomyolýzy. Cerivastatín bol schválený v nízkych dávkach, no neskôr boli zavedené vyššie dávky bez dostatočného vyhodnotenia bezpečnostného profilu.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa začali objavovať hlásenia o závažnej, často fatálnej rabdomyolýze, najmä v kombinácii s gemfibrozilom (ďalším liekom na zníženie lipidov). Cerivastatín bol stiahnutý z trhu v roku 2001, pretože spôsoboval rabdomyolýzu — rozpad svalového tkaniva, ktorý viedol k zlyhaniu obličiek a k smrti.</p>

<h4>Dôkazy o rabdomyolýze a mortalite</h4>
<p>FDA evidovala 31 potvrdených úmrtí na rabdomyolýzu u pacientov užívajúcich cerivastatín, z toho 12 v kombinácii s gemfibrozilom. Incidencia rabdomyolýzy pri cerivastatíne bola 10- až 50-krát vyššia ako pri iných statínoch. Mechanizmus zahŕňal inhibíciu metabolizmu cerivastatínu gemfibrozilom, čo viedlo k 5- až 8-násobnému zvýšeniu plazmatických hladín cerivastatínu.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>Spoločnosť Bayer dobrovoľne stiahla cerivastatín z celosvetového trhu v auguste 2001. Stiahnutie bolo výsledkom rastúceho počtu hlásení o fatálnej rabdomyolýze a následného regulačného tlaku.</p>

<h4>Aktuálny stav</h4>
<p>Cerivastatín zostáva stiahnutý z trhu. Prípad viedol k zvýšenému monitorovaniu liekových kombinácií a k zavedeniu prísnejších požiadaviek na farmakovigilanciu.</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je jednoznačne podporená farmakokinetickými interakciami a epidemiologickými údajmi.</p>

<h3 id="cisaprid">3.4 Cisaprid (Propulsid)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Cisaprid, predávaný pod názvom Propulsid, bol prokinetický liek používaný na liečbu gastroezofageálneho refluxu (GERD). Pôsobil ako agonista 5-HT4 receptora, čím stimuloval motilitu gastrointestinálneho traktu.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>V čase schválenia FDA v roku 1993 boli známe len mierne vedľajšie účinky, ako hnačka a bolesti brucha. Kardiálne riziko nebolo identifikované v predregistračných klinických skúšaniach.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa začali objavovať hlásenia o závažných srdcových arytmiách vrátane <em>torsades de pointes</em> a náhlej srdcovej smrti. Riziko bolo vyššie u pacientov s predĺženým QT intervalom, hypokaliémiou, hypomagneziémiou a pri súbežnom užívaní liekov, ktoré inhibujú metabolizmus cisapridu (azolové antimykotiká, makrolidové antibiotiká).</p>

<h4>Dôkazy o srdcových arytmiách a mortalite</h4>
<p>FDA evidovala stovky hlásení o srdcových arytmiách vrátane desiatok fatálnych prípadov. Mechanizmus zahŕňal blokádu draslíkových kanálov hERG v srdci, čo viedlo k predĺženiu QT intervalu. Riziko bolo obzvlášť vysoké u pacientov so súbežným užívaním inhibítorov CYP3A4.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>FDA spočiatku obmedzila indikácie a pridala kontraindikácie. V júli 2000 bol cisaprid stiahnutý z amerického trhu. EMA postupovala podobne a liek bol stiahnutý aj v Európe.</p>

<h4>Aktuálny stav</h4>
<p>Cisaprid zostáva stiahnutý z trhu vo väčšine krajín. V niektorých krajinách je dostupný len v rámci individualizovaného prístupu (<em>named patient program</em>).</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je podporená desiatkami kazuistík, farmakologickým mechanizmom a <em>in vitro</em> štúdiami na kanáloch hERG.</p>

<h3 id="valdekoxib">3.5 Valdekoxib (Bextra)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Valdekoxib, predávaný pod názvom Bextra, bol selektívny inhibítor COX-2, podobne ako rofekoxib. Bol schválený na liečbu artritídy a dysmenorey.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>V čase schválenia FDA v roku 2001 boli známe kardiovaskulárne riziká COX-2 inhibítorov, no valdekoxib bol považovaný za bezpečnejší než rofekoxib. Predregistračné štúdie nezachytili plný rozsah kardiovaskulárneho rizika ani Stevensovho-Johnsonovho syndrómu.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa objavili hlásenia o kardiovaskulárnych príhodách a závažných kožných reakciách vrátane Stevensovho-Johnsonovho syndrómu. Liek bol stiahnutý z trhu v roku 2004 pre kombináciu kardiovaskulárneho rizika a závažných kožných reakcií.</p>

<h4>Dôkazy o kardiovaskulárnych príhodách a Stevensovom-Johnsonovom syndróme</h4>
<p>Metaanalýzy ukázali zvýšené riziko kardiovaskulárnych príhod podobné ako pri rofekoxibe. Stevensov-Johnsonov syndróm sa vyskytol najmä v prvých dvoch týždňoch liečby a postihoval predovšetkým pacientov s alergiou na sulfónamidy.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>FDA požiadala spoločnosť Pfizer o stiahnutie Bextry z trhu v apríli 2004. EMA podobne odporučila stiahnutie lieku z európskeho trhu. Stiahnutie bolo motivované kombináciou kardiovaskulárneho rizika a závažných kožných reakcií.</p>

<h4>Aktuálny stav</h4>
<p>Valdekoxib zostáva stiahnutý z trhu. Jeho prípad prispel k prehodnoteniu bezpečnostného profilu celej triedy COX-2 inhibítorov.</p>

<p><strong>Stupeň istoty kauzality: stredný až vysoký.</strong> Kardiovaskulárne riziko je dobre zdokumentované, ale kauzalita Stevensovho-Johnsonovho syndrómu je menej istá pre nízku incidenciu.</p>

<h3 id="tegaserod">3.6 Tegaserod (Zelnorm)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Tegaserod, predávaný pod názvom Zelnorm, bol agonista 5-HT4 receptora používaný na liečbu syndrómu dráždivého čreva s prevahou zápchy (IBS-C) a chronickej idiopatickej zápchy.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>FDA schválila tegaserod v roku 2002 na základe klinických štúdií, ktoré preukázali účinnosť pri liečbe IBS-C. Kardiovaskulárne riziko nebolo v predregistračných štúdiách identifikované. Liek bol schválený len pre ženy, u ktorých sa preukázala účinnosť.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa objavili signály o zvýšenom riziku kardiovaskulárnych príhod vrátane infarktu myokardu, cievnej mozgovej príhody a nestabilnej angíny pektoris. Analýza 29 klinických štúdií ukázala zvýšený výskyt kardiovaskulárnych príhod u pacientov liečených tegaserodom v porovnaní s placebom.</p>

<h4>Dôkazy o kardiovaskulárnych príhodách a mortalite</h4>
<p>Metaanalýza 29 klinických štúdií identifikovala 13 kardiovaskulárnych príhod u pacientov liečených tegaserodom (0,11 %) oproti 1 príhode v placebovej skupine (0,01 %). Pomer rizík bol 2,5 (95 % CI 1,2 – 5,1). Hoci absolútne riziko bolo nízke, relatívne riziko bolo signifikantne zvýšené.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>FDA požiadala o stiahnutie tegaserodu z trhu v marci 2007. Liek bol odstránený z amerického trhu, no bol dostupný v rámci obmedzeného programu až do apríla 2008. V roku 2019 FDA schválila obmedzené znovuuvedenie tegaserodu pre špecifickú populáciu pacientok s IBS-C bez kardiovaskulárneho rizika.</p>

<h4>Aktuálny stav</h4>
<p>Tegaserod bol znovu uvedený na trh v roku 2019 s výrazne obmedzenými indikáciami. Prípad tegaserodu ilustruje kompromis medzi terapeutickým prínosom a bezpečnostným rizikom, ktorý môže viesť k znovuuvedeniu lieku za prísnych podmienok.</p>

<p><strong>Stupeň istoty kauzality: stredný.</strong> Kauzalita je podporená metaanalýzou klinických štúdií, no nízky počet príhod znižuje štatistickú silu dôkazov.</p>

<h3 id="fenfluramin">3.7 Fenfluramín (Pondimin)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Fenfluramín, predávaný pod názvom Pondimin, bol liek na potlačenie chuti do jedla používaný na liečbu obezity. Pôsobil ako agonista serotonínových receptorov, čím zvyšoval pocit sýtosti.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>Fenfluramín bol schválený FDA v roku 1973. V čase schválenia boli známe mierne vedľajšie účinky, ako sucho v ústach, hnačka a ospalosť. Kardiovaskulárne riziko nebolo identifikované v predregistračných štúdiách.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh, najmä po kombinácii s fentermínom (tzv. fen-phen), sa objavili hlásenia o srdcovej valvulopatii a pľúcnej hypertenzii. Echokardiografické štúdie ukázali, že 30 – 40 % pacientov užívajúcich fenfluramín vyvinulo abnormálne zmeny srdcových chlopní.</p>

<h4>Dôkazy o srdcovej valvulopatii a pľúcnej hypertenzii</h4>
<p>Observačné štúdie a echokardiografické vyšetrenia potvrdili asociáciu medzi užívaním fenfluramínu a rozvojom srdcovej valvulopatie. Mechanizmus zahŕňal aktiváciu 5-HT2B receptorov na srdcových chlopniach, čo viedlo k proliferácii valvulárnych intersticiálnych buniek. Pľúcna hypertenzia bola spojená s ovplyvnením serotonínového transportéra v pľúcach.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>FDA požiadala o stiahnutie fenfluramínu z trhu v septembri 1997. Liek bol stiahnutý v USA, Európe a ďalších krajinách. V júni 2020 bol fenfluramín znovu schválený FDA na liečbu záchvatov spojených s Dravetovým syndrómom podľa pravidiel pre orphan lieky, no s výrazne odlišným dávkovaním a monitorovaním.</p>

<h4>Aktuálny stav</h4>
<p>Fenfluramín je v súčasnosti schválený len na liečbu Dravetovho syndrómu, zriedkavej formy detskej epilepsie. Prípad fenfluramínu ilustruje, že liek stiahnutý pre závažné bezpečnostné riziko môže byť znovu uvedený na trh pre úplne odlišnú indikáciu s prísnym monitorovaním.</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je podporená rozsiahlymi observačnými štúdiami, echokardiografickými dôkazmi a biologickým mechanizmom.</p>

<h3 id="sibutramin">3.8 Sibutramín (Meridia/Reductil)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Sibutramín, predávaný pod názvami Meridia (USA) a Reductil (Európa), bol liek na potlačenie chuti do jedla používaný na liečbu obezity. Pôsobil ako inhibítor spätného vychytávania serotonínu a noradrenalínu, čím zvyšoval pocit sýtosti a termogenézu.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>FDA schválila sibutramín v roku 1997, EMA v roku 1999. V čase schválenia boli známe mierne kardiovaskulárne účinky (zvýšenie krvného tlaku a srdcovej frekvencie), no tieto boli považované za klinicky akceptovateľné vzhľadom na potenciálny prínos redukcie hmotnosti.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>Po uvedení na trh sa objavili signály o zvýšenom kardiovaskulárnom riziku. Štúdia SCOUT (Sibutramine Cardiovascular OUTcomes), ktorá zahŕňala 10 744 pacientov s nadváhou alebo obezitou a s existujúcim kardiovaskulárnym ochorením alebo diabetom 2. typu, preukázala 16 % zvýšenie rizika závažných kardiovaskulárnych príhod (infarkt myokardu, cievna mozgová príhoda, resuscitovaná zástava srdca, kardiovaskulárna smrť).</p>

<h4>Dôkazy o kardiovaskulárnych príhodách a mortalite</h4>
<p>Štúdia SCOUT (pomer rizík HR 1,16; 95 % CI 1,03 – 1,31) poskytla presvedčivé dôkazy o kardiovaskulárnom riziku sibutramínu. Vyššie riziko bolo pozorované najmä u pacientov s už existujúcim kardiovaskulárnym ochorením. Sibutramín bol stiahnutý z trhu vo viacerých krajinách vrátane Austrálie, Kanady, Číny, EÚ, Indie, Mexika, Nového Zélandu, Filipín, Thajska, Spojeného kráľovstva a USA.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>EMA odporučila pozastavenie registrácie sibutramínu v januári 2010. FDA požiadala o dobrovoľné stiahnutie Meridie z amerického trhu v októbri 2010. Európske krajiny a ďalšie štáty postupovali podobne.</p>

<h4>Aktuálny stav</h4>
<p>Sibutramín zostáva stiahnutý z trhu vo väčšine krajín. Prípad sibutramínu je významný, pretože kauzalita bola potvrdená rozsiahlou randomizovanou klinickou štúdiou navrhnutou špecificky na hodnotenie kardiovaskulárnej bezpečnosti.</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je podporená rozsiahlou randomizovanou kontrolovanou štúdiou (SCOUT) s viac než 10 000 pacientmi.</p>

<h3 id="natalizumab">3.9 Natalizumab (Tysabri)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Natalizumab, predávaný pod názvom Tysabri, bol humanizovaná monoklonálna protilátka používaná na liečbu roztrúsenej sklerózy. Pôsobil ako antagonista α4-integrínu, čím blokoval migráciu lymfocytov do centrálneho nervového systému.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>FDA schválila natalizumab vo februári 2004 na základe klinických štúdií, ktoré preukázali významné zníženie relapsov a progresie disability u pacientov s roztrúsenou sklerózou. V čase schválenia neboli známe riziká spojené s progresívnou multifokálnou leukoencefalopatiou (PML), pretože v predregistračných štúdiách sa tento typ komplikácie nevyskytol.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>V priebehu prvého roka po schválení boli hlásené tri prípady PML — zriedkavej a fatálnej oportúnnej infekcie mozgu spôsobenej vírusom JC. Dva prípady sa vyskytli u pacientov s roztrúsenou sklerózou liečených natalizumabom a jeden u pacienta s Crohnovou chorobou. Všetky tri prípady boli fatálne alebo viedli k závažnému neurologickému poškodeniu.</p>

<h4>Dôkazy o PML a mortalite</h4>
<p>Kazuistiky a observačné štúdie identifikovali rizikové faktory pre rozvoj PML: pozitivita na protilátky proti vírusu JC, dĺžka liečby nad 24 mesiacov a predchádzajúca imunosupresívna liečba. Celkové riziko PML sa odhaduje na 1 : 1000 až 1 : 100 v závislosti od kombinácie rizikových faktorov.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>Spoločnosť Biogen dobrovoľne stiahla Tysabri z amerického trhu vo februári 2005. Po analýze rizík a prínosov FDA schválila obmedzené znovuuvedenie natalizumabu v júli 2006 v rámci špeciálneho programu TOUCH (Tysabri Outreach: Unified Commitment to Health), ktorý vyžaduje prísne monitorovanie a hlásenie akýchkoľvek nových neurologických symptómov.</p>

<h4>Aktuálny stav</h4>
<p>Natalizumab je v súčasnosti dostupný len v rámci prísneho monitorovacieho programu. Prípad natalizumabu ilustruje, že aj lieky s výnimočným terapeutickým prínosom môžu byť spojené so závažnými rizikami, ktoré sa objavia až po uvedení na trh, a že regulačné orgány môžu umožniť prístup k takýmto liekom za prísnych podmienok.</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je jednoznačne podporená kazuistikami a biologickou plauzibilitou (blokáda imunitného dohľadu v CNS).</p>

<h3 id="ranitidin">3.10 Ranitidín (Zantac)</h3>

<h4>Schválenie a klinický benefit</h4>
<p>Ranitidín, predávaný pod názvom Zantac, bol antagonista H2 receptora používaný na liečbu peptického vredu a gastroezofageálneho refluxu. Patril medzi najpredávanejšie lieky na svete.</p>

<h4>Bezpečnostné obmedzenia v čase schválenia</h4>
<p>FDA schválila ranitidín v roku 1983. V čase schválenia bol ranitidín považovaný za bezpečný liek s minimálnymi vedľajšími účinkami. Neboli známe žiadne riziká spojené s karcinogenitou.</p>

<h4>Postmarketingový vývoj a identifikácia rizík</h4>
<p>V roku 2019 nezávislé laboratórium (Valisure) zistilo, že ranitidín sa spontánne rozkladá na N-nitrózodimetylamín (NDMA), ktorý je pravdepodobným ľudským karcinogénom. NDMA vzniká pri skladovaní ranitidínu pri zvýšených teplotách a jeho koncentrácia v lieku sa časom zvyšuje. FDA potvrdila prítomnosť NDMA v rôznych šaržiach ranitidínu a iniciovala vyšetrovanie.</p>

<h4>Dôkazy o karcinogenite</h4>
<p>Analytické štúdie potvrdili, že ranitidín produkuje NDMA v koncentráciách prekračujúcich prijateľný denný príjem stanovený FDA (96 ng/deň). NDMA je klasifikovaný ako pravdepodobný ľudský karcinogén na základe štúdií na zvieratách. Dlhodobé účinky u ľudí sú ťažko kvantifikovateľné, no potenciálne riziko rakoviny bolo považované za významné.</p>

<h4>Regulačné kroky a stiahnutie z trhu</h4>
<p>FDA požiadala o stiahnutie všetkých liekov obsahujúcich ranitidín z amerického trhu v apríli 2020. EMA a ďalšie regulačné orgány nasledovali po podobnom vyšetrovaní. Liek bol celosvetovo stiahnutý. Výrobcovia boli požiadaní, aby pozastavili distribúciu a začali proces stiahnutia všetkých šarží.</p>

<h4>Aktuálny stav</h4>
<p>Ranitidín je v súčasnosti stiahnutý z trhu a nie je dostupný v lekárňach. Nahradili ho iné lieky na zníženie kyslosti žalúdka, ako sú inhibítory protónovej pumpy (omeprazol, lansoprazol) alebo iné H2 antagonisty (famotidín). Prípad ranitidínu je unikátny, pretože riziko nebolo spôsobené farmakologickým účinkom lieku, ale chemickou nestabilitou vedúcou k tvorbe karcinogénnej látky.</p>

<p><strong>Stupeň istoty kauzality: vysoký.</strong> Kauzalita je podporená chemickými analýzami, ktoré jednoznačne preukázali tvorbu NDMA.</p>

<h2 id="synteza">4. Analytická syntéza — kauzalita, dôkazy a regulačné rozdiely</h2>

<h3>4.1 Typy dôkazov vedúcich k regulačným opatreniam</h3>
<p>Systematický prehľad 462 liekov stiahnutých z trhu pre nežiaduce liekové reakcie ukázal, že hepatotoxicita (81 prípadov, 18 %) bola najčastejšie hlásenou nežiaducou reakciou vedúcou k stiahnutiu, nasledovaná imunitne sprostredkovanými reakciami (79 prípadov, 17 %), neurotoxicitou (76 prípadov, 16 %), kardiotoxicitou (63 prípadov, 14 %), karcinogenitou (61 prípadov, 13 %), hematologickou toxicitou (53 prípadov, 11 %) a liekovou závislosťou (52 prípadov, 11 %). Úmrtia boli spojené so stiahnutím v 114 prípadoch (25 %).</p>

<p>Z hľadiska úrovne dôkazov boli kazuistiky najčastejšie používaným dôkazom pre stiahnutie liekov, a to v 71 % všetkých prípadov. V 49 prípadoch (11 %) boli rozhodnutia o stiahnutí založené na výsledkoch štúdií na zvieratách. Frekvencia používania kazuistík ako dominantného zdroja informácií sa časom znižovala — z 85 % v 50. rokoch 20. storočia na 64 % v 90. rokoch a od roku 2000 na 35 %.</p>

<h3>4.2 Časové intervaly medzi uvedením na trh a stiahnutím</h3>
<p>Medián intervalu medzi prvým uvedením na trh a prvým stiahnutím bol 18 rokov (IQR 6 – 34) pre všetky lieky a 10 rokov pre lieky uvedené po roku 1960 (IQR 3 – 19). Medián intervalu medzi prvou hlásenou nežiaducou reakciou a rokom prvého stiahnutia bol 6 rokov (IQR 1 – 15) pre všetky lieky a 3 roky pre lieky uvedené po roku 1960 (IQR 0 – 8).</p>

<p>Kohortová štúdia Yale School of Medicine zistila, že u 71 z 222 liekov schválených FDA v rokoch 2001 – 2010 došlo k bezpečnostným problémom, ktoré sa prejavili v mediáne 4,2 roka po schválení. Tieto zistenia poukazujú na to, že hoci sa interval medzi uvedením lieku na trh a prvým hlásením nežiaducej reakcie skracuje, interval medzi prvým hlásením a regulačným opatrením sa výrazne neskracuje.</p>

<h3>4.3 Regionálne rozdiely v stiahnutí liekov</h3>
<p>Zo 462 liekov bolo 43 (9,34 %) stiahnutých celosvetovo a 179 (39 %) len v jednej krajine. Miera stiahnutí na jednu krajinu bola signifikantne nižšia v Afrike v porovnaní s Áziou, Austráliou a Oceániou, Európou, Severnou Amerikou a Južnou Amerikou. Len 4 % afrických krajín majú stredne rozvinuté farmakovigilančné systémy a 39 % postráda adekvátnu regulačnú kapacitu.</p>

<p>Tieto rozdiely poukazujú na nerovnomernú globálnu implementáciu farmakovigilančných systémov a na potrebu lepšej koordinácie medzi regulačnými orgánmi.</p>

<h3>4.4 Rozdiely medzi FDA a EMA</h3>
<p>Štúdie ukázali, že FDA schvaľuje lieky rýchlejšie než jej európsky náprotivok EMA. Lieky, ktoré boli schválené v zrýchlenom procese FDA, mali vyššiu mieru bezpečnostných intervencií. Zrýchlené schvaľovanie sa často spolieha na náhradné ukazovatele (<em>surrogate endpoints</em>), čo znamená, že výskumníci merajú niečo iné než prežitie, napríklad veľkosť nádoru, aby určili, či liek funguje.</p>

<p>FDA tiež zaviedla požiadavky na genetické testovanie pred podaním niektorých liekov (napríklad kapecitabínu), aby sa zabránilo fatálnym toxickým reakciám. Na druhej strane EMA kladie väčší dôraz na postmarketingové bezpečnostné štúdie (PASS) a povinné plány riadenia rizík (RMP).</p>

<h3>4.5 Podhodnotenie nežiaducich reakcií</h3>
<p>Podhodnotenie nežiaducich liekových reakcií je významným problémom, ktorý môže spôsobiť oneskorenie rozhodnutí o stiahnutí. Existujú dôkazy, že klinici selektívne hlásia nežiaduce liekové reakcie. Nízka miera hlásenia medzi zdravotníckymi pracovníkmi môže byť spôsobená nedostatočnou znalosťou spontánnych systémov hlásenia, konfliktom záujmov, zabúdaním, nedostatkom času a neistotou o kauzálnom vzťahu medzi liekmi a nežiaducimi udalosťami.</p>

<p>Proaktívne opatrenia na podporu hlásenia podozrivých nežiaducich reakcií zahŕňajú ekonomické stimuly a vzdelávacie aktivity. Aj pacienti pravdepodobne podhodnocujú podozrenia na nežiaduce reakcie na lieky a odporúča sa ich aktívnejšie zapojenie.</p>

<h2 id="diskusia">5. Diskusia: <em>Primum non nocere</em> v ére zrýchlených schvaľovacích procesov</h2>

<p>Princíp <em>primum non nocere</em> (predovšetkým neškodiť) je základným kameňom medicínskej etiky. V kontexte farmaceutickej regulácie tento princíp znamená, že prínos lieku musí prevažovať nad jeho rizikami. Avšak, ako ukazujú analyzované prípady, tento princíp je v praxi často narúšaný nedostatočným postmarketingovým dohľadom a tlakom na rýchle schvaľovanie liekov.</p>

<h3>5.1 Tlak na rýchle schvaľovanie a jeho dôsledky</h3>
<p>Politický tlak na FDA, aby schvaľovala lieky rýchlejšie, nie je novým fenoménom. Výskumníci z Yale School of Medicine zistili, že takmer tretina liekov schválených v rokoch 2001 – 2010 mala závažné bezpečnostné problémy roky po tom, čo boli sprístupnené pacientom. „Kým sa tlačí na menej regulácie a rýchlejšie schvaľovanie, tieto rozhodnutia majú dôsledky,“ uvádza Dr. Joseph Ross, docent medicíny na Yale School of Medicine.</p>

<p>Zákon 21st Century Cures Act, ktorý prezident Barack Obama podpísal v decembri 2016, ponúka spôsoby, ako urýchliť schvaľovanie liekov tým, že tlačí na FDA, aby zvážila dôkazy nad rámec troch fáz tradičných klinických skúšaní. Tento nový proces vyvolal obavy, že otvorí dvere schvaľovaniu liekov, ktoré neboli adekvátne testované.</p>

<h3>5.2 Obmedzenia predregistračných klinických skúšaní</h3>
<p>Predchádzajúce štúdie výskumníkov z Yale dospeli k záveru, že väčšina kľúčových skúšaní pri schvaľovaní liekov zahŕňala menej než 1000 pacientov a trvala šesť mesiacov alebo menej. Tieto obmedzenia znamenajú, že zriedkavé, ale závažné nežiaduce účinky často nie sú zachytené pred uvedením lieku na trh.</p>

<p>Dr. Vinay Prasad, hematológ-onkológ a profesor na Oregon Health and Sciences University, hovorí: „Som vlastne naklonený myšlienke, že existujú spôsoby, akými môže byť FDA efektívnejšia a robiť svoju prácu rýchlejšie. Jedno miesto, kde nechcete šetriť, je bezpečnosť a účinnosť pred uvedením na trh.“</p>

<h3>5.3 Systém hlásenia nežiaducich udalostí</h3>
<p>Systém FDA na hlásenie zdravotných problémov súvisiacich s liekmi a zdravotníckymi pomôckami je dobrovoľný. Hlásenia nie sú overované a kritici tvrdia, že tento systém je nedostatočne využívaný a obsahuje neúplné a oneskorené informácie. FDA súčasne monitoruje ďalšie dostupné štúdie a správy, aby určila, či je potrebné prijať opatrenia týkajúce sa konkrétneho lieku.</p>

<h3>5.4 Psychiatrické, biologické a zrýchlene schválené lieky</h3>
<p>Štúdia Yale School of Medicine zistila, že bezpečnostné problémy boli častejšie u psychiatrických liekov, biologických liekov, liekov schválených v zrýchlenom procese (<em>accelerated approval</em>) a liekov schválených tesne pred regulačným termínom. Lieky, ktoré prešli zrýchleným schvaľovacím procesom FDA, mali vyššiu mieru bezpečnostných intervencií.</p>

<h3>5.5 Odporúčania pre budúcnosť</h3>
<p>Na základe analyzovaných prípadov a systematického prehľadu je možné formulovať niekoľko odporúčaní:</p>
<ol>
  <li><strong>Univerzálne usmernenia pre stiahnutie liekov:</strong> mali by byť vyvinuté a podporované univerzálne usmernenia na určenie, kedy by mal byť liek stiahnutý pri podozrení na závažné nežiaduce reakcie.</li>
  <li><strong>Posilnenie systémov monitorovania liekov:</strong> viac úsilia by sa malo venovať posilneniu systémov monitorovania liekov v krajinách s nízkym a stredným príjmom, najmä v Afrike.</li>
  <li><strong>Urýchlenie regulačných opatrení:</strong> regulačné orgány a výrobcovia liekov by mali urýchliť opatrenia pri podozrení na nežiaduce reakcie; formálne štúdie na testovanie takýchto asociácií by sa mali vykonávať skôr než neskôr; možno zvážiť dočasné pozastavenia alebo obmedzenia.</li>
  <li><strong>Transparentnosť v hlásení nežiaducich udalostí:</strong> malo by byť viac transparentnosti v hlásení nežiaducich udalostí pozorovaných počas klinických skúšaní; prístup k správam o klinických štúdiách by mal byť prioritou pre budúcu reguláciu liekov.</li>
  <li><strong>Aktívne zapojenie zdravotníckych pracovníkov a pacientov:</strong> malo by sa podporovať aktívnejšie zapojenie zdravotníckych pracovníkov a pacientov do hlásenia podozrivých nežiaducich reakcií.</li>
</ol>

<p>Ako zdôrazňuje Dr. Caleb Alexander, spoluriaditeľ Johns Hopkins Center for Drug Safety and Effectiveness: „Príliš často pacienti a klinici mylne považujú schválenie FDA za indikáciu, že produkt je úplne bezpečný a účinný. Nič nemôže byť ďalej od pravdy. O produkte sa dozvieme obrovské množstvo až potom, čo je na trhu a po jeho použití v širokej populácii.“</p>

<h2 id="zaver">6. Záver a odporúčania</h2>

<p>Táto hĺbková analýza 10 liekov s postmarketingovými bezpečnostnými zlyhaniami poukazuje na systémové nedostatky v procese schvaľovania a monitorovania liekov. Hoci regulačné orgány ako FDA a EMA vyvinuli značné úsilie, aby sa škodlivé lieky nedostali na trh (menej než 2 % nových schválení FDA medzi rokmi 1950 a 2011 a 3 % schválených produktov v Kanade a USA medzi rokmi 1992 a 2011 bolo stiahnutých), prípady analyzované v tomto článku ukazujú, že existujú významné medzery v postmarketingovom dohľade.</p>

<h3>Kľúčové zistenia</h3>

<div class="table-responsive" role="region" aria-label="Kľúčové zistenia" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Aspekt</th>
      <th scope="col">Zistenie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Frekvencia bezpečnostných problémov</strong></td>
      <td>Takmer 1/3 liekov schválených FDA (2001 – 2010) mala po schválení bezpečnostné problémy</td>
    </tr>
    <tr>
      <td><strong>Čas do identifikácie rizika</strong></td>
      <td>Medián 4,2 roka po schválení</td>
    </tr>
    <tr>
      <td><strong>Najčastejšie riziká</strong></td>
      <td>Hepatotoxicita (18 %), imunitné reakcie (17 %), neurotoxicita (16 %), kardiotoxicita (14 %), karcinogenita (13 %)</td>
    </tr>
    <tr>
      <td><strong>Dôkazy používané na stiahnutie</strong></td>
      <td>Kazuistiky v 71 % prípadov</td>
    </tr>
    <tr>
      <td><strong>Celosvetové stiahnutia</strong></td>
      <td>Len 9,34 % liekov stiahnutých celosvetovo</td>
    </tr>
    <tr>
      <td><strong>Regionálne rozdiely</strong></td>
      <td>Signifikantne nižšia miera stiahnutí v Afrike</td>
    </tr>
    <tr>
      <td><strong>Interval: uvedenie – stiahnutie</strong></td>
      <td>Medián 18 rokov (všetky lieky), 10 rokov (po roku 1960)</td>
    </tr>
    <tr>
      <td><strong>Interval: prvá reakcia – stiahnutie</strong></td>
      <td>Medián 6 rokov (všetky lieky), 3 roky (po roku 1960)</td>
    </tr>
  </tbody>
</table>
</div>

<h3>Záverečné odporúčania</h3>
<ol>
  <li><strong>Posilnenie farmakovigilančných systémov v krajinách s nízkym a stredným príjmom:</strong> len 4 % afrických krajín majú stredne rozvinuté farmakovigilančné systémy. Je nevyhnutné investovať do budovania kapacít v týchto regiónoch.</li>
  <li><strong>Zlepšenie koordinácie medzi regulačnými orgánmi:</strong> väčšia koordinácia a zvýšená transparentnosť v hlásení podozrivých nežiaducich reakcií by pomohli zlepšiť súčasné rozhodovacie procesy.</li>
  <li><strong>Urýchlenie formálnych štúdií po identifikácii bezpečnostného signálu:</strong> regulačné orgány a výrobcovia liekov by mali urýchliť opatrenia pri podozrení na nežiaduce reakcie; formálne štúdie by sa mali vykonávať skôr než neskôr.</li>
  <li><strong>Transparentnosť klinických údajov:</strong> mal by sa podporovať prístup k správam o klinických štúdiách, aby sa umožnila nezávislá analýza bezpečnostných údajov.</li>
  <li><strong>Edukácia pacientov a zdravotníckych pracovníkov:</strong> je nevyhnutné zvýšiť povedomie o tom, že schválenie lieku regulačným orgánom nie je zárukou jeho dlhodobej bezpečnosti.</li>
</ol>

<p>Na záver, ako zdôrazňuje Dr. Caleb Alexander: „O produkte sa dozvieme obrovské množstvo až potom, čo je na trhu a po jeho použití v širokej populácii.“ Táto skutočnosť podčiarkuje dôležitosť robustných postmarketingových bezpečnostných systémov a neustáleho zlepšovania farmakovigilančných praktík na celom svete.</p>

<h2 id="literatura">Zoznam citovanej literatúry</h2>

<ol>
  <li>Onakpoya IJ, Heneghan CJ, Aronson JK. Post-marketing withdrawal of 462 medicinal products because of adverse drug reactions: a systematic review of the world literature. <em>BMC Medicine</em>. 2016;14:10. <a href="https://doi.org/10.1186/s12916-016-0553-2" target="_blank" rel="noopener noreferrer">doi:10.1186/s12916-016-0553-2</a>.</li>
  <li>Downing NS, Shah ND, Aminawung JA, Pease AM, Zeitoun J-D, Krumholz HM, Ross JS. Postmarket safety events among novel therapeutics approved by the US Food and Drug Administration between 2001 and 2010. <em>JAMA</em>. 2017;317(18):1854–1863. <a href="https://doi.org/10.1001/jama.2017.5150" target="_blank" rel="noopener noreferrer">doi:10.1001/jama.2017.5150</a>.</li>
  <li>Bresalier RS, Sandler RS, Quan H, et al.; Adenomatous Polyp Prevention on Vioxx (APPROVe) Trial Investigators. Cardiovascular events associated with rofecoxib in a colorectal adenoma chemoprevention trial. <em>New England Journal of Medicine</em>. 2005;352(11):1092–1102. <a href="https://doi.org/10.1056/NEJMoa050493" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa050493</a>.</li>
  <li>James WPT, Caterson ID, Coutinho W, et al.; SCOUT Investigators. Effect of sibutramine on cardiovascular outcomes in overweight and obese subjects. <em>New England Journal of Medicine</em>. 2010;363(10):905–917. <a href="https://doi.org/10.1056/NEJMoa1003114" target="_blank" rel="noopener noreferrer">doi:10.1056/NEJMoa1003114</a>.</li>
  <li>Graham DJ, Campen D, Hui R, et al. Risk of acute myocardial infarction and sudden cardiac death in patients treated with cyclo-oxygenase 2 selective and non-selective non-steroidal anti-inflammatory drugs: nested case-control study. <em>Lancet</em>. 2005;365(9458):475–481.</li>
  <li>Connolly HM, Crary JL, McGoon MD, et al. Valvular heart disease associated with fenfluramine-phentermine. <em>New England Journal of Medicine</em>. 1997;337(9):581–588.</li>
  <li>Wysowski DK, Bacsanyi J. Cisapride and fatal arrhythmia. <em>New England Journal of Medicine</em>. 1996;335(4):290–291.</li>
  <li>Furberg CD, Pitt B. Withdrawal of cerivastatin from the world market. <em>Current Controlled Trials in Cardiovascular Medicine</em>. 2001;2(5):205–207.</li>
  <li>Graham DJ, Green L, Senior JR, Nourjah P. Troglitazone-induced liver failure: a case study. <em>American Journal of Medicine</em>. 2003;114(4):299–306.</li>
  <li>Van Assche G, Van Ranst M, Sciot R, et al. Progressive multifocal leukoencephalopathy after natalizumab therapy for Crohn's disease. <em>New England Journal of Medicine</em>. 2005;353(4):362–368.</li>
  <li>U.S. Food and Drug Administration. FDA requests removal of all ranitidine products (Zantac) from the market [tlačová správa]. 1. apríl 2020.</li>
  <li>European Medicines Agency. Guideline on good pharmacovigilance practices (GVP). EMA, Amsterdam.</li>
  <li>Wikipedia contributors. List of withdrawn drugs. Wikipedia, The Free Encyclopedia.</li>
</ol>

<hr>

<p><em><strong>Poznámka:</strong> Tento prehľadový článok má vzdelávací charakter a nenahrádza odborné farmakovigilančné ani klinické rozhodovanie. Spracovaný na základe verejne dostupných regulačných dokumentov (FDA, EMA) a citovanej odbornej literatúry.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie po úprave obsahu prepíše existujúci článok (regenerácia).
// Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

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
