<?php

declare(strict_types=1);

/**
 * Spoločná knižnica pre tools/crontab.example: povinné úlohy, omit,
 * vykreslenie inštalovateľného crontabu a kontrola parity voči dumpom.
 */

/**
 * @return list<string>
 */
function nefroCrontabMustSchedule(): array
{
    return [
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
}

/**
 * @return list<string>
 */
function nefroCrontabIntentionalOmit(): array
{
    return [
        'update_sitemap.php',
        'newsletter_apology_broken_links.php',
    ];
}

/**
 * Očakávané cron schedule tokeny (prvých 5 polí) pre kľúčové úlohy.
 * Porovnanie je proti normalizovanému textu aktívnych riadkov.
 *
 * @return array<string, string>
 */
function nefroCrontabExpectedSchedules(): array
{
    return [
        'newsletter_worker.php' => '* * * * *',
        'newsletter_weekly_digest.php' => '0 8 * * 1',
        'legal_notice_worker.php' => '17 * * * *',
        'provider_notice_worker.php' => '43 2 * * *',
        'archive_cleanup.php' => '0 2 * * 0',
        'backup_snapshot.php' => '40 3 * * *',
        'ops_health.php' => '10 6 * * *',
        'sync_drugs.php' => '15 4 * * 1',
        'sync_clinical_trials.php' => '30 3 * * 1',
    ];
}

function nefroCrontabDefaultRoot(): string
{
    return '/data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro';
}

function nefroCrontabDefaultPhp(): string
{
    return '/usr/bin/php';
}

/**
 * Aktívne (neodkomentované) riadky crontabu spojené do jedného textu.
 */
function nefroCrontabActiveJobText(string $crontab): string
{
    $out = '';
    foreach (preg_split('/\R/', $crontab) ?: [] as $line) {
        $trim = ltrim($line);
        if ($trim === '' || str_starts_with($trim, '#')) {
            continue;
        }
        $out .= $line . "\n";
    }

    return $out;
}

/**
 * Vykreslí inštalovateľný crontab z tools/crontab.example.
 * Zachová env premenné; nastaví NEFRO_PHP / NEFRO_ROOT.
 * Voliteľný $extraPreserve sa pripojí na koniec (napr. cudzie úlohy hostingu).
 */
function nefroCrontabRender(
    string $examplePath,
    string $phpBin = '',
    string $root = '',
    string $extraPreserve = ''
): string {
    $phpBin = $phpBin !== '' ? $phpBin : nefroCrontabDefaultPhp();
    $root = $root !== '' ? $root : nefroCrontabDefaultRoot();
    $src = (string) file_get_contents($examplePath);
    if ($src === '') {
        throw new RuntimeException('Prázdny alebo nečitateľný crontab.example: ' . $examplePath);
    }

    $src = preg_replace(
        '/^NEFRO_PHP=.*$/m',
        'NEFRO_PHP=' . $phpBin,
        $src,
        1
    ) ?? $src;
    $src = preg_replace(
        '/^NEFRO_ROOT=.*$/m',
        'NEFRO_ROOT=' . $root,
        $src,
        1
    ) ?? $src;

    $src = rtrim($src) . "\n";
    $extra = trim($extraPreserve);
    if ($extra !== '') {
        $src .= "\n# ── Zachované cudzie úlohy (nie nefro SoT) ───────────────────────────────\n";
        $src .= $extra . "\n";
    }

    return $src;
}

/**
 * Overí, že dump crontabu obsahuje povinné nefro úlohy so správnym schedule
 * a že provider_notice beží bez --send.
 *
 * @return list<string> zoznam chýb (prázdny = OK)
 */
function nefroCrontabParityErrors(string $crontabText): array
{
    $errors = [];
    $active = nefroCrontabActiveJobText($crontabText);

    foreach (nefroCrontabMustSchedule() as $script) {
        if (!str_contains($active, $script)) {
            $errors[] = "Chýba aktívny cron riadok pre {$script}.";
        }
    }

    foreach (nefroCrontabIntentionalOmit() as $script) {
        if (str_contains($active, $script)) {
            $errors[] = "{$script} nesmie byť v aktívnych riadkoch (zámerný omit).";
        }
    }

    foreach (nefroCrontabExpectedSchedules() as $script => $schedule) {
        $found = false;
        foreach (preg_split('/\R/', $active) ?: [] as $line) {
            if (!str_contains($line, $script)) {
                continue;
            }
            if (preg_match('/^' . preg_quote($schedule, '/') . '\s+/', ltrim($line)) === 1) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $errors[] = "{$script} musí mať schedule „{$schedule}“ (podľa tools/crontab.example).";
        }
    }

    foreach (preg_split('/\R/', $active) ?: [] as $line) {
        if (str_contains($line, 'provider_notice_worker.php') && str_contains($line, '--send')) {
            $errors[] = 'provider_notice_worker.php nesmie bežať s --send v crontabe.';
        }
    }

    return $errors;
}
