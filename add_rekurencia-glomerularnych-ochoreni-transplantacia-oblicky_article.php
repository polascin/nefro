<?php
/**
 * add_rekurencia-glomerularnych-ochoreni-transplantacia-oblicky_article.php
 * Odborný článok o rekurencii glomerulárnych ochorení po transplantácii
 * obličky: C3 glomerulopatia (vrátane štúdie NOBLE s pegcetakoplanom),
 * primárna FSGS a IgA nefropatia – riziko, diagnostika a hranice liečby.
 * Podnetom bol vzdelávací program NephroLIVE; číselné údaje pochádzajú
 * z primárnych zdrojov (CJASN 2021, Kidney International Reports 2025).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Rekurencia glomerulárnych ochorení po transplantácii obličky: C3 glomerulopatia, FSGS a IgA nefropatia',
    'slug'         => 'rekurencia-glomerularnych-ochoreni-transplantacia-oblicky',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Primárna FSGS recidivuje u 30 až 60 % príjemcov a môže sa prejaviť už v prvých dňoch. Profylaktická plazmaferéza sa neodporúča. Pri C3 glomerulopatii priniesla prvé priame údaje zo štepu štúdia NOBLE.',
    'content'      => <<<'HTML'
<figure><a href="img/rekurencia-glomerularnych-ochoreni-po-transplantacii.webp" rel="noopener noreferrer" target="_blank"><img src="img/rekurencia-glomerularnych-ochoreni-po-transplantacii.webp" alt="Z rozpadajúcej sa pôvodnej obličky vľavo prúdia svietiace častice a protilátky k novej transplantovanej obličke vpravo, v ktorej začínajú žiariť jantárové depozity" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna, nie snímka konkrétneho pacienta. Vyjadruje podstatu rekurencie: transplantácia nahradí orgán, ale neodstráni cirkulujúci mechanizmus, ktorý pôvodnú obličku zničil.</figcaption></figure>

<p>Transplantácia obličky nahrádza funkciu zlyhaného orgánu, nemusí však odstrániť mechanizmus, ktorý spôsobil jeho poškodenie. Ak v organizme pretrváva porucha regulácie komplementu, tvorba patogénnych imunoglobulínov alebo iný systémový mechanizmus poškodenia glomerulov, základné ochorenie môže postihnúť aj transplantovanú obličku.</p>

<p>Rekurencia glomerulárneho ochorenia zostáva významnou príčinou neskorého zlyhania štepu. Jej pravdepodobnosť, časový priebeh aj liečiteľnosť sa však medzi diagnózami zásadne líšia. Primárna fokálna segmentálna glomeruloskleróza môže recidivovať už v prvých dňoch po transplantácii. IgA nefropatia sa často prejaví až po rokoch. Pri C3 glomerulopatii môže histologická rekurencia predchádzať výrazným klinickým príznakom.</p>

<p>Podnetom na spracovanie témy bol vzdelávací program NephroLIVE venovaný rekurencii základného ochorenia po transplantácii, v ktorom Harald Rupprecht rozoberá C3 glomerulonefritídu, Janina Müller-Deile FSGS a Claudia Seikrit IgA nefropatiu. [1] Číselné údaje a liečebné postupy uvedené nižšie však pochádzajú z primárnych publikovaných zdrojov, nie z prednášok.</p>

<h2>Najskôr treba správne pomenovať základné ochorenie</h2>

<p>Odhad rizika rekurencie sa začína ešte pred transplantáciou. Rozhodujúci je čo najpresnejší etiologický záver z obdobia ochorenia vlastných obličiek, nie iba názov histologického obrazu.</p>

<p>Fokálna segmentálna glomeruloskleróza (FSGS) je <strong>vzorec glomerulárneho poškodenia</strong>, nie jedna choroba. Môže byť prejavom primárnej podocytopatie, genetického ochorenia alebo sekundárnej adaptívnej či inej lézie. Tieto situácie majú zásadne odlišné riziko rekurencie.</p>

<p>Podobne membranoproliferatívny obraz glomerulonefritídy nie je jednotnou etiologickou diagnózou. Treba rozlišovať najmä imunokomplexovo sprostredkované ochorenie a C3 glomerulopatiu, ktorá zahŕňa C3 glomerulonefritídu a chorobu denzných depozitov. Rozlíšenie sa opiera o imunofluorescenčné a elektrónovomikroskopické vyšetrenie.</p>

<p>Praktický význam má preto revízia pôvodnej biopsie, klinického fenotypu a podľa indikácie aj genetických, imunologických a hematologických vyšetrení. Nesprávne zaradenie primárnej a sekundárnej FSGS môže viesť k zásadne chybnému poučeniu pacienta o riziku transplantácie. [2]</p>

<h2>Rekurencia nie je synonymom každej proteinúrie v štepe</h2>

<p>Novovzniknutá proteinúria, hematúria alebo zhoršenie funkcie transplantovanej obličky vyžadujú diferenciálnu diagnostiku. Okrem rekurencie treba zvažovať rejekciu, transplantačnú glomerulopatiu, infekciu, trombotickú mikroangiopatiu, liekovú toxicitu a nové glomerulárne ochorenie.</p>

<p>Rekurencia a rejekcia navyše môžu existovať súčasne. Nález glomerulárnych depozitov preto nesmie ukončiť hodnotenie ostatných častí biopsie.</p>

<p>Základné klinické posúdenie zahŕňa:</p>

<ul>
  <li>vývoj kreatinínu a odhadovanej glomerulovej filtrácie,</li>
  <li>kvantifikáciu proteinúrie a vyšetrenie močového sedimentu,</li>
  <li>krvný tlak, sérový albumín a stav hydratácie,</li>
  <li>adherenciu k imunosupresívnej liečbe a podľa situácie koncentrácie liekov,</li>
  <li>vyšetrenia zamerané na rejekciu, infekciu alebo pôvodné ochorenie.</li>
</ul>

<p>Pri podozrení na glomerulárnu príčinu je zásadná biopsia štepu s primeraným imunofluorescenčným a elektrónovomikroskopickým spracovaním. Samotná svetelná mikroskopia nemusí zachytiť skorú rekurenciu podocytopatie ani správne klasifikovať depozitové ochorenie.</p>

<h2>C3 glomerulopatia: transplantácia neodstraňuje systémovú poruchu komplementu</h2>

<p>C3 glomerulopatia súvisí s dysreguláciou alternatívnej cesty komplementu. Mechanizmus môže zahŕňať genetické odchýlky, získané autoprotilátky alebo ich kombináciu. U časti pacientov treba hľadať aj monoklonálnu gamapatiu, ktorá môže nepriamo narúšať reguláciu komplementu.</p>

<p>Transplantovaná oblička zostáva vystavená cirkulujúcim patogénnym mechanizmom, a preto je riziko rekurencie vysoké. Jediné univerzálne percento by však bolo zavádzajúce: výsledky závisia od zloženia súboru, dĺžky sledovania a od toho, či sa vykonávajú protokolárne biopsie alebo iba biopsie pri klinickom zhoršení.</p>

<h3>Čo sledovať</h3>

<p>Klinické sledovanie zahŕňa proteinúriu, močový sediment a funkciu štepu. Vyšetrenie C3 a ďalších ukazovateľov komplementu môže doplniť obraz ochorenia, ale <strong>normálna koncentrácia C3 rekurenciu nevylučuje</strong>. Ani genetický alebo sérologický výsledok sám osebe neurčuje, kedy a s akou závažnosťou ochorenie recidivuje.</p>

<p>Rozhodovanie sa musí opierať o súlad klinického vývoja, laboratórnych výsledkov a histologického nálezu. Pri hodnotení biopsie je dôležitá nielen prítomnosť depozitov, ale aj aktivita zápalu a rozsah chronického poškodenia.</p>

<h3>Komplementová liečba: rozdielne ciele, rozdielna sila dôkazov</h3>

<div class="table-responsive" role="region" aria-label="Miesto účinku liekov zasahujúcich do komplementovej kaskády" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Liečivo</th>
      <th scope="col">Hlavný cieľ</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Ekulizumab</th>
      <td>Zložka C5</td>
    </tr>
    <tr>
      <th scope="row">Iptakopán</th>
      <td>Faktor B alternatívnej cesty</td>
    </tr>
    <tr>
      <th scope="row">Pegcetakoplan</th>
      <td>Zložka C3 a jej aktívny fragment C3b</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozdielne mechanizmy účinku neumožňujú považovať tieto lieky za vzájomne zameniteľné. Rovnako nemožno automaticky prenášať výsledky z vlastných obličiek na rekurentné ochorenie v štepe.</p>

<h4>Štúdia NOBLE: prvé priame údaje z transplantovanej populácie</h4>

<p>Priamo transplantačnej populácii sa venovala štúdia <strong>NOBLE</strong> (NCT04572854) – prospektívna, multicentrická, otvorená randomizovaná štúdia fázy 2 s pegcetakoplanom u pacientov s rekurentnou C3 glomerulopatiou alebo primárnou imunokomplexovo sprostredkovanou membranoproliferatívnou glomerulonefritídou po transplantácii. Primárnym ukazovateľom bolo zníženie farbenia na C3c v biopsii štepu v 12. týždni. Do 12. týždňa dostalo <strong>10 pacientov pegcetakoplan</strong> (1 080 mg subkutánne dvakrát týždenne spolu so štandardnou starostlivosťou) a <strong>3 pacienti iba štandardnú starostlivosť</strong>. [3]</p>

<div class="table-responsive" role="region" aria-label="Výsledky štúdie NOBLE v 12. týždni" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ v 12. týždni</th>
      <th scope="col">Pegcetakoplan (n = 10)</th>
      <th scope="col">Štandardná starostlivosť (n = 3)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Pokles farbenia C3 najmenej o 2 rády</th>
      <td>5 z 10 (50 %); u 4 z nich nulové farbenie a vymiznuté depozity v elektrónovej mikroskopii</td>
      <td>–</td>
    </tr>
    <tr>
      <th scope="row">Pokles farbenia C3 najmenej o 1 rád</th>
      <td>8 z 10 (80 %)</td>
      <td>1 z 3 (33 %) s poklesom farbenia</td>
    </tr>
    <tr>
      <th scope="row">Pokles histologického skóre aktivity C3G o viac než 54 %</th>
      <td>8 z 10 (80 %)</td>
      <td>–</td>
    </tr>
    <tr>
      <th scope="row">Proteinúria pri vstupnom uPCR ≥ 1 000 mg/g</th>
      <td>medián poklesu 54,4 %</td>
      <td>–</td>
    </tr>
    <tr>
      <th scope="row">Odhadovaná glomerulová filtrácia</th>
      <td>stabilná</td>
      <td>–</td>
    </tr>
  </tbody>
</table>
</div>

<p>Pegcetakoplan bol dobre tolerovaný, väčšina nežiaducich udalostí bola mierna až stredne závažná a nezaznamenalo sa žiadne prerušenie liečby, vysadenie ani úmrtie. [3]</p>

<p>Pri interpretácii treba zachovať mieru. Ide o <strong>štúdiu fázy 2 s trinástimi pacientmi</strong>, otvoreným dizajnom a <strong>histologickým náhradným ukazovateľom</strong> v 12. týždni. Z takého dizajnu nemožno odvodiť vplyv na dlhodobé prežívanie štepu ani optimálny čas začatia liečby. Výsledky sú povzbudivé a prvýkrát priamo získané v transplantovanej populácii, nie sú však dôkazom o tvrdých klinických výsledkoch.</p>

<p>Pri indikácii inhibície komplementu treba osobitne riešiť riziko závažných infekcií, vakcináciu a podľa konkrétneho prípravku aj antimikrobiálnu profylaxiu. U transplantovaného pacienta sa tieto riziká pripočítavajú k účinku udržiavacej imunosupresie. Klinické výsledky štúdie, registrovaná indikácia, dostupnosť a úhrada lieku sú štyri odlišné otázky – pred použitím treba overiť aktuálny súhrn charakteristických vlastností lieku a miestne podmienky.</p>

<h2>FSGS: najvyššie riziko má primárna forma s nefrotickým syndrómom</h2>

<p>Pri primárnej FSGS sa v publikovaných súboroch uvádza rekurencia <strong>u 30 až 60 %</strong> príjemcov. [2] Rozptyl súvisí aj s rozdielnou kvalitou vylúčenia sekundárnych a genetických príčin. Pri väčšine genetických foriem je riziko nízke a pri sekundárnej FSGS sa rekurencia pôvodného cirkulujúceho mechanizmu neočakáva. V štepe sa však môže nezávisle rozvinúť nová sekundárna FSGS.</p>

<p>Dôležitým údajom je prítomnosť nefrotického syndrómu pri pôvodnom ochorení. V kohorte TANGO <strong>nemal rekurenciu ani jeden z 22 pacientov</strong> s biopticky potvrdenou FSGS bez klinicko-patologických znakov sekundárnej príčiny a bez nefrotického syndrómu pri manifestácii. [2] Ide o malý súbor, nie o dôkaz absolútne nulového rizika.</p>

<p>Samotný histologický variant FSGS nie je spoľahlivým prediktorom rekurencie. Väčšiu hodnotu má etiologická klasifikácia, klinický fenotyp a podľa okolností genetické vyšetrenie.</p>

<h3>Skorá rekurencia sa môže prejaviť skôr než segmentálna skleróza</h3>

<p>Primárna FSGS môže recidivovať veľmi skoro po transplantácii, často náhlym vznikom výraznej proteinúrie. V počiatočnej biopsii ešte nemusí byť prítomná segmentálna skleróza – elektrónová mikroskopia však môže ukázať rozsiahle splývanie výbežkov podocytov.</p>

<p>Odborný prehľad odporúča u rizikových pacientov <strong>každodennú kvantifikáciu proteinúrie počas prvých 1 až 2 týždňov</strong> po transplantácii, s následným postupným predlžovaním intervalov. [2] Ide o praktické expertné odporúčanie, nie o režim overený randomizovanou štúdiou.</p>

<h3>Liečba zostáva prevažne empirická</h3>

<p>Najčastejšie používaným postupom je terapeutická výmena plazmy, často v kombinácii s rituximabom. Cieľom výmeny plazmy je odstrániť predpokladané cirkulujúce mediátory poškodenia podocytov.</p>

<p>Publikované odpovede na liečbu sú veľmi variabilné. Štúdie sa líšia definíciou remisie, načasovaním a intenzitou liečby aj doplnkovou imunosupresiou. Dosiahnutie remisie je spojené s priaznivejšou prognózou štepu, ale observačné výsledky neumožňujú spoľahlivo určiť prínos jednotlivých zložiek kombinovanej liečby. [2]</p>

<p>Pri <strong>profylaxii</strong> je stanovisko prehľadu jednoznačnejšie, než sa niekedy uvádza: <strong>žiadna štúdia nezistila významný účinok profylaktickej plazmaferézy na rekurentnú FSGS</strong> a autori odporúčajú predtransplantačnej liečbe zameranej na prevenciu rekurencie <strong>vyhnúť sa</strong>. [2] Nejde teda len o „nedostatočne doložený“ postup, ale o postup, proti ktorému sa prehľad explicitne vyslovuje. Individuálne rozhodnutie pri mimoriadne vysokom riziku patrí do transplantačného centra.</p>

<h3>Protilátky proti nefrínu sú sľubný smer, nie univerzálny test</h3>

<p>Východiskový vzdelávací program venuje pozornosť aj protilátkam proti nefrínu. [1] Tento smer výskumu môže pomôcť rozlíšiť imunologicky podmienené podocytopatie a lepšie charakterizovať časť pacientov s rizikom rekurencie.</p>

<p>Zatiaľ však nie je k dispozícii validovaný diagnostický prah ani záväzný liečebný algoritmus pre transplantovanú populáciu. Výsledok takého vyšetrenia preto nemožno používať ako jediný podklad na rozhodnutie o transplantácii alebo o profylaktickej liečbe.</p>

<p>Predchádzajúca strata štepu pre rekurentnú FSGS zvyšuje obavy pri ďalšej transplantácii. Nie je však automatickým dôvodom na definitívne vyradenie pacienta z transplantácie. Rozhodnutie musí zohľadniť predchádzajúci priebeh, odpoveď na liečbu, alternatívy a pri živom darcovstve aj záujmy a bezpečnosť darcu. [2]</p>

<h2>IgA nefropatia: zistená frekvencia závisí od biopsickej stratégie</h2>

<p>Rekurencia IgA nefropatie môže byť dlho klinicky nenápadná a jej zistená frekvencia zásadne závisí od toho, kedy sa biopsia vykonáva. Prehľad uvádza <strong>10 až 30 % v štúdiách s biopsiami indikovanými klinicky</strong> a <strong>25 až 53 % v štúdiách s protokolárnymi biopsiami</strong>. [2] Tieto rozpätia nemožno interpretovať ako rovnaké časovo ohraničené individuálne riziko.</p>

<p>Treba rozlišovať tri odlišné situácie:</p>

<ul>
  <li>histologický nález IgA depozitov bez klinických prejavov,</li>
  <li>rekurenciu s hematúriou alebo proteinúriou,</li>
  <li>progresívne ochorenie so zhoršovaním funkcie štepu.</li>
</ul>

<p>Nie každý histologický nález vedie k zlyhaniu transplantovanej obličky. Pri dlhšom sledovaní však rekurentná IgA nefropatia môže významne zhoršovať prognózu štepu. [2]</p>

<h3>Diagnostika sa nemôže opierať iba o hematúriu</h3>

<p>Podozrenie vyvoláva nová alebo narastajúca proteinúria, glomerulárna hematúria a nevysvetlený pokles funkcie štepu. <strong>Neprítomnosť hematúrie ochorenie nevylučuje.</strong></p>

<p>Pri interpretácii biopsie treba odlíšiť rekurenciu od nového IgA-dominantného ochorenia a podľa časového kontextu zohľadniť aj možnosť IgA depozitov prítomných už v darcovskej obličke. Histologický nález je potrebné posudzovať spolu s klinickým priebehom a vyšetrením možných súbežných príčin poškodenia.</p>

<h3>Liečba vyžaduje opatrný prenos poznatkov</h3>

<p>Základom klinického manažmentu je kontrola krvného tlaku a proteinúrie, podpora adherencie a primeraná transplantačná imunosupresia. Blokádu renínovo-angiotenzínového systému možno použiť podľa tolerancie, funkcie štepu a koncentrácie draslíka.</p>

<p>Samotná prítomnosť IgA depozitov bez klinickej aktivity nie je automatickým dôvodom na intenzifikáciu imunosupresie. Pri aktívnom alebo rýchlo progredujúcom priebehu treba individuálne zvážiť histologickú aktivitu, rozsah chronického poškodenia a riziko infekčných komplikácií.</p>

<p>Poznatky o cielene uvoľňovanom budezonide, sparsentáne, inhibítoroch komplementu a liekoch ovplyvňujúcich B-lymfocyty či plazmatické bunky pri <a href="article.php?slug=iga-nefropatia-kdigo-komentar-komplement-b-bunky-endotelin">primárnej IgA nefropatii</a> nemožno bez priameho overenia preniesť na príjemcov transplantovanej obličky. Podobne inhibítory SGLT2 nemožno označovať za preukázanú špecifickú liečbu rekurentnej IgA nefropatie.</p>

<h3>Kortikosteroidy a rekurencia: asociácia nie je dôkaz príčiny</h3>

<p>Niektoré registre naznačili nižšie riziko straty štepu pre rekurentnú IgA nefropatiu pri pokračovaní kortikosteroidov. Interpretáciu však obmedzujú rozdiely medzi skupinami, biopsická prax a neistota pri určovaní príčiny zlyhania štepu.</p>

<p>V kohorte TANGO bolo skoré vysadenie kortikosteroidov predpísané <strong>u 76 z 504 pacientov</strong> s IgA nefropatiou vlastných obličiek a v multivariabilnej analýze <strong>nebolo spojené s rekurenciou</strong> IgA nefropatie po transplantácii. [2] To nepreukazuje rovnakú bezpečnosť všetkých režimov u každého pacienta, oslabuje však kategorické tvrdenie, že vysadenie kortikosteroidov nevyhnutne vyvoláva rekurenciu.</p>

<h2>Praktické porovnanie</h2>

<div class="table-responsive" role="region" aria-label="Porovnanie C3 glomerulopatie, primárnej FSGS a IgA nefropatie z hľadiska rekurencie po transplantácii obličky" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Charakteristika</th>
      <th scope="col">C3 glomerulopatia</th>
      <th scope="col">Primárna FSGS</th>
      <th scope="col">IgA nefropatia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Pretrvávajúci mechanizmus</th>
      <td>Dysregulácia alternatívnej cesty komplementu</td>
      <td>Predpokladané cirkulujúce mediátory poškodenia podocytov</td>
      <td>Tvorba a ukladanie patogénnych IgA imunokomplexov</td>
    </tr>
    <tr>
      <th scope="row">Uvádzaná frekvencia rekurencie</th>
      <td>Vysoká; jediné univerzálne percento je zavádzajúce</td>
      <td>30 až 60 %</td>
      <td>10 až 30 % (klinicky indikované biopsie) / 25 až 53 % (protokolárne biopsie)</td>
    </tr>
    <tr>
      <th scope="row">Typický časový obraz</th>
      <td>Možná skorá histologická rekurencia</td>
      <td>Často prvé dni až týždne</td>
      <td>Často postupný nález počas rokov</td>
    </tr>
    <tr>
      <th scope="row">Významný klinický signál</th>
      <td>Proteinúria, hematúria, zhoršenie funkcie</td>
      <td>Náhla výrazná proteinúria</td>
      <td>Proteinúria, hematúria alebo pokles funkcie</td>
    </tr>
    <tr>
      <th scope="row">Diagnostická osobitosť</th>
      <td>Nevyhnutná imunofluorescencia a elektrónová mikroskopia</td>
      <td>Včas môže chýbať segmentálna skleróza</td>
      <td>Histologický nález nemusí znamenať klinicky aktívne ochorenie</td>
    </tr>
    <tr>
      <th scope="row">Zásadné obmedzenie liečby</th>
      <td>Priame dôkazy len z malej štúdie fázy 2 s náhradným ukazovateľom</td>
      <td>Prevažne observačné údaje; profylaxia sa neodporúča</td>
      <td>Obmedzené priame dôkazy pre špecifickú liečbu v štepe</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Čo z toho vyplýva pre transplantačnú prax</h2>

<p>Riziko rekurencie sa má hodnotiť individuálne a ešte pred transplantáciou. Pri FSGS je rozhodujúce odlíšiť primárnu, genetickú a sekundárnu príčinu. Pri C3 glomerulopatii treba charakterizovať poruchu komplementu a možné pridružené ochorenia vrátane monoklonálnej gamapatie. Pri IgA nefropatii je potrebné počítať s tým, že klinický význam rekurencie sa môže prejaviť až počas dlhodobého sledovania.</p>

<p>Po transplantácii má najväčšiu hodnotu sledovanie trendov proteinúrie a funkcie štepu, včasná biopsia pri odôvodnenom podozrení a spoločná interpretácia nálezu transplantačným nefrológom a nefropatológom. Liečbu nemožno určovať iba podľa názvu diagnózy – rozhoduje aktivita ochorenia, rozsah nezvratného poškodenia, dostupnosť priamych dôkazov a bezpečnosť ďalšej imunosupresívnej alebo komplementovej intervencie.</p>

<h2>Limity</h2>

<p>Článok zhŕňa prehľadové a expertné odporúčania, nie výsledky veľkých randomizovaných štúdií. Uvádzané frekvencie rekurencie pochádzajú z observačných súborov s rozdielnou biopsickou praxou a dĺžkou sledovania; nejde o individuálne riziko konkrétneho pacienta. Údaj o nulovej rekurencii u pacientov s FSGS bez nefrotického syndrómu sa opiera o 22 pacientov. Priame údaje o inhibícii komplementu v transplantovanej populácii pochádzajú z jednej otvorenej štúdie fázy 2 s trinástimi pacientmi a histologickým náhradným ukazovateľom. Odporúčania týkajúce sa monitorovania proteinúrie majú charakter expertného konsenzu.</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska.</em></p>

<h2>Literatúra</h2>

<p><em>1. Rupprecht H, Müller-Deile J, Seikrit C. Rekurrenz der Grundkrankheit nach Transplantation. NephroLIVE, streamed-up.com; vedecké vedenie Mario Schiffer (Universitätsklinikum Erlangen). Program v trvaní 89 minút: C3 glomerulonefritída (H. Rupprecht, Klinikum Bayreuth), FSGS (J. Müller-Deile, Universitätsklinikum Erlangen), IgA nefropatia (C. Seikrit, Uniklinik RWTH Aachen). <a href="https://streamed-up.com/video/rekurrenz-der-grundkrankheit-nach-transplantation" target="_blank" rel="noopener noreferrer">Verejná stránka vzdelávacieho programu</a>. Mená prednášajúcich, ich pracoviská, vedecké vedenie aj členenie programu boli overené na verejne dostupnej stránke; zdrojom bola anotácia a program, nie obsah videa.</em></p>

<p><em>2. Uffing A, Hullekes F, Riella LV, Hogan JJ. Recurrent Glomerular Disease after Kidney Transplantation: Diagnostic and Management Dilemmas. Clinical Journal of the American Society of Nephrology. 2021;16(11):1730–1742. <a href="https://doi.org/10.2215/CJN.00280121" target="_blank" rel="noopener noreferrer">DOI: 10.2215/CJN.00280121</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/34686531/" target="_blank" rel="noopener noreferrer">PubMed, PMID 34686531</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8729409/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>.</em></p>

<p><em>3. Bomback AS, Daina E, Remuzzi G, Kanellis J, Kavanagh D, Pickering MC, Sunder-Plassmann G, Walker PD, Wang Z, Ahmad Z, Fakhouri F. Efficacy and Safety of Pegcetacoplan in Kidney Transplant Recipients With Recurrent Complement 3 Glomerulopathy or Primary Immune Complex Membranoproliferative Glomerulonephritis. Kidney International Reports. 2025;10(1):87–98. <a href="https://doi.org/10.1016/j.ekir.2024.09.030" target="_blank" rel="noopener noreferrer">DOI: 10.1016/j.ekir.2024.09.030</a> · <a href="https://pubmed.ncbi.nlm.nih.gov/39810766/" target="_blank" rel="noopener noreferrer">PubMed, PMID 39810766</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11725963/" target="_blank" rel="noopener noreferrer">voľne dostupný plný text</a>. Štúdia NOBLE, NCT04572854.</em></p>

<p><em><strong>Poznámka k dôkazom.</strong> Bibliografické údaje zdrojov č. 2 a 3 vrátane úplného autorského zoznamu, ročníka, čísla a strán boli overené cez PubMed; plné texty oboch prác sú voľne dostupné v PubMed Central. Číselné údaje o frekvencii rekurencie, kohorte TANGO, monitorovaní proteinúrie a profylaktickej plazmaferéze boli načítané priamo z plného textu zdroja č. 2; výsledky štúdie NOBLE zo štruktúrovaného abstraktu zdroja č. 3. Rozdelenie na úrovne dôkazov, kritické zhodnotenie dizajnu štúdie NOBLE, porovnávacia tabuľka a sekcia Limity sú vlastným odborným spracovaním autora projektu.</em></p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=c3-glomerulopatia-c3g-liecba-inhibicia-komplementu">C3 glomerulopatia: liečba a inhibícia komplementu</a></li>
  <li><a href="article.php?slug=biopsia-obliciek-glomerularne-ochorenia">Biopsia obličiek pri glomerulárnych ochoreniach</a></li>
  <li><a href="article.php?slug=retransplantacia-obliciek-po-zlyhani-stepu-prekazky">Retransplantácia obličky po zlyhaní štepu: prekážky</a></li>
  <li><a href="article.php?slug=transplantacia-oblicky-zaradenie-do-programu">Transplantácia obličky: zaradenie do programu</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
);

foreach ($articles as $a) {
    try {
        $stmt->execute([
            'title'        => $a['title'],
            'slug'         => $a['slug'],
            'author'       => $a['author'],
            'content'      => $a['content'],
            'excerpt'      => $a['excerpt'],
            'published_at' => $a['published_at'],
            'is_top'       => $a['is_top'],
        ]);
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_zelatina_idh newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_zelatina_idh pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_zelatina_idh pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_rekurencia_gn_tx migration error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Migrácia článku: " . $articles[0]['title'] . "\n";
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
