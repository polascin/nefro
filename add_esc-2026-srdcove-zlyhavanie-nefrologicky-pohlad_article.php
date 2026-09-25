<?php
/**
 * Odborne a jazykovo revidovaný článok o odporúčaniach ESC 2026 pre srdcové zlyhávanie.
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

$articles = [];

$articles[] = [
    'title'        => 'ESC 2026 a srdcové zlyhávanie: čo sa mení z nefrologického pohľadu',
    'slug'         => 'esc-2026-srdcove-zlyhavanie-nefrologicky-pohlad',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'ESC 2026 mení klasifikáciu srdcového zlyhávania, zavádza rámec FMT–AMT–GDIT a zaraďuje eGFR aj UACR do vstupného vyšetrenia. Čo z toho prakticky vyplýva pre nefrológa?',
    'content'      => <<<'HTML'
<p>Odporúčania Európskej kardiologickej spoločnosti (ESC) z roku 2026 menia klasifikáciu, diagnostiku aj pomenovanie liečby srdcového zlyhávania. Pre nefrológa nejde iba o terminologickú úpravu. Dokument zaraďuje <strong>eGFR a pomer albumínu ku kreatinínu v moči (UACR)</strong> do vstupného laboratórneho vyšetrenia, posilňuje postavenie inhibítorov SGLT2 a antagonistov mineralokortikoidového receptora (MRA) naprieč spektrom ejekčnej frakcie a zdôrazňuje titráciu liečby podľa klinického stavu a laboratórnych výsledkov. [1–3]</p>

<h2>Dve skupiny podľa LVEF namiesto troch</h2>

<p>Kategória srdcového zlyhávania s mierne zníženou ejekčnou frakciou (HFmrEF) bola odstránená. Odporúčania používajú dve skupiny:</p>

<ul>
  <li><strong>HFrEF:</strong> ejekčná frakcia ľavej komory (LVEF) &lt; 50 %;</li>
  <li><strong>HFpEF:</strong> LVEF ≥ 50 %.</li>
</ul>

<p>Pacient s LVEF 41 až 49 % sa teda po novom označuje ako HFrEF. Samotná hodnota LVEF však diagnózu srdcového zlyhávania nestanovuje. Musí byť spojená s klinickým syndrómom a objektívnym dôkazom srdcovej dysfunkcie alebo štrukturálnej abnormality. Treba tiež zohľadniť variabilitu merania a predchádzajúcu LVEF. Nové označenie preto nemožno používať ako mechanický pokyn na liečbu bez klinického kontextu. [1, 2]</p>

<p>ESC zároveň preberá štádiá A až D: od pacienta s rizikovými faktormi bez štrukturálneho postihnutia až po pokročilé srdcové zlyhávanie. Tento rámec podporuje skorú prevenciu a zachytenie ochorenia ešte pred vznikom symptómov.</p>

<h2>FMT, AMT a GDIT: čo nové názvy skutočne znamenajú</h2>

<p>Nové názvoslovie rozlišuje tri vrstvy liečby:</p>

<ul>
  <li><strong>FMT, foundational medical therapy:</strong> základná farmakoterapia s odporúčaním triedy I pre všeobecnú populáciu daného fenotypu a s presvedčivým dôkazom zníženia morbidity alebo mortality;</li>
  <li><strong>AMT, additional medical therapy:</strong> doplnková farmakoterapia odporúčaná pre vybrané fenotypy, komorbidity alebo klinické situácie, prípadne na zlepšenie symptómov a kvality života;</li>
  <li><strong>GDIT, guideline-directed interventional therapy:</strong> odporúčané implantovateľné zariadenia a intervenčné výkony.</li>
</ul>

<p>Pojem guideline-directed medical therapy (GDMT) naďalej zahŕňa FMT aj AMT. Rozdelenie nemá vytvoriť tri po sebe nasledujúce kroky pre každého pacienta. Má jasnejšie oddeliť univerzálny farmakologický základ od liečby vyberanej podľa fenotypu a od prístrojových či intervenčných postupov. [1, 2]</p>

<h2>Základná farmakoterapia podľa fenotypu</h2>

<p>Pri symptomatickom <strong>HFrEF</strong> tvoria FMT štyri liekové skupiny:</p>

<ul>
  <li>inhibítor systému renín–angiotenzín, prednostne ACE inhibítor alebo ARNI, prípadne ARB pri intolerancii;</li>
  <li>betablokátor s dôkazmi pri srdcovom zlyhávaní;</li>
  <li>MRA;</li>
  <li>inhibítor SGLT2, konkrétne dapagliflozín alebo empagliflozín.</li>
</ul>

<p>Pri symptomatickom <strong>HFpEF</strong> zahŕňa FMT inhibítor SGLT2 a MRA. ESC 2026 odporúča inhibítor SGLT2 aj MRA pri symptomatickom srdcovom zlyhávaní nezávisle od LVEF na zníženie rizika hospitalizácie pre srdcové zlyhávanie alebo kardiovaskulárneho úmrtia, v oboch prípadoch trieda I, úroveň dôkazov A. Pri HFrEF sa k nim pridávajú betablokátor a inhibícia systému renín–angiotenzín, takisto s odporúčaním triedy I. [1, 2]</p>

<p>Rozšírenie názvu HFrEF až po LVEF pod 50 % preto nie je iba administratívne. Odporúčania zjednocujú liečebný rámec tejto skupiny. Stále však treba rešpektovať, že sila účinku jednotlivých liekov, vstupné kritériá štúdií a regulačné indikácie nemusia byť v každom bode spektra LVEF totožné.</p>

<h2>Čo znamená FMT pri chronickej chorobe obličiek</h2>

<p>CKD sama osebe nie je dôvodom prognostickú liečbu neponúknuť. Odporúčania upozorňujú, že nesprávna interpretácia zmien obličkovej funkcie patrí medzi príčiny nedostatočného používania FMT. Po začatí alebo titrácii inhibície systému renín–angiotenzín, MRA či inhibítora SGLT2 môže nastať hemodynamická zmena eGFR. Posudzuje sa spolu s objemovým stavom, krvným tlakom, vývojom kreatinínu, draslíka a ostatnou medikáciou, nie izolovane podľa jedného výsledku. [1, 3]</p>

<p>To však neznamená liečbu bez hraníc. Pri akútnom poškodení obličiek, ťažkej hyperkaliémii, závažnej hypotenzii alebo hypoperfúzii môže byť potrebná dočasná úprava. Konkrétne prahy na začatie, zníženie dávky alebo prerušenie sa líšia podľa liekovej skupiny a lieku. Treba ich overiť v aktuálnom súhrne charakteristických vlastností lieku a prispôsobiť klinickej situácii.</p>

<p>ESC odporúča titrovať FMT spravidla každé 1 až 2 týždne podľa symptómov, vitálnych funkcií a laboratórnych výsledkov až po cieľové alebo najvyššie tolerované dávky. Pre nefrologickú prax to znamená plánované kontroly, nie odkladanie účinnej liečby bez termínu ďalšieho kroku. [1, 2]</p>

<h2>eGFR a UACR patria do vstupného vyšetrenia</h2>

<p>Pri podozrení na srdcové zlyhávanie odporúčania vyžadujú laboratórny skríning komorbidít. Zahŕňa krvný obraz, <strong>eGFR a UACR</strong>, elektrolyty, pečeňové a tyreoidálne parametre, HbA1c, lipidy a stav železa. Ide o odporúčanie triedy I s úrovňou dôkazov C. [1, 2]</p>

<p>UACR nie je iba doplnkový „renálny údaj“. Albuminúria pomáha:</p>

<ul>
  <li>zachytiť CKD aj pri relatívne zachovanej eGFR;</li>
  <li>spresniť obličkové a kardiovaskulárne riziko;</li>
  <li>rozhodnúť o potrebe ďalšieho nefrologického vyšetrenia a sledovania;</li>
  <li>vytvoriť východiskovú hodnotu pre hodnotenie ďalšieho priebehu.</li>
</ul>

<p>Jeden zvýšený UACR ešte sám nepotvrdzuje chronickosť CKD. Albuminúriu môžu prechodne zvýšiť infekcia, horúčka, výrazná hyperglykémia, fyzická záťaž, hematúria alebo dekompenzované srdcové zlyhávanie. Pri stabilizovanom pacientovi treba abnormálny výsledok podľa klinického kontextu potvrdiť opakovaným meraním.</p>

<h2>NT-proBNP: vekové prahy pomáhajú, obličky zostávajú súčasťou interpretácie</h2>

<p>V ambulantnom algoritme sa za hodnoty, pri ktorých je srdcové zlyhávanie pravdepodobné, považuje NT-proBNP:</p>

<ul>
  <li>≥ 125 pg/ml vo veku menej ako 50 rokov;</li>
  <li>≥ 250 pg/ml vo veku 50 až 74 rokov;</li>
  <li>≥ 500 pg/ml vo veku 75 rokov a viac.</li>
</ul>

<p>Hodnota NT-proBNP &lt; 125 pg/ml zostáva ambulantným prahom, pod ktorým je srdcové zlyhávanie menej pravdepodobné. Ani jeden prah však nie je samostatným diagnostickým testom. Pri vysokej klinickej pravdepodobnosti sa má pokračovať v echokardiografii a odbornom posúdení aj napriek nízkej hodnote. [1, 4]</p>

<p>Vyšší vek, fibrilácia predsiení, renálna dysfunkcia a viaceré ďalšie stavy môžu koncentráciu zvýšiť; obezita ju môže znížiť. Znížená eGFR preto nie je dôvodom NT-proBNP ignorovať, ale dôvodom interpretovať výsledok v širšom kontexte. Vekové prahy zlepšujú špecificitu, nekorigujú však automaticky všetky účinky CKD, rytmu, telesnej hmotnosti a akútneho klinického stavu.</p>

<h2>Dekompenzácia: kongescia, diuretiká a obličková funkcia</h2>

<p>ESC používa pojem dekompenzované srdcové zlyhávanie namiesto predchádzajúceho širokého označenia akútne srdcové zlyhávanie. Pri preťažení tekutinami zostávajú základom slučkové diuretiká a dynamická úprava dávky podľa kongescie. Pri nedostatočnej odpovedi sa môže pridať krátkodobý intravenózny acetazolamid alebo perorálny hydrochlorotiazid. Riadenie diuretickej liečby podľa sodíka v moči počas prvých dní možno zvážiť na zlepšenie natriurézy a diurézy. [1, 2]</p>

<p>Po úvodnej stabilizácii sa u pacienta s dekompenzovaným srdcovým zlyhávaním odporúča začať inhibítor SGLT2 ešte počas hospitalizácie. Hodnotenie odpovede nemá stáť iba na kreatiníne. Zahŕňa symptómy a známky kongescie, diurézu, hmotnosť, krvný tlak, elektrolyty a trend obličkovej funkcie.</p>

<h2>Praktický postup pre nefrologickú ambulanciu</h2>

<ol>
  <li><strong>Pri známom alebo suspektnom srdcovom zlyhávaní dohľadať eGFR aj UACR.</strong> Ak je albuminúria zachytená počas dekompenzácie, po stabilizácii zvážiť kontrolné meranie.</li>
  <li><strong>LVEF 41 až 49 % čítať v novom rámci HFrEF,</strong> ale liečbu opierať o celý klinický obraz, kontraindikácie a toleranciu.</li>
  <li><strong>Pred začatím alebo titráciou RAAS inhibície a MRA skontrolovať tlak, kreatinín/eGFR a draslík</strong> a určiť termín následnej kontroly.</li>
  <li><strong>NT-proBNP interpretovať podľa veku a kontextu.</strong> CKD môže hodnotu zvyšovať a obezita znižovať; neprimerane vysoký alebo nízky výsledok treba porovnať s klinickým stavom a echokardiografiou.</li>
  <li><strong>Pri vzostupe kreatinínu najprv posúdiť príčinu.</strong> Skontrolovať kongesciu, hypovolémiu, tlak, NSAID, infekciu, dávky diuretík a ďalšie nefrotoxické alebo draslík zvyšujúce lieky.</li>
  <li><strong>Dočasne prerušenú prognostickú liečbu aktívne znovu posúdiť.</strong> Po ústupe AKI, hyperkaliémie alebo hypotenzie nemá zostať vysadená iba zo zotrvačnosti.</li>
</ol>

<h2>Čo sa do odporúčaní nesmie vkladať</h2>

<p>Nová hranica LVEF nemení biologické spektrum ochorenia na dve homogénne skupiny. Trieda I pri diagnostickom laboratóriu navyše neznamená, že UACR alebo NT-proBNP samy určia diagnózu či liečbu. A napokon, odporúčanie odbornej spoločnosti nie je totožné s regulačnou indikáciou konkrétneho lieku, jeho úhradou ani s miestnym preskripčným obmedzením.</p>

<p>Pre nefrológa je najdôležitejší praktický posun: obličková funkcia a albuminúria sa stávajú štandardnou súčasťou hodnotenia srdcového zlyhávania a renálne obavy sa majú riešiť plánovaným monitorovaním a korekciou reverzibilných príčin. Nemajú automaticky viesť k dlhodobému odopretiu liečby, ktorá znižuje riziko hospitalizácie a úmrtia.</p>

<p>Súvisiaci text: <a href="article.php?slug=esc-era-2026-kardiorenalne-odporucania">Prvé spoločné kardiorenálne odporúčania ESC/ERA 2026</a>.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Køber L, Adamo M, Ruwald AC, Tomasoni D, Anderson LJ, Andersson C, Brugts JJ, Chioncel O, Donal E, Ferdinandy P, Jhund PS, Leyva F, Lorusso R, Madigan M, Mullens W, Paolillo S, Ryan N, Simpson M, Thiele H, Thune JJ, Van Craenenbroeck EM, Van Laake LW, Verbakel M; ESC Guidelines Advisory Group. 2026 ESC Guidelines for the management of heart failure. Eur Heart J. 2026;ehag100. doi: 10.1093/eurheartj/ehag100. PMID 42661420. <a href="https://doi.org/10.1093/eurheartj/ehag100" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42661420/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.escardio.org/guidelines/clinical-practice-guidelines/all-esc-practice-guidelines/heart-failure/" target="_blank" rel="noopener noreferrer">ESC</a>.</em></small></li>
  <li><small><em>European Society of Cardiology. 2026 ESC Guidelines for the management of heart failure: Official Slide Set. Publikované 28. augusta 2026. <a href="https://dam-assets.escardio.org/download/b2e587389baa11f185de06bdfb3e4be9" target="_blank" rel="noopener noreferrer">Oficiálna prezentácia ESC</a>.</em></small></li>
  <li><small><em>Damman K, ter Maaten JM, Mayne KJ, et al. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease, in collaboration with the European Renal Association (ERA). Eur Heart J. 2026;ehag098. doi: 10.1093/eurheartj/ehag098. PMID 42661426. <a href="https://doi.org/10.1093/eurheartj/ehag098" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42661426/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Bayes-Genis A, Docherty KF, Petrie MC, Januzzi JL, Mueller C, Anderson L, et al. Practical algorithms for early diagnosis of heart failure and heart stress using NT-proBNP: a clinical consensus statement from the Heart Failure Association of the ESC. Eur J Heart Fail. 2023;25(11):1891–1898. doi: 10.1002/ejhf.3036. PMID 37712339. <a href="https://doi.org/10.1002/ejhf.3036" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37712339/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>

<p><small><em>Rozsah overenia: klasifikácia, triedy a úrovne odporúčaní, diagnostické prahy, liečebné skupiny a autorstvo boli overené podľa originálneho dokumentu ESC, oficiálneho súboru snímok a bibliografických záznamov PubMed a Crossref. Stav overenia: 24. september 2026.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_esc-2026-srdcove-zlyhavanie-nefrologicky-pohlad_article',
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
          <div class="alert alert-success">
            Hotovo: <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných,
            <?= $skipped ?> preskočených z <?= $total ?> článkov.
            Zaradených do fronty avíz: <?= $queuedTotal ?>.
          </div>
          <p><a href="index.php">← Späť na články</a></p>
        </div>
      </main>
    </body>
    </html>
    <?php
}
