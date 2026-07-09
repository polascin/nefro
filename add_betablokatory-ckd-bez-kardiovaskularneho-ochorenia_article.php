<?php
/**
 * add_betablokatory-ckd-bez-kardiovaskularneho-ochorenia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: Betablokátory pri CKD bez známeho kardiovaskulárneho ochorenia
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_betablokatory-ckd-bez-kardiovaskularneho-ochorenia_article.php"
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
    'title'        => 'Betablokátory pri chronickej chorobe obličiek bez známeho kardiovaskulárneho ochorenia: opatrnosť je namieste',
    'slug'         => 'betablokatory-ckd-bez-kardiovaskularneho-ochorenia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kórejská kohortová štúdia v Clinical Kidney Journal ukazuje asociáciu betablokátorov s vyššou mortalitou a MACE u pacientov s CKD bez známeho kardiovaskulárneho ochorenia.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek (CKD) je významným rizikovým faktorom kardiovaskulárnej morbidity a mortality. Pacienti so zníženou eGFR majú vyššie riziko ischemickej choroby srdca, srdcového zlyhávania, cievnej mozgovej príhody aj náhlej smrti. V klinickej praxi sa preto často používa intenzívna kardiovaskulárna prevencia vrátane antihypertenzívnej liečby.</p>

<p>Betablokátory majú pevné miesto pri viacerých kardiologických indikáciách, najmä po infarkte myokardu, pri srdcovom zlyhávaní so zníženou ejekčnou frakciou, pri niektorých arytmiách a pri symptomatickej ischemickej chorobe srdca. Menej jasná je však ich úloha u pacientov s CKD, ktorí ešte nemajú preukázané kardiovaskulárne ochorenie.</p>

<p>Nová populačná kohortová štúdia publikovaná v <em>Clinical Kidney Journal</em> prináša dôležitý signál: u pacientov s CKD bez predchádzajúceho kardiovaskulárneho ochorenia bolo užívanie betablokátorov spojené s vyššou mortalitou a vyšším rizikom veľkých kardiovaskulárnych príhod. Tento výsledok treba interpretovať opatrne, pretože ide o observačnú štúdiu. Napriek tomu je klinicky významný a podporuje potrebu presnejšej indikácie betablokátorov v nefrologickej populácii.</p>

<h2>Prečo je táto otázka dôležitá</h2>

<p>Pacienti s CKD majú často arteriálnu hypertenziu, sympatikovú aktiváciu, hypertrofiu ľavej komory, metabolické poruchy a vysoké bazálne kardiovaskulárne riziko. Betablokátory sa preto môžu zdať ako logická preventívna voľba.</p>

<p>Problém je, že účinnosť lieku závisí od indikácie. To, čo je prospešné po infarkte myokardu alebo pri systolickom srdcovom zlyhávaní, nemusí automaticky prinášať benefit pri primárnej prevencii u pacienta s CKD bez známeho kardiovaskulárneho ochorenia.</p>

<p>Navyše pacienti s CKD bývajú v randomizovaných kardiovaskulárnych štúdiách často podreprezentovaní. Dôkazy pre mnohé liečebné stratégie sú preto menej priame než u pacientov s normálnou funkciou obličiek.</p>

<h2>Cieľ štúdie</h2>

<p>Autori hodnotili, či je užívanie betablokátorov spojené s mortalitou a kardiovaskulárnymi príhodami u pacientov s chronickou chorobou obličiek, ktorí nemali známe kardiovaskulárne ochorenie.</p>

<p>Základná klinická otázka znela: prináša dlhodobé užívanie betablokátorov u tejto skupiny pacientov preventívny benefit, alebo môže byť spojené s nepriaznivými výsledkami?</p>

<h2>Dizajn a populácia štúdie</h2>

<p>Išlo o <strong>celonárodnú kohortovú štúdiu</strong> využívajúcu údaje kórejského systému zdravotného poistenia. Pacienti boli identifikovaní v rokoch 2012 až 2015.</p>

<p>Chronická choroba obličiek bola definovaná ako eGFR <strong>&lt; 60 ml/min/1,73 m²</strong> aspoň pri dvoch meraniach. Do analýzy boli zaradení pacienti bez predchádzajúceho preukázaného kardiovaskulárneho ochorenia.</p>

<p>Za používateľov betablokátorov boli považovaní pacienti, ktorí mali predpísaný betablokátor najmenej <strong>6 mesiacov</strong>.</p>

<p>Autori použili <strong>propensity score matching</strong> v pomere 1 : 2, teda sa snažili štatisticky vyrovnať rozdiely medzi používateľmi a nepoužívateľmi betablokátorov. Po párovaní bolo zahrnutých:</p>

<ul>
  <li>9 067 používateľov betablokátorov,</li>
  <li>17 094 nepoužívateľov betablokátorov.</li>
</ul>

<p>Primárne sledované výsledky boli celková mortalita a 4-bodové MACE, teda veľké nežiaduce kardiovaskulárne príhody zahŕňajúce kardiovaskulárne úmrtie, nefatálny infarkt myokardu, cievnu mozgovú príhodu a hospitalizáciu pre srdcové zlyhávanie.</p>

<h2>Hlavné výsledky</h2>

<p>Užívanie betablokátorov bolo spojené so zvýšeným rizikom celkovej mortality aj kardiovaskulárnych príhod.</p>

<p>V porovnaní s nepoužívateľmi mali používatelia betablokátorov:</p>

<ul>
  <li>vyššie riziko celkovej mortality: HR 2,09; 95 % CI 1,96 až 2,24,</li>
  <li>vyššie riziko MACE: HR 1,33; 95 % CI 1,26 až 1,41.</li>
</ul>

<p>Zvýšené riziko sa prejavilo aj pri jednotlivých zložkách kombinovaného kardiovaskulárneho ukazovateľa:</p>

<ul>
  <li>kardiovaskulárna smrť: HR 2,07; 95 % CI 1,66 až 2,57,</li>
  <li>infarkt myokardu: HR 1,29; 95 % CI 1,13 až 1,46,</li>
  <li>cievna mozgová príhoda: HR 1,21; 95 % CI 1,13 až 1,31,</li>
  <li>hospitalizácia pre srdcové zlyhávanie: HR 1,58; 95 % CI 1,44 až 1,72.</li>
</ul>

<p>Subanalýzy ukázali, že riziko mortality bolo výraznejšie pri nižších hodnotách eGFR. Vyššie riziko nepriaznivých príhod bolo pozorované pri karvedilole v porovnaní s inými betablokátormi.</p>

<h2>Ako tieto výsledky interpretovať</h2>

<p>Výsledky neznamenajú, že betablokátory sú všeobecne škodlivé u všetkých pacientov s CKD. Taká interpretácia by bola nesprávna.</p>

<p>Štúdia sa týkala špecifickej skupiny pacientov: osôb s CKD bez už známeho kardiovaskulárneho ochorenia. Ide teda o otázku používania betablokátorov v populácii, kde indikácia nemusí byť taká pevná ako pri srdcovom zlyhávaní, po infarkte myokardu alebo pri arytmii.</p>

<p>Keďže ide o observačnú analýzu, nemožno vylúčiť reziduálne skreslenie. Pacienti, ktorým lekári predpísali betablokátory, mohli mať horší klinický profil, vyšší krvný tlak, vyššiu sympatikovú aktivitu, subklinické srdcové ochorenie alebo iné rizikové faktory, ktoré neboli v dátach plne zachytené. Autori preto správne uvádzajú, že ďalšie štúdie musia objasniť, či pozorovaná asociácia odráža skutočný efekt liečby, alebo základné riziko pacientov.</p>

<h2>Možné vysvetlenia nepriaznivej asociácie</h2>

<p>Existuje viacero možných mechanizmov alebo vysvetlení, prečo mohli mať používatelia betablokátorov horšie výsledky.</p>

<p>Prvým je <strong>confounding by indication</strong>, teda skreslenie podľa indikácie. Pacienti liečení betablokátormi mohli byť rizikovejší už pred začatím liečby, aj keď nemali formálne diagnostikované kardiovaskulárne ochorenie.</p>

<p>Druhým vysvetlením môže byť <strong>maskované alebo subklinické kardiovaskulárne ochorenie</strong>. Pacient mohol dostať betablokátor pre symptómy, tachykardiu, tlakové špičky alebo podozrenie na ischemické ťažkosti, ktoré sa v administratívnych dátach neprejavili ako etablovaná diagnóza.</p>

<p>Tretím faktorom je možný vplyv betablokátorov na:</p>

<ul>
  <li>bradykardiu,</li>
  <li>ortostatickú hypotenziu,</li>
  <li>zhoršenie tolerancie záťaže,</li>
  <li>maskovanie hypoglykémie u diabetikov,</li>
  <li>metabolické parametre,</li>
  <li>periférnu perfúziu,</li>
  <li>intradialyzačnú alebo interdialyzačnú hemodynamiku pri pokročilom CKD.</li>
</ul>

<p>Tieto mechanizmy však štúdia priamo nedokazuje. Sú to biologicky možné vysvetlenia, nie definitívne závery.</p>

<h2>Karvedilol a rozdiely medzi betablokátormi</h2>

<p>Štúdia uvádza vyššie riziko nepriaznivých príhod pri karvedilole v porovnaní s inými betablokátormi. Tento nález je zaujímavý, ale treba ho interpretovať opatrne.</p>

<p>Karvedilol sa často používa u pacientov so srdcovým zlyhávaním, hypertrofiou ľavej komory, horším tlakovým profilom alebo vyšším kardiometabolickým rizikom. Preto aj tento výsledok môže byť ovplyvnený klinickým výberom pacientov.</p>

<p>Z farmakologického hľadiska sa betablokátory líšia kardioselektivitou, vazodilatačnými vlastnosťami, lipofilitou, elimináciou, vplyvom na metabolizmus a dialyzovateľnosťou. Pri CKD preto nemožno triedu betablokátorov považovať za úplne homogénnu.</p>

<h2>Praktický význam pre nefrologickú ambulanciu</h2>

<p>Pre nefrológa je hlavné posolstvo praktické: betablokátor by nemal byť u pacienta s CKD predpisovaný automaticky iba preto, že pacient má vysoké kardiovaskulárne riziko. Má mať jasnú indikáciu.</p>

<p>Silnejšie indikácie zahŕňajú najmä:</p>

<ul>
  <li>srdcové zlyhávanie so zníženou ejekčnou frakciou,</li>
  <li>stav po infarkte myokardu podľa aktuálnych kardiologických odporúčaní,</li>
  <li>niektoré tachyarytmie,</li>
  <li>symptomatickú angínu pectoris,</li>
  <li>vybrané situácie pri ťažko kontrolovateľnej hypertenzii,</li>
  <li>potrebu kontroly srdcovej frekvencie.</li>
</ul>

<p>Naopak, pri nekomplikovanej hypertenzii u pacienta s CKD bez kardiovaskulárneho ochorenia nebývajú betablokátory zvyčajne prvou voľbou. V mnohých prípadoch majú prioritu inhibítory RAAS, blokátory kalciových kanálov, diuretiká podľa objemového stavu a ďalšie lieky podľa albuminúrie, eGFR, kaliémie a tolerancie.</p>

<h2>Čo má lekár pri betablokátore skontrolovať</h2>

<p>Ak pacient s CKD užíva betablokátor, nie je správne ho bezhlavo vysadiť. Dôležité je najprv overiť dôvod liečby.</p>

<p>V praxi je vhodné skontrolovať:</p>

<ul>
  <li>pôvodnú indikáciu betablokátora,</li>
  <li>prítomnosť ischemickej choroby srdca,</li>
  <li>anamnézu infarktu myokardu,</li>
  <li>ejekčnú frakciu ľavej komory,</li>
  <li>výskyt arytmie,</li>
  <li>srdcovú frekvenciu,</li>
  <li>krvný tlak vrátane ortostatických zmien,</li>
  <li>príznaky únavy, závratov alebo synkopy,</li>
  <li>eGFR a stupeň CKD,</li>
  <li>súbežnú antihypertenzívnu liečbu,</li>
  <li>riziko hyperkaliémie a objemový stav.</li>
</ul>

<p>Ak indikácia nie je jasná, je rozumné liečbu prehodnotiť v spolupráci s kardiológom alebo internistom. Vysadenie má byť postupné, najmä pri dlhodobom užívaní, aby sa predišlo rebound tachykardii, zhoršeniu angíny alebo hypertenzným reakciám.</p>

<h2>Čo táto štúdia nemení</h2>

<p>Táto práca nemení základné postavenie betablokátorov pri jasných kardiologických indikáciách. Pacient s CKD a srdcovým zlyhávaním so zníženou ejekčnou frakciou môže z betablokátora významne profitovať. Podobne pacient s určitou arytmiou alebo po infarkte myokardu môže mať dôvod na pokračovanie liečby.</p>

<p>Štúdia skôr upozorňuje, že extrapolácia benefitov z kardiologických indikácií na primárnu prevenciu u pacientov s CKD bez známeho kardiovaskulárneho ochorenia môže byť problematická.</p>

<h2>Limity štúdie</h2>

<p>Najväčším limitom je observačný charakter. Aj kvalitné párovanie podľa propensity score nedokáže odstrániť všetky rozdiely medzi skupinami. Administratívne databázy môžu nepresne zachytávať diagnózy, závažnosť ochorenia, symptómy, skutočnú adherenciu k liečbe, dôvod predpisu, echokardiografické parametre a laboratórne detaily.</p>

<p>Štúdia tiež neodpovedá na otázku, či konkrétny betablokátor pri presne definovanej indikácii zlepšuje alebo zhoršuje prognózu. Nejde o randomizovanú klinickú štúdiu a výsledky nemožno automaticky preniesť na všetky populácie mimo kórejského zdravotného systému.</p>

<p>Dôležité je aj to, že pacienti bez etablovaného kardiovaskulárneho ochorenia mohli mať nediagnostikované subklinické ochorenie, ktoré ovplyvnilo predpis betablokátora aj výsledky.</p>

<h2>Klinické odporúčanie z pohľadu nefrológa</h2>

<p>Najrozumnejší záver je opatrný a praktický. U pacientov s CKD bez jasného kardiovaskulárneho ochorenia treba betablokátory používať selektívne, nie rutinne.</p>

<p>Liečba má byť individualizovaná podľa:</p>

<ul>
  <li>kardiologickej indikácie,</li>
  <li>stupňa CKD,</li>
  <li>krvného tlaku,</li>
  <li>srdcovej frekvencie,</li>
  <li>albuminúrie,</li>
  <li>prítomnosti diabetu,</li>
  <li>objemového stavu,</li>
  <li>tolerancie liečby,</li>
  <li>celkového rizika pacienta.</li>
</ul>

<p>Ak je cieľom iba liečba hypertenzie, treba zvážiť, či nie je vhodnejšia iná lieková skupina s lepším dôkazovým zázemím v CKD populácii. Ak je však prítomná jasná indikácia, betablokátor má svoje miesto a výsledky tejto štúdie nemajú viesť k jeho automatickému vysadeniu.</p>

<h2>Záver</h2>

<p>Kórejská celonárodná kohortová štúdia ukázala, že u pacientov s chronickou chorobou obličiek bez predchádzajúceho kardiovaskulárneho ochorenia bolo užívanie betablokátorov spojené s vyššou celkovou mortalitou a vyšším rizikom veľkých kardiovaskulárnych príhod. Riziko bolo výraznejšie pri nižšej eGFR a nepriaznivejšie výsledky boli pozorované pri karvedilole v porovnaní s inými betablokátormi.</p>

<p>Tieto údaje neznamenajú, že betablokátory sú škodlivé pri jasných kardiologických indikáciách. Znamenajú však, že ich používanie pri CKD bez etablovaného kardiovaskulárneho ochorenia má byť dobre odôvodnené. V nefrologickej praxi je vhodné pravidelne prehodnocovať indikáciu, dávku, toleranciu a alternatívy antihypertenzívnej liečby.</p>

<hr>

<p><em><strong>Zdroj:</strong> Han SH, Kim M, Lee J, Han SY. Higher cardiovascular risk observed with beta-blockers in CKD patients without prior cardiovascular disease. <em>Clinical Kidney Journal</em>. 2026;19(7):sfag204. Publikované online 12. júna 2026. DOI: <a href="https://doi.org/10.1093/ckj/sfag204" target="_blank" rel="noopener noreferrer">10.1093/ckj/sfag204</a>. PubMed: <a href="https://pubmed.ncbi.nlm.nih.gov/42389200/" target="_blank" rel="noopener noreferrer">42389200</a>.</em></p>
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
