<?php
/**
 * add_obezita-kardiometabolicke-zdravie-ckd-ckm-ramec_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie: Mathew et al. (Clinical Journal of the American Society
 * of Nephrology, 2026).
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
    'title'        => 'Obezita a kardiometabolické zdravie pri chorobe obličiek: od životného štýlu k viaczložkovej stratégii',
    'slug'         => 'obezita-kardiometabolicke-zdravie-ckd-ckm-ramec',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Prehľad v CJASN zhŕňa, ako obezita poškodzuje obličku priamo aj nepriamo a prečo sa jej manažment pri CKD posunul od prevažne režimového prístupu k viaczložkovej stratégii s inkretínovou liečbou. Nové je aj poznanie, že rozhoduje rozloženie tuku – nielen hmotnosť.',
    'content'      => <<<'HTML'
<p>Obezita už dávno nie je len sprievodným javom chronickej choroby obličiek (CKD). Je samostatným patofyziologickým činiteľom, ktorý zvyšuje riziko vzniku aj progresie ochorenia obličiek, urýchľuje kardiovaskulárne komplikácie a zhoršuje metabolický profil pacienta. Prehľadová práca Mathewa a kolektívu, publikovaná v roku 2026 v časopise <em>Clinical Journal of the American Society of Nephrology</em>, tieto väzby zhŕňa v rámci <strong>kardio-obličkovo-metabolického (CKM) rámca</strong>.</p>

<p>Pre nefrologickú prax je podstatný posun v uvažovaní: obezitu netreba vnímať ako komorbiditu vedľa CKD, ale ako stav, ktorý priamo ovplyvňuje hemodynamiku obličky, zápal, glomerulárny tlak, albuminúriu aj dlhodobú prognózu.</p>

<h2>Ako obezita poškodzuje obličku</h2>

<p>Prehľad rozlišuje <strong>priame a nepriame mechanizmy</strong>, čo je pri klinickej úvahe užitočné rozlíšenie:</p>

<div class="table-responsive" role="region" aria-label="Mechanizmy poškodenia obličiek pri obezite" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Dráha</th>
      <th scope="col">Mechanizmus</th>
      <th scope="col">Klinický prejav</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Priama</th>
      <td>Glomerulárna hyperfiltrácia a zvýšený intraglomerulárny tlak</td>
      <td>Proteinúria, zväčšenie glomerulov, poškodenie podocytov</td>
    </tr>
    <tr>
      <th scope="row">Priama</th>
      <td>Tubulárne poškodenie</td>
      <td>Tubulointersticiálne zmeny nezávislé od glomerulárnej dráhy</td>
    </tr>
    <tr>
      <th scope="row">Nepriama</th>
      <td>Diabetes, hypertenzia, kardiovaskulárno-metabolické ochorenie</td>
      <td>Progresia CKD cez etablované rizikové faktory</td>
    </tr>
  </tbody>
</table>
</div>

<p>K tomu sa pridáva zápalová a hormonálna aktivita tukového tkaniva. Tukové tkanivo nie je pasívnym zásobným orgánom – produkuje cytokíny a adipokíny, ktoré prispievajú k systémovému zápalu, endotelovej dysfunkcii, inzulínovej rezistencii a fibrotizácii. Obezita zároveň podporuje aktiváciu systému renín–angiotenzín–aldosterón a sympatikového nervového systému, čo zhoršuje hypertenziu aj tlakové zaťaženie glomerulu.</p>

<p>Klinicky podstatné je, že obezita môže poškodzovať obličku <strong>aj bez prítomnosti diabetu</strong>. Tento obraz sa označuje ako obezitná glomerulopatia a typicky sa prejavuje proteinúriou s pomalou progresiou. Môže sa však kombinovať s inými nefropatiami a urýchľovať ich priebeh.</p>

<h2>Nie hmotnosť, ale rozloženie tuku</h2>

<p>Jedným z najpraktickejších posolstiev prehľadu je, že <strong>rozloženie tukového tkaniva ovplyvňuje poškodenie cieľových orgánov</strong>. Pribúdajú dôkazy, že s CKD súvisia predovšetkým <strong>viscerálne a ektopické perirenálne tukové depozity</strong> – nie samotná celková hmotnosť.</p>

<p>Populačné štúdie to potvrdzujú: ukazovatele adipozity sa spájajú s vyšším rizikom vzniku CKD, jej progresie aj zlyhania obličiek.</p>

<p>Z toho vyplýva priamy dôsledok pre hodnotenie pacienta. <strong>Index telesnej hmotnosti (BMI) je praktický, ale sám osebe nedostatočný.</strong> U niektorých pacientov neodráža ani metabolické riziko, ani zloženie tela – najmä u starších osôb, pri sarkopénii a pri chronickom ochorení. Pri hodnotení preto patrí k BMI aj obvod pása, posúdenie viscerálnej adipozity, krvný tlak, glykemický stav, albuminúria, eGFR, lipidový profil, známky spánkového apnoe a funkčná zdatnosť vrátane rizika sarkopénie.</p>

<h2>Posun v liečbe: od režimu k viaczložkovej stratégii</h2>

<p>Hlavná téza prehľadu je, že s príchodom novších liekov sa manažment obezity pri CKD <strong>presunul od prevažne režimového prístupu k ucelenej viaczložkovej stratégii</strong>. Tá kombinuje farmakoterapiu s preukázaným kardio-obličkovo-metabolickým prínosom so štruktúrovaným nutričným vedením, individualizovanou pohybovou aktivitou a dlhodobou behaviorálnou podporou.</p>

<h3>Režimové opatrenia</h3>

<p>Základom zostáva energetická reštrikcia, zvýšenie pohybovej aktivity, obmedzenie ultraspracovaných potravín, primeraný príjem bielkovín a dlhodobá edukácia. Samotná režimová intervencia však býva nedostatočná, ak nie je sprevádzaná multidisciplinárnou starostlivosťou – a to nie je zlyhanie pacienta, ale očakávaný priebeh.</p>

<h3>Inkretínová liečba</h3>

<p>Prehľad označuje inkretínovú liečbu za prístup, ktorý <strong>predefinoval liečebné postupy</strong>. Agonisty receptora GLP-1 a duálne inkretínové agonisty pôsobia súčasne na metabolickú dysfunkciu, progresiu CKD aj kardiovaskulárne riziko.</p>

<p>Pripravované sú <strong>trojité inkretínové agonisty</strong>, ktoré sľubujú ešte väčšiu účinnosť v redukcii hmotnosti a metabolickej kontrole. Tu však prehľad výslovne upozorňuje, že <strong>údaje o ich účinnosti a bezpečnosti pri chorobe obličiek zostávajú obmedzené</strong> – ide o očakávanie, nie o doložený prínos.</p>

<p>Pre nefrológa je pri inkretínovej liečbe podstatné sledovať znášanlivosť, objemový stav, gastrointestinálne nežiaduce účinky, nutričný stav a možné interakcie s ostatnou liečbou.</p>

<h3>SGLT2 inhibítory</h3>

<p>SGLT2 inhibítory navodzujú <strong>mierny úbytok hmotnosti</strong>, a to prevažne stratou kalórií pri glykozúrii, pričom súčasne poskytujú kardio-obličkovú ochranu. Ich úloha pri obezite je teda doplnková – nie sú liekom na chudnutie, ale ich metabolický efekt je vítaným pridaným účinkom pri liečbe, ktorá je pri CKD indikovaná z iných dôvodov.</p>

<h3>Bariatrická a metabolická chirurgia</h3>

<p>Klinické štúdie ukazujú, že bariatrická chirurgia dosahuje <strong>podstatný úbytok hmotnosti</strong> a pri CKD sa spája so zlepšením kardio-obličkových výsledkov. U pacientov s CKD môže priniesť zlepšenie hypertenzie, redukciu proteinúrie a zlepšenie kontroly diabetu.</p>

<p>Treba však počítať s perioperačnými komplikáciami, výživovými deficitmi, rizikom nefrolitiázy a s potrebou dlhodobého sledovania minerálov, vitamínov a nutričného stavu. U pacienta s CKD je riziko oxalátovej nefrolitiázy po malabsorpčných výkonoch osobitne relevantné.</p>

<h2>Opatrná interpretácia takzvaného obezitného paradoxu</h2>

<p>V nefrológii sa dlhodobo diskutuje pozorovanie, že u niektorých skupín chronicky chorých – najmä u dialyzovaných pacientov – sa vyšší BMI spája s lepším prežívaním. Tento nález nemožno interpretovať zjednodušene.</p>

<p>Medzi možné vysvetlenia patrí obrátená kauzalita, vplyv sarkopénie a kachexie, rozdiel medzi BMI a skutočným metabolickým rizikom a výberové skreslenie v kohortách. Pre prax z toho vyplýva, že obezita zostáva rizikovým faktorom, redukcia hmotnosti však musí byť individualizovaná a cieľom nie je nižšie číslo na váhe, ale lepšie kardiometabolické a obličkové zdravie pri zachovaní svalovej hmoty.</p>

<h2>Praktické odporúčania pre nefrologickú prax</h2>

<ol>
  <li>U každého pacienta s CKD aktívne hodnotiť obezitu, metabolické riziko a kardiovaskulárne komorbidity – nie iba zaznamenať hmotnosť.</li>
  <li>Nepodceňovať albuminúriu a krvný tlak; pri obezite môžu byť prvými známkami poškodenia obličiek.</li>
  <li>Hodnotiť <strong>rozloženie tuku</strong>, nie iba BMI; pri sarkopénii a u starších pacientov je BMI obzvlášť nespoľahlivé.</li>
  <li>U vhodných pacientov zvážiť inkretínovú liečbu s preukázaným kardio-obličkovým prínosom, pri trojitých agonistoch však počítať s obmedzenými dátami pri CKD.</li>
  <li>Pri ťažkej obezite posúdiť indikáciu bariatrickej alebo metabolickej chirurgie vrátane plánu dlhodobého nutričného sledovania.</li>
  <li>Využívať multidisciplinárny model – nefrológ, diabetológ, kardiológ, nutričný špecialista a obezitológ.</li>
  <li>Komunikovať bez stigmatizácie; stigmatizujúci prístup znižuje adherenciu a je sám osebe prekážkou úspešnej liečby.</li>
</ol>

<h2>Limity</h2>

<p>Ide o <strong>naratívny prehľad</strong>, nie o systematickú syntézu s vlastnou metaanalýzou. Zhŕňa dôkazy rôznej sily – od populačných asociačných štúdií cez randomizované skúšania inkretínovej liečby až po observačné údaje o bariatrickej chirurgii. Odporúčanie stupňovitého postupu je expertné, nie gradované. Pri trojitých inkretínových agonistoch a pri viacerých postupoch v pokročilých štádiách CKD dôkazy stále chýbajú.</p>

<h2>Záver</h2>

<p>Obezita je pri CKD kľúčovým modifikovateľným činiteľom, ktorý zasahuje do patogenézy aj prognózy. V rámci CKM prestáva byť samostatným pridruženým problémom a stáva sa súčasťou liečebnej stratégie.</p>

<p>Pre klinickú prax je najdôležitejšie myslieť na obezitu ako na ochorenie s obličkovými dôsledkami, sledovať pacienta komplexne a nie iba podľa BMI, cielene liečiť metabolické a kardiovaskulárne riziko a u vhodných pacientov využiť moderné farmakologické aj chirurgické možnosti – s vedomím, kde dôkazy pri chorobe obličiek ešte končia.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=obezita-a-oblicky">Obezita a obličky</a></li>
  <li><a href="article.php?slug=kdigo-ckm-syndrom-oblicka-v-strede">Oblička v strede pozornosti: KDIGO a CKM syndróm</a></li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity pri pokročilej CKD a na dialýze</a></li>
  <li><a href="article.php?slug=obezita-multifaktorialne-ochorenie-skrining-nefrologia">Obezita ako multifaktoriálne ochorenie: skríning v nefrologickej praxi</a></li>
  <li><a href="article.php?slug=glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia">Éra GLP-1: nový model starostlivosti o obezitu v nefrológii</a></li>
</ul>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Mathew RO, Hong A, Narasaki Y, Fung E, Cheung D, Han J, Durstenfeld MS, Hsue PY, Rhee CM. Obesity and Cardio-Metabolic Health in Kidney Disease: Implications for Kidney Health, Risk Stratification, and Management. <em>Clinical Journal of the American Society of Nephrology</em>. 2026. doi:10.2215/CJN.0000001233. PMID 42726513. <a href="https://doi.org/10.2215/CJN.0000001233" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42726513/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Ďalšie zdroje:</strong></em></p>

<ol>
  <li><small><em>Ndumele CE, Neeland IJ, Tuttle KR, a kol. A Synopsis of the Evidence for the Science and Clinical Management of Cardiovascular-Kidney-Metabolic (CKM) Syndrome: A Scientific Statement From the American Heart Association. <em>Circulation</em>. 2023;148(20):1636–1664. doi:10.1161/CIR.0000000000001186. PMID 37807920. <a href="https://doi.org/10.1161/CIR.0000000000001186" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/37807920/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Wanner C, Inzucchi SE, Lachin JM, a kol. Empagliflozin and Progression of Kidney Disease in Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2016;375(4):323–334. doi:10.1056/NEJMoa1515920. PMID 27299675. <a href="https://doi.org/10.1056/NEJMoa1515920" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/27299675/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Heerspink HJL, Stefánsson BV, Correa-Rotter R, a kol. Dapagliflozin in Patients with Chronic Kidney Disease. <em>New England Journal of Medicine</em>. 2020;383(15):1436–1446. doi:10.1056/NEJMoa2024816. PMID 32970396. <a href="https://doi.org/10.1056/NEJMoa2024816" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/32970396/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Jastreboff AM, Aronne LJ, Ahmad NN, a kol. Tirzepatide Once Weekly for the Treatment of Obesity. <em>New England Journal of Medicine</em>. 2022;387(3):205–216. doi:10.1056/NEJMoa2206038. PMID 35658024. <a href="https://doi.org/10.1056/NEJMoa2206038" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/35658024/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
  <li><small><em>KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></li>
</ol>

<p><small>Bibliografické údaje boli overené v databáze PubMed 17. septembra 2026. Ide o naratívny prehľad; odporúčania v ňom nie sú gradované. Text nenahrádza individuálne klinické rozhodnutie ani schválenú informáciu o lieku.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_obezita_kardiometabolicke_zdravie_ckd_ckm',
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
