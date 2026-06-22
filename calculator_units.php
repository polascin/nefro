<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/calculators_common.php';

// Prevodník je čisto klientský (nonce'd JS), bez ukladania a bez spracovania POST.
// Konverzné faktory: SI = konvenčné × faktor. Zhodné s dokumentovanými hodnotami
// projektu (cholesterol ÷38,67; glukóza ÷18; triglyceridy ÷88,57).
$unitRows = [
    // [analyt, konv. jednotka, SI jednotka, faktor (SI = konv × faktor), dec_konv, dec_si]
    ["Kreatinín", "mg/dL", "µmol/L", 88.4, 2, 0],
    ["Urea (BUN)", "mg/dL (BUN)", "mmol/L (urea)", 0.357, 1, 1],
    ["Glukóza", "mg/dL", "mmol/L", 0.0555, 0, 1],
    ["Vápnik", "mg/dL", "mmol/L", 0.2495, 1, 2],
    ["Fosfát (P)", "mg/dL", "mmol/L", 0.3229, 1, 2],
    ["Magnézium", "mg/dL", "mmol/L", 0.4114, 1, 2],
    ["Kyselina močová", "mg/dL", "µmol/L", 59.48, 1, 0],
    ["Cholesterol", "mg/dL", "mmol/L", 0.02586, 0, 2],
    ["Triglyceridy", "mg/dL", "mmol/L", 0.01129, 0, 2],
    ["Hemoglobín", "g/dL", "g/L", 10.0, 1, 0],
    ["Albumín", "g/dL", "g/L", 10.0, 1, 0],
    ["Bilirubín", "mg/dL", "µmol/L", 17.1, 1, 0],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Prevodník jednotiek (SI ⇄ konvenčné) | Kalkulačky | Nefro-projekt Slovensko";
  $canonicalUrl = "https://nefro.polascin.net/calculator_units.php";
  $seoDescription =
      "Nefrologický prevodník laboratórnych jednotiek medzi SI a konvenčnými (kreatinín, urea/BUN, glukóza, vápnik, fosfát, cholesterol a ďalšie). Obojsmerná živá konverzia pre lekárov na Slovensku.";
  $baseUrl = "https://nefro.polascin.net/";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => "BreadcrumbList",
          "itemListElement" => [
              [
                  "@type" => "ListItem",
                  "position" => 1,
                  "name" => "Domov",
                  "item" => $baseUrl,
              ],
              [
                  "@type" => "ListItem",
                  "position" => 2,
                  "name" => "Kalkulačky",
                  "item" => $baseUrl . "calculators.php",
              ],
              [
                  "@type" => "ListItem",
                  "position" => 3,
                  "name" => "Prevodník jednotiek",
                  "item" => $baseUrl . "calculator_units.php",
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Prevodník jednotiek";
    $headerIntro = "SI ⇄ konvenčné laboratórne jednotky";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Prevodník laboratórnych jednotiek</h2>
                <p class="auth-subtitle">Obojsmerná konverzia medzi SI a konvenčnými (US) jednotkami — píšte do ktoréhokoľvek poľa.</p>

                <div class="info-box">
                    <strong>Ako to funguje:</strong> zadajte hodnotu do ľavého alebo pravého poľa
                    a druhé sa prepočíta naživo. Desatinná čiarka aj bodka sú akceptované. Hodnoty
                    sú orientačné — referenčné rozsahy závisia od laboratória a metódy.
                </div>

                <div class="form-section">
                    <h3>Konverzie</h3>
                    <div class="unit-converter" role="group" aria-label="Prevodník jednotiek">
                        <?php foreach ($unitRows as $i => $r): [$name, $convUnit, $siUnit, $factor, $decConv, $decSi] = $r; ?>
                            <div class="unit-row"
                                 data-factor="<?= htmlspecialchars((string) $factor) ?>"
                                 data-dec-conv="<?= (int) $decConv ?>"
                                 data-dec-si="<?= (int) $decSi ?>">
                                <span class="unit-row__label" id="unitlbl<?= $i ?>"><?= htmlspecialchars($name) ?></span>
                                <span class="unit-row__cell">
                                    <input type="text" inputmode="decimal" class="form-control unit-conv"
                                           aria-labelledby="unitlbl<?= $i ?>"
                                           aria-label="<?= htmlspecialchars($name . " v " . $convUnit) ?>">
                                    <span class="unit-row__unit"><?= htmlspecialchars($convUnit) ?></span>
                                </span>
                                <span class="unit-row__eq" aria-hidden="true">⇄</span>
                                <span class="unit-row__cell">
                                    <input type="text" inputmode="decimal" class="form-control unit-si"
                                           aria-label="<?= htmlspecialchars($name . " v " . $siUnit) ?>">
                                    <span class="unit-row__unit"><?= htmlspecialchars($siUnit) ?></span>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-actions no-print">
                        <button type="button" class="btn-secondary js-units-reset">Vymazať polia</button>
                        <a href="calculators.php" class="btn-secondary">Späť na prehľad</a>
                    </div>
                </div>
            </div>

            <?php include "calculator_disclaimer.php"; ?>
        </div>
    </main>

    <script nonce="<?= htmlspecialchars(function_exists('getScriptNonce') ? getScriptNonce() : '', ENT_QUOTES) ?>">
    (function () {
        function parseNum(v) {
            var n = parseFloat(String(v).replace(',', '.').trim());
            return isNaN(n) ? null : n;
        }
        function fmt(x, d) {
            if (!isFinite(x)) { return ''; }
            var p = Math.pow(10, d);
            return (Math.round(x * p) / p).toString().replace('.', ',');
        }
        document.querySelectorAll('.unit-row').forEach(function (row) {
            var conv = row.querySelector('.unit-conv');
            var si = row.querySelector('.unit-si');
            var f = parseFloat(row.getAttribute('data-factor'));
            var dC = parseInt(row.getAttribute('data-dec-conv') || '2', 10);
            var dS = parseInt(row.getAttribute('data-dec-si') || '2', 10);
            if (!conv || !si || !isFinite(f)) { return; }
            conv.addEventListener('input', function () {
                var v = parseNum(conv.value);
                si.value = (v === null) ? '' : fmt(v * f, dS);
            });
            si.addEventListener('input', function () {
                var v = parseNum(si.value);
                conv.value = (v === null) ? '' : fmt(v / f, dC);
            });
        });
        var resetBtn = document.querySelector('.js-units-reset');
        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                document.querySelectorAll('.unit-row input').forEach(function (el) { el.value = ''; });
            });
        }
    })();
    </script>

    <?php include "footer.php"; ?>
</body>
</html>
