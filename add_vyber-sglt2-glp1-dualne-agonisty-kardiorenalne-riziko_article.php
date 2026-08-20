<?php
/**
 * Odborny clanok: vyber a kombinovanie SGLT2i, GLP-1 RA a dualnych agonistov pri kardiorenalnom riziku.
 *
 * Spustenie na serveri:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko_article.php"
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
    'title'        => 'Výber a kombinovanie inhibítorov SGLT2, agonistov GLP-1 a duálnych agonistov pri diabete 2. typu s kardiorenálnym rizikom',
    'slug'         => 'vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko',
    'author'       => 'MUDr. Ľubomír Polaščín',
    'published_at' => date('Y-m-d H:i:s'),
    'is_top'       => 0,
    'excerpt'      => 'Praktický rámec, ako pri diabete 2. typu s CKD, srdcovým zlyhávaním alebo aterosklerózou vybrať a kombinovať inhibítor SGLT2, agonistu GLP-1 a duálneho agonistu. Postavený na piatich randomizovaných štúdiách s overenými pomermi rizík.',
    'content'      => <<<'HTML'
<p class="article-dek"><em>Pri diabete 2. typu s obličkovým alebo srdcovým postihnutím sa prínos liečby už neposudzuje podľa poklesu HbA1c, ale podľa tvrdých kardiovaskulárnych a obličkových výsledkov. Tento článok prekladá dostupnú randomizovanú evidenciu do rozhodovacieho rámca použiteľného v nefrologickej ambulancii — vrátane toho, čo o kombináciách vieme a čo zatiaľ nie.</em></p>

<h2>Prečo výber lieku prestal byť otázkou glykémie</h2>

<p>U pacienta s diabetom 2. typu a súčasne s chronickou chorobou obličiek (CKD), srdcovým zlyhávaním alebo aterosklerotickým kardiovaskulárnym ochorením (ASKVO) sa prínos moderných antidiabetík hodnotí predovšetkým cez klinické príhody — progresiu obličkového ochorenia, hospitalizácie pre srdcové zlyhávanie, infarkt, cievnu mozgovú príhodu a úmrtie.</p>

<p>Dôsledok je zásadný: <strong>rovnaká „diabetologická“ schéma nemusí byť optimálna, ak je pre pacienta dominantné obličkové alebo srdcové riziko.</strong> Výber sa preto riadi fenotypom komorbidít, nie cieľovou hodnotou HbA1c.</p>

<div class="pdf-avoid-break">
<h2>Evidenčný základ: čo presne štúdie ukázali</h2>

<p>Nasledujúca tabuľka zhŕňa randomizované štúdie, o ktoré sa rozhodovanie opiera. Všetky hodnoty sú prevzaté z publikovaných abstraktov.</p>

<div class="table-responsive" role="region" aria-label="Kľúčové randomizované štúdie pri kardiorenálnom riziku" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Štúdia</th>
      <th scope="col">Liek a populácia</th>
      <th scope="col">Hlavný výsledok</th>
      <th scope="col">Pomer rizík (95 % IS)</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">DAPA-CKD (2020)</th>
      <td>dapagliflozín; CKD s diabetom aj bez neho</td>
      <td>pokles eGFR ≥ 50 %, zlyhanie obličiek alebo úmrtie z renálnych či kardiovaskulárnych príčin</td>
      <td><strong>0,61</strong> (0,51–0,72); NNT 19</td>
    </tr>
    <tr>
      <th scope="row">EMPA-KIDNEY (2023)</th>
      <td>empagliflozín; CKD s rizikom progresie</td>
      <td>progresia obličkového ochorenia alebo kardiovaskulárne úmrtie</td>
      <td><strong>0,72</strong> (0,64–0,82)</td>
    </tr>
    <tr>
      <th scope="row">CREDENCE (2019)</th>
      <td>kanagliflozín; diabetes 2. typu s nefropatiou</td>
      <td>kompozitný primárny výsledok</td>
      <td><strong>0,70</strong> (0,59–0,82); renálny kompozit 0,66 (0,53–0,81)</td>
    </tr>
    <tr>
      <th scope="row">FLOW (2024)</th>
      <td>semaglutid; diabetes 2. typu s CKD</td>
      <td>kompozitný obličkový a kardiovaskulárny výsledok</td>
      <td><strong>0,76</strong> (0,66–0,88); obličkový kompozit 0,79 (0,66–0,94)</td>
    </tr>
    <tr>
      <th scope="row">FIDELIO-DKD (2020)</th>
      <td>finerenón; CKD s diabetom 2. typu</td>
      <td>progresia CKD a kardiovaskulárne príhody</td>
      <td><strong>0,82</strong> (0,73–0,93)</td>
    </tr>
  </tbody>
</table>
</div>

<p>Z tabuľky vyplýva niekoľko vecí, ktoré sa v zjednodušených schémach strácajú.</p>

<p><strong>Inhibítory SGLT2 majú pri obličkovom výsledku najväčší a najkonzistentnejší efekt</strong> — tri nezávislé štúdie s rôznymi molekulami a rôznymi populáciami dospeli k pomerom rizík 0,61 až 0,72. DAPA-CKD aj EMPA-KIDNEY navyše zaraďovali pacientov <em>bez</em> diabetu a účinok bol konzistentný, čo z tejto skupiny robí nefroprotektívnu liečbu, nie iba antidiabetikum.</p>

<p><strong>FLOW zmenila postavenie agonistov GLP-1 pri CKD.</strong> Do jej publikovania v roku 2024 sa GLP-1 RA odporúčali najmä pre ASKVO a metabolický prínos. FLOW je prvá veľká štúdia s <em>obličkovým</em> primárnym výsledkom pri semaglutide a bola ukončená predčasne pre účinnosť. Okrem obličkového kompozitu znížila aj kardiovaskulárne úmrtie (0,71; 0,56–0,89), celkovú úmrtnosť o 20 % a spomalila ročný pokles eGFR o 1,16 ml/min/1,73 m².</p>

<p><strong>Finerenón pôsobí v inej rovine.</strong> Nesteroidný antagonista mineralokortikoidového receptora dopĺňa blokádu systému renín-angiotenzín a inhibítory SGLT2, nie je ich náhradou. Cenou je hyperkaliémia: prerušenie liečby pre ňu bolo v FIDELIO-DKD 2,3 % oproti 0,9 % pri placebe.</p>
</div>

<h2>Rozhodovací rámec podľa dominantného fenotypu</h2>

<div class="table-responsive" role="region" aria-label="Voľba liečby podľa dominantnej komorbidity" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Dominantný problém</th>
      <th scope="col">Základná voľba</th>
      <th scope="col">Doplnenie</th>
      <th scope="col">Na čo myslieť</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">CKD s albuminúriou</th>
      <td>inhibítor SGLT2 (na podklade blokády RAS v maximálnej tolerovanej dávke)</td>
      <td>finerenón pri pretrvávajúcej albuminúrii; semaglutid pri diabete 2. typu</td>
      <td>očakávaný úvodný pokles eGFR; sledovať kálium po pridaní finerenónu</td>
    </tr>
    <tr>
      <th scope="row">Srdcové zlyhávanie</th>
      <td>inhibítor SGLT2</td>
      <td>podľa typu zlyhávania a ostatnej kardiologickej liečby</td>
      <td>koordinácia s kardiológom; úprava diuretík pri nasadení</td>
    </tr>
    <tr>
      <th scope="row">ASKVO alebo veľmi vysoké kardiovaskulárne riziko</th>
      <td>agonista GLP-1 s doloženým kardiovaskulárnym prínosom</td>
      <td>pridať inhibítor SGLT2, ak je súčasne prítomné obličkové alebo srdcové riziko</td>
      <td>gastrointestinálna tolerancia; riziko dehydratácie</td>
    </tr>
    <tr>
      <th scope="row">Obezita ako hlavný cieľ</th>
      <td>agonista GLP-1 alebo duálny agonista GIP/GLP-1</td>
      <td>zosúladiť s obličkovým a srdcovým plánom</td>
      <td>duálne agonisty nemajú obličkovú výsledkovú štúdiu</td>
    </tr>
  </tbody>
</table>
</div>

<p>Rámec nie je algoritmus. U väčšiny pacientov je prítomných viacero fenotypov naraz a rozhodnutie sa riadi tým, ktoré riziko je najbližšie a najzávažnejšie.</p>

<h2>Kombinácie: čo je dokázané a čo sa iba predpokladá</h2>

<p>Toto je miesto, kde sa v praxi najviac improvizuje — a kde je evidencia najtenšia.</p>

<h3>Čo je doložené randomizovanou štúdiou</h3>

<p>Štúdia <strong>CONFIDENCE</strong> priamo testovala kombináciu finerenónu s empagliflozínom oproti každej zložke samostatne u pacientov s CKD a diabetom 2. typu. Po 180 dňoch bola redukcia pomeru albumínu ku kreatinínu v moči pri kombinácii <strong>o 29 % väčšia než pri samotnom finerenóne</strong> a <strong>o 32 % väčšia než pri samotnom empagliflozíne</strong>.</p>

<p>Ide o doklad aditívneho účinku na náhradný ukazovateľ — albuminúriu. Nie je to dôkaz aditívneho účinku na tvrdé klinické príhody a štúdia na to ani nebola dimenzovaná.</p>

<h3>Čo dokázané nie je</h3>

<ul>
  <li><strong>Trojkombinácia</strong> inhibítor SGLT2 + agonista GLP-1 + finerenón nebola testovaná v štúdii s klinickými výsledkami. Súčasné podávanie je farmakologicky obhájiteľné, ale prínos je odvodený, nie preukázaný.</li>
  <li><strong>Poradie nasadzovania</strong> nebolo randomizovane porovnané. Odporúčania vychádzajú z veľkosti a konzistentnosti účinku, nie z priameho porovnania stratégií.</li>
  <li><strong>Duálne agonisty pri CKD.</strong> Tirzepatid nemá obličkovú výsledkovú štúdiu porovnateľnú s FLOW; dostupné obličkové údaje pochádzajú z analýz programu SURPASS, teda z náhradných ukazovateľov a sekundárnych analýz.</li>
  <li><strong>Retatrutid</strong> je skúšaná molekula bez registrácie a bez kardiorenálnych výsledkov.</li>
</ul>

<h2>Praktické poznámky pre ambulanciu</h2>

<ol>
  <li><strong>Základ je blokáda RAS v maximálnej tolerovanej dávke</strong> — inhibítory SGLT2 a finerenón sa nasadzujú na ňu, nie namiesto nej.</li>
  <li><strong>Úvodný pokles eGFR po nasadení inhibítora SGLT2 je očakávaný</strong> a nie je dôvodom na vysadenie. Je hemodynamický a spravidla reverzibilný.</li>
  <li><strong>Hranicu eGFR na začatie a pravidlá pokračovania</strong> overte v platnom súhrne charakteristických vlastností konkrétneho lieku a v aktuálnom odporúčaní KDIGO — medzi molekulami sú rozdiely.</li>
  <li><strong>Po pridaní finerenónu kontrolujte kálium</strong> podľa odporúčaného rozvrhu; hyperkaliémia je hlavný dôvod prerušenia liečby.</li>
  <li><strong>Pri nasadení inhibítora SGLT2 prehodnoťte diuretiká</strong> — riziko hypovolémie a hypotenzie stúpa najmä u starších a krehkých pacientov.</li>
  <li><strong>Poučte pacienta o pravidlách pri akútnom ochorení</strong> (dočasné prerušenie pri vracaní, hnačke, horúčke a nedostatočnom príjme tekutín) a o riziku euglykemickej ketoacidózy.</li>
  <li><strong>Pri agonistoch GLP-1 sledujte gastrointestinálnu toleranciu</strong> a hydratáciu — výrazné ťažkosti môžu viesť k prerenálnemu poškodeniu obličiek.</li>
  <li><strong>Nezabudnite na ostatné piliere</strong>: krvný tlak, statín, kontrola glykémie, hmotnosť, nefajčenie a očkovanie.</li>
</ol>

<div class="pdf-avoid-break">
<h2>Vecná kontrola hlavných tvrdení</h2>

<div class="table-responsive" role="region" aria-label="Overenie tvrdení o výbere kardiorenálnej liečby" tabindex="0">
<table>
  <thead>
    <tr>
      <th scope="col">Tvrdenie</th>
      <th scope="col">Hodnotenie</th>
      <th scope="col">Odborné spresnenie</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Pri CKD sa začína inhibítorom SGLT2</td><td><strong>Podložené</strong></td><td>Tri nezávislé štúdie, pomery rizík 0,61 až 0,72; účinok aj u pacientov bez diabetu</td></tr>
    <tr><td>Agonisty GLP-1 sú len pre ASKVO a hmotnosť</td><td><strong>Prekonané</strong></td><td>FLOW (2024) preukázala obličkový prínos semaglutidu pri CKD a diabete 2. typu; HR 0,76</td></tr>
    <tr><td>Kombinácia inhibítora SGLT2 a finerenónu má aditívny účinok</td><td><strong>Doložené na albuminúrii</strong></td><td>CONFIDENCE: o 29 % a 32 % väčší pokles UACR než jednotlivé zložky; nie na tvrdých príhodách</td></tr>
    <tr><td>Trojkombinácia je overená stratégia</td><td><strong>Nie</strong></td><td>Žiadna štúdia s klinickými výsledkami; prínos je odvodený</td></tr>
    <tr><td>Duálne agonisty majú preukázanú nefroprotekciu</td><td><strong>Nie</strong></td><td>Chýba obličková výsledková štúdia; dostupné sú náhradné ukazovatele z programu SURPASS</td></tr>
    <tr><td>Úvodný pokles eGFR znamená poškodenie obličiek</td><td><strong>Nie</strong></td><td>Hemodynamický a spravidla reverzibilný; nie je dôvodom na vysadenie</td></tr>
    <tr><td>Finerenón je bezpečný bez sledovania kália</td><td><strong>Nie</strong></td><td>Prerušenie pre hyperkaliémiu 2,3 % oproti 0,9 % pri placebe</td></tr>
    <tr><td>Existuje overené poradie nasadzovania</td><td><strong>Nie</strong></td><td>Stratégie neboli randomizovane porovnané; poradie vychádza z veľkosti účinku</td></tr>
  </tbody>
</table>
</div>
</div>

<h2>Poznámka k zdrojovému materiálu</h2>

<p>Podnetom k tomuto článku bol vzdelávací modul Medscape o kardioprotektívnych antihyperglykemických stratégiách pri kardiorenálnom riziku. Jeho plný text nie je voľne dostupný, preto v tomto článku <strong>nie sú pripisované Medscape žiadne konkrétne tvrdenia o veľkosti účinku, dávkovaní ani o poradí nasadzovania</strong>. Všetky číselné údaje pochádzajú z publikovaných abstraktov randomizovaných štúdií uvedených v zozname zdrojov a boli overené jednotlivo.</p>

<h2>Praktický záver</h2>

<p>Pri diabete 2. typu s kardiorenálnymi komorbiditami sa liečba vyberá podľa toho, ktoré riziko je dominantné, nie podľa cieľovej hodnoty HbA1c.</p>

<p>Pri obličkovom postihnutí je základnou voľbou inhibítor SGLT2 nasadený na maximálnu tolerovanú blokádu RAS. Pri diabete 2. typu s CKD má po štúdii FLOW doloženú obličkovú indikáciu aj semaglutid. Finerenón je doplnkom pri pretrvávajúcej albuminúrii, s povinným sledovaním kália. Duálne agonisty patria do úvahy tam, kde je hlavným cieľom hmotnosť — obličkovú výsledkovú štúdiu zatiaľ nemajú.</p>

<p>Kombinácie sú klinicky rozumné, ale ich prínos je zatiaľ doložený predovšetkým na albuminúrii, nie na tvrdých príhodách. Tento rozdiel má byť pri rozhovore s pacientom pomenovaný.</p>

<h2>Súvisiace články</h2>

<ul>
  <li><a href="article.php?slug=ckd-pri-diabete-skrining-vrstvena-kardiorenalna-liecba">Chronická choroba obličiek pri diabete: včasný skríning a vrstvená kardiorenálna liečba</a></li>
  <li><a href="article.php?slug=liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki">Liečba chronickej choroby obličiek v roku 2026: vrstvená nefroprotekcia a presná stratifikácia rizika</a></li>
  <li><a href="article.php?slug=finerenon-ckm-syndrom-dm2-ckd-fidelity">Finerenón naprieč štádiami CKM syndrómu u pacientov s DM2 a CKD: čo prináša post-hoc analýza FIDELITY</a></li>
  <li><a href="article.php?slug=tirzepatid-oblickove-vysledky-surpass-nefrologia">Tirzepatid a obličkové výsledky v programe SURPASS: čo znamenajú pre nefrológiu</a></li>
  <li><a href="article.php?slug=semaglutid-ckd-porovnanie-glp1-realna-prax">Semaglutid a riziko chronickej choroby obličiek pri diabete 2. typu: porovnanie agonistov GLP-1 v reálnej praxi</a></li>
</ul>

<hr>

<div class="pdf-avoid-break">
<h2>Zdroje</h2>

<ol>
  <li><strong>Heerspink HJL, Stefánsson BV, Correa-Rotter R, a spol.; DAPA-CKD Trial Committees and Investigators.</strong> <em>Dapagliflozin in Patients with Chronic Kidney Disease.</em> N Engl J Med. 2020;383(15):1436–1446. doi: 10.1056/NEJMoa2024816. <a href="https://doi.org/10.1056/NEJMoa2024816" target="_blank" rel="noopener noreferrer">Štúdia DAPA-CKD</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/32970396/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>The EMPA-KIDNEY Collaborative Group; Herrington WG, Staplin N, a spol.</strong> <em>Empagliflozin in Patients with Chronic Kidney Disease.</em> N Engl J Med. 2023;388(2):117–127. doi: 10.1056/NEJMoa2204233. <a href="https://doi.org/10.1056/NEJMoa2204233" target="_blank" rel="noopener noreferrer">Štúdia EMPA-KIDNEY</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/36331190/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Perkovic V, Jardine MJ, Neal B, a spol.; CREDENCE Trial Investigators.</strong> <em>Canagliflozin and Renal Outcomes in Type 2 Diabetes and Nephropathy.</em> N Engl J Med. 2019;380(24):2295–2306. doi: 10.1056/NEJMoa1811744. <a href="https://doi.org/10.1056/NEJMoa1811744" target="_blank" rel="noopener noreferrer">Štúdia CREDENCE</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/30990260/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Perkovic V, Tuttle KR, Rossing P, a spol.; FLOW Trial Committees and Investigators.</strong> <em>Effects of Semaglutide on Chronic Kidney Disease in Patients with Type 2 Diabetes.</em> N Engl J Med. 2024;391(2):109–121. doi: 10.1056/NEJMoa2403347. <a href="https://doi.org/10.1056/NEJMoa2403347" target="_blank" rel="noopener noreferrer">Štúdia FLOW</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/38785209/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Bakris GL, Agarwal R, Anker SD, a spol.; FIDELIO-DKD Investigators.</strong> <em>Effect of Finerenone on Chronic Kidney Disease Outcomes in Type 2 Diabetes.</em> N Engl J Med. 2020;383(23):2219–2229. doi: 10.1056/NEJMoa2025845. <a href="https://doi.org/10.1056/NEJMoa2025845" target="_blank" rel="noopener noreferrer">Štúdia FIDELIO-DKD</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/33264825/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Agarwal R, Green JB, Heerspink HJL, Mann JFE, McGill JB, Mottl AK, a spol.; CONFIDENCE Investigators.</strong> <em>Finerenone with Empagliflozin in Chronic Kidney Disease and Type 2 Diabetes.</em> N Engl J Med. 2025;393(6):533–543. doi: 10.1056/NEJMoa2410659. <a href="https://doi.org/10.1056/NEJMoa2410659" target="_blank" rel="noopener noreferrer">Štúdia CONFIDENCE</a>; <a href="https://pubmed.ncbi.nlm.nih.gov/40470996/" target="_blank" rel="noopener noreferrer">PubMed</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) Diabetes Work Group.</strong> <em>KDIGO 2022 Clinical Practice Guideline for Diabetes Management in Chronic Kidney Disease.</em> Kidney Int. 2022;102(5 Suppl):S1–S127. doi: 10.1016/j.kint.2022.06.008. Inštitucionálne skupinové autorstvo. <a href="https://kdigo.org/guidelines/diabetes-ckd/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Kidney Disease: Improving Global Outcomes (KDIGO) CKD Work Group.</strong> <em>KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease.</em> Kidney Int. 2024;105(4 Suppl):S117–S314. doi: 10.1016/j.kint.2023.10.018. <a href="https://kdigo.org/guidelines/ckd-evaluation-and-management/" target="_blank" rel="noopener noreferrer">Odporúčanie KDIGO</a>.</li>
  <li><strong>Medscape Education.</strong> <em>Cardioprotective Antihyperglycemic Strategies for Cardiorenal Risk in Type 2 Diabetes.</em> Medscape, 2026. Vzdelávací modul použitý ako podnet k téme; plný text nie je voľne dostupný, preto sa mu v článku nepripisujú konkrétne tvrdenia. <a href="https://www.medscape.org/viewarticle/medscape-now-cardioprotective-antihyperglycemic-strategies-2026a1000s58" target="_blank" rel="noopener noreferrer">Vzdelávací modul</a>.</li>
</ol>

<p><em><strong>Poznámka k spracovaniu:</strong> Všetky pomery rizík a intervaly spoľahlivosti boli overené priamo proti sekciám Results publikovaných abstraktov v PubMed: DAPA-CKD 0,61 (0,51–0,72) a NNT 19 (PMID 32970396); EMPA-KIDNEY 0,72 (0,64–0,82) (PMID 36331190); CREDENCE 0,70 (0,59–0,82) a renálny kompozit 0,66 (0,53–0,81) (PMID 30990260); FLOW 0,76 (0,66–0,88), obličkový kompozit 0,79 (0,66–0,94), kardiovaskulárne úmrtie 0,71 (0,56–0,89) a rozdiel v ročnom sklone eGFR 1,16 ml/min/1,73 m² (PMID 38785209); FIDELIO-DKD 0,82 (0,73–0,93) a prerušenie pre hyperkaliémiu 2,3 % oproti 0,9 % (PMID 33264825); CONFIDENCE rozdiel v poklese UACR o 29 % a 32 % (PMID 40470996). Identita všetkých šiestich štúdií bola overená cez DOI v Crossref — <strong>kľúčové upozornenie:</strong> vyhľadávanie podľa názvu v PubMed vracalo pri každej z nich ako prvý výsledok nedávnu sekundárnu prácu, nie pôvodnú štúdiu, preto boli PMID priradené cez DOI. Hranica eGFR na začatie liečby sa v článku zámerne neuvádza číselne, pretože sa medzi molekulami líši a nebola overená proti platným súhrnom charakteristických vlastností liekov.</em></p>

<p><em><strong>Poznámka k interpretácii:</strong> Článok je rozhodovací rámec, nie liečebný protokol. Voľba a kombinácia liečby pri diabete 2. typu s kardiorenálnymi komorbiditami patrí do rúk ošetrujúceho lekára a riadi sa platnými odporúčaniami, súhrnom charakteristických vlastností konkrétneho lieku, funkciou obličiek, komorbiditami a preferenciami pacienta. Údaje o kombináciách sa zatiaľ opierajú prevažne o náhradné ukazovatele.</em></p>
</div>
HTML,
];

$result = upsertArticles($pdo, $articles, 'odborne', [
    'enqueue_newsletter' => true,
    'regenerate_pdf' => true,
    'log_prefix' => 'add_vyber-sglt2-glp1-dualne-agonisty-kardiorenalne-riziko_article',
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
