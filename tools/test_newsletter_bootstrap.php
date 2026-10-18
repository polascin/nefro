<?php

declare(strict_types=1);

$source = (string) file_get_contents(__DIR__ . '/../newsletter_subscribe.php');
$beforeDatabase = explode("require_once __DIR__ . '/db_config.php';", $source, 2)[0];
preg_match_all("/require_once __DIR__ \\. '\/([^']+)';/", $beforeDatabase, $includes);
foreach ($includes[1] as $include) {
    require_once __DIR__ . '/../' . $include;
}
if (!function_exists('checkFormRateLimit')) {
    throw new RuntimeException('Newsletter endpoint nenačítal limiter pred prvým použitím.');
}

$checks = 1;
function newsletterBootstrapTest(bool $ok, string $label): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($label);
    }
}

class NewsletterLimitTestPdo extends Pdo\Sqlite
{
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        $query = str_replace('ON DUPLICATE KEY UPDATE id = id', 'ON CONFLICT(ip, action) DO NOTHING', $query);
        $query = str_replace('FOR UPDATE', '', $query);
        $query = str_replace('IF(:reset_window = 1, NOW(), first_attempt)', 'iif(:reset_window = 1, NOW(), first_attempt)', $query);
        $query = str_replace('TIMESTAMPDIFF(SECOND, first_attempt, NOW())', "(CAST(strftime('%s', NOW()) AS INTEGER) - CAST(strftime('%s', first_attempt) AS INTEGER))", $query);
        $query = str_replace('TIMESTAMPADD(SECOND, :window_seconds, NOW())', "datetime(NOW(), '+' || :window_seconds || ' seconds')", $query);
        return parent::prepare($query, $options);
    }
}

$pdo = new NewsletterLimitTestPdo('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$now = date('Y-m-d H:i:s');
$pdo->createFunction('NOW', static fn (): string => $now);
$pdo->exec('CREATE TABLE form_rate_limit (id INTEGER PRIMARY KEY, ip TEXT, action TEXT,
    attempt_count INTEGER, first_attempt TEXT, last_attempt TEXT, blocked_until TEXT,
    UNIQUE(ip, action))');
$ip = '192.0.2.10';
newsletterBootstrapTest(checkFormRateLimit($pdo, 'nl_subscribe', $ip, 2, 60), 'Prvý pokus je povolený.');
newsletterBootstrapTest(checkFormRateLimit($pdo, 'nl_subscribe', $ip, 2, 60), 'Posledný povolený pokus.');
newsletterBootstrapTest(!checkFormRateLimit($pdo, 'nl_subscribe', $ip, 2, 60), 'Nadlimitný pokus je blokovaný.');
$blocked = $pdo->query('SELECT blocked_until FROM form_rate_limit')->fetchColumn();
newsletterBootstrapTest(!checkFormRateLimit($pdo, 'nl_subscribe', $ip, 2, 60), 'Aktívna blokácia zostáva.');
newsletterBootstrapTest($pdo->query('SELECT blocked_until FROM form_rate_limit')->fetchColumn() === $blocked, 'Aktívna blokácia sa neskráti.');
newsletterBootstrapTest(checkFormRateLimit($pdo, 'different_action', $ip, 2, 60), 'Odlišné akcie majú vlastný limit.');
$pdo->prepare("UPDATE form_rate_limit SET first_attempt = ?, blocked_until = NULL WHERE action = 'nl_subscribe'")
    ->execute([date('Y-m-d H:i:s', time() - 120)]);
newsletterBootstrapTest(checkFormRateLimit($pdo, 'nl_subscribe', $ip, 2, 60), 'Nové okno umožní ďalší pokus.');
newsletterBootstrapTest((int) $pdo->query("SELECT attempt_count FROM form_rate_limit WHERE action = 'nl_subscribe'")->fetchColumn() === 1, 'Po uplynutí okna sa počítadlo resetuje.');

echo "Newsletter bootstrap and limits: $checks PASS\n";
