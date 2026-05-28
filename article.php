<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

// Načítanie parametra – akceptujeme len slug alebo id
$article = null;
$notFound = false;

$rawSlug = trim((string) ($_GET["slug"] ?? ""));
$rawId = (int) ($_GET["id"] ?? 0);

try {
    if ($rawSlug !== "") {
        // Validácia: slug smie obsahovať len písmená, číslice a pomlčky
        if (!preg_match('/^[a-z0-9\-]{1,500}$/i', $rawSlug)) {
            $notFound = true;
        } else {
            $stmt = $pdo->prepare(
                "SELECT * FROM articles WHERE slug = :slug AND is_published = 1 LIMIT 1",
            );
            $stmt->execute(["slug" => $rawSlug]);
            $article = $stmt->fetch() ?: null;
        }
    } elseif ($rawId > 0) {
        $stmt = $pdo->prepare(
            "SELECT * FROM articles WHERE id = :id AND is_published = 1 LIMIT 1",
        );
        $stmt->execute(["id" => $rawId]);
        $article = $stmt->fetch() ?: null;
    } else {
        $notFound = true;
    }
} catch (\PDOException $e) {
    error_log("article.php DB error: " . $e->getMessage());
    $notFound = true;
}

if ($article === null && !$notFound) {
    $notFound = true;
}

if ($notFound || $article === null) {
    http_response_code(404);
    header("X-Robots-Tag: noindex, follow", true);
}

$projectPublicStats = getProjectPublicStats($pdo);

// Formátovanie dátumu
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

function formatArticleDate(string $datetime, array $months): string
{
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
    int $maxLen = 165,
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

function toIso8601(string $datetime): string
{
    $ts = strtotime($datetime);
    if (!$ts) {
        return date(DATE_ATOM);
    }
    return date(DATE_ATOM, $ts);
}

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";

$articleTitleRaw = $article ? (string) ($article["title"] ?? "") : "";
$articleAuthorRaw = $article
    ? (string) ($article["author"] ?? "MUDr. Ľubomír Polaščín")
    : "MUDr. Ľubomír Polaščín";
$canonicalUrlRaw = $article
    ? $baseUrl . "article.php?slug=" . (string) ($article["slug"] ?? "")
    : "";

$metaDescriptionRaw = $article
    ? buildSeoExcerpt(
        (string) ($article["excerpt"] ?? ""),
        (string) ($article["content"] ?? ""),
        165,
    )
    : "Požadovaný článok neexistuje alebo bol odstránený.";
if ($metaDescriptionRaw === "") {
    $metaDescriptionRaw = "Odborný článok z oblasti nefrológie.";
}

$pageTitleRaw = $article
    ? $articleTitleRaw . " | " . $siteName
    : "Článok nenájdený | " . $siteName;
// POZNÁMKA: $pageTitle, $canonicalUrl a $seoDescription sa NEpre-escapujú.
// head_meta.php ich escapuje sám cez htmlspecialchars() — dvojité escapovanie
// by spôsobilo, že & → &amp;amp; a znaky sa stratia v title/canonical/description.
$pageTitle = $pageTitleRaw; // head_meta.php: htmlspecialchars($pageTitle)
$canonicalUrl = $canonicalUrlRaw; // head_meta.php: htmlspecialchars($canonicalUrl)
// $metaDescriptionRaw sa odovzdá priamo ako $seoDescription (pozri nižšie v <head>)
$pageLastUpdated     = $article
    ? date("d.m.Y H:i", strtotime((string) $article["updated_at"]))
    : date("d.m.Y H:i", filemtime(__FILE__));
$pageTimeZone        = date("T") . " (" . date_default_timezone_get() . ")";
$usePageLastUpdated  = true; // zachovaj dátum článku, nie deploy timestamp
$robotsMeta = $article
    ? "index, follow, max-image-preview:large"
    : "noindex, follow, noarchive";

$articleSchema = null;
if ($article) {
    $articleSchema = [
        "@context" => "https://schema.org",
        "@type" => ["Article", "MedicalWebPage"],
        "headline" => $articleTitleRaw,
        "description" => $metaDescriptionRaw,
        "inLanguage" => "sk-SK",
        "mainEntityOfPage" => $canonicalUrlRaw,
        "url" => $canonicalUrlRaw,
        "datePublished" => toIso8601((string) ($article["published_at"] ?? "")),
        "dateModified" => toIso8601(
            (string) ($article["updated_at"] ??
                ($article["published_at"] ?? "")),
        ),
        "medicalSpecialty" => "Nephrology",
        "audience" => [
            "@type" => "MedicalAudience",
            "audienceType" => "Clinician",
        ],
        "author" => [
            "@type" => "Person",
            "name" => $articleAuthorRaw,
            "sameAs" => "https://polascin.com/",
        ],
        "publisher" => [
            "@type" => "MedicalOrganization",
            "name" => $siteName,
            "url" => $baseUrl,
            // Logo pre Schema.org publisher – GIF logo (portálové id, malé rozmery sú OK pre logo)
            "logo" => [
                "@type" => "ImageObject",
                "url" => $baseUrl . "img/nps-logo.gif",
                "width" => 200,
                "height" => 200,
            ],
        ],
        // Primárny obrázok článku – Schema.org Article vyžaduje min. 1200 px šírku
        "image" => [
            "@type" => "ImageObject",
            "url" => $baseUrl . "img/og-default.jpg",
            "width" => 1200,
            "height" => 630,
        ],
    ];
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  // Mapovanie premenných pre head_meta.php — odovzdávame RAW (neescapované) hodnoty.
  // head_meta.php aplikuje htmlspecialchars() na každý výstup sám.
  $seoDescription = $metaDescriptionRaw;
  $seoKeywords =
      "nefrológia, CKD, chronické ochorenie obličiek, KDIGO, dialýza, transplantácia obličiek, Slovensko, " .
      $articleTitleRaw;
  $ogType = $article ? "article" : "website";

  $structuredData = [];
  if ($articleSchema) {
      $structuredData[] = $articleSchema;
  }

  // BreadcrumbList — všetky URL musia byť RAW (nie HTML-escaped), json_encode() ich správne zakóduje.
  $structuredData[] = [
      "@context" => "https://schema.org",
      "@type" => "BreadcrumbList",
      "itemListElement" => [
          [
              "@type" => "ListItem",
              "position" => 1,
              "name" => "Domov",
              "item" => $baseUrl,
          ],
          [
              "@type" => "ListItem",
              "position" => 2,
              "name" => $articleTitleRaw,
              "item" => $canonicalUrlRaw,
          ],
      ],
  ];

  include "head_meta.php";
  ?>
  <?php if ($article): ?>
  <meta property="article:published_time" content="<?= htmlspecialchars(
      toIso8601((string) ($article["published_at"] ?? "")),
      ENT_QUOTES,
  ) ?>">
  <meta property="article:modified_time" content="<?= htmlspecialchars(
      toIso8601(
          (string) ($article["updated_at"] ?? ($article["published_at"] ?? "")),
      ),
      ENT_QUOTES,
  ) ?>">
  <meta property="article:author" content="<?= htmlspecialchars(
      $articleAuthorRaw,
      ENT_QUOTES,
  ) ?>">
  <?php endif; ?>
</head>

<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

  <?php
  $headerTitle = "Nefro-projekt Slovensko";
  $headerIntro =
      "Dynamická renesancia nefrológie: Od molekulárnej biológie po umelú inteligenciu.";
  $showLogo = true;
  include "header.php";
  ?>

  <?php include 'main_nav.php'; ?>

  <main id="main-content" class="container main-content" role="main">
    <div class="content-wrapper">
      <?php if ($notFound || $article === null): ?>
        <article class="primary-article">
          <header>
            <h2>Článok nenájdený</h2>
          </header>
          <p>Požadovaný článok neexistuje alebo bol odstránený.</p>
          <a href="index.php" class="btn-primary">← Späť na úvodnú stránku</a>
        </article>

      <?php /* Dôverované HTML — správuje iba admin */
          else:
          $pubDate = (string) $article["published_at"];
          $pubDateIso = htmlspecialchars(substr($pubDate, 0, 10));
          $pubDateSk = formatArticleDate($pubDate, $months);
          $isTop = (int) $article["is_top"] === 1;
          ?>

        <article class="primary-article" itemscope itemtype="https://schema.org/Article">
          <?php if ($isTop): ?>
            <span class="badge-top" aria-label="Odporúčaný článok">★ TOP</span>
          <?php endif; ?>
          <header>
            <h2 itemprop="headline"><?= htmlspecialchars(
                (string) $article["title"],
            ) ?></h2>
            <p class="meta">
              Publikované:&nbsp;
              <time datetime="<?= $pubDateIso ?>" itemprop="datePublished"><?= htmlspecialchars(
    $pubDateSk,
) ?></time>
            </p>
          </header>

          <?= $article["content"]
          /* Dôverované HTML — správuje iba admin */
          ?>

          <footer>
            <p class="author">
              Autor: <span class="authorname"><?= htmlspecialchars(
                  (string) $article["author"],
              ) ?></span>
            </p>
            <?php if (isAdmin()): ?>
              <p class="article-admin-actions">
                <a href="admin_articles.php?action=edit&id=<?= (int) $article[
                    "id"
                ] ?>" class="btn-secondary-small">✏️ Upraviť článok</a>
              </p>
            <?php endif; ?>
          </footer>
        </article>

        <div class="newsletter-cta-inline" id="nl-cta-inline">
          <div class="newsletter-cta__inner">
            <h3 class="newsletter-cta__title">Dostávajte nové odborné články priamo do e-mailu</h3>
            <p class="newsletter-cta__desc">Bezplatný odber. Odhlásite sa kedykoľvek jedným klikom.</p>
            <form class="newsletter-cta__form" id="nl-form-inline" novalidate>
              <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">
              <input type="email" name="email" placeholder="váš@email.sk" class="form-control newsletter-cta__input" required aria-label="Vaša e-mailová adresa">
              <button type="submit" class="btn-primary newsletter-cta__btn">Prihlásiť na odber</button>
            </form>
            <div class="newsletter-cta__msg" id="nl-msg-inline" hidden role="status"></div>
          </div>
        </div>

        <nav class="article-nav" aria-label="Navigácia článkov">
          <a href="index.php" class="btn-secondary-small">← Späť na zoznam článkov</a>
        </nav>

      <?php endif; ?>
    </div>

    <aside class="sidebar">
      <div class="widget">
        <h3>O projekte</h3>
        <p>
          Nefrológia sa rozvíja míľovými krokmi — od molekulárnej biológie po umelú inteligenciu.
          Sledujte najnovšie poznatky a analýzy.
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
        <a href="index.php" class="btn-primary article-back-link">Všetky články</a>
      </div>
      <div class="widget newsletter-widget">
        <h3>Odber noviniek</h3>
        <p>Dostávajte nové odborné články priamo do e-mailu — zadarmo.</p>
        <form class="newsletter-cta__form" id="nl-form-sidebar" novalidate>
          <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">
          <input type="email" name="email" placeholder="váš@email.sk" class="form-control" required aria-label="Vaša e-mailová adresa">
          <button type="submit" class="btn-primary" style="width:100%;margin-top:10px;">Prihlásiť na odber</button>
        </form>
        <div id="nl-msg-sidebar" hidden role="status" style="margin-top:10px;font-size:0.9rem;"></div>
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
          <li><a href="https://www.lns-nefro.dk/" target="_blank" rel="noopener noreferrer">Dánsko (DNS)</a></li>
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

  <script>
  (function () {
    function initNlForm(formId, msgId) {
      var form = document.getElementById(formId);
      var msg  = document.getElementById(msgId);
      if (!form || !msg) return;
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var emailInput = form.querySelector('input[type="email"]');
        var btn        = form.querySelector('button[type="submit"]');
        var email      = emailInput ? emailInput.value.trim() : '';
        if (!email) return;
        btn.disabled    = true;
        btn.textContent = 'Odosielam…';
        fetch('newsletter_subscribe.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'email=' + encodeURIComponent(email)
                + '&website=' + encodeURIComponent(form.querySelector('input[name="website"]') ? form.querySelector('input[name="website"]').value : '')
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          // innerHTML je zámerné: jedna zo správ obsahuje <a> odkaz (registered user flow).
          // Invariant: server NIKDY nevkladá user-supplied dáta do poľa message.
          msg.innerHTML = data.message || '';
          msg.hidden    = false;
          if (data.success) {
            form.hidden = true;
          } else {
            btn.disabled    = false;
            btn.textContent = 'Prihlásiť na odber';
          }
        })
        .catch(function () {
          msg.textContent = 'Nastala chyba. Skúste to neskôr.';
          msg.hidden      = false;
          btn.disabled    = false;
          btn.textContent = 'Prihlásiť na odber';
        });
      });
    }
    initNlForm('nl-form-inline',  'nl-msg-inline');
    initNlForm('nl-form-sidebar', 'nl-msg-sidebar');
  })();
  </script>

  <?php include "footer.php"; ?>
</body>
</html>
