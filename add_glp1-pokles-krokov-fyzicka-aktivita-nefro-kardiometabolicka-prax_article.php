<?php

/**
 * add_glp1-pokles-krokov-fyzicka-aktivita-nefro-kardiometabolicka-prax_article.php
 * Odborný článok: pokles fyzickej aktivity pri agonistoch GLP-1 (spracovanie
 * Medscape Medical News) a dôsledky pre nefro-kardiometabolickú prax.
 *
 * Pôvodná autorka spracovaného zdroja je uvedená v source_authors.php.
 * Čísla overené z tlačovej správy Endocrine Society / ENDO 2026, abstraktu
 * SAT-714, Crossref (doi 10.2337/doc26-0062), PubMed eutils (PMID 42081217,
 * 33951361, 42518361). Paywall Medscape nebol obchádzaný.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_glp1-pokles-krokov-fyzicka-aktivita-nefro-kardiometabolicka-prax_article.php"
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
    'title'        => '„Weight down, steps down“: prečo sa pri agonistoch GLP-1 môže znižovať fyzická aktivita a ako na to myslieť v nefro-kardiometabolickej praxi',
    'slug'         => 'glp1-pokles-krokov-fyzicka-aktivita-nefro-kardiometabolicka-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Kohorta All of Us ukázala pokles denných krokov aj minút stredne až intenzívnej aktivity po začatí agonistov GLP-1. Úbytok hmotnosti pohyb automaticky nezvýši; v nefrológii ho treba plánovať zámerne.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Agonisty receptora glukagónu podobného peptidu 1 (GLP-1) znižujú hmotnosť nezávisle od cvičenia. Nové objektívne záznamy z náramkov Fitbit však ukazujú, že po ich nasadení môže denný pohyb klesnúť, nie stúpnuť. Ide o observačný signál, nie o dôkaz kauzality. Pre pacienta s chronickou chorobou obličiek, diabetom a obezitou z toho vyplýva skromné, ale praktické posolstvo: aktivitu treba plánovať ako súčasť liečby, nie ju očakávať ako samovoľný vedľajší produkt chudnutia.</em></p>

<p>Spravodajské spracovanie Medscape Medical News túto tému zhrnulo pod heslom „weight down, steps down“. Jadro nie je v tom, že by agonisty GLP-1 „škodili pohybu“. Jadro je v tom, že <strong>úbytok hmotnosti sám osebe nestačí na to, aby sa človek začal viac hýbať</strong> — a že odporúčanie cvičiť pri týchto liekoch sa v reálnych dátach často nenapĺňa. Prvý pilier dôkazu je retrospektívna pred-po kohorta z programu All of Us, prezentovaná na kongrese ENDO 2026. Druhý je prierezová analýza tej istej výskumnej platformy, už publikovaná v časopise <em>Diabetes, Obesity and CardioMetabolic CARE</em>.</p>

<h2>Čo ukázal Fitbit pred a po začatí liečby</h2>

<p>Sajana Maharjan a spolupracovníci identifikovali v programe All of Us 1 950 dospelých s obezitou, ktorým bol predpísaný agonista GLP-1 (semaglutid, tirzepatid, liraglutid alebo dulaglutid). Tirzepatid je duálny agonista receptorov GIP a GLP-1; v tejto práci ho autori zaradili do spoločnej skupiny s agonistami GLP-1. Do analýzy vstúpilo <strong>753 osôb (38,6 %)</strong>, ktoré mali použiteľný záznam Fitbit pred začatím aj po začatí liečby. Kohorta bola prevažne ženská (78,6 %), priemerný vek 52,7 ± 12,9 roka. Medzi časté komorbidity patrili muskuloskeletálna bolesť (81,9 %), hypertenzia (67,3 %) a diabetes 2. typu (48,1 %).</p>

<p>Ide o konferenčný abstrakt (poster SAT-714, 13. júna 2026), nie o recenzovanú plnú prácu. Výsledky sú preto predbežné. Dizajn je retrospektívny pred-po bez kontrolnej skupiny bez lieku: <strong>nedokazuje, že liek aktivitu znížil</strong>. Ukazuje, že v tejto kohorte aktivita po začatí liečby klesla, hoci by sa intuitívne čakalo, že po úbytku hmotnosti stúpne.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Zmena denných krokov a stredne až intenzívnej aktivity po začatí agonistu GLP-1 v kohorte All of Us" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Pred liečbou</th>
        <th scope="col">Po začatí liečby</th>
        <th scope="col">Zmena</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Denné kroky (n = 753)</th>
        <td>5 047 ± 3 073</td>
        <td>4 487 ± 3 133</td>
        <td>−560 ± 2 203; p &lt; 0,001</td>
      </tr>
      <tr>
        <th scope="row">MVPA, min/deň (n = 570)</th>
        <td>27,9 ± 28,2</td>
        <td>22,2 ± 23,3</td>
        <td>−5,7 ± 25,3; p &lt; 0,001</td>
      </tr>
    </tbody>
  </table>
</div>

<p>MVPA označuje stredne až intenzívnu fyzickú aktivitu (<em>moderate-to-vigorous physical activity</em>). Dôležitý metodický detail: denné kroky sa hodnotili u všetkých 753 účastníkov, minúty MVPA len u 570. Tlačová správa Endocrine Society čísla MVPA zaokrúhlila na 28 a 22 minút denne; presné hodnoty sú vyššie. Štandardné odchýlky sú veľké: individuálna zmena sa môže pohybovať oboma smermi.</p>

<p>Pokles bol väčší u mužov ako u žien: kroky −986 ± 2 244 oproti −445 ± 2 180 (p = 0,006), MVPA −15,3 ± 34,5 oproti −2,9 ± 21,2 min/deň (p &lt; 0,001). Účastníci s muskuloskeletálnou bolesťou mali výraznejší pokles krokov než bez nej (−679 ± 1 911 oproti −22 ± 3 165; p = 0,002). Zmena aktivity sa významne nelíšila podľa vekovej skupiny (ANOVA p = 0,670 pre kroky, p = 0,819 pre MVPA), stavu ťažkej obezity (p = 0,126), anamnézy cievnej mozgovej príhody (p = 0,601) ani srdcového zlyhávania (p = 0,925).</p>

<p>Autori v rozhovore pre Medscape upozornili na kľúčové obmedzenie: <strong>nevedeli posúdiť, či sa zmena aktivity líšila podľa veľkosti úbytku hmotnosti</strong>, ani či sa pohyb v priebehu liečby neskôr zlepšil. To bráni tvrdeniu, že „čím viac kto schudol, tým menej sa hýbal“ — a rovnako bráni tvrdeniu, že pokles je len prechodný.</p>

<p>Východiskových približne 5 000 krokov denne je ďaleko pod verejnozdravotným pásmom, o ktorom píšeme v článku <a href="article.php?slug=kolko-krokov-denne-staci-davkovo-odpovedova-analyza-nefrologia">Koľko krokov denne naozaj stačí?</a>. Ďalší pokles o približne 560 krokov preto nie je kozmetický. Zároveň treba povedať nahlas: ide o nositeľov Fitbit v programe All of Us, teda o selektovanú, pravdepodobne zdatnejšiu podskupinu. Prenos na typického nefrologického pacienta je analogický, nie priamy.</p>

<h2>Prierezový pohľad: koľko sa ľudia na agonistoch GLP-1 skutočne hýbu</h2>

<p>Kacey Chae a spolupracovníci hodnotili 298 dospelých z All of Us (roky 2018–2022), ktorí užívali agonistu GLP-1 a mali platný záznam z fitness náramka. Dizajn je prierezový: jeden časový rez, nie pred-po. Priemerný vek 52,6 ± 12,6 roka.</p>

<div class="table-responsive pdf-keep-together" role="region" aria-label="Pohybová aktivita u 298 dospelých užívajúcich agonistu GLP-1 v programe All of Us" tabindex="0">
  <table>
    <thead>
      <tr>
        <th scope="col">Ukazovateľ</th>
        <th scope="col">Hodnota</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Celková aktivita</th>
        <td>204 ± 76 min/deň</td>
      </tr>
      <tr>
        <th scope="row">Z toho MVPA</th>
        <td>24 ± 21 min/deň</td>
      </tr>
      <tr>
        <th scope="row">Nesplnenie ≥ 150 min MVPA/týždeň</th>
        <td>57,7 %</td>
      </tr>
      <tr>
        <th scope="row">Denné kroky</th>
        <td>5 944 ± 2 699</td>
      </tr>
      <tr>
        <th scope="row">Sedavý čas</th>
        <td>947 ± 189 min/deň (približne 15,8 h)</td>
      </tr>
    </tbody>
  </table>
</div>

<p>Viac ako polovica teda nesplnila minimum 150 minút stredne až intenzívnej aktivity týždenne, ktoré uvádzajú odporúčania pre obezitu, diabetes aj KDIGO 2024 pri chronickej chorobe obličiek. Nižšia aktivita bola spojená s vekom ≥ 65 rokov, ženským pohlavím, nižším príjmom domácnosti a diabetom 2. typu. Injekčný semaglutid bol v tejto prierezovej analýze spojený s vyšším celkovým denným časom aktivity než iné agonisty GLP-1; v spravodajskom spracovaní Medscape sa uvádza rozdiel 22,3 min/deň. Otvorený abstrakt práce asociáciu potvrdzuje, presné číslo v ňom však nie je. Ani pri overenom čísle by nešlo o dôkaz, že semaglutid aktivitu kauzálne zvyšuje — ide o asociáciu v malom, selektovanom súbore.</p>

<p>Autorka Kacey Chae zdôraznila, že vzorka je relatívne malá a zahŕňa len ľudí s dostupným náramkom. Sedavý čas okolo 16 hodín denne je klinicky nápadný, ale bez priameho porovnania s rovnako meranou kontrolnou skupinou v tej istej práci ho nemožno pretaviť na tvrdenie o „podstatne vyššej sedavosti než v celej populácii All of Us“. Na to by bola potrebná plná publikácia s tými porovnaniami.</p>

<p>Rozdiel v denných krokoch medzi oboma prácami (približne 5 944 oproti 4 487 po začatí liečby) nie je spor. Ide o iný dizajn, iný výber a iný časový rez. Spoločné posolstvo je skromnejšie: <strong>ľudia na agonistoch GLP-1 sa v týchto dátach nehýbu „sami od seba“ na úrovni odporúčaní</strong>.</p>

<h2>Prečo by aktivita mohla klesať — zatiaľ len hypotézy</h2>

<p>Maharjan pre Medscape uviedla tri mechanizmy, ktoré sa môžu sčítať. Žiadny z nich táto kohorta netestovala.</p>

<ol>
  <li><strong>Energetická šetrnosť a NEAT.</strong> NEAT (<em>non-exercise activity thermogenesis</em>) je energetický výdaj spontánneho pohybu mimo štruktúrovaného cvičenia: vstávanie, chôdza po domácnosti, prešľapovanie. Pri prudkom poklese apetítu a kalorického príjmu môže telo šetriť energiu práve obmedzením tohto „nezámerého“ pohybu.</li>
  <li><strong>Nežiaduce účinky.</strong> Nauzea, včasná sýtosť, znížený príjem a únava na začiatku titrácie môžu znížiť chuť aj kapacitu hýbať sa.</li>
  <li><strong>Strata chudej hmoty.</strong> Časť úbytku hmotnosti pri agonistoch GLP-1 tvorí beztuková hmota. Menej svalstva môže znížiť kapacitu aj „chuť“ na záťaž a uzavrieť slučku: menej pohybu → ďalšia strata svalstva.</li>
</ol>

<p>Štvrté, výslovne špekulatívne vysvetlenie je behaviorálne: ak injekcia „rieši váhu“, časť ľudí môže cvičenie považovať za menej potrebné. Maharjan proti čisto mechanickému výkladu (že ťažké telo bráni v chôdzi) uviedla, že vzorec sa podľa závažnosti obezity významne nelíšil (p = 0,126). To je indícia, nie dôkaz iného mechanizmu.</p>

<h2>Anhedónia pri vysokej dávke tirzepatidu: tri kazuistiky, nie evidencia</h2>

<p>Ako hypotézu generujúci doplnok Medscape citovalo sériu troch kazuistík. Spencer Nadolsky, Summer Kessel, Zachary A. Krumm a Grant M. Tinsley opísali tri ženy s obezitou na tirzepatide 15 mg týždenne, ktoré hlásili zníženú motiváciu, emočnú „plochosť“ alebo stratu záujmu o cvičenie a predtým príjemné činnosti napriek úspešnému chudnutiu. Príznaky sa objavili po dlhšej liečbe v blízkosti maximálnej dávky. Po znížení na 10 mg týždenne alebo menej sa stav u dvoch zlepšil samotnou redukciou dávky; tretia potrebovala aj bupropión. Opätovné zvýšenie dávky u jednej pacientky príznaky vrátilo bez ďalšieho prínosu na hmotnosť.</p>

<p><strong>Tri kazuistiky nedokazujú, že agonisty GLP-1 spôsobujú anhedóniu</strong>, ani to, že zníženie dávky je overená stratégia. Sú to signály na pýtanie sa na motiváciu a radosť z pohybu, najmä pri vysokých dávkach. Nemajú sa čítať ako dôvod liek vysadiť ani ako návod na off-label kombináciu s bupropiónom. Súvislosť s témou „food noise“ a zásahom do okruhov odmeny je biologicky mysliteľná, ale klinicky zatiaľ neuzavretá.</p>

<h2>Prečo cvičenie pri agonistoch GLP-1 nie je voliteľný doplnok</h2>

<p>Perspektíva v <em>JAMA</em> (Lieberman, Aslan, Heymsfield) kladie cvičenie do éry agonistov GLP-1 ako praktický problém, nie ako slogan. Medscape ho označilo za editorial; v PubMed ide o Perspective. Autori zdôrazňujú, že cvičenie pri týchto liekoch nie je len o ďalších kilogramoch. Má zmysel pre zachovanie chudej hmoty, zvládanie plató chudnutia, obmedzenie opätovného nárastu hmotnosti po prerušení liečby a pre oxidačný metabolizmus tuku. To sú argumenty z perspektívy, nie nové primárne dáta.</p>

<p>Ako konkrétny randomizovaný dôkaz Medscape aj perspektíva odkazujú na štúdiu S-LITE (Lundgren a kol., <em>N Engl J Med</em> 2021). Čísla treba čítať presne, nie tak, ako ich skracuje spravodajský text. Najprv 195 dospelých s obezitou bez diabetu schudlo počas 8-týždňovej nízkoenergetickej diéty v priemere 13,1 kg. Až potom boli randomizovaní na rok do štyroch stratégií. Rozdiely nižšie sú <strong>oproti placebu pri udržiavaní</strong>, nie absolútny úbytok od prvého dňa lieku:</p>

<ul>
  <li>program stredne až intenzívnej aktivity: −4,1 kg (95 % IS −7,8 až −0,4; p = 0,03),</li>
  <li>liraglutid 3,0 mg denne: −6,8 kg (95 % IS −10,4 až −3,1; p &lt; 0,001),</li>
  <li>kombinácia: −9,5 kg (95 % IS −13,1 až −5,9; p &lt; 0,001).</li>
</ul>

<p>Kombinácia bola lepšia ako samotné cvičenie (−5,4 kg; p = 0,004), ale <strong>oproti samotnému liraglutidu rozdiel −2,7 kg nebol štatisticky významný</strong> (95 % IS −6,3 až 0,8; p = 0,13). Kombinácia približne zdvojnásobila pokles percenta tuku v porovnaní s každou monoterapiou a len ona bola spojená so zlepšením glykovaného hemoglobínu, inzulinovej citlivosti a kardiorespiračnej zdatnosti. Ide o liraglutid po veľmi prísnej diéte, nie o semaglutid 2,4 mg ani tirzepatid v bežnej ambulancii. Prenos je analogický: cvičenie pridáva kvalitu úbytku hmotnosti, nie magický násobiteľ každého inkretínu.</p>

<h2>Čo z toho plynie v nefrológii</h2>

<p>Agonisty GLP-1 majú v presne definovaných populáciách preukázaný kardiorenálny prínos. V štúdii FLOW semaglutid 1,0 mg týždenne u pacientov s diabetom 2. typu a chronickou chorobou obličiek znížil primárny renálny kompozit (HR 0,76). V predšpecifikovanej renálnej analýze SELECT semaglutid 2,4 mg u osôb s nadváhou alebo obezitou a etablovaným kardiovaskulárnym ochorením bez diabetu znížil obličkový kompozit (HR 0,78). Tieto tvrdé endpointy <strong>neslobodno zamieňať</strong> s Fitbit kohortou. All of Us meria kroky, nie pokles eGFR, albuminúriu ani zlyhanie obličiek. Z poklesu 560 krokov denne preto nevyplýva, že by sa strácal renálny benefit lieku — a rovnako z neho nevyplýva, že by pohyb pri týchto liekoch bol zbytočný.</p>

<p>Práve naopak. Pacient s chronickou chorobou obličiek, diabetom a obezitou už na vstupe často spĺňa rizikový fenotyp: nízka východisková aktivita, sarkopénia, krehkosť, muskuloskeletálna bolesť, anémia, objemové preťaženie. Meta-analýza observačných štúdií odhadla priemerný denný počet krokov pri chronickej chorobe obličiek na približne 4 640 — teda v pásme, v ktorom Maharjan a kol. videli ďalší pokles. Ak sa k farmakologickému úbytku hmotnosti pridá ešte menej chôdze a menej MVPA, rastie riziko, že schudne nielen tuk, ale aj funkčná svalová rezerva.</p>

<p>KDIGO 2024 odporúča dospelým s chronickou chorobou obličiek aspoň 150 minút stredne intenzívnej aktivity týždenne, alebo úroveň zlučiteľnú s kardiovaskulárnou a fyzickou toleranciou, a vyhýbať sa dlhému sedavému správaniu. All of Us tento cieľ u väčšiny ľudí na agonistoch GLP-1 nenapĺňa. V nefrologickej ambulancii to znamená:</p>

<ul>
  <li><strong>Nepovažovať pohyb za automatický vedľajší produkt chudnutia.</strong> Pýtať sa na kroky, dychovú rezervu, bolesť kĺbov a chuť cvičiť už pri predpise, nielen pri kontrole hmotnosti.</li>
  <li><strong>Merať východisko.</strong> Niekoľko dní náramku alebo telefónu povie viac ako odhad. Cieľ má byť prírastok od reálneho čísla, nie skok na slogan 10 000 krokov.</li>
  <li><strong>Kombinovať chôdzu so silovým cvičením.</strong> Pri rýchlom úbytku hmotnosti ide aj o zachovanie svalstva a kostí, nielen o ďalšie kilogramy. Pri dialýze, steroidnej myopatii a vysokom riziku pádu treba plán individualizovať.</li>
  <li><strong>Odlišovať bariéry.</strong> Nauzea po titrácii, muskuloskeletálna bolesť, krehkosť, anémia, hypervolémia a depresívna nálada vyžadujú iný postup. U mužov v analýze Maharjan a kol. bol pokles väčší — v ambulancii to stojí za cielenú otázku, nie za iný liek.</li>
  <li><strong>Nenahrádzať nefroprotekciu cvičením ani cvičenie injekciou.</strong> Blokáda RAAS, inhibítor SGLT2, kontrola tlaku, glykémie a objemu ostávajú piliermi. Agonista GLP-1 ich pri vhodnej indikácii dopĺňa.</li>
</ul>

<div class="pdf-avoid-break">
<h2>Záver</h2>

<p>Dve práce z All of Us — pred-po kohorta s Fitbit a prierezová analýza 298 dospelých — ukazujú konzistentný obraz: ľudia na agonistoch GLP-1 sa po chudnutí nezačnú spontánne viac hýbať a často nespĺňajú ani základné odporúčania MVPA. Kauzalitu z toho vyvodiť nemožno. Mechanizmy ostávajú hypotézami. Kazuistiky anhedónie pri 15 mg tirzepatidu sú signál, nie dôkaz.</p>

<p><strong>V nefro-kardiometabolickej praxi stačí jedna zmena v poradí: najprv liek a plán pohybu, nie liek a predpoklad, že kroky prídu samy.</strong> Kardiorenálny prínos semaglutidu z FLOW a SELECT ostáva. Životný štýl ním nie je vyriešený.</p>
</div>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=kolko-krokov-denne-staci-davkovo-odpovedova-analyza-nefrologia">Koľko krokov denne naozaj stačí?</a> — dávkovo-odpoveďová analýza a realistický cieľ v nefrológii.</li>
  <li><a href="article.php?slug=glp1-lieky-renalne-benefity-dokazy-prax-nefrologia">Sú GLP-1 lieky už „lieky na obličky“?</a> — FLOW, SELECT a sila renálneho dôkazu.</li>
  <li><a href="article.php?slug=glp1-kompulzivne-spravanie-food-noise-nefrologia">GLP-1, „food noise“ a kompulzívne správanie</a> — okruhy odmeny, craving a opatrný výklad.</li>
  <li><a href="article.php?slug=glp1-era-novy-model-starostlivosti-o-obezitu-nefrologia">Éra GLP-1 a nový model starostlivosti o obezitu</a> — organizácia starostlivosti, nielen predpis.</li>
  <li><a href="article.php?slug=frailty-ckd-vyziva-pohyb-stisk-ruky">Krehkosť pri CKD</a> — výživa, pohyb a funkčné hodnotenie.</li>
  <li><a href="article.php?slug=wearables-chronicke-ochorenia-protokoly-klinicky-zmysel">Wearables pri chronických ochoreniach</a> — meranie bez protokolu nestačí.</li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Melville NA.</strong> <em>Weight Down, Steps Down: The GLP-1 Catch.</em> Medscape Medical News. 2026. Spravodajské spracovanie (časť obsahu za prihlásením); autorka overená vo verejnej tiráži. <a href="https://www.medscape.com/viewarticle/weight-down-steps-down-glp-1-catch-2026a1000tts" target="_blank" rel="noopener noreferrer">medscape.com</a>.</li>
  <li><strong>Maharjan S, Dangol G, Le Q.</strong> <em>Losing Pounds, Not Gaining Steps: The Paradox of GLP-1 Receptor Agonist Therapy.</em> Poster SAT-714, ENDO 2026, Chicago, 13. júna 2026. Konferenčný abstrakt, nie recenzovaná plná práca. <a href="https://endo2026.endocrine.org/ajaxcalls/PresentationInfo.asp?PresentationID=1845539" target="_blank" rel="noopener noreferrer">Abstrakt ENDO 2026</a>.</li>
  <li><strong>Endocrine Society.</strong> <em>Exercise decreases among people taking GLP-1 medication.</em> Tlačová správa k ENDO 2026. <a href="https://www.endocrine.org/news-and-advocacy/news-room/2026/maharjan-press-release-endo-2026" target="_blank" rel="noopener noreferrer">endocrine.org</a>.</li>
  <li><strong>Chae K, Jones MR, Yang A, Ghosh J, Rajagopal S, Chao AM.</strong> <em>Physical Activity Patterns in Adults Taking Glucagon-Like Peptide-1 Receptor Agonists: An All of Us Cross-Sectional Study.</em> Diabetes Obes Cardiometab CARE. 2026. doi: 10.2337/doc26-0062. <a href="https://doi.org/10.2337/doc26-0062" target="_blank" rel="noopener noreferrer">DOI</a>.</li>
  <li><strong>Lieberman DE, Aslan DH, Heymsfield SB.</strong> <em>The Conundrum of Exercise for Weight Management in the GLP-1 Receptor Agonist Era.</em> JAMA. 2026;335(21):1841–1843. doi: 10.1001/jama.2026.5537. PMID 42081217. <a href="https://pubmed.ncbi.nlm.nih.gov/42081217/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Lundgren JR, Janus C, Jensen SBK, et al.</strong> <em>Healthy Weight Loss Maintenance with Exercise, Liraglutide, or Both Combined.</em> N Engl J Med. 2021;384(18):1719–1730. doi: 10.1056/NEJMoa2028198. PMID 33951361. <a href="https://pubmed.ncbi.nlm.nih.gov/33951361/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Nadolsky S, Kessel S, Krumm ZA, Tinsley GM.</strong> <em>Resolution of anhedonia-like symptoms in patients treated for obesity with tirzepatide: A three-case series.</em> Obes Pillars. 2026;19:100302. doi: 10.1016/j.obpill.2026.100302. PMID 42518361. <a href="https://pubmed.ncbi.nlm.nih.gov/42518361/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC13382402/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, et al.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes (FLOW).</em> N Engl J Med. 2024;391:109–121. doi: 10.1056/NEJMoa2403347. PMID 38785209. <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Colhoun HM, Lingvay I, Brown PM, et al.</strong> <em>Long-term kidney outcomes of semaglutide in obesity and cardiovascular disease in the SELECT trial.</em> Nat Med. 2024;30:2058–2066. doi: 10.1038/s41591-024-03015-5. PMID 38796653. <a href="https://pubmed.ncbi.nlm.nih.gov/38796653/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4S):S117–S314. Odporúčanie k pohybovej aktivite. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">KDIGO</a>.</li>
  <li><strong>Zhang F, Ren Y, Wang H, Bai Y, Huang L.</strong> <em>Daily Step Counts in Patients With Chronic Kidney Disease: A Systematic Review and Meta-Analysis of Observational Studies.</em> Front Med (Lausanne). 2022;9:842645. doi: 10.3389/fmed.2022.842645. Priemerný odhad približne 4 640 krokov denne. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC8891233/" target="_blank" rel="noopener noreferrer">PMC</a>.</li>
</ol>

<p><em><strong>Poznámka k interpretácii:</strong> Článok je slovenským spracovaním spravodajského textu Medscape a overením citovaných primárnych zdrojov. Konferenčný abstrakt a prierezová kohorta nedokazujú kauzalitu. Konkrétny plán pohybu treba prispôsobiť kardiovaskulárnej tolerancii, krehkosti, riziku pádu, anémii, objemovému stavu a štádiu chronickej choroby obličiek.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_glp1-pokles-krokov-fyzicka-aktivita-nefro-kardiometabolicka-prax_article',
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
