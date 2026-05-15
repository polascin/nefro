import pypdf
import os
import re

pdf_file = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
pages_to_check = [13, 15, 30, 84, 85, 126]

reader = pypdf.PdfReader(pdf_file)

def clean_text(text):
    return " ".join(text.split())

for p_num in pages_to_check:
    print(f"--- PAGE {p_num} ---")
    page = reader.pages[p_num - 1]
    text = page.extract_text()
    
    # Simple strategy: find 2-year, 3-year, 5-year and print context
    for horizon in ['3-year', '3 year', '2-year', '5-year']:
        if horizon.lower() in text.lower():
            start = text.lower().find(horizon.lower())
            print(f"CONTEXT ({horizon}): {text[max(0, start-100):min(len(text), start+100)].replace('\n', ' ')}")

    # Look for coefficients (floats with several decimals)
    coeffs = re.findall(r'[-+]?\d\.\d{3,}', text)
    if coeffs:
        print(f"POTENTIAL COEFFICIENTS: {coeffs}")
        
    # Check for CKD-PC tables/links
    if "CKD-PC" in text:
        print("CKD-PC found on this page.")

