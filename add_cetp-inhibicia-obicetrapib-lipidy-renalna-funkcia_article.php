<?php
/**
 * add_cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia_article.php
 * Odborný článok o inhibícii CETP obicetrapibom a jej význame pre nefrológiu.
 * Pôvodný článok bez jedného konkrétneho spracovaného zdroja (syntéza primárnej literatúry).
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

// ── Dáta článku ───────────────────────────────────────────────────────────────

$articles = [];

$articles[] = [
    'title'        => 'Inhibícia CETP obicetrapibom: koniec éry „len LDL“ a čo z toho vyplýva pre nefrológiu',
    'slug'         => 'cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Obicetrapib znižuje LDL-C, apoB aj Lp(a) a má centrálnu európsku registráciu. Čo hovoria BROADWAY, BROOKLYN a TANDEM a prečo renálny signál zatiaľ nestačí.',
    'content'      => <<<'HTML'
<figure><a href="img/cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia.webp" rel="noopener noreferrer" target="_blank"><img src="img/cetp-inhibicia-obicetrapib-lipidy-renalna-funkcia.webp" alt="Zlatisté lipoproteínové častice prúdia zúženou cievou so zhrubnutou stenou smerom k polopriesvitnej obličke v chladnom tyrkysovom svetle" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna, nie snímka konkrétneho pacienta ani zobrazenie konkrétneho lieku. Aterogénna záťaž a obličková prognóza sú spojené nádoby – otázkou zostáva, nakoľko sa dá tá druhá ovplyvniť zásahom do prvej.</figcaption></figure>

<p>Zníženie LDL cholesterolu (LDL-C) je najlepšie podloženým zásahom do aterosklerotického rizika, aký v internej medicíne máme. Napriek tomu značná časť pacientov cieľové hodnoty nedosahuje a aj tí, ktorí ich dosiahnu, si nesú zvyškové (reziduálne) kardiovaskulárne riziko. Práve pacienti s chronickou chorobou obličiek (CKD) patria do oboch týchto skupín naraz.</p>

<p>Po dvadsiatich rokoch neúspechov sa do klinickej praxe vracia lieková trieda, ktorú väčšina z nás odpísala: inhibítory cholesteryl ester transfer proteínu (CETP). Obicetrapib, selektívny zástupca novej generácie, dokončil tri štúdie fázy 3 a vo Európskej únii získal centralizovanú registráciu. Súčasne sa objavil post hoc signál o spomalení poklesu odhadovanej glomerulovej filtrácie (eGFR). Tento text zhŕňa, čo je z toho doložené, a predovšetkým – čo z toho zatiaľ neplatí pre nefrologickú populáciu.</p>

<h2>Čo CETP robí a prečo sa jeho blokáda zdala dobrým nápadom</h2>

<p>CETP je plazmatický glykoproteín, ktorý sprostredkúva výmenu esterov cholesterolu a triglyceridov medzi lipoproteínmi. Prenáša estery cholesterolu z HDL častíc na lipoproteíny obsahujúce apolipoproteín B (apoB) – teda na VLDL, IDL a LDL – výmenou za triglyceridy. Jeho zablokovanie preto súčasne zvyšuje HDL cholesterol (HDL-C) a znižuje aterogénnu apoB frakciu.</p>

<p>Historicky sa trieda vyvíjala s dôrazom na prvý z týchto účinkov, teda na zvyšovanie HDL-C. Tento predpoklad sa nepotvrdil: zvýšenie HDL-C samo osebe nie je náhradným ukazovateľom klinického prínosu. Dnešný záujem stojí na druhom účinku – na znížení počtu aterogénnych častíc, ktoré sa dá merať ako apoB a non-HDL cholesterol.</p>

<h2>Čo nás naučili predchádzajúce molekuly</h2>

<p>Dejiny triedy sa často zhrnú do vety „CETP inhibítory zlyhali“. Toto zhrnutie je nepresné a pre pochopenie súčasnej situácie zavádzajúce.</p>

<p><strong>Torcetrapib</strong> v štúdii ILLUMINATE u 15 067 vysokorizikových pacientov zvýšil HDL-C o 72,1 % a znížil LDL-C o 24,9 %. Súčasne však zvýšil systolický tlak o 5,4 mm Hg, znížil kálium a zvýšil sodík, bikarbonát a aldosterón. Štúdiu ukončili predčasne pre zvýšené riziko kardiovaskulárnych príhod (pomer rizík 1,25; 95 % IS 1,09–1,44; p = 0,001) a úmrtia z akejkoľvek príčiny (pomer rizík 1,58; 95 % IS 1,14–2,19; p = 0,006). Autori už vtedy upozornili na dôkazy o mimocieľovom (off-target) mineralokortikoidnom účinku, pričom nevylúčili ani podiel samotnej inhibície CETP.</p>

<p><strong>Anacetrapib</strong> v štúdii REVEAL u 30 449 pacientov s aterosklerotickým cievnym ochorením na intenzívnej liečbe atorvastatínom priniesol opačný výsledok. Počas mediánu sledovania 4,1 roka sa primárny ukazovateľ – prvá veľká koronárna príhoda – vyskytol u 10,8 % oproti 11,8 % pacientov (pomer početností 0,91; 95 % IS 0,85–0,97; p = 0,004). Non-HDL cholesterol klesol o 18 %. Rozdiely v riziku úmrtia, nádorov ani iných závažných nežiaducich udalostí neboli významné.</p>

<p>Poučenie preto neznie „inhibícia CETP škodí“, ale presnejšie: <strong>problém torcetrapibu bol mimocieľový, nie triedny</strong>, a REVEAL ukázal, že inhibícia CETP dokáže znížiť počet koronárnych príhod – úmerne tomu, o koľko zníži aterogénnu záťaž. Anacetrapib sa ďalej nevyvíjal pre nepriaznivé farmakokinetické vlastnosti (hromadenie v tukovom tkanive), nie pre nedostatok účinnosti. Dalcetrapib a evacetrapib zlyhali vo výsledkových štúdiách, obe však mali len malý alebo žiadny vplyv na LDL-C a apoB – čo je s predchádzajúcim vysvetlením v súlade.</p>

<h2>Obicetrapib: čo je doložené zo štúdií fázy 3</h2>

<p>Obicetrapib je vysoko selektívny hydrofilný inhibítor CETP v dávke 10 mg denne. Tri dokončené štúdie fázy 3 mali zhodne za primárny ukazovateľ percentuálnu zmenu LDL-C, nie klinické príhody.</p>

<div class="table-responsive" role="region" aria-label="Prehľad dokončených štúdií fázy 3 s obicetrapibom" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Populácia a dizajn</th>
      <th scope="col">Hlavný výsledok (deň 84)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">BROOKLYN</th>
      <td>354 pacientov s heterozygotnou familiárnou hypercholesterolémiou a LDL-C ≥ 1,8 mmol/l (70 mg/dl) napriek maximálne tolerovanej liečbe; 87 % na statíne; randomizácia 2 : 1 na 365 dní</td>
      <td>LDL-C oproti placebu −36,3 % (95 % IS −42,2 až −30,4; p &lt; 0,0001); apoB −24,4 %; non-HDL-C −34,5 %; Lp(a) −45,9 %; HDL-C +138,7 %</td>
    </tr>
    <tr>
      <th scope="row">BROADWAY</th>
      <td>2 530 pacientov s heterozygotnou familiárnou hypercholesterolémiou alebo anamnézou ASCVD na maximálne tolerovanej liečbe; priemerný vek 65 rokov, 34 % žien, vstupný LDL-C 98 mg/dl; randomizácia 2 : 1 na 365 dní</td>
      <td>LDL-C −29,9 % (95 % IS −32,1 až −27,8) oproti +2,7 % pri placebe; rozdiel medzi skupinami −32,6 percentuálneho bodu (95 % IS −35,8 až −29,5; p &lt; 0,001)</td>
    </tr>
    <tr>
      <th scope="row">TANDEM</th>
      <td>407 pacientov s ASCVD alebo vysokým rizikom, prípadne so statínovou intoleranciou; štyri ramená 1 : 1 : 1 : 1 (fixná kombinácia, obicetrapib, ezetimib, placebo) na 84 dní</td>
      <td>Fixná kombinácia oproti placebu −48,6 % (95 % IS −58,3 až −38,9), oproti ezetimibu −27,9 %, oproti samotnému obicetrapibu −16,8 %; samotný obicetrapib oproti placebu −31,9 %</td>
    </tr>
  </tbody>
</table>
</div>

<p>Dve čísla si zasluhujú zdôraznenie. Po prvé, <strong>pokles Lp(a) o 45,9 %</strong> v štúdii BROOKLYN je pozoruhodný, pretože Lp(a) je u pacientov s CKD častý zosilňovač rizika a statíny ho neznižujú. Po druhé, <strong>pokles apoB bol s −24,4 % výrazne menší ako pokles LDL-C s −36,3 %</strong>. Tento nesúlad je klinicky dôležitý: ak časť poklesu LDL-C odráža zmenu zloženia častíc, a nie ich počtu, potom očakávaný prínos zodpovedá skôr poklesu apoB než pôsobivejšiemu číslu pri LDL-C. Ide o rovnakú úvahu, ktorá vysvetľuje, prečo neutrálne výsledky dalcetrapibu nikoho neprekvapili.</p>

<p>Znášanlivosť bola vo všetkých troch štúdiách porovnateľná s kontrolou. V štúdii TANDEM sa nežiaduce udalosti vyskytli u 51 % pacientov na fixnej kombinácii, 54 % na obicetrapibe, 53 % na ezetimibe a 37 % na placebe; závažné udalosti boli zriedkavé a rozdelené rovnomerne. Podstatné je, že <strong>sa neopakoval mineralokortikoidný obraz torcetrapibu</strong> – teda vzostup tlaku a pokles kália.</p>

<h2>Renálny signál: čo štúdie skutočne ukázali</h2>

<p>Najzaujímavejšou časťou pre nefrológa je združená post hoc analýza štúdií BROADWAY a BROOKLYN, ktorú publikovala skupina na čele s Liffertom Vogtom. Vychádzala z hypotézy, že nízky alebo dysfunkčný HDL prispieva k progresívnemu zhoršovaniu obličkových funkcií.</p>

<p>Do analýzy eGFR vstúpilo 2 832 a do analýzy pomeru albumín/kreatinín v moči (UACR) 1 897 randomizovaných účastníkov. Výsledky:</p>

<ul>
  <li>Obicetrapib spomalil pokles obličkových funkcií oproti placebu – priemerný rozdiel <strong>0,67 ml/min/1,73 m²</strong> (nominálne p = 0,02); v analýze podľa skutočného užívania liečby 0,82 ml/min/1,73 m² (nominálne p = 0,0139).</li>
  <li>Pokles eGFR pod 15 ml/min/1,73 m²: 0 oproti 0,2 %. Pokles eGFR o ≥ 40 %: 1,3 oproti 1,9 %.</li>
  <li>Zložený obličkový ukazovateľ: 1,9 oproti 3,0 %; pomer rizík 0,64, <strong>nominálne p = 0,08 – teda bez štatistickej významnosti</strong>.</li>
  <li>Vyšší dosiahnutý HDL-C sa spájal s nižším rizikom zloženého obličkového ukazovateľa (nominálne p &lt; 0,0001 v splajnovej analýze), nezávisle od vstupného HDL-C a eGFR.</li>
  <li><strong>Ročná percentuálna zmena UACR sa medzi skupinami významne nelíšila.</strong></li>
</ul>

<h3>Prečo tento signál zatiaľ nestačí</h3>

<p>Pri čítaní týchto výsledkov treba mať na pamäti štyri obmedzenia, ktoré ich pre nefrologickú prax zásadne ohraničujú.</p>

<p><strong>Populácia nemala chorobu obličiek.</strong> Priemerná vstupná eGFR bola 84,4 ± 17,9 ml/min/1,73 m² v štúdii BROADWAY a 91,8 ± 17,8 v štúdii BROOKLYN. Medián UACR bol 11,0 a 8,0 mg/g, teda v pásme normoalbuminúrie. Išlo o pacientov s prakticky zachovanou funkciou obličiek, nie o populáciu s CKD. Dialyzovaní ani transplantovaní pacienti zaradení neboli.</p>

<p><strong>Veľkosť účinku je malá a jej klinický význam neznámy.</strong> Rozdiel 0,67 ml/min/1,73 m² za jeden rok sa pohybuje na hranici biologickej variability merania a ani zďaleka nedosahuje prahy, ktoré sa uznávajú ako náhradné ukazovatele progresie CKD.</p>

<p><strong>Všetky hodnoty p sú nominálne a analýza je post hoc.</strong> Nebola korigovaná na mnohonásobné porovnávanie. Zložený obličkový ukazovateľ – teda jediný výstup, ktorý by sa priblížil klinickej príhode – významnosť nedosiahol.</p>

<p><strong>Súvislosť medzi dosiahnutým HDL-C a obličkovým výsledkom je asociačná, nie kauzálna.</strong> Ide o analýzu podľa odpovede na liečbu, ktorá je náchylná na zmätenie ukazovateľom zdravia: pacienti, ktorí dosiahnu vyšší HDL-C, sa môžu líšiť adherenciou, telesným zložením, zápalovou záťažou aj komorbiditami. História tejto triedy je navyše práve históriou chybných záverov vyvodených zo zvýšenia HDL-C.</p>

<p>Záver pre prax je preto strohý: <strong>ide o hypotézu hodnú testovania, nie o dôkaz obličkového prínosu.</strong> Potvrdiť by ju musela prospektívna štúdia s vopred určenými obličkovými ukazovateľmi v populácii, ktorá CKD skutočne má.</p>

<h2>Registračný stav v Európskej únii</h2>

<p>Na rozdiel od stavu, ktorý sa často uvádza, obicetrapib už nie je iba skúmanou látkou. Výbor CHMP Európskej liekovej agentúry prijal 23. júla 2026 kladné stanovisko a liek je centralizovane registrovaný v dvoch podobách: <strong>Ubeslo</strong> (obicetrapib 10 mg) a <strong>Evlarco</strong> (fixná kombinácia obicetrapib/ezetimib). Držiteľom registrácie je A. Menarini International Licensing S.A.</p>

<p>Schválená indikácia znie: liečba primárnej hypercholesterolémie alebo zmiešanej dyslipidémie u dospelých ako doplnok k diéte – v kombinácii so statínom u pacientov, ktorí nedosahujú cieľové hodnoty LDL-C, alebo samostatne či s inou liečbou u pacientov netolerujúcich statíny.</p>

<p>Centralizovaná registrácia platí aj pre Slovensko, to však neznamená dostupnosť. Pred predpisovaním treba overiť uvedenie na trh, úhradové podmienky a aktuálne znenie súhrnu charakteristických vlastností lieku vrátane dávkovania pri obličkovej nedostatočnosti. <strong>Obličková indikácia schválená nie je a nemožno ju z registrácie odvodzovať.</strong></p>

<h2>Čo chýba a kedy to budeme vedieť</h2>

<p>Klinický prínos obicetrapibu zatiaľ nie je preukázaný na úrovni príhod. Odpoveď má priniesť výsledková štúdia <strong>PREVAIL</strong> (NCT05202509) u 9 541 pacientov s ASCVD, ktorej primárne ukončenie je naplánované na november 2026. Dovtedy je každé tvrdenie o kardiovaskulárnom prínose extrapoláciou z náhradných ukazovateľov.</p>

<p>Pre nefrologickú populáciu je dôležité, že ani PREVAIL nebude štúdiou pri CKD. Ďalší vývoj zahŕňa štúdiu REMBRANDT (zobrazovanie koronárneho plaku) a RUBENS u pacientov s diabetom 2. typu alebo metabolickým syndrómom – tá sa kardiometabolickému prekryvu približuje najviac, no s primárnym ukončením až v roku 2028 a s počtom 300 účastníkov.</p>

<h2>Čo si z toho odniesť do nefrologickej ambulancie</h2>

<ol>
  <li><strong>Zvyškové riziko pri CKD je reálne a nevysvetlí ho samotný LDL-C.</strong> Pri hodnotení aterogénnej záťaže má preto zmysel merať apoB a aspoň raz za život Lp(a) – oba sú pri CKD informatívnejšie než samotný LDL-C.</li>
  <li><strong>Nedosahovanie cieľov je častejší problém než nedostatok liekov.</strong> Pred úvahou o novej molekule patrí overiť adherenciu, maximalizovať tolerovanú dávku statínu a pridať ezetimib.</li>
  <li><strong>Obicetrapib je registrovaný, no nie pre obličkovú indikáciu.</strong> Je perorálny, čo je oproti injekčným inhibítorom PCSK9 praktická výhoda, ale do rozhodovania vstupuje až po vyčerpaní liečby s doloženým prínosom na príhody.</li>
  <li><strong>Renálny signál nepoužívajte ako argument pri lôžku.</strong> Pochádza z populácie bez choroby obličiek, ide o post hoc analýzu s nominálnymi hodnotami p a zložený obličkový ukazovateľ nedosiahol významnosť.</li>
  <li><strong>Pri dialyzovaných pacientoch neplatí nič z uvedeného.</strong> Gradient prínosu hypolipidemickej liečby so zhoršujúcou sa funkciou obličiek klesá a pre dialyzovaných neexistujú k obicetrapibu nijaké údaje.</li>
</ol>

<h2>Limity</h2>

<p>Tento text je syntézou primárnej literatúry, nie systematickým prehľadom. Všetky tri štúdie fázy 3 financovala spoločnosť NewAmsterdam Pharma a väčšina autorov vrátane autorov obličkovej analýzy má k zadávateľovi vzťah – viacerí sú jeho zamestnancami. Primárne ukazovatele boli náhradné (zmena LDL-C), nie klinické. Dĺžka sledovania 84 dní pre primárny ukazovateľ a 365 dní celkovo je pre posúdenie aterosklerotického prínosu aj dlhodobej bezpečnosti krátka.</p>

<p>Obličková analýza je post hoc, združená z dvoch štúdií s odlišnými populáciami, bez korekcie na mnohonásobné porovnávanie a v kohorte bez CKD. Registračný stav sa môže meniť; uvedené údaje zodpovedajú stavu k 17. októbru 2026 a pred predpisovaním treba overiť aktuálny súhrn charakteristických vlastností lieku a úhradové podmienky.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom a slúži na odborné informovanie. Nenahrádza súhrn charakteristických vlastností lieku, platné odporúčania ani individuálne klinické rozhodnutie. Obicetrapib nemá schválenú obličkovú indikáciu.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Barter PJ, Caulfield M, Eriksson M, Grundy SM, Kastelein JJP, Komajda M, Lopez-Sendon J, Mosca L, Tardif JC, Waters DD, Shear CL, Revkin JH, Buhr KA, Fisher MR, Tall AR, Brewer B; ILLUMINATE Investigators. Effects of torcetrapib in patients at high risk for coronary events. <em>The New England Journal of Medicine</em>. 2007;357(21):2109–2122. DOI: 10.1056/NEJMoa0706628. <a href="https://pubmed.ncbi.nlm.nih.gov/17984165/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1056/NEJMoa0706628" target="_blank" rel="noopener noreferrer">DOI</a>.</li>

  <li>Bowman L, Hopewell JC, Chen F, Wallendszus K, Stevens W, Collins R, Wiviott SD, Cannon CP, Braunwald E, Sammons E, Landray MJ; HPS3/TIMI55–REVEAL Collaborative Group. Effects of anacetrapib in patients with atherosclerotic vascular disease. <em>The New England Journal of Medicine</em>. 2017;377(13):1217–1227. DOI: 10.1056/NEJMoa1706444. <a href="https://pubmed.ncbi.nlm.nih.gov/28847206/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1056/NEJMoa1706444" target="_blank" rel="noopener noreferrer">DOI</a>.</li>

  <li>Nicholls SJ, Nelson AJ, Ditmarsch M, Kastelein JJP, Ballantyne CM, Ray KK, Navar AM, Nissen SE, Goldberg AC, Brunham LR, Wuerdeman E, Neild AL, Kling D, Hsieh A, Butters J, Ference BA, Laufs U, Banach M, Mehran R, Catapano AL, Szarek M, Balinskaite V, Davidson MH. Obicetrapib in patients with heterozygous familial hypercholesterolemia: the BROOKLYN randomized clinical trial. <em>Nature Medicine</em>. 2026;32(3):1052–1060. DOI: 10.1038/s41591-025-04179-4. <a href="https://pubmed.ncbi.nlm.nih.gov/41760952/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1038/s41591-025-04179-4" target="_blank" rel="noopener noreferrer">DOI</a>.</li>

  <li>Nicholls SJ, Nelson AJ, Ditmarsch M, Kastelein JJP, Ballantyne CM, Ray KK, Navar AM, Nissen SE, Harada-Shiba M, Curcio DL, Neild A, Kling D, Hsieh A, Butters J, Ference BA, Laufs U, Banach M, Mehran R, Catapano AL, Huo Y, Szarek M, Balinskaite V, Davidson MH; BROADWAY Investigators. Safety and efficacy of obicetrapib in patients at high cardiovascular risk. <em>The New England Journal of Medicine</em>. 2025;393(1):51–61. DOI: 10.1056/NEJMoa2415820. <a href="https://pubmed.ncbi.nlm.nih.gov/40337982/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1056/NEJMoa2415820" target="_blank" rel="noopener noreferrer">DOI</a>.</li>

  <li>Sarraju A, Brennan D, Hayden K, Stronczek A, Goldberg AC, Michos ED, McGuire DK, Mason D, Tercek G, Nicholls SJ, Kling D, Neild AL, Kastelein J, Davidson M, Ditmarsch M, Nissen SE. Fixed-dose combination of obicetrapib and ezetimibe for LDL cholesterol reduction (TANDEM): a phase 3, randomised, double-blind, placebo-controlled trial. <em>The Lancet</em>. 2025;405(10491):1757–1768. DOI: 10.1016/S0140-6736(25)00721-4. <a href="https://pubmed.ncbi.nlm.nih.gov/40347969/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1016/S0140-6736(25)00721-4" target="_blank" rel="noopener noreferrer">DOI</a>.</li>

  <li>Vogt L, Davidson MH, Szarek M, Kling D, Dicklin MR, Curcio D, Ditmarsch M, Hsieh A, Wicks DL, Ortiz N, Kastelein JJP. Cholesteryl ester transfer protein inhibition with obicetrapib is associated with attenuated decline in kidney function in patients at high cardiovascular risk: post hoc pooled results from the BROADWAY and BROOKLYN trials. <em>American Journal of Preventive Cardiology</em>. 2026;27:101532. DOI: 10.1016/j.ajpc.2026.101532. <a href="https://pubmed.ncbi.nlm.nih.gov/42291065/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1016/j.ajpc.2026.101532" target="_blank" rel="noopener noreferrer">DOI</a> · <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13261266/" target="_blank" rel="noopener noreferrer">Plný text</a>.</li>

  <li>Prajapathi S, Mahajan K, Mohta A, Pradhan A. From failure to promise: obicetrapib and the renaissance of cholesteryl ester transfer protein inhibition in atherosclerotic cardiovascular disease. <em>Journal of the American Heart Association</em>. 2026;15(9):e047676. DOI: 10.1161/JAHA.125.047676. <a href="https://pubmed.ncbi.nlm.nih.gov/42017323/" target="_blank" rel="noopener noreferrer">PubMed</a> · <a href="https://doi.org/10.1161/JAHA.125.047676" target="_blank" rel="noopener noreferrer">DOI</a>.</li>

  <li>Európska lieková agentúra. Ubeslo (obicetrapib) – súhrn EPAR. Kladné stanovisko výboru CHMP z 23. júla 2026. <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/ubeslo" target="_blank" rel="noopener noreferrer">EMA</a>. Evlarco (obicetrapib/ezetimib): <a href="https://www.ema.europa.eu/en/medicines/human/EPAR/evlarco" target="_blank" rel="noopener noreferrer">EMA</a>.</li>

  <li>ClinicalTrials.gov. PREVAIL: cardiovascular outcome study to evaluate the effect of obicetrapib in participants with ASCVD (NCT05202509); 9 541 účastníkov, primárne ukončenie november 2026. <a href="https://clinicaltrials.gov/study/NCT05202509" target="_blank" rel="noopener noreferrer">ClinicalTrials.gov</a>.</li>
</ol>

<h3>Poznámka k dôkazom</h3>

<p>Všetky číselné údaje v texte pochádzajú zo štruktúrovaných abstraktov primárnych publikácií overených v databáze PubMed; úplné autorské zoznamy, ročníky, čísla a strany boli overené položkovo. Registračný stav bol overený priamo na stránkach Európskej liekovej agentúry a údaje o štúdii PREVAIL v registri ClinicalTrials.gov.</p>

<p>Predloha, z ktorej text vychádzal, uvádzala pokles LDL-C v štúdii BROADWAY ako „približne 30 % oproti placebu“; v skutočnosti ide o absolútny pokles 29,9 % a rozdiel oproti placebu 32,6 percentuálneho bodu. Pokles v štúdii TANDEM bol upresnený z „približne 50 %“ na doložených 48,6 %. Zaradenie anacetrapibu medzi molekuly s neutrálnym výsledkom bolo opravené – štúdia REVEAL dosiahla štatisticky významné zníženie veľkých koronárnych príhod. Tvrdenie, že obicetrapib je „terapiou v štádiu vývoja mimo rutinného štandardu“, nezodpovedá súčasnému stavu: liek má centralizovanú európsku registráciu.</p>

<p>Vlastným prínosom tohto spracovania je rozbor nesúladu medzi poklesom LDL-C a apoB, štyri výhrady k obličkovej analýze (populácia bez CKD, veľkosť účinku, nominálne hodnoty p, asociačná povaha súvislosti s HDL-C) a zasadenie do slovenského registračného a nefrologického kontextu.</p>

<h3>Súvisiace články</h3>

<ul>
  <li><a href="article.php?slug=dyslipidemia-ckd-acc-aha-2026-nefrologicka-prax">Dyslipidémia pri chronickej chorobe obličiek: čo z odporúčaní ACC/AHA 2026 mení nefrologickú prax</a></li>
  <li><a href="article.php?slug=statiny-ckd-dialyza-gradient-prinosu-dokazy">Statíny pri CKD a dialýze: gradient prínosu a čo hovoria dôkazy</a></li>
  <li><a href="article.php?slug=lipoprotein-a-kardiovaskularne-riziko-primarna-starostlivost">Lipoproteín(a) a kardiovaskulárne riziko</a></li>
  <li><a href="article.php?slug=nove-odporucania-dyslipidemia-prevent-ldl-ciele">Nové odporúčania pre dyslipidémiu: model PREVENT a cieľové hodnoty LDL</a></li>
  <li><a href="article.php?slug=zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky">Zápal ako terapeutický cieľ pri CKD</a></li>
</ul>
HTML,
];

// ── Vkladanie do databázy ──────────────────────────────────────────────────────

$inserted    = 0;
$updated     = 0;
$skipped     = 0;
$errors      = [];
$queuedTotal = 0;

// UPSERT: re-spustenie skriptu po úprave obsahu prepíše existujúci článok
// (regenerácia). Newsletter avízo sa pošle LEN pri prvom vložení (rc === 1).
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
        // rowCount(): 1 = nový INSERT, 2 = UPDATE existujúceho článku, 0 = bez zmeny.
        $rc = $stmt->rowCount();
        if ($rc === 0) {
            $skipped++;
            continue;
        }

        $articleId = (int) $pdo->lastInsertId();
        if ($articleId === 0) {
            // UPDATE: lastInsertId nemusí vrátiť existujúce id → dohľadaj podľa slug.
            $idStmt = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug");
            $idStmt->execute(['slug' => $a['slug']]);
            $articleId = (int) $idStmt->fetchColumn();
        }

        if ($rc === 1) {
            $inserted++;
            // Newsletter avízo LEN pri novom článku, nikdy pri regenerácii/update.
            try {
                $queuedTotal += enqueueArticleNewsletterEmails($pdo, $articleId);
            } catch (\Throwable $qe) {
                error_log('add_cetp_obicetrapib_2026 newsletter enqueue error: ' . $qe->getMessage());
            }
        } else {
            $updated++;
        }

        // Vygeneruj/preregeneruj PDF verziu článku (bonus na stiahnutie pre prihlásených).
        // Beží len ak je dostupné wkhtmltopdf (na produkčnom serveri áno).
        try {
            $pdfRes = generateArticlePdf($pdo, $a + ['id' => $articleId], true);
            if (!$pdfRes['ok'] && !empty($pdfRes['error'])) {
                error_log('add_cetp_obicetrapib_2026 pdf gen: ' . $pdfRes['error']);
            }
        } catch (\Throwable $pe) {
            error_log('add_cetp_obicetrapib_2026 pdf gen error: ' . $pe->getMessage());
        }
    } catch (\PDOException $e) {
        $errors[] = 'Chyba pri článku „' . htmlspecialchars($a['title']) . '“: ' . $e->getMessage();
        error_log('add_cetp_obicetrapib_2026 migration error: ' . $e->getMessage());
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
