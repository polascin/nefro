<?php
declare(strict_types=1);
$t = file_get_contents(__DIR__ . '/../add_litium-sedem-mytov-nefrologicka-perspektiva_article.php');
foreach (['o lítium', 'pri lítium', 'mýty o lítium', 'pri lítiu', 'o lítiu', 'vďaka', 'tedy', 'pouze', 'který', 'může', 'ledvin', 'výrazně', 'proto ', 'také ', 'lítiom', 'o lítium'] as $w) {
    $n = substr_count($t, $w);
    if ($n > 0 || in_array($w, ['o lítium', 'pri lítium', 'mýty o lítium'], true)) {
        echo "$w => $n\n";
    }
}
