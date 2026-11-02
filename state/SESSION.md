# SESSION

Aktualizované: 2026-11-02 04:18 Europe/Bratislava

## Aktívna úloha

Oprava CI Regression gate (Deploy to nefro.polascin.net). Handoff:
`.codex/handoffs/2026-11-02-041804-ci-regression-fix.md`.

## Stav repozitára

- Vetva: `main`
- HEAD: CI fix commit (po pushi)
- Predchádzajúci runtime / `DEPLOY_COMMIT`: `2a5164ea` (docs-only drift OK do opravy)
- Lokálne: `run_regressions` 38 PASS, PHPStan OK, `tools/integration/run.sh` PASS

## Čo je hotové

1. `.dockerignore`: `!/.htaccess` (provider deny test v Dockeri).
2. PHPStan: clinical G páry, author PDO guard, providers note isset.
3. Restore fixture + self_test `--no-verify` (request_input, ggshield).
4. Claim/lease ENUM **nebol**.

## Executable next step

```text
# Po pushi over gh run success; potom voliteľne PREVENT clinical refs.
```

## Handoff

`.codex/handoffs/2026-11-02-041804-ci-regression-fix.md`
