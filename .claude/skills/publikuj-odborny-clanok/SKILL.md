---
name: publikuj-odborny-clanok
description: Zverejni nový odborný článok na nefro.polascin.net zavedeným overeným postupom — hĺbková vecná kontrola a overenie citácií, slovenská jazyková korektúra, ilustračný obrázok 16:10, commit/SFTP deploy, spustenie cez SSH, sync PDF a live kontrola. Použi, keď používateľ povie „pridaj/vlož/zverejni odborný článok", odovzdá predlohu článku na spracovanie, alebo žiada regeneráciu či opravu už publikovaného odborného článku.
---

# Publikovanie odborného článku (nefro.polascin.net)

Zavedený postup pre `category = 'odborne'`. Pre články v sekcii „Pre pacientov"
(`popularne`) platí [PUBLIKOVANIE_PRE_PACIENTOV.md](../../../PUBLIKOVANIE_PRE_PACIENTOV.md).

**Zásada:** každý článok dokonči úplne (vrátane PDF a live kontroly), až potom začni
ďalší. Pri zásahu do limitu tak ostanú hotové články celé.

---

## 0. Čo NErobiť

- **Nespúšťaj per-článok multi-agentové Workflow** na recenziu. Jeden taký beh zožral
  ~1,2 mil. tokenov a zasiahol session limit. Stačí priama expertná kontrola + cielené
  overenie najfalzifikovateľnejších tvrdení.
- **Nespúšťaj `sync_article_pdfs.sh` súbežne s inou prácou v repozitári** — sám robí
  `git add`/`commit`.
- **Nespúšťaj `pre-commit install`** — zruší `core.hooksPath`, čím vypne vodoznak aj deploy.
- **Nepoužívaj WSL** (primárny terminál je PowerShell; `trunk` len natívny).

---

## 1. Hĺbková vecná kontrola a overenie citácií

Predlohy od používateľa bývajú „audit", nie článok — meta-vrstvu („Fakty vs. interpretácie",
otázky adresované agentovi) prepíš na súvislú odbornú prózu.

**Vždy over celý autorský zoznam, DOI/PMID, ročník, číslo a strany.** V dávkach predlôh
mala chybu väčšina z nich.

Poradie nástrojov, ktoré funguje:

| Nástroj | Na čo |
|---|---|
| PubMed MCP `search_articles` / `get_article_metadata` | Úplné krstné mená, afiliácie, strany, abstrakt. Pri >2 PMID naraz môže výstup prekročiť limit → parsuj súbor. |
| `curl -s -H "Accept: application/json" https://api.crossref.org/works/<doi>` | Najrýchlejšie overenie úplného autorského zoznamu. DOI so zátvorkami v `for` cykle **uvádzaj v úvodzovkách**. |
| `curl .../eutils/efetch.fcgi?db=pubmed&id=<PMID>&rettype=abstract&retmode=xml` | Doslovné znenie štruktúrovaného abstraktu. |
| `api.openalex.org/works/doi:<DOI>` | Abstrakt aj pri closed-access prácach (`abstract_inverted_index`). |
| `WebFetch` na CDC/KDIGO/FDA accessdata | Primárne odporúčania a znenie SPC/labelu. |

`WebFetch` na `pubmed.ncbi.nlm.nih.gov` padá na reCAPTCHA. Medscape vracia 402 →
použi `curl -s -L` + strip HTML (prejde, vrátane bylinu a disclosures).
Na Windows nastav `export PYTHONIOENCODING=utf-8`.

### Typické chyby v predlohách — cielene ich hľadaj

- Vymyslené alebo zamenené krstné mená (najčastejšia chyba).
- Spolupracujúci skúšajúci (`Collaborators`) vydávaní za autorov.
- Nesprávny PMID vedúci na úplne inú prácu — kontroluj aj keď názov sedí.
- Citovaný DOI nie je práca, ktorá uvádza titulkové číslo.
- Tlačová správa firmy sa týka inej štúdie než predloha tvrdí.
- **Zbytočný hedging** — „nemožno overiť" o veciach, ktoré sú priamo v abstrakte.
  Najprv over, až potom hedguj. Redakčné poznámky typu „pred publikovaním doplň"
  nikdy nenechaj v tele článku.
- Predloha tvrdí, že dôkaz neexistuje, hoci existuje — prečítaj úvod a diskusiu primárnej práce.
- Predloha kritizuje metódu, ktorú autori správne použili.
- **Vecné chyby v samotnom zdroji** — ak ich nájdeš, oprav ich a rozdiel v článku vysvetli.

### Slovenská jazyková korektúra

- „dôkazový základ" / „dôkazová základňa", **nie** „evidenčný"; vyhýbaj sa kalkom z angličtiny.
- Konzistentná odborná terminológia naprieč celým článkom.
- Prechyľovanie priezvisk podľa pohlavia autora — over, nehádaj.

---

## 2. Ilustračný obrázok 16:10 (povinné)

1. Canva MCP `generate-image`, `aspect_ratio: LANDSCAPE_3_2` (enum pre 16:10 neexistuje).
   V prompte **vždy**: „no text, no letters, no words, no logos, no watermark, no faces".
   Jednotný vizuálny jazyk: tmavé takmer čierne pozadie, dramatické bočné svetlo,
   volumetrický opar, jeden farebný akcent podľa témy, polopriesvitná anatómia.
2. Canva design **`DAHWYJ0SGc0`**, strana s rozmermi **1600×1000** (napr. page_index 3,
   `PBSj9SXGdtl93QnB`). Postup:
   - `read-design` s `open_transaction: true` → vráti `transaction_id` a `locator_id`
     existujúceho full-bleed elementu. **Transakciu nemožno vymyslieť**, musí prísť odtiaľto.
   - `edit-design` s `finalize: keep_open` a operáciou `update_fill`
     (`locator_id`, `asset_type: image`, `asset_id`, `alt_text`).
   - `edit-design` s `finalize: commit` a bez operácií.
   - Transakcia vyprší po pár minútach; pri `transaction not found` otvor novú a zopakuj
     *všetky* zmeny — čiastočné úpravy sa zahodia.
3. `export-design`, `type: png`, `pages: [N]`, `width: 1600`, `height: 1000`,
   `export_quality: pro`. Priamy download z `media.canva.com` nefunguje (podpísaná URL).
4. `curl` → `img/<slug>.png`, over `getimagesize` = 1600×1000.
5. `php tools/watermark_images.php img/<slug>.png`
   a `php tools/convert_images_webp.php img/<slug>.png`.
6. Na začiatok `content`:
   ```html
   <figure><a href="img/<slug>.webp" rel="noopener noreferrer" target="_blank"><img src="img/<slug>.webp" alt="…" width="1600" height="1000" loading="lazy" decoding="async"></a><figcaption>…</figcaption></figure>
   ```
   Popisok **musí** uvádzať, že ide o ilustračnú/poloschematickú scénu, nie o snímku
   konkrétneho pacienta či výrobku.

`generate-image` po ~36 obrázkoch v krátkom slede vráti „Too many requests".

---

## 3. Vytvorenie skriptu

Skopíruj `add_TEMPLATE_article.php` → `add_<slug>_article.php`, alebo (rýchlejšie)
vezmi nedávny článok a nahraď hlavičku, `title`, `slug`, `excerpt`, `content`
a tag v `error_log`.

**Súbory `add_*_article.php` majú CRLF** — pri skriptovanej úprave zachovaj `\r\n`
(v Pythone `io.open(..., newline='')` a na záver `.replace('\n', '\r\n')`).

| Pole | Pravidlo |
|---|---|
| `title` | Čistý text, bez HTML |
| `slug` | Len `a-z 0-9 -`; diakritika → ASCII. **Názov súboru aj slug musia byť ASCII** — SFTP deploy zlyhá na diakritike/medzerách. |
| `author` | `MUDr. Ľubomír Polaščín` (autor projektu, vždy) |
| `excerpt` | ~120–220 znakov, čistý text |
| `content` | HTML; **nezačínaj `<h2>` zhodným s titulom** |
| `is_top` | `0` bežný / `1` navrchu s odznakom |

### Povinná typografia a prístupnosť

- Slovenské úvodzovky `„…"`, pomlčka `–`, `≥`/`≤` namiesto `>=`/`<=`, jednotky `µg`/`mg/dl`.
- **Žiadny inline `style="…"`** — CSP `style-src 'self'` ho ticho zahodí; používaj triedy z `index.css`.
- Externé odkazy `target="_blank" rel="noopener noreferrer"`.
- Každá `<table>` obalená v
  `<div class="table-responsive" role="region" aria-label="…" tabindex="0">`,
  `<th scope="col">` v `<thead>`, `<th scope="row">` v riadkových hlavičkách.

### Odporúčaná stavba článku

Figure → dek (2–3 odseky) → `<h2>` sekcie → `<h2>Limity</h2>` → `<hr>` + upozornenie
pre zdravotníckych pracovníkov → `<h2>Literatúra</h2>` s číslovanými zdrojmi →
`Poznámka k dôkazom` (čo bolo overené a ako, vlastný prínos priznaj) →
`<h3>Súvisiace články</h3>` s krížovými odkazmi (slugy si over v repozitári!).

### Autori zdroja

Ak je článok spracovaním **jedného konkrétneho** zdrojového článku, doplň jeho autorov
do [source_authors.php](../../../source_authors.php). Dopĺňaj ich **sám**, aj pri Medscape
(byline je na verejne prístupnej stránke). Do mapy patrí **len autor**, nie recenzent ani
redaktor. NEpridávaj autorov štúdií len *citovaných* v zdroji. Pôvodný článok bez
konkrétneho zdroja ostáva len pod autorom projektu.

---

## 4. Overenie pred commitom

```bash
php -l add_<slug>_article.php
php tools/phpstan.phar analyse add_<slug>_article.php --no-progress
```

PHPStan už pre nové články baseline **nevyžaduje** (šablóna sa zmenila). Baseline
negeneruj automaticky — pridaj ho len ak analýza skutočne niečo nahlási.

Rýchla kontrola obsahu:

```bash
f=add_<slug>_article.php
grep -n 'style="' $f                      # musí byť prázdne
grep -c '<table' $f; grep -c 'table-responsive' $f   # počty sa musia rovnať
grep -n 'target="_blank"' $f | grep -vc 'rel="noopener'   # musí byť 0
```

---

## 5. Commit → SFTP deploy

```bash
git add add_<slug>_article.php img/<slug>.png img/<slug>.webp tools/.watermark-manifest.json
git commit -m "content(odborne): <názov článku bez diakritiky>"
```

Post-commit hook pushne a nasadí cez SFTP. Ak článok mení **databázovú schému**,
commitni migráciu **zvlášť a PRED** kódom.

---

## 6. Spustenie na serveri

```bash
ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 -o StrictHostKeyChecking=accept-new \
    uid58858@shell.r1.websupport.sk \
    "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_<slug>_article.php"
```

Očakávaný výstup nového článku: `1 vložených, 0 aktualizovaných`,
`Zaradených do fronty avíz: N`.

**Newsletter avízo sa pošle len pri prvom vložení (`rc === 1`).** Re-run po úprave
obsahu dá `0 vložených, 1 aktualizovaných` a `Zaradených do fronty avíz: 0` — je bezpečný.
Pri **dávke** viacerých článkov naraz dostane každý odberateľ N e-mailov v tej istej
chvíli → over to s používateľom, prípadne `'enqueue_newsletter' => false`.

Pozor: úprava obsahu starších článkov so starou šablónou (`INSERT IGNORE`) nemusí
zabrať — vtedy updatuj DB priamo + zavolaj `generateArticlePdf`.

---

## 7. PDF a live kontrola

```bash
sh sync_article_pdfs.sh
```

Preregeneruje neaktuálne PDF na serveri (`--stale`), stiahne ich do `pdf/` a commitne.
Over, že PDF obsahuje ilustráciu:

```bash
php -r '$c=file_get_contents("pdf/<slug>.pdf"); echo preg_match_all("#/Image#",$c)."\n";'
```

`>= 3` = logo + vodoznak + ilustrácia. Menej než 100 kB = obrázok chýba.
Pri hromadnej regenerácii: stiahni PDF **bez commitu medzi regeneráciou a stiahnutím**,
inak deploy prepíše dobré serverové PDF starou verziou.

Live kontrola:

```bash
curl -s "https://nefro.polascin.net/article.php?slug=<slug>" -o /tmp/art.html -w "HTTP %{http_code}\n"
grep -c "<title>" /tmp/art.html        # 1
grep -ci "fatal error" /tmp/art.html   # 0
grep -o 'img/<slug>[^"]*' /tmp/art.html | head -1
```

⚠️ **Nepoužívaj `curl -A "Mozilla/5.0"`** — WAF hostingu tento skrátený UA vyhodnotí ako
skener a vráti HTTP 466. Predvolený `curl` UA aj úplný prehliadačový UA prechádzajú.
Hodnoť **telo odpovede**, nie len stavový kód. Limit `curl` je 20 požiadaviek/min
(`bot_trap.php` zabanuje aj agenta).

---

## Regenerácia existujúceho článku

Uprav `content`/`excerpt`/`title` v jeho `add_<slug>_article.php`, potom kroky 4 → 7.
UPSERT prepíše obsah, newsletter sa neposiela, `published_at` ostáva.

## Len preregenerovať PDF

```bash
sh sync_article_pdfs.sh      # všetky chýbajúce + neaktuálne
```
Cielene na serveri: `php generate_all_article_pdfs.php --slug=<slug> --force`.
