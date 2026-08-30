<?php

declare(strict_types=1);

$createConfig = require_once __DIR__ . '/common.php';
$rules = require_once __DIR__ . '/rules-php73.php';

return $createConfig($rules, false);
