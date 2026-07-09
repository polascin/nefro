<?php
/**
 * add_moderna-liecba-melanomu-internista-nefrolog_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): moderná liečba melanómu
 * z pohľadu internistu a nefrológa, vrátane renálnych komplikácií imunoterapie.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_moderna-liecba-melanomu-internista-nefrolog_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Moderná liečba melanómu: čo má vedieť internista a nefrológ',
    'slug'         => 'moderna-liecba-melanomu-internista-nefrolog',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Melanóm už nie je len chirurgicko-dermatologická téma. Imunoterapia a BRAF/MEK liečba menia prognózu, ale prinášajú aj renálne riziká, ktoré má poznať nefrológ.',
    'content'      => <<<'HTML'
<p>Malígny melanóm patrí medzi biologicky najagresívnejšie nádory kože. Jeho incidencia celosvetovo stúpa a podľa epidemiologických odhadov môže do roku 2040 ročná globálna záťaž dosiahnuť približne 510 000 nových prípadov a 96 000 úmrtí. Hoci ide primárne o dermatologicko-onkologickú diagnózu, melanóm má význam aj pre internú medicínu a nefrológiu.</p>

<p>Dôvodom je najmä zásadná zmena systémovej liečby. Inhibítory kontrolných bodov imunity, cielená liečba pri mutácii <strong>BRAF V600</strong>, adjuvantné režimy pri vysokorizikovom ochorení a ústup interferónu či klasickej chemoterapie zmenili prognózu mnohých pacientov. Súčasne však pribudla potreba sledovať imunitne podmienené nežiaduce účinky, renálnu toxicitu, liekové interakcie a bezpečnosť liečby u polymorbidných pacientov s chronickou chorobou obličiek.</p>

<h2>Čo priniesol zdrojový materiál</h2>

<p>Zdrojový materiál Medscape zhŕňa aktuálne princípy liečby melanómu formou klinického kvízu. Venuje sa najmä chirurgickej liečbe lokalizovaného ochorenia, biopsii sentinelovej uzliny, adjuvantnej imunoterapii, cielenej liečbe pri mutácii BRAF V600 a súčasnému ústupu starších liečebných postupov, najmä interferónových režimov a chemoterapie.</p>

<p>Pre nefrológa nie je cieľom preberať úlohu onkológa. Praktický význam spočíva v tom, aby rozumel liečebnému kontextu, vedel včas zachytiť renálne komplikácie a dokázal s onkológom komunikovať o diferenciálnej diagnostike akútneho poškodenia obličiek počas systémovej protinádorovej liečby.</p>

<h2>Chirurgická liečba lokalizovaného melanómu</h2>

<p>Základom liečby lokalizovaného kožného melanómu zostáva <strong>široká lokálna excízia</strong> s adekvátnym bezpečnostným lemom podľa hrúbky nádoru, anatomickej lokalizácie a rizikových charakteristík. Pri vybraných pacientoch sa dopĺňa <strong>biopsia sentinelovej lymfatickej uzliny</strong>.</p>

<p>Biopsia sentinelovej uzliny má predovšetkým stagingový a prognostický význam. Pomáha presnejšie určiť riziko recidívy, patologické štádium a potrebu ďalšej liečby alebo intenzívnejšieho sledovania. V klinickej praxi sa zvažuje najmä pri melanómoch s hrúbkou približne ≥ 1,0 mm a pri tenších léziách okolo ≥ 0,8 mm, ak sú prítomné ďalšie rizikové znaky, napríklad ulcerácia alebo iné nepriaznivé parametre.</p>

<p>Indikácia však nemá byť mechanická. Treba zohľadniť vek, komorbidity, výkonnostný stav, očakávaný prínos výsledku pre ďalšie rozhodovanie a preferencie pacienta.</p>

<h2>Ústup kompletnej disekcie lymfatických uzlín</h2>

<p>Výsledky štúdie <strong>Multicenter Selective Lymphadenectomy Trial II</strong> (MSLT-II) a ďalších prác viedli k zásadnej zmene postoja ku kompletnej disekcii lymfatických uzlín pri pozitívnej sentinelovej uzline.</p>

<p>Okamžitá kompletná disekcia môže zlepšiť regionálnu kontrolu ochorenia a priniesť ďalšie prognostické informácie. Nebolo však preukázané, že rutinná okamžitá disekcia zlepšuje melanómovo špecifické prežívanie. Preto sa už neodporúča paušálne u každého pacienta s metastázou v sentinelovej uzline.</p>

<p>Dôležitý je aj nežiaduci účinok výkonu. Kompletná disekcia zvyšuje riziko lymfedému, ktorý môže dlhodobo zhoršiť kvalitu života, mobilitu a funkčnosť končatiny. V súčasnosti sa preto rozhodovanie presúva k individualizovanému postupu, aktívnemu sledovaniu uzlinovej oblasti a multidisciplinárnej diskusii.</p>

<h2>Adjuvantná liečba pri štádiu II</h2>

<p>Pri melanóme štádia <strong>IIA</strong> sa po adekvátnej chirurgickej liečbe spravidla odporúča sledovanie. Adjuvantná systémová liečba sa mimo klinickej štúdie rutinne neindikuje.</p>

<p>Odlišná situácia je pri štádiách <strong>IIB a IIC</strong>. Ide o vysokorizikové štádium II, kde je riziko recidívy významnejšie. Pacient má byť informovaný o možnostiach adjuvantnej liečby, ale rozhodovanie musí zostať individuálne. Do úvahy vstupuje očakávaný absolútny prínos, riziko toxicity, vek, komorbidity, autoimunitné ochorenia, transplantácia orgánu, renálna rezerva a preferencie pacienta.</p>

<p>V tejto indikácii má miesto monoterapia inhibítorom PD-1, najmä:</p>

<ul>
  <li><strong>pembrolizumab</strong>,</li>
  <li><strong>nivolumab</strong>.</li>
</ul>

<p>Výsledky štúdií KEYNOTE-716 a CheckMate 76K podporili adjuvantnú anti-PD-1 liečbu v štádiách IIB až IIC zlepšením prežívania bez recidívy. Pre internistu a nefrológa je podstatné, že ide o liečbu s iným profilom toxicity než klasická chemoterapia: menej priamo cytotoxickú, ale s rizikom imunitne podmienených orgánových komplikácií.</p>

<h2>Resekované štádium IV bez dôkazu ochorenia</h2>

<p>Vybraní pacienti s kompletne resekovaným melanómom štádia IV, ktorí po metastazektómii nemajú dôkaz aktívneho ochorenia, môžu byť kandidátmi na adjuvantnú imunoterapiu. Ide o klinicky špecifickú skupinu, kde rozhodnutie patrí do rúk multidisciplinárneho tímu.</p>

<p>V praxi sa zohľadňuje biologické správanie nádoru, rozsah pôvodného metastatického ochorenia, interval bez progresie, výkonnostný stav, očakávaný prínos liečby a riziko toxicity. U pacienta s chronickou chorobou obličiek alebo po transplantácii obličky je potrebné rozhodovanie ešte opatrnejšie.</p>

<h2>Metastatický melanóm s mutáciou BRAF V600</h2>

<p>Pri metastatickom melanóme je zásadné molekulové testovanie, najmä prítomnosť mutácie <strong>BRAF V600</strong>. U pacientov s touto mutáciou možno použiť kombinovanú cielenú liečbu inhibítorom BRAF a inhibítorom MEK.</p>

<p>Medzi používané kombinácie patria:</p>

<ul>
  <li><strong>dabrafenib plus trametinib</strong>,</li>
  <li><strong>vemurafenib plus cobimetinib</strong>,</li>
  <li><strong>encorafenib plus binimetinib</strong>.</li>
</ul>

<p>Kombinácie BRAF/MEK majú vyššiu účinnosť a priaznivejší profil než samotná monoterapia inhibítorom BRAF. Ich miesto je dôležité najmä pri potrebe rýchlej odpovede, symptomatickom alebo rýchlo progredujúcom ochorení, pri kontraindikácii imunoterapie alebo v ďalších sekvenčných situáciách podľa rozhodnutia onkologického tímu.</p>

<p>Poradie imunoterapie a cielenej liečby nemožno určiť univerzálne jednou vetou. Závisí od tempa ochorenia, rozsahu metastáz, symptómov, laboratórnych parametrov, komorbidít, autoimunitnej anamnézy, dostupnosti liečby a cieľa liečby. Pre nefrológa je dôležité poznať, že aj cielená liečba môže nepriamo ovplyvniť obličky, napríklad cez horúčku, dehydratáciu, systémový zápal, rabdomyolýzu, elektrolytové poruchy alebo liekové interakcie.</p>

<h2>Interferón a chemoterapia ustúpili do úzadia</h2>

<p>Interferónová liečba, ktorá mala v minulosti miesto v adjuvantnej liečbe melanómu, sa už v tejto indikácii rutinne neodporúča. Dôvodom je nepriaznivý pomer účinnosti a toxicity v porovnaní s modernejšími možnosťami.</p>

<p>Klasická chemoterapia má v súčasnosti skôr okrajové postavenie. Zvyčajne sa zvažuje až ako neskoršia možnosť pri metastatickom melanóme rezistentnom na imunoterapiu a relevantnú cielenú liečbu, alebo tam, kde pacient nemá prístup ku klinickej štúdii či vhodnej modernej liečbe.</p>

<p>Liečba zameraná na NTRK, napríklad <strong>larotrectinib</strong>, má miesto iba pri potvrdenej fúzii génu NTRK. Táto alterácia je pri melanóme zriedkavá, preto nejde o bežný terapeutický postup.</p>

<h2>Melanóm z pohľadu nefrológa</h2>

<p>Pre nefrológa je moderná liečba melanómu dôležitá najmä preto, že inhibítory kontrolných bodov imunity môžu vyvolať imunitne podmienené nežiaduce účinky. Z renálneho hľadiska je najtypickejšia <strong>akútna tubulointersticiálna nefritída</strong>, ktorá sa môže prejaviť vzostupom kreatinínu, poklesom eGFR, sterilnou leukocytúriou, miernou proteinúriou alebo aj nevýrazným močovým nálezom.</p>

<p>Riziko môže byť vyššie alebo diagnosticky zložitejšie u pacientov s preexistujúcou CKD, pri súbežnom užívaní inhibítorov protónovej pumpy, nesteroidových antiflogistík, niektorých antibiotík a ďalších liekov s potenciálom vyvolať intersticiálnu nefritídu. Pred začiatkom imunoterapie je preto vhodné poznať východiskový kreatinín, eGFR, albuminúriu alebo proteinúriu a základný močový sediment.</p>

<p>Pri zhoršení renálnych parametrov počas imunoterapie netreba automaticky pripísať každý vzostup kreatinínu liečbe. Diferenciálna diagnostika zahŕňa hypovolémiu, sepsu, obštrukciu, postkontrastné akútne poškodenie obličiek, nefrotoxické lieky, progresiu CKD, paraneoplastické alebo metastatické komplikácie a až následne imunitne podmienenú nefritídu. Pri nejasnom obraze, aktívnom močovom sedimente, významnej proteinúrii alebo potrebe rozhodnúť o pokračovaní onkologickej liečby môže byť namieste nefrologická konzultácia a biopsia obličky.</p>

<h2>Špecifiká u pacienta po transplantácii obličky</h2>

<p>Osobitnou skupinou sú pacienti po transplantácii obličky. Inhibítory kontrolných bodov imunity môžu u nich zvýšiť riziko rejekcie štepu, pretože mechanizmus liečby zasahuje do rovnováhy protinádorovej imunity a tolerancie transplantovaného orgánu. Rozhodovanie musí byť mimoriadne individualizované a má prebiehať v úzkej spolupráci onkológa, transplantačného nefrológa a pacienta.</p>

<p>V tejto situácii nejde len o otázku účinnosti protinádorovej liečby. Treba otvorene diskutovať riziko straty štepu, potrebu dialýzy, možnosti úpravy imunosupresie, alternatívne onkologické postupy a realistický cieľ liečby.</p>

<h2>Praktické dôsledky pre klinickú prax</h2>

<p>Z internistického a nefrologického pohľadu je vhodné:</p>

<ul>
  <li>skontrolovať východiskovú funkciu obličiek pred začatím systémovej liečby,</li>
  <li>dokumentovať eGFR, albuminúriu alebo proteinúriu a močový sediment,</li>
  <li>aktívne vyhľadávať nefrotoxické lieky a liekové interakcie,</li>
  <li>pri vzostupe kreatinínu odlíšiť bežné príčiny AKI od imunitne podmienenej nefritídy,</li>
  <li>myslieť na dehydratáciu pri horúčkach, hnačkách, vracaní alebo systémovej toxicite,</li>
  <li>pri liečbe BRAF/MEK sledovať klinický stav, teploty, hydratáciu, elektrolyty a svalové príznaky,</li>
  <li>spolupracovať s onkológom pri rozhodovaní o prerušení liečby, kortikoterapii a opätovnom nasadení imunoterapie,</li>
  <li>u transplantovaných pacientov vopred prebrať riziko rejekcie štepu.</li>
</ul>

<p>Dobrá nefrologická starostlivosť v tejto oblasti nie je brzdením onkologickej liečby. Naopak, pomáha ju bezpečne udržať tam, kde je pre pacienta prínosná.</p>

<h2>Limity zdroja</h2>

<p>Zdroj Medscape má edukačný charakter a ide o stručný klinický kvíz, nie o pôvodnú klinickú štúdiu ani kompletné odporúčanie odbornej spoločnosti. Text však zhŕňa viacero princípov, ktoré sú v súlade so súčasným manažmentom melanómu.</p>

<p>V dostupnom zobrazení nebol spoľahlivo uvedený konkrétny autor článku. Medscape zároveň uvádza redakčný a kontrolný proces vrátane použitia viacerých redakčných nástrojov; preto do databázy pôvodných autorov nepridávam mená, ktoré zdroj priamo a spoľahlivo neuvádza.</p>

<h2>Záver</h2>

<p>Súčasná liečba melanómu je založená na presnom stagingu, chirurgickej liečbe lokalizovaného ochorenia, rozumnej indikácii biopsie sentinelovej uzliny, individualizovanej adjuvantnej imunoterapii a cielenej liečbe pri mutácii BRAF V600. Rutinná kompletná disekcia lymfatických uzlín po pozitívnej sentinelovej uzline stratila svoje pôvodné postavenie, pretože nezlepšuje melanómovo špecifické prežívanie a zvyšuje riziko lymfedému.</p>

<p>Pre nefrologickú prax je najdôležitejšie včas rozpoznať renálne komplikácie imunoterapie, neprehliadnuť bežné príčiny akútneho poškodenia obličiek a spolupracovať s onkológom pri manažmente toxicity. Moderná onkologická liečba predlžuje prežívanie, ale zároveň kladie vyššie nároky na interdisciplinárnu starostlivosť.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Reference: „Fast Five Quiz: Melanoma Treatment“, 2025. V dostupnom zobrazení nebol spoľahlivo uvedený konkrétny autor. <a href="https://reference.medscape.com/viewarticle/fast-five-quiz-melanoma-treatment-2025a1000dry" target="_blank" rel="noopener noreferrer">Medscape Reference</a>.</em></p>

<p><em><strong>Doplňujúce odborné zdroje:</strong> ESMO Living Guideline: Cutaneous Melanoma. <a href="https://www.esmo.org/guidelines/living-guidelines/esmo-living-guideline-cutaneous-melanoma" target="_blank" rel="noopener noreferrer">ESMO</a>. National Cancer Institute: Melanoma Treatment (PDQ®). <a href="https://www.cancer.gov/types/skin/hp/melanoma-treatment-pdq" target="_blank" rel="noopener noreferrer">NCI</a>. Faries MB et al. Completion Dissection or Observation for Sentinel-Node Metastasis in Melanoma. <em>New England Journal of Medicine</em>. 2017; DOI: <a href="https://doi.org/10.1056/NEJMoa1613210" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa1613210</a>. Luke JJ et al. KEYNOTE-716. <em>The Lancet</em>. 2022; DOI: <a href="https://doi.org/10.1016/S0140-6736(22)00562-1" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(22)00562-1</a>. Kirkwood JM et al. CheckMate 76K. <em>Nature Medicine</em>. 2023; DOI: <a href="https://doi.org/10.1038/s41591-023-02583-2" target="_blank" rel="noopener noreferrer">10.1038/s41591-023-02583-2</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
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
