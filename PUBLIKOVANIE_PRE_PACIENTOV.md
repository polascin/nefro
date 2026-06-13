# Ako publikovať články v sekcii „Pre pacientov“

Návod na pridávanie **popularizačných** článkov (sekcia [populars.php](populars.php),
v menu „Pre pacientov“). Tieto články sú písané jednoduchým jazykom pre poučených
pacientov a verejnosť, často s obrázkami.

> Odborné články (na úvodnej stránke) sa pridávajú rovnako, len cez šablónu
> `add_TEMPLATE_article.php` (kategória `odborne`). Tento návod je o **popularizačných**.

---

## Rýchly prehľad (TL;DR)

1. Skopíruj `add_TEMPLATE_popular_article.php` → `add_<slug>_article.php`
2. Obrázky daj do priečinka `img/`
3. Vyplň `title`, `slug`, `excerpt`, `content`
4. `git add` + `git commit` → súbory sa **automaticky nahrajú** na server
5. Spusti skript na serveri cez SSH (vloží článok do databázy)
6. Skontroluj článok na webe

---

## Krok 1 — Vytvor súbor článku

Skopíruj šablónu a premenuj ju podľa slugu článku:

```bash
cp add_TEMPLATE_popular_article.php add_co-su-oblicky_article.php
```

Konvencia názvu: `add_<slug>_article.php`, kde `<slug>` zodpovedá poľu `slug`.

## Krok 2 — Priprav obrázky

- Obrázky ulož do priečinka `img/` (napr. `img/oblicky-schema.png`).
- Použiteľné formáty: `.png`, `.jpg`, `.webp`.
- V obsahu na ne odkazuj relatívne: `src="img/oblicky-schema.png"`.
- **Prvý `<img>` v obsahu** sa automaticky použije ako náhľad (obrázok karty)
  v zozname sekcie — preto ho daj na začiatok.
- Vždy vyplň zmysluplný `alt` (prístupnosť + SEO).

Odporúčaný pomer náhľadu je cca **16:9**; karta obrázok automaticky oreže.

## Krok 3 — Vyplň polia v skripte

V skopírovanom súbore uprav pole `$articles[]`:

| Pole | Význam | Pravidlá |
|------|--------|----------|
| `title` | Nadpis (zobrazí sa ako `<h1>`) | Čistý text, bez HTML, zrozumiteľný laikovi |
| `slug` | Časť URL (`article.php?slug=…`) | Len `a-z 0-9 -`, max ~80 znakov, **unikátny**. Diakritika → ASCII (á→a, č→c, š→s, ž→z, ľ→l) |
| `author` | Autor | Predvolene `MUDr. Ľubomír Polaščín` |
| `published_at` | Dátum a čas | Predvolene `date('Y-m-d H:i:s')` (teraz); uprav ak treba |
| `is_top` | Odporúčaný | `0` = bežný, `1` = navrchu sekcie s odznakom „Odporúčané“ |
| `excerpt` | Perex na karte | 1–2 vety, čistý text, cca 120–220 znakov |
| `content` | Telo článku | HTML — pozri nižšie |

Pole `category` netreba nastavovať — šablóna ho má napevno na `'popularne'`.

### Pravidlá pre `content` (HTML)

- **Nezačínaj** `<h2>` zhodným s titulom (vznikol by duplikát — titul sa generuje sám).
- Obrázok:
  ```html
  <figure>
    <img src="img/subor.png" alt="Popis obrázka" loading="lazy" decoding="async">
    <figcaption>Popis pod obrázkom.</figcaption>
  </figure>
  ```
- Nadpisy sekcií → `<h2>`, podsekcie → `<h3>`.
- Zoznamy → `<ul>`/`<ol>` + `<li>`.
- Zvýraznenie → `<strong>` (tučné), `<em>` (kurzíva).
- Externé odkazy → `<a href="…" target="_blank" rel="noopener noreferrer">`.
- Záver / zdroj → `<hr>` + `<p><em><strong>Zdroj:</strong> …</em></p>`.

### Štýl jazyka (dôležité pre túto sekciu)

- Píš **jednoducho a priateľsky**, bez odborného žargónu.
- Skratky (CKD, eGFR, dialýza…) vždy aspoň raz vysvetli ľudskou rečou.
- Krátke vety, čitateľovi „vykaj“.
- Pridaj upozornenie, že obsah **nenahrádza** vyšetrenie u lekára.

## Krok 4 — Commit (automatický deploy)

```bash
git add add_co-su-oblicky_article.php img/oblicky-schema.png
git commit -m "content(pre-pacientov): <názov článku>"
```

Po commite sa zmenené súbory **automaticky nahrajú na produkciu** cez SFTP
(post-commit hook). Commitni aj obrázky, inak na serveri nebudú.

## Krok 5 — Spusti skript na serveri

Vloženie článku do databázy spustíš cez SSH:

```bash
ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
    uid58858@shell.r1.websupport.sk \
    "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_co-su-oblicky_article.php"
```

Výpis ukáže, koľko článkov sa vložilo / preskočilo (slug už existuje) a koľko
e-mailových avíz sa zaradilo do fronty pre odberateľov newslettera.

> Skript používa `INSERT IGNORE` — ak má článok rovnaký `slug` ako existujúci,
> **nevloží sa**. Pri oprave už vloženého článku zmeň obsah radšej cez
> **Administrácia → Správa článkov**.

## Krok 6 — Skontroluj výsledok

- Sekcia: <https://nefro.polascin.net/populars.php>
- Článok: `https://nefro.polascin.net/article.php?slug=<slug>`

Skontroluj náhľadový obrázok, perex, dátum a že odkaz „← Späť na články pre
pacientov“ funguje.

---

## Úprava alebo zmena kategórie existujúceho článku

Cez **Administrácia → Správa článkov**:

- Pole **Kategória** prepína *Odborný článok (Domov)* ↔ *Popularizačný – Pre pacientov*.
- Tu vieš upraviť aj titul, perex, obsah, dátum a stav „Zverejnený“.

Takto vieš napr. preklopiť existujúci odborný článok do sekcie pre pacientov
(alebo naopak) bez nového skriptu.

---

## Časté problémy

| Problém | Príčina / riešenie |
|---------|--------------------|
| Článok sa nevložil, „preskočený“ | Slug už existuje — zmeň `slug` alebo uprav článok v admine |
| Náhľad karty je prázdny (ikona 🩺) | V obsahu nie je `<img>`, alebo cesta k obrázku je zlá |
| Obrázok sa nezobrazuje | Súbor nie je commitnutý / chýba v `img/` na serveri |
| Článok sa zobrazuje na úvodnej stránke | Má `category = 'odborne'` — preklop na *Pre pacientov* v admine |
| `Unknown column 'category'` | Na novom prostredí spusti `add_category_migration.php` na serveri |

---

## Súvisiace súbory

- [add_TEMPLATE_popular_article.php](add_TEMPLATE_popular_article.php) — šablóna
- [populars.php](populars.php) — zoznam sekcie „Pre pacientov“
- [article.php](article.php) — zobrazenie jednotlivého článku
- [admin_articles.php](admin_articles.php) — správa a kategorizácia článkov
- [add_category_migration.php](add_category_migration.php) — migrácia stĺpca `category` (jednorazovo na nové prostredie)
