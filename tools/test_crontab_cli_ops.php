<?php

declare(strict_types=1);

/**
 * Ops v kóde (Beh 43 / 108 / 145): tools/crontab.example je zdroj pravdy
 * plánovaných úloh a CLI ops skripty musia mať .htaccess deny.
 *
 * Tento test NEMENÍ produkčný crontab — len bráni driftu v repozitári.
 */

$checks = 0;

function crontabOpsTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);
$crontabPath = $root . '/tools/crontab.example';
$htaccessPath = $root . '/.htaccess';

crontabOpsTest(is_file($crontabPath), 'tools/crontab.example musí existovať.');
crontabOpsTest(is_file($htaccessPath), '.htaccess musí existovať.');

$crontab = (string) file_get_contents($crontabPath);
$htaccess = (string) file_get_contents($htaccessPath);

$mustSchedule = [
    'newsletter_worker.php',
    'newsletter_weekly_digest.php',
    'legal_notice_worker.php',
    'provider_notice_worker.php',
    'archive_cleanup.php',
    'backup_snapshot.php',
    'ops_health.php',
    'sync_drugs.php',
    'sync_clinical_trials.php',
];

$intentionalOmit = [
    'update_sitemap.php',
    'newsletter_apology_broken_links.php',
];

$cronLines = preg_split('/\R/', $crontab) ?: [];
$activeJobText = '';
foreach ($cronLines as $line) {
    $trim = ltrim($line);
    if ($trim === '' || str_starts_with($trim, '#')) {
        continue;
    }
    $activeJobText .= $line . "\n";
}

$omitSection = '';
if (preg_match('/# ── Zámerné OMITNUTÉ ─+.*$/s', $crontab, $m) === 1) {
    $omitSection = $m[0];
}
crontabOpsTest($omitSection !== '', 'crontab.example musí mať sekciu „Zámerné OMITNUTÉ“.');

foreach ($mustSchedule as $script) {
    crontabOpsTest(
        is_file($root . '/' . $script),
        "Ops skript {$script} musí existovať v koreni.",
    );
    crontabOpsTest(
        str_contains($activeJobText, $script),
        "crontab.example musí mať aktívny cron riadok pre {$script}.",
    );
    crontabOpsTest(
        str_contains($htaccess, '<Files "' . $script . '">'),
        ".htaccess musí deny-ovať {$script} cez <Files>.",
    );
    $source = (string) file_get_contents($root . '/' . $script);
    crontabOpsTest(
        str_contains($source, "php_sapi_name() !== 'cli'")
            || str_contains($source, "PHP_SAPI !== 'cli'"),
        "{$script} musí mať in-code CLI guard.",
    );
}

foreach ($intentionalOmit as $script) {
    crontabOpsTest(
        is_file($root . '/' . $script),
        "Zámerný omit skript {$script} musí existovať (alebo odstráň z testu).",
    );
    crontabOpsTest(
        str_contains($omitSection, $script),
        "crontab.example OMITNUTÉ musí spomínať {$script}.",
    );
    crontabOpsTest(
        !str_contains($activeJobText, $script),
        "{$script} nesmie byť v aktívnych cron riadkoch (je zámerný omit).",
    );
    crontabOpsTest(
        str_contains($htaccess, '<Files "' . $script . '">'),
        ".htaccess musí deny-ovať omit skript {$script}.",
    );
}

// Nový *_worker.php v koreni nesmie uniknúť mimo zoznamov.
foreach (glob($root . '/*_worker.php') ?: [] as $path) {
    $base = basename($path);
    crontabOpsTest(
        in_array($base, $mustSchedule, true) || in_array($base, $intentionalOmit, true),
        "Nový worker {$base} musí byť v mustSchedule alebo intentionalOmit tohto testu.",
    );
}

echo "Crontab + CLI ops deny: $checks PASS\n";
