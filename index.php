<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
$monthsLocative = [
    1 => "januári",
    2 => "februári",
    3 => "marci",
    4 => "apríli",
    5 => "máji",
    6 => "júni",
    7 => "júli",
    8 => "auguste",
    9 => "septembri",
    10 => "októbri",
    11 => "novembri",
    12 => "decembri",
];
$currentMonth = (int) date("n");
$currentYear = date("Y");
$currentMonthYearLocative =
    ($monthsLocative[$currentMonth] ?? "") . " " . $currentYear;
$pageLastUpdated = date("d.m.Y H:i", filemtime(__FILE__));
$pageTimeZone = date("T") . " (" . date_default_timezone_get() . ")";

function formatArticleDate(string $datetime): string
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

function normalizePlainText(string $text): string
{
    $decoded = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, "UTF-8");
    $stripped = strip_tags($decoded);
    $normalized = preg_replace("/\s+/u", " ", $stripped) ?? $stripped;
    return trim($normalized);
}

function buildSeoExcerpt(
    string $preferredText,
    string $fallbackText = "",
    int $maxLen = 170,
): string {
    $source = normalizePlainText($preferredText);
    if ($source === "") {
        $source = normalizePlainText($fallbackText);
    }
    if ($source === "") {
        return "";
    }
    if (mb_strlen($source) <= $maxLen) {
        return $source;
    }

    $slice = mb_substr($source, 0, $maxLen + 1);
    $slice = preg_replace('/\s+\S*$/u', "", $slice) ?? $slice;
    $slice = rtrim($slice, " \t\n\r\0\x0B,.;:-");
    return $slice . "…";
}

$topArticles = [];
$otherArticles = [];
$otherArticlesPerPage = 10;
$otherArticlesTotal = 0;
$otherArticlesTotalPages = 1;
$otherArticlesPage = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($otherArticlesPage < 1) {
    $otherArticlesPage = 1;
}
$autorFilter = isset($_GET["autor"]) ? mb_substr(trim($_GET["autor"]), 0, 255) : "";

try {
    if ($autorFilter !== "") {
        // Režim filtrovania podľa autora — všetky jeho články, stránkované
        $stmtCount = $pdo->prepare(
            "SELECT COUNT(*) FROM articles
             WHERE is_published = 1 AND TRIM(author) = :author",
        );
        $stmtCount->execute([":author" => $autorFilter]);
        $otherArticlesTotal = (int) $stmtCount->fetchColumn();
        $otherArticlesTotalPages = max(
            1,
            (int) ceil($otherArticlesTotal / $otherArticlesPerPage),
        );
        if ($otherArticlesPage > $otherArticlesTotalPages) {
            $otherArticlesPage = $otherArticlesTotalPages;
        }
        $otherArticlesOffset = ($otherArticlesPage - 1) * $otherArticlesPerPage;
        $stmtOther = $pdo->prepare(
            "SELECT id, title, slug, author, excerpt, published_at
             FROM articles
             WHERE is_published = 1 AND TRIM(author) = :author
             ORDER BY is_top DESC, sort_order ASC, published_at DESC
             LIMIT :limit OFFSET :offset",
        );
        $stmtOther->bindValue(":author", $autorFilter);
        $stmtOther->bindValue(":limit", $otherArticlesPerPage, \PDO::PARAM_INT);
        $stmtOther->bindValue(":offset", $otherArticlesOffset, \PDO::PARAM_INT);
        $stmtOther->execute();
        $otherArticles = $stmtOther->fetchAll();
    } else {
        // Štandardný režim — top + ostatné články
        $stmtTop = $pdo->query(
            "SELECT id, title, slug, author, excerpt, published_at
             FROM articles WHERE is_top = 1 AND is_published = 1
             ORDER BY sort_order ASC, published_at DESC",
        );
        $topArticles = $stmtTop->fetchAll();

        $stmtOtherCount = $pdo->query(
            "SELECT COUNT(*) FROM articles WHERE is_top = 0 AND is_published = 1",
        );
        $otherArticlesTotal = (int) $stmtOtherCount->fetchColumn();
        $otherArticlesTotalPages = max(
            1,
            (int) ceil($otherArticlesTotal / $otherArticlesPerPage),
        );
        if ($otherArticlesPage > $otherArticlesTotalPages) {
            $otherArticlesPage = $otherArticlesTotalPages;
        }
        $otherArticlesOffset = ($otherArticlesPage - 1) * $otherArticlesPerPage;
        $stmtOther = $pdo->prepare(
            "SELECT id, title, slug, author, excerpt, published_at
             FROM articles WHERE is_top = 0 AND is_published = 1
             ORDER BY sort_order ASC, published_at DESC
             LIMIT :limit OFFSET :offset",
        );
        $stmtOther->bindValue(":limit", $otherArticlesPerPage, \PDO::PARAM_INT);
        $stmtOther->bindValue(":offset", $otherArticlesOffset, \PDO::PARAM_INT);
        $stmtOther->execute();
        $otherArticles = $stmtOther->fetchAll();
    }
} catch (\PDOException $e) {
    error_log("index.php – chyba pri načítaní článkov: " . $e->getMessage());
}

$projectPublicStats = getProjectPublicStats($pdo);

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$isPaginated = $otherArticlesPage > 1;
$firstArticleForSeo = $topArticles[0] ?? ($otherArticles[0] ?? null);
$autorFilterUrl = $autorFilter !== "" ? urlencode($autorFilter) : "";
$autorFilterHtml = $autorFilter !== "" ? htmlspecialchars($autorFilter, ENT_QUOTES, "UTF-8") : "";

$defaultDescription =
    "Nefrologické články a odborné analýzy o CKD, dialýze a moderných odporúčaniach pre klinickú prax na Slovensku.";
$seoDescription = $defaultDescription;
if (is_array($firstArticleForSeo)) {
    $seoDescription = buildSeoExcerpt(
        (string) ($firstArticleForSeo["excerpt"] ?? ""),
        "",
        165,
    );
    if ($seoDescription === "") {
        $seoDescription = $defaultDescription;
    }
}

if ($autorFilter !== "") {
    $pageTitle = "Články autora: " . $autorFilter
        . ($isPaginated ? " – strana " . $otherArticlesPage : "")
        . " | " . $siteName;
    $canonicalUrl = $baseUrl . "?autor=" . $autorFilterUrl
        . ($isPaginated ? "&page=" . $otherArticlesPage : "");
    $prevUrl = $otherArticlesPage > 1
        ? ($otherArticlesPage === 2
            ? $baseUrl . "?autor=" . $autorFilterUrl
            : $baseUrl . "?autor=" . $autorFilterUrl . "&page=" . ($otherArticlesPage - 1))
        : "";
    $nextUrl = $otherArticlesPage < $otherArticlesTotalPages
        ? $baseUrl . "?autor=" . $autorFilterUrl . "&page=" . ($otherArticlesPage + 1)
        : "";
} else {
    $pageTitle = $isPaginated
        ? "Nefrologické články – strana " . $otherArticlesPage . " | " . $siteName
        : $siteName;
    $canonicalUrl = $isPaginated
        ? $baseUrl . "?page=" . $otherArticlesPage
        : $baseUrl;
    $prevUrl =
        $otherArticlesPage > 1
            ? ($otherArticlesPage === 2
                ? $baseUrl
                : $baseUrl . "?page=" . ($otherArticlesPage - 1))
            : "";
    $nextUrl =
        $otherArticlesPage < $otherArticlesTotalPages
            ? $baseUrl . "?page=" . ($otherArticlesPage + 1)
            : "";
}

$itemListElements = [];
$allPageArticles = array_merge($topArticles, $otherArticles);
foreach ($allPageArticles as $idx => $art) {
    $slug = (string) ($art["slug"] ?? "");
    $title = normalizePlainText((string) ($art["title"] ?? ""));
    if ($slug === "" || $title === "") {
        continue;
    }
    $itemListElements[] = [
        "@type" => "ListItem",
        "position" => count($itemListElements) + 1,
        "url" => $baseUrl . "article.php?slug=" . $slug,
        "name" => $title,
    ];
}

$structuredData = [
    [
        "@context" => "https://schema.org",
        "@type" => "MedicalOrganization",
        "name" => $siteName,
        "url" => $baseUrl,
        "logo" => [
            "@type" => "ImageObject",
            "url" => $baseUrl . "img/nps-logo.gif",
            "width" => 200,
            "height" => 200,
        ],
        "description" =>
            "Dynamická renesancia nefrológie: od molekulárnej biológie po umelú inteligenciu.",
        "medicalSpecialty" => "Nephrology",
        "inLanguage" => "sk-SK",
        "sameAs" => ["https://polascin.com/", "https://nefro.sk/"],
        "founder" => [
            "@type" => "Person",
            "name" => "MUDr. Ľubomír Polaščín",
            "jobTitle" => "Lekár, Nefrológ",
            "url" => "https://polascin.com/",
            "sameAs" => ["https://polascin.com/", "https://nefro.sk/"],
        ],
        "contactPoint" => [
            "@type" => "ContactPoint",
            "email" => "nefro@polascin.net",
            "contactType" => "customer support",
            "availableLanguage" => ["Slovak", "Czech", "English"],
        ],
    ],
    [
        "@context" => "https://schema.org",
        "@type" => "WebSite",
        "name" => $siteName,
        "url" => $baseUrl,
        "inLanguage" => "sk-SK",
        "description" => $seoDescription,
        "potentialAction" => [
            "@type" => "SearchAction",
            "target" => [
                "@type" => "EntryPoint",
                "urlTemplate" => $baseUrl . "search.php?s={search_term_string}",
            ],
            "query-input" => "required name=search_term_string",
        ],
    ],
];

if (!empty($itemListElements)) {
    $structuredData[] = [
        "@context" => "https://schema.org",
        "@type" => "ItemList",
        "name" => $isPaginated
            ? "Články – strana " . $otherArticlesPage
            : "Články",
        "itemListElement" => $itemListElements,
    ];
}
?>
<!DOCTYPE html>
<html lang="sk">

<head>
  <?php
  // Príprava pre head_meta.php
  $structuredData = $structuredData ?? [];
  include "head_meta.php";
  ?>
  <?php if ($prevUrl !== ""): ?>
  <link rel="prev" href="<?= htmlspecialchars($prevUrl, ENT_QUOTES) ?>">
  <?php endif; ?>
  <?php if ($nextUrl !== ""): ?>
  <link rel="next" href="<?= htmlspecialchars($nextUrl, ENT_QUOTES) ?>">
  <?php endif; ?>
</head>

<body>
  <!-- Skip to content (A11y) -->
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <!-- <header>: Hlavička stránky alebo sekcie, zvyčajne obsahuje logo a hlavný nadpis -->
  <?php
  $headerTitle = "Nefro-projekt Slovensko";
  $headerIntro =
      "Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.";
  $showLogo = true;
  include "header.php";
  ?>

  <?php include 'main_nav.php'; ?>

  <!-- <main>: Hlavný obsah stránky, ktorý je pre daný dokument unikátny -->
  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">

      <?php if ($autorFilter !== ""): ?>
      <!-- Články filtrované podľa autora -->
      <section class="articles-list-section" aria-labelledby="autor-articles-heading">
        <div class="primary-article">
          <h2 id="autor-articles-heading">
            Články autora: <em><?= $autorFilterHtml ?></em>
            <a href="index.php" class="autor-filter-reset" aria-label="Zobraziť všetky články" title="Zobraziť všetky články">✕</a>
          </h2>
          <?php if (empty($otherArticles)): ?>
            <p>Tento autor nemá žiadne publikované články.</p>
          <?php else: ?>
          <ul class="articles-list" role="list">
            <?php foreach ($otherArticles as $art):
                $artSlug = htmlspecialchars((string) $art["slug"], ENT_QUOTES);
                $artTitle = htmlspecialchars((string) $art["title"]);
                $artExc = htmlspecialchars(buildSeoExcerpt((string) ($art["excerpt"] ?? ""), "", 220));
                $artDate = htmlspecialchars(formatArticleDate((string) $art["published_at"]));
                $artDateIso = htmlspecialchars(substr((string) $art["published_at"], 0, 10));
                $artIsTop = !empty($art["is_top"]);
                ?>
            <li class="article-list-item">
              <div class="article-list-item__header">
                <a href="article.php?slug=<?= $artSlug ?>" class="article-list-item__title">
                  <?php if ($artIsTop): ?><span class="badge-top" aria-label="Odporúčaný článok">&#9733;</span> <?php endif; ?>
                  <?= $artTitle ?>
                </a>
                <time class="article-list-item__date" datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
              </div>
              <p class="article-list-item__excerpt"><?= $artExc ?></p>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php if ($otherArticlesTotalPages > 1): ?>
            <nav class="articles-pagination" aria-label="Stránkovanie článkov autora">
              <span class="articles-pagination__label">Stránky:</span>
              <div class="articles-pagination__links">
                <?php for ($p = 1; $p <= $otherArticlesTotalPages; $p++): ?>
                  <?php if ($p === $otherArticlesPage): ?>
                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                  <?php else: ?>
                    <a class="articles-page-link" href="?autor=<?= $autorFilterUrl ?>&page=<?= $p ?>#autor-articles-heading"><?= $p ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </nav>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </section>
      <?php endif; ?>

      <?php if ($autorFilter === "" && !empty($topArticles)): ?>
      <!-- Top články -->
      <section class="articles-top-section" aria-labelledby="top-articles-heading">
        <h2 id="top-articles-heading" class="section-heading">Odporúčané články</h2>
        <?php foreach ($topArticles as $art):

            $artSlug = htmlspecialchars((string) $art["slug"], ENT_QUOTES);
            $artTitle = htmlspecialchars((string) $art["title"]);
            $artExc = htmlspecialchars(
                buildSeoExcerpt((string) ($art["excerpt"] ?? ""), "", 220),
            );
            $artDate = htmlspecialchars(
                formatArticleDate((string) $art["published_at"]),
            );
            $artDateIso = htmlspecialchars(
                substr((string) $art["published_at"], 0, 10),
            );
            ?>
        <article class="primary-article">
          <span class="badge-top" aria-label="Odporúčaný článok">&#9733; TOP</span>
          <header>
            <h2><a href="article.php?slug=<?= $artSlug ?>" class="article-title-link"><?= $artTitle ?></a></h2>
            <p class="meta">
              Publikované:&nbsp; <time datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
            </p>
          </header>
          <p class="article-excerpt"><?= $artExc ?></p>
          <a href="article.php?slug=<?= $artSlug ?>" class="read-more">Čítať ďalej &rarr;</a>
        </article>
        <?php
        endforeach; ?>
      </section>
      <?php endif; ?>

      <?php if ($autorFilter === "" && !empty($otherArticles)): ?>
      <!-- Ďalšie články -->
      <section class="articles-list-section" aria-labelledby="all-articles-heading">
        <div class="primary-article">
          <h2 id="all-articles-heading">Ďalšie články</h2>
          <ul class="articles-list" role="list">
            <?php foreach ($otherArticles as $art):

                $artSlug = htmlspecialchars((string) $art["slug"], ENT_QUOTES);
                $artTitle = htmlspecialchars((string) $art["title"]);
                $artExc = htmlspecialchars(
                    buildSeoExcerpt((string) ($art["excerpt"] ?? ""), "", 220),
                );
                $artDate = htmlspecialchars(
                    formatArticleDate((string) $art["published_at"]),
                );
                $artDateIso = htmlspecialchars(
                    substr((string) $art["published_at"], 0, 10),
                );
                ?>
            <li class="article-list-item">
              <div class="article-list-item__header">
                <a href="article.php?slug=<?= $artSlug ?>" class="article-list-item__title"><?= $artTitle ?></a>
                <time class="article-list-item__date" datetime="<?= $artDateIso ?>"><?= $artDate ?></time>
              </div>
              <p class="article-list-item__excerpt"><?= $artExc ?></p>
            </li>
            <?php
            endforeach; ?>
          </ul>

          <?php if ($otherArticlesTotalPages > 1): ?>
            <nav class="articles-pagination" aria-label="Stránkovanie ďalších článkov">
              <span class="articles-pagination__label">Stránky:</span>
              <div class="articles-pagination__links">
                <?php for ($p = 1; $p <= $otherArticlesTotalPages; $p++): ?>
                  <?php if ($p === $otherArticlesPage): ?>
                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                  <?php else: ?>
                    <a class="articles-page-link" href="?page=<?= $p ?>#all-articles-heading"><?= $p ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </nav>
          <?php endif; ?>
        </div>
      </section>
      <?php endif; ?>

      <?php if ($autorFilter === "" && empty($topArticles) && empty($otherArticles)): ?>
      <div class="primary-article">
        <p>Žiadne články ešte neboli zverejnené.</p>
        <?php if (isAdmin()): ?>
          <a href="admin_articles.php" class="btn-primary">Pridať prvý článok</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <!-- Sekcia Služby -->
      <section class="features-section" id="sluzby" aria-labelledby="sluzby-heading">
        <h2 id="sluzby-heading">Čo ponúkam</h2>
        <div class="features-grid">

          <div class="feature-card service-card service-card--blue">
            <div class="service-card__icon" aria-hidden="true">🩺</div>
            <h3>Nefrológia a dialýza</h3>
            <p>Klinická a konziliárna nefrológia s dlhoročnou praxou v renálnej nahradzujúcej liečbe a ultrasonografii.</p>
            <ul class="service-card__list">
              <li>Hemodialýza, hemodiafiltrácia, peritoneálna dialýza</li>
              <li>Mimotelové eliminačné metódy (AKI, intoxikácie)</li>
              <li>Ultrasonografia obličiek, cievnych prístupov a brucha</li>
              <li>Konziliárna nefrológia a manažment CKD</li>
            </ul>
          </div>

          <div class="feature-card service-card service-card--green">
            <div class="service-card__icon" aria-hidden="true">🎓</div>
            <h3>Lektorstvo a vzdelávanie</h3>
            <p>Odborné prednášky a vzdelávacie aktivity pre zdravotníkov aj laickú verejnosť v oblasti nefrológie a internej medicíny.</p>
            <ul class="service-card__list">
              <li>Prednášky a workshopy pre zdravotníkov</li>
              <li>Spolupráca s univerzitnými pracoviskami</li>
              <li>Edukácia pacientov a laickej verejnosti</li>
              <li>Tvorba odborných vzdelávacích materiálov</li>
            </ul>
          </div>

          <div class="feature-card service-card service-card--purple">
            <div class="service-card__icon" aria-hidden="true">🌐</div>
            <h3>Medicínske preklady</h3>
            <p>Odborné preklady medicínskych textov a lokalizácia softvéru s dôrazom na presnú klinickú terminológiu.</p>
            <ul class="service-card__list">
              <li>Preklady AJ ↔ SJ (odborné aj populárne texty)</li>
              <li>Lokalizácia medicínskeho softvéru a UI</li>
              <li>Klinická dokumentácia a vedecké články</li>
              <li>Terminologická konzultácia</li>
            </ul>
          </div>

          <div class="feature-card service-card service-card--orange">
            <div class="service-card__icon" aria-hidden="true">💻</div>
            <h3>IT a AI riešenia</h3>
            <p>Vývoj medicínskych aplikácií a integrácia AI nástrojov pre zdravotnícke prostredie.</p>
            <ul class="service-card__list">
              <li>Webové aplikácie a portály pre zdravotníkov</li>
              <li>Klinické kalkulačky a rozhodovacie nástroje</li>
              <li>Integrácia AI do medicínskej praxe</li>
              <li>Automatizácia dokumentácie a dátová analýza</li>
            </ul>
          </div>

        </div>
        <div class="service-cta">
          <p>Máte záujem o spoluprácu alebo konzultáciu?</p>
          <a href="mailto:nefro@polascin.net" class="btn-primary">Napísať e-mail</a>
        </div>
      </section>

      <!-- Sekcia O mne -->
      <section class="features-section" id="o-mne" aria-labelledby="o-mne-heading">
        <h2 id="o-mne-heading">O mne</h2>

        <div class="about-bio">
          <div class="about-bio__avatar">
            <img src="img/lubomir-polascin.jpg" alt="MUDr. Ľubomír Polaščín" class="about-bio__photo" width="80" height="80" loading="lazy">
          </div>
          <div class="about-bio__text">
            <p class="about-bio__name">MUDr. Ľubomír Polaščín</p>
            <p class="about-bio__tagline">Nefrológ &middot; Autor &middot; Technológ &middot; Mysliteľ</p>
            <p>
              <strong>Interdisciplinárny tvorca</strong> na styku medicíny, technológií, jazyka a ideového myslenia.
              Lekár so špecializáciou v nefrológii a internej medicíne, ktorý spája odbornosť s tvorbou praktických a zmysluplných výstupov.
            </p>
          </div>
        </div>

        <div class="features-grid about-grid">
          <div class="feature-card about-card">
            <div class="about-card__icon" aria-hidden="true">🩺</div>
            <h3>Lekár a odborník</h3>
            <p>Špecializované zázemie v <strong>nefrológii</strong>, dialýze, hemodiafiltráciách, peritoneálnej dialýze a internej medicíne. Klinická prax dopĺňaná o vedeckú reflexiu a odborné písanie.</p>
          </div>
          <div class="feature-card about-card">
            <div class="about-card__icon" aria-hidden="true">✍️</div>
            <h3>Tvorca a autor</h3>
            <p>Kladiem dôraz na <strong>presnosť, štýl a jazyk</strong>. Som prekladateľ a jazykový pracovník citlivý na formulácie a významové odtiene — od odborných textov po literárne žánre.</p>
          </div>
          <div class="feature-card about-card">
            <div class="about-card__icon" aria-hidden="true">💻</div>
            <h3>Technologický praktik</h3>
            <p>Programujem a tvorím weby a aplikácie. <strong>Umelá inteligencia</strong> pre mňa nie je hračka, ale pracovný, tvorivý a systémový nástroj integrovaný do každodennej praxe.</p>
          </div>
          <div class="feature-card about-card">
            <div class="about-card__icon" aria-hidden="true">🔗</div>
            <h3>Integrátor disciplín</h3>
            <p>Medicína, kód, filozofia a spiritualita nie sú oddelené ostrovy — sú súčasťou jedného <strong>intelektuálneho ekosystému</strong>. Zaujíma ma nielen funkčnosť vecí, ale aj ich hlbší zmysel.</p>
          </div>
        </div>
      </section>

      <section class="features-section" id="kontakt" aria-labelledby="kontakt-heading">
        <h2 id="kontakt-heading">Kontakt a spolupráca</h2>
        <div class="contact-grid">

          <div class="contact-main">
            <p class="contact-main__lead">Som otvorený odbornej diskusii, prednáškam, prekladateľským zákazkám aj technologickej spolupráci.</p>
            <a href="mailto:nefro@polascin.net" class="contact-email-link" aria-label="Napísať e-mail na nefro@polascin.net">
              <span class="contact-email-link__icon" aria-hidden="true">✉</span>
              nefro@polascin.net
            </a>
            <ul class="contact-topics">
              <li>Odborné konzultácie a second opinion v nefrológii</li>
              <li>Prednášky, workshopy, edukačné projekty</li>
              <li>Medicínske preklady a terminologická spolupráca</li>
              <li>Vývoj medicínskych aplikácií a AI integrácia</li>
            </ul>
          </div>

          <div class="feature-card contact-community">
            <div class="contact-community__icon" aria-hidden="true">👥</div>
            <h3>Staňte sa súčasťou komunity</h3>
            <p>Zaregistrujte sa a získajte prístup k obsahu. Môžete si zvoliť zasielanie avíz o nových článkoch priamo do e-mailu.</p>
            <?php if (!isLoggedIn()): ?>
              <a href="register.php" class="btn-primary">Registrovať sa</a>
            <?php else: ?>
              <div class="badge-highlight">✓ Ste prihlásený</div>
            <?php endif; ?>
          </div>

        </div>
      </section>
    </div>

    <!-- <aside>: Bočný panel, obsah, ktorý len okrajovo súvisí s hlavným obsahom -->
    <aside class="sidebar">
      <div class="widget">
        <h3>Náhodný obrázok</h3>
        <?php
        // Získanie všetkých obrázkov zodpovedajúcich štruktúre
        $images = glob("./img/nefro_*.png");
        if ($images && count($images) > 0) {
            // Výber náhodného obrázka
            $randomIndex = array_rand($images);
            $randomImagePath = $images[$randomIndex];

            echo '<a href="' .
                htmlspecialchars($randomImagePath) .
                '" id="randomImageLink" target="_blank" rel="noopener noreferrer" title="Zobraziť obrázok v plnej veľkosti" aria-label="Zobraziť náhodný abstraktný obrázok v plnej veľkosti">';
            echo '<img id="randomImage" src="' .
                htmlspecialchars($randomImagePath) .
                '" alt="Náhodný abstraktný obrázok Nefro" loading="lazy">';
            echo "</a>";
        } else {
            echo "<p>\n";
            echo "Žiadne obrázky neboli nájdené.\n";
            echo "</p>";
        }
        ?>
      </div>

      <div class="widget">
        <img src="./img/nps.gif" alt="Nefro-projekt Slovensko Logo" class="header-logo" loading="lazy">
        <h3>O projekte</h3>
        <p>
          Ako nefrológa a nadšenca pre internú medicínu ma fascinuje, akou obrovskou a dynamickou renesanciou prechádza naša nefrologická špecializácia. Sme v <?= htmlspecialchars(
              $currentMonthYearLocative,
              ENT_QUOTES,
              "UTF-8",
          ) ?> a nefrológia sa rozvíja míľovými krokmi. Nie je to už len o manažovaní terminálneho zlyhania obličiek a čakaní na transplantáciu. Zažívame doslova explóziu inovácií, od molekulárnej biológie až po umelú inteligenciu.
        </p>
        <div class="project-stats" aria-label="Aktuálne štatistiky projektu">
          <div class="project-stat">
            <strong><?= htmlspecialchars(
                formatProjectPublicCount((int) $projectPublicStats["published_articles"]),
                ENT_QUOTES,
                "UTF-8",
            ) ?></strong>
            <span>zverejnených článkov</span>
          </div>
          <div class="project-stat">
            <strong><?= htmlspecialchars(
                formatProjectPublicCount((int) $projectPublicStats["users_total"]),
                ENT_QUOTES,
                "UTF-8",
            ) ?></strong>
            <span>registrovaných používateľov</span>
          </div>
        </div>
        <?php
        $projectAuthors = is_array($projectPublicStats["authors"] ?? null)
            ? $projectPublicStats["authors"]
            : [];
        ?>
        <?php if (!empty($projectAuthors)): ?>
        <div class="project-authors" aria-label="Autori článkov podľa počtu príspevkov">
          <h4>Zúčastnení autori</h4>
          <ul>
            <?php foreach ($projectAuthors as $authorStat):
                $authorName = trim((string) ($authorStat["author"] ?? ""));
                if ($authorName === "") {
                    continue;
                }
                $authorArticles = (int) ($authorStat["articles"] ?? 0);
                ?>
            <li>
              <a href="?autor=<?= urlencode($authorName) ?>#autor-articles-heading"
                 class="author-filter-link"
                 aria-label="Zobraziť články autora <?= htmlspecialchars($authorName, ENT_QUOTES, "UTF-8") ?>">
                <?= htmlspecialchars($authorName, ENT_QUOTES, "UTF-8") ?>
              </a>
              <strong><?= htmlspecialchars(
                  formatProjectArticleCountLabel($authorArticles),
                  ENT_QUOTES,
                  "UTF-8",
              ) ?></strong>
            </li>
            <?php
            endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>
      <div class="widget">
        <h3>Užitočné odkazy</h3>
        <ul>
          <li><a href="https://kdigo.org/guidelines/" target="_blank" rel="noopener noreferrer">KDIGO Guidelines</a></li>
          <li><a href="https://www.era-online.org/era-guidance/" target="_blank" rel="noopener noreferrer">ERA Guidance</a></li>
          <li><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology (ISN)</a></li>
          <li><a href="https://www.era-online.org/" target="_blank" rel="noopener noreferrer">European Renal Association (ERA)</a></li>
          <li><a href="https://pubmed.ncbi.nlm.nih.gov/" target="_blank" rel="noopener noreferrer">PubMed</a></li>
        </ul>
        <h4 class="subheading-secondary">Kalkulačky</h4>
        <ul>
          <li><a href="https://www.mdcalc.com/specialties/nephrology" target="_blank" rel="noopener noreferrer">MDCalc Nephrology</a></li>
          <li><a href="https://qxmd.com/calculate/" target="_blank" rel="noopener noreferrer">Calculate by QxMD</a></li>
          <li><a href="https://nephcalc.com/" target="_blank" rel="noopener noreferrer">NephCalc</a></li>
          <li><a href="https://www.era-online.org/clinical-practice/calculators-and-tools/" target="_blank" rel="noopener noreferrer">ERA Calculators</a></li>
          <li><a href="https://clincalc.com/nephrology/" target="_blank" rel="noopener noreferrer">ClinCalc Nephrology</a></li>
        </ul>
      </div>

      <div class="widget">
        <h3>Národné nefrologické spoločnosti</h3>
        <ul class="expandable-list" data-limit="10">
          <li><a href="https://www.nefro.sk/" target="_blank" rel="noopener noreferrer">Slovensko (SNS)</a></li>
          <li><a href="https://www.nefrol.cz/" target="_blank" rel="noopener noreferrer">Česko (ČNS)</a></li>
          <li><a href="https://www.asn-online.org/" target="_blank" rel="noopener noreferrer">USA (ASN)</a></li>
          <li><a href="https://www.csn-scn.ca/" target="_blank" rel="noopener noreferrer">Kanada (CSN)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://ptnefro.com.pl/" target="_blank" rel="noopener noreferrer">Poľsko (PTN)</a></li>
          <li><a href="http://www.nephrologia.hu/" target="_blank" rel="noopener noreferrer">Maďarsko (MANET)</a></li>
          <li><a href="https://www.nephrologie.at/" target="_blank" rel="noopener noreferrer">Rakúsko (ÖGN)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="https://nefroloji.org.tr/" target="_blank" rel="noopener noreferrer">Turecko (TND)</a></li>
          <li><a href="https://www.dgfn.eu/" target="_blank" rel="noopener noreferrer">Nemecko (DGfN)</a></li>
          <li><a href="https://www.sfndt.org/" target="_blank" rel="noopener noreferrer">Francúzsko (SFNDT)</a></li>
          <li><a href="https://ukkidney.org/" target="_blank" rel="noopener noreferrer">Spojené kráľovstvo (UKKA)</a></li>
          <li><a href="https://sinitaly.org/" target="_blank" rel="noopener noreferrer">Taliansko (SIN)</a></li>
          <li><a href="https://www.senefro.org/" target="_blank" rel="noopener noreferrer">Španielsko (S.E.N.)</a></li>
          <li><a href="https://www.srnefro.ro/" target="_blank" rel="noopener noreferrer">Rumunsko (SRN)</a></li>
          <li><a href="https://www.nefro.nl/" target="_blank" rel="noopener noreferrer">Holandsko (NfN)</a></li>
          <li><a href="https://bvn-sbn.be/" target="_blank" rel="noopener noreferrer">Belgicko (BVN/SBN)</a></li>
          <li><a href="https://www.ene.gr/" target="_blank" rel="noopener noreferrer">Grécko (ENE)</a></li>
          <li><a href="https://njurmed.com/" target="_blank" rel="noopener noreferrer">Švédsko (SNF)</a></li>
          <li><a href="https://www.spnefro.pt/" target="_blank" rel="noopener noreferrer">Portugalsko (SPN)</a></li>
          <li><a href="https://bgnephrology.com/" target="_blank" rel="noopener noreferrer">Bulharsko (BNA)</a></li>
          <li><a href="https://nephrology.dk/" target="_blank" rel="noopener noreferrer">Dánsko (DNS)</a></li>
          <li><a href="https://www.sny.fi/" target="_blank" rel="noopener noreferrer">Fínsko (SNY)</a></li>
          <li><a href="https://www.nephro.no/" target="_blank" rel="noopener noreferrer">Nórsko (NNF)</a></li>
          <li><a href="https://irishnephrology.ie/" target="_blank" rel="noopener noreferrer">Írsko (INS)</a></li>
          <li><a href="https://www.hdndt.org/" target="_blank" rel="noopener noreferrer">Chorvátsko (HDNDT)</a></li>
          <li><a href="https://www.lndta.lt/" target="_blank" rel="noopener noreferrer">Litva (LNDTA)</a></li>
          <li><a href="https://zdlbs.si/" target="_blank" rel="noopener noreferrer">Slovinsko (ZDLBS)</a></li>
          <li><a href="https://niere.lv/" target="_blank" rel="noopener noreferrer">Lotyšsko (Nieras.lv)</a></li>
          <li><a href="https://neer.ee/" target="_blank" rel="noopener noreferrer">Estónsko (ENL)</a></li>
          <li><a href="https://www.nek.org.cy/" target="_blank" rel="noopener noreferrer">Cyprus (CKA)</a></li>
          <!-- Medzinárodné organizácie -->
          <li class="list-item-separator"><a href="https://www.theisn.org/" target="_blank" rel="noopener noreferrer">International Society of Nephrology (ISN)</a></li>
          <li><a href="https://www.era-online.org/" target="_blank" rel="noopener noreferrer">European Renal Association (ERA)</a></li>
          <li><a href="https://kdigo.org/" target="_blank" rel="noopener noreferrer">KDIGO</a></li>
          <li><a href="https://www.edtnaerca.org/" target="_blank" rel="noopener noreferrer">EDTNA/ERCA (International Nurses)</a></li>
          <li><a href="https://ekpf.eu/" target="_blank" rel="noopener noreferrer">European Kidney Patients' Federation (EKPF)</a></li>
          <li><a href="https://www.ifkf-wka.org/" target="_blank" rel="noopener noreferrer">IFKF-WKA (World Kidney Alliance)</a></li>
          <li><a href="https://academy.theisn.org/" target="_blank" rel="noopener noreferrer">ISN Academy (Education)</a></li>
          <li><a href="https://www.era-online.org/education/" target="_blank" rel="noopener noreferrer">ERA Education</a></li>
          <li><a href="https://kdigo.org/education/" target="_blank" rel="noopener noreferrer">KDIGO Education</a></li>
          <li><a href="https://www.nephjc.com/" target="_blank" rel="noopener noreferrer">NSMC (Social Media Collective)</a></li>
        </ul>
        <button class="show-more-btn no-print" type="button">Zobraziť viac</button>
      </div>

      <div class="widget">
        <h3>Organizácie nefrologických sestier</h3>
        <ul class="expandable-list" data-limit="10">
          <li><a href="https://www.sksapa.sk/o-komore/odborne-sekcie/sekcia-sestier-pracujucich-v-nefrologii/" target="_blank" rel="noopener noreferrer">Slovensko (SKSaPA)</a></li>
          <li><a href="https://www.cnna.cz/sekce-a-regiony/sekce-nefrologicko-urologicka/" target="_blank" rel="noopener noreferrer">Česko (ČAS)</a></li>
          <li><a href="https://www.annanurse.org/" target="_blank" rel="noopener noreferrer">USA (ANNA)</a></li>
          <li><a href="https://cannt-acitn.ca/" target="_blank" rel="noopener noreferrer">Kanada (CANNT)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://pspn.pl/" target="_blank" rel="noopener noreferrer">Poľsko (PSPN)</a></li>
          <li><a href="http://www.nephrologia.hu/" target="_blank" rel="noopener noreferrer">Maďarsko (MANET)</a></li>
          <li><a href="https://www.nephrologie.at/" target="_blank" rel="noopener noreferrer">Rakúsko (ÖGN)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="https://ndthd.org.tr/" target="_blank" rel="noopener noreferrer">Turecko (TNDTHD)</a></li>
          <li><a href="https://www.fnb-ev.de/" target="_blank" rel="noopener noreferrer">Nemecko (fnb)</a></li>
          <li><a href="https://www.afidtn.com/" target="_blank" rel="noopener noreferrer">Francúzsko (AFIDTN)</a></li>
          <li><a href="https://annuk.org/" target="_blank" rel="noopener noreferrer">Spojené kráľovstvo (ANN-UK)</a></li>
          <li><a href="https://www.siin.it/" target="_blank" rel="noopener noreferrer">Taliansko (SIIN)</a></li>
          <li><a href="https://www.seden.org/" target="_blank" rel="noopener noreferrer">Španielsko (SEDEN)</a></li>
          <li><a href="https://www.srnefro.ro/" target="_blank" rel="noopener noreferrer">Rumunsko (SRN)</a></li>
          <li><a href="https://www.venvn.nl/afdelingen/nefrologie/" target="_blank" rel="noopener noreferrer">Holandsko (V&VN)</a></li>
          <li><a href="https://www.bvnv.be/" target="_blank" rel="noopener noreferrer">Belgicko (BVNV)</a></li>
          <li><a href="https://helina.gr/" target="_blank" rel="noopener noreferrer">Grécko (HELNNA)</a></li>
          <li><a href="https://www.snsf.eu/" target="_blank" rel="noopener noreferrer">Švédsko (SNSF)</a></li>
          <li><a href="https://www.apen.org.pt/" target="_blank" rel="noopener noreferrer">Portugalsko (APEN)</a></li>
          <li><a href="https://nursing-bg.com/" target="_blank" rel="noopener noreferrer">Bulharsko (BAHPN)</a></li>
          <li><a href="https://www.lns-nefro.dk/" target="_blank" rel="noopener noreferrer">Dánsko (LNS)</a></li>
          <li><a href="https://shhy.fi/" target="_blank" rel="noopener noreferrer">Fínsko (SNHY)</a></li>
          <li><a href="https://www.nsf.no/faggrupper/nefrologiske" target="_blank" rel="noopener noreferrer">Nórsko (NSF)</a></li>
          <li><a href="https://inna-ireland.com/" target="_blank" rel="noopener noreferrer">Írsko (INNA)</a></li>
          <li><a href="https://www.hdndt.org/" target="_blank" rel="noopener noreferrer">Chorvátsko (HDNDT)</a></li>
          <li><a href="https://lndta.lt/" target="_blank" rel="noopener noreferrer">Litva (LNDTA)</a></li>
          <li><a href="https://www.zbornica-zveza.si/" target="_blank" rel="noopener noreferrer">Slovinsko (Zbornica)</a></li>
          <li><a href="https://masuasociacija.lv/" target="_blank" rel="noopener noreferrer">Lotyšsko (LMA)</a></li>
          <li><a href="https://www.ena.ee/" target="_blank" rel="noopener noreferrer">Estónsko (ENA)</a></li>
          <li><a href="https://cynma.com/" target="_blank" rel="noopener noreferrer">Cyprus (CYNMA)</a></li>
        </ul>
        <button class="show-more-btn no-print" type="button">Zobraziť viac</button>
      </div>

      <div class="widget">
        <h3>Pacientske organizácie</h3>
        <ul class="expandable-list" data-limit="10">
          <li><a href="https://sdat.sk/" target="_blank" rel="noopener noreferrer">Slovensko (SDaT)</a></li>
          <li><a href="https://www.ledviny.cz/" target="_blank" rel="noopener noreferrer">Česko (Společnost RTCH)</a></li>
          <li><a href="https://www.kidney.org/" target="_blank" rel="noopener noreferrer">USA (NKF)</a></li>
          <li><a href="https://kidney.ca/" target="_blank" rel="noopener noreferrer">Kanada (Kidney Foundation)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://osod.info/" target="_blank" rel="noopener noreferrer">Poľsko (OSOD)</a></li>
          <li><a href="https://vese-alapitvany.hu/" target="_blank" rel="noopener noreferrer">Maďarsko (MVA)</a></li>
          <li><a href="https://www.argeniere.at/" target="_blank" rel="noopener noreferrer">Rakúsko (ARGE Niere)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="https://www.tbv.com.tr/" target="_blank" rel="noopener noreferrer">Turecko (TBV)</a></li>
          <li><a href="https://www.bundesverband-niere.de/" target="_blank" rel="noopener noreferrer">Nemecko (BV Niere)</a></li>
          <li><a href="https://www.francerein.org/" target="_blank" rel="noopener noreferrer">Francúzsko (France Rein)</a></li>
          <li><a href="https://www.kidneycareuk.org/" target="_blank" rel="noopener noreferrer">Spojené kráľovstvo (Kidney Care UK)</a></li>
          <li><a href="https://www.aned-onlus.it/" target="_blank" rel="noopener noreferrer">Taliansko (ANED)</a></li>
          <li><a href="https://alcer.org/" target="_blank" rel="noopener noreferrer">Španielsko (ALCER)</a></li>
          <li><a href="https://apar.ro/" target="_blank" rel="noopener noreferrer">Rumunsko (APAR)</a></li>
          <li><a href="https://nierstichting.nl/" target="_blank" rel="noopener noreferrer">Holandsko (Nierstichting)</a></li>
          <li><a href="https://fenier-fabir.be/" target="_blank" rel="noopener noreferrer">Belgicko (Fenier-Fabir)</a></li>
          <li><a href="https://pasyno.gr/" target="_blank" rel="noopener noreferrer">Grécko (PASYNEF)</a></li>
          <li><a href="https://njurforbundet.se/" target="_blank" rel="noopener noreferrer">Švédsko (Njurförbundet)</a></li>
          <li><a href="https://www.apir.org.pt/" target="_blank" rel="noopener noreferrer">Portugalsko (APIR)</a></li>
          <li><a href="https://apbz.org/" target="_blank" rel="noopener noreferrer">Bulharsko (BUTD)</a></li>
          <li><a href="https://nyreforeningen.dk/" target="_blank" rel="noopener noreferrer">Dánsko (Nyreforeningen)</a></li>
          <li><a href="https://www.munuaisjamaksaliitto.fi/" target="_blank" rel="noopener noreferrer">Fínsko (Munuais- ja maksaliitto)</a></li>
          <li><a href="https://www.lnt.no/" target="_blank" rel="noopener noreferrer">Nórsko (LNT)</a></li>
          <li><a href="https://ika.ie/" target="_blank" rel="noopener noreferrer">Írsko (IKA)</a></li>
          <li><a href="https://transplant.hr/" target="_blank" rel="noopener noreferrer">Chorvátsko (HUT)</a></li>
          <li><a href="https://geraviltis.lt/" target="_blank" rel="noopener noreferrer">Litva (Gera viltis)</a></li>
          <li><a href="https://zdlbs.si/" target="_blank" rel="noopener noreferrer">Slovinsko (ZDLBS)</a></li>
          <li><a href="https://niere.lv/" target="_blank" rel="noopener noreferrer">Lotyšsko (Nieras.lv)</a></li>
          <li><a href="https://neer.ee/" target="_blank" rel="noopener noreferrer">Estónsko (ENL)</a></li>
          <li><a href="https://www.nek.org.cy/" target="_blank" rel="noopener noreferrer">Cyprus (CKA)</a></li>
        </ul>
        <button class="show-more-btn no-print" type="button">Zobraziť viac</button>
      </div>

      <div class="widget">
        <h3>Vzdelávacie inštitúcie</h3>
        <ul class="expandable-list" data-limit="10">
          <li><a href="https://eszu.sk/" target="_blank" rel="noopener noreferrer">Slovensko (SZU)</a></li>
          <li><a href="https://www.fmed.uniba.sk/" target="_blank" rel="noopener noreferrer">Slovensko (LF UK Bratislava)</a></li>
          <li><a href="https://www.jfmed.uniba.sk/" target="_blank" rel="noopener noreferrer">Slovensko (JLF UK Martin)</a></li>
          <li><a href="https://www.upjs.sk/lekarska-fakulta/" target="_blank" rel="noopener noreferrer">Slovensko (LF UPJŠ Košice)</a></li>
          <li><a href="https://www.ipvz.cz/" target="_blank" rel="noopener noreferrer">Česko (IPVZ)</a></li>
          <li><a href="https://www.lf1.cuni.cz/" target="_blank" rel="noopener noreferrer">Česko (1. LF UK Praha)</a></li>
          <li><a href="https://www.lf2.cuni.cz/" target="_blank" rel="noopener noreferrer">Česko (2. LF UK Praha)</a></li>
          <li><a href="https://www.lf3.cuni.cz/" target="_blank" rel="noopener noreferrer">Česko (3. LF UK Praha)</a></li>
          <li><a href="https://www.med.muni.cz/" target="_blank" rel="noopener noreferrer">Česko (LF MU Brno)</a></li>
          <li><a href="https://www.lf.upol.cz/" target="_blank" rel="noopener noreferrer">Česko (LF UPOL Olomouc)</a></li>
          <li><a href="https://www.lfp.cuni.cz/" target="_blank" rel="noopener noreferrer">Česko (LF UK Plzeň)</a></li>
          <li><a href="https://www.lfhk.cuni.cz/" target="_blank" rel="noopener noreferrer">Česko (LF UK Hradec Králové)</a></li>
          <li><a href="https://lf.osu.cz/" target="_blank" rel="noopener noreferrer">Česko (LF OU Ostrava)</a></li>
          <li><a href="https://www.asn-online.org/education/" target="_blank" rel="noopener noreferrer">USA (ASN Education)</a></li>
          <li><a href="https://www.csn-scn.ca/education/" target="_blank" rel="noopener noreferrer">Kanada (CSN Education)</a></li>
          <!-- Susedia Slovenska podľa počtu obyvateľov -->
          <li><a href="https://www.gov.pl/web/zdrowie/ksztalcenie-podyplomowe-kadr-medycznych" target="_blank" rel="noopener noreferrer">Poľsko (CMKP)</a></li>
          <li><a href="https://semmelweis.hu/nefrologia/" target="_blank" rel="noopener noreferrer">Maďarsko (Semmelweis University)</a></li>
          <li><a href="https://www.meduniwien.ac.at/" target="_blank" rel="noopener noreferrer">Rakúsko (MedUni Wien)</a></li>
          <!-- Ostatné krajiny podľa počtu obyvateľov -->
          <li><a href="https://nefroloji.org.tr/tr/egitim/" target="_blank" rel="noopener noreferrer">Turecko (TND Eğitim)</a></li>
          <li><a href="https://www.dgfn.eu/akademie.html" target="_blank" rel="noopener noreferrer">Nemecko (Akademie DGfN)</a></li>
          <li><a href="https://www.sfndt.org/formation" target="_blank" rel="noopener noreferrer">Francúzsko (SFNDT Formation)</a></li>
          <li><a href="https://ukkidney.org/education" target="_blank" rel="noopener noreferrer">Spojené kráľovstvo (UKKA Education)</a></li>
          <li><a href="https://sinitaly.org/formazione/" target="_blank" rel="noopener noreferrer">Taliansko (SIN Formazione)</a></li>
          <li><a href="https://www.senefro.org/modules.php?name=webinar" target="_blank" rel="noopener noreferrer">Španielsko (S.E.N. Formación)</a></li>
          <li><a href="https://www.srnefro.ro/cursuri" target="_blank" rel="noopener noreferrer">Rumunsko (SRN Cursuri)</a></li>
          <li><a href="https://www.nefro.nl/nascholing" target="_blank" rel="noopener noreferrer">Holandsko (NfN Nascholing)</a></li>
          <li><a href="https://www.bvnv.be/education/" target="_blank" rel="noopener noreferrer">Belgicko (BVNV Education)</a></li>
          <li><a href="https://www.ene.gr/index.php/ekpaidefsi" target="_blank" rel="noopener noreferrer">Grécko (ENE Education)</a></li>
          <li><a href="https://njurmed.com/utbildning/" target="_blank" rel="noopener noreferrer">Švédsko (SNF Utbildning)</a></li>
          <li><a href="https://www.spnefro.pt/formacao" target="_blank" rel="noopener noreferrer">Portugalsko (SPN Formação)</a></li>
          <li><a href="https://bgnephrology.com/education" target="_blank" rel="noopener noreferrer">Bulharsko (BNA Education)</a></li>
          <li><a href="https://nephrology.dk/uddannelse/" target="_blank" rel="noopener noreferrer">Dánsko (DNS Uddannelse)</a></li>
          <li><a href="https://www.sny.fi/koulutus/" target="_blank" rel="noopener noreferrer">Fínsko (SNY Koulutus)</a></li>
          <li><a href="https://www.nephro.no/utdanning" target="_blank" rel="noopener noreferrer">Nórsko (NNF Utdanning)</a></li>
          <li><a href="https://irishnephrology.ie/education/" target="_blank" rel="noopener noreferrer">Írsko (INS Education)</a></li>
          <li><a href="https://www.hdndt.org/edukacija" target="_blank" rel="noopener noreferrer">Chorvátsko (HDNDT Edukacija)</a></li>
          <li><a href="https://lndta.lt/mokymai/" target="_blank" rel="noopener noreferrer">Litva (LNDTA Mokymai)</a></li>
          <li><a href="https://www.nephro-slovenia.si/srecanja/aktualna-srecanja-in-dogodki" target="_blank" rel="noopener noreferrer">Slovinsko (SND Izobraževanje)</a></li>
          <li><a href="https://nefrologs.lv/izglitiba" target="_blank" rel="noopener noreferrer">Lotyšsko (LNA Izglītība)</a></li>
          <li><a href="https://nefro.ee/koolitus/" target="_blank" rel="noopener noreferrer">Estónsko (ENS Koolitus)</a></li>
          <li><a href="https://www.nek.org.cy/education" target="_blank" rel="noopener noreferrer">Cyprus (CRA Education)</a></li>
          <!-- Medzinárodné vzdelávacie inštitúcie -->
          <li class="list-item-separator"><a href="https://academy.theisn.org/" target="_blank" rel="noopener noreferrer">ISN Academy</a></li>
          <li><a href="https://www.era-online.org/education/" target="_blank" rel="noopener noreferrer">ERA Education</a></li>
          <li><a href="https://kdigo.org/education/" target="_blank" rel="noopener noreferrer">KDIGO Education</a></li>
          <li><a href="https://www.nephjc.com/" target="_blank" rel="noopener noreferrer">NephJC (Nephrology Journal Club)</a></li>
          <li><a href="https://www.edtnaerca.org/education" target="_blank" rel="noopener noreferrer">EDTNA/ERCA Education</a></li>
        </ul>
        <button class="show-more-btn no-print" type="button">Zobraziť viac</button>
      </div>
    </aside>
  </main>

  <?php include "footer.php"; ?>
