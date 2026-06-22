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

| NephroResource | Stav u nás |
|---|---|
| eGFR, KFRE, IgA risk, CKD risk (KDIGO G/A), Kt/V, frakčná exkrécia (FENa/FEUrea), acidobáza, deficit voľnej vody | ✅ **Máme** |
| Hyponatrémia, elektrolyty, prevodník jednotiek | 🟡 **Čiastočne** (máme `calculator_na.php`, `_ca`, `_acidbase`, `_uacr`; chýba riziko ODS, Katzova korekcia na glukózu a všeobecný prevodník jednotiek) |
| **CKD-EPI kreatinín–cystatín C (2021)** | ❌ Chýba — naša eGFR je len kreatinínová; KDIGO 2024 odporúča potvrdenie cystatínom C |
| **Mehran** / **Thakkar** (kontrastom indukované AKI) | ❌ Chýba — časté pred CT a koronarografiou |
| **CRRT dávkovanie** (efluentová dávka mL/kg/h) | ❌ Chýba — intenzívna starostlivosť |
| **24-h klírens kreatinínu** (meraný CrCl) | ❌ Chýba |
| **nPCR / PNA** (nutrícia pri dialýze) | ❌ Chýba — vhodne dopĺňa Kt/V |
| **Recirkulácia** cievneho prístupu | ❌ Chýba — dialýza |
| **Klírens voľnej vody** (bez elektrolytov) | ❌ Chýba |
| **Furstova rovnica** | ❌ Chýba — pokročilá CKD |
| **Gupta — cisplatinové AKI riziko** | ❌ Chýba — onkonefrológia |
| **MGRS**, **MGUS / ľahké reťazce** | ❌ Chýba — paraproteíny |
| **Staging CKM** (AHA) | ❌ Chýba ako kalkulačka (článok už máme) |
| **KDPI** (Kidney Donor Profile Index) | ❌ Chýba — transplantácia |

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

| Nástroj | Klinická funkcia |
|---|---|
| **Plánovač diéty** (Diet Builder) | Renálna diéta — sodík/draslík/fosfor/bielkoviny (pacientsky + edukačný) |
| **Hyponatrémia** | Interaktívny diagnostický algoritmus |
| **Hypokaliémia** | Diagnostický a manažmentový postup |
| **AKI** | Diferenciálny diagnostický sprievodca |
| **TLS** | Syndróm rozpadu nádoru (riziko a manažment) |
| **TMA** | Trombotická mikroangiopatia — diagnostický sprievodca |
| **Sprievodca GN** | Diferenciálna diagnostika glomerulonefritíd |

---

## 4. Cheat sheety — tlačiteľné referencie (chýbajú ako typ)

Máme príbuzný obsah (checklistové články „anémia CKD A4", infografiky) a silný
PDF pipeline (`wkhtmltopdf`, automatická regenerácia), no nemáme dedikované
jednostránkové tlačiteľné referencie.

| Cheat sheet | Obsah |
|---|---|
| **Infúzne roztoky** | Zloženie a výber roztokov |
| **Diuretiká** | Triedy, dávkovanie, ekvivalencie |
| **Elektrolyty** | Rýchla referencia porúch |
| **Acidobáza** | Rýchla referencia porúch |
| **Komplement** | Dráha komplementu a komplementom sprostredkované choroby |
| **Membranózna nefropatia** | Antigény / vyšetrenie / liečba |

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
  + detail štúdie. Slovenské popisy a kontext pri vybraných štúdiách.

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

**Fáza 3 — Interaktívne nástroje** (najväčší diferenciátor):
AKI · algoritmus hyponatrémie · hypokaliémia · plánovač diéty.

**Fáza 4 — Cheat sheety** (tlačiteľné, využijú PDF pipeline):
acidobáza · elektrolyty · diuretiká · infúzne roztoky (najprv tie, ku ktorým už
máme kalkulačky).

**Fáza 5 — Špecializované kalkulačky a nástroje:**
CRRT · recirkulácia · klírens voľnej vody · Furst · Gupta · MGRS · MGUS / ľahké
reťazce · staging CKM · KDPI · TLS · TMA · sprievodca GN · cheat sheety komplement
a membranózna nefropatia.

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
