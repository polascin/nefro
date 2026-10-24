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
    'title' => 'Konopa a riziko bipolárnej poruchy: čo metaanalýza ukázala a čo sa z nej prebralo nesprávne',
    'slug' => 'konopa-riziko-bipolarnej-poruchy-metaanalyza',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Relatívne riziko 2,46 sa šírilo spolu s číslom sedem miliónov účastníkov. Hlavný odhad však stojí na ôsmich štúdiách a pri sledovaní nad tri roky prestáva byť významný.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/konopa-riziko-bipolarnej-poruchy-metaanalyza.webp" type="image/webp">
    <img src="img/konopa-riziko-bipolarnej-poruchy-metaanalyza.png" alt="Polopriesvitna hlava z profilu v tme, v mozgu krivka svetla prechadza z vysokych magentovych vrcholov do chladnej modrej roviny, zdola stupa stuzka dymu" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Nejde o zobrazenie reálneho vyšetrenia ani o snímku konkrétneho pacienta.</figcaption>
</figure>

<p>Metaanalýza uverejnená 6. októbra 2026 v časopise <em>Journal of Affective Disorders</em> uvádza, že užívanie konopy je spojené s viac než dvojnásobným rizikom neskoršieho vzniku bipolárnej poruchy. Titulok sa šíril rýchlo a číslo je skutočne pôsobivé: relatívne riziko 2,46.</p>

<p>Pri bližšom pohľade sa však ukazuje, že jedno číslo z tejto práce prebrali takmer všetky prevzatia nesprávne, a že samotní autori uvádzajú dve zistenia, ktoré výklad menia od základu. Prvé: po vylúčení niekoľkých jednotlivých štúdií prestávajú byť výsledky významné. Druhé: pri sledovaní dlhšom než tri roky asociácia pri bipolárnej poruche prestáva byť významná úplne.</p>

<h2>Čo autori urobili</h2>

<p>Ide o systematický prehľad a metaanalýzu registrovanú na platforme OSF a vypracovanú podľa odporúčaní PRISMA a MOOSE. Prehľadávané boli databázy PubMed a Web of Science od ich vzniku do októbra 2025. Zaradené boli longitudinálne pozorovacie štúdie porovnávajúce osoby exponované konope a neexponované, bez predchádzajúcej bipolárnej poruchy, a hodnotiace neskoršie výstupy bipolárneho spektra.</p>

<p>Zaradených bolo <strong>19 štúdií z 11 krajín</strong> s celkovým počtom 6 960 517 účastníkov, z toho 67 992 užívateľov konopy. Priemerný vek na začiatku sledovania bol 23,8 roka. Expozícia bola definovaná rôzne: akékoľvek užívanie, celoživotné užívanie, časté užívanie alebo porucha užívania konopy. Metodickú kvalitu autori hodnotili Newcastleskou a ottawskou škálou so skóre 6 až 9, čo zodpovedá dobrej až vysokej kvalite.</p>

<h2>Číslo, ktoré sa prebralo nesprávne</h2>

<p>Takmer všetky prevzatia uvádzajú sedem miliónov účastníkov v tesnej blízkosti relatívneho rizika 2,46, čím vzniká dojem, že odhad stojí na populácii tejto veľkosti. Nestojí.</p>

<p>Číslo 6 960 517 je súčet účastníkov <em>všetkých 19 zaradených štúdií</em>. Do samotných metaanalýz vstúpilo 13 z nich a boli rozdelené do dvoch samostatných výpočtov:</p>

<div class="table-responsive" role="region" aria-label="Zlúčené odhady a ich skutočná dôkazová základňa" tabindex="0">
<table>
  <thead><tr><th scope="col">Výstup</th><th scope="col">Relatívne riziko</th><th scope="col">95 % interval spoľahlivosti</th><th scope="col">Počet štúdií</th><th scope="col">Počet účastníkov</th></tr></thead>
  <tbody>
    <tr><th scope="row">Incidentná bipolárna porucha</th><td>2,46</td><td>1,57–3,84</td><td>8</td><td>206 572</td></tr>
    <tr><th scope="row">Incidentné manické alebo hypomanické príznaky</th><td>2,11</td><td>1,07–4,18</td><td>6</td><td>57 243</td></tr>
  </tbody>
</table>
</div>

<p>Skutočná dôkazová základňa pre hlavný výsledok je teda <strong>206 572 účastníkov v ôsmich štúdiách</strong>, nie sedem miliónov. Rozdiel je viac než tridsaťnásobný. Jedna štúdia prispela do oboch analýz.</p>

<p>Dôležitý je aj interval spoľahlivosti pri manických a hypomanických príznakoch: dolná hranica 1,07 je tesne nad hodnotou 1,0. Formulácia „takmer dvojnásobné riziko“ je pri takomto intervale nepresná; zlučiteľný je aj sotva badateľný účinok.</p>

<h2>Odhady sú neupravené</h2>

<p>Autori výslovne uvádzajú, že počítali <strong>neupravené</strong> relatívne riziká metódou Mantela a Haenszela v modeli náhodných efektov. Odhady teda nie sú upravené na konfundujúce faktory, ako sú fajčenie tabaku a užívanie alkoholu.</p>

<p>V tejto oblasti to nie je okrajová výhrada. Užívanie konopy sa silne zhlukuje s fajčením, alkoholom, ďalšími látkami, nižším socioekonomickým postavením a nepriaznivými udalosťami v detstve, pričom každý z týchto faktorov je nezávisle spojený s bipolárnym spektrom. Neupravené relatívne riziko 2,46 preto nemožno čítať ako odhad účinku konopy, ale ako odhad rozdielu medzi dvoma skupinami, ktoré sa líšia vo viacerých veciach naraz.</p>

<h2>Dve zistenia, ktoré rozhodujú o výklade</h2>

<p><strong>Krehkosť voči vynechaniu jednotlivých štúdií.</strong> Autori uvádzajú, že po vylúčení niekoľkých jednotlivých štúdií výsledky neboli významné. Pri ôsmich štúdiách v hlavnej analýze to znamená, že celý záver stojí na niekoľkých konkrétnych prácach. Heterogenita bola pri obidvoch výstupoch podstatná až vysoká.</p>

<p><strong>Závislosť od dĺžky sledovania.</strong> V exploratívnej analýze mali štúdie so sledovaním do troch rokov vrátane podstatne silnejšiu asociáciu (RR 3,34; 95 % IS 2,03–5,50) než štúdie so sledovaním dlhším než tri roky (RR 1,50; 95 % IS 0,95–2,37). Rozdiel medzi podskupinami bol významný (p = 0,0206).</p>

<p>Pri dlhšom sledovaní teda interval spoľahlivosti prekročil hodnotu 1,0 a asociácia prestala byť významná. Toto je presne opačný vzorec, než aký by sa očakával pri príčinnom pôsobení. Ak by konopa bipolárnu poruchu vyvolávala u predisponovaných osôb, dlhšie sledovanie by zachytilo <em>viac</em> prípadov a asociácia by sa upevnila, nie rozpustila.</p>

<p>Vzorec, pri ktorom je asociácia najsilnejšia tesne po expozícii a s odstupom mizne, je typický pre obrátenú príčinnosť. Hypománia má prodróm, ktorý sa prejavuje zvýšenou impulzivitou, vyhľadávaním nových podnetov a zníženou potrebou spánku; práve tieto črty zvyšujú pravdepodobnosť, že človek začne užívať konopu. Ak sa diagnóza stanoví krátko nato, expozícia sa v údajoch javí ako príčina, hoci bola skôr prvým prejavom.</p>

<p>Tento výklad podporuje aj metaregresia: novší rok publikovania bol spojený s <strong>menšími</strong> odhadmi účinku (p = 0,0242). Zmenšovanie efektu s pribúdajúcimi a metodicky lepšími štúdiami je známy jav, ktorý býva skôr prejavom skreslenia v starších prácach než skutočnej zmeny javu.</p>

<h2>Ďalšie obmedzenia, ktoré autori uvádzajú</h2>

<ul>
  <li>Pozorovací dizajn vylučuje príčinný záver.</li>
  <li>Vysoká heterogenita pravdepodobne odráža rozdielne východiskové riziko, rôznu dĺžku sledovania a nejednotné definície expozície aj výstupov.</li>
  <li>Užívanie konopy bolo často hodnotené sebahlásením, bez údajov o veku začiatku, frekvencii a účinnosti prípravku. Práve účinnosť je pritom pri konope rozhodujúca: obsah tetrahydrokanabinolu v dostupných produktoch sa za posledné dekády podstatne zvýšil, takže „užívanie konopy“ v štúdii z deväťdesiatych rokov a v štúdii z roku 2020 nie je tá istá expozícia.</li>
  <li>Sekundárne analýzy boli nedostatočne silné.</li>
</ul>

<p>Štúdia nemala osobitné financovanie. Viacerí autori uvádzajú honoráre alebo granty od farmaceutických spoločností nesúvisiace s touto prácou.</p>

<h2>Čo z toho platí pre prax</h2>

<p>Napriek všetkým výhradám zostáva praktický záver autorov primeraný a stojí za zopakovanie: užívanie konopy patrí do anamnézy u mladého človeka s rozvíjajúcimi sa afektívnymi príznakmi. Nie preto, že by bolo dokázané, že poruchu spôsobuje, ale preto, že je to modifikovateľný faktor, ktorý priebeh ochorenia nepochybne ovplyvňuje, a pretože jeho zistenie mení diferenciálnu diagnostiku.</p>

<p>Čo z práce nevyplýva: že konopa bipolárnu poruchu spôsobuje, že riziko je v absolútnych číslach vysoké (pri celoživotnej prevalencii okolo 2 % by aj zdvojnásobenie relatívneho rizika znamenalo nárast absolútneho rizika rádovo o jednotky percent) a že výsledok platí rovnako pre príležitostné užitie a pre poruchu užívania konopy. Podskupinová analýza podľa definície expozície pritom významný rozdiel medzi poruchou užívania a ostatnými definíciami nezistila, čo je samo osebe prekvapivé a skôr proti jednoduchému vzťahu dávky a odpovede.</p>

<h2>Prečo téma patrí aj do nefrologickej ambulancie</h2>

<p>Súvislosť konopy s obličkami je na rozdiel od psychiatrickej časti konkrétna a v nefrologickej praxi priamo použiteľná.</p>

<p><strong>Kanabidiol a inhibítory kalcineurínu.</strong> Toto je najdôležitejší bod pre každého, kto sleduje pacientov po transplantácii obličky. Kanabidiol sa metabolizuje cez CYP3A4 a CYP2C19 a zároveň je silným inhibítorom týchto dráh. V publikovanom prípade z <em>American Journal of Transplantation</em> došlo u účastníka klinického skúšania kanabidiolu pri epilepsii, ktorý súčasne užíval takrolimus, k približne <strong>trojnásobnému vzostupu koncentrácie takrolimu normalizovanej na dávku</strong> pri dávke kanabidiolu 2 000 až 2 900 mg denne. Autori označili tento nález za významný problém pre transplantačnú komunitu v čase postupnej legalizácie konopy a dostupnosti registrovaného kanabidiolového prípravku.</p>

<p>Dávky použité v tom prípade boli antiepileptické, teda podstatne vyššie než v bežne dostupných voľnopredajných výrobkoch. Smer interakcie je však jednoznačný a pacient po transplantácii, ktorý začne užívať kanabidiol, patrí medzi tých, u ktorých treba koncentráciu takrolimu skontrolovať skôr, a nie až pri najbližšej plánovanej kontrole.</p>

<p><strong>Kanabinoidný hyperemetický syndróm.</strong> Pri dlhodobom užívaní konopy sa môže vyvinúť syndróm cyklického zvracania, ktorý nereaguje na bežné antiemetiká a ustupuje po horúcej sprche a po vysadení konopy. Opakované zvracanie vedie k dehydratácii a hypovolémii, a tým k prerenálnemu akútnemu poškodeniu obličiek; v literatúre je opísaný prípadovými prácami. V diferenciálnej diagnostike nevysvetleného zvracania s akútnym poškodením obličiek u mladého pacienta ho treba zvážiť, pretože sa inak ľahko prehliadne.</p>

<p><strong>Adherencia a hodnotenie príznakov.</strong> U dialyzovaných pacientov a u pacientov s pokročilou chronickou chorobou obličiek je prevalencia psychiatrickej komorbidity a porúch spánku vysoká. Užívanie psychoaktívnych látok v tomto prostredí komplikuje hodnotenie príznakov, spoluprácu pri liečbe a posudzovanie spôsobilosti na zaradenie do čakacej listiny. Skríning užívania látok tu preto nie je moralizovaním, ale súčasťou klinického hodnotenia.</p>

<h2>Záver</h2>

<p>Metaanalýza ukazuje asociáciu medzi užívaním konopy a neskorším výskytom výstupov bipolárneho spektra. Zároveň však ide o neupravené odhady z ôsmich a šiestich štúdií, krehké voči vynechaniu jednotlivých prác, s vysokou heterogenitou a so vzorcom, ktorý sa s predlžovaním sledovania vytráca.</p>

<p>Primeraný záver je preto opatrný: zisťovať užívanie konopy u mladých ľudí s rozvíjajúcimi sa afektívnymi príznakmi má zmysel, ale prezentovať toto zistenie pacientovi ako „konopa zdvojnásobuje riziko bipolárnej poruchy“ by presiahlo to, čo údaje unesú. V nefrologickej praxi je konkrétnejšia a praktickejšia iná časť témy: interakcia kanabidiolu s inhibítormi kalcineurínu a prerenálne poškodenie obličiek pri kanabinoidnom hyperemetickom syndróme.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom a informovaným čitateľom. Nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania. Citované relatívne riziká pochádzajú z pozorovacích štúdií, sú neupravené na konfundujúce faktory a nevyjadrujú príčinný účinok. Pri podozrení na afektívnu poruchu je namieste psychiatrické vyšetrenie.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Sanjuan-Ortiz Cecilia, Querol Paula, Aymerich Claudia, Laherran Nuria, Ditlevsen Fanny, Navalón Pablo, Rojo-Bofill Luis M., Young Allan H., Arango Celso, Sharma Aditya, Di Forti Marta, Murray Robin M., Correll Christoph U., Salazar de Pablo Gonzalo. Cannabis use and subsequent onset of manic symptoms and bipolar disorder: A systematic review and meta-analysis. <em>Journal of Affective Disorders.</em> 2026;416:122588. DOI: <a href="https://doi.org/10.1016/j.jad.2026.122588" target="_blank" rel="noopener noreferrer">10.1016/j.jad.2026.122588</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42838231/" target="_blank" rel="noopener noreferrer">PubMed PMID 42838231</a>.</em></small></p>

<p><small><em>2. Leino Abbie D., Emoto Chie, Fukuda Tsuyoshi, Privitera Michael, Vinks Alexander A., Alloway Rita R. Evidence of a clinically significant drug-drug interaction between cannabidiol and tacrolimus. <em>American Journal of Transplantation.</em> 2019;19(10):2944–2948. DOI: <a href="https://doi.org/10.1111/ajt.15398" target="_blank" rel="noopener noreferrer">10.1111/ajt.15398</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31012522/" target="_blank" rel="noopener noreferrer">PubMed PMID 31012522</a>.</em></small></p>

<p><small><em>3. Bellamy Shannay E., Loor Brian, Gutierrez-Castillo Maria. A Case of Cannabinoid Hyperemesis Syndrome and Acute Kidney Injury: A Review of the Literature. <em>Cureus.</em> 2023;15(1):e34350. DOI: <a href="https://doi.org/10.7759/cureus.34350" target="_blank" rel="noopener noreferrer">10.7759/cureus.34350</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36865973/" target="_blank" rel="noopener noreferrer">PubMed PMID 36865973</a>. Prípadová práca; úroveň dôkazu je zodpovedajúco nízka.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Relatívne riziká, intervaly spoľahlivosti, počty štúdií a účastníkov v jednotlivých metaanalýzach, výsledky podskupinovej analýzy podľa dĺžky sledovania, výsledok metaregresie podľa roku publikovania, poznámka o strate významnosti po vylúčení jednotlivých štúdií a všetky uvádzané obmedzenia boli overené v štruktúrovanom abstrakte primárnej práce v PubMed a v zhrnutí zdrojovej správy. Úplný autorský zoznam všetkých štrnástich autorov, ročník, číslo článku a DOI boli overené v zázname PubMed.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je upozornenie na to, že počet 6 960 517 účastníkov sa vzťahuje na všetkých 19 zaradených štúdií, zatiaľ čo hlavný zlúčený odhad stojí na ôsmich štúdiách s 206 572 účastníkmi, výklad vzorca závislosti asociácie od dĺžky sledovania ako prejavu obrátenej príčinnosti, zaradenie nárastu obsahu tetrahydrokanabinolu v čase medzi obmedzenia definície expozície, prepočet relatívneho rizika na absolútne pri známej prevalencii, a nefrologická časť o interakcii kanabidiolu s takrolimom a o prerenálnom poškodení obličiek. Tieto súvislosti nie sú obsiahnuté v primárnej práci ani vo východiskovej správe.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=rem-spanok-riziko-83-ochoreni-uk-biobank">REM spánok a riziko 83 ochorení</a></li>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek, mozog a kognitívne poruchy</a></li>
  <li><a href="article.php?slug=retransplantacia-obliciek-po-zlyhani-stepu-prekazky">Retransplantácia obličiek po zlyhaní štepu</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_konopa-riziko-bipolarnej-poruchy-metaanalyza_article',
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