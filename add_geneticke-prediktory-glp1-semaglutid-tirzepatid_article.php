<?php
/**
 * add_geneticke-prediktory-glp1-semaglutid-tirzepatid_article.php
 * Idempotentný UPSERT skript pre vecne a jazykovo korigovaný odborný článok
 * o genetických prediktoroch odpovede na semaglutid a tirzepatid.
 * Pôvodní autori zdrojovej štúdie musia byť evidovaní aj v source_authors.php.
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
    'title'        => 'Genetické prediktory odpovede na semaglutid a tirzepatid: prísľub a limity pre nefrologickú prax',
    'slug'         => 'geneticke-prediktory-glp1-semaglutid-tirzepatid',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => '2026-07-21 20:45:00',
    'is_top'       => 0,
    'excerpt'      => 'Veľká štúdia 23andMe spojila varianty GLP1R a GIPR s úbytkom hmotnosti, nauzeou a vracaním pri semaglutide a tirzepatide. Účinky sú však malé a zatiaľ neopodstatňujú liečbu podľa genotypu.',
    'content'      => <<<'HTML'
<p>Myšlienka, že genetický test pred začatím liečby predpovie úbytok hmotnosti alebo gastrointestinálne nežiaduce účinky semaglutidu a tirzepatidu, je klinicky príťažlivá. Priložený text spoločnosti 23andMe ju však predstavuje súčasne ako vedeckú novinku aj ako podporu vlastného komerčného produktu. Vecné posúdenie preto musí vychádzať predovšetkým z pôvodnej práce publikovanej v časopise <em>Nature</em>, nie z jej marketingovej interpretácie.</p>

<p>Štúdia priniesla biologicky vierohodné a štatisticky presvedčivé asociácie v génoch <em>GLP1R</em> a <em>GIPR</em>. Ich účinky na úbytok hmotnosti boli malé, väčšina údajov pochádzala zo sebahlásenia a predikčné modely neboli overené v prospektívnej štúdii liečby riadenej genotypom. Výsledky preto zatiaľ neopodstatňujú rutinné farmakogenetické testovanie, výber medzi semaglutidom a tirzepatidom, zmenu dávky ani rýchlosti titrácie podľa týchto variantov.</p>

<h2>Čo autori skúmali</h2>

<p>Výskumníci oslovili zákazníkov 23andMe, ktorí predtým uviedli, že užívali liek na predpis na zníženie hmotnosti. Dotazník spustený v auguste 2024 zisťoval použitý prípravok, dávku, dĺžku liečby, hmotnosť pred liečbou a počas nej, nežiaduce účinky a dôvody začatia alebo ukončenia liečby. Do augusta 2025 odpovedalo 27 885 účastníkov, ktorí uviedli semaglutid alebo tirzepatid vrátane ich individuálne pripravovaných, neschválených verzií. Autori následne vykonali celogenómovú asociačnú štúdiu (GWAS) odpovede na liečbu.</p>

<p>Semaglutid je agonista receptora pre glukagónu podobný peptid 1 (GLP-1). Tirzepatid je duálny agonista receptorov pre GLP-1 a glukózodependentný inzulínotropný polypeptid (GIP). Označenie všetkých skúmaných prípravkov ako „GLP-1 liekov“ je preto praktická skratka, nie úplne presná farmakologická klasifikácia.</p>

<div class="table-responsive" role="region" aria-label="Čo autori skúmali" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Charakteristika súboru</th>
      <th scope="col">Hodnota</th>
      <th scope="col">Interpretačný význam</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Počet respondentov</td>
      <td>27 885</td>
      <td>Celý dotazníkový súbor, nie veľkosť hlavnej GWAS účinnosti</td>
    </tr>
    <tr>
      <td>Ženy</td>
      <td>82,4 %</td>
      <td>Výrazná pohlavná nerovnováha obmedzuje zovšeobecnenie</td>
    </tr>
    <tr>
      <td>Medián veku</td>
      <td>52 rokov</td>
      <td>Nešlo o náhodnú vzorku všeobecnej populácie</td>
    </tr>
    <tr>
      <td>Európsky genetický pôvod</td>
      <td>78,3 %</td>
      <td>Objavová GWAS sa vykonala v populácii európskeho pôvodu</td>
    </tr>
    <tr>
      <td>Východiskový index telesnej hmotnosti (BMI)</td>
      <td>medián 35,1 kg/m²</td>
      <td>Prevažovali osoby s obezitou</td>
    </tr>
    <tr>
      <td>Dĺžka liečby</td>
      <td>medián 8,3 mesiaca</td>
      <td>Nešlo o jednotne stanovený jednoročný horizont</td>
    </tr>
    <tr>
      <td>Sebahlásený úbytok</td>
      <td>medián 11,3 kg; 11,7 % hmotnosti</td>
      <td>Hodnoty neboli u väčšiny účastníkov objektívne zmerané</td>
    </tr>
  </tbody>
</table>
</div>

<p>Genotypizácia vychádzala zo vzoriek slín a z imputovaných genetických údajov. Po vylúčení účastníkov s neúplnými údajmi, po kontrole kvality a odstránení blízko príbuzných zahŕňala hlavná GWAS percentuálnej zmeny BMI 15 237 účastníkov európskeho genetického pôvodu. Číslo 27 885 preto nemožno bez spresnenia uvádzať ako veľkosť každej genetickej analýzy.</p>

<h2>Sebahlásenie a zdravotná dokumentácia sa zhodovali iba čiastočne</h2>

<p>Elektronické zdravotné záznamy sprístupnilo cez Apple HealthKit 909 účastníkov; 195 z nich zároveň vyplnilo dotazník. Typ lieku sa potvrdil pomerne dobre: záznam podporoval sebahlásený semaglutid u 97,6 % a tirzepatid u 85,7 % príslušných účastníkov. Presná dávka sa však zhodovala iba u 58,4 % používateľov semaglutidu a 64,3 % používateľov tirzepatidu.</p>

<p>Rozdiel v úbytku hmotnosti bol podstatný. V celom súbore so zdravotnými záznamami bol medián zmeny BMI −5,79 %, kým v dotazníkovom súbore −11,8 %. Aj u tých istých 195 ľudí zostala zmena väčšia pri sebahlásení než v zázname: −14,14 % oproti −8,43 %. Korelácia bola iba stredná (<em>r</em> = 0,57). Časť rozdielu môže súvisieť s neúplnosťou zdravotných záznamov, no údaje zároveň upozorňujú na možnú chybu pamäti, výberu merania a sebahlásenia.</p>

<p>Účastníci uvádzali väčší úbytok BMI pri tirzepatide než pri semaglutide. Keďže však liek nebol pridelený náhodne a skupiny mohli mať odlišné dávky, indikácie, adherenciu, prístup k liečbe a ďalšie charakteristiky, táto štúdia nie je priamym randomizovaným porovnaním účinnosti oboch liekov.</p>

<h2>Variant GLP1R a úbytok hmotnosti</h2>

<p>Najsilnejším signálom účinnosti bol variant <strong>rs10305420</strong> v géne <em>GLP1R</em>. Alela T mení siedmu aminokyselinu signálneho peptidu receptora z prolínu na leucín (p.Pro7Leu). Každá kópia alely T bola spojená s približne o 0,641 percentuálneho bodu väčším znížením BMI, čo autori prepočítali na priemerne o 0,76 kg väčší úbytok hmotnosti na alelu (95 % interval spoľahlivosti približne 0,34–1,27 kg; <em>P</em> = 2,9 × 10<sup>−10</sup>).</p>

<p>Štatistická istota asociácie je vysoká, klinická veľkosť účinku však zostáva malá v porovnaní s celkovou variabilitou odpovede. Navyše ani jemné mapovanie nedokázalo kauzálny variant jednoznačne určiť. V 99 % vierohodnostnom súbore bolo 42 variantov; rs10305420 bol jediný kódujúci variant a dosiahol najvyššiu pravdepodobnosť príčinnosti, 35 %. Je preto pravdepodobným, nie dokázaným kauzálnym variantom.</p>

<p>Asociácia sa potvrdila v kohorte All of Us s elektronickými zdravotnými záznamami 4 855 ľudí (<em>P</em> = 0,001; účinok −0,47 percentuálneho bodu). V UK Biobank sa nepotvrdila, pričom autori uvádzajú nízku štatistickú silu a použitie starších agonistov receptora GLP-1. V jednotlivých neeurópskych skupinách variant nedosiahol vopred zvolenú hladinu <em>P</em> &lt; 0,001, hoci smer odhadu bol konzistentný. Prenositeľnosť na rozmanité populácie preto zostáva nedostatočne overená.</p>

<h2>GLP1R, GIPR a gastrointestinálne nežiaduce účinky</h2>

<p>Autori porovnávali stredne závažné až závažné nežiaduce účinky s miernymi alebo neprítomnými ťažkosťami. Pri nauzee a vracaní identifikovali ďalšie signály v oblasti <em>GLP1R</em>; OR označuje pomer šancí:</p>

<ul>
  <li><strong>rs9357296:</strong> alela G bola spojená s vyšším pomerom šancí na nauzeu (OR 1,36; <em>P</em> = 2,6 × 10<sup>−28</sup>),</li>
  <li><strong>rs11760106:</strong> alela T bola spojená s vyšším pomerom šancí na vracanie (OR 1,57; <em>P</em> = 2,5 × 10<sup>−27</sup>).</li>
</ul>

<p>Je dôležité opraviť zjednodušenie v propagačnom texte: indexový variant úbytku hmotnosti a indexové varianty nauzey či vracania <strong>nie sú totožné</strong>. Nachádzajú sa v tej istej génovej oblasti a sú vo väzbovej nerovnováhe. Kolokalizačná analýza naznačila, že signály môžu mať spoločný kauzálny podklad, ale neurčila ho s istotou. Z výsledku nemožno vyvodiť, že vyvolanie nauzey spôsobí lepší liečebný účinok alebo že gastrointestinálne ťažkosti treba tolerovať za každú cenu.</p>

<p>U používateľov tirzepatidu sa navyše našla asociácia vracania s oblasťou <em>GIPR</em>. Indexový variant rs71338792 mal OR 1,84. Bol v takmer úplnej väzbovej nerovnováhe (<em>r</em><sup>2</sup> = 0,99) s variantom <strong>rs1800437</strong>, ktorý vedie k zámene p.Glu354Gln. Alela C zodpovedajúca glutamínu bola spojená s približne 1,83-násobným pomerom šancí na vracanie oproti ochrannej alele G. Pri semaglutide sa tento účinok nepozoroval, čo je biologicky zlučiteľné s tým, že semaglutid receptor GIP neaktivuje.</p>

<p>Autori navrhujú, že čiastočná strata funkcie receptora GIP môže oslabiť tlmiaci účinok zložky GIP na averzívne prejavy stimulácie GLP-1. Ide však o mechanistickú hypotézu podporenú predklinickými údajmi, nie o priamo dokázaný mechanizmus u liečených pacientov.</p>

<h2>Predikčný model ešte nie je klinický test</h2>

<p>Model z veku, pohlavia, východiskového BMI, typu lieku, dávky a trvania liečby vysvetlil 21,4 % variability percentuálnej zmeny BMI. Rozšírený model, ktorý zahŕňal aj diagnózy, vzdelanie ako zástupný ukazovateľ sociálno-ekonomického postavenia a genetické varianty, vysvetlil 25 % variability v trénovacom aj vyčlenenom testovacom súbore. Väčšinu vysvetlenej variability tvorili negenetické faktory. Rozdiel 3,6 percentuálneho bodu nemožno automaticky pripísať iba genetike, pretože oba modely nemali úplne rovnaký súbor ostatných premenných.</p>

<p>Hodnota R² = 0,25 znamená, že približne tri štvrtiny variability v skúmanom súbore zostali nevysvetlené. Neznamená „25 % presnosť“ pre konkrétneho pacienta. Modely nauzey a vracania dosiahli v testovacom súbore plochu pod krivkou ROC 0,654 a 0,680. Takéto rozlíšenie je výskumne zaujímavé, ale samo osebe nedokazuje dostatočný čistý klinický prínos, vhodný rozhodovací prah ani bezpečnosť používania.</p>

<p>Model účinnosti autori aplikovali aj na 642 ľudí so zdravotnými záznamami, ktorí sa nezúčastnili dotazníka. Keďže pred liečbou nepoznali budúci typ lieku, konečnú dávku ani trvanie liečby, dosadili pre všetkých ľubovoľnú konštantu. Model rozdelil skupiny s odlišným následným úbytkom hmotnosti, nejde však o prospektívne overenie, že rozhodovanie podľa modelu zlepší výsledky oproti štandardnej starostlivosti.</p>

<p>Rozsahy predikcie uvádzané v komerčnom nástroji 23andMe – odhad úbytku hmotnosti 6 až 20 % a rizika nauzey alebo vracania 5 až 78 % – nie sú samostatným výsledkom klinickej validačnej štúdie opísanej v publikácii. Kým nebude nástroj externe a prospektívne overený vrátane kalibrácie, rozhodovacích prahov a klinického prínosu, nemožno tieto čísla považovať za spoľahlivú individuálnu prognózu.</p>

<h2>Čo výsledky znamenajú pre nefrológiu</h2>

<p>Obezita a diabetes 2. typu sú v nefrologickej praxi časté a inkretínová liečba môže byť súčasťou komplexného kardiometabolického manažmentu. Táto konkrétna štúdia však <strong>nehodnotila eGFR, albuminúriu, akútne poškodenie obličiek, zlyhanie obličiek ani kardiovaskulárne udalosti</strong>. Neuvádza ani samostatnú validáciu u pacientov s CKD alebo pri dialýze. Zistené varianty preto nemožno interpretovať ako prediktory nefroprotekcie.</p>

<p>Nefrologicky relevantný je najmä bezpečnostný kontext nauzey, vracania a hnačky. Regulačné informácie o semaglutide a tirzepatide upozorňujú, že gastrointestinálne nežiaduce reakcie môžu viesť k objemovej deplécii a k zhoršeniu funkcie obličiek; pri takýchto ťažkostiach odporúčajú sledovať funkciu obličiek. U pacienta s CKD, najmä pri súbežnej diuretickej alebo hemodynamicky aktívnej liečbe, si pretrvávajúce vracanie, hnačka alebo výrazne znížený príjem tekutín vyžadujú včasné klinické zhodnotenie hydratácie, krvného tlaku, elektrolytov a funkcie obličiek.</p>

<p>Genetická asociácia nemení tento praktický postup. Neprítomnosť sledovanej rizikovej alely nevylučuje závažné nežiaduce účinky a jej prítomnosť neznamená, že pacient ťažkosti určite dostane. Klinické sledovanie znášanlivosti zostáva dôležitejšie než izolovaný variant.</p>

<h2>Silné stránky a limity</h2>

<p>Silnými stránkami sú veľký počet účastníkov, celogenómový prístup, biologická vierohodnosť nálezov v priamych cieľoch liekov, replikácia hlavného variantu účinnosti v All of Us, vyčlenený testovací súbor a verejne dostupné doplnkové materiály vrátane recenzných posudkov. Zdravotné záznamy zároveň aspoň čiastočne overili uvádzaný typ lieku.</p>

<ul>
  <li><strong>Observačný a selektovaný súbor:</strong> účastníci boli zákazníci 23andMe, ktorí dobrovoľne odpovedali na cielený dotazník. Výber mohol súvisieť s priebehom liečby aj so záujmom o genetiku.</li>
  <li><strong>Prevažujúce sebahlásenie:</strong> hmotnosť, dávka, trvanie liečby aj nežiaduce účinky neboli u väčšiny účastníkov objektívne overené; pri hmotnosti sa zistil systematický rozdiel oproti zdravotným záznamom.</li>
  <li><strong>Nerandomizovaná liečba:</strong> z rozdielu medzi semaglutidom a tirzepatidom nemožno odvodiť kauzálne porovnanie účinnosti alebo znášanlivosti.</li>
  <li><strong>Heterogénne prípravky:</strong> analýza zahŕňala aj individuálne pripravovaný semaglutid a tirzepatid, ktorých zloženie a skutočnú dávku štúdia nemohla overiť.</li>
  <li><strong>Obmedzená populačná prenositeľnosť:</strong> 82,4 % účastníkov tvorili ženy, 78,3 % malo európsky genetický pôvod a hlavná objavová GWAS sa uskutočnila v európskej skupine.</li>
  <li><strong>Malý genetický účinok:</strong> približne 0,76 kg na alelu je populačný priemer, nie presný individuálny odhad. Variant sám osebe nevytvára klinicky jasné skupiny pacientov s dobrou a slabou odpoveďou.</li>
  <li><strong>Neúplná externá validácia:</strong> hlavný signál sa potvrdil v All of Us, nie však v UK Biobank; modely nežiaducich účinkov nemali nezávislú prospektívnu validáciu.</li>
  <li><strong>Firemný konflikt záujmov:</strong> všetci autori boli súčasnými alebo bývalými zamestnancami 23andMe a firma súčasne ponúka komerčnú službu založenú na výsledkoch. To nálezy automaticky nezneplatňuje, ale zvyšuje význam nezávislej replikácie a transparentnej validácie.</li>
  <li><strong>Chýbajúce renálne výsledky:</strong> štúdia neodpovedá na otázku, či genotyp modifikuje účinok liečby na progresiu CKD alebo bezpečnosť u pacientov s pokročilým ochorením obličiek.</li>
</ul>

<h2>Čo možno a nemožno urobiť dnes</h2>

<ul>
  <li><strong>Možno povedať:</strong> bežné varianty v génoch cieľových receptorov pravdepodobne prispievajú k časti variability odpovede na semaglutid a tirzepatid.</li>
  <li><strong>Možno povedať:</strong> hlavná asociácia účinnosti je štatisticky robustná, biologicky vierohodná a replikovaná, jej priemerný účinok je však malý.</li>
  <li><strong>Nemožno povedať:</strong> že genetický test spoľahlivo určí, ktorý pacient schudne, komu bude zle alebo ktorý z dvoch liekov je preňho lepší.</li>
  <li><strong>Nemožno odporučiť:</strong> rutinnú genotypizáciu rs10305420, rs9357296, rs11760106 alebo rs1800437 pred začatím liečby.</li>
  <li><strong>Nemožno meniť:</strong> dávku, titráciu, výber lieku alebo ukončenie liečby iba podľa výsledku priameho spotrebiteľského genetického testu.</li>
  <li><strong>Treba zachovať:</strong> individualizovaný výber podľa schválenej indikácie, kontraindikácií, komorbidít, cieľov pacienta, dostupnosti a priebežne pozorovanej účinnosti a znášanlivosti.</li>
</ul>

<p>Na prechod od asociačnej genetiky ku klinickému testu budú potrebné nezávislé a etnicky rozmanité kohorty, prospektívne meranie hmotnosti a nežiaducich účinkov, externá validácia celého algoritmu, vopred stanovené rozhodovacie prahy a predovšetkým štúdia, ktorá ukáže, že starostlivosť riadená genotypom zlepšuje výsledky alebo bezpečnosť. Bez takejto klinickej užitočnosti je genetická informácia zaujímavým biologickým signálom, nie hotovým terapeutickým návodom.</p>

<h2>Záver</h2>

<p>Štúdia 23andMe poskytuje veľký súbor genetických údajov o sebahlásenej odpovedi na semaglutid a tirzepatid. Variant rs10305420 v <em>GLP1R</em> bol spojený s priemerne o 0,76 kg väčším úbytkom hmotnosti na alelu a varianty v oblastiach <em>GLP1R</em> a <em>GIPR</em> s nauzeou či vracaním. Nálezy sú biologicky presvedčivé, no ich individuálna predikčná hodnota je obmedzená.</p>

<p>Pre súčasnú nefrologickú prax je správnym záverom opatrnosť. Genotyp zatiaľ neurčuje voľbu lieku ani dávku a podľa tejto štúdie neumožňuje predpovedať renálny prínos. Praktický význam zostáva v dôslednom sledovaní skutočnej odpovede, gastrointestinálnej znášanlivosti, hydratácie a funkcie obličiek. Farmakogenomika inkretínovej liečby je sľubná výskumná oblasť, ale ešte nie štandard klinickej starostlivosti.</p>

<hr>

<p><em><strong>Zdroj:</strong> primárna originálna štúdia – Su QJ, Ashenhurst JR, Xu W, Tran V, Wu RR, Weldon CH, Shi J, Hicks B; 23andMe Research Team; Abul-Husn NS, Aslibekyan S, Holmes MV, Koelsch BL, Auton A. Genetic predictors of GLP1 receptor agonist weight loss and side effects. <em>Nature</em>. 2026;653(8115):770–775. Publikované online 8. apríla 2026. doi: <a href="https://doi.org/10.1038/s41586-026-10330-z" target="_blank" rel="noopener noreferrer">10.1038/s41586-026-10330-z</a>. PMID 41951734; PMCID PMC13190316. <a href="https://www.nature.com/articles/s41586-026-10330-z" target="_blank" rel="noopener noreferrer">Nature – originálny zdroj</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/41951734/" target="_blank" rel="noopener noreferrer">PubMed</a>; <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC13190316/" target="_blank" rel="noopener noreferrer">PubMed Central</a>; <a href="https://europepmc.org/article/MED/41951734" target="_blank" rel="noopener noreferrer">Europe PMC</a>; <a href="https://crossmark.crossref.org/dialog/?doi=10.1038%2Fs41586-026-10330-z" target="_blank" rel="noopener noreferrer">Crossref/Crossmark</a>; <a href="https://www.nature.com/articles/s41586-026-10330-z.pdf" target="_blank" rel="noopener noreferrer">PDF originálnej štúdie</a>; <a href="https://static-content.springer.com/esm/art%3A10.1038%2Fs41586-026-10330-z/MediaObjects/41586_2026_10330_MOESM1_ESM.pdf" target="_blank" rel="noopener noreferrer">doplnkové metódy</a>; <a href="https://static-content.springer.com/esm/art%3A10.1038%2Fs41586-026-10330-z/MediaObjects/41586_2026_10330_MOESM5_ESM.pdf" target="_blank" rel="noopener noreferrer">recenzné posudky</a>.</em></p>

<p><em><strong>Všetci autori v byline originálnej štúdie:</strong> Qiaojuan Jane Su; James R. Ashenhurst; Wanwan Xu; Vinh Tran; R. Ryanne Wu; Catherine H. Weldon; Jingchunzi Shi; Barry Hicks; 23andMe Research Team; Noura S. Abul-Husn; Stella Aslibekyan; Michael V. Holmes; Bertram L. Koelsch; Adam Auton.</em></p>

<p><em><strong>Ďalší menovaní členovia kolektívu 23andMe Research Team podľa PubMed:</strong> Robert K. Bell; Katelyn Kukar Bond; Zayn Cochinwala; Sayantan Das; Kahsaia de Brito; Devika Dhamija; Payambr Dibaeinia; Emily DelloRusso; Chris Eijsbouts; Sarah L. Elson; Shirin Fuller; Chris German; Julie M. Granka; Larry Hengl; David A. Hinds; Reza Jabal; Aly Khan; Matthew J. Kmiecik; Alan Kwong; Yanyu Liang; Keng-Han Lin; Matthew H. McIntyre; Alex Moran; Carrie Northover; Shubham Saini; Anjali J. Shastri; Suyash Shringarpure; Teague Sterling; Joyce Y. Tung. Zoznam uvádza všetkých 42 jedinečných menovaných autorov a kolaborátorov bez opakovania; úplný zoznam kolektívu na stránke vydavateľa zároveň opakuje deviatich členov už uvedených v hlavnej byline.</em></p>

<p><em><strong>Priložený popularizačný a komerčný zdroj:</strong> James Ashenhurst. Unlocking the Genetics of GLP-1 Medications: Why Your DNA Matters. 23andMe Blog. 8. apríla 2026. <a href="https://www.23andme.org/blog/articles/glp-1-medications-why-your-dna-matters/" target="_blank" rel="noopener noreferrer">Link na priložený zdroj</a>. Tento text propaguje službu 23andMe Total Health; pri vecnej kontrole bol preto použitý iba ako východisko a všetky odborné tvrdenia boli porovnané s primárnou publikáciou.</em></p>

<p><em><strong>Konflikty záujmov a dostupnosť údajov:</strong> Všetci autori originálnej štúdie boli v čase zverejnenia súčasnými alebo bývalými zamestnancami 23andMe. Noura S. Abul-Husn uviedla akademické pôsobenie na Icahn School of Medicine at Mount Sinai a Michael V. Holmes aktuálnu afiliáciu v Genentech. Individuálne údaje nie sú verejne dostupné; úplné deidentifikované súhrnné štatistiky možno získať na základe dohody s 23andMe a výsledky pre varianty s <em>P</em> &lt; 1 × 10<sup>−4</sup> sú v doplnkových dátach. Článok je otvorene dostupný pod licenciou CC BY-NC-ND 4.0.</em></p>

<p><em><strong>Doplňujúce oficiálne bezpečnostné zdroje:</strong> U.S. Food and Drug Administration. <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2025/218316Orig1s000lbl.pdf" target="_blank" rel="noopener noreferrer">WEGOVY (semaglutide) – aktuálne predpisové informácie, revidované 12/2025</a>; <a href="https://www.accessdata.fda.gov/drugsatfda_docs/label/2025/217806s031lbl.pdf" target="_blank" rel="noopener noreferrer">ZEPBOUND (tirzepatide) – predpisové informácie, 2025</a>. Obe informácie upozorňujú na riziko poškodenia obličiek pri deplécii objemu súvisiacej s gastrointestinálnymi nežiaducimi reakciami.</em></p>

<p><em><strong>Odborné spracovanie, vecná kontrola a slovenská jazyková redakcia:</strong> MUDr. Ľubomír Polaščín.</em></p>
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
