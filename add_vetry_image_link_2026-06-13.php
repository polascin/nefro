<?php

declare(strict_types=1);
/**
 * add_vetry_image_link_2026-06-13.php
 * ────────────────────────────────────────────────────────────────────────────
 * Obalí infografiku v článku „Koľko vetrov denne je ešte normálne?“ odkazom,
 * ktorý po kliknutí otvorí plný obrázok v novej karte. Idempotentné.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_vetry_image_link_2026-06-13.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
    requireAdminMutationConfirmation('Pridať odkaz k infografike');
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

if (php_sapi_name() !== 'cli') {
    header('Content-Type: text/plain; charset=utf-8');
}

$slug      = 'kolko-vetrov-denne-je-este-normalne';
$imageFile = 'img/vetry-denne-infografika.png';

$sel = $pdo->prepare("SELECT id, content FROM articles WHERE slug = :slug LIMIT 1");
$sel->execute(['slug' => $slug]);
$row = $sel->fetch();

if (!$row) {
    echo "CHYBA: článok '$slug' sa nenašiel.\n";
    exit(1);
}

$content = (string) $row['content'];

// Už obalené odkazom?
if (strpos($content, 'href="' . $imageFile . '"') !== false) {
    echo "UŽ JE: obrázok je už obalený odkazom — bez zmeny.\n";
    exit(0);
}

// Nájdi <img ... src="img/vetry-denne-infografika.png" ...> a obaľ ho odkazom.
$pattern = '#<img\b[^>]*\bsrc="' . preg_quote($imageFile, '#') . '"[^>]*>#i';

$newContent = preg_replace_callback(
    $pattern,
    static function (array $m) use ($imageFile): string {
        return '<a href="' . $imageFile . '" target="_blank" rel="noopener noreferrer">'
            . $m[0]
            . '</a>';
    },
    $content,
    1,
    $count
);

if ($count === 0 || $newContent === null) {
    echo "CHYBA: <img> s '$imageFile' sa v obsahu nenašiel — bez zmeny.\n";
    exit(1);
}

$upd = $pdo->prepare("UPDATE articles SET content = :content WHERE id = :id");
$upd->execute(['content' => $newContent, 'id' => (int) $row['id']]);

echo "HOTOVO: obrázok obalený odkazom (nová karta) v článku '$slug' (id " . (int) $row['id'] . ").\n";
