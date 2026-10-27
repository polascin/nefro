<?php

/** Publikačný skript odborného článku. Avíza sa zámerne neposielajú. */
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
    'title' => 'Odporúčania ISH 2026 pre hypertenziu pri chronickej chorobe obličiek',
    'slug' => 'ish-2026-hypertenzia-chronicka-choroba-obliciek',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Odporúčania ISH z 20. októbra 2026 viažu pri chronickej chorobe obličiek rozhodovanie na štandardizované meranie a tlak mimo ambulancie. Optimálny cieľ je pod 130/80 mmHg a návrh KDIGO pod 120 mmHg nepreberajú.',
    'content' => <<<'HTML'
<figure>
  <a href="img/ish-2026-hypertenzia-chronicka-choroba-obliciek.webp" rel="noopener noreferrer" target="_blank">
    <picture>
      <source srcset="img/ish-2026-hypertenzia-chronicka-choroba-obliciek.webp" type="image/webp">
      <img src="img/ish-2026-hypertenzia-chronicka-choroba-obliciek.png" alt="Priesvitná oblička v tme a manžeta na predlaktí, cez obličku prechádza nočná vlna tlaku" width="1600" height="1000" loading="lazy" decoding="async">
    </picture>
  </a>
  <figcaption>Ilustračná poloschematická scéna, nie snímka pacienta ani tlakomera. Nočný tlak pri chorobe obličiek nie je vidieť z jedného merania v ambulancii.</figcaption>
</figure>

<p>Medzinárodná spoločnosť pre hypertenziu (International Society of Hypertension, ISH) zverejnila 20. októbra 2026 globálne odporúčania pre prax. Pre pacienta s chronickou chorobou obličiek (CKD) z nich nevyplýva nový príkaz tlačiť systolický tlak pod 120 mmHg. Vyplýva z nich iná požiadavka. Diagnóza aj úprava liečby majú stáť na štandardizovanom meraní. Nízka odhadovaná glomerulová filtrácia (eGFR) je v texte spojená s rezistentnou, maskovanou a nočnou hypertenziou, a preto dokument vyžaduje meranie mimo ambulancie. Optimálny cieľ je pod 130/80 mmHg, a to pre štandardizované meranie v ambulancii, pre štandardizované domáce meranie aj pre denné hodnoty 24-hodinového monitorovania.</p>

<p>Tento optimálny cieľ nie je návrh KDIGO z roku 2021. Ten pri štandardizovanom meraní v ambulancii mieri na systolický tlak pod 120 mmHg. Hodnota pod 120 mmHg cieľ ISH spĺňa. Nie je však tým, čo ISH žiada dosiahnuť. Pri potvrdenej hypertenzii ostáva pre základnú starostlivosť cieľ pod 140/90 mmHg. Rozdiel treba poznať skôr, ako sa pridá ďalší liek.</p>

<h2>Čo dokument pokrýva</h2>

<p>Trinásť autorov text pripravilo a dvadsaťštyri recenzentov ho posúdilo. ISH pri oznámení uvádza, že spolu zastupujú 23 krajín na piatich kontinentoch. Zachováva sa rozlíšenie z roku 2020. Základná starostlivosť má byť dostupná každému. Optimálna starostlivosť sa pridáva tam, kde to podmienky dovoľujú. Dokument sám hovorí, že nie je monografiou pre špecialistu na zložité formy hypertenzie. Pokrýva skríning, diagnózu, prahy na začatie liečby, režimové opatrenia, farmakoterapiu, cieľové hodnoty a organizáciu starostlivosti, a tiež ťažko upraviteľnú a rezistentnú hypertenziu, pátranie po sekundárnej príčine a to, kedy treba urgentné alebo špecializované odoslanie.</p>

<p>Náhodné meranie, v ambulancii aj doma, je pre diagnózu a vedenie liečby nevhodné. V optimálnej starostlivosti je hlavnou metódou diagnózy a ďalšieho sledovania štandardizované domáce meranie. 24-hodinové ambulantné monitorovanie ostáva dôležité pri konkrétnych indikáciách, ak je dostupné.</p>

<h2>Diagnóza stojí na štandardizovanom meraní</h2>

<p>Hypertenzia sa potvrdí, keď je tlak v ambulancii najmenej 140/90 mmHg, systolický, diastolický alebo oba, aspoň na dvoch návštevách, s tromi meraniami pri každej návšteve, overeným tlakomerom s manžetou na rameno a podľa štandardizovaného postupu. Ak je to možné, zvýšenie sa potvrdí mimo ambulancie, štandardizovaným domácim meraním alebo 24-hodinovým monitorovaním. Náhradou sú opakované merania v ambulancii pri ďalších návštevách.</p>

<p>Kategórie v tabuľke patria štandardizovanému meraniu v ambulancii. Obrázok 1 v odporúčaniach uvádza prahy aj pre domáce a 24-hodinové meranie. V dostupnom zobrazení sa tieto prahy nedali spoľahlivo prečítať ako čísla, preto ich neuvádzam. Cieľ liečby pod 130/80 mmHg pre tri metódy nie je to isté ako diagnostický prah domáceho alebo 24-hodinového merania.</p>

<div class="table-responsive" role="region" aria-label="Kategórie krvného tlaku podľa štandardizovaného merania v ambulancii, ISH 2026" tabindex="0">
<table>
<thead>
<tr>
<th scope="col">Kategória</th>
<th scope="col">Systolický tlak</th>
<th scope="col">Vzťah</th>
<th scope="col">Diastolický tlak</th>
</tr>
</thead>
<tbody>
<tr>
<th scope="row">Normálny tlak</th>
<td>pod 130 mmHg</td>
<td>a súčasne</td>
<td>pod 80 mmHg</td>
</tr>
<tr>
<th scope="row">Zvýšený tlak</th>
<td>od 130 do 139 mmHg</td>
<td>a/alebo</td>
<td>od 80 do 89 mmHg</td>
</tr>
<tr>
<th scope="row">Hypertenzia 1. stupňa</th>
<td>od 140 do 159 mmHg</td>
<td>a/alebo</td>
<td>od 90 do 99 mmHg</td>
</tr>
<tr>
<th scope="row">Hypertenzia 2. stupňa</th>
<td>najmenej 160 mmHg</td>
<td>a/alebo</td>
<td>najmenej 100 mmHg</td>
</tr>
</tbody>
</table>
</div>

<p>ISH pri oznámení uvádza, že pojem zvýšený tlak nahrádza vysoký normálny tlak a že doň patrí aj diastolický pás od 80 do 84 mmHg. Má upozorniť, že ide o abnormálny tlak, ktorý si zaslúži rozhodnutie, nie o rezervu bez významu.</p>

<p>Merania mimo ambulancie sú opakovateľnejšie než merania v ambulancii, tesnejšie súvisia s poškodením orgánov spôsobeným hypertenziou aj s kardiovaskulárnym rizikom a odlíšia hypertenziu bieleho plášťa od maskovanej hypertenzie. Vo väčšine prípadov sú potrebné na presnú diagnózu, na rozpoznanie týchto dvoch obrazov, na každé rozhodnutie o liečbe a na dlhodobé sledovanie. Osobitne pri neliečenom aj liečenom pacientovi so štandardizovaným tlakom v ambulancii od 130 do 159 mmHg systolicky a/alebo od 80 do 99 mmHg diastolicky, teda pri zvýšenom tlaku alebo hypertenzii 1. stupňa, sa má diagnóza potvrdiť domácim meraním alebo 24-hodinovým monitorovaním.</p>

<p>Pri vstupnom vyšetrení sa tlak meria na oboch pažiach. Ak opakované merania ukazujú stály rozdiel systolického tlaku medzi pažami väčší ako 10 mmHg, ďalej sa používa paža s vyššou hodnotou. Pri rozdiele väčšom ako 20 mmHg sa má zvážiť ďalšie vyšetrenie. Meranie v stoji nie je potrebné u každého ani pri každej návšteve. Patrí pacientom liečeným pre hypertenziu, ktorí majú príznaky svedčiace pre ortostatickú hypotenziu, najmä ak majú viac ako 65 rokov, diabetes alebo neurodegeneratívne ochorenie. Ortostatická hypotenzia je pokles systolického tlaku najmenej o 20 mmHg a/alebo diastolického najmenej o 10 mmHg do troch minút po postavení. Chronickú chorobu obličiek text medzi dôvodmi merania v stoji neuvádza.</p>

<h2>Kedy začať liečbu a aký cieľ sledovať</h2>

<p>U ľudí s nízkym rizikom a so štandardizovaným tlakom v ambulancii pod 160/100 mmHg sa pred liekom odporúčajú tri mesiace režimových opatrení. Pri hypertenzii, teda od 140/90 mmHg, sa u väčšiny pacientov začína fixnou dvojkombináciou v jednej tablete. Cieľ základnej starostlivosti je pod 140/90 mmHg. Cieľ optimálnej starostlivosti je pod 130/80 mmHg.</p>

<p>Pri potvrdenom zvýšenom tlaku, od 130 do 139 a/alebo od 80 do 89 mmHg, sa liek v optimálnej starostlivosti odporúča u väčšiny ľudí. Začína sa zvyčajne monoterapiou. Nízkodávková fixná dvojkombinácia prichádza do úvahy pri vysokom riziku a pri systolickom tlaku blízko 140 mmHg. Cieľ je opäť pod 130/80 mmHg. Toto začatie liečby už v pásme zvýšeného tlaku je odporúčanie optimálnej starostlivosti, nie základnej.</p>

<p>Ten istý číselný cieľ, pod 130/80 mmHg, platí pre štandardizované meranie v ambulancii, pre štandardizované domáce meranie a pre denné hodnoty 24-hodinového monitorovania. Domáce meranie alebo 24-hodinové monitorovanie má tlak potvrdiť najmä vtedy, keď sa lieči zvýšený tlak a keď sa mieri pod 130/80 mmHg v ambulancii.</p>

<p>Začiatok liečby aj cieľ sa individualizujú, osobitne u ľudí starších ako 85 rokov a u mladších s krehkosťou, s príznakmi ortostatickej hypotenzie alebo s obmedzenou dĺžkou života. Začať liečbu už od 130/80 mmHg a smerovať pod 130/80 mmHg nie je vhodné u každého. Oproti odporúčaniam z roku 2020, ktoré mali optimálny cieľ pod 130/80 mmHg u ľudí mladších ako 65 rokov a pod 140/90 mmHg od 65 rokov, ISH teraz v optimálnej starostlivosti vzťahuje cieľ pod 130/80 mmHg širšie, vrátane mnohých starších dospelých. Individualizácia podľa krehkosti, znášanlivosti liečby a ostatných klinických okolností ostáva.</p>

<p>Nedodržiavanie antihypertenzívnej liečby dokument zaraďuje medzi časté ovplyvniteľné kardiovaskulárne rizikové činitele. Medzi novými možnosťami optimálnej starostlivosti sú inhibítory aldosterónsyntázy, antagonisti endotelínových receptorov a nesteroidní antagonisti mineralokortikoidových receptorov. Renálnu denerváciu možno podľa textu zvážiť vo vybraných prípadoch v odborných centrách. Pri chorobe obličiek z týchto novších liekov text menovite rozvádza finerenón, nie dávkovanie inhibítora aldosterónsyntázy.</p>

<h2>Čo z toho platí pri chorobe obličiek</h2>

<p>Vysoký tlak je v odporúčaniach významný rizikový činiteľ vzniku a progresie albuminúrie aj chronickej choroby obličiek. Zníženie tlaku má podľa ich znenia priaznivý účinok na albuminúriu a na funkciu obličiek. Táto veta je všeobecné konštatovanie dokumentu, nie nový číselný výsledok štúdie.</p>

<p>Nízka eGFR je spojená s rezistentnou, maskovanou a nočnou hypertenziou. Práve preto text vyžaduje meranie mimo ambulancie. Nočný tlak denné domáce meranie nevidí. Ak je otázkou noc, zachytí ho 24-hodinové monitorovanie. Trojmesačný odklad lieku dokument vyhradzuje ľuďom s nízkym kardiovaskulárnym rizikom. Obraz viazaný na nízku eGFR takým rizikom nie je. Výslovne však v odseku o CKD nepíše, že sa pri tlaku od 130 do 139 mmHg liek začína v ten istý deň. Rozhodnutie ostáva na potvrdení mimo ambulancie a na znášanlivosti.</p>

<p>Väčšina pacientov s CKD potrebuje kombinovanú antihypertenzívnu liečbu. Blokátor systému renín-angiotenzín, teda ACE inhibítor alebo sartan, má byť jej súčasťou, najmä pri albuminúrii. Text neopisuje kombináciu dvoch takýchto liekov. Retencia sodíka a vody je pri klesajúcej funkcii obličiek významný mechanizmus hypertenzie a diuretiká sú potrebné vo väčšine prípadov. Pri eGFR pod 30 ml/min/1,73 m² sa pred tiazidmi uprednostňujú kľučkové diuretiká a chlortalidón.</p>

<p>Inhibítory SGLT2 sa odporúčajú pri eGFR nad 20 ml/min/1,73 m² a text súčasne hovorí, že pokles systolického tlaku je malý. Agonistu receptorov GLP-1 možno k liečbe pridať. Finerenón, nesteroidný antagonista mineralokortikoidových receptorov, sa má pridať pri diabete a možno ho zvážiť aj bez diabetu, v oboch prípadoch pri normálnej koncentrácii draslíka a pri pomere albumínu a kreatinínu v moči najmenej 30 mg/g, čo je približne 3,4 mg/mmol. Číselnú hranicu draslíka dokument v tejto vete neuvádza.</p>

<h2>Prečo to nie je to isté čo KDIGO 2021</h2>

<p>KDIGO v odporúčaní z roku 2021 navrhuje, aby sa dospelý s vysokým tlakom a s CKD liečil na systolický tlak pod 120 mmHg, meraný štandardizovane v ambulancii, ak sa to znáša. Sila odporúčania je 2B. Neplatí pre pacienta po transplantácii obličky ani pre pacienta liečeného dialýzou. Zdôvodnenie sa opiera najmä o kardiovaskulárny prínos, prínos pre prežívanie a o možný prínos pre kogníciu v štúdii SPRINT. Cieľ pod 120 mmHg je viazaný na štandardizované meranie. Pri bežnom meraní v ambulancii KDIGO varuje pred príliš intenzívnou liečbou.</p>

<p>ISH v dostupnom znení prah pod 120 mmHg nepreberá. Optimálny cieľ ostáva pod 130/80 mmHg pre tri uvedené metódy a odsek o CKD ho nenahrádza iným číslom. Spoločná podmienka oboch dokumentov je štandardizované meranie. Bez neho nie je ani jeden cieľ použiteľný.</p>

<p>KDIGO kombináciu ACE inhibítora, sartanu a priameho inhibítora renínu odmieta, so silou 1B. V pasážach ISH 2026, ktoré boli dostupné, taká veta nie je. Je v nich požiadavka zaradiť jeden blokátor systému renín-angiotenzín, najmä pri albuminúrii.</p>

<p>Pre dialýzu a pre transplantáciu obličky dostupné pasáže ISH o CKD samostatný číselný cieľ neuvádzajú. Preniesť na ne prah pod 130/80 mmHg alebo prah KDIGO pod 120 mmHg by bolo doplnenie, ktoré text nedáva.</p>

<h2>Limity</h2>

<p>Plný text v Journal of Hypertension je uzavretý. Tvrdenia v tomto článku stoja na pasážach, ktoré stránka časopisu zobrazuje, a na oznámení ISH z 26. októbra 2026. Ročník, číslo a strany v Crossref, PubMed ani OpenAlex 28. októbra 2026 pridelené neboli. Diagnostické prahy domáceho a 24-hodinového merania z obrázka 1 sa nepodarilo prečítať ako čísla, preto nie sú v tabuľke. Nie je overené, či inde v plnom texte nie je pre dialýzu alebo transplantáciu samostatný cieľ, ktorý otvorená vrstva neukázala.</p>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie ani platné odporúčania.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>George S. Stergiou, Kazuomi Kario, Dagnovar Aristizabal, Hind Beheiry, Myeong-Chan Cho, Débora Simões Almeida Colombari, Hiroshi Itoh, Tazeen H. Jafar, Erika Jones, Yan Li, Cesar A. Romero, U. Muscha Steckelings, Bryan Williams. 2026 International Society of Hypertension Global Hypertension Practice Guidelines. <em>Journal of Hypertension.</em> Online 20. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. DOI: <a href="https://doi.org/10.1097/HJH.0000000000004451" target="_blank" rel="noopener noreferrer">10.1097/HJH.0000000000004451</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42909506/" target="_blank" rel="noopener noreferrer">PubMed PMID 42909506</a>.</small></li>
  <li><small>Alfred K. Cheung, Tara I. Chang, William C. Cushman, Susan L. Furth, Fan Fan Hou, Joachim H. Ix, Gregory A. Knoll, Paul Muntner, Roberto Pecoits-Filho, Mark J. Sarnak, Sheldon W. Tobe, Charles R.V. Tomson, Johannes F.E. Mann. KDIGO 2021 Clinical Practice Guideline for the Management of Blood Pressure in Chronic Kidney Disease. <em>Kidney International.</em> 2021;99(3):S1 až S87. DOI: <a href="https://doi.org/10.1016/j.kint.2020.11.003" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2020.11.003</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33637192/" target="_blank" rel="noopener noreferrer">PubMed PMID 33637192</a>.</small></li>
  <li><small>International Society of Hypertension. ISH publishes new global hypertension practice guidelines. 26. októbra 2026. <a href="https://ish-world.com/latest-news-and-updates/ish-publishes-new-global-hypertension-practice-guidelines" target="_blank" rel="noopener noreferrer">ish-world.com</a>. Oznámenie spoločnosti, nie samostatná recenzovaná publikácia.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Bibliografických autorov ISH je 13. Mená, poradie, DOI a dátum online publikovania 20. októbra 2026 sú z Crossref. PubMed (PMID 42909506) k nim pripojil 24 recenzentov, ktorých abstrakt označuje ako recenzentov, nie ako autorov. Úplné krstné mená sú z Crossref. Ročník a strany pridelené neboli. Plný text je uzavretý. Klinické vety o definícii, meraní, cieľoch, základnej a optimálnej starostlivosti a o CKD sú z pasáží zobrazených na stránke časopisu pri DOI 10.1097/HJH.0000000000004451. Vety o tom, že štandardizované domáce meranie je v optimálnej starostlivosti hlavná metóda, že náhodné meranie sa odmieta a že cieľ pod 130/80 mmHg sa rozširuje aj na mnohých starších ľudí, sú z oznámenia ISH z 26. októbra 2026 a sú tak použité. Znenie a stupeň 2B odporúčania KDIGO o systolickom tlaku pod 120 mmHg, jeho výluka pre dialýzu a transplantáciu a zákaz kombinácie ACE inhibítora, sartanu a priameho inhibítora renínu sú z oficiálneho súhrnu KDIGO k týmto odporúčaniam. Plný suplement Kidney International sa v tomto kole nečítal stranu po strane. Predloha bola pacientsky ladený výklad. Obsahovala kalk „ordinálne meranie“, nepresný opis domáceho a 24-hodinového merania ako rovnocennej dvojice, chýbali v nej diuretiká, inhibítory SGLT2 a finerenón, cieľ ISH zlievala s nižším cieľom a na záver mala neoverenú odbočku o liečbe sekundárnej hyperparatyreózy, ktorá s týmito odporúčaniami nesúvisí. Do článku neprešla. Autor projektu doplnil rozlíšenie základnej a optimálnej starostlivosti, vzťah k KDIGO a hranicu toho, čo otvorený text o dialýze a transplantácii nehovorí.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=nove-odporucania-hypertenzia-meranie-rozhodnutia">Nové odporúčania pre hypertenziu: menej improvizácie, viac presného merania a praktických rozhodnutí</a></li>
  <li><a href="article.php?slug=diurnalna-exkrecia-sodika-nocna-hypertenzia-casovanie-soli">Diurnálna exkrécia sodíka a nočná hypertenzia: načasovanie soli ako klinický problém</a></li>
  <li><a href="article.php?slug=nekontrolovana-rezistentna-hypertenzia-aldosteronova-os">Nekontrolovaná a rezistentná hypertenzia: diagnostika, aldosterónová os a nové liečebné možnosti</a></li>
  <li><a href="article.php?slug=baxdrostat-rezistentna-hypertenzia-bax24">Baxdrostat výrazne znižuje 24-hodinový krvný tlak pri rezistentnej hypertenzii: výsledky štúdie Bax24</a></li>
  <li><a href="article.php?slug=renalna-denervacia-rezistentna-hypertenzia">Renálna denervácia pri rezistentnej hypertenzii: nádejná metóda, ale nie skratka v liečbe</a></li>
  <li><a href="article.php?slug=finerenon-hypertenzna-nefropatia-bez-diabetu-find-ckd">Finerenón pri hypertenznej nefropatii bez diabetu: čo prináša analýza FIND-CKD?</a></li>
  <li><a href="article.php?slug=finerenon-empagliflozin-confidence-albuminuria-krvny-tlak">Finerenón s empagliflozínom pri CKD a diabete 2. typu: vysvetľuje pokles albuminúrie krvný tlak?</a></li>
  <li><a href="article.php?slug=kombinacna-liecba-ckd-styri-piliere-hranice-dokazov">Kombinovaná liečba chronickej choroby obličiek: štyri piliere, dôkazy a otvorené otázky</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_ish-2026-hypertenzia-chronicka-choroba-obliciek_article',
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
