<?php

declare(strict_types=1);

$pdo = new \PDO('sqlite::memory:');
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec(
    'CREATE TABLE access_logs (
        user_id INTEGER NULL,
        username TEXT NULL,
        event_type TEXT NOT NULL,
        method TEXT NOT NULL,
        request_uri TEXT NOT NULL,
        query_string TEXT NOT NULL,
        http_status INTEGER NOT NULL,
        client_ip TEXT NOT NULL,
        user_agent TEXT NOT NULL,
        referer TEXT NOT NULL,
        host TEXT NOT NULL,
        accept_language TEXT NOT NULL,
        response_time_ms INTEGER NULL,
        is_bot INTEGER NOT NULL
    )'
);
