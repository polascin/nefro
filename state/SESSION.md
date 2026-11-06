# SESSION

Aktualizované: 2026-11-06 22:30 Europe/Bratislava

## Slučky: ACTIVE

Majiteľ 6. 11. popoludní obnovil /loop (vývoj, opravy, optimalizácia; po každej slučke
handoff + `.doaudit.md`). Tempo: ScheduleWakeup ~20 min.

## Posledné slučky

- t (Beh 164): Gupta Mg < 0,82 mmol/L; PHPStan 2 → 0. Deploy `43858b6d`, `5e38079a`.
- u (Beh 165): ADPKD Mayo podľa ročného % prírastku r; citácia Irazabal. Deploy `7ec81e1c`.
- v (Beh 166): KDIGO heatmapa G4×A1 = veľmi vysoké (oprava Behu 101). Deploy `20a30272`.
- w (Beh 167): CKM 3 pri G4 bez uACR; popis štádia 3. Deploy `2e1941d9`.
- x (Beh 168): datalist autorov len na indexe (404 254 → 42 kB). Deploy `52aa602a`.
- y (Beh 169): deny pre 2 include-only knižnice + všeobecná regresia. Deploy `8cf39b0c`.

## Stav repozitára

- Nahradené, nezlúčené vetvy: `fix/gupta-mg-cutoff-2026-11-03`, `fix/adpkd-mayo-2026-11-03`
  (zmazanie len so súhlasom).
- PHPStan v `.claude/worktrees` nič neanalyzuje (excludePaths); spúšťať v dočasnom worktree.
- `D:\Dev\nefro` používajú aj iní agenti: merge do main iba s guardom
  `[ "$(git branch --show-current)" = main ]` v tom istom príkaze.

## Executable next step

Klinické zmeny IgAN/Na/CRRT čakajú na súhlas. Ďalej: robots.txt Disallow vs deny
zoznam, SEO metadáta kalkulačiek (description, canonical), alebo kalkulačky bez golden pinu.

## Handoff

`.codex/handoffs/2026-11-06-223000-loop-deny-beh169.md`
