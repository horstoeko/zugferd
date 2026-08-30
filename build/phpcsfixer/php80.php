<?php

declare(strict_types=1);

$createConfig = require_once __DIR__ . '/common.php';
$rules = require_once __DIR__ . '/rules-php80.php';

return $createConfig($rules, true);
