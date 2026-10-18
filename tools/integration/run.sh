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
