<?php
/**
 * Odborne a jazykovo revidovaný článok o manažmente hyperkaliémie pri CKD
 * v reálnej praxi. Spracovaná práca J Nephrol 2026, doi 10.1093/joneph/aajag149;
 * pôvodní autori sú uvedení v source_authors.php.
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
    'title'        => 'Hyperkaliémia pri CKD v reálnej praxi: recidíva je pravidlom a najviac na ňu doplácajú antagonisty mineralokortikoidného receptora',
    'slug'         => 'hyperkaliemia-ckd-realna-prax-recidiva-raasi',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Po epizóde hyperkaliémie sa u 429 pacientov vysadili antagonisty mineralokortikoidného receptora takmer u každého piateho, hoci ide o liečbu s najsilnejším dôkazovým základom. Recidíva postihla 43,8 %.',
    'content'      => <<<'HTML'
<p>Skutočná cena hyperkaliémie pri chronickej chorobe obličiek sa málokedy meria hodnotou kália. Meria sa tým, čo po epizóde vysadíme. Blokáda systému renín–angiotenzín–aldosterón a antagonisty mineralokortikoidného receptora patria k liečbe s najlepšie doloženým kardiorenálnym prínosom a zároveň k najčastejším „obetiam“ jedného zvýšeného laboratórneho výsledku.</p>

<p>Španielska prospektívna observačná štúdia publikovaná v auguste 2026 túto prax zdokumentovala u 429 pacientov v pätnástich nemocniciach. Jej hodnota nie je v odpovedi na otázku, čo funguje – na to nemá dizajn. Je v tom, že ukazuje, <em>čo sa naozaj deje</em>.</p>

<h2>Súbor a dizajn</h2>

<p>Išlo o prospektívnu multicentrickú observačnú štúdiu; zaraďovali sa pacienti so sérovým káliom nad 5,5 mmol/l a údaje sa zbierali počas dvoch rokov. Súbor bol starý a komorbídny: priemerný vek 71,5 roka, 71,3 % mužov, 88,6 % s hypertenziou a 55,9 % s diabetom. Stredne ťažkú hyperkaliémiu malo 19,1 % a ťažkú 3,7 % pacientov; podiel miernej práca neuvádza.</p>

<h2>Ako prax na epizódu zareagovala</h2>

<div class="table-responsive" role="region" aria-label="Nárast použitia jednotlivých opatrení po epizóde hyperkaliémie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Opatrenie</th>
      <th scope="col">Nárast použitia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Diétne úpravy</th>
      <td>+ 39,9 %</td>
    </tr>
    <tr>
      <th scope="row">Cyklosilikát zirkoničito-sodný</th>
      <td>+ 24,6 %</td>
    </tr>
    <tr>
      <th scope="row">Patiromér</th>
      <td>+ 10,9 %</td>
    </tr>
    <tr>
      <th scope="row">Hydrogénuhličitan</th>
      <td>+ 7,9 %</td>
    </tr>
    <tr>
      <th scope="row">Iónomeničové živice</th>
      <td>+ 2,6 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Obraz je jednoznačný: staré iónomeničové živice sa už prakticky nepridávajú a ťažisko sa presunulo na moderné viažuce látky, najmä na cyklosilikát. Zdroj však neuvádza, či ide o rozdiel v percentuálnych bodoch alebo o relatívny nárast oproti východiskovému podielu, takže absolútne počty z týchto čísel odvodiť nemožno.</p>

<h2>Čo sa stalo s blokádou RAAS</h2>

<div class="table-responsive" role="region" aria-label="Úpravy liečby blokujúcej systém renín-angiotenzín-aldosterón po epizóde hyperkaliémie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Lieková skupina</th>
      <th scope="col">Zníženie dávky</th>
      <th scope="col">Vysadenie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Inhibítory ACE</th>
      <td>12,00 %</td>
      <td>6,80 %</td>
    </tr>
    <tr>
      <th scope="row">Sartany</th>
      <td>5,49 %</td>
      <td>7,32 %</td>
    </tr>
    <tr>
      <th scope="row">Antagonisty mineralokortikoidného receptora</th>
      <td>12,73 %</td>
      <td><strong>21,82 %</strong></td>
    </tr>
  </tbody>
</table>
</div>

<p>Tu je jadro celej práce. <strong>Liečba, ktorá má pri chronickej chorobe obličiek s albuminúriou a pri srdcovom zlyhávaní najsilnejší doložený prínos, sa vysadzuje najčastejšie</strong> – takmer u každého piateho pacienta, teda trojnásobne častejšie než inhibítor ACE. Dôvod je pochopiteľný: antagonisty mineralokortikoidného receptora zvyšujú kálium najvýraznejšie a v hierarchii „čo vysadím ako prvé“ sú intuitívne na vrchu. Z hľadiska dlhodobej prognózy je to však presne opačné poradie, než aké by si pacient zaslúžil.</p>

<p><em>Poznámka k údajom: uvedené podiely sa nevzťahujú na celý súbor 429 pacientov, ale na počty užívateľov jednotlivých liekových skupín. Rekonštrukcia celých čísel ukazuje, že menovatele sú triedne špecifické; presné počty pacientov práca neuvádza.</em></p>

<h2>Recidíva je pravidlom</h2>

<ul>
  <li>Recidíva hyperkaliémie nastala u <strong>43,8 %</strong> pacientov.</li>
  <li>Pri vstupnej odhadovanej filtrácii pod 30 ml/min bola častejšia: <strong>49,1 % oproti 38,8 %</strong> (p = 0,03).</li>
  <li>Recidíva sa spájala s rýchlejším poklesom filtrácie – uvádza sa <strong>−2,4 ml/min za rok</strong> (p &lt; 0,001).</li>
  <li>Kaplanova–Meierova analýza nepreukázala rozdiel v celkovom prežívaní podľa toho, či recidíva nastala.</li>
  <li>Medzi modernými viažucimi látkami a živicami sa nezistil významný rozdiel v účinnosti meranej výskytom recidívy.</li>
</ul>

<h2>Čo z týchto čísel nemožno vyvodiť</h2>

<ol>
  <li><strong>Uvádzajú sa výhradne neupravené podiely a hodnoty p.</strong> Chýbajú pomery rizík, intervaly spoľahlivosti aj akýkoľvek viacrozmerný model. Nedá sa preto tvrdiť, že recidíva je <em>nezávisle</em> spojená s rýchlejším poklesom filtrácie – rovnako dobre môže byť len ukazovateľom pokročilejšieho a nestabilnejšieho ochorenia. Autori sami uvádzajú, že príčinná súvislosť je nejasná.</li>
  <li><strong>Recidíva vzniká až počas sledovania, ale analyzuje sa ako vstupná vlastnosť.</strong> To zavádza skreslenie nesmrteľného času: pacient musí prežiť dosť dlho na to, aby sa recidívy vôbec dožil. Rovnaký problém sa týka výpočtu ročného sklonu filtrácie.</li>
  <li><strong>Chýba definícia recidívy.</strong> Nie je uvedený prah kália, časové okno, minimálny odstup medzi epizódami ani predpísaná frekvencia odberov. Pri observačnom zbere pritom zachytenie recidívy priamo závisí od intenzity monitorovania – a pacienti s filtráciou pod 30 ml/min sa kontrolujú častejšie. Časť rozdielu 49,1 oproti 38,8 % teda môže byť len rozdielom v tom, ako často odoberáme krv.</li>
  <li><strong>„Žiadny významný rozdiel“ nie je dôkaz rovnocennosti.</strong> Porovnanie viažucich látok so živicami bolo nerandomizované, bez uvedenia veľkostí podskupín, intervalu spoľahlivosti aj sily testu. O liečbe rozhodoval ošetrujúci nefrológ, takže platí zmätenie indikáciou.</li>
  <li><strong>Záver ide nad rámec dát.</strong> Odporúčanie zaraďovať viažuce látky do liečebných stratégií nemá v tejto práci oporu – chýba kontrolná skupina bez viažucej látky aj výsledky o dosiahnutých hladinách kália. Dvaja zo šestnástich autorov vrátane prvej autorky navyše deklarujú konzultačné väzby na výrobcov, medzi nimi aj na výrobcu jednej z viažucich látok.</li>
  <li><strong>Abstrakt si protirečí.</strong> Výsledky uvádzajú, že rozdiel v prežívaní nie je, no záver hovorí, že „rozdiel v mortalite si vyžaduje ďalšie skúmanie“. Počet úmrtí ani hodnota log-rank testu nie sú uvedené.</li>
  <li><strong>Kardiovaskulárne príhody sa zbierali, ale nereferujú.</strong> Metodika ich menuje ako sledovaný ukazovateľ, vo výsledkoch ani v závere sa však neobjaví ani jeden. Ide o neúplné referovanie a z tejto práce nemožno o kardiovaskulárnych výsledkoch uviesť nič.</li>
  <li><strong>Podiel miernej hyperkaliémie sa neuvádza.</strong> Dopočet na 77,2 % je aritmeticky konzistentný, ale je to náš výpočet, nie údaj štúdie – a platí len vtedy, ak tri kategórie pokrývajú celý súbor bez chýbajúcich údajov.</li>
</ol>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o manažmente hyperkaliémie v reálnej praxi" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Verdikt</th>
      <th scope="col">Presná interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Recidíva hyperkaliémie postihla 43,8 % pacientov</th>
      <td>Potvrdené</td>
      <td>Platí pre populáciu v nefrologickej ambulancii so vstupným káliom nad 5,5 mmol/l; definícia recidívy nie je uvedená.</td>
    </tr>
    <tr>
      <th scope="row">Antagonisty mineralokortikoidného receptora sa vysadzujú najčastejšie</th>
      <td>Potvrdené</td>
      <td>21,82 % vysadených oproti 6,80 % pri inhibítoroch ACE a 7,32 % pri sartanoch; menovatele sú triedne špecifické.</td>
    </tr>
    <tr>
      <th scope="row">Recidíva spôsobuje rýchlejší pokles filtrácie</th>
      <td>Nesprávne</td>
      <td>Ide o asociáciu z neupravenej analýzy. Autori sami označujú príčinnú súvislosť za nejasnú; možná je aj obrátená príčinnosť.</td>
    </tr>
    <tr>
      <th scope="row">Recidíva neovplyvňuje prežívanie</th>
      <td>Neisté</td>
      <td>Kaplanova–Meierova analýza rozdiel nezistila, ale bez počtu úmrtí, hodnoty p a pomeru rizík ide o nekonkluzívny výsledok, nie o dôkaz absencie rozdielu.</td>
    </tr>
    <tr>
      <th scope="row">Moderné viažuce látky sú rovnako účinné ako živice</th>
      <td>Nesprávne</td>
      <td>Nesignifikantný výsledok nerandomizovaného porovnania bez intervalu spoľahlivosti a bez posúdenia sily testu nie je dôkazom rovnocennosti.</td>
    </tr>
    <tr>
      <th scope="row">Viažuce látky umožňujú udržať blokádu RAAS</th>
      <td>Doložené inde, nie touto prácou</td>
      <td>Podporujú to randomizované štúdie AMBER a DIAMOND; táto observačná práca nemala kontrolnú skupinu bez viažucej látky.</td>
    </tr>
    <tr>
      <th scope="row">Mierna hyperkaliémia bola u 77,2 % pacientov</th>
      <td>Odvodené</td>
      <td>Vlastný dopočet zo zvyšku; v práci sa toto číslo neuvádza.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo je napriek tomu použiteľné</h2>

<p>Opisná časť práce má reálnu hodnotu práve preto, že nie je intervenčná. Ukazuje, že v bežnej nefrologickej ambulancii sa hyperkaliémia rieši kombináciou diéty, viažucej látky a úpravy blokády RAAS – a že tou úpravou najčastejšie doplatí antagonista mineralokortikoidného receptora.</p>

<p>Práve pre túto situáciu existuje randomizovaný dôkaz, ktorý táto štúdia nenahrádza, ale dopĺňa. V štúdii AMBER umožnil patiromér u pacientov s rezistentnou hypertenziou a chronickou chorobou obličiek pokračovať v liečbe spironolaktónom podstatne častejšie než placebo. V štúdii DIAMOND pri srdcovom zlyhávaní so zníženou ejekčnou frakciou patiromér umožnil udržať cieľové dávky liečby blokujúcej RAAS. Kombinácia oboch pohľadov dáva jasný praktický záver: <strong>viažuca látka nie je liekom na číslo, ale nástrojom na udržanie liečby.</strong></p>

<h2>Praktický postup</h2>

<ol>
  <li><strong>Pred zásahom overiť hodnotu.</strong> Pseudohyperkaliémia z hemolýzy, oneskoreného spracovania vzorky alebo trombocytózy je pri prahu 5,5 mmol/l častou príčinou zbytočného vysadenia liečby.</li>
  <li><strong>Prejsť odstrániteľné príčiny.</strong> Metabolickú acidózu, zápchu, dehydratáciu, nesteroidové antiflogistiká, trimetoprim, heparín, príjem náhrad soli s obsahom draslíka a nedávnu zmenu dávky diuretika.</li>
  <li><strong>Vysadenie brať ako poslednú možnosť, nie prvú.</strong> Poradie zásahov: korekcia acidózy a objemu, diétna úprava, kľučkové diuretikum, viažuca látka – a až potom zníženie dávky.</li>
  <li><strong>Ak sa dávka zníži, naplánovať návrat.</strong> Vysadenie „dočasne“ sa bez konkrétneho termínu kontroly a plánu opätovného nasadenia mení na trvalé.</li>
  <li><strong>Počítať s recidívou.</strong> Takmer polovica pacientov ju zopakuje, pri filtrácii pod 30 ml/min ešte častejšie. Jednorazové riešenie preto neexistuje – ide o chronický proces s naplánovanými kontrolami kália.</li>
  <li><strong>Zaznamenať dôvod zásahu.</strong> Bez poznámky, prečo sa dávka znížila, nikto neskôr nevie, či je dôvod ešte platný.</li>
</ol>

<h2>Záver</h2>

<p>Štúdia neprináša nový dôkaz o účinnosti a jej záver o viažucich látkach vlastné dáta nepodporujú. Prináša však presný obraz bežnej praxe, ktorý stojí za pozornosť: hyperkaliémia sa vracia u takmer polovice pacientov a najčastejšou odpoveďou na ňu je oslabenie liečby, ktorá pacientovi prináša najviac. Ak si z práce odnesieme jedinú vetu, mala by znieť: <strong>cieľom manažmentu hyperkaliémie nie je normálne kálium, ale normálne kálium pri zachovanej účinnej liečbe.</strong></p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia RAASi/MRA terapie u pacientov so srdcovým zlyhávaním, CKD a hyperkaliémiou (praktický prístup)</a></li>
  <li><a href="article.php?slug=kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas">Kazuisticky: Ako zvládnuť hyperkaliémiu pri CKD a srdcovom zlyhávaní tak, aby sme neznižovali účinnú liečbu</a></li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri ochorení obličiek: edukovať, nie strašiť</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Marques M, López-Sánchez P, Morales E, Bajo MA, Rodriguez A, Fernández Lucas M, Paraiso V, Bucalo L, Hernandez Y, De La Flor JC, Padrón M, Bouarich H, Procaccini F, Nava Chavez C, Herrero J, Tornero F. Optimizing hyperkalemia management in CKD: real-world nephrologist strategies and impact on patient outcomes. <em>Journal of Nephrology</em>. Publikované online 14. augusta 2026 (predbežný článok, bez ročníka a stránkovania), e-lokátor aajag149. doi: 10.1093/joneph/aajag149. <a href="https://pubmed.ncbi.nlm.nih.gov/42599085/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia AMBER:</strong> Agarwal R, Rossignol P, Romero A, Garza D, Mayo MR, Warren S, Ma J, White WB, Williams B. Patiromer versus placebo to enable spironolactone use in patients with resistant hypertension and chronic kidney disease (AMBER): a phase 2, randomised, double-blind, placebo-controlled trial. <em>The Lancet</em>. 2019;394(10208):1540–1550. doi: 10.1016/S0140-6736(19)32135-X. <a href="https://pubmed.ncbi.nlm.nih.gov/31533906/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia DIAMOND:</strong> Butler J, Anker SD, Lund LH, et al. Patiromer for the management of hyperkalemia in heart failure with reduced ejection fraction: the DIAMOND trial. <em>European Heart Journal</em>. 2022;43(41):4362–4373. doi: 10.1093/eurheartj/ehac401. <a href="https://pubmed.ncbi.nlm.nih.gov/35900838/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Nefrologické odporúčanie:</strong> Kidney Disease: Improving Global Outcomes CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://pubmed.ncbi.nlm.nih.gov/38490803/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje, úplný zoznam šestnástich autorov aj všetky číselné výsledky spracovanej práce boli overené 23. augusta 2026 cez PubMed a Crossref z jej štruktúrovaného abstraktu. Plný text nemá otvorenú verziu, preto autorské limity nemožno citovať doslovne a výhrady k dizajnu sú odvodené z dostupného opisu metodiky. Podiel miernej hyperkaliémie je vlastným dopočtom. Deklarované konflikty záujmov dvoch autorov zahŕňajú konzultačné honoráre od výrobcov liekov vrátane výrobcu jednej z hodnotených viažucich látok.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_hyperkaliemia_realna_prax',
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
