import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
reader = pypdf.PdfReader(pdf_file)

# Vyhľadávanie textových vzorov ako '1 - exp(' alebo 'baseline'
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    if '1 - exp' in text or 'exp(' in text or 'coef' in text.lower():
        if '1 -' in text and 'exp' in text:
            print(f"--- PAGE {i+1} POSSIBLE EQUATION ---")
            print(text.replace('\n', ' '))
