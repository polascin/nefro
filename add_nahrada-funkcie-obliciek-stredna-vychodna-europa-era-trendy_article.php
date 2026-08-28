<?php
/**
 * add_nahrada-funkcie-obliciek-stredna-vychodna-europa-era-trendy_article.php
 * Idempotentný UPSERT skript pre odborne a jazykovo korigovaný článok
 * o trendoch náhrady funkcie obličiek v registri ERA.
 * Pôvodní autori zdrojovej štúdie sú evidovaní aj v source_authors.php.
 */

// Ochrana – len admin alebo CLI
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Vložiť alebo aktualizovať článok');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/pdf_generator.php';

$articles = [];

$articles[] = [
    'title'        => 'Náhrada funkcie obličiek v strednej a východnej Európe: trendy incidencie a prevalencie v registri ERA',
    'slug'         => 'nahrada-funkcie-obliciek-stredna-vychodna-europa-era-trendy',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-13 22:13:04',
    'is_top'       => 0,
    'excerpt'      => 'Analýza registra ERA v 19 krajinách ukázala, že v rokoch 2010–2019 stúpala neupravená incidencia náhrady funkcie obličiek priemerne o 1,5 % a prevalencia o 5,1 % ročne. Slovenské údaje si vyžadujú osobitne opatrnú interpretáciu.',
    'content'      => <<<'HTML'
<p>Náhrada funkcie obličiek (KRT; <em>kidney replacement therapy</em>) zahŕňa hemodialýzu, peritoneálnu dialýzu a život s funkčným transplantátom obličky. U pacientov so zlyhaním obličiek, ktorí sú na takúto liečbu indikovaní a rozhodnú sa ju podstúpiť, nahrádza životne dôležité funkcie obličiek. Nie je však jedinou legitímnou cestou pre každého pacienta: pri starostlivo vybraných ľuďoch môže byť aktívnou voľbou primeranou ich cieľom komplexná konzervatívna starostlivosť.</p>

<p>Rozsiahla analýza registra Európskej nefrologickej asociácie (ERA) opisuje vývoj liečenej populácie v 19 krajinách strednej a východnej Európy. Jej hlavné posolstvo nie je iba v rastúcich regionálnych priemeroch. Ešte dôležitejšia je výrazná heterogenita medzi krajinami a skutočnosť, že rovnaká hodnota incidencie či prevalencie môže vzniknúť kombináciou epidemiológie, demografie, dostupnosti liečby, klinickej praxe, prežívania a úplnosti registra. Tieto ukazovatele preto nemožno používať ako jednoduché poradie kvality zdravotných systémov.</p>

<h2>Čo presne merajú incidencia, prevalencia, pmp a AAPC</h2>

<div class="table-responsive" role="region" aria-label="Čo presne merajú incidencia, prevalencia, pmp a AAPC" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Význam v štúdii</th>
      <th scope="col">Dôležité interpretačné obmedzenie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><strong>Incidencia KRT</strong></td>
      <td>Počet ľudí, ktorí v danom roku začali dialýzu alebo podstúpili preemptívnu transplantáciu, prepočítaný na populáciu.</td>
      <td>Nie je totožná s incidenciou biologického zlyhania obličiek. Ovplyvňuje ju aj prístup k liečbe, rozhodnutie pacienta, prax pri začatí dialýzy a úplnosť hlásenia.</td>
    </tr>
    <tr>
      <td><strong>Prevalencia KRT</strong></td>
      <td>Počet ľudí žijúcich k 31. decembru na dialýze alebo s funkčným transplantátom obličky, prepočítaný na populáciu.</td>
      <td>Závisí od počtu nových liečených pacientov, ich prežívania, funkcie štepu, mortality, migrácie aj hraníc registra.</td>
    </tr>
    <tr>
      <td><strong>pmp</strong></td>
      <td><em>Per million population</em>, teda počet pacientov na milión obyvateľov.</td>
      <td>Umožňuje porovnať rôzne veľké populácie, ale sám neodstraňuje rozdiely vo vekovej a pohlavnej štruktúre.</td>
    </tr>
    <tr>
      <td><strong>AAPC</strong></td>
      <td>Priemerná ročná percentuálna zmena odhadnutá pomocou Joinpoint regresie.</td>
      <td>Je to modelovaný trend s 95 % intervalom spoľahlivosti, nie jednoduchý rozdiel prvého a posledného roku.</td>
    </tr>
  </tbody>
</table>
</div>

<p>Všetky porovnávané miery boli <strong>neupravené</strong>. Neboli štandardizované na vek ani pohlavie. Rozdiely medzi krajinami preto čiastočne odrážajú aj odlišnú demografickú štruktúru.</p>

<h2>Dizajn a rozsah analýzy</h2>

<p>Ide o mnohonárodnú retrospektívnu observačnú analýzu populačných trendov registra ERA. Päť registrov poskytlo individuálne záznamy pacientov – Bosna a Hercegovina, Estónsko, Grécko, Rumunsko a Srbsko. Ďalších štrnásť krajín poskytlo agregované ročné údaje: Albánsko, Bielorusko, Bulharsko, Chorvátsko, Cyprus, Česká republika, Lotyšsko, Litva, Severné Macedónsko, Poľsko, Rusko, Slovensko, Turecko a Ukrajina. Výsledná analýza však zostala na populačnej úrovni; nehodnotila individuálne trajektórie ani prežívanie pacientov.</p>

<p>Primárne obdobie rokov 2010–2019 bolo zvolené tak, aby nebolo ovplyvnené pandémiou COVID-19. Rozšírenie do roku 2021 slúžilo ako analýza citlivosti. Dostupné roky a úplnosť údajov sa medzi krajinami líšili, takže nešlo o vyvážený súbor všetkých 19 krajín počas celého obdobia. Maďarsko, Moldavsko, Čierna Hora a Slovinsko nemohli byť pre chýbajúce alebo neúplné údaje zaradené.</p>

<p>Trendy sa odhadovali Joinpoint regresiou; na výpočet boli potrebné najmenej štyri časové body. Pri agregovaných údajoch nebolo možné spätne zohľadniť oneskorené hlásenia. Podrobné členenie podľa veku, pohlavia, hlásenej primárnej príčiny zlyhania obličiek a modality bolo dostupné iba v časti registrov.</p>

<h2>Regionálne trendy: mierny rast incidencie, rýchlejší rast prevalencie</h2>

<div class="table-responsive" role="region" aria-label="Regionálne trendy: mierny rast incidencie, rýchlejší rast prevalencie" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Ukazovateľ</th>
      <th scope="col">Región</th>
      <th scope="col">2010<br>pmp</th>
      <th scope="col">2019<br>pmp</th>
      <th scope="col">AAPC 2010–2019<br>(95 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Incidencia KRT</td>
      <td>Stredná a východná Európa</td>
      <td>106,3</td>
      <td>119,6</td>
      <td>+1,5 % (+0,7 až +2,6)</td>
    </tr>
    <tr>
      <td>Incidencia KRT</td>
      <td>Západná Európa</td>
      <td>130,8</td>
      <td>145,9</td>
      <td>+1,4 % (+1,1 až +1,7)</td>
    </tr>
    <tr>
      <td>Prevalencia KRT</td>
      <td>Stredná a východná Európa</td>
      <td>426,2</td>
      <td>651,2</td>
      <td>+5,1 % (+4,5 až +5,7)</td>
    </tr>
    <tr>
      <td>Prevalencia KRT</td>
      <td>Západná Európa</td>
      <td>984,4</td>
      <td>1 253,9</td>
      <td>+2,6 % (+2,3 až +2,9)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Incidencia KRT v strednej a východnej Európe teda rástla približne rovnakým tempom ako v západnej Európe. Absolútna úroveň však bola nižšia a rozdiely medzi jednotlivými krajinami podstatne väčšie. V roku 2019 sa pohybovala od 39,9 pmp na Ukrajine po 283,8 pmp na Cypre; v Grécku dosiahla 268,9 pmp. Rozpätie bolo približne sedemnásobné, kým v západnej Európe približne trojnásobné.</p>

<p>Štatisticky významný rast incidencie sa zistil v ôsmich krajinách: v Albánsku, na Cypre, v Grécku, Severnom Macedónsku, Rumunsku, Rusku, Turecku a na Ukrajine. Pokles sa v primárnej analýze preukázal iba v Bosne a Hercegovine (AAPC −1,9 %; 95 % IS −3,5 až −0,6). V deviatich ďalších krajinách vrátane Slovenska bol trend štatisticky stabilný. Keďže preemptívne transplantácie tvorili približne 5 % začatí KRT a viaceré súbory ich vôbec nezahŕňali, regionálna incidencia do veľkej miery odrážala začatia dialýzy.</p>

<p>Prevalencia rástla podstatne rýchlejšie než incidencia. V roku 2019 sa pohybovala od 244,1 pmp na Ukrajine po 1 413,3 pmp v Grécku. Celková prevalencia sa štatisticky významne zvyšovala vo všetkých krajinách s vyhodnotiteľnými úplnými údajmi okrem Bieloruska. Cyprus nemal použiteľné údaje o celkovej prevalencii a chorvátske údaje boli neúplné alebo obmedzené na dialýzu.</p>

<h2>Modalita liečby: región zostáva prevažne hemodialyzačný</h2>

<p>V roku 2019 predstavovala v strednej a východnej Európe hemodialýza približne 66 % prevalentnej KRT, funkčný transplantát 29 % a peritoneálna dialýza približne 5 %. V západnej Európe boli podiely hemodialýzy a funkčného transplantátu takmer vyrovnané – približne 48 % a 47 %.</p>

<p>Najväčším modalitným príspevkom k rastu celkovej prevalencie v analyzovanom regióne bol rast počtu ľudí žijúcich s funkčným transplantátom. V Bielorusku, Českej republike, Estónsku, Lotyšsku a Litve predstavovali pacienti s funkčným štepom približne 40–60 % prevalentnej populácie KRT. Samotná analýza však neobsahovala údaje o mortalite, prežívaní štepu ani transplantačných výsledkoch. Nemožno z nej preto dokázať, že rast spôsobili úspešnejšie programy alebo lepšie prežívanie; opisuje zmenu počtu evidovaných pacientov, nie jej mechanizmus.</p>

<p>Prevalencia peritoneálnej dialýzy rástla v Lotyšsku, Litve, Rusku a na Ukrajine, klesala však v Bulharsku, Českej republike, Severnom Macedónsku, Poľsku, na Slovensku a podľa doplnkových údajov aj v Turecku. Estónsko malo štatisticky stabilný trend, preto nemožno hovoriť o spoločnom raste vo všetkých pobaltských štátoch. Pokles prevalencie tejto domácej modality je dôvodom na audit dostupnosti edukácie, asistovanej PD, personálu, úhrad, logistiky a preferencií pacientov; register sám príčiny nevysvetľuje.</p>

<h2>Vek, pohlavie a hlásená príčina zlyhania obličiek</h2>

<p>Vo všetkých krajinách začínalo KRT viac mužov než žien, medzi pohlaviami sa však neukázal zásadný rozdiel v časových trendoch. Medián veku pri začatí KRT sa medzi krajinami výrazne líšil: na Ukrajine sa v sledovaných obdobiach pohyboval od 52,0 do 54,8 roka, v Grécku od 70,8 do 74,2 roka. Vo väčšine krajín s dostupnými údajmi sa vek zvyšoval; v Lotyšsku a Litve zostával približne stabilný.</p>

<p>V krajinách s rastúcou incidenciou sa zvýšenie často koncentrovalo v diagnostických kategóriách diabetes mellitus a hypertenzia. Nešlo však o jednotný jav ani o dôkaz kauzality. Na Cypre napríklad rástla nielen incidencia pripísaná diabetu (+11,8 % ročne) a hypertenzii (+11,7 %), ale aj glomerulonefritíde (+12,5 %). Mnohé diagnózy neboli potvrdené biopsiou a v niektorých registroch bol vysoký podiel neznámej alebo chýbajúcej primárnej príčiny. Kategórie preto odrážajú aj diagnostickú a kódovaciu prax.</p>

<h2>Pandémia narušila rok 2020, dlhodobý obraz však väčšinou zostal</h2>

<p>Incidencia KRT v roku 2020 bola v strednej a východnej Európe o 5,7 % nižšia než priemer rokov 2017–2019; v západnej Európe bol rozdiel −6,2 %. Celková prevalencia sa medzi rokmi 2019 a 2020 zmenila iba o +0,1 %, v západnej Európe o +0,2 %. To je zlučiteľné s pandemickým narušením, štúdia však nemala údaje o mortalite a nemôže určiť podiel nadmerných úmrtí, obmedzenia prístupu, odložených začatí dialýzy či útlmu transplantačnej aktivity.</p>

<p>Po rozšírení analýzy do roku 2021 dosiahla regionálna incidencia 121,8 pmp a AAPC za roky 2010–2021 +1,1 % (95 % IS +0,3 až +2,6). Prevalencia dosiahla 669,1 pmp a AAPC +4,2 % (+3,8 až +4,6). Väčšina dlhodobých klasifikácií trendu sa nezmenila, hoci odhadovaný rast bol často menší. Incidenčný trend v Bosne a Hercegovine a Turecku už nebol štatisticky významný a v Srbsku sa ukázal pokles. Po predĺžení sledovaného obdobia už rastúci prevalenčný trend nebol štatisticky významný ani v Bosne a Hercegovine, Českej republike, Severnom Macedónsku a Srbsku. Z týchto údajov nemožno vyvodiť, že pandémia nemala závažný vplyv na jednotlivých pacientov.</p>

<h2>Slovensko: porovnateľná je dialyzačná séria, nie každý súčet KRT</h2>

<p>Slovenské výsledky si vyžadujú osobitnú pozornosť. Údaje o incidencii počas celého obdobia 2010–2021 zahŕňali iba pacientov začínajúcich dialýzu, nie preemptívne transplantácie. Pri celkovej prevalencii neboli transplantovaní pacienti zahrnutí v rokoch 2010, 2011 a 2021. Zdanlivý skok medzi rokmi 2011 a 2012 a pokles medzi rokmi 2020 a 2021 preto nemožno interpretovať ako klinickú zmenu – ide o zmenu hranice súboru. Na sledovanie slovenského vývoja je spoľahlivejšia samostatná dialyzačná séria.</p>

<div class="table-responsive" role="region" aria-label="Slovensko: porovnateľná je dialyzačná séria, nie každý súčet KRT" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Slovenský ukazovateľ</th>
      <th scope="col">2010<br>pmp</th>
      <th scope="col">2019<br>pmp</th>
      <th scope="col">AAPC 2010–2019<br>(95 % IS)</th>
      <th scope="col">Interpretácia</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Incidencia začatia dialýzy</td>
      <td>167,3</td>
      <td>121,9</td>
      <td>−1,2 % (−3,6 až +1,3)</td>
      <td>Štatisticky stabilný trend</td>
    </tr>
    <tr>
      <td>Prevalencia dialýzy</td>
      <td>572,7</td>
      <td>678,5</td>
      <td>+1,9 % (+1,5 až +2,2)</td>
      <td>Štatisticky významný rast</td>
    </tr>
    <tr>
      <td>Prevalencia hemodialýzy</td>
      <td>553,4</td>
      <td>664,7</td>
      <td>+2,0 % (+1,5 až +2,5)</td>
      <td>Štatisticky významný rast</td>
    </tr>
    <tr>
      <td>Prevalencia peritoneálnej dialýzy</td>
      <td>19,3</td>
      <td>13,8</td>
      <td>−3,3 % (−4,7 až −2,0)</td>
      <td>Štatisticky významný pokles</td>
    </tr>
  </tbody>
</table>
</div>

<p>Po rozšírení do roku 2021 zostala incidencia začatia dialýzy štatisticky stabilná (AAPC −0,7 %; 95 % IS −3,1 až +1,6), pričom hodnota v roku 2021 dosiahla 186,0 pmp. Dialyzačná prevalencia v tom roku predstavovala 777,9 pmp. Pokrytie slovenského registra pritom kleslo na 82,0 % v roku 2019, 79,2 % v roku 2020 a 81,8 % v roku 2021. Autori upravili populačný menovateľ podľa odhadovaného pokrytia, no pri porovnávaní posledných rokov je potrebná opatrnosť.</p>

<p>Regionálne pozorovanie o raste diabetickej a hypertenznej kategórie sa na Slovensko nedá automaticky preniesť. Incidencia pripísaná diabetu na Slovensku klesala (AAPC −4,1 %; 95 % IS −7,9 až −0,1), kým trend hypertenznej kategórie nebol štatisticky významný (−4,8 %; −12,2 až +3,2). Ani tieto údaje nepreukazujú zmenu skutočného výskytu príslušných chorôb, pretože ich ovplyvňuje diagnostika, kódovanie a úplnosť hlásenia.</p>

<h2>Prečo nízka alebo vysoká incidencia nie je hodnotením kvality</h2>

<p>Nízka incidencia KRT môže znamenať menšiu potrebu liečby, účinnejšiu prevenciu a pomalšiu progresiu chronickej choroby obličiek. Môže však odrážať aj úmrtie pred dosiahnutím zlyhania obličiek, obmedzenú dostupnosť alebo prijatie liečby, odlišný čas začatia dialýzy, preferenciu pacienta či voľbu konzervatívnej starostlivosti. Vysoká incidencia môže súvisieť s vyššou potrebou, staršou liečenou populáciou, lepšou dostupnosťou, odlišnou klinickou praxou alebo úplnejším registrom.</p>

<p>Podobne vysoká prevalencia nevypovedá sama osebe o prežívaní. Je výsledkom rovnováhy medzi novými začatiami, úmrtiami, transplantáciami, stratou funkcie štepu a migráciou. Ekonomické rozdiely medzi krajinami sú vierohodnou súčasťou kontextu a autori ich diskutujú s odkazom na staršiu literatúru, v tejto analýze však neboli priamo testované ani korelované s výsledkami.</p>

<h2>Čo zistenia znamenajú pre slovenskú prax a zdravotnú politiku</h2>

<ol>
  <li><strong>Vybudovať úplný pacientsky register.</strong> Slovensko potrebuje kontinuálne zachytiť dialýzu, preemptívnu transplantáciu, život s funkčným štepom, zmenu modality a výsledky. Ak sa hranica registra zmení, musí byť zreteľne označená. Evidencia komplexnej konzervatívnej starostlivosti by pomohla odlíšiť nenaplnenú potrebu od informovanej voľby.</li>
  <li><strong>Zverejňovať neupravené aj štandardizované miery.</strong> Neupravené pmp sú dôležité pre plánovanie kapacity, vekovo a pohlavne štandardizované miery zasa umožnia zmysluplnejšie porovnanie epidemiológie medzi krajinami.</li>
  <li><strong>Spomaľovať progresiu chronickej choroby obličiek.</strong> Včasná diagnostika, kontrola krvného tlaku, diabetu a albuminúrie a použitie liečby s dokázaným renálnym a kardiovaskulárnym prínosom patria k štandardnej starostlivosti. Register ERA však účinnosť jednotlivých liekov v tejto populácii netestoval.</li>
  <li><strong>Plánovať podľa rizika a trajektórie, nie podľa jediného čísla eGFR.</strong> <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024</a> odporúča zvažovať plánovanie preemptívnej transplantácie alebo dialyzačného prístupu pri eGFR pod 15–20 ml/min/1,73 m² alebo pri dvojročnom riziku KRT nad 40 %. Výber prístupu a jeho načasovanie musia zohľadniť rýchlosť progresie, anatómiu, komorbidity, očakávanú dĺžku života a preferencie pacienta. Praktické kroky približuje aj článok <a href="https://nefro.polascin.net/article.php?slug=priprava-na-dialyzacny-program">Príprava na dialyzačný program</a>.</li>
  <li><strong>Ponúknuť modalitne neutrálnu edukáciu.</strong> Hemodialýza, peritoneálna dialýza, transplantácia a komplexná konzervatívna starostlivosť majú byť vysvetlené zrozumiteľne a bez nátlaku. Pokles PD na Slovensku je dôvodom preskúmať bariéry, nie automaticky presmerovať každého pacienta na domácu liečbu. Voľba modality je spoločné, individualizované rozhodnutie.</li>
  <li><strong>Odoslať vhodných kandidátov na transplantačné vyšetrenie včas.</strong> Preemptívna transplantácia môže u vhodného pacienta predísť obdobiu dialýzy, nie každý pacient je však kandidátom. Samotná táto registračná štúdia nehodnotila prežívanie ani kauzálny účinok transplantácie.</li>
  <li><strong>Plánovať kapacity aj podpornú starostlivosť.</strong> Rast prevalencie liečených pacientov znamená potrebu personálu, dialyzačných miest, domácej podpory, transplantačnej následnej starostlivosti a geriatricko-paliatívnych služieb. Starší a krehkí pacienti potrebujú rozhodovanie zamerané na ciele, očakávaný prínos a záťaž liečby.</li>
</ol>

<h2>Hranice dôkazov</h2>

<p>Štúdia neobsahovala údaje o mortalite, hospitalizáciách, komorbiditách, liekoch, cievnych prístupoch, kvalite života ani individuálnych výsledkoch jednotlivých modalít. Nezachytávala ľudí so zlyhaním obličiek, ktorí KRT nezačali, ani pacientov v komplexnej konzervatívnej starostlivosti. Väčšina krajín poskytla iba agregované údaje, čo znemožnilo individuálnu adjustáciu a analýzu prežívania.</p>

<p>Úplnosť sa líšila medzi krajinami a rokmi. Napríklad v Rumunsku nebolo hlásených približne 30 % ľudí žijúcich s funkčným transplantátom; celková prevalencia KRT tým bola podľa autorov podhodnotená približne o 3 %. Incidencia preemptívnej transplantácie bola podhodnotená približne o 30 %. Chorvátske incidenčné údaje za roky 2020–2021 zahŕňali iba dialýzu. Pri agregovaných súboroch navyše nebolo možné doplniť oneskorene nahlásené prípady.</p>

<p>Preto treba výsledky čítať ako najlepší dostupný opis liečenej populácie v rámci známych hraníc registra, nie ako presné meranie biologického výskytu zlyhania obličiek, nenaplnenej potreby alebo kvality zdravotnej starostlivosti.</p>

<h2>Záver</h2>

<p>V rokoch 2010–2019 rástla v strednej a východnej Európe neupravená incidencia KRT priemerne o 1,5 % ročne a prevalencia o 5,1 % ročne. Incidencia sa vyvíjala podobným tempom ako v západnej Európe, prevalencia však rástla približne dvojnásobným tempom. Za regionálnym priemerom sa skrývali veľké rozdiely medzi krajinami a odlišné zastúpenie dialýzy a transplantácie.</p>

<p class="pdf-avoid-break">Pre Slovensko je najistejším zistením štatisticky stabilná incidencia začatia dialýzy, rastúca prevalencia dialýzy a klesajúca prevalencia peritoneálnej dialýzy. Celkovú slovenskú epidemiológiu KRT z publikovaných časových radov nemožno bez výhrad rekonštruovať, pretože v niektorých rokoch chýbali pacienti s funkčným transplantátom. Najpraktickejším dôsledkom práce je preto požiadavka na úplný, kontinuálny a transparentne definovaný register, ktorý umožní bezpečne plánovať prevenciu, modality liečby, transplantácie aj podpornú starostlivosť.</p>

<hr>

<p><em><strong>Zdroj – originálna štúdia:</strong> Bonthuis M, Kramer A, Bakkaloğlu SA, et al.; on behalf of the ERA Registry. Incidence and prevalence of kidney replacement therapy in Central and Eastern Europe—trends from the ERA Registry. <em>Nephrology Dialysis Transplantation</em>. 2026;41(7):1322–1339. <a href="https://academic.oup.com/ndt/article/41/7/1322/8416418" target="_blank" rel="noopener noreferrer">Oxford Academic – plný otvorený text</a>. doi: <a href="https://doi.org/10.1093/ndt/gfaf268" target="_blank" rel="noopener noreferrer">10.1093/ndt/gfaf268</a>. PMID 41499147: <a href="https://pubmed.ncbi.nlm.nih.gov/41499147/" target="_blank" rel="noopener noreferrer">PubMed</a>. <a href="https://europepmc.org/article/MED/41499147" target="_blank" rel="noopener noreferrer">Europe PMC</a>. <a href="https://academic.oup.com/ndt/article-pdf/41/7/1322/66292232/gfaf268.pdf" target="_blank" rel="noopener noreferrer">Oxford Academic – PDF</a>. <a href="https://portalcris.lsmuni.lt/server/api/core/bitstreams/0ffc5593-6dfe-4fd8-befa-e8494ced82ec/content" target="_blank" rel="noopener noreferrer">Inštitucionálna verzia rukopisu</a>. Článok je publikovaný pod licenciou CC BY 4.0.</em></p>

<p><em><strong>Všetci autori zdrojovej štúdie:</strong> Marjolein Bonthuis; Anneke Kramer; Sevcan A. Bakkaloğlu; Jaakko Helve; Nikola Gjorgjievski; Halima Resic; Anders Åsberg; Nicos Mitsides; Alicja M. Dębska-Ślizień; Kirill S. Komissarov; Viktorija Kuzema; Nurhan Seyahi; Belén Ponte; Edita Ziginskiene; Mirjana Lausevic; Ivan Rychlík; Mai Ots-Rosenberg; Evgueniy Vazelov; George Moustakas; Adrián Okša; Ariana Strakosha; Liliana Garneata; Dajana Katicic; Roser Torra; Alberto Ortiz; Vianda S. Stel.</em></p>

<p><em><strong>Financovanie zdroja:</strong> Register ERA financuje European Renal Association (ERA); článok bol pripravený v mene registra ERA, ktorý je oficiálnym orgánom asociácie.</em></p>

<p><em><strong>Konflikty záujmov zdroja:</strong> Nicos Mitsides, Mirjana Lausevic, Ivan Rychlík, Mai Ots-Rosenberg a Roser Torra uviedli neplatené funkcie v odborných alebo pacientskych organizáciách. Alicja M. Dębska-Ślizień, Liliana Garneata a Alberto Ortiz uviedli poradenské, prednáškové, cestovné alebo grantové vzťahy s viacerými farmaceutickými a zdravotníckymi spoločnosťami; Alberto Ortiz uviedol aj vedenie akademickej katedry podporenej spoločnosťou AstraZeneca. Ostatní autori neuviedli konflikty záujmov. Úplné individuálne vyhlásenia sú uvedené v originálnom článku.</em></p>

<p><em><strong>Vybrané doplňujúce zdroje použité pri vecnej kontrole:</strong> <a href="https://kdigo.org/wp-content/uploads/2024/03/KDIGO-2024-CKD-Guideline.pdf" target="_blank" rel="noopener noreferrer">KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease</a>; <a href="https://kdigo.org/wp-content/uploads/2017/02/KDIGO-Dialysis-Initiation-conf-report-FINAL.pdf" target="_blank" rel="noopener noreferrer">KDIGO – Dialysis initiation, modality choice, access, and prescription</a>; <a href="https://kdigo.org/wp-content/uploads/2023/04/Home-Dialysis-Conclusions-from-a-KDIGO-Controversies-Conference.pdf" target="_blank" rel="noopener noreferrer">KDIGO – Home dialysis</a>; <a href="https://www.kidney.org/professionals/kdoqi/guidelines-and-commentaries/vascular-access" target="_blank" rel="noopener noreferrer">KDOQI 2019 Vascular Access Guidelines and implementation tools</a>; <a href="https://www.era-online.org/research-education/era-registry/" target="_blank" rel="noopener noreferrer">ERA Registry</a>.</em></p>
HTML,
];

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

$stmt = $pdo->prepare(
    "INSERT INTO articles (title, slug, author, content, excerpt, published_at, is_top, is_published)
     VALUES (:title, :slug, :author, :content, :excerpt, :published_at, :is_top, 1)
     ON DUPLICATE KEY UPDATE
        title = VALUES(title), author = VALUES(author),
        content = VALUES(content), excerpt = VALUES(excerpt), is_top = VALUES(is_top)"
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

        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_article newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_article pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_article pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_article migration error: ' . $e->getMessage());
    }
}

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
