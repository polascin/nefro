<?php

declare(strict_types=1);

require_once __DIR__ . '/guard.php';
if (!isset($pdo) || !$pdo instanceof PDO) {
    throw new RuntimeException('Integration database bootstrap failed.');
}
require_once __DIR__ . '/../../auth.php';
require_once __DIR__ . '/../../search_helpers.php';
require_once __DIR__ . '/../../calculators_common.php';
require_once __DIR__ . '/../../publications_common.php';
require_once __DIR__ . '/../../mobile_verification.php';

$checks = 0;
function integrationCheck(bool $condition, string $label): void
{
    global $checks;
    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $label);
    }
    ++$checks;
    echo "PASS: $label\n";
}

function integrationHttp(string $path, ?array $post = null, array $headers = [], string $client = 'owner'): array
{
    if (!str_starts_with($path, '/') || str_starts_with($path, '//')) {
        throw new RuntimeException('Only fixed internal HTTP routes are allowed.');
    }
    $curl = curl_init('http://app:8080' . $path);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_USERAGENT => 'Mozilla/5.0 NefroIntegration',
        CURLOPT_COOKIEFILE => '/tmp/nefro-' . $client . '.cookies',
        CURLOPT_COOKIEJAR => '/tmp/nefro-' . $client . '.cookies',
        CURLOPT_HTTPHEADER => $headers,
    ]);
    if ($post !== null) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $raw = curl_exec($curl);
    $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $size = (int) curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    if (!is_string($raw) || $status === 0 || $status >= 500) {
        throw new RuntimeException('HTTP failure: ' . strtok($path, '?') . ' status=' . $status);
    }
    $body = substr($raw, $size);
    if (preg_match('/Fatal error|Uncaught (?:Error|Exception)|Warning:|Chyba: Pripojenie/', $body)) {
        throw new RuntimeException('Application error in integration response.');
    }
    return ['status' => $status, 'headers' => substr($raw, 0, $size), 'body' => $body];
}

function integrationCsrf(string $html): string
{
    if (!preg_match('/name="csrf_token"\s+value="([^"]+)"/', $html, $match)) {
        throw new RuntimeException('CSRF field missing.');
    }
    return html_entity_decode($match[1], ENT_QUOTES, 'UTF-8');
}

function integrationMailbox(): array
{
    $data = json_decode((string) file_get_contents('http://mailpit:8025/api/v1/messages'), true, 512, JSON_THROW_ON_ERROR);
    return $data['messages'];
}

function integrationLastMail(): string
{
    $messages = integrationMailbox();
    if ($messages === []) {
        throw new RuntimeException('Expected captured SMTP message.');
    }
    $message = json_decode((string) file_get_contents('http://mailpit:8025/api/v1/message/' . $messages[0]['ID']), true, 512, JSON_THROW_ON_ERROR);
    return html_entity_decode((string) $message['Text'] . ' ' . (string) $message['HTML'], ENT_QUOTES, 'UTF-8');
}

integrationCheck((int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn() === 0, 'fresh synthetic database');
$password = 'Aa1-' . bin2hex(random_bytes(16));
$insert = $pdo->prepare('INSERT INTO users(username,email,password_hash,email_verified_at,is_active) VALUES (:username,:email,:password,:verified,1)');
$ids = [];
foreach (['owner', 'other', 'pending'] as $name) {
    $insert->execute(['username' => 'integration_' . $name, 'email' => $name . '@example.invalid', 'password' => hashAppPassword($password), 'verified' => $name === 'pending' ? null : date('Y-m-d H:i:s')]);
    $ids[$name] = (int) $pdo->lastInsertId();
}
$pdo->exec("INSERT INTO articles(title,slug,author,excerpt,content,is_published,published_at) VALUES ('Integration nephrology','integration-fixture','Synthetic author','Integration nephrology','Integration nephrology fixture',1,NOW())");
$search = searchArticles($pdo, 'nephrology', 1, 20);
integrationCheck($search['strategy'] === 'fulltext' && $search['total'] === 1, 'native MariaDB FULLTEXT parameters');

// Skutočný HTTP resend a SMTP, nie náhrada aplikačnej funkcie.
$page = integrationHttp('/resend_verification.php');
$sent = integrationHttp('/resend_verification.php', ['login' => 'integration_pending', 'csrf_token' => integrationCsrf($page['body'])]);
integrationCheck(in_array($sent['status'], [302, 303], true), 'resend verification HTTP');
$mail = integrationLastMail();
preg_match('~verify_email\.php\?uid=(\d+)&token=([A-Za-z0-9_-]+)~', $mail, $token);
integrationCheck(isset($token[2]), 'verification delivered through TLS SMTP capture');
$verifyPath = '/verify_email.php?uid=' . $ids['pending'] . '&token=' . $token[2];
$page = integrationHttp($verifyPath);
integrationCheck($pdo->query('SELECT email_verified_at FROM users WHERE id=' . $ids['pending'])->fetchColumn() === null, 'email scanner GET does not activate account');
integrationHttp('/verify_email.php', ['uid' => $ids['pending'], 'token' => $token[2], 'csrf_token' => integrationCsrf($page['body'])]);
integrationCheck($pdo->query('SELECT email_verified_at FROM users WHERE id=' . $ids['pending'])->fetchColumn() !== null, 'explicit POST activates email');

// Odber a jeho potvrdenie sú vedené cez pôvodné HTTP endpointy.
$subscribe = integrationHttp('/newsletter_subscribe.php', ['email' => 'subscriber@example.invalid'], ['X-NPS-Newsletter: 1']);
integrationCheck(json_decode($subscribe['body'], true, 512, JSON_THROW_ON_ERROR)['success'] === true, 'newsletter subscribe HTTP');
preg_match('~newsletter_verify_sub\.php\?token=([a-f0-9]{64})~', integrationLastMail(), $newsletterToken);
integrationCheck(isset($newsletterToken[1]), 'newsletter confirmation captured');
$page = integrationHttp('/newsletter_verify_sub.php?token=' . $newsletterToken[1]);
integrationCheck($pdo->query("SELECT verified_at FROM newsletter_subscribers WHERE email='subscriber@example.invalid'")->fetchColumn() === null, 'newsletter GET does not create consent');
integrationHttp('/newsletter_verify_sub.php', ['token' => $newsletterToken[1], 'csrf_token' => integrationCsrf($page['body'])]);
integrationCheck($pdo->query("SELECT verified_at FROM newsletter_subscribers WHERE email='subscriber@example.invalid'")->fetchColumn() !== null, 'newsletter explicit consent persisted');
$denied = integrationHttp('/newsletter_subscribe.php', ['email' => 'blocked@example.invalid']);
integrationCheck($denied['status'] === 403, 'newsletter requires anti-CSRF header');

$page = integrationHttp('/forgot_password.php');
preg_match('/js_token_field.*?\.value = "([^"]+)"/s', $page['body'], $challenge);
sleep(5);
integrationHttp('/forgot_password.php', ['login' => 'integration_owner', 'csrf_token' => integrationCsrf($page['body']), 'js_token' => $challenge[1] ?? '', 'hp_contact' => '']);
preg_match('~reset_password\.php\?token=([A-Za-z0-9_-]+)~', integrationLastMail(), $reset);
integrationCheck(isset($reset[1]), 'password reset request delivered via SMTP');
$page = integrationHttp('/reset_password.php?token=' . $reset[1]);
$newPassword = 'Aa2-' . bin2hex(random_bytes(16));
integrationHttp('/reset_password.php', ['token' => $reset[1], 'csrf_token' => integrationCsrf($page['body']), 'new_password' => $newPassword, 'new_password_confirm' => $newPassword]);
integrationCheck(password_verify($newPassword, (string) $pdo->query('SELECT password_hash FROM users WHERE id=' . $ids['owner'])->fetchColumn()), 'reset changes password in MariaDB');
integrationCheck((int) $pdo->query('SELECT COUNT(*) FROM password_resets WHERE used_at IS NULL')->fetchColumn() === 0, 'reset token consumed');
$page = integrationHttp('/reset_password.php?token=' . $reset[1]);
integrationHttp('/reset_password.php', ['token' => $reset[1], 'csrf_token' => integrationCsrf($page['body']), 'new_password' => $password, 'new_password_confirm' => $password]);
integrationCheck(password_verify($newPassword, (string) $pdo->query('SELECT password_hash FROM users WHERE id=' . $ids['owner'])->fetchColumn()), 'reset token cannot be replayed');

$page = integrationHttp('/login.php');
$bad = integrationHttp('/login.php', ['login' => 'integration_owner', 'password' => $newPassword, 'csrf_token' => 'invalid']);
integrationCheck($bad['status'] === 200 && str_contains($bad['body'], 'Neplatný CSRF'), 'login rejects invalid CSRF');
$page = integrationHttp('/login.php');
preg_match('/js_token_field.*?\.value = "([^"]+)"/s', $page['body'], $challenge);
sleep(4);
$login = integrationHttp('/login.php', ['login' => 'integration_owner', 'password' => $newPassword, 'csrf_token' => integrationCsrf($page['body']), 'js_token' => $challenge[1] ?? '']);
integrationCheck(in_array($login['status'], [302, 303], true), 'real login establishes session');
$page = integrationHttp('/profile.php');
integrationCheck($page['status'] === 200 && str_contains($page['body'], 'mobile_verification_action'), 'authenticated profile HTTP');

// SMS provider log nemá žiadne externé spojenie; validujeme reálne hashovanie a stav DB.
$code = generateMobileVerificationCode();
saveMobileVerificationCode($pdo, $ids['owner'], $code['code_hash'], $code['expires_at']);
integrationCheck(sendMobileVerificationCode('+421900000000', $code['code']), 'SMS substitute accepts only synthetic message');
$user = $pdo->query('SELECT * FROM users WHERE id=' . $ids['owner'])->fetch();
integrationCheck(verifyMobileCodeRecord($user, 'invalid') === 'invalid', 'SMS rejects wrong code');
integrationCheck(verifyMobileCodeRecord($user, $code['code']) === 'ok', 'SMS verifies generated code');
markMobileAsVerified($pdo, $ids['owner']);
integrationCheck($pdo->query('SELECT mobile_verified_at FROM users WHERE id=' . $ids['owner'])->fetchColumn() !== null, 'SMS verification persisted');

calculatorSaveResult($pdo, $ids['owner'], 'egfr_ckd_epi_2021', 'Integration result', ['first_name' => 'INTEGRATION_OWNER_ONLY'], [], ['egfr' => 90]);
$resultId = (int) $pdo->lastInsertId();
integrationCheck(calculatorFetchSavedResultById($pdo, $resultId, $ids['other']) === null, 'other account cannot read result');
integrationCheck(!calculatorDeleteSavedResult($pdo, $resultId, $ids['other']), 'other account cannot delete result');
$otherPage = integrationHttp('/login.php', null, [], 'other');
preg_match('/js_token_field.*?\.value = "([^\"]+)"/s', $otherPage['body'], $otherChallenge);
sleep(4);
$otherLogin = integrationHttp('/login.php', ['login' => 'integration_other', 'password' => $password, 'csrf_token' => integrationCsrf($otherPage['body']), 'js_token' => $otherChallenge[1] ?? ''], [], 'other');
integrationCheck(in_array($otherLogin['status'], [302, 303], true), 'second account login HTTP');
$otherHistory = integrationHttp('/calculator_history.php?compare=' . $resultId, null, [], 'other');
integrationCheck(!str_contains($otherHistory['body'], 'INTEGRATION_OWNER_ONLY'), 'other account HTTP cannot view or compare result');
$otherProfile = integrationHttp('/profile.php', null, [], 'other');
integrationHttp('/calculator_history.php', ['action' => 'delete', 'result_id' => $resultId, 'csrf_token' => integrationCsrf($otherProfile['body'])], [], 'other');
integrationCheck(calculatorFetchSavedResultById($pdo, $resultId, $ids['owner']) !== null, 'other account HTTP deletion cannot change owner result');
$page = integrationHttp('/calculator_history.php');
integrationCheck(str_contains($page['body'], 'INTEGRATION_OWNER_ONLY'), 'owner sees saved result over HTTP');
$anonymous = integrationHttp('/calculator_history.php', null, [], 'anonymous');
integrationCheck(!str_contains($anonymous['body'], 'INTEGRATION_OWNER_ONLY'), 'anonymous HTTP does not disclose result');
$deleted = integrationHttp('/calculator_history.php', ['action' => 'delete', 'result_id' => $resultId, 'csrf_token' => integrationCsrf($page['body'])]);
integrationCheck($deleted['status'] === 303 && calculatorFetchSavedResultById($pdo, $resultId, $ids['owner']) === null, 'owner deletion HTTP and database');

// Portál nemá Stripe API/webhook; testujeme jeho skutočný manuálny platobný model.
$publication = publications()[0];
$created = createPublicationOrder($pdo, $publication, ['pdf'], ['email' => 'buyer@example.invalid', 'name' => 'SYNTHETIC BUYER']);
$order = $created['order'];
$download = '/download_publication.php?' . http_build_query(['vs' => $order['variable_symbol'], 't' => $created['token'], 'format' => 'pdf']);
integrationCheck(integrationHttp($download)['status'] === 402, 'unpaid order cannot download');
integrationCheck(markPublicationOrderPaid($pdo, (int) $order['id'], 'Synthetic settlement, no charge'), 'synthetic manual settlement');
integrationCheck(!markPublicationOrderPaid($pdo, (int) $order['id']), 'duplicate settlement is idempotent');
$dir = PUBLICATION_FILES_DIR . '/' . $publication['slug'];
if (!is_dir($dir)) {
    mkdir($dir, 0750, true);
}
file_put_contents($dir . '/' . $publication['slug'] . '.pdf', "%PDF-1.4\nSynthetic integration fixture\n%%EOF\n");
$paid = integrationHttp($download);
integrationCheck($paid['status'] === 200 && str_starts_with($paid['body'], '%PDF'), 'paid bearer access serves synthetic PDF');
$invalid = str_replace(urlencode($created['token']), 'invalid-token', $download);
integrationCheck(integrationHttp($invalid)['status'] === 404, 'wrong bearer token rejected');
$firstAttempt = checkFormRateLimit($pdo, 'integration_limit', '192.0.2.10', 1, 60);
$secondAttempt = checkFormRateLimit($pdo, 'integration_limit', '192.0.2.10', 1, 60);
integrationCheck($firstAttempt && !$secondAttempt, 'native MariaDB rate limit');
integrationCheck(date_default_timezone_get() === 'Europe/Bratislava' && (int) $pdo->query('SELECT TIMESTAMPDIFF(SECOND, UTC_TIMESTAMP(), NOW())')->fetchColumn() === 0, 'different PHP and MariaDB timezones intentionally exercised');
$remaining = (int) $pdo->query("SELECT TIMESTAMPDIFF(SECOND, NOW(), blocked_until) FROM form_rate_limit WHERE action='integration_limit'")->fetchColumn();
integrationCheck($remaining > 0 && $remaining <= 60, 'rate block duration uses database clock');
integrationCheck(!checkFormRateLimit($pdo, 'integration_limit', '192.0.2.10', 1, 60), 'active rate block persists');
$pdo->exec("UPDATE form_rate_limit SET blocked_until=NULL, first_attempt=DATE_SUB(NOW(), INTERVAL 61 SECOND) WHERE action='integration_limit'");
integrationCheck(checkFormRateLimit($pdo, 'integration_limit', '192.0.2.10', 1, 60), 'expired rate window resets using database clock');
integrationCheck(integrationHttp('/tools/integration/app.ini')['status'] === 403, 'test configuration not exposed by HTTP');
echo "Integration: $checks checks PASS\n";
