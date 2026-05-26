<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

$pageTitle = 'História výpočtov | Nefro-projekt Slovensko';
$errors    = [];
$messages  = [];

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

/** Kľúč pre zoskupenie výsledkov podľa identity pacienta. */
function patientGroupKey(array $row): string {
    $bn = trim((string)($row['patient_birth_number'] ?? ''));
    if ($bn !== '') return 'rc:' . preg_replace('/\s+/', '', $bn);
    $fn = mb_strtolower(trim((string)($row['patient_first_name'] ?? '')));
    $ln = mb_strtolower(trim((string)($row['patient_last_name'] ?? '')));
    $bd = trim((string)($row['patient_birth_date'] ?? ''));
    if ($fn !== '' || $ln !== '') return 'name:' . $ln . '|' . $fn . '|' . $bd;
    return '__anon__';
}

/** Čitateľný nadpis pacienta z prvého záznamu skupiny. */
function patientHeading(array $row): string {
    $fn = trim((string)($row['patient_first_name'] ?? ''));
    $ln = trim((string)($row['patient_last_name'] ?? ''));
    $bd = trim((string)($row['patient_birth_date'] ?? ''));
    $bn = trim((string)($row['patient_birth_number'] ?? ''));
    $ic = trim((string)($row['patient_insurance_code'] ?? ''));
    $name = trim("$fn $ln");
    if ($name !== '') {
        $parts = [];
        if ($bd !== '') $parts[] = 'nar. ' . $bd;
        if ($bn !== '') $parts[] = 'RC: ' . $bn;
        if ($ic !== '') $parts[] = 'ZP: ' . $ic;
        return $name . ($parts ? ' — ' . implode(', ', $parts) : '');
    }
    if ($bn !== '') return 'RC: ' . $bn;
    return 'Neidentifikovaný pacient';
}

/**
 * Vráti zobrazovací dátum záznamu.
 * Prednosť: examination_date z input_payload; fallback: created_at.
 * $withTime = true pridá čas len pri fallback na created_at (examination_date je iba dátum).
 */
function calcDisplayDate(array $row, bool $withTime = false): string {
    $examDate = trim((string)($row['input_payload']['examination_date'] ?? ''));
    if ($examDate !== '') {
        $ts = strtotime($examDate);
        return $ts ? date('d.m.Y', $ts) : $examDate;
    }
    $ts = strtotime((string)($row['created_at'] ?? ''));
    return $ts ? date($withTime ? 'd.m.Y H:i' : 'd.m.Y', $ts) : '—';
}

// POST akcie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!validateCsrfToken((string)($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token.';
    } elseif ($_POST['action'] === 'delete' && isLoggedIn()) {
        $rid = (int)($_POST['result_id'] ?? 0);
        if ($rid > 0 && calculatorDeleteSavedResult($pdo, $rid, (int)$_SESSION['user_id'])) {
            $messages[] = 'Záznam bol vymazaný.';
        } else {
            $errors[] = 'Záznam sa nepodarilo vymazať.';
        }
    }
}

$allResults  = [];
$grouped     = [];   // [ patientKey => [ 'heading'=>string, 'rows'=>[], 'egfrTrend'=>[] ] ]
$filterKey   = trim($_GET['calc'] ?? '');
$filterPat   = trim($_GET['patient'] ?? '');
$compareIds  = array_filter(array_map('intval', explode(',', $_GET['compare'] ?? '')));
$compareRows = [];

if (isLoggedIn()) {
    $allResults = calculatorFetchAllResults($pdo, (int)$_SESSION['user_id']);

    // Porovnanie
    if (!empty($compareIds)) {
        foreach ($compareIds as $cid) {
            $row = calculatorFetchSavedResultById($pdo, $cid, (int)$_SESSION['user_id']);
            if ($row) $compareRows[] = $row;
        }
    }

    // Zoskupenie podľa pacienta
    foreach ($allResults as $r) {
        if ($filterKey !== '' && $r['calculator_key'] !== $filterKey) continue;
        $pkey = patientGroupKey($r);
        if ($filterPat !== '' && $pkey !== $filterPat) continue;
        if (!isset($grouped[$pkey])) {
            $grouped[$pkey] = ['heading' => patientHeading($r), 'rows' => [], 'egfrTrend' => []];
        }
        $grouped[$pkey]['rows'][] = $r;
        // eGFR trend pre tohto pacienta
        if ($r['calculator_key'] === 'egfr_ckd_epi_2021') {
            $egfr = (float)($r['result_payload']['egfr'] ?? 0);
            if ($egfr > 0) {
                $examDate = trim((string)($r['input_payload']['examination_date'] ?? ''));
                $dateStr  = $examDate !== '' ? $examDate : substr((string)($r['created_at'] ?? ''), 0, 10);
                $grouped[$pkey]['egfrTrend'][] = [
                    'date'     => $dateStr,
                    'egfr'     => $egfr,
                    'category' => (string)($r['result_payload']['g_category'] ?? ''),
                ];
            }
        }
    }

    // Zoradiť každú skupinu od najnovšieho, anonymní na koniec
    uksort($grouped, function ($a, $b) {
        if ($a === '__anon__') return 1;
        if ($b === '__anon__') return -1;
        return strcmp(
            $GLOBALS['grouped'][$a]['heading'],
            $GLOBALS['grouped'][$b]['heading']
        );
    });
    foreach ($grouped as &$g) {
        // eGFR trend chronologicky podľa dátumu vyšetrenia
        usort($g['egfrTrend'], fn($a, $b) => strcmp($a['date'], $b['date']));
    }
    unset($g);
}

// Štatistika kalkulačiek (pre filter bočný panel)
$statsByCalc = [];
foreach ($allResults as $r) {
    $k = $r['calculator_key'];
    if (!isset($statsByCalc[$k])) {
        $statsByCalc[$k] = ['count' => 0, 'label' => $r['calculator_label'] ?? CALC_LABELS[$k] ?? $k];
    }
    $statsByCalc[$k]['count']++;
}
arsort($statsByCalc);

$totalCount = array_sum(array_column($statsByCalc, 'count'));
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php include 'head_meta.php'; ?>
</head>
<body>
<?php $headerTitle = 'História výpočtov'; $showLogo = false; include 'header.php'; ?>

<main class="container calc-history-main">
  <?php foreach ($errors   as $e): ?><div class="alert alert-error"><?= htmlspecialchars($e) ?></div><?php endforeach; ?>
  <?php foreach ($messages as $m): ?><div class="alert alert-success"><?= htmlspecialchars($m) ?></div><?php endforeach; ?>

  <?php if (!isLoggedIn()): ?>
    <div class="primary-article">
      <h2>História výpočtov</h2>
      <p>Pre zobrazenie histórie výpočtov je potrebné <a href="login.php">prihlásenie</a>.</p>
    </div>
  <?php else: ?>

    <!-- Hlavička + filtre -->
    <div class="calc-history-header">
      <div>
        <h2>História výpočtov</h2>
        <p class="calc-history-subtitle">
          <?= count($grouped) ?> pacient<?= count($grouped) === 1 ? '' : (count($grouped) < 5 ? 'i' : 'ov') ?>,
          <?= $totalCount ?> záznamov
          <?php if ($filterKey): ?> — <em><?= htmlspecialchars(CALC_LABELS[$filterKey] ?? $filterKey) ?></em><?php endif; ?>
          <?php if ($filterPat): ?> — <em><?= htmlspecialchars($grouped[$filterPat]['heading'] ?? '') ?></em><?php endif; ?>
        </p>
      </div>
      <div class="calc-history-actions">
        <a href="calculator_history.php" class="btn-secondary<?= ($filterKey === '' && $filterPat === '') ? ' btn-secondary--active' : '' ?>">Všetci</a>
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

    <!-- Porovnanie -->
    <?php if (!empty($compareRows)): ?>
    <section class="primary-article calc-compare-section">
      <h3>Porovnanie vybraných výsledkov</h3>
      <div class="calc-compare-grid">
        <?php foreach ($compareRows as $cr):
          $rp = $cr['result_payload']; $inp = $cr['input_payload']; $key = $cr['calculator_key'] ?? '';
        ?>
        <div class="calc-compare-card">
          <div class="calc-compare-card__header">
            <span class="calc-compare-card__label"><?= htmlspecialchars($cr['calculator_label'] ?? '') ?></span>
            <span class="calc-compare-card__date"><?= htmlspecialchars(calcDisplayDate($cr)) ?></span>
          </div>
          <div class="calc-compare-card__patient"><?= htmlspecialchars(calculatorBuildPatientDisplay($cr)) ?></div>
          <div class="calc-compare-card__result">
            <?php if ($key === 'egfr_ckd_epi_2021'):
              $cat = $rp['g_category'] ?? '';
              echo '<div class="calc-result-badge ' . egfrRiskClass($cat) . '">';
              echo htmlspecialchars(number_format((float)($rp['egfr']??0),1,',',' ')) . ' ml/min';
              echo '<span>' . htmlspecialchars($cat) . '</span></div>';
            elseif ($key === 'kfre'):
              $r5 = (float)($rp['risk_5yr']??0);
              echo '<div class="calc-result-badge ' . kfreRiskClass($r5) . '">5r: '
                 . htmlspecialchars(number_format($r5,1,',',' ')) . '%</div>';
            else:
              foreach ($rp as $ck => $cv) {
                  if (is_numeric($cv)) {
                      echo '<span>' . htmlspecialchars($ck) . ': ' . htmlspecialchars(number_format((float)$cv,2,',',' ')) . '</span>';
                      break;
                  }
              }
            endif; ?>
          </div>
          <?php foreach ($inp as $ik => $iv): ?>
            <div class="calc-compare-card__row">
              <span class="calc-compare-card__key"><?= htmlspecialchars($ik) ?></span>
              <span class="calc-compare-card__val"><?= htmlspecialchars((string)$iv) ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <a href="calculator_history.php<?= $filterKey ? '?calc='.urlencode($filterKey) : '' ?>" class="btn-secondary">Zavrieť porovnanie</a>
    </section>
    <?php endif; ?>

    <?php if (empty($grouped)): ?>
      <div class="primary-article">
        <p>Žiadne uložené výsledky<?= $filterKey ? ' pre túto kalkulačku' : '' ?>.</p>
        <a href="calculators.php" class="btn-primary">Otvoriť kalkulačky</a>
      </div>
    <?php else: ?>

    <form method="GET" action="calculator_history.php" id="compare-form">
      <?php if ($filterKey): ?><input type="hidden" name="calc" value="<?= htmlspecialchars($filterKey) ?>"><?php endif; ?>
      <?php if ($filterPat): ?><input type="hidden" name="patient" value="<?= htmlspecialchars($filterPat) ?>"><?php endif; ?>

      <div class="calc-history-toolbar-global">
        <button type="submit" name="compare" id="compare-btn" class="btn-secondary" style="display:none">Porovnať vybrané</button>
      </div>

      <?php $patIdx = 0; foreach ($grouped as $pkey => $pg):
        $patIdx++;
        $patRows = $pg['rows'];
        $egfrTrend = $pg['egfrTrend'];
        $patHeading = $pg['heading'];
        $isAnon = $pkey === '__anon__';
        $canvasId = 'egfr-trend-' . $patIdx;
      ?>
      <details class="calc-patient-section" open data-patient-idx="<?= $patIdx ?>">
        <summary class="calc-patient-summary">
          <span class="calc-patient-name"><?= htmlspecialchars($patHeading) ?></span>
          <span class="calc-patient-meta">
            <?= count($patRows) ?> záznam<?= count($patRows) === 1 ? '' : (count($patRows) < 5 ? 'y' : 'ov') ?>
            · posledný: <?= htmlspecialchars(calcDisplayDate($patRows[0])) ?>
          </span>
          <span class="calc-patient-summary-actions">
            <?php if ($filterPat === '' && !$isAnon): ?>
              <a href="?patient=<?= urlencode($pkey) ?><?= $filterKey ? '&calc='.urlencode($filterKey) : '' ?>"
                 class="calc-patient-filter-link" onclick="event.stopPropagation()">Len tento</a>
            <?php endif; ?>
            <button type="button" class="calc-patient-print-btn btn-secondary"
                    data-patient-idx="<?= $patIdx ?>"
                    onclick="event.stopPropagation(); printPatient(<?= $patIdx ?>)"
                    title="Vytlačiť históriu tohto pacienta">🖨 Tlačiť</button>
          </span>
        </summary>

        <!-- eGFR trend pre pacienta -->
        <?php if (count($egfrTrend) >= 2): ?>
        <div class="calc-trend-section calc-trend-section--patient">
          <h4>Trend eGFR</h4>
          <div class="calc-trend-wrap">
            <canvas id="<?= htmlspecialchars($canvasId) ?>" class="calc-trend-canvas"></canvas>
          </div>
          <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
          (function() {
            var data = <?= json_encode(array_values($egfrTrend), JSON_UNESCAPED_UNICODE) ?>;
            var canvas = document.getElementById('<?= htmlspecialchars($canvasId) ?>');
            if (!canvas || !canvas.getContext || data.length < 2) return;
            var ctx = canvas.getContext('2d');
            var W = canvas.offsetWidth || 600; var H = 140;
            canvas.width = W; canvas.height = H;
            var PAD = {top:16,right:16,bottom:32,left:44};
            var vals = data.map(function(d){return d.egfr;});
            var maxV = Math.max.apply(null,vals.concat([120]));
            var minV = Math.max(0, Math.min.apply(null,vals)-10);
            function xP(i){return PAD.left+(i/Math.max(data.length-1,1))*(W-PAD.left-PAD.right);}
            function yP(v){return PAD.top+(1-(v-minV)/(maxV-minV))*(H-PAD.top-PAD.bottom);}
            var bands=[{from:90,to:maxV,color:'rgba(34,197,94,0.08)'},{from:60,to:90,color:'rgba(134,239,172,0.12)'},{from:45,to:60,color:'rgba(234,179,8,0.10)'},{from:30,to:45,color:'rgba(249,115,22,0.10)'},{from:15,to:30,color:'rgba(239,68,68,0.10)'},{from:minV,to:15,color:'rgba(127,29,29,0.12)'}];
            bands.forEach(function(b){var y1=yP(Math.min(b.to,maxV)),y2=yP(Math.max(b.from,minV));ctx.fillStyle=b.color;ctx.fillRect(PAD.left,y1,W-PAD.left-PAD.right,y2-y1);});
            ctx.fillStyle='#94a3b8';ctx.font='10px system-ui,sans-serif';ctx.textAlign='right';
            [15,30,45,60,90].forEach(function(v){if(v>=minV&&v<=maxV){var y=yP(v);ctx.fillText(v,PAD.left-4,y+3);ctx.strokeStyle='rgba(148,163,184,0.2)';ctx.beginPath();ctx.moveTo(PAD.left,y);ctx.lineTo(W-PAD.right,y);ctx.stroke();}});
            ctx.textAlign='center';var step=data.length>10?Math.ceil(data.length/8):1;
            data.forEach(function(d,i){if(i%step!==0&&i!==data.length-1)return;ctx.fillStyle='#94a3b8';ctx.fillText(d.date.slice(5),xP(i),H-6);});
            ctx.strokeStyle='#3b82f6';ctx.lineWidth=2;ctx.lineJoin='round';ctx.beginPath();
            data.forEach(function(d,i){var x=xP(i),y=yP(d.egfr);if(i===0)ctx.moveTo(x,y);else ctx.lineTo(x,y);});ctx.stroke();
            var catC={G1:'#22c55e',G2:'#86efac',G3a:'#eab308',G3b:'#f97316',G4:'#ef4444',G5:'#7f1d1d'};
            data.forEach(function(d,i){var x=xP(i),y=yP(d.egfr);ctx.fillStyle=catC[d.category]||'#3b82f6';ctx.beginPath();ctx.arc(x,y,4,0,Math.PI*2);ctx.fill();});
          })();
          </script>
        </div>
        <?php endif; ?>

        <!-- Tabuľka výsledkov pacienta -->
        <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th></th>
              <th>Dátum</th>
              <th>Kalkulačka</th>
              <th>Výsledok</th>
              <th>Akcie</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($patRows as $row):
            $rp     = $row['result_payload'];
            $key    = $row['calculator_key'];
            $url    = CALC_URLS[$key] ?? null;
            $riskCls = '';
            $resultText = '';
            if ($key === 'egfr_ckd_epi_2021') {
                $egfr = (float)($rp['egfr'] ?? 0); $cat = (string)($rp['g_category'] ?? '');
                $resultText = number_format($egfr,1,',',' ') . ' ml/min (' . $cat . ')';
                $riskCls = egfrRiskClass($cat);
            } elseif ($key === 'kfre') {
                $r5 = (float)($rp['risk_5yr'] ?? 0);
                $resultText = '5r: ' . number_format($r5,1,',',' ') . '%';
                $riskCls = kfreRiskClass($r5);
            } elseif ($key === 'ckd_pc_grams_2022') {
                $r3 = (float)($rp['risk_3yr'] ?? 0);
                $resultText = '3r: ' . number_format($r3,1,',',' ') . '%';
                $riskCls = $r3 < 5 ? 'risk-low' : ($r3 < 15 ? 'risk-moderate' : 'risk-high');
            } elseif ($key === 'cockcroft_gault') {
                $resultText = number_format((float)($rp['crcl'] ?? 0),1,',',' ') . ' ml/min';
            } elseif ($key === 'uacr') {
                $resultText = number_format((float)($rp['uacr_mg_g'] ?? 0),1,',',' ') . ' mg/g';
            } elseif ($key === 'kdigo_risk') {
                $resultText = (string)($rp['risk_label'] ?? $rp['combined_risk'] ?? '—');
            } else {
                foreach ($rp as $ck => $cv) {
                    if (is_numeric($cv)) { $resultText = htmlspecialchars($ck) . ': ' . number_format((float)$cv,2,',',' '); break; }
                }
            }
          ?>
          <tr>
            <td><input type="checkbox" name="compare[]" value="<?= (int)$row['id'] ?>" class="compare-check" aria-label="Vybrať na porovnanie"></td>
            <td>
              <?= htmlspecialchars(calcDisplayDate($row)) ?>
              <?php if (isset($row['input_payload']['examination_date']) && $row['input_payload']['examination_date'] !== ''): ?>
                <small class="d-block" style="color:var(--text-secondary);font-size:.8em">ulo.: <?= htmlspecialchars(date('d.m.Y H:i', strtotime($row['created_at'] ?? ''))) ?></small>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['calculator_label'] ?? CALC_LABELS[$key] ?? $key) ?></td>
            <td><?php if ($riskCls): ?>
                <span class="calc-result-badge <?= htmlspecialchars($riskCls) ?>"><?= htmlspecialchars($resultText) ?></span>
              <?php else: ?>
                <?= htmlspecialchars($resultText) ?>
              <?php endif; ?></td>
            <td class="admin-actions-cell">
              <?php if ($url): ?>
                <a href="<?= htmlspecialchars($url) ?>?load_id=<?= (int)$row['id'] ?>" class="btn-admin-action btn-primary-filled">Načítať</a>
                <a href="calculator_result_print.php?result_id=<?= (int)$row['id'] ?>" target="_blank" rel="noopener" class="btn-admin-action">Tlačiť</a>
              <?php endif; ?>
              <form method="POST" class="d-inline" data-confirm="Vymazať záznam?">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken()) ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="result_id" value="<?= (int)$row['id'] ?>">
                <button type="submit" class="btn-admin-action btn-admin-action--warn">Vymazať</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </details>
      <?php endforeach; ?>

      <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
      (function() {
        var checks = document.querySelectorAll('.compare-check');
        var btn    = document.getElementById('compare-btn');
        var form   = document.getElementById('compare-form');
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
          <?php if ($filterPat): ?>url += '&patient=<?= urlencode($filterPat) ?>';<?php endif; ?>
          window.location.href = url;
        });
      })();

      // Tlač histórie jedného pacienta
      window.printPatient = function(patIdx) {
        var all = document.querySelectorAll('.calc-patient-section');
        // Zabezpeč, že cieľová sekcia je otvorená
        all.forEach(function(s) {
          var idx = parseInt(s.getAttribute('data-patient-idx'), 10);
          if (idx === patIdx) {
            s.setAttribute('open', '');
            s.classList.add('print-patient-active');
          } else {
            s.classList.add('print-patient-hidden');
          }
        });
        // Skry filtre a toolbar pre tlač
        var header = document.querySelector('.calc-history-header');
        var toolbar = document.querySelector('.calc-history-toolbar-global');
        if (header)  header.classList.add('no-print');
        if (toolbar) toolbar.classList.add('no-print');

        window.print();

        // Obnov stav po tlači
        all.forEach(function(s) {
          s.classList.remove('print-patient-active', 'print-patient-hidden');
        });
        if (header)  header.classList.remove('no-print');
        if (toolbar) toolbar.classList.remove('no-print');
      };
      </script>

    </form>
    <?php endif; ?>
  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
