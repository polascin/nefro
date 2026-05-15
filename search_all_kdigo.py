import pypdf
import os
import re

dir_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD'
pdf_files = [f for f in os.listdir(dir_path) if f.endswith('.pdf')]

search_terms = [
    '3-year', '3 year', '2-year', '5-year', 
    'coefficient', 'beta', 'hazard', 'intercept', 
    'CKD-PC', 'KFRE', 'logit', 'equation', 
    'kdigo.org', 'calculator'
]

results = []

for pdf_file in pdf_files:
    file_path = os.path.join(dir_path, pdf_file)
    try:
        reader = pypdf.PdfReader(file_path)
        for i, page in enumerate(reader.pages):
            text = page.extract_text()
            if not text:
                continue
            
            # Kontrola výskytu hľadaných výrazov
            found = [term for term in search_terms if term.lower() in text.lower()]
            if found:
                # Hľadanie číselných vzorov (napr. koeficienty ako -0.123 alebo 0.456)
                coeffs = re.findall(r'[-+]?\d*\.\d{3,}', text)
                
                results.append({
                    'file': pdf_file,
                    'page': i + 1,
                    'terms': found,
                    'has_numbers': len(coeffs) > 0,
                    'snippet': text[:200].replace('\n', ' ')
                })
    except Exception as e:
        print(f"Error reading {pdf_file}: {e}")

# Výpis súhrnov zaujímavých stránok
for res in results:
    if res['has_numbers'] or '3-year' in str(res['terms']) or 'coefficient' in str(res['terms']) or 'CKD-PC' in str(res['terms']):
         print(f"FILE: {res['file']} | PAGE: {res['page']} | TERMS: {res['terms']}")
         # Extrakcia riadkov pre kontext, ak sa stránka javí ako relevantná
