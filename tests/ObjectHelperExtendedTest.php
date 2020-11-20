<?php

namespace horstoeko\zugferd\tests;

use \PHPUnit\Framework\TestCase;
use \horstoeko\zugferd\ZugferdProfiles;
use \horstoeko\zugferd\ZugferdObjectHelper;
use \horstoeko\zugferd\exception\ZugferdUnknownDateFormat;

class ObjectHelperExtendedTest extends TestCase
{
    /**
     * @var ZugferdObjectHelper
     */
    protected static $objectHelper;

    public static function setUpBeforeClass(): void
    {
        self::$objectHelper = new ZugferdObjectHelper(ZugferdProfiles::PROFILE_EXTENDED);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("abc");
        $this->assertEquals("abc", $idtype->value());
        $this->assertEquals("", $idtype->getSchemeID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeWithValueAndScheme()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("abc", "0088");
        $this->assertEquals("abc", $idtype->value());
        $this->assertEquals("0088", $idtype->getSchemeID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeAllEmpty()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("", "");
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType(null, null);
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeEmptyValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("");
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType(null);
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIdType
     */
    public function testGetIdTypeEmptyValueWithScheme()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("", "0088");
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTextType
     */
    public function testGetTextTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getTextType("test");
        $this->assertEquals("test", $texttype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTextType
     */
    public function testGetTextTypeAllEmpty()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getTextType("");
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTextType
     */
    public function testGetTextTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getTextType(null);
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCodeType
     */
    public function testGetCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getCodeType("test");
        $this->assertEquals("test", $texttype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCodeType
     */
    public function testGetCodeTypeAllEmpty()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getCodeType("");
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCodeType
     */
    public function testGetCodeTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getCodeType(null);
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIndicatorType
     */
    public function testGetIndicatorTypeWithTrueValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->getIndicatorType(true);
        $this->assertTrue($indicatortype->getIndicator());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIndicatorType
     */
    public function testGetIndicatorTypeWithFalseValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->getIndicatorType(false);
        $this->assertNotNull($indicatortype);
        $this->assertEquals(false, $indicatortype->getIndicator());

        $indicatortype = self::$objectHelper->getIndicatorType(true);
        $this->assertNotNull($indicatortype);
        $this->assertEquals(true, $indicatortype->getIndicator());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getIndicatorType
     */
    public function testGetIndicatorTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->getIndicatorType(null);
        $this->assertNull($indicatortype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getNoteType
     */
    public function testGetNoteTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType("content", "contentcode", "subjectcode");
        $this->assertEquals("content", $notetype->getContent());
        $this->assertEquals("subjectcode", $notetype->getSubjectCode()->value());
        $this->assertEquals("contentcode", $notetype->getContentCode()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getNoteType
     */
    public function testGetNoteTypeAllNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType(null, null, null);
        $this->assertNull($notetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getNoteType
     */
    public function testGetNoteTypeWithEmptyContent()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType("", "", "");
        $this->assertNull($notetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getNoteType
     */
    public function testGetNoteTypeWithEmptyContentButWithSubjectCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType("", "", "subjectcode");
        $this->assertNull($notetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getFormattedDateTimeType
     */
    public function testGetFormattedDateTimeType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
         */
        $datetimetype = self::$objectHelper->getFormattedDateTimeType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateTimeString());
        $this->assertEquals("102", $datetimetype->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getFormattedDateTimeType
     */
    public function testGetFormattedDateTimeTypeWithNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
         */
        $datetimetype = self::$objectHelper->getFormattedDateTimeType(null);
        $this->assertNull($datetimetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDateTimeType
     */
    public function testGetDateTimeType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType
         */
        $datetimetype = self::$objectHelper->getDateTimeType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateTimeString());
        $this->assertEquals("102", $datetimetype->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDateTimeType
     */
    public function testGetDateTimeTypeWithNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType
         */
        $datetimetype = self::$objectHelper->getDateTimeType(null);
        $this->assertNull($datetimetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDateType
     */
    public function testGetDateType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateType
         */
        $datetimetype = self::$objectHelper->getDateType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateString());
        $this->assertEquals("102", $datetimetype->getDateString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDateType
     */
    public function testGetDateTypeWithNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateType
         */
        $datetimetype = self::$objectHelper->getDateType(null);
        $this->assertNull($datetimetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getAmountType
     */
    public function testGetAmountTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(100.0);
        $this->assertEquals(100.0, $amounttype->value());
        $this->assertEquals("", $amounttype->getCurrencyID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getAmountType
     */
    public function testGetAmountTypeWithValueAndCurrency()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(100.0, "EUR");
        $this->assertEquals(100.0, $amounttype->value());
        $this->assertEquals("EUR", $amounttype->getCurrencyID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getAmountType
     */
    public function testGetAmountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(null, null);
        $this->assertNull($amounttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getAmountType
     */
    public function testGetAmountTypeWithValueAndEmptyCurrency()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(100, "");
        $this->assertEquals(100.0, $amounttype->value());
        $this->assertEquals("", $amounttype->getCurrencyID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getAmountType
     */
    public function testGetAmountTypeWithNullValueAndCurrency()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(null, "EUR");
        $this->assertNull($amounttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getPercentType
     */
    public function testGetPercentTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $percenttype = self::$objectHelper->getPercentType(100.0);
        $this->assertEquals(100.0, $percenttype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getPercentType
     */
    public function testGetPercentTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $percenttype = self::$objectHelper->getPercentType(null);
        $this->assertNull($percenttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getQuantityType
     */
    public function testGetQuantityTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(100.0);
        $this->assertEquals(100.0, $quantitytype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getQuantityType
     */
    public function testGetQuantityTypeWithValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(100.0, "C62");
        $this->assertEquals(100.0, $quantitytype->value());
        $this->assertEquals("C62", $quantitytype->getUnitCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getQuantityType
     */
    public function testGetQuantityTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(null, null);
        $this->assertNull($quantitytype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getQuantityType
     */
    public function testGetQuantityTypeWithNullValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(null, "C62");
        $this->assertNull($quantitytype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getMeasureType
     */
    public function testGetMeasureTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(100.0);
        $this->assertEquals(100.0, $measuretype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getMeasureType
     */
    public function testGetMeasureTypeWithValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(100.0, "DAY");
        $this->assertEquals(100.0, $measuretype->value());
        $this->assertEquals("DAY", $measuretype->getUnitCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getMeasureType
     */
    public function testGetMeasureTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(null, null);
        $this->assertNull($measuretype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getMeasureType
     */
    public function testGetMeasureTypeWithNullValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(null, "DAY");
        $this->assertNull($measuretype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getNumericType
     */
    public function testGetNumericTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $numerictype = self::$objectHelper->getNumericType(100.0);
        $this->assertEquals(100, $numerictype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getNumericType
     */
    public function testGetNumericTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $numerictype = self::$objectHelper->getNumericType(null);
        $this->assertNull($numerictype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxCategoryCodeType
     */
    public function testGetTaxCategoryCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxCategoryCodeType
         */
        $taxcategorycodetype = self::$objectHelper->getTaxCategoryCodeType("VAT");
        $this->assertEquals("VAT", $taxcategorycodetype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxCategoryCodeType
     */
    public function testGetTaxCategoryCodeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxCategoryCodeType
         */
        $taxcategorycodetype = self::$objectHelper->getTaxCategoryCodeType(null);
        $this->assertNull($taxcategorycodetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxTypeCodeType
     */
    public function testGetTaxTypeCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->getTaxTypeCodeType("S");
        $this->assertEquals("S", $taxtypecodetype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxTypeCodeType
     */
    public function testGetTaxTypeCodeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->getTaxTypeCodeType(null);
        $this->assertNull($taxtypecodetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTimeReferenceCodeType
     */
    public function testGetTimeReferenceCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TimeReferenceCodeType
         */
        $timereferencecodetype = self::$objectHelper->getTimeReferenceCodeType("REF");
        $this->assertEquals("REF", $timereferencecodetype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTimeReferenceCodeType
     */
    public function testGetTimeReferenceCodeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TimeReferenceCodeType
         */
        $timereferencecodetype = self::$objectHelper->getTimeReferenceCodeType(null);
        $this->assertNull($timereferencecodetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getSpecifiedPeriodType
     */
    public function testGetSpecifiedPeriodTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType
         */
        $periodtype = self::$objectHelper->getSpecifiedPeriodType(new \DateTime(), new \DateTime(), new \DateTime(), "Description");
        $this->assertEquals("Description", $periodtype->getDescription());
        $this->assertEquals((new \DateTime())->format("Ymd"), $periodtype->getCompleteDateTime()->getDateTimeString());
        $this->assertEquals("102", $periodtype->getCompleteDateTime()->getDateTimeString()->getFormat());
        $this->assertEquals((new \DateTime())->format("Ymd"), $periodtype->getStartDateTime()->getDateTimeString());
        $this->assertEquals("102", $periodtype->getStartDateTime()->getDateTimeString()->getFormat());
        $this->assertEquals((new \DateTime())->format("Ymd"), $periodtype->getEndDateTime()->getDateTimeString());
        $this->assertEquals("102", $periodtype->getEndDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getSpecifiedPeriodType
     */
    public function testGetSpecifiedPeriodTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType
         */
        $periodtype = self::$objectHelper->getSpecifiedPeriodType(null, null, null, null);
        $this->assertNull($periodtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getBinaryObjectType
     */
    public function testGetBinaryObjectTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType("data", "application/pdf", "mypdf.pdf");
        $this->assertEquals("data", $binaryobject->value());
        $this->assertEquals("application/pdf", $binaryobject->getMimeCode());
        $this->assertEquals("mypdf.pdf", $binaryobject->getFilename());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getBinaryObjectType
     */
    public function testGetBinaryObjectTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType(null, null, null);
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getBinaryObjectType
     */
    public function testGetBinaryObjectTypeDataNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType(null, "application/pdf", "mypdf.pdf");
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getBinaryObjectType
     */
    public function testGetBinaryObjectTypeMimeTypeNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType("data", null, "mypdf.pdf");
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getBinaryObjectType
     */
    public function testGetBinaryObjectTypeFilenameNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType("data", "application/pdf", null);
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getReferencedDocumentType
     */
    public function testGetReferencedDocumentTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
         */
        $refdoctype = self::$objectHelper->getReferencedDocumentType("issuerid", "uriid", "lineid", "typecode", "name", "reftypcode", new \DateTime(), dirname(__FILE__) . "/data/en16931_allowancecharge.xml");
        $this->assertEquals("issuerid", $refdoctype->getIssuerAssignedID()->value());
        $this->assertEquals("uriid", $refdoctype->getURIID()->value());
        $this->assertEquals("lineid", $refdoctype->getLineID()->value());
        $this->assertEquals("typecode", $refdoctype->getTypeCode());
        $this->assertIsArray($refdoctype->getName());
        $this->assertArrayHasKey(0, $refdoctype->getName());
        $this->assertEquals("name", $refdoctype->getName()[0]);
        $this->assertEquals("reftypcode", $refdoctype->getReferenceTypeCode());
        $this->assertEquals((new \DateTime())->format("Ymd"), $refdoctype->getFormattedIssueDateTime()->getDateTimeString());
        $this->assertEquals("102", $refdoctype->getFormattedIssueDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getReferencedDocumentType
     */
    public function testGetReferencedDocumentTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
         */
        $refdoctype = self::$objectHelper->getReferencedDocumentType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($refdoctype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCrossIndustryInvoice
     */
    public function testCrossIndustryInvoice()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice
         */
        $crossindusty = self::$objectHelper->getCrossIndustryInvoice();
        $this->assertNotNull($crossindusty);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeParty
     */
    public function testGetTradePartyAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->getTradeParty("name", "id", "description");
        $this->assertEquals("name", $tradeparty->getName());
        $this->assertIsArray($tradeparty->getID());
        $this->assertArrayHasKey(0, $tradeparty->getID());
        $this->assertEquals("id", $tradeparty->getID()[0]);
        $this->assertEquals("description", $tradeparty->getDescription());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeParty
     */
    public function testGetTradePartyNullValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->getTradeParty(null, null, null);
        $this->assertNull($tradeparty);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeAddress
     */
    public function testGetTradeAddressAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAddressType
         */
        $tradeaddress = self::$objectHelper->getTradeAddress("lineone", "linetwo", "linethree", "00000", "city", "country", "county");
        $this->assertEquals("lineone", $tradeaddress->getLineOne());
        $this->assertEquals("linetwo", $tradeaddress->getLineTwo());
        $this->assertEquals("linethree", $tradeaddress->getLineThree());
        $this->assertEquals("00000", $tradeaddress->getPostcodeCode());
        $this->assertEquals("city", $tradeaddress->getCityName());
        $this->assertEquals("country", $tradeaddress->getCountryID());
        $this->assertIsArray($tradeaddress->getCountrySubDivisionName());
        $this->assertArrayHasKey(0, $tradeaddress->getCountrySubDivisionName());
        $this->assertEquals("county", $tradeaddress->getCountrySubDivisionName()[0]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeAddress
     */
    public function testGetTradeAddressAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAddressType
         */
        $tradeaddress = self::$objectHelper->getTradeAddress(null, null, null, null, null, null, null);
        $this->assertNull($tradeaddress);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getLegalOrganization
     */
    public function testGetLegalOrganizationAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LegalOrganizationType
         */
        $legalorg = self::$objectHelper->getLegalOrganization("orgid", "orgtype", "orgname");
        $this->assertEquals("orgid", $legalorg->getID());
        $this->assertEquals("orgtype", $legalorg->getID()->getSchemeID());
        $this->assertEquals("orgname", $legalorg->getTradingBusinessName());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getLegalOrganization
     */
    public function testGetLegalOrganizationAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LegalOrganizationType
         */
        $legalorg = self::$objectHelper->getLegalOrganization(null, null, null);
        $this->assertNull($legalorg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeContact
     */
    public function testGetTradeContactAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeContactType
         */
        $tradecontact = self::$objectHelper->getTradeContact("personname", "departmentname", "phone", "fax", "mail");
        $this->assertEquals("personname", $tradecontact->getPersonName());
        $this->assertEquals("departmentname", $tradecontact->getDepartmentName());
        $this->assertEquals("phone", $tradecontact->getTelephoneUniversalCommunication()->getCompleteNumber());
        $this->assertEquals("fax", $tradecontact->getFaxUniversalCommunication()->getCompleteNumber());
        $this->assertEquals("mail", $tradecontact->getEmailURIUniversalCommunication()->getURIID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeContact
     */
    public function testGetTradeContactAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeContactType
         */
        $tradecontact = self::$objectHelper->getTradeContact(null, null, null, null, null, null);
        $this->assertNull($tradecontact);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getUniversalCommunicationType
     */
    public function testGetUniversalCommunicationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType
         */
        $commtype = self::$objectHelper->getUniversalCommunicationType("number", "uriid", "smtp");
        $this->assertEquals("number", $commtype->getCompleteNumber());
        $this->assertEquals("uriid", $commtype->getURIID());
        $this->assertEquals("smtp", $commtype->getURIID()->getSchemeID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getUniversalCommunicationType
     */
    public function testGetUniversalCommunicationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType
         */
        $commtype = self::$objectHelper->getUniversalCommunicationType(null, null, null);
        $this->assertNull($commtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType("taxregtype", "taxid");
        $this->assertEquals("taxregtype", $taxregtype->getID()->getSchemeID());
        $this->assertEquals("taxid", $taxregtype->getID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType(null, null);
        $this->assertNull($taxregtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeIdNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType("taxregtype", null);
        $this->assertNull($taxregtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeTypeNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType(null, "taxid");
        $this->assertNull($taxregtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeDeliveryTermsType
     */
    public function testGetTradeDeliveryTermsTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType
         */
        $devterms = self::$objectHelper->getTradeDeliveryTermsType('code');
        $this->assertEquals("code", $devterms->getDeliveryTypeCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeDeliveryTermsType
     */
    public function testGetTradeDeliveryTermsTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType
         */
        $devterms = self::$objectHelper->getTradeDeliveryTermsType(null);
        $this->assertNull($devterms);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getProcuringProjectType
     */
    public function testGetProcuringProjectTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType("projectid", "projectname");
        $this->assertEquals("projectid", $project->getID());
        $this->assertEquals("projectname", $project->getName());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getProcuringProjectType
     */
    public function testGetProcuringProjectTypeIdNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType(null, "projectname");
        $this->assertNull($project);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getProcuringProjectType
     */
    public function testGetProcuringProjectTypeNameNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType("projectid", null);
        $this->assertNull($project);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getProcuringProjectType
     */
    public function testGetProcuringProjectTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType(null, null);
        $this->assertNull($project);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getSupplyChainEventType
     */
    public function testGetSupplyChainEventTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType
         */
        $supplychainevent = self::$objectHelper->getSupplyChainEventType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $supplychainevent->getOccurrenceDateTime()->getDateTimeString());
        $this->assertEquals("102", $supplychainevent->getOccurrenceDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getSupplyChainEventType
     */
    public function testGetSupplyChainEventTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType
         */
        $supplychainevent = self::$objectHelper->getSupplyChainEventType(null);
        $this->assertNull($supplychainevent);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementFinancialCardType
     */
    public function testGetTradeSettlementFinancialCardTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType
         */
        $fincard = self::$objectHelper->getTradeSettlementFinancialCardType("type", "id", "name");
        $this->assertEquals("type", $fincard->getID()->getSchemeID());
        $this->assertEquals("id", $fincard->getID());
        $this->assertEquals("name", $fincard->getCardholderName());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementFinancialCardType
     */
    public function testGetTradeSettlementFinancialCardTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType
         */
        $fincard = self::$objectHelper->getTradeSettlementFinancialCardType(null, null, null);
        $this->assertNull($fincard);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDebtorFinancialAccountType
     */
    public function testGetDebtorFinancialAccountTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType
         */
        $finacc = self::$objectHelper->getDebtorFinancialAccountType("iban");
        $this->assertEquals("iban", $finacc->getIBANID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDebtorFinancialAccountType
     */
    public function testGetDebtorFinancialAccountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType
         */
        $finacc = self::$objectHelper->getDebtorFinancialAccountType(null);
        $this->assertNull($finacc);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCreditorFinancialAccountType
     */
    public function testGetCreditorFinancialAccountTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType
         */
        $finacc = self::$objectHelper->getCreditorFinancialAccountType("iban", "accname", "propid");
        $this->assertEquals("iban", $finacc->getIBANID());
        $this->assertEquals("accname", $finacc->getAccountName());
        $this->assertEquals("propid", $finacc->getProprietaryID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCreditorFinancialAccountType
     */
    public function testGetCreditorFinancialAccountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType
         */
        $finacc = self::$objectHelper->getCreditorFinancialAccountType(null, null, null);
        $this->assertNull($finacc);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCreditorFinancialInstitutionType
     */
    public function testGetCreditorFinancialInstitutionTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType
         */
        $fininst = self::$objectHelper->getCreditorFinancialInstitutionType("bic");
        $this->assertEquals("bic", $fininst->getBICID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getCreditorFinancialInstitutionType
     */
    public function testGetCreditorFinancialInstitutionTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType
         */
        $fininst = self::$objectHelper->getCreditorFinancialInstitutionType(null);
        $this->assertNull($fininst);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementPaymentMeansType
     */
    public function testGetTradeSettlementPaymentMeansTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType
         */
        $paymentmeans = self::$objectHelper->getTradeSettlementPaymentMeansType("code", "info");
        $this->assertEquals("code", $paymentmeans->getTypeCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementPaymentMeansType
     */
    public function testGetTradeSettlementPaymentMeansTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType
         */
        $paymentmeans = self::$objectHelper->getTradeSettlementPaymentMeansType(null, null);
        $this->assertNull($paymentmeans);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradePaymentTermsType
     */
    public function testGetTradePaymentTermsTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentTermsType
         */
        $paymentterms = self::$objectHelper->getTradePaymentTermsType("description", new \DateTime(), "mandate");
        $this->assertEquals((new \DateTime())->format("Ymd"), $paymentterms->getDueDateDateTime()->getDateTimeString());
        $this->assertEquals("102", $paymentterms->getDueDateDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradePaymentTermsType
     */
    public function testGetTradePaymentTermsTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentTermsType
         */
        $paymentmeans = self::$objectHelper->getTradePaymentTermsType(null, null, null);
        $this->assertNull($paymentmeans);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradePaymentDiscountTermsType
     */
    public function testGetTradePaymentDiscountTermsTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType
         */
        $discountterms = self::$objectHelper->getTradePaymentDiscountTermsType(new \DateTime(), 2, "DAY", 1, 1, 1);

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $calculationpercent = $discountterms->getCalculationPercent();

        $this->assertEquals((new \DateTime())->format("Ymd"), $discountterms->getBasisDateTime()->getDateTimeString());
        $this->assertEquals("102", $discountterms->getBasisDateTime()->getDateTimeString()->getFormat());
        $this->assertEquals(2, $discountterms->getBasisPeriodMeasure()->value());
        $this->assertEquals("DAY", $discountterms->getBasisPeriodMeasure()->getUnitCode());
        $this->assertEquals(1, $discountterms->getBasisAmount()->value());
        $this->assertEquals(1, $calculationpercent->value());
        $this->assertEquals(1, $discountterms->getActualDiscountAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradePaymentDiscountTermsType
     */
    public function testGetTradePaymentDiscountTermsTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType
         */
        $discountterms = self::$objectHelper->getTradePaymentDiscountTermsType(null, null, null, null, null, null);
        $this->assertNull($discountterms);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeTaxType
     */
    public function testGetTradeTaxTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType
         */
        $tax = self::$objectHelper->getTradeTaxType("category", "type", 100, 19, 19, "reason", "reasoncode", 100, 10, new \DateTime(), "duedatecode");

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $rateapplicablepercent = $tax->getRateApplicablePercent();

        $this->assertEquals("category", $tax->getCategoryCode());
        $this->assertEquals("type", $tax->getTypeCode());
        $this->assertEquals(100.0, $tax->getBasisAmount()->value());
        $this->assertEquals(19.0, $tax->getCalculatedAmount()->value());
        $this->assertEquals(19.0, $rateapplicablepercent->value());
        $this->assertEquals("reasoncode", $tax->getExemptionReasonCode());
        $this->assertEquals("reason", $tax->getExemptionReason());
        $this->assertEquals(100, $tax->getLineTotalBasisAmount()->value());
        $this->assertEquals(10, $tax->getAllowanceChargeBasisAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeTaxType
     */
    public function testGetTradeTaxTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType
         */
        $tax = self::$objectHelper->getTradeTaxType(null, null, null, null, null, null, null, null, null, null, null);
        $this->assertNull($tax);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeAllowanceChargeType
     */
    public function testGetTradeAllowanceChargeTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAllowanceChargeType
         */
        $allowancecharge = self::$objectHelper->getTradeAllowanceChargeType(10, true, "taxtype", "taxcategory", 19.0, 1, 2.0, 1.0, 1.0, "C62", "reasoncode", "reason");

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $rateapplicablepercent = $allowancecharge->getCategoryTradeTax()->getRateApplicablePercent();

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $calculationpercent = $allowancecharge->getCalculationPercent();

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\GetNumericType
         */
        $sequenceNumeric = $allowancecharge->getCalculationPercent();

        $this->assertEquals(10.0, $allowancecharge->getActualAmount()->value());
        $this->assertTrue($allowancecharge->getChargeIndicator()->getIndicator());
        $this->assertEquals("taxtype", $allowancecharge->getCategoryTradeTax()->getTypeCode());
        $this->assertEquals("taxcategory", $allowancecharge->getCategoryTradeTax()->getCategoryCode());
        $this->assertEquals(19.0, $rateapplicablepercent->value());
        $this->assertEquals(2, $sequenceNumeric->value());
        $this->assertEquals(2.0, $calculationpercent->value());
        $this->assertEquals(1.0, $allowancecharge->getBasisQuantity()->value());
        $this->assertEquals("C62", $allowancecharge->getBasisQuantity()->getUnitCode());
        $this->assertEquals("reason", $allowancecharge->getReason());
        $this->assertEquals("reasoncode", $allowancecharge->getReasonCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeAllowanceChargeType
     */
    public function testGetTradeAllowanceChargeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAllowanceChargeType
         */
        $allowancecharge = self::$objectHelper->getTradeAllowanceChargeType(null, null, null, null, null, null, null, null, null, null, null, null);
        $this->assertNull($allowancecharge);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getLogisticsServiceChargeType
     */
    public function testGetLogisticsServiceChargeTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LogisticsServiceChargeType
         */
        $logcharge = self::$objectHelper->getLogisticsServiceChargeType("description", 10.0, ["taxtype"], ["taxcategpry"], [19]);
        $this->assertEquals("description", $logcharge->getDescription());
        $this->assertEquals(10.0, $logcharge->getAppliedAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getLogisticsServiceChargeType
     */
    public function testGetLogisticsServiceChargeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LogisticsServiceChargeType
         */
        $logcharge = self::$objectHelper->getLogisticsServiceChargeType(null, null, null, null, null);
        $this->assertNull($logcharge);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementHeaderMonetarySummationType
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementHeaderMonetarySummationTypeOnly
     */
    public function testGetTradeSettlementHeaderMonetarySummationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementHeaderMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementHeaderMonetarySummationType(119, 100, 100, 1, 2, 99, 99 * 0.19, 0.0, 10);
        $this->assertIsArray($summation->getGrandTotalAmount());
        $this->assertArrayHasKey(0, $summation->getGrandTotalAmount());
        $this->assertEquals(119.0, $summation->getGrandTotalAmount()[0]->value());
        $this->assertEquals(100.0, $summation->getDuePayableAmount()->value());
        $this->assertEquals(100.0, $summation->getLineTotalAmount()->value());
        $this->assertEquals(1.0, $summation->getChargeTotalAmount()->value());
        $this->assertEquals(2.0, $summation->getAllowanceTotalAmount()->value());
        $this->assertIsArray($summation->getTaxBasisTotalAmount());
        $this->assertArrayHasKey(0, $summation->getTaxBasisTotalAmount());
        $this->assertEquals(99.0, $summation->getTaxBasisTotalAmount()[0]->value());
        $this->assertIsArray($summation->getTaxTotalAmount());
        $this->assertArrayHasKey(0, $summation->getTaxTotalAmount());
        $this->assertEquals(99.0 * 0.19, $summation->getTaxTotalAmount()[0]->value());
        $this->assertEquals(0.0, $summation->getRoundingAmount()->value());
        $this->assertEquals(10.0, $summation->getTotalPrepaidAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementHeaderMonetarySummationType
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementHeaderMonetarySummationTypeOnly
     */
    public function testGetTradeSettlementHeaderMonetarySummationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementHeaderMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementHeaderMonetarySummationType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($summation);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementHeaderMonetarySummationTypeOnly
     */
    public function testGetTradeSettlementHeaderMonetarySummationTypeOnly()
    {
        $summation = self::$objectHelper->getTradeSettlementHeaderMonetarySummationTypeOnly();
        $this->assertNotNull($summation);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeAccountingAccountType
     */
    public function testGetTradeAccountingAccountTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAccountingAccountType
         */
        $accaccount = self::$objectHelper->getTradeAccountingAccountType("accid", "acctype");
        $this->assertEquals("accid", $accaccount->getID());
        $this->assertEquals("acctype", $accaccount->getTypeCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeAccountingAccountType
     */
    public function testGetTradeAccountingAccountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAccountingAccountType
         */
        $accaccount = self::$objectHelper->getTradeAccountingAccountType(null, null);
        $this->assertNull($accaccount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDocumentLineDocumentType
     */
    public function testGetDocumentLineDocumentTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DocumentLineDocumentType
         */
        $doclinedoctype = self::$objectHelper->getDocumentLineDocumentType("lineid");
        $this->assertEquals("lineid", $doclinedoctype->getLineID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getDocumentLineDocumentType
     */
    public function testGetDocumentLineDocumentTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DocumentLineDocumentType
         */
        $doclinedoctype = self::$objectHelper->getDocumentLineDocumentType(null);
        $this->assertNull($doclinedoctype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getSupplyChainTradeLineItemType
     */
    public function testGetSupplyChainTradeLineItemTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainTradeLineItemType
         */
        $line = self::$objectHelper->getSupplyChainTradeLineItemType("lineid", "linestatuscode", "linestatusreasoncode");
        $this->assertNotNull($line);
        $this->assertEquals("lineid", $line->getAssociatedDocumentLineDocument()->getLineID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getSupplyChainTradeLineItemType
     */
    public function testGetSupplyChainTradeLineItemTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainTradeLineItemType
         */
        $line = self::$objectHelper->getSupplyChainTradeLineItemType(null, null, null);
        $this->assertNull($line);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeProductType
     */
    public function testGetTradeProductTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeProductType
         */
        $product = self::$objectHelper->getTradeProductType("name", "description", "sellerid", "buyerid", "globalidtype", "globalid");
        $this->assertEquals("name", $product->getName());
        $this->assertEquals("description", $product->getDescription());
        $this->assertEquals("sellerid", $product->getSellerAssignedID());
        $this->assertEquals("buyerid", $product->getBuyerAssignedID());
        $this->assertEquals("globalidtype", $product->getGlobalID()->getSchemeID());
        $this->assertEquals("globalid", $product->getGlobalID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeProductType
     */
    public function testGetTradeProductTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeProductType
         */
        $product = self::$objectHelper->getTradeProductType(null, null, null, null, null, null);
        $this->assertNull($product);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getProductCharacteristicType
     */
    public function testGetProductCharacteristicType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProductCharacteristicType
         */
        $productCharacteristic = self::$objectHelper->getProductCharacteristicType("typecode", "description", 10.2, "valuemeasureunit", "value");
        $this->assertEquals("description", $productCharacteristic->getDescription());
        $this->assertEquals("value", $productCharacteristic->getValue());
        $this->assertEquals(10.2, $productCharacteristic->getValueMeasure()->value());
        $this->assertEquals("valuemeasureunit", $productCharacteristic->getValueMeasure()->getUnitCode());
        $this->assertEquals("typecode", $productCharacteristic->getTypeCode()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradePriceType
     */
    public function testGetTradePriceTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePriceType
         */
        $price = self::$objectHelper->getTradePriceType(1.0, 2.0, "C62");
        $this->assertEquals(1.0, $price->getChargeAmount()->value());
        $this->assertEquals(2.0, $price->getBasisQuantity()->value());
        $this->assertEquals("C62", $price->getBasisQuantity()->getUnitCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradePriceType
     */
    public function testGetTradePriceTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePriceType
         */
        $price = self::$objectHelper->getTradePriceType(null, null, null);
        $this->assertNull($price);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementLineMonetarySummationType
     */
    public function testGetTradeSettlementLineMonetarySummationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementLineMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementLineMonetarySummationType(1.0, 2.0);
        $this->assertEquals(1.0, $summation->getLineTotalAmount()->value());
        $this->assertEquals(2.0, $summation->getTotalAllowanceChargeAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::getTradeSettlementLineMonetarySummationType
     */
    public function testGetTradeSettlementLineMonetarySummationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementLineMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementLineMonetarySummationType(null, null);
        $this->assertNull($summation);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::toDateTime
     */
    public function testToDateTimeGeneral()
    {
        $this->assertEquals("20200202", self::$objectHelper->toDateTime("20200202", "102")->format("Ymd"));
        $this->assertNull(self::$objectHelper->toDateTime("", "102"));
        $this->assertNull(self::$objectHelper->toDateTime("20200202", ""));
        $this->assertNull(self::$objectHelper->toDateTime(null, "102"));
        $this->assertNull(self::$objectHelper->toDateTime("20200202", null));
        $this->assertNull(self::$objectHelper->toDateTime("", ""));
        $this->assertNull(self::$objectHelper->toDateTime(null, null));
        $this->assertNull(self::$objectHelper->toDateTime("", null));
        $this->assertNull(self::$objectHelper->toDateTime(null, ""));
        $this->assertNull(self::$objectHelper->toDateTime(null, null));
        $this->expectException(ZugferdUnknownDateFormat::class);
        $this->assertNull(self::$objectHelper->toDateTime("20200202", "999"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::toDateTime
     */
    public function testToDateTime101()
    {
        $this->assertEquals("20200202", self::$objectHelper->toDateTime("200202", "101")->format("Ymd"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::toDateTime
     */
    public function testToDateTime201()
    {
        $this->assertEquals("2002021031", self::$objectHelper->toDateTime("2002021031", "201")->format("ymdHi"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::toDateTime
     */
    public function testToDateTime202()
    {
        $this->assertEquals("200202103145", self::$objectHelper->toDateTime("200202103145", "202")->format("ymdHis"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::toDateTime
     */
    public function testToDateTime203()
    {
        $this->assertEquals("202002021031", self::$objectHelper->toDateTime("202002021031", "203")->format("YmdHi"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::toDateTime
     */
    public function testToDateTime204()
    {
        $this->assertEquals("20200202103145", self::$objectHelper->toDateTime("20200202103145", "204")->format("YmdHis"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::createClassInstance
     */
    public function testCreateClassInstance()
    {
        $instance = self::$objectHelper->createClassInstance('ram\TradeProductType');
        $this->assertNotNull($instance);
        $instance = self::$objectHelper->createClassInstance('ram\LogisticsServiceChargeType');
        $this->assertNotNull($instance);
    }
}
