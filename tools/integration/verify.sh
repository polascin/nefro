#!/usr/bin/env bash
set -euo pipefail
php tools/integration/guard.php
php tools/integration/runner_failure_probe.php
php tools/run_regressions.php
php tools/integration/run.php | tee /tmp/nefro-integration.log
grep -Eq '^Integration: [1-9][0-9]* checks PASS$' /tmp/nefro-integration.log
php tools/lint_all.php >/tmp/nefro-lint.log
tail -n 2 /tmp/nefro-lint.log
for source in ./*.js tools/test_*.mjs; do node --check "$source"; done
php /usr/local/bin/phpstan.phar analyse --no-progress --memory-limit=1G
