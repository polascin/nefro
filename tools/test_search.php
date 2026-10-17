<?php

declare(strict_types=1);

require_once __DIR__ . '/../search_helpers.php';

$checks = 0;
function searchTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Natívny PDO MySQL odmieta opakované pomenované parametre; SQLite ich povoľuje.
class NativeSearchTestPdo extends PDO
{
    public array $statements = [];

    public function __construct()
    {
    }

    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        preg_match_all('/(?<!:):([a-zA-Z_][a-zA-Z_0-9]*)/', $query, $matches);
        if (count($matches[1]) !== count(array_unique($matches[1]))) {
            throw new PDOException('SQLSTATE[HY093]: duplicate named parameter');
        }
        $statement = new NativeSearchTestStatement($query);
        $this->statements[] = $statement;
        return $statement;
    }
}

class NativeSearchTestStatement extends PDOStatement
{
    public array $values = [];

    public function __construct(public string $sql)
    {
    }

    public function bindValue(string|int $param, mixed $value, int $type = PDO::PARAM_STR): bool
    {
        $this->values[ltrim((string) $param, ':')] = $value;
        return true;
    }

    public function execute(?array $params = null): bool
    {
        $values = $params ?? $this->values;
        preg_match_all('/(?<!:):([a-zA-Z_][a-zA-Z_0-9]*)/', $this->sql, $matches);
        foreach ($matches[1] as $name) {
            if (!array_key_exists($name, $values)) {
                throw new PDOException('Unbound parameter');
            }
        }
        return true;
    }

    public function fetchColumn(int $column = 0): mixed
    {
        return str_contains($this->sql, 'information_schema') ? 1 : 3;
    }

    public function fetchAll(int $mode = PDO::FETCH_DEFAULT, mixed ...$args): array
    {
        return [['id' => 3, 'title' => 'Syntetický výsledok']];
    }
}

$pdo = new NativeSearchTestPdo();
$result = doArticleSearch($pdo, searchTokenize('obličky'), 1, 10);
searchTest($result['strategy'] === 'fulltext', 'Natívne parametre nesmú potichu vypnúť FULLTEXT.');
searchTest($result['total'] === 3 && count($result['items']) === 1, 'FULLTEXT musí vrátiť nájdené výsledky.');
$last = $pdo->statements[array_key_last($pdo->statements)];
searchTest($last->values['q'] === $last->values['q_score'], 'Filter a skóre používajú ten istý výraz.');
searchTest(str_contains($last->sql, 'published_at DESC, id DESC'), 'Rovnaké skóre a čas majú stabilné poradie.');
$large = doArticleSearch($pdo, searchTokenize('obličky'), PHP_INT_MAX, 10);
$last = $pdo->statements[array_key_last($pdo->statements)];
searchTest(is_int($last->values['off']) && $last->values['off'] >= 0, 'Veľká strana nesmie pretiecť na float.');
searchTest($large['strategy'] === 'fulltext', 'Veľká strana nesmie vyvolať TypeError.');

$resend = (string) file_get_contents(__DIR__ . '/../resend_verification.php');
preg_match('/SELECT id, username, email, email_verified_at, email_verification_sent_at\s+FROM users[^"\']+/', $resend, $query);
searchTest(isset($query[0]), 'Nájdený dotaz opätovného overenia.');
$pdo->prepare($query[0]);
searchTest(true, 'Dotaz opätovného overenia rešpektuje natívne placeholdery.');

class LikeSearchTestPdo extends PDO
{
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        return parent::prepare(str_replace('LEFT(content, 3000)', 'substr(content, 1, 3000)', $query), $options);
    }
}
$like = new LikeSearchTestPdo('sqlite::memory:');
$like->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$like->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$like->exec('CREATE TABLE articles (id INTEGER PRIMARY KEY, title TEXT, slug TEXT, author TEXT,
    excerpt TEXT, content TEXT, published_at TEXT, is_published INTEGER)');
$insert = $like->prepare('INSERT INTO articles VALUES (?, ?, ?, ?, ?, ?, ?, 1)');
foreach ([2, 5, 1, 4, 3] as $id) {
    $insert->execute([$id, 'synthetic renal', 'synthetic-' . $id, 'Fictional Author', '', 'renal', '2026-01-01']);
}
$first = searchViaLike($like, ['renal' => 'renal'], 0, 2, false);
$second = searchViaLike($like, ['renal' => 'renal'], 2, 2, false);
searchTest(array_column($first['items'], 'id') === [5, 4], 'Prvá strana pri zhode skóre a času.');
searchTest(array_column($second['items'], 'id') === [3, 2], 'Druhá strana nemá prekryv.');

$highlighted = highlightSearchTerms('mark class & <script>alert(1)</script>', ['mark' => 'mark', 'class' => 'class']);
searchTest(substr_count($highlighted, '<mark class="search-hl">') === 2, 'Zvýraznenie nesmie prepisovať vlastné značky.');
searchTest(!str_contains($highlighted, '<script>') && str_contains($highlighted, '&lt;script&gt;'), 'HTML v texte zostáva escapované.');
searchTest(str_contains($highlighted, '&amp;'), 'Ampersand zostáva správne escapovaný.');
searchTest(highlightSearchTerms('A & B', []) === 'A &amp; B', 'Aj prázdne vyhľadávanie escapuje text.');
$overlap = highlightSearchTerms('renal renalny', ['renal' => 'renal', 'renalny' => 'renalny']);
searchTest(substr_count($overlap, '<mark ') === 2, 'Prekrývajúce sa výrazy sa zvýraznia iba raz.');
$unicode = highlightSearchTerms('Obličky', ['oblicky' => 'obličky']);
searchTest(strip_tags($unicode) === 'Obličky', 'Zvýraznenie zachová diakritiku.');
$snippet = buildSearchSnippet('<p>&lt;img src=x onerror=alert(1)&gt; obličky</p>', searchTokenize('obličky'));
searchTest(!str_contains($snippet, '<img') && str_contains($snippet, '&lt;img'), 'Snippet nesmie dekódovaním vytvoriť aktívne HTML.');

echo "Search: $checks PASS\n";
