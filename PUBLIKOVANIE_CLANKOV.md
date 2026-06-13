# Ako publikovať články

Na portáli sú **dve kategórie** článkov:

| Kategória | `category` | Kde sa zobrazí | Šablóna |
|-----------|-----------|----------------|---------|
| **Odborné** | `odborne` | Úvodná stránka ([index.php](index.php)) | `add_TEMPLATE_article.php` |
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

## Polia článku

| Pole | Význam | Pravidlá |
|------|--------|----------|
| `title` | Nadpis (`<h1>`) | Čistý text, bez HTML |
| `slug` | Časť URL | Len `a-z 0-9 -`, unikátny, diakritika → ASCII (á→a, č→c, š→s, ž→z, ľ→l) |
| `author` | Autor | Predvolene `MUDr. Ľubomír Polaščín` |
| `published_at` | Dátum/čas | Predvolene teraz; uprav ak treba |
| `is_top` | Odporúčaný | `0` bežný / `1` navrchu s odznakom |
| `excerpt` | Perex | 1–2 vety, čistý text, ~120–220 znakov |
| `content` | Telo (HTML) | Nezačínaj `<h2>` zhodným s titulom; nadpisy `<h2>/<h3>`, zoznamy `<ul>/<ol>`, odkazy `target="_blank" rel="noopener noreferrer"` |

> `INSERT IGNORE`: ak `slug` už existuje, článok sa **nevloží**. Na úpravu už
> publikovaného článku použi **Administrácia → Správa článkov**.

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
