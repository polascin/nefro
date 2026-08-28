<?php

/**
 * add_sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky_article.php
 * Odborný článok: rozdiely v schválených indikáciách jednotlivých inhibítorov SGLT2
 * (FDA vs. EMA) a čo z toho vyplýva pre výber lieku pri HF a CKD.
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
    'title'        => 'Šesť inhibítorov SGLT2 nie je šesť zameniteľných liekov: rozdiely v schválených indikáciách pre srdce a obličky',
    'slug'         => 'sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Spoločný mechanizmus účinku neznamená spoločnú indikáciu. V Európskej únii má indikáciu pre srdcové zlyhávanie aj chronickú chorobu obličiek bez ohľadu na diabetes iba dapagliflozín a empagliflozín — ostatné molekuly triedy nie.',
    'content'      => <<<'HTML'
<p>V bežnej rozprave o „gliflozínoch“ sa trieda inhibítorov SGLT2 často berie ako jeden celok: spoločný mechanizmus, spoločný kardiorenálny prínos, výber podľa dostupnosti. Registračná realita je iná. Jednotlivé molekuly majú výrazne odlišné schválené indikácie a odlišné cieľové populácie štúdií, ktoré k tým indikáciám viedli. Rozdiel nie je formálny: rozhoduje o tom, či pacient s chronickou chorobou obličiek (CKD) alebo srdcovým zlyhávaním (HF) bez diabetu dostane liek v súlade s registráciou, alebo mimo nej.</p>

<h2>Čo trieda skutočne zdieľa</h2>

<p>Spoločná je inhibícia sodíkovo-glukózového kotransportéra 2 v proximálnom tubule a z nej vyplývajúca glykozúria, natriuréza a obnovenie tubuloglomerulovej spätnej väzby. Spoločné však <strong>nie sú</strong> dôkazy. Kardiorenálne indikácie sa opierajú o konkrétne randomizované štúdie s konkrétnymi molekulami v konkrétnych populáciách. Triedový záver typu „SGLT2 chránia obličky“ je užitočná skratka pre výučbu, nie podklad na výber prípravku.</p>

<h2>Rozdiely v americkom označení</h2>

<p>Prehľad rozdielov medzi šiestimi molekulami registrovanými v USA vyzerá takto:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Schválené indikácie jednotlivých inhibítorov SGLT2 v USA" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Molekula (obchodný názov v USA)</th>
        <th scope="col">Rozsah schválených indikácií</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Dapagliflozín (Farxiga)</th>
        <td>Diabetes 2. typu, srdcové zlyhávanie aj chronická choroba obličiek — kardiorenálne indikácie platia bez ohľadu na prítomnosť diabetu.</td>
      </tr>
      <tr>
        <th scope="row">Empagliflozín (Jardiance)</th>
        <td>Diabetes 2. typu, srdcové zlyhávanie aj chronická choroba obličiek — takisto bez ohľadu na prítomnosť diabetu.</td>
      </tr>
      <tr>
        <th scope="row">Kanagliflozín (Invokana)</th>
        <td>Diabetes 2. typu; od roku 2018 zníženie rizika závažných kardiovaskulárnych príhod pri diabete 2. typu so známym kardiovaskulárnym ochorením a od roku 2019 obličkový ukazovateľ, ktorý je však viazaný na <strong>diabetickú chorobu obličiek pri diabete 2. typu</strong>. Samostatnú indikáciu pre srdcové zlyhávanie nemá.</td>
      </tr>
      <tr>
        <th scope="row">Ertugliflozín (Steglatro)</th>
        <td>Iba glykemická kontrola pri diabete 2. typu.</td>
      </tr>
      <tr>
        <th scope="row">Bexagliflozín (Brenzavvy)</th>
        <td>Iba glykemická kontrola pri diabete 2. typu.</td>
      </tr>
      <tr>
        <th scope="row">Sotagliflozín (Inpefa)</th>
        <td>Opačný profil: <strong>bez glykemickej indikácie</strong>; schválený na zníženie rizika kardiovaskulárnej smrti, hospitalizácie pre srdcové zlyhávanie a neodkladnej návštevy pre srdcové zlyhávanie u dospelých so srdcovým zlyhávaním alebo s diabetom 2. typu, CKD a ďalšími kardiovaskulárnymi rizikovými faktormi. Samostatný obličkový ukazovateľ v indikácii nemá.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Prakticky dôležitý je rozdiel pri kanagliflozíne. Jeho obličková indikácia nie je všeobecným prínosom „pri CKD“, ale je viazaná na diabetickú chorobu obličiek. U pacienta s CKD bez diabetu sa naň teda nemožno odvolávať tak ako na dapagliflozín či empagliflozín.</p>

<h2>Európska realita: z porovnania šiestich liekov zostávajú dva</h2>

<p>Toto je časť, ktorú americký prehľad neposkytne a ktorá je pre prax v Slovenskej republike rozhodujúca. V Európskej únii vyzerá situácia podstatne jednoduchšie — a užšie:</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Registračný stav a rozsah indikácií inhibítorov SGLT2 v Európskej únii" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Molekula</th>
        <th scope="col">Stav registrácie v EÚ</th>
        <th scope="col">Rozsah indikácie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Dapagliflozín (Forxiga)</th>
        <td>Registrovaný</td>
        <td>Diabetes 2. typu; symptomatické chronické srdcové zlyhávanie; chronická choroba obličiek — posledné dve <strong>bez ohľadu na diabetes</strong>.</td>
      </tr>
      <tr>
        <th scope="row">Empagliflozín (Jardiance)</th>
        <td>Registrovaný</td>
        <td>Diabetes 2. typu; symptomatické chronické srdcové zlyhávanie; chronická choroba obličiek — takisto bez ohľadu na diabetes.</td>
      </tr>
      <tr>
        <th scope="row">Kanagliflozín (Invokana)</th>
        <td>Registrovaný od 15. novembra 2013</td>
        <td>Iba nedostatočne kontrolovaný diabetes 2. typu (dospelí a deti od 10 rokov). <strong>Samostatnú indikáciu pre srdcové zlyhávanie ani pre chronickú chorobu obličiek v EÚ nemá</strong>, hoci nefroprotektívny účinok bol v štúdiách preukázaný.</td>
      </tr>
      <tr>
        <th scope="row">Ertugliflozín (Steglatro)</th>
        <td>Registrovaný od 21. marca 2018</td>
        <td>Iba diabetes 2. typu.</td>
      </tr>
      <tr>
        <th scope="row">Sotagliflozín</th>
        <td><strong>Nie je dostupný.</strong> Zynquista bol registrovaný 26. apríla 2019 a registrácia bola stiahnutá 22. marca 2022 z obchodných dôvodov.</td>
        <td>Pôvodná indikácia sa týkala diabetu 1. typu ako doplnok k inzulínu. Prípravok so schválenou indikáciou pre srdcové zlyhávanie je registrovaný v USA, nie v EÚ.</td>
      </tr>
      <tr>
        <th scope="row">Bexagliflozín</th>
        <td><strong>Nie je registrovaný v EÚ.</strong></td>
        <td>—</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Z toho vyplýva jednoduchý praktický záver: <strong>v podmienkach Slovenskej republiky sa výber inhibítora SGLT2 pri srdcovom zlyhávaní alebo chronickej chorobe obličiek zužuje na dapagliflozín a empagliflozín.</strong> Ostatné molekuly triedy sú buď nedostupné, alebo majú v EÚ len diabetologickú indikáciu. Rozdiel oproti americkému označeniu je pritom najvýraznejší práve pri kanagliflozíne: obličkový ukazovateľ, ktorý má v USA v označení, v európskej indikácii nie je.</p>

<p>Registrácia v EÚ však nie je to isté ako dostupnosť a úhrada na Slovensku. Aktuálny stav kategorizácie a podmienky úhrady treba overiť v databáze Štátneho ústavu pre kontrolu liečiv a v platnom zozname kategorizovaných liekov.</p>

<h2>Kanagliflozín a amputácie: čo sa v označení zmenilo a čo nie</h2>

<p>Príklad, na ktorom vidno, prečo sa oplatí čítať aktuálnu verziu informácie o lieku:</p>

<ul>
  <li>V programe CANVAS (10 142 účastníkov s diabetom 2. typu a vysokým kardiovaskulárnym rizikom) sa pri kanagliflozíne pozoroval <strong>zvýšený výskyt amputácií: 6,3 oproti 3,4 na 1 000 pacientorokov, pomer rizík 1,97 (95 % IS 1,41 – 2,75)</strong>, prevažne na úrovni prsta alebo metatarzu.</li>
  <li>Na tomto podklade FDA v roku 2017 zaviedla pre kanagliflozín <strong>rámčekové varovanie</strong> (boxed warning).</li>
  <li><strong>26. augusta 2020</strong> FDA rámčekové varovanie <strong>odstránila</strong> po posúdení údajov z troch klinických štúdií a po pribudnutí kardiálnych a obličkových indikácií, ktoré zmenili pomer prínosu a rizika.</li>
  <li><strong>Riziko však nezmizlo.</strong> FDA výslovne uvádza, že riziko amputácie pri kanagliflozíne pretrváva a naďalej je opísané v časti <em>Upozornenia a opatrenia</em>. Odporúčanie venovať pozornosť preventívnej starostlivosti o nohy a sledovať novú bolesť, defekty a infekcie na dolných končatinách zostáva v platnosti.</li>
</ul>

<p>Odstránenie najnápadnejšieho formátu varovania sa teda ľahko číta ako „problém sa vyriešil“. Nevyriešil sa — presunul sa do menej viditeľnej časti dokumentu. Ide o všeobecnejšie poučenie: zmena formátu varovania nie je to isté ako zmena rizika.</p>

<h2>Praktické pravidlo pre výber</h2>

<ol>
  <li><strong>Srdcové zlyhávanie, bez ohľadu na diabetes:</strong> v EÚ dapagliflozín alebo empagliflozín.</li>
  <li><strong>Chronická choroba obličiek, bez ohľadu na diabetes:</strong> v EÚ opäť dapagliflozín alebo empagliflozín.</li>
  <li><strong>Diabetes 2. typu bez HF a bez CKD, kde ide o glykemickú kontrolu:</strong> prichádzajú do úvahy aj ďalšie registrované molekuly triedy; kardiorenálny prínos však na ne nemožno automaticky prenášať.</li>
  <li><strong>Pri zmene prípravku</strong> (napr. z dôvodu dostupnosti alebo úhrady) treba overiť, či nová molekula pokrýva tú indikáciu, pre ktorú bol liek pôvodne nasadený. Zámena v rámci triedy nie je z registračného hľadiska neutrálna.</li>
</ol>

<h2>Limity tohto prehľadu</h2>

<ul>
  <li>Ide o prehľad <strong>schválených indikácií</strong>, nie o porovnanie účinnosti. Neporovnáva molekuly v rovnakých populáciách a nenahrádza priame porovnávacie štúdie, ktoré pre väčšinu dvojíc v tejto triede neexistujú.</li>
  <li>Neprítomnosť indikácie neznamená neprítomnosť účinku. Pri kanagliflozíne je nefroprotektívny účinok pri diabetickej chorobe obličiek doložený, len sa nepremietol do európskeho znenia indikácie.</li>
  <li>Registračný stav, znenie indikácií aj podmienky úhrady sa v čase menia; údaje v článku zodpovedajú stavu ku dňu overenia uvedenému nižšie.</li>
</ul>

<h2>Záver</h2>

<p>Inhibítory SGLT2 zdieľajú mechanizmus, nie indikácie. V USA sa šesť molekúl rozpadá do troch odlišných rolí — široká kardiorenálna indikácia, čisto glykemická indikácia a indikácia zameraná výhradne na kardiálne ukazovatele. V Európskej únii je obraz ešte vyhranenejší: pre srdcové zlyhávanie a chronickú chorobu obličiek bez ohľadu na diabetes prichádzajú do úvahy iba dapagliflozín a empagliflozín. Výber prípravku by preto mal vychádzať z toho, akú indikáciu liečime, nie z príslušnosti lieku k triede.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko">Výber a kombinovanie inhibítorov SGLT2, agonistov GLP-1 a duálnych agonistov pri diabete 2. typu</a></li>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Kombinačná liečba CKD: štyri piliere a hranice dôkazov</a></li>
  <li><a href="article.php?slug=metformin-sglt2-prva-linia-diabetu-2-typu">Metformín a inhibítory SGLT2 v prvej línii liečby diabetu</a></li>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p id="odborny-zdroj-1"><small><em><strong>1. Východiskový materiál:</strong> Medscape. Six Drugs, Three Different Jobs: Why SGLT2 Inhibitors Are Not Interchangeable. 2026. Prehľad rozdielov v schválených indikáciách; odborné tvrdenia, registračný stav a číselné údaje v tomto článku boli overené podľa primárnych a oficiálnych zdrojov uvedených nižšie.</em></small></p>

<p id="odborny-zdroj-2"><small><em><strong>2. Regulačný zdroj (USA):</strong> U.S. Food and Drug Administration. FDA removes Boxed Warning about risk of leg and foot amputations for the diabetes medicine canagliflozin (Invokana, Invokamet, Invokamet XR). Drug Safety Communication, 26. augusta 2020. <a href="https://www.fda.gov/drugs/drug-safety-and-availability/fda-removes-boxed-warning-about-risk-leg-and-foot-amputations-diabetes-medicine-canagliflozin" target="_blank" rel="noopener noreferrer">Oficiálne oznámenie FDA</a>.</em></small></p>

<p id="odborny-zdroj-3"><small><em><strong>3. CANVAS:</strong> Neal B, Perkovic V, Mahaffey KW, de Zeeuw D, Fulcher G, Erondu N, Shaw W, Law G, Desai M, Matthews DR; CANVAS Program Collaborative Group. Canagliflozin and Cardiovascular and Renal Events in Type 2 Diabetes. <em>New England Journal of Medicine</em>. 2017;377(7):644–657. doi: <a href="https://doi.org/10.1056/NEJMoa1611925" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa1611925</a>. PMID 28605608. <a href="https://pubmed.ncbi.nlm.nih.gov/28605608/" target="_blank" rel="noopener noreferrer">PubMed</a>. Registrácia: NCT01032629 a NCT01989754.</em></small></p>

<p id="odborny-zdroj-4"><small><em><strong>4. Európske registrácie:</strong> European Medicines Agency, verejné hodnotiace správy (EPAR): <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/forxiga" target="_blank" rel="noopener noreferrer">Forxiga (dapagliflozín)</a>, <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/jardiance" target="_blank" rel="noopener noreferrer">Jardiance (empagliflozín)</a>, <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/invokana" target="_blank" rel="noopener noreferrer">Invokana (kanagliflozín)</a>, <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/steglatro" target="_blank" rel="noopener noreferrer">Steglatro (ertugliflozín)</a>, <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/zynquista" target="_blank" rel="noopener noreferrer">Zynquista (sotagliflozín, registrácia stiahnutá)</a>.</em></small></p>

<p id="odborny-zdroj-5"><small><em><strong>5. Dostupnosť a úhrada v SR:</strong> Štátny ústav pre kontrolu liečiv — <a href="https://www.sukl.sk/" target="_blank" rel="noopener noreferrer">databáza registrovaných liekov</a>; Ministerstvo zdravotníctva SR — zoznam kategorizovaných liekov.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Registračný stav a znenie indikácií v EÚ boli overené 28. augusta 2026 priamo na stránkach EPAR Európskej agentúry pre lieky. Dátum a znenie oznámenia FDA o odstránení rámčekového varovania boli overené priamo v texte oznámenia. Číselné údaje o amputáciách pochádzajú z publikácie programu CANVAS. Americké obchodné názvy sa uvádzajú preto, že sa v zdrojovom prehľade používajú; na Slovensku nie sú všetky tieto prípravky dostupné.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie ani aktuálnu informáciu o lieku. Pred predpísaním overte platné znenie súhrnu charakteristických vlastností lieku, kontraindikácie, funkciu obličiek a podmienky úhrady.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    // Publikované v dávke šiestich článkov naraz — newsletterové avízo sa zámerne
    // neposiela, aby odberatelia nedostali šesť samostatných e-mailov v tej istej chvíli.
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sglt2_rozdiely_schvalene_indikacie',
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
