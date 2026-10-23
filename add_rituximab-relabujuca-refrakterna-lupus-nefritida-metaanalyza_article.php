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
    'title' => 'Rituximab pri relabujúcej a refraktérnej lupusovej nefritíde: čo metaanalýza dokladá a čo nie',
    'slug' => 'rituximab-relabujuca-refrakterna-lupus-nefritida-metaanalyza',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Metaanalýza 19 štúdií so 445 pacientmi uvádza renálnu odpoveď približne u dvoch tretín. Bez komparátora však číslo nehovorí o účinnosti: v štúdii LUNAR odpovedalo 45,8 % pacientov na placebo.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/rituximab-relabujuca-refrakterna-lupus-nefritida-metaanalyza.webp" type="image/webp">
    <img src="img/rituximab-relabujuca-refrakterna-lupus-nefritida-metaanalyza.png" alt="Polopriesvitny rez oblickou v tme, jeden zapaleny glomerulus ziari jantarovym svetlom a okolo neho protilatky rozpustaju imunitne bunky" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna deplécie B-lymfocytov protilátkou proti CD20. Nejde o mikroskopický nález ani o zobrazenie konkrétneho pacienta.</figcaption>
</figure>

<p>Relabujúca a refraktérna lupusová nefritída zostáva jedným z najťažšie zvládnuteľných fenotypov systémového lupus erythematosus. Aj pri moderných imunosupresívnych schémach pretrváva nedostatočná alebo neudržateľná renálna odpoveď, zvyšková proteinúria a postupné hromadenie chronického poškodenia obličiek.</p>

<p>Rituximab, chimérna monoklonálna protilátka proti CD20, sa v tejto situácii používa ako záchranná alebo pridaná liečba, hoci na lupusovú nefritídu nemá registrovanú indikáciu. V októbri 2026 vyšla v časopise <em>Clinical and Translational Science</em> prvá systematická kvantitatívna syntéza renálnych výsledkov presne v tejto cieľovej populácii. Výsledok znie priaznivo: renálnu odpoveď dosiahli približne dve tretiny pacientov. Otázka, ktorú treba položiť hneď za tým, znie: dve tretiny v porovnaní s čím?</p>

<h2>Čo autori hodnotili</h2>

<p>Prehľadávané boli databázy PubMed, Embase a Web of Science od ich vzniku do 30. marca 2026. Zaradené boli pôvodné klinické štúdie u pacientov s relabujúcou alebo refraktérnou lupusovou nefritídou liečených režimom založeným na rituximabe, ak uvádzali extrahovateľné renálne výstupy. Vylúčené boli práce o novodiagnostikovanej lupusovej nefritíde bez samostatne extrahovateľných údajov pre cieľovú populáciu a výlučne pediatrické súbory.</p>

<p>Primárnymi ukazovateľmi boli kompletná renálna odpoveď (CRR), parciálna renálna odpoveď (PRR) a celková renálna odpoveď (ORR) v časových bodoch 6, 12 a 24 mesiacov. Sekundárnymi ukazovateľmi boli zmena proteinúrie, štandardizovaná na ekvivalent gramov za deň, a zmena sérového kreatinínu v µmol/l. Použitý bol model náhodných efektov.</p>

<p>Zaradených bolo <strong>19 štúdií so 445 pacientmi</strong>. Väčšinu tvorili observačné kohorty; dve randomizované štúdie prispeli iba ramenom s rituximabom, teda údajmi bez priameho komparátora. Metodická kvalita bola hodnotená nekomparatívnou verziou nástroja MINORS, ktorý je určený práve pre jednoramenné súbory.</p>

<h2>Výsledky</h2>

<div class="table-responsive" role="region" aria-label="Zlúčené miery renálnej odpovede po liečbe rituximabom" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">6 mesiacov</th><th scope="col">12 mesiacov</th><th scope="col">24 mesiacov</th></tr></thead>
  <tbody>
    <tr><th scope="row">Celková odpoveď (ORR)</th><td>0,67 (0,52–0,80)</td><td>0,70 (0,51–0,86)</td><td>0,66 (0,43–0,86)</td></tr>
    <tr><th scope="row">Kompletná odpoveď (CRR)</th><td>0,33 (0,21–0,46)</td><td>0,41 (0,28–0,54)</td><td>0,42 (0,26–0,60)</td></tr>
    <tr><th scope="row">Parciálna odpoveď (PRR)</th><td>0,29 (0,16–0,45)</td><td>0,23 (0,07–0,46)</td><td>0,19 (0,07–0,34)</td></tr>
    <tr><th scope="row">Počet štúdií pre ORR</th><td>10</td><td>7</td><td>6</td></tr>
    <tr><th scope="row">Heterogenita I² pre ORR</th><td>75,1 %</td><td>85,0 %</td><td>79,5 %</td></tr>
  </tbody>
</table>
</div>

<p>Hodnoty v zátvorkách sú 95 % intervaly spoľahlivosti. Celková odpoveď zostávala v čase stabilná okolo dvoch tretín, kompletná odpoveď mierne narastala z približne jednej tretiny na dve pätiny a parciálna odpoveď klesala, čo je očakávané: časť pacientov s parciálnou odpoveďou prechádza do kompletnej.</p>

<p>Pri spojitých ukazovateľoch sa proteinúria znížila o <strong>2,69 g/deň</strong> v prepočítanom ekvivalente (95 % IS −3,23 až −2,16; I² 86,4 %) a sérový kreatinín o <strong>11,79 µmol/l</strong> (95 % IS −19,86 až −3,72; I² 58,5 %). Podporná analýza zohľadňujúca východiskové hodnoty dala relatívny pokles kreatinínu o 12,8 % (95 % IS −20,0 % až −5,7 %).</p>

<p>Analýzy s postupným vynechávaním jednotlivých štúdií ukázali stabilitu výsledku proteinúrie, ktorý zostal záporný v rozpätí −2,84 až −2,48 g/deň, a to aj po vyradení jedinej štúdie, ktorá údaje prepočítavala z pomeru bielkovina/kreatinín. Výsledok pri kreatiníne bol menej robustný: zlúčený odhad kolísal od −14,25 do −8,91 µmol/l a v jednom z týchto behov stratil štatistickú významnosť, hoci smer efektu zostal zachovaný. Eggerov test nezistil významné dôkazy publikačného skreslenia pri žiadnom z ukazovateľov, pri malom počte štúdií má však tento test nízku silu.</p>

<h2>Prečo sa dve tretiny nedajú čítať ako účinnosť</h2>

<p>Toto je kľúčové miesto celej práce a autori to sami formulujú jednoznačne: ide o frekvenciu renálnej odpovede po eskalácii založenej na rituximabe, nie o odhad porovnávacej účinnosti voči štandardnej imunosupresii alebo novším cieleným liekom.</p>

<p>Dôvod je dobre ilustrovateľný číslom z jedinej veľkej randomizovanej štúdie rituximabu pri lupusovej nefritíde. V štúdii LUNAR bolo 144 pacientov s triedou III alebo IV randomizovaných na rituximab alebo placebo, pričom <em>obe</em> ramená dostávali mykofenolátmofetil a kortikosteroidy. Celkovú renálnu odpoveď v 52. týždni dosiahlo 56,9 % pacientov v ramene s rituximabom a <strong>45,8 % v ramene s placebom</strong> (p = 0,18). Primárny ukazovateľ splnený nebol.</p>

<p>Takmer polovica pacientov teda odpovedala na samotnú štandardnú liečbu. Zlúčená celková odpoveď 0,67 v jednoramenných súboroch sa proti tomuto pozadiu stráca, najmä preto, že všetci pacienti v zaradených štúdiách dostávali aj sprievodnú imunosupresiu. Prisúdiť odpoveď rituximabu znamená pripísať jednému prvku režimu výsledok, ktorý vytvoril celý režim spolu s prirodzeným priebehom ochorenia a s regresiou k priemeru po vrchole aktivity.</p>

<p>K tomu pristupuje skreslenie indikáciou. Rituximab dostávajú pacienti vybraní lekárom, a tento výber môže ísť oboma smermi: buď k najťažším prípadom, čo odpoveď podhodnocuje, alebo k tým, u ktorých lekár očakáva prínos, čo ju nadhodnocuje. Bez komparátora sa smer tohto skreslenia nedá určiť.</p>

<p>Napokon, počty štúdií prispievajúcich k jednotlivým časovým bodom sú rozdielne: 10 pre šesť mesiacov, 7 pre dvanásť a 6 pre dvadsaťštyri. Krivka „kompletná odpoveď v čase narastá“ preto nespája tých istých pacientov. Časť nárastu môže odrážať jednoducho to, ktoré súbory v danom časovom bode reportovali.</p>

<h2>Heterogenita a podskupiny</h2>

<p>Heterogenita bola vo viacerých zlúčených odhadoch podstatná: I² nad 75 % pri všetkých troch časových bodoch celkovej odpovede a 86,4 % pri proteinúrii. Hodnoty tejto veľkosti znamenajú, že rozdiely medzi štúdiami presahujú to, čo vysvetlí náhoda. Autori ich pripisujú rozdielom vo fenotype pacientov, predchádzajúcej liečbe, sprievodnej imunosupresii, definíciách renálnej odpovede a dĺžke sledovania.</p>

<p>Pri takejto heterogenite je samotný bodový odhad málo informatívny. Užitočnejšie je čítať interval spoľahlivosti: pri celkovej odpovedi v 24. mesiaci siaha od 0,43 do 0,86, čo je rozpätie zlučiteľné s veľmi odlišnými klinickými očakávaniami.</p>

<p>Exploratívne podskupinové analýzy podľa triedy lupusovej nefritídy, spôsobu podania a kombinačného režimu zväčša nepriniesli významné rozdiely. Výnimkou boli spôsob liečby pri kompletnej odpovedi v 6. mesiaci (p = 0,026) a pri parciálnej odpovedi v 6. mesiaci (p &lt; 0,001), trieda lupusovej nefritídy pri celkovej odpovedi v 12. mesiaci (p &lt; 0,001) a pri zmene proteinúrie (p = 0,001) a kombinačný režim pri zmene kreatinínu (p = 0,014). Viaceré z týchto porovnaní stáli na malom počte štúdií, takže ide o generovanie hypotéz, nie o podklad na výber režimu.</p>

<h2>Kde je rituximab v odporúčaniach</h2>

<p>Aktualizácia odporúčaní EULAR pre manažment systémového lupus erythematosus z roku 2023 uvádza rituximab ako možnosť pri refraktérnom alebo orgánovo ohrozujúcom ochorení, nie ako liečbu prvej voľby. Pri aktívnej lupusovej nefritíde zostávajú základom glukokortikoidy v kombinácii s mykofenolátom alebo nízkodávkovaným intravenóznym cyklofosfamidom, s pridanou liečbou podľa klinického kontextu, napríklad belimumabom alebo inhibítorom kalcineurínu.</p>

<p>To zodpovedá populácii, v ktorej metaanalýza pracovala. Rituximab tu vystupuje ako stratégia pri ťažko liečiteľnom priebehu, nie ako univerzálna prvá línia.</p>

<h2>Čo sa medzitým zmenilo: trieda funguje, len s inou molekulou</h2>

<p>Pre rozhodovanie v roku 2026 je dôležité, že deplécia B-lymfocytov pri lupusovej nefritíde už <em>má</em> pozitívny randomizovaný dôkaz. V štúdii fázy 3 REGENCY bolo 271 dospelých s biopticky potvrdenou aktívnou lupusovou nefritídou randomizovaných na obinutuzumab, humanizovanú protilátku proti CD20 typu II, alebo na placebo; obe ramená dostávali mykofenolátmofetil a prednizón s cieľovou dávkou 7,5 mg denne do 12. týždňa a 5 mg denne do 24. týždňa.</p>

<p>Kompletnú renálnu odpoveď v 76. týždni dosiahlo 46,4 % pacientov na obinutuzumabe a 33,1 % na placebe (upravený rozdiel 13,4 percentuálneho bodu; 95 % IS 2,0–24,8; p = 0,02). Kompletná odpoveď pri dávke prednizónu najviac 7,5 mg denne medzi 64. a 76. týždňom bola 42,7 % oproti 30,9 % a pomer bielkovina/kreatinín pod 0,8 bez interkurentnej udalosti 55,5 % oproti 41,9 %. Neočakávané bezpečnostné signály sa nevyskytli, závažných nežiaducich udalostí, najmä infekcií, však bolo pri obinutuzumabe viac.</p>

<p>Klinická otázka sa tým posúva. Nestojí už „rituximab, alebo nič“, ale „ktorý anti-CD20 liek, v akom režime a u ktorého pacienta“. Pri refraktérnom priebehu po zlyhaní základnej liečby zostáva rituximab prakticky dostupnou možnosťou, ale pri rozhodovaní treba vedieť, že jeho vlastná randomizovaná štúdia primárny ukazovateľ nesplnila, zatiaľ čo iná látka z tej istej triedy ho pri aktívnej lupusovej nefritíde splnila.</p>

<h2>Praktické poznámky k podaniu</h2>

<ul>
  <li>Rituximab nemá pre lupusovú nefritídu registrovanú indikáciu. Podanie je použitie mimo schválenej indikácie so všetkými dôsledkami pre informovaný súhlas, dokumentáciu a úhradu.</li>
  <li>Pred začatím liečby patrí ku štandardu skríning hepatitídy B vrátane HBsAg a anti-HBc pre riziko reaktivácie, ďalej vyšetrenie na tuberkulózu a stanovenie východiskových hladín imunoglobulínov.</li>
  <li>Pri opakovaných cykloch treba sledovať hypogamaglobulinémiu a neutropéniu s neskorým nástupom; v štúdii LUNAR sa neutropénia, leukopénia a hypotenzia vyskytovali v ramene s rituximabom častejšie.</li>
  <li>Odpoveď treba hodnotiť v definovaných časových bodoch, pričom kompletná odpoveď býva oneskorená. Rozhodnutie o neúspechu v šiestom mesiaci môže byť predčasné.</li>
  <li>Metaanalýza nepriniesla zlúčené bezpečnostné ani dlhodobé renálne výstupy; tieto údaje neboli v zaradených štúdiách dostupné v podobe vhodnej na zlúčenie.</li>
</ul>

<h2>Limity</h2>

<ol>
  <li>Prevaha observačných a jednoramenných dizajnov. Randomizované štúdie prispeli iba ramenom s rituximabom, takže chýba komparátor a výsledky nemožno čítať ako prírastkovú účinnosť.</li>
  <li>Podstatná heterogenita vo väčšine zlúčených odhadov, vrátane I² nad 75 % pri celkovej odpovedi a 86,4 % pri proteinúrii.</li>
  <li>Variabilita definícií renálnej odpovede, predchádzajúcej liečby a sprievodnej imunosupresie naprieč štúdiami.</li>
  <li>Rozdielny počet štúdií prispievajúcich do jednotlivých časových bodov, takže trend v čase nesleduje tú istú skupinu pacientov.</li>
  <li>Malý počet štúdií vo viacerých podskupinách a nízka sila Eggerovho testu v tomto rozsahu.</li>
  <li>Dlhodobé renálne a bezpečnostné výstupy neboli konzistentne dostupné.</li>
</ol>

<h2>Záver</h2>

<p>Práca je užitočná tým, že po prvý raz kvantifikuje, čo možno očakávať po eskalácii na rituximab pri relabujúcej alebo refraktérnej lupusovej nefritíde: celkovú odpoveď približne u dvoch tretín pacientov, kompletnú odpoveď u jednej tretiny v pol roku a u dvoch pätín v dvoch rokoch, s poklesom proteinúrie aj kreatinínu.</p>

<p>Nedokazuje, že tieto odpovede spôsobil rituximab. Pri rozhodovaní o jednotlivom pacientovi preto váži viac to, čo ukázali randomizované štúdie: rituximab pri aktívnej lupusovej nefritíde svoj primárny ukazovateľ nesplnil, obinutuzumab ho splnil. Rituximab zostáva legitímnou možnosťou pri refraktérnom priebehu, keď základná liečba zlyháva alebo nie je vhodná, ale ako postup bez preukázanej prírastkovej účinnosti, nie ako doložený štandard.</p>

<hr>

<p><small><em><strong>Upozornenie:</strong> Text je určený zdravotníckym pracovníkom. Nenahrádza odborné vyšetrenie, individuálne posúdenie ani platné klinické odporúčania a súhrny charakteristických vlastností liekov. Podanie rituximabu pri lupusovej nefritíde je použitím mimo schválenej indikácie. Dávkovanie, skríning pred liečbou a monitorovanie je nutné overiť v aktuálnom súhrne charakteristických vlastností lieku a v platných odporúčaniach.</em></small></p>

<h2>Literatúra</h2>

<p><small><em>1. Wang Xiaolong, Liang Shuang, Sun Xiaowei, Wang Fuling, Tang Guichun, Deng Weizhu, Li Meng, Wang Qian, Dong Zheyi. Rituximab as Rescue or Add-On Therapy for Relapsing or Refractory Lupus Nephritis: A Systematic Review and Meta-Analysis. <em>Clinical and Translational Science.</em> 2026;19(10):e70730. DOI: <a href="https://doi.org/10.1111/cts.70730" target="_blank" rel="noopener noreferrer">10.1111/cts.70730</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42806593/" target="_blank" rel="noopener noreferrer">PubMed PMID 42806593</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13620286/" target="_blank" rel="noopener noreferrer">PMC13620286</a>, voľný plný text.</em></small></p>

<p><small><em>2. Rovin Brad H., Furie Richard, Latinis Kevin, Looney R. John, Fervenza Fernando C., Sanchez-Guerrero Jorge, Maciuca Romeo, Zhang David, Garg Jay P., Brunetta Paul, Appel Gerald; LUNAR Investigator Group. Efficacy and safety of rituximab in patients with active proliferative lupus nephritis: the Lupus Nephritis Assessment with Rituximab study. <em>Arthritis and Rheumatism.</em> 2012;64(4):1215–1226. DOI: <a href="https://doi.org/10.1002/art.34359" target="_blank" rel="noopener noreferrer">10.1002/art.34359</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/22231479/" target="_blank" rel="noopener noreferrer">PubMed PMID 22231479</a>.</em></small></p>

<p><small><em>3. Furie Richard A., Rovin Brad H., Garg Jay P., Santiago Mittermayer B., Aroca-Martínez Gustavo, Zuta Santillán Adolfina Elizabeth, Alvarez Damaris, Navarro Sandoval Cleyber, Lila Alexander M., Tumlin James A., Saxena Amit, Irazoque Palazuelos Fedra, Raghu Harini, Yoo Bongin, Hassan Imran, Martins Elsa, Sehgal Himanshi, Kirchner Petra, Ross Terres Jorge, Omachi Theodore A., Schindler Thomas, Pendergraft William F., Malvar Ana; REGENCY Trial Investigators. Efficacy and Safety of Obinutuzumab in Active Lupus Nephritis. <em>New England Journal of Medicine.</em> 2025;392(15):1471–1483. DOI: <a href="https://doi.org/10.1056/NEJMoa2410965" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2410965</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39927615/" target="_blank" rel="noopener noreferrer">PubMed PMID 39927615</a>.</em></small></p>

<p><small><em>4. Fanouriakis Antonis, Kostopoulou Myrto, Andersen Jeanette, Aringer Martin, Arnaud Laurent, Bae Sang-Cheol a kolektív (42 autorov). EULAR recommendations for the management of systemic lupus erythematosus: 2023 update. <em>Annals of the Rheumatic Diseases.</em> 2024;83(1):15–29. DOI: <a href="https://doi.org/10.1136/ard-2023-224762" target="_blank" rel="noopener noreferrer">10.1136/ard-2023-224762</a>.</em></small></p>

<h3>Poznámka k dôkazom</h3>

<p><small><em>Všetky číselné údaje o metaanalýze boli overené priamo v plnom texte primárnej práce (PMC13620286) a v jej abstrakte v PubMed, nie v sekundárnych prevzatiach. Úplný autorský zoznam všetkých deviatich autorov, ročník, číslo, číslo článku a DOI boli overené v zázname PubMed. Hodnoty I², počty štúdií prispievajúcich do jednotlivých časových bodov, výsledky analýz s postupným vynechávaním štúdií, Eggerov test a nástroj MINORS pochádzajú z výsledkovej a metodickej časti plného textu. Čísla zo štúdií LUNAR a REGENCY a bibliografické údaje odporúčaní EULAR 2023 boli overené samostatne v PubMed a v databáze Crossref.</em></small></p>

<p><small><em>Vlastným prínosom tohto spracovania je porovnanie zlúčenej celkovej odpovede s mierou odpovede v placebovom ramene štúdie LUNAR, upozornenie na rozdielny počet štúdií v jednotlivých časových bodoch a zaradenie výsledku do kontextu randomizovaného dôkazu pre obinutuzumab. Tieto porovnania nie sú obsiahnuté v primárnej práci.</em></small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kdigo-2024-lupusova-nefritida-klinicka-prax">KDIGO 2024 a lupusová nefritída v klinickej praxi</a></li>
  <li><a href="article.php?slug=porovnanie-usmerneni-lupusova-nefritida-acr-eular-kdigo">Porovnanie odporúčaní ACR, EULAR a KDIGO pri lupusovej nefritíde</a></li>
  <li><a href="article.php?slug=lupusova-nefritida-liecit-hned-biopsiu-co-najskor">Lupusová nefritída: liečiť hneď, biopsiu čo najskôr</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_rituximab-relabujuca-refrakterna-lupus-nefritida-metaanalyza_article',
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