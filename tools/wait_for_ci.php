<?php

declare(strict_types=1);

require_once __DIR__ . '/ci_gate.php';
$sha = trim((string) ($argv[1] ?? ''));
if (PHP_SAPI !== 'cli' || !preg_match('/^[a-f0-9]{40}$/D', $sha)) {
    throw new RuntimeException('Usage: php tools/wait_for_ci.php <full-commit-sha>');
}
$deadline = time() + 1200;
echo "[CI] Waiting for required deploy validation and regression gate.\n";
do {
    $process = proc_open(['gh', 'run', 'list', '--repo', 'polascin/nefro', '--workflow', 'deploy.yml', '--commit', $sha, '--event', 'push', '--limit', '1', '--json', 'headSha,status,conclusion'], [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipes);
    if (!is_resource($process)) {
        throw new RuntimeException('GitHub CLI is required for production release validation.');
    }
    fclose($pipes[0]);
    $output = stream_get_contents($pipes[1]);
    stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    if (proc_close($process) !== 0) {
        throw new RuntimeException('Cannot verify GitHub CI; production deploy denied.');
    }
    $state = nefroCiGateState(json_decode($output, true, 512, JSON_THROW_ON_ERROR), $sha);
    if ($state === 'success') {
        echo "[CI] Exact commit passed required validation.\n";
        exit(0);
    }
    if ($state === 'failure') {
        throw new RuntimeException('Required CI failed or was cancelled; production deploy denied.');
    }
    sleep(10);
} while (time() < $deadline);
throw new RuntimeException('Timed out waiting for required CI; production deploy denied.');
