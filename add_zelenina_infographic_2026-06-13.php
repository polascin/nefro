<?php
declare(strict_types=1);
/**
 * add_zelenina_infographic_2026-06-13.php
 * ────────────────────────────────────────────────────────────────────────────
 * Vloží úvodnú infografiku do článku „Zelenina pre lepšie zdravie obličiek (CKD):
 * 5 druhov…". Obrázok sa pridá na začiatok obsahu → stane sa aj náhľadom karty
 * v sekcii „Pre pacientov". Obrázok je obalený odkazom (klik = nová karta).
 * Idempotentné — ak už obrázok v obsahu je, nič nemení.
 *
 * PREDPOKLAD: súbor img/zelenina-infografika.png je nahraný na serveri.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_zelenina_infographic_2026-06-13.php"
 * ────────────────────────────────────────────────────────────────────────────
 */

if (php_sapi_name() !== 'cli') {
    require_once __DIR__ . '/auth.php';
    requireAdmin();
}
require_once __DIR__ . '/db_config.php';

if (php_sapi_name() !== 'cli') {
    header('Content-Type: text/plain; charset=utf-8');
}

$slug      = 'zelenina-pre-lepsie-zdravie-obliciek-ckd-5-druhov-dietologovia';
$imageFile = 'img/zelenina-infografika.png';

$figureHtml = <<<HTML
<figure class="article-figure">
  <a href="$imageFile" target="_blank" rel="noopener noreferrer">
    <img src="$imageFile" alt="Infografika: 5 druhov zeleniny pre zdravie obličiek pri CKD — červená repa, brukvovitá zelenina (brokolica, karfiol, kapusta), červené papriky, cesnak a cibuľa, zelené fazuľové struky. Pri CKD sledovať sodík, draslík, fosfor a hydratáciu podľa odporúčaní lekára." loading="lazy" decoding="async">
  </a>
  <figcaption>Päť druhov zeleniny, ktoré dietológovia odporúčajú zaradiť pri chronickom ochorení obličiek. Konkrétne hodnoty živín si vždy overte u lekára alebo dietológa.</figcaption>
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
