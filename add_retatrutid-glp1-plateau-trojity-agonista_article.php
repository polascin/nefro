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
    'title' => 'Retatrutid a zastavený úbytok hmotnosti na GLP-1: čo dáta hovoria a čo nie',
    'slug' => 'retatrutid-glp1-plateau-trojity-agonista',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Trojitý agonista dosiahol úbytok 28,3 % hmotnosti. Pivotná štúdia však vylúčila pacientov liečených v predchádzajúcich 90 dňoch, takže o prechode z inej liečby nehovorí nič.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/retatrutid-glp1-plateau-trojity-agonista.webp" type="image/webp">
    <img src="img/retatrutid-glp1-plateau-trojity-agonista.png" alt="Svetelna krivka klesa a prechadza do vodorovnej roviny, sprava sa k nej pripaja spleteny zvazok troch stuh svetla a ohyba ju znova nadol" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna znázorňujúca zastavenie úbytku hmotnosti a pridanie tretej receptorovej dráhy. Nejde o graf z klinickej štúdie.</figcaption>
</figure>

<p>Retatrutid je skúšaný trojitý agonista receptorov pre GIP, GLP-1 a glukagón. V máji 2026 zverejnila spoločnosť Eli Lilly výsledky fázy 3, podľa ktorých dosiahol v pivotnej štúdii TRIUMPH-1 priemerný úbytok <strong>28,3 % telesnej hmotnosti v 80. týždni</strong> pri najvyššej skúšanej dávke, teda hodnoty historicky spájané s bariatrickou chirurgiou.</p>

<p>S tým prichádza aj praktická otázka, ktorú si v ambulanciách kladú stále častejšie. Mnohí kandidáti na túto liečbu nezačínajú od nuly; prichádzajú po optimalizovanej liečbe semaglutidom alebo tirzepatidom a časť z nich naráža na zastavenie úbytku hmotnosti. Dokáže pridanie glukagónovej dráhy toto zastavenie prekonať?</p>

<p>Odpoveď, ktorú dnes údaje dovoľujú, je jednoznačná a nepríjemná: nevieme. A dôvod, prečo to nevieme, je v dizajne štúdií, nie v nedostatku pozornosti.</p>

<h2>Prečo sa úbytok hmotnosti zastaví</h2>

<p>Lieky s jedným alebo dvoma inkretínovými cieľmi pôsobia prevažne na príjem energie, a to navodením centrálnej sýtosti a spomalením vyprázdňovania žalúdka. Dlhodobé kalorické obmedzenie však spúšťa metabolickú adaptáciu: centrálny nervový systém znižuje energetický výdaj a posilňuje protiregulačné mechanizmy, ktorými telo zásoby chráni.</p>

<p>Teoretická úvaha, o ktorú sa opiera nádej vkladaná do trojitého agonistu, je tomuto obrazu primeraná. Glukagónová zložka by mala pôsobiť na druhej strane energetickej rovnice, teda na výdaj a na metabolizmus tuku, nielen na chuť do jedla. Diskutuje sa o termogenéze v hnedom tukovom tkanive, o lipolýze v pečeni a o mitochondriálnom cyklovaní substrátov so zvýšením pokojového energetického výdaja.</p>

<p>Samostatná aktivácia glukagónového receptora by pritom niesla riziko hyperglykémie. Súbežné pôsobenie zložiek GLP-1 a GIP, ktoré stimulujú od glukózy závislú sekréciu inzulínu, toto riziko podľa uvedenej úvahy vyvažuje.</p>

<p>Odborníci citovaní v zdrojovej správe však na jednom mieste formulujú zásadnú výhradu, ktorá sa oplatí zopakovať doslova: sľubný mechanizmus nie je to isté ako preukázaná stratégia prechodu. Výsledky retatrutidu v redukcii hmotnosti sú povzbudivé, ale zatiaľ nedokazujú, že spoľahlivo prelomí zastavenie úbytku u pacientov užívajúcich semaglutid alebo tirzepatid.</p>

<h2>Čo štúdie TRIUMPH ukázali a čo z nich vyvodiť nemožno</h2>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky programu TRIUMPH" tabindex="0">
<table>
  <thead><tr><th scope="col">Štúdia a populácia</th><th scope="col">Úbytok hmotnosti</th></tr></thead>
  <tbody>
    <tr><th scope="row">TRIUMPH-1, obezita (80. týždeň, najvyššia dávka)</th><td>28,3 %</td></tr>
    <tr><th scope="row">TRIUMPH-2, kohorta s diabetom (údaj sponzora)</th><td>20,8 %</td></tr>
    <tr><th scope="row">TRIUMPH-3, ťažká obezita s kardiovaskulárnym ochorením</th><td>22,6 %</td></tr>
  </tbody>
</table>
</div>

<p>Rozhodujúce obmedzenie je metodické. <strong>Štúdia TRIUMPH-1 vylúčila pacientov, ktorí v predchádzajúcich 90 dňoch užívali lieky na redukciu hmotnosti.</strong> Nebola teda navrhnutá ako štúdia prechodu a nehovorí, koľko hmotnosti pacient stratí navyše po tom, čo sa mu úbytok na semaglutide alebo tirzepatide zastavil.</p>

<p>Percento úbytku od východiskovej hodnoty v štúdii nemožno stotožniť s dodatočným úbytkom po inej liečbe. Pacient, ktorý už na predchádzajúcom lieku schudol pätinu hmotnosti, má inú východiskovú situáciu, iné zloženie tela a iný stupeň metabolickej adaptácie než účastník, ktorý liečbu nikdy nedostal.</p>

<p>Praktické dôsledky, na ktoré odborníci upozorňujú, sú dva. Pacient prechádzajúci z existujúceho inkretínu bude pravdepodobne čakať na nástup účinku dlhšie než pacient bez predchádzajúcej liečby. A hoci predchádzajúca expozícia poskytuje istú krížovú toleranciu voči základným gastrointestinálnym nežiaducim účinkom, nechráni pacienta pred nežiaducimi udalosťami pri agresívnej titrácii ani pri zavedení úplne novej receptorovej dráhy.</p>

<h2>Znášanlivosť a srdcová frekvencia</h2>

<p>Pri najvyššej skúšanej dávke v štúdii TRIUMPH-2 bola hlásená nauzea u 28,0 %, hnačka u 33,6 % a vracanie u 15,7 % účastníkov. Tieto udalosti boli podľa citovaných odborníkov prevažne mierne až stredne ťažké a zvládnuteľné pri začatí nižšou dávkou. Opäť však platí, že tieto čísla nekvantifikujú, ako sa znášanlivosť zmení pri prechode z tirzepatidu.</p>

<p>Osobitnú pozornosť si zaslúži srdcová frekvencia. V štúdiách fázy 2 bol zistený od dávky závislý vzostup s vrcholom približne okolo 24. týždňa a následným poklesom. Praktická poznámka z klinickej praxe je priamočiara: ak je pacient už na duálnom agonistovi a má mierne zvýšenú srdcovú frekvenciu, pridanie ďalšej dráhy môže byť pre neho nevýhodné.</p>

<p>Pre kardiovaskulárnu bezpečnosť platí dôležitá rezerva. Dostupné analýzy kardiovaskulárnych príhod zo štúdie TRIUMPH-3 zatiaľ <strong>nepreukázali zníženie závažných nežiaducich kardiovaskulárnych príhod</strong>. Predpoklad, že väčší úbytok hmotnosti automaticky znamená lepší kardiovaskulárny bezpečnostný profil, preto nie je podložený.</p>

<h2>Liečba ako cielený plán, nie rebrík</h2>

<p>Odborníci sa zhodujú na tom, že liečbu netreba rámcovať ako rebrík, ktorý má každý pacient vystúpiť od jedného agonistu cez duálny až po trojitý. Cieľom je zvoliť liečbu, ktorá rieši komplikácie obezity u daného pacienta, prináša zmysluplný úžitok, je znášaná a dá sa udržať.</p>

<p>Praktické dôsledky:</p>

<ul>
  <li>Ak pacient dosahuje zdravotný prínos, samotné spomalenie úbytku hmotnosti nie je dôvodom na eskaláciu.</li>
  <li>Pred zvažovaním prechodu treba overiť, že súčasná liečba dostala dostatočnú príležitosť, a riešiť prekážky adherencie.</li>
  <li>Udržanie dosiahnutého zlepšenia zdravotného stavu má rovnakú hodnotu ako ďalší úbytok na váhe.</li>
  <li>Ponechanie trojitého agonistu v zálohe zachováva dôležitú možnosť pre neskoršie obdobie pri ochorení, ktoré sa manažuje desaťročia.</li>
</ul>

<p>Zaznela aj poznámka, ktorá sa v diskusii o týchto liekoch opakovane prehliada: po vysadení lieku sa môžu počas jedného roka vrátiť <strong>dve tretiny</strong> dosiahnutého úbytku hmotnosti. To isté platí po chirurgickom výkone. Stratégia liečby sa preto musí plánovať na roky, nie na cieľovú hodnotu na váhe.</p>

<h2>Nefrologický pohľad</h2>

<p>Retatrutid nemá žiadne publikované obličkové výsledky. Program TRIUMPH obličkové ukazovatele nesledoval a akékoľvek tvrdenie o nefroprotektívnom potenciáli by bolo prenesením očakávania z inej triedy.</p>

<p>Pre porovnanie stojí za to pripomenúť, aký vyzerá skutočný obličkový dôkaz. Štúdia FLOW randomizovala 3 533 pacientov s diabetom 2. typu a chronickou chorobou obličiek na semaglutid alebo placebo a po mediáne sledovania 3,4 roka znížila riziko závažných obličkových udalostí o 24 % (HR 0,76; 95 % IS 0,66–0,88), riziko úmrtia z kardiovaskulárnych príčin o 29 % (HR 0,71; 95 % IS 0,56–0,89) a spomalila ročný pokles eGFR o 1,16 ml/min/1,73 m². To je úroveň dôkazu, pri ktorej možno hovoriť o obličkovom prínose. Pri retatrutide taký dôkaz zatiaľ neexistuje.</p>

<p>Z praktického hľadiska je pri pacientovi s chronickou chorobou obličiek podstatnejšia bezpečnosť než percentá úbytku:</p>

<ul>
  <li><strong>Gastrointestinálne straty a objemový stav.</strong> Pri hnačke u tretiny a vracaní u šestiny pacientov pri najvyššej dávke je riziko prerenálneho akútneho poškodenia obličiek reálne, najmä pri súbežnej liečbe inhibítormi systému renín-angiotenzín, diuretikami alebo inhibítormi SGLT2. Pacient potrebuje vopred vedieť, kedy má liečbu prerušiť a koho kontaktovať.</li>
  <li><strong>Interpretácia odhadu glomerulárnej filtrácie.</strong> Rýchly a výrazný úbytok hmotnosti znižuje svalovú hmotu, a tým aj tvorbu kreatinínu. Odhad filtrácie z kreatinínu sa môže javiť priaznivejšie, než aká je skutočnosť. Pri nejasnosti alebo pri rozhodovaní závislom od presnej hodnoty má miesto stanovenie cystatínu C.</li>
  <li><strong>Nutričný stav a svalová hmota.</strong> Pri chronickej chorobe obličiek a pri dialýze je nízka svalová hmota nezávislým nepriaznivým prognostickým faktorom. Úbytok 28 % telesnej hmotnosti nie je úbytok výlučne tukového tkaniva. Monitorovanie príjmu bielkovín a funkčného stavu patrí k liečbe, nie k jej príslušenstvu.</li>
  <li><strong>Srdcová frekvencia.</strong> U dialyzovaného pacienta s obmedzenou kardiálnou rezervou je od dávky závislý vzostup srdcovej frekvencie relevantnejší než u metabolicky zdravého človeka.</li>
</ul>

<h2>Záver</h2>

<p>Retatrutid zatiaľ nie je registrovaný a nie je možnosťou pre bežné predpisovanie. Jeho účinnosť v redukcii hmotnosti je podporená publikovanou štúdiou fázy 2 a štúdiou fázy 3 pri diabete 2. typu; čísla z programu TRIUMPH pri obezite pochádzajú prevažne z oznámení sponzora a čakajú na recenzované publikovanie.</p>

<p>Prezentovať ho ako potvrdené riešenie zastaveného úbytku hmotnosti u pacientov po semaglutide alebo tirzepatide je predbiehanie dôkazov. Relevantné štúdie prechodu zatiaľ neexistujú a pivotná štúdia predchádzajúcu liečbu práve vylúčila. Pre nefrológa je dnes podstatnejšie, že obličkové výsledky nie sú k dispozícii vôbec, zatiaľ čo pre semaglutid existujú z primárneho randomizovaného dôkazu.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom. Retatrutid je skúšaný liek bez registrácie a nie je schválený na klinické použitie; uvádzané údaje z programu TRIUMPH pri obezite pochádzajú z oznámení sponzora a z konferenčných prezentácií, nie z recenzovaných publikácií. Text nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania a súhrny charakteristických vlastností liekov.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Peck Julie. Could Retatrutide Break a GLP-1 Weight-Loss Plateau? <em>Medscape Medical News</em>, 20. októbra 2026. Vyjadrenia Gevorka Tatariana (Elevé Cosmetic Surgery, Coral Gables, Florida), Jamesa Chaa (VedaNu Wellness, San Diego) a Vishala Dubeyho (Nutricult, India). <a href="https://www.medscape.com/viewarticle/could-retatrutide-break-glp-1-weight-loss-plateau-2026a10013ek" target="_blank" rel="noopener noreferrer">Celá správa</a>. Poznámka k hodnoteniu: oslovení komentujúci pôsobia v estetickej chirurgii, vo wellness zariadení a v spoločnosti vyrábajúcej doplnky výživy, nie v akademickej obezitológii ani v nefrológii; ich vyjadrenia preto predstavujú odborný názor s primerane obmedzenou váhou.</em></small></p>

<p><small><em>2. Jastreboff Ania M., Kaplan Lee M., Frías Juan P., Wu Qiwei, Du Yu, Gurbuz Sirel, Coskun Tamer, Haupt Axel, Milicevic Zvonko, Hartman Mark L.; Retatrutide Phase 2 Obesity Trial Investigators. Triple-Hormone-Receptor Agonist Retatrutide for Obesity: A Phase 2 Trial. <em>New England Journal of Medicine.</em> 2023;389(6):514–526. DOI: <a href="https://doi.org/10.1056/NEJMoa2301972" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2301972</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37366315/" target="_blank" rel="noopener noreferrer">PubMed PMID 37366315</a>.</em></small></p>

<p><small><em>3. Bajaj Harpreet S., Welch Michelle, Shah Parag, Luna Eduardo, Jaouimaa Fatima-Zahra, Liu Bing, Liu Rong, Chen Yanyun, Patel Hiren, Bartee Amy. Efficacy and safety of retatrutide, a GIP, GLP-1, and glucagon receptor agonist, in people with type 2 diabetes and inadequate glycaemic control with diet and exercise (TRANSCEND-T2D-1): a double-blind, randomised, phase 3 trial. <em>The Lancet.</em> 2026;407(10546):2402–2413. DOI: <a href="https://doi.org/10.1016/S0140-6736(26)00967-0" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(26)00967-0</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42250575/" target="_blank" rel="noopener noreferrer">PubMed PMID 42250575</a>.</em></small></p>

<p><small><em>4. Perkovic Vlado, Tuttle Katherine R., Rossing Peter, Mahaffey Kenneth W., Mann Johannes F. E., Bakris George, Baeres Florian M. M., Idorn Thomas, Bosch-Traberg Heidrun, Lausvig Nanna Leonora, Pratley Richard; FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. <em>New England Journal of Medicine.</em> 2024;391(2):109–121. DOI: <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2403347</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed PMID 38785209</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky číselné údaje o programe TRIUMPH, vrátane podielov nežiaducich účinkov, kritéria vylúčenia v štúdii TRIUMPH-1 a údaja o nepreukázanom znížení kardiovaskulárnych príhod, boli overené priamo na verejne prístupnej stránke zdrojovej správy, vrátane mena autorky v byline a afiliácií citovaných komentujúcich. Bibliografické údaje a úplné autorské zoznamy publikovaných štúdií fázy 2 a 3 a štúdie FLOW boli nezávisle overené v databáze Crossref a v PubMed.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je explicitné pomenovanie afiliácií citovaných komentujúcich, odlíšenie recenzovaných publikácií od oznámení sponzora, porovnanie s úrovňou obličkového dôkazu zo štúdie FLOW, a nefrologicky špecifické praktické body vrátane vplyvu úbytku svalovej hmoty na odhad glomerulárnej filtrácie z kreatinínu a rizika nízkej svalovej hmoty pri dialýze. Tieto súvislosti nie sú obsiahnuté vo východiskovej správe.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=stigma-glp1-komunikacia-s-pacientom-nefrologia">Stigma okolo liečby GLP-1 a komunikácia s pacientom</a></li>
  <li><a href="article.php?slug=semaglutid-chudnutie-egfr-kreatinin-cystatin-c">Semaglutid, chudnutie a odhad eGFR z kreatinínu a cystatínu C</a></li>
  <li><a href="article.php?slug=obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia">Obezita v nefrológii: skríning a manažment</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_retatrutid-glp1-plateau-trojity-agonista_article',
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