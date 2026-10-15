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
    'title' => 'IgG4-súvisiace renálne ochorenie: diagnostika, liečba a dlhodobé sledovanie',
    'slug' => 'igg4-suvisiace-renalne-ochorenie-liecebny-standard',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Liečebný štandard ERA pre IgG4-súvisiace renálne ochorenie. Žiadny jediný biomarker nestačí, glukokortikoidy zostávajú základom indukcie a cielenie na B bunky má po štúdii MITIGATE prvý dôkaz fázy 3.',
    'content' => <<<'HTML'
<figure>
  <picture>
    <source srcset="img/igg4-suvisiace-renalne-ochorenie-liecebny-standard.webp" type="image/webp">
    <img src="img/igg4-suvisiace-renalne-ochorenie-liecebny-standard.png" alt="Poloschematická oblička so zápalovými ložiskami v parenchýme, močovod zovretý prstencom retroperitoneálnej fibrózy a vpravo ubúdajúce B bunky" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta. Dve tváre toho istého ochorenia: zápalové postihnutie parenchýmu a obštrukcia močovodu pri retroperitoneálnej fibróze.</figcaption>
</figure>

<p>IgG4-súvisiace ochorenie je systémová, imunitne sprostredkovaná fibrózno-zápalová jednotka, ktorá môže postihnúť prakticky ktorýkoľvek orgán. Renálne postihnutie patrí k jej klinicky najvýznamnejším prejavom a v októbri 2026 preň vyšiel v časopise <em>Nephrology Dialysis Transplantation</em> liečebný štandard písaný z nefrologickej perspektívy.</p>

<p>Praktická hodnota tohto dokumentu nespočíva v novej molekule. Spočíva v rozlíšení, ktoré sa v bežnej praxi stráca: hoci sa systémová imunosupresívna liečba naprieč prejavmi do veľkej miery prekrýva, <strong>manažment postihnutia parenchýmu a manažment retroperitoneálnej fibrózy sa podstatne líšia</strong> – mechanizmom poškodenia obličiek, potrebou intervenčných výkonov, liečebnými cieľmi aj spôsobom sledovania.</p>

<h2>Spektrum renálnych prejavov</h2>

<div class="table-responsive" role="region" aria-label="Hlavné renálne prejavy IgG4-súvisiaceho ochorenia" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Prejav</th><th scope="col">Mechanizmus poškodenia</th><th scope="col">Terapeutické ťažisko</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">IgG4-súvisiaca tubulointersticiálna nefritída</th><td>Zápalová infiltrácia a fibróza interstícia</td><td>Systémová imunosupresia</td></tr>
    <tr><th scope="row">Membranózna nefropatia</th><td>Glomerulárne subepitelové depozity</td><td>Systémová imunosupresia</td></tr>
    <tr><th scope="row">Obštrukčná uropatia pri retroperitoneálnej fibróze</th><td>Mechanická obštrukcia močovodu</td><td>Imunosupresia <em>a</em> intervenčné riešenie obštrukcie</td></tr>
  </tbody>
</table>
</div>

<p>Posledný riadok je klinicky najdôležitejší. Pri obštrukčnej uropatii samotná imunosupresia nestačí – pokiaľ nie je obnovená priechodnosť močových ciest, funkcia obličiek sa nezlepší bez ohľadu na to, ako dobre sa zápal potlačí. Nefrológ preto musí manažment koordinovať s urológiou a zobrazovacími disciplínami, nielen titrovať lieky.</p>

<h2>Diagnostika: žiadny jediný biomarker nestačí</h2>

<p>Diagnóza zostáva náročná, pretože <strong>žiadny samostatný biomarker nie je dostatočne citlivý ani špecifický</strong>. Potrebná je integrácia klinických a laboratórnych nálezov, zobrazovania a histopatológie.</p>

<p>Sérová koncentrácia IgG4 je v tomto smere typickou pascou. Môže byť zvýšená pri infekciách, alergických ochoreniach, vaskulitídach aj malignitách, a naopak normálna hodnota IgG4-súvisiace ochorenie nevylučuje. Ilustratívne čísla poskytuje otvorená štúdia s rituximabom: zo štrnástich pacientov s východiskovo zvýšeným IgG4 dosiahlo po šiestich mesiacoch normálne hodnoty iba 8 z 19 (42 %), hoci klinická odpoveď nastala u 97 % účastníkov. Sérový IgG4 teda nie je spoľahlivým ukazovateľom aktivity ani odpovede na liečbu.</p>

<p>Pre zaradenie pacientov existujú klasifikačné kritériá ACR/EULAR z roku 2019 a pre renálne postihnutie samostatné japonské diagnostické kritériá. Treba však rozlišovať: <strong>klasifikačné kritériá slúžia na výber homogénnej populácie do štúdií, nie na stanovenie diagnózy u konkrétneho pacienta.</strong> Kritériá ACR/EULAR obsahujú vylučovacie položky, ktorých zmyslom je odlíšiť napodobeniny – malignitu, ANCA-asociovanú vaskulitídu, infekciu.</p>

<p>Z nefrologického pohľadu treba pri diagnostickej rozvahe odpovedať na tri otázky:</p>

<ol>
  <li>Ide skutočne o IgG4-súvisiace ochorenie, alebo o napodobeninu?</li>
  <li>Dominuje postihnutie parenchýmu, alebo obštrukcia pri retroperitoneálnej fibróze?</li>
  <li>Aká je pravdepodobnosť reverzibility renálnej dysfunkcie?</li>
</ol>

<p>Tretia otázka rozhoduje o intenzite liečby. Prevažne fibrotické, zjazvené postihnutie na imunosupresiu neodpovie a agresívna liečba prinesie len toxicitu.</p>

<h2>Indukčná liečba</h2>

<h3>Glukokortikoidy</h3>

<p>Glukokortikoidy sú základom indukčnej liečby a spravidla vedú k rýchlej klinickej odpovedi. Problém nastáva potom. Ochorenie má chronicky relabujúci priebeh a kumulatívna expozícia glukokortikoidom prináša vlastnú záťaž – diabetes, osteoporózu, infekcie, katarakty. Práve to je dôvod, prečo sa hľadajú stratégie šetriace steroidy.</p>

<h3>Konvenčné imunosupresíva</h3>

<p>Konvenčné imunosupresíva sa používajú, ale <strong>s kontroverznými výsledkami</strong>. Liečebný štandard ich nestavia na úroveň B-bunkovej liečby. V praxi to znamená individualizáciu podľa profilu pacienta, typu renálneho postihnutia a dostupnosti.</p>

<h3>Cielenie na B bunky</h3>

<p>Najkonzistentnejšie účinnou možnosťou sú terapie cielené na B bunky, predovšetkým rituximab, a to v indukcii aj v udržiavacej liečbe.</p>

<p>Dôkazová základňa pre rituximab pritom dlho stála na otvorenej pilotnej štúdii s 30 pacientmi: odpoveď nastala u 97 %, primárny ukazovateľ v šiestom mesiaci dosiahlo 23 účastníkov (77 %), úplnú remisiu malo v šiestom mesiaci 14 pacientov (47 %) a v dvanástom mesiaci ju udržalo 12 (40 %). Ide o presvedčivé čísla, ale bez kontrolnej skupiny.</p>

<p>Zásadná zmena nastala v roku 2025. Randomizovaná, dvojito zaslepená, placebom kontrolovaná štúdia fázy 3 <strong>MITIGATE</strong> hodnotila inebilizumab – protilátku, ktorá cieli a deplécuje CD19-pozitívne B bunky – u 135 dospelých s aktívnym IgG4-súvisiacim ochorením počas 52 týždňov. Obe skupiny dostávali rovnaké znižovanie dávky glukokortikoidov; súbežné imunosupresíva neboli povolené.</p>

<div class="table-responsive" role="region" aria-label="Hlavné výsledky štúdie MITIGATE" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Ukazovateľ</th><th scope="col">Inebilizumab (n = 68)</th><th scope="col">Placebo (n = 67)</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Aspoň jedno vzplanutie</th><td>7 (10 %)</td><td>40 (60 %)</td></tr>
    <tr><th scope="row">Pomer hazardov vzplanutia</th><td colspan="2">HR 0,13; 95 % IS 0,06 – 0,28; p &lt; 0,001</td></tr>
    <tr><th scope="row">Ročná miera vzplanutí</th><td colspan="2">pomer mier 0,14; 95 % IS 0,06 – 0,31; p &lt; 0,001</td></tr>
    <tr><th scope="row">Úplná remisia bez vzplanutia a bez liečby</th><td colspan="2">OR 4,68; 95 % IS 2,21 – 9,91; p &lt; 0,001</td></tr>
    <tr><th scope="row">Závažné nežiaduce udalosti</th><td>12 (18 %)</td><td>6 (9 %)</td></tr>
  </tbody>
</table>
</div>

<p>Účinok je výrazný. Zároveň platí, že závažné nežiaduce udalosti boli pri inebilizumabe dvakrát častejšie a že štúdia nebola špecificky zameraná na renálne postihnutie – zaraďovali sa pacienti s aktívnym systémovým ochorením bez ohľadu na postihnutý orgán.</p>

<h2>Dlhodobé sledovanie</h2>

<p>Dlhodobé sledovanie je nevyhnutné z dvoch dôvodov: ochorenie relabuje a pretrvávajúca aktivita vedie k chronickému ochoreniu obličiek. Prakticky treba priebežne hodnotiť klinickú odpoveď, dynamiku renálnych parametrov, známky relapsu a potrebu úpravy udržiavacej stratégie. Pri retroperitoneálnej fibróze patrí k sledovaniu aj pravidelné zobrazenie močových ciest, pretože obštrukcia sa môže vrátiť nezávisle od systémovej aktivity.</p>

<p>Osobitnú pozornosť si zaslúži bezpečnosť dlhodobej deplécie B buniek: hypogamaglobulinémia, riziko infekcií a znížená odpoveď na očkovanie. Očkovací plán je vhodné doplniť pred začatím liečby, nie po ňom.</p>

<h2>Praktické zhrnutie</h2>

<ol>
  <li><strong>Diagnózu stavať na integrácii</strong> kliniky, laboratória, zobrazovania a histopatológie. Samotný sérový IgG4 nestačí ani na potvrdenie, ani na vylúčenie.</li>
  <li><strong>Vždy vylúčiť napodobeniny</strong> – malignitu, ANCA-asociovanú vaskulitídu, infekciu – skôr než sa začne imunosupresia.</li>
  <li><strong>Určiť vzorec postihnutia.</strong> Parenchýmové verzus obštrukčné rozhoduje o tom, či je potrebný urologický výkon.</li>
  <li><strong>Odhadnúť reverzibilitu.</strong> Pri prevažne fibrotickom, zjazvenom náleze je prínos imunosupresie nízky a toxicita istá.</li>
  <li><strong>Glukokortikoidy použiť na indukciu</strong>, ale od začiatku plánovať stratégiu šetriacu steroidy.</li>
  <li><strong>Pri relabujúcom priebehu zvážiť cielenie na B bunky.</strong> Rituximab má dlhšiu klinickú skúsenosť, inebilizumab prvý dôkaz fázy 3.</li>
  <li><strong>Sledovať dlhodobo</strong> – vrátane zobrazenia močových ciest pri retroperitoneálnej fibróze a imunologickej bezpečnosti pri dlhodobej deplécii B buniek.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li><strong>Liečebný štandard nie je odporúčanie s formálnym hodnotením sily dôkazov.</strong> Ide o prehľadový rámec, ktorý integruje dostupné dôkazy a klinickú skúsenosť.</li>
  <li><strong>Randomizované dáta pre renálne postihnutie chýbajú.</strong> MITIGATE hodnotila systémové ochorenie; samostatná randomizovaná štúdia pre IgG4-súvisiacu tubulointersticiálnu nefritídu neexistuje.</li>
  <li><strong>Dôkazy pre rituximab sú z nekontrolovanej štúdie</strong> s 30 pacientmi bez kontrolnej skupiny a bez zaslepenia.</li>
  <li><strong>Inebilizumab nemusí byť dostupný.</strong> Schvaľovací a úhradový status sa medzi krajinami líši.</li>
  <li><strong>Ochorenie je zriedkavé.</strong> Veľké prospektívne súbory neexistujú; optimálna dĺžka udržiavacej liečby nie je stanovená.</li>
  <li><strong>Neexistuje validovaný ukazovateľ aktivity špecifický pre obličky.</strong> Index IgG4-RD Responder Index je nástrojom pre systémové ochorenie.</li>
</ul>

<hr>

<p><small><em>Text je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodnutie, platné odporúčania ani súhrn charakteristických vlastností lieku. Použitie uvedených liekov pri IgG4-súvisiacom renálnom ochorení môže byť v danej krajine mimo schválenej indikácie.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li><small>Peyronel F, Palazzini G, Campi R, Granata S, Masieri L, Vaglio A. IgG4-related kidney disease: treatment standard. <em>Nephrol Dial Transplant.</em> 2026 Oct 9:gfag235 (online pred tlačou). DOI: <a href="https://doi.org/10.1093/ndt/gfag235" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfag235</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42852734/" target="_blank" rel="noopener noreferrer">PubMed PMID 42852734</a>.</small></li>
  <li><small>Stone JH, Khosroshahi A, Zhang W, Della Torre E, Okazaki K, Tanaka Y, Löhr JM, Schleinitz N, Dong L, Umehara H, Lanzillotta M, Wallace ZS, Ebbo M, Webster GJ, Martinez Valle F, Nayar MK, Perugino CA, Rebours V, Dong X, Wu Y, Li Q, Rampal N, Cimbora D, Culver EL; MITIGATE Trial Investigators. Inebilizumab for Treatment of IgG4-Related Disease. <em>N Engl J Med.</em> 2025;392(12):1168–1177. DOI: <a href="https://doi.org/10.1056/NEJMoa2409712" target="_blank" rel="noopener noreferrer">10.1056/NEJMoa2409712</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/39541094/" target="_blank" rel="noopener noreferrer">PubMed PMID 39541094</a>.</small></li>
  <li><small>Carruthers MN, Topazian MD, Khosroshahi A, Witzig TE, Wallace ZS, Hart PA, Deshpande V, Smyrk TC, Chari S, Stone JH. Rituximab for IgG4-related disease: a prospective, open-label trial. <em>Ann Rheum Dis.</em> 2015;74(6):1171–1177. DOI: <a href="https://doi.org/10.1136/annrheumdis-2014-206605" target="_blank" rel="noopener noreferrer">10.1136/annrheumdis-2014-206605</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/25667206/" target="_blank" rel="noopener noreferrer">PubMed PMID 25667206</a>.</small></li>
  <li><small>Wallace ZS, Naden RP, Chari S, Choi HK, Della-Torre E, Dicaire JF, Hart PA, Inoue D, Kawano M, Khosroshahi A, Lanzillotta M, Okazaki K, Perugino CA, Sharma A, Saeki T, Schleinitz N, Takahashi N, Umehara H, Zen Y, Stone JH; Members of the ACR/EULAR IgG4-RD Classification Criteria Working Group. The 2019 American College of Rheumatology/European League Against Rheumatism classification criteria for IgG4-related disease. <em>Ann Rheum Dis.</em> 2020;79(1):77–87. DOI: <a href="https://doi.org/10.1136/annrheumdis-2019-216561" target="_blank" rel="noopener noreferrer">10.1136/annrheumdis-2019-216561</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/31796497/" target="_blank" rel="noopener noreferrer">PubMed PMID 31796497</a>.</small></li>
  <li><small>Kawano M, Saeki T, Nakashima H, Nishi S, Yamaguchi Y, Hisano S, et al. Proposal for diagnostic criteria for IgG4-related kidney disease. <em>Clin Exp Nephrol.</em> 2011;15(5):615–626. DOI: <a href="https://doi.org/10.1007/s10157-011-0521-2" target="_blank" rel="noopener noreferrer">10.1007/s10157-011-0521-2</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/21898030/" target="_blank" rel="noopener noreferrer">PubMed PMID 21898030</a>.</small></li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p><small>Autorský zoznam, DOI a PMID liečebného štandardu boli overené cez PubMed eutils a Crossref. Nad rámec predlohy, ktorá vychádzala iba zo zdrojového abstraktu, doplnil autor projektu kvantitatívne výsledky randomizovanej štúdie MITIGATE (prvý dôkaz fázy 3 pre cielenie na B bunky pri tomto ochorení), číselné výsledky otvorenej štúdie s rituximabom, rozlíšenie medzi klasifikačnými a diagnostickými kritériami, upozornenie na obmedzenú výpovednú hodnotu sérového IgG4 a rozbor limitov. Predloha uvádzala tvrdenia o „vysokej účinnosti“ B-bunkovej liečby bez číselného podkladu.</small></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=terapie-cielene-na-b-bunky-imunitne-ochorenia-obliciek-kdigo">Terapie cielené na B bunky pri imunitných ochoreniach obličiek</a></li>
  <li><a href="article.php?slug=cielenie-b-buniek-imunitne-podmienene-nefropatie-kdigo">Cielenie na B bunky pri imunitne podmienených nefropatiách</a></li>
  <li><a href="article.php?slug=cheatsheet-membranozna-nefropatia">Membranózna nefropatia: prehľadová karta</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_igg4-suvisiace-renalne-ochorenie-liecebny-standard_article',
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
