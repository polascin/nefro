<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */

$siteName = 'Nefro-projekt Slovensko';
$baseUrl  = 'https://nefro.polascin.net/';

// --- Údaje o pracovisku ------------------------------------------------------
$center = [
    'brand'        => 'Medimpax',
    'fullName'     => 'Dialyzačné stredisko a nefrologická ambulancia Medimpax',
    'operator'     => 'Impax Trading, spol. s r.o.',
    'seatAddress'  => 'Dúbravská cesta 9, 842 36 Bratislava',
    'siteAddress'  => 'Na vrátkach 2/A, 841 01 Bratislava-Dúbravka',
    'email'        => 'medimpax@impax.sk',
    'website'      => 'https://www.impax.sk/',
    'ico'          => '17320097',
    'dic'          => '2020300447',
    'icdph'        => 'SK2020300447',
    'register'     => 'Mestský súd Bratislava III, oddiel: Sro, vložka č. 1032/B',
];

// Odkazy na verejné registre prevádzkovateľa
$registryLinks = [
    ['label' => 'Obchodný register SR (ORSR)', 'url' => 'https://www.orsr.sk/hladaj_ico.asp?ICO=17320097&SID=0'],
    ['label' => 'FinStat', 'url' => 'https://finstat.sk/17320097'],
    ['label' => 'Register účtovných závierok', 'url' => 'https://www.registeruz.sk/cruz-public/domain/accountingentity/simplesearch?ico=17320097'],
    ['label' => 'Poskytovateľ ZS (e-VUC)', 'url' => 'https://www.e-vuc.sk/e-vuc/poskytovatelia/impax-trading-spol.-s-r.-o..html?page_id=107502'],
];

// Pacientske kontakty (zobrazené prominentne)
$patientContacts = [
    [
        'label'   => 'Dialyzačná sála',
        'display' => '0947 900 202',
        'tel'     => '+421947900202',
    ],
    [
        'label'   => 'Nefrologická ambulancia',
        'display' => '0940 609 480',
        'tel'     => '+421940609480',
    ],
];

// Mapový odkaz (bez embed iframe — CSP default-src 'self' blokuje frame-src)
$mapUrl = 'https://www.google.com/maps/search/?api=1&query='
    . rawurlencode('Na vrátkach 2/A, 841 01 Bratislava-Dúbravka');
// Street View / fotka miesta na Google Mapách (zdieľaný odkaz strediska)
$streetViewUrl = 'https://maps.app.goo.gl/8UkFRAYMvbkr5PT26';

// --- Služby ------------------------------------------------------------------
$services = [
    [
        'icon'  => '🩸',
        'color' => 'service-card--blue',
        'title' => 'Hemodialýza a hemodiafiltrácia',
        'desc'  => 'Pravidelná chronická aj akútna náhrada funkcie obličiek na dialyzačných monitoroch B. Braun Dialog iQ®.',
        'list'  => [
            'Hemodialýza (HD)',
            'Hemodiafiltrácia (HDF) — vyššia eliminácia urémických toxínov',
            'Jednoihlový (single-needle) režim podľa potreby',
            'Biofeedback BioLogic Fusion pre hemodynamickú stabilitu',
        ],
    ],
    [
        'icon'  => '🏠',
        'color' => 'service-card--green',
        'title' => 'Peritoneálna dialýza',
        'desc'  => 'Domáca dialýza s podporou strediska — kontinuálna ambulantná (CAPD) aj automatizovaná (APD) forma.',
        'list'  => [
            'CAPD — ručné výmeny dialyzačného roztoku',
            'APD — automatizovaná dialýza počas spánku (cykler)',
            'Vzdialené sledovanie liečby (telemedicína Sharesource)',
            'Edukácia pacienta a rodinných príslušníkov',
        ],
    ],
    [
        'icon'  => '🌴',
        'color' => 'service-card--orange',
        'title' => 'Prázdninové (dovolenkové) dialýzy',
        'desc'  => 'Hosťovská dialýza pre pacientov na cestách — počas pobytu v Bratislave a okolí.',
        'list'  => [
            'Hosťovská HD/HDF počas dovolenky či pracovnej cesty',
            'Pre slovenských aj zahraničných pacientov',
            'Vybavenie po dohode podľa voľnej kapacity',
            'Kontinuita dialyzačného režimu mimo domovského strediska',
        ],
    ],
    [
        'icon'  => '🩺',
        'color' => 'service-card--purple',
        'title' => 'Nefrologická ambulancia',
        'desc'  => 'Preventívna a klinická nefrológia — diagnostika a manažment ochorení obličiek.',
        'list'  => [
            'Preventívne a klinické nefrologické vyšetrenia',
            'Manažment chronického ochorenia obličiek (CKD)',
            'Poradňa pre prípravu na zaradenie do dialyzačného programu',
            'Sledovanie pacientov pred dialýzou aj v dialyzačnom programe',
        ],
    ],
    [
        'icon'  => '📡',
        'color' => 'service-card--blue',
        'title' => 'Ultrazvukové vyšetrenia',
        'desc'  => 'Ultrasonografia v rámci nefrologickej ambulancie.',
        'list'  => [
            'Ultrazvuk obličiek',
            'Ultrazvuk močových ciest',
            'Ultrazvuk brucha',
        ],
    ],
    [
        'icon'  => '🧭',
        'color' => 'service-card--green',
        'title' => 'Poradňa pred dialýzou',
        'desc'  => 'Príprava na zaradenie do chronického hemodialyzačného alebo peritoneálneho dialyzačného programu.',
        'list'  => [
            'Voľba dialyzačnej modality (HD vs. PD)',
            'Informovanie o priebehu a režime liečby',
            'Plánovanie cievneho prístupu / PD katétra',
            'Sprevádzanie pacienta pri rozhodovaní',
        ],
    ],
];

// --- Firemné / obchodné kontakty (zverejnené v plnom rozsahu) ----------------
$businessContacts = [
    [
        'name'  => 'Ing. Branislav Halanda',
        'role'  => 'Konateľ',
        'lines' => [
            ['display' => '02/54789192',      'tel' => '+421254789192'],
            ['display' => '+421 903 210 584', 'tel' => '+421903210584'],
        ],
        'email' => 'halanda@impax.sk',
    ],
    [
        'name'  => 'Robert Velmovský',
        'role'  => 'Logistika, rozvoz',
        'lines' => [
            ['display' => '+421 904 027 527', 'tel' => '+421904027527'],
        ],
        'email' => '',
    ],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <?php
  $pageTitle = 'Dialýza Bratislava — dialyzačné stredisko a nefrologická ambulancia | ' . $siteName;
  $canonicalUrl = $baseUrl . 'dialyza-bratislava.php';
  $seoDescription =
      'Dialyzačné stredisko a nefrologická ambulancia Medimpax v Bratislave-Dúbravke: hemodialýza, '
      . 'hemodiafiltrácia, peritoneálna dialýza, dovolenkové dialýzy, USG a poradňa pred dialýzou.';
  $seoKeywords =
      'dialýza Bratislava, dialyzačné stredisko Dúbravka, hemodialýza, hemodiafiltrácia, '
      . 'peritoneálna dialýza Bratislava, dovolenková dialýza, holiday dialysis Bratislava, '
      . 'nefrologická ambulancia Bratislava, Medimpax';
  $ogType = 'website';

  $structuredData = [
      [
          '@context'        => 'https://schema.org',
          '@type'           => 'MedicalClinic',
          'name'            => $center['fullName'],
          'alternateName'   => $center['brand'],
          'url'             => $canonicalUrl,
          'email'           => $center['email'],
          'telephone'       => '+421947900202',
          'medicalSpecialty' => 'Renal',
          'address'         => [
              '@type'           => 'PostalAddress',
              'streetAddress'   => 'Na vrátkach 2/A',
              'addressLocality' => 'Bratislava-Dúbravka',
              'postalCode'      => '841 01',
              'addressCountry'  => 'SK',
          ],
          'geo'             => [
              '@type'     => 'GeoCoordinates',
              'latitude'  => 48.1903299,
              'longitude' => 17.0442423,
          ],
          'hasMap'          => $mapUrl,
          'availableService' => [
              ['@type' => 'MedicalProcedure', 'name' => 'Hemodialýza'],
              ['@type' => 'MedicalProcedure', 'name' => 'Hemodiafiltrácia (HDF)'],
              ['@type' => 'MedicalProcedure', 'name' => 'Peritoneálna dialýza'],
              ['@type' => 'MedicalProcedure', 'name' => 'Prázdninová (dovolenková) dialýza'],
              ['@type' => 'MedicalProcedure', 'name' => 'Ultrasonografia obličiek, močových ciest a brucha'],
          ],
          'department'      => [
              '@type'     => 'MedicalClinic',
              'name'      => 'Nefrologická ambulancia',
              'telephone' => '+421940609480',
          ],
          'provider'        => [
              '@type'      => 'Organization',
              'name'       => $center['operator'],
              'url'        => $center['website'],
              'identifier' => $center['ico'],
              'vatID'      => $center['icdph'],
              'address'    => [
                  '@type'           => 'PostalAddress',
                  'streetAddress'   => 'Dúbravská cesta 9',
                  'addressLocality' => 'Bratislava',
                  'postalCode'      => '842 36',
                  'addressCountry'  => 'SK',
              ],
          ],
      ],
      [
          '@context'        => 'https://schema.org',
          '@type'           => 'BreadcrumbList',
          'itemListElement' => [
              ['@type' => 'ListItem', 'position' => 1, 'name' => 'Domov', 'item' => $baseUrl],
              ['@type' => 'ListItem', 'position' => 2, 'name' => 'Dialýza Bratislava', 'item' => $canonicalUrl],
          ],
      ],
  ];
  include 'head_meta.php';
  ?>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>

    <?php
    $headerTitle = 'Dialyzačné stredisko a nefrologická ambulancia';
    $headerIntro = 'Medimpax — Bratislava-Dúbravka';
    $showLogo = false;
    include 'header.php';
    ?>

    <main id="main-content" class="container main-content main-content--single-col" role="main">
        <div class="content-wrapper">

            <section class="features-section" aria-labelledby="uvod-heading">
                <h2 id="uvod-heading">Dialýza a nefrologická starostlivosť v Bratislave</h2>
                <p>
                    <strong><?= htmlspecialchars($center['fullName']) ?></strong> poskytuje komplexnú
                    starostlivosť pacientom s ochorením obličiek — od preventívnej a klinickej nefrológie
                    cez prípravu na dialýzu až po samotnú dialyzačnú liečbu. Pracovisko sídli na adrese
                    <strong><?= htmlspecialchars($center['siteAddress']) ?></strong>.
                </p>

                <div class="info-box-blue">
                    <h3>Rýchly kontakt</h3>
                    <dl class="donate-bank">
                        <?php foreach ($patientContacts as $c): ?>
                            <dt><?= htmlspecialchars($c['label']) ?></dt>
                            <dd><a href="tel:<?= htmlspecialchars($c['tel']) ?>"><?= htmlspecialchars($c['display']) ?></a></dd>
                        <?php endforeach; ?>
                        <dt>E-mail</dt>
                        <dd><a href="mailto:<?= htmlspecialchars($center['email']) ?>"><?= htmlspecialchars($center['email']) ?></a></dd>
                        <dt>Adresa</dt>
                        <dd>
                            <?= htmlspecialchars($center['siteAddress']) ?>
                            &nbsp;·&nbsp;
                            <a href="<?= htmlspecialchars($mapUrl) ?>" target="_blank" rel="noopener noreferrer">Zobraziť na mape</a>
                            &nbsp;·&nbsp;
                            <a href="<?= htmlspecialchars($streetViewUrl) ?>" target="_blank" rel="noopener noreferrer">Street View</a>
                        </dd>
                    </dl>
                </div>
            </section>

            <section class="features-section" id="mapa" aria-labelledby="mapa-heading">
                <h2 id="mapa-heading">Kde nás nájdete</h2>
                <figure class="place-figure">
                    <img src="img/impax.png" alt="Dialyzačné stredisko a nefrologická ambulancia Medimpax, Na vrátkach 2/A, Bratislava-Dúbravka" width="1108" height="826" loading="lazy" decoding="async">
                    <figcaption><?= htmlspecialchars($center['siteAddress']) ?></figcaption>
                </figure>
                <iframe class="map-embed" title="Mapa — Dialyzačné stredisko Medimpax, Na vrátkach 2/A, Bratislava-Dúbravka"
                        src="https://maps.google.com/maps?q=48.1903299,17.0442423&amp;hl=sk&amp;z=17&amp;output=embed"
                        width="100%" height="380" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <p class="donate-note">
                    <a href="<?= htmlspecialchars($mapUrl) ?>" target="_blank" rel="noopener noreferrer">Otvoriť v Google Mapách</a>
                    &nbsp;·&nbsp;
                    <a href="<?= htmlspecialchars($streetViewUrl) ?>" target="_blank" rel="noopener noreferrer">Street View</a>
                </p>
            </section>

            <section class="features-section" aria-labelledby="sluzby-heading">
                <h2 id="sluzby-heading">Naše služby</h2>
                <div class="features-grid">
                    <?php foreach ($services as $s): ?>
                        <div class="feature-card service-card <?= htmlspecialchars($s['color']) ?>">
                            <div class="service-card__icon" aria-hidden="true"><?= $s['icon'] ?></div>
                            <h3><?= htmlspecialchars($s['title']) ?></h3>
                            <p><?= htmlspecialchars($s['desc']) ?></p>
                            <ul class="service-card__list">
                                <?php foreach ($s['list'] as $item): ?>
                                    <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="features-section" aria-labelledby="vybavenie-heading">
                <h2 id="vybavenie-heading">Vybavenie</h2>
                <div class="features-grid">
                    <div class="feature-card service-card service-card--blue">
                        <div class="service-card__icon" aria-hidden="true">🩸</div>
                        <h3>Hemodialýza — B. Braun Dialog iQ®</h3>
                        <p>Dialyzačné monitory B. Braun Dialog iQ® s adaptívnym systémom podporujúcim individualizáciu liečby.</p>
                        <ul class="service-card__list">
                            <li>Hemodialýza aj hemodiafiltrácia (HDF) na jednom prístroji</li>
                            <li>BioLogic Fusion — biofeedback (systolický tlak + relatívny objem krvi)</li>
                            <li>Plynulé prispôsobenie ultrafiltračnej rýchlosti pre hemodynamickú stabilitu</li>
                            <li>Jednoihlový (single-needle) režim podľa potreby</li>
                        </ul>
                    </div>
                    <div class="feature-card service-card service-card--green">
                        <div class="service-card__icon" aria-hidden="true">🏠</div>
                        <h3>Peritoneálna dialýza — CAPD a APD</h3>
                        <p>Domáca dialýza s ručnými výmenami (CAPD) aj s automatizovaným cyklerom (APD).</p>
                        <ul class="service-card__list">
                            <li>Automatizovaná PD počas spánku (cykler, napr. HomeChoice Claria)</li>
                            <li>Vzdialené sledovanie liečby cez platformu Sharesource</li>
                            <li>Roztoky na báze glukózy, ikodextrínu a aminokyselín</li>
                            <li>Antimikrobiálny uzáver katétra (napr. Citra-Lock™)</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="features-section" id="lekar" aria-labelledby="lekar-heading">
                <h2 id="lekar-heading">Lekár strediska</h2>
                <div class="info-box-blue">
                    <p>
                        Od <strong>1. augusta 2026</strong> v stredisku pôsobím ako
                        <strong>lekár — špecialista v odbore nefrológia</strong>.
                        Na portáli <a href="index.php">Nefro-projekt Slovensko</a> sa venujem
                        odbornému aj pacientskemu vzdelávaniu v nefrológii, dialýze a internej medicíne;
                        v stredisku Medimpax túto starostlivosť poskytujem priamo v klinickej praxi.
                    </p>
                    <p class="donate-note">— MUDr. Ľubomír Polaščín</p>
                </div>
            </section>

            <section class="features-section" id="holiday-dialysis" aria-labelledby="en-heading">
                <h2 id="en-heading">Holiday dialysis in Bratislava (EN)</h2>
                <div class="info-box-green">
                    <p>
                        <strong>Medimpax Dialysis Centre</strong> in Bratislava-Dúbravka, Slovakia, welcomes
                        visiting patients for <strong>holiday (guest) dialysis</strong>. We provide
                        <strong>haemodialysis and haemodiafiltration (HDF)</strong> on B. Braun Dialog iQ®
                        machines, as well as <strong>peritoneal dialysis</strong> support and a nephrology
                        out-patient clinic.
                    </p>
                    <p>
                        Planning a stay in Bratislava and need a dialysis session? Please contact us in advance
                        to arrange a slot subject to capacity.
                    </p>
                    <dl class="donate-bank">
                        <dt>Dialysis room</dt>
                        <dd><a href="tel:+421947900202">+421 947 900 202</a></dd>
                        <dt>Nephrology clinic</dt>
                        <dd><a href="tel:+421940609480">+421 940 609 480</a></dd>
                        <dt>E-mail</dt>
                        <dd><a href="mailto:<?= htmlspecialchars($center['email']) ?>"><?= htmlspecialchars($center['email']) ?></a></dd>
                        <dt>Address</dt>
                        <dd><?= htmlspecialchars($center['siteAddress']) ?></dd>
                    </dl>
                </div>
            </section>

            <section class="features-section" id="prevadzkovatel" aria-labelledby="prevadzkovatel-heading">
                <h2 id="prevadzkovatel-heading">Prevádzkovateľ a kontakty</h2>

                <div class="info-box-blue">
                    <dl class="donate-bank">
                        <dt>Prevádzkovateľ</dt>
                        <dd><?= htmlspecialchars($center['operator']) ?></dd>
                        <dt>Sídlo spoločnosti</dt>
                        <dd><?= htmlspecialchars($center['seatAddress']) ?></dd>
                        <dt>Prevádzka</dt>
                        <dd><?= htmlspecialchars($center['siteAddress']) ?></dd>
                        <dt>IČO</dt>
                        <dd><?= htmlspecialchars($center['ico']) ?></dd>
                        <dt>DIČ</dt>
                        <dd><?= htmlspecialchars($center['dic']) ?></dd>
                        <dt>IČ DPH</dt>
                        <dd><?= htmlspecialchars($center['icdph']) ?></dd>
                        <dt>Zápis</dt>
                        <dd><?= htmlspecialchars($center['register']) ?></dd>
                        <dt>Web</dt>
                        <dd><a href="<?= htmlspecialchars($center['website']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($center['website']) ?></a></dd>
                        <dt>E-mail</dt>
                        <dd><a href="mailto:<?= htmlspecialchars($center['email']) ?>"><?= htmlspecialchars($center['email']) ?></a></dd>
                    </dl>
                    <p class="donate-note">
                        Verejné registre:
                        <?php foreach ($registryLinks as $i => $r): ?>
                            <?= $i > 0 ? ' · ' : '' ?><a href="<?= htmlspecialchars($r['url']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($r['label']) ?></a>
                        <?php endforeach; ?>
                    </p>
                </div>

                <div class="features-grid">
                    <?php foreach ($businessContacts as $bc): ?>
                        <div class="feature-card">
                            <h3><?= htmlspecialchars($bc['name']) ?></h3>
                            <p><?= htmlspecialchars($bc['role']) ?></p>
                            <ul class="service-card__list">
                                <?php foreach ($bc['lines'] as $line): ?>
                                    <li><a href="tel:<?= htmlspecialchars($line['tel']) ?>"><?= htmlspecialchars($line['display']) ?></a></li>
                                <?php endforeach; ?>
                                <?php if ($bc['email'] !== ''): ?>
                                    <li><a href="mailto:<?= htmlspecialchars($bc['email']) ?>"><?= htmlspecialchars($bc['email']) ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <div class="info-box-green">
                <strong>Informácia:</strong> obsah tejto stránky má informatívny charakter o poskytovaných
                službách a nenahrádza odborné lekárske vyšetrenie ani konzultáciu. O vhodnosti a rozsahu
                liečby rozhoduje ošetrujúci lekár. Dostupnosť dovolenkových dialýz závisí od voľnej kapacity.
            </div>

            <div class="form-actions">
                <a href="mailto:<?= htmlspecialchars($center['email']) ?>" class="btn-primary">Napísať e-mail</a>
                <a href="index.php" class="btn-secondary">Späť na úvod</a>
            </div>

        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
