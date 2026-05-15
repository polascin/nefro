import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
reader = pypdf.PdfReader(pdf_file)
# Search more broadly for pages with 'beta' and 'hazard'
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    if 'beta' in text.lower() or 'hazard' in text.lower():
         # If it has many decimals, it might be the table we need
         coeffs = re.findall(r'\d\.\d{3,}', text)
         if len(coeffs) > 5:
             print(f"PAGE {i+1} has {len(coeffs)} coefficients.")
             print(text[:500].replace('\n', ' '))
