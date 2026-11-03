# Handoff: request-input-prevent-refs

## Metadata

- Generated At: 2026-11-03T04:58:30+01:00
- Project Root: D:\Dev\nefro
- Git Branch: main
- Head Commit: 84d61269

## Original Goal

Autonómna vývojová slučka 1: najvyšší dlh z auditu/session, jedna overiteľná
jednotka, commit + push + deploy, handoff + SESSION + .doaudit.

## Current State

Hotové. Produkcia `DEPLOY_COMMIT=84d61269` = HEAD = `origin/main` = `server/main`.
Predchádzajúci Beh 138 (`c0f033c7`) sa nenasadil: regresná brána na Windowse
padala na `tools/test_request_input.php` (`php -r` + `escapeshellarg`). Oprava
používa fixture súbor; zároveň profil má `requestRequireScalarPost` a clinical
refs obsahujú AHA PREVENT golden case.

## Completed This Session

- [x] Diagnostika zlyhania post-merge deployu Behu 138 (gate FAIL)
- [x] Fixture test pre `requestRequireScalarPost` (Windows-safe)
- [x] `profile.php`: skalárny guard + `requestScalarString` pre polia
- [x] PREVENT referencie v `tools/test_clinical_references.php` (80 PASS)
- [x] Regresie 38 PASS, PHPStan 0, encoding PASS
- [x] Deploy SFTP + smoke; claim/lease ENUM **nebol**

## Validated

- Command: `php tools/test_request_input.php` → 100 PASS
- Command: `php tools/test_clinical_references.php` → 80 PASS
- Command: `php tools/run_regressions.php` → 38 files PASS
- Command: `php tools/phpstan.phar analyse` → No errors
- Deploy: `DEPLOY_COMMIT` 84d61269; smoke `/`, `/privacy.php`, `/terms.php` 200
- Live: `/calculator_prevent.php` 200 + PREVENT title; `/AGENTS.md` 403; `/pdf/` 403

## Not Yet Validated

- Risk: plošný prepis zvyšných `trim($_POST)` (register po guarde, admin) ešte nie
- Risk: claim/lease ENUM stále bez súhlasu
- Assumption: ops_health lokálne WARN na `deploy_info`/retenčný log je očakávané
  (súbory len na serveri)

## Remaining Work

- [ ] Voliteľne `requestRequireScalarPost` na ďalšie auth/admin POST bez poľových polí
- [ ] Claim/lease ENUM `sending` **iba so súhlasom**
- [ ] Voliteľne ďalšie clinical refs (CKD-PC / CKM) ako samostatný súbor

## Decisions Made

- Decision: Opraviť test cez temp fixture, nie vypnúť kontrolu ani meniť `escapeshellarg`
- Reason: Rovnaký spoľahlivý vzor ako JSON/text reject fixture v tom istom teste
- Decision: Claim/lease nerobiť
- Reason: Stojaci zákaz bez výslovného súhlasu

## Blockers / Open Questions

- Žiadne blokery pre túto slučku. Claim/lease len so súhlasom.

## Critical Files

- tools/test_request_input.php
- profile.php
- tools/test_clinical_references.php
- prevent_model.php
- request_input.php

## Recent Commits

- 84d61269 fix(auth): Windows fixture pre requestRequireScalarPost a PREVENT referencie
- c0f033c7 audit: Beh 138 - POST s poľovým parametrom na register/2FA vracia 400 namiesto TypeError (#95)

## Modified Files

- (committed) profile.php, tools/test_request_input.php, tools/test_clinical_references.php
- docs/state/audit po dokončení handoffu

## Context To Load

- AGENTS.md
- state/SESSION.md
- state/TODO.md
- state/DECISIONS.md
- .codex/handoffs/2026-11-03-045740-request-input-prevent-refs.md

## Next Command

```text
# Voliteľne: requestRequireScalarPost na forgot/reset/login honeypot, ALEBO
# claim/lease IBA so súhlasom. Over: php tools/run_regressions.php
```
