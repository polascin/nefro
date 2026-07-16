<?php
declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

function generateMobileVerificationCode(): array {
    $code = (string) random_int(100000, 999999);

    return [
        'code' => $code,
        'code_hash' => password_hash($code, PASSWORD_DEFAULT),
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
    $status = 'ok';

    if (!empty($userRow['mobile_verified_at'])) {
        $status = 'already_verified';
    } elseif (empty($userRow['mobile_verification_code_hash']) || empty($userRow['mobile_verification_expires_at'])) {
        $status = 'missing_code';
    } elseif (strtotime((string) $userRow['mobile_verification_expires_at']) < time()) {
        $status = 'expired';
    } elseif (!preg_match('/^\d{6}$/', $providedCode)) {
        $status = 'invalid';
    } elseif (!password_verify($providedCode, (string) $userRow['mobile_verification_code_hash'])) {
        $status = 'invalid';
    }

    return $status;
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

    return [
        'sms_provider' => strtolower(trim((string) ($env['SMS_PROVIDER'] ?? 'log'))),
        'sms_sender' => trim((string) ($env['SMS_SENDER'] ?? 'Nefro')),
        'twilio_account_sid' => trim((string) ($env['SMS_TWILIO_ACCOUNT_SID'] ?? $env['TWILIO_ACCOUNT_SID'] ?? '')),
        'twilio_auth_token' => (string) ($env['SMS_TWILIO_AUTH_TOKEN'] ?? $env['TWILIO_AUTH_TOKEN'] ?? ''),
        'twilio_verify_service_sid' => trim((string) ($env['SMS_TWILIO_VERIFY_SERVICE_SID'] ?? $env['TWILIO_VERIFY_SERVICE_SID'] ?? '')),
        'twilio_user_sid' => trim((string) ($env['SMS_TWILIO_USER_SID'] ?? $env['TWILIO_USER_SID'] ?? '')),
    ];
}

function isExternalMobileVerificationProvider(): bool {
    $cfg = getMobileVerificationEnvConfig();
    return ($cfg['sms_provider'] ?? '') === 'twilio_verify';
}

function twilioVerifyMissingConfig(string $accountSid, string $authToken, string $serviceSid): bool {
    $missing = $accountSid === '' || $authToken === '' || $serviceSid === '';
    if ($missing) {
        error_log('Twilio Verify config missing (account/auth/service sid).');
    }
    return $missing;
}

function twilioVerifyExecuteRequest(string $url, string $accountSid, string $authToken, array $postData): array {
    $response = ['ok' => false, 'status_code' => 0, 'json' => null];

    $ch = curl_init($url);
    if ($ch === false) {
        error_log('Twilio Verify request initialization failed.');
        return $response;
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

    if ($rawResponse === false) {
        error_log('Twilio Verify request failed: ' . $curlErr);
        $response['status_code'] = $statusCode;
        return $response;
    }

    $decoded = json_decode((string) $rawResponse, true);
    $ok = $statusCode >= 200 && $statusCode < 300;
    if (!$ok) {
        $providerCode = is_array($decoded) && isset($decoded['code'])
            ? (string) $decoded['code']
            : 'unknown';
        error_log('Twilio Verify API error HTTP ' . $statusCode . '; provider_code=' . $providerCode);
    }

    return ['ok' => $ok, 'status_code' => $statusCode, 'json' => $decoded];
}

function twilioVerifyApiRequest(string $resourcePath, array $postData): array {
    $cfg = getMobileVerificationEnvConfig();
    $accountSid = (string) ($cfg['twilio_account_sid'] ?? '');
    $authToken = (string) ($cfg['twilio_auth_token'] ?? '');
    $serviceSid = (string) ($cfg['twilio_verify_service_sid'] ?? '');

    if (twilioVerifyMissingConfig($accountSid, $authToken, $serviceSid)) {
        return ['ok' => false, 'status_code' => 0, 'json' => null];
    }

    if (!function_exists('curl_init')) {
        error_log('Twilio Verify requires PHP cURL extension.');
        return ['ok' => false, 'status_code' => 0, 'json' => null];
    }

    $url = 'https://verify.twilio.com/v2/Services/' . rawurlencode($serviceSid) . '/' . ltrim($resourcePath, '/');
    return twilioVerifyExecuteRequest($url, $accountSid, $authToken, $postData);
}

function verifyMobileCodeByProvider(array $userRow, ?string $mobilePhone, string $providedCode): string {
    $status = verifyMobileCodeRecord($userRow, $providedCode);

    if (isExternalMobileVerificationProvider()) {
        if (!preg_match('/^\d{6}$/', $providedCode)) {
            $status = 'invalid';
        } elseif (empty($mobilePhone)) {
            $status = 'missing_code';
        } else {
            $result = twilioVerifyApiRequest('VerificationCheck', [
                'To' => (string) $mobilePhone,
                'Code' => $providedCode,
            ]);

            if (!$result['ok']) {
                $status = 'provider_error';
            } else {
                $providerStatus = strtolower((string) ($result['json']['status'] ?? ''));
                $status = $providerStatus === 'approved' ? 'ok' : 'invalid';
            }
        }
    }

    return $status;
}

function sendMobileVerificationCode(string $mobilePhone, ?string $code = null): bool {
    $cfg = getMobileVerificationEnvConfig();
    $provider = $cfg['sms_provider'];
    $isLocalDev = isAppLocalDev();

    $sent = false;

    if ($provider === 'twilio_verify') {
        $result = twilioVerifyApiRequest('Verifications', [
            'To' => $mobilePhone,
            'Channel' => 'sms',
        ]);

        if ($result['ok']) {
            $status = strtolower((string) ($result['json']['status'] ?? ''));
            $sent = $status === 'pending' || $status === 'approved';
        }
    } elseif ($provider === '' || $provider === 'log') {
        // Logovací provider: použiteľný iba pri lokálnom vývoji.
        // BEZPEČNOSŤ: kód sa nesmie objaviť v produkčných logoch.
        $maskedPhone = substr($mobilePhone, 0, -4) . '****';
        if ($isLocalDev) {
            error_log('[DEV] SMS overovací kód pre ' . $maskedPhone . ': ' . (string) $code);
            $sent = true;
        } else {
            // V produkcii zlyhávame explicitne — tichý návrat true by maskoval
            // chýbajúcu konfiguráciu SMS_PROVIDER a používatelia by nikdy SMS nedostali.
            error_log(
                'SMS verifikácia zlyhala: SMS_PROVIDER="' . $provider . '" nie je platný produkčný provider. '
                . 'Nakonfigurujte SMS_PROVIDER=twilio_verify v .env súbore.'
            );
        }
    } else {
        // Zástupné miesto pre budúce SMS providéry.
        error_log('SMS provider not implemented: ' . $provider . ', sender=' . $cfg['sms_sender']);
    }

    return $sent;
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
    $previousCount = (int) ($user['mobile_verify_fail_count'] ?? 0);
    $previousLock = strtotime((string) ($user['mobile_verify_locked_until'] ?? ''));
    if ($previousLock !== false && $previousLock <= time()) {
        $previousCount = 0;
    }
    $newCount   = $previousCount + 1;
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
