<?php
/**
 * Odborne a jazykovo revidovaný článok o nositeľných senzoroch v nefrológii
 * a dialýze. Spracovaný prehľad Stauss et al., Sensors 2023 – pôvodní autori
 * sú uvedení v source_authors.php.
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
    'title'        => 'Nositeľné senzory v nefrológii a dialýze: čo už má validačné dáta a čo je stále vo vývoji',
    'slug'         => 'wearables-dialyza-nefrologia-dokazy-a-limity',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Neinvazívne meranie hemoglobínu má pri hemodialýze prvé validačné dáta, detekcia arytmií pri zlyhaní obličiek nie. Prehľad toho, čo z nositeľných senzorov obstojí v dialyzačnej praxi a kde sa limity prehliadajú.',
    'content'      => <<<'HTML'
<p>Nositeľné senzory sa v nefrológii ponúkajú s jasným prísľubom: zachytiť zhoršenie skôr, než sa pacient dostane na pohotovosť. Prísľub je opodstatnený, no populácia s chronickou chorobou obličiek a najmä s dialyzačnou liečbou patrí k tým, kde sa poznatky z bežnej populácie prenášajú najhoršie. Zmenená cievna stena, arteriovenózny prístup na predlaktí, opakované objemové výkyvy a rýchle elektrolytové posuny robia z dialyzovaného pacienta úplne iný merací objekt než je zdravý nositeľ inteligentných hodiniek.</p>

<p>Nasledujúci text triedi jednotlivé použitia podľa toho, čo o nich skutočne vieme: kde už existujú validačné údaje z dialyzačnej populácie, kde ide o prenos z inej populácie a kde sme stále vo fáze prototypu.</p>

<h2>Prečo sa dôkazy z bežnej populácie neprenášajú</h2>

<ul>
  <li><strong>Kvalita pulzovej vlny.</strong> Väčšina spotrebných senzorov stojí na fotopletyzmografii. Pri chronickej chorobe obličiek mení pulzovú vlnu kalcifikácia médie, arteriálna tuhosť, anémia aj periférna hypoperfúzia počas ultrafiltrácie. Prehľadová práca k tejto téme priamo uvádza, že platnosť bezmanžetového merania tlaku u pacientov s cievnymi zmenami pri chorobe obličiek je potrebné <em>naliehavo</em> objasniť.</li>
  <li><strong>Dynamika, nie hodnota.</strong> Kaliémia, natrémia aj objem sa počas jedného sedenia menia rýchlo. Bodová laboratórna hodnota a kontinuálny signál zo senzora preto nemerajú to isté a nemožno ich stotožňovať.</li>
  <li><strong>Miesto merania.</strong> Končatina s fistulou alebo graftom má odlišnú hemodynamiku. Údaje z nej nie sú zameniteľné s údajmi z druhostrannej končatiny.</li>
  <li><strong>Validácia musí prebehnúť počas dialýzy.</strong> Zariadenie overené v pokoji nemá preukázanú presnosť v prostredí, ktoré je fyziologicky agresívne.</li>
</ul>

<h2>Neinvazívny hemoglobín: prvé skutočné validačné dáta</h2>

<p>Doteraz najkonkrétnejší výsledok pochádza z prospektívneho porovnávacieho hodnotenia náplasťového senzora noseného nad arteriovenóznym prístupom. Zahrnulo <strong>116 hemodialyzovaných pacientov</strong> na štyroch pracoviskách (tri v USA, jedno v Jordánsku) a porovnávalo neinvazívne stanovenie hemoglobínu a hematokritu s laboratórnym vyšetrením z krvi.</p>

<div class="table-responsive" role="region" aria-label="Presnosť neinvazívneho merania hemoglobínu a hematokritu pri hemodialýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">Systematická odchýlka</th>
      <th scope="col">95 % hranice zhody</th>
      <th scope="col">Korelácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Hemoglobín</th>
      <td>−0,04 g/dl</td>
      <td>−2,00 až +1,86 g/dl</td>
      <td>r = 0,64</td>
    </tr>
    <tr>
      <th scope="row">Hematokrit</th>
      <td>−0,14 %</td>
      <td>−5,84 až +5,53 %</td>
      <td>r = 0,66</td>
    </tr>
  </tbody>
</table>
</div>

<p>Tieto čísla sa dajú prečítať dvoma spôsobmi a oba sú pravdivé. Systematická odchýlka je zanedbateľná, takže <strong>na sledovanie trendu v skupine aj u jednotlivca je metóda použiteľná</strong>. Hranice zhody však znamenajú, že jednotlivé meranie sa od laboratórnej hodnoty môže líšiť približne o 2 g/dl. To je rozdiel, ktorý sám osebe rozhoduje o zmene dávky látky stimulujúcej erytropoézu alebo o podaní železa. <strong>Náhrada laboratórneho vyšetrenia pred zmenou dávky teda z týchto údajov nevyplýva.</strong></p>

<p>K tomu patria limity, ktoré autori sami uvádzajú: hodnotenie prebehlo počas jedného dialyzačného sedenia, pacienti s hemoglobinopatiami boli vylúčení, analyzovali sa iba natívne fistuly (nie protetické graftové prístupy) a správanie zariadenia naprieč typmi pokožky si vyžaduje ďalšie sledovanie.</p>

<h2>Arytmie: presne tu chýbajú dáta</h2>

<p>Napriek tomu, že detekcia fibrilácie predsiení je marketingovo najviditeľnejšou funkciou spotrebných zariadení, prehľadová práca konštatuje, že <strong>pre neinvazívnu wearable detekciu arytmií v populácii s terminálnym zlyhaním obličiek neexistujú publikované štúdie</strong>. Nejde pritom len o chýbajúcu validáciu senzora. Nejasná je aj klinická nadväznosť: indikácia antikoagulácie pri fibrilácii predsiení u dialyzovaného pacienta je sama osebe predmetom sporu, takže záchyt bez rozhodovacieho algoritmu nemusí pacientovi priniesť nič.</p>

<p>Paradoxne pritom platí, že práve u dialyzovaných pacientov je kontinuálny záznam rytmu klinicky najzaujímavejší – implantovateľné slučkové záznamníky ukázali prevahu bradyarytmií nad komorovými arytmiami. Prenos tejto informácie na neinvazívny senzor je však zatiaľ nepodložený.</p>

<h2>Draslík z krivky EKG: nádejné, ale nie hotové</h2>

<p>Model hlbokého učenia trénovaný na krivkách EKG dokázal v populácii s ochorením obličiek rozpoznať hyperkaliémiu z dvoch zvodov s plochou pod krivkou 0,883. To je výsledok na úrovni skríningového nástroja, nie náhrady laboratórneho stanovenia: pri nízkej prevalencii ťažkej hyperkaliémie zostáva pozitívna prediktívna hodnota obmedzená a model bol vyvinutý na štandardnom zázname, nie na signáli zo spotrebného zariadenia.</p>

<p>Praktický záver je preto opatrný: cesta „draslík z hodiniek“ je technicky predstaviteľná a intenzívne sa skúma, ale rozhodovať podľa nej o dialyzačnej preskripcii dnes nemožno.</p>

<h2>Objemový stav: najbližšie k praxi, no najmenej „nositeľné“</h2>

<p>Bioimpedančné hodnotenie poskytuje objektívnejší podklad na riadenie ultrafiltrácie než samotná hmotnosť a v prehľade sa uvádza ako oblasť s najvyššou citlivosťou v porovnaní s tradičným postupom. Metodicky však ide skôr o bodové vyšetrenie než o kontinuálny nositeľný senzor: vyžaduje pripojenie elektród, je citlivé na polohu tela, redistribúciu tekutín a telesné zloženie. Dlhodobé údaje o vplyve na tvrdé ukazovatele zostávajú obmedzené.</p>

<p>V praxi preto bioimpedancia patrí do súboru metód na stanovenie cieľovej hmotnosti spolu s klinickým hodnotením a ultrazvukom, nie do kategórie zariadení, ktoré pacient nosí medzi sedeniami.</p>

<h2>Kde sú dôkazy najsilnejšie: domáca dialýza</h2>

<p>Najpresvedčivejšia oblasť nie je senzorika, ale organizácia starostlivosti. Prehľadová práca k vzdialenému monitorovaniu pri domácej hemodialýze a peritoneálnej dialýze uvádza lepšie zapojenie pacienta, lepšie dodržiavanie liečby, kvalitu života, nižší počet prechodov na centrovú hemodialýzu a nižšiu hospitalizovanosť. Ide prevažne o observačné údaje a o systémy vzdialeného zberu dát z liečby, nie o dôkazy z randomizovaných štúdií s nositeľnými senzormi.</p>

<p>Rovnaký prehľad menuje aj tri hlavné prekážky: technologické obmedzenia, ochranu údajov a nerovnomerné prijatie zo strany pacientov aj personálu.</p>

<h2>Nositeľná umelá oblička: stále vo vývoji</h2>

<p>Prototypy pre peritoneálnu dialýzu (AWAK, Carry Life, WEAKID, ViWAK) prešli malými štúdiami na zvieratách alebo na obmedzenom počte ľudí. Hemodialyzačné riešenia narážajú na trvalé technické prekážky: zrážanie v mimotelovom okruhu, kolísanie prietokov, regeneráciu dialyzačného roztoku sorbentmi a bezpečnostné mechanizmy. Rozdiel oproti bežnému monitorovaniu je zásadný a stojí za jednoduchým zhrnutím: <strong>nositeľný monitor je dnes realistický, nositeľná dialýza nie.</strong></p>

<h2>Vecná kontrola tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Vecná kontrola tvrdení o nositeľných senzoroch v nefrológii" tabindex="0">
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
      <th scope="row">Nositeľné senzory majú najväčší potenciál pri dialýze, najmä domácej</th>
      <td>Pravdepodobné</td>
      <td>Podporené prehľadovou literatúrou a skúsenosťou zo vzdialeného monitorovania domácej liečby; ide o observačné údaje, nie o dôkazy z randomizovaných štúdií.</td>
    </tr>
    <tr>
      <th scope="row">Neinvazívne meranie hemoglobínu je pri hemodialýze presné</th>
      <td>Čiastočne</td>
      <td>Systematická odchýlka je zanedbateľná, hranice zhody však dosahujú približne ±2 g/dl. Vhodné na sledovanie trendu, nie na rozhodnutie o dávke pred laboratórnym overením.</td>
    </tr>
    <tr>
      <th scope="row">Neinvazívna detekcia arytmií je pri zlyhaní obličiek preukázaná</th>
      <td>Nepotvrdené</td>
      <td>Prehľad uvádza, že publikované štúdie v tejto populácii chýbajú a klinická nadväznosť nálezu je nejasná.</td>
    </tr>
    <tr>
      <th scope="row">Draslík sa dá spoľahlivo merať nositeľným zariadením</th>
      <td>Nesprávne</td>
      <td>Ide o oblasť vývoja. Odhad hyperkaliémie z EKG modelom hlbokého učenia dosahuje skríningovú výkonnosť, nie diagnostickú istotu, a nebol overený v podobe nositeľného senzora.</td>
    </tr>
    <tr>
      <th scope="row">Bioimpedancia pomáha riadiť ultrafiltráciu</th>
      <td>Pravdepodobné</td>
      <td>Citlivejšia než samotná hmotnosť, ale metodicky zraniteľná a bez presvedčivých dlhodobých výsledkov. Nie je to nositeľná technológia v pravom zmysle.</td>
    </tr>
    <tr>
      <th scope="row">Nositeľná umelá oblička je blízko klinického použitia</th>
      <td>Nesprávne</td>
      <td>Prototypy zostávajú v skorých fázach vývoja s nevyriešenými technickými a bezpečnostnými otázkami.</td>
    </tr>
    <tr>
      <th scope="row">Viac dát znamená lepšiu starostlivosť</th>
      <td>Nesprávne</td>
      <td>Bez rozhodovacieho pravidla vedie nekontrolované monitorovanie k falošne pozitívnym nálezom, úzkosti pacienta, zbytočným zásahom a únave z upozornení.</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Sedem otázok pred zavedením akéhokoľvek zariadenia</h2>

<ol>
  <li><strong>Akú klinickú otázku rieši?</strong> Nie „čo vie merať“, ale „aké rozhodnutie sa vďaka nemu zmení“.</li>
  <li><strong>Bolo validované v tejto populácii?</strong> Overenie u zdravých dobrovoľníkov alebo u kardiologických pacientov nestačí; pri fotopletyzmografii to platí dvojnásobne.</li>
  <li><strong>Poznám hranice zhody, nielen koreláciu?</strong> Vysoká korelácia a klinicky zameniteľné meranie nie sú to isté.</li>
  <li><strong>Kto reaguje na upozornenie?</strong> Menovite, v akom čase a s akým postupom. Bez tejto odpovede zariadenie nezavádzať.</li>
  <li><strong>Aká je očakávaná miera falošných poplachov?</strong> A čo sa stane, keď personál začne upozornenia ignorovať.</li>
  <li><strong>Kam idú údaje?</strong> Právny základ spracúvania, spracovateľská zmluva, prenos mimo Európsku úniu, prepojenie na zdravotnícku dokumentáciu.</li>
  <li><strong>Ide o zdravotnícku pomôcku alebo o spotrebný produkt?</strong> Rozdiel v regulačnom postavení určuje, čo možno použiť ako podklad klinického rozhodnutia.</li>
</ol>

<h2>Riziká, ktoré sa pri nadšení prehliadajú</h2>

<p><strong>Únava z upozornení.</strong> Prehľad na ňu upozorňuje výslovne: nekontrolované používanie vedie k falošne pozitívnym nálezom, k úzkosti pacienta a k zbytočným zásahom. V dialyzačnom stredisku, kde je personálu chronicky nedostatok, je to reálna bezpečnostná hrozba, nie teoretická poznámka.</p>

<p><strong>Digitálna priepasť.</strong> Časť pacientov nemá prístup k technológii ani zručnosti na jej používanie. Ak sa monitorovanie stane cestou k lepšej starostlivosti, jeho zavedenie bez podpory znevýhodní práve tých, ktorí sú už znevýhodnení – starších, sociálne slabších, pacientov s poruchou zraku alebo s kognitívnym deficitom.</p>

<p><strong>Prehnané očakávanie pacienta.</strong> Zariadenie, ktoré ukazuje „hodnotu hemoglobínu“, pacient prirodzene považuje za laboratórny výsledok. Bez vysvetlenia, že ide o odhad s tolerančným pásmom, vzniká konflikt medzi číslom na displeji a odberom.</p>

<h2>Praktický záver</h2>

<p>Nositeľné senzory v nefrológii nie sú ani hotovým riešením, ani prázdnym sľubom. Najbližšie ku klinickému využitiu je dnes sledovanie trendu neinvazívnych ukazovateľov a vzdialené monitorovanie domácej dialýzy, kde technológia dopĺňa existujúci systém starostlivosti. Najďalej zostávajú priame meranie elektrolytov a nositeľná náhrada funkcie obličiek.</p>

<p>Rozhodujúce kritérium pri výbere nie je počet meraných parametrov, ale to, či existuje overená presnosť v dialyzačnej populácii a jasný postup, čo sa s nameraným údajom stane. Zariadenie bez rozhodovacieho pravidla je len drahý zberač dát – a v prostredí s nedostatkom personálu aj zdroj rizika.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=wearables-chronicke-ochorenia-protokoly-klinicky-zmysel">Wearables pri chronických ochoreniach: viac dát nestačí, rozhodujú protokoly a klinický zmysel</a></li>
  <li><a href="article.php?slug=stanovenie-suchej-vahy-edw-hemodialyza">Stanovenie suchej váhy (EDW) pri hemodialýze: klinický odhad, BCM, BVM a POCUS</a></li>
  <li><a href="article.php?slug=digitalne-zdravotnictvo-nerovnosti-who-nefrologia">Digitálne zdravotníctvo a riziko prehlbovania nerovností</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Stauss M, Htay H, Kooman JP, Lindsay T, Woywodt A. Wearables in Nephrology: Fanciful Gadgetry or Prêt-à-Porter? <em>Sensors (Basel)</em>. 2023;23(3):1361. doi: 10.3390/s23031361. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9919296/" target="_blank" rel="noopener noreferrer">Plný text</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/36772401/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Validácia neinvazívneho hemoglobínu:</strong> Steig A, Miller F, Shreim S, Wilcox J, Sykes C, Whittaker D, Sivaprakasam R, Gupta S, Kuraguntla D. Remote management of anaemia in patients with end-stage kidney disease using a wearable, non-invasive sensor. <em>Clinical Kidney Journal</em>. 2025;18(1):sfae375. doi: 10.1093/ckj/sfae375. <a href="https://academic.oup.com/ckj/article/18/1/sfae375/7907250" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Vzdialené monitorovanie pri domácej dialýze:</strong> Arya S, Zhang S, Fu X. Remote Patient Monitoring in Home Dialysis Patients: Enhancing Care for Home Hemodialysis and Peritoneal Dialysis. <em>Seminars in Dialysis</em>. 2026. doi: 10.1111/sdi.70041. <a href="https://onlinelibrary.wiley.com/doi/10.1111/sdi.70041" target="_blank" rel="noopener noreferrer">Plný text</a>.</em></small></p>

<p><small><em><strong>Odhad hyperkaliémie z EKG:</strong> Galloway CD, Valys AV, Shreibati JB, et al. Development and Validation of a Deep-Learning Model to Screen for Hyperkalemia From the Electrocardiogram. <em>JAMA Cardiology</em>. 2019;4(5):428–436. doi: 10.1001/jamacardio.2019.0640. <a href="https://pubmed.ncbi.nlm.nih.gov/30942845/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Bibliografické údaje a uvedené číselné výsledky boli overené 23. augusta 2026. Text hodnotí publikované validačné údaje, nie konkrétne komerčné produkty, a nenahrádza posúdenie regulačného postavenia zariadenia pred jeho zavedením do praxe.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_wearables_dialyza_nefrologia',
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
