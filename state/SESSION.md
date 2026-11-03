# SESSION

Aktualizované: 2026-11-03 09:40 Europe/Bratislava

## Aktívna úloha

Beh 150: skalárne superglobály + PHPStan 0. Handoff:
`.codex/handoffs/2026-11-03-094000-scalar-superglobals.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `effbd221`
- `origin/main` a `server/main`: `effbd221` (dokumentačný commit po ňom sa nenasadzuje)

## Čo je hotové

1. Žiadne priame `(string)`/`(int)`/`trim()` na `$_GET`/`$_POST` v koreňových `*.php` (regresia)
2. PHPStan 0 (crontab nástroje z Behu 148)
3. Regresie 41 PASS; request_input 130 PASS

## Otvorené

- Ďalší P1 z auditu (klinické referencie ďalších kalkulačiek, a11y úlohy)

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-094000-scalar-superglobals.md`
