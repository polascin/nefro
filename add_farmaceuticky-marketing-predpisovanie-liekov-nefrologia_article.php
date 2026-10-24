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
    'title' => 'Marketing farmaceutických firiem a predpisovanie liekov: čo ukázal Cochranov prehľad',
    'slug' => 'farmaceuticky-marketing-predpisovanie-liekov-nefrologia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Deväťdesiattri štúdií spája dary a platby s menej vhodným a objemnejším predpisovaním. Osemdesiatosem percent z nich je však amerických, a Slovensko má vlastný zákonný register plnení.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/farmaceuticky-marketing-predpisovanie-liekov-nefrologia.webp" type="image/webp">
    <img src="img/farmaceuticky-marketing-predpisovanie-liekov-nefrologia.png" alt="Prazdny receptovy blok v tme, nad nim visi pero zavesene na tenkych zlatistych vlaknach ako na marionetovych nitiach" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Nejde o zobrazenie konkrétnej situácie, osoby ani spoločnosti.</figcaption>
</figure>

<p>Dňa 9. októbra 2026 vyšla v Cochranovej databáze aktualizácia systematického prehľadu o tom, ako informačné a propagačné aktivity farmaceutických spoločností pôsobia na predpisujúcich lekárov. Zahŕňa 93 štúdií a jej záver je jednoznačný: propagačné interakcie s farmaceutickými spoločnosťami sú pravdepodobne spojené s nepriaznivými dôsledkami, teda s menej vhodným predpisovaním, väčším množstvom predpísaných liekov a vyššími nákladmi.</p>

<p>Prehľad má zároveň dve vlastnosti, ktoré sa pri citovaní pravidelne strácajú a bez ktorých sa jeho výsledky vykladajú nesprávne. Po prvé, pre heterogenitu nebolo možné urobiť žiadnu metaanalýzu; ide o naratívnu syntézu. Po druhé, 88 % zaradených štúdií pochádza zo Spojených štátov. Prenos týchto zistení do slovenského prostredia preto vyžaduje osobitnú úvahu, a to tým skôr, že Slovensko má vlastný zákonný register plnení, o ktorom sa hovorí prekvapivo málo.</p>

<h2>Čo prehľad hodnotil</h2>

<p>Autori prehľadávali databázy CENTRAL, MEDLINE, Embase, jednu ďalšiu databázu a dva registre klinických skúšaní do januára 2025. Zaradili randomizované aj nerandomizované štúdie, kontrolované štúdie pred intervenciou a po nej, prerušované časové rady a prierezové, kohortové a prípadovo-kontrolné štúdie, pokiaľ údaje pokrývali celú populáciu alebo náhodnú vzorku definovanej populácie s mierou odpovede najmenej 60 %.</p>

<p>Kritickými výstupmi boli vhodnosť predpisovania, množstvo predpísaných liekov, náklady na predpisovanie a žiadosti o zaradenie lieku do nemocničného zoznamu. Expozície boli rozdelené do štyroch skupín: reklama a vzdelávanie, dary a platby, bezplatné vzorky a politiky riadenia konfliktu záujmov.</p>

<p>Dôveryhodnosť dôkazov hodnotili metodikou GRADE. Znížili ju pre riziko skreslenia a nepresnosť, a zvýšili ju pre <strong>vzťah dávky a odpovede a veľký rozsah účinku</strong>. Ten druhý bod je dôležitý: práve existencia stúpajúceho gradientu medzi mierou expozície a mierou zmeny predpisovania je argument, ktorý samotný pozorovací dizajn posilňuje.</p>

<h2>Zloženie dôkazovej základne</h2>

<p>Z 93 štúdií bolo 82 (88 %) zo Spojených štátov a 11 z Európskej únie alebo Spojeného kráľovstva. Z hľadiska dizajnu bolo 60 prierezových, 23 kontrolovaných kohortových, štyri kontrolované pred intervenciou a po nej, štyri prerušované časové rady, jedna vnorená prípadovo-kontrolná štúdia a <strong>jediná randomizovaná kontrolovaná štúdia</strong>, ktorej oba výstupy boli navyše vyhodnotené ako celkovo vysoko rizikové z hľadiska skreslenia.</p>

<p>Hlavnou metodickou výhradou pri prierezových a kohortových štúdiách bola identifikácia konfundujúcich faktorov. Prehľad teda nie je dôkazom príčinnej súvislosti a jeho autori to formulujú opatrne slovom „pravdepodobne“.</p>

<h2>Výsledky podľa typu expozície</h2>

<div class="table-responsive" role="region" aria-label="Súvislosti medzi typom expozície a predpisovaním podľa Cochranovho prehľadu" tabindex="0">
<table>
  <thead><tr><th scope="col">Expozícia</th><th scope="col">Vhodnosť predpisovania</th><th scope="col">Množstvo</th><th scope="col">Náklady</th></tr></thead>
  <tbody>
    <tr><th scope="row">Dary a platby</th><td>znížená (10 štúdií; 2 941 948 predpisujúcich)</td><td>zvýšené (39 štúdií; 3 858 871)</td><td>pravdepodobne zvýšené (25 štúdií; 2 505 292)</td></tr>
    <tr><th scope="row">Reklama a vzdelávanie</th><td>môže byť znížená (6 štúdií; 1 335)</td><td>pravdepodobne zvýšené (7 štúdií; 151 399)</td><td>môžu byť zvýšené (2 štúdie; 986)</td></tr>
    <tr><th scope="row">Bezplatné vzorky</th><td>veľmi neisté (1 štúdia; 10 praxí)</td><td>veľmi neisté (4 štúdie; 150 050)</td><td>veľmi neisté (4 štúdie; 2 508)</td></tr>
    <tr><th scope="row">Politiky konfliktu záujmov</th><td>pravdepodobne zlepšená (2 štúdie; 3 065)</td><td>môže byť znížené (6 štúdií; 110 470)</td><td>neisté (2 štúdie; 33 975)</td></tr>
  </tbody>
</table>
</div>

<p>Formulácie v tabuľke nie sú štylistická variácia. Zodpovedajú stupňom istoty podľa metodiky GRADE: „je spojené“ znamená vyššiu istotu než „pravdepodobne je spojené“, a to zase vyššiu než „môže byť spojené“ a „veľmi neisté“. Najsilnejší signál je teda pri daroch a platbách, kde je znížená vhodnosť predpisovania a zvýšené množstvo doložené bez zmierňujúceho slova.</p>

<p>Pri žiadostiach o zaradenie lieku do nemocničného zoznamu bolo dôkazov málo, jedna štúdia so 105 predpisujúcimi. Reklama, vzdelávanie, dary a platby môžu byť spojené s vyšším počtom takýchto žiadostí, ale dôkaz je veľmi neistý.</p>

<p>Mimoriadne poučná je skupina bezplatných vzoriek. Práve tá sa v bežnom uvažovaní považuje za najnevinnejšiu formu kontaktu, a práve pri nej je dôkaz najslabší. Jedna štúdia o desiatich praxiach nedokáže povedať nič. Neistota tu však nie je to isté ako dôkaz neškodnosti; znamená, že otázka zostáva otvorená.</p>

<h2>Politiky konfliktu záujmov pôsobia opačným smerom</h2>

<p>Osem štúdií skúmalo inštitucionálne politiky, napríklad obmedzenie návštev obchodných zástupcov alebo zákaz prijímania darov a vzoriek. Tieto obmedzenia sú pravdepodobne spojené s lepšou vhodnosťou predpisovania a môžu byť spojené s nižším množstvom predpísaných liekov; vplyv na náklady zostáva neistý.</p>

<p>Ide o najpraktickejšiu časť celého prehľadu, pretože na rozdiel od expozície je politika pracoviska niečo, čo sa dá rozhodnutím zmeniť. Autori prehľadu neuvádzajú žiadne financovanie.</p>

<h2>Slovenský kontext: register, o ktorom sa málo vie</h2>

<p>Osemdesiatosem percent dôkazov pochádza z amerického prostredia, ktoré sa od slovenského líši podstatne. V Európskej únii je reklama liekov viazaných na lekársky predpis určená širokej verejnosti zakázaná, takže celá vetva priamej spotrebiteľskej reklamy, ktorá americké predpisovanie spoluformuje, tu odpadá.</p>

<p>Zároveň platí, že Slovensko má vlastnú zákonnú obdobu amerického registra platieb, a to už roky. Podľa <strong>§ 15 ods. 1 písm. u) zákona č. 362/2011 Z. z.</strong> o liekoch a zdravotníckych pomôckach je držiteľ povolenia na výrobu liekov povinný predkladať v elektronickej podobe Národnému centru zdravotníckych informácií, a to výslovne „na účely verejnej kontroly poskytovania peňažných alebo nepeňažných plnení“, najneskôr do 31. januára a 31. júla kalendárneho roka správu o výdavkoch na propagáciu, marketing a na peňažné a nepeňažné plnenia za predchádzajúci kalendárny polrok.</p>

<p>Obsah správy je podrobný. Podľa § 15 ods. 8 sa výdavky členia na marketing, propagáciu lieku, peňažné plnenia a nepeňažné plnenia poskytnuté priamo alebo nepriamo zdravotníckemu pracovníkovi alebo poskytovateľovi zdravotnej starostlivosti. Podľa ods. 9 sa pri plneniach uvádza meno, priezvisko a zdravotnícke povolanie pracovníka, názov a adresa zdravotníckeho zariadenia, výška a účel plnenia a pri plnení viazanom na liek aj názov lieku alebo jeho anatomicko-terapeuticko-chemickej skupiny, s členením účelu na klinické skúšanie, neintervenčnú klinickú štúdiu, štúdiu o bezpečnosti po registrácii, prieskum trhu, odborné prednášky, odborné konzultácie, účastnícke a registračné poplatky a dary.</p>

<p>Zákon pamätá aj na nepriame cesty. Podľa ods. 11 a 12 je pri plnení poskytnutom cez tretiu osobu nutné oznámiť aj identifikáciu tejto tretej osoby, a samotná tretia osoba musí držiteľovi povolenia do 30 dní oznámiť zoznam príjemcov.</p>

<p>Podľa § 15 ods. 13 Národné centrum zdravotníckych informácií bezodkladne zverejní oznámené údaje na svojom webovom sídle. Ak zdravotnícky pracovník alebo poskytovateľ zistí, že zverejnené informácie o jeho osobe nie sú presné, úplné alebo pravdivé, môže podať námietku; centrum o nej rozhodne do 30 dní.</p>

<p>Z toho vyplýva praktická možnosť, ktorú väčšina lekárov nevyužíva: <strong>údaje o vlastnej osobe sú verejné a dajú sa skontrolovať</strong>. Nejde o obvinenie ani o vyzvanie k pocitu viny. Ide o to, že dáta, ktoré Cochranov prehľad analyzoval v americkom prostredí, sú u nás k dispozícii na úrovni jednotlivca a dajú sa použiť na vlastnú kontrolu.</p>

<h2>Prečo je téma relevantná práve v nefrológii</h2>

<p>Nefrológia má niekoľko vlastností, pre ktoré je na tento typ vplyvu nadpriemerne citlivá.</p>

<ul>
  <li><strong>Dlhodobé predpisovanie.</strong> Rozhodnutie o lieku pri chronickej chorobe obličiek sa často nerobí na mesiac, ale na roky. Raz zavedená preferencia sa reprodukuje pri každej ďalšej kontrole a pri každom ďalšom pacientovi.</li>
  <li><strong>Viacero blízko rovnocenných možností.</strong> Pri viazačoch fosfátov, látkach stimulujúcich erytropoézu, inhibítoroch HIF-prolylhydroxylázy, kalcimimetikách aj v rámci tried inhibítorov SGLT2 existuje viacero prípravkov s podobným postavením v odporúčaniach. Práve tam, kde odborný podklad nerozhoduje jednoznačne, má propagácia najviac priestoru.</li>
  <li><strong>Vysoká cena.</strong> Viaceré z týchto skupín patria k nákladovo najvýznamnejším v medicíne vôbec, takže aj malý posun v predpisovaní má veľký rozpočtový dosah.</li>
  <li><strong>Rozhodovanie na úrovni protokolu.</strong> V dialyzačnom stredisku sa značná časť liečby neriadi receptom pre jednotlivého pacienta, ale liečebným protokolom alebo zoznamom liekov pracoviska. Výstup „žiadosti o zaradenie lieku do zoznamu“, pre ktorý má Cochranov prehľad najmenej dôkazov, je práve ten, ktorý je v dialýze najvýznamnejší. Vplyv na jedného človeka, ktorý protokol pripravuje, sa prenesie na všetkých pacientov strediska naraz.</li>
</ul>

<p>Treba povedať aj to, čo z prehľadu nevyplýva. Žiadna z 93 štúdií nehodnotila nefrológov osobitne. Tvrdenie, že nefrologické predpisovanie je ovplyvnené v rovnakej miere, by bolo extrapoláciou, nie zistením. Mechanizmus však nie je špecializačne viazaný a nie je dôvod predpokladať, že nefrológovia sú voči nemu odolnejší než ostatní.</p>

<h2>Čo sa s tým dá urobiť na pracovisku</h2>

<p>Najlepšie podloženou intervenciou je politika pracoviska, nie individuálne predsavzatie. Zmyslom nie je nulový kontakt s priemyslom za každú cenu, ale aby kontakt neformoval liečebné rozhodnutia tam, kde na to nemá odborný podklad.</p>

<ol>
  <li>Mať písomné pravidlá pre návštevy obchodných zástupcov, pre prijímanie darov a pohostenia a pre účasť na podujatiach financovaných výrobcom.</li>
  <li>Pri tvorbe liečebných protokolov a zoznamov liekov vyžadovať deklaráciu konfliktu záujmov od každého, kto sa na nich podieľa, a zdokumentovať ju.</li>
  <li>Pri zaraďovaní nového lieku vychádzať z odporúčaní a systematických prehľadov, nie z materiálov získaných v propagačnom kontexte; informácie z takého kontextu overiť v nezávislom zdroji.</li>
  <li>Raz za čas si pozrieť vlastný záznam vo verejných údajoch zverejnených Národným centrom zdravotníckych informácií a overiť, či zodpovedá skutočnosti. Prípadnú nepresnosť rieši námietka podľa § 15 ods. 13.</li>
  <li>Pri odbornom vzdelávaní rozlišovať, kto podujatie financuje a kto určuje jeho odborný program. Financovanie samo osebe nie je diskvalifikujúce; nepriznané financovanie a vplyv na obsah sú.</li>
</ol>

<h2>Záver</h2>

<p>Najsilnejší signál z 93 štúdií sa týka darov a platieb: sú spojené s menej vhodným predpisovaním a s väčším množstvom predpísaných liekov a pravdepodobne aj s vyššími nákladmi. Inštitucionálne politiky, ktoré tieto interakcie obmedzujú, pôsobia opačne.</p>

<p>Dôkaz je pozorovací, prevažne americký a bez metaanalýzy. Zároveň je konzistentný naprieč desiatkami štúdií a miliónmi predpisujúcich a vykazuje vzťah dávky a odpovede. To je typ dôkazovej štruktúry, pri ktorej je rozumné konať preventívne a neodkladať opatrenia do času, keď bude k dispozícii dôkaz, ktorý z etických dôvodov pravdepodobne nikdy nevznikne.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom a informovaným čitateľom. Neobsahuje tvrdenia o konkrétnych osobách, pracoviskách ani spoločnostiach. Uvedené zákonné ustanovenia boli overené v znení účinnom v čase publikovania; pred praktickým použitím overte aktuálne znenie na portáli Slov-Lex. Text nie je právnym stanoviskom.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Mintzes Barbara, Lexchin Joel, Grundy Quinn, Fabbri Alice, Spurling Geoffrey K. P., Qureshi Riaz, Bero Lisa. Pharmaceutical industry information and promotional strategies aimed at prescribers. <em>Cochrane Database of Systematic Reviews.</em> 2026;10(10):CD013423. DOI: <a href="https://doi.org/10.1002/14651858.CD013423.pub3" target="_blank" rel="noopener noreferrer">10.1002/14651858.CD013423.pub3</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42849912/" target="_blank" rel="noopener noreferrer">PubMed PMID 42849912</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13649351/" target="_blank" rel="noopener noreferrer">PMC13649351</a>, voľný plný text.</em></small></p>

<p><small><em>2. Zákon č. 362/2011 Z. z. o liekoch a zdravotníckych pomôckach a o zmene a doplnení niektorých zákonov v znení neskorších predpisov, § 15 ods. 1 písm. u) a ods. 8, 9, 11, 12 a 13. <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2011/362/" target="_blank" rel="noopener noreferrer">Slov-Lex</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky počty štúdií a predpisujúcich, formulácie stupňov istoty podľa metodiky GRADE, zloženie dôkazovej základne podľa krajín a dizajnov a údaj o chýbajúcej metaanalýze pochádzajú zo štruktúrovaného abstraktu primárneho prehľadu v PubMed, nie zo sekundárnych prevzatí. Autorský zoznam, ročník, číslo a DOI boli nezávisle overené v databáze Crossref a v PubMed. Znenie § 15 zákona č. 362/2011 Z. z. bolo overené doslovne v konsolidovanom znení stiahnutom z portálu Slov-Lex; citované sú odseky 1 písm. u), 8, 9, 11, 12 a 13.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je upozornenie na to, že prehľad neobsahuje žiadnu metaanalýzu a že 88 % jeho dôkazovej základne je americkej, zachovanie presných stupňov istoty GRADE namiesto ich zjednotenia, doplnenie slovenskej zákonnej úpravy verejného registra plnení vrátane práva na námietku, a rozbor dôvodov, pre ktoré je nefrológia na tento typ vplyvu nadpriemerne citlivá, najmä cez rozhodovanie na úrovni liečebného protokolu v dialyzačnom stredisku. Tieto súvislosti nie sú obsiahnuté v primárnom prehľade.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema">Postmarketingové bezpečnostné zlyhania liekov</a></li>
  <li><a href="article.php?slug=sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky">Inhibítory SGLT2: rozdiely v schválených indikáciách</a></li>
  <li><a href="article.php?slug=zelezo-anemia-ckd-kdigo-2026-erbp">Železo a anémia pri chronickej chorobe obličiek</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_farmaceuticky-marketing-predpisovanie-liekov-nefrologia_article',
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