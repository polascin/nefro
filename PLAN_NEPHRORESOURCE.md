# Plán rozvoja podľa NephroResource

Porovnanie portálu **nefro.polascin.net** s referenčným zdrojom
[NephroResource](https://nephroresource.com/) a implementačný plán doplnení.
Dôraz na **kalkulačky**, **interaktívne nástroje** a **cheat sheety**, doplnený
o **darovaciu stránku** (priorita) a o **databázu klinických štúdií a liekov**
(neskoršia fáza s pravidelnou aktualizáciou).

> Stav k 21. 6. 2026. Inventár NephroResource overený z jeho mapy stránok
> (`sitemap.xml`): 25 kalkulačiek, 7 interaktívnych nástrojov, 6 cheat sheetov.

---

## 0. Východiská

NephroResource je jednostránková aplikácia („Nephrology Clinical Tools for Kidney
Specialists") zameraná na klinické nástroje pre nefrológov. Náš portál má dnes
silnú **obsahovú** vrstvu (odborné články, PDF, infografiky, checklisty) a **15
klinických kalkulačiek**, no úplne mu chýba vrstva **interaktívnych nástrojov** a
**tlačiteľných cheat sheetov**.

**Naše prednosti, ktoré NephroResource nemá:** CKD-PC (Grams 2022), PREVENT
(AHA 2024), Mayo ADPKD klasifikácia, eGFR Slope, Cockcroft-Gault a samostatný
korigovaný vápnik. Porovnanie je teda obojstranné — cieľom nie je kopírovať, ale
doplniť zmysluplné chýbajúce nástroje a vlastnou implementáciou z primárnych
zdrojov ich prispôsobiť slovenskému kontextu.

---

## 1. Darovacia stránka — Podpora projektu (PRIORITA)

Inšpirácia: <https://nephroresource.com/donate>. Cieľom je umožniť **dobrovoľnú
podporu** nezávislého, bezplatného odborného portálu. Plne v súlade s našou
konverznou stratégiou — **žiadny paywall, obsah ostáva voľný**, podpora je čisto
dobrovoľná a neviaže sa na prístup k obsahu.

### Obsah a štruktúra stránky

- **Posolstvo (prečo):** portál je nezávislý a bezplatný; príspevky pokrývajú
  reálne náklady — hosting (WebSupport), doménové poplatky, generovanie PDF,
  nástroje a najmä čas venovaný tvorbe a aktualizácii odborného obsahu.
- **Transparentnosť:** stručný, úprimný rozpis, na čo prostriedky slúžia. Žiadne
  protislužby viazané na obsah.
- **Spôsoby podpory:**
  - **Bankový prevod** — IBAN + variabilný symbol.
  - **QR platba** — slovenský štandard **PAY by square** (rýchle skenovanie
    v bankových aplikáciách).
  - **Medzinárodne (voliteľne)** — Ko-fi / Buy Me a Coffee / PayPal pre
    zahraničných podporovateľov.
- **Poďakovanie:** krátke poďakovanie + jemná pripomienka možnosti odberu
  newslettera (oddeleného od účtu), nie agresívne CTA.

### Technická realizácia

- Nová stránka `podpora.php` (s prípadným aliasom `donate.php`).
- Zaradenie do pätičky (`footer.php`) a voliteľne do hlavnej navigácie
  (`main_nav.php`) ako nenápadná položka „Podporiť projekt".
- **Bez spracovania platobných údajov na serveri** — zobrazujeme IBAN + QR alebo
  odkazujeme na externé platobné brány. Znižuje to GDPR/PCI riziko a údržbu.
- Súlad s CSP (nonce pre prípadné skripty), schema.org a jednotným hlavičkovým
  metadátovým rámcom (`head_meta.php`).
- Jemné, neagresívne CTA „Podporte projekt" v pätičke (analogicky k newsletter
  CTA), bez vyskakovacích okien.

---

## 2. Kalkulačky — gap analýza a doplnenie

Dnešný stav: 15 kalkulačiek (`calculator_*.php`, register v `calculators.php`
a `calc_subnav.php`). Mapovanie voči 25 kalkulačkám NephroResource:

| NephroResource                                                                                                   | Stav u nás                                                                                                                                              |
| ---------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- |
| eGFR, KFRE, IgA risk, CKD risk (KDIGO G/A), Kt/V, frakčná exkrécia (FENa/FEUrea), acidobáza, deficit voľnej vody | ✅ **Máme**                                                                                                                                             |
| Hyponatrémia, elektrolyty, prevodník jednotiek                                                                   | 🟡 **Čiastočne** (máme `calculator_na.php`, `_ca`, `_acidbase`, `_uacr`; chýba riziko ODS, Katzova korekcia na glukózu a všeobecný prevodník jednotiek) |
| **CKD-EPI kreatinín–cystatín C (2021)**                                                                          | ❌ Chýba — naša eGFR je len kreatinínová; KDIGO 2024 odporúča potvrdenie cystatínom C                                                                   |
| **Mehran** / **Thakkar** (kontrastom indukované AKI)                                                             | ❌ Chýba — časté pred CT a koronarografiou                                                                                                              |
| **CRRT dávkovanie** (efluentová dávka mL/kg/h)                                                                   | ❌ Chýba — intenzívna starostlivosť                                                                                                                     |
| **24-h klírens kreatinínu** (meraný CrCl)                                                                        | ❌ Chýba                                                                                                                                                |
| **nPCR / PNA** (nutrícia pri dialýze)                                                                            | ❌ Chýba — vhodne dopĺňa Kt/V                                                                                                                           |
| **Recirkulácia** cievneho prístupu                                                                               | ❌ Chýba — dialýza                                                                                                                                      |
| **Klírens voľnej vody** (bez elektrolytov)                                                                       | ❌ Chýba                                                                                                                                                |
| **Furstov pomer** (U/S elektrolytový pomer)                                                                      | ❌ Chýba — predikcia reštrikcie tekutín pri hyponatriémii (nie „pokročilá CKD", ako sa pôvodne uvádzalo)                                                |
| **Gupta — cisplatinové AKI riziko**                                                                              | ❌ Chýba — onkonefrológia                                                                                                                               |
| **MGRS**, **MGUS / ľahké reťazce**                                                                               | ❌ Chýba — paraproteíny                                                                                                                                 |
| **Staging CKM** (AHA)                                                                                            | ❌ Chýba ako kalkulačka (článok už máme)                                                                                                                |
| **KDPI** (Kidney Donor Profile Index)                                                                            | ❌ Chýba — transplantácia                                                                                                                               |

### Prioritizácia kalkulačiek

**Vysoká priorita** (časté, vysoká klinická hodnota, dopĺňajú existujúce):
CKD-EPI kreatinín–cystatín C · Mehran (CI-AKI) · 24-h klírens kreatinínu · nPCR ·
všeobecný prevodník jednotiek · rozšírenie hyponatrémie o riziko ODS a Katzovu
korekciu na glukózu (v `calculator_na.php`).

**Stredná / špecializovaná priorita:**
CRRT · recirkulácia · klírens voľnej vody · Furstova rovnica · Gupta (cisplatina) ·
MGRS · MGUS / ľahké reťazce · staging CKM · KDPI.

---

## 3. Interaktívne nástroje — nová kategória (chýba celá)

Nemáme **žiadny** interaktívny krok-za-krokom nástroj (algoritmy máme len ako
statické články). Toto je **najväčší diferenciátor** — premena existujúcich
článkových algoritmov (IgA, anémia) na interaktívne rozhodovacie stromy.

| Nástroj                           | Klinická funkcia                                                        |
| --------------------------------- | ----------------------------------------------------------------------- |
| **Plánovač diéty** (Diet Builder) | Renálna diéta — sodík/draslík/fosfor/bielkoviny (pacientsky + edukačný) |
| **Hyponatrémia**                  | Interaktívny diagnostický algoritmus                                    |
| **Hypokaliémia**                  | Diagnostický a manažmentový postup                                      |
| **AKI**                           | Diferenciálny diagnostický sprievodca                                   |
| **TLS**                           | Syndróm rozpadu nádoru (riziko a manažment)                             |
| **TMA**                           | Trombotická mikroangiopatia — diagnostický sprievodca                   |
| **Sprievodca GN**                 | Diferenciálna diagnostika glomerulonefritíd                             |

---

## 4. Cheat sheety — tlačiteľné referencie (chýbajú ako typ)

Máme príbuzný obsah (checklistové články „anémia CKD A4", infografiky) a silný
PDF pipeline (`wkhtmltopdf`, automatická regenerácia), no nemáme dedikované
jednostránkové tlačiteľné referencie.

| Cheat sheet                | Obsah                                                    |
| -------------------------- | -------------------------------------------------------- |
| **Infúzne roztoky**        | Zloženie a výber roztokov                                |
| **Diuretiká**              | Triedy, dávkovanie, ekvivalencie                         |
| **Elektrolyty**            | Rýchla referencia porúch                                 |
| **Acidobáza**              | Rýchla referencia porúch                                 |
| **Komplement**             | Dráha komplementu a komplementom sprostredkované choroby |
| **Membranózna nefropatia** | Antigény / vyšetrenie / liečba                           |

---

## 5. Neskôr: Klinické štúdie a Databáza liekov

Inšpirácia: <https://nephroresource.com/trials> a
<https://nephroresource.com/database>. Obe sekcie majú byť **pravidelne
aktualizované** podľa rozsahu a kurácie na NephroResource, **ale dáta čerpáme
z primárnych autoritatívnych zdrojov** (nie kopírovaním cudzej databázy — pozri
časť 8 Právne poznámky).

### 5.1 Klinické štúdie (Clinical Trials)

- **Rozsah:** kurátorský výber nefrologicky relevantných intervenčných štúdií
  (CKD, dialýza, transplantácia, glomerulopatie, onkonefrológia).
- **Zdroj dát:** oficiálne API **ClinicalTrials.gov (v2)**; voliteľne register
  EU CTIS pre európske štúdie.
- **Aktualizácia:** pravidelný `cron` (napr. týždenne), ktorý obnoví stav štúdií
  (nábor / ukončené / výsledky) a sleduje rozsah tém podľa NephroResource.
- **Zobrazenie:** prehľadová stránka s filtrami (ochorenie, fáza, stav, lokalita)
  - detail štúdie. Slovenské popisy a kontext pri vybraných štúdiách.

### 5.2 Databáza liekov (Drug Database)

- **Rozsah:** lieky relevantné v nefrológii — úprava dávkovania podľa eGFR,
  nefrotoxicita, lieky pri dialýze, nefroprotektíva (SGLT2i, nsMRA, GLP-1 atď.).
- **Zdroj dát:** oficiálne registre a SPC — **ŠÚKL** (SK), **EMA**, prípadne
  štruktúrované zdroje (napr. ChEMBL pre mechanizmy a farmakológiu). Kľúčové
  klinické tvrdenia vždy s odkazom na primárny zdroj.
- **Aktualizácia:** pravidelná synchronizácia (`cron`) + ručná odborná kontrola
  pred zverejnením zmien (lieková bezpečnosť si vyžaduje kurátorský dohľad).
- **Zobrazenie:** karta lieku (dávkovanie podľa funkcie obličiek, dialyzovateľnosť,
  upozornenia), prepojenie na súvisiace články a kalkulačky (eGFR, Cockcroft-Gault).

---

## 6. Implementačný prístup (do existujúcej architektúry)

- **Kalkulačky:** replikovať vzor `calculator_X.php` + `calculators_common.php`
  (voliteľné údaje pacienta, ukladanie histórie pre prihlásených, tlačový layout,
  disclaimer cez `calculator_disclaimer.php`). Registrovať v `calculators.php`
  (karta + `schema hasPart`) a v `calc_subnav.php`. Vlastná implementácia
  z primárnych prác s citáciou zdrojov.
- **Interaktívne nástroje:** nová kategória — hub `nastroje.php` + jednotlivé
  `nastroj_*.php` s klientskou logikou rozhodovacieho stromu; nová položka
  v `main_nav.php` („Nástroje").
- **Cheat sheety:** najúspornejšie ako nová kategória v tabuľke `articles`
  (`category = 'cheatsheet'`) — znovupoužije `article.php` aj automatický PDF
  pipeline; hub stránka so zoznamom tlačiteľných referencií.
- **Štúdie a databáza liekov:** samostatné tabuľky + synchronizačné skripty
  spúšťané `cron`-om; rešpektovať poradie nasadenia pri zmene schémy (DB migráciu
  commitnúť zvlášť pred kódom).
- **Darovacia stránka:** statická `podpora.php` bez spracovania platieb na serveri.

---

## 7. Fázovanie a priority

**Fáza 1 — Darovacia stránka (priorita). ✅ HOTOVÉ.**
`podpora.php` (bankový prevod + PAY by square QR, Viamo, payme.sk, PayPal, Revolut,
Stripe/BLIK, Ko-fi, crypto Uphold) + odkaz v pätičke.

**Fáza 2 — Rýchle doplnenia kalkulačiek (dopĺňajú existujúce). ✅ HOTOVÉ.**
CKD-EPI kreatinín–cystatín C ✅ · Mehran (CI-AKI) ✅ · 24-h klírens kreatinínu ✅ ·
nPCR ✅ · všeobecný prevodník jednotiek ✅ · rozšírenie hyponatrémie (Katz/Hillier
korekcia Na + ODS strop) ✅.

**Fáza 3 — Interaktívne nástroje** (najväčší diferenciátor). ✅ HOTOVÉ.
Nová kategória „Nástroje": hub `nastroje.php` + položka v navigácii/pätičke +
zdieľaný znovupoužiteľný engine rozhodovacieho stromu (`NefroDecisionTree`
v `nastroj_engine.js`; jednotlivé nástroje sú už len dátové stromy `nastroj_*.js`,
bez inline štýlov, no-JS statická referencia).
AKI sprievodca ✅ (`nastroj_aki.php` — diferenciálna dg. podľa KDIGO) ·
algoritmus hyponatrémie ✅ (`nastroj_hyponatremia.php` — tonicita → závažnosť →
objem → U-Na/U-osm, SIADH, ODS limity) ·
hypokaliémia ✅ (`nastroj_hypokalemia.php` — závažnosť → presun → U-K → acidobáza →
TK → U-Cl; RTA, hyperaldosteronizmus, Bartter/Gitelman, dôraz na Mg) ·
plánovač diéty ✅ (`nastroj_dieta.php` — formulár hmotnosť+kategória → denné limity
bielkovín/energie/Na/K/P podľa KDOQI 2020; klientsky výpočet, nie rozhodovací strom).

**Fáza 4 — Cheat sheety („Ťaháky"). ✅ HOTOVÉ.**
Nová kategória `category = 'cheatsheet'` (znovupoužíva `article.php` aj PDF
pipeline) + hub `cheatsheets.php` („Ťaháky") + položka v navigácii/pätičke +
šablóna `add_TEMPLATE_cheatsheet_article.php`. Prvé štyri tlačiteľné ťaháky:
acidobáza ✅ (kompenzácia, AG, delta ratio) · elektrolyty ✅ (Na/K/Ca/Mg/P,
EKG, limity korekcie) · diuretiká ✅ (triedy, ekvivalencie, rezistencia) ·
infúzne roztoky ✅ (zloženie, tonicita, balansované vs. 0,9 % NaCl).
Pri vložení ťaháka sa NEodosiela newsletter avízo (referenčný, nie spravodajský
obsah); PDF na stiahnutie/tlač sa generuje automaticky.

**Fáza 5 — Špecializované kalkulačky a nástroje** (prebieha):
CRRT ✅ (`calculator_crrt.php` — efluentová dávka mL/kg/h, cieľ KDIGO 20–25, odhad
dodanej dávky pri výpadkoch) · klírens voľnej vody ✅ (`calculator_free_water.php` —
klasický CH₂O z osmolality + elektrolytový EFWC z Na/K) · recirkulácia cievneho
prístupu ✅ (`calculator_recirculation.php` — ureová trojvzorková metóda
R = (C_P−C_A)/(C_P−C_V)×100, hranica KDOQI 5–10 %) · Furstov pomer ✅
(`calculator_furst.php` — (U_Na+U_K)/S_Na predikuje účinnosť reštrikcie tekutín
pri hyponatriémii: <0,5 <1000 mL, 0,5–1,0 <500 mL, >1,0 neúčinná; Furst 2000) ·
MGUS / ľahké reťazce ✅ (`calculator_mgus.php` — Mayo riziková stratifikácia
Rajkumar 2005: M-proteín ≥15 g/L + non-IgG + abnormálny κ/λ → 20-ročné riziko
5/21/37/58 %; κ/λ pomer z voľných reťazcov; poznámka k MGRS a renálnemu rozpätiu FLC) ·
syndróm rozpadu nádoru ✅ (`calculator_tls.php` — Cairo–Bishop klasifikácia: laboratórny
TLS = ≥ 2 z kys. močová ≥ 476 µmol/L / K ≥ 6,0 / fosfát ≥ 1,45 dospelí–2,1 deti /
Ca ≤ 1,75 mmol/L; klinický TLS + kreatinín ≥ 1,5× ULN, arytmia alebo kŕče; absolútne
prahy, poznámka k Howard NEJM 2011) ·
PLASMIC skóre ✅ (`calculator_plasmic.php` — Bendapudi 2017: 7-zložkové skóre pravdepodobnosti
ťažkého deficitu ADAMTS13 / TTP pri trombotickej mikroangiopatii — trombocyty < 30, hemolýza,
bez nádoru, bez transplantácie, MCV < 90 fL, INR < 1,5, kreatinín < 176,8 µmol/L; 0–4 nízke,
5 stredné, 6–7 vysoké riziko; pomôcka pred testom ADAMTS13) ·
staging CKM ✅ (`calculator_ckm.php` — kardio-renálno-metabolický syndróm, AHA 2023 Ndumele:
hierarchické štádium 0–4 — adipozita → metabolické RF a/alebo CKD (stredné–vysoké) →
subklinické CVD / veľmi vysoké riziko CKD → klinické CVD (4a bez / 4b so zlyhaním obličiek);
riziko CKD podľa KDIGO, zlyhanie obličiek = veľmi vysoké riziko) ·
MGRS ✅ (`calculator_mgrs.php` — klasifikátor podľa konsenzu IKMG Leung 2019: hierarchicky
odlíši MGRS od MGUS a od hematologickej malignity vyžadujúcej liečbu; MGRS = dôkaz klonu
a zároveň renálne postihnutie pripísateľné paraproteínu bez kritérií malignity → renálna
biopsia, hematológ, klon-cielená liečba napriek nízkej náloži; biopsia s monoklonálnymi depozitmi
dokladá klon aj pri negatívnom sére/moči ~30 %) ·
**Gupta — odložené** (presné bodové hodnoty „simple risk score" sú v BMJ 2024 len ako
obrázok Fig 2, nedostupné v texte; sekundárne zdroje sa rozchádzajú — neimplementovať
bez overenej bodovej tabuľky) ·
KDRI/KDPI ✅ (`calculator_kdpi.php` — **bod 1**: exaktný KDRI (Rao 2009, fixné koeficienty,
10 darcovských faktorov, kreatinín stropovaný na 8 mg/dL) ako HR vs. referenčný darca;
KDPI percentil zámerne neuvádzaný — vyžaduje ročný škálovací faktor a mapovaciu tabuľku
OPTN — namiesto toho odkaz na oficiálnu OPTN kalkulačku) ·
sprievodca GN ✅ (`nastroj_gn.php` + `nastroj_gn.js` — interaktívny rozhodovací strom nad
`NefroDecisionTree`: nefritický vs nefrotický → tempo/RPGN (ANCA, anti-GBM, imunokomplexová)
→ komplement (postinfekčná, lupus, MPGN/C3G, kryoglobulinemická) / normálny komplement (IgA,
hereditárne) a nefrotická vetva (diabetická, MCD, membranózna/anti-PLA2R, FSGS, sekundárne
amyloid/paraproteín); no-JS statická referencia, prepojenie na IgAN/UACR/KFRE/MGRS/MGUS
kalkulačky; KDIGO 2024) ·
cheat sheety komplement a membranózna nefropatia.

**Fáza 6 — Klinické štúdie a databáza liekov** (s pravidelnou aktualizáciou):
najprv klinické štúdie (jednoduchší a bezpečnejší dátový tok cez ClinicalTrials.gov),
potom databáza liekov (vyžaduje kurátorský dohľad).

---

## 8. Právne a licenčné poznámky

- **Nepreberáme** obsah ani databázy NephroResource. Slúži ako referencia pre
  rozsah a kuráciu; vlastné implementácie staviame z primárnych zdrojov.
- Pri kalkulačkách citujeme **pôvodné práce** (autori, rok), nie sekundárne weby.
- Pri štúdiách a liekoch používame **oficiálne API a registre** (ClinicalTrials.gov,
  ŠÚKL, EMA) v súlade s ich licenčnými podmienkami a uvádzame zdroj a dátum
  poslednej aktualizácie.
- Lieková databáza si vyžaduje **odborný kurátorský dohľad** pred zverejnením
  zmien (bezpečnosť pacienta). Disclaimer ostáva pri všetkých klinických nástrojoch.

---

## Zdroje

- [Nephrology Calculators | NephroResource](https://nephroresource.com/calculators)
- [Interactive Tools | NephroResource](https://nephroresource.com/interactive-tools)
- [Cheat sheets | NephroResource](https://nephroresource.com/cheatsheets)
- [Clinical Trials | NephroResource](https://nephroresource.com/trials)
- [Drug Database | NephroResource](https://nephroresource.com/database)
- [Donate | NephroResource](https://nephroresource.com/donate)
