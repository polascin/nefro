import os, glob, re, json

php_files = glob.glob('d:\\\\OneDrive\\\\www\\\\nefro\\\\calculator_*.php')
for path in php_files:
    if 'calculator_result_print.php' in path or 'calculators_common.php' in path: continue
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    if 'application/ld+json' in content: 
        print(f"Skipping {path}, already has JSON-LD")
        continue

    filename = os.path.basename(path)
    
    title_match = re.search(r'\$pageTitle\s*=\s*[\'"](.*?)[\'"]', content)
    title = title_match.group(1).replace(' | \' . $siteName', '').replace(' | ', '') if title_match else 'Lekárska kalkulačka'
    
    desc_match = re.search(r'\$pageDesc\s*=\s*[\'"](.*?)[\'"]', content)
    desc = desc_match.group(1) if desc_match else 'Nástroj pre klinické rozhodovanie a výpočty v nefrológii.'
    
    url = f"https://nefro.polascin.net/{filename}"
    
    schema = {
        "@context": "https://schema.org",
        "@type": ["MedicalWebPage", "WebApplication"],
        "name": title,
        "description": desc,
        "url": url,
        "applicationCategory": "HealthApplication",
        "audience": {
            "@type": "MedicalAudience",
            "audienceType": "Clinician"
        },
        "about": {
            "@type": "MedicalCondition",
            "name": "Kidney Disease"
        },
        "publisher": {
            "@type": "MedicalOrganization",
            "name": "Nefro-projekt Slovensko",
            "logo": {
                "@type": "ImageObject",
                "url": "https://nefro.polascin.net/img/nps-logo.gif"
            }
        }
    }
    
    schema_str = json.dumps(schema, ensure_ascii=False, indent=4)
    
    injection = f"    <script type=\"application/ld+json\">\n{schema_str}\n    </script>\n</head>"
    
    content = content.replace("</head>", injection, 1)
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Updated {filename}")
