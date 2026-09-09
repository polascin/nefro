<?php
/**
 * Odborný článok: Ekonomické scenáre transformujúcej AI do roku 2030 a ich význam pre zdravotníctvo.
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

$articles = [];

$articles[] = [
    'title'        => 'Umelá inteligencia do roku 2030: čo môžu znamenať rôzne ekonomické scenáre pre mzdy, prácu a zdravotníctvo',
    'slug'         => 'ai-ekonomicke-scenare-2030-praca-zdravotnictvo',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Model troch scenárov do roku 2030 ukazuje, že hospodársky rast a mzdy nemusia ísť rovnakým smerom. Autori výslovne uvádzajú, že nejde o predpovede a nepripisujú im pravdepodobnosti.',
    'content'      => <<<'HTML'
<p>Ako veľmi zmení umelá inteligencia ekonomiku do roku 2030 a čo to znamená pre ľudí, ktorí v nej pracujú? Pracovný dokument <em>Economic Scenarios for Transformative AI</em> ponúka na túto otázku netradičnú odpoveď: namiesto jednej predpovede stavia jednoduchý model, ktorý prevádza malý počet predpokladov o vývoji umelej inteligencie na dôsledky pre produktivitu, rast, mzdy, podiel práce na príjmoch, presuny pracovných miest a nezamestnanosť.</p>

<p>Autori svoj zámer formulujú jednoznačne: <strong>„Scenáre nie sú predpovede a nepripisujeme im pravdepodobnosti; ich účelom je urobiť dôsledky rôznych predpokladov porovnateľnými."</strong> Model je sprístupnený aj ako interaktívny prehliadač scenárov.</p>

<h3>Poznámka k pôvodu zdroja</h3>

<p>Dokument vydal The Anthropic Institute — teda inštitút spoločnosti, ktorá umelú inteligenciu vyvíja a predáva. Ide o prácu o ekonomickom dosahu vlastnej produktovej kategórie, čo je pri hodnotení namieste vziať do úvahy. Autori v poznámke pod čiarou uvádzajú, že vyjadrené názory sú ich vlastné a nemusia predstavovať stanovisko spoločnosti Anthropic ani inštitútu, a že pri rešerši a písaní použili ako asistenta model Claude. Dokument nie je recenzovanou publikáciou v odbornom časopise.</p>

<p>Tieto skutočnosti prácu nediskvalifikujú — jej predpoklady aj obmedzenia sú explicitne uvedené a výsledky sa porovnávajú s nezávislou literatúrou. Znamenajú však, že sa má čítať ako analytický rámec s deklarovaným záujmom autorskej inštitúcie, nie ako neutrálny odhad.</p>

<h2>Ako je model postavený</h2>

<p>Ide o štandardný model založený na úlohách (<em>task-based model</em>). Umelá inteligencia v ňom automatizuje alebo dopĺňa rastúci podiel úloh vykonávaných prácou. Pracovníci sú rozdelení na dve skupiny:</p>

<ul>
  <li><strong>kognitívne povolania</strong> — riadiace, odborné, obchodné a administratívne, ktoré môžu byť umelou inteligenciou priamo zasiahnuté;</li>
  <li><strong>ostatné povolania</strong>, ktoré priamo zasiahnuté nie sú (autori uvádzajú ako príklad stavebných robotníkov alebo elektrikárov).</li>
</ul>

<p>Zavádzanie umelej inteligencie zvyšuje produktivitu, ale súčasne vytláča pracovníkov: znižuje dopyt po práci a mzdy v kognitívnych povolaniach a časť pracovníkov musí hľadať prácu inde. Tento presun naráža na trenie — softvérový inžinier sa ťažko stane elektrikárom — čo môže viesť k trvalejšiemu zvýšeniu nezamestnanosti. Umelá inteligencia zároveň zvyšuje dopyt po kapitáli, čím rastie jeho výnos aj podiel na celkových príjmoch výrobných faktorov.</p>

<h2>Tri scenáre a ich výsledky</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie troch scenárov do roku 2030" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ k roku 2030</th>
      <th scope="col">Mierny scenár</th>
      <th scope="col">Podstatný scenár</th>
      <th scope="col">Extrémny scenár</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">HDP oproti vývoju bez umelej inteligencie</th>
      <td>+1,6 %</td>
      <td>+8,3 %</td>
      <td>+32,4 %</td>
    </tr>
    <tr>
      <th scope="row">Podiel práce na HDP</th>
      <td>59,4 %</td>
      <td>56,1 %</td>
      <td>45,2 %</td>
    </tr>
    <tr>
      <th scope="row">Mzdy v kognitívnych povolaniach</th>
      <td>rastú</td>
      <td>približne stagnujú</td>
      <td>o 11,5 % pod dráhou bez umelej inteligencie</td>
    </tr>
    <tr>
      <th scope="row">Mzdy v ostatných povolaniach</th>
      <td>mierne vyššie</td>
      <td>vyššie</td>
      <td>o 34 % nad dráhou bez umelej inteligencie</td>
    </tr>
    <tr>
      <th scope="row">Nezamestnanosť</th>
      <td>+0,1 percentuálneho bodu</td>
      <td>pokles kognitívnej zamestnanosti</td>
      <td>takmer jeden z piatich kognitívnych pracovníkov</td>
    </tr>
  </tbody>
</table>
</div>

<p>V miernom scenári pridá umelá inteligencia k rastu HDP do roku 2030 menej než pol percentuálneho bodu a nezamestnanosť zvýši o desatinu bodu. V extrémnom scenári vykonáva umelá inteligencia do roku 2030 takmer polovicu dnešnej kognitívnej práce, tempo rastu HDP stúpa na 15 % ročne a podiel práce na príjmoch klesá zo 60 % na 45 %.</p>

<h3>Dôležité spresnenie k mzdám</h3>

<p>Údaj o poklese miezd kognitívnych pracovníkov sa často cituje nepresne. Podľa pracovného dokumentu je v extrémnom scenári kognitívna mzda <strong>o 11,5 % nižšia, než by bola bez umelej inteligencie</strong> — nejde teda automaticky o absolútny pokles oproti dnešku, ale o zaostávanie za hypotetickou dráhou bez tejto technológie.</p>

<p>Ešte podstatnejšie je, čo sa deje súčasne v druhej skupine: mzdy v povolaniach, ktoré umelá inteligencia priamo nezasahuje, sú v tom istom scenári <strong>o 34 % vyššie</strong>, než by boli bez nej. Model teda nepredpovedá plošné ochudobnenie pracujúcich, ale <em>presun</em> — od kognitívnej práce ku kapitálu a k nekognitívnym povolaniam. Autori tiež uvádzajú, že takmer celá divergencia medzi scenármi nastáva až po roku 2027.</p>

<h2>Vyšší rast nemusí znamenať vyššie mzdy</h2>

<p>Najdôležitejším posolstvom modelu je, že hospodársky rast a rast miezd nemusia kráčať rovnakým smerom. Podiel práce na príjmoch klesá <strong>vo všetkých troch scenároch</strong>, pretože mzdy zaostávajú za rastom produkcie.</p>

<p>Rozhodujúce bude, kto bude vlastniť technológie, výpočtovú infraštruktúru, dátové centrá, modely a podnikový kapitál potrebný na ich využívanie. Ak umelá inteligencia zvýši výnosy z kapitálu, väčšia časť ekonomických prínosov môže smerovať k vlastníkom kapitálu.</p>

<p>Mechanizmus nie je pre umelú inteligenciu špecifický — technologické inovácie opakovane menili pomer medzi príjmami z práce a z kapitálu. Pri digitálnych technológiách však môže byť zmena rýchlejšia, pretože ich možno škálovať bez úmerného zvyšovania počtu pracovníkov.</p>

<h2>Prekvapivé zistenie: inovačný kanál je malý</h2>

<p>Za pozornosť stojí nález, ktorý ide proti častému očakávaniu. Ak umelá inteligencia zrýchli samotný výskum, mala by ekonomiku poháňať aj týmto druhým kanálom. Podľa modelu je však toto zrýchlenie <strong>relatívne malé aj v extrémnom scenári</strong>: produktivita práce cez inovačný kanál rastie „výrazne menej než o jedno percento" vo všetkých troch scenároch.</p>

<p>Dôvodom je, že automatizácia výskumu síce zvyšuje množstvo vstupov do tvorby nových poznatkov, výskum však zostáva limitovaný fyzickými úlohami. Autori zároveň priznávajú, že model neobsahuje niektoré dôležité spätné väzby medzi výskumom a automatizáciou, a preto nedokáže vygenerovať scenáre explozívneho zrýchlenia. Inovačné efekty v modeli sú teda skôr <strong>dolným odhadom</strong>.</p>

<h2>Čo očakáva verejnosť</h2>

<p>Autori doplnili scenáre reprezentatívnym prieskumom medzi <strong>10 980 dospelými obyvateľmi USA</strong>. Pýtali sa, kedy bude umelá inteligencia schopná zvládnuť osem kognitívnych úloh rastúcej náročnosti, ako široko sa bude používať, aké veľké budú prírastky produktivity, či bude prácu automatizovať alebo dopĺňať a ako dlho bude vytlačenému pracovníkovi trvať nájsť si novú prácu.</p>

<p>Po dosadení mediánových odpovedí do modelu vyšiel výsledok blízky <strong>podstatnému scenáru</strong>: do roku 2030 by HDP vzrástlo o 8 % a kognitívna zamestnanosť by klesla o 4 %. Očakávania verejnosti sa teda nachádzajú medzi krajnými variantmi.</p>

<h2>Dve interpretácie doterajších dát</h2>

<p>Autori upozorňujú na dôležitú nejednoznačnosť. V makroekonomických údajoch boli doteraz účinky umelej inteligencie na trh práce pomerne tlmené, hoci meraná miera jej používania rýchlo rastie. S týmto faktom sú zlučiteľné dva výklady:</p>

<ol>
  <li>nachádzame sa v <strong>miernom</strong> scenári a ekonomické účinky zostanú malé;</li>
  <li>nachádzame sa na <strong>úplnom začiatku</strong> extrémnejšieho vývoja, ktorý úlohu a odmeňovanie práce zásadne zmení.</li>
</ol>

<p>Ako autori zdôrazňujú, tieto dva výklady majú veľmi odlišné dôsledky pre verejnú politiku — a doterajšie dáta medzi nimi zatiaľ nerozhodujú.</p>

<h2>Expozícia povolania nie je zánik pracovných miest</h2>

<p>Generatívna umelá inteligencia zasahuje aj činnosti, ktoré sa tradične považovali za prevažne intelektuálne: tvorbu a úpravu textov, preklad, analýzu dokumentov, programovanie, administratívu, právne a finančné služby, zákaznícku podporu či prípravu odborných materiálov.</p>

<p>Treba však dôsledne rozlišovať medzi <em>expozíciou</em> povolania voči umelej inteligencii a <em>zánikom</em> pracovných miest. Ak systém dokáže vykonávať časť úloh určitého povolania, ešte z toho nevyplýva, že povolanie zanikne — technológia môže pracovníka podporovať, meniť náplň práce alebo zvyšovať jeho produktivitu. Povolanie vystavené technologickej zmene môže dokonca rásť, ak vyššia produktivita vyvolá vyšší dopyt po danej službe.</p>

<p>Na druhej strane môže podiel činností vykonávaných človekom klesnúť natoľko, že sa zníži počet pracovníkov potrebných na určitý objem služieb. Výsledkom nemusí byť hromadné prepúšťanie — častejšie ide o pomalšie prijímanie nových pracovníkov, tlak na mzdy, zmenu kvalifikačných požiadaviek a presun pracovných miest medzi sektormi.</p>

<h2>Obmedzenia, ktoré autori priznávajú</h2>

<p>Výsledky modelu nemožno oddeliť od predpokladov, z ktorých vychádza. Autori sami uvádzajú, že model je „výrazným zjednodušením zložitej reality" a vynecháva:</p>

<ol>
  <li><strong>Jednotlivých pracovníkov.</strong> Model nesleduje osobné náklady straty zamestnania, dĺžku rekvalifikácie, regionálne rozdiely ani sociálne dôsledky nútenej zmeny povolania.</li>
  <li><strong>Hospodársku politiku.</strong> Nepracuje v plnom rozsahu s daňovou politikou, sociálnymi transfermi, reguláciou, vzdelávacou politikou ani s inými formami prerozdelenia.</li>
  <li><strong>Hospodárske cykly a finančné poruchy.</strong> Skutočný vývoj môže ovplyvniť recesia, úverová kríza, rast cien energie, geopolitické napätie alebo výpadky dodávateľských reťazcov.</li>
  <li><strong>Dopyt z výstavby infraštruktúry.</strong> Investície do čipov, energetiky, dátových centier a sietí môžu dočasne zvyšovať dopyt po práci aj kapitáli.</li>
  <li><strong>Spätné väzby medzi výskumom a automatizáciou</strong>, a teda ani možnosť samourýchľujúceho sa pokroku.</li>
</ol>

<p>Model tiež pracuje s ekonomikou USA, nie so slovenskými alebo európskymi podmienkami. Štruktúra zamestnanosti, regulácia trhu práce, sociálny systém aj tempo zavádzania technológií sa u nás od amerických líšia.</p>

<h2>Dopĺňanie človeka alebo jeho nahradenie?</h2>

<p>Rozhodujúcou premennou modelu je, či umelá inteligencia prácu prevažne <em>automatizuje</em>, alebo ju <em>dopĺňa</em>. V zdravotníctve je pravdepodobnejší zmiešaný model. Umelá inteligencia môže automatizovať administratívne úlohy, pripravovať návrhy lekárskych správ, pomáhať pri triedení pacientov, analyzovať obrazové a laboratórne údaje, upozorňovať na riziko zhoršenia stavu, podporovať výskum liekov a zjednodušovať komunikáciu s pacientmi.</p>

<p>To však neznamená, že môže bez ďalšieho nahradiť lekára alebo sestru. Klinické rozhodovanie zahŕňa neistotu, hodnotenie dôveryhodnosti údajov, komunikáciu, etické rozhodovanie, zodpovednosť a schopnosť reagovať na neštandardné situácie.</p>

<p>Zdravotníctvo má navyše vlastnosť, ktorú ekonomický model nezachytáva: je to regulovaný sektor s vysokými nárokmi na bezpečnosť, ochranu osobných údajov, vysvetliteľnosť rozhodnutí a profesionálnu zodpovednosť. Technický pokrok v ňom môže byť rýchlejší než jeho bezpečné a regulačne akceptované zavedenie.</p>

<h3>Nefrologický kontext</h3>

<p>V nefrológii možno očakávať rozvoj systémov na predikciu progresie chronickej choroby obličiek, optimalizáciu dávkovania liekov, detekciu komplikácií pri dialýze, interpretáciu trendov laboratórnych výsledkov a podporu rozhodovania o načasovaní transplantačného vyšetrenia.</p>

<p>Každý takýto systém však musí byť validovaný v konkrétnej populácii a v konkrétnom klinickom prostredí. Ekonomické modelové úvahy preto nemožno priamo premeniť na klinické odporúčania — a naopak, dobrá výkonnosť nástroja v celkovej populácii nie je dôkazom jeho vhodnosti pre nefrologických pacientov.</p>

<h2>Čo z toho plynie pre zdravotníckych pracovníkov</h2>

<p>Rozhodujúce nebude tempo technologického pokroku samo osebe, ale najmä:</p>

<ul>
  <li>kvalita a dostupnosť dát,</li>
  <li>spoľahlivosť modelov v reálnych podmienkach,</li>
  <li>cena výpočtovej infraštruktúry a jej energetická náročnosť,</li>
  <li>právna zodpovednosť za chybný výstup,</li>
  <li>dôvera používateľov,</li>
  <li>schopnosť pracovníkov technológiu kontrolovať,</li>
  <li>dostupnosť rekvalifikácie a celoživotného vzdelávania.</li>
</ul>

<p>Pre lekára z toho vyplýva potreba rozvíjať nielen odborné vedomosti, ale aj schopnosť kriticky hodnotiť výstupy umelej inteligencie. Kto takýto systém používa, musí rozumieť jeho účelu, obmedzeniam, možným systematickým chybám a podmienkam, za ktorých je výsledok nespoľahlivý.</p>

<h2>Záver</h2>

<p>Model upozorňuje na dôležitý paradox: ekonomika môže vďaka umelej inteligencii rásť rýchlo, zatiaľ čo časť pracovníkov zo zvýšenej produktivity primerane neprofituje. Podiel práce na príjmoch klesá vo všetkých troch scenároch a v extrémnom variante zo 60 % na 45 %.</p>

<p>Najväčšou hodnotou práce nie je presnosť konkrétneho čísla, ale možnosť porovnať, čo by z rôznych predpokladov vyplývalo. Autori sami trvajú na tom, že nejde o predpovede a že scenárom nepripisujú pravdepodobnosti. Model navyše nezachytáva politické reakcie, hospodárske cykly, finančné otrasy ani spätné väzby, ktoré by mohli výsledok posunúť oboma smermi.</p>

<p>Pre zdravotníctvo a nefrológiu je praktickým záverom potreba pripravovať sa na postupnú spoluprácu človeka so systémami umelej inteligencie. Kľúčom nebude plošná automatizácia, ale overená technológia, klinická zodpovednosť, ochrana pacienta a zachovanie rozhodovacej úlohy kvalifikovaného zdravotníckeho pracovníka.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=regulacia-medicinskej-umelej-inteligencie-fda-nefrologia">Regulácia medicínskej umelej inteligencie: čo by mal lekár vedieť a čo z toho plynie pre nefrológiu</a></li>
  <li><a href="article.php?slug=umela-inteligencia-nefrologia-co-vieme-limity">Umelá inteligencia v nefrológii: čo už vieme, kde sú limity a kam to smeruje</a></li>
  <li><a href="article.php?slug=ai-scribe-pravne-nastrahy-ambulancia-nefrologia">Právne nástrahy pri používaní AI scribov v ambulancii a čo z toho plynie pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=nova-ada-vyskumne-granty-politicky-zasah-dopad-na-nefrologiu">Nová ADA ako impulz na reflexiu: výskumné granty, politický zásah a dopad na nefrológiu</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li><small><em>Korinek A, Jones CI, Sacher S, Cotter T, McCrory P. Economic Scenarios for Transformative AI. The Anthropic Institute Working Paper No. 2026-02, september 2026. <a href="https://www-cdn.anthropic.com/files/4zrzovbb/website/cf58f84d46a4a76bf5a5b039ac695fba6b80041c.pdf" target="_blank" rel="noopener noreferrer">plný text (PDF)</a>. Hlavný spracovaný zdroj; nerecenzovaný pracovný dokument.</em></small></li>
  <li><small><em>Scenarios for our Economic Future — interaktívny prehliadač scenárov. The Anthropic Institute. <a href="https://www.anthropic.com/institute/econ-scenarios" target="_blank" rel="noopener noreferrer">anthropic.com</a>. Zdroj číselných hodnôt HDP a podielu práce. Na stránke je druhý autor uvedený ako „Chad Jones", v pracovnom dokumente ako „Charles I. Jones" — ide o tú istú osobu.</em></small></li>
  <li><small><em>Acemoglu D. The Simple Macroeconomics of AI. NBER Working Paper No. 32487, máj 2024; publikované v Economic Policy. 2025;40(121):13–58. <a href="https://www.nber.org/papers/w32487" target="_blank" rel="noopener noreferrer">NBER</a>. Zdroj jedného z konzervatívnejších odhadov, s ktorým autori porovnávajú mierny scenár.</em></small></li>
  <li><small><em>Acemoglu D, Restrepo P. Artificial Intelligence, Automation and Work. NBER Working Paper No. 24196, január 2018. <a href="https://www.nber.org/papers/w24196" target="_blank" rel="noopener noreferrer">NBER</a>. Rámec vytláčacieho a produktivitného efektu, z ktorého vychádzajú modely založené na úlohách.</em></small></li>
  <li><small><em>Eloundou T, Manning S, Mishkin P, Rock D. GPTs are GPTs: An Early Look at the Labor Market Impact Potential of Large Language Models. arXiv:2303.10130, 17. marca 2023. <a href="https://arxiv.org/abs/2303.10130" target="_blank" rel="noopener noreferrer">arXiv</a>. Práca o expozícii povolaní voči veľkým jazykovým modelom.</em></small></li>
  <li><small><em>Gmyrek P, Berg J, Bescond D. Generative AI and Jobs: A global analysis of potential effects on job quantity and quality. ILO Working Paper 96, Medzinárodná organizácia práce, 21. augusta 2023. <a href="https://www.ilo.org/publications/generative-ai-and-jobs-global-analysis-potential-effects-job-quantity-and" target="_blank" rel="noopener noreferrer">ILO</a>.</em></small></li>
  <li><small><em>Baily MN, Brynjolfsson E, Korinek A. Machines of mind: The case for an AI-powered productivity boom. Brookings Institution, 10. mája 2023. <a href="https://www.brookings.edu/articles/machines-of-mind-the-case-for-an-ai-powered-productivity-boom/" target="_blank" rel="noopener noreferrer">Brookings</a>. Jedna z prác, s ktorými autori porovnávajú podstatný scenár.</em></small></li>
</ol>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ai-ekonomicke-scenare-2030-praca-zdravotnictvo_article',
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
