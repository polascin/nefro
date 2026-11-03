# Handoff: mgus-clinical-refs

## Metadata

- Generated At: 2026-11-03T12:42:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: main (merge z claude/loop-dev-audit-1ec33b)
- Head Commit: 3c118c65
- Pripravené, nezlúčené: fix/adpkd-mayo-2026-11-03 (01e6a45c), fix/gupta-mg-cutoff-2026-11-03 (f10782b6)

## Current State

Runtime `DEPLOY_COMMIT` = `3c118c65`. MGUS má referenčný test.

## Remaining Work

- [ ] SÚHLAS: zlúčiť ADPKD a Gupta Mg vetvy (najprv do nich zlúčiť main: konflikty v registri a regressions.json)
- [ ] SÚHLAS: IgAN; limity korekcie nátria; CRRT predilúcia
- [ ] Referenčné testy: mgrs (checklist), kdpi (KDRI tabuľky OPTN, overiť zdroj)

## Next Command

```text
php tools/run_regressions.php
```
