# SESSION

Aktualizované: 2026-11-03 12:42 Europe/Bratislava

## Aktívna úloha

Beh 162: referenčné testy MGUS. Handoff:
`.codex/handoffs/2026-11-03-124200-mgus-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `3c118c65`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03` (`01e6a45c`), `fix/gupta-mg-cutoff-2026-11-03` (`f10782b6`)

## Čo je hotové

1. Beh 150 až 162: skalárne vstupy, PHPStan 0, referenčné testy 17 kalkulačiek, citácie overené
2. Regresie 51 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-124200-mgus-clinical-refs.md`
