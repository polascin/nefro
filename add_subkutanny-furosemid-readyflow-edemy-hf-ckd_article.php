<?php

/**
 * add_subkutanny-furosemid-readyflow-edemy-hf-ckd_article.php
 * Odborný článok o autoinjektore Furoscix ReadyFlow a limitoch domácej dekongesčnej liečby.
 */

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
    'title'        => 'Subkutánny furosemid v autoinjektore: možnosti a limity domácej liečby edémov pri srdcovom zlyhávaní a CKD',
    'slug'         => 'subkutanny-furosemid-readyflow-edemy-hf-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Furoscix ReadyFlow podá dospelému 80 mg furosemidu podkožne približne za 10 sekúnd. Článok vysvetľuje význam „intravenózne ekvivalentnej“ expozície, hranice dôkazov a bezpečný výber pacienta.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Americký FDA v júli 2026 schválil autoinjektor Furoscix ReadyFlow, ktorý dospelému podá 80 mg furosemidu podkožne približne za desať sekúnd. Zariadenie môže vybraným stabilným pacientom rozšíriť možnosti včasnej ambulantnej dekongesčnej liečby. Nie je však náhradou urgentnej intravenóznej liečby a zatiaľ nemáme dôkaz, že znižuje hospitalizácie alebo mortalitu.</em></p>

<p>Pri chronickom srdcovom zlyhávaní a chronickej chorobe obličiek (CKD) býva kontrola objemového preťaženia náročná. Perorálny furosemid má variabilnú biologickú dostupnosť a pri zhoršení kongescie môže jeho účinok slabnúť. Parenterálne podanie preto často znamená návštevu ambulancie urgentného príjmu alebo hospitalizáciu.</p>

<p>Furoscix ReadyFlow obchádza gastrointestinálnu absorpciu bez potreby intravenózneho prístupu. Technická jednoduchosť však nesmie prekryť klinickú otázku: <strong>ktorý pacient je ešte vhodný na vopred naplánovanú domácu liečbu a ktorý už potrebuje bezodkladné nemocničné vyšetrenie?</strong></p>

<h2>Čo sa v júli 2026 zmenilo</h2>

<p>Furoscix je v USA schválený liek s obsahom furosemidu na subkutánne podanie. Pre dospelých ho aktuálna americká registračná informácia indikuje na liečbu edémov pri chronickom srdcovom zlyhávaní alebo CKD vrátane nefrotického syndrómu. V júli 2026 pribudla nová lieková forma <strong>ReadyFlow</strong>:</p>

<ul>
  <li>jednorazový mechanický pružinový autoinjektor,</li>
  <li>80 mg furosemidu v 1 ml roztoku,</li>
  <li>podanie do podkožia brucha približne za 10 sekúnd,</li>
  <li>určenie iba pre dospelých,</li>
  <li>aplikácia po predchádzajúcom zaškolení zdravotníkom.</li>
</ul>

<p>Furoscix podľa registračnej informácie <strong>nie je určený na chronické používanie</strong> a čo najskôr sa má nahradiť perorálnym diuretikom. Ide teda o liečbu konkrétnej epizódy objemového preťaženia podľa vopred určeného plánu, nie o novú formu pravidelnej udržiavacej dávky.</p>

<p>Miesto aplikácie má byť na bruchu približne najmenej 5 cm od pupka. Miesta treba striedať a vyhnúť sa porušenej či podráždenej koži, jazvám a striám. Autoinjektor sa drží pritlačený, kým sa žltý piest neprestane pohybovať a nevyplní kontrolné okienko.</p>

<div class="pdf-avoid-break">
<h2>Dva systémy pod jedným názvom nie sú totožné</h2>

<div class="table-responsive">
<table>
  <thead>
    <tr>
      <th scope="col">Vlastnosť</th>
      <th scope="col">ReadyFlow</th>
      <th scope="col">On-body Infusor</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Zariadenie</td>
      <td>mechanický autoinjektor</td>
      <td>nalepovací elektromechanický infúzor</td>
    </tr>
    <tr>
      <td>Dávka a objem</td>
      <td>80 mg v 1 ml</td>
      <td>80 mg v 10 ml</td>
    </tr>
    <tr>
      <td>Trvanie podania</td>
      <td>približne 10 sekúnd</td>
      <td>5 hodín: 30 mg v prvej hodine, potom 12,5 mg/h počas 4 hodín</td>
    </tr>
    <tr>
      <td>Americká veková indikácia</td>
      <td>iba dospelí</td>
      <td>dospelí a pediatrickí pacienti s hmotnosťou najmenej 43 kg</td>
    </tr>
  </tbody>
</table>
</div>
</div>

<p>Pediatrické rozšírenie sa teda nevzťahuje na ReadyFlow. Rovnako ani údaje získané s päťhodinovým systémom nemožno bez výhrady vydávať za klinické výsledky desaťsekundového autoinjektora.</p>

<h2>Prečo perorálny furosemid niekedy nestačí</h2>

<p>Furosemid inhibuje kotransportér Na<sup>+</sup>-K<sup>+</sup>-2Cl<sup>−</sup> v hrubom vzostupnom ramienku Henleho slučky. Zvýšením natriurézy a diurézy znižuje extracelulárny objem a kongesciu. Odpoveď na perorálnu liečbu však môžu zhoršiť:</p>

<ul>
  <li>variabilná gastrointestinálna absorpcia a edém črevnej steny,</li>
  <li>venózna kongescia a znížená perfúzia tráviaceho traktu,</li>
  <li>pokles tubulárnej sekrécie lieku pri CKD,</li>
  <li>hypoalbuminémia a nefrotický syndróm,</li>
  <li>vysoký príjem sodíka alebo nedostatočná adherencia,</li>
  <li>nesteroidové protizápalové lieky,</li>
  <li>distálna tubulárna adaptácia pri dlhodobej diuretickej liečbe.</li>
</ul>

<p>Subkutánna cesta odstraňuje neistotu gastrointestinálnej absorpcie, neodstraňuje však diuretickú rezistenciu vznikajúcu pri výrazne zníženej funkcii obličiek, nízkej perfúzii alebo distálnej retencii sodíka. Americká registračná informácia výslovne upozorňuje, že fixná dávka 80 mg nemusí pri významne zníženej renálnej funkcii postačovať.</p>

<h2>Čo presne znamená „intravenózne ekvivalentný“</h2>

<p>Registračné farmakokinetické porovnanie zahŕňalo <strong>19 zdravých dospelých</strong>. Hodnotilo 80 mg furosemidu podaného autoinjektorom oproti celkovej intravenóznej dávke 80 mg, ktorá bola rozdelená do dvoch 40 mg bolusov s odstupom 120 minút.</p>

<ul>
  <li>Relatívna biologická dostupnosť ReadyFlow bola <strong>107,3 %</strong> (90 % interval spoľahlivosti 103,9 až 110,8 %).</li>
  <li>Medián času do maximálnej koncentrácie bol <strong>0,75 hodiny</strong> (rozmedzie 0,5 až 1,5 hodiny).</li>
  <li>Priemerná maximálna koncentrácia dosiahla približne <strong>4 530 ng/ml</strong> po ReadyFlow a <strong>10 100 ng/ml</strong> po porovnávacom intravenóznom režime.</li>
  <li>Diuréza, natriuréza a kaliuréza boli v hodnotených časoch po 6, 8 a 12 hodinách podobné; diuretický účinok ReadyFlow pretrvával do približne 6 hodín od podania.</li>
</ul>

<p>Porovnateľná plocha pod krivkou znamená podobnú <strong>celkovú systémovú expozíciu</strong>. Neznamená identický koncentračný profil, rovnaký nástup účinku ako po jednorazovom intravenóznom boluse ani zameniteľnosť vo všetkých klinických situáciách. Výsledok navyše pochádza zo zdravej populácie, nie z pacientov s anasarkou, pokročilou CKD alebo akútnou dekompenzáciou.</p>

<p>Vplyv podkožného edému v mieste aplikácie na absorpciu nie je podľa oficiálnej registračnej informácie známy. Táto neistota je osobitne dôležitá pri výrazných edémoch a nefrotickom syndróme.</p>

<h2>Nástup diurézy nie je to isté ako úľava od príznakov</h2>

<p>Návod pre pacienta uvádza, že zvýšenú tvorbu moču možno očakávať približne hodinu po injekcii. Z toho nemožno vyvodiť zaručené zmiernenie dyspnoe alebo periférnych edémov v rovnakom čase. Klinická odpoveď závisí od závažnosti a príčiny kongescie, funkcie obličiek, predchádzajúcej dávky diuretika, perfúzie, albuminémie, príjmu sodíka a stupňa diuretickej rezistencie.</p>

<h2>Klinické výsledky: signál uskutočniteľnosti, nie dôkaz lepšej prognózy</h2>

<p>ReadyFlow nebol schválený na základe veľkej randomizovanej štúdie, ktorá by preukázala zníženie hospitalizácií, mortality alebo progresie CKD. Najčastejšie citovaná štúdia <strong>AT HOME-HF</strong> skúmala skoršiu subkutánnu formuláciu podávanú päťhodinovým systémom On-body Infusor.</p>

<p>V otvorenej pilotnej štúdii bolo 51 ambulantných pacientov so srdcovým zlyhávaním a zhoršujúcou sa kongesciou randomizovaných v pomere 2 : 1: 34 dostalo subkutánny furosemid a 17 obvyklú starostlivosť. Rozdiel v priemernej zmene hmotnosti na tretí deň bol −2,02 kg v prospech subkutánnej liečby (95 % interval spoľahlivosti −3,90 až −0,14 kg). Priaznivejšie boli aj niektoré sekundárne hodnotenia dyspnoe a šesťminútového testu chôdze.</p>

<p>Primárny hierarchický kombinovaný ukazovateľ kardiovaskulárneho úmrtia, príhod srdcového zlyhávania a zmeny NT-proBNP však štatisticky významný nebol (pomer víťazstiev 1,11; 95 % interval spoľahlivosti 0,48 až 2,50). Najčastejším nežiaducim účinkom súvisiacim s liečbou bola mierna bolesť v mieste infúzie u 11,8 % pacientov.</p>

<p>Štúdia bola malá, otvorená, financovaná výrobcom a viacerí autori uviedli finančné väzby na spoločnosť alebo v nej pracovali. Podporuje ďalší výskum ambulantnej dekongescie, ale <strong>nedokazuje zníženie hospitalizácií ani mortality a priamo netestovala ReadyFlow</strong>. Ešte menej údajov máme o klinických výsledkoch u pacientov s CKD alebo nefrotickým syndrómom bez súčasného srdcového zlyhávania.</p>

<h2>Ktorý pacient by mohol byť vhodný</h2>

<p>Autoinjektor dáva klinický zmysel iba ako súčasť <strong>vopred pripraveného dekongesčného protokolu</strong>. Uvažovať o ňom možno pri dospelom pacientovi, ktorý:</p>

<ul>
  <li>má známu diagnózu chronického srdcového zlyhávania alebo CKD s edémami,</li>
  <li>má skoré, jasne definované známky zhoršujúcej sa kongescie,</li>
  <li>je hemodynamicky stabilný a nemá závažnú dyspnoe v pokoji ani hypoxémiu,</li>
  <li>má vopred určené, kedy dávku použiť a kedy kontaktovať zdravotníka,</li>
  <li>dokáže zariadenie správne použiť alebo má zaškoleného opatrovateľa,</li>
  <li>má prístup k toalete, dokáže sledovať hmotnosť, tlak a diurézu,</li>
  <li>má zabezpečenú následnú klinickú a laboratórnu kontrolu.</li>
</ul>

<p>Tento výberový rámec je klinickou bezpečnostnou interpretáciou, nie univerzálnym algoritmom z registračnej dokumentácie. Konkrétny plán musí vychádzať z predchádzajúcej diuretickej odpovede, renálnej funkcie, krvného tlaku, elektrolytov a súbežnej liečby.</p>

<h2>Kedy domáca injekcia nesmie oddialiť urgentné vyšetrenie</h2>

<p>Furoscix nie je skúmanou náhradou emergentnej intravenóznej liečby pri akútnom pľúcnom edéme alebo obehovej nestabilite. Domáce podanie nesmie oddialiť urgentnú starostlivosť najmä pri:</p>

<ul>
  <li>závažnej alebo rýchlo progredujúcej dyspnoe, hypoxémii či cyanóze,</li>
  <li>bolesti na hrudníku, synkope, zmätenosti alebo novej významnej arytmii,</li>
  <li>symptomatickej hypotenzii, známkach šoku alebo srdcového zlyhávania s nízkym výdajom,</li>
  <li>anúrii, závažnej oligúrii alebo podozrení na akútne poškodenie obličiek,</li>
  <li>závažnej poruche elektrolytov, progresívnej azotémii alebo klinickej hypovolémii,</li>
  <li>podozrení na infekciu, akútny koronárny syndróm alebo inú vyvolávajúcu príčinu dekompenzácie,</li>
  <li>nemožnosti zabezpečiť klinické a laboratórne sledovanie.</li>
</ul>

<h2>Riziká dôležité pre nefrologickú prax</h2>

<h3>Objemová deplécia a zhoršenie renálnej funkcie</h3>

<p>Furosemid môže spôsobiť hypovolémiu, hypotenziu a azotémiu. Mierny vzostup kreatinínu počas účinnej dekongescie nemusí automaticky znamenať štruktúrne poškodenie obličiek, treba ho však čítať spolu s tlakom, diurézou, klinickým objemovým stavom a trendom laboratórnych hodnôt. Pri narastajúcej azotémii a oligúrii počas liečby ťažkého progresívneho ochorenia obličiek americká registračná informácia odporúča furosemid vysadiť.</p>

<h3>Elektrolytové a metabolické poruchy</h3>

<p>Možné sú hypokaliémia, hyponatriémia, hypomagneziémia, hypokalciémia, hypochloremická metabolická alkalóza, hyperurikémia a hyperglykémia. Riziko rastie pri vyššej celkovej diuretickej záťaži, nízkom príjme elektrolytov, pokročilom veku a pri sekvenčnej blokáde nefrónu.</p>

<h3>Retencia moču, ototoxicita a lokálne reakcie</h3>

<p>Prudké zvýšenie diurézy môže vyvolať akútnu retenciu pri poruche vyprázdňovania močového mechúra, napríklad pri významnej hyperplázii prostaty alebo striktúre uretry. Ototoxicita furosemidu sa spája najmä s rýchlym intravenóznym podaním, vysokými dávkami, ťažkou renálnou insuficienciou, hypoproteinémiou a kombináciou s aminoglykozidmi, kyselinou etakrynovou alebo inými ototoxickými liekmi. Nižšia maximálna koncentrácia po ReadyFlow môže byť farmakologicky zaujímavá, klinicky významné zníženie ototoxicity však preukázané nebolo.</p>

<p>V mieste aplikácie sa môžu objaviť erytém, bolesť, svrbenie, opuch, podliatina alebo zatvrdnutie.</p>

<h3>Kontraindikácie a interakcie</h3>

<p>Furoscix je kontraindikovaný pri anúrii a pri precitlivenosti na furosemid alebo zložku prípravku. Precitlivenosť na medicínske lepidlá je kontraindikáciou systému On-body Infusor, nie mechanického autoinjektora ReadyFlow.</p>

<p>Osobitnú pozornosť vyžadujú nesteroidové protizápalové lieky, lítium, aminoglykozidy, kyselina etakrynová, cisplatina a ďalšie nefrotoxické alebo ototoxické lieky. Inhibítory ACE, sartany a iné antihypertenzíva môžu pri intenzívnej diuréze zvyšovať riziko hypotenzie a zhoršenia renálnej funkcie. Úpravy súbežnej liečby majú byť súčasťou individuálneho plánu, nie improvizovaným rozhodnutím pacienta.</p>

<h2>Čo sledovať po ambulantnom podaní</h2>

<p>Jednotný interval kontroly neexistuje. Má sa prispôsobiť štádiu CKD, východiskovým elektrolytom, tlaku, veku, súbežným liekom a predchádzajúcej odpovedi. Praktický protokol by mal zahŕňať:</p>

<ul>
  <li>hmotnosť, dyspnoe, edémy a ortostatické príznaky,</li>
  <li>krvný tlak, srdcovú frekvenciu a diurézu,</li>
  <li>kreatinín, močovinu, sodík, draslík, chloridy a hydrogénuhličitan,</li>
  <li>podľa rizika aj horčík, glukózu a kyselinu močovú,</li>
  <li>miesto aplikácie a úplnosť podanej dávky.</li>
</ul>

<p>Pri vysoko rizikovom pacientovi môže byť rozumná laboratórna kontrola v priebehu 24 až 72 hodín. Ide o klinický bezpečnostný návrh, nie o univerzálny interval určený americkou registračnou informáciou.</p>

<h2>Regulačný kontext pre Slovensko</h2>

<p>Schválenie FDA platí pre Spojené štáty. Automaticky neznamená registráciu, dostupnosť ani úhradu v Európskej únii alebo na Slovensku. Americká registračná informácia zároveň nie je slovenským súhrnom charakteristických vlastností lieku.</p>

<p>Pred prípadným klinickým použitím by bolo potrebné overiť aktuálny stav v databázach Európskej liekovej agentúry a Štátneho ústavu pre kontrolu liečiv, platné podmienky výdaja, dostupnosť liekovej formy a organizačné pravidlá domáceho parenterálneho podania. Ani individuálny dovoz nesmie obísť medicínske a právne podmienky bezpečnej liečby.</p>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Furoscix ReadyFlow je prakticky významnou inováciou: podá 80 mg furosemidu podkožne približne za desať sekúnd a obíde variabilnú gastrointestinálnu absorpciu. Pre vybraného stabilného dospelého môže byť súčasťou vopred pripraveného ambulantného dekongesčného protokolu.</p>

<p>Výraz „intravenózne ekvivalentný“ však treba obmedziť na porovnateľnú celkovú expozíciu a podobnú diuretickú odpoveď voči konkrétnemu režimu dvoch 40 mg intravenóznych bolusov. Neznamená identickú farmakokinetiku, preukázanú účinnosť pri urgentnej dekompenzácii ani dokázané zníženie hospitalizácií alebo mortality.</p>

<p>Najväčšie neistoty sa týkajú klinických výsledkov pri samotnej CKD a nefrotickom syndróme, pacientov s výrazným podkožným edémom a situácií, keď fixná dávka 80 mg pri pokročilej renálnej dysfunkcii nestačí. Rozhodujúce preto zostávajú výber pacienta, jasné hranice pre urgentné vyšetrenie a rýchlo dostupné klinické i laboratórne monitorovanie.</p>
</div>

<div class="pdf-avoid-break">
<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=cheatsheet-diuretika">Diuretiká v nefrologickej praxi</a> – mechanizmy, ekvivalentné dávky a prístup k diuretickej rezistencii.</li>
  <li><a href="article.php?slug=oblicka-v-centre-ckm-syndromu-kdigo">Oblička v centre kardiovaskulárno-obličkovo-metabolického syndrómu</a> – spoločný manažment CKD a srdcového zlyhávania.</li>
  <li><a href="article.php?slug=ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register">CKD a vznik srdcového zlyhávania</a> – prečo je väzba osobitne silná pri HFpEF.</li>
</ul>
</div>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Lois Anzelowitz Levine.</strong> <em>Newly Approved IV-Equivalent Autoinjector Offers Fast At-Home Diuresis.</em> Medscape. 2026. <a href="https://www.medscape.com/viewarticle/newly-approved-iv-equivalent-autoinjector-offers-fast-home-2026a1000qgl" target="_blank" rel="noopener noreferrer">Východiskový odborný článok</a>.</li>
  <li><strong>MannKind Corporation.</strong> <em>FUROSCIX (furosemide injection): Full Prescribing Information.</em> DailyMed; revízia júl 2026. <a href="https://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?setid=eac958dd-8d43-e44e-e053-2995a90a4d5e" target="_blank" rel="noopener noreferrer">Aktuálna americká registračná informácia</a>.</li>
  <li><strong>U.S. Food and Drug Administration.</strong> <em>NDA 209988/S-003 Supplement Approval.</em> Rozšírenie indikácie o edémy pri CKD vrátane nefrotického syndrómu; 2025. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/appletter/2025/209988Orig1s003ltr.pdf" target="_blank" rel="noopener noreferrer">Rozhodnutie FDA</a>.</li>
  <li><strong>Konstam MA, Massaro J, Dhingra R, et al.</strong> <em>Avoiding Treatment in Hospital With Subcutaneous Furosemide for Worsening Heart Failure: A Pilot Study (AT HOME-HF).</em> JACC Heart Fail. 2024;12(11):1830–1841. doi: 10.1016/j.jchf.2024.07.015. <a href="https://pubmed.ncbi.nlm.nih.gov/39269392/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>MannKind Corporation.</strong> <em>MannKind Announces FDA Approval of Furoscix ReadyFlow.</em> Tlačová správa, 24. júla 2026. <a href="https://investors.mannkindcorp.com/node/21501" target="_blank" rel="noopener noreferrer">Oznámenie výrobcu</a>.</li>
  <li><strong>European Medicines Agency; Štátny ústav pre kontrolu liečiv.</strong> Databázy liekov na overenie aktuálneho európskeho a slovenského registračného stavu. <a href="https://www.ema.europa.eu/en/medicines" target="_blank" rel="noopener noreferrer">EMA Medicine Finder</a>; <a href="https://www.sukl.sk/pre-verejnost-pacientov-a-media/sluzby-pre-verejnost/vyhladavanie-liekov-zdravotnickych-pomocok-a-zmien-v-liekovej-databaze" target="_blank" rel="noopener noreferrer">databáza ŠÚKL</a>.</li>
</ol>
</div>

<p><em><strong>Poznámka k interpretácii:</strong> Americké schválenie a registračná informácia boli overené 14. augusta 2026; európsku a slovenskú registráciu i dostupnosť treba pred použitím overiť v aktuálnych oficiálnych databázach. Údaje o ReadyFlow pochádzajú najmä z farmakokinetického a farmakodynamického porovnania u zdravých dospelých. Štúdia AT HOME-HF hodnotila starší päťhodinový systém, bola pilotná a financovaná výrobcom; jej výsledky nemožno preniesť na dôkaz prognostického prínosu nového autoinjektora.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_subkutanny-furosemid-readyflow-edemy-hf-ckd_article',
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
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
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
