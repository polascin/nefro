#!/usr/bin/env bash

set -uo pipefail

usage() {
	cat <<'EOF'
Použitie: hooks/deploy.sh [--dry-run | --remote-commit] [base-ref]

Bez base-ref nasadí zmeny z posledného commitu. S base-ref nasadí všetky
zmeny od daného commitu po HEAD. --dry-run iba vypíše plán bez pripojenia.
--remote-commit vypíše DEPLOY_COMMIT zo servera (na kontrolu driftu) a skončí.
EOF
}

DRY_RUN=0
REMOTE_COMMIT_ONLY=0
BASE_REF=""

while (($# > 0)); do
	case "$1" in
	--dry-run)
		DRY_RUN=1
		;;
	--remote-commit)
		REMOTE_COMMIT_ONLY=1
		;;
	-h | --help)
		usage
		exit 0
		;;
	--*)
		echo "[deploy] Neznámy prepínač: $1" >&2
		usage >&2
		exit 2
		;;
	*)
		if [[ -n $BASE_REF ]]; then
			echo "[deploy] Povolený je najviac jeden base-ref." >&2
			exit 2
		fi
		BASE_REF=$1
		;;
	esac
	shift
done

REPO_ROOT=$(git rev-parse --show-toplevel 2>/dev/null) || {
	echo "[deploy] Skript musí bežať v Git repozitári." >&2
	exit 1
}
cd "$REPO_ROOT" || exit 1

DEPLOY_CONFIG=${NEFRO_DEPLOY_CONFIG:-"$HOME/.config/nefro/deploy.env"}
if [[ -r $DEPLOY_CONFIG ]]; then
	# Strojovo lokálne nastavenie zostáva mimo synchronizovaného repozitára.
	# shellcheck source=/dev/null
	source "$DEPLOY_CONFIG"
fi

if [[ -n $BASE_REF ]] && ! git rev-parse --verify "${BASE_REF}^{commit}" >/dev/null 2>&1; then
	echo "[deploy] Neplatný base-ref: $BASE_REF" >&2
	exit 1
fi

sftp_escape() {
	local value=$1
	value=${value//\\/\\\\}
	value=${value//\"/\\\"}
	printf '%s' "$value"
}

# Pripojenie sa rozlisuje len tu, aby --remote-commit aj samotny deploy pouzivali
# rovnaky ciel, kluc aj remote cestu.
setup_sftp() {
	SFTP_TARGET=${NEFRO_SFTP_TARGET:-""}
	REMOTE_PATH=${NEFRO_REMOTE_PATH:-"/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro"}
	REMOTE_PATH=${REMOTE_PATH%/}

	declare -g -a SFTP_OPTIONS=(-q -o BatchMode=yes -o ConnectTimeout=20 -o StrictHostKeyChecking=accept-new)

	# Bez strojovo lokálneho cieľa zostáva zachovaný pôvodný explicitný prístup.
	# Vďaka tomu konfigurácia Macu nemení správanie na synchronizovanom Windows stroji.
	if [[ -z $SFTP_TARGET ]]; then
		SFTP_HOST=${NEFRO_SFTP_HOST:-"shell.r1.websupport.sk"}
		SFTP_USER=${NEFRO_SFTP_USER:-"uid58858"}
		SFTP_TARGET="${SFTP_USER}@${SFTP_HOST}"
		SFTP_OPTIONS+=(-P "${NEFRO_SFTP_PORT:-26650}")
		SFTP_KEY=${NEFRO_SFTP_KEY:-"$HOME/.ssh/nefro_deploy"}
		if [[ ! -f $SFTP_KEY ]]; then
			# Pri --remote-commit musí na stdout ísť výlučne SHA, inak by volajúci
			# dostal ako "commit" túto hlášku; nenulový koniec ho pošle na fallback.
			if ((REMOTE_COMMIT_ONLY)); then
				echo "[deploy] SSH kľúč nenájdený: $SFTP_KEY" >&2
				exit 1
			fi
			echo "[deploy] SSH kľúč nenájdený; tento stroj nemá deploy oprávnenie: $SFTP_KEY"
			exit 0
		fi
		SFTP_OPTIONS+=(-i "$SFTP_KEY")
	fi

	for command in sftp mktemp; do
		if ! command -v "$command" >/dev/null 2>&1; then
			echo "[deploy] Chýba príkaz: $command" >&2
			exit 1
		fi
	done
}

# Vypíše DEPLOY_COMMIT z produkčného deploy_info.php a skončí. Pri neúspechu
# končí nenulovo, aby si volajúci mohol zvoliť vlastný fallback.
if ((REMOTE_COMMIT_ONLY)); then
	setup_sftp
	RC_BATCH=$(mktemp "${TMPDIR:-/tmp}/nefro_rc_batch_XXXXXX") || exit 1
	RC_INFO=$(mktemp "${TMPDIR:-/tmp}/nefro_rc_info_XXXXXX") || {
		rm -f "$RC_BATCH"
		exit 1
	}
	trap 'rm -f "$RC_BATCH" "$RC_INFO"' EXIT
	{
		printf 'get "%s" "%s"\n' \
			"$(sftp_escape "$REMOTE_PATH/deploy_info.php")" \
			"$(sftp_escape "$RC_INFO")"
		printf 'quit\n'
	} >"$RC_BATCH"
	if ! sftp "${SFTP_OPTIONS[@]}" -b "$RC_BATCH" "$SFTP_TARGET" >/dev/null 2>&1; then
		echo "[deploy] Nepodarilo sa načítať vzdialený deploy_info.php." >&2
		exit 1
	fi
	REMOTE_COMMIT=$(sed -n "s/.*DEPLOY_COMMIT'[[:space:]]*,[[:space:]]*'\([0-9a-fA-F]\{4,40\}\)'.*/\1/p" "$RC_INFO" | head -1)
	if [[ -z $REMOTE_COMMIT ]]; then
		echo "[deploy] Vo vzdialenom deploy_info.php chýba DEPLOY_COMMIT." >&2
		exit 1
	fi
	printf '%s\n' "$REMOTE_COMMIT"
	exit 0
fi

IGNORE_FILE=${NEFRO_DEPLOY_IGNORE_FILE:-"$REPO_ROOT/hooks/deploy-ignore.txt"}
declare -a PATHSPECS=(.)

if [[ -r $IGNORE_FILE ]]; then
	while IFS= read -r pattern || [[ -n $pattern ]]; do
		pattern=${pattern%$'\r'}
		[[ -z $pattern || $pattern == \#* ]] && continue
		PATHSPECS+=(":(exclude,glob)$pattern")
	done <"$IGNORE_FILE"
else
	echo "[deploy] Chýba ignore súbor: $IGNORE_FILE" >&2
	exit 1
fi

declare -a UPLOADS=()
declare -a DELETES=()

if [[ -n $BASE_REF ]]; then
	while IFS= read -r -d '' path; do
		UPLOADS+=("$path")
	done < <(git diff --name-only -z --diff-filter=ACMR "$BASE_REF" HEAD -- "${PATHSPECS[@]}")
	while IFS= read -r -d '' path; do
		DELETES+=("$path")
	done < <(git diff --name-only -z --diff-filter=D "$BASE_REF" HEAD -- "${PATHSPECS[@]}")
else
	while IFS= read -r -d '' path; do
		UPLOADS+=("$path")
	done < <(git diff-tree --root --no-commit-id -r -z --diff-filter=ACMR \
		--name-only HEAD -- "${PATHSPECS[@]}")
	while IFS= read -r -d '' path; do
		DELETES+=("$path")
	done < <(git diff-tree --root --no-commit-id -r -z --diff-filter=D \
		--name-only HEAD -- "${PATHSPECS[@]}")
fi

if ((${#UPLOADS[@]} == 0 && ${#DELETES[@]} == 0)); then
	echo "[deploy] Žiadne nasaditeľné zmeny."
	exit 0
fi

validate_path() {
	local path=$1
	if [[ $path == *$'\n'* || $path == *$'\r'* ]]; then
		echo "[deploy] Cesta obsahuje nepovolený nový riadok: $path" >&2
		return 1
	fi
	if [[ $path == /* || $path == ../* || $path == */../* ]]; then
		echo "[deploy] Nebezpečná relatívna cesta: $path" >&2
		return 1
	fi
}

for path in ${UPLOADS[@]+"${UPLOADS[@]}"} ${DELETES[@]+"${DELETES[@]}"}; do
	validate_path "$path" || exit 1
done

echo "[deploy] Upload: ${#UPLOADS[@]}, zmazanie: ${#DELETES[@]}"

if ((DRY_RUN)); then
	for path in ${UPLOADS[@]+"${UPLOADS[@]}"}; do
		printf '[deploy] PUT %s\n' "$path"
	done
	for path in ${DELETES[@]+"${DELETES[@]}"}; do
		printf '[deploy] RM  %s\n' "$path"
	done
	exit 0
fi

setup_sftp

BATCH_FILE=$(mktemp "${TMPDIR:-/tmp}/nefro_deploy_batch_XXXXXX") || exit 1
DEPLOY_INFO=$(mktemp "${TMPDIR:-/tmp}/nefro_deploy_info_XXXXXX") || {
	rm -f "$BATCH_FILE"
	exit 1
}
trap 'rm -f "$BATCH_FILE" "$DEPLOY_INFO"' EXIT

COMMIT=$(git rev-parse --short HEAD)
BRANCH=$(git symbolic-ref --quiet --short HEAD 2>/dev/null || printf 'detached')
TIMESTAMP=$(date '+%d.%m.%Y %H:%M')
UNIX_TS=$(date '+%s')

cat >"$DEPLOY_INFO" <<PHPEOF
<?php
// Automaticky generované deploy skriptom - neupravovať manuálne
define('DEPLOY_TIME', '$TIMESTAMP');
define('DEPLOY_TIMESTAMP', $UNIX_TS);
define('DEPLOY_COMMIT', '$COMMIT');
define('DEPLOY_BRANCH', '$BRANCH');
PHPEOF

for path in ${DELETES[@]+"${DELETES[@]}"}; do
	remote=$(sftp_escape "$REMOTE_PATH/$path")
	printf -- '-rm "%s"\n' "$remote" >>"$BATCH_FILE"
done

declare -a SEEN_DIRS=()
for path in ${UPLOADS[@]+"${UPLOADS[@]}"}; do
	[[ $path == */* ]] || continue
	directory=${path%/*}
	current=""
	IFS='/' read -r -a parts <<<"$directory"
	for part in "${parts[@]}"; do
		current=${current:+"$current/"}$part
		seen=0
		for seen_directory in ${SEEN_DIRS[@]+"${SEEN_DIRS[@]}"}; do
			if [[ $seen_directory == "$current" ]]; then
				seen=1
				break
			fi
		done
		((seen)) && continue
		SEEN_DIRS+=("$current")
		remote=$(sftp_escape "$REMOTE_PATH/$current")
		printf -- '-mkdir "%s"\n' "$remote" >>"$BATCH_FILE"
	done
done

for path in ${UPLOADS[@]+"${UPLOADS[@]}"}; do
	local_path=$(sftp_escape "$path")
	remote=$(sftp_escape "$REMOTE_PATH/$path")
	printf 'put "%s" "%s"\n' "$local_path" "$remote" >>"$BATCH_FILE"
done

local_info=$(sftp_escape "$DEPLOY_INFO")
remote_info=$(sftp_escape "$REMOTE_PATH/deploy_info.php")
printf 'put "%s" "%s"\n' "$local_info" "$remote_info" >>"$BATCH_FILE"
printf 'quit\n' >>"$BATCH_FILE"

echo "[deploy] Uploading cez SSH profil $SFTP_TARGET..."
SFTP_OUTPUT=$(
	sftp "${SFTP_OPTIONS[@]}" \
		-b "$BATCH_FILE" \
		"$SFTP_TARGET" 2>&1
)
RC=$?

while IFS= read -r line; do
	line=${line%$'\r'}
	[[ $line =~ ^remote\ mkdir\ .*:\ Failure$ ]] && continue
	[[ -n $line ]] && printf '%s\n' "$line"
done <<<"$SFTP_OUTPUT"

if ((RC != 0)); then
	echo "[deploy] SFTP zlyhalo (exit code: $RC)." >&2
	exit "$RC"
fi

echo "[deploy] Hotovo! ($TIMESTAMP, $BRANCH@$COMMIT)"
