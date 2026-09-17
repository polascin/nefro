<?php
/**
 * add_tirzepatid-vs-semaglutid-ucinnost-bezpecnost-nefro_article.php
 * Idempotentny publikačný skript odborného článku.
 * Spracovanie Paccola et al. (Clinical Obesity, 2026).
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
    'title'        => 'Tirzepatid verzus semaglutid pri redukcii hmotnosti: účinnosť, bezpečnosť a význam pre nefrologickú prax',
    'slug'         => 'tirzepatid-vs-semaglutid-ucinnost-bezpecnost-nefro',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nová syntéza priamych porovnaní ukazuje pri tirzepatide väčší priemerný úbytok hmotnosti a pokles HbA1c než pri semaglutide, ale aj vyšší výskyt závažných nežiaducich udalostí. Pre nefrológa rozhoduje najmä riziko objemovej deplécie a AKI.',
    'content'      => <<<'HTML'
<p><strong>Tirzepatid</strong>, duálny agonista receptorov GIP a GLP-1, a <strong>semaglutid</strong>, agonista receptora GLP-1, patria medzi najúčinnejšie farmakologické možnosti liečby obezity a diabetu 2. typu. Priame porovnanie však nie je iba otázkou percent úbytku hmotnosti. V nefrologickej praxi treba súčasne zohľadniť funkciu obličiek, objemový stav, súbežné diuretiká, renálne rizikové lieky a toleranciu gastrointestinálnych nežiaducich účinkov.</p>

<p>Nová systematická review a meta-analýza priamych porovnaní ukázala pri tirzepatide väčší priemerný úbytok hmotnosti a väčšie zníženie HbA1c než pri semaglutide. Súčasne však zaznamenala vyšší výskyt závažných nežiaducich udalostí (serious adverse events, SAE). Tento signál je klinicky relevantný, ale nemožno ho preložiť do jednoduchej vety, že tirzepatid je „nebezpečnejší“: SAE je heterogénny kompozit a dostupné štúdie neukazujú, ktoré konkrétne udalosti rozdiel vytvorili.</p>

<h2>Čo presne hodnotila nová meta-analýza</h2>

<p>Paccola a kol. zahrnuli štúdie, ktoré priamo porovnávali tirzepatid so semaglutidom u dospelých s nadváhou alebo obezitou a mali najmenej 24 týždňov sledovania. Syntéza obsahovala <strong>10 štúdií a 41 381 účastníkov</strong>. Išlo o kombináciu <strong>3 randomizovaných skúšaní a 7 retrospektívnych kohort</strong>, so sledovaním približne 24 až 72 týždňov.</p>

<p>Primárnym ukazovateľom bola percentuálna zmena telesnej hmotnosti. Sekundárne ukazovatele zahŕňali absolútnu zmenu hmotnosti, dosiahnutie prahov úbytku hmotnosti, HbA1c, celkové a gastrointestinálne nežiaduce udalosti, prerušenie liečby pre nežiaduce udalosti a SAE.</p>

<p>Takéto spojenie randomizovaných a retrospektívnych údajov zvyšuje počet účastníkov, ale zároveň mieša rozdielne zdroje skreslenia. Výsledok pre účinnosť je preto užitočný ako syntéza dostupných priamych porovnaní, no jeho presnosť závisí od populácie, dávky, titrácie, indikácie a kvality jednotlivých štúdií.</p>

<h2>Účinnosť: výhoda tirzepatidu v priemernom účinku</h2>

<p>V súhrnnej analýze bol tirzepatid spojený s väčším úbytkom hmotnosti než semaglutid:</p>

<ul>
  <li>rozdiel v percentuálnej zmene hmotnosti: <strong>−4,28 percentuálneho bodu</strong> (95 % interval spoľahlivosti [IS] −5,28 až −3,28),</li>
  <li>rozdiel v absolútnom úbytku: <strong>−4,43 kg</strong> (95 % IS −5,56 až −3,30),</li>
  <li>vyššia pravdepodobnosť dosiahnutia úbytku najmenej 10 %, 15 % a 20 %,</li>
  <li>bez významného rozdielu v dosiahnutí úbytku najmenej 5 %,</li>
  <li>väčšie zníženie HbA1c: <strong>−0,29 %</strong>; <em>P</em> = 0,0002.</li>
</ul>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky porovnania tirzepatidu a semaglutidu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Výsledok v prospech tirzepatidu</th>
      <th scope="col">Ako ho čítať</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Percentuálna zmena hmotnosti</th>
      <td>MD −4,28 percentuálneho bodu</td>
      <td>Priemerný rozdiel medzi liečbami, nie garantovaný rozdiel u jednotlivca</td>
    </tr>
    <tr>
      <th scope="row">Absolútny úbytok hmotnosti</th>
      <td>MD −4,43 kg</td>
      <td>Závisí od vstupnej hmotnosti, dávky, adherencie a trvania liečby</td>
    </tr>
    <tr>
      <th scope="row">Úbytok najmenej 10 %, 15 % a 20 %</th>
      <td>Vyššia pravdepodobnosť pri tirzepatide</td>
      <td>Prahové výsledky môžu byť klinicky zrozumiteľnejšie než samotný priemer</td>
    </tr>
    <tr>
      <th scope="row">HbA1c</th>
      <td>MD −0,29 %</td>
      <td>Metabolický účinok sa nedá automaticky zameniť za renálny klinický benefit</td>
    </tr>
  </tbody>
</table>
</div>

<p>Subanalýzy podľa dizajnu štúdie a prítomnosti diabetu 2. typu smerovali podobným smerom. To podporuje konzistentnosť účinnosti, ale neodstraňuje rozdiely v dávkach, eskalácii, trvaní sledovania ani v tom, či bol liek predpísaný primárne na obezitu alebo diabetes.</p>

<h2>Bezpečnosť: čo znamená signál SAE</h2>

<p>SAE boli v meta-analýze častejšie pri tirzepatide: <strong>5,7 % oproti 2,9 %</strong> pri semaglutide, čo zodpovedalo <strong>RR 1,83</strong>; <em>P</em> = 0,007. Rozdiel v prerušení liečby pre nežiaduce udalosti nebol štatisticky významný (RR 1,28; <em>P</em> = 0,54). Celkové a gastrointestinálne nežiaduce udalosti sa medzi skupinami významne nelíšili.</p>

<p>SAE je regulačná kategória, nie jedna diagnóza. Môže zahŕňať udalosť vedúcu k hospitalizácii, ohrozeniu života, významnej invalidite alebo inú závažnú klinickú situáciu podľa definície štúdie. Bez rozpisu jednotlivých SAE nemožno určiť, či rozdiel súvisel najmä s gastrointestinálnou intoleranciou, objemovou depléciou, žlčníkovými alebo pankreatickými udalosťami, kardiovaskulárnymi príhodami, infekciami alebo inými príčinami.</p>

<p>Preto je správna interpretácia užšia: v zahrnutých priamych porovnaniach sa objavil signál vyššieho rizika SAE pri tirzepatide. Neznamená to, že tirzepatid spôsobuje o 83 % viac všetkých závažných komplikácií u každého pacienta, ani že semaglutid je bez rizika.</p>

<h2>Prečo sa výsledok nedá čítať ako jednoduchý verdikt</h2>

<ul>
  <li><strong>Zmiešaný dizajn:</strong> iba 3 z 10 štúdií boli randomizované; retrospektívne kohorty môžu trpieť reziduálnym confoundingom.</li>
  <li><strong>Rôzne populácie:</strong> pacienti s obezitou bez diabetu a pacienti s diabetom nemajú rovnaké východiskové riziko ani rovnaké terapeutické ciele.</li>
  <li><strong>Rôzne dávky a titrácia:</strong> výsledok závisí od toho, či boli porovnávané maximálne tolerované dávky a ako rýchlo sa k nim pacienti dostali.</li>
  <li><strong>Kompozitný SAE endpoint:</strong> bez detailnej typológie nemožno vytvoriť špecifický nefrologický mechanizmus.</li>
  <li><strong>Obmedzené trvanie:</strong> 24 až 72 týždňov nemusí zachytiť vzácne alebo neskoré komplikácie.</li>
  <li><strong>Absolútne riziko:</strong> relatívne riziko 1,83 môže znamenať rozdiel malej alebo väčšej klinickej významnosti podľa základného rizika pacienta.</li>
</ul>

<h2>Nefrologický význam: objem, AKI a lieková záťaž</h2>

<p>Pri oboch liekoch sú nauzea, vracanie a hnačka najmä počas eskalácie dávky klinicky dôležité. U pacienta s CKD môže znížený príjem tekutín alebo straty tráviacim traktom viesť k hypovolémii, hypotenzii, poruche elektrolytov a prerenálnemu alebo zmiešanému AKI. Riziko môže byť vyššie pri diuretikách, ACE inhibítoroch alebo sartanoch, nesteroidových antiflogistikách, srdcovom zlyhávaní, horúčke či interkurentnej infekcii.</p>

<p>Nejde o dôkaz, že tirzepatid má špecifickú nefrotoxickú vlastnosť. Ide o dôvod na aktívne riadenie objemového rizika, ktoré sa môže uplatniť pri oboch inkretínových liekoch a v zraniteľnejšej populácii môže viesť k hospitalizácii alebo SAE.</p>

<h3>Bezpečnostné minimum pred začatím alebo eskaláciou</h3>

<ul>
  <li>skontrolovať kreatinín/eGFR, krvný tlak a klinický objemový stav,</li>
  <li>pri CKD a vyššom riziku zmerať sodík, draslík a podľa kontextu aj magnézium,</li>
  <li>prehodnotiť diuretiká, NSAID, ACE inhibítor/ARB a ďalšie lieky s hemodynamickým účinkom,</li>
  <li>vysvetliť pacientovi, ktoré príznaky vyžadujú včasný kontakt: opakované vracanie, pretrvávajúca hnačka, výrazný pokles príjmu tekutín, oligúria, závraty alebo kolaps,</li>
  <li>počas titrácie nastaviť kontrolu podľa rizika, nie mechanicky rovnaký interval pre všetkých.</li>
</ul>

<h3>„Sick-day“ postup musí byť individuálny</h3>

<p>Pri akútnom ochorení s vracaním, hnačkou, horúčkou alebo výrazne zníženým príjmom tekutín treba pacienta kontaktovať, posúdiť hydratáciu, tlak, diurézu, kreatinín/eGFR a elektrolyty a podľa klinického stavu dočasne upraviť liečbu. Neexistuje univerzálne pravidlo, že každý pacient má automaticky vysadiť všetky lieky. Konkrétny postup závisí od liekovej kombinácie, diabetu, krvného tlaku, srdcového zlyhávania, CKD a závažnosti interkurentného ochorenia.</p>

<h2>Účinnosť nie je to isté ako renálny benefit</h2>

<p>Väčší úbytok hmotnosti a pokles HbA1c môžu zlepšiť metabolický a kardiovaskulárny profil, ale z tejto meta-analýzy nemožno odvodiť superioritu tirzepatidu v prevencii AKI, spomalení poklesu eGFR, znížení albuminúrie alebo oddialení náhrady funkcie obličiek. Na renálny záver treba samostatné štúdie so špecifickou CKD populáciou a renálnymi ukazovateľmi.</p>

<p>Pri výbere lieku preto netreba zamieňať „väčší úbytok hmotnosti“ za „lepší liek pre každého nefrologického pacienta“. Dôležitý je očakávaný prínos pre konkrétneho pacienta, tolerancia, dávka, dostupnosť, úhrada, liekové interakcie a schopnosť bezpečne zvládnuť gastrointestinálne nežiaduce účinky.</p>

<h2>Praktické rozhodovanie v ambulancii</h2>

<ol>
  <li><strong>Definovať cieľ:</strong> liečba obezity, diabetes 2. typu, metabolické riziko alebo kombinácia.</li>
  <li><strong>Vyhodnotiť renálne riziko:</strong> štádium CKD, albuminúria, predchádzajúce AKI, diuretiká, NSAID, ACEi/ARB, srdcové zlyhávanie a sklon k dehydratácii.</li>
  <li><strong>Vybrať liek podľa celkového profilu:</strong> vyššia priemerná účinnosť tirzepatidu môže byť dôležitá, ale sama neprevažuje nad bezpečnostnými a tolerančnými problémami.</li>
  <li><strong>Titrovať podľa tolerancie:</strong> pri významných GI ťažkostiach dávku nezvyšovať mechanicky a zvážiť dočasný návrat na predchádzajúcu tolerovanú dávku podľa schválenej informácie o lieku.</li>
  <li><strong>Chrániť objem:</strong> pacient má mať jasný plán, kedy kontaktovať ambulanciu a kedy je potrebné laboratórne alebo urgentné vyšetrenie.</li>
  <li><strong>Interpretovať SAE v kontexte:</strong> zistiť, čo sa v konkrétnej udalosti skutočne stalo, nie iba priradiť rozhodnutie k číslu RR.</li>
</ol>

<h2>Záver</h2>

<p>Systematická review a meta-analýza priamych porovnaní ukázala pri tirzepatide v priemere väčší úbytok hmotnosti a väčšie zníženie HbA1c než pri semaglutide. Súčasne zaznamenala vyšší výskyt SAE (5,7 % oproti 2,9 %; RR 1,83), pričom prerušenie liečby pre nežiaduce udalosti, celkové nežiaduce udalosti a gastrointestinálne nežiaduce udalosti sa významne nelíšili.</p>

<p>Pre nefrologickú prax to nie je dôvod označiť tirzepatid za nebezpečný ani semaglutid za automaticky bezpečný. Je to dôvod na presnejšie rozhodovanie: počas titrácie sledovať toleranciu, hydratáciu, krvný tlak, funkciu obličiek a elektrolyty, najmä pri CKD, diuretikách, NSAID alebo liekoch ovplyvňujúcich hemodynamiku. Väčšia účinnosť má hodnotu iba vtedy, ak ju pacient dokáže bezpečne tolerovať a ak je zvolený režim primeraný jeho renálnemu riziku.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=geneticke-prediktory-glp1-semaglutid-tirzepatid">Genetické prediktory odpovede na semaglutid a tirzepatid</a></li>
  <li><a href="article.php?slug=inkretinove-agonisty-masld-mash-pecen-ckd">Inkretínové agonisty pri MASLD a MASH v kontexte CKD</a></li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid a riziko CKD v reálnej praxi</a></li>
  <li><a href="article.php?slug=tirzepatid-mounjaro-fda-kardiovaskularne-riziko-t2d-surpass-cvot">Tirzepatid a kardiovaskulárne riziko pri diabete 2. typu</a></li>
</ul>

<hr>

<p><em><strong>Zdroj:</strong> Paccola GP, Fernandes de Oliveira R, Mochetti MM, Marsola Razera FP, Vecchi R, Montanher RCP. Comparative Efficacy of Tirzepatide Versus Semaglutide for Weight Loss in Adults With Overweight or Obesity: A Systematic Review and Meta-Analysis of Head-to-Head Studies. <em>Clinical Obesity</em>. 2026;16(5):e70111. doi:10.1111/cob.70111. PMID 42670242. <a href="https://doi.org/10.1111/cob.70111" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42670242/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><small>Odborný text bol vecne a jazykovo revidovaný 17. septembra 2026. Výsledky meta-analýzy nepredstavujú dôkaz renálneho benefitu jednej molekuly a nenahrádzajú individuálne klinické rozhodnutie ani schválenú informáciu o lieku.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_tirzepatid_vs_semaglutid_efekt_bezpecnost',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
