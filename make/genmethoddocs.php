<?php

use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\ZugferdDocument;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfBuilder;
use horstoeko\zugferd\ZugferdDocumentPdfMerger;
use horstoeko\zugferd\ZugferdDocumentPdfReader;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdDocumentValidator;
use horstoeko\zugferd\ZugferdKositValidator;
use horstoeko\zugferd\ZugferdSettings;
use horstoeko\zugferd\ZugferdXsdValidator;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Printer;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Exception\PcreException;
use Webmozart\Assert\InvalidArgumentException;

require dirname(__FILE__) . "/../vendor/autoload.php";

class ExtractClass
{
    /**
     * The class to analyze
     *
     * @var string
     */
    protected $className = "";

    /**
     * Constructor
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * Returns the current classnane
     *
     * @return string
     * */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Returns the base name of the current classname
     *
     * @return string
     */
    public function getClassBasename(): string
    {
        $classParts = explode('\\', $this->className);
        return end($classParts);
    }

    /**
     * Magic method __toString, String converstion
     *
     * @return string
     * @throws InvalidArgumentException
     * @throws PcreException
     * @throws LogicException
     */
    public function __toString()
    {
        return $this->getJson();
    }

    /**
     * Returns the result as array
     *
     * @return array
     * @throws InvalidArgumentException
     * @throws PcreException
     * @throws LogicException
     */
    public function getArray(): array
    {
        $reflection = new ReflectionClass($this->className);
        $classDocComment = $reflection->getDocComment();
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC); // Only public methods
        $docBlockFactory = DocBlockFactory::createInstance();
        $result = [];

        if ($classDocComment !== false) {
            $classDocBlock = $docBlockFactory->create($classDocComment);
            $result['class'] = [
                'summary' => $classDocBlock->getSummary() ?: '',
                'description' => (string)$classDocBlock->getDescription() ?: ''
            ];
        } else {
            $result['class'] = [
                'summary' => '',
                'description' => ''
            ];
        }

        foreach ($methods as $method) {
            $docComment = $method->getDocComment();
            $parameters = [];
            $returnDetails = [
                'type' => 'void',
                'description' => ''
            ];
            $methodDetails = [
                'summary' => '',
                'description' => '',
                'static' => false,
                'abstract' => false,
                'final' => false,
                'hasadditional' => false,
            ];

            if ($docComment !== false) {
                $docBlock = $docBlockFactory->create($docComment);

                // Extract summary and description
                $methodDetails['summary'] = $docBlock->getSummary() ?: 'No summary available.';
                $methodDetails['description'] = (string)$docBlock->getDescription() ?: '';
                $methodDetails['static'] = $method->isStatic();
                $methodDetails['abstract'] = $method->isAbstract();
                $methodDetails['final'] = $method->isFinal();
                $methodDetails['hasadditional'] = $method->isStatic() || $method->isAbstract() || $method->isFinal();

                // Parse @param tags
                $paramDescriptions = [];
                foreach ($docBlock->getTagsByName('param') as $tag) {
                    if ($tag instanceof Param) {
                        $paramDescriptions[$tag->getVariableName()] = [
                            'type' => (string) $tag->getType(),
                            'description' => (string) $tag->getDescription()
                        ];
                    }
                }

                // Parse @return tag
                $returnTag = $docBlock->getTagsByName('return');
                if (!empty($returnTag) && $returnTag[0] instanceof Return_) {
                    $returnDetails['type'] = (string) $returnTag[0]->getType();
                    $returnDetails['description'] = (string) $returnTag[0]->getDescription();
                }
            }

            // Get method parameters and match them with DocBlock descriptions
            foreach ($method->getParameters() as $parameter) {
                $parameterName = $parameter->getName();
                $parameterType = $parameter->getType();

                $parameters[] = [
                    'name' => $parameterName,
                    'type' => $parameterType ? $parameterType->getName() : 'mixed',
                    'isNullable' => $parameterType && $parameterType->allowsNull(),
                    'defaultValueavailable' => $parameter->isOptional() ? ($parameter->isDefaultValueAvailable() ? true : false) : false,
                    'defaultValue' => $parameter->isOptional() ? ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null) : null,
                    'description' => $paramDescriptions[$parameterName]['description'] ?? ''
                ];
            }

            $result['methods'][$method->getName()] = [
                'methodDetails' => $methodDetails,
                'parameters' => $parameters,
                'return' => $returnDetails
            ];
        }

        return $result;
    }

    /**
     * Returns the result as JSON string
     *
     * @return string
     * @throws InvalidArgumentException
     * @throws PcreException
     * @throws LogicException
     */
    public function getJson(): string
    {
        return json_encode($this->getArray(), JSON_PRETTY_PRINT);
    }

    /**
     * Save Json to file
     *
     * @param string $filename
     * @return void
     * @throws InvalidArgumentException
     */
    public function saveJson(string $filename): void
    {
        file_put_contents($filename, $this->getJson());
    }
}

class MarkDownGenerator
{
    /**
     * Extractor
     *
     * @var ExtractClass
     */
    protected $extractor = null;

    /**
     * The lines for the MD
     *
     * @var string[]
     */
    protected $lines = [];

    /**
     * Constructor
     *
     * @param ExtractClass $extractor
     */
    public function __construct(ExtractClass $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * Generate markdown
     *
     * @return MarkDownGenerator
     */
    public function generateMarkdown(): MarkDownGenerator
    {
        $metaData = $this->extractor->getArray();

        $this->addLineH1($this->extractor->getClassName());

        $phpPrinter = new Printer;
        $phpClass = new ClassType($this->extractor->getClassBasename());

        if (!empty($metaData['class']['summary'])) {
            $this->addLine($metaData['class']['summary'] ?? "")->addEmptyLine();
        }

        if (!empty($metaData['class']['description'])) {
            $this->addLine($metaData['class']['description'] ?? "")->addEmptyLine();
        }

        if (!empty($metaData['methods'])) {
            $this->addLineH2("Methods");
        }

        foreach ($metaData['methods'] as $methodName => $methodData) {
            $this->addLineH3($methodName, $methodData["methodDetails"]["hasadditional"] === false);

            if ($methodData["methodDetails"]["static"] === true) {
                $this->addToLastLine('<span style="color: white; background-color: blue; padding: 0.2em 0.5em; border-radius: 0.2em; font-size: .8rem">``[static]``</span>', " ");
            }

            if ($methodData["methodDetails"]["abstract"] === true) {
                $this->addToLastLine('<span style="color: white; background-color: red; padding: 0.2em 0.5em; border-radius: 0.2em; font-size: .8rem">``[abstract]``</span>', " ");
            }

            if ($methodData["methodDetails"]["final"] === true) {
                $this->addToLastLine('<span style="color: white; background-color: green; padding: 0.2em 0.5em; border-radius: 0.2em; font-size: .8rem">``[final]``</span>', " ");
            }

            if ($methodData["methodDetails"]["hasadditional"] === true) {
                $this->addEmptyLine();
            }

            $this->addLineH4("Summary");

            if (!empty($methodData["methodDetails"]["summary"])) {
                $this->addLine($methodData["methodDetails"]["summary"])->addEmptyLine();
            }

            if (!empty($methodData["methodDetails"]["description"])) {
                $this->addLine($methodData["methodDetails"]["description"])->addEmptyLine();
            }

            $this->addLineH4("Signature");

            $phpMethod = $phpClass->addMethod($methodName);
            $phpMethod->setPublic();
            $phpMethod->setStatic($methodData["methodDetails"]["static"] === true);
            $phpMethod->setAbstract($methodData["methodDetails"]["abstract"] === true);
            $phpMethod->setFinal($methodData["methodDetails"]["final"] === true);
            $phpMethod->setReturnType($methodData["return"]["type"]);
            $phpMethod->setBody(null);

            foreach ($methodData["parameters"] as $parameter) {
                $phpParameter = $phpMethod
                    ->addParameter($parameter["name"])
                    ->setType($parameter["type"])
                    ->setNullable($parameter["isNullable"]);

                if ($parameter['defaultValueavailable'] === true) {
                    $phpParameter->setDefaultValue($parameter["defaultValue"]);
                }
            }

            $this->addLineRaw("```php");
            $this->addLineRaw($phpPrinter->printMethod($phpMethod));
            $this->addLineRaw("```");

            if (!empty($methodData["parameters"])) {
                $this->addLineH4("Parameters");
                $this->addLine("| Name | Type | Allows Null | Description");
                $this->addLine("| :------ | :------ | :-----: | :------");

                foreach ($methodData["parameters"] as $parameter) {
                    $this->addLine(
                        "| %s | %s | %s | %s",
                        $parameter["name"],
                        $parameter["type"],
                        $this->boolToMarkDown($parameter["isNullable"] ? "Yes" : "No"),
                        $parameter["description"] ?? "",
                    );
                }

                $this->addEmptyLine();
            } else {
                $this->addEmptyLine();
            }
        }

        return $this;
    }

    /**
     * Save MD to file
     *
     * @param string $filename
     * @return MarkDownGenerator
     */
    public function saveToFile(string $filename): MarkDownGenerator
    {
        file_put_contents($filename, implode(PHP_EOL, $this->lines));

        return $this;
    }

    /**
     * Add a line to internal container
     *
     * @param string $string
     * @param mixed ...$args
     * @return MarkDownGenerator
     */
    private function addLine(string $string, ...$args): MarkDownGenerator
    {
        if (StringUtils::stringIsNullOrEmpty($string)) {
            return $this;
        }

        $this->lines[] = $this->sanatizeString(sprintf($string, ...$args));

        return $this;
    }

    /**
     * Add a line to internal container
     *
     * @param string $string
     * @param mixed ...$args
     * @return MarkDownGenerator
     */
    private function addLineRaw(string $string, ...$args): MarkDownGenerator
    {
        if (StringUtils::stringIsNullOrEmpty($string)) {
            return $this;
        }

        $this->lines[] = sprintf($string, ...$args);

        return $this;
    }

    /**
     * Add an empty line to internal container
     *
     * @return MarkDownGenerator
     */
    private function addEmptyLine(): MarkDownGenerator
    {
        $this->lines[] = "";

        return $this;
    }

    /**
     * Add an H1-Line to internal container
     *
     * @param string $string
     * @param boolean $newLine
     * @return MarkDownGenerator
     */
    private function addLineH1(string $string, bool $newLine = true): MarkDownGenerator
    {
        $this->addLine("# %s", $string);

        if ($newLine) {
            $this->addEmptyLine();
        }

        return $this;
    }

    /**
     * Add an H2-Line to internal container
     *
     * @param string $string
     * @param boolean $newLine
     * @return MarkDownGenerator
     */
    private function addLineH2(string $string, bool $newLine = true): MarkDownGenerator
    {
        $this->addLine("## %s", $string);

        if ($newLine) {
            $this->addEmptyLine();
        }

        return $this;
    }

    /**
     * Add an H3-Line to internal container
     *
     * @param string $string
     * @param boolean $newLine
     * @return MarkDownGenerator
     */
    private function addLineH3(string $string, bool $newLine = true): MarkDownGenerator
    {
        $this->addLine("### %s", $string);

        if ($newLine) {
            $this->addEmptyLine();
        }

        return $this;
    }

    /**
     * Add an H4-Line to internal container
     *
     * @param string $string
     * @param boolean $newLine
     * @return MarkDownGenerator
     */
    private function addLineH4(string $string, bool $newLine = true): MarkDownGenerator
    {
        $this->addLine("#### %s", $string);

        if ($newLine) {
            $this->addEmptyLine();
        }

        return $this;
    }

    /**
     * Add a string to the latest line which was added
     *
     * @param string $string
     * @param string $delimiter
     * @param mixed ...$args
     * @return MarkDownGenerator
     */
    public function addToLastLine(string $string, string $delimiter = "", ...$args): MarkDownGenerator
    {
        if (empty($this->lines)) {
            return $this->addLine($string, ...$args);
        }

        $lastIndex = count($this->lines) - 1;
        $this->lines[$lastIndex] = $this->lines[$lastIndex] . $delimiter . sprintf($string, ...$args);

        return $this;
    }

    /**
     * Add a string to the latest line which was added (before)
     *
     * @param string $string
     * @param string $delimiter
     * @param mixed ...$args
     * @return MarkDownGenerator
     */
    public function addToLastLineBefore(string $string, string $delimiter = "", ...$args): MarkDownGenerator
    {
        if (empty($this->lines)) {
            return $this->addLine($string, ...$args);
        }

        $lastIndex = count($this->lines) - 1;
        $this->lines[$lastIndex] = sprintf($string, ...$args) . $delimiter . $this->lines[$lastIndex];

        return $this;
    }

    /**
     * Sanatize a string
     *
     * @param string $string
     * @return string
     */
    private function sanatizeString(string $string): string
    {
        $string = str_replace("\n", "<br/>", $string);
        $string = str_replace("__BT-, From __", "", $string);
        $string = str_replace("__BT-, From", "__BT-??, From", $string);
        $string = trim($string);

        return $string;
    }

    /**
     * Convert yes/no to markdown markup
     *
     * @param string $boolText
     * @return string
     */
    private function boolToMarkDown(string $boolText): string
    {
        return strcasecmp($boolText, "no") === 0 ? ":x:" : ":heavy_check_mark:";
    }
}

class BatchMarkDownGenerator
{
    /**
     * Start a batch documentation creation
     *
     * @param array $classes
     * @return void
     * @throws InvalidArgumentException
     * @throws PcreException
     * @throws LogicException
     */
    public static function generate(array $classes)
    {
        foreach ($classes as $className => $toFilename) {
            $extractor = new ExtractClass($className);
            $generator = new MarkDownGenerator($extractor);
            $generator->generateMarkdown();
            $generator->saveToFile($toFilename);
        }
    }
}

BatchMarkDownGenerator::generate([
    ZugferdDocument::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocument.md',
    ZugferdSettings::class => dirname(__FILE__) . '/ClassOverview-ZugferdSettings.md',
    ZugferdDocumentBuilder::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocumentBuilder.md',
    ZugferdDocumentReader::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocumentReader.md',
    ZugferdDocumentPdfReader::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocumentPdfReader.md',
    ZugferdDocumentPdfBuilder::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocumentPdfBuilder.md',
    ZugferdDocumentPdfMerger::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocumentPdfMerger.md',
    ZugferdDocumentValidator::class => dirname(__FILE__) . '/ClassOverview-ZugferdDocumentValidator.md',
    ZugferdXsdValidator::class => dirname(__FILE__) . '/ClassOverview-ZugferdXsdValidator.md',
    ZugferdKositValidator::class => dirname(__FILE__) . '/ClassOverview-ZugferdKositValidator.md',
]);
