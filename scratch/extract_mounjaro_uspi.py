from pypdf import PdfReader

reader = PdfReader("scratch/mounjaro_uspi.pdf")
with open("scratch/mounjaro_uspi_extract.txt", "w", encoding="utf-8") as out:
    out.write("pages %d\n" % len(reader.pages))
    for i, page in enumerate(reader.pages):
        text = page.extract_text() or ""
        low = text.lower()
        if any(k in low for k in [
            "indications and usage",
            "surpass-cvot",
            "mace-3",
            "210.1",
            "high risk for these events",
            "non-fatal stroke",
            "all-cause",
            "all cause",
        ]):
            out.write("\n===== PAGE %d =====\n" % (i + 1))
            out.write(text)
print("wrote")
