# SESSION

Aktualizované: 2026-11-05 19:22 Europe/Bratislava

## Aktívna úloha

Beh: referenčné testy MGRS + KDRI/OPTN. Handoff:
`.codex/handoffs/2026-11-05-192038-mgrs-kdpi-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (HEAD docs `d846c5aa`; nasaditeľný kód `a6c6b4b1`)
- Runtime / `DEPLOY_COMMIT`: `a6c6b4b1`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 162 + slučka 2026-11-05: clinical refs vrátane MGRS a KDRI
2. Regresie 53 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php ops_health.php --no-http
```

## Handoff

`.codex/handoffs/2026-11-05-192038-mgrs-kdpi-clinical-refs.md`
