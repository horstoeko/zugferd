<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/../examples',
        __DIR__ . '/../make',
        __DIR__ . '/../src',
        __DIR__ . '/../tests',
    ])
    ->withSkip([
        __DIR__ . '/../src/entities',
        __DIR__ . '/../src/codelistsenum',
    ])
    ->withSkip([
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
    ])
    ->withPhp73Sets()
    ->withPreparedSets(
        codeQuality: true,
        codingStyle: true,
        strictBooleans: true,
        instanceOf: true,
        earlyReturn: true,
        //
        carbon: false,
        deadCode: false,
        doctrineCodeQuality: false,
        naming: false,
        phpunitCodeQuality: false,
        privatization: false,
        rectorPreset: false,
        symfonyCodeQuality: false,
        symfonyConfigs: false,
        typeDeclarations: false,
    );