<?php
/**
 * add_udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): pacientsky pohľad na
 * udržateľnosť peritoneálnej dialýzy a zelenú nefrológiu.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia_article.php"
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
    'title'        => 'Udržateľná budúcnosť peritoneálnej dialýzy: pacienti, recyklácia a zelená nefrológia',
    'slug'         => 'udrzatelna-peritonealna-dialyza-pacienti-zelena-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pacienti na peritoneálnej dialýze sú ochotní zapájať sa do udržateľnejšej starostlivosti. Potrebujú však jasné pravidlá pre odpad, stabilnú logistiku a digitálne nástroje, ktoré nenahradia klinicky potrebný osobný kontakt.',
    'content'      => <<<'HTML'
<p>Peritoneálna dialýza (PD) je z klinického hľadiska cenná domáca dialyzačná metóda. Pacientovi prináša väčšiu autonómiu, menšiu potrebu pravidelného dochádzania do dialyzačného strediska a pri správnej indikácii aj dobrú kvalitu života. Menej viditeľnou, ale čoraz dôležitejšou témou je jej environmentálna stopa.</p>

<p>Nová práca publikovaná v <em>Journal of Nephrology</em> skúma zelenú nefrológiu priamo z pohľadu pacientov liečených peritoneálnou dialýzou. Autori sa nezamerali iba na technické riešenia, ale na každodennú realitu: čo pacienti doma recyklujú, ako vnímajú dodávky dialyzačného materiálu a aký majú postoj k digitálnej zdravotnej starostlivosti.</p>

<p>Práve pacientsky pohľad je pri PD zásadný. Pacient nie je pasívny prijímateľ logistického systému. Doma skladuje veľké objemy materiálu, manipuluje s obalmi a použitými vakmi, rieši priestorové obmedzenia, čaká na dodávky a zároveň nesie dôsledky každej zmeny v organizácii starostlivosti.</p>

<h2>Prečo sa zelená nefrológia týka aj PD</h2>

<p>Zdravotníctvo významne prispieva k environmentálnej záťaži spotrebou energie, vody, jednorazových pomôcok, dopravou, odpadom a dodávateľskými reťazcami. Nefrológia patrí medzi odbory, v ktorých je táto záťaž mimoriadne viditeľná.</p>

<p>Pri hemodialýze sa prirodzene hovorí najmä o spotrebe vody, elektriny a dialyzačných setov. Peritoneálna dialýza má inú štruktúru záťaže. Znižuje cestovanie pacienta do centra, ale zároveň prináša veľké množstvo roztokov, plastových vakov, kartónov, obalov a pravidelnú domácu distribúciu materiálu.</p>

<p>Udržateľnosť PD preto nemožno riešiť len cez výzvu, aby pacient „viac recykloval“. Potrebné sú bezpečné pravidlá, zrozumiteľná edukácia, premyslený dizajn obalov, logistika bez ohrozenia liečby a realistické digitálne riešenia.</p>

<h2>Dizajn štúdie</h2>

<p>Autori realizovali observačnú štúdiu v dvoch centrách. Použili 17-položkový dotazník pripravený na základe literatúry a expertného vstupu. Dotazník sa zameral na tri oblasti:</p>

<ul>
  <li>recyklačné správanie pacientov,</li>
  <li>logistiku a frekvenciu dodávok dialyzačného materiálu,</li>
  <li>vnímanie telemedicíny a digitálnych informačných nástrojov.</li>
</ul>

<p>Do štúdie bolo zaradených 90 pacientov na peritoneálnej dialýze. Priemerný vek bol 54,4 ± 14,3 roka a muži tvorili 64,4 % súboru. Ide teda o relatívne prakticky uchopiteľnú pacientsku kohortu, nie o abstraktný model environmentálnej záťaže.</p>

<h2>Recyklácia: ochota existuje, hranice musia byť jasné</h2>

<p>Väčšina pacientov uviedla, že recykluje aspoň jeden materiál súvisiaci s PD. Konkrétne išlo o 84,4 % pacientov. Najčastejšie sa recykloval papier (83,3 %) a plastové obaly (66,7 %).</p>

<p>Tento výsledok je povzbudivý. Ukazuje, že pacienti nie sú voči environmentálnej téme ľahostajní a mnohí si svoje bežné domáce recyklačné návyky prenášajú aj do dialyzačnej liečby. Zároveň však štúdia upozorňuje na podstatný bezpečnostný problém.</p>

<p>Až 21,3 % pacientov uviedlo recykláciu vakov s dialyzačným roztokom alebo drenážnych vakov, hoci tieto materiály sú klasifikované ako zdravotnícky odpad. To nie je dôkaz nezodpovednosti pacienta. Skôr je to signál, že systém pacientom nemusí dostatočne jasne vysvetľovať, ktoré materiály možno bezpečne triediť a ktoré už patria do regulovaného zdravotníckeho odpadu.</p>

<p>Pre klinickú prax z toho vyplýva jednoduché pravidlo: dobrá vôľa pacienta nesmie nahradiť bezpečnostný protokol. Recyklácia pri PD musí byť zrozumiteľná, právne a hygienicky bezpečná a prakticky uskutočniteľná v domácnosti.</p>

<h2>Kto recykluje viac?</h2>

<p>Autori nenašli významnú súvislosť medzi recyklačným správaním a vekom, miestom bydliska ani modalitou peritoneálnej dialýzy. Ochota recyklovať teda podľa dostupných údajov nebola vyhradená len mladším pacientom ani konkrétnej technike PD.</p>

<p>To je pre dialyzačné centrá dôležité. Edukácia o odpade a recyklácii by nemala byť selektívna. Nemá sa predpokladať, že starší pacienti o tému nemajú záujem alebo že mladší pacienti automaticky poznajú pravidlá. Každý pacient potrebuje rovnaký, jasný a opakovane dostupný návod.</p>

<p>Rozumným výstupom môže byť jednoduchý lokálny prehľad: čo patrí do papiera, čo do plastu, čo do komunálneho odpadu a čo je zdravotnícky odpad. Takýto dokument má byť prispôsobený miestnym pravidlám nakladania s odpadom, nie iba všeobecným environmentálnym heslám.</p>

<h2>Dodávky materiálu: stabilita je klinická hodnota</h2>

<p>Väčšina pacientov dostávala dialyzačný materiál mesačne. Tento model uviedlo 85,6 % účastníkov a spokojnosť s frekvenciou dodávok bola vysoká: 88,9 % pacientov bolo s nastavením doručovania spokojných.</p>

<p>Z pohľadu systému môže byť lákavé optimalizovať dopravu a znižovať počet jázd, skladovanie alebo emisie. Z pohľadu pacienta však dialyzačný materiál nie je bežný spotrebný tovar. Predvídateľná dodávka znamená bezpečnú liečbu, nižší stres a istotu, že domáca dialýza nebude prerušená pre logistickú chybu.</p>

<p>Environmentálne zmeny v logistike preto musia byť navrhnuté opatrne. Ak majú byť dodávky menej časté, pacient musí mať doma priestor. Ak majú byť častejšie a menšie, nesmie to zvyšovať organizačnú záťaž. Ak sa mení spôsob doručenia, pacient musí vedieť, koho kontaktovať pri výpadku, poškodení zásielky alebo nesúlade v množstve materiálu.</p>

<h2>Doprava sa pri PD nemení na nulu</h2>

<p>Peritoneálna dialýza znižuje počet pravidelných ciest pacienta do dialyzačného strediska. To je jej sociálna, ekonomická aj environmentálna výhoda. Neznamená to však, že dopravná záťaž zmizne. Časť mobility sa presunie do distribučnej siete.</p>

<p>Preto má zelená PD hľadať rovnováhu medzi cestovaním pacienta, dodávkami materiálu, skladovaním v domácnosti a bezpečnosťou liečby. Ideálne riešenie nebude rovnaké pre pacienta v meste, pacienta v odľahlej obci, osamelého seniora alebo pracujúceho pacienta s obmedzeným domácim priestorom.</p>

<p>Praktické zlepšenia môžu zahŕňať lepšie plánovanie trás, presnejšie predvídanie spotreby, znižovanie zbytočných rezerv, ekologickejšie balenie, jasné označenie recyklovateľných obalov a spoluprácu medzi dialyzačným centrom, dodávateľom, výrobcom a lokálnym systémom odpadového hospodárstva.</p>

<h2>Telemedicína: pacienti chcú viac než videohovor</h2>

<p>Štúdia ukázala opatrný postoj pacientov k nahrádzaniu osobných návštev telemedicínou. Až 84,4 % pacientov preferovalo osobné kontroly pred telemedicínou.</p>

<p>Tento výsledok netreba čítať ako odmietnutie digitalizácie. Pacienti môžu súčasne chcieť osobnú kontrolu a zároveň prijímať digitálne informácie, pripomienky alebo bezpečný komunikačný kanál. Zdrojová práca naznačuje, že mladší pacienti boli digitálnym formám informovania otvorenejší.</p>

<p>Pre nefrológa je dôležité rozlíšiť dve veci: telemedicína ako náhrada klinickej kontroly a digitálne nástroje ako doplnok starostlivosti. Pri peritoneálnej dialýze môže videokonzultácia pomôcť pri administratíve, edukácii, kontrole denníka, úprave predpisu alebo rýchlom riešení otázok. Nenahradí však všetko.</p>

<h2>Prečo osobný kontakt zostáva dôležitý</h2>

<p>Peritoneálna dialýza je domáca liečba, ale jej bezpečnosť stojí na pravidelnej odbornej kontrole. Pri osobnej návšteve možno lepšie posúdiť exit-site katétra, techniku výmen, stav hydratácie, nutričný stav, zásoby materiálu, príznaky infekcie, adherenciu aj celkovú kondíciu pacienta.</p>

<p>Osobná kontrola má aj edukačnú a psychologickú hodnotu. Pacient na domácej dialýze nesie veľkú časť liečby sám. Kontrola v centre nie je len „návšteva lekára“, ale aj priestor na korekciu techniky, zachytenie únavy z liečby, posilnenie istoty a prevenciu komplikácií.</p>

<p>Najrozumnejší model je preto hybridný. Osobné návštevy majú zostať tam, kde prinášajú klinickú hodnotu. Digitálne riešenia majú odbremeniť pacienta od zbytočného cestovania, duplicít a administratívy, nie vytlačiť potrebný kontakt so zdravotníckym tímom.</p>

<h2>Čo z toho vyplýva pre dialyzačné centrá</h2>

<p>Výsledky štúdie podporujú praktický, nie deklaratívny prístup k zelenej nefrológii. Dialyzačné centrá by mali mať pre pacientov jasné informácie o tom:</p>

<ul>
  <li>ktoré obaly možno recyklovať,</li>
  <li>ktoré materiály sa majú považovať za zdravotnícky odpad,</li>
  <li>ako bezpečne manipulovať s použitými vakmi,</li>
  <li>ako skladovať materiál doma,</li>
  <li>ako postupovať pri nejasnostiach alebo chybnej dodávke,</li>
  <li>ktoré kontakty použiť pri logistickom alebo technickom probléme.</li>
</ul>

<p>Rovnako dôležité je zapojiť pacientov pred zavedením zmien. Ak centrum zmení dodávky, triedenie odpadu alebo kontrolný režim bez spätnej väzby pacientov, môže vytvoriť systém, ktorý vyzerá environmentálne správne na papieri, ale v domácnosti je nepoužiteľný.</p>

<h2>Nefrologická interpretácia</h2>

<p>Zelená nefrológia nemá byť samostatný projekt oddelený od kvality starostlivosti. Má byť súčasťou klinického rozhodovania. Pri peritoneálnej dialýze to znamená, že environmentálne opatrenia musia rešpektovať infekčnú bezpečnosť, kontinuitu liečby, schopnosti pacienta, domáce podmienky a dostupnosť podpory.</p>

<p>Najväčší priestor na zlepšenie pravdepodobne nie je v moralizovaní pacienta. Je v systémových opatreniach: lepší dizajn obalov, jednoznačné označenie recyklovateľných komponentov, bezpečné oddelenie zdravotníckeho odpadu, optimalizácia distribúcie a digitálne nástroje, ktoré riešia konkrétnu potrebu.</p>

<p>Pacient môže byť partnerom udržateľnej PD len vtedy, ak systém nezamieňa partnerstvo za prenesenie zodpovednosti. Úlohou centra je vytvoriť rámec, v ktorom je environmentálne správanie bezpečné, jednoduché a kompatibilné s liečbou.</p>

<h2>Limity štúdie</h2>

<p>Štúdia bola observačná a zahŕňala 90 pacientov z dvoch centier. Výsledky preto nemožno automaticky preniesť na všetky krajiny, regulačné prostredia, typy dodávok a modely odpadového hospodárstva.</p>

<p>Dotazníkové údaje navyše zachytávajú deklarované správanie a postoje. Tie sa môžu líšiť od reálnej praxe, najmä pri odpade, kde pacient nemusí presne rozlišovať medzi obalom, použitým vakom, kontaminovaným materiálom a lokálnymi pravidlami recyklácie.</p>

<p>Napriek týmto limitom je práca hodnotná. Do diskusie o udržateľnosti prináša hlas pacientov, teda ľudí, ktorí budú environmentálne opatrenia pri domácej dialýze skutočne vykonávať.</p>

<h2>Záver</h2>

<p>Pacienti na peritoneálnej dialýze prejavujú vysokú mieru zapojenia do recyklácie, najmä pri papieri a plastových obaloch. Zároveň časť pacientov recykluje aj materiály, ktoré patria medzi zdravotnícky odpad, čo zdôrazňuje potrebu jasnejšej edukácie a bezpečných pravidiel.</p>

<p>V logistike pacienti oceňujú stabilitu a väčšinou sú spokojní s mesačným doručovaním materiálu. Pri digitálnej starostlivosti preferujú osobné kontroly, ale to nevylučuje využitie digitálnych informácií a doplnkových nástrojov.</p>

<p>Pre klinickú prax je hlavné posolstvo jednoduché: udržateľná peritoneálna dialýza sa nemá robiť „na pacientoch“, ale spolu s pacientmi. Zelená nefrológia bude úspešná len vtedy, ak zostane bezpečná, praktická a klinicky rozumná.</p>

<hr>

<p><em><strong>Zdroj:</strong> Trigo F, Bessa J, Tavares J, Alves R, Carvalho MJ, Gonçalves H, Santos P, Rodrigues A. A sustainable future for peritoneal dialysis: a patient survey on green nephrology. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajag073. doi:10.1093/joneph/aajag073. PMID: 42360195. <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag073/8718965" target="_blank" rel="noopener noreferrer">Oxford Academic</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42360195/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_udrzatelna_pd newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_udrzatelna_pd pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_udrzatelna_pd pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_udrzatelna_pd migration error: ' . $e->getMessage());
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
