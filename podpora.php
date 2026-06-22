<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';

$siteName = "Nefro-projekt Slovensko";
$baseUrl = "https://nefro.polascin.net/";

// Bankové údaje príjemcu
$bank = [
    'recipient' => 'MUDr. Ľubomír Polaščín - Nephroctor',
    'iban_raw' => 'SK0311000000002943301908',
    'iban_pretty' => 'SK03 1100 0000 0029 4330 1908',
    'swift' => 'TATRSKBX',
    'bank_name' => 'Tatra banka, a.s.',
    'bank_address' => 'Hodžovo námestie 3, 811 06 Bratislava 1',
    'country' => 'Slovensko (SK)',
];

// Voliteľný PAY by square QR — zobrazí sa iba ak existuje obrázok
$qrImage = 'img/pay-by-square.png';
$hasQr = is_file(__DIR__ . '/' . $qrImage);

// PayPal — doplnkové spôsoby podpory (jeden alebo viac účtov)
$paypalAccounts = [
    'polascin@proton.me',
    'walter.csoelle@gmail.com',
];
$paypalDonateUrl = static function (string $email): string {
    return 'https://www.paypal.com/donate/?business=' . rawurlencode($email)
        . '&no_recurring=0&item_name=' . rawurlencode('Podpora Nefro-projekt Slovensko')
        . '&currency_code=EUR';
};

// Doplnkové platobné kanály (karta, Apple Pay, Google Pay, BLIK …).
// Zobrazia sa len tie, ktoré majú vyplnený odkaz — prázdny reťazec = skryté.
// Jeden odkaz na bránu/peňaženku spravidla pokryje kartu aj Apple/Google Pay naraz.
$payMethods = [
    [
        'name' => 'Revolut',
        'desc' => 'Karta, Apple Pay aj Google Pay jedným odkazom.',
        'url' => 'https://revolut.me/polascin',
        'cta' => 'Podporiť cez Revolut',
    ],
    [
        'name' => 'Ko‑fi',
        'desc' => 'Jednorazový aj opakovaný príspevok kartou alebo cez peňaženku.',
        'url' => '', // napr. https://ko-fi.com/tvoj-profil
        'cta' => 'Podporiť cez Ko‑fi',
    ],
    [
        // Pozn.: doplň PLATOBNÝ ODKAZ zo Stripe (Payment Link), nie e-mail účtu.
        // Vytvor v Stripe dashboarde: Payment links → New → výsledok https://buy.stripe.com/...
        'name' => 'Platobná karta (Stripe)',
        'desc' => 'Karta, Apple Pay, Google Pay aj BLIK cez zabezpečenú bránu.',
        'url' => '', // napr. https://buy.stripe.com/...
        'cta' => 'Zaplatiť kartou',
    ],
];
$enabledPayMethods = array_values(array_filter(
    $payMethods,
    static fn (array $m): bool => $m['url'] !== ''
));

// Kryptomeny — Uphold účet (príjem na e-mail účtu).
$upholdAccount = 'lubomir@polascin.net';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = "Podporiť projekt | " . $siteName;
  $canonicalUrl = $baseUrl . "podpora.php";
  $seoDescription =
      "Podporte nezávislý a bezplatný odborný portál Nefro-projekt Slovensko dobrovoľným príspevkom. Obsah, kalkulačky aj PDF zostávajú voľne dostupné, bez paywallu a reklám.";
  $structuredData = [
      [
          "@context" => "https://schema.org",
          "@type" => "WebPage",
          "name" => "Podporiť projekt — " . $siteName,
          "description" => $seoDescription,
          "url" => $canonicalUrl,
          "inLanguage" => "sk-SK",
      ],
      [
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
                  "name" => "Podporiť projekt",
                  "item" => $canonicalUrl,
              ],
          ],
      ],
  ];
  include "head_meta.php";
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = "Podporiť projekt";
    $headerIntro = "Pomôžte udržať nefrológiu voľne dostupnú";
    $showLogo = false;
    include "header.php";
    ?>

    <?php include 'main_nav.php'; ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">
            <div class="auth-container auth-container--wide">
                <h2>Podporte Nefro-projekt Slovensko</h2>
                <p class="auth-subtitle">Dobrovoľný príspevok na prevádzku a tvorbu odborného obsahu.</p>

                <p>
                    <strong><?= htmlspecialchars($siteName) ?></strong> je nezávislý odborný portál
                    o nefrológii, dialýze a internej medicíne. Celý obsah — odborné články, klinické
                    kalkulačky aj ich PDF verzie — zostáva <strong>voľne dostupný, bez paywallu a bez
                    reklám</strong>. Ak vám projekt pomáha v praxi alebo pri vzdelávaní, môžete jeho
                    fungovanie podporiť dobrovoľným príspevkom. Ďakujeme.
                </p>

                <section class="form-section" aria-labelledby="pouzitie-heading">
                    <h3 id="pouzitie-heading">Na čo prostriedky slúžia</h3>
                    <ul>
                        <li>hosting a doménové poplatky,</li>
                        <li>generovanie a uchovávanie PDF verzií článkov,</li>
                        <li>vývoj a údržba klinických kalkulačiek a nástrojov,</li>
                        <li>čas venovaný tvorbe, prekladu a aktualizácii odborného obsahu.</li>
                    </ul>
                </section>

                <section class="form-section" aria-labelledby="prevod-heading">
                    <h3 id="prevod-heading">Bankový prevod</h3>
                    <div class="info-box-blue">
                        <dl class="donate-bank">
                            <dt>Príjemca</dt>
                            <dd><?= htmlspecialchars($bank['recipient']) ?></dd>

                            <dt>IBAN</dt>
                            <dd>
                                <code class="donate-iban" id="donate-iban"><?= htmlspecialchars($bank['iban_pretty']) ?></code>
                                <button type="button" class="btn-secondary donate-copy-btn no-print"
                                        data-copy="<?= htmlspecialchars($bank['iban_raw']) ?>"
                                        aria-label="Kopírovať IBAN do schránky">Kopírovať IBAN</button>
                            </dd>

                            <dt>SWIFT / BIC</dt>
                            <dd><code><?= htmlspecialchars($bank['swift']) ?></code></dd>

                            <dt>Banka</dt>
                            <dd><?= htmlspecialchars($bank['bank_name']) ?></dd>

                            <dt>Adresa banky</dt>
                            <dd><?= htmlspecialchars($bank['bank_address']) ?></dd>

                            <dt>Krajina</dt>
                            <dd><?= htmlspecialchars($bank['country']) ?></dd>
                        </dl>
                        <p class="donate-note">
                            Pri platbe zo zahraničia použite IBAN a SWIFT/BIC. Do poznámky pre prijímateľa
                            môžete uviesť napríklad <em>„Podpora projektu"</em>.
                        </p>
                    </div>

                    <?php if ($hasQr): ?>
                        <figure class="donate-qr">
                            <img src="<?= htmlspecialchars($qrImage) ?>" alt="PAY by square QR kód pre platbu na účet projektu" width="220" height="220" loading="lazy">
                            <figcaption>Naskenujte QR kód (PAY by square) v mobilnej aplikácii vašej banky.</figcaption>
                        </figure>
                    <?php endif; ?>
                </section>

                <section class="form-section" aria-labelledby="paypal-heading">
                    <h3 id="paypal-heading">PayPal</h3>
                    <p>Prispieť môžete aj cez PayPal — rýchlo a bez zadávania bankových údajov.
                        Vyberte si ktorýkoľvek z účtov:</p>
                    <ul class="donate-paypal-list">
                        <?php foreach ($paypalAccounts as $ppEmail): ?>
                        <li class="donate-paypal-row">
                            <code><?= htmlspecialchars($ppEmail) ?></code>
                            <a href="<?= htmlspecialchars($paypalDonateUrl($ppEmail)) ?>" class="btn-primary" target="_blank" rel="noopener noreferrer">Podporiť cez PayPal</a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <?php if ($enabledPayMethods): ?>
                <section class="form-section" aria-labelledby="karta-heading">
                    <h3 id="karta-heading">Platobná karta, Apple Pay a Google Pay</h3>
                    <p>Rýchly príspevok platobnou kartou alebo cez mobilnú peňaženku — bez zadávania
                        bankových údajov. Vyberte si službu:</p>
                    <ul class="donate-paypal-list">
                        <?php foreach ($enabledPayMethods as $m): ?>
                        <li class="donate-paypal-row">
                            <span><strong><?= htmlspecialchars($m['name']) ?></strong> — <?= htmlspecialchars($m['desc']) ?></span>
                            <a href="<?= htmlspecialchars($m['url']) ?>" class="btn-primary" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($m['cta']) ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
                <?php endif; ?>

                <section class="form-section" aria-labelledby="crypto-heading">
                    <h3 id="crypto-heading">Kryptomeny (Uphold)</h3>
                    <p>Ak používate <a href="https://uphold.com/" target="_blank" rel="noopener noreferrer">Uphold</a>,
                        môžete poslať príspevok v kryptomene priamo na účet zadaním e-mailu príjemcu:</p>
                    <div class="info-box-blue">
                        <dl class="donate-bank">
                            <dt>Uphold účet</dt>
                            <dd>
                                <code id="donate-uphold"><?= htmlspecialchars($upholdAccount) ?></code>
                                <button type="button" class="btn-secondary donate-copy-btn no-print"
                                        data-copy="<?= htmlspecialchars($upholdAccount) ?>"
                                        aria-label="Kopírovať Uphold účet do schránky">Kopírovať</button>
                            </dd>
                        </dl>
                        <p class="donate-note">
                            V aplikácii Uphold zvoľte <em>Send</em>, zadajte uvedený e-mail a vyberte
                            kryptomenu. Príjem na e-mail účtu nevyžaduje zverejnenie konkrétnej adresy peňaženky.
                        </p>
                    </div>
                </section>

                <div class="info-box-green">
                    <strong>Dôležité:</strong> príspevok je <strong>dobrovoľný dar</strong> na podporu
                    prevádzky a tvorby obsahu. Nejde o platbu za tovar ani službu a nezakladá nárok na
                    protiplnenie. Prevádzkovateľ nie je registrovaná nezisková organizácia, preto dar
                    nie je daňovo uznateľný. Platby sa nespracúvajú na tejto stránke — uskutočňujú sa
                    priamo cez vašu banku, peňaženku alebo platobnú službu (napr. PayPal, Revolut,
                    Ko‑fi, Stripe či Uphold).
                </div>

                <p>
                    Podporiť projekt môžete aj <strong>bez jediného eura</strong> — zdieľaním článkov,
                    spätnou väzbou alebo odberom noviniek. Novinky a nové články dostávate na e-mail
                    zadarmo a odhlásiť sa môžete kedykoľvek.
                </p>

                <div class="form-actions">
                    <a href="index.php#kontakt" class="btn-primary">Odoberať novinky</a>
                    <a href="index.php" class="btn-secondary">Späť na úvod</a>
                </div>
            </div>
        </div>
    </main>

    <script nonce="<?= htmlspecialchars(function_exists('getScriptNonce') ? getScriptNonce() : '', ENT_QUOTES) ?>">
    (function () {
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

    <?php include "footer.php"; ?>
</body>
</html>
