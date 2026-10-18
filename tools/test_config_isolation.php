<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$script = 'require ' . var_export($root . '/config_loader.php', true) . ';'
    . '$paths=getAppConfigPaths(); if(count($paths)!==1 || $paths[0]!==getenv("NEFRO_ENV_PATH")){exit(2);}'
    . 'try{loadAppConfig();exit(3);}catch(AppConfigException $e){echo "Config isolation PASS\n";}';
$environment = getenv();
$environment['NEFRO_ENV_PATH'] = sys_get_temp_dir() . '/nefro-missing-' . bin2hex(random_bytes(8)) . '.ini';
$process = proc_open([PHP_BINARY, '-r', $script], [STDIN, STDOUT, STDERR], $pipes, $root, $environment);
if (!is_resource($process) || proc_close($process) !== 0) {
    throw new RuntimeException('Explicit configuration must fail closed, without fallback.');
}
