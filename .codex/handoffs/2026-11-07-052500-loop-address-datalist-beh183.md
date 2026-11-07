# Handoff 2026-11-07 05:25: slučka am (datalisty adresy) + Beh 183

## Stav
- Slučky ACTIVE (~20 min). main po merge `audit/beh-183-2026-11-07`; runtime `ddccc9ba`.
- ČAKÁ NA SÚHLAS: 8 odkazov v článkoch (Beh 173), prompt nočnej routine (Beh 177).

## Hotové
- db_config.php: addressMunicipalityDatalistOptions(), addressDatalistOptions().
- register.php + profile_form_address.php ich používajú; register 1,5 MB → 517 kB.
- tools/test_address_datalist.php (13) v regressions.json.

## Pasce
- Odsadené PHP šablóny v cykloch nad tisíckami položiek nafukujú HTML (medzery), gzip to skryje.
- Python: "\n" v reťazci pre PHP píše skutočný nový riadok; kontrolovať Grep/Read, nie bash grep s \n.
- Test bez DB: funkciu z db_config.php vybrať zo zdroja (include otvára spojenie s DB).

## Ďalší krok
Zmerať HTML ostatných stránok zo sitemap; PHPStan 6 (64). Články/routine/IgAN/Na/CRRT len so súhlasom.
