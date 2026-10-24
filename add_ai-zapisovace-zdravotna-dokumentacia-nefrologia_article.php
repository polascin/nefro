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
    'title' => 'AI zapisovače a zdravotná dokumentácia: čo ukázalo kanadské hodnotenie',
    'slug' => 'ai-zapisovace-zdravotna-dokumentacia-nefrologia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Viac než 12 000 lekárov, menšia vnímaná záťaž. Viac než polovica ušetreného času sa však vrátila do administratívy a 75 % lekárov záznamy často upravuje.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/ai-zapisovace-zdravotna-dokumentacia-nefrologia.webp" type="image/webp">
    <img src="img/ai-zapisovace-zdravotna-dokumentacia-nefrologia.png" alt="Svetelna zvukova krivka prechadza cez priesvitny list papiera a vychadza ako stuha svetla, ktorej jeden usek sa rozpada na castice" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna. Nejde o zobrazenie konkrétneho softvéru ani reálneho záznamu.</figcaption>
</figure>

<p>Kanadská národná agentúra Canada Health Infoway spustila v júni 2025 program pre nasadenie takzvaných AI zapisovačov v primárnej starostlivosti. Do februára 2026 sa doň zapojilo viac než 12 000 lekárov primárnej starostlivosti a počet mesačne podporených stretnutí vzrástol z 244 631 na viac než 1,22 milióna. Ide o jeden z mála programov, ktorý nasadenie takéhoto nástroja aj systematicky vyhodnotil.</p>

<p>Výsledky hodnotenia sú zmiešané spôsobom, ktorý stojí za pozornosť aj v slovenskom prostredí, kde tieto nástroje prichádzajú bez porovnateľného rámca. Najzaujímavejší údaj z celého hodnotenia sa pritom netýka presnosti zápisu, ale toho, kam sa ušetrený čas v skutočnosti presunul.</p>

<h2>Čo AI zapisovač je a čím sa stal</h2>

<p>AI zapisovače sú digitálne nástroje poháňané spracovaním prirodzeného jazyka, ktoré v reálnom čase prepisujú a sumarizujú rozhovor s pacientom. Počas hodnotenia sa však ich úloha rozšírila. Hodnotiaca správa to formuluje priamo: hoci hodnotenie bolo pôvodne navrhnuté na posúdenie automatizovaného zapisovania lekárskeho záznamu, táto funkcia sa rýchlo ukázala byť len jednou zložkou širšieho a rozširujúceho sa súboru schopností.</p>

<p>Nástroje začali fungovať ako „klinickí kopiloti“ podporujúci návrhy odporúčaní a konziliárnych listov, pacientske zhrnutia, edukačné a sebariadiace materiály, a dokonca aj klinické rozhodovanie. To je podstatná zmena predmetu posudzovania. Nástroj, ktorý prepisuje, a nástroj, ktorý navrhuje postup, sú z hľadiska rizika aj regulácie dve rôzne veci.</p>

<h2>Čo hodnotenie ukázalo ako prínos</h2>

<div class="table-responsive" role="region" aria-label="Vykazované prínosy podľa hodnotenia programu Infoway" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Výsledok</th></tr></thead>
  <tbody>
    <tr><th scope="row">Nižšia administratívna záťaž</th><td>takmer 70 % respondentov</td></tr>
    <tr><th scope="row">Nižšia kognitívna záťaž</th><td>takmer 80 %</td></tr>
    <tr><th scope="row">Väčšie zapojenie počas návštevy</th><td>viac než 80 %</td></tr>
    <tr><th scope="row">Vnímané zlepšenie kvality starostlivosti</th><td>60 %</td></tr>
    <tr><th scope="row">Dokončenie záznamu v ten istý deň</th><td>z 55,9 % na takmer 75 %</td></tr>
    <tr><th scope="row">Ušetrený čas po 6 mesiacoch</th><td>1,11 hodiny týždenne počas pracovného času a takmer 1 hodina mimo neho</td></tr>
  </tbody>
</table>
</div>

<p>Mechanizmus, ktorý lekári opisovali, je zrozumiteľný a nejde o maličkosť: možnosť udržať očný kontakt, pozornejšie počúvať a sústrediť sa na rozhovor namiesto neustáleho prepínania pozornosti medzi pacientom a obrazovkou. Časť respondentov vnímala aj úplnejšiu dokumentáciu pri zložitejších stretnutiach.</p>

<p>Treba však pomenovať, čo tieto čísla sú. Ide o <strong>subjektívne hodnotenie vlastnej záťaže v dotazníku</strong>, nie o meranie chybovosti, bezpečnosti pacienta ani klinických výsledkov. „Vnímané zlepšenie kvality starostlivosti u 60 %“ nie je údaj o kvalite starostlivosti. Samotná úvodná veta zdrojovej správy to priznáva: dôkazy o vplyve na pracovné postupy a na výsledky pacientov sú stále obmedzené.</p>

<h2>Kam sa presunul ušetrený čas</h2>

<p>Toto je najpoučnejší údaj z celého hodnotenia a v prevzatiach spravidla chýba. Medzi lekármi, ktorí uviedli úsporu času, presunulo <strong>viac než polovica</strong> tento čas na inú administratívnu prácu, napríklad na odporúčania a tlačivá. Približne 20 % ho presunulo na rovnováhu medzi prácou a súkromím a približne 20 % na vyšetrenie väčšieho počtu pacientov.</p>

<p>Ak sa teda viac než polovica ušetreného času vracia späť do administratívy, prínos nástroja nespočíva v tom, že by zmenšil celkové administratívne bremeno, ale v tom, že časť tohto bremena presunul z menej znesiteľnej formy na znesiteľnejšiu. To je stále zmysluplný prínos, ale je to iné tvrdenie než „AI zapisovač vracia lekárovi čas pre pacienta“.</p>

<h2>Chyby, vynechania a bremeno úprav</h2>

<p>Medzi hlásenými chybami boli homonymické zámeny a preklepy, nesprávne alebo odvodené informácie, ktoré počas stretnutia neodzneli, a vynechania klinicky významných informácií. Posledné dve kategórie sú nebezpečnejšie než preklepy, pretože výsledný text pôsobí plynule a vierohodne.</p>

<p>Ďalším obmedzením je jazyk. Nástroje môžu mať ťažkosti s niektorými prízvukmi a nemusia zachytiť reč tela a neverbálnu komunikáciu, ktoré môžu patriť do záznamu. Prehľadový článok v <em>Canadian Medical Association Journal</em> dodáva, že zapisovače môžu mať problém s rôznymi jazykmi a s dokumentovaním fyzikálneho vyšetrenia.</p>

<p>Praktickým dôsledkom je bremeno úprav. Viac než 75 % respondentov hodnotiaceho prieskumu uviedlo, že záznamy od AI zapisovača často upravuje. Približne 15 % nezaznamenalo podstatnú zmenu v čase dokumentácie a vyše 10 % uviedlo <em>vyššiu</em> administratívnu záťaž, niekedy pre potrebu rozsiahlych úprav, najmä vo viacjazyčnej starostlivosti, alebo pre príliš podrobný výstup, ktorý predĺžil kontrolu.</p>

<p>V samostatnom prieskume organizácie OntarioMD bolo práve bremeno úprav najčastejším dôvodom, prečo lekári, ktorí o nástrojoch vedeli, ich nikdy nepoužili (30 %), pred nákladmi a časom na nastavenie (po 28 %) a obavami o súkromie (25 %). V tom istom prieskume malo skúsenosť aspoň s jedným nástrojom umelej inteligencie 67 % oslovených a s AI zapisovačom 58 %.</p>

<h2>Prílišné spoliehanie a erózia zručností</h2>

<p>Obavu z prílišného spoliehania na umelú inteligenciu uviedlo <strong>47 % lekárov</strong> v prieskume OntarioMD. V otvorených odpovediach sa opisovala erózia kritického myslenia, vplyv na lekárov v príprave a znížená pozornosť pri kontrole výstupu. Jeden z respondentov to zhrnul tak, že pri príliš rýchlom zavedení tejto technológie bez zváženia rizík môže vyrásť generácia mladých lekárov, ktorá si nikdy plne nerozvinie schopnosť kritického myslenia.</p>

<p>Je to názor z dotazníka, nie meraný výsledok. Je však konzistentný s tým, čo hodnotenie meralo: ak nástroj produkuje plynulý a vierohodný text, pozornosť kontrolujúceho prirodzene klesá. Riziko nie je v tom, že by nástroj robil veľa chýb, ale v tom, že robí málo chýb pôsobiacich veľmi presvedčivo.</p>

<h2>Súhlas, súkromie a zodpovednosť</h2>

<p>Kanadská asociácia na ochranu lekárov odporúča získať informovaný súhlas pacienta pred použitím zapisovača a tento súhlas zdokumentovať, pričom to nemusí znamenať podrobný rozhovor pri každom jednom kontakte. Lekár má zároveň vedieť, kam sa zaznamenané informácie dostanú, ako sa používajú a ako dlho sa uchovávajú, čo sa líši podľa dodávateľa. Viaceré kanadské profesijné regulačné orgány dnes informovaný súhlas pri dokumentácii podporenej umelou inteligenciou vyžadujú.</p>

<p>V hodnotení Infoway považovalo proces súhlasu za priamočiary 85,4 % lekárov, ale spoliehanie sa na procesy vytvorené dodávateľom a absencia celoštátnych a regionálnych štandardizovaných politík vytvárali neefektívnosť.</p>

<p>V otázke zodpovednosti sa oslovení odborníci zhodli: zodpovednosť za konečný záznam nesie lekár, ktorý ho skontroluje a podpíše. Prirovnanie, ktoré zaznelo, je výstižné. Ak nástroj niečo vynechá, je to ako keď medik vynechá dôležitý údaj, ktorý musí lekár neskôr doplniť.</p>

<p>Zaznela však aj dôležitá protiváha: dodávatelia a zdravotné systémy nesú spoluzodpovednosť za spoľahlivé systémy, politiky, školenie a ochranné opatrenia, aby lekári neboli vystavení nerealistickému očakávaniu, že sami musia odhaliť a zmierniť každú možnú systémovú chybu. Ak by lekári niesli plnú zodpovednosť za preverenie nástrojov, prínosy týchto technológií sa pre averziu k riziku nemusia vôbec dostaviť.</p>

<h2>Čo z toho platí v slovenskom právnom rámci</h2>

<p>Kanadské odporúčania sa prenášajú len čiastočne. Slovenské prostredie má vlastné a v niektorých ohľadoch prísnejšie pravidlá, ktoré treba zvážiť pred nasadením, nie po ňom.</p>

<p><strong>Kto vykonáva zápis.</strong> Podľa § 21 ods. 3 zákona č. 576/2004 Z. z. o zdravotnej starostlivosti obsahuje zápis do zdravotnej dokumentácie okrem iného identifikáciu ošetrujúceho zdravotníckeho pracovníka a osobitne aj identifikáciu osoby určenej poskytovateľom podľa § 18 ods. 1, ktorá zápis vykonala. Zákon teda už dnes počíta s tým, že zápis môže fyzicky vyhotoviť niekto iný než ošetrujúci lekár, ale touto osobou je <em>určená osoba</em>, nie nástroj. Výstup AI zapisovača je preto z právneho hľadiska podklad, ktorý si ako vlastný zápis privlastňuje identifikovaný človek.</p>

<p><strong>Oprava záznamu.</strong> Podľa § 21 ods. 2 sa oprava elektronického zdravotného záznamu vykonáva stornovaním pôvodného záznamu, opravu môže vykonať len ten zdravotnícky pracovník, ktorý pôvodný záznam vytvoril, a pôvodný záznam zostáva uložený v elektronickej zdravotnej knižke na účely kontroly správnosti poskytnutej zdravotnej starostlivosti. Nesprávny záznam sa teda nedá ticho prepísať; zostane viditeľný. To posúva ťažisko kontroly pred podpis, nie po ňom, a robí z dôslednej revízie pred vložením do dokumentácie nie odporúčanie, ale praktickú nevyhnutnosť.</p>

<p><strong>Ochrana údajov.</strong> Nahrávanie rozhovoru s pacientom je spracúvaním údajov o zdraví, teda osobitnej kategórie osobných údajov podľa čl. 9 všeobecného nariadenia o ochrane údajov. Dodávateľ nástroja je spravidla sprostredkovateľom, čo vyžaduje zmluvu podľa čl. 28. Pri systematickom spracúvaní osobitnej kategórie údajov vo veľkom rozsahu prichádza do úvahy posúdenie vplyvu na ochranu údajov podľa čl. 35. Ak sa údaje spracúvajú alebo ukladajú mimo Európskeho hospodárskeho priestoru, uplatňujú sa záruky podľa kapitoly V nariadenia.</p>

<p>Pred nasadením treba preto vedieť odpovedať na konkrétne otázky: čo presne sa prenáša (zvuk, prepis, alebo oboje), kde sa spracúva, ako dlho sa uchováva, či sa údaje používajú na trénovanie modelu, a na akom právnom základe. Odpovede patria do zmluvy s dodávateľom, nie do marketingových materiálov.</p>

<p><strong>Nariadenie o umelej inteligencii.</strong> Nariadenie (EÚ) 2024/1689 zavádza stupňované povinnosti podľa rizikovej kategórie a jeho jednotlivé časti nadobúdajú účinnosť postupne. Zaradenie konkrétneho nástroja závisí od toho, či ide len o dokumentačnú podporu, alebo či nástroj zasahuje do klinického rozhodovania, prípadne či je súčasťou zdravotníckej pomôcky. Posúdenie preto nemožno urobiť paušálne pre „AI zapisovače“ ako triedu a pred nasadením je namieste overiť aktuálny stav povinností.</p>

<h2>Čo to znamená v nefrológii</h2>

<p>Nefrologická dokumentácia má vlastnosti, pre ktoré je chybovosť zapisovača rizikovejšia než v mnohých iných odboroch.</p>

<ul>
  <li><strong>Čísla rozhodujú o liečbe.</strong> Dávka, interval, cieľová hodnota, hmotnosť pacienta, rýchlosť ultrafiltrácie, koncentrácia draslíka, hodnota eGFR. Homonymická zámena je v texte nápadná; zámena číslice nie je.</li>
  <li><strong>Hodnoty sa nesú v čase.</strong> Nefrologický záznam sa číta ako séria. Jedna nesprávne prepísaná hodnota sa pri ďalších kontrolách preberá ako východisko a chyba sa reprodukuje.</li>
  <li><strong>Dialyzačný predpis je viacpoložkový.</strong> Zloženie roztoku, antikoagulácia, trvanie, prietoky, cieľová hmotnosť. Vynechanie jednej položky z návrhu zápisu sa pri kontrole prehliadne ľahšie než pri súvislom texte.</li>
  <li><strong>Fyzikálne vyšetrenie.</strong> Posúdenie objemového stavu, stav cievneho prístupu vrátane vírenia a šelestu, opuchy, stav vpichov. Toto je presne tá oblasť, pri ktorej prehľadová práca uvádza, že zapisovače majú ťažkosti, pretože lekár ju často nekomentuje nahlas.</li>
  <li><strong>Jazyková rôznorodosť.</strong> V dialyzačnom prostredí je bežná komunikácia s pacientmi, ktorých prejav je ovplyvnený vekom, nedoslýchavosťou alebo iným materinským jazykom. Práve tam hodnotenie zaznamenalo najväčšie bremeno úprav.</li>
</ul>

<p>Z toho vyplýva praktický návrh: ak sa nástroj zavádza, treba vopred určiť zoznam položiek, ktoré sa pred podpisom kontrolujú vždy a bodovo, nie čítaním celého textu. Minimálne liekový zoznam a dávky, alergie, kľúčové laboratórne hodnoty, dialyzačný predpis a opis cievneho prístupu. Priebežne je vhodné auditovať nie spokojnosť používateľov, ale zhodu zápisu so skutočnosťou na vzorke záznamov.</p>

<h2>Záver</h2>

<p>Kanadské hodnotenie je zatiaľ najlepší dostupný podklad o tom, ako sa AI zapisovače správajú v bežnej praxi, a je užitočné práve tým, že nezamlčiava nepriaznivé zistenia. Prínos v znížení vnímanej záťaže je konzistentný a nie zanedbateľný. Zároveň viac než polovica ušetreného času skončila späť v administratíve, viac než 75 % lekárov záznamy často upravuje, vyše 10 % hlási vyššiu záťaž a takmer polovica má obavu z prílišného spoliehania.</p>

<p>Rozumný postoj preto nie je ani odmietnutie, ani nekritické prijatie. Je to nasadenie s vopred vyriešeným súhlasom, vyriešenou ochranou údajov, definovanými kontrolnými bodmi pred podpisom a s vedomím, že výstup je návrh, nie záznam. V slovenskom prostredí to platí o to viac, že nesprávny záznam sa po vložení do elektronickej zdravotnej knižky už nedá odstrániť, len stornovať, a pôvodná verzia zostáva uložená.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom a vedúcim pracovníkom zdravotníckych zariadení. Nie je právnym stanoviskom ani posúdením súladu konkrétneho produktu s právnymi predpismi. Citované ustanovenia boli overené v znení účinnom v čase publikovania; pred praktickým použitím overte aktuálne znenie na portáli Slov-Lex a v prípade potreby konzultujte zodpovednú osobu pre ochranu osobných údajov a právnika.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Larkin Marilynn. AI Scribes in Canada: Benefits, Concerns, and Safeguards. <em>Medscape News Canada</em>, 22. októbra 2026. Vyjadrenia Onila Bhattacharyyu (Women's College Hospital Institute for Health System Solutions and Virtual Care, Toronto), Roberta Johnstona (Canadian Medical Protective Association) a Boluwajiho Ogunyemiho (Canadian Medical Association). <a href="https://www.medscape.com/viewarticle/ai-scribes-canada-benefits-concerns-and-safeguards-2026a10013sd" target="_blank" rel="noopener noreferrer">Celá správa</a>.</em></small></p>

<p><small><em>2. Canada Health Infoway. AI Scribe Program. Programová stránka a hodnotiaca správa. <a href="https://www.infoway-inforoute.ca/en/featured-initiatives/ai-scribe-program" target="_blank" rel="noopener noreferrer">infoway-inforoute.ca</a>.</em></small></p>

<p><small><em>3. Canadian Medical Protective Association. AI Scribes: Answers to frequently asked questions. <a href="https://www.cmpa-acpm.ca/en/advice-publications/browse-articles/2023/ai-scribes-answers-to-frequently-asked-questions" target="_blank" rel="noopener noreferrer">cmpa-acpm.ca</a>.</em></small></p>

<p><small><em>4. Zákon č. 576/2004 Z. z. o zdravotnej starostlivosti, službách súvisiacich s poskytovaním zdravotnej starostlivosti a o zmene a doplnení niektorých zákonov v znení neskorších predpisov, § 18 ods. 1, § 20, § 21 ods. 2 a 3. <a href="https://www.slov-lex.sk/ezbierky/pravne-predpisy/SK/ZZ/2004/576/" target="_blank" rel="noopener noreferrer">Slov-Lex</a>.</em></small></p>

<p><small><em>5. Nariadenie Európskeho parlamentu a Rady (EÚ) 2016/679 o ochrane fyzických osôb pri spracúvaní osobných údajov (všeobecné nariadenie o ochrane údajov), čl. 9, čl. 28, čl. 35 a kapitola V. Nariadenie Európskeho parlamentu a Rady (EÚ) 2024/1689, ktorým sa stanovujú harmonizované pravidlá v oblasti umelej inteligencie.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky číselné údaje o kanadskom programe, prieskume OntarioMD a vyjadrenia oslovených odborníkov boli overené priamo na verejne prístupnej stránke zdrojovej správy, vrátane mena autorky v byline. Ide o novinársku správu o hodnotiacej správe programu, nie o recenzovanú publikáciu; dôkazová úroveň je zodpovedajúco nižšia a samotná správa uvádza, že dôkazy o vplyve na pracovné postupy a výsledky pacientov sú obmedzené. Znenie § 21 ods. 2 a 3 zákona č. 576/2004 Z. z. bolo overené doslovne v konsolidovanom znení stiahnutom z portálu Slov-Lex.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je zdôraznenie údaja o tom, kam sa ušetrený čas presunul, odlíšenie subjektívneho dotazníkového hodnotenia od merania bezpečnosti a klinických výsledkov, doplnenie slovenského právneho rámca zápisu a opravy zdravotnej dokumentácie vrátane dôsledku nezmazateľnosti stornovaného záznamu, rámec ochrany osobných údajov, a nefrologicky špecifický zoznam položiek, pri ktorých je chybovosť zapisovača najrizikovejšia. Tieto súvislosti nie sú obsiahnuté vo východiskovej správe.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=farmaceuticky-marketing-predpisovanie-liekov-nefrologia">Marketing farmaceutických firiem a predpisovanie liekov</a></li>
  <li><a href="article.php?slug=postmarketingove-bezpecnostne-zlyhania-liekov-fda-ema">Postmarketingové bezpečnostné zlyhania liekov</a></li>
  <li><a href="article.php?slug=skrining-ckd-mlady-dospely-preventivne-odbery">Preventívne odbery u mladého dospelého</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ai-zapisovace-zdravotna-dokumentacia-nefrologia_article',
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