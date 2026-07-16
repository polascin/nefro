<?php

declare(strict_types=1);

/**
 * newsletter_apology_broken_links.php
 * ════════════════════════════════════════════════════════════════════════════
 * Jednorazový ospravedlňujúci e-mail za prvý týždenný prehľad (digest), v ktorom
 * odkazy na články smerovali nesprávne (http://localhost/...). Chyba je opravená.
 *
 * Posiela rovnakému okruhu príjemcov ako týždenný digest:
 *   – registrovaní používatelia so súhlasom s novinkami
 *   – overení anonymní odberatelia
 * s deduplikáciou podľa e-mailu a platným odhlasovacím odkazom.
 *
 * Spustenie (na serveri cez SSH):
 *   php newsletter_apology_broken_links.php            # ostré odoslanie
 *   php newsletter_apology_broken_links.php --dry-run  # nič neodošle, len vypíše
 * ════════════════════════════════════════════════════════════════════════════
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý.");
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/newsletter_notifications.php';

$dryRun = in_array('--dry-run', $argv, true);

$subject = 'Ospravedlnenie za nefunkčné odkazy v prvom týždennom prehľade – Nefro-projekt Slovensko';
$cfg     = getEmailEnvConfig();

$buildBody = static function (string $greetingName): string {
    $greeting = $greetingName !== ''
        ? 'Dobrý deň, ' . htmlspecialchars($greetingName, ENT_QUOTES | ENT_HTML5, 'UTF-8') . ','
        : 'Dobrý deň,';

    return '<p style="margin:0 0 16px;">' . $greeting . '</p>'
        . '<p style="margin:0 0 16px;line-height:22px;">ospravedlňujeme sa za prvý týždenný prehľad (digest), '
        . 'v ktorom odkazy na články nefungovali správne. Chybu sme už odstránili a všetky odkazy '
        . 'teraz smerujú na náš web.</p>'
        . '<p style="margin:0 0 16px;line-height:22px;">Projekt je ešte stále vo vývoji, preto sa občas '
        . 'môže vyskytnúť drobná chyba. Veľmi si vážime vašu trpezlivosť a spätnú väzbu.</p>'
        . '<p style="margin:0 0 16px;line-height:22px;">Ďakujeme za pochopenie.</p>'
        . '<p style="margin:0;line-height:22px;">S pozdravom,<br>Nefro-projekt Slovensko</p>';
};

$sendOne = static function (string $email, string $unsubscribeUrl, string $greetingName) use ($buildBody, $subject, $cfg, $dryRun): bool {
    if ($dryRun) {
        return true;
    }
    $unsubEsc = htmlspecialchars($unsubscribeUrl, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $body = $buildBody($greetingName)
        . '<p style="margin:24px 0 0;color:#475569;line-height:22px;font-size:14px;">Tento e-mail ste dostali, '
        . 'pretože odoberáte novinky z webu Nefro-projekt Slovensko.<br>'
        . 'Ak už nechcete dostávať novinky, otvorte odkaz a potvrďte odhlásenie:<br>'
        . '<a href="' . $unsubEsc . '" style="color:#1d4ed8;text-decoration:underline;">Odhlásiť sa</a></p>';
    $message = renderEmailHtmlLayout($body, 'Zobraziť všetky články', getAppBaseUrl());

    $sent = sendViaSmtp($email, $subject, $message, $cfg, 'text/html; charset=UTF-8');
    if (!$sent) {
        $fallbackFrom     = $cfg['from_email'] !== '' ? $cfg['from_email'] : 'no-reply@nefro.polascin.net';
        $fallbackFromName = mb_encode_mimeheader($cfg['from_name'] ?: 'Nefro-projekt', 'UTF-8', 'B', "\r\n ");
        $headers = ['MIME-Version: 1.0', 'Content-Type: text/html; charset=UTF-8', 'Content-Transfer-Encoding: quoted-printable', 'From: ' . $fallbackFromName . ' <' . $fallbackFrom . '>'];
        $sent = @mail($email, mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n "), quoted_printable_encode($message), implode("\r\n", $headers));
    }
    return $sent;
};

$usersSent = 0;
$subsSent  = 0;
$failed    = 0;
$sentEmails = [];

// 1) Registrovaní používatelia so súhlasom
$userStmt = $pdo->query("SELECT id, email, title_before, first_name, middle_name, last_name, title_after, username
    FROM users
    WHERE newsletter_consent = 1 AND is_active = 1 AND email_verified_at IS NOT NULL
      AND email IS NOT NULL AND email <> ''");
foreach ($userStmt->fetchAll() as $u) {
    $email = trim((string) ($u['email'] ?? ''));
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $failed++;
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
        $usersSent++;
        $sentEmails[$emailKey] = true;
    } else {
        $failed++;
    }
}

// 2) Anonymní odberatelia
$subStmt = $pdo->query("SELECT id, email FROM newsletter_subscribers
    WHERE verified_at IS NOT NULL AND unsubscribed_at IS NULL
      AND email IS NOT NULL AND email <> ''");
foreach ($subStmt->fetchAll() as $s) {
    $email = trim((string) ($s['email'] ?? ''));
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $failed++;
        continue;
    }
    $emailKey = strtolower($email);
    if (isset($sentEmails[$emailKey])) {
        continue;
    }
    $unsub = buildSubscriberUnsubscribeHmacUrl((int) $s['id'], $email);
    if ($sendOne($email, $unsub, '')) {
        $subsSent++;
        $sentEmails[$emailKey] = true;
    } else {
        $failed++;
    }
}

echo "Ospravedlňujúci e-mail – " . ($dryRun ? "SKÚŠOBNÝ BEH (nič sa neodoslalo)" : "dokončené") . ".\n";
echo "Odoslané registrovaným: " . $usersSent . "\n";
echo "Odoslané odberateľom:   " . $subsSent . "\n";
echo "Zlyhané odoslania:      " . $failed . "\n";
