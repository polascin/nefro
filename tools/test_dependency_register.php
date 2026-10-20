<?php

declare(strict_types=1);

require_once __DIR__ . '/dependency_register.php';

$root = dirname(__DIR__);
$checks = 0;
function dependencyTest(bool $ok, string $message): void
{
    global $checks;
    ++$checks;
    if (!$ok) {
        throw new RuntimeException($message);
    }
}

// Skutočný register: hashe sedia a každý dodaný súbor je evidovaný.
$register = dependencyRegisterLoad();
$problems = dependencyRegisterCheck($register, $root);
dependencyTest($problems === [], "Register závislostí nesedí:\n" . implode("\n", $problems));
dependencyTest(count($register['entries']) >= 5, 'Register musí evidovať všetky známe dodané knižnice a nástroje.');
foreach ($register['entries'] as $entry) {
    dependencyTest(preg_match('~^https://~', (string) $entry['origin']) === 1 || str_contains((string) $entry['origin'], 'https://'), 'Pôvod musí odkazovať na primárny zdroj: ' . $entry['id']);
}

// Syntetický koreň: zmena súboru, chýbajúci súbor a neevidovaný súbor sa odhalia; voliteľný chýbajúci PHAR nie.
$tmpRoot = sys_get_temp_dir() . '/nefro-deps-' . bin2hex(random_bytes(6));
foreach (['assets/katex/9.9.9/contrib', 'assets/katex/9.9.9/fonts', 'assets/fonts', 'tools'] as $dir) {
    mkdir($tmpRoot . '/' . $dir, 0777, true);
}
file_put_contents($tmpRoot . '/assets/katex/9.9.9/katex.min.js', 'js');
file_put_contents($tmpRoot . '/assets/katex/9.9.9/katex.min.css', 'css');
file_put_contents($tmpRoot . '/assets/katex/9.9.9/LICENSE', 'MIT');
file_put_contents($tmpRoot . '/assets/qrcode.min.js', 'qr');
file_put_contents($tmpRoot . '/assets/fonts/inter.woff2', 'font');
$meta = ['name' => 'x', 'version' => '1', 'origin' => 'https://example.invalid', 'license' => 'MIT', 'advisories' => 'https://example.invalid/a', 'update' => 'postup'];
$synthetic = ['schema' => 1, 'updated' => '2026-01-01', 'entries' => [
    $meta + ['id' => 'katex', 'patterns' => ['assets/katex/*/*.js', 'assets/katex/*/*.css', 'assets/katex/*/LICENSE']],
    $meta + ['id' => 'qr', 'patterns' => ['assets/*.js']],
    $meta + ['id' => 'font', 'patterns' => ['assets/fonts/*']],
    $meta + ['id' => 'phar', 'optional' => true, 'patterns' => ['tools/*.phar']],
]];
$updated = dependencyRegisterUpdate($synthetic, $tmpRoot, '2026-10-20');
dependencyTest($updated['updated'] === '2026-10-20' && count($updated['entries'][0]['files']) === 3, 'Aktualizácia prepočíta hashe podľa vzorov.');
dependencyTest(!isset($updated['entries'][3]['files']), 'Voliteľná položka bez súborov neexistujúce hashe nevymýšľa.');
$updated['entries'][3]['files'] = ['tools/phpstan.phar' => str_repeat('0', 64)];
dependencyTest(dependencyRegisterCheck($updated, $tmpRoot) === [], 'Čerstvo prepočítaný register musí prejsť; chýbajúci voliteľný PHAR sa preskočí.');

file_put_contents($tmpRoot . '/assets/qrcode.min.js', 'qr-zmenené');
$problems = dependencyRegisterCheck($updated, $tmpRoot);
dependencyTest(count($problems) === 1 && str_contains($problems[0], 'SHA-256 nesedí'), 'Zmenená knižnica sa musí odhaliť.');

file_put_contents($tmpRoot . '/assets/fonts/novy.woff2', 'x');
$problems = dependencyRegisterCheck($updated, $tmpRoot);
dependencyTest(in_array('Neevidovaný dodaný súbor: assets/fonts/novy.woff2', $problems, true), 'Neevidovaný dodaný súbor sa musí odhaliť.');

unlink($tmpRoot . '/assets/katex/9.9.9/LICENSE');
$problems = dependencyRegisterCheck($updated, $tmpRoot);
dependencyTest(count(array_filter($problems, static fn (string $p): bool => str_contains($p, 'evidovaný súbor chýba'))) === 1, 'Chýbajúci povinný súbor sa musí odhaliť.');

$broken = $updated;
unset($broken['entries'][0]['license']);
$problems = dependencyRegisterCheck($broken, $tmpRoot);
dependencyTest(in_array('katex: chýba pole license.', $problems, true), 'Chýbajúce metadáta sa musia odhaliť.');

// Upratanie.
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tmpRoot, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
foreach ($it as $item) {
    $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
}
rmdir($tmpRoot);

echo "Dependency register: $checks PASS\n";
