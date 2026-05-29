<?php
/**
 * Jednorazový UPDATE skript – jazyková korektúra článku nsMRA/T2D/CKD.
 * Spustiť raz cez SSH, potom zmazať.
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

$slug = 'nsmra-t2d-ckd-perzistujuca-albuminuria';

$content = <<<'HTML'
<p>U pacienta s <strong>diabetom 2. typu (T2D)</strong> a <strong>chronickým ochorením obličiek (CKD)</strong>, ktorý má <strong>pretrvávajúcu albuminúriu napriek maximálne tolerovanej liečbe v osi RAS</strong>, dáva zmysel zvážiť prídavok <strong>nesteroidného antagonistu mineralokortikoidového receptora (nsMRA)</strong>. Výsledkom má byť zlepšenie „cardio-kidney" dopadov a spomalenie nepriaznivého priebehu.</p>

<h2>Indikačný rámec (prakticky)</h2>

<p>Zváž prínos nsMRA, ak sú splnené tieto podmienky:</p>
<ol>
  <li><strong>T2D + CKD</strong></li>
  <li><strong>pretrvávajúca albuminúria</strong></li>
  <li>pacient už dostáva <strong>maximálne tolerovanú liečbu v osi RAS</strong> (ACE inhibítor alebo AT1 blokátor) a albuminúria pretrváva</li>
</ol>
<p>Toto je situácia, kde sa nsMRA považujú za ďalší krok v „treatment pillar" prístupe.</p>

<h2>Rýchly „work-up" pred nasadením</h2>

<p>Skôr než začneš, nastav si kontrolný rámec tak, aby si minimalizoval riziko nežiaducich účinkov (najmä hyperkaliémie) a aby dávalo zmysel aj časovanie kontrol.</p>

<h3>Laboratórny prehľad (pred nasadením)</h3>
<ul>
  <li><strong>kreatinín / eGFR</strong></li>
  <li><strong>draslík (K⁺)</strong></li>
  <li>podľa lokálneho protokolu aj <strong>acidobázická rovnováha</strong> a ďalšie parametre rizika hyperkaliémie</li>
</ul>

<h3>Zhodnoť riziká hyperkaliémie</h3>
<p>V praxi sú to typicky:</p>
<ul>
  <li>vyšší východiskový draslík,</li>
  <li>výraznejšia renálna insuficiencia,</li>
  <li>lieky zvyšujúce draslík (presahy medikácie si skontrolovať),</li>
  <li>stavy s vyšším rizikom dehydratácie (infekcia, vracanie, interkurentné ochorenie).</li>
</ul>

<h2>Algoritmus: ako postupovať v ambulancii</h2>

<h3>Krok A: potvrdíš, že albuminúria pretrváva</h3>
<ul>
  <li>over, že nejde o prechodný stav</li>
  <li>pracuj s trendom (opakované merania, ak máte nastavený systém v poradni)</li>
</ul>

<h3>Krok B: zabezpečíš „core" liečbu</h3>
<p>Títo antagonisti sa zvyčajne pridávajú až vtedy, keď:</p>
<ul>
  <li>RAS inhibícia je už v maximálne tolerovanej podobe,</li>
  <li>ďalšie nefro-metabolické piliere (napr. SGLT2 inhibícia u vhodných pacientov) sú už riešené podľa štandardu starostlivosti.</li>
</ul>

<h3>Krok C: nasadenie nsMRA</h3>
<ul>
  <li>nastav si jasný plán kontrol laboratórií</li>
  <li>pacientovi vysvetli, že ide o liečbu s cieľom nefro-kardiálnej ochrany, ale s potrebou kontroly K⁺</li>
</ul>

<h3>Krok D: kontrola po nasadení</h3>
<p>V praxi sa kontroluje najmä <strong>K⁺ a renálne parametre</strong> krátko po začatí a následne podľa rizika. Presné načasovanie si zosúladíš s lokálnym protokolom a východiskovým rizikom konkrétneho pacienta.</p>

<h3>Krok E: úprava pri nežiaducich účinkoch</h3>
<ul>
  <li>ak K⁺ stúpne, postupuj podľa lokálnych pravidiel (redukcia, dočasné prerušenie, úprava sprievodnej medikácie, riešenie precipitujúcich faktorov)</li>
  <li>dôležité je mať v ambulancii pripravený „plan B", aby sa pacient nedostal do dlhého čakania bez monitorovania</li>
</ul>

<h2>Praktický príklad zo vzdelávacieho materiálu</h2>

<p>V materiáli je uvedený pacient „Mark" (52 rokov) s <strong>T2D a CKD</strong>, ktorý už má:</p>
<ul>
  <li><strong>empagliflozín</strong>,</li>
  <li><strong>ramipril</strong>,</li>
  <li>napriek tomu pretrváva miernejšia proteinúria a rieši sa aj metabolický aspekt (hmotnosť).</li>
</ul>
<p>V rozhodovacom modeli sa potom pridáva:</p>
<ul>
  <li><strong>semaglutid</strong> (metabolický cieľ, úprava hmotnosti),</li>
  <li><strong>finerenone</strong> (nsMRA) ako ďalší krok pri pretrvávajúcej albuminúrii, aj keď je RAS inhibícia už zavedená.</li>
</ul>
<p>Tento príklad ukazuje, že nsMRA je „doplnok do stratégie", nie izolovaný zásah.</p>

<h2>Mechanistické pozadie (pre pochopenie)</h2>

<p>Nadmerná aktivácia MR sa spája s nepriaznivými procesmi v obličkách a srdci. Preto sa nsMRA prezentujú ako lieky, ktoré zasahujú do „škodlivých dráh" pri kardioreálnom prepojení.</p>
<p>Pri ambulantnom vysvetľovaní pacientovi stačí povedať v jednoduchej forme:</p>
<ul>
  <li>liek cieli nepriaznivé signály v tkanivách,</li>
  <li>tým pomáha chrániť obličky aj kardiovaskulárny systém,</li>
  <li>a preto treba kontrolovať draslík.</li>
</ul>

<h2>Záver</h2>

<p>U pacienta s <strong>T2D a CKD</strong> s <strong>perzistujúcou albuminúriou napriek maximálne tolerovanej RAS inhibícii</strong> je <strong>nsMRA</strong> logickým ďalším krokom. Kľúčom k bezpečnej implementácii je vopred nastavený plán kontrol (najmä <strong>K⁺</strong> a renálnych parametrov) a jasná komunikácia s pacientom.</p>

<hr>

<p><em><strong>Zdroj:</strong> Medscape Education Cardiology, „The Evolving Role of Nonsteroidal MRAs for Heart and Kidney Disease", uverejnené 30. 5. 2025. <a href="https://www.medscape.org/viewarticle/1002559" target="_blank" rel="noopener noreferrer">https://www.medscape.org/viewarticle/1002559</a>.</em></p>
HTML;

$stmt = $pdo->prepare(
    "UPDATE articles SET content = :content, updated_at = NOW() WHERE slug = :slug"
);
$stmt->execute(['content' => $content, 'slug' => $slug]);
$rows = $stmt->rowCount();

if (php_sapi_name() === 'cli') {
    echo "\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "UPDATE článku: $slug\n";
    echo "──────────────────────────────────────────────────────\n";
    echo "Zmenených riadkov: $rows\n";
    echo "──────────────────────────────────────────────────────\n\n";
} else {
    echo "<p>Zmenených riadkov: $rows</p>";
}
?>
