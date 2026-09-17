<?php
/**
 * add_sparsentan-realna-prax-iga-nefropatia-12-mesiacov_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie Garcia-Carro et al. (Clinical Kidney Journal, 2026).
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
    'title'        => 'Sparsentan a rýchla, udržaná redukcia proteinúrie pri IgA nefropatii v reálnej praxi',
    'slug'         => 'sparsentan-realna-prax-iga-nefropatia-12-mesiacov',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Multicentrická retrospektívna kohorta zo Španielska ukázala pri sparsentane pokles proteinúrie už po 3 mesiacoch, s pretrvávaním efektu do 12 mesiacov. Výsledky sú povzbudivé, ale bez kontrolnej skupiny nepreukazujú kauzálny účinok.',
    'content'      => <<<'HTML'
<p><strong>Proteinúria</strong> patrí pri IgA nefropatii (IgAN) medzi najdôležitejšie modifikovateľné ukazovatele rizika progresie chronickej choroby obličiek. Súčasná stratégia preto začína optimalizovanou podpornou liečbou vrátane kontroly krvného tlaku, inhibície systému renín–angiotenzín (RAS) v maximálne tolerovanej dávke a podľa vhodnosti aj inhibítora SGLT2. Pri pretrvávajúcej proteinúrii môže prichádzať do úvahy sparsentan, ktorý v jednej molekule kombinuje antagonizmus endotelínového receptora typu A a receptora AT1 pre angiotenzín II.</p>

<p>Nová multicentrická retrospektívna štúdia zo Španielska sledovala účinok sparsentanu v bežnej klinickej praxi. Jej význam spočíva v tom, že väčšina pacientov už dostávala modernú podpornú liečbu vrátane inhibítora SGLT2. Zároveň však ide o malú nekontrolovanú kohortu, takže výsledky opisujú asociáciu po nasadení lieku a nemožno z nich samostatne dokázať jeho kauzálny účinok ani dlhodobý vplyv na zlyhanie obličiek.</p>

<h2>Čo štúdia sledovala</h2>

<p>Práca <em>Twelve-month real-world outcomes of sparsentan in a multicenter Spanish IgA nephropathy cohort</em> bola publikovaná v časopise <em>Clinical Kidney Journal</em>. Išlo o retrospektívnu multicentrickú analýzu pacientov s biopsiou potvrdenou IgAN, ktorí začali sparsentan mimo klinického skúšania a mali najmenej 3 mesiace sledovania.</p>

<ul>
  <li>Do analýzy bolo zaradených <strong>41 pacientov</strong>; medián veku bol 42 rokov.</li>
  <li>Medián vstupného eGFR bol <strong>44 ml/min/1,73 m²</strong>, teda išlo o kohortu s už zníženou funkciou obličiek.</li>
  <li><strong>95 %</strong> pacientov užívalo pri začatí sparsentanu aj inhibítor SGLT2.</li>
  <li>Všetci pacienti mali biopsiou potvrdenú IgAN a liečba bola podaná v rutinnej praxi, nie v randomizovanom skúšaní.</li>
  <li>Primárnym cieľom bol podiel pacientov s redukciou proteinúrie o <strong>viac než 50 %</strong> po 3 mesiacoch.</li>
</ul>

<p>V dostupnom abstrakte nie je uvedený počet pacientov s údajmi v každom časovom bode. Pri 6- a 12-mesačných výsledkoch preto treba počítať s menšími podskupinami a s vyššou neistotou odhadu.</p>

<h2>Rýchly pokles proteinúrie</h2>

<p>Medián proteinúrie klesol z <strong>1 163 mg/24 h</strong> na <strong>772 mg/24 h</strong> po 3 mesiacoch. Autori uvádzajú medián relatívnej redukcie <strong>44,1 %</strong> a 51 % pacientov dosiahlo pokles o viac než 50 %.</p>

<div class="table-responsive" role="region" aria-label="Vývoj proteinúrie po nasadení sparsentanu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Časový bod</th>
      <th scope="col">Výsledok</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Vstup</th>
      <td>Medián 1 163 mg/24 h</td>
      <td>Východisková proteinúria pred sparsentanom</td>
    </tr>
    <tr>
      <th scope="row">3 mesiace</th>
      <td>Medián 772 mg/24 h; redukcia 44,1 %</td>
      <td>51 % pacientov dosiahlo redukciu o viac než 50 %</td>
    </tr>
    <tr>
      <th scope="row">6 mesiacov</th>
      <td>Medián redukcie 46,9 %</td>
      <td>Efekt pretrvával v dostupnej podskupine</td>
    </tr>
    <tr>
      <th scope="row">12 mesiacov</th>
      <td>Medián redukcie 38,9 %</td>
      <td>Efekt pretrvával, s väčšou variabilitou a menším počtom pozorovaní</td>
    </tr>
  </tbody>
</table>
</div>

<p>Číselný pokles po 3 mesiacoch je klinicky zaujímavý, najmä preto, že 95 % pacientov už užívalo inhibítor SGLT2. Porovnanie s účinkom samotnej RAS blokády alebo so sekvenčným pridaním inej liečby však štúdia neumožňuje.</p>

<h2>Funkcia obličiek a bezpečnosť</h2>

<p>Funkcia obličiek podľa abstraktu zostala počas sledovania stabilná napriek mierne až stredne zníženému vstupnému eGFR. Toto pozorovanie je upokojujúce, ale 12 mesiacov a nekontrolovaný dizajn nestačia na spoľahlivé určenie skutočného sklonu eGFR ani na preukázanie prevencie zlyhania obličiek.</p>

<p>Autori nepozorovali <strong>klinicky významnú hyperkaliémiu ani závažné nežiaduce udalosti</strong>. Tento záver neznamená, že monitorovanie nie je potrebné. Pri sparsentane treba individuálne sledovať krvný tlak, objemový stav, kreatinín alebo eGFR, draslík a podľa platných informácií o lieku aj pečeňové testy. Pri poklese tlaku, akútnom zhoršení funkcie obličiek alebo objemovej deplecii je potrebné prehodnotiť súbežnú liečbu a hydratáciu pacienta.</p>

<h2>Ako výsledky zapadajú do randomizovaných dát</h2>

<p>Randomizované skúšanie PROTECT porovnávalo sparsentan s maximálne titrovaným irbesartanom u dospelých pacientov s IgAN a pretrvávajúcou proteinúriou napriek RAS blokáde. Randomizovaných bolo 406 pacientov (po 203 v každej skupine). Po 110 týždňoch bola proteinúria pri sparsentane približne o 40 % nižšia než pri irbesartane (pomer geometrických priemerov 0,60; 95 % IS 0,50–0,72). Chronický sklon eGFR (týždne 6–110) bol <strong>−2,7 oproti −3,8 ml/min/1,73 m² za rok</strong> (rozdiel 1,1; 95 % IS 0,1–2,1; <em>P</em> = 0,037), zatiaľ čo celkový 2-ročný sklon tesne nedosiahol významnosť (rozdiel 1,0; 95 % IS −0,03 až 1,94; <em>P</em> = 0,058). Kompozitný ukazovateľ zlyhania obličiek dosiahlo 18 (9 %) pacientov pri sparsentane oproti 26 (13 %) pri irbesartane – relatívne riziko 0,7 (95 % IS 0,4–1,2), teda bez štatisticky jednoznačného rozdielu.</p>

<p>Systematický prehľad a meta-analýza z roku 2024 zahŕňali <strong>tri štúdie s celkovo 884 pacientmi</strong> s IgAN alebo fokálnou segmentovou glomerulosklerózou, nie iba pacientov s IgAN. V porovnaní s irbesartanom bol sparsentan spojený s priaznivejším UPCR (pomer percentuálnej redukcie 0,66; 95 % interval spoľahlivosti [IS] 0,58–0,74), častejšou kompletnou remisiou proteinúrie (relatívne riziko 2,57; 95 % IS 1,73–3,81) a čiastočnou remisiou (relatívne riziko 1,63; 95 % IS 1,40–1,91). Rozdiel v eGFR oproti irbesartanu nebol štatisticky významný a hypotenzia bola častejšia pri sparsentane (relatívne riziko 2,02; 95 % IS 1,30–3,16).</p>

<p>Meta-analýza teda podporuje najmä antiproteinurický účinok. Pri interpretácii renálnych „hard“ endpointov treba zohľadniť malý počet štúdií, rozdielne populácie, odlišné definície remisie a dĺžku sledovania.</p>

<h2>Praktické limity štúdie z reálnej praxe</h2>

<ul>
  <li>Retrospektívny dizajn prináša riziko výberového skreslenia a chýbajúcich údajov.</li>
  <li>Bez kontrolnej skupiny nemožno oddeliť účinok sparsentanu od prirodzenej variability proteinúrie, súbežnej liečby a zmien životného štýlu.</li>
  <li>Pacienti, ktorí mali dlhšie sledovanie, nemuseli byť reprezentatívni pre všetkých zaradených pacientov.</li>
  <li>Pokles proteinúrie je dôležitý náhradný ukazovateľ, ale sám osebe nenahrádza dlhodobé údaje o sklone eGFR, zlyhaní obličiek a mortalite.</li>
</ul>

<h2>Záver pre klinickú prax</h2>

<p>V multicentrickej španielskej kohorte bol sparsentan spojený s rýchlym poklesom proteinúrie po 3 mesiacoch a s pretrvávaním účinku do 12 mesiacov. Výsledok je pozoruhodný najmä v prostredí, kde väčšina pacientov už užívala inhibítor SGLT2 a mala znížené vstupné eGFR. Nejde však o dôkaz, že sparsentan sám spôsobil celý pozorovaný efekt, ani o dôkaz, že krátkodobá stabilita eGFR znamená prevenciu zlyhania obličiek.</p>

<p>V praxi má rozhodnutie o sparsentane vychádzať z celkového rizika progresie IgAN, stupňa proteinúrie, krvného tlaku, funkcie obličiek, objemového stavu, súbežnej liečby, kontraindikácií a dostupnosti lieku. Po nasadení je potrebné plánované klinické a laboratórne sledovanie, predovšetkým krvného tlaku, kreatinínu alebo eGFR, draslíka a pečeňových testov.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=sparsentan-sglt2-inhibitor-iga-nefropatia-spartacus-protect">Sparsentan so SGLT2 inhibítorom pri IgA nefropatii: SPARTACUS a PROTECT OLE</a></li>
  <li><a href="article.php?slug=kompletna-remisia-proteinurie-igan-protect-post-hoc">Kompletná remisia proteinúrie v štúdii PROTECT</a></li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Algoritmus manažmentu IgA nefropatie podľa KDIGO 2025</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> García-Carro C, Rodríguez-Moreno A, Cordero L, Pérez-Gómez MV, Rusiñol HM, Pasache E, Morales A, Zamora R, Parra D, Villa J, Guillén-Olmos E, Coll-Brito V, Álvarez Á, Bordignon J, Arcal C, Gracia O, Delgado P, Soler MJ, Sánchez-Fructuoso AI. Twelve-month real-world outcomes of sparsentan in a multicenter Spanish IgA nephropathy cohort. <em>Clinical Kidney Journal</em>. 2026;19(9):sfag298. doi:10.1093/ckj/sfag298. <a href="https://doi.org/10.1093/ckj/sfag298" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42746507/" target="_blank" rel="noopener noreferrer">PubMed PMID 42746507</a>.</em></p>

<p><em><strong>Ďalší zdroj:</strong> Abo Elnaga AA, Alsaied MA, Elettreby AM, Ramadan A, Abouzid M, Shetta R, Al-Ajlouni YA. Safety and efficacy of sparsentan versus irbesartan in focal segmental glomerulosclerosis and IgA nephropathy: a systematic review and meta-analysis of randomized controlled trials. <em>BMC Nephrology</em>. 2024;25(1):316. doi:10.1186/s12882-024-03713-9. PMID 39333921. <a href="https://doi.org/10.1186/s12882-024-03713-9" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/39333921/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11429118/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></p>

<p><em><strong>Randomizované dáta PROTECT:</strong> Rovin BH, Barratt J, Heerspink HJL, et al. Efficacy and safety of sparsentan versus irbesartan in patients with IgA nephropathy (PROTECT): 2-year results from a randomised, active-controlled, phase 3 trial. <em>The Lancet</em>. 2023;402:2077–2090. doi:10.1016/S0140-6736(23)02302-4. <a href="https://pubmed.ncbi.nlm.nih.gov/37931634/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><small>Bibliografické údaje a hlavné výsledky boli overené 17. septembra 2026 cez PubMed/eutils, Crossref a otvorený fulltext meta-analýzy. Text je odborným informačným materiálom a nenahrádza individuálne klinické rozhodnutie.</small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_sparsentan_realna_prax_igan_12m',
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
