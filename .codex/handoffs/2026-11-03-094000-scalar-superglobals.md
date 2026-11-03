# Handoff: scalar-superglobals

## Metadata

- Generated At: 2026-11-03T09:40:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: effbd221

## Original Goal

Slučka 12 (/loop): ďalší P1 z auditu, overenie, deploy, handoff a .doaudit.md.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `effbd221` = `server/main` = `origin/main`.

## Completed This Session

- [x] Posledné priame `(string)`/`(int)`/`trim()` na `$_GET`/`$_POST` v koreňových stránkach → request* helpery
- [x] Regresia v `tools/test_request_input.php` (130 PASS) zakáže recidívu
- [x] PHPStan 2 → 0 (`render_crontab.php`, `verify_crontab_parity.php`)

## Validated

- PHPStan 0; lint 703/0; UTF-8 837 PASS; regresie 41 PASS
- CS-Fixer: 6 súborov iba CRLF artefakt (LF kópie 0)
- Live: `/` 200; profile/admin 302; refresh_article/AGENTS 403

## Remaining Work

- [ ] Ďalší P1 (napr. klinické referenčné testy ďalších kalkulačiek, a11y úlohy)

## Decisions Made

- Admin GET filtre s poľovým parametrom → riadená 400 (rovnako ako admin_articles)
- Changelog nepridaný: bez zmeny viditeľnej pre používateľa

## Critical Files

- request_input.php
- tools/test_request_input.php
- tools/verify_crontab_parity.php

## Next Command

```text
php tools/run_regressions.php
```
