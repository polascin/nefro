# SESSION

Aktualizované: 2026-11-05 20:20 Europe/Bratislava

## Aktívna úloha

Beh: Wintersova kompenzácia pCO₂ pri metabolickej acidóze. Handoff:
`.codex/handoffs/2026-11-05-202000-winters-compensation.md`.

## Stav repozitára

- Vetva: `main` (HEAD `e1606d38`)
- Runtime / `DEPLOY_COMMIT`: `e1606d38`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 163 + slučka tick 2: AG / Figge / ΔΔ
2. Slučka tick 3: a11y 35 PASS; Wintersova rovnica + test 31 PASS
3. Regresie 54 PASS; PHPStan 0

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-05-202000-winters-compensation.md`
