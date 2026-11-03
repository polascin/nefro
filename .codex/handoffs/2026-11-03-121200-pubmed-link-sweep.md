# Handoff: pubmed-link-sweep

## Metadata

- Generated At: 2026-11-03T12:12:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: 3d09b657
- Pripravené, nezlúčené: fix/adpkd-mayo-2026-11-03 (01e6a45c), fix/gupta-mg-cutoff-2026-11-03 (f10782b6)

## Current State

Runtime `DEPLOY_COMMIT` = `3d09b657`. MGRS citácia opravená, kontrola PubMed odkazov v sade.

## Completed This Session

- [x] 12 PubMed odkazov overených, 1 chybný (MGRS) opravený
- [x] tools/check_calculator_pubmed.php + offline register v regresnej sade
- [x] Čakajúce vetvy zosúladené s main a zálohované

## Remaining Work

- [ ] SÚHLAS: zlúčiť ADPKD a Gupta Mg vetvy (+ site_changelog.php); obe sú zosúladené s main,
      pri zlúčení druhej vyriešiť konflikt v calculators_common.php / regressions.json / registri
- [ ] SÚHLAS: IgAN, limity korekcie nátria, CRRT predilúcia
- [ ] Citácie bez PubMed odkazu (text, DOI) na stránkach kalkulačiek: plošne overiť
- [ ] Referenčné testy: kdpi, mgrs, mgus

## Next Command

```text
php tools/check_calculator_pubmed.php
```
