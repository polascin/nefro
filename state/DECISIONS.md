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

## 2026-11-01 (slučka 2) — deny add_provider* v htaccess

Priamy HTTP prístup k migráciám/seedom partner_providers je zakázaný
(`FilesMatch ^add_provider.*\.php$`). Preferovaná cesta je CLI cez SSH.
Admin HTTP vetva v PHP ostáva ako druhá vrstva pri zlomenej deny konfigurácii,
ale bežne ju Apache neprepustí.

## 2026-11-01 (slučka 2) — legal retry bez ENUM sending

`next_attempt_at` pri zlyhaní právneho oznámenia počíta databáza. Plný
claim/lease so stavom `sending` ostáva na samostatný beh so schválenou migráciou;
worker už má `GET_LOCK`, čo bráni súbehu dvoch procesov.

## 2026-11-01 (slučka 3) — a11y pred claim/lease

Bez súhlasu na ENUM `sending` sa robila prístupnosť: ARIA role na alertoch,
väzba chýb prihlásenia a layout 320 px. Claim/lease právnych front ostáva
blokované, kým používateľ výslovne neschváli migráciu.

## 2026-11-01 (slučka 4) — auth fokus + menu trap

Vzor z `login.php` rozšírený na register/forgot/reset/resend/2FA verify.
Mobilné menu pri Tab zostáva v cykle toggle ↔ položky; Escape vracia fokus
na tlačidlo. ENUM `sending` stále bez súhlasu.

## 2026-11-01 (slučka 5) — 2FA setup + confirm toggle

Dokončený auth fokus vzor na 2fa_setup a zrušenie účtu. Duplicitný
`data-toggle-btn` listener v 2fa_setup odstránený (kolízia s nefro-ui.js).
Confirm panely fokusujú heslo a synchronizujú `aria-expanded`.

## 2026-11-01 (slučka 6) — request_input bootstrap

Prvý konkrétny krok P1 oddelenia bootstrapov: izolovaný modul skalárnych
vstupov namiesto rozsypania auth.php. JSON preferencia cez
`requestInputResponseIsJson()` (CLI headers_list je nespoľahlivý). Claim/lease
a seed priorít ostávajú bez súhlasu.

## 2026-11-02 (slučka 7) — request_input rozšírenie

PreferPost pre token/slug; heslá bez `trim`. Plošné napojenie verejných
a auth endpointov; admin_providers GET filtre. P1 autori a claim/lease
ostávajú mimo rozsahu bez samostatného rozhodnutia.

## 2026-11-02 (slučka 8) — request_input v admin katalógoch

Admin drugs/trials/articles (+ discussion, newsletter) čítajú skaláre cez
`request_input`. Checkboxy ostávajú na `isset`, lebo absencia nie je
neplatný tvar. Claim/lease ENUM stále bez súhlasu.
