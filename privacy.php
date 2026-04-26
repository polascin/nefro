<?php
// Bezpečnostné HTTP hlavičky
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <meta name="description" content="Zásady ochrany osobných údajov pre projekt Nefro-projekt Slovensko.">
    <title>Privacy Policy | Nefro-projekt Slovensko</title>

    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;900&display=swap" rel="stylesheet">
    
    <!-- Cookie Consent Skript -->
    <script src="cookie-consent.js" defer></script>
</head>
<body>
    <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
    <header class="site-header" id="domov" role="banner" style="padding: 60px 0 40px;">
        <div class="container">
            <h1>Zásady ochrany osobných údajov</h1>
            <p class="intro">Privacy Policy & Cookie Policy</p>
        </div>
    </header>

    <nav class="main-nav" aria-label="Hlavná navigácia">
        <div class="container">
            <ul>
                <li><a href="index.php">Návrat na Domov</a></li>
            </ul>
        </div>
    </nav>

    <main id="main-content" class="container main-content" role="main" style="grid-template-columns: 1fr;">
        <div class="content-wrapper">
            <article class="primary-article">
                <header>
                    <h2>Ochrana osobných údajov (Privacy Policy)</h2>
                    <p class="meta">Posledná aktualizácia:&nbsp; <time datetime="2026-04-26">26. Apríl 2026</time></p>
                </header>
                
                <h3>1. Úvodné ustanovenia</h3>
                <p>Tieto Zásady ochrany osobných údajov ("Privacy Policy") vysvetľujú, ako zhromažďujeme, používame, zverejňujeme a chránime vaše informácie pri návšteve našej webovej stránky (ďalej len "Stránka"). Dodržiavame Nariadenie (EÚ) 2016/679 (GDPR), smernicu ePrivacy, a tiež zohľadňujeme medzinárodné štandardy vrátane CCPA/CPRA, pokiaľ ide o návštevníkov z príslušných regiónov.</p>
                
                <h3>2. Aké údaje zhromažďujeme</h3>
                <p>Môžeme o vás zhromažďovať informácie rôznymi spôsobmi:</p>
                <ul>
                    <li><strong>Osobné údaje:</strong> Meno, e-mailová adresa alebo iné kontaktné údaje, ktoré nám dobrovoľne poskytnete pri kontaktovaní.</li>
                    <li><strong>Derivované dáta:</strong> Informácie, ktoré naše servery automaticky zhromažďujú, ako je IP adresa, typ prehliadača, operačný systém, čas prístupu a stránky, ktoré ste si prezerali priamo pred a po prístupe na Stránku (prostredníctvom nevyhnutných aj analytických cookies).</li>
                </ul>

                <h3>3. Spracovanie a využitie vašich údajov</h3>
                <p>Vaše údaje používame predovšetkým na nasledujúce účely:</p>
                <ul>
                    <li>Zabezpečenie plynulého a bezpečného fungovania Stránky.</li>
                    <li>Vylepšovanie používateľského zážitku a analýza návštevnosti (na základe vášho súhlasu).</li>
                    <li>Komunikácia s vami (ak nás priamo kontaktujete).</li>
                </ul>
                <p><strong>Zdieľanie údajov:</strong> Vaše osobné údaje nepredávame, neobchodujeme s nimi ani ich neprenajímame tretím stranám. ("We do not sell your personal information" podľa CCPA/CPRA).</p>

                <h3>4. Práva dotknutých osôb (GDPR)</h3>
                <p>V zmysle GDPR máte nasledujúce práva:</p>
                <ul>
                    <li><strong>Právo na prístup:</strong> Máte právo požadovať kópiu svojich osobných údajov.</li>
                    <li><strong>Právo na opravu:</strong> Máte právo požadovať opravu nepresných údajov.</li>
                    <li><strong>Právo na vymazanie (právo „na zabudnutie“):</strong> Môžete požiadať o vymazanie svojich údajov.</li>
                    <li><strong>Právo na obmedzenie spracúvania a prenosnosť údajov.</strong></li>
                </ul>
                <p>Pre uplatnenie týchto práv nás kontaktujte na e-mailovej adrese: <code>nefro@polascin.net</code>.</p>

                <h3>5. Pravidlá používania súborov Cookies (Cookie Policy)</h3>
                <p>Naša stránka používa cookies. Pri prvej návšteve sa vám zobrazí banner, ktorý vám umožní vybrať si, ktoré kategórie cookies chcete povoliť.</p>
                <ul>
                    <li><strong>Nevyhnutné (Strictly Necessary):</strong> Tieto cookies sú potrebné pre fungovanie webových stránok a nemožno ich vypnúť v našich systémoch (napr. zapamätanie si samotného súhlasu).</li>
                    <li><strong>Analytické (Analytics):</strong> Umožňujú nám počítať návštevy a zdroje návštevnosti, aby sme mohli merať a zlepšovať výkonnosť našej stránky. Zbierané dáta sú agregované a anonymné.</li>
                    <li><strong>Marketingové (Marketing):</strong> Môžu byť nastavené našimi reklamnými partnermi na vytvorenie profilu vašich záujmov.</li>
                    <li><strong>Preferenčné (Preferences):</strong> Umožňujú stránke poskytovať vylepšenú funkcionalitu a prispôsobenie (napr. jazyk).</li>
                </ul>
                <p>Svoj súhlas môžete kedykoľvek zmeniť alebo odvolať kliknutím na odkaz "Nastavenia Cookies" v pätičke stránky.</p>
                <button onclick="window.openCookiePreferences()" class="btn-outline" style="margin-top: 10px;">Otvoriť nastavenia cookies</button>

                <h3>6. Zmeny v týchto pravidlách</h3>
                <p>Tieto Zásady ochrany osobných údajov môžeme z času na čas aktualizovať, aby odrážali zmeny v našich postupoch alebo z iných prevádzkových, právnych alebo regulačných dôvodov. Odporúčame vám, aby ste túto stránku pravidelne kontrolovali.</p>
                
            </article>
        </div>
    </main>

    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <p>&copy; 2026 Ľubomír Polaščín. Vytvorené s využitím moderných štandardov a s dôrazom na prístupnosť.</p>
            <p style="margin-top: 10px; font-size: 0.85rem;">
                <a href="privacy.php" style="color: #94a3b8; text-decoration: underline;">Ochrana osobných údajov (Privacy Policy)</a> | 
                <a href="#" onclick="event.preventDefault(); window.openCookiePreferences();" style="color: #94a3b8; text-decoration: underline;">Nastavenia Cookies</a>
            </p>
        </div>
    </footer>
</body>
</html>
