import os
import re

files = [
    'calculator_aki.php',
    'calculator_cg.php',
    'calculator_ca.php',
    'calculator_na.php',
    'calculator_acidbase.php',
    'calculator_egfr_slope.php',
    'calculator_ktv.php',
    'calculator_uacr.php',
    'calculator_egfr.php',
    'calculator_adpkd.php'
]

load_logic = """
if (isLoggedIn() && isset($_GET['load_id'])) {
    $loadId = (int) $_GET['load_id'];
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int) $_SESSION['user_id']);
    if ($loadedRow) {
        $form['patient_first_name'] = (string) ($loadedRow['patient_first_name'] ?? '');
        $form['patient_last_name'] = (string) ($loadedRow['patient_last_name'] ?? '');
        $form['patient_birth_date'] = (string) ($loadedRow['patient_birth_date'] ?? '');
        $form['patient_birth_number'] = (string) ($loadedRow['patient_birth_number'] ?? '');
        $form['patient_insurance_code'] = (string) ($loadedRow['patient_insurance_code'] ?? '');
        if (is_array($loadedRow['input_payload'])) {
            foreach ($loadedRow['input_payload'] as $k => $v) {
                if (isset($form[$k]) || array_key_exists($k, $form)) {
                    $form[$k] = (string) $v;
                }
            }
        }
        $messages[] = 'Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.';
    }
}
"""

slope_load_logic = """
if (isLoggedIn() && isset($_GET['load_id'])) {
    $loadId = (int) $_GET['load_id'];
    $loadedRow = calculatorFetchSavedResultById($pdo, $loadId, (int) $_SESSION['user_id']);
    if ($loadedRow) {
        $form['patient_first_name'] = (string) ($loadedRow['patient_first_name'] ?? '');
        $form['patient_last_name'] = (string) ($loadedRow['patient_last_name'] ?? '');
        $form['patient_birth_date'] = (string) ($loadedRow['patient_birth_date'] ?? '');
        $form['patient_birth_number'] = (string) ($loadedRow['patient_birth_number'] ?? '');
        $form['patient_insurance_code'] = (string) ($loadedRow['patient_insurance_code'] ?? '');
        if (is_array($loadedRow['input_payload'])) {
            foreach ($loadedRow['input_payload'] as $pKey => $pData) {
                if (preg_match('/^p(\\d+)$/', $pKey, $m)) {
                    $idx = $m[1];
                    $form["date_$idx"] = $pData['date'] ?? '';
                    $form["egfr_$idx"] = $pData['egfr'] ?? '';
                }
            }
        }
        $messages[] = 'Údaje z histórie boli načítané do formulára. Môžete ich upraviť a vykonať nový výpočet.';
    }
}
"""

for f in files:
    path = os.path.join('d:\\\\OneDrive\\\\www\\\\nefro', f)
    if not os.path.exists(path):
        continue
    with open(path, 'r', encoding='utf-8') as file:
        content = file.read()
    
    # 1. Add Load logic if not present
    if 'isset($_GET[' in content and 'load_id' in content:
        pass # Already added
    else:
        logic_to_insert = slope_load_logic if f == 'calculator_egfr_slope.php' else load_logic
        content = content.replace("if ($_SERVER['REQUEST_METHOD'] === 'POST') {", logic_to_insert + "\nif ($_SERVER['REQUEST_METHOD'] === 'POST') {")

    # 2. Add 'Načítať' button
    if '>Načítať</a>' not in content:
        # Some tables use class="admin-actions-cell"
        content = content.replace('<td class="admin-actions-cell">', '<td class="admin-actions-cell">\n                                            <a href="?load_id=<?= (int) $row[\'id\'] ?>" class="btn-admin-action" style="background: var(--color-primary); color: white; border-color: var(--color-primary);">Načítať</a>')

    # 3. Modify Date representation
    content = re.sub(r'<\?= htmlspecialchars\(\(string\) \(\$row\[\'created_at\'\] \?\? \'\'\)\) \?>', '<?= htmlspecialchars(date(\'d.m.Y H:i\', strtotime($row[\'created_at\'] ?? \'\'))) ?>', content)
    content = re.sub(r'<\?= htmlspecialchars\(\$row\[\'created_at\'\]\) \?>', '<?= htmlspecialchars(date(\'d.m.Y H:i\', strtotime($row[\'created_at\'] ?? \'\'))) ?>', content)
    
    with open(path, 'w', encoding='utf-8') as file:
        file.write(content)
    print(f'Updated {f}')

