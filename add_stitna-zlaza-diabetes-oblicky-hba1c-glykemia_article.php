<?php

/** Publikačný skript odborného článku. */
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
    'title' => 'Štítna žľaza, diabetes a obličky: keď HbA1c nevystihuje glykémiu',
    'slug' => 'stitna-zlaza-diabetes-oblicky-hba1c-glykemia',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Porucha funkcie štítnej žľazy aj chronická choroba obličiek môžu meniť potrebu inzulínu a skresliť HbA1c. Pri nesúlade rozhodujú priame údaje o glukóze a klinický kontext.',
    'content' => <<<'HTML'
<p>Nevysvetlené hypoglykémie, rastúca potreba inzulínu alebo nesúlad medzi glykovaným hemoglobínom (HbA1c) a priamo nameranými glykémiami môžu upozorniť na poruchu funkcie štítnej žľazy. U pacienta s chronickou chorobou obličiek (CKD) je interpretácia náročnejšia: mení sa metabolizmus inzulínu, riziko hypoglykémie aj spoľahlivosť nepriamych ukazovateľov glykémie.</p>

<p>Hormóny štítnej žľazy ovplyvňujú tvorbu glukózy v pečeni, jej využitie v periférnych tkanivách aj metabolizmus inzulínu. Hypotyreóza a hypertyreóza preto môžu narušiť dovtedy stabilný priebeh diabetu. Zmena HbA1c však nemusí zodpovedať rovnako veľkej zmene skutočnej glykemickej expozície. [1,2]</p>

<figure>
  <picture>
    <source srcset="img/stitna-zlaza-diabetes-oblicky-hba1c-glykemia.webp" type="image/webp">
    <img src="img/stitna-zlaza-diabetes-oblicky-hba1c-glykemia.png" alt="Ilustračné prepojenie štítnej žľazy, pankreasu, obličiek, erytrocytov a kontinuálneho monitorovania glukózy pri nesúlade HbA1c s glykémiou" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>HbA1c je nepriamy ukazovateľ. Jeho vzťah ku glykémii môžu meniť poruchy štítnej žľazy, CKD, anémia aj liečba ovplyvňujúca obrat erytrocytov. Ilustračné zobrazenie.</figcaption>
</figure>

<p>Východiskom článku je odborný rozhovor Kanikshy Desaiovej a Shashanka Joshiho v podcaste Medscape pripravenom s American Thyroid Association. Ide o expertnú diskusiu, nie o systematicky vytvorené klinické odporúčanie. Jej praktické závery preto treba porovnať s primárnymi štúdiami a aktuálnymi usmerneniami. [1]</p>

<h2>Dve ochorenia, viacero mechanizmov</h2>

<p>Pri diabete 1. typu je vzťah k autoimunitným ochoreniam štítnej žľazy predovšetkým imunologický. Spoločná genetická predispozícia a porucha imunitnej tolerancie zvyšujú pravdepodobnosť súbehu diabetu s Hashimotovou tyreoiditídou alebo Gravesovou-Basedowovou chorobou.</p>

<p>Prehľad Biondiovej, Kahalyho a Robertsona uvádza autoimunitné ochorenie štítnej žľazy približne u 17 až 30 % dospelých s diabetom 1. typu. Rozpätie nemožno stotožniť s podielom pacientov s aktuálne manifestnou hormonálnou poruchou. Pozitivita protilátok a klinicky významná dysfunkcia nie sú rovnaké nálezy. [2]</p>

<p>Pri diabete 2. typu je asociácia zložitejšia. Podieľajú sa na nej vek, obezita, inzulínová rezistencia a ďalšie okolnosti; autoimunitné ochorenie štítnej žľazy sa však môže vyskytnúť aj v tejto skupine. Jednoduché rozdelenie na „autoimunitný diabetes 1. typu“ a „metabolický diabetes 2. typu“ preto nevysvetľuje každý prípad.</p>

<h2>Hypotyreóza môže znížiť potrebu inzulínu, nie však u každého</h2>

<p>Pri nedostatku hormónov štítnej žľazy sa môže spomaliť metabolizmus inzulínu a znížiť tvorba glukózy v pečeni. U pacienta liečeného inzulínom to môže prispieť k hypoglykémii. Súčasne však môže pretrvávať periférna inzulínová rezistencia, takže výsledný glykemický profil nie je u všetkých pacientov rovnaký. [1,2]</p>

<p>Podozrivá je najmä nová, nevysvetlená zmena: nižšia potreba inzulínu, opakované hypoglykémie alebo nepredvídateľné glykémie. Vyšetrenie funkcie štítnej žľazy môže byť súčasťou diferenciálnej diagnostiky, nemá však nahradiť kontrolu častejších príčin.</p>

<ul>
  <li>zhoršenie funkcie obličiek a zníženie eliminácie inzulínu,</li>
  <li>menší príjem potravy, vracanie alebo interkurentné ochorenie,</li>
  <li>nesúlad dávkovania s jedlom a dialyzačným režimom,</li>
  <li>lieky s rizikom hypoglykémie a chyby pri ich užívaní.</li>
</ul>

<p>Pri diabete 1. typu a ďalších autoimunitných ochoreniach môže kombinácia hypoglykémií, hypotenzie, chudnutia alebo hyponatriémie vyžadovať aj zváženie primárnej adrenálnej insuficiencie. Všetky ťažkosti nemožno automaticky pripísať už známej hypotyreóze.</p>

<p>Percentuálne zníženie potreby inzulínu uvedené v podcaste nie je univerzálnym dávkovacím návodom. Dávka sa upravuje podľa nameraných glykémií, príjmu potravy, funkcie obličiek a rizika hypoglykémie.</p>

<h2>Hypertyreóza môže zhoršiť hyperglykémiu</h2>

<p>Nadbytok hormónov štítnej žľazy podporuje tvorbu glukózy v pečeni, mení jej absorpciu a zvyšuje metabolický obrat. Môže zvýšiť elimináciu inzulínu a zhoršiť inzulínovú rezistenciu. U človeka s diabetom sa preto môžu zvýšiť glykémie aj potreba inzulínu. [2]</p>

<p>Na tyreotoxikózu treba myslieť najmä pri zhoršení glykemickej kontroly spolu s tachykardiou, tremorom, neznášanlivosťou tepla alebo nevysvetleným chudnutím. Prejavy nie sú špecifické a diagnózu treba potvrdiť laboratórne.</p>

<p><strong>Významná hyperglykémia sa lieči súčasne s ochorením štítnej žľazy.</strong> Očakávanie, že sa glykémia upraví po zvládnutí tyreotoxikózy, nesmie oddialiť potrebné podanie inzulínu ani liečbu diabetickej ketoacidózy. Po dosiahnutí eutyreózy môže potreba inzulínu opäť klesnúť, preto dočasnú úpravu dávok musí sprevádzať plán následného prehodnotenia.</p>

<h2>Prečo HbA1c nemusí zodpovedať glykémii</h2>

<p>HbA1c závisí nielen od koncentrácie glukózy, ale aj od vekového zloženia a dĺžky prežívania erytrocytov. Hypotyreóza môže pri spomalenom obrate erytrocytov HbA1c nadhodnotiť a hypertyreóza pri zrýchlenom obrate podhodnotiť. Nejde o nevyhnutný nález ani o odchýlku s pevnou veľkosťou; univerzálny „korekčný faktor“ podľa TSH neexistuje. [1,2]</p>

<p>Pri CKD pribúdajú anémia, skrátené prežívanie erytrocytov, liečba stimulujúca erytropoézu, podanie železa a transfúzie. KDIGO preto upozorňuje, že presnosť a spoľahlivosť HbA1c klesajú v štádiách CKD G4 až G5, najmä pri dialyzačnej liečbe. HbA1c však naďalej odporúča na sledovanie dlhodobého trendu, pretože alternatívne sérové markery majú vlastné významné zdroje skreslenia. [3]</p>

<div class="table-responsive" role="region" aria-label="Faktory ovplyvňujúce interpretáciu ukazovateľov glykémie" tabindex="0">
<table>
  <thead><tr><th scope="col">Ukazovateľ</th><th scope="col">Čo približne zachytáva</th><th scope="col">Dôležité obmedzenia v tomto kontexte</th></tr></thead>
  <tbody>
    <tr><th scope="row">HbA1c</th><td>Dlhodobejšiu glykemickú expozíciu</td><td>Obrat erytrocytov, anémia, liečba stimulujúca erytropoézu, železo, transfúzie, pokročilá CKD a poruchy štítnej žľazy</td></tr>
    <tr><th scope="row">Fruktozamín</th><td>Glykáciu sérových bielkovín približne za 2 až 3 týždne</td><td>Koncentrácia a obrat bielkovín, hypoalbuminémia, proteinúria a peritoneálna dialýza</td></tr>
    <tr><th scope="row">Glykovaný albumín</th><td>Glykáciu albumínu približne za 2 až 3 týždne</td><td>Obrat albumínu, albuminúria, hypoalbuminémia a straty bielkovín</td></tr>
    <tr><th scope="row">CGM alebo glukomer</th><td>Priame údaje o intersticiálnej alebo kapilárnej glukóze</td><td>Technická presnosť, oneskorenie intersticiálnej glukózy, dostupnosť a správne používanie zariadenia</td></tr>
  </tbody>
</table>
</div>

<h2>Fruktozamín nie je glykovaný albumín</h2>

<p>Zdrojový rozhovor tieto pojmy miestami zamieňa. Fruktozamín vyjadruje celkové glykované sérové bielkoviny, medzi ktorými prevažuje albumín. Glykovaný albumín hodnotí osobitne glykáciu albumínu, zvyčajne vo vzťahu k jeho celkovému množstvu. Oba ukazovatele odrážajú kratšie obdobie než HbA1c a nie sú priamo závislé od životnosti erytrocytov, ale nie sú nezávislé od metabolizmu bielkovín.</p>

<p>V prospektívnej štúdii 104 účastníkov s diabetom 2. typu, z ktorých 80 malo eGFR pod 60 ml/min/1,73 m² a nebolo liečených dialýzou, korelovali HbA1c, glykovaný albumín aj fruktozamín s priemernou glukózou z CGM podobne. Glykovaný albumín a fruktozamín navyše ovplyvňovali vek, index telesnej hmotnosti, parametre železa a albuminúria; HbA1c bol pri albuminúrii podhodnotený. Štúdia preto nepodporila jednoduchú náhradu HbA1c jedným z týchto markerov. [4]</p>

<p>Pri významnej proteinúrii, nefrotickom syndróme, hypoalbuminémii alebo stratách bielkovín pri peritoneálnej dialýze teda fruktozamín a glykovaný albumín nie sú automaticky spoľahlivejšie. Praktickým riešením býva porovnanie laboratórneho výsledku s priamym sledovaním glukózy.</p>

<h2>Keď sa HbA1c a glykémie rozchádzajú</h2>

<p>KDIGO odporúča pri nesúlade HbA1c s priamo meranou glukózou alebo klinickými príznakmi použiť kontinuálne monitorovanie glukózy (CGM) a z neho odvodený indikátor manažmentu glukózy (GMI). CGM zároveň zachytáva čas v cieľovom rozmedzí, hypoglykémie a glykemickú variabilitu, ktoré priemerná hodnota HbA1c neukáže. [3]</p>

<p>Konsenzus odborníkov z roku 2025 podporuje širšie využitie CGM pri diabete a CKD, súčasne však upozorňuje na medzery v dôkazoch, prístupe k technológii a hodnotení u dialyzovaných pacientov. Ani senzor nie je neomylný. Ak údaj nezodpovedá príznakom alebo sa glukóza rýchlo mení, treba postupovať podľa pravidiel konkrétneho zariadenia a podľa potreby výsledok overiť glukomerom. [5]</p>

<h2>Skríning: funkcia štítnej žľazy nie je to isté ako protilátky</h2>

<p>ADA 2026 odporúča u ľudí s diabetom 1. typu vyšetriť autoimunitné ochorenie štítnej žľazy krátko po diagnóze a potom opakovane, ak je to klinicky indikované. U detí a dospievajúcich uvádza TSH pri diagnóze v klinicky stabilnom stave a pri normálnom výsledku opakovanie spravidla každé 1 až 2 roky, skôr pri pozitívnych protilátkach, príznakoch, strume, poruche rastu alebo nevysvetlenej glykemickej variabilite. [6]</p>

<p>Treba rozlišovať účel jednotlivých vyšetrení. TSH a podľa situácie voľný tyroxín (fT4) hodnotia funkciu štítnej žľazy. Protilátky proti tyreoperoxidáze (anti-TPO) podporujú určenie autoimunitného pôvodu a odhad rizika budúcej dysfunkcie; ich opakované každoročné stanovovanie po potvrdení pozitivity spravidla neposkytuje rovnakú informáciu ako kontrola TSH. Protilátky proti receptoru TSH pomáhajú pri diagnostike Gravesovej-Basedowovej choroby, nie sú plošným každoročným skríningovým testom.</p>

<p>Pri diabete 2. typu nemožno z podcastu odvodiť povinnosť každoročného kompletného tyreologického panelu. Diagnostické vyšetrenie je primerané pri príznakoch, strume, nevysvetlenej zmene hmotnosti, fibrilácii predsiení alebo nezvyčajnej zmene glykemického profilu. Vyšetrenie symptomatického pacienta nie je skríningom v pravom zmysle slova.</p>

<h2>Mierne zvýšené TSH pri obezite nie je automatickou indikáciou liečby</h2>

<p>Mierna elevácia TSH pri normálnom fT4 môže súvisieť s obezitou, subklinickou hypotyreózou alebo prechodnou zmenou počas zotavovania z iného ochorenia. Zdrojový rozhovor používa v tejto súvislosti výraz „hypertyroxinémia“, ktorý znamená zvýšenú koncentráciu tyroxínu. Pri zvýšenom TSH a normálnom fT4 je presnejšie hovoriť o miernej elevácii TSH alebo hypertyreotropinémii.</p>

<p>Negativita anti-TPO nevylučuje hypotyreózu a pozitivita sama osebe neznamená potrebu levotyroxínu. Rozhoduje pretrvávanie nálezu, fT4, výška TSH, vek, príznaky a osobitné situácie, napríklad gravidita. Levotyroxín nie je liekom na obezitu ani prostriedkom na zlepšenie HbA1c bez preukázanej indikácie.</p>

<h2>Osobitosti pri chronickej chorobe obličiek</h2>

<p>Pacient s pokročilou CKD môže mať únavu, zimomravosť, opuchy či psychomotorické spomalenie aj bez primárneho ochorenia štítnej žľazy. Pri závažnom systémovom ochorení a pokročilej CKD sa navyše menia tyreoidálne parametre. Izolovane nízke T3 preto automaticky neznamená hypotyreózu vyžadujúcu substitúciu. Výsledok sa hodnotí spolu s TSH, fT4, klinickým stavom a liekmi.</p>

<p>Pri nevysvetlene zvýšenom TSH u pacienta užívajúceho levotyroxín treba skontrolovať spôsob podávania a interakcie. Železo, vápnik a niektoré viazače fosfátov môžu znižovať vstrebávanie levotyroxínu. Riešením nemusí byť okamžité zvýšenie dávky, ale overenie adherencie, interakcií a časového odstupu podľa liekových informácií konkrétnych prípravkov.</p>

<h2>Praktický postup pri nevysvetlenej zmene glykémie</h2>

<ol>
  <li>Overiť skutočný priebeh glukózy z glukomera alebo CGM, príznaky a technickú spoľahlivosť merania.</li>
  <li>Skontrolovať liečbu, príjem potravy, interkurentné ochorenie a zmenu funkcie obličiek.</li>
  <li>Podľa kliniky vyšetriť TSH a fT4; protilátky voliť podľa diagnostickej otázky.</li>
  <li>Pri nesúlade HbA1c zhodnotiť krvný obraz, liečbu anémie, transfúzie a obrat bielkovín.</li>
  <li>Po liečbe tyreoidálnej poruchy intenzívnejšie sledovať glukózu a znovu upraviť antidiabetickú liečbu.</li>
</ol>

<p>Ide o klinickú syntézu, nie o validované skóre. Najväčšou chybou by bolo zintenzívniť liečbu iba podľa skresleného HbA1c alebo, naopak, prehliadnuť skutočnú hyperglykémiu či hypoglykémiu s očakávaním, že sa upraví po liečbe štítnej žľazy.</p>

<h2>Klinické posolstvo</h2>

<p>HbA1c zostáva užitočným ukazovateľom dlhodobého trendu, pri CKD a poruche funkcie štítnej žľazy však potrebuje kontext. Ak sa nezhoduje s príznakmi a priamymi meraniami, netreba hľadať univerzálny korekčný vzorec ani automaticky prejsť na fruktozamín. Bezpečnejšie je určiť príčinu nesúladu a oprieť rozhodnutie o priame údaje o glukóze.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Kaniksha Desai, Shashank Joshi. Common in Clinical Practice: Thyroid Disease and Diabetes. <em>Thyroid Stimulating Podcast, Medscape v spolupráci s American Thyroid Association.</em> 2. októbra 2026. <a href="https://www.medscape.com/viewarticle/1003512" target="_blank" rel="noopener noreferrer">Prepis odborného rozhovoru</a>.</em></small></p>
<p><small><em>[2] Bernadette Biondi, George J. Kahaly, R. Paul Robertson. Thyroid Dysfunction and Diabetes Mellitus: Two Closely Associated Disorders. <em>Endocrine Reviews.</em> 2019;40(3):789–824. DOI: <a href="https://doi.org/10.1210/er.2018-00163" target="_blank" rel="noopener noreferrer">10.1210/er.2018-00163</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/30649221/" target="_blank" rel="noopener noreferrer">PubMed PMID 30649221</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6507635/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>
<p><small><em>[3] Kidney Disease: Improving Global Outcomes Diabetes Work Group. KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease. <em>Kidney International.</em> 2022;102(Suppl 5S):S1–S127. DOI: <a href="https://doi.org/10.1016/j.kint.2022.06.008" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2022.06.008</a>. <a href="https://kdigo.org/wp-content/uploads/2022/10/KDIGO-2022-Clinical-Practice-Guideline-for-Diabetes-Management-in-CKD.pdf" target="_blank" rel="noopener noreferrer">Oficiálne odporúčanie KDIGO</a>.</em></small></p>
<p><small><em>[4] Leila R. Zelnick, Zona O. Batacchi, Iram Ahmad, Ashveena Dighe, Randie R. Little, Dace L. Trence, Irl B. Hirsch, Ian H. de Boer. Continuous Glucose Monitoring and Use of Alternative Markers To Assess Glycemia in Chronic Kidney Disease. <em>Diabetes Care.</em> 2020;43(10):2379–2387. DOI: <a href="https://doi.org/10.2337/dc20-0915" target="_blank" rel="noopener noreferrer">10.2337/dc20-0915</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32788282/" target="_blank" rel="noopener noreferrer">PubMed PMID 32788282</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC7510019/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>
<p><small><em>[5] Connie M. Rhee, Roma Y. Gianchandani, David Kerr, Athena Philis-Tsimikas, Csaba P. Kovesdy, Robert C. Stanton, Andjela T. Drincic, Rodolfo J. Galindo, Kamyar Kalantar-Zadeh, Joshua J. Neumiller, Ian H. de Boer, Marcus Lind, Sun H. Kim, Alessandra T. Ayers, Cindy N. Ho, Rachel E. Aaron, Tiffany Tian, David C. Klonoff. Consensus Report on the Use of Continuous Glucose Monitoring in Chronic Kidney Disease and Diabetes. <em>Journal of Diabetes Science and Technology.</em> 2025;19(1):217–245. DOI: <a href="https://doi.org/10.1177/19322968241292041" target="_blank" rel="noopener noreferrer">10.1177/19322968241292041</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39611379/" target="_blank" rel="noopener noreferrer">PubMed PMID 39611379</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11607725/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</em></small></p>
<p><small><em>[6] American Diabetes Association Professional Practice Committee for Diabetes. Comprehensive Medical Evaluation and Assessment of Comorbidities: Standards of Care in Diabetes—2026. <em>Diabetes Care.</em> 2026;49(Suppl 1):S61–S88. DOI: <a href="https://doi.org/10.2337/dc26-S004" target="_blank" rel="noopener noreferrer">10.2337/dc26-S004</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41358897/" target="_blank" rel="noopener noreferrer">PubMed PMID 41358897</a>. Súvisiace pediatrické odporúčania: <a href="https://diabetesjournals.org/care/article/49/Supplement_1/S297/163923/14-Children-and-Adolescents-Standards-of-Care-in" target="_blank" rel="noopener noreferrer">Children and Adolescents: Standards of Care in Diabetes—2026</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_stitna-zlaza-diabetes-oblicky-hba1c-glykemia_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
?>
