<?php

declare(strict_types=1);

/**
 * Jediný zdroj pravdy pre právne dokumenty:
 * Zásady ochrany osobných údajov (privacy.php), Cookie Policy (cookies.php)
 * a Podmienky používania (terms.php).
 *
 * Audit `.audit.md` (sekcia „Súkromie, súhlas a právne dokumenty") kontroluje
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
        'operator'                 => 'MUDr. Ľubomír Polaščín - Nephroctor',
        'companyId'                => '57 646 856',
        'site'                     => 'nefro.polascin.net',
        'url'                      => 'https://nefro.polascin.net',
        'contactEmail'             => 'nefro@polascin.net',
        'establishment'            => 'Slovenskej republike (EÚ)',
        'jurisdiction'             => 'Slovenskej republiky (EÚ)',
        'supervisoryAuthority'     => 'Úrad na ochranu osobných údajov Slovenskej republiky',
        'supervisoryAuthorityUrl'  => 'https://dataprotection.gov.sk/sk/',
        'effectiveDate'            => '2026-10-03',
        'version'                  => '2.9',
        'consentVersion'           => '2026-07-16',
    ];
}

/** Kategórie osobných údajov, ktoré spracúvame. */
function legalDataCategories(): array
{
    return [
        [
            'category' => 'Identifikačné a kontaktné údaje',
            'examples' => 'Meno, priezvisko, používateľské meno, súkromný e-mail a voliteľne telefónne čísla, dátum narodenia, rod, zámená, poštová adresa, osobná webová stránka, profily na sociálnych sieťach a iné kontaktné alebo menné poznámky.',
        ],
        [
            'category' => 'Profesijné údaje',
            'examples' => 'Titul pred menom / za menom, pracovná funkcia, organizácia, pracovný e-mail, pracovný mobil, webová adresa organizácie (voliteľné polia v profile).',
        ],
        [
            'category' => 'Autentifikačné a bezpečnostné údaje',
            'examples' => 'Hašované heslo (bcrypt), údaje dvojfaktorového overenia, čas posledného prihlásenia, IP adresa, používateľský agent, pokusy o prihlásenie a iné rate-limit záznamy. Po zrušení účtu sa najviac 90 dní uchováva minimalizovaný bezpečnostný audit bez používateľského mena; môže obsahovať pôvodné číselné ID, jednosmerný odtlačok a doménu e-mailu, IP adresu, používateľský agent a súhrnné počty vymazaných záznamov.',
        ],
        [
            'category' => 'Avatar',
            'examples' => 'Voliteľne nahraná profilová fotografia uložená na serveri.',
        ],
        [
            'category' => 'Klinické výsledky kalkulačiek',
            'examples' => 'Výsledky výpočtov uložené na žiadosť lekára spolu s pacientskymi identifikátormi (meno, dátum narodenia, rodné číslo, kód poisťovne) — vkladá ich výhradne prihlásený lekár. Ide o údaje o zdraví (osobitná kategória podľa čl. 9 GDPR). Záznam vymaže ten, kto ho zadal, priamo vo svojom konte; na žiadosť používateľa ho vymaže prevádzkovateľ. Všetky záznamy sa odstránia aj pri zrušení konta.',
        ],
        [
            'category' => 'Lokálna história kalkulačiek pre neprihlásených',
            'examples' => 'Po udelení preferenčného súhlasu môže prehliadač lokálne uchovať najviac 50 zobrazených výsledkov. Formulárové vstupy ani identifikátory pacienta sa neukladajú a údaje sa neodosielajú na server.',
        ],
        [
            'category' => 'Kontakty spolupracujúcich poskytovateľov',
            'examples' => 'Interný pracovný adresár zdravotníckych zariadení a ambulancií (názov, typ, odbornosť, adresa, telefón, e-mail, web, IČO, kontaktná osoba, poznámka). Nejde o údaje pacientov. Kontakty pochádzajú z verejne dostupných profesijných zdrojov — registra poskytovateľov e-VÚC a webových stránok zdravotníckych zariadení — a pri každom zázname evidujeme jeho zdroj. Dotknuté osoby informujeme e-mailom podľa čl. 14 GDPR pri prvom oslovení.',
        ],
        [
            'category' => 'Komunikácia',
            'examples' => 'Newsletter (nové články aj novinky na portáli), notifikácie o článkoch, overovacie e-maily/SMS a príspevky v diskusii.',
        ],
        [
            'category' => 'Objednávkové a fakturačné údaje (predaj publikácií)',
            'examples' => 'E-mailová adresa (povinná — bez nej nevieme doručiť platobné pokyny ani publikáciu) a voliteľne meno, názov firmy, IČO, DIČ/IČ DPH, fakturačná adresa a poznámka. Ďalej vybrané formáty, suma, variabilný symbol, stav objednávky a dátumy objednania, úhrady či zrušenia. Registrácia sa nevyžaduje — objednávku možno podať bez konta.',
        ],
        [
            'category' => 'Doklad o súhlasoch pri digitálnom obsahu',
            'examples' => 'Čas potvrdenia obchodných podmienok, čas výslovnej žiadosti o dodanie pred uplynutím lehoty na odstúpenie od zmluvy a verzia obchodných podmienok platná v tom okamihu. Neuchovávame text súhlasu, ten je verzovaný v samotnom dokumente. Bez tohto dokladu by predávajúci nedokázal preukázať, že právo na odstúpenie zaniklo oprávnene.',
        ],
        [
            'category' => 'Prístup k objednávke a evidencia stiahnutí',
            'examples' => 'Náhodná soľ, z ktorej sa odvodzuje prístupový token v odkaze na stránku objednávky (samotný token sa neukladá), počet stiahnutí a čas a formát posledného stiahnutia. Slúži na sprístupnenie kúpeného obsahu, obmedzenie zdieľania odkazu a ako doklad o dodaní.',
        ],
        [
            'category' => 'Technické a prevádzkové údaje',
            'examples' => 'Serverové a prístupové logy: IP adresa, typ prehliadača, operačný systém, URL požiadavky a čas prístupu. Pri zrušení účtu sa väzba prístupových logov na účet a používateľské meno odstráni. Pri podaní objednávky publikácie sa IP adresa a prehliadač ukladajú aj k objednávke (ochrana pred zneužitím formulára) a po 90 dňoch sa z nej odstránia, aj keď samotná objednávka ako účtovný doklad zostáva.',
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
            'basis'   => 'Zmluva — čl. 6 ods. 1 písm. b); pri údajoch o zdraví navyše čl. 9 ods. 2 písm. h) (zdravotná starostlivosť), resp. výslovný súhlas písm. a). Pri týchto údajoch vystupuje prevádzkovateľ v postavení prevádzkovateľa (nie sprostredkovateľa ambulancie), pretože sám určuje účely a prostriedky ich spracúvania; sprostredkovateľská zmluva podľa čl. 28 sa preto neuzatvára.',
        ],
        [
            'purpose' => 'Zasielanie newslettera a notifikácií o nových článkoch a o novinkách na portáli (nové kalkulačky, nástroje a zmeny v službe)',
            'basis'   => 'Súhlas — čl. 6 ods. 1 písm. a) (kedykoľvek odvolateľný odhlásením)',
        ],
        [
            'purpose' => 'Overenie e-mailovej adresy a telefónneho čísla',
            'basis'   => 'Zmluva — čl. 6 ods. 1 písm. b); oprávnený záujem na bezpečnosti — písm. f)',
        ],
        [
            'purpose' => 'Vedenie interného adresára zdravotníckych zariadení a oslovenie ohľadom odbornej spolupráce',
            'basis'   => 'Oprávnený záujem — čl. 6 ods. 1 písm. f). Ide o profesijné kontaktné údaje z verejne dostupných zdrojov, nie o údaje pacientov. Dotknutú osobu informujeme e-mailom podľa čl. 14 pri prvom oslovení; údaje spracúvame, kým trvá účel oslovenia, a na námietku podľa čl. 21 ich bez zbytočného odkladu vymažeme.',
        ],
        [
            'purpose' => 'Vybavenie objednávky publikácie, doručenie platobných pokynov, dodanie digitálneho obsahu a sprístupnenie na stiahnutie',
            'basis'   => 'Plnenie zmluvy — čl. 6 ods. 1 písm. b). Objednávku možno podať bez registrácie; e-mailová adresa je povinná, lebo bez nej nie je možné obsah dodať.',
        ],
        [
            'purpose' => 'Vedenie účtovníctva a splnenie daňových povinností z predaja publikácií',
            'basis'   => 'Zákonná povinnosť — čl. 6 ods. 1 písm. c) v spojení so zákonom č. 431/2002 Z. z. o účtovníctve a daňovými predpismi. Vzťahuje sa len na zaplatené objednávky; z neuhradenej objednávky účtovný záznam nevzniká.',
        ],
        [
            'purpose' => 'Preukázanie, že kupujúci výslovne požiadal o dodanie digitálneho obsahu pred uplynutím lehoty na odstúpenie od zmluvy a bol poučený o strate tohto práva',
            'basis'   => 'Zákonná povinnosť — čl. 6 ods. 1 písm. c) v spojení so zákonom č. 108/2024 Z. z. o ochrane spotrebiteľa; zároveň oprávnený záujem na obrane právnych nárokov — písm. f)',
        ],
        [
            'purpose' => 'Vybavenie reklamácie a prípadné uplatnenie alebo obrana právnych nárokov z predaja',
            'basis'   => 'Zákonná povinnosť — čl. 6 ods. 1 písm. c); oprávnený záujem — písm. f)',
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

/**
 * Príjemcovia údajov a ich skutočná rola.
 *
 * Nie každý príjemca je sprostredkovateľ. Sprostredkovateľ spracúva údaje
 * podľa našich pokynov a na základe zmluvy podľa čl. 28 GDPR; platobné služby
 * naopak určujú vlastné účely (vykonanie platby, prevencia podvodov, povinnosti
 * podľa predpisov o platobných službách a AML), takže vystupujú ako
 * **samostatní prevádzkovatelia**. Označiť ich za sprostredkovateľov by bolo
 * nepravdivé a sľubovalo by zmluvnú kontrolu, ktorú nad nimi nemáme.
 *
 * Ešte iná situácia je kanál, kde **neprenášame nič** — kupujúci len klikne na
 * odkaz a spojenie vytvorí jeho prehliadač alebo aplikácia. Takého príjemcu
 * uvádzame pre transparentnosť, no žiadny údaj mu neposielame.
 *
 * `role` je jedna z: `sprostredkovateľ`, `samostatný prevádzkovateľ`,
 * `samostatný prevádzkovateľ (neprenášame mu údaje)`.
 */
function legalSubprocessors(): array
{
    return [
        [
            'name'     => 'WebSupport, s.r.o. (SK)',
            'role'     => 'Sprostredkovateľ (čl. 28 GDPR)',
            'purpose'  => 'Webhosting, databáza a SMTP e-mailová služba — vrátane uloženia objednávok publikácií a odoslania e-mailov s platobnými pokynmi a s publikáciou',
            'transfer' => 'Európska únia (Slovensko)',
        ],
        [
            'name'     => 'Twilio Inc. (USA)',
            'role'     => 'Sprostredkovateľ (čl. 28 GDPR)',
            'purpose'  => 'Odosielanie overovacích SMS kódov pri overení telefónneho čísla',
            'transfer' => 'USA — štandardné zmluvné doložky (SCC)',
        ],
        [
            'name'     => 'Google LLC (USA)',
            'role'     => 'Sprostredkovateľ (čl. 28 GDPR)',
            'purpose'  => 'Google Analytics 4 — len so súhlasom',
            'transfer' => 'USA — štandardné zmluvné doložky (SCC) / EU-US Data Privacy Framework',
        ],
        [
            'name'     => 'Stripe Payments Europe, Limited (Írsko)',
            'role'     => 'Samostatný prevádzkovateľ',
            'purpose'  => 'Platba kartou, Apple Pay a Google Pay za publikáciu. Ak zvolíte tento spôsob, do platobnej stránky sa prenesie vaša e-mailová adresa (predvyplnenie) a číslo objednávky (párovanie platby).',
            'transfer' => 'Európska únia (Írsko); ďalšie prenosy v rámci skupiny do USA zabezpečuje poskytovateľ štandardnými zmluvnými doložkami, resp. rámcom EU-US Data Privacy Framework',
        ],
        [
            'name'     => 'PayPal (Europe) S.à r.l. et Cie, S.C.A. (Luxembursko)',
            'role'     => 'Samostatný prevádzkovateľ',
            'purpose'  => 'Platba cez PayPal za publikáciu. Prenáša sa číslo objednávky, názov publikácie a suma; vašu e-mailovú adresu PayPalu neodovzdávame.',
            'transfer' => 'Európska únia (Luxembursko); ďalšie prenosy do USA na základe štandardných zmluvných doložiek poskytovateľa',
        ],
        [
            'name'     => 'Tatra banka, a.s. (SK)',
            'role'     => 'Samostatný prevádzkovateľ',
            'purpose'  => 'Vedenie účtu predávajúceho a prijatie platby bankovým prevodom. Údaje o platiteľovi dostane banka od vašej banky, nie od nás.',
            'transfer' => 'Európska únia (Slovensko)',
        ],
        [
            'name'     => 'Revolut, Ko-fi, Viamo, payme.sk a Uphold',
            'role'     => 'Samostatní prevádzkovatelia (neprenášame im vaše údaje)',
            'purpose'  => 'Doplnkové spôsoby platby za publikáciu. Na stránke objednávky zobrazujeme len odkaz alebo číslo účtu; ak ho použijete, spojenie vytvorí váš prehliadač alebo aplikácia a tieto služby spracúvajú vaše údaje podľa vlastných zásad. My im neposielame nič.',
            'transfer' => 'EÚ a Spojené kráľovstvo (rozhodnutie o primeranosti); prípadné ďalšie prenosy určuje príslušná služba',
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
            'description' => 'Pomáhajú nám pochopiť, ako sa web používa, aby sme ho mohli zlepšovať. Google Analytics používa pseudonymný identifikátor klienta; službe neposielame mená, e-mailové adresy ani iné priame identifikátory.',
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

/**
 * Zmeny podľa verzie, najnovšie ako prvé. Pri zvýšení legalInfo()['version']
 * pridaj novú skupinu; staršie skupiny zachovaj pre čakajúce oznámenia.
 * @return array<string, list<string>>
 */
function legalUpdatesByVersion(): array
{
    return [
        '2.9' => [
            'Portál začal predávať elektronické publikácie (e-knihy). Doplnili sme preto nové účely spracúvania — vybavenie objednávky a dodanie digitálneho obsahu (plnenie zmluvy), vedenie účtovníctva z predaja a preukázanie súhlasu s dodaním pred uplynutím lehoty na odstúpenie od zmluvy (zákonná povinnosť) a vybavenie reklamácií či obranu nárokov.',
            'Opísali sme nové kategórie údajov: objednávkové a fakturačné údaje, doklad o oboch potvrdených súhlasoch vrátane verzie obchodných podmienok, prístupový token k objednávke a evidenciu stiahnutí. Objednávku možno podať bez registrácie.',
            'Doby uchovávania objednávok sme rozlíšili podľa údaja namiesto jednej paušálnej lehoty: zaplatená objednávka ako účtovný doklad 10 rokov, neuhradená alebo zrušená 90 dní, IP adresa a prehliadač z objednávkového formulára 90 dní, prístup na stiahnutie 2 roky a podrobnosti o stiahnutiach 4 roky (potom zostáva len ich počet). Mazanie a anonymizáciu vykonáva automatický cron.',
            'Do zoznamu príjemcov sme doplnili platobné služby a pri každom príjemcovi uvádzame jeho skutočnú rolu. Stripe Payments Europe (Írsko), PayPal (Europe) v Luxembursku a Tatra banka vystupujú ako samostatní prevádzkovatelia, nie ako naši sprostredkovatelia — určujú vlastné účely a nemáme nad nimi zmluvnú kontrolu. Pri Revolute, Ko-fi, Viame, payme.sk a Upholde im sami neposielame žiadny údaj; zobrazíme len odkaz alebo číslo účtu a spojenie vytvorí váš prehliadač.',
            'Spresnili sme medzinárodné prenosy pri platbách: zmluvní partneri sú v EÚ, prípadné ďalšie prenosy do USA zabezpečujú poskytovatelia vlastnými zárukami, a Ko-fi s Upholdom spadajú pod rozhodnutie o primeranosti pre Spojené kráľovstvo.',
        ],
        '2.8' => [
            'Týždenný newsletter odteraz okrem nových odborných článkov obsahuje aj krátky prehľad noviniek na portáli — nové kalkulačky, interaktívne nástroje a zmeny v ostatných častiach služby. Účel spracúvania a text súhlasu sme tomu prispôsobili; odber je stále dobrovoľný a kedykoľvek odvolateľný odhlásením.',
        ],
        '2.7' => [
            'Doplnili sme opis interného pracovného adresára zdravotníckych zariadení — aké kontaktné údaje v ňom vedieme, že pochádzajú z verejne dostupných profesijných zdrojov (register poskytovateľov e-VÚC a weby zariadení), že právnym základom je oprávnený záujem podľa čl. 6 ods. 1 písm. f) a že dotknuté osoby informujeme e-mailom podľa čl. 14 GDPR. Nejde o údaje pacientov.',
            'Spresnili sme, kto maže uložené výsledky klinických kalkulačiek: záznam vymaže ten, kto ho zadal, priamo vo svojom konte, na žiadosť používateľa ho vymaže prevádzkovateľ a všetky záznamy sa odstránia aj pri zrušení konta.',
            'Určili sme, že pri zdravotných údajoch zadaných lekárom vystupuje prevádzkovateľ v postavení prevádzkovateľa, nie sprostredkovateľa ambulancie, pretože sám určuje účely a prostriedky spracúvania; sprostredkovateľská zmluva podľa čl. 28 sa preto neuzatvára.',
            'Zjednotili sme označenie prevádzkovateľa na „MUDr. Ľubomír Polaščín - Nephroctor“ naprieč všetkými dokumentmi.',
        ],
        '2.6' => [
            'Registráciu sme obmedzili na osoby vo veku aspoň 16 rokov; ak miestne právo vyžaduje vyšší minimálny vek, platí tento vyšší vek.',
        ],
        '2.5' => [
            'Spresnili sme úplný rozsah nepovinných profilových údajov, pseudonymný charakter analytiky GA4, minimalizovaný audit po zrušení účtu, jeho 90-dňovú retenčnú lehotu a informáciu, že služba nevykonáva právne významné výlučne automatizované rozhodovanie ani profilovanie.',
        ],
        '2.4' => [
            'Lokálna história kalkulačiek pre neprihlásených sa odteraz vytvára iba po preferenčnom súhlase, neuchováva formulárové vstupy ani identifikátory pacienta a pri odvolaní súhlasu sa vymaže.',
        ],
        '2.3' => [
            'Rozšírili sme Službu o informačnú databázu liekov v nefrológii, register klinických štúdií (dáta z verejného registra ClinicalTrials.gov) a ďalšie informačné nástroje, ktoré samy nespracúvajú osobné údaje návštevníkov.',
        ],
        '2.2' => [
            'Do zoznamu sprostredkovateľov sme doplnili Twilio Inc. (USA), ktoré odosiela overovacie SMS kódy pri overení telefónneho čísla; prenos do USA je krytý štandardnými zmluvnými doložkami (SCC).',
        ],
        '2.1' => [
            'Webové písmo (Inter) sme presunuli na vlastný server — pri jeho načítaní sa už neprenáša žiadny údaj (IP adresa) do Google LLC (USA).',
        ],
        '2.0' => [
            'Právne dokumenty sme rozdelili do troch samostatných stránok: Zásady ochrany osobných údajov, Cookie Policy a Podmienky používania.',
            'Doplnili sme prehľad práv podľa regiónu (USA – CCPA/CPRA a GPC, Brazília – LGPD, Ázia, Austrália a Nový Zéland).',
            'Spresnili sme účely a právne základy spracúvania (prehľadná tabuľka) a zoznam sprostredkovateľov vrátane medzinárodných prenosov.',
            'Pridali sme sekcie o medzinárodných prenosoch a o ochrane údajov detí.',
            'Vykonali sme drobné jazykové spresnenia naprieč všetkými dokumentmi.',
        ],
    ];
}

/**
 * Bez verzie zachová celý prehľad na právnych stránkach.
 * S verziou vráti iba jej zmeny; neznáma verzia nemá žiadne položky.
 * @return list<string>
 */
function legalRecentUpdates(?string $version = null): array
{
    $byVersion = legalUpdatesByVersion();
    return $version === null ? array_merge(...array_values($byVersion)) : ($byVersion[$version] ?? []);
}
