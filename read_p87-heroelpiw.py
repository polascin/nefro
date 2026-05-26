import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
reader = pypdf.PdfReader(pdf_file)
text = reader.pages[86].extract_text() # Strana 87 má index 86
print(text)
