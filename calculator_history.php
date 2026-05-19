<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$pageTitle = 'História výpočtov | Nefro-projekt Slovensko';
$errors    = [];
$messages  = [];

// Mapovanie kľúčov na ľudsky čitateľné názvy
const CALC_LABELS = [
    'egfr_ckd_epi_2021'   => 'eGFR (CKD-EPI 2021)',
    'kdigo_risk'          => 'KDIGO G/A riziko',
    'kfre'                => 'KFRE – Kidney Failure Risk',
    'ckd_pc_grams_2022'   => 'CKD-PC (Grams 2022)',
    'igan_risk'           => 'IgAN riziko',
    'adpkd_mayo'          => 'Mayo ADPKD',
    'aki_fenafeurea'      => 'AKI – FENa/FEUrea',
    'cockcroft_gault'     => 'Cockcroft-Gault',
    'corrected_calcium'   => 'Korigovaný vápnik',
    'sodium_disorders'    => 'Poruchy sodíka',
    'anion_gap'           => 'Aniónová medzera',
    'egfr_slope'          => 'eGFR Slope',
    'ktv_urr'             => 'Kt/V a URR',
    'uacr'                => 'UACR',
];

const CALC_URLS = [
    'egfr_ckd_epi_2021'   => 'calculator_egfr.php',
    'kdigo_risk'          => 'calculator_kdigo_risk.php',
    'kfre'                => 'calculator_kfre.php',
    'ckd_pc_grams_2022'   => 'calculator_ckdpc.php',
    'igan_risk'           => 'calculator_igan.php',
    'adpkd_mayo'          => 'calculator_adpkd.php',
    'aki_fenafeurea'      => 'calculator_aki.php',
    'cockcroft_gault'     => 'calculator_cg.php',
    'corrected_calcium'   => 'calculator_ca.php',
    'sodium_disorders'    => 'calculator_na.php',
    'anion_gap'           => 'calculator_acidbase.php',
    'egfr_slope'          => 'calculator_egfr_slope.php',
    'ktv_urr'             => 'calculator_ktv.php',
    'uacr'                => 'calculator_uacr.php',
];

$allResults   = [];
$egfrTrend    = [];
$filterKey    = trim($_GET['calc'] ?? '');
$compareIds   = array_filter(array_map('intval', explode(',', $_GET['compare'] ?? '')));
$compareRows  = [];

// Vymazanie záznamu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token.';
    } elseif ($_POST['action'] === 'delete' && isLoggedIn()) {
        $rid = (int) ($_POST['result_id'] ?? 0);
        if ($rid > 0 && calculatorDeleteSavedResult($pdo, $rid, (int) $_SESSION['user_id'])) {
            $messages[] = 'Záznam bol vymazaný.';
        } else {
            $errors[] = 'Záznam sa nepodarilo vymazať.';
        }
    } elseif ($_POST['action'] === 'delete_all' && isLoggedIn()) {
        $key = trim($_POST['calc_key'] ?? '');
        if ($key !== '') {
            $stmt = $pdo->prepare('DELETE FROM calculator_results WHERE user_id = :u AND calculator_key = :k');
            $stmt->execute([':u' => (int) $_SESSION['user_id'], ':k' => $key]);
            $messages[] = 'Všetky záznamy pre túto kalkulačku boli vymazané.';
        }
    }
}

if (isLoggedIn()) {
    $allResults = calculatorFetchAllResults($pdo, (int) $_SESSION['user_id']);

    // eGFR trend — zoradený od najstarších po najnovšie
    foreach (array_reverse($allResults) as $r) {
        if ($r['calculator_key'] === 'egfr_ckd_epi_2021') {
            $egfr = (float) ($r['result_payload']['egfr'] ?? 0);
            if ($egfr > 0) {
                $egfrTrend[] = [
                    'date'     => substr((string) ($r['created_at'] ?? ''), 0, 10),
                    'egfr'     => $egfr,
                    'category' => (string) ($r['result_payload']['g_category'] ?? ''),
                    'patient'  => trim(
                        ((string) ($r['patient_first_name'] ?? '')) . ' ' .
                        ((string) ($r['patient_last_name'] ?? ''))
                    ),
                ];
            }
        }
    }

    // Porovnanie vybraných záznamov
    if (!empty($compareIds)) {
        foreach ($compareIds as $cid) {
            $row = calculatorFetchSavedResultById($pdo, $cid, (int) $_SESSION['user_id']);
            if ($row) {
                $compareRows[] = $row;
            }
        }
    }

    // Filter podľa kalkulačky
    if ($filterKey !== '') {
        $allResults = array_filter($allResults, fn($r) => $r['calculator_key'] === $filterKey);
    }
}

// Zoskupenie výsledkov podľa kalkulačky pre štatistiku
$statsByCalc = [];
foreach ($allResults as $r) {
    $k = $r['calculator_key'];
    if (!isset($statsByCalc[$k])) {
        $statsByCalc[$k] = ['count' => 0, 'label' => $r['calculator_label'] ?? CALC_LABELS[$k] ?? $k];
    }
    $statsByCalc[$k]['count']++;
}
arsort($statsByCalc); // zoradiť podľa počtu
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php include 'head_meta.php'; ?>
</head>
<body>
<?php
$headerTitle = 'História výpočtov';
$showLogo    = false;
include 'header.php';
?>

<main class="container calc-history-main">
  <?php if (!empty($errors)): ?>
    <div class="alert alert-error"><?= htmlspecialchars(implode(' ', $errors)) ?></div>
  <?php endif; ?>
  <?php if (!empty($messages)): ?>
    <div class="alert alert-success"><?= htmlspecialchars(implode(' ', $messages)) ?></div>
  <?php endif; ?>

  <?php if (!isLoggedIn()): ?>
    <div class="primary-article">
      <h2>História výpočtov</h2>
      <p>Pre zobrazenie histórie výpočtov je potrebné <a href="login.php">prihlásenie</a>.</p>
      <p>Neprihlásení používatelia môžu použiť tlačidlo <strong>„Vypočítať a uložiť lokálne"</strong> priamo v kalkulačke — výsledok sa uloží do vášho prehliadača.</p>
    </div>
  <?php else: ?>

    <div class="calc-history-header">
      <div>
        <h2>História výpočtov</h2>
        <p class="calc-history-subtitle">
          <?= count($allResults) ?> záznamov<?= $filterKey ? ' — filtrované: ' . htmlspecialchars(CALC_LABELS[$filterKey] ?? $filterKey) : '' ?>
        </p>
      </div>
      <div class="calc-history-actions">
        <a href="calculator_history.php" class="btn-secondary<?= $filterKey === '' ? ' btn-secondary--active' : '' ?>">Všetky</a>
        <?php foreach ($statsByCalc as $k => $s): ?>
          <a href="?calc=<?= urlencode($k) ?>"
             class="btn-secondary<?= $filterKey === $k ? ' btn-secondary--active' : '' ?>"
             title="<?= htmlspecialchars($s['label']) ?>">
            <?= htmlspecialchars($s['label']) ?>
            <span class="calc-history-badge"><?= $s['count'] ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- eGFR Trend chart -->
    <?php if (!empty($egfrTrend) && ($filterKey === '' || $filterKey === 'egfr_ckd_epi_2021')): ?>
    <section class="primary-article calc-trend-section">
      <h3>Trend eGFR v čase</h3>
      <div class="calc-trend-wrap">
        <canvas id="egfrTrendChart" class="calc-trend-canvas" aria-label="Graf trendu eGFR"></canvas>
      </div>
      <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
      (function() {
        var data = <?= json_encode(array_values($egfrTrend), JSON_UNESCAPED_UNICODE) ?>;
        var canvas = document.getElementById('egfrTrendChart');
        if (!canvas || !canvas.getContext || data.length < 1) return;
        var ctx = canvas.getContext('2d');

        var W = canvas.offsetWidth || 700;
        var H = 180;
        canvas.width  = W;
        canvas.height = H;

        var PAD = { top: 20, right: 20, bottom: 40, left: 50 };
        var values = data.map(function(d) { return d.egfr; });
        var maxV = Math.max.apply(null, values.concat([120]));
        var minV = Math.max(0, Math.min.apply(null, values) - 10);

        function xPos(i) { return PAD.left + (i / Math.max(data.length - 1, 1)) * (W - PAD.left - PAD.right); }
        function yPos(v) { return PAD.top + (1 - (v - minV) / (maxV - minV)) * (H - PAD.top - PAD.bottom); }

        // G-category background bands
        var bands = [
          { from: 90,  to: maxV, color: 'rgba(34,197,94,0.08)'  },
          { from: 60,  to: 90,   color: 'rgba(134,239,172,0.12)' },
          { from: 45,  to: 60,   color: 'rgba(234,179,8,0.10)'  },
          { from: 30,  to: 45,   color: 'rgba(249,115,22,0.10)' },
          { from: 15,  to: 30,   color: 'rgba(239,68,68,0.10)'  },
          { from: minV,to: 15,   color: 'rgba(127,29,29,0.12)'  },
        ];
        bands.forEach(function(b) {
          var y1 = yPos(Math.min(b.to, maxV));
          var y2 = yPos(Math.max(b.from, minV));
          ctx.fillStyle = b.color;
          ctx.fillRect(PAD.left, y1, W - PAD.left - PAD.right, y2 - y1);
        });

        // Y-axis labels
        ctx.fillStyle = '#94a3b8';
        ctx.font = '11px system-ui, sans-serif';
        ctx.textAlign = 'right';
        [15, 30, 45, 60, 90].forEach(function(v) {
          if (v >= minV && v <= maxV) {
            var y = yPos(v);
            ctx.fillText(v, PAD.left - 6, y + 4);
            ctx.strokeStyle = 'rgba(148,163,184,0.2)';
            ctx.beginPath(); ctx.moveTo(PAD.left, y); ctx.lineTo(W - PAD.right, y); ctx.stroke();
          }
        });

        // X-axis labels (dates)
        ctx.textAlign = 'center';
        var step = data.length > 12 ? Math.ceil(data.length / 10) : 1;
        data.forEach(function(d, i) {
          if (i % step !== 0 && i !== data.length - 1) return;
          var x = xPos(i);
          ctx.fillStyle = '#94a3b8';
          ctx.fillText(d.date.slice(5), x, H - 8);
        });

        // Line
        ctx.strokeStyle = '#3b82f6';
        ctx.lineWidth = 2.5;
        ctx.lineJoin = 'round';
        ctx.beginPath();
        data.forEach(function(d, i) {
          var x = xPos(i), y = yPos(d.egfr);
          if (i === 0) ctx.moveTo(x, y); else ctx.lineTo(x, y);
        });
        ctx.stroke();

        // Points
        data.forEach(function(d, i) {
          var x = xPos(i), y = yPos(d.egfr);
          var catColors = {G1:'#22c55e',G2:'#86efac',G3a:'#eab308',G3b:'#f97316',G4:'#ef4444',G5:'#7f1d1d'};
          ctx.fillStyle = catColors[d.category] || '#3b82f6';
          ctx.beginPath();
          ctx.arc(x, y, 5, 0, Math.PI * 2);
          ctx.fill();
        });
      })();
      </script>
      <p class="calc-trend-legend">
        <span class="trend-cat trend-g1">G1 ≥90</span>
        <span class="trend-cat trend-g2">G2 60–89</span>
        <span class="trend-cat trend-g3a">G3a 45–59</span>
        <span class="trend-cat trend-g3b">G3b 30–44</span>
        <span class="trend-cat trend-g4">G4 15–29</span>
        <span class="trend-cat trend-g5">G5 &lt;15</span>
      </p>
    </section>
    <?php endif; ?>

    <!-- Porovnanie vybraných výsledkov -->
    <?php if (!empty($compareRows)): ?>
    <section class="primary-article calc-compare-section">
      <h3>Porovnanie vybraných výsledkov</h3>
      <div class="calc-compare-grid">
        <?php foreach ($compareRows as $cr):
          $rp = $cr['result_payload'];
          $inp = $cr['input_payload'];
        ?>
        <div class="calc-compare-card">
          <div class="calc-compare-card__header">
            <span class="calc-compare-card__label"><?= htmlspecialchars($cr['calculator_label'] ?? '') ?></span>
            <span class="calc-compare-card__date"><?= htmlspecialchars(date('d.m.Y', strtotime($cr['created_at'] ?? ''))) ?></span>
          </div>
          <div class="calc-compare-card__patient"><?= htmlspecialchars(calculatorBuildPatientDisplay($cr)) ?></div>
          <div class="calc-compare-card__result">
            <?php
            $key = $cr['calculator_key'] ?? '';
            if ($key === 'egfr_ckd_epi_2021'):
              $cat = $rp['g_category'] ?? '';
              echo '<div class="calc-result-badge ' . egfrRiskClass($cat) . '">';
              echo htmlspecialchars(number_format((float)($rp['egfr']??0),1,',',' ')) . ' ml/min';
              echo '<span>' . htmlspecialchars($cat) . '</span></div>';
            elseif ($key === 'kfre'):
              $r5 = (float)($rp['risk_5yr']??0);
              echo '<div class="calc-result-badge ' . kfreRiskClass($r5) . '">';
              echo '5r: ' . htmlspecialchars(number_format($r5,1,',',' ')) . '%';
              echo '</div>';
            else:
              echo '<pre class="calc-compare-raw">' . htmlspecialchars(
                json_encode($rp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
              ) . '</pre>';
            endif;
            ?>
          </div>
          <?php foreach ($inp as $k => $v): ?>
            <div class="calc-compare-card__row">
              <span class="calc-compare-card__key"><?= htmlspecialchars($k) ?></span>
              <span class="calc-compare-card__val"><?= htmlspecialchars((string)$v) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <a href="calculator_history.php<?= $filterKey ? '?calc='.urlencode($filterKey) : '' ?>" class="btn-secondary">Zavrieť porovnanie</a>
    </section>
    <?php endif; ?>

    <!-- Hlavná tabuľka histórie -->
    <?php if (empty($allResults)): ?>
      <div class="primary-article">
        <p>Zatiaľ nemáte žiadne uložené výsledky<?= $filterKey ? ' pre túto kalkulačku' : '' ?>.</p>
        <a href="calculators.php" class="btn-primary">Otvoriť kalkulačky</a>
      </div>
    <?php else: ?>
    <form method="GET" action="calculator_history.php" id="compare-form">
      <?php if ($filterKey): ?><input type="hidden" name="calc" value="<?= htmlspecialchars($filterKey) ?>"><?php endif; ?>
      <div class="primary-article calc-history-table-wrap">
        <div class="calc-history-table-toolbar">
          <span class="calc-history-table-count"><?= count($allResults) ?> záznamov</span>
          <button type="submit" name="compare" id="compare-btn" class="btn-secondary" style="display:none">
            Porovnať vybrané
          </button>
        </div>
        <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th></th>
              <th>Dátum</th>
              <th>Kalkulačka</th>
              <th>Pacient</th>
              <th>Výsledok</th>
              <th>Akcie</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($allResults as $row):
            $rp  = $row['result_payload'];
            $key = $row['calculator_key'];
            $url = CALC_URLS[$key] ?? null;

            // Zostavenie výsledku pre zobrazenie
            $resultText = '';
            $riskClass  = '';
            if ($key === 'egfr_ckd_epi_2021') {
                $egfr = (float)($rp['egfr'] ?? 0);
                $cat  = (string)($rp['g_category'] ?? '');
                $resultText = number_format($egfr, 1, ',', ' ') . ' ml/min (' . $cat . ')';
                $riskClass  = egfrRiskClass($cat);
            } elseif ($key === 'kfre') {
                $r5 = (float)($rp['risk_5yr'] ?? 0);
                $resultText = '5r: ' . number_format($r5, 1, ',', ' ') . '%';
                $riskClass  = kfreRiskClass($r5);
            } elseif ($key === 'kdigo_risk') {
                $resultText = (string)($rp['risk_label'] ?? $rp['combined_risk'] ?? '—');
            } elseif ($key === 'ckd_pc_grams_2022') {
                $r3 = (float)($rp['risk_3yr'] ?? 0);
                $resultText = '3r: ' . number_format($r3, 1, ',', ' ') . '%';
                $riskClass = $r3 < 5 ? 'risk-low' : ($r3 < 15 ? 'risk-moderate' : 'risk-high');
            } elseif ($key === 'cockcroft_gault') {
                $cg = (float)($rp['crcl'] ?? 0);
                $resultText = number_format($cg, 1, ',', ' ') . ' ml/min';
            } elseif ($key === 'uacr') {
                $val = (float)($rp['uacr_mg_g'] ?? 0);
                $resultText = number_format($val, 1, ',', ' ') . ' mg/g';
            } else {
                // Generický výsledok — prvá číselná hodnota
                foreach ($rp as $k => $v) {
                    if (is_numeric($v)) {
                        $resultText = htmlspecialchars($k) . ': ' . number_format((float)$v, 2, ',', ' ');
                        break;
                    }
                }
            }
          ?>
          <tr>
            <td>
              <input type="checkbox" name="compare[]" value="<?= (int)$row['id'] ?>"
                     class="compare-check" aria-label="Vybrať na porovnanie">
            </td>
            <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at'] ?? ''))) ?></td>
            <td><?= htmlspecialchars($row['calculator_label'] ?? CALC_LABELS[$key] ?? $key) ?></td>
            <td><?= htmlspecialchars(calculatorBuildPatientDisplay($row)) ?></td>
            <td>
              <?php if ($riskClass): ?>
                <span class="calc-result-badge <?= htmlspecialchars($riskClass) ?>">
                  <?= htmlspecialchars($resultText) ?>
                </span>
              <?php else: ?>
                <?= htmlspecialchars($resultText) ?>
              <?php endif; ?>
            </td>
            <td class="admin-actions-cell">
              <?php if ($url): ?>
                <a href="<?= htmlspecialchars($url) ?>?load_id=<?= (int)$row['id'] ?>"
                   class="btn-admin-action btn-primary-filled">Načítať</a>
                <a href="calculator_result_print.php?result_id=<?= (int)$row['id'] ?>"
                   target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
              <?php endif; ?>
              <form method="POST" class="d-inline" data-confirm="Vymazať záznam?">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="result_id" value="<?= (int)$row['id'] ?>">
                <?php if ($filterKey): ?><input type="hidden" name="calc_filter_redirect" value="<?= htmlspecialchars($filterKey) ?>"><?php endif; ?>
                <button type="submit" class="btn-admin-action btn-admin-action--warn">Vymazať</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </div>
    </form>

    <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
    (function() {
      var checks  = document.querySelectorAll('.compare-check');
      var btn     = document.getElementById('compare-btn');
      var form    = document.getElementById('compare-form');
      if (!checks.length || !btn || !form) return;

      checks.forEach(function(cb) {
        cb.addEventListener('change', function() {
          var sel = document.querySelectorAll('.compare-check:checked');
          btn.style.display = sel.length >= 2 ? '' : 'none';
          btn.textContent = 'Porovnať vybrané (' + sel.length + ')';
        });
      });

      form.addEventListener('submit', function(e) {
        var sel = Array.from(document.querySelectorAll('.compare-check:checked')).map(function(c){return c.value;});
        if (!sel.length) return;
        e.preventDefault();
        var url = 'calculator_history.php?compare=' + sel.join(',');
        <?php if ($filterKey): ?>url += '&calc=<?= urlencode($filterKey) ?>';<?php endif; ?>
        window.location.href = url;
      });
    })();
    </script>
    <?php endif; ?>

  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
