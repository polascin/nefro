<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Inhibítory SGLT2 zvyšujú hemoglobín: čo to znamená pre hodnotenie anémie pri CKD',
    'slug' => 'inhibitory-sglt2-hemoglobin-anemia-ckd',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'V 85 randomizovaných štúdiách sa hemoglobín pri inhibítoroch SGLT2 líšil od kontroly o 0,60 g/dl. Priemerný vstupný hemoglobín bol 13,6 g/dl, takže výsledok sám neprepisuje prahy KDIGO.',
    'content' => <<<'HTML'
<figure>
  <a href="img/inhibitory-sglt2-hemoglobin-anemia-ckd.webp" rel="noopener noreferrer" target="_blank">
    <picture>
      <source srcset="img/inhibitory-sglt2-hemoglobin-anemia-ckd.webp" type="image/webp">
      <img src="img/inhibitory-sglt2-hemoglobin-anemia-ckd.png" alt="Priesvitná oblička v tme, z rednúcej zásoby stúpa prúd železa do pribúdajúcich červených krviniek" width="1600" height="1000" loading="lazy" decoding="async">
    </picture>
  </a>
  <figcaption>Ilustračná poloschematická scéna, nie snímka pacienta ani lieku. Železo odchádza z rednúcej zásoby do vznikajúcich erytrocytov.</figcaption>
</figure>

<p>Inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2) v združenej analýze 85 dvojito zaslepených randomizovaných štúdií zvýšili hemoglobín oproti kontrole o 0,60 g/dl a hematokrit o 2,36 percentuálneho bodu. Rozdiel je malý a štatisticky konzistentný. Autori sami označujú jeho klinický význam za nejasný. Priemerný vstupný hemoglobín bol 13,6 g/dl, takže išlo prevažne o ľudí bez anémie, nie o bežnú nefrologickú ambulanciu pacientov s anémiou pri chronickej chorobe obličiek (CKD).</p>

<p>Súčasne klesá saturácia transferínu a podľa správy autorov aj feritín. To nie je obraz doplnených zásob železa. Ak však feritín alebo saturácia prejdú prah, pri ktorom KDIGO železo odporúča zvážiť, vysvetlenie spotrebou na erytropoézu tento prah neruší.</p>

<h2>Združená analýza 85 štúdií</h2>

<p>Yang a spolupracovníci prehľadali PubMed, Web of Science a Cochrane Central od vzniku databáz do 22. júla 2026. Zaradili dvojito zaslepené randomizované štúdie u ľudí s aspoň jednou z týchto diagnóz: kardiovaskulárne ochorenie, diabetes, srdcové zlyhanie alebo CKD. Porovnávacou liečbou bolo placebo alebo iný liek. Údaje extrahovali traja posudzovatelia nezávisle od seba a združili ich modelom náhodných účinkov.</p>

<p>Primárnymi ukazovateľmi boli zmena hemoglobínu a hematokritu. Vedľajšími boli koncentrácia erytrocytov, erytropoetín, sérové železo, feritín, saturácia transferínu (TSAT) a hepcidín. Analýza zahŕňa 70 543 účastníkov. Medián trvania bol 24 týždňov, medzikvartilové rozpätie 12 až 32 týždňov. Priemerný vek bol 62,4 roka (SD 9,4), žien bolo 25 334 (35,9 %). Vstupný hematokrit bol 41,5 % (SD 4,9). Placebo bolo porovnávacou liečbou v 78 štúdiách (67 208 účastníkov), iný liek v 7 štúdiách (3 335 účastníkov), najčastejšie sitagliptín v 2 štúdiách (1 158 účastníkov).</p>

<div class="table-responsive" role="region" aria-label="Zmeny hemoglobínu, hematokritu, erytropoetínu a saturácie transferínu pri inhibítoroch SGLT2" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Inhibítor SGLT2</th>
      <th scope="col">Kontrola</th>
      <th scope="col">Rozdiel (95 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Hemoglobín</th>
      <td>+0,55 g/dl (0,49 až 0,61)</td>
      <td>−0,08 g/dl (−0,13 až −0,03)</td>
      <td>+0,60 g/dl (0,55 až 0,66)</td>
    </tr>
    <tr>
      <th scope="row">Hematokrit</th>
      <td>+2,17 percentuálneho bodu (1,95 až 2,39)</td>
      <td>−0,13 (−0,28 až 0,01)</td>
      <td>+2,36 (2,19 až 2,52)</td>
    </tr>
    <tr>
      <th scope="row">Erytropoetín</th>
      <td>+2,35 mIU/ml</td>
      <td>+0,04 mIU/ml</td>
      <td>+2,11 mIU/ml (0,5 až 3,71)</td>
    </tr>
    <tr>
      <th scope="row">Saturácia transferínu</th>
      <td>−2,2 %</td>
      <td>−0,10 %</td>
      <td>−0,84 percentuálneho bodu (−1,21 až −0,47)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdiely hemoglobínu, hematokritu a saturácie transferínu sú štatisticky významné (p &lt; 0,001). Rozdiel erytropoetínu je tiež významný (p = 0,01), interval spoľahlivosti je však široký. V kontrolnom ramene hemoglobín klesol o 0,08 g/dl (p = 0,003). Hematokrit v kontrole sa významne nezmenil (p = 0,07). Na rozdiele hemoglobínu sa preto podieľa aj malý pokles v kontrole, nielen nárast pri inhibítore SGLT2.</p>

<p>Zmeny vnútri ramien a rozdiel medzi ramenami sú samostatné združené odhady. Pri saturácii transferínu sa vnútroramenné zmeny a medzi skupinový rozdiel číselne nesčítajú. Na porovnanie s kontrolou platí rozdiel −0,84 percentuálneho bodu.</p>

<p>Štyri zo šiestich vedľajších ukazovateľov boli s inhibítormi SGLT2 spojené významne. Abstrakt z nich menovite uvádza len erytropoetín a saturáciu transferínu. Koncentráciu erytrocytov, feritín, sérové železo a hepcidín číslami neuvádza. Správa Univerzitného medicínskeho centra v Groningene k tej istej práci hovorí, že feritín klesol a sérové železo sa podstatne nezmenilo. Veľkosť týchto dvoch zmien abstrakt neudáva. Hepcidín v abstrakte vyhodnotený nie je, takže z neho nemožno tvrdiť ani významný pokles, ani absenciu zmeny.</p>

<h2>Prečo vstupný hemoglobín 13,6 g/dl obmedzuje prenos do ambulancie</h2>

<p>Väčšina zaradených ľudí anémiu nemala. Priestor na ďalší nárast je iný ako u pacienta s hemoglobínom okolo 9 g/dl, ktorý už dostáva látku stimulujúcu erytropoézu (ESA). Abstrakt metaanalýzy takúto podskupinu neuvádza.</p>

<p>Komentár European Renal Best Practice (ERBP) k odporúčaniu KDIGO 2026 zhŕňa osobitne štúdie fázy 3 pri CKD: nárast hemoglobínu oproti placebu približne o 0,7 g/dl a hematokritu o 2,2 až 2,4 percentuálneho bodu. To je bližšie nefrologickej populácii. Stále to nie je odhad pre dialyzovaného pacienta s anémiou liečeného ESA a v tomto texte nebol znova prepočítaný z pôvodných štúdií. Je to syntéza komentára, nie výsledok metaanalýzy v JAMA.</p>

<h2>Hemoglobín rastie, markery železa klesajú</h2>

<p>KDIGO 2026 podľa komentára ERBP žiada pri diagnóze anémie krvný obraz, retikulocyty, feritín a saturáciu transferínu. Vitamín B12 a folát už nie sú súčasťou povinného úvodného panelu. Hemoglobín a hematokrit nie sú vyšetrenia plazmy. Nízka saturácia pri nízkom feritíne sa volá systémový nedostatok železa. Nízka saturácia pri vyššom feritíne sa už nevolá funkčný nedostatok, ale železo-reštrikovaná erytropoéza.</p>

<p>Ak po nasadení inhibítora SGLT2 hemoglobín stúpne a feritín so saturáciou klesnú, obraz zodpovedá skôr spotrebe železa na erytropoézu než doplneniu zásob. Nárast erytropoetínu v metaanalýze tento výklad podporuje. Sám osebe však nepovie, aká časť nárastu hematokritu pripadá na novotvorbu erytrocytov a aká na zníženie objemu plazmy. Starší prehľad, ktorý napísali Cases a spolupracovníci, a komentár ERBP opisujú aj skorý vzostup retikulocytov a pokles hepcidínu. To je mechanistický rámec z predchádzajúcej literatúry, nie číselný výsledok metaanalýzy z roku 2026.</p>

<p>Pokles saturácie o 0,84 percentuálneho bodu je malý voči rozhodovacím prahom. Sám osebe z pacienta so saturáciou 28 % neurobí kandidáta na železo. Ak však hodnota prejde prah, pri ktorom KDIGO železo navrhuje, spotreba železa mohla prejsť do skutočného nedostatku. Platí to najmä tam, kde súčasne stúpa dávka ESA. Zápal, krvná strata a zmena objemu plazmy zostávajú v diferenciálnej diagnóze nízkej saturácie. Prahy, pri ktorých KDIGO 2026 železo začína a kedy ho prerušuje, rozoberá <a href="article.php?slug=zelezo-anemia-ckd-kdigo-2026-erbp">samostatný článok o železe</a>. Tento text ich neprepisuje.</p>

<h2>Čo z analýzy nevyplýva pre ESA a železo</h2>

<p>Abstrakt nerozdeľuje účinok podľa súbežného železa ani podľa ESA. Očakávanie, že obe liečby zvýšia dopyt po železe, je fyziologický úsudok, nie výsledok interakčnej analýzy. Pri rozhodovaní ostáva logika KDIGO: železo sa posudzuje opakovane, podľa cieľa (zvýšiť hemoglobín alebo znížiť dávku ESA) a podľa feritínu so saturáciou. Nestačí jeden odber krátko po nasadení inhibítora SGLT2.</p>

<p>Zmysluplné je porovnať odber pred nasadením s ďalším v čase, keď sa účinok na erytropoézu už mohol prejaviť, a čítať ich spolu s retikulocytmi, zápalom a krvnými stratami. Cieľové hodnoty hemoglobínu pri ESA sa touto metaanalýzou nemenia.</p>

<h2>Limity</h2>

<ul>
  <li><strong>Plný text práce v JAMA nebol v čase prípravy článku voľne dostupný.</strong> Čísla primárnych ukazovateľov, erytropoetínu a saturácie transferínu sú zo štruktúrovaného abstraktu. Smer zmeny feritínu a sérového železa je zo správy pracoviska autorov, bez intervalu spoľahlivosti.</li>
  <li><strong>Hepcidín, koncentrácia erytrocytov a pomer zmeny hematokritu k hemoglobínu v abstrakte vyčíslené nie sú.</strong> Tvrdenie o sklone 3,73 ani o poklese feritínu o 15,05 ng/ml sa preto nepreberá. Rovnako sa nepreberá tvrdenie, že hepcidín sa v tejto metaanalýze významne nezmenil.</li>
  <li><strong>Súbor nie je kohorta anémie pri CKD.</strong> Priemerný hemoglobín 13,6 g/dl to ukazuje priamo. Trvanie 4 až 219 týždňov abstrakt neuvádza. Uvádza medián 24 týždňov a medzikvartilové rozpätie 12 až 32 týždňov.</li>
  <li><strong>Odhad 0,7 g/dl pri CKD je syntéza komentára ERBP,</strong> nie výsledok tejto metaanalýzy, a nebol tu znova extrahovaný z pôvodných štúdií fázy 3.</li>
  <li><strong>Klinický význam nárastu o 0,60 g/dl autori označujú za nejasný.</strong> Mediačné analýzy, podľa ktorých nárast hemoglobínu súvisí s kardiorenálnym prínosom, pochádzajú zo staršieho prehľadu. Nepotvrdzujú, že prínos inhibítorov SGLT2 ide cez hemoglobín.</li>
  <li><strong>Bezpečnosť pri už prítomnej erytrocytóze komentár ERBP necháva otvorenú.</strong> Pri hemoglobíne nad 16,5 g/dl u mužov a nad 16 g/dl u žien, najmä pri nedostatku železa, leukocytóze, trombocytóze, svrbení alebo splenomegálii, treba pomýšľať na polycytémiu vera. To je iná otázka než anémia.</li>
</ul>

<h2>Záver</h2>

<p>Inhibítory SGLT2 hemoglobín a hematokrit mierne a konzistentne zvyšujú. Súčasný pokles saturácie transferínu, a podľa autorov aj feritínu, zapadá do vyššieho využitia železa, nie do obrazu doplnených zásob. Pri anémii CKD sa prahy KDIGO nemenia. Mení sa len čítanie jedného odberu: rastúci hemoglobín pri klesajúcom feritíne nie je sám osebe dôkaz, že nedostatok železa sa zhoršuje, a nie je ani dôvod železo vynechať, ak pacient prah KDIGO spĺňa.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani súhrn charakteristických vlastností lieku.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Yang Y, Yang C, Wang Y, Rawee P, Cases A, Leaf DE, Del Vecchio L, Muka T, Heerspink HJL, Gansevoort RT, Eisenga MF. Sodium-Glucose Cotransporter 2 Inhibitor Use and Levels of Hemoglobin, Markers of Iron Metabolism, and Erythropoiesis: A Systematic Review and Meta-Analysis of Randomized Clinical Trials. <em>JAMA.</em> 2026. Online pred zaradením do čísla, ročník a strany v PubMed v čase overenia neboli pridelené. DOI: <a href="https://doi.org/10.1001/jama.2026.19921" target="_blank" rel="noopener noreferrer">10.1001/jama.2026.19921</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42925557/" target="_blank" rel="noopener noreferrer">PubMed PMID 42925557</a>. PMC13695848.</small></li>
  <li><small>Del Vecchio L, Cases A, Eisenga MF, Małyszko J, Barratt J, Bolignano D. KDIGO 2026 Clinical Practice Guideline for Anemia in Chronic Kidney Disease (CKD): a commentary from the European Renal Best Practice (ERBP). <em>Nephrol Dial Transplant.</em> 2026;41(8):1554–1572. DOI: <a href="https://doi.org/10.1093/ndt/gfag014" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag014</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41604211/" target="_blank" rel="noopener noreferrer">PubMed PMID 41604211</a>. PMC13423824.</small></li>
  <li><small>Cases A, Cigarrán S, Górriz JL, Núñez J. Effect of SGLT2 inhibitors on anemia and their possible clinical implications. <em>Nefrologia (Engl Ed).</em> 2024;44(2):165–172. DOI: <a href="https://doi.org/10.1016/j.nefroe.2024.03.011" target="_blank" rel="noopener noreferrer">10.1016/j.nefroe.2024.03.011</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38604895/" target="_blank" rel="noopener noreferrer">PubMed PMID 38604895</a>.</small></li>
  <li><small>University Medical Center Groningen. Large meta-analysis sheds new light on how SGLT2 inhibitors affect blood and iron parameters. <em>Medical Xpress.</em> 26. októbra 2026. <a href="https://medicalxpress.com/news/2026-10-large-meta-analysis-sglt2-inhibitors.html" target="_blank" rel="noopener noreferrer">medicalxpress.com</a>. Správa pracoviska autorov metaanalýzy, nie samostatná recenzovaná publikácia.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Štruktúrovaný abstrakt metaanalýzy bol overený cez PubMed (PMID 42925557) a OpenAlex. Úplný autorský zoznam, 11 mien, pochádza z PubMed. Plný text JAMA bol v čase prípravy uzavretý. Smer zmeny feritínu a sérového železa je preto prevzatý zo správy Univerzitného medicínskeho centra v Groningene z 26. októbra 2026 a je tak v texte označený. Komentár ERBP (PMID 41604211, PMC13423824) bol čítaný v plnom znení, vrátane časti o inhibítoroch SGLT2 a o základnom paneli vyšetrení. Prehľad Casesa, Cigarrána, Górriza a Núñeza bol overený na úrovni abstraktu a bibliografie (PMID 38604895). Anglické vydanie má DOI 10.1016/j.nefroe.2024.03.011. Predloha zamieňala hornú hranicu intervalu vnútroramennej zmeny hemoglobínu (0,61) s rozdielom oproti kontrole (0,60), uvádzala rozsah trvania 4 až 219 týždňov namiesto medzikvartilového rozpätia, pripisovala metaanalýze neoverený sklon 3,73 a pokles feritínu o 15,05 ng/ml a tvrdila, že hepcidín sa významne nezmenil. Tieto údaje abstrakt neobsahuje a do článku neprešli. Autor projektu doplnil oddelenie výsledku randomizovaného porovnania od mechanistického výkladu, vzťah malého poklesu saturácie k prahom KDIGO a limity prenosu na anemického pacienta liečeného ESA.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=zelezo-anemia-ckd-kdigo-2026-erbp">Železo pri anémii v CKD podľa KDIGO 2026: prahy, proaktívna substitúcia a pohľad ERBP</a></li>
  <li><a href="article.php?slug=anemia-ckd-kdigo-2026-kdoqi-komentar">Anémia pri CKD podľa KDIGO 2026: komentár KDOQI</a></li>
  <li><a href="article.php?slug=anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi">Anémia pri CKD 2026: algoritmus od diagnostiky po ESA a HIF-PHI</a></li>
  <li><a href="article.php?slug=sglt2-inhibitory-rozdiely-schvalene-indikacie-srdce-oblicky">Inhibítory SGLT2: rozdiely v schválených indikáciách pre srdce a obličky</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_inhibitory-sglt2-hemoglobin-anemia-ckd_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
