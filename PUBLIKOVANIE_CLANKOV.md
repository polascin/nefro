# Ako publikovať články

Na portáli sú **dve kategórie** článkov:

| Kategória                          | `category`  | Kde sa zobrazí                                        | Šablóna                            |
| ---------------------------------- | ----------- | ----------------------------------------------------- | ---------------------------------- |
| **Odborné**                        | `odborne`   | Úvodná stránka ([index.php](index.php))               | `add_TEMPLATE_article.php`         |
| **Pre pacientov** (populariza­čné) | `popularne` | Sekcia „Pre pacientov“ ([populars.php](populars.php)) | `add_TEMPLATE_popular_article.php` |

Oba typy zdieľajú rovnakú databázovú tabuľku `articles`, rovnaké zobrazenie cez
[article.php](article.php), newsletter, vyhľadávanie aj sitemap. Líšia sa len
poľom `category` a tým, kde sú vypísané.

---

## Postup (platí pre obe kategórie)

1. **Skopíruj šablónu** podľa typu článku → `add_<slug>_article.php`
   ```bash
   # odborný článok
   cp add_TEMPLATE_article.php add_<slug>_article.php
   # článok pre pacientov
   cp add_TEMPLATE_popular_article.php add_<slug>_article.php
   ```
2. **Obrázky** (ak nejaké sú) ulož do priečinka `img/`, odkazuj relatívne `src="img/…"`.
3. **Vyplň polia** `title`, `slug`, `excerpt`, `content` (a prípadne `is_top`, `published_at`).
4. **Commit** → súbory sa automaticky nahrajú na produkciu (post-commit SFTP hook):
   ```bash
   git add add_<slug>_article.php img/<obrazky>
   git commit -m "content(<sekcia>): <názov článku>"
   ```
5. **Spusti skript na serveri** cez SSH (vloží článok do databázy):
   ```bash
   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
       uid58858@shell.r1.websupport.sk \
       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
   ```
6. **Skontroluj** výsledok na webe.

---

## Pre AI agentov — presný recept

> Deterministický postup pre automatizované pridanie aj regeneráciu. Skript je
> **idempotentný UPSERT** — ten istý súbor sa používa na vloženie aj na úpravu.

### A) Pridať nový článok

1. **Vyber šablónu podľa kategórie** a skopíruj na `add_<slug>_article.php`:
   - odborný → `cp add_TEMPLATE_article.php add_<slug>_article.php`
   - pre pacientov → `cp add_TEMPLATE_popular_article.php add_<slug>_article.php`
     (kategória `popularne` je v popular šablóne napevno — needituj ju).
2. **Slug:** len `a-z 0-9 -`, diakritika → ASCII (`á→a č→c š→s ž→z ľ→l ý→y í→i …`).
   Názov súboru aj `slug` musia byť ASCII (SFTP deploy zlyhá na diakritike/medzerách).
3. **Vyplň** `title`, `slug`, `excerpt` (~120–220 znakov, čistý text), `content` (HTML),
   prípadne `is_top`, `published_at`. `author` ponechaj `MUDr. Ľubomír Polaščín`,
   ak nie je dôvod inak. Obrázky do `img/`, relatívne `src="img/…"`, `loading="lazy"`.
4. **Typografia (povinné):** slovenské úvodzovky `„…"`, pomlčka `–`, `≥`/`≤` namiesto
   `>=`/`<=`, jednotky `µl`/`mg/dl`. Žiadny inline `style="…"` (CSP `style-src 'self'`
   ho ticho zahodí — používaj triedy z `index.css`). `content` **nezačínaj `<h2>`**
   zhodným s titulom. Externé odkazy `target="_blank" rel="noopener noreferrer"`.
5. **Overenie pred commitom:** `php -l add_<slug>_article.php` a
   `php tools/phpstan.phar analyse add_<slug>_article.php --no-progress`
   (0 chýb nad baseline; v šablóne nechaj `?? '(bez titulu)'` — PHPStan ju neflaguje).
6. **Commit** (post-commit hook nahrá SFTP na produkciu):
   `git add add_<slug>_article.php img/… && git commit -m "content(<sekcia>): <titul>"`
7. **Spusti na serveri** cez SSH (vloží do DB + pošle newsletter avízo + vygeneruje PDF):
   ```bash
   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 uid58858@shell.r1.websupport.sk \
       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
   ```
   Očakávaný výstup: `1 vložených, 0 aktualizovaných … Zaradených do fronty avíz: N`.
8. **Sync PDF do gitu:** `sh sync_article_pdfs.sh` (stiahne PDF zo servera + commitne).
9. **Over live:** `curl -s "https://nefro.polascin.net/article.php?slug=<slug>"` —
   HTTP 200, žiadny `Fatal error`, jeden `<title>`, správna typografia.

> 👥 **Pôvodní autori zdroja (krok navyše, ak je článok spracovaním cudzieho
> zdroja).** Pole `author` je vždy len **autor projektu** (`MUDr. Ľubomír
> Polaščín`), takže pôvodní autori zdrojového článku sa k autorom **nepridajú
> sami**. Ak je článok slovenským spracovaním KONKRÉTNEHO zdrojového článku,
> doplň jeho autorov do **[source_authors.php](source_authors.php)** (mapa
> `slug => [mená]`) — je **autoritatívna** a zobrazí ich vo widgete „Zúčastnení
> autori" aj vo filtri `?autor=`. Mená získavaj len z **otvorených
> bibliografických API** (Crossref `filter=alternative-id:<PII>`, PubMed/eutils,
> DOI) alebo verejných tlačových správ — **nikdy obchádzaním paywallu**
> (Medscape a pod. doplní používateľ). Notácia „Meno Priezvisko" kvôli
> agregácii naprieč článkami. Bez mapy funguje len obmedzený fallback: prvý
> autor z presnej značky `Zdroj:` v obsahu (zoznam `Zdroje` sa neparsuje).
> Pôvodný (originálny) článok bez konkrétneho zdroja ostáva len pod autorom
> projektu — to je správne. **NEpridávaj autorov štúdií/odporúčaní len
> _citovaných_ v origináli** (napr. zoznam „Zdroje" pod pôvodným článkom) —
> mapa je len pre autorov skutočného spracovaného zdroja.

### B) Regenerovať / upraviť existujúci článok

1. **Uprav `content`/`excerpt`/`title`** priamo v jeho `add_<slug>_article.php`
   (alebo v šablóne, ak skript ešte neexistuje — vtedy ho najprv vytvor ako v A).
2. Kroky **5–6** ako vyššie (lint + commit/deploy).
3. **Spusti na serveri** ten istý skript (krok 7). UPSERT prepíše obsah; očakávaný
   výstup: `0 vložených, 1 aktualizovaných` a **`Zaradených do fronty avíz: 0`**
   (pri update sa newsletter zámerne neposiela). `updated_at` sa posunie.
4. **Sync PDF:** `sh sync_article_pdfs.sh` — `--stale` na serveri preregeneruje PDF
   (deteguje zmenu podľa `updated_at`), stiahne ho do `pdf/` a commitne.
5. **Over live** (krok 9).

> ⚠️ **Newsletter avíza** sa pošlú len pri **prvom** vložení článku (`rc === 1`).
> Pri regenerácii (`rc === 2`) sa neposielajú — netreba sa báť opätovného spustenia.

### C) Len preregenerovať PDF (bez zmeny obsahu)

Ak je obsah v DB správny, ale PDF chýba/je neaktuálne:

```bash
sh sync_article_pdfs.sh          # všetky chýbajúce + neaktuálne (--stale)
```

Alebo cielene na serveri: `php generate_all_article_pdfs.php --slug=<slug> --force`.

---

## Polia článku

| Pole           | Význam          | Pravidlá                                                                                                                         |
| -------------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| `title`        | Nadpis (`<h1>`) | Čistý text, bez HTML                                                                                                             |
| `slug`         | Časť URL        | Len `a-z 0-9 -`, unikátny, diakritika → ASCII (á→a, č→c, š→s, ž→z, ľ→l)                                                          |
| `author`       | Autor           | Predvolene `MUDr. Ľubomír Polaščín`                                                                                              |
| `published_at` | Dátum/čas       | Predvolene teraz; uprav ak treba                                                                                                 |
| `is_top`       | Odporúčaný      | `0` bežný / `1` navrchu s odznakom                                                                                               |
| `excerpt`      | Perex           | 1–2 vety, čistý text, ~120–220 znakov                                                                                            |
| `content`      | Telo (HTML)     | Nezačínaj `<h2>` zhodným s titulom; nadpisy `<h2>/<h3>`, zoznamy `<ul>/<ol>`, odkazy `target="_blank" rel="noopener noreferrer"` |

> **UPSERT (idempotentné):** šablóny používajú `INSERT … ON DUPLICATE KEY UPDATE`.
> Prvé spustenie článok **vloží** (a pošle newsletter avízo + vygeneruje PDF);
> opätovné spustenie po úprave obsahu článok **prepíše** (regenerácia obsahu aj
> PDF) a newsletter už **neposiela**. `published_at` ostáva zachované. Alternatíva
> bez skriptu: **Administrácia → Správa článkov**.

---

## PDF verzia článku (bonus na stiahnutie)

Pri spustení `add_<slug>_article.php` na serveri sa **automaticky vygeneruje PDF**
verzia článku z jeho obsahu (cez `wkhtmltopdf`), uloží sa do `pdf/<slug>.pdf` a priradí
k článku (`articles.pdf_file`). PDF je bonus na stiahnutie pre **prihlásených**
používateľov — servíruje [download_pdf.php](download_pdf.php); priečinok `/pdf` je inak
cez `.htaccess` blokovaný.

- Generovanie zabezpečuje [pdf_generator.php](pdf_generator.php) (`generateArticlePdf()`).
  Volá sa **automaticky**:
  - zo **šablón** po vložení nového článku,
  - z **Administrácia → Správa článkov** po vytvorení aj **úprave** článku
    (po audite, slovenskej korektúre/revízii… sa PDF preregeneruje),
- Vyžaduje `wkhtmltopdf` (na produkčnom serveri je k dispozícii). Ak chýba, uloženie
  článku prebehne normálne, len bez PDF.
- **Hromadné / stale dogenerovanie** na serveri:
  `php generate_all_article_pdfs.php` (chýbajúce), `--stale` (chýbajúce **aj
  neaktuálne** podľa `updated_at`), `--force` (všetky), `--slug=<slug>`, `--limit=N`.

### Zosúladenie PDF do gitu (po zmene obsahu)

PDF vznikajú na serveri. Po zmene obsahu (audit, korektúra, nový/upravený článok)
spusti z koreňa projektu:

```bash
sh sync_article_pdfs.sh
```

Skript na serveri preregeneruje neaktuálne PDF (`--stale`), stiahne ich do `pdf/`
a commitne zmeny (post-commit hook → push + deploy). Tým ostávajú PDF v gite
zosúladené s aktuálnym obsahom článkov.

---

## Rozdiely podľa kategórie

- **Odborné** (`add_TEMPLATE_article.php`) — odborný jazyk, určené lekárom; zobrazujú
  sa na úvodnej stránke.
- **Pre pacientov** (`add_TEMPLATE_popular_article.php`) — jednoduchý jazyk, obrázky,
  pre verejnosť. **Prvý `<img>` v obsahu** sa stane náhľadom karty.
  👉 Detailný návod: **[PUBLIKOVANIE_PRE_PACIENTOV.md](PUBLIKOVANIE_PRE_PACIENTOV.md)**.

## Zmena kategórie / úprava

Cez **Administrácia → Správa článkov** vieš pri každom článku prepnúť pole
**Kategória** (Odborný ↔ Pre pacientov) a upraviť titul, perex, obsah, dátum a
stav „Zverejnený“ — bez nového skriptu.

---

## Súvisiace súbory

- [add_TEMPLATE_article.php](add_TEMPLATE_article.php) — šablóna odborného článku
- [add_TEMPLATE_popular_article.php](add_TEMPLATE_popular_article.php) — šablóna článku pre pacientov
- [PUBLIKOVANIE_PRE_PACIENTOV.md](PUBLIKOVANIE_PRE_PACIENTOV.md) — detailný návod pre sekciu „Pre pacientov“
- [admin_articles.php](admin_articles.php) — správa a kategorizácia článkov
