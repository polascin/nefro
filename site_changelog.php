<?php

declare(strict_types=1);

/**
 * site_changelog.php
 * ════════════════════════════════════════════════════════════════════════════
 * Zoznam zmien portálu mimo článkov — nové kalkulačky, interaktívne nástroje,
 * databázy a úpravy ostatných častí webu. Používa ho týždenný newsletter
 * (newsletter_weekly_digest.php), aby okrem nových článkov avizoval aj to,
 * čo pribudlo v zvyšku portálu.
 *
 * Ako pridať záznam
 * ─────────────────
 * Nový záznam pridaj do toho istého commitu ako samotnú zmenu a do poľa
 * `date` zapíš dátum a čas, kedy zmena išla naživo (formát "Y-m-d H:i").
 * Newsletter posiela záznamy, ktoré padnú do okna od konca posledného behu
 * po teraz — pri samotnom dátume bez času sa berie 00:00, takže spätne
 * dopĺňaný záznam sa už nemusí odoslať.
 *
 * Polia
 * ─────
 *   date        "Y-m-d H:i" (alebo "Y-m-d") — kedy zmena išla naživo
 *   category    kľúč z siteChangelogCategoryLabels(): calculators | tools
 *               | content | portal
 *   title       krátky názov zmeny (bez bodky na konci)
 *   description jedna-dve vety, čo to používateľovi prináša
 *   url         relatívna cesta na portáli (napr. "calculators.php")
 *               alebo prázdne, ak zmena nemá vlastnú stránku
 *
 * Najnovšie záznamy sú hore.
 * ════════════════════════════════════════════════════════════════════════════
 */

if (!function_exists('siteChangelogCategoryLabels')) {
    /**
     * @return array<string, string>
     */
    function siteChangelogCategoryLabels(): array
    {
        return [
            'calculators' => 'Kalkulačky',
            'tools' => 'Interaktívne nástroje',
            'content' => 'Obsah a databázy',
            'portal' => 'Portál a účet',
        ];
    }
}

if (!function_exists('siteChangelogEntries')) {
    /**
     * @return list<array{date: string, category: string, title: string, description: string, url: string}>
     */
    function siteChangelogEntries(): array
    {
        return [
            [
                'date' => '2026-11-07 07:05',
                'category' => 'portal',
                'title' => 'Prístupnosť: jeden hlavný nadpis na stránke',
                'description' => 'Hlavným nadpisom stránky je teraz jej vlastný názov (napríklad titulok článku), nie názov portálu v hlavičke. Čítačky obrazovky a vyhľadávače tak správne rozpoznajú, o čom stránka je. Vzhľad sa nemení.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-07 05:17',
                'category' => 'portal',
                'title' => 'Rýchlejšia registrácia a úprava profilu',
                'description' => 'Zoznam obcí, PSČ a okresov pre automatické doplnenie adresy sa do stránky vkladá úspornejšie. Stránka registrácie sa tým zmenšila z 1,5 MB na približne tretinu; doplnenie PSČ, okresu a kraja po výbere obce funguje ako doteraz.',
                'url' => 'register.php',
            ],
            [
                'date' => '2026-11-06 22:54',
                'category' => 'portal',
                'title' => 'Formulár na oznámenie nezákonného obsahu sa zobrazuje správne',
                'description' => 'Stránka kontaktného miesta podľa aktu o digitálnych službách nemala úplnú hlavičku dokumentu, takže sa zobrazovala bez štýlov portálu. Teraz má rovnakú podobu ako ostatné právne stránky.',
                'url' => 'content_report.php',
            ],
            [
                'date' => '2026-11-06 21:57',
                'category' => 'portal',
                'title' => 'Rýchlejšie stránky článkov: výber autora len na hlavnej stránke',
                'description' => 'Zoznam všetkých autorov zdrojových článkov (vyše 2 500 mien) sa už nevkladá do každej stránky článku, čím sa stránka zmenšila zhruba o 200 kB. Odkaz „Vyhľadať ďalšieho autora“ otvorí rovnaký výber na hlavnej stránke.',
                'url' => 'index.php?autori=1#autori-vyhladanie',
            ],
            [
                'date' => '2026-11-06 21:27',
                'category' => 'calculators',
                'title' => 'Ambulantná kalkulačka: CKM pri G4 bez albuminúrie',
                'description' => 'Pri potvrdenej CKD s eGFR pod 30 bez zadaného uACR kalkulačka zaraďuje CKM štádium 3, lebo riadky G4 a G5 heatmapy KDIGO sú veľmi vysoké riziko pri každej kategórii albuminúrie. Popis štádia 3 teraz uvádza aj veľmi vysoké riziko CKD.',
                'url' => 'calculator_ambulatory.php',
            ],
            [
                'date' => '2026-11-06 20:58',
                'category' => 'calculators',
                'title' => 'KDIGO heatmapa: G4 s albuminúriou A1 je veľmi vysoké riziko',
                'description' => 'Kombinácia G4 (eGFR 15 až 29) a A1 sa v KDIGO kalkulačke a v Ambulantnej kalkulačke zobrazovala ako vysoké riziko. Podľa heatmapy KDIGO je celý riadok G4 veľmi vysoké riziko; opravené. Ostatné bunky sa nemenia.',
                'url' => 'calculator_kdigo_risk.php',
            ],
            [
                'date' => '2026-11-06 20:26',
                'category' => 'calculators',
                'title' => 'Mayo klasifikácia ADPKD: triedy podľa ročného prírastku a opravená citácia',
                'description' => 'Triedy 1A až 1E sa určujú podľa ročného percentuálneho prírastku HtTKV (< 1,5 / 3 / 4,5 / 6 %), ako ho definuje Irazabal a kol. Doteraz sa porovnávala logaritmická miera rastu, takže napríklad prírastok 6,1 %/rok sa zaradil do 1D namiesto 1E. Opravená je aj citácia: J Am Soc Nephrol 2015;26(1):160–172 (PMID 24904092).',
                'url' => 'calculator_adpkd.php',
            ],
            [
                'date' => '2026-11-06 19:50',
                'category' => 'calculators',
                'title' => 'Gupta skóre (CP-AKI): hranica horčíka podľa zdroja',
                'description' => 'Bod za horčík sa prideľuje pri hodnote < 0,82 mmol/l, ako uvádza Gupta a kol. (BMJ 2024). Doteraz sa porovnávalo s 2,0 mg/dl, preto hodnota presne 0,82 mmol/l chybne pridala bod. Ostatné premenné a kategórie rizika sa nemenia.',
                'url' => 'calculator_gupta.php',
            ],
            [
                'date' => '2026-11-05 21:15',
                'category' => 'calculators',
                'title' => 'Prevodník jednotiek: spoločné konverzné faktory',
                'description' => 'Konverzné faktory SI ⇄ konvenčné (vrátane eGFR ml/min ⇄ ml/s) sú v spoločnej funkcii s referenčnými testami. Živý prevodník na stránke ostáva klientský; číselné faktory sa nemenia.',
                'url' => 'calculator_units.php',
            ],
            [
                'date' => '2026-11-05 20:55',
                'category' => 'calculators',
                'title' => 'Mehran skóre: spoločná funkcia a citácia',
                'description' => 'Celkové Mehran skóre CI-AKI je v spoločnej funkcii s referenčnými testami (body, hranice veku a eGFR, kategórie rizika). Na stránke je doplnená citácia Mehran 2004 (PMID 15464318); číselné výsledky sa nemenia.',
                'url' => 'calculator_mehran.php',
            ],
            [
                'date' => '2026-11-05 20:40',
                'category' => 'calculators',
                'title' => 'Očakávané pCO₂ pri metabolickej alkalóze',
                'description' => 'Pri HCO₃ nad 24 mmol/L kalkulačka aniónovej medzery dopočíta očakávané pCO₂ podľa Javaheriho vzťahu (0,7 · HCO₃ + 20 ± 5 mmHg) a voliteľne porovná namerané pCO₂ s týmto pásmom. Wintersova rovnica ostáva pre metabolickú acidózu.',
                'url' => 'calculator_acidbase.php',
            ],
            [
                'date' => '2026-11-05 20:20',
                'category' => 'calculators',
                'title' => 'Wintersova kompenzácia v acidobázickej kalkulačke',
                'description' => 'Pri metabolickej acidóze kalkulačka aniónovej medzery dopočíta očakávané pCO₂ podľa Wintersovej rovnice (1,5 · HCO₃ + 8 ± 2 mmHg) a voliteľne porovná namerané pCO₂ s týmto pásmom.',
                'url' => 'calculator_acidbase.php',
            ],
            [
                'date' => '2026-11-05 17:10',
                'category' => 'portal',
                'title' => 'Jazyková a typografická korektúra textov portálu',
                'description' => 'Doplnená chýbajúca diakritika v popiskoch profilu a registrácie, opravené čechizmy v textoch, nezlomiteľné medzery medzi číslom a jednotkou (mg, ml, %, mmHg, hodiny) v kalkulačkách, správach aj článkoch a odstránené koncové medzery v kóde. Žiadna funkčná zmena.',
                'url' => '',
            ],
            [
                'date' => '2026-11-03 08:15',
                'category' => 'calculators',
                'title' => 'Popísané prepínače jednotiek v kalkulačkách',
                'description' => 'Prepínače jednotiek UACR a cholesterolu majú stabilné id a aria-label, aby ich čítačky obrazovky ohlásili aj bez samostatného viditeľného labelu vedľa hodnoty.',
                'url' => 'calculators.php',
            ],
            [
                'date' => '2026-11-03 07:22',
                'category' => 'portal',
                'title' => 'Cookie banner mimo čítačky po súhlase',
                'description' => 'Po prijatí alebo odmietnutí voliteľných cookies už zatvorený banner nezostáva v strome pre čítačky obrazovky ani neberie fokus. Nastavenia súkromia sa naďalej otvoria z pätičky.',
                'url' => 'cookies.php',
            ],
            [
                'date' => '2026-11-02 03:52',
                'category' => 'tools',
                'title' => 'Spoločné vzorce EKFC, UACR a Mehran + referenčné testy',
                'description' => 'EKFC, UACR (A1–A3), Mehran skóre a KDIGO G kategórie majú spoločné čisté funkcie a regresné referenčné príklady (vrátane KFRE). Výsledky kalkulačiek sa nemenia.',
                'url' => 'calculator_ekfc.php',
            ],
            [
                'date' => '2026-11-02 03:35',
                'category' => 'portal',
                'title' => 'Jednotné parametre pri štúdiách, objednávkach a tlači výsledkov',
                'description' => 'Detail klinickej štúdie, stav objednávky publikácie, sťahovanie súboru a tlač uloženého výsledku kalkulačky čítajú URL parametre rovnako ako zvyšok portálu. Poškodený tvar parametra skončí chybou 400.',
                'url' => 'objednavka.php',
            ],
            [
                'date' => '2026-11-02 03:33',
                'category' => 'tools',
                'title' => 'Spoločný vzorec CKD-EPI 2021 v kalkulačkách',
                'description' => 'Kalkulačka eGFR a porovnanie v EKFC používajú ten istý vzorec CKD-EPI 2021. Výsledky sa nemenia; pribudla regresná kontrola referenčných príkladov.',
                'url' => 'calculator_egfr.php',
            ],
            [
                'date' => '2026-11-02 03:15',
                'category' => 'portal',
                'title' => 'Bezpečnejšie CSRF tokeny vo formulároch',
                'description' => 'Prihlásenie, registrácia, profil, 2FA, newsletter a administrácia čítajú CSRF token ako jednu hodnotu. Ak príde namiesto nej pole, portál vráti chybu 400 namiesto pádu stránky.',
                'url' => 'login.php',
            ],
            [
                'date' => '2026-11-02 03:12',
                'category' => 'content',
                'title' => 'Ďalšie štyri články s overenými autormi zdroja',
                'description' => 'Kurátorská mapa autorov pribudla pri textoch o káve a mikrobióme, DAPA-CKD, KDIGO transplantácii a konsenze o lupusovej nefritíde. Filter autorov používa mená z Crossref.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 02:55',
                'category' => 'portal',
                'title' => 'Jednotné parametre aj na úvodnej stránke',
                'description' => 'Stránkovanie a filter „Zúčastnení autori“ na úvodnej stránke čítajú parametre rovnako ako zvyšok portálu. Poškodený tvar parametra skončí chybou 400 namiesto pádu stránky.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 02:53',
                'category' => 'content',
                'title' => 'Ďalších dvanásť článkov s overenými autormi zdroja',
                'description' => 'Kurátorská mapa autorov pribudla mimo iného pri textoch o uhlíkovej stope HD, CONFIDENCE, TMAO/L-karnitíne, ESC/EAS dyslipidémii a prechode medzi agonistami GLP-1. Filter autorov používa mená z Crossref.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 02:35',
                'category' => 'portal',
                'title' => 'Bezpečnejší výber formátov pri objednávke publikácie',
                'description' => 'Zaškrtávacie formáty na stránke publikácie sa čítajú rovnakým listovým helperom ako multi-select v kalkulačkách. Poškodený tvar poľa skončí chybou 400 namiesto nejasného správania formulára.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-11-02 02:33',
                'category' => 'content',
                'title' => 'Ďalších trinásť článkov s overenými autormi zdroja',
                'description' => 'Kurátorská mapa autorov pribudla mimo iného pri textoch o gabapentíne, ketamínovej uropatii, CKDnt, MASLD, ANCA vaskulitíde a ADA technológiách diabetu. Filter autorov používa mená z Crossref.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 02:20',
                'category' => 'portal',
                'title' => 'Bezpečnejšie multi-select polia v ambulantnej kalkulačke',
                'description' => 'Zoznamy diagnóz a komplikácií sa čítajú jednotným listovým helperom. Poškodený tvar poľa (vnorené pole namiesto jednoduchej hodnoty) skončí chybou 400, nie pádom stránky; bežné výpočty sa nemenia.',
                'url' => 'calculator_ambulatory.php',
            ],
            [
                'date' => '2026-11-02 02:18',
                'category' => 'content',
                'title' => 'Ďalších desať článkov s overenými autormi zdroja',
                'description' => 'Kurátorská mapa autorov pribudla mimo iného pri textoch o pneumokokovom očkovaní, KDOQI cievnych prístupoch, xylitole, iTTP, sarkopénii pri PD a inkrementálnej HD. Filter autorov používa mená z Crossref.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 01:55',
                'category' => 'content',
                'title' => 'Ďalších šestnásť článkov s overenými autormi zdroja',
                'description' => 'Kurátorská mapa autorov pribudla pri ďalších odborných textoch (mimo iného ADA/EASD 2026, CKD-aP, SGLT2i a hemoglobín, prehabilitácia). Filter autorov a podpis článku používajú mená z Crossref namiesto odhadu zo textu.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 01:40',
                'category' => 'content',
                'title' => 'Presnejší zoznam autorov pri ďalších článkoch',
                'description' => 'Pri štrnástich odborných textoch je zoznam autorov pôvodného zdroja doplnený z Crossref a PubMed. Filter „Zúčastnení autori“ a podpis článku tak ukazujú overené mená namiesto heuristiky zo textu.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 01:15',
                'category' => 'portal',
                'title' => 'Rýchlejší filter autorov na úvodnej stránke',
                'description' => 'Zoznam a filter „Zúčastnení autori“ už nenačítava celé texty článkov, ktoré majú kurátorskú mapu autorov. Výsledky filtrovania ostávajú rovnaké, odozva je kratšia.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-11-02 00:55',
                'category' => 'portal',
                'title' => 'Jednotné parametre vo formulároch kalkulačiek',
                'description' => 'Klinické kalkulačky čítajú skalárne polia formulára rovnako ako zvyšok portálu. Poškodený tvar parametra (napríklad pole namiesto jednej hodnoty) vráti chybu 400 namiesto pádu stránky; bežné výpočty sa nemenia.',
                'url' => 'calculators.php',
            ],
            [
                'date' => '2026-11-02 00:35',
                'category' => 'portal',
                'title' => 'Jednotné parametre aj v administrácii',
                'description' => 'Správa článkov, liekov, štúdií, diskusie a newslettera číta filtre a formulárové polia rovnako ako verejné stránky: poškodený tvar parametra skončí chybou 400, nie pádom stránky.',
                'url' => 'admin_articles.php',
            ],
            [
                'date' => '2026-11-02 00:12',
                'category' => 'portal',
                'title' => 'Jednotné spracovanie parametrov na ďalších stránkach',
                'description' => 'Prihlásenie, články, lieky, štúdie, publikácie, overenie e-mailu a súvisiace formuláre odmietnu poškodený tvar parametrov rovnako ako vyhľadávanie — jasnou chybou 400 namiesto pádu stránky.',
                'url' => 'login.php',
            ],
            [
                'date' => '2026-11-01 23:52',
                'category' => 'portal',
                'title' => 'Bezpečnejšie spracovanie parametrov vo formulároch',
                'description' => 'Ak príde namiesto jednej hodnoty pole (napríklad v hľadaní, odbere newslettera alebo pri PDF), portál vráti jasnú chybu 400 namiesto pádovej stránky. Bežné použitie sa nemení.',
                'url' => 'search.php',
            ],
            [
                'date' => '2026-11-01 23:32',
                'category' => 'portal',
                'title' => 'Prístupnejšie 2FA nastavenie a zrušenie účtu',
                'description' => 'Pri chybách v nastavení dvojfaktorového overenia a pri potvrdení zrušenia účtu sa fokus presunie na upozornenie. Potvrdzovacie panely (deaktivácia 2FA, zrušenie účtu) po otvorení fokusujú pole hesla.',
                'url' => '2fa_setup.php',
            ],
            [
                'date' => '2026-11-01 23:12',
                'category' => 'portal',
                'title' => 'Prístupnejšie chyby účtu a mobilné menu',
                'description' => 'Pri chybe na registrácii, obnove hesla, opätovnom overení e-mailu a 2FA sa fokus presunie na zoznam chýb a polia sú s ním prepojené. Mobilné menu sa ovláda klávesnicou vrátane Escape a cyklu Tab.',
                'url' => 'register.php',
            ],
            [
                'date' => '2026-11-01 22:50',
                'category' => 'portal',
                'title' => 'Lepšie hlásenie chýb formulárov a užšie displeje',
                'description' => 'Chybové a úspešné hlásenia na prihlásení, registrácii a kalkulačkách oznamujú čítačky obrazovky; pri chybe prihlásenia sa fokus presunie na zoznam chýb. Na displejoch okolo 320 px sa formuláre a jednotky už nerozťahujú stránku do šírky.',
                'url' => 'login.php',
            ],
            [
                'date' => '2026-11-01 11:59',
                'category' => 'portal',
                'title' => 'Microsoft Clarity len po analytickom súhlase',
                'description' => 'Na verejných neprihlásených stránkach sa po analytickom súhlase môže načítať Microsoft Clarity s maskovaným textom. Prihlásené obrazovky, formuláre a kalkulačky sú vylúčené; reklamný súhlas sa službe neudeľuje. Súhlas možno kedykoľvek odvolať v nastaveniach cookies.',
                'url' => 'privacy.php',
            ],
            [
                'date' => '2026-11-01 10:34',
                'category' => 'portal',
                'title' => 'Dynamický akvamarínový titulný nadpis',
                'description' => 'Nadpis Nefro-projekt Slovensko v hlavičke má plynulý akvamarínovo-tyrkysovo-modrý gradient s jemným červeným akcentom, animáciou a režimom zníženého pohybu.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-10-29 17:42',
                'category' => 'portal',
                'title' => 'Menej požiadaviek na jedno zobrazenie stránky',
                'description' => 'Hosting obmedzuje počet požiadaviek z jednej adresy a pri prekročení ukazoval chybu 429. Štýly a skripty sa teraz v prehliadači držia dlhodobo, knižnica na vzorce sa sťahuje len tam, kde sú vzorce, a stránky už neposielajú zbytočné CSP hlásenia.',
                'url' => '',
            ],
            [
                'date' => '2026-10-29 17:05',
                'category' => 'content',
                'title' => 'Marža z krvi za 9,98 € a publikácie bez DOCX',
                'description' => 'Cena e-knihy Marža z krvi je 9,98 € za ľubovoľný výber dostupných formátov. Publikácie sa už neponúkajú vo formáte DOCX; k dispozícii zostávajú PDF, EPUB, AZW3 a pri odborných vydaniach aj ODT.',
                'url' => 'publikacia.php?slug=marza-z-krvi',
            ],
            [
                'date' => '2026-10-28 01:22',
                'category' => 'portal',
                'title' => 'Videá v sekcii Dialýza',
                'description' => 'Sekciu Dialýza dopĺňajú dve videá s prehrávaním v slučke. Každé video možno pozastaviť pomocou ovládania prehrávača.',
                'url' => 'dialyza-bratislava.php',
            ],
            [
                'date' => '2026-10-27 23:05',
                'category' => 'content',
                'title' => 'Marža z krvi za 7 €',
                'description' => 'Cena e-knihy Marža z krvi je 7 € za ľubovoľný výber dostupných formátov.',
                'url' => 'publikacia.php?slug=marza-z-krvi',
            ],
            [
                'date' => '2026-10-22 18:00',
                'category' => 'content',
                'title' => 'Marža z krvi s prideleným ISBN',
                'description' => 'Národná agentúra ISBN v SR pridelila trileru Marža z krvi ISBN pre PDF, EPUB aj tlačené vydanie. E-kniha vo všetkých formátoch má ISBN v tiráži; kupujúci si môžu stiahnuť aktualizované súbory.',
                'url' => 'publikacia.php?slug=marza-z-krvi',
            ],
            [
                'date' => '2026-10-22 10:15',
                'category' => 'portal',
                'title' => 'Výsledky kalkulačiek sa po roku anonymizujú',
                'description' => 'Z výsledkov uložených v konte sa po roku odstránia pacientské identifikátory (meno, rodné číslo, poisťovňa); výsledok zostáva anonymizovaný a použiteľný na sledovanie vývoja. Po desiatich rokoch sa záznam vymaže úplne.',
                'url' => '',
            ],
            [
                'date' => '2026-10-22 10:15',
                'category' => 'portal',
                'title' => 'Novinky sa neposielajú dvakrát',
                'description' => 'Posielanie noviniek prechádza na nový postup, pri ktorom sa stav odoberu zaznamenáva pred odoslaním. Prerušenie počíta dávky už nespôsobí duplicitné rozoslanie celej dávky.',
                'url' => '',
            ],
            [
                'date' => '2026-10-22 10:15',
                'category' => 'portal',
                'title' => 'Ochrana prihlásenia aj na úrovni účtu',
                'description' => 'Neúspešné pokusy o prihlásenie sa počítajú aj pre konkrétny účet, takže útok z mnoha rôznych adres už neobmedzuje iba limit podľa IP adresy.',
                'url' => '',
            ],
            [
                'date' => '2026-10-20 16:53',
                'category' => 'content',
                'title' => 'Beletria: Marža z krvi',
                'description' => 'V publikáciách pribudla sekcia Beletria a ilustrovaný triler Marža z krvi. E-kniha stojí 20 € a je dostupná v PDF, EPUB, AZW3 a DOCX.',
                'url' => 'publikacia.php?slug=marza-z-krvi',
            ],
            [
                'date' => '2026-10-20 09:30',
                'category' => 'content',
                'title' => 'PDF verzie článkov s funkčnými webovými odkazmi',
                'description' => 'Novo generované PDF verzie článkov odkazujú na súvisiace články a ilustrácie cez webové adresy portálu, takže odkazy fungujú aj mimo servera.',
                'url' => '',
            ],
            [
                'date' => '2026-10-20 09:30',
                'category' => 'content',
                'title' => 'Vyhľadávanie liekov a štúdií opäť vracia výsledky',
                'description' => 'Textové hľadanie v databáze liekov a klinických štúdií prestalo pri natívnych parametroch databázy potichu vracať prázdny zoznam.',
                'url' => 'lieky.php',
            ],
            [
                'date' => '2026-10-18 08:40',
                'category' => 'portal',
                'title' => 'Spoľahlivejšia ochrana formulárov',
                'description' => 'Ochrana pred opakovaným odosielaním formulárov správne uplatňuje časové limity aj pri rozdielnom nastavení času serverov.',
                'url' => '',
            ],
            [
                'date' => '2026-10-18 00:24',
                'category' => 'portal',
                'title' => 'Spoľahlivejšie vyhľadávanie a jednoduchší výber autora',
                'description' => 'Vyhľadávanie má stabilnejšie poradie a presnejšie zvýraznenie výsledkov. Ďalšieho autora si možno vyhľadať v kompaktnom zozname; opravené bolo aj overovanie účtu a prihlasovanie na odber noviniek.',
                'url' => 'search.php',
            ],
            [
                'date' => '2026-10-14 05:30',
                'category' => 'portal',
                'title' => 'Kompaktnejšia ponuka publikácií na domovskej stránke',
                'description' => 'Ponuka bezplatných publikácií nad odporúčanými článkami zaberá menej miesta, pričom odkazy na všetky dostupné formáty zostali zachované.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-10-13 15:30',
                'category' => 'content',
                'title' => 'Dve talianske vydania SK Nefro Báza 1',
                'description' => 'Do katalógu pribudlo talianske plné vydanie s 387 odbornými článkami a talianske kompendium. Obe sú dostupné vo formátoch PDF, EPUB, AZW3, DOCX a ODT.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-13 15:25',
                'category' => 'content',
                'title' => 'Talianske vydanie bezplatnej publikácie',
                'description' => 'Publikácia SK Nefro: Dimostrato, probabile, aperto je bezplatne dostupná v taliančine vo formátoch PDF, EPUB, AZW3, DOCX a ODT, bez registrácie a objednávky.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-12 04:32',
                'category' => 'portal',
                'title' => 'Presnejšie právne informácie a oznamovanie obsahu',
                'description' => 'Portál doplnil identifikačné a spotrebiteľské informácie, presnejšie upozornenia pri kalkulačkách a elektronický formulár na oznámenie možného nezákonného obsahu.',
                'url' => 'terms.php',
            ],
            [
                'date' => '2026-10-11 19:20',
                'category' => 'portal',
                'title' => 'Stabilnejšie stránkovanie článkov',
                'description' => 'Pri rovnakom poradí a dátume publikovania zostáva poradie článkov stabilné aj medzi stránkami. To platí pre hlavný zoznam aj výber článkov podľa autora.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-10-10 23:04',
                'category' => 'portal',
                'title' => 'Prehľadnejšie stránkovanie článkov',
                'description' => 'Zoznam odborných článkov aj výber podľa autora teraz zobrazuje 21 článkov na jednej stránke.',
                'url' => 'index.php',
            ],
            [
                'date' => '2026-10-09 13:15',
                'category' => 'calculators',
                'title' => 'Aniónová medzera znova ukáže vypočítaný výsledok',
                'description' => 'Po výpočte aniónovej medzery a delta pomeru sa číselný výsledok znova zobrazí na stránke.',
                'url' => 'calculator_acidbase.php',
            ],
            [
                'date' => '2026-10-08 16:55',
                'category' => 'calculators',
                'title' => 'UACR a Kt/V znova ukážu vypočítaný výsledok',
                'description' => 'Po výpočte UACR a Kt/V sa číselný výsledok znova zobrazí na stránke.',
                'url' => 'calculators.php',
            ],
            [
                'date' => '2026-10-08 16:40',
                'category' => 'calculators',
                'title' => 'Presnejšie zaradenie albuminúrie, CKM a PREVENT',
                'description' => 'Kategória A sa určuje podľa prahov v zadanej jednotke: 3 mg/mmol je A2 a 30 mg/mmol je A3, bez prepočtu na mg/g. Potvrdená A2 alebo A3 bez eGFR sa zaradí do štádia CKM 2. PREVENT prijme eGFR 15 ml/min/1,73 m² a po načítaní z histórie zachová UACR, takže riziko neprejde ticho na základný model. Nový výpočet po načítaní histórie už nepoužije staré údaje.',
                'url' => 'calculators.php',
            ],
            [
                'date' => '2026-10-06 19:35',
                'category' => 'content',
                'title' => 'Dve nemecké vydania SK Nefro Báza 1',
                'description' => 'Do katalógu pribudlo nemecké plné vydanie s 387 odbornými článkami a nemecké kompendium. Obe sú dostupné vo formátoch PDF, EPUB, AZW3, DOCX a ODT.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-06 19:17',
                'category' => 'content',
                'title' => 'Nemecké vydanie bezplatnej publikácie',
                'description' => 'Publikácia SK Nefro: Belegt, wahrscheinlich, offen je bezplatne dostupná v nemčine vo formátoch PDF, EPUB, AZW3, DOCX a ODT, bez registrácie a objednávky.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-06 08:42',
                'category' => 'content',
                'title' => 'Dve nové publikácie na bezplatné stiahnutie',
                'description' => 'Publikácia SK Nefro: Dokázané, pravdepodobné, otvorené spája 387 odborných článkov do 17 rozšírených úvodníkov. Slovenské aj anglické vydanie si možno bezplatne stiahnuť vo formátoch PDF, EPUB, AZW3, DOCX a ODT, bez registrácie a objednávky.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-05 20:32',
                'category' => 'portal',
                'title' => 'Platba kartou za publikácie s pevnou sumou',
                'description' => 'Platobná brána Stripe pri objednávke publikácie automaticky predvyplní presnú sumu podľa vybraných formátov (7 € za jeden formát, 12 € za balík). Sumu už pri platbe kartou nezadávate ručne.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-05 19:14',
                'category' => 'portal',
                'title' => 'Dodací e-mail publikácie príde aj pri objednávke len PDF',
                'description' => 'Po potvrdení platby príde správa so stránkou na stiahnutie aj vtedy, keď je v objednávke len PDF a poštový server neprijme odosielateľa nefro@polascin.net. Opätovné odoslanie z administrácie použije tú istú zálohu. Druhé potvrdenie už zaplatenej objednávky publikáciu znova nepošle.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-04 13:39',
                'category' => 'portal',
                'title' => 'Bezpečnejšie objednávky a sťahovanie publikácií',
                'description' => 'Stránky objednávok sú vylúčené z analytiky aj pri uloženom súhlase. Sťahovanie spoľahlivo dodržiava limit a platnosť prístupu aj pri súbežných požiadavkách; počas prenosu môžete ďalej používať portál.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-04 10:30',
                'category' => 'content',
                'title' => 'Anglické vydanie kompendia',
                'description' => 'Kompendium je od dnes aj v angličtine — 387 článkov ako abstrakt a stručné zhrnutie, syntéza na začiatku každej zo 16 kapitol, 275 strán. Číslovanie je zhodné s anglickým plným vydaním, pri každom článku je odkaz na slovenskú online verziu. Rovnakých päť formátov — PDF, EPUB, Kindle, DOCX a ODT.',
                'url' => 'publikacia.php?slug=sk-nefro-baza-1-kompendium-en',
            ],
            [
                'date' => '2026-10-04 09:30',
                'category' => 'content',
                'title' => 'SK Nefro Báza 1 Kompendium — zhustené vydanie',
                'description' => 'Do katalógu publikácií pribudlo kompendium: 387 odborných článkov spracovaných do abstraktu a štyroch až siedmich kľúčových bodov, k tomu syntéza na začiatku každej zo 16 kapitol. Celý ročník na 261 stranách namiesto 1 745, s číslovaním zhodným s plným vydaním. Rovnakých päť formátov — PDF, EPUB, Kindle, DOCX a ODT.',
                'url' => 'publikacia.php?slug=sk-nefro-baza-1-kompendium',
            ],
            [
                'date' => '2026-10-03 20:00',
                'category' => 'content',
                'title' => 'Anglické vydanie e-knihy SK Nefro Báza 1',
                'description' => 'Do katalógu publikácií pribudol anglický preklad — 387 odborných článkov na 1 782 stranách, rovnako v PDF, EPUB, Kindle, DOCX a ODT. Oproti slovenskému vydaniu neobsahuje 18 popularizačných textov pre pacientov. Pri každom článku je odkaz na jeho slovenskú online verziu.',
                'url' => 'publikacia.php?slug=sk-nefro-baza-1-en',
            ],
            [
                'date' => '2026-10-03 13:53',
                'category' => 'content',
                'title' => 'Publikácie na predaj — e-kniha SK Nefro Báza 1',
                'description' => 'Pribudla sekcia Publikácie s prvým zväzkom SK Nefro Báza 1 — 387 odborných článkov z portálu na 1 745 stranách, v jednom súbore na čítanie offline aj do tlače. Na výber je PDF, EPUB, Kindle (AZW3), DOCX a ODT; jeden formát 7 €, všetky 12 €. Platí sa prevodom alebo kartou a peňaženkou. Články na portáli zostávajú voľne dostupné bez platobnej steny.',
                'url' => 'publikacie.php',
            ],
            [
                'date' => '2026-10-03 18:30',
                'category' => 'portal',
                'title' => 'Zásady ochrany údajov doplnené o predaj publikácií',
                'description' => 'Zásady ochrany osobných údajov popisujú spracúvanie objednávok — účely, kategórie údajov, rozlíšené doby uchovávania a platobné služby vrátane ich skutočnej roly. Pridali sme samostatné Obchodné podmienky predaja publikácií.',
                'url' => 'privacy.php',
            ],
            [
                'date' => '2026-09-24 00:38',
                'category' => 'portal',
                'title' => 'Prehľadnejšie oznámenia o právnych zmenách',
                'description' => 'E-mailové oznámenia obsahujú iba zmeny príslušnej verzie právnych dokumentov. Aj pri oneskorenom doručení zostáva zachovaný správny dátum účinnosti a príslušný súhrn zmien.',
                'url' => 'privacy.php',
            ],
            [
                'date' => '2026-09-17 18:11',
                'category' => 'calculators',
                'title' => 'eGFR sa dá zadávať aj v ml/s/1,73 m²',
                'description' => 'Pri každom poli pre eGFR je teraz voľba jednotky — ml/min/1,73 m² alebo ml/s/1,73 m². Prepnutie prepočíta už zadanú hodnotu. Prevodník jednotiek má nový riadok pre eGFR a kalkulačky eGFR ukazujú výsledok v oboch jednotkách.',
                'url' => 'calculators.php',
            ],
            [
                'date' => '2026-09-13 00:00',
                'category' => 'calculators',
                'title' => 'Ambulantná kalkulačka počíta aj z neúplných údajov',
                'description' => 'Kalkulačka vypočíta, čo sa z vyplnených polí dá, a do textu pre správu doplní prehľadnejšie zhrnutie.',
                'url' => 'calculator_ambulatory.php',
            ],
            [
                'date' => '2026-09-01 00:00',
                'category' => 'calculators',
                'title' => 'Ambulantná kalkulačka CKD',
                'description' => 'Komplexný nástroj pre nefrologickú ambulanciu: stagingové zaradenie CKD, prognostické modely a príčina CKD z číselníka MKCH-10 s vlastným textom.',
                'url' => 'calculator_ambulatory.php',
            ],
        ];
    }
}

if (!function_exists('siteChangelogEntriesBetween')) {
    /**
     * Vráti záznamy z okna (since, until] zoradené od najnovšieho.
     *
     * @return list<array{date: string, category: string, title: string, description: string, url: string}>
     */
    function siteChangelogEntriesBetween(string $since, string $until): array
    {
        $sinceTs = strtotime($since);
        $untilTs = strtotime($until);
        if ($sinceTs === false || $untilTs === false) {
            return [];
        }

        $selected = [];
        foreach (siteChangelogEntries() as $entry) {
            $entryTs = strtotime($entry['date']);
            if ($entryTs === false || $entryTs <= $sinceTs || $entryTs > $untilTs) {
                continue;
            }
            $selected[] = $entry;
        }

        usort($selected, static fn (array $a, array $b): int => strtotime($b['date']) <=> strtotime($a['date']));

        return $selected;
    }
}
