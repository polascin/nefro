<?php
/**
 * add_glp1-kompulzivne-spravanie-food-noise-nefrologia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok (category = default 'odborne'): agonisty GLP-1 receptorov,
 * „food noise“, kompulzívne správanie a praktický nefrologický pohľad.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-kompulzivne-spravanie-food-noise-nefrologia_article.php"
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
    'title'        => 'GLP-1 agonisty, „food noise“ a kompulzívne správanie: čo to znamená pre nefrológiu',
    'slug'         => 'glp1-kompulzivne-spravanie-food-noise-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Agonisty GLP-1 receptorov môžu u časti pacientov tlmiť nielen hlad, ale aj naliehavosť cravingu a „food noise“. Pre nefrológiu je dôležité rozlíšiť sľubný neurobiologický signál od neschválených indikácií a sledovať bezpečnosť pri CKD.',
    'content'      => <<<'HTML'
<p>Lieky pôsobiace cez receptor GLP-1 boli pôvodne vyvíjané ako antidiabetiká. Neskôr zásadne zmenili liečbu obezity a postupne vstúpili aj do diskusie o kardiorenálnej ochrane. Dnes sa okolo nich otvára ďalšia, zatiaľ opatrná, ale vedecky veľmi zaujímavá otázka: môžu ovplyvňovať aj kompulzívne správanie, craving a nutkavé vyhľadávanie odmeňujúcich podnetov?</p>

<p>Medscape túto tému približuje cez pacientsky pojem <strong>„food noise“</strong>. Nejde o bežný hlad, ale o vnútorný mentálny hluk spojený s jedlom: vtieravé, opakované a ťažko ovládateľné myšlienky najmä na vysoko odmeňujúce ultraprocesované potraviny. U časti pacientov sa po nasadení GLP-1 liečby tento „hluk“ výrazne stíši. Klinicky zaujímavé je, že pacienti často nehovoria iba o menšom hlade, ale o menšej naliehavosti impulzu.</p>

<p>Pre nefrológiu to nie je okrajová téma. Agonisty GLP-1 receptorov a príbuzné inkretínové lieky sa čoraz častejšie používajú u pacientov s diabetes mellitus 2. typu, obezitou, kardiovaskulárnym rizikom a chronickou chorobou obličiek (CKD). Ak zároveň ovplyvňujú vzťah k jedlu, alkoholu, nikotínu alebo impulzívnym návykom, môže to mať praktický dopad na celkový kardiorenálny rizikový profil pacienta.</p>

<h2>Od glukózy k systému odmeny</h2>

<p>Agonisty GLP-1 receptorov zvyšujú glukózovo závislú sekréciu inzulínu, ovplyvňujú pocit sýtosti, spomaľujú vyprázdňovanie žalúdka, znižujú príjem potravy a vedú k poklesu telesnej hmotnosti. To je známa metabolická časť ich účinku.</p>

<p>Novšia výskumná línia sa však pýta, či tieto lieky nezasahujú aj mozgové okruhy zodpovedné za odmenu, motiváciu, craving a kompulzívne vyhľadávanie odmeňujúcich podnetov. Tento posun je dôležitý. Ak pacient prestane neustále myslieť na jedlo, nemusí to byť len dôsledok plného žalúdka. Môže ísť aj o zmenu toho, akú naliehavosť mozog pripisuje potravinovým podnetom.</p>

<p>Biologická vierohodnosť tejto hypotézy nie je nová. GLP-1 signalizácia je prítomná aj v centrálnom nervovom systéme a experimentálne práce už dávnejšie ukázali vplyv GLP-1 na príjem potravy. Nové je najmä to, že klinické skúsenosti a modernejšie štúdie posúvajú otázku od „hladu“ k širšej neurobiológii motivácie.</p>

<h2>„Chcenie“ a „páčenie“ nie sú to isté</h2>

<p>Kľúčové je rozlíšenie medzi dvoma procesmi, ktoré sa v anglickej neurovede označujú ako <em>liking</em> a <em>wanting</em>. <em>Liking</em> znamená hedonický pôžitok z odmeny. <em>Wanting</em> znamená motivačný ťah smerom k odmene, teda naliehavé „chcenie“.</p>

<p>Tieto dva procesy sa často prekrývajú, ale nie sú totožné. Človek môže niečo chcieť aj vtedy, keď mu to už neprináša veľké potešenie. Práve tento rozdiel je dôležitý pri závislostiach, kompulzívnom jedení, hazardnom správaní a iných poruchách kontroly impulzov.</p>

<p>Dopamínový systém, kedysi zjednodušene chápaný ako systém pôžitku, sa dnes viac spája s motiváciou, salienciou podnetu a vyhľadávaním odmeny. Ak sa tento systém stane senzibilizovaným, bežný podnet môže spúšťať neúmerne silné „chcenie“. Pacient to môže vnímať ako nutkanie, ktoré sa cíti menej ako rozhodnutie a viac ako príkaz. Agonisty GLP-1 receptorov môžu podľa tejto hypotézy znižovať práve intenzitu „chcenia“, nie nevyhnutne samotný pôžitok.</p>

<h2>Alkohol a nikotín: sľubné, ale zatiaľ skoré dáta</h2>

<p>Najkonkrétnejšie klinické dáta sa zatiaľ týkajú alkoholu. Randomizovaná klinická štúdia publikovaná v <em>JAMA Psychiatry</em> v roku 2025 ukázala, že nízkodávkovaný semaglutid u dospelých s poruchou užívania alkoholu znížil množstvo alkoholu skonzumovaného v laboratórnom modeli sebapodávania. Počas 9 týždňov liečby sa zlepšili niektoré, nie však všetky ukazovatele pitia, a významne klesol týždenný craving po alkohole.</p>

<p>Silnejší klinický signál priniesla randomizovaná štúdia v <em>The Lancet</em> z roku 2026. Zahŕňala pacientov s poruchou užívania alkoholu a obezitou, ktorí dostávali semaglutid alebo placebo počas 26 týždňov. Semaglutid viedol k väčšiemu poklesu dní s ťažkým pitím, celkovej mesačnej konzumácie alkoholu, sebahodnoteného cravingu a niektorých biomarkerov súvisiacich s alkoholovou expozíciou.</p>

<p>Pri nikotíne sú údaje zatiaľ menej jednoznačné. Fáza 2a randomizovanej štúdie publikovanej v <em>JAMA Network Open</em> v roku 2026 u dospelých denných fajčiarov nepreukázala jasný pokles počtu vyfajčených cigariet za deň v primárnych testoch, ale ukázala signál zníženia nikotínového cravingu a hmotnosti. To je dôležitý rozdiel: liek nemusí hneď zmeniť celé správanie, ale môže oslabiť jeho vnútornú naliehavosť.</p>

<h2>Veľké observačné dáta: užitočné, nie kauzálne</h2>

<p>Ďalší diel skladačky priniesla veľká kohortová štúdia v <em>BMJ</em> z roku 2026, ktorá analyzovala údaje viac než 600 000 amerických veteránov s diabetes mellitus 2. typu. V dizajne emulácie cieľových štúdií bolo začatie liečby agonistom GLP-1 receptora v porovnaní so začatím liečby inhibítorom SGLT2 spojené s nižším rizikom nových porúch užívania látok. U pacientov s už existujúcou poruchou užívania látok bolo používanie GLP-1 liečby spojené aj s nižším rizikom niektorých nepriaznivých klinických udalostí.</p>

<p>Takéto dáta sú zaujímavé, ale treba ich čítať správne. Observačná štúdia ani pri kvalitnom dizajne nedokazuje kauzalitu. Môže v nej pretrvávať reziduálne skreslenie, rozdiely v správaní pacientov, dostupnosti starostlivosti alebo v závažnosti základného ochorenia. Je to dôvod na ďalší výskum, nie dôkaz, že GLP-1 lieky sú hotovou liečbou závislostí.</p>

<h2>Food noise a ultraprocesované potraviny</h2>

<p>Pojem „food noise“ nie je oficiálna diagnóza. Napriek tomu zachytáva opakovanú pacientsku skúsenosť: jedlo nie je iba fyziologická potreba, ale aj mentálny objekt, ktorý sa stále vracia do pozornosti. Dôležitý detail je, že pacienti zvyčajne nehovoria o vtieravých myšlienkach na strukoviny, zeleninu alebo ryby. Často opisujú nutkanie na vysoko odmeňujúce ultraprocesované potraviny bohaté na rafinované sacharidy, tuky a soľ.</p>

<p>Tieto potraviny sú navrhnuté tak, aby rýchlo a účinne aktivovali systém odmeny. U časti pacientov preto problémom nie je iba hlad, ale nadmerná saliencia potravinových podnetov: jedlo sa stáva príliš prítomné, príliš naliehavé a príliš ťažko ignorovateľné.</p>

<p>Ak GLP-1 liečba znižuje preokupáciu jedlom, môže to mať význam aj pre pacienta s CKD. Lepšia kontrola večerného jedenia, ultraprocesovaných potravín, sladkých nápojov alebo epizód straty kontroly môže nepriamo pomôcť pri redukcii hmotnosti, krvného tlaku, inzulínovej rezistencie a kardiometabolického rizika.</p>

<h2>Centrálna amygdala a odmeňujúce jedlo</h2>

<p>Experimentálna práca publikovaná v <em>Nature</em> v roku 2026 ukázala u myší, že novšie malé molekuly pôsobiace cez GLP-1 receptor môžu zasiahnuť mozgový okruh súvisiaci s odmeňujúcim jedením. Autori identifikovali neuróny exprimujúce GLP-1 receptor v centrálnej amygdale a ukázali, že aktivácia tohto okruhu znižuje konzumáciu vysoko palatabilnej potravy cez následné ovplyvnenie dopamínovej signalizácie.</p>

<p>Tento nález je biologicky veľmi zaujímavý, ale jeho klinická interpretácia musí byť opatrná. Ide o experiment u myší, nie o priamy dôkaz ľudskej skúsenosti „food noise“. Navyše sa týka najmä novších malomolekulových GLP-1 liekov, nie automaticky všetkých dostupných injekčných inkretínových terapií. Napriek tomu ukazuje vierohodnú cestu, ktorou môže GLP-1 signalizácia ovplyvňovať motivované správanie oddelene od klasickej regulácie hladu a sýtosti.</p>

<h2>Riziko príliš širokého tlmenia motivácie</h2>

<p>Dôležitou otázkou je špecificita účinku. Ideálny liek by znížil patologicky silné nutkanie, ale neznižoval by normálnu radosť, záujem, energiu a motiváciu. V praxi to nemusí byť také jednoduché.</p>

<p>Niektorí pacienti užívajúci GLP-1 lieky opisujú emočné otupenie, nižšiu motiváciu alebo menší záujem o bežné príjemné aktivity. Mediálne sa objavuje aj pojem „Ozempic personality“. Vedecké dôkazy sú zatiaľ nejednotné, ale otázka je klinicky relevantná. Ak liek tlmí mezolimbické „chcenie“, treba vedieť, či prednostne tlmí škodlivé cravingy, alebo aj širšie spektrum normálnych túžob.</p>

<p>Preto sa pri uvažovaní o GLP-1 liekoch v adiktológii alebo psychiatrii nedá preskočiť psychologická a behaviorálna liečba. Farmakoterapia môže znížiť naliehavosť impulzu, ale prostredie, návyky, stresové spúšťače a naučené vzorce správania zostávajú klinicky dôležité.</p>

<h2>Význam pre nefrologickú prax</h2>

<p>V nefrologickej ambulancii sa GLP-1 receptorové agonisty a príbuzné inkretínové lieky objavujú najmä u pacientov s diabetom 2. typu, obezitou, kardiovaskulárnym rizikom a CKD. Bežne sledujeme hmotnosť, HbA1c, eGFR, albuminúriu, krvný tlak, gastrointestinálnu toleranciu a kardiovaskulárne riziko. Nové poznatky však naznačujú, že sa oplatí pýtať aj na správanie.</p>

<p>Pacient môže počas liečby spontánne alebo na cielenú otázku hlásiť:</p>

<ul>
  <li>menšie nutkanie jesť večer alebo v noci,</li>
  <li>menšiu preokupáciu jedlom a sladkými či slanými ultraprocesovanými potravinami,</li>
  <li>znížený craving po alkohole,</li>
  <li>zmeny vo vzťahu k fajčeniu,</li>
  <li>oslabenie niektorých impulzívnych návykov,</li>
  <li>alebo naopak nižšiu motiváciu, emočné otupenie či nepríjemnú stratu záujmu.</li>
</ul>

<p>Pri CKD je to dôležité z dvoch dôvodov. Po prvé, kompulzívne jedenie, alkohol, fajčenie a obezita priamo zhoršujú kardiorenálne riziko. Po druhé, nežiaduce účinky GLP-1 liekov, najmä nauzea, vracanie, znížený príjem tekutín a dehydratácia, môžu pri CKD zvýšiť riziko prechodného zhoršenia renálnej funkcie, najmä pri súčasnej liečbe diuretikami, blokádou RAAS alebo inhibítormi SGLT2.</p>

<h2>Klinické hranice interpretácie</h2>

<p>Táto oblasť je sľubná, ale ešte nie definitívna. Z dostupných dát nevyplýva, že GLP-1 lieky sú schválenou liečbou závislostí, kompulzívneho jedenia, hazardu, impulzivity alebo iných behaviorálnych problémov. Výskum je dynamický, no treba rozlišovať medzi biologicky vierohodným mechanizmom, observačnou asociáciou, malou randomizovanou štúdiou, anekdotickou skúsenosťou pacienta a štandardnou indikáciou schválenou regulačnými autoritami.</p>

<p>V praxi má byť použitie GLP-1 liečby stále postavené na schválených indikáciách, klinickom prínose, bezpečnosti, dostupnosti a individuálnom posúdení pacienta. Ak má pacient poruchu užívania alkoholu, nikotínovú závislosť, poruchu príjmu potravy alebo inú behaviorálnu poruchu, GLP-1 liek nemá nahrádzať štandardnú psychiatrickú, adiktologickú alebo psychologickú starostlivosť.</p>

<h2>Praktický záver</h2>

<p>Agonisty GLP-1 receptorov menia naše chápanie obezity, diabetu a možno aj niektorých foriem kompulzívneho správania. Ich účinok zrejme nespočíva iba v tom, že pacient je menej hladný. U časti pacientov sa mení aj naliehavosť podnetov, intenzita cravingu a subjektívny pocit kontroly.</p>

<p>Pre nefrologickú prax to znamená, že tieto lieky treba vnímať širšie než len ako antidiabetiká alebo antiobezitiká. U pacienta s diabetom, obezitou a CKD môžu nepriamo zlepšovať rizikový profil aj tým, že pomáhajú znižovať škodlivé návyky spojené s jedlom, alkoholom alebo metabolickým správaním.</p>

<p>Zároveň však nesmieme zjednodušovať. GLP-1 lieky nie sú univerzálnym riešením kompulzií, neúčinkujú u každého a nemajú byť náhradou behaviorálnej liečby. Najrozumnejší záver je opatrne optimistický: táto lieková trieda nám ukazuje, že hranica medzi črevom, metabolizmom, mozgom, odmenou a správaním je oveľa tesnejšia, než sa kedysi predpokladalo.</p>

<hr>

<p><em><strong>Zdroj:</strong> Spitznagel E. What GLP-1s Are Teaching Us About Compulsive Behavior. <em>Medscape Medical News</em>. 23. júna 2026. <a href="https://www.medscape.com/viewarticle/what-glp-1s-are-teaching-us-about-compulsive-behavior-2026a1000l4c" target="_blank" rel="noopener noreferrer">Medscape</a>.</em></p>

<p><em><strong>Primárne odborné zdroje:</strong> Hendershot CS et al. Once-Weekly Semaglutide in Adults With Alcohol Use Disorder. <em>JAMA Psychiatry</em>. 2025;82(4):395. doi:10.1001/jamapsychiatry.2024.4789. Klausen MK et al. Once-weekly semaglutide versus placebo in patients with alcohol use disorder and comorbid obesity. <em>The Lancet</em>. 2026;407(10540):1687–1698. doi:10.1016/S0140-6736(26)00305-3. Godschall EN et al. A brain reward circuit inhibited by next-generation weight-loss drugs in mice. <em>Nature</em>. 2026;654(8120):1055–1064. doi:10.1038/s41586-026-10444-4. Cai M, Choi T, Xie Y, Al-Aly Z. GLP-1 receptor agonists and risk of substance use disorders among US veterans with type 2 diabetes. <em>BMJ</em>. 2026;392:e086886. doi:10.1136/bmj-2025-086886.</em></p>
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
                error_log('add_glp1_compulsive newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_glp1_compulsive pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_glp1_compulsive pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_glp1_compulsive migration error: ' . $e->getMessage());
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
