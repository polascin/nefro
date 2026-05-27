<?php
declare(strict_types=1);
// Jednorazová migrácia — tento súbor sa po spustení sám zmaže.
require_once __DIR__ . '/db_config.php';
header('Content-Type: text/plain; charset=UTF-8');

try {
    $check = $pdo->query("SHOW INDEX FROM newsletter_subscribers WHERE Key_name = 'idx_ns_verify_token'");
    if ($check->fetch()) {
        echo "Index idx_ns_verify_token uz existuje. Nic sa nezmenilo.\n";
    } else {
        $pdo->exec("ALTER TABLE newsletter_subscribers ADD INDEX idx_ns_verify_token (verify_token)");
        echo "Index idx_ns_verify_token bol uspesne pridany.\n";
    }
} catch (\Throwable $e) {
    echo "CHYBA: " . $e->getMessage() . "\n";
}

@unlink(__FILE__);
echo "Subor migrácie bol zmazaný.\n";
