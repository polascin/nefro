<?php

declare(strict_types=1);
/**
 * provider_notices.php
 *
 * Informovanie poskytovateľov v adresári `partner_providers` podľa čl. 14 GDPR
 * (údaje získané inak než od dotknutej osoby — z registra e-VÚC a z webov zariadení).
 *
 * Čl. 14 ods. 3 písm. a) žiada informovanie v primeranej lehote, najneskôr do jedného
 * mesiaca od získania údajov. Tento modul robí z tejto povinnosti opakovateľný proces:
 * fronta + worker + doložiteľný stav pri každom zázname.
 *
 * Rozsah je vecne obmedzený. V adresári je 67 záznamov, z toho 38 má e-mail
 * (35 unikátnych schránok) a 29 nemá žiadny. Pre záznamy bez e-mailu sa oznámenie
 * poslať nedá; na tie sa použije výnimka podľa čl. 14 ods. 5 písm. b) — informácia
 * je verejne dostupná v zásadách ochrany súkromia (`privacy.php`) a záznam sa označí
 * ako `verejne`, aby bolo zrejmé, ktorou cestou bola povinnosť splnená.
 *
 * Oznámenie je čisto informačné. NESMIE obsahovať ponuku spolupráce ani propagáciu —
 * inak by šlo o nevyžiadanú obchodnú komunikáciu podľa § 62 zákona č. 351/2011 Z. z.,
 * na ktorú je potrebný súhlas. Splnenie právnej povinnosti transparentnosti súhlas
 * nevyžaduje, ale len dovtedy, kým sa doň nepribalí marketing.
 */

require_once __DIR__ . '/legal_data.php';
require_once __DIR__ . '/email_verification.php';
require_once __DIR__ . '/newsletter_notifications.php';
require_once __DIR__ . '/legal_notifications.php';

if (!defined('PROVIDER_NOTICE_VERSION')) {
    /**
     * Verzia oznámenia. Zmena verzie umožní v budúcnosti informovať znova
     * (napr. pri zmene účelu spracúvania). Fronta je unikátna na dvojicu
     * (verzia, e-mail), takže zvýšenie verzie je jediný spôsob, ako oznámenie
     * poslať na tú istú adresu druhý raz.
     */
    define('PROVIDER_NOTICE_VERSION', '1.0');
}

if (!defined('PROVIDER_OBJECTION_DEFAULT_TTL')) {
    // Námietku musí byť možné uplatniť aj po dlhšom čase — e-mail si adresát
    // môže otvoriť po dovolenke. Rok je kompromis medzi použiteľnosťou a tým,
    // aby podpísaný odkaz neplatil navždy.
    define('PROVIDER_OBJECTION_DEFAULT_TTL', 365 * 24 * 3600);
}

if (!function_exists('providerNoticeNormalizeEmail')) {
    function providerNoticeNormalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }
}

if (!function_exists('providerEmailHash')) {
    /**
     * Nezvratný odtlačok e-mailu pre `provider_suppressions`.
     *
     * HMAC, nie holý sha256: e-mailových adries je konečne veľa a obyčajný hash
     * by sa dal spätne dohľadať zoznamom. S tajným kľúčom to nejde.
     */
    function providerEmailHash(string $email): string
    {
        return hash_hmac(
            'sha256',
            'provider-suppression|' . providerNoticeNormalizeEmail($email),
            getNewsletterUnsubscribeSecret()
        );
    }
}

if (!function_exists('buildProviderObjectionSignature')) {
    function buildProviderObjectionSignature(int $providerId, string $email, int $expiresAt): string
    {
        // Predpona oddeľuje doménu podpisu od newsletterových odkazov, ktoré
        // používajú ten istý kľúč — token z jedného kontextu nesmie platiť v druhom.
        $payload = 'provider-objection|' . $providerId . '|'
            . providerNoticeNormalizeEmail($email) . '|' . $expiresAt;

        return hash_hmac('sha256', $payload, getNewsletterUnsubscribeSecret());
    }
}

if (!function_exists('buildProviderObjectionUrl')) {
    function buildProviderObjectionUrl(int $providerId, string $email, int $ttlSeconds = PROVIDER_OBJECTION_DEFAULT_TTL): string
    {
        $ttlSeconds = max(3600, min(2 * 365 * 24 * 3600, $ttlSeconds));
        $expiresAt  = time() + $ttlSeconds;

        return getAppBaseUrl() . '/provider_namietka.php?pid=' . urlencode((string) $providerId)
            . '&exp=' . urlencode((string) $expiresAt)
            . '&sig=' . urlencode(buildProviderObjectionSignature($providerId, $email, $expiresAt));
    }
}

if (!function_exists('verifyProviderObjectionSignature')) {
    function verifyProviderObjectionSignature(int $providerId, string $email, int $expiresAt, string $signature): bool
    {
        if ($expiresAt < time()) {
            return false;
        }
        $expected = buildProviderObjectionSignature($providerId, $email, $expiresAt);

        return hash_equals($expected, $signature);
    }
}

if (!function_exists('providerNoticeDescribeSource')) {
    /**
     * Prevedie internú poznámku o zdroji na vetu zrozumiteľnú adresátovi.
     *
     * V `partner_providers.source` je pracovný zápis („master dokument (Littlebird)
     * / e-VÚC, 2026-06-30“), ktorý mimo projektu nikomu nič nepovie. Čl. 14 ods. 2
     * písm. f) však žiada uviesť zdroj tak, aby mu dotknutá osoba rozumela — ide
     * o to, aby vedela, kde sa jej údaje vzali, nie o presný názov nášho súboru.
     * Prekladáme preto na kategóriu zdroja a dátum ponechávame, ak je v zápise.
     */
    function providerNoticeDescribeSource(string $source): string
    {
        $source = trim($source);
        if ($source === '') {
            return 'Verejne dostupné profesijné zdroje — register poskytovateľov zdravotnej '
                . 'starostlivosti e-VÚC a webové stránky zdravotníckych zariadení.';
        }

        $date = preg_match('/(\d{4}-\d{2}-\d{2})/', $source, $m) === 1 ? $m[1] : '';

        if (stripos($source, 'e-VÚC') !== false || stripos($source, 'e-VUC') !== false) {
            return 'Verejne dostupný register poskytovateľov zdravotnej starostlivosti e-VÚC'
                . ($date !== '' ? ', stav k ' . $date : '') . '.';
        }

        // Zvyšné záznamy pochádzajú z webu samotného zariadenia; v poznámke je doména.
        if (preg_match('/([a-z0-9-]+\.[a-z]{2,})/i', $source, $m) === 1) {
            return 'Verejne dostupná webová stránka zariadenia (' . $m[1] . ')'
                . ($date !== '' ? ', stav k ' . $date : '') . '.';
        }

        return 'Verejne dostupné profesijné zdroje — register poskytovateľov zdravotnej '
            . 'starostlivosti e-VÚC a webové stránky zdravotníckych zariadení.';
    }
}

if (!function_exists('buildProviderNoticeEmailHtml')) {
    /**
     * Telo oznámenia podľa čl. 14 GDPR.
     *
     * Poradie a obsah kopírujú zoznam povinných informácií, aby sa dalo overiť
     * bod po bode: totožnosť prevádzkovateľa, účel a právny základ vrátane
     * konkrétneho oprávneného záujmu, kategórie údajov, ZDROJ údajov
     * (čl. 14 ods. 2 písm. f) — to je práve to, čo pri nepriamom získaní chýba
     * najčastejšie), príjemcovia, doba uchovávania, práva a dozorný úrad.
     *
     * @param array{id:int,name:string,email:string,source:?string} $provider
     */
    function buildProviderNoticeEmailHtml(array $provider, string $objectionUrl): string
    {
        $info = legalInfo();
        $e    = static fn(?string $s): string => htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');

        $name       = $e($provider['name']);
        $sourceText = $e(providerNoticeDescribeSource((string) ($provider['source'] ?? '')));

        $operator = $e($info['operator']);
        $companyId = $e($info['companyId']);
        $contact  = $e($info['contactEmail']);
        $url      = $e($info['url']);
        $authority = $e($info['supervisoryAuthority']);
        $authorityUrl = $e($info['supervisoryAuthorityUrl']);
        $objection = $e($objectionUrl);

        return <<<HTML
<p>Dobrý deň,</p>

<p>v internom pracovnom adresári zdravotníckych zariadení, ktorý vedie prevádzkovateľ
webu <a href="{$url}">{$url}</a>, evidujeme kontaktné údaje zariadenia
<strong>{$name}</strong>. Údaje sme nezískali od vás, ale z verejne dostupných zdrojov,
a preto vás o tom podľa <strong>článku 14 nariadenia GDPR</strong> informujeme.</p>

<p><em>Toto nie je ponuka ani reklama. Je to zákonom vyžadovaná informácia o spracúvaní
údajov a nič od vás nežiada.</em></p>

<h3>Kto údaje spracúva</h3>
<p>{$operator}, IČO {$companyId}, prevádzkovateľ webu {$url}.<br>
Kontakt vo veciach ochrany údajov: <a href="mailto:{$contact}">{$contact}</a></p>

<h3>Odkiaľ údaje pochádzajú</h3>
<p>{$sourceText}</p>

<h3>Aké údaje evidujeme</h3>
<p>Názov zariadenia, typ a odbornosť, adresa, telefón, e-mail, webová stránka, IČO
a prípadná pracovná poznámka. <strong>Neevidujeme žiadne údaje pacientov</strong>
a údaje nepoužívame na profilovanie ani automatizované rozhodovanie.</p>

<h3>Na aký účel a na akom právnom základe</h3>
<p>Účelom je vedenie prehľadu nefrologických a súvisiacich pracovísk na Slovensku
a prípadné oslovenie vo veci odbornej spolupráce. Právnym základom je
<strong>oprávnený záujem</strong> podľa čl. 6 ods. 1 písm. f) GDPR — konkrétne záujem
udržiavať aktuálny prehľad pracovísk v odbore a nadviazať odbornú spoluprácu.
Ide o profesijné kontaktné údaje zverejnené na profesijné účely, nie o údaje
súkromnej povahy, takže zásah do súkromia je minimálny.</p>

<h3>Komu údaje poskytujeme</h3>
<p>Nikomu. Údaje neposkytujeme tretím stranám ani ich neprenášame mimo Európskej únie.
Sú uložené na hostingu poskytovateľa WebSupport, s. r. o., ktorý pre nás vystupuje
ako sprostredkovateľ.</p>

<h3>Ako dlho ich uchovávame</h3>
<p>Kým trvá uvedený účel, alebo do vašej námietky — podľa toho, čo nastane skôr.</p>

<h3>Vaše práva</h3>
<p>Máte právo na prístup k údajom, na ich opravu, výmaz, obmedzenie spracúvania,
na prenosnosť a právo namietať. Máte tiež právo podať sťažnosť dozornému úradu:
<a href="{$authorityUrl}">{$authority}</a>. Ktorékoľvek z týchto práv môžete uplatniť
odpoveďou na tento e-mail alebo na adrese <a href="mailto:{$contact}">{$contact}</a>.</p>

<h3>Právo namietať</h3>
<p><strong>Proti spracúvaniu na základe oprávneného záujmu môžete kedykoľvek namietať.
Nemusíte to nijako odôvodňovať.</strong> Ak namietnete, záznam z adresára bez zbytočného
odkladu vymažeme a znova vás neoslovíme. Stačí kliknúť:</p>

<p><a href="{$objection}">Namietam — vymažte môj záznam z adresára</a></p>

<p>Rovnaký účinok má aj obyčajná odpoveď na tento e-mail so slovom „namietam“.</p>
HTML;
    }
}

if (!function_exists('enqueueProviderNotices')) {
    /**
     * Zaradí oznámenia pre aktívne záznamy s e-mailom, ktoré ešte neboli informované.
     *
     * Deduplikácia je na úrovni schránky, nie záznamu: viacero pracovísk zdieľa tú istú
     * adresu (napr. spoločná klinika), takže bez toho by jedna schránka dostala oznámenie
     * niekoľkokrát. Zabezpečuje to UNIQUE (notice_version, email) spolu s INSERT IGNORE.
     *
     * Adresy zo `provider_suppressions` (skoršia námietka) sa preskočia — to je celý
     * zmysel toho zoznamu.
     *
     * @return array{candidates:int,enqueued:int,suppressed:int}
     */
    function enqueueProviderNotices(PDO $pdo): array
    {
        $version = PROVIDER_NOTICE_VERSION;

        $rows = $pdo->query(
            "SELECT id, name, email
               FROM partner_providers
              WHERE is_active = 1
                AND email IS NOT NULL
                AND email <> ''
                AND notice_status IN ('neinformovany', 'zlyhal')
              ORDER BY id"
        )->fetchAll(PDO::FETCH_ASSOC);

        $suppressedHashes = $pdo->query('SELECT email_hash FROM provider_suppressions')
            ->fetchAll(PDO::FETCH_COLUMN, 0);
        $suppressed = array_flip(array_map('strval', $suppressedHashes));

        $insert = $pdo->prepare(
            'INSERT IGNORE INTO provider_notice_queue (notice_version, provider_id, email)
             VALUES (:v, :pid, :email)'
        );

        $enqueued = 0;
        $skipped  = 0;
        $seen     = [];

        foreach ($rows as $row) {
            $email = providerNoticeNormalizeEmail((string) $row['email']);
            if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                continue;
            }
            if (isset($suppressed[providerEmailHash($email)])) {
                $skipped++;
                continue;
            }
            // Vrámci jedného behu si pamätáme už videné adresy, aby sme na tú istú
            // schránku nerobili zbytočné INSERT-y; UNIQUE to poistí aj naprieč behmi.
            if (isset($seen[$email])) {
                continue;
            }
            $seen[$email] = true;

            $insert->execute([':v' => $version, ':pid' => (int) $row['id'], ':email' => $email]);
            if ($insert->rowCount() > 0) {
                $enqueued++;
            }
        }

        return ['candidates' => count($rows), 'enqueued' => $enqueued, 'suppressed' => $skipped];
    }
}

if (!function_exists('markProvidersInformedPublicly')) {
    /**
     * Záznamy bez e-mailu podľa čl. 14 ods. 5 písm. b).
     *
     * Poskytnutie informácie priamo dotknutej osobe tu nie je možné — kontaktná adresa
     * jednoducho nie je k dispozícii. Nariadenie na taký prípad pripúšťa, aby sa informácia
     * sprístupnila verejne; to spĺňajú zásady ochrany súkromia, kde je adresár opísaný
     * vrátane zdroja údajov a právneho základu. Označením `verejne` je pri každom zázname
     * doložiteľné, ktorou cestou bola povinnosť splnená.
     *
     * @return int počet označených záznamov
     */
    function markProvidersInformedPublicly(PDO $pdo): int
    {
        $stmt = $pdo->prepare(
            "UPDATE partner_providers
                SET notice_status = 'verejne', notice_sent_at = NOW()
              WHERE is_active = 1
                AND (email IS NULL OR email = '')
                AND notice_status = 'neinformovany'"
        );
        $stmt->execute();

        return $stmt->rowCount();
    }
}

if (!function_exists('processProviderNoticeQueue')) {
    /**
     * Odošle frontu oznámení.
     *
     * @param bool   $dryRun neodosiela ani nemení stav; len vypíše, čo by sa stalo
     * @param string $only   ak je uvedená, spracuje sa výhradne táto e-mailová adresa
     * @return array{selected:int,sent:int,failed:int,skipped:int}
     */
    function processProviderNoticeQueue(
        PDO $pdo,
        int $limit = 25,
        int $maxAttempts = 5,
        bool $dryRun = true,
        string $only = ''
    ): array {
        $version = PROVIDER_NOTICE_VERSION;
        $stats   = ['selected' => 0, 'sent' => 0, 'failed' => 0, 'skipped' => 0];

        // Cielenie na jednu adresu existuje kvôli prvému ostrému kusu: bez neho by
        // `--limit=1` poslal tomu, kto je vo fronte prvý podľa id, nie tomu, koho
        // si odosielateľ vybral na skúšku.
        $only   = providerNoticeNormalizeEmail($only);
        $params = [':v' => $version];
        $filter = '';
        if ($only !== '') {
            $filter            = ' AND LOWER(q.email) = :only';
            $params[':only']   = $only;
        }

        $select = $pdo->prepare(
            "SELECT q.id, q.provider_id, q.email, q.attempts, p.name, p.source
               FROM provider_notice_queue q
               JOIN partner_providers p ON p.id = q.provider_id
              WHERE q.notice_version = :v
                AND q.status = 'pending'
                AND q.next_attempt_at <= NOW()
                {$filter}
              ORDER BY q.id
              LIMIT {$limit}"
        );
        $select->execute($params);
        $items = $select->fetchAll(PDO::FETCH_ASSOC);

        $stats['selected'] = count($items);
        if ($items === []) {
            return $stats;
        }

        $markSent = $pdo->prepare(
            "UPDATE provider_notice_queue
                SET status = 'sent', sent_at = NOW(), attempts = attempts + 1, last_error = NULL
              WHERE id = :id"
        );
        // Stav sa prenáša na VŠETKY záznamy s touto schránkou, nielen na ten jeden,
        // cez ktorý sa oznámenie odoslalo — adresát bol informovaný raz a platí to
        // pre celú adresu, inak by ostatné záznamy ostali navždy „neinformovany“
        // a ďalší beh by na tú istú schránku poslal oznámenie znova.
        $markProviders = $pdo->prepare(
            "UPDATE partner_providers
                SET notice_status = 'odoslany', notice_sent_at = NOW()
              WHERE LOWER(email) = :email"
        );
        $markFailed = $pdo->prepare(
            "UPDATE provider_notice_queue
                SET status = CASE WHEN attempts + 1 >= :maxa THEN 'failed' ELSE 'pending' END,
                    attempts = attempts + 1,
                    next_attempt_at = DATE_ADD(NOW(), INTERVAL POW(2, LEAST(attempts, 6)) * 5 MINUTE),
                    last_error = :err
              WHERE id = :id"
        );
        $markProviderFailed = $pdo->prepare(
            "UPDATE partner_providers SET notice_status = 'zlyhal' WHERE LOWER(email) = :email"
        );

        $subject = 'Informácia o spracúvaní kontaktných údajov (čl. 14 GDPR) — nefro.polascin.net';

        foreach ($items as $item) {
            $email = (string) $item['email'];
            $pid   = (int) $item['provider_id'];

            if ($dryRun) {
                echo "  [nasucho] {$email}  ({$item['name']})\n";
                $stats['skipped']++;
                continue;
            }

            $objectionUrl = buildProviderObjectionUrl($pid, $email);
            $bodyHtml     = buildProviderNoticeEmailHtml([
                'id'     => $pid,
                'name'   => (string) $item['name'],
                'email'  => $email,
                'source' => $item['source'] !== null ? (string) $item['source'] : null,
            ], $objectionUrl);

            $ok = false;
            try {
                $ok = legalNoticeSendOne($email, $subject, $bodyHtml);
            } catch (Throwable $e) {
                $ok = false;
                $error = $e->getMessage();
            }

            if ($ok) {
                $markSent->execute([':id' => (int) $item['id']]);
                $markProviders->execute([':email' => $email]);
                $stats['sent']++;
                echo "  odoslané: {$email}\n";
            } else {
                $markFailed->execute([
                    ':maxa' => $maxAttempts,
                    ':err'  => $error ?? 'Odoslanie zlyhalo (SMTP aj mail() fallback).',
                    ':id'   => (int) $item['id'],
                ]);
                if ((int) $item['attempts'] + 1 >= $maxAttempts) {
                    $markProviderFailed->execute([':email' => $email]);
                }
                $stats['failed']++;
                echo "  ZLYHALO: {$email}\n";
            }
            unset($error);
        }

        return $stats;
    }
}

if (!function_exists('providerNoticeSummary')) {
    /**
     * Prehľad stavu — na overenie pred odoslaním aj po ňom.
     *
     * @return array<string,int>
     */
    function providerNoticeSummary(PDO $pdo): array
    {
        $out = [];
        foreach ($pdo->query(
            'SELECT notice_status, COUNT(*) n FROM partner_providers WHERE is_active = 1 GROUP BY notice_status'
        ) as $row) {
            $out[(string) $row['notice_status']] = (int) $row['n'];
        }

        return $out;
    }
}
