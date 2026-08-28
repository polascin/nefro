<?php
/**
 * add_nove-odporucania-dyslipidemia-prevent-ldl-ciele_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie článku do DB (INSERT IGNORE → idempotentný).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_nove-odporucania-dyslipidemia-prevent-ldl-ciele_article.php"
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Nové odporúčania pre dyslipidémiu: PREVENT namiesto starého kalkulátora a nižšie cieľové hodnoty LDL',
    'slug'         => 'nove-odporucania-dyslipidemia-prevent-ldl-ciele',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Odporúčania ACC/AHA/ADA pre dyslipidémiu z roku 2026 zavádzajú kalkulátor PREVENT, hodnotenie 10- aj 30-ročného rizika, jasnejšie cieľové hodnoty LDL a väčší dôraz na ApoB, Lp(a) a koronárne kalciové skóre. Pri sekundárnej prevencii sa kľúčovou hodnotou stáva LDL pod 55 mg/dl (1,4 mmol/l).',
    'content'      => <<<'HTML'
<p>Nové odporúčania ACC/AHA/ADA pre manažment dyslipidémie z roku 2026 prinášajú viacero prakticky dôležitých zmien. Nejde len o kozmetickú úpravu starých pravidiel. Mení sa spôsob odhadu kardiovaskulárneho rizika, zavádzajú sa jasnejšie rizikové kategórie, viac sa pracuje s celoživotným rizikom a pri vyššom riziku sa cieľové hodnoty LDL cholesterolu posúvajú nižšie.</p>

<p>Hlavné posolstvo pre prax je jednoduché: liečba dyslipidémie má byť viac individualizovaná, viac založená na aktuálnejšom odhade rizika a pri rizikových pacientoch dostatočne intenzívna. Zároveň platí, že samotné číslo LDL nestačí. Treba ho interpretovať v kontexte veku, diabetu, chronickej choroby obličiek, aterosklerotického ochorenia, rodinnej anamnézy a ďalších rizikových markerov.</p>

<h2>PREVENT nahrádza starý ASCVD kalkulátor</h2>

<p>Jednou z najväčších zmien je prechod od starého kalkulátora pooled cohort equation, známeho ako PCE, k novému kalkulátoru PREVENT.</p>

<p>Starý PCE kalkulátor vychádzal z dát približne 25 000 ľudí z rokov 1960 až 1990. Nový PREVENT kalkulátor je založený na podstatne modernejšom súbore viac než 3 miliónov ľudí. Má preto lepšie odrážať súčasné populačné riziko.</p>

<p>Dôležité je, že PREVENT umožňuje vypočítať nielen 10-ročné, ale aj 30-ročné riziko. To má význam najmä u mladších ľudí do 50 rokov. Tí môžu mať nízke 10-ročné riziko len preto, že sú mladí, ale ich dlhodobé riziko môže byť vysoké.</p>

<p>Treba však poznať jeden praktický detail. PREVENT zvyčajne dáva približne polovičný odhad 10-ročného rizika v porovnaní so starým PCE kalkulátorom. Preto sa v nových odporúčaniach znížili hranice rizika, pri ktorých sa uvažuje o liečbe. Na prvý pohľad môžu vyzerať agresívnejšie, ale v skutočnosti majú zachytiť podobnú skupinu pacientov ako predchádzajúci systém.</p>

<h2>Primárna prevencia: nové rizikové kategórie</h2>

<p>V primárnej prevencii sa rozhodovanie opiera o 10-ročné riziko vypočítané podľa PREVENT.</p>

<h3>Nízke riziko: menej ako 3 %</h3>

<p>Pacienti s 10-ročným rizikom pod 3 % sa považujú za nízkorizikových. Ak majú LDL cholesterol pod 160 mg/dl (4,1 mmol/l) a 30-ročné riziko pod 10 %, základom je poradenstvo o životnom štýle.</p>

<p>Ak je však LDL v rozmedzí 160 až 189 mg/dl (4,1 až 4,9 mmol/l) alebo ak je 30-ročné riziko aspoň 10 % vo veku 30 až 50 rokov, stredne intenzívny statín je rozumnou možnosťou. Toto je dôležitý posun. Odporúčania viac myslia na kumulatívnu celoživotnú expozíciu aterogénnym lipoproteínom, nielen na krátkodobé 10-ročné riziko.</p>

<h3>Hraničné riziko: 3 až 5 %</h3>

<p>Pri 10-ročnom riziku 3 až 5 % možno zvážiť liečbu stredne intenzívnym statínom. Toto je skupina, kde je obzvlášť dôležité personalizovať rozhodovanie.</p>

<p>Pomôcť môžu takzvané riziko modifikujúce faktory:</p>

<ul>
  <li>rodinná anamnéza predčasného aterosklerotického ochorenia,</li>
  <li>apolipoproteín B,</li>
  <li>lipoproteín(a),</li>
  <li>koronárne kalciové skóre.</li>
</ul>

<p>Ak sa liečba v tejto skupine začne, cieľom je LDL cholesterol pod 100 mg/dl (2,6 mmol/l).</p>

<h3>Stredné riziko: 5 až 10 %</h3>

<p>Pacienti s 10-ročným rizikom 5 až 10 % patria do skupiny stredného rizika. U nich sa má zvážiť LDL znižujúca liečba aspoň stredne intenzívnym statínom.</p>

<p>Pri vyššom konci tohto rizikového pásma môže byť vhodný aj vysoko intenzívny statín. Cieľová hodnota LDL cholesterolu je pod 100 mg/dl (2,6 mmol/l).</p>

<h3>Vysoké riziko: nad 10 %</h3>

<p>Pri 10-ročnom riziku nad 10 % ide podľa nového systému o vysoké riziko. Cieľová hodnota LDL cholesterolu je tu 70 mg/dl (1,8 mmol/l) alebo menej.</p>

<p>Ak sa cieľ nedosiahne samotným statínom, je rozumné pridať ezetimib. Tento postup môže na prvý pohľad pôsobiť prísne, ale treba si uvedomiť, že pacienti s rizikom nad 10 % podľa PREVENT by často mali podľa starého PCE kalkulátora riziko nad 20 %.</p>

<h2>Skupiny, kde netreba čakať na kalkulátor</h2>

<p>Niektorí pacienti majú indikáciu na statín bez potreby výpočtu 10-ročného rizika. Patria sem dospelí vo veku 40 až 75 rokov s:</p>

<ul>
  <li>diabetom,</li>
  <li>chronickou chorobou obličiek štádia 3 alebo 4,</li>
  <li>infekciou HIV,</li>
  <li>LDL cholesterolom nad 190 mg/dl (4,9 mmol/l).</li>
</ul>

<p>Pri LDL nad 190 mg/dl (4,9 mmol/l) je cieľom dostať LDL pod 100 mg/dl (2,6 mmol/l). Ak má pacient diabetes a viacero rizikových faktorov, cieľ je prísnejší: LDL pod 70 mg/dl (1,8 mmol/l).</p>

<p>Pre nefrologickú prax je dôležité, že CKD štádia 3 a 4 zostáva samostatnou rizikovou kategóriou. U týchto pacientov sa nemá rozhodovanie odkladať len preto, že kalkulátor vyjde relatívne priaznivo. CKD samo osebe významne zvyšuje kardiovaskulárne riziko.</p>

<h2>ApoB: keď LDL nemusí povedať všetko</h2>

<p>Apolipoproteín B môže pomôcť najmä v situáciách, keď LDL cholesterol neodráža úplne aterogénnu záťaž. ApoB lepšie reprezentuje počet aterogénnych lipoproteínových častíc.</p>

<p>Môže byť užitočný napríklad pri metabolickom syndróme, hypertriglyceridémii, diabete 2. typu alebo u pacientov, u ktorých je LDL zdanlivo prijateľný, ale reziduálne riziko zostáva vysoké.</p>

<p>Prakticky povedané: ApoB nenahrádza LDL u každého pacienta, ale môže spresniť rozhodovanie u vybraných rizikových pacientov.</p>

<h2>Lp(a): zmerať aspoň raz za život</h2>

<p>Nové odporúčania zdôrazňujú, že lipoproteín(a), teda Lp(a), by sa mal zmerať aspoň raz za život. Za riziko zvyšujúci faktor sa považuje hodnota nad 125.</p>

<p>Dnes ešte nie je bežne dostupná špecifická liečba znižujúca Lp(a), ale meranie má aj tak význam. Podobne ako rodinná anamnéza pomáha lepšie pochopiť celkové riziko pacienta. Ak je Lp(a) vysoký, môže to viesť k intenzívnejšej kontrole ostatných ovplyvniteľných rizikových faktorov, najmä LDL cholesterolu, krvného tlaku, fajčenia a diabetu.</p>

<p>Druhý dôvod je výhľad do blízkej budúcnosti. Liečby cielene znižujúce Lp(a) sú vo vývoji a v najbližších rokoch môžu zmeniť klinickú prax.</p>

<h2>Koronárne kalciové skóre: užitočný nástroj pri neistote</h2>

<p>Koronárne kalciové skóre má v odporúčaniach silnejšie miesto. Je osobitne užitočné u mužov nad 40 rokov a u žien nad 45 rokov, najmä ak je pacient v hraničnej alebo strednej rizikovej kategórii a rozhodnutie o statíne nie je jasné.</p>

<p>Interpretácia je praktická:</p>

<ul>
  <li>CAC skóre 0 znamená nízke riziko koronárnej príhody v najbližších približne 5 rokoch. Statín zvyčajne nie je potrebný a vyšetrenie možno zopakovať o 3 až 7 rokov.</li>
  <li>CAC skóre 1 až 99 znamená, že liečba je rozumná, s cieľom LDL pod 100 mg/dl (2,6 mmol/l).</li>
  <li>CAC skóre 100 až 999 podporuje odporúčanie LDL znižujúcej liečby s cieľom pod 70 mg/dl (1,8 mmol/l).</li>
  <li>CAC skóre nad 1000 môže viesť k úvahe o veľmi prísnom cieli LDL pod 55 mg/dl (1,4 mmol/l).</li>
</ul>

<p>Tento prístup má výhodu v komunikácii s pacientom. Namiesto abstraktného percenta rizika vidí konkrétny dôkaz aterosklerotického postihnutia koronárnych artérií. Zároveň však treba zvážiť dostupnosť, náklady, radiačnú záťaž a klinickú primeranosť vyšetrenia.</p>

<h2>Sekundárna prevencia: LDL pod 55 mg/dl (1,4 mmol/l) sa stáva kľúčovou hodnotou</h2>

<p>V sekundárnej prevencii sú odporúčania výrazne prísnejšie. Ide o pacientov s už prítomným aterosklerotickým kardiovaskulárnym ochorením, napríklad po infarkte myokardu, akútnom koronárnom syndróme, ischemickej cievnej mozgovej príhode alebo s periférnym artériovým ochorením.</p>

<p>Podľa odporúčaní bude väčšina pacientov s anamnézou ASCVD pravdepodobne patriť do veľmi vysokého rizika. Pre nich je cieľová hodnota LDL cholesterolu pod 55 mg/dl (1,4 mmol/l).</p>

<p>To má praktický dôsledok: vysokointenzívny statín často nebude stačiť. Odporúčania preto zdôrazňujú potrebu včas pridávať ďalšie lieky, ak sa cieľ nedosiahne.</p>

<p>Do úvahy prichádzajú:</p>

<ul>
  <li>ezetimib,</li>
  <li>inhibítory PCSK9,</li>
  <li>kyselina bempedoová,</li>
  <li>inklisiran.</li>
</ul>

<p>Dôležité je neuspokojiť sa s „celkom dobrým“ LDL, ak pacient patrí do veľmi vysokého rizika. Pri sekundárnej prevencii je reziduálne riziko vysoké a cieľ má byť primerane ambiciózny.</p>

<h2>Čo to znamená pre ambulantnú prax</h2>

<p>Tieto odporúčania budú mať najväčší dopad v bežnej ambulancii. Dyslipidémia je častá, ale jej liečba často trpí dvoma opačnými problémami: niektorí nízkorizikoví pacienti sú liečení príliš automaticky, zatiaľ čo vysokorizikoví pacienti nedosahujú dostatočne nízke hodnoty LDL.</p>

<p>Nový prístup je presnejší. Pri nízkom alebo hraničnom riziku podporuje individualizáciu a využitie doplňujúcich markerov. Pri vysokom a veľmi vysokom riziku naopak tlačí na dôslednejšie dosahovanie cieľových hodnôt.</p>

<p>Pre pacienta je vhodné vysvetlenie bez zbytočného strašenia: cholesterol sa nelieči izolovane, lieči sa celkové riziko. To isté LDL môže mať iný význam u mladého nízkorizikového človeka a úplne iný význam u pacienta po infarkte, s diabetom alebo s chronickou chorobou obličiek.</p>

<h2>Praktický klinický záver</h2>

<p>Nové odporúčania pre dyslipidémiu prinášajú štyri hlavné zmeny: používanie kalkulátora PREVENT, hodnotenie 10-ročného aj 30-ročného rizika, jasnejšie cieľové hodnoty LDL podľa rizika a väčší dôraz na individualizáciu pomocou ApoB, Lp(a) a koronárneho kalciového skóre.</p>

<p>V primárnej prevencii sa rozhodovanie stáva jemnejším. V sekundárnej prevencii sa ciele sprísňujú, pričom LDL pod 55 mg/dl (1,4 mmol/l) sa stáva kľúčovou hodnotou pre väčšinu pacientov s ASCVD.</p>

<p>Najpraktickejšie posolstvo je toto: najskôr správne určiť riziko, potom zvoliť primerane intenzívnu liečbu a následne skutočne kontrolovať, či pacient dosiahol cieľ. Pri vysokom riziku nestačí statín predpísať. Treba sa uistiť, že výsledný LDL zodpovedá riziku pacienta.</p>

<div class="info-box-blue">
<p><strong>Poznámka — prepočet jednotiek cholesterolu.</strong> Hodnoty v mmol/l uvedené v zátvorkách sú prepočítané z mg/dl a zaokrúhlené na jedno desatinné miesto. Pre cholesterol (LDL, HDL aj celkový cholesterol) platí:</p>
<ul>
  <li>mmol/l = mg/dl ÷ 38,67 (čiže mg/dl × 0,02586),</li>
  <li>mg/dl = mmol/l × 38,67.</li>
</ul>
<p>Pre triglyceridy platí odlišný prepočítavací faktor: mmol/l = mg/dl ÷ 88,57 (× 0,01129) a mg/dl = mmol/l × 88,57.</p>
</div>

<hr>

<p><em><strong>Zdroj:</strong> Medscape, <em>2026 Dyslipidemia Guideline: Key Takeaways for Primary Care</em> (2026). <a href="https://www.medscape.com/viewarticle/2026-dyslipidemia-guideline-key-takeaways-primary-care-2026a1000hcu" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

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
        // Newsletter avíza posielame LEN pri novom článku (rc === 1), nikdy pri update.
        $rc = $stmt->rowCount();
        if ($rc === 1) {
            $inserted++;
            $newId = (int) $pdo->lastInsertId();
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $newId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } elseif ($rc === 2) {
            $updated++;
        } else {
            $skipped++;
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
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

          <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
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
