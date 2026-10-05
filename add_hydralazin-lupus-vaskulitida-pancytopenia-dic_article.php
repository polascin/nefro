<?php
/** Odborne revidovaný článok; idempotentné publikovanie podľa projektovej šablóny. */

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
    'title'        => 'Hydralazínom indukovaný prekryv lupusu a vaskulitídy: pancytopénia, DIC a akútne poškodenie obličiek',
    'slug'         => 'hydralazin-lupus-vaskulitida-pancytopenia-dic',
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kritické spracovanie závažnej kazuistiky hydralazínom asociovaného DIL/DIV: diagnostika, vysadenie spúšťača, individualizácia imunosupresie a význam NAT2.',
    'content'      => <<<'HTML'
<p>Hydralazín môže vyvolať liekom indukovaný lupus (DIL) aj liekom indukovanú vaskulitídu (DIV), vrátane ANCA-asociovanej vaskulitídy (AAV). Klinické a sérologické znaky sa môžu prekrývať. Kazuistika publikovaná v októbri 2026 upozorňuje na mimoriadne závažnú kombináciu pancytopénie, diseminovanej intravaskulárnej koagulácie (DIC) a akútneho poškodenia obličiek (AKI). Je podnetom na diagnostickú obozretnosť, nie dôkazom univerzálneho mechanizmu ani návodom na jednotný imunosupresívny režim. [1, 2]</p>

<figure>
<a href="img/hydralazin-lupus-vaskulitida-pancytopenia-dic.webp" target="_blank" rel="noopener noreferrer"><img src="img/hydralazin-lupus-vaskulitida-pancytopenia-dic.webp" alt="Symbolická oblička v sieti zapálených malých ciev a zväčšená cieva s erytrocytmi a fibrínovými vláknami" width="1586" height="992" loading="lazy" decoding="async"></a>
<figcaption>Ilustračné zobrazenie systémového liekom podmieneného poškodenia. Nezobrazuje skutočný nález pacienta a neurčuje mechanizmus jeho AKI.</figcaption>
</figure>

<h2>Kazuistika: závažný priebeh s následným zotavením</h2>
<p>Yangming Cao opisuje 52-ročného muža s horúčkou, závažnou pancytopéniou a úvodným podozrením na pneumóniu. Rozvinuli sa DIC s gastrointestinálnym krvácaním, respiračné zlyhanie vyžadujúce intubáciu, AKI s potrebou hemodialýzy a ďalšie orgánové komplikácie. Rozsiahle vyšetrenia nezistili infekčný zdroj. Autor považuje hydralazínom indukovaný prekryv DIL/DIV za najpravdepodobnejšie vysvetlenie, výslovne však odlišuje podporu tejto interpretácie od jej dôkazu. [1]</p>
<p>Hydralazín bol vysadený. Pacient dostával glukokortikoidy a intravenózny cyklofosfamid každé dva týždne, spolu sedem dávok. Pre pretrvávajúcu pancytopéniu sa zopakovala biopsia kostnej drene. Neskôr sa stav zlepšil, hemodialýzu bolo možné ukončiť a po prepustení nasledovalo znižovanie glukokortikoidov a dvojročné podávanie mykofenolátmofetilu. Pri šesťročnom sledovaní bol krvný obraz normálny a funkcia obličiek stabilná. Zistený diplotyp NAT2 *5.002/*6.002 zodpovedal pomalej acetylácii. [1]</p>
<p>Opis vychádza z vydavateľom zverejneného abstraktu korigovanej práce pred definitívnym vydaním. Bez úplných klinických a histologických údajov nemožno dopĺňať konkrétny bioptický typ nefritídy, dávky liekov ani rozhodovací algoritmus, ktorý abstrakt neuvádza.</p>

<h2>Prečo sa lupus a vaskulitída môžu prekrývať</h2>
<p>Hydralazínom asociovaný autoimunitný syndróm môže zahŕňať ANA, protilátky proti histónom, MPO-ANCA, niekedy anti-dsDNA a znížené koncentrácie komplementu. Samotná pozitivita jednej protilátky však nerozlišuje spoľahlivo medzi liekovou autoimunitou, idiopatickým ochorením a laboratórnym nálezom bez zodpovedajúcej klinickej aktivity. Rozhoduje súhrn expozície, orgánových prejavov, laboratórnych výsledkov a podľa možností histológie. [2]</p>
<p>V retrospektívnom súbore Kumara a spoluautorov malo všetkých 12 pacientov exponovaných hydralazínu pozitivitu ANA aj ANCA; všetci mali protilátky proti histónom a 11 malo protilátky proti MPO. U šiestich biopsiovaných pacientov sa preukázala pauciimunitná polmesiačiková glomerulonefritída. Tento malý súbor dokladá možný prekryv sérologických znakov, neumožňuje však odhadnúť incidenciu komplikácie medzi všetkými užívateľmi hydralazínu. [2]</p>

<h2>AKI nemusí mať jedinú príčinu</h2>
<p>Pri súčasnom šoku, krvácaní a DIC môže k AKI prispievať hypoperfúzia, akútne tubulárne poškodenie a porucha mikrocirkulácie. Súbežne môže existovať imunitne podmienené glomerulárne ochorenie. Potreba dialýzy sama osebe neurčuje mechanizmus poškodenia. Aktívny močový sediment a vývoj proteinúrie pomáhajú formulovať podozrenie, ale nenahrádzajú tkanivový dôkaz konkrétnej glomerulonefritídy. [1, 2, 4]</p>
<p>Biopsia obličky môže byť diagnosticky dôležitá, pri nekorigovanej koagulopatii alebo výraznej trombocytopénii však nemusí byť bezpečná. Načasovanie sa riadi stabilizáciou pacienta a otázkou, ktorú má výkon zodpovedať. Závažné krvácanie nemožno ignorovať len preto, že histológia by bola užitočná. [5]</p>

<h2>Bezprostredný postup: odstrániť spúšťač a súčasne overovať diagnózu</h2>
<p>Pri dôvodnom podozrení na závažnú hydralazínom vyvolanú autoimunitnú reakciu treba liek vysadiť a nežiaducu reakciu jednoznačne zaznamenať do dokumentácie. Po takomto život ohrozujúcom priebehu nie je opätovná expozícia vhodná. Na rozhodnutie o vysadení sa nečaká na genotypizáciu. Súhrn charakteristických vlastností lieku upozorňuje aj na závažnú vaskulitídu s pľúcnym a obličkovým postihnutím a potrebu včasného rozpoznania a liečby. [3]</p>
<p>Diferenciálna diagnostika pritom musí pokračovať. Negatívne kultivácie samy osebe nevylučujú sepsu. DIC, trombotická mikroangiopatia, hemolýza, hematologické ochorenie a liekový útlm kostnej drene vyžadujú odlišné zhodnotenie. DIC a trombotická mikroangiopatia nie sú synonymá; hodnotia sa trendy trombocytov, koagulačných parametrov, fibrinogénu, markerov hemolýzy a periférny krvný náter v klinickom kontexte. [6, 8]</p>
<p>Podporná liečba sa prispôsobuje krvácaniu, hemodynamike, oxygenácii a indikáciám náhrady funkcie obličiek. Liečba DIC sa opiera predovšetkým o zvládnutie vyvolávajúcej príčiny; transfúzne rozhodnutia vychádzajú z klinického krvácania a plánovaných výkonov spolu s laboratórnymi výsledkami. Potrebná je koordinácia intenzivistu, nefrológa a hematológa. [6]</p>

<h2>Imunosupresia: nepremeniť kazuistiku na protokol</h2>
<p>Pri orgán ohrozujúcej AAV je základom indukcie podľa KDIGO kombinácia glukokortikoidov s rituximabom alebo cyklofosfamidom. Prenos tohto rámca na liekom indukovaný prekryv je klinickou extrapoláciou, nie výsledkom osobitnej randomizovanej štúdie DIL/DIV. Výber a intenzita liečby musia zohľadniť infekciu, cytopénie, orgánové poškodenie a očakávanú toxicitu. [4]</p>
<p><strong>Sedem dávok cyklofosfamidu a dva roky mykofenolátmofetilu sú opisom jedného prípadu.</strong> Nemožno ich odporúčať automaticky každému pacientovi. Pretrvávajúca pancytopénia počas liečby vyžaduje revíziu príčin vrátane toxicity imunosupresie. Opakovaná biopsia kostnej drene môže byť odôvodnená konkrétnym priebehom, nie je povinným rutinným krokom pri každom prekryve DIL/DIV.</p>

<h2>Čo dnes znamená nález NAT2</h2>
<p>CPIC v roku 2025 publikovalo odporúčanie pre používanie výsledku genotypizácie NAT2 pri liečbe hydralazínom. Pomalí metabolizátori majú vyššiu expozíciu lieku a vyššie riziko liekom indukovaného lupusu. Odporúčania sa týkajú najmä dávkovania perorálneho hydralazínu pri rezistentnej hypertenzii; dokument nie je príkazom na plošné genetické testovanie všetkých pacientov. [7]</p>
<p><strong>Pre riziko hydralazínom asociovanej ANCA vaskulitídy zatiaľ nie je genotypovo závislý účinok NAT2 preukázaný.</strong> Genotyp preto nemožno použiť ako dôkaz príčiny DIC alebo pancytopénie ani ako diagnostický test prekryvu DIL/DIV. V opísanom prípade dopĺňa farmakokinetický kontext, nenahrádza klinické posúdenie kauzality. [7]</p>
<p>Najdôležitejším poučením je zahrnúť liekovú anamnézu do včasného hodnotenia systémového ochorenia s AKI. Rozpoznanie možného spúšťača má prebiehať súčasne so stabilizáciou pacienta a s overovaním alternatívnych diagnóz.</p>

<hr>
<p><small><em><strong>Zdroj:</strong> [1] Cao Y. Life-Threatening Pancytopenia and Disseminated Intravascular Coagulation Associated With Hydralazine-Induced Lupus and Vasculitis Overlap: A Comprehensive Case Report. Am J Case Rep. Dostupné online 2. októbra 2026, In Press, Corrected Proof. DOI: 10.12659/AJCR.954113. <a href="https://amjcaserep.com/abstract/index/idArt/954113" target="_blank" rel="noopener noreferrer">Vydavateľ a abstrakt</a>. Slovenské odborné spracovanie abstraktu doplnené o kritický klinický komentár.</em></small></p>
<p><small><em>[2] Kumar B a kol. Hydralazine-associated vasculitis: Overlapping features of drug-induced lupus and vasculitis. Semin Arthritis Rheum. 2018. <a href="https://pubmed.ncbi.nlm.nih.gov/29519741/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
<p><small><em>[3] Hydralazine 50 mg Film-coated Tablets. Summary of Product Characteristics. <a href="https://www.medicines.org.uk/emc/product/2605/smpc" target="_blank" rel="noopener noreferrer">Aktuálny súhrn charakteristických vlastností lieku</a>, časti 4.4 a 4.8. Overené 5. októbra 2026.</em></small></p>
<p><small><em>[4] KDIGO ANCA Vasculitis Work Group. KDIGO 2024 Clinical Practice Guideline for the Management of Antineutrophil Cytoplasmic Antibody (ANCA)-Associated Vasculitis. Kidney Int. 2024;105(Suppl 3S):S71–S116. <a href="https://kdigo.org/wp-content/uploads/2024/05/KDIGO-2024-ANCA-Vasculitis-Guideline.pdf" target="_blank" rel="noopener noreferrer">Úplné odporúčanie</a>.</em></small></p>
<p><small><em>[5] Schnuelle P. Renal Biopsy for Diagnosis in Kidney Disease: Indication, Technique, and Safety. J Clin Med. 2023;12(19):6424. <a href="https://doi.org/10.3390/jcm12196424" target="_blank" rel="noopener noreferrer">DOI: 10.3390/jcm12196424</a>.</em></small></p>
<p><small><em>[6] British Society for Haematology. Guidelines for the diagnosis and management of disseminated intravascular coagulation. 2009, aktualizované 2012. <a href="https://cms.b-s-h.org.uk/guidelines/guidelines/guidelines-for-the-diagnosis-and-management-of-disseminated-intravascular-coagulation" target="_blank" rel="noopener noreferrer">Odporúčanie BSH</a>.</em></small></p>
<p><small><em>[7] Eadon MT a kol. Clinical Pharmacogenetics Implementation Consortium Guideline for NAT2 Genotype and Hydralazine Therapy. Clin Pharmacol Ther. 2025;118(6):1430–1436. DOI: <a href="https://doi.org/10.1002/cpt.70071" target="_blank" rel="noopener noreferrer">10.1002/cpt.70071</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/40974042/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
<p><small><em>[8] Iba T, Levy JH, Wada H a kol. Differential diagnoses for sepsis-induced disseminated intravascular coagulation: communication from the SSC of the ISTH. J Thromb Haemost. 2019;17(2):415–419. DOI: <a href="https://doi.org/10.1111/jth.14354" target="_blank" rel="noopener noreferrer">10.1111/jth.14354</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/30618150/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
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
    'log_prefix' => 'add_hydralazin-lupus-vaskulitida-pancytopenia-dic_article',
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
