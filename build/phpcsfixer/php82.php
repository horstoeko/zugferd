<?php

declare(strict_types=1);

$createConfig = require_once __DIR__ . '/common.php';
$rules = require_once __DIR__ . '/rules-modern.php';

return $createConfig($rules, true);
