<?php
// Odborný článok. Publikovanie bez automatických avíz podľa pokynu používateľa.
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
    'title'        => 'Fibrilácia predsiení pri CKD: kontrola rytmu a hranice antikoagulácie',                    // ← VYPLNIŤ: napr. 'Hyperurikémia a CKD: nové odporúčania'
    'slug'         => 'fibrilacia-predsieni-ckd-liecba',                    // ← VYPLNIŤ: napr. 'hyperurikemia-ckd-nove-odporucania'
    'author'       => 'MUDr. Ľubomír Polaščín',  // autor projektu; pôvodných autorov zdroja pridaj do source_authors.php (slug → mená)
    'published_at' => date('Y-m-d H:i:s'),   // ← dátum + čas zverejnenia (upraviť ak treba)
    'is_top'       => 0,                     // ← 1 ak má byť featured
    'excerpt'      => 'Pri pokročilej CKD rastie riziko tromboembólie aj krvácania. Čo hovoria odporúčania a randomizované štúdie o kontrole rytmu, antikoagulácii a jej alternatívach?',                    // ← VYPLNIŤ: 1–2 vety, čistý text
    'content'      => <<<'HTML'
<figure><a href="img/fibrilacia-predsieni-ckd-liecba.webp" target="_blank" rel="noopener noreferrer"><img src="img/fibrilacia-predsieni-ckd-liecba.webp" alt="Poloschematické srdce s nepravidelnou elektrickou aktivitou predsiení nad dvojicou obličiek" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna vytvorená s podporou umelej inteligencie. Nejde o snímku pacienta ani o diagnostický záznam elektrickej aktivity srdca.</figcaption></figure>
<p>Pri fibrilácii predsiení a chronickej chorobe obličiek (CKD) treba súčasne riešiť príznaky arytmie, prevenciu ischemickej cievnej mozgovej príhody a riziko krvácania. V pokročilých štádiách CKD sa tieto ciele dostávajú do napätia. Samotná vysoká pravdepodobnosť tromboembólie ešte neurčuje, či konkrétny pacient získa z dlhodobej antikoagulácie viac, než stratí jej komplikáciami.</p>
<p>Prehľad Caroline Schneppeovej a spoluautorov v časopise <em>Nephrology Dialysis Transplantation</em> upozorňuje na slabšiu oporu liečebných rozhodnutí pri CKD G4 až G5, najmä pri hemodialýze. Ide o prehľad liečby, nie o novú randomizovanú štúdiu. Jeho hlavné posolstvo treba čítať spolu s aktuálnymi odporúčaniami a výsledkami jednotlivých klinických skúšaní. [1]</p>
<h2>Štádium CKD mení istotu rozhodnutia</h2>
<p>KDIGO 2024 odporúča pri fibrilácii predsiení a CKD G1 až G4 uprednostniť priame perorálne antikoagulanciá (DOAC) pred antagonistami vitamínu K. Odporúčanie má silu 1C a sprevádza ho požiadavka upraviť dávku podľa funkcie obličiek a zvýšiť opatrnosť pri G4 až G5. Preferencia jedného typu liečby preto neznamená rovnako presvedčivé dôkazy v každom štádiu CKD. [2]</p>
<p>Odporúčania ESC a ERA z roku 2026 rozlišujú tri situácie: pri eGFR ≥30 ml/min/1,73 m² preferujú DOAC; pri eGFR 15 až 29 ml/min/1,73 m² odporúčajú zvážiť prednostne perorálny inhibítor faktora Xa; pri eGFR &lt;15 ml/min/1,73 m² vrátane dialýzy zdôrazňujú individuálne rozhodovanie. Pri poslednej skupine majú návrhy konkrétnej antikoagulačnej liečby iba slabšiu oporu. Tieto odporúčania nemožno zamieňať s registračnými podmienkami liekov. [3]</p>
<p>Nové odporúčania zároveň neodporúčajú používať bežné skóre ischemickej cievnej mozgovej príhody ani krvácania pri eGFR &lt;30 ml/min/1,73 m² pre ich nedostatočnú predikčnú schopnosť. Pacient patrí do skupiny s vysokým rizikom oboch komplikácií, ale samotný výsledok skóre nenahrádza posúdenie jeho klinického stavu. [3]</p>
<h2>Kontrola frekvencie a udržanie sínusového rytmu</h2>
<p>Voľba lieku na kontrolu komorovej frekvencie závisí od systolickej funkcie ľavej komory, príznakov, krvného tlaku a liekových interakcií. Odporúčania ESC 2024 uvádzajú betablokátory a digoxín; verapamil alebo diltiazem prichádzajú do úvahy pri ejekčnej frakcii ľavej komory nad 40 %. Pri kombináciách treba predchádzať bradykardii. Digoxín si pri CKD vyžaduje úpravu dávkovania a podľa klinickej situácie kontrolu koncentrácie. Amiodarón má závažné možné mimokardiálne nežiaduce účinky a početné interakcie. [4]</p>
<p>Pri pokročilej CKD je po kardioverzii alebo katétrovej ablácii vyššia pravdepodobnosť recidívy fibrilácie predsiení. [1] Neznamená to automatické vylúčenie kontroly rytmu. ESC a ERA odporúčajú zvážiť abláciu u pacientov liečených náhradou funkcie obličiek, ak fibrilácia predsiení vyvoláva hemodynamickú nestabilitu počas dialýzy. Cieľom je aj zlepšenie tolerancie dialyzačnej liečby. [3]</p>
<p>Obnovenie sínusového rytmu samo osebe neruší potrebu posúdiť tromboembolické riziko. Rozhodnutie o dlhodobej antikoagulácii sa podľa ESC 2024 nemá odvíjať iba od zdanlivého úspechu kontroly rytmu. [4]</p>
<h2>Dávkovanie: eGFR a klírens kreatinínu nie sú zameniteľné</h2>
<p>Stupne CKD sa určujú podľa glomerulovej filtrácie indexovanej na telesný povrch 1,73 m². Registračné podmienky konkrétneho antikoagulancia však môžu pracovať s klírensom kreatinínu v ml/min a s ďalšími kritériami. Pri predpisovaní treba použiť parameter uvedený v súhrne charakteristických vlastností lieku (SPC), nie mechanicky prevziať kategóriu CKD. [2,5]</p>
<p>Praktickým príkladom je apixabán. Európske SPC pri nevalvulárnej fibrilácii predsiení a klírense kreatinínu 15 až 29 ml/min uvádza 2,5 mg dvakrát denne. Pri klírense &lt;15 ml/min alebo počas dialýzy jeho použitie neodporúča. [5] Návrh odborného odporúčania zvážiť apixabán v niektorých takýchto situáciách teda neznamená rozšírenie registrácie. Ide o rozdiel, ktorý musí byť pri individuálnom rozhodovaní výslovne rozpoznaný. Dávku použitú v klinickej štúdii nemožno automaticky premeniť na bežný predpis pre slovenskú prax.</p>
<h2>Čo skutočne ukázali randomizované štúdie pri dialýze</h2>
<p>RENAL-AF porovnávala apixabán s warfarínom u 154 hemodialyzovaných pacientov s fibriláciou predsiení. Nábor sa predčasne skončil a štúdia nemala dostatočnú štatistickú silu na spoľahlivé porovnanie krvácavých výsledkov. Ročný výskyt závažného alebo klinicky relevantného nezávažného krvácania bol 32 % pri apixabáne a 26 % pri warfaríne, pomer rizík v čase (HR) 1,20; 95 % interval spoľahlivosti 0,63 až 2,30. Ročný výskyt cievnej mozgovej príhody alebo systémovej embólie bol 3,0 % a 3,3 %. [6]</p>
<p>Údaj 32 % preto nemožno označiť za výskyt samotného závažného krvácania. Rovnako nemožno z podobných percent tromboembolických príhod vyvodiť rovnocennosť liekov. Warfarínová skupina strávila v terapeutickom rozmedzí INR iba 44 % času, čo ďalej obmedzuje interpretáciu porovnania. [6]</p>
<p>AXADIA-AFNET 8 randomizovala 97 hemodialyzovaných pacientov na apixabán alebo fenprokumón. Primárny bezpečnostný ukazovateľ spájal závažné krvácanie, klinicky relevantné nezávažné krvácanie a úmrtie z akejkoľvek príčiny. Vyskytol sa u 45,8 % a 51,0 % pacientov; HR bol 0,93 s 95 % intervalom spoľahlivosti 0,53 až 1,65. Stanovené kritérium noninferiority sa nesplnilo, p = 0,157. Nezistenie štatisticky významného rozdielu nie je dôkazom rovnocennej bezpečnosti. [7]</p>
<p>Obe skúšania porovnávali dve antikoagulačné stratégie. Neodpovedajú priamo na otázku, či je u konkrétneho dialyzovaného pacienta antikoagulácia lepšia než jej nepodávanie.</p>
<p>Pilotná štúdia SAFE-D už zahŕňala aj skupinu bez perorálnej antikoagulácie: 151 pacientov bolo rozdelených na apixabán, warfarín alebo nepodávanie antikoagulancia a sledovaných 26 týždňov. Hlavným cieľom bolo overiť uskutočniteľnosť väčšej štúdie. Vyskytla sa jedna posúdená cievna mozgová príhoda a osem závažných krvácaní. Takýto počet udalostí neumožňuje určiť najúčinnejšiu stratégiu; práca podporuje uskutočniteľnosť definitívneho skúšania, nie víťazstvo niektorej liečby. [8]</p>
<h2>Inhibítory faktora XI a uzáver uška ľavej predsiene</h2>
<p>Menšie riziko krvácania má význam iba vtedy, ak sa zachová dostatočná ochrana pred tromboembóliou. V štúdii OCEANIC-AF s 14 810 pacientmi viedol asundexián k častejšej cievnej mozgovej príhode alebo systémovej embólii než apixabán: 1,3 % oproti 0,4 %, HR 3,79; 95 % interval spoľahlivosti 2,46 až 5,83. Závažné krvácanie bolo menej časté, ale štúdia sa predčasne skončila. Výsledok sa týka konkrétneho inhibítora faktora XIa a skúmanej dávky; nie je definitívnym rozsudkom nad celou liekovou skupinou ani dôkazom účinnosti pri dialýze. [9]</p>
<p>Ani katétrový uzáver uška ľavej predsiene nemožno predstavovať ako všeobecne bezpečnejšiu náhradu liekov. CLOSURE-AF randomizovala 912 pacientov s vysokým rizikom cievnej mozgovej príhody aj krvácania. Pri mediáne sledovania tri roky nepreukázala noninferioritu uzáveru voči najlepšej medikamentóznej starostlivosti určenej lekárom pre kombináciu cievnej mozgovej príhody, systémovej embólie, závažného krvácania a kardiovaskulárneho alebo nevysvetleného úmrtia. [10] To nevylučuje individuálnu indikáciu výkonu, ale neposkytuje podklad na jeho plošné uprednostňovanie u dialyzovaných pacientov. Táto štúdia nebola osobitným randomizovaným skúšaním dialyzačnej populácie.</p>
<h2>Rozhodnutie pri lôžku pacienta</h2>
<p>Z uvedených dôkazov vyplýva potreba oddeliť dve otázky: či antikoagulovať a ktorý liek následne zvoliť. Pri pokročilej CKD má rozhodnutie zachytiť predchádzajúcu tromboembóliu, prekonané krvácanie, súbežnú liečbu, aktuálnu funkciu obličiek, možnosti sledovania aj preferencie pacienta. Ide o klinickú syntézu dostupných dôkazov, nie o nový validovaný rozhodovací algoritmus.</p>
<p>Neistota pri dialýze neoprávňuje k plošnému vysadeniu antikoagulácie. Rovnako neoprávňuje k jej automatickému nasadeniu iba podľa diagnózy fibrilácie predsiení. Rozhodnutie treba priebežne prehodnocovať, najmä po krvácaní, tromboembolickej príhode alebo podstatnej zmene klinického stavu.</p>
<h2>Rozsah a obmedzenia dôkazov</h2>
<p>Východiskový prehľad bol overený podľa úplného abstraktu a bibliografických údajov; jeho plný text nebol dostupný. Článok preto nie je úplným referátom všetkých jeho častí. Hlavné odporúčania sú doplnené z KDIGO, ESC a európskeho SPC; výsledky uvedených skúšaní sú overené podľa ich pôvodných publikačných abstraktov. Úplné protokoly a suplementy všetkých štúdií neboli posúdené. Malé dialyzačné skúšania, rozdielne kombinované ukazovatele a odlišné porovnávacie stratégie obmedzujú istotu záverov.</p>
<hr>
<p><small><em>Text je určený zdravotníckym pracovníkom. Výber lieku a dávky vyžaduje posúdenie konkrétneho pacienta a aktuálneho SPC.</em></small></p>
<h2>Literatúra</h2>
<ol>
<li id="ref-1"><small><em>Caroline Schneppe, Gunnar H Heine, Ingo Eitel, Marie Evans, Lukas Urbanek, Wolfgang Winkelmayer, An S De Vriese. Atrial fibrillation in chronic kidney disease - treatment standard. Nephrol Dial Transplant. 2026;gfag263. Publikované online 13. novembra 2026. <a href="https://doi.org/10.1093/ndt/gfag263" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ndt/gfag263, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/43024348/" target="_blank" rel="noopener noreferrer">PubMed: 43024348</a>.</em></small></li>
<li id="ref-2"><small><em>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117-S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.kint.2023.10.018, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed: 38490803</a>.</em></small></li>
<li id="ref-3"><small><em>Kevin Damman, Jozine M Ter Maaten, Kaitlin J Mayne, Davide Bolignano, Elizabeth M Brown, Bruno R da Costa, Anna Dagre, Ron T Gansevoort, Cristina Gavina, Andreas Goette, Diana A Gorog, Nina Nikolova Gotcheva, Marta Kaluzna-Oleksy, Dearbhla M Kelly, Oleksii Korzh, Jennifer S Lees, Olivia Manfrini, Pieter Martens, Julio Nunez, Eugenio Stabile, Isabella Sudano, Marieta P Theodorakopoulou, Simon Winther, William G Herrington, ESC Guidelines Advisory Group. 2026 ESC Guidelines for the management of cardiovascular disease and chronic kidney disease, in collaboration with the European Renal Association (ERA). Eur Heart J. 2026. <a href="https://doi.org/10.1093/eurheartj/ehag098" target="_blank" rel="noopener noreferrer">DOI: 10.1093/eurheartj/ehag098, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42661426/" target="_blank" rel="noopener noreferrer">PubMed: 42661426</a>.</em></small></li>
<li id="ref-4"><small><em>Isabelle C Van Gelder, Michiel Rienstra, Karina V Bunting, Ruben Casado-Arroyo, Valeria Caso, Harry J G M Crijns, Tom J R De Potter, Jeremy Dwight, Luigina Guasti, Thorsten Hanke, Tiny Jaarsma, Maddalena Lettino, Maja-Lisa Løchen, R Thomas Lumbers, Bart Maesen, Inge Mølgaard, Giuseppe M C Rosano, Prashanthan Sanders, Renate B Schnabel, Piotr Suwalski, Emma Svennberg, Juan Tamargo, Otilia Tica, Vassil Traykov, Stylianos Tzeis, Dipak Kotecha, ESC Scientific Document Group. 2024 ESC Guidelines for the management of atrial fibrillation developed in collaboration with the European Association for Cardio-Thoracic Surgery (EACTS). Eur Heart J. 2024;45(36):3314-3414. <a href="https://doi.org/10.1093/eurheartj/ehae176" target="_blank" rel="noopener noreferrer">DOI: 10.1093/eurheartj/ehae176, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39210723/" target="_blank" rel="noopener noreferrer">PubMed: 39210723</a>.</em></small></li>
<li id="ref-5"><small><em>European Medicines Agency. Eliquis: súhrn charakteristických vlastností lieku, časti 4.2 a 4.4. Overené 17. novembra 2026. <a href="https://www.ema.europa.eu/en/documents/product-information/eliquis-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">EMA, informácie o lieku</a>. Dokument nemá DOI ani PMID.</em></small></li>
<li id="ref-6"><small><em>Sean D Pokorney, Glenn M Chertow, Hussein R Al-Khalidi, Dianne Gallup, Pat Dignacco, Kurt Mussina, Nisha Bansal, Crystal A Gadegbeku, David A Garcia, Samira Garonzik, Renato D Lopes, Kenneth W Mahaffey, Kelly Matsuda, John P Middleton, Jennifer A Rymer, George H Sands, Ravi Thadhani, Kevin L Thomas, Jeffrey B Washam, Wolfgang C Winkelmayer, Christopher B Granger, RENAL-AF Investigators. Apixaban for Patients With Atrial Fibrillation on Hemodialysis: A Multicenter Randomized Controlled Trial. Circulation. 2022;146(23):1735-1745. <a href="https://doi.org/10.1161/CIRCULATIONAHA.121.054990" target="_blank" rel="noopener noreferrer">DOI: 10.1161/CIRCULATIONAHA.121.054990, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36335914/" target="_blank" rel="noopener noreferrer">PubMed: 36335914</a>.</em></small></li>
<li id="ref-7"><small><em>Holger Reinecke, Christiane Engelbertz, Rupert Bauersachs, Günter Breithardt, Hans-Herbert Echterhoff, Joachim Gerß, Karl Georg Haeusler, Bernd Hewing, Joachim Hoyer, Sabine Juergensmeyer, Thomas Klingenheben, Guido Knapp, Lars Christian Rump, Hans Schmidt-Guertler, Christoph Wanner, Paulus Kirchhof, Dennis Goerlich. A Randomized Controlled Trial Comparing Apixaban With the Vitamin K Antagonist Phenprocoumon in Patients on Chronic Hemodialysis: The AXADIA-AFNET 8 Study. Circulation. 2023;147(4):296-309. <a href="https://doi.org/10.1161/CIRCULATIONAHA.122.062779" target="_blank" rel="noopener noreferrer">DOI: 10.1161/CIRCULATIONAHA.122.062779, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36335915/" target="_blank" rel="noopener noreferrer">PubMed: 36335915</a>.</em></small></li>
<li id="ref-8"><small><em>Ziv Harel, Brendan Smyth, Sunil V Badve, Daniel Blum, William Beaubien-Souligny, Samuel A Silver, Edward Clark, Rita Suri, Thomas A Mavrakanas, Joanna Sasal, Bhanu Prasad, John Eikelboom, Karthik Tennankore, Claudio Rigatto, Ivana Prce, Francois Madore, Fabrice Mac-Way, Andrew Steele, Yangmin Zeng, Michelle Sholzberg, Paul Dorian, Andrew T Yan, Manish M Sood, David J Gladstone, Eric Tseng, Abhijat Kitchlu, Michael Walsh, Danny Sapir, Matthew J Oliver, Murali Krishnan, Mercedeh Kiaii, Nikki Wong, Sradha Kotwal, Marisa Battistella, Rey Acedillo, Charmaine Lok, Matthew Weir, Ron Wald. Anticoagulation for Patients with Atrial Fibrillation Receiving Dialysis: A Pilot Randomized Controlled Trial. J Am Soc Nephrol. 2025;36(5):901-910. <a href="https://doi.org/10.1681/ASN.0000000000000495" target="_blank" rel="noopener noreferrer">DOI: 10.1681/ASN.0000000000000495, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39495569/" target="_blank" rel="noopener noreferrer">PubMed: 39495569</a>.</em></small></li>
<li id="ref-9"><small><em>Jonathan P Piccini, Manesh R Patel, Jan Steffel, Keith Ferdinand, Isabelle C Van Gelder, Andrea M Russo, Chang-Sheng Ma, Shaun G Goodman, Jonas Oldgren, Christopher Hammett, Renato D Lopes, Masaharu Akao, Raffaele De Caterina, Paulus Kirchhof, Diana A Gorog, Martin Hemels, Michiel Rienstra, W Schuyler Jones, Josephine Harrington, Gregory Y H Lip, Stephen J Ellis, Frank W Rockhold, Christoph Neumann, John H Alexander, Thomas Viethen, James Hung, Rosa Coppolecchia, Hardi Mundl, Valeria Caso, OCEANIC-AF Steering Committee and Investigators. Asundexian versus Apixaban in Patients with Atrial Fibrillation. N Engl J Med. 2025;392(1):23-32. <a href="https://doi.org/10.1056/NEJMoa2407105" target="_blank" rel="noopener noreferrer">DOI: 10.1056/NEJMoa2407105, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39225267/" target="_blank" rel="noopener noreferrer">PubMed: 39225267</a>.</em></small></li>
<li id="ref-10"><small><em>Ulf Landmesser, Carsten Skurk, Paulus Kirchhof, Thorsten Lewalter, Johannes Hartung, Andi Rroku, Burkert Pieske, Johannes Brachmann, Ibrahim Akin, Claudius Jacobshagen, Benjamin Meder, Andreas Zeiher, Stefan D Anker, Holger Thiele, Stefan Blankenberg, Steffen Massberg, Heribert Schunkert, Norbert Frey, Alexander Joost, Martin Bergmann, Ralph Stephan von Bardeleben, Tim Friede, Marius Placzek, Anna Suling, Karl Georg Haeusler, Matthias Endres, Karl Wegscheider, Leif-Hendrik Boldt, Ingo Eitel, CLOSURE-AF Trial Investigators. Left Atrial Appendage Closure or Medical Therapy in Atrial Fibrillation. N Engl J Med. 2026;394(13):1270-1280. <a href="https://doi.org/10.1056/NEJMoa2513310" target="_blank" rel="noopener noreferrer">DOI: 10.1056/NEJMoa2513310, vydavateľ</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41849741/" target="_blank" rel="noopener noreferrer">PubMed: 41849741</a>.</em></small></li>
</ol>
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
    'log_prefix' => 'add_fibrilacia-predsieni-ckd-liecba_article',
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
