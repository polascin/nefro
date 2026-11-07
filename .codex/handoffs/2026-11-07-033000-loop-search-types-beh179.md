# Handoff 2026-11-07 03:30: slučka ai (typy vyhľadávania a SMS) + Beh 179

## Stav
- Slučky ACTIVE (~20 min). main po merge `audit/beh-179-2026-11-07`; runtime `9c70b213`.
- ČAKÁ NA SÚHLAS: 8 odkazov v článkoch (Beh 173), prompt nočnej routine (Beh 177).

## Hotové
- search_helpers.php, mobile_verification.php docblocky; profile.php bez zbytočných ??/isset.
- PHPStan 5 = 0; PHPStan 6 = 145.

## Pasce
- Vyhľadávanie: GET parameter `s` (nie `q`); výsledky = `href="article.php?slug=` a `<mark class="search-hl">`.
- Tokeny vyhľadávania sú asociatívne (normalizovaný => pôvodný), nie list.
- Jednoriadkový docblock `/** text */` treba pri doplnení tagov prepísať na viacriadkový.

## Ďalší krok
PHPStan 6: newsletter_notifications.php (10), auth.php (8). Články/routine/IgAN/Na/CRRT len so súhlasom.
