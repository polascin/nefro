import pypdf
import sys
import re

# Set output encoding to UTF-8
sys.stdout.reconfigure(encoding='utf-8')

pdf_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
reader = pypdf.PdfReader(pdf_path)

keywords = [re.compile(k, re.IGNORECASE) for k in ["CKD-PC", "KFRE", "coefficient", "40%", "ESRD", "regression", "equation"]]

found_pages = []
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    if any(k.search(text) for k in keywords):
        found_pages.append(i + 1)

print(f"Keywords found on pages: {found_pages}")
