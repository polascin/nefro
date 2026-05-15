import pypdf
import os
import re

dir_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD'
search_terms = ['CKD-PC', 'Chronic Kidney Disease Prognosis Consortium', 'risk prediction', 'KFRE', 'Kidney Failure Risk Equation']

for filename in os.listdir(dir_path):
    if filename.endswith('.pdf'):
        print(f'Scanning {filename}...')
        try:
            reader = pypdf.PdfReader(os.path.join(dir_path, filename))
            for i, page in enumerate(reader.pages):
                text = page.extract_text()
                if text:
                    for term in search_terms:
                        if term.lower() in text.lower():
                            print(f'--- Found "{term}" on page {i+1} ---')
                            # Print a snippet of the text
                            start = max(0, text.lower().find(term.lower()) - 200)
                            end = min(len(text), text.lower().find(term.lower()) + 500)
                            print(text[start:end])
                            print('\n' + '='*50 + '\n')
                            break # Move to next page after first find
        except Exception as e:
            print(f'Error reading {filename}: {e}')
