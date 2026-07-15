<?php

declare(strict_types=1);

/**
 * Jediný zdroj pravdy pre právne dokumenty:
 * Zásady ochrany osobných údajov (privacy.php), Cookie Policy (cookies.php)
 * a Podmienky používania (terms.php).
 *
 * Audit `.agent.md` (sekcia „Súkromie, súhlas a právne dokumenty") kontroluje
 * tieto polia pri každom behu — aktualizuj ich tu a všetky tri stránky ostanú
 * konzistentné.
 *
 * POZNÁMKA: Ide o dôkladnú šablónu podľa osvedčených postupov. Pred spoľahnutím
 * sa na ňu over registračné/kontaktné údaje a daj dokumenty posúdiť právnikovi.
 */

if (defined('LEGAL_DATA_INCLUDED')) {
    return;
}
define('LEGAL_DATA_INCLUDED', 1);

/**
 * Základné identifikačné údaje prevádzkovateľa a verzia dokumentov.
 *
 * `consentVersion` sa MUSÍ zhodovať s konštantou `consentVersion`
 * v `ui-preferences.js` — pri jej zmene sa všetkým návštevníkom znova
 * zobrazí cookie banner (GDPR čl. 7 ods. 3 — nový súhlas pri zmene podmienok).
 */
function legalInfo(): array
{
    return [
        'entity'                   => 'Nefro-projekt Slovensko',
        'operator'                 => 'MUDr. Ľubomír Polaščín',
        'companyId'                => '57 646 856',
        'site'                     => 'nefro.polascin.net',
        'url'                      => 'https://nefro.polascin.net',
        'contactEmail'             => 'nefro@polascin.net',
        'establishment'            => 'Slovenskej republike (EÚ)',
        'jurisdiction'             => 'Slovenskej republiky (EÚ)',
        'supervisoryAuthority'     => 'Úrad na ochranu osobných údajov Slovenskej republiky',
        'supervisoryAuthorityUrl'  => 'https://dataprotection.gov.sk/sk/',
        'effectiveDate'            => '2026-07-15',
        'version'                  => '2.4',
        'consentVersion'           => '2026-07-15',
    ];
}

/** Kategórie osobných údajov, ktoré spracúvame. */
function legalDataCategories(): array
{
    return [
        [
            'category' => 'Identifikačné a kontaktné údaje',
            'examples' => 'Meno, priezvisko, používateľské meno, e-mailová adresa, voliteľne mobilné telefónne číslo.',
        ],
        [
            'category' => 'Profesijné údaje',
            'examples' => 'Titul pred menom / za menom, pracovná funkcia, organizácia, pracovný e-mail, pracovný mobil, webová adresa organizácie (voliteľné polia v profile).',
        ],
        [
            'category' => 'Autentifikačné a bezpečnostné údaje',
            'examples' => 'Hašované heslo (bcrypt), čas posledného prihlásenia, IP adresa pri prihlásení, pokusy o prihlásenie (rate-limiting).',
        ],
        [
            'category' => 'Avatar',
            'examples' => 'Voliteľne nahraná profilová fotografia uložená na serveri.',
        ],
        [
            'category' => 'Klinické výsledky kalkulačiek',
            'examples' => 'Výsledky výpočtov uložené na žiadosť lekára spolu s pacientskymi identifikátormi (meno, dátum narodenia, rodné číslo, kód poisťovne) — vkladá ich výhradne prihlásený lekár. Ide o údaje o zdraví (osobitná kategória podľa čl. 9 GDPR).',
        ],
        [
            'category' => 'Lokálna história kalkulačiek pre neprihlásených',
            'examples' => 'Po udelení preferenčného súhlasu môže prehliadač lokálne uchovať najviac 50 zobrazených výsledkov. Formulárové vstupy ani identifikátory pacienta sa neukladajú a údaje sa neodosielajú na server.',
        ],
        [
            'category' => 'Komunikácia',
            'examples' => 'Newsletter, notifikácie o článkoch, overovacie e-maily/SMS a príspevky v diskusii.',
        ],
        [
            'category' => 'Technické a prevádzkové údaje',
            'examples' => 'Server logy: IP adresa, typ prehliadača, operačný systém, URL požiadavky a čas prístupu.',
        ],
    ];
}

/** Účely spracúvania mapované na právny základ podľa GDPR (čl. 6, resp. čl. 9). */
function legalProcessingPurposes(): array
{
    return [
        [
            'purpose' => 'Vytvorenie a prevádzka používateľského konta, autentifikácia a obnova hesla',
            'basis'   => 'Plnenie zmluvy — čl. 6 ods. 1 písm. b)',
        ],
        [
            'purpose' => 'Ukladanie a zobrazovanie výsledkov klinických kalkulačiek na žiadosť lekára',
            'basis'   => 'Zmluva — čl. 6 ods. 1 písm. b); pri údajoch o zdraví navyše čl. 9 ods. 2 písm. h) (zdravotná starostlivosť), resp. výslovný súhlas písm. a)',
        ],
        [
            'purpose' => 'Zasielanie newslettera a notifikácií o nových článkoch',
            'basis'   => 'Súhlas — čl. 6 ods. 1 písm. a) (kedykoľvek odvolateľný odhlásením)',
        ],
        [
            'purpose' => 'Overenie e-mailovej adresy a telefónneho čísla',
            'basis'   => 'Zmluva — čl. 6 ods. 1 písm. b); oprávnený záujem na bezpečnosti — písm. f)',
        ],
        [
            'purpose' => 'Bezpečnosť služby: rate-limiting, prevencia zneužitia a podvodov, audit',
            'basis'   => 'Oprávnený záujem — čl. 6 ods. 1 písm. f)',
        ],
        [
            'purpose' => 'Diskusia pre prihlásených používateľov',
            'basis'   => 'Zmluva — čl. 6 ods. 1 písm. b)',
        ],
        [
            'purpose' => 'Voliteľná analytika návštevnosti (Google Analytics 4)',
            'basis'   => 'Súhlas — čl. 6 ods. 1 písm. a) (cez cookie banner)',
        ],
        [
            'purpose' => 'Marketingová personalizácia (ak bude zavedená)',
            'basis'   => 'Súhlas — čl. 6 ods. 1 písm. a)',
        ],
    ];
}

/** Sprostredkovatelia / príjemcovia, ktorí môžu spracúvať vaše údaje. */
function legalSubprocessors(): array
{
    return [
        [
            'name'     => 'WebSupport, s.r.o. (SK)',
            'purpose'  => 'Webhosting, databáza a SMTP e-mailová služba',
            'transfer' => 'Európska únia (Slovensko)',
        ],
        [
            'name'     => 'Twilio Inc. (USA)',
            'purpose'  => 'Odosielanie overovacích SMS kódov pri overení telefónneho čísla',
            'transfer' => 'USA — štandardné zmluvné doložky (SCC)',
        ],
        [
            'name'     => 'Google LLC (USA)',
            'purpose'  => 'Google Analytics 4 — len so súhlasom',
            'transfer' => 'USA — štandardné zmluvné doložky (SCC) / EU-US Data Privacy Framework',
        ],
    ];
}

/** Práva dotknutých osôb a spôsob ich uplatnenia podľa regiónu. */
function legalRightsRegions(): array
{
    return [
        [
            'region' => 'Európsky hospodársky priestor, Švajčiarsko a Spojené kráľovstvo',
            'law'    => 'GDPR / UK GDPR / švajčiarsky FADP, zákon č. 18/2018 Z. z.',
            'rights' => 'Právo na prístup, opravu, vymazanie, obmedzenie spracúvania, prenosnosť, námietku a právo kedykoľvek odvolať súhlas. Voliteľné cookies vyžadujú predchádzajúci súhlas (opt-in). Máte právo podať sťažnosť na svoj dozorný úrad; ak je spracúvanie založené na oprávnenom záujme, môžete kedykoľvek namietať.',
        ],
        [
            'region' => 'Spojené štáty americké (CA/CPRA, VA, CO, CT, UT, TX, OR, MT a ďalšie štátne zákony)',
            'law'    => 'CCPA/CPRA, VCDPA, CPA, CTDPA, UCPA, TDPSA, …',
            'rights' => 'Právo vedieť o údajoch a získať k nim prístup, vymazať ich, opraviť a odhlásiť sa z „predaja“ alebo „zdieľania“ osobných údajov a z cielenej reklamy. Vaše údaje nepredávame za peniaze; rešpektujeme signál Global Privacy Control (GPC) a možnosť „Odmietnuť / Nepredávať ani nezdieľať“. Proti zamietnutej žiadosti sa môžete odvolať a za uplatnenie práv nebudete diskriminovaní.',
        ],
        [
            'region' => 'Brazília',
            'law'    => 'LGPD (Lei Geral de Proteção de Dados)',
            'rights' => 'Prevádzkovateľ (controlador) je ' . legalInfo()['entity'] . '. Môžete potvrdiť spracúvanie, získať prístup, opraviť, anonymizovať, preniesť alebo vymazať údaje, získať informácie o zdieľaní a odvolať súhlas. Žiadosti smerujte na náš kontakt a v prípade nevyriešenia na úrad ANPD.',
        ],
        [
            'region' => 'Latinská Amerika (Argentína, Mexiko, Kolumbia, Čile, Peru)',
            'law'    => 'Národné zákony o ochrane osobných údajov',
            'rights' => 'Práva typu ARCO — prístup, oprava, zrušenie/vymazanie a námietka — a odvolanie súhlasu pri voliteľnom spracúvaní.',
        ],
        [
            'region' => 'Kanada',
            'law'    => 'PIPEDA / Québec Law 25',
            'rights' => 'Zmysluplný súhlas pri voliteľnom spracúvaní, právo na prístup a opravu a možnosť odvolať súhlas.',
        ],
        [
            'region' => 'Ázia (Čína, Južná Kórea, Japonsko, India, Singapur, Thajsko)',
            'law'    => 'PIPL, PIPA, APPI, DPDP, PDPA',
            'rights' => 'Voliteľné spracúvanie sa opiera o súhlas (osobitný/výslovný tam, kde to zákon vyžaduje). Môžete získať prístup k údajom, opraviť ich, vymazať a preniesť a odvolať súhlas. Cezhraničné prenosy sa realizujú so zárukami, ktoré vyžaduje príslušný zákon.',
        ],
        [
            'region' => 'Austrália a Nový Zéland',
            'law'    => 'Privacy Act 1988 (AU) / Privacy Act 2020 (NZ)',
            'rights' => 'Zhromažďujeme len to, čo je primerane nevyhnutné, transparentne informujeme o voliteľnom sledovaní a poskytujeme právo na prístup a opravu.',
        ],
    ];
}

/**
 * Kategórie cookies. `id` zodpovedá kľúčom v `ui-preferences.js`
 * (necessary / analytics / marketing / preferences).
 */
function legalCookieCategories(): array
{
    return [
        [
            'id'          => 'necessary',
            'title'       => 'Nevyhnutné (Strictly Necessary)',
            'description' => 'Potrebné pre základné fungovanie webu — prihlásenie a relácia, CSRF ochrana a uloženie tohto súhlasu. Neukladajú sledovacie údaje a nedajú sa vypnúť.',
            'required'    => true,
        ],
        [
            'id'          => 'preferences',
            'title'       => 'Preferenčné (Preferences)',
            'description' => 'Zapamätajú si nastavenia rozhrania, automatické ukladanie a lokálnu históriu výsledkov kalkulačiek. Lokálna história neobsahuje formulárové vstupy ani identifikátory pacienta a nepoužíva sa na sledovanie.',
            'required'    => false,
        ],
        [
            'id'          => 'analytics',
            'title'       => 'Analytické (Analytics)',
            'description' => 'Pomáhajú nám pochopiť, ako sa web používa, aby sme ho mohli zlepšovať. Údaje sú agregované a anonymizované — nepoužívajú sa na vašu identifikáciu.',
            'required'    => false,
        ],
        [
            'id'          => 'marketing',
            'title'       => 'Marketingové (Marketing)',
            'description' => 'Slúžia na meranie kampaní a zobrazenie relevantných ponúk. V režimoch opt-out (USA) ich vypína voľba „Nepredávať ani nezdieľať“. Aktuálne nie sú aktívne žiadne reklamné kampane.',
            'required'    => false,
        ],
    ];
}

/** Konkrétne cookies a úložisko, ktoré nastavujeme. */
function legalStoredItems(): array
{
    return [
        [
            'name'     => 'PHPSESSID (relačná cookie)',
            'category' => 'Nevyhnutné',
            'purpose'  => 'Udržiava vaše prihlásenie a CSRF ochranu formulárov.',
            'duration' => 'Do odhlásenia alebo zatvorenia prehliadača',
        ],
        [
            'name'     => 'nps_cookie_consent',
            'category' => 'Nevyhnutné',
            'purpose'  => 'Ukladá vaše voľby súhlasu s cookies (localStorage + záložná cookie).',
            'duration' => '365 dní',
        ],
        [
            'name'     => 'nps_theme, nps_theme_auto',
            'category' => 'Preferenčné',
            'purpose'  => 'Zapamätajú si zvolený svetlý/tmavý režim (localStorage).',
            'duration' => 'Trvalé (kým ich nevymažete)',
        ],
        [
            'name'     => 'calc_autosave',
            'category' => 'Preferenčné',
            'purpose'  => 'Zapamätá si, či si prihlásený používateľ zapol automatické uloženie výsledkov kalkulačiek (localStorage).',
            'duration' => 'Trvalé (kým ho nevypnete, neodvoláte súhlas alebo nevymažete)',
        ],
        [
            'name'     => 'calc_local_history',
            'category' => 'Preferenčné',
            'purpose'  => 'Pre neprihláseného používateľa uchová najviac 50 zobrazených výsledkov iba v prehliadači; bez formulárových vstupov a identifikátorov pacienta.',
            'duration' => 'Do vymazania záznamov, odvolania súhlasu alebo vymazania úložiska prehliadača',
        ],
        [
            'name'     => '_ga, _ga_0JT5VMQ61K',
            'category' => 'Analytické',
            'purpose'  => 'Google Analytics 4 — rozlíšenie návštevníkov a relácií. Nastavené len so súhlasom.',
            'duration' => 'Do 2 rokov',
        ],
    ];
}

/** Krátky súhrn „čo sa zmenilo" zobrazený na vrchu Zásad ochrany údajov. */
function legalRecentUpdates(): array
{
    return [
        'Lokálna história kalkulačiek pre neprihlásených sa odteraz vytvára iba po preferenčnom súhlase, neuchováva formulárové vstupy ani identifikátory pacienta a pri odvolaní súhlasu sa vymaže.',
        'Rozšírili sme Službu o informačnú databázu liekov v nefrológii, register klinických štúdií (dáta z verejného registra ClinicalTrials.gov) a ďalšie informačné nástroje, ktoré samy nespracúvajú osobné údaje návštevníkov.',
        'Do zoznamu sprostredkovateľov sme doplnili Twilio Inc. (USA), ktoré odosiela overovacie SMS kódy pri overení telefónneho čísla; prenos do USA je krytý štandardnými zmluvnými doložkami (SCC).',
        'Webové písmo (Inter) sme presunuli na vlastný server — pri jeho načítaní sa už neprenáša žiadny údaj (IP adresa) do Google LLC (USA).',
        'Právne dokumenty sme rozdelili do troch samostatných stránok: Zásady ochrany osobných údajov, Cookie Policy a Podmienky používania.',
        'Doplnili sme prehľad práv podľa regiónu (USA – CCPA/CPRA a GPC, Brazília – LGPD, Ázia, Austrália a Nový Zéland).',
        'Spresnili sme účely a právne základy spracúvania (prehľadná tabuľka) a zoznam sprostredkovateľov vrátane medzinárodných prenosov.',
        'Pridali sme sekcie o medzinárodných prenosoch a o ochrane údajov detí.',
        'Vykonali sme drobné jazykové spresnenia naprieč všetkými dokumentmi.',
    ];
}
