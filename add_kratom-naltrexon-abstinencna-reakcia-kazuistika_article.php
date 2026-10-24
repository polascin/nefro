<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Ťažká abstinenčná reakcia po naltrexóne u užívateľa kratomu: kazuistika a jej poučenie',
    'slug' => 'kratom-naltrexon-abstinencna-reakcia-kazuistika',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Hodinu po prvej dávke naltrexónu nasledovala intubácia a dvanásť dní hospitalizácie. Kratom sa zistil až z rozhovoru s rodinou; toxikologické vyšetrenie ho nezachytí.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/kratom-naltrexon-abstinencna-reakcia-kazuistika.webp" type="image/webp">
    <img src="img/kratom-naltrexon-abstinencna-reakcia-kazuistika.png" alt="Polopriesvitna receptorova struktura v tme, z ktorej je prudko vyrazena organicka svietiaca forma, pricom sa z miesta siri razova vlna" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna vytesnenia agonistu z opioidného receptora antagonistom. Nejde o zobrazenie reálnej molekulárnej štruktúry ani o snímku konkrétneho pacienta.</figcaption>
</figure>

<p>Naltrexón je kompetitívny antagonista opioidných receptorov a pri liečbe závislosti od alkoholu patrí k štandardným možnostiam. Jeho bezpečné začatie má jednu dobre známu podmienku: pred podaním sa vyžaduje <strong>obdobie 7 až 10 dní bez opioidov</strong>, inak môže vyvolať nebezpečnú precipitovanú abstinenciu.</p>

<p>Kazuistika uverejnená 21. októbra 2026 v časopise <em>Federal Practitioner</em> opisuje, čo sa stane, keď je opioidnou aktivitou niečo, čo za opioid nikto nepovažuje. Informácie o lieku kratom ako výstrahu neuvádzajú a bežné toxikologické vyšetrenie moču ho nezachytí.</p>

<h2>Kratom v skratke</h2>

<p>Kratom (<em>Mitragyna speciosa</em>) je v Spojených štátoch neregulovaná, v niektorých štátoch nezákonná rastlinná látka so stimulačným a analgetickým účinkom. Obsahuje viac než 40 alkaloidov; mitragynín a 7-hydroxymitragynín majú od dávky závislú afinitu k μ aj κ opioidným receptorom.</p>

<p>Dávkovo závislý je aj celý obraz. Pri nižších dávkach prevažuje stimulačný účinok, pravdepodobne cez serotonergné a adrenergné receptory; vyššie dávky vyvolávajú uvoľnenie dopamínu po aktivácii μ receptora a pocit eufórie. Na rozdiel od opioidov kratom nevyvoláva rutinne útlm dýchania, čo je jeden z dôvodov, prečo sa vníma ako neškodný.</p>

<p>Závislosť sa však vyvíja. V populačnej štúdii malo problémy so závislosťou až 55 % používateľov, pričom 65 % malo mierne a 35 % stredne ťažké až ťažké abstinenčné príznaky. Patria k nim nepokoj, nekľud, tremor, hnačka, potenie, zívanie, výtok z nosa a baženie.</p>

<p>Epidemiologicky nejde o okrajový jav. V prierezovom prieskume v rámci National Survey on Drug Use and Health užilo kratom za uplynulý rok odhadom 0,7 % populácie, ale medzi ľuďmi s poruchou užívania opioidov to bolo 10,4 %. Medzi rokmi 2011 a 2017 bolo americkým toxikologickým centrám hlásených 1 807 expozícií kratomu; 31,8 % viedlo k hospitalizácii a zaznamenaných bolo 11 úmrtí.</p>

<h2>Prípad</h2>

<p>Šesťdesiatštyriročný muž s hmotnosťou 65 kg bol zaradený do multidisciplinárneho programu pre ukončenie užívania alkoholu. Uvádzal pitie počas posledných štyroch rokov, naposledy približne 8 uncí liehu denne, ráno a večer. V anamnéze mal veľkú depresívnu poruchu, artériovú hypertenziu a chronickú bolesť chrbta, pre ktorú v minulosti užíval opioidy; posledných desať rokov podľa svojich slov nie. Chronicky užíval metoprolol, famotidín, tamsulozín, mirtazapín, lizinopril a kyselinu listovú.</p>

<p>Pri vstupnom vyšetrení bol <strong>eutýmny</strong>, spolupracujúci, orientovaný osobou, miestom, časom aj situáciou, s logickým a cieleným myslením. Toxikologické vyšetrenie moču bolo negatívne na fencyklidín, benzodiazepíny, kokaín, amfetamíny, kanabinoidy, opiáty, barbituráty a metadón. Dostal predpis na naltrexón 25 mg denne a kontrolu o týždeň.</p>

<p>Prvú dávku užil večer. <strong>Do jednej hodiny</strong> sa stal mimoriadne nepokojným a povedal: „Niečo nie je v poriadku, zavolajte záchranku.“ Spočiatku bol pri ťažkej úzkosti ešte spolupracujúci a sám si nastúpil do sanitky. Počas prevozu sa nepokoj zhoršil a dostal diazepam intravenózne.</p>

<p>Na urgentnom príjme mal tachykardiu 118/min, tachypnoe 22/min a tlak 189/121 mm Hg. Bol orientovaný miestom a osobou, nie však situáciou. V diferenciálnej diagnostike boli zvažované pečeňová encefalopatia, odvykací stav pri alkohole, akútna intoxikácia a nežiaduci účinok lieku.</p>

<p>Počas nasledujúcich hodín sa stal spoteným, nespolupracujúcim a agresívnym a vytrhol si intravenózne kanyly. Pre nepokoj <strong>refraktérny na benzodiazepíny</strong> bol intubovaný na zaistenie dýchacích ciest.</p>

<p>Opakované toxikologické vyšetrenie moču bolo negatívne, hladina alkoholu v sére 147 mg/dl, amoniak 56 µmol/l, vyšetrenie moču bez odchýlok a počítačová tomografia hlavy bez prínosu. Z laboratórnych nálezov bola odchýlkou len mierna transaminitída.</p>

<p>Až pri ďalšom rozhovore s rodinou vyšlo najavo, že pacient desať rokov pravidelne užíval kratom v prášku, jednu čajovú lyžičku trikrát denne rozmiešanú v horúcej vode, teda približne <strong>6,0 až 7,5 g denne</strong>. Manželka vysvetlila, že s kratomom začal, aby zvládol abstinenčné príznaky po opioidoch.</p>

<p>Pacient bol prijatý na jednotku intenzívnej starostlivosti s minimálnymi parametrami ventilácie a liečený podľa protokolu pre odvykací stav pri alkohole vrátane parenterálneho tiamínu. Dostával benzodiazepíny a titrovateľné infúzie opioidov, propofolu a dexmedetomidínu. Pre horúčku 38,8 °C dostal empirické antibiotiká, zdroj infekcie sa však nezistil (hemokultúry aj vírusový panel negatívne). Na druhý deň sa objavili vodnaté stolice. Extubovaný bol na siedmy deň, pre následnú slabosť potreboval rehabilitáciu a na dvanásty deň bol prepustený do intenzívneho ambulantného programu.</p>

<h2>Prečo je príčinná súvislosť pravdepodobná</h2>

<p>Autori uvádzajú ako najpravdepodobnejšiu diagnózu akútnu abstinenčnú reakciu na kratom vyvolanú naltrexónom. Podporujú ju:</p>

<ul>
  <li>časová väzba do jednej hodiny od prvej dávky,</li>
  <li>desaťročné pravidelné užívanie kratomu v dávke nad prahom rizika,</li>
  <li>negatívne toxikologické vyšetrenie moču pri dvoch odberoch,</li>
  <li>žiadne nové serotonergné lieky a žiadny zistený zdroj infekcie,</li>
  <li>prítomnosť alkoholu v sére pri obraze, ktorý zodpovedal skôr odvykaciemu stavu než intoxikácii, a <strong>refraktérnosť počiatočných príznakov voči benzodiazepínom</strong>, čo svedčí proti čistému odvykaciemu stavu pri alkohole,</li>
  <li>absencia predchádzajúcej hospitalizácie pre látkové alebo psychiatrické ochorenie a podľa manželky žiadna predchádzajúca psychotická epizóda.</li>
</ul>

<p>Skóre podľa Naranja bolo <strong>5</strong>, čo zodpovedá kategórii pravdepodobnej príčinnej súvislosti. Nasledujúci odvykací stav pri alkohole a potreba sedácie predĺžili čas na ventilátore.</p>

<h2>Prečo sa to prehliadne</h2>

<p>Podľa autorov sú v literatúre známe len <strong>tri</strong> prípady abstinenčných príznakov po prvej dávke naltrexónu u používateľov kratomu. Predchádzajúce prípady opisovali mierne príznaky; tento opisuje potenciálne ťažký následok s predĺženou hospitalizáciou.</p>

<p>Spoločným znakom všetkých hlásených prípadov je náhly nástup abstinenčných príznakov do jednej hodiny od podania naltrexónu, negatívne toxikologické vyšetrenie moču a návšteva urgentného príjmu. V troch zo známych prípadov sa užívanie kratomu zistilo až po začatí ťažkostí.</p>

<p>Dôvodov, prečo sa to prehliadne, je niekoľko a všetky sú odstrániteľné:</p>

<ul>
  <li><strong>Pacient o kratome sám nepovie.</strong> Buď pre stigmu, alebo pre presvedčenie, že ide o bezpečnú a nepodstatnú bylinnú látku, čo podľa autorov do veľkej miery formuje marketing.</li>
  <li><strong>Bežné toxikologické vyšetrenia kratom nezachytia.</strong> Testy na mitragynín v moči existujú, ale v zdravotníckych zariadeniach nemusia byť dostupné.</li>
  <li><strong>Informácie o lieku neobsahujú výstrahu.</strong> Kratom nie je v informáciách o naltrexóne uvedený ako upozornenie ani opatrenie a liekové databázy túto kombináciu neuvádzajú ako interakciu kategórie X, ako by to urobili pri opioidoch.</li>
</ul>

<p>Rizikovými faktormi abstinenčnej reakcie sú vyššie dávky, orientačne od 6 g denne, a dlhodobé užívanie, hoci údaje z dobrovoľných prieskumov sú veľmi premenlivé a variabilita komerčných výrobkov presné kvantifikovanie sťažuje. Vyššie riziko môžu mať aj osoby s predchádzajúcou závislosťou od opioidov, čo bol presne tento prípad.</p>

<h2>Čo z toho platí v nefrológii</h2>

<p>Kratom nie je typicky nefrologická téma, ale tri prepojenia sú vecné.</p>

<p><strong>Orgánová toxicita.</strong> Pri kratome je opisované poškodenie pečene, čomu zodpovedá aj mierna transaminitída v tomto prípade. Opísaná je aj multiorgánová dysfunkcia: v kazuistike z <em>ACG Case Reports Journal</em> sa u 37-ročnej ženy po dlhodobom užívaní doplnkov s obsahom kratomu rozvinulo zmiešané hepatocelulárne a cholestatické akútne poškodenie pečene, <strong>akútne poškodenie obličiek</strong> a pankolitída. Ide o jednotlivé prípadové práce, takže úroveň dôkazu je zodpovedajúco nízka, ale pri nevysvetlenom akútnom poškodení obličiek s hepatálnym nálezom u užívateľa rastlinných doplnkov je to hypotéza, ktorú sa oplatí položiť.</p>

<p><strong>Bolesť pri dialýze.</strong> Chronická bolesť je u dialyzovaných pacientov vysoko prevalentná a možnosti analgézie sú obmedzené: nesteroidové antiflogistiká sú problematické, opioidy sa pri zníženej eliminácii kumulujú. Prípravok, ktorý sa predáva ako prírodný, voľne dostupný a analgetický, je v takejto situácii nápadne príťažlivý. Je rozumné sa naň priamo opýtať.</p>

<p><strong>Prenosná metodická lekcia.</strong> Najcennejšie na tejto kazuistike nie je samotná látka, ale princíp. Negatívne toxikologické vyšetrenie nevylučuje prítomnosť látky, ktorá sa netestuje. Rovnaká logika platí v nefrológii pri akútnej tubulointersticiálnej nefritíde z nehláseného doplnku výživy, pri nefropatii z nefrotoxickej rastliny alebo pri nevysvetlenej hyperkaliémii u pacienta užívajúceho bylinný prípravok. „Pacient nič neužíva“ znamená, že sa ho nikto nespýtal na to správne.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<ol>
  <li>Pred predpísaním naltrexónu sa cielene opýtať na kratom, vrátane dávky, formy a dĺžky užívania. Všeobecná otázka na „drogy“ ani na „lieky“ nestačí; kratom pacient pod tieto pojmy nezaradí.</li>
  <li>Pri akútnom nepokoji a odvykacom obraze do jednej hodiny po prvej dávke naltrexónu zaradiť kratom do diferenciálnej diagnostiky, najmä pri negatívnom toxikologickom skríningu.</li>
  <li>Nepokoj refraktérny na benzodiazepíny u pacienta, u ktorého sa predpokladá odvykací stav pri alkohole, je dôvodom prehodnotiť diagnózu, nie len zvýšiť dávku.</li>
  <li>Otázky formulovať konkrétne a bez hodnotenia: na rastlinné prípravky, doplnky výživy, „bylinkové“ analgetiká a prípravky kupované cez internet.</li>
  <li>Pri podozrení pokračovať v manažmente podľa závažnosti stavu a miestnych protokolov; v tomto prípade bola potrebná kombinácia podporných a symptomatických postupov vrátane zaistenia dýchacích ciest.</li>
</ol>

<p>Autori uvádzajú ešte jeden dôsledok, ktorý sa pri kazuistikách ľahko prehliadne. Pacient po tejto skúsenosti vyjadril zdráhavosť skúsiť naltrexón znovu. Ťažká precipitovaná abstinencia tak môže nepriaznivo ovplyvniť aj budúce pokusy o liečbu závislosti od alkoholu.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom. Ide o opis jedného prípadu; kazuistika je najnižšou úrovňou klinického dôkazu a nedovoľuje odhadnúť, ako často sa opísaná reakcia vyskytuje. Text nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania a súhrny charakteristických vlastností liekov. Dostupnosť a právny status kratomu sa v jednotlivých krajinách líšia.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Cole Jennifer L., Pittman Leah B., Osborne Jomo C., Osinski Michael N. Severe Kratom Withdrawal Induced by Oral Naltrexone: A Case Report and Call for Increased Awareness. <em>Federal Practitioner.</em> 2026;43(10):390–393. DOI: <a href="https://doi.org/10.12788/fp.0763" target="_blank" rel="noopener noreferrer">10.12788/fp.0763</a>. Veterans Health Care System of the Ozarks, Fayetteville, Arkansas. Autori neuvádzajú konflikt záujmov. <a href="https://www.medscape.com/viewarticle/severe-kratom-withdrawal-induced-oral-naltrexone-case-report-2026a10013aw" target="_blank" rel="noopener noreferrer">Celý text</a>.</em></small></p>

<p><small><em>2. Jarka Christopher, Gregoire Kathryn. Precipitated withdrawal with kratom use following naltrexone administration. <em>Mental Health Clinician.</em> 2023;13(3):155–158. DOI: <a href="https://doi.org/10.9740/mhc.2023.06.155" target="_blank" rel="noopener noreferrer">10.9740/mhc.2023.06.155</a>.</em></small></p>

<p><small><em>3. Jensen Austin, Truong Quyen, Jameson Michael a kolektív. Kratom-induced transaminitis with subsequent precipitated opioid withdrawal following naltrexone. <em>Mental Health Clinician.</em> 2021;11(3):220–224. DOI: <a href="https://doi.org/10.9740/mhc.2021.05.220" target="_blank" rel="noopener noreferrer">10.9740/mhc.2021.05.220</a>.</em></small></p>

<p><small><em>4. Singh Darshan, Müller Christian, Vicknasingam Balasingam. Kratom (Mitragyna speciosa) dependence, withdrawal symptoms and craving in regular users. <em>Drug and Alcohol Dependence.</em> 2014;139:132–137. DOI: <a href="https://doi.org/10.1016/j.drugalcdep.2014.03.017" target="_blank" rel="noopener noreferrer">10.1016/j.drugalcdep.2014.03.017</a>.</em></small></p>

<p><small><em>5. Khan Muhammad Zarrar, Abou Saleh Mohannad, Alkhayyat Motasem, Roberts Daniel E., Lindenmeyer Christina C. Multiorgan Dysfunction Related to Kratom Ingestion. <em>ACG Case Reports Journal.</em> 2021;8(8):e00647. DOI: <a href="https://doi.org/10.14309/crj.0000000000000647" target="_blank" rel="noopener noreferrer">10.14309/crj.0000000000000647</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/34476274/" target="_blank" rel="noopener noreferrer">PubMed PMID 34476274</a>.</em></small></p>

<p><small><em>6. Naranjo Claudio A., Busto Usoa, Sellers Edward M. a kolektív. A method for estimating the probability of adverse drug reactions. <em>Clinical Pharmacology and Therapeutics.</em> 1981;30(2):239–245. DOI: <a href="https://doi.org/10.1038/clpt.1981.154" target="_blank" rel="noopener noreferrer">10.1038/clpt.1981.154</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky klinické údaje prípadu vrátane dávkovania, laboratórnych hodnôt, časovej postupnosti, skóre podľa Naranja a údajov o epidemiológii a závislosti boli overené priamo v plnom texte kazuistiky na verejne prístupnej stránke zdroja, vrátane úplného autorského zoznamu, afiliácie, bibliografických údajov a vyhlásenia o konflikte záujmov. Informovaný súhlas bol podľa autorov získaný od manželky pacienta ako osoby splnomocnenej na zdravotnú starostlivosť. Bibliografické údaje ostatných citovaných prác boli prevzaté zo zoznamu literatúry primárnej kazuistiky; údaje o multiorgánovej dysfunkcii boli samostatne overené v zázname PubMed.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je prepočet dennej dávky kratomu voči uvádzanému prahu rizika 6 g denne, zdôraznenie refraktérnosti voči benzodiazepínom ako diagnostického vodidla, oprava prekladu klinického stavu pri vstupnom vyšetrení (eutýmny, nie eufórický) a nefrologická časť o multiorgánovej toxicite, o analgézii pri dialýze a o prenosnej metodickej lekcii, podľa ktorej negatívne toxikologické vyšetrenie nevylučuje netestovanú látku. Tieto súvislosti nie sú obsiahnuté v primárnej kazuistike.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=konopa-riziko-bipolarnej-poruchy-metaanalyza">Konopa a riziko bipolárnej poruchy</a></li>
  <li><a href="article.php?slug=postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema">Postmarketingové bezpečnostné zlyhania liekov</a></li>
  <li><a href="article.php?slug=biopsia-obliciek-glomerularne-ochorenia">Biopsia obličiek pri glomerulárnych ochoreniach</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_kratom-naltrexon-abstinencna-reakcia-kazuistika_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "────────────────────────────────────────────────────\n\n";
}
?>