<?php

declare(strict_types=1);
/**
 * add_providers_priorities_seed.php
 * Prvotné nastavenie priority A/B/C odporúčateľov (partner_providers.priority)
 * podľa návrhu „koho ešte osloviť" z 1. 11. 2026:
 *   A  západná Bratislava v spáde strediska (Dúbravka, Karlova Ves, Lamač,
 *      Devínska Nová Ves, Devín, Záhorská Bystrica): ambulancie,
 *   B  inštitúcie (nemocnice, polikliniky, transplantačné centrá), zariadenia
 *      sociálnych služieb, Nové Mesto, Staré Mesto, Rovinka, Stupava,
 *   C  východná časť mesta (Ružinov, Podunajské Biskupice, Vrakuňa, Rača,
 *      Petržalka): hromadný list.
 * Zapisuje LEN tam, kde je priorita prázdna, takže ručné úpravy v admin_providers.php
 * zostanú zachované; neaktívne záznamy a vlastní lekári strediska sa vynechávajú.
 *
 * Spustenie: php add_providers_priorities_seed.php [--dry-run]
 */
if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Nastaviť priority odporúčateľov A/B/C');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$dryRun = in_array('--dry-run', $argv ?? [], true);

$west = ['Bratislava-Dúbravka', 'Bratislava-Karlova Ves', 'Bratislava-Lamač',
    'Bratislava-Devínska Nová Ves', 'Bratislava-Devín', 'Bratislava-Záhorská Bystrica'];
$east = ['Bratislava-Ružinov', 'Bratislava-Podunajské Biskupice', 'Bratislava-Vrakuňa',
    'Bratislava-Rača', 'Bratislava-Petržalka'];
$mid  = ['Bratislava-Nové Mesto', 'Bratislava-Staré Mesto', 'Rovinka', 'Stupava'];
$institutions = ['nemocnica', 'poliklinika', 'transplant', 'socialna_sluzba'];

/** Výnimky podľa začiatku názvu (najskôr sa uplatnia). */
$overrides = [
    'MUDr. Juraj Magyarics' => null, // vlastný lekár strediska, neoslovuje sa
    'CINRE'                 => 'B',  // interná ambulancia v Nemocnici Bory: osloviť s nemocnicou
];

function ppPriorityFor(array $r, array $west, array $east, array $mid, array $institutions, array $overrides): ?string
{
    foreach ($overrides as $prefix => $p) {
        if (str_starts_with((string) $r['name'], $prefix)) {
            return $p;
        }
    }
    $loc  = (string) $r['locality'];
    $type = (string) $r['provider_type'];
    if (in_array($loc, $east, true)) {
        return 'C';
    }
    if (in_array($type, $institutions, true) || in_array($loc, $mid, true)) {
        return 'B';
    }
    if (in_array($loc, $west, true)) {
        return 'A';
    }
    return null; // neznáma lokalita: nechať na ručné rozhodnutie
}

$rows = $pdo->query(
    "SELECT id, name, provider_type, locality FROM partner_providers
     WHERE is_active = 1 AND (priority IS NULL OR priority = '') ORDER BY id"
)->fetchAll(\PDO::FETCH_ASSOC);

$upd    = $pdo->prepare('UPDATE partner_providers SET priority = :p WHERE id = :id');
$counts = ['A' => 0, 'B' => 0, 'C' => 0, 'bez' => 0];
if ($dryRun) {
    echo '[dry-run] nič sa nezapisuje' . PHP_EOL;
}
foreach ($rows as $r) {
    $p = ppPriorityFor($r, $west, $east, $mid, $institutions, $overrides);
    if ($p === null) {
        $counts['bez']++;
        echo "bez priority: {$r['id']} {$r['name']} ({$r['locality']})" . PHP_EOL;
        continue;
    }
    $counts[$p]++;
    echo "{$p}: {$r['id']} {$r['name']}" . PHP_EOL;
    if (!$dryRun) {
        $upd->execute(['p' => $p, 'id' => (int) $r['id']]);
    }
}
echo "Priority: A {$counts['A']}, B {$counts['B']}, C {$counts['C']}, bez priority {$counts['bez']} (spracovaných " . count($rows) . ')' . PHP_EOL;
