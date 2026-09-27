<?php

declare(strict_types=1);

/**
 * article_illustration.php
 * ────────────────────────────────────────────────────────────────────────────
 * Hromadné začlenenie ilustračného obrázka do článkov podľa manifestu.
 *
 * Manifest je JSON pole položiek:
 *   [{"slug": "...", "img": "nazov-suboru-bez-pripony", "alt": "...", "caption": "..."}]
 *
 * Dva režimy — HTML figúry generuje v oboch rovnaká funkcia, takže zdrojový
 * skript článku a obsah v databáze zostávajú zhodné:
 *
 *   --local   (spúšťa sa lokálne) vloží figúru do zdrojového `add_<slug>_article.php`,
 *             aby ju budúci re-run skriptu neprepísal. Zachováva CRLF.
 *   --db      (spúšťa sa na serveri) vloží figúru do `articles.content` a
 *             preregeneruje PDF článku.
 *
 * Oba režimy sú IDEMPOTENTNÉ: ak článok už `<figure` obsahuje, preskočia ho.
 *
 * Použitie:
 *   php article_illustration.php --local --manifest=tmp/ilu.json
 *   php article_illustration.php --db    --manifest=tmp/ilu.json
 *
 * Beží len z CLI. Vracia 0 pri úspechu, 1 ak niektorá položka zlyhala.
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit("Len CLI.\n");
}

$root = __DIR__;

// ── Argumenty ────────────────────────────────────────────────────────────────
$mode = null;
$manifestPath = null;
$arguments = isset($_SERVER['argv']) && is_array($_SERVER['argv']) ? $_SERVER['argv'] : [];
foreach (array_slice($arguments, 1) as $arg) {
    if ($arg === '--local' || $arg === '--db') {
        $mode = substr($arg, 2);
    } elseif (str_starts_with($arg, '--manifest=')) {
        $manifestPath = substr($arg, 11);
    }
}

if ($mode === null || $manifestPath === null) {
    fwrite(STDERR, "Použitie: php article_illustration.php --local|--db --manifest=<cesta.json>\n");
    exit(1);
}

if (!is_file($manifestPath)) {
    fwrite(STDERR, "CHYBA: manifest neexistuje: {$manifestPath}\n");
    exit(1);
}

$items = json_decode((string) file_get_contents($manifestPath), true);
if (!is_array($items)) {
    fwrite(STDERR, "CHYBA: manifest nie je platné JSON pole.\n");
    exit(1);
}

/**
 * Zostaví HTML figúry. Jediné miesto, kde sa definuje — oba režimy ho zdieľajú.
 *
 * @param array{img: string, alt: string, caption: string} $item
 */
function illustrationFigureHtml(array $item): string
{
    $img = htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8');
    $alt = htmlspecialchars($item['alt'], ENT_QUOTES, 'UTF-8');
    $caption = $item['caption']; // môže obsahovať povolené inline značky

    return '<figure><a href="img/' . $img . '.webp" rel="noopener noreferrer" target="_blank">'
        . '<img src="img/' . $img . '.webp" alt="' . $alt . '"'
        . ' width="1600" height="1000" loading="lazy" decoding="async"></a>'
        . '<figcaption>' . $caption . '</figcaption></figure>';
}

$ok = 0;
$skipped = 0;
$failed = 0;

// ── Režim --local: uprav zdrojové add_<slug>_article.php ─────────────────────
if ($mode === 'local') {
    // Index slug → súbor. Slug je v šablóne ako  'slug'         => '<slug>',
    $index = [];
    foreach (glob($root . '/add_*_article.php') ?: [] as $file) {
        $src = (string) file_get_contents($file);
        if (preg_match_all("/'slug'\s*=>\s*'([^']+)'/", $src, $m)) {
            foreach ($m[1] as $slug) {
                $index[$slug] = $file;
            }
        }
    }

    foreach ($items as $item) {
        $slug = (string) ($item['slug'] ?? '');
        if (!isset($index[$slug])) {
            // Článok bez zdrojového skriptu — rieši ho len režim --db.
            echo "  – {$slug}: bez zdrojového skriptu (len DB)\n";
            $skipped++;
            continue;
        }

        $file = $index[$slug];
        $src = (string) file_get_contents($file);

        if (str_contains($src, 'img/' . $item['img'] . '.webp')) {
            echo "  = {$slug}: obrázok už vložený\n";
            $skipped++;
            continue;
        }

        // Niektore skripty maju zmiesane konce riadkov, preto skus oba varianty.
        $base = "'content'      => <<<'HTML'";
        $eol = "\r\n";
        $anchor = $base . $eol;
        $pos = strpos($src, $anchor);
        if ($pos === false) {
            $eol = "\n";
            $anchor = $base . $eol;
            $pos = strpos($src, $anchor);
        }
        if ($pos === false) {
            fwrite(STDERR, "  ✗ {$slug}: kotva 'content' => <<<'HTML' nenájdená v " . basename($file) . "\n");
            $failed++;
            continue;
        }

        $fig = illustrationFigureHtml($item) . $eol . $eol;
        $insertAt = $pos + strlen($anchor);
        $src = substr($src, 0, $insertAt) . $fig . substr($src, $insertAt);
        file_put_contents($file, $src);
        echo "  ✓ {$slug}: " . basename($file) . "\n";
        $ok++;
    }
} else {
    // ── Režim --db: uprav articles.content a preregeneruj PDF ────────────────
    require_once $root . '/db_config.php';
    require_once $root . '/pdf_generator.php';
    /** @var PDO $pdo */

    $sel = $pdo->prepare('SELECT id, title, content FROM articles WHERE slug = :slug');
    $upd = $pdo->prepare('UPDATE articles SET content = :content WHERE id = :id');

    foreach ($items as $item) {
        $slug = (string) ($item['slug'] ?? '');
        $sel->execute(['slug' => $slug]);
        $row = $sel->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            fwrite(STDERR, "  ✗ {$slug}: článok nenájdený\n");
            $failed++;
            continue;
        }

        $content = (string) $row['content'];
        if (str_contains($content, 'img/' . $item['img'] . '.webp')) {
            echo "  = {$slug}: obrázok už vložený\n";
            $skipped++;
            continue;
        }

        $content = illustrationFigureHtml($item) . "\n\n" . $content;
        $upd->execute(['content' => $content, 'id' => (int) $row['id']]);

        try {
            $res = generateArticlePdf($pdo, [
                'id' => (int) $row['id'],
                'slug' => $slug,
                'title' => (string) $row['title'],
                'content' => $content,
            ], true);
            if (!$res['ok'] && !empty($res['error'])) {
                fwrite(STDERR, "  ! {$slug}: PDF: {$res['error']}\n");
            }
        } catch (Throwable $e) {
            fwrite(STDERR, "  ! {$slug}: PDF: " . $e->getMessage() . "\n");
        }

        echo "  ✓ {$slug}\n";
        $ok++;
    }
}

echo str_repeat('─', 74) . "\n";
echo "Režim {$mode}: spracovaných {$ok}, preskočených {$skipped}, zlyhaní {$failed}.\n";
exit($failed > 0 ? 1 : 0);
