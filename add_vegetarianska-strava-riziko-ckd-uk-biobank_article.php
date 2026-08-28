<?php

/**
 * add_vegetarianska-strava-riziko-ckd-uk-biobank_article.php
 * Odborný článok: habituálne stravovacie skupiny a incidentná CKD v UK Biobank.
 * Spracovaný zdroj: Candussi CJ, Bell W, Mutapcic M, Thompson AS, Rohrmann S,
 * Cassidy A, Kühn T, Gaggl M. Sci Rep. 2026;16(1).
 * doi 10.1038/s41598-026-62827-2 (PMID 42547796, PMCID PMC13434791).
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
    'title'        => 'Vegetariánska strava a nižšie riziko vzniku chronickej choroby obličiek v UK Biobank: čo z toho platí pre prax',
    'slug'         => 'vegetarianska-strava-riziko-ckd-uk-biobank',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'U 416 584 dospelých sa počas priemerne 12,9 roka sledovania vegetariánska strava spájala s o 19 % nižším rizikom vzniku chronickej choroby obličiek. Ide o asociáciu a o tému primárnej prevencie, nie o liečebné odporúčanie.',
    'content'      => <<<'HTML'
<p>Vplyv rastlinnej stravy na obličky sa doteraz skúmal prevažne cez skóre kvality stravy, ktoré si výskumník definuje dodatočne — napríklad index zdravej rastlinnej stravy. Takéto skóre je analyticky elegantné, ale nezodpovedá tomu, ako o svojom jedálničku uvažuje pacient. Analýza z kohorty UK Biobank ide inou cestou: pracuje s <strong>habituálnymi stravovacími skupinami</strong>, teda so vzorcami, ktoré v populácii reálne existujú a ktoré človek o sebe vie povedať jednou vetou. Práve to robí jej výsledok priamočiarejšie prenosným do ambulancie — a zároveň zraniteľnejším voči zavádzajúcim faktorom.</p>

<h2>Dizajn</h2>

<p>Východiskom bolo <strong>502 166</strong> účastníkov UK Biobank vo veku <strong>40 – 69 rokov</strong>, získaných v rokoch 2006 – 2010 v 22 vyšetrovacích centrách v Anglicku, Škótsku a Walese. Po vylúčení chýbajúcich údajov o stravovaní, chýbajúcich spojitých premenných (BMI, obvod pása, eGFR, ACR) a po vylúčení <strong>9 057</strong> osôb s prevalentnou chorobou obličiek zostala analytická kohorta <strong>416 584</strong> účastníkov.</p>

<p>Stravovanie sa hodnotilo vstupným dotazníkom frekvencie potravín (FFQ) s 29 položkami. Účastníci sa zaradili do piatich skupín:</p>

<ul>
  <li><strong>Vysoká spotreba mäsa</strong> (<em>high meat eaters</em>) — červené alebo spracované mäso vrátane hydiny viac než 5 – 6× týždenne.</li>
  <li><strong>Nízka spotreba mäsa</strong> (<em>low meat eaters</em>) — tie isté potraviny menej často, ale viac než raz týždenne.</li>
  <li><strong>Konzumenti hydiny</strong> (<em>poultry eaters</em>) — hydina áno, červené a spracované mäso nie.</li>
  <li><strong>Pescatariáni</strong> — bez mäsa a hydiny, ryby áno.</li>
  <li><strong>Vegetariáni</strong> — bez mäsa a rýb. Vegánov bolo na samostatnú analýzu primálo (<strong>n = 367</strong>), preto ich autori zlúčili s vegetariánmi.</li>
</ul>

<p>Incidentná choroba obličiek sa zisťovala z <strong>hospitalizačných záznamov</strong> podľa kódov MKCH-10 (N03, N06, N08, N11 – N16, N18, N19, Z49, I12, I13) a podľa procedurálnej klasifikácie OPCS-4. Prevalentná choroba obličiek na začiatku bola definovaná predchádzajúcou diagnózou alebo vstupným <strong>eGFR &lt; 60 ml/min/1,73 m²</strong>; eGFR sa počítal rovnicou CKD-EPI 2021 z kreatinínu.</p>

<p>Použili sa Coxove modely proporcionálnych rizík s <strong>vekom ako časovou osou</strong>, upravené na pohlavie, príjem, vzdelanie, obvod pása, BMI, pohybovú aktivitu a fajčenie. Etnicita a diabetes 2. typu porušovali predpoklad proporcionality rizík, preto boli v modeloch <strong>stratifikované</strong>, nie adjustované — metodicky korektné riešenie.</p>

<h2>Výsledky</h2>

<p>Počas priemerného sledovania <strong>12,9 (± 2,8) roka</strong> vzniklo ochorenie obličiek u <strong>23 084</strong> účastníkov.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Veľkosť stravovacích skupín, počty incidentných prípadov a pomery rizík vzniku chronickej choroby obličiek" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Stravovacia skupina</th>
        <th scope="col">Počet osôb</th>
        <th scope="col">Incidentné prípady</th>
        <th scope="col">Pomer rizík (95 % IS)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Vysoká spotreba mäsa</th>
        <td>195 030</td>
        <td>11 796 (6 %)</td>
        <td>referencia</td>
      </tr>
      <tr>
        <th scope="row">Nízka spotreba mäsa</th>
        <td>199 478</td>
        <td>10 516 (5 %)</td>
        <td>0,97 (0,943 – 0,996)</td>
      </tr>
      <tr>
        <th scope="row">Konzumenti hydiny</th>
        <td>4 779</td>
        <td>221 (5 %)</td>
        <td>asi o 2 % nižšie, bez štatistickej významnosti</td>
      </tr>
      <tr>
        <th scope="row">Pescatariáni</th>
        <td>9 647</td>
        <td>319 (3 %)</td>
        <td>asi o 9 % nižšie, bez štatistickej významnosti</td>
      </tr>
      <tr>
        <th scope="row">Vegetariáni (vrátane vegánov)</th>
        <td>7 650</td>
        <td>232 (3 %)</td>
        <td>0,81 (0,711 – 0,927)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Štatistickú významnosť v základnom modeli dosiahli len dve skupiny — nízka spotreba mäsa a vegetariáni. Naprieč skupinami však bol viditeľný <strong>odstupňovaný vzťah</strong>, ktorý kopíroval klesajúci príjem živočíšnych bielkovín: o 3 % nižšie riziko pri nízkej spotrebe mäsa, o 2 % u konzumentov hydiny, o 9 % u pescatariánov a o 19 % u vegetariánov.</p>

<h3>Podskupiny a citlivostné analýzy</h3>

<ul>
  <li><strong>Podľa vstupnej funkcie obličiek:</strong> u vegetariánov s normálnou funkciou obličiek bolo riziko nižšie (HR 0,81; 95 % IS 0,706 – 0,936), u osôb s ľahko zníženou funkciou (štádium 1 – 2) sa významný rozdiel nepreukázal. Test heterogenity medzi vrstvami však vyšiel negatívny — rozdiel teda môže odrážať menšiu silu podskupiny, nie odlišný účinok.</li>
  <li><strong>Podľa pohlavia:</strong> u mužov o 21 %, u žien o 16 % nižšie riziko, bez významnej heterogenity.</li>
  <li><strong>Podľa polygénového rizika:</strong> najväčší rozdiel (približne 30 %) sa objavil v skupine s najnižším genetickým rizikom, no asociácie boli konzistentné vo všetkých vrstvách a heterogenita sa nepreukázala.</li>
  <li><strong>Po doplnkovej úprave na vstupný eGFR a ACR</strong> sa asociácia u vegetariánov mierne <em>zosilnila</em> (HR 0,80; 95 % IS 0,676 – 0,938).</li>
  <li><strong>Po úprave na polygénové riziko</strong> zostala u vegetariánov podobná (HR 0,79; 95 % IS 0,67 – 0,94) a u pescatariánov dosiahla významnosť (HR 0,89; 95 % IS 0,75 – 0,97).</li>
  <li><strong>Podľa etnicity</strong> bol smer aj veľkosť asociácií zhodný, hoci odhady u ázijských a černošských účastníkov boli pre menšie počty menej presné.</li>
</ul>

<h2>Ako výsledok čítať</h2>

<p>Ide o prospektívnu observačnú analýzu. Formulácia „vegetariánska strava <strong>bola spojená</strong> s nižším rizikom vzniku choroby obličiek“ je presná; formulácia „chráni obličky“ presahuje to, čo dizajn unesie. Autori si to uvedomujú a v diskusii pripúšťajú, že najmä pri takomto rozsahu efektu môže zistenie sčasti odrážať celkovo zdravší životný štýl, nie samotnú stravu. Základné charakteristiky to podporujú: vegetariáni v tejto kohorte boli mladší, častejšie ženy, mali nižší BMI, vyššie vzdelanie, menej fajčili a pili menej alkoholu.</p>

<p>Ďalšie limity, ktoré patria do každého citovania tejto práce:</p>

<ol>
  <li><strong>Zdravší profil kohorty.</strong> Účastníci UK Biobank sú zdravší než bežná britská populácia a prevažne európskeho pôvodu, čo obmedzuje prenositeľnosť záveru.</li>
  <li><strong>Strava sa merala raz, na začiatku.</strong> Zmena stravovania alebo podhodnotenie niektorých potravín vedie k chybnému zaradeniu — pravdepodobne skôr k <em>podhodnoteniu</em> skutočného rozdielu. Autori zároveň odkazujú na podštúdiu reprodukovateľnosti, podľa ktorej sú typy stravy v tejto kohorte v čase veľmi stabilné.</li>
  <li><strong>Kategórie miešajú dve rôzne kritériá</strong> — frekvenčné (vysoká verzus nízka spotreba mäsa) a vylučovacie (hydina, ryby). Preto sa výsledok nedá čítať ako čistá závislosť dávky a odpovede pre živočíšnu bielkovinu.</li>
  <li><strong>Zachytenie prípadov je nemocničné.</strong> Kódy z hospitalizačných záznamov zachytávajú skôr klinicky rozpoznané a pokročilejšie ochorenie než všetky incidentné prípady.</li>
  <li><strong>Jednorazové meranie eGFR a ACR</strong> pri delení na štádiá sa odchyľuje od klinickej definície, ktorá vyžaduje pretrvávanie odchýlok aspoň tri mesiace. Časť účastníkov zaradených do štádia 1 – 2 teda mohla mať prechodný pokles funkcie alebo prechodnú albuminúriu.</li>
  <li><strong>Zlúčenie vegánov s vegetariánmi</strong> spája dva čiastočne odlišné nutričné profily, čo môže asociáciu zrieďovať.</li>
</ol>

<h2>Navrhované mechanizmy sú zatiaľ hypotézy</h2>

<p>Autori ponúkajú tri okruhy vysvetlení. Žiadny z nich táto práca netestovala — ide o interpretačný rámec, nie o dôkaz.</p>

<ul>
  <li><strong>Nižšia kyslá nálož.</strong> Rastlinná strava obsahuje menej organických fosfátov, sulfátov a nemetabolizovateľných organických kyselín, ktoré vedú k nadbytku protónov. Experimentálne práce ukazujú, že acidifikácia obličkového tkaniva aktivuje lokálny renín-angiotenzínový systém, a klinické práce pri hypertenznej nefropatii ukázali, že strava bohatá na ovocie a zeleninu znižovala čistú exkréciu kyselín a spomaľovala progresiu porovnateľne s perorálnym hydrogenuhličitanom sodným.</li>
  <li><strong>Vláknina, polyfenoly a os črevo – obličky.</strong> Vyšší príjem vlákniny podporuje baktérie produkujúce mastné kyseliny s krátkym reťazcom, čo sa spája s nižším oxidačným stresom a zápalom. Rastlinná strava tiež znižuje hladiny trimetylamín-N-oxidu (TMAO), metabolitu spájaného s vyššou mortalitou a kardiometabolickým rizikom pri chorobe obličiek.</li>
  <li><strong>Minerály a mikroživiny.</strong> Fosfát je v rastlinných potravinách viazaný najmä ako fytát, ktorý sa pre chýbajúcu črevnú fytázu vstrebáva zle — fosfátová nálož je preto pri rovnakom obsahu nižšia než z mäsa a najmä z fosfátových aditív.</li>
</ul>

<h3>Nuansa, ktorá stojí za povšimnutie: draslík a fosfor</h3>

<p>Bežná obava, že rastlinná strava automaticky znamená vysoký príjem draslíka, sa v opisných údajoch tejto kohorty <strong>nepotvrdila</strong>. Vegetariáni mali podľa 24-hodinových nutričných záznamov vyšší príjem vlákniny, ale <strong>nižší</strong> príjem draslíka aj fosforu než skupina s vysokou spotrebou mäsa. Konzumenti mäsa mali zároveň vyššie vylučovanie sodíka, kreatinínu a mikroalbumínu močom. Ide o opisné porovnanie bez štatistického testovania, no dobre ilustruje, že „vegetariánska strava“ nie je synonymom „stravy bohatej na draslík“ — rozhoduje zloženie konkrétneho jedálnička, nie nálepka.</p>

<h2>Čo z toho pre prax</h2>

<p>Zistenie sa týka <strong>primárnej prevencie</strong>, teda populácie bez choroby obličiek. Tam zapadá do rovnakej logiky ako ostatné kardiometabolické odporúčania: obezita, diabetes 2. typu a hypertenzia sú spoločnými determinantmi choroby obličiek aj kardiovaskulárnych ochorení a všetky tri sú stravou ovplyvniteľné.</p>

<p>Pri pacientovi, ktorý už chorobu obličiek má, sú odporúčania rozpornejšie a táto práca na ne neodpovedá. Obmedzenie bielkovín na spomalenie progresie hovorí v prospech stravy chudobnej na živočíšne produkty; obmedzenie draslíka pri hyperkaliémii naopak limituje mnohé rastlinné potraviny a obmedzenie fosfátov pri poruche kostného a minerálového metabolizmu vedie k jednotvárnemu jedálničku. Samotné označenie „vegetariánska strava“ preto nezaručuje priaznivý nutričný profil — rozhodovať treba individuálne podľa štádia, kaliémie, fosfatémie, kompenzácie diabetu a znášanlivosti.</p>

<p>Za zmienku stojí posun v odporúčaniach: KDIGO začalo úlohu rastlinnej stravy v manažmente choroby obličiek uznávať, hoci v praxi stále prevažujú konzervatívnejšie postoje opreté o staršie obavy z draslíka, fosforu a kvality bielkovín. Autori preto v závere volajú po randomizovaných štúdiách rastlinnej stravy u pacientov s chorobou obličiek vrátane posúdenia jej praktickej uskutočniteľnosti a prijateľnosti.</p>

<h2>Záver</h2>

<p>V populačnej kohorte s viac než 400 000 účastníkmi a takmer 13 rokmi sledovania sa vegetariánska strava spájala s približne o pätinu nižším rizikom vzniku chronickej choroby obličiek, s odstupňovaným vzťahom kopírujúcim klesajúci príjem živočíšnych bielkovín a s výsledkom stabilným po zohľadnení vstupnej funkcie obličiek, albuminúrie aj genetickej predispozície. Pre nefrologickú prax z toho nevyplýva nový liečebný postup, ale podpora pre argument, ktorý pri prevencii aj tak používame: posun jedálnička smerom k rastlinným zdrojom je rozumný. Dôkazový základ pre pacientov, ktorí chorobu obličiek už majú, zatiaľ chýba — a ten sa observačnou analýzou nahradiť nedá.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=rastlinna-strava-nizsia-mortalita-ckd">Rastlinná strava a nižšia mortalita u pacientov s CKD: čo z toho využiť v praxi</a></li>
  <li><a href="article.php?slug=mierne-obmedzenie-bielkovin-ckd-prognoza">Mierne obmedzenie bielkovín môže pri chronickej chorobe obličiek zlepšiť prognózu</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri ochorení obličiek: edukovať, nie strašiť</a></li>
  <li><a href="article.php?slug=fibermaxxing-vlaknina-davka-odpoved-ckd">„Fibermaxxing“: vyšší príjem vlákniny prináša úžitok, otázkou je kde a pre koho sa krivka vyrovná</a></li>
  <li><a href="article.php?slug=vyssi-prijem-bielkovin-merana-gfr-renis">Vyšší príjem bielkovín a meraná GFR v štúdii RENIS</a></li>
</ul>

<hr>

<h2>Odborné zdroje</h2>

<p><small><em><strong>Spracovaný zdroj:</strong> Candussi CJ, Bell W, Mutapcic M, Thompson AS, Rohrmann S, Cassidy A, Kühn T, Gaggl M. Vegetarian diet is associated with a lower risk of chronic kidney disease in a population-based study. <em>Scientific Reports</em>. 2026;16(1). doi: <a href="https://doi.org/10.1038/s41598-026-62827-2" target="_blank" rel="noopener noreferrer">10.1038/s41598-026-62827-2</a>. PMID 42547796, PMCID PMC13434791. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13434791/" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný autorský zoznam (8 mien), veľkosti kohorty a jednotlivých stravovacích skupín, počty incidentných prípadov, dĺžka sledovania, všetky uvedené pomery rizík aj intervaly spoľahlivosti boli overené 28. augusta 2026 v plnom texte spracovanej práce cez PubMed Central. Presné intervaly spoľahlivosti pre konzumentov hydiny a pre pescatariánov sú v pôvodnej práci uvedené len v obrázku, nie v texte — preto sa tu uvádza iba veľkosť a významnosť odhadu. Údaje o príjme živín pochádzajú z podskupiny s dostupným 24-hodinovým záznamom (n = 178 209) a autori ich neporovnávali štatisticky.</em></small></p>

<p><small><em>Text má odborný informačný charakter a nenahrádza individuálne klinické rozhodovanie. Zistenie sa týka vzniku ochorenia u osôb bez choroby obličiek; nejde o výživové odporúčanie pre pacientov, ktorí chronickú chorobu obličiek už majú. Úpravu príjmu bielkovín, draslíka a fosforu treba prispôsobiť štádiu ochorenia a aktuálnym laboratórnym hodnotám.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vegetarianska_strava_riziko_ckd_uk_biobank',
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
    echo "Migrácia článku: " . ($articles[0]['title'] ?? '(bez titulu)') . "\n";
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
