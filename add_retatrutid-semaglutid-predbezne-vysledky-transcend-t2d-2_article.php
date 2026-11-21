<?php
// Predbezne vysledky z tlacovej spravy. Aviza ani newsletter nie su povolene.
if (PHP_SAPI !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';
$articles = [[
    'title' => 'Retatrutid a semaglutid: predbežné výsledky TRANSCEND-T2D-2',
    'slug' => 'retatrutid-semaglutid-predbezne-vysledky-transcend-t2d-2',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Výrobca oznámil väčší pokles hmotnosti pri retatrutide než pri semaglutide. Správa rozlišuje predbežné metabolické výsledky od dôkazov o ochrane obličiek.',
    'content' => <<<'HTML'
<figure><a href="img/retatrutid-semaglutid-predbezne-vysledky-transcend-t2d-2.webp" target="_blank" rel="noopener noreferrer"><img src="img/retatrutid-semaglutid-predbezne-vysledky-transcend-t2d-2.webp" alt="Abstraktné znázornenie pôsobenia jednej molekuly na tri typy receptorov v bunkovej membráne" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná molekulová scéna. Nezobrazuje skutočnú štruktúru liečiva ani jeho väzbu na receptory.</figcaption></figure>

<p><strong>Spoločnosť Eli Lilly 28. októbra 2026 oznámila predbežné výsledky priameho porovnania retatrutidu so semaglutidom pri diabete 2. typu. Podľa tlačovej správy bol pokles hmotnosti pri retatrutide väčší. Podrobné výsledky však zatiaľ neboli dostupné v recenzovanej publikácii. Ide o správu o oznámení výrobcu, nie o nezávisle overené definitívne závery štúdie.</strong> [1]</p>

<h2>Čo sa porovnávalo</h2>
<p>TRANSCEND-T2D-2 je randomizovaná otvorená štúdia fázy 3. Retatrutid sa skúšal pri nedostatočnej kompenzácii diabetu metformínom, prípadne v kombinácii s inhibítorom sodíkovo-glukózového kotransportéra 2 (SGLT2). Register potvrdzuje dizajn a kritériá zaradenia, výsledkové tabuľky v ňom pri príprave článku zverejnené neboli. [2]</p>

<p>Retatrutid je skúšaný agonista receptorov pre glukózovo dependentný inzulínotropný polypeptid (GIP), glukagónu podobný peptid 1 (GLP-1) a glukagón. Výrobca uvádza 1 298 účastníkov a porovnanie týždenných dávok 9 mg a 12 mg so semaglutidom 2 mg počas 80 týždňov. [1] Tieto dávky opisujú skúšanú intervenciu, nepredstavujú odporúčanie na predpisovanie.</p>

<h2>Výsledky oznámené výrobcom</h2>
<div class="table-responsive" role="region" aria-label="Predbežné výsledky oznámené výrobcom po 80 týždňoch" tabindex="0"><table><thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Retatrutid 9 mg</th><th scope="col">Retatrutid 12 mg</th><th scope="col">Semaglutid 2 mg</th></tr></thead><tbody>
<tr><th scope="row">Zmena glykovaného hemoglobínu (HbA1c), percentuálne body</th><td>−2,2</td><td>−2,2</td><td>−1,8</td></tr>
<tr><th scope="row">Zmena telesnej hmotnosti, %</th><td>−19,5</td><td>−20,9</td><td>−9,4</td></tr>
<tr><th scope="row">Ukončenie liečby pre nežiaduce udalosti, %</th><td>4,8</td><td>7,9</td><td>2,7</td></tr>
</tbody></table></div>
<p>Údaje pochádzajú výlučne z tlačovej správy. Superiorita dávky 12 mg pri HbA1c bola podľa výrobcu preukázaná so zohľadnením viacnásobného testovania. Pri dávke 9 mg bolo porovnanie HbA1c na superioritu len nominálne štatisticky významné. [1] Tieto dve tvrdenia preto nemajú rovnakú dôkazovú váhu.</p>

<h2>Aký účinok analýza odhaduje</h2>
<p>Výrobca označuje oznámenú analýzu ako <em>efficacy estimand</em>: odhad za predpokladu, že by všetci randomizovaní účastníci zotrvali na skúšanej liečbe a nepridali ďalšie antidiabetikum na dlhšie než 14 dní. [1] Nejde jednoducho o opis podskupiny, ktorá liečbu dokončila. Ide o vopred definovanú otázku, na ktorú štatistická analýza odpovedá.</p>

<p>Pre prax potrebujeme aj výsledok stratégie liečby, ktorá zohľadní jej predčasné ukončenie a potrebu ďalších liekov. Bez úplnej publikácie nemožno posúdiť, nakoľko sa tento odhad od oznámených výsledkov líši, ako sa nahrádzali chýbajúce údaje ani ako citlivé sú závery na predpoklady analýzy. Samotné percentá v tabuľke tieto otázky nezodpovedajú.</p>

<h2>Čo z toho vyplýva pre nefrológiu</h2>
<p>Vylučovacím kritériom bola odhadovaná glomerulová filtrácia (eGFR) pod 45 ml/min/1,73 m² alebo pod miestnou hranicou na vysadenie metformínu. [2] Výsledky preto nemožno priamo preniesť na pacientov s pokročilou chronickou chorobou obličiek, na dialyzačnú ani transplantačnú populáciu. Menší podiel tuku alebo nižší HbA1c zároveň nie sú zameniteľné s preukázaným spomalením progresie choroby obličiek.</p>

<p>Rozdiel oproti štúdii FLOW je podstatný. FLOW skúmala semaglutid proti placebu u pacientov s diabetom 2. typu a chronickou chorobou obličiek a preukázala zníženie rizika primárneho zloženého ukazovateľa závažných obličkových príhod alebo úmrtia z obličkových či kardiovaskulárnych príčin. [3] Z predbežných metabolických výsledkov TRANSCEND-T2D-2 nemožno vyvodiť, že retatrutid poskytuje väčšiu obličkovú ochranu než semaglutid. Na taký záver by bolo potrebné porovnanie príslušných klinických výsledkov.</p>

<h2>Čo zostáva otvorené</h2>
<p>Otvorený dizajn umožňuje, aby znalosť pridelenej liečby ovplyvnila správanie účastníkov, hlásenie ťažkostí alebo rozhodnutie liečbu ukončiť. Rozsah takého vplyvu zatiaľ nepoznáme. Tlačová správa tiež neposkytuje úplnú bezpečnostnú analýzu, podrobné intervaly spoľahlivosti ani dostatok údajov na posúdenie podskupín a dlhodobej rovnováhy prínosu a rizika.</p>

<p>Oznámenie podporuje ďalšie skúmanie retatrutidu ako metabolickej liečby. Neodôvodňuje však zmenu nefroprotektívnej liečby na základe samotného poklesu hmotnosti. Vyjadrenie Anne L. Petersovej na Medscape je odborným komentárom k rovnakému oznámeniu, nie druhým nezávislým súborom výsledkov. [4] Očakávaný termín registrácie sa nesmie zamieňať s rozhodnutím regulačného orgánu.</p>

<hr>
<p><small><em>Stav dôkazov k 21. novembru 2026: predbežné výsledky výrobcu, bez dostupnej recenzovanej výsledkovej publikácie TRANSCEND-T2D-2. Článok je určený zdravotníckym pracovníkom a nepredstavuje individuálne liečebné odporúčanie.</em></small></p>

<h2>Zdroje</h2>
<ol>
<li><small><em>Eli Lilly and Company. Lilly's retatrutide delivered greater A1C reduction and more than double the weight loss of Ozempic's highest approved dose in head-to-head trial. Tlačová správa, 28. október 2026. <a href="https://lilly.gcs-web.com/news-releases/news-release-details/lillys-retatrutide-delivered-greater-a1c-reduction-and-more" target="_blank" rel="noopener noreferrer">Úplná tlačová správa výrobcu</a>. Nejde o časopiseckú publikáciu, DOI ani PMID sa neuvádzajú.</em></small></li>
<li><small><em>Eli Lilly and Company. Effect of Retatrutide Compared With Semaglutide in Adult Participants With Type 2 Diabetes and Inadequate Glycemic Control With Metformin With or Without SGLT2 Inhibitor (TRANSCEND-T2D-2). ClinicalTrials.gov, NCT06260722. <a href="https://clinicaltrials.gov/study/NCT06260722" target="_blank" rel="noopener noreferrer">Register štúdie</a>. Overené 21. novembra 2026.</em></small></li>
<li><small><em>Vlado Perkovic, Katherine R. Tuttle, Peter Rossing, Kenneth W. Mahaffey, Johannes F. E. Mann, George Bakris, Florian M. M. Baeres, Thomas Idorn, Heidrun Bosch-Traberg, Nanna Leonora Lausvig, Richard Pratley; FLOW Trial Committees and Investigators. Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes. New England Journal of Medicine. 2024;391(2):109-121. DOI: <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2403347</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://www.nejm.org/doi/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">Vydavateľ</a>.</em></small></li>
<li><small><em>Anne L. Peters. Retatrutide vs Semaglutide for People With Type 2 Diabetes. Medscape, 20. november 2026. <a href="https://www.medscape.com/viewarticle/retatrutide-vs-semaglutide-people-type-2-diabetes-2026a10018ym" target="_blank" rel="noopener noreferrer">Východiskový odborný komentár</a>.</em></small></li>
</ol>
<h3>Súvisiaci článok</h3>
<p><a href="article.php?slug=semaglutid-oblickove-vysledky-flow">Semaglutid a obličkové výsledky v štúdii FLOW</a></p>

HTML,
]];
$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_retatrutid_semaglutid_predbezne',
]);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL;
if (!empty($result['errors'])) {
    exit(1);
}
