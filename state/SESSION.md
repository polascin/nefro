# SESSION

Aktualizované: 2026-11-07 01:00 Europe/Bratislava

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
- z (Beh 170): úplný head pre content_report (DSA) a admin_content_notices. Deploy `e544b159`.
- aa (Beh 171): JSON-LD WebApplication + MedicalWebPage pre 33 kalkulačiek. Deploy `a11ba838`.
- ab (Beh 172): externé odkazy (CYNMA bez odkazu, TNDTHD, APAR); admin/CSRF/cookie bez nálezu. Deploy `80d811e0`.
- ac (Beh 173): 1 015 odkazov v článkoch; 8 mŕtvych → návrh náhrad čaká na súhlas; nástroj tools/check_external_links.sh.

## Stav repozitára

- Nahradené, nezlúčené vetvy: `fix/gupta-mg-cutoff-2026-11-03`, `fix/adpkd-mayo-2026-11-03`
  (zmazanie len so súhlasom).
- PHPStan v `.claude/worktrees` nič neanalyzuje (excludePaths); spúšťať v dočasnom worktree.
- `D:\Dev\nefro` používajú aj iní agenti: merge do main iba s guardom
  `[ "$(git branch --show-current)" = main ]` v tom istom príkaze.

## Executable next step

ČAKÁ NA SÚHLAS: náhrady 8 mŕtvych odkazov v 7 článkoch (state/TODO.md). Po súhlase:
upraviť add_*_article.php, merge do main (post-merge UPSERT + PDF), overiť článok naživo.
Inak: IgAN/Na/CRRT tiež len so súhlasom; ďalšia technická kontrola podľa výberu.

## Handoff

`.codex/handoffs/2026-11-07-010000-loop-article-links-beh173.md`
