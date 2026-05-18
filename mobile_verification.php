<?php

require_once __DIR__ . '/config_loader.php';

function generateMobileVerificationCode(): array {
    $code = (string) random_int(100000, 999999);

    return [
        'code' => $code,
        'code_hash' => hash('sha256', $code),
        'expires_at' => date('Y-m-d H:i:s', time() + 600), // 10 min
    ];
}

function saveMobileVerificationCode(PDO $pdo, int $userId, string $codeHash, string $expiresAt): void {
    $stmt = $pdo->prepare("UPDATE users
        SET mobile_verification_code_hash = :code_hash,
            mobile_verification_expires_at = :expires_at,
            mobile_verification_sent_at = NOW(),
            mobile_verified_at = NULL
        WHERE id = :id");
    $stmt->execute([
        'code_hash' => $codeHash,
        'expires_at' => $expiresAt,
        'id' => $userId,
    ]);
}

function markMobileAsVerified(PDO $pdo, int $userId): void {
    $stmt = $pdo->prepare("UPDATE users
        SET mobile_verified_at = NOW(),
            mobile_verification_code_hash = NULL,
            mobile_verification_expires_at = NULL,
            mobile_verification_sent_at = NULL
        WHERE id = :id");
    $stmt->execute(['id' => $userId]);
}

function clearMobileVerification(PDO $pdo, int $userId): void {
    $stmt = $pdo->prepare("UPDATE users
        SET mobile_verified_at = NULL,
            mobile_verification_code_hash = NULL,
            mobile_verification_expires_at = NULL,
            mobile_verification_sent_at = NULL
        WHERE id = :id");
    $stmt->execute(['id' => $userId]);
}

function isMobileResendAllowed(?string $sentAt, int $cooldownSeconds = 60): bool {
    if (empty($sentAt)) {
        return true;
    }

    $sentTs = strtotime((string) $sentAt);
    if ($sentTs === false) {
        return true;
    }

    return (time() - $sentTs) >= $cooldownSeconds;
}

function verifyMobileCodeRecord(array $userRow, string $providedCode): string {
    if (!empty($userRow['mobile_verified_at'])) {
        return 'already_verified';
    }

    if (empty($userRow['mobile_verification_code_hash']) || empty($userRow['mobile_verification_expires_at'])) {
        return 'missing_code';
    }

    if (strtotime((string) $userRow['mobile_verification_expires_at']) < time()) {
        return 'expired';
    }

    if (!preg_match('/^\d{6}$/', $providedCode)) {
        return 'invalid';
    }

    $providedHash = hash('sha256', $providedCode);
    if (!hash_equals((string) $userRow['mobile_verification_code_hash'], $providedHash)) {
        return 'invalid';
    }

    return 'ok';
}

function getMobileVerificationEnvConfig(): array {
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    try {
        $env = loadAppConfig();
    } catch (\RuntimeException $e) {
        error_log('SMS konfigurácia nebola načítaná: ' . $e->getMessage());
        $env = [];
    }

    $config = [
        'sms_provider' => strtolower(trim((string) ($env['SMS_PROVIDER'] ?? 'log'))),
        'sms_sender' => trim((string) ($env['SMS_SENDER'] ?? 'Nefro')),
        'twilio_account_sid' => trim((string) ($env['SMS_TWILIO_ACCOUNT_SID'] ?? $env['TWILIO_ACCOUNT_SID'] ?? '')),
        'twilio_auth_token' => (string) ($env['SMS_TWILIO_AUTH_TOKEN'] ?? $env['TWILIO_AUTH_TOKEN'] ?? ''),
        'twilio_verify_service_sid' => trim((string) ($env['SMS_TWILIO_VERIFY_SERVICE_SID'] ?? $env['TWILIO_VERIFY_SERVICE_SID'] ?? '')),
        'twilio_user_sid' => trim((string) ($env['SMS_TWILIO_USER_SID'] ?? $env['TWILIO_USER_SID'] ?? '')),
    ];

    return $config;
}

function isExternalMobileVerificationProvider(): bool {
    $cfg = getMobileVerificationEnvConfig();
    return ($cfg['sms_provider'] ?? '') === 'twilio_verify';
}

function twilioVerifyApiRequest(string $resourcePath, array $postData): array {
    $cfg = getMobileVerificationEnvConfig();
    $accountSid = (string) ($cfg['twilio_account_sid'] ?? '');
    $authToken = (string) ($cfg['twilio_auth_token'] ?? '');
    $serviceSid = (string) ($cfg['twilio_verify_service_sid'] ?? '');

    if ($accountSid === '' || $authToken === '' || $serviceSid === '') {
        error_log('Twilio Verify config missing (account/auth/service sid).');
        return ['ok' => false, 'status_code' => 0, 'json' => null];
    }

    if (!function_exists('curl_init')) {
        error_log('Twilio Verify requires PHP cURL extension.');
        return ['ok' => false, 'status_code' => 0, 'json' => null];
    }

    $url = 'https://verify.twilio.com/v2/Services/' . rawurlencode($serviceSid) . '/' . ltrim($resourcePath, '/');

    $ch = curl_init($url);
    if ($ch === false) {
        return ['ok' => false, 'status_code' => 0, 'json' => null];
    }

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $accountSid . ':' . $authToken);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $rawResponse = curl_exec($ch);
    $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    unset($ch);

    if ($rawResponse === false) {
        error_log('Twilio Verify request failed: ' . $curlErr);
        return ['ok' => false, 'status_code' => $statusCode, 'json' => null];
    }

    $decoded = json_decode((string) $rawResponse, true);
    $ok = $statusCode >= 200 && $statusCode < 300;

    if (!$ok) {
        $message = '';
        if (is_array($decoded) && !empty($decoded['message'])) {
            $message = (string) $decoded['message'];
        }
        error_log('Twilio Verify API error HTTP ' . $statusCode . ($message !== '' ? (': ' . $message) : ''));
    }

    return ['ok' => $ok, 'status_code' => $statusCode, 'json' => $decoded];
}

function verifyMobileCodeByProvider(array $userRow, ?string $mobilePhone, string $providedCode): string {
    if (isExternalMobileVerificationProvider()) {
        if (!preg_match('/^\d{6}$/', $providedCode)) {
            return 'invalid';
        }
        if (empty($mobilePhone)) {
            return 'missing_code';
        }

        $result = twilioVerifyApiRequest('VerificationCheck', [
            'To' => (string) $mobilePhone,
            'Code' => $providedCode,
        ]);

        if (!$result['ok']) {
            return 'provider_error';
        }

        $status = strtolower((string) (($result['json']['status'] ?? '')));
        if ($status === 'approved') {
            return 'ok';
        }

        return 'invalid';
    }

    return verifyMobileCodeRecord($userRow, $providedCode);
}

function sendMobileVerificationCode(string $mobilePhone, ?string $code = null): bool {
    $cfg = getMobileVerificationEnvConfig();
    $provider = $cfg['sms_provider'];
    $isLocalDev = isAppLocalDev();

    if ($provider === 'twilio_verify') {
        $result = twilioVerifyApiRequest('Verifications', [
            'To' => $mobilePhone,
            'Channel' => 'sms',
        ]);

        if (!$result['ok']) {
            return false;
        }

        $status = strtolower((string) (($result['json']['status'] ?? '')));
        return $status === 'pending' || $status === 'approved';
    }

    // Fallback logovacieho providéra: použiteľný pri lokálnom vývoji, v produkcii zlyhá.
    if ($provider === '' || $provider === 'log') {
        // BEZPEČnosŤ: samotmý overovací kód sa nesmie objaviť v logoch — logy čítajú
        // systémoví administrátori, sú archivované zálohami a môžu byť dostupné
        // cez webový server v chybnej konfigurácii.
        if ($isLocalDev) {
            // V DEV režime logujeme kód (maskované telefónne číslo) pre ladenie
            $maskedPhone = substr($mobilePhone, 0, -4) . '****';
            error_log('[DEV] SMS overovací kód pre ' . $maskedPhone . ': ' . (string) $code);
        } else {
            // V produkcii zaznamenávame IBA fakt o odoslaní, NIE kód
            $maskedPhone = substr($mobilePhone, 0, -4) . '****';
            error_log('SMS verifikácia odoslaná (log provider) na: ' . $maskedPhone);
        }
        return $isLocalDev;
    }

    // Zástupné miesto pre budúce SMS providéry.
    error_log('SMS provider not implemented: ' . $provider . ' for ' . $mobilePhone . ', sender=' . $cfg['sms_sender']);
    return false;
}

/**
 * Vráti true ak je SMS verifikácia zablokovaná kvôli príliš veľa neúspešným pokusom.
 */
function isMobileVerifyLocked(array $user): bool {
    $lockedUntil = $user['mobile_verify_locked_until'] ?? null;
    if (empty($lockedUntil)) {
        return false;
    }
    $ts = strtotime((string) $lockedUntil);
    return $ts !== false && $ts > time();
}

/**
 * Zaznamená neúspešný pokus o overenie SMS kódu.
 * Pri dosiahnutí 5 pokusov nastaví 15-minútový lockout.
 */
function recordMobileVerifyFail(PDO $pdo, int $userId, array $user): void {
    $newCount   = ((int) ($user['mobile_verify_fail_count'] ?? 0)) + 1;
    $maxAttempts = 5;
    $lockoutSecs = 900; // 15 minút
    $lockedUntil = $newCount >= $maxAttempts
        ? date('Y-m-d H:i:s', time() + $lockoutSecs)
        : null;

    $pdo->prepare(
        "UPDATE users
         SET mobile_verify_fail_count = :count,
             mobile_verify_locked_until = :locked_until
         WHERE id = :id"
    )->execute([
        ':count'        => $newCount,
        ':locked_until' => $lockedUntil,
        ':id'           => $userId,
    ]);

    error_log(sprintf(
        'mobile_verify: fail uid=%d attempt=%d/%d%s',
        $userId,
        $newCount,
        $maxAttempts,
        $lockedUntil !== null ? ' LOCKED_UNTIL=' . $lockedUntil : ''
    ));
}

/**
 * Resetuje počítadlo neúspešných pokusov po úspešnom overení SMS kódu.
 */
function resetMobileVerifyAttempts(PDO $pdo, int $userId): void {
    $pdo->prepare(
        "UPDATE users
         SET mobile_verify_fail_count = 0,
             mobile_verify_locked_until = NULL
         WHERE id = :id"
    )->execute([':id' => $userId]);
}
