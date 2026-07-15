<?php
/**
 * add_predialyzacna-edukacia-volba-peritonealnej-dialyzy_article.php
 * Odborný článok o predialyzačnej edukácii a voľbe dialyzačnej modality.
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
    'title'        => 'Predialyzačná edukácia a voľba peritoneálnej dialýzy: čo ukázala poľská kohorta',
    'slug'         => 'predialyzacna-edukacia-volba-peritonealnej-dialyzy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'V poľskej kohorte si po individuálnej edukácii zvolilo peritoneálnu dialýzu 62,7 % pacientov. Výsledok ukazuje potenciál spoločného rozhodovania, nie kauzálny účinok programu.',
    'content'      => <<<'HTML'
<p>Voľba liečby pri zlyhaní obličiek patrí medzi rozhodnutia, ktoré zásadne menia každodenný život pacienta aj jeho blízkych. Rozhovor nemá byť obmedzený na otázku, kedy vytvoriť cievny prístup. Pacient potrebuje včas a zrozumiteľne poznať preemptívnu transplantáciu, peritoneálnu dialýzu (PD), strediskovú a tam, kde je dostupná, domácu hemodialýzu, ako aj komplexnú konzervatívnu starostlivosť bez dialýzy.</p>

<p>Retrospektívna štúdia z jedného varšavského centra sledovala 118 pacientov s CKD G4–G5, ktorí absolvovali individuálnu predialyzačnú edukáciu. PD si po stretnutí zvolilo 74 pacientov (62,7 %) a 61 pacientov, teda 51,7 % celého súboru, ju napokon začalo. Čísla ukazujú, že domáca liečba môže byť pre vhodne vybraných a informovaných pacientov prijateľnou možnosťou.</p>

<p>Štúdia však <strong>nepreukázala kauzálny účinok edukácie</strong>. Nemala kontrolnú skupinu a zahŕňala pacientov, ktorých odosielajúci nefrológovia už považovali za možných kandidátov na PD. Jej najsilnejším odkazom preto nie je univerzálny cieľ 63 % pacientov na PD, ale praktická ukážka, ako môže vyzerať systematická a individualizovaná voľba modality.</p>

<h2>Prečo je edukácia súčasťou klinickej starostlivosti</h2>

<p>Neplánovaný začiatok dialýzy zužuje priestor na slobodnú voľbu. Pri urgentnej potrebe liečby často rozhoduje aktuálna dostupnosť pracoviska, prístupu a personálu, nie dlhodobé ciele pacienta. Aj po neplánovanom začatí hemodialýzy sa však má preferencia modality znovu otvoriť, keď sa klinický stav stabilizuje.</p>

<p>Kvalitná edukácia nie je jednorazové odovzdanie informačného letáka. Má pacientovi pomôcť porozumieť prognóze, realistickým možnostiam, každodennej záťaži liečby, možným komplikáciám a tomu, akú podporu bude potrebovať. Rozhodnutie má spájať medicínsku uskutočniteľnosť s pacientovými prioritami, napríklad autonómiou, pracovným režimom, cestovaním, bezpečnosťou doma alebo želaním minimalizovať záťaž rodiny.</p>

<h2>Čo presne skúmala varšavská štúdia</h2>

<p>Autori analyzovali pacientov edukovaných od januára 2020 do decembra 2023 v ambulancii peritoneálnej dialýzy Vojenského lekárskeho inštitútu vo Varšave. Stretnutie trvalo približne 90–120 minút, viedol ho stály tím dvoch lekárov a dvoch sestier a podľa možnosti sa ho zúčastnili aj blízki pacienta.</p>

<p>Lekárska časť zahŕňala vysvetlenie indikácií, PD, strediskovej hemodialýzy a podmienok transplantácie. Sestry prakticky ukazovali vaky s dialyzačným roztokom, Tenckhoffov katéter, cyklér, ohrievač aj výmenu pri kontinuálnej ambulantnej peritoneálnej dialýze. Pacienti videli aj hemodialyzačné pracovisko a prístroj. Domáca hemodialýza sa nepreberala, pretože v Poľsku nebola dostupná.</p>

<div class="table-responsive" role="region" aria-label="Charakteristika súboru a edukačného programu" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Ukazovateľ</th>
      <th>Výsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Počet pacientov</td>
      <td>118</td>
    </tr>
    <tr>
      <td>Vek</td>
      <td>priemer 54,3 roka; rozpätie 18–86 rokov</td>
    </tr>
    <tr>
      <td>Ženy</td>
      <td>40 (34 %)</td>
    </tr>
    <tr>
      <td>Diabetes mellitus</td>
      <td>46 (39 %)</td>
    </tr>
    <tr>
      <td>Pacientom deklarované vhodné domáce podmienky</td>
      <td>108 (91,5 %)</td>
    </tr>
    <tr>
      <td>Dostupnosť podpory blízkej osoby</td>
      <td>112 (95 %)</td>
    </tr>
    <tr>
      <td>Forma edukácie</td>
      <td>individuálne stretnutie, približne 90–120 minút</td>
    </tr>
  </tbody>
</table>
</div>

<p>Zásadné je, že nešlo o všetkých pacientov s CKD G4–G5 v regióne. Na edukáciu boli odoslaní ľudia, ktorých nefrológ považoval za potenciálnych kandidátov na PD a za osoby, ktoré by mohli mať z programu prospech. Takáto predselekcia pravdepodobne zvýšila podiel pacientov vhodných pre PD aj podiel tých, ktorí si ju zvolili.</p>

<h2>Vhodnosť pre PD nebola binárna</h2>

<p>Po klinickom a psychosociálnom posúdení autori rozdelili pacientov do štyroch skupín:</p>

<div class="table-responsive" role="region" aria-label="Posúdenie vhodnosti pacientov pre peritoneálnu dialýzu" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Kategória centra</th>
      <th>Počet</th>
      <th>Podiel</th>
      <th>Praktický význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Bez medicínskych alebo psychosociálnych prekážok</td>
      <td>75</td>
      <td>63,5 %</td>
      <td>voľba zostala na pacientovi</td>
    </tr>
    <tr>
      <td>Relatívne prekážky</td>
      <td>17</td>
      <td>14,4 %</td>
      <td>individuálne zváženie rizík a úprav liečby</td>
    </tr>
    <tr>
      <td>Potreba asistovanej PD</td>
      <td>19</td>
      <td>16,1 %</td>
      <td>liečba závisela od dostupnej pomoci</td>
    </tr>
    <tr>
      <td>Vyradenie z PD</td>
      <td>7</td>
      <td>6,0 %</td>
      <td>kombinácia závažných klinických a funkčných prekážok</td>
    </tr>
  </tbody>
</table>
</div>

<p>Podľa klasifikácie centra teda 94 % odoslaných pacientov nemalo absolútnu prekážku PD. Tento údaj nemožno preniesť na celú populáciu s pokročilou CKD, pretože pacienti boli pred odoslaním vybraní a kategórie odrážali rozhodovanie konkrétneho pracoviska, nie univerzálny zoznam kontraindikácií.</p>

<h2>Voľba modality nie je to isté ako jej začatie</h2>

<p>Po edukácii si PD zvolilo 74 pacientov (62,7 %) a hemodialýzu 44 pacientov (37,3 %). Z pacientov preferujúcich PD ju 61 skutočne začalo, čo predstavuje 82,4 % tejto skupiny a 51,7 % celého súboru. Štyria podstúpili preemptívnu transplantáciu, piati zostali v predialyzačnom sledovaní a u štyroch sa plán PD nerealizoval alebo nepokračoval pre klinické či procedurálne komplikácie.</p>

<p>Pre prax je tento rozdiel podstatný. Preferencia pacienta sa môže stratiť medzi rozhodnutím a začiatkom liečby pre progresiu ochorenia, nedostupnosť implantácie katétra, akútnu komplikáciu, zmenu funkčného stavu alebo zmenu liečebného cieľa. Program preto nemá merať iba odpoveď na otázku „čo si pacient vybral“, ale aj to, akú modalitu reálne začal a prečo sa pôvodný plán prípadne nenaplnil.</p>

<h2>Faktory spojené s nižšou šancou zvoliť si PD</h2>

<p>V univariačných logistických modeloch boli s nižšími šancami na voľbu PD spojené:</p>

<ul>
  <li>vyšší vek: OR 0,967 na každý ďalší rok; p = 0,010,</li>
  <li>diabetes mellitus: OR 0,353; p = 0,008,</li>
  <li>vyšší BMI: OR 0,884 na 1 kg/m<sup>2</sup>; p = 0,010,</li>
  <li>jazvy po abdominálnej operácii: OR 0,423; p = 0,029,</li>
  <li>posúdená potreba asistovanej PD: OR 0,264; p = 0,013.</li>
</ul>

<p>OR nižší než 1 vyjadruje nižšie šance, nie priamy pokles absolútnej pravdepodobnosti. Analýzy boli iba univariačné, preto neoddeľujú vzájomne previazané vplyvy veku, diabetu, funkčnej závislosti, komorbidít a potreby asistencie. Výsledky sú asociáciami a nemožno ich interpretovať ako dôkaz, že jednotlivý faktor spôsobil odmietnutie PD.</p>

<h2>Vek, diabetes ani operácia brucha nie sú automatické zákazy</h2>

<p>Vyšší vek môže súvisieť s krehkosťou, poruchou zraku, obmedzenou manuálnou zručnosťou alebo kognitívnym deficitom, ale chronologický vek sám osebe nevystihuje schopnosť vykonávať PD. Diabetes môže prinášať retinopatiu, neuropatiu a vyššiu multimorbiditu; ani on však nie je absolútnou kontraindikáciou.</p>

<p>Obdobne jazva po abdominálnej operácii nedokazuje nepriechodnosť peritoneálnej dutiny. Upozorňuje na možné adhézie a mechanické riziká a môže viesť k chirurgickému alebo laparoskopickému posúdeniu. Hernie možno u vybraných pacientov chirurgicky ošetriť pred implantáciou katétra alebo súčasne s ňou. Rozhodovať má kombinácia anatomického nálezu, funkčného stavu, skúseností centra, preferencie pacienta a dostupnej podpory.</p>

<h2>Asistovaná PD je skúškou systému, nie pacienta</h2>

<p>Asistenciu potrebovalo 19 pacientov, ale PD si z tejto skupiny zvolilo iba šesť. V danom poľskom prostredí mohla pomoc pochádzať len od rodiny alebo blízkych. Ak nikto nedokázal pravidelne prevziať technické úkony, praktickou voľbou zostala stredisková hemodialýza.</p>

<p>ISPD považuje asistovanú PD za legitímny model, ktorý môže odstrániť bariéry sebestačnosti u starších, krehkých alebo funkčne limitovaných pacientov. Rodina však nemá byť skrytým a neobmedzeným zdrojom bez posúdenia záťaže. Program potrebuje definovať rozsah asistencie, vyškolenie, zastupiteľnosť, financovanie, kontrolu kvality a odľahčovaciu podporu pre opatrovateľa.</p>

<h2>Rovnocenná ponuka je presnejšia než povinné „PD-first“</h2>

<p>Peritoneálna dialýza umožňuje domácu liečbu, väčšiu časovú autonómiu a zachovanie cievneho riečiska. Plynulejšia ultrafiltrácia môže byť hemodynamicky lepšie tolerovaná a PD býva najmä v skoršom období spojená s lepším zachovaním reziduálnej funkcie obličiek. Tieto výhody však nie sú u každého pacienta rovnako dôležité a nevylučujú peritonitídu, mechanické komplikácie, glukózovú záťaž ani možnosť zlyhania techniky.</p>

<p>KDIGO odporúča, aby mal každý človek, ktorý potrebuje udržiavaciu dialýzu, domácu dialýzu medzi potenciálnymi možnosťami. Zároveň upozorňuje, že výsledky dostupných modalít sú celkovo porovnateľné a voľba má vychádzať z kvality života očakávanej pacientom a jeho blízkymi. Povinná politika <em>PD-first</em> preto nie je univerzálnym klinickým pravidlom; vhodnejší je <strong>systém, ktorý neuprednostňuje jednu modalitu, ale domácu liečbu reálne umožňuje</strong>.</p>

<h2>Čo má obsahovať kvalitný edukačný proces</h2>

<ul>
  <li>prognózu CKD a vysvetlenie, prečo a kedy môže byť potrebná liečba zlyhania obličiek,</li>
  <li>preemptívnu transplantáciu vrátane možnosti žijúceho darcu,</li>
  <li>PD, strediskovú aj domácu hemodialýzu tam, kde je dostupná,</li>
  <li>komplexnú konzervatívnu starostlivosť pri rozhodnutí nezačať dialýzu,</li>
  <li>praktickú ukážku techniky, materiálu, časového režimu a požiadaviek na priestor,</li>
  <li>očakávané prínosy, neistoty, komplikácie a záťaž každej možnosti,</li>
  <li>vplyv na prácu, cestovanie, spánok, stravu, rodinu a finančné náklady pacienta,</li>
  <li>zhodnotenie zraku, manuálnej zručnosti, kognície, krehkosti, zdravotnej gramotnosti a domáceho prostredia,</li>
  <li>možnosť hovoriť s vyškoleným pacientom, ktorý má skúsenosť s danou modalitou,</li>
  <li>opakované stretnutie a dokumentovanie pacientových cieľov a preferencie.</li>
</ul>

<p>Informácie majú byť vyvážené aj spôsobom podania. Rovnaký čas pre každú modalitu ešte nezaručuje neutralitu, ak tím jednu možnosť opisuje ako normu a inú ako náročnú výnimku. Užitočné sú štandardizované rozhodovacie pomôcky, spätné overenie porozumenia a priestor na zmenu názoru bez pocitu zlyhania.</p>

<h2>Kedy s edukáciou začať</h2>

<p>KDIGO uvádza, že účinná edukácia sa zvyčajne ponúka pri približovaní sa ku CKD G4. Presný čas však nemá určovať jediná hodnota eGFR. Zohľadniť treba rýchlosť progresie, riziko zlyhania obličiek, symptómy, komorbidity, transplantačnú spôsobilosť a čas potrebný na prípravu zvolenej modality.</p>

<p>Jedno stretnutie nemusí stačiť. Pacient môže byť pri prvom rozhovore zahltený diagnózou alebo ešte nemusí vnímať potrebu rozhodovať. Edukácia má byť procesom s opakovaním, zapojením blízkych a jasným plánom ďalších krokov. Znovu ju treba ponúknuť aj človeku, ktorý začal dialýzu neplánovane.</p>

<h2>Čo štúdia nepreukázala</h2>

<ul>
  <li>Bez kontrolnej skupiny nemožno určiť, o koľko edukácia zvýšila výber PD.</li>
  <li>Predvýber potenciálnych kandidátov na PD obmedzuje zovšeobecnenie na všetkých pacientov s CKD G4–G5.</li>
  <li>Jednocentrový retrospektívny súbor 118 pacientov má obmedzenú štatistickú presnosť.</li>
  <li>Univariačné modely nekontrolovali možné mätúce faktory.</li>
  <li>Neutralita edukácie nebola nezávisle posúdená a jednotnosť programu nebola formálne validovaná.</li>
  <li>Nehodnotili sa vedomosti, rozhodovací konflikt, skúsenosť pacienta, kvalita života ani dlhodobé klinické výsledky.</li>
  <li>Aktuálne dostupná verzia je rukopis prijatý na publikovanie pred konečnou redakčnou úpravou; obsahuje drobné vnútorné nezrovnalosti v niektorých podskupinových súčtoch a štatistických údajoch.</li>
</ul>

<p>Najspoľahlivejšie sú preto celkové denominátory: 74 zo 118 pacientov si zvolilo PD a 61 zo 118 ju začalo. Tieto údaje opisujú výsledok konkrétneho programu, nie univerzálnu účinnosť edukácie.</p>

<h2>Praktické ukazovatele kvality programu</h2>

<p>Úspech predialyzačnej starostlivosti by sa nemal hodnotiť iba percentom pacientov, ktorí si vybrali PD. Užitočnejšie je sledovať:</p>

<ul>
  <li>podiel vhodných pacientov, ktorým boli včas ponúknuté všetky dostupné možnosti,</li>
  <li>čas od odoslania po edukáciu a od rozhodnutia po zabezpečenie prístupu,</li>
  <li>podiel neplánovaných začiatkov dialýzy a začiatkov cez centrálny venózny katéter,</li>
  <li>zhodu medzi preferovanou a skutočne začatou modalitou,</li>
  <li>dôvody, pre ktoré sa pôvodný plán nenaplnil,</li>
  <li>dostupnosť preemptívnej transplantácie, asistovanej PD a konzervatívnej starostlivosti,</li>
  <li>porozumenie pacienta, rozhodovací konflikt, spokojnosť a záťaž opatrovateľa.</li>
</ul>

<h2>Záver</h2>

<p>V predselektovanej kohorte jedného poľského centra si po individuálnej edukácii zvolilo peritoneálnu dialýzu 62,7 % pacientov a 51,7 % celého súboru ju napokon začalo. Štúdia ukazuje realizovateľnosť systematického rozhovoru o modalite, ale bez kontrolnej skupiny nedokazuje, že pozorovaný podiel spôsobila samotná edukácia.</p>

<p>Najdôležitejším cieľom nie je maximalizovať počet pacientov na PD. Cieľom je, aby človek s pokročilou CKD dostal včasnú, zrozumiteľnú a vyváženú informáciu, mohol pomenovať svoje priority a mal reálny prístup k zvolenej možnosti. Informovaná voľba vzniká až vtedy, keď zdravotný systém dokáže ponúknuť nielen rozhovor, ale aj transplantáciu, domácu liečbu, asistenciu, strediskovú dialýzu a konzervatívnu starostlivosť podľa potrieb pacienta.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Mosakowska M, Jędrych E, Kotwica-Strzałek E, Dorywalska A, Lubas A, Niemczyk S. How pre-education affects patients choosing appropriate renal replacement treatment: a retrospective study. <em>BMC Nephrology</em>. Publikované online 27. júna 2026. Akceptovaný rukopis pred finálnou redakčnou úpravou. <a href="https://doi.org/10.1186/s12882-026-05160-0" target="_blank" rel="noopener noreferrer">DOI</a>.</em></p>

<p><em><strong>Odporúčania a kontext:</strong> <a href="https://kdigo.org/wp-content/uploads/2017/02/KDIGO-Dialysis-Initiation-conf-report-FINAL.pdf" target="_blank" rel="noopener noreferrer">KDIGO: Dialysis initiation, modality choice, access, and prescription</a> · <a href="https://kdigo.org/wp-content/uploads/2023/04/Home-Dialysis-Conclusions-from-a-KDIGO-Controversies-Conference.pdf" target="_blank" rel="noopener noreferrer">KDIGO: Home dialysis</a> · <a href="https://ispd.org/wp-content/uploads/Assisted-PD-PP-2024.pdf" target="_blank" rel="noopener noreferrer">ISPD Position Paper on Assisted Peritoneal Dialysis</a>.</em></p>
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
                error_log('add_predialysis_education newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_predialysis_education pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_predialysis_education pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_predialysis_education migration error: ' . $e->getMessage());
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
