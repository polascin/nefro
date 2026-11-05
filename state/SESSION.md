# SESSION

Aktualizované: 2026-11-05 19:46 Europe/Bratislava

## Aktívna úloha

Beh: referenčné testy CKD-EPI 2021 kreatinín–cystatín C. Handoff:
`.codex/handoffs/2026-11-05-194517-egfr-cys-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (HEAD `fc543a83`)
- Runtime / `DEPLOY_COMMIT`: `fc543a83`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 162 + slučka 2026-11-05: MGRS, KDRI, Cr–Cys eGFR
2. Regresie 53 PASS; eGFR ref 27 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php tools/test_acidbase_display.php
```

## Handoff

`.codex/handoffs/2026-11-05-194517-egfr-cys-clinical-refs.md`
