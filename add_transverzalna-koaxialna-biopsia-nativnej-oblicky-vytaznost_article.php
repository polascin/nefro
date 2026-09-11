<?php

/**
 * add_transverzalna-koaxialna-biopsia-nativnej-oblicky-vytaznost_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok — spracovanie štúdie Renal Failure 2026;48(1):2656545
 * (doi 10.1080/0886022X.2026.2656545, PMID 42613737, PMC13491899)
 * doplnené o porovnávacie štúdie a odborné odporúčania.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *     "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_transverzalna-koaxialna-biopsia-nativnej-oblicky-vytaznost_article.php"
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
    'title'        => 'Transverzálna koaxiálna biopsia natívnej obličky: vyššia výťažnosť vzorky, ale dôkazy na zmenu praxe nestačia',
    'slug'         => 'transverzalna-koaxialna-biopsia-nativnej-oblicky-vytaznost',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Jednocentrová retrospektívna štúdia zo 184 biopsií uvádza, že transverzálna koaxiálna technika je výťažnejšia, rýchlejšia aj bezpečnejšia. Kontrola primárnych údajov však odhalila štyri vnútorné rozpory publikácie.',
    'content'      => <<<'HTML'
<p>Jednocentrová retrospektívna štúdia porovnala tri techniky ultrazvukom navigovanej perkutánnej biopsie natívnej obličky. Transverzálna koaxiálna technika dosiahla najvyšší počet glomerulov, stopercentnú úspešnosť podľa vopred určeného prahu a najkratší čas od punkcie kože po ukončenie odberu. Výsledky sú zaujímavé, ale nemožno z nich zatiaľ vyvodiť, že táto technika je všeobecne bezpečnejšia alebo že by mala nahradiť zavedené postupy.</p>

<p>Porovnanie tabuliek publikácie s jej abstraktom a slovným opisom výsledkov navyše odhalilo <strong>štyri vnútorné rozpory</strong>. Najzávažnejší z nich obracia smer rozdielu vo výskyte makroskopickej hematúrie a prevzal ho aj sprievodný článok na portáli ReachMD.</p>

<h2>Prečo záleží na technike biopsie</h2>

<p>Perkutánna biopsia natívnej obličky zostáva základnou diagnostickou metódou pri mnohých glomerulárnych, tubulointersticiálnych a cievnych ochoreniach obličiek. Jej prínos závisí od správnej indikácie, bezpečného vykonania, dostatočného množstva reprezentatívneho kortikálneho tkaniva a jeho vhodného rozdelenia na svetelnú mikroskopiu, imunofluorescenčné vyšetrenie a elektrónovú mikroskopiu.</p>

<p>Najčastejšou klinicky významnou komplikáciou je krvácanie. Môže sa prejaviť mikroskopickou alebo makroskopickou hematúriou, perirenálnym hematómom, poklesom koncentrácie hemoglobínu, obštrukciou močových ciest krvnými koagulami alebo, zriedkavo, potrebou transfúzie či intervenčnej embolizácie.</p>

<p>Moderná biopsia sa zvyčajne vykonáva automatickou pružinovou ihlou pod ultrazvukovou kontrolou v reálnom čase. Výťažnosť a bezpečnosť môžu ovplyvniť:</p>

<ul>
  <li>priemer bioptickej ihly,</li>
  <li>počet prechodov cez puzdro obličky,</li>
  <li>miesto a uhol punkcie,</li>
  <li>orientácia ultrazvukovej sondy,</li>
  <li>skúsenosť operatéra,</li>
  <li>anatomické pomery,</li>
  <li>krvný tlak, hemoglobín, funkcia obličiek a hemostáza pacienta,</li>
  <li>spôsob kontroly odobratej vzorky.</li>
</ul>

<p>Jednou z technických možností je koaxiálny systém. Najprv sa zavedie vonkajšia vodiaca kanyla a následné tkanivové valčeky sa odoberajú bioptickou ihlou cez tú istú prístupovú dráhu. Teoretickou výhodou je stabilnejšie vedenie ihly a možnosť viacerých odberov pri jedinom prechode vonkajšej kanyly cez puzdro obličky. Nevýhodou je väčší vonkajší priemer koaxiálnej kanyly.</p>

<h2>Ako bola štúdia usporiadaná</h2>

<p>Autori posudzovali 201 pacientov, ktorí v jednom čínskom centre (Anhui Provincial Public Health Clinical Center) podstúpili od 1. januára 2019 do 31. decembra 2025 ultrazvukom navigovanú perkutánnu biopsiu natívnej obličky. Po vylúčení 17 z nich sa analyzovali údaje <strong>184 dospelých pacientov</strong>.</p>

<p>Zo štúdie boli vylúčení:</p>

<ul>
  <li>pacienti mladší ako 18 rokov,</li>
  <li>biopsie transplantovanej obličky,</li>
  <li>biopsie fokálnych nádorov,</li>
  <li>výkony vyžadujúce navigáciu počítačovou tomografiou.</li>
</ul>

<p>Podľa použitej techniky vznikli tri skupiny:</p>

<ol>
  <li><strong>Transverzálna koaxiálna technika</strong> (skupina A), 47 pacientov. Sonda bola orientovaná v priečnej rovine a cieľom bola kôra v strednej až dolnej časti obličky.</li>
  <li><strong>Longitudinálna koaxiálna technika</strong> (skupina B), 45 pacientov. Sonda bola orientovaná v pozdĺžnej rovine a biopsia smerovala do dolného pólu.</li>
  <li><strong>Longitudinálna nekoaxiálna technika</strong> (skupina C), 92 pacientov. Použila sa pozdĺžna orientácia sondy, dolný pól obličky a samostatné zavedenie bioptickej ihly pri jednotlivých odberoch.</li>
</ol>

<p>Používali sa automatické bioptické ihly s priemerom 16 G alebo 18 G. Pri koaxiálnej technike boli spojené s vonkajšími kanylami 15 G alebo 17 G. U každého pacienta sa vykonal jeden až tri odbery, najčastejšie dva (medián 2,0 v každej skupine). Všetky výkony vykonali alebo viedli dvaja intervenční rádiológovia s praxou dlhšou ako osem rokov, pričom sa počas siedmich rokov striedali tri rôzne ultrazvukové prístroje.</p>

<p>Za technicky úspešnú biopsiu autori považovali získanie najmenej desiatich glomerulov. Hodnotili celkový počet glomerulov, počet glomerulov na jeden odber, čas od punkcie kože po ukončenie odberu a krvácavé komplikácie klasifikované podľa Society of Interventional Radiology (SIR).</p>

<h2>Výťažnosť bioptickej vzorky</h2>

<p>Najvyšší priemerný počet glomerulov sa získal transverzálnou koaxiálnou technikou.</p>

<div class="table-responsive" role="region" aria-label="Výťažnosť bioptickej vzorky podľa techniky biopsie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Technika</th>
      <th scope="col">Pacienti</th>
      <th scope="col">Priemerný počet glomerulov</th>
      <th scope="col">Vzorka s najmenej 10 glomerulmi</th>
      <th scope="col">Podiel ihiel 16 G</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Transverzálna koaxiálna (A)</th>
      <td>47</td>
      <td>26,90 ± 9,90</td>
      <td>47 zo 47 (100 %)</td>
      <td>74,5 %</td>
    </tr>
    <tr>
      <th scope="row">Longitudinálna koaxiálna (B)</th>
      <td>45</td>
      <td>22,93 ± 10,75</td>
      <td>44 zo 45 (97,8 %)</td>
      <td>68,9 %</td>
    </tr>
    <tr>
      <th scope="row">Longitudinálna nekoaxiálna (C)</th>
      <td>92</td>
      <td>20,87 ± 10,50</td>
      <td>82 z 92 (89,1 %)</td>
      <td>59,8 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Transverzálna koaxiálna technika mala štatisticky významne vyššiu úspešnosť než longitudinálna nekoaxiálna technika, 100 % oproti 89,1 %, p = 0,016. Medzi oboma koaxiálnymi technikami nebol rozdiel v úspešnosti štatisticky významný (p = 0,489) a nebol významný ani medzi longitudinálnou koaxiálnou a nekoaxiálnou technikou (p = 0,101).</p>

<p>Priemerný počet glomerulov na jeden odber bol 13,94 ± 5,21 pri transverzálnej koaxiálnej technike, 11,88 ± 5,53 pri longitudinálnej koaxiálnej a 10,67 ± 5,14 pri longitudinálnej nekoaxiálnej technike.</p>

<p>Tento ukazovateľ však <strong>nepredstavuje nezávislé potvrdenie</strong> hlavného zistenia. Počet odberov bol vo všetkých troch skupinách rovnaký (medián 2,0; p = 1,000), takže „počet glomerulov na odber“ je prakticky celkový počet glomerulov delený rovnakou konštantou — čo potvrdzujú aj samotné čísla (26,90 ÷ 2 ≈ 13,45; 22,93 ÷ 2 ≈ 11,47; 20,87 ÷ 2 ≈ 10,44). Prezentovať oba údaje ako dve samostatné zhodné zistenia preto zdanie dôkazovej sily zvyšuje viac, než je opodstatnené.</p>

<p>Výsledky podporujú hypotézu, že kombinácia priečnej orientácie sondy a koaxiálneho prístupu môže zlepšiť efektívnosť odberu kortikálneho tkaniva. Štúdia však nedokáže oddeliť účinok orientácie sondy od účinku koaxiálneho systému, pretože <strong>neobsahovala štvrtú skupinu s transverzálnou nekoaxiálnou biopsiou</strong>.</p>

<h3>Desať glomerulov nie je univerzálnou definíciou diagnostickej dostatočnosti</h3>

<p>Prahová hodnota najmenej desať glomerulov je praktickým ukazovateľom, nemala by sa však zamieňať s univerzálnou diagnostickou dostatočnosťou.</p>

<p>Požadovaný počet glomerulov závisí od klinickej otázky a typu ochorenia. Pri fokálnych léziách, napríklad pri fokálnej segmentovej glomeruloskleróze alebo nekrotizujúcej glomerulonefritíde, môže byť potrebná väčšia vzorka. Dôležitý je aj počet artérií, zastúpenie kôry, fragmentácia tkaniva a jeho rozdelenie medzi jednotlivé diagnostické metódy — odporúčania Renal Pathology Society žiadajú pri natívnej obličke súčasné vyšetrenie svetelnou mikroskopiou, imunohistochémiou aj elektrónovou mikroskopiou, čo znamená, že jeden odber musí zásobiť tri rôzne spracovania.</p>

<p>Vzorka s desiatimi glomerulmi preto nemusí byť dostatočná pre každú diagnózu. Naopak, vzorka s menším počtom glomerulov môže niekedy poskytnúť rozhodujúci nález.</p>

<p>V skúmanom centre navyše nebola pri výkone dostupná okamžitá kontrola vzorky patológom. O potrebe ďalšieho odberu rozhodoval nefrológ podľa makroskopického vzhľadu a dĺžky tkanivového valčeka. To môže ovplyvniť počet odberov aj výslednú výťažnosť.</p>

<h2>Čas výkonu</h2>

<div class="table-responsive" role="region" aria-label="Priemerný čas od punkcie kože po ukončenie odberu" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Technika</th>
      <th scope="col">Priemerný čas</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Transverzálna koaxiálna</th>
      <td>1,45 ± 0,20 minúty</td>
    </tr>
    <tr>
      <th scope="row">Longitudinálna koaxiálna</th>
      <td>2,22 ± 0,35 minúty</td>
    </tr>
    <tr>
      <th scope="row">Longitudinálna nekoaxiálna</th>
      <td>2,61 ± 0,46 minúty</td>
    </tr>
  </tbody>
</table>
</div>

<p>Všetky párové porovnania boli podľa autorov štatisticky významné, p &lt; 0,001.</p>

<p>Rozdiel je technicky zaujímavý, jeho klinický význam však treba interpretovať opatrne. Nešlo o celkové trvanie biopsie vrátane prípravy pacienta, ultrazvukového zobrazenia, lokálnej anestézie, zavedenia koaxiálneho systému, manipulácie so vzorkou a následnej kontroly. Meral sa iba interval od preniknutia cez kožu po ukončenie odberu tkaniva.</p>

<p>Že tento ukazovateľ nie je medzi pracoviskami porovnateľný, ukazuje randomizovaná štúdia Babaei Jandaghiho a spolupracovníkov: pri rovnako nazvanom ukazovateli uvádza 5 ± 1 minúty pre koaxiálnu a 14 ± 2 minúty pre nekoaxiálnu techniku — teda hodnoty päť- až šesťnásobne vyššie. Rozdiel približne jednej minúty preto nemožno bez ďalších údajov považovať za dôkaz významného skrátenia celého pracovného postupu.</p>

<h2>Krvácavé komplikácie</h2>

<p>V žiadnej skupine sa nevyskytlo krvácanie vyžadujúce embolizáciu ani iná závažná komplikácia (SIR trieda C až F). Nebolo zaznamenané ani predĺženie hospitalizácie v dôsledku komplikácie. Všetci pacienti boli hospitalizovaní, 24 hodín dodržiavali prísny pokoj na lôžku a 48 hodín boli klinicky sledovaní.</p>

<div class="table-responsive" role="region" aria-label="Výskyt krvácavých komplikácií podľa techniky biopsie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Komplikácia</th>
      <th scope="col">Transverzálna koaxiálna (A)</th>
      <th scope="col">Longitudinálna koaxiálna (B)</th>
      <th scope="col">Longitudinálna nekoaxiálna (C)</th>
      <th scope="col">A vs. C</th>
      <th scope="col">B vs. C</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Perirenálny hematóm</th>
      <td>5/47 (10,6 %)</td>
      <td>11/45 (24,4 %)</td>
      <td>37/92 (40,2 %)</td>
      <td>p &lt; 0,001</td>
      <td>p = 0,069</td>
    </tr>
    <tr>
      <th scope="row">Makroskopická hematúria</th>
      <td>7/47 (14,9 %)</td>
      <td>19/45 (42,2 %)</td>
      <td>37/92 (40,2 %)</td>
      <td>p = 0,002</td>
      <td>p = 0,823</td>
    </tr>
    <tr>
      <th scope="row">Mikroskopická hematúria</th>
      <td>35/47 (74,5 %)</td>
      <td>38/45 (84,4 %)</td>
      <td>85/92 (92,4 %)</td>
      <td>p = 0,004</td>
      <td>p = 0,149</td>
    </tr>
  </tbody>
</table>
</div>

<p>Transverzálna koaxiálna skupina mala oproti longitudinálnej nekoaxiálnej skupine významne nižší výskyt všetkých troch sledovaných krvácavých príhod. Medzi oboma koaxiálnymi technikami boli rozdiely v perirenálnom hematóme (p = 0,081) a mikroskopickej hematúrii (p = 0,237) štatisticky nevýznamné. Pri makroskopickej hematúrii bol rozdiel významný, ale smeroval <strong>v prospech transverzálnej techniky</strong>, 14,9 % oproti 42,2 %.</p>

<h3>Prehliadaný nález: samotný koaxiálny systém prínos nepreukázal</h3>

<p>Posledný stĺpec tabuľky obsahuje zistenie, ktoré diskusia pôvodnej práce nezdôrazňuje. <strong>Longitudinálna koaxiálna skupina sa od nekoaxiálnej skupiny nelíšila v žiadnej z troch komplikácií</strong> (p = 0,069; 0,823; 0,149) ani v technickej úspešnosti (p = 0,101). Celá pozorovaná výhoda sa teda sústredila do skupiny, ktorá kombinovala koaxiálny systém s priečnou orientáciou sondy.</p>

<p>Tvrdenie v diskusii publikácie, že „koaxiálna skupina“ mala nižší výskyt krvácavých komplikácií než nekoaxiálna, tak platí len pre jednu z dvoch koaxiálnych skupín. V tomto súbore samotný koaxiálny systém — pri zachovaní zaužívanej pozdĺžnej orientácie — merateľný prínos nepriniesol.</p>

<h2>Vnútorné rozpory publikácie</h2>

<p>Porovnanie tabuliek s abstraktom a slovným opisom výsledkov odhalilo štyri nezrovnalosti. Prvá z nich je klinicky najzávažnejšia, pretože obracia smer rozdielu.</p>

<div class="table-responsive" role="region" aria-label="Rozpory medzi tabuľkami a textom pôvodnej publikácie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Údaj</th>
      <th scope="col">Podľa tabuliek</th>
      <th scope="col">Podľa abstraktu a textu</th>
      <th scope="col">Dôsledok</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Makroskopická hematúria, A vs. B</th>
      <td>7/47 (14,9 %) oproti 19/45 (42,2 %), p = 0,004 — <strong>menej častá</strong> v skupine A</td>
      <td>„významne vyšší výskyt v skupine A“</td>
      <td>Obrátený smer rozdielu; tvrdenie prevzal aj ReachMD</td>
    </tr>
    <tr>
      <th scope="row">Celkový počet glomerulov, párové p</th>
      <td>A vs. B: p = 0,028; B vs. C: p = 0,236</td>
      <td>A vs. B: p = 0,236; B vs. C: p &lt; 0,001</td>
      <td>Hodnoty vymenené; mení sa záver o rozdiele medzi oboma koaxiálnymi technikami</td>
    </tr>
    <tr>
      <th scope="row">Počet glomerulov na odber, párové p</th>
      <td>A vs. B: p = 0,048; B vs. C: p = 0,029; A vs. C: p &lt; 0,001</td>
      <td>„všetky p &lt; 0,001“</td>
      <td>Nadhodnotená sila hraničných rozdielov</td>
    </tr>
    <tr>
      <th scope="row">Smerodajná odchýlka počtu glomerulov, skupina C</th>
      <td>10,50</td>
      <td>11,50</td>
      <td>Nejednotný údaj; hlavný záver nemení</td>
    </tr>
  </tbody>
</table>
</div>

<p>Ak sú tabuľkové údaje správne, makroskopická hematúria bola v transverzálnej skupine jednoznačne <strong>menej častá</strong>, nie častejšia. Ide pravdepodobne o chybu pri formulácii smeru rozdielu, ktorá sa z abstraktu preniesla do sprievodného článku na portáli ReachMD.</p>

<p>Kým autori alebo vydavateľ nezverejnia opravu, pri interpretácii treba uprednostniť explicitné počty pacientov v tabuľke a upozorniť na vnútorný rozpor publikácie.</p>

<h3>Záver publikácie presahuje jej vlastné údaje</h3>

<p>Záver pôvodnej práce uvádza, že transverzálna koaxiálna technika bola „nezávisle spojená“ s vyššou technickou úspešnosťou v porovnaní <em>s oboma</em> zvyšnými technikami. Ani jedna časť tohto tvrdenia nie je podložená:</p>

<ul>
  <li>rozdiel v technickej úspešnosti oproti longitudinálnej koaxiálnej technike nebol významný (p = 0,489);</li>
  <li>slovo „nezávisle“ predpokladá viacrozmerný model, ktorý v práci nie je uvedený — nebola prezentovaná žiadna analýza, ktorá by súčasne korigovala výber obličky, kaliber ihly a klinické charakteristiky.</li>
</ul>

<p>Formulácia pravdepodobne nadväzuje na randomizovanú štúdiu Akkakriseeho a spolupracovníkov, ktorá viacrozmernú logistickú regresiu skutočne vykonala. V tejto práci však ostáva neopodstatnená.</p>

<h2>Prekvapivo vysoký výskyt hematúrie</h2>

<p>Výskyt makroskopickej hematúrie od 14,9 % do 42,2 % je rádovo vyšší než v referenčných súboroch moderných biopsií natívnej obličky. Rovnako nápadný je výskyt mikroskopickej hematúrie od 74,5 % do 92,4 %.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie výskytu krvácavých komplikácií s referenčnými súbormi" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Súbor</th>
      <th scope="col">Rozsah</th>
      <th scope="col">Makroskopická hematúria</th>
      <th scope="col">Transfúzia / intervencia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Hodnotená štúdia (2026)</th>
      <td>184 biopsií, jedno centrum</td>
      <td>14,9–42,2 %</td>
      <td>0 %</td>
    </tr>
    <tr>
      <th scope="row">Metaanalýza Corapi a spol. (2012)</th>
      <td>34 štúdií, 9 474 biopsií</td>
      <td>3,5 % (95 % IS 2,2–5,1)</td>
      <td>Transfúzia 0,9 % (0,4–1,5)</td>
    </tr>
    <tr>
      <th scope="row">Nórsky register (Tøndel a spol., 2012)</th>
      <td>9 288 biopsií, 8 573 dospelých</td>
      <td>1,9 %</td>
      <td>Transfúzia 0,9 %; chirurgický alebo katétrový zákrok 0,2 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>To nemusí znamenať, že výkony boli neprimerane nebezpečné. Výsledky mohli ovplyvniť:</p>

<ul>
  <li>aktívne laboratórne vyhľadávanie aj klinicky nevýznamnej hematúrie počas 48-hodinového sledovania,</li>
  <li>odlišná definícia komplikácie,</li>
  <li>východisková hematúria pri základnom ochorení,</li>
  <li>intenzita a časovanie kontrolných vyšetrení,</li>
  <li>nezohľadnenie zmeny oproti predbioptickému močovému nálezu.</li>
</ul>

<p>Štúdia uvádza, že moč sa vyšetroval pred biopsiou aj počas následného sledovania. Z publikovaných údajov však nie je dostatočne jasné, či bola mikroskopická hematúria definovaná ako novovzniknutý nález, zhoršenie existujúceho nálezu alebo akákoľvek prítomnosť erytrocytov po výkone.</p>

<p>Bez presnej a jednotnej definície sa tieto percentá nedajú priamo porovnávať s inými štúdiami. Navyše neboli systematicky uvedené klinicky významnejšie ukazovatele, ako pokles hemoglobínu, potreba transfúzie, močová retencia, hemodynamická nestabilita alebo opakovaná hospitalizácia.</p>

<p>Tento nesúlad má aj odvrátenú stranu. Kým menšie príhody boli v tomto súbore hlásené mimoriadne často, závažné komplikácie sa nevyskytli vôbec — zatiaľ čo randomizovaná štúdia Akkakriseeho zaznamenala u 70 pacientov až tri angioembolizácie. Obidva súbory teda podávajú vzájomne nekompatibilný obraz o bezpečnosti výkonu, čo samo osebe upozorňuje na neštandardizované hlásenie komplikácií v tejto oblasti.</p>

<h2>Ako sa štúdia má k ostatným dôkazom</h2>

<p>Hodnotená práca nie je prvá, ktorá sa témou zaoberá, a nie je ani najsilnejšia z hľadiska metodiky. Nasledujúci prehľad zaraďuje jej zistenia do kontextu existujúcich randomizovaných a veľkých observačných údajov.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie s existujúcimi štúdiami o technike biopsie natívnej obličky" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Dizajn</th>
      <th scope="col">Hlavné zistenie</th>
      <th scope="col">Čo z toho vyplýva</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Akkakrisee a spol. (2025) — orientácia sondy</th>
      <td>Randomizovaná kontrolovaná štúdia, 70 pacientov (35 + 35)</td>
      <td>Technická úspešnosť 85,7 % oproti 62,9 %, ale <strong>p = 0,056 — významnosť nedosiahnutá</strong>. Medián počtu glomerulov 20 oproti 18 (p = 0,173). Vo viacrozmernom modeli priečna technika OR 7,69 (95 % IS 1,69–50; p = 0,006)</td>
      <td>Jediná randomizovaná štúdia priečnej orientácie nepreukázala rozdiel vo výťažnosti a v základnej analýze ani v úspešnosti</td>
    </tr>
    <tr>
      <th scope="row">Babaei Jandaghi a spol. (2017) — koaxiálna technika</th>
      <td>Randomizovaná kontrolovaná štúdia, 166 pacientov (83 + 83)</td>
      <td>Počet glomerulov 18,2 ± 9,1 oproti 8,6 ± 5,5 (p &lt; 0,001); komplikácie 10,8 % oproti 24,1 % (p = 0,025). Komplikácie boli častejšie pri patologickom parenchýme (19/71 oproti 10/95; p = 0,006)</td>
      <td>Prínos koaxiálneho systému má randomizovanú oporu — ale typ ochorenia obličky je samostatný rizikový faktor, ktorý hodnotená štúdia nezohľadnila</td>
    </tr>
    <tr>
      <th scope="row">Mai a spol. (2013) — kaliber ihly</th>
      <td>Retrospektívne, 934 biopsií, dve centrá</td>
      <td>16 G oproti 18 G: medián 19 oproti 12 glomerulov (p &lt; 0,001) pri menšom počte valčekov; dostatočnosť 94,7 % oproti 89,4 % (p = 0,001); komplikácie bez rozdielu (3,7 % oproti 2,2 %; p = 0,49)</td>
      <td>Kaliber ihly je silný determinant výťažnosti — a jeho zastúpenie sa medzi skupinami hodnotenej štúdie líšilo</td>
    </tr>
    <tr>
      <th scope="row">Corapi a spol. (2012) — bezpečnosť</th>
      <td>Systematický prehľad a metaanalýza, 9 474 biopsií</td>
      <td>Makroskopická hematúria 3,5 %; transfúzia 0,9 %. Ihly hrubšie ako 14 G mali vyššiu potrebu transfúzie (2,1 % oproti 0,5 %; p = 0,009)</td>
      <td>Referenčné hodnoty, oproti ktorým sú čísla hodnotenej štúdie rádovo odlišné</td>
    </tr>
    <tr>
      <th scope="row">Tøndel a spol. (2012) — register</th>
      <td>Národný register, 9 288 biopsií</td>
      <td>97,9 % biopsií bez komplikácie. Riziko závažnej komplikácie stúpa pri eGFR &lt; 30 ml/min/1,73 m² (OR 15,5) a v centrách s menej ako 30 biopsiami ročne (OR 1,60)</td>
      <td>Objem pracoviska a funkcia obličiek ovplyvňujú riziko viac než detail techniky</td>
    </tr>
  </tbody>
</table>
</div>

<p>Z porovnania vyplýva dôležitý záver: <strong>randomizované dôkazy sú slabšie než retrospektívne</strong>. Jediná randomizovaná štúdia priečnej orientácie sondy nenašla rozdiel v počte glomerulov a rozdiel v technickej úspešnosti tesne minul hranicu významnosti. Retrospektívna práca s voľbou techniky podľa uváženia operatéra naopak hlási veľké a konzistentné rozdiely vo všetkých ukazovateľoch naraz. Taký obrazec býva typickejší pre výberové skreslenie než pre skutočný účinok.</p>

<h2>Prečo nemožno dokázať príčinnú súvislosť</h2>

<p>Najväčším obmedzením je nerandomizované retrospektívne usporiadanie. Techniku si volil operatér podľa vlastného uváženia. Pacienti preto neboli priradení k jednotlivým postupom náhodne.</p>

<p>Hoci sa skupiny v mnohých zaznamenaných charakteristikách podobali, mohli sa líšiť v nezachytených faktoroch:</p>

<ul>
  <li>technickej náročnosti výkonu,</li>
  <li>kvalite ultrazvukového zobrazenia,</li>
  <li>hĺbke obličky,</li>
  <li>hrúbke podkožného a perirenálneho tuku (podskupinová analýza podľa indexu telesnej hmotnosti nebola vykonaná),</li>
  <li>schopnosti zadržať dych,</li>
  <li>aktivite a type ochorenia obličiek (autori priznávajú, že podskupinovú analýzu podľa diagnózy nevykonali),</li>
  <li>prítomnosti hematúrie pred biopsiou,</li>
  <li>skúsenosti konkrétneho operatéra v danom období.</li>
</ul>

<p>Výrazne sa líšil aj výber biopsiovanej obličky (p &lt; 0,001). V nekoaxiálnej skupine sa vo všetkých prípadoch odoberala vzorka z ľavej obličky, kým v longitudinálnej koaxiálnej skupine prevažovala pravá oblička (57,8 %). Autori to vysvetľujú tým, že pri nekoaxiálnej technike stálo pracovisko s prístrojom po ľavej strane pacienta. Táto nerovnováha je preto zástupným ukazovateľom rozdielnych pracovných postupov, operatérov alebo časových období, nie anatomickým faktorom.</p>

<p>Štúdia neuvádza viacrozmernú analýzu, ktorá by súčasne korigovala výber obličky, kaliber ihly, klinické charakteristiky a ďalšie možné zavádzajúce premenné. Pri viacerých párových porovnaniach tiež nie je zrejmá korekcia na viacnásobné porovnávanie.</p>

<h3>Kaliber ihly ako neposúdený faktor</h3>

<p>Podiel hrubších ihiel 16 G klesal naprieč skupinami rovnakým smerom ako výťažnosť: 74,5 % v transverzálnej koaxiálnej skupine, 68,9 % v longitudinálnej koaxiálnej a 59,8 % v nekoaxiálnej skupine. Rozdiel nebol štatisticky významný (p = 0,198), no pri súbore 184 pacientov nevýznamnosť neznamená neprítomnosť skreslenia. Autori v obmedzeniach výslovne uvádzajú, že podskupinovú analýzu podľa kalibru ihly nemohli vykonať.</p>

<p>Pri poctivom odhade však samotný kaliber pozorovaný rozdiel nevysvetlí. Ak by sa použili mediány z práce Mai a spolupracovníkov (19 glomerulov pre 16 G, 12 pre 18 G), rozdielne zastúpenie kalibrov by medzi krajnými skupinami vysvetlilo približne jeden glomerulus — nie šesť. Kaliber ihly teda pôsobí rovnakým smerom a nemožno ho vylúčiť ako spolupôsobiaci faktor, sám osebe však rozdiel vo výťažnosti neobjasňuje.</p>

<p>Pri bezpečnosti je vzťah dokonca opačný a hovorí <em>v prospech</em> techniky: transverzálna koaxiálna skupina používala najviac hrubých ihiel 16 G, a teda aj najhrubšie vonkajšie kanyly 15 G — a napriek tomu krvácala najmenej. Ak by bol pozorovaný bezpečnostný rozdiel len artefaktom rozdielneho vybavenia, očakávali by sme opačné poradie. To je jediný ukazovateľ, pri ktorom je zistenie odolnejšie, než sa na prvý pohľad zdá.</p>

<h2>Možný vplyv obdobia výkonu a učenia operatérov</h2>

<p>Údaje pochádzajú zo sedemročného obdobia a počas neho sa striedali tri rôzne ultrazvukové prístroje. Ak sa jednotlivé techniky zavádzali postupne, výsledky mohli byť ovplyvnené časom:</p>

<ul>
  <li>rastúcou skúsenosťou operatérov,</li>
  <li>zmenou ultrazvukových prístrojov,</li>
  <li>zmenou bioptických ihiel,</li>
  <li>zdokonalením prípravy pacientov,</li>
  <li>zmenami v monitorovaní komplikácií.</li>
</ul>

<p>Publikácia nepredkladá rozdelenie jednotlivých techník podľa kalendárnych rokov ani analýzu krivky učenia. Nie je preto možné vylúčiť, že aspoň časť lepších výsledkov najnovšej techniky súvisela s postupným zdokonaľovaním celého pracovného postupu.</p>

<h2>Čo štúdia skutočne dokazuje</h2>

<p>Na základe publikovaných údajov možno primerane konštatovať, že v skúsenom jedinom centre bola transverzálna koaxiálna biopsia <strong>spojená</strong> s:</p>

<ul>
  <li>vyšším priemerným počtom získaných glomerulov,</li>
  <li>vyššou úspešnosťou podľa prahu najmenej desať glomerulov oproti longitudinálnej nekoaxiálnej biopsii,</li>
  <li>kratším časom samotného odberu,</li>
  <li>nižším zaznamenaným výskytom perirenálneho hematómu a hematúrie oproti nekoaxiálnej skupine.</li>
</ul>

<p>Nemožno však tvrdiť, že štúdia dokázala:</p>

<ul>
  <li>príčinnú nadradenosť transverzálnej koaxiálnej techniky,</li>
  <li>prevahu nad longitudinálnou koaxiálnou technikou v technickej úspešnosti,</li>
  <li>zníženie rizika závažného krvácania,</li>
  <li>bezpečnosť u vysokorizikových pacientov,</li>
  <li>vhodnosť techniky pri transplantovaných obličkách, nádoroch alebo u detí,</li>
  <li>všeobecnú prenositeľnosť výsledkov na iné pracoviská,</li>
  <li>jednoznačnú výhodu samotnej transverzálnej orientácie nezávisle od koaxiálneho systému.</li>
</ul>

<p>Keďže ani v jednej skupine nenastala komplikácia vyžadujúca embolizáciu, štúdia nemala dostatočnú štatistickú silu na porovnanie zriedkavých závažných príhod. Neprítomnosť takejto udalosti v súbore 184 pacientov nie je dôkazom nulového rizika — pri nulovom počte udalostí siaha horná hranica 95 % intervalu spoľahlivosti pre najmenšiu skupinu (47 pacientov) až k približne 7,6 %.</p>

<h2>Praktické dôsledky pre nefrologické a intervenčné pracoviská</h2>

<p>Transverzálny koaxiálny prístup je racionálna a perspektívna technická možnosť. Priečna rovina môže v určitých anatomických podmienkach poskytnúť širšiu cieľovú oblasť kôry, kratšiu dráhu ihly a stabilnejší uhol. Koaxiálny systém umožňuje opakovaný odber bez opakovaných samostatných prechodov cez puzdro obličky — v hodnotenej štúdii vystačila koaxiálna technika s jedným prechodom cez puzdro oproti dvom pri nekoaxiálnej technike, čo je najpravdepodobnejší mechanizmus nižšieho výskytu hematómu.</p>

<p>O zavedení techniky by však nemala rozhodnúť jediná retrospektívna štúdia, najmä ak jej randomizovaný náprotivok rozdiel nepotvrdil. Pracovisko by malo zohľadniť:</p>

<ul>
  <li>skúsenosť operatérov a ročný počet výkonov (v nórskom registri bolo malé centrum samostatným rizikovým faktorom závažnej komplikácie),</li>
  <li>kvalitu ultrazvukového vybavenia,</li>
  <li>vlastné výsledky a komplikácie sledované podľa jednotnej definície,</li>
  <li>spoluprácu s nefropatológom,</li>
  <li>dostupnosť okamžitého posúdenia vzorky,</li>
  <li>možnosť urgentnej angiografie a embolizácie.</li>
</ul>

<p>Pri každej technike zostáva rozhodujúca správna indikácia, korekcia ovplyvniteľných rizikových faktorov, kontrola krvného tlaku a hemostázy, primerané prerušenie antikoagulačnej alebo protidoštičkovej liečby podľa individuálneho trombotického rizika a dôsledné sledovanie pacienta po výkone. Podľa dostupných dôkazov má na riziko väčší vplyv výber pacienta a funkcia obličiek než detail orientácie sondy.</p>

<p>Za vhodný ďalší krok možno považovať prospektívnu multicentrickú randomizovanú štúdiu so štyrmi ramenami, ktorá by samostatne porovnala transverzálnu a longitudinálnu orientáciu pri koaxiálnom aj nekoaxiálnom postupe. Mala by používať jednotné definície komplikácií a zaznamenávať:</p>

<ul>
  <li>diagnostickú, nie iba numerickú dostatočnosť vzorky,</li>
  <li>počet glomerulov a artérií,</li>
  <li>podiel kôry a drene,</li>
  <li>okamžité hodnotenie vzorky,</li>
  <li>pokles hemoglobínu,</li>
  <li>transfúzie a invazívne intervencie,</li>
  <li>trvanie celého výkonu,</li>
  <li>bolesť a hospitalizáciu,</li>
  <li>neskoré komplikácie po prepustení.</li>
</ul>

<h2>Záver</h2>

<p>Transverzálna koaxiálna biopsia natívnej obličky dosiahla v analyzovanom centre vysokú tkanivovú výťažnosť a kratší čas od punkcie kože po ukončenie odberu. V porovnaní s longitudinálnou nekoaxiálnou technikou bola spojená aj s nižším výskytom zaznamenaných krvácavých príhod.</p>

<p>Výsledky sú sľubné, ale ich dôkazová sila je obmedzená retrospektívnym jednocentrovým usporiadaním, výberom techniky operatérom, malým počtom pacientov, nedostatočnou kontrolou zavádzajúcich premenných a nejasnou klinickou interpretáciou vysokého výskytu hematúrie. Jediná randomizovaná štúdia priečnej orientácie sondy rozdiel vo výťažnosti nepotvrdila.</p>

<p>Dôležitá je aj oprava interpretácie makroskopickej hematúrie. Podľa tabuľkových údajov bola menej častá pri transverzálnej koaxiálnej technike než pri longitudinálnej koaxiálnej technike. Opačné tvrdenie v abstrakte, texte štúdie a sprievodnom článku ReachMD je v rozpore s publikovanými počtami.</p>

<p>Transverzálna koaxiálna technika preto zatiaľ predstavuje perspektívnu možnosť, nie nový univerzálny štandard biopsie natívnej obličky.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia">Východisková eGFR pri biopsii obličky: ako jej výber a imputácia môžu skresliť výsledky observačných štúdií</a></li>
  <li><a href="article.php?slug=iga-nefropatia-algoritmus-kdigo-2025-kdoqi">Praktická príloha: Algoritmus manažmentu IgA nefropatie podľa KDIGO 2025 s ohľadom na KDOQI US Commentary</a></li>
  <li><a href="article.php?slug=nahly-vzostup-kreatininu-starsi-pacient-hypertenzia-aki">Náhly vzostup kreatinínu u staršieho pacienta s hypertenziou: príčiny, diagnostika a klinický postup</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Huang L, Zhan X, Chen L, Zhang J, Luo N, Wang Y, Wang D, Liu J, Ren L, Li M, Yang Q, Luo H. Cross-Sectional coaxial technique: optimizing specimen adequacy and safety in ultrasound-guided renal biopsy procedures. <em>Renal Failure</em>. 2026;48(1):2656545. doi: 10.1080/0886022X.2026.2656545. <a href="https://pubmed.ncbi.nlm.nih.gov/42613737/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13491899/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Sprievodný článok s prevzatou chybou:</strong> Cross-Sectional Coaxial Renal Biopsy Improved Adequacy. ReachMD (autor neuvedený). <a href="https://reachmd.com/news/cross-sectional-coaxial-renal-biopsy-improved-adequacy/2488382/" target="_blank" rel="noopener noreferrer">reachmd.com</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia orientácie sondy:</strong> Akkakrisee S, Hongsakul K, Arunwate S, et al. Percutaneous ultrasound-guided kidney biopsy: a randomized controlled trial comparing longitudinal and cross-sectional probe location cutting techniques. <em>Abdominal Radiology</em>. Publikované online 24. októbra 2025; 51(5):2575–2582. doi: 10.1007/s00261-025-05248-5. <a href="https://pubmed.ncbi.nlm.nih.gov/41134369/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia koaxiálnej techniky:</strong> Babaei Jandaghi A, Lebady M, Zamani AA, Heidarzadeh A, Monfared A, Pourghorban R. A Randomised Clinical Trial to Compare Coaxial and Noncoaxial Techniques in Percutaneous Core Needle Biopsy of Renal Parenchyma. <em>Cardiovascular and Interventional Radiology</em>. 2017;40(1):106–111. doi: 10.1007/s00270-016-1466-3. <a href="https://pubmed.ncbi.nlm.nih.gov/27695925/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Metaanalýza krvácavých komplikácií:</strong> Corapi KM, Chen JLT, Balk EM, Gordon CE. Bleeding complications of native kidney biopsy: a systematic review and meta-analysis. <em>American Journal of Kidney Diseases</em>. 2012;60(1):62–73. doi: 10.1053/j.ajkd.2012.02.330. <a href="https://pubmed.ncbi.nlm.nih.gov/22537423/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Národný register:</strong> Tøndel C, Vikse BE, Bostad L, Svarstad E. Safety and complications of percutaneous kidney biopsies in 715 children and 8573 adults in Norway 1988–2010. <em>Clinical Journal of the American Society of Nephrology</em>. 2012;7(10):1591–1597. doi: 10.2215/CJN.02150212. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3463204/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Kaliber ihly:</strong> Mai J, Yong J, Dixson H, Makris A, Aravindan A, Suranyi MG, Wong J. Is bigger better? A retrospective analysis of native renal biopsies with 16 Gauge versus 18 Gauge automatic needles. <em>Nephrology (Carlton)</em>. 2013;18(7):525–530. doi: 10.1111/nep.12093. <a href="https://pubmed.ncbi.nlm.nih.gov/23639213/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Odborné odporúčania a prehľady:</strong> Hogan JJ, Mocanu M, Berns JS. The Native Kidney Biopsy: Update and Evidence for Best Practice. <em>Clinical Journal of the American Society of Nephrology</em>. 2016;11(2):354–362. doi: 10.2215/CJN.05750515. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4741037/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>. — Luciano RL, Moeckel GW. Update on the Native Kidney Biopsy: Core Curriculum 2019. <em>American Journal of Kidney Diseases</em>. 2019;73(3):404–415. doi: 10.1053/j.ajkd.2018.10.011. <a href="https://pubmed.ncbi.nlm.nih.gov/30661724/" target="_blank" rel="noopener noreferrer">PubMed</a>. — Walker PD, Cavallo T, Bonsib SM. Practice guidelines for the renal biopsy. <em>Modern Pathology</em>. 2004;17(12):1555–1563. doi: 10.1038/modpathol.3800239. <a href="https://pubmed.ncbi.nlm.nih.gov/15272280/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
HTML,
];

// ── Vloženie / aktualizácia ───────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_transverzalna_koaxialna_biopsia',
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
