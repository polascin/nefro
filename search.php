<?php
declare(strict_types=1);
/**
 * search.php — Komplexné hĺbkové vyhľadávanie v článkoch
 * Funkcie: FULLTEXT + LIKE, slovenské diakritiky, stop slová,
 *          relevančné skórovanie, zvýraznenie výrazov, snippety, stránkovanie.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

require_once __DIR__ . '/search_helpers.php';

// ── Spracovanie vstupu ────────────────────────────────────────────────────────

$rawQuery = trim((string) ($_GET["s"] ?? ""));
$page = max(1, (int) ($_GET["page"] ?? 1));

// Sanitácia: max 200 znakov
if (mb_strlen($rawQuery, "UTF-8") > 200) {
    $rawQuery = mb_substr($rawQuery, 0, 200, "UTF-8");
}

$tokens = []; // ['normalized' => 'original']
$results = [];
$totalItems = 0;
$totalPages = 1;
$strategy = "none";
$searchTime = 0.0;
$hasQuery = $rawQuery !== "";

if ($hasQuery) {
    $tokens = searchTokenize($rawQuery);

    if (!empty($tokens)) {
        $t0 = microtime(true);
        $sr = doArticleSearch($pdo, $tokens, $page, SEARCH_PER_PAGE);
        $searchTime = round((microtime(true) - $t0) * 1000, 1); // ms

        $results = $sr["items"];
        $totalItems = $sr["total"];
        $strategy = $sr["strategy"];
        $totalPages = max(1, (int) ceil($totalItems / SEARCH_PER_PAGE));

        if ($page > $totalPages) {
            $page = $totalPages;
            $sr = doArticleSearch($pdo, $tokens, $page, SEARCH_PER_PAGE);
            $results = $sr["items"];
        }
    }
}

// ── SEO meta ─────────────────────────────────────────────────────────────────

$baseUrl = "https://nefro.polascin.net/";
$siteName = "Nefro-projekt Slovensko";
$searchQueryPrefix = "search.php?s=";
$pageQuerySeparator = "&page=";

$pageTitle = $hasQuery
    ? "Výsledky hľadania: " . $rawQuery . " | " . $siteName
    : "Vyhľadávanie | " . $siteName;

$seoDescription = $hasQuery
    ? "Výsledky vyhľadávania pre: " .
        $rawQuery .
        " — odborné nefrologické články, kalkulačky a analýzy."
    : "Prehľadávajte odborné nefrologické články, kalkulačky CKD, eGFR, KFRE a ďalší obsah portálu Nefro-projekt Slovensko.";

$robotsMeta = "noindex, follow";
$canonicalUrl =
    $baseUrl . "search.php" . ($hasQuery ? "?s=" . urlencode($rawQuery) : "");

$prevUrl = "";
$nextUrl = "";
if ($page > 1) {
    $prevUrl =
        $baseUrl .
    $searchQueryPrefix .
        urlencode($rawQuery) .
    $pageQuerySeparator .
        ($page - 1);
}
if ($page < $totalPages) {
    $nextUrl =
        $baseUrl .
    $searchQueryPrefix .
        urlencode($rawQuery) .
    $pageQuerySeparator .
        ($page + 1);
}

// Pomocná funkcia na formátovanie dátumu
function formatSearchDate(string $datetime): string
{
    $months = [
        1 => "januára",
        2 => "februára",
        3 => "marca",
        4 => "apríla",
        5 => "mája",
        6 => "júna",
        7 => "júla",
        8 => "augusta",
        9 => "septembra",
        10 => "októbra",
        11 => "novembra",
        12 => "decembra",
    ];
    try {
        $dt = new DateTimeImmutable($datetime, new DateTimeZone(date_default_timezone_get() ?: 'Europe/Bratislava'));
        $dt = $dt->setTimezone(new DateTimeZone(getUserTimezone()));
    } catch (\Throwable) {
        return htmlspecialchars($datetime);
    }
    return (int) $dt->format("j") .
        ". " .
        ($months[(int) $dt->format("n")] ?? "") .
        " " .
        $dt->format("Y");
}

$fieldLabels = [
    "title" => "Nadpis",
    "excerpt" => "Perex",
    "content" => "Obsah",
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php include_once "head_meta.php"; ?>
  <?php if ($prevUrl): ?>
  <link rel="prev" href="<?= htmlspecialchars($prevUrl) ?>">
  <?php endif; ?>
  <?php if ($nextUrl): ?>
  <link rel="next" href="<?= htmlspecialchars($nextUrl) ?>">
  <?php endif; ?>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na obsah</a>

  <?php
  $headerTitle = "Nefro-projekt Slovensko";
  $showLogo = false;
  include_once "header.php";
  ?>

  <?php include_once 'main_nav.php'; ?>

  <main id="main-content" class="container search-main" role="main">
    <div class="main-content main-content--single-col">
      <div class="primary-article">

        <!-- ── Nadpis stránky ──────────────────────────────────────── -->
        <h2 class="search-title">
          <?php if ($hasQuery): ?>
            Výsledky hľadania
          <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="search-icon"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Vyhľadávanie
          <?php endif; ?>
        </h2>

        <!-- ── Formulár vyhľadávania ──────────────────────────────── -->
        <form method="GET" action="search.php" role="search" aria-label="Vyhľadávanie v článkoch">
          <div class="search-form-wrap">
            <label for="search-input" class="visually-hidden">Vyhľadať v článkoch</label>
            <input
              type="search"
              id="search-input"
              name="s"
              class="search-input"
              value="<?= htmlspecialchars($rawQuery) ?>"
              placeholder="Hľadajte napr. eGFR, hyponatriémia, dyslipidémia…"
              autocomplete="off"
              autofocus
              maxlength="200"
              aria-label="Vyhľadávací výraz"
            >
            <button type="submit" class="search-btn" aria-label="Spustiť vyhľadávanie">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
              Hľadať
            </button>
          </div>

          <?php if ($hasQuery && !empty($tokens)): ?>
            <p class="search-hint">
              Vyhľadávané výrazy:
              <?php foreach ($tokens as $norm => $orig): ?>
                <span class="search-meta__term"><?= htmlspecialchars(
                    $orig,
                ) ?></span>
              <?php endforeach; ?>
            </p>
          <?php endif; ?>
        </form>

        <?php if ($hasQuery): ?>

          <!-- ── Metadáta výsledkov ────────────────────────────────── -->
          <div class="search-meta" aria-live="polite" aria-atomic="true">
            <?php if ($totalItems > 0): ?>
              <span>
                Nájdených: <strong class="search-meta__count"><?= $totalItems ?></strong>
                <?php
                $resultWord = "výsledkov";
                if ($totalItems === 1) {
                  $resultWord = "výsledok";
                } elseif ($totalItems < 5) {
                  $resultWord = "výsledky";
                }
                echo $resultWord;
                ?>
              </span>
              <?php if ($totalPages > 1): ?>
                <span class="text-tertiary">·</span>
                <span>Strana <?= $page ?> z <?= $totalPages ?></span>
              <?php endif; ?>
              <span class="text-tertiary">·</span>
              <span class="search-meta__time"><?= $searchTime ?>&nbsp;ms</span>
            <?php else: ?>
              <span>Žiadne výsledky pre <span class="search-meta__term"><?= htmlspecialchars(
                  $rawQuery,
              ) ?></span></span>
            <?php endif; ?>
          </div>

          <?php if (!empty($results)): ?>

            <!-- ── Zoznam výsledkov ─────────────────────────────────── -->
            <ul class="search-results-list" aria-label="Výsledky vyhľadávania">
              <?php foreach ($results as $row):

                  $matchFields = detectMatchFields($row, $tokens);
                  $snippet = buildSearchSnippet(
                      (string) ($row["content_preview"] ??
                          ($row["excerpt"] ?? "")),
                      $tokens,
                  );
                  $titleHl = highlightSearchTerms(
                      htmlspecialchars((string) ($row["title"] ?? "")),
                      $tokens,
                  );
                  $articleUrl =
                      "article.php?slug=" .
                      rawurlencode((string) ($row["slug"] ?? ""));
                  $searchTitleRaw = trim((string) ($row["title"] ?? ""));
                  $searchTitle = $searchTitleRaw !== "" ? $searchTitleRaw : "Bez názvu článku";
                  ?>
              <li class="search-result-item">
              <article class="search-result">
                <a href="<?= htmlspecialchars(
                    $articleUrl,
                ) ?>" class="search-result__title" aria-label="Článok: <?= htmlspecialchars($searchTitle, ENT_QUOTES, 'UTF-8') ?>">
                  <?= $searchTitleRaw !== "" ? $titleHl : htmlspecialchars($searchTitle, ENT_QUOTES, 'UTF-8') ?>
                </a>

                <div class="search-result__meta">
                  <time datetime="<?= htmlspecialchars(
                      substr((string) ($row["published_at"] ?? ""), 0, 10),
                  ) ?>">
                    <?= formatSearchDate(
                        (string) ($row["published_at"] ?? ""),
                    ) ?>
                  </time>
                  <?php if (!empty($row["author"])): ?>
                    <span class="text-tertiary">·</span>
                    <span><?= htmlspecialchars(
                        (string) $row["author"],
                    ) ?></span>
                  <?php endif; ?>
                  <?php foreach ($matchFields as $field): ?>
                    <span class="search-result__field-badge"><?= htmlspecialchars(
                        $fieldLabels[$field] ?? $field,
                    ) ?></span>
                  <?php endforeach; ?>
                </div>

                <?php if ($snippet !== ""): ?>
                  <div class="search-result__snippet" aria-label="Ukážka z článku">
                    <?= $snippet ?>
                  </div>
                <?php elseif (!empty($row["excerpt"])): ?>
                  <div class="search-result__snippet">
                    <?= highlightSearchTerms(
                        htmlspecialchars(
                            mb_substr(
                                (string) $row["excerpt"],
                                0,
                                SEARCH_SNIPPET,
                                "UTF-8",
                            ),
                        ),
                        $tokens,
                    ) ?>
                  </div>
                <?php endif; ?>
              </article>
              </li>
              <?php
              endforeach; ?>
            </ul>

            <!-- ── Stránkovanie ─────────────────────────────────────── -->
            <?php if ($totalPages > 1): ?>
              <nav class="search-pagination" aria-label="Stránkovanie výsledkov vyhľadávania">
                <?php if ($prevUrl): ?>
                  <a href="<?= htmlspecialchars($prevUrl) ?>"
                     class="articles-page-link"
                    rel="prev">← Predošlá</a>
                <?php endif; ?>

                <?php
                $startP = max(1, $page - 2);
                $endP = min($totalPages, $page + 2);
                for ($p = $startP; $p <= $endP; $p++):
                    $pUrl =
                        $baseUrl .
                        $searchQueryPrefix .
                        urlencode($rawQuery) .
                        $pageQuerySeparator .
                        $p; ?>
                  <a href="<?= htmlspecialchars($pUrl) ?>"
                     class="articles-page-link<?= $p === $page
                         ? " is-active"
                         : "" ?>"
                     <?= $p === $page ? 'aria-current="page"' : "" ?>
                     aria-label="Strana <?= $p ?>"><?= $p ?></a>
                <?php
                endfor;
                ?>

                <?php if ($nextUrl): ?>
                  <a href="<?= htmlspecialchars($nextUrl) ?>"
                     class="articles-page-link"
                    rel="next">Ďalšia →</a>
                <?php endif; ?>
              </nav>
            <?php endif; ?>

          <?php else: ?>

            <!-- ── Nulové výsledky ──────────────────────────────────── -->
            <output class="search-empty" aria-live="polite">
              <div class="search-empty__icon" aria-hidden="true">🔍</div>
              <div class="search-empty__title">Žiadne výsledky</div>
              <p class="search-empty__text">
                Pre výraz <strong><?= htmlspecialchars($rawQuery) ?></strong>
                nebol nájdený žiadny článok.
              </p>

              <?php if (empty($tokens)): ?>
                <p class="search-empty__text fs-085">
                  Zadaný výraz obsahuje iba krátke alebo bežné slovenské slová.
                  Skúste konkrétnejší odborný výraz.
                </p>
              <?php endif; ?>

              <div class="mt-1-5rem">
                <p class="search-section-label">Skúste napríklad:</p>
                <div class="flex-center-wrap-gap8">
                  <?php foreach (
                      [
                          "eGFR",
                          "CKD",
                          "KFRE",
                          "hyponatriémia",
                          "dyslipidémia",
                          "dialýza",
                          "statín",
                          "vitamín D",
                      ]
                      as $sugg
                  ): ?>
                    <a href="search.php?s=<?= urlencode($sugg) ?>"
                       class="search-meta__term link-unstyled"
                       aria-label="Hľadať výraz <?= htmlspecialchars($sugg, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(
                           $sugg,
                       ) ?></a>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="mt-2rem">
                <a href="index.php" class="btn-primary d-inline-block">
                  ← Späť na zoznam článkov
                </a>
              </div>
            </output>

          <?php endif; ?>

        <?php else: ?>

          <!-- ── Úvodná stránka vyhľadávania (bez dopytu) ─────────── -->
          <div class="search-empty">
            <p class="search-empty-desc">
              Prehľadávajte odborné nefrologické články, analýzy a komentáre.
              Vyhľadávanie je jazykovo inteligentné — rozumie slovenčine, diakritike aj medicínskym skratkám.
            </p>

            <p class="search-section-label-1rem">Obľúbené témy:</p>
            <div class="flex-center-wrap-gap10 mb-25rem">
              <?php foreach (
                  [
                      "eGFR",
                      "CKD",
                      "KFRE",
                      "KDIGO",
                      "hyponatriémia",
                      "dyslipidémia",
                      "dialýza",
                      "AKI",
                      "lymfóm",
                      "prediabetes",
                      "statín",
                      "vitamín D",
                      "ADPKD",
                      "IgA nefropatia",
                  ]
                  as $sugg
              ): ?>
                <a href="search.php?s=<?= urlencode($sugg) ?>"
                   class="search-meta__term link-chip"
                   aria-label="Hľadať výraz <?= htmlspecialchars($sugg, ENT_QUOTES, 'UTF-8') ?>">
                  <?= htmlspecialchars($sugg) ?>
                </a>
              <?php endforeach; ?>
            </div>

            <div class="flex-gap-16-center-wrap">
              <a href="index.php" class="btn-secondary search-cta-btn">
                📄 Všetky články
              </a>
              <a href="calculators.php" class="btn-secondary search-cta-btn">
                🧮 Kalkulačky
              </a>
            </div>
          </div>

        <?php endif; ?>

      </div><!-- /.primary-article -->
    </div><!-- /.main-content -->
  </main>

  <?php include_once "footer.php"; ?>

</body>
</html>
