<?php
/**
 * add_lupusova-nefritida-liecit-hned-biopsiu-co-najskor_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový skript na vloženie/aktualizáciu článku do DB (idempotentný UPSERT).
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_lupusova-nefritida-liecit-hned-biopsiu-co-najskor_article.php"
 * ════════════════════════════════════════════════════════════════════════════
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Lupusová nefritída: liečiť hneď, biopsiu vykonať čo najskôr',
    'slug'         => 'lupusova-nefritida-liecit-hned-biopsiu-co-najskor',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Biopsiu obličky urobiť vždy, keď sa dá – ale nečakať na ňu so začiatkom liečby. Prehľad dôkazov za skorú imunosupresiu, miesto opakovanej biopsie, limitov konvenčných biomarkerov a rozdielov medzi odporúčaniami ACR, EULAR a KDIGO.',
    'content'      => <<<'HTML'
<p>Otázka „biopsia najprv, alebo liečba najprv?“ patrí pri lupusovej nefritíde (LN) medzi najdiskutovanejšie v klinickej praxi. Odpoveď, ku ktorej sa v posledných rokoch priklonili odborné spoločnosti aj panelové diskusie, znie nepríjemne prakticky: <strong>biopsiu urobiť vždy, keď sa dá – ale nečakať na ňu s liečbou</strong>. Nasledujúci text zhŕňa dôkazy, o ktoré sa toto stanovisko opiera, aktuálne odporúčania ACR, EULAR a KDIGO, ako aj miesto opakovanej biopsie, biomarkerov a nových kombinovaných režimov.</p>

<h2>Prečo na tom záleží: rozsah problému</h2>

<p>Systémový lupus erythematosus (SLE) postihuje obličky približne u <strong>polovice pacientov</strong>, pričom v niektorých populáciách – najmä u osôb afrického a ázijského pôvodu – prevalencia stúpa až na <strong>70 %</strong>. Renálne postihnutie zostáva jedným z hlavných determinantov morbidity a mortality pri SLE.</p>

<p>Prognóza je pritom silne viazaná na <strong>rýchlosť a úplnosť odpovede</strong> na úvodnú liečbu. V dlhodobo sledovanej hongkonskej kohorte 176 pacientov s biopsiou potvrdenou LN (priemerné sledovanie 15,3 roka) dosiahlo 43,8 % pacientov modifikovanú kompletnú renálnu odpoveď (mCRR) dva roky po biopsii – a práve táto skupina mala výrazne lepšie dlhodobé prežívanie obličiek (92,2 % oproti 71,7 % u nerespondérov). Dosiahnutie mCRR bolo spojené s <strong>86 % znížením</strong> upraveného rizika zlyhania obličiek.</p>

<p>Zároveň platí, že benígny priebeh je skôr výnimkou. V torontskej kohorte 374 pacientov s LN malo <strong>len 25,7 %</strong> tzv. responzívny monofázický priebeh (úplná úprava proteinúrie do 1 roka, resp. do 2 rokov pri nefrotickej proteinúrii, bez následného renálneho relapsu) – a aj z nich 18,8 % napokon zaznamenalo nepriaznivú dlhodobú udalosť. Predpovedať na začiatku, ktorý pacient bude mať priaznivý priebeh, je teda prakticky nemožné.</p>

<h2>Biopsia obličky: nenahraditeľná, ale nie za cenu odkladu liečby</h2>

<h3>Prečo biopsia zostáva zlatým štandardom</h3>

<p>Renálna biopsia umožňuje stanoviť histologickú triedu, oddelene kvantifikovať <strong>aktivitu a chronicitu</strong> a vylúčiť iné príčiny glomerulového postihnutia. Histologická klasifikácia vychádza z delenia Medzinárodnej spoločnosti pre nefrológiu a Spoločnosti pre renálnu patológiu (ISN/RPS) z roku 2003: trieda I (minimálna mezangiálna), II (mezangiálna proliferatívna), III (fokálna), IV (difúzna), V (membranózna) a VI (pokročilá sklerotizujúca).</p>

<p>Dôležité je, že táto klasifikácia bola v roku <strong>2018 podstatne revidovaná</strong>: zrušilo sa delenie triedy IV na segmentálnu (IV-S) a globálnu (IV-G), upravili sa definície mezangiálnej hypercelularity a semilunarov, pojem „endokapilárna proliferácia“ bol nahradený <strong>endokapilárnou hypercelularitou</strong> a namiesto označení „aktívna/chronická“ sa pre všetky triedy zaviedli modifikované <strong>indexy aktivity a chronicity podľa NIH</strong>. Tieto indexy sú dnes základom rozhodovania o intenzite imunosupresie a mali by byť v histologickom náleze uvedené.</p>

<h3>Kontraindikácie a dostupnosť</h3>

<p>Biopsia je u stabilného pacienta výkonom s nízkym rizikom. Prekážkou môžu byť nekorigovaná koagulopatia alebo výrazná trombocytopénia, nekontrolovaná hypertenzia, aktívna infekcia (najmä pyelonefritída), solitárna oblička, malé hyperechogénne obličky s pokročilou chronickou zmenou, prípadne nespolupracujúci pacient. V reálnej praxi však býva najčastejším limitom <strong>dostupnosť výkonu a nefropatológa</strong>, nie medicínska kontraindikácia – a práve tu vzniká klinická dilema.</p>

<h3>Dilema: čakať, alebo nečakať?</h3>

<p>Táto otázka bola témou panelovej diskusie na 43. brazílskom reumatologickom kongrese (Curitiba, 2. – 5. septembra 2026). <strong>Evandro Mendes Klumb</strong> (Reumatologická jednotka, Štátna univerzita v Rio de Janeiro; Komisia pre lupus Brazílskej reumatologickej spoločnosti) argumentoval, že liečba nesmie čakať na biopsiu: presnosť odvodenia histologickej triedy zo samotných klinických a laboratórnych parametrov je nedokonalá a odklad liečby môže znamenať nevratnú stratu funkcie obličiek u mladého človeka. <strong>Edgard Torres dos Reis Neto</strong> (Paulistická lekárska fakulta Federálnej univerzity v São Paule) na druhej strane zdôraznil nezastupiteľnosť biopsie a potrebu odstraňovať bariéry v prístupe k nej.</p>

<p>Klumbovo zhrnutie po diskusii formuluje kompromis, ktorý sa medzičasom stal prevažujúcim postojom: <em>„Stopercentne správna odpoveď neexistuje – biopsiu robíme vždy, keď je to možné, ale nemôžeme čakať na jej výsledok, aby sme začali liečbu.“</em></p>

<p>Nejde o názor jednotlivcov. <strong>II. konsenzus Brazílskej reumatologickej spoločnosti pre LN</strong> (2024), na ktorom sa obaja diskutujúci autorsky podieľali, uvádza priamo, že biopsia je zlatým štandardom diagnostiky, ale <strong>ak nie je dostupná alebo je kontraindikovaná, terapeutické rozhodnutie sa má oprieť o klinické a laboratórne parametre</strong>. Podobne ACR aj KDIGO pripúšťajú podanie pulzných glukokortikoidov na potlačenie akútneho zápalu už pri dôvodnom podozrení na LN, teda ešte pred histologickým potvrdením.</p>

<p><strong>Praktický dôsledok:</strong> podozrenie na LN (novovzniknutá proteinúria ≥ 0,5 g/g kreatinínu, aktívny močový sediment alebo nevysvetlený pokles eGFR u pacienta s SLE) je dôvodom na <strong>urgentné objednanie biopsie a súčasné začatie liečby</strong>, nie na sekvenčný postup. Biopsia následne určí, či a ako sa v imunosupresii pokračuje.</p>

<h2>Klinické markery a ich limity</h2>

<h3>Konvenčné biomarkery</h3>

<p>Proteinúria, močový sediment, hladiny komplementu (C3, C4) a protilátky proti dvojvláknovej DNA (anti-dsDNA) majú z konvenčných markerov najsilnejší dôkazový základ. Ich rozlišovacia schopnosť voči histológii je však obmedzená.</p>

<p>Systematický prehľad, ktorý pripravoval podklad pre aktualizáciu odporúčaní EULAR, to formuluje jednoznačne: pacienti s SLE a <strong>nízkostupňovou proteinúriou (&lt; 500 – 1000 mg/deň) a/alebo hematúriou môžu mať histologicky aktívne ochorenie</strong> (dôkazy strednej kvality). Inými slovami – „normálne“ laboratórium nevylučuje aktívnu nefritídu.</p>

<p>Rovnaký nesúlad potvrdila aj pediatrická kohorta 30 detí s proliferatívnou LN a sériovými biopsiami: rok po iniciálnej biopsii malo <strong>pretrvávajúcu proliferatívnu nefritídu 11 z 18 detí v kompletnej renálnej odpovedi</strong> (a 11 z 12 detí v inkompletnej odpovedi). Výsledok biopsie priamo zmenil rozhodnutie u 7 z 18 pacientov v kompletnej odpovedi – buď sa liečba eskalovala, alebo sa nepristúpilo k plánovanej redukcii.</p>

<h3>Nové biomarkery</h3>

<p>Sérová proteomika identifikovala <strong>ICAM2 (CD102)</strong> ako nádejný marker proliferatívnej LN: v nezávislej validačnej kohorte dosiahol pri odlíšení LN od zdravých kontrol plochu pod krivkou (AUC) <strong>0,92</strong> a koreloval s indexom aktivity, proteinúriou, albumínom a hladinou anti-dsDNA. V odlíšení proliferatívnej od neproliferatívnej LN prekonal konvenčné parametre a jeho expresia bola zvýšená aj v renálnom tkanive.</p>

<p>Z talianskej štúdie Zeus vychádza iná dvojica kandidátov – <strong>anti-ENO1</strong> (proti α-enoláze) a <strong>anti-H2A</strong> (proti histónu 2A) v triede IgG2. Ich hladiny kopírovali proteinúriu (vysoké pri nástupe renálnych príznakov, normalizované po <strong>12 mesiacoch</strong> liečby), zatiaľ čo anti-dsDNA a anti-C1q IgG2 zostávali zvýšené počas celého obdobia sledovania. Obe protilátky boli asociované s proteinúriou &gt; 1 g aj s poklesom eGFR pod 60 ml/min/1,73 m².</p>

<p>Žiadny z týchto markerov zatiaľ biopsiu nenahrádza. Ich reálnou perspektívou je skôr <strong>neinvazívne sledovanie</strong> – teda rozhodovanie o tom, kedy biopsiu zopakovať.</p>

<h2>Opakovaná biopsia: kedy a prečo</h2>

<h3>Indikácie</h3>

<p>Podľa odporúčaní ACR má opakovaná biopsia miesto u pacienta v remisii s podozrením na renálny relaps (vzostup proteinúrie, hematúria a/alebo zhoršenie funkcie obličiek) a u pacienta, ktorý napriek <strong>≥ 6 mesiacom adekvátnej liečby</strong> má pretrvávajúcu alebo progredujúcu proteinúriu, hematúriu či klesajúcu funkciu obličiek. EULAR odporúča rebiopsiu pri zhoršení, refraktérnosti na štandardnú liečbu a pri relapsoch – na zachytenie zmeny alebo progresie histologickej triedy.</p>

<h3>Čo opakovaná biopsia reálne prináša</h3>

<p>Retrospektívna kohorta 370 pacientov s biopsiou potvrdenou LN je v tomto smere poučná. Klinicky indikovanú druhú biopsiu podstúpilo <strong>122 pacientov (33 %)</strong> – pre akútny renálny relaps, pretrvávajúcu aktivitu alebo podozrenie na progresiu. K <strong>histologickej transformácii došlo v 68 % opakovaných biopsií</strong> a podiel zmiešaných tried stúpol zo 7,4 % na 22,9 % (p &lt; 0,05). Nález viedol k <strong>okamžitej zmene liečby u 82,8 % pacientov</strong>, najčastejšie k jej intenzifikácii pri aktívnej proliferatívnej transformácii.</p>

<p>Jediným nezávislým klinickým prediktorom podstúpenia druhej biopsie bolo <strong>dlhšie trvanie SLE</strong> (22,2 ± 4,96 vs. 17,2 ± 6,29 roka; upravené OR = 1,15; 95 % IS: 1,06 – 1,25), zatiaľ čo <strong>východisková proliferatívna LN</strong> nezávisle predpovedala aktívne ochorenie pri rebiopsii (upravené OR = 2,42; 95 % IS: 1,09 – 5,38). Autori zároveň korektne upozorňujú, že z retrospektívneho dizajnu nemožno odvodiť prínos pre dlhodobé prežívanie.</p>

<p>Menšia, no obsahovo cenná španielska kohorta (19 pacientov, 45 natívnych biopsií, 2003 – 2025) ukazuje ešte jeden rozmer. Najčastejšou indikáciou bolo sérologické a/alebo proteinurické zhoršenie; pri porovnaní indexovej a poslednej biopsie sa histologická alebo diagnostická zmena zistila u <strong>14 z 19 pacientov (73,7 %)</strong>. Kľúčové je, že u <strong>3 z 19 (15,8 %)</strong> išlo o diagnózu <strong>nezlučiteľnú s aktívnou lupusovou nefritídou</strong> – rebiopsia teda nechráni len pred poddávkovaním imunosupresie, ale aj pred jej zbytočným stupňovaním.</p>

<h3>Protokolárna biopsia</h3>

<p>Otázka biopsie „podľa protokolu“ (bez klinickej indikácie) zostáva otvorená. Pediatrické údaje podporujú zváženie kontrolnej biopsie <strong>rok po iniciálnej biopsii aj u detí v kompletnej renálnej odpovedi</strong>, práve preto, že dostupné laboratórne markery deti s pretrvávajúcou proliferatívnou nefritídou nezachytia. U dospelých systematický prehľad EULAR uzatvára, že úlohu protokolárnej rebiopsie musia potvrdiť kvalitnejšie štúdie.</p>

<h2>Liečba: posun ku kombinovaným režimom</h2>

<h3>Spoločný dôkazový základ</h3>

<p>Systematický prehľad pre EULAR preukázal na základe vysokokvalitných randomizovaných štúdií, že <strong>kombinácia dvoch imunosupresívnych látok</strong> – belimumab s mykofenolát-mofetilom (MMF) alebo cyklofosfamidom, voklosporín s MMF, prípadne obinutuzumab s MMF – vedie k <strong>vyššej miere renálnej odpovede</strong> než predchádzajúci štandard. Prehľad zároveň potvrdil súvislosť medzi kompletnou alebo parciálnou odpoveďou v prvých 6 – 12 mesiacoch a dlhodobým prežívaním obličiek, a naopak spojitosť medzi vysadením liečby a rizikom relapsu.</p>

<h3>V čom sa odporúčania rozchádzajú</h3>

<div class="table-responsive" role="region" aria-label="Porovnanie odporúčaní ACR, EULAR a KDIGO pri proliferatívnej lupusovej nefritíde" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Oblasť</th>
      <th scope="col">ACR (2024, publ. 2025)</th>
      <th scope="col">EULAR (2025)</th>
      <th scope="col">KDIGO (2024)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Úvodný režim</th>
      <td>Pulzné glukokortikoidy + <strong>dve</strong> imunosupresívne látky (napr. MMF s belimumabom alebo s kalcineurínovým inhibítorom)</td>
      <td>Jednozložková alebo <strong>včasná kombinovaná</strong> liečba podľa závažnosti; ako jediné zahŕňa aj MMF + obinutuzumab</td>
      <td>Pripúšťa aj dvojkombináciu s nízkodávkovým cyklofosfamidom alebo MMF ako prvú líniu</td>
    </tr>
    <tr>
      <th scope="row">Rámec liečby</th>
      <td>Liečba ako <strong>kontinuum</strong> – nedelí sa na indukciu a udržiavanie</td>
      <td>Míľniky odpovede a jasné pravidlá detrakcie glukokortikoidov</td>
      <td>Klasickejšie delenie, dôraz na podrobné „kompartmentové“ histologické hodnotenie</td>
    </tr>
    <tr>
      <th scope="row">Trvanie</th>
      <td><strong>3 – 5 rokov</strong> pri dosiahnutí kompletnej renálnej odpovede</td>
      <td>Individualizované; vysadenie je spojené s rizikom relapsu</td>
      <td>Individualizované podľa rizikového profilu</td>
    </tr>
    <tr>
      <th scope="row">Glukokortikoidy</th>
      <td colspan="3">Zhoda naprieč všetkými: čo najnižšia dávka, rýchla detrakcia, cieľom je ich úplné vysadenie</td>
    </tr>
  </tbody>
</table>
</div>

<p>ACR predložil 28 hodnotených odporúčaní (7 silných, 21 podmienených) a 13 nehodnotených vyhlásení správnej praxe. EULAR sa zhodol na 4 zastrešujúcich princípoch a 13 odporúčaniach. Americký komentár KDOQI ku KDIGO (2026) k tomu dodáva dôležitý kontext: od vydania odporúčaní KDIGO schválil americký úrad FDA <strong>obinutuzumab</strong> – popri belimumabe a voklosporíne – na liečbu LN a do praxe vstupujú prvé klinické štúdie s <strong>CAR-T bunkovou terapiou</strong> pri autoimunitných ochoreniach vrátane SLE.</p>

<h3>Patofyziologicky ukotvená liečba</h3>

<p>Prehľad publikovaný v časopise <em>Nature Reviews Nephrology</em> tento posun rámcuje ako prechod od potláčania zápalu k <strong>modifikácii ochorenia</strong>. Porucha odstraňovania jadrových autoantigénov vedie k nadmernej signalizácii Toll-like receptorov, upregulácii interferónových dráh a hyperaktivácii B-lymfocytov; tieto procesy udržiavajú tvorbu autoprotilátok a aktiváciu komplementu. Rýchlo účinkujúce glukokortikoidy a antiproliferatívne látky preto slúžia na rýchle zvládnutie systémového zápalu, no <strong>včasné pridanie imunomodulačnej liečby</strong> je podľa autorov rozhodujúce pre trvalú remisiu – namiesto doterajšej stratégie postupného prepínania a pridávania liekov metódou pokusu a omylu.</p>

<h3>Argument proti plošnej trojkombinácii</h3>

<p>Posun k intenzívnejším režimom nie je bez oponentov. V časopise <em>Kidney International</em> prebehla v roku 2026 výmena názorov, v ktorej sa upozorňuje, že <strong>nie každý novodiagnostikovaný pacient s LN potrebuje trojitú imunosupresiu</strong>. Pacienti liečení v dobre organizovaných centrách dosahujú vysoké miery kompletnej remisie aj pri dvojkombinácii a prínos tretej látky u nich nemusí byť rovnaký ako v pivotných randomizovaných štúdiách, do ktorých boli zaraďovaní pacienti so závažnejším fenotypom. Argument nespochybňuje účinnosť kombinovanej liečby – upozorňuje na <strong>pomer rizika a prínosu</strong>, náklady, kumulatívnu toxicitu a regionálnu dostupnosť liekov.</p>

<h3>Prebiehajúce štúdie</h3>

<p>Otázku optimálnej kombinácie majú pomôcť zodpovedať prebiehajúce štúdie 4. fázy. <strong>SYNERGY</strong> (NCT07225387, 30 pacientov) hodnotí kombináciu belimumabu a voklosporínu pri proliferatívnych formách lupusovej glomerulopatie. Rozsiahlejšia štúdia <strong>PRESERVE</strong> (NCT07611214, plánovaných 150 pacientov, 27 centier) porovnáva voklosporín v kombinácii s belimumabom, obinutuzumabom alebo anifrolumabom pri navodení rýchlej renálnej odpovede. Výsledky sa očakávajú v rokoch 2027 – 2029.</p>

<h2>Hydroxychlorochín: základ, ktorý sa nevynecháva</h2>

<p>Hydroxychlorochín (HCQ) zostáva základnou liečbou SLE aj LN a má ho dostať každý pacient, u ktorého nie je kontraindikovaný. Korektné je pritom pomenovať silu dôkazov: prehľad v časopise <em>Kidney360</em> konštatuje, že podklady pre terapeutický prínos HCQ <strong>špecificky pri LN</strong> pochádzajú prevažne z observačných štúdií realizovaných ešte pred spresnením moderných imunosupresívnych protokolov. Napriek tejto obmedzenej kvalite dôkazov nefrologická komunita jeho plošné používanie pri LN široko podporuje a odporúčania ho konzistentne obsahujú. Pozornosť si vyžaduje kumulatívna dávka a retinálna toxicita, čo podčiarkuje potrebu individualizovaného dávkovania a pravidelného oftalmologického sledovania.</p>

<h2>Zhrnutie pre prax</h2>

<ul>
  <li>Pri dôvodnom podozrení na LN <strong>začni liečbu a súčasne urgentne objednaj biopsiu</strong> – nie sekvenčne.</li>
  <li><strong>Normálne laboratórium nevylučuje aktívnu nefritídu</strong>: histologicky aktívne ochorenie sa vyskytuje aj pri proteinúrii pod 0,5 – 1 g/deň.</li>
  <li>Odpoveď v prvých <strong>6 – 24 mesiacoch</strong> je najsilnejším modifikovateľným prediktorom dlhodobého prežívania obličiek – oplatí sa o ňu bojovať intenzívne a včas.</li>
  <li>Pri pretrvávajúcej či zhoršujúcej sa proteinúrii po <strong>≥ 6 mesiacoch</strong> adekvátnej liečby, pri podozrení na relaps alebo pri refraktérnosti zváž <strong>rebiopsiu</strong> – mení liečbu vo väčšine prípadov a niekedy odhalí inú diagnózu.</li>
  <li>Kombinovaná imunosupresia je dnes štandardom pri proliferatívnej LN, <strong>voľba konkrétneho režimu však patrí individualizácii</strong> – podľa závažnosti, komorbidít, reprodukčných plánov, dostupnosti liekov a preferencií pacienta.</li>
  <li>Glukokortikoidy v <strong>čo najnižšej dávke a čo najkratšie</strong>; hydroxychlorochín u každého pacienta bez kontraindikácie.</li>
</ul>

<h2>Záver</h2>

<p>Liečbu lupusovej nefritídy treba začať promptne, bez čakania na výsledok renálnej biopsie – biopsia však zostáva nenahraditeľným diagnostickým a prognostickým nástrojom, ktorý má byť vykonaný čo najskôr. Aktuálne odporúčania ACR, EULAR aj KDIGO sa zhodujú na skorej kombinovanej imunosupresii, minimalizácii glukokortikoidov a individualizovanom prístupe; rozchádzajú sa v tom, aký agresívny má byť úvodný režim.</p>

<p>Opakovaná biopsia zostáva pre rozhodovanie o intenzifikácii alebo redukcii imunosupresie kľúčová práve preto, že klinické a sérologické markery histológiu spoľahlivo nenahradia. Nové biomarkery a cielené terapie tento priestor postupne rozširujú, no ich dlhodobú účinnosť a bezpečnosť ešte treba potvrdiť. Integrácia klinických, laboratórnych a histologických údajov tak zostáva jadrom starostlivosti o pacienta s lupusovou nefritídou.</p>

<hr>

<h2>Zdroje</h2>

<ol>
  <li>Klumb EM, Reis Neto ETD. <em>Lupus Nephritis: Treat Now, Biopsy Later?</em> Panel ReumaFights, 43. brazílsky reumatologický kongres, Curitiba, 2. – 5. septembra 2026. Medscape, 22. septembra 2026. <a href="https://www.medscape.com/viewarticle/lupus-nephritis-treat-now-biopsy-later-2026a1000z7p" target="_blank" rel="noopener noreferrer">medscape.com</a></li>
  <li>Reis-Neto ETD, Seguro LPC, Sato EI, a kol. II Brazilian Society of Rheumatology consensus for lupus nephritis diagnosis and treatment. <em>Adv Rheumatol</em>. 2024;64(1):48. <a href="https://doi.org/10.1186/s42358-024-00386-8" target="_blank" rel="noopener noreferrer">doi:10.1186/s42358-024-00386-8</a></li>
  <li>Sammaritano LR, Askanase A, Bermas BL, a kol. 2024 American College of Rheumatology (ACR) Guideline for the Screening, Treatment, and Management of Lupus Nephritis. <em>Arthritis Rheumatol</em>. 2025;77(9):1115–1135. <a href="https://doi.org/10.1002/art.43212" target="_blank" rel="noopener noreferrer">doi:10.1002/art.43212</a> (paralelne <em>Arthritis Care Res</em>. 2025;77(9):1045–1065, <a href="https://doi.org/10.1002/acr.25528" target="_blank" rel="noopener noreferrer">doi:10.1002/acr.25528</a>)</li>
  <li>Fanouriakis A, Kostopoulou M, Anders HJ, a kol. EULAR recommendations for the management of systemic lupus erythematosus with kidney involvement: 2025 update. <em>Ann Rheum Dis</em>. 2026;85(1):75–90. <a href="https://doi.org/10.1016/j.ard.2025.09.007" target="_blank" rel="noopener noreferrer">doi:10.1016/j.ard.2025.09.007</a></li>
  <li>Kostopoulou M, Bertsias G, Scirè CA, Boumpas DT, Fanouriakis A. Management of systemic lupus erythematosus with kidney involvement: systematic literature review to inform the 2025 update of EULAR recommendations. <em>EULAR Rheumatol Open</em>. 2025;1(3):210–219. <a href="https://doi.org/10.1016/j.ero.2025.07.006" target="_blank" rel="noopener noreferrer">doi:10.1016/j.ero.2025.07.006</a></li>
  <li>KDIGO 2024 Clinical Practice Guideline for the Management of Lupus Nephritis. <em>Kidney Int</em>. 2024;105(1S):S1–S69. <a href="https://doi.org/10.1016/j.kint.2023.09.002" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2023.09.002</a></li>
  <li>Rovin BH, Ayoub IM, Chan TM, a kol. Executive summary of the KDIGO 2024 Clinical Practice Guideline for the Management of Lupus Nephritis. <em>Kidney Int</em>. 2024;105(1):31–34. <a href="https://doi.org/10.1016/j.kint.2023.09.001" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2023.09.001</a></li>
  <li>Norouzi S, Contreras GN. KDOQI US Commentary on the KDIGO 2024 Clinical Practice Guideline for the Management of Lupus Nephritis. <em>Am J Kidney Dis</em>. 2026;88(2):179–195. <a href="https://doi.org/10.1053/j.ajkd.2026.05.002" target="_blank" rel="noopener noreferrer">doi:10.1053/j.ajkd.2026.05.002</a></li>
  <li>Bajema IM, Wilhelmus S, Alpers CE, a kol. Revision of the International Society of Nephrology/Renal Pathology Society classification for lupus nephritis: clarification of definitions, and modified National Institutes of Health activity and chronicity indices. <em>Kidney Int</em>. 2018;93(4):789–796. <a href="https://doi.org/10.1016/j.kint.2017.11.023" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2017.11.023</a></li>
  <li>Bedaiwi MK, Khalil N, Almaghlouth I, a kol. Value of Repeat Renal Biopsy in Lupus Nephritis: Histological Transitions, Treatment Impact, and Predictors of Repeat Biopsy and Active Disease. <em>Saudi J Kidney Dis Transpl</em>. 2026. <a href="https://doi.org/10.4103/sjkdt.sjkdt_152_26" target="_blank" rel="noopener noreferrer">doi:10.4103/sjkdt.sjkdt_152_26</a></li>
  <li>Patricio-Liébana M, Soler MJ, Gabaldón A, a kol. Repeat Kidney Biopsy in Lupus Nephritis: Diagnostic Yield and Clinical Utility in a Real-World Single-Centre Cohort. <em>J Clin Med</em>. 2026;15(14):5515. <a href="https://doi.org/10.3390/jcm15145515" target="_blank" rel="noopener noreferrer">doi:10.3390/jcm15145515</a></li>
  <li>Raschke R, Crane C, Sheets R, a kol. Incomplete concordance between laboratory and pathologic findings on post-induction kidney biopsy in pediatric patients with proliferative lupus nephritis. <em>Pediatr Nephrol</em>. 2025;40(9):2845–2854. <a href="https://doi.org/10.1007/s00467-025-06736-y" target="_blank" rel="noopener noreferrer">doi:10.1007/s00467-025-06736-y</a></li>
  <li>Yap DYH, Xu X, Juliao PC, a kol. Long-Term Kidney Outcome of Lupus Nephritis by Renal Response Status. <em>Kidney Int Rep</em>. 2024;9(12):3532–3541. <a href="https://doi.org/10.1016/j.ekir.2024.09.028" target="_blank" rel="noopener noreferrer">doi:10.1016/j.ekir.2024.09.028</a></li>
  <li>Kharouf F, Mehta P, Carrizo Abarza V, a kol. Responsive and monophasic lupus nephritis: prevalence, associations and outcomes. <em>Rheumatology (Oxford)</em>. 2025;64(8):4599–4606. <a href="https://doi.org/10.1093/rheumatology/keaf187" target="_blank" rel="noopener noreferrer">doi:10.1093/rheumatology/keaf187</a></li>
  <li>Li Z, Sun Y, Wang Y, a kol. Proteomics uncovers ICAM2 (CD102) as a novel serum biomarker of proliferative lupus nephritis. <em>Lupus Sci Med</em>. 2025;12(1):e001446. <a href="https://doi.org/10.1136/lupus-2024-001446" target="_blank" rel="noopener noreferrer">doi:10.1136/lupus-2024-001446</a></li>
  <li>Bruschi M, Alberici F, Moroni G, a kol. The landscape of serum autoantibodies in lupus nephritis. <em>Autoimmun Rev</em>. 2026;25(10):104128. <a href="https://doi.org/10.1016/j.autrev.2026.104128" target="_blank" rel="noopener noreferrer">doi:10.1016/j.autrev.2026.104128</a></li>
  <li>van Schaik M, van Kooten C, Arnaud L, a kol. Disease modification in lupus nephritis: towards a pathophysiology-based treatment paradigm. <em>Nat Rev Nephrol</em>. 2026;22(10):684–703. <a href="https://doi.org/10.1038/s41581-026-01103-y" target="_blank" rel="noopener noreferrer">doi:10.1038/s41581-026-01103-y</a></li>
  <li>Lichtnekert J, Anders HJ. Triple therapy is not required for all newly diagnosed cases of lupus nephritis. <em>Kidney Int</em>. 2026. <a href="https://doi.org/10.1016/j.kint.2026.06.011" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2026.06.011</a></li>
  <li>Floege J. Triple immunosuppressive therapy in active lupus nephritis: does one therapy really fit all? <em>Kidney Int</em>. 2026. <a href="https://doi.org/10.1016/j.kint.2026.07.003" target="_blank" rel="noopener noreferrer">doi:10.1016/j.kint.2026.07.003</a></li>
  <li>Caravaca-Fontán F, Yandian F, Zand L, Sethi S, Fervenza FC. Antimalarials in Lupus Nephritis: How Strong Is the Evidence? <em>Kidney360</em>. 2024;5(12):1938–1947. <a href="https://doi.org/10.34067/KID.0000000626" target="_blank" rel="noopener noreferrer">doi:10.34067/KID.0000000626</a></li>
  <li>Ponticelli C, Moroni G. Past, present and future of lupus nephritis. <em>Expert Rev Clin Immunol</em>. 2026;22(2):195–209. <a href="https://doi.org/10.1080/1744666X.2026.2637769" target="_blank" rel="noopener noreferrer">doi:10.1080/1744666X.2026.2637769</a></li>
  <li>ClinicalTrials.gov: <a href="https://clinicaltrials.gov/study/NCT07225387" target="_blank" rel="noopener noreferrer">SYNERGY (NCT07225387)</a>; <a href="https://clinicaltrials.gov/study/NCT07611214" target="_blank" rel="noopener noreferrer">PRESERVE (NCT07611214)</a></li>
</ol>

<hr>

<p><em><strong>Zdroj:</strong> Panelová diskusia „Lupus Nephritis: Treat Now, Biopsy Later?“, 43. brazílsky reumatologický kongres, Curitiba 2026 (Medscape). Obsah bol doplnený a overený voči primárnym publikáciám indexovaným v databáze PubMed a voči aktuálnym odporúčaniam ACR, EULAR a KDIGO.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_lupusova_nefritida_liecit_hned',
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
