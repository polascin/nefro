<?php

/**
 * add_renalne-riziko-po-preeklampsii-detekcia-albuminuria_article.php
 * Renalne riziko po preeklampsii - skryte bremeno a premeskane prilezitosti na detekciu.
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
    'title'        => 'Renálne riziko po preeklampsii: skryté bremeno a premeškané príležitosti na včasnú detekciu',
    'slug'         => 'renalne-riziko-po-preeklampsii-detekcia-albuminuria',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štokholmská kohorta 171 693 tehotenstiev ukázala po preeklampsii viac než dvojnásobné riziko laboratórnych známok CKD. Absolútne čísla sú však nízke aj preto, že sa v prvom roku po pôrode testuje len pätina žien — a prah albuminúrie 300 mg/g vynecháva skorý fenotyp.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Preeklampsia nie je len akútna pôrodnícka komplikácia. Rozsiahla švédska kohortová štúdia dokladá, že po nej pretrváva viac než dvojnásobné riziko laboratórnych známok chronickej choroby obličiek. Absolútne riziko pôsobí upokojujúco — ale výmena názorov na stránkach <em>JASN</em> ukazuje, že do veľkej miery odráža to, koho a čím po pôrode vyšetrujeme.</em></p>

<p>Hypertenzné ochorenia v tehotenstve sa v posledných rokoch presunuli z čisto pôrodníckej domény do kardiorenálnej medicíny. Preeklampsia komplikuje približne 3–6 % tehotenstiev a jej vzťah k neskoršej hypertenzii, kardiovaskulárnym príhodám aj k chronickej chorobe obličiek (CKD) je opakovane doložený. Menej jasné však zostáva niečo praktickejšie: <strong>ako veľké je toto riziko v absolútnych číslach a nakoľko ho vôbec dokážeme v bežnej starostlivosti zachytiť</strong>.</p>

<p>Odpoveď na obe otázky priniesla kombinácia populačnej kohortovej štúdie publikovanej v <em>Journal of the American Society of Nephrology</em> a následnej korešpondencie, ktorá jej dáta prepočítala pri miernejšej definícii albuminúrie. Práve táto výmena je pre nefrologickú prax poučnejšia než samotné hlavné čísla.</p>

<h2>Čo ukázala štokholmská kohorta</h2>

<p>Jennifer H. Yo a spolupracovníci analyzovali údaje zdravotníckeho registra regiónu Štokholm. Do kohorty zaradili všetky prvorodičky (nulipary), ktorých tehotenstvo sa medzi 1. januárom 2006 a 31. decembrom 2020 skončilo živonarodeným alebo mŕtvonarodeným dieťaťom — spolu <strong>171&nbsp;693 tehotenstiev u 170&nbsp;192 žien</strong> s priemerným vekom 29 rokov. Preeklampsia komplikovala <strong>6 % tehotenstiev</strong> (n = 10&nbsp;538).</p>

<p>Sledované boli tri cieľové ukazovatele definované laboratórne, nie diagnostickým kódom:</p>

<ul>
  <li>albuminúria s pomerom albumínu ku kreatinínu v moči (UACR) nad 300 mg/g,</li>
  <li>eGFR pod 60 ml/min/1,73 m²,</li>
  <li>kompozit oboch predchádzajúcich.</li>
</ul>

<p>Počas mediánu sledovania <strong>7 rokov</strong> boli incidencie na 1000 osoborokov po preeklampsii konzistentne vyššie než bez nej:</p>

<ul>
  <li>albuminúria &gt; 300 mg/g: <strong>1,53</strong> oproti 0,57,</li>
  <li>eGFR &lt; 60 ml/min/1,73 m²: <strong>0,52</strong> oproti 0,18,</li>
  <li>kompozit: <strong>2,00</strong> oproti 0,73.</li>
</ul>

<p>Vážené pomery rizík (HR) boli 2,53 (95 % IS 2,04–3,13) pre albuminúriu, 2,18 (95 % IS 1,49–3,19) pre pokles eGFR a 2,43 (95 % IS 2,01–2,95) pre kompozit. Relatívne riziko je teda po preeklampsii <strong>viac než dvojnásobné</strong> a odhad je pomerne presný.</p>

<p>Absolútne počty však pôsobia nenápadne: albuminúriu nad 300 mg/g malo 775 tehotenstiev (0,5 %), pokles eGFR 248 (0,1 %) a kompozitný ukazovateľ 985 (0,6 %). Práve tento kontrast — vysoké relatívne, nízke absolútne riziko — sa stal jadrom následnej diskusie.</p>

<h2>Nízke riziko, alebo nízka detekcia?</h2>

<p>Shiuan-Chih Chen a Ming-Cheng Lin z Chung Shan Medical University upozornili v liste redakcii <em>JASN</em>, že nízke absolútne čísla nemusia znamenať biologicky pokojnú situáciu, ale predovšetkým <strong>obmedzenú detekciu</strong>. Argument stojí na údaji, ktorý pôvodná práca sama uvádza a ktorý je klinicky alarmujúci:</p>

<ul>
  <li>sérový kreatinín bol v prvom roku po pôrode stanovený len u <strong>20 %</strong> žien,</li>
  <li>albuminúria v moči len u <strong>10 %</strong>,</li>
  <li><strong>obidve</strong> vyšetrenia absolvovalo len <strong>5 %</strong>.</li>
</ul>

<p>Laboratórne definovaný cieľový ukazovateľ je pritom možné zaznamenať len u ženy, ktorej sa laboratórne vyšetrenie skutočne urobilo. Ak sa deväť z desiatich žien po pôrode nikdy netestuje na albuminúriu, incidencia albuminúrie nemôže byť vysoká — bez ohľadu na to, koľko žien ju v skutočnosti má. Kohorta v takom prípade meria nie prevalenciu poškodenia obličiek, ale <strong>prienik poškodenia a vyšetrovacej praxe</strong>.</p>

<h2>Prah 300 mg/g vynecháva skorý fenotyp</h2>

<p>Druhá výhrada sa týkala definície cieľového ukazovateľa. Hranica UACR nad 300 mg/g zodpovedá v klasifikácii KDIGO kategórii <strong>A3</strong>, teda výrazne zvýšenej albuminúrii. Vynecháva celú kategóriu <strong>A2</strong> (30–300 mg/g), ktorá je pritom prognosticky významná a zároveň predstavuje okno, v ktorom je liečebný zásah najúčinnejší.</p>

<p>Autorky a autori pôvodnej práce túto námietku v odpovedi neodmietli — naopak, dáta prepočítali. Pri posunutí prahu na UACR nad 30 mg/g stúpol počet zachytených príhod:</p>

<ul>
  <li>po preeklampsii zo <strong>113 na 428</strong>,</li>
  <li>bez preeklampsie zo <strong>662 na 3025</strong>.</li>
</ul>

<p>Zahrnutie stredne zvýšenej albuminúrie teda zvýšilo počet zachytených prípadov približne <strong>4,5-násobne</strong>. Bremeno, ktoré pôvodná analýza pri prahu A3 nevidela, existuje — len bolo pod rozlišovacou schopnosťou zvolenej definície.</p>

<p>Pre prax z toho vyplýva jednoduchý dôsledok: ak sa popôrodné sledovanie oprie o kreatinín alebo o „ťažkú“ proteinúriu, zachytí prevažne ženy, u ktorých už bolo poškodenie obličiek nastolené. Skoršie a potenciálne ovplyvniteľné štádium zostane neviditeľné.</p>

<h2>Prečo albuminúria predbieha pokles eGFR</h2>

<p>Vzorec pozorovaný v kohorte — albuminúria približne trikrát častejšie než pretrvávajúci pokles eGFR — dobre zodpovedá tomu, čo o renálnom postihnutí pri preeklampsii vieme z patofyziológie.</p>

<p>Renálnym korelátom preeklampsie je <strong>glomerulárna endotelióza</strong>: opuch endotelových buniek glomerulárnych kapilár s obliteráciou fenestrácií, podmienený nerovnováhou angiogénnych faktorov (nadbytok sFlt-1 viažuceho VEGF a PlGF). Endotelióza po pôrode väčšinou ustúpi. Sprievodná strata podocytov je však problematickejšia — podocyty sú terminálne diferencované bunky s minimálnou schopnosťou proliferácie, takže ich úbytok je do značnej miery nezvratný.</p>

<p>Výsledkom je poškodenie <strong>filtračnej bariéry</strong> skôr než úbytok funkčnej masy nefrónov. Albuminúria je preto citlivejším a skorším signálom. Glomerulárna filtrácia zostáva vďaka funkčnej rezerve a kompenzačnej hyperfiltrácii zvyšných nefrónov dlho normálna a k poklesu eGFR pod 60 ml/min/1,73 m² dochádza až pri pokročilejšej strate. Sledovanie postavené na samotnom kreatiníne teda nielenže zachytáva menej — zachytáva <strong>neskôr</strong>.</p>

<h2>Metodická poznámka: detekčné skreslenie pôsobí oboma smermi</h2>

<p>Argument o skrytom bremene je presvedčivý v otázke <em>absolútneho</em> rizika. Pri <em>relatívnom</em> riziku je opatrnosť namieste v opačnom smere.</p>

<p>Ženy po preeklampsii sú po pôrode pravdepodobne sledované intenzívnejšie než ženy s nekomplikovaným tehotenstvom. Ak je vyšetrovacia intenzita v exponovanej skupine vyššia, časť pozorovaného rozdielu môže pochádzať z <strong>diferenciálnej detekcie</strong>, nie z rozdielu v biológii — a pomer rizík by potom bol nadhodnotený. Zároveň platí opak pre absolútne čísla, ktoré sú podhodnotené v oboch skupinách.</p>

<p>Obidve skreslenia teda pôsobia súčasne, ale na rôzne parametre. Nič to nemení na hlavnom klinickom posolstve — skôr to podčiarkuje, že jediným robustným riešením je <strong>systematické, a nie príležitostné</strong> popôrodné vyšetrovanie. Kohorta so 100 % pokrytím by odstránila obe skreslenia naraz.</p>

<h2>Čo z toho vyplýva pre popôrodné sledovanie</h2>

<p>Medzinárodné odporúčania popôrodnú kontrolu po hypertenznom ochorení v tehotenstve už obsahujú. Odporúčania ISSHP z roku 2021 predpokladajú <strong>systematickú kontrolu približne tri mesiace po pôrode</strong>, ktorej cieľom je overiť normalizáciu tlaku krvi, moču a laboratórnych odchýlok; pri pretrvávajúcej hypertenzii alebo proteinúrii sa odporúča odoslanie k špecialistovi, spravidla nefrológovi alebo kardiológovi.</p>

<p>Švédske dáta ukazujú, že medzi odporúčaním a realitou je priepasť. Ak sa v krajine s dobre organizovanou zdravotnou starostlivosťou a úplným registrom testuje v prvom roku po pôrode 20 % žien na kreatinín a 10 % na albuminúriu, je málo pravdepodobné, že by situácia inde bola podstatne lepšia.</p>

<p>Prakticky sa preto oplatí presadzovať tri veci:</p>

<ol>
  <li><strong>Vyšetrenie UACR, nie iba kreatinínu.</strong> Samotný kreatinín pri tomto fenotype zachytáva neskoré štádium a väčšinu skorých prípadov prehliadne.</li>
  <li><strong>Hodnotenie od hranice 30 mg/g.</strong> Kategória A2 je prognosticky významná a je práve tým pásmom, v ktorom má intervencia najväčší zmysel.</li>
  <li><strong>Preeklampsia v anamnéze ako trvalý údaj, nie epizóda.</strong> Informácia musí prejsť z pôrodníckej dokumentácie do dokumentácie všeobecného lekára, inak sa po niekoľkých rokoch stratí.</li>
</ol>

<h2>Ako o riziku hovoriť s pacientkou</h2>

<p>Komunikačne ide o citlivú situáciu. Viac než dvojnásobné relatívne riziko znie hrozivo, kým absolútne riziko okolo 0,6 % za sedem rokov znie zanedbateľne. Obidva údaje sú pravdivé a obidva samostatne zavádzajú.</p>

<p>Korektnejšie je povedať, že prekonaná preeklampsia neznamená ochorenie obličiek, ale zaraďuje ženu do skupiny s vyšším rizikom, v ktorej má pravidelná kontrola tlaku krvi a moču zmysel — a to najmä preto, že <strong>skoro zachytená albuminúria je liečiteľná</strong>. Prínos sledovania nie je v tom, že by riziko odstránilo, ale v tom, že nález presúva do štádia, keď je ešte ovplyvniteľný.</p>

<h2>Limity</h2>

<p>Pôvodná kohorta má obmedzenia, ktoré treba brať do úvahy:</p>

<ul>
  <li>ide o observačnú, nie intervenčnú štúdiu — dokladá asociáciu, nie kauzalitu, hoci časová následnosť a biologická vierohodnosť ju podporujú;</li>
  <li>zahrnuté boli len prvorodičky, čo zlepšuje vnútornú konzistentnosť, ale obmedzuje prenositeľnosť na viacrodičky;</li>
  <li>medián sledovania 7 rokov je pre ochorenie s desaťročiami trvajúcou latenciou krátky — dlhodobé riziko je pravdepodobne vyššie;</li>
  <li>populácia jedného švédskeho regiónu nemusí zodpovedať krajinám s odlišnou dostupnosťou popôrodnej starostlivosti;</li>
  <li>neúplné testovanie ovplyvňuje odhady tak, ako je rozobrané vyššie.</li>
</ul>

<h2>Praktické závery</h2>

<ol>
  <li><strong>Po preeklampsii pretrváva viac než dvojnásobné riziko laboratórnych známok CKD</strong> aj po zohľadnení sledovaných zmätočných faktorov.</li>
  <li><strong>Absolútne riziko je nízke, ale podhodnotené.</strong> Vyplýva to z veľmi nízkej miery popôrodného testovania — 20 % pre kreatinín, 10 % pre albuminúriu, 5 % pre obidve.</li>
  <li><strong>Prah 300 mg/g nie je vhodný na skríning.</strong> Posun na 30 mg/g zvýšil počet zachytených príhod približne 4,5-násobne.</li>
  <li><strong>Albuminúria predbieha pokles eGFR</strong>, čo zodpovedá poškodeniu filtračnej bariéry a strate podocytov skôr než úbytku nefrónov. Sledovanie postavené na kreatiníne prichádza neskoro.</li>
  <li><strong>Odhady rizika treba čítať cez optiku vyšetrovacieho dizajnu.</strong> „Koľko“ rizika štúdia nájde, závisí od toho, koho testuje, čím ho testuje a aký prah označí za príhodu.</li>
</ol>

<h2>Záver</h2>

<p>Výmena názorov okolo štokholmskej kohorty je dobrou ukážkou toho, ako sa epidemiologický odhad mení podľa metodických rozhodnutí. Nízke absolútne odhady renálneho rizika po preeklampsii sú sčasti dôsledkom neúplnej detekcie a reštriktívnej definície cieľového ukazovateľa. Bremeno, ktoré takto zostáva neviditeľné, nie je hypotetické — pri miernejšom prahe albuminúrie sa v tých istých dátach ukázalo približne štyri a pol razy väčšie.</p>

<p>Pre nefrológa z toho plynie konkrétny záver: popôrodné hodnotenie po preeklampsii má stáť na vyšetrení albuminúrie a má sa hodnotiť od hranice 30 mg/g. Nie preto, že by každá takáto žena mala ochorenie obličiek, ale preto, že práve v tomto pásme má sledovanie ešte čo ponúknuť.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=proteinuria-preeklampsia-hypertenzia-ckd-riziko">Proteinúria pri preeklampsii a dlhodobé riziko hypertenzie a CKD</a> — dánska kohorta hodnotiaca proteinúriu už v čase preeklampsie.</li>
  <li><a href="article.php?slug=ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost">Ochorenie obličiek v tehotenstve</a> — plánovanie pred koncepciou a multidisciplinárna starostlivosť.</li>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu</a> — meranie tlaku krvi a rozhodovanie o liečbe.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Shiuan-Chih Chen, Ming-Cheng Lin.</strong> <em>Reassessing Postpartum Kidney Risk after Preeclampsia: Hidden Burden and Missed Opportunities for Detection.</em> Journal of the American Society of Nephrology. 2026;37(8):1845. doi: 10.1681/ASN.0000001047. <a href="https://pubmed.ncbi.nlm.nih.gov/42545753/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1681/ASN.0000001047" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Jennifer H. Yo, Yuanhang Yang, Aurora Caldinelli, Morgan E. Grams, Kate Bramham, Giorgina B. Piccoli, Juan-Jesús Carrero, Anna Sara Oberg.</strong> <em>Laboratory Signs of CKD after Preeclampsia.</em> Journal of the American Society of Nephrology. 2026;37(7):1524–1534. doi: 10.1681/ASN.0000001001. <a href="https://pubmed.ncbi.nlm.nih.gov/41568873/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1681/ASN.0000001001" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Jennifer H. Yo, Anna Sara Oberg, Juan-Jesús Carrero.</strong> <em>Authors' Reply: Reassessing Postpartum Kidney Risk after Preeclampsia: Hidden Burden and Missed Opportunities for Detection.</em> Journal of the American Society of Nephrology. 2026;37(8):1846. doi: 10.1681/ASN.0000001048. <a href="https://pubmed.ncbi.nlm.nih.gov/41801303/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1681/ASN.0000001048" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Laura A. Magee, Mark A. Brown, David R. Hall, Sanjay Gupte, Annemarie Hennessy, S. Ananth Karumanchi, Louise C. Kenny, Fergus McCarthy, Jenny Myers, Liona C. Poon, Sarosh Rana, Shigeru Saito, Anne Cathrine Staff, Eleni Tsigas, Peter von Dadelszen.</strong> <em>The 2021 International Society for the Study of Hypertension in Pregnancy classification, diagnosis &amp; management recommendations for international practice.</em> Pregnancy Hypertension. 2022;27:148–169. doi: 10.1016/j.preghy.2021.09.008. <a href="https://pubmed.ncbi.nlm.nih.gov/35066406/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO (PDF)</a>.</li>
  <li><strong>Healio Nephrology.</strong> <em>Laboratory signs show early CKD risks for women with preeclampsia.</em> 4. februára 2026. <a href="https://www.healio.com/news/nephrology/20260204/laboratory-signs-show-early-ckd-risks-for-women-with-preeclampsia" target="_blank" rel="noopener noreferrer">Healio</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje všetkých troch príspevkov z <em>JASN</em> (list, odpoveď autorov aj pôvodná práca) boli overené v PubMed a Europe PMC. Číselné údaje pôvodnej kohorty — veľkosť súboru, 6 % podiel preeklampsie, medián sledovania 7 rokov, incidencie na 1000 osoborokov, pomery rizík s intervalmi spoľahlivosti a miery popôrodného testovania (20 %, 10 %, 5 %) — pochádzajú z abstraktu práce a z odbornej tlače, ktorá ju referovala. Prepočet pri prahu UACR nad 30 mg/g (428 oproti 113 a 3025 oproti 662 príhod) uvádzajú autori v publikovanej odpovedi na list; súčet 113 a 662 zodpovedá 775 príhodám albuminúrie v pôvodnej práci. Plné texty listu aj odpovede sú za platobnou bariérou vydavateľa a neboli sprístupnené. Sekcia o mechanizme (glomerulárna endotelióza, strata podocytov) a metodická poznámka o obojsmernom detekčnom skreslení sú <strong>vlastným odborným komentárom</strong>, nie tvrdením citovaných prác.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_renalne-riziko-po-preeklampsii-detekcia-albuminuria_article',
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
