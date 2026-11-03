# SESSION

Aktualizované: 2026-11-03 08:45 Europe/Bratislava

## Aktívna úloha

Beh 148: cron sync + newsletter ENUM sending (mandát RSI). Handoff:
`.codex/handoffs/2026-11-03-084500-cron-sync-sending-lease.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: `66f6b4e1` (docs Beh 148; runtime `bad2398d`)
- Runtime / `DEPLOY_COMMIT`: `bad2398d` (ignore drift: tools/docs/state)
- `origin/main` a `server/main`: aktuálne

## Čo je hotové

1. Rozhodnutia v `state/DECISIONS.md` (cron áno, newsletter sending áno, legal nie)
2. Produkčný crontab = SoT + polascin.net ops; záloha `crontab.nefro.bak.20261103T074351Z`
3. ENUM `sending` na article_newsletter_queue + nl_sub_queue
4. RSI: crontab_lib / render / verify; ops_health ENUM check; LF pin
5. `ops_health --no-http` PASS

## Otvorené

- Legal notice claim/lease (port newsletter vzoru)
- Ďalší P1 z auditu

## Executable next step

```text
# Legal claim/lease ALEBO iný P1; php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-084500-cron-sync-sending-lease.md`
