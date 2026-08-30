<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\ConvertStaticToSelfRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveDuplicatedReturnSelfDocblockRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveMixedDocblockOverruledByNativeTypeRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessUnionReturnDocblockRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/../src',
        __DIR__ . '/../examples',
        __DIR__ . '/../make',
        __DIR__ . '/../tests',
    ])
    ->withSkip([
        __DIR__ . '/../build',
        __DIR__ . '/../vendor',
        __DIR__ . '/../.git',
        __DIR__ . '/rector-cache',
        __DIR__ . '/../src/entities',
        __DIR__ . '/../src/codelistsenum',

        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
        RemoveUselessVarTagRector::class,
        ConvertStaticToSelfRector::class,
        NewStaticToNewSelfRector::class,
        SimplifyIfReturnBoolRector::class,
        UseClassKeywordForClassNameResolutionRector::class,
        CallUserFuncArrayToVariadicRector::class,
        RemoveDuplicatedReturnSelfDocblockRector::class,
        RemoveUselessUnionReturnDocblockRector::class,
        RemoveMixedDocblockOverruledByNativeTypeRector::class,
    ])
    ->withPhpVersion(PhpVersion::PHP_73)
    ->withPhpSets(false, false, false, false, false, true)
    ->withPreparedSets(true, true, true, false, false, false, false, false, true, false, false, false, false, true)
    ->withComposerBased(false, false, true)
    ->withRules([
        DeclareStrictTypesRector::class,
    ])
    ->withImportNames(false, false, true, true)
    ->withCache(__DIR__ . '/rector-cache', FileCacheStorage::class)
    ->withParallel(60000, 2, 10)
    ->withTypeCoverageLevel(0)
    ->withTypeCoverageDocblockLevel(0);
