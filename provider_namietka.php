<?php

declare(strict_types=1);
/**
 * provider_namietka.php
 *
 * Uplatnenie práva namietať podľa čl. 21 GDPR pre záznamy v adresári
 * `partner_providers`. Odkaz je v oznámení podľa čl. 14 (pozri `provider_notices.php`).
 *
 * Výmaz sa vykoná až na POST s platným CSRF tokenom, nikdy na samotné otvorenie
 * odkazu. Dôvod je praktický: bezpečnostné brány a náhľadové roboty poštových
 * serverov si odkazy v e-mailoch samy otvárajú, takže výmaz na GET by zmazal
 * záznamy ľuďom, ktorí na nič neklikli.
 *
 * Po námietke sa záznam maže — presne to sľubuje oznámenie aj zásady ochrany
 * súkromia. Aby sa ten istý kontakt nedostal späť pri ďalšom seedovaní adresára,
 * ostáva v `provider_suppressions` len HMAC odtlačok e-mailu, nie adresa samotná.
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/provider_notices.php';

$requestMethod = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if (!in_array($requestMethod, ['GET', 'POST'], true)) {
    http_response_code(405);
    header('Allow: GET, POST');
    exit;
}

$isPost  = $requestMethod === 'POST';
$request = $isPost ? $_POST : $_GET;

$providerId = (int) ($request['pid'] ?? 0);
$expiresAt  = (int) ($request['exp'] ?? 0);
$signature  = trim((string) ($request['sig'] ?? ''));

$status           = 'error';
$message          = 'Neplatný alebo neúplný odkaz.';
$showConfirmation = false;
$providerName     = '';

if ($isPost && !validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
    $message = 'Neplatný CSRF token. Otvorte odkaz z e-mailu znova.';
} elseif ($providerId > 0 && $expiresAt > 0 && $signature !== '') {
    try {
        $stmt = $pdo->prepare('SELECT id, name, email FROM partner_providers WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $providerId]);
        $provider = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$provider) {
            // Buď už bola námietka uplatnená, alebo taký záznam nikdy nebol.
            // Odpoveď je zámerne rovnaká — cez tento odkaz sa nedá zisťovať,
            // ktoré zariadenia v adresári sú a ktoré nie.
            $status  = 'success';
            $message = 'Tento záznam sa už v adresári nenachádza. Nemusíte robiť nič ďalšie.';
        } elseif (!verifyProviderObjectionSignature($providerId, (string) $provider['email'], $expiresAt, $signature)) {
            $message = $expiresAt < time()
                ? 'Platnosť odkazu uplynula. Napíšte nám prosím na ' . htmlspecialchars(legalInfo()['contactEmail'], ENT_QUOTES, 'UTF-8') . ' a záznam vymažeme.'
                : 'Odkaz nie je platný. Skontrolujte, či ste ho skopírovali celý.';
        } elseif (!$isPost) {
            $showConfirmation = true;
            $status           = 'info';
            $providerName     = (string) $provider['name'];
            $message          = 'Potvrďte prosím, že máme záznam o zariadení „' . $providerName . '“ vymazať z nášho adresára.';
        } else {
            $email = providerNoticeNormalizeEmail((string) $provider['email']);

            $pdo->beginTransaction();
            try {
                if ($email !== '') {
                    // Odtlačok najprv — keby výmaz zlyhal, radšej máme kontakt
                    // navyše v zozname namietajúcich než záznam, ktorý sa vráti.
                    $ins = $pdo->prepare(
                        "INSERT IGNORE INTO provider_suppressions (email_hash, reason)
                         VALUES (:h, 'namietka')"
                    );
                    $ins->execute([':h' => providerEmailHash($email)]);

                    // Tú istú schránku môže zdieľať viacero záznamov; námietka
                    // sa vzťahuje na kontakt, takže padnú všetky.
                    $del = $pdo->prepare('DELETE FROM partner_providers WHERE LOWER(email) = :email');
                    $del->execute([':email' => $email]);
                } else {
                    $del = $pdo->prepare('DELETE FROM partner_providers WHERE id = :id');
                    $del->execute([':id' => $providerId]);
                }
                $removed = $del->rowCount();
                $pdo->commit();
            } catch (Throwable $e) {
                $pdo->rollBack();
                throw $e;
            }

            $status  = 'success';
            $message = $removed > 1
                ? 'Hotovo. Vymazali sme ' . $removed . ' záznamy viazané na túto e-mailovú adresu a znova vás neoslovíme.'
                : 'Hotovo. Záznam sme vymazali z adresára a znova vás neoslovíme.';

            error_log('[provider-objection] namietka uplatnena, vymazanych zaznamov: ' . $removed);
        }
    } catch (Throwable $e) {
        error_log('[provider-objection] chyba: ' . $e->getMessage());
        $message = 'Pri spracovaní nastala chyba. Napíšte nám prosím na '
            . htmlspecialchars(legalInfo()['contactEmail'], ENT_QUOTES, 'UTF-8') . ' a vybavíme to ručne.';
    }
}

$pageClass = match ($status) {
    'success' => 'alert-success',
    'info'    => 'alert-info',
    default   => 'alert-error',
};
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Námietka proti spracúvaniu údajov - Nefro-projekt Slovensko</title>
    <link rel="stylesheet" href="index.css?v=<?= filemtime('index.css') ?>">
    <script src="ui-preferences.js?v=<?= filemtime('ui-preferences.js') ?>"></script>
    <script src="theme.js?v=<?= filemtime('theme.js') ?>"></script>
    <script src="ui-preferences-fallback.js?v=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <?php
    $headerTitle = 'Námietka proti spracúvaniu';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container" role="main">
        <div class="auth-container">
            <h2>Námietka proti spracúvaniu údajov</h2>
            <div class="alert <?= htmlspecialchars($pageClass, ENT_QUOTES) ?>">
                <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
            </div>

            <?php if ($showConfirmation): ?>
                <p>Po potvrdení kontaktné údaje zariadenia z adresára odstránime a už vás
                   v tejto veci nebudeme kontaktovať. Nemusíte uvádzať dôvod.</p>
                <form method="POST" action="provider_namietka.php">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES) ?>">
                    <input type="hidden" name="pid" value="<?= $providerId ?>">
                    <input type="hidden" name="exp" value="<?= $expiresAt ?>">
                    <input type="hidden" name="sig" value="<?= htmlspecialchars($signature, ENT_QUOTES) ?>">
                    <button type="submit" class="btn btn-primary">Áno, vymažte môj záznam</button>
                </form>
            <?php endif; ?>

            <p class="mt-3">
                <a href="privacy.php">Zásady ochrany súkromia</a> &middot;
                <a href="<?= htmlspecialchars('mailto:' . legalInfo()['contactEmail'], ENT_QUOTES) ?>">Napísať prevádzkovateľovi</a>
            </p>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
