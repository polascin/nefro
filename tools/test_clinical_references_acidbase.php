<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: aniónová medzera, Figgeho korekcia a Δ/Δ pomer.
 *
 * Figge J a kol. (Crit Care Med 1998;26(11):1807–1810, PMID 9824071): +0,25 mmol/L
 * AG na každý g/L poklesu albumínu (pri g/dL faktor 2,5).
 * Rastegar A (J Am Soc Nephrol 2007;18(9):2429–2431, PMID 17656477): koncept
 * ΔAG/ΔHCO₃; pásma < 0,4 / < 0,8 / < 2,0 sú výučbová konvencia pinovaná tu.
 * Očakávané hodnoty sú z rovníc; wiring asserty proti kópii logiky na stránke.
 */

require_once dirname(__DIR__) . '/calculators_common.php';

$checks = 0;

function acidbaseRefTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

function acidbaseRefApprox(float $expected, float $actual, float $tol, string $message): void
{
    acidbaseRefTest(
        abs($expected - $actual) <= $tol,
        $message . ': očakávané ' . $expected . ', získané ' . $actual,
    );
}

// ─── Klasický high-AG príklad ───
// Na 140, Cl 104, HCO₃ 16, Alb 40 → AG 20; Δ = (20 − 12) / (24 − 16) = 1,0
$pure = calculatorAnionGapAnalysis(140.0, 104.0, 16.0, 40.0);
acidbaseRefTest($pure['ag'] === 20.0 && $pure['corrected_ag'] === 20.0, 'Klasický AG 20 bez korekcie albumínu.');
acidbaseRefTest($pure['delta_ratio'] === 1.0, 'Δ/Δ pomer 1,0 = čistá high-AG acidóza.');
acidbaseRefTest(
    $pure['interpretation'] === 'Čistá high-AG metabolická acidóza.',
    'Interpretácia pri pomere 1,0.',
);

// ─── Figgeho korekcia ───
// Alb 20 g/L: +0,25 · 20 = +5 → korigované AG 25; Δ = 13 / 8 = 1,625 → 1,63
$hypo = calculatorAnionGapAnalysis(140.0, 104.0, 16.0, 20.0);
acidbaseRefTest($hypo['ag'] === 20.0, 'Nekorigované AG ostáva 20 pri hypoalbuminémii.');
acidbaseRefTest($hypo['corrected_ag'] === 25.0, 'Figge: AG + 5 pri Alb 20 g/L.');
acidbaseRefTest($hypo['delta_ratio'] === 1.63, 'Δ/Δ z korigovaného AG.');
acidbaseRefApprox(2.5, ACIDBASE_ALBUMIN_CORR_PER_GL * 10.0, 1e-9, 'Faktor 0,25/g/L = 2,5/g/dL.');

// ─── Hyperchloremická (normálna AG) acidóza ───
// Na 140, Cl 120, HCO₃ 16 → AG 4; Δ = (4 − 12) / 8 = −1,0 → < 0,4
$nagma = calculatorAnionGapAnalysis(140.0, 120.0, 16.0, 40.0);
acidbaseRefTest($nagma['ag'] === 4.0 && $nagma['delta_ratio'] === -1.0, 'NAGMA: AG 4, Δ −1,0.');
acidbaseRefTest(
    str_starts_with($nagma['interpretation'], 'Hyperchloremická'),
    'Interpretácia NAGMA.',
);

// ─── Hranice pásiem (ostré <) ───
acidbaseRefTest(
    calculatorAnionGapDeltaInterpretation(0.399) === 'Hyperchloremická (normálna AG) metabolická acidóza.',
    'Pomer 0,399 je NAGMA.',
);
acidbaseRefTest(
    calculatorAnionGapDeltaInterpretation(0.4) === 'Zmiešaná high-AG a normálna-AG metabolická acidóza.',
    'Pomer 0,4 je zmiešaná acidóza.',
);
acidbaseRefTest(
    calculatorAnionGapDeltaInterpretation(0.799) === 'Zmiešaná high-AG a normálna-AG metabolická acidóza.',
    'Pomer 0,799 je zmiešaná acidóza.',
);
acidbaseRefTest(
    calculatorAnionGapDeltaInterpretation(0.8) === 'Čistá high-AG metabolická acidóza.',
    'Pomer 0,8 je čistá high-AG.',
);
acidbaseRefTest(
    calculatorAnionGapDeltaInterpretation(1.999) === 'Čistá high-AG metabolická acidóza.',
    'Pomer 1,999 je čistá high-AG.',
);
acidbaseRefTest(
    str_starts_with(calculatorAnionGapDeltaInterpretation(2.0), 'High-AG metabolická acidóza +'),
    'Pomer 2,0 je high-AG + alkalóza/resp. acidóza.',
);

// ─── ΔHCO₃ príliš blízko nule ───
$near = calculatorAnionGapAnalysis(140.0, 104.0, 24.4, 40.0);
acidbaseRefTest($near['delta_ratio'] === null, 'Pri |ΔHCO₃| ≤ 0,5 nie je Δ/Δ.');
acidbaseRefTest(
    str_contains($near['interpretation'], 'príliš blízko nule'),
    'Hláška pri nulovom ΔHCO₃.',
);
$edge = calculatorAnionGapAnalysis(140.0, 104.0, 23.4, 40.0);
acidbaseRefTest($edge['delta_ratio'] !== null, 'Pri |ΔHCO₃| > 0,5 sa Δ/Δ počíta.');

// ─── Wiring + citácie ───
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_acidbase.php');
acidbaseRefTest(str_contains($page, 'calculatorAnionGapAnalysis('), 'calculator_acidbase.php musí volať calculatorAnionGapAnalysis.');
acidbaseRefTest(
    !str_contains($page, '0.25 * (40.0') && !str_contains($page, 'function calculatorAnionGap'),
    'calculator_acidbase.php nesmie mať vlastnú kópiu logiky.',
);
acidbaseRefTest(
    str_contains($page, 'pubmed.ncbi.nlm.nih.gov/9824071/')
        && str_contains($page, 'pubmed.ncbi.nlm.nih.gov/17656477/')
        && str_contains($page, 'Figge')
        && str_contains($page, 'Rastegar'),
    'Citácie Figge 1998 a Rastegar 2007 s PMID.',
);

echo "Clinical references (AG, Figge, Δ/Δ): $checks PASS\n";
