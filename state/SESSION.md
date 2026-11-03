# SESSION

Aktualizované: 2026-11-03 11:55 Europe/Bratislava

## Aktívna úloha

Beh 159: Gupta citácia (nasadené) a hranica horčíka (vetva). Handoff:
`.codex/handoffs/2026-11-03-115500-gupta-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `6301a428`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03` (`4dd8aebc`), `fix/gupta-mg-cutoff-2026-11-03` (`93fcde65`)

## Čo je hotové

1. Beh 150 až 159: skalárne vstupy, PHPStan 0, referenčné testy 16 kalkulačiek
2. Regresie 49 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN koeficienty / skrytie
- Limity korekcie hyponatrémie; CRRT predilúcia a citácia

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-115500-gupta-clinical-refs.md`
