<?php

require_once __DIR__ . '/email_verification.php';

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

        return (int) $stmt->rowCount();
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

        return (int) $stmt->rowCount();
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

        return (int) $stmt->rowCount();
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

        return [
            'updated' => $updated,
            'inserted' => $inserted,
            'total' => $updated + $inserted,
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

        foreach ($ids as $queueIdRaw) {
            $queueId = (int) $queueIdRaw;
            if ($queueId <= 0) {
                $stats['skipped']++;
                continue;
            }

            $itemStmt = $pdo->prepare("SELECT
                    q.id,
                    q.article_id,
                    q.user_id,
                    q.email,
                    q.attempts,
                    a.title,
                    a.slug,
                    a.excerpt,
                    a.is_published,
                    u.username,
                    u.email AS user_email,
                    u.newsletter_consent,
                    u.is_active,
                    u.email_verified_at
                FROM article_newsletter_queue q
                LEFT JOIN articles a ON a.id = q.article_id
                LEFT JOIN users u ON u.id = q.user_id
                WHERE q.id = :id
                LIMIT 1");
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
                $cancelStmt = $pdo->prepare("UPDATE article_newsletter_queue
                    SET status = 'cancelled',
                        next_attempt_at = NOW(),
                        last_error = :reason
                    WHERE id = :id AND sent_at IS NULL");
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

                $failStmt = $pdo->prepare("UPDATE article_newsletter_queue
                    SET status = 'failed',
                        attempts = :attempts,
                        next_attempt_at = :next_attempt_at,
                        last_error = :last_error
                    WHERE id = :id AND sent_at IS NULL");
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
            $excerpt = trim((string) strip_tags((string) ($item['excerpt'] ?? '')));
            if ($excerpt !== '') {
                $excerpt = mb_substr($excerpt, 0, 320);
            }

            $displayName = trim((string) ($item['username'] ?? ''));
            if ($displayName === '') {
                $displayName = $recipientEmail;
            }

            $message = "Dobrý deň, " . $displayName . "\n\n"
                . "bol publikovaný nový článok na Nefro-projekt Slovensko:\n\n"
                . (string) $item['title'] . "\n"
                . $articleUrl . "\n\n";

            if ($excerpt !== '') {
                $message .= "Perex:\n" . $excerpt . "\n\n";
            }

            $message .= "Tento e-mail ste dostali, pretože máte povolené zasielanie noviniek.\n"
                . "Nastavenie môžete zmeniť vo svojom profile.\n\n"
                . "Nefro-projekt Slovensko";

            $cfg = getEmailEnvConfig();
            $sent = sendViaSmtp($recipientEmail, $subject, $message, $cfg);
            if (!$sent) {
                $fallbackFrom = $cfg['from_email'] !== ''
                    ? $cfg['from_email']
                    : ('no-reply@' . preg_replace('/:\\d+$/', '', (string) ($_SERVER['HTTP_HOST'] ?? 'nefro.polascin.net')));
                $headers = [
                    'MIME-Version: 1.0',
                    'Content-Type: text/plain; charset=UTF-8',
                    'From: ' . ($cfg['from_name'] ?: 'Nefro-projekt') . ' <' . $fallbackFrom . '>',
                ];
                $sent = @mail($recipientEmail, $subject, $message, implode("\r\n", $headers));
            }

            if ($sent) {
                $successStmt = $pdo->prepare("UPDATE article_newsletter_queue
                    SET status = 'sent',
                        attempts = attempts + 1,
                        sent_at = NOW(),
                        last_error = NULL
                    WHERE id = :id AND sent_at IS NULL");
                $successStmt->execute(['id' => $queueId]);
                $stats['sent']++;
            } else {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $nextAttemptAt = date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60));

                $failStmt = $pdo->prepare("UPDATE article_newsletter_queue
                    SET status = 'failed',
                        attempts = :attempts,
                        next_attempt_at = :next_attempt_at,
                        last_error = :last_error
                    WHERE id = :id AND sent_at IS NULL");
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
