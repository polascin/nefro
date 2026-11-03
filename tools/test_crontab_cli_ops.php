<?php

declare(strict_types=1);

/**
 * Ops v kóde (Beh 43 / 108 / 145 / 148): tools/crontab.example je zdroj pravdy
 * plánovaných úloh a CLI ops skripty musia mať .htaccess deny.
 *
 * Od Behu 148 navyše pinuje schedule parity cez tools/crontab_lib.php a
 * existenciu render/verify nástrojov (RSI — drift sa dá overiť aj voči
 * produkčnému `crontab -l` dumpom).
 */

require __DIR__ . '/crontab_lib.php';

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
crontabOpsTest(is_file($root . '/tools/crontab_lib.php'), 'tools/crontab_lib.php musí existovať.');
crontabOpsTest(is_file($root . '/tools/render_crontab.php'), 'tools/render_crontab.php musí existovať.');
crontabOpsTest(is_file($root . '/tools/verify_crontab_parity.php'), 'tools/verify_crontab_parity.php musí existovať.');

$crontab = (string) file_get_contents($crontabPath);
$htaccess = (string) file_get_contents($htaccessPath);

$mustSchedule = nefroCrontabMustSchedule();
$intentionalOmit = nefroCrontabIntentionalOmit();

$activeJobText = nefroCrontabActiveJobText($crontab);

$omitSection = '';
if (preg_match('/# ── Zámerné OMITNUTÉ ─+.*$/s', $crontab) === 1) {
    preg_match('/# ── Zámerné OMITNUTÉ ─+.*$/s', $crontab, $m);
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

foreach (nefroCrontabParityErrors($crontab) as $err) {
    crontabOpsTest(false, 'Parity example: ' . $err);
}

$rendered = nefroCrontabRender($crontabPath, '', '', "line\r\nwith\rCRLF\n");
foreach (nefroCrontabParityErrors($rendered) as $err) {
    crontabOpsTest(false, 'Parity rendered: ' . $err);
}
crontabOpsTest(
    str_contains($rendered, 'NEFRO_ROOT=' . nefroCrontabDefaultRoot()),
    'render musí nastaviť produkčný NEFRO_ROOT.',
);
crontabOpsTest(
    !str_contains($rendered, "\r"),
    'render musí emitovať iba LF (CRLF rozbije crontab bad minute).',
);

// Nový *_worker.php v koreni nesmie uniknúť mimo zoznamov.
foreach (glob($root . '/*_worker.php') ?: [] as $path) {
    $base = basename($path);
    crontabOpsTest(
        in_array($base, $mustSchedule, true) || in_array($base, $intentionalOmit, true),
        "Nový worker {$base} musí byť v mustSchedule alebo intentionalOmit tohto testu.",
    );
}

echo "Crontab + CLI ops deny: $checks PASS\n";
