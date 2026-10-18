<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli' || !is_file('/.dockerenv')) {
    exit('Restore probe requires the isolated CLI container.');
}

// Output is an aggregate allowlist. Never print source paths, secrets or HTTP bodies.
ini_set('display_errors', '0');
ini_set('error_log', '/dev/null');
set_error_handler(static function (int $severity): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new RuntimeException('Probe warning withheld.');
});

function probeCheck(bool $condition): void
{
    if (!$condition) {
        throw new RuntimeException('Restore application control failed; raw data withheld.');
    }
}

function probePath(string $relative): string|false
{
    $relative = rawurldecode($relative);
    if ($relative === '' || str_contains($relative, "\0") || str_contains($relative, '\\')
        || str_starts_with($relative, '/') || in_array('..', explode('/', $relative), true)) {
        return false;
    }
    $path = realpath('/restore/' . $relative);
    return $path !== false && str_starts_with($path, '/restore/') && is_file($path) && is_readable($path) ? $path : false;
}

function probeReferences(array $paths): array
{
    $missing = [];
    $result = ['references' => count($paths), 'present' => 0, 'missing_or_unsafe' => 0];
    foreach ($paths as $path) {
        $absent = probePath((string) $path) === false;
        ++$result[$absent ? 'missing_or_unsafe' : 'present'];
        if ($absent) {
            $missing[(string) $path] = true;
        }
    }
    $result['unique_missing_paths'] = count($missing);
    return $result;
}

$stage = 'input';
try {
    $input = json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR);
    $stage = 'key_configuration';
    $rawKey = '';
    $keySource = null;
    // Read archived configuration strictly as data. Never activate its DB/SMTP/API settings.
    foreach (['private/nefro.env.ini', 'private/env.ini', 'env.ini'] as $candidate) {
        if (!is_file('/restore/' . $candidate)) {
            continue;
        }
        $config = parse_ini_file('/restore/' . $candidate, false, INI_SCANNER_TYPED);
        probeCheck(is_array($config));
        foreach (['DATA_PROTECTION_KEY', 'APP_KEY', 'APP_SECRET', 'NEWSLETTER_UNSUBSCRIBE_SECRET'] as $field) {
            if (trim((string) ($config[$field] ?? '')) !== '') {
                $rawKey = trim((string) $config[$field]);
                $keySource = $field;
                break;
            }
        }
        unset($config);
        break;
    }
    if ($rawKey === '' && is_file('/restore/private/data_protection.key')) {
        $rawKey = trim(file_get_contents('/restore/private/data_protection.key'));
        $keySource = 'persistent_key_file';
    }
    // Archived runtime sees only a minimal, explicitly isolated configuration.
    $databaseConfig = "DB_HOST=localhost\nDB_NAME=nefro_restore_unused\nDB_USER=restore_unused\nDB_PASS=unused\n";
    if (isset($input['reader_password'])) {
        probeCheck(preg_match('/^[A-Za-z0-9_]+$/', $input['database_name']) === 1
            && preg_match('/^[a-f0-9]{48}$/', $input['reader_password']) === 1);
        $databaseConfig = "DB_HOST=localhost\nDB_NAME=" . $input['database_name']
            . "\nDB_USER=restore_reader\nDB_PASS=" . $input['reader_password'] . "\n";
    }
    file_put_contents('/restore/.drill.ini', "APP_ENV=local\nAPP_LOCAL_DEV=true\nBOT_GUARD_ENABLED=false\n" . $databaseConfig);
    putenv('NEFRO_ENV_PATH=/restore/.drill.ini');
    foreach (['DATA_PROTECTION_KEY', 'APP_KEY', 'APP_SECRET', 'NEWSLETTER_UNSUBSCRIBE_SECRET'] as $field) {
        putenv($field);
    }
    if ($rawKey !== '') {
        putenv('DATA_PROTECTION_KEY=' . $rawKey);
    }
    $stage = 'archived_helpers';
    $appRoot = realpath('/restore');
    probeCheck($appRoot !== false);
    require $appRoot . '/config_loader.php';
    require $appRoot . '/totp.php';
    require $appRoot . '/calculators_common.php';
    require $appRoot . '/publications_common.php';
    $checks = 0;
    foreach ([[90.0, 'G1'], [60.0, 'G2'], [45.0, 'G3a'], [30.0, 'G3b'], [15.0, 'G4'], [14.9, 'G5']] as [$value, $category]) {
        probeCheck(ckdGCategory($value) === $category);
        ++$checks;
    }
    probeCheck(calculatorParsePositiveFloat('1,25') === 1.25 && calculatorParsePositiveFloat('-1') === null);
    ++$checks;
    probeCheck(publicationFilePath('../escape', 'pdf') === null && publicationFilePath('invalid', 'unknown') === null);
    ++$checks;
    $catalogPaths = [];
    foreach (publications() as $publication) {
        $slug = $publication['slug'];
        foreach (publicationFormats() as $format => $definition) {
            $catalogPaths[] = 'private/publications/' . $slug . '/' . $slug . '.' . $definition['ext'];
        }
    }
    $stage = 'cryptography';
    $crypto = ['key_available' => $rawKey !== '', 'key_source' => $keySource,
        'synthetic_round_trip' => 'NOT_RUN', 'encrypted_records' => 0, 'decrypted' => 0,
        'failed' => 0, 'legacy_plaintext_records' => 0, 'enabled_without_secret' => 0,
        'wrong_key_rejected' => 0, 'tampered_rejected' => 0, 'existing_record_decryption' => 'NOT_RUN'];
    $ciphertexts = [];
    if ($rawKey !== '') {
        // Real archived key derivation and encryption functions, with a fictitious secret.
        probeCheck(hash_equals(hash('sha256', $rawKey, true), getAppDataProtectionKey()));
        $fixture = 'JBSWY3DPEHPK3PXP';
        $envelope = encodeTotpStorage($fixture, []);
        probeCheck(decodeTotpStorage($envelope['secret_field'], $envelope['backup_json'])['secret'] === $fixture);
        $crypto['synthetic_round_trip'] = 'PASS';
    }
    unset($rawKey);
    foreach ($input['totp'] ?? [] as $record) {
        if (($record['secret'] ?? '') === TOTP_ENCRYPTED_MARKER) {
            ++$crypto['encrypted_records'];
            try {
                probeCheck($crypto['key_available']);
                $decoded = decodeTotpStorage($record['secret'], $record['storage']);
                probeCheck(!$decoded['legacy'] && totpBase32Decode($decoded['secret']) !== false);
                unset($decoded);
                ++$crypto['decrypted'];
                $ciphertexts[] = json_decode($record['storage'], true, 512, JSON_THROW_ON_ERROR)['secret'];
            } catch (Throwable) {
                ++$crypto['failed'];
            }
        } elseif (($record['secret'] ?? '') !== '') {
            ++$crypto['legacy_plaintext_records'];
        } elseif ((int) ($record['enabled'] ?? 0) === 1) {
            ++$crypto['enabled_without_secret'];
        }
    }
    if ($ciphertexts !== []) {
        $pipes = [];
        $process = proc_open(['php', '/checks/wrong_key_probe.php'], [['pipe', 'r'], ['pipe', 'w'], ['file', '/dev/null', 'a']], $pipes);
        probeCheck(is_resource($process));
        fwrite($pipes[0], json_encode($ciphertexts, JSON_THROW_ON_ERROR));
        fclose($pipes[0]);
        $wrong = json_decode(stream_get_contents($pipes[1]), true, 512, JSON_THROW_ON_ERROR);
        fclose($pipes[1]);
        probeCheck(proc_close($process) === 0);
        $crypto['wrong_key_rejected'] = $wrong['rejected'];
        foreach ($ciphertexts as $ciphertext) {
            $payload = totpBase64UrlDecode(substr($ciphertext, 3));
            $payload[strlen($payload) - 1] = chr(ord($payload[strlen($payload) - 1]) ^ 1);
            try {
                decryptTotpSecret(substr($ciphertext, 0, 3) . totpBase64UrlEncode($payload));
            } catch (Throwable) {
                ++$crypto['tampered_rejected'];
            }
        }
        $crypto['existing_record_decryption'] = $crypto['failed'] === 0
            && $crypto['wrong_key_rejected'] === $crypto['encrypted_records']
            && $crypto['tampered_rejected'] === $crypto['encrypted_records'] ? 'PASS' : 'FAIL';
    } elseif ($crypto['encrypted_records'] > 0) {
        $crypto['existing_record_decryption'] = 'FAIL';
    } elseif ($input['database_available']) {
        $crypto['existing_record_decryption'] = 'NO_ENCRYPTED_RECORDS';
    }
    unset($ciphertexts, $record, $input['totp']);
    $stage = 'references';
    $references = ['paid_catalog' => probeReferences($catalogPaths)];
    if ($input['database_available']) {
        foreach (['article_pdfs', 'article_images', 'avatars', 'archived_avatars', 'order_files'] as $group) {
            $references[$group] = probeReferences($input[$group]);
        }
    }
    $databaseReadOnly = 'NOT_RUN';
    if (isset($input['reader_password'])) {
        $stage = 'database_socket';
        $connection = new PDO('mysql:unix_socket=/run/mysqld/mysqld.sock;dbname=' . $input['database_name'] . ';charset=utf8mb4',
            'restore_reader', $input['reader_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]);
        probeCheck($connection->query('SELECT COUNT(*) FROM articles')->fetchColumn() !== false);
        try {
            $connection->exec('CREATE TABLE nefro_restore_write_probe(id INT)');
            probeCheck(false);
        } catch (PDOException $error) {
            probeCheck((int) ($error->errorInfo[1] ?? 0) === 1142);
        }
        $databaseReadOnly = 'PASS';
        unset($connection, $input['reader_password'], $databaseConfig);
    }
    $stage = 'http_start';
    $http = [];
    $databaseHttp = 0;
    $searchResultsVerified = false;
    mkdir('/restore/.drill-sessions', 0700);
    $server = proc_open(['php', '-d', 'display_errors=0', '-d', 'log_errors=0', '-d', 'pdo_mysql.default_socket=/run/mysqld/mysqld.sock', '-d', 'session.save_path=/restore/.drill-sessions', '-S', '127.0.0.1:8099', '-t', '/restore', '/checks/probe_router.php'],
        [['file', '/dev/null', 'r'], ['file', '/dev/null', 'a'], ['file', '/dev/null', 'a']], $unused);
    probeCheck(is_resource($server));
    try {
        for ($attempt = 0; $attempt < 50; ++$attempt) {
            $socket = @fsockopen('127.0.0.1', 8099, $errorCode, $errorMessage, 0.1);
            if (is_resource($socket)) {
                fclose($socket);
                break;
            }
            usleep(100000);
        }
        if ($databaseReadOnly === 'PASS') {
            $stage = 'http_database';
            foreach (['index.php', 'search.php', 'login.php', 'download_pdf.php', 'article.php'] as $position => $endpoint) {
                $stage = 'missing_required_endpoint_' . $position;
                probeCheck(is_file('/restore/' . $endpoint));
            }
            $routes = ['/index.php', '/search.php?s=oblicky', '/login.php', '/download_pdf.php?slug=restore-probe'];
            if ($input['published_slug'] ?? null) {
                $routes[] = '/article.php?slug=' . rawurlencode($input['published_slug']);
            }
            foreach ($routes as $route) {
                $curl = curl_init('http://127.0.0.1:8099' . $route);
                curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30,
                    CURLOPT_FOLLOWLOCATION => false, CURLOPT_USERAGENT => 'Mozilla/5.0 RestoreDrill']);
                $body = curl_exec($curl);
                $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
                $expectedStatus = str_starts_with($route, '/download_pdf.php') ? 302 : 200;
                $stage = 'http_database_check_' . $databaseHttp . '_status_' . $status;
                probeCheck(is_string($body) && ($expectedStatus === 302 || $body !== '') && $status === $expectedStatus
                    && !preg_match('/Fatal error|Uncaught|Warning:|SQLSTATE|Chyba: Pripojenie|Chyba: Databázová/', $body));
                if (str_starts_with($route, '/search.php')) {
                    probeCheck(str_contains($body, 'class="search-meta"') && str_contains($body, 'oblicky'));
                    $searchResultsVerified = true;
                }
                unset($body, $curl);
                ++$databaseHttp;
            }
        }
        $stage = 'http_negative_controls';
        foreach ([['GET', '?edition=invalid&format=pdf', 404], ['GET', '?edition=../&format=pdf', 404], ['POST', '?edition=sk&format=pdf', 405]] as [$method, $query, $status]) {
            $curl = curl_init('http://127.0.0.1:8099/download_free_publication.php' . $query);
            curl_setopt_array($curl, [CURLOPT_CUSTOMREQUEST => $method, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20, CURLOPT_USERAGENT => 'Mozilla/5.0 RestoreDrill']);
            curl_exec($curl);
            $stage = 'http_negative_expected_' . $status . '_actual_' . curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            probeCheck(curl_getinfo($curl, CURLINFO_RESPONSE_CODE) === $status);
            unset($curl);
            $http[] = 'PASS';
        }
        $stage = 'http_downloads';
        $editions = ['sk' => 'sk-nefro-dokazane-pravdepodobne-otvorene', 'en' => 'sk-nefro-proven-probable-open',
            'de' => 'sk-nefro-belegt-wahrscheinlich-offen', 'it' => 'sk-nefro-dimostrato-probabile-aperto'];
        foreach ($editions as $edition => $stem) {
            foreach (publicationFormats() as $format => $definition) {
                $path = probePath('pdf/publikacie/' . $stem . '.' . $definition['ext']);
                probeCheck($path !== false);
                $hash = hash_init('sha256');
                $curl = curl_init('http://127.0.0.1:8099/download_free_publication.php?edition=' . $edition . '&format=' . $format);
                curl_setopt_array($curl, [CURLOPT_TIMEOUT => 30, CURLOPT_USERAGENT => 'Mozilla/5.0 RestoreDrill', CURLOPT_WRITEFUNCTION => static function ($handle, string $chunk) use ($hash): int {
                    hash_update($hash, $chunk);
                    return strlen($chunk);
                }]);
                probeCheck(curl_exec($curl) !== false && curl_getinfo($curl, CURLINFO_RESPONSE_CODE) === 200
                    && hash_equals(hash_file('sha256', $path), hash_final($hash)));
                unset($curl);
                $http[] = 'PASS';
            }
        }
    } finally {
        proc_terminate($server);
        proc_close($server);
    }
    $missing = array_sum(array_column($references, 'missing_or_unsafe'));
    $result = !$input['database_available'] ? 'PARTIAL' : 'PASS';
    if ($missing || $crypto['existing_record_decryption'] === 'FAIL' || $crypto['enabled_without_secret'] > 0) {
        $result = 'FAIL';
    } elseif ($crypto['existing_record_decryption'] !== 'PASS' || $databaseHttp !== 5) {
        $result = 'PARTIAL';
    }
    echo json_encode(['result' => $result,
        'database_available' => $input['database_available'], 'references' => $references, 'cryptography' => $crypto,
        'archived_application_helper_checks' => $checks, 'public_download_http_checks' => count($http),
        'database_read_only_account' => $databaseReadOnly, 'database_http_checks' => $databaseHttp,
        'search_results_branch_verified' => $searchResultsVerified,
        'database_relations' => $input['relations'] ?? [],
        'limits' => ['No authenticated production-account flow, external service, browser rendering or Apache configuration test.',
            'Synthetic key round trip alone does not prove decryption of an existing record.',
            'Reference presence does not prove semantic PDF/content parity or a common recovery timestamp.']], JSON_THROW_ON_ERROR);
} catch (Throwable $error) {
    echo json_encode(['result' => 'FAIL', 'probe_error_stage' => $stage, 'probe_error_line' => $error->getLine(),
        'database_available' => $input['database_available'] ?? false,
        'references' => $references ?? [], 'cryptography' => $crypto ?? [],
        'archived_application_helper_checks' => $checks ?? 0, 'public_download_http_checks' => count($http ?? []),
        'database_read_only_account' => $databaseReadOnly ?? 'NOT_RUN', 'database_http_checks' => $databaseHttp ?? 0,
        'search_results_branch_verified' => $searchResultsVerified ?? false,
        'database_relations' => $input['relations'] ?? [],
        'limits' => ['Probe stopped at the reported stage; later checks were not executed. Raw data withheld.']], JSON_THROW_ON_ERROR);
}
