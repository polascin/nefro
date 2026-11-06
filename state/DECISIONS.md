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

## 2026-11-03 (slučka 3) — clinical refs CKD-PC / CKM

Samostatný `tools/test_clinical_references_ckdpc_ckm.php` namiesto ďalšieho
balíka do PREVENT súboru. CKD-PC pinuje ckdpcrisk.org; CKM pinuje
`ckmComputeStage` + wiring BMI 23/25 a KF→very-high. Iba tools → SFTP
deploy marker sa nemení. Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 4) — admin scalar POST guards

`requestRequireScalarPost` na všetky súčasné admin mutácie bez `name="…[]"`
(grep 0 multi-selectov). Providers/notices/orders čítajú skaláre cez helpers.
Budúci multi-select nesmie dostať plošný guard. Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 5) — public/member form scalar guards

Diskusia, DSA `content_report`, verify_email, provider_namietka, newsletter
subscribe, logout + profile delete_account. `publikacia.php` ostáva na
`requestStringList` pre `formats[]`. Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 6) — register/2fa requestScalarString cleanup

Po `requestRequireScalarPost` (Beh 138) ešte ostávalo `trim($_POST)` v
`register.php` a TOTP tokoch. Heslá cez `requestScalarString(..., trim=false)`.
Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 7) — cookie banner a11y (Beh 109)

Zatvorený banner: HTML `hidden` + `aria-hidden` + `inert`, nie len CSS
`translateY`. Cron drift (crontab.example vs produkcia) zaznamenaný, sync
až so súhlasom. Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 8) — crontab.example + CLI deny regresia

`tools/test_crontab_cli_ops.php` pinuje povinné úlohy a OMITNUTÉ v
`crontab.example` plus `.htaccess` `<Files>` deny a CLI guard. Produkčný
crontab sa nemení (zákaz bez súhlasu). Claim/lease ENUM stále bez súhlasu.

## 2026-11-03 (slučka 10 / Beh 148) — mandát RSI: rozhodovať sám

Majiteľ zrušil „čakaj na súhlas“ pre cron sync a claim/lease. Agent rozhoduje
podľa dôkazov, rizík a prínosu; rozhodnutia zapisuje sem.

### Cron sync s tools/crontab.example — ÁNO

- **Pre:** produkčný `crontab -l` nemá provider_notice (bez --send),
  backup_snapshot, sync_drugs, sync_clinical_trials; newsletter_worker a
  legal_notice bežia `*/30` namiesto SoT (`* * * * *` / `17 * * * *`).
  História: worker mimo cronu = tiché nedoručenie avíz.
- **Proti / riziká:** hustší newsletter cron; nové sync joby zaťažia sieť
  raz týždenne; backup disk. Mitigácia: provider_notice bez `--send`;
  logy do `private/logs/`; záloha starého crontabu pred inštaláciou;
  zachovaný polascin.net ops blok.
- **Rollback:** `crontab` zo zálohy `crontab.nefro.bak.*`.

### Newsletter ENUM `sending` (claim/lease) — ÁNO teraz

- **Pre:** kód v `newsletter_notifications.php` už claim/lease podporuje
  s feature detection; produkčné ENUM je stále bez `sending` (legacy SMTP
  v transakcii = riziko duplicít pri páde); fronty bez `pending` (len
  sent/cancelled) → bezpečné okno migrácie.
- **Proti / riziká:** ALTER ENUM; zaseknuté `sending` pri páde (mitigácia:
  reclaim po NEWSLETTER_SENDING_LEASE_SECONDS).
- **Rollback:** ENUM sa bežne neskracuje; worker zvláda oba režimy. Pri
  incidente reclaim + log.

### Legal notice ENUM `sending` — NIE v tomto behu (148)

Legal worker nemá claim/lease cestu (iba GET_LOCK). Migrácia ENUM bez
kódu by nič nezmenila. Samostatný beh po portovaní newsletter vzoru.

### RSI v tomto behu

`tools/crontab_lib.php` + `render_crontab.php` + `verify_crontab_parity.php`;
ops_health WARN pri chýbajúcom ENUM sending; regresia pinuje schedule.

## 2026-11-03 (slučka 11 / Beh 149) — legal claim/lease port

### Legal notice ENUM `sending` + claim/lease — ÁNO

- **Pre:** rovnaké riziko duplicít ako pri newsletteri (SMTP mimo transakcie);
  newsletter vzor je overený; fronty bez pending; GET_LOCK nestačí pri páde
  po odoslaní pred update statusu.
- **Proti / riziká:** ALTER ENUM; stale `sending` (mitigácia reclaim 15 min).
- **Rollback:** worker má feature detection; bez ENUM ostáva legacy režim.
- **RSI:** reclaim pin v `test_legal_notifications.php`; ops_health pokrýva
  aj legal ENUM; migrácia `add_legal_sending_status_migration.php`.

## 2026-11-06 (slučka v) — KDIGO G4×A1 späť na veľmi vysoké

Beh 101 (0e71c47e) preradil G4×A1 na „vysoké“ s tvrdením „oranžová“. Heatmapa KDIGO
má celý riadok G4 červený; textový primárny zdroj je obrázok, preto overenie
aritmetikou z publikovanej kohorty (PMC13512940, Table 3). AHA CKM 2023 dáva G4 do
štádia 3 aj nezávisle. Rollback: revert merge `20a30272`.

## 2026-11-06 (slučka u) — ADPKD Mayo: klasifikácia podľa ročného % prírastku

Irazabal 2015 (PMC4279733, Methods): „yearly percentage increases of <1.5% (1A) …
>6% (1E)“ od teoretických 150 mL/m. Rovnica s počiatočným vekom nie je v texte
(Suppl.); ponechaný predpoklad celého veku, zhodný so zobrazeným %/rok. Zmena
dotkne len pacientov tesne nad hranicami (r ≥ prah, k < prah). Nová vetva nad main,
stará `fix/adpkd-mayo-2026-11-03` ponechaná. Rollback: revert merge `7ec81e1c`.

## 2026-11-06 (slučka t) — Gupta Mg: nová vetva namiesto rebase starej

Majiteľ obnovil /loop. Zdroj overený (Gupta 2024, PMC10964715, Methods:
„magnesium <0.82, ≥0.82 mmol/L“). Namiesto rebase `fix/gupta-mg-cutoff-2026-11-03`
(starý merge-base, vlastný faktor 2,4305) nová vetva nad main so spoločnými
`magnesium*` helpermi. Stará vetva ostáva, zmazanie len so súhlasom.
Rollback: revert merge `43858b6d`.

## 2026-11-06 (pauza / close-WIP) — ADPKD a Gupta merge: NIE teraz

Majiteľ požiadal dokončiť rozrobené a prechodne zastaviť doaudit + RSI slučky.
RSI mandát (Beh 148) umožňuje rozhodnúť; zlúčenie teraz **nie**.

- **Pre odklad:** vetvy `fix/adpkd-mayo-2026-11-03` a `fix/gupta-mg-cutoff-2026-11-03`
  majú starý merge-base (`3d09b657`); na `main` už žije `adpkdClassify` v common
  s golden pinom log-k. ADPKD vetva mení klasifikáciu na ročný % prírastok HtTKV
  (iná veličina na prahoch 0,015…); Gupta mení jednotku/hranicu Mg na &lt; 0,82 mmol/L.
  Merge bez rebase + nového pinu by rozbil aktuálne testy alebo ticho zmenil kliniku.
- **Proti odkladu:** obe vetvy vyzerajú ako korekcie podľa zdroja; ostávajú mimo produkcie.
- **Rozhodnutie:** BLOCKED do samostatného behu po zrušení PAUSE: najprv rebase na
  aktuálny `main`, potom pin, potom merge. Počas pauzy nespúšťať /loop ani doaudit.
- **Rollback:** netreba; produkcia ostáva na `f695d7aa` bez týchto zmien.

## 2026-11-06 (tick 33) — calculatorEkfcModeLabel do calculators_common

Lokálny `ekfcModeLabel` → `calculatorEkfcModeLabel` v `calculators_common.php`.
Len UI label režimu cr/cys/cr_cys; klinický výpočet EKFC sa nemení. Pin v
`tools/test_clinical_references.php`. Deploy dobehnutý manuálne (predchádzajúci
post-commit nechal produkciu na `28bcf11e`).

## 2026-11-06 (tick 32) — adpkdClassify do calculators_common

`adpkdClassify` (Mayo HtTKV, Irazabal 2015) ide do `calculators_common.php`
tesne pred `adpkdInterpretation`. Prahy k (0.015 / 0.03 / 0.045 / 0.06) a
výstupy tried sa nemenia; pin 7 scenárov + 4 hranice v
`tools/test_clinical_references.php`. Atypická trieda 2 ostáva v POST vetve
stránky. Meno bez prefixu `calculator*` (konzistentné s `adpkdInterpretation`).

## 2026-11-06 (tick 30) — iganRisk do calculators_common

`iganRisk` (Barbour 2019 klinický model) ide do `calculators_common.php`
vedľa `iganInterpretation`. Koeficienty sa nemenia; golden pin 8 scenárov
v `tools/test_clinical_references.php` chráni aktuálne správanie. Klinická
oprava koeficientov ostáva samostatný beh so súhlasom majiteľa.
