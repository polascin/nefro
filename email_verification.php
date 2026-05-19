<?php

require_once __DIR__ . '/config_loader.php';

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

    $config = [
        'smtp_host' => trim((string) ($env['SMTP_HOST'] ?? '')),
        'smtp_port' => (int) ($env['SMTP_PORT'] ?? 587),
        'smtp_secure' => strtolower(trim((string) ($env['SMTP_SECURE'] ?? 'tls'))),
        'smtp_user' => trim((string) ($env['SMTP_USER'] ?? '')),
        'smtp_pass' => (string) ($env['SMTP_PASS'] ?? ''),
        'from_email' => trim((string) ($env['SMTP_FROM_EMAIL'] ?? '')),
        'from_name' => trim((string) ($env['SMTP_FROM_NAME'] ?? 'Nefro-projekt Slovensko')),
        'admin_notification_email' => trim((string) ($env['SMTP_ADMIN_EMAIL'] ?? ($env['ADMIN_EMAIL'] ?? ''))),
        'smtp_timeout' => max(5, min(30, (int) ($env['SMTP_TIMEOUT'] ?? 10))),
    ];

    return $config;
}

function escapeEmailHtml(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function renderEmailHtmlLayout(string $contentHtml, string $actionLabel = '', string $actionUrl = ''): string {
    $brand = 'Nefro-projekt Slovensko';
    $buttonHtml = '';
    if ($actionLabel !== '' && $actionUrl !== '') {
        $buttonHtml = '<p style="text-align:center;margin:28px 0 0;">'
            . '<a href="' . escapeEmailHtml($actionUrl) . '" style="display:inline-block;padding:12px 20px;background:#0055a5;color:#ffffff;border-radius:8px;text-decoration:none;font-weight:600;">'
            . escapeEmailHtml($actionLabel) . '</a></p>';
    }

    return '<!doctype html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>'
        . escapeEmailHtml($brand) . '</title></head><body style="margin:0;padding:0;background:#f4f6f8;color:#111111;font-family:Arial,Helvetica,sans-serif;">'
        . '<table width="100%" cellpadding="0" cellspacing="0" role="presentation"><tr><td align="center" style="padding:24px 12px;">'
        . '<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 18px 50px rgba(15,23,42,0.08);">'
        . '<tr><td style="background:#0055a5;padding:30px;text-align:center;color:#ffffff;font-size:22px;font-weight:700;">'
        . escapeEmailHtml($brand) . '</td></tr>'
        . '<tr><td style="padding:30px;">' . $contentHtml . $buttonHtml
        . '<p style="margin:28px 0 0;color:#6b7280;font-size:13px;line-height:20px;">Ak tento e-mail nevyžadujete, ignorujte ho.</p>'
        . '</td></tr>'
        . '<tr><td style="background:#f3f4f6;padding:18px 30px 22px 30px;color:#64748b;font-size:13px;line-height:20px;text-align:center;">'
        . 'Nefro-projekt Slovensko • <a href="' . escapeEmailHtml(getAppBaseUrl()) . '" style="color:#64748b;text-decoration:underline;">Navštívte web</a>'
        . '</td></tr></table></td></tr></table></body></html>';
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

function sendViaSmtp(string $toEmail, string $subject, string $messageBody, array $cfg, string $contentType = 'text/plain; charset=UTF-8'): bool {
    if ($cfg['smtp_host'] === '' || $cfg['smtp_user'] === '' || $cfg['smtp_pass'] === '' || $cfg['from_email'] === '') {
        return false;
    }

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
        return false;
    }

    stream_set_timeout($socket, (int) $cfg['smtp_timeout']);

    [$code, $bannerResponse] = smtpReadResponse($socket);
    if ($code !== 220) {
        smtpLogError('banner', 'unexpected_code', [
            'expected' => [220],
            'actual' => $code,
            'response' => $bannerResponse,
        ]);
        fclose($socket);
        return false;
    }

    $ehloHost = $_SERVER['SERVER_NAME'] ?? 'localhost';
    if (!smtpSendCommand($socket, 'EHLO ' . $ehloHost, [250], 'ehlo_initial')['ok']) {
        fclose($socket);
        return false;
    }

    if ($cfg['smtp_secure'] === 'tls') {
        if (!smtpSendCommand($socket, 'STARTTLS', [220], 'starttls')['ok']) {
            fclose($socket);
            return false;
        }

        $cryptoEnabled = @stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        if ($cryptoEnabled !== true) {
            smtpLogError('starttls_crypto', 'tls_handshake_failed');
            fclose($socket);
            return false;
        }

        if (!smtpSendCommand($socket, 'EHLO ' . $ehloHost, [250], 'ehlo_tls')['ok']) {
            fclose($socket);
            return false;
        }
    }

    if (!smtpSendCommand($socket, 'AUTH LOGIN', [334], 'auth_login')['ok']) {
        fclose($socket);
        return false;
    }
    if (!smtpSendCommand($socket, base64_encode($cfg['smtp_user']), [334], 'auth_username')['ok']) {
        fclose($socket);
        return false;
    }
    if (!smtpSendCommand($socket, base64_encode($cfg['smtp_pass']), [235], 'auth_password')['ok']) {
        fclose($socket);
        return false;
    }

    if (!smtpSendCommand($socket, 'MAIL FROM:<' . $cfg['from_email'] . '>', [250], 'mail_from')['ok']) {
        fclose($socket);
        return false;
    }
    if (!smtpSendCommand($socket, 'RCPT TO:<' . $toEmail . '>', [250, 251], 'rcpt_to')['ok']) {
        fclose($socket);
        return false;
    }
    if (!smtpSendCommand($socket, 'DATA', [354], 'data')['ok']) {
        fclose($socket);
        return false;
    }

    // mb_encode_mimeheader správne rozdelí dlhý predmet na viacero RFC 2047 encoded words
    // (max. 75 znakov každý) — jednoduchý base64_encode bez delenia lámal diakritiku.
    $encodedSubject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n ");
    $headers = [
        'From: ' . $cfg['from_name'] . ' <' . $cfg['from_email'] . '>',
        'To: <' . $toEmail . '>',
        'Subject: ' . $encodedSubject,
        'MIME-Version: 1.0',
        'Content-Type: ' . $contentType,
        'Content-Transfer-Encoding: 8bit',
        'Date: ' . date(DATE_RFC2822),
    ];

    $payload = implode("\r\n", $headers) . "\r\n\r\n" . str_replace(["\r\n", "\r"], "\n", $messageBody);
    $payload = str_replace("\n", "\r\n", $payload);
    $payload .= "\r\n.\r\n";

    if (@fwrite($socket, $payload) === false) {
        smtpLogError('data_payload', 'write_failed');
        fclose($socket);
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
    fclose($socket);

    return $dataCode === 250;
}

function generateEmailVerificationToken(): array {
    $rawToken = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    $tokenHash = hash('sha256', $rawToken);

    return [
        'token' => $rawToken,
        'token_hash' => $tokenHash,
        'expires_at' => date('Y-m-d H:i:s', time() + 86400), // 24h
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

    $subject = 'Overenie e-mailovej adresy - Nefro-projekt Slovensko';
    $displayName = trim($username) !== '' ? $username : $toEmail;
    $message = "Dobrý deň, " . $displayName . "\n\n"
        . "ďakujeme za registráciu v Nefro-projekt Slovensko.\n"
        . "Pre aktiváciu účtu overte svoju e-mailovú adresu kliknutím na tento odkaz:\n\n"
        . $verifyUrl . "\n\n"
        . "Platnosť odkazu je 24 hodín.\n"
        . "Ak ste sa neregistrovali, tento e-mail ignorujte.\n\n"
        . "Nefro-projekt Slovensko";

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($displayName) . ',</p>'
        . '<p style="margin:0 0 16px;">ďakujeme za registráciu v Nefro-projekt Slovensko.</p>'
        . '<p style="margin:0 0 16px;">Pre aktiváciu účtu overte svoju e-mailovú adresu kliknutím na tlačidlo nižšie.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Ak tlačidlo nefunguje, skopírujte a vložte tento odkaz do prehliadača:</p>'
        . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($verifyUrl) . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($verifyUrl) . '</a></p>'
        . '<p style="margin:0;color:#64748b;font-size:14px;line-height:22px;">Platnosť odkazu je 24 hodín.</p>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Overiť e-mail', $verifyUrl);

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, 'text/html; charset=UTF-8')) {
        return true;
    }

    $fallbackFrom = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . ($cfg['from_name'] ?: 'Nefro-projekt') . ' <' . $fallbackFrom . '>',
    ];

    return @mail($toEmail, $subject, $htmlMessage, implode("\r\n", $headers));
}

function sendPasswordResetEmail(string $toEmail, string $username, string $rawToken): bool {
    $resetUrl = getAppBaseUrl() . '/reset_password.php?token=' . urlencode($rawToken);

    $subject = 'Obnova hesla - Nefro-projekt Slovensko';
    $displayName = trim($username) !== '' ? $username : $toEmail;
    $message = "Dobrý deň, " . $displayName . "\n\n"
        . "prijali sme žiadosť o obnovenie hesla pre váš účet v Nefro-projekt Slovensko.\n"
        . "Nové heslo nastavíte kliknutím na tento odkaz:\n\n"
        . $resetUrl . "\n\n"
        . "Platnosť odkazu je 60 minút.\n"
        . "Ak ste o obnovu hesla nežiadali, tento e-mail ignorujte.\n\n"
        . "Nefro-projekt Slovensko";

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($displayName) . ',</p>'
        . '<p style="margin:0 0 16px;">Prijali sme žiadosť o obnovenie hesla pre váš účet v Nefro-projekt Slovensko.</p>'
        . '<p style="margin:0 0 16px;">Nové heslo nastavíte kliknutím na tlačidlo nižšie.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Ak tlačidlo nefunguje, skopírujte a vložte tento odkaz do prehliadača:</p>'
        . '<p style="margin:0 0 16px;word-break:break-word;"><a href="' . escapeEmailHtml($resetUrl) . '" style="color:#0b61d1;text-decoration:underline;">' . escapeEmailHtml($resetUrl) . '</a></p>'
        . '<p style="margin:0;color:#64748b;font-size:14px;line-height:22px;">Platnosť odkazu je 60 minút.</p>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Obnoviť heslo', $resetUrl);

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, 'text/html; charset=UTF-8')) {
        return true;
    }

    $fallbackFrom = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . ($cfg['from_name'] ?: 'Nefro-projekt') . ' <' . $fallbackFrom . '>',
    ];

    return @mail($toEmail, $subject, $htmlMessage, implode("\r\n", $headers));
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

    $subject = 'Nová registrácia používateľa - Nefro-projekt Slovensko';

    $lines = [];
    $lines[] = 'Bola zaznamenaná nová úspešná registrácia.';
    $lines[] = '';
    $lines[] = 'REGISTRAČNÝ KONTEXT';
    $lines[] = '------------------';
    $lines[] = 'Čas servera: ' . date('Y-m-d H:i:s');
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
        . '<li>Čas servera: ' . escapeEmailHtml(date('Y-m-d H:i:s')) . '</li>'
        . '<li>IP adresa: ' . escapeEmailHtml((string) ($registrationContext['ip'] ?? '-')) . '</li>'
        . '<li>User-Agent: ' . escapeEmailHtml((string) ($registrationContext['user_agent'] ?? '-')) . '</li>'
        . '<li>Referer: ' . escapeEmailHtml((string) ($registrationContext['referer'] ?? '-')) . '</li>'
        . '<li>Request URI: ' . escapeEmailHtml((string) ($registrationContext['request_uri'] ?? '-')) . '</li>'
        . '</ul>'
        . '<h2 style="margin:0 0 14px;font-size:18px;color:#0f172a;">Uložené hodnoty</h2>'
        . '<pre style="margin:0;padding:14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;white-space:pre-wrap;word-break:break-word;color:#334155;font-size:13px;line-height:21px;">' . escapeEmailHtml($message) . '</pre>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody);

    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, 'text/html; charset=UTF-8')) {
        return true;
    }

    $fallbackFrom = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . ($cfg['from_name'] ?: 'Nefro-projekt') . ' <' . $fallbackFrom . '>',
    ];

    return @mail($toEmail, $subject, $htmlMessage, implode("\r\n", $headers));
}

/**
 * Pošle potvrdenie novej registrácie registrovanému používateľovi.
 */
function sendUserRegistrationNotificationEmail(string $toEmail, string $username, array $dbUserRow = []): bool {
    $cfg = getEmailEnvConfig();
    $displayName = trim($username) !== '' ? $username : $toEmail;
    $subject = 'Potvrdenie registrácie - Nefro-projekt Slovensko';

    $firstName = trim((string) ($dbUserRow['first_name'] ?? ''));
    $lastName = trim((string) ($dbUserRow['last_name'] ?? ''));
    $fullName = trim($firstName . ' ' . $lastName);
    $nameLine = $fullName !== '' ? $fullName : $displayName;

    $lines = [];
    $lines[] = 'Dobrý deň, ' . $nameLine . ',';
    $lines[] = '';
    $lines[] = 'váš účet bol úspešne vytvorený v Nefro-projekt Slovensko.';
    $lines[] = '';
    $lines[] = 'Základné údaje registrácie:';
    $lines[] = '- Používateľské meno: ' . (string) ($dbUserRow['username'] ?? $username);
    $lines[] = '- E-mail: ' . (string) ($dbUserRow['email'] ?? $toEmail);
    $lines[] = '- Čas registrácie: ' . date('Y-m-d H:i:s');
    $lines[] = '';
    $lines[] = 'Ak ste túto registráciu nevykonali vy, čo najskôr nás kontaktujte.';
    $lines[] = '';
    $lines[] = 'Nefro-projekt Slovensko';

    $message = implode("\n", $lines);

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($nameLine) . ',</p>'
        . '<p style="margin:0 0 16px;">Váš účet bol úspešne vytvorený v Nefro-projekt Slovensko.</p>'
        . '<div style="margin:18px 0 24px;padding:18px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;color:#334155;line-height:24px;">'
        . '<strong>Základné údaje registrácie:</strong><br>'
        . 'Používateľské meno: ' . escapeEmailHtml((string) ($dbUserRow['username'] ?? $username)) . '<br>'
        . 'E-mail: ' . escapeEmailHtml((string) ($dbUserRow['email'] ?? $toEmail)) . '<br>'
        . 'Čas registrácie: ' . escapeEmailHtml(date('Y-m-d H:i:s')) . '</div>'
        . '<p style="margin:0 0 16px;color:#475569;">Ak ste túto registráciu nevykonali vy, čo najskôr nás kontaktujte.</p>';

    $htmlMessage = renderEmailHtmlLayout($htmlBody);

    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, 'text/html; charset=UTF-8')) {
        return true;
    }

    $fallbackFrom = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . ($cfg['from_name'] ?: 'Nefro-projekt') . ' <' . $fallbackFrom . '>',
    ];

    return @mail($toEmail, $subject, $htmlMessage, implode("\r\n", $headers));
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
    $subject = 'Potvrdenie zrušenia účtu - Nefro-projekt Slovensko';
    $message = "Dobrý deň, " . $displayName . ",\n\n"
        . "prijali sme žiadosť o zrušenie vášho účtu v Nefro-projekt Slovensko.\n\n"
        . "Pre dokončenie a trvalé vymazanie účtu kliknite na tento odkaz:\n\n"
        . $confirmUrl . "\n\n"
        . "Platnosť odkazu je 24 hodín.\n\n"
        . "UPOZORNENIE: Táto akcia je nezvratná. Po potvrdení budú natrvalo vymazané "
        . "všetky vaše údaje vrátane výsledkov kalkulačiek a nastavení profilu.\n\n"
        . "Ak ste o zrušenie účtu nežiadali, tento e-mail ignorujte. "
        . "Váš účet zostane zachovaný.\n\n"
        . "Nefro-projekt Slovensko";

    $htmlBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . escapeEmailHtml($displayName) . ',</p>'
        . '<p style="margin:0 0 16px;">Prijali sme žiadosť o zrušenie vášho účtu v Nefro-projekt Slovensko.</p>'
        . '<p style="margin:0 0 16px;">Pre dokončenie a trvalé vymazanie účtu kliknite na tlačidlo nižšie.</p>'
        . '<p style="margin:0 0 16px;color:#334155;">Odkaz je platný 24 hodín.</p>'
        . '<p style="margin:0 0 16px;color:#334155;font-size:14px;line-height:22px;">Táto akcia je nezvratná. Po potvrdení budú natrvalo vymazané všetky vaše údaje vrátane výsledkov kalkulačiek a nastavení profilu.</p>';
    $htmlMessage = renderEmailHtmlLayout($htmlBody, 'Potvrdiť zrušenie účtu', $confirmUrl);

    $cfg = getEmailEnvConfig();
    if (sendViaSmtp($toEmail, $subject, $htmlMessage, $cfg, 'text/html; charset=UTF-8')) {
        return true;
    }

    $fallbackFrom = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . ($cfg['from_name'] ?: 'Nefro-projekt') . ' <' . $fallbackFrom . '>',
    ];

    return @mail($toEmail, $subject, $htmlMessage, implode("\r\n", $headers));
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
