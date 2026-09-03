#!/usr/bin/env bash
set -euo pipefail
cd /d/Dev/nefro
git add .audit.md
git commit -F scratch/commitmsg_beh103.txt
git status
git log -1 --oneline
