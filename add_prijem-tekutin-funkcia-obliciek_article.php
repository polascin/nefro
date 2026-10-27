<?php

/**
 * add_prijem-tekutin-funkcia-obliciek_article.php
 * Prijem tekutin a funkcia obliciek: Chen 2026 (Am J Nephrol), CKD WIT (JAMA 2018), Wu 2016 (BMJ Open), Armstrong 2024.
 *
 * enqueue_newsletter je zamerne false: aviza sa pri tomto clanku neposielaju.
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
    'title'        => 'Príjem tekutín a funkcia obličiek: observačné asociácie a hranica randomizovanej skúšky',
    'slug'         => 'prijem-tekutin-funkcia-obliciek',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Vyšší príjem tekutín súvisí v observačnej metaanalýze s pomalším poklesom eGFR najmä pri filtrácii aspoň 60. Pri 3. štádiu randomizovaná štúdia rozdiel v eGFR za rok nepreukázala.',
    'content'      => <<<'HTML'
<figure><a href="img/prijem-tekutin-funkcia-obliciek.webp" rel="noopener noreferrer" target="_blank"><img src="img/prijem-tekutin-funkcia-obliciek.webp" alt="Priesvitná oblička v tme, do ktorej vchádza úzky prúd vody a z dolného pólu odkvapkáva do tmavej hladiny" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka pacienta ani návod, koľko piť. Úzky prúd je obraz otázky článku: vyššia hydratácia sa v observačných údajoch spája s pomalším poklesom filtrácie, randomizovaná skúška v 3. štádiu však za jeden rok rozdiel v eGFR nepreukázala.</figcaption></figure>

<p class="article-dek"><em>Metaanalýza 16 štúdií s 70&nbsp;053 dospelými, zverejnená 16. októbra 2026 v American Journal of Nephrology, spája vyšší celkový príjem tekutín s pomalším poklesom odhadovanej glomerulovej filtrácie a s nižšou šancou už prítomnej pokročilej chronickej choroby obličiek. Asociácia poklesu filtrácie sa týkala súborov s priemernou vstupnou hodnotou aspoň 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup>. V randomizovanej štúdii CKD WIT u ľudí s 3. štádiom sa cielené zvýšenie pitia vody na eGFR za jeden rok nepremietlo.</em></p>

<p>Otázka v ambulancii znie jednoducho a odpoveď jednoduchá nie je. Má človek s chronickou chorobou obličiek piť viac, aby si ochránil filtráciu? Väčšina prác, ktoré sa citujú v prospech vyššieho príjmu, je observačná. Kto je chorší, často pije inak. Iná je diéta, pohyblivosť aj lieky. Nižšie sú preto len štyri dohľadateľné zdroje. Oddelené je, čo zmerali, od toho, čo sa z nich nedá urobiť príčina.<sup>1,2,3,4</sup></p>

<h2>Čo sa dá čakať od vazopresínu</h2>

<p>Pri nižšom príjme vody stúpa osmolalita plazmy a stúpa vazopresín. Jeho náhradný ukazovateľ v krvi je copeptín. Vyšší príjem vody copeptín znižuje, moč je menej koncentrovaný a oblička má inú hemodynamiku, než keď vodu šetrí. To je biologicky zrozumiteľný mechanizmus. Nie je to dôkaz, že každý ďalší liter spomalí pokles filtrácie o predvídateľný krok. Do vzťahu vstupujú telesná hmotnosť, soľ, zloženie nápojov, diuretiká, srdcové zlyhávanie a to, či je nízky príjem príčinou, alebo už dôsledkom choroby.</p>

<p>Skúška CKD WIT túto os priamo zasiahla. Ľudia vedení k vyššiemu pitiu vody mali po roku copeptín nižší o 2,2&nbsp;pmol/l oproti skupine s doterajším príjmom. Filtrácia sa napriek tomu medzi skupinami nelíšila. Pohyb ukazovateľa teda nestačí na záver, že sa pohla aj funkcia.<sup>2</sup></p>

<h2>Metaanalýza z októbra 2026</h2>

<p>Jia-Jin Chen a spolupracovníci urobili systematický prehľad a metaanalýzu vzťahu dávky a účinku. Prehľadali EMBASE, PubMed a Cochrane Library po február 2025. Hľadali štúdie dospelých, v ktorých bol celkový príjem tekutín, príjem čistej vody alebo objem moču uvedený vo vzťahu k poklesu eGFR alebo k už prítomnej pokročilej chronickej chorobe obličiek. Zaradili 16 štúdií a 70&nbsp;053 ľudí. Registrácia PROSPERO má číslo CRD42024627796. Práca vyšla online 16. októbra 2026. Ročník a strany časopis v deň overenia ešte nemal.<sup>1</sup></p>

<p>Vyšší celkový príjem tekutín bol lineárne spojený s pomalším poklesom eGFR (p&nbsp;=&nbsp;0,02). Koeficient bol β&nbsp;=&nbsp;0,97&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> za rok, 95&nbsp;% interval spoľahlivosti od 0,15 do 1,79. Abstrakt nehovorí, na aký prírastok príjmu, v litroch alebo v inej jednotke, sa tento koeficient vzťahuje. Bez tejto jednotky sa β nedá preložiť do vety „o koľko mililitrov za rok spomalí jeden liter navyše“. Rovnako abstrakt neudáva číselný rozsah príjmu, v ktorom asociácia platí. Píše len „v skúmaných rozsahoch“.</p>

<p>Pre už prítomnú pokročilú chorobu uvádzajú logaritmus pomeru šancí −0,27 (95&nbsp;% interval spoľahlivosti od −0,43 do −0,11; p&nbsp;&lt;&nbsp;0,001). Prepočet na pomer šancí, približne 0,76 (od 0,65 do 0,90), je redakčný. Abstrakt ho neuvádza a neuvádza ani kontrast príjmu, ku ktorému sa logaritmus vzťahuje. Ide o šancu, že pokročilá choroba v súbore už je, nie o riziko, že vznikne. Pri prierezovom ukazovateli je zámena príčiny a následku blízko: človek s pokročilou chorobou môže piť menej preto, že chorobu už má.</p>

<p>Vopred určené podskupiny výsledok rozdelili. Asociácia s poklesom eGFR sa objavila v štúdiách, ktorých priemerná vstupná eGFR bola aspoň 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> (p&nbsp;=&nbsp;0,016). V štúdiách s priemernou vstupnou eGFR pod 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> sa neobjavila. Abstrakt pre tieto podskupiny neuvádza samostatné koeficienty, len uvedenú hodnotu p pri zachovalejšej filtrácii a absenciu asociácie pri nižšej. Dôkaz pre čistú vodu a pre objem moču autori označujú za obmedzený. Čo sa teda dá z metaanalýzy vyvodiť, týka sa celkového príjmu tekutín, nie samotnej vody.</p>

<p>Záver autorov je v abstrakte priamy. Vyšší denný celkový príjem bol spojený s pomalším poklesom eGFR a s nižšou šancou už prítomnej pokročilej choroby, najmä v súboroch s priemernou eGFR aspoň 60. Keďže dôkazy boli prevažne observačné, nedá sa z nich uzavrieť, že zvýšenie príjmu filtráciu uchová.<sup>1</sup></p>

<div class="table-responsive" role="region" aria-label="Hlavné čísla metaanalýzy a štúdie CKD WIT" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Zdroj</th>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Výsledok v abstrakte</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Chen a spolupracovníci, 2026</th>
        <td>Pokles eGFR</td>
        <td>β&nbsp;=&nbsp;0,97&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> za rok (95&nbsp;% IS od 0,15 do 1,79). Jednotka príjmu pri β v abstrakte chýba.</td>
      </tr>
      <tr>
        <th scope="row">Chen a spolupracovníci, 2026</th>
        <td>Už prítomná pokročilá choroba</td>
        <td>Logaritmus pomeru šancí −0,27 (95&nbsp;% IS od −0,43 do −0,11).</td>
      </tr>
      <tr>
        <th scope="row">Clark a spolupracovníci, 2018</th>
        <td>Zmena eGFR za 12 mesiacov</td>
        <td>Upravený rozdiel −0,3&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> (95&nbsp;% IS od −1,8 do 1,2; p&nbsp;=&nbsp;0,74).</td>
      </tr>
      <tr>
        <th scope="row">Clark a spolupracovníci, 2018</th>
        <td>Objem moču a copeptín</td>
        <td>Objem moču o 0,6&nbsp;l/deň vyšší (95&nbsp;% IS od 0,5 do 0,7). Copeptín: rozdiel −2,2&nbsp;pmol/l (95&nbsp;% IS od −3,9 do −0,5).</td>
      </tr>
    </tbody>
  </table>
</div>

<h2>Randomizovaná skúška v 3. štádiu</h2>

<p>William F. Clark a spolupracovníci publikovali v roku 2018 v JAMA skúšku CKD WIT. Deväť centier v Ontáriu randomizovalo od roku 2013 do roku 2017 631 dospelých s 3. štádiom chronickej choroby obličiek. Podmienkou bola eGFR od 30 do 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup>, mikroalbuminúria alebo makroalbuminúria a objem moču pod 3,0&nbsp;l za 24 hodín. Priemerný vek bol 65,0 roka, mužov bolo 63,4&nbsp;%, priemerná eGFR 43&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> a medián albumínu v moči 123&nbsp;mg/deň. Skupina s hydratáciou (n&nbsp;=&nbsp;316) bola vedená k vyššiemu pitiu vody. Kontrolná skupina (n&nbsp;=&nbsp;315) mala príjem ponechať. Primárnym ukazovateľom bola zmena eGFR za 12 mesiacov. Posledný deň sledovania bol 25. máj 2017. Register je NCT01766687.<sup>2</sup></p>

<p>Z 631 ľudí zomrelo 12, päť v skupine s hydratáciou a sedem v kontrolnej. Medzi 590 ľuďmi so živým sledovaním a meraním po roku, čo je 95&nbsp;% z 619 preživších, stúpol 24-hodinový objem moču v skupine s hydratáciou o 0,6&nbsp;l/deň viac (95&nbsp;% interval spoľahlivosti od 0,5 do 0,7; p&nbsp;&lt;&nbsp;0,001). Priemerná zmena eGFR bola −2,2&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> pri vyššom pití a −1,9&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> pri doterajšom príjme. Upravený rozdiel medzi skupinami bol −0,3&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> (od −1,8 do 1,2; p&nbsp;=&nbsp;0,74). Bodový odhad teda neleží na strane pomalšieho poklesu. Interval však pripúšťa aj spomalenie približne o 1&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> za rok, aj rýchlejší pokles. Autori sami píšu, že skúška mohla mať malú silu na klinicky dôležitý rozdiel.<sup>2</sup></p>

<p>Sekundárne ukazovatele sa rozišli len sčasti. Rozdiel copeptínu bol −2,2&nbsp;pmol/l (95&nbsp;% interval spoľahlivosti od −3,9 do −0,5; p&nbsp;=&nbsp;0,01). Klírens kreatinínu bol vyšší o 3,6&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> (od 0,8 do 6,4; p&nbsp;=&nbsp;0,01). Albumín v moči sa nelíšil: rozdiel 7&nbsp;mg/deň (od −4 do 51; p&nbsp;=&nbsp;0,11). Celkové hodnotenie zdravia na škále od 0 do 10 sa nelíšilo: 0,2 bodu (od −0,3 do 0,3; p&nbsp;=&nbsp;0,22). Klírens kreatinínu nie je eGFR. Štúdia ho uvádza ako sekundárny ukazovateľ. Jeho vzostup pri vyššom prietoku moču nie je dôkaz, že stúpla glomerulová filtrácia. Záver skúšky stojí na primárnom ukazovateli. Cielené zvýšenie pitia vody oproti ponechaniu doterajšieho príjmu pokles eGFR za jeden rok významne nespomalilo.<sup>2</sup></p>

<p>Títo ľudia patria do vrstvy, v ktorej metaanalýza Chena asociáciu s poklesom eGFR nenašla: priemerná vstupná filtrácia pod 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup>. Zhoda nie je dôkaz, že metaanalýza negatívnu skúšku predpovedala. Je to dôvod neprenášať observačnú asociáciu od ľudí so zachovalejšou filtráciou na človeka, ktorý už má 3. štádium a albuminúriu.</p>

<h2>Kohorta NHANES a rozpor v tabuľkách</h2>

<p>Li-Wei Wu a spolupracovníci uverejnili v BMJ Open v roku 2016 observačnú analýzu 2&nbsp;182 dospelých starších ako 20 rokov z Third National Health and Nutrition Examination Survey (1988 až 1994). Mortalitu sledovali do 31. decembra 2006, medián 15,4 roka. Za ten čas zomrelo 1&nbsp;080 ľudí, z toho 473 na kardiovaskulárnu príčinu. Denný príjem tekutín bol jedno 24-hodinové spätné zisťovanie. Započítaná bola aj voda v jedle a iné nápoje, nielen voda z pohára. Vylúčení boli tehotné ženy, ľudia užívajúci lítium alebo diuretikum a ľudia s kongestívnym srdcovým zlyhávaním. Chronickú chorobu definovali ako eGFR najviac 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup> podľa skrátenej rovnice zo štúdie MDRD, vrátane rasového koeficientu, alebo ako pomer albumínu a kreatinínu v moči najmenej 30&nbsp;mg/g. Skupina teda nie je jedno štádium v dnešnom delení a rovnica nie je tá, ktorou sa eGFR počíta dnes.<sup>3</sup></p>

<p>Kvartily celkového príjmu boli najviac 2,147&nbsp;l/deň, potom do 2,789&nbsp;l/deň, do 3,576&nbsp;l/deň a najmenej 3,576&nbsp;l/deň. Dolný kvartil nie je skupina ľudí, ktorí takmer nepijú. Ide o celkovú vodu vrátane jedla. Tabuľka 2 uvádza 933 ľudí s takto definovanou chorobou: priemerný vek 70,39 roka, priemerná eGFR 50,68&nbsp;ml/min/1,73&nbsp;m<sup>2</sup>, priemerný príjem 2&nbsp;865&nbsp;ml/deň. Bez choroby ich bolo 1&nbsp;249: vek 63,76 roka, eGFR 71,35, príjem 3&nbsp;049&nbsp;ml/deň.<sup>3</sup></p>

<p>Text výsledkov pripisuje skupine s chorobou pre celkovú mortalitu upravený pomer hazardov 0,741 (95&nbsp;% interval spoľahlivosti od 0,566 do 0,970; p&nbsp;=&nbsp;0,029) pri najvyššom kvartile oproti najnižšiemu. Pre kardiovaskulárnu mortalitu v tej istej skupine uvádza upravený pomer hazardov 0,827 (od 0,643 do 1,115; p&nbsp;=&nbsp;0,236). Úprava zahŕňala vek, pohlavie, etnicitu, index telesnej hmotnosti, obvod pása, leukocyty, eGFR, HDL cholesterol, apolipoproteín AI, glukózu, fibrinogén, albumín, C-reaktívny proteín, fajčenie, rakovinu, emfyzém, diabetes a artritídu. Po tejto úprave teda autori opisujú nižšiu celkovú mortalitu a neopisujú významný rozdiel v kardiovaskulárnej mortalite.<sup>3</sup></p>

<p>Hlavičky tabuliek 3 a 4 majú počty obrátene voči tabuľke 2. Pri skupine bez choroby uvádzajú 933 a pri skupine s chorobou 1&nbsp;249. Čísla 0,741 a 0,827 sedia s pravým blokom týchto tabuliek, ktorý je označený ako skupina s chorobou, ale s počtom 1&nbsp;249. Ľavý blok, označený ako skupina bez choroby s počtom 933, má pre celkovú mortalitu v najvyššom kvartile upravený pomer hazardov 1,002 (od 0,768 do 1,308; p&nbsp;=&nbsp;0,985). Kým časopis rozpor v označení skupín neopraví, pomer 0,741 nie je bezpečné priradiť k súboru 933 ľudí s priemernou eGFR 50,68. Aritmetika úmrtí v texte sedí so súhrnom 1&nbsp;080 a 473. Nesedí priradenie veľkosti skupín. V diskusii je navyše veta, podľa ktorej táto práca merala 24-hodinový objem moču a vyhla sa skresleniu spätného zisťovania. Metódy opisujú práve jedno 24-hodinové spätné zisťovanie príjmu, nie zber moču. Veta v diskusii preto nie je opis metódy.<sup>3</sup></p>

<h2>Čo prehľad o nízkom príjme vody nepreukazuje</h2>

<p>Lawrence E. Armstrong a spolupracovníci uverejnili v roku 2024 v Nutrition and Health prehľad, nie metaanalýzu so spojeným odhadom. Z 3&nbsp;903 prác podľa názvu a abstraktu nechali 96. Pri celkovej mortalite označujú dôkaz za chýbajúci. Za silný ho označujú pri obličkových kameňoch a pri diabete 2. typu s hyperglykémiou. Pri siedmich ďalších chorobách ho v abstrakte označujú za nedostatočný alebo rozporný a v súhrne ich nemenujú. Rozdiely medzi ženami a mužmi uvádzajú z deviatich štúdií pri piatich chorobách. Prehľad teda nie je oporou vety, že nízky príjem vody zvyšuje celkovú mortalitu pri chronickej chorobe obličiek. Kameň a hyperglykémia sú iné otázky než pokles eGFR.<sup>4</sup></p>

<h2>Čo z toho plynie pri konkrétnom pacientovi</h2>

<p>Cieľom nie je maximálny príjem. Cieľom je príjem, ktorý konkrétny človek znesie. Metaanalýza dáva observačný signál najmä tam, kde je priemerná filtrácia ešte aspoň 60&nbsp;ml/min/1,73&nbsp;m<sup>2</sup>, a sama odmieta kauzálny záver. Skúška u ľudí s eGFR od 30 do 60, s albuminúriou a s objemom moču pod 3 litre, zvýšenie pitia vody na ročnú zmenu eGFR nepretavila. Kohorta, ktorá sa cituje pre mortalitu, vylúčila diuretiká a srdcové zlyhávanie a jej tabuľky sa v počte ľudí s chorobou nezhodujú.</p>

<p>Pri edémoch, srdcovom zlyhávaní, hyponatriémii v anamnéze a pri diuretikách nemá zmysel pridávať tekutiny podľa populačnej asociácie. Wu ľudí na diuretiku a so srdcovým zlyhávaním do analýzy nezaradil. Nútené pitie bez ohľadu na sodík v sére môže hyponatriémiu prehĺbiť. To nie je výsledok uvedených štúdií. Je to dôvod, prečo sa objem neriadi heslom.</p>

<p>Pri dialýze sa príjem riadi režimom, interdialyzačným prírastkom hmotnosti a toleranciou ultrafiltrácie. Ani Chen, ani CKD WIT, ani Wu túto situáciu neskúmali. Autozómovo dominantná polycystická choroba obličiek je iná biológia vody a iná liečba. Tento článok ju nepokrýva.</p>

<h2>Limity</h2>

<p>Plný text metaanalýzy Chena nebol voľne dostupný. Čísla sú zo štruktúrovaného abstraktu. Chýba jednotka, na ktorú sa viaže β, chýba kontrast pri logaritme pomeru šancí a chýbajú koeficienty podskupín. Bez nich sa nedá povedať, aký prírastok príjmu zodpovedá publikovanému spomaleniu poklesu eGFR. Unpaywall prácu označil ako uzavretú.</p>

<p>CKD WIT poznám z abstraktu, nie z protokolu ani z tabuliek plného textu. Abstrakt neudáva, o koľko litrov vody mali ľudia príjem zvýšiť, len o koľko stúpol objem moču. Jeden rok a interval, ktorý pripúšťa rozdiel približne 1&nbsp;ml/min/1,73&nbsp;m<sup>2</sup>, nechávajú otvorenú možnosť menšieho účinku, ktorý skúška nevedela preukázať. Dvanásť úmrtí nie je mortalitný výsledok.</p>

<p>Wu má plný text. Práve preto je vidieť rozpor hlavičiek tabuliek 3 a 4 s tabuľkou 2 a vetu v diskusii, ktorá nezodpovedá metódam. Jedno spätné zisťovanie za 24 hodín nie je dlhodobý príjem. Zloženie tekutín práca oddeliť nevie, čo autori v závere sami píšu. Armstrongov prehľad poznám z abstraktu. Sedem chorôb s nedostatočným dôkazom abstrakt nevymenúva.</p>

<h2>Záver</h2>

<p>Vyšší celkový príjem tekutín je v observačnej metaanalýze spojený s pomalším poklesom eGFR najmä v súboroch so zachovalejšou filtráciou a s nižšou šancou, že pokročilá choroba v súbore už je. Zvýšenie pitia vody v randomizovanej skúške pri 3. štádiu s albuminúriou za jeden rok eGFR nezmenilo, hoci copeptín klesol a objem moču stúpol. Tvrdenie, že vyšší príjem v chronickej chorobe znižuje celkovú mortalitu, sa o kohortu NHANES III oprieť nedá, kým sa neopraví označenie skupín v jej mortalitných tabuľkách. Kardiovaskulárnu mortalitu táto kohorta ako významný rozdiel neopisuje ani vo vlastnom texte. Rozumná veta pre prax je primeraný a bezpečný príjem podľa edémov, srdca, sodíka, diuretík a dialyzačného režimu. Veta „piť čo najviac“ z týchto prác nevyplýva.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne rozhodnutie pri edémoch, srdcovom zlyhávaní, hyponatriémii, diuretikách ani pri dialýze. Observačná asociácia nie je návod na zvyšovanie príjmu.</em></p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=vasopresin-nezavisla-cesta-regulacie-vody-adpkd">Nová, od vazopresínu nezávislá cesta regulácie vody v obličkách a jej význam pre liečbu ADPKD</a></li>
</ul>

<h2>Zdroje</h2>

<ol>
  <li id="ref-chen-2026"><strong>Jia-Jin Chen, Tao Han Lee, Cheng-Chia Lee, Ming-Jen Chan, Tsung-Yu Tsai, Pei-Chun Fan, Chieh-Li Yen, Huang-Yu Yang, Yu-Kang Tu, Dmytro Ivanov, Yung-Chang Chen, Chih-Hsiang Chang.</strong> <em>Fluid Intake and Kidney Function: A Systematic Review and Dose-Response Meta-analysis.</em> American Journal of Nephrology. Zverejnené online 16. októbra 2026. Ročník, číslo a strany v čase overenia neboli pridelené. <a href="https://doi.org/10.1159/ajn/ablag027" target="_blank" rel="noopener noreferrer">DOI 10.1159/ajn/ablag027</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/42886618/" target="_blank" rel="noopener noreferrer">PubMed 42886618</a>.</li>
  <li id="ref-clark-2018"><strong>William F. Clark, Jessica M. Sontrop, Shih-Han Huang, Kerri Gallo, Louise Moist, Andrew A. House, Meaghan S. Cuerden, Matthew A. Weir, Amit Bagga, Scott Brimble, Andrew Burke, Norman Muirhead, Sanjay Pandeya, Amit X. Garg.</strong> <em>Effect of Coaching to Increase Water Intake on Kidney Function Decline in Adults With Chronic Kidney Disease: The CKD WIT Randomized Clinical Trial.</em> JAMA. 2018, ročník 319, číslo 18, strany 1870 až 1879. <a href="https://doi.org/10.1001/jama.2018.4930" target="_blank" rel="noopener noreferrer">DOI 10.1001/jama.2018.4930</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/29801012/" target="_blank" rel="noopener noreferrer">PubMed 29801012</a>. Register <a href="https://clinicaltrials.gov/study/NCT01766687" target="_blank" rel="noopener noreferrer">NCT01766687</a>.</li>
  <li id="ref-wu-2016"><strong>Li-Wei Wu, Wei-Liang Chen, Fang-Yih Liaw, Yu-Shan Sun, Hui-Fang Yang, Chung-Ching Wang, Chien-Ming Lin, Yu-Tzu Tsao.</strong> <em>Association between fluid intake and kidney function, and survival outcomes analysis: a nationwide population-based study.</em> BMJ Open. 2016, ročník 6, číslo 5, článok e010708. <a href="https://doi.org/10.1136/bmjopen-2015-010708" target="_blank" rel="noopener noreferrer">DOI 10.1136/bmjopen-2015-010708</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/27173809/" target="_blank" rel="noopener noreferrer">PubMed 27173809</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4874113/" target="_blank" rel="noopener noreferrer">PMC4874113</a>.</li>
  <li id="ref-armstrong-2024"><strong>Lawrence E. Armstrong, Michael F. Bergeron, Colleen X. Muñoz, Stavros A. Kavouras.</strong> <em>Low daily water intake profile—is it a contributor to disease?</em> Nutrition and Health. 2024, ročník 30, číslo 3, strany 435 až 446. <a href="https://doi.org/10.1177/02601060241238826" target="_blank" rel="noopener noreferrer">DOI 10.1177/02601060241238826</a>. <a href="https://pubmed.ncbi.nlm.nih.gov/38515347/" target="_blank" rel="noopener noreferrer">PubMed 38515347</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom.</strong> Abstrakt Chena bol načítaný z PubMed (efetch, PMID 42886618) a porovnaný s Europe PMC. Dvanásť autorov, dátum 16. októbra 2026 a absencia ročníka a strán sú z Crossref. Unpaywall označil plný text ako uzavretý, takže jednotka pri β a kontrast pri logaritme pomeru šancí overené nie sú. Prepočet logaritmu na pomer šancí približne 0,76 je redakčný. Číslo PROSPERO je z abstraktu. Stránka registra bez JavaScriptu záznam neukázala, takže znenie registrácie som nečítal. Abstrakt CKD WIT bol načítaný z PubMed (PMID 29801012). Štrnásť autorov, ročník, číslo a strany 1870 až 1879 sú z Crossref. Plný text JAMA ani protokol som nečítal. Cieľový prírastok vody v mililitroch abstrakt neuvádza, uvádzam len dosiahnutý rozdiel objemu moču. Wu som čítal v plnom texte JATS z Europe PMC (PMC4874113), vrátane tabuliek 2, 3 a 4. Osem autorov a bibliografia sú z Crossref. Rozpor v počte 933 a 1&nbsp;249 medzi tabuľkou 2 a hlavičkami tabuliek 3 a 4 je v súbore, nie v preklade. Armstrongov abstrakt je z PubMed (PMID 38515347), štyria autori, ročník, číslo a strany z Crossref. Plný text prehľadu som nečítal, preto sedem chorôb s nedostatočným dôkazom nemenujem. Vlastné je odmietnutie preniesť observačnú asociáciu pri eGFR aspoň 60 na 3. štádium, oddelenie poklesu copeptínu od nezmenenej eGFR a odmietnutie použiť pomer hazardov 0,741 ako číselný podklad, kým označenie skupín v BMJ Open nesedí.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => false,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_prijem-tekutin-funkcia-obliciek_article',
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
