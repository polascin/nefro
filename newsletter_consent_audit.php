<?php

declare(strict_types=1);

require_once __DIR__ . '/config_loader.php';

const NEWSLETTER_CONSENT_VERSION = '2026-10-12';
const NEWSLETTER_CONSENT_RETENTION_YEARS = 4;

function newsletterConsentText(): string
{
    return 'Súhlasím so zasielaním odborných článkov a noviniek z portálu e-mailom. Súhlas je dobrovoľný a môžem ho kedykoľvek odvolať odhlásením v každom e-maile alebo v profile.';
}

function newsletterConsentEmailDigest(string $email): string
{
    return hash_hmac('sha256', mb_strtolower(trim($email)), getAppDataProtectionKey());
}

function newsletterConsentAuditTableAvailable(PDO $pdo): bool
{
    static $available = null;
    if ($available !== null) {
        return $available;
    }

    try {
        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
            $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type = 'table' AND name = :name");
            $stmt->execute(['name' => 'newsletter_consent_audit']);
            $available = $stmt->fetchColumn() !== false;
        } else {
            $available = $pdo->query("SHOW TABLES LIKE 'newsletter_consent_audit'")->fetchColumn() !== false;
        }
    } catch (PDOException $e) {
        error_log('newsletter consent audit availability check failed: ' . $e->getMessage());
        $available = false;
    }

    return $available;
}

function recordNewsletterConsentEvent(
    PDO $pdo,
    string $subjectType,
    int $subjectId,
    string $email,
    string $event,
    string $source
): void {
    if (!in_array($subjectType, ['user', 'subscriber'], true)
        || !in_array($event, ['granted', 'withdrawn'], true)
    ) {
        throw new InvalidArgumentException('Neplatný typ udalosti newsletterového súhlasu.');
    }

    // Aplikačný kód možno bezpečne nasadiť pred samostatnou migráciou.
    // Chýbajúca tabuľka nesmie rozbiť registráciu; stav zostane v serverovom logu.
    if (!newsletterConsentAuditTableAvailable($pdo)) {
        error_log('newsletter consent audit skipped: table newsletter_consent_audit is missing');
        return;
    }

    $digest = newsletterConsentEmailDigest($email);
    if ($event === 'withdrawn') {
        $pdo->prepare(
            'UPDATE newsletter_consent_audit
             SET retain_until = DATE_ADD(NOW(), INTERVAL 4 YEAR)
             WHERE email_digest = :digest AND event = \'granted\' AND retain_until IS NULL'
        )->execute(['digest' => $digest]);
    }

    $stmt = $pdo->prepare(
        'INSERT INTO newsletter_consent_audit
         (subject_type, subject_id, email_digest, event, consent_version, consent_text, source, occurred_at, retain_until)
         VALUES (:subject_type, :subject_id, :digest, :event, :version, :text, :source, NOW(), '
         . ($event === 'withdrawn' ? 'DATE_ADD(NOW(), INTERVAL 4 YEAR)' : 'NULL') . ')'
    );
    $stmt->execute([
        'subject_type' => $subjectType,
        'subject_id' => $subjectId,
        'digest' => $digest,
        'event' => $event,
        'version' => NEWSLETTER_CONSENT_VERSION,
        'text' => newsletterConsentText(),
        'source' => mb_substr($source, 0, 80),
    ]);
}
