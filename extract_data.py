import pdfplumber
import os
import re
import json

folder = r"c:\Users\polas\Downloads\KDIGO-2024-CKD"
keywords = ["Grams", "Tangri", "Matsushita", "CKD-PC", "risk model", "coefficients", "40%", "eGFR decline", "logit", "hazard"]

def check_text(text):
    if not text: return False
    return any(kw.lower() in text.lower() for kw in keywords)

results = []

for filename in os.listdir(folder):
    if filename.endswith(".pdf"):
        filepath = os.path.join(folder, filename)
        print(f"Processing {filename}...")
        try:
            with pdfplumber.open(filepath) as pdf:
                for page_num, page in enumerate(pdf.pages):
                    text = page.extract_text()
                    if check_text(text):
                        tables = page.extract_tables()
                        if tables:
                            for table_idx, table in enumerate(tables):
                                # Filter tables that might contain numbers/coefficients
                                table_str = str(table)
                                if re.search(r"\d+\.\d+", table_str) or any(kw.lower() in table_str.lower() for kw in keywords):
                                    results.append({
                                        "file": filename,
                                        "page": page_num + 1,
                                        "table_index": table_idx,
                                        "content": table
                                    })
                        
                        # Also look for decimals in text if tables are missing or small
                        decimals = re.findall(r"-?\d+\.\d{2,}", text)
                        if len(decimals) > 5:
                            results.append({
                                "file": filename,
                                "page": page_num + 1,
                                "type": "text_decimals",
                                "content": decimals[:20] # Limit output
                            })
        except Exception as e:
            print(f"Error processing {filename}: {e}")

with open("extraction_results.json", "w") as f:
    json.dump(results, f)
