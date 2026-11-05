<?php
/**
 * add_komentar-program-47-kongres-snefs-2026_article.php
 * Komentár k programu 47. kongresu Slovenskej nefrologickej spoločnosti
 * (Jasná, 11. až 13. novembra 2026).
 * Avíza sa pri tomto článku zámerne NEposielajú ('enqueue_newsletter' => false).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nefrológia medzi pokrokom v liečbe a každodennou praxou: komentár k programu 47. kongresu Slovenskej nefrologickej spoločnosti',
    'slug'         => 'komentar-program-47-kongres-snefs-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Program 47. kongresu SNefS v Jasnej spája včasný záchyt, nefroprotekciu a cielenú liečbu s dialýzou, transplantáciou a environmentálnymi témami. Hodnota programu sa ukáže až v tom, čo sa po ňom systematicky prenesie do praxe.',
    'content'      => <<<'HTML'
<figure><a href="img/komentar-program-47-kongres-snefs-2026.webp" rel="noopener noreferrer" target="_blank"><img src="img/komentar-program-47-kongres-snefs-2026.webp" alt="Polopriesvitná oblička s cievnym mostom svetla k dialyzačnému kreslu a laboratórnemu stolu na tmavom pozadí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nejde o snímku konkrétneho pacienta, pracoviska ani výrobku. Motív spája biologický pokrok s každodennou klinickou starostlivosťou.</figcaption></figure>

<p>Program 47. kongresu Slovenskej nefrologickej spoločnosti s medzinárodnou účasťou, ktorý sa koná od 11. do 13. novembra 2026 v Hoteli Grand v Jasnej, naznačuje smer, ktorý v odbore čoraz zreteľnejšie rezonuje.<sup>1,2</sup> Odkláňa sa od zamerania iba na náhradu funkcie obličiek a posúva sa k včasnému záchytu ochorení, nefroprotekcii a cielenej liečbe. Je to správny smer. Rozhodujúce však bude, nakoľko sa odborné poznatky reálne premenia na dostupnú, bezpečnú a uskutočniteľnú starostlivosť.</p>

<p>Nasledujúci text je komentár k oficiálnemu programu, nie správa z prednášok. V čase prípravy ešte nezazneli. Opiera sa o verejne dostupný rozvrh a o vybrané publikácie, ktoré pomáhajú kalibrovať očakávania pri témach, kde program sľubuje novinky, ale prax potrebuje hranice dôkazov.</p>

<h2>Štatistika na začiatku: potrebný základ pre diskusiu o budúcnosti odboru</h2>

<p>Za veľmi dobré rozhodnutie považujem zaradenie nefrologickej a transplantačnej štatistiky hneď na začiatok odborného programu prvého dňa.<sup>2</sup> Diskusia o budúcnosti slovenskej nefrológie má zmysel len vtedy, keď sa opiera o pomenovanie súčasného stavu. Nadväzujúce prezentácie štúdie SIRIUS, projektu Silné obličky a národných epidemiologických indikátorov chronickej choroby obličiek môžu priniesť dôležitý domáci pohľad, najmä ak sa dôsledne rozlíši:</p>

<ul>
  <li>čo presne meria skúsenosť kohorty v rámci skríningu a kampaní,</li>
  <li>čo je špecifické pre jedno centrum alebo vybranú skupinu,</li>
  <li>a čo sa dá zovšeobecniť pre populáciu.</li>
</ul>

<p>Aj dobré dáta treba interpretovať tak, aby sa z nich nestala dojmová argumentácia, ale použiteľný podklad pre klinické a organizačné rozhodovanie.</p>

<h2>Diagnostika a cielená liečba: precíznosť, nie iba novinka</h2>

<p>Silnou stránkou programu je prepojenie klinickej nefrológie s novými diagnostickými a liečebnými možnosťami. Témy ako IgA nefropatia, komplementom sprostredkované glomerulopatie a moderná diagnostika rejekcie pomocou darcovskej voľnej DNA (dd-cfDNA) majú potenciál posunúť klinické rozhodovanie vpred.<sup>2</sup></p>

<p>Pri prezentáciách však považujem za kľúčové, aby popri zdôraznení účinnosti zostali výrazne prítomné aj tieto otázky:</p>

<ul>
  <li>bezpečnosť a riziká, vrátane infekčných komplikácií pri imunomodulačnej liečbe,</li>
  <li>voľba vhodného pacienta, teda pre koho je daný prístup skutočne racionálny,</li>
  <li>dostupnosť vyšetrení a ich praktická interpretácia,</li>
  <li>a reálne možnosti úhrady, teda čo je uskutočniteľné v bežných podmienkach.</li>
</ul>

<p>To platí aj pri biomarkeroch. dd-cfDNA sa často prezentuje ako neinvazívny marker poškodenia aloštepu a ako pomocník pri odlíšení aktívnej rejekcie od stavu bez rejekcie. V klinickej praxi je dôležité zachovať realistické očakávania: biomarker môže zlepšiť identifikáciu rizika a rizikové stratifikovanie, konečné terapeutické rozhodnutie však má stáť na klinickom obraze, laboratóriu a podľa potreby na histológii. Ani pri cielených terapiách v komplementových ochoreniach nebýva odpoveď jednotná.</p>

<p>C3 glomerulopatia je zriedkavé ochorenie s dysreguláciou komplementu; konsenzuálna definícia a diagnostický rámec boli sformulované už pred viac ako desaťročím.<sup>3</sup> Príkladom, ktorý stojí za kritické zohľadnenie pri diskusiách o cielenej liečbe, je eculizumab. Retrospektívna práca z jedného centra (University of Freiburg) zaradila 14 pacientov s C3 glomerulopatiou; jedenásť dostávalo eculizumab a traja štandardnú starostlivosť. Medián sledovania bol 68&nbsp;mesiacov a medián trvania liečby eculizumabom 10&nbsp;mesiacov. Po liečbe eculizumabom malo päť pacientov stabilný vývoj odhadovanej glomerulovej filtrácie (zmena v rozpätí ±30 %) a šesť negatívny výsledok (pokles o viac než 30 %). Autori uzavreli, že prínos eculizumabu pri chronicky progresívnej C3 glomerulopatii je obmedzený.<sup>4</sup> Takéto výsledky majú byť v diskusii prítomné, pretože podmieňujú, ako nastavujeme indikácie aj očakávania pacientov.</p>

<h2>Každodenná dialýza: domáce metódy, predtransplantačná príprava a cievne prístupy</h2>

<p>Pre každodennú dialyzačnú prax sú mimoriadne cenné prednášky o domácich modalitách, predtransplantačnej príprave a o cievnych prístupoch.<sup>2</sup> Z praktického pohľadu je dôležité, aby sa domáce riešenia neprezentovali iba ako organizačná zmena, ale ako model starostlivosti, ktorý vyžaduje štruktúru, vzdelávanie, podporu a bezpečnostné pravidlá.</p>

<p>Pri predtransplantačnej príprave je otázka, kde pri príprave strácame čas, rovnako dôležitá ako predstavenie novej technológie. Chronická choroba obličiek je dlhodobý proces, ale intervaly medzi jednotlivými krokmi často rozhodujú o tom, či sa pacient dostane na transplantáciu pripravený a v stave, ktorý umožní maximalizovať benefit.</p>

<p>Rovnako praktický potenciál má piatkový blok o ultrazvuku, kanylácii a komplikáciách cievnych prístupov.<sup>2</sup> V tejto oblasti nejde primárne o teóriu, ale o zručnosti, prevenciu a štandardizáciu postupov, ktoré znižujú riziko infekcií, trombóz a morbidných komplikácií.</p>

<h2>Životné prostredie: mikroplasty, neistoty dôkazov a udržateľnosť dialýzy</h2>

<p>Program otvára aj tému obličiek a životného prostredia.<sup>1,2</sup> To je potrebné, lebo nefrológia sa v reálnom svete stretáva s klimatickými a environmentálnymi rizikami cez populáciu aj cez samotnú zdravotnú starostlivosť.</p>

<h3>Mikroplasty: biologická vierohodnosť nie je to isté ako klinický dôsledok</h3>

<p>Pri mikroplastoch považujem za dôležité jasne rozlíšiť, čo vieme z experimentov, biológie a detekcie v tkanivách alebo telesných tekutinách, od toho, čo je preukázané ako klinický dopad na progresiu alebo výsledky u pacientov s ochorením obličiek. Kým sa táto hranica nebude dôsledne rešpektovať, hrozí, že sa z nej stane mediálne jednoduché tvrdenie bez opory v klinických dátach.</p>

<p>Recenzia La Porta a spol. sumarizuje rastúci korpus dôkazov o depozícii plastových mikročastíc v ľudských orgánoch, tkanivách a tekutinách a zároveň upozorňuje na metodické limity a na to, že príspevok mikroplastov k ľudským ochoreniam, vrátane poškodenia obličiek, zostáva predmetom ďalšieho skúmania.<sup>5</sup></p>

<h3>Udržateľnosť dialýzy: zdroje aj kvalita starostlivosti</h3>

<p>Pri ekologickej udržateľnosti dialýzy je vhodné posudzovať spotrebu vody, energie a materiálov spolu s bezpečnosťou a výsledkami liečby. V opačnom prípade sa dá urobiť ekologická optimalizácia, ktorá zhorší klinickú kvalitu.</p>

<p>KDIGO v podklade ku Controversies Conference o zelenej dialýze (apríl 2025) priamo uvádza, že dialyzačné terapie patria medzi medicínske liečby s najvyššou uhlíkovou náročnosťou, a to pre vysokú spotrebu energie, závislosť od spotrebného materiálu a frekvenciu liečby; zároveň zdôrazňuje aj spotrebu vody a plastové znečistenie. Navrhovaný rámec má znižovať zdrojovú záťaž pri zachovaní, alebo zlepšení kvality starostlivosti a dostupnosti.<sup>6</sup></p>

<h2>Vyváženosť programu: označenie firemných blokov nestačí</h2>

<p>Program zároveň otvára otázku vyváženosti. To, že firemné sympóziá a podporené prednášky sú zreteľne označené, je správne.<sup>2</sup> Samotné označenie však nenahrádza kritické porovnanie terapeutických možností vrátane nefarmakologických prístupov, ako aj zohľadnenie neistôt v dôkazoch.</p>

<p>Ak v názvoch prednášok menej vystupujú témy konzervatívnej starostlivosti bez dialýzy, spoločného rozhodovania alebo kvality života, neznamená to, že nezaznejú. Znamená to však, že by si zaslúžili viditeľnejší priestor, pretože práve tieto oblasti sú často miestom, kde sa najvýraznejšie stretáva medicína s reálnym životom pacienta.</p>

<h2>Časové rozloženie tém: priestor na výmenu skúseností je neprenosný</h2>

<p>Odborná pestrosť naráža na časové možnosti. Pediatrický blok zaradený až na štvrtkový večer a krátke diskusie pri viacerých prednáškach môžu obmedziť výmenu skúseností medzi pracoviskami.<sup>2</sup> Pri kongresoch to býva rozhodujúce: nie iba to, čo sa odprezentuje, ale čo sa reálne preberie, spresní a prenesie do praxe.</p>

<h2>Čo by malo nasledovať po kongrese</h2>

<p>Celkovo ide o obsahovo silný program. Jeho najväčšiu hodnotu však neukáže počet noviniek. Ukáže ju jednoduchá odpoveď: čo po kongrese dokážeme pre svojich pacientov robiť lepšie, bezpečnejšie a systematickejšie. To sa dá merať až vtedy, keď sa diskutované princípy premenia na protokoly, školenia, indikácie a merateľné zmeny v praxi.</p>

<h2>Limity</h2>

<ul>
  <li>Text komentuje verejne dostupný program, nie obsah ešte neprednesených prednášok.</li>
  <li>Údaje o eculizumabe pochádzajú z retrospektívnej, jednocentrovej série s malým počtom pacientov a neumožňujú kauzálne zovšeobecnenie.</li>
  <li>Prehľad o mikroplastoch mapuje detekciu a biologickú vierohodnosť; nepreukazuje klinický dopad na progresiu chronickej choroby obličiek.</li>
  <li>Dokument KDIGO o zelenej dialýze je konferenčný podklad (scope of work), nie hotové odporúčanie klinickej praxe.</li>
  <li>Hodnotenie vyváženosti programu vychádza z názvov a označení blokov, nie z neznámeho obsahu diskusií.</li>
</ul>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie, platné odporúčania ani rozhodnutia o úhrade. Indikácia cielených terapií, interpretácia biomarkerov a organizačné zmeny v dialyzačnej starostlivosti sú vždy individuálne a lokálne podmienené.</em></p>

<hr>

<h2>Literatúra</h2>

<ol>
  <li>47. kongres Slovenskej nefrologickej spoločnosti s medzinárodnou účasťou, 11. až 13. novembra 2026, Hotel Grand, Jasná. Oficiálna stránka kongresu. <a href="https://nefro2026.sk/" target="_blank" rel="noopener noreferrer">https://nefro2026.sk/</a></li>
  <li>Odborný program 47. kongresu Slovenskej nefrologickej spoločnosti. <a href="https://nefro2026.sk/program.php" target="_blank" rel="noopener noreferrer">https://nefro2026.sk/program.php</a></li>
  <li>Pickering MC, D’Agati VD, Nester CM, Smith RJ, Haas M, Appel GB, Alpers CE, Bajema IM, Bedrosian C, Braun M, Doyle M, Fakhouri F, Fervenza FC, Fogo AB, Frémeaux-Bacchi V, Gale DP, Goicoechea de Jorge E, Griffin G, Harris CL, Holers VM, Johnson S, Lavin PJ, Medjeral-Thomas N, Morgan BP, Nast CC, Noel LH, Peters DK, Rodríguez de Córdoba S, Servais A, Sethi S, Song WC, Tamburini P, Thurman JM, Zavros M, Cook HT. C3 glomerulopathy: consensus report. <em>Kidney International.</em> 2013;84(6):1079-1089. doi:10.1038/ki.2013.377. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/24172683/" target="_blank" rel="noopener noreferrer">24172683</a></li>
  <li>Welte T, Arnold F, Westermann L, Rottmann FA, Hug MJ, Neumann-Haefelin E, Ganner A. Eculizumab as a treatment for C3 glomerulopathy: a single-center retrospective study. <em>BMC Nephrology.</em> 2023;24(1):8. doi:10.1186/s12882-023-03058-9. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/36631797/" target="_blank" rel="noopener noreferrer">36631797</a>. PMC: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9832765/" target="_blank" rel="noopener noreferrer">PMC9832765</a></li>
  <li>La Porta E, Exacoustos O, Lugani F, Angeletti A, Chiarenza DS, Bigatti C, Spinelli S, Kajana X, Garbarino A, Bruschi M, Candiano G, Caridi G, Mancianti N, Calatroni M, Verzola D, Esposito P, Viazzi F, Verrina E, Ghiggeri GM. Microplastics and Kidneys: An Update on the Evidence for Deposition of Plastic Microparticles in Human Organs, Tissues and Fluids and Renal Toxicity Concern. <em>International Journal of Molecular Sciences.</em> 2023;24(18):14391. doi:10.3390/ijms241814391. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/37762695/" target="_blank" rel="noopener noreferrer">37762695</a>. PMC: <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10531672/" target="_blank" rel="noopener noreferrer">PMC10531672</a></li>
  <li>KDIGO Controversies Conference on Green Dialysis: Environmentally Sustainable Care, Growth, and Innovation. Scope of Work (konferencia 24. až 27. apríla 2025). <a href="https://kdigo.org/wp-content/uploads/2024/12/KDIGO-Green-Dialysis_Scope-of-Work-for-Public-Review.pdf" target="_blank" rel="noopener noreferrer">PDF</a></li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Program a dátumy kongresu boli overené proti oficiálnej stránke a stránke programu (nefro2026.sk). Autorské zoznamy, bibliografické údaje a abstrakty Pickering 2013, Welte 2023 a La Porta 2023 boli overené cez Crossref a PubMed/PMC (vrátane záveru Welte o obmedzenom prínose eculizumabu pri chronicky progresívnej C3 glomerulopatii a opatrnej interpretácie mikroplastov). KDIGO tvrdenia o environmentálnej záťaži dialýzy boli overené v Scope of Work. Vlastný prínos autora spočíva v komentári k štruktúre programu a v kalibrácii očakávaní voči dostupným dôkazom, nie v nových empirických dátach.</em></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=uhlikova-stopa-hemodialyzy-meranie-znizovanie-emisii">Uhlíková stopa hemodialýzy</a> – meranie a hranice znižovania emisií.</li>
  <li><a href="article.php?slug=udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia">Udržateľná peritoneálna dialýza</a> – zelená nefrológia z pohľadu pacientov.</li>
  <li><a href="article.php?slug=mikroplasty-tpe-odstranenie-z-krvi-prva-klinicka-studia">Mikroplasty a TPE</a> – klinický pokus o odstránenie z krvi.</li>
  <li><a href="article.php?slug=environmentalne-toxiny-poskodenie-obliciek-nefrolog">Environmentálne toxíny a poškodenie obličiek</a>.</li>
  <li><a href="article.php?slug=cievny-pristup-nemozny-avf-avg-planovanie-dialyzy">Plánovanie cievneho prístupu</a>.</li>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Zaradenie do transplantačného programu</a>.</li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_komentar-program-47-kongres-snefs-2026_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

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
