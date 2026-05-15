import os, glob
files = glob.glob('d:/OneDrive/www/nefro/*.php')
for f in files:
    with open(f, 'rb') as file:
        raw = file.read(4)
        if raw.startswith(b'\xef\xbb\xbf'):
            print(f"BOM found in {f}")
print("BOM check complete.")
