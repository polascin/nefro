<?php
/**
 * add_porovnanie-usmerneni-lupusova-nefritida-acr-eular-kdigo_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_porovnanie-usmerneni-lupusova-nefritida-acr-eular-kdigo_article.php"
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
    'title'        => 'Porovnanie troch hlavných usmernení pre lupusovú nefritídu: ACR 2025, EULAR 2025 a KDIGO 2024',
    'slug'         => 'porovnanie-usmerneni-lupusova-nefritida-acr-eular-kdigo',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Tri veľké medzinárodné odporúčania pre lupusovú nefritídu (ACR, EULAR, KDIGO) vychádzajú zo spoločného dôkazového základu, no v niekoľkých bodoch sa významne rozchádzajú — najmä pri výbere úvodného režimu (trojkombinácia verzus dvojkombinácia), miere využitia klinického profilu a tempe hodnotenia liečebnej odpovede.',
    'content'      => <<<'HTML'
<p>Nedávna komparatívna analýza ukazuje, že tri „veľké“ medzinárodné odporúčania pre lupusovú nefritídu (LN) vychádzajú zo spoločného dôkazového základu, no v niekoľkých miestach sa významne rozchádzajú. Tieto rozdiely následne menia praktické rozhodovanie pri výbere režimu, miere využitia klinického profilu pacienta aj pri cieľoch liečby v čase. Nasledujúci text sumarizuje hlavné zhody a odlišnosti z hľadiska klinickej použiteľnosti.</p>

<h2>Diagnostika a sledovanie: rovnaký princíp, odlišná operacionalizácia</h2>

<p>Všetky tri usmernenia podporujú prísne sledovanie renálneho postihnutia u pacientov so systémovým lupus erythematosus (SLE).</p>

<ul>
  <li><strong>ACR</strong> preferuje <strong>fixný harmonogram</strong> hodnotení každých <strong>6 až 12 mesiacov</strong>.</li>
  <li><strong>EULAR aj KDIGO</strong> idú skôr cestou <strong>individualizovaného, rizikovo orientovaného monitorovania</strong>.</li>
</ul>

<p><strong>Biopsia obličky</strong> je pri podozrení na LN konzistentne odporúčaná naprieč všetkými tromi zdrojmi, typicky najmä vtedy, ak:</p>

<ul>
  <li>proteinúria presahuje <strong>0,5 g/deň</strong>, alebo</li>
  <li>dochádza k <strong>poklesu funkcie obličiek</strong>.</li>
</ul>

<p><strong>KDIGO</strong> pritom kladie väčší dôraz na <strong>detailné, „kompartmentové“ histologické hodnotenie</strong>, aby sa liečba dala cielene prispôsobiť.</p>

<h2>Úvodná imunosupresia pri proliferatívnej LN: zhoda na eskalácii, rozdiel vo východiskovom režime</h2>

<p>Pri proliferatívnej forme LN všetky tri usmernenia podporujú <strong>včasnú a intenzívnu kombinovanú liečbu</strong>.</p>

<h3>Spoločný základ</h3>

<ul>
  <li><strong>hydroxychlorochín (HCQ)</strong> ako základ liečby,</li>
  <li><strong>glukokortikoidy</strong> s dôrazom na <strong>rýchlu minimalizáciu dávky steroidov</strong>.</li>
</ul>

<p>Všetky tri rámce uvádzajú použitie <strong>krátkych intravenóznych pulzov metylprednizolónu</strong> (v rozmedzí <strong>250 až 1000 mg denne počas najviac 3 dní</strong>), následne prechod na perorálne glukokortikoidy a <strong>zrýchlené znižovanie dávky (taperovanie)</strong> tak, aby sa približne do <strong>4 až 6 mesiacov</strong> dosiahla dávka <strong>5 mg/deň alebo nižšia</strong>.</p>

<h3>Odlišnosti v úvodných režimoch (trojkombinácia verzus dvojkombinácia)</h3>

<p>Tu sú rozdiely klinicky najcitlivejšie:</p>

<ul>
  <li><strong>ACR</strong> preferuje <strong>úvodnú trojkombináciu</strong>, typicky s <strong>mykofenolát-mofetilom (MMF)</strong> a pridaním <strong>buď belimumabu, alebo kalcineurínového inhibítora (CNI)</strong>.</li>
  <li><strong>EULAR</strong> tiež podporuje skorú intenzívnu liečbu, no ako prvú líniu uvádza <strong>MMF + obinutuzumab</strong> — to je prakticky kľúčový rozdiel oproti ACR aj KDIGO, ktoré obinutuzumab do odporúčaní nezahŕňajú.</li>
  <li><strong>KDIGO</strong> explicitne uznáva ako prvú líniu aj <strong>dvojkombináciu</strong>, ktorá môže zahŕňať <strong>nízkodávkovaný cyklofosfamid</strong> alebo <strong>MMF</strong>.</li>
</ul>

<h3>Rituximab a obinutuzumab</h3>

<ul>
  <li><strong>Rituximab</strong> nie je odporúčaný ako prvá línia v žiadnom z troch usmernení; dôvodom sú negatívne výsledky štúdie <strong>LUNAR</strong> (rutinne sa teda nepoužíva ako východiskový krok).</li>
  <li><strong>Obinutuzumab</strong> je naopak špecifický pre EULAR, čo odráža rozdiely v interpretácii a zapracovaní dostupných dát.</li>
</ul>

<h2>Klinické profilovanie: ACR najpreskriptívnejšie, EULAR opatrnejšie</h2>

<p>Rozdiely sa netýkajú len toho, aký liek zvoliť, ale aj toho, <strong>ako striktne</strong> sa má rozhodovanie opierať o klinický profil pacienta.</p>

<ul>
  <li><strong>ACR</strong> poskytuje <strong>najkonkrétnejšie odporúčania</strong>:
    <ul>
      <li>pri <strong>ťažkej proteinúrii (3 g/deň alebo viac)</strong> preferuje režimy založené na <strong>CNI</strong>,</li>
      <li>pri <strong>výraznom extrarenálnom postihnutí</strong> alebo pri <strong>zníženej funkcii obličiek</strong> uprednostňuje <strong>belimumab</strong>.</li>
    </ul>
  </li>
  <li><strong>KDIGO</strong> tiež zohľadňuje charakteristiky pacienta (vrátane napríklad <strong>etnicity</strong> a <strong>rizika recidívy</strong>), no je <strong>menej preskriptívne</strong> v konkrétnych algoritmoch.</li>
  <li><strong>EULAR</strong> pristupuje <strong>opatrnejšie</strong> — zdôrazňuje, že niektoré „profilové“ závery môžu stáť na <em>post-hoc</em> analýzach s obmedzenou interpretáciou.</li>
</ul>

<h2>Liečebné ciele a časové rámce: zhoda na „kompletnej odpovedi“, rozdiel v tempe hodnotenia</h2>

<p>Všeobecná zhoda je v definícii:</p>

<ul>
  <li><strong>kompletná renálna odpoveď</strong>: <strong>proteinúria &lt; 0,5 g/deň</strong> pri stabilnej funkcii obličiek.</li>
</ul>

<p>Tempo, do ktorého sa má tento cieľ dosiahnuť, však vnímajú odlišne:</p>

<ul>
  <li><strong>KDIGO aj ACR</strong> zdôrazňujú dosiahnutie v horizonte <strong>6 až 12 mesiacov</strong>.</li>
  <li><strong>EULAR</strong> používa praktickejší priebežný cieľ: <strong>proteinúria &lt; 0,7 g/deň v 12. mesiaci</strong> ako referenčný bod na rutinné vyhodnotenie.</li>
</ul>

<h2>Súhrnné porovnanie</h2>

<table>
  <thead>
    <tr>
      <th>Oblasť</th>
      <th>ACR</th>
      <th>EULAR</th>
      <th>KDIGO</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Monitorovanie</strong></td>
      <td>Skôr <strong>fixný harmonogram</strong> hodnotení (typicky každých <strong>6 až 12 mesiacov</strong>)</td>
      <td>Viac <strong>individualizovaný, rizikovo orientovaný</strong> prístup</td>
      <td>Rizikovo orientované monitorovanie, praktický dôraz na načasovanie</td>
    </tr>
    <tr>
      <td><strong>Prvolíniový režim (proliferatívna LN)</strong></td>
      <td>Skôr <strong>úvodná trojkombinácia</strong> (HCQ + glukokortikoidy + imunosupresia; jadro často <strong>MMF</strong>, doplnenie podľa profilu: <strong>belimumab alebo CNI</strong>)</td>
      <td>Skôr <strong>MMF + obinutuzumab</strong> (v komparácii uvádzané ako kľúčový rozdiel)</td>
      <td>Uznáva aj <strong>dvojkombináciu</strong> ako prvú líniu (napr. <strong>nízkodávkovaný cyklofosfamid</strong> alebo <strong>MMF</strong>)</td>
    </tr>
    <tr>
      <td><strong>Miesto obinutuzumabu</strong></td>
      <td>Nie je východiskový v prvej línii</td>
      <td><strong>Súčasť prvej línie</strong></td>
      <td>Nie je v jadre odlišujúcim prvkom oproti ostatným v tejto komparácii</td>
    </tr>
    <tr>
      <td><strong>Miesto rituximabu</strong></td>
      <td>Nie ako prvá línia (uvádza sa negatívny dosah dát typu <strong>LUNAR</strong>)</td>
      <td>Nie ako prvá línia</td>
      <td>Nie ako prvá línia v rámci komparácie</td>
    </tr>
    <tr>
      <td><strong>Profilovanie pacienta</strong></td>
      <td><strong>Najpreskriptívnejšie</strong> odporúčania podľa profilu (napr. váha proteinúrie)</td>
      <td><strong>Opatrnejšie</strong> pri profilových záveroch</td>
      <td>Zohľadňuje viac faktorov, no je <strong>menej algoritmické</strong> v detailoch</td>
    </tr>
    <tr>
      <td><strong>Liečebný cieľ a časový rámec</strong></td>
      <td>Kompletná renálna odpoveď: <strong>proteinúria &lt; 0,5 g/deň</strong> pri stabilnej funkcii; hodnotenie v horizonte <strong>6 až 12 mesiacov</strong></td>
      <td>Praktický cieľový rámec; uvádza sa referenčný bod <strong>proteinúria &lt; 0,7 g/deň v 12. mesiaci</strong></td>
      <td>Kompatibilné s rámcom kompletnej renálnej odpovede a hodnotením v horizonte <strong>6 až 12 mesiacov</strong></td>
    </tr>
    <tr>
      <td><strong>Biopsia a histológia</strong></td>
      <td>Biopsia najmä pri podozrení na aktívnu LN so závažnejšími parametrami (prah typicky <strong>proteinúria &gt; 0,5 g/deň</strong> a/alebo pokles funkcie)</td>
      <td>Podobný koncept potreby biopsie pri klinickej indikácii</td>
      <td>Biopsia s dôrazom na detailné „kompartmentové“ histologické hodnotenie pre čo najcielenejšiu liečbu</td>
    </tr>
    <tr>
      <td><strong>Eskalačné kroky / zmena stratégie</strong></td>
      <td>Po úvodnej imunosupresii sa nastavuje tempo hodnotenia (6 až 12 mesiacov); pri nedostatočnej odpovedi sa zvažuje úprava stratégie (presun medzi režimami / eskalácia intenzity)</td>
      <td>Podobný princíp s dôrazom na priebežné vyhodnotenie odpovede v čase a následnú úpravu podľa rizika a odpovede</td>
      <td>Dôraz na štruktúrovanú stratifikáciu; pri nedostatočnej odpovedi logika „uprav a prehodnoť“ (úprava typu a intenzity imunosupresie)</td>
    </tr>
    <tr>
      <td><strong>Rezervné lieky (nie prvá línia)</strong></td>
      <td>Rituximab nie je prvá línia; skôr neskoršia/alternatívna možnosť pri zlyhaní alebo intolerancii prvolíniových prístupov</td>
      <td>Rituximab tiež nie je prvá línia (komparácia rieši najmä jeho neštandardnosť ako prvolíniovej liečby)</td>
      <td>Rituximab tiež nie je prvá línia; neskoršie použitie závisí od klinického kontextu</td>
    </tr>
    <tr>
      <td><strong>Renoprotekcia</strong></td>
      <td>Spoločný rámec: kontrola krvného tlaku, <strong>blokáda RAAS</strong>, selektívne zváženie <strong>inhibítorov SGLT2</strong></td>
      <td>Rovnaký princíp — praktická renoprotekcia popri imunosupresii</td>
      <td>Rovnaký spoločný základ: cieľový krvný tlak, RAAS, selektívne SGLT2</td>
    </tr>
  </tbody>
</table>

<h2>Membranózna (trieda V) LN: najväčšie medzery v dôkazoch</h2>

<p>Tu komparácia priamo poukazuje na citeľný nedostatok robustných dát:</p>

<ul>
  <li>naprieč odporúčaniami <strong>neexistuje všeobecne prijatá stratégia</strong>,</li>
  <li><strong>EULAR</strong> lieči triedu V podobne ako proliferatívne ochorenie,</li>
  <li><strong>ACR a KDIGO</strong> sa viac riadia závažnosťou proteinúrie:
    <ul>
      <li>pri proteinúrii <strong>&gt; 1 g/deň</strong> ACR odporúča <strong>úvodnú trojkombináciu</strong> (glukokortikoidy + MMF + CNI),</li>
      <li>KDIGO preferuje <strong>dvojkombinovanú imunosupresiu</strong>.</li>
    </ul>
  </li>
</ul>

<h2>Triedy I–II LN: praktická šedá zóna</h2>

<ul>
  <li>pre <strong>triedy I a II</strong> nie sú usmernenia v komparácii explicitné v odporúčaniach (ide o „šedú zónu“),</li>
  <li><strong>KDIGO</strong> však spomína koncept <strong>lupusovej podocytopatie</strong> u pacientov s triedou I–II, ak sa pridá <strong>nefrotická proteinúria</strong> alebo <strong>nefrotický syndróm</strong>,</li>
  <li>pri recidívach KDIGO odporúča udržiavaciu stratégiu: <strong>nízkodávkové glukokortikoidy</strong> a ďalší imunosupresívny liek (<strong>MMF, azatioprín alebo CNI</strong>).</li>
</ul>

<h2>Renoprotektívna liečba: spoločný rámec bez ohľadu na hlavný režim</h2>

<p>Okrem imunosupresie všetky tri dokumenty zdôrazňujú renoprotekciu:</p>

<ul>
  <li>kontrola krvného tlaku na približne <strong>&lt; 120–130/80 mmHg</strong>,</li>
  <li><strong>blokáda systému renín-angiotenzín (RAAS)</strong>,</li>
  <li>selektívne zváženie <strong>inhibítorov SGLT2</strong>.</li>
</ul>

<h2>Praktický dosah do bežnej ambulancie</h2>

<p>Komparácia posúva jednu myšlienku: hoci cieľ je spoločný (včas potlačiť aktívnu zápalovú aj fibrotizujúcu kaskádu a udržať bezpečnosť liečby), <strong>spôsob, akým sa volí režim</strong>, sa môže líšiť podľa toho:</p>

<ul>
  <li>či sa ako východisko preferuje trojkombinácia alebo dvojkombinácia,</li>
  <li>akú váhu dostane klinické profilovanie,</li>
  <li>a aké tempo sa nastaví pre hodnotenie odpovede.</li>
</ul>

<p>To vysvetľuje, prečo sa v odbornej komunite stále diskutuje, či by sa štandardom mala stať „trojkombinácia pre všetkých“, alebo či je lepšie flexibilné, rizikovo orientované prispôsobenie.</p>

<hr>

<p><em><strong>Zdroj:</strong> <em>Nephrology Dialysis Transplantation</em> (komparatívny článok referovaný v Renal &amp; Urology News): „Three Major Lupus Nephritis Guidelines Agree, Differ on Treatment“. <a href="https://www.renalandurologynews.com/news/three-major-lupus-nephritis-guidelines-agree-differ-treatment/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
            // Vygeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
            // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
            try {
                $pdfRes = generateArticlePdf($pdo, $a + ['id' => $newId], true);
                if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                    error_log('add_article pdf gen: ' . $pdfRes['error']);
                }
            } catch (\Throwable $pe) {
                error_log('add_article pdf gen error: ' . $pe->getMessage());
            }
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . ($articles[0]['title']) . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted z $total článkov bolo vložených.\n";
    echo "Preskočení (slug už existuje): $skipped\n";
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
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
