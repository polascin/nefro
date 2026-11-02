# Handoff: CI regression fix

## Metadata

- Generated At: 2026-11-02T04:18:04+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 1ed7f45d

## Original Goal

Opraviť zlyhanie GitHub Actions „Deploy to nefro.polascin.net“: job
`regressions / Regression gate` FAILED; Deploy production Skippped.
Claim/lease ENUM nerobiť. Newsletter/sociálne siete nie.

## Current State

CI padalo na `tools/test_provider_script_deny.php`, lebo `.dockerignore`
allowlist neobsahoval `.htaccess`. Po oprave vyšli ďalšie skryté chyby
(PHPStan float kľúče v clinical refs, restore fixture bez `request_input.php`,
lokálny ggshield hook pri synthetic git commit). Celý
`bash tools/integration/run.sh` lokálne PASS.

## Completed This Session

- [x] Diagnostika `gh run` 41380487965: Fatal `.htaccess` missing v Dockeri
- [x] `!/.htaccess` v `.dockerignore`
- [x] PHPStan: G kategórie ako páry; isset note; PDO guard bez `@var`
- [x] Restore: `request_input.php` do `probe_fixture.php`; `--no-verify` v self_test
- [x] Lokálne: regressions 38 PASS, PHPStan OK, integration run.sh PASS
- [x] Claim/lease ENUM **nebol**

## Validated

- Command: `php tools/run_regressions.php` → 38 files PASS
- Command: `php tools/phpstan.phar analyse` → No errors
- Command: `bash tools/integration/run.sh` → exit 0, Restore self-test PASS

## Not Yet Validated

- Risk: Actions Deploy production ostáva skipped, kým `NEFRO_DEPLOY_MODE != actions` (lokálny SFTP hook je primárny)

## Remaining Work

- [x] CI success run 41382755429 (Validate + Regression gate)
- [ ] Voliteľne PREVENT clinical refs / claim/lease len so súhlasom

## Decisions Made

- Decision: Pridať `.htaccess` do Docker allowlistu (nie vypnúť test)
- Reason: Test je statická kontrola deny pravidiel; súbor musí byť v obraze
- Decision: Claim/lease ENUM nerobiť
- Reason: Stojaci zákaz v úlohe

## Blockers / Open Questions

- Žiadne pre CI fix. Claim/lease len so súhlasom.

## Critical Files

- .dockerignore
- tools/test_clinical_references.php
- tools/test_author_identity_parity.php
- add_providers_evuc_bratislava.php
- tools/restore/probe_fixture.php
- tools/restore/self_test.py

## Recent Commits

- f7ba3d55 docs(state): SHA deploy vs HEAD po handoffe slucky 18
- c3eb71e9 docs(state): handoff a session po dev-loop 18
- 2a5164ea feat(kalkulacky): spolocne vzorce EKFC/UACR/Mehran a klinicke referencie

## Modified Files

- .dockerignore, clinical/author/provider PHPStan fixes, restore fixture/self_test

## Context To Load

- AGENTS.md
- state/SESSION.md
- .codex/handoffs/2026-11-02-041804-ci-regression-fix.md

## Next Command

```text
# Over CI: gh run list -R polascin/nefro --workflow "Deploy to nefro.polascin.net" --limit 3
```
