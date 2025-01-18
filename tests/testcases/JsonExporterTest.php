<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentJsonExporter;
use horstoeko\zugferd\ZugferdDocumentReader;

class JsonExporterTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . "/../assets/xml_xrechnung_2.xml");
    }

    public function testToJsonString(): void
    {
        $exporter = new ZugferdDocumentJsonExporter(static::$document);
        $jsonString = $exporter->toJsonString();

        $this->assertStringStartsWith('{"ExchangedDocumentContext"', $jsonString);
        $this->assertStringContainsString('{"GuidelineSpecifiedDocumentContextParameter"', $jsonString);
    }

    public function testToPrettyJsonString(): void
    {
        $exporter = new ZugferdDocumentJsonExporter(static::$document);
        $jsonString = $exporter->toPrettyJsonString();

        $this->assertStringStartsWith("{\n    \"ExchangedDocumentContext\": {\n        \"GuidelineSpecifiedDocumentContextParameter\": {", $jsonString);
    }

    public function testToJsonObject(): void
    {
        $exporter = new ZugferdDocumentJsonExporter(static::$document);
        $jsonObject = $exporter->toJsonObject();

        $this->assertInstanceOf("stdClass", $jsonObject);
        $this->assertTrue(isset($jsonObject->ExchangedDocumentContext));
        $this->assertTrue(isset($jsonObject->ExchangedDocumentContext->GuidelineSpecifiedDocumentContextParameter));
    }
}
