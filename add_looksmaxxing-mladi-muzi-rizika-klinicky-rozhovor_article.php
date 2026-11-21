<?php
// Klinicky prehlad s rozlisenim dostupnosti zdrojov. Aviza ani newsletter nie su povolene.
if (PHP_SAPI !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';
$articles = [[
    'title' => 'Looksmaxxing u mladých mužov: ako rozpoznať riziko a viesť klinický rozhovor',
    'slug' => 'looksmaxxing-mladi-muzi-rizika-klinicky-rozhovor',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Tlak na vzhľad môže viesť k rizikovému správaniu. Klinický prehľad vysvetľuje varovné príznaky, hranice dôkazov a rozhovor s mladým pacientom bez stigmatizácie.',
    'content' => <<<'HTML'
<figure><a href="img/looksmaxxing-mladi-muzi-rizika-klinicky-rozhovor.webp" target="_blank" rel="noopener noreferrer"><img src="img/looksmaxxing-mladi-muzi-rizika-klinicky-rozhovor.webp" alt="Zrkadlo s abstraktným odrazom a telefón ako symbol tlaku na vzhľad v online prostredí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Symbolická ilustrácia online tlaku na vzhľad. Nezobrazuje konkrétneho človeka ani výsledok estetického zákroku.</figcaption></figure>
<p><strong>Záujem o vzhľad patrí k dospievaniu. Klinický problém vzniká vtedy, keď úsilie o jeho zmenu sprevádza výrazné utrpenie, obmedzenie bežného života alebo zdravotne rizikové správanie. Pri fenoméne označovanom ako looksmaxxing má preto väčší význam otázka, čo mladý človek robí a aké to má následky, než samotná internetová nálepka.</strong> [1, 3]</p>

<p>Správa Medscape približuje nový komentár Kylea T. Gansona, Timothyho Piatkowského a Jasona M. Nagatu v časopise <em>Journal of Adolescent Health</em>. [1, 2] Ide o upozornenie pre klinikov, nie o intervenčnú štúdiu. Dostupné podklady neumožňujú určiť výskyt looksmaxxingu ani preukázanú účinnosť osobitnej liečby tohto fenoménu. Klinické odporúčania treba opierať o konkrétny zdravotný problém, ktorý pri vyšetrení identifikujeme.</p>

<h2>Rovnaké označenie môže skrývať veľmi rozdielne správanie</h2>
<p>Looksmaxxing označuje snahu čo najviac zlepšiť príťažlivosť podľa často úzko vymedzeného online ideálu mužského vzhľadu. Môže zahŕňať bežnú starostlivosť o pleť, obliekanie alebo pohyb, ale aj extrémne obmedzovanie jedla či tekutín, užívanie anabolicko-androgénnych steroidov a neregulovaných prípravkov alebo sebapoškodzovanie v snahe zmeniť vzhľad tváre. [1, 3]</p>

<p>Internetové výrazy <em>softmaxxing</em> a <em>hardmaxxing</em> nie sú medicínskou klasifikáciou bezpečnosti. Aj zdanlivo bežný úkon môže byť problémom, ak sa stane nutkavým, zaberá veľkú časť dňa alebo vedie k vyhýbaniu sa škole, práci a vzťahom. Naopak, samotná návšteva posilňovne či záujem o oblečenie neodôvodňujú psychiatrické označenie. [1, 3]</p>

<h2>Pýtať sa na skúsenosť, nie skúšať znalosť slangu</h2>
<p>Otázka „Robíte looksmaxxing?“ nemusí zachytiť podstatu problému. Mladý človek tento výraz nemusí používať alebo sa môže obávať odsúdenia. Užitočnejšie je otvoriť rozhovor o spokojnosti s vlastným telom, obsahu sledovanom na sociálnych sieťach a konkrétnych postupoch, ktoré skúšal. [1, 3]</p>

<p>Možno sa opýtať: „Čo vás na vašom vzhľade najviac trápi?“ alebo „Čo ste už skúšali zmeniť a ako to ovplyvnilo váš deň?“ Pri látkach a prípravkoch je vhodné zistiť ich skutočný názov, zdroj a spôsob používania. Všeobecné označenie „doplnky“ môže zakryť veľmi rozdielne expozície. Takýto rozhovor má zisťovať zdravotné riziko, nie viesť pacienta k obhajobe svojho vzhľadu.</p>

<p>Autori v univerzitnom zhrnutí odporúčajú venovať pozornosť aj osamelosti, šikane, sociálnemu porovnávaniu a komerčným či pseudovedeckým posolstvám. [3] Klinicky dôležité je pochopiť, prečo pacient danému zdroju dôveruje a čo od zmeny vzhľadu očakáva. Samotný nesúhlas s internetovým tvrdením ešte neobjasňuje jeho motiváciu.</p>

<h2>Kedy myslieť na telesnú dysmorfickú poruchu</h2>
<p>Pri podozrení na telesnú dysmorfickú poruchu, v medzinárodnej literatúre označovanú BDD, britské usmernenie National Institute for Health and Care Excellence (NICE) odporúča zistiť obsah obáv, čas venovaný vzhľadu a dôsledky pre fungovanie a vzťahy. <strong>Viac než hodinu denne strávenú zaoberaním sa vzhľadom považuje v tomto hodnotení za nadmerný čas.</strong> Nie je to však samostatný diagnostický test ani hranica, podľa ktorej by sa mal posudzovať každý záujem o vzhľad. [4]</p>

<p>Pri podozrení na BDD u človeka, ktorý vyhľadáva kozmetický alebo dermatologický zákrok, NICE odporúča posúdenie odborníkom na duševné zdravie so skúsenosťou s touto poruchou. U pacientov s diagnostikovanou BDD treba hodnotiť sebapoškodzovanie a samovražedné riziko, najmä pri súčasnej depresii. U detí a mladých ľudí s BDD odporúča posúdiť samovražedné myšlienky a vykonať úplné hodnotenie rizika pred liečbou. [4]</p>

<p>Vyšetrenie môže odhaliť aj poruchu príjmu potravy, depresiu, úzkosť alebo problémové užívanie látok. Tieto možnosti uvádzajú autori klinického komentára v dostupnom univerzitnom zhrnutí. [3] Nemajú sa však automaticky pripisovať každému človeku, ktorý sa zaujíma o looksmaxxing. Rozhodujú príznaky, ich závažnosť a dopad na život.</p>

<h2>Prečo sa téma týka aj internistu a nefrológa</h2>
<p>Rizikové zmeny vzhľadu nemusia mať iba psychické následky. Pri pacientovi so zdravotnými ťažkosťami má význam citlivá anamnéza užívaných prípravkov, stravovania, obmedzovania tekutín a predchádzajúcich zákrokov. Závažný telesný nález sa nesmie prehliadnuť len preto, že pacient opisuje svoj problém jazykom sociálnych sietí.</p>

<p>Nefrologický príklad poskytuje séria 10 dospelých kulturistov s dlhodobým užívaním anabolických steroidov, publikovaná v roku 2010. Biopsia preukázala u deviatich fokálnu segmentálnu glomerulosklerózu a u jedného samotnú glomerulomegáliu. [5] Ide o vybranú sériu pacientov s obličkovým nálezom, nie o odhad rizika medzi všetkými užívateľmi steroidov. Nemožno z nej vypočítať riziko pre dospievajúcich ani pre používateľov komunít orientovaných na looksmaxxing. Ukazuje však, prečo sa na tieto expozície pýtať bez odsudzovania.</p>

<h2>Čo možno ponúknuť bez sľubovania rýchlej nápravy</h2>
<p>Prvým cieľom je pomenovať aktuálne zdravotné následky a udržať možnosť ďalšieho kontaktu. Odporúčania autorov zahŕňajú vysvetlenie rizík, korekciu nepravdivých tvrdení, znižovanie zdravotných škôd a spoluprácu s odborníkmi podľa nálezu. [1, 3] Dôvera neznamená súhlas s nebezpečným postupom. Umožňuje však hovoriť o ňom otvorene a zistiť, či pacient po odmietnutí jednej možnosti nesiahol po ďalšej, ešte menej kontrolovanej.</p>

<p>Koordinácia s odborníkom na duševné zdravie, výživu, dorastové lekárstvo alebo dermatológiu sa má riadiť zisteným problémom. Zapojenie rodiny či iných blízkych ľudí môže byť súčasťou podpory, ak je primerané situácii. [3] Looksmaxxing je podnetom na rozhovor o konkrétnom človeku. Neoprávňuje k predpokladu, že poznáme jeho diagnózu, hodnoty alebo celkový zdravotný stav.</p>

<hr><p><small><em>Text je určený zdravotníckym pracovníkom. Celá východisková správa Medscape, univerzitné zhrnutie a relevantné odporúčania NICE boli dostupné. Pôvodný časopisecký komentár bol overený bibliograficky, jeho plný text nebol dostupný. Nefrologická séria bola hodnotená podľa abstraktu; nejde o štúdiu looksmaxxingu.</em></small></p>
<h2>Zdroje</h2><ol>
<li><small><em>Alison Palkhivala. Brutally Handsome: How to Identify and Address Looksmaxxing. Medscape, 16. november 2026. <a href="https://www.medscape.com/viewarticle/brutally-handsome-how-identify-and-address-looksmaxxing-2026a10018hv" target="_blank" rel="noopener noreferrer">Východisková správa</a>.</em></small></li>
<li><small><em>Kyle T. Ganson, Timothy Piatkowski, Jason M. Nagata. Looksmaxxing Among Adolescent Boys and Young Men: Increasing Awareness Among Clinicians. Journal of Adolescent Health. Publikované online 6. novembra 2026. DOI: <a href="https://doi.org/10.1016/j.jadohealth.2026.07.034" target="_blank" rel="noopener noreferrer">10.1016/j.jadohealth.2026.07.034</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42993115/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://linkinghub.elsevier.com/retrieve/pii/S1054139X26003587" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>University of Toronto, Factor-Inwentash Faculty of Social Work. Kyle Ganson and colleagues warn clinicians to be alert to health risks of “looksmaxxing” among boys and young men. 9. november 2026. <a href="https://socialwork.utoronto.ca/news/kyle-ganson-and-colleagues-warn-clinicians-to-be-alert-to-health-risks-of-looksmaxxing-among-boys-and-young-men/" target="_blank" rel="noopener noreferrer">Univerzitné zhrnutie komentára</a>.</em></small></li>
<li><small><em>National Institute for Health and Care Excellence. Obsessive-compulsive disorder and body dysmorphic disorder: treatment. Klinické usmernenie CG31, časť 1.4.2. <a href="https://www.nice.org.uk/guidance/cg31/chapter/Recommendations" target="_blank" rel="noopener noreferrer">Odporúčania NICE</a>. Online verzia overená 21. novembra 2026.</em></small></li>
<li><small><em>Leal C. Herlitz, Glen S. Markowitz, Alton B. Farris, Joshua A. Schwimmer, Michael B. Stokes, Cheryl Kunis, Robert B. Colvin, Vivette D. D’Agati. Development of Focal Segmental Glomerulosclerosis after Anabolic Steroid Abuse. Journal of the American Society of Nephrology. 2010;21(1):163-172. DOI: <a href="https://doi.org/10.1681/ASN.2009040450" target="_blank" rel="noopener noreferrer">10.1681/ASN.2009040450</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/19917783/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://doi.org/10.1681/ASN.2009040450" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
</ol>

HTML,
]];
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_looksmaxxing_klinicky_rozhovor',
]);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL;
if (!empty($result['errors'])) {
    exit(1);
}
