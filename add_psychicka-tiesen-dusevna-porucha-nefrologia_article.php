<?php
/**
 * add_psychicka-tiesen-dusevna-porucha-nefrologia_article.php
 * Odborny clanok o rozliseni psychickej tiesne a dusevnej poruchy
 * v nefrologickej praxi, spracovany z komentara Medscape a nefrologickych studii.
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
    'title'        => 'Psychická tieseň nie je vždy duševná porucha: význam pre nefrologickú prax',
    'slug'         => 'psychicka-tiesen-dusevna-porucha-nefrologia',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Nie každá psychická tieseň pri chorobe obličiek je duševná porucha, no pochopiteľný dôvod na smútok nevylučuje depresiu. Ako odlíšiť skríning od diagnózy a kedy a ako pomáhať.',
    'content'      => <<<'HTML'
<figure><a href="img/psychicka-tiesen-dusevna-porucha-nefrologia.webp" rel="noopener noreferrer" target="_blank"><img src="img/psychicka-tiesen-dusevna-porucha-nefrologia.webp" alt="Priesvitná postava zozadu: polovica hlavy sa rozpadá v sivej hmle, druhú polovicu s tyrkysovou nervovou sieťou skúma lúč svetla cez lupu; dole obličky a slučka dialyzačnej hadičky" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>Poloschematická ilustračná scéna, nie snímka konkrétneho pacienta. Hmla znázorňuje psychickú tieseň, svetelná sieť pod lupou starostlivé diagnostické posúdenie; obličky a dialyzačný okruh pripomínajú somatický kontext, v ktorom sa obe roviny prekrývajú.</figcaption></figure>

<p>Psychické utrpenie si zaslúži pozornosť aj vtedy, keď nespĺňa diagnostické kritériá duševnej poruchy. Zároveň nemožno depresívnu poruchu, úzkostnú poruchu ani inú liečiteľnú psychickú poruchu prehliadnuť s vysvetlením, že ide o pochopiteľnú reakciu na závažné ochorenie. V nefrológii je toto rozlišovanie zvlášť dôležité: chronická choroba obličiek a dialyzačná liečba zasahujú telesné fungovanie, každodenný život, vzťahy aj predstavy pacienta o budúcnosti.</p>

<p>Psychiater Temitope Ogundare z Columbia University upozorňuje v komentári pre Medscape z 8. októbra 2026 na riziko, že čoraz širšie používanie psychiatrického slovníka môže viesť k zamieňaniu bolestivých ľudských skúseností za duševné poruchy. Jeho text je odbornou úvahou, nie klinickým odporúčaním ani pôvodnou výskumnou prácou. [1] Pre nefrologickú prax však otvára podstatnú otázku: ako rozpoznať skutočnú psychickú poruchu bez toho, aby sa každá ťažkosť pacienta automaticky premenila na psychiatrickú diagnózu? Odpoveď v tomto článku opierame aj o nefrologické štúdie skríningu a liečby depresie. [2–8]</p>

<h2>Diagnóza má pomenovať poruchu, nie každé utrpenie</h2>

<p>Smútok sám osebe nie je depresívna porucha. Strach pred zavedením cievneho prístupu nie je automaticky úzkostná porucha a ťažkosti so sústredením po hemodialýze nepreukazujú poruchu pozornosti s hyperaktivitou (ADHD) ani inú neurovývinovú poruchu.</p>

<p>Psychiatrická diagnóza vyžaduje posúdenie konkrétneho súboru príznakov, ich trvania, závažnosti, priebehu a súvislostí, ako aj ich vplyvu na fungovanie človeka. Žiadny z týchto ukazovateľov však nemožno mechanicky vytrhnúť z kontextu: intenzívne utrpenie môže sprevádzať aj reakciu, ktorá nepredstavuje duševnú poruchu.</p>

<p>Ogundare pripomína, že podľa definície DSM-5 spoločensky odlišné správanie ani konflikt jednotlivca so spoločnosťou samy osebe nie sú duševnou poruchou a že štatisticky neobvyklé nie je automaticky patologické. Zdôrazňuje tiež, že diagnóza ovplyvňuje nielen liečbu, ale aj to, ako človek vníma sám seba a ako k nemu pristupuje rodina, zdravotníci či inštitúcie. Pomenovanie podľa neho nie je bezvýznamný úkon. [1]</p>

<p>Z toho nevyplýva, že treba za každú cenu stanovovať menej diagnóz, ale že ich treba stanovovať presnejšie. Sám autor uzatvára, že zložitosť hraníc nie je argumentom proti diagnostike, ale argumentom pre pokoru pri nej. [1]</p>

<h2>Prečo je rozlišovanie v nefrológii náročné</h2>

<p>Pacient s chronickou chorobou obličiek môže čeliť strate pracovnej schopnosti, finančným ťažkostiam, obmedzeniam pri cestovaní, zmenám partnerského života alebo obavám zo závislosti od liečby. Tieto okolnosti môžu vyvolávať výraznú psychickú tieseň bez toho, aby nevyhnutne znamenali duševnú poruchu.</p>

<p>Opačné zjednodušenie je však rovnako nebezpečné. Skutočnosť, že pacient má pochopiteľný dôvod na smútok, nevylučuje depresívnu poruchu. Závažné telesné ochorenie a duševná porucha môžu existovať súčasne a pri chronickej chorobe obličiek nejde o zriedkavú kombináciu: v metaanalýze 249 populácií s takmer 56&nbsp;000 účastníkmi mala depresiu potvrdenú klinickým rozhovorom približne štvrtina dospelých. [2]</p>

<p>Posudzovanie komplikuje prekrývanie telesných a psychických príznakov. Únava, poruchy spánku, znížená chuť do jedla či ťažkosti so sústredením môžu súvisieť s depresiou, ale aj s anémiou, urémiou, nedostatočnou dávkou dialýzy, bolesťou, svrbením, syndrómom nepokojných nôh, účinkami liekov alebo ďalšími pridruženými ochoreniami. Často sa uplatňuje viac príčin naraz.</p>

<p>Rozhovor sa preto nemá zastaviť pri otázke, či je pacient unavený. Treba zisťovať, ako sa mení jeho nálada, či stráca záujem a schopnosť prežívať potešenie, či pociťuje beznádej alebo nadmernú vinu a či uvažuje o smrti alebo samovražde. Ani jednotlivý takýto príznak však nenahrádza celkové klinické posúdenie.</p>

<h2>Skríning nie je potvrdenie diagnózy</h2>

<p>Dotazníky pomáhajú odhaliť pacientov, ktorí potrebujú podrobnejšie vyšetrenie. Pozitívny výsledok však znamená podozrenie na poruchu, nie jej potvrdenie.</p>

<p>Rozdiel je dobre viditeľný v nefrologických údajoch. Systematický prehľad a metaanalýza Palmerovej a spoluautorov zistili u dialyzovaných pacientov (CKD G5D) prevalenciu depresie potvrdenej rozhovorom 22,8&nbsp;% (95&nbsp;% CI 18,6–27,6), kým podľa sebaposudzovacích alebo hodnotiacich škál dosahovala prevalencia depresívnych príznakov 39,3&nbsp;% (95&nbsp;% CI 36,8–42,0). V štádiách G1–G5 bez dialýzy bol rozdiel menší (21,4&nbsp;% oproti 26,5&nbsp;%) a u príjemcov transplantátu takmer žiadny (25,7&nbsp;% oproti 26,6&nbsp;%). Autori z toho vyvodzujú, že dotazníky môžu výskyt depresie nadhodnocovať, najmä v dialyzačnej populácii. [2]</p>

<p>Validačné štúdie ukazujú praktický dôsledok: pri hemodialýze bola najlepšou hranicou Beckovej škály depresie (BDI) hodnota 14, a aj pri nej malo len 53&nbsp;% pozitívne skrínovaných pacientov depresiu potvrdenú štruktúrovaným rozhovorom vedeným lekárom. Negatívny výsledok pritom depresiu spoľahlivo nevylučoval (senzitivita 62&nbsp;%). [3] U pacientov s chronickou chorobou obličiek bez dialýzy bola optimálnou hranicou BDI hodnota 11 so senzitivitou 89&nbsp;% a špecificitou 88&nbsp;% voči štruktúrovanému diagnostickému rozhovoru. [4] Hranice prevzaté z celkovej populácie teda pri dialýze nemusia platiť a skríning je vždy len prvým krokom.</p>

<div class="table-responsive" role="region" aria-label="Rozlíšenie pojmov pri hodnotení depresie" tabindex="0">
<table>
<thead>
<tr><th scope="col">Pojem v dokumentácii</th><th scope="col">Čo znamená</th><th scope="col">Čo nasleduje</th></tr>
</thead>
<tbody>
<tr><th scope="row">Depresívne príznaky</th><td>Opísané ťažkosti, napríklad smútok, strata záujmu, beznádej; sami osebe nie sú diagnózou</td><td>Posúdiť trvanie, závažnosť, vplyv na fungovanie a somatické príčiny</td></tr>
<tr><th scope="row">Pozitívny skríning depresie</th><td>Skóre dotazníka nad stanovenou hranicou; podozrenie, nie potvrdenie</td><td>Klinický rozhovor, pri nejasnosti psychiatrické alebo psychologické vyšetrenie</td></tr>
<tr><th scope="row">Depresívna porucha</th><td>Diagnóza stanovená klinickým posúdením podľa diagnostických kritérií</td><td>Individualizovaná liečba a opakované hodnotenie odpovede</td></tr>
</tbody>
</table>
</div>

<p>Telesné príznaky pritom nemožno zo psychiatrického hodnotenia jednoducho vyradiť. Ich význam treba posudzovať podľa časového priebehu, somatického stavu a prítomnosti ďalších, menej „somatických“ príznakov, ako sú anhedónia, pocit bezcennosti alebo beznádej.</p>

<h2>Porozumenie okolnostiam nenahrádza diferenciálnu diagnostiku</h2>

<p>Pri nových psychických alebo behaviorálnych ťažkostiach je užitočné najprv zrekonštruovať ich vznik. Objavili sa po oznámení diagnózy, začatí dialýzy, hospitalizácii, zmene medikácie alebo strate blízkeho človeka? Sú trvalé, alebo sa viažu na určité situácie či fázy liečby?</p>

<p>Náhla zmena správania, kolísanie pozornosti, dezorientácia alebo zmena bdelosti vyžadujú prednostné posúdenie možného delíria a jeho telesnej príčiny, napríklad infekcie, hypoglykémie, porúch vnútorného prostredia, urémie alebo kumulácie liekov pri zníženej funkcii obličiek. Nemožno ich automaticky interpretovať ako úzkosť, „nespoluprácu“ alebo osobnostnú črtu.</p>

<p>Podobná opatrnosť platí pri odmietaní či vynechávaní dialýzy. Príčinou môžu byť dopravné problémy, nepríjemné skúsenosti s liečbou, bolesť, nedostatočné porozumenie, depresia, kognitívna porucha alebo informované rozhodnutie pacienta. Samotné správanie neurčuje diagnózu ani rozhodovaciu spôsobilosť. Ogundare upozorňuje na podobnú chybu z urgentnej psychiatrie: správanie v kríze nie je osobnostná charakteristika a stabilnú diagnózu nemožno odvodiť z jediného náročného kontaktu. [1]</p>

<p>Ak ťažkosti vznikajú v súvislosti so stresovou udalosťou, môže prichádzať do úvahy porucha prispôsobenia (adaptačná porucha). Ani tá však nemá byť univerzálnym označením každej nepríjemnej reakcie na chorobu. Vyžaduje splnenie príslušných diagnostických kritérií a vylúčenie iných vysvetlení.</p>

<h2>Pomoc nemusí čakať na psychiatrickú diagnózu</h2>

<p>Pacient môže potrebovať podporu aj bez potvrdenej duševnej poruchy. V nefrologickej starostlivosti môže ísť o zrozumiteľné vysvetlenie liečby, liečbu bolesti a svrbenia, úpravu organizácie dialýzy, sociálne poradenstvo, psychologickú intervenciu alebo zapojenie blízkych so súhlasom pacienta. Ogundare to vyjadruje tak, že ľudia nemajú byť psychiatricky chorí na to, aby ich utrpenie malo význam. [1]</p>

<p>Takýto postup nie je menejcennou náhradou psychiatrickej liečby. Reaguje na konkrétny zdroj ťažkostí. Finančnú neistotu nemožno odstrániť predpisom psychofarmaka, podobne ako depresívnu poruchu nemožno spoľahlivo vyriešiť iba povzbudením.</p>

<h2>Liečba potvrdenej poruchy: dôkazy sú skromnejšie, než sa predpokladá</h2>

<p>Pri potvrdenej duševnej poruche sa liečba individualizuje podľa diagnózy, závažnosti, preferencií pacienta a somatického stavu. Presná diagnóza je dôležitá aj preto, že dôkazový základ farmakoterapie depresie pri chronickej chorobe obličiek je obmedzený.</p>

<p>V dvojito zaslepenej randomizovanej štúdii CAST s 201 pacientmi s chronickou chorobou obličiek G3–G5 bez dialýzy a s veľkou depresívnou poruchou potvrdenou štruktúrovaným rozhovorom nezlepšil sertralín počas 12 týždňov depresívne príznaky v porovnaní s placebom (zmena skóre QIDS-C16 −4,1 oproti −4,2; rozdiel 0,1; 95&nbsp;% CI −1,1 až 1,3). Nevoľnosť či vracanie (22,7&nbsp;% oproti 10,4&nbsp;%) a hnačka (13,4&nbsp;% oproti 3,1&nbsp;%) boli pri sertralíne častejšie. [5]</p>

<p>V otvorenej randomizovanej štúdii ASCEND u 120 hemodialyzovaných pacientov s veľkou depresívnou poruchou alebo dystýmiou viedol sertralín po 12 týždňoch k mierne nižšiemu skóre depresie než kognitívno-behaviorálna terapia poskytovaná priamo v dialyzačnom stredisku (rozdiel −1,84 bodu QIDS-C; 95&nbsp;% CI −3,54 až −0,13), za cenu častejších nežiaducich udalostí. Pozitívny skríning (BDI-II ≥&nbsp;15) na zaradenie do štúdie nestačil: diagnózu bolo potrebné potvrdiť štruktúrovaným rozhovorom MINI podľa kritérií DSM-IV. [6, 7] Štúdia nemala placebovú ani neliečenú kontrolnú skupinu a nehodnotila pretrvávanie účinku. [6]</p>

<p>Z týchto výsledkov nevyplýva, že antidepresíva sú pri chorobe obličiek neúčinné, ale že ich prínos nemožno automaticky prenášať zo všeobecnej populácie. Pri farmakoterapii treba zohľadniť funkciu obličiek, prípadnú dialyzovateľnosť liečiva, interakcie a profil nežiaducich účinkov. Potreba úpravy dávky sa posudzuje podľa konkrétneho lieku, nie všeobecne podľa toho, že ide o psychofarmakum.</p>

<h2>Bezpečnosť má prednosť pred diskusiou o diagnostických hraniciach</h2>

<p>Úvaha o nadmernej medikalizácii nesmie oddialiť pomoc pri samovražednom riziku, psychóze, mánii, delíriu alebo závažnom zanedbávaní základných potrieb. V americkom registri pacientov, ktorí začali dialýzu v rokoch 1995 až 2000, bol výskyt samovrážd o 84&nbsp;% vyšší než v celkovej populácii (štandardizovaný pomer incidencie 1,84; 95&nbsp;% CI 1,50–2,27). Nezávislými prediktormi boli okrem iného vek ≥&nbsp;75 rokov, mužské pohlavie, závislosť od alkoholu alebo drog a nedávna hospitalizácia pre duševnú poruchu. [8]</p>

<p>Vyjadrenia o smrti treba preskúmať priamo a citlivo. U dialyzovaného pacienta je potrebné rozlišovať samovražedný úmysel, depresívnu beznádej, vyčerpanie z liečby a informované rozhodovanie o cieľoch starostlivosti vrátane ukončenia dialýzy. Rozlíšenie si môže vyžadovať spoluprácu nefrológa, psychiatra, psychológa a paliatívneho tímu.</p>

<p>Odmietnutie liečby samo osebe nepreukazuje duševnú poruchu. Zároveň nesmie byť dôvodom na vynechanie posúdenia bezpečnosti, porozumenia dôsledkom a rozhodovacej spôsobilosti.</p>

<h2>Limity</h2>

<p>Východiskový text je názorový komentár psychiatra, nie systematický prehľad ani odporúčanie odbornej spoločnosti, a nezaoberá sa nefrológiou. Nefrologické údaje o prevalencii pochádzajú prevažne z observačných štúdií s rozdielnymi nástrojmi a populáciami. Validačné štúdie skríningových škál boli jednocentrové a s obmedzeným počtom pacientov. Liečebné štúdie CAST a ASCEND boli krátke (12 týždňov) a ASCEND nemal placebovú vetvu. Údaje o samovraždách pochádzajú z amerického registra spred viac ako dvoch desaťročí a ich prenos do súčasnej slovenskej praxe je len orientačný.</p>

<h2>Záver</h2>

<p>Ogundareho komentár pripomína, že pomenovanie ťažkostí má dôsledky. Neopodstatnená diagnóza môže skresliť ďalšie klinické uvažovanie. Nepoznaná duševná porucha môže pacienta pripraviť o účinnú pomoc. [1]</p>

<p>Pre nefrologickú prax z toho vyplýva dvojitá zodpovednosť: nezamieňať psychickú tieseň automaticky za duševnú poruchu a nepovažovať duševnú poruchu za nevyhnutnú, neliečiteľnú súčasť ochorenia obličiek. Rozhodujúce sú pozorný rozhovor, rozlišovanie medzi skríningom a diagnózou, diferenciálna diagnostika vrátane somatických príčin, primeraná podpora a opakované hodnotenie v čase.</p>

<hr>

<p><em>Článok je určený zdravotníckym pracovníkom. Nenahrádza individuálne klinické posúdenie, psychiatrické vyšetrenie ani aktuálny súhrn charakteristických vlastností konkrétneho lieku. Pri akútnom samovražednom riziku je potrebné okamžité odborné posúdenie.</em></p>

<h2>Literatúra</h2>

<ol>
  <li><em>Ogundare T. The Risk of Turning Every Problem Into a Mental Health Problem. Medscape Psychiatry. 8. októbra 2026. <a href="https://www.medscape.com/viewarticle/risk-turning-every-problem-mental-health-problem-2026a10010w6" target="_blank" rel="noopener noreferrer">Východiskový komentár</a>.</em></li>
  <li><em>Palmer S, Vecchio M, Craig JC, Tonelli M, Johnson DW, Nicolucci A, Pellegrini F, Saglimbene V, Logroscino G, Fishbane S, Strippoli GFM. Prevalence of depression in chronic kidney disease: systematic review and meta-analysis of observational studies. Kidney Int. 2013;84(1):179–191. doi: <a href="https://doi.org/10.1038/ki.2013.77" target="_blank" rel="noopener noreferrer">10.1038/ki.2013.77</a>. PMID: 23486521. <a href="https://pubmed.ncbi.nlm.nih.gov/23486521/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Hedayati SS, Bosworth HB, Kuchibhatla M, Kimmel PL, Szczech LA. The predictive value of self-report scales compared with physician diagnosis of depression in hemodialysis patients. Kidney Int. 2006;69(9):1662–1668. doi: <a href="https://doi.org/10.1038/sj.ki.5000308" target="_blank" rel="noopener noreferrer">10.1038/sj.ki.5000308</a>. PMID: 16598203. <a href="https://pubmed.ncbi.nlm.nih.gov/16598203/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Hedayati SS, Minhajuddin AT, Toto RD, Morris DW, Rush AJ. Validation of depression screening scales in patients with CKD. Am J Kidney Dis. 2009;54(3):433–439. doi: <a href="https://doi.org/10.1053/j.ajkd.2009.03.016" target="_blank" rel="noopener noreferrer">10.1053/j.ajkd.2009.03.016</a>. PMID: 19493600. PMCID: PMC3217720. <a href="https://pubmed.ncbi.nlm.nih.gov/19493600/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC3217720/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>Hedayati SS, Gregg LP, Carmody T, Jain N, Toups M, Rush AJ, Toto RD, Trivedi MH. Effect of Sertraline on Depressive Symptoms in Patients With Chronic Kidney Disease Without Dialysis Dependence: The CAST Randomized Clinical Trial. JAMA. 2017;318(19):1876–1890. doi: <a href="https://doi.org/10.1001/jama.2017.17131" target="_blank" rel="noopener noreferrer">10.1001/jama.2017.17131</a>. PMID: 29101402. PMCID: PMC5710375. <a href="https://pubmed.ncbi.nlm.nih.gov/29101402/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC5710375/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>Mehrotra R, Cukor D, Unruh M, Rue T, Heagerty P, Cohen SD, Dember LM, Diaz-Linhart Y, Dubovsky A, Greene T, Grote N, Kutner N, Trivedi MH, Quinn DK, Ver Halen N, Weisbord SD, Young BA, Kimmel PL, Hedayati SS. Comparative Efficacy of Therapies for Treatment of Depression for Patients Undergoing Maintenance Hemodialysis: A Randomized Clinical Trial. Ann Intern Med. 2019;170(6):369–379. doi: <a href="https://doi.org/10.7326/M18-2229" target="_blank" rel="noopener noreferrer">10.7326/M18-2229</a>. PMID: 30802897. <a href="https://pubmed.ncbi.nlm.nih.gov/30802897/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
  <li><em>Hedayati SS, Daniel DM, Cohen S, Comstock B, Cukor D, Diaz-Linhart Y, Dember LM, Dubovsky A, Greene T, Grote N, Heagerty P, Katon W, Kimmel PL, Kutner N, Linke L, Quinn D, Rue T, Trivedi MH, Unruh M, Weisbord S, Young BA, Mehrotra R. Rationale and design of A Trial of Sertraline vs. Cognitive Behavioral Therapy for End-stage Renal Disease Patients with Depression (ASCEND). Contemp Clin Trials. 2016;47:1–11. doi: <a href="https://doi.org/10.1016/j.cct.2015.11.020" target="_blank" rel="noopener noreferrer">10.1016/j.cct.2015.11.020</a>. PMID: 26621218. PMCID: PMC4818161. <a href="https://pubmed.ncbi.nlm.nih.gov/26621218/" target="_blank" rel="noopener noreferrer">PubMed</a>, <a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC4818161/" target="_blank" rel="noopener noreferrer">plný text</a>.</em></li>
  <li><em>Kurella M, Kimmel PL, Young BS, Chertow GM. Suicide in the United States end-stage renal disease program. J Am Soc Nephrol. 2005;16(3):774–781. doi: <a href="https://doi.org/10.1681/ASN.2004070550" target="_blank" rel="noopener noreferrer">10.1681/ASN.2004070550</a>. PMID: 15659561. <a href="https://pubmed.ncbi.nlm.nih.gov/15659561/" target="_blank" rel="noopener noreferrer">PubMed</a>.</em></li>
</ol>

<p><em><strong>Poznámka k dôkazom:</strong> Východiskom bol komentár Medscape, ktorého plný text, autor, afiliácia a dátum (8. októbra 2026) boli overené priamo na stránke zdroja. Bibliografické údaje všetkých citovaných prác (autori, ročník, číslo, strany, DOI, PMID) boli overené v PubMed a Crossref a číselné údaje porovnané so štruktúrovanými abstraktmi. Pôvodná predloha obsahovala iba komentár a metaanalýzu Palmerovej a spol.; údaje o validácii skríningových škál, štúdie CAST a ASCEND (vrátane dizajnovej publikácie ASCEND) a údaje o samovraždách v dialyzačnej populácii sú redakčným doplnením. Nefrologická interpretácia je redakčným spracovaním uvedených zdrojov.</em></p>

<h3>Súvisiace články</h3>
<ul>
  <li><a href="article.php?slug=lubovnik-bodkovany-depresia-interakcie-nefrologia">Ľubovník bodkovaný pri depresii: kedy o ňom uvažovať a kedy v nefrológii radšej nie</a></li>
  <li><a href="article.php?slug=paliativna-starostlivost-nefrologia-krehki-starsi-eskd">Paliatívna starostlivosť v rutinnej nefrológii</a></li>
  <li><a href="article.php?slug=ckd-mozog-kognitivne-poruchy-cievne-poskodenie">Chronická choroba obličiek postihuje aj mozog: kognitívne poruchy</a></li>
  <li><a href="article.php?slug=primarna-alebo-latkou-vyvolana-psychoza-diagnostika">Primárna alebo látkou vyvolaná psychóza? Diferenciálna diagnostika</a></li>
</ul>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_psychicka-tiesen-dusevna-porucha-nefrologia_article',
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
            <div class="alert alert-error"><ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul></div>
          <?php endif; ?>
          <div class="alert <?= ($inserted + $updated) > 0 ? 'alert-success' : 'alert-info' ?>">
            <p><strong>Výsledok:</strong> <?= $inserted ?> vložených, <?= $updated ?> aktualizovaných z <?= $total ?> článkov. <?= $skipped ?> bez zmeny.</p>
            <?php if ($queuedTotal > 0): ?><p>Do fronty avíz zaradených: <strong><?= $queuedTotal ?></strong> e-mailov.</p><?php endif; ?>
          </div>
          <p class="mt-30"><a href="index.php" class="btn-primary">← Späť na hlavnú stránku</a></p>
        </div>
      </main>
      <?php include 'footer.php'; ?>
    </body>
    </html>
    <?php
}
?>
