<?php

declare(strict_types=1);
/**
 * legal_notifications.php
 * Upozornenia na zmenu právnych dokumentov (Privacy / Cookie / Terms).
 *
 * Zdroj pravdy o verzii a popise zmien je legal_data.php: legalInfo()['version'],
 * ['effectiveDate'] a legalRecentUpdates(). Pri každej zmene verzie sa pošle
 * e-mail s popisom zmien VŠETKÝM registrovaným členom (bez ohľadu na
 * newsletter_consent — ide o transparenčnú povinnosť, GDPR čl. 13–14) a
 * anonymným odberateľom newslettera (verified, neodhlásení).
 *
 * Znovupoužíva infraštruktúru newslettera: process-lock (GET_LOCK), SMTP
 * odosielanie (sendViaSmtp + fallback @mail), e-mailový layout a odhlasovacie
 * odkazy. Spúšťa sa cez legal_notice_worker.php (CLI/cron), idempotentne podľa
 * tabuľky legal_notice_runs (UNIQUE legal_version).
 */

require_once __DIR__ . '/legal_data.php';
require_once __DIR__ . '/newsletter_notifications.php';

if (!function_exists('legalNoticeCurrentVersionInfo')) {
    /**
     * Aktuálna verzia právnych dokumentov + popis zmien zo zdroja pravdy.
     * @return array{version: string, effectiveDate: string, updates: array<int, string>}
     */
    function legalNoticeCurrentVersionInfo(): array
    {
        $info = legalInfo();
        $updates = array_values(array_filter(
            array_map(static fn ($u): string => trim((string) $u), legalRecentUpdates()),
            static fn (string $u): bool => $u !== ''
        ));

        return [
            'version'       => trim((string) ($info['version'] ?? '')),
            'effectiveDate' => trim((string) ($info['effectiveDate'] ?? '')),
            'updates'       => $updates,
        ];
    }
}

if (!function_exists('legalNoticeRunExists')) {
    function legalNoticeRunExists(PDO $pdo, string $version): bool
    {
        if ($version === '') {
            return false;
        }
        $stmt = $pdo->prepare('SELECT 1 FROM legal_notice_runs WHERE legal_version = :v LIMIT 1');
        $stmt->execute(['v' => $version]);
        return $stmt->fetchColumn() !== false;
    }
}

if (!function_exists('enqueueLegalChangeNotice')) {
    /**
     * Idempotentne zaradí upozornenie na danú verziu do fronty pre členov aj
     * odberateľov. Strážcom idempotencie je UNIQUE(legal_version) v
     * legal_notice_runs — opakované volanie pre tú istú verziu nič nepridá.
     *
     * @param array<int, string> $updates
     * @return array{already: bool, users: int, subscribers: int}
     */
    function enqueueLegalChangeNotice(PDO $pdo, string $version, string $effectiveDate, array $updates): array
    {
        if ($version === '') {
            return ['already' => false, 'users' => 0, 'subscribers' => 0];
        }

        $summary = json_encode(array_values($updates), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $effDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $effectiveDate) === 1 ? $effectiveDate : null;

        // Atomický strážca: prvý zápis verzie uspeje, ďalšie sa ignorujú.
        $runStmt = $pdo->prepare(
            'INSERT IGNORE INTO legal_notice_runs (legal_version, effective_date, change_summary, dispatched_at)
             VALUES (:v, :eff, :summary, NOW())'
        );
        $runStmt->execute(['v' => $version, 'eff' => $effDate, 'summary' => $summary]);
        if ((int) $runStmt->rowCount() === 0) {
            return ['already' => true, 'users' => 0, 'subscribers' => 0];
        }

        // Členovia: VŠETCI aktívni s overeným e-mailom (bez ohľadu na newsletter_consent).
        $userStmt = $pdo->prepare(
            "INSERT IGNORE INTO legal_notice_queue (legal_version, user_id, email, status, next_attempt_at)
             SELECT :v, u.id, u.email, 'pending', NOW()
             FROM users u
             WHERE u.is_active = 1
               AND u.email_verified_at IS NOT NULL
               AND u.email IS NOT NULL
               AND u.email <> ''"
        );
        $userStmt->execute(['v' => $version]);
        $usersQueued = (int) $userStmt->rowCount();

        // Anonymní odberatelia: overení a neodhlásení.
        $subStmt = $pdo->prepare(
            "INSERT IGNORE INTO legal_notice_sub_queue (legal_version, subscriber_id, email, status, next_attempt_at)
             SELECT :v, s.id, s.email, 'pending', NOW()
             FROM newsletter_subscribers s
             WHERE s.verified_at IS NOT NULL
               AND s.unsubscribed_at IS NULL
               AND s.email IS NOT NULL
               AND s.email <> ''"
        );
        $subStmt->execute(['v' => $version]);
        $subsQueued = (int) $subStmt->rowCount();

        $pdo->prepare(
            'UPDATE legal_notice_runs SET users_queued = :u, subscribers_queued = :s WHERE legal_version = :v'
        )->execute(['u' => $usersQueued, 's' => $subsQueued, 'v' => $version]);

        return ['already' => false, 'users' => $usersQueued, 'subscribers' => $subsQueued];
    }
}

if (!function_exists('buildLegalNoticeEmailHtml')) {
    /**
     * Telo e-mailu (inline štýly — e-mailové HTML, CSP sa neaplikuje).
     * @param array<int, string> $updates
     */
    function buildLegalNoticeEmailHtml(
        string $displayName,
        string $version,
        string $effectiveDate,
        array $updates,
        bool $isSubscriber,
        string $unsubscribeUrl = ''
    ): string {
        $base = getAppBaseUrl();
        $esc  = static fn (string $s): string => htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $effHtml = '';
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $effectiveDate) === 1) {
            $effHtml = ' s účinnosťou od <strong>' . $esc($effectiveDate) . '</strong>';
        }

        $items = '';
        foreach ($updates as $u) {
            $u = trim((string) $u);
            if ($u === '') {
                continue;
            }
            $items .= '<li style="margin:0 0 10px;line-height:22px;">' . $esc($u) . '</li>';
        }
        if ($items === '') {
            $items = '<li style="margin:0 0 10px;line-height:22px;">Vykonali sme aktualizáciu právnych dokumentov.</li>';
        }

        $docs = '<p style="margin:0 0 8px;">Úplné znenie nájdete tu:</p>'
            . '<ul style="margin:0 0 16px;padding-left:20px;">'
            . '<li style="margin:0 0 6px;"><a href="' . $esc($base . '/privacy.php') . '" style="color:#1d4ed8;text-decoration:underline;">Zásady ochrany osobných údajov</a></li>'
            . '<li style="margin:0 0 6px;"><a href="' . $esc($base . '/cookies.php') . '" style="color:#1d4ed8;text-decoration:underline;">Cookie Policy</a></li>'
            . '<li style="margin:0 0 6px;"><a href="' . $esc($base . '/terms.php') . '" style="color:#1d4ed8;text-decoration:underline;">Podmienky používania</a></li>'
            . '</ul>';

        if ($isSubscriber) {
            $closing = '<p style="margin:24px 0 16px;color:#475569;line-height:22px;">Toto je informačné oznámenie o zmene právnych podmienok. '
                . 'Ak už nechcete dostávať e-maily, môžete sa odhlásiť:<br>'
                . '<a href="' . $esc($unsubscribeUrl) . '" style="color:#1d4ed8;text-decoration:underline;">Odhlásiť sa</a></p>';
        } else {
            $closing = '<p style="margin:24px 0 16px;color:#475569;line-height:22px;">Toto oznámenie dostávajú všetci registrovaní členovia, '
                . 'pretože sa týka spracúvania vašich údajov a podmienok používania (transparenčná povinnosť podľa GDPR). '
                . 'Svoje údaje a nastavenia spravujete vo <a href="' . $esc($base . '/profile.php') . '" style="color:#1d4ed8;text-decoration:underline;">svojom profile</a>.</p>';
        }

        return '<p style="margin:0 0 16px;">Dobrý deň, ' . $esc($displayName) . ',</p>'
            . '<p style="margin:0 0 16px;">aktualizovali sme svoje právne dokumenty (Zásady ochrany osobných údajov, Cookie Policy a Podmienky používania)'
            . $effHtml . ' — verzia <strong>' . $esc($version) . '</strong>.</p>'
            . '<p style="margin:0 0 8px;font-weight:600;color:#0f172a;">Čo sa zmenilo:</p>'
            . '<ul style="margin:0 0 20px;padding-left:20px;">' . $items . '</ul>'
            . $docs
            . '<p style="margin:0 0 16px;">Ďalším používaním Služby beriete zmeny na vedomie. Ak so zmenami nesúhlasíte, '
            . 'kontaktujte nás alebo môžete svoj účet zrušiť.</p>'
            . $closing;
    }
}

if (!function_exists('legalNoticeDisplayName')) {
    /** Zostaví oslovenie z mena používateľa (fallback username / e-mail). */
    function legalNoticeDisplayName(array $item, string $fallbackEmail): string
    {
        $titleBefore = trim((string) ($item['title_before'] ?? ''));
        $firstName   = trim((string) ($item['first_name'] ?? ''));
        $middleName  = trim((string) ($item['middle_name'] ?? ''));
        $lastName    = trim((string) ($item['last_name'] ?? ''));
        $titleAfter  = trim((string) ($item['title_after'] ?? ''));

        if ($firstName !== '' && $lastName !== '') {
            $parts = array_filter([$titleBefore, $firstName, $middleName], static fn ($p): bool => $p !== '');
            $parts[] = $lastName;
            $name = trim(implode(' ', $parts));
            if ($titleAfter !== '') {
                $name .= ', ' . $titleAfter;
            }
            return $name;
        }

        $username = trim((string) ($item['username'] ?? ''));
        return $username !== '' ? $username : $fallbackEmail;
    }
}

if (!function_exists('legalNoticeSendOne')) {
    /** Odošle jeden e-mail (SMTP + fallback @mail). Vráti true pri úspechu. */
    function legalNoticeSendOne(string $email, string $subject, string $bodyHtml): bool
    {
        $message = renderEmailHtmlLayout($bodyHtml);
        $cfg = getEmailEnvConfig();
        $sent = sendViaSmtp($email, $subject, $message, $cfg, 'text/html; charset=UTF-8');
        if ($sent) {
            return true;
        }
        $fallbackFrom = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
        $fallbackFromName = mb_encode_mimeheader($cfg['from_name'] ?: 'Nefro-projekt', 'UTF-8', 'B', "\r\n ");
        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: quoted-printable',
            'From: ' . $fallbackFromName . ' <' . $fallbackFrom . '>',
        ];
        return @mail(
            $email,
            mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n "),
            quoted_printable_encode($message),
            implode("\r\n", $headers)
        );
    }
}

if (!function_exists('processLegalNoticeQueue')) {
    /**
     * Odošle frontu pre registrovaných členov.
     * @return array{selected:int,sent:int,failed:int,cancelled:int,skipped:int}
     */
    function processLegalNoticeQueue(PDO $pdo, int $limit = 50, int $maxAttempts = 5): array
    {
        $limit = max(1, min(500, $limit));
        $maxAttempts = max(1, min(20, $maxAttempts));
        $stats = ['selected' => 0, 'sent' => 0, 'failed' => 0, 'cancelled' => 0, 'skipped' => 0];

        $selectStmt = $pdo->prepare(
            "SELECT id FROM legal_notice_queue
             WHERE status IN ('pending','failed') AND attempts < :max_attempts
               AND next_attempt_at <= NOW() AND sent_at IS NULL
             ORDER BY next_attempt_at ASC, id ASC LIMIT :limit_rows"
        );
        $selectStmt->bindValue(':max_attempts', $maxAttempts, PDO::PARAM_INT);
        $selectStmt->bindValue(':limit_rows', $limit, PDO::PARAM_INT);
        $selectStmt->execute();
        $ids = $selectStmt->fetchAll(PDO::FETCH_COLUMN);
        $stats['selected'] = count($ids);

        $itemStmt = $pdo->prepare(
            "SELECT q.id, q.legal_version, q.user_id, q.email, q.attempts,
                    u.username, u.title_before, u.first_name, u.middle_name,
                    u.last_name, u.title_after, u.email AS user_email,
                    u.is_active, u.email_verified_at
             FROM legal_notice_queue q
             LEFT JOIN users u ON u.id = q.user_id
             WHERE q.id = :id LIMIT 1"
        );
        $cancelStmt = $pdo->prepare(
            "UPDATE legal_notice_queue SET status='cancelled', next_attempt_at=NOW(), last_error=:reason
             WHERE id=:id AND sent_at IS NULL"
        );
        $failStmt = $pdo->prepare(
            "UPDATE legal_notice_queue SET status='failed', attempts=:attempts,
                    next_attempt_at=:next_attempt_at, last_error=:last_error
             WHERE id=:id AND sent_at IS NULL"
        );
        $successStmt = $pdo->prepare(
            "UPDATE legal_notice_queue SET status='sent', attempts=attempts+1, sent_at=NOW(), last_error=NULL
             WHERE id=:id AND sent_at IS NULL"
        );

        $info = legalNoticeCurrentVersionInfo();

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
            if ((int) ($item['is_active'] ?? 0) !== 1) {
                $cancelReason = 'Používateľský účet je neaktívny.';
            } elseif (empty($item['email_verified_at'])) {
                $cancelReason = 'E-mail používateľa nie je overený.';
            }
            if ($cancelReason !== null) {
                $cancelStmt->execute(['id' => $queueId, 'reason' => $cancelReason]);
                $stats['cancelled']++;
                continue;
            }

            $recipientEmail = trim((string) ($item['user_email'] ?? $item['email'] ?? ''));
            if ($recipientEmail === '' || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $failStmt->execute([
                    'id' => $queueId,
                    'attempts' => $failAttempt,
                    'next_attempt_at' => date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60)),
                    'last_error' => 'Neplatný alebo chýbajúci e-mail príjemcu.',
                ]);
                $stats['failed']++;
                continue;
            }

            $version = (string) ($item['legal_version'] ?? $info['version']);
            $subject = 'Aktualizácia právnych podmienok (verzia ' . $version . ') - Nefro-projekt Slovensko';
            $displayName = legalNoticeDisplayName($item, $recipientEmail);
            $body = buildLegalNoticeEmailHtml($displayName, $version, $info['effectiveDate'], $info['updates'], false);

            if (legalNoticeSendOne($recipientEmail, $subject, $body)) {
                $successStmt->execute(['id' => $queueId]);
                $stats['sent']++;
            } else {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $failStmt->execute([
                    'id' => $queueId,
                    'attempts' => $failAttempt,
                    'next_attempt_at' => date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60)),
                    'last_error' => 'SMTP odoslanie zlyhalo.',
                ]);
                $stats['failed']++;
            }
        }

        return $stats;
    }
}

if (!function_exists('processLegalNoticeSubQueue')) {
    /**
     * Odošle frontu pre anonymných odberateľov newslettera.
     * @return array{selected:int,sent:int,failed:int,cancelled:int,skipped:int}
     */
    function processLegalNoticeSubQueue(PDO $pdo, int $limit = 50, int $maxAttempts = 5): array
    {
        $limit = max(1, min(500, $limit));
        $maxAttempts = max(1, min(20, $maxAttempts));
        $stats = ['selected' => 0, 'sent' => 0, 'failed' => 0, 'cancelled' => 0, 'skipped' => 0];

        $selectStmt = $pdo->prepare(
            "SELECT id FROM legal_notice_sub_queue
             WHERE status IN ('pending','failed') AND attempts < :max_attempts
               AND next_attempt_at <= NOW() AND sent_at IS NULL
             ORDER BY next_attempt_at ASC, id ASC LIMIT :limit_rows"
        );
        $selectStmt->bindValue(':max_attempts', $maxAttempts, PDO::PARAM_INT);
        $selectStmt->bindValue(':limit_rows', $limit, PDO::PARAM_INT);
        $selectStmt->execute();
        $ids = $selectStmt->fetchAll(PDO::FETCH_COLUMN);
        $stats['selected'] = count($ids);

        $itemStmt = $pdo->prepare(
            "SELECT q.id, q.legal_version, q.subscriber_id, q.email, q.attempts,
                    s.email AS sub_email, s.verified_at, s.unsubscribed_at
             FROM legal_notice_sub_queue q
             LEFT JOIN newsletter_subscribers s ON s.id = q.subscriber_id
             WHERE q.id = :id LIMIT 1"
        );
        $cancelStmt = $pdo->prepare(
            "UPDATE legal_notice_sub_queue SET status='cancelled', next_attempt_at=NOW(), last_error=:reason
             WHERE id=:id AND sent_at IS NULL"
        );
        $failStmt = $pdo->prepare(
            "UPDATE legal_notice_sub_queue SET status='failed', attempts=:attempts,
                    next_attempt_at=:next_attempt_at, last_error=:last_error
             WHERE id=:id AND sent_at IS NULL"
        );
        $successStmt = $pdo->prepare(
            "UPDATE legal_notice_sub_queue SET status='sent', attempts=attempts+1, sent_at=NOW(), last_error=NULL
             WHERE id=:id AND sent_at IS NULL"
        );

        $info = legalNoticeCurrentVersionInfo();

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
            if (empty($item['verified_at'])) {
                $cancelReason = 'Odberateľ nie je overený.';
            } elseif (!empty($item['unsubscribed_at'])) {
                $cancelReason = 'Odberateľ sa odhlásil.';
            }
            if ($cancelReason !== null) {
                $cancelStmt->execute(['id' => $queueId, 'reason' => $cancelReason]);
                $stats['cancelled']++;
                continue;
            }

            $recipientEmail = trim((string) ($item['sub_email'] ?? $item['email'] ?? ''));
            if ($recipientEmail === '' || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $failStmt->execute([
                    'id' => $queueId,
                    'attempts' => $failAttempt,
                    'next_attempt_at' => date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60)),
                    'last_error' => 'Neplatný alebo chýbajúci e-mail príjemcu.',
                ]);
                $stats['failed']++;
                continue;
            }

            $version = (string) ($item['legal_version'] ?? $info['version']);
            $subject = 'Aktualizácia právnych podmienok (verzia ' . $version . ') - Nefro-projekt Slovensko';
            $unsubscribeUrl = buildSubscriberUnsubscribeHmacUrl((int) ($item['subscriber_id'] ?? 0), $recipientEmail);
            $body = buildLegalNoticeEmailHtml($recipientEmail, $version, $info['effectiveDate'], $info['updates'], true, $unsubscribeUrl);

            if (legalNoticeSendOne($recipientEmail, $subject, $body)) {
                $successStmt->execute(['id' => $queueId]);
                $stats['sent']++;
            } else {
                $failAttempt = (int) ($item['attempts'] ?? 0) + 1;
                $failStmt->execute([
                    'id' => $queueId,
                    'attempts' => $failAttempt,
                    'next_attempt_at' => date('Y-m-d H:i:s', time() + min(3600, (int) pow(2, min($failAttempt, 10)) * 60)),
                    'last_error' => 'SMTP odoslanie zlyhalo.',
                ]);
                $stats['failed']++;
            }
        }

        return $stats;
    }
}

if (!function_exists('getLegalNoticeOverview')) {
    /**
     * Prehľad pre admin: zoznam behov + agregované stavy fronty na verziu.
     * @return array<int, array<string, mixed>>
     */
    function getLegalNoticeOverview(PDO $pdo): array
    {
        $runs = $pdo->query(
            'SELECT legal_version, effective_date, change_summary, users_queued, subscribers_queued, dispatched_at
             FROM legal_notice_runs ORDER BY dispatched_at DESC, id DESC LIMIT 50'
        )->fetchAll(PDO::FETCH_ASSOC);

        $aggSql =
            "SELECT legal_version,
                    SUM(status='sent') AS sent,
                    SUM(status='pending') AS pending,
                    SUM(status='failed') AS failed,
                    SUM(status='cancelled') AS cancelled,
                    COUNT(*) AS total
             FROM %s GROUP BY legal_version";
        $userAgg = [];
        foreach ($pdo->query(sprintf($aggSql, 'legal_notice_queue'))->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $userAgg[(string) $r['legal_version']] = $r;
        }
        $subAgg = [];
        foreach ($pdo->query(sprintf($aggSql, 'legal_notice_sub_queue'))->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $subAgg[(string) $r['legal_version']] = $r;
        }

        foreach ($runs as &$run) {
            $v = (string) $run['legal_version'];
            $run['user_stats'] = $userAgg[$v] ?? ['sent' => 0, 'pending' => 0, 'failed' => 0, 'cancelled' => 0, 'total' => 0];
            $run['sub_stats']  = $subAgg[$v] ?? ['sent' => 0, 'pending' => 0, 'failed' => 0, 'cancelled' => 0, 'total' => 0];
        }
        unset($run);

        return $runs;
    }
}
