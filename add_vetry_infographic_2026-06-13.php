<?php
declare(strict_types=1);
/**
 * add_vetry_infographic_2026-06-13.php
 * ────────────────────────────────────────────────────────────────────────────
 * Vloží úvodnú infografiku do článku „Koľko vetrov denne je ešte normálne?“.
 * Obrázok sa pridá na začiatok obsahu → stane sa aj náhľadom karty v sekcii
 * „Pre pacientov“. Idempotentné — ak už obrázok v obsahu je, nič nemení.
 *
 * PREDPOKLAD: súbor img/vetry-denne-infografika.png je nahraný na serveri.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_vetry_infographic_2026-06-13.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

if (php_sapi_name() !== 'cli') {
    header('Content-Type: text/plain; charset=utf-8');
}

$slug      = 'kolko-vetrov-denne-je-este-normalne';
$imageFile = 'img/vetry-denne-infografika.png';

$figureHtml = <<<HTML
<figure class="article-figure">
  <img src="$imageFile" alt="Infografika: priemerne približne 5× denne je normálne; frekvenciu ovplyvňuje strava, vláknina, črevná mikrobiota, pohyb a lieky. Kedy spozornieť: krv v stolici, úbytok hmotnosti, nočné bolesti, zmena stolice, chronická hnačka alebo zápcha, anémia, horúčka." loading="lazy" decoding="async">
  <figcaption>Koľko vetrov denne je ešte normálne — priemer, čo frekvenciu ovplyvňuje a kedy spozornieť. Plynatosť je normálna; výrazná zmena alebo varovné príznaky patria k lekárovi.</figcaption>
</figure>

HTML;

$sel = $pdo->prepare("SELECT id, content FROM articles WHERE slug = :slug LIMIT 1");
$sel->execute(['slug' => $slug]);
$row = $sel->fetch();

if (!$row) {
    echo "CHYBA: článok '$slug' sa nenašiel.\n";
    exit(1);
}

if (strpos((string) $row['content'], $imageFile) !== false) {
    echo "UŽ JE: infografika '$imageFile' už je v obsahu článku — bez zmeny.\n";
    exit(0);
}

$newContent = $figureHtml . (string) $row['content'];

$upd = $pdo->prepare("UPDATE articles SET content = :content WHERE id = :id");
$upd->execute(['content' => $newContent, 'id' => (int) $row['id']]);

echo "HOTOVO: infografika vložená na začiatok článku '$slug' (id " . (int) $row['id'] . ").\n";
echo "Náhľad karty: $imageFile\n";
