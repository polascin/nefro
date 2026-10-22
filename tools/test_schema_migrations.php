<?php

declare(strict_types=1);

/**
 * Schéma databázy musí mať jeden vstupný bod a viditeľnú evidenciu migrácií.
 *
 * `setup_db.php` vytváral 30 tabuliek, ale šesť ďalších (drugs, clinical_trials,
 * partner_providers, provider_contacts, provider_notice_queue,
 * provider_suppressions) existovalo výlučne v samostatných migračných
 * skriptoch. Čistá inštalácia podľa AGENTS.md teda bola neúplná.
 *
 * Navyše neexistovala tabuľka evidujúca, ktoré migrácie už prebehli — nedalo
 * sa zistiť, či je databáza na aktuálnej verzii.
 */

$checks = 0;

function schemaMigrationTest(bool $condition, string $label): void
{
    global $checks;
    ++$checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
}

$root = dirname(__DIR__);
$setup = (string) file_get_contents($root . '/setup_db.php');

// ── Evidencia migrácií ───────────────────────────────────────────────────────
schemaMigrationTest(
    str_contains($setup, 'CREATE TABLE IF NOT EXISTS schema_migrations'),
    'setup_db.php musí vytvoriť tabuľku schema_migrations.',
);
schemaMigrationTest(
    str_contains($setup, 'runPendingSchemaMigrations('),
    'setup_db.php musí spúšťať migračné skripty.',
);
schemaMigrationTest(
    str_contains($setup, "glob(\$root . '/add_*_migration.php')"),
    'setup_db.php musí hľadať migračné skripty podľa vzoru add_*_migration.php.',
);
schemaMigrationTest(
    str_contains($setup, 'schemaMigrationRecord('),
    'setup_db.php musí evidovať spustené migrácie.',
);

// ── Každá tabuľka, ktorú vytvára len migračný skript, musí byť dosiahnuteľná ──
$migrations = glob($root . '/add_*_migration.php') ?: [];
sort($migrations);

schemaMigrationTest(
    count($migrations) >= 10,
    'Očakáva sa dostatok migračných skriptov (nájdené: ' . count($migrations) . ').',
);

$tablesCreated = [];
foreach ($migrations as $migration) {
    $source = (string) file_get_contents($migration);

    // Každý migračný skript musí byť spustiteľný len cez CLI.
    schemaMigrationTest(
        str_contains($source, "php_sapi_name() !== 'cli'") || str_contains($source, "PHP_SAPI !== 'cli'"),
        'Migračný skript ' . basename($migration) . ' musí mať CLI guard.',
    );

    if (preg_match_all('/CREATE TABLE IF NOT EXISTS\s+`?(\w+)`?/i', $source, $matches) > 0) {
        foreach ($matches[1] as $table) {
            $tablesCreated[strtolower($table)] = true;
        }
    }
}

// ── Vzor, podľa ktorého bežník hľadá migrácie, musí zachytiť všetky ────────
// Ak by sa niektorý migračný skript nezhodoval so vzorom, ostal by v repozitári
// a setup_db.php by ho nikdy nespustil — rovnako ako v prípade chýbajúceho
// záznamu v crontabe.
schemaMigrationTest(
    preg_match("/glob\(\\\$root \. '([^']+)'\)/", $setup, $patternMatch) === 1,
    'setup_db.php musí hľadať migračné skripty cez glob() so vzorom.',
);

$pattern = $patternMatch[1] ?? '';
// Vzor sa v kóde skladá s $root . '…', preto ho takto aj použijeme.
$matched = glob($root . $pattern) ?: [];
sort($matched);

schemaMigrationTest(
    $matched === $migrations,
    'Vzor "' . $pattern . '" nezachytáva všetky migračné skripty na disku.',
);

// Tabuľky, ktoré nevytvára setup_db.php, musí vytvoriť niektorý z migračných
// skriptov — inak by tabuľka na produkcii chýbala.
$setupTables = [];
if (preg_match_all('/CREATE TABLE IF NOT EXISTS\s+`?(\w+)`?/i', $setup, $setupMatches) > 0) {
    foreach ($setupMatches[1] as $table) {
        $setupTables[strtolower($table)] = true;
    }
}

$migrationOnlyTables = array_diff(array_keys($tablesCreated), array_keys($setupTables));
schemaMigrationTest(
    $migrationOnlyTables !== [],
    'Neočakávané: žiadna tabuľka sa nevytvára len migračným skriptom.',
);

foreach ($migrationOnlyTables as $table) {
    schemaMigrationTest(
        isset($tablesCreated[$table]),
        'Tabuľka ' . $table . ' musí mať vlastného nositeľa.',
    );
}

// ── Pomocníci na detekciu schémy sú zdieľaní ────────────────────────────────
schemaMigrationTest(
    is_file($root . '/schema_helpers.php'),
    'Musí existovať zdieľaný helper na detekciu schémy (schema_helpers.php).',
);

$helpers = (string) file_get_contents($root . '/schema_helpers.php');
foreach (['columnExists', 'indexExists', 'schemaTableExists'] as $function) {
    schemaMigrationTest(
        str_contains($helpers, 'function ' . $function),
        'schema_helpers.php musí poskytovať funkciu ' . $function . '().',
    );
}

schemaMigrationTest(
    str_contains($setup, "require_once __DIR__ . '/schema_helpers.php'"),
    'setup_db.php musí načítať zdieľané helpery schémy.',
);

// ── Index na odber noviniek ──────────────────────────────────────────────────
schemaMigrationTest(
    str_contains($setup, 'idx_users_newsletter'),
    'setup_db.php musí vytvoriť index idx_users_newsletter (filter pri enqueue).',
);

echo "Schema migrations: $checks PASS\n";
