<?php
require_once 'auth.php';

header_remove('X-Powered-By');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

$pageLastUpdated = date('d.m.Y H:i', filemtime(__FILE__));
$pageTimeZone = date('T') . ' (' . date_default_timezone_get() . ')';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulacky KDIGO 2024 CKD - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskocit na hlavny obsah</a>

    <?php
    $headerTitle = 'Kalkulacky';
    $headerIntro = 'Klinicke vypocty podla KDIGO 2024 pre CKD';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavna navigacia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="index.php#sluzby">Sluzby</a></li>
                <li><a href="index.php#o-nas">O nas</a></li>
                <li><a href="index.php#kontakt">Kontakt</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulacky</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="admin.php">Admin panel</a></li>
                        <li><a href="admin_articles.php">Sprava clankov</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Odhlasit sa (<?= htmlspecialchars($_SESSION['username'] ?? 'Profil') ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Prihlasenie</a></li>
                    <li><a href="register.php">Registracia</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <section class="primary-article">
                <h2>Kalkulacky KDIGO 2024 CKD</h2>
                <p>
                    Vypocty su urcene na orientacnu podporu klinickeho rozhodovania. Udaje pacienta
                    (meno, priezvisko, datum narodenia, rodne cislo, kod zdravotnej poistovne) su volitelne.
                    Udaje potrebne pre vypocet su povinne.
                </p>
                <p>
                    Prihlaseny pouzivatel moze vysledok ulozit do databazy. Ulozene vysledky sa zobrazia
                    v spodnej casti kazdej kalkulacky s moznostou vytlace alebo vymazania.
                </p>
            </section>

            <section class="features-section">
                <h3>Dostupne podstranky</h3>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h4>eGFR (CKD-EPI 2021)</h4>
                        <p>Vypocet odhadovanej glomerulovej filtracie z veku, pohlavia a kreatininu.</p>
                        <a href="calculator_egfr.php" class="btn-primary">Otvorit kalkulacku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h4>KDIGO G/A riziko CKD</h4>
                        <p>Zaradenie do G a A kategorie a orientacny rizikovy stupen podla KDIGO mapy.</p>
                        <a href="calculator_kdigo_risk.php" class="btn-primary">Otvorit kalkulacku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h4>KFRE — Kidney Failure Risk Equation</h4>
                        <p>Predikcia rizika potreby dialýzy alebo transplantácie obličky na 2 a 5 rokov (Tangri 4-parametrová).</p>
                        <a href="calculator_kfre.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
