#!/usr/bin/env bash
set -euo pipefail
BASE="https://nefro.polascin.net"
check() {
  local url="$1"
  local tmp
  tmp=$(mktemp)
  local code
  code=$(curl -sS -o "$tmp" -w "%{http_code}" "$url" || echo "000")
  local bytes
  bytes=$(wc -c < "$tmp" | tr -d ' ')
  local flags=""
  grep -q "Fatal error\|Call to undefined\|Uncaught\|Parse error" "$tmp" && flags="${flags} PHP_ERROR"
  grep -q "/data/8/" "$tmp" && flags="${flags} PATH_LEAK"
  echo "$code ${bytes}B${flags}  $url"
  rm -f "$tmp"
}

echo "=== LIVE HEALTH ==="
check "$BASE/"
check "$BASE/index.php"
check "$BASE/calculators.php"
check "$BASE/calculator_kfre.php"
check "$BASE/calculator_ambulatory.php"
check "$BASE/calculator_ckdpc.php"
check "$BASE/article.php?slug=srdcove-zlyhavanie-ckd-kdigo-kontroverzie-2026"
check "$BASE/privacy.php"
check "$BASE/cookies.php"
check "$BASE/terms.php"
check "$BASE/sitemap.php"
check "$BASE/nastroje.php"
check "$BASE/robots.txt"

echo "=== LIBRARIES (expect 403) ==="
for f in ckd_risk_models.php calculator_ambulatory_logic.php mkch10_codebook.php prevent_model.php db_config.php newsletter_worker.php auth.php legal_data.php article_publisher.php pdf_generator.php; do
  code=$(curl -sS -o /dev/null -w "%{http_code}" "$BASE/$f" || echo "000")
  echo "$code  $f"
done

echo "=== SENSITIVE JSON ==="
code=$(curl -sS -o /tmp/mkch.json -w "%{http_code}" "$BASE/assets/data/mkch10-sk.json" || echo "000")
bytes=$(wc -c < /tmp/mkch.json | tr -d ' ')
echo "$code ${bytes}B  mkch10-sk.json"
