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
    'title' => 'Skôr než pacienta označíme za nespolupracujúceho',
    'slug' => 'skor-nez-pacienta-oznacime-nespolupracujuceho',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Nedostatočná adherencia môže ohroziť zdravie, nie je však charakterovou vlastnosťou. V nefrológii treba rozlíšiť klinické riziko, liečebnú záťaž, praktické bariéry a informované rozhodnutie.',
    'content' => <<<'HTML'
<p>Vynechané lieky, nedokončené vyšetrenia alebo opakované nepríchody na dialýzu majú klinické dôsledky. Označenie pacienta za „nespolupracujúceho“ však nevysvetľuje, prečo k nim dochádza. Niekedy ide o nežiaduce účinky, inokedy o nedostupnú dopravu, neporozumenie pokynom, vyčerpanie alebo strach. Rovnaké správanie môže mať odlišné príčiny a vyžadovať odlišnú pomoc.</p>

<p>Lekárka Raghda Rashad v komentári pre Medscape upozornila aj na predchádzajúcu psychickú traumu a pocit ohrozenia pri kontakte so zdravotníctvom. Navrhuje starostlivosť zohľadňujúcu psychickú traumu, označovanú ako <em>trauma-informed care</em>. Nejde o hľadanie traumatickej udalosti u každého pacienta. Podstatou je predvídateľné a rešpektujúce prostredie a snaha porozumieť tomu, čo bráni uskutočneniu liečebného plánu. [1]</p>

<figure>
  <picture>
    <source srcset="img/skor-nez-pacienta-oznacime-nespolupracujuceho.webp" type="image/webp">
    <img src="img/skor-nez-pacienta-oznacime-nespolupracujuceho.png" alt="Pacient a lekárka pri rozhovore o liečebnej záťaži znázornenej liekmi, dopravou, časom a dialyzačnou liečbou" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Za rovnakým prejavom nedostatočnej adherencie môžu byť odlišné zdravotné, praktické, psychické aj systémové bariéry. Ilustračné zobrazenie.</figcaption>
</figure>

<p>Pre nefrológiu je tento pohľad osobitne dôležitý. Dlhodobá liečba zasahuje do stravovania, práce, rodinného života aj každodenného rozhodovania. Rozhovor o adherencii preto nemôže zostať iba kontrolou, či pacient splnil pokyny.</p>

<h2>Adherencia opisuje uskutočňovanie liečby, nie charakter človeka</h2>

<p>Adherenciou v tomto článku rozumieme mieru, do akej pacient uskutočňuje dohodnutý liečebný plán. Toto vymedzenie predpokladá, že plán bol zrozumiteľne vysvetlený a pacient mal možnosť vyjadriť obavy, preferencie alebo nesúhlas.</p>

<p>Treba odlíšiť nezámerné vynechanie liečby od vedomého rozhodnutia. Zabudnutá dávka, zamenený liek, nedostupný recept a prerušenie liečby pre závraty nie sú rovnaký problém. Ani informované odmietnutie navrhovaného postupu nemožno bez ďalšieho vysvetlenia zameniť za neschopnosť spolupracovať.</p>

<p>Užitočnejšie než všeobecná otázka „Užívate lieky pravidelne?“ sú konkrétne, nehodnotiace otázky:</p>

<ul>
  <li>Ktoré dávky sa vám počas posledného týždňa nepodarilo užiť?</li>
  <li>Objavili sa po lieku ťažkosti, pre ktoré ste ho obmedzili?</li>
  <li>Dostali ste sa ku všetkým predpísaným liekom?</li>
  <li>Ktorá časť liečby je pre vás najťažšia?</li>
</ul>

<p>Takéto otázky neznižujú pacientovu zodpovednosť. Umožňujú zistiť, či je navrhované riešenie uskutočniteľné a aký typ zásahu môže pomôcť.</p>

<h2>Čo znamená starostlivosť zohľadňujúca psychickú traumu</h2>

<p>Psychickou traumou sa tu nemyslí telesné poranenie. SAMHSA ju opisuje ako následok udalosti, série udalostí alebo okolností, ktoré človek prežíva ako fyzicky či emocionálne škodlivé alebo ohrozujúce a ktoré môžu nepriaznivo ovplyvniť jeho fungovanie a telesnú, psychickú či sociálnu pohodu. Nie každá takáto skúsenosť vedie k posttraumatickej stresovej poruche (PTSD). [2]</p>

<p>Starostlivosť zohľadňujúca psychickú traumu nie je jedným predpísaným postupom. SAMHSA ju stavia na bezpečí, dôveryhodnosti a transparentnosti, rovesníckej podpore, spolupráci, posilňovaní hlasu a reálnej možnosti voľby, ako aj na rešpekte ku kultúrnym, historickým a rodovým súvislostiam. Organizácia má rozumieť vplyvu traumy, rozpoznávať jej možné prejavy, premietnuť toto poznanie do praxe a predchádzať opätovnému traumatizovaniu. [2]</p>

<p>V ambulancii to môže znamenať ochranu súkromia, vysvetlenie nasledujúcich krokov, vyžiadanie súhlasu pred dotykom alebo vyšetrením a ponuku skutočných možností tam, kde sú klinicky prípustné. Pacient nemusí odhaľovať osobnú minulosť, aby tím postupoval citlivo.</p>

<p>Na dialyzačnom pracovisku sa tento princíp môže premietnuť do vysvetlenia kanylácie cievneho prístupu, včasného oznámenia zmeny postupu alebo dohody, ako pacient upozorní na neznesiteľnú bolesť. Ide o praktickú aplikáciu všeobecných princípov, nie o osobitný dialyzačný protokol overený v citovaných štúdiách. Ak určitý úkon nemožno bezpečne odložiť, treba vysvetliť prečo. Predstieraná možnosť voľby alebo nesplniteľný sľub dôveru poškodzujú.</p>

<h2>PTSD a lieková adherencia: asociácia, nie jednoduchá príčina</h2>

<p>Lauren Taggart Wasson a spoluautori v metaanalýze 16 observačných štúdií so 4 483 účastníkmi skúmali súvislosť medzi PTSD a nedostatočnou adherenciou k liekom pri chronických somatických ochoreniach. Súhrnný pomer šancí bol 1,22 (95 % interval spoľahlivosti od 1,06 do 1,41). Medzi štúdiami bola významná heterogenita (Q = 59,4; p &lt; 0,001). [3]</p>

<p>Výsledok znamená vyššie šance nedostatočnej adherencie u ľudí s PTSD. <strong>Neznamená zvýšenie absolútneho rizika o 22 percentuálnych bodov</strong> a nepreukazuje, že PTSD bola príčinou vynechávania liekov.</p>

<p>V šiestich štúdiách, ktoré skúmali PTSD súvisiacu so zdravotnou udalosťou, bol súhrnný pomer šancí 2,08 (95 % interval spoľahlivosti od 1,03 do 4,18). V ôsmich štúdiách s PTSD po inej udalosti bol 1,10 (95 % interval spoľahlivosti od 0,99 do 1,24). Rozdiel medzi podskupinami nedosiahol obvyklú hranicu štatistickej významnosti (p = 0,08) a v oboch podskupinách pretrvávala heterogenita. Nemožno preto spoľahlivo tvrdiť, že PTSD vyvolaná zdravotnou udalosťou má pre adherenciu preukázateľne silnejšiu asociáciu než PTSD po inej udalosti. [3]</p>

<p>Autori uvádzajú možné mechanizmy, napríklad vyhýbanie sa lieku pripomínajúcemu ohrozujúcu udalosť, presvedčenia o ochorení alebo kognitívne ťažkosti. Ide o hypotézy. Metaanalýza nebola intervenčnou štúdiou a nepreukázala, že zavedenie starostlivosti zohľadňujúcej psychickú traumu zlepší adherenciu, hospitalizácie alebo mortalitu.</p>

<p>Výsledky nemožno automaticky preniesť na dialyzovaných pacientov. Zahrnuté populácie boli rôznorodé; výrazne boli zastúpené HIV a kardiovaskulárne ochorenia. Jediná transplantačná štúdia sa týkala transplantácie srdca, nie obličky. [3]</p>

<h2>Nenahrádzajme jednu nálepku druhou</h2>

<p>Vyhýbavé správanie, podráždenosť alebo opakované nepríchody neumožňujú diagnostikovať PTSD. Rovnako z nich nemožno odvodzovať depresiu, poruchu pozornosti alebo neurovývinovú odlišnosť. Psychická trauma je jednou z možných súvislostí, nie univerzálnym vysvetlením.</p>

<p>V nefrologickej ambulancii má zmysel začať overiteľnými okolnosťami. Vie pacient, ktoré lieky má aktuálne užívať? Nezostali mu po hospitalizácii dva rozdielne liekové zoznamy? Dokáže otvoriť balenie, prečítať pokyny a zosúladiť dávkovanie s denným režimom? Má liek dostupný a toleruje ho?</p>

<p>Ak rozhovor naznačuje psychické ťažkosti, je primerané ponúknuť ďalšie odborné posúdenie. Pacient však nemusí najprv dostať psychiatrickú diagnózu, aby mal nárok na zrozumiteľnú a rešpektujúcu starostlivosť.</p>

<h2>Nepríchod na dialýzu má dôsledky, ale aj konkrétne bariéry</h2>

<p>Kvalitatívna štúdia s 30 pacientmi liečenými hemodialýzou identifikovala ako častú bariéru nedostatočnú alebo nespoľahlivú dopravu. Pacienti zároveň uvádzali význam vysvetlenia rizík, vzťahov s ostatnými pacientmi a podporujúceho prístupu tímu. Malý účelovo vybraný súbor neumožňuje určiť prevalenciu jednotlivých bariér, prináša však informáciu o tom, ako problém vnímali samotní pacienti. [4]</p>

<p>Vo veľkej americkej observačnej analýze 44 586 241 plánovaných hemodialyzačných liečeb u 182 536 pacientov bolo vynechanie liečby spojené s dopravou, počasím, sviatkami, psychiatrickým ochorením, bolesťou a gastrointestinálnymi ťažkosťami. Po vynechanej liečbe boli vyššie šance hospitalizácie, návštevy urgentného príjmu aj prijatia na jednotku intenzívnej starostlivosti. [5]</p>

<p>Táto analýza bola observačná. Autori nemohli úplne vylúčiť, že niektorí pacienti vynechali dialýzu pre už sa zhoršujúci zdravotný stav, ktorý zároveň viedol k hospitalizácii. Výsledky však ukazujú, prečo treba súčasne riešiť riziko z vynechanej liečby aj bariéru, ktorá k nej prispela.</p>

<h2>Laboratórny výsledok nie je meradlom poslušnosti</h2>

<p>Vyššia koncentrácia fosfátov, hyperkaliémia alebo väčší medzidialyzačný hmotnostný prírastok môžu otvoriť otázku, ako sa liečebný plán uskutočňuje. Samy osebe však nedokazujú vedomé porušovanie odporúčaní.</p>

<p>Pri hyperfosfatémii treba okrem príjmu fosfátov a užívania viazačov zohľadniť ich toleranciu, spôsob a čas užívania, predpísanú a skutočne absolvovanú dialyzačnú liečbu aj reziduálnu funkciu obličiek. Koncentráciu draslíka ovplyvňujú lieky, acidobázický stav, inzulínový deficit, tkanivové poškodenie, presuny medzi bunkami a extracelulárnym priestorom aj okolnosti odberu. Ide o diferenciálnu diagnostiku, nie o výsledky citovanej metaanalýzy.</p>

<p>Súčasne sa nesmie podceniť aktuálne ohrozenie. Pri vynechanej dialýze a podozrení na závažnú hyperkaliémiu alebo pľúcny edém má prednosť bezodkladné klinické posúdenie a potrebná liečba. Citlivá komunikácia a dôsledné zvládnutie rizika sa nevylučujú.</p>

<h2>Rozhovor musí viesť ku konkrétnej zmene</h2>

<ol>
  <li><strong>Opísať problém bez hodnotenia osoby.</strong> Napríklad: „Tento mesiac ste neabsolvovali dve plánované dialýzy.“</li>
  <li><strong>Zistiť pacientovo vysvetlenie.</strong> Neprerušovať ho hneď prvým poučením.</li>
  <li><strong>Overiť bezprostredné riziko a bariéry.</strong> Rozlíšiť zdravotný problém, organizačnú prekážku, neporozumenie a vedomé rozhodnutie.</li>
  <li><strong>Dohodnúť jeden uskutočniteľný krok.</strong> Napríklad vyriešiť dopravu alebo zosúladiť liekové zoznamy.</li>
  <li><strong>Určiť, kto a kedy overí výsledok.</strong> Bez následnej kontroly zostáva dohoda iba zámerom.</li>
</ol>

<p>Ide o praktický rámec klinickej komunikácie, nie o validovaný intervenčný program. Podľa potreby sa zapája sestra, farmaceut, sociálny pracovník, psychológ alebo psychiater. Porozumenie možno overiť požiadavkou, aby pacient vlastnými slovami opísal ďalší postup. Nejde o skúšanie pacienta, ale o kontrolu, či tím plán vysvetlil zrozumiteľne.</p>

<h2>Dokumentácia má zachytiť skutočnosti a ďalší postup</h2>

<p>Záznam „pacient nespolupracuje“ je informačne chudobný. Nepovie ďalšiemu zdravotníkovi, čo sa stalo, aké riziko vzniklo ani čo už bolo vykonané.</p>

<p>Modelový, nie skutočný záznam môže znieť:</p>

<blockquote><p>Pacient uvádza vynechanie večernej dávky pre opakovanú nevoľnosť. Overený aktuálny liekový zoznam a časová súvislosť ťažkostí s užívaním. Vysvetlené riziká svojvoľného prerušenia liečby. Dohodnuté ďalšie posúdenie tolerancie a kontrola v určenom termíne.</p></blockquote>

<p>Takýto zápis neospravedlňuje rizikové správanie. Zachytáva však informácie, podľa ktorých môže ďalší člen tímu konať. Pri odmietnutí treba rozlíšiť informované rozhodnutie od neporozumenia alebo narušenej rozhodovacej schopnosti. Dokumentácia má vecne zachytiť poskytnuté informácie, pacientovo stanovisko, posúdenie rizika a dohodnutý postup, nie úsudok o osobnosti.</p>

<h2>Rešpektujúca starostlivosť má hranice</h2>

<p>Zohľadňovanie psychickej traumy neznamená tolerovanie násilia, vyhrážok alebo ohrozovania ostatných pacientov. Nevyžaduje ani to, aby nefrológ suploval psychoterapeuta. Fyzická a psychická bezpečnosť pacientov aj zdravotníkov patria medzi základné princípy tohto prístupu. [2]</p>

<p>Nedostatok času, súkromia a personálu nemožno nahradiť požiadavkou na neobmedzenú emocionálnu dostupnosť jednotlivého lekára či sestry. Pracovisko však môže systematicky vyhodnocovať opakované bariéry, napríklad zlyhávanie dopravy, nezrozumiteľné písomné pokyny alebo nejasný postup pri bolestivých výkonoch. Po zavedení zmeny treba overiť jej účinok.</p>

<h2>Klinické posolstvo</h2>

<p>Nedostatočnú adherenciu treba pomenovať, pretože môže ohrozovať zdravie. Netreba z nej však robiť charakterovú vlastnosť. Starostlivosť zohľadňujúca psychickú traumu ponúka rámec na zníženie zbytočného pocitu ohrozenia a na otvorenie rozhovoru o prekážkach. Jej rozumné princípy nemožno zamieňať s preukázaným zlepšením dlhodobých nefrologických výsledkov.</p>

<p>Dostupná metaanalýza podporuje asociáciu PTSD s liekovou nonadherenciou, nie účinnosť konkrétnej intervencie. Pre každodennú prax zostáva podstatná zmena otázky: namiesto hodnotenia, aký pacient je, zistiť, čo mu bráni uskutočniť liečbu, aké riziko vzniklo a čo možno bezpečne zmeniť.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Raghda Rashad. Before You Call a Patient 'Noncompliant'. <em>Medscape.</em> Komentár, 30. septembra 2026. <a href="https://www.medscape.com/viewarticle/before-you-call-patient-noncompliant-2026a10010ku" target="_blank" rel="noopener noreferrer">Zdrojový článok</a>.</em></small></p>
<p><small><em>[2] Substance Abuse and Mental Health Services Administration. SAMHSA's Concept of Trauma and Guidance for a Trauma-Informed Approach. HHS Publication No. (SMA) 14-4884. Rockville, MD: SAMHSA; 2014. <a href="https://library.samhsa.gov/sites/default/files/sma14-4884.pdf" target="_blank" rel="noopener noreferrer">Oficiálny dokument</a>. <a href="https://www.samhsa.gov/mental-health/trauma-violence/trauma-informed-approaches-programs" target="_blank" rel="noopener noreferrer">Aktuálny prehľad SAMHSA</a>.</em></small></p>
<p><small><em>[3] Lauren Taggart Wasson, Jonathan A. Shaffer, Donald Edmondson, Rachel Bring, Elena Brondolo, Louise Falzon, Beatrice Konrad, Ian M. Kronish. Posttraumatic Stress Disorder and Nonadherence to Medications Prescribed for Chronic Medical Conditions: A Meta-Analysis. <em>Journal of Psychiatric Research.</em> 2018;102:102–109. DOI: <a href="https://doi.org/10.1016/j.jpsychires.2018.02.013" target="_blank" rel="noopener noreferrer">10.1016/j.jpsychires.2018.02.013</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/29631190/" target="_blank" rel="noopener noreferrer">PubMed PMID 29631190</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6124486/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>
<p><small><em>[4] Kara B. Chenitz, Michael Fernando, Judy A. Shea. In-Center Hemodialysis Attendance: Patient Perceptions of Risks, Barriers, and Recommendations. <em>Hemodialysis International.</em> 2014;18(2):364–373. DOI: <a href="https://doi.org/10.1111/hdi.12139" target="_blank" rel="noopener noreferrer">10.1111/hdi.12139</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/24447838/" target="_blank" rel="noopener noreferrer">PubMed PMID 24447838</a>.</em></small></p>
<p><small><em>[5] Kevin E. Chan, Ravi I. Thadhani, Franklin W. Maddux. Adherence Barriers to Chronic Dialysis in the United States. <em>Journal of the American Society of Nephrology.</em> 2014;25(11):2642–2648. DOI: <a href="https://doi.org/10.1681/ASN.2013111160" target="_blank" rel="noopener noreferrer">10.1681/ASN.2013111160</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/24762400/" target="_blank" rel="noopener noreferrer">PubMed PMID 24762400</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4214530/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_skor-nez-pacienta-oznacime-nespolupracujuceho_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
