<?php
/**
 * add_ckd-samostatny-faktor-polyfarmacie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: CKD ako samostatný faktor polyfarmácie
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ckd-samostatny-faktor-polyfarmacie_article.php"
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

$articles = [];

$articles[] = [
    'title'        => 'Chronická choroba obličiek ako samostatný faktor polyfarmácie',
    'slug'         => 'ckd-samostatny-faktor-polyfarmacie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Polyfarmácia pri CKD nie je len dôsledkom veku a komorbidít. Samotná chronická choroba obličiek zvyšuje liekovú záťaž, riziko interakcií a potrebu pravidelnej liekovej revízie.',
    'content'      => <<<'HTML'
<p>Polyfarmácia je u pacientov s chronickou chorobou obličiek bežná, často nevyhnutná a zároveň riziková. Pacient s CKD má často arteriálnu hypertenziu, diabetes, dyslipidémiu, srdcové zlyhávanie, anémiu, poruchu minerálovo-kostného metabolizmu, metabolickú acidózu, hyperkaliémiu alebo hyperurikémiu. Každá z týchto diagnóz môže viesť k pridaniu ďalšieho lieku.</p>

<p>Krátky odborný list publikovaný v <em>Clinical Kidney Journal</em> upozorňuje na dôležitú myšlienku: chronická choroba obličiek nemá byť chápaná iba ako jedna z komorbidít, ktoré sa náhodne spájajú s polyfarmáciou. CKD môže byť <strong>samostatným a aktívnym motorom polyfarmácie</strong>. Samotné zníženie funkcie obličiek a komplikácie s ním spojené vytvárajú liečebnú záťaž, ktorá zvyšuje počet predpisovaných liekov, náklady, riziko interakcií aj pravdepodobnosť nežiaducich účinkov.</p>

<h2>Prečo je polyfarmácia pri CKD taká častá</h2>

<p>Polyfarmácia sa najčastejšie definuje ako užívanie piatich alebo viacerých liekov. Pri CKD je táto hranica často prekročená už v stredne pokročilých štádiách ochorenia. Nejde pritom automaticky o chybnú liečbu. Mnohé lieky sú indikované správne a znižujú riziko progresie renálneho ochorenia alebo kardiovaskulárnych komplikácií.</p>

<p>Typický pacient s CKD môže užívať:</p>

<ul>
  <li>inhibítor RAAS alebo blokátor receptorov angiotenzínu,</li>
  <li>diuretikum,</li>
  <li>blokátor kalciových kanálov,</li>
  <li>statín,</li>
  <li>antidiabetickú liečbu vrátane inhibítora SGLT2 alebo agonistu GLP-1 receptora,</li>
  <li>lieky na liečbu hyperkaliémie,</li>
  <li>suplementáciu vitamínu D,</li>
  <li>viazače fosfátov,</li>
  <li>liečbu anémie,</li>
  <li>antiagregačnú alebo antikoagulačnú liečbu,</li>
  <li>lieky na srdcové zlyhávanie,</li>
  <li>gastroprotektívnu liečbu,</li>
  <li>analgetiká alebo lieky na neuropatickú bolesť.</li>
</ul>

<p>Takýto zoznam môže byť klinicky opodstatnený. Problém vzniká vtedy, keď sa lieky kumulujú bez pravidelného prehodnocovania, keď sa pokračuje v liečbe bez jasnej indikácie alebo keď sa nové lieky pridávajú na liečbu nežiaducich účinkov predchádzajúcej liečby.</p>

<h2>CKD ako príčina, nie iba následok polyfarmácie</h2>

<p>Autori zdôrazňujú, že CKD má vlastnú patofyziologickú logiku, ktorá prirodzene vedie k nárastu farmakoterapie. S poklesom eGFR sa zvyšuje výskyt komplikácií, ktoré si vyžadujú liečbu. Zároveň sa zhoršuje farmakokinetika mnohých liekov, mení sa distribučný objem, väzba na bielkoviny, renálna eliminácia a citlivosť na nežiaduce účinky.</p>

<p>Preto polyfarmácia pri CKD nie je iba dôsledkom vyššieho veku alebo pridružených diagnóz. Chronická choroba obličiek sama osebe vytvára klinické situácie, ktoré vedú k predpisovaniu ďalších liekov. Tento pohľad je prakticky dôležitý, pretože umožňuje lepšie identifikovať pacientov s vysokým rizikom liekových komplikácií.</p>

<h2>Vhodná a nevhodná polyfarmácia</h2>

<p>Nie každá polyfarmácia je škodlivá. Pri CKD môže byť viacero liekov súčasťou modernej a kvalitnej nefroprotektívnej liečby. Napríklad kombinácia inhibítora RAAS, inhibítora SGLT2, statínu a primeranej antihypertenzívnej liečby môže mať jasný klinický prínos.</p>

<p>Riziková je najmä <strong>nevhodná polyfarmácia</strong>, pri ktorej:</p>

<ul>
  <li>liek nemá aktuálnu indikáciu,</li>
  <li>dávka nie je upravená podľa eGFR,</li>
  <li>prínos lieku je menší než riziko,</li>
  <li>liek duplikuje účinok iného lieku,</li>
  <li>vzniká významná lieková interakcia,</li>
  <li>liečba zhoršuje renálnu funkciu alebo elektrolytovú rovnováhu,</li>
  <li>pacient nerozumie dávkovaniu a neužíva lieky správne.</li>
</ul>

<p>Cieľom nefrológa preto nemá byť mechanické znižovanie počtu liekov. Cieľom má byť <strong>racionálna farmakoterapia</strong>, pri ktorej má každý liek jasný dôvod, primeranú dávku, sledovaný účinok a prijateľné riziko.</p>

<h2>Riziká polyfarmácie u pacientov s CKD</h2>

<p>Pacienti s CKD sú na liekové komplikácie citlivejší než bežná populácia. Znížená renálna eliminácia zvyšuje riziko kumulácie liekov a ich metabolitov. Uremické prostredie mení väzbu liekov na plazmatické bielkoviny a zvyšuje variabilitu účinku.</p>

<p>Medzi najčastejšie riziká patria:</p>

<ul>
  <li>akútne poškodenie obličiek,</li>
  <li>hyperkaliémia,</li>
  <li>hyponatriémia,</li>
  <li>hypotenzia a pády,</li>
  <li>krvácanie pri antikoagulačnej alebo antiagregačnej liečbe,</li>
  <li>hypoglykémia pri niektorých antidiabetikách,</li>
  <li>bradykardia,</li>
  <li>delírium a kognitívne zhoršenie,</li>
  <li>gastrointestinálne komplikácie,</li>
  <li>liekové interakcie,</li>
  <li>nízka adherencia.</li>
</ul>

<p>Osobitne rizikové sú nesteroidové antiflogistiká, nevhodne dávkované antibiotiká, niektoré antidiabetiká, sedatíva, opioidy, anticholinergiká, digoxín, lítium a niektoré antiarytmiká. Pri pokročilom CKD môže aj štandardná dávka bežne používaného lieku predstavovať problém.</p>

<h2>Polyfarmácia a adherencia</h2>

<p>Čím viac liekov pacient užíva, tým vyššie je riziko chýb v dávkovaní. Pacienti často nevedia rozlíšiť, ktorý liek je pre nich nevyhnutný, ktorý je symptomatický a ktorý bol predpísaný iba prechodne. V reálnej praxi sa pridáva aj problém rôznych predpisujúcich lekárov, duplicít, zmenených generík a nedostatočnej komunikácie medzi ambulanciami.</p>

<p>Pri CKD je adherencia mimoriadne dôležitá. Pacient môže mať súčasne lieky užívané ráno, večer, s jedlom, nalačno, len v dialyzačné dni, mimo dialyzačných dní alebo podľa laboratórnych výsledkov. Ak je režim neprehľadný, riziko nesprávneho užívania je vysoké.</p>

<p>Preto má byť súčasťou starostlivosti pravidelná kontrola skutočne užívaných liekov, nielen kontrola zoznamu v zdravotnej dokumentácii.</p>

<h2>Praktický prístup v nefrologickej ambulancii</h2>

<p>Nefrologická ambulancia je vhodným miestom na systematické prehodnotenie liečby. Pri každej významnej zmene eGFR, hospitalizácii, epizóde AKI alebo pri prechode do dialyzačného programu by sa mal aktualizovať celý liekový režim.</p>

<p>Prakticky je vhodné prejsť tieto otázky:</p>

<ul>
  <li>Má každý liek aktuálnu a jasnú indikáciu?</li>
  <li>Je dávka upravená podľa aktuálnej eGFR?</li>
  <li>Neexistuje bezpečnejšia alternatíva?</li>
  <li>Nie je liek duplicitný?</li>
  <li>Nezhoršuje liek hyperkaliémiu, acidózu, hypotenziu alebo retenciu tekutín?</li>
  <li>Nevyžaduje liek monitorovanie hladín alebo častejšiu laboratórnu kontrolu?</li>
  <li>Rozumie pacient, ako má lieky užívať?</li>
  <li>Vie pacient, ktoré lieky má dočasne vysadiť pri dehydratácii, infekcii alebo vracaní?</li>
</ul>

<p>Tento postup je jednoduchý, ale v praxi môže výrazne znížiť riziko liekových komplikácií.</p>

<h2>Depreskripcia nie je zlyhanie liečby</h2>

<p>Depreskripcia znamená plánované, medicínsky odôvodnené zníženie dávky alebo vysadenie lieku, ktorý už nemá priaznivý pomer prínosu a rizika. Pri CKD je to súčasť kvalitnej starostlivosti, nie prejav rezignácie.</p>

<p>Depreskripcia je vhodná najmä pri liekoch bez jasnej indikácie, pri liekoch s vysokým rizikom toxicity, pri duplicitách, pri zmene prognózy pacienta alebo pri prechode na paliatívne ciele liečby.</p>

<p>Dôležité je, aby bola riadená a dokumentovaná. Náhle vysadenie niektorých liekov môže byť nebezpečné, napríklad pri betablokátoroch, benzodiazepínoch, kortikosteroidoch alebo antiepileptikách.</p>

<h2>Úloha farmaceuta a tímovej spolupráce</h2>

<p>Polyfarmáciu nemožno efektívne riešiť iba v rámci krátkej lekárskej kontroly. Veľmi užitočná je spolupráca klinického farmaceuta, praktického lekára, nefrológa, kardiológa, diabetológa a dialyzačného tímu.</p>

<p>Farmaceutická intervencia môže pomôcť identifikovať interakcie, duplicity, nevhodné dávkovanie podľa eGFR a lieky s vysokým anticholinergným alebo sedatívnym zaťažením. Pri dialyzovaných pacientoch je dôležité zohľadniť aj dialyzovateľnosť liekov a časovanie dávok vo vzťahu k dialýze.</p>

<h2>Širší systémový význam</h2>

<p>Autori upozorňujú aj na ekonomický a systémový rozmer. CKD je spojená s vyšším využívaním zdravotnej starostlivosti, častejšími hospitalizáciami, vyššími nákladmi a komplikovanejšou farmakoterapiou. Polyfarmácia tento problém ďalej zvyšuje.</p>

<p>Ak sa CKD chápe ako samostatný faktor polyfarmácie, zdravotnícke systémy môžu lepšie plánovať preventívne stratégie. Patrí sem pravidelné liekové hodnotenie, elektronické upozornenia na dávkovanie podľa eGFR, integrované zdieľanie liekových zoznamov a edukácia pacientov.</p>

<h2>Limity zdroja</h2>

<p>Zdrojový text je publikovaný ako <strong>Letter</strong>, teda krátky odborný list, nie ako pôvodná klinická štúdia ani systematický prehľad. Neposkytuje nové primárne dáta o pacientoch, ale interpretuje existujúce poznatky a upozorňuje na dôležitý klinický problém.</p>

<p>Záver preto treba chápať ako odbornú interpretáciu témy, nie ako kvantitatívny dôkaz kauzality medzi CKD a konkrétnym počtom liekov. Praktická hodnota textu je najmä v tom, že pripomína potrebu aktívneho liekového manažmentu pri každom poklese renálnej funkcie.</p>

<h2>Praktické odporúčanie</h2>

<p>Pri každom pacientovi s CKD by mal byť liekový zoznam považovaný za dynamický dokument. Nestačí vedieť, aké lieky pacient užíva. Treba pravidelne overovať, či ich ešte potrebuje, či ich užíva správne a či sú bezpečné pri aktuálnej funkcii obličiek.</p>

<p>Najpraktickejší postup je:</p>

<ul>
  <li>pravidelne aktualizovať kompletný zoznam liekov vrátane voľnopredajných prípravkov,</li>
  <li>kontrolovať dávkovanie podľa eGFR,</li>
  <li>aktívne vyhľadávať nefrotoxické lieky,</li>
  <li>znižovať duplicitnú a neindikovanú liečbu,</li>
  <li>edukovať pacienta o rizikových situáciách,</li>
  <li>zapájať klinického farmaceuta pri zložitej liečbe,</li>
  <li>pri každej hospitalizácii a prepustení vykonať liekovú rekonciliáciu.</li>
</ul>

<h2>Záver</h2>

<p>Chronická choroba obličiek je významným a často samostatným faktorom polyfarmácie. Nejde len o sprievodný jav vyššieho veku alebo multimorbidity. Samotná CKD vytvára komplikácie, ktoré vedú k pridávaniu ďalších liekov, a zároveň zvyšuje riziko ich nežiaducich účinkov.</p>

<p>Cieľom modernej nefrologickej starostlivosti nemá byť čo najnižší počet liekov za každú cenu, ale bezpečná, účelná a pravidelne prehodnocovaná farmakoterapia. Každý liek má mať jasný dôvod, správnu dávku a sledovaný prínos. Pri CKD je to jedna z najpraktickejších ciest, ako znížiť riziko iatrogénnych komplikácií a zlepšiť kvalitu starostlivosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> Santamaria R, Escobar C, Hernández I, Palacios B, Aranda U, Alcázar R. CKD as an independent driver of polypharmacy. <em>Clinical Kidney Journal</em>. 2026;19(7):sfag184. Letter. Publikované online 3. júna 2026. DOI: <a href="https://doi.org/10.1093/ckj/sfag184" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag184</a>. PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/42395861/" target="_blank" rel="noopener noreferrer">42395861</a>.</em></p>
HTML,
];

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
