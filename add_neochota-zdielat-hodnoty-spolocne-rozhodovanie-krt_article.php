<?php

/**
 * add_neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt_article.php
 * Neochota zdielat osobne hodnoty pri spolocnom rozhodovani o nahrade funkcie obliciek.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Keď pacient nechce hovoriť o svojich hodnotách: skrytá prekážka spoločného rozhodovania o dialýze',
    'slug'         => 'neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Takmer štvrtina pacientov pred voľbou náhrady funkcie obličiek nie je ochotná hovoriť o tom, čo je pre nich dôležité. Japonská štúdia so 474 účastníkmi ukazuje, že za mlčaním stojí najmä nedôvera a depresia — nie neochota spolupracovať.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Spoločné rozhodovanie o modalite náhrady funkcie obličiek predpokladá, že pacient povie, čo je pre neho dôležité. Japonská štúdia ukazuje, že takmer štvrtina pacientov to urobiť nechce — a že za mlčaním nestojí odmietanie spolupráce, ale najmä miera dôvery k lekárovi a prítomnosť depresívnych príznakov.</em></p>

<p>Model spoločného rozhodovania (<em>shared decision-making</em>, SDM) sa pri voľbe medzi hemodialýzou, peritoneálnou dialýzou, transplantáciou a konzervatívnym postupom stal štandardom. Jeho logika je jednoduchá: lekár prináša odborné informácie o možnostiach, pacient prináša informácie o tom, čo je pre neho v živote dôležité, a rozhodnutie vzniká zo spojenia oboch.</p>

<p>Celý model však stojí na predpoklade, ktorý sa málokedy overuje — že pacient je ochotný o svojich hodnotách hovoriť. Ak túto časť nedodá, rozhodovanie zostane formálne správne, ale fakticky jednostranné: lekár vyplní prázdne miesto vlastným odhadom toho, čo by pacient asi chcel.</p>

<h2>Čo štúdia skúmala</h2>

<p>Rozsiahla japonská štúdia pod vedením Noriakiho Kuritu z Fukushima Medical University sa zamerala presne na túto medzeru. Zapojených bolo <strong>474 dospelých pacientov s pokročilou chronickou chorobou obličiek</strong>, ktorí si už modalitu náhrady funkcie obličiek zvolili.</p>

<p>Použitý bol <strong>konvergentný zmiešaný dizajn</strong> — kvantitatívna a kvalitatívna časť prebiehali súbežne a ich výsledky sa spájali až pri interpretácii. Kvantitatívna časť merala mieru neochoty, jej determinanty a vzťah k dotazníku <strong>CollaboRATE</strong>, ktorým pacient hodnotí, do akej miery bol do rozhodovania skutočne zapojený. Kvalitatívna časť analyzovala voľné odpovede pacientov na otázku, prečo o svojich hodnotách hovoriť nechcú.</p>

<h2>Neochota je častá a má merateľné dôsledky</h2>

<p>Ako veľmi alebo do istej miery neochotných zdieľať svoje osobné hodnoty sa označilo <strong>111 pacientov, teda 24,2 %</strong>. Takmer každý štvrtý pacient teda vstupuje do rozhovoru o zásadnom celoživotnom rozhodnutí s tým, že podstatnú časť informácií neposkytne.</p>

<p>Nejde pritom o formalitu bez následkov. V porovnaní s pacientmi, ktorí neochotu neuvádzali vôbec, dosahovali:</p>

<ul>
  <li>minimálne neochotní pacienti skóre CollaboRATE nižšie o <strong>5,12 bodu</strong>,</li>
  <li>veľmi alebo do istej miery neochotní pacienti nižšie o <strong>11,39 bodu</strong>.</li>
</ul>

<p>Vzťah je teda odstupňovaný — čím väčšia neochota, tým nižšie hodnotenie vlastného zapojenia. To je dôležité: neochota nie je len postoj, ale premieta sa do toho, ako pacient sám vníma kvalitu rozhodovacieho procesu, ktorým prešiel.</p>

<h2>Dva determinanty s opačným smerom</h2>

<p>Analýza identifikovala dva faktory, ktoré na neochotu pôsobia protichodne:</p>

<ul>
  <li><strong>Väčšia dôvera v primárneho nefrológa pôsobila ochranne</strong> — čím vyššia dôvera, tým nižšia neochota.</li>
  <li><strong>Depresívne príznaky neochotu podporovali.</strong></li>
</ul>

<p>Obidva nálezy majú priamy praktický význam. Prvý hovorí, že ochota hovoriť o hodnotách nie je vlastnosťou pacienta, ale <strong>vlastnosťou vzťahu</strong> — a vzťah možno ovplyvniť. Druhý upozorňuje, že mlčanie môže byť príznakom, nie postojom.</p>

<p>Práve druhý bod si zaslúži zdôraznenie. Ak pacient pred rozhodnutím o dialýze nekomunikuje, apaticky prijíma čokoľvek, čo sa navrhne, alebo pôsobí, že mu je to jedno, prvá úvaha by nemala smerovať k „nespolupracujúcemu pacientovi“, ale k možnej neliečenej depresii. Tá je v tejto populácii častá, systematicky poddiagnostikovaná a liečiteľná.</p>

<h2>Päť dôvodov mlčania</h2>

<p>Kvalitatívna analýza voľných odpovedí vyčlenila päť tém, ktoré vysvetľujú, prečo pacienti o svojich hodnotách hovoriť nechcú. Prvé tri neochotu vysvetľujú, posledné dve naopak opisujú, čo ju prekonáva:</p>

<ol>
  <li><strong>Rozdielna citlivosť na súkromie.</strong> Pacienti sa výrazne líšia v tom, čo považujú za osobnú informáciu, ktorá do zdravotníckeho rozhovoru nepatrí.</li>
  <li><strong>Postoje a preferencie v rozhodovaní.</strong> Nie každý pacient chce rozhodovať spoločne. Časť ľudí si vedome želá, aby rozhodol lekár, a nepovažuje za potrebné vysvetľovať prečo.</li>
  <li><strong>Osobnosť a psychická adaptácia.</strong> Spôsob, akým sa človek vyrovnáva so závažnou diagnózou, ovplyvňuje jeho ochotu hovoriť o vlastných preferenciách — vrátane situácií, keď si ich sám ešte nesformuloval.</li>
  <li><strong>Uprednostnenie zdravia pred súkromím.</strong> Časť pacientov je ochotná osobné informácie poskytnúť napriek nepohodliu, ak sú presvedčení, že to zlepší ich liečbu.</li>
  <li><strong>Dôvera k poskytovateľom starostlivosti.</strong> Dôvera funguje ako faktor, ktorý bariéru súkromia prekonáva — čo zodpovedá aj kvantitatívnemu nálezu.</li>
</ol>

<p>Zásadný praktický dôsledok je, že <strong>jednotná komunikačná stratégia nemôže fungovať</strong>. Pacient, ktorý mlčí kvôli citlivosti na súkromie, potrebuje niečo iné ako pacient, ktorý si praje, aby rozhodol lekár, a ten zas niečo iné ako pacient s depresiou.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<p>Zistenia sa dajú previesť do niekoľkých pomerne konkrétnych krokov:</p>

<ol>
  <li><strong>Neochotu považovať za údaj, nie za prekážku.</strong> Ak pacient o svojich hodnotách nehovorí, je to informácia o vzťahu, o jeho psychickom stave alebo o jeho preferovanom štýle rozhodovania — a stojí za to zistiť, o ktorú z možností ide.</li>
  <li><strong>Aktívne pátrať po depresívnych príznakoch</strong> pred rozhodovaním o modalite, nie až po ňom. Postačí krátky skríningový nástroj alebo cielená otázka na náladu, spánok a záujem o veci, ktoré pacienta predtým tešili.</li>
  <li><strong>Budovať dôveru priebežne, nie pri rozhodovacom rozhovore.</strong> Dôvera k primárnemu nefrológovi je podľa štúdie ochranným faktorom — vzniká však počas mesiacov a rokov sledovania, nie počas jednej konzultácie.</li>
  <li><strong>Explicitne sa opýtať na preferovanú mieru zapojenia.</strong> Otázka „Chcete, aby sme sa rozhodovali spoločne, alebo by ste radšej, aby som vám odporučil, čo považujem za najlepšie?“ je legitímna a šetrí obom stranám nedorozumenie.</li>
  <li><strong>Normalizovať postupné odpovede.</strong> Pacient nemusí mať svoje hodnoty sformulované hneď. Rozdelenie rozhodovania do viacerých návštev je pri plánovanom začiatku liečby spravidla realizovateľné.</li>
  <li><strong>Rešpektovať hranicu.</strong> Právo nehovoriť o osobných záležitostiach je súčasťou autonómie pacienta rovnako ako právo rozhodovať. Cieľom nie je neochotu odstrániť za každú cenu, ale porozumieť jej a prispôsobiť sa jej.</li>
</ol>

<h2>Limity</h2>

<p>Pri výklade treba mať na pamäti niekoľko obmedzení:</p>

<ul>
  <li>Ide o <strong>prierezovú štúdiu</strong>. Doložené sú asociácie, nie príčinné vzťahy. Vzťah medzi dôverou a neochotou môže pôsobiť obojsmerne a rovnako je možné, že depresia aj neochota majú spoločnú príčinu.</li>
  <li>Zaradení boli len pacienti, ktorí <strong>modalitu už zvolili</strong>. Tí, ktorí sa k rozhodnutiu nedopracovali, v súbore chýbajú — a práve u nich by neochota mohla byť ešte vyššia. Skutočná prevalencia je preto pravdepodobne podhodnotená.</li>
  <li>Kľúčové premenné sú <strong>sebahlásené</strong>, čo pri téme, ako je ochota hovoriť o osobných veciach, prináša riziko skreslenia sociálnou žiaducnosťou.</li>
  <li>Ide o <strong>japonskú populáciu</strong>. Normy týkajúce sa súkromia, očakávaného rozdelenia rolí medzi lekárom a pacientom a spôsobu vyjadrovania nesúhlasu sa medzi kultúrami líšia. Konkrétny podiel 24,2 % preto nemožno automaticky preniesť do slovenských podmienok — mechanizmy, ktoré štúdia opísala, sú však pravdepodobne prenositeľnejšie než samotné číslo.</li>
</ul>

<h2>Záver</h2>

<p>Spoločné rozhodovanie sa v odporúčaniach opisuje ako výmena, v ktorej lekár prináša odbornosť a pacient hodnoty. Táto štúdia pripomína, že druhá polovica výmeny sa nedeje automaticky. Takmer štvrtina pacientov o svojich hodnotách hovoriť nechce a ich hodnotenie vlastného zapojenia do rozhodovania je zodpovedajúco nižšie.</p>

<p>Podstatné je, ako sa tento nález číta. Mlčanie pacienta nie je zlyhaním pacienta. Podľa dostupných údajov súvisí predovšetkým s dôverou — teda s niečím, čo je na strane vzťahu a čo možno budovať — a s depresívnymi príznakmi, teda s niečím liečiteľným. Spoločné rozhodovanie preto nemá byť jedným rozhovorom pred podpisom informovaného súhlasu, ale procesom, ktorý začína dávno predtým a ktorý počíta aj s tým, že časť pacientov si svoje súkromie ponechá.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kvalitativny-vyskum-nefrologia-rozhodovanie-pacientov-ckd">Kvalitatívny výskum v nefrológii a rozhodovanie pacientov s CKD</a>.</li>
  <li><a href="article.php?slug=predialyzacna-edukacia-volba-peritonealnej-dialyzy">Predialyzačná edukácia a voľba peritoneálnej dialýzy</a>.</li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Krehkosť pri CKD</a> — výživa, pohyb a funkčné hodnotenie.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Noriaki Kurita, Jun Miyashita, Mayumi Nishimura, Hiroo Kawarazaki, Tadashi Sofue, Tatsunori Toida, Kosuke Inoue, Hiroshi Kado, Susumu Toda, Hiroki Nishiwaki, Seita Sugitani, Izaya Nakaya, Yosuke Yamada, Makoto Yamamoto, Shigeru Shibata, Atsuhiro Maeda, Hideaki Oka, Tomoya Nishino, Tomo Suzuki, Daisuke Komukai, Masahide Furusho, Ryohei Inanaga, Keiko Nishi, Yasuhiro Taki, Hideki Shimizu, Shohei Yamada, Kenichiro Asano, Hitoshi Miyasato, Minoru Murakami, Takaaki Tsutsui, Takayuki Nakamura, Takayuki Adachi, Hiroaki Asada, Keita Uehara, Tatsuo Tsukamoto, Ryo Zamami, Yoshihiko Raita, Ken-Ichi Miyoshi, Takeshi Okamoto, Takafumi Ito, Hiroyuki Terawaki, Chisato Fukuhara, Mari Yamamoto, Tsukasa Naganuma, Kei Nagai, Kojiro Nagai, Kiichiro Fujisaki, Yukihiro Tamura, Hideaki Shimizu, Shuma Hirashio, Shohei Nakanishi, Satoshi Furukata, Nobuyuki Nakano, Yugo Shibagaki.</strong> <em>Determinants and implications of reluctance to disclose personal values in the shared decision-making process for kidney replacement therapy.</em> Journal of Nephrology. 2026 Aug 3 (online ahead of print). doi: 10.1093/joneph/aajag079. <a href="https://pubmed.ncbi.nlm.nih.gov/42544782/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1093/joneph/aajag079" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Paul J. Barr, Rachel Thompson, Thom Walsh, Stuart W. Grande, Elissa M. Ozanne, Glyn Elwyn.</strong> <em>The psychometric properties of CollaboRATE: a fast and frugal patient-reported measure of the shared decision-making process.</em> Journal of Medical Internet Research. 2014;16(1):e2. doi: 10.2196/jmir.3085. <a href="https://pubmed.ncbi.nlm.nih.gov/24389354/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje, kompletné autorstvo (52 autorov) aj kľúčové číselné údaje — 474 účastníkov, 111 pacientov (24,2 %) veľmi alebo do istej miery neochotných, rozdiely v skóre CollaboRATE −5,12 a −11,39 bodu, ochranný účinok dôvery v primárneho nefrológa, podporný účinok depresívnych príznakov a konvergentný zmiešaný dizajn — boli overené priamo v zázname PubMed a v Europe PMC vrátane doslovného znenia abstraktu. Rovnako boli overené názvy všetkých piatich kvalitatívnych tém. Plný text štúdie je za platobnou bariérou vydavateľa a nebol sprístupnený; slovenský opis jednotlivých tém preto vychádza z ich názvov a nie z detailných citácií pacientov. Praktické odporúčania, výklad depresie ako možnej príčiny mlčania a poznámka o kultúrnej prenositeľnosti sú <strong>vlastným odborným komentárom</strong>.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_neochota-zdielat-hodnoty-spolocne-rozhodovanie-krt_article',
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
