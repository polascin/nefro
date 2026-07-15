<?php
/**
 * add_kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd_article.php
 * Odborný článok o kvalitatívnom výskume a jeho využití v nefrológii.
 * Pôvodná autorka spracovaného zdroja je uvedená v source_authors.php.
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
    'title'        => 'Kvalitatívny výskum v nefrológii: čo čísla neukážu o rozhodovaní pri CKD',
    'slug'         => 'kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Rozhovory, pozorovanie a tematická analýza odhaľujú, ako pacienti prežívajú liečbu. Ako kvalitatívne dôkazy správne čítať a používať v nefrologickej praxi.',
    'content'      => <<<'HTML'
<p>Randomizovaná štúdia môže ukázať, či intervencia znižuje riziko klinickej udalosti. Register odhalí, ako často sa udalosť vyskytuje a s čím súvisí. Ani jeden prístup však sám osebe nemusí vysvetliť, ako pacient chápe svoje ochorenie, prečo odmieta navrhovanú liečbu alebo čo mu bráni uskutočniť plán, s ktorým v ambulancii súhlasil.</p>

<p>Práve na takéto otázky je určený kvalitatívny výskum. Skúma významy, skúsenosti, vzťahy a kontext, v ktorom ľudia konajú a rozhodujú sa. V nefrológii môže objasniť liečebnú záťaž, voľbu dialyzačnej modality, prijatie cievneho prístupu, skúsenosť s transplantáciou, obavy darcov, postoje k medikácii alebo rozhodovanie o konzervatívnej starostlivosti.</p>

<p>Kvalitatívne dôkazy nie sú náhradou experimentov, kohort ani štatistického modelovania. Odpovedajú na iný typ otázky. Ich hodnota preto nezávisí od toho, či vytvoria percento alebo p-hodnotu, ale od súladu výskumnej otázky, metodológie, výberu účastníkov, zberu dát a transparentnej interpretácie.</p>

<h2>Nie je to len „malá štúdia s rozhovormi“</h2>

<p>Kvalitatívny výskum je široká skupina metodologických prístupov. Rozhovor alebo fokusová skupina sú metódy zberu dát, nie metodológia sama osebe. Výskumný rámec môže vychádzať napríklad z fenomenológie, zakotvenej teórie, etnografie alebo kvalitatívneho deskriptívneho prístupu. Každý z nich kladie iné otázky a inak pristupuje k analýze.</p>

<p>Medzi bežné zdroje kvalitatívnych dát patria:</p>

<ul>
  <li>individuálne hĺbkové alebo pološtruktúrované rozhovory,</li>
  <li>fokusové skupiny, ktoré zachytávajú aj interakciu medzi účastníkmi,</li>
  <li>priame alebo zúčastnené pozorovanie klinickej praxe,</li>
  <li>denníky, zdravotné záznamy, dokumenty a písomné naratívy,</li>
  <li>audiozáznamy, videozáznamy alebo digitálny obsah, ak zodpovedajú výskumnej otázke.</li>
</ul>

<p>Zmiešaný výskum nie je synonymom kvalitatívneho výskumu. Ide o dizajn, ktorý zámerne prepája kvalitatívne a kvantitatívne časti a integruje ich výsledky. Jednoduché pridanie otvorenej otázky na koniec dotazníka ešte automaticky nevytvára kvalitný zmiešaný dizajn.</p>

<h2>Tri prístupy, tri odlišné druhy odpovedí</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie kvantitatívneho, kvalitatívneho a zmiešaného výskumu" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Oblasť</th>
      <th>Kvantitatívny výskum</th>
      <th>Kvalitatívny výskum</th>
      <th>Zmiešané metódy</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Typická otázka</td>
      <td>koľko, ako často, aký je účinok alebo asociácia</td>
      <td>ako ľudia jav chápu, prežívajú a vysvetľujú</td>
      <td>aký je rozsah javu a ako možno výsledok vysvetliť</td>
    </tr>
    <tr>
      <td>Výber účastníkov</td>
      <td>často pravdepodobnostný alebo podľa presných kritérií</td>
      <td>zvyčajne zámerný výber informačne bohatých prípadov</td>
      <td>podľa logiky každej časti a spôsobu ich integrácie</td>
    </tr>
    <tr>
      <td>Dáta</td>
      <td>merania, kategórie, počty</td>
      <td>text, reč, pozorovanie, obraz alebo dokument</td>
      <td>číselné aj kvalitatívne dáta</td>
    </tr>
    <tr>
      <td>Výstup</td>
      <td>odhad účinku, asociácie, prevalencie alebo predikcie</td>
      <td>témy, koncepty, mechanizmy, model alebo opis skúsenosti</td>
      <td>integrované vysvetlenie alebo návrh intervencie</td>
    </tr>
    <tr>
      <td>Prenos výsledkov</td>
      <td>štatistická zovšeobecniteľnosť podľa dizajnu a výberu</td>
      <td>prenositeľnosť do podobného kontextu po posúdení čitateľom</td>
      <td>závisí od oboch častí a kvality integrácie</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Ako vzniká dôveryhodná kvalitatívna štúdia</h2>

<p>Výber účastníkov býva zámerný: výskumník hľadá ľudí s rozdielnou alebo osobitne informatívnou skúsenosťou. Môže cielene zahrnúť pacientov rôzneho veku, typu liečby, sociálneho zázemia alebo tých, ktorí prijali aj odmietli určitý postup. Cieľom nie je vytvoriť reprezentatívnu miniaturu populácie, ale získať dostatočne bohaté dáta pre zvolenú otázku.</p>

<p>Veľkosť súboru nemožno posúdiť rovnakým výpočtom sily ako v klinickom experimente. Mala by byť zdôvodnená informačnou silou dát, rozsahom otázky, homogenitou účastníkov, kvalitou rozhovorov a analytickým prístupom. Tematická saturácia, teda stav, keď ďalšie dáta neprinášajú významne nové témy, môže byť užitočným konceptom, nie je však univerzálnou ani jedinou podmienkou kvality.</p>

<p>Analýza má byť systematická a dohľadateľná. Výskumníci opisujú, ako vznikali kódy, ako sa z nich vytvorili témy alebo koncepty, ako riešili odlišné interpretácie a či cielene hľadali prípady, ktoré dominantnému vysvetleniu odporovali. Doslovné ukážky výpovedí majú čitateľovi ukázať väzbu medzi dátami a interpretáciou, nie nahradiť samotnú analýzu.</p>

<h2>Reflexivita nie je osobný dodatok</h2>

<p>Výskumník nie je pri kvalitatívnom výskume neviditeľným meracím prístrojom. Jeho profesia, skúsenosti, predpoklady, vzťah k účastníkom a spôsob kladenia otázok môžu ovplyvniť, čo účastníci povedia aj ako sa dáta vyložia. Reflexivita znamená, že tento vplyv výskumný tím priebežne rozpoznáva, dokumentuje a transparentne opisuje.</p>

<p>Napríklad rozhovor o odmietnutí dialýzy môže vyzerať inak, ak ho vedie ošetrujúci nefrológ, nezávislý výskumník alebo človek so skúsenosťou pacienta. Žiadna z týchto pozícií nie je automaticky nesprávna, ale čitateľ potrebuje vedieť, kto dáta vytvoril a z akej perspektívy ich interpretoval.</p>

<h2>Ako štúdiu kriticky čítať</h2>

<p>COREQ a SRQR pomáhajú autorom transparentne uviesť podstatné prvky kvalitatívnej práce. Nie sú však bodovacími systémami, ktoré samy potvrdia metodologickú kvalitu. Pri kritickom čítaní sú užitočné najmä tieto otázky:</p>

<div class="table-responsive" role="region" aria-label="Otázky na kritické hodnotenie kvalitatívnej štúdie" tabindex="0">
<table>
  <thead>
    <tr>
      <th>Oblasť</th>
      <th>Čo overiť</th>
      <th>Varovný signál</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Výskumná otázka</td>
      <td>je kvalitatívny prístup pre otázku vhodný</td>
      <td>témy sa používajú na tvrdenie o účinnosti alebo prevalencii</td>
    </tr>
    <tr>
      <td>Metodológia</td>
      <td>je rámec pomenovaný a konzistentný s metódami</td>
      <td>štúdia uvádza iba „urobili sme rozhovory“</td>
    </tr>
    <tr>
      <td>Výber účastníkov</td>
      <td>kto bol zahrnutý, kto chýba a prečo</td>
      <td>nejasný nábor alebo prehliadnutie dôležitej perspektívy</td>
    </tr>
    <tr>
      <td>Kontext</td>
      <td>pracovisko, zdravotný systém, kultúrne a sociálne podmienky</td>
      <td>čitateľ nevie posúdiť prenositeľnosť</td>
    </tr>
    <tr>
      <td>Zber dát</td>
      <td>kto rozhovory viedol, kde, ako dlho a podľa akého rámca</td>
      <td>vzťah výskumníka k účastníkom nie je uvedený</td>
    </tr>
    <tr>
      <td>Analýza</td>
      <td>ako vznikli kódy a témy a ako sa riešili rozdielne výklady</td>
      <td>témy sa objavia bez vysvetlenia analytického postupu</td>
    </tr>
    <tr>
      <td>Reflexivita</td>
      <td>ako tím zohľadnil vlastný vplyv a predpoklady</td>
      <td>výskumník sa prezentuje ako úplne neutrálny pozorovateľ</td>
    </tr>
    <tr>
      <td>Dôkazy a limity</td>
      <td>sú interpretácie podložené dátami vrátane odlišných prípadov</td>
      <td>selektívne citácie alebo závery presahujúce skúmaný kontext</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Príklad: hospic a dialýza v predstavách nefrológov</h2>

<p>Spravodajský komentár uviedol kvalitatívnu štúdiu hospicovej starostlivosti pri zlyhaní obličiek. Pôvodná práca bola sekundárnou analýzou pološtruktúrovaných rozhovorov s 20 americkými nefrológmi, ktorí sa vyjadrovali k rozhodovaniu u starších pacientov s pokročilou CKD. Výskumníci opätovne analyzovali časti rozhovorov týkajúce sa hospicu pomocou tematickej analýzy s induktívnym vytváraním tém.</p>

<p>V dátach sa objavili dve prepojené témy: nefrológovia často chápali dialýzu a hospic ako vzájomne sa vylučujúce modely a zároveň si neboli istí, kto má viesť rozhovor o hospici a kto má koordinovať takúto starostlivosť. Výpovede poukázali aj na obavy, že nefrologické ani hospicové tímy nemajú dostatočnú prípravu na spoločnú starostlivosť.</p>

<p>Štúdia však neurčila, aký podiel všetkých nefrológov zastáva tieto názory. Účastníci pochádzali z dvoch terciárnych centier a štyroch komunitných praxí v jednom americkom meste; 85 % z nich bolo v publikácii zaradených do kategórie bielych osôb a 75 % tvorili muži. Išlo iba o perspektívu nefrológov, bez rozhovorov s pacientmi, rodinami a hospicovými pracovníkmi. Navyše americké pravidlá úhrady hospicu a dialýzy nie sú priamo prenosné na Slovensko.</p>

<p>Klinický odkaz je napriek tomu užitočný: paliatívna starostlivosť nie je synonymom hospicu a môže sa poskytovať súbežne s dialýzou. Konzervatívna liečba, rozhodnutie nezačať dialýzu, ukončenie dialýzy a hospicová starostlivosť sú odlišné situácie. Kvalitatívny nález pomohol pomenovať bariéry a navrhnúť otázky pre ďalší výskum; sám osebe nevytvoril všeobecné klinické pravidlo.</p>

<h2>Čo môžu kvalitatívne dáta odhaliť v nefrológii</h2>

<ul>
  <li><strong>Voľba modality:</strong> obavy zo zodpovednosti za domácu liečbu, záťaže blízkych, infekcie, katétra alebo nedostatku priestoru.</li>
  <li><strong>Cievny prístup:</strong> význam telesného obrazu, strach z bolesti, predchádzajúce skúsenosti a rozdielne chápanie budúcej potreby dialýzy.</li>
  <li><strong>Medikácia:</strong> liečebná záťaž, nežiaduce účinky, náklady, nedôvera alebo konflikt odporúčania s každodenným režimom.</li>
  <li><strong>Tekutinový a diétny režim:</strong> smäd, kultúrne zvyklosti, dostupnosť potravín, sociálne situácie a vzťah obmedzení ku kvalite života.</li>
  <li><strong>Transplantácia:</strong> obavy darcu a príjemcu, rodinné roly, pocit dlhu, stigma a nerovný prístup k informáciám.</li>
  <li><strong>Konzervatívna starostlivosť:</strong> predstavy o dialýze, prognóze, smrti, záťaži rodiny a prijateľnom výsledku liečby.</li>
</ul>

<p>Tieto príklady sú možné vysvetlenia, nie predpokladané príčiny správania každého pacienta. Kvalitatívny výskum má zmysel práve preto, že namiesto domýšľania bariér systematicky získava perspektívy ľudí, ktorých sa rozhodnutie týka.</p>

<h2>Frekvencia témy nie je jej jedinou hodnotou</h2>

<p>Autori niekedy uvedú, koľko účastníkov určitú skúsenosť opísalo. Takýto počet môže orientovať čitateľa v skúmanom súbore, nemožno ho však meniť na populačnú prevalenciu. Zámerný výber a otvorený spôsob zberu dát na takýto odhad spravidla nie sú určené.</p>

<p>Dôležitá téma nemusí byť najčastejšia. Ojedinelý prípad môže odhaliť bezpečnostné riziko, mechanizmus nerovnosti alebo skúsenosť skupiny, ktorá v bežnej praxi zostáva neviditeľná. Kvalitu témy treba posudzovať podľa analytickej hĺbky, súvislosti s dátami a schopnosti vysvetliť skúmaný jav, nie iba podľa počtu citácií.</p>

<h2>Kedy sú vhodné zmiešané metódy</h2>

<p>Kvalitatívna časť môže najprv identifikovať bariéry a pomôcť vytvoriť dotazník alebo intervenciu, ktorú následne otestuje kvantitatívna štúdia. Opačný postup môže začať nečakaným výsledkom registra alebo klinickej štúdie a rozhovormi potom skúmať, prečo sa intervencia nevyužívala alebo prečo bol účinok medzi pracoviskami rozdielny.</p>

<p>Skutočná sila zmiešaného dizajnu vzniká integráciou. Nestačí publikovať dve paralelné časti. Autori majú ukázať, ako sa výsledky navzájom dopĺňajú, vysvetľujú alebo si odporujú a čo spoločná interpretácia pridáva oproti každému prístupu samostatne.</p>

<h2>Od výskumu ku klinickému rozhovoru</h2>

<p>Otvorené otázky zlepšujú klinickú komunikáciu, ale bežný rozhovor v ambulancii nie je kvalitatívnou výskumnou štúdiou. Je však možné využiť rovnakú zvedavosť a nepredpokladať, že laboratórny výsledok vysvetľuje pacientovo rozhodnutie.</p>

<p>Užitočné otázky môžu znieť:</p>

<ul>
  <li>„Čo je pre vás pri ochorení obličiek momentálne najťažšie?“</li>
  <li>„Ako rozumiete možnostiam, o ktorých sme hovorili?“</li>
  <li>„Čoho sa pri tejto liečbe najviac obávate?“</li>
  <li>„Ktorá časť plánu je vo vašom každodennom živote ťažko uskutočniteľná?“</li>
  <li>„Čo by pre vás znamenal prijateľný výsledok liečby?“</li>
  <li>„Koho chcete zapojiť do rozhodovania?“</li>
</ul>

<p>Odpoveď treba overiť, zhrnúť a premietnuť do konkrétneho plánu. Pri komplexnom rozhodnutí môže byť potrebná dialyzačná sestra, nutričný terapeut, sociálny pracovník, psychológ, transplantačný koordinátor alebo paliatívny tím. Multidisciplinarita má riešiť identifikovanú potrebu, nie iba rozšíriť počet ľudí v miestnosti.</p>

<h2>Limity hlavného zdroja</h2>

<p>Hlavným zdrojom je odborný spravodajský komentár, nie pôvodná štúdia ani systematický prehľad. Upozorňuje na prehliadanú metodologickú oblasť a uvádza ilustratívne príklady, ale nepopisuje systematické vyhľadávanie literatúry ani kritériá výberu citovaných prác.</p>

<p>Preto som metodologické tvrdenia overil v odborných prehľadoch kvalitatívneho výskumu v nefrológii a v odporúčaniach COREQ a SRQR. Príklad hospicovej starostlivosti je interpretovaný podľa pôvodnej štúdie, nie iba podľa spravodajského zhrnutia.</p>

<h2>Záver</h2>

<p>Kvantitatívne a kvalitatívne dôkazy nesúťažia o miesto v jednej hierarchii. Dobre položená otázka určuje, aký dizajn je vhodný. Ak potrebujeme odhadnúť účinok, frekvenciu alebo riziko, potrebujeme kvantitatívny prístup. Ak chceme porozumieť skúsenosti, významu, rozhodovaniu a kontextu, kvalitatívny prístup môže priniesť poznanie, ktoré čísla samy nevytvoria.</p>

<p>Pre nefrológiu je tento rozdiel praktický. Liečba môže byť biologicky účinná a technicky dostupná, no pre pacienta neprijateľná alebo neuskutočniteľná. Kvalitatívny výskum pomáha zistiť prečo, bez toho, aby z jednotlivých výpovedí vytváral falošnú prevalenciu alebo univerzálne pravidlo.</p>

<hr>

<p><em><strong>Hlavný zdroj:</strong> O’Mary L. The Essential Clinical Research You’re Probably Not Reading. <em>Medscape Medical News</em>. 2026. <a href="https://www.medscape.com/viewarticle/essential-clinical-research-youre-probably-not-reading-2026a1000n6a" target="_blank" rel="noopener noreferrer">Odkaz na komentár</a>.</em></p>

<p><em><strong>Metodologické zdroje:</strong> Amir N, McCarthy HJ, Tong A. Qualitative Research in Nephrology: An Introduction to Methods and Critical Appraisal. <em>Kidney360</em>. 2021;2(4):737–741. DOI: 10.34067/KID.0006302020. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8791319/" target="_blank" rel="noopener noreferrer">Plný text</a> · Tong A, Sainsbury P, Craig J. COREQ. <a href="https://pubmed.ncbi.nlm.nih.gov/17872937/" target="_blank" rel="noopener noreferrer">PubMed</a> · O’Brien BC, Harris IB, Beckman TJ, Reed DA, Cook DA. SRQR. <a href="https://pubmed.ncbi.nlm.nih.gov/24979285/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Príklad hospicovej štúdie:</strong> Wachterman MW, Sinha A, Leveille T, Waikar SS, Widera E, Romero K, Bokhour B. Nephrologists’ Perspectives and Experiences with Hospice Among Older Adults with End-Stage Kidney Disease. <em>Journal of the American Geriatrics Society</em>. 2024;72(7):2060–2069. DOI: 10.1111/jgs.18936. <a href="https://pubmed.ncbi.nlm.nih.gov/38777614/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_qualitative_research newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_qualitative_research pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_qualitative_research pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_qualitative_research migration error: ' . $e->getMessage());
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
