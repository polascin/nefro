<?php
/**
 * add_retatrutid-mimo-schvalenia-neregulovane-pouzivanie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový UPSERT skript pre odborný článok o neregulovanom používaní
 * neschváleného retatrutidu (na motívy Medscape Medical News).
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
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Retatrutid mimo schválenia: keď experimentálny liek predbehne reguláciu',
    'slug'         => 'retatrutid-mimo-schvalenia-neregulovane-pouzivanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Retatrutid zostáva neschváleným skúšaným liekom, no na internete sa predávajú produkty s jeho názvom. Ako má lekár reagovať bez legitimizácie rizikového trhu?',
    'content'      => <<<'HTML'
<p><strong>Retatrutid</strong> patrí medzi najsledovanejšie skúšané lieky na liečbu obezity a diabetu 2. typu. Prvé výsledky klinického programu sú sľubné, no rozhodujúci fakt zostáva nezmenený: retatrutid zatiaľ <strong>neschválila žiadna regulačná autorita pre nijakú indikáciu</strong>. Podľa spoločnosti Eli Lilly je pre pacientov dostupný iba v rámci jej riadne vedených klinických skúšaní.</p>

<p>Napriek tomu sa na internete a sociálnych sieťach predávajú injekčné produkty označené ako retatrutid. Niektoré ich ponúkajú ako „výskumný peptid“, hoci sú zjavne propagované na humánne použitie. Lekár sa preto môže stretnúť s pacientom, ktorý si látku podáva bez štandardizovaného predpisu, overiteľného pôvodu a farmaceutickej kontroly kvality.</p>

<p>Pre internistu, diabetológa, obezitológa, nefrológa aj všeobecného lekára nejde o okrajovú kuriozitu. Je to praktický problém na pomedzí klinickej bezpečnosti, komunikácie, znižovania rizika a profesijnej etiky.</p>

<h2>Čo retatrutid je a čo zatiaľ nie je</h2>

<p>Retatrutid je skúšaný <strong>trojitý agonista receptorov pre GLP-1, GIP a glukagón</strong>, ktorý vyvíja spoločnosť Eli Lilly. Kombinovaný mechanizmus ovplyvňuje príjem potravy, reguláciu glykémie, telesnú hmotnosť a energetický metabolizmus. Výrazný úbytok hmotnosti v klinických skúšaniach vysvetľuje mimoriadny záujem pacientov aj médií.</p>

<p>Sľubný výsledok klinickej štúdie však nie je synonymom regulačného schválenia. Kým sa liek dostane do štandardnej praxe, regulačné autority posudzujú úplnosť údajov o účinnosti, bezpečnosti, výrobe a kvalite. Zároveň sa vytvára schválená informácia o lieku: indikácie, dávkovanie a titrácia, kontraindikácie, upozornenia, liekové interakcie a pravidlá používania v osobitných populáciách.</p>

<p>Pri retatrutide dnes existujú skúšobné dávkovacie schémy definované protokolmi klinických štúdií. <strong>Neexistuje však schválené dávkovanie pre bežnú klinickú prax</strong> ani definitívne vymedzený dlhodobý bezpečnostný profil.</p>

<h2>Keď internetový trh predstihne medicínu</h2>

<p>Zdrojový článok Medscape Medical News sumarizuje vyšetrovanie CBS News, ktoré identifikovalo viac ako 120 webových stránok predávajúcich alebo propagujúcich produkty označené ako retatrutid a viac ako 50 kliník, na ktorých ich ponúkali aj licencovaní zdravotníci. Tieto čísla nemožno považovať za systematický odhad prevalencie, dokumentujú však rozsah viditeľnej ponuky.</p>

<p>Produkt z neovereného zdroja môže obsahovať inú účinnú látku, nesprávne množstvo deklarovanej látky, nečistoty alebo mikrobiálnu kontamináciu. Riziko vzniká aj pri neodbornej rekonštitúcii prášku, nesprávnom uchovávaní a opakovanom prepichovaní liekovky. Samotný názov na etikete preto nedokazuje, že pacient dostal retatrutid v deklarovanej dávke a kvalite.</p>

<p>Americký Úrad pre kontrolu potravín a liečiv (FDA) výslovne uvádza, že retatrutid nemožno v USA používať na individuálnu prípravu liekov, pretože nie je zložkou schváleného lieku a nebolo preukázané, že je bezpečný a účinný pri akejkoľvek indikácii. Ide o pravidlo amerického regulačného rámca; právny režim sa medzi krajinami líši. Medicínske jadro problému je však univerzálne: neschválený produkt bez overiteľnej kvality nie je rovnocenný lieku použitému v klinickom skúšaní.</p>

<h2>Čo naozaj ukázala analýza Redditu</h2>

<p>Ďalším zdrojom pozornosti sa stal preprint analyzujúci verejné príspevky na platforme Reddit. Autori pomocou jazykových modelov identifikovali 13 589 používateľov, ktorí sa podľa textu príspevkov sami označovali za aktuálnych užívateľov retatrutidu. Po metodických vylúčeniach malo 7 823 z nich, teda 57,6 %, v texte aspoň jeden príznak priradený ku klinickému termínu databázy MedDRA.</p>

<p>Tento údaj <strong>nie je incidenciou klinicky potvrdených nežiaducich účinkov</strong>. Výskumníci neoverovali totožnosť používateľov, skutočné zloženie produktu, dávku, súbežné užívanie iných látok, diagnózu ani príčinnú súvislosť. Nešlo ani o prospektívne sledovanie so známym a úplným menovateľom. Štúdia je navyše preprintom bez ukončeného recenzného konania.</p>

<p>Medzi často zachytené pojmy patrili zvýšená chuť do jedla, únava, zvýšená energia, nauzea, nutkavá chuť na jedlo, nespavosť a zvýšená srdcová frekvencia. Odlišnosť od profilu v kontrolovaných štúdiách môže súvisieť s vlastnosťami analyzovanej komunity, chybou automatickej klasifikácie, kombinovaním viacerých peptidov, nesprávnym dávkovaním alebo tým, že predávaný produkt neobsahoval deklarovanú látku. Výsledky sú preto <strong>signálom na ďalšie skúmanie, nie dôkazom frekvencie alebo kauzality</strong>.</p>

<h2>Prečo je téma dôležitá pre nefrológa</h2>

<p>O retatrutid sa môžu zaujímať práve pacienti s obezitou, diabetom 2. typu, hypertenziou a chronickou chorobou obličiek (CKD). Pri neregulovanom použití sa k neistote o účinnej látke pridávajú klinické riziká typické pre liečbu s výrazným inkretínovým účinkom.</p>

<ul>
  <li><strong>Nauzea, vracanie, hnačka a znížený príjem tekutín</strong> môžu viesť k hypovolémii a akútnemu poškodeniu obličiek.</li>
  <li><strong>Pokles krvného tlaku a objemová deplécia</strong> môžu byť klinicky významnejšie pri súbežnom užívaní diuretík, inhibítorov systému renín – angiotenzín – aldosterón alebo inhibítorov SGLT2. Nejde nevyhnutne o priamu liekovú interakciu, ale o súbeh účinkov počas akútneho ochorenia.</li>
  <li><strong>Hypoglykémia</strong> je osobitným rizikom pri súbežnom inzulíne alebo derivátoch sulfonylurey, najmä ak pacient výrazne obmedzí príjem potravy.</li>
  <li><strong>Rýchly úbytok hmotnosti</strong> môže zahŕňať aj stratu svalovej hmoty. U starších, krehkých a dialyzovaných pacientov môže zhoršiť funkčnú rezervu a nutričný stav.</li>
  <li><strong>Neznáme zloženie a sterilita</strong> rozširujú diferenciálnu diagnostiku o intoxikáciu, kontamináciu a infekčné komplikácie v mieste vpichu.</li>
</ul>

<p>Samotný pokles hmotnosti nemožno hodnotiť izolovane. Význam má indikácia liečby, telesná kompozícia, funkčný stav, primeraný príjem energie a bielkovín, pohybová aktivita, tolerancia a vývoj pridružených ochorení.</p>

<h2>Ako postupovať, keď pacient už produkt používa</h2>

<p>Rozhovor má byť vecný a neodsudzujúci. Moralizovanie zvyšuje pravdepodobnosť, že pacient užívanie zatají a bude pokračovať bez odbornej pomoci. Empatická komunikácia však neznamená schválenie neregulovanej liečby.</p>

<p>Lekár by mal:</p>

<ol>
  <li><strong>jasne pomenovať stav:</strong> retatrutid je neschválený skúšaný liek a identitu internetového produktu nemožno spoľahlivo odvodiť z etikety;</li>
  <li><strong>odporučiť ukončenie používania</strong> produktu z neovereného zdroja a ponúknuť štandardnú liečbu obezity alebo diabetu, ak je indikovaná;</li>
  <li><strong>získať presnú anamnézu:</strong> zdroj produktu, označenie šarže, forma, deklarovaná koncentrácia, spôsob rekonštitúcie, dávka, frekvencia, začiatok používania, súbežné látky a vzniknuté ťažkosti;</li>
  <li><strong>zhodnotiť aktuálne riziko:</strong> vitálne funkcie, hydratáciu, diurézu, glykémiu, liečbu diabetu a antihypertenznú či diuretickú medikáciu;</li>
  <li><strong>indikovať cielené vyšetrenia</strong> podľa príznakov, komorbidít a klinického nálezu, nie podľa neexistujúceho univerzálneho monitorovacieho protokolu;</li>
  <li><strong>zdokumentovať rozhovor a odporúčanie</strong> vrátane informácie, že bezpečnostné sledovanie nepredstavuje predpis ani schválenie používaného produktu.</li>
</ol>

<p>Ak pacient napriek poučeniu pokračuje, lekár má naďalej poskytovať potrebnú zdravotnú starostlivosť a znižovať riziko. Nemal by však určovať dávku, titrovať neschválený produkt ani vytvárať dojem, že jeho používanie medicínsky garantuje.</p>

<h2>Varovné príznaky</h2>

<p>Pacient má bezodkladne vyhľadať zdravotnú pomoc pri pretrvávajúcom vracaní, neschopnosti prijímať tekutiny, výraznej alebo trvalej bolesti brucha, synkope, závažných palpitáciách, oligúrii, poruche vedomia, prejavoch ťažkej hypoglykémie alebo pri začervenaní, opuchu, bolesti či sekrécii v mieste vpichu. U pacienta s CKD môže byť prah na kontrolu renálnych parametrov a elektrolytov nižší.</p>

<h2>Regulácia nie je zdržanie, ale súčasť liečby</h2>

<p>Regulačné schválenie neodpovedá iba na otázku, či molekula v priemere funguje. Spája klinické údaje s kontrolou výrobného procesu, čistoty, stability, sterility, dávkovania, označovania a farmakovigilancie. Obídením týchto krokov nevzniká rýchlejšia verzia modernej medicíny, ale iný produkt s podstatne väčšou neistotou.</p>

<p>Retatrutid môže po dokončení vývoja a regulačnom posúdení rozšíriť možnosti liečby obezity a diabetu 2. typu. Jeho vedecký potenciál však nesmie slúžiť ako reklama pre produkty neznámeho pôvodu. Úlohou lekára je odlíšiť skúšaný liek v kontrolovanom klinickom programe od látky predávanej pod rovnakým názvom bez overiteľnej kvality.</p>

<h2>Záver</h2>

<p>Retatrutid je sľubný, ale stále neschválený liek. Produkty ponúkané mimo klinických skúšaní nemožno považovať za jeho bezpečný ekvivalent. Neistota sa netýka iba dávkovania a dlhodobej bezpečnosti, ale už samotnej identity, koncentrácie, čistoty a sterility prípravku.</p>

<p>Správnou reakciou nie je pacienta odmietnuť, ale jasne odporučiť ukončenie neregulovaného používania, posúdiť možné komplikácie a ponúknuť schválenú alternatívu. V nefrologickej praxi treba myslieť najmä na hypovolémiu, akútne poškodenie obličiek, hypotenziu, zmeny antidiabetickej liečby a stratu svalovej hmoty u krehkých pacientov. Účinná liečba nie je iba silná; musí byť aj identifikovateľná, kvalitná, indikovaná a kontrolovaná.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> Larkin M. Unapproved Retatrutide Use Challenges Clinicians. <em>Medscape Medical News</em>. 26. júna 2026. <a href="https://www.medscape.com/viewarticle/unapproved-retatrutide-use-challenges-clinicians-2026a1000lqj" target="_blank" rel="noopener noreferrer">medscape.com</a></em></p>

<p><em><strong>Ďalšie zdroje:</strong> U.S. Food and Drug Administration. Concerns with Unapproved GLP-1 Drugs Used for Weight Loss. <a href="https://www.fda.gov/drugs/postmarket-drug-safety-information-patients-and-providers/medications-containing-semaglutide-marketed-type-2-diabetes-or-weight-loss" target="_blank" rel="noopener noreferrer">fda.gov</a>; Eli Lilly and Company. What to Know About Retatrutide. <a href="https://www.lilly.com/news/stories/what-to-know-about-retatrutide" target="_blank" rel="noopener noreferrer">lilly.com</a>; Sehgal NKR, et al. Self-Reported Side Effects Among Reddit Users Taking Unapproved Retatrutide. <em>medRxiv</em>. 2026. doi: <a href="https://doi.org/10.64898/2026.05.28.26352819" target="_blank" rel="noopener noreferrer">10.64898/2026.05.28.26352819</a>.</em></p>
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
