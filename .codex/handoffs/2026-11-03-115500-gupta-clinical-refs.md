# Handoff: gupta-clinical-refs

## Metadata

- Generated At: 2026-11-03T11:55:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: 6301a428
- Pripravené, nezlúčené: fix/adpkd-mayo-2026-11-03 (4dd8aebc), fix/gupta-mg-cutoff-2026-11-03 (93fcde65)

## Current State

Runtime `DEPLOY_COMMIT` = `6301a428`. Citácia Gupta opravená a nasadená.

## Remaining Work (súhlas majiteľa)

- [ ] Zlúčiť fix/adpkd-mayo-2026-11-03 (Beh 158) + site_changelog.php
- [ ] Zlúčiť fix/gupta-mg-cutoff-2026-11-03 (Beh 159) + site_changelog.php
      (vetva je postavená na 26c685ba; po zlúčení ADPKD skontrolovať konflikt v calculators_common.php a regressions.json)
- [ ] IgAN koeficienty / skrytie (Beh 158)
- [ ] Limity korekcie hyponatrémie (Beh 153); CRRT predilúcia a citácia (Beh 157)
- [ ] Ďalšie: kdpi, mgrs, mgus; plošná kontrola PMID odkazov na stránkach kalkulačiek

## Next Command

```text
php tools/run_regressions.php
```
