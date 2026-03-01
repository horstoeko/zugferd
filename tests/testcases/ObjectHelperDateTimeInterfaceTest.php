<?php

namespace horstoeko\zugferd\tests\testcases;

use DateTime;
use DateTimeImmutable;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdObjectHelper;
use horstoeko\zugferd\ZugferdProfiles;

/**
 * Tests for DateTimeInterface support in ZugferdObjectHelper,
 * including isAllNullOrEmpty/isOneNullOrEmpty and date formatting methods.
 */
class ObjectHelperDateTimeInterfaceTest extends TestCase
{
    /**
     * @var ZugferdObjectHelper
     */
    protected static $objectHelper;

    public static function setUpBeforeClass(): void
    {
        self::$objectHelper = new ZugferdObjectHelper(ZugferdProfiles::PROFILE_EXTENDED);
    }

    // =========================================================================
    // isAllNullOrEmpty tests
    // =========================================================================

    public function testIsAllNullOrEmptyWithNull(): void
    {
        self::assertTrue(ZugferdObjectHelper::isAllNullOrEmpty([null]));
    }

    public function testIsAllNullOrEmptyWithEmptyString(): void
    {
        self::assertTrue(ZugferdObjectHelper::isAllNullOrEmpty([""]));
    }

    public function testIsAllNullOrEmptyWithMultipleNulls(): void
    {
        self::assertTrue(ZugferdObjectHelper::isAllNullOrEmpty([null, null, ""]));
    }

    public function testIsAllNullOrEmptyWithDateTime(): void
    {
        self::assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([new DateTime()]));
    }

    public function testIsAllNullOrEmptyWithDateTimeImmutable(): void
    {
        self::assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([new DateTimeImmutable()]));
    }

    public function testIsAllNullOrEmptyWithMixedNullAndDateTime(): void
    {
        self::assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([null, new DateTime()]));
    }

    public function testIsAllNullOrEmptyWithMixedNullAndDateTimeImmutable(): void
    {
        self::assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([null, new DateTimeImmutable()]));
    }

    public function testIsAllNullOrEmptyWithNonEmptyString(): void
    {
        self::assertFalse(ZugferdObjectHelper::isAllNullOrEmpty(["abc"]));
    }

    public function testIsAllNullOrEmptyWithZero(): void
    {
        self::assertFalse(ZugferdObjectHelper::isAllNullOrEmpty([0]));
    }

    public function testIsAllNullOrEmptyWithEmptyArray(): void
    {
        self::assertTrue(ZugferdObjectHelper::isAllNullOrEmpty([]));
    }

    // =========================================================================
    // isOneNullOrEmpty tests
    // =========================================================================

    public function testIsOneNullOrEmptyWithAllValues(): void
    {
        self::assertFalse(ZugferdObjectHelper::isOneNullOrEmpty(["abc", "def"]));
    }

    public function testIsOneNullOrEmptyWithOneNull(): void
    {
        self::assertTrue(ZugferdObjectHelper::isOneNullOrEmpty(["abc", null]));
    }

    public function testIsOneNullOrEmptyWithOneEmpty(): void
    {
        self::assertTrue(ZugferdObjectHelper::isOneNullOrEmpty(["abc", ""]));
    }

    public function testIsOneNullOrEmptyWithDateTime(): void
    {
        self::assertFalse(ZugferdObjectHelper::isOneNullOrEmpty([new DateTime(), "abc"]));
    }

    public function testIsOneNullOrEmptyWithDateTimeImmutable(): void
    {
        self::assertFalse(ZugferdObjectHelper::isOneNullOrEmpty([new DateTimeImmutable(), "abc"]));
    }

    public function testIsOneNullOrEmptyWithDateTimeAndNull(): void
    {
        self::assertTrue(ZugferdObjectHelper::isOneNullOrEmpty([new DateTime(), null]));
    }

    public function testIsOneNullOrEmptyWithDateTimeImmutableAndNull(): void
    {
        self::assertTrue(ZugferdObjectHelper::isOneNullOrEmpty([new DateTimeImmutable(), null]));
    }

    // =========================================================================
    // getFormattedDateTimeType with DateTimeImmutable
    // =========================================================================

    public function testGetFormattedDateTimeTypeWithDateTimeImmutable(): void
    {
        $dateTime = new DateTimeImmutable("2025-06-15");
        $result = self::$objectHelper->getFormattedDateTimeType($dateTime);
        $this->assertNotNull($result);
    }

    public function testGetFormattedDateTimeTypeWithNull(): void
    {
        $result = self::$objectHelper->getFormattedDateTimeType(null);
        $this->assertNull($result);
    }

    public function testGetFormattedDateTimeTypeWithDateTime(): void
    {
        $dateTime = new DateTime("2025-06-15");
        $result = self::$objectHelper->getFormattedDateTimeType($dateTime);
        $this->assertNotNull($result);
    }

    // =========================================================================
    // getDateTimeType with DateTimeImmutable
    // =========================================================================

    public function testGetDateTimeTypeWithDateTimeImmutable(): void
    {
        $dateTime = new DateTimeImmutable("2025-03-20");
        $result = self::$objectHelper->getDateTimeType($dateTime);
        $this->assertNotNull($result);
    }

    public function testGetDateTimeTypeWithNull(): void
    {
        $result = self::$objectHelper->getDateTimeType(null);
        $this->assertNull($result);
    }

    // =========================================================================
    // getDateType with DateTimeImmutable
    // =========================================================================

    public function testGetDateTypeWithDateTimeImmutable(): void
    {
        $dateTime = new DateTimeImmutable("2025-09-30");
        $result = self::$objectHelper->getDateType($dateTime);
        $this->assertNotNull($result);
    }

    public function testGetDateTypeWithNull(): void
    {
        $result = self::$objectHelper->getDateType(null);
        $this->assertNull($result);
    }

    // =========================================================================
    // Round-trip: Builder with DateTimeImmutable, Reader gets correct date
    // =========================================================================

    public function testBuilderReaderRoundTripWithDateTimeImmutable(): void
    {
        $builder = \horstoeko\zugferd\ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_EXTENDED);
        $builder
            ->setDocumentInformation("IMM-001", "380", new DateTimeImmutable("2025-07-04"), "EUR")
            ->setDocumentSeller("Seller")
            ->addDocumentSellerTaxRegistration("VA", "DE123456789")
            ->setDocumentSellerAddress("Street", null, null, "12345", "City", "DE")
            ->setDocumentBuyer("Buyer")
            ->setDocumentBuyerAddress("Street", null, null, "12345", "City", "DE")
            ->addDocumentTax("S", "VAT", 100.00, 19.00, 19.00)
            ->setDocumentSummation(119.00, 119.00, 100.00, 0.00, 0.00, 100.00, 19.00)
            ->setDocumentSupplyChainEvent(new DateTimeImmutable("2025-07-10"))
            ->addNewPosition("1")
            ->setDocumentPositionProductDetails("Product")
            ->setDocumentPositionNetPrice(100.00)
            ->setDocumentPositionQuantity(1.00, "C62")
            ->addDocumentPositionTax("S", "VAT", 19.00)
            ->setDocumentPositionLineSummation(100.00);

        $xml = $builder->getContent();
        $reader = \horstoeko\zugferd\ZugferdDocumentReader::readAndGuessFromContent($xml);

        $reader->getDocumentSupplyChainEvent($date);
        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertEquals("20250710", $date->format("Ymd"));
    }
}
