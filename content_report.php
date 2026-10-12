<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var PDO $pdo */

$errors = [];
$sent = false;
$contentUrl = trim((string) ($_POST['content_url'] ?? $_GET['url'] ?? ''));
$reporterName = trim((string) ($_POST['reporter_name'] ?? ''));
$reporterEmail = trim((string) ($_POST['reporter_email'] ?? ''));
$contactExemption = isset($_POST['contact_exemption']);
$legalBasis = trim((string) ($_POST['legal_basis'] ?? ''));
$explanation = trim((string) ($_POST['explanation'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Platnosť formulára vypršala. Obnovte stránku a skúste to znova.';
    }
    if (!checkFormRateLimit($pdo, 'content_report', getClientIpAddress(), 5, 3600)) {
        $errors[] = 'Bolo odoslaných priveľa oznámení. Skúste to neskôr.';
    }
    if ($contentUrl === '' || filter_var($contentUrl, FILTER_VALIDATE_URL) === false) {
        $errors[] = 'Uveďte platnú URL adresu oznámeného obsahu.';
    }
    if (!$contactExemption && ($reporterName === '' || $reporterEmail === '')) {
        $errors[] = 'Uveďte meno a e-mail alebo potvrďte zákonnú výnimku pre oznámenie týkajúce sa sexuálneho zneužívania detí.';
    }
    if (mb_strlen($reporterName) > 255) {
        $errors[] = 'Meno oznamovateľa je príliš dlhé.';
    }
    if ($reporterEmail !== '' && filter_var($reporterEmail, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'E-mailová adresa nemá platný formát.';
    }
    if (mb_strlen($legalBasis) < 10 || mb_strlen($legalBasis) > 1000) {
        $errors[] = 'Opíšte právny dôvod oznámenia v rozsahu 10 až 1 000 znakov.';
    }
    if (mb_strlen($explanation) < 20 || mb_strlen($explanation) > 5000) {
        $errors[] = 'Uveďte dostatočne presné vysvetlenie v rozsahu 20 až 5 000 znakov.';
    }
    if (!isset($_POST['good_faith'])) {
        $errors[] = 'Potvrďte, že oznámenie podávate v dobrej viere.';
    }

    if ($errors === []) {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO content_notices
                 (reporter_name, reporter_email, contact_exemption, content_url, legal_basis,
                  explanation, good_faith, status, created_at, updated_at)
                 VALUES (:name, :email, :contact_exemption, :url, :basis, :explanation,
                         1, \'received\', NOW(), NOW())'
            );
            $stmt->execute([
                'name' => $reporterName !== '' ? $reporterName : null,
                'email' => $reporterEmail !== '' ? $reporterEmail : null,
                'contact_exemption' => $contactExemption ? 1 : 0,
                'url' => $contentUrl,
                'basis' => $legalBasis,
                'explanation' => $explanation,
            ]);
            $sent = true;
            $contentUrl = $reporterName = $reporterEmail = $legalBasis = $explanation = '';
        } catch (PDOException $e) {
            error_log('content_report insert failed: ' . $e->getMessage());
            $errors[] = 'Oznámenie sa nepodarilo bezpečne zaevidovať. Kontaktujte nás e-mailom.';
        }
    }
}

$pageTitle = 'Oznámenie nezákonného obsahu';
$metaDescription = 'Kontaktné miesto a formulár na oznámenie nezákonného obsahu podľa aktu o digitálnych službách.';
include 'header.php';
include 'main_nav.php';
?>
<main id="main-content" class="container main-content main-content--single-col" role="main">
  <article class="primary-article legal-article">
    <h1>Oznámenie nezákonného obsahu</h1>
    <p>Tento formulár je jednotným elektronickým kontaktným miestom na oznámenia podľa článku 16 nariadenia (EÚ) 2022/2065. Uveďte presnú adresu obsahu, právny dôvod a dostatočné vysvetlenie.</p>
    <?php if ($sent): ?><div class="alert alert-success" role="status">Oznámenie bolo zaevidované. Ak ste uviedli e-mail, oznámime vám rozhodnutie a jeho dôvody.</div><?php endif; ?>
    <?php if ($errors !== []): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form method="post" action="content_report.php" class="form-card">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
      <div class="form-group"><label for="content_url">Presná URL adresa obsahu *</label><input type="url" id="content_url" name="content_url" required maxlength="2048" value="<?= htmlspecialchars($contentUrl, ENT_QUOTES, 'UTF-8') ?>"></div>
      <div class="form-group"><label for="legal_basis">Prečo považujete obsah za nezákonný *</label><textarea id="legal_basis" name="legal_basis" required minlength="10" maxlength="1000" rows="4"><?= htmlspecialchars($legalBasis, ENT_QUOTES, 'UTF-8') ?></textarea></div>
      <div class="form-group"><label for="explanation">Skutkové okolnosti a dôkazy *</label><textarea id="explanation" name="explanation" required minlength="20" maxlength="5000" rows="7"><?= htmlspecialchars($explanation, ENT_QUOTES, 'UTF-8') ?></textarea></div>
      <div class="form-group"><label for="reporter_name">Meno alebo názov oznamovateľa</label><input type="text" id="reporter_name" name="reporter_name" maxlength="255" value="<?= htmlspecialchars($reporterName, ENT_QUOTES, 'UTF-8') ?>"></div>
      <div class="form-group"><label for="reporter_email">E-mail na potvrdenie a rozhodnutie</label><input type="email" id="reporter_email" name="reporter_email" maxlength="254" value="<?= htmlspecialchars($reporterEmail, ENT_QUOTES, 'UTF-8') ?>"></div>
      <label class="checkbox-label"><input type="checkbox" name="contact_exemption" value="1" <?= $contactExemption ? 'checked' : '' ?>> Oznámenie sa týka trestného činu sexuálneho zneužívania alebo vykorisťovania detí, pri ktorom DSA nevyžaduje meno a e-mail oznamovateľa.</label>
      <label class="checkbox-label"><input type="checkbox" name="good_faith" value="1" required> Potvrdzujem, že oznámenie podávam v dobrej viere a uvedené informácie sú presné a úplné. *</label>
      <button type="submit" class="btn-primary">Odoslať oznámenie</button>
    </form>
    <p>Oznámenia posudzujeme včas, dôsledne, objektívne a bez svojvôle. Dotknutému používateľovi oznámime obmedzenie obsahu a jeho dôvody. Ohlasovateľovi, ktorý uvedie e-mail, oznámime výsledok a dostupné možnosti nápravy. Kontaktný jazyk je slovenčina alebo angličtina.</p>
  </article>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
