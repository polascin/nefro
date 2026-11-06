#!/usr/bin/env bash
# Kontrola externých odkazov v zdrojoch obsahu (články, lieky, kalkulačky, bočný panel).
#
# Odkazy sa overujú zo servera WebSupport (SSH alias `websupport`), nie z lokálneho PC:
# lokálna sieť/IPv6 dáva pri niektorých hostoch falošné „000“ (Beh 172, 173).
#
# Použitie (Git Bash na Windows alebo shell na macOS):
#   bash tools/check_external_links.sh            # všetky zdroje
#   bash tools/check_external_links.sh --limit 50 # len prvých N URL (rýchly test)
#
# Výstup: private/link-check/<UTC>.tsv (mimo gitu) a súhrn na stdout.
# Stĺpce TSV: http_kód, počet zhôd „doména na predaj“, výsledná URL, pôvodná URL.
# Hodnotenie: 404/410 = mŕtvy odkaz; zhoda „na predaj“ = zaparkovaná doména;
# 403/429 = ochrana proti botom (NEOVERENÉ, nie mŕtvy odkaz); 000 = bez odpovede,
# over druhým miestom pred opravou. Opravy publikovaných článkov idú cez
# add_*_article.php a vyžadujú súhlas majiteľa (.doaudit.md).
set -euo pipefail

root="$(cd "$(dirname "$0")/.." && pwd)"
limit=0
if [ "${1:-}" = "--limit" ]; then
    limit="${2:-0}"
fi

stamp="$(date -u +%Y%m%dT%H%M%SZ)"
outdir="$root/private/link-check"
mkdir -p "$outdir"
list="$outdir/$stamp-urls.txt"
out="$outdir/$stamp.tsv"

cd "$root"
# &amp; v PHP/HTML zdroji je v prehliadači &; bez dekódovania vznikajú falošné 404 (ŠÚKL).
grep -o -h -E 'https?://[A-Za-z0-9._~:/?#@!$&+,;=%-]+' \
    add_*_article.php lieky.php studie.php drugs_common.php \
    calculator_*.php nastroj_*.php nastroje.php calculators.php index.php article.php footer.php \
    2>/dev/null \
    | sed -E 's/&amp;/\&/g; s/[).,;:]+$//' \
    | grep -v -E 'pubmed\.ncbi|doi\.org|nefro\.polascin\.net|<\?|schema\.org|w3\.org' \
    | sort -u > "$list"

if [ "$limit" -gt 0 ]; then
    head -n "$limit" "$list" > "$list.tmp" && mv "$list.tmp" "$list"
fi
count="$(wc -l < "$list" | tr -d ' ')"
echo "URL na kontrolu: $count"

remote_list="/tmp/nefro-linkcheck-$stamp.txt"
remote_helper="/tmp/nefro-linkcheck-$stamp.sh"
helper="$outdir/$stamp-check.sh"
cat > "$helper" <<'HELPER'
#!/bin/sh
u="$1"
tmp="$(mktemp)"
r="$(curl -s -m 25 -L --max-redirs 8 -A 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/130 Safari/537.36' -o "$tmp" -w '%{http_code} %{url_effective}' "$u" 2>/dev/null || true)"
sale="$(grep -ci 'hugedomains\|sedo.com/search\|dan.com/buy\|afternic\|this domain is for sale\|buy this domain' "$tmp" 2>/dev/null || true)"
rm -f "$tmp"
code="${r%% *}"
final="${r#* }"
printf '%s\t%s\t%s\t%s\n' "${code:-000}" "${sale:-0}" "$final" "$u"
HELPER
scp -q "$list" "websupport:$remote_list"
scp -q "$helper" "websupport:$remote_helper"
rm -f "$helper"

# Server: 4 súbežné požiadavky, timeout 25 s, nasleduje presmerovania.
ssh -o BatchMode=yes websupport "xargs -P4 -n1 sh '$remote_helper' < '$remote_list'; rm -f '$remote_list' '$remote_helper'" > "$out"

echo "Výsledok: $out"
echo "Kódy:"
cut -f1 "$out" | sort | uniq -c | sort -rn
echo "Na kontrolu (404/410, 000, doména na predaj):"
awk -F'\t' '$1=="404" || $1=="410" || $1=="000" || $2>0' "$out"
