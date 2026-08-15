<?php
/**
 * Odborny clanok: infekcie krvneho rieciska pri hemodialyze - mikrobiologicke spektrum.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum_article.php"
 */

// Ochrana - len admin alebo CLI
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
    'title'        => 'Infekcie krvného riečiska pri hemodialýze: ich výskyt klesá, mikrobiologické spektrum sa však môže meniť',
    'slug'         => 'infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Pätnásťročná írska štúdia zaznamenala pokles podielu stafylokokových infekcií a relatívny vzostup gramnegatívnych paličiek. Najvýznamnejším modifikovateľným rizikom zostáva centrálny venózny katéter.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pätnásťročná írska štúdia zaznamenala pokles podielu stafylokokových infekcií a relatívny vzostup gramnegatívnych baktérií. Najvýznamnejším modifikovateľným rizikovým faktorom zostáva centrálny venózny katéter. Časová súvislosť s otvorením novej dialyzačnej jednotky je zaujímavá, ale sama osebe nedokazuje príčinný účinok.</em></p>

<h2>Prečo je téma dôležitá</h2>

<p>Infekcie krvného riečiska patria medzi najzávažnejšie komplikácie udržiavacej hemodialýzy. Môžu viesť k sepse, infekčnej endokarditíde, osteomyelitíde, septickej artritíde, strate cievneho prístupu, hospitalizácii a úmrtiu. Riziko je mimoriadne vysoké pri používaní centrálneho venózneho katétra.</p>

<p>Retrospektívna írska štúdia publikovaná v auguste 2026 v časopise <em>Journal of Nephrology</em> analyzovala infekcie krvného riečiska u pacientov liečených hemodialýzou v rokoch 2009 až 2023. Autori zaznamenali pokles infekcií a súčasne zmenu mikrobiologického spektra: stafylokoky tvorili postupne menší podiel, zatiaľ čo podiel gramnegatívnych paličiek sa zvýšil.</p>

<p>Výsledky podporujú význam komplexných protiepidemických opatrení. Neznamenajú však, že stafylokokové infekcie prestali byť dominantnou hrozbou všade alebo že otvorenie novej dialyzačnej jednotky samo osebe spôsobilo pokles infekcií.</p>

<h2>Čo skúmala írska štúdia</h2>

<p>Autorský kolektív z Beaumont Hospital v Dubline uskutočnil retrospektívnu longitudinálnu kohortovú štúdiu. Z elektronických zdravotných záznamov získal údaje o hemokultúrach, klinických charakteristikách a infekciách u pacientov liečených hemodialýzou počas 15 rokov.</p>

<p>Do analýzy bolo zahrnutých <strong>1 248 pacientov na hemodialýze</strong>, u ktorých sa vyskytlo <strong>522 epizód infekcie krvného riečiska</strong>.</p>

<p>Pozitívne hemokultúry boli rozdelené podľa mikroorganizmov. Výskyt infekcií sa vyjadroval ako počet epizód na 100 pacientorokov a porovnával sa v ročných intervaloch. Autori použili analýzu prerušovaného časového radu s pomermi incidencií, označovanými skratkou IRR, na hodnotenie súvislosti medzi tromi zmenami balíkov protiepidemických opatrení a vývojom infekcií.</p>

<p>Takýto dizajn je vhodnejší než jednoduché porovnanie obdobia pred intervenciou a po nej, pretože zohľadňuje existujúci časový trend. Stále však ide o observačnú štúdiu bez randomizovanej kontrolnej skupiny.</p>

<h2>Zmena mikrobiologického spektra</h2>

<div class="table-responsive" role="region" aria-label="Podiel pôvodcov infekcií krvného riečiska na začiatku a na konci sledovania" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina pôvodcov</th>
      <th scope="col">2009 až 2011</th>
      <th scope="col">2021 až 2023</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Stafylokoky (<em>Staphylococcus aureus</em> a koaguláza-negatívne stafylokoky)</td><td>60 %</td><td>34,8 %</td></tr>
    <tr><td>Gramnegatívne paličky</td><td>18,5 %</td><td>43,9 %</td></tr>
  </tbody>
</table>
</div>

<p>Na konci sledovania tak v skúmanej kohorte gramnegatívne paličky predstavovali väčší podiel infekcií krvného riečiska než stafylokoky. Autori to v závere označujú za posun od prevahy grampozitívnych k prevahe gramnegatívnych pôvodcov.</p>

<h3>Relatívny podiel nie je to isté ako absolútny výskyt</h3>

<p>Toto rozlíšenie je zásadné. Zvýšenie podielu gramnegatívnych infekcií nemusí znamenať, že ich absolútny počet alebo incidencia stúpli. Podiel môže narásť aj vtedy, keď:</p>

<ul>
  <li>stafylokokové infekcie klesajú rýchlejšie,</li>
  <li>gramnegatívne infekcie klesajú pomalšie,</li>
  <li>mení sa zloženie populácie,</li>
  <li>mení sa spôsob odberu a interpretácie hemokultúr,</li>
  <li>zlepší sa rozpoznávanie niektorých infekcií.</li>
</ul>

<p>Údaje o modelovanej zmene incidencie hovoria dokonca proti absolútnemu nárastu: pomer incidencií po otvorení novej jednotky bol pri gramnegatívnych infekciách 0,49, teda smerom nadol. Zverejnený abstrakt neuvádza úplný ročný vývoj absolútnej incidencie jednotlivých mikrobiologických skupín. Správna interpretácia preto znie, že sa <strong>zmenilo relatívne zastúpenie pôvodcov</strong>, nie že nastal absolútny nárast gramnegatívnych infekcií.</p>

<h2>Centrálny venózny katéter zostáva hlavným rizikom</h2>

<p>Prístup cez centrálny venózny katéter bol v štúdii spojený so zvýšeným rizikom infekcie krvného riečiska. Tento výsledok je v súlade s dlhodobými epidemiologickými údajmi a odbornými odporúčaniami.</p>

<p>Katéter vytvára niekoľko možných ciest infekcie:</p>

<ul>
  <li>migráciu mikroorganizmov z kože pozdĺž vonkajšieho povrchu katétra,</li>
  <li>kontamináciu koncoviek a lúmenu pri pripájaní,</li>
  <li>tvorbu intraluminálneho biofilmu,</li>
  <li>hematogénne osídlenie katétra z iného infekčného ložiska,</li>
  <li>kontamináciu infúznych alebo dialyzačných roztokov.</li>
</ul>

<p>Biofilm znižuje dostupnosť antibiotík, chráni mikroorganizmy pred imunitnou odpoveďou a podporuje pretrvávanie alebo recidívu bakteriémie.</p>

<h3>Poradie infekčného rizika cievnych prístupov</h3>

<p>Vo všeobecnosti platí, že najnižšie infekčné riziko má natívna arteriovenózna fistula, vyššie riziko arteriovenózny štep a najvyššie centrálny venózny katéter.</p>

<p>Fistula však nie je vhodná pre každého pacienta a stratégia „fistula za každú cenu“ nie je primeraná. Odporúčania KDOQI z roku 2019 posunuli dôraz od preferencie jedného typu prístupu k individuálnemu plánu cievneho prístupu, ktorý zohľadňuje očakávanú dĺžku liečby, cievnu anatómiu, srdcové zlyhávanie, funkčný stav, predchádzajúce zlyhania prístupov, prognózu a preferencie pacienta.</p>

<p>Najdôležitejším preventívnym cieľom je vyhnúť sa zbytočnému alebo neprimerane dlhému používaniu katétra.</p>

<h2>Ďalšie rizikové faktory v štúdii</h2>

<p>Mužské pohlavie bolo spojené so zvýšeným rizikom infekcie: pomer incidencií 1,43 pri P &lt; 0,001. To znamená približne o 43 % vyššiu incidenciu po zohľadnení premenných zahrnutých do modelu. Neznamená to, že mužské pohlavie je priamou biologickou príčinou infekcie. Výsledok môže ovplyvňovať typ cievneho prístupu, komorbidity, správanie, hospitalizácie alebo reziduálne konfundujúce faktory.</p>

<p>Autori uviedli aj súvislosť s vekom nad 34 rokov. Takto stanovená hranica má pri typickej hemodialyzačnej populácii, ktorej podstatná časť je staršia, obmedzenú klinickú užitočnosť. Bez podrobného vysvetlenia vekových kategórií, referenčnej skupiny a modelu nemožno tento výsledok presvedčivo interpretovať a nemá sa prenášať do klinického skríningu ako samostatná riziková hranica.</p>

<h2>Otvorenie novej dialyzačnej jednotky a pokles infekcií</h2>

<p>Najväčšia časová zmena infekcií nastala po otvorení novej dialyzačnej jednotky.</p>

<div class="table-responsive" role="region" aria-label="Zmena incidencie infekcií po otvorení novej dialyzačnej jednotky" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Skupina pôvodcov</th>
      <th scope="col">Pomer incidencií</th>
      <th scope="col">Hodnota P</th>
      <th scope="col">Približné relatívne zníženie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td><em>Staphylococcus aureus</em></td><td>0,42</td><td>&lt; 0,001</td><td>asi 58 %</td></tr>
    <tr><td>Gramnegatívne paličky</td><td>0,49</td><td>0,048</td><td>asi 51 %</td></tr>
  </tbody>
</table>
</div>

<p>Úplná interpretácia vyžaduje vedieť, či model odhadoval okamžitú zmenu úrovne incidencie, zmenu časového trendu alebo kombináciu oboch. Výsledok pri gramnegatívnych baktériách bol tesne pod hranicou konvenčnej štatistickej významnosti, a je preto podstatne menej robustný než výsledok pre <em>S. aureus</em>.</p>

<h3>Prečo nová jednotka mohla pomôcť</h3>

<p>Nové priestory mohli priniesť lepšie rozostupy medzi dialyzačnými miestami, vhodnejšie usporiadanie čistých a kontaminovaných zón, dostupnejšie miesta na hygienu rúk, lepší tok pacientov, personálu a materiálu, viac priestoru na aseptickú manipuláciu, modernizáciu zariadení, lepšie izolačné možnosti, súčasné preškolenie personálu aj dôslednejší audit a spätnú väzbu.</p>

<p>Nie je však možné určiť, ktorá z týchto zmien bola rozhodujúca.</p>

<h3>Prečo nemožno hovoriť o dokázanej kauzalite</h3>

<p>Počas pätnástich rokov sa mohli súčasne meniť podiel pacientov s katétrom, vek a komorbidity pacientov, personálne obsadenie, postupy starostlivosti o katéter, kožná antisepsa, používanie antimikrobiálnych mastí alebo uzáverov, mikrobiologická diagnostika, antibiotická politika, epidemiológia nemocničných mikroorganizmov, podiel hospitalizovaných a ambulantných pacientov, očkovanie aj celková organizácia starostlivosti.</p>

<p>Otvorenie novej jednotky preto mohlo byť skôr markerom širšej organizačnej zmeny než jej príčinou. Časová následnosť hypotézu o účinku podporuje, ale nedokazuje ju. Samotní autori v závere hovoria o „časovej asociácii“, nie o preukázanom účinku.</p>

<h2>Prečo môžu gramnegatívne infekcie nadobúdať väčší význam</h2>

<p>Gramnegatívne bakteriémie môžu pochádzať z močových ciest, gastrointestinálneho a hepatobiliárneho systému, respiračného traktu, diabetickej alebo ischemickej rany, katétra, kontaminovaného zdravotníckeho prostredia, vody alebo vlhkého rezervoára, prípadne z dialyzačnej techniky a roztokov pri porušení bezpečnostných postupov.</p>

<p>Gramnegatívne baktérie dobre prežívajú vo vlhkom prostredí. Rizikové môžu byť umývadlá, odtoky, mokré pracovné plochy a nesprávne umiestnené čisté pomôcky. Samotný vyšší podiel gramnegatívnych infekcií však nepreukazuje kontamináciu vody ani dialyzačnej techniky.</p>

<p>Takéto podozrenie je opodstatnené najmä pri:</p>

<ul>
  <li>časovom alebo priestorovom zoskupení prípadov,</li>
  <li>výskyte rovnakého neobvyklého mikroorganizmu,</li>
  <li>infekciách u pacientov dialyzovaných na rovnakých miestach,</li>
  <li>mikrobiologickej podobnosti izolátov,</li>
  <li>prekročení mikrobiologických limitov vody alebo dialyzátu.</li>
</ul>

<p>Pri podozrení na ohnisko je potrebná spolupráca nefrológa, klinického mikrobiológa, epidemiológa, infektológa a technického tímu. Molekulárna typizácia môže odlíšiť spoločný zdroj od náhodného zoskupenia nesúvisiacich infekcií.</p>

<h2>Nie všetky pozitívne hemokultúry znamenajú to isté</h2>

<p>Pojmy infekcia krvného riečiska, bakteriémia, infekcia súvisiaca s cievnym prístupom, katétrová infekcia a laboratórne potvrdená infekcia krvného riečiska nie sú úplne zameniteľné.</p>

<h3>Kontaminácia hemokultúry</h3>

<p>Koaguláza-negatívne stafylokoky sú častými pôvodcami katétrových infekcií, ale aj častými kontaminantmi hemokultúr. Interpretácia závisí od počtu pozitívnych fliaš a odberových súprav, času do pozitivity, prítomnosti rovnakého mikroorganizmu vo viacerých odberoch, klinických príznakov, prítomnosti katétra alebo iného implantátu a výsledkov kontrolných hemokultúr.</p>

<p>Príliš voľná definícia môže počet infekcií nadhodnotiť, príliš prísna môže prehliadnuť skutočnú katétrovú infekciu. Táto skutočnosť má význam aj pri porovnávaní dlhodobých trendov: zmena definície alebo laboratórnej metodiky sa v grafe prejaví podobne ako skutočná zmena epidemiológie.</p>

<h3>Katétrová infekcia verzus infekcia z iného zdroja</h3>

<p>U dialyzovaného pacienta s katétrom nemožno každú bakteriémiu automaticky označiť za katétrovú. Zdrojom môže byť pneumónia, infekcia močových ciest, cholangitída, ischemická rana alebo endokarditída.</p>

<p>Na druhej strane absencia lokálnych známok pri výstupe katétra nevylučuje intraluminálnu infekciu.</p>

<h2>Klinický postup pri podozrení na infekciu krvného riečiska</h2>

<h3>Hemokultúry</h3>

<p>Pred podaním antibiotík treba, ak to klinický stav umožňuje, odobrať primerané hemokultúry. U pacienta s dialyzačným katétrom sa podľa miestneho protokolu odoberajú vzorky z katétrových lúmenov, z periférnej žily, ak je odber možný a primeraný, prípadne z dialyzačného okruhu pri štandardizovanom postupe.</p>

<p>Periférna venepunkcia sa nemá vykonávať bez uváženia na končatine, ktorú treba chrániť pre budúci cievny prístup.</p>

<p>Pri sepse alebo hemodynamickej nestabilite sa antibiotická liečba nesmie neprimerane odkladať pre komplikovaný odber.</p>

<h3>Empirická antibiotická liečba</h3>

<p>Empirická liečba má spravidla pokrývať meticilín-rezistentný <em>Staphylococcus aureus</em> podľa miestnej epidemiológie a klinicky významné gramnegatívne baktérie vrátane <em>Pseudomonas aeruginosa</em>, ak to odôvodňuje závažnosť stavu a lokálny antibiogram.</p>

<p>Výber musí zohľadniť miestnu rezistenciu, predchádzajúce mikrobiologické nálezy, alergie, závažnosť infekcie, pravdepodobný zdroj, reziduálnu funkciu obličiek, dialyzačný režim a odstrániteľnosť lieku dialýzou.</p>

<p>Po identifikácii pôvodcu treba liečbu zúžiť. Dávka a čas podania musia byť prispôsobené hemodialýze. Bežné dávkovanie pre pacientov s normálnou funkciou obličiek môže viesť k toxicite, zatiaľ čo neprimerane nízka dávka zvyšuje riziko zlyhania liečby a rezistencie.</p>

<h3>Kontrola infekčného zdroja</h3>

<p>Samotné antibiotiká nemusia odstrániť infekciu biofilmu. Odstránenie katétra sa spravidla dôrazne zvažuje pri:</p>

<ul>
  <li>ťažkej sepse alebo septickom šoku,</li>
  <li>pretrvávajúcej bakteriémii napriek účinnej liečbe,</li>
  <li>tunelovej infekcii,</li>
  <li>infekčnej endokarditíde,</li>
  <li>septickej trombóze,</li>
  <li>metastatických infekčných ložiskách,</li>
  <li>infekcii spôsobenej <em>S. aureus</em>, <em>P. aeruginosa</em> alebo hubami.</li>
</ul>

<p>Definitívny postup závisí od mikroorganizmu, klinickej stability, možností nového cievneho prístupu a miestnych odporúčaní. Katétrový zámok s antibiotikom môže mať miesto vo vybraných nekomplikovaných prípadoch, nie je však náhradou odstránenia katétra pri vysoko rizikových infekciách.</p>

<h3>Bakteriémia spôsobená Staphylococcus aureus</h3>

<p>Pri <em>S. aureus</em> treba aktívne pátrať po infekčnej endokarditíde, osteomyelitíde a spondylodiscitíde, septickej artritíde, epidurálnom abscese, infekcii cievnej protézy a septických embolizáciách.</p>

<p>Potrebné sú kontrolné hemokultúry a podľa klinickej situácie echokardiografia. Trvanie liečby závisí od odstránenia zdroja, rýchlosti sterilizácie krvi a prítomnosti komplikácií.</p>

<h2>Základné prvky prevencie</h2>

<p>Účinný preventívny program netvorí jedno opatrenie, ale konzistentne vykonávaný balík postupov.</p>

<h3>1. Minimalizácia katétrov</h3>

<p>Každý pacient s katétrom má mať pravidelne prehodnotený plán definitívneho cievneho prístupu. Treba odstrániť administratívne oneskorenia pri cievnom vyšetrení, chirurgickom alebo intervenčnom výkone a dozrievaní prístupu.</p>

<h3>2. Hygiena rúk</h3>

<p>Hygiena rúk sa vyžaduje pred kontaktom s cievnym prístupom, po ňom, po odstránení rukavíc a pri prechode z kontaminovanej na čistú činnosť. Rukavice hygienu rúk nenahrádzajú.</p>

<h3>3. Aseptická manipulácia</h3>

<p>Kritické časti katétra, spojov a ihiel sa nesmú po dezinfekcii dotýkať nesterilným predmetom. Pripájanie a odpájanie katétra má vykonávať vyškolený personál podľa štandardizovaného postupu.</p>

<h3>4. Kožná antisepsa</h3>

<p>Pri zavádzaní katétra a starostlivosti o cievny prístup sa vo všeobecnosti preferuje alkoholový roztok chlórhexidínu, ak nie je kontraindikovaný. Treba dodržať správnu koncentráciu, mechanické čistenie a dostatočné zaschnutie. Výber alternatívy pri alergii alebo intolerancii má zodpovedať miestnemu protokolu.</p>

<h3>5. Dezinfekcia koncoviek katétra</h3>

<p>Koncovky sa musia pred každým pripojením dôkladne dezinfikovať a chrániť pred opätovnou kontamináciou. Účinnosť závisí od techniky, času kontaktu a dodržiavania postupu, nie iba od názvu dezinfekčného prípravku.</p>

<h3>6. Starostlivosť o výstup katétra</h3>

<p>Niektoré odporúčania podporujú lokálne antimikrobiálne prípravky na miesto výstupu katétra. Ich výber treba prispôsobiť dostupnosti, kompatibilite materiálu, alergiám a lokálnej rezistencii. Dlhodobé nekontrolované používanie antibiotických mastí môže podporovať selekciu rezistencie.</p>

<h3>7. Audit a spätná väzba</h3>

<p>Pravidelne sa má hodnotiť dodržiavanie hygieny rúk, technika pripájania katétra, starostlivosť o výstup, príprava a podávanie injekčných liekov, výskyt infekcií podľa cievneho prístupu aj mikrobiologické spektrum a rezistencia.</p>

<p>Samotné školenie bez pozorovania reálnej praxe a spätnej väzby má obmedzený účinok. Práve tento prvok je pravdepodobne najbližším vysvetlením írskych výsledkov: podobný účinok priniesol aj americký program spolupracujúcich dialyzačných stredísk, v ktorom kombinácia štandardizovaných postupov, sledovania a spätnej väzby viedla k poklesu infekcií krvného riečiska.</p>

<h3>8. Vzdelávanie pacientov</h3>

<p>Pacient má vedieť rozpoznať horúčku, zimnicu, bolesť, začervenanie, sekréciu, opuch a poruchu funkcie prístupu. Musí vedieť, komu a ako ich bezodkladne oznámiť.</p>

<h3>9. Bezpečná príprava liekov</h3>

<p>Parenterálne lieky sa majú pripravovať v čistej zóne oddelenej od použitých pomôcok, umývadiel a dialyzačných miest. Jednodávkové balenia sa nemajú používať pre viacerých pacientov.</p>

<h3>10. Starostlivosť o prostredie a vodný systém</h3>

<p>Pravidelná údržba, mikrobiologická kontrola vody a dialyzátu, správna dezinfekcia zariadení a vyšetrovanie neobvyklých zhlukov patria k základom bezpečnosti. Kultivácia prostredia bez epidemiologickej hypotézy však môže prinášať ťažko interpretovateľné výsledky.</p>

<h2>Antimikrobiálna rezistencia</h2>

<p>Zmena smerom ku gramnegatívnym pôvodcom môže mať význam pre empirickú liečbu, najmä pri výskyte enterobaktérií produkujúcich širokospektrálne betalaktamázy, karbapeném-rezistentných enterobaktérií, multirezistentnej <em>Pseudomonas aeruginosa</em> alebo druhov komplexu <em>Acinetobacter baumannii</em>.</p>

<p>Výsledky jednej írskej nemocnice však nemožno použiť na výber empirickej liečby na Slovensku. Rozhodujúci je lokálny antibiogram dialyzačného pracoviska alebo nemocnice.</p>

<p>Rozšírenie empirického gramnegatívneho krytia u každého pacienta bez následnej deeskalácie by mohlo zvýšiť rezistenciu a výskyt infekcie <em>Clostridioides difficile</em>. Mikrobiologický posun preto podporuje lokálny dohľad, nie automatické plošné používanie širokospektrálnych antibiotík.</p>

<h2>Metodologické zhodnotenie štúdie</h2>

<h3>Silné stránky</h3>

<ul>
  <li>pätnásťročné sledovanie,</li>
  <li>veľká kohorta 1 248 pacientov a 522 zachytených infekčných epizód,</li>
  <li>vyjadrenie incidencie na pacientoroky,</li>
  <li>mikrobiologické rozdelenie pôvodcov,</li>
  <li>použitie analýzy prerušovaného časového radu namiesto jednoduchého porovnania období,</li>
  <li>hodnotenie organizačných protiepidemických zmien,</li>
  <li>deklarovaná neprítomnosť komerčného financovania a konfliktov záujmov.</li>
</ul>

<h3>Obmedzenia</h3>

<ol>
  <li><strong>Retrospektívny dizajn.</strong> Výsledky závisia od kvality a úplnosti elektronických záznamov.</li>
  <li><strong>Jedno centrum.</strong> Mikrobiologické spektrum a organizačné podmienky nemusia byť prenosné na iné pracoviská.</li>
  <li><strong>Bez randomizácie.</strong> Nemožno spoľahlivo oddeliť účinok intervencií od súbežných časových zmien.</li>
  <li><strong>Možné zmeny definícií a diagnostiky.</strong> Počas 15 rokov sa mohli meniť kritériá infekcie, odber hemokultúr aj laboratórne metódy.</li>
  <li><strong>Nejasný vplyv cievneho prístupu.</strong> Bez podrobného vývoja podielu katétrov, fistúl a štepov nemožno určiť, do akej miery vysvetľuje pokles infekcií.</li>
  <li><strong>Zmena podielu nie je zmena incidencie.</strong> Relatívny vzostup gramnegatívnych baktérií nemožno označiť za absolútny nárast.</li>
  <li><strong>Možné opakované epizódy u tých istých pacientov.</strong> Z abstraktu nie je jasné, ako model zohľadnil vnútroindividuálnu koreláciu a recidívy.</li>
  <li><strong>Obmedzená interpretácia veku nad 34 rokov.</strong> Nezvyčajná hranica potrebuje vysvetlenie.</li>
  <li><strong>Viacero súbežných intervencií.</strong> Otvorenie novej jednotky mohlo byť spojené s personálnymi, technickými a organizačnými zmenami.</li>
  <li><strong>Hraničná štatistická významnosť pri gramnegatívnych infekciách.</strong> Hodnotu P = 0,048 treba interpretovať opatrne, najmä pri troch testovaných intervenciách a viacerých mikrobiologických skupinách, teda pri opakovanom testovaní.</li>
  <li><strong>Chýbajúce klinické výsledky v abstrakte.</strong> Nie sú uvedené údaje o mortalite, hospitalizáciách, endokarditíde, strate cievneho prístupu ani o rezistencii.</li>
</ol>

<h2>Časté omyly a ich uvedenie na správnu mieru</h2>

<div class="table-responsive" role="region" aria-label="Časté omyly pri interpretácii infekcií krvného riečiska na hemodialýze" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Centrálny venózny katéter zvyšuje infekčné riziko</td><td>Jednoznačne potvrdené</td><td>Najvýznamnejší modifikovateľný rizikový faktor.</td></tr>
    <tr><td>Podiel stafylokokových infekcií v skúmanom centre klesol</td><td>Potvrdené</td><td>Zo 60 % na 34,8 % počas 15 rokov.</td></tr>
    <tr><td>Podiel gramnegatívnych paličiek vzrástol</td><td>Potvrdené</td><td>Z 18,5 % na 43,9 %.</td></tr>
    <tr><td>Absolútna incidencia gramnegatívnych infekcií stúpla</td><td>Nepodporené</td><td>Modelovaný pomer incidencií 0,49 svedčí skôr o poklese.</td></tr>
    <tr><td>Gramnegatívne baktérie sú dnes dominantné vo všetkých centrách</td><td>Nedokázané</td><td>Ide o nález z jednej írskej nemocnice.</td></tr>
    <tr><td>Otvorenie novej jednotky spôsobilo pokles infekcií</td><td>Nedokázané</td><td>Preukázaná je časová asociácia; autori sami hovoria o asociácii.</td></tr>
    <tr><td>Pomer incidencií 0,42 znamená približne 58-percentné relatívne zníženie</td><td>Podporené</td><td>Presný význam závisí od parametrizácie časového modelu.</td></tr>
    <tr><td>Muži mali vyššiu incidenciu infekcií</td><td>Potvrdené v tejto kohorte</td><td>Kauzalita nie je dokázaná; môže ísť o typ prístupu a komorbidity.</td></tr>
    <tr><td>Vek nad 34 rokov je praktická hranica infekčného rizika</td><td>Nesprávne</td><td>Bez ďalšieho vysvetlenia má pre dialyzačnú populáciu malú hodnotu.</td></tr>
    <tr><td>Každá pozitívna hemokultúra u pacienta s katétrom je katétrová infekcia</td><td>Nesprávne</td><td>Zdrojom môže byť pneumónia, uroinfekcia, cholangitída či endokarditída.</td></tr>
    <tr><td>Každý koaguláza-negatívny stafylokok je kontaminant</td><td>Nesprávne</td><td>Je aj častým skutočným pôvodcom katétrovej infekcie.</td></tr>
    <tr><td>Prevenciu možno zabezpečiť jedným antiseptickým prípravkom</td><td>Nesprávne</td><td>Potrebný je komplexný, auditovaný balík opatrení so spätnou väzbou.</td></tr>
    <tr><td>Gramnegatívny posun odôvodňuje širokospektrálne antibiotiká pre všetkých</td><td>Nesprávne</td><td>Rozhoduje klinický stav a lokálny antibiogram; nutná je deeskalácia.</td></tr>
    <tr><td>Zníženie používania katétrov patrí medzi najdôležitejšie stratégie</td><td>Potvrdené</td><td>Platí naprieč odporúčaniami aj epidemiologickými dátami.</td></tr>
    <tr><td>Výsledky írskeho centra možno priamo preniesť na Slovensko</td><td>Nesprávne</td><td>Potrebné sú lokálne epidemiologické údaje a vlastný antibiogram.</td></tr>
  </tbody>
</table>
</div>

<div class="pdf-avoid-break">
<h2>Praktický záver</h2>

<p>Írska štúdia ukazuje, že infekcie krvného riečiska pri hemodialýze možno dlhodobo znižovať, ale ich mikrobiologické spektrum sa môže meniť. Pokles stafylokokových infekcií môže byť výsledkom lepšej starostlivosti o cievny prístup, hygieny rúk, antisepsy, vzdelávania a organizačných zmien. Relatívne väčšie zastúpenie gramnegatívnych baktérií upozorňuje, že dohľad sa nemá sústrediť iba na kožnú flóru a katétrové stafylokokové infekcie.</p>

<p>Najdôležitejším modifikovateľným rizikom zostáva centrálny venózny katéter. Každá dialyzačná jednotka by mala sledovať incidenciu infekcií osobitne podľa typu cievneho prístupu, pôvodcu a citlivosti na antibiotiká. Dáta sa majú pravidelne vracať klinickému tímu vo forme použiteľnej spätnej väzby.</p>

<p><strong>Výsledky jedného centra nemajú určovať slovenskú empirickú antibiotickú liečbu. Tú treba zakladať na miestnom antibiograme, klinickej závažnosti, zdroji infekcie a dôslednom programe racionálnej antibiotickej liečby.</strong></p>
</div>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=antimikrobialna-rezistencia-infekcie-mocovych-ciest-nefrologia">Antimikrobiálna rezistencia pri infekciách močových ciest: globálna záťaž a nefrologický pohľad</a></li>
  <li><a href="article.php?slug=ambulantna-parenteralna-antimikrobialna-liecba-opat">Ambulantná parenterálna antimikrobiálna liečba: bezpečná alternatíva hospitalizácie iba pri správnom výbere pacienta</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Conlon P, Skally M, de Barra E, O'Kelly P, Greene M, Fitzpatrick F, Conlon PJ.</strong> <em>Declining rates of bloodstream infections among haemodialysis patients and the temporal association with changes in infection, prevention and control bundles of care between 2009 and 2023.</em> J Nephrol. Publikované online 14. augusta 2026. doi: 10.1093/joneph/aajag171. Retrospektívna kohorta 1 248 pacientov z Beaumont Hospital v Dubline. <a href="https://doi.org/10.1093/joneph/aajag171" target="_blank" rel="noopener noreferrer">Primárna publikácia</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/42599172/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lok CE, Huber TS, Lee T, a spol.</strong> <em>KDOQI Clinical Practice Guideline for Vascular Access: 2019 Update.</em> Am J Kidney Dis. 2020;75(4 Suppl 2):S1–S164. doi: 10.1053/j.ajkd.2019.12.001. <a href="https://doi.org/10.1053/j.ajkd.2019.12.001" target="_blank" rel="noopener noreferrer">Odporúčanie KDOQI pre cievny prístup</a>.</li>
  <li><strong>Mermel LA, Allon M, Bouza E, a spol.</strong> <em>Clinical Practice Guidelines for the Diagnosis and Management of Intravascular Catheter-Related Infection: 2009 Update by the Infectious Diseases Society of America.</em> Clin Infect Dis. 2009;49(1):1–45. doi: 10.1086/599376. Stále platná verzia odporúčania IDSA pre manažment katétrových infekcií. <a href="https://doi.org/10.1086/599376" target="_blank" rel="noopener noreferrer">Odporúčanie IDSA</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4039170/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Vanholder R, Canaud B, Fluck R, a spol.</strong> <em>Diagnosis, prevention and treatment of haemodialysis catheter-related bloodstream infections (CRBSI): a position statement of European Renal Best Practice.</em> NDT Plus. 2010;3(3):234–246. doi: 10.1093/ndtplus/sfq041. <a href="https://doi.org/10.1093/ndtplus/sfq041" target="_blank" rel="noopener noreferrer">Stanovisko ERBP</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC6371390/" target="_blank" rel="noopener noreferrer">plný text</a>.</li>
  <li><strong>Patel PR, Yi SH, Booth S, a spol.</strong> <em>Bloodstream infection rates in outpatient hemodialysis facilities participating in a collaborative prevention effort: a quality improvement report.</em> Am J Kidney Dis. 2013;62(2):322–330. doi: 10.1053/j.ajkd.2013.03.011. Doklad o účinnosti balíka opatrení so sledovaním a spätnou väzbou. <a href="https://doi.org/10.1053/j.ajkd.2013.03.011" target="_blank" rel="noopener noreferrer">Program spolupracujúcich stredísk</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/23676763/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Centers for Disease Control and Prevention.</strong> <em>Best Practices for Bloodstream Infection Prevention in Dialysis Settings.</em> Inštitucionálne autorstvo. <a href="https://www.cdc.gov/dialysis-safety/hcp/clinical-safety/index.html" target="_blank" rel="noopener noreferrer">Odporúčané postupy CDC</a>.</li>
  <li><strong>Centers for Disease Control and Prevention.</strong> <em>Core Interventions and Resources for Dialysis Bloodstream Infection Prevention.</em> Inštitucionálne autorstvo. <a href="https://www.cdc.gov/dialysis-safety/hcp/tools/index.html" target="_blank" rel="noopener noreferrer">Nástroje a kľúčové intervencie CDC</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčania KDIGO</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Všetky číselné údaje boli overené proti abstraktu primárnej publikácie. Časopis Journal of Nephrology vydáva pre Taliansku nefrologickú spoločnosť Oxford University Press, preto má identifikátor DOI predponu 10.1093. Autori štúdie deklarovali, že nemajú konkurenčné záujmy ani externé financovanie. Zverejnený abstrakt neobsahuje úplné údaje o troch balíkoch opatrení, absolútnych ročných incidenciách ani o všetkých premenných časového modelu; tieto údaje neboli dopĺňané odhadom.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Empirickú antibiotickú liečbu, dávkovanie pri hemodialýze a postup pri katétrových infekciách treba riadiť podľa miestneho antibiogramu, platného súhrnu charakteristických vlastností lieku a národných odporúčaní. Epidemiologické údaje jedného zahraničného centra nie sú podkladom na zmenu miestnych protokolov.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_infekcie-krvneho-rieciska-hemodialyza-mikrobiologicke-spektrum_article',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];

$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "------------------------------------------------------\n";
    echo 'Migracia clanku: ' . $articles[0]['title'] . "\n";
    echo "------------------------------------------------------\n";
    echo "Vysledok: $inserted vlozenych, $updated aktualizovanych z $total clankov.\n";
    echo "Preskocenych (bez zmeny):      $skipped\n";
    echo "Zaradenych do fronty aviz:     $queuedTotal\n";
    if (!empty($errors)) {
        echo "\nChyby:\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "------------------------------------------------------\n\n";
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
