<?php

declare(strict_types=1);

putenv('DATA_PROTECTION_KEY=nefro-publication-delivery-test-key');
$_ENV['DATA_PROTECTION_KEY'] = 'nefro-publication-delivery-test-key';

require_once __DIR__ . '/../publications_common.php';

$assertions = 0;

function publicationDeliveryTestSame(mixed $expected, mixed $actual, string $message): void
{
    global $assertions;
    $assertions++;
    if ($expected !== $actual) {
        throw new RuntimeException(
            $message . ': očakávané ' . var_export($expected, true) .
            ', získané ' . var_export($actual, true),
        );
    }
}

function publicationDeliveryTest(bool $condition, string $message): void
{
    global $assertions;
    $assertions++;
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

// Predvolený nákup (len PDF) ide celý odkazom — úvodná správa nemá prílohu.
// Technická adresa sa musí skúsiť aj vtedy, inak potvrdenie platby zmizne,
// keď server odmietne PUBLICATION_DELIVERY_FROM_EMAIL.
publicationDeliveryTestSame(
    ['technical'],
    publicationDeliveryIntroFallbackPlan(false),
    'bez prílohy nasleduje hneď technická adresa',
);

publicationDeliveryTestSame(
    ['unattached', 'technical'],
    publicationDeliveryIntroFallbackPlan(true),
    'po zlyhaní prílohy najprv správa bez prílohy, potom technická adresa',
);

/**
 * @return array<string, mixed>
 */
function publicationDeliveryTestOrder(string $formats): array
{
    return [
        'id' => 7,
        'variable_symbol' => '2026000007',
        'publication_title' => 'SK Nefro Báza 1',
        'publication_slug' => 'sk-nefro-baza-1',
        'formats' => $formats,
        'amount_eur' => $formats === 'pdf' ? '7.00' : '12.00',
        'buyer_email' => 'buyer@example.com',
        'token_salt' => 'salt-delivery-test',
        'status' => 'paid',
    ];
}

/**
 * @param list<array{from: string, attachments: int, text: string}> $calls
 */
function publicationDeliveryInstallSmtp(array &$calls, callable $decide): void
{
    $GLOBALS['__smtpMaxMessageSize'] = 32 * 1024 * 1024;
    $GLOBALS['NEFRO_TEST_PUBLICATION_SMTP'] = static function (
        string $toEmail,
        string $subject,
        string $html,
        array $cfg,
        string $plainText,
        array $attachments,
        array $extraHeaders
    ) use (&$calls, $decide): bool {
        unset($toEmail, $subject, $html, $extraHeaders);
        $call = [
            'from' => (string) ($cfg['from_email'] ?? ''),
            'attachments' => count($attachments),
            'text' => $plainText,
        ];
        $calls[] = $call;

        return (bool) $decide($call, count($calls));
    };
}

function publicationDeliveryResetSmtp(): void
{
    unset($GLOBALS['NEFRO_TEST_PUBLICATION_SMTP']);
}

$technicalFrom = (string) getEmailEnvConfig()['from_email'];
publicationDeliveryTest(
    $technicalFrom !== PUBLICATION_DELIVERY_FROM_EMAIL,
    'technický odosielateľ sa v teste líši od verejnej adresy dodania',
);

$pdfCalls = [];
publicationDeliveryInstallSmtp(
    $pdfCalls,
    static fn (array $call): bool => $call['from'] !== PUBLICATION_DELIVERY_FROM_EMAIL,
);
$pdfOrder = publicationDeliveryTestOrder('pdf');
$pdfToken = publicationOrderToken($pdfOrder);
$pdfResult = sendPublicationOrderDeliveryEmail($pdfOrder, $pdfToken);
publicationDeliveryResetSmtp();

publicationDeliveryTest($pdfResult['sent'] === true, 'PDF bez prílohy sa po páde bežného SMTP doručí technickou adresou');
publicationDeliveryTestSame(2, count($pdfCalls), 'bez prílohy sú presne dva pokusy: bežný odosielateľ a technický');
publicationDeliveryTestSame(PUBLICATION_DELIVERY_FROM_EMAIL, $pdfCalls[0]['from'], 'prvý pokus ide z verejnej adresy');
publicationDeliveryTestSame(0, $pdfCalls[0]['attachments'], 'predvolené PDF nemá prílohu');
publicationDeliveryTestSame($technicalFrom, $pdfCalls[1]['from'], 'druhý pokus ide z technickej adresy');
publicationDeliveryTestSame(0, $pdfCalls[1]['attachments'], 'technická záchrana PDF je tiež bez prílohy');
publicationDeliveryTest(
    str_contains($pdfCalls[1]['text'], publicationOrderUrl('2026000007', $pdfToken)),
    'technická správa nesie podpísaný odkaz objednávky',
);
publicationDeliveryTest(
    !str_contains($pdfCalls[1]['text'], 'objednavka.php?id='),
    'odkaz nepoužíva holé ID objednávky',
);

$okCalls = [];
publicationDeliveryInstallSmtp($okCalls, static fn (): bool => true);
$okResult = sendPublicationOrderDeliveryEmail($pdfOrder, $pdfToken);
publicationDeliveryResetSmtp();
publicationDeliveryTest($okResult['sent'] === true && count($okCalls) === 1, 'úspech bežného odosielateľa technickú adresu nespúšťa');

$epubDir = PUBLICATION_FILES_DIR . '/sk-nefro-baza-1';
$epubPath = $epubDir . '/sk-nefro-baza-1.epub';
if (!is_dir($epubDir) && !mkdir($epubDir, 0700, true) && !is_dir($epubDir)) {
    throw new RuntimeException('Nepodarilo sa pripraviť dočasný súbor publikácie.');
}
$epubCreated = !is_file($epubPath);
file_put_contents($epubPath, 'publication-delivery-test');

try {
    $epubCalls = [];
    publicationDeliveryInstallSmtp(
        $epubCalls,
        static fn (array $call): bool => $call['from'] !== PUBLICATION_DELIVERY_FROM_EMAIL,
    );
    $epubOrder = publicationDeliveryTestOrder('epub');
    $epubResult = sendPublicationOrderDeliveryEmail($epubOrder, publicationOrderToken($epubOrder));
    publicationDeliveryResetSmtp();

    publicationDeliveryTest($epubResult['sent'] === true, 'objednávka s prílohou sa po páde SMTP doručí');
    publicationDeliveryTestSame(3, count($epubCalls), 's prílohou sú tri pokusy: príloha, bez prílohy, technická adresa');
    publicationDeliveryTest(
        $epubCalls[0]['from'] === PUBLICATION_DELIVERY_FROM_EMAIL && $epubCalls[0]['attachments'] === 1,
        'prvý pokus nesie prílohu z verejnej adresy',
    );
    publicationDeliveryTest(
        $epubCalls[1]['from'] === PUBLICATION_DELIVERY_FROM_EMAIL && $epubCalls[1]['attachments'] === 0,
        'druhý pokus je tá istá verejná adresa už bez prílohy',
    );
    publicationDeliveryTestSame($technicalFrom, $epubCalls[2]['from'], 'tretí pokus je technická adresa');
    publicationDeliveryTest($epubResult['attached'] === [] && in_array('epub', $epubResult['linked'], true), 'zlyhaná príloha prejde do odkazu');
} finally {
    publicationDeliveryResetSmtp();
    if ($epubCreated) {
        @unlink($epubPath);
    }
}

$resendCalls = [];
publicationDeliveryInstallSmtp(
    $resendCalls,
    static fn (array $call): bool => $call['from'] !== PUBLICATION_DELIVERY_FROM_EMAIL,
);
$resendFirst = sendPublicationOrderDeliveryEmail($pdfOrder, $pdfToken);
$resendSecond = sendPublicationOrderDeliveryEmail($pdfOrder, $pdfToken);
publicationDeliveryResetSmtp();
publicationDeliveryTest(
    $resendFirst['sent'] === true && $resendSecond['sent'] === true && count($resendCalls) === 4,
    'opätovné odoslanie z administrácie je druhá dodávka, nie druhý pokus v tej istej správe',
);

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec(
    'CREATE TABLE publication_orders (
        id INTEGER PRIMARY KEY,
        status TEXT,
        paid_at TEXT,
        access_expires_at TEXT,
        payment_note TEXT,
        variable_symbol TEXT,
        token_salt TEXT
    )'
);
$pdo->exec(
    "INSERT INTO publication_orders
        (id, status, paid_at, access_expires_at, payment_note, variable_symbol, token_salt)
     VALUES (7, 'awaiting_payment', NULL, NULL, NULL, '2026000007', 'salt-delivery-test')"
);

$deliveryCount = 0;
$confirmAndDeliver = static function () use ($pdo, $pdfOrder, $pdfToken, &$deliveryCount): bool {
    if (!markPublicationOrderPaid($pdo, 7, null)) {
        return false;
    }
    $sent = sendPublicationOrderDeliveryEmail($pdfOrder, $pdfToken);
    if ($sent['sent']) {
        $deliveryCount++;
    }

    return true;
};

$confirmCalls = [];
publicationDeliveryInstallSmtp(
    $confirmCalls,
    static fn (array $call): bool => $call['from'] !== PUBLICATION_DELIVERY_FROM_EMAIL,
);
publicationDeliveryTest($confirmAndDeliver(), 'prvé potvrdenie platby prejde');
$paidRow = $pdo->query('SELECT status, paid_at, access_expires_at FROM publication_orders WHERE id = 7')->fetch(PDO::FETCH_ASSOC);
publicationDeliveryTest(
    is_array($paidRow) && $paidRow['status'] === 'paid' && $paidRow['paid_at'] !== null && $paidRow['access_expires_at'] !== null,
    'prvé potvrdenie zapíše úhradu aj platnosť prístupu',
);
publicationDeliveryTest(!$confirmAndDeliver(), 'druhé potvrdenie platby sa odmietne');
$paidAgain = $pdo->query('SELECT status, paid_at, access_expires_at FROM publication_orders WHERE id = 7')->fetch(PDO::FETCH_ASSOC);
publicationDeliveryTest($paidAgain === $paidRow, 'odmietnuté druhé potvrdenie nemení záznam úhrady');
publicationDeliveryTest($deliveryCount === 1, 'druhé potvrdenie znova nedoručí publikáciu');
$resend = sendPublicationOrderDeliveryEmail($pdfOrder, $pdfToken);
publicationDeliveryResetSmtp();
publicationDeliveryTest($resend['sent'] === true && $deliveryCount === 1, 'ručné opätovné dodanie nie je druhé potvrdenie platby');
publicationDeliveryTest(!markPublicationOrderPaid($pdo, 999, null), 'potvrdenie neexistujúcej objednávky nič nezapíše');

$lookup = new PDO('sqlite::memory:');
$lookup->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$lookup->exec(
    'CREATE TABLE publication_orders (
        id INTEGER PRIMARY KEY,
        variable_symbol TEXT,
        token_salt TEXT,
        status TEXT,
        access_expires_at TEXT,
        download_count INTEGER
    )'
);
$openOrder = [
    'id' => 7,
    'variable_symbol' => '2026000007',
    'token_salt' => 'salt-open',
    'status' => 'paid',
    'access_expires_at' => '2099-01-01 00:00:00',
    'download_count' => 0,
];
$otherSalt = $openOrder;
$otherSalt['token_salt'] = 'salt-other';
$lookup->prepare(
    'INSERT INTO publication_orders
        (id, variable_symbol, token_salt, status, access_expires_at, download_count)
     VALUES (:id, :vs, :salt, :status, :expires, :downloads)'
)->execute([
    'id' => 7,
    'vs' => '2026000007',
    'salt' => 'salt-open',
    'status' => 'paid',
    'expires' => '2099-01-01 00:00:00',
    'downloads' => 0,
]);

$goodToken = publicationOrderToken($openOrder);
publicationDeliveryTest($goodToken !== '7' && $goodToken !== '2026000007', 'token nie je ID ani variabilný symbol');
publicationDeliveryTest(!str_contains($goodToken, '+') && !str_contains($goodToken, '/'), 'token je v neuhádnuteľnom tvare bez štandardného base64');
publicationDeliveryTest(strlen($goodToken) >= 40, 'token má dĺžku HMAC, nie krátke poradové číslo');
publicationDeliveryTest(
    publicationOrderToken($openOrder) === $goodToken,
    'ten istý podpis sa dá z objednávky odvodiť znova',
);
publicationDeliveryTest(
    publicationOrderToken($otherSalt) !== $goodToken,
    'iná soľ, akú nastaví obnova prístupu, podpis zmení',
);

$found = findPublicationOrderByToken($lookup, '2026000007', $goodToken);
publicationDeliveryTest(is_array($found) && (int) $found['id'] === 7, 'platný podpis otvorí svoju objednávku');
publicationDeliveryTest(findPublicationOrderByToken($lookup, '2026000007', '') === null, 'prázdny token nič neotvorí');
publicationDeliveryTest(findPublicationOrderByToken($lookup, '2026000007', '7') === null, 'holé ID namiesto podpisu nič neotvorí');
$tampered = substr($goodToken, 0, -1) . ($goodToken[-1] === 'a' ? 'b' : 'a');
publicationDeliveryTest(findPublicationOrderByToken($lookup, '2026000007', $tampered) === null, 'zmenený podpis nič neotvorí');
publicationDeliveryTest(findPublicationOrderByToken($lookup, 'abc', $goodToken) === null, 'nečíselný variabilný symbol sa odmietne skôr, než sa porovná podpis');
publicationDeliveryTest(findPublicationOrderByToken($lookup, '2026000999', $goodToken) === null, 'podpis inej objednávky sa k cudziemu symbolu nehodí');

$awaiting = $openOrder;
$awaiting['status'] = 'awaiting_payment';
publicationDeliveryTest(!publicationOrderIsDownloadable($awaiting), 'neuhradená objednávka sa nestiahne');
$expired = $openOrder;
$expired['access_expires_at'] = '2000-01-01 00:00:00';
publicationDeliveryTest(!publicationOrderIsDownloadable($expired), 'po expirácii prístupu sa súbor nestiahne');
$exhausted = $openOrder;
$exhausted['download_count'] = PUBLICATION_DOWNLOAD_MAX;
publicationDeliveryTest(!publicationOrderIsDownloadable($exhausted), 'vyčerpaný limit stiahnutí prístup zatvorí');
publicationDeliveryTest(publicationOrderIsDownloadable($openOrder), 'zaplatená objednávka v platnosti sa stiahnuť dá');

$orderUrl = publicationOrderUrl('2026000007', $goodToken);
publicationDeliveryTest(
    str_contains($orderUrl, 'vs=2026000007') && str_contains($orderUrl, 't=' . rawurlencode($goodToken)),
    'odkaz nesie variabilný symbol aj podpis',
);
publicationDeliveryTest(!str_contains($orderUrl, 'id=7'), 'odkaz neobsahuje holé ID');

echo 'Dodanie publikácie: ' . $assertions . " kontroly prešli.\n";
