#!/usr/bin/env bash
#
# local_gate.sh: lokálna brána pred nasadením, náhrada za GitHub CI.
#
# Overuje presne ten commit, ktorý sa nasadí: ak sa sledované PHP/JS súbory
# v pracovnom strome líšia od HEAD, brána odmietne, lebo testy by bežali na
# iných bajtoch, než aké deploy.sh nahrá (berie ich z `git show HEAD:...`).
#
# Kroky: syntax všetkých PHP súborov, regresná sada, syntax JS sprievodcov.
# Integračná sada v Dockeri (rovnaká ako bývalý „Regression gate“) beží len
# pri NEFRO_GATE_INTEGRATION=1, lebo trvá niekoľko minút.

set -uo pipefail

REPO_ROOT=$(git rev-parse --show-toplevel 2>/dev/null) || {
	echo "[gate] Skript musí bežať v Git repozitári." >&2
	exit 1
}
cd "$REPO_ROOT" || exit 1

PHP_BIN=${NEFRO_PHP_BIN:-php}
if ! command -v "$PHP_BIN" >/dev/null 2>&1; then
	echo "[gate] Chýba PHP ($PHP_BIN); bez overenia sa nenasadzuje." >&2
	exit 1
fi

if ! git -c core.safecrlf=false diff --quiet HEAD -- '*.php' '*.js' 2>/dev/null; then
	echo "[gate] PHP/JS súbory v pracovnom strome sa líšia od HEAD:" >&2
	git -c core.safecrlf=false diff --name-only HEAD -- '*.php' '*.js' 2>/dev/null | sed 's/^/[gate]   /' >&2
	echo "[gate] Commitni alebo odlož ich (git stash), inak by sa overoval iný kód, než aký sa nasadí." >&2
	exit 1
fi

echo "[gate] Syntax PHP..."
LINT_OUTPUT=$("$PHP_BIN" tools/lint_all.php 2>&1)
LINT_RC=$?
if ((LINT_RC != 0)); then
	printf '%s\n' "$LINT_OUTPUT" | grep -v '^No syntax errors' | tail -20 >&2
	echo "[gate] Syntax PHP neprešla." >&2
	exit 1
fi
printf '%s\n' "$LINT_OUTPUT" | tail -1 | sed 's/^/[gate] /'

echo "[gate] Regresná sada..."
REG_OUTPUT=$("$PHP_BIN" tools/run_regressions.php 2>&1)
REG_RC=$?
if ((REG_RC != 0)); then
	printf '%s\n' "$REG_OUTPUT" | tail -20 >&2
	echo "[gate] Regresná sada neprešla." >&2
	exit 1
fi
printf '%s\n' "$REG_OUTPUT" | grep -E '^Regression suite' | sed 's/^/[gate] /'

if command -v node >/dev/null 2>&1; then
	JS_FAIL=0
	while IFS= read -r -d '' file; do
		if ! node --check "$file" >/dev/null 2>&1; then
			echo "[gate] Syntax JS: $file" >&2
			JS_FAIL=1
		fi
	done < <(git ls-files -z -- ':(glob)*.js' ':(glob)assets/*.js')
	if ((JS_FAIL)); then
		echo "[gate] Syntax JS neprešla." >&2
		exit 1
	fi
	echo "[gate] Syntax JS v poriadku."
else
	echo "[gate] node nie je dostupný; kontrolu JS preskakujem."
fi

if [[ ${NEFRO_GATE_INTEGRATION:-0} == 1 ]]; then
	echo "[gate] Integračná sada (Docker)..."
	if ! bash tools/integration/run.sh; then
		echo "[gate] Integračná sada neprešla." >&2
		exit 1
	fi
fi

echo "[gate] Brána prešla pre $(git rev-parse --short HEAD)."
