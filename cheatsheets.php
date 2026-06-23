<?php
declare(strict_types=1);
/**
 * cheatsheets.php — Sekcia „Ťaháky"
 * ────────────────────────────────────────────────────────────────────────────
 * Zoznam tlačiteľných ťahákov (category = 'cheatsheet') —
 * rýchle prehľady pre klinickú prax (acidobáza, elektrolyty, diuretiká,
 * infúzne roztoky a ďalšie). Renderujú sa cez article.php (spoločná
 * infraštruktúra vrátane automatického PDF pipeline na stiahnutie/tlač).
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

// ── Pomocné funkcie ──────────────────────────────────────────────────────────
$months = [
    1 => "januára", 2 => "februára", 3 => "marca", 4 => "apríla",
    5 => "mája", 6 => "júna", 7 => "júla", 8 => "augusta",
    9 => "septembra", 10 => "októbra", 11 => "novembra", 12 => "decembra",
];

function csFormatDate(string $datetime, array $months): string
{
    $ts = strtotime($datetime);
    if (!$ts) {
        return htmlspecialchars($datetime);
    }
    return (int) date("j", $ts) . ". " . ($months[(int) date("n", $ts)] ?? "") . " " . date("Y", $ts);
}

function csExcerpt(string $text, int $maxLen = 200): string
{
    $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, "UTF-8");
    $plain = trim(preg_replace("/\s+/u", " ", strip_tags($decoded)) ?? "");
    if ($plain === "") {
        return "";
    }
    if (mb_strlen($plain) <= $maxLen) {
        return $plain;
    }
    $slice = mb_substr($plain, 0, $maxLen + 1);
    $slice = preg_replace('/\s+\S*$/u', "", $slice) ?? $slice;
    return rtrim($slice, " \t\n\r\0\x0B,.;:-") . "…";
}

/** Vyberie URL prvého <img> z HTML obsahu ťaháka (ilustrácia pre náhľad karty). */
function csFirstImage(string $html): string
{
    if (preg_match('/<img[^>]+src\s*=\s*["\']([^"\']+)["\']/i', $html, $m)) {
        return trim($m[1]);
    }
    return "";
}

// ── Načítanie ťahákov ────────────────────────────────────────────────────────
$articles = [];

try {
    $stmt = $pdo->query(
        "SELECT id, title, slug, author, content, excerpt, published_at, is_top
         FROM articles
         WHERE is_published = 1 AND category = 'cheatsheet'
         ORDER BY is_top DESC, sort_order ASC, title ASC"
    );
    $articles = $stmt->fetchAll();
} catch (\PDOException $e) {
    error_log("cheatsheets.php – chyba pri načítaní ťahákov: " . $e->getMessage());
}

// ── SEO ──────────────────────────────────────────────────────────────────────
$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$schemaOrgUrl = "https://schema.org";

$pageTitle = "Ťaháky | " . $siteName;
$seoDescription = "Tlačiteľné ťaháky pre nefrológiu a internú medicínu — acidobáza, elektrolyty, diuretiká, infúzne roztoky a ďalšie. Rýchly prehľad k dispozícii aj ako PDF na stiahnutie a tlač.";
$seoKeywords = "ťahák, cheat sheet, rýchla referencia, acidobáza, elektrolyty, diuretiká, infúzne roztoky, nefrológia, tlačiteľná pomôcka, Slovensko";
$canonicalUrl = $baseUrl . "cheatsheets.php";
$robotsMeta = "index, follow, max-image-preview:large";
$ogType = "website";

$structuredData = [
    [
        "@context" => $schemaOrgUrl,
        "@type" => "CollectionPage",
        "name" => "Ťaháky",
        "description" => $seoDescription,
        "url" => $canonicalUrl,
        "inLanguage" => "sk-SK",
        "audience" => [
            "@type" => "MedicalAudience",
            "audienceType" => "Clinician",
        ],
    ],
    [
        "@context" => $schemaOrgUrl,
        "@type" => "BreadcrumbList",
        "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Domov", "item" => $baseUrl],
            ["@type" => "ListItem", "position" => 2, "name" => "Ťaháky", "item" => $canonicalUrl],
        ],
    ],
];

$itemListElements = [];
foreach ($articles as $i => $art) {
    $itemListElements[] = [
        "@type" => "ListItem",
        "position" => $i + 1,
        "url" => $baseUrl . "article.php?slug=" . rawurlencode((string) $art["slug"]),
        "name" => (string) $art["title"],
    ];
}
if (!empty($itemListElements)) {
    $structuredData[] = [
        "@context" => $schemaOrgUrl,
        "@type" => "ItemList",
        "name" => "Ťaháky",
        "itemListElement" => $itemListElements,
    ];
}
?>
<!DOCTYPE html>
<html lang="sk">

<head>
  <?php include_once "head_meta.php"; ?>
</head>

<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <?php
  $headerTitle = "Ťaháky";
  $headerIntro = "Tlačiteľné ťaháky pre klinickú prax.";
  $showLogo = true;
  include_once "header.php";
  ?>

  <?php include_once 'main_nav.php'; ?>

  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper content-wrapper--full">

      <section class="populars-intro" aria-labelledby="cheatsheets-heading">
        <h1 id="cheatsheets-heading" class="section-heading">Ťaháky</h1>
        <p class="populars-lead">
          Stručné, tlačiteľné prehľady pre klinickú prax — kľúčové čísla,
          klasifikácie a postupy na jednom mieste. Každý ťahák si možno vytlačiť
          priamo z prehliadača alebo stiahnuť ako PDF (pre prihlásených).
          Sú orientačnou pomôckou a <strong>nenahrádzajú</strong> klinický úsudok.
        </p>
      </section>

      <?php if (empty($articles)): ?>
        <section class="populars-empty">
          <div class="primary-article">
            <p>Zatiaľ tu nie sú žiadne ťaháky. Čoskoro pribudnú prvé — vráťte sa, prosím, neskôr.</p>
            <p>
              Medzitým si môžete pozrieť <a href="calculators.php">nefrologické kalkulačky</a>
              alebo <a href="nastroje.php">interaktívne nástroje</a>.
            </p>
          </div>
        </section>
      <?php else: ?>
        <section class="populars-grid-section" aria-label="Zoznam ťahákov">
          <ul class="populars-grid">
            <?php foreach ($articles as $art):
                $artSlug = htmlspecialchars((string) $art["slug"], ENT_QUOTES);
                $artTitle = htmlspecialchars((string) $art["title"]);
                $artExc = htmlspecialchars(csExcerpt((string) ($art["excerpt"] ?? ($art["content"] ?? "")), 200));
                $artDate = htmlspecialchars(csFormatDate((string) $art["published_at"], $months));
                $artDateIso = htmlspecialchars(substr((string) $art["published_at"], 0, 10));
                $artIsTop = !empty($art["is_top"]);
                $artImg = csFirstImage((string) ($art["content"] ?? ""));
                ?>
            <li class="popular-card">
              <a href="article.php?slug=<?= $artSlug ?>" class="popular-card__link" aria-label="Otvoriť ťahák: <?= $artTitle ?>">
                <div class="popular-card__media">
                  <?php if ($artImg !== ""): ?>
                    <img src="<?= htmlspecialchars($artImg, ENT_QUOTES) ?>" alt="" loading="lazy" decoding="async" class="popular-card__img">
                  <?php else: ?>
                    <span class="popular-card__placeholder" aria-hidden="true">📋</span>
                  <?php endif; ?>
                  <?php if ($artIsTop): ?><span class="popular-card__badge">★ Odporúčané</span><?php endif; ?>
                </div>
                <div class="popular-card__body">
                  <h2 class="popular-card__title"><?= $artTitle ?></h2>
                  <p class="popular-card__excerpt"><?= $artExc ?></p>
                  <div class="popular-card__footer">
                    <time class="popular-card__date" datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
                    <span class="popular-card__more">Otvoriť &rarr;</span>
                  </div>
                </div>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endif; ?>

    </div>
  </main>

  <?php include_once "footer.php"; ?>
</body>
</html>
