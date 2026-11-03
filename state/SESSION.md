# SESSION

Aktualizované: 2026-11-03 12:12 Europe/Bratislava

## Aktívna úloha

Beh 160: plošná kontrola PubMed odkazov, MGRS opravený. Handoff:
`.codex/handoffs/2026-11-03-121200-pubmed-link-sweep.md`.

## Stav repozitára

- Vetva: `main` (práca vo worktree `claude/loop-dev-audit-1ec33b`, merge `--no-ff`)
- Runtime / `DEPLOY_COMMIT`: `3d09b657`
- Pripravené, nezlúčené: `fix/adpkd-mayo-2026-11-03` (`01e6a45c`), `fix/gupta-mg-cutoff-2026-11-03` (`f10782b6`)

## Čo je hotové

1. Beh 150 až 160: skalárne vstupy, PHPStan 0, referenčné testy 16 kalkulačiek, 2 chybné PMID opravené
2. Regresie 50 PASS

## Otvorené (súhlas majiteľa)

- Zlúčenie ADPKD a Gupta Mg vetiev
- IgAN; limity korekcie nátria; CRRT predilúcia

## Executable next step

```text
php tools/check_calculator_pubmed.php
```

## Handoff

`.codex/handoffs/2026-11-03-121200-pubmed-link-sweep.md`
