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
    'title' => 'Kedy možno vysadiť glukokortikoidy pri lupuse a lupusovej nefritíde?',
    'slug' => 'vysadenie-glukokortikoidov-lupus-lupusova-nefritida',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Vysadenie glukokortikoidov pri lupusovej nefritíde je u vybraných pacientov možné. Rozhoduje stabilná renálna aj celková kontrola ochorenia, pokračujúca liečba a plán sledovania.',
    'content' => <<<'HTML'
<p>Glukokortikoidy pomáhajú rýchlo potlačiť aktivitu systémového lupus erythematosus (SLE), ich dlhodobé podávanie však prináša kumulatívnu záťaž. Cieľom liečby preto nie je iba dosiahnuť nízku udržiavaciu dávku, ale u vhodne vybraných pacientov zvážiť aj úplné vysadenie. Rozhodnutie musí rešpektovať aktivitu ochorenia, predchádzajúce orgánové postihnutie, trvanie odpovede a účinnosť ostatnej liečby.</p>

<p>Odporúčania EULAR pre SLE smerujú k dávke najviac 5 mg prednizónového ekvivalentu denne a k vysadeniu, keď je to možné. KDIGO 2024 pri lupusovej nefritíde pripúšťa vysadenie po najmenej 12 mesiacoch kompletnej klinickej renálnej odpovede, ak glukokortikoidy nie sú potrebné pre extrarenálne prejavy. Ani jedno odporúčanie nepredstavuje automatický harmonogram pre každého pacienta. [3,4]</p>

<figure>
  <picture>
    <source srcset="img/vysadenie-glukokortikoidov-lupus-lupusova-nefritida.webp" type="image/webp">
    <img src="img/vysadenie-glukokortikoidov-lupus-lupusova-nefritida.png" alt="Ilustračné zobrazenie obličky s lupusovou nefritídou, postupného znižovania glukokortikoidov a rovnováhy medzi kontrolou zápalu a liečebnou záťažou" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Vysadenie glukokortikoidov nie je samostatný cieľ oddelený od kontroly lupusu. Rozhoduje rovnováha medzi aktivitou ochorenia, rizikom relapsu a kumulatívnou toxicitou liečby. Ilustračné zobrazenie.</figcaption>
</figure>

<h2>Vysadiť glukokortikoid neznamená ukončiť liečbu lupusu</h2>

<p>Pri diskusii o vysadení treba oddeliť tri situácie: zníženie vysokej dávky po zvládnutí aktívneho ochorenia, ukončenie nízkodávkovej glukokortikoidovej liečby a neskoršie obmedzovanie ostatnej imunosupresie. Tieto kroky nie sú zameniteľné.</p>

<p>Pacient môže byť bez glukokortikoidov, ale naďalej potrebovať hydroxychlorochín a udržiavaciu imunosupresívnu liečbu. V aténskej kohorte pacientov s lupusovou nefritídou <strong>všetci pri vysadení glukokortikoidov naďalej dostávali imunosupresívnu liečbu</strong>. Úspešné vysadenie preto neznamenalo ukončenie liečby nefritídy. [2]</p>

<p>Aj odporúčania rozlišujú časovanie jednotlivých liekov. KDIGO pripúšťa vysadenie glukokortikoidov po najmenej 12 mesiacoch kompletnej klinickej renálnej odpovede, ale pri proliferatívnej lupusovej nefritíde odporúča celkové trvanie úvodnej a udržiavacej imunosupresie najmenej 36 mesiacov. Klinická odpoveď navyše nemusí znamenať neprítomnosť histologickej aktivity. [3]</p>

<h2>Čo priniesla kohorta pacientov s lupusovou nefritídou</h2>

<p>Ioannis E. Michelakis a spoluautori analyzovali 136 pacientov s biopticky potvrdenou lupusovou nefritídou diagnostikovanou v rokoch 1992 až 2021. Pacienti boli sledovaní na spolupracujúcich reumatologickom a nefrologickom pracovisku nemocnice Laiko v Aténach. Medián sledovania bol 121 mesiacov. [2]</p>

<p>Proliferatívnu nefritídu vrátane zmiešaných foriem malo 97 pacientov a čistú membranóznu formu 39 pacientov. Zo súboru boli vylúčení pacienti so zlyhaním obličiek vyžadujúcim liečbu nahrádzajúcu funkciu obličiek pri diagnóze alebo krátko po nej. Výsledky preto nemožno bez výhrad preniesť na najťažšie renálne prezentácie.</p>

<div class="table-responsive" role="region" aria-label="Výsledky vysadzovania glukokortikoidov v aténskej kohorte" tabindex="0">
<table>
  <thead><tr><th scope="col">Sledovaný údaj</th><th scope="col">Výsledok</th></tr></thead>
  <tbody>
    <tr><th scope="row">Počet zaradených pacientov</th><td>136</td></tr>
    <tr><th scope="row">Medián sledovania</th><td>121 mesiacov</td></tr>
    <tr><th scope="row">Dosiahnuté vysadenie glukokortikoidov</th><td>117 pacientov (86 %)</td></tr>
    <tr><th scope="row">Medián času od diagnózy po vysadenie</th><td>29 mesiacov</td></tr>
    <tr><th scope="row">Akýkoľvek relaps po vysadení</th><td>29 zo 117 pacientov (24,8 %)</td></tr>
    <tr><th scope="row">Renálny relaps po vysadení</th><td>22 zo 117 pacientov (18,8 %)</td></tr>
  </tbody>
</table>
</div>

<p>Podiel 18,8 % nie je jednoročným rizikom ani odhadom pre každého budúceho pacienta. Renálne relapsy sa objavili s mediánom 25 mesiacov po vysadení. Sledovanie sa preto nemôže skončiť po niekoľkých stabilných kontrolách. [2]</p>

<h2>Rozhodovala renálna odpoveď aj aktivita mimo obličiek</h2>

<p>S kratším časom do vysadenia boli nezávisle spojené tri charakteristiky: pretrvávajúca kompletná renálna odpoveď spolu so skóre celkovej aktivity SLEDAI-2K najviac 4, čistá membranózna lupusová nefritída oproti proliferatívnym formám a pretrvávajúce užívanie hydroxychlorochínu. [2]</p>

<p>Kombinácia renálnej a celkovej kontroly je klinicky dôležitá. Priaznivý vývoj proteinúrie nevylučuje extrarenálnu aktivitu. Ústup kĺbových či kožných prejavov zase nepotvrdzuje remisiu nefritídy.</p>

<p>V čase vysadenia bola v kohorte mediánová proteinúria 0,2 g/deň a mediánová odhadovaná glomerulová filtrácia 105 ml/min/1,73 m². Ide o opis vybranej skupiny, nie o univerzálne prahové hodnoty. [2]</p>

<p>Pri čistej membranóznej forme sa glukokortikoidy vysadili skôr než pri proliferatívnej nefritíde, mediánovo po 25 oproti 31 mesiacom. Celkový podiel pacientov, u ktorých sa vysadenie napokon podarilo, bol však podobný. Histologická trieda V preto sama osebe neznamená nízke riziko ani neoprávňuje na vysadenie pri pretrvávajúcej aktivite.</p>

<h2>Remisia nie je iba neprítomnosť príznakov</h2>

<p>Lupus môže byť klinicky pokojný napriek pretrvávajúcim sérologickým odchýlkam. Pri rozhodovaní preto vzniká otázka, akú váhu prisúdiť protilátkam proti dvojvláknovej DNA a koncentráciám komplementu. Dostupné údaje nepodporujú jediný laboratórny test, ktorý by spoľahlivo rozhodol o vysadení.</p>

<p>Aténska štúdia rozlišovala klinickú remisiu DORIS a prísnejšiu kategóriu označenú ako „DORIS complete remission“. Práve prísnejšia kategória v čase vysadenia bola v multivariabilnej analýze spojená s nižšími šancami následného renálneho relapsu: OR 0,20; p = 0,005. Publikovaný abstrakt neuvádza interval spoľahlivosti tohto odhadu. [2]</p>

<p>Tento výsledok nemožno preložiť ako zaručené 80 % zníženie individuálneho rizika. Ide o pomer šancí z observačnej analýzy s krokovým výberom premenných. Označenie použité v štúdii navyše nemožno automaticky zameniť za každú inú definíciu remisie DORIS. Pri klinickom použití treba vždy skontrolovať presné kritériá príslušnej definície.</p>

<h2>Hydroxychlorochín bol priaznivým prognostickým znakom</h2>

<p>Pretrvávajúce užívanie hydroxychlorochínu bolo spojené so skorším vysadením glukokortikoidov aj s nižšími šancami renálneho relapsu po vysadení (upravený OR 0,28; p = 0,031). Autori „pretrvávajúce užívanie“ definovali ako užívanie počas najmenej dvoch tretín hodnoteného obdobia. Adherenciu hodnotili podľa sebahlásenia a elektronických údajov o výdaji, nie koncentráciou hydroxychlorochínu v krvi. [2]</p>

<p>Asociácia nie je dôkazom ochranného účinku v rozsahu vyjadrenom pomerom šancí. Pacienti užívajúci hydroxychlorochín sa mohli od ostatných odlišovať adherenciou, obdobím liečby aj ďalšími charakteristikami. V novšej časti kohorty sa hydroxychlorochín používal častejšie.</p>

<p>Výsledok je však v súlade s KDIGO, ktoré odporúča hydroxychlorochín alebo ekvivalentné antimalarikum pacientom so SLE vrátane lupusovej nefritídy, ak nie je kontraindikované. Dávka a monitorovanie musia rešpektovať telesnú hmotnosť, funkciu obličiek, kumulatívnu expozíciu a riziko retinálnej či zriedkavej kardiálnej toxicity. [3]</p>

<h2>Pomalšie znižovanie nebolo v tejto kohorte ochranné</h2>

<p>Autori nezistili, že vyššia úvodná dávka nad 40 mg/deň prednizónového ekvivalentu alebo pomalšie znižovanie chránili pred renálnym relapsom po vysadení. Tento výsledok nemožno interpretovať ako dôkaz bezpečnosti náhleho vysadenia. Štúdia nebola randomizovaným porovnaním rýchleho a pomalého režimu a pacienti s ťažšie kontrolovateľným ochorením prirodzene dostávali glukokortikoidy dlhšie. [2]</p>

<p>Randomizovaná štúdia CORTICOLUP pri klinicky pokojnom SLE zistila viac vzplanutí po vysadení stabilnej dávky 5 mg prednizónu než pri jej pokračovaní. KDIGO však upozorňuje, že vysadenie mohlo byť po dlhoročnej liečbe príliš náhle a časť príznakov mohla súvisieť s glukokortikoidovým abstinenčným syndrómom. Výsledok sa navyše netýkal výlučne pacientov s lupusovou nefritídou. [3]</p>

<p>Riziko relapsu lupusu a riziko adrenálnej insuficiencie sú dva odlišné klinické problémy. Aj pacient s kontrolovaným ochorením môže potrebovať pomalšie znižovanie pre útlm osi hypotalamus, hypofýza a nadobličky. Aténska štúdia neposkytuje endokrinologický protokol vysadzovania.</p>

<h2>Relaps po vysadení nemožno automaticky pripísať glukokortikoidu</h2>

<p>Z 22 pacientov s renálnym relapsom po vysadení malo šesť relaps počas pokračujúcej imunosupresívnej liečby, šesť počas jej znižovania a desať po jej ukončení. Časová následnosť „vysadenie glukokortikoidu, potom relaps“ preto sama osebe nepreukazuje príčinnú súvislosť. Medzitým sa menila ďalšia liečba aj aktivita ochorenia. [2]</p>

<p>Začatie znižovania ostatnej imunosupresie ešte pred úplným vysadením glukokortikoidov bolo častejšie u pacientov s renálnym relapsom počas znižovania dávky. Aj toto je observačná asociácia. Podporuje opatrnosť pri súbežnom oslabovaní viacerých zložiek liečby, neurčuje však jediné správne poradie pre všetkých pacientov.</p>

<h2>Ako výsledky využiť pri rozhodovaní</h2>

<p><strong>Stabilita odpovede.</strong> Dôležitý je vývoj proteinúrie, funkcie obličiek, močového sedimentu a extrarenálnych prejavov v čase, nie výsledok jednej kontroly.</p>

<p><strong>Pokračujúca liečba.</strong> Treba vedieť, čo bude po vysadení udržiavať kontrolu ochorenia a či pacient liečbu toleruje a užíva. Vysadenie glukokortikoidu sa nemá automaticky spájať so súčasným ukončením ostatnej imunosupresie.</p>

<p><strong>Predchádzajúci priebeh.</strong> Význam majú relapsy, histologická forma nefritídy, predchádzajúce orgánové ohrozenie a reakcia na skoršie pokusy o znižovanie dávky.</p>

<p><strong>Plán sledovania.</strong> Pacient potrebuje vedieť, ktoré ťažkosti má oznámiť, kedy sa skontroluje moč, proteinúria a funkcia obličiek a ako sa bude postupovať pri zhoršení. Nová proteinúria alebo pokles glomerulovej filtrácie vyžadujú diferenciálnu diagnostiku; nie každé zhoršenie je relaps aktívnej nefritídy.</p>

<p>Ide o klinickú syntézu, nie o validované predikčné skóre. Konkrétny postup má nadväzovať na aktuálne odporúčania a spoločné rozhodovanie nefrológa, reumatológa a pacienta.</p>

<h2>Obmedzenia aténskej štúdie</h2>

<ul>
  <li><strong>Retrospektívny observačný dizajn:</strong> identifikuje asociácie, nie príčiny ani optimálny režim.</li>
  <li><strong>Jedno grécke akademické prostredie:</strong> prevažovali pacienti bieleho európskeho pôvodu a zdravotná starostlivosť bola bezplatná.</li>
  <li><strong>Takmer tri desaťročia liečby:</strong> menili sa diagnostické kritériá, používanie hydroxychlorochínu aj dostupnosť liekov.</li>
  <li><strong>Obmedzené používanie biologickej liečby:</strong> kohorta nemôže spoľahlivo určiť jej vplyv na vysadzovanie.</li>
  <li><strong>Bez protokolárnej opakovanej biopsie:</strong> klinická remisia nemusela znamenať histologickú neaktivitu.</li>
  <li><strong>Málo relapsov:</strong> multivariabilné odhady vychádzali z 22 renálnych relapsov po vysadení a môžu byť nestabilné.</li>
</ul>

<h2>Klinické posolstvo</h2>

<p>Pri lupusovej nefritíde je vysadenie glukokortikoidov u mnohých pacientov dosiahnuteľné, spravidla však na pozadí pokračujúcej liečby. Najdôležitejším predpokladom nie je samotná nízka dávka prednizónu, ale stabilná kontrola renálneho aj systémového ochorenia.</p>

<p>Aténska kohorta podporuje význam kompletnej renálnej odpovede, nízkej celkovej aktivity a pokračujúceho hydroxychlorochínu. Nemôže zaručiť bezpečné vysadenie konkrétnemu pacientovi ani určiť univerzálny harmonogram. Rozumným cieľom nie je nulová dávka za každú cenu, ale čo najnižšia glukokortikoidová záťaž bez straty kontroly nad ochorením.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Who Can Safely Stop Steroids in Lupus? <em>Medscape.</em> Preklad textu z El Médico Interactivo pre Univadis. <a href="https://www.medscape.com/viewarticle/who-can-safely-stop-steroids-lupus-2026a10010o0" target="_blank" rel="noopener noreferrer">Zdrojový článok</a>. Individuálne autorstvo ani presný dátum neboli vo verejne dostupnom výstupe uvedené.</em></small></p>
<p><small><em>[2] Ioannis E. Michelakis, Alexandros Panagiotopoulos, Eleni Kapsia, John Boletis, Smaragdi Marinaki, Petros P. Sfikakis, Maria G. Tektonidou. Predictors of a Successful Glucocorticoid Tapering and Withdrawal in an Inception Cohort of Patients With Lupus Nephritis and Associations With Long-Term Outcomes and Damage Accrual. <em>RMD Open.</em> 2025;11(4):e005877. DOI: <a href="https://doi.org/10.1136/rmdopen-2025-005877" target="_blank" rel="noopener noreferrer">10.1136/rmdopen-2025-005877</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/41120201/" target="_blank" rel="noopener noreferrer">PubMed PMID 41120201</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12542714/" target="_blank" rel="noopener noreferrer">Plný text a suplement v PubMed Central</a>.</em></small></p>
<p><small><em>[3] Kidney Disease: Improving Global Outcomes Lupus Nephritis Work Group. KDIGO 2024 Clinical Practice Guideline for the Management of Lupus Nephritis. <em>Kidney International.</em> 2024;105(Suppl 1S):S1–S69. DOI: <a href="https://doi.org/10.1016/j.kint.2023.09.002" target="_blank" rel="noopener noreferrer">10.1016/j.kint.2023.09.002</a>. <a href="https://kdigo.org/wp-content/uploads/2024/01/KDIGO-2024-Lupus-Nephritis-Guideline.pdf" target="_blank" rel="noopener noreferrer">Oficiálne odporúčanie KDIGO</a>.</em></small></p>
<p><small><em>[4] Antonis Fanouriakis, Myrto Kostopoulou, Jeanette Andersen, Martin Aringer, Laurent Arnaud, Sang-Cheol Bae, John Boletis, Ian N. Bruce, Ricard Cervera, Andrea Doria, Thomas Dörner, Richard A. Furie, Dafna D. Gladman, Frederic A. Houssiau, Luís Sousa Inês, David Jayne, Marios Kouloumas, László Kovács, Chi Chiu Mok, Eric F. Morand, Gabriella Moroni, Marta Mosca, Johanna Mucke, Chetan B. Mukhtyar, György Nagy, Sandra Navarra, Ioannis Parodis, José M. Pego-Reigosa, Michelle Petri, Bernardo A. Pons-Estel, Matthias Schneider, Josef S. Smolen, Elisabet Svenungsson, Yoshiya Tanaka, Maria G. Tektonidou, Yk Onno Teng, Angela Tincani, Edward M. Vital, Ronald F. van Vollenhoven, Chris Wincup, George Bertsias, Dimitrios T. Boumpas. EULAR Recommendations for the Management of Systemic Lupus Erythematosus: 2023 Update. <em>Annals of the Rheumatic Diseases.</em> 2024;83(1):15–29. DOI: <a href="https://doi.org/10.1136/ard-2023-224762" target="_blank" rel="noopener noreferrer">10.1136/ard-2023-224762</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/37827694/" target="_blank" rel="noopener noreferrer">PubMed PMID 37827694</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vysadenie-glukokortikoidov-lupus-lupusova-nefritida_article',
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
