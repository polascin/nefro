<?php

declare(strict_types=1);

putenv('DATA_PROTECTION_KEY=nefro-publication-stripe-test-key');
$_ENV['DATA_PROTECTION_KEY'] = 'nefro-publication-stripe-test-key';

require_once __DIR__ . '/../publications_common.php';

$checks = 0;

function publicationStripeTest(bool $condition, string $label): void
{
    global $checks;
    $checks++;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

/**
 * @return array{url: string, exact: bool, query: array<string, string>}
 */
function publicationStripeCheckedUrl(float $amount, string $variableSymbol, string $email = ''): array
{
    $built = publicationStripeUrl($amount, $variableSymbol, $email);
    if ($built === null) {
        throw new RuntimeException('Stripe odkaz pre ' . $amount . ' chýba.');
    }

    $parts = parse_url($built['url']);
    $query = [];
    parse_str((string) ($parts['query'] ?? ''), $query);
    /** @var array<string, string> $query */

    return [
        'url' => $built['url'],
        'exact' => $built['exact'],
        'query' => $query,
        'host' => (string) ($parts['host'] ?? ''),
        'path' => (string) ($parts['path'] ?? ''),
    ];
}

$single = 'https://buy.stripe.com/cNi9AN1fs51B95OeWOfMA01';
$bundle = 'https://buy.stripe.com/3cI6oB5vIcu35TCcOGfMA02';
$donate = 'https://donate.stripe.com/8x2fZb0bo3Xxdm4cOGfMA00';
$cfg = publicationPaymentConfig();

publicationStripeTest($cfg['stripe_links']['7.00'] === $single, '7.00 je existujúci nákupný odkaz jedného formátu');
publicationStripeTest($cfg['stripe_links']['12.00'] === $bundle, '12.00 je existujúci nákupný odkaz balíka');
publicationStripeTest($cfg['stripe_fallback'] === $donate, 'donate odkaz ostáva len ako záloha podpory');
publicationStripeTest($cfg['stripe_links']['7.00'] !== $donate && $cfg['stripe_links']['12.00'] !== $donate, 'donate nie je predvolený nákup');

$one = publicationStripeCheckedUrl(7.00, '2026000007', 'buyer@example.com');
publicationStripeTest($one['exact'] === true, '7 EUR má pevnú sumu');
publicationStripeTest($one['host'] === 'buy.stripe.com' && $one['path'] === '/cNi9AN1fs51B95OeWOfMA01', '7 EUR ide na svoj Payment Link');
publicationStripeTest(($one['query']['client_reference_id'] ?? '') === '2026000007', 'do Checkoutu ide variabilný symbol ako client_reference_id');
publicationStripeTest(($one['query']['locale'] ?? '') === 'sk', 'Checkout je po slovensky');
publicationStripeTest(($one['query']['prefilled_email'] ?? '') === 'buyer@example.com', 'platný e-mail sa predvyplní');
publicationStripeTest(!str_contains($one['url'], 'donate.stripe.com'), '7 EUR nepoužije donate odkaz');
publicationStripeTest(!str_contains($one['url'], 'id=7'), 'referencia nie je holé ID objednávky');

$all = publicationStripeCheckedUrl(12.0, '2026000012');
publicationStripeTest($all['exact'] === true && $all['path'] === '/3cI6oB5vIcu35TCcOGfMA02', '12 EUR ide na odkaz balíka');
publicationStripeTest(($all['query']['client_reference_id'] ?? '') === '2026000012', 'balík nesie svoj variabilný symbol');
publicationStripeTest(!isset($all['query']['prefilled_email']), 'neplatný alebo prázdny e-mail sa do odkazu nevkladá');
publicationStripeTest(!str_contains($all['url'], 'cNi9AN1fs51B95OeWOfMA01'), '12 EUR nedostane cenu 7 EUR');

$wrong = publicationStripeCheckedUrl(8.00, '2026000008', 'not-an-email');
publicationStripeTest($wrong['exact'] === false && $wrong['host'] === 'donate.stripe.com', 'suma mimo cenníka nemá pevný odkaz a nie je to nákup 7 ani 12 EUR');
publicationStripeTest(($wrong['query']['client_reference_id'] ?? '') === '2026000008', 'aj záložný odkaz nesie referenciu objednávky');
publicationStripeTest(!isset($wrong['query']['prefilled_email']), 'neplatný e-mail sa zahodí');

$swapped = publicationStripeCheckedUrl(7.00, '2026000099');
publicationStripeTest(!str_contains($swapped['url'], '3cI6oB5vIcu35TCcOGfMA02'), 'objednávka za 7 EUR nedostane odkaz za 12 EUR');

$order = [
    'amount_eur' => '7.00',
    'variable_symbol' => '2026000007',
    'publication_title' => 'SK Nefro Báza 1',
    'buyer_email' => 'buyer@example.com',
];
$methods = publicationPaymentMethods($order);
$stripeMethod = null;
foreach ($methods as $method) {
    if (($method['key'] ?? '') === 'stripe') {
        $stripeMethod = $method;
        break;
    }
}
publicationStripeTest(is_array($stripeMethod), 'platobná stránka ponúkne Stripe');
publicationStripeTest(($stripeMethod['exact'] ?? false) === true && ($stripeMethod['auto_ref'] ?? false) === true, 'pevná suma aj referencia sa prenesú samy');
publicationStripeTest(str_starts_with((string) $stripeMethod['url'], $single), 'predvolený nákup 7 EUR nie je donate stránka');
publicationStripeTest(!str_contains((string) $stripeMethod['name'], 'sumu zadávate ručne'), 'pri pevnej cene kupujúci sumu nezadávava');

$bundleOrder = $order;
$bundleOrder['amount_eur'] = '12.00';
$bundleOrder['variable_symbol'] = '2026000012';
$bundleMethods = publicationPaymentMethods($bundleOrder);
$bundleStripe = null;
foreach ($bundleMethods as $method) {
    if (($method['key'] ?? '') === 'stripe') {
        $bundleStripe = $method;
        break;
    }
}
publicationStripeTest(is_array($bundleStripe) && str_starts_with((string) $bundleStripe['url'], $bundle), 'balík 12 EUR má vlastný odkaz');

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('CREATE TABLE publication_orders (id INTEGER PRIMARY KEY, status TEXT, paid_at TEXT, access_expires_at TEXT, payment_note TEXT)');
$pdo->exec("INSERT INTO publication_orders (id, status) VALUES (7, 'awaiting_payment')");

$deliveries = 0;
$GLOBALS['__smtpMaxMessageSize'] = 32 * 1024 * 1024;
$GLOBALS['NEFRO_TEST_PUBLICATION_SMTP'] = static fn (): bool => true;
$paidOrder = [
    'id' => 7,
    'variable_symbol' => '2026000007',
    'publication_title' => 'SK Nefro Báza 1',
    'publication_slug' => 'sk-nefro-baza-1',
    'formats' => 'pdf',
    'amount_eur' => '7.00',
    'buyer_email' => 'buyer@example.com',
    'token_salt' => 'salt-stripe-test',
];

publicationStripeTest(!publicationOrderIsDownloadable(['status' => 'awaiting_payment', 'access_expires_at' => null, 'download_count' => 0]), 'pred úhradou sa súbor nevydá');
publicationStripeTest(markPublicationOrderPaid($pdo, 7, 'spárované podľa client_reference_id'), 'prvé potvrdenie už spárovanej úhrady objednávku označí ako zaplatenú');
$token = publicationOrderToken($paidOrder);
$firstDelivery = sendPublicationOrderDeliveryEmail($paidOrder, $token);
if ($firstDelivery['sent']) {
    $deliveries++;
}
publicationStripeTest($deliveries === 1, 'doručenie vznikne až po platnom potvrdení');
publicationStripeTest(!markPublicationOrderPaid($pdo, 7, 'opakované potvrdenie'), 'druhé potvrdenie tej istej úhrady sa odmietne');
publicationStripeTest($deliveries === 1, 'odmietnuté druhé potvrdenie znova nedoručí');
$resend = sendPublicationOrderDeliveryEmail($paidOrder, $token);
publicationStripeTest($resend['sent'] === true, 'ručné opätovné dodanie je možné až po úhrade a nie je druhé potvrdenie');
unset($GLOBALS['NEFRO_TEST_PUBLICATION_SMTP']);

echo "Stripe odkazy publikácií: $checks kontrol prešlo.\n";
