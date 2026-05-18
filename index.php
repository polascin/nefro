<?php
require_once "auth.php";
require_once "db_config.php";
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
try {
    $stmtTop = $pdo->query(
        "SELECT id, title, slug, author, excerpt, published_at
         FROM articles WHERE is_top = 1 AND is_published = 1
         ORDER BY sort_order ASC, published_at DESC",
    );
    $topArticles = $stmtTop->fetchAll();

    $stmtOtherCount = $pdo->query(
        "SELECT COUNT(*)
     FROM articles WHERE is_top = 0 AND is_published = 1",
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
} catch (\PDOException $e) {
    error_log("index.php – chyba pri načítaní článkov: " . $e->getMessage());
}

$projectPublicStats = getProjectPublicStats($pdo);

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$isPaginated = $otherArticlesPage > 1;
$firstArticleForSeo = $topArticles[0] ?? ($otherArticles[0] ?? null);

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

      <?php if (!empty($topArticles)): ?>
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

      <?php if (!empty($otherArticles)): ?>
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

      <?php if (empty($topArticles) && empty($otherArticles)): ?>
      <div class="primary-article">
        <p>Žiadne články ešte neboli zverejnené.</p>
        <?php if (isAdmin()): ?>
          <a href="admin_articles.php" class="btn-primary">Pridať prvý článok</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <!-- Sekcia Služby -->
      <section class="features-section" id="sluzby">
        <h2>Poskytované služby a expertíza</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Nefrológia a Dialýza</h3>
            <p>
              Komplexná starostlivosť. Špecializácia na liečbu obličkových chorôb, renálnu nahradzujúcu liečbu (hemodialýza, hemodiafiltrácia, peritoneálna dialýza), ultrasonografiu orgánov brucha so zameraním na uropoetický systém, ultrasonografiu cievnych prístupov a mimotelové eliminačné metódy.
            </p>
          </div>
          <div class="feature-card">
            <h3>Lektorstvo a vzdelávanie</h3>
            <p>
              Rozsiahle skúsenosti s výučbou a odborným prednášaním predovšetkým v oblasti nefrológie a vnútorného lekárstva pre odbornú ale aj laickú verejnosť. Dlhodobá spolupráca s univerzitnými pracoviskami ako aj so spoločnosťami zaoberajúcimi sa vzdelávaním zdravotníckeho personálu.
            </p>
          </div>
          <div class="feature-card">
            <h3>Medicínske preklady</h3>
            <p>
              Špecializované preklady medicínskych dokumentov a lokalizácia softvéru (AJ/SJ) s maximálnym dôrazom na presnú klinickú terminológiu. Preklady sú vždy na vysokej odbornej úrovni, bez gramatických chýb a s dôrazom na detail.
            </p>
          </div>
          <div class="feature-card">
            <h3>IT a AI riešenia</h3>
            <p>
              Vývoj na mieru šitých medicínskych aplikácií, integrácia AI nástrojov pre spracovanie dát a modernizácia zdravotníckych systémov.
            </p>
          </div>
        </div>
      </section>

      <!-- Sekcia O mne -->
      <section class="features-section" id="o-mne">
        <h2>O mne</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Kto som</h3>
            <p>
              Som <strong>interdisciplinárny tvorca</strong>, ktorý spája medicínu, technológie, jazyk a ideové myslenie. Nie som len lekár alebo len autor. Pôsobím na styku viacerých svetov a prepájam ich do praktických výstupov.
            </p>
          </div>
          <div class="feature-card">
            <h3>Ako sa vnímam</h3>
            <ul>
              <li><strong>som lekár</strong> so špecializovaným odborným zázemím v nefrológii, dialýze a internej medicíne</li>
              <li><strong>som tvorca textov</strong>, ktorý kladie dôraz na presnosť, štýl, význam a jazyk</li>
              <li><strong>som prekladateľ a jazykový pracovník</strong>, citlivý na formulácie a významové odtiene</li>
              <li><strong>som technologický praktik</strong>, ktorý vie programovať a tvoriť weby či aplikácie</li>
              <li><strong>som AI nadšenec</strong>, pre ktorého umelá inteligencia nie je len hračka, ale pracovný, tvorivý a systémový nástroj</li>
              <li><strong>som človek s filozofickým a duchovným presahom</strong>, ktorý sa zaujíma nielen o funkčnosť vecí, ale aj o ich zmysel</li>
            </ul>
          </div>
          <div class="feature-card">
            <h3>Čo robím</h3>
            <p>
              <strong>Prepájam odbornosť s tvorbou.</strong> Využívam medicínske poznanie, jazyk, technológie a organizačné myslenie na tvorbu textov, webov, dokumentov, projektov, aplikácií a širších koncepcií.
            </p>
            <p>
              <strong>Transformujem poznanie do použiteľnej podoby.</strong> Nezostávam pri teórii. Zaujíma ma, ako myšlienku pretaviť do článku, dokumentu, systému, platformy, služby alebo inštitucionálneho projektu.
            </p>
            <p>
              <strong>Budujem mosty medzi disciplínami.</strong> Medicína, kód, poézia, metafyzika, spiritualita a AI pre mňa nie sú oddelené ostrovy, ale súčasť vlastného pracovného a intelektuálneho ekosystému.
            </p>
          </div>
          <div class="feature-card">
            <h3>Stručne o mne</h3>
            <p>
              Som medicínsky odborník, tvorca a technologický integrátor s výrazným jazykovým, filozofickým a duchovným presahom. Moja práca stojí na prepájaní presnosti, tvorivosti a praktického využitia poznania.
            </p>
            <p>
              <strong>Lekár, autor, technológ a mysliteľ, ktorý premieňa odborné poznanie na praktické a zmysluplné systémy.</strong>
            </p>
          </div>
        </div>
      </section>

      <!-- Ďalšia nezávislá <section> v hlavnom obsahu -->
      <section class="features-section" id="kontakt">
        <h2>Kontakty a spolupráca</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Máte otázky alebo sa chcete zapojiť?</h3>
            <p>
              Radi uvítame akúkoľvek formu diskusie, spolupráce či dotazov. Neváhajte nás kedykoľvek kontaktovať.
            </p>
            <a href="mailto:nefro@polascin.net" class="btn-primary">Napísať e-mail</a>
          </div>
          <div class="feature-card">
            <h3>Staňte sa súčasťou komunity</h3>
            <p>
              Zaregistrujte sa a získajte prístup k obsahu. Pri registrácii si môžete zvoliť súhlas so zasielaním noviniek a my vás budeme ihneď informovať o najnovších príspevkoch a analýzach.
            </p>
            <?php if (!isLoggedIn()): ?>
              <br><a href="register.php" class="btn-primary mt-15 d-inline-block">Registrovať sa</a>
            <?php else: ?>
              <div class="badge-highlight">Ste prihlásený</div>
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
              <span><?= htmlspecialchars($authorName, ENT_QUOTES, "UTF-8") ?></span>
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
