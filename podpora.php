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
                                        data-iban="<?= htmlspecialchars($bank['iban_raw']) ?>"
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

                <div class="info-box-green">
                    <strong>Dôležité:</strong> príspevok je <strong>dobrovoľný dar</strong> na podporu
                    prevádzky a tvorby obsahu. Nejde o platbu za tovar ani službu a nezakladá nárok na
                    protiplnenie. Prevádzkovateľ nie je registrovaná nezisková organizácia, preto dar
                    nie je daňovo uznateľný. Platby sa nespracúvajú na tejto stránke — uskutočňujú sa
                    priamo cez vašu banku.
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
        var btn = document.querySelector('.donate-copy-btn');
        if (!btn || !navigator.clipboard) { return; }
        btn.addEventListener('click', function () {
            navigator.clipboard.writeText(btn.getAttribute('data-iban') || '').then(function () {
                var original = btn.textContent;
                btn.textContent = 'Skopírované ✓';
                setTimeout(function () { btn.textContent = original; }, 2000);
            }).catch(function () {});
        });
    })();
    </script>

    <?php include "footer.php"; ?>
</body>
</html>
