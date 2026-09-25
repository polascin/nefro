<?php

/**
 * Odborny clanok: Amanita muscaria v produktoch typu "gummies" - toxikologia
 * a jej skutocny nefrologicky rozmer.
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vlozit alebo aktualizovat clanok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/article_publisher.php';

$articles = [];

$articles[] = [
    'title'        => 'Muchotrávka červená v produktoch typu „gummies“: toxikologické riziká a ich skutočný nefrologický rozmer',
    'slug'         => 'muchotravka-cervena-gummies-toxikologia-nefrologicky-rozmer',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Želé cukríky s muchotrávkou červenou často neobsahujú to, čo deklarujú. Najväčší publikovaný klinický súbor pritom pri Amanita muscaria nezaznamenal ani jedno akútne poškodenie obličiek.',
    'content'      => <<<'HTML'
<p><strong>Muchotrávka červená</strong> (<em>Amanita muscaria</em>, fly agaric) sa za posledné roky presunula z kapitol o otravách hubami do regálov s doplnkami výživy. Predáva sa ako želé cukríky („gummies“), prášky, tinktúry a kapsuly s prísľubom zmiernenia stresu, zlepšenia spánku alebo „mikrodávkovania“. Americký Úrad pre kontrolu potravín a liečiv (FDA) v roku 2024 dvakrát oficiálne zasiahol a Európsky úrad pre bezpečnosť potravín (EFSA) tému eviduje medzi vznikajúcimi rizikami.</p>

<p>Pre nefrológa je podstatné oddeliť dve otázky, ktoré sa v populárnych aj v niektorých odborných textoch zlievajú do jednej. Prvá: <em>poškodzuje muchotrávka červená obličky?</em> Odpoveď podľa dostupných údajov znie – <strong>typicky nie</strong>, a tvrdenia o opaku stoja na veľmi tenkom dôkazovom základe. Druhá, klinicky oveľa dôležitejšia: <em>čo v skutočnosti pacient požil, keď povie, že si dal „hubové cukríky“?</em> Tu je odpoveď znepokojivá, pretože laboratórne analýzy opakovane ukázali, že obsah balenia nezodpovedá etikete.</p>

<p>Tento text zhŕňa overené toxikologické údaje, koriguje niekoľko tvrdení, ktoré sa o téme šíria, a ponúka praktický rámec pre diferenciálnu diagnostiku akútneho poškodenia obličiek po požití húb.</p>

<h2>Účinné látky a ich mechanizmus</h2>

<p>FDA vo vedeckom memorande z 9. septembra 2024 označuje za hlavné farmakologicky účinné zložky s hlásenými psychotropnými účinkami <strong>muscimol</strong>, <strong>kyselinu ibotenovú</strong> a <strong>muskarín</strong>. Memorandum ich na jednom mieste spoločne nazýva izoxazolovými zlúčeninami; to je nepresné a samotný dokument to o niekoľko odsekov ďalej koriguje – muskarín je kvartérny amóniový alkaloid, nie izoxazol.</p>

<div class="table-responsive" role="region" aria-label="Prehľad účinných látok muchotrávky červenej" tabindex="0">
<table>
<thead>
<tr><th scope="col">Látka</th><th scope="col">Chemická trieda</th><th scope="col">Cieľ</th><th scope="col">Klinický korelát</th></tr>
</thead>
<tbody>
<tr><th scope="row">Muscimol</th><td>izoxazol, štruktúrny analóg GABA</td><td>potentný agonista receptorov GABA<sub>A</sub>, parciálny agonista GABA<sub>C</sub></td><td>útlm, somnolencia, ataxia, kóma</td></tr>
<tr><th scope="row">Kyselina ibotenová</th><td>izoxazol, analóg glutamátu</td><td>agonista ionotropných NMDA receptorov</td><td>excitácia, agitovanosť, myoklonus, halucinácie</td></tr>
<tr><th scope="row">Muskarín</th><td>kvartérny amóniový alkaloid</td><td>muskarínové acetylcholínové receptory</td><td>hnačka, potenie, <strong>mióza</strong>, bronchorea, bradykardia, slinenie</td></tr>
</tbody>
</table>
</div>

<p>Kyselina ibotenová sa <em>in vivo</em> spontánne dekarboxyluje na muscimol. Obe látky ľahko prechádzajú hematoencefalickou bariérou a v pokusoch na myšiach sa objavia v moči do jednej hodiny. Práve táto konverzia je jedným z dôvodov, prečo je klinický obraz premenlivý: pomer excitačnej a inhibičnej zložky sa mení v čase a medzi jedincami.</p>

<h3>Muskarín: opravená predstava</h3>

<p>Tvrdenie, že muskarín vysvetľuje autonómne prejavy otravy muchotrávkou červenou, treba podať presne. Napriek tomu, že huba dala látke meno, jej obsah je nízky – FDA uvádza približne 3 ppm (0,0003 %), čo je hodnota vychádzajúca z prác z 50. rokov minulého storočia. Klinicky významné množstvá muskarínu obsahujú iné rody, najmä <em>Inocybe</em> a <em>Clitocybe</em>.</p>

<p>Tento konsenzus však bol v roku 2025 spochybnený. Feeney a spol. analyzovali vzorky metódou HPLC-MS/MS a namerali koncentrácie muskarínu <strong>0,004 % až 0,043 %</strong>, teda rádovo 10- až 140-násobne vyššie než tradične uvádzaná hodnota, a doložili ich prieskumom u 53 osôb s cholinergnými príznakmi po požití huby. Praktický záver: obsah muskarínu nemožno považovať za zanedbateľný paušálne, ale ani za hlavný mechanizmus toxicity. Ak sú prítomné cholinergné prejavy, ide o <strong>miózu</strong>, nie mydriázu – tá patrí k opačnému, anticholinergnému obrazu.</p>

<h3>Obsah účinných látok kolíše o rády</h3>

<p>Tsujikawa a spol. namerali v klobúkoch muchotrávky červenej kyselinu ibotenovú v rozsahu pod 10 až 2 845 ppm a muscimol 46 až 1 052 ppm, pričom v hlúbiku boli hodnoty podstatne nižšie. Takýto rozptyl znamená, že „jedna huba“ ani „jeden cukrík“ nie sú použiteľnou jednotkou dávky.</p>

<h2>Klinický obraz: dva protichodné toxidrómy naraz</h2>

<p>Nástup príznakov sa konzistentne uvádza <strong>do 30 minút až 2 hodín</strong> po požití. Dominujú prejavy centrálneho nervového systému: dezorientácia, únava, zrakové a sluchové halucinácie, delírium. FDA uvádza, že v ťažkých prípadoch môže dôjsť ku kóme, kŕčom, útlmu dýchania a úmrtiu.</p>

<p>Charakteristickým znakom je <strong>striedanie útlmu a excitácie</strong> podľa toho, ktorá zložka práve prevláda. Obraz, ktorý sa v literatúre označuje ako panterínovo-muskarínový syndróm, svojimi hlavnými znakmi napodobňuje <strong>anticholinergný</strong> toxidróm – návaly, horúčka, rozšírené zrenice, vracanie, hnačka a halucinácie. Zároveň však boli u týchto otráv opísané aj cholinergné prejavy. Pre klinika z toho vyplýva zásadné upozornenie: <strong>pri tejto otrave neexistuje jednotný toxidróm</strong> a pokus zaradiť pacienta do jednej kategórie môže viesť k nesprávnemu manažmentu.</p>

<p>Priebeh nie je vždy krátky. V opísanom prípade sa 48-ročný muž prebral po desiatich hodinách plne orientovaný, po 18 hodinách sa stav opäť zhoršil a nasledovala paranoidná psychóza so zrakovými a sluchovými halucináciami trvajúca päť dní.</p>

<div class="table-responsive" role="region" aria-label="Retrospektívny súbor Oregonského toxikologického centra 2002 – 2016" tabindex="0">
<table>
<thead>
<tr><th scope="col">Ukazovateľ</th><th scope="col">Zistenie (34 prípadov, 2002 – 2016)</th></tr>
</thead>
<tbody>
<tr><th scope="row">Zloženie súboru</th><td>23× <em>A. muscaria</em>, 10× <em>A. pantherina</em>, 1× <em>A. aprica</em></td></tr>
<tr><th scope="row">Symptomatickí pacienti</th><td>25; u všetkých okrem jedného príznaky do 6 hodín</td></tr>
<tr><th scope="row">Intubácia</th><td>5 pacientov</td></tr>
<tr><th scope="row">Akútne poškodenie obličiek</th><td><strong>0 prípadov</strong></td></tr>
<tr><th scope="row">Kŕče, hypotenzia, hepatotoxicita</th><td><strong>0 prípadov</strong></td></tr>
<tr><th scope="row">Úmrtia</th><td><strong>0</strong></td></tr>
</tbody>
</table>
</div>

<p><em>A. pantherina</em> bola v tomto súbore symptomatickejšia než <em>A. muscaria</em> vo všetkých sledovaných doménach – gastrointestinálne príznaky 80 % oproti 35 %, útlm CNS 70 % oproti 35 %, excitácia CNS 70 % oproti 35 %.</p>

<h2>Nefrologická otázka: poškodzuje muchotrávka červená obličky?</h2>

<p>Práve v tomto bode sa opakovane objavuje nadhodnotenie rizika. Dostupné údaje hovoria nasledovné:</p>

<ul>
<li><strong>Najväčší publikovaný klinický súbor</strong> (34 prípadov za 14 rokov, Oregonské toxikologické centrum) <strong>nezaznamenal ani jedno akútne poškodenie obličiek</strong>.</li>
<li><strong>Vedecké memorandum FDA</strong>, ktoré prešlo 604 unikátnych publikácií, <strong>neuvádza obličkové poškodenie vôbec</strong> – ani medzi hlásenými účinkami, ani medzi kazuistikami. Citovať FDA ako zdroj tvrdenia o renálnej insuficiencii po <em>A. muscaria</em> je preto nepodložené.</li>
<li>V databáze PubMed <strong>nie je indexovaná ani jedna práca</strong> na dopyt „Amanita muscaria“ a „rhabdomyolysis“.</li>
<li>Jediný dohľadateľný doklad o súbežnom renálnom zlyhaní a rabdomyolýze je <strong>kongresový abstrakt</strong> (poster, CHEST 2020): 56-ročný muž po cielenom požití huby s hyperaktivitou prechádzajúcou do agresivity, útlmom dýchania, myoklonickými zášklbmi, renálnym zlyhaním a rabdomyolýzou. Ide o jednu kazuistiku vo forme neindexovaného abstraktu, teda o najnižšiu úroveň dôkazu.</li>
</ul>

<p>Z toho vyplýva korektná formulácia rizika: <strong>muchotrávka červená nie je nefrotoxická huba</strong>. Ak sa pri nej objaví akútne poškodenie obličiek, ide s najväčšou pravdepodobnosťou o <strong>sekundárny dej</strong> – dôsledok kritického stavu, hypoperfúzie, respiračného zlyhania, dlhého bezvedomia s kompresiou svalov, výraznej agitovanosti alebo kŕčov s následnou rabdomyolýzou. Nie o priamu tubulotoxicitu.</p>

<p>Praktický dôsledok je však opačný, než by sa zdalo: práve preto, že primárna nefrotoxicita chýba, <strong>každé akútne poškodenie obličiek po požití húb treba považovať za signál, že v hre je iný druh huby alebo iná látka</strong>, kým sa nepreukáže opak.</p>

<h2>Druhovo špecifická nefrotoxicita: podľa čoho sa orientovať</h2>

<p>Rod <em>Amanita</em> nie je toxikologicky homogénny. Rozhodujúcim rozlišovacím znakom pri lôžku je <strong>latencia medzi požitím a nástupom príznakov</strong>.</p>

<div class="table-responsive" role="region" aria-label="Diferenciálna diagnostika syndrómov po požití húb podľa latencie" tabindex="0">
<table>
<thead>
<tr><th scope="col">Huba / toxín</th><th scope="col">Latencia</th><th scope="col">Cieľový orgán</th><th scope="col">Poznámka</th></tr>
</thead>
<tbody>
<tr><th scope="row"><em>A. muscaria</em>, <em>A. pantherina</em><br>(muscimol, kyselina ibotenová)</th><td>30 min – 2 h</td><td>CNS</td><td>obličky typicky nepostihnuté; AKI len ako komplikácia kritického stavu</td></tr>
<tr><th scope="row"><em>A. smithiana</em>, <em>A. proxima</em>, <em>A. boudieri</em>, <em>A. gracilior</em>, <em>A. echinocephala</em></th><td>10 – 12 h<br>(nauzea, vracanie)</td><td>obličky + mierna hepatitída</td><td>ťažké, ale <strong>reverzibilné</strong> AKI; biopsia: akútna intersticiálna nefritída a tubulárna nekróza</td></tr>
<tr><th scope="row"><em>Cortinarius orellanus</em> / <em>C. rubellus</em><br>(orelanín)</th><td>1 – 2 týždne</td><td>obličky</td><td>ťažká intersticiálna nefritída, tubulárne poškodenie a fibróza; bez antidota, často <strong>ireverzibilné</strong></td></tr>
<tr><th scope="row"><em>Tricholoma equestre</em></th><td>oneskorená</td><td>priečne pruhované svaly</td><td>rabdomyolýza so sekundárnym AKI</td></tr>
<tr><th scope="row"><em>A. phalloides</em> (amatoxíny)</th><td>6 – 12 h</td><td>pečeň</td><td>najčastejšia príčina fatálnych otráv hubami; obličky sekundárne</td></tr>
</tbody>
</table>
</div>

<p>Skupina nefrotoxických bielych muchotrávok si zaslúži osobitnú pozornosť, pretože je toxikologicky mladá. Kirchmair a spol. v roku 2012 opísali nemeckého a dvoch portugalských pacientov po požití celkom bielych muchotrávok s prsteňom: nauzea a vracanie 10 až 12 hodín po požití, ťažké akútne renálne zlyhanie a mierna hepatitída, biopsia s obrazom akútnej intersticiálnej nefritídy a tubulárnej nekrózy. Dvaja pacienti potrebovali dočasnú hemodialýzu a <strong>všetci plne obnovili funkciu obličiek</strong>. Autori následne testovali 20 druhov muchotrávok a toxín <em>A. smithiana</em> preukázali v druhoch <em>A. boudieri</em>, <em>A. gracilior</em> a <em>A. echinocephala</em>. Posledný menovaný je jediná nefrotoxická muchotrávka rastúca severne od Álp – teda druh relevantný aj pre stredoeurópsku prax.</p>

<p>Naopak pri orelanínovom syndróme je latencia 1 až 2 týždne a pacient v medziobdobí buď nemá príznaky, alebo len mierne gastrointestinálne ťažkosti. Ak sa na anamnézu húb nespýtame cielene, spojitosť nám unikne.</p>

<h3>Aplikácie na určovanie húb nie sú bezpečnostná poistka</h3>

<p>Pri odbere anamnézy stojí za zmienku, že rastúci podiel pacientov sa spolieha na mobilné aplikácie s rozpoznávaním obrázkov. Austrálska práca porovnala tri populárne aplikácie na 78 vzorkách overených mykológom: úspešnosť určenia bola 35 až 49 % pre všetky vzorky a 30 až 44 % pre jedovaté huby, pričom <em>A. phalloides</em> bola nesprávne určená trikrát. Autori uzatvárajú, že tieto nástroje samy osebe nedokážu vylúčiť expozíciu potenciálne jedovatej hube.</p>

<h2>Prečo je „gummy“ iný problém než huba z lesa</h2>

<p>Tu sa klinický problém výrazne mení. Pri komerčných produktoch <strong>nie je hlavným rizikom deklarovaná látka, ale nedeklarovaná</strong>.</p>

<p>Correia a spol. v roku 2025 analyzovali osem produktov zakúpených v siedmich predajniach v Portlande metódou kvapalinovej chromatografie s hmotnostnou spektrometriou. Výsledok:</p>

<ul>
<li>v dvoch produktoch deklarujúcich extrakt <em>A. muscaria</em> <strong>nebola zistená ani kyselina ibotenová, ani muscimol</strong> – obsahovali psilocín a deriváty tryptamínu,</li>
<li>sedem z ôsmich produktov obsahovalo psilocín, šesť z nich 4-acetoxy-<em>N,N</em>-dimetyltryptamín,</li>
<li>jeden produkt deklarovaný ako „bez psilocybínu“ bol na psilocybín pozitívny,</li>
<li>ďalšia vzorka označená ako nootropikum obsahovala nedeklarovaný Δ<sup>9</sup>-tetrahydrokanabinol.</li>
</ul>

<p>Nejde o novú anomáliu. Už v roku 2006 japonská forenzná analýza produktov predávaných ako extrakty <em>A. muscaria</em> nezistila kyselinu ibotenovú ani muscimol nad hranicou stanovenia, zato v nich našla psychoaktívne tryptamíny (5-MeO-DIPT, 5-MeO-DMT), reverzibilné inhibítory monoaminooxidázy (harmín, harmalín) a <strong>tropánové alkaloidy – atropín a skopolamín</strong>.</p>

<h3>Prípad Diamond Shruumz</h3>

<p>Rozsah možných následkov ukázala epidémia otráv spojená s čokoládovými tyčinkami na „mikrodávkovanie“, ktorú v USA vyšetrovali CDC a FDA. V období január až október 2024 bolo v 34 štátoch hlásených <strong>180 prípadov</strong>, z toho:</p>

<ul>
<li>73 hospitalizácií,</li>
<li>38 prijatí na jednotku intenzívnej starostlivosti,</li>
<li>29 endotracheálnych intubácií,</li>
<li>2 úmrtia.</li>
</ul>

<p>Konzumácia práve týchto tyčiniek bola v porovnaní s inými hubovými čokoládovými výrobkami spojená s vyššou pravdepodobnosťou hospitalizácie (OR 3,29; 95 % IS 1,51 – 7,40), prijatia na JIS (OR 6,30; 95 % IS 2,17 – 22,6), kŕčov (OR 8,45; 95 % IS 3,00 – 27,9) aj intubácie (OR 8,04; 95 % IS 2,24 – 44,2), pričom riziko stúpalo s množstvom. Testovanie odhalilo muscimol, psilocín (látka I. zoznamu podľa amerického práva), kavalaktóny a ďalšie látky – ale <strong>len v niektorých testovaných produktoch, nie vo všetkých</strong>.</p>

<p>Toto je jadro problému. Pri pacientovi, ktorý požil komerčný „hubový“ výrobok, nemožno z etikety odvodiť ani látku, ani dávku. Rozumným východiskom je predpokladať <strong>zmesovú expozíciu neznámeho zloženia</strong>.</p>

<h2>Regulačný rámec</h2>

<p>FDA vydala k téme dva dokumenty. Vedecké memorandum z <strong>9. septembra 2024</strong> uzatvára, že použitie <em>A. muscaria</em>, jej extraktov a známych účinných zložiek (muscimol, kyselina ibotenová, muskarín) v potravinách <strong>nespĺňa kritériá všeobecného uznania bezpečnosti (GRAS)</strong>; údaje na preukázanie bezpečnosti konzumácie sú nedostatočné a dostupné informácie naznačujú, že takéto použitie môže byť škodlivé. Podľa Cramerovej klasifikácie patria všetky tri látky do triedy III, teda s vysokým toxikologickým potenciálom. Nadväzujúce upozornenie pre priemysel a spotrebiteľov z <strong>18. decembra 2024</strong> konštatuje, že ide o <strong>neschválené potravinové prídavné látky</strong>, a odporúča potravinám s týmito zložkami sa vyhýbať.</p>

<p>Situácia v Európe je regulačne rozdrobená. Prezentácia pre diskusnú skupinu EFSA pre vznikajúce riziká (StaDG-ER, Brusel, november 2023) opisuje, že po sprísnení pravidiel pre huby s obsahom psilocybínu vzrástol predaj a spotreba druhov rodu <em>Amanita</em>, pričom väčšina krajín ich použitie osobitne neupravuje. Trh s želé cukríkmi, práškami, tinktúrami a kapsulami s extraktmi <em>A. muscaria</em> tak rastie v podmienkach regulačnej medzery a bez klinických štúdií. Treba dodať, že ide o <strong>stanovisko zainteresovanej strany prednesené na pôde EFSA, nie o vedecké stanovisko úradu</strong>.</p>

<p>Pre slovenskú prax z toho vyplýva, že tieto produkty sú dostupné cez internetový predaj a pacient ich nemusí vnímať ako drogu ani ako liek, ale ako doplnok výživy.</p>

<h2>Praktický postup</h2>

<h3>1. Cielená anamnéza</h3>

<p>Pri pacientovi s neuropsychiatrickým obrazom, agitovanosťou, kŕčmi alebo nevysvetleným akútnym poškodením obličiek sa treba explicitne opýtať na:</p>

<ul>
<li>požitie „hubových“ cukríkov, čokolád, práškov, kapsúl alebo tinktúr vrátane produktov označených ako <em>Amanita muscaria</em>, fly agaric či muchotrávka,</li>
<li>zber a konzumáciu húb – vrátane období <strong>pred dvomi až troma týždňami</strong>, čo pokrýva latenciu orelanínového syndrómu,</li>
<li>presný čas medzi požitím a prvými príznakmi; latencia je najsilnejší diferenciálno-diagnostický údaj,</li>
<li>použitie aplikácie na určovanie húb (nespoľahlivý zdroj istoty),</li>
<li>zvyšky produktu, obal alebo zvyšky húb – ich uchovanie umožní laboratórnu identifikáciu.</li>
</ul>

<p>Užitočná je aj informácia, že <strong>tieto látky sa nezachytia bežným toxikologickým skríningom</strong>. Negatívny drogový skríning expozíciu nevylučuje.</p>

<h3>2. Laboratórne sledovanie</h3>

<p>Pri agitovanosti, kŕčoch, myoklonoch alebo dlhšom bezvedomí je namieste cielene hľadať rabdomyolýzu ako potenciálnu príčinu sekundárneho AKI:</p>

<ul>
<li>kreatínkináza vrátane dynamiky, myoglobín v moči,</li>
<li>kreatinín, urea, odhad glomerulárnej filtrácie v čase,</li>
<li>ionogram vrátane kália, fosforu a kalcia, acidobázická rovnováha,</li>
<li>pečeňové testy a koagulácia – oneskorená hepatopatia posúva diagnózu k amatoxínom,</li>
<li>bilancia tekutín a diuréza.</li>
</ul>

<h3>3. Liečba</h3>

<p>Špecifické antidotum pri otrave muchotrávkou červenou neexistuje; liečba je podporná a symptomatická. V publikovaných prípadoch sa použilo aktívne uhlie na zníženie absorpcie a pri výrazných cholinergných prejavoch atropín. Indikácia náhrady funkcie obličiek sa riadi <strong>štandardnými nefrologickými kritériami</strong> – refraktérna hyperkaliémia, ťažká metabolická acidóza, objemové preťaženie nereagujúce na liečbu, urémia so závažnými komplikáciami – nie samotným faktom expozície. Eliminačné metódy nie sú pri muscimole ani kyseline ibotenovej doložené ako účinný spôsob odstránenia toxínu.</p>

<h3>4. Kedy prehodnotiť diagnózu</h3>

<p>Ak po požití húb vznikne akútne poškodenie obličiek, má to viesť k aktívnemu prehodnoteniu pôvodnej domnienky:</p>

<ul>
<li>latencia 10 – 12 hodín s nauzeou a vracaním nasledovaná AKI a miernou hepatitídou → nefrotoxické biele muchotrávky,</li>
<li>latencia 1 – 2 týždne → orelanínový syndróm (<em>Cortinarius</em>); prognóza je horšia a poškodenie môže byť trvalé,</li>
<li>dominantná rabdomyolýza s oneskoreným nástupom → zvážiť <em>Tricholoma equestre</em>,</li>
<li>oneskorená hepatopatia → amatoxíny.</li>
</ul>

<p>Vo všetkých týchto scenároch je vhodná konzultácia s Národným toxikologickým informačným centrom a podľa možnosti mykologická identifikácia zvyškov.</p>

<h2>Záver</h2>

<p>Muchotrávka červená je neurotoxická, nie nefrotoxická huba. Najväčší publikovaný klinický súbor pri nej nezaznamenal akútne poškodenie obličiek a vedecké memorandum FDA obličkové postihnutie vôbec neuvádza. Ojedinelé hlásenia renálneho zlyhania majú povahu kongresového abstraktu a najpravdepodobnejšie odrážajú rabdomyolýzu alebo komplikácie kritického stavu, nie priamu tubulotoxicitu.</p>

<p>Skutočné riziko produktov typu „gummies“ leží inde: opakované laboratórne analýzy ukazujú, že deklarovaný obsah nezodpovedá skutočnému, a to obojsmerne – raz chýba ohlásená látka, inokedy je prítomná nedeklarovaná psychoaktívna zložka, tropánový alkaloid alebo látka podliehajúca kontrole. Epidémia s 180 prípadmi, 73 hospitalizáciami a dvoma úmrtiami ukazuje, aké následky to môže mať.</p>

<p>Pre nefrologickú prax z toho vyplýva jednoduchá heuristika: <strong>akútne poškodenie obličiek po požití húb spravidla znamená, že nejde o muchotrávku červenú</strong>. Kľúčovým údajom pri lôžku je latencia medzi požitím a prvými príznakmi – práve ona odlišuje prognosticky priaznivé reverzibilné poškodenie od orelanínového syndrómu s rizikom trvalého zlyhania obličiek.</p>

<p><small><em>Redakčné overenie k 25. septembru 2026: klinické a toxikologické údaje boli overené cez PubMed, vedecké memorandum FDA bolo skontrolované v úplnom texte primárneho dokumentu. Text nenahrádza konzultáciu s toxikologickým informačným centrom ani platné odporúčania pracoviska.</em></small></p>

<div class="pdf-keep-together"><hr><h2>Zdroje</h2><ol>
<li><small><em>U.S. Food and Drug Administration, Center for Food Safety and Applied Nutrition. Memorandum: Regulatory status and review of available information pertaining to Amanita muscaria: lack of general recognition of safety for its use in foods. 9. september 2024; <a href="https://www.fda.gov/media/184512/download" target="_blank" rel="noopener noreferrer">plný text (PDF)</a>.</em></small></li>
<li><small><em>U.S. Food and Drug Administration. FDA Alerts Industry and Consumers about the Use of Amanita Muscaria or its Constituents in Food. 18. december 2024; <a href="https://www.fda.gov/food/hfp-constituent-updates/fda-alerts-industry-and-consumers-about-use-amanita-muscaria-or-its-constituents-food" target="_blank" rel="noopener noreferrer">FDA</a>.</em></small></li>
<li><small><em>Moss MJ, Hendrickson RG. Toxicity of muscimol and ibotenic acid containing mushrooms reported to a regional poison control center from 2002–2016. Clin Toxicol (Phila). 2019;57(2):99–103. doi:10.1080/15563650.2018.1497169; <a href="https://pubmed.ncbi.nlm.nih.gov/30073844/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Correia MS, Gonzaga MJ, Temple C, Gerona RR. Quantitative analysis of recreational psychoactive mushroom gummies in Portland, Oregon. Clin Toxicol (Phila). 2025;63(4):261–266. doi:10.1080/15563650.2025.2450240; <a href="https://pubmed.ncbi.nlm.nih.gov/39977248/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Rumph JT, Winquist A, Troeschel AN, et al. Severe Illness Associated with Eating Mushroom-Containing Chocolate Products – United States, January–October 2024. MMWR Morb Mortal Wkly Rep. 2026;75(13):179–184. doi:10.15585/mmwr.mm7513a2; <a href="https://pubmed.ncbi.nlm.nih.gov/41955162/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Kirchmair M, Carrilho P, Pfab R, et al. Amanita poisonings resulting in acute, reversible renal failure: new cases, new toxic Amanita mushrooms. Nephrol Dial Transplant. 2012;27(4):1380–1386. doi:10.1093/ndt/gfr511; <a href="https://pubmed.ncbi.nlm.nih.gov/21965588/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Diaz JH. Nephrotoxic Mushroom Poisoning: Global Epidemiology, Clinical Manifestations, and Management. Wilderness Environ Med. 2021;32(4):537–544. doi:10.1016/j.wem.2021.09.002; <a href="https://pubmed.ncbi.nlm.nih.gov/34629291/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Dinis-Oliveira RJ, Soares M, Rocha-Pereira C, Carvalho F. Human and experimental toxicology of orellanine. Hum Exp Toxicol. 2016;35(9):1016–1029. doi:10.1177/0960327115613845; <a href="https://pubmed.ncbi.nlm.nih.gov/26553321/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Feeney K, Kababick J, Wise S. An Examination of Cholinergic Symptoms Produced by the Fly Agaric Mushroom Amanita muscaria (Agaricomycetes): Revisiting the Role of Muscarine. Int J Med Mushrooms. 2025;27(7):1–15. doi:10.1615/IntJMedMushrooms.2025058603; <a href="https://pubmed.ncbi.nlm.nih.gov/40228215/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Tsujikawa K, Mohri H, Kuwayama K, et al. Analysis of hallucinogenic constituents in Amanita mushrooms circulated in Japan. Forensic Sci Int. 2006;164(2–3):172–178. doi:10.1016/j.forsciint.2006.01.004; <a href="https://pubmed.ncbi.nlm.nih.gov/16464551/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Stoeva-Grigorova S, Yarabanova I, Radeva-Ilieva M, et al. Amanita muscaria Acute Toxicity: A Literature Review and Two Case Reports in Elderly Spouses Following Home Preparation. Toxins (Basel). 2025;17(12):570. doi:10.3390/toxins17120570; <a href="https://pubmed.ncbi.nlm.nih.gov/41441606/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Rampolli FI, Kamler P, Carnevale Carlino C, Bedussi F. The Deceptive Mushroom: Accidental Amanita muscaria Poisoning. Eur J Case Rep Intern Med. 2021;8(3):002212. doi:10.12890/2021_002212; <a href="https://pubmed.ncbi.nlm.nih.gov/33768066/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Brvar M, Možina M, Bunc M. Prolonged psychosis after Amanita muscaria ingestion. Wien Klin Wochenschr. 2006;118(9–10):294–297. doi:10.1007/s00508-006-0581-6; <a href="https://pubmed.ncbi.nlm.nih.gov/16810488/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Łukasik-Głębocka M, Druzdz A, Naskręt M. Klinické príznaky a okolnosti akútnych otráv muchotrávkou červenou (Amanita muscaria) a muchotrávkou tigrovanou (Amanita pantherina). Przegl Lek. 2011;68(8):449–452 (v poľštine); <a href="https://pubmed.ncbi.nlm.nih.gov/22010435/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Hodgson SE, McKenzie C, May TW, Greene SL. A comparison of the accuracy of mushroom identification applications using digital photographs. Clin Toxicol (Phila). 2023;61(3):166–172. doi:10.1080/15563650.2022.2162917; <a href="https://pubmed.ncbi.nlm.nih.gov/36794335/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></small></li>
<li><small><em>Vaze R, Ahluwalia A, Lenivy C, Zirlinger A, Coyle T. A Not So Fun-Gi: A Rare Case of Amanita Muscaria Mushroom Overdose. Chest. 2020;158(4 Suppl):A800 (kongresový abstrakt); <a href="https://journal.chestnet.org/article/S0012-3692(20)33041-5/fulltext" target="_blank" rel="noopener noreferrer">CHEST</a>.</em></small></li>
<li><small><em>Ishimbaeva R (Association of Veterinary Consultants). Risks associated with the increase in consumption of Amanita muscaria. Prezentácia pre EFSA Stakeholder Discussion Group on Emerging Risks, Brusel, 8. november 2023; <a href="https://www.efsa.europa.eu/sites/default/files/2024-01/4.3-risk-increase-consumption-amanita-muscaria.pdf" target="_blank" rel="noopener noreferrer">EFSA (PDF)</a>.</em></small></li>
</ol></div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_muchotravka-cervena-gummies-toxikologia-nefrologicky-rozmer_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\nMigrácia článku: {$articles[0]['title']}\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny): $skipped\n";
    echo "Zaradených do fronty avíz: $queuedTotal\n";
    foreach ($errors as $error) {
        echo "Chyba: $error\n";
    }
} else {
    echo '<p>Článok bol spracovaný: ' . htmlspecialchars($articles[0]['title']) . '.</p>';
}
