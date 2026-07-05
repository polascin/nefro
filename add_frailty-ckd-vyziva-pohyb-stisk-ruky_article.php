<?php
/**
 * add_frailty-ckd-vyziva-pohyb-stisk-ruky_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): multidomain frailty pri CKD,
 * výživa, fyzická aktivita a sila stisku ruky.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_frailty-ckd-vyziva-pohyb-stisk-ruky_article.php"
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
    'title'        => 'Frailty pri chronickej chorobe obličiek: prečo nestačí sledovať iba eGFR',
    'slug'         => 'frailty-ckd-vyziva-pohyb-stisk-ruky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Frailty pri CKD je dynamický viacrozmerný syndróm. Popri eGFR a albuminúrii má zmysel sledovať výživu, fyzickú aktivitu, svalovú silu, psychickú rezervu a sociálne fungovanie pacienta.',
    'content'      => <<<'HTML'
<p>Chronická choroba obličiek nie je len ochorenie glomerulovej filtrácie. U mnohých pacientov ide o systémový stav, ktorý zasahuje svalovú silu, výživu, psychickú odolnosť, sociálne fungovanie a schopnosť zvládať bežné denné aktivity. Práve preto sa v nefrológii čoraz viac diskutuje o pojme <em>frailty</em>, teda krehkosť alebo zraniteľnosť pacienta.</p>

<p>Článok publikovaný v <em>Journal of Nephrology</em> sa venuje longitudinálnemu sledovaniu viacrozmernej frailty u pacientov s chronickou chorobou obličiek. Autori skúmali, ako sa počas 12 mesiacov menia jednotlivé zložky frailty u pacientov s CKD, ktorí ešte neboli liečení dialýzou, a aký význam majú nutričný stav, fyzická aktivita a sila stisku ruky.</p>

<p>Pre klinickú prax je hlavné posolstvo jednoduché: eGFR a albuminúria sú nevyhnutné, ale nestačia. Pacient s rovnakou eGFR môže mať úplne inú funkčnú rezervu, inú toleranciu liečby a iné riziko hospitalizácie podľa toho, či je aktívny, živený, sebestačný a sociálne podporený.</p>

<h2>Frailty ako klinický problém pri CKD</h2>

<p>Frailty je syndróm zníženej fyziologickej rezervy. Pacient s frailty horšie toleruje infekcie, hospitalizácie, operačné výkony, zmeny liečby aj progresiu základného ochorenia. Pri chronickej chorobe obličiek je tento problém mimoriadne dôležitý, pretože CKD urýchľuje biologické starnutie a je spojená s chronickým zápalom, anémiou, metabolickou acidózou, poruchami minerálového metabolizmu, sarkopéniou a malnutríciou.</p>

<p>Autori pripomínajú, že výskyt frailty u pacientov s CKD môže byť veľmi vysoký, najmä v pokročilých štádiách ochorenia. V literatúre sa v niektorých skupinách pacientov s pokročilou CKD uvádza prevalencia až približne 70 %.</p>

<p>Dôležité je, že frailty nie je statická nálepka. Môže sa zhoršovať, stabilizovať alebo zlepšovať. Preto nestačí jednorazovo označiť pacienta ako krehkého. Klinicky cennejšie je sledovať vývoj v čase a hľadať faktory, ktoré sú ovplyvniteľné.</p>

<h2>Viacrozmerný pohľad na krehkosť</h2>

<p>Frailty sa často zužuje na fyzickú slabosť, pomalú chôdzu alebo nízku svalovú silu. Tento prístup je praktický, ale neúplný. Zdrojový článok zdôrazňuje <em>multidomain frailty</em>, teda viacrozmernú krehkosť.</p>

<p>Viacrozmerná frailty zahŕňa fyzickú, psychologickú a sociálnu zložku. Pri CKD to dáva veľký klinický zmysel. Pacient môže mať relatívne stabilnú eGFR, ale zároveň sa môže zhoršovať jeho výživa, ubúdať svalová sila, klesať aktivita, narastať únava alebo sociálna izolácia.</p>

<p>Takýto pacient je klinicky rizikovejší, aj keď samotné laboratórne parametre nemusia dramaticky upozorniť na zmenu stavu. Preto by sa krehkosť mala chápať ako doplnková informácia o biologickom a funkčnom stave pacienta, nie ako samostatná geriatrická poznámka mimo nefrologického rozhodovania.</p>

<h2>Dizajn štúdie</h2>

<p>Autori realizovali longitudinálnu kohortovú štúdiu u pacientov s chronickou chorobou obličiek, ktorí neboli liečení dialýzou.</p>

<p>Do štúdie bolo zaradených 120 pacientov s CKD vo veku nad 20 rokov. Pacienti boli regrutovaní z nefrologickej ambulancie zdravotníckeho centra na južnom Taiwane v období od novembra 2022 do mája 2024.</p>

<p>Cieľom bolo sledovať 12-mesačné trajektórie viacrozmernej frailty a hodnotiť súvislosť medzi zmenami frailty a tromi klinicky ovplyvniteľnými faktormi: nutričným stavom, fyzickou aktivitou a silou stisku ruky.</p>

<h2>Prečo práve výživa, pohyb a sila stisku</h2>

<p>Výber týchto faktorov je veľmi praktický. V nefrologickej ambulancii často sledujeme kreatinín, eGFR, albuminúriu, draslík, bikarbonát, fosfor, hemoglobín a krvný tlak. Menej systematicky však hodnotíme, či pacient chudne, koľko sa hýbe a či mu ubúda svalová sila.</p>

<p>Pritom práve tieto ukazovatele môžu predchádzať klinickému zlomu. Pokles chuti do jedla, úbytok hmotnosti, zníženie aktivity alebo slabší stisk ruky môžu signalizovať, že pacient stráca rezervu ešte predtým, než sa objaví hospitalizácia, pád alebo strata sebestačnosti.</p>

<h2>Nutričný stav</h2>

<p>Malnutrícia pri CKD môže mať viacero príčin. Patrí sem nechutenstvo, urémia, zápal, obmedzujúce diéty, depresia, sociálne faktory, zhoršený chrup, gastrointestinálne ťažkosti aj polyfarmácia.</p>

<p>Zhoršená výživa vedie k strate svalovej hmoty, zníženej imunite, vyššiemu riziku pádov, infekcií a hospitalizácií. Pri CKD je navyše potrebné vyvažovať nutričné odporúčania tak, aby pacient nebol preťažený fosforom, draslíkom alebo sodíkom, ale zároveň neupadol do proteínovo-energetickej malnutrície.</p>

<p>V praxi to znamená, že u pacienta s pokročilejšou CKD nestačí iba zakazovať. Diétne odporúčanie má byť bezpečné, ale aj realistické a výživovo dostatočné. Pri známkach úbytku hmotnosti alebo svalovej hmoty má byť nutričné poradenstvo aktívnou súčasťou nefrologickej starostlivosti.</p>

<h2>Fyzická aktivita</h2>

<p>Znížená fyzická aktivita je u pacientov s CKD častá. Prispieva k nej únava, anémia, dýchavica, neuropatia, kardiovaskulárne ochorenia, bolesti kĺbov, depresívne symptómy a strach z preťaženia.</p>

<p>Primeraná fyzická aktivita však môže pomáhať udržiavať svalovú silu, metabolickú stabilitu, rovnováhu, funkčnú nezávislosť a psychickú odolnosť. Nemusí ísť o športový výkon. U mnohých pacientov má význam pravidelná chôdza, jednoduché silové cvičenia, tréning rovnováhy a individuálne nastavený rehabilitačný plán.</p>

<p>Pre nefrológa je dôležité nepýtať sa iba „bolí vás niečo?“, ale aj „koľko prejdete?“, „zvládnete schody?“, „prestali ste robiť niečo, čo ste predtým zvládali?“ a „bojíte sa pádu?“. Tieto otázky často odhalia riziko skôr než laboratórium.</p>

<h2>Sila stisku ruky</h2>

<p>Sila stisku ruky je jednoduchý, lacný a klinicky použiteľný ukazovateľ svalovej funkcie. V geriatrii aj nefrológii sa používa ako marker sarkopénie a celkovej fyzickej rezervy.</p>

<p>Jej výhodou je praktickosť. Vyšetrenie je rýchle, opakovateľné a pre pacienta málo zaťažujúce. Pokles sily stisku môže signalizovať zhoršenie svalovej kondície ešte predtým, než sa prejaví výrazná strata sebestačnosti.</p>

<p>Samozrejme, sila stisku nie je celý príbeh. Treba ju interpretovať spolu s vekom, pohlavím, dominantnou rukou, neurologickým a ortopedickým stavom. Ako jednoduchý trendový ukazovateľ však môže byť veľmi užitočná.</p>

<h2>Klinický význam pre nefrológa</h2>

<p>Hlavné posolstvo článku je jasné: pacient s CKD má byť hodnotený komplexnejšie ako iba podľa eGFR. Frailty významne ovplyvňuje prognózu, toleranciu liečby a kvalitu života.</p>

<p>V praxi má zmysel u pacientov s CKD, najmä v pokročilejších štádiách, pravidelne sledovať neúmyselný úbytok hmotnosti, chuť do jedla, svalovú silu, schopnosť chôdze, pády alebo neistotu pri chôdzi, únavu, fyzickú aktivitu, depresívne alebo úzkostné príznaky, sociálnu izoláciu a schopnosť zvládať liečebný režim.</p>

<p>Takéto hodnotenie môže odhaliť rizikového pacienta skôr, ako dôjde k hospitalizácii alebo strate sebestačnosti. Zároveň pomáha lepšie nastaviť ciele liečby: inak budeme uvažovať pri robustnom pacientovi s vysokou rezervou a inak pri pacientovi, ktorý má rovnakú eGFR, ale rýchlo stráca funkčnosť.</p>

<h2>Frailty a rozhodovanie o dialýze</h2>

<p>Frailty má veľký význam aj pri rozhodovaní o začatí dialýzy. Nie každý pacient s nízkou eGFR profituje z rovnakého postupu. U krehkých pacientov môže byť začatie dialýzy spojené s vysokým rizikom funkčného poklesu, hospitalizácií a zhoršenia kvality života.</p>

<p>To neznamená, že frailty je dôvodom dialýzu odmietnuť. Znamená to, že rozhodovanie má byť individualizované. Treba hodnotiť biologický stav pacienta, komorbidity, funkčnú rezervu, preferencie pacienta, očakávaný benefit, riziká a dostupnosť podpornej starostlivosti.</p>

<p>Včasné rozpoznanie frailty môže pomôcť pacienta lepšie pripraviť. Predialyzačná starostlivosť by nemala byť iba technickou prípravou cievneho prístupu alebo peritoneálneho katétra. Mala by zahŕňať aj výživu, pohyb, rehabilitáciu, liečbu anémie, úpravu acidózy, prevenciu pádov a psychosociálnu podporu.</p>

<h2>Čo možno ovplyvniť</h2>

<p>Výhodou sledovania multidomain frailty je, že časť rizikových faktorov je ovplyvniteľná. Nefrológ síce nedokáže zmeniť vek pacienta ani všetky komorbidity, ale môže aktívne zasiahnuť do viacerých oblastí.</p>

<p>Prakticky použiteľné intervencie môžu zahŕňať nutričné poradenstvo prispôsobené štádiu CKD, vyhľadávanie proteínovo-energetickej malnutrície, korekciu metabolickej acidózy, liečbu anémie podľa odporúčaní, podporu primeranej fyzickej aktivity, rehabilitáciu alebo fyzioterapiu, prevenciu pádov, liečbu depresie a úzkosti, zjednodušenie liekového režimu a zapojenie rodiny alebo opatrovateľskej podpory.</p>

<p>Najlepšie výsledky pravdepodobne neprinesie jedna izolovaná intervencia, ale kombinovaný prístup. Frailty je viacrozmerná, preto má byť viacrozmerná aj jej liečba.</p>

<h2>Ambulantný praktický checklist</h2>

<p>Pri pacientovi s CKD možno do bežnej kontroly zaradiť krátke otázky a jednoduché merania:</p>

<ul>
  <li>neúmyselný úbytok hmotnosti za posledné mesiace,</li>
  <li>zmena chuti do jedla alebo príjmu bielkovín,</li>
  <li>počet pádov alebo strach z pádu,</li>
  <li>schopnosť chôdze, schodov a bežných domácich aktivít,</li>
  <li>úroveň fyzickej aktivity počas týždňa,</li>
  <li>únava, depresívne príznaky a sociálna izolácia,</li>
  <li>sila stisku ruky alebo iný jednoduchý funkčný test, ak je dostupný.</li>
</ul>

<p>Takýto skríning nemusí predĺžiť ambulanciu neprimerane dlho, ale môže zmeniť klinické rozhodovanie. Ak sa ukáže zhoršovanie, pacient potrebuje nie iba ďalší laboratórny odber, ale aj plán intervencie.</p>

<h2>Dôležitý posun v uvažovaní</h2>

<p>Tento článok zapadá do širšieho trendu modernej nefrológie. Cieľom už nie je iba spomaliť pokles eGFR alebo pripraviť pacienta na dialýzu. Cieľom je zachovať funkčnosť, sebestačnosť, kvalitu života a schopnosť pacienta rozhodovať o vlastnej liečbe.</p>

<p>Pri CKD sa často venuje veľká pozornosť laboratórnym hraniciam. Tie sú nevyhnutné, ale nie postačujúce. Pacient, ktorý je fyzicky slabý, sociálne izolovaný, malnutričný a depresívny, má iné riziko ako pacient s rovnakou eGFR, ale dobrou svalovou silou, stabilnou výživou a zachovanou aktivitou.</p>

<h2>Limity dostupného zdroja</h2>

<p>Verejne dostupný text článku je extrakt advance článku a celý text nie je voľne dostupný. Preto nie je možné spoľahlivo zhrnúť všetky detailné výsledky, štatistické modely, presné hodnoty zmien jednotlivých domén frailty ani všetky charakteristiky pacientov.</p>

<p>Tento slovenský odborný text preto interpretuje najmä overené informácie zo záznamu a dostupného extraktu: cieľ štúdie, dizajn, počet pacientov, sledované faktory a klinický význam témy. Pri citovaní detailných numerických výsledkov nad rámec týchto údajov je vhodné vychádzať z plného textu článku.</p>

<h2>Záver</h2>

<p>Frailty pri chronickej chorobe obličiek je dynamický a viacrozmerný syndróm. Netýka sa iba svalovej slabosti, ale aj psychickej, sociálnej a funkčnej rezervy pacienta. Štúdia z Taiwanu upozorňuje, že u nedialyzovaných pacientov s CKD má zmysel sledovať vývoj frailty v čase a venovať pozornosť ovplyvniteľným faktorom, ako sú výživa, fyzická aktivita a sila stisku ruky.</p>

<p>Pre nefrologickú prax je hlavné posolstvo praktické: eGFR a albuminúria nestačia na úplné posúdenie rizika. Pacienta s CKD treba hodnotiť aj podľa jeho funkčnej rezervy. Včasné rozpoznanie frailty môže pomôcť lepšie načasovať intervencie, pripraviť pacienta na ďalší priebeh ochorenia a zachovať čo najlepšiu kvalitu života.</p>

<hr>

<p><em><strong>Zdroj:</strong> Yueh FR, Xu D, Lee HF, Sung JM, Yen M. Longitudinal trajectories in multidomain frailty among patients with chronic kidney disease. <em>Journal of Nephrology</em>. Publikované online 26. júna 2026; aajag085. doi:10.1093/joneph/aajag085. PMID: 42360837. <a href="https://academic.oup.com/joneph/advance-article/doi/10.1093/joneph/aajag085/8719086" target="_blank" rel="noopener noreferrer">Oxford Academic</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42360837/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>
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
                error_log('add_frailty_ckd newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_frailty_ckd pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_frailty_ckd pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_frailty_ckd migration error: ' . $e->getMessage());
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
