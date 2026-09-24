<?php

/**
 * Odborny prehlad vysledkov kontrolovanej krmnej studie DASH4D.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'DASH4D pri diabete 2. typu: lepšia glykémia a krvný tlak v kontrolovanej štúdii',
    'slug'         => 'dash4d-diabetes-2-typu-glykemia-tlak',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-09-24 12:02:28',
    'is_top'       => 0,
    'excerpt'      => 'Kontrolovaná kŕmna štúdia DASH4D ukázala malé zlepšenie laboratórnych markerov glykémie, priaznivejší profil CGM a pokles tlaku. Výsledky však nemožno bez ďalšieho preniesť na pokročilé CKD.',
    'content'      => <<<'HTML'
<p><strong>DASH4D</strong> je stravovací model odvodený od diéty DASH a upravený pre dospelých s diabetes mellitus 2. typu. V randomizovanej kontrolovanej kŕmnej štúdii zlepšil oproti typickej americkej strave viaceré krátkodobé ukazovatele glykémie. Kombinácia DASH4D s nižším príjmom sodíka zároveň znížila krvný tlak. Výsledky sú presvedčivým dôkazom biologickej účinnosti pri presne dodanej strave, neposkytujú však dôkaz o prevencii renálnych alebo kardiovaskulárnych príhod.</p>
<p>Najnovšia sekundárna analýza biomarkerov bola publikovaná online v časopise <em>Diabetes Care</em> 28. augusta 2026. Ide o ďalšiu analýzu tej istej štúdie DASH4D, nie o novú nezávislú randomizovanú štúdiu. Pri interpretácii preto nemožno výsledky jednotlivých publikácií počítať ako opakované nezávislé potvrdenie účinku.</p>

<h2>Čím sa DASH4D líši od pôvodnej diéty DASH</h2>
<p>Jedálny lístok DASH4D zachováva dôraz na zeleninu, ovocie, celozrnné potraviny a nízkotučné mliečne výrobky a obmedzuje červené a spracované mäso, sladkosti a sladené nápoje. Oproti pôvodnej diéte DASH obsahuje menej sacharidov, viac nenasýtených tukov a menej draslíka. Zníženie draslíka malo zvýšiť použiteľnosť modelu u časti ľudí s diabetom a ochorením obličiek. Neznamená však, že ide o univerzálnu renálnu diétu alebo že je bezpečný pri každom stupni CKD.</p>

<h2>Ako bola štúdia usporiadaná</h2>
<p>DASH4D bola randomizovaná štvorperiodická skrížená kŕmna štúdia uskutočnená v rokoch 2021 až 2024. Každý účastník dostával v náhodnom poradí štyri izokalorické diéty:</p>
<ol>
<li>DASH4D s nižším obsahom sodíka,</li>
<li>DASH4D s vyšším obsahom sodíka,</li>
<li>porovnávaciu stravu s nižším obsahom sodíka,</li>
<li>porovnávaciu stravu s vyšším obsahom sodíka.</li>
</ol>
<p>Každé obdobie trvalo päť týždňov a od ďalšieho ho oddeľoval najmenej týždňový interval. Pri energetickom príjme 2 000 kcal obsahovala nižšia sodíková úroveň približne 1 500 mg sodíka denne a vyššia približne 3 700 mg denne. Výskumný tím dodal účastníkom všetku stravu, nepovoľoval potraviny mimo protokolu a upravoval energetický príjem tak, aby sa telesná hmotnosť nemenila. Štúdia teda skúmala účinok zloženia stravy nezávisle od chudnutia.</p>
<p>Do analýzy laboratórnych markerov vstúpilo 101 dospelých s priemerným vekom 67 rokov; 65 % tvorili ženy a 87 % účastníkov sa identifikovalo ako černosi. Analýza kontinuálneho monitorovania glukózy zahŕňala 89 účastníkov. Takéto zloženie vzorky je dôležité pri posudzovaní prenositeľnosti výsledkov na inú populáciu.</p>

<h2>Laboratórne markery glykémie: štatisticky významný, ale malý rozdiel</h2>
<p>V porovnaní s kontrolnou stravou, po spriemerovaní oboch sodíkových úrovní, viedla DASH4D k týmto priemerným rozdielom:</p>
<ul>
<li>fruktozamín: −5,6 µmol/l (P = 0,002),</li>
<li>glykémia nalačno: −4,5 mg/dl (P = 0,02),</li>
<li>HbA1c: −0,09 percentuálneho bodu (P = 0,04).</li>
</ul>
<p>Fruktozamín odráža glykémiu približne za predchádzajúce dva až tri týždne, kým glykémia nalačno je okamžitý údaj ovplyvnený dennou variabilitou. HbA1c odzrkadľuje dlhšie obdobie, pričom päťtýždňová intervencia je príliš krátka na zachytenie jej plného ustáleného účinku. Pokles HbA1c o 0,09 percentuálneho bodu bol štatisticky významný, jeho absolútna veľkosť však bola malá. Z tejto zmeny nemožno odvodiť redukciu komplikácií diabetu.</p>

<h2>Kontinuálne monitorovanie glukózy</h2>
<p>V samostatnej analýze CGM znížila DASH4D priemernú glukózu o 11,1 mg/dl a zvýšila čas v cieľovom rozmedzí 70–180 mg/dl o 5,2 percentuálneho bodu oproti porovnávacej strave, v oboch prípadoch P &lt; 0,001. Rozdiel 5,2 percentuálneho bodu zodpovedá približne 75 minútam denne navyše v cieľovom rozmedzí. DASH4D skrátila aj čas v hyperglykémii a znížila smerodajnú odchýlku glukózy, ale nezmenila variačný koeficient (P = 0,52). Rozdiel v čase v hypoglykémii sa nepreukázal.</p>
<p>Tieto výsledky ukazujú priaznivý krátkodobý glykemický profil. Štúdia však netestovala, či sa zmena CGM premietne do nižšieho výskytu progresie CKD, kardiovaskulárnych príhod alebo mortality.</p>

<h2>Krvný tlak: treba oddeliť stravovací model od účinku sodíka</h2>
<p>V primárnej analýze krvného tlaku malo porovnanie DASH4D s nižším obsahom sodíka oproti typickej americkej strave s vyšším obsahom sodíka za následok pokles systolického tlaku o 4,6 mmHg (95 % CI −7,2 až −2,0) a diastolického tlaku o 2,3 mmHg (95 % CI −3,7 až −0,9). Toto porovnanie však súčasne mení stravovací model aj príjem sodíka. Autori zistili, že väčšiu časť tlakového účinku vysvetľovalo zníženie sodíka. Celý rozdiel preto nemožno pripísať samotnému modelu DASH4D.</p>

<h2>Čo výsledky znamenajú pre nefrologickú prax</h2>
<p>DASH4D ponúka použiteľný rámec pre pacienta s diabetom 2. typu, hypertenziou a zachovanou alebo mierne až stredne zníženou funkciou obličiek, ak sa jedálny lístok prispôsobí laboratórnym výsledkom, liečbe a nutričným potrebám. Prakticky ide najmä o nahradenie vysoko spracovaných potravín a sladených nápojov minimálne spracovanými potravinami, preferovanie nenasýtených tukov a primerané zníženie sodíka.</p>
<p>Pri CKD musí byť odporúčanie individuálne. Zo štúdie boli vylúčení ľudia s eGFR &lt; 30 ml/min/1,73 m², sérovým draslíkom ≥ 5,2 mmol/l alebo &lt; 3,5 mmol/l a pacienti užívajúci doplnky draslíka. Výsledky preto nepotvrdzujú bezpečnosť pri CKD G4–G5, dialýze, aktuálnej hyperkaliémii ani pri vysokej náchylnosti na hyperkaliémiu. Obsah draslíka, sodíka, bielkovín a energie treba upraviť podľa štádia CKD, albuminúrie, kaliémie, krvného tlaku, nutričného stavu a súbežnej liečby.</p>
<p>Medzi ďalšie významné vylučovacie kritériá patrili HbA1c &gt; 9 %, používanie rýchlo pôsobiaceho inzulínu, nestabilná antihypertenzná liečba, nedávna významná zmena hmotnosti a závažné nestabilné ochorenie. Na tieto skupiny sa výsledky nesmú automaticky extrapolovať. Pri úprave stravy a zlepšení glykémie môže byť navyše potrebné prehodnotiť inzulín alebo lieky s rizikom hypoglykémie.</p>

<h2>Silné stránky a limity dôkazov</h2>
<p>Skrížené usporiadanie umožnilo, aby každý účastník slúžil ako vlastná kontrola. Dodanie všetkých jedál, kontrola sodíka a udržiavanie stabilnej hmotnosti výrazne obmedzili skreslenie adherenciou a chudnutím. Práve táto prísna kontrola však znižuje podobnosť s bežnou ambulantnou praxou.</p>
<p>Hlavnými limitmi sú malá vzorka, jediné centrum, krátke päťtýždňové obdobia a vybraná populácia prevažne starších černošských dospelých. Štúdia nehodnotila dlhodobú udržateľnosť, kvalitu života, klinické renálne ani kardiovaskulárne príhody. Neumožňuje ani určiť, ktorá jednotlivá zložka stravy spôsobila glykemický účinok.</p>

<h2>Záver</h2>
<p>Kontrolovaná kŕmna štúdia ukázala, že DASH4D môže aj bez úbytku hmotnosti mierne zlepšiť laboratórne markery glykémie, priaznivejšie ovplyvniť profil CGM a v kombinácii s nižším príjmom sodíka znížiť krvný tlak. Dôkazy podporujú stravovací model ako doplnok štandardnej liečby diabetu a hypertenzie. Zatiaľ však nedokazujú dlhodobú ochranu obličiek ani bezpečnosť pri pokročilom CKD. V nefrologickej praxi má byť plán vždy prispôsobený eGFR, kaliémii, albuminúrii, nutričnému stavu a farmakoterapii.</p>
<p><small><em>Redakčné overenie k 24. septembru 2026: bibliografické údaje, dizajn štúdie a číselné výsledky boli overené v záznamoch PubMed a v primárnych publikáciách. Text je odborným prehľadom a nenahrádza individuálne nutričné ani terapeutické rozhodnutie.</em></small></p>

<div class="pdf-keep-together"><hr><h2>Zdroje</h2><ol>
<li><small><em>Fang M, Wang D, Rebholz CM, et al. Effects of the DASH4D Diet on Biomarkers of Glycemia in Adults With Type 2 Diabetes: A Secondary Analysis of the DASH4D Randomized Clinical Trial. Diabetes Care. Publikované online 28. augusta 2026. doi:10.2337/dc26-1062; <a href="https://pubmed.ncbi.nlm.nih.gov/42663510/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Fang M, Wang D, Rebholz CM, et al. DASH4D diet for glycemic control and glucose variability in type 2 diabetes: a randomized crossover trial. Nat Med. 2025;31(10):3309–3316. doi:10.1038/s41591-025-03823-3; <a href="https://pubmed.ncbi.nlm.nih.gov/40764427/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Pilla SJ, Yeh HC, Mitchell CM, et al.; DASH4D Collaborative Research Group. Dietary Patterns, Sodium Reduction, and Blood Pressure in Type 2 Diabetes: The DASH4D Randomized Clinical Trial. JAMA Intern Med. 2025;185(8):937–946. doi:10.1001/jamainternmed.2025.1580; <a href="https://pubmed.ncbi.nlm.nih.gov/40489102/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Wang D, Mu SZ, Tang O, et al. Design of the Continuous Glucose Monitoring (CGM) Study in the Dietary Approaches to Stop Hypertension for Diabetes Trial (DASH4D-CGM). Contemp Clin Trials. 2025;151:107845. doi:10.1016/j.cct.2025.107845; <a href="https://pubmed.ncbi.nlm.nih.gov/39952551/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
</ol></div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_dash4d-diabetes-2-typu-glykemia-tlak_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\nMigrácia článku: {$articles[0]['title']}\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny): $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $error) {
        echo "Chyba: $error\n";
    }
} else {
    echo '<p>Článok bol spracovaný: ' . htmlspecialchars($articles[0]['title']) . '.</p>';
}
