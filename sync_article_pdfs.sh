#!/bin/sh
# sync_article_pdfs.sh
# ─────────────────────────────────────────────────────────────────────────────
# Zosúladí PDF verzie článkov medzi serverom a gitom. Spusti po zmene obsahu
# článkov (audit, slovenská korektúra/revízia, nový alebo upravený článok).
#
#   1) na serveri preregeneruje CHÝBAJÚCE a NEAKTUÁLNE PDF (--stale: podľa
#      articles.updated_at vs. čas súboru) — zachytí zmenu obsahu akoukoľvek
#      cestou (admin, korektúrny skript, UPSERT …),
#   2) stiahne PDF zo servera do lokálneho pdf/,
#   3) ak nastali zmeny, commitne ich (post-commit hook → push + deploy).
#
# Spustenie z koreňa projektu:  sh sync_article_pdfs.sh
# ─────────────────────────────────────────────────────────────────────────────

KEY="$HOME/.ssh/nefro_deploy"
HOST="shell.r1.websupport.sk"
USER="uid58858"
PORT="26650"
REMOTE="/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro"
ROOT="$(cd "$(dirname "$0")" && pwd)"

SFTP_BIN="${NEFRO_SFTP_BIN:-}"
SFTP_WINDOWS_CLIENT=0
if [ -z "$SFTP_BIN" ]; then
	case "$(uname -s 2>/dev/null || true)" in
	MINGW* | MSYS* | CYGWIN*)
		# Windows Application Control môže blokovať nepodpísaný klient z Git for
		# Windows. Uprednostni podpísaný systémový OpenSSH klient.
		if [ -x /c/Windows/System32/OpenSSH/sftp.exe ]; then
			SFTP_BIN=/c/Windows/System32/OpenSSH/sftp.exe
			SFTP_WINDOWS_CLIENT=1
		fi
		;;
	esac
fi
if [ -z "$SFTP_BIN" ]; then
	SFTP_BIN="$(command -v sftp 2>/dev/null || true)"
fi
if [ -z "$SFTP_BIN" ] || [ ! -x "$SFTP_BIN" ]; then
	echo "[sync-pdf] Chýba spustiteľný SFTP klient." >&2
	exit 1
fi
case "$SFTP_BIN" in
*.exe)
	if command -v cygpath >/dev/null 2>&1; then
		SFTP_WINDOWS_CLIENT=1
	fi
	;;
esac

if [ ! -f "$KEY" ]; then
	echo "[sync-pdf] SSH kľúč nenájdený: $KEY — končím."
	exit 0
fi

echo "[sync-pdf] 1/3 Regenerujem chýbajúce/neaktuálne PDF na serveri…"
ssh -i "$KEY" -p "$PORT" -o StrictHostKeyChecking=accept-new "$USER@$HOST" \
	"php $REMOTE/generate_all_article_pdfs.php --stale" 2>&1 |
	grep -E 'Hotovo|✓|✗|CHYBA' || true

echo "[sync-pdf] 2/3 Sťahujem PDF zo servera do pdf/…"
mkdir -p "$ROOT/pdf"
LOCAL_PDF_DIR="$ROOT/pdf"
if [ "$SFTP_WINDOWS_CLIENT" -eq 1 ]; then
	LOCAL_PDF_DIR="$(cygpath -m "$LOCAL_PDF_DIR")" || exit 1
fi
if ! "$SFTP_BIN" -q -i "$KEY" -P "$PORT" -o StrictHostKeyChecking=accept-new "$USER@$HOST" >/dev/null <<SFTP
lcd "$LOCAL_PDF_DIR"
cd $REMOTE/pdf
mget *.pdf
SFTP
then
	echo "[sync-pdf] Sťahovanie PDF cez SFTP zlyhalo." >&2
	exit 1
fi

echo "[sync-pdf] 3/3 Commitujem zmeny v pdf/ (ak nejaké sú)…"
cd "$ROOT" || exit 1
git add pdf/*.pdf 2>/dev/null
if git diff --cached --quiet -- pdf/; then
	echo "[sync-pdf] Žiadne zmeny v PDF — hotovo."
else
	n=$(git diff --cached --name-only -- pdf/ | wc -l | tr -d ' ')
	git commit -m "content(pdf): sync ${n} PDF zo servera (po zmene obsahu)"
	echo "[sync-pdf] Commitnutých ${n} PDF (push + deploy beží cez post-commit hook)."
fi
