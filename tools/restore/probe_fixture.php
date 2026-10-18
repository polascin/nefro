<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli' || !is_file('/.dockerenv')) {
    exit('Restore fixture requires the isolated CLI container.');
}

// Synthetic data only; never read a hosting archive or a host configuration.
foreach (['auth.php', 'bot_guard.php', 'config_loader.php', 'totp.php', 'calculators_common.php',
    'publications_common.php', 'email_verification.php', 'download_free_publication.php'] as $name) {
    copy('/app/' . $name, '/fixture/files/' . $name);
}
mkdir('/fixture/files/private', 0700);
file_put_contents('/fixture/files/private/nefro.env.ini', "DATA_PROTECTION_KEY=synthetic-restore-fixture-key\n");
putenv('NEFRO_ENV_PATH=/fixture/files/private/nefro.env.ini');
$fixtureRoot = realpath('/fixture/files');
if ($fixtureRoot === false) {
    throw new RuntimeException('Synthetic fixture root missing.');
}
require $fixtureRoot . '/totp.php';
require $fixtureRoot . '/publications_common.php';
$storage = encodeTotpStorage('JBSWY3DPEHPK3PXP', []);
foreach (publications() as $publication) {
    $slug = $publication['slug'];
    mkdir('/fixture/files/private/publications/' . $slug, 0700, true);
    foreach (publicationFormats() as $format => $definition) {
        copy('/fixture/files/synthetic.' . $format, '/fixture/files/private/publications/' . $slug . '/' . $slug . '.' . $definition['ext']);
    }
}
mkdir('/fixture/files/pdf/publikacie', 0700, true);
foreach (['sk-nefro-dokazane-pravdepodobne-otvorene', 'sk-nefro-proven-probable-open',
    'sk-nefro-belegt-wahrscheinlich-offen', 'sk-nefro-dimostrato-probabile-aperto'] as $stem) {
    foreach (publicationFormats() as $format => $definition) {
        copy('/fixture/files/synthetic.' . $format, '/fixture/files/pdf/publikacie/' . $stem . '.' . $definition['ext']);
    }
}
copy('/fixture/files/synthetic.pdf', '/fixture/files/pdf/article.pdf');
mkdir('/fixture/files/img');
file_put_contents('/fixture/files/img/fixture.svg', '<svg xmlns="http://www.w3.org/2000/svg"/>');
$sql = "CREATE DATABASE nefro_restore_fixture CHARACTER SET utf8mb4; USE nefro_restore_fixture;
CREATE TABLE users(id INT PRIMARY KEY, avatar_path VARCHAR(255), totp_secret VARCHAR(32), totp_backup_codes TEXT, totp_enabled INT);
CREATE TABLE articles(id INT PRIMARY KEY, pdf_file VARCHAR(255), content TEXT);
CREATE TABLE calculator_results(id INT PRIMARY KEY, user_id INT, FOREIGN KEY(user_id) REFERENCES users(id));
INSERT INTO users VALUES(1,NULL,'encrypted:v1',CONVERT(0x" . bin2hex($storage['backup_json']) . " USING utf8mb4),1);
INSERT INTO articles VALUES(1,'article.pdf','<img src=\"img/fixture.svg\">');
INSERT INTO calculator_results VALUES(1,1);";
file_put_contents('/fixture/probe.sql', $sql);
file_put_contents('/fixture/files/index.php', '<?php require __DIR__ . "/config_loader.php"; $env=loadAppConfig(); $pdo=new PDO("mysql:host=localhost;dbname=".$env["DB_NAME"],$env["DB_USER"],$env["DB_PASS"]); echo "Synthetic articles: ".$pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();');
