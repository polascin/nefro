<?php

declare(strict_types=1);

function profileHandleDeleteAccount(PDO $pdo, array $user, int $userId): array
{
    $deleteErrors   = [];
    $showDeleteForm = true;
    $postedCsrfToken = (string) ($_POST['csrf_token'] ?? '');

    if (!validateCsrfToken($postedCsrfToken)) {
        $deleteErrors[] = "Neplatný CSRF token. Skúste to znova.";
    } elseif (isAdmin()) {
        $deleteErrors[] = "Administrátorský účet nie je možné zrušiť z profilu. Požiadajte iného administrátora o zrušenie.";
    } else {
        $confirmPassword = (string) ($_POST['delete_confirm_password'] ?? '');
        if ($confirmPassword === '') {
            $deleteErrors[] = "Pre potvrdenie zadajte svoje aktuálne heslo.";
        } elseif (!password_verify($confirmPassword, (string) $user['password_hash'])) {
            $deleteErrors[] = "Zadané heslo nie je správne. Účet nebol zrušený.";
        } else {
            try {
                $rawToken  = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
                $tokenHash = hash('sha256', $rawToken);
                $expiresAt = date('Y-m-d H:i:s', time() + 86400);
                $clientIp  = getClientIpAddress();

                $pdo->prepare(
                    "INSERT INTO account_deletion_tokens (user_id, token_hash, expires_at, requested_ip)
                     VALUES (:user_id, :token_hash, :expires_at, :requested_ip)
                     ON DUPLICATE KEY UPDATE token_hash = VALUES(token_hash),
                         expires_at = VALUES(expires_at), requested_ip = VALUES(requested_ip),
                         created_at = CURRENT_TIMESTAMP"
                )->execute([
                    'user_id'      => $userId,
                    'token_hash'   => $tokenHash,
                    'expires_at'   => $expiresAt,
                    'requested_ip' => $clientIp,
                ]);

                $emailSent = sendAccountDeletionConfirmationEmail(
                    (string) $user['email'],
                    (string) ($user['username'] ?? ''),
                    $rawToken
                );

                if (!$emailSent) {
                    error_log('Nepodarilo sa odoslať potvrdzovací e-mail pre zrušenie účtu user_id=' . $userId);
                }

                setFlashMessage('info',
                    'Na vašu e-mailovú adresu sme zaslali potvrdzovací odkaz. '
                    . 'Kliknite naň do 24 hodín pre trvalé zrušenie účtu. '
                    . 'Ak e-mail neprišiel, skontrolujte priečinok so spamom.'
                );
                $showDeleteForm = false;

            } catch (\PDOException $e) {
                error_log('Chyba pri generovaní tokenu pre zrušenie účtu user_id=' . $userId . ': ' . $e->getMessage());
                $deleteErrors[] = "Nastala chyba. Skúste to znova neskôr.";
            }
        }
    }

    return ['errors' => $deleteErrors, 'showForm' => $showDeleteForm];
}
