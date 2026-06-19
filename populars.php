<?php
declare(strict_types=1);
/**
 * populars.php — Sekcia „Pre pacientov"
 * ────────────────────────────────────────────────────────────────────────────
 * Zoznam popularizačných článkov (category = 'popularne') pre poučených
 * pacientov a verejnosť. Jednoduchý jazyk, obrázky, žiadny odborný žargón.
 * Články sa renderujú cez article.php (spoločná infraštruktúra).
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

function popFormatDate(string $datetime, array $months): string
{
    $ts = strtotime($datetime);
    if (!$ts) {
        return htmlspecialchars($datetime);
    }
    return (int) date("j", $ts) . ". " . ($months[(int) date("n", $ts)] ?? "") . " " . date("Y", $ts);
}

function popExcerpt(string $text, int $maxLen = 200): string
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

/** Vyberie URL prvého <img> z HTML obsahu článku (pre náhľad karty). */
function popFirstImage(string $html): string
{
    if (preg_match('/<img[^>]+src\s*=\s*["\']([^"\']+)["\']/i', $html, $m)) {
        return trim($m[1]);
    }
    return "";
}

// ── Stránkovanie ─────────────────────────────────────────────────────────────
$perPage = 9;
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($page < 1) {
    $page = 1;
}

$articles = [];
$total = 0;
$totalPages = 1;

try {
    $cntStmt = $pdo->query(
        "SELECT COUNT(*) FROM articles WHERE is_published = 1 AND category = 'popularne'"
    );
    $total = (int) $cntStmt->fetchColumn();
    $totalPages = max(1, (int) ceil($total / $perPage));
    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    $stmt = $pdo->prepare(
        "SELECT id, title, slug, author, content, excerpt, published_at, is_top
         FROM articles
         WHERE is_published = 1 AND category = 'popularne'
         ORDER BY is_top DESC, sort_order ASC, published_at DESC
         LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue(":limit", $perPage, \PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, \PDO::PARAM_INT);
    $stmt->execute();
    $articles = $stmt->fetchAll();
} catch (\PDOException $e) {
    error_log("populars.php – chyba pri načítaní článkov: " . $e->getMessage());
}

// ── SEO ──────────────────────────────────────────────────────────────────────
$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$schemaOrgUrl = "https://schema.org";
$isPaginated = $page > 1;

$pageTitle = ($isPaginated ? "Pre pacientov – strana " . $page . " | " : "Pre pacientov – zrozumiteľne o obličkách | ") . $siteName;
$seoDescription = "Popularizačné články o obličkách, ich ochoreniach a liečbe — jednoduchým jazykom, s obrázkami, pre poučených pacientov a verejnosť.";
$seoKeywords = "obličky, chronické ochorenie obličiek, dialýza, pre pacientov, zrozumiteľne, zdravie obličiek, prevencia, edukácia pacientov";
$canonicalUrl = $baseUrl . "populars.php" . ($isPaginated ? "?page=" . $page : "");
$robotsMeta = "index, follow, max-image-preview:large";
$ogType = "website";

$structuredData = [
    [
        "@context" => $schemaOrgUrl,
        "@type" => "CollectionPage",
        "name" => "Pre pacientov – popularizačné články",
        "description" => $seoDescription,
        "url" => $canonicalUrl,
        "inLanguage" => "sk-SK",
        "audience" => [
            "@type" => "MedicalAudience",
            "audienceType" => "Patient",
        ],
    ],
    [
        "@context" => $schemaOrgUrl,
        "@type" => "BreadcrumbList",
        "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Domov", "item" => $baseUrl],
            ["@type" => "ListItem", "position" => 2, "name" => "Pre pacientov", "item" => $baseUrl . "populars.php"],
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
        "name" => $isPaginated ? "Pre pacientov – strana " . $page : "Pre pacientov",
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
  $headerTitle = "Nefro-projekt Slovensko";
  $headerIntro = "Zrozumiteľne o obličkách — pre poučených pacientov a verejnosť.";
  $showLogo = true;
  include_once "header.php";
  ?>

  <?php include_once 'main_nav.php'; ?>

  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper content-wrapper--full">

      <section class="populars-intro" aria-labelledby="populars-heading">
        <h1 id="populars-heading" class="section-heading">Pre pacientov</h1>
        <p class="populars-lead">
          Zrozumiteľné články o obličkách, ich ochoreniach, vyšetreniach a liečbe —
          písané jednoduchým jazykom, s obrázkami, pre poučených pacientov a širokú
          verejnosť. Bez odborného žargónu, s dôrazom na to podstatné.
        </p>
      </section>

      <?php if (empty($articles)): ?>
        <section class="populars-empty">
          <div class="primary-article">
            <p>Zatiaľ tu nie sú žiadne články. Čoskoro pribudnú prvé popularizačné príspevky — vráťte sa, prosím, neskôr.</p>
            <p>
              Medzitým si môžete prečítať <a href="index.php">odborné články</a>
              alebo využiť <a href="calculators.php">nefrologické kalkulačky</a>.
            </p>
          </div>
        </section>
      <?php else: ?>
        <section class="populars-grid-section" aria-label="Zoznam článkov pre pacientov">
          <ul class="populars-grid">
            <?php foreach ($articles as $art):
                $artSlug = htmlspecialchars((string) $art["slug"], ENT_QUOTES);
                $artTitle = htmlspecialchars((string) $art["title"]);
                $artExc = htmlspecialchars(popExcerpt((string) ($art["excerpt"] ?? ($art["content"] ?? "")), 200));
                $artDate = htmlspecialchars(popFormatDate((string) $art["published_at"], $months));
                $artDateIso = htmlspecialchars(substr((string) $art["published_at"], 0, 10));
                $artImg = popFirstImage((string) ($art["content"] ?? ""));
                $artIsTop = !empty($art["is_top"]);
                ?>
            <li class="popular-card">
              <a href="article.php?slug=<?= $artSlug ?>" class="popular-card__link" aria-label="Čítať článok: <?= $artTitle ?>">
                <div class="popular-card__media">
                  <?php if ($artImg !== ""): ?>
                    <img src="<?= htmlspecialchars($artImg, ENT_QUOTES) ?>" alt="" loading="lazy" decoding="async" class="popular-card__img">
                  <?php else: ?>
                    <span class="popular-card__placeholder" aria-hidden="true">🩺</span>
                  <?php endif; ?>
                  <?php if ($artIsTop): ?><span class="popular-card__badge">★ Odporúčané</span><?php endif; ?>
                </div>
                <div class="popular-card__body">
                  <h2 class="popular-card__title"><?= $artTitle ?></h2>
                  <p class="popular-card__excerpt"><?= $artExc ?></p>
                  <div class="popular-card__footer">
                    <time class="popular-card__date" datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
                    <span class="popular-card__more">Čítať ďalej &rarr;</span>
                  </div>
                </div>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>

          <?php if ($totalPages > 1): ?>
            <nav class="articles-pagination" aria-label="Stránkovanie článkov pre pacientov">
              <span class="articles-pagination__label">Stránky:</span>
              <div class="articles-pagination__links">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                  <?php if ($p === $page): ?>
                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                  <?php else: ?>
                    <a class="articles-page-link" href="?page=<?= $p ?>#populars-heading" aria-label="Strana <?= $p ?>"><?= $p ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </nav>
          <?php endif; ?>
        </section>
      <?php endif; ?>

      <div class="newsletter-cta-inline" id="nl-cta-inline">
        <div class="newsletter-cta__inner">
          <h3 class="newsletter-cta__title">Nové články pre pacientov priamo do e-mailu</h3>
          <p class="newsletter-cta__desc">Bezplatný odber. Odhlásite sa kedykoľvek jedným klikom.</p>
          <form class="newsletter-cta__form" id="nl-form-inline" novalidate>
            <div class="honeypot" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
            <input type="email" name="email" placeholder="váš@email.sk" class="form-control newsletter-cta__input" required aria-label="Vaša e-mailová adresa">
            <button type="submit" class="btn-primary newsletter-cta__btn">Prihlásiť na odber</button>
          </form>
          <output class="newsletter-cta__msg" id="nl-msg-inline" hidden aria-live="polite"></output>
        </div>
      </div>

    </div>
  </main>

  <script src="newsletter-cta.js?v=<?= filemtime(__DIR__ . '/newsletter-cta.js') ?>" defer></script>
  <?php include_once "footer.php"; ?>
</body>
</html>
