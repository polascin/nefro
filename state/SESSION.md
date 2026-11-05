# SESSION

Aktualizované: 2026-11-05 20:00 Europe/Bratislava

## Aktívna úloha

Beh: referenčné testy aniónovej medzery (Figge, Δ/Δ). Handoff:
`.codex/handoffs/2026-11-05-200000-acidbase-clinical-refs.md`.

## Stav repozitára

- Vetva: `main` (HEAD `23b0ffe1`)
- Runtime / `DEPLOY_COMMIT`: `23b0ffe1`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03`, `fix/gupta-mg-cutoff-2026-11-03`

## Čo je hotové

1. Beh 150 až 163 + slučka tick 2: AG / Figge / ΔΔ
2. Regresie 54 PASS; acidbase ref 21 PASS; display 15 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php tools/test_a11y_form_alerts.php
```

## Handoff

`.codex/handoffs/2026-11-05-200000-acidbase-clinical-refs.md`
