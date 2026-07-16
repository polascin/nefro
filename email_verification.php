<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

const EMAIL_BRAND_NAME = 'Nefro-projekt Slovensko';
const EMAIL_DATETIME_FORMAT = 'Y-m-d H:i:s';
const EMAIL_CONTENT_TYPE_HTML = 'text/html; charset=UTF-8';
const EMAIL_GREETING_PREFIX = 'Dobrý deň, ';
const EMAIL_PLAIN_PARAGRAPH_BREAK = ",\n\n";
const EMAIL_SENTENCE_PARAGRAPH_SUFFIX = ".\n\n";

function getEmailEnvConfig(): array {
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    try {
        $env = loadAppConfig();
    } catch (\RuntimeException $e) {
        error_log('SMTP konfigurácia nebola načítaná: ' . $e->getMessage());
        $env = [];
    }

    return [
        'smtp_host' => trim((string) ($env['SMTP_HOST'] ?? '')),
        'smtp_port' => (int) ($env['SMTP_PORT'] ?? 587),
        'smtp_secure' => strtolower(trim((string) ($env['SMTP_SECURE'] ?? 'tls'))),
        'smtp_user' => trim((string) ($env['SMTP_USER'] ?? '')),
        'smtp_pass' => (string) ($env['SMTP_PASS'] ?? ''),
        'from_email' => trim((string) ($env['SMTP_FROM_EMAIL'] ?? '')),
        'from_name' => trim((string) ($env['SMTP_FROM_NAME'] ?? EMAIL_BRAND_NAME)),
        'admin_notification_email' => trim((string) ($env['SMTP_ADMIN_EMAIL'] ?? ($env['ADMIN_EMAIL'] ?? ''))),
        'smtp_timeout' => max(5, min(30, (int) ($env['SMTP_TIMEOUT'] ?? 10))),
    ];
}

function escapeEmailHtml(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function renderEmailHtmlLayout(string $contentHtml, string $actionLabel = '', string $actionUrl = '', string $extraFooterHtml = ''): string {
    $brand = EMAIL_BRAND_NAME;
    $buttonHtml = '';
    if ($actionLabel !== '' && $actionUrl !== '') {
        $buttonHtml = '<p style="text-align:center;margin:28px 0 0;">'
            . '<a href="' . escapeEmailHtml($actionUrl) . '" style="display:inline-block;padding:12px 20px;background:#0055a5;color:#ffffff;border-radius:8px;text-decoration:none;font-weight:600;">'
            . escapeEmailHtml($actionLabel) . '</a></p>';
    }

    return '<!doctype html><html lang="sk"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>'
        . escapeEmailHtml($brand) . '</title></head><body style="margin:0;padding:0;background:#f4f6f8;color:#111111;font-family:Arial,Helvetica,sans-serif;">'
        . '<table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr><td align="center" style="padding:24px 12px;">'
        . '<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 18px 50px rgba(15,23,42,0.08);">'
        . '<tr><td style="background:#0055a5;padding:30px;text-align:center;color:#ffffff;font-size:22px;font-weight:700;">'
        . escapeEmailHtml($brand) . '</td></tr>'
        . '<tr><td style="padding:30px;">' . $contentHtml . $buttonHtml
        . '<p style="margin:28px 0 0;color:#6b7280;font-size:13px;line-height:20px;">Ak tento e-mail nevyžadujete, ignorujte ho.</p>'
        . '</td></tr>'
        . '<tr><td style="background:#f3f4f6;padding:18px 30px 22px 30px;color:#64748b;font-size:13px;line-height:20px;text-align:center;">'
        . $extraFooterHtml
        . 'Nefro-projekt Slovensko • <a href="' . escapeEmailHtml(getAppBaseUrl()) . '" style="color:#64748b;text-decoration:underline;">Navštívte web</a>'
        . '</td></tr></table></td></tr></table></body></html>';
}

/**
 * Nenásilná zmienka o Dialyzačnom stredisku Medimpax do pätičky newsletter e-mailov.
 * Odovzdáva sa do renderEmailHtmlLayout() ako $extraFooterHtml — len pre newsletter,
 * NIE pre transakčné e-maily (overenie, reset hesla a pod.).
 */
function medimpaxEmailFooterHtml(): string {
    $url = escapeEmailHtml(getAppBaseUrl() . '/dialyza-bratislava.php');
    return '<div style="margin:0 0 10px;">Dialyzačná a nefrologická starostlivosť v Bratislave: '
        . '<a href="' . $url . '" style="color:#64748b;text-decoration:underline;">Dialyzačné stredisko Medimpax (Dúbravka)</a></div>';
}

function smtpReadResponse($socket): array {
    $lines = '';
    $code = 0;

    while (($line = fgets($socket, 515)) !== false) {
        $lines .= $line;
        if (preg_match('/^(\d{3})([\s-])/', $line, $m)) {
            $code = (int) $m[1];
            if ($m[2] === ' ') {
                break;
            }
        }
    }

    return [$code, $lines];
}

function smtpLogError(string $stage, string $reason, array $context = []): void {
    $parts = ['SMTP ' . $stage . ' failed', 'reason=' . $reason];

    if (!empty($context['expected'])) {
        $parts[] = 'expected=' . implode('|', array_map('strval', (array) $context['expected']));
    }

    if (isset($context['actual'])) {
        $parts[] = 'actual=' . (string) $context['actual'];
    }

    if (!empty($context['response'])) {
        $responseOneLine = preg_replace('/\s+/', ' ', trim((string) $context['response']));
        if ($responseOneLine !== '') {
            $responseOneLine = preg_replace(
                '/[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}/iu',
                '[redacted-email]',
                $responseOneLine
            );
            $parts[] = 'response="' . $responseOneLine . '"';
        }
    }

    error_log(implode('; ', $parts));
}

function smtpSendCommand($socket, string $command, array $expectedCodes, string $stage): array {
    if (@fwrite($socket, $command . "\r\n") === false) {
        smtpLogError($stage, 'write_failed', ['expected' => $expectedCodes]);
        return ['ok' => false, 'code' => 0, 'response' => ''];
    }

    [$code, $response] = smtpReadResponse($socket);
    $ok = in_array($code, $expectedCodes, true);
    if (!$ok) {
        smtpLogError($stage, 'unexpected_code', [
            'expected' => $expectedCodes,
            'actual' => $code,
            'response' => $response,
        ]);
    }

    return ['ok' => $ok, 'code' => $code, 'response' => $response];
}

function smtpCloseSocket($socket): void {
    if (is_resource($socket)) {
        fclose($socket);
    }
}

function smtpHasRequiredConfig(array $cfg): bool {
    return $cfg['smtp_host'] !== ''
        && $cfg['smtp_user'] !== ''
        && $cfg['smtp_pass'] !== ''
        && $cfg['from_email'] !== '';
}

function smtpOpenSocket(array $cfg) {
    $transportHost = $cfg['smtp_host'];
    if ($cfg['smtp_secure'] === 'ssl') {
        $transportHost = 'ssl://' . $transportHost;
    }

    $socket = @stream_socket_client(
        $transportHost . ':' . (int) $cfg['smtp_port'],
        $errno,
        $errstr,
        (int) $cfg['smtp_timeout'],
        STREAM_CLIENT_CONNECT
    );
    if (!$socket) {
        error_log('SMTP connect failed: ' . $errstr . ' (' . $errno . ')');
        return null;
    }

    stream_set_timeout($socket, (int) $cfg['smtp_timeout']);
    return $socket;
}

function smtpExpectBanner($socket): bool {
    [$code, $bannerResponse] = smtpReadResponse($socket);
    if ($code === 220) {
        return true;
    }

    smtpLogError('banner', 'unexpected_code', [
        'expected' => [220],
        'actual' => $code,
        'response' => $bannerResponse,
    ]);
    return false;
}

function smtpRunEhlo($socket, string $ehloHost, string $stage): bool {
    return smtpSendCommand($socket, 'EHLO ' . $ehloHost, [250], $stage)['ok'];
}

function smtpStartTlsAndReEhlo($socket, string $ehloHost): bool {
    if (!smtpSendCommand($socket, 'STARTTLS', [220], 'starttls')['ok']) {
        return false;
    }

    $tlsMethod = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
    $cryptoEnabled = @stream_socket_enable_crypto($socket, true, $tlsMethod) === true;
    if (!$cryptoEnabled) {
        smtpLogError('starttls_crypto', 'tls_handshake_failed');
        return false;
    }

    return smtpRunEhlo($socket, $ehloHost, 'ehlo_tls');
}

function smtpOpenAndHandshake(array $cfg) {
    $socket = null;

    if (smtpHasRequiredConfig($cfg)) {
        $socket = smtpOpenSocket($cfg);
        if ($socket) {
            $ehloHost = $_SERVER['SERVER_NAME'] ?? 'localhost';
            $ok = smtpExpectBanner($socket)
                && smtpRunEhlo($socket, $ehloHost, 'ehlo_initial');

            if ($ok && $cfg['smtp_secure'] === 'tls') {
                $ok = smtpStartTlsAndReEhlo($socket, $ehloHost);
            }

            if (!$ok) {
                smtpCloseSocket($socket);
                $socket = null;
            }
        }
    }

    return $socket;
}

function smtpAuthenticate($socket, array $cfg): bool {
    return smtpSendCommand($socket, 'AUTH LOGIN', [334], 'auth_login')['ok']
        && smtpSendCommand($socket, base64_encode($cfg['smtp_user']), [334], 'auth_username')['ok']
        && smtpSendCommand($socket, base64_encode($cfg['smtp_pass']), [235], 'auth_password')['ok'];
}

function smtpOpenEnvelope($socket, string $fromEmail, string $toEmail): bool {
    return smtpSendCommand($socket, 'MAIL FROM:<' . $fromEmail . '>', [250], 'mail_from')['ok']
        && smtpSendCommand($socket, 'RCPT TO:<' . $toEmail . '>', [250, 251], 'rcpt_to')['ok']
        && smtpSendCommand($socket, 'DATA', [354], 'data')['ok'];
}

function smtpBuildPayload(string $toEmail, string $subject, string $messageBody, array $cfg, string $contentType, ?string $plainTextAlt): string {
    $encodedSubject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n ");
    $encodedFromName = mb_encode_mimeheader($cfg['from_name'], 'UTF-8', 'B', "\r\n ");
    $useMultipart = ($plainTextAlt !== null && stripos($contentType, 'text/html') !== false);

    $headers = [
        'From: ' . $encodedFromName . ' <' . $cfg['from_email'] . '>',
        'To: <' . $toEmail . '>',
        'Subject: ' . $encodedSubject,
        'MIME-Version: 1.0',
        'Date: ' . date(DATE_RFC2822),
    ];

    if ($useMultipart) {
        $boundary = '=_nps_' . bin2hex(random_bytes(16));
        $headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
        $body = '--' . $boundary . "\n"
            . "Content-Type: text/plain; charset=UTF-8\n"
            . "Content-Transfer-Encoding: quoted-printable\n\n"
            . quoted_printable_encode((string) $plainTextAlt) . "\n\n"
            . '--' . $boundary . "\n"
            . "Content-Type: " . EMAIL_CONTENT_TYPE_HTML . "\n"
            . "Content-Transfer-Encoding: quoted-printable\n\n"
            . quoted_printable_encode($messageBody) . "\n\n"
            . '--' . $boundary . "--\n";
    } else {
        $headers[] = 'Content-Type: ' . $contentType;
        $headers[] = 'Content-Transfer-Encoding: quoted-printable';
        $body = quoted_printable_encode($messageBody);
    }

    $payload = implode("\r\n", $headers) . "\r\n\r\n" . str_replace(["\r\n", "\r"], "\n", $body);
    $payload = str_replace("\n", "\r\n", $payload);
    $payload = str_replace("\r\n.", "\r\n..", $payload);
    return $payload . "\r\n.\r\n";
}

function smtpWritePayloadAndFinish($socket, string $payload): bool {
    if (@fwrite($socket, $payload) === false) {
        smtpLogError('data_payload', 'write_failed');
        smtpSendCommand($socket, 'QUIT', [221], 'quit');
        return false;
    }

    [$dataCode, $dataResponse] = smtpReadResponse($socket);
    if ($dataCode !== 250) {
        smtpLogError('data_finalize', 'unexpected_code', [
            'expected' => [250],
            'actual' => $dataCode,
            'response' => $dataResponse,
        ]);
    }

    smtpSendCommand($socket, 'QUIT', [221], 'quit');
    return $dataCode === 250;
}

function sendViaSmtp(string $toEmail, string $subject, string $messageBody, array $cfg, string $contentType = 'text/plain; charset=UTF-8', ?string $plainTextAlt = null): bool {
    $socket = smtpOpenAndHandshake($cfg);
    if (!$socket) {
        return false;
    }

    $ok = smtpAuthenticate($socket, $cfg)
        && smtpOpenEnvelope($socket, (string) $cfg['from_email'], $toEmail);
    if ($ok) {
        $payload = smtpBuildPayload($toEmail, $subject, $messageBody, $cfg, $contentType, $plainTextAlt);
        $ok = smtpWritePayloadAndFinish($socket, $payload);
    }

    smtpCloseSocket($socket);
    return $ok;
}

function generateEmailVerificationToken(): array {
    $rawToken = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    $tokenHash = hash('sha256', $rawToken);

    return [
        'token' => $rawToken,
        'token_hash' => $tokenHash,
        'expires_at' => date(EMAIL_DATETIME_FORMAT, time() + 86400), // 24h
    ];
}

function saveEmailVerificationToken(PDO $pdo, int $userId, string $tokenHash, string $expiresAt): void {
    $stmt = $pdo->prepare("UPDATE users
        SET email_verification_token_hash = :token_hash,
            email_verification_expires_at = :expires_at,
            email_verification_sent_at = NOW()
        WHERE id = :id");
    $stmt->execute([
        'token_hash' => $tokenHash,
        'expires_at' => $expiresAt,
        'id' => $userId,
    ]);
}

function sendVerificationEmail(string $toEmail, string $username, int $userId, string $rawToken): bool {
    $verifyUrl = getAppBaseUrl() . '/verify_email.php?uid=' . urlencode((string) $userId) . '&token=' . urlencode($rawToken);

    $subject = 'Overenie e-mailovej adresy - ' . EMAIL_BRAND_NAME;
    $displayName = trim($username) !== '' ? $username : $toEmail;

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($displayName) . ',</p>'
        . '<p style="margin:0 0 16px;">ďakujeme za registráciu v ' . EMAIL_BRAND_NAME . '.</p>'
        . '<p style="margin:0 0 16px;">Pre aktiváciu účtu overte svoju e-mailovú adresu kliknutím na tlačidlo nižšie.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Ak tlačidlo nefunguje, skopírujte a vložte tento odkaz do prehliadača:</p>'
        . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($verifyUrl) . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($verifyUrl) . '</a></p>'
        . '<p style="margin:0;color:#64748b;font-size:14px;line-height:22px;">Platnosť odkazu je 24 hodín.</p>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Overiť e-mail', $verifyUrl);
    $plainMessage = EMAIL_GREETING_PREFIX . $displayName . EMAIL_PLAIN_PARAGRAPH_BREAK
        . "ďakujeme za registráciu v " . EMAIL_BRAND_NAME . EMAIL_SENTENCE_PARAGRAPH_SUFFIX
        . "Pre aktiváciu účtu overte svoju e-mailovú adresu otvorením tohto odkazu:\n"
        . $verifyUrl . "\n\n"
        . "Platnosť odkazu je 24 hodín.\n\n"
        . EMAIL_BRAND_NAME;

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $plainMessage)) {
        return true;
    }

    error_log('sendVerificationEmail: SMTP zlyhalo.');
    return false;
}

function sendPasswordResetEmail(string $toEmail, string $username, string $rawToken): bool {
    $resetUrl = getAppBaseUrl() . '/reset_password.php?token=' . urlencode($rawToken);

    $subject = 'Obnova hesla - ' . EMAIL_BRAND_NAME;
    $displayName = trim($username) !== '' ? $username : $toEmail;

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($displayName) . ',</p>'
        . '<p style="margin:0 0 16px;">Prijali sme žiadosť o obnovenie hesla pre váš účet v ' . EMAIL_BRAND_NAME . '.</p>'
        . '<p style="margin:0 0 16px;">Nové heslo nastavíte kliknutím na tlačidlo nižšie.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Ak tlačidlo nefunguje, skopírujte a vložte tento odkaz do prehliadača:</p>'
        . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($resetUrl) . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($resetUrl) . '</a></p>'
        . '<p style="margin:0;color:#64748b;font-size:14px;line-height:22px;">Platnosť odkazu je 60 minút.</p>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Obnoviť heslo', $resetUrl);
    $plainMessage = EMAIL_GREETING_PREFIX . $displayName . EMAIL_PLAIN_PARAGRAPH_BREAK
        . "prijali sme žiadosť o obnovenie hesla pre váš účet v " . EMAIL_BRAND_NAME . EMAIL_SENTENCE_PARAGRAPH_SUFFIX
        . "Nové heslo nastavíte otvorením tohto odkazu:\n"
        . $resetUrl . "\n\n"
        . "Platnosť odkazu je 60 minút.\n\n"
        . EMAIL_BRAND_NAME;

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $plainMessage)) {
        return true;
    }

    error_log('sendPasswordResetEmail: SMTP zlyhalo.');
    return false;
}

/**
 * Pošle internú notifikáciu o novej úspešnej registrácii.
 * Citlivé hash hodnoty sa zo správy zámerne vynechávajú.
 */
function sendAdminNewRegistrationEmail(array $dbUserRow, array $registrationContext = []): bool {
    $cfg = getEmailEnvConfig();
    $toEmail = trim((string) ($cfg['admin_notification_email'] ?? ''));
    if ($toEmail === '') {
        $toEmail = trim((string) ($cfg['from_email'] ?? ''));
    }
    if ($toEmail === '') {
        return false;
    }

    $sensitiveKeys = [
        'password_hash',
        'email_verification_token_hash',
        'mobile_verification_code_hash',
    ];

    foreach ($sensitiveKeys as $key) {
        if (array_key_exists($key, $dbUserRow)) {
            unset($dbUserRow[$key]);
        }
    }

    $subject = 'Nová registrácia používateľa - ' . EMAIL_BRAND_NAME;

    $lines = [];
    $lines[] = 'Bola zaznamenaná nová úspešná registrácia.';
    $lines[] = '';
    $lines[] = 'REGISTRAČNÝ KONTEXT';
    $lines[] = '------------------';
    $lines[] = 'Čas servera: ' . date(EMAIL_DATETIME_FORMAT);
    $lines[] = 'IP adresa: ' . (string) ($registrationContext['ip'] ?? '-');
    $lines[] = 'User-Agent: ' . (string) ($registrationContext['user_agent'] ?? '-');
    $lines[] = 'Referer: ' . (string) ($registrationContext['referer'] ?? '-');
    $lines[] = 'Request URI: ' . (string) ($registrationContext['request_uri'] ?? '-');
    $lines[] = '';
    $lines[] = 'HODNOTY ULOŽENÉ DO USERS';
    $lines[] = '------------------------';

    ksort($dbUserRow);
    foreach ($dbUserRow as $key => $value) {
        $display = $value;
        if ($display === null || $display === '') {
            $display = '(null)';
        } elseif (is_bool($display)) {
            $display = $display ? '1' : '0';
        } elseif (is_array($display)) {
            $display = json_encode($display, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $lines[] = (string) $key . ': ' . (string) $display;
    }

    $message = implode("\n", $lines);
    $htmlBody = '<p style="margin:0 0 16px;">Bola zaznamenaná nová úspešná registrácia.</p>'
        . '<h2 style="margin:0 0 14px;font-size:18px;color:#0f172a;">Registračný kontext</h2>'
        . '<ul style="margin:0 0 16px;padding-left:20px;color:#334155;line-height:24px;">'
        . '<li>Čas servera: ' . escapeEmailHtml(date(EMAIL_DATETIME_FORMAT)) . '</li>'
        . '<li>IP adresa: ' . escapeEmailHtml((string) ($registrationContext['ip'] ?? '-')) . '</li>'
        . '<li>User-Agent: ' . escapeEmailHtml((string) ($registrationContext['user_agent'] ?? '-')) . '</li>'
        . '<li>Referer: ' . escapeEmailHtml((string) ($registrationContext['referer'] ?? '-')) . '</li>'
        . '<li>Request URI: ' . escapeEmailHtml((string) ($registrationContext['request_uri'] ?? '-')) . '</li>'
        . '</ul>'
        . '<h2 style="margin:0 0 14px;font-size:18px;color:#0f172a;">Uložené hodnoty</h2>'
        . '<pre style="margin:0;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;white-space:pre-wrap;word-break:break-word;color:#334155;font-size:13px;line-height:21px;">' . escapeEmailHtml($message) . '</pre>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody);

    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $message)) {
        return true;
    }

    error_log('sendAdminNewRegistrationEmail: SMTP zlyhalo.');
    return false;
}

/**
 * Pošle potvrdenie novej registrácie registrovanému používateľovi.
 */
function sendUserRegistrationNotificationEmail(string $toEmail, string $username, array $dbUserRow = []): bool {
    $cfg = getEmailEnvConfig();
    $displayName = trim($username) !== '' ? $username : $toEmail;
    $subject = 'Potvrdenie registrácie - ' . EMAIL_BRAND_NAME;

    $firstName = trim((string) ($dbUserRow['first_name'] ?? ''));
    $lastName = trim((string) ($dbUserRow['last_name'] ?? ''));
    $fullName = trim($firstName . ' ' . $lastName);
    $nameLine = $fullName !== '' ? $fullName : $displayName;

    $lines = [];
    $lines[] = EMAIL_GREETING_PREFIX . $nameLine . ',';
    $lines[] = '';
    $lines[] = 'váš účet bol úspešne vytvorený v ' . EMAIL_BRAND_NAME . '.';
    $lines[] = '';
    $lines[] = 'Základné údaje registrácie:';
    $lines[] = '- Používateľské meno: ' . (string) ($dbUserRow['username'] ?? $username);
    $lines[] = '- E-mail: ' . (string) ($dbUserRow['email'] ?? $toEmail);
    $lines[] = '- Čas registrácie: ' . date(EMAIL_DATETIME_FORMAT);
    $lines[] = '';
    $lines[] = 'Ak ste túto registráciu nevykonali vy, čo najskôr nás kontaktujte.';
    $lines[] = '';
    $lines[] = EMAIL_BRAND_NAME;

    $message = implode("\n", $lines);

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($nameLine) . ',</p>'
        . '<p style="margin:0 0 16px;">Váš účet bol úspešne vytvorený v ' . EMAIL_BRAND_NAME . '.</p>'
        . '<div style="margin:18px 0 24px;padding:18px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;color:#334155;line-height:24px;">'
        . '<strong>Základné údaje registrácie:</strong><br>'
        . 'Používateľské meno: ' . escapeEmailHtml((string) ($dbUserRow['username'] ?? $username)) . '<br>'
        . 'E-mail: ' . escapeEmailHtml((string) ($dbUserRow['email'] ?? $toEmail)) . '<br>'
        . 'Čas registrácie: ' . escapeEmailHtml(date(EMAIL_DATETIME_FORMAT)) . '</div>'
        . '<p style="margin:0 0 16px;color:#475569;">Ak ste túto registráciu nevykonali vy, čo najskôr nás kontaktujte.</p>';

    $htmlMessage = renderEmailHtmlLayout($htmlBody);

    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $message)) {
        return true;
    }

    error_log('sendUserRegistrationNotificationEmail: SMTP zlyhalo.');
    return false;
}

function markEmailAsVerified(PDO $pdo, int $userId): void {
    $stmt = $pdo->prepare("UPDATE users
        SET email_verified_at = NOW(),
            email_verification_token_hash = NULL,
            email_verification_expires_at = NULL,
            email_verification_sent_at = NULL
        WHERE id = :id");
    $stmt->execute(['id' => $userId]);
}

function sendAccountDeletionConfirmationEmail(string $toEmail, string $username, string $rawToken): bool {
    $confirmUrl = getAppBaseUrl() . '/confirm_account_deletion.php?token=' . urlencode($rawToken);
    $displayName = trim($username) !== '' ? $username : $toEmail;
    $subject = 'Potvrdenie zrušenia účtu - ' . EMAIL_BRAND_NAME;
    $message = EMAIL_GREETING_PREFIX . $displayName . EMAIL_PLAIN_PARAGRAPH_BREAK
        . "prijali sme žiadosť o zrušenie vášho účtu v " . EMAIL_BRAND_NAME . EMAIL_SENTENCE_PARAGRAPH_SUFFIX
        . "Pre dokončenie a trvalé vymazanie účtu kliknite na tento odkaz:\n\n"
        . $confirmUrl . "\n\n"
        . "Platnosť odkazu je 24 hodín.\n\n"
        . "UPOZORNENIE: Táto akcia je nezvratná. Po potvrdení budú natrvalo vymazané "
        . "váš účet, profil, avatary a uložené výsledky kalkulačiek. Minimalizovaný bezpečnostný "
        . "audit vykonania žiadosti bez používateľského mena môžeme uchovať najviac 90 dní.\n\n"
        . "Ak ste o zrušenie účtu nežiadali, tento e-mail ignorujte. "
        . "Váš účet zostane zachovaný.\n\n"
        . EMAIL_BRAND_NAME;

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($displayName) . ',</p>'
        . '<p style="margin:0 0 16px;">Prijali sme žiadosť o zrušenie vášho účtu v ' . EMAIL_BRAND_NAME . '.</p>'
        . '<p style="margin:0 0 16px;">Pre dokončenie a trvalé vymazanie účtu kliknite na tlačidlo nižšie.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Odkaz je platný 24 hodín.</p>'
        . '<p style="margin:0 0 16px;color:#334155;font-size:14px;line-height:22px;">Táto akcia je nezvratná. Po potvrdení budú natrvalo vymazané váš účet, profil, avatary a uložené výsledky kalkulačiek. Minimalizovaný bezpečnostný audit vykonania žiadosti bez používateľského mena môžeme uchovať najviac 90 dní.</p>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Potvrdiť zrušenie účtu', $confirmUrl);

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, EMAIL_CONTENT_TYPE_HTML, $message)) {
        return true;
    }

    error_log('sendAccountDeletionConfirmationEmail: SMTP zlyhalo.');
    return false;
}

function isEmailResendAllowed(?string $sentAt, int $cooldownSeconds = 60): bool {
    if (empty($sentAt)) {
        return true;
    }

    $sentTs = strtotime($sentAt);
    if ($sentTs === false) {
        return true;
    }

    return (time() - $sentTs) >= $cooldownSeconds;
}
