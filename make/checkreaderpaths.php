<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Verifies every entity path literal used by ZugferdDocumentReader against the
 * generated JMS metadata.
 *
 * ZugferdDocumentReader addresses the generated entity graph through stringly-typed
 * paths such as "getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.
 * getShipToTradeParty.getID". Those strings are hand written, while the entities they
 * address are generated from the XSD by xsd2php. Nothing connects the two, so a typo -
 * or a cardinality change in a new schema release - makes the path silently resolve to
 * the default value instead of raising. That is data loss which a test can only catch
 * if a fixture happens to populate that exact field.
 *
 * The types are read from src/yaml (the JMS mapping), NOT from the @return annotations
 * of the generated entities. The annotations are derived from the XSD base type and lie
 * about what the property actually holds at runtime: ExchangedDocumentType::getTypeCode()
 * is annotated "@return string" while JMS deserializes a qdt\DocumentCodeType object into
 * it, which is exactly why the reader appends ".value" to that path. The JMS mapping is
 * the contract the reader really walks, and it is regenerated together with the entities.
 *
 * Usage: php make/checkreaderpaths.php
 * Exit code 0 = all paths resolve, 1 = at least one broken path.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

final class ReaderPathChecker
{
    /**
     * Profile whose metadata is used to resolve the paths. "extended" is the superset of
     * all profiles, so a path valid in any profile is valid here.
     */
    private const PROFILE = 'extended';

    private const ROOT_CLASS = 'horstoeko\\zugferd\\entities\\%s\\rsm\\CrossIndustryInvoiceType';

    private const YAML_DIR = __DIR__ . '/../src/yaml/%s';

    private const READER_FILE = __DIR__ . '/../src/ZugferdDocumentReader.php';

    /** @var string */
    private $profile;

    /**
     * class => [getterName => ['type' => FQCN, 'collection' => bool]]
     *
     * @var array<string,array<string,array{type:string,collection:bool}>>
     */
    private $graph = [];

    /** @var array<int,array{line:int,path:string,error:string}> */
    private $problems = [];

    /** @var int */
    private $checked = 0;

    public function __construct(string $profile = self::PROFILE)
    {
        $this->profile = $profile;
    }

    public function run(): int
    {
        $this->buildGraph();

        $source = file_get_contents(self::READER_FILE);

        if ($source === false) {
            fwrite(STDERR, "Cannot read " . self::READER_FILE . "\n");
            return 1;
        }

        foreach ($this->extractPaths($source) as $usage) {
            $this->checked++;
            $this->checkPath($usage);
        }

        return $this->report();
    }

    /**
     * Build a getter => type graph out of the generated JMS mapping.
     *
     * @return void
     */
    private function buildGraph(): void
    {
        $yamlDirectory = sprintf(self::YAML_DIR, $this->profile);

        $directoryIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($yamlDirectory));

        foreach ($directoryIterator as $fileInfo) {
            if (!$fileInfo->isFile() || $fileInfo->getExtension() !== 'yml') {
                continue;
            }

            $parsed = Yaml::parseFile($fileInfo->getPathname());

            if (!is_array($parsed)) {
                continue;
            }

            foreach ($parsed as $className => $definition) {
                if (!isset($definition['properties']) || !is_array($definition['properties'])) {
                    continue;
                }

                foreach ($definition['properties'] as $property) {
                    if (!isset($property['type'], $property['accessor']['getter'])) {
                        continue;
                    }

                    $type = (string) $property['type'];
                    $collection = false;

                    if (preg_match('/^array<(.+)>$/', $type, $matches) === 1) {
                        $collection = true;
                        $type = $matches[1];
                    }

                    $this->graph[ltrim($className, '\\')][strtolower((string) $property['accessor']['getter'])] = [
                        'type' => ltrim($type, '\\'),
                        'collection' => $collection,
                    ];
                }
            }
        }
    }

    /**
     * Pull every path literal out of the reader source together with its line number.
     *
     * getInvoiceValueByPath("a.b")         -> absolute, resolvable from the document root
     * getInvoiceValueByPathFrom($x, "a.b") -> relative, root not known statically
     *
     * @param  string $source
     * @return array<int,array{line:int,path:string,absolute:bool}>
     */
    private function extractPaths(string $source): array
    {
        $usages = [];

        $patterns = [
            ['regex' => '/getInvoiceValueByPathFrom\s*\(\s*[^,]+,\s*"([^"]+)"/', 'absolute' => false],
            ['regex' => '/getInvoiceValueByPath\s*\(\s*"([^"]+)"/', 'absolute' => true],
        ];

        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern['regex'], $source, $matches, PREG_OFFSET_CAPTURE) === false) {
                continue;
            }

            foreach ($matches[1] as $match) {
                $usages[] = [
                    'line' => substr_count(substr($source, 0, $match[1]), "\n") + 1,
                    'path' => $match[0],
                    'absolute' => $pattern['absolute'],
                ];
            }
        }

        usort(
            $usages,
            function (array $a, array $b): int {
                return $a['line'] <=> $b['line'];
            }
        );

        return $usages;
    }

    /**
     * @param  array{line:int,path:string,absolute:bool} $usage
     * @return void
     */
    private function checkPath(array $usage): void
    {
        $segments = explode('.', $usage['path']);

        // Lexical check, also valid for relative paths whose root is unknown. A segment
        // containing a comma is the classic "getA,getB" typo - a PHP method name cannot
        // contain one, so the lookup silently misses and the default value is returned.
        foreach ($segments as $segment) {
            if (preg_match('/^(get[A-Za-z0-9_]+|value)$/i', $segment) !== 1) {
                $this->addProblem($usage, sprintf('segment "%s" is not a valid accessor name', $segment));
                return;
            }
        }

        if ($usage['absolute'] === true) {
            $this->resolveAbsolute($usage, $segments);
        }
    }

    /**
     * Walk an absolute path through the JMS type graph.
     *
     * @param  array{line:int,path:string,absolute:bool} $usage
     * @param  array<int,string>                         $segments
     * @return void
     */
    private function resolveAbsolute(array $usage, array $segments): void
    {
        $currentClass = sprintf(self::ROOT_CLASS, $this->profile);

        foreach ($segments as $index => $segment) {
            $isLast = $index === count($segments) - 1;
            $next = $segments[$index + 1] ?? null;

            // "value" unwraps a udt/qdt leaf object into its scalar. Nothing may follow it.
            if (strtolower($segment) === 'value') {
                if (!method_exists($currentClass, 'value')) {
                    $this->addProblem($usage, sprintf('%s has no value() method, so ".value" cannot be read here', $this->shortName($currentClass)));
                    return;
                }

                if (!$isLast) {
                    $this->addProblem($usage, sprintf('%s::value() returns a scalar; the path continues with "%s", but nothing can follow a scalar', $this->shortName($currentClass), $next));
                }

                return;
            }

            if (!isset($this->graph[$currentClass])) {
                $this->addProblem($usage, sprintf('%s is a leaf type; it has no property "%s"', $this->shortName($currentClass), $segment));
                return;
            }

            $property = $this->graph[$currentClass][strtolower($segment)] ?? null;

            if ($property === null) {
                $this->addProblem($usage, sprintf('%s has no mapped getter %s()', $this->shortName($currentClass), $segment));
                return;
            }

            if ($isLast) {
                return;
            }

            if ($property['collection'] === true) {
                $this->addProblem(
                    $usage,
                    sprintf(
                        '%s::%s() is a collection of %s; the path continues with "%s", but a collection must be indexed before it can be walked',
                        $this->shortName($currentClass),
                        $segment,
                        $this->shortName($property['type']),
                        $next
                    )
                );
                return;
            }

            $currentClass = $property['type'];
        }
    }

    private function shortName(string $className): string
    {
        $position = strrpos($className, '\\');

        return $position === false ? $className : substr($className, $position + 1);
    }

    /**
     * @param  array{line:int,path:string,absolute:bool} $usage
     * @param  string                                    $error
     * @return void
     */
    private function addProblem(array $usage, string $error): void
    {
        $this->problems[] = [
            'line' => $usage['line'],
            'path' => $usage['path'],
            'error' => $error,
        ];
    }

    private function report(): int
    {
        printf("Checked %d entity paths in ZugferdDocumentReader against profile \"%s\".\n", $this->checked, $this->profile);

        if ($this->problems === []) {
            print("No broken paths found.\n");
            return 0;
        }

        printf("\n%d broken path(s):\n\n", count($this->problems));

        foreach ($this->problems as $problem) {
            printf("  src/ZugferdDocumentReader.php:%d\n", $problem['line']);
            printf("    path : %s\n", $problem['path']);
            printf("    error: %s\n\n", $problem['error']);
        }

        return 1;
    }
}

exit((new ReaderPathChecker())->run());
