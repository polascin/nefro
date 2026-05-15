import pypdf
import sys

sys.stdout.reconfigure(encoding='utf-8')

pdf_path = r'c:\Users\polas\Downloads\KDIGO-2024-CKD\KDIGO-2024-CKD-Guideline.pdf'
pages_to_extract = [33, 44, 61, 70, 71, 72, 73, 74] # 0-indexed

reader = pypdf.PdfReader(pdf_path)
for page_num in pages_to_extract:
    page = reader.pages[page_num]
    text = page.extract_text()
    if "risk" in text.lower() or "formula" in text.lower() or "ESRD" in text or "40%" in text:
        print(f"--- PAGE {page_num + 1} ---")
        # Print lines containing the keywords with context
        lines = text.split('\n')
        for i, line in enumerate(lines):
            if any(k in line for k in ["CKD-PC", "KFRE", "coefficient", "40%", "ESRD", "regression", "equation", "alpha", "beta", "intercept"]):
                start = max(0, i-2)
                end = min(len(lines), i+3)
                print("\n".join(lines[start:end]))
                print("-" * 20)
