<?php

declare(strict_types=1);

putenv('DATA_PROTECTION_KEY=fictional-compliance-test-key-with-32-bytes');
require_once __DIR__ . '/../newsletter_consent_audit.php';
require_once __DIR__ . '/../publications_common.php';

$checks = 0;
function complianceTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

class ComplianceTestPdo extends PDO
{
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        $query = str_replace('DATE_ADD(NOW(), INTERVAL 4 YEAR)', "datetime('now', '+4 years')", $query);
        $query = str_replace('NOW()', "datetime('now')", $query);
        return parent::prepare($query, $options);
    }
}

$pdo = new ComplianceTestPdo('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->exec('CREATE TABLE newsletter_consent_audit (
    id INTEGER PRIMARY KEY AUTOINCREMENT, subject_type TEXT, subject_id INTEGER,
    email_digest TEXT, event TEXT, consent_version TEXT, consent_text TEXT,
    source TEXT, occurred_at TEXT, retain_until TEXT)');

recordNewsletterConsentEvent($pdo, 'user', 7, 'Person@Example.invalid', 'granted', 'registration');
recordNewsletterConsentEvent($pdo, 'user', 7, 'person@example.invalid', 'withdrawn', 'profile');
$events = $pdo->query('SELECT * FROM newsletter_consent_audit ORDER BY id')->fetchAll();

complianceTest(count($events) === 2, 'Nezaznamenali sa obe udalosti súhlasu.');
complianceTest($events[0]['event'] === 'granted' && $events[1]['event'] === 'withdrawn', 'Poradie udalostí nesúhlasí.');
complianceTest($events[0]['email_digest'] === $events[1]['email_digest'], 'Normalizovaný odtlačok e-mailu nie je stabilný.');
complianceTest($events[0]['consent_version'] === NEWSLETTER_CONSENT_VERSION, 'Chýba verzia súhlasu.');
complianceTest($events[0]['consent_text'] === newsletterConsentText(), 'Chýba presné znenie súhlasu.');
complianceTest($events[0]['retain_until'] !== null && $events[1]['retain_until'] !== null, 'Po odvolaní sa nenastavila retenčná lehota.');
complianceTest(strtotime($events[1]['retain_until']) >= strtotime('+3 years 11 months'), 'Retenčná lehota je kratšia ako štyri roky.');
complianceTest(str_contains(publicationDeliveryConsentText(), 'Výslovne súhlasím'), 'Vyhlásenie neobsahuje výslovný súhlas.');
complianceTest(str_contains(publicationDeliveryConsentText(), 'strácam'), 'Vyhlásenie neobsahuje vedomie straty práva.');

$reportCode = file_get_contents(__DIR__ . '/../content_report.php');
$adminCode = file_get_contents(__DIR__ . '/../admin_content_notices.php');
$migrationCode = file_get_contents(__DIR__ . '/../add_compliance_controls_migration.php');
complianceTest($reportCode !== false && str_contains($reportCode, 'validateCsrfToken'), 'DSA formulár nemá CSRF kontrolu.');
complianceTest($reportCode !== false && str_contains($reportCode, 'checkFormRateLimit'), 'DSA formulár nemá rate limit.');
complianceTest($adminCode !== false && str_contains($adminCode, 'decision_reason'), 'DSA proces neeviduje odôvodnenie.');
complianceTest($adminCode !== false && str_contains($adminCode, 'logAdminAction'), 'DSA rozhodnutie nemá auditnú stopu.');
complianceTest($adminCode !== false && str_contains($adminCode, 'affected_email'), 'DSA proces nevie oznámiť dôvody dotknutému používateľovi.');
complianceTest($reportCode !== false && str_contains($reportCode, 'contact_exemption'), 'DSA formulár nepokrýva výnimku z kontaktných údajov.');
complianceTest($migrationCode !== false && str_contains($migrationCode, "PHP_SAPI !== 'cli'"), 'Migrácia nie je obmedzená na CLI.');
complianceTest($migrationCode !== false && str_contains($migrationCode, 'array_diff($required, $columns)'), 'Migrácia po vytvorení neoveruje úplnosť schémy.');

echo "Compliance controls: {$checks} PASS\n";
