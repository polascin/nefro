#!/usr/bin/env bash
set -euo pipefail
cd /d/Dev/nefro
BASE="https://nefro.polascin.net"
kfre=$(mktemp)
amb=$(mktemp)
curl -sS -o "$kfre" "$BASE/calculator_kfre.php"
curl -sS -o "$amb" "$BASE/calculator_ambulatory.php"
echo "kfre bytes $(wc -c < "$kfre" | tr -d ' ')"
echo "Tangri 2024: $(grep -c 'Tangri 2024' "$kfre" || true)"
echo "accusative Severnú Ameriku: $(grep -c 'Severnú Ameriku' "$kfre" || true)"
echo "genitive Severnej Ameriky: $(grep -c 'Severnej Ameriky' "$kfre" || true)"
echo "Tangri 2011/2016: $(grep -c 'Tangri 2011/2016' "$kfre" || true)"
grep -q 'Fatal error\|Call to undefined\|Uncaught\|/data/8/' "$kfre" && echo KFRE_BODY_FAIL || echo KFRE_BODY_OK
echo "amb accusative: $(grep -c 'Severnú Ameriku' "$amb" || true)"
echo "amb genitive: $(grep -c 'Severnej Ameriky' "$amb" || true)"
grep -q 'Fatal error\|Call to undefined\|Uncaught\|/data/8/' "$amb" && echo AMB_BODY_FAIL || echo AMB_BODY_OK
rm -f "$kfre" "$amb"
echo "=== DRIFT ==="
bash hooks/deploy.sh --remote-commit
echo "local $(git rev-parse --short HEAD)"
