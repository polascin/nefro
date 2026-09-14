<?php
/**
 * add_sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect_article.php
 * Idempotentný publikačný skript odborného článku.
 * Spracovanie NDT 2026 (Ayoub et al.; PMID 42726023) — SPARTACUS + PROTECT OLE.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Sparsentan so SGLT2 inhibítorom pri IgA nefropatii: SPARTACUS a PROTECT OLE',
    'slug'         => 'sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pri IgA nefropatii výmena RASi za sparsentan pri stabilnom SGLT2i v SPARTACUS výrazne znížila albuminúriu; v PROTECT OLE pridanie SGLT2i k sparsentanu prinieslo ďalší mierny pokles proteinúrie.',
    'content'      => <<<'HTML'
<p><strong>Sparsentan</strong> (duálny antagonista endotelínového a angiotenzínového receptora, DEARA) a <strong>inhibítory sodíkovo-glukózového kotransportéra 2 (SGLT2i)</strong> znižujú proteinúriu pri IgA nefropatii (IgAN). V <em>Nephrology Dialysis Transplantation</em> (2026) Ayoub a kol. zhrnuli účinnosť a bezpečnosť ich kombinácie v dvoch komplementárnych nastaveniach: v otvorenej štúdii fázy 2 <strong>SPARTACUS</strong> a v randomizovanej substúdii otvoreného predĺženia (OLE) štúdie <strong>PROTECT</strong>. Text vychádza z publikačného abstraktu a má sa čítať opatrne – najmä pri extrapolácii na tvrdé obličkové alebo kardiovaskulárne ukazovatele.</p>

<h2>Najdôležitejšie odkazy</h2>

<ul>
  <li>V <strong>SPARTACUS</strong> (NCT05856760) sa u pacientov so stabilným SGLT2i vymenil inhibítor systému renín–angiotenzín (RASi) za sparsentan. Do 24.&nbsp;týždňa klesol pomer albumínu ku kreatinínu v moči (UACR) o LS mean <strong>−56&nbsp;%</strong> (95&nbsp;% interval spoľahlivosti [IS] −66&nbsp;% až −3&nbsp;%).</li>
  <li>V substúdii <strong>PROTECT OLE</strong> (NCT03762850) pridanie SGLT2i k stabilnému sparsentanu v 12.&nbsp;týždni prinieslo relatívne priaznivejšiu zmenu pomeru proteínu ku kreatinínu v moči (UPCR) oproti samotnému sparsentanu (pomer 0,75; 95&nbsp;% IS 0,58–0,98; <em>P</em>&nbsp;&lt;&nbsp;0,05).</li>
  <li>Kombinácia bola podľa abstraktu <strong>dobre tolerovaná</strong>; závažné alebo vážne nežiaduce udalosti súvisiace s liečbou boli zriedkavé a neočakávané bezpečnostné signály sa nehlásili.</li>
  <li>Ide o <strong>náhradné (surrogátne) ukazovatele</strong> (UACR/UPCR) a relatívne krátke sledovanie. Samostatný dôkaz o spomalení poklesu eGFR, zlyhaní obličiek či kardiovaskulárnych príhodách z týchto dát nevyplýva.</li>
</ul>

<h2>Prečo má kombinácia DEARA + SGLT2i zmysel</h2>

<p>Sparsentan blokuje endotelínový receptor typu&nbsp;A a receptor angiotenzínu&nbsp;II typu&nbsp;1. SGLT2 inhibítory pôsobia cez tubuloglomerulárnu spätnú väzbu, znižujú intraglomerulárny tlak a majú ďalšie systémové účinky. Pri IgAN sa obe cesty používajú ako neimunosupresívna nefroprotekcia; otázka <strong>sekvencie a súčtu účinkov</strong> (výmena RASi za sparsentan pri už užívanom SGLT2i vs. pridanie SGLT2i k sparsentanu) však ešte nebola dostatočne zodpovedaná v bežnej praxi.</p>

<p>SPARTACUS a PROTECT OLE odpovedajú práve na tieto dve praktické situácie – nie sú to však veľké štúdie tvrdej klinickej účinnosti ani priame porovnanie s inými modernými režimami (napr. cieľová imunomodulácia podľa KDIGO).</p>

<h2>SPARTACUS: výmena RASi za sparsentan pri stabilnom SGLT2i</h2>

<p>SPARTACUS bola <strong>fáza&nbsp;2, otvorená</strong> štúdia. Pacienti mali RASi nahradený sparsentanom a pokračovali v stabilnej liečbe SGLT2i. Zaradených bolo <strong>48</strong> pacientov (priemerný vek 48,9&nbsp;rokov, SD 13,9; 58&nbsp;% mužov); liečbu dokončilo <strong>39</strong>.</p>

<p>Výmena RASi za sparsentan viedla k <strong>rýchlemu a do 24.&nbsp;týždňa udržanému poklesu UACR</strong>: LS mean −56&nbsp;% (95&nbsp;% IS −66&nbsp;% až −3&nbsp;%). Interval spoľahlivosti je podľa publikačného abstraktu značne asymetrický; bodový odhad je však výrazný a smeruje k klinicky relevantnej redukcii albuminúrie.</p>

<div class="table-responsive" role="region" aria-label="Hlavné znaky štúdie SPARTACUS" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Položka</th>
      <th scope="col">Údaj (abstrakt)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Dizajn</th>
      <td>Fáza&nbsp;2, otvorená; NCT05856760</td>
    </tr>
    <tr>
      <th scope="row">Intervencia</th>
      <td>Výmena RASi → sparsentan pri pokračujúcom stabilnom SGLT2i</td>
    </tr>
    <tr>
      <th scope="row">Počet</th>
      <td>48 zaradených; 39 dokončilo liečbu</td>
    </tr>
    <tr>
      <th scope="row">Demografia</th>
      <td>Vek 48,9 (SD 13,9) rokov; 58&nbsp;% mužov</td>
    </tr>
    <tr>
      <th scope="row">Kľúčový výsledok</th>
      <td>UACR do 24.&nbsp;týždňa: LS mean −56&nbsp;% (95&nbsp;% IS −66&nbsp;% až −3&nbsp;%)</td>
    </tr>
  </tbody>
</table>
</div>

<p><strong>Metodický kontext:</strong> SPARTACUS nie je zaslepená randomizovaná komparatívna štúdia oproti pokračovaniu RASi. Pokles UACR preto silne podporuje hypotézu o prínose sparsentanu v prostredí SGLT2i, ale nedokazuje superioritu voči „optimálne titovanému RASi + SGLT2i“ v rovnakom dizajne. Endpointom bola albuminúria (UACR), nie UPCR – pri citovaní treba rozlišovať od PROTECT OLE.</p>

<h2>PROTECT OLE: pridanie SGLT2i k stabilnému sparsentanu</h2>

<p>V substúdii otvoreného predĺženia PROTECT boli pacienti už liečení sparsentanom randomizovaní <strong>1&nbsp;:&nbsp;1</strong> na pridanie SGLT2i alebo pokračovanie samotným sparsentanom počas <strong>12&nbsp;týždňov</strong>. Následne mohli všetci pokračovať v kombinácii sparsentan + SGLT2i ďalších až <strong>24&nbsp;týždňov</strong>.</p>

<p>Do 12-týždňovej randomizovanej časti bolo zaradených <strong>63</strong> pacientov (všetci ju dokončili): sparsentan + SGLT2i <strong>n&nbsp;=&nbsp;32</strong> (vek 51,4; SD 13,4; 81&nbsp;% mužov) oproti samotnému sparsentanu <strong>n&nbsp;=&nbsp;31</strong> (vek 50,6; SD 11,1; 68&nbsp;% mužov). <strong>24&nbsp;týždňov</strong> kombinácie dokončilo <strong>54</strong> pacientov.</p>

<p>V 12.&nbsp;týždni bol LS mean zmeny UPCR −11,1&nbsp;% (95&nbsp;% IS −26,3&nbsp;% až 7,3&nbsp;%) pri kombinácii oproti +17,7&nbsp;% (95&nbsp;% IS −2,4&nbsp;% až 42,1&nbsp;%) pri samotnom sparsentane. Relatívny pomer medzi skupinami bol <strong>0,75</strong> (95&nbsp;% IS 0,58–0,98; <em>P</em>&nbsp;&lt;&nbsp;0,05).</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky substúdie PROTECT OLE" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Položka</th>
      <th scope="col">Sparsentan + SGLT2i</th>
      <th scope="col">Samotný sparsentan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Počet (12&nbsp;týždňov)</th>
      <td>32</td>
      <td>31</td>
    </tr>
    <tr>
      <th scope="row">Vek; podiel mužov</th>
      <td>51,4 (13,4); 81&nbsp;%</td>
      <td>50,6 (11,1); 68&nbsp;%</td>
    </tr>
    <tr>
      <th scope="row">Zmena UPCR (LS mean, 12.&nbsp;týždeň)</th>
      <td>−11,1&nbsp;% (−26,3&nbsp;% až 7,3&nbsp;%)</td>
      <td>+17,7&nbsp;% (−2,4&nbsp;% až 42,1&nbsp;%)</td>
    </tr>
    <tr>
      <th scope="row">Pomer medzi skupinami</th>
      <td colspan="2">0,75 (0,58–0,98); <em>P</em>&nbsp;&lt;&nbsp;0,05</td>
    </tr>
    <tr>
      <th scope="row">24&nbsp;týždňov kombinácie</th>
      <td colspan="2">54 pacientov dokončilo</td>
    </tr>
  </tbody>
</table>
</div>

<p>Absolútne ide o <strong>mierny</strong> ďalší pokles proteinúrie pri pridaní SGLT2i, nie o efekt veľkosti SPARTACUS. Intervaly spoľahlivosti jednotlivých skupín sa prekrývajú s nulou, ale <em>kontrast medzi ramenami</em> dosiahol štatistickú významnosť. Pri interpretácii treba počítať s malým <em>n</em>, krátkym randomizovaným horizontom a tým, že neskôr mali všetci možnosť prejsť na kombináciu.</p>

<h2>Bezpečnosť</h2>

<p>Podľa abstraktu bolo málo nežiaducich udalostí súvisiacich s liečbou, ktoré by boli závažné, vážne alebo viedli k ukončeniu. Kombinácia bola hodnotená ako dobre tolerovaná, <strong>bez neočakávaných bezpečnostných signálov</strong>.</p>

<p>Aj tu platí opatrnosť: abstrakt neuvádza detailné frekvencie hyperkaliémie, poklesu eGFR, hepatotoxicity, retencie tekutín ani hypotenzie – teda oblasti, ktoré pri endotelínovej blokáde a SGLT2i treba v praxi sledovať. Krátke sledovanie nezachytí zriedkavé oneskorené riziká.</p>

<h2>Čo výsledky podporujú a čo ešte nie</h2>

<div class="table-responsive" role="region" aria-label="Praktická interpretácia SPARTACUS a PROTECT OLE" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Podporujú</th>
      <th scope="col">Nepodporujú / chýba</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Albuminúria / proteinúria</th>
      <td>Výrazný pokles UACR po výmene RASi→sparsentan pri SGLT2i; mierny ďalší pokles UPCR po pridaní SGLT2i k sparsentanu</td>
      <td>Dôkaz o spomalení sklonu eGFR, dialýze, transplantácii alebo úmrtí</td>
    </tr>
    <tr>
      <th scope="row">Sekvencia liečby</th>
      <td>Oba praktické scenáre (výmena RASi; pridanie SGLT2i) majú empirickú oporu</td>
      <td>Optimálne poradie voči imunoterapii podľa rizika progresie (KDIGO)</td>
    </tr>
    <tr>
      <th scope="row">Bezpečnosť</th>
      <td>Krátkodobá tolerancia bez neočakávaných signálov v abstrakte</td>
      <td>Dlhodobý bezpečnostný profil kombinácie v bežnej praxi</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pre ambulantnú prax je rozumný záver: <strong>kombinácia sparsentanu so SGLT2i pri IgAN je v týchto dátach biologicky a klinicky zmysluplná cestou k ďalšiemu zníženiu proteinúrie</strong>, najmä ak už pacient užíva jednu z týchto tried. Rozhodnutie však musí rešpektovať dostupnosť lieku, úhradu, kontraindikácie, monitorovanie a celkový rizikový profil pacienta – vrátane otázky, či je vhodnejšia cielená imunomodulácia.</p>

<h2>Zhrnutie</h2>

<p>SPARTACUS ukázal výrazný a udržaný pokles <strong>UACR</strong> po výmene RASi za sparsentan pri stabilnom SGLT2i. Substúdia PROTECT OLE ukázala, že pridanie SGLT2i k sparsentanu prináša oproti samotnému sparsentanu <strong>relatívne priaznivejšiu zmenu UPCR</strong> v 12.&nbsp;týždni (pomer 0,75). Kombinácia bola krátkodobo dobre tolerovaná. Ide o dôležité náhradné dôkazy proteinúrie pre kombinovanú nefroprotekciu pri IgAN, nie o finálny dôkaz tvrdého klinického prínosu.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=kompletna-remisia-proteinurie-igan-protect-post-hoc">Kompletná remisia proteinúrie v štúdii PROTECT (post hoc)</a></li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus manažmentu IgA nefropatie podľa KDIGO 2025</a></li>
  <li><a href="article.php?slug=iga-nefropatia-kdigo-2025-kdoqi">IgA nefropatia: KDIGO 2025 a komentár KDOQI</a></li>
  <li><a href="article.php?slug=telitacicept-iga-nefropatia-teligan-faza-3-interim">Telitacicept pri IgA nefropatii (TELIGAN)</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Isabelle Ayoub, Gabriela Alperovich, Radko Komers, Laura Ann Kooienga, Alex Mercer, Stephanie Moody, Ingrid Prkačin, Brad H. Rovin, Hira Siktel, Sydney C. W. Tang. Sparsentan – SGLT2 inhibitor combination therapy in trials of IgA nephropathy. <em>Nephrol Dial Transplant</em>. 2026 Sep 11:gfag211. doi:10.1093/ndt/gfag211. <a href="https://pubmed.ncbi.nlm.nih.gov/42726023/" target="_blank" rel="noopener noreferrer">PubMed PMID 42726023</a>; <a href="https://doi.org/10.1093/ndt/gfag211" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://academic.oup.com/ndt/advance-article/doi/10.1093/ndt/gfag211/8790578" target="_blank" rel="noopener noreferrer">OUP (advance article)</a>.</em></p>

<p><em><strong>Ďalšie overené odkazy:</strong></em></p>

<ol>
  <li>ClinicalTrials.gov: <a href="https://clinicaltrials.gov/study/NCT05856760" target="_blank" rel="noopener noreferrer">SPARTACUS (NCT05856760)</a>; <a href="https://clinicaltrials.gov/study/NCT03762850" target="_blank" rel="noopener noreferrer">PROTECT (NCT03762850)</a>.</li>
</ol>

<p><small>Bibliografické údaje a dostupnosť odkazov overené 14.&nbsp;septembra 2026 (PubMed/eutils, Crossref, ClinicalTrials.gov). OUP stránka môže byť chránená Cloudflare výzvou; primárny overený prístup k abstraktu je cez PubMed. Text je odborným informačným materiálom a nenahrádza individuálne klinické rozhodnutie.</small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sparsentan_sglt2_igan_spartacus_protect',
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
