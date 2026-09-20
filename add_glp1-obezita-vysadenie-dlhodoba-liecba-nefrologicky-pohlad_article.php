<?php
/**
 * Odborná syntéza dôkazov o udržiavaní liečby obezity, 20. 9. 2026.
 * Primárne štúdie, odporúčanie WHO a produktové informácie EMA.
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
    'title'        => 'Liečba obezity agonistami GLP-1: vysadenie, udržiavacia stratégia a nefrologický pohľad',
    'slug'         => 'glp1-obezita-vysadenie-dlhodoba-liecba-nefrologicky-pohlad',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Po vysadení liečby obezity sa hmotnosť často vracia. Čo dokazujú STEP 1, SELECT a SURMOUNT-MAINTAIN a ako plánovať udržiavaciu liečbu pri chronickom ochorení obličiek?',
    'content'      => <<<'HTML'
<p>Liečba obezity agonistami receptora pre glukagónu podobný peptid 1 (GLP-1) sa má plánovať ako súčasť dlhodobej starostlivosti. Po jej ukončení sa často vracia významná časť stratenej hmotnosti. To však neznamená, že každý pacient musí celoživotne užívať rovnaký liek v rovnakej dávke. Rozhodnutie o pokračovaní, úprave alebo ukončení má vychádzať z účinnosti, tolerancie, pridružených ochorení a možností pacienta. WHO dlhodobé použitie podmienečne odporúča, pričom upozorňuje aj na neistoty týkajúce sa udržiavania a ukončovania liečby. [1]</p>
<p>Semaglutid je agonista receptora GLP-1. Tirzepatid pôsobí súčasne na receptory glukózovo dependentného inzulinotropného polypeptidu (GIP) a GLP-1; výsledky jeho udržiavacích štúdií preto nemožno automaticky prenášať na všetky agonisty GLP-1. Nasledujúci prehľad odlišuje dôkazy o hmotnosti od dôkazov o kardiovaskulárnych a obličkových príhodách. Stav poznatkov je posúdený k 20. septembru 2026. [7, 8]</p>

<h2>Návrat hmotnosti nie je jednoduchým prejavom nedostatočnej vôle</h2>
<p>Obezita je chronické ochorenie so sklonom k opätovnému zhoršovaniu. Pokles hmotnosti môže vyvolať adaptačné zmeny podporujúce hlad a opätovné priberanie. V štúdii Sumithranovej a spoluautorov absolvovalo 50 dospelých bez diabetu desaťtýždňový program s veľmi nízkoenergetickou diétou. Priemerný úbytok bol 13,5 kg. Rok po ukončení úvodného chudnutia pretrvávali odchýlky viacerých hormónov vrátane zvýšeného ghrelínu a zvýšeného subjektívneho hladu. [2]</p>
<p>Autori merali deväť hormonálnych ukazovateľov, ale nepreukázali pretrvávanie významnej zmeny všetkých deviatich. Navyše išlo o reakciu na diétou navodené chudnutie, nie o štúdiu vysadenia semaglutidu. Výsledok vysvetľuje biologickú zložku návratu hmotnosti; neurčuje však potrebnú dĺžku farmakoterapie konkrétneho pacienta. [2]</p>

<h2>STEP 1: čo presne znamenajú „dve tretiny“</h2>
<p>Rozšírené sledovanie STEP 1 zahŕňalo 327 účastníkov. Počas 68 týždňov sa pri semaglutide 2,4 mg raz týždenne hmotnosť znížila v priemere o 17,3 %. Po ďalších 52 týždňoch bez liečby sa vrátilo 11,6 percentuálneho bodu a čistý úbytok oproti začiatku bol 5,6 %. Väčšina sledovaných kardiometabolických ukazovateľov sa posúvala späť k východiskovým hodnotám. [3]</p>
<p><strong>Priemerný návrat približne dvoch tretín predchádzajúceho úbytku neznamená, že dve tretiny pacientov nabrali všetku hmotnosť späť.</strong> Významným obmedzením je súčasné ukončenie lieku aj štruktúrovanej režimovej intervencie. Išlo o exploračné sledovanie vybranej podskupiny, nie o nové randomizované porovnanie pokračovania liečby s vysadením pri rovnakej intenzite podpory. Výsledky ukazujú riziko návratu hmotnosti, ale nepredpovedajú individuálny priebeh. [3]</p>

<h2>SURMOUNT-MAINTAIN: nižšia udržiavacia dávka namiesto vysadenia</h2>
<p>Štúdia fázy 3b zahŕňala 60 týždňov úvodnej liečby tirzepatidom. Následne bolo 378 účastníkov randomizovaných na ďalších 52 týždňov: pokračovali maximálnou tolerovanou dávkou 10 alebo 15 mg, prešli na 5 mg alebo na placebo. Hodnotila sa teda konkrétna udržiavacia stratégia po predchádzajúcej liečbe, nie postupné znižovanie dávky až na nulu. [4]</p>
<div class="pdf-keep-together">
<div class="table-responsive" role="region" aria-label="Modelované výsledky hmotnosti v SURMOUNT-MAINTAIN" tabindex="0">
<table><thead><tr><th scope="col">Režim po 60. týždni</th><th scope="col">Zmena hmotnosti od začiatku do 112. týždňa</th></tr></thead><tbody>
<tr><th scope="row">Tirzepatid 10 alebo 15 mg týždenne</th><td>−21,9 %</td></tr>
<tr><th scope="row">Tirzepatid 5 mg týždenne</th><td>−16,6 %</td></tr>
<tr><th scope="row">Placebo</th><td>−9,9 %</td></tr>
</tbody></table></div></div>
<p>Obe aktívne ramená boli oproti placebu štatisticky lepšie (p &lt; 0,0001). Sú to modelované odhady od pôvodného začiatku štúdie, nie dodatočné schudnutie počas udržiavacej fázy. Analytický postup osobitne zohľadňoval záchranné nasadenie tirzepatidu pri výraznom návrate hmotnosti. [4]</p>
<p>Nižšia dávka môže byť u niektorých pacientov alternatívou úplného ukončenia, priemerne však nezachovala rovnaký výsledok ako vyššia dávka. Štúdia nepreukazuje rovnocennosť 5 mg s 10 alebo 15 mg ani zachovanie kardiovaskulárnej či obličkovej ochrany po redukcii dávky. Nemožno z nej odvodiť univerzálny režim vysadzovania semaglutidu, predlžovania intervalov injekcií alebo prerušovaných liečebných cyklov.</p>

<h2>SELECT: prínos sa netýka iba čísla na váhe</h2>
<p>SELECT randomizovala 17 604 ľudí vo veku ≥45 rokov s BMI ≥27 kg/m², preukázaným kardiovaskulárnym ochorením a bez diabetu. Pri semaglutide 2,4 mg týždenne sa kardiovaskulárne úmrtie, nefatálny infarkt alebo nefatálna cievna mozgová príhoda vyskytli u 6,5 % oproti 8,0 % pri placebe: pomer okamžitých rizík (HR) 0,80; 95 % interval spoľahlivosti 0,72 až 0,90. Nežiaduce udalosti viedli k trvalému ukončeniu skúšaného lieku u 16,6 % oproti 8,2 %. [5]</p>
<p>Samostatná vopred plánovaná obličková analýza uviedla kombinovaný výsledok u 1,8 % oproti 2,2 % účastníkov: HR 0,78; 95 % interval spoľahlivosti 0,63 až 0,96. Zahŕňal úmrtie z obličkovej príčiny, chronickú náhradu funkcie obličiek, pretrvávajúcu eGFR &lt;15 ml/min/1,73 m², pretrvávajúci pokles eGFR o ≥50 % alebo vznik pretrvávajúcej makroalbuminúrie. [6]</p>
<p>Zníženie kombinovaného ukazovateľa o 22 % preto nemožno označiť za 22 % zníženie potreby dialýzy. SELECT tiež nebola štúdiou vysadenia a nedokazuje, o koľko sa po ukončení liečby zmení riziko príhod. Jej výsledky platia pre definovanú populáciu so známym kardiovaskulárnym ochorením; nemožno ich bez ďalších dôkazov zovšeobecniť na všetkých ľudí s obezitou, všetky štádiá CKD ani pacientov na dialýze.</p>

<h2>CKD: rozhoduje konkrétny liek a klinická situácia</h2>
<p>Pri chronickom ochorení obličiek (CKD) nestačí všeobecné tvrdenie, že lieky tejto skupiny nevyžadujú úpravu dávky. Európska produktová informácia injekčného Wegovy nevyžaduje úpravu pri miernej alebo stredne ťažkej poruche funkcie obličiek, ale použitie pri eGFR &lt;30 ml/min/1,73 m² vrátane terminálneho zlyhania neodporúča pre obmedzené skúsenosti. [7]</p>
<p>Pri Mounjaro sa úprava dávky z dôvodu poruchy funkcie obličiek vrátane terminálneho zlyhania nevyžaduje; pri ťažkej poruche a terminálnom zlyhaní sú však skúsenosti obmedzené a je potrebná opatrnosť. Farmakokinetická možnosť podania nie je totožná s dôkazom dlhodobého klinického prínosu u dialyzovaných pacientov. Schválené udržiavacie dávky tirzepatidu pre dospelých sú 5, 10 a 15 mg týždenne. [8]</p>

<h2>Gastrointestinálne ťažkosti, hydratácia a bezpečné prerušenie</h2>
<p>Nauzea, vracanie a hnačka môžu viesť k dehydratácii a následnému zhoršeniu funkcie obličiek. Pri podozrení na pankreatitídu sa liečba semaglutidom prerušuje; pri potvrdenej pankreatitíde sa nemá znovu začať. Závažné pretrvávajúce ťažkosti preto nemožno riešiť iba pomalým znižovaním dávky bez diagnostického zhodnotenia. [7]</p>
<p>Reflux a zápcha môžu znižovať toleranciu liečby. Kolitídu však nemožno bez presvedčivých kauzálnych údajov uvádzať ako všeobecne preukázanú typickú komplikáciu celej skupiny. Pri silnej bolesti brucha, krvácaní alebo podozrení na nepriechodnosť čreva je potrebné vyšetrenie príčiny, nie automatické pripísanie príznakov lieku.</p>

<h2>Praktický rámec pre nefrologickú ambulanciu</h2>
<p>Nasledujúci postup predstavuje klinickú syntézu uvedených dôkazov a bezpečnostných upozornení, nie validovaný protokol vysadzovania:</p>
<ol>
<li><strong>Určiť dôvod zmeny.</strong> Rozlišovať dosiahnutie hmotnostného cieľa, intoleranciu, nedostatočný účinok, finančnú nedostupnosť a stav vyžadujúci bezodkladné prerušenie. Samotné dosiahnutie nižšej hmotnosti nedokazuje zánik potreby liečby.</li>
<li><strong>Posúdiť celý prínos a riziko.</strong> Zhodnotiť hmotnosť, funkčnosť, krvný tlak, glykemickú kontrolu, eGFR, albuminúriu a indikáciu konkrétneho prípravku. Nižšiu dávku hodnotiť podľa odpovede pacienta, nie iba podľa skupinového priemeru.</li>
<li><strong>Sledovať príjem a objemový stav.</strong> Pri vracaní, hnačke alebo hypotenzii posúdiť hydratáciu, kreatinín, elektrolyty a súbežné lieky. Príjem tekutín prispôsobiť CKD a prípadnému srdcovému zlyhávaniu; neodporúčať plošne neobmedzené pitie.</li>
<li><strong>Chrániť výživu a funkčnú kapacitu.</strong> Pri nechutenstve alebo rýchlom poklese hmotnosti hodnotiť nutričný príjem a svalovú funkciu. Pohyb aj výživu prispôsobiť stavu pacienta; potrebu bielkovín posudzovať podľa štádia CKD a dialyzačnej liečby.</li>
<li><strong>Dohodnúť plán po zmene.</strong> Stanoviť termín kontroly, sledované ukazovatele a podmienky opätovného prehodnotenia. Režimová a odborná podpora má pokračovať aj pri ukončení lieku. Návrat hmotnosti riešiť úpravou liečebného plánu, nie obviňovaním pacienta.</li>
</ol>

<h2>Záver</h2>
<p>Dôkazy podporujú dlhodobú liečbu obezity s pravidelným prehodnocovaním. Nižšia udržiavacia dávka tirzepatidu môže byť vhodná pre časť pacientov, no nie je ekvivalentom bezpečne overeného vysadenia. V nefrológii treba súčasne zohľadniť obličkovú funkciu, objemový stav, výživu a presnú indikáciu prípravku. Cieľom je udržateľný zdravotný prínos pri prijateľnom riziku.</p>
<hr>
<h2>Zdroje</h2>
<ol>
<li><small><em>World Health Organization. WHO issues global guideline on the use of GLP-1 medicines in treating obesity. 1. 12. 2025. <a href="https://www.who.int/news/item/01-12-2025-who-issues-global-guideline-on-the-use-of-glp-1-medicines-in-treating-obesity" target="_blank" rel="noopener noreferrer">WHO</a>.</em></small></li>
<li><small><em>Priya Sumithran, Luke A Prendergast, Elizabeth Delbridge, Katrina Purcell, Arthur Shulkes, Adamandia Kriketos, Joseph Proietto. Long-term persistence of hormonal adaptations to weight loss. N Engl J Med. 2011;365:1597–1604. DOI: 10.1056/NEJMoa1105816. <a href="https://pubmed.ncbi.nlm.nih.gov/22029981/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>John P H Wilding, Rachel L Batterham, Melanie Davies, Luc F Van Gaal, Kristian Kandler, Katerina Konakli, Ildiko Lingvay, Barbara M McGowan, Tugce Kalayci Oral, Julio Rosenstock, Thomas A Wadden, Sean Wharton, Koutaro Yokote, Robert F Kushner, STEP 1 Study Group. Weight regain and cardiometabolic effects after withdrawal of semaglutide: The STEP 1 trial extension. Diabetes Obes Metab. 2022;24:1553–1564. DOI: 10.1111/dom.14725. <a href="https://pubmed.ncbi.nlm.nih.gov/35441470/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Deborah B Horn, Louis J Aronne, Sean Wharton, Harold E Bays, Carel W le Roux, Reshmi Srinath, Elisa Gomez-Valderas, Avigdor D Arad, Sagar Das, Julia P Dunn, Anderson Ribeiro, Leonard C Glass, Clare J Lee. Tirzepatide for maintenance of bodyweight reduction in people with obesity in the USA (SURMOUNT-MAINTAIN). Lancet. 2026;407:2305–2318. DOI: 10.1016/S0140-6736(26)00656-2. <a href="https://pubmed.ncbi.nlm.nih.gov/42119587/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>A Michael Lincoff, Kirstine Brown-Frandsen, Helen M Colhoun, John Deanfield, Scott S Emerson, Sille Esbjerg, Søren Hardt-Lindberg, G Kees Hovingh, Steven E Kahn, Robert F Kushner, Ildiko Lingvay, Tugce K Oral, Marie M Michelsen, Jorge Plutzky, Christoffer W Tornøe, Donna H Ryan, SELECT Trial Investigators. Semaglutide and Cardiovascular Outcomes in Obesity without Diabetes. N Engl J Med. 2023;389:2221–2232. DOI: 10.1056/NEJMoa2307563. <a href="https://pubmed.ncbi.nlm.nih.gov/37952131/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Helen M Colhoun, Ildiko Lingvay, Paul M Brown, John Deanfield, Kirstine Brown-Frandsen, Steven E Kahn, Jorge Plutzky, Koichi Node, Alexander Parkhomenko, Lars Rydén, John P H Wilding, Johannes F E Mann, Katherine R Tuttle, Thomas Idorn, Naveen Rathor, A Michael Lincoff. Long-term kidney outcomes of semaglutide in obesity and cardiovascular disease in the SELECT trial. Nat Med. 2024;30:2058–2066. DOI: 10.1038/s41591-024-03015-5. <a href="https://www.nature.com/articles/s41591-024-03015-5" target="_blank" rel="noopener noreferrer">Primárna obličková analýza</a>.</em></small></li>
<li><small><em>European Medicines Agency. Wegovy, súhrn charakteristických vlastností lieku, najmä časti 4.2 a 4.4. Overené 20. 9. 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/wegovy-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Produktová informácia EMA</a>.</em></small></li>
<li><small><em>European Medicines Agency. Mounjaro, súhrn charakteristických vlastností lieku, najmä časti 4.2 a 4.4. Overené 20. 9. 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/mounjaro-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Produktová informácia EMA</a>.</em></small></li>
</ol>
<p><small><em>Bibliografická poznámka: k publikácii SURMOUNT-MAINTAIN je evidované erratum (Lancet. 2026;407:2290; DOI: <a href="https://doi.org/10.1016/S0140-6736(26)01134-7" target="_blank" rel="noopener noreferrer">10.1016/S0140-6736(26)01134-7</a>). Jeho úplný obsah nebol pri tejto kontrole dostupný; uvedené číselné výsledky zodpovedajú aktuálne dostupnému abstraktu primárnej publikácie v PubMed.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

// POZOR: každý vložený článok zaradí samostatné avízo pre KAŽDÉHO odberateľa.
// Pri dávke N článkov to znamená N × počet odberateľov e-mailov naraz
// (2026-09-09: 12 článkov = 144 e-mailov). Preto je predvolená hodnota `false`.
// Na `true` prepni vedome — pri jednom článku, ktorý má ísť do newslettera.
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_glp1-obezita-vysadenie-dlhodoba-liecba-nefrologicky-pohlad_article',
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
