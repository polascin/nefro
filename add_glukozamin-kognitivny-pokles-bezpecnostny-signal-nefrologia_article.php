<?php
/**
 * Odborny clanok o glukozamine, kognitivnom poklese a nefrologickej praxi.
 */

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
    'title'        => 'Glukozamín a kognitívny pokles: bezpečnostný signál, ktorý treba čítať opatrne',
    'slug'         => 'glukozamin-kognitivny-pokles-bezpecnostny-signal-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nová štúdia spojila glukozamín s horšou prognózou pri kognitívnej poruche, neskoršia reanalýza však spochybnila špecificitu signálu. Čo dôkazy znamenajú pre nefrológa?',
    'content'      => <<<'HTML'
<figure><a href="img/glukozamin-kognitivny-pokles-bezpecnostny-signal-nefrologia.webp" rel="noopener noreferrer" target="_blank"><img src="img/glukozamin-kognitivny-pokles-bezpecnostny-signal-nefrologia.webp" alt="Polopriesvitný mozog a oblička prepojené sieťou molekúl okolo neoznačenej kapsuly" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna, nie snímka konkrétneho pacienta ani výrobku. Prepojenie mozgu, glukozamínu a obličky znázorňuje skúmanú biologickú hypotézu a potrebu celkového posúdenia liečby, nie dokázanú príčinnú súvislosť.</figcaption></figure>

<p>Glukozamín patrí medzi voľnopredajné prípravky užívané pri kĺbových ťažkostiach. V roku 2026 vyvolala pozornosť práca v časopise <em>Nature Metabolism</em>: v zdravotných záznamoch bolo dokumentované užívanie glukozamínu spojené s častejším prechodom miernej kognitívnej poruchy do demencie a s horším prežívaním pacientov s demenciou. Tá istá práca ukázala zvýšenú N-glykozyláciu v mozgovom tkanive a experimentálne ovplyvnila správanie transgénnych myší. [1]</p>

<p>Tieto vrstvy dôkazov však nemožno zlúčiť do vety „glukozamín spôsobuje demenciu“. Klinická časť bola retrospektívna, expozíciu určoval záznam v dokumentácii a párovanie zohľadnilo iba vek alebo základné demografické premenné. Neskoršia analýza v nezávislej kohorte navyše ukázala, že podobný signál progresie sprevádzal aj záznamy o iných doplnkoch, a po adjustácii nepotvrdila vyššiu mortalitu pri glukozamíne. Ide zatiaľ o nerecenzovaný preprint, no oslabuje predstavu špecifického klinického účinku. [2]</p>

<p>Pre nefrológa nie je bezprostredným dôsledkom plošný zákaz. Dôležitá je presná lieková anamnéza vrátane doplnkov, individuálne posúdenie prínosu a rizika a otvorená diskusia najmä pri už existujúcej kognitívnej poruche. Nová štúdia neposkytla údaje podľa eGFR, albuminúrie, dialýzy ani transplantácie.</p>

<h2>Čo vlastne skúmala práca v Nature Metabolism</h2>

<p>Hawkinsonová a spoluautori spojili štyri výskumné prístupy: priestorovú metabolomiku, lipidomiku a glykomiku posmrtného ľudského mozgového tkaniva, izotopové sledovanie tvorby glykánov, zásahy do glykozylácie v modeloch 5xFAD a PS19 a retrospektívnu analýzu elektronických zdravotných záznamov. [1] Takéto prepojenie zvyšuje biologickú vierohodnosť hypotézy, ale každá časť odpovedá na inú otázku a má odlišné limity.</p>

<p>Úvodné priestorové porovnanie čerstvo zmrazenej frontálnej kôry zahŕňalo tri vzorky s Alzheimerovou chorobou a tri kontrolné vzorky. Pri niektorých analýzach sa tisíce obrazových bodov uvádzali ako dátové body, tie však nie sú tisíckami nezávislých pacientov. Nálezy sa ďalej overovali vo väčšom súbore tkanív podľa Braakovho štádia. V sivej hmote viaceré N-glykány pribúdali s pokročilosťou neuropatologických zmien; v bielej hmote sa zvýšenie objavilo skôr a v neskorých štádiách nepokračovalo. [1]</p>

<p>Posmrtné prierezové vzorky neukazujú časový vývoj u toho istého človeka a samy osebe neurčujú, či zmena glykozylácie bola príčinou, následkom alebo sprievodným javom ochorenia.</p>

<h2>Glykozylácia nie je glykácia</h2>

<p><strong>Glykozylácia</strong> je enzýmovo riadené pripájanie sacharidových štruktúr k proteínom alebo lipidom. N-glykozylácia je fyziologicky nevyhnutná pre skladanie proteínov, ich stabilitu, transport a bunkovú signalizáciu. Patologická môže byť jej nesprávna regulácia, nie samotná existencia.</p>

<p><strong>Glykácia</strong> je naopak neenzýmová reakcia redukujúcich sacharidov s biomolekulami, ktorá súvisí aj so vznikom konečných produktov pokročilej glykácie (AGE). Práca z roku 2026 neskúmala diabetickú nefropatiu ani nepreukázala, že klinický signál sprostredkúvajú AGE. [1]</p>

<p>Autori navyše pozorovali zvýšenú N-glykozyláciu súčasne so zníženou O-GlcNAcyláciou a menším množstvom kyseliny hyalurónovej v skúmaných modeloch. Nie je teda správne zhrnúť výsledok ako dôkaz, že „všetka glykozylácia je škodlivá“.</p>

<h2>Experiment podporuje mechanizmus, nie klinické odporúčanie</h2>

<p>Genetické zníženie expresie enzýmu PGM3 a farmakologická inhibícia N-glykozylácie zlepšili sociálnu pamäť v transgénnych myších modeloch. Glukozamín podávaný sondou počas dvoch týždňov v dávke 457 mg/kg/deň zvýšil N-glykány a zhoršil sociálnu pamäť u 5xFAD myší. Skupiny však boli malé: pri behaviorálnom porovnaní išlo o šesť liečených a sedem kontrolných zvierat. U zdravých myší rovnaký zásah nezhoršil sociálnu pamäť. [1]</p>

<p>Transgénne modely zachytávajú iba vybrané časti ľudskej neurodegenerácie. Krátky experiment s modelovou dávkou prepočítanou z ľudskej dávky približne 2 500 mg/deň nemôže určiť riziko bežného dlhodobého užívania u človeka. Ani inhibítory glykozylácie z tejto práce nie sú pripravenou liečbou demencie.</p>

<h2>Klinický signál: čo ukázali zdravotné záznamy</h2>

<p>Analýza databázy UF Health z rokov 2012 až 2024 zahrnula 24 481 pacientov s Alzheimerovou chorobou alebo príbuznými demenciami (ADRD) a 41 884 pacientov s miernou kognitívnou poruchou. Záznam o glukozamíne malo 1 896 pacientov s ADRD a 2 750 pacientov s miernou kognitívnou poruchou, približne 8 % v oboch skupinách. Medián sledovania bol 1 835 dní, teda približne päť rokov. [1]</p>

<div class="table-responsive" role="region" aria-label="Klinické výsledky a ich interpretácia" tabindex="0">
<table>
<thead><tr><th scope="col">Populácia</th><th scope="col">Uvádzaný výsledok</th><th scope="col">Čo možno uzavrieť</th></tr></thead>
<tbody>
<tr><th scope="row">Mierna kognitívna porucha</th><td>O 25 % vyšší podiel prechodu do ADRD pri zázname o glukozamíne (p &lt; 0,0010)</td><td>Relatívna observačná asociácia; absolútne riziko, interval spoľahlivosti ani kauzalita neboli v texte práce presvedčivo vyčíslené</td></tr>
<tr><th scope="row">ADRD</th><td>O 25 % vyššie riziko úmrtia pri zázname o glukozamíne (p = 0,0023)</td><td>Asociácia celkovej mortality, nie priame meranie rýchlosti kognitívneho poklesu</td></tr>
<tr><th scope="row">Mierna kognitívna porucha</th><td>Bez významného rozdielu v mortalite (log-rank p = 0,252)</td><td>Výsledok nepodporuje všeobecný mortalitný účinok vo všetkých sledovaných skupinách</td></tr>
</tbody>
</table>
</div>

<p>Percentuálne údaje sú relatívne, nie zvýšením absolútneho rizika o 25 percentuálnych bodov. Autori identifikovali expozíciu vyhľadávaním kľúčových slov v lekárskych poznámkach a záznamoch o liekoch. Zmienka v dokumentácii nemusí spoľahlivo určovať dávku, liekovú formu, adherenciu ani dĺžku užívania. Párovanie 1 : 1 zohľadňovalo iba vek alebo demografické premenné. Nezahŕňalo závažnosť artrózy a bolesti, mobilitu, krehkosť, komorbidity, funkčný stav, sociálnu podporu ani celú súbežnú liečbu. [1]</p>

<p>Aj časové zaradenie expozície je problematické: užívateľ bol definovaný dokumentovaným užívaním najmenej rok po diagnóze demencie. Bez dôkladného časovo závislého modelovania môže takáto definícia vytvoriť skreslenie a neumožňuje jednoduché príčinné čítanie Kaplanových-Meierových kriviek.</p>

<h2>Neskoršia reanalýza spochybnila špecificitu signálu</h2>

<p>Nakashima a spoluautori analyzovali nezávislé údaje National Alzheimer’s Coordinating Center. Pri progresii z miernej kognitívnej poruchy do primárnej Alzheimerovej demencie našli pri zázname o glukozamíne odhad v rovnakom smere ako pôvodná práca. Podobné odhady však sprevádzali aj záznamy o multivitamínoch a o vápniku alebo vitamíne D. U pacientov s demenciou sa po adjustácii nepotvrdila vyššia mortalita spojená s glukozamínom. [2]</p>

<p>Táto analýza je preprint bez recenzného konania a má vlastné obmedzenia vrátane údajov o úmrtiach. Nevyvracia tkanivové ani zvieracie experimenty. Ukazuje však, že samotný záznam o doplnku môže označovať intenzitu zdravotnej starostlivosti, rodinnú podporu, komorbidity alebo iné vlastnosti pacienta a nemusí predstavovať špecifický účinok glukozamínu.</p>

<p>Obraz komplikuje aj prospektívna UK Biobank. V dvoch veľkých observačných analýzach sa zvyčajné užívanie glukozamínu spájalo s <em>nižším</em> výskytom demencie; v jednej bol plne adjustovaný pomer rizík 0,87 (95 % CI 0,82–0,93), v druhej 0,84 (95 % CI 0,75–0,93). [3, 4] Ani tieto opačne orientované výsledky nedokazujú ochranu. Poukazujú na rozdielne populácie, definície expozície a závažné reziduálne zmätenie pri výskume doplnkov.</p>

<h2>Čo je a čo nie je známe pri chorobe obličiek</h2>

<p>Práca Hawkinsonovej a spoluautorov neuvádza výsledky podľa eGFR, albuminúrie, dialýzy alebo transplantácie a neposudzuje farmakokinetiku pri zníženej funkcii obličiek. Nemožno z nej odvodiť, že neurologické riziko je pri CKD vyššie, ani že glukozamín sa pri zlyhaní obličiek akumuluje alebo odstraňuje dialýzou. [1]</p>

<p>Samostatná renálna bezpečnostná základňa je riedka. Publikované sú ojedinelé kazuistiky intersticiálnej nefritídy. V jednej biopsiou dokumentovanej kazuistike sa po vysadení glukozamínu eGFR čiastočne zlepšila a po opätovnom nasadení znovu klesla; takáto pozitívna reexpozícia podporuje súvislosť v danom prípade, neurčuje však populačnú incidenciu. [5]</p>

<p>Mendelovská randomizačná štúdia opísala spojenie genetickej náchylnosti k užívaniu glukozamínu s veľmi malým poklesom eGFR, no genetický nástroj pre správanie „užíva doplnok“ nie je ekvivalentom koncentrácie alebo dávky glukozamínu a výsledok nemožno použiť na klinické dávkovanie. [6] Naopak, observačná analýza UK Biobank zistila nižšiu albuminúriu medzi užívateľmi, ale genetická analýza kauzálny účinok na albuminúriu nepodporila. [7] Súbor údajov je teda rozporný a neumožňuje vyhlásiť renálnu škodlivosť ani renoprotekciu.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<ol>
  <li><strong>Zaznamenať konkrétny prípravok.</strong> Názov, formu glukozamínu, dávku, kombináciu s chondroitínom alebo inými látkami, dĺžku užívania a skutočný dôvod nasadenia.</li>
  <li><strong>Overiť merateľný prínos.</strong> Dlhodobé užívanie bez rozpoznateľného účinku na bolesť alebo funkciu má slabý pomer prínosu k neistote.</li>
  <li><strong>Posúdiť kognitívny stav a rozhodovanie.</strong> Pri miernej kognitívnej poruche alebo demencii vysvetliť, že existuje biologicky vierohodný, ale zatiaľ nekauzálny a neskôr spochybnený klinický signál.</li>
  <li><strong>Skontrolovať funkciu obličiek a časový priebeh.</strong> Pri nevysvetlenom zhoršení funkcie obličiek zahrnúť medzi možné expozície aj doplnky; ojedinelá kazuistika nie je dôvodom pripísať každé zhoršenie glukozamínu.</li>
  <li><strong>Rozhodnúť spoločne.</strong> Ak prínos nie je zrejmý, je rozumné zvážiť skúšobné vysadenie a následne zhodnotiť kĺbové ťažkosti. Náhla náhrada nesteroidovým antiflogistikom môže byť pri CKD podstatne rizikovejšia.</li>
</ol>

<p>Ide o opatrný klinický úsudok, nie o nové odporúčanie nefrologickej alebo neurologickej odbornej spoločnosti. U pacienta bez kognitívnej poruchy údaje z roku 2026 nepreukazujú, že glukozamín zvyšuje riziko vzniku demencie. U pacienta s miernou kognitívnou poruchou alebo demenciou je primerané neistotu pomenovať a prehodnotiť pokračovanie podľa skutočného prínosu.</p>

<h2>Limity dôkazov</h2>

<ul>
  <li>ľudské tkanivové súbory boli malé a priestorové pixely nie sú nezávislí pacienti;</li>
  <li>zvieracie behaviorálne experimenty mali malé skupiny a krátke trvanie;</li>
  <li>klinická analýza bola retrospektívna, expozíciu určovala dokumentácia a kontrola zmätenia bola obmedzená;</li>
  <li>pôvodná práca neuviedla dostatok údajov na výpočet absolútneho nárastu rizika;</li>
  <li>nezávislá reanalýza, ktorá signál oslabila, ešte neprešla recenzným konaním;</li>
  <li>staršie kohorty sledovali prevažne vznik demencie u ľudí bez diagnózy, nie progresiu už prítomnej neurodegenerácie;</li>
  <li>chýbajú randomizované údaje o kognitívnych výsledkoch a osobitné údaje pre CKD G4–G5, dialýzu a transplantáciu.</li>
</ul>

<h2>Záver</h2>

<p>Práca z roku 2026 priniesla zaujímavý mechanistický koncept: dysregulovaná N-glykozylácia môže byť súčasťou neurodegenerácie a jej zvýšenie glukozamínom zhoršilo sociálnu pamäť v malom myšom experimente. Klinická asociácia v zdravotných záznamoch je však oveľa slabším článkom dôkazového reťazca. Neskoršia nezávislá analýza spochybnila jej špecificitu a staršie veľké kohorty priniesli opačné asociácie.</p>

<p>Najpresnejší klinický záver preto znie: nejde o dokázanú príčinu demencie ani o osobitne preukázané riziko pri CKD. Ide o bezpečnostný signál hodný ďalšieho výskumu a o dobrý dôvod nepovažovať voľnopredajný doplnok automaticky za bezvýznamnú súčasť liečby.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne posúdenie pacienta, aktuálny súhrn charakteristických vlastností konkrétneho lieku ani neurologické, geriatrické alebo nefrologické vyšetrenie. Pacient nemá bez konzultácie nahrádzať glukozamín nesteroidovým antiflogistikom, najmä pri chorobe obličiek.</em></p>

<h2>Literatúra</h2>

<ol>
  <li><em>Hawkinson TR, Liu Z, Ribas RA, et al. Hyperglycosylation is a metabolic driver of Alzheimer's disease. Nat Metab. 2026;8(6):1410–1425. doi: <a href="https://doi.org/10.1038/s42255-026-01538-4" target="_blank" rel="noopener noreferrer">10.1038/s42255-026-01538-4</a>. PMID: 42265388. PMCID: PMC13303091. <a href="https://pubmed.ncbi.nlm.nih.gov/42265388/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13303091/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>Nakashima S, Sato K, Niimi Y, Satake W, Iwatsubo T. Comparator supplement patterns qualify the clinical interpretation of an EHR-derived glucosamine signal in Alzheimer's disease. medRxiv [preprint]. 2026;2026.07.23.26358748. doi: <a href="https://doi.org/10.64898/2026.07.23.26358748" target="_blank" rel="noopener noreferrer">10.64898/2026.07.23.26358748</a>. PMID: 42619916. PMCID: PMC13484311. <a href="https://pubmed.ncbi.nlm.nih.gov/42619916/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Xu C, Hou Y, Fang X, Yang H, Cao Z. The role of type 2 diabetes in the association between habitual glucosamine use and dementia: a prospective cohort study. Alzheimers Res Ther. 2022;14(1):184. doi: <a href="https://doi.org/10.1186/s13195-022-01137-x" target="_blank" rel="noopener noreferrer">10.1186/s13195-022-01137-x</a>. PMID: 36514123. PMCID: PMC9746022.</em></li>
  <li><em>Zheng J, Ni C, Zhang Y, Huang J, Hukportie DN, Liang B, Tang S. Association of regular glucosamine use with incident dementia: evidence from a longitudinal cohort and Mendelian randomization study. BMC Med. 2023;21(1):114. doi: <a href="https://doi.org/10.1186/s12916-023-02816-8" target="_blank" rel="noopener noreferrer">10.1186/s12916-023-02816-8</a>. PMID: 36978077. PMCID: PMC10052856.</em></li>
  <li><em>Gueye S, Saint-Cricq M, Coulibaly M, et al. Chronic tubulointerstitial nephropathy induced by glucosamine: a case report and literature review. Clin Nephrol. 2016;86(2):106–110. doi: <a href="https://doi.org/10.5414/CN108781" target="_blank" rel="noopener noreferrer">10.5414/CN108781</a>. PMID: 27397418.</em></li>
  <li><em>Cho JM, Koh JH, Kim SG, et al. Causal Effect of Chondroitin, Glucosamine, Vitamin, and Mineral Intake on Kidney Function: A Mendelian Randomization Study. Nutrients. 2023;15(15):3318. doi: <a href="https://doi.org/10.3390/nu15153318" target="_blank" rel="noopener noreferrer">10.3390/nu15153318</a>. PMID: 37571255. PMCID: PMC10421197.</em></li>
  <li><em>Hayward SJL, Constantinescu A, Hazelwood E, Butler MJ, Vincent EE, Satchell SC. Association between glucosamine use and albuminuria in the UK: a cohort and Mendelian randomisation study. BMJ Open. 2025;15(11):e096344. doi: <a href="https://doi.org/10.1136/bmjopen-2024-096344" target="_blank" rel="noopener noreferrer">10.1136/bmjopen-2024-096344</a>. PMID: 41271412. PMCID: PMC12658525.</em></li>
  <li><em>Brooks M. Popular Joint Supplement Tied to Faster AD Progression. Medscape Medical News. 16. júna 2026. <a href="https://www.medscape.com/viewarticle/popular-joint-supplement-tied-faster-ad-progression-2026a1000k79" target="_blank" rel="noopener noreferrer">Zdrojová správa</a>.</em></li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Primárna práca vrátane metód, obrázkov, zdrojových dát a doplnkov bola overená v plnom texte; bibliografické údaje a úplný autorský zoznam boli porovnané s PubMed. Článok zohľadňuje aj neskorší nerecenzovaný preprint, dve veľké prospektívne kohorty s opačným smerom asociácie a samostatné renálne zdroje. Presná 25 % miera v pôvodnej práci nie je označená ako hazard ratio ani doplnená o interval spoľahlivosti, preto ju text neprezentuje ako presný individuálny odhad rizika. Nefrologická interpretácia a praktický postup sú redakčným spracovaním uvedených dôkazov, nie stanoviskom odbornej spoločnosti.</em></p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek postihuje aj mozog: kognitívne poruchy a cievne poškodenie</a></li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">CKD ako samostatný faktor polyfarmácie</a></li>
  <li><a href="article.php?slug=neziaduce-ucinky-statinov-dokazy-nefrologia">Nežiaduce účinky statínov: čo ukazujú dôkazy a čo je dôležité v nefrológii</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_glukozamin-kognitivny-pokles-bezpecnostny-signal-nefrologia_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <ul><?php foreach ($articles as $a): ?><li><strong><?= htmlspecialchars($a['title']) ?></strong> (slug: <code><?= htmlspecialchars($a['slug']) ?></code>)</li><?php endforeach; ?></ul>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>&nbsp;<a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
