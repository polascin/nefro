import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
reader = pypdf.PdfReader(pdf_file)

# Overenie výskytu výrazu '3-year' a výpis kontextu
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    if '3-year' in text or '3 year' in text:
        print(f"--- PAGE {i+1} ---")
        start = text.find('3-year') if '3-year' in text else text.find('3 year')
        print(text[max(0, start-150):min(len(text), start+200)])
