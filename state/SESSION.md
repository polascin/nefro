# SESSION

Aktualizované: 2026-11-03 11:45 Europe/Bratislava

## Aktívna úloha

Beh 158: nálezy ADPKD (oprava pripravená, nezlúčená) a IgAN (bez zásahu). Handoff:
`.codex/handoffs/2026-11-03-114500-adpkd-igan-findings.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `bcffbf85`
- Pripravená, nezlúčená: `fix/adpkd-mayo-2026-11-03` (`4dd8aebc`)

## Čo je hotové

1. Beh 150 až 157: skalárne vstupy, PHPStan 0, referenčné testy 15 kalkulačiek
2. Beh 158: overenie ADPKD a IgAN v plných textoch

## Otvorené (súhlas majiteľa)

- Zlúčenie opravy ADPKD (Beh 158)
- IgAN koeficienty / skrytie (Beh 158)
- Limity korekcie hyponatrémie (Beh 153); CRRT predilúcia a citácia (Beh 157)

## Executable next step

```text
php tools/run_regressions.php
```

## Handoff

`.codex/handoffs/2026-11-03-114500-adpkd-igan-findings.md`
