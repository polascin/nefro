<?php
/**
 * add_styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): ultra-dlhodobé prežívanie
 * transplantátu obličky viac ako 40 rokov.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie_article.php"
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
    'title'        => 'Štyridsať rokov s funkčným transplantátom obličky: čo ukazujú ultra-dlhodobí prežívajúci',
    'slug'         => 'styridsat-rokov-transplantat-oblicky-ultra-dlhodobe-prezivanie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Írska kohorta pacientov s funkčným obličkovým štepom po viac ako 40 rokoch ukazuje význam živého darcovstva, nízko nastavenej individualizovanej imunosupresie a celoživotného skríningu kožných nádorov.',
    'content'      => <<<'HTML'
<p>Transplantácia obličky je pre mnohých pacientov s terminálnym zlyhaním obličiek najlepšou formou náhrady funkcie obličiek. Pri hodnotení úspechu sa často sleduje jednoročné, päťročné alebo desaťročné prežívanie štepu. Osobitne cennú skupinu však tvoria pacienti, u ktorých transplantovaná oblička funguje štyridsať rokov a viac.</p>

<p>Nová štúdia publikovaná v <em>Journal of Nephrology</em> analyzuje írsku kohortu pacientov s extrémne dlhým prežívaním obličkového štepu. Je to prakticky dôležitá práca: ukazuje, že veľmi dlhodobá funkcia transplantovanej obličky nie je len historická kuriozita, ale klinicky dosiahnuteľný výsledok pri priaznivých podmienkach, dôslednej dispenzarizácii a individualizovanej imunosupresii.</p>

<p>Pre nefrológa je takýto súbor zaujímavý aj preto, že mení perspektívu. Nejde iba o otázku, ako zabrániť skorému zlyhaniu štepu. Ide o to, ako viesť pacienta celé desaťročia tak, aby sa zachovala funkcia štepu a zároveň sa minimalizovala cena chronickej imunosupresie.</p>

<h2>Kontext írskej transplantológie</h2>

<p>Prvá transplantácia obličky v Írsku bola vykonaná v roku 1964. Autori sa zamerali na pacientov, ktorí podstúpili transplantáciu obličky od 1. januára 1970 do 31. marca 1983. Následné sledovanie bolo vedené až do 31. marca 2023.</p>

<p>Cieľom bolo zistiť, koľko transplantátov prežilo viac ako 40 rokov, aké klinické charakteristiky mali títo pacienti a ktoré faktory boli spojené s ultra-dlhodobým prežívaním štepu.</p>

<p>Takýto časový horizont je vzácny. Moderné transplantologické kohorty majú lepšiu diagnostiku, inú imunosupresiu a pokročilejšiu infekčnú profylaxiu, ale ešte nemusia mať dostatočne dlhé sledovanie na odpoveď, čo sa deje po štyroch desaťročiach.</p>

<h2>Metodika štúdie</h2>

<p>Išlo o retrospektívnu analýzu údajov z írskeho národného registra transplantácií obličiek. Do analýzy boli zahrnuté transplantácie vykonané v uvedenom období.</p>

<p>Celý súbor zahŕňal 428 transplantácií u 394 pacientov. Longitudinálne údaje boli dostupné u 390 pacientov, teda u 98,9 % sledovanej kohorty. To je pri takomto historickom časovom rozpätí veľmi dobrá dostupnosť dát.</p>

<p>Štúdia sa nezameriavala len na samotný fakt prežitia štepu. Sledovala aj klinické charakteristiky ultra-dlhodobých prežívajúcich, funkciu štepu, typ transplantácie a významné komplikácie dlhodobého prežívania.</p>

<h2>Hlavné výsledky</h2>

<p>Zo 428 transplantovaných obličiek prežilo 33 štepov, teda 7,7 %, štyridsať rokov alebo viac. V čase analýzy bolo stále funkčných 25 transplantátov.</p>

<p>Funkcia prežívajúcich štepov bola pozoruhodne dobrá. Medián sérového kreatinínu u pacientov s prežívajúcim transplantátom bol 107 µmol/l, s rozsahom 66 až 322 µmol/l. Tento údaj ukazuje, že časť pacientov mala aj po štyroch desaťročiach funkciu transplantovanej obličky v klinicky veľmi priaznivom pásme.</p>

<p>Multivariačná analýza identifikovala ako významný faktor dlhodobého prežívania typ transplantácie. Transplantácia od živého darcu bola v porovnaní s transplantáciou od mŕtveho darcu spojená s lepším ultra-dlhodobým prežívaním štepu. Odds ratio bolo 3,51, 95 % interval spoľahlivosti 1,17 až 11,1 a hodnota P = 0,027.</p>

<p>Naopak, vek ani pohlavie darcu alebo príjemcu neboli v tejto analýze významne spojené so zlepšeným ultra-dlhodobým prežívaním štepu.</p>

<h2>Živé darcovstvo ako dlhodobá výhoda</h2>

<p>Výsledky podporujú význam transplantácie od živého darcu. Pravdepodobne sa na tom podieľa viacero faktorov: lepšia kvalita štepu, kratší ischemický čas, plánovaný charakter výkonu, lepšia príprava príjemcu, dôkladné vyšetrenie darcu a možnosť optimalizovať klinický stav ešte pred transplantáciou.</p>

<p>Zároveň však štúdia neprináša zjednodušený záver, že ultra-dlhodobé prežívanie je možné iba pri živom darcovi. Aj časť transplantátov od mŕtvych darcov prežila veľmi dlho. Dôležité je preto vnímať živé darcovstvo ako silný priaznivý faktor, nie ako jedinú cestu k dlhodobému úspechu.</p>

<p>Pre prax je to ďalší argument pre aktívnu podporu živého darcovstva vždy, keď je medicínsky, eticky a organizačne možné. Súčasne je to pripomienka, že kvalita celého transplantologického procesu, od výberu darcu až po celoživotné sledovanie, rozhoduje o výsledku po desaťročiach.</p>

<h2>Imunosupresia: po rokoch rozhoduje jemné nastavenie</h2>

<p>Autori zdôrazňujú, že u ultra-dlhodobých prežívajúcich bola funkcia štepu výborná, ak boli pacienti udržiavaní na nízkej úrovni imunosupresie. Tento bod je klinicky zásadný.</p>

<p>Dlhodobá imunosupresia musí chrániť pred rejekciou, ale zároveň nesmie zbytočne zvyšovať riziko infekcií, malignít, metabolických komplikácií, kostného poškodenia a kardiovaskulárnej morbidity. U pacienta desaťročia po transplantácii sa preto postupne mení hlavná otázka: nejde len o to, či imunosupresia funguje, ale či je nastavená na najnižšiu účinnú intenzitu.</p>

<p>Prílišná redukcia môže ohroziť štep, najmä pri imunologicky rizikovom pacientovi alebo pri známkach chronickej aloimunitnej aktivity. Príliš intenzívna liečba však môže zvyšovať kumulatívnu toxicitu. Preto má byť imunosupresia u dlhodobých prežívajúcich pravidelne prehodnocovaná a individualizovaná, nie mechanicky ponechaná bez revízie.</p>

<h2>Kožné nádory ako cena dlhodobého úspechu</h2>

<p>Veľmi dôležitým zistením bola vysoká frekvencia nemelanómových kožných nádorov. Postihovali 22 z 33 pacientov, teda približne 67 % ultra-dlhodobých prežívajúcich pacientov.</p>

<p>Tento údaj je klinicky varovný. Dlhodobá imunosupresia významne zvyšuje riziko kožných malignít, najmä spinocelulárneho a bazocelulárneho karcinómu. U pacientov po transplantácii obličky preto dermatologický skríning nie je doplnková starostlivosť. Je to základná súčasť dlhodobého manažmentu.</p>

<p>Prakticky to znamená pravidelné dermatologické kontroly, edukáciu o fotoprotekcii, aktívne vyhľadávanie nových alebo meniacich sa kožných lézií a nízky prah na odoslanie k dermatológovi. Pri pacientoch s opakovanými kožnými nádormi treba zvážiť aj úpravu imunosupresívnej stratégie v spolupráci s transplantačným centrom.</p>

<h2>Dlhodobé prežívanie nie je len dobrý kreatinín</h2>

<p>Stabilný kreatinín po mnohých rokoch je výborná správa, ale neznamená, že pacient už nepotrebuje intenzívnu odbornú starostlivosť. Riziko sa v čase mení. Menej môže dominovať akútna rejekcia a viac vystupujú do popredia malignity, infekcie, kardiovaskulárne ochorenia, metabolické komplikácie, osteopatia, liekové interakcie a krehkosť vo vyššom veku.</p>

<p>Ultra-dlhodobý prežívajúci pacient po transplantácii je preto úspechom transplantológie, ale aj veľmi špecifickou chronickou populáciou. Vyžaduje nefrologickú a transplantačnú dispenzarizáciu, dobrú komunikáciu s praktickým lekárom, dermatológom, kardiológom a ďalšími odbormi podľa komorbidít.</p>

<p>Najväčšou chybou by bolo považovať pacienta s dlhodobo funkčným štepom za „vyriešeného“. Práve títo pacienti ukazujú, že transplantácia nie je jednorazový výkon, ale celoživotná liečebná stratégia.</p>

<h2>Čo z toho vyplýva pre nefrologickú prax</h2>

<p>Štúdia prináša niekoľko praktických odkazov. Po prvé, prežívanie štepu viac ako 40 rokov je reálne. Nejde iba o izolované kazuistiky, ale o identifikovateľnú skupinu pacientov v národnom registri.</p>

<p>Po druhé, živé darcovstvo má jasný dlhodobý význam a má byť systematicky podporované tam, kde je bezpečné a eticky vhodné. Po tretie, pacient po transplantácii potrebuje celoživotnú špecializovanú starostlivosť, aj keď má dlhodobo stabilnú funkciu štepu.</p>

<p>Po štvrté, udržiavacia imunosupresia musí byť pravidelne prehodnocovaná. Otázkou nemá byť iba „či pacient lieky užíva“, ale či je režim stále primeraný jeho imunologickému riziku, veku, komorbiditám, infekčnej anamnéze a onkologickému riziku.</p>

<h2>Praktický checklist pre dlhodobého príjemcu štepu</h2>

<p>Pri pacientovi desaťročia po transplantácii má nefrologické sledovanie pravidelne zahŕňať:</p>

<ul>
  <li>trend kreatinínu, eGFR a proteinúrie,</li>
  <li>krvný tlak a kardiovaskulárne rizikové faktory,</li>
  <li>kontrolu hladín a toxicity imunosupresív podľa režimu,</li>
  <li>skríning infekčných komplikácií podľa rizika a lokálnych protokolov,</li>
  <li>dermatologický skríning a edukáciu o fotoprotekcii,</li>
  <li>onkologický skríning primeraný veku a imunosupresii,</li>
  <li>metabolické komplikácie vrátane diabetu, dyslipidémie a kostného zdravia,</li>
  <li>liekové interakcie a adherenciu,</li>
  <li>kvalitu života, krehkosť a funkčný stav pacienta.</li>
</ul>

<p>Takýto prístup presúva pozornosť od samotného prežívania štepu k širšiemu cieľu: dlhému, bezpečnému a kvalitnému životu s funkčnou transplantovanou obličkou.</p>

<h2>Limity štúdie</h2>

<p>Štúdia je retrospektívna a hodnotí historickú kohortu pacientov transplantovaných medzi rokmi 1970 až 1983. Transplantologická medicína sa odvtedy zásadne zmenila. Dnes máme iné chirurgické techniky, inú imunosupresiu, lepšiu infekčnú profylaxiu, modernejšiu HLA typizáciu, presnejšiu diagnostiku rejekcie a celkovo odlišný manažment pacienta.</p>

<p>Preto nemožno výsledky mechanicky preniesť na súčasné kohorty. Hodnota práce je však práve v dĺžke sledovania. Moderné registre zatiaľ nemôžu vždy ukázať, čo sa stane po štyridsiatich rokoch. Historická kohorta poskytuje pohľad na otázky, ktoré krátkodobé výsledky nezachytia: čo znamená celoživotná imunosupresia, aká je cena dlhodobého prežívania a aké komplikácie sa stávajú dominantnými po desaťročiach.</p>

<h2>Záver</h2>

<p>Írska kohorta pacientov s transplantovanou obličkou fungujúcou viac ako 40 rokov ukazuje, že ultra-dlhodobé prežívanie štepu je možné. Najvýznamnejším faktorom spojeným s takýmto výsledkom bola transplantácia od živého darcu. U pacientov s dlhodobo funkčným štepom bola funkcia obličky často veľmi dobrá, najmä pri nízkej, individualizovanej udržiavacej imunosupresii.</p>

<p>Zároveň štúdia pripomína cenu dlhodobého úspechu: vysoké riziko nemelanómových kožných nádorov a potrebu celoživotnej komplexnej starostlivosti. Pre nefrológa je hlavným posolstvom rovnováha medzi ochranou štepu, prevenciou komplikácií a kvalitou života pacienta.</p>

<p>Transplantácia obličky môže byť úspešná nielen v rokoch, ale aj v desaťročiach. Aby sa to podarilo, nestačí dobrý operačný výkon. Potrebná je dlhodobá, pozorná a individualizovaná medicína.</p>

<hr>

<p><em><strong>Zdroj:</strong> Madden M, Comerford G, O'Kelly P, Cooney A, O'Neill L, Elhassan EAE, Abdalla A, Traynor C, Conlon PJ, Irish Nephrology Society Research Group. Ultra-long survivors of kidney transplantation: forty years and more of graft function. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajag020. doi:10.1093/joneph/aajag020. PMID: 42360201. <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag020/8718959" target="_blank" rel="noopener noreferrer">Oxford Academic</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42360201/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_styridsat_rokov_transplantat newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_styridsat_rokov_transplantat pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_styridsat_rokov_transplantat pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_styridsat_rokov_transplantat migration error: ' . $e->getMessage());
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
