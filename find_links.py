import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
reader = pypdf.PdfReader(pdf_file)

# We search for "calculator" or "kdigo.org" to find tool links
for i, page in enumerate(reader.pages):
    text = page.extract_text()
    if 'kdigo.org' in text.lower() or 'calculator' in text.lower():
        print(f"PAGE {i+1} mentions calculator/link")
        # Extract lines starting with http
        urls = re.findall(r'https?://\S+', text)
        if urls:
            print(f"URLs: {urls}")
        if '3-year' in text or '3 year' in text:
             print("3-YEAR FOUND!")
