<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 70400) {
    $configFile = __DIR__ . '/phpcsfixer/php73.php';
} elseif (PHP_VERSION_ID < 80000) {
    $configFile = __DIR__ . '/phpcsfixer/php74.php';
} elseif (PHP_VERSION_ID < 80100) {
    $configFile = __DIR__ . '/phpcsfixer/php80.php';
} elseif (PHP_VERSION_ID < 80200) {
    $configFile = __DIR__ . '/phpcsfixer/php81.php';
} elseif (PHP_VERSION_ID < 80300) {
    $configFile = __DIR__ . '/phpcsfixer/php82.php';
} elseif (PHP_VERSION_ID < 80400) {
    $configFile = __DIR__ . '/phpcsfixer/php83.php';
} elseif (PHP_VERSION_ID < 80500) {
    $configFile = __DIR__ . '/phpcsfixer/php84.php';
} else {
    $configFile = __DIR__ . '/phpcsfixer/php85.php';
}

return require_once $configFile;
