<?php
declare(strict_types=1);
/**
 * medimpax_cta.php — kontextové CTA na Dialyzačné stredisko Medimpax.
 *
 * Zobrazí sa na konci článku, ale IBA ak je článok tematicky relevantný
 * (dialýza / CKD / náhrada funkcie obličiek). Cieľom je nenásilne nasmerovať
 * existujúcu organickú návštevnosť na landing page strediska.
 *
 * Vyžaduje pole $article (title, excerpt) v scope volajúceho (article.php).
 */
if (!isset($article) || !is_array($article)) {
    return;
}

$_mpaxHaystack = mb_strtolower(
    (string) ($article['title'] ?? '') . ' ' . (string) ($article['excerpt'] ?? ''),
    'UTF-8'
);

// Cielené kľúčové slová — dialýza / CKD / zlyhanie obličiek (vrátane variantov bez diakritiky).
// Zámerne úzke: nechceme CTA na každom nefrologickom článku, len na priamo relevantných.
$_mpaxKeywords = [
    'dialýz', 'dialyz', 'hemodial', 'peritoneál', 'peritoneal', 'hemodiafiltr',
    'ckd', 'chronické ochorenie obličiek', 'chronicke ochorenie obliciek',
    'zlyhanie obličiek', 'zlyhanie obliciek', 'náhrada funkcie obličiek',
    'renáln', 'renaln', 'predialýz', 'predialyz', 'urémi', 'uremi',
    'egfr', 'kfre', 'transplantác', 'transplantac',
];

$_mpaxRelevant = false;
foreach ($_mpaxKeywords as $_kw) {
    if (mb_strpos($_mpaxHaystack, $_kw) !== false) {
        $_mpaxRelevant = true;
        break;
    }
}

if (!$_mpaxRelevant) {
    return;
}
?>
<aside class="info-box-blue medimpax-cta" aria-label="Dialyzačné stredisko Medimpax v Bratislave">
  <p class="medimpax-cta__text">
    <strong>Potrebujete dialýzu alebo nefrologické vyšetrenie v Bratislave?</strong>
    Dialyzačné stredisko a nefrologická ambulancia <strong>Medimpax</strong> (Bratislava-Dúbravka)
    poskytuje hemodialýzu, hemodiafiltráciu, peritoneálnu dialýzu aj prázdninové (dovolenkové) dialýzy.
  </p>
  <p class="medimpax-cta__cta">
    <a class="btn-primary" href="dialyza-bratislava.php">Zistiť viac o stredisku →</a>
  </p>
</aside>
