# SESSION

Aktualizované: 2026-11-05 20:40 Europe/Bratislava

## Aktívna úloha

Beh: očakávané pCO₂ pri metabolickej alkalóze. Handoff:
`.codex/handoffs/2026-11-05-204000-alkalosis-compensation.md`.

## Stav repozitára

- Vetva: `main` (HEAD `8d5793b8`)
- Runtime / `DEPLOY_COMMIT`: `8d5793b8`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 163 + slučka tick 2: AG / Figge / ΔΔ
2. Slučka tick 3: a11y 35 PASS; Wintersova rovnica + test 31 PASS
3. Slučka tick 4: regresie 54 PASS; alkalóza Javaheri + test 42 PASS
4. PHPStan 0

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php tools/phpstan.phar analyse --memory-limit=1G --no-progress
```

## Handoff

`.codex/handoffs/2026-11-05-204000-alkalosis-compensation.md`
