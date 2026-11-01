<?php

/**
 * add_simplified-vitamin-d3-dialyza-mortalita_article.php
 * Odborný článok: štúdia SIMPLIFIED, vysokodávkový cholekalciferol u dialyzovaných
 * pacientov, celková mortalita, sekundárne ukazovatele a podskupiny.
 * Spracované zdroje: abstrakty FR-OR101 a FR-PO0503 (ASN Kidney Week 2026),
 * protokol štúdie (Trials 2025), správa Medscape Medical News (25. 10. 2026)
 * a odporúčania KDIGO 2017 pre CKD-MBD.
 * Avíza sa pri tomto článku zámerne NEposielajú ('enqueue_newsletter' => false).
 */

// Ochrana: len admin alebo CLI
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
    'title'        => 'Vysoké dávky vitamínu D3 na dialýze: čo štúdia SIMPLIFIED preukázala, čo iba naznačila a čo z toho platí pre prax',
    'slug'         => 'simplified-vitamin-d3-dialyza-mortalita',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Najväčšia randomizovaná štúdia cholekalciferolu u dialyzovaných pacientov nepredĺžila prežívanie. Prečo to nie je slabý výsledok, čo znamenajú signály v podskupinách a kde leží hranica medzi dôkazom a hypotézou.',
    'content'      => <<<'HTML'
<figure><a href="img/simplified-vitamin-d3-dialyza-mortalita.webp" rel="noopener noreferrer" target="_blank"><img src="img/simplified-vitamin-d3-dialyza-mortalita.webp" alt="Tmavá makrosnímka čelného rezu zväzku kapilár dialyzátora, nasvietená zľava, s teplým jantárovým svetlom v strede zväzku" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nejde o snímku konkrétneho prístroja ani pacienta. Zväzok kapilár dialyzátora: miesto, kde sa rozhoduje, čo z plazmy odíde a čo zostane.</figcaption></figure>

<p>Otázka bola jednoduchá a klinicky dôležitá: predĺži vysokodávkový vitamín D3 život pacientom na dialýze? Odpoveď zo štúdie SIMPLIFIED je nie. Štúdia randomizovala 3 866 dospelých dialyzovaných pacientov v 55 strediskách Spojeného kráľovstva medzi marcom 2017 a júlom 2025, podávala 60 000 IU cholekalciferolu ústne každé dva týždne a výsledok porovnávala so štandardnou starostlivosťou. Primárnym ukazovateľom bola celková mortalita.</p>

<p>Výsledok je zároveň menej jednoznačný, než znie prvá veta. V ramene s cholekalciferolom zomrelo 883 účastníkov (45,5 %), v ramene so štandardnou starostlivosťou 934 (48,5 %), pomer rizík 0,95 s 95 % intervalom spoľahlivosti 0,86 až 1,04 a p = 0,27. Interval spoľahlivosti pripúšťa aj 14 % zníženie rizika úmrtia. Štúdia teda účinok nepreukázala, nevyvrátila ho však s takou presnosťou, akú si sama naplánovala.</p>

<p>Tretia vrstva je najzradnejšia. Podskupinové analýzy naznačili nižšiu mortalitu u mužov a u nebelošských účastníkov, kompozit závažných kardiovaskulárnych príhod bol pri cholekalciferole menej častý. Práve tieto čísla sa najľahšie prečítajú ako návod na liečbu, hoci autori ich sami označili za hypotézu.</p>

<h2>Čo štúdia testovala a ako bola postavená</h2>

<p>SIMPLIFIED (Survival Improvement with Cholecalciferol in Patients on Dialysis) je pragmatická, multicentrická, otvorená randomizovaná štúdia s dvoma ramenami v pomere 1 : 1, stratifikovaná podľa strediska. Zaradila dospelých pacientov liečených dialýzou v 55 strediskách Spojeného kráľovstva.</p>

<p>Zaradených bolo 3 866 účastníkov: 1 940 dostávalo cholekalciferol 60 000 IU ústne každé dva týždne, 1 926 štandardnú starostlivosť. Medián veku bol 65 rokov, muži tvorili 68 %, belošského pôvodu bolo 80 % účastníkov, medián trvania dialyzačnej liečby bol 2,25 roka a diabetes malo 40 % účastníkov. Vylučovaní boli pacienti s pretrvávajúcou hyperkalciémiou, s príjmom viac ako 1 000 IU cholekalciferolu denne v predchádzajúcich 30 dňoch, gravidné ženy a pacienti s očakávaným prežívaním kratším ako šesť mesiacov.</p>

<p>Primárnym ukazovateľom bola celková mortalita. Sekundárne ukazovatele zahŕňali prvú hospitalizáciu pre kardiovaskulárnu príhodu, infekciu, zlomeninu a vopred určený kompozit závažných kardiovaskulárnych príhod (MACE: kardiovaskulárna smrť, infarkt myokardu, koronárna revaskularizácia, cievna mozgová príhoda a periférne artériové ochorenie).</p>

<p>Podstatný je spôsob zberu údajov. Úmrtia pochádzali z registra Office for National Statistics, sekundárne ukazovatele z administratívnych dát Hospital Episode Statistics. Štúdia teda nepostavila vlastnú dokumentáciu vedľa rutinnej starostlivosti, ale využila tú, ktorá už existovala. Preto mohla mať tisíce účastníkov a sledovanie do 7,5 roka za zlomok nákladov bežnej randomizovanej štúdie. Preto sú jej ukazovatele presné len do tej miery, do akej sú presné kódy a záznamy v jednotlivých nemocniciach.</p>

<h2>Či sa dávka vôbec dostala do krvi</h2>

<p>Skôr než sa interpretuje nulový výsledok, treba overiť, či intervencia fungovala.</p>

<p>U prvých 206 účastníkov, u ktorých sa koncentrácia 25(OH)D merala po štyroch mesiacoch, bol medián 141 nmol/l v ramene s cholekalciferolom a 36,5 nmol/l v ramene so štandardnou starostlivosťou. Dávka sa teda užila, vstrebala a substrát zvýšila približne štvornásobne, hlboko nad hranicu deficitu.</p>

<p>Tento údaj je pre interpretáciu rozhodujúci. Štúdia neporovnávala neliečený deficit s liečeným. Porovnávala bežnú starostlivosť s režimom, ktorý koncentráciu 25(OH)D spoľahlivo zvýšil, a napriek tomu nezmenil prežívanie. Námietka, že štúdia zlyhala pre nízke dodržiavanie liečby alebo pre poddávkovanie, preto v rovine substrátu neobstojí. Abstrakt presnú mieru dodržiavania liečby neuvádza, ale nameraná koncentrácia 25(OH)D svedčí o tom, že intervencia v sledovanej skupine fungovala.</p>

<h2>Výsledok: celková mortalita</h2>

<p>Rozdiel v počte úmrtí bol 51. V podieloch to je 45,5 % oproti 48,5 %, teda necelé tri percentuálne body. Medián prežívania bol 5,06 roka (95 % IS 4,71 až 5,34) v ramene s cholekalciferolom a 4,78 roka (4,48 až 5,05) v ramene so štandardnou starostlivosťou, teda rozdiel približne tri a pol mesiaca. Ani jeden z týchto rozdielov nebol štatisticky významný.</p>

<p>Pomer rizík 0,95 znamená, že počas sledovaného obdobia bola okamžitá intenzita úmrtnosti (hazard) v ramene s cholekalciferolom o 5 % nižšia. Nejde o 5 % menej úmrtí v absolútnom zmysle a nejde ani o štatisticky preukázaný rozdiel. Interval spoľahlivosti 0,86 až 1,04 zahŕňa jednotku, čiže nulový účinok, a to s väčšou rezervou na strane prínosu než na strane škody.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Prehľad primárneho a sekundárnych ukazovateľov štúdie SIMPLIFIED" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Pomer rizík (95 % IS)</th>
        <th scope="col">p</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Celková mortalita (primárny ukazovateľ)</th>
        <td>0,95 (0,86 až 1,04)</td>
        <td>0,27</td>
      </tr>
      <tr>
        <th scope="row">Prvá hospitalizácia pre kardiovaskulárnu príhodu</th>
        <td>0,96 (0,88 až 1,06)</td>
        <td>0,44</td>
      </tr>
      <tr>
        <th scope="row">Infekcia</th>
        <td>0,96 (0,87 až 1,06)</td>
        <td>0,43</td>
      </tr>
      <tr>
        <th scope="row">Zlomenina</th>
        <td>0,89 (0,70 až 1,12)</td>
        <td>0,32</td>
      </tr>
      <tr>
        <th scope="row">Kompozit MACE</th>
        <td>0,88 (0,78 až 0,99)</td>
        <td>0,03</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Aspoň jednu hospitalizáciu malo 69 % účastníkov v ramene s cholekalciferolom a 70 % v ramene so štandardnou starostlivosťou. Výskyt závažných nežiaducich udalostí bol medzi ramenami podobný.</p>

<h2>Prečo nulový rozdiel nie je dôkazom nulového účinku</h2>

<p>Protokol počítal s približne 4 200 pacientmi a s 2 200 úmrtiami, čo malo dať 90 % silu preukázať pomer rizík 0,87. Skutočnosť bola 3 866 randomizovaných a 1 817 úmrtí. Štúdia teda dosiahla približne 83 % plánovaného počtu úmrtí a jej skutočná sila bola nižšia, než predpokladal návrh.</p>

<p>To mení formuláciu záveru. Štúdia nepreukázala, že cholekalciferol neznižuje mortalitu. Vylúčila iba prínos nad určitú hranicu. Dolná hranica intervalu spoľahlivosti 0,86 znamená, že najväčší prínos, ktorý dáta ešte pripúšťajú, je 14 %. Prínos okolo 10 alebo 12 % je s nimi zlučiteľný.</p>

<p>Pre prax to má dva dôsledky. Prvý: výsledok neopodstatňuje plošné podávanie vysokých dávok, pretože možný prínos je malý a štúdia ho nepreukázala. Druhý: výsledok neukončuje výskum, pretože otázka, či existuje malý prínos, zostáva otvorená a na jej zodpovedanie by bola potrebná väčšia vzorka alebo dlhšie sledovanie.</p>

<h2>Sekundárne ukazovatele: dva kompozity, ktoré si odporujú</h2>

<p>Prvá hospitalizácia pre kardiovaskulárnu príhodu, infekcia ani zlomenina sa medzi ramenami nelíšili. Všetky tri odhady majú interval spoľahlivosti, ktorý prechádza jednotkou, a veľkosťou sú malé.</p>

<p>Kompozit MACE dopadol inak: 0,88 (0,78 až 0,99), p = 0,03. Na prvý pohľad je to jediný pozitívny výsledok štúdie. Pomer rizík 0,88 znamená 12 % relatívne zníženie rizika závažnej kardiovaskulárnej príhody a interval spoľahlivosti sa tesne nedotýka jednotky.</p>

<p>Práve preto treba vedieť, z čoho kompozit vznikol. Podľa správy Medscape prednášajúca uviedla, že rozdiel bol z veľkej časti nesený koronárnou revaskularizáciou. To je zložka, ktorá závisí od rozhodnutia lekára a od toho, či sa príhoda zachytí, teda zložka najviac náchylná na skreslenie v otvorenej štúdii, kde pacient aj lekár vedia, kto dostáva vitamín. Ak sa účinok koncentruje práve tam, je to dôvod na opatrnosť, nie na nadšenie.</p>

<p>Druhý dôvod je vnútorný. Širší kardiovaskulárny kompozit a MACE obsahujú podľa opisu v správe Medscape tie isté zložky, líšia sa však požiadavkou na hospitalizáciu. Dva kompozity z takmer rovnakých prvkov, z ktorých jeden vyjde nulový (0,96, p = 0,44) a druhý významný (0,88, p = 0,03), nie sú nezlučiteľné, ale ani sa navzájom nepodporujú. Taký rozdiel skôr naznačuje, že výsledok je citlivý na definíciu ukazovateľa, než že existuje pevný biologický účinok.</p>

<p>Napokon, abstrakt neuvádza, či bol interval spoľahlivosti pre MACE upravený na viacnásobné porovnania. Pri štvrtom zo série sekundárnych ukazovateľov a pri viacerých podskupinových analýzach je p = 0,03 slabý dôkaz, nie potvrdenie.</p>

<h2>Podskupiny: najsilnejší signál a najväčšie riziko omylu</h2>

<p>Štúdia zistila interakciu účinku s pohlavím (p interakcie 0,02) a s etnickým pôvodom (0,02). Odhadovaný pomer rizík bol 0,89 (0,79 až 0,99) u mužov a 0,72 (0,56 až 0,92) u účastníkov, ktorí neboli belosi. Abstrakt plagátu uvádza pre tie isté podskupiny mierne odlišné hodnoty, 0,88 (0,79 až 0,99) a 0,70 (0,55 až 0,91).</p>

<p>Každé z týchto čísel má štyri slabiny a všetky štyri treba povedať nahlas.</p>

<ol>
  <li><strong>Muži nie sú podskupina.</strong> Tvoria 68 % súboru. Keď sa účinok nájde v dvoch tretinách populácie, nie je to vedľajší nález, je to takmer celkový výsledok. Formálny test interakcie môže byť významný aj vtedy, keď sa odhad pre podskupinu od celkového odhadu líši len málo, a presne to je tento prípad: 0,89 oproti 0,95.</li>
  <li><strong>Nebelošská podskupina je malá a nesúrodá.</strong> Ide o pätinu súboru a abstrakt ju vymedzuje len negatívne, ako skupinu účastníkov, ktorí neboli belosi, teda spolu ľudí ázijského, černošského, zmiešaného a iného pôvodu. Interval spoľahlivosti 0,56 až 0,92 je široký a neumožňuje rozlíšiť, či ide o biologický rozdiel, o rozdiel v prístupe k starostlivosti, o vplyv pridružených chorôb, alebo o náhodu.</li>
  <li><strong>Chýba doplnková podskupina.</strong> Abstrakty uvádzajú odhad pre nebelošských účastníkov, ale nie pre belošských, a neuvádzajú ani odhad pre ženy. Bez doplnkových skupín sa nedá overiť, či sú uvedené odhady navzájom konzistentné.</li>
  <li><strong>Podskupín bolo viac a úprava na viacnásobné porovnania nie je uvedená.</strong> Čím viac podskupín sa analyzuje, tým pravdepodobnejšie sa aspoň v jednej objaví „významný“ rozdiel bez toho, aby existoval.</li>
</ol>

<p>K tomu pristupuje rozpor, ktorý je sám o sebe poučný. Abstrakt plagátu uzatvára, že cholekalciferol priniesol prínos v prežívaní mužom a pacientom z etnických menšín. Abstrakt ústnej prezentácie ten istý nález označuje za hypotézu, ktorá vyžaduje nezávislé potvrdenie. Pre prax je správna druhá formulácia. Rozdiel v sile záveru medzi dvoma prezentáciami tej istej štúdie je presne ten typ nezhody, ktorý má čitateľa zastaviť.</p>

<h2>Bezpečnosť: čo „podobné“ v tomto dizajne znamená</h2>

<p>Bezpečnostné údaje sú v abstraktoch stručné: výskyt závažných nežiaducich udalostí bol medzi ramenami podobný a podiel hospitalizovaných sa líšil o jeden percentuálny bod. Štúdia teda nepriniesla signál zvýšeného rizika. To je pri vysokej dávke vitamínu D dôležité, pretože hlavnou obavou je hyperkalciémia a jej dôsledky.</p>

<p>Zároveň treba vidieť, čo tento údaj pokrýva. Bezpečnosť sa hodnotila z hospitalizácií a závažných udalostí v administratívnych dátach, nie z protokolom predpísaného sledovania kalciémie a fosfatémie. Abstrakty takéto sledovanie neuvádzajú. „Bezpečné“ tu preto znamená, že nebolo viac hospitalizácií, nie že nevznikala asymptomatická hyperkalciémia. V bežnej praxi, kde sa vysoká dávka kombinuje s aktívnymi formami vitamínu D a s liekmi viažucimi fosfát, je kalcium potrebné sledovať bez ohľadu na tento výsledok.</p>

<h2>Cholekalciferol nie je aktívny vitamín D</h2>

<p>V diskusii po prednáške zaznela otázka, či by iná forma vitamínu D neviedla k inému výsledku. Odpoveď je vecná, hoci sa dve veci ľahko zamenia.</p>

<p>Cholekalciferol je neaktívny, nehydroxylovaný vitamín D3. Slúži na doplnenie substrátu a na korekciu deficitu. Na aktívnu formu sa mení hydroxyláciou a 1α-hydroxyláciu zabezpečuje prevažne oblička. Pri chronickej chorobe obličiek je renálna 1α-hydroxyláza nedostatočná a časť premeny prebieha v cieľových tkanivách autokrinným a parakrinným mechanizmom. Presne na tomto predpoklade bol postavený dizajn štúdie.</p>

<p>Aktívne formy, teda kalcitriol a jeho analógy, majú iné určenie. Používajú sa na liečbu sekundárnej hyperparatyreózy a na ovplyvnenie osi vápnik, fosfát a parathormón. KDIGO v odporúčaní 3.1.3 pre CKD G3a až G5D navrhuje merať 25(OH)D a korigovať deficit a insuficienciu postupmi odporúčanými pre všeobecnú populáciu (2C). V odporúčaní 4.2.4 pre pacientov v CKD G5D, ktorí potrebujú liečbu znižujúcu parathormón, navrhuje kalcimimetiká, kalcitriol alebo analógy vitamínu D (2B). Sú to dve rozdielne rozhodnutia s dvoma rozdielnymi cieľmi.</p>

<p>Štúdia testovala prvý z nich. Druhý nechala nedotknutý. Podľa správy Medscape autori počas celej štúdie nezbierali podrobné údaje o používaní aktívnych foriem vitamínu D, hoci ich časť účastníkov dostávala. To je vecné obmedzenie pragmatického dizajnu: časť nulového výsledku môže súvisieť práve so súbežným používaním aktívnych foriem a z dostupných textov to nemožno vylúčiť ani potvrdiť.</p>

<h2>Čo z toho platí pre prax</h2>

<ol>
  <li><strong>Nepresúvať výsledok do plošného podávania.</strong> Vysokodávkový cholekalciferol u všetkých dialyzovaných pacientov nemá oporu v prežívaní ani v ostatných tvrdých ukazovateľoch. Práve to je hlavné posolstvo štúdie a je dostatočne silné na to, aby sa podľa neho dalo rozhodovať.</li>
  <li><strong>Neprestať s korekciou deficitu.</strong> Štúdia netestovala, či má zmysel doplniť chýbajúci vitamín D. Testovala, či vysoká dávka navyše zmení mortalitu. To nie je to isté a KDIGO 3.1.3 platí ďalej.</li>
  <li><strong>Rozlišovať cieľ liečby.</strong> Ak je cieľom 25(OH)D, rozhoduje korekcia deficitu. Ak je cieľom parathormón pri sekundárnej hyperparatyreóze, rozhoduje postup pre CKD-MBD, teda odporúčania 4.2.3 a 4.2.4. Zámena týchto dvoch cieľov je chyba, ktorú tento typ štúdie odhaľuje.</li>
  <li><strong>Pri vysokých dávkach sledovať kalcium a fosfát.</strong> Pragmatická štúdia kalciémiu a fosfatémiu systematicky nesledovala, takže jej bezpečnostné údaje hyperkalciémiu nevylučujú. Ak sa vysoká dávka predsa len zváži, patrí ku konkrétnemu pacientovi, k jeho dávke liekov viažucich fosfát, k aktívnemu vitamínu D a ku kontrole kalcia a fosfátu.</li>
  <li><strong>Podskupiny nebrať ako indikáciu.</strong> Mužské pohlavie ani nebelošský pôvod nie sú dôvodom na iný režim. Sú dôvodom na to, aby sa otázka skúmala ďalej, nie aby sa na jej základe menila liečba.</li>
</ol>

<h2>Limity</h2>

<ul>
  <li>V čase písania neexistoval recenzovaný plný text. Dostupné boli dva konferenčné abstrakty a spravodajský článok. V PubMed je k štúdii zatiaľ len protokol.</li>
  <li>Dve prezentácie uvádzajú mierne odlišné počty úmrtí (881 a 883) aj mierne odlišné odhady (0,94 oproti 0,95, p = 0,22 oproti 0,27). Najpravdepodobnejším vysvetlením sú dve rôzne uzávierky dát, abstrakty to však neuvádzajú.</li>
  <li>Išlo o otvorenú štúdiu bez placeba. Pacient aj lekár vedeli o zaradení, čo pri ukazovateľoch závislých od rozhodnutia, napríklad od revaskularizácie, vytvára priestor na skreslenie.</li>
  <li>Ukazovatele pochádzali z administratívnych dát. Ich presnosť závisí od kódovania, od zachytenia udalostí a od toho, či pacienta ošetrovali v systéme, ktorý štúdia sledovala.</li>
  <li>Počet úmrtí bol nižší, než sa plánovalo (2 200), takže skutočná sila štúdie bola nižšia než plánovaná.</li>
  <li>Podskupinové analýzy neboli podľa dostupných textov upravené na viacnásobné porovnania a abstrakty neuvádzajú, koľko podskupín sa testovalo.</li>
  <li>Koncentrácia 25(OH)D sa overovala len u prvých 206 účastníkov a len po štyroch mesiacoch. Dlhodobé dodržiavanie liečby nie je z abstraktov zrejmé.</li>
  <li>Chýbajú údaje o súbežnej liečbe aktívnymi formami vitamínu D, o kalciémii a o fosfatémii počas sledovania.</li>
  <li>Súbor bol britský a z 80 % belošský. Prenos na slovenskú dialyzačnú populáciu je prirodzený v smere účinku, nie v absolútnych číslach.</li>
</ul>

<h2>Záver</h2>

<p>SIMPLIFIED je najväčšia randomizovaná štúdia cholekalciferolu u dialyzovaných pacientov a jej hlavný výsledok je jasný: 60 000 IU každé dva týždne nepredĺžilo prežívanie. Tento záver stojí na 1 817 úmrtiach a na podstatnom zvýšení koncentrácie 25(OH)D, takže ho nemožno vysvetliť tým, že by intervencia nefungovala.</p>

<p>Rovnako jasné je, čo štúdia nepreukázala. Nevylúčila malý prínos, nevyvrátila význam aktívnych foriem vitamínu D pri sekundárnej hyperparatyreóze a nepodala dôkaz o účinku v podskupinách. Kompozit MACE a nižšia mortalita u mužov a u nebelošských účastníkov sú hypotézy, ktoré si vyžadujú potvrdenie, nie indikácie.</p>

<p>Pre prax z toho plynie jednoduché pravidlo, ktoré je zároveň staré pravidlo nefrológie: liečiť pacienta a jeho konkrétnu poruchu, nie laboratórnu hodnotu. Zvýšiť 25(OH)D je možné a pri deficite potrebné. Očakávať od toho predĺženie života však nemožno.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=vitamin-d-klinicka-prax-vysetrovanie-suplementacia-rizika">Vitamín D v klinickej praxi: koho vyšetrovať, komu ho podávať a kedy môže liečba škodiť</a></li>
  <li><a href="article.php?slug=perzistujuca-hyperparatyreoza-po-transplantacii-oblicky">Perzistujúca hyperparatyreóza po transplantácii obličky ako rizikový marker mortality a zlyhania štepu</a></li>
  <li><a href="article.php?slug=dynamika-kalciemie-hemodialyza">Dynamika kalciémie pri hemodialýze: prečo nestačí jediný výsledok</a></li>
  <li><a href="article.php?slug=klinicka-krehkost-cfs-mortalita-dialyza-validacia">Krehkosť hodnotená sestrou predpovedá mortalitu na dialýze: multicentrická validácia škály klinickej krehkosti</a></li>
  <li><a href="article.php?slug=dialyzacna-liecba-slovensko-nczi-2025">Dialyzačná liečba na Slovensku podľa údajov NCZI za rok 2025: čo z nich vyplýva a čo nie</a></li>
</ul>

<hr>

<p><small><em>Text má odborný informačný charakter a je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické rozhodovanie ani platné odporúčania. Uvedené výsledky pochádzajú z konferenčných abstraktov; do publikovania recenzovaného plného textu ich treba čítať s touto mierou istoty.</em></small></p>

<h2>Literatúra</h2>

<ol>
  <li>Smith RM, Cui M, Caskey F, Chaudhry A, Cunningham J, Humphrey T, Mitra S, Schoenmakers I, Wagner AP, Wheeler DC, Wilkinson I, Wilson ECF, Yahia A, Bond S, Hiemstra T; on behalf of the SIMPLIFIED Investigators. <em>High-Dose Cholecalciferol and Clinical Outcomes in Patients Receiving Dialysis: Results of the SIMPLIFIED Trial.</em> Abstract FR-OR101, High-Impact Clinical Trials. ASN Kidney Week 2026, Denver, 23. októbra 2026. <a href="https://www.asn-online.org/education/kidneyweek/2026/program-abstract.aspx?controlId=4587392" target="_blank" rel="noopener noreferrer">Abstrakt</a>.</li>
  <li>Smith RM, Cui M, Caskey F, Chaudhry A, Cunningham J, Humphrey T, Mitra S, Schoenmakers I, Wagner AP, Wheeler DC, Wilkinson I, Wilson ECF, Yahia A, Bond S, Hiemstra T; on behalf of SIMPLIFIED investigators. <em>Effect of High-Dose Cholecalciferol on Mortality in Patients on Dialysis: Results of the SIMPLIFIED Trial.</em> Abstract FR-PO0503. ASN Kidney Week 2026, Denver, 23. októbra 2026. <a href="https://www.asn-online.org/education/kidneyweek/2026/program-abstract.aspx?controlId=4554317" target="_blank" rel="noopener noreferrer">Abstrakt</a>.</li>
  <li>Humphrey TJL, Caskey FJ, Wheeler DC, Wilkinson IB, Wilson ECF, Wagner AP, Dowling F, Vencilas B, Cui M, Bond SJ, Hiemstra TF, Smith RM. <em>A pragmatic, randomised, open-label, multi-centre UK registry-facilitated trial evaluating the effect of high-dose cholecalciferol on mortality in patients on dialysis: the SIMPLIFIED trial.</em> Trials. 2025;26(1):415. doi: <a href="https://doi.org/10.1186/s13063-025-09134-9" target="_blank" rel="noopener noreferrer">10.1186/s13063-025-09134-9</a>. PMID 41094532, PMCID PMC12522466.</li>
  <li>Melville NA. <em>High-Dose Vitamin D Supplementation Shows No Mortality Benefit in Dialysis.</em> Medscape Medical News, 25. októbra 2026. <a href="https://www.medscape.com/viewarticle/high-dose-vitamin-d-supplementation-shows-no-mortality-2026a1001498" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li>Kidney Disease: Improving Global Outcomes (KDIGO) CKD-MBD Update Work Group. <em>KDIGO 2017 Clinical Practice Guideline Update for the Diagnosis, Evaluation, Prevention, and Treatment of Chronic Kidney Disease-Mineral and Bone Disorder (CKD-MBD).</em> Kidney International Supplements. 2017;7(1):1-59. doi: <a href="https://doi.org/10.1016/j.kisu.2017.04.001" target="_blank" rel="noopener noreferrer">10.1016/j.kisu.2017.04.001</a>. <a href="https://kdigo.org/wp-content/uploads/2026/04/KDIGO-2017-CKD-MBD-Guideline.pdf" target="_blank" rel="noopener noreferrer">Plný text (PDF)</a>.</li>
  <li>Neale RE, Baxter C, Romero BD, McLeod DSA, English DR, Armstrong BK, Ebeling PR, Hartel G, Kimlin MG, O'Connell R, van der Pols JC, Venn AJ, Webb PM, Whiteman DC, Waterhouse M. <em>The D-Health Trial: a randomised controlled trial of the effect of vitamin D on mortality.</em> The Lancet Diabetes &amp; Endocrinology. 2022;10(2):120-128. doi: <a href="https://doi.org/10.1016/S2213-8587(21)00345-4" target="_blank" rel="noopener noreferrer">10.1016/S2213-8587(21)00345-4</a>. PMID 35026158.</li>
</ol>

<p><small><em><strong>Poznámka k dôkazovému základu:</strong> Oba abstrakty ASN boli 1. novembra 2026 prečítané v celom rozsahu, rovnako ako správa Medscape vrátane podpisu autorky a dátumu vydania. Protokol štúdie bol overený v PubMed a Crossref (PMID 41094532, PMCID PMC12522466) a odtiaľ pochádza plánovaný počet 2 200 úmrtí, sila 90 % a cieľový pomer rizík 0,87; počet 1 817 úmrtí je súčet oboch ramien z abstraktu. Znenie odporúčaní 3.1.3, 4.2.3 a 4.2.4 bolo overené priamo v texte guidelines KDIGO 2017. Údaje o koncentráciách 25(OH)D, o podiele hospitalizovaných, o vylučovacích kritériách a o podiele účinku MACE tvorenom revaskularizáciou pochádzajú zo správy Medscape, ktorá cituje prednášajúcu; abstrakty ich neuvádzajú.</em></small></p>

<p><small><em><strong>Čo bolo v predlohe opravené:</strong> Predloha podávala rozdiel medzi 881 a 883 úmrtiami ako rozpor medzi abstraktom ASN a správou Medscape. Ide o dve prezentácie tej istej štúdie, plagát FR-PO0503 a ústnu prednášku FR-OR101, s dvoma uzávierkami dát; Medscape spracoval ústnu prezentáciu. Predloha ďalej neuvádzala koncentrácie 25(OH)D, plánovanú silu štúdie ani počet skutočne pozorovaných úmrtí, teda tri údaje, bez ktorých sa nulový výsledok nedá správne interpretovať. Tvrdenie o vplyve „vybranej zložky kompozitu“ bolo nahradené konkrétnym údajom o koronárnej revaskularizácii. Doplnená bola časť o vnútornom rozpore dvoch kardiovaskulárnych kompozitov a o rozdielnej sile záveru oboch abstraktov. Ilustračný obrázok bol vytvorený pre tento článok.</em></small></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_simplified_vitamin_d3_dialyza_mortalita',
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
