<?php
/**
 * add_ppi-dlhodobe-uzivanie-dokazy-prax_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie ACG guideline a syntézy Ben-Eltriki et al. s nefrologickym kontextom.
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
    'title'        => 'Inhibítory protónovej pumpy pri dlhodobom používaní: čo skutočne vieme a ako to pretaviť do praxe',
    'slug'         => 'ppi-dlhodobe-uzivanie-dokazy-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Dlhodobé PPI sa v observačných štúdiách spájajú s viacerými rizikami, no kvalitnejšie dáta väčšinu kauzálnych obáv nepotvrdzujú. Klinicky rozhoduje indikácia, najnižšia účinná dávka a pravidelná revízia potreby liečby.',
    'content'      => <<<'HTML'
<p><strong>Inhibítory protónovej pumpy (PPI)</strong> patria medzi najúčinnejšie lieky na gastroezofageálnu refluxovú chorobu (GERD), erozívnu ezofagitídu a viaceré peptické alebo liekmi podmienené gastrointestinálne komplikácie. Spory sa netýkajú ich krátkodobého prínosu pri správnej indikácii, ale najmä dlhodobého používania bez pravidelnej kontroly dôvodu, dávky a trvania.</p>

<p>V observačných štúdiách sa PPI opakovane spájali s chronickou chorobou obličiek, akútnym poškodením obličiek, zlomeninami, demenciou, kardiovaskulárnymi príhodami, deficitmi mikronutrientov, infekciami a mortalitou. Takéto signály však samy osebe nedokazujú kauzalitu. Ľudia, ktorí dostávajú PPI, môžu byť už na začiatku chorší, mať krvácanie, reflux, polyfarmáciu alebo akútne ochorenie, ktoré ešte nebolo rozpoznané. Ide o skreslenie indikáciou a protopatické skreslenie, pri ktorom liek lieči skorý prejav budúcej diagnózy.</p>

<h2>Čo hovoria kvalitnejšie dáta</h2>

<p>Usmernenie American College of Gastroenterology (ACG) pre GERD uvádza, že PPI zostávajú najúčinnejšou medikamentóznou liečbou GERD. Pri dlhodobých nežiaducich účinkoch zároveň upozorňuje, že pozorovacie štúdie sú citlivé na reziduálne skreslenie a že kvalitné štúdie nepreukázali významné zvýšenie väčšiny často obávaných udalostí; výnimkou bol signál črevných infekcií. Usmernenie pritom nevylučuje malý nárast rizika pri niektorých udalostiach.</p>

<p>To nie je tvrdenie, že PPI sú „bez rizika“. Je to presnejšie tvrdenie: pri správnej indikácii majú dobre doložený prínos, zatiaľ čo veľká časť dlhodobých bezpečnostných signálov má neistú kauzálnu interpretáciu. Pri GERD preto ACG uvádza, že preukázané prínosy zvyčajne prevažujú nad teoretickými rizikami.</p>

<div class="table-responsive" role="region" aria-label="Ako interpretovať dôkazy o dlhodobom používaní PPI" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Typ dôkazu</th>
      <th scope="col">Čo môže ukázať</th>
      <th scope="col">Hlavné obmedzenie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Randomizované skúšanie</th>
      <td>Rozdiel medzi liečbou a kontrolou pri náhodnom rozdelení</td>
      <td>Často kratšie sledovanie a populácia bez dôvodu na dlhodobý PPI</td>
    </tr>
    <tr>
      <th scope="row">Aktívnym komparátorom kontrolovaná kohorta</th>
      <td>Účinok v bežnej praxi pri podobnej liečebnej indikácii</td>
      <td>Aj po vážení môžu pretrvávať nemerané rozdiely medzi skupinami</td>
    </tr>
    <tr>
      <th scope="row">Jednoduchá observačná asociácia</th>
      <td>Signál možného rizika</td>
      <td>Confounding by indication, protopatické skreslenie, reverzná kauzalita a chybné meranie expozície</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Randomizované bezpečnostné dáta: pantoprazol v COMPASS</h2>

<p>V štúdii COMPASS boli pacienti so stabilným kardiovaskulárnym alebo periférnym arteriálnym ochorením, ktorí nemali schválenú indikáciu na PPI, sekundárne randomizovaní na pantoprazol 40 mg denne alebo placebo. Po mediáne približne 3 rokov sa celková mortalita významne nelíšila: <strong>HR 1,03; 95 % interval spoľahlivosti 0,92–1,15</strong>. Jediným ukazovateľom s významným rozdielom boli črevné infekcie: <strong>1,4 % oproti 1,0 %</strong> pri placebe (pomer šancí 1,33; 95 % IS 1,01–1,75). Infekcia <em>Clostridioides difficile</em> bola v skupine s pantoprazolom približne dvakrát častejšia, celkovo však bolo zaznamenaných len 13 prípadov, takže rozdiel nedosiahol štatistickú významnosť.</p>

<p>COMPASS však nebola štúdia navrhnutá primárne na zachytenie zriedkavých alebo veľmi neskorých nežiaducich účinkov. Výsledok preto podporuje upokojenie pri niekoľkoročnej expozícii, ale nemôže definitívne vylúčiť malý účinok pri dlhšom sledovaní, v inej populácii alebo pri inom klinickom kontexte.</p>

<h2>Čo ukazuje syntéza o mortalite</h2>

<p>Systematický prehľad Ben-Eltrikiho a kol. z roku 2020 hľadal dôkazy o celkovej mortalite pri používaní PPI dlhšom než 12 týždňov. Porovnal tri odlišné typy údajov:</p>

<ul>
  <li>systematický prehľad observačných štúdií s približne ročným sledovaním: pooled OR 1,68 (95 % IS 1,53–1,84),</li>
  <li>americká kohorta veteránov s novými používateľmi PPI verzus H2-antagonistov a až 10-ročným sledovaním: HR 1,17 (95 % IS 1,10–1,24),</li>
  <li>randomizovaná časť COMPASS s pantoprazolom: HR 1,03 (95 % IS 0,92–1,15) po približne 3 rokoch.</li>
</ul>

<p>Autori zdôraznili „konvergenciu dôkazov“ z rôznych zdrojov a interpretovali výsledky varovnejšie než samotná randomizovaná štúdia. Tento záver je dôležitý ako farmakoepidemiologická hypotéza, nie ako definitívny dôkaz, že PPI spôsobujú zvýšenú mortalitu. Observačná kohorta bola prevažne mužská a biela, štúdie sa líšili populáciou, indikáciou, dĺžkou sledovania a presnosťou zachytenia užívania. Samotný prehľad navyše nevykonal novú metaanalýzu pôvodných údajov.</p>

<p>Praktický záver je preto striedmy: dlhodobý PPI bez platnej indikácie nemá byť automaticky považovaný za neškodný, ale ani za dokázanú príčinu úmrtia. Potrebná je pravidelná revízia pomeru prínosu a rizika.</p>

<h2>Renálne obavy: čo je podložené a čo nie</h2>

<h3>Akútna tubulointersticiálna nefritída</h3>

<p>Akútna tubulointersticiálna nefritída je uznávaná, hoci idiosynkratická lieková reakcia spojená aj s PPI. Môže sa prejaviť vzostupom kreatinínu bez kompletnej klasickej triády horúčky, exantému a eozinofílie. Pri nevysvetlenom akútnom zhoršení funkcie obličiek treba skontrolovať liekovú anamnézu vrátane PPI a pri podozrení liek prehodnotiť v spolupráci s nefrológom.</p>

<h3>CKD a AKI v observačných štúdiách</h3>

<p>Kohorty a metaanalýzy observačných štúdií často ukazujú spojenie PPI s incidentnou CKD, progresiou CKD alebo AKI. Tieto výsledky sú biologicky možné, ale veľkosť pozorovaných asociácií býva citlivá na definíciu expozície, porovnávaciu skupinu, zachytenie kreatinínu a klinický dôvod predpisu.</p>

<p>ACG preto neodporúča rutinné monitorovanie kreatinínu u pacientov bez iných rizikových faktorov ochorenia obličiek. Pri už prítomnej renálnej insuficiencii však uvádza používanie PPI s tesným sledovaním renálnej funkcie alebo po konzultácii s nefrológom. To je dôležité rozlíšenie: nejde o plošné laboratórne testovanie každého používateľa ani o ignorovanie rizika u pacienta s CKD, AKI alebo polyfarmáciou.</p>

<h3>Najnovší nefrologický kontext: PPI verzus H2-antagonisty pri tNSAID</h3>

<p>V juhokórejskej retrospektívnej kohorte pacientov s CKD, ktorí začali užívať tradičné NSAID, bolo medzi 5 315 používateľmi PPI a 7 112 používateľmi H2-antagonistov používanie PPI spojené s vyšším rizikom progresie CKD: <strong>aHR 1,38 (95 % IS 1,10–1,74)</strong>. Asociácia bola najvýraznejšia u žien, pri CKD G3, vo veku najmenej 71 rokov a pri 1–15 dňoch liečby.</p>

<p>Krátka expozícia 1–15 dní je pre príčinnú progresiu CKD biologicky nepresvedčivá a upozorňuje na možné časové skreslenie, akútne ochorenie, hospitalizáciu alebo reverznú kauzalitu. Štúdia preto podporuje otázku, či je gastroprotekcia potrebná a či je PPI nevyhnutný, ale nedokazuje, že zámena PPI za H2-antagonistu zabráni progresii CKD.</p>

<p>Najsilnejším nefrologickým preventívnym zásahom v tejto situácii často zostáva prehodnotenie samotného NSAID, objemového stavu a kombinácie NSAID + diuretikum + ACEi/ARB. PPI chráni pred časťou horných gastrointestinálnych komplikácií, nie pred hemodynamickým účinkom NSAID na obličku.</p>

<h2>Clopidogrel a gastroprotekcia</h2>

<p>Interakcia PPI s clopidogrelom je farmakologicky plausibilná najmä cez CYP2C19, ktorý sa podieľa na aktivácii clopidogrelu. Klinické observačné výsledky však boli nekonzistentné a sú citlivé na to, že PPI dostávajú pacienti s vyšším gastrointestinálnym aj kardiovaskulárnym rizikom.</p>

<p>ACG uvádza, že u pacientov užívajúcich clopidogrel, ktorí majú erozívnu ezofagitídu LA C alebo D alebo nedostatočne kontrolované symptómy alternatívnou liečbou, dostupné kvalitné dáta podporujú prevahu preukázaného benefitu PPI nad navrhovaným, ale veľmi sporným kardiovaskulárnym rizikom. Klinické rozhodnutie má zároveň rešpektovať oficiálne informácie o konkrétnom PPI; pri omeprazole a esomeprazole existujú regulačné upozornenia týkajúce sa CYP2C19, preto treba výber lieku riešiť individuálne.</p>

<h2>Ostatné obávané udalosti</h2>

<ul>
  <li><strong>Enterálne infekcie:</strong> zníženie žalúdočnej kyslosti je biologicky plausibilný mechanizmus; COMPASS ukázala malý nárast črevných infekcií.</li>
  <li><strong>Hypomagneziémia:</strong> relevantná najmä u rizikových pacientov, napríklad pri diuretikách, dlhodobej liečbe alebo nevysvetlených elektrolytových poruchách; rutinný skríning všetkých pacientov ACG nepodporuje.</li>
  <li><strong>Deficit vitamínu B12 a zlomeniny:</strong> observačné asociácie existujú, ale bez ďalších rizikových faktorov ACG neodporúča automatické dopĺňanie ani rutinné monitorovanie.</li>
  <li><strong>Demencia, infarkt, cievna mozgová príhoda a rakovina:</strong> jednotlivé observačné signály nie sú dostatočným dôkazom, že PPI tieto udalosti spôsobujú.</li>
</ul>

<p>Mechanistická plausibilita sama osebe nestačí. Pri klinickom rozhodnutí treba kombinovať absolútne riziko udalosti, silu indikácie, alternatívy, dĺžku expozície a kvalitu dôkazov.</p>

<h2>Praktický algoritmus</h2>

<ol>
  <li><strong>Overiť indikáciu.</strong> Rozlíšiť potvrdenú GERD, závažnú erozívnu ezofagitídu, Barrettov pažerák, ulcerózne krvácanie, hypersekrečný stav, eradikáciu <em>H. pylori</em> a gastroprotekciu pri vysokom riziku od „zabudnutého“ PPI po empirickom kurze.</li>
  <li><strong>Určiť, či je potrebná dlhodobá liečba.</strong> Pri typických príznakoch bez alarmujúcich prejavov ACG odporúča 8-týždňový empirický kurz raz denne pred jedlom; pri odpovedi odporúča pokus o vysadenie. Toto neplatí automaticky pri Barrettovom pažeráku alebo LA C/D ezofagitíde.</li>
  <li><strong>Použiť najnižšiu účinnú dávku.</strong> Pri potrebe udržiavacej liečby voliť dávku, ktorá kontroluje symptómy a udržiava hojenie. Pri neerozívnej GERD možno zvážiť intermitentný alebo režim podľa potreby.</li>
  <li><strong>Skontrolovať užívanie.</strong> Enterosolventný PPI je pri dávkovaní raz denne spravidla účinnejší 30–60 minút pred prvým jedlom než pred spaním.</li>
  <li><strong>Prehodnotiť NSAID a antitrombotiká.</strong> Najprv riešiť potrebu NSAID, krvácavé riziko, renálnu funkciu a objemový stav; gastroprotekcia nenahrádza renálnu bezpečnosť.</li>
  <li><strong>Monitorovať podľa rizika.</strong> Pri CKD alebo predchádzajúcom AKI sledovať kreatinín/eGFR a podľa kontextu draslík, objemový stav a magnézium. Pri nevysvetlenom vzostupe kreatinínu myslieť na AIN.</li>
  <li><strong>Depreskribovať kontrolovane.</strong> Po zrušení indikácie možno znížiť dávku, prejsť na intermitentné podávanie alebo liečbu vysadiť; treba pacienta upozorniť na možné prechodné návratové symptómy.</li>
</ol>

<h2>Záver</h2>

<p>PPI netreba démonizovať ani idealizovať. Pri jasnej indikácii má ich prínos pri GERD, závažnej ezofagitíde, vredovej chorobe a gastroprotekcii často prevahu. Väčšina obávaných dlhodobých udalostí bola identifikovaná najmä v observačných štúdiách, v ktorých nemožno úplne odstrániť skreslenie indikáciou, protopatické skreslenie a chyby v meraní expozície.</p>

<p>Pre nefrologickú a internú prax z toho vyplýva jednoduchý princíp: <strong>udržať PPI tam, kde je potrebný, ale pravidelne odstrániť PPI bez platnej indikácie</strong>. Pri CKD má byť súčasťou revízie aj samotné NSAID, diuretikum, ACEi/ARB, objemový stav, elektrolyty a riziko AIN. Cieľom nie je nulová expozícia PPI, ale odôvodnená expozícia v najnižšej účinnej dávke a s primeranou kontrolou.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=ppi-h2-antihistaminika-nsaid-ckd-progresia">PPI verzus H2-antihistaminiká u pacientov s CKD užívajúcich NSAID</a></li>
  <li><a href="article.php?slug=ckd-samostatny-faktor-polyfarmacie">Chronická choroba obličiek ako samostatný faktor polyfarmácie</a></li>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia RAASi/MRA terapie pri srdcovom zlyhávaní, CKD a hyperkaliémii</a></li>
</ul>

<hr>

<p><em><strong>Hlavné zdroje:</strong></em></p>

<ol>
  <li><small><em>Katz PO, Dunbar KB, Schnoll-Sussman FH, Greer KB, Yadlapati R, Spechler SJ. ACG Clinical Guideline for the Diagnosis and Management of Gastroesophageal Reflux Disease. <em>Am J Gastroenterol</em>. 2022;117:27–56. doi:10.14309/ajg.0000000000001538. PMID 34807007. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8754510/" target="_blank" rel="noopener noreferrer">Plný text v PMC</a>.</em></small></li>
  <li><small><em>Ben-Eltriki M, Green CJ, Maclure M, Musini V, Bassett KL, Wright JM. Do proton pump inhibitors increase mortality? A systematic review and in-depth analysis of the evidence. <em>Pharmacol Res Perspect</em>. 2020;8(5):e00651. doi:10.1002/prp2.651. PMID 32996701. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7525804/" target="_blank" rel="noopener noreferrer">Plný text v PMC</a>.</em></small></li>
  <li><small><em>Park S, Chun P. Chronic kidney disease progression with proton pump inhibitors versus H2 receptor antagonists in NSAID users. <em>J Nephrol</em>. 2026. doi:10.1093/joneph/aajag176. PMID 42687760. <a href="https://pubmed.ncbi.nlm.nih.gov/42687760/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
  <li><small><em>Moayyedi P, Eikelboom JW, Bosch J, et al. Safety of Proton Pump Inhibitors Based on a Large, Multi-Year, Randomized Trial of Patients Receiving Rivaroxaban or Aspirin. <em>Gastroenterology</em>. 2019;157:682–691.e2. doi:10.1053/j.gastro.2019.05.056. PMID 31152740. <a href="https://pubmed.ncbi.nlm.nih.gov/31152740/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol>

<p><small>Odborný text bol vecne a jazykovo revidovaný 17. septembra 2026. Interpretácia nenahrádza individuálne klinické rozhodnutie; pri depreskripcii treba zohľadniť pôvodnú indikáciu, endoskopický nález, krvácavé riziko a stav pacienta.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ppi_dlhodobe_uzivanie_dokazy_prax',
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
