<?php
require_once 'auth.php';
require_once 'db_config.php';

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
    <title>Kalkulačky KDIGO 2024 CKD - Nefro-projekt Slovensko</title>
    <script src="theme.js?v=20260511-1&cb=<?= filemtime('theme.js') ?>"></script>
    <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
    <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Kalkulačky';
    $headerIntro = 'Klinické výpočty podľa KDIGO 2024 pre CKD';
    $showLogo = false;
    include 'header.php';
    ?>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="index.php#sluzby">Služby</a></li>
                <li><a href="index.php#o-nas">O nás</a></li>
                <li><a href="index.php#kontakt">Kontakt</a></li>
                <li><a href="calculators.php" class="active" aria-current="page">Kalkulačky</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="admin.php">Admin panel</a></li>
                        <li><a href="admin_articles.php">Správa článkov</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Odhlásiť sa (<?= htmlspecialchars($_SESSION['username'] ?? 'Profil') ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Prihlásenie</a></li>
                    <li><a href="register.php">Registrácia</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <section class="primary-article">
                <h2>Kalkulačky KDIGO 2024 CKD</h2>
                <p>
                    Výpočty sú určené na orientačnú podporu klinického rozhodovania. Údaje pacienta
                    (meno, priezvisko, dátum narodenia, rodné číslo, kód zdravotnej poisťovne) sú voliteľné.
                    Údaje potrebné pre výpočet sú povinné.
                </p>
                <p>
                    Prihlásený používateľ môže výsledok uložiť do databázy. Uložené výsledky sa zobrazia
                    v spodnej časti každej kalkulačky s možnosťou vytlačenia alebo vymazania.
                </p>
            </section>

            <section class="features-section">
                <h3>Dostupné podstránky</h3>
                <div class="features-grid calculators-grid">
                    <article class="feature-card calculator-card">
                        <h4>eGFR (CKD-EPI 2021)</h4>
                        <p>Výpočet odhadovanej glomerulovej filtrácie z veku, pohlavia a kreatinínu.</p>
                        <a href="calculator_egfr.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h4>KDIGO G/A riziko CKD</h4>
                        <p>Zaradenie do G a A kategórie a orientačný rizikový stupeň podľa KDIGO mapy.</p>
                        <a href="calculator_kdigo_risk.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h4>KFRE — Kidney Failure Risk Equation</h4>
                        <p>Predikcia rizika potreby dialýzy alebo transplantácie obličky na 2 a 5 rokov (Tangri 4-parametrová).</p>
                        <a href="calculator_kfre.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>

                    <article class="feature-card calculator-card">
                        <h4>CKD-PC — Grams 2022 (3-ročné riziko)</h4>
                        <p>Odhad 3-ročného rizika poklesu eGFR o ≥40 % alebo zlyhania obličiek — platné pre všetky štádiá CKD vrátane G1–G2. Rozšírený model s 13+ vstupmi.</p>
                        <a href="calculator_ckdpc.php" class="btn-primary">Otvoriť kalkulačku</a>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
