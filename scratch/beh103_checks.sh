#!/usr/bin/env bash
# Beh 103: PMID titles, article URL status, SQL concat greps.
set -euo pipefail
cd /d/Dev/nefro

echo "=== PMID titles (esummary) ==="
curl -sS "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&id=41791738,41793402,31146814,37807924,37807920,38490803,33663906,35023547,38785209,33879500,35113333,41321907&retmode=json" \
  | python -c "
import json,sys
d=json.load(sys.stdin)
ids=d['result']['uids']
for i in ids:
    r=d['result'][i]
    print(i, '|', r.get('pubtype',['?'])[0] if r.get('pubtype') else '?', '|', r.get('fulljournalname','?'), '|', r.get('title','')[:180])
"

echo
echo "=== Crossref main DOI ==="
curl -sS -A "NefroAudit/1.0 (mailto:nefro@localhost)" "https://api.crossref.org/works/10.1016/j.kint.2025.10.011" \
  | python -c "
import json,sys
m=json.load(sys.stdin)['message']
print('title:', m['title'][0][:160])
print('container:', m.get('container-title',['?'])[0])
print('issued:', m.get('issued',{}).get('date-parts'))
print('volume', m.get('volume'), 'issue', m.get('issue'), 'pages', m.get('page'))
print('author0:', m['author'][0].get('given'), m['author'][0].get('family'))
print('authorN:', m['author'][-1].get('given'), m['author'][-1].get('family'), 'n=', len(m['author']))
"

echo
echo "=== Article external URL status ==="
urls=(
  "https://doi.org/10.1016/j.kint.2025.10.011"
  "https://doi.org/10.1016/j.jchf.2026.102943"
  "https://kdigo.org/wp-content/uploads/2026/05/KDIGO-2026-Kidney-Disease-Heart-Failure-Controversies-Conference-Report-KI-Final.pdf"
  "https://pubmed.ncbi.nlm.nih.gov/41791738/"
  "https://pubmed.ncbi.nlm.nih.gov/41793402/"
  "https://doi.org/10.1016/j.jacc.2019.02.071"
  "https://pubmed.ncbi.nlm.nih.gov/31146814/"
  "https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6590908/"
  "https://doi.org/10.1161/CIR.0000000000001184"
  "https://pubmed.ncbi.nlm.nih.gov/37807924/"
  "https://doi.org/10.1161/CIR.0000000000001186"
  "https://pubmed.ncbi.nlm.nih.gov/37807920/"
  "https://kdigo.org/guidelines/ckd-evaluation-and-management/"
  "https://pubmed.ncbi.nlm.nih.gov/38490803/"
  "https://doi.org/10.1016/j.cardfail.2021.01.022"
  "https://pubmed.ncbi.nlm.nih.gov/33663906/"
  "https://doi.org/10.1093/eurheartj/ehab777"
  "https://pubmed.ncbi.nlm.nih.gov/35023547/"
  "https://doi.org/10.1056/NEJMoa2403347"
  "https://pubmed.ncbi.nlm.nih.gov/38785209/"
  "https://doi.org/10.2215/CJN.02480221"
  "https://pubmed.ncbi.nlm.nih.gov/33879500/"
  "https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8455037/"
  "https://doi.org/10.1007/s11892-021-01442-z"
  "https://pubmed.ncbi.nlm.nih.gov/35113333/"
  "https://doi.org/10.1016/j.mayocpiqo.2025.100671"
  "https://pubmed.ncbi.nlm.nih.gov/41321907/"
  "https://www.ncbi.nlm.nih.gov/pmc/articles/PMC12657295/"
  "https://kidneyfailurerisk.com/"
)
for u in "${urls[@]}"; do
  code=$(curl -sS -o /dev/null -w "%{http_code} %{url_effective}" -L --max-time 25 "$u" || echo "ERR")
  echo "$code  <-  $u"
done

echo
echo "=== Internal related slugs ==="
for slug in \
  srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026 \
  oblicka-v-centre-ckm-syndromu-kdigo \
  ckm-syndrom-stadia-skrining-liecba-usmernenie-2026 \
  ckm-syndrom-usmernenia-acc-aha-ada-asn-nefrologia \
  5-kritickych-chyb-manazment-ckm-syndromu-nefrologia \
  ckd-vznik-srdcoveho-zlyhavania-hfpef-svedsky-register \
  finerenon-ckm-syndrom-dm2-ckd-fidelity \
  liecba-ckd-2026-vrstvena-nefroprotekcia-post-aki
do
  code=$(curl -sS -o /tmp/beh103_body.html -w "%{http_code} %{size_download}" --max-time 25 \
    "https://nefro.polascin.net/article.php?slug=$slug")
  if grep -q "Fatal error\|/data/8/" /tmp/beh103_body.html; then
    echo "BODY FAIL $code $slug"
  else
    echo "OK $code $slug"
  fi
done

echo
echo "=== SQL concat greps (expect empty) ==="
rg -n --glob '*.php' --glob '!.trunk/**' --glob '!assets/**' \
  '(query|exec)[[:space:]]*\([[:space:]]*"[^"]*\$' || true
rg -n --glob '*.php' --glob '!.trunk/**' --glob '!assets/**' \
  '(query|exec)[[:space:]]*\([^)]*"[[:space:]]*\.[[:space:]]*\$' || true
