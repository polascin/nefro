import os
import re
import glob

# Files to update
php_files = glob.glob('d:\\\\OneDrive\\\\www\\\\nefro\\\\calculator_*.php')
php_files.append('d:\\\\OneDrive\\\\www\\\\nefro\\\\calculators.php')
php_files.append('d:\\\\OneDrive\\\\www\\\\nefro\\\\login.php')
php_files.append('d:\\\\OneDrive\\\\www\\\\nefro\\\\register.php')

for path in php_files:
    if 'calculator_result_print.php' in path or 'calculators_common.php' in path:
        continue
    
    filename = os.path.basename(path)
    
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if '<meta name="description"' in content:
        # Already has description, skip or update?
        # Let's skip to avoid duplicates if already implemented
        continue
        
    title_match = re.search(r'<title>(.*?)</title>', content)
    title = title_match.group(1) if title_match else 'Nefrologická kalkulačka'
    
    # Strip suffix from title if present
    title = title.replace(' - Kalkulačky KDIGO 2024 CKD', '').replace(' - Kalkulačky', '').replace(' - Nefro', '')
    
    intro_match = re.search(r'\$headerIntro\s*=\s*[\'"](.*?)[\'"];', content)
    intro = intro_match.group(1) if intro_match else ''
    
    if 'calculator_' in filename or 'calculators' in filename:
        desc = f"Nefrologická kalkulačka a nástroj: {title}. {intro}. Presné klinické výpočty podľa najnovších odporúčaní pre lekárov na Slovensku."
    else:
        desc = f"Nefro-projekt Slovensko - {title}. Odborný portál pre lekárov a nefrológov."
        
    # Clean up desc
    desc = desc.replace('..', '.').strip()
    
    canonical = f"https://nefro.polascin.net/{filename}"
    
    tags_to_insert = f"""
    <meta name="description" content="{desc}">
    <link rel="canonical" href="{canonical}">
    <meta property="og:title" content="{title}">
    <meta property="og:description" content="{desc}">
    <meta property="og:url" content="{canonical}">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow">
"""
    
    # Insert right after <title>
    content = re.sub(r'(<title>.*?</title>)', r'\1' + tags_to_insert, content, 1)
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Added SEO tags to {filename}")

