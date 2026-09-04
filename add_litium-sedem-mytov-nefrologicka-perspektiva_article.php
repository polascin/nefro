<?php
/**
 * add_litium-sedem-mytov-nefrologicka-perspektiva_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok: Lítium — sedem mýtov a nefrologická perspektíva.
 * Spracovanie komentára Nassira Ghaemiho (Medscape, 28. 8. 2026) s overením
 * voči primárnym zdrojom a s korekciou voči nefrologickej praxi.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_litium-sedem-mytov-nefrologicka-perspektiva_article.php"
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

$articles = [];

$articles[] = [
    'title'        => 'Lítium: sedem mýtov, ktoré môžu brániť jeho použitiu — nefrologická perspektíva',
    'slug'         => 'litium-sedem-mytov-nefrologicka-perspektiva',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Sedem mýtov o lítium treba čítať nefrologicky: cieľ 0,6–1,0 mmol/l nie je známkou úspechu, nefrogenný diabetes insipidus nie je to isté ako CKD a monitorovanie ostáva bezpečnostným rámcom.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Komentár Nassira Ghaemiho o siedmich mýtoch, ktoré môžu brániť použitiu lítia, je užitočný ako psychiatrický korekčný tón. Pre nefrológa však niektoré formulácie znejú príliš zmierňujúco. Tento text prechádza tých istých sedem tvrdení, overuje ich voči otvoreným primárnym zdrojom a vracia do stredu to, čo v psychiatrickom komentári ostáva na okraji: expozíciu, monitorovanie a rozdiel medzi nefrogenným diabetes insipidus, chronickou tubulointersticiálnou nefropatiou a akútnou toxicitou.</em></p>

<p>Lítium ostáva jedným z najúčinnejších liekov v psychiatrii — a jedným z najčastejšie nepochopených. Ghaemi v komentári pre Medscape (28. 8. 2026) argumentuje, že predstavy o „povinnom“ cieľovom pásme, inherentnej nefrotoxicite, trojdávkovom režime, čisto antimanickom účinku, výlučnej indikácii pri bipolárnej poruche, nevyhnutnom náraste hmotnosti a potlačení kreativity vedú k nedostatočnému využívaniu. S týmto smerom polemiky sa dá súhlasiť. Dôsledok, ktorý z neho Ghaemi vyvodzuje na záver — že riziká sú „oveľa nižšie“ a laboratórne sledovanie „oveľa menej dôležité“, než sa predpokladá — už nefrologická prax neunesie. Monitorovanie nie je fetišom cieľovej hodnoty, ale bezpečnostným rámcom.</p>

<p>Jednotky: sérová koncentrácia lítia sa v laboratóriách uvádza v mmol/l. Pre jednomocný ión Li<sup>+</sup> je 1 mmol/l numericky totožný s 1 mEq/l; v texte používame mmol/l podľa konvencie portálu.</p>

<div class="pdf-avoid-break">
<h2>Mýtus 1: Treba titrovať na presné pásmo 0,6–1,0 mmol/l, často na 0,8</h2>

<p>Ghaemi má pravdu v tom, že historické „terapeutické pásmo“ vzniklo predovšetkým zo štúdií akútnej mánie a že sérová koncentrácia nie je totožná s klinickým úspechom. Pacient, ktorý má benefit pri nižšej dávke, nemusí automaticky potrebovať eskaláciu len preto, aby sa „zmestil“ do laboratórneho okienka. To však nie je návod ignorovať monitorovanie.</p>

<p>Randomizovaná štúdia Gelenberga a spol. (1989) porovnala udržiavacie pásmo 0,8–1,0 mmol/l s pásmom 0,4–0,6 mmol/l: riziko relapsu bolo v nižšom pásme 2,6-násobné (38 % vs. 13 %), pri vyššom pásme však pribúdali nežiaduce účinky. Neskorší konsenzus preto hľadal stred. Pracovná skupina ISBD/IGSLI (Nolen a spol., 2019) na základe prehľadu a Delphi prieskumu odporúča pre dospelých v udržiavacej liečbe <strong>štandard 0,60–0,80 mmol/l</strong>, s možnosťou znížiť na 0,40–0,60 mmol/l pri dobrej odpovedi a zlej tolerancii, alebo zvýšiť na 0,80–1,00 mmol/l pri nedostatočnej odpovedi a dobrej tolerancii. U starších je väčšina skupiny konzervatívnejšia: zvyčajne 0,40–0,60 mmol/l, maximálne 0,70–0,80 mmol/l vo veku 65–79 rokov a maximálne 0,70 mmol/l nad 80 rokov. Odber má byť ráno, 12 ± 1 hodinu po večernej dávke.</p>

<p>Odporúčanie NICE (CG185) je konkrétne a zároveň opatrné: pri prvom predpise lítia udržiavať plazmatickú koncentráciu <strong>0,6–0,8 mmol/l</strong>; pásmo 0,8–1,0 mmol/l zvážiť aspoň na šesť mesiacov u tých, ktorí v minulosti počas liečby lítiom relabovali, alebo majú podprahové príznaky s funkčným obmedzením. Koncentrácia sa meria týždeň po začatí a po každej zmene dávky, potom týždenne do stabilizácie; prvý rok každé 3 mesiace, neskôr každé 6 mesiacov — a opäť každé 3 mesiace u starších, pri interakciách, pri riziku poklesu eGFR alebo tyreopatie, pri zlej adherencii a ak posledná hodnota bola ≥ 0,8 mmol/l.</p>

<p>Praktický princíp teda nie je „ignorovať hladinu“, ale <strong>liečiť na klinický účinok najnižšou účinnou dávkou</strong> a hladinu čítať ako ukazovateľ expozície, adherencie a toxicity — nie ako známku úspechu. U starších a pri CKD treba pásmo znížiť, nie mechanicky držať 0,8 mmol/l.</p>
</div>

<div class="pdf-avoid-break">
<h2>Mýtus 2: Lítium je vysoko toxické, najmä pre obličky</h2>

<p>Tu treba Ghaemiho formuláciu opraviť najvýraznejšie. Tvrdenie, že „klinicky významné chronické poškodenie obličiek sa vyskytuje približne u 1–5 % dlhodobých užívateľov“, cituje jeho vlastný naratívny prehľad s Barroilhetom (Acta Psychiatr Scand 2020, PMID 32526812). Abstrakt tejto práce číslo 1–5 % neuvádza a plný text nie je v otvorenom prístupe. Voči primárnym nefrologickým sériám toto percento <strong>nie je opisom nefrogenného diabetes insipidus (NDI)</strong> a ani opisom všetkej CKD 3. stupňa.</p>

<p>Tri entity sa nesmú zlúčiť do jednej vety o „toxicite pre obličky“:</p>

<div class="table-responsive" role="region" aria-label="Rozlíšenie renálnych účinkov lítia: NDI, CKD, AKI a terminálne zlyhanie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Entita</th>
      <th scope="col">Čo to je</th>
      <th scope="col">Ako časté to je</th>
      <th scope="col">Čo z toho plynie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Nefrogenný diabetes insipidus</th>
      <td>Porucha koncentračnej schopnosti zberných kanálikov (AQP2), polyúria, polydipsia, riziko dehydratácie a následnej toxicity</td>
      <td>Boton a spol.: koncentračný defekt najmenej u 54 % z 1 105 nevybraných pacientov; zjavná polyúria u 19 %. Wallin a spol.: 49 % nekoncentrovalo nad 800 mOsm/kg</td>
      <td>Bežné, nie „1–5 %“. Amilorid môže zmierniť polyúriu. NDI zvyšuje riziko toxicity cez slučku polyúria → dehydratácia → vyššia hladina</td>
    </tr>
    <tr>
      <th scope="row">Chronická tubulointersticiálna nefropatia / CKD</th>
      <td>Pomaly progredujúca intersticiálna fibróza, pokles eGFR, často s cystami v dreni</td>
      <td>Shine a spol.: HR 1,93 (95 % IS 1,76–2,12) pre CKD 3. stupňa. Bocchetta a spol.: polovica liečených &gt; 20 rokov mala eGFR &lt; 60 ml/min/1,73 m<sup>2</sup>. Aiff a spol. 2015: asi tretina po 10–29 rokoch mala známky chronického zlyhávania, ťažká forma len u 5 %</td>
      <td>Skutočné, expozíčne závislé, pomalé. Nie je to automatická kontraindikácia u každého psychiatrického pacienta, ale nie je to ani „zriedkavosť 1–5 %“</td>
    </tr>
    <tr>
      <th scope="row">Akútne poškodenie obličiek / intoxikácia</th>
      <td>Náhle zvýšenie hladiny pri dehydratácii, AKI, NSAID, ACEI/ARB, tiazidoch</td>
      <td>U starších užívateľov je toxicita bežnejšia (roční incidencia okolo 1,5 %); AKI v kohortách starších 1,3–4 % za 5 rokov</td>
      <td>Predovšetkým nadmerná expozícia. Lítium pri AKI a dehydratácii vysadiť, kým sa stav neupraví</td>
    </tr>
    <tr>
      <th scope="row">Terminálne zlyhanie obličiek (ESRD)</th>
      <td>Dialýza alebo transplantácia v dôsledku lítium-asociovanej nefropatie</td>
      <td>Aiff a spol. 2014: prevalencia RRT u užívateľov lítia 15,0 ‰ (1,5 %), relatívne riziko 7,8 voči bežnej populácii. Presne a spol.: lítium-súvisiace ESRD ≈ 0,22 % všetkých príčin ESRD vo Francúzsku, priemerná latencia 20 rokov</td>
      <td>Nebežné, ale nie raritné. Číslo „1–5 %“ je bližšie k ESRD/ťažkej CKD než k NDI</td>
    </tr>
  </tbody>
</table>
</div>

<p>Presne a spol. v biopsickej sérii opísali pomalú progresiu (priemerný ročný pokles klírensu kreatinínu 2,29 ml/min) a vzťah fibrózy k dĺžke liečby aj kumulatívnej dávke; približne 35 % vyšetrených malo stredne ťažkú hyperkalcémiu pri hyperparatyreóze. Shine a spol. súčasne potvrdili asociáciu lítia s hypotyreózou (HR 2,31) a so zvýšeným celkovým kalciom (HR 1,43); vyššie než mediánové koncentrácie lítia zvyšovali riziko všetkých sledovaných nežiaducich výsledkov. Bocchetta a spol. ukázali, že dĺžka liečby je rizikový faktor poklesu eGFR nezávisle od veku, ale dysfunkcia sa zvyčajne objaví až po desaťročiach a po poklese eGFR pod 45 ml/min/1,73 m<sup>2</sup> sa ďalšia progresia v ich 4-ročnom sledovaní nelíšila podľa toho, či sa lítium vysadilo.</p>

<p>Aiffova švédska séria je dôležitá práve pre nefrológa: staršie režimy 1960.–1970. rokov niesli vyššie riziko ESRD (približne 1,5 %); v jednej analýze nikto, kto začal lítium po roku 1980, neskončil v RRT — ale v následnej práci s 630 pacientmi s najmenej 10 rokmi liečby podľa moderných princípov mala asi tretina známky chronického zlyhávania. Moderné dávkovanie riziko znižuje, neeliminuje ho.</p>

<p><strong>Záver k tomuto mýtu:</strong> toxicita je predovšetkým funkciou nadmernej expozície, nie magickou vlastnosťou molekuly. Lítium má reálny nefrotoxický potenciál, je expozíčne závislé a NDI je časté. Nie je automatickou kontraindikáciou u všetkých psychiatrických pacientov. Veta „pri terapeutických hladinách je lítium pre obličky spravidla bezpečné“ bez vety o NDI, eGFR, kalciu a interakciách je pre nefrologického čitateľa nesprávna.</p>
</div>

<h2>Mýtus 3: Musí sa užívať dvakrát až trikrát denne</h2>

<p>Lítium má relatívne dlhý polčas a raz denne, zvyčajne večer, je v praxi bežný a často výhodný režim: jednoduchšia adherencia a štandardizovaný 12-hodinový odber ráno (údolná koncentrácia). Ghaemi k tomu pridáva možnosť nižšej renálnej expozície pri jednorazovom dávkovaní. To je <em>možné</em>, nie tvrdenie o tvrdom klinickom ukazovateli.</p>

<p>Carterová, Zolezziová a Lewczyková v prehľade 20 štúdií (2013) zistili protichodné výsledky pre objem moču: niektoré práce ukázali pokles pri jednej dennej dávke, iné nie. Bioptické práce spájali viacnásobné denné dávkovanie s väčším histologickým poškodením. Žiadna zaradená štúdia neukázala horšiu profylaktickú účinnosť jednorazového režimu. Autorky preto odporúčajú u novonasadených previesť overenú dennú dávku na večerné podanie raz denne.</p>

<p>Singh a spol. v randomizovanom porovnaní raz vs. dvakrát denne pri mánii (n = 83) nenašli rozdiel v účinnosti, ale pri dvoch dávkach bola vyššia frekvencia močenia (deň 21 a 42), vyšší celkový denný dávkový súčet a nižšia sérová koncentrácia. Schootová a spol. v systematickom prehľade prevencie Li-NDI a lítium-nefropatie (2020) konštatujú, že dôkazov je málo, a predsa prakticky odporúčajú: raz denne, najnižšia účinná hladina, predchádzať intoxikácii, včas zachytiť NDI aj nefropatiu, pri NDI zvážiť off-label amilorid.</p>

<p>Jednorazové večerné dávkovanie je teda racionálne a môže znížiť trvalú tubulárnu záťaž. Nie je to záruka, že pacient neskončí s poklesom eGFR.</p>

<div class="pdf-avoid-break">
<h2>Mýtus 4: Účinkuje na mániu, nie na depresiu</h2>

<p>Toto je azda najtrvácnejší psychiatrický omyl a tu je Ghaemi bližšie k dátam. Lítium v udržiavacej liečbe nie je „len antimanikum“. Štúdia BALANCE (Geddes a spol., Lancet 2010) randomizovala 330 pacientov s bipolárnou poruchou I. typu z 41 centier na lítium v monoterapii (plazmatická koncentrácia 0,4–1,0 mmol/l), valproát v monoterapii (750–1 250 mg) alebo kombináciu, po aktívnom úvodnom období na kombinácii. Primárnym výsledkom bolo začatie novej intervencie pre vzniknutú epizódu nálady počas až 24 mesiacov.</p>

<p>Primárnu udalosť malo 54 % v kombinácii, 59 % pri lítium a 69 % pri valproáte. Pomer rizík: kombinácia vs. valproát 0,59 (95 % IS 0,42–0,83; p = 0,0023); lítium vs. valproát 0,71 (0,51–1,00; p = 0,0472); kombinácia vs. lítium 0,82 (0,58–1,17; p = 0,27). Interpretácia autorov: kombinácia aj lítium v monoterapii predchádzajú relapsu spoľahlivejšie než valproát; prínos kombinácie voči samotnému lítiu štúdia nevedela spoľahlivo potvrdiť ani vyvrátiť.</p>

<p><strong>Korekcia voči Ghaemimu:</strong> v otvorenom abstrakte BALANCE nie je samostatný pomer rizík pre depresívne vs. manické relapsy. Tvrdenie, že lítium bolo „obzvlášť účinné v prevencii depresívnych epizód“, z verejného záznamu štúdie <em>nevieme nezávisle potvrdiť</em>. Čo potvrdiť vieme: udržiavacia liečba lítiom znižuje riziko relapsu náladovej epizódy ako celku — teda oboch pólov v zloženom primárnom výsledku — a nie je to liek „iba na mániu“. NICE navyše ponúka lítium ako liek prvej voľby v dlhodobej farmakoterapii bipolárnej poruchy práve preto, že predchádza relapsu, nie preto, že by liečilo výlučne mániu.</p>
</div>

<h2>Mýtus 5: Je užitočné len pri bipolárnej poruche</h2>

<p>Lítium je s bipolárnou poruchou späté historicky aj v myslení lekárov. Augmentácia pri unipolárnej depresii, ktorá neodpovedala na antidepresívum, má však svoje miesto v odporúčaniach — skromné, nie triumfálne. Barroilhet a Ghaemi v prehľade z roku 2020 hovoria o „nedocenenom dokázanom prínose“ v prevencii unipolárnej depresie a suicídia. NICE v usmernení k depresii u dospelých (NG222) ponecháva lítium medzi farmakologickými možnosťami ďalšieho postupu pri nedostatočnej odpovedi. Metaanalýza Scottovej a spol. (2023) k včasnej liečbe rezistentnej depresie však ukázala, že len aripiprazol a lítium mali ≥ 10 štúdií, heterogenita bola vysoká a intervaly spoľahlivosti mnohých stratégií sa prekrývali s placebom.</p>

<p>Pre nefrológa z toho plynie striedmosť: unipolárna augmentácia <strong>existuje a nie je kontraindikovaná diagnózou „nie je to bipolarita“</strong>, ale nie je dôvod sľubovať rovnakú silu dôkazu ako pri udržiavacej liečbe bipolárnej poruchy. Ak sa lítium v tejto indikácii nasadí, monitorovací rámec ostáva rovnaký.</p>

<h2>Mýtus 6: Nevyhnutne spôsobuje výrazný nárast hmotnosti</h2>

<p>Ghaemi označuje lítium za na populačnej úrovni „hmotnostne neutrálne“ a uvádza, že nárast hmotnosti postihne približne 20 % pacientov, v menšej miere než olanzapín, kvetiapín a valproát. Odkaz smeruje na metaanalýzu Gomes-da-Costa a spol. (Neurosci Biobehav Rev 2022). Z otvoreného abstraktu tejto práce vyplýva niečo presnejšie a skromnejšie.</p>

<p>Do systematického prehľadu vošlo 20 štúdií, do metaanalýzy 9. Priemerný nárast hmotnosti pri lítium bol <strong>+0,462 kg a nebol štatisticky významný</strong> (p = 0,158). Voči placebu rozdiel nebol významný; voči aktívnym komparátorom bol nárast pri lítium významne nižší. Kratšie trvanie liečby sa spájalo s väčším nárastom. Číslo „približne 20 %“ v abstrakte <em>nie je</em>; ako podiel pacientov s klinicky významným nárastom ho z otvoreného záznamu nevieme overiť. Overiť vieme: lítium nie je metabolicky nevinné u každého jednotlivca, ale na úrovni populácie nie je olanzapínom — a vyhýbať sa mu výhradne pre obavu z hmotnosti, kým alternativa nesie ťažší metabolický náklad, nemá oporu v tejto metaanalýze.</p>

<h2>Mýtus 7: Narušuje kreativitu a kogníciu</h2>

<p>Subjektívny pocit „spomalenia“ je častým dôvodom nonadherencie. Objektívne dáta sú zmiešané a závislé od hladiny, trvania a od toho, či sa meria pacient s neliečenou mániou, alebo stabilizovaný pacient. Burdicková a spol. (2020, PMC7419515) v doteraz najväčšej kohorte bipolárnej poruchy I. typu (n = 262) nenašli v priereze rozdiel v neurokognitívnych testoch medzi tými, ktorí lítium brali, a tými, ktorí nie. V longitudinálnej podskupine 88 pacientov, ktorí dosiahli stabilizáciu v monoterapii, sa globálny kognitívny index, verbálne učenie a TMT-B dokonca zlepšili. Autori uzatvárajú, že lítium pri terapeutickom použití kogníciu významne nepoškodzuje a môže byť prospešné.</p>

<p>To nevylučuje, že nadmerná expozícia — vrátane hladín ešte v „terapeutickom“ pásme u starších — spôsobí tremor, ataxiu a kognitívne spomalenie; NICE výslovne žiada hľadať známky neurotoxicity pri každej kontrole. Ghaemiho pojem „vytesanej kreativity“ (znížiť deštrukciu ťažkej mánie a zachovať energiu miernejších stavov) je <strong>klinický názor</strong>, nie overený klinický ukazovateľ. Ako metafora pre rozhovor s umelcom môže pomôcť; ako dôkaz, že lítium kreativitu „sochársky vylepšuje“, nestačí.</p>

<div class="pdf-avoid-break">
<h2>Čo z toho plynie pre nefrologickú prax</h2>

<p>Lítium sa nenasadzuje v nefrologickej ambulancii, ale nefrológ ho číta v zozname liekov, v poklese eGFR, v polyúrii, v hyperkalcémii a v AKI po hnačke. Individualizácia dávky je správna; vypnutie monitorovania nie je.</p>

<div class="table-responsive" role="region" aria-label="Monitorovanie a rizikové situácie pri liečbe lítiom v nefrologickej praxi" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Čo sledovať</th>
      <th scope="col">Prečo</th>
      <th scope="col">Praktická poznámka</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">eGFR (a urea, kreatinín)</th>
      <td>Chronická tubulointersticiálna nefropatia; akútny pokles pri toxicite</td>
      <td>NICE: vstupne a potom každé 6 mesiacov, častejšie pri poklese. Pokles eGFR v ≥ 2 meraniach → častejšie hladiny a zhodnotenie tempa. Pokles eGFR o &gt; 25 % alebo kreatinínu o &gt; 30 % je dôvod na revíziu, nie automatické celoživotné vysadenie</td>
    </tr>
    <tr>
      <th scope="row">Sérové lítium (12 h trough)</th>
      <td>Expozícia, adherencia, toxicita</td>
      <td>Najnižšia účinná hladina. U starších a pri CKD nižšie pásmo (často 0,4–0,6 mmol/l). Jedna hodnota &gt; 1,0 mmol/l sa spája s akútnym poklesom eGFR</td>
    </tr>
    <tr>
      <th scope="row">Elektrolyty, hydratácia, NDI</th>
      <td>Polyúria, hypernatriémia, slučka dehydratácia–toxicita</td>
      <td>Pýtať sa na nočné močenie a smäd. Pri vracaní, hnačke, horúčke, zníženom príjme — lítium dočasne vysadiť („sick-day rule“)</td>
    </tr>
    <tr>
      <th scope="row">TSH</th>
      <td>Hypotyreóza je častá (Shine: HR 2,31)</td>
      <td>Vstupne a každých 6 mesiacov; pri zmene nálady myslieť aj na tyreopatiu</td>
    </tr>
    <tr>
      <th scope="row">Kalcium (a PTH pri hyperkalcémii)</th>
      <td>Hyperparatyreóza; Presne: ≈ 35 % stredne ťažká hyperkalcémia v nefrologickej sérii</td>
      <td>NICE meria kalcium spolu s eGFR a tyreoidálnymi testami. Hyperkalcémia nie je „laboratórna kuriozita“</td>
    </tr>
    <tr>
      <th scope="row">Liekové interakcie</th>
      <td>NSAID, ACEI/ARB, tiazidy môžu zdvihnúť hladinu rádovo o desiatky percent</td>
      <td>Varovať pred voľnopredajnými NSAID. Po nasadení interakcie kontrolovať hladinu. Tiazid pri NDI je liečebná možnosť, ale súčasne dvíha lítium — len so sledovaním</td>
    </tr>
    <tr>
      <th scope="row">AKI a dehydratácia</th>
      <td>Klesajúci klírens → kumulácia → neurotoxicita</td>
      <td>Pri AKI lítium vysadiť. Obnoviť až po úprave volémie a eGFR, v nižšej dávke, s včasnou kontrolou hladiny</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozhodnutie pokračovať, znížiť dávku alebo vysadiť patrí na spoločný stôl psychiatra a nefrológa. NICE to hovorí priamo: zohľadniť klinickú účinnosť, ostatné riziká CKD a kardiovaskulárne ochorenie a stupeň poklesu funkcie; pri potrebe prizvať obe odbornosti. U lítium-preferenčného respondéra môže byť relaps po vysadení klinicky ťažší než pomalý pokles eGFR. To nie je argument proti monitorovaniu — je to argument proti automatizmu.</p>
</div>

<div class="pdf-avoid-break">
<h2>Vecná kontrola siedmich tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie siedmich mýtov o lítium voči primárnym zdrojom" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Spresnenie z primárnych zdrojov</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Každý pacient musí mať 0,6–1,0 mmol/l, ideálne 0,8</td>
      <td><strong>Zjednodušenie</strong></td>
      <td>ISBD: štandard 0,60–0,80 mmol/l, individualizácia 0,40–1,00. NICE: 0,6–0,8 pri prvom predpise; 0,8–1,0 len vo vybraných situáciách. Hladina = expozícia, nie známka úspechu. Monitorovanie nevypínať</td>
    </tr>
    <tr>
      <td>Chronické poškodenie obličiek u 1–5 % dlhodobých užívateľov</td>
      <td><strong>Čiastočne, ale zavádzajúco</strong></td>
      <td>1–5 % je bližšie k ESRD/ťažkej CKD (Aiff ≈ 1,5 % ESRD; 5 % ťažká forma po desaťročiach). NDI je časté (≥ 50 % koncentračný defekt). CKD 3. stupňa je po dlhej expozícii bežnejšia (Shine HR 1,93; Bocchetta ≈ 50 % po &gt; 20 rokoch)</td>
    </tr>
    <tr>
      <td>Lítium je pre obličky pri terapeutických hladinách spravidla bezpečné</td>
      <td><strong>Nepresné pre nefrologického čitateľa</strong></td>
      <td>Reálny nefrotoxický potenciál, expozíčne závislý. Nie automatická kontraindikácia. Bez sledovania NDI/eGFR/kalcia túto vetu nepoužívať</td>
    </tr>
    <tr>
      <td>Musí sa dávkovať 2–3× denne</td>
      <td><strong>Nepravdivé ako pravidlo</strong></td>
      <td>Raz denne večer je racionálne (Carter, Singh, Schoot). Možná nižšia tubulárna záťaž, nie záruka tvrdého renálneho endpointu</td>
    </tr>
    <tr>
      <td>Účinkuje na mániu, nie na depresiu</td>
      <td><strong>Nepravdivé</strong></td>
      <td>BALANCE: lítium (aj kombinácia) predchádza relapsu náladovej epizódy lepšie než valproát (HR 0,71 resp. 0,59). Pole-špecifickú prevahu pri depresii z abstraktu nevieme potvrdiť</td>
    </tr>
    <tr>
      <td>Je užitočné len pri bipolarite</td>
      <td><strong>Príliš tesné</strong></td>
      <td>Unipolárna augmentácia má miesto v NICE, dôkaz je skromný. Nepreceňovať</td>
    </tr>
    <tr>
      <td>Nevyhnutne výrazný nárast hmotnosti</td>
      <td><strong>Nepresné</strong></td>
      <td>Gomes-da-Costa: +0,46 kg, NS; voči placebu bez rozdielu; voči aktívnym komparátorom menší nárast. Podiel „20 %“ z otvoreného abstraktu neoverený</td>
    </tr>
    <tr>
      <td>Narušuje kreativitu a kogníciu</td>
      <td><strong>Hladinovo závislé; „vytesaná kreativita“ je názor</strong></td>
      <td>Burdicková: pri terapeutickom použití bez významného poškodenia, v podskupine zlepšenie. Neurotoxicita pri nadmernej expozícii je reálna</td>
    </tr>
  </tbody>
</table>
</div>
</div>

<h2>Praktický záver</h2>

<p>Ghaemiho sedem mýtov správne bráni lítium pred karikatúrou „jedovatého antimanika, ktoré treba titrovať na 0,8 a podávať trikrát denne“. Nefrologické čítanie musí ísť o krok ďalej. Najnižšia účinná dávka je správny cieľ; sérová koncentrácia ostáva nástrojom bezpečnosti. NDI je časté, CKD po dlhej expozícii je skutočná, ESRD je nebežné, ale nie raritné. Raz denne večer je rozumný režim, nie amulet. Udržiavacia liečba predchádza relapsu oboch pólov v kompozitnom zmysle štúdie BALANCE. Unipolárna augmentácia existuje v skromnej sile dôkazu. Hmotnosť na úrovni populácie nie je olanzapínový problém. Kognícia pri terapeutickom použití nemusí trpieť — a „vytesaná kreativita“ ostáva metaforou.</p>

<p>Pre ambulanciu to znamená krátku, opakovanú vetu pacientovi aj psychiatrovi: hydratácia, žiadne voľnopredajné NSAID, pri hnačke a horúčke liek dočasne vysadiť, hladinu a eGFR čítať ako expozíciu, kalcium a TSH nenechať vypadnúť z balíka. Individualizovať. Nesľubovať, že obličky sú mimo hry.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=perzistujuca-hyperparatyreoza-po-transplantacii-oblicky">Perzistujúca hyperparatyreóza po transplantácii obličky ako rizikový marker mortality a zlyhania štepu</a></li>
  <li><a href="article.php?slug=kedy-zacat-krt-pri-aki">Kedy začať náhradnú liečbu obličiek (KRT) pri akútnom poškodení obličiek (AKI)</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia, presná stratifikácia rizika a sledovanie po AKI</a></li>
  <li><a href="article.php?slug=ketoacidoza-nefrologicka-prax-hladovanie-euglykemicka-dka">Ketoacidóza v nefrologickej praxi: od hladovania po euglykemickú diabetickú ketoacidózu</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Ghaemi N.</strong> <em>Lithium: 7 Myths That May Be Keeping It Underused.</em> Medscape Psychiatry, 28. 8. 2026. Komentár, ktorý je spracovaným zdrojom tohto článku. <a href="https://www.medscape.com/viewarticle/lithium-7-myths-may-be-keeping-it-underused-2026a1000tsv" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
  <li><strong>Barroilhet SA, Ghaemi SN.</strong> <em>When and how to use lithium.</em> Acta Psychiatr Scand. 2020;142(3):161–172. doi: 10.1111/acps.13202. PMID 32526812. Naratívny prehľad, na ktorý sa Ghaemi odvoláva pri údaji 1–5 %; abstrakt toto percento neuvádza, plný text nie je v otvorenom prístupe. <a href="https://pubmed.ncbi.nlm.nih.gov/32526812/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>BALANCE investigators and collaborators, Geddes JR, Goodwin GM, Rendell J, Azorin JM, Cipriani A, Ostacher MJ, Morriss R, Alder N, Juszczak E.</strong> <em>Lithium plus valproate combination therapy versus monotherapy for relapse prevention in bipolar I disorder (BALANCE): a randomised open-label trial.</em> Lancet. 2010;375(9712):385–395. doi: 10.1016/S0140-6736(09)61828-6. PMID 20092882. <a href="https://pubmed.ncbi.nlm.nih.gov/20092882/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nolen WA, Licht RW, Young AH, Malhi GS, Tohen M, Vieta E, Kupka RW, Zarate C, Nielsen RE, Baldessarini RJ, Severus E, ISBD/IGSLI Task Force on the treatment with lithium.</strong> <em>What is the optimal serum level for lithium in the maintenance treatment of bipolar disorder? A systematic review and recommendations from the ISBD/IGSLI Task Force on treatment with lithium.</em> Bipolar Disord. 2019;21(5):394–409. doi: 10.1111/bdi.12805. PMID 31112628. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6688930/" target="_blank" rel="noopener noreferrer">PMC</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/31112628/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Bipolar disorder: assessment and management.</em> Clinical guideline CG185. Odporúčania k hladinám 0,6–0,8 mmol/l, k pásmu 0,8–1,0 mmol/l, k monitorovaniu eGFR, TSH, kalcia a k NSAID. <a href="https://www.nice.org.uk/guidance/cg185" target="_blank" rel="noopener noreferrer">NICE CG185</a>.</li>
  <li><strong>Goodwin GM, Haddad PM, Ferrier IN, Aronson JK, Barnes TRH, Cipriani A, Coghill DR, Fazel S, Geddes JR, Grunze H, Holmes EA, Howes O, Hudson S, Hunt N, Jones I, Macmillan IC, McAllister-Williams H, Miklowitz DR, Morriss R, Munafò M, Paton C, Sahakian BJ, Saunders KEA, Sinclair JMA, Taylor D, Vieta E, Young AH.</strong> <em>Evidence-based guidelines for treating bipolar disorder: Revised third edition recommendations from the British Association for Psychopharmacology.</em> J Psychopharmacol. 2016;30(6):495–553. doi: 10.1177/0269881116636545. PMID 26979387. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC4922419/" target="_blank" rel="noopener noreferrer">PMC</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/26979387/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Gelenberg AJ, Kane JM, Keller MB, Lavori P, Rosenbaum JF, Cole K, Lavelle J.</strong> <em>Comparison of standard and low serum levels of lithium for maintenance treatment of bipolar disorder.</em> N Engl J Med. 1989;321(22):1489–1493. doi: 10.1056/NEJM198911303212201. PMID 2811970. <a href="https://pubmed.ncbi.nlm.nih.gov/2811970/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Shine B, McKnight RF, Leaver L, Geddes JR.</strong> <em>Long-term effects of lithium on renal, thyroid, and parathyroid function: a retrospective analysis of laboratory data.</em> Lancet. 2015;386(9992):461–468. doi: 10.1016/S0140-6736(14)61842-0. PMID 26003379. <a href="https://pubmed.ncbi.nlm.nih.gov/26003379/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Aiff H, Attman PO, Aurell M, Bendz H, Schön S, Svedlund J.</strong> <em>End-stage renal disease associated with prophylactic lithium treatment.</em> Eur Neuropsychopharmacol. 2014;24(4):540–544. doi: 10.1016/j.euroneuro.2014.01.002. PMID 24503277. Prevalencia RRT 15,0 ‰, RR 7,8. <a href="https://pubmed.ncbi.nlm.nih.gov/24503277/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Aiff H, Attman PO, Aurell M, Bendz H, Ramsauer B, Schön S, Svedlund J.</strong> <em>Effects of 10 to 30 years of lithium treatment on kidney function.</em> J Psychopharmacol. 2015;29(5):608–614. doi: 10.1177/0269881115573808. PMID 25735990. <a href="https://pubmed.ncbi.nlm.nih.gov/25735990/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Presne C, Fakhouri F, Noël LH, Stengel B, Even C, Kreis H, Mignon F, Grünfeld JP.</strong> <em>Lithium-induced nephropathy: Rate of progression and prognostic factors.</em> Kidney Int. 2003;64(2):585–592. doi: 10.1046/j.1523-1755.2003.00096.x. PMID 12846754. <a href="https://pubmed.ncbi.nlm.nih.gov/12846754/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bocchetta A, Ardau R, Fanni T, Sardu C, Piras D, Pani A, Del Zompo M.</strong> <em>Renal function during long-term lithium treatment: a cross-sectional and longitudinal study.</em> BMC Med. 2015;13:12. doi: 10.1186/s12916-014-0249-4. PMID 25604586. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC4300557/" target="_blank" rel="noopener noreferrer">PMC</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/25604586/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Boton R, Gaviria M, Batlle DC.</strong> <em>Prevalence, pathogenesis, and treatment of renal dysfunction associated with chronic lithium therapy.</em> Am J Kidney Dis. 1987;10(5):329–345. doi: 10.1016/S0272-6386(87)80098-7. PMID 3314489. <a href="https://pubmed.ncbi.nlm.nih.gov/3314489/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Wallin L, Alling C, Aurell M.</strong> <em>Impairment of renal function in patients on long-term lithium treatment.</em> Clin Nephrol. 1982;18(1):23–28. PMID 6749359. <a href="https://pubmed.ncbi.nlm.nih.gov/6749359/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Schoot TS, Molmans THJ, Grootens KP, Kerckhoffs APM.</strong> <em>Systematic review and practical guideline for the prevention and management of the renal side effects of lithium therapy.</em> Eur Neuropsychopharmacol. 2020;31:16–32. doi: 10.1016/j.euroneuro.2019.11.006. PMID 31837914. <a href="https://pubmed.ncbi.nlm.nih.gov/31837914/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Carter L, Zolezzi M, Lewczyk A.</strong> <em>An updated review of the optimal lithium dosage regimen for renal protection.</em> Can J Psychiatry. 2013;58(10):595–600. doi: 10.1177/070674371305801009. PMID 24165107. <a href="https://pubmed.ncbi.nlm.nih.gov/24165107/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Singh LK, Nizamie SH, Akhtar S, Praharaj SK.</strong> <em>Improving tolerability of lithium with a once-daily dosing schedule.</em> Am J Ther. 2011;18(4):288–291. doi: 10.1097/MJT.0b013e3181d070c3. PMID 20592663. <a href="https://pubmed.ncbi.nlm.nih.gov/20592663/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Gomes-da-Costa S, Marx W, Corponi F, Anmella G, Murru A, Pons-Cabrera MT, Giménez-Palomo A, Gutiérrez-Arango F, Llach CD, Fico G, Kotzalidis GD, Verdolini N, Valentí M, Berk M, Vieta E, Pacchiarotti I.</strong> <em>Lithium therapy and weight change in people with bipolar disorder: A systematic review and meta-analysis.</em> Neurosci Biobehav Rev. 2022;134:104266. doi: 10.1016/j.neubiorev.2021.07.011. PMID 34265322. <a href="https://pubmed.ncbi.nlm.nih.gov/34265322/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Burdick KE, Millett CE, Russo M, Alda M, Alliey-Rodriguez N, Anand A, Balaraman Y, Berrettini W, Bertram H, Calabrese JR, Calkin C, Conroy C, Coryell W, DeModena A, Feeder S, Fisher C, Frazier N, Frye M, Gao K, Garnham J, Gershon ES, Glazer K, Goes FS, Goto T, Harrington GJ, Jakobsen P, Kamali M, Kelly M, Leckband S, Løberg EM, Lohoff FW, Maihofer AX, McCarthy MJ, McInnis M, Morken G, Nievergelt CM, Nurnberger J, Oedegaard KJ, Ortiz A, Ritchey M, Ryan K, Schinagle M, Schwebel C, Shaw M, Shilling P, Slaney C, Stapp E, Tarwater B, Zandi P, Kelsoe JR.</strong> <em>The association between lithium use and neurocognitive performance in patients with bipolar disorder.</em> Neuropsychopharmacology. 2020;45(10):1743–1749. doi: 10.1038/s41386-020-0683-2. PMID 32349118. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC7419515/" target="_blank" rel="noopener noreferrer">PMC</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/32349118/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bedford JJ, Weggery S, Ellis G, McDonald FJ, Joyce PR, Leader JP, Walker RJ.</strong> <em>Lithium-induced nephrogenic diabetes insipidus: renal effects of amiloride.</em> Clin J Am Soc Nephrol. 2008;3(5):1324–1331. doi: 10.2215/CJN.01640408. PMID 18596116. <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC2518801/" target="_blank" rel="noopener noreferrer">PMC</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/18596116/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>National Institute for Health and Care Excellence.</strong> <em>Depression in adults: treatment and management.</em> NICE guideline NG222. Lítium ako jedna z farmakologických možností pri nedostatočnej odpovedi; nie ako dôkaz rovnocenný udržiavacej liečbe bipolárnej poruchy. <a href="https://www.nice.org.uk/guidance/ng222" target="_blank" rel="noopener noreferrer">NICE NG222</a>.</li>
  <li><strong>Scott F, Hampsey E, Gnanapragasam S, Carter B, Marwood L, Taylor RW, Emre C, Korotkova L, Martín-Dombrowski J, Cleare AJ, Young AH, Strawbridge R.</strong> <em>Systematic review and meta-analysis of augmentation and combination treatments for early-stage treatment-resistant depression.</em> J Psychopharmacol. 2023;37(3):268–278. doi: 10.1177/02698811221104058. PMID 35861202. <a href="https://pubmed.ncbi.nlm.nih.gov/35861202/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Spracovaný zdroj je komentár Nassira Ghaemiho v Medscape (byline overený vo verejnej tiráži 3. 9. 2026). Autorstvo štúdií BALANCE, Shine, Aiff, Presne, Bocchetta, Gomes-da-Costa a ostatných citovaných prác sa do mapy zdrojových autorov nepridáva. Číslo 1–5 % chronického poškodenia obličiek pochádza z Ghaemiho výkladu PMID 32526812; abstrakt tohto prehľadu ho neobsahuje a plný text je za predplatným — údaj sme konfrontovali s Aiffom (ESRD ≈ 1,5 %), Presnem, Bocchettom, Shineom a Botonom (NDI). BALANCE: HR a počty z PubMed abstraktu PMID 20092882; pole-špecifické HR pre depresiu z otvoreného záznamu nevieme potvrdiť. Hmotnosť: +0,462 kg a p = 0,158 z abstraktu PMID 34265322; Ghaemiho „približne 20 %“ v ňom nie je. ISBD pásma a NICE hladiny/monitorovanie z PMC 6688930 a z verejného textu CG185. Jednotky mmol/l = mEq/l pre Li<sup>+</sup>.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Tento článok nenahrádza psychiatrické rozhodnutie o nasadení, pokračovaní ani vysadení lítia. Dávku, cieľovú hladinu a trvanie liečby treba individualizovať podľa diagnózy, veku, eGFR, interakcií a psychiatrického prínosu. Pri poklese funkcie obličiek patrí rozhodnutie na spoločný stôl psychiatra a nefrológa.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_litium-sedem-mytov-nefrologicka-perspektiva_article',
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
