<?php
/**
 * add_obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Idempotentný UPSERT skript na vloženie/regeneráciu článku.
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia_article.php"
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
    'title'        => 'Obezita v nefrológii: skríning, manažment a vplyv na dialýzu a transplantáciu (praktická optika podľa AJKD Core Curriculum)',
    'slug'         => 'obezita-v-nefrologii-skrining-manazment-dialyza-transplantacia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický prehľad podľa AJKD Core Curriculum: ako skrínovať obezitu pri CKD (BMI a centrálna adipozita), prečo poškodzuje obličky a čo platí pri behaviorálnej liečbe, ketodiétach, dialýze a transplantácii.',
    'content'      => <<<'HTML'
<p>Obezita je najčastejším rizikovým faktorom ochorenia obličiek. V bežnej populácii aj u pacientov s chronickým ochorením obličiek (CKD) nejde len o kardiovaskulárny problém – ide o chronické, často recidivujúce ochorenie, ktoré sa môže výrazne dotýkať viacerých orgánov vrátane obličiek a zároveň zásadne ovplyvňuje priebeh liečby, najmä dialýzy a možnosti transplantácie.</p>

<p>V nefrologickej praxi sa obezita spája s dvoma praktickými „paradoxmi“:</p>

<ol>
  <li><strong>Celková adipozita</strong> môže mať v niektorých kohortách prekvapivo slabšiu alebo opačnú asociáciu s mortalitou (vplyv metabolicky aktívneho tkaniva, skreslenie sprievodnými faktormi a výber pacientov).</li>
  <li><strong>Abdominálna adipozita</strong> (napríklad parametre centrálneho tuku) je konzistentnejšie spojená s horšími výsledkami vrátane mortality u pacientov s CKD.</li>
</ol>

<p>Tieto rozdiely sú dôležité pri rozhodovaní, ako pacienta skrínovať, ako mu vysvetliť riziko a aký cieľ má mať intervencia.</p>

<h2>Prečo obezita poškodzuje obličky: hlavné mechanizmy</h2>

<p>Obezita aktivuje viacero dráh, ktoré podporujú zápal, metabolickú dysreguláciu a hemodynamické zmeny:</p>

<ul>
  <li><strong>Zmeny adipokínov:</strong> nižší adiponektín a vyšší leptín zvyšujú aktiváciu renálneho sympatika a systému renín-angiotenzín-aldosterón. Výsledkom je zvýšená <strong>reabsorpcia sodíka v proximálnom tubule</strong> a vyšší systémový tlak.</li>
  <li><strong>Zmeny perfúzie a glomerulárnej hemodynamiky:</strong> pri zníženom počte nefrónov môže dôjsť k preferenčnej vazodilatácii aferentnej arterioly, ktorá má „udržať“ GFR pri vyšších metabolických nárokoch, čo však narúša autoreguláciu.</li>
  <li><strong>Barotrauma a strata nefrónov:</strong> zvýšený vnútroglomerulárny tlak sa ľahšie prenáša na glomerulárne kapiláry, čím urýchľuje poškodenie a progresiu CKD.</li>
  <li><strong>Ektopické ukladanie mastných kyselín:</strong> ak sa nadbytočné tukové zásoby „nezmestia“ do adipocytov, ukladajú sa aj do svalov, pečene a obličiek. To zvyšuje zápal a inzulínovú rezistenciu a podporuje kardiovaskulárno-metabolické dôsledky v prostredí CKD.</li>
</ul>

<p>Na ilustráciu mechanizmov článok uvádza zjednodušený model, v ktorom obezita urýchľuje progresiu CKD prostredníctvom vnútrokapilárneho tlaku, mechanického stresu a metabolicko-zápalových vplyvov.</p>

<h2>Skríning obezity v nefrologickej praxi</h2>

<h3>BMI: výhody a limity</h3>

<p>Index telesnej hmotnosti (BMI) zostáva najpoužívanejším skríningovým nástrojom, pretože je jednoduchý, dostupný a spojený s mortalitou. Problém je, že:</p>

<ul>
  <li><strong>nedokáže odlíšiť sval od tuku</strong>,</li>
  <li>medzi populáciami sa líši distribúciou tuku,</li>
  <li>sám osebe nemusí najlepšie vystihnúť metabolicky rizikový „typ“ adipozity.</li>
</ul>

<p>Pre dospelých sa uvádzajú tieto prahové hodnoty:</p>

<ul>
  <li><strong>nadváha:</strong> BMI 25 až 29,9 kg/m²,</li>
  <li><strong>obezita:</strong> BMI ≥ 30 kg/m².</li>
</ul>

<p>Obezita sa ďalej delí na triedy:</p>

<ul>
  <li>trieda I: BMI 30,0 až 34,9,</li>
  <li>trieda II: BMI 35,0 až 39,9,</li>
  <li>trieda III: BMI ≥ 40.</li>
</ul>

<p>Pre <strong>ázijskú populáciu</strong> sa pri skríningu rizika používajú nižšie prahy (WHO): nadváha BMI > 23,0 a obezita BMI > 27,5 kg/m², pretože kardiometabolické riziko sa začína už pri nižších hodnotách než u belošskej populácie.</p>

<h3>Centrálna adipozita: prečo môže byť dôležitejšia</h3>

<p>Samotný obvod pása (WC) je „nedokonalý“ marker, pretože je variabilný vzhľadom na distribúciu viscerálneho tuku. Napriek tomu sú parametre centrálnej adipozity klinicky cenné, lebo lepšie odrážajú metabolický a kardiovaskulárny rizikový profil.</p>

<p>Pri všeobecnom hodnotení abdominálnej adipozity sa uvádza obvod pása:</p>

<ul>
  <li>ženy: > 88 cm,</li>
  <li>muži: > 102 cm.</li>
</ul>

<p>Okrem obvodu pása sa v praxi často používajú:</p>

<ul>
  <li><strong>pomer pás/boky</strong> (uvádzané prahy: > 0,9 u mužov a > 0,85 u žien),</li>
  <li><strong>index konicity</strong> (conicity index),</li>
  <li><strong>index zaoblenia tela</strong> (body roundness index),</li>
  <li>prípadne <strong>bioimpedančná analýza (BIA)</strong> a <strong>DXA</strong>, ktoré však hodnotia skôr zloženie tela než výhradne viscerálny tuk.</li>
</ul>

<p>Niektoré odborné spoločnosti odporúčajú rutinné meranie BMI aj obvodu pása. Pri BMI ≥ 35 kg/m² však môže byť obvod pása menej rozlišujúci, keďže väčšina pacientov už má abdominálnu adipozitu.</p>

<h3>Kedy odporúčať chudnutie</h3>

<p>V modelovom prípade pacienta s BMI 26 kg/m², CKD 4. štádia, obštrukčným spánkovým apnoe a osteoartrózou článok rieši otázku, či treba robiť ďalšie merania adipozity (napríklad DXA). Odpoveď je, že <strong>nie</strong> – pri nadváhe v prítomnosti komorbidít asociovaných s adipozitou sa chudnutie odporúča aj bez ďalších špecifických doplnkových testov.</p>

<p>Kľúčový praktický bod: u pacientov s CKD sa zameraj skôr na <strong>prítomnosť komorbidít</strong> a celkový zdravotný cieľ než na „zložitosť“ merania adipozity, ktoré by len zvýšilo záťaž pacienta.</p>

<h2>Behaviorálny intervenčný program: čo má byť jadrom liečby</h2>

<p>Odporúčané behaviorálne intervencie pre osoby s nadváhou alebo obezitou majú trvať <strong>minimálne 6 mesiacov</strong> a majú byť komplexné. Vychádza sa aj z dát programu, ktorý kombinuje:</p>

<ul>
  <li>úpravu stravy,</li>
  <li>cielené cvičenie,</li>
  <li>behaviorálne stratégie a podporu.</li>
</ul>

<h3>Dôkazy a limity pri už rozvinutej CKD</h3>

<p>Zmienka o štúdii LOOK AHEAD (diabetes 2. typu) pomáha pochopiť, čo sa reálne dosiahne:</p>

<ul>
  <li>pri intenzívnom programe bol váhový úbytok významne vyšší (8 % oproti 0,7 % v 1. roku),</li>
  <li>v dlhšom horizonte sa zaznamenal nižší výskyt incidentnej CKD oproti štandardnej starostlivosti, štúdia však nezahŕňala pacientov v štádiu 3B až 5.</li>
</ul>

<p>Článok zároveň jasne upozorňuje, že u osôb s už etablovanou CKD sa zatiaľ nepodarilo presvedčivo preukázať, že behaviorálne intervencie výrazne spomaľujú progresiu CKD alebo znižujú tvrdé renálne a kardiovaskulárne cieľové ukazovatele. Napriek tomu majú význam:</p>

<ul>
  <li>vedú k chudnutiu,</li>
  <li>znižujú krvný tlak,</li>
  <li>zlepšujú kvalitu života a funkčné schopnosti.</li>
</ul>

<h3>Zložky behaviorálnej intervencie</h3>

<p>Článok uvádza praktické zložky programu (strava, vedomé jedenie, pitný režim, pohyb, redukcia stresu, spánok, monitorovanie). Typické nastavenia zahŕňajú napríklad:</p>

<ul>
  <li><strong>kalorický deficit</strong> približne 500 až 750 kcal/deň,</li>
  <li><strong>bielkoviny</strong> okolo 0,8 g/kg ideálnej telesnej hmotnosti/deň,</li>
  <li><strong>vláknina</strong> okolo 24 g/deň,</li>
  <li>vedomé jedenie (mindful eating) – pravidelné jedlá, pomalé jedenie, vyhýbanie sa neplánovanému maškrteniu,</li>
  <li>pitný režim založený najmä na vode a vyhýbanie sa sladeným aj umelo sladeným nápojom,</li>
  <li>pohyb s cieľom 30 až 60 minút pri intenzite približne 65 až 85 % maximálnej tepovej frekvencie aspoň 5 dní v týždni,</li>
  <li>monitorovanie BMI a obvodu pása a sledovanie kvality života.</li>
</ul>

<p>Pri riziku hyperkaliémie sa spomína využiteľnosť <strong>pomeru draslík/vláknina</strong> na výber potravín s nižším rizikom hyperkaliémie.</p>

<h2>Ketogénne diéty pri CKD: prečo sú pri pokročilom CKD skôr nevhodné</h2>

<p>Článok rieši kazuistický dotaz pacienta s CKD 4. štádia, či môže použiť ketogénnu diétu. Záver je jednoznačne praktický:</p>

<ul>
  <li>pri CKD, najmä pokročilom, sa ketogénne diéty <strong>skôr neodporúčajú</strong> pre nedostatok dôkazov o bezpečnosti,</li>
  <li>ketogénna diéta často znamená nízky príjem sacharidov a vysoký príjem tuku, pričom v praxi môže viesť aj k vyššiemu príjmu bielkovín,</li>
  <li>diétna logika pri CKD zdôrazňuje, že nízkosacharidová strava s vysokým obsahom bielkovín sa u pacientov s CKD neodporúča.</li>
</ul>

<p>Text v tejto časti spomína aj diétne rámce pri CKD podľa KDIGO (v kontexte odporúčania 0,8 g bielkovín/kg ideálnej telesnej hmotnosti/deň pre pacientov bez dialýzy) a potrebu starostlivo kontrolovaných nízkobielkovinových stratégií pod vedením registrovaného dietológa.</p>

<p>Z textu vyplývajú dve ďalšie obavy:</p>

<ul>
  <li>ketogénne diéty môžu zvyšovať LDL cholesterol,</li>
  <li>ketogénne diéty zvyšujú riziko obličkových kameňov – podporujú vyššiu exkréciu vápnika do moču, znižujú exkréciu citrátu a znižujú pH moču.</li>
</ul>

<p>Článok síce spomína krátkodobú štúdiu s rastlinnou ketogénnou diétou pri autozomálne dominantnej polycystickej chorobe obličiek (ADPKD), kde bolo priemerné eGFR vysoké a diéta sa po 12 týždňoch hodnotila ako bezpečná a účinná. Hneď však dodáva, že pre krátke trvanie nevieme, či je udržateľná a bezpečná dlhodobo, a preto sa pri CKD, najmä pokročilom, majú ketogénne diéty skôr odradiť.</p>

<h2>Obezita a dialýza: peritoneálna dialýza a Kt/V pri veľkých telesných rozmeroch</h2>

<h3>Peritoneálna dialýza (PD)</h3>

<p>Vhodnosť PD sa nedefinuje podľa jednej antropometrickej miery. Najväčším praktickým problémom pri obezite triedy II a III je, aby pacient dokázal udržať <strong>miesto výstupu katétra viditeľné a trvalo čisté</strong>.</p>

<p>Štúdie opisujú vyššie riziko infekčnej peritonitídy u obéznych pacientov, článok ho však hodnotí ako „mierne“, ktoré samo osebe nemá byť dôvodom PD odmietnuť.</p>

<p>Ak má pacient veľký kožno-tukový previs (panniculus), ktorý by mohol prekryť nižšie umiestnený abdominálny výstup katétra, navrhuje sa alternatívna implantácia:</p>

<ul>
  <li><strong>horný abdominálny predĺžený katéter</strong>, alebo</li>
  <li><strong>presternálny katéter</strong>.</li>
</ul>

<h3>Dialyzačná adekvátnosť a Kt/V</h3>

<p>Obezita komplikuje interpretáciu Kt/V, pretože:</p>

<ul>
  <li>Kt/V závisí od objemu distribúcie močoviny (V),</li>
  <li>výpočet V vychádza z výšky, hmotnosti a veku,</li>
  <li>pri obezite sa V typicky prepočíta ako väčší, než zodpovedá „realite“ jeho distribučných vlastností, čím vzniká <strong>falošne nízky odhad dialyzačnej adekvátnosti</strong>.</li>
</ul>

<p>Preto môžu byť pri obezite užitočnejšie aj iné prístupy:</p>

<ul>
  <li>hodnotenie symptómov a klinický úsudok,</li>
  <li>a ak sú dostupné, metódy ako <strong>bioimpedancia alebo kinetické modelovanie</strong>, ktoré môžu obísť chyby vo výpočte V.</li>
</ul>

<p>Dôležitým praktickým dodatkom je častejší režim monitorovania a úprav predpisu PD u obéznych pacientov, ako aj to, že úbytok reziduálnej renálnej funkcie môže byť pri vyššom BMI rýchlejší.</p>

<h2>Obezita a transplantácia obličky: zaradenie na čakaciu listinu, operačné riziká a zmysel chudnutia</h2>

<p>V Spojených štátoch je ťažká obezita najčastejšou bariérou, pre ktorú sa pacienti nedostanú na čakaciu listinu. BMI limity na zaradenie sa medzi centrami líšia, pričom tieto rozdiely prispeli k nerovnostiam v dostupnosti transplantácie medzi skupinami.</p>

<h3>Čo hovorí rizikový profil</h3>

<ul>
  <li><strong>Celková adipozita</strong> je v niektorých dátach spojená s nižšou mortalitou pri CKD vrátane pacientov na hemodialýze.</li>
  <li><strong>Pomer pás/boky</strong> (abdominálna adipozita) je spojený s vyššou mortalitou aj u pacientov na dialýze.</li>
</ul>

<h3>Prežívanie: transplantácia verzus dialýza</h3>

<p>Praktický záver z dostupných dát: prežívanie pacienta s BMI približne 45 kg/m² sa maximalizuje transplantáciou, nie dialýzou.</p>

<p>Článok uvádza, že:</p>

<ul>
  <li>pri BMI ≤ 40 kg/m² je zníženie mortality pri transplantácii oproti pacientom zaradeným na čakaciu listinu bez transplantácie <strong>viac než 60 %</strong>,</li>
  <li>pri obezite triedy III je prínos stále prítomný, ale menší,</li>
  <li>prežívanie štepu (allograftu) sa pre samotnú obezitu nezdá byť lepšie, no prežívanie pacienta môže byť vďaka transplantácii lepšie.</li>
</ul>

<h3>Chirurgické riziká a kontroverzia okolo BMI limitu</h3>

<p>Obezita zvyšuje riziko komplikácií, najmä chirurgických. Preto je kontroverzné, či existuje presný BMI prah, pri ktorom by riziko transplantácie prevážilo nad jej prínosom. Aj tam, kde platia prísne limity, článok zdôrazňuje, že:</p>

<ul>
  <li>chudnutie síce môže zlepšiť šance, ale nie je „garanciou“,</li>
  <li>pri BMI ≥ 40 kg/m² je opísané vyššie riziko oneskoreného funkčného nástupu štepu, akútnej rejekcie, komplikácií rany, ako aj dlhších operačných časov a hospitalizácií,</li>
  <li>KDIGO 2020 podľa textu odporúča, aby obezita sama osebe nebola dôvodom na vylúčenie z transplantácie.</li>
</ul>

<h2>Komunikácia s pacientom: ako otvoriť tému chudnutia bez stigmy</h2>

<p>Pri otváraní témy chudnutia text kladie dôraz na komunikačný postup:</p>

<ul>
  <li>najprv si vyžiadať <strong>súhlas pacienta</strong>, či je možné hovoriť o chudnutí ako o intervencii na dosiahnutie konkrétneho cieľa (napríklad zaradenia na čakaciu listinu),</li>
  <li>vyhýbať sa stigmatizujúcim výrazom ako „obezita“ alebo „tuk“,</li>
  <li>rámcovať diskusiu ako prínos pre zdravie a konkrétny výsledok,</li>
  <li>pred zvažovaním medicínskych krokov preveriť bariéry ako poruchy príjmu potravy a sociálne faktory.</li>
</ul>

<h2>Zhrnutie pre klinickú prax</h2>

<ul>
  <li>skríning rob cez <strong>BMI</strong> a podľa situácie doplň aj <strong>centrálnu adipozitu (obvod pása, pomer pás/boky)</strong>,</li>
  <li>pri <strong>nadváhe alebo obezite s komorbiditami</strong> pri CKD je chudnutie na mieste aj bez „overovania“ adipozity ďalšími drahými meraniami,</li>
  <li>behaviorálne intervencie majú byť dlhé, komplexné a prakticky uskutočniteľné pre reálneho pacienta,</li>
  <li>ketogénne diéty pri CKD, najmä pokročilom, skôr odmietať pre riziká a nedostatok dôkazov,</li>
  <li>pri obezite a PD počítať s praktickými aspektmi katétra a uvedomiť si limit Kt/V (falošne nízka adekvátnosť),</li>
  <li>pri transplantácii myslieť najmä na <strong>zmysel transplantácie pre prežitie</strong>, ale súčasne rátať so zvýšenými chirurgickými rizikami a centrovými limitmi,</li>
  <li>o chudnutí komunikovať citlivo a v kontexte konkrétneho cieľa.</li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> <em>AJKD Core Curriculum in Nephrology: Obesity in Kidney Disease</em>, American Journal of Kidney Diseases (AJKD), 2026. <a href="https://www.ajkd.org/article/S0272-6386(26)00847-4/fulltext" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</em></p>
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
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
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
