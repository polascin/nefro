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
 * @param array<int, string>   $requested
 * @return array<int, string>
 */
function normalizePublicationFormats(array $publication, array $requested): array
{
    /** @var array<int, string> $offered */
    $offered   = $publication['formats'];
    $requested = array_map(static fn ($code): string => strtolower(trim((string) $code)), $requested);

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
             buyer_address, buyer_note, token_salt, status,
             payment_due_at, created_ip, created_user_agent)
         VALUES
            (:slug, :title, :formats, :amount, 'EUR',
             :email, :name, :company, :company_id, :tax_id,
             :address, :note, :token_salt, 'awaiting_payment',
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
function recordPublicationDownload(PDO $pdo, int $orderId, string $formatCode): void
{
    $pdo->prepare(
        "UPDATE publication_orders
         SET download_count = download_count + 1,
             last_download_at = NOW(),
             last_download_format = :format
         WHERE id = :id"
    )->execute(['format' => $formatCode, 'id' => $orderId]);
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

    $plainMessage = 'Dobrý deň,' . EMAIL_PLAIN_PARAGRAPH_BREAK
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

        if ($attachments !== []) {
            return sendViaSmtpWithAttachments(
                $recipient,
                $subject,
                $html,
                $cfg,
                $text,
                $attachments,
                $extraHeaders
            );
        }

        return sendViaSmtp($recipient, $subject, $html, $cfg, EMAIL_CONTENT_TYPE_HTML, $text, $extraHeaders);
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
    $introText = 'Dobrý deň,' . EMAIL_PLAIN_PARAGRAPH_BREAK
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
    } elseif ($firstBatch !== []) {
        // Príloha neprešla — pošli aspoň úvodnú správu s odkazom, inak kupujúci
        // nevie ani to, že platba dorazila.
        error_log('sendPublicationOrderDeliveryEmail: príloha v úvodnej správe zlyhala pre VS ' . $vs);
        foreach ($firstBatch as $attachment) {
            $linked[] = $attachment['code'];
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
        $fallbackText = 'Dobrý deň,' . EMAIL_PLAIN_PARAGRAPH_BREAK
            . 'platbu ' . $amount . ' za objednávku ' . $vs . ' sme prijali. Publikácia '
            . $title . ' je pripravená vo formátoch '
            . implode(', ', publicationFormatLabels($formats)) . '.' . "\n\n"
            . 'Súbory sa do e-mailovej prílohy nezmestili, preto ich stiahnete tu:' . "\n"
            . $orderUrl . "\n\n"
            . 'Prístup je platný ' . $years . ' roky, so stropom '
            . PUBLICATION_DOWNLOAD_MAX . ' stiahnutí.' . "\n\n";

        $firstSent = $sendMessage(
            'Vaša publikácia ' . $title . ' · ' . EMAIL_BRAND_NAME,
            $fallbackHtml,
            $fallbackText,
            []
        );

        if (!$firstSent) {
            // Poslednou možnosťou je technická adresa — niektoré servery odmietnu
            // MAIL FROM s adresou, ktorá nie je tá autentifikovaná, a dodanie by sa
            // stratilo len preto, že sme chceli pekného odosielateľa.
            $firstSent = sendViaSmtp(
                $recipient,
                'Vaša publikácia ' . $title . ' · ' . EMAIL_BRAND_NAME,
                renderEmailHtmlLayout($fallbackHtml . $footerHtml, 'Stiahnuť publikáciu', $orderUrl),
                getEmailEnvConfig(),
                EMAIL_CONTENT_TYPE_HTML,
                $fallbackText . $footerText,
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
        $bodyText = 'Dobrý deň,' . EMAIL_PLAIN_PARAGRAPH_BREAK
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
