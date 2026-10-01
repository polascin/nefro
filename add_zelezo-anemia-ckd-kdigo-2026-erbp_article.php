<?php
/**
 * add_zelezo-anemia-ckd-kdigo-2026-erbp_article.php
 * ════════════════════════════════════════════════════════════════════════════
 * Vloženie odborného článku: liečba nedostatku železa pri anémii v CKD podľa
 * KDIGO 2026 — prahy iniciácie, proaktívna i.v. substitúcia, bezpečnostný rámec
 * a európsky komentár ERBP.
 * Autor projektu: MUDr. Ľubomír Polaščín. Ide o odborné zhrnutie odporúčaní
 * (KDIGO 2026, kapitola 2) a primárnych štúdií (PIVOTAL, FIND-CKD) spolu
 * s komentárom ERBP — nie o preklad jedného zdrojového článku, preto sa do
 * source_authors.php nedopĺňajú pôvodní autori.
 * Číselné údaje overené proti plnému textu odporúčaní (kidigo.org PDF),
 * plnému textu komentára ERBP (PMC13423824) a abstraktom v PubMede.
 * Postup: git commit (SFTP deploy) → spustenie cez SSH (php …/add_…php).
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
    'title'        => 'Železo pri anémii v CKD podľa KDIGO 2026: prahy iniciácie, proaktívna i.v. substitúcia a európsky pohľad ERBP',
    'slug'         => 'zelezo-anemia-ckd-kdigo-2026-erbp',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Druhá kapitola odporúčaní KDIGO 2026 posúva liečbu železa pri anémii v CKD smerom k proaktívnej substitúcii — ale všetky štyri odporúčania majú stupeň 2D. Prehľad prahov pre hemodialýzu aj pre pacientov mimo nej, dôkazový základ v štúdiách PIVOTAL a FIND-CKD, bezpečnostné limity, zvládanie reakcií na i.v. železo a kritické body, v ktorých sa európsky komentár ERBP od odporúčaní odkláňa.',
    'content'      => <<<'HTML'
<figure><a href="img/zelezo-anemia-ckd-kdigo-2026.webp" rel="noopener noreferrer" target="_blank"><img src="img/zelezo-anemia-ckd-kdigo-2026.webp" alt="Infúzna linka privádza prúd roztaveného železa k červenej krvinke, ktorá sa ním rozsvieti, zatiaľ čo obrovská zásoba železa horí uzamknutá za ťažkými železnými mrežami" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná scéna, nie mikroskopický záznam. Pri zápale uzatvára hepcidín železo v makrofágoch — zásoby sú plné, ale erytropoéza hladuje. Intravenózne železo túto bariéru obchádza; práve na tom stojí celá druhá kapitola odporúčaní KDIGO 2026.</figcaption></figure>

<p>Anémia pri chronickej chorobe obličiek (CKD) má málokedy jedinú príčinu. Popri nedostatočnej tvorbe erytropoetínu a skrátenom prežívaní erytrocytov stojí <strong>porucha hospodárenia so železom</strong> — a práve tá je najčastejšie a najlacnejšie korigovateľná. Odporúčania <strong>KDIGO 2026</strong> venujú železu samostatnú druhú kapitolu a oproti dokumentu z roku 2012 posúvajú manažment smerom k <em>proaktívnej</em> substitúcii — najvýraznejšie u pacientov na hemodialýze. Pre pacientov mimo dialýzy znamenajú podľa komentára ERBP jednoznačný odklon od konzervatívneho európskeho stanoviska z roku 2013.</p>

<p>Tento článok rozoberá kapitolu o železe podrobne a dopĺňa ju o <strong>komentár European Renal Best Practice (ERBP)</strong>, ktorý vyšiel v <em>Nephrology Dialysis Transplantation</em> v roku 2026 a ktorý na niekoľkých miestach formuluje európsku výhradu. Širší kontext celého dokumentu vrátane ESA a HIF-PHI rozoberá samostatný článok <a href="article.php?slug=anemia-ckd-kdigo-2026-kdoqi-komentar">o americkom komentári KDOQI</a>; praktické zhrnutie na jednu stranu nájdete v <a href="article.php?slug=anemia-ckd-checklist-kdigo-2026-kdoqi">checkliste do praxe</a>.</p>

<h2>Čo treba vedieť skôr, než sa začnú citovať čísla: všetko sú to „2D“ odporúčania</h2>

<p>Štyri odporúčania druhej kapitoly (2.1 až 2.4) sú <strong>bez výnimky stupňa 2D</strong> — teda <em>slabé odporúčanie</em> opreté o <em>veľmi nízku istotu dôkazov</em>. V jazyku GRADE to znamená „navrhujeme“, nie „odporúčame“, a explicitne pripúšťa, že informovaní pacienti sa budú rozhodovať rôzne. Jedenásť praktických bodov (practice points) nie je odstupňovaných vôbec — ide o názor pracovnej skupiny bez systematického prehľadu.</p>

<p>Táto poznámka nie je formalita. Prahy uvedené nižšie sa v praxi rýchlo menia na pevné čísla v protokoloch a v auditoch, hoci pôvodný dokument ich takto nemyslí. Ak sa u konkrétneho pacienta rozhodnete inak, nejdete proti „silnému odporúčaniu“ — idete v priestore, ktorý si dokument sám ponecháva otvorený.</p>

<h2>Nová terminológia: koniec „absolútneho“ a „funkčného“ deficitu železa</h2>

<p>Pracovná skupina KDIGO premenovala dva zaužívané pojmy tak, aby lepšie zodpovedali fyziológii:</p>

<div class="table-responsive" role="region" aria-label="Nová a stará terminológia deficitu železa pri CKD" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Pôvodný názov</th><th scope="col">Nový názov podľa KDIGO 2026</th><th scope="col">Orientačná definícia</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Absolútny deficit železa</th><td>Systémový nedostatok železa<br><em>(systemic iron deficiency)</em></td><td>TSAT &lt; 20 % a zároveň ferritín &lt; 100 ng/ml pri CKD bez dialýzy, resp. ferritín &lt; 200 ng/ml pri CKD G5HD</td></tr>
    <tr><th scope="row">Funkčný deficit železa</th><td>Erytropoéza obmedzená železom<br><em>(iron-restricted erythropoiesis)</em></td><td>Ferritín &gt; 100 – 200 ng/ml pri TSAT &lt; 20 %</td></tr>
  </tbody>
</table>
<p><em>Podľa obrázka 2 a obrázka 3 výkonného súhrnu KDIGO 2026. Ide o orientačné, nie absolútne hranice.</em></p>
</div>

<p>Rozdiel je mechanistický. Pri <strong>systémovom nedostatku</strong> chýba železo v obehu aj v zásobách; hepcidín je potlačený a makrofágy uvoľňujú, čo majú. Pri <strong>erytropoéze obmedzenej železom</strong> sú zásoby dostatočné, ale zápalom indukovaný hepcidín blokuje feroportín, železo zostáva uzamknuté v makrofágoch a k erytroblastom sa nedostane. Práve druhý stav vysvetľuje, prečo môže suplementácia zvýšiť hemoglobín aj pri hodnotách, ktoré na prvý pohľad deficit nepripomínajú.</p>

<h2>Diagnostika: čo vyšetriť hneď a kedy panel rozšíriť</h2>

<p>Základná sada pri podozrení na anémiu v CKD je krátka: <strong>krvný obraz, retikulocyty, ferritín a TSAT</strong>. Anémia sa diagnostikuje pri hemoglobíne &lt; 130 g/l u mužov a &lt; 120 g/l u žien. Ak úvodné testy príčinu nevysvetlia, dokument navrhuje rozšírený panel: krvný náter, haptoglobín a LDH, CRP, vitamín B12, folát, pečeňové testy, elektroforézu bielkovín s imunofixáciou, voľné ľahké reťazce, Bence-Jonesovu bielkovinu v moči, TSH a vyšetrenie stolice; parathormón podľa klinickej indikácie s odkazom na odporúčania KDIGO 2024 pre CKD-MBD.</p>

<p>Dva body si zaslúžia zvýraznenie:</p>

<ul>
  <li><strong>Ferritín &lt; 45 ng/ml</strong> alebo mikrocytová anémia (stredný objem erytrocytu &lt; 80 fl) má viesť k <strong>cielenému pátraniu po zdroji krvácania</strong> a podľa klinického úsudku k odoslaniu ku gastroenterológovi, gynekológovi alebo urológovi. Substitúcia železa bez tejto úvahy môže zamaskovať karcinóm hrubého čreva.</li>
  <li>Vitamín B12 a folát <strong>nie sú</strong> súčasťou úvodného panela, len rozšíreného. Komentár ERBP to považuje za slabinu: folát sa pri liečbe ESA spotrebúva a účinne sa odstraňuje dialýzou, vitamín B12 sa odstraňuje najmä pri high-flux technikách, mnohé potraviny bohaté na B12 majú pre dialyzovaných nevhodný obsah elektrolytov a dialyzačná populácia je prevažne staršia, krehká a polypragmaticky liečená. Oba deficity sú navyše modifikovateľným rizikovým faktorom kognitívneho poškodenia.</li>
</ul>

<h2>Kedy začať liečbu železom: prah závisí od dialyzačného statusu</h2>

<div class="table-responsive" role="region" aria-label="Prahy pre začatie liečby železom podľa KDIGO 2026" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Skupina</th><th scope="col">Začať železo, ak</th><th scope="col">Cesta podania</th><th scope="col">Stupeň</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">CKD G5 na hemodialýze (G5HD)</th><td>ferritín ≤ 500 ng/ml <strong>a</strong> TSAT ≤ 30 %</td><td>Prednostne <strong>intravenózne</strong> pred perorálnym (odporúčanie 2.2)</td><td>2D</td></tr>
    <tr><th scope="row">CKD bez dialýzy a CKD G5 na peritoneálnej dialýze (G5PD)</th><td>ferritín &lt; 100 ng/ml <strong>a</strong> TSAT &lt; 40 %,<br><strong>alebo</strong><br>ferritín 100 – 299 ng/ml <strong>a</strong> TSAT &lt; 25 %</td><td>Perorálne <strong>alebo</strong> intravenózne podľa hodnôt a preferencií pacienta, závažnosti anémie a deficitu, účinnosti, znášanlivosti, dostupnosti a ceny (odporúčanie 2.4)</td><td>2D</td></tr>
  </tbody>
</table>
<p><em>Odporúčania 2.1 až 2.4, KDIGO 2026. Všetky podmienky v stĺpci „Začať železo, ak“ musia platiť súčasne.</em></p>
</div>

<p>Prakticky najdôležitejší je ten tretí riadok, ktorý v tabuľke nie je: <strong>hranice pre hemodialýzu sú podstatne voľnejšie než pre ostatných</strong>. Pacient na hemodialýze s ferritínom 450 ng/ml a TSAT 28 % je podľa odporúčania kandidátom na železo; pacient v ambulancii s rovnakými hodnotami nie je.</p>

<h3>Čo na to ERBP</h3>

<p>Komentár obe sady prahov podporuje. Dve výhrady však formuluje ostro:</p>

<ul>
  <li><strong>Horná hranica TSAT &lt; 40 %</strong> v kombinácii s ferritínom &lt; 100 ng/ml je podľa ERBP sporná. Optimálna hodnota TSAT pre maximálnu odpoveď hemoglobínu na ESA sa pohybuje okolo 30 %, takže začínať železo pri ferritíne tesne pod 100 ng/ml a TSAT napríklad 35 % nemusí dávať zmysel. Na druhej strane observačné dáta (japonský register — menej kardiovaskulárnych príhod pri TSAT 30 – 40 % oproti 20 – 30 %; analýza so splajnami, kde najnižšie riziko vychádza okolo TSAT 40 %) hovoria opačne. ERBP uzatvára, že tieto údaje <strong>nestačia na podporu cieľovej hodnoty TSAT nad 40 %</strong>, ktorá by časom mohla viesť k akumulácii železa.</li>
  <li><strong>Pásmo ferritínu 100 – 299 ng/ml s TSAT &lt; 25 %</strong> nevychádza z randomizovaných dôkazov o prínose, ale z <em>vstupných kritérií</em> štúdií s ESA a HIF-PHI. Autori odporúčaní to priznávajú a uvádzajú, že prah prevzali kvôli zjednodušeniu.</li>
</ul>

<h2>Proaktívne i.v. železo pri hemodialýze: štúdia PIVOTAL</h2>

<p>Praktický bod 2.1 hovorí, že u hemodialyzovaných pacientov sa má i.v. železo podávať <strong>proaktívne, s cieľom udržať stabilný stav železa</strong> — nie reaktívne, až keď parametre spadnú. Tento posun stojí takmer výlučne na jednej štúdii.</p>

<p><strong>PIVOTAL</strong> randomizovala <strong>2141 dospelých</strong> v prvom roku hemodialýzy liečených ESA do dvoch ramien:</p>

<ul>
  <li><strong>proaktívne vysokodávkové</strong> železo-sacharóza 400 mg mesačne, pokiaľ ferritín nepresiahol 700 µg/l alebo TSAT nedosiahla 40 %,</li>
  <li><strong>reaktívne nízkodávkové</strong> 0 – 400 mg mesačne, spúšťané až pri ferritíne &lt; 200 µg/l alebo TSAT &lt; 20 %.</li>
</ul>

<p>Pri mediáne sledovania 2,1 roka dostávali pacienti v proaktívnej vetve medián 264 mg železa mesačne oproti 145 mg v reaktívnej. Výsledky:</p>

<ul>
  <li><strong>Primárny zložený ukazovateľ</strong> (nefatálny infarkt myokardu, nefatálna cievna mozgová príhoda, hospitalizácia pre srdcové zlyhávanie alebo úmrtie) nastal u <strong>29,3 % oproti 32,3 %</strong> pacientov — pomer rizík 0,85 (95 % IS 0,73 – 1,00); p &lt; 0,001 pre non-inferioritu a <strong>p = 0,04 pre superioritu</strong>.</li>
  <li>Pri analýze opakovaných príhod 429 oproti 507 udalostiam — pomer incidencií 0,77 (95 % IS 0,66 – 0,92).</li>
  <li><strong>Mesačná dávka ESA</strong> klesla z mediánu 38 805 IU na 29 757 IU (rozdiel mediánov −7539 IU; 95 % IS −9485 až −5582).</li>
  <li><strong>Výskyt infekcií bol v oboch ramenách rovnaký.</strong></li>
</ul>

<p>ERBP výsledok podporuje, ale vymedzuje hranice jeho platnosti: štúdia zahrnula <strong>incidentných</strong> pacientov na dialýze kratšie než rok, všetci boli liečení ESA (teda nie ESA-naivní), a vylúčení boli pacienti s krátkou očakávanou dĺžkou života, aktívnou malignitou, chronickým ochorením pečene, srdcovým zlyhávaním NYHA IV a tehotné. Zároveň upozorňuje na logickú pascu: PIVOTAL porovnávala <em>stratégie</em>, nie <em>cieľové hodnoty</em>. Z jej výsledku nevyplýva, že udržiavanie ferritínu okolo 400 ng/ml by bolo horšie než proaktívna schéma.</p>

<h2>CKD bez dialýzy: štúdia FIND-CKD</h2>

<p>Pre pacientov mimo hemodialýzy je hlavnou oporou <strong>FIND-CKD</strong> — 56-týždňová otvorená štúdia so <strong>626 pacientmi</strong> s CKD bez dialýzy, anémiou a deficitom železa, ktorí <strong>neboli liečení ESA</strong>. Randomizácia v pomere 1 : 1 : 2 do troch ramien:</p>

<div class="table-responsive" role="region" aria-label="Výsledky štúdie FIND-CKD" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Rameno</th><th scope="col">Primárny ukazovateľ</th><th scope="col">Porovnanie s perorálnym železom</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">i.v. ferric carboxymaltose, cieľový ferritín 400 – 600 µg/l</th><td>36 pacientov (23,5 %)</td><td>HR 0,65 (95 % IS 0,44 – 0,95); p = 0,026</td></tr>
    <tr><th scope="row">i.v. ferric carboxymaltose, cieľový ferritín 100 – 200 µg/l</th><td>49 pacientov (32,2 %)</td><td>bez významného rozdielu</td></tr>
    <tr><th scope="row">Perorálne železo</th><td>98 pacientov (31,8 %)</td><td>referencia</td></tr>
  </tbody>
</table>
<p><em>Primárnym ukazovateľom bol čas do začatia inej liečby anémie (ESA, iné železo alebo transfúzia) alebo pokles hemoglobínu pod 100 g/l v dvoch po sebe nasledujúcich meraniach medzi 8. a 52. týždňom.</em></p>
</div>

<p>Vzostup hemoglobínu bol vo vetve s vyšším cieľovým ferritínom väčší než pri perorálnom železe (p = 0,014) a vzostup o aspoň 10 g/l dosiahlo viac pacientov (HR 2,04; 95 % IS 1,52 – 2,72; p &lt; 0,001). Výskyt nežiaducich a závažných nežiaducich udalostí bol vo všetkých ramenách porovnateľný, bez renálnej toxicity a bez rozdielu v kardiovaskulárnych či infekčných príhodách.</p>

<p><strong>Poznámka k názvu.</strong> Skratka FIND-CKD sa používa pre <em>dve rôzne</em> štúdie. Pôvodná (<em>Ferinject assessment in patients with Iron deficiency anaemia and Non-Dialysis-dependent CKD</em>, 2014) je tá, o ktorej je reč tu. Novšia FIND-CKD z roku 2025 je štúdia <strong>finerenónu pri nediabetickej CKD</strong> a so železom nesúvisí. Pri citovaní je nutné rozlišovať.</p>

<h2>Kedy železo zadržať</h2>

<p>Praktický bod 2.2 uvádza, že je rozumné <strong>zadržať rutinné podávanie železa</strong>, ak:</p>

<ul>
  <li><strong>ferritín presiahne 700 ng/ml</strong>, alebo</li>
  <li><strong>TSAT dosiahne 40 %</strong>.</li>
</ul>

<p>Formulácia neodlišuje populácie, a práve tam smeruje výhrada ERBP: tieto hodnoty pochádzajú <strong>priamo z protokolu štúdie PIVOTAL</strong>, teda z prostredia hemodialýzy. Pre pacientov bez dialýzy je najväčšou relevantnou štúdiou FIND-CKD, ktorá pripúšťala ferritín najviac 600 ng/ml a odporúčala zadržať železo pri TSAT 40 % a viac. Z metodického hľadiska považuje ERBP v tejto populácii za rozumný cieľ ferritín <strong>400 – 600 ng/ml</strong>.</p>

<p>Druhé pravidlo je nezávislé od čísel: <strong>počas systémovej infekcie liečbu železom dočasne pozastavte</strong> (praktický bod 2.8). ERBP ho podporuje výslovne ako prejav opatrnosti — ani FIND-CKD, ani PIVOTAL, ani systematický prehľad zvýšené riziko infekcií nepreukázali, ale <em>všetky</em> protokoly podávanie železa počas infekcie prerušovali, takže dôkaz o bezpečnosti pri pokračovaní jednoducho neexistuje. Železo je pritom nevyhnutné pre množenie mnohých patogénov.</p>

<h2>Perorálne železo a kedy prepnúť na intravenózne</h2>

<p>Pri perorálnom železe nechávajú odporúčania voľbu prípravku a dávkovacej schémy na cene, preferencii pacienta, znášanlivosti a účinnosti (praktický bod 2.3). Rozhodovacie pravidlo je jednoduché a tvrdé:</p>

<p><strong>Ak optimálny perorálny režim po 1 až 3 mesiacoch nemá dostatočný efekt alebo ho pacient zle znáša, prejdite na i.v. železo</strong> (praktický bod 2.7). „Optimálny režim“ pritom znamená aj to, že pacient liek skutočne užíva — gastrointestinálna neznášanlivosť je najčastejším dôvodom tichého vysadenia.</p>

<p>ERBP dopĺňa dve novšie perorálne možnosti dostupné v Európskej únii:</p>

<ul>
  <li><strong>Ferric citrate</strong> (komplex citrátu železitého) je v EÚ indikovaný pri súčasne zvýšenom fosfáte a deficite železa u dospelých s CKD. V metaanalýze šiestich randomizovaných štúdií znižoval fosfát a zvyšoval hemoglobín, ferritín aj TSAT, ale za cenu častejších gastrointestinálnych nežiaducich účinkov oproti placebu.</li>
  <li><strong>Ferric maltol</strong> má vysokú biologickú dostupnosť, takže umožňuje účinnú substitúciu nižšími dennými dávkami. V štúdii fázy 3 u pacientov s CKD bez dialýzy zvýšil hemoglobín, ferritín aj TSAT oproti placebu pri priaznivej znášanlivosti.</li>
</ul>

<h2>Voľba intravenózneho prípravku: nie je to len otázka ceny</h2>

<p>Praktický bod 2.4 hovorí, že výber i.v. prípravku riadi cena, preferencia pacienta, bezpečnosť, znášanlivosť a odporúčané dávkovacie schémy. ERBP to považuje za <strong>príliš všeobecné</strong> a trvá na tom, že do rozhodovania patria aj konkrétne klinické okolnosti.</p>

<div class="table-responsive" role="region" aria-label="Intravenózne prípravky železa a maximálne jednotlivé dávky" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Prípravok</th><th scope="col">Koncentrácia elementárneho železa</th><th scope="col">Maximálna jednotlivá dávka</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Nízkomolekulový dextrán železa</th><td>50 mg/ml</td><td>20 mg/kg</td></tr>
    <tr><th scope="row">Železo-sacharóza</th><td>20 mg/ml</td><td>200 mg (CKD), 400 mg (peritoneálna dialýza)</td></tr>
    <tr><th scope="row">Glukonát železitý</th><td>12,5 mg/ml</td><td>125 mg</td></tr>
    <tr><th scope="row">Ferric carboxymaltose</th><td>50 mg/ml</td><td>750 mg (FDA), 1000 mg (EMA)</td></tr>
    <tr><th scope="row">Ferric derisomaltose (železo-izomaltozid)</th><td>100 mg/ml</td><td>1000 mg (FDA), 20 mg/kg (EMA)</td></tr>
    <tr><th scope="row">Ferumoxytol</th><td>30 mg/ml</td><td>510 mg — <strong>v Európskej únii nie je na trhu</strong></td></tr>
  </tbody>
</table>
<p><em>Podľa tabuľky 4 odporúčaní KDIGO 2026. Minimálne časy podania sa medzi prípravkami aj medzi registráciami FDA a EMA líšia — riaďte sa platným súhrnom charakteristických vlastností lieku.</em></p>
</div>

<p>Najkonkrétnejšia európska výhrada sa týka <strong>hypofosfatémie po ferric carboxymaltose</strong>. ERBP uvádza, že u <strong>čerstvo transplantovaných pacientov sa FCM neodporúča</strong>: títo pacienti majú často pretrvávajúcu hyperparatyreózu a po podaní FCM sú pre nadbytok FGF-23 vo vysokom riziku ťažkej hypofosfatémie. V takej situácii je vhodnejší iný i.v. prípravok s nižším rizikom — alebo, ak sa FCM podá, treba fosfát sledovať tesne. Rovnaké upozornenie formulujú odporúčania aj pre pacientov v skorších štádiách CKD.</p>

<h2>Hypersenzitívne reakcie: čo musí byť pripravené vopred</h2>

<p>Praktický bod 2.9 zhŕňa štyri pravidlá, ktoré sa dajú zapamätať:</p>

<ol>
  <li>I.v. železo podávajte <strong>len tam, kde viete zvládnuť akútnu hypersenzitívnu a hypotenznú reakciu</strong>.</li>
  <li><strong>Neprekračujte maximálnu dávku na podanie</strong> pre daný prípravok.</li>
  <li>Premedikácia kortikoidmi ani antihistaminikami (blokátormi H1) <strong>nie je rutinne potrebná</strong>.</li>
  <li><strong>Testovacia dávka sa obvykle nevyžaduje</strong> — jej negativita riziko hypersenzitivity nepredpovedá.</li>
</ol>

<p>Odstupňovaný postup pri reakcii (praktický bod 2.10) vyzerá takto:</p>

<div class="table-responsive" role="region" aria-label="Postup pri reakcii na intravenózne železo" tabindex="0">
<table>
  <thead>
    <tr><th scope="col">Závažnosť</th><th scope="col">Obraz</th><th scope="col">Postup</th></tr>
  </thead>
  <tbody>
    <tr><th scope="row">Nešpecifické príznaky</th><td>Tlak na hrudi, závrat, nevoľnosť, svrbenie, asymptomatická hypotenzia</td><td>Zastaviť infúziu, sledovať 15 minút; ak je pacient v poriadku, pokračovať 25 – 50 % rýchlosťou. Pri opakovaní ukončiť.</td></tr>
    <tr><th scope="row">Mierna infúzna reakcia</th><td>Nešpecifické príznaky <strong>plus</strong> drobná urtikária</td><td>Zastaviť infúziu, sledovať; prípadný opakovaný pokus hodinu po podaní kortikoidu alebo perorálneho blokátora H1, pokračovať 25 – 50 % rýchlosťou. Pri opakovaní ukončiť.</td></tr>
    <tr><th scope="row">Stredne ťažká reakcia</th><td>Silná bolesť na hrudi, kašeľ, tachykardia, hypotenzia, ťažká generalizovaná urtikária</td><td>Zastaviť infúziu, podať i.v. tekutiny, hydrokortizón 100 mg i.v. a blokátor H1; pokračovať len pri úprave stavu 25 – 50 % rýchlosťou. Zvážiť iný prípravok železa podľa pomeru prínosu a rizika.</td></tr>
    <tr><th scope="row">Ťažká reakcia</th><td>Náhly vznik piskotov, stridoru, cyanózy, hypotenzie, tachykardie</td><td>Zastaviť infúziu, i.v. tekutiny, kyslík 15 l/min, <strong>adrenalín 0,5 mg 1 : 1000 intramuskulárne</strong>, kortikoid i.v., inhalačný beta-2-mimetikum nebulizátorom, <strong>hospitalizovať</strong>, i.v. železo do budúcna <strong>nepodávať</strong>.</td></tr>
  </tbody>
</table>
<p><em>Podľa obrázka 7 odporúčaní KDIGO 2026.</em></p>
</div>

<h2>Monitoring: ako často a kedy častejšie</h2>

<p>Praktický bod 2.5 stanovuje intervaly pre hemoglobín, ferritín a TSAT u pacientov liečených železom:</p>

<ul>
  <li><strong>CKD bez dialýzy a CKD G5PD: každé 3 mesiace.</strong></li>
  <li><strong>CKD G5HD: každý 1 až 3 mesiace.</strong> (Centrálna ilustrácia pre hemodialýzu uvádza mesačnú kontrolu — v praxi sa teda na dialýze pohybujeme skôr pri hornej frekvencii.)</li>
</ul>

<p>Praktický bod 2.6 vymenúva situácie, ktoré opodstatňujú častejšie testovanie: začatie alebo zvýšenie dávky ESA či HIF-PHI, epizóda známej straty krvi, nedávna hospitalizácia a významný vzostup ferritínu alebo TSAT, prípadne prekročenie cieľového limitu.</p>

<h2>Deficit železa bez anémie</h2>

<p>Praktický bod 2.11 je ľahko prehliadnuteľný, ale klinicky zaujímavý: pri <strong>hlbokom deficite železa (ferritín &lt; 30 ng/ml a TSAT &lt; 20 %) aj bez anémie</strong> treba zvážiť perorálnu alebo i.v. liečbu železom.</p>

<p>ERBP tento bod podporuje, hoci opatrne. Dve malé randomizované štúdie nepreukázali zlepšenie záťažovej kapacity pri i.v. železe u neanemických pacientov s CKD bez dialýzy. Novší systematický prehľad naznačuje zníženie rizika hospitalizácie pre srdcové zlyhávanie a kardiovaskulárneho úmrtia, konzistentne pri dialyzovaných aj nedialyzovaných — prínos však pochádza prevažne od pacientov s CKD zaradených do <em>kardiologických</em> štúdií, nie z nefrologických kohort, a efekty na pokles eGFR či proteinúriu sa nepotvrdili.</p>

<h2>Ako to zhrnúť do postupu pri lôžku</h2>

<ol>
  <li><strong>Potvrď anémiu</strong> (Hb &lt; 130 g/l u mužov, &lt; 120 g/l u žien) a odober krvný obraz, retikulocyty, ferritín a TSAT.</li>
  <li><strong>Pri ferritíne &lt; 45 ng/ml alebo mikrocytóze</strong> pátraj po zdroji krvácania — skôr, než začneš substituovať.</li>
  <li><strong>Urči skupinu:</strong> CKD G5HD verzus CKD bez dialýzy alebo G5PD.</li>
  <li><strong>Použi príslušný prah:</strong> hemodialýza ferritín ≤ 500 ng/ml a TSAT ≤ 30 %; mimo hemodialýzy ferritín &lt; 100 ng/ml s TSAT &lt; 40 %, alebo ferritín 100 – 299 ng/ml s TSAT &lt; 25 %.</li>
  <li><strong>Zvoľ cestu:</strong> na hemodialýze prednostne i.v. a proaktívne; mimo nej perorálne alebo i.v. podľa preferencií, závažnosti deficitu, znášanlivosti a dostupnosti.</li>
  <li><strong>Ak perorálne železo po 1 až 3 mesiacoch nezaberá alebo ho pacient neznáša,</strong> prepni na i.v.</li>
  <li><strong>Pri výbere i.v. prípravku zohľadni kontext</strong> — po transplantácii a v skorších štádiách CKD pozor na hypofosfatémiu po ferric carboxymaltose.</li>
  <li><strong>Zadrž rutinné železo</strong> pri ferritíne nad 700 ng/ml alebo TSAT 40 % a viac; <strong>preruš ho pri systémovej infekcii</strong>.</li>
  <li><strong>Nastav monitoring</strong> — 3 mesiace mimo hemodialýzy, 1 až 3 mesiace na hemodialýze, častejšie pri zmene ESA/HIF-PHI, krvácaní alebo hospitalizácii.</li>
  <li><strong>Ak sú parametre železa v poriadku a anémia trvá,</strong> rozšír diferenciálnu diagnostiku a až potom uvažuj o ESA; ESA zostávajú preferovanou prvou líniou pred HIF-PHI.</li>
</ol>

<h2>Čo kapitola o železe nerieši</h2>

<p>Komentár ERBP upozorňuje na témy, ktoré odporúčania obchádzajú a ktoré pritom v európskej praxi vznikajú denne: <strong>tehotenstvo</strong> (perorálne železo ako prvá línia, i.v. železo v prvom trimestri kontraindikované), <strong>rodové rozdiely</strong>, interakcie s <strong>inhibítormi SGLT2</strong> (znižujú hepcidín a ferritín, zvyšujú erytroferón a ukazovatele viazacej kapacity — teda zlepšujú dostupnosť železa) a systematický prístup k pacientom s <strong>chronickým zápalom</strong>. Pre poslednú skupinu sú na obzore protilátky proti interleukínu 6 (ziltivekimab, klazakizumab), ktoré v skorých štúdiách znižovali potrebu ESA a zvyšovali TSAT a väzbovú kapacitu — zatiaľ však bez dát o tvrdých klinických ukazovateľoch.</p>

<h2>Poznámka k dôkazom</h2>

<p>Tento článok je odborným zhrnutím druhej kapitoly publikovaných odporúčaní, ich európskeho komentára a dvoch primárnych randomizovaných štúdií; nejde o samostatný systematický prehľad. Uvedené číselné údaje pochádzajú z plného textu odporúčaní, z plného textu komentára ERBP a z abstraktov citovaných štúdií. Pripomíname, že všetky štyri odporúčania kapitoly majú stupeň 2D a jedenásť praktických bodov nie je odstupňovaných vôbec — konkrétny postup u konkrétneho pacienta vždy závisí od komorbidít, zápalového stavu, dostupnosti prípravkov a lokálnych protokolov.</p>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li>Kidney Disease: Improving Global Outcomes (KDIGO) Anemia Work Group. KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in Chronic Kidney Disease (CKD). <em>Kidney Int</em>. 2026;109(Suppl 1S):S1–S99. <a href="https://kdigo.org/guidelines/anemia-in-ckd/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</li>
  <li>Babitt JL, Berns JS, Bozkurt B, Cheung Khedairy RS, Cuevas Y, Effa EE, Eisenga MF, Fishbane S, Ginzburg YZ, Haase VH, Hedayati SS, Kim S, Moura-Neto JA, Nagler EV, Rossignol P, Sahay M, Tanaka T, Wang AYM, Wheeler DC, Robinson KA, Wilson LM, Wilson RF, Earley A, Akl EA, Tonelli M. Executive Summary of the KDIGO 2026 Clinical Practice Guideline for the Management of Anemia in Chronic Kidney Disease (CKD). <em>Kidney Int</em>. 2026;109:44–56. <a href="https://kdigo.org/guidelines/anemia-in-ckd/" target="_blank" rel="noopener noreferrer">Link na zdroj</a>.</li>
  <li>Del Vecchio L, Cases A, Eisenga MF, Małyszko J, Barratt J, Bolignano D. KDIGO 2026 Clinical Practice Guideline for Anemia in Chronic Kidney Disease (CKD): a commentary from the European Renal Best Practice (ERBP). <em>Nephrol Dial Transplant</em>. 2026;41(8):1554–1572. <a href="https://doi.org/10.1093/ndt/gfag014" target="_blank" rel="noopener noreferrer">DOI</a>. Oprava (týka sa regulačného statusu vadadustatu, nie kapitoly o železe): <em>Nephrol Dial Transplant</em>. 2026. <a href="https://doi.org/10.1093/ndt/gfag192" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Macdougall IC, White C, Anker SD, Bhandari S, Farrington K, Kalra PA, McMurray JJV, Murray H, Tomson CRV, Wheeler DC, Winearls CG, Ford I; PIVOTAL Investigators and Committees. Intravenous Iron in Patients Undergoing Maintenance Hemodialysis. <em>N Engl J Med</em>. 2019;380(5):447–458. <a href="https://doi.org/10.1056/NEJMoa1810742" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li>Macdougall IC, Bock AH, Carrera F, Eckardt KU, Gaillard C, Van Wyck D, Roubert B, Nolen JG, Roger SD; FIND-CKD Study Investigators. FIND-CKD: a randomized trial of intravenous ferric carboxymaltose versus oral iron in patients with chronic kidney disease and iron deficiency anaemia. <em>Nephrol Dial Transplant</em>. 2014;29(11):2075–2084. <a href="https://doi.org/10.1093/ndt/gfu201" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em>Bibliografické údaje boli overené cez PubMed a plné texty odporúčaní; abstrakty citovaných prác sú dostupné na <a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></p>

<p><em><strong>Poznámka:</strong> Tento článok má vzdelávací charakter a nenahrádza individuálne klinické rozhodovanie ošetrujúceho tímu, platné súhrny charakteristických vlastností liekov ani aktuálne stanoviská regulačných orgánov.</em></p>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_zelezo_anemia_ckd_kdigo_2026_erbp',
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
