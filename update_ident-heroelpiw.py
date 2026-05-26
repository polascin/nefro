import glob
import re

def update_file(filename):
    with open(filename, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if '<div class="form-section">' not in content:
        return
        
    patient_info_block = """                    <div class="form-section">
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
                            <div class="form-group">
                                <label for="patient_insurance_code">Kód zdravotnej poisťovne</label>
                                <input type="text" id="patient_insurance_code" name="patient_insurance_code" class="form-control" placeholder="24 alebo 24-01" value="<?= htmlspecialchars($form['patient_insurance_code']) ?>">
                            </div>
                        </div>
                    </div>"""

    # Look for the patient info block either as "Voliteľné identifikačné údaje pacienta" or "Údaje pacienta (voliteľné)"
    pattern = r'(\s*)<div class="form-section">\s*<h3>(?:Voliteľné identifikačné údaje pacienta|Údaje pacienta \(voliteľné\))</h3>.*?(?=\n\s*<div class="form-(?:section|actions)")'
    
    match = re.search(pattern, content, flags=re.DOTALL)
    if match:
        content = content[:match.start()] + "\n" + patient_info_block + content[match.end():]
    else:
        print(f"Could not find patient info section in {filename}")
        return
        
    # Replace next h3
    parts = content.split('Voliteľné identifikačné údaje pacienta</h3>')
    if len(parts) > 1:
        after_patient_info = parts[1]
        h3_match = re.search(r'<h3>(.*?)</h3>', after_patient_info)
        if h3_match:
            new_title = "Povinné vstupy na výpočet"
            # don't replace if already done
            if h3_match.group(1) != new_title:
                content = content[:parts[0].__len__() + len('Voliteľné identifikačné údaje pacienta</h3>') + h3_match.start()] + f"<h3>{new_title}</h3>" + content[parts[0].__len__() + len('Voliteľné identifikačné údaje pacienta</h3>') + h3_match.end():]
            
    with open(filename, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Updated {filename}")

if __name__ == "__main__":
    for f in glob.glob("calculator_*.php"):
        if f not in ['calculator_result_print.php']:
            update_file(f)
