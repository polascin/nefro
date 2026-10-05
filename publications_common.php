<?php

declare(strict_types=1);
/**
 * publications_common.php
 * ────────────────────────────────────────────────────────────────────────────
 * Spoločná vrstva pre predaj publikácií (e-knihy):
 *   • katalóg publikácií a ich formátov (zdroj pravdy je tento súbor),
 *   • cenník a výpočet ceny podľa vybraných formátov,
 *   • životný cyklus objednávky v tabuľke `publication_orders`,
 *   • e-maily kupujúcemu (platobné pokyny, sprístupnenie) a interné avízo.
 *
 * Súbory publikácií zámerne NIE SÚ vo web roote ani v gite — ležia
 * v `private/publications/<slug>/`, ktorý .htaccess blokuje (`RewriteRule
 * ^private`) a .gitignore vynecháva (120 MB binárok nepatrí do repozitára).
 * Jediná cesta k nim vedie cez `download_publication.php`, ktorý overí
 * zaplatenú objednávku. Na server sa nahrávajú ručne cez SFTP/SSH.
 *
 * Platí sa bankovým prevodom na účet predávajúceho — na stránke sa
 * nespracúvajú žiadne platobné údaje. Platbu páruje predávajúci podľa
 * variabilného symbolu a potvrdí ju v `admin_publication_orders.php`.
 * ────────────────────────────────────────────────────────────────────────────
 */

require_once __DIR__ . '/email_verification.php';

/** Cena jedného formátu v EUR. */
const PUBLICATION_PRICE_SINGLE = 7.00;
/** Cena balíka všetkých formátov v EUR (platí už pri dvoch a viac formátoch). */
const PUBLICATION_PRICE_BUNDLE = 12.00;

/** Koľko dní má kupujúci na úhradu, než objednávka exspiruje. */
const PUBLICATION_PAYMENT_DAYS = 14;
/** Koľko dní je prístup na stiahnutie platný od potvrdenia platby. */
const PUBLICATION_ACCESS_DAYS = 730;
/** Strop počtu stiahnutí na objednávku (bežný nákup zmestí do jednotiek). */
const PUBLICATION_DOWNLOAD_MAX = 40;

/**
 * Adresa, z ktorej sa posiela e-mail s publikáciou v prílohe. Odlišuje sa od
 * technickej adresy v SMTP_FROM_EMAIL (overenia, resety hesla) — dodanie
 * zakúpenej publikácie má prísť z verejnej kontaktnej adresy predávajúceho.
 */
const PUBLICATION_DELIVERY_FROM_EMAIL = 'nefro@polascin.net';

/**
 * Strop na prílohy jednej správy, keď server neohlási vlastný limit (SIZE).
 * 20 MB je bežná hodnota u poštových schránok; väčší súbor sa pošle odkazom.
 */
const PUBLICATION_ATTACHMENT_FALLBACK_LIMIT = 20971520;

/** Adresár so súbormi publikácií — mimo web rootu. */
const PUBLICATION_FILES_DIR = __DIR__ . '/private/publications';

/**
 * Verzia a účinnosť obchodných podmienok predaja. Žijú tu, nie
 * v obchodne-podmienky.php, pretože verziu treba zapísať ku každej objednávke
 * (`consent_terms_version`) — aby bolo pri spore zrejmé, aké znenie kupujúci
 * potvrdil. Pri zmene podmienok zvýš verziu a dátum spolu.
 */
const PUBLICATION_TERMS_VERSION = '1.1';
const PUBLICATION_TERMS_EFFECTIVE_DATE = '2026-10-03';

/* ── Retencia údajov objednávok ───────────────────────────────────────────
 * Zámerne rôzne doby pre rôzne polia — jednotných „10 rokov“ by bolo
 * nadbytočné spracúvanie pre všetko okrem účtovného dokladu.
 * Vynucuje ich `archive_cleanup.php` (cron), nie len text v zásadách.
 * ──────────────────────────────────────────────────────────────────────── */

/** Účtovný doklad: 10 rokov (§ 35 ods. 3 zákona č. 431/2002 Z. z. o účtovníctve). */
const PUBLICATION_RETENTION_ACCOUNTING_DAYS = 3653;
/** Neuhradené a zrušené objednávky — nevznikol účtovný záznam, netreba ich držať. */
const PUBLICATION_RETENTION_UNPAID_DAYS = 90;
/** IP adresa a prehliadač pri podaní objednávky — oprávnený záujem (prevencia zneužitia). */
const PUBLICATION_RETENTION_REQUEST_META_DAYS = 90;
/** Podrobnosti o stiahnutiach (čas, formát) nad rámec doby na uplatnenie nárokov. */
const PUBLICATION_RETENTION_DOWNLOAD_DETAIL_DAYS = 1461;

/**
 * Identifikácia predávajúceho pre predajné stránky, objednávky a e-maily.
 *
 * Poštová adresa miesta podnikania tu musí byť uvedená — predzmluvné informácie
 * pri predaji na diaľku ju vyžadujú. Zvyšok webu (privacy.php, terms.php)
 * vystačí s „so sídlom v Slovenskej republike (EÚ)“, pretože neuzatvára kúpnu
 * zmluvu; `establishment` preto zostáva pre texty, ktoré stačia všeobecne.
 *
 * `supervisoryAuthority` je inšpektorát SOI príslušný podľa miesta podnikania
 * (Rovinka, okres Senec → Bratislavský kraj) — spotrebiteľ musí vedieť, kam
 * sa obrátiť, a všeobecné „príslušný inšpektorát“ mu to nepovie.
 *
 * @return array<string, string>
 */
function publicationSeller(): array
{
    return [
        'name'          => 'MUDr. Ľubomír Polaščín - Nephroctor',
        'companyId'     => '57646856',
        'taxId'         => '1047524401',
        'vatNote'       => 'Predávajúci nie je platiteľom DPH. Ceny sú konečné.',
        'address'       => 'Kvetná 944/2I, 900 41 Rovinka',
        'establishment' => 'Slovenská republika (EÚ)',
        'email'         => 'nefro@polascin.net',
        'supervisoryAuthority'    => 'Inšpektorát Slovenskej obchodnej inšpekcie pre Bratislavský kraj',
        'supervisoryAuthorityUrl' => 'https://www.soi.sk/',
    ];
}

/**
 * Bankové údaje pre úhradu objednávok. Zhodné s podpora.php — pri zmene IBAN
 * treba upraviť obe miesta, inak si budú protirečiť.
 *
 * @return array<string, string>
 */
function publicationBankAccount(): array
{
    return [
        'recipient'    => 'MUDr. Ľubomír Polaščín - Nephroctor',
        'iban_raw'     => 'SK0311000000002943301908',
        'iban_pretty'  => 'SK03 1100 0000 0029 4330 1908',
        'swift'        => 'TATRSKBX',
        'bank_name'    => 'Tatra banka, a.s.',
        'bank_address' => 'Hodžovo námestie 3, 811 06 Bratislava 1',
        'country'      => 'SK',
    ];
}

/**
 * Formáty, v ktorých sa publikácie predávajú. Kľúč je kód formátu — používa sa
 * v URL, v DB (`formats` ako CSV) aj v názve súboru, preto musí ostať ASCII.
 *
 * @return array<string, array{ext: string, label: string, mime: string, note: string}>
 */
function publicationFormats(): array
{
    return [
        'pdf' => [
            'ext'   => 'pdf',
            'label' => 'PDF',
            'mime'  => 'application/pdf',
            'note'  => 'Základný formát s pevnou sadzbou — na čítanie na počítači, tablete aj na tlač. Otvorí ho čokoľvek.',
        ],
        'epub' => [
            'ext'   => 'epub',
            'label' => 'EPUB',
            'mime'  => 'application/epub+zip',
            'note'  => 'Pretekavý text pre čítačky a mobilné aplikácie (Apple Books, Google Play Books, PocketBook, Kobo, Calibre).',
        ],
        'azw3' => [
            'ext'   => 'azw3',
            'label' => 'AZW3 (Kindle)',
            'mime'  => 'application/vnd.amazon.ebook',
            'note'  => 'Pre čítačky Amazon Kindle — súbor pošlite do zariadenia cez Send to Kindle alebo USB.',
        ],
        'docx' => [
            'ext'   => 'docx',
            'label' => 'DOCX',
            'mime'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'note'  => 'Editovateľný dokument pre Microsoft Word — ak si chcete robiť vlastné poznámky či výpisky.',
        ],
        'odt' => [
            'ext'   => 'odt',
            'label' => 'ODT',
            'mime'  => 'application/vnd.oasis.opendocument.text',
            'note'  => 'Otvorený editovateľný formát pre LibreOffice a OpenOffice.',
        ],
    ];
}

/**
 * Katalóg publikácií. Pri pridaní ďalšej publikácie stačí doplniť položku —
 * katalóg, predajná stránka aj objednávkový tok ju prevezmú automaticky.
 *
 * @return array<int, array<string, mixed>>
 */
function publications(): array
{
    return [
        [
            'slug'        => 'sk-nefro-baza-1',
            'title'       => 'SK Nefro Báza 1',
            'subtitle'    => 'Súhrn odborných článkov z portálu nefro.polascin.net, apríl – október 2026',
            'author'      => 'MUDr. Ľubomír Polaščín',
            'edition'     => '1. vydanie, október 2026',
            'published_on' => '2026-10-03',
            'language'    => 'slovenčina',
            'language_code' => 'sk',
            'pages'       => 1745,
            'articles'    => 405,
            'words'       => 590630,
            'images'      => 476,
            'cover'       => 'img/publikacie/sk-nefro-baza-1-obalka.jpg',
            'cover_small' => 'img/publikacie/sk-nefro-baza-1-obalka-600.jpg',
            'formats'     => ['pdf', 'epub', 'azw3', 'docx', 'odt'],
            'is_available' => true,
            'excerpt'     => 'Celý polročný ročník odborného obsahu portálu v jednej knihe — 405 článkov '
                . 'o chronickej chorobe obličiek, dialýze, transplantácii a internej medicíne, '
                . 'zoradených a prelinkovaných na čítanie offline.',
            'description'  => [
                'Prvý zväzok série <strong>SK Nefro Báza</strong> zhromažďuje všetko, čo na portáli '
                . '<em>Nefro-projekt Slovensko</em> vyšlo od apríla do začiatku októbra 2026 — '
                . '405 odborných a popularizačných článkov, vrátane ťahákov a textov pre pacientov.',
                'Na webe je obsah rozdrobený do jednotlivých článkov a nájdete ho len cez vyhľadávanie. '
                . 'V knihe je zoradený, s obsahom, priebežným číslovaním a zachovanými odkazmi na zdroje, '
                . 'takže sa dá čítať aj listovať ako celok — v ambulancii, na dialýze aj bez internetu.',
                'Texty prešli pred zostavením jazykovou korektúrou a zjednotením terminológie '
                . '(chronická choroba obličiek, glomerulová filtrácia, inhibítor SGLT2, agonista GLP-1, '
                . 'jednotky mmol/l), takže znenie je konzistentné naprieč celým zväzkom.',
            ],
            'highlights'   => [
                '405 článkov na 1 745 stranách — celý ročník obsahu v jednom súbore',
                '476 ilustrácií a schém v plnom rozlíšení',
                'Chronologické radenie s obsahom a vnútornými odkazmi',
                'Zachované citácie a odkazy na primárne zdroje (PubMed, Crossref)',
                'Jazyková korektúra a zjednotená odborná terminológia',
                'Bez DRM — kúpený súbor je váš, čítajte ho na čomkoľvek',
            ],
            'audience'     => 'Nefrológovia, internisti, lekári v špecializačnej príprave, sestry na dialýze '
                . 'a informovaní pacienti, ktorí chcú mať odborný obsah portálu pohromade a offline.',
        ],
        [
            'slug'        => 'sk-nefro-baza-1-en',
            'title'       => 'SK Nefro Báza 1 — English edition',
            'subtitle'    => 'Collected specialist articles from nefro.polascin.net, April – October 2026',
            'author'      => 'Ľubomír Polaščín, MD',
            'edition'     => '1. vydanie, október 2026',
            'published_on' => '2026-10-03',
            'language'    => 'angličtina',
            // Jazyk obsahu, nie jazyk stránky — ide do Schema.org `inLanguage`.
            'language_code' => 'en',
            // Anglické vydanie je o 18 článkov menšie: popularizačné texty
            // pre pacientov sa neprekladali, lebo mieria na slovenského
            // pacienta. Číslo preto nie je 405 ako v slovenskom vydaní.
            'pages'       => 1782,
            'articles'    => 387,
            'words'       => 661410,
            'images'      => 393,
            'cover'       => 'img/publikacie/sk-nefro-baza-1-en-obalka.jpg',
            'cover_small' => 'img/publikacie/sk-nefro-baza-1-en-obalka-600.jpg',
            'formats'     => ['pdf', 'epub', 'azw3', 'docx', 'odt'],
            'is_available' => true,
            'excerpt'     => 'Anglický preklad odborného ročníka portálu — 387 článkov o chronickej '
                . 'chorobe obličiek, dialýze, transplantácii a internej medicíne. Vhodné na '
                . 'zdieľanie so zahraničnými kolegami a na citovanie v anglickom prostredí.',
            'description'  => [
                '<strong>Anglické vydanie</strong> prvého zväzku série <em>SK Nefro Báza</em>. '
                . 'Obsahuje 387 odborných článkov, ktoré na portáli '
                . '<em>Nefro-projekt Slovensko</em> vyšli od apríla do začiatku októbra 2026, '
                . 'preložených do angličtiny vrátane ťahákov.',
                'Oproti slovenskému vydaniu <strong>neobsahuje 18 popularizačných textov '
                . 'pre pacientov</strong> — tie sú písané pre slovenského pacienta a preklad '
                . 'by im vzal zmysel. Všetko ostatné je zhodné: rovnaké články, rovnaké '
                . 'zoradenie, rovnaké odkazy na zdroje.',
                'Pri každom článku je odkaz na jeho slovenskú online verziu, takže sa dá '
                . 'rýchlo porovnať s originálom. Terminológia, jednotky aj desatinné '
                . 'oddeľovače sú prevedené do anglickej konvencie.',
            ],
            'highlights'   => [
                '387 článkov na 1 782 stranách — odborný ročník v angličtine',
                '393 ilustrácií a schém v plnom rozlíšení',
                'Pri každom článku odkaz na slovenskú online verziu',
                'Anglická terminológia, jednotky a desatinné oddeľovače',
                'Zachované citácie a odkazy na primárne zdroje (PubMed, Crossref)',
                'Bez DRM — kúpený súbor je váš, čítajte ho na čomkoľvek',
            ],
            'audience'     => 'Zahraniční kolegovia, slovenskí nefrológovia a internisti, ktorí potrebujú '
                . 'odborný obsah v angličtine na zdieľanie, citovanie alebo prednášky.',
        ],
        [
            'slug'        => 'sk-nefro-baza-1-kompendium',
            'title'       => 'SK Nefro Báza 1 Kompendium',
            'subtitle'    => 'Abstrakty a zhutnené verzie odborných článkov z portálu nefro.polascin.net, apríl – október 2026',
            'author'      => 'MUDr. Ľubomír Polaščín',
            'edition'     => '1. vydanie, október 2026',
            'published_on' => '2026-10-04',
            'language'    => 'slovenčina',
            'language_code' => 'sk',
            'pages'       => 261,
            'articles'    => 387,
            'words'       => 109029,
            // Kompendium zámerne nepreberá obrázky ani tabuľky z plného
            // vydania — je to textová mapa, nie obrazová publikácia. Šablóny
            // preto fakt o ilustráciách pri nule vynechávajú.
            'images'      => 0,
            'cover'       => 'img/publikacie/sk-nefro-baza-1-kompendium-obalka.jpg',
            'cover_small' => 'img/publikacie/sk-nefro-baza-1-kompendium-obalka-600.jpg',
            'formats'     => ['pdf', 'epub', 'azw3', 'docx', 'odt'],
            'is_available' => true,
            'excerpt'     => 'Zhustené vydanie prvého zväzku — 387 článkov ako abstrakt a štyri až sedem '
                . 'kľúčových bodov, k tomu syntéza na začiatku každej zo 16 kapitol. '
                . 'Celý ročník na 261 stranách namiesto 1 745.',
            'description'  => [
                '<strong>Kompendium</strong> je zhustené vydanie prvého zväzku série '
                . '<em>SK Nefro Báza</em>. Každý z 387 odborných článkov je spracovaný do '
                . 'abstraktu a zhutnenej verzie v štyroch až siedmich bodoch s kľúčovými '
                . 'číslami, limitmi dôkazov a praktickým záverom pre ambulanciu.',
                'Každú zo 16 kapitol otvára <strong>syntéza kľúčových posolstiev</strong> '
                . 'v rozsahu približne dvoch strán, ktorá spája jednotlivé články do '
                . 'súvislého obrazu a pri každom tvrdení odkazuje na číslo zdrojového článku. '
                . 'Číslovanie je zhodné s plným vydaním, takže prechod na celý text je okamžitý.',
                'Zhustenie má svoju cenu: kompendium <strong>nepreberá zoznamy literatúry, '
                . 'tabuľky ani obrázky</strong>. Je mapou, nie náhradou plného znenia — '
                . 'pri klinickom rozhodnutí, citovaní alebo výučbe treba siahnuť po '
                . 'plnom článku v zväzku <em>SK Nefro Báza 1</em> alebo na portáli.',
            ],
            'highlights'   => [
                '387 článkov na 261 stranách — celý ročník za zlomok rozsahu',
                'Pri každom článku abstrakt a 4 až 7 kľúčových bodov s číslami',
                'Syntéza kľúčových posolstiev na začiatku každej zo 16 kapitol',
                'Číslovanie zhodné s plným vydaním SK Nefro Báza 1',
                'Odkaz na online verziu pri každom článku',
                'Bez DRM — kúpený súbor je váš, čítajte ho na čomkoľvek',
            ],
            'audience'     => 'Lekári, ktorí potrebujú rýchlu orientáciu pri vizite, v ambulancii alebo '
                . 'pred seminárom — a čitatelia plného vydania, ktorým sa hodí stručný register toho, '
                . 'čo jednotlivé články priniesli.',
        ],
        [
            'slug'        => 'sk-nefro-baza-1-kompendium-en',
            'title'       => 'SK Nefro Báza 1 Compendium — English edition',
            'subtitle'    => 'Abstracts and summaries of specialist articles from nefro.polascin.net, April – October 2026',
            'author'      => 'Ľubomír Polaščín, MD',
            'edition'     => '1. vydanie, október 2026',
            'published_on' => '2026-10-04',
            'language'    => 'angličtina',
            'language_code' => 'en',
            'pages'       => 275,
            'articles'    => 387,
            // Rozsah textu je väčší než v slovenskom kompendiu (109 029 slov)
            // len kvôli angličtine — tá na tú istú informáciu potrebuje viac
            // slov. Článkov aj kapitol je rovnako.
            'words'       => 127308,
            'images'      => 0,
            'cover'       => 'img/publikacie/sk-nefro-baza-1-kompendium-en-obalka.jpg',
            'cover_small' => 'img/publikacie/sk-nefro-baza-1-kompendium-en-obalka-600.jpg',
            'formats'     => ['pdf', 'epub', 'azw3', 'docx', 'odt'],
            'is_available' => true,
            'excerpt'     => 'Anglické vydanie kompendia — 387 článkov ako abstrakt a stručné zhrnutie, '
                . 'k tomu syntéza na začiatku každej zo 16 kapitol. Celý ročník na 275 stranách '
                . 'namiesto 1 782.',
            'description'  => [
                '<strong>Anglické vydanie kompendia</strong> prvého zväzku série '
                . '<em>SK Nefro Báza</em>. Každý z 387 odborných článkov je spracovaný do '
                . 'abstraktu a stručného zhrnutia s kľúčovými číslami, limitmi dôkazov '
                . 'a praktickým záverom.',
                'Každú zo 16 kapitol otvára <strong>syntéza kľúčových posolstiev</strong>, '
                . 'ktorá spája jednotlivé články a pri každom tvrdení odkazuje na číslo '
                . 'zdrojového článku. Číslovanie je zhodné s anglickým plným vydaním '
                . '<em>SK Nefro Báza 1</em>, prílohové články sú A.1 až A.11.',
                'Články boli písané pre lekárov pôsobiacich na Slovensku, preto odkazy na '
                . 'slovenskú legislatívu, inštitúcie a úhradové pravidlá zostali zachované. '
                . 'Odkazy na online verziu vedú na slovenský originál; plné anglické znenie '
                . 'je v anglickom vydaní zväzku 1.',
                'Rovnako ako slovenské kompendium <strong>nepreberá zoznamy literatúry, '
                . 'tabuľky ani obrázky</strong> — je mapou, nie náhradou plného znenia.',
            ],
            'highlights'   => [
                '387 článkov na 275 stranách — celý ročník v angličtine za zlomok rozsahu',
                'Pri každom článku abstrakt a stručné zhrnutie s kľúčovými číslami',
                'Syntéza kľúčových posolstiev na začiatku každej zo 16 kapitol',
                'Číslovanie zhodné s anglickým plným vydaním (príloha A.1 až A.11)',
                'Pri každom článku odkaz na slovenskú online verziu',
                'Bez DRM — kúpený súbor je váš, čítajte ho na čomkoľvek',
            ],
            'audience'     => 'Zahraniční kolegovia a slovenskí lekári, ktorí potrebujú rýchlu '
                . 'orientáciu v angličtine — na vizitu, prednášku alebo zdieľanie s kolegami '
                . 'mimo Slovenska.',
        ],
    ];
}

/**
 * Nájde publikáciu podľa slugu.
 *
 * @return array<string, mixed>|null
 */
function findPublication(string $slug): ?array
{
    foreach (publications() as $publication) {
        if ($publication['slug'] === $slug) {
            return $publication;
        }
    }

    return null;
}

/** Je slug v tvare, ktorý smieme použiť v názve adresára a súboru? */
function isValidPublicationSlug(string $slug): bool
{
    return (bool) preg_match('/^[a-z0-9][a-z0-9-]{0,80}$/', $slug);
}

/**
 * Ponechá z vybraných kódov len tie, ktoré publikácia skutočne ponúka,
 * a zoradí ich podľa poradia v katalógu (nie podľa poradia v požiadavke).
 *
 * @param array<string, mixed> $publication
 * @param array<int, mixed>    $requested
 * @return array<int, string>
 */
function normalizePublicationFormats(array $publication, array $requested): array
{
    /** @var array<int, string> $offered */
    $offered   = $publication['formats'];
    $requested = array_map(
        static fn (string $code): string => strtolower(trim($code)),
        array_filter($requested, 'is_string')
    );

    return array_values(array_filter($offered, static fn (string $code): bool => in_array($code, $requested, true)));
}

/**
 * Cena za vybrané formáty. Jeden formát stojí PUBLICATION_PRICE_SINGLE,
 * dva a viac sú už balík za PUBLICATION_PRICE_BUNDLE — pri dvoch formátoch
 * by samostatné ceny (2 × 7 €) prevýšili balík, takže balíkovú cenu
 * uplatňujeme automaticky a kupujúci nemá ako preplatiť.
 *
 * @param array<int, string> $formats
 */
function publicationPriceFor(array $formats): float
{
    $count = count($formats);
    if ($count <= 0) {
        return 0.0;
    }

    return $count === 1 ? PUBLICATION_PRICE_SINGLE : PUBLICATION_PRICE_BUNDLE;
}

/**
 * ASCII podoba názvu súboru pre `filename=` v Content-Disposition.
 *
 * Moderné klienty čítajú `filename*` (RFC 5987) s plnou diakritikou; `filename=`
 * je fallback pre staré prehliadače a musí byť ASCII. Preto nestačí nahradiť
 * nepovolené bajty podčiarkovníkom — „á“ má v UTF-8 dva bajty a zo
 * „SK Nefro Báza 1“ by vzniklo „SK Nefro B__za 1“. Diakritiku najprv
 * prepíšeme na základné písmeno.
 */
function publicationAsciiFilename(string $name): string
{
    $map = [
        'á' => 'a', 'ä' => 'a', 'â' => 'a', 'à' => 'a', 'ã' => 'a', 'å' => 'a',
        'č' => 'c', 'ć' => 'c', 'ç' => 'c',
        'ď' => 'd', 'đ' => 'd',
        'é' => 'e', 'ě' => 'e', 'ë' => 'e', 'è' => 'e', 'ê' => 'e',
        'í' => 'i', 'ï' => 'i', 'ì' => 'i', 'î' => 'i',
        'ľ' => 'l', 'ĺ' => 'l', 'ł' => 'l',
        'ň' => 'n', 'ń' => 'n', 'ñ' => 'n',
        'ó' => 'o', 'ô' => 'o', 'ö' => 'o', 'ò' => 'o', 'õ' => 'o', 'ø' => 'o',
        'ŕ' => 'r', 'ř' => 'r',
        'š' => 's', 'ś' => 's', 'ş' => 's',
        'ť' => 't', 'ţ' => 't',
        'ú' => 'u', 'ů' => 'u', 'ü' => 'u', 'ù' => 'u', 'û' => 'u',
        'ý' => 'y', 'ÿ' => 'y',
        'ž' => 'z', 'ź' => 'z', 'ż' => 'z',
        'ß' => 'ss', 'æ' => 'ae', 'œ' => 'oe',
        // Typografická interpunkcia v názve publikácie: bez prepisu by sa
        // z em dash „—" (tri bajty v UTF-8) stali tri podčiarkovníky.
        '—' => '-', '–' => '-', '‑' => '-',
        '„' => '"', '“' => '"', '”' => '"',
        '‘' => "'", '’' => "'",
        '…' => '...', ' ' => ' ',
    ];

    // Veľké písmená dorobíme z tej istej tabuľky, aby sa nemusela písať dvakrát.
    foreach ($map as $from => $to) {
        $map[mb_strtoupper($from)] = mb_strtoupper($to);
    }

    $ascii = strtr($name, $map);

    return preg_replace('/[^A-Za-z0-9._ -]/', '_', $ascii) ?? 'publikacia';
}

/** Cena v tvare „7,00 €“ (slovenská konvencia: desatinná čiarka, medzera pred €). */
function formatPublicationPrice(float $price): string
{
    return number_format($price, 2, ',', ' ') . ' €';
}

/**
 * Štítky vybraných formátov pre zobrazenie a e-maily.
 *
 * @param array<int, string> $formats
 * @return array<int, string>
 */
function publicationFormatLabels(array $formats): array
{
    $all = publicationFormats();

    return array_values(array_map(
        static fn (string $code): string => (string) ($all[$code]['label'] ?? strtoupper($code)),
        array_filter($formats, static fn (string $code): bool => isset($all[$code]))
    ));
}

/**
 * Absolútna cesta k súboru publikácie v danom formáte, alebo null ak chýba.
 * Slug aj kód formátu sú validované voči katalógu — do cesty sa nikdy
 * nedostane vstup z požiadavky bez prechodu touto funkciou.
 */
function publicationFilePath(string $slug, string $formatCode): ?string
{
    if (!isValidPublicationSlug($slug)) {
        return null;
    }

    $formats = publicationFormats();
    if (!isset($formats[$formatCode])) {
        return null;
    }

    $path = PUBLICATION_FILES_DIR . '/' . $slug . '/' . $slug . '.' . $formats[$formatCode]['ext'];

    return is_file($path) && is_readable($path) ? $path : null;
}

/** Veľkosť súboru v čitateľnom tvare („27,4 MB“), alebo null ak súbor chýba. */
function publicationFileSize(string $slug, string $formatCode): ?string
{
    $path = publicationFilePath($slug, $formatCode);
    if ($path === null) {
        return null;
    }

    $bytes = (int) filesize($path);
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 1, ',', ' ') . ' MB';
    }

    return number_format(max(1, (int) round($bytes / 1024)), 0, ',', ' ') . ' kB';
}

/**
 * Variabilný symbol objednávky: rok + ID doplnené nulami na 10 znakov.
 * Banky VS nad 10 číslic odmietajú, preto ID obmedzujeme na 6 miest —
 * to je 999 999 objednávok v jednom roku, čo s rezervou stačí.
 */
function publicationOrderVariableSymbol(int $orderId, string $createdAt): string
{
    $year = substr($createdAt, 0, 4);
    if (!preg_match('/^\d{4}$/', $year)) {
        $year = date('Y');
    }

    return $year . str_pad((string) ($orderId % 1000000), 6, '0', STR_PAD_LEFT);
}

/** Odkaz na platobnú stránku payme.sk s predvyplnenou sumou a variabilným symbolom. */
function publicationPaymeUrl(float $amount, string $variableSymbol): string
{
    $bank = publicationBankAccount();

    return 'https://payme.sk/2/q/PME?IBAN=' . rawurlencode($bank['iban_raw'])
        . '&AM=' . rawurlencode(number_format($amount, 2, '.', ''))
        . '&CC=EUR'
        . '&PI=' . rawurlencode('/VS' . $variableSymbol)
        . '&MSG=' . rawurlencode('SK Nefro Baza')
        . '&CN=' . rawurlencode('MUDr. Lubomir Polascin');
}

/* ─────────────────── Doplnkové spôsoby platby ───────────────────────────────
 * Bankový prevod zostáva základom: je bez poplatkov a variabilný symbol
 * spoľahlivo spáruje platbu s objednávkou. Doplnkové kanály sú pre
 * kupujúcich, ktorí platia kartou alebo peňaženkou.
 *
 * Pri každej metóde je kľúčová otázka, či prenesie **referenciu objednávky**.
 * Bez nej predávajúci vidí len prišlú sumu a netuší, komu má publikáciu
 * poslať — preto metódy bez technickej referencie kupujúcemu výslovne
 * povedia, že variabilný symbol musí uviesť do poznámky, a sú označené ako
 * pomalšie na spárovanie.
 *
 *   Stripe   → client_reference_id (automaticky, vidno v Stripe dashboarde)
 *   PayPal   → custom + item_name (automaticky)
 *   payme.sk → variabilný symbol v platobnom príkaze (automaticky)
 *   Revolut, Ko-fi, Viamo, Uphold → len poznámka od kupujúceho
 * ────────────────────────────────────────────────────────────────────────── */

/**
 * Konfigurácia doplnkových platobných kanálov na jednom mieste.
 *
 * Zámerne funkcia a nie konštanty: vyprázdnenie hodnoty je prevádzkový
 * prepínač (kanál zo stránky zmizne), nie preklep. Pri konštantách by
 * statická analýza porovnanie s prázdnym reťazcom vyhodnotila ako mŕtvy kód
 * a prepínač by sa stal neviditeľným.
 *
 * `stripe_links` - Suma sa do Stripe URL vložiť nedá; je zapečená v cene,
 * na ktorú je Payment Link vytvorený. Máme jeden nákupný odkaz na každú
 * cenovú hladinu (kľúč je suma v tvare „7.00“).
 * Donate link (podpora.php) sa v predaji nepoužíva, aby nedošlo k zámene
 * predaja za dar bez pevnej sumy.
 *
 * @return array<string, mixed>
 */
function publicationPaymentConfig(): array
{
    return [
        'stripe_links' => [
            '7.00'  => 'https://buy.stripe.com/cNi9AN1fs51B95OeWOfMA01',
            '12.00' => 'https://buy.stripe.com/3cI6oB5vIcu35TCcOGfMA02',
        ],
        // Donate link z podpora.php sa v predaji publikácií nepoužíva, aby nedochádzalo
        // k zámene predaja za dar s voľnou sumou. Ak by cena nemala presný odkaz,
        // fallback je prázdny a metóda Stripe sa neponúkne.
        'stripe_fallback' => '',
        'paypal_account'  => 'polascin@proton.me',
        // Revolut ani Ko-fi nevedia prijať sumu či referenciu v odkaze —
        // kupujúci ich zadáva v ich rozhraní.
        'revolut_url'     => 'https://revolut.me/polascin',
        'kofi_url'        => 'https://ko-fi.com/lubomirpolascin',
        'uphold_account'  => 'lubomir@polascin.net',
        // Viamo — okamžitá platba na telefónne číslo. Zhodné s podpora.php.
        'viamo_phone_raw'    => '+421917370474',
        'viamo_phone_pretty' => '+421 917 370 474',
    ];
}

/**
 * Stripe odkaz pre danú sumu.
 *
 * `client_reference_id` (alfanumerické znaky, pomlčky a podčiarkovníky, do
 * 200 znakov) nesie variabilný symbol — v Stripe dashboarde ho predávajúci
 * vidí pri platbe, takže ju spáruje bez pýtania sa kupujúceho.
 *
 * @return array{url: string, exact: bool}|null  `exact` = odkaz má pevnú sumu
 */
function publicationStripeUrl(float $amount, string $variableSymbol, string $buyerEmail = ''): ?array
{
    $cfg   = publicationPaymentConfig();
    $key   = number_format($amount, 2, '.', '');
    $links = $cfg['stripe_links'];
    $exact = isset($links[$key]) && $links[$key] !== '';
    $base  = $exact ? (string) $links[$key] : (string) $cfg['stripe_fallback'];

    if ($base === '') {
        return null;
    }

    $params = ['client_reference_id' => $variableSymbol, 'locale' => 'sk'];
    if (filter_var($buyerEmail, FILTER_VALIDATE_EMAIL)) {
        $params['prefilled_email'] = $buyerEmail;
    }

    return [
        'url'   => $base . (str_contains($base, '?') ? '&' : '?') . http_build_query($params),
        'exact' => $exact,
    ];
}

/**
 * PayPal „Buy Now“ — polia formulára s pevnou sumou. Variabilný symbol ide
 * do `custom`, `item_number` aj do názvu položky, takže ho predávajúci vidí
 * v transakcii a objednávku spáruje bez pýtania sa kupujúceho.
 *
 * PayPal Payments Standard je navrhnutý ako **POST formulár** na
 * `cgi-bin/webscr`, nie ako odkaz s query stringom — tá istá kombinácia polí
 * poslaná GETom vracia 403. Preto sa vracajú polia, ktoré stránka vykreslí
 * ako formulár, a nie hotová URL.
 *
 * Endpoint PayPal označuje za zastaraný, stále však funguje a nevyžaduje
 * serverovú integráciu ani API kľúče. Ak ho PayPal vypne, stačí
 * `paypal_account` v publicationPaymentConfig() vyprázdniť a možnosť
 * zo stránky zmizne.
 *
 * @return array{action: string, fields: array<string, string>}
 */
function publicationPaypalForm(float $amount, string $variableSymbol, string $title): array
{
    return [
        'action' => 'https://www.paypal.com/cgi-bin/webscr',
        'fields' => [
            'cmd'           => '_xclick',
            'business'      => (string) publicationPaymentConfig()['paypal_account'],
            'item_name'     => $title . ' (obj. ' . $variableSymbol . ')',
            'item_number'   => $variableSymbol,
            'custom'        => $variableSymbol,
            'amount'        => number_format($amount, 2, '.', ''),
            'currency_code' => 'EUR',
            'no_shipping'   => '1',
            'no_note'       => '0',
            'charset'       => 'utf-8',
            'lc'            => 'SK',
        ],
    ];
}

/**
 * Doplnkové spôsoby platby pre konkrétnu objednávku. Vracia len tie, ktoré
 * majú vyplnenú konfiguráciu — vyprázdnením konštanty metóda zo stránky zmizne.
 *
 * Kľúče položky:
 *   name, desc  — čo to je a pre koho
 *   url         — odkaz na platbu (null pri formulári alebo kopírovanom údaji)
 *   form        — POST formulár {action, fields} pre brány, ktoré GET odmietajú
 *   cta         — text tlačidla
 *   copy        — hodnota na skopírovanie (telefón, e-mail účtu)
 *   copy_label  — popis kopírovanej hodnoty
 *   auto_ref    — true, ak metóda prenesie variabilný symbol sama
 *   exact       — true, ak je suma v odkaze pevná
 *
 * @param array<string, mixed> $order
 * @return array<int, array<string, mixed>>
 */
function publicationPaymentMethods(array $order): array
{
    $amount = (float) $order['amount_eur'];
    $vs     = (string) $order['variable_symbol'];
    $title  = (string) $order['publication_title'];
    $email  = (string) $order['buyer_email'];
    $price  = formatPublicationPrice($amount);
    $cfg    = publicationPaymentConfig();

    $methods = [];

    $stripe = publicationStripeUrl($amount, $vs, $email);
    if ($stripe !== null) {
        $methods[] = [
            'key'      => 'stripe',
            'name'     => $stripe['exact']
                ? 'Platobná karta, Apple Pay a Google Pay'
                : 'Platobná karta, Apple Pay a Google Pay — sumu zadávate ručne',
            'desc'     => $stripe['exact']
                ? 'Zabezpečená platobná brána Stripe s predvyplnenou sumou ' . $price
                    . '. Platí sa kartou alebo mobilnou peňaženkou, bez zadávania bankových údajov.'
                // Kým nie je pre danú cenu vytvorený Payment Link s pevnou cenou,
                // používa sa všeobecná platobná stránka. Sumu teda zadáva kupujúci
                // a môže sa preklepnúť — na to musí byť výslovne upozornený,
                // inak vznikne nedoplatok, ktorý sa rieši dodatočne.
                : 'Zabezpečená platobná brána Stripe. Platobná stránka ešte nemá pevnú cenu, '
                    . 'takže sumu ' . $price . ' musíte zadať sami — skontrolujte si ju prosím '
                    . 'pred potvrdením. Číslo objednávky sa prenesie automaticky. '
                    . 'Ak chcete mať sumu predvyplnenú, použite bankový prevod alebo PayPal.',
            'url'      => $stripe['url'],
            'cta'      => 'Zaplatiť kartou',
            'auto_ref' => true,
            'exact'    => $stripe['exact'],
        ];
    }

    if ($cfg['paypal_account'] !== '') {
        $methods[] = [
            'key'      => 'paypal',
            'name'     => 'PayPal',
            'desc'     => 'Platba z PayPal zostatku alebo kartou. Suma ' . $price
                . ' aj číslo objednávky sú predvyplnené.',
            'url'      => null,
            'form'     => publicationPaypalForm($amount, $vs, $title),
            'cta'      => 'Zaplatiť cez PayPal',
            'auto_ref' => true,
            'exact'    => true,
        ];
    }

    if ($cfg['revolut_url'] !== '') {
        $methods[] = [
            'key'      => 'revolut',
            'name'     => 'Revolut',
            'desc'     => 'Karta, Apple Pay aj Google Pay jedným odkazom. Revolut neprenesie sumu '
                . 'ani číslo objednávky — zadajte sumu ' . $price . ' a do popisu platby '
                . 'variabilný symbol.',
            'url'      => $cfg['revolut_url'],
            'cta'      => 'Zaplatiť cez Revolut',
            'auto_ref' => false,
            'exact'    => false,
        ];
    }

    if ($cfg['kofi_url'] !== '') {
        $methods[] = [
            'key'      => 'kofi',
            'name'     => 'Ko-fi',
            'desc'     => 'Platba kartou alebo peňaženkou cez Ko-fi. Zadajte sumu ' . $price
                . ' a do správy variabilný symbol.',
            'url'      => $cfg['kofi_url'],
            'cta'      => 'Zaplatiť cez Ko-fi',
            'auto_ref' => false,
            'exact'    => false,
        ];
    }

    if ($cfg['viamo_phone_raw'] !== '') {
        $methods[] = [
            'key'        => 'viamo',
            'name'       => 'Viamo — platba na telefónne číslo',
            'desc'       => 'Okamžitá platba medzi slovenskými bankami (Tatra banka, VÚB, OTP) '
                . 'bez IBAN. V aplikácii banky zvoľte platbu na telefónne číslo, zadajte sumu '
                . $price . ' a do poznámky variabilný symbol.',
            'url'        => null,
            'copy'       => $cfg['viamo_phone_raw'],
            'copy_label' => $cfg['viamo_phone_pretty'],
            'auto_ref'   => false,
            'exact'      => false,
        ];
    }

    if ($cfg['uphold_account'] !== '') {
        $methods[] = [
            'key'        => 'uphold',
            'name'       => 'Kryptomeny (Uphold)',
            'desc'       => 'V aplikácii Uphold zvoľte Send, zadajte e-mail príjemcu a kryptomenu '
                . 'v hodnote ' . $price . '. Do poznámky uveďte variabilný symbol. '
                . 'Kurz sa môže pohnúť, preto platbu párujeme ručne.',
            'url'        => null,
            'copy'       => $cfg['uphold_account'],
            'copy_label' => $cfg['uphold_account'],
            'auto_ref'   => false,
            'exact'      => false,
        ];
    }

    return $methods;
}

/**
 * Údaje pre PAY by square QR kód (štandard SK bankovej asociácie v tvare,
 * ktorý aplikácie bánk čítajú z odkazu payme.sk). QR generuje prehliadač
 * z tohto odkazu — CSP nedovoľuje inline štýly ani externé skripty, preto
 * sa používa lokálne `assets/qrcode.min.js`.
 */
function publicationPaymentQrPayload(float $amount, string $variableSymbol): string
{
    return publicationPaymeUrl($amount, $variableSymbol);
}

/** Absolútna URL stránky objednávky (do e-mailov musí ísť celá, nie relatívna). */
function publicationOrderUrl(string $variableSymbol, string $token): string
{
    return 'https://nefro.polascin.net/objednavka.php?vs=' . rawurlencode($variableSymbol)
        . '&t=' . rawurlencode($token);
}

/* ───────────────────────────── Objednávky v DB ──────────────────────────── */

/**
 * Prístupový token objednávky. Nie je to uložená náhodná hodnota, ale HMAC
 * z ID objednávky a jej soli — vďaka tomu ho vieme kedykoľvek odvodiť znova
 * (napríklad keď predávajúci po potvrdení platby posiela dodací e-mail),
 * a pritom v DB nie je nič, čím by sa dal odkaz z e-mailu priamo zneužiť.
 * Prepísanie `token_salt` zneplatní odkaz, ktorý sme už poslali.
 *
 * @param array<string, mixed> $order
 */
function publicationOrderToken(array $order): string
{
    $payload = 'nefro:publication-order:v1|' . (int) $order['id'] . '|' . (string) $order['token_salt'];

    return rtrim(strtr(base64_encode(
        hash_hmac('sha256', $payload, getAppDataProtectionKey(), true)
    ), '+/', '-_'), '=');
}

/**
 * Založí objednávku a vráti ju spolu s prístupovým tokenom pre odkaz v e-maile.
 *
 * Volá sa až po serverovom overení oboch povinných súhlasov (pozri
 * publikacia.php), preto sa čas oboch zapisuje priamo pri vložení spolu
 * s verziou podmienok — bez toho by sa nedalo preukázať, že kupujúci
 * výslovne požiadal o dodanie pred uplynutím lehoty na odstúpenie.
 *
 * @param array<string, mixed> $publication
 * @param array<int, string>   $formats
 * @param array<string, string> $buyer  email, name, company, company_id, tax_id, address, note
 * @return array{order: array<string, mixed>, token: string}
 */
function createPublicationOrder(PDO $pdo, array $publication, array $formats, array $buyer): array
{
    $amount = publicationPriceFor($formats);

    $stmt = $pdo->prepare(
        "INSERT INTO publication_orders
            (publication_slug, publication_title, formats, amount_eur, currency,
             buyer_email, buyer_name, buyer_company, buyer_company_id, buyer_tax_id,
             buyer_address, buyer_note,
             consent_terms_at, consent_delivery_at, consent_terms_version,
             token_salt, status,
             payment_due_at, created_ip, created_user_agent)
         VALUES
            (:slug, :title, :formats, :amount, 'EUR',
             :email, :name, :company, :company_id, :tax_id,
             :address, :note,
             NOW(), NOW(), :terms_version,
             :token_salt, 'awaiting_payment',
             DATE_ADD(NOW(), INTERVAL :due_days DAY), :ip, :ua)"
    );
    $stmt->execute([
        'slug'       => (string) $publication['slug'],
        'title'      => (string) $publication['title'],
        'formats'    => implode(',', $formats),
        'amount'     => number_format($amount, 2, '.', ''),
        'email'      => $buyer['email'],
        'name'       => $buyer['name'] ?? '',
        'company'    => $buyer['company'] ?? '',
        'company_id' => $buyer['company_id'] ?? '',
        'tax_id'     => $buyer['tax_id'] ?? '',
        'address'    => $buyer['address'] ?? '',
        'note'       => $buyer['note'] ?? '',
        'terms_version' => PUBLICATION_TERMS_VERSION,
        'token_salt' => bin2hex(random_bytes(16)),
        'due_days'   => PUBLICATION_PAYMENT_DAYS,
        'ip'         => getClientIpAddress(),
        'ua'         => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
    ]);

    $orderId = (int) $pdo->lastInsertId();

    // Variabilný symbol vieme zložiť až z prideleného ID, preto druhý UPDATE.
    $order = findPublicationOrderById($pdo, $orderId);
    if ($order === null) {
        throw new RuntimeException('Objednávku sa po vložení nepodarilo načítať.');
    }

    $variableSymbol = publicationOrderVariableSymbol($orderId, (string) $order['created_at']);
    $pdo->prepare("UPDATE publication_orders SET variable_symbol = :vs WHERE id = :id")
        ->execute(['vs' => $variableSymbol, 'id' => $orderId]);
    $order['variable_symbol'] = $variableSymbol;

    return ['order' => $order, 'token' => publicationOrderToken($order)];
}

/**
 * @return array<string, mixed>|null
 */
function findPublicationOrderById(PDO $pdo, int $orderId): ?array
{
    $stmt = $pdo->prepare("SELECT * FROM publication_orders WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $orderId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row === false ? null : $row;
}

/**
 * Načíta objednávku podľa variabilného symbolu a prístupového tokenu.
 * VS sám o sebe nestačí — je to predvídateľné poradové číslo, ktoré vidí
 * každý, kto uvidí platbu; otvorí objednávku až spolu s tokenom.
 *
 * @return array<string, mixed>|null
 */
function findPublicationOrderByToken(PDO $pdo, string $variableSymbol, string $token): ?array
{
    if (!preg_match('/^\d{5,12}$/', $variableSymbol) || $token === '' || strlen($token) > 128) {
        return null;
    }

    $stmt = $pdo->prepare("SELECT * FROM publication_orders WHERE variable_symbol = :vs LIMIT 1");
    $stmt->execute(['vs' => $variableSymbol]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        return null;
    }

    // hash_equals, nie ===, aby sa z času porovnania nedal token odvodiť znak po znaku.
    return hash_equals(publicationOrderToken($row), $token) ? $row : null;
}

/**
 * Formáty objednávky ako pole kódov.
 *
 * @param array<string, mixed> $order
 * @return array<int, string>
 */
function publicationOrderFormats(array $order): array
{
    $codes = array_filter(array_map('trim', explode(',', (string) $order['formats'])));

    return array_values(array_filter($codes, static fn (string $code): bool => isset(publicationFormats()[$code])));
}

/**
 * Je objednávka zaplatená a prístup na stiahnutie ešte platný?
 *
 * @param array<string, mixed> $order
 */
function publicationOrderIsDownloadable(array $order): bool
{
    if (($order['status'] ?? '') !== 'paid') {
        return false;
    }

    $expiresAt = $order['access_expires_at'] ?? null;
    if ($expiresAt !== null && strtotime((string) $expiresAt) < time()) {
        return false;
    }

    return (int) ($order['download_count'] ?? 0) < PUBLICATION_DOWNLOAD_MAX;
}

/**
 * Označí objednávku ako zaplatenú a otvorí prístup na stiahnutie.
 * Vracia false, ak objednávka neexistuje alebo už zaplatená bola —
 * opakované potvrdenie nesmie posúvať platnosť prístupu.
 */
function markPublicationOrderPaid(PDO $pdo, int $orderId, ?string $paymentNote = null): bool
{
    // Rovnaká podmienka `status <> 'paid'` platí aj pre pamäťový SQLite
    // v CLI teste. MariaDB vetva ostáva na NOW()/DATE_ADD, aby sa čas
    // potvrdenia bral z databázy, nie z hodín PHP.
    if ((string) $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
        $now = new DateTimeImmutable('now', new DateTimeZone('Europe/Bratislava'));
        $stmt = $pdo->prepare(
            "UPDATE publication_orders
             SET status = 'paid',
                 paid_at = :paid_at,
                 access_expires_at = :expires_at,
                 payment_note = COALESCE(:note, payment_note)
             WHERE id = :id AND status <> 'paid'"
        );
        $stmt->execute([
            'paid_at'    => $now->format('Y-m-d H:i:s'),
            'expires_at' => $now->modify('+' . PUBLICATION_ACCESS_DAYS . ' days')->format('Y-m-d H:i:s'),
            'note'       => $paymentNote,
            'id'         => $orderId,
        ]);

        return $stmt->rowCount() > 0;
    }

    $stmt = $pdo->prepare(
        "UPDATE publication_orders
         SET status = 'paid',
             paid_at = NOW(),
             access_expires_at = DATE_ADD(NOW(), INTERVAL :access_days DAY),
             payment_note = COALESCE(:note, payment_note)
         WHERE id = :id AND status <> 'paid'"
    );
    $stmt->execute([
        'access_days' => PUBLICATION_ACCESS_DAYS,
        'note'        => $paymentNote,
        'id'          => $orderId,
    ]);

    return $stmt->rowCount() > 0;
}

/** Zruší objednávku (neuhradená, vrátená platba, žiadosť kupujúceho). */
function cancelPublicationOrder(PDO $pdo, int $orderId, string $reason): bool
{
    $stmt = $pdo->prepare(
        "UPDATE publication_orders
         SET status = 'cancelled', cancelled_at = NOW(), payment_note = :reason
         WHERE id = :id AND status <> 'cancelled'"
    );
    $stmt->execute(['reason' => mb_substr($reason, 0, 500), 'id' => $orderId]);

    return $stmt->rowCount() > 0;
}

/** Zapíše jedno stiahnutie (počítadlo je zároveň stropom proti zdieľaniu odkazu). */
function recordPublicationDownload(PDO $pdo, int $orderId, string $formatCode): bool
{
    // Kontrola a rezervácia musia byť atomické aj pri súbežných požiadavkách.
    $stmt = $pdo->prepare(
        "UPDATE publication_orders
         SET download_count = download_count + 1,
             last_download_at = NOW(),
             last_download_format = :format
         WHERE id = :id AND status = 'paid'
           AND (access_expires_at IS NULL OR access_expires_at >= NOW())
           AND download_count < :download_max"
    );
    $stmt->execute(['format' => $formatCode, 'id' => $orderId, 'download_max' => PUBLICATION_DOWNLOAD_MAX]);

    return $stmt->rowCount() === 1;
}

/* ─────────────────────────────── E-maily ────────────────────────────────── */

/**
 * Pošle kupujúcemu platobné pokyny vrátane variabilného symbolu a odkazu
 * na stav objednávky.
 *
 * @param array<string, mixed> $order
 */
function sendPublicationOrderInstructionsEmail(array $order, string $token): bool
{
    $bank      = publicationBankAccount();
    $seller    = publicationSeller();
    $vs        = (string) $order['variable_symbol'];
    $amount    = formatPublicationPrice((float) $order['amount_eur']);
    $orderUrl  = publicationOrderUrl($vs, $token);
    $formats   = implode(', ', publicationFormatLabels(publicationOrderFormats($order)));
    $title     = (string) $order['publication_title'];
    $dueDays   = PUBLICATION_PAYMENT_DAYS;

    $subject = 'Objednávka ' . $vs . ' — platobné pokyny · ' . EMAIL_BRAND_NAME;

    $rows = [
        'Publikácia'        => $title,
        'Formáty'           => $formats,
        'Suma'              => $amount,
        'Variabilný symbol' => $vs,
        'IBAN'              => $bank['iban_pretty'],
        'SWIFT / BIC'       => $bank['swift'],
        'Príjemca'          => $bank['recipient'],
    ];

    $rowsHtml = '';
    $rowsText = '';
    foreach ($rows as $label => $value) {
        $rowsHtml .= '<tr>'
            . '<td style="padding:6px 12px 6px 0;color:#64748b;vertical-align:top;white-space:nowrap;">'
            . escapeEmailHtml($label) . '</td>'
            . '<td style="padding:6px 0;color:#0f172a;font-weight:600;">' . escapeEmailHtml($value) . '</td>'
            . '</tr>';
        $rowsText .= $label . ': ' . $value . "\n";
    }

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň,</p>'
        . '<p style="margin:0 0 16px;">ďakujeme za objednávku publikácie <strong>'
        . escapeEmailHtml($title) . '</strong>. Na jej dokončenie uhraďte prosím sumu '
        . '<strong>' . escapeEmailHtml($amount) . '</strong> bankovým prevodom s uvedeným '
        . 'variabilným symbolom.</p>'
        . '<table role="presentation" style="margin:0 0 16px;border-collapse:collapse;font-size:15px;line-height:22px;">'
        . $rowsHtml . '</table>'
        . '<p style="margin:0 0 16px;">Platbu spárujeme podľa variabilného symbolu, zvyčajne '
        . 'do jedného pracovného dňa od pripísania na účet. Potom vám pošleme publikáciu '
        . 'e-mailom — súbory, ktoré sa zmestia do prílohy, prídu priamo v nej, '
        . 'objemnejšie stiahnete na stránke objednávky.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Stav objednávky a platobné pokyny máte '
        . 'kedykoľvek na tejto adrese:</p>'
        . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($orderUrl)
        . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($orderUrl) . '</a></p>'
        . '<p style="margin:0;color:#64748b;font-size:14px;line-height:22px;">Objednávka je '
        . 'rezervovaná ' . $dueDays . ' dní. Ak nestihnete zaplatiť, nič sa nedeje — '
        . 'objednávku jednoducho vytvorte znova. Predávajúci: '
        . escapeEmailHtml($seller['name']) . ', ' . escapeEmailHtml($seller['address'])
        . ', IČO ' . escapeEmailHtml($seller['companyId'])
        . ', DIČ ' . escapeEmailHtml($seller['taxId']) . '. '
        . escapeEmailHtml($seller['vatNote']) . '</p>';

    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Stav objednávky', $orderUrl);

    $plainMessage = 'Dobrý deň' . EMAIL_PLAIN_PARAGRAPH_BREAK
        . 'ďakujeme za objednávku publikácie ' . $title . '. Na jej dokončenie uhraďte '
        . 'sumu ' . $amount . ' bankovým prevodom s uvedeným variabilným symbolom.' . "\n\n"
        . $rowsText . "\n"
        . 'Stav objednávky:' . "\n" . $orderUrl . "\n\n"
        . 'Platbu spárujeme podľa variabilného symbolu, zvyčajne do jedného pracovného dňa '
        . 'od pripísania na účet. Potom vám pošleme publikáciu e-mailom — súbory, ktoré sa '
        . 'zmestia do prílohy, prídu priamo v nej, objemnejšie stiahnete na stránke objednávky.' . "\n\n"
        . 'Objednávka je rezervovaná ' . $dueDays . ' dní.' . "\n\n"
        . 'Predávajúci: ' . $seller['name'] . ', ' . $seller['address']
        . ', IČO ' . $seller['companyId']
        . ', DIČ ' . $seller['taxId'] . '. ' . $seller['vatNote'] . "\n\n"
        . EMAIL_BRAND_NAME;

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp((string) $order['buyer_email'], $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $plainMessage)) {
        return true;
    }

    error_log('sendPublicationOrderInstructionsEmail: SMTP zlyhalo pre objednávku ' . $vs);

    return false;
}
/**
 * SMTP konfigurácia s odosielateľom nastaveným na verejnú adresu predávajúceho.
 * Technická adresa z SMTP_FROM_EMAIL (overenia, resety) by na dodacom e-maile
 * pôsobila cudzo — kupujúci čaká odpoveď od adresy, s ktorou komunikoval.
 *
 * @return array<string, mixed>
 */
function publicationDeliveryEmailConfig(): array
{
    $cfg = getEmailEnvConfig();
    $cfg['from_email'] = PUBLICATION_DELIVERY_FROM_EMAIL;

    return $cfg;
}
/**
 * Odhadne veľkosť správy s jedným súborom v prílohe (base64 = 4/3 obsahu
 * plus zalomenie každých 76 znakov a hlavičky časti).
 */
function publicationEncodedAttachmentSize(string $path): int
{
    $bytes = (int) filesize($path);

    return (int) ceil($bytes / 3) * 4 + (int) ceil($bytes / 57) * 2 + 512;
}

/**
 * Rozvrhne formáty do dávok podľa limitu veľkosti správy.
 *
 * E-knihy majú 21 – 27 MB a v base64 narastú na ~1,37-násobok, takže do
 * jednej správy sa pri 32 MB limite WebSupportu zmestí nanajvýš jeden súbor
 * a PDF (najväčší, zároveň základný formát) sa nezmestí ani samo. Preto sa
 * neposiela jedna správa s čím sa dá, ale **dávka na správu**: každý formát
 * dostane vlastný rozpočet a kupujúci ich dostane v postupných e-mailoch.
 * Čo neprejde ani samostatne, ide odkazom na stránku objednávky — dodanie
 * tak nikdy nezávisí len od veľkosti prílohy.
 *
 * Rozpočet berieme z limitu, ktorý server ohlási v EHLO (SIZE) — ten je
 * jediný spoľahlivý; ak ho neohlási, použijeme konzervatívny fallback.
 *
 * @param array<int, string> $formats
 * @return array{batches: array<int, array<int, array{path: string, filename: string, ascii_filename: string, mime: string, code: string}>>, linked: array<int, string>}
 */
function publicationAttachmentPlan(string $slug, array $formats, string $title): array
{
    $limit = smtpProbeMaxMessageSize(publicationDeliveryEmailConfig());
    if ($limit <= 0) {
        $limit = PUBLICATION_ATTACHMENT_FALLBACK_LIMIT;
    }

    // Rezerva na hlavičky, HTML aj textovú časť správy.
    $budget     = max(0, $limit - 65536);
    $formatMeta = publicationFormats();
    $batches    = [];
    $linked     = [];
    $current    = [];
    $used       = 0;

    foreach ($formats as $code) {
        $path = publicationFilePath($slug, $code);
        if ($path === null) {
            $linked[] = $code;
            continue;
        }

        $encoded = publicationEncodedAttachmentSize($path);

        // Súbor, ktorý neprejde ani sám, prílohou poslať nevieme.
        if ($encoded > $budget) {
            $linked[] = $code;
            continue;
        }

        // Nezmestí sa do rozbehnutej dávky → uzavri ju a začni novú.
        if ($current !== [] && $used + $encoded > $budget) {
            $batches[] = $current;
            $current   = [];
            $used      = 0;
        }

        $used += $encoded;
        $filename = $title . '.' . (string) $formatMeta[$code]['ext'];
        $current[] = [
            'path'           => $path,
            'filename'       => $filename,
            'ascii_filename' => publicationAsciiFilename($filename),
            'mime'           => (string) $formatMeta[$code]['mime'],
            'code'           => $code,
        ];
    }

    if ($current !== []) {
        $batches[] = $current;
    }

    return ['batches' => $batches, 'linked' => $linked];
}

/**
 * CLI-only náhrada SMTP pre test doručenia. Vo webovom SAPI sa ignoruje,
 * takže požiadavka z prehliadača ňou neodošle poštu ani neobíde platbu.
 */
function publicationDeliverySmtpTestHook(): ?callable
{
    if (PHP_SAPI !== 'cli' || !isset($GLOBALS['NEFRO_TEST_PUBLICATION_SMTP'])) {
        return null;
    }

    $hook = $GLOBALS['NEFRO_TEST_PUBLICATION_SMTP'];

    return is_callable($hook) ? $hook : null;
}

/**
 * Jedna dodacia správa. Príloha ide cez SMTP s prílohami, správa bez prílohy
 * cez bežné SMTP. Technická adresa je tá istá funkcia s inou konfiguráciou
 * odosielateľa — test aj produkcia tak vidia obe cesty oddelene.
 *
 * @param array<string, mixed> $cfg
 * @param array<int, array<string, mixed>> $attachments
 * @param array<string, string> $extraHeaders
 */
function publicationDeliverSmtpMessage(
    string $toEmail,
    string $subject,
    string $html,
    array $cfg,
    string $plainText,
    array $attachments,
    array $extraHeaders
): bool {
    $hook = publicationDeliverySmtpTestHook();
    if ($hook !== null) {
        return (bool) $hook($toEmail, $subject, $html, $cfg, $plainText, $attachments, $extraHeaders);
    }

    if ($attachments !== []) {
        return sendViaSmtpWithAttachments(
            $toEmail,
            $subject,
            $html,
            $cfg,
            $plainText,
            $attachments,
            $extraHeaders
        );
    }

    return sendViaSmtp(
        $toEmail,
        $subject,
        $html,
        $cfg,
        EMAIL_CONTENT_TYPE_HTML,
        $plainText,
        $extraHeaders
    );
}

/**
 * Kroky záchrany, keď úvodná dodacia správa zlyhá.
 *
 * Predvolený nákup je len PDF. PDF sa do e-mailovej prílohy nezmestí, takže
 * `$firstBatch` je prázdny a správa ide odkazom. Ak server odmietne
 * `PUBLICATION_DELIVERY_FROM_EMAIL` (typicky nie je SMTP-autentifikovaná),
 * jediná záchrana je technická adresa. Staršia podmienka
 * `$firstBatch !== []` tento krok preskočila — potvrdenie platby sa
 * nedoručilo a tlačidlo „Poslať dodací e-mail“ zlyhalo rovnako.
 *
 * @return list<'unattached'|'technical'>
 */
function publicationDeliveryIntroFallbackPlan(bool $hadAttachments): array
{
    $plan = [];
    if ($hadAttachments) {
        $plan[] = 'unattached';
    }
    $plan[] = 'technical';

    return $plan;
}

/**
 * Pošle kupujúcemu potvrdenie platby a samotnú publikáciu.
 *
 * Do jednej správy sa pri 32 MB limite zmestí nanajvýš jeden súbor, preto sa
 * dávky posielajú ako postupné e-maily („časť 2 z 3“). Formáty, ktoré sa
 * nezmestia ani samostatne (PDF má po zakódovaní ~37 MB), dostane kupujúci
 * odkazom na stránku objednávky — tá po zaplatení sťahovanie odomkne. Odkaz je
 * ten istý ako v platobných pokynoch, takže kupujúci nemusí držať dve adresy.
 *
 * Prvá správa je vždy úvodná (potvrdenie platby a prehľad) a odošle sa aj
 * vtedy, keď k nej žiadna príloha nie je. Ak odoslanie s prílohou zlyhá
 * (server ju odmietne, spojenie spadne), formát prepadne medzi odkazované —
 * dodanie nesmie zostať visieť na veľkosti súboru.
 *
 * @param array<string, mixed> $order
 * @return array{sent: bool, attached: array<int, string>, linked: array<int, string>}
 */
function sendPublicationOrderDeliveryEmail(array $order, string $token): array
{
    $vs       = (string) $order['variable_symbol'];
    $title    = (string) $order['publication_title'];
    $slug     = (string) $order['publication_slug'];
    $formats  = publicationOrderFormats($order);
    $amount   = formatPublicationPrice((float) $order['amount_eur']);
    $orderUrl = publicationOrderUrl($vs, $token);
    $years    = (int) round(PUBLICATION_ACCESS_DAYS / 365);
    $seller   = publicationSeller();

    $plan     = publicationAttachmentPlan($slug, $formats, $title);
    $batches  = $plan['batches'];
    $linked   = $plan['linked'];
    $attached = [];

    $cfg          = publicationDeliveryEmailConfig();
    $extraHeaders = ['Reply-To' => PUBLICATION_DELIVERY_FROM_EMAIL];
    $recipient    = (string) $order['buyer_email'];
    $batchCount   = count($batches);

    $footerHtml = '<p style="margin:0;color:#64748b;font-size:14px;line-height:22px;">'
        . 'Súbory sú bez DRM a určené na vaše osobné použitie. Predávajúci: '
        . escapeEmailHtml($seller['name']) . ', ' . escapeEmailHtml($seller['address'])
        . ', IČO ' . escapeEmailHtml($seller['companyId'])
        . ', DIČ ' . escapeEmailHtml($seller['taxId']) . '. '
        . escapeEmailHtml($seller['vatNote']) . '</p>';
    $footerText = 'Súbory sú bez DRM a určené na vaše osobné použitie.' . "\n\n"
        . 'Predávajúci: ' . $seller['name'] . ', ' . $seller['address']
        . ', IČO ' . $seller['companyId']
        . ', DIČ ' . $seller['taxId'] . '. ' . $seller['vatNote'] . "\n\n"
        . EMAIL_BRAND_NAME;

    /**
     * Vykreslí a odošle jednu správu dodania.
     *
     * @param array<int, array{path: string, filename: string, ascii_filename: string, mime: string, code: string}> $attachments
     */
    $sendMessage = static function (
        string $subject,
        string $bodyHtml,
        string $bodyText,
        array $attachments
    ) use ($recipient, $cfg, $extraHeaders, $orderUrl, $footerHtml, $footerText): bool {
        $html = renderEmailHtmlLayout($bodyHtml . $footerHtml, 'Stránka objednávky', $orderUrl);
        $text = $bodyText . $footerText;

        return publicationDeliverSmtpMessage(
            $recipient,
            $subject,
            $html,
            $cfg,
            $text,
            $attachments,
            $extraHeaders
        );
    };

    /**
     * Štítky formátov v dávke, pripravené do vety.
     *
     * @param array<int, array{code: string}> $batch
     */
    $batchLabels = static function (array $batch): string {
        return implode(', ', publicationFormatLabels(
            array_map(static fn (array $a): string => $a['code'], $batch)
        ));
    };

    // ── 1. Úvodná správa (potvrdenie platby + prvá dávka príloh) ────────────
    $firstBatch = $batches[0] ?? [];

    $introHtml = '<p style="margin:0 0 16px;">Dobrý deň,</p>'
        . '<p style="margin:0 0 16px;">platbu ' . escapeEmailHtml($amount) . ' za objednávku '
        . '<strong>' . escapeEmailHtml($vs) . '</strong> sme prijali. Ďakujeme.</p>';
    $introText = 'Dobrý deň' . EMAIL_PLAIN_PARAGRAPH_BREAK
        . 'platbu ' . $amount . ' za objednávku ' . $vs . ' sme prijali. Ďakujeme.' . "\n\n";

    if ($firstBatch !== []) {
        $labels = $batchLabels($firstBatch);
        $introHtml .= '<p style="margin:0 0 16px;">V prílohe tohto e-mailu nájdete publikáciu '
            . '<strong>' . escapeEmailHtml($title) . '</strong> vo formáte '
            . escapeEmailHtml($labels) . '.</p>';
        $introText .= 'V prílohe tohto e-mailu nájdete publikáciu ' . $title
            . ' vo formáte ' . $labels . '.' . "\n\n";
    }

    if ($batchCount > 1) {
        $restLabels = [];
        foreach (array_slice($batches, 1) as $batch) {
            $restLabels[] = $batchLabels($batch);
        }
        $rest = implode(', ', $restLabels);
        $introHtml .= '<p style="margin:0 0 16px;">Ostatné formáty ('
            . escapeEmailHtml($rest) . ') posielame v samostatných e-mailoch — '
            . 'do jednej správy sa súbory tejto veľkosti nezmestia.</p>';
        $introText .= 'Ostatné formáty (' . $rest . ') posielame v samostatných e-mailoch — '
            . 'do jednej správy sa súbory tejto veľkosti nezmestia.' . "\n\n";
    }

    if ($linked !== []) {
        $labels = implode(', ', publicationFormatLabels($linked));
        $reason = $batches === []
            ? 'Súbory sú na e-mailovú prílohu príliš veľké, preto ich stiahnete na stránke objednávky'
            : 'Formát ' . $labels . ' je na e-mailovú prílohu príliš veľký — stiahnete ho na stránke objednávky';
        $introHtml .= '<p style="margin:0 0 16px;">' . escapeEmailHtml($reason) . ':</p>'
            . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($orderUrl)
            . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($orderUrl) . '</a></p>';
        $introText .= $reason . ':' . "\n" . $orderUrl . "\n\n";
    }

    $introHtml .= '<p style="margin:0 0 16px;color:#334155;">Tento e-mail si odložte — je zároveň '
        . 'vaším dokladom o prístupe. Sťahovanie na stránke objednávky je platné '
        . $years . ' roky, so stropom ' . PUBLICATION_DOWNLOAD_MAX . ' stiahnutí.</p>';
    $introText .= 'Tento e-mail si odložte — je zároveň vaším dokladom o prístupe. '
        . 'Sťahovanie na stránke objednávky je platné ' . $years . ' roky, so stropom '
        . PUBLICATION_DOWNLOAD_MAX . ' stiahnutí.' . "\n\n"
        . 'Stránka objednávky: ' . $orderUrl . "\n\n";

    $introSubject = 'Vaša publikácia ' . $title . ' · ' . EMAIL_BRAND_NAME;
    if ($batchCount > 1) {
        $introSubject = 'Vaša publikácia ' . $title . ' (časť 1 z ' . $batchCount . ') · ' . EMAIL_BRAND_NAME;
    }

    $firstSent = $sendMessage($introSubject, $introHtml, $introText, $firstBatch);

    if ($firstSent) {
        foreach ($firstBatch as $attachment) {
            $attached[] = $attachment['code'];
        }
    } else {
        if ($firstBatch !== []) {
            error_log('sendPublicationOrderDeliveryEmail: príloha v úvodnej správe zlyhala pre VS ' . $vs);
            foreach ($firstBatch as $attachment) {
                $linked[] = $attachment['code'];
            }
        } else {
            error_log('sendPublicationOrderDeliveryEmail: úvodná správa bez prílohy zlyhala pre VS ' . $vs);
        }

        $fallbackHtml = '<p style="margin:0 0 16px;">Dobrý deň,</p>'
            . '<p style="margin:0 0 16px;">platbu ' . escapeEmailHtml($amount) . ' za objednávku '
            . '<strong>' . escapeEmailHtml($vs) . '</strong> sme prijali. Publikácia <strong>'
            . escapeEmailHtml($title) . '</strong> je pripravená vo formátoch '
            . escapeEmailHtml(implode(', ', publicationFormatLabels($formats))) . '.</p>'
            . '<p style="margin:0 0 16px;">Súbory sa do e-mailovej prílohy nezmestili, '
            . 'preto ich stiahnete na stránke objednávky:</p>'
            . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($orderUrl)
            . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($orderUrl) . '</a></p>'
            . '<p style="margin:0 0 16px;color:#334155;">Prístup je platný ' . $years
            . ' roky, so stropom ' . PUBLICATION_DOWNLOAD_MAX . ' stiahnutí.</p>';
        $fallbackText = 'Dobrý deň' . EMAIL_PLAIN_PARAGRAPH_BREAK
            . 'platbu ' . $amount . ' za objednávku ' . $vs . ' sme prijali. Publikácia '
            . $title . ' je pripravená vo formátoch '
            . implode(', ', publicationFormatLabels($formats)) . '.' . "\n\n"
            . 'Súbory sa do e-mailovej prílohy nezmestili, preto ich stiahnete tu:' . "\n"
            . $orderUrl . "\n\n"
            . 'Prístup je platný ' . $years . ' roky, so stropom '
            . PUBLICATION_DOWNLOAD_MAX . ' stiahnutí.' . "\n\n";

        foreach (publicationDeliveryIntroFallbackPlan($firstBatch !== []) as $step) {
            if ($firstSent) {
                break;
            }

            if ($step === 'unattached') {
                $firstSent = $sendMessage(
                    'Vaša publikácia ' . $title . ' · ' . EMAIL_BRAND_NAME,
                    $fallbackHtml,
                    $fallbackText,
                    []
                );
                continue;
            }

            // Technická adresa — niektoré servery odmietnu MAIL FROM, ktorý
            // nie je autentifikovaný, a dodanie by sa stratilo len preto,
            // že sme chceli pekného odosielateľa. Musí sa skúsiť aj keď
            // úvodná správa nemala prílohu (predvolený nákup len PDF).
            $firstSent = publicationDeliverSmtpMessage(
                $recipient,
                'Vaša publikácia ' . $title . ' · ' . EMAIL_BRAND_NAME,
                renderEmailHtmlLayout($fallbackHtml . $footerHtml, 'Stiahnuť publikáciu', $orderUrl),
                getEmailEnvConfig(),
                $fallbackText . $footerText,
                [],
                $extraHeaders
            );
            if ($firstSent) {
                error_log('sendPublicationOrderDeliveryEmail: VS ' . $vs
                    . ' odoslané z technickej adresy — ' . PUBLICATION_DELIVERY_FROM_EMAIL
                    . ' server odmietol.');
            }
        }
    }

    // ── 2. Ďalšie dávky ako samostatné správy ──────────────────────────────
    foreach (array_slice($batches, 1) as $index => $batch) {
        $part    = $index + 2;
        $labels  = $batchLabels($batch);
        $subject = 'Vaša publikácia ' . $title . ' (časť ' . $part . ' z ' . $batchCount . ') · '
            . EMAIL_BRAND_NAME;

        $bodyHtml = '<p style="margin:0 0 16px;">Dobrý deň,</p>'
            . '<p style="margin:0 0 16px;">v prílohe posielame publikáciu <strong>'
            . escapeEmailHtml($title) . '</strong> vo formáte ' . escapeEmailHtml($labels)
            . ' — časť ' . $part . ' z ' . $batchCount . ' k objednávke <strong>'
            . escapeEmailHtml($vs) . '</strong>.</p>';
        $bodyText = 'Dobrý deň' . EMAIL_PLAIN_PARAGRAPH_BREAK
            . 'v prílohe posielame publikáciu ' . $title . ' vo formáte ' . $labels
            . ' — časť ' . $part . ' z ' . $batchCount . ' k objednávke ' . $vs . '.' . "\n\n"
            . 'Stránka objednávky: ' . $orderUrl . "\n\n";

        if ($sendMessage($subject, $bodyHtml, $bodyText, $batch)) {
            foreach ($batch as $attachment) {
                $attached[] = $attachment['code'];
            }
        } else {
            error_log('sendPublicationOrderDeliveryEmail: časť ' . $part . ' zlyhala pre VS ' . $vs);
            foreach ($batch as $attachment) {
                $linked[] = $attachment['code'];
            }
        }
    }

    if (!$firstSent) {
        error_log('sendPublicationOrderDeliveryEmail: SMTP zlyhalo pre objednávku ' . $vs);
    }

    return [
        'sent'     => $firstSent,
        'attached' => $attached,
        'linked'   => array_values(array_unique($linked)),
    ];
}

/**
 * Interné avízo o novej objednávke. Bez tohto e-mailu by predávajúci
 * o objednávke nevedel, kým sám nepozrie do administrácie.
 *
 * @param array<string, mixed> $order
 */
function sendPublicationOrderAdminNotice(array $order): bool
{
    $seller  = publicationSeller();
    $vs      = (string) $order['variable_symbol'];
    $formats = implode(', ', publicationFormatLabels(publicationOrderFormats($order)));
    $amount  = formatPublicationPrice((float) $order['amount_eur']);
    $adminUrl = 'https://nefro.polascin.net/admin_publication_orders.php';

    $subject = 'Nová objednávka publikácie ' . $vs . ' · ' . EMAIL_BRAND_NAME;

    $lines = [
        'Variabilný symbol: ' . $vs,
        'Publikácia: ' . (string) $order['publication_title'],
        'Formáty: ' . $formats,
        'Suma: ' . $amount,
        'Kupujúci: ' . (string) $order['buyer_email'],
        'Meno: ' . ((string) $order['buyer_name'] !== '' ? (string) $order['buyer_name'] : '—'),
        'Firma: ' . ((string) $order['buyer_company'] !== '' ? (string) $order['buyer_company'] : '—'),
        'IČO: ' . ((string) $order['buyer_company_id'] !== '' ? (string) $order['buyer_company_id'] : '—'),
        'Čas servera: ' . date(EMAIL_DATETIME_FORMAT),
    ];

    $htmlBody = '<p style="margin:0 0 16px;">Nová objednávka publikácie čaká na úhradu.</p>'
        . '<ul style="margin:0 0 16px;padding-left:20px;color:#0f172a;">'
        . implode('', array_map(
            static fn (string $line): string => '<li>' . escapeEmailHtml($line) . '</li>',
            $lines
        ))
        . '</ul>'
        . '<p style="margin:0;color:#64748b;font-size:14px;">Po pripísaní platby ju potvrďte '
        . 'v administrácii objednávok — kupujúcemu sa automaticky pošle odkaz na stiahnutie.</p>';

    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Objednávky publikácií', $adminUrl);
    $plainMessage = "Nová objednávka publikácie čaká na úhradu.\n\n"
        . implode("\n", $lines) . "\n\n" . $adminUrl . "\n\n" . EMAIL_BRAND_NAME;

    $cfg = getEmailEnvConfig();

    return sendViaSmtp($seller['email'], $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $plainMessage);
}
