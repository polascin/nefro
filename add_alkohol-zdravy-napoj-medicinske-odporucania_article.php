<?php
/**
 * add_alkohol-zdravy-napoj-medicinske-odporucania_article.php
 * ============================================================================
 * Odborný článok: alkohol, zmena interpretácie dôkazov a nefrologická prax.
 *
 * Spustenie na serveri po commite:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_alkohol-zdravy-napoj-medicinske-odporucania_article.php"
 */

// Ochrana - len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

$articles = [];

$articles[] = [
    'title'        => 'Alkohol ako „zdravý nápoj“: prečo sa medicínske odporúčania menia',
    'slug'         => 'alkohol-zdravy-napoj-medicinske-odporucania',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Mierne pitie alkoholu nemožno odporúčať ako prevenciu. Novšie dôkazy spresňujú onkologické a kardiovaskulárne riziká aj praktický prístup u pacientov s CKD.',
    'content'      => <<<'HTML'
<p>Predstava, že jeden pohár vína denne prospieva srdcu, patrila desaťročia medzi najrozšírenejšie zdravotné mýty. Podporovali ju médiá, pojem „francúzsky paradox“ aj observačné štúdie, v ktorých mali ľahkí až mierni konzumenti alkoholu priaznivejšie výsledky než abstinenti. Novšie analýzy však ukazujú, že podstatnú časť zdanlivého prínosu možno vysvetliť metodickými skresleniami. Alkohol preto nemožno odporúčať ako súčasť prevencie kardiovaskulárnych ani iných ochorení.</p>

<p>Zdrojový článok Medscape sa venuje praktickej otázke, ako túto zmenu vysvetliť pacientovi bez moralizovania. Pre internistu a nefrológa je téma osobitne dôležitá: pacienti s chronickou chorobou obličiek (CKD) majú často hypertenziu, diabetes mellitus, vysoké kardiovaskulárne riziko, polyfarmáciu a menšiu rezervu pri poruchách hydratácie či hemodynamiky.</p>

<h2>Prečo bola J-krivka presvedčivá a v čom bol problém</h2>

<p>Staršie observačné práce často opisovali takzvanú J-krivku: abstinenti mali vyššie riziko než mierni konzumenti a najvyššie riziko mali osoby s vysokou spotrebou alkoholu. Takéto porovnanie však ľahko skreslí niekoľko javov:</p>

<ul>
  <li>medzi abstinentov sa zaradili bývalí konzumenti, ktorí prestali piť pre chorobu alebo predchádzajúce problematické pitie,</li>
  <li>ľahkí konzumenti sa od abstinentov líšili socioekonomickým postavením, stravou, pohybom, fajčením, vzdelaním aj dostupnosťou zdravotnej starostlivosti,</li>
  <li>množstvo a vzorec pitia sa zisťovali z údajov od samotných účastníkov a počas sledovania sa mohli meniť,</li>
  <li>priemerná týždenná spotreba zakryla nárazové pitie veľkých dávok, ktoré nesie osobitné riziko.</li>
</ul>

<p>Po dôslednejšom oddelení celoživotných abstinentov od bývalých konzumentov a po lepšom zohľadnení sprievodných faktorov sa údajný ochranný účinok oslabuje alebo mizne. Veľká syntéza <em>Alcohol Intake and Health Study</em> publikovaná v roku 2026 nenašla pri nízkej spotrebe čistý ochranný účinok na mortalitu. Ide však o populačný odhad založený na epidemiologických údajoch, nie o dôkaz, že rovnaké riziko vznikne u každého jednotlivca.</p>

<h2>Čo presne znamená „najbezpečnejšia dávka je nulová“</h2>

<p>Táto veta potrebuje presnú interpretáciu. Etanol a acetaldehyd vznikajúci pri jeho metabolizme sú karcinogénne. Pri nádorových ochoreniach nebola určená hranica, pod ktorou by bolo riziko preukázateľne nulové. Abstinencia preto minimalizuje riziko pripísateľné alkoholu. Pri nízkej spotrebe býva absolútny nárast rizika u jednotlivca malý, nie však nulový, a s dávkou rastie.</p>

<p>Označenie „nízkoriziková“ alebo „mierna“ konzumácia neznamená bezpečnosť ani zdravotný prínos. Vyjadruje iba nižšie riziko v porovnaní s vyššou spotrebou. Ak človek alkohol nepije, nie je medicínsky dôvod odporúčať mu, aby začal. Ak pije, znižovanie množstva a vynechanie nárazového pitia riziko znižujú.</p>

<p>Pri anamnéze treba myslieť aj na to, že „štandardný nápoj“ nemá všade rovnakú definíciu. V rôznych krajinách a štúdiách môže predstavovať približne 10 až 14 g čistého etanolu. Presnejšie než počet pohárov je preto zisťovať typ nápoja, objem, koncentráciu alkoholu, frekvenciu a maximálnu dávku pri jednej príležitosti.</p>

<h2>Alkohol a onkologické riziko</h2>

<p>Príčinná súvislosť je preukázaná najmenej pri siedmich lokalizáciách: nádory ústnej dutiny, hltana, hrtana, pažeráka, pečene, kolorekta a prsníka u žien. Riziko súvisí s etanolom, nie s tým, či ide o víno, pivo alebo destilát.</p>

<p>Medzi biologické mechanizmy patria poškodenie DNA acetaldehydom a oxidačným stresom, zmeny hormonálnej regulácie a uľahčenie vstrebávania ďalších karcinogénov v oblasti horného aerodigestívneho traktu. Kombinácia alkoholu a fajčenia je pri niektorých nádoroch mimoriadne riziková.</p>

<p>V ambulancii je preto vhodné hovoriť priamo: nižšia spotreba znamená nižšie onkologické riziko a najnižšie riziko pripísateľné alkoholu má človek, ktorý nepije. Takáto informácia nie je zákazom ani hodnotením pacienta, ale súčasťou informovaného rozhodovania.</p>

<h2>Kardiovaskulárne ochorenia: bez dôvodu predpisovať víno</h2>

<p>V kardiovaskulárnej oblasti je potrebná väčšia nuansa. Vedecké stanovisko American Heart Association z roku 2025 hodnotí údaje o nízkej až miernej konzumácii ako zmiešané: niektoré observačné štúdie naznačujú priaznivú asociáciu pri vybraných výsledkoch, kým štúdie využívajúce mendelovskú randomizáciu jasný ochranný účinok nepotvrdili. Príčinný kardioprotektívny účinok alkoholu teda nebol dokázaný a odborné spoločnosti neodporúčajú začať piť pre zdravie srdca.</p>

<p>Na druhej strane sú nadmerná a nárazová konzumácia konzistentne spojené s hypertenziou, fibriláciou predsiení, cievnou mozgovou príhodou, kardiomyopatiou a srdcovým zlyhávaním. Japonská longitudinálna analýza z roku 2025 navyše ukázala malé, dávkovo závislé zníženie krvného tlaku po ukončení aj nízkej až miernej konzumácie. Keďže nešlo o randomizovanú intervenciu, výsledok treba chápať ako podporu redukcie alkoholu pri manažmente tlaku, nie ako presný odhad účinku pre každého pacienta.</p>

<h2>Nefrologický pohľad</h2>

<p>Pri nízkej konzumácii nie je hlavným problémom priama nefrotoxicita etanolu. Dôležitejšie sú nepriame účinky a klinický kontext:</p>

<ul>
  <li>zhoršenie kontroly krvného tlaku a zvýšenie celkového kardiovaskulárneho rizika,</li>
  <li>akútna diuréza a zhoršenie objemovej deplécie pri horúčave, horúčke, vracaní alebo hnačke,</li>
  <li>vyššie riziko hypotenzie a akútneho poškodenia obličiek pri súčasnej liečbe diuretikami, blokátormi systému renín-angiotenzín, inhibítormi SGLT2 alebo pri užívaní NSAID,</li>
  <li>hypoglykémia u pacientov liečených inzulínom alebo liekmi s rizikom hypoglykémie, najmä pri pití bez jedla,</li>
  <li>poruchy adherencie, pády, úrazy a liekové interakcie,</li>
  <li>pri ťažkej intoxikácii alebo dlhodobom nadmernom pití aj elektrolytové poruchy, rabdomyolýza, malnutrícia a poškodenie pečene s následnými renálnymi komplikáciami.</li>
</ul>

<p>U dialyzovaného pacienta sa alkoholický nápoj započítava do denného príjmu tekutín. Podľa druhu môže prinášať aj sacharidy, draslík alebo fosfor a môže sťažiť dodržiavanie liečebného režimu. U príjemcu transplantátu treba posúdiť funkciu pečene, metabolické riziko, súbežnú medikáciu a adherenciu; všeobecné tvrdenie o priamej interakcii alkoholu so všetkými imunosupresívami by však nebolo správne.</p>

<h2>Ako viesť rozhovor bez moralizovania</h2>

<p>Samotné konštatovanie „alkohol škodí“ zvyčajne nestačí. Užitočnejšie je spojiť rozhovor s cieľom pacienta: lepšou kontrolou tlaku, znížením rizika fibrilácie predsiení, stabilnejšou glykémiou, kvalitnejším spánkom alebo bezpečnejším užívaním liekov. Medscape cituje odborníkov, ktorí odporúčajú presunúť pozornosť od sporu o „povolené množstvo“ k otázke, či alkohol pacientovi pomáha dosiahnuť jeho zdravotné ciele.</p>

<p>Praktická anamnéza môže zahŕňať:</p>

<ul>
  <li>Koľko dní v týždni zvyčajne pijete alkohol?</li>
  <li>Čo a koľko vypijete v bežný deň, keď pijete?</li>
  <li>Aké najväčšie množstvo vypijete pri jednej príležitosti?</li>
  <li>Všimli ste si vplyv na tlak, pulz, spánok, hmotnosť alebo glykémiu?</li>
  <li>Skúsili ste spotrebu znížiť a bolo to ťažšie, než ste očakávali?</li>
</ul>

<p>Na rýchly skríning možno použiť validovaný dotazník AUDIT-C. Pozitívny výsledok nie je diagnózou; je podnetom na podrobnejšie zhodnotenie rizikového pitia, možnej závislosti, psychických ťažkostí a sociálnych dôsledkov.</p>

<h2>Dôležité upozornenie pri možnej závislosti</h2>

<p>Odporúčanie okamžite prestať piť nie je bezpečné pre každého. U človeka s fyzickou závislosťou môže náhle vysadenie vyvolať závažný abstinenčný syndróm vrátane kŕčov alebo delíria. Varovné sú ranné pitie, tras, potenie, úzkosť, nespavosť či predchádzajúce abstinenčné príznaky po vynechaní alkoholu. Takýto pacient potrebuje lekárske zhodnotenie a podľa rizika plánovanú ambulantnú alebo ústavnú detoxifikáciu.</p>

<h2>Najčastejšie mýty v ambulancii</h2>

<p><strong>„Červené víno je zdravé na srdce.“</strong><br>
Príčinný ochranný účinok nebol preukázaný. Polyfenoly možno získať z potravín bez expozície etanolu.</p>

<p><strong>„Pivo je bezpečnejšie než destilát.“</strong><br>
Rozhoduje najmä množstvo prijatého etanolu a vzorec pitia. Veľký objem piva je navyše relevantný pri obmedzení tekutín.</p>

<p><strong>„Riziko sa týka iba ľudí so závislosťou.“</strong><br>
Nie. Niektoré riziká, najmä onkologické, rastú už pri nízkych pravidelných dávkach; závažné akútne riziká zvyšuje aj nárazové pitie.</p>

<p><strong>„Odporúčaný limit je hranica bezpečnosti.“</strong><br>
Limit je nástroj na znižovanie rizika, nie deliaca čiara medzi bezpečnou a nebezpečnou konzumáciou.</p>

<h2>Praktické odporúčania pre internú a nefrologickú ambulanciu</h2>

<ul>
  <li>Ak pacient nepije, neodporúčať mu začať zo zdravotných dôvodov.</li>
  <li>Ak pije, kvantifikovať spotrebu, frekvenciu a nárazové pitie; nespoliehať sa len na slová „príležitostne“ alebo „mierne“.</li>
  <li>Vysvetliť, že menej znamená nižšie riziko a abstinencia minimalizuje riziko pripísateľné alkoholu.</li>
  <li>Odporučiť abstinenciu pri gravidite, vedení vozidla, aktívnom ochorení pečene alebo pankreasu, nekontrolovanom pití a pri liekoch či stavoch, pri ktorých je alkohol nebezpečný.</li>
  <li>Pri CKD individualizovať odporúčanie podľa objemového stavu, krvného tlaku, diabetu, liekov, ochorenia pečene a dialyzačného alebo transplantačného režimu.</li>
  <li>Pri podozrení na závislosť najprv posúdiť riziko abstinenčného syndrómu a zabezpečiť odbornú pomoc.</li>
</ul>

<h2>Limity dostupných dôkazov</h2>

<p>Zdrojový článok Medscape je edukačný publicistický text, nie pôvodná klinická štúdia. Opiera sa o novšie epidemiologické práce a vyjadrenia odborníkov. Autor článku nebol vo verejne dostupnom zobrazení spoľahlivo identifikovaný, preto ho nemožno korektne doplniť.</p>

<p>Aj kvalitnejšie štúdie o nízkej konzumácii alkoholu majú limity: dlhodobé randomizované prideľovanie alkoholu by bolo eticky a prakticky problematické, spotreba sa často zisťuje sebahlásením a zvyškové skreslenie nemožno úplne odstrániť. Najpevnejší záver preto nie je, že každá dávka spôsobí rovnakú ujmu, ale že alkohol nemožno predpisovať ako zdraviu prospešnú intervenciu a že s rastúcou expozíciou rastie aj spektrum zdravotných rizík.</p>

<h2>Záver</h2>

<p>Alkohol nepatrí medzi opatrenia zdravej životosprávy. Starší obraz kardioprotektívneho „pohára vína“ bol do veľkej miery založený na observačných údajoch náchylných na skreslenie. Pri rakovine nepoznáme dávku s nulovým rizikom a pri kardiovaskulárnych ochoreniach nie je dôkaz dostatočný na odporúčanie alkoholu ako prevencie.</p>

<p>Pre internistu a nefrológa je najpraktickejší jednoduchý postup: pýtať sa presne a bez odsudzovania, neodporúčať začatie pitia, podporovať znižovanie spotreby a osobitne chrániť pacientov s vysokým onkologickým či kardiovaskulárnym rizikom, CKD, polyfarmáciou alebo možnou závislosťou.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> <em>Alcohol’s Health Myth Is Over. How to Tell Patients</em>. Medscape Medical News, 1. júl 2026. Autor článku nebol vo verejne dostupnom zobrazení spoľahlivo uvedený. Citovaní odborníci: Noelle LoConte, Douglas Spotts a Columbus Batiste. <a href="https://www.medscape.com/viewarticle/alcohols-health-myth-over-how-tell-patients-2026a1000map" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<p><em><strong>Doplňujúce zdroje:</strong> George S et al. <em>Alcohol Intake and Health Study: No Protective Effect at Low Levels, With Mortality Increasing to 1 in 25 at 14 Drinks Per Week</em>. Journal of Studies on Alcohol and Drugs. 2026;87(4):621-638. <a href="https://doi.org/10.15288/jsad.25-00435" target="_blank" rel="noopener noreferrer">doi:10.15288/jsad.25-00435</a>. Piano MR et al. <em>Alcohol Use and Cardiovascular Disease: A Scientific Statement From the American Heart Association</em>. Circulation. 2025. <a href="https://doi.org/10.1161/CIR.0000000000001341" target="_blank" rel="noopener noreferrer">doi:10.1161/CIR.0000000000001341</a>. Suzuki T et al. <em>Blood Pressure After Changes in Light-to-Moderate Alcohol Consumption in Women and Men</em>. J Am Coll Cardiol. 2025;86(21):2031-2044. <a href="https://doi.org/10.1016/j.jacc.2025.09.018" target="_blank" rel="noopener noreferrer">doi:10.1016/j.jacc.2025.09.018</a>. <a href="https://www.hhs.gov/surgeongeneral/reports-and-publications/alcohol-cancer/index.html" target="_blank" rel="noopener noreferrer">U.S. Surgeon General: Alcohol and Cancer Risk</a>.</em></p>
HTML,
];

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
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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
