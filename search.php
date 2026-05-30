<?php
declare(strict_types=1);
/**
 * search.php — Komplexné hĺbkové vyhľadávanie v článkoch
 * Funkcie: FULLTEXT + LIKE, slovenské diakritiky, stop slová,
 *          relevančné skórovanie, zvýraznenie výrazov, snippety, stránkovanie.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

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
        $sr = doArticleSearch($pdo, $rawQuery, $tokens, $page, SEARCH_PER_PAGE);
        $searchTime = round((microtime(true) - $t0) * 1000, 1); // ms

        $results = $sr["items"];
        $totalItems = $sr["total"];
        $strategy = $sr["strategy"];
        $totalPages = max(1, (int) ceil($totalItems / SEARCH_PER_PAGE));

        if ($page > $totalPages) {
            $page = $totalPages;
            $sr = doArticleSearch($pdo, $rawQuery, $tokens, $page, SEARCH_PER_PAGE);
            $results = $sr["items"];
        }
    }
}

// ── SEO meta ─────────────────────────────────────────────────────────────────

$baseUrl = "https://nefro.polascin.net/";
$siteName = "Nefro-projekt Slovensko";

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
        "search.php?s=" .
        urlencode($rawQuery) .
        "&page=" .
        ($page - 1);
}
if ($page < $totalPages) {
    $nextUrl =
        $baseUrl .
        "search.php?s=" .
        urlencode($rawQuery) .
        "&page=" .
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
    $ts = strtotime($datetime);
    if (!$ts) {
        return htmlspecialchars($datetime);
    }
    return (int) date("j", $ts) .
        ". " .
        ($months[(int) date("n", $ts)] ?? "") .
        " " .
        date("Y", $ts);
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
  <?php include "head_meta.php"; ?>
  <?php if ($prevUrl): ?>
  <link rel="prev" href="<?= htmlspecialchars($prevUrl) ?>">
  <?php endif; ?>
  <?php if ($nextUrl): ?>
  <link rel="next" href="<?= htmlspecialchars($nextUrl) ?>">
  <?php endif; ?>
</head>
<body>
  <a href="#search-results" class="skip-link">Preskočiť na výsledky</a>

  <?php
  $headerTitle = "Nefro-projekt Slovensko";
  $showLogo = false;
  include "header.php";
  ?>

  <?php include 'main_nav.php'; ?>

  <main id="search-results" class="container search-main" role="main">
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
                <?= $totalItems === 1
                    ? "výsledok"
                    : ($totalItems < 5
                        ? "výsledky"
                        : "výsledkov") ?>
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
            <div role="list" aria-label="Výsledky vyhľadávania">
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
                  ?>
              <article class="search-result" role="listitem">
                <a href="<?= htmlspecialchars(
                    $articleUrl,
                ) ?>" class="search-result__title">
                  <?= $titleHl ?>
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
              <?php
              endforeach; ?>
            </div>

            <!-- ── Stránkovanie ─────────────────────────────────────── -->
            <?php if ($totalPages > 1): ?>
              <nav class="search-pagination" aria-label="Stránkovanie výsledkov vyhľadávania">
                <?php if ($prevUrl): ?>
                  <a href="<?= htmlspecialchars($prevUrl) ?>"
                     class="articles-page-link"
                     rel="prev"
                     aria-label="Predchádzajúca strana">← Predošlá</a>
                <?php endif; ?>

                <?php
                $startP = max(1, $page - 2);
                $endP = min($totalPages, $page + 2);
                for ($p = $startP; $p <= $endP; $p++):
                    $pUrl =
                        $baseUrl .
                        "search.php?s=" .
                        urlencode($rawQuery) .
                        "&page=" .
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
                     rel="next"
                     aria-label="Nasledujúca strana">Ďalšia →</a>
                <?php endif; ?>
              </nav>
            <?php endif; ?>

          <?php else: ?>

            <!-- ── Nulové výsledky ──────────────────────────────────── -->
            <div class="search-empty" role="status" aria-live="polite">
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
                       class="search-meta__term link-unstyled"><?= htmlspecialchars(
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
            </div>

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
                   class="search-meta__term link-chip">
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

  <?php include "footer.php"; ?>

</body>
</html>
