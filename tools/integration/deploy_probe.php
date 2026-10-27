<?php

declare(strict_types=1);

if (!is_file('/.dockerenv') || PHP_SAPI !== 'cli') {
    throw new RuntimeException('Release probe requires a disposable container.');
}
$root = sys_get_temp_dir() . '/nefro-release-probe-' . bin2hex(random_bytes(6));
mkdir($root, 0700);
mkdir($root . '/hooks');
mkdir($root . '/tools');
mkdir($root . '/bin');
$environment = getenv();
$environment['PATH'] = $root . '/bin:' . $environment['PATH'];
$environment['NEFRO_DEPLOY_CONFIG'] = $root . '/absent-config';
$environment['NEFRO_SFTP_TARGET'] = 'synthetic@example.invalid';
$environment['NEFRO_REMOTE_PATH'] = '/fixture/nefro';
$environment['NEFRO_SFTP_BIN'] = $root . '/bin/sftp';
$environment['NEFRO_CAPTURE'] = $root . '/capture.json';
$environment['NEFRO_DEPLOY_MODE'] = 'sftp';
$environment['NEFRO_DEPLOY_GATE'] = 'local';
$environment['NEFRO_GATE_CMD'] = 'sh "$NEFRO_PROBE_BIN/gate"';
$environment['NEFRO_PROBE_BIN'] = $root . '/bin';
$environment['NEFRO_SKIP_POST_DEPLOY'] = '1';

function releaseProbeRun(array $command, string $root, array $environment): array
{
    $process = proc_open($command, [STDIN, ['pipe', 'w'], ['pipe', 'w']], $pipes, $root, $environment);
    if (!is_resource($process)) {
        throw new RuntimeException('Cannot start release probe subprocess.');
    }
    $output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    return [proc_close($process), $output];
}
try {
    foreach (['deploy.sh', 'deploy-ignore.txt'] as $name) {
        copy(__DIR__ . '/../../hooks/' . $name, $root . '/hooks/' . $name);
    }
    foreach (['ci_gate.php', 'wait_for_ci.php'] as $name) {
        copy(__DIR__ . '/../' . $name, $root . '/tools/' . $name);
    }
    // Náhrada hooks/local_gate.sh: simuluje neúspešnú bránu, zmenu HEAD počas
    // overovania a neoverené zmeny v pracovnom strome.
    file_put_contents($root . '/bin/gate', <<<'SHELL'
#!/bin/sh
case "$NEFRO_MODE" in
  moved) git -c user.name=Fixture -c user.email=fixture@example.invalid commit --allow-empty -qm newer ;;
  dirty) printf 'unverified working tree' > sample.php ;;
esac
[ "${NEFRO_CONCLUSION:-success}" = success ]
SHELL);
    chmod($root . '/bin/gate', 0755);
    file_put_contents($root . '/bin/sftp', <<<'PHP'
#!/usr/local/bin/php
<?php
$batch = $argv[array_search('-b', $argv, true) + 1];
preg_match_all('/^put "([^"]+)" "([^"]+)"$/m', file_get_contents($batch), $matches, PREG_SET_ORDER);
$payload = [];
foreach ($matches as $match) { $payload[basename($match[2])] = file_get_contents($match[1]); }
file_put_contents(getenv('NEFRO_CAPTURE'), json_encode($payload));
PHP);
    chmod($root . '/bin/sftp', 0755);
    foreach ([['git', 'init', '-q', '-b', 'main'], ['git', 'config', 'user.name', 'Fixture'], ['git', 'config', 'user.email', 'fixture@example.invalid']] as $command) {
        if (releaseProbeRun($command, $root, $environment)[0] !== 0) {
            throw new RuntimeException('Cannot create disposable fixture repository.');
        }
    }
    file_put_contents($root . '/sample.php', "<?php\necho 'verified commit';\n");
    releaseProbeRun(['git', 'add', 'sample.php'], $root, $environment);
    releaseProbeRun(['git', 'commit', '-qm', 'fixture'], $root, $environment);
    $environment['NEFRO_SHA'] = trim(releaseProbeRun(['git', 'rev-parse', 'HEAD'], $root, $environment)[1]);
    $environment['NEFRO_CONCLUSION'] = 'failure';
    $environment['NEFRO_MODE'] = 'normal';
    [$status] = releaseProbeRun(['bash', 'hooks/deploy.sh'], $root, $environment);
    if ($status === 0 || file_exists($root . '/capture.json')) {
        throw new RuntimeException('Failed gate must stop before SFTP.');
    }
    $environment['NEFRO_CONCLUSION'] = 'success';
    $environment['NEFRO_MODE'] = 'dirty';
    [$status, $output] = releaseProbeRun(['bash', 'hooks/deploy.sh'], $root, $environment);
    $capture = json_decode((string) @file_get_contents($root . '/capture.json'), true);
    if ($status !== 0 || ($capture['sample.php'] ?? '') !== "<?php\necho 'verified commit';\n") {
        throw new RuntimeException('Deploy must upload committed bytes, not working tree: ' . $output);
    }
    unlink($root . '/capture.json');
    $environment['NEFRO_MODE'] = 'moved';
    [$status] = releaseProbeRun(['bash', 'hooks/deploy.sh'], $root, $environment);
    if ($status === 0 || file_exists($root . '/capture.json')) {
        throw new RuntimeException('Changed HEAD must stop before SFTP.');
    }
    echo "Release probe: failed gate, immutable file snapshot and changed HEAD PASS\n";
} finally {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($root);
}
