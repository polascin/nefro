<?php
// Ochrana pred priamym prístupom k súboru
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit("Prístup odmietnutý.");
}

/**
 * Konfigurácia pripojenia k databáze
 * 
 * POZNÁMKA: Nahraďte 'ZADAJTE_MENO' a 'ZADAJTE_HESLO' vašimi skutočnými údajmi.
 */
$env = parse_ini_file(__DIR__ . '/env.ini');
if ($env === false) {
    exit("Chyba: Konfiguračný súbor env.ini sa nenašiel alebo je neplatný.");
}

$dbHost = $env['DB_HOST'];
$dbName = $env['DB_NAME'];
$dbUser = $env['DB_USER'];
$dbPass = $env['DB_PASS'];
$dbCharset = 'utf8mb4';

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Vyhadzovanie výnimiek pri chybách
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Výsledky ako asociatívne polia
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Použitie natívnych prepared statements pre lepšiu bezpečnosť
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (\PDOException $e) {
    // V produkcii by sa chyba nemala vypisovať priamo kvôli bezpečnosti
    // Zapisujeme do logu a zobrazíme všeobecnú chybu
    error_log("Chyba pripojenia k databáze: " . $e->getMessage());
    // exit("Pripojenie k databáze zlyhalo. Skontrolujte konfiguračný súbor.");
}
?>
