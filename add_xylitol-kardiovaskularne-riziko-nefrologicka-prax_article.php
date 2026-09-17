<?php
/**
 * add_xylitol-kardiovaskularne-riziko-nefrologicka-prax_article.php
 * Idempotentny publikacny skript odborneho clanku.
 * Spracovanie: ESC Congress 2026 (Zheng et al., CLSA + EPIC-Norfolk)
 * a Witkowski et al. (European Heart Journal, 2024).
 */

// Ochrana – len admin alebo CLI
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
    'title'        => 'Xylitol a kardiovaskulárne riziko: čo naozaj ukazujú nové kohortové dáta a čo z toho platí v nefrológii',
    'slug'         => 'xylitol-kardiovaskularne-riziko-nefrologicka-prax',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nová analýza kohort CLSA a EPIC-Norfolk spája vyššie hladiny xylitolu v krvi s vyšším výskytom závažných kardiovaskulárnych udalostí. Ide o zatiaľ nepublikovaný kongresový abstrakt s dôležitými obmedzeniami. Skutočná nefrologická súvislosť xylitolu je pritom iná, než sa zvyčajne uvádza – a týka sa oxalátovej nefropatie.',
    'content'      => <<<'HTML'
<p><strong>Xylitol</strong> (takzvaný „brezový cukor“) je cukrový alkohol – polyol – používaný ako náhrada sacharózy v potravinách, žuvačkách a prostriedkoch ústnej hygieny. Na kongrese Európskej kardiologickej spoločnosti (ESC Congress 2026, Mníchov) boli prezentované údaje, podľa ktorých sú vyššie cirkulujúce hladiny xylitolu spojené s vyšším dlhodobým výskytom závažných nežiaducich kardiovaskulárnych udalostí (major adverse cardiovascular events, MACE) v bežnej populácii.</p>

<p>Téma si zaslúži presné zaobchádzanie, pretože v mediálnych zhrnutiach sa opakovane miešajú <strong>dve rozdielne štúdie</strong> s odlišnými počtami účastníkov, odlišným rozdelením expozície aj odlišnou dĺžkou sledovania. Tento text ich preto oddeľuje a osobitne pomenúva, čo z nich pre nefrologickú prax vyplýva a čo nie.</p>

<h2>Dve štúdie, ktoré sa nesmú zamieňať</h2>

<p>Prvou je <strong>pôvodná práca z roku 2024</strong> publikovaná v časopise <em>European Heart Journal</em> (Witkowski a kol., Cleveland Clinic). Druhou je <strong>nová analýza prezentovaná na ESC Congress 2026</strong> (prvý autor T. M. Zheng, McGill University; prezentujúci Marco Witkowski, Charité, Berlín), ktorá zatiaľ existuje len ako kongresový abstrakt.</p>

<div class="table-responsive" role="region" aria-label="Porovnanie oboch štúdií o xylitole" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Parameter</th>
      <th scope="col">European Heart Journal 2024</th>
      <th scope="col">ESC Congress 2026 (abstrakt)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Populácia</th>
      <td>Pacienti odoslaní na elektívne kardiologické vyšetrenie (vysoké riziko)</td>
      <td>Bežná populácia (CLSA, EPIC-Norfolk)</td>
    </tr>
    <tr>
      <th scope="row">Počet účastníkov</th>
      <td>1 157 (objavná kohorta) + 2 149 (validačná kohorta)</td>
      <td>17 710 spolu (CLSA 7 651; EPIC-Norfolk 10 059)</td>
    </tr>
    <tr>
      <th scope="row">Sledovanie</th>
      <td>3 roky</td>
      <td>6 rokov (CLSA); 30 rokov (EPIC-Norfolk)</td>
    </tr>
    <tr>
      <th scope="row">Rozdelenie expozície</th>
      <td><strong>Tercily</strong> (3. verzus 1.)</td>
      <td><strong>Kvartily</strong> (Q4 verzus Q1)</td>
    </tr>
    <tr>
      <th scope="row">Hlavný výsledok</th>
      <td>Upravený HR 1,57 (95 % IS 1,12–2,21); <em>P</em> &lt; 0,01</td>
      <td>CLSA: upravený HR 1,47; EPIC-Norfolk: upravený HR 1,18</td>
    </tr>
    <tr>
      <th scope="row">Stav publikácie</th>
      <td>Recenzovaná publikácia (PMID 38842092)</td>
      <td>Zatiaľ len abstrakt; recenzovaná publikácia nie je dostupná</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rozlíšenie nie je akademická pedantéria. Hodnota <strong>HR 1,57</strong> pochádza z práce z roku 2024, z <em>tercilového</em> porovnania u <em>vysokorizikových</em> pacientov počas <em>3 rokov</em>. Ak sa táto hodnota uvádza ako výsledok kohorty CLSA, ide o zámenu.</p>

<h2>Nezrovnalosť v číslach, ktorú treba priznať</h2>

<p>Pri kohorte CLSA sa v dostupných sekundárnych zdrojoch objavujú <strong>dve rôzne hodnoty</strong>. Tlačová správa ESC uvádza „o 57 % vyššie riziko“, zatiaľ čo agentúrne spracovanie abstraktu (HealthDay) uvádza <strong>upravený HR 1,47</strong>, teda o 47 %. Pri kohorte EPIC-Norfolk sa obe hodnoty zhodujú (HR 1,18; teda o 18 %).</p>

<p>Bez plného textu abstraktu alebo recenzovanej publikácie nie je možné rozhodnúť, ktorá hodnota pre kohortu CLSA je správna. Je pravdepodobné, že ide o prenos čísla 1,57 z práce z roku 2024. Do času, kým bude práca publikovaná v plnom znení, je preto vecne správne uvádzať <strong>rádovo 45 – 60 % relatívne zvýšenie v kohorte CLSA</strong> a výslovne označiť tento údaj za predbežný.</p>

<p>Na doplnenie kontextu: v kohorte CLSA bolo zaznamenaných 2 950 udalostí MACE, v kohorte EPIC-Norfolk 5 670. Kompozitný ukazovateľ MACE bol definovaný ako <strong>úmrtie, infarkt myokardu alebo cievna mozgová príhoda</strong>. Zahrnutie celkovej mortality do kompozitu je metodicky podstatné – časť signálu môže pochádzať z nekardiovaskulárnych úmrtí.</p>

<h2>Prečo „veľká nemecká štúdia“ nie je presné označenie</h2>

<p>Niektoré zdroje označujú prácu ako nemeckú. Kohorty sú však <strong>kanadská</strong> (Canadian Longitudinal Study on Aging) a <strong>britská</strong> (European Prospective Investigation into Cancer – Norfolk), prvý autor pôsobí v Montreale a nemecké je pracovisko prezentujúceho autora. Ide teda o kanadsko-britské údaje prezentované berlínskym autorom.</p>

<h2>Biologická vierohodnosť: polyoly a krvné doštičky</h2>

<p>Pôvodná práca z roku 2024 nebola len observačná. Obsahovala aj mechanistickú časť, ktorá ukázala, že xylitol pri koncentráciách zodpovedajúcich hladinám nameraným nalačno <strong>zosilňuje viaceré ukazovatele reaktivity krvných doštičiek</strong> a podporuje tvorbu trombu <em>in vivo</em> v zvieracom modeli. V intervenčnej časti u <strong>10 zdravých dobrovoľníkov</strong> viedlo vypitie nápoja sladeného xylitolom k výraznému vzostupu plazmatických hladín a k zosilneniu funkčných ukazovateľov reaktivity doštičiek u všetkých sledovaných osôb.</p>

<p>Tento nález nestojí osamotene. Tá istá skupina publikovala v roku 2023 v časopise <em>Nature Medicine</em> obdobné zistenia pre <strong>erytritol</strong>, s ešte výraznejšími odhadmi rizika (štvrtý verzus prvý kvartil: upravený HR 1,80 v americkej a 2,21 v európskej validačnej kohorte). Signál sa teda javí skôr ako <strong>možný efekt triedy polyolov</strong> než ako vlastnosť jedinej molekuly.</p>

<p>Mechanistické dáta zvyšujú dôveryhodnosť asociácie, ale samy osebe nedokazujú, že bežná konzumácia xylitolu spôsobuje MACE. Intervenčná časť mala 10 účastníkov a sledovala náhradné ukazovatele (biomarkery a funkčné testy doštičiek), nie klinické príhody.</p>

<h2>Kľúčové obmedzenie, ktoré sa v zhrnutiach stráca</h2>

<p>Xylitol vzniká aj <strong>endogénne</strong> – podľa pôvodnej práce však v koncentráciách viac než <strong>1 000-násobne nižších</strong>, než aké sa dosahujú po konzumácii xylitolu ako náhrady cukru. Z toho vyplýva zásadná interpretačná otázka: <strong>čo vlastne nameraná hladina v krvi odráža?</strong></p>

<ul>
  <li>Môže ísť o <strong>marker expozície</strong>, teda o skutočnú konzumáciu xylitolu v strave.</li>
  <li>Môže ísť o <strong>marker metabolického stavu</strong> – endogénna tvorba polyolov súvisí s aktivitou polyolovej dráhy, ktorá je zvýšená pri hyperglykémii. Vyššia hladina by potom mohla byť skôr <em>dôsledkom</em> zhoršenej metabolickej kontroly než jej príčinou.</li>
  <li>Môže ísť o <strong>marker stravovacieho vzorca</strong> – vysoko spracované potraviny „bez cukru“ sa konzumujú spolu s inými zložkami, ktoré samy nesú riziko.</li>
</ul>

<p>Žiadna z prezentovaných analýz neuvádza samostatne hodnotený príjem xylitolu z potravy. Reziduálne skreslenie aj obrátená kauzalita preto zostávajú otvorené. Autori aj komentátori ESC to výslovne priznávajú – člen komunikačnej komisie ESC Dan Atar k práci uviedol, že pri observačných štúdiách sa kauzalita vyvodzuje ťažko a že sú potrebné ďalšie štúdie.</p>

<h2>Odporúčanie WHO sa na xylitol nevzťahuje</h2>

<p>V súvislosti s touto témou sa často cituje odporúčanie <strong>Svetovej zdravotníckej organizácie z mája 2023</strong>, podľa ktorého sa nemajú používať nesacharidové sladidlá na reguláciu hmotnosti ani na prevenciu neprenosných ochorení. Toto odporúčanie sa však na xylitol <strong>nevzťahuje</strong>.</p>

<p>WHO v texte odporúčania výslovne uvádza, že sa netýka nízkokalorických cukrov a <strong>cukrových alkoholov (polyolov)</strong>, pretože ide o cukry alebo ich deriváty s obsahom kalórií, ktoré sa preto za nesacharidové sladidlá nepovažujú. Xylitol, erytritol aj sorbitol sú z pôsobnosti odporúčania vylúčené rovnako ako sladidlá v zubných pastách a v liekoch.</p>

<p>Citovanie odporúčania WHO na podporu opatrnosti voči xylitolu je teda vecne nesprávne. Opatrnosť treba oprieť o dáta o xylitole samotnom, nie o dokument, ktorý ho výslovne nezahŕňa.</p>

<h2>Skutočná nefrologická súvislosť: oxalátová nefropatia</h2>

<p>Býva zvykom uvádzať, že xylitol nemá priamu nefrologickú relevanciu a že s obličkami súvisí len nepriamo, cez kardiovaskulárne riziko. To nie je presné. Xylitol má <strong>dobre zdokumentovanú priamu renálnu toxicitu</strong> – nie však pri bežnom perorálnom príjme, ale pri <strong>parenterálnom podaní</strong>.</p>

<p>Xylitol sa v minulosti používal ako náhrada glukózy v parenterálnej výžive. Jeho metabolizmus vedie k tvorbe <strong>oxalátu</strong> a pri vyšších dávkach k sekundárnej oxalóze s ukladaním kryštálov oxalátu vápenatého v obličkových tubuloch:</p>

<ul>
  <li>Opísaný je prípad 61-ročného muža, u ktorého po pooperačnom podaní parenterálneho xylitolu (kumulatívna dávka 1 560 g) vzniklo akútne poškodenie obličiek vyžadujúce opakovanú hemodialýzu, s biopticky potvrdenou renálnou oxalózou a s epileptickým záchvatom pri cerebrovaskulárnych depozitoch oxalátu.</li>
  <li>Opísané je aj <strong>smrteľné cerebro-renálne oxalózne postihnutie</strong> u 24-ročného muža po apendektómii, dva dni po prvej infúzii xylitolu.</li>
  <li>Samostatnou situáciou je podanie xylitolu pacientovi s dovtedy nerozpoznanou <strong>primárnou hyperoxalúriou 1. typu</strong>, kde infúzia odmaskovala základné ochorenie a viedla k trvalej dialyzačnej liečbe.</li>
</ul>

<p>Parenterálne podanie xylitolu je preto v Spojených štátoch zakázané a v literatúre zaznelo odporúčanie vyradiť ho z klinickej praxe ako náhradu cukru pri infúznej liečbe. Pre nefrológa je podstatné, že <strong>ide o toxicitu viazanú na infúzne dávky rádovo v stovkách gramov</strong>, nie na žuvačku či zubnú pastu. Zámena týchto dvoch situácií v rozhovore s pacientom by bola vecnou chybou.</p>

<h2>Čo z toho vyplýva pre pacientov s chronickou chorobou obličiek</h2>

<p>Pacienti s chronickou chorobou obličiek (CKD) majú kardiovaskulárne riziko výrazne vyššie než bežná populácia a kardiovaskulárne príhody sú u nich najčastejšou príčinou úmrtia. Pri vyššom absolútnom riziku sa aj mierne relatívne zvýšenie prejaví väčším počtom udalostí. To je argument pre opatrnosť, nie pre zákaz.</p>

<p>Praktické závery, ktoré dnešný dôkazový základ unesie:</p>

<ul>
  <li><strong>Neodporúčať xylitol ako zdravotný prínos.</strong> Náhrada cukru polyolom nie je automaticky prospešná a dnes ju nemožno prezentovať ako kardiovaskulárne neutrálnu.</li>
  <li><strong>Nevyžadovať plošné vysadenie.</strong> Dáta nepodporujú tvrdenie, že bežné množstvá xylitolu v žuvačke alebo v zubnej paste spôsobujú infarkt či cievnu mozgovú príhodu.</li>
  <li><strong>Všímať si veľkosť dávky.</strong> Klinicky relevantná otázka nie je „používate xylitol?“, ale „koľko ho denne prijímate?“. Pravidelné pridávanie xylitolu do nápojov a do pečenia v desiatkach gramov denne je iná situácia než žuvačka po jedle.</li>
  <li><strong>Riešiť celkovú stratégiu, nie jednu molekulu.</strong> Ak je cieľom obmedziť príjem cukru, dôkazovo najsilnejším riešením zostáva zníženie celkovej sladkej chuti, nie výmena jednej sladkej látky za druhú.</li>
  <li><strong>Nezabudnúť na znášanlivosť v tráviacom trakte.</strong> Xylitol má pri vyšších dávkach osmotický laxatívny účinok, ktorý môže u pacienta s CKD a súbežnou diuretickou liečbou prispieť k objemovej deplécii.</li>
</ul>

<h2>Ako o tom hovoriť s pacientom</h2>

<p>Formulácia rozhoduje o tom, či pacient odíde informovaný, alebo vystrašený. Osvedčené vetné rámce:</p>

<ul>
  <li>„Nové údaje naznačujú, že ľudia s vyššími hladinami xylitolu v krvi mali viac srdcovo-cievnych príhod. Nie je to dôkaz, že xylitol tie príhody spôsobil.“</li>
  <li>„Štúdia merala hladinu v krvi, nie to, koľko xylitolu ľudia zjedli. Vyššia hladina môže odrážať aj iné veci – napríklad metabolický stav.“</li>
  <li>„Malé množstvá v žuvačke alebo v zubnej paste nie sú dôvod na paniku. Ak ho však pridávate denne po lyžiciach, má zmysel množstvo prehodnotiť.“</li>
  <li>„Vzhľadom na vaše obličky a srdcové riziko by som vám xylitol neodporúčal ako náhradu cukru s istotou, že je neutrálna. Radšej sa zamerajme na celkové množstvo sladkého.“</li>
</ul>

<p>Okrajová, ale v praxi často kladená otázka: xylitol je <strong>silne toxický pre psy</strong> (ťažká hypoglykémia a poškodenie pečene). Pre domácnosti so psom ide o relevantnú informáciu bez ohľadu na kardiovaskulárnu diskusiu.</p>

<h2>Limity, ktoré musia zaznieť pri každej interpretácii</h2>

<ul>
  <li>Údaje z ESC Congress 2026 sú <strong>kongresový abstrakt</strong>, nie recenzovaná publikácia; čísla sa v konečnej verzii môžu zmeniť.</li>
  <li>Ide o <strong>observačné kohorty</strong> – preukazujú asociáciu, nie príčinnú súvislosť.</li>
  <li>Expozícia bola meraná ako <strong>hladina v krvi</strong>, nie ako príjem v strave; vzťah medzi oboma nie je v analýze kvantifikovaný.</li>
  <li>Hodnota pre kohortu CLSA sa v dostupných zdrojoch <strong>rozchádza</strong> (HR 1,47 verzus „o 57 %“).</li>
  <li>Kompozit MACE zahŕňa <strong>celkovú mortalitu</strong>, čo môže signál zosilniť aj z nekardiovaskulárnych príčin.</li>
  <li>Obe kohorty boli zložené prevažne z osôb <strong>európskeho pôvodu a vyššieho veku</strong>; prenositeľnosť na iné populácie je obmedzená.</li>
  <li>Mechanistické dáta sú <strong>podporné, nie rozhodujúce</strong>; intervenčná časť mala 10 účastníkov a hodnotila náhradné ukazovatele.</li>
</ul>

<h2>Záver</h2>

<p>Signál spájajúci cirkulujúci xylitol s vyšším výskytom MACE je konzistentný naprieč dvoma nezávislými súbormi kohort, má biologicky vierohodný mechanizmus cez reaktivitu krvných doštičiek a zapadá do širšieho obrazu pozorovaného aj pri erytritole. Zároveň však ide o observačné dáta s nevyriešenou otázkou, či nameraná hladina odráža príjem, alebo metabolický stav, a hlavný nový súbor údajov zatiaľ neprešiel recenzným konaním.</p>

<p>Pre nefrologickú prax z toho vyplýva zdržanlivé, nie reštriktívne stanovisko: xylitol nepropagovať ako bezpečnú alternatívu, sledovať celkové množstvo a u pacientov s vysokým kardiovaskulárnym rizikom uprednostniť zníženie sladkej chuti pred výmenou sladidla. Priamu renálnu toxicitu xylitolu pritom treba viazať výhradne na parenterálne podanie a oxalátovú nefropatiu – nie na bežný perorálny príjem.</p>

<h2>Súvisiace články na portáli</h2>

<ul>
  <li><a href="article.php?slug=alternativne-sladidla-masld-ckd-inkretinova-liecba">Sladidlá pri MASLD, CKD a inkretínovej liečbe: dôkazy a neistoty</a></li>
  <li><a href="article.php?slug=antitromboticka-liecba-faktor-xi-bezpecnejsia-prevencia">Nové prístupy v antitrombotickej liečbe: od „dobrých“ a „zlých“ zrazenín k bezpečnejšej prevencii</a></li>
  <li><a href="article.php?slug=dyslipidemia-2026-kardiovaskularne-riziko-ldl-ciele-ckd">Dyslipidémia v roku 2026: kardiovaskulárne riziko a ciele LDL cholesterolu pri CKD</a></li>
  <li><a href="article.php?slug=vyzivove-odporucania-usa-2025-2030-masld-ckd">Americké výživové odporúčania 2025–2030: riziko nesprávnej interpretácie pri MASLD a CKD</a></li>
  <li><a href="article.php?slug=zapal-terapeuticky-ciel-ckd-renalne-kardiovaskularne-vysledky">Zápal pri chronickej chorobe obličiek: od rizikového biomarkera k liečebnému cieľu</a></li>
</ul>

<hr>

<p><em><strong>Zdroje:</strong></em></p>

<ol>
  <li><em>Zheng TM a kol. The association of Xylitol and incident cardiovascular events: the CLSA and EPIC-Norfolk cohort studies. Prezentované na ESC Congress 2026, Mníchov (tlačová správa ESC z 26. augusta 2026). <a href="https://www.escardio.org/news/press/press-releases/xylitol-may-increase-the-risk-of-cardiovascular-events/" target="_blank" rel="noopener noreferrer">Tlačová správa ESC</a>. Kongresový abstrakt; recenzovaná publikácia zatiaľ nie je dostupná.</em></li>
  <li><em>Witkowski M, Nemet I, Li XS, Wilcox J, Ferrell M, Alamri H, Gupta N, Wang Z, Tang WHW, Hazen SL. Xylitol is prothrombotic and associated with cardiovascular risk. European Heart Journal. 2024;45(27):2439–2452. doi:10.1093/eurheartj/ehae244. PMID 38842092. <a href="https://doi.org/10.1093/eurheartj/ehae244" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38842092/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Witkowski M, Nemet I, Alamri H a kol. The artificial sweetener erythritol and cardiovascular event risk. Nature Medicine. 2023;29(3):710–718. doi:10.1038/s41591-023-02223-9. PMID 36849732. <a href="https://doi.org/10.1038/s41591-023-02223-9" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/36849732/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>World Health Organization. WHO advises not to use non-sugar sweeteners for weight control in newly released guideline. 15. mája 2023. <a href="https://www.who.int/news/item/15-05-2023-who-advises-not-to-use-non-sugar-sweeteners-for-weight-control-in-newly-released-guideline" target="_blank" rel="noopener noreferrer">who.int</a>. (Odporúčanie sa výslovne nevzťahuje na cukrové alkoholy – polyoly.)</em></li>
  <li><em>Leidig P, Gerding W, Arns W, Ortmann M. [Renal oxalosis with renal failure after infusion of xylitol]. Deutsche Medizinische Wochenschrift. 2001;126(48):1357–1360. doi:10.1055/s-2001-18650. PMID 11727161. <a href="https://doi.org/10.1055/s-2001-18650" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/11727161/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Pfeiffer H, Weiss FU, Karger B, Aghdassi A, Lerch MM, Brinkmann B. Fatal cerebro-renal oxalosis after appendectomy. International Journal of Legal Medicine. 2004;118(2):98–100. doi:10.1007/s00414-003-0414-3. PMID 14634832. <a href="https://doi.org/10.1007/s00414-003-0414-3" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/14634832/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Meier M, Nitschke M, Perras B, Steinhoff J. Ethylene glycol intoxication and xylitol infusion – metabolic steps of oxalate-induced acute renal failure. Clinical Nephrology. 2005;63(3):225–228. doi:10.5414/cnp63225. PMID 15786825. <a href="https://doi.org/10.5414/cnp63225" target="_blank" rel="noopener noreferrer">DOI</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/15786825/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
</ol>

<p><small>Bibliografické údaje boli overené v databáze PubMed. Odborný text bol vecne a jazykovo revidovaný 17. septembra 2026. Údaje prezentované na ESC Congress 2026 nie sú recenzovanou publikáciou a v konečnej verzii sa môžu zmeniť. Text nenahrádza individuálne klinické rozhodnutie ani odborné výživové poradenstvo.</small></p>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_xylitol_kardiovaskularne_riziko_nefrologia',
]);

$inserted    = $result['inserted'];
$updated     = $result['updated'];
$skipped     = $result['skipped'];
$queuedTotal = $result['queued'];
$errors      = $result['errors'];
$total       = count($articles);

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
