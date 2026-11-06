# Handoff 2026-11-07 01:00: slučka ac (odkazy v článkoch) + Beh 173

## Stav
- Slučky ACTIVE (~20 min). main po merge `audit/beh-173-2026-11-07` (len docs + tools, bez deployu).
- ČAKÁ NA SÚHLAS: 8 mŕtvych odkazov v 7 článkoch, tabuľka náhrad v state/TODO.md.

## Hotové
- tools/check_external_links.sh: extrakcia URL (dekóduje &amp;), kontrola zo servera (xargs -P4),
  výstup private/link-check/<UTC>.tsv; riadok v AGENTS.md.
- Overené náhrady: LSMU, AUA 2025, ukkidney 2016 PDF, China Daily subdoména, 3× Wayback (FDA, SAMHSA).

## Pasce
- &amp; v zdrojoch → falošné 404; 000 z PC aj zo servera = NEOVERENÉ.
- Úprava add_*_article.php = UPSERT + PDF na produkcii pri merge do main → len so súhlasom.

## Ďalší krok
Po súhlase opraviť odkazy v článkoch; inak ďalšia technická kontrola.
