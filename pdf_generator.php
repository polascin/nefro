<?php

declare(strict_types=1);
/**
 * pdf_generator.php
 * ────────────────────────────────────────────────────────────────────────────
 * Generovanie PDF verzie článku z jeho HTML obsahu pomocou wkhtmltopdf.
 * PDF sa ukladá do /pdf/<slug>.pdf a (voliteľne) sa nastaví articles.pdf_file.
 *
 * Knižnica — vkladá sa cez require. Priame volanie cez web je zakázané.
 * Vyžaduje wkhtmltopdf v PATH (na produkčnom serveri je dostupné).
 */

if (basename($_SERVER['PHP_SELF'] ?? '') === basename(__FILE__)) {
    http_response_code(403);
    exit('Prístup odmietnutý.');
}

/**
 * Nájde binárku wkhtmltopdf (cache v statickej premennej).
 */
function wkhtmltopdfBin(): string
{
    static $bin = null;
    if ($bin === null) {
        $bin = trim((string) @shell_exec('command -v wkhtmltopdf 2>/dev/null'));
        if ($bin === '') {
            // Windows fallback: `where` returns one path per line.
            $win = trim((string) @shell_exec('where wkhtmltopdf 2>NUL'));
            if ($win !== '') {
                $parts = preg_split('/\r\n|\r|\n/', $win);
                $bin = trim((string) ($parts[0] ?? ''));
            }
        }
        if ($bin === '') {
            $candidates = [
                'C:/Program Files/wkhtmltopdf/bin/wkhtmltopdf.exe',
                'C:/Program Files (x86)/wkhtmltopdf/bin/wkhtmltopdf.exe',
            ];
            foreach ($candidates as $candidate) {
                if (is_file($candidate)) {
                    $bin = $candidate;
                    break;
                }
            }
        }
    }
    return $bin;
}

/**
 * Je generovanie PDF na tomto prostredí dostupné?
 */
function articlePdfAvailable(): bool
{
    return wkhtmltopdfBin() !== '' && function_exists('shell_exec');
}

/**
 * Z PDF vstupu odstráni aktívny obsah a všetky zdroje okrem existujúcich
 * obrázkov v lokálnom /img. Generátor tak nemôže čítať konfiguráciu ani robiť
 * HTTP požiadavky podľa HTML uloženého administrátorom.
 */
function sanitizeArticlePdfContent(string $content): string
{
    if (!class_exists('DOMDocument')) {
        return '<p>' . nl2br(htmlspecialchars(strip_tags($content), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . '</p>';
    }

    $document = new DOMDocument('1.0', 'UTF-8');
    $previous = libxml_use_internal_errors(true);
    $loaded = $document->loadHTML(
        '<?xml encoding="UTF-8"><div id="nps-pdf-content">' . $content . '</div>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
    );
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    if (!$loaded) {
        return '<p>' . nl2br(htmlspecialchars(strip_tags($content), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . '</p>';
    }

    $xpath = new DOMXPath($document);
    foreach ($xpath->query('//script|//style|//iframe|//object|//embed|//link|//base|//meta|//svg|//form|//input|//button|//textarea|//select') ?: [] as $node) {
        $node->parentNode?->removeChild($node);
    }

    $imgRoot = realpath(__DIR__ . '/img');
    foreach ($xpath->query('//*') ?: [] as $element) {
        if (!$element instanceof DOMElement) {
            continue;
        }
        $attributeNames = [];
        foreach ($element->attributes as $attribute) {
            $attributeNames[] = $attribute->name;
        }
        foreach ($attributeNames as $name) {
            $lower = strtolower($name);
            if (str_starts_with($lower, 'on') || in_array($lower, [
                'style', 'srcset', 'poster', 'background', 'data', 'formaction', 'xlink:href',
            ], true)) {
                $element->removeAttribute($name);
            }
        }

        if (strtolower($element->tagName) === 'img') {
            $src = rawurldecode(trim($element->getAttribute('src')));
            $safeShape = preg_match('#^img/[A-Za-z0-9._/-]+\.(?:png|jpe?g|gif|webp|svg)$#iD', $src) === 1
                && !str_contains($src, '..')
                && !str_contains($src, '\\');
            $candidate = $safeShape ? realpath(__DIR__ . '/' . $src) : false;
            $safePath = $imgRoot !== false
                && $candidate !== false
                && str_starts_with($candidate, $imgRoot . DIRECTORY_SEPARATOR)
                && is_file($candidate);
            if (!$safePath) {
                $element->removeAttribute('src');
            } else {
                $element->setAttribute('src', $src);
            }
        } elseif ($element->hasAttribute('src')) {
            $element->removeAttribute('src');
        }

        if ($element->hasAttribute('href')) {
            $href = trim($element->getAttribute('href'));
            if (preg_match('#^https?://#i', $href) !== 1 && preg_match('~^[A-Za-z0-9_./?&=%#-]+$~D', $href) !== 1) {
                $element->removeAttribute('href');
            }
        }
    }

    $wrapper = $document->getElementById('nps-pdf-content');
    if (!$wrapper) {
        return '';
    }
    $safe = '';
    foreach ($wrapper->childNodes as $child) {
        $safe .= $document->saveHTML($child);
    }
    return $safe;
}

/**
 * Zostaví tlačové HTML článku pre wkhtmltopdf.
 * Obrázky sa načítavajú lokálne cez <base href="file://…"> (rýchle, bez siete).
 */
function buildArticlePdfHtml(array $article): string
{
    $title  = htmlspecialchars((string) ($article['title'] ?? ''), ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars((string) ($article['author'] ?? 'MUDr. Ľubomír Polaščín'), ENT_QUOTES, 'UTF-8');
    $slug   = htmlspecialchars((string) ($article['slug'] ?? ''), ENT_QUOTES, 'UTF-8');
    $content = sanitizeArticlePdfContent((string) ($article['content'] ?? ''));
    // wkhtmltopdf 0.12.6 (staré WebKit) nevykreslí WebP — v PDF použi PNG variant obrázka.
    $content = preg_replace('/((?:src|srcset)="[^"]*?)\.webp"/i', '$1.png"', $content) ?? $content;

    $dateRaw = (string) ($article['published_at'] ?? '');
    $date = $dateRaw !== '' ? date('d.m.Y', strtotime($dateRaw)) : '';

    // Lokálny základ pre relatívne obrázky (img/…). Koniec lomkou je nutný.
    $base = 'file://' . str_replace('\\', '/', __DIR__) . '/';
    $baseAttr = htmlspecialchars($base, ENT_QUOTES, 'UTF-8');

    $metaParts = [];
    if ($author !== '') { $metaParts[] = 'Autor: ' . $author; }
    if ($date !== '')   { $metaParts[] = 'Publikované: ' . $date; }
    $meta = implode(' &middot; ', $metaParts);

    return <<<HTML
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="utf-8">
<base href="{$baseAttr}">
<style>
  body { font-family: "DejaVu Sans", Arial, sans-serif; font-size: 11pt; line-height: 1.55; color: #1a1a1a; margin: 0; }
  .pdf-header { border-bottom: 3px solid #2563eb; padding-bottom: 10px; margin-bottom: 18px; }
  .pdf-site { color: #2563eb; font-weight: bold; font-size: 9.5pt; letter-spacing: 0.6px; text-transform: uppercase; }
  h1 { font-size: 19pt; line-height: 1.25; margin: 6px 0 6px; color: #0f172a; }
  .pdf-meta { color: #64748b; font-size: 9.5pt; }
  h2 { font-size: 14pt; color: #1e40af; margin: 20px 0 6px; }
  h3 { font-size: 12pt; color: #1e3a8a; margin: 14px 0 4px; }
  p { margin: 8px 0; }
  ul, ol { margin: 8px 0 14px 20px; }
  li { margin: 4px 0; page-break-inside: avoid; break-inside: avoid; }
  dl { margin: 8px 0 14px; }
  dt { font-weight: bold; margin-bottom: 3px; }
  dd { margin: 0 0 8px 18px; }
  img { max-width: 100%; height: auto; }
  figure { margin: 14px 0; text-align: center; }
  figure img { border: 1px solid #e2e8f0; border-radius: 6px; }
  figcaption { font-size: 9pt; color: #64748b; margin-top: 5px; }
  a { color: #2563eb; text-decoration: none; word-break: break-word; }
  strong { color: #0f172a; }
  hr { border: none; border-top: 1px solid #e2e8f0; margin: 16px 0; }
  .article-dek { color: #475569; font-style: italic; }
  .info-box-blue, .info-box-yellow, .info-box-green, .info-box-gray {
    border-left: 4px solid #2563eb; background: #eff6ff; padding: 9px 13px; margin: 13px 0; border-radius: 4px;
  }
  .info-box-yellow { border-color: #d97706; background: #fffbeb; }
  .info-box-green  { border-color: #16a34a; background: #f0fdf4; }
  .info-box-gray   { border-color: #94a3b8; background: #f8fafc; }
  .pdf-footer-note {
    margin-top: 8px;
    padding-top: 5px;
    border-top: 1px solid #e2e8f0;
    color: #94a3b8;
    font-size: 7.5pt;
    line-height: 1.35;
    page-break-inside: avoid;
    break-inside: avoid;
  }
  .pdf-page-break { page-break-before: always; break-before: page; height: 0; margin: 0; padding: 0; }
  .pdf-avoid-break { page-break-inside: avoid; break-inside: avoid; }
  .pdf-keep-together { display: block; page-break-inside: avoid; break-inside: avoid; }
  table { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 10pt; }
  th { text-align: left; padding: 7px 9px; border-bottom: 2px solid #cbd5e1; background: #f1f5f9; }
  td { padding: 7px 9px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
</style>
</head>
<body>
  <div class="pdf-header">
    <div class="pdf-site">Nefro &middot; nefro.polascin.net</div>
    <h1>{$title}</h1>
    <div class="pdf-meta">{$meta}</div>
  </div>
  {$content}
  <div class="pdf-footer-note">
    Zdroj: https://nefro.polascin.net/article.php?slug={$slug} &middot; Nefro-projekt Slovensko.
    Obsah má informačný a vzdelávací charakter a nenahrádza konzultáciu s lekárom.
  </div>
</body>
</html>
HTML;
}

/**
 * Slugy s ručne pripravenými PDF (kurátorovaný dizajn s AI ilustráciami), ktoré
 * sa NESMÚ automaticky prepísať. Pregeneruj ich len explicitne ($allowProtected=true).
 */
const PROTECTED_PDF_SLUGS = [
    'diabeticka-choroba-obliciek-bez-zahad',
    'moderne-trendy-v-nefroprotekcii',
    'obezita-a-oblicky',
    'zivot-s-diabetom-a-nefropatiou',
];

function articlePdfIsProtected(string $slug): bool
{
    return in_array($slug, PROTECTED_PDF_SLUGS, true);
}

/**
 * Vygeneruje PDF pre článok. Vráti ['ok'=>bool, 'file'=>?string, 'error'=>?string, 'skipped'=>bool].
 *
 * @param array $article        riadok z tabuľky articles (id, slug, title, author, content, published_at)
 * @param bool  $updateDb       ak true, nastaví articles.pdf_file na názov súboru
 * @param bool  $allowProtected ak true, prepíše aj chránené (ručné) PDF
 */
function generateArticlePdf(PDO $pdo, array $article, bool $updateDb = true, bool $allowProtected = false): array
{
    if (!articlePdfAvailable()) {
        return ['ok' => false, 'file' => null, 'error' => 'wkhtmltopdf nie je dostupné v tomto prostredí'];
    }

    $slug = preg_replace('/[^a-z0-9-]/', '', (string) ($article['slug'] ?? ''));
    if ($slug === '') {
        return ['ok' => false, 'file' => null, 'error' => 'neplatný slug'];
    }

    // Chránené (ručne pripravené) PDF sa automaticky neprepisujú.
    if (!$allowProtected && articlePdfIsProtected($slug)) {
        return ['ok' => true, 'file' => (string) ($article['pdf_file'] ?? ($slug . '.pdf')), 'error' => null, 'skipped' => true];
    }

    $pdfDir = __DIR__ . '/pdf';
    if (!is_dir($pdfDir) && !@mkdir($pdfDir, 0775, true) && !is_dir($pdfDir)) {
        return ['ok' => false, 'file' => null, 'error' => 'priečinok /pdf sa nedá vytvoriť'];
    }

    $outFile = $slug . '.pdf';
    $outPath = $pdfDir . '/' . $outFile;

    $html = buildArticlePdfHtml($article);
    $tmp = tempnam(sys_get_temp_dir(), 'artpdf_');
    if ($tmp === false) {
        return ['ok' => false, 'file' => null, 'error' => 'dočasný súbor sa nedá vytvoriť'];
    }
    $tmpHtml = $tmp . '.html';
    file_put_contents($tmpHtml, $html);
    @unlink($tmp);

    $allowedImages = realpath(__DIR__ . '/img');
    if ($allowedImages === false) {
        @unlink($tmpHtml);
        return ['ok' => false, 'file' => null, 'error' => 'priečinok povolených PDF obrázkov nie je dostupný'];
    }

    $cmd = escapeshellarg(wkhtmltopdfBin())
        . ' --disable-javascript --disable-local-file-access --allow ' . escapeshellarg($allowedImages)
        . ' --encoding utf-8 --image-quality 88'
        . ' --margin-top 16 --margin-bottom 16 --margin-left 15 --margin-right 15'
        . ' --footer-center ' . escapeshellarg('[page] / [topage]')
        . ' --footer-font-size 8 --footer-font-name ' . escapeshellarg('DejaVu Sans') . ' --footer-spacing 5'
        . ' --quiet ' . escapeshellarg($tmpHtml) . ' ' . escapeshellarg($outPath) . ' 2>&1';

    $res = @shell_exec($cmd);
    @unlink($tmpHtml);

    if (!is_file($outPath) || filesize($outPath) < 1000) {
        return ['ok' => false, 'file' => null, 'error' => 'wkhtmltopdf zlyhalo: ' . trim((string) $res)];
    }

    if ($updateDb && isset($article['id'])) {
        try {
            $u = $pdo->prepare('UPDATE articles SET pdf_file = :f WHERE id = :id');
            $u->execute(['f' => $outFile, 'id' => (int) $article['id']]);
        } catch (\PDOException $e) {
            return ['ok' => true, 'file' => $outFile, 'error' => 'PDF vytvorené, ale DB sa nepodarilo aktualizovať: ' . $e->getMessage()];
        }
    }

    // Zarovnaj mtime PDF tesne ZA updated_at článku (epoch z DB hodín, bez TZ posunu),
    // aby --stale práve vygenerované PDF nepovažoval za neaktuálne (UPDATE pdf_file
    // bumpne updated_at až po zápise súboru).
    if (isset($article['id'])) {
        try {
            $ts = $pdo->prepare('SELECT UNIX_TIMESTAMP(updated_at) FROM articles WHERE id = :id');
            $ts->execute(['id' => (int) $article['id']]);
            $u = (int) $ts->fetchColumn();
            if ($u > 0) {
                @touch($outPath, $u + 1);
            }
        } catch (\Throwable $e) {
            // zarovnanie je best-effort
        }
    }

    return ['ok' => true, 'file' => $outFile, 'error' => null];
}
