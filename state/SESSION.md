# SESSION

Aktualizované: 2026-11-03 11:14 Europe/Bratislava

## Aktívna úloha

Beh 156: referenčné testy Furstovho pomeru, FENa a FEurea. Handoff:
`.codex/handoffs/2026-11-03-111400-urine-indices-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `1a601bdc`
- `origin/main` a `server/main`: `1a601bdc` (dokumentačný commit po ňom sa nenasadzuje)

## Čo je hotové

1. Beh 150 až 156: skalárne vstupy, PHPStan 0, referenčné testy 14 kalkulačiek
2. Regresie 47 PASS

## Otvorené

- Rozhodnutie majiteľa: limity korekcie hyponatrémie (Beh 153)
- Referenčné testy: kdpi, igan, adpkd, crrt, gupta, mgrs, mgus

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-111400-urine-indices-clinical-refs.md`
