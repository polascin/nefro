# Handoff: adpkd-igan-findings

## Metadata

- Generated At: 2026-11-03T11:45:00+01:00
- Project Root: D:\Dev\nefro (worktree .claude/worktrees/loop-dev-audit-1ec33b)
- Git Branch: claude/loop-dev-audit-1ec33b (main = 131f0890 + tento zápis)
- Pripravená vetva: fix/adpkd-mayo-2026-11-03 (4dd8aebc), NEZLÚČENÁ

## Original Goal

Slučka 20 (/loop): P1 klinické referenčné testy, ADPKD, IgAN, Gupta.

## Current State

Runtime bez zmeny (`bcffbf85`). Dva klinické nálezy čakajú na majiteľa.

## Completed This Session

- [x] ADPKD: overené v PMC4279733; oprava hraníc tried a citácie na vetve, test 43 PASS
- [x] IgAN: overené v PMC6583088; implementácia nezodpovedá opísanému modelu (zapísané)

## Remaining Work

- [ ] SÚHLAS: zlúčiť `fix/adpkd-mayo-2026-11-03` do main (+ site_changelog.php s časom nasadenia)
- [ ] SÚHLAS: IgAN, overiť koeficienty v eTable 2, alebo kalkulačku skryť/nahradiť
- [ ] SÚHLAS (Beh 153, 157): limity korekcie hyponatrémie; CRRT predilúcia a citácia
- [ ] Ďalšie: gupta, kdpi, mgrs, mgus

## Next Command

```text
git -C D:/Dev/nefro merge --no-ff fix/adpkd-mayo-2026-11-03   # iba po súhlase
```
