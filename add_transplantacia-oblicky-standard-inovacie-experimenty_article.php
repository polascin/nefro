<?php
/**
 * Odborný článok: štandard, inovácie a experimenty pri transplantácii obličky.
 */

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
    'title'        => 'Transplantácia obličky: čo je štandard, čo inovácia a čo stále experiment',
    'slug'         => 'transplantacia-oblicky-standard-inovacie-experimenty',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Hypotermická perfúzia, normotermická perfúzia, inhibícia komplementu, belatacept a tegoprubart nemajú rovnakú úroveň dôkazov. Článok oddeľuje rutinnú prax od výskumu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Transplantačná medicína sa mení rýchlo, no nie každá technicky pôsobivá novinka už zlepšuje klinické výsledky. Hypotermická strojová perfúzia má randomizované dôkazy, krátka normotermická perfúzia v doterajšej veľkej štúdii neznížila oneskorený nástup funkcie štepu a lokálne podanie inhibítora C1 esterázy prinieslo iba malý pilotný signál. Podobne treba odlišovať etablovaný belatacept od experimentálnej blokády CD154 tegoprubartom.</em></p>

<p>Transplantácia obličky je pre vhodného pacienta so zlyhaním obličiek spravidla najúčinnejšou formou náhrady funkcie obličiek. Výsledok však neurčuje jedna technológia. Závisí od správneho výberu príjemcu a darcu, imunologického rizika, kvality orgánu, času ischémie, chirurgického výkonu, imunosupresie, prevencie infekcií, adherencie a dlhodobého manažmentu kardiometabolických komplikácií.</p>

<p>Pri hodnotení noviniek je preto užitočné položiť tri otázky:</p>

<ol>
  <li>Bol prínos preukázaný v randomizovanej klinickej štúdii?</li>
  <li>Zlepšil sa výsledok dôležitý pre pacienta alebo iba biomarker či mechanistický ukazovateľ?</li>
  <li>Možno výsledok preniesť na bežnú transplantáciu, alebo platí iba pre úzko vybraný orgán, centrum a protokol?</li>
</ol>

<h2>Dôkazová mapa</h2>

<div class="table-responsive" role="region" aria-label="Úroveň dôkazov pre vybrané postupy pri transplantácii obličky" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Postup</th>
        <th scope="col">Čo vieme</th>
        <th scope="col">Primerané zaradenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Hypotermická strojová perfúzia</th>
        <td>Randomizované údaje podporujú nižšie riziko oneskoreného nástupu funkcie štepu oproti statickému chladovému uchovaniu</td>
        <td>Etablovaná technológia podľa typu darcu a protokolu centra</td>
      </tr>
      <tr>
        <th scope="row">Normotermická ex vivo perfúzia</th>
        <td>Je uskutočniteľná a umožňuje funkčné hodnotenie; jedna hodina po chladovom uchovaní však v RCT neznížila DGF</td>
        <td>Špecializované alebo výskumné protokoly</td>
      </tr>
      <tr>
        <th scope="row">Lokálny inhibítor C1 esterázy</th>
        <td>Pilot so 40 príjemcami neznížil DGF; ukázal exploratórny rozdiel eGFR</td>
        <td>Experiment, ktorý vyžaduje väčšiu potvrdzujúcu štúdiu</td>
      </tr>
      <tr>
        <th scope="row">Belatacept</th>
        <td>Dlhodobé randomizované údaje a schválené použitie pri presne vymedzených príjemcoch</td>
        <td>Vybraná alternatíva k inhibítoru kalcineurínu, nie univerzálna náhrada</td>
      </tr>
      <tr>
        <th scope="row">Tegoprubart</th>
        <td>Štúdia fázy 2 BESTOW je dokončená, no register zatiaľ neobsahuje výsledky</td>
        <td>Experimentálna liečba</td>
      </tr>
    </tbody>
  </table>
</div>

<p><abbr title="delayed graft function">DGF</abbr> označuje oneskorený nástup funkcie štepu; v citovaných štúdiách sa najčastejšie definoval potrebou dialýzy počas prvého týždňa po transplantácii. Táto praktická definícia má limity, pretože potrebu dialýzy ovplyvňuje aj rozhodovanie pracoviska.</p>

<h2>Základom zostáva včasné a úplné vyšetrenie kandidáta</h2>

<p>Technologické inovácie nenahrádzajú správne načasovanie transplantácie. KDIGO odporúča odoslať potenciálne vhodného pacienta na transplantačné vyšetrenie dostatočne skoro, aby sa umožnila predemptívna transplantácia a vyhodnotenie živého darcu. Samotný vek nemá byť automatickou kontraindikáciou; rozhoduje kombinácia komorbidít, krehkosti, očakávaného prežívania, funkčného stavu a preferencií pacienta.</p>

<p>Pred zaradením treba cielene hodnotiť:</p>

<ul>
  <li>kardiovaskulárne riziko a funkčnú kapacitu,</li>
  <li>aktívne infekcie a imunizačný stav,</li>
  <li>malignitu a interval od jej liečby podľa typu nádoru,</li>
  <li>imunologické riziko, HLA protilátky a krížovú skúšku,</li>
  <li>krehkosť, výživu, adherenciu a psychosociálne podmienky,</li>
  <li>urologické a cievne pomery dôležité pre výkon.</li>
</ul>

<p>Prekážka nemusí znamenať trvalé vyradenie. Často ide o riešiteľný stav, ktorý vyžaduje liečbu, rehabilitáciu, očkovanie, úpravu hmotnosti alebo doplnenie vyšetrení. Naopak, formálne splnenie jedného kritéria nezaručuje prijateľný celkový pomer prínosu a rizika.</p>

<h2>Hypotermická strojová perfúzia: technológia s klinickým dôkazom</h2>

<p>Pri statickom chladovom uchovaní je oblička uložená v konzervačnom roztoku. Hypotermická strojová perfúzia (HMP) cez orgán priebežne vedie chladný perfuzát a umožňuje sledovať parametre prietoku a odporu. Nejde iba o technickú eleganciu: randomizované štúdie preukázali klinický účinok.</p>

<p>Medzinárodná párová štúdia z roku 2009 použila obličky od 336 zosnulých darcov. Z každého páru bola jedna oblička uchovaná strojovou perfúziou a druhá staticky v chlade; sledovalo sa 672 príjemcov. DGF vznikla u 70 príjemcov po strojovej perfúzii a u 89 po chladovom uchovaní (upravený pomer šancí 0,57; p = 0,01). Jednoročné prežívanie štepu bolo 94 % oproti 90 %.</p>

<p>Výsledok nepovoľuje tvrdenie, že HMP odstráni DGF alebo vyrovná všetky riziká okrajového darcu. Podporuje však jej použitie ako súčasť programu uchovávania orgánov, osobitne tam, kde je riziko ischemického poškodenia vyššie.</p>

<h2>Normotermická perfúzia: platforma s potenciálom, nie dokázaná univerzálna nadradenosť</h2>

<p>Normotermická strojová perfúzia (NMP) udržiava orgán pri teplote blízkej fyziologickej a dodáva mu okysličený perfuzát, často s erytrocytmi. Umožňuje sledovať prietok, tvorbu moču a metabolické parametre a teoreticky vytvára priestor na opravu orgánu alebo lokálne podanie liečby.</p>

<p>Veľká britská randomizovaná štúdia pri obličkách od darcov po cirkulačnej smrti porovnala statické chladové uchovanie s pridaním jednej hodiny NMP. Do konečnej analýzy vstúpilo 277 obličiek. DGF vznikla pri NMP u 60,7 % a pri samotnom chladovom uchovaní u 58,5 % príjemcov (upravený pomer šancí 1,13; 95 % interval spoľahlivosti 0,69 až 1,84; p = 0,624).</p>

<p>NMP bola uskutočniteľná a nepriniesla nový bezpečnostný signál, no tento konkrétny hodinový protokol DGF neznížil. Nemožno z toho odvodiť, že každý dlhší, kontinuálny alebo liečebný protokol je neúčinný. Rovnako však nemožno prezentovať NMP ako všeobecne dokázanú náhradu HMP či chladového uchovania.</p>

<h2>Ischemicko-reperfúzne poškodenie: silná biológia, slabšia terapeutická istota</h2>

<p>Počas ischémie sa vyčerpáva ATP, mení sa mitochondriálny metabolizmus a hromadia sa metabolity. Obnovenie prietoku je nevyhnutné, no zároveň spúšťa oxidačný stres, aktiváciu endotelu, komplementu a vrodenej imunity. Tento mechanizmus je biologicky presvedčivý, ale úspech v modeli alebo biopsii automaticky neznamená menej DGF či dlhšie prežívanie štepu.</p>

<h3>Lokálna inhibícia komplementu</h3>

<p>Randomizovaná dvojito zaslepená pilotná štúdia z roku 2025 podala počas prípravy orgánu 500 jednotiek inhibítora C1 esterázy do renálnej artérie 20 obličiek; 20 kontrolných orgánov dostalo fyziologický roztok. Liečba <strong>neznížila DGF</strong>. Medián eGFR bol vyšší v liečenej skupine po 6 mesiacoch (55 oproti 39 ml/min/1,73 m²) aj po 30 mesiacoch (54 oproti 43 ml/min/1,73 m²).</p>

<p>Ide o zaujímavý signál, ale malé počty, viacnásobné hodnotenia a neprítomnosť účinku na hlavný skorý klinický problém neumožňujú rutinné použitie. Autori navyše uvádzajú patentové a finančné väzby súvisiace s týmto prístupom. Potrebná je väčšia nezávislá potvrdzujúca štúdia.</p>

<h2>Imunosupresia: cieľom nie je „čo najmenej“, ale najlepší pomer rizík</h2>

<p>Takrolimus zostáva základom mnohých udržiavacích režimov, zvyčajne v kombinácii s mykofenolátom a glukokortikoidom podľa imunologického rizika a protokolu centra. Nefrotoxicita inhibítorov kalcineurínu je reálna, ale ich redukcia alebo vysadenie môže zvýšiť riziko rejekcie a tvorby donorovo špecifických protilátok. Zmena musí vychádzať z celého klinického obrazu, expozície lieku, biopsie a imunologického rizika.</p>

<h3>Belatacept</h3>

<p>Belatacept blokuje kostimulačný signál CD80/86–CD28. V sedemročnom sledovaní štúdie BENEFIT bol oproti cyklosporínu spojený s vyššou eGFR a nižším kombinovaným rizikom smrti alebo straty štepu. Porovnávacím liekom bol však <strong>cyklosporín, nie súčasný takrolimový režim</strong>, čo je pri interpretácii zásadné.</p>

<p>Belatacept nie je vhodný pre každého. Použitie je obmedzené na príjemcov séropozitívnych na Epsteinov-Barrovej vírus pre riziko posttransplantačnej lymfoproliferatívnej choroby; vyžaduje intravenózne podávanie a starostlivé sledovanie rejekcie aj infekcií. Je etablovanou možnosťou pre vybraných pacientov, nie automatickou „netoxickou“ náhradou takrolimu.</p>

<h3>Tegoprubart</h3>

<p>Tegoprubart je monoklonová protilátka proti CD154, ktorá zasahuje dráhu CD40–CD154. Fáza 2 BESTOW porovnávala tegoprubart s takrolimom u 127 nových príjemcov transplantátu. Podľa registra ClinicalTrials.gov sa štúdia skončila v septembri 2025, ale k poslednej aktualizácii z 22. júla 2026 nemala zverejnené výsledky.</p>

<p>Z dokončenia štúdie nemožno vyvodiť účinnosť. Kým nie sú dostupné recenzované výsledky o eGFR, biopsiou potvrdenej rejekcii, prežívaní štepu a bezpečnosti, tegoprubart zostáva experimentálnym liečivom.</p>

<h2>Infekcie, malignity a metabolické komplikácie zostávajú rozhodujúce</h2>

<p>Úspech transplantácie nie je len absencia rejekcie. Intenzita imunosupresie sa musí priebežne vyvažovať s rizikom cytomegalovírusu, BK polyomavírusu, pneumocystovej pneumónie, ďalších infekcií a malignít. Profylaxia a monitorovanie sa riadia sérologickým rizikom darcu a príjemcu, použitou indukciou, lokálnou epidemiológiou a protokolom centra.</p>

<p>Rovnako dôležité sú artériová hypertenzia, diabetes po transplantácii, dyslipidémia, obezita, fajčenie, kostné ochorenie a adherencia. Nová perfúzna technika ani biologická liečba nevykompenzujú dlhodobú nedostupnosť liekov alebo opakované vynechávanie dávok.</p>

<h2>Praktický záver</h2>

<ol>
  <li><strong>Transplantáciu plánovať včas.</strong> Vhodný kandidát má byť odoslaný ešte pred začatím dialýzy, ak je to možné.</li>
  <li><strong>HMP považovať za technológiu s klinickou oporou.</strong> Konkrétne použitie však závisí od darcu a programu centra.</li>
  <li><strong>NMP nevydávať za automaticky lepšiu.</strong> Je platformou na hodnotenie a intervenciu; hodinový protokol DGF neznížil.</li>
  <li><strong>Mechanistické terapie označovať ako experiment.</strong> Pilotný signál C1-INH nie je štandardom.</li>
  <li><strong>Belatacept a tegoprubart nezamieňať.</strong> Prvý má schválené použitie s významnými obmedzeniami, druhý zatiaľ nemá zverejnené výsledky fázy 2.</li>
  <li><strong>Chrániť štepy komplexne.</strong> Imunologické, infekčné, metabolické a behaviorálne riziká treba sledovať spolu.</li>
</ol>

<h2>Záver</h2>

<p>Najväčší pokrok v transplantácii obličky nevzniká z jednej „prelomovej“ technológie, ale zo súhry lepšieho výberu kandidátov, kvalitnejšieho uchovania orgánov, individualizovanej imunosupresie a dôslednej dlhodobej starostlivosti. Hypotermická strojová perfúzia už má klinický dôkaz. Normotermická perfúzia je sľubná platforma, no jej výsledok závisí od protokolu. Lokálna inhibícia komplementu a tegoprubart zostávajú výskumnými stratégiami.</p>

<p>Presná komunikácia úrovne dôkazov nie je akademická opatrnosť. Chráni pacienta pred tým, aby sa uskutočniteľnosť, mechanistický signál alebo tlačová správa zamieňali za dokázaný klinický prínos.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Transplantácia obličky: zaradenie do programu</a></li>
  <li><a href="article.php?slug=regulacne-t-lymfocyty-transplantacia-oblicky-tolerancia">Regulačné T-lymfocyty a transplantačná tolerancia</a></li>
  <li><a href="article.php?slug=malignity-transplantacia-oblicky-skrining-ptld">Malignity po transplantácii obličky a PTLD</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<ol>
  <li><strong>Chadban SJ, Ahn C, Axelrod DA, et al.</strong> <em>KDIGO Clinical Practice Guideline on the Evaluation and Management of Candidates for Kidney Transplantation.</em> Transplantation. 2020;104(4S1 Suppl 1):S11–S103. doi: 10.1097/TP.0000000000003136. <a href="https://pubmed.ncbi.nlm.nih.gov/32301874/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Moers C, Smits JM, Maathuis MHJ, et al.</strong> <em>Machine Perfusion or Cold Storage in Deceased-Donor Kidney Transplantation.</em> New England Journal of Medicine. 2009;360:7–19. doi: 10.1056/NEJMoa0802289. <a href="https://pubmed.ncbi.nlm.nih.gov/19118301/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Tingle SJ, Figueiredo RS, Moir JA, Goodfellow M, Thompson ER, Ibrahim IK.</strong> <em>Machine perfusion preservation versus static cold storage for deceased donor kidney transplantation.</em> Cochrane Database of Systematic Reviews. 2019;3:CD011671. doi: 10.1002/14651858.CD011671.pub2. <a href="https://pubmed.ncbi.nlm.nih.gov/30875082/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Hosgood SA, Callaghan CJ, Wilson CH, et al.</strong> <em>Normothermic machine perfusion versus static cold storage in donation after circulatory death kidney transplantation: a randomized controlled trial.</em> Nature Medicine. 2023;29:1511–1519. doi: 10.1038/s41591-023-02376-7. <a href="https://pubmed.ncbi.nlm.nih.gov/37231075/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Huang E, Ammerman N, Vo A, et al.</strong> <em>Back-table intra-arterial administration of C1 esterase inhibitor to deceased donor kidney allografts improves posttransplant allograft function.</em> American Journal of Transplantation. 2025;25(9):1926–1939. doi: 10.1016/j.ajt.2025.05.003. <a href="https://pubmed.ncbi.nlm.nih.gov/40349965/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Vincenti F, Rostaing L, Grinyo J, et al.</strong> <em>Belatacept and Long-Term Outcomes in Kidney Transplantation.</em> New England Journal of Medicine. 2016;374:333–343. doi: 10.1056/NEJMoa1506027. <a href="https://pubmed.ncbi.nlm.nih.gov/26816011/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>U.S. National Library of Medicine.</strong> <em>BESTOW: Safety and Efficacy of Tegoprubart in Patients Undergoing Kidney Transplantation.</em> NCT05983770. <a href="https://clinicaltrials.gov/study/NCT05983770" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
</ol>

<p><em><strong>Poznámka k vecnej kontrole:</strong> Text oddeľuje randomizované klinické výsledky od uskutočniteľnosti a mechanistických signálov. Neuvádza neoverené počty čakateľov, neoznačuje NMP za dokázane nadradenú a neinterpretuje dokončenie štúdie BESTOW ako pozitívny výsledok. Pilot C1-INH je uvedený spolu s nulovým účinkom na DGF, malou vzorkou a konfliktmi záujmov.</em></p>

<p><em>Text má odborný informačný charakter. Výber kandidáta, spôsob uchovania orgánu a imunosupresia patria do rozhodovania transplantačného centra.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$__articleLogPrefix = basename(__FILE__, '.php');
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => $__articleLogPrefix,
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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