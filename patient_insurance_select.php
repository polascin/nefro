<?php
/**
 * Partial: Výber zdravotnej poisťovne.
 *
 * Číselník načítava z DB tabuľky `insurance_companies` (aktívne záznamy, zoradené podľa kódu).
 * Ak nie je dostupné PDO spojenie, použije PHP konštantu z insurance_codes.php ako fallback.
 *
 * Očakáva premennú $form['patient_insurance_code'] z nadradeného súboru.
 *
 * Použitie: include 'patient_insurance_select.php';
 */

// Načítanie zoznamu poisťovní — primárne z DB, fallback na statický číselník
$_insuranceList = [];

if (isset($pdo) && $pdo instanceof PDO) {
    try {
        $insStmt = $pdo->query(
            "SELECT code, nazov, skratka
             FROM insurance_companies
             WHERE aktivna = 1
             ORDER BY code ASC"
        );
        $dbRows = $insStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dbRows as $row) {
            $_insuranceList[$row['code']] = [
                'nazov'   => $row['nazov'],
                'skratka' => $row['skratka'],
            ];
        }
    } catch (Throwable $e) {
        // Fallback — DB dočasne nedostupná
        error_log('patient_insurance_select: DB chyba — ' . $e->getMessage());
    }
}

// Fallback na statický číselník ak DB vrátila prázdny výsledok
if (empty($_insuranceList)) {
    if (!defined('INSURANCE_COMPANIES')) {
        require_once __DIR__ . '/insurance_codes.php';
    }
    foreach (INSURANCE_COMPANIES as $code => $ins) {
        $_insuranceList[$code] = [
            'nazov'   => $ins['nazov'],
            'skratka' => $ins['skratka'],
        ];
    }
}

// Normalizácia aktuálne vybraného kódu (napr. '24-01' → '24')
$_currentInsCode = trim((string) ($form['patient_insurance_code'] ?? ''));
$_baseInsCode    = strtok($_currentInsCode ?: '', '-') ?: '';
?>
<div class="form-group">
    <label for="patient_insurance_code">Zdravotná poisťovňa</label>
    <select id="patient_insurance_code"
            name="patient_insurance_code"
            class="form-control"
            aria-label="Zdravotná poisťovňa">
        <option value="">— nevyplnené —</option>
        <?php foreach ($_insuranceList as $code => $ins): ?>
            <option value="<?= htmlspecialchars($code) ?>"
                    <?= $_baseInsCode === $code ? 'selected' : '' ?>>
                <?= htmlspecialchars($code . ' – ' . $ins['skratka'] . ' (' . $ins['nazov'] . ')') ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
