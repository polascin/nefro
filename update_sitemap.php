<?php
require_once 'db_config.php';
$baseUrl = 'https://nefro.polascin.net/';
$urls = [
    '',
    'calculators.php',
    'calculator_egfr.php',
    'calculator_kdigo_risk.php',
    'calculator_kfre.php',
    'calculator_ckdpc.php',
    'calculator_igan.php',
    'calculator_adpkd.php',
    'calculator_aki.php',
    'calculator_cg.php',
    'calculator_ca.php',
    'calculator_na.php',
    'calculator_acidbase.php',
    'calculator_egfr_slope.php',
    'calculator_ktv.php',
    'calculator_uacr.php',
    'privacy.php'
];

$content = file_get_contents('sitemap.php');

$newArrayStr = '$urls = [';
foreach ($urls as $u) {
    if ($u === '') {
        $loc = '$baseUrl';
        $priority = '1.0';
        $freq = "'daily'";
    } else {
        $loc = '$baseUrl . \'' . $u . '\'';
        if ($u === 'calculators.php') {
            $priority = '0.9';
            $freq = "'weekly'";
        } else {
            $priority = '0.8';
            $freq = "'weekly'";
        }
    }
    
    $newArrayStr .= "\n    [\n        'loc' => $loc,\n        'lastmod' => date('c'),\n        'changefreq' => $freq,\n        'priority' => '$priority',\n    ],";
}
$newArrayStr .= "\n];";

$content = preg_replace('/\$urls = \[.*?\];/s', $newArrayStr, $content, 1);
file_put_contents('sitemap.php', $content);
echo 'sitemap.php updated.';
