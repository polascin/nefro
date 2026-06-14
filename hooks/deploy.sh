#!/bin/sh
# Automatický deploy zmenených súborov na produkčný server nefro.polascin.net
# Volaný z post-commit hooku.
#   bez argumentu     → nasadí súbory zmenené v poslednom commite (HEAD)
#   sh deploy.sh <ref> → nasadí všetky súbory zmenené od <ref> po HEAD
#                        (jednorazové dobehnutie po výpadku deployu)

SFTP_KEY="$HOME/.ssh/nefro_deploy"
SFTP_HOST="shell.r1.websupport.sk"
SFTP_USER="uid58858"
SFTP_PORT="26650"
REMOTE_PATH="/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro"

if [ ! -f "$SFTP_KEY" ]; then
    echo "[deploy] SSH kľúč nenájdený: $SFTP_KEY — preskakujem upload."
    exit 0
fi

# Súbory na upload/zmazanie — voliteľný base-ref pre dobehnutie viacerých commitov
BASE_REF="$1"
if [ -n "$BASE_REF" ]; then
    UPLOAD=$(git diff --diff-filter=ACMR --name-only "$BASE_REF" HEAD 2>/dev/null \
      | grep -v '^\.claude/' | grep -v '^\.vscode/' | grep -v '^scratch/node_modules/')
    DELETE=$(git diff --diff-filter=D --name-only "$BASE_REF" HEAD 2>/dev/null \
      | grep -v '^\.claude/' | grep -v '^\.vscode/' | grep -v '^scratch/node_modules/')
else
    UPLOAD=$(git diff-tree --no-commit-id -r --diff-filter=ACMR --name-only HEAD 2>/dev/null \
      | grep -v '^\.claude/' | grep -v '^\.vscode/' | grep -v '^scratch/node_modules/')
    DELETE=$(git diff-tree --no-commit-id -r --diff-filter=D --name-only HEAD 2>/dev/null \
      | grep -v '^\.claude/' | grep -v '^\.vscode/' | grep -v '^scratch/node_modules/')
fi

if [ -z "$UPLOAD" ] && [ -z "$DELETE" ]; then
    exit 0
fi

SCRIPT_FILE=$(mktemp /tmp/nefro_deploy_XXXXX.sftp)

# Mazanie
if [ -n "$DELETE" ]; then
    echo "$DELETE" | while IFS= read -r f; do
        f=$(echo "$f" | tr -d '\r')
        [ -z "$f" ] && continue
        printf -- '-rm "%s/%s"\n' "$REMOTE_PATH" "$f" >> "$SCRIPT_FILE"
    done
fi

# Upload
if [ -n "$UPLOAD" ]; then
    echo "$UPLOAD" | while IFS= read -r f; do
        f=$(echo "$f" | tr -d '\r')
        [ -z "$f" ] && continue
        # Vytvor nadradený adresár (ak súbor je v podadresári)
        dir=$(dirname "$f")
        if [ "$dir" != "." ]; then
            # Vytvor všetky úrovne adresárov
            parts="$dir"
            current=""
            IFS='/' read -ra PARTS <<< "$parts"
            for part in "${PARTS[@]}"; do
                current="$current/$part"
                printf -- '-mkdir "%s%s"\n' "$REMOTE_PATH" "$current" >> "$SCRIPT_FILE"
            done
        fi
        printf 'put "%s" "%s/%s"\n' "$f" "$REMOTE_PATH" "$f" >> "$SCRIPT_FILE"
    done
fi

if [ ! -s "$SCRIPT_FILE" ]; then
    rm -f "$SCRIPT_FILE"
    exit 0
fi

echo "[deploy] Uploading na $SFTP_HOST..."
sftp -i "$SFTP_KEY" \
     -P "$SFTP_PORT" \
     -o StrictHostKeyChecking=accept-new \
     -o BatchMode=yes \
     -b "$SCRIPT_FILE" \
     "${SFTP_USER}@${SFTP_HOST}" 2>&1

RC=$?
rm -f "$SCRIPT_FILE"

if [ $RC -eq 0 ]; then
    # Vygeneruj a nahraj deploy_info.php s aktuálnym timestampom
    COMMIT=$(git rev-parse --short HEAD 2>/dev/null)
    BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null)
    TIMESTAMP=$(date '+%d.%m.%Y %H:%M')
    UNIX_TS=$(date '+%s')
    DEPLOY_INFO=$(mktemp /tmp/nefro_deploy_info_XXXXX.php)
    cat > "$DEPLOY_INFO" << PHPEOF
<?php
// Automaticky generované deploy skriptom — neupravovať manuálne
define('DEPLOY_TIME', '$TIMESTAMP');
define('DEPLOY_TIMESTAMP', $UNIX_TS);
define('DEPLOY_COMMIT', '$COMMIT');
define('DEPLOY_BRANCH', '$BRANCH');
PHPEOF
    printf 'put "%s" "%s/deploy_info.php"\nexit\n' "$DEPLOY_INFO" "$REMOTE_PATH" \
      | sftp -i "$SFTP_KEY" -P "$SFTP_PORT" -o BatchMode=yes -o StrictHostKeyChecking=accept-new \
             "${SFTP_USER}@${SFTP_HOST}" 2>/dev/null
    rm -f "$DEPLOY_INFO"
    echo "[deploy] Hotovo! ($TIMESTAMP, $BRANCH@$COMMIT)"
else
    echo "[deploy] Chyba (exit code: $RC)"
fi
