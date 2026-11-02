# SESSION

Aktualizované: 2026-11-02 04:28 Europe/Bratislava

## Aktívna úloha

CI Regression gate opravená a overená. Handoff:
`.codex/handoffs/2026-11-02-041804-ci-regression-fix.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: `1ed7f45d` (fix CI .htaccess / PHPStan / restore)
- Runtime / `DEPLOY_COMMIT`: `1ed7f45d` (lokálny SFTP post-commit)
- `origin/main` a `server/main`: aktuálne
- GitHub Actions run 41382755429: **success** (Validate + Regression gate;
  Deploy production skipped — lokálny SFTP je primárny)

## Čo je hotové

1. `.dockerignore`: `!/.htaccess`
2. PHPStan: clinical G páry, author PDO, providers note
3. Restore fixture `request_input.php` + self_test `--no-verify`
4. Claim/lease ENUM **nebol**

## Executable next step

```text
# Voliteľne PREVENT clinical refs, alebo claim/lease IBA so súhlasom.
```

## Handoff

`.codex/handoffs/2026-11-02-041804-ci-regression-fix.md`
