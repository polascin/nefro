# Handoff: legal-claim-lease

## Metadata

- Generated At: 2026-11-03T09:07:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: d4f12dcf

## Original Goal

Slučka 11 (RSI): port legal claim/lease podľa newsletter vzoru alebo iný P1.

## Current State

Hotové. Runtime `DEPLOY_COMMIT` = `d4f12dcf`. Legal ENUM `sending`
na produkcii; ops_health PASS (mail ENUM sending ano×4).

## Completed This Session

- [x] Rozhodnutie: legal claim/lease ÁNO (DECISIONS.md)
- [x] Claim/lease helpers + process*Queue v `legal_notifications.php`
- [x] `add_legal_sending_status_migration.php` + setup_db ENUM + htaccess deny
- [x] Produkčná migrácia ENUM
- [x] RSI: reclaim pin v test_legal (65 PASS); ops_health legal ENUM

## Validated

- Regresie 41 PASS; legal 65 PASS
- Live ops_health RESULT PASS; migration HTTP 403
- DEPLOY_COMMIT=d4f12dcf

## Remaining Work

- [ ] Ďalší P1 z auditu

## Decisions Made

- Legal claim/lease portovať teraz (nie ďalší odklad)
- Feature detection + SQLite always-on v testoch

## Critical Files

- legal_notifications.php
- add_legal_sending_status_migration.php
- ops_health.php
- tools/test_legal_notifications.php

## Next Command

```text
# Ďalší P1 z .audit.md; php tools/run_regressions.php
```
