<?php
declare(strict_types=1);

require_once __DIR__ . '/email_verification.php';

if (!function_exists('acquireNewsletterProcessLock')) {
    function acquireNewsletterProcessLock(PDO $pdo, string $lockName, int $timeoutSeconds = 0): bool
    {
        $lockName = 'nefro:' . preg_replace('/[^a-z0-9_-]/i', '_', $lockName);
        $timeoutSeconds = max(0, min(30, $timeoutSeconds));
        $stmt = $pdo->prepare('SELECT GET_LOCK(:lock_name, :timeout_seconds)');
        $stmt->bindValue(':lock_name', mb_substr($lockName, 0, 64), PDO::PARAM_STR);
        $stmt->bindValue(':timeout_seconds', $timeoutSeconds, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn() === 1;
    }
}

if (!function_exists('releaseNewsletterProcessLock')) {
    function releaseNewsletterProcessLock(PDO $pdo, string $lockName): void
    {
        $lockName = 'nefro:' . preg_replace('/[^a-z0-9_-]/i', '_', $lockName);
        $stmt = $pdo->prepare('SELECT RELEASE_LOCK(:lock_name)');
        $stmt->execute(['lock_name' => mb_substr($lockName, 0, 64)]);
    }
}

if (!function_exists('getNewsletterUnsubscribeSecret')) {
    function getNewsletterUnsubscribeSecret(): string
    {
        if (!function_exists('isAppLocalDev')) {
            require_once __DIR__ . '/auth.php';
        }

        static $secret = null;
        if ($secret !== null) {
            return $secret;
        }

        $rawSecret = '';
        try {
            $env = loadAppConfig();
            // Povolené zdroje kľúča: iba dedikované aplikačné tajomstvá.
            // DB_PASS a SMTP_PASS sú zámerne vynechané — ich únik by umožnil
            // falšovanie odhlasovacích odkazov.
            $candidates = [
                (string) ($env['NEWSLETTER_UNSUBSCRIBE_SECRET'] ?? ''),
                (string) ($env['APP_KEY'] ?? ''),
                (string) ($env['APP_SECRET'] ?? ''),
            ];
            foreach ($candidates as $candidate) {
                $candidate = trim($candidate);
                if ($candidate !== '') {
                    $rawSecret = $candidate;
                    break;
                }
            }
        } catch (\RuntimeException $e) {
            error_log('Newsletter secret config loading failed: ' . $e->getMessage());
        }

        if ($rawSecret === '') {
            $isLocal = function_exists('isAppLocalDev') && isAppLocalDev();
            if ($isLocal) {
                error_log('SECURITY WARNING: NEWSLETTER_UNSUBSCRIBE_SECRET is not set in env.ini. Using a temporary, insecure development key.');
                $rawSecret = 'dev-insecure-newsletter-secret';
            } else {
                // V produkcii je dedikovaný kľúč povinný. Pád aplikácie je v tomto prípade
                // bezpečnostné opatrenie, ktoré núti administrátora nakonfigurovať kľúč.
                throw new \RuntimeException('NEWSLETTER_UNSUBSCRIBE_SECRET is not configured in env.ini. This is mandatory for production environments.');
            }
        }

        $secret = hash('sha256', $rawSecret);
        return $secret;
    }
}

if (!function_exists('buildNewsletterUnsubscribeSignature')) {
    function buildNewsletterUnsubscribeSignature(int $userId, string $email, int $expiresAt): string
    {
        $normalizedEmail = strtolower(trim($email));
        $payload = $userId . '|' . $normalizedEmail . '|' . $expiresAt;
        return hash_hmac('sha256', $payload, getNewsletterUnsubscribeSecret());
    }
}

if (!function_exists('buildNewsletterUnsubscribeUrl')) {
    function buildNewsletterUnsubscribeUrl(int $userId, string $email, int $ttlSeconds = 2592000): string
    {
        $ttlSeconds = max(3600, min(31536000, $ttlSeconds));
        $expiresAt = time() + $ttlSeconds;
        $signature = buildNewsletterUnsubscribeSignature($userId, $email, $expiresAt);

        return getAppBaseUrl() . '/newsletter_unsubscribe.php?uid=' . urlencode((string) $userId)
            . '&exp=' . urlencode((string) $expiresAt)
            . '&sig=' . urlencode($signature);
    }
}

if (!function_exists('verifyNewsletterUnsubscribeSignature')) {
    function verifyNewsletterUnsubscribeSignature(int $userId, string $email, int $expiresAt, string $signature): bool
    {
        if ($userId <= 0 || $expiresAt <= 0 || trim($signature) === '') {
            return false;
        }

        if ($expiresAt < time()) {
            return false;
        }

        if ($expiresAt > (time() + 31536000)) {
            return false;
        }

        $expected = buildNewsletterUnsubscribeSignature($userId, $email, $expiresAt);
        return hash_equals($expected, trim($signature));
    }
}

if (!function_exists('enqueueArticleNewsletterEmails')) {
    function enqueueArticleNewsletterEmails(PDO $pdo, int $articleId): int
    {
        if ($articleId <= 0) {
            return 0;
        }

        $articleStmt = $pdo->prepare("SELECT id FROM articles WHERE id = :id AND is_published = 1 LIMIT 1");
        $articleStmt->execute(['id' => $articleId]);
        if (!$articleStmt->fetch()) {
            return 0;
        }

        $insertSql = "INSERT IGNORE INTO article_newsletter_queue (article_id, user_id, email, status, next_attempt_at)
            SELECT :article_id, u.id, u.email, 'pending', NOW()
            FROM users u
            WHERE u.newsletter_consent = 1
              AND u.is_active = 1
              AND u.email_verified_at IS NOT NULL
              AND u.email IS NOT NULL
              AND u.email <> ''";

        $stmt = $pdo->prepare($insertSql);
        $stmt->execute(['article_id' => $articleId]);
        $userCount = (int) $stmt->rowCount();

        // Anonymní odberatelia (newsletter_subscribers)
        $subInsertSql = "INSERT IGNORE INTO nl_sub_queue (article_id, subscriber_id, email, status, next_attempt_at)
            SELECT :article_id, s.id, s.email, 'pending', NOW()
            FROM newsletter_subscribers s
            WHERE s.verified_at IS NOT NULL
              AND s.unsubscribed_at IS NULL
              AND s.email IS NOT NULL
              AND s.email <> ''";
        $subStmt = $pdo->prepare($subInsertSql);
        $subStmt->execute(['article_id' => $articleId]);

        return $userCount + (int) $subStmt->rowCount();
    }
}

if (!function_exists('cancelPendingArticleNewsletter')) {
    function cancelPendingArticleNewsletter(PDO $pdo, int $articleId): int
    {
        if ($articleId <= 0) {
            return 0;
        }

        $stmt = $pdo->prepare("UPDATE article_newsletter_queue
            SET status = 'cancelled',
                next_attempt_at = NOW(),
                last_error = 'Článok bol odpublikovaný pred odoslaním noviniek.'
            WHERE article_id = :article_id
              AND status IN ('pending', 'failed')
              AND sent_at IS NULL");
        $stmt->execute(['article_id' => $articleId]);
        $count = (int) $stmt->rowCount();

        $subStmt = $pdo->prepare("UPDATE nl_sub_queue
            SET status = 'cancelled',
                next_attempt_at = NOW(),
                last_error = 'Článok bol odpublikovaný pred odoslaním noviniek.'
            WHERE article_id = :article_id
              AND status IN ('pending', 'failed')
              AND sent_at IS NULL");
        $subStmt->execute(['article_id' => $articleId]);

        return $count + (int) $subStmt->rowCount();
    }
}

if (!function_exists('requeueFailedArticleNewsletter')) {
    function requeueFailedArticleNewsletter(PDO $pdo, int $articleId): int
    {
        if ($articleId <= 0) {
            return 0;
        }

        $stmt = $pdo->prepare("UPDATE article_newsletter_queue q
            INNER JOIN users u ON u.id = q.user_id
            SET q.status = 'pending',
                q.attempts = 0,
                q.next_attempt_at = NOW(),
                q.sent_at = NULL,
                q.last_error = 'Ručne znovu zaradené administrátorom.'
            WHERE q.article_id = :article_id
              AND q.status IN ('failed', 'cancelled')
              AND u.newsletter_consent = 1
              AND u.is_active = 1
              AND u.email_verified_at IS NOT NULL");
        $stmt->execute(['article_id' => $articleId]);
        $count = (int) $stmt->rowCount();

        $subStmt = $pdo->prepare("UPDATE nl_sub_queue q
            INNER JOIN newsletter_subscribers s ON s.id = q.subscriber_id
            SET q.status = 'pending',
                q.attempts = 0,
                q.next_attempt_at = NOW(),
                q.sent_at = NULL,
                q.last_error = 'Ručne znovu zaradené administrátorom.'
            WHERE q.article_id = :article_id
              AND q.status IN ('failed', 'cancelled')
              AND s.verified_at IS NOT NULL
              AND s.unsubscribed_at IS NULL");
        $subStmt->execute(['article_id' => $articleId]);

        return $count + (int) $subStmt->rowCount();
    }
}

if (!function_exists('enqueueArticleNewsletterEmailsNow')) {
    function enqueueArticleNewsletterEmailsNow(PDO $pdo, int $articleId): array
    {
        if ($articleId <= 0) {
            return ['updated' => 0, 'inserted' => 0, 'total' => 0];
        }

        $articleStmt = $pdo->prepare("SELECT id, is_published FROM articles WHERE id = :id LIMIT 1");
        $articleStmt->execute(['id' => $articleId]);
        $article = $articleStmt->fetch();
        if (!$article || (int) ($article['is_published'] ?? 0) !== 1) {
            return ['updated' => 0, 'inserted' => 0, 'total' => 0];
        }

        $updateStmt = $pdo->prepare("UPDATE article_newsletter_queue q
            INNER JOIN users u ON u.id = q.user_id
            SET q.status = 'pending',
                q.attempts = 0,
                q.next_attempt_at = NOW(),
                q.sent_at = NULL,
                q.last_error = 'Ručné odoslanie avíza administrátorom.'
            WHERE q.article_id = :article_id
              AND u.newsletter_consent = 1
              AND u.is_active = 1
              AND u.email_verified_at IS NOT NULL");
        $updateStmt->execute(['article_id' => $articleId]);
        $updated = (int) $updateStmt->rowCount();

        $insertStmt = $pdo->prepare("INSERT IGNORE INTO article_newsletter_queue (article_id, user_id, email, status, next_attempt_at, attempts, sent_at, last_error)
            SELECT :article_id, u.id, u.email, 'pending', NOW(), 0, NULL, 'Ručné odoslanie avíza administrátorom.'
            FROM users u
            WHERE u.newsletter_consent = 1
              AND u.is_active = 1
              AND u.email_verified_at IS NOT NULL
              AND u.email IS NOT NULL
              AND u.email <> ''");
        $insertStmt->execute(['article_id' => $articleId]);
        $inserted = (int) $insertStmt->rowCount();

        $subUpdateStmt = $pdo->prepare("UPDATE nl_sub_queue q
            INNER JOIN newsletter_subscribers s ON s.id = q.subscriber_id
            SET q.status = 'pending',
                q.attempts = 0,
                q.next_attempt_at = NOW(),
                q.sent_at = NULL,
                q.last_error = 'Ručné odoslanie avíza administrátorom.'
            WHERE q.article_id = :article_id
              AND s.verified_at IS NOT NULL
              AND s.unsubscribed_at IS NULL");
        $subUpdateStmt->execute(['article_id' => $articleId]);
        $subUpdated = (int) $subUpdateStmt->rowCount();

        $subInsertStmt = $pdo->prepare("INSERT IGNORE INTO nl_sub_queue (article_id, subscriber_id, email, status, next_attempt_at, attempts, sent_at, last_error)
            SELECT :article_id, s.id, s.email, 'pending', NOW(), 0, NULL, 'Ručné odoslanie avíza administrátorom.'
            FROM newsletter_subscribers s
            WHERE s.verified_at IS NOT NULL
              AND s.unsubscribed_at IS NULL
              AND s.email IS NOT NULL
              AND s.email <> ''");
        $subInsertStmt->execute(['article_id' => $articleId]);
        $subInserted = (int) $subInsertStmt->rowCount();

        return [
            'updated' => $updated + $subUpdated,
            'inserted' => $inserted + $subInserted,
            'total' => $updated + $inserted + $subUpdated + $subInserted,
        ];
    }
}

if (!function_exists('getNewsletterQueueSummary')) {
    function getNewsletterQueueSummary(PDO $pdo): array
    {
        $summary = [
            'pending' => 0,
            'failed' => 0,
            'sent' => 0,
            'cancelled' => 0,
            'due_now' => 0,
            'total' => 0,
        ];

        $stmt = $pdo->query("SELECT status, COUNT(*) AS total
            FROM article_newsletter_queue
            GROUP BY status");
        foreach ($stmt->fetchAll() as $row) {
            $status = (string) ($row['status'] ?? '');
            $total = (int) ($row['total'] ?? 0);
            if (array_key_exists($status, $summary)) {
                $summary[$status] = $total;
            }
            $summary['total'] += $total;
        }

        $dueStmt = $pdo->query("SELECT COUNT(*) FROM article_newsletter_queue
            WHERE status IN ('pending', 'failed')
              AND next_attempt_at <= NOW()
              AND sent_at IS NULL");
        $summary['due_now'] = (int) $dueStmt->fetchColumn();

        return $summary;
    }
}

if (!function_exists('getArticleNewsletterQueueStats')) {
    function getArticleNewsletterQueueStats(PDO $pdo): array
    {
        $stats = [];

        $stmt = $pdo->query("SELECT article_id, status, COUNT(*) AS total
            FROM article_newsletter_queue
            GROUP BY article_id, status");
        foreach ($stmt->fetchAll() as $row) {
            $articleId = (int) ($row['article_id'] ?? 0);
            if ($articleId <= 0) {
                continue;
            }
            if (!isset($stats[$articleId])) {
                $stats[$articleId] = [
                    'pending' => 0,
                    'failed' => 0,
                    'sent' => 0,
                    'cancelled' => 0,
                ];
            }
            $status = (string) ($row['status'] ?? '');
            if (isset($stats[$articleId][$status])) {
                $stats[$articleId][$status] = (int) ($row['total'] ?? 0);
            }
        }

        return $stats;
    }
}

if (!function_exists('getNewsletterQueueRecent')) {
    function getNewsletterQueueRecent(PDO $pdo, int $limit = 40, string $statusFilter = '', int $articleIdFilter = 0, string $presetFilter = ''): array
    {
        $limit = max(1, min(200, $limit));
        $allowedStatuses = ['pending', 'failed', 'sent', 'cancelled'];
        $statusFilter = strtolower(trim($statusFilter));
        if (!in_array($statusFilter, $allowedStatuses, true)) {
            $statusFilter = '';
        }

        $presetFilter = strtolower(trim($presetFilter));
        if (!in_array($presetFilter, ['', 'unsent', 'due_now'], true)) {
            $presetFilter = '';
        }

        $where = [];
        $params = [];

        if ($presetFilter === 'unsent') {
            $where[] = "q.status IN ('pending', 'failed')";
        } elseif ($presetFilter === 'due_now') {
            $where[] = "q.status IN ('pending', 'failed')";
            $where[] = 'q.next_attempt_at <= NOW()';
            $where[] = 'q.sent_at IS NULL';
        }

        if ($statusFilter !== '') {
            $where[] = 'q.status = :status_filter';
            $params['status_filter'] = $statusFilter;
        }

        if ($articleIdFilter > 0) {
            $where[] = 'q.article_id = :article_id_filter';
            $params['article_id_filter'] = $articleIdFilter;
        }

        $sql = "SELECT q.id, q.article_id, q.user_id, q.email, q.status, q.attempts, q.next_attempt_at, q.sent_at, q.last_error, q.updated_at,
                a.title AS article_title,
                u.username
            FROM article_newsletter_queue q
            LEFT JOIN articles a ON a.id = q.article_id
            LEFT JOIN users u ON u.id = q.user_id";

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= " ORDER BY q.updated_at DESC, q.id DESC
            LIMIT :limit_rows";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            if ($key === 'article_id_filter') {
                $stmt->bindValue(':' . $key, (int) $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':' . $key, (string) $value, PDO::PARAM_STR);
            }
        }
        $stmt->bindValue(':limit_rows', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

if (!function_exists('buildSubscriberUnsubscribeUrl')) {
    function buildSubscriberUnsubscribeUrl(int $subscriberId, string $unsubToken): string
    {
        return getAppBaseUrl() . '/newsletter_unsubscribe.php?sub=' . urlencode((string) $subscriberId)
            . '&token=' . urlencode($unsubToken);
    }
}

if (!function_exists('buildSubscriberUnsubscribeHmacUrl')) {
    function buildSubscriberUnsubscribeHmacUrl(int $subscriberId, string $email, int $ttlSeconds = 315360000): string
    {
        $ttlSeconds      = max(86400, min(315360000, $ttlSeconds));
        $expiresAt       = time() + $ttlSeconds;
        $normalizedEmail = strtolower(trim($email));
        $payload         = $subscriberId . '|' . $normalizedEmail . '|' . $expiresAt;
        $signature       = hash_hmac('sha256', $payload, getNewsletterUnsubscribeSecret());

        return getAppBaseUrl() . '/newsletter_unsubscribe.php?sub=' . urlencode((string) $subscriberId)
            . '&exp=' . urlencode((string) $expiresAt)
            . '&sig=' . urlencode($signature);
    }
}

if (!function_exists('verifySubscriberUnsubscribeHmac')) {
    function verifySubscriberUnsubscribeHmac(int $subscriberId, string $email, int $expiresAt, string $signature): bool
    {
        if ($subscriberId <= 0 || $expiresAt <= 0 || trim($signature) === '') {
            return false;
        }
        if ($expiresAt < time()) {
            return false;
        }
        $normalizedEmail = strtolower(trim($email));
        $payload         = $subscriberId . '|' . $normalizedEmail . '|' . $expiresAt;
        $expected        = hash_hmac('sha256', $payload, getNewsletterUnsubscribeSecret());
        return hash_equals($expected, trim($signature));
    }
}

if (!function_exists('sendSubscriberVerifyEmail')) {
    function sendSubscriberVerifyEmail(string $email, string $verifyToken): bool
    {
        $verifyUrl     = getAppBaseUrl() . '/newsletter_verify_sub.php?token=' . urlencode($verifyToken);
        $subject       = 'Potvrďte odber noviniek - Nefro-projekt Slovensko';
        $verifyUrlHtml = htmlspecialchars($verifyUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $body = '<p style="margin:0 0 16px;">Dobrý deň,</p>'
            . '<p style="margin:0 0 16px;">Požiadali ste o odber noviniek z webu Nefro-projekt Slovensko.</p>'
            . '<p style="margin:0 0 16px;">Kliknite na tlačidlo nižšie a potvrďte svoju e-mailovú adresu:</p>'
            . '<p style="margin:0 0 24px;"><a href="' . $verifyUrlHtml . '" style="display:inline-block;padding:12px 20px;background:#0055a5;color:#ffffff;border-radius:8px;text-decoration:none;font-weight:600;">Potvrdiť odber</a></p>'
            . '<p style="margin:0 0 16px;color:#475569;font-size:13px;">Ak ste o odber nepožiadali, tento e-mail ignorujte. Odkaz vyprší po 7 dňoch.</p>'
            . '<p style="margin:0 0 16px;color:#475569;font-size:13px;">Priamy odkaz: <a href="' . $verifyUrlHtml . '" style="color:#1d4ed8;">' . $verifyUrlHtml . '</a></p>';

        $message = renderEmailHtmlLayout($body, 'Potvrdiť odber', $verifyUrl);
        $cfg     = getEmailEnvConfig();
        $sent    = sendViaSmtp($email, $subject, $message, $cfg, 'text/html; charset=UTF-8');

        if (!$sent) {
            $fallbackFrom     = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
            $fallbackFromName = mb_encode_mimeheader($cfg['from_name'] ?: 'Nefro-projekt', 'UTF-8', 'B', "\r\n ");
            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8',
                'Content-Transfer-Encoding: quoted-printable',
                'From: ' . $fallbackFromName . ' <' . $fallbackFrom . '>',
            ];
            // QP kódovanie: dlhý jednoriadkový HTML inak MTA zalomí (>998 oktetov) → medzery v texte
            $sent = @mail($email, mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n "), quoted_printable_encode($message), implode("\r\n", $headers));
        }

        return $sent;
    }
}

if (!function_exists('processNlSubQueue')) {
    function processNlSubQueue(PDO $pdo, int $limit = 50, int $maxAttempts = 5): array
    {
        $limit       = max(1, min(500, $limit));
        $maxAttempts = max(1, min(20, $maxAttempts));

        $stats = ['selected' => 0, 'sent' => 0, 'failed' => 0, 'cancelled' => 0, 'skipped' => 0];

        $selectStmt = $pdo->prepare("SELECT id FROM nl_sub_queue
            WHERE status IN ('pending','failed')
              AND attempts < :max_attempts
              AND next_attempt_at <= NOW()
              AND sent_at IS NULL
            ORDER BY next_attempt_at ASC, id ASC
            LIMIT :limit_rows");
        $selectStmt->bindValue(':max_attempts', $maxAttempts, PDO::PARAM_INT);
        $selectStmt->bindValue(':limit_rows', $limit, PDO::PARAM_INT);
        $selectStmt->execute();
        $ids                = $selectStmt->fetchAll(PDO::FETCH_COLUMN);
        $stats['selected']  = count($ids);

        $itemStmt = $pdo->prepare("SELECT q.id, q.article_id, q.subscriber_id, q.email, q.attempts,
                a.title, a.slug, a.excerpt, a.is_published,
                s.verified_at, s.unsubscribed_at
            FROM nl_sub_queue q
            LEFT JOIN articles a ON a.id = q.article_id
            LEFT JOIN newsletter_subscribers s ON s.id = q.subscriber_id
            WHERE q.id = :id LIMIT 1");

        $cancelStmt = $pdo->prepare("UPDATE nl_sub_queue SET status='cancelled', next_attempt_at=NOW(), last_error=:reason WHERE id=:id AND sent_at IS NULL");
        $failStmt   = $pdo->prepare("UPDATE nl_sub_queue SET status='failed', attempts=:attempts, next_attempt_at=:next_attempt_at, last_error=:last_error WHERE id=:id AND sent_at IS NULL");
        $successStmt = $pdo->prepare("UPDATE nl_sub_queue SET status='sent', attempts=attempts+1, sent_at=NOW(), last_error=NULL WHERE id=:id AND sent_at IS NULL");

        foreach ($ids as $queueIdRaw) {
            $queueId = (int) $queueIdRaw;
            if ($queueId <= 0) { $stats['skipped']++; continue; }

            $itemStmt->execute(['id' => $queueId]);
            $item = $itemStmt->fetch();
            if (!$item) { $stats['skipped']++; continue; }

            $cancelReason = null;
            if (empty($item['title']) || (int) ($item['is_published'] ?? 0) !== 1) {
                $cancelReason = 'Článok nie je publikovaný alebo už neexistuje.';
            } elseif ($item['verified_at'] === null) {
                $cancelReason = 'E-mail odberateľa nie je overený.';
            } elseif ($item['unsubscribed_at'] !== null) {
                $cancelReason = 'Odberateľ sa odhlásil z noviniek.';
            }

            if ($cancelReason !== null) {
                $cancelStmt->execute(['id' => $queueId, 'reason' => $cancelReason]);
                $stats['cancelled']++;
                continue;
            }

            $recipientEmail = trim((string) ($item['email'] ?? ''));
            if ($recipientEmail === '' || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                $failAttempt    = (int) ($item['attempts'] ?? 0) + 1;
                $nextAttemptAt  = date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60));
                $failStmt->execute(['id' => $queueId, 'attempts' => $failAttempt, 'next_attempt_at' => $nextAttemptAt, 'last_error' => 'Neplatný e-mail.']);
                $stats['failed']++;
                continue;
            }

            $unsubscribeUrl     = buildSubscriberUnsubscribeHmacUrl((int) $item['subscriber_id'], $recipientEmail);
            $articleUrl         = getAppBaseUrl() . '/article.php?slug=' . urlencode((string) ($item['slug'] ?? ''));
            $subject            = 'Nový článok: ' . (string) $item['title'] . ' - Nefro-projekt Slovensko';
            $titleHtml          = htmlspecialchars((string) $item['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $articleUrlEsc      = htmlspecialchars($articleUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $unsubscribeUrlEsc  = htmlspecialchars($unsubscribeUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $excerpt            = mb_substr(trim(strip_tags((string) ($item['excerpt'] ?? ''))), 0, 320);
            $excerptHtml        = $excerpt !== ''
                ? '<p><strong>Perex:</strong><br>' . nl2br(htmlspecialchars($excerpt, ENT_QUOTES | ENT_HTML5, 'UTF-8')) . '</p>'
                : '';

            $messageBody = '<p style="margin:0 0 16px;">Dobrý deň,</p>'
                . '<p style="margin:0 0 16px;">Bol publikovaný nový článok na Nefro-projekt Slovensko.</p>'
                . '<h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">' . $titleHtml . '</h2>'
                . '<p style="margin:0 0 16px;"><a href="' . $articleUrlEsc . '" style="color:#1d4ed8;text-decoration:none;font-weight:600;">Prečítajte si článok</a></p>'
                . $excerptHtml
                . '<p style="margin:24px 0 16px;color:#475569;line-height:22px;">Tento e-mail ste dostali, pretože ste prihlásení na odber noviniek.<br>'
                . 'Ak už nechcete dostávať novinky, otvorte odkaz a potvrďte odhlásenie:<br>'
                . '<a href="' . $unsubscribeUrlEsc . '" style="color:#1d4ed8;text-decoration:underline;">Odhlásiť sa</a></p>';

            $message = renderEmailHtmlLayout($messageBody, 'Zobraziť článok', $articleUrl, medimpaxEmailFooterHtml());
            $cfg     = getEmailEnvConfig();
            $sent    = sendViaSmtp($recipientEmail, $subject, $message, $cfg, 'text/html; charset=UTF-8');

            if (!$sent) {
                $fallbackFrom     = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
                $fallbackFromName = mb_encode_mimeheader($cfg['from_name'] ?: 'Nefro-projekt', 'UTF-8', 'B', "\r\n ");
                $headers = ['MIME-Version: 1.0', 'Content-Type: text/html; charset=UTF-8', 'Content-Transfer-Encoding: quoted-printable', 'From: ' . $fallbackFromName . ' <' . $fallbackFrom . '>'];
                $sent    = @mail($recipientEmail, mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n "), quoted_printable_encode($message), implode("\r\n", $headers));
            }

            if ($sent) {
                $successStmt->execute(['id' => $queueId]);
                $stats['sent']++;
            } else {
                $failAttempt   = (int) ($item['attempts'] ?? 0) + 1;
                $nextAttemptAt = date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60));
                $failStmt->execute(['id' => $queueId, 'attempts' => $failAttempt, 'next_attempt_at' => $nextAttemptAt, 'last_error' => 'SMTP zlyhalo.']);
                $stats['failed']++;
            }
        }

        return $stats;
    }
}

if (!function_exists('processArticleNewsletterQueue')) {
    function processArticleNewsletterQueue(PDO $pdo, int $limit = 50, int $maxAttempts = 5): array
    {
        $limit = max(1, min(500, $limit));
        $maxAttempts = max(1, min(20, $maxAttempts));

        $stats = [
            'selected' => 0,
            'sent' => 0,
            'failed' => 0,
            'cancelled' => 0,
            'skipped' => 0,
        ];

        $selectStmt = $pdo->prepare("SELECT id
            FROM article_newsletter_queue
            WHERE status IN ('pending', 'failed')
              AND attempts < :max_attempts
              AND next_attempt_at <= NOW()
              AND sent_at IS NULL
            ORDER BY next_attempt_at ASC, id ASC
            LIMIT :limit_rows");
        $selectStmt->bindValue(':max_attempts', $maxAttempts, PDO::PARAM_INT);
        $selectStmt->bindValue(':limit_rows', $limit, PDO::PARAM_INT);
        $selectStmt->execute();

        $ids = $selectStmt->fetchAll(PDO::FETCH_COLUMN);
        $stats['selected'] = count($ids);

        // Príprava dopytov mimo cyklu pre maximalizáciu výkonu
        $itemStmt = $pdo->prepare("SELECT
                q.id, q.article_id, q.user_id, q.email, q.attempts,
                a.title, a.slug, a.excerpt, a.is_published,
                u.username, u.title_before, u.first_name, u.middle_name,
                u.last_name, u.title_after, u.email AS user_email,
                u.newsletter_consent, u.is_active, u.email_verified_at
            FROM article_newsletter_queue q
            LEFT JOIN articles a ON a.id = q.article_id
            LEFT JOIN users u ON u.id = q.user_id
            WHERE q.id = :id
            LIMIT 1");

        $cancelStmt = $pdo->prepare("UPDATE article_newsletter_queue
            SET status = 'cancelled',
                next_attempt_at = NOW(),
                last_error = :reason
            WHERE id = :id AND sent_at IS NULL");

        $failStmt = $pdo->prepare("UPDATE article_newsletter_queue
            SET status = 'failed',
                attempts = :attempts,
                next_attempt_at = :next_attempt_at,
                last_error = :last_error
            WHERE id = :id AND sent_at IS NULL");

        $successStmt = $pdo->prepare("UPDATE article_newsletter_queue
            SET status = 'sent',
                attempts = attempts + 1,
                sent_at = NOW(),
                last_error = NULL
            WHERE id = :id AND sent_at IS NULL");

        foreach ($ids as $queueIdRaw) {
            $queueId = (int) $queueIdRaw;
            if ($queueId <= 0) {
                $stats['skipped']++;
                continue;
            }

            $itemStmt->execute(['id' => $queueId]);
            $item = $itemStmt->fetch();

            if (!$item) {
                $stats['skipped']++;
                continue;
            }

            $cancelReason = null;
            if (empty($item['title']) || (int) ($item['is_published'] ?? 0) !== 1) {
                $cancelReason = 'Článok nie je publikovaný alebo už neexistuje.';
            } elseif ((int) ($item['newsletter_consent'] ?? 0) !== 1) {
                $cancelReason = 'Používateľ odvolal súhlas s novinkami.';
            } elseif ((int) ($item['is_active'] ?? 0) !== 1) {
                $cancelReason = 'Používateľský účet je neaktívny.';
            } elseif (empty($item['email_verified_at'])) {
                $cancelReason = 'E-mail používateľa nie je overený.';
            }

            if ($cancelReason !== null) {
                $cancelStmt->execute([
                    'id' => $queueId,
                    'reason' => $cancelReason,
                ]);
                $stats['cancelled']++;
                continue;
            }

            $recipientEmail = trim((string) ($item['user_email'] ?? $item['email'] ?? ''));
            if ($recipientEmail === '' || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $nextAttemptAt = date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60));

                $failStmt->execute([
                    'id' => $queueId,
                    'attempts' => $failAttempt,
                    'next_attempt_at' => $nextAttemptAt,
                    'last_error' => 'Neplatný alebo chýbajúci e-mail príjemcu.',
                ]);
                $stats['failed']++;
                continue;
            }

            $subject = 'Nový článok: ' . (string) $item['title'] . ' - Nefro-projekt Slovensko';
            $articleUrl = getAppBaseUrl() . '/article.php?slug=' . urlencode((string) ($item['slug'] ?? ''));
            $unsubscribeUrl = buildNewsletterUnsubscribeUrl((int) ($item['user_id'] ?? 0), $recipientEmail);
            $excerpt = trim((string) strip_tags((string) ($item['excerpt'] ?? '')));
            if ($excerpt !== '') {
                $excerpt = mb_substr($excerpt, 0, 320);
            }

            $titleBefore = trim((string) ($item['title_before'] ?? ''));
            $firstName = trim((string) ($item['first_name'] ?? ''));
            $middleName = trim((string) ($item['middle_name'] ?? ''));
            $lastName = trim((string) ($item['last_name'] ?? ''));
            $titleAfter = trim((string) ($item['title_after'] ?? ''));
            if ($firstName !== '' && $lastName !== '') {
                $nameParts = array_filter([
                    $titleBefore,
                    $firstName,
                    $middleName,
                ], static fn ($part) => $part !== '');
                $nameParts[] = $lastName;

                $displayName = trim(implode(' ', $nameParts));
                if ($titleAfter !== '') {
                    $displayName .= ', ' . $titleAfter;
                }
            } else {
                $displayName = trim((string) ($item['username'] ?? ''));
                if ($displayName === '') {
                    $displayName = $recipientEmail;
                }
            }

            $titleHtml = htmlspecialchars((string) $item['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $articleUrlEscaped = htmlspecialchars($articleUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $unsubscribeUrlEscaped = htmlspecialchars($unsubscribeUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $excerptHtml = $excerpt !== ''
                ? '<p><strong>Perex:</strong><br>' . nl2br(htmlspecialchars($excerpt, ENT_QUOTES | ENT_HTML5, 'UTF-8')) . '</p>'
                : '';

            $messageBody = '<p style="margin:0 0 16px;">Dobrý deň, ' . htmlspecialchars($displayName, ENT_QUOTES | ENT_HTML5, 'UTF-8') . ',</p>'
                . '<p style="margin:0 0 16px;">Bol publikovaný nový článok na Nefro-projekt Slovensko.</p>'
                . '<h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">' . $titleHtml . '</h2>'
                . '<p style="margin:0 0 16px;"><a href="' . $articleUrlEscaped . '" style="color:#1d4ed8;text-decoration:none;font-weight:600;">Prečítajte si článok</a></p>'
                . $excerptHtml
                . '<p style="margin:24px 0 16px;color:#475569;line-height:22px;">Tento e-mail ste dostali, pretože máte povolené zasielanie noviniek.<br>'
                . 'Nastavenie môžete zmeniť vo svojom profile.</p>'
                . '<p style="margin:0 0 16px;color:#475569;line-height:22px;">Ak už nechcete dostávať novinky, otvorte odkaz a potvrďte odhlásenie:<br>'
                . '<a href="' . $unsubscribeUrlEscaped . '" style="color:#1d4ed8;text-decoration:underline;">Odhlásiť sa</a></p>';
            $message = renderEmailHtmlLayout($messageBody, 'Zobraziť článok', $articleUrl, medimpaxEmailFooterHtml());

            $cfg = getEmailEnvConfig();
            $sent = sendViaSmtp($recipientEmail, $subject, $message, $cfg, 'text/html; charset=UTF-8');
            if (!$sent) {
                $fallbackFrom = $cfg['from_email'] !== ''
                    ? $cfg['from_email']
                    : 'no-reply@nefro.polascin.net';
                $fallbackFromName = mb_encode_mimeheader($cfg['from_name'] ?: 'Nefro-projekt', 'UTF-8', 'B', "\r\n ");
                $fallbackSubject = mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n ");
                $headers = [
                    'MIME-Version: 1.0',
                    'Content-Type: text/html; charset=UTF-8',
                    'Content-Transfer-Encoding: quoted-printable',
                    'From: ' . $fallbackFromName . ' <' . $fallbackFrom . '>',
                ];
                $sent = @mail($recipientEmail, $fallbackSubject, quoted_printable_encode($message), implode("\r\n", $headers));
            }

            if ($sent) {
                $successStmt->execute(['id' => $queueId]);
                $stats['sent']++;
            } else {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $nextAttemptAt = date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60));

                $failStmt->execute([
                    'id' => $queueId,
                    'attempts' => $failAttempt,
                    'next_attempt_at' => $nextAttemptAt,
                    'last_error' => 'SMTP odoslanie zlyhalo.',
                ]);
                $stats['failed']++;
            }
        }

        return $stats;
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Týždenný prehľad (digest) — jeden e-mail so súhrnom článkov za uplynulé obdobie.
// Doplnok k okamžitým avízam pri publikovaní; posiela sa hromadne (cron/CLI).
// ─────────────────────────────────────────────────────────────────────────────

if (!function_exists('ensureWeeklyDigestTable')) {
    function ensureWeeklyDigestTable(PDO $pdo): void
    {
        $pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_digest_runs (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            window_start DATETIME NOT NULL,
            window_end DATETIME NOT NULL,
            articles_count INT NOT NULL DEFAULT 0,
            users_sent INT NOT NULL DEFAULT 0,
            subscribers_sent INT NOT NULL DEFAULT 0,
            failed INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_ndr_window_end (window_end)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }
}

if (!function_exists('getWeeklyDigestArticles')) {
    function getWeeklyDigestArticles(PDO $pdo, string $since, string $until): array
    {
        $stmt = $pdo->prepare("SELECT id, title, slug, excerpt, published_at
            FROM articles
            WHERE is_published = 1
              AND published_at > :since
              AND published_at <= :until
            ORDER BY published_at DESC, id DESC");
        $stmt->execute(['since' => $since, 'until' => $until]);
        return $stmt->fetchAll();
    }
}

if (!function_exists('buildWeeklyDigestArticlesHtml')) {
    function buildWeeklyDigestArticlesHtml(array $articles): string
    {
        $baseUrl = getAppBaseUrl();
        $items   = '';
        foreach ($articles as $a) {
            $title = htmlspecialchars((string) ($a['title'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $url   = htmlspecialchars($baseUrl . '/article.php?slug=' . urlencode((string) ($a['slug'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $excerptRaw = trim(strip_tags((string) ($a['excerpt'] ?? '')));
            $excerptHtml = $excerptRaw !== ''
                ? '<p style="margin:6px 0 0;color:#475569;font-size:14px;line-height:20px;">'
                    . htmlspecialchars(mb_substr($excerptRaw, 0, 280), ENT_QUOTES | ENT_HTML5, 'UTF-8') . '</p>'
                : '';
            $items .= '<div style="padding:16px 0;border-bottom:1px solid #e5e7eb;">'
                . '<a href="' . $url . '" style="color:#0f172a;font-size:17px;font-weight:700;text-decoration:none;line-height:24px;">' . $title . '</a>'
                . $excerptHtml
                . '<p style="margin:8px 0 0;"><a href="' . $url . '" style="color:#1d4ed8;text-decoration:none;font-weight:600;font-size:14px;">Prečítať článok →</a></p>'
                . '</div>';
        }
        return $items;
    }
}

if (!function_exists('sendWeeklyNewsletterDigest')) {
    /**
     * Pošle týždenný prehľad nových článkov všetkým overeným príjemcom
     * (registrovaní používatelia so súhlasom + anonymní odberatelia).
     *
     * @param array $opts  days (int, predvolené 7), dry_run (bool), ignore_last_run (bool)
     * @return array  Súhrn behu.
     */
    function sendWeeklyNewsletterDigest(PDO $pdo, array $opts = []): array
    {
        ensureWeeklyDigestTable($pdo);

        $fallbackDays = max(1, min(60, (int) ($opts['days'] ?? 7)));
        $dryRun       = !empty($opts['dry_run']);
        $ignoreLast   = !empty($opts['ignore_last_run']);
        $seed         = !empty($opts['seed']);

        $until = (new DateTime('now'))->format('Y-m-d H:i:s');

        // Okno: od konca posledného behu (aby sa články neopakovali), inak now - fallbackDays.
        $since = null;
        if (!$ignoreLast) {
            $lastEnd = $pdo->query("SELECT window_end FROM newsletter_digest_runs ORDER BY id DESC LIMIT 1")->fetchColumn();
            if ($lastEnd) {
                $since = (string) $lastEnd;
            }
        }
        if ($since === null) {
            $since = (new DateTime('now'))->modify('-' . $fallbackDays . ' days')->format('Y-m-d H:i:s');
        }

        $articles = getWeeklyDigestArticles($pdo, $since, $until);

        $result = [
            'window_start'     => $since,
            'window_end'       => $until,
            'articles'         => count($articles),
            'users_sent'       => 0,
            'subscribers_sent' => 0,
            'failed'           => 0,
            'skipped_empty'    => false,
            'seeded'           => false,
            'dry_run'          => $dryRun,
        ];

        // SEED: iba nastaví základňu okna (zaznamená beh bez odoslania), aby ďalší
        // (týždenný) beh posielal len články pridané po tomto bode. Použité na
        // „presunutie“ prvého prehľadu na ďalší cyklus bez zopakovania už avizovaných článkov.
        if ($seed) {
            if (!$dryRun) {
                $logStmt = $pdo->prepare("INSERT INTO newsletter_digest_runs
                    (window_start, window_end, articles_count, users_sent, subscribers_sent, failed)
                    VALUES (:ws, :we, :ac, 0, 0, 0)");
                $logStmt->execute(['ws' => $since, 'we' => $until, 'ac' => count($articles)]);
            }
            $result['seeded'] = true;
            return $result;
        }

        if (empty($articles)) {
            // Prázdny prehľad neposielame; beh ani nezaznamenávame, aby sa okno neposunulo.
            $result['skipped_empty'] = true;
            return $result;
        }

        $articlesHtml = buildWeeklyDigestArticlesHtml($articles);
        $count        = count($articles);
        $intro        = $count === 1
            ? 'Za uplynulé obdobie pribudol nový článok:'
            : 'Za uplynulé obdobie pribudli nové články (' . $count . '):';
        $subject      = $count === 1
            ? 'Týždenný prehľad: 1 nový článok – Nefro-projekt Slovensko'
            : 'Týždenný prehľad: ' . $count . ' nových článkov – Nefro-projekt Slovensko';
        $cfg          = getEmailEnvConfig();

        $sendOne = static function (string $email, string $unsubscribeUrl, string $greetingName) use ($articlesHtml, $intro, $subject, $cfg, $dryRun): bool {
            if ($dryRun) {
                return true;
            }
            $greeting = $greetingName !== ''
                ? 'Dobrý deň, ' . htmlspecialchars($greetingName, ENT_QUOTES | ENT_HTML5, 'UTF-8') . ','
                : 'Dobrý deň,';
            $unsubEsc = htmlspecialchars($unsubscribeUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $body = '<p style="margin:0 0 16px;">' . $greeting . '</p>'
                . '<p style="margin:0 0 8px;">' . $intro . '</p>'
                . $articlesHtml
                . '<p style="margin:24px 0 16px;color:#475569;line-height:22px;">Tento prehľad ste dostali, pretože odoberáte novinky z webu Nefro-projekt Slovensko.<br>'
                . 'Ak už nechcete dostávať novinky, otvorte odkaz a potvrďte odhlásenie:<br>'
                . '<a href="' . $unsubEsc . '" style="color:#1d4ed8;text-decoration:underline;">Odhlásiť sa</a></p>';
            $message = renderEmailHtmlLayout($body, 'Zobraziť všetky články', getAppBaseUrl(), medimpaxEmailFooterHtml());

            $sent = sendViaSmtp($email, $subject, $message, $cfg, 'text/html; charset=UTF-8');
            if (!$sent) {
                $fallbackFrom     = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
                $fallbackFromName = mb_encode_mimeheader($cfg['from_name'] ?: 'Nefro-projekt', 'UTF-8', 'B', "\r\n ");
                $headers = ['MIME-Version: 1.0', 'Content-Type: text/html; charset=UTF-8', 'Content-Transfer-Encoding: quoted-printable', 'From: ' . $fallbackFromName . ' <' . $fallbackFrom . '>'];
                $sent = @mail($email, mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n "), quoted_printable_encode($message), implode("\r\n", $headers));
            }
            return $sent;
        };

        // Deduplikácia podľa e-mailu (používateľ aj odberateľ s rovnakým e-mailom dostane len jeden prehľad).
        $sentEmails = [];

        // 1) Registrovaní používatelia so súhlasom
        $userStmt = $pdo->query("SELECT id, email, title_before, first_name, middle_name, last_name, title_after, username
            FROM users
            WHERE newsletter_consent = 1 AND is_active = 1 AND email_verified_at IS NOT NULL
              AND email IS NOT NULL AND email <> ''");
        foreach ($userStmt->fetchAll() as $u) {
            $email = trim((string) ($u['email'] ?? ''));
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result['failed']++;
                continue;
            }
            $emailKey = strtolower($email);
            if (isset($sentEmails[$emailKey])) {
                continue;
            }

            $first = trim((string) ($u['first_name'] ?? ''));
            $last  = trim((string) ($u['last_name'] ?? ''));
            if ($first !== '' && $last !== '') {
                $parts = array_filter([
                    trim((string) ($u['title_before'] ?? '')),
                    $first,
                    trim((string) ($u['middle_name'] ?? '')),
                ], static fn ($p) => $p !== '');
                $parts[] = $last;
                $name = trim(implode(' ', $parts));
                $titleAfter = trim((string) ($u['title_after'] ?? ''));
                if ($titleAfter !== '') {
                    $name .= ', ' . $titleAfter;
                }
            } else {
                $name = trim((string) ($u['username'] ?? ''));
            }

            $unsub = buildNewsletterUnsubscribeUrl((int) $u['id'], $email);
            if ($sendOne($email, $unsub, $name)) {
                $result['users_sent']++;
                $sentEmails[$emailKey] = true;
            } else {
                $result['failed']++;
            }
        }

        // 2) Anonymní odberatelia
        $subStmt = $pdo->query("SELECT id, email FROM newsletter_subscribers
            WHERE verified_at IS NOT NULL AND unsubscribed_at IS NULL
              AND email IS NOT NULL AND email <> ''");
        foreach ($subStmt->fetchAll() as $s) {
            $email = trim((string) ($s['email'] ?? ''));
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result['failed']++;
                continue;
            }
            $emailKey = strtolower($email);
            if (isset($sentEmails[$emailKey])) {
                continue;
            }
            $unsub = buildSubscriberUnsubscribeHmacUrl((int) $s['id'], $email);
            if ($sendOne($email, $unsub, '')) {
                $result['subscribers_sent']++;
                $sentEmails[$emailKey] = true;
            } else {
                $result['failed']++;
            }
        }

        // Zaznamenaj beh (pri dry-run neukladáme, aby sa okno neposunulo).
        if (!$dryRun) {
            $logStmt = $pdo->prepare("INSERT INTO newsletter_digest_runs
                (window_start, window_end, articles_count, users_sent, subscribers_sent, failed)
                VALUES (:ws, :we, :ac, :us, :ss, :f)");
            $logStmt->execute([
                'ws' => $since,
                'we' => $until,
                'ac' => $count,
                'us' => $result['users_sent'],
                'ss' => $result['subscribers_sent'],
                'f'  => $result['failed'],
            ]);
        }

        return $result;
    }
}
