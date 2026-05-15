<?php
/**
 * Partial: Výber zdravotnej poisťovne.
 *
 * Očakáva premennú $form['patient_insurance_code'] z nadradeného súboru.
 * Zahŕňa číselník poisťovní cez insurance_codes.php.
 *
 * Použitie: include 'patient_insurance_select.php';
 */

// Číselník poisťovní — zahrnie iba ak ešte nie je zahrnutý
if (!defined('INSURANCE_COMPANIES')) {
    require_once __DIR__ . '/insurance_codes.php';
}

$_currentInsCode = trim((string) ($form['patient_insurance_code'] ?? ''));
// Normalizácia: základný kód pre porovnanie so select (napr. '24-01' → '24')
$_baseInsCode = strtok($_currentInsCode, '-') ?: '';
?>
<div class="form-group">
    <label for="patient_insurance_code">Kód zdravotnej poisťovne</label>
    <select id="patient_insurance_code"
            name="patient_insurance_code"
            class="form-control"
            aria-label="Kód zdravotnej poisťovne">
        <option value="">— nevyplnené —</option>
        <?php foreach (INSURANCE_COMPANIES as $code => $ins): ?>
            <option value="<?= htmlspecialchars($code) ?>"
                <?= $_baseInsCode === $code ? 'selected' : '' ?>>
                <?= htmlspecialchars($code . ' – ' . $ins['skratka'] . ' (' . $ins['nazov'] . ')') ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
