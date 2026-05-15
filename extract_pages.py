import pypdf
import sys

# Nastavenie kódovania výstupu na UTF-8
sys.stdout.reconfigure(encoding='utf-8')

pdf_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
pages_to_extract = [33, 44, 61] # 0-indexed for 34, 45, 62

reader = pypdf.PdfReader(pdf_path)
for page_num in pages_to_extract:
    if page_num < len(reader.pages):
        page = reader.pages[page_num]
        text = page.extract_text()
        print(f'--- PAGE {page_num + 1} ---')
        print(text)
        print('\n' + '='*80 + '\n')
