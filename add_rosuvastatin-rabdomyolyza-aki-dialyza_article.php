<?php

/** Odborne a jazykovo revidovaný komentár ku kazuistike rabdomyolýzy. */

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
    'title'        => 'Rosuvastatín, rabdomyolýza a AKI vyžadujúce dialýzu: poučenie z kazuistiky',
    'slug'         => 'rosuvastatin-rabdomyolyza-aki-dialyza',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Kazuistika ťažkej rabdomyolýzy u staršej pacientky: diagnostika pigmentového AKI, bezpečná volumoterapia, indikácie dialýzy a európske pravidlá dávkovania rosuvastatínu.',
    'content'      => <<<'HTML'
<figure><a href="img/rosuvastatin-rabdomyolyza-aki-dialyza.webp" target="_blank" rel="noopener noreferrer"><img src="img/rosuvastatin-rabdomyolyza-aki-dialyza.webp" alt="Konceptuálne zobrazenie poškodených svalových vlákien, uvoľňovania myoglobínu a poškodenia obličky s dialyzátorom v pozadí" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná vizualizácia vytvorená pomocou umelej inteligencie: rozpad kostrového svalstva môže viesť k pigmentovému poškodeniu obličiek. Obrázok nezobrazuje konkrétnu pacientku ani skutočný anatomický preparát.</figcaption></figure>

<p><strong>Nová výrazná svalová slabosť u pacienta užívajúceho statín vyžaduje pozornosť, najmä ak ju sprevádza oligúria alebo tmavý moč.</strong> Rabdomyolýza predstavuje zriedkavú, ale závažnú komplikáciu. Nasledujúci odborný komentár vychádza z publikovanej kazuistiky a zasadzuje ju do kontextu diagnostiky, bezpečného dávkovania a nefrologickej liečby. Nejde o vlastné klinické pozorovanie autora portálu. [1,2]</p>

<h2>Publikovaný prípad: závažný priebeh s obnovením nezávislosti od dialýzy</h2>
<p>U 87-ročnej ženy sa približne 20 dní po nasadení rosuvastatínu 20 mg/deň, ezetimibu 10 mg/deň a evogliptínu 5 mg/deň prejavila progresívna slabosť s neschopnosťou stáť. Pred liečbou mala kreatinín 1,00 mg/dl a CK 85 U/l. Pri prijatí bola dehydratovaná; CK presahovala merací limit 4 267 U/l, kreatinín dosiahol 6,13 mg/dl (približne 542 µmol/l), močovina 220 mg/dl (približne 36,6 mmol/l), sodík 122 mmol/l, draslík 5,1 mmol/l a bikarbonát 15 mmol/l pri pH 7,30. AST/ALT boli 419/342 U/l. Močový prúžok ukázal krv 3+, sediment iba 2–4 erytrocyty v zornom poli. [1]</p>
<p>Po vysadení podozrivej liečby a podaní 2,5 l fyziologického roztoku za prvých 24 hodín pretrvávala oligúria. Autori uvádzajú osem hemodialýz, poslednú na 23. deň, a prepustenie na 30. deň s obnovenou chôdzou. Po troch mesiacoch bol kreatinín 1,40 mg/dl a CK 62 U/l. Bikarbonát na alkalinizáciu moču nepodali. Naranjovo skóre 5 hodnotili ako pravdepodobnú liekovú súvislosť. [1]</p>

<h2>Čo prípad dokazuje a čo z neho vyvodiť nemožno</h2>
<p>Jednotlivá kazuistika dokumentuje možný klinický priebeh, nevyčísľuje však riziko kombinácie liekov a nepreukazuje jej mechanizmus. Časová súvislosť a ústup ťažkostí po vysadení podporujú podozrenie na nežiaduci účinok; pri súbežných zásahoch neizolujú účinok jediného lieku. Pri ezetimibe alebo evogliptíne preto nemožno bez ďalších dôkazov tvrdiť konkrétnu príčinnú interakciu. [1,2]</p>
<p>Pojem <em>svalové príznaky asociované so statínmi</em> (SAMS) zahŕňa aj ťažkosti časovo súvisiace s liečbou bez dokázanej farmakologickej príčiny. Mierna myalgia s normálnou CK a rabdomyolýza s orgánovým poškodením vyžadujú odlišný postup. V diferenciálnej diagnostike treba zohľadniť najmä hypotyreózu, nadmernú záťaž, traumu, imobilizáciu, infekciu a ďalšie myotoxické lieky. [2,8]</p>

<h2>Ako vzniká poškodenie obličiek a ako ho rozpoznať</h2>
<p>Pri rozpade svalových buniek sa uvoľňuje myoglobín, draslík a ďalšie intracelulárne látky. Hypovolémia znižuje perfúziu obličiek; myoglobín prispieva k oxidačnému poškodeniu tubulárnych buniek a tvorbe pigmentových valcov, najmä v kyslom prostredí. Laboratórnu diagnózu podporuje CK nad päťnásobok hornej hranice normy alebo nad 1 000 U/l v zodpovedajúcom klinickom kontexte. Samotná CK však neurčuje potrebu dialýzy. [3]</p>
<p><strong>Pozitívny prúžok na krv bez primeranej erytrocytúrie podporuje pigmentúriu, nie definitívny dôkaz myoglobinúrie.</strong> Reakciu môže vyvolať aj hemoglobín. Nález sa interpretuje spolu so svalovými príznakmi, CK a prípadnými známkami hemolýzy. Negatívny močový nález nevylučuje prekonané uvoľnenie myoglobínu, pretože jeho prítomnosť závisí aj od času odberu. Vyšetrenie myoglobínu nemá odkladať liečbu zjavnej rabdomyolýzy. [3,4]</p>
<p>Pri rýchlo sa meniacom kreatiníne štandardný výpočet eGFR nevyjadruje spoľahlivo aktuálnu filtráciu. AKI sa hodnotí podľa dynamiky kreatinínu, diurézy a klinického stavu. Začatie náhrady funkcie obličiek samo osebe zaraďuje AKI do stupňa 3 podľa KDIGO. [5]</p>

<h2>Zvýšené aminotransferázy: svalový pôvod je možný, pečeňový nie je automaticky vylúčený</h2>
<p>AST aj ALT môžu stúpať pri svalovom poškodení; AST je menej špecifická pre pečeň. Súbežný pokles aminotransferáz a CK podporuje svalový podiel. Normálny bilirubín a GGT však <strong>nevylučujú hepatocelulárne poškodenie</strong>, a preto nestačia na kategorický záver o neprítomnosti hepatotoxicity. Pri neprimeranom alebo pretrvávajúcom vzostupe ALT, zvýšenom bilirubíne, poruche syntetickej funkcie či odlišnej časovej dynamike treba vyšetriť aj pečeňovú príčinu. [6]</p>

<h2>Včasný manažment: vysadenie spúšťača, riadená volumoterapia a sledovanie komplikácií</h2>
<p>Pri podozrení na rabdomyolýzu sa statín okamžite vysadí. Súbežne treba skontrolovať celú medikáciu, objemový stav a možné interakcie. Rosuvastatín nie je významným substrátom CYP3A4; význam majú aj transportéry OATP1B1 a BCRP. Interakčné riziko sa preto neposudzuje iba podľa pravidiel platných pre simvastatín. Pri pretrvávajúcej proximálnej slabosti a zvýšenej CK napriek vysadeniu treba myslieť na imunitne sprostredkovanú nekrotizujúcu myopatiu vrátane vyšetrenia protilátok proti HMGCR v spolupráci so špecialistom. [7,8]</p>
<p>Hypovolémia sa koriguje izotonickými kryštaloidmi s opakovaným hodnotením odpovede. U staršieho oligurického pacienta sa objem a rýchlosť podávania riadia perfúziou, bilanciou, diurézou a známkami kongescie. Pretrvávajúca anúria nie je dôvodom na neobmedzené zvyšovanie prívodu tekutín. Rutinná alkalinizácia moču bikarbonátom ani manitol sa na prevenciu AKI neodporúčajú; podklady sú slabé. Bikarbonát pri inej konkrétnej indikácii a diuretiká pri objemovom preťažení predstavujú odlišné klinické rozhodnutia. [3,5]</p>
<p>Sledujú sa draslík, sodík, vápnik, fosfát, acidobázická rovnováha, kreatinín, CK a diuréza; frekvencia odberov zodpovedá závažnosti a dynamike stavu. Hyperkaliémia vyžaduje bezodkladné zhodnotenie EKG a liečbu podľa nálezu. Sériová CK pomáha dokumentovať ústup svalového poškodenia. [3]</p>

<h2>Dialýza: rozhoduje klinická potreba, nie izolovaná hodnota CK</h2>
<p>Náhrada funkcie obličiek je urgentná pri život ohrozujúcich poruchách vnútorného prostredia, najmä pri nezvládnuteľnej hyperkaliémii, závažnej acidóze, pľúcnom edéme alebo uremických komplikáciách. Rozhodnutie zohľadňuje vývoj a celkový stav, nie jedinú hodnotu kreatinínu či močoviny. Samotná oligúria bez ďalších súvislostí nie je univerzálnou indikáciou urgentnej hemodialýzy. Ani bikarbonát 15 mmol/l pri pH 7,30 automaticky nedokazuje refraktérnu acidózu. [5]</p>
<p>Profylaktická dialýza iba na odstránenie myoglobínu nemá preukázaný klinický prínos. Vyššia schopnosť niektorých membrán odstraňovať myoglobín sama osebe nedokazuje lepšie prežívanie alebo obnovu funkcie obličiek. [3]</p>

<h2>Hyponatriémia počas dialýzy vyžaduje osobitný plán</h2>
<p>Konvenčná hemodialýza môže pri výraznej hyponatriémii zvýšiť natriémiu príliš rýchlo. Nie je teda automaticky bezpečným spôsobom jej korekcie. Treba zohľadniť trvanie hyponatriémie, neurologické príznaky, riziko osmotickej demyelinizácie a všetky zdroje zmeny sodíka. Pri chronickej hyponatriémii alebo neznámom trvaní a zvýšenom riziku sa používa konzervatívny cieľ približne 4–6 mmol/l za 24 hodín s neprekročením 8 mmol/l za 24 hodín. Ide o horný bezpečnostný limit, nie o cieľ, ktorý treba dosiahnuť. [9,10]</p>
<p>Ak pacient potrebuje dialýzu, jej predpis sa individualizuje, napríklad úpravou prietoku krvi, trvania procedúry a koncentrácie sodíka v dialyzáte; alternatívou je kontinuálna metóda s prispôsobenými roztokmi. Počas korekcie sú potrebné časté, podľa situácie aj hodinové kontroly natriémie. Prípadnú nadmernú korekciu rieši skúsený tím bezodkladne. Akútna symptomatická hyponatriémia má odlišné priority a vyžaduje urgentný postup podľa neurologického stavu. [9,10]</p>

<h2>Rosuvastatín pri poruche funkcie obličiek: dávkovanie pre európsku prax</h2>
<p>Americké dávkovacie pravidlo „pri ťažkej poruche začať 5 mg, najviac 10 mg denne“ sa nesmie preniesť do európskej praxe bez kontroly príslušného SPC. Európska dokumentácia a aktuálny SmPC lieku Crestor uvádzajú: [7,11]</p>
<div class="table-responsive" role="region" aria-label="Obmedzenia dávkovania rosuvastatínu" tabindex="0"><table><thead><tr><th scope="col">Klinická situácia</th><th scope="col">Dávkovacie pravidlo</th></tr></thead><tbody>
<tr><th scope="row">Vek nad 70 rokov</th><td>Odporúčaná začiatočná dávka 5 mg denne.</td></tr>
<tr><th scope="row">Stredne závažná porucha funkcie obličiek, klírens kreatinínu 30 až &lt; 60 ml/min</th><td>Odporúčaná začiatočná dávka 5 mg denne; dávka 40 mg je kontraindikovaná.</td></tr>
<tr><th scope="row">Ťažká porucha funkcie obličiek, klírens kreatinínu &lt; 30 ml/min</th><td>Rosuvastatín je kontraindikovaný vo všetkých dávkach.</td></tr>
</tbody></table></div>
<p>Pri predpisovaní sa treba riadiť aktuálnym slovenským SPC konkrétneho prípravku. Klírens kreatinínu a eGFR normalizovaná na 1,73 m² nie sú zameniteľné veličiny. Zdanlivo prijateľný kreatinín u krehkého seniora preto nenahrádza posúdenie funkcie obličiek, telesnej konštitúcie a liekových interakcií. [7,11]</p>

<h2>Po stabilizácii: obličky aj kardiovaskulárna prevencia</h2>
<p>Pri ťažkej rabdomyolýze s AKI sa bežný algoritmus opätovného skúšania statínu pri miernych SAMS neuplatňuje automaticky. Konsenzus EAS pri podozrení na rabdomyolýzu neodporúča statín znovu nasadiť. Ďalšiu hypolipidemickú liečbu treba naplánovať individuálne s lipidológom alebo kardiológom, vrátane vhodnej nestatínovej liečby podľa rizika, predchádzajúcej reakcie a dostupných dôkazov. [2,8]</p>
<p>Ukončenie dialýzy neznamená nevyhnutne návrat funkcie obličiek na pôvodnú úroveň. Kontrola po AKI má posúdiť zotavenie aj vznik či zhoršenie chronického ochorenia obličiek; KDIGO odporúča prehodnotenie približne po troch mesiacoch. Súčasťou následnej starostlivosti je kontrola medikácie, funkčného stavu a rehabilitácia podľa potreby. [5]</p>

<h2>Záver pre klinickú prax</h2>
<p>Pri novej závažnej slabosti počas liečby statínom treba rýchlo vyšetriť CK, funkciu obličiek, moč a elektrolyty. Pri rabdomyolýze sú rozhodujúce vysadenie podozrivého lieku, liečba podľa objemového stavu a včasné riešenie komplikácií. Bezpečnosť zvyšuje správne dávkovanie, kontrola interakcií a osobitná opatrnosť pri oligurickom AKI s hyponatriémiou. [2,3,5,7,9]</p>
<hr>
<h2>Zdroje</h2>
<ol class="article-references">
<li><small><em>De Melo LMP, Passos MD, Ferreira DP. Severe Rosuvastatin-Associated Rhabdomyolysis and Dialysis-Requiring Acute Kidney Injury in an Octogenarian Patient: A Case Report. Am J Case Rep. 2026; v čase overenia verzia In Press/Corrected Proof. <a href="https://doi.org/10.12659/AJCR.954160" target="_blank" rel="noopener noreferrer">doi:10.12659/AJCR.954160</a>.</em></small></li>
<li><small><em>Warden BA, Guyton JR, Kovacs AC a kol. Assessment and management of statin-associated muscle symptoms (SAMS): A clinical perspective from the National Lipid Association. J Clin Lipidol. 2023;17(1):19–39. <a href="https://pubmed.ncbi.nlm.nih.gov/36115813/" target="_blank" rel="noopener noreferrer">PubMed</a>; doi:10.1016/j.jacl.2022.09.001.</em></small></li>
<li><small><em>Kodadek L, Carmichael SP II, Seshadri A a kol. Rhabdomyolysis: an American Association for the Surgery of Trauma Critical Care Committee Clinical Consensus Document. Trauma Surg Acute Care Open. 2022;7(1):e000836. <a href="https://pubmed.ncbi.nlm.nih.gov/35136842/" target="_blank" rel="noopener noreferrer">PubMed</a>; doi:10.1136/tsaco-2021-000836.</em></small></li>
<li><small><em>Schifman RB, Luevano DR. Value and Use of Urinalysis for Myoglobinuria. Arch Pathol Lab Med. 2019;143(11):1378–1381. <a href="https://pubmed.ncbi.nlm.nih.gov/31116043/" target="_blank" rel="noopener noreferrer">PubMed</a>; doi:10.5858/arpa.2018-0475-OA.</em></small></li>
<li><small><em>KDIGO Acute Kidney Injury Work Group. KDIGO Clinical Practice Guideline for Acute Kidney Injury. Kidney Int Suppl. 2012;2:1–138. <a href="https://kdigo.org/wp-content/uploads/2016/10/KDIGO-2012-AKI-Guideline-English.pdf" target="_blank" rel="noopener noreferrer">Plné znenie</a>. Aktualizácia 2026 bola pri overení na stránke KDIGO ešte pripravovaná na publikovanie po verejnom pripomienkovaní.</em></small></li>
<li><small><em>Lim AK. Abnormal liver function tests associated with severe rhabdomyolysis. World J Gastroenterol. 2020;26(10):1020–1028. <a href="https://pubmed.ncbi.nlm.nih.gov/32205993/" target="_blank" rel="noopener noreferrer">PubMed</a>; doi:10.3748/wjg.v26.i10.1020.</em></small></li>
<li><small><em>AstraZeneca. Crestor 20 mg film-coated tablets: Summary of Product Characteristics, časti 4.2–4.5; aktualizácia na emc 9. 4. 2026. <a href="https://www.medicines.org.uk/emc/product/7555/smpc" target="_blank" rel="noopener noreferrer">SmPC</a>.</em></small></li>
<li><small><em>Stroes ES, Thompson PD, Corsini A a kol. Statin-associated muscle symptoms: impact on statin therapy – European Atherosclerosis Society Consensus Panel Statement on Assessment, Aetiology and Management. Eur Heart J. 2015;36(17):1012–1022. <a href="https://pubmed.ncbi.nlm.nih.gov/25694464/" target="_blank" rel="noopener noreferrer">PubMed</a>; doi:10.1093/eurheartj/ehv043.</em></small></li>
<li><small><em>Pirklbauer M. Hemodialysis treatment in patients with severe electrolyte disorders: Management of hyperkalemia and hyponatremia. Hemodial Int. 2020;24(3):282–289. <a href="https://pubmed.ncbi.nlm.nih.gov/32436307/" target="_blank" rel="noopener noreferrer">PubMed</a>; doi:10.1111/hdi.12845.</em></small></li>
<li><small><em>Sterns RH, Rondon-Berrios H, Adrogué HJ a kol. Treatment Guidelines for Hyponatremia: Stay the Course. Clin J Am Soc Nephrol. 2024;19(1):129–135. <a href="https://doi.org/10.2215/CJN.0000000000000244" target="_blank" rel="noopener noreferrer">doi:10.2215/CJN.0000000000000244</a>.</em></small></li>
<li><small><em>European Medicines Agency. Crestor 5 mg: Article 29 referral, prílohy s informáciami o lieku, časti 4.2–4.3. <a href="https://www.ema.europa.eu/en/documents/referral/crestor-5-mg-article-29-referral-annex-i-ii-iii_en.pdf" target="_blank" rel="noopener noreferrer">Dokument EMA</a>.</em></small></li>
</ol>
<p><small><em>Odborné a bibliografické overenie: 4. októbra 2026.</em></small></p>
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
    'log_prefix' => 'add_rosuvastatin-rabdomyolyza-aki-dialyza_article',
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
