<?php

declare(strict_types=1);
require_once __DIR__ . '/ci_gate.php';
$sha = str_repeat('a', 40);
$cases = [
    [[], 'pending'],
    [[['headSha' => str_repeat('b', 40), 'status' => 'completed', 'conclusion' => 'success']], 'pending'],
    [[['headSha' => $sha, 'status' => 'in_progress']], 'pending'],
];
foreach (['failure', 'cancelled', 'skipped', 'timed_out', 'neutral', 'success'] as $conclusion) {
    $cases[] = [[['headSha' => $sha, 'status' => 'completed', 'conclusion' => $conclusion]], $conclusion === 'success' ? 'success' : 'failure'];
}
foreach ($cases as [$runs, $expected]) {
    if (nefroCiGateState($runs, $sha) !== $expected) {
        throw new RuntimeException('CI release gate regression.');
    }
}
echo 'CI gate: ' . count($cases) . " PASS\n";
