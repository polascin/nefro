<?php
declare(strict_types=1);
/**
 * add_search_ft_index.php
 * Jednorazová migrácia: pridá FULLTEXT index na tabuľku articles.
 * Spusti cez CLI: php add_search_ft_index.php
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Prístup odmietnutý — spusti cez CLI.\n");
}

require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

echo "── FULLTEXT index migrácia ────────────────────────────────────────\n";

// Skontroluj, či index už existuje
$chk = $pdo->prepare(
    "SELECT COUNT(*) FROM information_schema.STATISTICS
     WHERE table_schema = DATABASE()
       AND table_name   = 'articles'
       AND index_name   = 'ft_articles_search'
       AND index_type   = 'FULLTEXT'"
);
$chk->execute();
$exists = (int) $chk->fetchColumn();

if ($exists > 0) {
    echo "ℹ️   FULLTEXT index 'ft_articles_search' už existuje. Nie je potrebná migrácia.\n";
    exit(0);
}

try {
    echo "   Pridávam FULLTEXT index na (title, excerpt, content)...\n";
    $pdo->exec(
        "ALTER TABLE articles
         ADD FULLTEXT INDEX ft_articles_search (title, excerpt, content)"
    );
    echo "✅  FULLTEXT index bol úspešne vytvorený.\n";
    echo "   Vyhľadávanie teraz využíva FULLTEXT + LIKE v kombinácii.\n";
} catch (\PDOException $e) {
    echo "❌  Chyba pri vytváraní indexu: " . $e->getMessage() . "\n";
    exit(1);
}

// Overenie
$verify = $pdo->prepare(
    "SELECT index_type, COUNT(*) as col_count
     FROM information_schema.STATISTICS
     WHERE table_schema = DATABASE()
       AND table_name   = 'articles'
       AND index_name   = 'ft_articles_search'
     GROUP BY index_type"
);
$verify->execute();
$row = $verify->fetch();
echo "\n── Verifikácia ─────────────────────────────────────────────────────\n";
echo "   Index typ:    " . ($row['index_type'] ?? '?') . "\n";
echo "   Počet stĺpcov: " . ($row['col_count'] ?? '?') . "\n";
echo "────────────────────────────────────────────────────────────────────\n";
