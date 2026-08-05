<?php

/**
 * add_semaglutid-wernickeho-encefalopatia-deficit-tiaminu_article.php
 * Wernickeho encefalopatia pri liecbe semaglutidom - deficit tiaminu.
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
    'title'        => 'Semaglutid a Wernickeho encefalopatia: zriedkavá komplikácia rýchleho chudnutia',
    'slug'         => 'semaglutid-wernickeho-encefalopatia-deficit-tiaminu',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Šesť kazuistík a nezávislá analýza hlásení vo VigiBase upozorňujú na deficit tiamínu pri liečbe agonistami receptora GLP-1. Signál je zriedkavý, pri oneskorenej liečbe však nezvratný.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Publikované kazuistiky aj analýza spontánnych hlásení ukazujú na to isté miesto zlyhania: dlhodobé gastrointestinálne ťažkosti a rýchly úbytok hmotnosti počas liečby agonistom receptora GLP-1 môžu vyčerpať zásoby tiamínu. Semaglutid pritom podľa dostupných údajov nie je priamym neurotoxínom. Rozhoduje včasné rozpoznanie rizikovej situácie a bezodkladné parenterálne podanie tiamínu.</em></p>

<p>Semaglutid patrí medzi agonisty receptora pre glukagónu podobný peptid 1 (GLP-1 RA). Používa sa pri diabetes mellitus 2. typu a pri obezite. S rozširujúcim sa používaním sa dostávajú do popredia aj zriedkavé komplikácie, ktoré nemusia byť priamym toxickým účinkom lieku, ale môžu vzniknúť sekundárne — v dôsledku výrazného potlačenia apetítu, vracania, obmedzeného príjmu potravy a rýchleho poklesu telesnej hmotnosti.</p>

<p>Systematický prehľad publikovaný v júli 2026 identifikoval šesť kazuistík Wernickeho encefalopatie u pacientov liečených semaglutidom pre obezitu. Nezávisle od neho bola na kongrese AACE 2026 prezentovaná analýza spontánnych hlásení, ktorá pre túto dvojicu našla výrazný disproporcionálny signál. Ide o klinicky relevantné upozornenie, nie však o dôkaz, že semaglutid sám osebe priamo poškodzuje mozog.</p>

<h2>Čo je Wernickeho encefalopatia</h2>

<p>Wernickeho encefalopatia je akútny neurologický syndróm spôsobený nedostatkom tiamínu, teda vitamínu B<sub>1</sub>. Tiamín je vo forme tiamínpyrofosfátu nevyhnutným kofaktorom kľúčových enzýmov energetického metabolizmu (pyruvátdehydrogenáza, α-ketoglutarátdehydrogenáza, transketoláza). Mozog je pre svoju vysokú a málo flexibilnú metabolickú potrebu na jeho nedostatok mimoriadne citlivý.</p>

<p>Tradičnú klinickú triádu tvoria:</p>

<ul>
  <li>porucha vedomia alebo zmena psychického stavu,</li>
  <li>okohybné (okulomotorické) poruchy, najmä nystagmus alebo oftalmoparéza,</li>
  <li>ataxia.</li>
</ul>

<p>Kompletná triáda je však prítomná len u menšiny pacientov a čakanie na jej rozvinutie vedie k oneskoreniu liečby. Praktickejšie sú operacionalizované Caineove kritériá, ktoré na klinické podozrenie vyžadujú prítomnosť <strong>dvoch zo štyroch</strong> znakov: nutričný deficit, okohybná porucha, cerebelárna dysfunkcia a porucha psychického stavu alebo mierne postihnutie pamäti.</p>

<p>Neliečené ochorenie môže progredovať do kómy a smrti alebo prejsť do Korsakovovho syndrómu s pretrvávajúcou poruchou pamäti a konfabuláciami.</p>

<h2>Čo zistil systematický prehľad</h2>

<p>Janice Bidesie a Erik Oudman systematicky prehľadali databázy PubMed, Embase, CINAHL a Scopus podľa metodiky PRISMA. Zaradili kazuistiky pacientov, ktorým bol semaglutid predpísaný na liečbu obezity a u ktorých klinický obraz zodpovedal Wernickeho encefalopatii.</p>

<p>Identifikovaných bolo iba <strong>šesť prípadov</strong> — štyri ženy a dvaja muži. Priemerný vek bol 47,2 roka a semaglutid sa pred rozvojom encefalopatie užíval v priemere 4,9 mesiaca.</p>

<p>Neurologickému zhoršeniu predchádzali najmä:</p>

<ul>
  <li>nechutenstvo u piatich zo šiestich pacientov,</li>
  <li>slabosť u štyroch zo šiestich,</li>
  <li>vracanie u troch zo šiestich,</li>
  <li>zápcha u dvoch z piatich hodnotených pacientov,</li>
  <li>výrazné zníženie telesnej hmotnosti u všetkých.</li>
</ul>

<p>Pri neurologickej manifestácii sa zaznamenali:</p>

<ul>
  <li>zmeny psychického stavu u piatich zo šiestich pacientov,</li>
  <li>nystagmus u piatich zo šiestich,</li>
  <li>ataktická porucha chôdze u štyroch zo šiestich.</li>
</ul>

<p>Magnetickú rezonanciu absolvovalo päť pacientov a vo všetkých piatich prípadoch preukázala nález typický pre Wernickeho encefalopatiu.</p>

<p>Klinické výsledky boli nepriaznivé:</p>

<ul>
  <li>jeden pacient zomrel,</li>
  <li>jeden sa úplne zotavil,</li>
  <li>štyria mali pretrvávajúcu poruchu pamäti zodpovedajúcu Korsakovovmu syndrómu,</li>
  <li>u jedného z nich pretrvávala aj závažná porucha funkcie dolných končatín.</li>
</ul>

<h2>Nezávislý farmakovigilančný signál</h2>

<p>Kazuistický prehľad nezostal osamotený. Na kongrese American Association of Clinical Endocrinology v apríli 2026 bola prezentovaná analýza, ktorá spojila systematický prehľad publikovaných prípadov s hláseniami z databázy Svetovej zdravotníckej organizácie VigiBase. Okrem troch publikovaných klinických správ zahrnula <strong>18 hlásení z VigiBase</strong>.</p>

<p>Vypočítané pomery šancí hlásenia (reporting odds ratio, ROR) boli:</p>

<ul>
  <li>semaglutid 10,2 (95 % interval spoľahlivosti 5,8–17,9),</li>
  <li>tirzepatid 11,4 (95 % interval spoľahlivosti 2,8–45,8).</li>
</ul>

<p>Analýza opísala „trojitý zásah“ (<em>triple hit</em>): iatrogénnu gastroparézu, pretrvávajúce vracanie a rýchly úbytok hmotnosti rýchlosťou 3,5 až 13,3 kg mesačne — v jednom prípade 30 kg za 12 týždňov. Medián nástupu bol 3 až 6 mesiacov od začatia liečby alebo od zvýšenia dávky, čo dobre zodpovedá priemerným 4,9 mesiaca v prehľade kazuistík.</p>

<p>Tieto čísla treba čítať správne. ROR je mierou <strong>disproporcionality hlásení</strong>, nie incidencie ani relatívneho rizika. Databázy spontánnych hlásení nemajú menovateľa, trpia podhlásením aj mediálne podmieneným nadhlásením a nedokazujú kauzalitu. Zmysluplné je preto najmä porovnanie oboch liečiv navzájom: hodnota pre tirzepatid nie je nižšia než pre semaglutid, čo skôr podporuje mechanizmus <strong>spoločný pre celú triedu</strong> než účinok špecifický pre jednu molekulu. Široký interval spoľahlivosti pri tirzepatide zároveň pripomína, že ide o veľmi malé počty.</p>

<h2>Pravdepodobný mechanizmus</h2>

<p>Dostupné údaje nepodporujú predstavu, že semaglutid priamo toxicky poškodzuje mozog. Biologicky pravdepodobnejšia je nepriama kauzálna cesta:</p>

<p><strong>semaglutid → potlačenie apetítu a gastrointestinálne nežiaduce účinky → obmedzený príjem potravy a rýchle chudnutie → vyčerpanie zásob tiamínu → Wernickeho encefalopatia.</strong></p>

<p>Zásoby tiamínu v organizme sú malé — rádovo 25–30 mg — a pri výrazne zníženom príjme sa môžu vyčerpať v priebehu niekoľkých týždňov. Riziko zvyšuje pretrvávajúce vracanie, malnutrícia, malabsorpcia alebo iné ochorenie narúšajúce príjem a využitie živín.</p>

<p>Závažný nutričný deficit pritom môže vzniknúť aj u človeka s obezitou. Vysoký index telesnej hmotnosti nevylučuje nedostatok vitamínov ani stopových prvkov — a práve u týchto pacientov sa naň myslí najmenej.</p>

<h2>Asociácia nie je dôkazom príčinnej súvislosti</h2>

<p>Mediálne tvrdenie, že semaglutid je „spojený so zriedkavým ochorením mozgu“, treba interpretovať opatrne. Systematický prehľad zahŕňal iba šesť kazuistík a nemal kontrolnú skupinu.</p>

<p>Z týchto údajov nemožno spoľahlivo určiť:</p>

<ul>
  <li>incidenciu Wernickeho encefalopatie medzi používateľmi semaglutidu,</li>
  <li>relatívne riziko v porovnaní s neliečenými pacientmi,</li>
  <li>mieru, do akej sa na komplikácii podieľal samotný liek,</li>
  <li>rizikové faktory umožňujúce presnú predikciu,</li>
  <li>či je riziko špecifické pre semaglutid, alebo spoločné pre všetky situácie s dlhodobým vracaním a rýchlym chudnutím.</li>
</ul>

<p>Kazuistiky podliehajú publikačnému a selekčnému skresleniu: závažné a nezvyčajné prípady sa publikujú s väčšou pravdepodobnosťou než mierne alebo včas rozpoznané. Práve to vysvetľuje nápadný rozdiel vo výsledkoch — v publikovaných kazuistikách skončili štyria zo šiestich pacientov s Korsakovovým syndrómom, kým v analýze hlásení malo kognitívny deficit pri prepustení približne 20 % pacientov. Skutočná prognóza pri včasnej liečbe je teda pravdepodobne lepšia, než naznačuje samotný kazuistický prehľad.</p>

<p>U piatich zo šiestich pacientov boli navyše prítomné pridružené ochorenia a nie vždy bolo možné jednoznačne oddeliť účinky lieku, základného ochorenia, ďalšej farmakoterapie a nutričného deficitu.</p>

<p>Správny záver preto nie je, že semaglutid bežne spôsobuje Wernickeho encefalopatiu. Údaje predstavujú <strong>farmakovigilančný signál</strong>, ktorý si vyžaduje klinickú pozornosť a ďalší výskum s populačným menovateľom.</p>

<h2>Kedy treba na deficit tiamínu myslieť</h2>

<p>Zvýšenú pozornosť si zasluhuje pacient liečený agonistom receptora GLP-1, u ktorého sa objaví:</p>

<ul>
  <li>pretrvávajúce vracanie alebo výrazná nevoľnosť,</li>
  <li>dlhodobé nechutenstvo a minimálny príjem potravy,</li>
  <li>neprimerane rýchly pokles telesnej hmotnosti,</li>
  <li>celková slabosť alebo zhoršenie chôdze,</li>
  <li>nystagmus, diplopia alebo iná okohybná porucha,</li>
  <li>zmätenosť, apatia, porucha pozornosti alebo pamäti.</li>
</ul>

<p>Nešpecifická úvodná symptomatológia sa ľahko nesprávne pripíše dehydratácii, metabolickej encefalopatii, psychickému ochoreniu alebo bežným nežiaducim účinkom liečby. Osobitne zradné je, že sama liečba obezity poskytuje pohodlné vysvetlenie pre nechutenstvo aj chudnutie — teda presne pre tie príznaky, ktoré mali vzbudiť podozrenie.</p>

<h2>Diagnostika a liečba</h2>

<p>Wernickeho encefalopatia je predovšetkým klinická diagnóza. Normálna koncentrácia tiamínu v krvi ju nemusí spoľahlivo vylúčiť a výsledok laboratórneho vyšetrenia nesmie oddialiť liečbu. Ani normálny nález na magnetickej rezonancii diagnózu úplne nevylučuje — senzitivita MR je pri tomto ochorení nízka, hoci jej špecificita je vysoká.</p>

<p>Pri dôvodnom podozrení je indikované bezodkladné <strong>parenterálne podanie tiamínu</strong>, ideálne ešte pred podaním glukózy alebo súbežne s ňou; podanie sacharidov bez tiamínu môže deficit prehĺbiť a stav zhoršiť. Perorálny tiamín nemožno pri manifestnej encefalopatii považovať za rovnocennú úvodnú liečbu, pretože jeho absorpcia je saturovateľná a pri malabsorpcii aj vracaní neistá.</p>

<p>Medzi odbornými odporúčaniami nie je úplná zhoda o optimálnej dávke:</p>

<ul>
  <li><strong>EFNS 2010</strong> odporúča pri predpokladanej alebo manifestnej Wernickeho encefalopatii 200 mg tiamínu trikrát denne, prednostne intravenózne (odporúčanie úrovne C).</li>
  <li><strong>Novšie protokoly a práce autorov prehľadu</strong> používajú 500 mg intravenózne trikrát denne; v analýze hlásení sa uvádzajú vysoké dávky 500–1500 mg denne.</li>
</ul>

<p>Hranica menej ako 500 mg parenterálneho tiamínu v úvodnej dávke, ktorú autori prehľadu označili za suboptimálnu liečbu, teda nie je svojvoľná: vychádza z ich vlastného predchádzajúceho systematického prehľadu Wernickeho encefalopatie pri ochoreniach obličiek, kde dávka 500 mg trikrát denne často viedla k úplnému zotaveniu, zatiaľ čo Korsakovov syndróm sa vyskytol u pacientov liečených nízkymi dávkami. Nejde však o univerzálne prijatú dávkovaciu normu — liečba sa má riadiť miestnym protokolom a klinickou odpoveďou a v žiadnom prípade sa nesmie odkladať.</p>

<p>Hodnotiť a korigovať treba aj hypomagneziémiu: magnézium je kofaktorom premeny tiamínu na tiamínpyrofosfát, a pri jeho nedostatku môže byť odpoveď na substitúciu tiamínu neúplná. Myslieť treba aj na súčasný deficit ďalších vitamínov skupiny B a na riziko realimentačného (refeeding) syndrómu.</p>

<h2>Význam pre nefrologickú prax</h2>

<p>Agonisty receptora GLP-1 sa čoraz častejšie používajú aj u pacientov s chronickou chorobou obličiek vrátane pokročilých štádií a dialýzy. Pri ich sledovaní preto nestačí hodnotiť iba glykémiu, telesnú hmotnosť a toleranciu lieku.</p>

<p>Pretrvávajúce vracanie a výrazne obmedzený príjem môžu viesť súčasne k:</p>

<ul>
  <li>hypovolémii a zhoršeniu funkcie obličiek,</li>
  <li>poruchám elektrolytov,</li>
  <li>strate svalovej hmoty,</li>
  <li>nedostatku vitamínov vrátane tiamínu.</li>
</ul>

<p>Nefrologický pacient je pritom rizikovejší už východiskovo. Systematický prehľad Wernickeho encefalopatie pri akútnom aj chronickom ochorení obličiek identifikoval 46 publikovaných prípadov; typickými prodrómami boli nechutenstvo, vracanie, úbytok hmotnosti, bolesti brucha a hnačka — teda presne to spektrum ťažkostí, ktoré sa pri liečbe agonistom GLP-1 očakáva ako „bežný“ nežiaduci účinok.</p>

<p>Osobitne zraniteľní sú dialyzovaní pacienti. Tiamín je vodorozpustný vitamín s nízkou molekulovou hmotnosťou a minimálnou väzbou na bielkoviny, preto sa odstraňuje do dialyzátu. V kombinácii s nechutenstvom, diétnymi obmedzeniami a liečbou diuretikami vzniká reálne riziko deficitu aj bez akéhokoľvek lieku na chudnutie.</p>

<p>U pacienta s pokročilou chronickou chorobou obličiek sa zmätenosť ľahko automaticky pripíše urémii, elektrolytovej poruche, dialyzačnému dysekvilibračnému syndrómu alebo liekom. Wernickeho encefalopatia musí zostať v diferenciálnej diagnostike vždy, keď neurologickým príznakom predchádzalo vracanie, nechutenstvo alebo rýchle chudnutie. Podanie tiamínu je pritom lacné, bezpečné a nevyžaduje úpravu dávky podľa funkcie obličiek — pomer prínosu a rizika je preto pri dôvodnom podozrení jednoznačný.</p>

<h2>Praktické závery</h2>

<p>Semaglutid netreba na základe šiestich kazuistík považovať za priamo neurotoxický liek ani ho bezdôvodne vysadzovať u dobre tolerujúceho pacienta. Klinicky významné je niečo iné:</p>

<ol>
  <li><strong>Dlhodobé gastrointestinálne ťažkosti pri liečbe nemožno bagatelizovať.</strong> Pretrvávajúce vracanie nie je len otázkou komfortu.</li>
  <li><strong>Rýchly pokles hmotnosti nemusí byť vždy priaznivým výsledkom</strong>, najmä ak ho sprevádza minimálny príjem potravy a slabosť. Úbytok presahujúci približne 4 kg mesačne pri takmer nulovom príjme je varovný, nie úspešný.</li>
  <li><strong>Pri neurologických príznakoch treba na deficit tiamínu myslieť včas</strong> a použiť Caineove kritériá namiesto čakania na kompletnú triádu.</li>
  <li><strong>Pri dôvodnom podozrení sa parenterálny tiamín podáva ihneď</strong>, bez čakania na laboratórne alebo zobrazovacie potvrdenie a pred podaním glukózy.</li>
  <li><strong>Signál sa netýka len semaglutidu.</strong> Rovnaká pozornosť patrí tirzepatidu a ďalším liekom triedy, keďže mechanizmus je nutričný, nie molekulovo špecifický.</li>
  <li><strong>Potrebné sú populačné farmakovigilančné štúdie</strong> s menovateľom — kazuistiky ani analýzy spontánnych hlásení neumožňujú vyčísliť riziko ani dokázať kauzalitu.</li>
</ol>

<h2>Záver</h2>

<p>Dostupné údaje naznačujú možnosť Wernickeho encefalopatie pri liečbe semaglutidom, ak je liečba komplikovaná dlhodobým vracaním, závažným nechutenstvom, výrazne obmedzeným príjmom potravy a rýchlym chudnutím. Ide o zriedkavý, ale potenciálne smrteľný — a pritom plne liečiteľný — stav.</p>

<p>Najdôležitejším posolstvom nie je obava zo semaglutidu ako takého, ale včasné rozpoznanie rizikovej klinickej situácie. Oneskorené podanie tiamínu môže viesť k nezvratnému Korsakovovmu syndrómu alebo k smrti, zatiaľ čo empirická parenterálna liečba pri dôvodnom podozrení je lacná, bezpečná a časovo kritická.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=glp1-ischemicka-opticka-neuropatia-naion">GLP-1 a nearteritická ischemická optická neuropatia</a> — ďalší zriedkavý bezpečnostný signál triedy.</li>
  <li><a href="article.php?slug=farmakologicka-liecba-obezity-pokrocile-ckd-dialyza">Farmakologická liečba obezity pri pokročilej CKD a dialýze</a>.</li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid pri CKD v reálnej praxi</a>.</li>
</ul>

<hr>

<h2>Zdroje</h2>

<ol>
  <li><strong>Bidesie J, Oudman E.</strong> <em>Wernicke's Encephalopathy Following Semaglutide Treatment for Obesity: A Systematic PRISMA Review of Case-Based Evidence.</em> Obesity (Silver Spring). 2026 Jul 3 (online ahead of print). doi: 10.1002/oby.70256. <a href="https://pubmed.ncbi.nlm.nih.gov/42399213/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://doi.org/10.1002/oby.70256" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Oudman E, Wijnia JW, Severs D, Oey MJ, van Dam M, van Dorp M, Postma A.</strong> <em>Wernicke's Encephalopathy in Acute and Chronic Kidney Disease: A Systematic Review.</em> Journal of Renal Nutrition. 2024;34(2):105–114. doi: 10.1053/j.jrn.2023.10.003. <a href="https://pubmed.ncbi.nlm.nih.gov/37838073/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kadhem M.</strong> <em>Wernicke encephalopathy emerges as a possible safety signal in patients on GLP-1 receptor agonists</em> (systematický prehľad a analýza databázy VigiBase). Abstrakt prezentovaný na kongrese American Association of Clinical Endocrinology (AACE) 2026, 23. apríla 2026. <a href="https://www.ccjm.org/page/aace-2026/wernicke-encephalopathy" target="_blank" rel="noopener noreferrer">Cleveland Clinic Journal of Medicine</a>.</li>
  <li><strong>Galvin R, Bråthen G, Ivashynka A, Hillbom M, Tanasescu R, Leone MA; EFNS.</strong> <em>EFNS guidelines for diagnosis, therapy and prevention of Wernicke encephalopathy.</em> European Journal of Neurology. 2010;17(12):1408–1418. doi: 10.1111/j.1468-1331.2010.03153.x. <a href="https://pubmed.ncbi.nlm.nih.gov/20642790/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Caine D, Halliday GM, Kril JJ, Harper CG.</strong> <em>Operational criteria for the classification of chronic alcoholics: identification of Wernicke's encephalopathy.</em> Journal of Neurology, Neurosurgery &amp; Psychiatry. 1997;62(1):51–60. doi: 10.1136/jnnp.62.1.51. <a href="https://pubmed.ncbi.nlm.nih.gov/9010400/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Clase CM, Ki V, Holden RM.</strong> <em>Water-soluble vitamins in people with low glomerular filtration rate or on dialysis: a review.</em> Seminars in Dialysis. 2013;26(5):546–567. doi: 10.1111/sdi.12099. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4285924/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Medscape Medical News.</strong> <em>Semaglutide Linked to Rare Brain Illness.</em> 14. júla 2026. <a href="https://www.medscape.com/viewarticle/semaglutide-linked-rare-brain-illness-2026a1000npa" target="_blank" rel="noopener noreferrer">Medscape</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Hlavným spracovaným zdrojom je systematický prehľad Bidesieovej a Oudmana; jeho bibliografické údaje a kľúčové čísla (šesť prípadov, štyri ženy a dvaja muži, priemerný vek 47,2 roka, priemerné trvanie liečby 4,9 mesiaca, jedno úmrtie, štyria pacienti s Korsakovovým syndrómom, hranica &lt; 500 mg parenterálneho tiamínu) boli overené v PubMed a Europe PMC. Farmakovigilančné údaje pochádzajú z nezávislej analýzy prezentovanej na kongrese AACE 2026 — ide o konferenčný abstrakt, teda o predbežné údaje bez plnej recenzie. Nefrologická časť vychádza zo systematického prehľadu Wernickeho encefalopatie pri ochoreniach obličiek a z prehľadu vodorozpustných vitamínov pri dialýze. Podrobné frekvencie jednotlivých príznakov sú prevzaté z plného textu prehľadu v podobe, v akej ich referovala odborná tlač.</em></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_semaglutid-wernickeho-encefalopatia-deficit-tiaminu_article',
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
