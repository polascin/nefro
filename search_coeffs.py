import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'

reader = pypdf.PdfReader(pdf_file)

# We suspect equations or supplements might be at the end or in appendices
# Let's search for "intercept", "beta", "equation" in more pages or 
# check for a list of tables.
target_terms = ['coefficient', 'intercept', 'beta', 'baseline hazard']

for i in range(len(reader.pages)):
    page_text = reader.pages[i].extract_text()
    if not page_text: continue
    
    found = [t for t in target_terms if t.lower() in page_text.lower()]
    if found:
        # Search for floats with at least 4 decimal places which are common in model coefficients
        coeffs = re.findall(r'[-+]?\d\.\d{4,}', page_text)
        if coeffs:
             print(f"PAGE {i+1} | TERMS: {found}")
             print(f"COEFFS: {coeffs}")
             # Print a bit of context around the first coefficient
             idx = page_text.find(coeffs[0])
             print(f"CONTEXT: {page_text[max(0, idx-50):idx+50].replace('\n', ' ')}")
             print("-" * 30)

