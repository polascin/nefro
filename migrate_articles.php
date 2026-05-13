<?php
/**
 * migrate_articles.php
 * Jednorazová migrácia článkov z hardcode-ovaného HTML do databázovej tabuľky articles.
 * Prístupné len pre prihlásených adminov alebo z CLI.
 * Po spustení migrácie môžete tento súbor odstrániť alebo ponechať (idempotentný – vkladá len chýbajúce).
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

// ── Dáta článkov ──────────────────────────────────────────────────────────────

$articles = [];

// ── Článok 1 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Tirzepatid verzus semaglutid: nižšia mortalita a menej gastrointestinálnych komplikácií?',
    'slug'         => 'tirzepatid-verzus-semaglutid-nizsia-mortalita-a-menej-gi-komplikacii',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-11',
    'is_top'       => 1,
    'excerpt'      => 'Tirzepatid bol vo veľkej observačnej analýze z reálnej klinickej praxe spojený s nižšou celkovou mortalitou a s menším výskytom niektorých gastrointestinálnych nežiaducich udalostí v porovnaní so semaglutidom. Výsledky boli prezentované na Digestive Disease Week 2026 a môžu byť zaujímavé najmä pre diabetológov, internistov, nefrológov, kardiológov a lekárov starajúcich sa o pacientov s obezitou a diabetom 2. typu.',
    'content'      => <<<'HTML'
<p><strong>Tirzepatid bol vo veľkej observačnej analýze z reálnej klinickej praxe spojený s nižšou celkovou mortalitou a s menším výskytom niektorých gastrointestinálnych nežiaducich udalostí v porovnaní so semaglutidom. Výsledky boli prezentované na Digestive Disease Week 2026 a môžu byť zaujímavé najmä pre diabetológov, internistov, nefrológov, kardiológov a lekárov starajúcich sa o pacientov s obezitou a diabetom 2. typu.</strong></p>
<p>Tirzepatid a semaglutid patria medzi lieky, ktoré výrazne zmenili manažment diabetu 2. typu a obezity. Semaglutid pôsobí ako agonista GLP-1 receptorov, zatiaľ čo tirzepatid je duálny inkretínový agonista s účinkom na receptory GIP a GLP-1. Oba lieky zlepšujú glykemickú kontrolu, podporujú redukciu telesnej hmotnosti a majú potenciálne kardiometabolické benefity.</p>
<p>Nové údaje z veľkej globálnej kohorty však naznačujú, že medzi týmito dvoma molekulami môžu existovať rozdiely nielen v účinnosti, ale aj v bezpečnostnom profile.</p>

<h3>Veľká analýza z reálnej klinickej praxe</h3>
<p>Výskumníci využili databázu <strong>TriNetX Global Collaborative Network</strong>, ktorá umožňuje analyzovať veľké súbory pacientov z bežnej praxe. Do štúdie zaradili pacientov s nadváhou alebo obezitou a diabetom 2. typu, ktorí začali liečbu buď tirzepatidom, alebo semaglutidom.</p>
<p>Po párovaní podľa propensity score vznikli dve veľké, porovnateľné skupiny:</p>
<ul>
  <li><strong>126 971 pacientov</strong> iniciujúcich tirzepatid,</li>
  <li><strong>126 971 pacientov</strong> iniciujúcich semaglutid.</li>
</ul>
<p>Pacienti, ktorí užívali oba lieky, boli z analýzy vylúčení. Sledované obdobie sa pohybovalo od 1 dňa do 5 rokov po začiatku liečby.</p>
<p>Autori hodnotili najmä:</p>
<ul>
  <li>celkovú mortalitu,</li>
  <li>gastroparézu,</li>
  <li>paralytický ileus alebo intestinálnu obštrukciu,</li>
  <li>aspiračnú pneumonitídu.</li>
</ul>

<h3>Nižšia celková mortalita pri tirzepatide</h3>
<p>Najvýraznejší rozdiel sa týkal celkovej mortality. V skupine s tirzepatidom bolo zaznamenaných <strong>1182 úmrtí</strong>, zatiaľ čo v skupine so semaglutidom <strong>1998 úmrtí</strong>.</p>
<p>V percentách to predstavovalo:</p>
<ul>
  <li><strong>0,9 % pri tirzepatide</strong>,</li>
  <li><strong>1,6 % pri semaglutide</strong>.</li>
</ul>
<p>Relatívne riziko bolo <strong>0,59</strong>, čo naznačuje približne <strong>41 % relatívne nižšie riziko celkovej mortality</strong> u pacientov liečených tirzepatidom v porovnaní so semaglutidom.</p>
<p>Treba však zdôrazniť, že ide o observačné údaje. Takýto typ analýzy vie ukázať asociáciu, nie definitívnu kauzalitu. Inými slovami, výsledok neznamená automaticky, že tirzepatid sám osebe „spôsobil" nižšiu mortalitu. Môžu sa uplatniť aj rozdiely v charakteristikách pacientov, predpisovacej praxi, dávkach, adherencii či dostupnosti zdravotnej starostlivosti.</p>

<h3>Menej ileu, črevnej obštrukcie a aspiračnej pneumonitídy</h3>
<p>Tirzepatid bol spojený aj s nižším rizikom niektorých gastrointestinálnych komplikácií.</p>
<p>Výskyt paralytického ileu alebo intestinálnej obštrukcie bol:</p>
<ul>
  <li><strong>0,9 % pri tirzepatide</strong>,</li>
  <li><strong>1,0 % pri semaglutide</strong>,</li>
</ul>
<p>s relatívnym rizikom <strong>0,84</strong>.</p>
<p>Aspiračná pneumonitída bola tiež menej častá pri tirzepatide:</p>
<ul>
  <li><strong>0,3 % pri tirzepatide</strong>,</li>
  <li><strong>0,4 % pri semaglutide</strong>,</li>
</ul>
<p>s relatívnym rizikom <strong>0,69</strong>.</p>
<p>Riziko gastroparézy bolo medzi skupinami podobné:</p>
<ul>
  <li><strong>1,0 % pri tirzepatide</strong>,</li>
  <li><strong>1,1 % pri semaglutide</strong>,</li>
</ul>
<p>s relatívnym rizikom <strong>0,95</strong>.</p>
<p>Tieto rozdiely sú numericky malé, ale pri veľmi veľkých populáciách môžu byť klinicky významné, najmä ak ide o pacientov s vyšším rizikom gastrointestinálnych komplikácií, aspiračných udalostí alebo perioperačných problémov.</p>

<h3>Prečo je to prekvapivé?</h3>
<p>Podľa hlavnej riešiteľky Aasmy Shaukat, MD, z NYU Langone Health v New Yorku bolo prekvapivé, že tirzepatid bol napriek duálnemu inkretínovému mechanizmu spojený s menším počtom nežiaducich udalostí.</p>
<p>Pri inkretínovej liečbe sa často diskutuje spomalenie vyprázdňovania žalúdka, nauzea, vracanie, gastroparéza a potenciálne aspiračné riziko pri anestézii alebo endoskopii. Dalo by sa preto očakávať, že silnejší alebo širší inkretínový efekt môže priniesť viac gastrointestinálnych problémov. Táto analýza však naznačuje opak, aspoň v sledovaných parametroch.</p>
<p>Autori posteru uviedli, že tirzepatid môže v rutinnej praxi ponúkať priaznivejší pomer benefitu a rizika, kombinujúci silnejšie metabolické účinky so zachovanou žalúdočnou motilitou a nižším aspiračným rizikom.</p>

<h3>Čo z toho vyplýva pre klinickú prax?</h3>
<p>Výsledky môžu podporiť preferenciu tirzepatidu u vhodných pacientov s diabetom 2. typu a obezitou, najmä ak je cieľom výrazná metabolická intervencia a zároveň minimalizácia niektorých gastrointestinálnych rizík.</p>
<p>Pre nefrologickú a internistickú prax je táto téma zaujímavá z viacerých dôvodov. Pacienti s diabetom 2. typu, obezitou, chronickou chorobou obličiek a vysokým kardiovaskulárnym rizikom často potrebujú liečbu, ktorá presahuje samotné zníženie HbA1c. Inkretínová terapia je čoraz viac vnímaná ako súčasť komplexnej kardiorenálno-metabolickej ochrany.</p>
<p>Pri výbere medzi semaglutidom a tirzepatidom však treba zohľadniť:</p>
<ul>
  <li>indikáciu liečby,</li>
  <li>dostupnosť a úhradu,</li>
  <li>renálnu funkciu,</li>
  <li>kardiovaskulárne riziko,</li>
  <li>telesnú hmotnosť a metabolické ciele,</li>
  <li>predchádzajúcu toleranciu liečby,</li>
  <li>gastrointestinálne príznaky,</li>
  <li>perioperačné alebo endoskopické riziko,</li>
  <li>pacientove preferencie a adherenciu.</li>
</ul>

<h3>Opatrnosť pri interpretácii</h3>
<p>Napriek veľkému počtu pacientov má štúdia dôležité limity. Ide o observačnú analýzu z databázy reálnej klinickej praxe, nie o randomizovanú kontrolovanú štúdiu. Aj po párovaní pacientov môže pretrvávať reziduálne skreslenie. Niektoré premenné môžu byť neúplne zachytené alebo nesprávne kódované. Dôležité môže byť aj dávkovanie, dĺžka liečby, adherencia a dôvod výberu konkrétneho lieku.</p>
<p>Samotní autori zdôraznili, že výsledky si vyžadujú potvrdenie v ďalších kohortách a v prospektívnych štúdiách. Plánujú tiež skúmať vzťah medzi dávkou a odpoveďou.</p>

<h3>Praktický záver</h3>
<p>Táto veľká globálna analýza naznačuje, že <strong>tirzepatid bol v reálnej praxi spojený s nižšou celkovou mortalitou, nižším rizikom ileu alebo črevnej obštrukcie a nižším výskytom aspiračnej pneumonitídy v porovnaní so semaglutidom</strong>. Riziko gastroparézy bolo medzi oboma liekmi podobné.</p>
<p>Tieto výsledky sú klinicky zaujímavé, ale zatiaľ by nemali viesť k zjednodušenému záveru, že tirzepatid je univerzálne lepšou voľbou pre každého pacienta. Skôr podporujú individualizovaný výber liečby, pri ktorom sa hodnotí nielen HbA1c a telesná hmotnosť, ale aj celkový kardiorenálno-metabolický profil, gastrointestinálna tolerancia a konkrétne riziká pacienta.</p>
<p><em>Zdroj: Spracované podľa Medscape Medical News: „Tirzepatid Tied to Less Mortality and AEs Than Semaglutide", 2026.</em></p>
HTML,
];

// ── Článok 2 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'GLP-1 agonisty pred operáciou: vysadiť alebo pokračovať?',
    'slug'         => 'glp-1-agonisty-pred-operaciou-vysadit-alebo-pokracovat',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-11',
    'is_top'       => 1,
    'excerpt'      => 'Moderné antidiabetiká a antiobezitiká zo skupiny agonistov GLP-1 receptorov priniesli výrazný pokrok v liečbe diabetu 2. typu, obezity aj kardiorenálnej ochrany. V perioperačnej medicíne však otvorili praktickú otázku: majú sa pred plánovaným výkonom vysadiť, alebo je bezpečnejšie v liečbe pokračovať?',
    'content'      => <<<'HTML'
<p><strong>Moderné antidiabetiká a antiobezitiká zo skupiny agonistov GLP-1 receptorov priniesli výrazný pokrok v liečbe diabetu 2. typu, obezity aj kardiorenálnej ochrany. V perioperačnej medicíne však otvorili praktickú otázku: majú sa pred plánovaným výkonom vysadiť, alebo je bezpečnejšie v liečbe pokračovať?</strong></p>
<p>Agonisty GLP-1 receptorov, medzi ktoré patria napríklad semaglutid, liraglutid, dulaglutid či tirzepatid s účinkom na inkretínový systém, znižujú glykémiu, tlmia chuť do jedla a podporujú redukciu hmotnosti. Ich účinok na tráviaci trakt však môže byť významný aj z pohľadu anestéziológie. Spomaľujú vyprázdňovanie žalúdka, čím môžu u niektorých pacientov zvyšovať objem reziduálneho žalúdočného obsahu pred anestéziou.</p>

<h3>Prečo je to dôležité pred operáciou?</h3>
<p>Pri celkovej anestézii je jednou z obáv aspirácia žalúdočného obsahu do dýchacích ciest. Ide síce o zriedkavú komplikáciu, no potenciálne závažnú. Práve preto sa pred operačnými výkonmi dodržiavajú pravidlá predoperačného hladovania.</p>
<p>Novšie údaje ukazujú, že pacienti liečení GLP-1 agonistami môžu mať vyšší reziduálny objem žalúdka. Tento efekt sa pozoruje pri krátkodobo aj dlhodobo pôsobiacich prípravkoch, pričom výraznejší môže byť pri dlhodobo pôsobiacich liekoch podávaných raz týždenne. Zaujímavé je, že spomalené vyprázdňovanie žalúdka môže pretrvávať aj viac ako 7 dní po prerušení liečby.</p>
<p>Riziko môže byť vyššie najmä:</p>
<ul>
  <li>pri vyšších dávkach,</li>
  <li>počas úvodnej titrácie dávky,</li>
  <li>u pacientov s gastrointestinálnymi príznakmi,</li>
  <li>pri diabetickej autonómnej neuropatii,</li>
  <li>pri súbežnom užívaní liekov spomaľujúcich motilitu tráviaceho traktu, napríklad opioidov.</li>
</ul>

<h3>Vyšší objem žalúdka neznamená automaticky vyššiu aspiráciu</h3>
<p>Kľúčový problém spočíva v tom, že vyšší reziduálny objem žalúdka síce bol opakovane popísaný, ale jednoznačný nárast klinicky potvrdených aspirácií sa zatiaľ nepreukázal.</p>
<p>Aspirácia pri modernej anestézii zostáva zriedkavá, s odhadovanou incidenciou približne 0,05 až 0,20 %. Viaceré metaanalýzy nepreukázali jasné zvýšenie rizika aspirácie u pacientov užívajúcich GLP-1 agonisty, hoci žalúdočný objem môže byť vyšší. Niektoré práce naznačujú možný nárast rizika, ale dôkazy sú zatiaľ limitované a metodicky rôznorodé.</p>

<h3>Má zmysel liečbu pred operáciou prerušiť?</h3>
<p>Staršie odporúčania navrhovali vysadiť denné prípravky približne 24 hodín pred výkonom a týždenné prípravky niekoľko dní pred operáciou. Tento prístup sa však v súčasnosti prehodnocuje.</p>
<p>Dostupné údaje totiž neukazujú jasný vzťah medzi dĺžkou prerušenia liečby a poklesom reziduálneho žalúdočného objemu. Stabilizácia vyprázdňovania žalúdka môže trvať niekoľko týždňov, nie iba niekoľko dní. Navyše neexistuje presvedčivý dôkaz, že krátkodobé vysadenie GLP-1 agonistu pred výkonom reálne znižuje výskyt aspirácie.</p>
<p>Na druhej strane vysadenie liečby môže mať svoje nevýhody:</p>
<ul>
  <li>zhoršenie glykemickej kontroly,</li>
  <li>potrebu úpravy antidiabetickej liečby,</li>
  <li>stratu časti kardiovaskulárneho a renálneho benefitu,</li>
  <li>vyššiu organizačnú záťaž pre pacienta aj lekára.</li>
</ul>
<p>Pre nefrologickú prax je tento aspekt mimoriadne dôležitý. Mnohí pacienti s diabetom 2. typu, chronickou chorobou obličiek, obezitou a vysokým kardiovaskulárnym rizikom môžu z GLP-1 liečby profitovať. Automatické vysadzovanie bez individuálneho posúdenia preto nemusí byť optimálne.</p>

<h3>Predlžovať hladovanie? Zatiaľ nie</h3>
<p>Aktuálne dôkazy nepodporujú rutinné predlžovanie predoperačného hladovania u pacientov užívajúcich GLP-1 agonisty. Dlhšie hladovanie nemusí zlepšiť vyprázdňovanie žalúdka a môže viesť k dehydratácii, nauzee, úzkosti a celkovému diskomfortu.</p>
<p>Štandardné pravidlá predoperačného hladovania by sa mali dodržiavať, pokiaľ nie je podozrenie na gastroparézu alebo iný klinicky významný problém s vyprázdňovaním žalúdka.</p>

<h3>Úloha ultrazvuku žalúdka</h3>
<p>Jedným z praktických riešení môže byť predoperačná ultrasonografia žalúdka. Ide o neinvazívne vyšetrenie, ktoré umožňuje zhodnotiť obsah žalúdka krátko pred výkonom. Ak je nález rizikový alebo nejasný, anestéziológ môže upraviť stratégiu, napríklad zvoliť rýchlu sekvenčnú indukciu, zvýšené aspiračné opatrenia alebo preferovať regionálnu anestéziu, ak je to vhodné.</p>

<h3>Súčasný trend: individuálne rozhodovanie</h3>
<p>Novšie odporúčania zdôrazňujú personalizovaný prístup. Francúzske odborné odporúčania z roku 2025, pripravené anestéziologickou a diabetologickou odbornou spoločnosťou, neodporúčajú rutinné vysadenie dlhodobo pôsobiacich GLP-1 agonistov do 7 dní pred operáciou u nízkorizikových pacientov.</p>
<p>Rozhodovanie by malo zohľadniť:</p>
<ul>
  <li>typ GLP-1 lieku a dávkovací režim,</li>
  <li>fázu liečby, najmä titráciu dávky,</li>
  <li>prítomnosť nauzey, vracania, pocitu plnosti alebo iných príznakov gastroparézy,</li>
  <li>diabetickú neuropatiu,</li>
  <li>obezitu a pridružené ochorenia,</li>
  <li>súbežnú liečbu ovplyvňujúcu motilitu tráviaceho traktu,</li>
  <li>typ výkonu a plánovaný spôsob anestézie.</li>
</ul>

<h3>Praktický záver</h3>
<p>GLP-1 agonisty pred operáciou nemožno posudzovať jednoduchým pravidlom „vysadiť všetkým" alebo „pokračovať u všetkých". Dôkazy naznačujú zvýšený reziduálny žalúdočný objem, ale zatiaľ nepreukazujú jednoznačné zvýšenie výskytu aspirácie. Krátkodobé prerušenie liečby nemusí spoľahlivo odstrániť riziko, no môže zhoršiť metabolickú stabilitu pacienta.</p>
<p>Najrozumnejším prístupom je individuálne zhodnotenie rizika v spolupráci anestéziológa, diabetológa, internistu, prípadne nefrológa. U nízkorizikových pacientov môže byť pokračovanie v liečbe primerané. U pacientov s príznakmi gastroparézy, počas titrácie dávky alebo pri ďalších rizikových faktoroch je vhodné zvážiť špecifické anestéziologické opatrenia, prípadne ultrazvukové posúdenie žalúdka.</p>
<p><em>Zdroj: Spracované podľa Medscape, článok „GLP-1 Drugs and Surgery: Stop or Continue?", 2026.</em></p>
HTML,
];

// ── Článok 3 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => '10 najčastejších chýb pri predpisovaní SGLT2 inhibítorov a GLP-1 agonistov',
    'slug'         => '10-najcastejsich-chyb-pri-predpisovani-sglt2-inhibitorov-a-glp-1-agonistov',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-11',
    'is_top'       => 1,
    'excerpt'      => 'SGLT2 inhibítory a agonisty GLP-1 receptorov zásadne zmenili liečbu diabetu 2. typu, obezity, chronickej choroby obličiek aj srdcového zlyhávania. Ich význam dnes ďaleko presahuje samotné znižovanie glykémie. Pri nesprávnom používaní však môžeme pacienta pripraviť o časť kardiorenálneho benefitu alebo ho vystaviť zbytočnému riziku.',
    'content'      => <<<'HTML'
<p><strong>SGLT2 inhibítory a agonisty GLP-1 receptorov zásadne zmenili liečbu diabetu 2. typu, obezity, chronickej choroby obličiek aj srdcového zlyhávania. Ich význam dnes ďaleko presahuje samotné znižovanie glykémie. Pri nesprávnom používaní však môžeme pacienta pripraviť o časť kardiorenálneho benefitu alebo ho vystaviť zbytočnému riziku.</strong></p>
<p>Moderná liečba diabetu 2. typu sa už nedá hodnotiť iba cez prizmu HbA1c. SGLT2 inhibítory a GLP-1 agonisty priniesli nový terapeutický jazyk: ochranu obličiek, srdca, ciev a metabolického zdravia. Práve v bežnej ambulantnej praxi však vznikajú opakovateľné chyby. Niektoré vedú k predčasnému vysadeniu účinnej liečby, iné k podceneniu nežiaducich účinkov alebo kontraindikácií.</p>
<p>Nasledujúci prehľad zhŕňa desať prakticky dôležitých omylov, ktorým sa oplatí vyhnúť.</p>

<h3>1. Pozerať sa iba na HbA1c a ignorovať kardiorenálne indikácie</h3>
<p>Najväčšou chybou je vnímať SGLT2 inhibítory a GLP-1 agonisty výlučne ako antidiabetiká určené až do neskorších línií liečby. Súčasné odporúčania kladú dôraz na orgánovú ochranu.</p>
<p>SGLT2 inhibítory majú významné miesto pri chronickej chorobe obličiek a srdcovom zlyhávaní, často nezávisle od hodnoty HbA1c a dokonca aj nezávisle od prítomnosti diabetu. GLP-1 agonisty, napríklad semaglutid, znižujú riziko veľkých kardiovaskulárnych príhod a prinášajú priaznivé účinky aj na renálne a kardiálne parametre.</p>
<p>V praxi to znamená, že pri pacientovi s diabetom 2. typu, chronickou chorobou obličiek, albuminúriou, obezitou alebo srdcovým zlyhávaním sa nemáme pýtať iba: „Aký má HbA1c?" Rovnako dôležitá otázka znie: „Aké orgány potrebujeme chrániť?"</p>

<h3>2. Nesprávne interpretovať počiatočný pokles eGFR po nasadení SGLT2 inhibítora</h3>
<p>Po začatí liečby SGLT2 inhibítorom sa často objaví mierny prechodný pokles eGFR, typicky približne o 10 až 15 % oproti východiskovej hodnote. Nejde o prejav nefrotoxicity. Ide o očakávaný hemodynamický efekt v glomerule, ktorý súvisí s dlhodobou renálnou ochranou.</p>
<p>Chybou je automaticky vysadiť liek pri každom poklese eGFR. Pokles do 30 % počas prvých troch mesiacov liečby sa všeobecne považuje za akceptovateľný. Ak je však pokles väčší ako 30 %, alebo sa renálna funkcia ďalej zhoršuje, treba hľadať iné príčiny: hypovolémiu, hypotenziu, nadmernú diuretickú liečbu, užívanie nesteroidových antiflogistík alebo inú interkurentnú patológiu.</p>
<p>Pre nefrologickú prax je toto mimoriadne dôležité. Predčasné vysadenie SGLT2 inhibítora pre „kozmetický" pokles eGFR môže pacienta pripraviť o dlhodobú nefroprotekciu.</p>

<h3>3. Zle manažovať genitálne a močové nežiaduce účinky SGLT2 inhibítorov</h3>
<p>Najčastejším nežiaducim účinkom SGLT2 inhibítorov sú genitálne mykotické infekcie, najmä kandidózy. Môžu sa vyskytnúť až u približne 10 % pacientov, častejšie pri obezite alebo pri anamnéze mykotických infekcií.</p>
<p>Chybou je považovať každú mykotickú infekciu za dôvod na definitívne vysadenie liečby. Pacienta treba už pri začatí liečby poučiť o riziku, hygiene a potrebe včasnej liečby príznakov. Pri prvých prejavoch je vhodná lokálna antimykotická liečba, pri potrebe aj systémová liečba, často bez nutnosti prerušiť SGLT2 inhibítor.</p>
<p>Riziko infekcií močových ciest sa javí ako malé a týka sa najmä žien. Rutinná antibiotická profylaxia sa neodporúča.</p>

<h3>4. Podceniť euglykemickú ketoacidózu pri SGLT2 inhibítoroch</h3>
<p>Euglykemická ketoacidóza je zradná práve tým, že glykémia nemusí byť výrazne zvýšená. Môže sa objaviť aj pri relatívne nízkych hodnotách glukózy. Vyskytuje sa takmer výlučne u pacientov s diabetom, najmä pri nedostatočnej dávke inzulínu alebo pri záťažových situáciách.</p>
<p>Rizikovými faktormi sú:</p>
<ul>
  <li>dlhšie hladovanie,</li>
  <li>ketogénna alebo veľmi nízkosacharidová diéta,</li>
  <li>nadmerný príjem alkoholu,</li>
  <li>infekcia,</li>
  <li>operačný výkon,</li>
  <li>dehydratácia,</li>
  <li>nedostatočná inzulinizácia.</li>
</ul>
<p>Pacient musí poznať takzvané „sick day rules". Pri akútnom ochorení, vracaní, dehydratácii alebo výraznom obmedzení príjmu potravy má dočasne prerušiť SGLT2 inhibítor, zabezpečiť príjem tekutín a sacharidov a pri riziku monitorovať ketolátky.</p>
<p>Treba tiež pripomenúť, že SGLT2 inhibítory nie sú štandardne indikované pri diabete 1. typu.</p>

<h3>5. Nedostatočne riešiť perioperačné vysadenie SGLT2 inhibítorov</h3>
<p>Perioperačné obdobie je typickou situáciou, v ktorej môže vzniknúť euglykemická ketoacidóza. Preto sa SGLT2 inhibítory pred plánovaným operačným výkonom dočasne vysadzujú.</p>
<p>Praktické pravidlo je jednoduché: liečba sa má prerušiť 3 dni pred výkonom. Do tohto obdobia sa zahŕňa deň pred operáciou, deň operácie a deň po operácii. Liečbu možno obnoviť až vtedy, keď pacient normálne prijíma potravu a už nie je riziko dehydratácie.</p>
<p>Pri urgentných výkonoch je potrebná vyššia pozornosť k hydratácii, acidobázickej rovnováhe a ketolátkam.</p>

<h3>6. Rutinne vysadzovať GLP-1 agonisty pred operáciou</h3>
<p>Na rozdiel od SGLT2 inhibítorov nie je pri GLP-1 agonistoch potrebné rutinné vysadenie pred operáciou alebo endoskopiou. Hlavnou obavou je spomalené vyprázdňovanie žalúdka, ktoré môže zvýšiť riziko reziduálneho žalúdočného obsahu.</p>
<p>Väčšina pacientov však môže v liečbe pokračovať. Dočasné prerušenie má zmysel zvažovať individuálne, najmä pri:</p>
<ul>
  <li>známej gastroparéze,</li>
  <li>výraznej nauzee alebo vracaní,</li>
  <li>aktívnych gastrointestinálnych príznakoch,</li>
  <li>nedávnej eskalácii dávky.</li>
</ul>
<p>Ak existuje neistota, praktickým kompromisom môže byť číra tekutá diéta počas 24 hodín pred výkonom. Rozhodnutie by malo vzniknúť v spolupráci s anestéziológom a lekárom, ktorý liečbu indikuje.</p>

<h3>7. Ignorovať retinopatiu pri rýchlom poklese HbA1c po semaglutide</h3>
<p>Pri semaglutide bol v niektorých štúdiách pozorovaný mierny nárast komplikácií diabetickej retinopatie u pacientov s veľmi vysokým rizikom. Pravdepodobne nejde o priamu toxickú retinálnu reakciu, ale skôr o efekt rýchleho zlepšenia glykémie, podobne ako pri intenzifikácii inzulínovej liečby.</p>
<p>Rizikoví sú najmä pacienti s výrazne zle kontrolovaným diabetom a preproliferatívnou alebo proliferatívnou retinopatiou. Pred začatím liečby je vhodný skríning retinopatie, opatrná titrácia dávky a úzka oftalmologická kontrola.</p>

<h3>8. Kombinovať GLP-1 agonistu s DPP-4 inhibítorom</h3>
<p>Kombinácia GLP-1 agonistu a DPP-4 inhibítora neprináša významný dodatočný klinický benefit. Obe skupiny pôsobia cez inkretínový systém, ale GLP-1 agonisty majú výraznejší účinok.</p>
<p>Ak je indikovaný GLP-1 agonista, DPP-4 inhibítor sa má zvyčajne vysadiť. Ich kombinovanie zvyšuje náklady bez adekvátneho prínosu a veľké odporúčania ho všeobecne neodporúčajú.</p>

<h3>9. Neupraviť ostatnú antidiabetickú liečbu pri nasadení GLP-1 agonistu</h3>
<p>GLP-1 agonisty majú samy osebe nízke riziko hypoglykémie, pretože ich účinok je glukózovo závislý. Riziko sa však zvyšuje pri kombinácii s inzulínom, sulfonylureou alebo glinidmi.</p>
<p>Častou chybou je pridať GLP-1 agonistu bez úpravy existujúcej liečby. Rozumným prístupom môže byť zníženie dávky sulfonylurey alebo bazálneho inzulínu približne o 50 % pri začatí liečby, s následnou úpravou podľa domácich glykémií. Samozrejme, treba zohľadniť východiskovú kompenzáciu diabetu, renálnu funkciu, vek pacienta a riziko hypoglykémie.</p>

<h3>10. Prehliadnuť kontraindikácie a dôležité upozornenia pri GLP-1 agonistoch</h3>
<p>GLP-1 agonisty sú účinné lieky, ale nie sú vhodné pre každého pacienta. Semaglutid sa neodporúča počas gravidity. Ženy vo fertilnom veku majú počas liečby používať účinnú antikoncepciu a pri plánovaní gravidity sa má semaglutid vysadiť aspoň 2 mesiace pred počatím.</p>
<p>Absolútnou kontraindikáciou je osobná alebo rodinná anamnéza medulárneho karcinómu štítnej žľazy alebo syndrómu mnohopočetnej endokrinnej neoplázie typu 2.</p>
<p>Pri predpisovaní je preto potrebné cielene sa pýtať na relevantnú osobnú a rodinnú anamnézu, nie iba mechanicky pridať liek do chronickej medikácie.</p>

<h3>Praktický záver pre ambulanciu</h3>
<p>SGLT2 inhibítory a GLP-1 agonisty patria medzi najvýznamnejšie liekové skupiny modernej metabolickej, kardiologickej a nefrologickej medicíny. Ich správne používanie vyžaduje zmenu myslenia: od samotnej glykémie k orgánovej ochrane.</p>
<p>Pri SGLT2 inhibítoroch treba rátať s očakávaným úvodným poklesom eGFR, správne manažovať genitálne mykózy, myslieť na euglykemickú ketoacidózu a liek dočasne vysadiť pred operáciou alebo pri akútnom ochorení s rizikom dehydratácie.</p>
<p>Pri GLP-1 agonistoch je dôležité nevysadzovať ich automaticky pred výkonom, nekombinovať ich s DPP-4 inhibítormi, upraviť rizikovú antidiabetickú liečbu a nezabudnúť na retinopatiu, graviditu a kontraindikácie.</p>
<p>Dobre indikovaná a dobre vedená liečba týmito liekmi môže pacientom s diabetom 2. typu, chronickou chorobou obličiek, obezitou alebo srdcovým zlyhávaním priniesť výrazný kardiorenálny benefit. Rovnako však platí, že najväčší úžitok vzniká až vtedy, keď liek nepredpisujeme iba „podľa schémy", ale podľa konkrétneho pacienta.</p>
<p><em>Zdroj: Spracované podľa Medscape: „Avoid These 10 Mistakes When Prescribing SGLT2 Inhibitor and GLP-1 RA", 2026.</em></p>
HTML,
];

// ── Článok 4 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'IgA nefropatia: úloha APRIL v štvorzásahovom modeli patogenézy',
    'slug'         => 'iga-nefropatia-uloha-april-v-stvorzasahovom-modeli-patogeneze',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-11',
    'is_top'       => 0,
    'excerpt'      => 'IgA nefropatia patrí medzi najčastejšie primárne glomerulonefritídy na svete. V posledných rokoch sa pohľad na jej vznik a progresiu výrazne spresnil. Kľúčovým konceptom je štvorzásahový model patogenézy, v ktorom dôležitú úlohu zohráva cytokín APRIL.',
    'content'      => <<<'HTML'
<p>IgA nefropatia patrí medzi najčastejšie primárne glomerulonefritídy na svete. V posledných rokoch sa pohľad na jej vznik a progresiu výrazne spresnil. Kľúčovým konceptom je štvorzásahový model patogenézy, v ktorom dôležitú úlohu zohráva cytokín APRIL.</p>
<p>Ochorenie dnes nechápeme iba ako pasívne ukladanie IgA v mezangiu, ale ako komplexný imunologický proces: od poruchy slizničnej imunity, cez tvorbu abnormálneho IgA1 a autoprotilátok, až po vznik imunitných komplexov, zápal a poškodenie glomerulov.</p>

<h3>Čo je APRIL a prečo je dôležitý</h3>
<p>APRIL (A Proliferation-Inducing Ligand) je cytokín podporujúci prežívanie a diferenciáciu B buniek a plazmatických buniek. Pri IgA nefropatii je významný tým, že môže podporovať tvorbu IgA a najmä patologického galaktózovo deficitného IgA1 (Gd-IgA1), ktorý stojí na začiatku patogenetickej kaskády.</p>
<p>Z pohľadu kliniky ide o upstream mechanizmus. To znamená, že cielenie APRIL môže potenciálne zasiahnuť ochorenie vyššie v patogenetickom reťazci, nie iba tlmiť jeho neskoré dôsledky.</p>

<h3>Štvorzásahový model IgA nefropatie</h3>
<p>Patogenéza IgA nefropatie sa často vysvetľuje 4-hit modelom. V prvom kroku vzniká Gd-IgA1. V druhom kroku sa tvoria autoprotilátky proti tomuto abnormálnemu IgA1. V treťom kroku vznikajú cirkulujúce imunitné komplexy. V štvrtom kroku sa tieto komplexy ukladajú v mezangiu, aktivujú lokálny zápal, komplement a vedú k progresívnemu glomerulovému poškodeniu.</p>
<p>Klinickým dôsledkom sú hematúria, proteinúria, pokles eGFR a pri progresívnom priebehu aj chronická choroba obličiek až zlyhanie obličiek.</p>

<h3>Pacient za diagnózou: variabilita rizika</h3>
<p>IgA nefropatia má veľmi heterogénny priebeh. U časti pacientov je zachytená náhodne pri mikroskopickej hematúrii, iní prichádzajú s epizódami makroskopickej hematúrie po infekcii horných dýchacích ciest, ďalší už pri diagnóze majú významnú proteinúriu, hypertenziu alebo zníženú eGFR.</p>
<p>Preto je rozhodujúca stratifikácia rizika podľa proteinúrie, krvného tlaku, hodnoty a dynamiky eGFR, histologického nálezu a celkového klinického kontextu.</p>

<h3>Liečba: od nefroprotekcie k mechanistickému cielenému prístupu</h3>
<p>Základom zostáva optimalizovaná nefroprotekcia: kontrola krvného tlaku, blokáda RAAS pomocou ACE inhibítorov alebo sartanov, redukcia proteinúrie, režimové opatrenia a manažment komplikácií CKD.</p>
<p>Súčasne pribúdajú liečebné stratégie zamerané na konkrétne mechanizmy ochorenia vrátane osí APRIL/BAFF, komplementu, slizničnej tvorby IgA a endotelínovej cesty. Tento posun umožňuje individualizovanejšie rozhodovanie u pacientov s vyšším rizikom progresie.</p>

<h3>Praktické posolstvo pre nefrológa</h3>
<p>Moderný manažment IgA nefropatie stojí na troch pilieroch: presnej diagnostike (vrátane biopsie), dôslednej stratifikácii rizika a individualizovanej liečbe. APRIL zapadá do tohto rámca ako významný biologický faktor, ktorý môže udržiavať aktivitu ochorenia a predstavuje racionálny terapeutický cieľ.</p>
<p><em>Zdroj: ReachMD, program „Navigating IgA Nephropathy: Pathogenesis, The Role Of APRIL &amp; The 4-Hit Process, &amp; A Patient Case Study"</em></p>
HTML,
];

// ── Článok 5 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'IgA nefropatia v ére nových terapeutických možností: od podpornej liečby k cielenej terapii',
    'slug'         => 'iga-nefropatia-v-ere-novych-terapeutickych-moznosti',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-11',
    'is_top'       => 0,
    'excerpt'      => 'IgA nefropatia patrí medzi najčastejšie glomerulové ochorenia na svete. Napriek tomu, že je známa desaťročia, jej liečba prechádza jednou z najvýznamnejších zmien. Nové poznatky o patogenéze a nové lieky posúvajú klinickú prax od všeobecnej nefroprotekcie k cielenej terapii zasahujúcej konkrétne mechanizmy ochorenia.',
    'content'      => <<<'HTML'
<p>IgA nefropatia patrí medzi najčastejšie glomerulové ochorenia na svete. Napriek tomu, že je známa desaťročia, jej liečba prechádza jednou z najvýznamnejších zmien. Nové poznatky o patogenéze a nové lieky posúvajú klinickú prax od všeobecnej nefroprotekcie k cielenej terapii zasahujúcej konkrétne mechanizmy ochorenia.</p>
<p>Klinický priebeh je veľmi variabilný: od dlhodobo miernych foriem až po progresiu do chronickej choroby obličiek a terminálneho zlyhania. Typickým prejavom u mladších pacientov býva synfaryngitická makroskopická hematúria, u starších skôr mikroskopická hematúria s rôznym stupňom proteinúrie.</p>

<h3>Štvorzásahový model: prečo ochorenie progreduje</h3>
<p>Súčasné chápanie IgA nefropatie vychádza zo štvorzásahového modelu: tvorba galaktózovo deficitného IgA1, vznik autoprotilátok, tvorba imunitných komplexov a ich ukladanie v mezangiu glomerulov. Následne sa aktivuje zápal, komplement a procesy vedúce k postupnému poškodeniu obličkového tkaniva.</p>
<p>Práve tento patofyziologický rámec umožnil vývoj liekov, ktoré cielia slizničnú produkciu patologického IgA, B-bunkové signály, komplementové dráhy aj mechanizmy spojené s proteinúriou a fibrózou.</p>

<h3>Proteinúria ako hlavný terapeutický cieľ</h3>
<p>Nové odporúčania KDIGO kladú dôraz na prísnejšie ciele proteinúrie. U pacientov s rizikom progresie má byť cieľom znížiť proteinúriu aspoň pod <strong>0,5 g/deň</strong>, ideálne pod <strong>0,3 g/deň</strong>. Tento cieľ má praktický význam, pretože proteinúria je dôležitý marker aktivity ochorenia aj prediktor budúceho poklesu renálnej funkcie.</p>

<h3>Základ zostáva rovnaký: kvalitná nefroprotekcia</h3>
<p>Podporná liečba zostáva základom manažmentu IgA nefropatie a má byť optimalizovaná včas. Kľúčové sú najmä ACE inhibítory alebo sartany, dôsledná kontrola krvného tlaku, inhibítory SGLT2 u vhodných pacientov, režimové opatrenia a systematické znižovanie proteinúrie.</p>
<p>Dáta zo štúdií DAPA-CKD a EMPA-KIDNEY podporujú nefroprotektívny účinok SGLT2 inhibítorov aj pri proteinurických fenotypoch vrátane IgA nefropatie.</p>

<h3>Nové cielené možnosti liečby</h3>
<p>Medzi dôležité novinky patria antagonisty endotelínového receptora. <strong>Sparsentan</strong> ako duálny antagonista angiotenzínového a endotelínového receptora viedol v štúdii PROTECT k výraznejšiemu poklesu proteinúrie než irbesartan. <strong>Atrasentan</strong> (štúdia ALIGN) priniesol významné zníženie proteinúrie oproti placebu, pri liečbe je však potrebné sledovať najmä retenciu tekutín.</p>
<p><strong>Cielený budezonid</strong> využíva črevno-obličkovú os a uvoľňuje sa v distálnom ileu, kde pôsobí na Peyerove plaky. Štúdia NefIgArd ukázala zníženie proteinúrie a priaznivejší vývoj eGFR v porovnaní s placebom.</p>
<p><strong>Iptakopan</strong>, inhibítor faktora B alternatívnej komplementovej dráhy, v štúdii APPLAUSE-IgAN významne znížil proteinúriu. Pri tejto liečbe je dôležitá prevencia infekcií opuzdrenými baktériami vrátane adekvátneho očkovania.</p>
<p>Významnú pozornosť pútajú aj lieky cieliace APRIL/BAFF osi. <strong>Sibeprenlimab</strong> (anti-APRIL protilátka) podľa dostupných údajov vedie k významnému poklesu proteinúrie. Ďalšie molekuly, ako atacicept alebo povetacicept, sú vo vývoji.</p>

<h3>Individualizácia rozhodovania v praxi</h3>
<p>Moderná liečba IgA nefropatie si vyžaduje individualizáciu podľa výšky proteinúrie, dynamiky eGFR, krvného tlaku, histologického nálezu, veku, komorbidít, rizika nežiaducich účinkov, plánovania tehotenstva, dostupnosti liečby a preferencií pacienta.</p>
<p>Diagnóza ostáva postavená na renálnej biopsii a prognostickom hodnotení (vrátane MEST-C), pričom výber liečby nemá byť mechanický, ale klinicky cielený.</p>

<h3>Záver</h3>
<p>IgA nefropatia vstupuje do novej terapeutickej éry. Podporná liečba zostáva nevyhnutným základom, no už nie je jedinou možnosťou. Kombinácia nefroprotekcie a cielenej imunomodulácie umožňuje presnejší zásah do biologického podkladu ochorenia a otvára priestor pre lepšie dlhodobé renálne výsledky.</p>
<p><em>Zdroj: odborné zhrnutie aktuálnych terapeutických trendov v IgA nefropatii, vrátane odporúčaní KDIGO a dát zo štúdií PROTECT, ALIGN, NefIgArd, APPLAUSE-IgAN, DAPA-CKD a EMPA-KIDNEY</em></p>
HTML,
];

// ── Článok 6 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Konzervatívnejšia dialyzačná stratégia pri AKI môže podporiť obnovu funkcie obličiek',
    'slug'         => 'konzervativnejsia-dialyzacna-strategia-pri-aki',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-11',
    'is_top'       => 0,
    'excerpt'      => 'Nová randomizovaná klinická štúdia publikovaná v časopise JAMA naznačuje, že u hospitalizovaných pacientov s akútnym poškodením obličiek (AKI), ktorí vyžadujú dialýzu, môže byť konzervatívnejší prístup k dialýze spojený s častejšou obnovou funkcie obličiek pri prepustení z nemocnice.',
    'content'      => <<<'HTML'
<p>Nová randomizovaná klinická štúdia publikovaná v časopise <em>JAMA</em> naznačuje, že u hospitalizovaných pacientov s akútnym poškodením obličiek (AKI), ktorí vyžadujú dialýzu, môže byť konzervatívnejší prístup k dialýze spojený s častejšou obnovou funkcie obličiek pri prepustení z nemocnice.</p>
<p>V praxi sa často rieši otázka, ako intenzívne a ako často dialyzovať pacienta v období, keď ešte existuje šanca na regeneráciu vlastnej renálnej funkcie. Tieto dáta prinášajú dôležitý pohľad: dialýza podávaná pri jasných metabolických alebo klinických indikáciách môže byť u vybraných pacientov výhodnejšia než rutinné plánované dialyzovanie trikrát týždenne.</p>

<h3>Čo štúdia sledovala</h3>
<p>Multicentrická randomizovaná klinická štúdia porovnávala dve stratégie u hospitalizovaných dospelých pacientov s AKI vyžadujúcim dialýzu. Konzervatívna stratégia znamenala vykonanie dialýzy iba pri splnení konkrétnych metabolických alebo klinických kritérií. Konvenčná stratégia využívala pravidelnú dialýzu trikrát týždenne až do splnenia kritérií obnovy diurézy alebo klírensu kreatinínu.</p>
<p>Do štúdie bolo zaradených 221 pacientov v štyroch centrách v USA, pričom intervenciu dostalo 220 účastníkov. Priemerný vek bol 56 rokov, približne dve tretiny tvorili muži a priemerná východisková eGFR dosiahla 64,8 ml/min/1,73 m². Randomizácia prebehla mediánovo 9 dní po začatí náhrady funkcie obličiek.</p>

<h3>Hlavný výsledok: obnova funkcie obličiek</h3>
<p>Primárnym ukazovateľom bola obnova funkcie obličiek pri prepustení z nemocnice, definovaná ako stav, keď bol pacient nažive, bez potreby dialýzy a mal minimálne 14 po sebe nasledujúcich dní bez dialýzy (vrátane obdobia po prepustení).</p>
<ul>
  <li><strong>64 % pacientov</strong> v konzervatívnej skupine dosiahlo obnovu funkcie obličiek.</li>
  <li><strong>50 % pacientov</strong> v konvenčnej skupine dosiahlo obnovu funkcie obličiek.</li>
</ul>
<p>Absolútny rozdiel bol 13,8 %. V neupravenej analýze bol rozdiel štatisticky významný, no v predšpecifikovanej upravenej analýze sa štatistická významnosť nepotvrdila. Veľkosť účinku preto zostáva neistá a vyžaduje potvrdenie vo väčších štúdiách.</p>

<h3>Menej dialýz a viac dní bez dialýzy</h3>
<p>Konzervatívny prístup bol spojený s nižším počtom dialyzačných procedúr: mediánovo <strong>1,8 dialýzy týždenne</strong> oproti <strong>3,1 dialýzy týždenne</strong> v konvenčnej skupine.</p>
<p>Výrazný rozdiel sa ukázal aj v počte dní bez dialýzy do 28. dňa: konzervatívna skupina mala medián <strong>21 po sebe nasledujúcich dní bez dialýzy</strong>, zatiaľ čo konvenčná skupina iba <strong>5 dní</strong>.</p>

<h3>Menej epizód intradialytickej hypotenzie</h3>
<p>Dôležitým klinickým zistením bol nižší výskyt hypotenzie spojenej s dialýzou: v konzervatívnej skupine bolo zaznamenaných 69 príhod oproti 97 príhodám v konvenčnej skupine.</p>
<p>Hypotenzia počas dialýzy môže zhoršovať perfúziu obličiek a potenciálne negatívne ovplyvniť ich regeneráciu. Aj preto je primeraná intenzita dialyzačnej liečby pri AKI klinicky zásadná.</p>

<h3>Čo z toho vyplýva pre klinickú prax</h3>
<p>U hemodynamicky stabilných pacientov s dialyzačne liečeným AKI nemusí byť automatické pokračovanie v pravidelnej dialýze trikrát týždenne vždy optimálnou stratégiou. Konzervatívnejší, indikačne cielený prístup môže byť spojený s vyšším podielom obnovy funkcie obličiek v neupravenej analýze, menším počtom dialýz, väčším počtom dní bez dialýzy a nižším výskytom hypotenzie.</p>
<p>Zároveň však treba výsledky interpretovať opatrne, keďže upravená analýza hlavného výsledku nedosiahla štatistickú významnosť.</p>
<p><em>Zdroj: ReachMD, podľa randomizovanej klinickej štúdie publikovanej v JAMA</em></p>
HTML,
];

// ── Článok 7 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Znižovanie krvného tlaku u pacientov s chronickým ochorením obličiek: metaanalýza',
    'slug'         => 'znizovanie-krvneho-tlaku-u-pacientov-s-ckd-metaanalaza',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-08',
    'is_top'       => 0,
    'excerpt'      => 'V apríli 2026 časopis The Lancet publikoval individuálnu metaanalýzu dát (individual-participant data meta-analysis), ktorá skúmala, či znižovanie krvného tlaku prináša rovnaký kardiovaskulárny prínos pacientom s chronickým ochorením obličiek (CKD) aj pacientom bez CKD. Ide o doteraz najrozsiahlejšiu analýzu tohto typu.',
    'content'      => <<<'HTML'
<p>V apríli 2026 časopis <em>The Lancet</em> publikoval individuálnu metaanalýzu dát (individual-participant data meta-analysis), ktorá skúmala, či znižovanie krvného tlaku prináša rovnaký kardiovaskulárny prínos pacientom s chronickým ochorením obličiek (CKD) aj pacientom bez CKD. Ide o doteraz najrozsiahlejšiu analýzu tohto typu.</p>

<h3>Dizajn a populácia</h3>
<p>Vedci z Blood Pressure Lowering Treatment Trialists' Collaboration analyzovali údaje zo 46 randomizovaných štúdií zahŕňajúcich <strong>285 124 účastníkov</strong>. Z nich malo 20,7 % CKD a 30,2 % diabetes 2. typu. Medián sledovania bol 4,4 roka. Primárnym sledovaným ukazovateľom boli závažné kardiovaskulárne príhody (fatálna alebo nefatálna cievna mozgová príhoda, ischemická choroba srdca, hospitalizácia alebo úmrtie pre srdcové zlyhanie).</p>

<h3>Hlavné výsledky</h3>
<p><strong>Konzistentný prínos naprieč štádiami CKD</strong> – Každé zníženie systolického tlaku o 5 mm Hg bolo spojené s približne 9 – 10 % relatívnym znížením rizika závažných kardiovaskulárnych príhod. Tento efekt bol prakticky rovnaký u pacientov s CKD (HR 0,91; 95 % CI 0,87 – 0,94) aj bez CKD (HR 0,90; 95 % CI 0,88 – 0,93). Nezistila sa heterogenita účinku naprieč štádiami CKD vrátane štádií 4 – 5 ani podľa prítomnosti proteinúrie.</p>
<p><strong>Efekt aj pri nízkom východiskovom tlaku</strong> – Prínos pretrvával aj u pacientov s východiskovým tlakom pod 120/70 mm Hg, čo naznačuje, že neexistuje jasný „prah", pod ktorým by liečba strácala zmysel.</p>
<p><strong>Triedy liekov</strong> – Sieťová metaanalýza ukázala, že hlavné triedy antihypertenzív (ACE inhibítory, blokátory receptorov angiotenzínu, blokátory kalciových kanálov, diuretiká, betablokátory) mali podobný relatívny účinok voči placebu. Prínos teda nie je viazaný na konkrétnu triedu, ale na samotné zníženie tlaku.</p>
<p><strong>Výnimka – pacienti s CKD a diabetom</strong> – V rámci podskupiny CKD bol účinok liečby významne slabší u pacientov s diabetom (HR 0,96; 95 % CI 0,90 – 1,02) oproti pacientom s CKD bez diabetu (HR 0,88; 95 % CI 0,84 – 0,93). Interakcia bola štatisticky významná (p = 0,044). Tento signál vyžaduje ďalšie overenie.</p>

<h3>Čo to znamená v praxi?</h3>
<p>Zistenia podporujú <strong>univerzálne znižovanie kardiovaskulárneho rizika</strong> pomocou antihypertenzívnej liečby u pacientov s CKD – bez ohľadu na štádium ochorenia, východiskový tlak alebo triedu lieku. Výnimku môžu tvoriť pacienti s kombináciou CKD a diabetu, kde je prínos menej výrazný a rozhodovanie by malo byť individuálne.</p>
<p>Autori zdôrazňujú, že liečba by sa nemala odkladať ani u pacientov s pokročilým CKD (štádium 4 – 5), ktorí sú často z kardiovaskulárnych štúdií vylučovaní.</p>
<p><em>Zdroj: ReachMD / The Lancet, publikované v apríli 2026</em></p>
HTML,
];

// ── Článok 8 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Porovnávacia účinnosť liečby IgA nefropatie: sieťová metaanalýza',
    'slug'         => 'porovnavacia-ucinnost-liecby-iga-nefropatie-sietova-metaanalaza',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-05-08',
    'is_top'       => 0,
    'excerpt'      => 'V apríli 2026 bola publikovaná bayesovská sieťová metaanalýza, ktorá porovnala konvenčné imunosupresíva s novšími cielenými liekmi pri liečbe IgA nefropatie (IgAN) u dospelých. Vedci prehľadali databázy PubMed, Cochrane Library, Web of Science, Scopus a Embase od začiatku do marca 2025.',
    'content'      => <<<'HTML'
<p>V apríli 2026 bola publikovaná bayesovská sieťová metaanalýza, ktorá porovnala konvenčné imunosupresíva s novšími cielenými liekmi pri liečbe IgA nefropatie (IgAN) u dospelých. Vedci prehľadali databázy PubMed, Cochrane Library, Web of Science, Scopus a Embase od začiatku do marca 2025 a do analýzy zaradili 17 randomizovaných klinických štúdií.</p>

<h3>Aké lieky sa porovnávali?</h3>
<ul>
  <li>Metylprednizolón</li>
  <li>Mykofenolát mofetil</li>
  <li>Takrolimus</li>
  <li>Nefecon (budezonid s cieleným uvoľňovaním)</li>
  <li>Iptakopan</li>
  <li>Sibeprenlimab</li>
</ul>
<p>Všetky lieky sa porovnávali s placebom alebo štandardnou podpornou liečbou. Sledovali sa renálne funkcie (eGFR slope), proteinúria (pomer bielkovín a kreatínu v moči – UPCR) a závažné nežiaduce udalosti.</p>

<h3>Hlavné výsledky</h3>
<p><strong>Funkcia obličiek (eGFR slope)</strong> – Nefecon dosiahol najpriaznivejší bodový odhad a najvyššie SUCRA hodnotenie, čo naznačuje potenciálne priaznivý signál. 95 % intervaly dôveryhodnosti však zahŕňali nulový efekt, takže nemožno hovoriť o preukázanej nadradenosti.</p>
<p><strong>Proteinúria</strong> – Metylprednizolón viedol k najväčšiemu zníženiu pomeru bielkovín a kreatínu v moči (UPCR) v porovnaní s placebom. Aj iptakopan a sibeprenlimab boli spojené so znížením proteinúrie. Viaceré liečby teda vykázali prínos, no ich vzájomné postavenie zostáva neisté.</p>
<p><strong>Bezpečnosť</strong> – Porovnania závažných nežiaducich udalostí boli prevažne nepresvedčivé, keďže údajov bolo málo a intervaly neistoty široké. Iptakopan vykázal numericky nižší výskyt závažných nežiaducich udalostí, ale aj tento signál zostáva neistý.</p>
<p><strong>Podskupiny</strong> – Analýzy nepreukázali, že by bol účinok liečby výrazne ovplyvnený vstupnou funkciou obličiek (eGFR pod alebo nad 60 ml/min/1,73 m²).</p>

<h3>Čo to znamená v praxi?</h3>
<p>Autori zdôrazňujú, že ide o <strong>exploratívne zistenia</strong>, nie o dôkaz nadradenosti niektorej liečby. Sieť porovnaní bola riedka, režimy liečby heterogénne a sledovanie krátke. Na jednoznačné závery sú potrebné väčšie a dlhšie štúdie s priamym porovnávaním liekov a tvrdými renálnymi ukazovateľmi (napr. zlyhanie obličiek).</p>
<p>Napriek obmedzeniam môžu tieto signály pomôcť pri <strong>individualizovanom rozhodovaní</strong> o liečbe u konkrétnych pacientov s IgA nefropatiou.</p>
<p><em>Zdroj: ReachMD, zverejnené 24. apríla 2026</em></p>
HTML,
];

// ── Článok 9 ─────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Kardio-nefro-metabolická revolúcia beží na plné obrátky',
    'slug'         => 'kardio-nefro-metabolicka-revolucia',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-04-25',
    'is_top'       => 0,
    'excerpt'      => 'SGLT2 inhibítory (gliflozíny) už dnes vnímame ako absolútny štandard a základný kameň terapie. Skutočným zemetrasením posledných mesiacov však bola ofenzíva GLP-1 receptorových agonistov a ich rozšírenie na CKD.',
    'content'      => <<<'HTML'
<p>SGLT2 inhibítory (gliflozíny) už dnes vnímame ako absolútny štandard a základný kameň terapie. Skutočným zemetrasením posledných mesiacov však bola ofenzíva GLP-1 receptorových agonistov. Po prelomových dátach zo štúdie FLOW sa v rokoch 2025 a 2026 indikácie molekúl ako semaglutid oficiálne rozšírili priamo na spomalenie progresie chronického ochorenia obličiek (CKD). Keď tento prístup elegantne skombinujeme s nesteroidnými antagonistami mineralokortikoidových receptorov (ako je finerenón) a novými inhibítormi aldosterón syntázy, máme v rukách nefarmakologický a farmakologický arzenál, ktorý mení prirodzený priebeh diabetickej aj nediabetickej nefropatie.</p>
HTML,
];

// ── Článok 10 ────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Zlatý vek pre IgA nefropatiu a zriedkavé glomerulopatie',
    'slug'         => 'zlaty-vek-pre-iga-nefropatiu-a-zriedkave-glomerulopatie',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-04-25',
    'is_top'       => 0,
    'excerpt'      => 'Roky sme boli odkázaní na neselektívnu imunosupresiu kortikoidmi so všetkými jej devastačnými vedľajšími účinkami. Súčasnosť patrí precíznej medicíne a novým biologickým liekom.',
    'content'      => <<<'HTML'
<p>Roky sme boli odkázaní na neselektívnu imunosupresiu kortikoidmi so všetkými jej devastačnými vedľajšími účinkami. Súčasnosť patrí precíznej medicíne. V poslednom období sa schválili a do praxe zaviedli lieky zasahujúce priamo do patogenézy. Či už hovoríme o duálnych antagonistoch receptorov pre endotelín a angiotenzín (sparsentan), alebo o fascinujúcej biologickej liečbe. Modulácia komplementovej kaskády (napríklad iptakopan) a blokátory dráh APRIL/BAFF (sibeprenlimab) postupne menia prognózu pacientov s IgAN z fatálnej na chronicky manažovateľnú.</p>
HTML,
];

// ── Článok 11 ────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Inovácie v dialýze a manažmente anémie',
    'slug'         => 'inovacie-v-dialyze-a-manazmente-anemie',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-04-25',
    'is_top'       => 0,
    'excerpt'      => 'V oblasti dialýzy sú kľúčové najnovšie odporúčania z jari 2026 týkajúce sa inkrementálnej peritoneálnej dialýzy a nástup HIF-PH inhibítorov v liečbe anémie pri CKD.',
    'content'      => <<<'HTML'
<p>V oblasti dialýzy sú kľúčové najnovšie odporúčania z jari 2026 týkajúce sa inkrementálnej peritoneálnej dialýzy. Tento koncept naberá na obrovskej popularite, pretože je šetrnejší k pacientom, predlžuje zachovanie reziduálnej renálnej funkcie a zlepšuje kvalitu života. Čo sa týka anémie pri CKD, v praxi sa definitívne etablujú HIF-PH inhibítory (ako roxadustat či daprodustat). Princíp oklamania senzoru pre hypoxiu v tele bez nutnosti injekčného podávania erytropoézu stimulujúcich látok (ESA) je fyziologicky čistým riešením. Pre pacienta to znamená obrovský komfort perorálnej liečby a pre personál menej logistickej záťaže.</p>
HTML,
];

// ── Článok 12 ────────────────────────────────────────────────────────────────
$articles[] = [
    'title'        => 'Keď sa nefrológia stretne s kódom',
    'slug'         => 'ked-sa-nefrologia-stretne-s-kodom',
    'author'       => 'Dr. Ľubomír Polaščín',
    'published_at' => '2026-04-25',
    'is_top'       => 0,
    'excerpt'      => 'Nefrológia a dialýza generujú gigantické množstvo dát. Prediktívne modely a AI nástroje otvárajú fascinujúce možnosti pre lekárov, ktorí dokážu spojiť klinický úsudok s algoritmickým myslením.',
    'content'      => <<<'HTML'
<p>Nefrológia a dialýza generujú gigantické množstvo dát z laboratórnych výsledkov, monitorovania tlaku krvi, pulzu, parametrov ultrafiltrácie a mnohých ďalších. Dnes vidíme masívny nástup prediktívnych modelov, ktoré dokážu na základe zdanlivo nesúvisiacich premenných predpovedať trajektóriu poklesu eGFR alebo riziko intradialytickej hypotenzie.</p>
<p><strong>Programátori a lekári.</strong> Schopnosť spojiť prísny klinický úsudok lekára s algoritmickým myslením programátora je dnes neuveriteľne vzácna. S technologickým stackom (PHP, JS, Python, HTML, CSS) môže byť jeden v dokonalej pozícii nielen konzumovať medicínske vedomosti, ale rovno budovať vlastné nástroje a aplikácie. Môže vytvárať systémy na mieru pre svoje dialyzačné stredisko, ktoré budú analyzovať trendy pacientov a automatizovať administratívu.</p>
<p>Je fascinujúce sledovať, ako sa jazyk medicíny a jazyk kódu prelínajú do jedného zmysluplného celku. Aký je váš pohľad na integráciu týchto nových technológií alebo liekov priamo vo vašom stredisku? Vidíte už niektoré z týchto inovácií reálne rezonovať na oddelení alebo v praxi aj na Slovensku?</p>
HTML,
];

// ── Vkladanie do databázy ─────────────────────────────────────────────────────

$inserted = 0;
$skipped  = 0;
$errors   = [];

$stmt = $pdo->prepare(
    "INSERT IGNORE INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)"
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
        if ($stmt->rowCount() > 0) {
            $inserted++;
        } else {
            $skipped++; // slug už existuje
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '": ' . $e->getMessage();
        error_log('migrate_articles error: ' . $e->getMessage());
    }
}

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "Migrácia dokončená: $inserted/$total vložených, $skipped preskočených.\n";
    if (!empty($errors)) {
        foreach ($errors as $err) { echo "  CHYBA: $err\n"; }
    }
} else {
    // Webové zobrazenie – admin je overený hore
    $pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
    $pageTimeZone    = date('T') . ' (' . date_default_timezone_get() . ')';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Migrácia článkov – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <main class="container" style="padding-top:60px;padding-bottom:60px;">
    <div class="auth-container">
      <h2>Migrácia článkov</h2>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
          <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endif; ?>

      <div class="alert <?= $inserted > 0 ? 'alert-success' : 'alert-info' ?>">
        <p><strong>Výsledok:</strong> <?= $inserted ?> z <?= $total ?> článkov bolo vložených. <?= $skipped ?> preskočených (slug už existuje).</p>
      </div>

      <p><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a>
         &nbsp;
         <a href="admin_articles.php" class="btn-secondary-small">Správa článkov</a>
      </p>

      <p style="margin-top:30px;font-size:0.85rem;color:var(--text-secondary);">
        Tento súbor môžete po úspešnej migrácii odstrániť alebo nechať – je idempotentný (vkladá len chýbajúce záznamy).
      </p>
    </div>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
<?php
}
