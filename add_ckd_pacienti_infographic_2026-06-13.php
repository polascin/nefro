<?php
declare(strict_types=1);
/**
 * add_ckd_pacienti_infographic_2026-06-13.php
 * ────────────────────────────────────────────────────────────────────────────
 * Vloží úvodnú infografiku do článku „Chronická choroba obličiek podľa KDIGO 2024:
 * čo môže pacient urobiť…". Obrázok sa pridá na začiatok obsahu → stane sa aj
 * náhľadom karty v sekcii „Pre pacientov". Obrázok je obalený odkazom
 * (klik = nová karta). Idempotentné — ak už obrázok v obsahu je, nič nemení.
 *
 * PREDPOKLAD: súbor img/ckd-pacienti-infografika.png je nahraný na serveri.
 *
 * Spustenie cez SSH:
 *   ssh -i "$HOME/.ssh/nefro_deploy" -p 26650 \
 *       uid58858@shell.r1.websupport.sk \
 *       "php /data/8/6/868f981d-e598-4e71-b7f5-246f2e180cef/polascin.net/sub/nefro/add_ckd_pacienti_infographic_2026-06-13.php"
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

$slug      = 'chronicka-choroba-obliciek-podla-kdigo-2024-co-moze-pacient-urobit-pre-svoje-oblicky';
$imageFile = 'img/ckd-pacienti-infografika.png';

$figureHtml = <<<HTML
<figure class="article-figure">
  <a href="$imageFile" target="_blank" rel="noopener noreferrer">
    <img src="$imageFile" alt="Infografika: čo môže pacient urobiť pre svoje obličky podľa KDIGO 2024 — včasná diagnostika, úprava životného štýlu, kontrola krvného tlaku, moderná nefroprotektívna liečba a aktívna spolupráca s lekárom." loading="lazy" decoding="async">
  </a>
  <figcaption>Čo môže pacient urobiť pre svoje obličky podľa KDIGO 2024 — diagnostika, životný štýl, krvný tlak, liečba a spolupráca s lekárom. Individuálny plán vždy nastavuje lekár.</figcaption>
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
