# Handoff: cron-sync-sending-lease

## Metadata

- Generated At: 2026-11-03T08:45:00+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: bad2398d (+ LF fix commit pending)

## Original Goal

Nový mandát majiteľa: rozhodovať sám (RSI). Vyhodnotiť cron sync,
claim/lease ENUM sending a ďalší P1; implementovať najvyššiu hodnotu.

## Current State

Hotové. Produkčný crontab zarovnaný so SoT; newsletter ENUM `sending`
aktívny; `ops_health --no-http` PASS vrátane ENUM. Legal claim/lease
odložené. PHPStan providers commit `246f0fc8` na main (nekolízia).

## Completed This Session

- [x] Rozhodnutia v `state/DECISIONS.md` (cron ÁNO, newsletter sending ÁNO,
  legal sending NIE)
- [x] `tools/crontab_lib.php`, `render_crontab.php`, `verify_crontab_parity.php`
- [x] Inštalácia produkčného crontabu + záloha `crontab.nefro.bak.20261103T074351Z`
- [x] `add_newsletter_sending_status_migration.php` na produkcii
- [x] `ops_health` WARN/PASS pre ENUM sending
- [x] Deploy `bad2398d`

## Validated

- `php tools/test_crontab_cli_ops.php` → 54+ PASS
- Live `crontab -l`: všetky SoT joby + polascin.net ops
- ENUM article/nl_sub obsahuje `sending`
- `ops_health.php --no-http` → RESULT PASS; newsletter ENUM sending ano/ano
- `DEPLOY_COMMIT=bad2398d`

## Remaining Work

- [ ] Legal notice claim/lease (port newsletter vzoru + ENUM) — samostatný beh
- [ ] Ďalší P1 podľa auditu
- [ ] Commit LF normalizácie v `crontab_lib` ak ešte nie je v HEAD

## Decisions Made

- Cron sync: áno (dôkaz driftu; rollback zo zálohy)
- Newsletter sending: áno (kód ready; prázdne pending)
- Legal sending: nie (chýba worker claim cesta)

## Critical Files

- tools/crontab_lib.php, render_crontab.php, verify_crontab_parity.php
- tools/crontab.example, ops_health.php
- state/DECISIONS.md
- add_newsletter_sending_status_migration.php

## Next Command

```text
# Ďalší P1 alebo legal claim/lease port.
# php tools/run_regressions.php
```
