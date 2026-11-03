<?php

declare(strict_types=1);

/**
 * P1 bootstrap: skalárne vstupy — pole namiesto skaláru → riadená 400, nie TypeError.
 */

require_once dirname(__DIR__) . '/request_input.php';

$checks = 0;
function requestInputTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

requestInputTest(requestIsScalarInput('ok'), 'Reťazec je skalár.');
requestInputTest(requestIsScalarInput(1), 'Int je skalár.');
requestInputTest(requestIsScalarInput(null), 'Null je povolený vstup (chýbajúci).');
requestInputTest(!requestIsScalarInput(['a']), 'Pole nie je skalár.');
requestInputTest(!requestIsScalarInput(new stdClass()), 'Objekt nie je skalár.');

requestInputTest(requestScalarString(['s' => '  hello  '], 's') === 'hello', 'String sa otrimuje.');
requestInputTest(requestScalarString(['s' => '  keep  '], 's', '', true, false) === '  keep  ', 'Heslo sa neotrimuje.');
requestInputTest(requestScalarString([], 's', 'def') === 'def', 'Chýbajúci kľúč → default.');
requestInputTest(requestScalarString(['s' => null], 's', 'def') === 'def', 'Null → default.');
requestInputTest(
    requestScalarString(['s' => ['x']], 's', 'def', false) === 'def',
    'Pole so reject=false → default bez exit.',
);

requestInputTest(requestScalarInt(['page' => '3'], 'page') === 3, 'Číslo zo stringu.');
requestInputTest(requestScalarInt(['page' => 'x'], 'page', 1) === 1, 'Neplatné číslo → default.');
requestInputTest(requestScalarInt(['page' => ['2']], 'page', 9, false) === 9, 'Pole page so reject=false → default.');

$_POST = ['token' => 'from-post'];
$_GET = ['token' => 'from-get', 'uid' => '7'];
requestInputTest(requestScalarStringPreferPost('token') === 'from-post', 'PreferPost berie POST pred GET.');
requestInputTest(requestScalarIntPreferPost('uid') === 7, 'PreferPost int z GET ak POST chýba.');
$_POST = [];
$_GET = [];

$root = dirname(__DIR__);
$wiredPages = [
    'index.php',
    'search.php',
    'download_pdf.php',
    'newsletter_subscribe.php',
    'login.php',
    'forgot_password.php',
    'resend_verification.php',
    'article.php',
    'liek.php',
    'lieky.php',
    'studie.php',
    'download_free_publication.php',
    'verify_email.php',
    'publikacia.php',
    'reset_password.php',
    'confirm_account_deletion.php',
    'calculator_history.php',
    'calculator_result_print.php',
    'studia.php',
    'objednavka.php',
    'download_publication.php',
    'admin_providers.php',
    'admin_drugs.php',
    'admin_trials.php',
    'admin_articles.php',
    'admin_discussion.php',
    'admin_newsletter.php',
];
foreach ($wiredPages as $page) {
    $src = (string) file_get_contents($root . '/' . $page);
    requestInputTest(
        str_contains($src, "require_once __DIR__ . '/request_input.php';"),
        "{$page} musí načítavať request_input.php.",
    );
    requestInputTest(
        str_contains($src, 'requestScalarString')
            || str_contains($src, 'requestScalarInt')
            || str_contains($src, 'requestScalarStringPreferPost')
            || str_contains($src, 'requestScalarIntPreferPost')
            || str_contains($src, 'calculatorPostString')
            || str_contains($src, 'calculatorPostInt'),
        "{$page} musí používať skalárne čítanie.",
    );
}

$commonSrc = (string) file_get_contents($root . '/calculators_common.php');
requestInputTest(
    str_contains($commonSrc, "require_once __DIR__ . '/request_input.php';"),
    'calculators_common.php musí načítavať request_input.php.',
);
requestInputTest(
    str_contains($commonSrc, 'function calculatorPostString')
        && str_contains($commonSrc, 'function calculatorPostInt')
        && str_contains($commonSrc, 'function calculatorPostStringList'),
    'calculators_common.php musí mať calculatorPostString/Int/StringList.',
);

$calcSamples = [
    'calculator_egfr.php',
    'calculator_prevent.php',
    'calculator_ckm.php',
    'calculator_ambulatory.php',
    'calculator_egfr_slope.php',
];
foreach ($calcSamples as $page) {
    $src = (string) file_get_contents($root . '/' . $page);
    requestInputTest(
        str_contains($src, 'calculatorPostString') || str_contains($src, 'calculatorPostInt'),
        "{$page} musí používať calculatorPostString/Int.",
    );
}
requestInputTest(
    str_contains((string) file_get_contents($root . '/calculator_ambulatory.php'), "calculatorPostStringList('complications')"),
    'ambulatory musí čítať complications[] cez list helper (nie skalár).',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/publikacia.php'), "requestStringList(\$_POST, 'formats')"),
    'publikacia.php musí čítať formats[] cez requestStringList.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/calculator_ambulatory.php'), "calculatorPostStringList('cause_diagnoses')"),
    'ambulatory musí čítať cause_diagnoses cez list helper.',
);
requestInputTest(
    function_exists('requestStringList'),
    'request_input.php musí exportovať requestStringList.',
);
requestInputTest(requestStringList([], 'codes') === [], 'Chýbajúci list → [].');
requestInputTest(requestStringList(['codes' => 'N18.3'], 'codes') === ['N18.3'], 'Skalár → jedno položkové pole.');
requestInputTest(requestStringList(['codes' => ['N18.3', 'I12.00']], 'codes') === ['N18.3', 'I12.00'], 'Pole skalárov → list.');
requestInputTest(requestStringList(['codes' => ['N18.3', ['x']]], 'codes', false) === ['N18.3'], 'Vnorenie so reject=false sa preskočí.');

requestInputTest(
    str_contains((string) file_get_contents($root . '/newsletter_subscribe.php'), 'requestInputResponseIsJson(true)'),
    'newsletter_subscribe.php musí preferovať JSON pri rejecte.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/request_input.php'), 'function requestScalarStringPreferPost'),
    'request_input.php musí mať PreferPost helper.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/request_input.php'), 'function requestCsrfTokenFromPost'),
    'request_input.php musí mať requestCsrfTokenFromPost.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/auth.php'), "require_once __DIR__ . '/request_input.php';")
        && str_contains((string) file_get_contents($root . '/auth.php'), 'requestCsrfTokenFromPost()'),
    'auth.php musí načítavať request_input a používať requestCsrfTokenFromPost.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/profile.php'), 'requestRequireScalarPost()')
        && str_contains((string) file_get_contents($root . '/profile.php'), 'requestScalarString($_POST, $field)'),
    'profile.php musí odmietnuť poľový POST a čítať polia cez requestScalarString.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/login.php'), 'requestCsrfTokenFromPost()'),
    'login.php musí čítať CSRF cez requestCsrfTokenFromPost.',
);
requestInputTest(
    str_contains((string) file_get_contents($root . '/.htaccess'), 'request_input'),
    '.htaccess musí deny-ovať request_input.php.',
);

$fixtureDir = sys_get_temp_dir();
$fixtureJson = $fixtureDir . DIRECTORY_SEPARATOR . 'nefro_test_request_input_json.php';
$fixtureText = $fixtureDir . DIRECTORY_SEPARATOR . 'nefro_test_request_input_text.php';
file_put_contents($fixtureJson, "<?php\ndeclare(strict_types=1);\n"
    . "require " . var_export($root . DIRECTORY_SEPARATOR . 'request_input.php', true) . ";\n"
    . "\$_SERVER['HTTP_ACCEPT'] = 'application/json';\n"
    . "requestRejectNonScalarInput('email');\n");
file_put_contents($fixtureText, "<?php\ndeclare(strict_types=1);\n"
    . "require " . var_export($root . DIRECTORY_SEPARATOR . 'request_input.php', true) . ";\n"
    . "requestRejectNonScalarInput('s');\n");

$php = PHP_BINARY;
$jsonOut = [];
$jsonCode = 0;
exec(escapeshellarg($php) . ' -d display_errors=0 ' . escapeshellarg($fixtureJson) . ' 2>&1', $jsonOut, $jsonCode);
$jsonBody = implode("\n", $jsonOut);
@unlink($fixtureJson);
$requestInputJson = json_decode($jsonBody, true);
requestInputTest(is_array($requestInputJson), 'Reject JSON odpoveď musí byť platný JSON, nie HTML. Got: ' . $jsonBody);
requestInputTest(($requestInputJson['error'] ?? '') === 'invalid_parameter', 'JSON musí niesť error=invalid_parameter.');
requestInputTest(!str_contains($jsonBody, '<html') && !str_contains($jsonBody, 'Fatal error'), 'Odpoveď nesmie byť HTML fatál.');

$textOut = [];
$textCode = 0;
exec(escapeshellarg($php) . ' -d display_errors=0 ' . escapeshellarg($fixtureText) . ' 2>&1', $textOut, $textCode);
$textBody = implode("\n", $textOut);
@unlink($fixtureText);
requestInputTest(str_contains($textBody, 'Neplatný tvar parametra'), 'Plain text obsahuje správu o parametri.');
requestInputTest(!str_contains($textBody, '<br') && !str_contains($textBody, 'Fatal'), 'Plain text nie je HTML chyba.');

requestRequireScalarPost(['email' => 'a@b.sk', 'age_confirm' => '1', 'empty' => null]);
requestInputTest(true, 'Skalárny POST prejde bez ukončenia.');

// Windows: php -r + escapeshellarg rozbije vnorené úvodzovky; fixture súbor je spoľahlivý
// (rovnaký vzor ako reject JSON/text vyššie).
$fixtureScalarPost = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'nefro_req_scalar_post_' . getmypid() . '.php';
file_put_contents($fixtureScalarPost, "<?php\ndeclare(strict_types=1);\n"
    . "require " . var_export($root . DIRECTORY_SEPARATOR . 'request_input.php', true) . ";\n"
    . "requestRequireScalarPost(['email' => ['x']]);\n"
    . "echo 'REACHED';\n");
$scalarPostOut = [];
$scalarPostCode = 0;
exec(escapeshellarg($php) . ' -d display_errors=0 ' . escapeshellarg($fixtureScalarPost) . ' 2>&1', $scalarPostOut, $scalarPostCode);
$scalarPostBody = implode("\n", $scalarPostOut);
@unlink($fixtureScalarPost);
requestInputTest(!str_contains($scalarPostBody, 'REACHED'), 'Poľový POST parameter ukončí požiadavku. Got: ' . $scalarPostBody);
requestInputTest(
    str_contains($scalarPostBody, 'Neplatný tvar parametra "email"'),
    'Poľový POST → riadená 400 správa. Got: ' . $scalarPostBody,
);
requestInputTest(!str_contains($scalarPostBody, 'Fatal') && !str_contains($scalarPostBody, 'TypeError'), 'Poľový POST nie je fatál.');

echo "Request input: $checks PASS\n";
