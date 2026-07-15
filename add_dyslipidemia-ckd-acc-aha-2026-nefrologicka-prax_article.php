<?php
/**
 * add_dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax_article.php
 * Odborný článok o manažmente dyslipidémie pri CKD podľa ACC/AHA 2026.
 * Pôvodní autori spracovaného zdroja sú uvedení v source_authors.php.
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Dyslipidémia pri chronickej chorobe obličiek: čo z odporúčaní ACC/AHA 2026 mení nefrologickú prax',
    'slug'         => 'dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Presný nefrologický výklad odporúčaní ACC/AHA 2026: koho liečiť bez skóre PREVENT, aké ciele platia pri CKD s ASCVD a prečo je dialýza osobitnou situáciou.',
    'content'      => <<<'HTML'
<p>Kardiovaskulárne ochorenia patria medzi hlavné príčiny chorobnosti a úmrtnosti pacientov s chronickou chorobou obličiek (CKD). Riziko stúpa s poklesom odhadovanej glomerulovej filtrácie (eGFR), albuminúriou, diabetom, artériovou hypertenziou a už prítomným aterosklerotickým kardiovaskulárnym ochorením (ASCVD). Manažment dyslipidémie je preto dôležitou súčasťou kardiorenálnej prevencie, jeho prínos však nie je rovnaký v predialyzačnej CKD, počas dialýzy a po transplantácii obličky.</p>

<p>Van Craenenbroeck a spoluautori v časopise <em>Nephrology Dialysis Transplantation</em> komentovali nové multidisciplinárne odporúčania ACC/AHA pre manažment dyslipidémie z roku 2026 z pohľadu nefrológa. Najvýznamnejšou zmenou je návrat k explicitným cieľovým hodnotám LDL cholesterolu (LDL-C) a non-HDL cholesterolu, používanie modelu PREVENT a presné odporúčania pre pacientov s CKD v štádiu G3 alebo vyššom.</p>

<p>Americké odporúčania nenahrádzajú európske usmernenia ani KDIGO. Pre slovenskú prax sú však dôležité, pretože presnejšie pomenúvajú vysoké aterosklerotické riziko pri CKD a ponúkajú praktický rámec pre eskaláciu liečby. Všeobecné zmeny odporúčaní vrátane rizikových kategórií PREVENT sú podrobnejšie rozobraté v samostatnom článku <a href="article.php?slug=nove-odporucania-dyslipidemia-prevent-ldl-ciele">Nové odporúčania pre dyslipidémiu</a>; tento text sa sústreďuje na nefrologické situácie.</p>

<h2>Tri kľúčové odporúčania pre CKD</h2>

<p>Presné znenie CKD časti odporúčaní je užšie, než môže naznačovať všeobecné tvrdenie „CKD G3 znamená automaticky statín“. Rozhodujú vek, rozsah LDL-C, prítomnosť klinického ASCVD a dialyzačný status.</p>

<div class="table-responsive" role="region" aria-label="Odporúčania ACC a AHA 2026 pre dyslipidémiu pri CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Klinická situácia</th>
      <th scope="col">Odporúčaný postup</th>
      <th scope="col">Trieda a úroveň dôkazov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Vek 40–75 rokov, CKD v štádiu G3 alebo vyššom, LDL-C 1,8–4,9 mmol/l (70–189 mg/dl)</td>
      <td>Stredne intenzívny statín alebo kombinácia stredne intenzívneho statínu s ezetimibom na zníženie rizika ASCVD</td>
      <td>I, B-R</td>
    </tr>
    <tr>
      <td>CKD v štádiu G3 alebo vyššom a klinické ASCVD</td>
      <td>Vysokointenzívny statín s možným pridaním ezetimibu a/alebo monoklonálnej protilátky proti PCSK9; cieľom je pokles LDL-C najmenej o 50 %, LDL-C &lt;1,4 mmol/l (&lt;55 mg/dl) a non-HDL-C &lt;2,2 mmol/l (&lt;85 mg/dl)</td>
      <td>I, B-R</td>
    </tr>
    <tr>
      <td>Udržiavacia hemodialýza a už prebiehajúca statínová liečba</td>
      <td>V liečbe možno pokračovať po individuálnom zohľadnení prognózy, komorbidít a závažnosti ASCVD</td>
      <td>IIb, C-LD</td>
    </tr>
  </tbody>
</table>
</div>

<p>Prvá veta sa týka primárnej prevencie vo vymedzenom veku a rozsahu LDL-C. Pacienti s LDL-C ≥4,9 mmol/l (≥190 mg/dl) patria do osobitného algoritmu závažnej hypercholesterolémie. Pri hodnotách mimo uvedeného rozsahu alebo mimo veku 40–75 rokov nemožno CKD odporúčanie mechanicky extrapolovať; rozhoduje celkový klinický kontext a ďalšie príslušné časti usmernenia.</p>

<h2>PREVENT už obličky neignoruje</h2>

<p>Odporúčania nahrádzajú staršie rovnice Pooled Cohort Equations modelom PREVENT-ASCVD. Ten odhaduje desaťročné aj tridsaťročné riziko u dospelých vo veku 30–79 rokov bez známeho kardiovaskulárneho ochorenia; v usmernení sa používa pri LDL-C 1,8–4,9 mmol/l. Na rozdiel od staršieho modelu povinne zahŕňa eGFR; pomer albumínu ku kreatinínu v moči (UACR) možno pridať ako voliteľný parameter spolu s HbA1c a indexom sociálnej deprivácie.</p>

<p>PREVENT preto lepšie prepája kardiovaskulárne, obličkové a metabolické riziko. Ani tento model však nie je určený pre sekundárnu prevenciu, zlyhanie obličiek ani závažné subklinické kardiovaskulárne ochorenie. Pri pacientovi vo veku 40–75 rokov s CKD v štádiu G3 alebo vyššom a LDL-C 1,8–4,9 mmol/l navyše nízky vypočítaný výsledok nemá byť dôvodom na odklad liečby, pretože táto skupina má samostatné odporúčanie triedy I.</p>

<p>Model bol odvodený a validovaný v populácii Spojených štátov; americký index sociálnej deprivácie založený na poštovom smerovacom čísle nie je priamo prenosný do slovenského prostredia. PREVENT preto môže byť informatívny, ale v európskej praxi nenahrádza odporúčané modely SCORE2 alebo SCORE2-OP ani klinické posúdenie CKD.</p>

<p>UACR zostáva klinicky významný aj vtedy, keď nie je zadaný do kalkulátora. Albuminúria je nezávislým ukazovateľom kardiovaskulárneho aj obličkového rizika a spolu s eGFR určuje prognostickú kategóriu CKD podľa KDIGO.</p>

<h2>Návrat cieľových hodnôt LDL-C</h2>

<p>Americké odporúčania opäť používajú absolútne cieľové hodnoty LDL-C a non-HDL-C. V primárnej prevencii je všeobecným cieľom pri hraničnom alebo strednom riziku LDL-C &lt;2,6 mmol/l (&lt;100 mg/dl) a non-HDL-C &lt;3,4 mmol/l (&lt;130 mg/dl). Pri vysokom desaťročnom riziku PREVENT-ASCVD ≥10 % sú ciele LDL-C &lt;1,8 mmol/l (&lt;70 mg/dl) a non-HDL-C &lt;2,6 mmol/l (&lt;100 mg/dl).</p>

<p>Pri CKD v štádiu G3 alebo vyššom s klinickým ASCVD platí prísnejší CKD-špecifický cieľ: LDL-C &lt;1,4 mmol/l, non-HDL-C &lt;2,2 mmol/l a súčasne pokles LDL-C najmenej o 50 % oproti východiskovej hodnote. Nejde teda o voľbu medzi cieľom 1,8 a 1,4 mmol/l podľa neurčitej kategórie „veľmi vysokého“ rizika; v tejto konkrétnej kombinácii CKD a ASCVD odporúčanie priamo uvádza cieľ 1,4 mmol/l.</p>

<h2>Statín je základ, ale nie vždy postačuje</h2>

<p>V primárnej prevencii pri CKD v štádiu G3 alebo vyššom odporúčanie uprednostňuje stredne intenzívny statín alebo jeho kombináciu s ezetimibom. Pri klinickom ASCVD je základom vysokointenzívny statín, ak ho pacient toleruje. Keď sa požadovaný pokles alebo cieľ nedosiahne, liečba sa rozširuje podľa absolútneho rizika, východiskového LDL-C, tolerancie a dostupnosti.</p>

<ul>
  <li><strong>Ezetimib</strong> má pri CKD oporu aj v štúdii SHARP a umožňuje ďalšie zníženie LDL-C bez zvyšovania dávky statínu.</li>
  <li><strong>Monoklonálne protilátky proti PCSK9</strong> majú dôkazy o kardiovaskulárnom prínose pri miernej až stredne ťažkej CKD; údaje pri eGFR &lt;20 ml/min/1,73 m<sup>2</sup> sú obmedzené.</li>
  <li><strong>Kyselina bempedoová</strong> je možnosťou pri vybraných pacientoch, ale pri ťažkej CKD a dialýze chýbajú dostatočné údaje a treba rešpektovať schválené dávkovanie a bezpečnostný profil.</li>
  <li><strong>Inklisiran</strong> účinne znižuje LDL-C, no odporúčania upozorňujú, že štúdie hodnotiace vplyv na klinické kardiovaskulárne príhody ešte prebiehajú. Jeho účinok na LDL-C preto nemožno automaticky stotožniť s výsledkovými dôkazmi monoklonálnych protilátok proti PCSK9.</li>
</ul>

<p>Výber statínu a dávky musí zohľadniť funkciu obličiek a interakcie. Atorvastatín má nízky renálny klírens, zatiaľ čo pri ťažkej CKD sa zvyšuje expozícia rosuvastatínu a môže byť potrebné obmedziť dávku podľa súhrnu charakteristických vlastností lieku. Riziko myopatie zvyšujú najmä nevhodné kombinácie s gemfibrozilom, niektorými makrolidmi a azolovými antimykotikami či interakcie s imunosupresívami.</p>

<h2>Dialýza: nezačínať rutinne, pokračovanie individualizovať</h2>

<p>Randomizované štúdie 4D a AURORA ani dialyzačná podskupina štúdie SHARP nepreukázali presvedčivý prínos rutinného nového nasadenia statínu po začatí dialýzy. V tejto populácii sa na kardiovaskulárnom riziku výrazne podieľajú aj neaterosklerotické mechanizmy, ktoré samotné zníženie LDL-C neovplyvní v rovnakej miere.</p>

<p>ACC/AHA 2026 preto nepodporuje rutinné nové nasadenie statínu pri udržiavacej hemodialýze. Ak pacient statín už užíval, pokračovanie môže byť rozumné, ale má zohľadniť očakávané prežívanie, komorbidity, závažnosť ASCVD, polyfarmáciu a preferencie pacienta. Nejde o absolútny zákaz liečby, ale o situáciu, v ktorej je priemerný očakávaný prínos menší a rozhodnutie musí byť individuálne.</p>

<p>Presná americká formulácia sa týka udržiavacej hemodialýzy. KDIGO používa širší pojem dialyzačne závislá CKD: neodporúča rutinné začatie statínu ani kombinácie statínu s ezetimibom, no navrhuje pokračovať v liečbe, ktorú pacient už dostával pri začatí dialýzy.</p>

<h2>Transplantácia obličky je osobitná situácia</h2>

<p>CKD časť odporúčaní ACC/AHA neposkytuje samostatný transplantologický algoritmus. KDIGO však u dospelých príjemcov transplantovanej obličky navrhuje liečbu statínom pre ich vysoké kardiovaskulárne riziko.</p>

<p>V praxi treba venovať mimoriadnu pozornosť interakciám. Cyklosporín môže výrazne zvýšiť expozíciu viacerým statínom; interagovať môžu aj takrolimus, azolové antimykotiká, makrolidy a ďalšie lieky. Výber prípravku a maximálnej dávky sa preto musí riadiť konkrétnou imunosupresívnou schémou, súhrnom charakteristických vlastností lieku a miestnym transplantologickým protokolom.</p>

<h2>Lipoproteín(a), apoB a koronárne kalciové skóre</h2>

<p>Odporúčania podporujú aspoň jedno meranie lipoproteínu(a), Lp(a), počas dospelosti. Koncentrácia &gt;125 nmol/l je spojená približne s 1,4-násobným a koncentrácia &gt;250 nmol/l najmenej s dvojnásobným rizikom ASCVD. Hodnoty v nmol/l a mg/dl sa pre rozdielnu veľkosť izoforiem apolipoproteínu(a) nemajú prepočítavať jedným pevným faktorom.</p>

<p>Apolipoproteín B môže spresniť reziduálne aterogénne riziko najmä pri diabete, kardiovaskulárno-obličkovo-metabolickom (CKM) syndróme, hypertriglyceridémii alebo nesúlade medzi LDL-C a non-HDL-C. Ani Lp(a), ani apoB však nenahrádzajú základný lipidový profil a klinické hodnotenie.</p>

<p>Koronárne kalciové skóre (CAC) má význam najmä vtedy, keď je rozhodnutie o začatí alebo intenzite liečby neisté. Nemá slúžiť na zrušenie jednoznačnej indikácie u pacienta vo veku 40–75 rokov s CKD v štádiu G3 alebo vyššom v rozsahu LDL-C uvedenom v odporúčaniach. Pri pokročilej CKD býva kalcifikačná záťaž vysoká a jej patofyziológia komplexná; výsledok preto treba interpretovať spolu s klinickým obrazom, nie izolovane.</p>

<h2>ACC/AHA, KDIGO a ESC/EAS nie sú totožné</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie prístupov k dyslipidémii pri CKD" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Usmernenie</th>
      <th scope="col">Hlavný princíp pri CKD</th>
      <th scope="col">Praktická poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>ACC/AHA 2026</td>
      <td>Rizikovo orientované ciele LDL-C a non-HDL-C; osobitné odporúčania pre CKD v štádiu G3 alebo vyššom, ASCVD a hemodialýzu</td>
      <td>Primárna CKD indikácia je presne vymedzená vekom 40–75 rokov a LDL-C 1,8–4,9 mmol/l</td>
    </tr>
    <tr>
      <td>KDIGO 2013/2024</td>
      <td>Liečba podľa veku, štádia CKD a celkového rizika; tradične skôr pevný režim než titrácia na LDL-C cieľ</td>
      <td>Osobitne rieši dialyzačne závislú CKD a transplantáciu obličky</td>
    </tr>
    <tr>
      <td>ESC/EAS 2019 s aktualizáciou 2025</td>
      <td>CKD v štádiu G3 sa považuje za vysoké a CKD v štádiách G4–G5 za veľmi vysoké kardiovaskulárne riziko</td>
      <td>Ciele zostali po aktualizácii nezmenené: pri vysokom riziku LDL-C &lt;1,8 mmol/l a pri veľmi vysokom &lt;1,4 mmol/l, spravidla spolu s poklesom najmenej o 50 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdiely nie sú iba terminologické. Americké odporúčania pracujú s modelom PREVENT a osobitnými skupinami, európske s kategóriami rizika a KDIGO s pragmatickým prístupom podľa veku a štádia CKD. V slovenskej praxi treba vychádzať z aktuálnych európskych a národných odporúčaní, registrovaných indikácií, kontraindikácií a úhradových podmienok.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<ol>
  <li><strong>Potvrdiť klinický kontext:</strong> štádium a chronicitu CKD, UACR, prítomnosť ASCVD, diabetes, dialýzu alebo transplantáciu, prognózu a krehkosť.</li>
  <li><strong>Zhodnotiť lipidy a sekundárne príčiny:</strong> LDL-C, non-HDL-C, triglyceridy, adherenciu, hypotyreózu, nefrotický syndróm, lieky a výživu; Lp(a) zmerať aspoň raz a apoB podľa indikácie.</li>
  <li><strong>Vybrať primeranú intenzitu liečby:</strong> statín zostáva základom; pri nedostatočnom účinku alebo tolerancii sa pridáva liek s preukázaným prínosom podľa rizika a dostupných údajov pri danej eGFR.</li>
  <li><strong>Skontrolovať odpoveď a bezpečnosť:</strong> po začatí alebo úprave liečby overiť lipidový profil, adherenciu, nežiaduce účinky a interakcie. Kreatínkináza sa bez svalových príznakov rutinne nesleduje.</li>
  <li><strong>Neizolovať cholesterol od kardiorenálnej prevencie:</strong> súčasne liečiť krvný tlak, diabetes, albuminúriu, fajčenie, obezitu a ďalšie ovplyvniteľné rizikové faktory.</li>
</ol>

<h2>Záver</h2>

<p>Odporúčania ACC/AHA 2026 potvrdzujú CKD v štádiu G3 alebo vyššom ako významnú klinickú situáciu pre hypolipidemickú liečbu, no jej presné použitie závisí od veku, LDL-C, prítomnosti ASCVD a dialyzačného statusu. V primárnej prevencii je odporúčanie triedy I vymedzené vekom 40–75 rokov a LDL-C 1,8–4,9 mmol/l. Pri CKD v štádiu G3 alebo vyššom s klinickým ASCVD sa odporúča znížiť LDL-C najmenej o 50 % a dosiahnuť hodnotu &lt;1,4 mmol/l.</p>

<p>Dialýza zostáva zásadnou výnimkou: rutinné nové nasadenie statínu po začatí udržiavacej hemodialýzy nemá presvedčivú výsledkovú oporu, zatiaľ čo pokračovanie už zavedenej liečby môže byť rozumné po individualizácii. Transplantácia obličky si vyžaduje osobitný prístup podľa KDIGO a dôslednú kontrolu interakcií.</p>

<p>Najpraktickejším posolstvom pre nefrológa je neliečiť izolované číslo LDL-C, ale presne určené aterosklerotické riziko. Cieľová hodnota má zmysel iba spolu so správne zvolenou populáciou, bezpečnou liečbou a kontrolou celého kardiorenálneho rizikového profilu.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Van Craenenbroeck AH, Mark PB, Valdivielso JM, the EuReCa-m WG of the ERA. Filtering the 2026 ACC/AHA guidelines of dyslipidaemia management: what nephrologists need to know. <em>Nephrology Dialysis Transplantation</em>. Publikované online 10. júla 2026; gfag161. DOI: 10.1093/ndt/gfag161. <a href="https://pubmed.ncbi.nlm.nih.gov/42429511/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1093/ndt/gfag161" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Americké odporúčania:</strong> Blumenthal RS, Morris PB, Gaudino M, et al. 2026 ACC/AHA/AACVPR/ABC/ACPM/ADA/AGS/APhA/ASPC/NLA/PCNA Guideline on the Management of Dyslipidemia. <em>Journal of the American College of Cardiology</em>. 2026;87(19):2624–2757. DOI: 10.1016/j.jacc.2025.11.016. <a href="https://doi.org/10.1016/j.jacc.2025.11.016" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://www.acc.org/latest-in-cardiology/journal-scans/2026/03/13/15/20/acc-aha-release-new-clinical-guideline-for-managing-dyslipidemia" target="_blank" rel="noopener noreferrer">Súhrn ACC</a>.</em></p>

<p><em><strong>Nefrologické odporúčania:</strong> Kidney Disease: Improving Global Outcomes. KDIGO Clinical Practice Guideline for Lipid Management in Chronic Kidney Disease. <em>Kidney International Supplements</em>. 2013;3:259–305. <a href="https://kdigo.org/wp-content/uploads/2017/02/KI-Lipids-Summary-and-clinical-approach.pdf" target="_blank" rel="noopener noreferrer">Súhrn odporúčaní</a> · <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024 CKD</a>.</em></p>

<p><em><strong>Európsky kontext:</strong> Mach F, Koskinas KC, et al. 2025 Focused Update of the 2019 ESC/EAS Guidelines for the management of dyslipidaemias. <em>European Heart Journal</em>. 2025;46:4359–4378. DOI: 10.1093/eurheartj/ehaf190. <a href="https://doi.org/10.1093/eurheartj/ehaf190" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://www.escardio.org/guidelines/clinical-practice-guidelines/all-esc-practice-guidelines/dyslipidaemias/" target="_blank" rel="noopener noreferrer">ESC</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_dyslipidemia_ckd_2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_dyslipidemia_ckd_2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_dyslipidemia_ckd_2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_dyslipidemia_ckd_2026 migration error: ' . $e->getMessage());
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
