<?php

/**
 * add_htd1801-berberin-ursodeoxycholat-diabetes-2-typu_article.php
 * Odborný článok: HTD1801 pridaný k metformínu pri diabete 2. typu,
 * výsledky štúdie SYMPHONY-2 a hranice kardiorenálnych dôkazov.
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// Dáta článku

$articles = [];

$articles[] = [
    'title'        => 'HTD1801 pri diabete 2. typu: výsledky štúdie SYMPHONY-2 a hranice dôkazov',
    'slug'         => 'htd1801-berberin-ursodeoxycholat-diabetes-2-typu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'HTD1801 pridaný k metformínu znížil v štúdii SYMPHONY-2 HbA1c viac než placebo, hnačka však bola častá. Renálny ani kardiovaskulárny prínos zatiaľ preukázaný nebol.',
    'content'      => <<<'HTML'
<p>HTD1801 pridaný k metformínu znížil v 24-týždňovej štúdii fázy 3 hodnotu glykovaného hemoglobínu (HbA1c) viac než placebo. Najčastejšou nežiaducou udalosťou však bola hnačka. Výsledok podporuje glykemickú účinnosť skúšaného lieku vo vymedzenej populácii, nepreukazuje však ochranu obličiek, zníženie kardiovaskulárneho rizika ani nadradenosť v porovnaní s inými účinnými liekmi.</p>

<h2>Čo je HTD1801</h2>

<p>HTD1801 (angl. <span lang="en">berberine ursodeoxycholate</span>) je skúšaný perorálny liek. Chemicky ide o ekvimolárnu iónovú soľ berberínu a kyseliny ursodeoxycholovej, ktorá v tráviacom trakte disociuje. Nejde o jednoduchú zmes berberínu a kyseliny ursodeoxycholovej.</p>

<p>Toto rozlíšenie je klinicky dôležité. Výsledky štúdie s HTD1801 nemožno preniesť na voľnopredajné výživové doplnky s berberínom, na samostatne podávanú kyselinu ursodeoxycholovú ani na ich svojvoľnú kombináciu. Nemožno z nich vyvodiť ani to, že liek odstraňuje „základnú príčinu“ diabetu 2. typu. Štúdia hodnotila predovšetkým zmenu HbA1c.</p>

<h2>Ako bola navrhnutá štúdia SYMPHONY-2</h2>

<p>SYMPHONY-2 bola multicentrická, randomizovaná, dvojito zaslepená a placebom kontrolovaná štúdia fázy 3, ktorá prebehla v 64 centrách v Číne. Zaradila účastníkov s diabetom 2. typu, u ktorých glykemická kontrola zostávala nedostatočná napriek stabilnej dávke metformínu užívanej najmenej osem týždňov. Podmienkou zaradenia bola hodnota HbA1c od 7,0 do 10,5 % a glykémia nalačno najviac 250,5 mg/dl, teda 13,9 mmol/l.</p>

<p>Publikácia uvádza randomizáciu v pomere 2 : 1:</p>

<ul>
  <li><strong>365 účastníkov</strong> dostávalo HTD1801 v dávke 1 000 mg perorálne dvakrát denne spolu s doterajšou liečbou metformínom,</li>
  <li><strong>184 účastníkov</strong> dostávalo placebo spolu s metformínom.</li>
</ul>

<p>Primárnym koncovým ukazovateľom bola zmena HbA1c od východiskovej hodnoty do 24. týždňa. Register štúdie uvádza, že po dvojito zaslepenej fáze nasledovala 28-týždňová otvorená predĺžená fáza, v ktorej všetci účastníci dostávali HTD1801. Bez súbežnej kontrolnej skupiny však majú tieto dlhšie údaje nižšiu výpovednú hodnotu než randomizované porovnanie počas prvých 24 týždňov.</p>

<h2>Výsledok pre HbA1c</h2>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Zmena HbA1c v štúdii SYMPHONY-2 do 24. týždňa" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Skupina</th>
        <th scope="col">HbA1c na začiatku</th>
        <th scope="col">HbA1c v 24. týždni</th>
        <th scope="col">Priemerná zmena (95 % interval spoľahlivosti)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">HTD1801 + metformín</th>
        <td>8,6 %</td>
        <td>7,4 %</td>
        <td>−1,2 percentuálneho bodu (−1,3 až −1,1)</td>
      </tr>
      <tr>
        <th scope="row">Placebo + metformín</th>
        <td>8,5 %</td>
        <td>7,8 %</td>
        <td>−0,7 percentuálneho bodu (−0,8 až −0,6)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Upravený rozdiel medzi skupinami bol <strong>−0,5 percentuálneho bodu</strong> v prospech HTD1801 (95 % interval spoľahlivosti −0,7 až −0,4; P &lt; 0,0001). Práve tento rozdiel je najdôležitejším odhadom účinku pridania HTD1801. Ak by sa za liečebný účinok považoval samotný pokles o 1,2 percentuálneho bodu v aktívnej skupine, jeho veľkosť by sa nadhodnotila, pretože HbA1c klesol aj v skupine s placebom.</p>

<p>Štúdia nemala aktívny porovnávací liek. Neumožňuje preto tvrdiť, že HTD1801 znižuje HbA1c viac než inhibítor SGLT2, agonista receptora GLP-1 alebo iné antidiabetikum. Rovnako neodpovedá na otázku, ktorá liečba má priaznivejší vplyv na telesnú hmotnosť, riziko hypoglykémie, srdcové zlyhávanie alebo progresiu chronickej choroby obličiek.</p>

<h2>Bezpečnosť: výrazný rozdiel vo výskyte hnačky</h2>

<p>Hnačka bola najčastejšou nežiaducou udalosťou. Vyskytla sa u <strong>23,8 %</strong> účastníkov liečených HTD1801 a u <strong>1,1 %</strong> účastníkov v skupine s placebom. Tri prípady v skupine HTD1801 boli hodnotené ako ťažké; ostatné boli mierne alebo stredne ťažké. Označenie „ťažký stupeň“ vyjadruje intenzitu udalosti a nemožno ho automaticky zamieňať s regulačným pojmom závažná nežiaduca udalosť.</p>

<p>Ťažká hypoglykémia sa nevyskytla v žiadnej skupine. Tento údaj však neznamená, že sa nevyskytla žiadna hypoglykémia, ani nepreukazuje bezpečnosť vo všetkých skupinách pacientov. Dvojito zaslepené porovnanie trvalo 24 týždňov a nebolo dostatočne veľké ani dlhé na spoľahlivé zachytenie veľmi zriedkavých alebo neskorých nežiaducich účinkov.</p>

<p>Z nefrologického hľadiska je hnačka relevantná aj nepriamo. Pretrvávajúce gastrointestinálne straty môžu viesť k hypovolémii a prechodnému zhoršeniu funkcie obličiek, najmä u pacientov užívajúcich diuretiká, blokátory systému renín-angiotenzín alebo inhibítory SGLT2. V štúdiách programu SYMPHONY bola vstupným kritériom eGFR vyššia než 60 ml/min/1,73 m<sup>2</sup>. Účinnosť a bezpečnosť u pacientov s nižšou eGFR preto tieto štúdie nestanovili.</p>

<h2>Čo štúdia nepreukázala</h2>

<ul>
  <li><strong>Ochranu obličiek:</strong> primárny ukazovateľ nezahŕňal albuminúriu, pokles odhadovanej glomerulovej filtrácie (eGFR), zlyhanie obličiek ani potrebu náhrady funkcie obličiek.</li>
  <li><strong>Kardiovaskulárny prínos:</strong> štúdia nebola navrhnutá na hodnotenie infarktu myokardu, cievnej mozgovej príhody, hospitalizácie pre srdcové zlyhávanie ani kardiovaskulárnej mortality.</li>
  <li><strong>Dlhodobú prognózu:</strong> zmena HbA1c počas 24 týždňov je náhradný laboratórny ukazovateľ, nie klinický výsledok.</li>
  <li><strong>Nadradenosť nad štandardnou liečbou:</strong> porovnávacím ramenom bolo placebo pridané k metformínu, nie iný účinný liek.</li>
  <li><strong>Rovnaký účinok mimo skúmanej populácie:</strong> všetky centrá boli v Číne a prenositeľnosť výsledkov na iné populácie treba ešte overiť.</li>
</ul>

<p>V protokole SYMPHONY-2 boli medzi sekundárnymi ukazovateľmi glykémia nalačno, postprandiálna glykémia, inzulínová rezistencia a LDL cholesterol. Zmena laboratórneho ukazovateľa však sama osebe nepreukazuje zlepšenie klinickej prognózy. Najmä pokles lipidového alebo pečeňového laboratórneho ukazovateľa nemožno bez príslušnej výsledkovej štúdie vydávať za dôkaz prevencie aterosklerotických príhod, progresie steatohepatitídy alebo chronickej choroby obličiek.</p>

<p>Združená analýza štúdií SYMPHONY-1 a SYMPHONY-2 prezentovaná v konferenčnom abstrakte ASN opísala zmeny eGFR v podskupinách s mierne zníženou eGFR a s hyperfiltráciou. Išlo však o krátkodobú analýzu programu, ktorého primárnym ukazovateľom bol HbA1c a ktorý zaraďoval iba účastníkov s eGFR nad 60 ml/min/1,73 m<sup>2</sup>. Tento laboratórny signál odôvodňuje ďalší výskum, nie je však dôkazom spomalenia progresie CKD.</p>

<h2>Renálna otázka sa skúma osobitne</h2>

<p>V júli 2026 sa začala samostatná randomizovaná štúdia fázy 2 s registračným číslom NCT07496177 u pacientov s diabetom 2. typu a chronickou chorobou obličiek. Plánuje zaradiť 75 účastníkov a počas 12 týždňov porovnať HTD1801 s placebom. Primárnym ukazovateľom je relatívna zmena pomeru albumínu ku kreatinínu v moči (UACR); medzi sekundárne ukazovatele patria viaceré hodnotenia eGFR.</p>

<p>Táto štúdia môže objasniť krátkodobý vplyv na albuminúriu a hemodynamické či metabolické ukazovatele obličiek. Ani prípadný priaznivý výsledok 12-týždňovej mechanistickej štúdie by však sám osebe nepreukázal spomalenie progresie CKD alebo zníženie rizika zlyhania obličiek. Na to by bola potrebná dlhšia štúdia s klinicky významnými obličkovými výsledkami.</p>

<h2>Vývojový a registračný stav</h2>

<p>K 5. septembru 2026 nebolo v preverovaných regulačných databázach evidované povolenie na uvedenie HTD1801 na trh v Európskej únii ani v USA. Spoločnosť HighTide Therapeutics v oznámení z 10. marca 2026 uviedla, že čínsky regulačný úrad National Medical Products Administration (NMPA) prijal na posúdenie žiadosť o registráciu HTD1801 na liečbu diabetu 2. typu. <strong>Prijatie žiadosti na posúdenie nie je povolením na uvedenie lieku na trh.</strong> Samotné firemné oznámenie výslovne upozorňuje, že úspešné uvedenie lieku na trh nemožno zaručiť.</p>

<p>Publikované výsledky preto nemožno chápať ako návod na predpisovanie HTD1801 ani ako dôvod nahradiť liečbu s preukázaným kardiovaskulárnym alebo renálnym prínosom. Neoprávňujú ani na samoliečbu berberínom alebo kyselinou ursodeoxycholovou.</p>

<h2>Obmedzenia dôkazov</h2>

<ul>
  <li>Najpresvedčivejšie porovnanie trvalo 24 týždňov a hodnotilo HbA1c, nie klinické príhody.</li>
  <li>Štúdia používala placebo, takže neposkytuje priame porovnanie s etablovanou antidiabetickou alebo kardiorenálnou liečbou.</li>
  <li>Výsledky pochádzajú výlučne z centier v Číne.</li>
  <li>Štúdiu financovala spoločnosť Shenzhen HighTide Biopharmaceutical a viacerí spoluautori boli zamestnancami sponzora alebo s ním mali iné deklarované väzby. To výsledok nezneplatňuje, ale zvyšuje význam nezávislej replikácie a dôsledného hodnotenia úplných údajov.</li>
  <li>Otvorená predĺžená fáza nemala súbežnú kontrolnú skupinu s placebom, preto je náchylnejšia na skreslenie než zaslepená fáza.</li>
</ul>

<h2>Záver</h2>

<p>SYMPHONY-2 priniesla kvalitný dôkaz, že HTD1801 pridaný k metformínu počas 24 týždňov znižuje HbA1c viac než placebo. Upravený rozdiel medzi skupinami v zmene HbA1c bol −0,5 percentuálneho bodu v prospech HTD1801. Hnačka sa však v skupine HTD1801 vyskytovala podstatne častejšie.</p>

<p>Pre nefrologickú prax je rovnako dôležité to, čo štúdia neukázala. Nehodnotila renálne ani kardiovaskulárne klinické výsledky a neporovnávala HTD1801 s liekmi, ktoré takýto prognostický prínos už preukázali. HTD1801 je preto vhodné opisovať ako skúšaný liek s preukázaným krátkodobým glykemickým účinkom v štúdii SYMPHONY-2, nie ako etablovanú kardiorenálnu liečbu.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=metformin-sglt2-prva-linia-diabetu">Metformín s predĺženým uvoľňovaním a inhibítor SGLT2 ako nová prvá línia liečby diabetu 2. typu</a></li>
  <li><a href="article.php?slug=vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko">Výber a kombinovanie inhibítorov SGLT2, agonistov GLP-1 a duálnych agonistov pri diabete 2. typu s kardiorenálnym rizikom</a></li>
  <li><a href="article.php?slug=sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky">Šesť inhibítorov SGLT2 nie je šesť zameniteľných liekov</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>Zdroj:</strong> <strong>1. Primárna publikácia SYMPHONY-2:</strong> Ji L, Cheng Z, Ma J, Liu D, Zhang X, Dong X, Lin Y, Yang M, Gan S, Cai H, Wang X, Liu Y, Shi X, Liu K, MacConell L, Yu M, Liu L. HTD1801 in Combination with Metformin for Type 2 Diabetes. <em>NEJM Evidence</em>. 2026;5(7):EVIDoa2500317. doi: <a href="https://doi.org/10.1056/EVIDoa2500317" target="_blank" rel="noopener noreferrer">10.1056/EVIDoa2500317</a>. PMID 42251702. <a href="https://pubmed.ncbi.nlm.nih.gov/42251702/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. Register SYMPHONY-2:</strong> ClinicalTrials.gov. Efficacy and Safety of Berberine Ursodeoxycholate (HTD1801) in Patients With Type 2 Diabetes Inadequately Controlled With Metformin. NCT06353347. <a href="https://clinicaltrials.gov/study/NCT06353347" target="_blank" rel="noopener noreferrer">Záznam štúdie</a>.</em></small></p>

<p id="odborny-zdroj-3"><small><em><strong>3. Predchádzajúca štúdia fázy 2:</strong> Ji L, Ma J, Ma Y, Cheng Z, Gan S, Yuan G, Liu D, Li S, Liu Y, Xue X, Bai J, Wang K, Cai H, Li S, Liu K, Yu M, Liu L. Berberine Ursodeoxycholate for the Treatment of Type 2 Diabetes: A Randomized Clinical Trial. <em>JAMA Network Open</em>. 2025;8(3):e2462185. doi: <a href="https://doi.org/10.1001/jamanetworkopen.2024.62185" target="_blank" rel="noopener noreferrer">10.1001/jamanetworkopen.2024.62185</a>. PMID 40029660. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11877176/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p id="odborny-zdroj-4"><small><em><strong>4. Prebiehajúca mechanistická štúdia pri CKD:</strong> ClinicalTrials.gov. A Randomized, Double-blind, Placebo-controlled Mechanistic Study to Evaluate the Effect of HTD1801 in Delaying the Progression of Renal Impairment in Patients With Type 2 Diabetes and Chronic Kidney Disease. NCT07496177. <a href="https://clinicaltrials.gov/study/NCT07496177" target="_blank" rel="noopener noreferrer">Záznam štúdie</a>.</em></small></p>

<p id="odborny-zdroj-5"><small><em><strong>5. Obličková podskupinová analýza programu SYMPHONY:</strong> Surmont FA, Gao L, Liu K, Liberman A, MacConell L, Yu M, Liu L, Ji L; SYMPHONY Investigators. Evidence of Kidney Benefit with HTD1801 in Patients with Mild Renal Impairment. ASN Kidney Week 2025, abstrakt TH-PO1190. doi: <a href="https://doi.org/10.1681/ASN.202552fxp7aj" target="_blank" rel="noopener noreferrer">10.1681/ASN.202552fxp7aj</a>. <a href="https://www.asn-online.org/education/kidneyweek/2025/program-abstract.aspx?controlId=4399019" target="_blank" rel="noopener noreferrer">Abstrakt ASN</a>.</em></small></p>

<p id="odborny-zdroj-6"><small><em><strong>6. Registračný míľnik v Číne:</strong> HighTide Therapeutics, Inc. HighTide Therapeutics Announces Acceptance of New Drug Application for HTD1801 by China's National Medical Products Administration. Oznámenie pre Hong Kong Stock Exchange, 10. marca 2026. <a href="https://www1.hkexnews.hk/listedco/listconews/sehk/2026/0310/2026031000738.pdf" target="_blank" rel="noopener noreferrer">Oficiálne zverejnené oznámenie</a>.</em></small></p>

<p id="odborny-zdroj-7"><small><em><strong>7. Regulačné databázy EÚ a USA:</strong> European Commission, <a href="https://ec.europa.eu/health/documents/community-register/html/reg_index_inn.htm" target="_blank" rel="noopener noreferrer">Union Register of medicinal products, register podľa INN</a>; U.S. Food and Drug Administration, <a href="https://precision.fda.gov/uniisearch/srs/unii/vm8kq3w8gm" target="_blank" rel="noopener noreferrer">Global Substance Registration System, záznam HTD1801</a>. Záznam látky v GSRS identifikuje substanciu, ale neznamená schválenie lieku.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, autorský zoznam, výsledky HbA1c a bezpečnostné údaje boli overené 5. septembra 2026 podľa abstraktu primárnej publikácie indexovaného v PubMed. Návrh štúdie, zoznam centier a plánované renálne ukazovatele boli overené v ClinicalTrials.gov. Číselné výsledky otvorenej predĺženej fázy uvádzané iba v sekundárnych a firemných materiáloch nie sú v článku prezentované ako rovnocenný dôkaz.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie, platné odporúčania ani aktuálnu informáciu o lieku.</em></small></p>
HTML,
];

// Vkladanie do databázy

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_htd1801_berberin_ursodeoxycholat_diabetes_2_typu',
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
