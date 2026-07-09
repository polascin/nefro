<?php
/**
 * add_postkongres-eha-asco-2026-onkonefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): postkongresový onkologický
 * kontext EHA/ASCO 2026 z pohľadu nefrológie a praktickej onkonefrológie.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_postkongres-eha-asco-2026-onkonefrologia_article.php"
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
    'title'        => 'Postkongresové poznámky z EHA a ASCO 2026: čo majú onkologické novinky spoločné s nefrológiou',
    'slug'         => 'postkongres-eha-asco-2026-onkonefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Moderná onkologická a hematoonkologická liečba zvyšuje potrebu onkonefrologického dohľadu: ICI nefritída, anti-VEGF toxicita, myelómová oblička, CAR-T, TLS aj dávkovanie liekov pri CKD.',
    'content'      => <<<'HTML'
<p>Onkológia a nefrológia sa čoraz výraznejšie prelínajú. Dôvodom nie je iba vyšší vek pacientov a častejšia polymorbidita, ale aj samotná povaha modernej protinádorovej liečby. Imunoterapia, cielené lieky, bunkové terapie, bispecifické protilátky, konjugáty protilátka–liek a intenzívne kombinované režimy prinášajú pacientom významný benefit, no zároveň zvyšujú nároky na sledovanie renálnych nežiaducich účinkov.</p>

<p>Postkongresové onkologické formáty po EHA a ASCO sú preto relevantné aj pre nefrológa. Nie preto, že by mal preberať rolu onkológa alebo hematológa, ale preto, že úspech modernej liečby často závisí od schopnosti bezpečne zvládnuť akútne poškodenie obličiek, proteinúriu, hypertenziu, elektrolytové poruchy, syndróm nádorového rozpadu a dávkovanie liekov pri zníženej funkcii obličiek.</p>

<h2>Prečo má nefrológ sledovať EHA a ASCO</h2>

<p>Kongresy <strong>EHA</strong> (European Hematology Association) a <strong>ASCO</strong> (American Society of Clinical Oncology) patria medzi najvýznamnejšie odborné podujatia v hematológii a klinickej onkológii. Pre nefrológa sú dôležité najmä preto, že nové liečebné stratégie sa často dostávajú do klinickej praxe rýchlejšie, než vzniknú detailné nefrologické algoritmy pre ich komplikácie.</p>

<p>Pacient s nádorovým ochorením môže mať postihnutie obličiek z viacerých príčin:</p>

<ul>
  <li>samotné nádorové ochorenie alebo jeho infiltrácia,</li>
  <li>paraproteinémia, monoklonálna gamapatia alebo mnohopočetný myelóm,</li>
  <li>obštrukcia močových ciest,</li>
  <li>hyperkalciémia,</li>
  <li>syndróm nádorového rozpadu,</li>
  <li>sepsa, hypovolémia alebo dehydratácia,</li>
  <li>opakované vyšetrenia s jódovou kontrastnou látkou,</li>
  <li>nefrotoxická chemoterapia a podporná liečba,</li>
  <li>imunitne podmienená nefritída,</li>
  <li>trombotická mikroangiopatia,</li>
  <li>liekové interakcie,</li>
  <li>preexistujúca chronická choroba obličiek (CKD).</li>
</ul>

<p>Moderná onkologická liečba zlepšuje prežívanie, ale zároveň vytvára novú skupinu pacientov, ktorí potrebujú dlhodobú koordinovanú starostlivosť onkológa, hematológa, nefrológa, klinického farmakológa, intenzivistu a praktického lekára.</p>

<h2>Imunoterapia a obličky</h2>

<p>Jednou z najdôležitejších oblastí sú inhibítory imunitných kontrolných bodov (<em>immune checkpoint inhibitors</em>, ICI). Patria sem lieky zamerané na PD-1, PD-L1 a CTLA-4. Ich účinok spočíva v uvoľnení protinádorovej imunitnej odpovede. Rovnaký mechanizmus však môže vyvolať imunitne podmienené nežiaduce účinky v rôznych orgánoch vrátane obličiek.</p>

<p>Z nefrologického hľadiska je najznámejšia <strong>akútna tubulointersticiálna nefritída</strong>. Môže sa prejaviť vzostupom kreatinínu, niekedy sterilnou leukocytúriou, miernou proteinúriou alebo eozinofíliou, hoci klasické znaky často chýbajú. Klinický obraz býva nešpecifický a diferenciálna diagnostika široká.</p>

<p>Pri pacientovi na imunoterapii treba vždy systematicky zvažovať:</p>

<ul>
  <li>prerenálne príčiny akútneho poškodenia obličiek,</li>
  <li>sepsu alebo systémový zápal,</li>
  <li>obštrukciu močových ciest,</li>
  <li>postkontrastné akútne poškodenie obličiek,</li>
  <li>nefrotoxické antibiotiká a antimykotiká,</li>
  <li>inhibítory protónovej pumpy,</li>
  <li>NSAID a ďalšie voľnopredajné analgetiká,</li>
  <li>progresiu základného ochorenia,</li>
  <li>imunitne podmienenú nefritídu.</li>
</ul>

<p>Biopsia obličky môže byť dôležitá najmä v nejasných prípadoch, pri výraznej proteinúrii, aktívnom močovom sedimente alebo v situácii, keď treba rozhodnúť o pokračovaní protinádorovej liečby. Automaticky pripísať každý vzostup kreatinínu imunoterapii by bolo rovnako chybné ako imunitnú nefritídu prehliadnuť.</p>

<h2>Cielená liečba a renálne riziká</h2>

<p>Cielené protinádorové lieky zasahujú konkrétne signálne dráhy. Ich renálne nežiaduce účinky preto závisia od mechanizmu účinku, farmakokinetiky, kombinovanej liečby a od renálnej rezervy pacienta.</p>

<p>Pri inhibítoroch VEGF a VEGF receptorov sa nefrológ stretáva najmä s:</p>

<ul>
  <li>novou alebo zhoršenou hypertenziou,</li>
  <li>proteinúriou,</li>
  <li>nefrotickým syndrómom,</li>
  <li>trombotickou mikroangiopatiou,</li>
  <li>zhoršením preexistujúcej CKD.</li>
</ul>

<p>Tieto komplikácie sú klinicky významné. Hypertenzia a proteinúria môžu byť v niektorých kontextoch markerom biologickej aktivity liečby, no nie sú dôvodom na pasivitu. Vyžadujú meranie krvného tlaku, kvantifikáciu proteinúrie, úpravu antihypertenzívnej liečby, posúdenie renálneho rizika a v ťažších prípadoch diskusiu o úprave alebo prerušení onkologickej liečby.</p>

<p>Pri inhibítoroch tyrozínkináz treba myslieť aj na elektrolytové poruchy, renálnu dysfunkciu, liekové interakcie cez metabolické dráhy a potrebu úpravy dávok pri zníženej funkcii obličiek. Prakticky dôležitá je najmä pravidelná kontrola kreatinínu, eGFR, močového nálezu, krvného tlaku, draslíka, horčíka a liekov, ktoré pacient užíva mimo onkologickej ambulancie.</p>

<h2>Hematologické malignity a obličky</h2>

<p>EHA je pre nefrológa osobitne dôležitá pre oblasť hematologických malignít. Obličky sú často postihnuté pri mnohopočetnom myelóme, AL amyloidóze, monoklonálnej gamapatii renálneho významu (MGRS), lymfómoch, leukémiách a pri komplikáciách ich liečby.</p>

<p>Pri mnohopočetnom myelóme môže byť renálne postihnutie prvým alebo dominantným prejavom ochorenia. Najtypickejšia je myelómová <em>cast</em> nefropatia, ale spektrum je širšie: zahŕňa AL amyloidózu, chorobu z depozície ľahkých reťazcov, Fanconiho syndróm a iné tubulárne alebo glomerulové poškodenia súvisiace s monoklonálnym proteínom.</p>

<p>Pre prax je zásadné rýchle rozpoznanie kombinácie týchto signálov:</p>

<ul>
  <li>nevysvetlený vzostup kreatinínu,</li>
  <li>proteinúria s disproporčne nízkou albuminúriou,</li>
  <li>hyperkalciémia,</li>
  <li>anémia,</li>
  <li>bolesti kostí alebo patologické fraktúry,</li>
  <li>výrazne zvýšené voľné ľahké reťazce,</li>
  <li>monoklonálny proteín v sére alebo moči.</li>
</ul>

<p>Pri podozrení na myelómovú obličku rozhoduje čas. Rýchle zníženie koncentrácie voľných ľahkých reťazcov môže zlepšiť šancu na renálnu reparáciu. Nefrológ preto nemá čakať, kým sa renálna dysfunkcia „ustáli“, ale má aktívne koordinovať diagnostiku s hematológom.</p>

<h2>CAR-T bunky, bispecifické protilátky a AKI</h2>

<p>Moderná hematoonkologická liečba zahŕňa aj CAR-T bunkové terapie a bispecifické protilátky. Tieto liečby môžu byť veľmi účinné, no prinášajú riziko systémových zápalových a metabolických komplikácií.</p>

<p>Z nefrologického hľadiska sú dôležité najmä:</p>

<ul>
  <li>syndróm uvoľnenia cytokínov,</li>
  <li>hypotenzia a potreba vazopresorov,</li>
  <li>kapilárny leak,</li>
  <li>sepsa alebo infekčné komplikácie,</li>
  <li>syndróm nádorového rozpadu,</li>
  <li>nefrotoxická podporná liečba,</li>
  <li>potreba intenzívnej starostlivosti.</li>
</ul>

<p>Akútne poškodenie obličiek pri týchto stavoch býva často multifaktoriálne. Môže ísť o kombináciu hypoperfúzie, systémového zápalu, tubulárneho poškodenia, liekových vplyvov a metabolických komplikácií. Manažment preto vyžaduje dobrú komunikáciu medzi hematológom, intenzivistom, nefrológom a klinickým farmakológom.</p>

<h2>Syndróm nádorového rozpadu</h2>

<p>Syndróm nádorového rozpadu zostáva jednou z najakútnejších onkonefrologických situácií. Riziko stúpa pri nádoroch s vysokou proliferáciou, veľkou nádorovou masou a vysokou citlivosťou na liečbu. Typicky sa spája s hematologickými malignitami, ale môže sa objaviť aj pri solídnych nádoroch.</p>

<p>Klinicky sú podstatné:</p>

<ul>
  <li>hyperurikémia,</li>
  <li>hyperfosfatémia,</li>
  <li>hypokalciémia,</li>
  <li>hyperkaliémia,</li>
  <li>akútne poškodenie obličiek,</li>
  <li>arytmie, kŕče alebo náhle zhoršenie celkového stavu.</li>
</ul>

<p>Prevencia je účinnejšia ako liečba rozvinutého syndrómu. Zahŕňa rizikovú stratifikáciu, hydratáciu podľa kardiálneho a renálneho stavu, časté monitorovanie elektrolytov, inhibítor xantínoxidázy alebo urikolytickú liečbu podľa rizika a včasné zapojenie nefrológa pri vzostupe kreatinínu alebo závažných elektrolytových poruchách.</p>

<h2>Dávkovanie liekov pri zníženej funkcii obličiek</h2>

<p>Jednou z prakticky najčastejších úloh nefrológa v onkologickej starostlivosti je pomoc s dávkovaním liekov pri CKD alebo akútnom poškodení obličiek. Nejde iba o cytostatiká. Rovnako dôležité sú antibiotiká, antivirotiká, antimykotiká, analgetiká, antikoagulanciá, antiemetiká a podporná liečba.</p>

<p>Pri onkologickom pacientovi môže byť odhad eGFR problematický. Sérový kreatinín môže byť nízky pri sarkopénii, malnutrícii alebo kachexii, takže eGFR môže skutočnú renálnu funkciu nadhodnotiť. To je klinicky dôležité, pretože nesprávny odhad môže viesť k predávkovaniu lieku a toxicite.</p>

<p>U rizikových pacientov má zmysel zvážiť:</p>

<ul>
  <li>opakované hodnotenie trendu kreatinínu a diurézy,</li>
  <li>cystatín C, ak je dostupný a klinicky vhodný,</li>
  <li>pri niektorých liekoch terapeutické monitorovanie hladín,</li>
  <li>konzultáciu klinického farmakológa,</li>
  <li>zohľadnenie telesnej kompozície, hydratácie a dynamiky ochorenia.</li>
</ul>

<h2>Onkonefrológia ako praktická potreba</h2>

<p>Postkongresové onkologické novinky majú pre nefrológiu jeden spoločný odkaz: onkonefrológia už nie je okrajová téma. Pacienti s nádorovým ochorením žijú dlhšie, dostávajú komplexnejšie liečebné režimy a častejšie majú súčasne CKD, diabetes, hypertenziu alebo kardiovaskulárne ochorenie.</p>

<p>V praxi by mala byť spolupráca nastavená tak, aby nefrológ nebol privolaný až pri ťažkom akútnom poškodení obličiek. Skoré zapojenie je vhodné najmä pri týchto rizikových situáciách:</p>

<ul>
  <li>CKD G3b až G5,</li>
  <li>významná albuminúria alebo proteinúria,</li>
  <li>prekonané AKI,</li>
  <li>jediná funkčná oblička,</li>
  <li>myelóm alebo monoklonálna gamapatia,</li>
  <li>plánovaná liečba s renálnym rizikom,</li>
  <li>pretrvávajúca hypertenzia počas anti-VEGF liečby,</li>
  <li>opakovaná potreba kontrastných vyšetrení,</li>
  <li>vysoké riziko syndrómu nádorového rozpadu.</li>
</ul>

<h2>Praktický rámec pre nefrologickú ambulanciu</h2>

<p>Pri pacientovi s onkologickou alebo hematoonkologickou liečbou má zmysel zaviesť jednoduchý, ale dôsledný systém sledovania. Mal by zahŕňať:</p>

<ul>
  <li>vstupné zhodnotenie eGFR a albuminúrie alebo proteinúrie,</li>
  <li>močový sediment pri vzostupe kreatinínu,</li>
  <li>pravidelné meranie krvného tlaku,</li>
  <li>kontrolu elektrolytov,</li>
  <li>posúdenie nefrotoxických liekov a voľnopredajných prípravkov,</li>
  <li>zhodnotenie rizika kontrastných vyšetrení,</li>
  <li>jasný plán pri vzostupe kreatinínu,</li>
  <li>dohodu s onkológom alebo hematológom o hraniciach pre úpravu liečby.</li>
</ul>

<p>Dôležité je aj poučenie pacienta. Mal by vedieť, že má hlásiť pokles diurézy, opuchy, výraznú slabosť, hnačky, vracanie, horúčku, novú dýchavicu alebo náhle zhoršenie krvného tlaku. V onkonefrológii často nerozhoduje iba samotná hodnota kreatinínu, ale rýchlosť zmeny a kontext liečby.</p>

<h2>Čo nemožno zo zdroja spoľahlivo vyvodiť</h2>

<p>Verejne dostupné zobrazenie stránky STREAMED UP potvrdzuje názov formátu „Post-Kongress: EHA und ASCO 2026“, kanál OnkoLive a informáciu, že na zobrazenie obsahu je potrebný účet. Neuvádza však spoľahlivo kompletný obsah videa, mená prednášajúcich ani zoznam prezentovaných štúdií.</p>

<p>Z tohto dôvodu tento text nepridáva neoverené mená, čísla, výsledky štúdií ani citácie. Ide o odborný komentár k postkongresovej onkologickej téme z pohľadu nefrológie, nie o doslovné zhrnutie uzamknutého videa.</p>

<h2>Záver</h2>

<p>Postkongresové novinky z EHA a ASCO 2026 sú dôležité aj pre nefrológiu. Moderná onkologická a hematoonkologická liečba prináša pacientom lepšiu prognózu, ale zároveň zvyšuje riziko renálnych komplikácií. Nefrológ musí poznať najmä riziká imunoterapie, anti-VEGF liečby, cielených liekov, CAR-T terapií, bispecifických protilátok, syndrómu nádorového rozpadu a dávkovania liekov pri zníženej funkcii obličiek.</p>

<p>Kľúčové je skoré zapojenie nefrológa, presná diferenciálna diagnostika akútneho poškodenia obličiek, pravidelné sledovanie proteinúrie a krvného tlaku a úzka komunikácia s onkológom alebo hematológom. Onkonefrológia sa tak stáva nevyhnutnou súčasťou modernej starostlivosti o onkologického pacienta.</p>

<hr>

<p><em><strong>Zdroj:</strong> STREAMED UP / OnkoLive: „Post-Kongress: EHA und ASCO 2026“, online postkongresový odborný formát. Verejné zobrazenie stránky dňa 9. júla 2026 uvádzalo, že na zobrazenie obsahu je potrebný účet; mená prednášajúcich ani zoznam prezentovaných štúdií neboli v dostupnom zobrazení spoľahlivo uvedené. <a href="https://streamed-up.com/video/post-kongress-eha-und-asco-2026" target="_blank" rel="noopener noreferrer">STREAMED UP</a>.</em></p>
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
                error_log('add_postkongres_eha_asco newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_postkongres_eha_asco pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_postkongres_eha_asco pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_postkongres_eha_asco migration error: ' . $e->getMessage());
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
