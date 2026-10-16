<?php

/**
 * add_hyperkaliemia-raasi-mra-viazace-draslika-sodik_article.php
 * Sodikova zataz viazacov draslika pri snahe udrzat RAASi a MRA.
 * Spracovanie editorialu Pitt B, Butler J, Weir MR,
 * JACC Heart Fail 2026;14(8):103114, doi 10.1016/j.jchf.2026.103114.
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
    'title'        => 'Sodíková záťaž viazačov draslíka: nezamýšľaný dôsledok snahy udržať RAASi a MRA',
    'slug'         => 'hyperkaliemia-raasi-mra-viazace-draslika-sodik',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Editoriál v JACC: Heart Failure odporúča pri chronickej hyperkaliémii uprednostniť patiromér alebo nízku dávku cyklosilikátu zirkoničito-sodného. Dôvod znie presvedčivo, dôkazy sú však slabšie a konfliktnejšie, než sa na prvý pohľad zdá.',
    'content'      => <<<'HTML'
<figure><a href="img/hyperkaliemia-raasi-mra-viazace-draslika-sodik.webp" rel="noopener noreferrer" target="_blank"><img src="img/hyperkaliemia-raasi-mra-viazace-draslika-sodik.webp" alt="Polopriesvitné srdce a oblička spojené cievou v tmavej scéne; nahor sa odvíja riedky prúd fialových častíc, zatiaľ čo pri základe sa rovnaké častice hromadia do hústnucej náplavy" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná, poloschematická scéna – nejde o zobrazenie konkrétneho pacienta ani o grafické znázornenie nameraných hodnôt. Znázorňuje výmenu, ktorá je podstatou problému: draslík odchádza, sodík sa hromadí.</figcaption></figure>

<p class="article-dek"><em>Vysadenie inhibítora RAS alebo antagonistu mineralokortikoidových receptorov pre hyperkaliémiu nie je bezpečným riešením – má vlastnú cenu. Editoriál troch významných autorov v JACC: Heart Failure upozorňuje, že ani riešenie pomocou viazača draslíka nie je neutrálne: cyklosilikát zirkoničito-sodný vymieňa draslík za sodík, a to práve u pacientov, ktorí sodík zvládajú najhoršie. Argument je mechanisticky elegantný. Dôkazová základňa pod ním je však tenšia a zaťaženejšia konfliktmi záujmov, než editoriál pripúšťa.</em></p>

<p>Zdrojom tohto článku je editoriál <em>Enabling a Renin-Angiotensin System Inhibitor and/or a Mineralocorticoid Receptor Antagonist in Patients With Heart Failure and/or Chronic Kidney Disease: Unintended Consequences of Increased Sodium Exposure</em>, ktorý v roku 2026 publikovali <strong>Bertram Pitt, Javed Butler a Matthew R. Weir</strong> v časopise JACC: Heart Failure.</p>

<p>Ide o odborný komentár, <strong>nie o systematický prehľad ani o pôvodnú štúdiu</strong>. Tomu zodpovedá spôsob, akým s dôkazmi narába: vyberá ich, zoraďuje do úvahy a formuluje odporúčanie. Práve preto má zmysel prejsť si podkladové práce samostatne.</p>

<h2>Prečo vysadenie RAASi alebo MRA nie je bezpečná možnosť</h2>

<p>Inhibítory systému renín–angiotenzín–aldosterón (RAASi) a antagonisty mineralokortikoidových receptorov (MRA) znižujú kardiovaskulárnu úmrtnosť, hospitalizácie pre srdcové zlyhávanie aj progresiu chronickej choroby obličiek. V praxi sa však pri hyperkaliémii alebo vzostupe kreatinínu často znižuje dávka alebo sa liečba ukončí.</p>

<p>Editoriál pripomína mechanizmus, ktorý sa pri tomto rozhodovaní prehliada: po nasadení MRA dochádza k <strong>reaktívnemu vzostupu plazmatického aldosterónu</strong>. Náhle vysadenie MRA môže preto pacienta vystaviť pôsobeniu zvýšeného aldosterónu bez blokády receptora, a tým teoreticky zvýšiť pravdepodobnosť zhoršenia srdcového zlyhávania a kardiovaskulárneho úmrtia. Vysadenie teda nie je návratom do východiskového stavu.</p>

<p>Rovnako dôležité je, že pokles glomerulovej filtrácie po nasadení RAASi alebo MRA býva reverzibilný a spája sa s lepšími dlhodobými obličkovými aj kardiovaskulárnymi výsledkami. Pôvodným zdrojom tohto poznatku je metaanalýza dvanástich randomizovaných štúdií, ktorú publikovali Bakris a Weir v roku 2000. Zistili, že akútny vzostup kreatinínu <strong>do 30 %</strong>, ktorý sa stabilizuje v priebehu prvých dvoch mesiacov, sa spája s dlhodobým zachovaním funkcie obličiek, a to aj u pacientov s východiskovým kreatinínom nad 124 µmol/l. Ich záver bol, že inhibítor ACE sa má vysadiť len vtedy, keď vzostup kreatinínu presiahne 30 % nad východiskovú hodnotu, alebo keď sa rozvinie hyperkaliémia, teda pri draslíku <strong>≥ 5,6 mmol/l</strong>.</p>

<h2>Čo k tomu hovorí KDIGO 2024</h2>

<p>Odporúčanie KDIGO pre chronickú chorobu obličiek z roku 2024 formuluje rovnakú zásadu výslovne a je vhodné ju citovať presne, pretože sa často parafrázuje voľnejšie, než znie.</p>

<div class="table-responsive" role="region" aria-label="Praktické body KDIGO 2024 týkajúce sa hyperkaliémie a pokračovania liečby inhibítormi RAS" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Praktický bod</th>
        <th scope="col">Obsah</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">3.6.2</th>
        <td>Krvný tlak, sérový kreatinín a sérový draslík skontrolovať do 2 – 4 týždňov od nasadenia alebo zvýšenia dávky RASi, podľa aktuálnej glomerulovej filtrácie a draslíka.</td>
      </tr>
      <tr>
        <th scope="row">3.6.3</th>
        <td>Hyperkaliémiu spojenú s užívaním RASi možno často zvládnuť opatreniami na zníženie sérového draslíka <strong>namiesto zníženia dávky alebo ukončenia RASi</strong>.</td>
      </tr>
      <tr>
        <th scope="row">3.6.4</th>
        <td>Pokračovať v liečbe inhibítorom ACE alebo ARB, pokiaľ sérový kreatinín nestúpne o viac než 30 % do 4 týždňov od nasadenia alebo zvýšenia dávky.</td>
      </tr>
      <tr>
        <th scope="row">3.6.5</th>
        <td>Zvážiť zníženie dávky alebo ukončenie inhibítora ACE či ARB pri symptomatickej hypotenzii alebo <strong>nekontrolovanej hyperkaliémii napriek liečbe</strong>, prípadne na zmiernenie uremických príznakov pri zlyhaní obličiek.</td>
      </tr>
      <tr>
        <th scope="row">3.8.3</th>
        <td>Na zmiernenie rizika hyperkaliémie vyberať na nesteroidný MRA osoby s trvalo normálnym draslíkom a draslík po nasadení pravidelne sledovať.</td>
      </tr>
      <tr>
        <th scope="row">3.11.5.2</th>
        <td>Odporučiť obmedzenie potravín bohatých na biologicky dostupný draslík, <strong>napríklad spracovaných potravín</strong>.</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Posledný bod si zaslúži zdôraznenie, pretože mení zaužívanú prax. KDIGO 2024 v súhrne výslovne opisuje posun v diétnom poradenstve ako <strong>vyhýbanie sa vysoko spracovaným potravinám, nie vyhýbanie sa ovociu a zelenine</strong>. Plošné odporúčanie „diéty s obmedzením draslíka“, ktoré používa aj editoriál, je preto dnes zastarané: cieľom je obmedziť draslík z aditív a spracovaných potravín, kde je biologická dostupnosť blízka úplnej, a nie pripraviť pacienta o rastlinnú stravu s priaznivým kardiovaskulárnym profilom.</p>

<p>Pozoruhodné je aj to, čo KDIGO 2024 <strong>neodporúča</strong>. V častiach o načasovaní kontroly draslíka a o samotnom manažmente hyperkaliémie neuvádza žiadne odporúčania ani praktické body a pri viazačoch draslíka sa obmedzuje na upozornenie na miestnu dostupnosť a úhradové obmedzenia. Preferencia konkrétneho viazača teda <strong>nemá oporu v odporúčaní</strong> – je to názor editoriálu.</p>

<h2>Čo vyskúšať pred viazačom draslíka</h2>

<p>Editoriál navrhuje postupnosť, ktorej logika je obhájiteľná: diétne opatrenia, slučkové diuretikum, prípadne zmena na sakubitril/valsartan a pridanie inhibítora SGLT2, a až potom viazač draslíka. Dve z týchto opatrení majú konkrétne čísla, ktoré sa oplatí poznať presne.</p>

<p><strong>Sakubitril/valsartan.</strong> Sekundárna analýza štúdie PARADIGM-HF (8 399 pacientov) porovnala sakubitril/valsartan s enalaprilom. U pacientov užívajúcich MRA na začiatku boli celkové výskyty hyperkaliémie medzi skupinami <strong>podobné</strong>; rozdiel sa týkal <em>závažnej</em> hyperkaliémie nad 6,0 mmol/l, ktorá bola častejšia pri enalaprile (3,1 oproti 2,2 príhody na 100 pacientorokov; HR 1,37; 95 % IS 1,06 – 1,76; p = 0,02). Pri zahrnutí pacientov, ktorí MRA začali užívať počas štúdie, bol rozdiel podobný (3,3 oproti 2,3 na 100 pacientorokov; HR 1,43; 95 % IS 1,13 – 1,81; p = 0,003). Formulácia „sakubitril/valsartan znižuje hyperkaliémiu vyvolanú MRA“ je teda presná iba pre závažnú hyperkaliémiu.</p>

<p><strong>Inhibítory SGLT2.</strong> Analýza EMPEROR-Pooled u 9 583 pacientov ukázala, že empagliflozín znížil zložený ukazovateľ hyperkaliémie hlásenej skúšajúcim alebo nasadenia viazača draslíka (6,5 % oproti 7,7 %; HR 0,82; 95 % IS 0,71 – 0,95; p = 0,01). Účinok bol konzistentný pri draslíku nad 5,5 mmol/l (HR 0,85) aj nad 6,0 mmol/l (HR 0,62; 95 % IS 0,48 – 0,81), bez významného nárastu hypokaliémie. Ide o analýzu podskupinových ukazovateľov, nie o vopred určený hlavný cieľ, no smer účinku je konzistentný a inhibítor SGLT2 má u týchto pacientov aj vlastnú indikáciu.</p>

<h2>Téza editoriálu: sodík ako nezamýšľaný dôsledok</h2>

<p>Jadro editoriálu je v tom, že viazače draslíka nie sú farmakodynamicky neutrálne. Draslík totiž musia za niečo vymeniť:</p>

<ul>
  <li><strong>Patiromér</strong> vymieňa draslík za <strong>vápnik</strong>.</li>
  <li><strong>Cyklosilikát zirkoničito-sodný (SZC)</strong> vymieňa draslík za <strong>sodík</strong>.</li>
  <li><strong>Polystyrénsulfonát sodný</strong> (staršia iónomeničová živica) vymieňa draslík takisto za sodík a pri opakovanom podávaní sa môže spájať s objemovým preťažením.</li>
</ul>

<p>Podľa údajov citovaných v editoriáli sa pri SZC v dávke 10 g denne spája nahromadenie sodíka približne <strong>800 mg</strong> a pri 15 g denne približne <strong>1 200 mg</strong>, spolu s nárastom opuchov dolných končatín. Dávka 10 g je pritom najpoužívanejšia.</p>

<p>Autori z toho odvodzujú viacero dôsledkov. Zvýšená sodíková záťaž môže u pacienta so srdcovým zlyhávaním alebo chronickou chorobou obličiek ďalej zvýšiť objem plazmy a napätie steny myokardu. Sodík môže zvyšovať aj oxidačný stres, a tým – aj bez zjavných opuchov – prispievať k mineralokortikoidovej aktivácii cestou Rac1 a oslabovať kardio- a nefroprotektívny účinok RAASi a MRA. U pacientov s albuminúriou navyše vyšší príjem sodíka zvyšuje krvný tlak a oslabuje antiproteinurický účinok RAASi.</p>

<p>Záver editoriálu znie, že snaha umožniť liečbu RAASi a MRA by sa pri vyšších dávkach SZC mohla obrátiť na svoj opak. Ako preferovaný postup pri chronickej hyperkaliémii autori navrhujú <strong>nízku dávku SZC (5 g) alebo patiromér</strong>.</p>

<h2>Tri štúdie, o ktoré sa téza opiera</h2>

<p>Priame prospektívne randomizované porovnanie oboch moderných viazačov s klinickými ukazovateľmi neexistuje. Editoriál preto opiera svoj argument o tri práce.</p>

<div class="table-responsive" role="region" aria-label="Prehľad troch štúdií porovnávajúcich cyklosilikát zirkoničito-sodný s patiromérom alebo placebom" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Charakteristika</th>
        <th scope="col">Zhuo a spol., 2022</th>
        <th scope="col">Tardif a spol., 2023 (PRIORITIZE-HF)</th>
        <th scope="col">Desai a spol., 2024</th>
      </tr>
    </thead>
    <tbody>
      <tr><th scope="row">Dizajn</th><td>Kohortová štúdia nových používateľov (Optum)</td><td>Randomizovaná dvojito zaslepená štúdia</td><td>Retrospektívna kohortová štúdia (Cerner Real World Data)</td></tr>
      <tr><th scope="row">Porovnanie</th><td>SZC oproti patiroméru</td><td>SZC 5 g denne oproti placebu</td><td>SZC oproti patiroméru</td></tr>
      <tr><th scope="row">Počet pacientov</th><td>1 126 oproti 2 839</td><td>92 oproti 90</td><td>19 849 oproti 9 929</td></tr>
      <tr><th scope="row">Podiel so srdcovým zlyhávaním</th><td>približne 30 %</td><td>100 % (symptomatické HFrEF)</td><td>34 %</td></tr>
      <tr><th scope="row">Hlavný ukazovateľ</th><td>Hospitalizácia pre srdcové zlyhávanie</td><td>Intenzita liečby RAASi a MRA po 12 týždňoch</td><td>Hospitalizácia pre HF, závažný edém, úmrtie</td></tr>
      <tr><th scope="row">Výsledok</th><td>35,8 oproti 25,1 príhody na 100 pacientorokov; HR 1,22 (0,95 – 1,56), <strong>bez štatistickej významnosti</strong></td><td>Hlavný ukazovateľ <strong>bez rozdielu</strong> (p = 0,43); zhoršenie HF 12,1 % oproti 5,6 %; <strong>bez rozdielu v NT-proBNP</strong></td><td>HHF HR 1,37 (1,34 – 1,41); závažný edém HR 1,33 (1,30 – 1,36); úmrtie HR 1,29 (1,26 – 1,32)</td></tr>
    </tbody>
  </table>
</div>

<h2>Prečo tieto dôkazy čítať obozretne</h2>

<p>Pri overovaní podkladových prác sa ukázalo niekoľko skutočností, ktoré editoriál neuvádza a ktoré podstatne menia váhu jeho argumentu.</p>

<p><strong>Najväčšia zo štúdií bola spoluautorsky napísaná výrobcom porovnávaného lieku.</strong> V práci Desaia a spolupracovníkov z roku 2024, ktorá jediná priniesla významné rozdiely, sú dvaja zo šiestich autorov zamestnancami spoločnosti CSL Vifor, ktorá uvádza na trh patiromér, a ďalší traja pôsobia u dodávateľa údajov. Zistenie v prospech patiroméru teda pochádza od subjektu, ktorý z neho má priamy obchodný prospech. To výsledok nevyvracia, ale zásadne mení jeho dôkaznú hodnotu.</p>

<p><strong>Podobné prepojenie majú aj autori editoriálu.</strong> Bertram Pitt uvádza opcie alebo podiel v spoločnosti Vifor a Matthew R. Weir pôsobil ako vedecký poradca pre CSL Vifor. Javed Butler neuvádza relevantné vzťahy. Editoriál odporúčajúci patiromér pred vyššími dávkami SZC teda napísali autori, z ktorých dvaja majú väzbu na výrobcu patiroméru.</p>

<p><strong>Randomizovaná štúdia hovorí niečo iné, než sa z nej cituje.</strong> PRIORITIZE-HF bola predčasne ukončená pre pandémiu ochorenia COVID-19 so 182 randomizovanými pacientmi namiesto plánovaného počtu, takže na posúdenie klinických príhod bola výrazne poddimenzovaná. Jej hlavným ukazovateľom nebolo zhoršenie srdcového zlyhávania, ale intenzita liečby RAASi a MRA – a v tomto ukazovateli nebol významný rozdiel, pričom podiel pacientov na cieľovej dávke MRA bol <strong>číselne vyšší v skupine so SZC</strong> (56,4 % oproti 47,0 %). Abstrakt uvádza, že SZC bol celkovo dobre znášaný. Editoriál z tejto štúdie preberá počty zhoršenia srdcového zlyhávania, nespomína však ani predčasné ukončenie, ani to, že vo svojom vlastnom cieli vyznela číselne v prospech SZC.</p>

<p><strong>Štúdia použila práve tú dávku, ktorú editoriál odporúča ako bezpečnejšiu.</strong> PRIORITIZE-HF podávala SZC v dávke 5 g denne. Ak sa teda signál zhoršenia srdcového zlyhávania z tejto štúdie berie vážne, nemožno ho súčasne pripisovať iba vysokým dávkam a odporúčať 5 g ako riešenie. Argument a odporúčanie si tu navzájom odporujú.</p>

<p><strong>Tvrdenie o NT-proBNP nemá oporu v citovaných prácach.</strong> Editoriál uvádza, že zvýšené riziko príhod srdcového zlyhávania sa spájalo so vzostupom NT-proBNP svedčiacim pre nárast objemu plazmy. Jediná z troch prác, ktorá NT-proBNP merala, je PRIORITIZE-HF – a tá zistila, že <strong>rozdiel nebol</strong>. Zvyšné dve sú kohortové analýzy administratívnych a nemocničných údajov, ktoré NT-proBNP neobsahujú. Editoriál sám priznáva, že objem plazmy priamo meraný nebol.</p>

<p><strong>Číselné údaje v tabuľke editoriálu sú nesprávne označené.</strong> Hodnoty 35,8 a 25,1 sú v práci Zhuo a spolupracovníkov <strong>incidencie na 100 pacientorokov</strong>, nie percentá, ako ich uvádza tabuľka editoriálu. Rozdiel medzi nimi navyše nedosiahol štatistickú významnosť (HR 1,22; 95 % IS 0,95 – 1,56), čo pri čítaní samotnej tabuľky nie je zrejmé.</p>

<p>Dodajme aj to, čo svedčí v prospech tézy: všetky tri práce ukazujú rovnaký smer a najväčšia z nich zahŕňa takmer 30 000 pacientov s konzistentným nálezom v podskupinách so srdcovým zlyhávaním aj bez neho. Mechanistické vysvetlenie je biologicky vierohodné. Nejde teda o tézu, ktorú by bolo možné odmietnuť – ide o tézu, ktorá nie je preukázaná.</p>

<h2>Čo z toho vyplýva pre prax</h2>

<ul>
  <li><strong>Hyperkaliémia je dôvodom na liečbu hyperkaliémie, nie na vysadenie RAASi či MRA.</strong> Toto je jediné tvrdenie v článku, ktoré má oporu v odporúčaní (KDIGO praktický bod 3.6.3).</li>
  <li><strong>Pri vzostupe kreatinínu použite správny prah.</strong> Pokračovať, pokiaľ vzostup nepresiahne 30 % do 4 týždňov a hodnota sa stabilizuje; súčasne vylúčiť hypovolémiu, nesteroidové antiflogistiká a stenózu obličkovej tepny.</li>
  <li><strong>Diétne poradenstvo zamerajte na spracované potraviny,</strong> nie plošne na ovocie a zeleninu.</li>
  <li><strong>Vyčerpajte opatrenia pred viazačom:</strong> úprava diuretickej liečby, zváženie sakubitrilu/valsartanu u vhodného pacienta s HFrEF a inhibítor SGLT2, ktorý má u týchto pacientov vlastnú indikáciu.</li>
  <li><strong>Pri výbere viazača zvážte objemový stav.</strong> U pacienta so srdcovým zlyhávaním, sklonom k edémom alebo albuminúriou je úvaha o sodíkovej záťaži legitímna, hoci nie je dokázaná. Vyhýbanie sa zbytočne vysokým dávkam SZC je rozumné aj bez priameho dôkazu.</li>
  <li><strong>Staršie iónomeničové živice nie sú vhodné na chronické podávanie</strong> pre zlú znášanlivosť, nepredvídateľný nástup účinku a hlásené prípady črevnej nekrózy.</li>
  <li><strong>Nevysadzujte MRA náhle</strong> bez zváženia reaktívneho vzostupu aldosterónu.</li>
</ul>

<h2>Limity</h2>

<ul>
  <li>Zdrojom je odborný komentár, nie systematický prehľad; výber podkladových prác nebol systematický a nie je doložená metodika ich hodnotenia.</li>
  <li>Chýba priame prospektívne randomizované porovnanie patiroméru a SZC s klinickými ukazovateľmi; všetky porovnania sú nepriame.</li>
  <li>Dve z troch podkladových prác sú observačné a napriek propenzitnému párovaniu u nich nemožno vylúčiť indikačné skreslenie – SZC sa môže prednostne podávať pacientom v akútnejšom alebo závažnejšom stave.</li>
  <li>Údaje o nahromadení sodíka pri SZC pochádzajú z analýzy hlásení nežiaducich účinkov, nie z priameho merania bilancie sodíka alebo objemu plazmy.</li>
  <li>Editoriál sám uvádza, že chýbajú údaje o zmenách krvného tlaku, hmotnosti a ďalších kardiorenálnych ukazovateľoch, a že nie je zrejmé, aká sodíková záťaž je už priveľká a do akej miery ju možno vyvážiť diuretikom.</li>
  <li>Dostupnosť a úhrada moderných viazačov draslíka sa medzi krajinami líšia; KDIGO na to výslovne upozorňuje.</li>
</ul>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie ani aktuálny súhrn charakteristických vlastností konkrétneho lieku. Pri závažnej alebo symptomatickej hyperkaliémii je potrebný akútny postup, ktorý tento text nerieši.</em></p>

<hr>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=optimalizacia-raasi-mra-hyperkaliemia-ckd-hf">Optimalizácia liečby RAASi a MRA pri hyperkaliémii</a> – praktický rámec postupu.</li>
  <li><a href="article.php?slug=hyperkaliemia-ckd-realna-prax-recidiva-raasi">Hyperkaliémia pri CKD v reálnej praxi</a> – recidíva je pravidlom a najviac na ňu doplácajú MRA.</li>
  <li><a href="article.php?slug=kazuistika-hyperkaliemia-ckd-hf-zachovanie-raas">Kazuistika: zachovanie liečby pri hyperkaliémii</a> – postup u konkrétneho pacienta.</li>
  <li><a href="article.php?slug=kontrola-draslika-ckd-edukovat-nie-strasit">Kontrola draslíka pri chorobe obličiek</a> – prečo plošné obmedzenie ovocia a zeleniny škodí.</li>
  <li><a href="article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026">Srdcové zlyhávanie a CKD podľa KDIGO</a> – kontroverzie roku 2026.</li>
  <li><a href="article.php?slug=finerenon-nefroprotekcia-ckd-3-4-bez-ohladu-na-diabetes">Finerenón pri CKD 3 – 4</a> – nesteroidný MRA a riziko hyperkaliémie.</li>
  <li><a href="article.php?slug=esc-era-2026-kardiorenalne-odporucania">Kardiorenálne odporúčania ESC a ERA 2026</a> – širší kontext.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Bertram Pitt, Javed Butler, Matthew R. Weir.</strong> <em>Enabling a Renin-Angiotensin System Inhibitor and/or a Mineralocorticoid Receptor Antagonist in Patients With Heart Failure and/or Chronic Kidney Disease: Unintended Consequences of Increased Sodium Exposure.</em> JACC: Heart Failure. 2026;14(8):103114. <a href="https://doi.org/10.1016/j.jchf.2026.103114" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney International. 2024;105(4S):S117–S314. <a href="https://doi.org/10.1016/j.kint.2023.10.018" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://kdigo.org/wp-content/uploads/2017/02/KDIGO-2024-CKD-Guideline-Executive-Summary.pdf" target="_blank" rel="noopener noreferrer">súhrn pre prax (PDF)</a>.</li>
  <li><strong>George L. Bakris, Matthew R. Weir.</strong> <em>Angiotensin-converting enzyme inhibitor-associated elevations in serum creatinine: is this a cause for concern?</em> Archives of Internal Medicine. 2000;160(5):685–693. <a href="https://doi.org/10.1001/archinte.160.5.685" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Akshay S. Desai, Orly Vardeny, Brian Claggett, John J. V. McMurray, Milton Packer, Karl Swedberg a spol.</strong> <em>Reduced Risk of Hyperkalemia During Treatment of Heart Failure With Mineralocorticoid Receptor Antagonists by Use of Sacubitril/Valsartan Compared With Enalapril: A Secondary Analysis of the PARADIGM-HF Trial.</em> JAMA Cardiology. 2017;2(1):79–85. <a href="https://doi.org/10.1001/jamacardio.2016.4733" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>João Pedro Ferreira, Faiez Zannad, Javed Butler, Gerasimos Filippatos, Ivana Ritter, Elke Schüler a spol.</strong> <em>Empagliflozin and serum potassium in heart failure: an analysis from EMPEROR-Pooled.</em> European Heart Journal. 2022;43(31):2984–2993. <a href="https://doi.org/10.1093/eurheartj/ehac306" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Min Zhuo, Seoyoung C. Kim, Elisabetta Patorno, Julie M. Paik.</strong> <em>Risk of Hospitalization for Heart Failure in Patients With Hyperkalemia Treated With Sodium Zirconium Cyclosilicate Versus Patiromer.</em> Journal of Cardiac Failure. 2022;28(9):1414–1423. <a href="https://doi.org/10.1016/j.cardfail.2022.04.003" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Jean-Claude Tardif, Jean Rouleau, Glenn M. Chertow, Ayman Al-Shurbaji, Vera Lisovskaja, Stephanie Gustavson a spol. (PRIORITIZE-HF).</strong> <em>Potassium reduction with sodium zirconium cyclosilicate in patients with heart failure.</em> ESC Heart Failure. 2023;10(2):1066–1076. <a href="https://doi.org/10.1002/ehf2.14268" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10053160/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Nihar R. Desai, Jennifer Kammerer, Jeffrey Budden, Abisola Olopoenia, Asa Tysseling, Alexandra Gordon.</strong> <em>The Association of Heart Failure and Edema Events between Patients Initiating Sodium Zirconium Cyclosilicate or Patiromer.</em> Kidney360. 2024;5(12):1835–1843. <a href="https://doi.org/10.34067/KID.0000000586" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC11687973/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Jordan Weinstein, Louis-Philippe Girard, Serge Lepage, Robert S. McKelvie, Karthik Tennankore.</strong> <em>Prevention and management of hyperkalemia in patients treated with renin–angiotensin–aldosterone system inhibitors.</em> Canadian Medical Association Journal. 2021;193(48):E1836–E1841. <a href="https://doi.org/10.1503/cmaj.210831" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Text editoriálu vrátane jeho tabuľky, zoznamu literatúry a vyhlásení o konfliktoch záujmov bol prečítaný v plnom znení. Číselné údaje všetkých podkladových prác boli overené proti ich abstraktom v databáze PubMed: Zhuo a spol. (1 126 oproti 2 839 pacientom, 88 oproti 245 príhodám, 35,8 oproti 25,1 na 100 pacientorokov, HR 1,22; 0,95 – 1,56), PRIORITIZE-HF (182 randomizovaných, SZC 5 g, predčasné ukončenie pre COVID-19, p = 0,43, 56,4 % oproti 47,0 %), Desai a spol. 2024 (19 849 oproti 9 929, HR 1,373; 1,330 a 1,287), PARADIGM-HF (8 399 pacientov, 3,1 oproti 2,2 a 3,3 oproti 2,3 na 100 pacientorokov, HR 1,37 a 1,43), EMPEROR-Pooled (9 583 pacientov, 6,5 % oproti 7,7 %, HR 0,82; 0,85 a 0,62) a Bakris s Weirom (12 štúdií, prah 30 %, draslík ≥ 5,6 mmol/l). Praktické body KDIGO 3.6.2 až 3.6.5, 3.8.3 a 3.11.5.2 boli prevzaté z doslovného znenia súhrnu pre prax. Bibliografia bola overená cez PubMed a Crossref. <strong>Opravy oproti pôvodnej predlohe a zdroju:</strong> zdrojom nie je „prehľadový článok Medscape“, ale editoriál v JACC: Heart Failure, ktorého autori v predlohe chýbali. Hodnoty 35,8 a 25,1 sú incidencie na 100 pacientorokov, nie percentá, ako ich označuje tabuľka editoriálu. Tvrdenie editoriálu o vzostupe NT-proBNP nemá oporu v žiadnej z troch citovaných prác a randomizovaná štúdia zistila opak. Predloha uvádzala, že randomizovaná štúdia porovnávala SZC s placebom „u symptomatických pacientov s HFrEF“, neuviedla však jej predčasné ukončenie, použitú dávku 5 g ani to, že jej hlavný ukazovateľ vyznel číselne v prospech SZC. Predloha ani editoriál neuviedli zamestnanecké prepojenie autorov najväčšej podkladovej štúdie so spoločnosťou CSL Vifor. <strong>Vlastným odborným spracovaním</strong> je konfrontácia editoriálu s doslovným znením KDIGO 2024 vrátane zistenia, že odporúčanie žiadny konkrétny viazač neuprednostňuje, upozornenie na posun diétneho poradenstva od ovocia a zeleniny k spracovaným potravinám, spresnenie, že prínos sakubitrilu/valsartanu sa týka iba závažnej hyperkaliémie, upozornenie na rozpor medzi dávkou použitou v PRIORITIZE-HF a odporúčanou dávkou, a celé zhrnutie pre prax.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_hyperkaliemia-raasi-mra-viazace-draslika-sodik_article',
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
