# DECISIONS

## 2026-11-01 — ops_health pásmo bez db_config include

`ops_health.php` má vlastné PDO a volá `opsHealthApplySessionTimezone()`.
`db_config.php` sa nenačítava, lebo pri chybe konfigurácie končí `exit(0)`, čo by
health-checku znemožnilo vrátiť FAIL (kód 1).

## 2026-11-01 — priority providerov v providers_common

Logika A/B/C je v `ppPriorityForProvider()` + `ppPriorityAssignmentRules()`.
Seed skript ostáva CLI/admin mutáciou; regresia je izolovaná bez DB.

## 2026-11-01 — Clarity do site_changelog, nie do newsletter fronty

User-facing zmena portálu musí mať záznam v `site_changelog.php`.
`enqueue_newsletter` / avíza sa neposielajú, pokiaľ to používateľ výslovne nepožiada.

## 2026-11-01 — state a handoffy mimo web rootu

Adresáre `.codex/` a `state/` patria do deploy-ignore (SFTP aj rsync zoznam),
aby agentné handoffy a session stav neboli vo verejnom web roote.
