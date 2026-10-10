<?php

/**
 * Odborný článok: cystínuria, nefrokalcinóza a nefropatická cystinóza.
 * Rozlíšenie transportnej poruchy, vápenatých depozitov a lyzozómového ochorenia.
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
    'title'        => 'Cystínuria a nefrokalcinóza: čo ich spája a prečo ich nezamieňať',
    'slug'         => 'cystinuria-nefrokalcinoza-cystinoza-rozlisenie',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Cystínové kamene, vápenaté depozity v parenchýme a lyzozómová cystinóza sú tri rôzne stavy. Súčasný nález treba rozdeliť na dve otázky: z čoho je kameň a prečo vzniká nefrokalcinóza.',
    'content'      => <<<'HTML'
<figure><a href="img/cystinuria-nefrokalcinoza-cystinoza-rozlisenie.webp" target="_blank" rel="noopener noreferrer"><img src="img/cystinuria-nefrokalcinoza-cystinoza-rozlisenie.webp" alt="Poloschematická oblička: vľavo cystínový konkrement a hexagonálne kryštály v dutom systéme, vpravo kriedové vápenaté depozity v dreňových pyramídach" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Ilustračná poloschematická scéna. Vľavo je cystín v dutom systéme obličky, vpravo vápenaté depozity v dreni. Ide o dva procesy, nie o jeden nález a nie o snímku konkrétneho pacienta.</figcaption></figure>

<p>Cystínový kameň a vápenatá usadenina v obličkovom tkanive sú dva rôzne nálezy. Pri cystínurii zlyháva spätné vstrebávanie cystínu a dvojzásaditých aminokyselín, moč sa cystínom presýti a cystín kryštalizuje. Nefrokalcinóza znamená ukladanie vápenatých solí v parenchýme. Keď sa u jedného človeka zídu oba nálezy, vyšetrenie má odpovedať na dve otázky: z čoho kameň vznikol a prečo sa vápnik ukladá v tkanive.</p>

<p>Podobné názvy cystínuria a cystinóza sú ďalším zdrojom zámeny. Cystinóza je systémové lyzozómové ochorenie. Jej nefropatická forma vedie k Fanconiho syndrómu a nefrokalcinóza je pri nej doložená pomerne často. Vápenaté depozity ani v tomto prípade nenahrádzajú cystín uložený v bunkách.</p>

<p>Od správneho zaradenia závisí výber laboratórnych vyšetrení, čítanie ultrasonografie aj bezpečnosť alkalizácie a minerálovej suplementácie. Postup pri samotnej cystínurii a pri cystinóze je rozobratý v súvisiacich článkoch. Tu ide o to, čo sa medzi týmito stavmi a nefrokalcinózou smie preniesť a čo nie.</p>

<h2>Cystínuria: porucha jedného transportu</h2>

<p>Cystínuria je dedičná porucha spätného vstrebávania cystínu a dvojzásaditých aminokyselín ornitínu, lyzínu a arginínu v proximálnom tubule a v epiteli gastrointestinálneho traktu. Spôsobujú ju patogénne varianty génov <em>SLC3A1</em> a <em>SLC7A9</em>. <em>SLC7A9</em> kóduje transportér b<sup>0,+</sup>AT, <em>SLC3A1</em> kóduje proteín rBAT, ktorý tento transportér smeruje k apikálnej membráne buniek proximálneho tubulu. [1]</p>

<p>Klinicky rozhoduje cystín. Pri fyziologickom pH moču je málo rozpustný, pri dostatočnom presýtení kryštalizuje a tvorí konkrementy. Ornitín, lyzín a arginín sa vylučujú tiež, kamene z nich však nevznikajú. Ide o selektívny transportný defekt. Ostatné funkcie proximálneho tubulu ostávajú zachované, takže cystínuria nie je Fanconiho syndróm.</p>

<p>Prehľad z roku 2023 označuje cystínuriu za najčastejšiu genetickú príčinu opakovanej nefrolitiázy a uvádza, že sa na nefrolitiáze podieľa približne 1 % u dospelých a 7 % u detí. Opakované koliky, hematúria, obštrukcia a urologické výkony zhoršujú kvalitu života. Opakované poškodenie obličiek môže vyústiť do chronickej choroby obličiek. Odstránenie jedného kameňa preto liečbu neuzatvára. [1]</p>

<h2>Nefrokalcinóza pomenúva nález</h2>

<p>Nefrokalcinóza je ukladanie vápenatých solí, najmä fosforečnanu alebo šťaveľanu vápenatého, v obličkovom parenchýme. Depozity môžu ležať v tubuloch aj v interstíciu. Najčastejšie sa rozpozná medulárna forma, pri ktorej sú postihnuté dreňové pyramídy.</p>

<p>Nefrolitiáza znamená kameň v dutom systéme. Pediatrická štúdia z rokov 2011–2021 definovala nefrokalcinózu na zobrazení ako dreňovú kalcifikáciu bez akustického tieňa a rozlišovala mierny, stredný a závažný stupeň. Oba nálezy sa môžu kombinovať. Pri drobných kalcifikáciách býva hranica medzi kameňom a parenchýmovým depozitom neostrá. [2]</p>

<p>Samotné slovo nefrokalcinóza liečbu neurčuje. V súbore 86 detí z dvoch terciárnych centier stáli za nefrolitiázou alebo nefrokalcinózou metabolické poruchy (62 %), familiárna hypomagneziémia s hyperkalciúriou a nefrokalcinózou (21 %) a distálna renálna tubulárna acidóza (17 %). V metabolickej skupine išlo o hyperoxalúriu, cystínuriu, hyperkalciúriu a hyperurikozúriu. Familiárna hypomagneziémia s hyperkalciúriou a nefrokalcinózou sa zvyčajne prejavila práve nefrokalcinózou. [2]</p>

<h2>Cystínuria nefrokalcinózu bežne nevysvetlí</h2>

<p>Pacient s cystínuriou môže mať súčasne inú metabolickú odchýlku alebo kameň iného zloženia. Samotný transportný defekt však nefrokalcinózu ako svoj obvyklý následok nemá.</p>

<p>V metabolickej časti spomínanej pediatrickej štúdie bolo 17 detí s cystínuriou. Konkrement malo všetkých 17, nefrokalcinózu nikto. Nefrokalcinóza sa v metabolickej skupine objavila pri hyperoxalúrii (4 z 20, 20 %) a pri hyperkalciúrii (2 z 13, 15,4 %). U 16 zo 17 detí s cystínuriou bol kameň aj v močovom mechúre; lokality sa prekrývali, takže toto číslo nehovorí, že cystínový kameň vzniká predovšetkým v mechúre. Genetické vyšetrenie zachytilo variant v <em>SLC3A1</em> u 3 zo 17 detí s cystínuriou. V celej metabolickej skupine 53 detí sa genetika nerobila u 36. [2]</p>

<p>Súbor je malý a vybraný: zaradené boli deti, ktoré už prišli s nefrolitiázou alebo nefrokalcinózou. Nevylučuje teda, že sa oba nálezy u iného pacienta zídu. Nepodporuje však predstavu, že nefrokalcinóza bežne nadväzuje na cystínové kamene. Takmer tretina detí s hyperkalciúriou a s cystínuriou v tejto sérii dospela do 2.–4. štádia chronickej choroby obličiek. Chýbajúca nefrokalcinóza teda neznamená zachovanú funkciu obličiek. [2]</p>

<p>Opakovaná obštrukcia a infekcie sú pri cystínurii klinicky závažné a podieľajú sa na chronickej chorobe obličiek. [1] Z toho ešte nevyplýva príčinný reťazec od poruchy tubulu cez zmenu pH k ukladaniu vápnika v parenchýme. Takú postupnosť by musela doložiť cielená práca. Ak sa pri známej cystínurii objaví nefrokalcinóza, zobrazovací nález treba overiť a hľadať druhú príčinu.</p>

<h2>Alkalizácia zvyšuje rozpustnosť cystínu</h2>

<p>Rozpustnosť cystínu rastie s pH moču, preto alkalizácia patrí k základu liečby. Prehľad amerických a európskych odporúčaní uvádza ako prvú voľbu citrát draselný, 40–80 mEq denne v dvoch alebo troch dávkach, s cieľovým pH 7,0 až 8,0. Odporúčania Európskej urologickej asociácie pripúšťajú aj pH do 8,5. Autori prehľadu začínajú nad 7,0 a dávku zvyšujú, keď konkrementy ďalej rastú. Jednotlivé dokumenty sa v cieľovom pH líšia, preto sa liečba titruje podľa aktivity litiázy a metabolického profilu. [1]</p>

<p>Vyššie pH môže zvýšiť presýtenie moču fosforečnanom vápenatým. Prehľad túto obavu z kalciumfosfátovej litiázy označuje za často diskutovanú a v citovanej klinickej skúsenosti za zriedkavo pozorovanú. Alkalizácia súčasne zvyšuje vylučovanie citrátu, ktorý tvorbu vápenatých kameňov tlmí. Týka sa to zloženia kameňa v dutom systéme. Nie je to dôkaz, že správne vedená alkalizácia bežne spôsobuje nefrokalcinózu. Výsledné riziko nezávisí od samotného čísla pH. [1]</p>

<p>Nový konkrement počas liečby nemusí byť opäť cystínový. Analýza jeho zloženia mení ďalší postup. V pediatrickej sérii sa zloženie kameňov medzi metabolickými skupinami líšilo. [2]</p>

<p>Praktický cieľ pri cystínurii je koncentrácia cystínu v moči pod 250 mg/l (1 mmol/l). U dospelých tomu spravidla zodpovedá diuréza nad 3 litre za deň. Ide o objem moču, nie o pokyn vypiť pevne tri litre. Režim sa prispôsobuje stratám tekutín a schopnosti obličiek vodu vylúčiť. U detí sa cieľ odvodzuje od koncentrácie cystínu a telesnej veľkosti. Obmedzenie sodíka vylučovanie cystínu znižuje, číselné ciele amerických a európskych odporúčaní sa však líšia. Výrazné obmedzenie živočíšnych bielkovín u detí prehľad neodporúča. [1]</p>

<p>Ak konzervatívne opatrenia nestačia, prichádzajú do úvahy tiolové lieky tiopronín a D-penicilamín. Štiepia disulfid cystínu a vzniká rozpustnejší komplex lieku s cysteínom. Bežné meranie cystínu nedokáže tento komplex od voľného cystínu oddeliť, takže pri tiolovej liečbe dáva skreslenú hodnotu. Prehľad dopĺňa, že meranie je nespoľahlivé aj bez tiolového lieku, lebo rozpustnosť cystínu závisí od pH. Ako presnejšia metóda sa navrhuje stanovenie cystínovej kapacity. Medzi nežiaduce účinky patrí proteinúria v nefrotickom pásme pri membranóznej nefropatii. Pri tioproníne americký regulačný úrad ustúpil od rutinného sledovania krvného obrazu a pečeňových testov. Staršie práce uvádzali menej nežiaducich účinkov pri tioproníne než pri D-penicilamíne; francúzska séria 442 pacientov zistila podobný výskyt pri oboch liekoch. Tiopronín nie je mimo Spojených štátov všeobecne dostupný. Podrobný liečebný postup je v článku o cystínurii. [1]</p>

<p>Citrát draselný prináša aj draslíkovú záťaž. Pri pokročilej chronickej chorobe obličiek a pri liekoch, ktoré draslík zadržiavajú, patrí ku kontrole kaliémia.</p>

<h2>Pri cystinóze je nefrokalcinóza doložená</h2>

<p>Cystinóza vzniká pri poruche lyzozómového transportéra cystinozínu, ktorý kóduje gén <em>CTNS</em>. Cystín sa hromadí vo vnútri buniek. Nefropatická forma môže už v detstve vyvolať generalizovanú proximálnu tubulopatiu, teda Fanconiho syndróm, so stratami fosfátov, bikarbonátu, glukózy, aminokyselín a ďalších látok. Súčasťou liečby býva náhrada fosfátov a zásad, podľa okolností aj vitamín D. Cysteamín, ktorým sa znižuje vnútrobunkový cystín, patrí k liečbe cystinózy a na cystínové kamene pri cystínurii sa neprenáša.</p>

<p>Práve kombinácia močových strát, zloženia moču a suplementácie vytvára podmienky pre nefrokalcinózu. Nie je to ten istý proces ako hromadenie cystínu v lyzozómoch.</p>

<p>Ultrasonografická práca z roku 1995 vyšetrila 41 detí s nefropatickou cystinózou a zachovanou funkciou obličiek, vo veku od 2 mesiacov do 15 rokov. Vyšetrenie retroperitonea bolo zaslepené a k metabolickým údajom autori pripojili 216 pacientorokov. Medulárnu nefrokalcinózu nemalo 15 detí, miernu malo 18 a závažnú 8. Obličkové kamene malo 5 detí. Priemerný vek detí s nefrokalcinózou bol 9,4 ± 3,8 roka, bez nej 5,1 ± 3,8 roka. Priemerné pH moču sa pohybovalo od 7,5 do 8,1. Sérový vápnik, fosfát, vitamín D ani parathormón s výskytom ani so závažnosťou nefrokalcinózy nekorelovali. [3]</p>

<p>Nález ukazuje, že nefrokalcinóza môže byť pri nefropatickej cystinóze častá. Podiel 26 zo 41 detí sa však týka historickej kohorty so zachovanou funkciou obličiek a s vtedajšou liečbou. Na všetkých súčasných pacientov ho preniesť nemožno. Autori sami navrhli, že nefrokalcinózu by bolo možné ovplyvniť znížením perorálnej náhrady fosfátu, vápnika, vitamínu D a citrátu a že po ukončení rastu kostí treba zvážiť obmedzenie fosfátovej substitúcie. Štúdia však zníženie dávok neskúšala. Nedostatočná náhrada strát zhoršuje acidózu, rast a mineralizáciu kostí, takže úprava liečby vychádza zo súčasného laboratórneho a klinického stavu. [3]</p>

<h2>Prehľad rozdielov</h2>

<div class="table-responsive" role="region" aria-label="Rozdiely medzi cystínuriou, nefrokalcinózou a nefropatickou cystinózou" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Charakteristika</th>
      <th scope="col">Cystínuria</th>
      <th scope="col">Nefrokalcinóza</th>
      <th scope="col">Nefropatická cystinóza</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Podstata</th>
      <td>Porucha spätného vstrebávania cystínu a dvojzásaditých aminokyselín (<em>SLC3A1</em>, <em>SLC7A9</em>)</td>
      <td>Ukladanie vápenatých solí v parenchýme obličky</td>
      <td>Lyzozómové hromadenie cystínu pri poruche cystinozínu (<em>CTNS</em>)</td>
    </tr>
    <tr>
      <th scope="row">Hlavný renálny prejav</th>
      <td>Opakovaná cystínová litiáza, pri opakovanom poškodení chronická choroba obličiek</td>
      <td>Závisí od príčiny a od rozsahu depozitov</td>
      <td>Fanconiho syndróm a postupná strata funkcie obličiek</td>
    </tr>
    <tr>
      <th scope="row">Čo sa ukladá</th>
      <td>Cystín v močových kameňoch</td>
      <td>Fosforečnan alebo šťaveľan vápenatý</td>
      <td>Cystín v bunkách; prípadná nefrokalcinóza je ďalší proces</td>
    </tr>
    <tr>
      <th scope="row">Čo má vyšetrenie vyriešiť</th>
      <td>Zloženie kameňa, cystín v moči, pri nejasnom fenotype genetika</td>
      <td>Zobrazenie a etiologické vyšetrenie</td>
      <td>Potvrdenie cystinózy a rozsah tubulárnych strát</td>
    </tr>
    <tr>
      <th scope="row">Význam alkalizácie</th>
      <td>Zvyšuje rozpustnosť cystínu; pH sa titruje</td>
      <td>Závisí od príčiny nálezu</td>
      <td>Koriguje straty bikarbonátu a súčasne mení močové prostredie, v ktorom nefrokalcinóza vzniká</td>
    </tr>
  </tbody>
</table>
</div>

<h2>Dve otázky pri súčasnom náleze</h2>

<h3>Overiť zobrazenie</h3>

<p>Americké aj európske odporúčania, ako ich zhŕňa prehľad o cystínurii, radia po epizóde litiázy kontrolovať obličky ultrasonografiou alebo výpočtovou tomografiou, najmenej raz ročne, s intervalom podľa aktivity ochorenia. Tomografia je citlivejšia. Ultrasonografia sa uprednostňuje kvôli nižšej radiačnej záťaži, najmä u detí. [1] Pediatrická séria používala ultrasonografiu, natívnu snímku alebo tomografiu. Mierny stupeň nefrokalcinózy v nej zodpovedal včasnej hyperechogenite na okraji pyramíd, stredný difúzne hyperechogénnym pyramídam a závažný zhlukom v pyramídach. [2]</p>

<p>Zvýšená echogenita pyramíd sa číta v klinickom kontexte. Zobrazenie samo neurčí chemické zloženie kameňa ani metabolickú príčinu depozitov.</p>

<h3>Určiť zloženie kameňa a metabolický profil</h3>

<p>Pri podozrení na cystínuriu rozhoduje analýza odstráneného alebo spontánne odišlého kameňa a stanovenie cystínu v moči. Hexagonálne kryštály v sedimente sú pre cystín charakteristické; ich neprítomnosť diagnózu nevylučuje. Cieľová koncentrácia cystínu je pod 250 mg/l a hodnotu treba čítať spolu s pH a s tým, či pacient berie tiolový liek. [1]</p>

<p>Pri nefrokalcinóze sa podľa klinickej situácie vyšetruje funkcia obličiek, sodík, draslík, chloridy a bikarbonát, vápnik, fosfáty a horčík, objem a pH moču a vylučovanie vápnika, oxalátu a citrátu. Parathormón a vitamín D patria k vyšetreniu pri poruche minerálov. V súbore detí s cystinózou ich sérové hladiny s nefrokalcinózou nekorelovali. Proteinúria upozorní na tubulárnu dysfunkciu a pri tiolovej liečbe aj na membranóznu nefropatiu. [1–3] Pediatrická štúdia hodnotila látky v moči ako pomer ku kreatinínu v jednorazovej vzorke a nález overovala opakovaným odberom. U detí sa tieto pomery posudzujú podľa veku. [2]</p>

<p>Alkalický moč sám osebe distálnu renálnu tubulárnu acidózu nedokazuje. V tej istej sérii tvorila distálna renálna tubulárna acidóza samostatnú skupinu. Renálny priebeh nefrokalcinózy bol pri nej priaznivejší než pri familiárnej hypomagneziémii s hyperkalciúriou a nefrokalcinózou. Rozhoduje aj acidobázická rovnováha a vylúčenie iných príčin vyššieho pH. [2]</p>

<h3>Posúdiť genetické vyšetrenie</h3>

<p>Skorý začiatok, opakovaná alebo obojstranná litiáza, nefrokalcinóza, rodinný výskyt, porucha rastu a zhoršená funkcia obličiek zvyšujú podozrenie na dedičnú príčinu. Metabolická odchýlka a uzavreté genetické vyšetrenie nie sú to isté. V pediatrickej sérii sa genetika robila u 23 pacientov. Variant v <em>SLC3A1</em> sa potvrdil u 3 zo 17 detí s cystínuriou a väčšina metabolickej skupiny testovaná nebola. Ak zloženie kameňa a vylučovanie cystínu cystínuriu dokazujú, chýbajúci genetický výsledok ju nezruší. [2]</p>

<h2>Liečba sa riadi príčinou</h2>

<p>Pri cystínurii je základom nižšia koncentrácia cystínu v moči: dostatočná diuréza, umiernený príjem sodíka, primeraná strava a titrácia alkalizácie. Tiolový liek sa zvažuje, keď napriek týmto opatreniam cystínové kamene ďalej vznikajú. Sleduje sa účinnosť, proteinúria a kaliémia. Konkrétne dávkovanie, dostupnosť tiopronínu a sledovanie sú v článku o cystínurii. [1]</p>

<p>Pri nefrokalcinóze spoločný režim neexistuje. Iný postup vyžaduje distálna renálna tubulárna acidóza, iný hyperkalciúria a iný primárna hyperoxalúria. V pediatrickej sérii do zlyhania obličiek dospelo 30 % detí s hyperoxalúriou a variant v géne <em>AGXT</em> sa potvrdil u 11 z 20. Vápenaté depozity samy osebe nie sú dôvod prerušiť citrát pri cystínurii ani výrazne obmedziť vápnik v strave. [1,2]</p>

<p>Pri nefropatickej cystinóze sa náhrada tubulárnych strát riadi aktuálnou acidózou, fosfátmi a rastom, nie paušálnym znížením podľa práce z roku 1995. Cielená liečba cysteamínom a celoživotná starostlivosť sú v článku o cystinóze. [3]</p>

<p>Priebežne sa sleduje funkcia obličiek, metabolické odchýlky a aktivita litiázy. Cieľom je obmedziť ďalšie poškodzovanie obličiek, nielen odstrániť kameň, ktorý už v dutom systéme leží.</p>

<h2>Limity</h2>

<p>Pediatrické čísla o cystínurii a nefrokalcinóze pochádzajú z retrospektívneho súboru 86 detí na dvoch terciárnych pracoviskách. Podmienkou zaradenia bola nefrolitiáza alebo nefrokalcinóza, takže nulový výskyt nefrokalcinózy u 17 detí s cystínuriou opisuje túto vzorku. Genetické vyšetrenie bolo neúplné. Štúdia nehovorí, ako často sa oba nálezy stretnú v neselektovanej populácii. [2]</p>

<p>Odporúčania o alkalizácii, objeme moču a tiolových liekoch zhŕňa naratívny prehľad. Autori sami uvádzajú, že pri absencii randomizovaných štúdií stoja na patofyziológii, observačných prácach a klinickej skúsenosti. Veta, že kalciumfosfátová litiáza sa pri alkalizácii pozoruje zriedkavo, je ich zhodnotenie citovaných údajov, nie výsledok prospektívneho sledovania nefrokalcinózy. Podiely 1 % a 7 % prehľad preberá z inej práce a v tomto texte neboli znovu extrahované z primárneho zdroja. [1]</p>

<p>Údaje o 41 deťoch s cystinózou pochádzajú z abstraktu a bibliografického záznamu práce z roku 1995. Plný text tejto práce nebol voľne dostupný. Návrh znížiť suplementáciu je záver observačnej série, nie výsledok porovnania dvoch liečebných režimov. Vek, výber detí so zachovanou funkciou obličiek a vtedajšia liečba výsledok ovplyvnili. [3]</p>

<hr>

<p><em><strong>Upozornenie:</strong> Článok je určený zdravotníckym pracovníkom a slúži na odborné vzdelávanie. Nenahrádza individuálne klinické rozhodnutie, aktuálny súhrn charakteristických vlastností použitého lieku ani lokálny protokol pracoviska.</em></p>

<h2>Literatúra</h2>

<ol>
  <li>Sarah M. Azer, David S. Goldfarb. A Summary of Current Guidelines and Future Directions for Medical Management and Monitoring of Patients with Cystinuria. <em>Healthcare (Basel).</em> 2023;11(5):674. DOI: <a href="https://doi.org/10.3390/healthcare11050674" target="_blank" rel="noopener noreferrer">10.3390/healthcare11050674</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/36900678/" target="_blank" rel="noopener noreferrer">36900678</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC10000469/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</li>
  <li>Jameela A. Kari, Mohamed A. Shalaby, Faiza A. Qari, Amr S. Albanna, Khalid A. Alhasan. Childhood nephrolithiasis and nephrocalcinosis caused by metabolic diseases and renal tubulopathy: A retrospective study from 2 tertiary centers. <em>Saudi Medical Journal.</em> 2022;43(1):81–90. DOI: <a href="https://doi.org/10.15537/smj.2022.43.1.20210650" target="_blank" rel="noopener noreferrer">10.15537/smj.2022.43.1.20210650</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/35022288/" target="_blank" rel="noopener noreferrer">35022288</a>. <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9280569/" target="_blank" rel="noopener noreferrer">Plný text v PubMed Central</a>.</li>
  <li>Demetrios S. Theodoropoulos, Thomas H. Shawker, Claudine Heinrichs, William A. Gahl. Medullary nephrocalcinosis in nephropathic cystinosis. <em>Pediatric Nephrology.</em> 1995;9(4):412–418. DOI: <a href="https://doi.org/10.1007/BF00866713" target="_blank" rel="noopener noreferrer">10.1007/BF00866713</a>. PMID: <a href="https://pubmed.ncbi.nlm.nih.gov/7577398/" target="_blank" rel="noopener noreferrer">7577398</a>.</li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Úplné autorské zoznamy, názvy, ročníky, čísla, strany a DOI boli 8. októbra 2026 overené v Crossref a v PubMed. Plné texty prehľadu v časopise Healthcare a pediatrickej štúdie v Saudi Medical Journal boli prečítané vo voľne dostupnom znení v Europe PMC. Čísla 17/17 konkrementov a 0/17 nefrokalcinóz, 4/20 a 2/13, nález <em>SLC3A1</em> u 3 zo 17, rozdelenie súboru 86 detí, 30 % zlyhaní obličiek pri hyperoxalúrii a prechod takmer tretiny detí s hyperkalciúriou a cystínuriou do 2.–4. štádia chronickej choroby obličiek pochádzajú z tabuliek a textu výsledkov pediatrickej štúdie. Jej abstrakt pri hyperoxalúrii hovorí o väčšine pacientov v konečnom štádiu; v článku je číslo z výsledkov. V tabuľke tejto štúdie je močový analyt označený ako cysteine, preto sa príslušné pomery v článku neuvádzajú ako overené vylučovanie cystínu. Pri práci z roku 1995 bol k dispozícii štruktúrovaný abstrakt a bibliografický záznam, nie plný text; počty 15, 18 a 8, päť kameňov, vek, pH moču, absencia korelácie so sérovými ukazovateľmi aj autorský návrh znížiť suplementáciu sú v abstrakte. Podiely 1 % a 7 % sú prevzaté z prehľadu, ktorý ich cituje z iného zdroja. Veta o draslíkovej záťaži citrátu draselného a morfologická zmienka o hexagonálnych kryštáloch sú klinickým sprievodným údajom, nie výsledkom troch citovaných prác. Oddeľovanie cysteamínu od liečby cystínurie odkazuje na súvisiace články portálu.</em></p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=cystinuria-genetika-diagnostika-komplexna-liecba">Cystínuria: klinický obraz, genetická diagnostika a komplexná liečba</a></li>
  <li><a href="article.php?slug=cystinoza-fanconiho-syndrom-celozivotna-systemova-starostlivost">Cystinóza: od Fanconiho syndrómu k celoživotnej systémovej starostlivosti</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_cystinuria-nefrokalcinoza-cystinoza-rozlisenie_article',
]);

$inserted = $result['inserted'];
$updated = $result['updated'];
$skipped = $result['skipped'];
$queuedTotal = $result['queued'];
$errors = $result['errors'];
$total = count($articles);

if (php_sapi_name() === 'cli') {
    echo "\n──────────────────────────────────────────────────────\n";
    echo 'Migrácia článku: ' . $articles[0]['title'] . "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Výsledok: $inserted vložených, $updated aktualizovaných z $total článkov.\n";
    echo "Preskočení (bez zmeny):        $skipped\n";
    echo "Zaradených do fronty avíz:     $queuedTotal\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
    echo "──────────────────────────────────────────────────────\n\n";
}
