<?php

/**
 * add_hypertenzia-v-tehotenstve-a-po-porode-nefrologicka-rola_article.php
 * Hypertenzne poruchy v gravidite a po porode - uloha nefrologa.
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
    'title'        => 'Hypertenzia v tehotenstve a po pôrode: prečo popôrodná kontrola nesmie byť poslednou',
    'slug'         => 'hypertenzia-v-tehotenstve-a-po-porode-nefrologicka-rola',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Hypertenzné ochorenia komplikujú približne 9 % tehotenstiev a kardiovaskulárne príčiny tvoria vyše tretiny úmrtí súvisiacich s tehotenstvom. Tlak krvi po pôrode vrcholí medzi 3. a 6. dňom — teda v čase, keď je pacientka spravidla už doma a bez dohľadu.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pôrodom sa preeklampsia nekončí. Endotelové a kardiorenálne poškodenie po ňom úplne neustúpi, tlak krvi vrcholí až na tretí až šiesty deň po pôrode a práve toto obdobie nesie najvyššie riziko odvrátiteľného úmrtia matky. Prehľad v <em>JASN</em> označuje popôrodnú kontrolu za kritickú, no nedostatočne využívanú príležitosť — a nefrológovi v nej prisudzuje konkrétnu úlohu.</em></p>

<p>Hypertenzné ochorenia v tehotenstve postihujú podľa prehľadu Line Malhy a Phyllis August približne <strong>9 % tehotenstiev v USA</strong> a patria medzi hlavné príčiny materskej chorobnosti a úmrtnosti. Kardiovaskulárne príčiny pritom tvoria <strong>vyše tretiny všetkých úmrtí súvisiacich s tehotenstvom</strong>.</p>

<p>Pre nefrológa ide o tému na priesečníku dvoch smerov. Chronická choroba obličiek patrí k najsilnejším rizikovým faktorom preeklampsie — a zároveň tehotenstvo samo môže <strong>odhaliť dovtedy nerozpoznané ochorenie obličiek</strong>, pretože kladie na obličkovú a cievnu rezervu nároky, ktoré bežný život neprináša. Tehotenstvo je v tomto zmysle nechcený, ale citlivý záťažový test.</p>

<h2>Prečo poškodenie pôrodom nekončí</h2>

<p>Preeklampsia sa iniciuje v placente: uvoľňovanie antiangiogénnych faktorov, predovšetkým solubilnej fms-podobnej tyrozínkinázy 1 (sFlt-1), viaže cirkulujúci vaskulárny endotelový rastový faktor a placentárny rastový faktor. Výsledkom je rozsiahla <strong>dysfunkcia endotelu</strong> so systémovými dôsledkami vrátane akútneho kardiorenálneho poškodenia.</p>

<p>Odstránenie placenty odstraňuje zdroj antiangiogénnych faktorov, no nie ich následky. Prehľad výslovne uvádza, že kardiorenálne poškodenie sa síce zlepší, ale <strong>úplne nevymizne</strong>. Predstava, že pôrod predstavuje definitívnu liečbu preeklampsie, je preto klinicky zavádzajúca — je liečbou jej akútnej fázy, nie jej dôsledkov.</p>

<h2>Liečba tlaku krvi počas tehotenstva</h2>

<p>Otázka, či liečiť miernu chronickú hypertenziu v tehotenstve, bola dlho sporná pre obavu z hypoperfúzie placenty a rastovej reštrikcie plodu. Odpoveď priniesla štúdia <strong>CHAP</strong>, ktorá zaradila 2408 tehotných žien s miernou chronickou hypertenziou v 61 centrách a randomizovala ich pred 23. týždňom do liečby s cieľom pod 140/90 mm Hg oproti liečbe až pri rozvoji ťažkej hypertenzie.</p>

<p>Aktívna liečba znížila výskyt zloženého ukazovateľa (preeklampsia so závažnými znakmi, medicínsky indikovaný predčasný pôrod pred 35. týždňom, abrupcia placenty alebo úmrtie plodu či novorodenca) z <strong>37,0 % na 30,2 %</strong>, s upraveným relatívnym rizikom 0,82 (95 % IS 0,74–0,92). Podstatné je, že <strong>nevzrástol podiel novorodencov malých na gestačný vek</strong> — teda obava, ktorá liečbu desaťročia brzdila, sa nepotvrdila.</p>

<p>Pre výber liečiva platí:</p>

<ul>
  <li><strong>Vhodné:</strong> labetalol a nifedipín s predĺženým uvoľňovaním ako liečivá prvej voľby, metyldopa ako alternatíva s najdlhšou históriou bezpečného používania.</li>
  <li><strong>Kontraindikované:</strong> inhibítory ACE, sartany a priame inhibítory renínu pre fetopatiu s oligohydramniónom, poruchou vývinu obličiek a lebky. Vyhnúť sa treba aj antagonistom mineralokortikoidových receptorov a inhibítorom SGLT2, pre ktoré v tehotenstve chýbajú údaje o bezpečnosti.</li>
</ul>

<p>Toto je pre nefrológa mimoriadne relevantné: práve renoprotektívne liečivá, ktoré u pacientky s chronickou chorobou obličiek bežne používame, sa musia pri plánovaní tehotenstva vysadiť alebo nahradiť — a to <strong>pred koncepciou</strong>, nie až pri pozitívnom teste.</p>

<h2>Ťažká hypertenzia je akútny stav</h2>

<p>Tlak krvi 160/110 mm Hg alebo vyšší predstavuje v tehotenstve aj po pôrode urgentnú situáciu s rizikom cievnej mozgovej príhody. Liečbu treba podať bezodkladne, spravidla do 30 až 60 minút, intravenóznym labetalolom, intravenóznym hydralazínom alebo perorálnym nifedipínom s rýchlym uvoľňovaním.</p>

<p>U pacientky s preeklampsiou so závažnými znakmi je indikovaný <strong>síran horečnatý</strong> na prevenciu eklampsie. Tu si nefrológ musí uvedomiť špecifické riziko: <strong>horčík sa vylučuje takmer výlučne obličkami</strong>. Pri zníženej glomerulárnej filtrácii alebo akútnom poškodení obličiek kumuluje a hrozí útlm dýchania a zástava srdca. Dávkovanie je preto nutné redukovať a sledovať šľachové reflexy, diurézu a podľa možnosti aj koncentráciu horčíka v sére.</p>

<h2>Prevencia u rizikovej pacientky</h2>

<p>U žien so zvýšeným rizikom preeklampsie — a chronická choroba obličiek medzi ne jednoznačne patrí — je indikovaná profylaxia kyselinou acetylsalicylovou v nízkej dávke, začatá optimálne medzi 12. a 16. týždňom tehotenstva. Ide o jednu z mála intervencií, ktorá riziko preeklampsie skutočne znižuje, a jej opomenutie u nefrologickej pacientky je premárnená príležitosť.</p>

<h2>Popôrodné okno: najrizikovejšie a najmenej sledované</h2>

<p>Najdôležitejšie posolstvo prehľadu sa týka obdobia po pôrode. Tlak krvi po pôrode <strong>vrcholí medzi tretím a šiestym dňom</strong>, teda v čase, keď je pacientka spravidla už prepustená domov. Autori uvádzajú, že popôrodná hypertenzia býva <strong>podhodnotená</strong> a že práve toto obdobie nesie najvyššie riziko odvrátiteľného úmrtia matky.</p>

<p>Časové zosúladenie je nešťastné: vrchol rizika pripadá presne na obdobie, keď sa zdravotnícky dohľad končí a keď je žena zaneprázdnená novorodencom, nevyspatá a najmenej ochotná pripisovať vlastným príznakom význam. Bolesť hlavy, poruchy videnia alebo dýchavičnosť sa v tejto situácii ľahko pripíšu vyčerpaniu.</p>

<p>Prehľad preto označuje popôrodnú kontrolu za <strong>kritickú, ale nedostatočne využívanú príležitosť</strong>, pri ktorej možno identifikovať ženy potrebujúce nefrologické vyšetrenie, začať liečbu znižujúcu dlhodobé renálne a kardiovaskulárne riziko, a tým prerušiť trajektóriu smerujúcu k chronickej hypertenzii, chronickej chorobe obličiek a kardiometabolickému ochoreniu.</p>

<h2>Liečba pri dojčení</h2>

<p>Obava z prechodu liečiva do materského mlieka býva dôvodom, prečo sa popôrodná hypertenzia lieči nedostatočne. Priestor je pritom širší než počas tehotenstva:</p>

<ul>
  <li><strong>Vhodné pri dojčení:</strong> labetalol, nifedipín, a na rozdiel od tehotenstva aj <strong>inhibítory ACE</strong>, najmä enalapril a kaptopril, ktoré prechádzajú do mlieka len v minimálnom množstve. Pre nefrologickú pacientku ide o dôležitý údaj, lebo umožňuje včasný návrat k renoprotektívnej liečbe.</li>
  <li><strong>Menej vhodné:</strong> atenolol, ktorý sa v mlieku kumuluje výraznejšie než iné betablokátory.</li>
</ul>

<p>Rozhodnutie treba prijímať individuálne, no vyhýbanie sa liečbe „pre istotu“ nie je neutrálna voľba — neliečená hypertenzia po pôrode nesie vlastné, a to bezprostredné riziko.</p>

<h2>Úloha nefrológa</h2>

<p>Z prehľadu vyplýva pre nefrologickú prax niekoľko konkrétnych úloh:</p>

<ol>
  <li><strong>Pred koncepciou:</strong> upraviť liečbu u ženy s chronickou chorobou obličiek v reprodukčnom veku, vysadiť inhibítory ACE a sartany, naplánovať profylaxiu kyselinou acetylsalicylovou a zhodnotiť východiskovú funkciu obličiek a proteinúriu.</li>
  <li><strong>Počas tehotenstva:</strong> liečiť aj miernu hypertenziu na cieľ pod 140/90 mm Hg podľa výsledkov štúdie CHAP, používať vhodné liečivá a pri preeklampsii so závažnými znakmi dbať na úpravu dávky síranu horečnatého podľa funkcie obličiek.</li>
  <li><strong>Bezprostredne po pôrode:</strong> počítať s vrcholom tlaku krvi medzi tretím a šiestym dňom a zabezpečiť kontrolu v tomto období, nie až o šesť týždňov.</li>
  <li><strong>Pri popôrodnej kontrole:</strong> vyšetriť tlak krvi, funkciu obličiek a albuminúriu; pri pretrvávajúcej hypertenzii alebo proteinúrii prevziať pacientku do dlhodobého sledovania.</li>
  <li><strong>Dlhodobo:</strong> zaznamenať preeklampsiu ako trvalý rizikový faktor do dokumentácie a nastaviť pravidelné sledovanie kardiovaskulárneho aj renálneho rizika.</li>
</ol>

<h2>Limity</h2>

<p>Ide o <strong>prehľadový článok</strong>, nie o originálnu štúdiu — jeho tvrdenia zhrňujú existujúce dôkazy rôznej sily. Uvádzaný podiel 9 % sa vzťahuje na Spojené štáty a v iných krajinách sa môže líšiť podľa vekovej štruktúry rodičiek, prevalencie obezity a diagnostickej praxe. Rovnako podiel kardiovaskulárnych príčin na úmrtiach súvisiacich s tehotenstvom odráža americkú štruktúru materskej úmrtnosti a nemožno ho automaticky preniesť do európskych podmienok. Konkrétne dávkovacie a liečebné postupy uvedené v tomto článku pochádzajú z etablovaných odporúčaní a nie sú citáciami z prehľadu; v každom prípade sa má postupovať podľa platného miestneho protokolu.</p>

<h2>Záver</h2>

<p>Prehľad zhrňuje niečo, čo sa v praxi vie, ale nepremieta sa do organizácie starostlivosti: hypertenzné ochorenie v tehotenstve nie je epizóda, ktorá sa pôrodom uzavrie. Endotelové poškodenie pretrváva, tlak krvi vrcholí až po prepustení a rizikové trajektórie smerujúce k chronickej hypertenzii a chorobe obličiek sa začínajú práve v tomto období.</p>

<p>Pre nefrológa z toho vyplýva jednoduchá zmena postoja: popôrodná kontrola nemá byť poslednou návštevou uzatvárajúcou tehotenskú epizódu, ale <strong>prvou návštevou dlhodobého preventívneho sledovania</strong>. Ide o jednu z mála situácií, kde je riziková populácia jasne identifikovaná, mladá, motivovaná a v systéme už zachytená — a napriek tomu sa nám spravidla stratí.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=renalne-riziko-po-preeklampsii-detekcia-albuminuria">Renálne riziko po preeklampsii</a> — prečo sa skryté bremeno pri bežnom sledovaní nezachytí.</li>
  <li><a href="article.php?slug=proteinuria-preeklampsia-hypertenzia-ckd-riziko">Proteinúria pri preeklampsii a dlhodobé riziko hypertenzie a CKD</a>.</li>
  <li><a href="article.php?slug=ochorenie-obliciek-tehotenstvo-multidisciplinarna-starostlivost">Ochorenie obličiek v tehotenstve</a> — plánovanie pred koncepciou a multidisciplinárna starostlivosť.</li>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Line Malha, Phyllis August.</strong> <em>Hypertension Management in Pregnancy and Postpartum.</em> Journal of the American Society of Nephrology. 2026 Aug 3 (online ahead of print). doi: 10.1681/ASN.0000001236. <a href="https://pubmed.ncbi.nlm.nih.gov/42545738/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1681/ASN.0000001236" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Alan T. Tita, Jeff M. Szychowski, Kim Boggess, Lorraine Dugoff, Baha Sibai, Kirsten Lawrence, Brenna L. Hughes, Joseph Bell, Kjersti Aagaard, Rodney K. Edwards, Kelly Gibson, David M. Haas, Lauren Plante, Torri Metz, Brian Casey, Sean Esplin, Sherri Longo, Matthew Hoffman, George R. Saade, Kara K. Hoppe, Janelle Foroutan, Methodius Tuuli, Michelle Y. Owens, Hyagriv N. Simhan, Heather Frey, Tiffany Rosen, Alexi Palatnik, Susan Baker, Paul August, Uma M. Reddy, William Kinzler, Elaine Su, Ishita Krishna, Nghia Nguyen, Mark E. Norton, David Skupski, Yasser Y. El-Sayed, Dalton Ogunyemi, Zoltan S. Galis, Lisa Harper, Namaste Ambalavanan, Niloo L. Geller, Suzanne Oparil, George R. Cutter, William W. Andrews; Chronic Hypertension and Pregnancy (CHAP) Trial Consortium.</strong> <em>Treatment for Mild Chronic Hypertension during Pregnancy.</em> New England Journal of Medicine. 2022;386(19):1781–1792. doi: 10.1056/NEJMoa2201295. <a href="https://pubmed.ncbi.nlm.nih.gov/35363951/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Laura A. Magee, Mark A. Brown, David R. Hall, Sanjay Gupte, Annemarie Hennessy, S. Ananth Karumanchi, Louise C. Kenny, Fergus McCarthy, Jenny Myers, Liona C. Poon, Sarosh Rana, Shigeru Saito, Anne Cathrine Staff, Eleni Tsigas, Peter von Dadelszen.</strong> <em>The 2021 International Society for the Study of Hypertension in Pregnancy classification, diagnosis &amp; management recommendations for international practice.</em> Pregnancy Hypertension. 2022;27:148–169. doi: 10.1016/j.preghy.2021.09.008. <a href="https://pubmed.ncbi.nlm.nih.gov/35066406/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>American College of Obstetricians and Gynecologists.</strong> <em>Clinical Guidance for the Integration of the Findings of the Chronic Hypertension and Pregnancy (CHAP) Study.</em> Practice Advisory, apríl 2022. <a href="https://www.acog.org/clinical/clinical-guidance/practice-advisory/articles/2022/04/clinical-guidance-for-the-integration-of-the-findings-of-the-chronic-hypertension-and-pregnancy-chap-study" target="_blank" rel="noopener noreferrer">ACOG</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Bibliografické údaje a obsah prehľadu Malhy a August — podiel 9 % tehotenstiev, kardiovaskulárne príčiny ako vyše tretina úmrtí súvisiacich s tehotenstvom, chronická choroba obličiek ako rizikový faktor preeklampsie, tehotenstvo odhaľujúce nerozpoznané ochorenie obličiek, antiangiogénne faktory a dysfunkcia endotelu, kardiorenálne poškodenie pretrvávajúce po pôrode, vrchol popôrodnej hypertenzie medzi 3. a 6. dňom a popôrodná kontrola ako nedostatočne využitá príležitosť — boli overené v zázname PubMed a Europe PMC vrátane znenia abstraktu. Plný text prehľadu je za platobnou bariérou vydavateľa a nebol sprístupnený. Výsledky štúdie CHAP (2408 účastníčok, 30,2 % oproti 37,0 %, aRR 0,82; 95 % IS 0,74–0,92, bez nárastu podielu novorodencov malých na gestačný vek) boli overené samostatne. Konkrétne odporúčania k výberu liečiv, k liečbe ťažkej hypertenzie, k profylaxii kyselinou acetylsalicylovou, k úprave dávky síranu horečnatého pri zníženej funkcii obličiek a k liečbe pri dojčení pochádzajú z etablovaných odporúčaní a sú <strong>vlastným odborným spracovaním</strong>, nie citáciami z prehľadu.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_hypertenzia-v-tehotenstve-a-po-porode-nefrologicka-rola_article',
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
