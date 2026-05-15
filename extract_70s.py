import pypdf
import sys

sys.stdout.reconfigure(encoding='utf-8')

pdf_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
pages_to_extract = [i-1 for i in [71, 72, 73, 74, 75]]

reader = pypdf.PdfReader(pdf_path)
for page_num in pages_to_extract:
    if 0 <= page_num < len(reader.pages):
        page = reader.pages[page_num]
        print(f'--- PAGE {page_num + 1} ---')
        print(page.extract_text())
