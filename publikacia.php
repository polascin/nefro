<?php

declare(strict_types=1);
/**
 * publikacia.php — Predajná stránka publikácie
 * ────────────────────────────────────────────────────────────────────────────
 * Detail publikácie, výber formátov a objednávkový formulár. Objednávka sa
 * zakladá na POST; po úspechu stránka presmeruje na `objednavka.php`
 * s variabilným symbolom a prístupovým tokenom (POST → redirect → GET,
 * aby obnovenie stránky nezaložilo druhú objednávku).
 *
 * Objednávať môže aj neprihlásený návštevník — vyžadovať registráciu by pri
 * jednorazovom nákupe e-knihy iba odrádzalo. Identifikátorom je variabilný
 * symbol plus token z e-mailu, nie účet.
 *
 * Použitie: publikacia.php?slug=sk-nefro-baza-1
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/publications_common.php';

$siteName = 'Nefro-projekt Slovensko';
$baseUrl  = 'https://nefro.polascin.net/';

$slug = trim((string) ($_GET['slug'] ?? $_POST['slug'] ?? ''));
if ($slug === '' || !isValidPublicationSlug($slug)) {
    header('Location: publikacie.php');
    exit;
}

$publication = findPublication($slug);
if ($publication === null || !$publication['is_available']) {
    http_response_code(404);
    $publication = null;
}

$isLocalDev   = function_exists('isAppLocalDev') && isAppLocalDev();
$errors       = [];
$formValues   = [
    'formats'    => ['pdf'],
    'email'      => '',
    'name'       => '',
    'company'    => '',
    'company_id' => '',
    'tax_id'     => '',
    'address'    => '',
    'note'       => '',
];

if ($publication !== null && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    /** @var array<int, string> $postedFormats */
    $postedFormats = is_array($_POST['formats'] ?? null) ? $_POST['formats'] : [];

    $formValues = [
        'formats'    => $postedFormats,
        'email'      => strtolower(trim((string) ($_POST['email'] ?? ''))),
        'name'       => trim((string) ($_POST['buyer_name'] ?? '')),
        'company'    => trim((string) ($_POST['buyer_company'] ?? '')),
        'company_id' => trim((string) ($_POST['buyer_company_id'] ?? '')),
        'tax_id'     => trim((string) ($_POST['buyer_tax_id'] ?? '')),
        'address'    => trim((string) ($_POST['buyer_address'] ?? '')),
        'note'       => trim((string) ($_POST['buyer_note'] ?? '')),
    ];

    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Neplatný CSRF token. Obnovte stránku a skúste to znova.';
    } else {
        // ── Bot detekcia (User-Agent, honeypot, JS-challenge, time-check) ────
        // Rovnaká sada ako pri registrácii: objednávkový formulár posiela
        // e-mail, takže bez nej by sa dal zneužiť na rozosielanie správ.
        $isBotRequest = false;

        if (isKnownBotUserAgent()) {
            if ($isLocalDev) {
                $errors[] = '[DEV] Detekovaný nepovolený User-Agent.';
            } else {
                $isBotRequest = true;
            }
        }

        if (!$isBotRequest && ($_POST['website_url'] ?? '') !== '') {
            if ($isLocalDev) {
                $errors[] = '[DEV] Honeypot aktivovaný.';
            } else {
                $isBotRequest = true;
            }
        }

        if (!$isBotRequest && !validateJsChallengeToken($_POST['js_token'] ?? null)) {
            if ($isLocalDev) {
                $errors[] = '[DEV] JS-Challenge zlyhal (chýba js_token).';
            } else {
                $isBotRequest = true;
            }
        }

        if (!$isBotRequest && !validateFormTime('publication_order', 4)) {
            if ($isLocalDev) {
                $errors[] = '[DEV] Formulár odoslaný príliš rýchlo (pod 4 s).';
            } else {
                $isBotRequest = true;
            }
        }

        if ($isBotRequest) {
            // Botovi nepriznávame detekciu — mlčky ho pošleme na katalóg.
            header('Location: publikacie.php');
            exit;
        }

        $selectedFormats = normalizePublicationFormats($publication, $formValues['formats']);

        if ($selectedFormats === []) {
            $errors[] = 'Vyberte aspoň jeden formát.';
        }
        if (!filter_var($formValues['email'], FILTER_VALIDATE_EMAIL) || !isEmailDomainValid($formValues['email'])) {
            $errors[] = 'Zadajte platnú e-mailovú adresu — pošleme na ňu platobné pokyny aj súbory.';
        }
        if (mb_strlen($formValues['email']) > 255) {
            $errors[] = 'E-mailová adresa je príliš dlhá.';
        }
        if (mb_strlen($formValues['name']) > 255 || mb_strlen($formValues['company']) > 255) {
            $errors[] = 'Meno alebo názov firmy je príliš dlhý.';
        }
        if ($formValues['company_id'] !== '' && !preg_match('/^[0-9 ]{6,20}$/', $formValues['company_id'])) {
            $errors[] = 'IČO zadajte ako číslo (6 – 12 číslic).';
        }
        if (mb_strlen($formValues['address']) > 500) {
            $errors[] = 'Fakturačná adresa je príliš dlhá.';
        }
        if (mb_strlen($formValues['note']) > 1000) {
            $errors[] = 'Poznámka je príliš dlhá (najviac 1 000 znakov).';
        }
        if (($_POST['agree_terms'] ?? '') !== '1') {
            $errors[] = 'Bez súhlasu s obchodnými podmienkami nemôžeme objednávku prijať.';
        }
        if (($_POST['agree_immediate_delivery'] ?? '') !== '1') {
            $errors[] = 'Potvrďte prosím súhlas s dodaním digitálneho obsahu pred uplynutím '
                . 'lehoty na odstúpenie od zmluvy — bez neho vám súbory nemôžeme sprístupniť hneď po platbe.';
        }

        // Rate limit podľa IP — bráni zakladaniu objednávok v dávkach.
        if ($errors === [] && !checkFormRateLimit($pdo, 'publication_order', getClientIpAddress(), 10, 3600)) {
            $errors[] = 'Príliš veľa objednávok z tejto adresy. Skúste to prosím neskôr '
                . 'alebo nám napíšte na ' . htmlspecialchars(publicationSeller()['email'], ENT_QUOTES, 'UTF-8') . '.';
        }

        if ($errors === []) {
            try {
                $created = createPublicationOrder($pdo, $publication, $selectedFormats, [
                    'email'      => $formValues['email'],
                    'name'       => $formValues['name'],
                    'company'    => $formValues['company'],
                    'company_id' => $formValues['company_id'],
                    'tax_id'     => $formValues['tax_id'],
                    'address'    => $formValues['address'],
                    'note'       => $formValues['note'],
                ]);

                $order = $created['order'];
                $token = $created['token'];

                if (!sendPublicationOrderInstructionsEmail($order, $token)) {
                    // Objednávka existuje a platobné pokyny sú aj na stránke,
                    // kam vzápätí presmerujeme — zlyhanie SMTP teda nákup
                    // neblokuje, len ho zalogujeme pre dohľadanie.
                    error_log('publikacia.php: platobné pokyny sa nepodarilo odoslať pre VS '
                        . (string) $order['variable_symbol']);
                }
                sendPublicationOrderAdminNotice($order);

                header('Location: ' . 'objednavka.php?vs=' . urlencode((string) $order['variable_symbol'])
                    . '&t=' . urlencode($token) . '&new=1');
                exit;
            } catch (\Throwable $e) {
                error_log('publikacia.php: objednávku sa nepodarilo založiť: ' . $e->getMessage());
                $errors[] = 'Objednávku sa nepodarilo založiť. Skúste to prosím znova, '
                    . 'alebo nám napíšte na ' . publicationSeller()['email'] . '.';
            }
        }
    }
}

$seller  = publicationSeller();
$formats = publicationFormats();

// Predvolený výber pre formulár: zachovaj, čo návštevník odoslal, a ak nič
// platné nevybral (alebo prichádza na stránku prvý raz), nechaj zaškrtnuté PDF
// — základný formát, ktorý si vyberie väčšina kupujúcich.
$selectedForUi = ['pdf'];
if ($publication !== null) {
    $selectedForUi = normalizePublicationFormats($publication, $formValues['formats']);
    if ($selectedForUi === []) {
        $selectedForUi = ['pdf'];
    }
}

markFormLoadTime('publication_order');
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  if ($publication === null) {
      $pageTitle      = 'Publikácia sa nenašla | ' . $siteName;
      $canonicalUrl   = $baseUrl . 'publikacie.php';
      $seoDescription = 'Požadovaná publikácia nie je v ponuke.';
      $robotsMeta     = 'noindex, follow';
  } else {
      $pageTitle      = $publication['title'] . ' — e-kniha | ' . $siteName;
      $canonicalUrl   = $baseUrl . 'publikacia.php?slug=' . $publication['slug'];
      $seoDescription = (string) $publication['excerpt'];
      $seoKeywords    = 'SK Nefro Báza, e-kniha nefrológia, CKD, dialýza, PDF EPUB Kindle, '
          . 'odborná literatúra nefrológia, nefrológia kniha slovensky';
      $ogType         = 'product';
      $ogImage        = $baseUrl . $publication['cover'];
      $ogImageWidth   = 1600;
      $ogImageHeight  = 2400;

      $offers = [];
      foreach ([
          ['name' => 'Jeden formát', 'price' => PUBLICATION_PRICE_SINGLE],
          ['name' => 'Všetky formáty', 'price' => PUBLICATION_PRICE_BUNDLE],
      ] as $offer) {
          $offers[] = [
              '@type'         => 'Offer',
              'name'          => $offer['name'],
              'price'         => number_format($offer['price'], 2, '.', ''),
              'priceCurrency' => 'EUR',
              'availability'  => 'https://schema.org/InStock',
              'url'           => $canonicalUrl,
              'seller'        => [
                  '@type' => 'Organization',
                  'name'  => $seller['name'],
              ],
          ];
      }

      $structuredData = [
          [
              '@context'      => 'https://schema.org',
              '@type'         => 'Book',
              'name'          => $publication['title'],
              'bookFormat'    => 'https://schema.org/EBook',
              'description'   => $publication['excerpt'],
              'inLanguage'    => 'sk-SK',
              'numberOfPages' => (int) $publication['pages'],
              'datePublished' => $publication['published_on'],
              'image'         => $baseUrl . $publication['cover'],
              'url'           => $canonicalUrl,
              'author'        => ['@type' => 'Person', 'name' => $publication['author']],
              'publisher'     => ['@type' => 'Organization', 'name' => $seller['name']],
              'offers'        => $offers,
          ],
          [
              '@context'        => 'https://schema.org',
              '@type'           => 'BreadcrumbList',
              'itemListElement' => [
                  ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
                  ['@type' => 'ListItem', 'position' => 2, 'name' => 'Publikácie', 'item' => $baseUrl . 'publikacie.php'],
                  ['@type' => 'ListItem', 'position' => 3, 'name' => $publication['title'], 'item' => $canonicalUrl],
              ],
          ],
      ];
  }
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = $publication === null ? 'Publikácie' : (string) $publication['title'];
    $headerIntro = $publication === null ? '' : 'E-kniha · ' . (string) $publication['edition'];
    $showLogo    = false;
    $navActiveItem = 'publikacie.php';
    include 'header.php';
    ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">

        <?php if ($publication === null): ?>
            <div class="info-box-yellow">
                <p>Takú publikáciu v ponuke nemáme. Prejdite prosím na
                   <a href="publikacie.php">katalóg publikácií</a>.</p>
            </div>
        <?php else: ?>

            <nav class="pub-breadcrumb" aria-label="Navigačná cesta">
                <a href="index.php">Domov</a> ›
                <a href="publikacie.php">Publikácie</a> ›
                <span aria-current="page"><?= htmlspecialchars((string) $publication['title']) ?></span>
            </nav>

            <?php if ($errors !== []): ?>
                <div class="alert alert-error" role="alert">
                    <p><strong>Objednávku sa nepodarilo odoslať:</strong></p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <section class="pub-hero">
                <div class="pub-hero__cover">
                    <img src="<?= htmlspecialchars((string) $publication['cover_small']) ?>"
                         alt="Obálka publikácie <?= htmlspecialchars((string) $publication['title']) ?>"
                         width="600" height="900">
                </div>
                <div class="pub-hero__body">
                    <h2 class="pub-hero__title"><?= htmlspecialchars((string) $publication['title']) ?></h2>
                    <p class="pub-hero__subtitle"><?= htmlspecialchars((string) $publication['subtitle']) ?></p>
                    <p class="pub-hero__author"><?= htmlspecialchars((string) $publication['author']) ?>
                        · <?= htmlspecialchars((string) $publication['edition']) ?></p>

                    <dl class="pub-hero__facts">
                        <div><dt>Článkov</dt><dd><?= number_format((int) $publication['articles'], 0, ',', ' ') ?></dd></div>
                        <div><dt>Strán</dt><dd><?= number_format((int) $publication['pages'], 0, ',', ' ') ?></dd></div>
                        <div><dt>Slov</dt><dd><?= number_format((int) $publication['words'], 0, ',', ' ') ?></dd></div>
                        <div><dt>Ilustrácií</dt><dd><?= number_format((int) $publication['images'], 0, ',', ' ') ?></dd></div>
                    </dl>

                    <p class="pub-hero__price">
                        <span class="pub-hero__price-main"><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_SINGLE)) ?></span>
                        <span class="pub-hero__price-note">jeden formát &nbsp;·&nbsp; všetky formáty
                            <strong><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_BUNDLE)) ?></strong></span>
                    </p>
                    <p class="pub-hero__cta">
                        <a href="#objednavka" class="btn-primary">Objednať</a>
                        <a href="#formaty" class="btn-secondary">Formáty</a>
                    </p>
                    <p class="pub-hero__trust">Bez DRM · okamžité stiahnutie po úhrade ·
                        <?= htmlspecialchars($seller['vatNote']) ?></p>
                </div>
            </section>

            <section class="form-section" aria-labelledby="pub-o-knihe-heading">
                <h3 id="pub-o-knihe-heading">O publikácii</h3>
                <?php foreach ($publication['description'] as $paragraph): ?>
                    <p><?= $paragraph /* dôveryhodný text z katalógu v kóde, nie zo vstupu */ ?></p>
                <?php endforeach; ?>

                <h4>Čo v knihe dostanete</h4>
                <ul class="pub-highlights">
                    <?php foreach ($publication['highlights'] as $highlight): ?>
                        <li><?= htmlspecialchars((string) $highlight) ?></li>
                    <?php endforeach; ?>
                </ul>

                <h4>Pre koho je</h4>
                <p><?= htmlspecialchars((string) $publication['audience']) ?></p>

                <div class="info-box-yellow">
                    <p><strong>Upozornenie.</strong> Publikácia je vzdelávací a referenčný materiál.
                       Nenahrádza odborné posúdenie stavu konkrétneho pacienta, aktuálne platné
                       odporúčania ani súhrn charakteristických vlastností liekov. Dávkovanie
                       a indikácie si vždy overte v primárnom zdroji.</p>
                </div>
            </section>

            <section class="form-section" id="formaty" aria-labelledby="pub-formaty-heading">
                <h3 id="pub-formaty-heading">Dostupné formáty</h3>
                <p>Základný formát je <strong>PDF</strong> — pevná sadzba identická s tlačenou
                   podobou. Ostatné formáty obsahujú ten istý text; vyberte si podľa toho,
                   na čom čítate.</p>
                <div class="table-responsive">
                    <table class="pub-formats-table">
                        <caption class="visually-hidden">Prehľad dostupných formátov publikácie</caption>
                        <thead>
                            <tr>
                                <th scope="col">Formát</th>
                                <th scope="col">Na čo sa hodí</th>
                                <th scope="col">Veľkosť</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($publication['formats'] as $code): ?>
                                <?php $size = publicationFileSize((string) $publication['slug'], (string) $code); ?>
                                <tr>
                                    <th scope="row"><?= htmlspecialchars((string) $formats[$code]['label']) ?></th>
                                    <td><?= htmlspecialchars((string) $formats[$code]['note']) ?></td>
                                    <td><?= $size !== null ? htmlspecialchars($size) : '—' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="pub-note">
                    Cena je <strong><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_SINGLE)) ?></strong>
                    za jeden formát. Pri dvoch a viac formátoch sa automaticky uplatní balíková cena
                    <strong><?= htmlspecialchars(formatPublicationPrice(PUBLICATION_PRICE_BUNDLE)) ?></strong>
                    za všetky vybrané — viac než balík teda nikdy nezaplatíte.
                </p>
            </section>

            <section class="form-section" id="objednavka" aria-labelledby="pub-objednavka-heading">
                <h3 id="pub-objednavka-heading">Objednávka</h3>
                <p>Objednávka je nezáväzná do úhrady a nevyžaduje registráciu. Po odoslaní
                   dostanete e-mailom platobné pokyny s variabilným symbolom.</p>

                <form method="post" action="publikacia.php?slug=<?= urlencode((string) $publication['slug']) ?>"
                      class="pub-order-form" id="pubOrderForm" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES) ?>">
                    <input type="hidden" name="slug" value="<?= htmlspecialchars((string) $publication['slug'], ENT_QUOTES) ?>">
                    <input type="hidden" name="js_token" id="js_token_field" value="">

                    <div class="honeypot" aria-hidden="true" tabindex="-1">
                        <label for="website_url">Webová adresa (nevypĺňať)</label>
                        <input type="text" id="website_url" name="website_url" value="" autocomplete="off" tabindex="-1" maxlength="255">
                    </div>

                    <fieldset class="pub-order-formats">
                        <legend>Vyberte formáty <span class="pub-required">*</span></legend>
                        <?php foreach ($publication['formats'] as $code): ?>
                            <?php $checked = in_array((string) $code, $selectedForUi, true); ?>
                            <label class="pub-format-choice" for="format_<?= htmlspecialchars((string) $code, ENT_QUOTES) ?>">
                                <input type="checkbox"
                                       id="format_<?= htmlspecialchars((string) $code, ENT_QUOTES) ?>"
                                       name="formats[]"
                                       value="<?= htmlspecialchars((string) $code, ENT_QUOTES) ?>"
                                       data-pub-format
                                       <?= $checked ? 'checked' : '' ?>>
                                <span class="pub-format-choice__label"><?= htmlspecialchars((string) $formats[$code]['label']) ?></span>
                                <span class="pub-format-choice__note"><?= htmlspecialchars((string) $formats[$code]['note']) ?></span>
                            </label>
                        <?php endforeach; ?>
                        <p class="pub-order-total" id="pubOrderTotal"
                           data-price-single="<?= htmlspecialchars(number_format(PUBLICATION_PRICE_SINGLE, 2, '.', ''), ENT_QUOTES) ?>"
                           data-price-bundle="<?= htmlspecialchars(number_format(PUBLICATION_PRICE_BUNDLE, 2, '.', ''), ENT_QUOTES) ?>"
                           aria-live="polite">
                            Cena:
                            <strong id="pubOrderTotalValue"><?= htmlspecialchars(formatPublicationPrice(publicationPriceFor($selectedForUi))) ?></strong>
                        </p>
                    </fieldset>

                    <div class="form-group">
                        <label for="email">E-mail <span class="pub-required">*</span></label>
                        <input type="email" id="email" name="email" required maxlength="255"
                               autocomplete="email" inputmode="email"
                               value="<?= htmlspecialchars($formValues['email'], ENT_QUOTES) ?>">
                        <small>Na túto adresu pošleme platobné pokyny aj odkaz na stiahnutie.
                               Adresu používame výhradne na vybavenie objednávky.</small>
                    </div>

                    <div class="form-group">
                        <label for="buyer_name">Meno a priezvisko</label>
                        <input type="text" id="buyer_name" name="buyer_name" maxlength="255" autocomplete="name"
                               value="<?= htmlspecialchars($formValues['name'], ENT_QUOTES) ?>">
                        <small>Voliteľné — uvedieme ho na doklade o zaplatení.</small>
                    </div>

                    <details class="pub-order-invoice">
                        <summary>Potrebujem doklad na firmu (voliteľné)</summary>
                        <div class="form-group">
                            <label for="buyer_company">Názov firmy / organizácie</label>
                            <input type="text" id="buyer_company" name="buyer_company" maxlength="255"
                                   autocomplete="organization"
                                   value="<?= htmlspecialchars($formValues['company'], ENT_QUOTES) ?>">
                        </div>
                        <div class="form-group">
                            <label for="buyer_company_id">IČO</label>
                            <input type="text" id="buyer_company_id" name="buyer_company_id" maxlength="20"
                                   inputmode="numeric"
                                   value="<?= htmlspecialchars($formValues['company_id'], ENT_QUOTES) ?>">
                        </div>
                        <div class="form-group">
                            <label for="buyer_tax_id">DIČ / IČ DPH</label>
                            <input type="text" id="buyer_tax_id" name="buyer_tax_id" maxlength="20"
                                   value="<?= htmlspecialchars($formValues['tax_id'], ENT_QUOTES) ?>">
                        </div>
                        <div class="form-group">
                            <label for="buyer_address">Fakturačná adresa</label>
                            <input type="text" id="buyer_address" name="buyer_address" maxlength="500"
                                   autocomplete="street-address"
                                   value="<?= htmlspecialchars($formValues['address'], ENT_QUOTES) ?>">
                        </div>
                    </details>

                    <div class="form-group">
                        <label for="buyer_note">Poznámka</label>
                        <textarea id="buyer_note" name="buyer_note" rows="3" maxlength="1000"><?= htmlspecialchars($formValues['note'], ENT_QUOTES) ?></textarea>
                    </div>

                    <div class="form-group pub-order-consent">
                        <label for="agree_terms" class="pub-checkbox-label">
                            <input type="checkbox" id="agree_terms" name="agree_terms" value="1" required>
                            <span>Prečítal/-a som si <a href="obchodne-podmienky.php" target="_blank" rel="noopener">obchodné
                                podmienky predaja publikácií</a> a <a href="/privacy" target="_blank" rel="noopener">zásady
                                ochrany osobných údajov</a> a súhlasím s nimi. <span class="pub-required">*</span></span>
                        </label>
                    </div>

                    <div class="form-group pub-order-consent">
                        <label for="agree_immediate_delivery" class="pub-checkbox-label">
                            <input type="checkbox" id="agree_immediate_delivery" name="agree_immediate_delivery" value="1" required>
                            <span>Žiadam o dodanie digitálneho obsahu hneď po prijatí platby, teda pred
                                uplynutím 14-dňovej lehoty na odstúpenie od zmluvy, a beriem na vedomie,
                                že udelením tohto súhlasu <strong>stratím právo odstúpiť od zmluvy</strong>
                                po sprístupnení súborov. <span class="pub-required">*</span></span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Odoslať objednávku</button>
                        <a href="publikacie.php" class="btn-secondary">Späť na katalóg</a>
                    </div>
                </form>
            </section>

            <section class="form-section" aria-labelledby="pub-predajca-heading">
                <h3 id="pub-predajca-heading">Predávajúci a platba</h3>
                <div class="info-box-blue">
                    <dl class="donate-bank">
                        <dt>Predávajúci</dt>
                        <dd><?= htmlspecialchars($seller['name']) ?></dd>
                        <dt>IČO</dt>
                        <dd><?= htmlspecialchars($seller['companyId']) ?></dd>
                        <dt>DIČ</dt>
                        <dd><?= htmlspecialchars($seller['taxId']) ?></dd>
                        <?php if ($seller['address'] !== ''): ?>
                            <dt>Adresa</dt>
                            <dd><?= htmlspecialchars($seller['address']) ?></dd>
                        <?php endif; ?>
                        <dt>E-mail</dt>
                        <dd><a href="mailto:<?= htmlspecialchars($seller['email'], ENT_QUOTES) ?>"><?= htmlspecialchars($seller['email']) ?></a></dd>
                        <dt>DPH</dt>
                        <dd><?= htmlspecialchars($seller['vatNote']) ?></dd>
                    </dl>
                    <p class="donate-note">
                        Platí sa v eurách. Po odoslaní objednávky dostanete variabilný symbol,
                        IBAN aj QR kód pre <strong>bankový prevod</strong> a zároveň možnosť
                        zaplatiť <strong>kartou, Apple Pay či Google Pay (Stripe), cez PayPal,
                        Revolut, Ko-fi, Viamo</strong> alebo <strong>kryptomenou (Uphold)</strong>.
                        Na tejto stránke sa nezadávajú žiadne platobné údaje — platbu spracúva
                        vaša banka alebo vybraná služba.
                    </p>
                </div>
                <p class="pub-legal-link">
                    <a href="obchodne-podmienky.php">Obchodné podmienky predaja publikácií</a> ·
                    <a href="/terms">Podmienky používania</a> ·
                    <a href="/privacy">Ochrana osobných údajov</a>
                </p>
            </section>

        <?php endif; ?>
        </div>
    </main>

    <?php if ($publication !== null): ?>
    <script nonce="<?= htmlspecialchars(getScriptNonce(), ENT_QUOTES) ?>">
    (function () {
        var tokenField = document.getElementById('js_token_field');
        if (tokenField) {
            tokenField.value = "<?= htmlspecialchars(generateJsChallengeToken(), ENT_QUOTES) ?>";
        }

        // Priebežný prepočet ceny. Pravidlo je zhodné s publicationPriceFor()
        // na serveri — tu ide len o okamžitú spätnú väzbu, platná je serverová.
        var totalBox = document.getElementById('pubOrderTotal');
        var totalValue = document.getElementById('pubOrderTotalValue');
        if (!totalBox || !totalValue) { return; }

        var single = parseFloat(totalBox.getAttribute('data-price-single'));
        var bundle = parseFloat(totalBox.getAttribute('data-price-bundle'));
        var boxes = Array.prototype.slice.call(document.querySelectorAll('[data-pub-format]'));

        function render() {
            var count = boxes.filter(function (b) { return b.checked; }).length;
            var price = count === 0 ? 0 : (count === 1 ? single : bundle);
            totalValue.textContent = price.toFixed(2).replace('.', ',') + ' €';
        }

        boxes.forEach(function (b) { b.addEventListener('change', render); });
        render();
    })();
    </script>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>
</html>
