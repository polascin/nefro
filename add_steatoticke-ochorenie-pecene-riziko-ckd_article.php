<?php

/**
 * add_steatoticke-ochorenie-pecene-riziko-ckd_article.php
 * Odborne revidovane spracovanie prehladu Marshall et al. o zacleneni pecene
 * do hodnotenia kardiovaskularno-oblickovo-metabolickeho rizika.
 *
 * Povodni autori spracovaneho zdroja su uvedeni v source_authors.php.
 */

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
    'title'        => 'Steatotické ochorenie pečene: prečo patrí do hodnotenia rizika pacienta s chronickým ochorením obličiek',
    'slug'         => 'steatoticke-ochorenie-pecene-riziko-ckd',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'MASLD nie je iba náhodný ultrazvukový nález. Ako hodnotiť pečeňovú fibrózu pri CKD, čo znamená návrh CRHM a kde sa končí dôkaz a začína hypotéza?',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Steatotické ochorenie pečene spojené s metabolickou dysfunkciou môže dlho prebiehať bez príznakov. Nie je však iba náhodným ultrazvukovým nálezom. Súvisí s kardiovaskulárnym a obličkovým rizikom, najmä v prítomnosti ďalších metabolických porúch a pokročilej pečeňovej fibrózy. Pre nefrológa z toho vyplýva potreba cielene hodnotiť aj pečeň — nie automaticky predpisovať ďalší liek každému pacientovi so steatózou.</em></p>

<p>Nový prehľad Williama R. Marshalla, Smeety Sinha, Darrena Greena a Philipa A. Kalru v časopise <em>Current Opinion in Nephrology and Hypertension</em> navrhuje začleniť pečeň do kardiovaskulárno-obličkovo-metabolického rámca. Autori používajú pracovný názov <strong>kardiovaskulárny, renálny, hepatálny a metabolický syndróm (CRHM)</strong>. Myšlienka je klinicky podnetná, ale vyžaduje presné čítanie: ide o recenzovaný naratívny prehľad a koncepčný návrh, nie o novú randomizovanú štúdiu, metaanalýzu ani všeobecne prijatú diagnostickú klasifikáciu.</p>

<h2>Čo prehľad priniesol — a čo nie</h2>

<p>Prehľad syntetizuje epidemiologické, mechanistické a terapeutické poznatky o prepojení pečene, srdca, obličiek a metabolickej dysfunkcie. V bibliografii má 55 zdrojov. Správy, že „štúdie zahŕňali milióny pacientov“, označujú súčet podkladových prác; nejde o veľkosť jedného nového súboru.</p>

<div class="table-responsive" role="region" aria-label="Dôkazová sila hlavných tvrdení prehľadu o MASLD a CKD" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Tvrdenie</th>
        <th scope="col">Čo ho podporuje</th>
        <th scope="col">Hlavné obmedzenie</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">MASLD a CKD sa často vyskytujú spolu</th>
        <td>Veľké populačné kohorty a konzistentný spoločný metabolický profil</td>
        <td>Súbeh sám osebe neurčuje smer príčinnej súvislosti</td>
      </tr>
      <tr>
        <th scope="row">Súbeh označuje pacienta s vysokým rizikom</th>
        <td>Pozorovacie analýzy mortality a kardiovaskulárnej morbidity</td>
        <td>Reziduálne skreslenie a rozdielne definície MASLD aj CKD</td>
      </tr>
      <tr>
        <th scope="row">Pečeňová fibróza spresňuje prognózu</th>
        <td>Histologické kohorty a neinvazívne prognostické štúdie</td>
        <td>FIB-4 ani elastografia nie sú totožné s histologickým štádiom</td>
      </tr>
      <tr>
        <th scope="row">Jedna lieková kombinácia chráni všetky orgány</th>
        <td>Výsledky viacerých samostatných skúšaní a biologická plausibilita</td>
        <td>Chýba štúdia celého navrhovaného režimu v jednej CRHM populácii</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Najprimeranejším klinickým záverom preto nie je „MASLD spôsobuje CKD“, ale: <strong>nález MASLD, najmä s podozrením na pokročilú fibrózu, má podnietiť úplnejšie hodnotenie rizika pacienta</strong>. Zároveň prítomnosť CKD nemá viesť k automatickému označeniu každého pečeňového nálezu za MASLD.</p>

<h2>MASLD, MASH a fibróza nie sú zameniteľné</h2>

<p><strong>MASLD</strong> (<em>metabolic dysfunction-associated steatotic liver disease</em>) označuje steatotické ochorenie pečene spojené s metabolickou dysfunkciou. Diagnostické zaradenie vyžaduje steatózu a najmenej jeden kardiometabolický rizikový faktor. Súčasťou vyšetrenia zostáva kvantifikácia alkoholu, kontrola liekov a hľadanie iných alebo súbežných príčin poškodenia pečene.</p>

<p><strong>MASH</strong> je steatohepatitída spojená s metabolickou dysfunkciou: okrem steatózy zahŕňa zápal a balónové poškodenie hepatocytov. Samotná ultrasonografická steatóza ani zvýšená ALT ju nepotvrdzujú. Normálna aktivita aminotransferáz ju naopak nevylučuje.</p>

<p><strong>Fibróza</strong> označuje zmnoženie väziva. Jej stupeň patrí medzi najsilnejšie ukazovatele pečeňových komplikácií a mortality spojenej s ochorením pečene. To však neznamená, že nahrádza eGFR, albuminúriu, diabetes, krvný tlak, srdcové zlyhávanie, aterosklerotické ochorenie, fajčenie alebo vek pri hodnotení celkového rizika.</p>

<h2>Najdôležitejšia kohorta: užitočný signál, nie dôkaz kauzality</h2>

<p>Kľúčovým podkladom pre tvrdenie o nepriaznivom súbehu MASLD a CKD bola analýza NHANES 2007 až 2018. Zahŕňala 14 818 dospelých s priemerným sledovaním 6,9 roka; 1 142 z nich malo klasifikované obe ochorenia. Súbeh MASLD a CKD bol po štatistickej úprave spojený s vyššou celkovou mortalitou a pacienti so súbežnou pokročilou pečeňovou fibrózou a CKD mali najhoršiu prognózu.</p>

<p>Interpretáciu obmedzuje dizajn štúdie. MASLD sa určovala prevažne pomocou indexu stukovatenia pečene, nie zobrazovaním alebo biopsiou; fibróza pomocou FIB-4. Klasifikácia CKD vychádzala z prierezových údajov prieskumu o eGFR, albuminúrii a dialýze, pričom pri jednorazových laboratórnych údajoch nemožno u každého človeka overiť trojmesačnú chronicitu. Skupiny sa výrazne líšili vekom, diabetom, obezitou, hypertenziou, príjmom aj liečbou.</p>

<p>Modelová úprava znižuje časť skreslenia, ale nevytvára randomizáciu. Štúdia porovnávala štyri fenotypy a ukázala stupňovanie rizika; nepreukázala, že liečba steatózy sama zníži obličkové príhody. Výrazy „synergický“ alebo „viac než aditívny“ treba používať iba vtedy, ak bola príslušná štatistická interakcia formálne hodnotená na vopred určenej škále.</p>

<h2>Prečo môže byť pečeň súčasťou systémového rizika</h2>

<h3>Spoločný metabolický podklad</h3>

<p>Obezita, diabetes 2. typu, artériová hypertenzia, dyslipidémia, inzulínová rezistencia a fyzická inaktivita môžu súčasne poškodzovať pečeň, obličky aj cievy. Časť epidemiologického vzťahu preto nevychádza z jednosmerného pôsobenia pečene na obličku, ale zo spoločných determinantov.</p>

<h3>Lipotoxicita, hepatokíny a zápal</h3>

<p>Niektoré lipidové medziprodukty, najmä ceramidy a diacylglyceroly, sa v experimentálnych modeloch podieľajú na poruche inzulínovej signalizácie, mitochondriálnej dysfunkcii a bunkovom strese. Steatotická a zapálená pečeň mení aj tvorbu hepatokínov a ďalších signálnych molekúl. Tieto mechanizmy poskytujú biologicky vierohodné vysvetlenie medziorgánového prepojenia, ich individuálny príspevok však v bežnej ambulancii nevieme zmerať.</p>

<h3>Črevná mikrobiota a uremické toxíny</h3>

<p>Zmenená črevná bariéra, mikrobiálne metabolity a imunitná aktivácia môžu ovplyvňovať pečeň, cievy aj obličky. Pri CKD sa zároveň znižuje eliminácia niektorých látok. Zvýšená koncentrácia trimetylamín-N-oxidu alebo iného metabolitu však môže odrážať vyššiu tvorbu, nižšie vylučovanie alebo oboje; samotná asociácia biomarkera nie je dôkazom, že práve on spôsobil poškodenie.</p>

<h3>Hemodynamika a kongescia</h3>

<p>Aktivácia systému renín-angiotenzín-aldosterón, retencia sodíka a objemové preťaženie prepájajú srdcovú, obličkovú a pečeňovú dysfunkciu. Venózna kongescia však môže vyvolať kongestívnu hepatopatiu a zvýšiť tuhosť pečene bez toho, aby išlo iba o metabolickú fibrózu. MASLD a kongestívna hepatopatia môžu koexistovať a vyžadujú odlišnú interpretáciu.</p>

<h2>Koho cielene vyšetrovať</h2>

<p>Európske odporúčania EASL–EASD–EASO podporujú vyhľadávanie MASLD s fibrózou najmä u ľudí s diabetom 2. typu, abdominálnou obezitou a aspoň jedným ďalším metabolickým rizikovým faktorom alebo s pretrvávajúcimi abnormalitami pečeňových testov. Nejde o plošný populačný skríning.</p>

<p>Americké odporúčanie AHA/ACC/ADA/ASN z roku 2026 už pečeň výslovne začleňuje do manažmentu CKM. U dospelých s CKM, diabetom alebo najmenej dvoma kardiometabolickými rizikovými faktormi odporúča výpočet FIB-4 každé 1 až 2 roky. Pri CKM štádiu 1 z dôvodu prediabetu považuje interval 2 až 3 roky za primeraný.</p>

<p>Marshall a spoluautori navrhujú ešte širší praktický prístup: FIB-4 u každého pacienta s CKD a aspoň jedným kardiometabolickým rizikovým faktorom. Tento návrh je rozumným podnetom pre nefrologickú diskusiu, ale nie je totožný so znením európskeho ani amerického odporúčania.</p>

<h2>FIB-4 je triáž, nie diagnóza</h2>

<p>FIB-4 sa vypočíta z veku, AST, ALT a počtu trombocytov:</p>

<p class="pdf-avoid-break"><strong>FIB-4 = vek &times; AST / (počet trombocytov &times; &radic;ALT)</strong></p>

<p>V bežnom viacstupňovom algoritme sa používajú tieto orientačné hranice:</p>

<ul>
  <li><strong>pod 1,3:</strong> nižšia pravdepodobnosť pokročilej fibrózy, nie jej absolútne vylúčenie,</li>
  <li><strong>1,3 až 2,67:</strong> nejednoznačný výsledok; podľa rizika nasleduje elastografia alebo test ELF,</li>
  <li><strong>nad 2,67:</strong> vysoké riziko a dôvod na hepatologické posúdenie.</li>
</ul>

<p>U ľudí starších ako 65 rokov sa na vstupnú triáž používa vyššia spodná hranica 2,0. U osôb mladších ako 35 rokov je FIB-4 menej presné a nemá sa interpretovať počas akútneho ochorenia. Aj hodnota pod 1,3 môže podľa EASL prehliadnuť približne desatinu pacientov s pokročilou fibrózou.</p>

<p>Pri CKD treba zohľadniť nepečeňové príčiny trombocytopénie alebo zvýšenej AST. U hemodialyzovaných pacientov bývajú aminotransferázy často nižšie a štandardné prahy nie sú dostatočne validované ako samostatná diagnostika. FIB-4 je preto signál pre ďalší krok, nie potvrdenie MASH alebo fibrózy F2–F3.</p>

<h2>Elastografia pri CKD: na objemovom stave záleží</h2>

<p>Elastografia meria tuhosť pečene, nie priamo množstvo histologického väziva. Výsledok môžu meniť zápal, cholestáza, jedlo, technické podmienky a venózna kongescia. Hodnota pod 8 kPa podporuje nízke riziko pokročilej fibrózy; hodnota 8 kPa alebo vyššia si vyžaduje klinickú interpretáciu a sama neurčuje MASH ani konkrétne histologické štádium.</p>

<p>Prospektívna pilotná štúdia z roku 2026 vykonala elastografiu bezprostredne pred a po hemodialýze u 41 pacientov s párovými meraniami. Medián sa významne nezmenil, ale približne 10 % pacientov po dialýze prekročilo hranicu 8 kPa, ktorú pred dialýzou neprekračovali. FIB-4 a APRI mali slabú zhodu so zvýšenou tuhosťou. Štúdia nemala histologický referenčný štandard a jej 45 zaradených pacientov nestačí na vytvorenie dialyzačných prahov; dobre však ukazuje, prečo treba čas merania a objemový stav štandardizovať.</p>

<h2>Liečba: orgánový prienik nie je univerzálny recept</h2>

<p>Prehľad správne upozorňuje, že niektoré lieky prinášajú prospech vo viacerých orgánových oblastiach. Neprimerané by však bolo premeniť túto myšlienku na povinnú kombináciu pre každého pacienta so steatózou a CKD.</p>

<div class="table-responsive" role="region" aria-label="Interpretácia liečby pri súbehu MASLD a chronickej choroby obličiek" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Liečba</th>
        <th scope="col">Čo je preukázané</th>
        <th scope="col">Čo z toho nevyplýva</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">ACE inhibítor alebo sartán, inhibítor SGLT2</th>
        <td>Kardiorenálna ochrana v príslušných CKD, diabetických a srdcových indikáciách</td>
        <td>Samotná MASLD nevytvára automaticky indikáciu a biomarkerové zlepšenie nie je liečbou MASH</td>
      </tr>
      <tr>
        <th scope="row">Finerenón</th>
        <td>Kardiorenálny prínos pri CKD spojenej s diabetom 2. typu a príslušnej albuminúrii</td>
        <td>Analýza FIDELITY ukázala neutrálne pečeňové parametre, nie liečbu fibrózy pečene</td>
      </tr>
      <tr>
        <th scope="row">Semaglutid</th>
        <td>Rozdielne prínosy v samostatných štúdiách obezity, diabetu, CKD, kardiovaskulárneho rizika a MASH</td>
        <td>FLOW, SELECT, SMART a ESSENCE nepredstavujú jednu spoločnú CRHM populáciu ani rovnaký výsledok</td>
      </tr>
      <tr>
        <th scope="row">Cielená liečba MASH</th>
        <td>Rezdiffra a Kayshild majú v EÚ podmienečné povolenie pre necirhotickú MASH s fibrózou F2–F3</td>
        <td>Steatóza, zvýšená ALT alebo FIB-4 nad 1,3 samy osebe nie sú dostatočnou indikáciou</td>
      </tr>
    </tbody>
  </table>
</div>

<h3>Semaglutid: rôzne dávky, populácie a cieľové ukazovatele</h3>

<p>ESSENCE ukázala po 72 týždňoch ústup steatohepatitídy bez zhoršenia fibrózy u 62,9 % pacientov so semaglutidom 2,4 mg a u 34,3 % s placebom. FLOW preukázala kardiorenálny prínos semaglutidu 1 mg pri diabete 2. typu a CKD. SELECT hodnotila ľudí s obezitou a preukázaným kardiovaskulárnym ochorením bez diabetu; obličkový výsledok bol sekundárny. SMART trvala 24 týždňov a jej primárnym výsledkom bola zmena albuminúrie pri CKD bez diabetu.</p>

<p>Súhrn týchto štúdií podporuje široký klinický potenciál semaglutidu, nie však tvrdenie, že rovnaký liek v rovnakej dávke súčasne znížil tvrdé pečeňové, obličkové a kardiovaskulárne príhody u jednej populácie so súbehom všetkých ochorení.</p>

<h3>Finerenón: zachovaný kardiorenálny prínos, nie antifibrotická liečba pečene</h3>

<p>Post hoc analýza FIDELITY zahŕňala 13 026 pacientov s diabetom 2. typu a CKD. Kardiorenálny prínos finerenónu sa zachoval aj v podskupinách s abnormálnymi pečeňovými markermi a vyšší FIB-4 označoval vyššie kardiovaskulárne riziko. ALT, AST a GMT však zostali medzi liečebnými skupinami porovnateľné. Analýza teda podporuje bezpečnosť a prognostickú hodnotu pečeňových markerov v tejto populácii, nie tvrdenie, že finerenón lieči MASH alebo pečeňovú fibrózu.</p>

<h3>Resmetirom: európska informácia sa líši od amerických prahov</h3>

<p>V praktickom algoritme prehľadu sa resmetirom spája s hranicou eGFR najmenej 45 ml/min/1,73 m<sup>2</sup>, ktorá vychádza z amerického kontextu. Aktuálny európsky súhrn charakteristických vlastností Rezdiffry uvádza, že pri eGFR 15 až 89 ml/min sa úprava dávky neodporúča. To neznamená automatickú vhodnosť pri každej CKD: liek je určený pre necirhotickú MASH s fibrózou F2–F3 a treba preveriť interakcie, hepatálny stav, dostupnosť a úhradu. Americkú hranicu nemožno bez vysvetlenia vydávať za európsku kontraindikáciu.</p>

<h2>CRHM je užitočný koncept, zatiaľ nie jednotná diagnóza</h2>

<p>CRHM pomenúva klinickú realitu multimorbidity a upozorňuje na fragmentovanú starostlivosť. K septembru 2026 však nemá jednotné konsenzuálne diagnostické kritériá ani všeobecne prijaté štádiá. Nové americké odporúčanie z roku 2026 naďalej používa názov <strong>CKM</strong>, hoci už obsahuje samostatné odporúčania pre hodnotenie MASLD.</p>

<p>Praktická hodnota konceptu nespočíva v ďalšej nálepke do dokumentácie. Spočíva v koordinácii: pacient nemá dostať navzájom rozporné dietetické odporúčania, neprimerané liekové kombinácie alebo opakované vyšetrenia bez jasnej otázky. Nový názov nenahrádza presné diagnózy CKD, albuminúrie, diabetu, srdcového zlyhávania, MASLD, MASH alebo cirhózy.</p>

<h2>Praktický postup v nefrologickej ambulancii</h2>

<ol>
  <li><strong>Identifikovať rizikový kontext.</strong> Diabetes 2. typu, abdominálna obezita, ďalšie metabolické faktory, nevysvetlené pečeňové testy alebo náhodne zistená steatóza.</li>
  <li><strong>Overiť etiológiu.</strong> Kvantifikovať alkohol, skontrolovať lieky, vírusové hepatitídy podľa rizika a odlíšiť kongestívnu či inú chorobu pečene.</li>
  <li><strong>Posúdiť fibrózu.</strong> Použiť FIB-4 ako vstupnú triáž s ohľadom na vek, akútne ochorenie, trombocyty a špecifiká pokročilej CKD.</li>
  <li><strong>Doplniť druhý test.</strong> Pri nejednoznačnom alebo vysokom riziku vykonať štandardizovanú elastografiu alebo ELF a podľa výsledku konzultovať hepatológa.</li>
  <li><strong>Optimalizovať preukázanú liečbu.</strong> Riadiť RAS blokádu, inhibítor SGLT2, finerenón, inkretínovú alebo inú liečbu podľa konkrétnej indikácie, eGFR, albuminúrie, glykémie a tolerancie.</li>
  <li><strong>Chrániť výživu a objemový stav.</strong> Pri chudnutí sledovať svalovú silu a príjem živín; pri gastrointestinálnej intolerancii predchádzať hypovolémii a akútnemu poškodeniu obličiek.</li>
  <li><strong>Koordinovať starostlivosť.</strong> Pri pokročilej fibróze, nejasnej etiológii, rozporných testoch alebo zvažovaní cielenej liečby MASH zapojiť hepatológa.</li>
</ol>

<h2>Čo možno a nemožno tvrdiť</h2>

<h3>Dostatočne podložené</h3>

<ul>
  <li>MASLD a CKD sa často združujú s rovnakými metabolickými rizikovými faktormi.</li>
  <li>Súbeh oboch diagnóz a podozrenie na pokročilú fibrózu označujú populáciu s vysokým rizikom.</li>
  <li>FIB-4 a následná elastografia alebo ELF umožňujú praktickú viacstupňovú stratifikáciu.</li>
  <li>Nové odporúčanie CKM z roku 2026 už zahŕňa periodické hodnotenie FIB-4 vo vymedzených rizikových skupinách.</li>
  <li>Jednotlivé liekové triedy môžu mať preukázaný prínos vo viacerých orgánových oblastiach.</li>
</ul>

<h3>Neprimerane silné alebo nepreukázané</h3>

<ul>
  <li>Observačná asociácia dokazuje, že MASLD priamo spôsobila CKD alebo mortalitu.</li>
  <li>Každý pacient s CKD potrebuje rovnaký pečeňový skríning bez ohľadu na vek a metabolické riziko.</li>
  <li>FIB-4 nad 1,3 alebo elastografia nad 8 kPa samy potvrdzujú MASH s fibrózou F2–F3.</li>
  <li>Finerenón alebo inhibítor SGLT2 sú cielenou liečbou MASH.</li>
  <li>Výsledky viacerých štúdií semaglutidu dokazujú pan-orgánový klinický prínos v jednej CRHM populácii.</li>
  <li>Navrhovaný viacliekový režim bol ako celok otestovaný v randomizovanom skúšaní.</li>
</ul>

<h2>Záver</h2>

<p>Pečeň patrí do hodnotenia rizika pacienta s CKD vtedy, keď klinický kontext naznačuje MASLD alebo pokročilú fibrózu. Najväčšiu výpovednú hodnotu nemá samotná steatóza, ale správne interpretovaná viacstupňová stratifikácia fibrózy spolu s tradičnými obličkovými a kardiovaskulárnymi ukazovateľmi.</p>

<p>Koncept CRHM pomáha myslieť naprieč odbormi, zatiaľ však nie je samostatnou konsenzuálnou diagnózou. Pre nefrológa je dôležitejšie konať presne: rozpoznať rizikového pacienta, nepreceňovať neinvazívne testy, liečiť jednotlivé diagnózy podľa ich dôkazov a indikácií a pri zložitom súbehu koordinovať starostlivosť s hepatológom, diabetológom a kardiológom.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=masld-diagnostika-fibroza-nefrologicka-prax">MASLD: diagnostika, hodnotenie fibrózy a význam pre nefrologickú prax</a></li>
  <li><a href="article.php?slug=inkretinove-agonisty-masld-mash-pecen-ckd">Inkretínové agonisty pri MASLD a MASH: ochrana pečene a význam pre nefrológa</a></li>
  <li><a href="article.php?slug=oblicka-v-centre-ckm-syndromu-kdigo">Oblička v centre kardiovaskulárno-obličkovo-metabolického syndrómu</a></li>
  <li><a href="article.php?slug=tukove-tkanivo-obezita-kardiorenalne-riziko-biologia">Tukové tkanivo, obezita a kardiorenálne riziko</a></li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>William R. Marshall, Smeeta Sinha, Darren Green, Philip A. Kalra.</strong> <em>Integrating the liver into the cardiovascular-kidney-metabolic syndrome: pathophysiology and therapeutic implications.</em> Current Opinion in Nephrology and Hypertension. Publikované online 2. septembra 2026. doi: 10.1097/MNH.0000000000001225. <a href="https://pubmed.ncbi.nlm.nih.gov/42683763/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://www.ovid.com/jnls/co-nephrolhypertens/fulltext/10.1097/mnh.0000000000001225~integrating-the-liver-into-the" target="_blank" rel="noopener noreferrer">Plný text vydavateľa</a>.</li>
  <li><strong>European Association for the Study of the Liver, European Association for the Study of Diabetes, European Association for the Study of Obesity.</strong> <em>EASL–EASD–EASO Clinical Practice Guidelines on the management of metabolic dysfunction-associated steatotic liver disease.</em> Journal of Hepatology. 2024;81(3):492–542. doi: 10.1016/j.jhep.2024.04.031. <a href="https://pubmed.ncbi.nlm.nih.gov/38851997/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11299976/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Chiadi E. Ndumele, Fatima Rodriguez, Dave L. Dixon a spol.; AHA/ACC Joint Committee on Clinical Practice Guidelines.</strong> <em>2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome.</em> Circulation. 2026;154(4):e50–e158. doi: 10.1161/CIR.0000000000001453. <a href="https://pubmed.ncbi.nlm.nih.gov/42263157/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://professional.heart.org/en/guidelines-statements/2026-ahaaccadaasn-guideline-for-the-prevention-detection-evaluation-andcir0000000000001453" target="_blank" rel="noopener noreferrer">AHA guideline hub</a>.</li>
  <li><strong>Rachel Sze Jen Goh, Jun Xian Koh, Mohamed A. U. Intaran a spol.</strong> <em>Population-Based Study on the Coexistence of Metabolic Dysfunction-Associated Steatotic Liver Disease and Chronic Kidney Disease.</em> Journal of the American Heart Association. 2025;14:e041834. doi: 10.1161/JAHA.125.041834. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC12684605/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
  <li><strong>Nikolaos Perakakis, Stefan R. Bornstein, Andreas L. Birkenfeld a spol.; FIDELIO-DKD and FIGARO-DKD investigators.</strong> <em>Efficacy of finerenone in patients with type 2 diabetes, chronic kidney disease and altered markers of liver steatosis and fibrosis: a FIDELITY subgroup analysis.</em> Diabetes, Obesity and Metabolism. 2024;26(1):191–200. doi: 10.1111/dom.15305. <a href="https://pubmed.ncbi.nlm.nih.gov/37814928/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Vlado Perkovic, Katherine R. Tuttle, Peter Rossing a spol.; FLOW Trial Committees and Investigators.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> New England Journal of Medicine. 2024;391(2):109–121. doi: 10.1056/NEJMoa2403347. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Arun J. Sanyal, Philip N. Newsome, Iris Kliers a spol.; ESSENCE Study Group.</strong> <em>Phase 3 Trial of Semaglutide in Metabolic Dysfunction-Associated Steatohepatitis.</em> New England Journal of Medicine. 2025;392(21):2089–2099. doi: 10.1056/NEJMoa2413258. <a href="https://pubmed.ncbi.nlm.nih.gov/40305708/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Rezdiffra (resmetirom): EPAR a informácie o lieku.</em> <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/rezdiffra" target="_blank" rel="noopener noreferrer">EPAR</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/rezdiffra-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Súhrn charakteristických vlastností lieku</a>.</li>
  <li><strong>European Medicines Agency.</strong> <em>Kayshild (semaglutid): EPAR a informácie o lieku.</em> <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/kayshild" target="_blank" rel="noopener noreferrer">EPAR</a>. <a href="https://www.ema.europa.eu/en/documents/product-information/kayshild-epar-product-information_en.pdf" target="_blank" rel="noopener noreferrer">Súhrn charakteristických vlastností lieku</a>.</li>
  <li><strong>Karem Awad, Fadi Abu Baker, Mahmoud Foqara a spol.</strong> <em>Liver Stiffness Variability and Limited Performance of Non-Invasive Fibrosis Scores in Hemodialysis: A Prospective Study.</em> Diagnostics. 2026;16(13):2080. doi: 10.3390/diagnostics16132080. <a href="https://pubmed.ncbi.nlm.nih.gov/42449861/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13360910/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>
</ol>

<p><em><strong>Poznámka k vecnej kontrole:</strong> Hlavný prehľad, jeho bibliografia a primárna kohorta MASLD–CKD boli skontrolované podľa verejne dostupných plných textov. Skríningové a diagnostické tvrdenia boli porovnané s odporúčaniami EASL–EASD–EASO 2024 a AHA/ACC/ADA/ASN 2026. Údaje o liekoch boli oddelené podľa populácie, dávky, ukazovateľa a európskej indikácie; informácia o resmetirome bola opravená podľa aktuálneho dokumentu EMA. Osobitne boli označené limity FIB-4 a elastografie pri hemodialýze a rozdiel medzi observačnou asociáciou, mechanistickou hypotézou a klinickým účinkom.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_steatoticke_ochorenie_pecene_riziko_ckd',
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
