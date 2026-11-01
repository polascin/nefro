<?php

declare(strict_types=1);

/**
 * Defense-in-depth: migrácie/seedy partner_providers a worker oznámení
 * nesmú chýbať v .htaccess deny ani v robots.txt Disallow.
 */

$checks = 0;
function providerDenyTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

$root = dirname(__DIR__);
$htaccess = (string) file_get_contents($root . '/.htaccess');
$robots = (string) file_get_contents($root . '/robots.txt');

providerDenyTest(
    str_contains($htaccess, '<FilesMatch "^add_provider.*\\.php$">'),
    '.htaccess musí blokovať všetky add_provider*.php jedným FilesMatch.',
);
providerDenyTest(
    str_contains($htaccess, '<Files "provider_notice_worker.php">'),
    '.htaccess musí blokovať provider_notice_worker.php.',
);

$scripts = [
    'add_providers_migration.php',
    'add_providers_fields_migration.php',
    'add_providers_priority_migration.php',
    'add_provider_contacts_migration.php',
    'add_provider_notice_migration.php',
    'add_providers_seed.php',
    'add_providers_seed_referral.php',
    'add_providers_rovinka.php',
    'add_providers_evuc_bratislava.php',
    'add_providers_priorities_seed.php',
    'provider_notice_worker.php',
    'legal_notice_worker.php',
];

foreach ($scripts as $script) {
    providerDenyTest(
        str_contains($robots, 'Disallow: /' . $script),
        "robots.txt musí Disallow /{$script}.",
    );
    providerDenyTest(is_file($root . '/' . $script), "Súbor {$script} musí existovať v koreni.");
}

echo "Provider script deny: $checks PASS\n";
