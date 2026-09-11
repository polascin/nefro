<?php

/**
 * add_bmi-hematokrit-diabetes-2-typu-riziko-zlyhania-obliciek_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Odborný článok — spracovanie štúdie Renal Failure 2026;48(1):2687223
 * (doi 10.1080/0886022X.2026.2687223, PMID 42556871, PMC13446056)
 * po overení plného textu cez PubMed Central.
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
    'title'        => 'BMI a hematokrit pri diabete 2. typu: čo skutočne hovoria o riziku zlyhania obličiek',
    'slug'         => 'bmi-hematokrit-diabetes-2-typu-riziko-zlyhania-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Štúdia spojila mendelovskú randomizáciu s klinickým súborom a zostavila nomogram s AUC 0,88. Model však neobsahuje eGFR ani albuminúriu a abstrakt štúdie si protirečí s jej vlastnými výsledkami.',
    'content'      => <<<'HTML'
<p>Vyšší index telesnej hmotnosti a nižší hematokrit môžu u ľudí s diabetom 2. typu upozorňovať na zvýšené riziko zlyhania obličiek. Nová štúdia spojila analýzu genetických údajov s retrospektívnym sledovaním klinického súboru a vytvorila predikčný model s dobrou rozlišovacou schopnosťou.</p>

<p>Jej výsledky však nemožno interpretovať ako dôkaz, že samotné zvýšenie hematokritu zabráni progresii chronickej choroby obličiek. A hoci model dosiahol plochu pod krivkou 0,88, <strong>neobsahuje eGFR ani albuminúriu</strong> — teda práve tie dva ukazovatele, o ktoré sa opiera zavedené hodnotenie rizika.</p>

<h2>Dve analytické časti, dve odlišné otázky</h2>

<p>Štúdia kombinovala dvojvýberovú mendelovskú randomizáciu s retrospektívnou analýzou pacientov s diabetom 2. typu. Tieto prístupy sa môžu navzájom dopĺňať, neodpovedajú však na rovnakú otázku.</p>

<p>Mendelovská randomizácia používa genetické varianty ako inštrumentálne premenné na posudzovanie možného kauzálneho vzťahu medzi určitou vlastnosťou a sledovaným výsledkom. Klinická časť naopak hodnotila, ktoré charakteristiky pacientov súviseli s následným výskytom zlyhania obličiek a či z nich možno zostaviť prognostický model.</p>

<p>Genetické údaje pochádzali z databázy IEU OpenGWAS a boli filtrované na východoázijskú populáciu. Súbor pre diabetes 2. typu (ebi-a-GCST010118) zahŕňal 433 540 osôb, z toho 77 418 prípadov a 356 122 kontrol.</p>

<h3>Kľúčový detail: výsledkom genetickej analýzy nebolo zlyhanie obličiek</h3>

<p>Ako obličkový výsledok slúžil samostatný genetický súbor pre <strong>chronické zlyhávanie obličiek</strong> (ebi-a-GCST90018602) so 176 462 osobami. Toto číslo však treba čítať presne: zahŕňalo iba <strong>2 117 prípadov</strong> a 174 345 kontrol.</p>

<p>Sú to dve dôležité obmedzenia naraz:</p>

<ul>
  <li>Genetická časť nebola obmedzená na pacientov s diabetom 2. typu — autori uvádzajú, že podskupinová analýza nebola možná pre chýbajúce súhrnné údaje pre túto populáciu.</li>
  <li>Výsledkový fenotyp <em>chronic renal failure</em> nebol totožný s klinicky sledovanou progresiou do konečného štádia. Autori to v obmedzeniach výslovne priznávajú a upozorňujú, že ide o rozdielne štádiá kontinua.</li>
</ul>

<p>Genetickú časť preto nemožno bez výhrad opisovať ako dôkaz progresie diabetickej choroby obličiek do potreby dialýzy. Pri 2 117 prípadoch je navyše štatistická sila pre menej silné expozície obmedzená.</p>

<p>Ani samotná prítomnosť diabetu u pacienta s chronickou chorobou obličiek automaticky nedokazuje diabetickú etiológiu poškodenia. Diabetická choroba obličiek je klinická diagnóza, pri ktorej treba zohľadniť priebeh ochorenia, močový nález a prípadné známky inej nefropatie.</p>

<h2>Čo ukázala genetická analýza</h2>

<p>Základnou metódou bolo váženie inverzným rozptylom (IVW), pleiotropia a heterogenita sa hodnotili regresiou MR-Egger a Cochranovým Q testom, odľahlé hodnoty sa odstraňovali metódou MR-PRESSO.</p>

<div class="table-responsive" role="region" aria-label="Výsledky jednorozmernej mendelovskej randomizácie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Expozícia (na 1 smerodajnú odchýlku)</th>
      <th scope="col">Pomer šancí pre chronické zlyhávanie obličiek</th>
      <th scope="col">95 % IS</th>
      <th scope="col">p</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Glukóza</th><td>2,406</td><td>1,470–3,930</td><td>0,00044</td></tr>
    <tr><th scope="row">Index telesnej hmotnosti</th><td>1,630</td><td>1,090–2,430</td><td>0,016</td></tr>
    <tr><th scope="row">Genetická predispozícia k diabetu 2. typu</th><td>1,291</td><td>1,190–1,400</td><td>1,37 × 10⁻¹⁰</td></tr>
    <tr><th scope="row">Hematokrit</th><td>0,513</td><td>0,320–0,820</td><td>0,00497</td></tr>
  </tbody>
</table>
</div>

<p>Vo viacrozmernom modeli, ktorý zohľadňoval súčasne diabetes 2. typu, zostal hematokrit ochranným faktorom s pomerom šancí 0,492 (95 % IS 0,320–0,756; p = 1,20 × 10⁻³).</p>

<h3>Rozpor o sile inštrumentov má vysvetlenie</h3>

<p>Abstrakt uvádza, že všetky inštrumentálne premenné mali F-štatistiku vyššiu ako 10. Sprievodná správa zároveň uvádzala vyradenie glukózy pre slabý inštrument s F-štatistikou 5,65. Plný text tento zdanlivý rozpor rieši: glukóza bola vyradená <strong>z viacrozmernej</strong> analýzy práve pre F = 5,65, pričom jej asociácia s výsledkom bola ďaleko od významnosti (p = 0,671). Tvrdenie o F &gt; 10 sa vzťahuje na inštrumenty ponechané v analýze.</p>

<p>Klinicky je to však nepríjemné zistenie: glukóza mala v jednorozmernej analýze najsilnejší účinok vôbec (pomer šancí 2,41), no práve tento odhad stojí na najslabšom inštrumente. Podobne treba pristupovať k údaju o glykovanom hemoglobíne — jeho genetický súbor (ukb-e-30750_EAS) zahŕňal len 2 566 osôb.</p>

<h3>Prečo je pri hematokrite predpoklad bez pleiotropie krehký</h3>

<p>Mendelovská randomizácia obmedzuje spätnú kauzalitu a časť zavádzajúcich vplyvov, jej kauzálna interpretácia však platí len za splnenia predpokladov: varianty musia dostatočne súvisieť s expozíciou, nesmú súvisieť so zavádzajúcimi faktormi a nemajú ovplyvňovať výsledok inou cestou než cez skúmanú expozíciu.</p>

<p>Pri hematokrite je posledný predpoklad obzvlášť dôležitý — a samotné výsledky štúdie ho spochybňujú. Metóda MR-PRESSO musela pri hematokrite odstrániť tri odľahlé varianty, medzi nimi <strong>rs855791</strong>. Ide o dobre známy variant génu <em>TMPRSS6</em>, ktorý patrí medzi hlavné determinanty metabolizmu železa. Presne takto vyzerá horizontálna pleiotropia: varianty ovplyvňujúce erytropoézu súčasne zasahujú do hospodárenia so železom. Pri indexe telesnej hmotnosti bolo odstránených dokonca osem odľahlých variantov.</p>

<p>Neprítomnosť štatisticky významného výsledku testu pleiotropie po odstránení odľahlých hodnôt preto nie je dôkazom, že pleiotropia neexistuje.</p>

<h2>Čo ukázal klinický súbor</h2>

<p>Retrospektívna časť zahŕňala 875 dospelých s diabetom 2. typu z pracoviska Qingpu Branch of Zhongshan Hospital pri Univerzite Fudan v Šanghaji, zaradených od 1. januára 2016 do 31. decembra 2023 a sledovaných tri roky. Do výsledku označeného ako <em>end-stage renal disease</em> dospelo 140 pacientov (16 %), 735 pacientov nie.</p>

<p>Vylúčení boli okrem iného pacienti s biopticky preukázaným primárnym glomerulovým ochorením alebo systémovým ochorením, pacienti už liečení dialýzou alebo po transplantácii, pacienti s infekciou, srdcovou či pečeňovou nedostatočnosťou, nádorovým ochorením, so solitárnou obličkou, s toxickým poškodením obličiek — a napokon aj pacienti s neúplnými údajmi alebo stratení zo sledovania.</p>

<p>Podiel 16 % nie je odhadom trojročného rizika pre všetkých ľudí s diabetom 2. typu. Ide o podiel udalostí v takto vybranom súbore, ktorý bol cielene očistený od iných príčin poškodenia obličiek a zároveň o pacientov so stratou zo sledovania.</p>

<div class="table-responsive" role="region" aria-label="Výsledky viacrozmernej logistickej regresie v klinickom súbore" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Premenná</th>
      <th scope="col">Zmena</th>
      <th scope="col">Pomer šancí</th>
      <th scope="col">95 % IS</th>
      <th scope="col">p</th>
    </tr>
  </thead>
  <tbody>
    <tr><th scope="row">Index telesnej hmotnosti</th><td>na 1 kg/m²</td><td>1,085</td><td>1,026–1,147</td><td>0,004</td></tr>
    <tr><th scope="row">Systolický krvný tlak</th><td>na 1 mm Hg</td><td>1,020</td><td>1,008–1,032</td><td>&lt; 0,001</td></tr>
    <tr><th scope="row">Sérový kreatinín</th><td>na 1 µmol/l</td><td>1,018</td><td>1,014–1,022</td><td>&lt; 0,001</td></tr>
    <tr><th scope="row">Hematokrit</th><td>na 1 percentuálny bod</td><td>0,940</td><td>0,891–0,993</td><td>0,027</td></tr>
    <tr><th scope="row">Albumín</th><td>na 1 g/l</td><td>0,953</td><td>0,913–0,995</td><td>0,027</td></tr>
  </tbody>
</table>
</div>

<p>Kyselina močová a vápnik boli významné v jednorozmernej analýze, po posúdení multikolinearity však vo viacrozmernom modeli významnosť stratili.</p>

<h3>Abstrakt štúdie si protirečí s jej vlastnými výsledkami</h3>

<p>Abstrakt pôvodnej práce uvádza medzi nezávislými rizikovými faktormi <strong>diastolický</strong> krvný tlak. Výsledková časť plného textu však v jednorozmernej aj viacrozmernej analýze konzistentne uvádza <strong>systolický</strong> krvný tlak (pomer šancí 1,020; 95 % IS 1,008–1,032; p &lt; 0,001).</p>

<p>Ide o chybu v abstrakte, nie v sprievodnom spravodajstve — správa, ktorá uvádzala systolický tlak, bola v zhode s plným textom. Pri preberaní údajov z tejto publikácie preto treba vychádzať z výsledkovej časti, nie z abstraktu.</p>

<h2>Vyšší BMI: vierohodný rizikový faktor, nie samostatná diagnóza</h2>

<p>V genetickej aj klinickej časti sa vyšší BMI spájal s nepriaznivejším obličkovým výsledkom. Takáto zhoda podporuje záujem o úlohu adipozity pri poškodení obličiek, sama osebe však neurčuje veľkosť prínosu konkrétnej intervencie.</p>

<p>Nadmerná adipozita môže k poškodeniu obličiek prispievať viacerými cestami: súvisí s inzulínovou rezistenciou, hypertenziou, zmenami glomerulovej hemodynamiky, aktiváciou neurohumorálnych systémov a zápalovými procesmi. Časť rizika môže sprostredkovať diabetes a zvýšený krvný tlak, časť môže súvisieť s priamym zaťažením obličiek.</p>

<p>BMI má však dôležité obmedzenia. Nerozlišuje tukovú a svalovú hmotu, nevyjadruje rozloženie telesného tuku a pri retencii tekutín môže stúpať bez skutočného nárastu adipozity. U pacienta s chronickou chorobou obličiek preto treba telesnú hmotnosť interpretovať spolu s objemovým stavom, nutričným stavom a vývojom svalovej hmoty.</p>

<p>Rovnako nemožno automaticky považovať každý pokles BMI za priaznivý. Úmyselná redukcia nadmernej tukovej hmoty sa klinicky zásadne odlišuje od neúmyselného chudnutia pri zápale, sarkopénii alebo proteínovo-energetickom chradnutí.</p>

<p>Geneticky podmienený rozdiel v BMI počas celého života navyše nie je ekvivalentom krátkodobého zníženia hmotnosti diétou, liekom alebo bariatrickým zákrokom. Výsledok mendelovskej randomizácie preto nemožno priamo previesť na očakávaný účinok konkrétnej liečby.</p>

<h2>Nižší hematokrit môže byť markerom pokročilosti ochorenia</h2>

<p>Hematokrit vyjadruje podiel objemu erytrocytov na celkovom objeme krvi. Nižšia hodnota môže sprevádzať anémiu, ale ovplyvňuje ju aj objem plazmy. Nie je preto úplne zameniteľná s koncentráciou hemoglobínu ani so samotnou masou erytrocytov.</p>

<p>U pacientov s chronickou chorobou obličiek môže nižší hematokrit súvisieť s nedostatočnou tvorbou erytropoetínu, nedostatkom železa, obmedzenou dostupnosťou železa pri zápale, krvácaním, skráteným prežívaním erytrocytov alebo hemodilúciou pri hyperhydratácii.</p>

<h3>Vysvetlenie autorov je zároveň argumentom proti kauzalite</h3>

<p>Autori v diskusii ponúkajú ako možný mechanizmus účinok inhibítorov SGLT2: znížením tubulárnej reabsorpcie glukózy sa zmierňuje metabolická záťaž proximálneho tubulu, stimuluje sa tvorba erytropoetínu a hematokrit mierne stúpa.</p>

<p>Toto vysvetlenie je biologicky vierohodné — má však dôsledok, ktorý autori nedomýšľajú. Ak vyšší hematokrit odráža užívanie inhibítorov SGLT2, potom v retrospektívnom klinickom súbore <strong>nemeria vlastnosť krvi, ale liečbu s preukázaným nefroprotektívnym účinkom</strong>. Priaznivá asociácia hematokritu by tak bola z podstatnej časti zavádzajúca podľa indikácie, nie kauzálna. Štúdia liečbu inhibítormi SGLT2 medzi premennými neuvádza, takže túto možnosť nemožno ani potvrdiť, ani vylúčiť.</p>

<p>Podobne treba interpretovať albumín. Nižšia sérová koncentrácia nemusí znamenať iba nedostatočnú výživu — ovplyvňujú ju zápal, straty bielkovín močom, ochorenie pečene aj objemový stav. Prognostická asociácia preto nie je dôkazom, že samotné zvýšenie laboratórnej hodnoty zlepší obličkové výsledky.</p>

<h2>Vyšší hematokrit ako priaznivý marker neznamená cieľ liečby</h2>

<p>Najdôležitejším klinickým rozlíšením je rozdiel medzi markerom rizika a liečebným cieľom. Zo zistenia, že vyšší hematokrit súvisí s nižším rizikom zlyhania obličiek, <strong>nevyplýva odporúčanie farmakologicky normalizovať hematokrit alebo hemoglobín s cieľom spomaliť progresiu chronickej choroby obličiek</strong>.</p>

<p>Randomizovaná štúdia CHOIR u 1 432 pacientov s chronickou chorobou obličiek porovnávala liečbu epoetínom alfa s cieľovou koncentráciou hemoglobínu 13,5 g/dl oproti 11,3 g/dl. Vyšší cieľ bol spojený so <strong>zvýšeným</strong> rizikom zloženého výsledku zahŕňajúceho úmrtie, infarkt myokardu, hospitalizáciu pre srdcové zlyhávanie a cievnu mozgovú príhodu — pomer rizík 1,34 (95 % IS 1,03–1,74; p = 0,03) — bez akéhokoľvek zlepšenia kvality života.</p>

<p>CHOIR priamo netestovala nový prognostický model. Názorne však ukazuje, prečo nemožno priaznivú observačnú asociáciu vyššej krvnej hodnoty zamieňať za prospešnosť jej intenzívnej liečebnej korekcie. Ide o rovnaký typ omylu, ktorý by hrozil pri mechanickom čítaní tejto štúdie.</p>

<p>Nález nízkeho hematokritu má viesť k objasneniu príčiny a k primeranej liečbe anémie, nie k snahe dosiahnuť čo najvyššiu hodnotu. Rozhodovanie sa opiera predovšetkým o koncentráciu hemoglobínu, príznaky, stav železa, pridružené ochorenia, transfúzne riziko a riziká zvolenej liečby.</p>

<h2>Dobrý model ešte nemusí byť klinicky použiteľný</h2>

<p>Autori vytvorili nomogram, teda grafický nástroj na výpočet odhadovaného rizika. Model založený na logistickej regresii dosiahol plochu pod krivkou ROC 0,880 (95 % IS 0,850–0,910) s dobrou kalibráciou a prekonal modely XGBoost, náhodný les aj metódu podporných vektorov. Interná validácia s 500 bootstrapovými prevýbermi dala korigovanú hodnotu 0,878 (95 % IS 0,850–0,908). Autori vykonali aj analýzu rozhodovacej krivky s hodnotením čistého prínosu pri prahových pravdepodobnostiach od 0 % do 50 %.</p>

<p><strong>AUC 0,88 neznamená, že model správne predpovedal výsledok u 88 % pacientov.</strong> Ide o mieru diskriminácie, nie o celkovú percentuálnu správnosť, citlivosť pri konkrétnom prahu ani o záruku presnosti individuálneho odhadu rizika.</p>

<h3>Najväčšia slabina: chýba eGFR a albuminúria</h3>

<p>Model obsahuje sérový kreatinín — ale nie odhadovanú glomerulovú filtráciu ani albuminúriu. To má dva dôsledky.</p>

<p>Po prvé, zahrnutie kreatinínu medzi prediktory zlyhania obličiek je do značnej miery tautologické: kreatinín <em>je</em> mierou funkcie obličiek. Vysoká hodnota AUC je preto pravdepodobne v rozhodujúcej miere daná východiskovou funkciou obličiek, nie prínosom BMI a hematokritu. Štúdia neuvádza, o koľko sa diskriminácia zlepší po pridaní týchto dvoch premenných k modelu založenému na funkcii obličiek — a práve to je otázka, ktorá rozhoduje o klinickej užitočnosti.</p>

<p>Po druhé, albuminúria je pri diabetickej chorobe obličiek najsilnejším samostatným prediktorom progresie. Prognostický model zlyhania obličiek, ktorý ju neobsahuje, nemožno porovnávať so zavedenými nástrojmi. Rovnica Kidney Failure Risk Equation, ktorú Tangri a spolupracovníci overili na dvoch nezávislých kanadských kohortách, vo svojej štvorpremennej verzii zahŕňa vek, pohlavie, eGFR a pomer albumínu ku kreatinínu v moči a v validačnej kohorte dosiahla C-štatistiku 0,841.</p>

<p>Interná validácia pomáha odhadnúť optimizmus modelu vytvoreného na dostupných údajoch. Nenahrádza však externú validáciu v inom centre, zdravotníckom systéme alebo populácii. Z dostupných podkladov nemožno overiť, či nový model poskytuje pridanú hodnotu oproti modelu založenému na eGFR a albuminúrii.</p>

<p>Výsledok tiež nepreukazuje všeobecnú prevahu logistickej regresie nad strojovým učením. Pri 140 udalostiach a piatich premenných je jednoduchý model očakávane stabilnejší než metódy s množstvom ladených parametrov; výkonnosť závisí od veľkosti súboru, počtu udalostí, nastavenia modelov, výberu premenných a validačného postupu.</p>

<p>Pri prognóze zlyhania obličiek treba napokon zohľadniť čas do udalosti a úmrtie ako konkurenčnú udalosť. Logistický model pri pevnom časovom horizonte môže byť primeraný, ak je výsledok spoľahlivo známy u všetkých pacientov. Vylúčenie pacientov stratených zo sledovania však naznačuje, že cenzorovanie sa riešilo vyradením, nie modelovaním.</p>

<h2>Čo z výsledkov vyplýva pre prax</h2>

<p>BMI a hematokrit sú lacné a bežne dostupné údaje, ktoré môžu dopĺňať klinický obraz. Nenahrádzajú však vyšetrenie glomerulovej filtrácie a albuminúrie.</p>

<p>KDIGO 2024 odporúča pri hodnotení chronickej choroby obličiek vychádzať z príčiny ochorenia, kategórie glomerulovej filtrácie a kategórie albuminúrie. Pri CKD v kategóriách G3 až G5 odporúča na odhad absolútneho rizika zlyhania obličiek externe validovanú prognostickú rovnicu.</p>

<p>Vyšší BMI má viesť k posúdeniu adipozity, metabolických rizík a objemového stavu. Nižší hematokrit má viesť k hodnoteniu hemoglobínu a príčin anémie. Ani jeden z týchto údajov by sa nemal interpretovať izolovane.</p>

<p>Liečba pacienta s diabetom 2. typu a chronickou chorobou obličiek sa naďalej opiera o postupy s preukázaným klinickým prínosom: primeraná kontrola krvného tlaku a glykémie, blokáda renínovo-angiotenzínového systému pri príslušnej indikácii a nefroprotektívna liečba podľa funkcie obličiek, albuminúrie, kaliémie a ďalších charakteristík pacienta. KDIGO 2024 zahŕňa do týchto postupov inhibítory SGLT2 a u vhodne vybraných pacientov aj nesteroidný antagonista mineralokortikoidového receptora.</p>

<p>Nová štúdia tieto odporúčania nemení. Prináša hypotézu o doplnkovom prognostickom význame BMI a hematokritu a predstavuje model, ktorý si zaslúži ďalšie overenie.</p>

<h2>Čo zostáva neoverené</h2>

<p>Aj po prečítaní plného textu zostávajú dva body otvorené:</p>

<ul>
  <li><strong>Prevádzková definícia výsledku.</strong> Práca nikde presne neuvádza, či <em>ESRD</em> znamenalo začatie dialýzy, transplantáciu, trvalo nízku eGFR alebo kombinovaný výsledok. Tieto možnosti nie sú zameniteľné a ovplyvňujú interpretáciu 16 % výskytu.</li>
  <li><strong>Východisková funkcia obličiek a albuminúria.</strong> Práca ich neuvádza medzi premennými modelu ani medzi opísanými charakteristikami súboru, takže nemožno posúdiť, v akom štádiu CKD pacienti vstupovali do sledovania.</li>
</ul>

<h2>Klinický význam bez neprimeraných záverov</h2>

<p>Najpresnejšie posolstvo štúdie je, že vyšší BMI a nižší hematokrit boli konzistentne spojené s nepriaznivejšími obličkovými výsledkami v dvoch rozdielnych analytických prístupoch. Prenositeľnosť obmedzujú rozdielne výsledkové ukazovatele oboch častí, malý počet prípadov v genetickom súbore výsledku, populačná špecifickosť východoázijských údajov, retrospektívny jednocentrový dizajn a chýbajúca externá validácia.</p>

<p>Hematokrit môže upozorniť na rizikového pacienta, ale nemožno z neho na základe tejto práce urobiť nový nefroprotektívny liečebný cieľ. BMI môže prispieť k hodnoteniu rizika, ale nenahrádza posúdenie telesného zloženia a objemového stavu. A nomogram s vysokou AUC sa stáva klinicky užitočným až vtedy, keď spoľahlivo funguje aj mimo pôvodného súboru, obsahuje zavedené prediktory a jeho použitie zlepšuje rozhodovanie.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=cielovy-systolicky-tlak-120-ckd-kdigo-realna-prax">Cieľový systolický tlak pod 120 mm Hg pri chronickej chorobe obličiek sa v praxi uplatňuje len obmedzene</a></li>
  <li><a href="article.php?slug=vychodiskova-egfr-biopsia-imputacia-glomerulove-ochorenia">Východisková eGFR pri biopsii obličky: ako jej výber a imputácia môžu skresliť výsledky observačných štúdií</a></li>
  <li><a href="article.php?slug=anemia-ckd-2026-prakticky-algoritmus-esa-hif-phi">Anémia pri CKD 2026 prakticky: algoritmus od diagnostiky po ESA a HIF-PHI podľa KDOQI US Commentary</a></li>
</ul>

<hr>

<p><small><em><strong>Spracovaný zdroj:</strong> Wang Y, Guo X, Li Y, Fu Q, Zhang C, Bai S. A study on risk factors for the progression from T2DM to end-stage renal disease based on Mendelian randomization and logistic regression analysis. <em>Renal Failure</em>. 2026;48(1):2687223. doi: 10.1080/0886022X.2026.2687223. <a href="https://pubmed.ncbi.nlm.nih.gov/42556871/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13446056/" target="_blank" rel="noopener noreferrer">plný text v PubMed Central</a>.</em></small></p>

<p><small><em><strong>Sprievodná správa:</strong> BMI and Hematocrit Predict ESRD Risk in Type 2 Diabetes. ReachMD (autor neuvedený). <a href="https://reachmd.com/news/bmi-and-hematocrit-predict-esrd-risk-in-type-2-diabetes/2488225/" target="_blank" rel="noopener noreferrer">reachmd.com</a>.</em></small></p>

<p><small><em><strong>Odporúčanie KDIGO:</strong> Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group. KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. <em>Kidney International</em>. 2024;105(4S):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">kdigo.org</a>.</em></small></p>

<p><small><em><strong>Randomizovaná štúdia CHOIR:</strong> Singh AK, Szczech L, Tang KL, Barnhart H, Sapp S, Wolfson M, Reddan D; CHOIR Investigators. Correction of anemia with epoetin alfa in chronic kidney disease. <em>New England Journal of Medicine</em>. 2006;355(20):2085–2098. doi: 10.1056/NEJMoa065485. <a href="https://pubmed.ncbi.nlm.nih.gov/17108343/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>

<p><small><em><strong>Rovnica Kidney Failure Risk Equation:</strong> Tangri N, Stevens LA, Griffith J, Tighiouart H, Djurdjev O, Naimark D, Levin A, Levey AS. A predictive model for progression of chronic kidney disease to kidney failure. <em>JAMA</em>. 2011;305(15):1553–1559. doi: 10.1001/jama.2011.451. <a href="https://pubmed.ncbi.nlm.nih.gov/21482743/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></p>
HTML,
];

// ── Vloženie / aktualizácia ───────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_bmi_hematokrit_t2dm_esrd',
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
