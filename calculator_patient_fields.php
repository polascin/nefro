<?php
declare(strict_types=1); /* Uses $form from calling scope */ ?>
<div class="form-section">
    <h3>Voliteľné identifikačné údaje pacienta</h3>
    <div class="form-grid">
        <div class="form-group">
            <label for="patient_first_name">Meno</label>
            <input type="text" id="patient_first_name" name="patient_first_name" class="form-control" value="<?= htmlspecialchars($form['patient_first_name']) ?>">
        </div>
        <div class="form-group">
            <label for="patient_last_name">Priezvisko</label>
            <input type="text" id="patient_last_name" name="patient_last_name" class="form-control" value="<?= htmlspecialchars($form['patient_last_name']) ?>">
        </div>
        <div class="form-group">
            <label for="patient_birth_date">Dátum narodenia</label>
            <input type="date" id="patient_birth_date" name="patient_birth_date" class="form-control" value="<?= htmlspecialchars($form['patient_birth_date']) ?>">
        </div>
        <div class="form-group">
            <label for="patient_birth_number">Rodné číslo</label>
            <input type="text" id="patient_birth_number" name="patient_birth_number" class="form-control" placeholder="000000/0000" value="<?= htmlspecialchars($form['patient_birth_number']) ?>">
        </div>
        <?php include __DIR__ . '/patient_insurance_select.php'; ?>
    </div>
</div>
