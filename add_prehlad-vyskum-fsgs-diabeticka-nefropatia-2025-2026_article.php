<?php
/**
 * add_prehlad-vyskum-fsgs-diabeticka-nefropatia-2025-2026_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie prehľadového článku o najnovšom výskume FSGS
 * a diabetickej choroby obličiek (2025–2026).
 * Postup: git add + commit (deploy hook → SFTP) → spustiť cez SSH.
 * ════════════════════════════════════════════════════════════════════════════
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
require_once __DIR__ . '/newsletter_notifications.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Prehľad najnovšieho výskumu: FSGS a diabetická choroba obličiek (2025–2026)',
    'slug'         => 'prehlad-vyskum-fsgs-diabeticka-nefropatia-2025-2026',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d'),
    'is_top'       => 0,
    'excerpt'      => 'Sparsentan ako prvý liek schválený špecificky na FSGS, autoprotilátky proti nefrínu v úlohe nového biomarkera a etablovanie trojkombinácie SGLT2i + GLP-1 + finerénon pri diabetickej chorobe obličiek — prehľad kľúčových zistení z rokov 2025–2026.',
    'content'      => <<<'HTML'
<p>Posledné mesiace priniesli v nefrológii niekoľko zásadných posunov. V oblasti fokálnej segmentálnej glomerulosklerózy (FSGS) ide o historicky prvé cielené schválenie liečby a o rýchle dozrievanie nových biomarkerov, pri diabetickej chorobe obličiek o postupné etablovanie kombinovanej kardiorenálnej ochrany. Nasledujúci prehľad sumarizuje najvýznamnejšie zistenia z rokov 2025 – 2026 spolu s ich dopadom na klinickú prax.</p>

<h2>FSGS – fokálna segmentálna glomeruloskleróza</h2>

<h3>1. Historický prelom: FDA schválila sparsentan (apríl 2026)</h3>

<p>Ide o najvýznamnejšiu správu v histórii liečby FSGS. Dňa 13. apríla 2026 schválil americký Úrad pre kontrolu potravín a liečiv (FDA) <strong>sparsentan (FILSPARI)</strong> ako <strong>prvý a jediný liek schválený špecificky na liečbu FSGS</strong> — po desaťročiach čisto empirickej terapie. Schválenie sa týka dospelých a detských pacientov vo veku <strong>≥ 8 rokov</strong> s FSGS <strong>bez</strong> nefrotického syndrómu.</p>

<p>Liek je duálnym antagonistom receptorov pre angiotenzín II a endotelín-1 (v liečbe IgA nefropatie je už schválený). Rozhodnutie FDA vychádza z výsledkov štúdie fázy 3 DUPLEX (n = 371, doteraz najväčšia štúdia FSGS), publikovanej v <em>New England Journal of Medicine</em>:</p>

<div class="table-responsive">
<table style="width:100%;border-collapse:collapse;margin:1rem 0;font-size:0.95rem;">
  <thead>
    <tr>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Cieľový ukazovateľ (108. týždeň)</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Sparsentan</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Irbesartan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Redukcia proteinúrie (celá populácia)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;"><strong>46 %</strong></td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">30 %</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Redukcia proteinúrie (bez nefrotického syndrómu)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;"><strong>48 %</strong></td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">27 %</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Sklon eGFR (dlhodobý pokles)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Priaznivejší trend †</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Referencia</td>
    </tr>
  </tbody>
</table>
</div>

<p><em>† Rozdiel v sklone eGFR nebol v celkovej populácii štatisticky významný.</em></p>

<p>Liek bude dostupný cez špecializované lekárne, pričom schvaľovanie úhrady zdravotnými poisťovňami bude pravdepodobne komplikované.</p>

<h3>2. Precízna medicína pretvára klasifikáciu FSGS</h3>

<p>Zásadný prehľadový článok autorov Trachtmana, Eddyho a Kretzlera, publikovaný v <em>American Journal of Kidney Diseases</em> (december 2025), mapuje súčasný stav terapeutiky FSGS v ére precíznej medicíny. KDIGO v súčasnosti uznáva 4 podtypy — primárny (imunitne podmienený), genetický, sekundárny a nešpecifikovaný — pričom výskumná komunita smeruje k <strong>mechanistickým molekulárnym podtypom</strong>, ktoré využívajú multiomické prístupy (genomika, transkriptomika, proteomika a metabolomika). Súčasná imunosupresívna liečba dosahuje remisiu u menej než 25 % pacientov, čo robí mechanistickú stratifikáciu kľúčovou prioritou výskumu.</p>

<p>Kľúčový praktický záver: genetické testovanie je dnes indikované <strong>bez ohľadu na vek</strong>, keďže až 15 % dospelých pacientov s FSGS je nositeľom kauzálnej mutácie — čo sa donedávna považovalo za výnimočné.</p>

<h3>3. Autoprotilátky proti nefrínu: transformujúci biomarker</h3>

<p>Autoprotilátky proti nefrínu sa rýchlo presúvajú z výskumnej zaujímavosti do klinickej praxe. Vyskytujú sa približne u 10 % pacientov s FSGS, pri použití modernejších testovacích metód až u 90 % prípadov idiopatického nefrotického syndrómu. Klinické dôsledky sú nasledujúce:</p>

<ul>
  <li><strong>Vedenie liečby:</strong> pacienti s pozitivitou autoprotilátok proti nefrínu dobre reagujú na rituximab, čo umožňuje precíznu terapiu šetriacu kortikosteroidy;</li>
  <li><strong>Monitorovanie:</strong> titre protilátok korelujú s odpoveďou na liečbu;</li>
  <li><strong>Pred transplantáciou:</strong> séria prípadov z roku 2026 opisuje úspešnú elimináciu protilátok pred transplantáciou s cieľom predísť recidíve FSGS po transplantácii — reálny klinický pokrok pre pacientov indikovaných na transplantáciu.</li>
</ul>

<h3>4. Vývojová línia terapií cielených na APOL1</h3>

<p>Pacienti s dvoma rizikovými alelami génu APOL1 majú výrazne vyššie riziko FSGS. V súčasnosti prebiehajú dedikované klinické štúdie:</p>

<ul>
  <li><strong>VX-147 (inaxaplin)</strong> spoločnosti Vertex — fáza 2a pri FSGS podmienenej APOL1, prebieha;</li>
  <li><strong>Baricitinib</strong> (inhibítor JAK1/2, bežne známy pri reumatoidnej artritíde) — fáza 2, štúdia JUSTICE pri FSGS a hypertenznej CKD asociovanej s APOL1, predpokladaný koniec v roku 2029.</li>
</ul>

<p>Tieto prístupy predstavujú prvé skutočne <strong>genotypovo cielené</strong> terapie FSGS.</p>

<h3>5. Ďalšia aktívna vývojová línia</h3>

<div class="table-responsive">
<table style="width:100%;border-collapse:collapse;margin:1rem 0;font-size:0.95rem;">
  <thead>
    <tr>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Liek</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Mechanizmus</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Stav</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">BI 764198</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Inhibítor kanála TRPC6</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Fáza 2, výsledky sa očakávajú</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Protilátka proti suPAR</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Neutralizácia cirkulujúceho faktora suPAR</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Prebieha</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">DMX-200 (Dimerix)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Antagonista CCR2 (blokáda dráhy MCP-1)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Prebieha</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Metformín</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Aktivácia AMP-kinázy</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Prebieha štúdia pri FSGS</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Aktivátor KLF15</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Stabilizácia aktínu podocytov (podobne ako steroidy, bez systémovej imunosupresie)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Predklinická fáza, sľubné výsledky</td>
    </tr>
  </tbody>
</table>
</div>

<p>Výskum aktivátorov KLF15 je obzvlášť zaujímavý — replikuje priaznivé podocytárne účinky kortikosteroidov bez ich systémových nežiaducich účinkov.</p>

<h2>Diabetická choroba obličiek (DKD)</h2>

<h3>1. Štúdia FLOW: semaglutid si upevnil historické miesto</h3>

<p>Štúdia FLOW (publikovaná v <em>NEJM</em> v roku 2024, s rozsiahlymi subskupinovými analýzami v rokoch 2025 – 2026) bola predčasne ukončená pre preukázanú účinnosť. U pacientov s diabetom mellitus 2. typu (DM2) a CKD dosiahol subkutánny semaglutid podávaný raz týždenne <strong>24-percentnú relatívnu redukciu rizika</strong> kombinovaného primárneho cieľového ukazovateľa (trvalý pokles eGFR o ≥ 50 %, zlyhanie obličiek [ESKD], kardiovaskulárna smrť alebo úmrtie z akejkoľvek príčiny). Analýza v <em>CJASN</em> z mája 2026 potvrdila konzistentný prínos <strong>naprieč všetkými stupňami závažnosti CKD</strong> — teda bez ohľadu na úroveň eGFR či albuminúrie.</p>

<p>V januári 2025 FDA schválila injekčnú formu semaglutidu na liečbu CKD pri DM2. Štúdia SELECT navyše preukázala 22-percentnú redukciu závažných renálnych príhod u pacientov s obezitou alebo nadváhou.</p>

<h3>2. Inhibítory SGLT2 verzus agonisty GLP-1: prvé priame porovnanie</h3>

<p>Rozsiahla štúdia v <em>JAMA Internal Medicine</em>, ktorá využila dánske registrové dáta (sledovanie 5 rokov), postavila obe liekové skupiny zoči-voči:</p>

<div class="table-responsive">
<table style="width:100%;border-collapse:collapse;margin:1rem 0;font-size:0.95rem;">
  <thead>
    <tr>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Cieľový ukazovateľ</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Inhibítory SGLT2</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Agonisty GLP-1</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">5-ročné riziko CKD</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;"><strong>6,7 %</strong></td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">8,2 %</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Príhody akútneho poškodenia obličiek (AKI)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;"><strong>menej časté</strong></td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">častejšie</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Pokles eGFR o ≥ 40 %</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;"><strong>nižší pomer rizík (HR)</strong></td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">referencia</td>
    </tr>
  </tbody>
</table>
</div>

<p>Inhibítory SGLT2 sa javia ako účinnejšie pri priamej ochrane obličiek, kým agonisty GLP-1 pridávajú zníženie telesnej hmotnosti, redukciu kardiovaskulárneho rizika a prínosy pri aterosklerotickom kardiovaskulárnom ochorení (ASCVD). Rastúci konsenzus ich vníma ako komplementárne, nie konkurenčné stratégie.</p>

<h3>3. Finerénon verzus spironolaktón: prvé priame porovnanie</h3>

<p>Emulácia cieľového klinického skúšania (target trial emulation) publikovaná v <em>Nature Communications</em> (október 2025) priniesla prvé porovnanie finerénonu a spironolaktónu z reálnej praxe u pacientov s DM2 a CKD (n = 2 268 po spárovaní podľa skóre náchylnosti, databáza TriNetX):</p>

<div class="table-responsive">
<table style="width:100%;border-collapse:collapse;margin:1rem 0;font-size:0.95rem;">
  <thead>
    <tr>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Cieľový ukazovateľ</th>
      <th style="text-align:left;padding:10px 12px;border-bottom:2px solid var(--border-color);background:var(--bg-secondary);">Finerénon vs. spironolaktón</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Úmrtnosť z akejkoľvek príčiny</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">aHR 0,31 (o 69 % nižšia)</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">MACE (závažné kardiovaskulárne príhody)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">aHR 0,74 (o 26 % nižšie riziko)</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">MAKE (závažné obličkové príhody)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">aHR 0,47 (o 53 % nižšie riziko)</td>
    </tr>
    <tr>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">Hyperkaliémia (K⁺ ≥ 5,5 mmol/l)</td>
      <td style="padding:10px 12px;border-bottom:1px solid var(--border-color);vertical-align:top;">17,2 % vs. 26,4 %</td>
    </tr>
  </tbody>
</table>
</div>

<p><em>aHR = upravený pomer rizík (adjusted hazard ratio).</em></p>

<p>Tieto zistenia silne favorizujú finerénon pred spironolaktónom pri kombinácii CKD a DM2, pričom výhoda z hľadiska hyperkaliémie je klinicky mimoriadne dôležitá pre dodržiavanie liečby. Priebežné subanalýzy štúdie FIDELITY (2025 – 2026) potvrdili konzistentný prínos aj u krehkých pacientov, pacientov čiernej pleti a užívateľov diuretík.</p>

<h3>4. Trojkombinácia ako nastupujúci štandard</h3>

<p>Kombinácia <strong>inhibítor SGLT2 + agonista GLP-1 + finerénon</strong> (na pozadí inhibítora ACE alebo blokátora receptorov pre angiotenzín) sa etabluje ako optimálna stratégia kardiorenálnej ochrany pri DM2 a CKD. Každá lieková trieda pôsobí na odlišné, vzájomne sa dopĺňajúce patofyziologické dráhy — čo potvrdzuje aj dokument ADA <em>Standards of Care 2025</em> (<em>Diabetes Care</em>).</p>

<h3>5. Nový obzor: agonisty GLP-1 pri diabete 1. typu</h3>

<p>Štúdia z pracoviska Johns Hopkins z roku 2026 preukázala prelomové zlepšenie srdcových a obličkových výsledkov u pacientov s diabetom 1. typu (DM1) užívajúcich agonisty GLP-1 — v populácii, ktorá bola doteraz v renálnych štúdiách výrazne podreprezentovaná.</p>

<h2>Záver pre klinickú prax</h2>

<p><strong>FSGS:</strong> Sparsentan je dnes liekom prvej voľby špecifickým pre FSGS bez nefrotického syndrómu. Testovanie autoprotilátok proti nefrínu dozrieva na reálny klinický nástroj a genetické testovanie si zaslúži širšie využitie. Vývojová línia je bohatá, väčšina liekov je však stále vo fáze 2.</p>

<p><strong>DKD:</strong> Trojvrstvová kardiorenálna ochrana (inhibítor SGLT2 + agonista GLP-1 + finerénon) sa stáva de facto štandardom. Finerénon jasne prekonáva spironolaktón z hľadiska účinnosti aj znášanlivosti. Dáta zo štúdie FLOW pre semaglutid sú robustné naprieč všetkými stupňami CKD.</p>

<h2>Zdroje</h2>

<ol>
  <li>Trachtman H, Eddy AA, Kretzler M. <em>Current and Future Therapeutics for Focal Segmental Glomerular Sclerosis in the Era of Precision Medicine: A Review.</em> American Journal of Kidney Diseases (2025). <a href="https://www.ajkd.org/article/S0272-6386(25)01210-7/fulltext" target="_blank" rel="noopener noreferrer">ajkd.org</a></li>
  <li>Travere Therapeutics. <em>FDA Approves Sparsentan (FILSPARI) for Focal Segmental Glomerulosclerosis.</em> NephCure Foundation, apríl 2026. <a href="https://nephcure.org/fda-approves-sparsentan-for-fsgs-marking-a-landmark-achievement-for-patients-living-with-rare-kidney-disease/" target="_blank" rel="noopener noreferrer">nephcure.org</a></li>
  <li>Rheault MN et al. <em>Sparsentan versus Irbesartan in Focal Segmental Glomerulosclerosis (DUPLEX).</em> New England Journal of Medicine. <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2308550" target="_blank" rel="noopener noreferrer">nejm.org</a></li>
  <li><em>UCSF FSGS Clinical Trials 2026.</em> <a href="https://clinicaltrials.ucsf.edu/focal-segmental-glomerulosclerosis" target="_blank" rel="noopener noreferrer">clinicaltrials.ucsf.edu</a></li>
  <li><em>Anti-nephrin autoantibodies in post-transplant recurrent FSGS.</em> PubMed Central (2026). <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13090191/" target="_blank" rel="noopener noreferrer">pmc.ncbi.nlm.nih.gov</a></li>
  <li><em>NephMadness 2025: Anti-Nephrin Antibodies.</em> AJKD Blog (2025). <a href="https://ajkdblog.org/2025/04/07/nephmadness-2025-anti-nephrin-antibodies-the-breakthrough-that-will-transform-minimal-change-disease-management/" target="_blank" rel="noopener noreferrer">ajkdblog.org</a></li>
  <li><em>Design and Rationale of the Phase 2 Baricitinib (JUSTICE) Study for APOL1-Associated Kidney Disease.</em> PMC. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11403079/" target="_blank" rel="noopener noreferrer">pmc.ncbi.nlm.nih.gov</a></li>
  <li>Perkovic V et al. <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes (FLOW).</em> New England Journal of Medicine (2024). <a href="https://www.nejm.org/doi/full/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">nejm.org</a></li>
  <li><em>The FLOW of Progress in Diabetic Kidney Disease: Semaglutide's Impact.</em> Diabetes Care (2025). <a href="https://diabetesjournals.org/care/article/48/11/1875/163610/The-FLOW-of-Progress-in-Diabetic-Kidney-Disease" target="_blank" rel="noopener noreferrer">diabetesjournals.org</a></li>
  <li><em>Kidney and Survival Outcomes with Semaglutide by CKD Severity Strata.</em> CJASN (2026). <a href="https://journals.lww.com/cjasn/fulltext/2026/05000/kidney_and_survival_outcomes_with_semaglutide_by.15.aspx" target="_blank" rel="noopener noreferrer">journals.lww.com</a></li>
  <li><em>SGLT2 Inhibitors vs GLP-1 Receptor Agonists for Kidney Outcomes.</em> JAMA Internal Medicine. <a href="https://jamanetwork.com/journals/jamainternalmedicine/article-abstract/2843983" target="_blank" rel="noopener noreferrer">jamanetwork.com</a></li>
  <li><em>SGLT2 Inhibitors and GLP-1 Receptor Agonists in Diabetic Kidney Disease.</em> PMC (2025). <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12086580/" target="_blank" rel="noopener noreferrer">pmc.ncbi.nlm.nih.gov</a></li>
  <li><em>Finerenone versus spironolactone in patients with CKD and Type 2 Diabetes: a target trial emulation.</em> Nature Communications (2025). <a href="https://www.nature.com/articles/s41467-025-64640-3" target="_blank" rel="noopener noreferrer">nature.com</a></li>
  <li><em>Finerenone and Clinical Outcomes in CKD and Type 2 Diabetes.</em> CJASN (2025). <a href="https://journals.lww.com/cjasn/fulltext/2025/07000/finerenone_and_clinical_outcomes_in_ckd_and_type_2.11.aspx" target="_blank" rel="noopener noreferrer">journals.lww.com</a></li>
  <li><em>ADA Standards of Care 2025 – Chapter 11: Chronic Kidney Disease and Risk Management.</em> Diabetes Care. <a href="https://diabetesjournals.org/care/article/49/Supplement_1/S246/163914/11-Chronic-Kidney-Disease-and-Risk-Management" target="_blank" rel="noopener noreferrer">diabetesjournals.org</a></li>
  <li><em>6 New Kidney Disease Medications Approved in 2025.</em> National Kidney Foundation. <a href="https://www.kidney.org/news-stories/6-new-kidney-disease-medications-approved-2025" target="_blank" rel="noopener noreferrer">kidney.org</a></li>
  <li><em>2025 Advancements in Kidney Disease Research and Treatment.</em> American Kidney Fund. <a href="https://www.kidneyfund.org/article/2025-advancements-kidney-disease-research-and-treatment" target="_blank" rel="noopener noreferrer">kidneyfund.org</a></li>
</ol>

<hr>

<p><em>Tento text má informatívny charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani odbornú konzultáciu.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
        // Newsletter avíza posielame LEN pri novom článku (rc === 1), nikdy pri update.
        $rc = $stmt->rowCount();
        if ($rc === 1) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } elseif ($rc === 2) {
            $updated++;
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
