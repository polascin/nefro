import pypdf
import os
import sys

# Nastavenie kódovania výstupu na UTF-8
sys.stdout.reconfigure(encoding='utf-8')

pdf_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
search_terms = ['CKD-PC', 'KFRE', 'Kidney Failure Risk Equation', 'coefficient', 'formula']

reader = pypdf.PdfReader(pdf_path)
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    if text:
        content = text.lower()
        if any(term.lower() in content for term in search_terms):
            print(f'--- PAGE {i+1} ---')
            print(text)
            print('\n' + '='*80 + '\n')
