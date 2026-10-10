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
    'title' => 'Periférne artériové ochorenie a prognóza starších príjemcov obličky',
    'slug' => 'periferne-arteriove-ochorenie-prognoza-starsi-prijemcovia-oblicky',
    'author' => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top' => 0,
    'excerpt' => 'Francúzska kohortová štúdia spája periférne artériové ochorenie s vyššou jednoročnou mortalitou po transplantácii obličky. Výsledok podporuje individuálne cievne a funkčné hodnotenie.',
    'content' => <<<'HTML'
<p>Pri posudzovaní staršieho kandidáta na transplantáciu obličky nestačí poznať jeho vek. Rozhoduje celková záťaž ochoreniami, funkčná rezerva, technická uskutočniteľnosť výkonu a riziko komplikácií. Nová francúzska retrospektívna kohortová štúdia ukázala, že periférne artériové ochorenie dolných končatín bolo u transplantovaných pacientov vo veku najmenej 65 rokov spojené s vyšším hazardom úmrtia počas prvého roka po transplantácii. Chronologická veková skupina sa v upravenom modeli nepreukázala ako nezávislý prediktor, hoci pri veku nad 75 rokov bol odhad blízko hranice štatistickej významnosti. [1]</p>

<p>Výsledok podporuje podrobnejšie cievne a funkčné hodnotenie. Neznamená, že vek nemá prognostický význam, ani že periférne artériové ochorenie samo osebe vylučuje transplantáciu.</p>

<figure>
  <picture>
    <source srcset="img/periferne-arteriove-ochorenie-prognoza-starsi-prijemcovia-oblicky.webp" type="image/webp">
    <img src="img/periferne-arteriove-ochorenie-prognoza-starsi-prijemcovia-oblicky.png" alt="Starší príjemca obličky s ilustračným zobrazením transplantovanej obličky, panvových tepien a zúženia tepny dolnej končatiny" width="1600" height="1000" loading="lazy" decoding="async">
  </picture>
  <figcaption>Periférne artériové ochorenie môže súčasne vyjadrovať systémovú aterosklerotickú záťaž, lokálnu ischémiu aj technickú náročnosť cievneho napojenia štepu. Ilustračné zobrazenie.</figcaption>
</figure>

<h2>Koho výskumníci sledovali</h2>

<p>Autori prepojili francúzsky register REIN s celoštátnou databázou zdravotnej starostlivosti SNDS. Do analýzy zahrnuli 749 pacientov vo veku najmenej 65 rokov, ktorí v rokoch 2017 alebo 2018 začali liečbu nahrádzajúcu funkciu obličiek a do konca roka 2020 podstúpili prvú transplantáciu obličky. Pacientov po kombinovanej transplantácii orgánov nezaradili. Muži tvorili 67,4 % súboru. [1]</p>

<p>Transplantácia bola prvou metódou liečby nahrádzajúcej funkciu obličiek u 191 pacientov, teda u 25,5 % súboru. Obličku od žijúceho darcu dostalo 104 pacientov (13,9 %). Periférne artériové ochorenie dolných končatín bolo pri začatí liečby nahrádzajúcej funkciu obličiek zaznamenané u 74 pacientov (9,9 %); údaj chýbal u 14 pacientov. [1]</p>

<p>Primárnou analyzovanou udalosťou bolo úmrtie z akejkoľvek príčiny počas prvého roka po transplantácii. Autori hodnotili aj dĺžku úvodnej hospitalizácie, opätovnú hospitalizáciu do 30 dní po prepustení a kumulatívny počet dní hospitalizácie počas prvého potransplantačného roka. Do údajov o predtransplantačnej ceste zahrnuli kardiovaskulárne vyšetrenia, odborné konzultácie a hospitalizácie počas dvoch rokov pred registráciou na čakaciu listinu až po zaradenie na aktívnu čakaciu listinu. [1]</p>

<h2>Periférne artériové ochorenie bolo spojené s vyššou mortalitou</h2>

<p>Počas prvého roka po transplantácii zomrelo 66 zo 749 pacientov, čo predstavuje 8,8 % celej kohorty. Devätnásť úmrtí nastalo počas úvodnej hospitalizácie. V multivariabilnom Coxovom modeli bolo periférne artériové ochorenie dolných končatín spojené s vyšším hazardom jednoročnej mortality:</p>

<p><strong>upravený pomer hazardov 1,97; 95 % interval spoľahlivosti 1,02 až 3,82; p = 0,04.</strong> [1]</p>

<p>Bodový odhad zodpovedá približne dvojnásobnému relatívnemu hazardu, nie dvojnásobnej absolútnej pravdepodobnosti úmrtia. Interval spoľahlivosti je široký a jeho dolná hranica leží tesne nad neutrálnou hodnotou. Výsledok preto naznačuje klinicky dôležitú asociáciu, jej presná veľkosť však zostáva neistá. Publikácia neuvádza absolútnu mortalitu osobitne pre pacientov s periférnym artériovým ochorením a bez neho, takže absolútny rozdiel rizika ani počet potrebný na poškodenie nemožno spoľahlivo vypočítať.</p>

<div class="table-responsive" role="region" aria-label="Faktory spojené s jednoročnou mortalitou po transplantácii" tabindex="0">
<table>
  <thead><tr><th scope="col">Premenná</th><th scope="col">Upravený HR</th><th scope="col">95 % interval spoľahlivosti</th><th scope="col">p</th></tr></thead>
  <tbody>
    <tr><th scope="row">Vek od 70 do 74 rokov oproti 65 až 69 rokom</th><td>1,43</td><td>0,76 až 2,70</td><td>0,26</td></tr>
    <tr><th scope="row">Vek nad 75 rokov oproti 65 až 69 rokom</th><td>1,80</td><td>0,96 až 3,27</td><td>0,06</td></tr>
    <tr><th scope="row">Periférne artériové ochorenie dolných končatín</th><td>1,97</td><td>1,02 až 3,82</td><td>0,04</td></tr>
    <tr><th scope="row">Chronické srdcové zlyhávanie</th><td>2,21</td><td>1,15 až 4,25</td><td>0,02</td></tr>
    <tr><th scope="row">Najmenej dve cievnochirurgické konzultácie</th><td>1,95</td><td>1,07 až 3,56</td><td>0,03</td></tr>
    <tr><th scope="row">Jedna hospitalizácia z cievnych príčin</th><td>2,07</td><td>1,11 až 3,85</td><td>0,02</td></tr>
    <tr><th scope="row">Najmenej dve hospitalizácie z cievnych príčin</th><td>2,85</td><td>1,34 až 6,07</td><td>0,007</td></tr>
  </tbody>
</table>
</div>

<p>Hospitalizácie z cievnych príčin nezahŕňali výkony súvisiace s dialyzačným cievnym prístupom. Počet cievnochirurgických konzultácií ani hospitalizácií nemožno interpretovať ako príčinu úmrtia. Pravdepodobnejšie označujú symptomatickejšie, závažnejšie alebo komplikovanejšie cievne ochorenie.</p>

<h2>Vek sa prejavil skôr v hospitalizačnej záťaži</h2>

<p>Úvodná hospitalizácia trvala menej ako 10 dní u 197 pacientov, od 10 do 21 dní u 424 pacientov a viac ako 21 dní u 128 pacientov. S dlhým úvodným pobytom bol nezávisle spojený vek od 70 do 74 rokov oproti veku od 65 do 69 rokov (OR 2,15; 95 % interval spoľahlivosti 1,3 až 3,5), chronická respiračná insuficiencia a arytmia. Pri veku nad 75 rokov sa takáto asociácia s úvodnou hospitalizáciou nepreukázala. [1]</p>

<p>Po prepustení bolo do 30 dní opätovne hospitalizovaných 411 zo 730 pacientov, ktorí prežili úvodnú hospitalizáciu, teda 56 %. Skúmaná definícia zahŕňala každú novú hospitalizáciu bez ohľadu na dôvod. Vyšší pomer šancí skorej opätovnej hospitalizácie bol spojený so ženským pohlavím (OR 1,50; 95 % interval spoľahlivosti 1,05 až 2,12) a úvodným pobytom dlhším ako 21 dní (OR 1,70; 95 % interval spoľahlivosti 1,06 až 2,70). Veková skupina nebola nezávislým prediktorom tejto udalosti. [1]</p>

<p>V analýze 681 pacientov bol vek nad 75 rokov spojený s viac ako 30 dňami následnej hospitalizácie počas prvého roka po transplantácii, pričom úvodný pobyt sa do súčtu nezapočítaval (OR 2,08; 95 % interval spoľahlivosti 1,2 až 3,5). Podobnú asociáciu mala arytmia. Preemptívna transplantácia a transplantácia od žijúceho darcu boli v tomto modeli spojené s nižším pomerom šancí predĺženej kumulatívnej hospitalizácie. [1]</p>

<h2>Nezávislá asociácia nie je dôkaz príčinnej súvislosti</h2>

<p>Označenie „nezávisle spojené“ znamená, že asociácia pretrvala po úprave o premenné zahrnuté do modelu. Neodstraňuje vplyv nemeraných alebo nepresne zaznamenaných faktorov. Periférne artériové ochorenie môže sprevádzať diabetes, fajčenie, difúznu aterosklerózu, kalcifikáciu tepien, krehkosť a funkčné obmedzenie. Register a administratívne údaje ich nemusia zachytiť v potrebnej podrobnosti.</p>

<p>Do Coxovho modelu sa premenné vyberali podľa výsledkov jednorozmernej analýzy a následne spätnou krokovou selekciou. Takýto postup môže pri 66 jednoročných úmrtiach viesť k nestabilite odhadov a zvyšuje riziko nadhodnotenia niektorých asociácií. Štúdia navyše nebola navrhnutá ako validačná štúdia prognostického modelu. Výsledný HR preto nemožno používať ako samostatné transplantačné skóre.</p>

<h2>Prečo nemožno uzavrieť, že vek nie je dôležitý</h2>

<p>Do kohorty vstúpili iba pacienti, ktorí prešli výberom na transplantáciu a následne transplantáciu podstúpili. Najstarší príjemcovia mohli byť zdravotne starostlivejšie vybraní než mladší. Takáto selekcia oslabuje pozorovanú súvislosť medzi chronologickým vekom a mortalitou.</p>

<p>Odhad pre vek nad 75 rokov nebol neutrálny: HR bol 1,80, 95 % interval spoľahlivosti 0,96 až 3,27 a p = 0,06. Štúdia teda neposkytla dostatočne presný dôkaz nezávislej asociácie, ale ani dôkaz neprítomnosti vekového účinku. Podporuje užší záver, že samotný vek nedostatočne vystihuje individuálne riziko v už vybranej skupine starších príjemcov.</p>

<h2>Vyššie riziko po transplantácii neznamená neprítomnosť jej prínosu</h2>

<p>Analýza neporovnávala transplantovaných pacientov s klinicky podobnými pacientmi, ktorí zostali na dialýze. Pacient s periférnym artériovým ochorením môže mať po transplantácii horšiu prognózu než príjemca bez tohto ochorenia a napriek tomu môže z transplantácie profitovať v porovnaní s pokračovaním dialyzačnej liečby.</p>

<p>Štúdia preto odpovedá na otázku, ktoré charakteristiky boli spojené s prognózou už transplantovaných starších pacientov. Neurčuje, komu sa transplantácia v porovnaní s ponechaním na dialýze „neoplatí“, a nevytvára automatické vylučovacie kritérium.</p>

<h2>Čo periférne artériové ochorenie mení v predtransplantačnom hodnotení</h2>

<p>Periférne artériové ochorenie nie je synonymom všetkých cievnych diagnóz. V tejto štúdii išlo o ochorenie dolných končatín zaznamenané v registri pri začatí liečby nahrádzajúcej funkciu obličiek. Bez údajov o anatomickom rozsahu, závažnosti ischémie a predchádzajúcich revaskularizáciách nemožno určiť, ktorý mechanizmus vysvetľoval mortalitnú asociáciu.</p>

<p>Odporúčanie KDIGO pre hodnotenie kandidátov na transplantáciu obličky žiada u všetkých kandidátov anamnézou a fyzikálnym vyšetrením posúdiť prítomnosť a závažnosť periférneho artériového ochorenia. Rizikoví pacienti bez klinicky zjavného ochorenia majú podstúpiť neinvazívne cievne vyšetrenie. Pri klinicky zjavnom ochorení sa odporúča konzultácia cievneho chirurga; pri zjavnom ochorení alebo abnormálnom neinvazívnom náleze aj natívne CT brucha a panvy na zhodnotenie kalcifikácií a operačné plánovanie. [2]</p>

<p>Závažné aortoiliakálne alebo distálne cievne ochorenie podľa KDIGO samo osebe nie je dôvodom pacienta z transplantácie vylúčiť. Riziko progresie treba prebrať s pacientom. Pri nehojacej sa rane končatiny s aktívnou infekciou sa má transplantácia odložiť do vyriešenia infekcie. [2]</p>

<p>V praxi treba rozlíšiť asymptomatické ochorenie, klaudikácie, pokojovú bolesť, nehojace sa defekty, predchádzajúcu revaskularizáciu a anatomické postihnutie aortoiliakálneho riečiska. Neprítomnosť klaudikácií nevylučuje významné ochorenie u človeka s nízkou mobilitou alebo diabetickou neuropatiou. Hodnotenie mobility, sebestačnosti, výživy, kognitívnych funkcií a sociálnej podpory dopĺňa informáciu, ktorú vek ani diagnostický kód neposkytujú.</p>

<p>Predchádzajúce observačné práce tiež spájali periférne cievne ochorenie s horším prežívaním pacienta a štepu po transplantácii. [3,4] Ani súhrn týchto asociácií však nepreukazuje, že rutinná preventívna revaskularizácia znižuje mortalitu, ani neurčuje jednotný antitrombotický režim. Liečba musí vychádzať z konkrétnej cievnej indikácie, krvácavého rizika, funkcie obličiek a plánovaného výkonu.</p>

<h2>Obmedzenia, ktoré menia silu záveru</h2>

<ul>
  <li><strong>Retrospektívny observačný dizajn:</strong> umožňuje hodnotiť asociácie, nie dokazovať príčinnosť.</li>
  <li><strong>Vybraná populácia:</strong> výsledky sa vzťahujú na pacientov, ktorí boli zaradení na čakaciu listinu a transplantovaní do troch rokov od začatia liečby nahrádzajúcej funkciu obličiek.</li>
  <li><strong>Časovanie údajov:</strong> pri nepreemptívnej transplantácii pochádzali niektoré klinické údaje zo začiatku dialyzačnej liečby, nie z bezprostredného predtransplantačného obdobia.</li>
  <li><strong>Administratívne záznamy:</strong> diagnostické kódy a dôvody hospitalizácie môžu byť neúplné alebo nejednotné.</li>
  <li><strong>Málo udalostí a široké intervaly:</strong> počas prvého roka zomrelo 66 pacientov; presnosť viacerých odhadov bola obmedzená.</li>
  <li><strong>Jednoročný horizont:</strong> výsledky nemožno prenášať na dlhodobé prežívanie pacienta alebo štepu.</li>
  <li><strong>Bez porovnania s dialýzou:</strong> štúdia neurčuje individuálny prínos transplantácie oproti pokračovaniu dialyzačnej liečby.</li>
</ul>

<h2>Klinické posolstvo</h2>

<p>Periférne artériové ochorenie je u staršieho kandidáta na transplantáciu signálom na podrobnejšie posúdenie cievnej, kardiálnej a funkčnej záťaže. Nie je samo osebe odpoveďou na otázku, či pacienta transplantovať.</p>

<p>Rozhodnutie má vychádzať z celkového zdravotného stavu, závažnosti a anatomického rozsahu cievneho ochorenia, technickej uskutočniteľnosti výkonu, očakávanej rehabilitácie, alternatív liečby a preferencií pacienta. Francúzska štúdia podporuje individualizované hodnotenie namiesto rozhodovania založeného výlučne na chronologickom veku. Dôkaz, že konkrétna nová skríningová alebo intervenčná stratégia zlepší výsledky, však neposkytuje.</p>

<hr>

<p><small><em><strong>Zdroje:</strong></em></small></p>
<p><small><em>[1] Elsa Vabret, Juliette Piveteau, Mathilde Lassalle, Fatouma Dupuytren Toure, Jean-Baptiste Beuscart, Cécile Couchoud, Cécile Vigneau, Sahar Bayat-Makoei. Kidney transplantation outcomes in older adults: the influence of comorbidity burden. <em>Kidney Diseases.</em> Publikované online 23. septembra 2026. DOI: <a href="https://doi.org/10.1159/kdd/adkag009" target="_blank" rel="noopener noreferrer">10.1159/kdd/adkag009</a>. <a href="https://karger.figshare.com/articles/dataset/Supplemental_Material_for_Kidney_transplantation_outcomes_in_older_adults_the_influence_of_comorbidity_burden/33964414" target="_blank" rel="noopener noreferrer">Suplement</a>.</em></small></p>
<p><small><em>[2] Steven J. Chadban, Curie Ahn, David A. Axelrod, Bethany J. Foster, Bertram L. Kasiske, Vijah Kher, Deepali Kumar, Rainer Oberbauer, Julio Pascual, Helen L. Pilmore, James R. Rodrigue, Dorry L. Segev, Neil S. Sheerin, Kathryn J. Tinckam, Germaine Wong, Gregory A. Knoll. KDIGO Clinical Practice Guideline on the Evaluation and Management of Candidates for Kidney Transplantation. <em>Transplantation.</em> 2020;104(4S1 Suppl 1):S11–S103. DOI: <a href="https://doi.org/10.1097/TP.0000000000003136" target="_blank" rel="noopener noreferrer">10.1097/TP.0000000000003136</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/32301874/" target="_blank" rel="noopener noreferrer">PubMed PMID 32301874</a>. <a href="https://kdigo.org/guidelines/transplant-candidate/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</em></small></p>
<p><small><em>[3] Amarpali Brar, Rahul M. Jindal, Eric A. Elster, Fasika Tedla, Devon John, Nabil Sumrani, Moro O. Salifu. Effect of peripheral vascular disease on kidney allograft outcomes: a study of U.S. Renal Data System. <em>Transplantation.</em> 2013;95(6):810–815. DOI: <a href="https://doi.org/10.1097/TP.0b013e31827eef36" target="_blank" rel="noopener noreferrer">10.1097/TP.0b013e31827eef36</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/23354295/" target="_blank" rel="noopener noreferrer">PubMed PMID 23354295</a>.</em></small></p>
<p><small><em>[4] Domingo Hernández, Teresa Vázquez, Ana María Armas-Padrón, Juana Alonso-Titos, Cristina Casas, Elena Gutiérrez, Cristina Jironda, Mercedes Cabello, Verónica López. Peripheral Vascular Disease and Kidney Transplant Outcomes: Rethinking an Important Ongoing Complication. <em>Transplantation.</em> 2021;105(6):1188–1202. DOI: <a href="https://doi.org/10.1097/TP.0000000000003518" target="_blank" rel="noopener noreferrer">10.1097/TP.0000000000003518</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/33148978/" target="_blank" rel="noopener noreferrer">PubMed PMID 33148978</a>.</em></small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_periferne-arteriove-ochorenie-prognoza-starsi-prijemcovia-oblicky_article',
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
