<?php
/**
 * add_korekcia-hyponatriemie-rychlost-bezpecnost_article.php
 * Odborny clanok o rychlosti korekcie hyponatriemie: hypotonicka
 * hyponatriemia, urgentna liecba hypertonickym roztokom, bezpecnostne
 * limity verzus cielovy denny vzostup, nadmerna korekcia a dezmopresin,
 * osobitosti pri zlyhani obliciek a kritika observacnych studii.
 * Slovenske spracovanie prehladu Kamel KS a spol. (Clin Kidney J 2026).
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
    'title'        => 'Korekcia hyponatriémie: kedy postupovať rýchlo a kedy obozretne',
    'slug'         => 'korekcia-hyponatriemie-rychlost-bezpecnost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Bezpečnostný limit a cieľový vzostup nie sú to isté číslo. Pri priemernom riziku najviac 10 mmol/l za 24 hodín a 18 mmol/l za 48 hodín, cieľ 4 až 8 mmol/l denne. Nadmernú korekciu spôsobí najčastejšie náhla vodná diuréza.',
    'content'      => <<<'HTML'
<figure><a href="img/korekcia-hyponatriemie-rychlost-bezpecnost.webp" rel="noopener noreferrer" target="_blank"><img src="img/korekcia-hyponatriemie-rychlost-bezpecnost.webp" alt="Priesvitný mozog v tme: ľavá polovica opuchnutá chladným tyrkysovým svetlom, pravá s praskajúcimi nervovými vláknami v jantárovočervených trhlinách, medzi nimi úzky pás svetla" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna, nie zobrazenie konkrétneho pacienta. Vyjadruje dvojaké riziko liečby hyponatriémie: vľavo edém mozgu pri nedostatočnej korekcii, vpravo osmotické poškodenie myelínu pri príliš rýchlej korekcii. Medzi nimi je úzky bezpečný koridor.</figcaption></figure>

<p>Pri liečbe hyponatriémie nejde o jednoduchú voľbu medzi rýchlou a pomalou korekciou. Bezprostredným cieľom pri závažných neurologických príznakoch je zmierniť edém mozgu. Ďalším cieľom je predísť nadmernému vzostupu koncentrácie sodíka, ktorý môže pri chronickej hyponatriémii vyvolať osmotický demyelinizačný syndróm. Bezpečná liečba preto spája včasný, kontrolovaný úvodný zásah s následným dôsledným sledovaním.</p>

<p>Rozhodujúce nie je iba číslo v laboratórnom výsledku. Treba posúdiť tonicitu, klinické príznaky, trvanie poruchy, jej príčinu a individuálne riziko komplikácií. Keďže trvanie hyponatriémie býva neisté, <strong>prehľadová práca Kamela a spoluautorov odporúča riadiť sa predovšetkým neurologickými prejavmi, nie samotným odhadom trvania</strong>. [1]</p>

<p>Téma je opäť aktuálna, pretože viaceré nedávne observačné štúdie spochybnili platné limity korekcie. Autori prehľadu tieto práce kriticky posudzujú a dospievajú k záveru, že <strong>kým nebudú k dispozícii kvalitnejšie dôkazy, konzervatívne limity zostávajú primerané</strong>. [1]</p>

<h2>Najskôr potvrdiť hypotonickú hyponatriémiu</h2>

<p>Hyponatriémia je koncentrácia sodíka v sére nižšia ako 135 mmol/l. Neznamená automaticky nedostatok sodíka v organizme – často ide predovšetkým o relatívny nadbytok vody vzhľadom na množstvo výmenného sodíka a draslíka.</p>

<p>Pred použitím liečebného algoritmu pre hypotonickú hyponatriémiu treba zohľadniť:</p>

<ul>
  <li>hyperglykémiu a ďalšie príčiny hypertonickej hyponatriémie,</li>
  <li>pseudohyponatriémiu pri výraznej hyperlipidémii alebo hyperproteinémii pri niektorých laboratórnych metódach,</li>
  <li>rozdiel medzi meranou osmolalitou a efektívnou osmolalitou, teda tonicitou.</li>
</ul>

<p>Toto rozlíšenie je dôležité aj pri pokročilej chronickej chorobe obličiek. Močovina zvyšuje meranú osmolalitu, prestupuje však bunkovou membránou, takže neúčinkuje ako efektívny osmolyt rovnako ako sodíkové soli. Samotná normálna alebo zvýšená meraná osmolalita preto nemusí vylučovať zníženú tonicitu.</p>

<h2>Závažné príznaky vyžadujú bezodkladnú liečbu</h2>

<p>Kŕče, výrazná porucha vedomia alebo ďalšie prejavy závažnej hyponatriemickej encefalopatie predstavujú urgentný stav. Ak je pravdepodobnou príčinou hypotonická hyponatriémia, podáva sa 3 % roztok chloridu sodného v monitorovanom prostredí.</p>

<p>Prehľad odporúča podať <strong>100 až 150 ml 3 % hypertonického roztoku intravenózne počas 10 až 20 minút, s opakovaním až dva- či trikrát podľa potreby</strong>. [1] Cieľom je zvýšiť natriémiu <strong>približne o 4 až 6 mmol/l v priebehu prvých 1 až 2 hodín</strong> – taký vzostup spravidla stačí na zvrátenie život ohrozujúceho edému mozgu. [1]</p>

<p><strong>Cieľom urgentnej liečby nie je okamžitá normalizácia natriémie.</strong> Súčasne treba hľadať iné príčiny neurologického stavu. Pretrvávanie poruchy vedomia po primeranom úvodnom vzostupe natriémie nie je samo osebe dôvodom na jej nekontrolované ďalšie zvyšovanie.</p>

<h2>Cieľ korekcie nie je totožný s bezpečnostným limitom</h2>

<p>Za akútnu sa spravidla považuje hyponatriémia s preukázaným trvaním kratším ako 48 hodín. Pri dlhšom alebo neznámom trvaní sa pri plánovaní bezpečnosti postupuje obozretne, ako pri chronickej poruche.</p>

<p>Počas chronickej hyponatriémie sa mozgové bunky adaptujú stratou intracelulárnych elektrolytov a organických osmolytov. Táto adaptácia obmedzuje opuch mozgu, zároveň však zvyšuje zraniteľnosť voči osmotickému poškodeniu počas korekcie. [1]</p>

<p>Prehľad odporúča rozlišovať <strong>bezpečnostný limit</strong> a <strong>cieľový denný vzostup</strong> – nejde o to isté číslo:</p>

<div class="table-responsive" role="region" aria-label="Odporúčané limity a cieľové hodnoty korekcie chronickej hyponatriémie podľa rizika osmotickej demyelinizácie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Riziko osmotickej demyelinizácie</th>
      <th scope="col">Bezpečnostný limit (nesmie sa prekročiť)</th>
      <th scope="col">Cieľový denný vzostup</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Priemerné</th>
      <td>najviac 10 mmol/l za 24 hodín a 18 mmol/l za 48 hodín</td>
      <td>4 až 8 mmol/l za deň</td>
    </tr>
    <tr>
      <th scope="row">Vysoké</th>
      <td>najviac 8 mmol/l za 24 hodín</td>
      <td>4 až 6 mmol/l za deň</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tieto hodnoty predstavujú bezpečnostné hranice, nie métu, ktorú treba dosiahnuť. [1] Vhodná je rezerva pre nepredvídanú vodnú diurézu aj pre neistotu merania.</p>

<p>Pozor na rozšírenú nepresnosť: limit pre druhých 24 hodín nie je ďalších 8 mmol/l „navyše“, ale <strong>kumulatívne najviac 18 mmol/l za 48 hodín</strong>. Rozdiel je klinicky podstatný práve u pacientov, u ktorých sa korekcia v prvý deň priblížila k hornej hranici.</p>

<h3>Kto je vo vysokom riziku</h3>

<p>K významným rizikovým okolnostiam patria: [1]</p>

<ul>
  <li>veľmi nízka východisková natriémia, približne 105 až 110 mmol/l alebo menej,</li>
  <li>hypokaliémia,</li>
  <li>hypofosfatémia,</li>
  <li>malnutrícia,</li>
  <li>porucha užívania alkoholu,</li>
  <li>pokročilé ochorenie pečene.</li>
</ul>

<p>Autori zároveň uvádzajú, že osmotická demyelinizácia je <strong>zriedkavá u pacientov bez týchto rizikových faktorov, najmä ak je východisková natriémia nad 120 mmol/l</strong>. [1] To neznamená, že u nich možno limity ignorovať – znamená to, že stratifikácia rizika má reálny klinický obsah a nejde o formalitu.</p>

<p>Aj dopĺňanie draslíka môže zvýšiť natriémiu, pretože draslík je rovnako účinný osmolyt ako sodík. Musí sa preto zarátať do celkového priebehu korekcie, nie sledovať oddelene.</p>

<h2>Nadmernú korekciu často spôsobí náhla vodná diuréza</h2>

<p>Neočakávaný vzostup natriémie nebýva dôsledkom príliš veľkej dávky hypertonického roztoku. Častejším mechanizmom je náhle obnovenie vylučovania zriedenej moči po odstránení podnetu na sekréciu vazopresínu.</p>

<p>Takáto situácia môže vzniknúť po doplnení objemu pri hypovolémii, po vysadení tiazidu, po liečbe nedostatku kortizolu alebo po ústupe nauzey. Výrazný vzostup diurézy preto môže upozorniť na hroziacu nadmernú korekciu <strong>skôr než nasledujúci laboratórny výsledok</strong>.</p>

<p>Počas aktívnej liečby závažnej hyponatriémie treba sledovať neurologický stav, bilanciu tekutín, diurézu a natriémiu. Kontroly sodíka bývajú potrebné každé 2 až 4 hodiny, pri rýchlych zmenách aj častejšie.</p>

<p>Výpočtové vzorce pomáhajú s plánovaním, nedokážu však predvídať náhlu zmenu vylučovania vody. Nenahrádzajú opakované meranie.</p>

<h2>Čo robiť pri hroziacej alebo už vzniknutej nadmernej korekcii</h2>

<p>Pri neprimerane rýchlom vzostupe natriémie treba okamžite prehodnotiť podávanú liečbu a zistiť, či pacient nezačal vylučovať veľké množstvo zriedenej moči.</p>

<p>Dezmopresín možno podľa prehľadu použiť <strong>reaktívne aj preventívne</strong> na zabránenie nadmernej vodnej diuréze a prekorigovaniu; pri SIAD sa opisuje aj plánované podávanie súbežne s hypertonickým roztokom na dosiahnutie tesnejšej kontroly rýchlosti korekcie. [1] Na doplnenie vody, prípadne na kontrolované opätovné zníženie natriémie, sa používa 5 % roztok glukózy.</p>

<p>Pri opätovnom znižovaní natriémie treba poznať úroveň dôkazov. Prehľad uvádza, že <strong>zníženie natriémie do 12 hodín po príliš rýchlej korekcii zmierňuje demyelinizáciu a mortalitu v experimentálnych podmienkach</strong>; podrobné klinické odporúčanie pre ľudí však neuvádza. [1] Ide teda o patofyziologicky zdôvodnený postup opretý o zvieracie dáta a klinickú skúsenosť, nie o postup overený randomizovanou štúdiou.</p>

<p>Nejde o automatický krok pri každom prekročení plánovaného vzostupu. Rozhoduje rozsah a časovanie korekcie, východisková natriémia a rizikový profil pacienta. Liečba patrí do prostredia s častými kontrolami a skúseným klinickým dohľadom. Ani preventívny dezmopresín nemožno považovať za univerzálny režim pre každú hyponatriémiu.</p>

<h2>Osobitosti pri zlyhaní obličiek</h2>

<p><em>Táto časť presahuje rámec východiskového prehľadu a vychádza z publikovanej praxe pri náhrade funkcie obličiek.</em></p>

<p>Pacient s pokročilým zlyhaním obličiek môže mať súčasne hyponatriémiu, hypervolémiu, hyperkaliémiu alebo inú urgentnú indikáciu na náhradu funkcie obličiek. Liečba musí riešiť všetky tieto problémy bez neprimeraného vzostupu natriémie.</p>

<p>Konvenčná hemodialýza môže pri výraznom rozdiele medzi koncentráciou sodíka v dialyzáte a v krvi zvýšiť natriémiu príliš rýchlo. Dialyzačný predpis preto vyžaduje individuálnu úpravu – nižšiu koncentráciu sodíka v dialyzáte, skrátenie výkonu, zníženie prietoku krvi alebo dialyzátu.</p>

<p>Pri kontinuálnych metódach možno prísun sodíka regulovať validovaným postupom. Retrospektívna séria štyroch kriticky chorých pacientov so sodíkom pod 125 mmol/l a zlyhaním obličiek opísala protokol s postfiltrovou dilúciou sterilnou vodou a regionálnou citrátovou antikoaguláciou, ktorý podľa autorov umožnil postupnú korekciu (zo 112,7 ± 6,7 na 141,9 ± 2,8 mmol/l) bez osmotickej demyelinizácie. [2] Ide o malú retrospektívnu sériu, ktorá dokladá uskutočniteľnosť princípu, nie jeho účinnosť v porovnaní s inými postupmi.</p>

<p>Takéto úpravy vyžadujú výpočet, kontrolu prípravy roztokov a časté merania. <strong>Urémia sa nesmie považovať za spoľahlivú ochranu pred osmotickou demyelinizáciou.</strong></p>

<p>Aj pri hypervolémii môže závažná hyponatriemická encefalopatia vyžadovať malý bolus hypertonického roztoku. Následný postup však musí zohľadniť objemové zaťaženie a potrebu dialýzy.</p>

<h2>Ako interpretovať diskusiu o rýchlejšej korekcii</h2>

<p>Pri hodnotení štúdií treba rozlišovať kontrolovaný úvodný vzostup pri závažných príznakoch od nadmernej celodennej korekcie chronickej hyponatriémie. Ide o dve odlišné veci, ktoré sa v diskusii často zlučujú.</p>

<p>Observačné práce uvádzajú, že osmotická demyelinizácia je zriedkavá, že jej súvislosť s príliš rýchlou korekciou je nekonzistentná a že pomalšia korekcia – vzostup menej než 6 mmol/l v prvých 24 hodinách – sa spájala s vyššou mortalitou. [1] Autori prehľadu však uvádzajú konkrétne dôvody opatrnosti:</p>

<ul>
  <li>zdanlivý prínos pre mortalitu <strong>vymizol po úprave na propenzitné skóre</strong>, čo naznačuje reziduálne zmätenie,</li>
  <li>súvislosť medzi rýchlejšou korekciou a lepším prežívaním môže odrážať <strong>zmätenie závažnosťou základného ochorenia</strong>,</li>
  <li>pacienti s komorbiditami sa korigujú pomalšie pre <strong>pretrvávajúce uvoľňovanie vazopresínu</strong> – rýchlejšia korekcia potom len označuje menej závažne chorých pacientov.</li>
</ul>

<p>Záver autorov je jednoznačný: tieto nálezy <strong>nemožno vykladať ako oprávnenie prekračovať platné limity</strong>. [1] Podobne nízky počet zachytených prípadov osmotickej demyelinizácie nevylučuje riziko v najzraniteľnejších podskupinách.</p>

<p>Klinicky správna otázka preto znie: aký úvodný vzostup potrebuje tento pacient na zvládnutie príznakov a ako následne zabrániť prekročeniu jeho bezpečnostnej hranice?</p>

<h2>Limity</h2>

<p>Článok vychádza z naratívneho prehľadu, nie zo systematickej analýzy ani z randomizovaných štúdií. Uvedené limity korekcie sa opierajú o patofyziologické zdôvodnenie, pozorovania prípadov osmotickej demyelinizácie a odborný konsenzus; samotní autori prehľadu upozorňujú, že kvalitnejšie dôkazy chýbajú a že platné limity sú predmetom prebiehajúcej diskusie. Údaje o opätovnom znižovaní natriémie pochádzajú z experimentálnych podmienok. Postup pri náhrade funkcie obličiek nie je súčasťou východiskového prehľadu a citovaná séria zahŕňa štyroch pacientov.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska. Liečba závažnej hyponatriémie patrí do monitorovaného prostredia.</em></p>

<h2>Literatúra</h2>

<p><em>1. Kamel KS, Harel Z, Schreiber M. Managing hyponatremia: fast or slow? Why, when, how, and controversies. Clinical Kidney Journal. 2026;19(10):sfag288. Online 27. augusta 2026. <a href="https://doi.org/10.1093/ckj/sfag288" target="_blank" rel="noopener noreferrer">DOI: 10.1093/ckj/sfag288</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/42824684/" target="_blank" rel="noopener noreferrer">PubMed, PMID 42824684</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13627832/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>2. Shi A, Liu X, Jia Z, Lu X, Teng S, Zhang L, Li J, Li C, Peng Y, Huang Y, Tang J, Zhang H, Liu Z. Sterile water and regional citrate anticoagulation: A simple CRRT strategy for safe correction of severe hyponatraemia. Nursing in Critical Care. 2024;29(6):1450–1459. <a href="https://doi.org/10.1111/nicc.13167" target="_blank" rel="noopener noreferrer">DOI: 10.1111/nicc.13167</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39308137/" target="_blank" rel="noopener noreferrer">PubMed, PMID 39308137</a>.</em></p>

<p><em><strong>Poznámka k dôkazom.</strong> Bibliografické údaje oboch zdrojov vrátane úplného autorského zoznamu, ročníka, čísla a strán boli overené cez PubMed. Limity korekcie, cieľové denné vzostupy, dávkovanie hypertonického roztoku, zoznam rizikových faktorov aj kritické argumenty proti observačným štúdiám boli načítané priamo z plného textu zdroja č. 1 v PubMed Central. Kapitola o zlyhaní obličiek nie je súčasťou východiskového prehľadu – ide o vlastné odborné spracovanie autora projektu doplnené o citovanú sériu č. 2. Rozdelenie limitov a cieľov do tabuľky, upozornenie na 48-hodinový kumulatívny limit a sekcia Limity sú rovnako vlastným spracovaním.</em></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=diurnalna-exkrecia-sodika-nocna-hypertenzia-casovanie-soli">Diurnálna exkrécia sodíka, nočná hypertenzia a časovanie soli</a></li>
  <li><a href="article.php?slug=biopsia-obliciek-glomerularne-ochorenia">Biopsia obličiek pri glomerulárnych ochoreniach</a></li>
  <li><a href="article.php?slug=intradialyzacna-hypotenzia-prevencia-osetrovatelsky-protokol">Intradialyzačná hypotenzia: prevencia a ošetrovateľský manažment</a></li>
</ul>
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
                error_log('add_zelatina_idh newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_zelatina_idh pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_zelatina_idh pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_korekcia_hyponatriemie migration error: ' . $e->getMessage());
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
