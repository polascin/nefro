# Handoff: crontab-cli-ops-regression

## Metadata

- Generated At: 2026-11-03T07:46:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 3cef9245

## Original Goal

Autonómna slučka 8: P1 mimo claim/lease a mimo sync produkčného crontabu.
Ops v kóde / regresia.

## Current State

Hotové. HEAD `3cef9245` (tools-only). Runtime `DEPLOY_COMMIT` ostáva
`f5032e59` (ignore drift OK). Claim/lease a produkčný crontab **netknuté**.

## Completed This Session

- [x] `tools/test_crontab_cli_ops.php` (50 PASS) — povinné úlohy v
  `crontab.example`, OMITNUTÉ sekcia, `.htaccess` `<Files>` deny, CLI guard
- [x] Zapísané do `tools/regressions.json` (40 files PASS)
- [x] Live: `ops_health.php` / `newsletter_worker.php` 403
- [x] Claim/lease ENUM **nebol**; produkčný crontab **nebol**

## Validated

- Command: `php tools/test_crontab_cli_ops.php` → 50 PASS
- Command: `php tools/run_regressions.php` → 40 files PASS
- Live: `/` 200; ops_health + newsletter_worker + AGENTS 403
- Deploy marker: `f5032e59` (očakávaný drift voči HEAD; iba tools)

## Not Yet Validated

- **Ops (súhlas):** produkčný crontab stále vs example — chýbajú
  provider_notice, backup_snapshot, sync_drugs, sync_clinical_trials;
  newsletter_worker `*/30`
- Assumption: claim/lease stále vyžaduje výslovný súhlas

## Remaining Work

- [ ] Po súhlase: sync produkčný crontab
- [ ] Claim/lease ENUM **iba so súhlasom**
- [ ] Iný P1 z auditu

## Decisions Made

- Decision: Regresia zdrojovej pravdy cronu namiesto zmeny produkčného crontabu
- Reason: Explicitný zákaz sync crontabu bez súhlasu
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez súhlasu

## Blockers / Open Questions

- Cron sync a claim/lease čakajú na súhlas majiteľa.

## Critical Files

- tools/test_crontab_cli_ops.php
- tools/regressions.json
- tools/crontab.example
- .htaccess

## Recent Commits

- 3cef9245 test(ops): regresia crontab.example a CLI deny
- a7480ac6 docs(state): SHA deploy vs HEAD po handoffe Beh 145
- f5032e59 fix(a11y): cookie banner mimo a11y stromu po súhlase

## Modified Files

- (committed) tools/test_crontab_cli_ops.php, tools/regressions.json

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-074603-crontab-cli-ops-regression.md

## Next Command

```text
# Po súhlase: sync crontab ALEBO claim/lease.
# Inak ďalší P1 z .audit.md (a11y aria-label unit selects, …).
# php tools/run_regressions.php
```
