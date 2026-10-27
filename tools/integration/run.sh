#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/../.."
PROJECT="nefro-integration-${GITHUB_RUN_ID:-local}-$$"
COMPOSE=(docker compose --project-name "$PROJECT" --file tools/integration/compose.yaml)
cleanup() {
	local status=$?
	if ((status != 0)); then
		"${COMPOSE[@]}" logs --no-color --tail 100 app mailpit || true
	fi
	"${COMPOSE[@]}" down --volumes --remove-orphans || true
	exit "$status"
}
trap cleanup EXIT
"${COMPOSE[@]}" build certs
"${COMPOSE[@]}" up --detach --wait --wait-timeout 180 app
"${COMPOSE[@]}" run --no-deps --rm tests
DUMP=$(mktemp)
"${COMPOSE[@]}" run --no-deps --rm tests php -d display_errors=stderr tools/integration/backup_probe.php --dump >"$DUMP"
# Expand database credentials inside the isolated container, not on the host.
# shellcheck disable=SC2016
"${COMPOSE[@]}" exec -T db sh -c 'MYSQL_PWD="$MARIADB_PASSWORD" mariadb -u "$MARIADB_USER" "$MARIADB_DATABASE"' <"$DUMP"
rm -f "$DUMP"
"${COMPOSE[@]}" run --no-deps --rm tests php tools/integration/backup_probe.php --verify
# Na Windows je `python3` často len odkaz do Microsoft Store, ktorý nič nespustí;
# preto sa použije prvý interpreter, ktorý skutočne odpovie.
PYTHON=""
for candidate in python3 python py; do
	if command -v "$candidate" >/dev/null 2>&1 && "$candidate" -c 'import sys; sys.exit(0 if sys.version_info >= (3, 8) else 1)' >/dev/null 2>&1; then
		PYTHON=$candidate
		break
	fi
done
[[ -n $PYTHON ]] || { echo "Python 3.8+ nie je dostupný; test obnovy sa nedá spustiť." >&2; exit 1; }
"$PYTHON" tools/restore/self_test.py --file-image "${PROJECT}-php"
