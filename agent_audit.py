import os, glob, re

issues = []

files = glob.glob('d:\\\\OneDrive\\\\www\\\\nefro\\\\*.php')
for path in files:
    filename = os.path.basename(path)
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. SQL Injection: check for ->query( string with $ variable )
    sqli_matches = re.finditer(r'->query\(\s*["\'][^"\']*?\$[^"\']*?["\']\s*\)', content)
    for match in sqli_matches:
        issues.append(f'[SQLi Risk] {filename}: {match.group(0)}')

    # 2. XSS: Check for <?= $_POST or <?= $_GET without htmlspecialchars
    xss_matches = re.finditer(r'<\?=\s*\$_(GET|POST|REQUEST)\[.*?\]\s*\?>', content)
    for match in xss_matches:
        issues.append(f'[XSS Risk] {filename}: {match.group(0)}')

    # 3. Missing CSRF validation on POST
    if "$_SERVER['REQUEST_METHOD'] === 'POST'" in content or '$_POST' in content:
        if 'validateCsrfToken' not in content and filename not in ['calculators_common.php', 'auth.php', 'db_config.php', 'phone_utils.php', 'header.php', 'footer.php', 'sitemap.php', 'update_sitemap.php', 'setup_db.php']:
            issues.append(f'[CSRF Risk] {filename}: Handles POST but validateCsrfToken not found.')

if not issues:
    print('No critical security issues found via basic static analysis.')
else:
    for issue in issues:
        print(issue)
