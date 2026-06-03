<?php

namespace horstoeko\zugferd\tests\testcases;

use DateTime;
use DateTimeImmutable;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdObjectHelper;

class BugfixRegressionTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../assets/xml_xrechnung_1.xml');
    }

    /**
     * Regression: getDocumentRoutingId must write the value back by reference.
     */
    public function testGetDocumentRoutingIdPassByReference(): void
    {
        self::$document->getDocumentRoutingId($routingId);

        $this->assertSame('04011000-12345-34', $routingId);
    }

    /**
     * Regression: isAllNullOrEmpty must recognise DateTimeImmutable as non-empty.
     */
    public function testIsAllNullOrEmptyWithDateTimeImmutable(): void
    {
        $this->assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([new DateTimeImmutable()]));
    }

    /**
     * Regression: isAllNullOrEmpty must still recognise DateTime as non-empty.
     */
    public function testIsAllNullOrEmptyWithDateTime(): void
    {
        $this->assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([new DateTime()]));
    }

    /**
     * isAllNullOrEmpty must return true when all values are null or empty.
     */
    public function testIsAllNullOrEmptyWithNullAndEmptyValues(): void
    {
        $this->assertTrue(ZugferdObjectHelper::isAllNullOrEmpty([null, '']));
    }

    /**
     * Regression: isOneNullOrEmpty must handle DateTimeImmutable without treating it as null.
     */
    public function testIsOneNullOrEmptyWithDateTimeImmutable(): void
    {
        $this->assertFalse(ZugferdObjectHelper::isOneNullOrEmpty([new DateTimeImmutable(), 'value']));
    }

    /**
     * Regression: isOneNullOrEmpty must still handle DateTime properly.
     */
    public function testIsOneNullOrEmptyWithDateTime(): void
    {
        $this->assertFalse(ZugferdObjectHelper::isOneNullOrEmpty([new DateTime(), 'value']));
    }

    /**
     * isOneNullOrEmpty must return true when at least one value is null or empty.
     */
    public function testIsOneNullOrEmptyWithMixedValues(): void
    {
        $this->assertTrue(ZugferdObjectHelper::isOneNullOrEmpty([new DateTime(), '']));
    }
}
