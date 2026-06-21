<?php
declare(strict_types=1);
// $_navCurrent musí byť nastavené pred include (nastavuje main_nav.php)
// Profil pre quickfill — dostupný na kalkulačkách (vyžaduje calculators_common.php)
if (function_exists('isLoggedIn') && isLoggedIn() && isset($pdo)
    && function_exists('calculatorGetUserProfile')) {
    $_calcProfile = calculatorGetUserProfile($pdo, (int) $_SESSION['user_id']);
}
$_calcSubnavItems = [
    ['file' => 'calculator_egfr.php',       'label' => 'eGFR'],
    ['file' => 'calculator_egfr_cys.php',   'label' => 'eGFR (kr-cys)'],
    ['file' => 'calculator_kdigo_risk.php',  'label' => 'KDIGO G/A'],
    ['file' => 'calculator_kfre.php',        'label' => 'KFRE'],
    ['file' => 'calculator_ckdpc.php',       'label' => 'CKD-PC'],
    ['file' => 'calculator_prevent.php',     'label' => 'PREVENT'],
    ['file' => 'calculator_igan.php',        'label' => 'IgAN'],
    ['file' => 'calculator_adpkd.php',       'label' => 'Mayo ADPKD'],
    ['file' => 'calculator_aki.php',         'label' => 'AKI (FENa/FEUrea)'],
    ['file' => 'calculator_cg.php',          'label' => 'Cockcroft-Gault'],
    ['file' => 'calculator_ca.php',          'label' => 'Vápnik'],
    ['file' => 'calculator_na.php',          'label' => 'Poruchy sodíka'],
    ['file' => 'calculator_acidbase.php',    'label' => 'Aniónová medzera'],
    ['file' => 'calculator_egfr_slope.php',  'label' => 'eGFR Slope'],
    ['file' => 'calculator_ktv.php',         'label' => 'Kt/V a URR'],
    ['file' => 'calculator_uacr.php',        'label' => 'UACR'],
];
?>
<nav class="quick-nav-calculators" aria-label="Kalkulačky — rýchla navigácia">
    <div class="container">
        <ul class="quick-nav-list">
            <?php foreach ($_calcSubnavItems as $_item): ?>
                <li>
                    <?php if (isset($_navCurrent) && $_navCurrent === $_item['file']): ?>
                        <a href="<?= htmlspecialchars($_item['file']) ?>" class="active" aria-current="page"><?= htmlspecialchars($_item['label']) ?></a>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($_item['file']) ?>"><?= htmlspecialchars($_item['label']) ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
        <a href="calculator_history.php"
           class="quick-nav-history-link<?= (isset($_navCurrent) && $_navCurrent === 'calculator_history.php') ? ' active' : '' ?>"
           title="História výpočtov">📋 História</a>
        <?php endif; ?>
    </div>
</nav>
<script nonce="<?= htmlspecialchars(function_exists('getScriptNonce') ? getScriptNonce() : '', ENT_QUOTES) ?>">
window.calcIsGuest = <?= (function_exists('isLoggedIn') && isLoggedIn()) ? 'false' : 'true' ?>;
<?php if (!empty($_calcProfile) && !empty(array_filter($_calcProfile))): ?>
window.calcProfileData = <?= json_encode($_calcProfile, JSON_UNESCAPED_UNICODE) ?>;
<?php endif; ?>
</script>
