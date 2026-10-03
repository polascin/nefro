<?php

declare(strict_types=1);
/**
 * objednavka.php — Stav objednávky publikácie a platobné pokyny
 * ────────────────────────────────────────────────────────────────────────────
 * Jedna stránka pre celý život objednávky: kým nie je zaplatená, ukazuje
 * platobné pokyny (IBAN, variabilný symbol, QR); po potvrdení platby na tom
 * istom odkaze odomkne sťahovanie súborov. Kupujúci si tak nemusí držať dve
 * rôzne adresy a odkaz z prvého e-mailu platí celý čas.
 *
 * Prístup nie je viazaný na účet — objednávku identifikuje variabilný symbol
 * plus token z e-mailu (odvodený HMAC-om, v DB je len jeho soľ). Samotný
 * variabilný symbol je predvídateľné poradové číslo, preto bez tokenu neotvorí nič.
 *
 * Použitie: objednavka.php?vs=<variabilný symbol>&t=<token>
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/publications_common.php';

$siteName = 'Nefro-projekt Slovensko';
$baseUrl  = 'https://nefro.polascin.net/';

$variableSymbol = trim((string) ($_GET['vs'] ?? ''));
$token          = trim((string) ($_GET['t'] ?? ''));
$isNewOrder     = ($_GET['new'] ?? '') === '1';

// Rate limit na overovanie tokenov — bez neho by sa dal token hádať dávkovo.
// Chyba databázy sa nesmie prejaviť ako 500: kupujúci drží v ruke odkaz
// na vlastnú platbu, takže aj pri zlyhaní má dostať zrozumiteľnú stránku
// s kontaktom, nie prázdnu chybu servera.
$order = null;
if ($variableSymbol !== '' && $token !== '') {
    try {
        if (checkFormRateLimit($pdo, 'publication_order_view', getClientIpAddress(), 60, 3600)) {
            $order = findPublicationOrderByToken($pdo, $variableSymbol, $token);
        }
    } catch (\PDOException $e) {
        error_log('objednavka.php: objednávku sa nepodarilo načítať: ' . $e->getMessage());
    }
}

$publication = $order !== null ? findPublication((string) $order['publication_slug']) : null;
$bank        = publicationBankAccount();
$seller      = publicationSeller();
$formatMeta  = publicationFormats();

$orderFormats = $order !== null ? publicationOrderFormats($order) : [];
$amount       = $order !== null ? (float) $order['amount_eur'] : 0.0;
$status       = $order !== null ? (string) $order['status'] : '';
$canDownload  = $order !== null && publicationOrderIsDownloadable($order);
$paymeUrl     = $order !== null ? publicationPaymeUrl($amount, (string) $order['variable_symbol']) : '';

// Doplnkové kanály (karta, peňaženky) sa ponúkajú len pri neuhradenej
// objednávke — po zaplatení by boli len návodom, ako zaplatiť druhý raz.
$payMethods = ($order !== null && $status === 'awaiting_payment')
    ? publicationPaymentMethods($order)
    : [];

// PayPal prijíma len POST na vlastnú doménu, čo globálne `form-action 'self'`
// blokuje. Výnimku dávame len tejto stránke a len pre PayPal — nie celému webu.
if (array_filter($payMethods, static fn (array $m): bool => !empty($m['form'])) !== []) {
    cspAllowFormActionOrigins(['https://www.paypal.com']);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle      = 'Objednávka publikácie | ' . $siteName;
  $canonicalUrl   = $baseUrl . 'objednavka.php';
  $seoDescription = 'Stav objednávky publikácie, platobné pokyny a stiahnutie súborov.';
  // Stránka je osobná a prístupná len s tokenom — do indexu nepatrí.
  $robotsMeta     = 'noindex, nofollow';
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle   = 'Objednávka publikácie';
    $headerIntro   = $order !== null ? 'Variabilný symbol ' . (string) $order['variable_symbol'] : '';
    $showLogo      = false;
    $navActiveItem = 'publikacie.php';
    include 'header.php';
    ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">

            <?php if ($order === null): ?>
                <h2>Objednávku sa nepodarilo otvoriť</h2>
                <div class="info-box-yellow">
                    <p>Odkaz nie je platný alebo je neúplný. Najčastejšia príčina je, že sa pri
                       kopírovaní z e-mailu odrezal jeho konec — skúste prosím kliknúť na odkaz
                       priamo v e-maile s platobnými pokynmi.</p>
                    <p>Ak odkaz nemáte, napíšte nám na
                       <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES) ?>"><?= htmlspecialchars($seller['email']) ?></a>
                       a objednávku dohľadáme.</p>
                </div>
                <div class="form-actions">
                    <a href="publikacie.php" class="btn-primary">Katalóg publikácií</a>
                    <a href="index.php" class="btn-secondary">Späť na úvod</a>
                </div>

            <?php else: ?>

                <?php if ($isNewOrder): ?>
                    <div class="alert alert-success" role="status">
                        <p><strong>Objednávku sme prijali.</strong> Platobné pokyny sme vám poslali
                           aj e-mailom na <?= htmlspecialchars((string) $order['buyer_email']) ?>.
                           Túto stránku si môžete uložiť do záložiek — po pripísaní platby sa na nej
                           objavia odkazy na stiahnutie.</p>
                    </div>
                <?php endif; ?>

                <h2><?= htmlspecialchars((string) $order['publication_title']) ?></h2>
                <p class="auth-subtitle">
                    Objednávka <strong><?= htmlspecialchars((string) $order['variable_symbol']) ?></strong>
                    ·
                    <?php if ($status === 'paid'): ?>
                        <span class="pub-status pub-status--paid">zaplatená</span>
                    <?php elseif ($status === 'cancelled'): ?>
                        <span class="pub-status pub-status--cancelled">zrušená</span>
                    <?php else: ?>
                        <span class="pub-status pub-status--awaiting">čaká na úhradu</span>
                    <?php endif; ?>
                </p>

                <section class="form-section" aria-labelledby="order-summary-heading">
                    <h3 id="order-summary-heading">Súhrn objednávky</h3>
                    <div class="info-box-gray">
                        <dl class="donate-bank">
                            <dt>Publikácia</dt>
                            <dd><?= htmlspecialchars((string) $order['publication_title']) ?></dd>

                            <dt>Formáty</dt>
                            <dd><?= htmlspecialchars(implode(', ', publicationFormatLabels($orderFormats))) ?></dd>

                            <dt>Cena</dt>
                            <dd><strong><?= htmlspecialchars(formatPublicationPrice($amount)) ?></strong></dd>

                            <dt>E-mail</dt>
                            <dd><?= htmlspecialchars((string) $order['buyer_email']) ?></dd>

                            <dt>Objednané</dt>
                            <dd><?= htmlspecialchars(formatUserDateTime((string) $order['created_at'], 'd.m.Y H:i')) ?></dd>

                            <?php if ($status === 'paid' && $order['paid_at'] !== null): ?>
                                <dt>Zaplatené</dt>
                                <dd><?= htmlspecialchars(formatUserDateTime((string) $order['paid_at'], 'd.m.Y H:i')) ?></dd>
                            <?php elseif ($status === 'awaiting_payment' && $order['payment_due_at'] !== null): ?>
                                <dt>Rezervované do</dt>
                                <dd><?= htmlspecialchars(formatUserDateTime((string) $order['payment_due_at'], 'd.m.Y')) ?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </section>

                <?php if ($status === 'cancelled'): ?>
                    <div class="info-box-yellow">
                        <p><strong>Táto objednávka bola zrušená</strong> a nie je možné ju uhradiť.
                           <?php if ((string) $order['payment_note'] !== ''): ?>
                               Dôvod: <?= htmlspecialchars((string) $order['payment_note']) ?>
                           <?php endif; ?>
                        </p>
                        <p>Ak išlo o omyl alebo si publikáciu chcete kúpiť znova, napíšte nám na
                           <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES) ?>"><?= htmlspecialchars($seller['email']) ?></a>,
                           prípadne vytvorte novú objednávku v
                           <a href="publikacie.php">katalógu</a>.</p>
                    </div>

                <?php elseif ($status === 'paid'): ?>
                    <section class="form-section" aria-labelledby="order-download-heading">
                        <h3 id="order-download-heading">Stiahnutie súborov</h3>

                        <?php if ($canDownload): ?>
                            <p>Platbu sme prijali — súbory sú pripravené. Odkazy fungujú opakovane,
                               takže si publikáciu môžete stiahnuť do viacerých zariadení.</p>
                            <ul class="pub-download-list">
                                <?php foreach ($orderFormats as $code): ?>
                                    <?php
                                    $size = publicationFileSize((string) $order['publication_slug'], $code);
                                    $downloadUrl = 'download_publication.php?vs=' . urlencode((string) $order['variable_symbol'])
                                        . '&t=' . urlencode($token)
                                        . '&format=' . urlencode($code);
                                    ?>
                                    <li class="pub-download-row">
                                        <span class="pub-download-row__meta">
                                            <strong><?= htmlspecialchars((string) $formatMeta[$code]['label']) ?></strong>
                                            <?php if ($size !== null): ?>
                                                <span class="pub-download-row__size"><?= htmlspecialchars($size) ?></span>
                                            <?php endif; ?>
                                        </span>
                                        <?php if ($size !== null): ?>
                                            <a href="<?= htmlspecialchars($downloadUrl, ENT_QUOTES) ?>" class="btn-primary">Stiahnuť</a>
                                        <?php else: ?>
                                            <span class="pub-download-row__missing">Pripravujeme — napíšte nám prosím</span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <p class="pub-note">
                                Stiahnutí využitých: <?= (int) $order['download_count'] ?> z <?= PUBLICATION_DOWNLOAD_MAX ?>.
                                <?php if ($order['access_expires_at'] !== null): ?>
                                    Prístup je platný do
                                    <?= htmlspecialchars(formatUserDateTime((string) $order['access_expires_at'], 'd.m.Y')) ?>.
                                <?php endif; ?>
                            </p>
                            <div class="info-box-green">
                                <p><strong>Ďakujeme.</strong> Súbory sú bez DRM a určené na vaše osobné
                                   použitie — čítajte ich na akomkoľvek zariadení. Prosíme len, aby ste
                                   ich nešírili ďalej; výnos z publikácií drží zvyšok portálu voľne
                                   dostupný bez paywallu a reklám.</p>
                            </div>
                        <?php else: ?>
                            <div class="info-box-yellow">
                                <p>Platba je zaznamenaná, ale prístup na stiahnutie už nie je aktívny —
                                   buď uplynula jeho platnosť, alebo bol vyčerpaný limit
                                   <?= PUBLICATION_DOWNLOAD_MAX ?> stiahnutí.</p>
                                <p>Napíšte nám prosím na
                                   <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES) ?>"><?= htmlspecialchars($seller['email']) ?></a>
                                   s variabilným symbolom <?= htmlspecialchars((string) $order['variable_symbol']) ?>
                                   a prístup obnovíme.</p>
                            </div>
                        <?php endif; ?>
                    </section>

                <?php else: ?>
                    <section class="form-section" aria-labelledby="order-payment-heading">
                        <h3 id="order-payment-heading">Platobné pokyny</h3>
                        <p>Uhraďte prosím <strong><?= htmlspecialchars(formatPublicationPrice($amount)) ?></strong>
                           bankovým prevodom s variabilným symbolom
                           <strong><?= htmlspecialchars((string) $order['variable_symbol']) ?></strong>.
                           Bez variabilného symbolu platbu nedokážeme spárovať.</p>

                        <div class="info-box-blue">
                            <dl class="donate-bank">
                                <dt>Príjemca</dt>
                                <dd><?= htmlspecialchars($bank['recipient']) ?></dd>

                                <dt>IBAN</dt>
                                <dd>
                                    <code class="donate-iban"><?= htmlspecialchars($bank['iban_pretty']) ?></code>
                                    <button type="button" class="btn-secondary donate-copy-btn no-print"
                                            data-copy="<?= htmlspecialchars($bank['iban_raw'], ENT_QUOTES) ?>"
                                            aria-label="Kopírovať IBAN do schránky">Kopírovať IBAN</button>
                                </dd>

                                <dt>Suma</dt>
                                <dd>
                                    <code><?= htmlspecialchars(number_format($amount, 2, ',', ' ')) ?> EUR</code>
                                    <button type="button" class="btn-secondary donate-copy-btn no-print"
                                            data-copy="<?= htmlspecialchars(number_format($amount, 2, '.', ''), ENT_QUOTES) ?>"
                                            aria-label="Kopírovať sumu do schránky">Kopírovať</button>
                                </dd>

                                <dt>Variabilný symbol</dt>
                                <dd>
                                    <code><?= htmlspecialchars((string) $order['variable_symbol']) ?></code>
                                    <button type="button" class="btn-secondary donate-copy-btn no-print"
                                            data-copy="<?= htmlspecialchars((string) $order['variable_symbol'], ENT_QUOTES) ?>"
                                            aria-label="Kopírovať variabilný symbol do schránky">Kopírovať</button>
                                </dd>

                                <dt>SWIFT / BIC</dt>
                                <dd><code><?= htmlspecialchars($bank['swift']) ?></code></dd>

                                <dt>Banka</dt>
                                <dd><?= htmlspecialchars($bank['bank_name']) ?></dd>

                                <dt>Adresa banky</dt>
                                <dd><?= htmlspecialchars($bank['bank_address']) ?></dd>

                                <dt>Kód krajiny</dt>
                                <dd><?= htmlspecialchars($bank['country']) ?></dd>
                            </dl>
                            <p class="donate-note">
                                Pri platbe zo zahraničia použite IBAN a SWIFT/BIC a variabilný symbol
                                uveďte do poznámky pre prijímateľa (napríklad <em>VS
                                <?= htmlspecialchars((string) $order['variable_symbol']) ?></em>).
                            </p>
                        </div>

                        <figure class="donate-qr">
                            <div id="pub-payment-qr" class="pub-payment-qr"></div>
                            <figcaption>
                                Naskenujte QR kód fotoaparátom telefónu — otvorí platobnú stránku
                                payme.sk s predvyplnenou sumou aj variabilným symbolom, z ktorej
                                zaplatíte v aplikácii svojej banky.
                            </figcaption>
                        </figure>
                        <p class="no-print">
                            <a href="<?= htmlspecialchars($paymeUrl, ENT_QUOTES) ?>" class="btn-primary"
                               target="_blank" rel="noopener noreferrer">Zaplatiť cez payme.sk</a>
                        </p>

                        <div class="info-box-gray">
                            <p><strong>Čo bude ďalej.</strong> Platbu párujeme podľa variabilného
                               symbolu, zvyčajne do jedného pracovného dňa od pripísania na účet.
                               Potom vám publikáciu pošleme e-mailom — súbory, ktoré sa zmestia do
                               prílohy, prídu priamo v nej. Zároveň sa odomknú na tejto stránke,
                               takže ich stiahnete aj tu; stačí stránku obnoviť.</p>
                            <p>Platba sa realizuje výhradne vo vašej banke. Na tejto stránke sa
                               nezadávajú žiadne platobné údaje a portál ich nespracúva.</p>
                        </div>
                    </section>

                    <?php if ($payMethods !== []): ?>
                    <section class="form-section" aria-labelledby="order-altpay-heading">
                        <h3 id="order-altpay-heading">Alebo zaplaťte kartou či peňaženkou</h3>
                        <p>Ak nechcete platiť prevodom, použite ktorúkoľvek z týchto možností.
                           Platbu spracúva vybraná služba — portál platobné údaje nevidí
                           ani neuchováva.</p>

                        <ul class="pub-paymethod-list">
                            <?php foreach ($payMethods as $method): ?>
                                <li class="pub-paymethod">
                                    <div class="pub-paymethod__body">
                                        <p class="pub-paymethod__name">
                                            <?= htmlspecialchars((string) $method['name']) ?>
                                            <?php if ($method['auto_ref']): ?>
                                                <span class="pub-paymethod__tag pub-paymethod__tag--auto">číslo objednávky sa prenesie</span>
                                            <?php else: ?>
                                                <span class="pub-paymethod__tag pub-paymethod__tag--manual">uveďte VS do poznámky</span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="pub-paymethod__desc"><?= htmlspecialchars((string) $method['desc']) ?></p>
                                    </div>
                                    <div class="pub-paymethod__action no-print">
                                        <?php if (!empty($method['url'])): ?>
                                            <a href="<?= htmlspecialchars((string) $method['url'], ENT_QUOTES) ?>"
                                               class="btn-primary" target="_blank" rel="noopener noreferrer">
                                                <?= htmlspecialchars((string) $method['cta']) ?>
                                            </a>
                                        <?php elseif (!empty($method['form'])): ?>
                                            <?php /* PayPal Payments Standard prijíma len POST — tá istá
                                                     sada polí poslaná GETom vracia 403, preto formulár
                                                     a nie odkaz. */ ?>
                                            <form action="<?= htmlspecialchars((string) $method['form']['action'], ENT_QUOTES) ?>"
                                                  method="post" target="_blank" rel="noopener noreferrer">
                                                <?php foreach ($method['form']['fields'] as $fieldName => $fieldValue): ?>
                                                    <input type="hidden"
                                                           name="<?= htmlspecialchars((string) $fieldName, ENT_QUOTES) ?>"
                                                           value="<?= htmlspecialchars((string) $fieldValue, ENT_QUOTES) ?>">
                                                <?php endforeach; ?>
                                                <button type="submit" class="btn-primary"><?= htmlspecialchars((string) $method['cta']) ?></button>
                                            </form>
                                        <?php else: ?>
                                            <code><?= htmlspecialchars((string) $method['copy_label']) ?></code>
                                            <button type="button" class="btn-secondary donate-copy-btn"
                                                    data-copy="<?= htmlspecialchars((string) $method['copy'], ENT_QUOTES) ?>"
                                                    aria-label="Kopírovať <?= htmlspecialchars((string) $method['copy_label'], ENT_QUOTES) ?> do schránky">Kopírovať</button>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="info-box-yellow">
                            <p><strong>Dôležité pri platbe mimo prevodu.</strong> Tam, kde službe
                               nevieme odovzdať číslo objednávky, uveďte prosím do poznámky alebo
                               popisu platby variabilný symbol
                               <strong><?= htmlspecialchars((string) $order['variable_symbol']) ?></strong>.
                               Bez neho musíme platbu dohľadávať ručne a dodanie sa zdrží.
                               Ak sa to stane, napíšte nám na
                               <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES) ?>"><?= htmlspecialchars($seller['email']) ?></a>
                               a objednávku spárujeme.</p>
                        </div>
                    </section>
                    <?php endif; ?>
                <?php endif; ?>

                <section class="form-section" aria-labelledby="order-seller-heading">
                    <h3 id="order-seller-heading">Predávajúci</h3>
                    <p>
                        <?= htmlspecialchars($seller['name']) ?>,
                        IČO <?= htmlspecialchars($seller['companyId']) ?>,
                        DIČ <?= htmlspecialchars($seller['taxId']) ?>,
                        <?= htmlspecialchars($seller['address']) ?>.
                        <?= htmlspecialchars($seller['vatNote']) ?>
                    </p>
                    <p class="pub-legal-link">
                        <a href="obchodne-podmienky.php">Obchodné podmienky predaja publikácií</a> ·
                        <a href="/privacy">Ochrana osobných údajov</a> ·
                        <a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES) ?>">Napísať predávajúcemu</a>
                    </p>
                </section>

                <div class="form-actions">
                    <?php if ($publication !== null): ?>
                        <a href="publikacia.php?slug=<?= urlencode((string) $publication['slug']) ?>" class="btn-secondary">Detail publikácie</a>
                    <?php endif; ?>
                    <a href="publikacie.php" class="btn-secondary">Katalóg publikácií</a>
                </div>

            <?php endif; ?>

            </div>
        </div>
    </main>

    <?php if ($order !== null && $status === 'awaiting_payment'): ?>
    <script src="/assets/qrcode.min.js?v=<?= filemtime(__DIR__ . '/assets/qrcode.min.js') ?>"></script>
    <?php endif; ?>
    <script nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES) ?>">
    (function () {
        <?php if ($order !== null && $status === 'awaiting_payment'): ?>
        var qrBox = document.getElementById('pub-payment-qr');
        if (qrBox && typeof QRCode !== 'undefined') {
            new QRCode(qrBox, {
                text: <?= json_encode($paymeUrl, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
                width: 220, height: 220,
                colorDark: '#000000', colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M
            });
        }
        <?php endif; ?>

        if (!navigator.clipboard) { return; }
        document.querySelectorAll('.donate-copy-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                navigator.clipboard.writeText(btn.getAttribute('data-copy') || '').then(function () {
                    var original = btn.textContent;
                    btn.textContent = 'Skopírované ✓';
                    setTimeout(function () { btn.textContent = original; }, 2000);
                }).catch(function () {});
            });
        });
    })();
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
