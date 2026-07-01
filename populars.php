<?php
declare(strict_types=1);
/**
 * populars.php — Sekcia „Pre pacientov"
 * ────────────────────────────────────────────────────────────────────────────
 * Zoznam popularizačných článkov (category = 'popularne') pre poučených
 * pacientov a verejnosť. Jednoduchý jazyk, obrázky, žiadny odborný žargón.
 * Články sa renderujú cez article.php (spoločná infraštruktúra).
 *
 * Články sa delia na dve podsekcie: všeobecné pacientske články a samostatnú
 * podsekciu „Dialýza a stredisko Medimpax" (články spomínajúce Medimpax).
 * Zdieľané pomôcky a dopyty sú v patient_articles_common.php.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/patient_articles_common.php';

$months = popSkMonths();

// ── Načítanie a rozdelenie článkov (bez stránkovania — malý dataset) ──────────
$allArticles      = getPopularArticles($pdo);
$medimpaxArticles = [];
$generalArticles  = [];
foreach ($allArticles as $art) {
    if (isMedimpaxPatientArticle($art)) {
        $medimpaxArticles[] = $art;
    } else {
        $generalArticles[] = $art;
    }
}

// ── SEO ──────────────────────────────────────────────────────────────────────
$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";
$schemaOrgUrl = "https://schema.org";

$pageTitle = "Pre pacientov – zrozumiteľne o obličkách | " . $siteName;
$seoDescription = "Popularizačné články o obličkách, ich ochoreniach a liečbe — jednoduchým jazykom, s obrázkami, pre poučených pacientov a verejnosť.";
$seoKeywords = "obličky, chronické ochorenie obličiek, dialýza, pre pacientov, zrozumiteľne, zdravie obličiek, prevencia, edukácia pacientov";
$canonicalUrl = $baseUrl . "populars.php";
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
$pos = 0;
foreach ($allArticles as $art) {
    $itemListElements[] = [
        "@type" => "ListItem",
        "position" => ++$pos,
        "url" => $baseUrl . "article.php?slug=" . rawurlencode((string) $art["slug"]),
        "name" => (string) $art["title"],
    ];
}
if (!empty($itemListElements)) {
    $structuredData[] = [
        "@context" => $schemaOrgUrl,
        "@type" => "ItemList",
        "name" => "Pre pacientov",
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

      <?php if (empty($allArticles)): ?>
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

        <?php if (!empty($generalArticles)): ?>
        <section class="populars-grid-section" aria-label="Články pre pacientov">
          <ul class="populars-grid">
            <?php foreach ($generalArticles as $art) {
                popRenderCard($art, $months);
            } ?>
          </ul>
        </section>
        <?php endif; ?>

        <?php if (!empty($medimpaxArticles)): ?>
        <section class="populars-grid-section populars-subsection" aria-labelledby="medimpax-subheading">
          <h2 id="medimpax-subheading" class="populars-subheading">Dialýza a stredisko Medimpax</h2>
          <p class="populars-sublead">
            Praktické články o dialýze, nefrologickej ambulancii a transplantácii —
            a o tom, ako túto starostlivosť poskytuje
            <a href="dialyza-bratislava.php">Dialyzačné stredisko a nefrologická ambulancia Medimpax</a>
            v Bratislave-Dúbravke.
          </p>
          <ul class="populars-grid">
            <?php foreach ($medimpaxArticles as $art) {
                popRenderCard($art, $months);
            } ?>
          </ul>
        </section>
        <?php endif; ?>

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
