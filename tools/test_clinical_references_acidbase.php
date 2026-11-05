<?php

declare(strict_types=1);

/**
 * P1 klinické referenčné príklady: aniónová medzera, Figgeho korekcia, Δ/Δ a Winters.
 *
 * Figge J a kol. (Crit Care Med 1998;26(11):1807–1810, PMID 9824071): +0,25 mmol/L
 * AG na každý g/L poklesu albumínu (pri g/dL faktor 2,5).
 * Rastegar A (J Am Soc Nephrol 2007;18(9):2429–2431, PMID 17656477): koncept
 * ΔAG/ΔHCO₃; pásma < 0,4 / < 0,8 / < 2,0 sú výučbová konvencia pinovaná tu.
 * Albert MS, Dell RB, Winters RW (Ann Intern Med 1967;66(2):312–322, PMID 6016545):
 * pCO₂_očak. = 1,5 · HCO₃ + 8 (± 2 mmHg) pri metabolickej acidóze.
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

// ─── Wintersova kompenzácia (PMID 6016545) ───
// HCO₃ 16 → 1,5 · 16 + 8 = 32; pásmo 30 až 34 mmHg
$w = calculatorWintersCompensation(16.0, null);
acidbaseRefTest($w !== null, 'Winters platí pri HCO₃ 16.');
acidbaseRefTest($w['expected_pco2'] === 32.0, 'Winters: očakávané pCO₂ 32 pri HCO₃ 16.');
acidbaseRefTest($w['expected_pco2_low'] === 30.0 && $w['expected_pco2_high'] === 34.0, 'Winters pásmo ± 2.');
acidbaseRefTest(
    str_contains($w['interpretation'], 'bez nameranej'),
    'Bez pCO₂ ostáva všeobecná hláška Winters.',
);
$okComp = calculatorWintersCompensation(16.0, 32.0);
acidbaseRefTest(
    $okComp !== null && str_contains($okComp['interpretation'], 'primeraná'),
    'pCO₂ 32 v pásme = primeraná kompenzácia.',
);
$respAlk = calculatorWintersCompensation(16.0, 28.0);
acidbaseRefTest(
    $respAlk !== null && str_contains($respAlk['interpretation'], 'respiračná alkalóza'),
    'pCO₂ pod pásmom = súbežná respiračná alkalóza.',
);
$respAcid = calculatorWintersCompensation(16.0, 36.0);
acidbaseRefTest(
    $respAcid !== null && str_contains($respAcid['interpretation'], 'respiračná acidóza'),
    'pCO₂ nad pásmom = súbežná respiračná acidóza.',
);
acidbaseRefTest(
    calculatorWintersCompensation(24.0, 40.0) === null,
    'Pri HCO₃ ≥ 24 Winters neplatí.',
);
acidbaseRefApprox(
    1.5 * 10.0 + 8.0,
    (float) (calculatorWintersCompensation(10.0)['expected_pco2'] ?? 0.0),
    1e-9,
    'Winters pri HCO₃ 10 → 23,0',
);

// ─── Wiring + citácie ───
$page = (string) file_get_contents(dirname(__DIR__) . '/calculator_acidbase.php');
acidbaseRefTest(str_contains($page, 'calculatorAnionGapAnalysis('), 'calculator_acidbase.php musí volať calculatorAnionGapAnalysis.');
acidbaseRefTest(str_contains($page, 'calculatorWintersCompensation('), 'calculator_acidbase.php musí volať calculatorWintersCompensation.');
acidbaseRefTest(
    !str_contains($page, '0.25 * (40.0')
        && !str_contains($page, 'function calculatorAnionGap')
        && !str_contains($page, 'function calculatorWinters'),
    'calculator_acidbase.php nesmie mať vlastnú kópiu logiky.',
);
acidbaseRefTest(
    str_contains($page, 'pubmed.ncbi.nlm.nih.gov/9824071/')
        && str_contains($page, 'pubmed.ncbi.nlm.nih.gov/17656477/')
        && str_contains($page, 'pubmed.ncbi.nlm.nih.gov/6016545/')
        && str_contains($page, 'Figge')
        && str_contains($page, 'Rastegar')
        && str_contains($page, 'Winters'),
    'Citácie Figge 1998, Rastegar 2007 a Albert/Winters 1967 s PMID.',
);

echo "Clinical references (AG, Figge, Δ/Δ, Winters): $checks PASS\n";
