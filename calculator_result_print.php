<?php
require_once 'auth.php';
require_once 'db_config.php';
require_once 'calculators_common.php';

requireLogin();

$resultId = (int) ($_GET['result_id'] ?? 0);
$resultRow = null;
$errorMessage = null;

if ($resultId <= 0) {
    $errorMessage = 'Neplatné ID výsledku.';
} else {
    try {
        $resultRow = calculatorFetchSavedResultById($pdo, $resultId, (int) $_SESSION['user_id']);
        if ($resultRow === null) {
            $errorMessage = 'Výsledok nebol nájdený.';
        }
    } catch (\PDOException $e) {
        $errorMessage = 'Databázová chyba pri načítaní výsledku.';
        error_log('calculator_result_print error: ' . $e->getMessage());
    }
}

$inputPayload = is_array($resultRow['input_payload'] ?? null) ? $resultRow['input_payload'] : [];
$resultPayload = is_array($resultRow['result_payload'] ?? null) ? $resultRow['result_payload'] : [];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tlač výsledku kalkulačky</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body class="admin-notice-page">
    <main class="container main-content main-content--single-col" role="main">
        <div class="auth-container auth-container--wide admin-notice-card">
            <h2>Tlač výsledku kalkulačky</h2>

            <?php if ($errorMessage !== null): ?>
                <div class="alert alert-error"><p><?= htmlspecialchars($errorMessage) ?></p></div>
                <p><a href="calculators.php" class="btn-primary">Späť na kalkulačky</a></p>
            <?php else: ?>
                <p class="auth-subtitle"><?= htmlspecialchars((string) ($resultRow['calculator_label'] ?? '')) ?></p>

                <div class="admin-notice-print-user">
                    <h3>Identifikácia pacienta</h3>
                    <div class="admin-notice-print-row"><strong>Pacient</strong><span><?= htmlspecialchars(calculatorBuildPatientDisplay($resultRow)) ?></span></div>
                    <div class="admin-notice-print-row"><strong>Dátum uloženia</strong><span><?= htmlspecialchars((string) ($resultRow['created_at'] ?? '')) ?></span></div>
                </div>

                <div class="admin-notice-print-user">
                    <h3>Vstupy kalkulačky</h3>
                    <?php if (empty($inputPayload)): ?>
                        <p>Vstupné údaje nie sú dostupné.</p>
                    <?php else: ?>
                        <?php foreach ($inputPayload as $key => $value): ?>
                            <div class="admin-notice-print-row">
                                <strong><?= htmlspecialchars((string) $key) ?></strong>
                                <span><?= htmlspecialchars(is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE)) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="admin-notice-print-user">
                    <h3>Výsledok</h3>
                    <?php if (empty($resultPayload)): ?>
                        <p>Výsledok nie je dostupný.</p>
                    <?php else: ?>
                        <?php foreach ($resultPayload as $key => $value): ?>
                            <div class="admin-notice-print-row">
                                <strong><?= htmlspecialchars((string) $key) ?></strong>
                                <span><?= htmlspecialchars(is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE)) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-actions no-print">
                    <button type="button" class="btn-primary" onclick="window.print()">Tlačiť</button>
                    <a href="javascript:window.close()" class="btn-secondary">Zatvoriť okno</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script>
        if (document.querySelector('.alert-error') === null) {
            window.addEventListener('load', function () { window.print(); });
        }
    </script>
</body>
</html>
