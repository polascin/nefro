# SESSION

Aktualizované: 2026-11-03 10:28 Europe/Bratislava

## Aktívna úloha

Beh 153: referenčné testy CrCl 24 h, BSA a nátria. Handoff:
`.codex/handoffs/2026-11-03-102800-sodium-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `b3e0f4df`
- `origin/main` a `server/main`: `b3e0f4df` (dokumentačný commit po ňom sa nenasadzuje)

## Čo je hotové

1. Beh 150 až 153: skalárne vstupy, PHPStan 0, referenčné testy 8 kalkulačiek
2. Regresie 44 PASS

## Otvorené

- Rozhodnutie majiteľa: limity korekcie hyponatrémie (Beh 153)
- Referenčné testy: plasmic, kdpi a ďalšie

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-102800-sodium-clinical-refs.md`
