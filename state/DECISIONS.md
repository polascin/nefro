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

## 2026-11-02 (slučka 9) — kalkulačky pred P1 autormi

Zvolené bezpečné rozšírenie `request_input` na POST skaláre kalkulačiek
(`calculatorPostString`/`Int`) namiesto P1 autorov, ktoré vyžadujú EXPLAIN
a meranie. Multi-select v ambulatory (`complications[]`, diagnózy) ostáva
zámerne mimo skalárnej vrstvy.

## 2026-11-02 (slučka 10) — P1 autori: meranie + cache indexu

Lokálne (492 publikovaných, 267 mapovaných v source_authors): EXPLAIN na
`is_published=1` ostáva type=ALL + filesort (selektivita indexu nízka — takmer
všetky riadky publikované). Index migráciu sme nerobili. Pred: filter autora
~811 ms s plným `content` (~7,6 MB). Po: hydratácia contentu len pre unmapped

- `author_index` v `project_stats` cache; teplý filter ~157 ms, parity 172 PASS.
  Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 11) — source_authors: len single-source overenia

Do mapy pribudlo 14 slugov s autormi z Crossref/PubMed, kde článok má
jednoznačný DOI alebo PMID primárneho zdroja. Vylúčené: chybné DOI
(eocr/gutmaxxing), sekundárne review (CANVAS, suchej váhy), ťaháky a
pacientské edukácie. Parita 172 PASS; claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 12) — source_authors: kurácia podľa zhody DOI↔téma

Automatický single-ID filter už neprinášal nové safe návrhy. Do mapy
pribudlo 16 slugov po manuálnej zhode Crossref titulu s témou článku
a kontrole, že DOI je v obsahu. Vylúčené: multi-štúdiové články
(sibeprenlimab×3), chybný CETP/torcetrapib DOI, fiber-only pri článku
o vláknine+pohybe, ťaháky. Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 13) — list helper + ďalší source_authors

`requestStringList` / `calculatorPostStringList` pre multi-select
(ambulatory diagnózy a complications[]): vnorené polia → HTTP 400,
skaláry a ploché zoznamy ostávajú platné. +10 source_authors (DOI↔téma,
≤40 autorov); vylúčené SHARP/CATALYST pre príliš dlhý zoznam autorov.
Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 14) — formats[] + ďalší source_authors

`publikacia.php` číta `formats[]` cez `requestStringList` (rovnaký vzor
ako ambulatory). +13 source_authors; vylúčené ERA registry (>40 autorov)
a ESsCD celiakia pri článku o NCWS. Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 15) — index request_input + ďalší source_authors

`index.php` číta `page`/`autor` cez `requestScalarInt`/`String` (pole → 400).
+12 source_authors; vylúčené >40 autorov, ADA SoC namiesto CONFIDENCE
pri finerenóne a TMAO/IBD mismatch. Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 16) — CSRF skalár + zvyšné DOI autori

`requestCsrfTokenFromPost()` v `request_input.php`; `auth.php` načítava
request_input a admin mutácie aj auth/admin formuláre čítajú CSRF cez helper
(pole → 400, bez trim). +4 source_authors; vylúčené Pielotax/Drucker mismatch
a agave syrup pri sladidlách. Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 17) — GET request_input + CKD-EPI referencie

`studia`/`objednavka`/`download_publication`/`calculator_result_print` čítajú
GET cez request_input. CKD-EPI 2021 extrahované do
`calculatorCkdEpi2021FromCreatinineMgDl()` + regresný referenčný test (začiatok
P1 klinických referencií). Claim/lease ENUM stále bez súhlasu.

## 2026-11-02 (slučka 18) — klinické referencie KFRE/EKFC/UACR/Mehran

Čisté EKFC funkcie do `calculator_ekfc_logic.php`; UACR A-kategórie a Mehran
body/kategórie do `calculators_common.php`. Nový
`tools/test_clinical_references.php` (56 assertov). Claim/lease ENUM stále
bez súhlasu.

## 2026-11-02 — CI: .htaccess v Docker allowliste

`tools/test_provider_script_deny.php` číta `.htaccess` a `robots.txt`.
Allowlist `.dockerignore` mal `robots.txt`, nie `.htaccess`, takže Regression
gate v Actions padala Fatalom. Oprava: `!/.htaccess`. Súvisiace: PHPStan
(float kľúče G máp → páry), restore fixture kopíruje aj `request_input.php`,
synthetic git commit v self_test používa `--no-verify`. Claim/lease ENUM nie.

## 2026-11-03 — requestRequireScalarPost test cez fixture

Beh 138 pridal `php -r` + `escapeshellarg` na overenie poľového POST. Na
Windowse to rozbije vnorené úvodzovky, regresná brána padá a SFTP deploy
nespustí (produkcia ostala na staršom SHA). Riešenie: temp fixture PHP súbor,
rovnako ako JSON/text reject. Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 2) — auth/newsletter scalar POST guard

`requestRequireScalarPost` na login, forgot/reset, resend, confirm deletion,
admin_reauth a newsletter verify/unsubscribe. Heslá cez
`requestScalarString(..., trim=false)`. Admin katalógy s multi-selectmi
nedostávajú plošný guard. Claim/lease ENUM stále bez súhlasu.
