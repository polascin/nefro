<?php

declare(strict_types=1);
/**
 * admin_providers.php
 * Kurátorská správa internej databázy spolupracujúcich poskytovateľov
 * (partner_providers) — sieť odporúčateľov okolo Medimpax Dúbravka.
 * Plný CRUD: pridať, upraviť, zmazať, prepnúť aktívnosť; filtre podľa lokality,
 * typu, odbornosti a vyhľadávanie.
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db_config.php';
/** @var \PDO $pdo */
require_once __DIR__ . '/providers_common.php';

requireAdmin();

$actionResult   = null; // plain text — escapuje sa pri výpise
$actionError    = null;
$editProvider   = null;
$editContacts   = [];
$editContact    = null; // konkrétny záznam histórie na úpravu (?contact=id)
$stayEditId     = null; // po zápise kontaktu ostaň v editačnom pohľade

$typeLabels = ppTypeLabels();

/** Orežanie na max dĺžku stĺpca; prázdny reťazec → null. */
function ppClean(string $v, int $max): ?string
{
    $v = trim($v);
    if ($v === '') {
        return null;
    }
    return mb_substr($v, 0, $max);
}

// ── Spracovanie POST akcií ────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!validateCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $actionError = 'Neplatný CSRF token.';
    } else {
        $action = (string) ($_POST['action'] ?? '');
        switch ($action) {
            case 'save':
                $id     = (int) ($_POST['provider_id'] ?? 0);
                $name   = trim((string) ($_POST['name'] ?? ''));
                $type   = (string) ($_POST['provider_type'] ?? 'specialista');
                $email  = trim((string) ($_POST['email'] ?? ''));
                $web    = trim((string) ($_POST['website'] ?? ''));
                $active = isset($_POST['is_active']) ? 1 : 0;
                $outreach = (string) ($_POST['outreach_status'] ?? 'nekontaktovany');
                if (!array_key_exists($outreach, ppOutreachLabels())) {
                    $outreach = 'nekontaktovany';
                }
                $priority = strtoupper((string) ($_POST['priority'] ?? ''));
                if (!array_key_exists($priority, ppPriorityLabels())) {
                    $priority = null;
                }
                $contactedRaw = trim((string) ($_POST['contacted_at'] ?? ''));
                $contactedVal = null;
                if ($contactedRaw !== '') {
                    if (preg_match('/^(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2})(:\d{2})?$/', $contactedRaw, $m)) {
                        $contactedVal = $m[1] . ' ' . $m[2] . ':00';
                    } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $contactedRaw)) {
                        $contactedVal = $contactedRaw . ' 00:00:00';
                    }
                }

                if ($name === '') {
                    $actionError = 'Názov je povinný.';
                    break;
                }
                if (!array_key_exists($type, $typeLabels)) {
                    $actionError = 'Neplatný typ poskytovateľa.';
                    break;
                }
                if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $actionError = 'Neplatný formát e-mailu.';
                    break;
                }
                if ($web !== '' && !preg_match('~^https?://~i', $web)) {
                    $web = 'https://' . $web;
                }

                $data = [
                    'name'           => mb_substr($name, 0, 255),
                    'provider_type'  => $type,
                    'specialization' => ppClean((string) ($_POST['specialization'] ?? ''), 255),
                    'locality'       => ppClean((string) ($_POST['locality'] ?? ''), 120),
                    'address'        => ppClean((string) ($_POST['address'] ?? ''), 255),
                    'phone'          => ppClean((string) ($_POST['phone'] ?? ''), 120),
                    'email'          => $email !== '' ? mb_substr($email, 0, 190) : null,
                    'website'        => $web !== '' ? mb_substr($web, 0, 255) : null,
                    'contact_person' => ppClean((string) ($_POST['contact_person'] ?? ''), 190),
                    'notes'          => ppClean((string) ($_POST['notes'] ?? ''), 20000),
                    'source'         => ppClean((string) ($_POST['source'] ?? ''), 255),
                    'ico'            => ppClean((string) ($_POST['ico'] ?? ''), 20),
                    'outreach_status' => $outreach,
                    'contacted_at'   => $contactedVal,
                    'priority'       => $priority,
                    'is_active'      => $active,
                ];

                try {
                    if ($id > 0) {
                        $data['id'] = $id;
                        $upd = $pdo->prepare(
                            'UPDATE partner_providers SET
                                name = :name, provider_type = :provider_type, specialization = :specialization,
                                locality = :locality, address = :address, phone = :phone, email = :email,
                                website = :website, contact_person = :contact_person, notes = :notes,
                                source = :source, ico = :ico, outreach_status = :outreach_status,
                                contacted_at = :contacted_at, priority = :priority, is_active = :is_active
                             WHERE id = :id'
                        );
                        $upd->execute($data);
                        $actionResult = 'Poskytovateľ „' . $name . '“ bol aktualizovaný.';
                    } else {
                        $ins = $pdo->prepare(
                            'INSERT INTO partner_providers
                                (name, provider_type, specialization, locality, address, phone, email,
                                 website, contact_person, notes, source, ico, outreach_status, contacted_at, priority, is_active)
                             VALUES
                                (:name, :provider_type, :specialization, :locality, :address, :phone, :email,
                                 :website, :contact_person, :notes, :source, :ico, :outreach_status, :contacted_at, :priority, :is_active)'
                        );
                        $ins->execute($data);
                        $actionResult = 'Poskytovateľ „' . $name . '“ bol pridaný.';
                    }
                } catch (\PDOException $e) {
                    error_log('admin_providers save error: ' . $e->getMessage());
                    $actionError = 'Chyba pri ukladaní poskytovateľa.';
                }
                break;

            case 'delete':
                $id = (int) ($_POST['provider_id'] ?? 0);
                if ($id <= 0) {
                    $actionError = 'Neplatné ID.';
                    break;
                }
                try {
                    $del = $pdo->prepare('DELETE FROM partner_providers WHERE id = :id');
                    $del->execute(['id' => $id]);
                    $actionResult = 'Poskytovateľ bol zmazaný.';
                } catch (\PDOException $e) {
                    error_log('admin_providers delete error: ' . $e->getMessage());
                    $actionError = 'Chyba pri mazaní poskytovateľa.';
                }
                break;

            case 'toggle_active':
                $id     = (int) ($_POST['provider_id'] ?? 0);
                $setVal = (int) ($_POST['set_active'] ?? -1);
                if ($id <= 0 || !in_array($setVal, [0, 1], true)) {
                    $actionError = 'Neplatný vstup.';
                    break;
                }
                try {
                    $upd = $pdo->prepare('UPDATE partner_providers SET is_active = :a WHERE id = :id');
                    $upd->execute(['a' => $setVal, 'id' => $id]);
                    $actionResult = $setVal === 1 ? 'Poskytovateľ je aktívny.' : 'Poskytovateľ je neaktívny.';
                } catch (\PDOException $e) {
                    error_log('admin_providers toggle error: ' . $e->getMessage());
                    $actionError = 'Chyba pri zmene stavu.';
                }
                break;

            // Rýchle označenie „Oslovený teraz“ — nastaví stav + dátum a čas + zápis do histórie.
            case 'mark_contacted':
                $id = (int) ($_POST['provider_id'] ?? 0);
                if ($id <= 0) {
                    $actionError = 'Neplatné ID.';
                    break;
                }
                try {
                    $pdo->beginTransaction();
                    $pdo->prepare("UPDATE partner_providers SET outreach_status = 'osloveny', contacted_at = NOW() WHERE id = :id")
                        ->execute(['id' => $id]);
                    $pdo->prepare("INSERT INTO provider_contacts (provider_id, contacted_at, channel, outcome, note)
                                   VALUES (:pid, NOW(), 'other', 'osloveny', :note)")
                        ->execute(['pid' => $id, 'note' => 'Rýchle označenie „Oslovený teraz“']);
                    $pdo->commit();
                    $actionResult = 'Označené ako oslovené (' . date('d.m.Y H:i') . ') — zapísané do histórie.';
                } catch (\PDOException $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    error_log('admin_providers mark_contacted error: ' . $e->getMessage());
                    $actionError = 'Chyba pri označení kontaktu.';
                }
                break;

            // Zápis kontaktu do histórie (z editačného pohľadu).
            case 'add_contact':
                $id = (int) ($_POST['provider_id'] ?? 0);
                if ($id <= 0) {
                    $actionError = 'Neplatné ID.';
                    break;
                }
                $stayEditId = $id;
                $ch = (string) ($_POST['channel'] ?? 'other');
                if (!array_key_exists($ch, ppContactChannelLabels())) {
                    $ch = 'other';
                }
                $outc = (string) ($_POST['outcome'] ?? '');
                if ($outc !== '' && !array_key_exists($outc, ppOutreachLabels())) {
                    $outc = '';
                }
                $cnote = ppClean((string) ($_POST['contact_note'] ?? ''), 20000);
                $craw  = trim((string) ($_POST['contact_at'] ?? ''));
                $cval  = null;
                if ($craw !== '' && preg_match('/^(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2})(:\d{2})?$/', $craw, $m2)) {
                    $cval = $m2[1] . ' ' . $m2[2] . ':00';
                }
                try {
                    $pdo->beginTransaction();
                    $pdo->prepare("INSERT INTO provider_contacts (provider_id, contacted_at, channel, outcome, note)
                                   VALUES (:pid, COALESCE(:cat, NOW()), :ch, :outc, :note)")
                        ->execute([
                            'pid'  => $id,
                            'cat'  => $cval,
                            'ch'   => $ch,
                            'outc' => $outc !== '' ? $outc : null,
                            'note' => $cnote,
                        ]);
                    if ($outc !== '') {
                        $pdo->prepare("UPDATE partner_providers SET contacted_at = COALESCE(:cat, NOW()), outreach_status = :outc WHERE id = :id")
                            ->execute(['cat' => $cval, 'outc' => $outc, 'id' => $id]);
                    } else {
                        $pdo->prepare("UPDATE partner_providers SET contacted_at = COALESCE(:cat, NOW()) WHERE id = :id")
                            ->execute(['cat' => $cval, 'id' => $id]);
                    }
                    $pdo->commit();
                    $actionResult = 'Kontakt bol zapísaný do histórie.';
                } catch (\PDOException $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    error_log('admin_providers add_contact error: ' . $e->getMessage());
                    $actionError = 'Chyba pri zápise kontaktu.';
                }
                break;

            // Úprava existujúceho záznamu histórie (needituje stav poskytovateľa).
            case 'update_contact':
                $cid = (int) ($_POST['contact_id'] ?? 0);
                $id  = (int) ($_POST['provider_id'] ?? 0);
                if ($cid <= 0 || $id <= 0) {
                    $actionError = 'Neplatné ID.';
                    break;
                }
                $stayEditId = $id;
                $ch = (string) ($_POST['channel'] ?? 'other');
                if (!array_key_exists($ch, ppContactChannelLabels())) {
                    $ch = 'other';
                }
                $outc = (string) ($_POST['outcome'] ?? '');
                if ($outc !== '' && !array_key_exists($outc, ppOutreachLabels())) {
                    $outc = '';
                }
                $cnote = ppClean((string) ($_POST['contact_note'] ?? ''), 20000);
                $craw  = trim((string) ($_POST['contact_at'] ?? ''));
                $cval  = null;
                if ($craw !== '' && preg_match('/^(\d{4}-\d{2}-\d{2})T(\d{2}:\d{2})(:\d{2})?$/', $craw, $m3)) {
                    $cval = $m3[1] . ' ' . $m3[2] . ':00';
                }
                try {
                    $pdo->prepare("UPDATE provider_contacts
                                   SET contacted_at = COALESCE(:cat, contacted_at), channel = :ch,
                                       outcome = :outc, note = :note
                                   WHERE id = :cid AND provider_id = :pid")
                        ->execute([
                            'cat'  => $cval,
                            'ch'   => $ch,
                            'outc' => $outc !== '' ? $outc : null,
                            'note' => $cnote,
                            'cid'  => $cid,
                            'pid'  => $id,
                        ]);
                    $actionResult = 'Záznam kontaktu bol upravený.';
                } catch (\PDOException $e) {
                    error_log('admin_providers update_contact error: ' . $e->getMessage());
                    $actionError = 'Chyba pri úprave kontaktu.';
                }
                break;

            // Zmazanie záznamu histórie.
            case 'delete_contact':
                $cid = (int) ($_POST['contact_id'] ?? 0);
                $id  = (int) ($_POST['provider_id'] ?? 0);
                if ($cid <= 0 || $id <= 0) {
                    $actionError = 'Neplatné ID.';
                    break;
                }
                $stayEditId = $id;
                try {
                    $pdo->prepare('DELETE FROM provider_contacts WHERE id = :cid AND provider_id = :pid')
                        ->execute(['cid' => $cid, 'pid' => $id]);
                    $actionResult = 'Záznam kontaktu bol zmazaný.';
                } catch (\PDOException $e) {
                    error_log('admin_providers delete_contact error: ' . $e->getMessage());
                    $actionError = 'Chyba pri mazaní kontaktu.';
                }
                break;

            default:
                $actionError = 'Neznáma akcia.';
                break;
        }
    }
}

// ── Načítanie na editáciu (GET alebo po zápise kontaktu) ──────────────────────
$editId = (int) ($_GET['id'] ?? 0);
if ($stayEditId !== null) {
    $editId = $stayEditId;
}
if (($stayEditId !== null || ($_GET['action'] ?? '') === 'edit') && $editId > 0) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM partner_providers WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $editId]);
        $editProvider = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        if ($editProvider !== null) {
            $cs = $pdo->prepare('SELECT * FROM provider_contacts WHERE provider_id = :id ORDER BY contacted_at DESC, id DESC');
            $cs->execute(['id' => (int) $editProvider['id']]);
            $editContacts = $cs->fetchAll(\PDO::FETCH_ASSOC);

            $contactEditId = (int) ($_GET['contact'] ?? 0);
            if ($contactEditId > 0) {
                foreach ($editContacts as $c) {
                    if ((int) $c['id'] === $contactEditId) {
                        $editContact = $c;
                        break;
                    }
                }
            }
        }
    } catch (\PDOException $e) {
        error_log('admin_providers edit load error: ' . $e->getMessage());
    }
}

// ── Filtre + zoznam ───────────────────────────────────────────────────────────
$fType = (string) ($_GET['type'] ?? '');
if ($fType !== '' && !array_key_exists($fType, $typeLabels)) {
    $fType = '';
}
$fLoc    = trim((string) ($_GET['loc'] ?? ''));
$fSpec   = trim((string) ($_GET['spec'] ?? ''));
$fActive = (string) ($_GET['active'] ?? '');
if (!in_array($fActive, ['', 'active', 'inactive'], true)) {
    $fActive = '';
}
$fOutreach = (string) ($_GET['outreach'] ?? '');
if ($fOutreach !== '' && !array_key_exists($fOutreach, ppOutreachLabels())) {
    $fOutreach = '';
}
$fPriority = strtoupper((string) ($_GET['priority'] ?? ''));
if ($fPriority !== '' && !array_key_exists($fPriority, ppPriorityLabels())) {
    $fPriority = '';
}
$fGroup = (string) ($_GET['group'] ?? '');
if (!in_array($fGroup, ['', 'type', 'locality', 'spec'], true)) {
    $fGroup = '';
}
$grouped = $fGroup !== '';
$fQuery = trim((string) ($_GET['q'] ?? ''));
foreach (['fLoc', 'fSpec', 'fQuery'] as $vn) {
    if (mb_strlen($$vn) > 120) {
        $$vn = mb_substr($$vn, 0, 120);
    }
}

$perPage = 50;
$page    = max(1, (int) ($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;

$where  = ' WHERE 1=1';
$params = [];
if ($fType !== '') {
    $where .= ' AND provider_type = :type';
    $params['type'] = $fType;
}
if ($fLoc !== '') {
    $where .= ' AND locality LIKE :loc';
    $params['loc'] = '%' . $fLoc . '%';
}
if ($fSpec !== '') {
    $where .= ' AND specialization LIKE :spec';
    $params['spec'] = '%' . $fSpec . '%';
}
if ($fActive === 'active') {
    $where .= ' AND is_active = 1';
} elseif ($fActive === 'inactive') {
    $where .= ' AND is_active = 0';
}
if ($fOutreach !== '') {
    $where .= ' AND outreach_status = :outreach';
    $params['outreach'] = $fOutreach;
}
if ($fPriority !== '') {
    $where .= ' AND priority = :priority';
    $params['priority'] = $fPriority;
}
if ($fQuery !== '') {
    $where .= ' AND (name LIKE :q OR email LIKE :q OR contact_person LIKE :q OR notes LIKE :q OR address LIKE :q)';
    $params['q'] = '%' . $fQuery . '%';
}

// ── Export (bod 1) — CSV / JSON / vCard; rešpektuje aktuálne filtre; admin už overený ──
$exportFmt = strtolower((string) ($_GET['export'] ?? ''));
if (in_array($exportFmt, ['csv', 'json', 'vcard'], true)) {
    $expStmt = $pdo->prepare('SELECT * FROM partner_providers' . $where . ' ORDER BY provider_type ASC, name ASC');
    $expStmt->execute($params);
    $rows  = $expStmt->fetchAll(\PDO::FETCH_ASSOC);
    $stamp = date('Y-m-d');

    if ($exportFmt === 'json') {
        header('Content-Type: application/json; charset=UTF-8');
        header('Content-Disposition: attachment; filename="poskytovatelia_' . $stamp . '.json"');
        echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        exit;
    }

    if ($exportFmt === 'vcard') {
        header('Content-Type: text/vcard; charset=UTF-8');
        header('Content-Disposition: attachment; filename="poskytovatelia_' . $stamp . '.vcf"');
        $esc = static fn (string $v): string => str_replace(["\\", "\n", ',', ';'], ['\\\\', '\\n', '\\,', '\\;'], $v);
        foreach ($rows as $r) {
            $name = (string) $r['name'];
            echo "BEGIN:VCARD\r\nVERSION:3.0\r\n";
            echo 'FN:' . $esc($name) . "\r\n";
            echo 'ORG:' . $esc($name) . "\r\n";
            if (!empty($r['specialization'])) {
                echo 'TITLE:' . $esc((string) $r['specialization']) . "\r\n";
            }
            if (!empty($r['phone'])) {
                echo 'TEL;TYPE=work,voice:' . $esc((string) $r['phone']) . "\r\n";
            }
            if (!empty($r['email'])) {
                echo 'EMAIL;TYPE=work:' . $esc((string) $r['email']) . "\r\n";
            }
            if (!empty($r['website'])) {
                echo 'URL:' . $esc((string) $r['website']) . "\r\n";
            }
            if (!empty($r['address']) || !empty($r['locality'])) {
                echo 'ADR;TYPE=work:;;' . $esc((string) ($r['address'] ?? '')) . ';' . $esc((string) ($r['locality'] ?? '')) . ';;;Slovensko' . "\r\n";
            }
            $noteParts = array_filter([
                ppTypeLabel((string) $r['provider_type']),
                'Stav: ' . ppOutreachLabel((string) $r['outreach_status']),
                !empty($r['notes']) ? (string) $r['notes'] : '',
            ]);
            if ($noteParts) {
                echo 'NOTE:' . $esc(implode(' | ', $noteParts)) . "\r\n";
            }
            echo "END:VCARD\r\n";
        }
        exit;
    }

    // CSV (predvolené) — UTF-8 BOM pre Excel
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="poskytovatelia_' . $stamp . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");
    fputcsv($out, ['Nazov', 'Typ', 'Odbornost', 'Lokalita', 'Adresa', 'Telefon', 'Email', 'Web',
        'ICO', 'Kontaktna osoba', 'Priorita', 'Stav oslovenia', 'Datum a cas kontaktu', 'Aktivny', 'Poznamky', 'Zdroj', 'Posledna zmena']);
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['name'],
            ppTypeLabel((string) $r['provider_type']),
            $r['specialization'],
            $r['locality'],
            $r['address'],
            $r['phone'],
            $r['email'],
            $r['website'],
            $r['ico'],
            $r['contact_person'],
            (string) ($r['priority'] ?? ''),
            ppOutreachLabel((string) $r['outreach_status']),
            $r['contacted_at'],
            ((int) $r['is_active'] === 1 ? 'ano' : 'nie'),
            $r['notes'],
            $r['source'],
            $r['updated_at'] ?? '',
        ]);
    }
    fclose($out);
    exit;
}

// ── Export histórie kontaktov (aktivít) do CSV ────────────────────────────────
if ($exportFmt === 'history') {
    $hstmt = $pdo->query(
        'SELECT pc.contacted_at, pp.name AS provider_name, pp.provider_type, pp.locality,
                pc.channel, pc.outcome, pc.note, pc.created_at
         FROM provider_contacts pc
         JOIN partner_providers pp ON pp.id = pc.provider_id
         ORDER BY pc.contacted_at DESC, pc.id DESC'
    );
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="historia_kontaktov_' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");
    fputcsv($out, ['Datum a cas', 'Poskytovatel', 'Typ', 'Lokalita', 'Kanal', 'Vysledok', 'Poznamka', 'Zaznamenane']);
    foreach ($hstmt as $r) {
        fputcsv($out, [
            $r['contacted_at'],
            $r['provider_name'],
            ppTypeLabel((string) $r['provider_type']),
            $r['locality'],
            ppContactChannelLabel((string) $r['channel']),
            !empty($r['outcome']) ? ppOutreachLabel((string) $r['outcome']) : '',
            $r['note'],
            $r['created_at'],
        ]);
    }
    fclose($out);
    exit;
}

$providers = [];
$total      = 0;
$totalPages = 1;
try {
    $countStmt = $pdo->prepare('SELECT COUNT(*) FROM partner_providers' . $where);
    $countStmt->execute($params);
    $total      = (int) $countStmt->fetchColumn();
    $totalPages = max(1, (int) ceil($total / $perPage));

    $orderBy = match ($fGroup) {
        'type'     => 'provider_type ASC, name ASC',
        'locality' => 'locality ASC, name ASC',
        'spec'     => 'specialization ASC, name ASC',
        default    => 'is_active DESC, locality ASC, name ASC',
    };

    if ($grouped) {
        // Zoskupené zobrazenie — bez stránkovania (dataset je malý).
        $listStmt = $pdo->prepare('SELECT * FROM partner_providers' . $where . ' ORDER BY ' . $orderBy . ' LIMIT 2000');
        $listStmt->execute($params);
    } else {
        $listStmt = $pdo->prepare('SELECT * FROM partner_providers' . $where . ' ORDER BY ' . $orderBy . ' LIMIT :limit OFFSET :offset');
        foreach ($params as $k => $v) {
            $listStmt->bindValue(':' . $k, $v);
        }
        $listStmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $listStmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $listStmt->execute();
    }
    $providers = $listStmt->fetchAll(\PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    error_log('admin_providers list error: ' . $e->getMessage());
    $actionError = $actionError ?? 'Chyba pri načítaní zoznamu (existuje tabuľka partner_providers?).';
}

// Súhrn podľa typu (informatívne).
$typeCounts = [];
try {
    $rows = $pdo->query('SELECT provider_type, COUNT(*) c FROM partner_providers GROUP BY provider_type')
        ->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        $typeCounts[(string) $r['provider_type']] = (int) $r['c'];
    }
} catch (\PDOException $e) {
    error_log('admin_providers typecount error: ' . $e->getMessage());
}

// Počet zaznamenaných kontaktov pre zobrazených poskytovateľov (história).
$contactCounts = [];
if (!empty($providers)) {
    $ids = array_map('intval', array_column($providers, 'id'));
    if ($ids !== []) {
        $inList = implode(',', $ids);
        try {
            foreach ($pdo->query("SELECT provider_id, COUNT(*) c FROM provider_contacts WHERE provider_id IN ($inList) GROUP BY provider_id") as $r) {
                $contactCounts[(int) $r['provider_id']] = (int) $r['c'];
            }
        } catch (\PDOException $e) {
            error_log('admin_providers contactcount error: ' . $e->getMessage());
        }
    }
}

// ── Akvizičný prehľad (funnel + follow-up) — nezávislé od filtrov, len aktívni ──
$FOLLOWUP_DAYS  = 14;   // prah „bez odozvy" v dňoch
$activeTotal    = 0;
$funnelCounts   = [];   // outreach_status => počet (aktívni)
$priorityCounts = [];   // priority (A/B/C/'') => počet (aktívni)
$followUps      = [];   // položky na follow-up
try {
    foreach (array_keys(ppOutreachLabels()) as $slug) {
        $funnelCounts[$slug] = 0;
    }
    foreach (array_keys(ppPriorityLabels()) as $slug) {
        $priorityCounts[$slug] = 0;
    }
    $priorityCounts[''] = 0;

    $ovStmt = $pdo->query(
        'SELECT id, name, provider_type, locality, priority, outreach_status, contacted_at,
                DATEDIFF(NOW(), contacted_at) AS days_since
         FROM partner_providers WHERE is_active = 1'
    );
    foreach ($ovStmt as $r) {
        $activeTotal++;
        $st = (string) $r['outreach_status'];
        if (array_key_exists($st, $funnelCounts)) {
            $funnelCounts[$st]++;
        }
        $pr = (string) ($r['priority'] ?? '');
        $priorityCounts[array_key_exists($pr, $priorityCounts) ? $pr : '']++;

        $days   = $r['days_since'] !== null ? (int) $r['days_since'] : null;
        $reason = null;
        $urg    = null;
        if ($st === 'nekontaktovany' && $pr !== '') {
            $reason = 'Neoslovený — priorita ' . $pr;
            $urg    = ['A' => 0, 'B' => 1, 'C' => 2][$pr] ?? 2;
        } elseif ($st === 'osloveny' && ($days === null || $days >= $FOLLOWUP_DAYS)) {
            $reason = $days === null ? 'Oslovený — bez dátumu, pripomenúť'
                                     : 'Oslovený — ' . $days . ' dní bez odozvy';
            $urg    = 3;
        } elseif ($st === 'odpovedal' && ($days === null || $days >= $FOLLOWUP_DAYS)) {
            $reason = 'Odpovedal — dotiahnuť spoluprácu';
            $urg    = 4;
        }
        if ($reason !== null) {
            $followUps[] = [
                'id'       => (int) $r['id'],
                'name'     => (string) $r['name'],
                'locality' => (string) ($r['locality'] ?? ''),
                'type'     => (string) $r['provider_type'],
                'priority' => $pr,
                'days'     => $days,
                'reason'   => $reason,
                'urg'      => $urg,
            ];
        }
    }
    usort($followUps, static function (array $a, array $b): int {
        if ($a['urg'] !== $b['urg']) {
            return $a['urg'] <=> $b['urg'];
        }
        $da = $a['days'] ?? -1;
        $db = $b['days'] ?? -1;
        if ($da !== $db) {
            return $db <=> $da; // najstaršie kontakty hore
        }
        return strcasecmp($a['name'], $b['name']);
    });
} catch (\PDOException $e) {
    error_log('admin_providers overview error: ' . $e->getMessage());
}

$csrfToken = generateCsrfToken();

/** Query string pre stránkovanie so zachovaním filtrov. */
function ppAdminQs(array $extra = []): string
{
    global $fType, $fLoc, $fSpec, $fActive, $fOutreach, $fPriority, $fGroup, $fQuery;
    $qs = array_filter([
        'type'     => $fType,
        'loc'      => $fLoc,
        'spec'     => $fSpec,
        'active'   => $fActive,
        'outreach' => $fOutreach,
        'priority' => $fPriority,
        'group'    => $fGroup,
        'q'        => $fQuery,
    ], static fn ($v): bool => $v !== '');
    $qs = array_merge($qs, $extra);
    return $qs === [] ? '' : '?' . http_build_query($qs);
}

// Hodnoty pre formulár (edit alebo prázdne).
$fv = static function (string $key) use ($editProvider): string {
    return htmlspecialchars((string) ($editProvider[$key] ?? ''), ENT_QUOTES);
};
$isEdit = $editProvider !== null;
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spolupracujúci poskytovatelia – Nefro-projekt Slovensko</title>
  <meta name="robots" content="noindex, nofollow">
  <script src="theme.js?v=20260509-1&cb=<?= filemtime('theme.js') ?>"></script>
  <link rel="stylesheet" href="index.css?v=20260509-1&cb=<?= filemtime('index.css') ?>">
  <script src="ui-preferences.js?v=20260511-1&cb=<?= filemtime('ui-preferences.js') ?>" defer></script>
  <script src="ui-preferences-fallback.js?v=20260511-1&cb=<?= filemtime('ui-preferences-fallback.js') ?>" defer></script>
  <script src="nefro-ui.js?v=<?= filemtime('nefro-ui.js') ?>" defer></script>
</head>
<body>
  <a href="#main-content" class="skip-link">Preskočiť na hlavný obsah</a>
  <?php
  $headerTitle = 'Spolupracujúci poskytovatelia';
  $headerIntro = 'Sieť odporúčateľov okolo Medimpax Dúbravka';
  $showLogo = false;
  include_once 'header.php';
  include_once 'admin_menu.php';
  ?>

  <main id="main-content" class="container container--wide admin-page-main" role="main">
    <div class="auth-container auth-container--wide">
      <h2>Spolupracujúci lekári a poskytovatelia</h2>
      <p class="auth-subtitle">
        Interná databáza siete odporúčateľov (zdravotná a sociálna starostlivosť) v pracovnom dosahu
        dialyzačného strediska a nefrologickej ambulancie Medimpax, Dúbravka. Nie je verejná.
      </p>

      <?php if ($actionResult !== null): ?>
        <div class="alert alert-success"><p><?= htmlspecialchars((string) $actionResult) ?></p></div>
      <?php endif; ?>
      <?php if ($actionError !== null): ?>
        <div class="alert alert-error"><p><?= htmlspecialchars($actionError) ?></p></div>
      <?php endif; ?>

      <!-- ── FORMULÁR: pridať / upraviť ─────────────────────────────────── -->
      <div class="primary-article">
        <h3><?= $isEdit ? 'Upraviť poskytovateľa' : 'Pridať poskytovateľa' ?></h3>
        <form method="POST" action="admin_providers.php">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="provider_id" value="<?= $isEdit ? (int) $editProvider['id'] : 0 ?>">

          <div class="article-form-grid">
            <div class="form-row">
              <label for="f_name">Názov / meno *</label>
              <input type="text" id="f_name" name="name" class="form-control" maxlength="255" required value="<?= $fv('name') ?>">
            </div>

            <div class="form-row">
              <label for="f_type">Typ poskytovateľa</label>
              <?php $curType = (string) ($editProvider['provider_type'] ?? 'specialista'); ?>
              <select id="f_type" name="provider_type" class="form-control">
                <?php foreach ($typeLabels as $slug => $label): ?>
                  <option value="<?= htmlspecialchars($slug) ?>" <?= $curType === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-row">
              <label for="f_spec">Odbornosť / špecializácia</label>
              <input type="text" id="f_spec" name="specialization" class="form-control" maxlength="255" list="spec_suggestions" value="<?= $fv('specialization') ?>">
              <datalist id="spec_suggestions">
                <?php foreach (ppSpecializationSuggestions() as $s): ?><option value="<?= htmlspecialchars($s) ?>"></option><?php endforeach; ?>
              </datalist>
            </div>

            <div class="form-row">
              <label for="f_loc">Lokalita</label>
              <input type="text" id="f_loc" name="locality" class="form-control" maxlength="120" list="loc_suggestions" value="<?= $fv('locality') ?>">
              <datalist id="loc_suggestions">
                <?php foreach (ppLocalitySuggestions() as $s): ?><option value="<?= htmlspecialchars($s) ?>"></option><?php endforeach; ?>
              </datalist>
            </div>

            <div class="form-row">
              <label for="f_addr">Adresa</label>
              <input type="text" id="f_addr" name="address" class="form-control" maxlength="255" value="<?= $fv('address') ?>">
            </div>

            <div class="form-row">
              <label for="f_phone">Telefón</label>
              <input type="text" id="f_phone" name="phone" class="form-control" maxlength="120" value="<?= $fv('phone') ?>">
            </div>

            <div class="form-row">
              <label for="f_email">E-mail</label>
              <input type="email" id="f_email" name="email" class="form-control" maxlength="190" value="<?= $fv('email') ?>">
            </div>

            <div class="form-row">
              <label for="f_web">Web</label>
              <input type="text" id="f_web" name="website" class="form-control" maxlength="255" value="<?= $fv('website') ?>">
            </div>

            <div class="form-row">
              <label for="f_ico">IČO</label>
              <input type="text" id="f_ico" name="ico" class="form-control" maxlength="20" value="<?= $fv('ico') ?>">
            </div>

            <div class="form-row">
              <label for="f_person">Kontaktná osoba</label>
              <input type="text" id="f_person" name="contact_person" class="form-control" maxlength="190" value="<?= $fv('contact_person') ?>">
            </div>

            <div class="form-row">
              <label for="f_outreach">Stav oslovenia</label>
              <?php $curOutreach = (string) ($editProvider['outreach_status'] ?? 'nekontaktovany'); ?>
              <select id="f_outreach" name="outreach_status" class="form-control">
                <?php foreach (ppOutreachLabels() as $slug => $label): ?>
                  <option value="<?= htmlspecialchars($slug) ?>" <?= $curOutreach === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-row">
              <label for="f_priority">Priorita</label>
              <?php $curPriority = (string) ($editProvider['priority'] ?? ''); ?>
              <select id="f_priority" name="priority" class="form-control">
                <option value="">(žiadna)</option>
                <?php foreach (ppPriorityLabels() as $slug => $label): ?>
                  <option value="<?= htmlspecialchars($slug) ?>" <?= $curPriority === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-row">
              <label for="f_contacted">Dátum a čas kontaktu</label>
              <?php
              $contactedInput = '';
              if (!empty($editProvider['contacted_at'])) {
                  $contactedInput = substr(str_replace(' ', 'T', (string) $editProvider['contacted_at']), 0, 16);
              }
              ?>
              <input type="datetime-local" id="f_contacted" name="contacted_at" class="form-control" value="<?= htmlspecialchars($contactedInput) ?>">
            </div>

            <div class="form-row">
              <label for="f_source">Zdroj údaja</label>
              <input type="text" id="f_source" name="source" class="form-control" maxlength="255" placeholder="napr. evuc.sk, web poskytovateľa" value="<?= $fv('source') ?>">
            </div>

            <div class="form-row">
              <label for="f_notes">Poznámky</label>
              <textarea id="f_notes" name="notes" class="form-control" rows="3"><?= htmlspecialchars((string) ($editProvider['notes'] ?? '')) ?></textarea>
            </div>

            <div class="form-row-inline">
              <label>
                <input type="checkbox" name="is_active" value="1" <?= (!$isEdit || (int) ($editProvider['is_active'] ?? 1) === 1) ? 'checked' : '' ?>>
                Aktívny (v sieti odporúčateľov)
              </label>
            </div>
          </div>

          <div class="form-actions admin-action-mt">
            <button type="submit" class="btn-primary"><?= $isEdit ? '💾 Uložiť zmeny' : '➕ Pridať' ?></button>
            <?php if ($isEdit): ?>
              <a href="admin_providers.php<?= ppAdminQs() ?>" class="btn-secondary-small">Zrušiť editáciu</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <?php if ($isEdit): ?>
      <div class="primary-article">
        <h3>História kontaktov</h3>
        <?php
        $isContactEdit = $editContact !== null;
        $pidEdit = (int) $editProvider['id'];
        $ceAt = ($isContactEdit && !empty($editContact['contacted_at']))
            ? substr(str_replace(' ', 'T', (string) $editContact['contacted_at']), 0, 16) : '';
        $ceCh   = (string) ($editContact['channel'] ?? '');
        $ceOut  = (string) ($editContact['outcome'] ?? '');
        $ceNote = (string) ($editContact['note'] ?? '');
        ?>
        <form method="POST" action="admin_providers.php" class="form-row-inline admin-filter-form">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
          <input type="hidden" name="action" value="<?= $isContactEdit ? 'update_contact' : 'add_contact' ?>">
          <input type="hidden" name="provider_id" value="<?= $pidEdit ?>">
          <?php if ($isContactEdit): ?><input type="hidden" name="contact_id" value="<?= (int) $editContact['id'] ?>"><?php endif; ?>
          <label for="c_at">Dátum/čas:</label>
          <input type="datetime-local" id="c_at" name="contact_at" class="form-control admin-select-md" value="<?= htmlspecialchars($ceAt) ?>">
          <label for="c_ch">Kanál:</label>
          <select id="c_ch" name="channel" class="form-control admin-select-sm">
            <?php foreach (ppContactChannelLabels() as $slug => $label): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $ceCh === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>
          <label for="c_out">Výsledok:</label>
          <select id="c_out" name="outcome" class="form-control admin-select-md">
            <option value="">(nemeniť stav)</option>
            <?php foreach (ppOutreachLabels() as $slug => $label): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $ceOut === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>
          <input type="text" name="contact_note" class="form-control admin-select-md" maxlength="1000" placeholder="Poznámka" value="<?= htmlspecialchars($ceNote) ?>">
          <button type="submit" class="btn-secondary-small"><?= $isContactEdit ? '💾 Uložiť kontakt' : '➕ Zapísať kontakt' ?></button>
          <?php if ($isContactEdit): ?><a href="admin_providers.php?action=edit&id=<?= $pidEdit ?>" class="btn-secondary-small">Zrušiť</a><?php endif; ?>
        </form>

        <?php if (empty($editContacts)): ?>
          <p class="helper-text">Zatiaľ žiadny zaznamenaný kontakt. Prázdny dátum = teraz.</p>
        <?php else: ?>
          <div class="overflow-x-auto">
            <table class="admin-articles-table" aria-label="História kontaktov">
              <thead><tr><th scope="col">Dátum a čas</th><th scope="col">Kanál</th><th scope="col">Výsledok</th><th scope="col">Poznámka</th><th scope="col">Akcie</th></tr></thead>
              <tbody>
                <?php foreach ($editContacts as $c): $ct = strtotime((string) $c['contacted_at']); $ccId = (int) $c['id']; ?>
                <tr>
                  <td><?= htmlspecialchars($ct ? date('d.m.Y H:i', $ct) : (string) $c['contacted_at']) ?></td>
                  <td><?= htmlspecialchars(ppContactChannelLabel((string) $c['channel'])) ?></td>
                  <td><?= !empty($c['outcome']) ? htmlspecialchars(ppOutreachLabel((string) $c['outcome'])) : '<span class="calc-result-detail">—</span>' ?></td>
                  <td><?= nl2br(htmlspecialchars((string) ($c['note'] ?? ''))) ?></td>
                  <td>
                    <a href="admin_providers.php?action=edit&id=<?= $pidEdit ?>&contact=<?= $ccId ?>" class="btn-secondary-small" title="Upraviť záznam">✏️</a>
                    <form method="POST" action="admin_providers.php" class="d-inline" onsubmit="return confirm('Zmazať tento záznam histórie?');">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="delete_contact">
                      <input type="hidden" name="provider_id" value="<?= $pidEdit ?>">
                      <input type="hidden" name="contact_id" value="<?= $ccId ?>">
                      <button type="submit" class="btn-secondary-small" title="Zmazať">🗑</button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <hr class="section-divider">

      <!-- ── AKVIZIČNÝ PREHĽAD (funnel + follow-up) ─────────────────────── -->
      <div class="primary-article">
        <h3>Akvizičný prehľad</h3>
        <?php if ($activeTotal === 0): ?>
          <p class="helper-text">Zatiaľ žiadni aktívni poskytovatelia v sieti.</p>
        <?php else: ?>
          <p class="helper-text">
            Aktívna sieť: <strong><?= (int) $activeTotal ?></strong> &nbsp;|&nbsp; Stav oslovenia:
            <?php
            $fp = [];
            foreach (ppOutreachLabels() as $slug => $label) {
                $fp[] = '<a href="admin_providers.php?active=active&amp;outreach=' . urlencode($slug) . '">'
                    . htmlspecialchars($label) . ': ' . (int) ($funnelCounts[$slug] ?? 0) . '</a>';
            }
            echo implode(' &middot; ', $fp);
            ?>
          </p>
          <p class="helper-text">
            Priorita:
            <?php
            $pp = [];
            foreach (ppPriorityLabels() as $slug => $label) {
                $pp[] = '<a href="admin_providers.php?active=active&amp;priority=' . urlencode($slug) . '">'
                    . htmlspecialchars($slug) . ': ' . (int) ($priorityCounts[$slug] ?? 0) . '</a>';
            }
            $pp[] = 'bez priority: ' . (int) $priorityCounts[''];
            echo implode(' &middot; ', $pp);
            ?>
          </p>

          <h4 class="calc-result-mt12">Potrebuje follow-up (<?= count($followUps) ?>)</h4>
          <?php if (empty($followUps)): ?>
            <p class="helper-text">Nič nečaká na follow-up — všetci prioritní sú oslovení a bez podlžností. 👍</p>
          <?php else: ?>
            <div class="overflow-x-auto">
              <table class="admin-articles-table" aria-label="Poskytovatelia na follow-up">
                <thead>
                  <tr>
                    <th scope="col">Poskytovateľ</th>
                    <th scope="col">Lokalita</th>
                    <th scope="col">Priorita</th>
                    <th scope="col">Dôvod</th>
                    <th scope="col" class="no-print">Akcie</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($followUps as $f): ?>
                  <tr>
                    <td>
                      <strong><?= htmlspecialchars($f['name']) ?></strong>
                      <br><span class="calc-result-detail"><?= htmlspecialchars(ppTypeLabel($f['type'])) ?></span>
                    </td>
                    <td><?= htmlspecialchars($f['locality']) ?></td>
                    <td><?= $f['priority'] !== '' ? '<span class="badge-top-sm">' . htmlspecialchars($f['priority']) . '</span>' : '<span class="calc-result-detail">—</span>' ?></td>
                    <td><?= htmlspecialchars($f['reason']) ?></td>
                    <td class="no-print">
                      <a href="admin_providers.php?action=edit&amp;id=<?= (int) $f['id'] ?>" class="btn-secondary-small">✏️ Upraviť</a>
                      <form method="POST" action="admin_providers.php" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="action" value="mark_contacted">
                        <input type="hidden" name="provider_id" value="<?= (int) $f['id'] ?>">
                        <button type="submit" class="btn-secondary-small" title="Označiť ako oslovené teraz + zápis do histórie">✅ Oslovený teraz</button>
                      </form>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- ── FILTRE + ZOZNAM ───────────────────────────────────────────── -->
      <div class="primary-article">
        <h3>Poskytovatelia (<?= (int) $total ?>)</h3>
        <?php if (!empty($typeCounts)): ?>
          <p class="helper-text">
            <?php $parts = [];
            foreach ($typeCounts as $tt => $cc) {
                $parts[] = htmlspecialchars(ppTypeLabel($tt)) . ': ' . (int) $cc;
            }
            echo implode(' &middot; ', $parts); ?>
          </p>
        <?php endif; ?>

        <form method="GET" action="admin_providers.php" class="form-row-inline admin-filter-form no-print">
          <label for="type">Typ:</label>
          <select id="type" name="type" class="form-control admin-select-md">
            <option value="">Všetky</option>
            <?php foreach ($typeLabels as $slug => $label): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $fType === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>

          <label for="loc">Lokalita:</label>
          <input type="search" id="loc" name="loc" class="form-control admin-select-md" maxlength="120" value="<?= htmlspecialchars($fLoc) ?>" placeholder="napr. Dúbravka">

          <label for="spec">Odbornosť:</label>
          <input type="search" id="spec" name="spec" class="form-control admin-select-md" maxlength="120" value="<?= htmlspecialchars($fSpec) ?>" placeholder="napr. diabetológia">

          <label for="active">Stav:</label>
          <select id="active" name="active" class="form-control admin-select-sm">
            <option value="" <?= $fActive === '' ? 'selected' : '' ?>>Všetky</option>
            <option value="active" <?= $fActive === 'active' ? 'selected' : '' ?>>Aktívni</option>
            <option value="inactive" <?= $fActive === 'inactive' ? 'selected' : '' ?>>Neaktívni</option>
          </select>

          <label for="outreach">Oslovenie:</label>
          <select id="outreach" name="outreach" class="form-control admin-select-md">
            <option value="">Všetky</option>
            <?php foreach (ppOutreachLabels() as $slug => $label): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $fOutreach === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>

          <label for="priority">Priorita:</label>
          <select id="priority" name="priority" class="form-control admin-select-sm">
            <option value="">Všetky</option>
            <?php foreach (ppPriorityLabels() as $slug => $label): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $fPriority === $slug ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
          </select>

          <label for="group">Zoskupiť:</label>
          <select id="group" name="group" class="form-control admin-select-md">
            <option value="" <?= $fGroup === '' ? 'selected' : '' ?>>(bez zoskupenia)</option>
            <option value="type" <?= $fGroup === 'type' ? 'selected' : '' ?>>podľa typu</option>
            <option value="locality" <?= $fGroup === 'locality' ? 'selected' : '' ?>>podľa lokality</option>
            <option value="spec" <?= $fGroup === 'spec' ? 'selected' : '' ?>>podľa odbornosti</option>
          </select>

          <label for="q">Hľadať:</label>
          <input type="search" id="q" name="q" class="form-control admin-select-md" maxlength="120" value="<?= htmlspecialchars($fQuery) ?>" placeholder="názov, e-mail, osoba">

          <button type="submit" class="btn-secondary-small">Filtrovať</button>
          <a href="admin_providers.php" class="btn-secondary-small">Reset</a>
          <a href="admin_providers.php<?= ppAdminQs(['export' => 'csv']) ?>" class="btn-secondary-small" title="Export do CSV (Excel)">⬇ CSV</a>
          <a href="admin_providers.php<?= ppAdminQs(['export' => 'json']) ?>" class="btn-secondary-small" title="Export do JSON">⬇ JSON</a>
          <a href="admin_providers.php<?= ppAdminQs(['export' => 'vcard']) ?>" class="btn-secondary-small" title="Export do vCard (kontakty .vcf)">⬇ vCard</a>
          <a href="admin_providers.php?export=history" class="btn-secondary-small" title="Export celej histórie kontaktov do CSV">⬇ História CSV</a>
          <button type="button" id="btnPrintProviders" class="btn-secondary-small" title="Vytlačiť aktuálny výber">🖨 Tlačiť</button>
        </form>

        <?php if (empty($providers)): ?>
          <p class="calc-result-mt12">Pre zvolený filter sa nenašli žiadni poskytovatelia.</p>
        <?php else: ?>
          <?php
          $groupValOf = static function (array $p) use ($fGroup): string {
              return match ($fGroup) {
                  'type'     => (string) $p['provider_type'],
                  'locality' => (string) ($p['locality'] ?? ''),
                  'spec'     => (string) ($p['specialization'] ?? ''),
                  default    => '',
              };
          };
          $groupLabelOf = static function (string $v) use ($fGroup): string {
              if ($fGroup === 'type') {
                  return ppTypeLabel($v);
              }
              return $v !== '' ? $v : '(neuvedené)';
          };
          $groupCounts = [];
          if ($grouped) {
              foreach ($providers as $gp) {
                  $gv = $groupValOf($gp);
                  $groupCounts[$gv] = ($groupCounts[$gv] ?? 0) + 1;
              }
          }
          $curGroup = null;
          ?>
          <div class="overflow-x-auto">
            <table class="admin-articles-table" aria-label="Zoznam poskytovateľov">
              <thead>
                <tr>
                  <th scope="col">Názov</th>
                  <th scope="col">Typ</th>
                  <th scope="col">Odbornosť</th>
                  <th scope="col">Lokalita</th>
                  <th scope="col">Kontakt</th>
                  <th scope="col">Stav</th>
                  <th scope="col" class="no-print">Akcie</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($providers as $p):
                    $pId = (int) $p['id'];
                    $pActive = (int) ($p['is_active'] ?? 0) === 1;
                    if ($grouped):
                        $gv = $groupValOf($p);
                        if ($gv !== $curGroup):
                            $curGroup = $gv;
                ?>
                <tr class="admin-group-row"><th colspan="7" scope="colgroup"><?= htmlspecialchars($groupLabelOf($gv)) ?> <span class="calc-result-detail">(<?= (int) $groupCounts[$gv] ?>)</span></th></tr>
                <?php
                        endif;
                    endif;
                ?>
                <tr>
                  <td>
                    <strong><?= htmlspecialchars((string) $p['name']) ?></strong>
                    <?php if (!empty($p['priority'])): ?> <span class="badge-top-sm" title="Priorita">Priorita <?= htmlspecialchars((string) $p['priority']) ?></span><?php endif; ?>
                    <?php if (!empty($p['contact_person'])): ?><br><span class="calc-result-detail"><?= htmlspecialchars((string) $p['contact_person']) ?></span><?php endif; ?>
                    <?php if (!empty($p['address'])): ?><br><span class="calc-result-detail"><?= htmlspecialchars((string) $p['address']) ?></span><?php endif; ?>
                  </td>
                  <td><?= htmlspecialchars(ppTypeLabel((string) $p['provider_type'])) ?></td>
                  <td><?= htmlspecialchars((string) ($p['specialization'] ?? '')) ?></td>
                  <td><?= htmlspecialchars((string) ($p['locality'] ?? '')) ?></td>
                  <td>
                    <?php if (!empty($p['phone'])): ?><?= htmlspecialchars((string) $p['phone']) ?><br><?php endif; ?>
                    <?php if (!empty($p['email'])): ?><a href="mailto:<?= htmlspecialchars((string) $p['email']) ?>"><?= htmlspecialchars((string) $p['email']) ?></a><br><?php endif; ?>
                    <?php if (!empty($p['website'])): ?><a href="<?= htmlspecialchars((string) $p['website']) ?>" target="_blank" rel="noopener noreferrer">web ↗</a><?php endif; ?>
                  </td>
                  <td>
                    <?php if ($pActive): ?>
                      <span class="badge-pub">Aktívny</span>
                    <?php else: ?>
                      <span class="badge-draft">Neaktívny</span>
                    <?php endif; ?>
                    <br><span class="calc-result-detail"><?= htmlspecialchars(ppOutreachLabel((string) ($p['outreach_status'] ?? ''))) ?><?php if (!empty($p['contacted_at'])): $_ct = strtotime((string) $p['contacted_at']); ?> · <?= htmlspecialchars($_ct ? date('d.m.Y H:i', $_ct) : (string) $p['contacted_at']) ?><?php endif; ?></span>
                    <?php $cc = $contactCounts[$pId] ?? 0; if ($cc > 0): ?><br><span class="calc-result-detail">🗒 <?= (int) $cc ?> kontakt(ov)</span><?php endif; ?>
                    <?php if (!empty($p['updated_at'])): $_ut = strtotime((string) $p['updated_at']); ?><br><span class="calc-result-detail">Zmenené: <?= htmlspecialchars($_ut ? date('d.m.Y H:i', $_ut) : (string) $p['updated_at']) ?></span><?php endif; ?>
                  </td>
                  <td class="no-print">
                    <a href="admin_providers.php?action=edit&id=<?= $pId ?>" class="btn-secondary-small">✏️ Upraviť</a>
                    <form method="POST" action="admin_providers.php" class="d-inline">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="mark_contacted">
                      <input type="hidden" name="provider_id" value="<?= $pId ?>">
                      <button type="submit" class="btn-secondary-small" title="Nastaviť stav Oslovený s dnešným dátumom a časom">✅ Oslovený teraz</button>
                    </form>
                    <form method="POST" action="admin_providers.php" class="d-inline">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="toggle_active">
                      <input type="hidden" name="provider_id" value="<?= $pId ?>">
                      <input type="hidden" name="set_active" value="<?= $pActive ? 0 : 1 ?>">
                      <button type="submit" class="btn-secondary-small"><?= $pActive ? '🙈 Deaktivovať' : '👁 Aktivovať' ?></button>
                    </form>
                    <form method="POST" action="admin_providers.php" class="d-inline" onsubmit="return confirm('Naozaj zmazať tohto poskytovateľa?');">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="provider_id" value="<?= $pId ?>">
                      <button type="submit" class="btn-secondary-small" title="Zmazať">🗑 Zmazať</button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <?php if (!$grouped && $totalPages > 1): ?>
            <nav class="articles-pagination admin-pagination" aria-label="Stránkovanie poskytovateľov">
              <span class="articles-pagination__label">Stránky:</span>
              <div class="articles-pagination__links">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                  <?php if ($p === $page): ?>
                    <span class="articles-page-link is-active" aria-current="page"><?= $p ?></span>
                  <?php else: ?>
                    <a class="articles-page-link" href="admin_providers.php<?= ppAdminQs(['page' => $p]) ?>"><?= $p ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
            </nav>
          <?php endif; ?>
        <?php endif; ?>
      </div>

    </div><!-- /.auth-container -->
  </main>

  <script nonce="<?= htmlspecialchars(getScriptNonce()) ?>">
  (function () {
    var b = document.getElementById('btnPrintProviders');
    if (b) { b.addEventListener('click', function () { window.print(); }); }
  })();
  </script>

  <?php include_once 'footer.php'; ?>

</body>
</html>
