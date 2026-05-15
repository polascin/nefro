import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'

reader = pypdf.PdfReader(pdf_file)

# Rovnice alebo doplnky sa môžu nachádzať na konci dokumentu alebo v prílohách
# Vyhľadávanie výrazov "intercept", "beta", "equation" na ďalších stránkach
# alebo kontrola zoznamu tabuliek.
target_terms = ['coefficient', 'intercept', 'beta', 'baseline hazard']

for i in range(len(reader.pages)):
    page_text = reader.pages[i].extract_text()
    if not page_text: continue
    
    found = [t for t in target_terms if t.lower() in page_text.lower()]
    if found:
        # Hľadanie desatinných čísel so ≥4 desatinnými miestami (typické pre koeficienty modelov)
        coeffs = re.findall(r'[-+]?\d\.\d{4,}', page_text)
        if coeffs:
             print(f"PAGE {i+1} | TERMS: {found}")
             print(f"COEFFS: {coeffs}")
             # Výpis kontextu okolo prvého koeficientu
             idx = page_text.find(coeffs[0])
             print(f"CONTEXT: {page_text[max(0, idx-50):idx+50].replace('\n', ' ')}")
             print("-" * 30)

