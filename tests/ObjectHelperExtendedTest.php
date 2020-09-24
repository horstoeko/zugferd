<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdObjectHelper;
use horstoeko\zugferd\exception\ZugferdUnknownDateFormat;

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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType("abc");
        $this->assertEquals("abc", $idtype->value());
        $this->assertEquals("", $idtype->getSchemeID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeWithValueAndScheme()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType("abc", "0088");
        $this->assertEquals("abc", $idtype->value());
        $this->assertEquals("0088", $idtype->getSchemeID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeAllEmpty()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType("", "");
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType(null, null);
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeEmptyValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType("");
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType(null);
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeEmptyValueWithScheme()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->GetIdType("", "0088");
        $this->assertNull($idtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTextType
     */
    public function testGetTextTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->GetTextType("test");
        $this->assertEquals("test", $texttype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTextType
     */
    public function testGetTextTypeAllEmpty()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->GetTextType("");
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTextType
     */
    public function testGetTextTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->GetTextType(null);
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCodeType
     */
    public function testGetCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->GetCodeType("test");
        $this->assertEquals("test", $texttype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCodeType
     */
    public function testGetCodeTypeAllEmpty()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->GetCodeType("");
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCodeType
     */
    public function testGetCodeTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->GetCodeType(null);
        $this->assertNull($texttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIndicatorType
     */
    public function testGetIndicatorTypeWithTrueValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->GetIndicatorType(true);
        $this->assertTrue($indicatortype->getIndicator());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIndicatorType
     */
    public function testGetIndicatorTypeWithFalseValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->GetIndicatorType(false);
        $this->assertNull($indicatortype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIndicatorType
     */
    public function testGetIndicatorTypeNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->GetIndicatorType(null);
        $this->assertNull($indicatortype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNoteType
     */
    public function testGetNoteTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->GetNoteType("content", "contentcode", "subjectcode");
        $this->assertEquals("content", $notetype->getContent());
        $this->assertEquals("subjectcode", $notetype->getSubjectCode()->value());
        $this->assertEquals("contentcode", $notetype->getContentCode()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNoteType
     */
    public function testGetNoteTypeAllNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->GetNoteType(null, null, null);
        $this->assertNull($notetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNoteType
     */
    public function testGetNoteTypeWithEmptyContent()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->GetNoteType("", "", "");
        $this->assertNull($notetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNoteType
     */
    public function testGetNoteTypeWithEmptyContentButWithSubjectCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->GetNoteType("", "", "subjectcode");
        $this->assertNull($notetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetFormattedDateTimeType
     */
    public function testGetFormattedDateTimeType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
         */
        $datetimetype = self::$objectHelper->GetFormattedDateTimeType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateTimeString());
        $this->assertEquals("102", $datetimetype->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetFormattedDateTimeType
     */
    public function testGetFormattedDateTimeTypeWithNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
         */
        $datetimetype = self::$objectHelper->GetFormattedDateTimeType(null);
        $this->assertNull($datetimetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDateTimeType
     */
    public function testGetDateTimeType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType
         */
        $datetimetype = self::$objectHelper->GetDateTimeType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateTimeString());
        $this->assertEquals("102", $datetimetype->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDateTimeType
     */
    public function testGetDateTimeTypeWithNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType
         */
        $datetimetype = self::$objectHelper->GetDateTimeType(null);
        $this->assertNull($datetimetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDateType
     */
    public function testGetDateType()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateType
         */
        $datetimetype = self::$objectHelper->GetDateType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateString());
        $this->assertEquals("102", $datetimetype->getDateString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDateType
     */
    public function testGetDateTypeWithNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateType
         */
        $datetimetype = self::$objectHelper->GetDateType(null);
        $this->assertNull($datetimetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetAmountType
     */
    public function testGetAmountTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->GetAmountType(100.0);
        $this->assertEquals(100.0, $amounttype->value());
        $this->assertEquals("", $amounttype->getCurrencyID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetAmountType
     */
    public function testGetAmountTypeWithValueAndCurrency()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->GetAmountType(100.0, "EUR");
        $this->assertEquals(100.0, $amounttype->value());
        $this->assertEquals("EUR", $amounttype->getCurrencyID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetAmountType
     */
    public function testGetAmountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->GetAmountType(null, null);
        $this->assertNull($amounttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetAmountType
     */
    public function testGetAmountTypeWithValueAndEmptyCurrency()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->GetAmountType(100, "");
        $this->assertEquals(100.0, $amounttype->value());
        $this->assertEquals("", $amounttype->getCurrencyID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetAmountType
     */
    public function testGetAmountTypeWithNullValueAndCurrency()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->GetAmountType(null, "EUR");
        $this->assertNull($amounttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetPercentType
     */
    public function testGetPercentTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $percenttype = self::$objectHelper->GetPercentType(100.0);
        $this->assertEquals(100.0, $percenttype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetPercentType
     */
    public function testGetPercentTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $percenttype = self::$objectHelper->GetPercentType(null);
        $this->assertNull($percenttype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetQuantityType
     */
    public function testGetQuantityTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->GetQuantityType(100.0);
        $this->assertEquals(100.0, $quantitytype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetQuantityType
     */
    public function testGetQuantityTypeWithValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->GetQuantityType(100.0, "C62");
        $this->assertEquals(100.0, $quantitytype->value());
        $this->assertEquals("C62", $quantitytype->getUnitCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetQuantityType
     */
    public function testGetQuantityTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->GetQuantityType(null, null);
        $this->assertNull($quantitytype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetQuantityType
     */
    public function testGetQuantityTypeWithNullValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->GetQuantityType(null, "C62");
        $this->assertNull($quantitytype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetMeasureType
     */
    public function testGetMeasureTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->GetMeasureType(100.0);
        $this->assertEquals(100.0, $measuretype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetMeasureType
     */
    public function testGetMeasureTypeWithValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->GetMeasureType(100.0, "DAY");
        $this->assertEquals(100.0, $measuretype->value());
        $this->assertEquals("DAY", $measuretype->getUnitCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetMeasureType
     */
    public function testGetMeasureTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->GetMeasureType(null, null);
        $this->assertNull($measuretype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetMeasureType
     */
    public function testGetMeasureTypeWithNullValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->GetMeasureType(null, "DAY");
        $this->assertNull($measuretype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNumericType
     */
    public function testGetNumericTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $numerictype = self::$objectHelper->GetNumericType(100.0);
        $this->assertEquals(100, $numerictype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNumericType
     */
    public function testGetNumericTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $numerictype = self::$objectHelper->GetNumericType(null);
        $this->assertNull($numerictype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxCategoryCodeType
     */
    public function testGetTaxCategoryCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxCategoryCodeType
         */
        $taxcategorycodetype = self::$objectHelper->GetTaxCategoryCodeType("VAT");
        $this->assertEquals("VAT", $taxcategorycodetype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxCategoryCodeType
     */
    public function testGetTaxCategoryCodeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxCategoryCodeType
         */
        $taxcategorycodetype = self::$objectHelper->GetTaxCategoryCodeType(null);
        $this->assertNull($taxcategorycodetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxTypeCodeType
     */
    public function testGetTaxTypeCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->GetTaxTypeCodeType("S");
        $this->assertEquals("S", $taxtypecodetype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxTypeCodeType
     */
    public function testGetTaxTypeCodeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->GetTaxTypeCodeType(null);
        $this->assertNull($taxtypecodetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTimeReferenceCodeType
     */
    public function testGetTimeReferenceCodeTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TimeReferenceCodeType
         */
        $timereferencecodetype = self::$objectHelper->GetTimeReferenceCodeType("REF");
        $this->assertEquals("REF", $timereferencecodetype->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTimeReferenceCodeType
     */
    public function testGetTimeReferenceCodeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TimeReferenceCodeType
         */
        $timereferencecodetype = self::$objectHelper->GetTimeReferenceCodeType(null);
        $this->assertNull($timereferencecodetype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetSpecifiedPeriodType
     */
    public function testGetSpecifiedPeriodTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType
         */
        $periodtype = self::$objectHelper->GetSpecifiedPeriodType(new \DateTime(), new \DateTime(), new \DateTime(), "Description");
        $this->assertEquals("Description", $periodtype->getDescription());
        $this->assertEquals((new \DateTime())->format("Ymd"), $periodtype->getCompleteDateTime()->getDateTimeString());
        $this->assertEquals("102", $periodtype->getCompleteDateTime()->getDateTimeString()->getFormat());
        $this->assertEquals((new \DateTime())->format("Ymd"), $periodtype->getStartDateTime()->getDateTimeString());
        $this->assertEquals("102", $periodtype->getStartDateTime()->getDateTimeString()->getFormat());
        $this->assertEquals((new \DateTime())->format("Ymd"), $periodtype->getEndDateTime()->getDateTimeString());
        $this->assertEquals("102", $periodtype->getEndDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetSpecifiedPeriodType
     */
    public function testGetSpecifiedPeriodTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType
         */
        $periodtype = self::$objectHelper->GetSpecifiedPeriodType(null, null, null, null);
        $this->assertNull($periodtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetBinaryObjectType
     */
    public function testGetBinaryObjectTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->GetBinaryObjectType("data", "application/pdf", "mypdf.pdf");
        $this->assertEquals("data", $binaryobject->value());
        $this->assertEquals("application/pdf", $binaryobject->getMimeCode());
        $this->assertEquals("mypdf.pdf", $binaryobject->getFilename());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetBinaryObjectType
     */
    public function testGetBinaryObjectTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->GetBinaryObjectType(null, null, null);
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetBinaryObjectType
     */
    public function testGetBinaryObjectTypeDataNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->GetBinaryObjectType(null, "application/pdf", "mypdf.pdf");
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetBinaryObjectType
     */
    public function testGetBinaryObjectTypeMimeTypeNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->GetBinaryObjectType("data", null, "mypdf.pdf");
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetBinaryObjectType
     */
    public function testGetBinaryObjectTypeFilenameNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->GetBinaryObjectType("data", "application/pdf", null);
        $this->assertNull($binaryobject);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetReferencedDocumentType
     */
    public function testGetReferencedDocumentTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
         */
        $refdoctype = self::$objectHelper->GetReferencedDocumentType("issuerid", "uriid", "lineid", "typecode", "name", "reftypcode", new \DateTime(), dirname(__FILE__) . "/data/en16931_allowancecharge.xml");
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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetReferencedDocumentType
     */
    public function testGetReferencedDocumentTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
         */
        $refdoctype = self::$objectHelper->GetReferencedDocumentType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($refdoctype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCrossIndustryInvoice
     */
    public function testCrossIndustryInvoice()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice
         */
        $crossindusty = self::$objectHelper->GetCrossIndustryInvoice();
        $this->assertNotNull($crossindusty);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeParty
     */
    public function testGetTradePartyAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->GetTradeParty("name", "id", "description");
        $this->assertEquals("name", $tradeparty->getName());
        $this->assertIsArray($tradeparty->getID());
        $this->assertArrayHasKey(0, $tradeparty->getID());
        $this->assertEquals("id", $tradeparty->getID()[0]);
        $this->assertEquals("description", $tradeparty->getDescription());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeParty
     */
    public function testGetTradePartyNullValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->GetTradeParty(null, null, null);
        $this->assertNull($tradeparty);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeAddress
     */
    public function testGetTradeAddressAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAddressType
         */
        $tradeaddress = self::$objectHelper->GetTradeAddress("lineone", "linetwo", "linethree", "00000", "city", "country", "county");
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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeAddress
     */
    public function testGetTradeAddressAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAddressType
         */
        $tradeaddress = self::$objectHelper->GetTradeAddress(null, null, null, null, null, null, null);
        $this->assertNull($tradeaddress);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetLegalOrganization
     */
    public function testGetLegalOrganizationAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LegalOrganizationType
         */
        $legalorg = self::$objectHelper->GetLegalOrganization("orgid", "orgtype", "orgname");
        $this->assertEquals("orgid", $legalorg->getID());
        $this->assertEquals("orgtype", $legalorg->getID()->getSchemeID());
        $this->assertEquals("orgname", $legalorg->getTradingBusinessName());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetLegalOrganization
     */
    public function testGetLegalOrganizationAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LegalOrganizationType
         */
        $legalorg = self::$objectHelper->GetLegalOrganization(null, null, null);
        $this->assertNull($legalorg);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeContact
     */
    public function testGetTradeContactAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeContactType
         */
        $tradecontact = self::$objectHelper->GetTradeContact("personname", "departmentname", "phone", "fax", "mail");
        $this->assertEquals("personname", $tradecontact->getPersonName());
        $this->assertEquals("departmentname", $tradecontact->getDepartmentName());
        $this->assertEquals("phone", $tradecontact->getTelephoneUniversalCommunication()->getCompleteNumber());
        $this->assertEquals("fax", $tradecontact->getFaxUniversalCommunication()->getCompleteNumber());
        $this->assertEquals("mail", $tradecontact->getEmailURIUniversalCommunication()->getURIID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeContact
     */
    public function testGetTradeContactAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeContactType
         */
        $tradecontact = self::$objectHelper->GetTradeContact(null, null, null, null, null, null);
        $this->assertNull($tradecontact);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetUniversalCommunicationType
     */
    public function testGetUniversalCommunicationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType
         */
        $commtype = self::$objectHelper->GetUniversalCommunicationType("number", "uriid", "smtp");
        $this->assertEquals("number", $commtype->getCompleteNumber());
        $this->assertEquals("uriid", $commtype->getURIID());
        $this->assertEquals("smtp", $commtype->getURIID()->getSchemeID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetUniversalCommunicationType
     */
    public function testGetUniversalCommunicationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType
         */
        $commtype = self::$objectHelper->GetUniversalCommunicationType(null, null, null);
        $this->assertNull($commtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->GetTaxRegistrationType("taxregtype", "taxid");
        $this->assertEquals("taxregtype", $taxregtype->getID()->getSchemeID());
        $this->assertEquals("taxid", $taxregtype->getID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->GetTaxRegistrationType(null, null);
        $this->assertNull($taxregtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeIdNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->GetTaxRegistrationType("taxregtype", null);
        $this->assertNull($taxregtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTaxRegistrationType
     */
    public function testGetTaxRegistrationTypeTypeNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->GetTaxRegistrationType(null, "taxid");
        $this->assertNull($taxregtype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeDeliveryTermsType
     */
    public function testGetTradeDeliveryTermsTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType
         */
        $devterms = self::$objectHelper->GetTradeDeliveryTermsType('code');
        $this->assertEquals("code", $devterms->getDeliveryTypeCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeDeliveryTermsType
     */
    public function testGetTradeDeliveryTermsTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType
         */
        $devterms = self::$objectHelper->GetTradeDeliveryTermsType(null);
        $this->assertNull($devterms);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetProcuringProjectType
     */
    public function testGetProcuringProjectTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->GetProcuringProjectType("projectid", "projectname");
        $this->assertEquals("projectid", $project->getID());
        $this->assertEquals("projectname", $project->getName());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetProcuringProjectType
     */
    public function testGetProcuringProjectTypeIdNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->GetProcuringProjectType(null, "projectname");
        $this->assertNull($project);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetProcuringProjectType
     */
    public function testGetProcuringProjectTypeNameNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->GetProcuringProjectType("projectid", null);
        $this->assertNull($project);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetProcuringProjectType
     */
    public function testGetProcuringProjectTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->GetProcuringProjectType(null, null);
        $this->assertNull($project);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetSupplyChainEventType
     */
    public function testGetSupplyChainEventTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType
         */
        $supplychainevent = self::$objectHelper->GetSupplyChainEventType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $supplychainevent->getOccurrenceDateTime()->getDateTimeString());
        $this->assertEquals("102", $supplychainevent->getOccurrenceDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetSupplyChainEventType
     */
    public function testGetSupplyChainEventTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType
         */
        $supplychainevent = self::$objectHelper->GetSupplyChainEventType(null);
        $this->assertNull($supplychainevent);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementFinancialCardType
     */
    public function testGetTradeSettlementFinancialCardTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType
         */
        $fincard = self::$objectHelper->GetTradeSettlementFinancialCardType("type", "id", "name");
        $this->assertEquals("type", $fincard->getID()->getSchemeID());
        $this->assertEquals("id", $fincard->getID());
        $this->assertEquals("name", $fincard->getCardholderName());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementFinancialCardType
     */
    public function testGetTradeSettlementFinancialCardTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType
         */
        $fincard = self::$objectHelper->GetTradeSettlementFinancialCardType(null, null, null);
        $this->assertNull($fincard);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDebtorFinancialAccountType
     */
    public function testGetDebtorFinancialAccountTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType
         */
        $finacc = self::$objectHelper->GetDebtorFinancialAccountType("iban");
        $this->assertEquals("iban", $finacc->getIBANID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDebtorFinancialAccountType
     */
    public function testGetDebtorFinancialAccountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType
         */
        $finacc = self::$objectHelper->GetDebtorFinancialAccountType(null);
        $this->assertNull($finacc);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCreditorFinancialAccountType
     */
    public function testGetCreditorFinancialAccountTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType
         */
        $finacc = self::$objectHelper->GetCreditorFinancialAccountType("iban", "accname", "propid");
        $this->assertEquals("iban", $finacc->getIBANID());
        $this->assertEquals("accname", $finacc->getAccountName());
        $this->assertEquals("propid", $finacc->getProprietaryID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCreditorFinancialAccountType
     */
    public function testGetCreditorFinancialAccountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType
         */
        $finacc = self::$objectHelper->GetCreditorFinancialAccountType(null, null, null);
        $this->assertNull($finacc);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCreditorFinancialInstitutionType
     */
    public function testGetCreditorFinancialInstitutionTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType
         */
        $fininst = self::$objectHelper->GetCreditorFinancialInstitutionType("bic");
        $this->assertEquals("bic", $fininst->getBICID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetCreditorFinancialInstitutionType
     */
    public function testGetCreditorFinancialInstitutionTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType
         */
        $fininst = self::$objectHelper->GetCreditorFinancialInstitutionType(null);
        $this->assertNull($fininst);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementPaymentMeansType
     */
    public function testGetTradeSettlementPaymentMeansTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType
         */
        $paymentmeans = self::$objectHelper->GetTradeSettlementPaymentMeansType("code", "info");
        $this->assertEquals("code", $paymentmeans->getTypeCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementPaymentMeansType
     */
    public function testGetTradeSettlementPaymentMeansTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType
         */
        $paymentmeans = self::$objectHelper->GetTradeSettlementPaymentMeansType(null, null);
        $this->assertNull($paymentmeans);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradePaymentTermsType
     */
    public function testGetTradePaymentTermsTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentTermsType
         */
        $paymentterms = self::$objectHelper->GetTradePaymentTermsType("description", new \DateTime(), "mandate");
        $this->assertEquals((new \DateTime())->format("Ymd"), $paymentterms->getDueDateDateTime()->getDateTimeString());
        $this->assertEquals("102", $paymentterms->getDueDateDateTime()->getDateTimeString()->getFormat());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradePaymentTermsType
     */
    public function testGetTradePaymentTermsTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentTermsType
         */
        $paymentmeans = self::$objectHelper->GetTradePaymentTermsType(null, null, null);
        $this->assertNull($paymentmeans);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradePaymentDiscountTermsType
     */
    public function testGetTradePaymentDiscountTermsTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType
         */
        $discountterms = self::$objectHelper->GetTradePaymentDiscountTermsType(new \DateTime(), 2, "DAY", 1, 1, 1);
        
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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradePaymentDiscountTermsType
     */
    public function testGetTradePaymentDiscountTermsTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType
         */
        $discountterms = self::$objectHelper->GetTradePaymentDiscountTermsType(null, null, null, null, null, null);
        $this->assertNull($discountterms);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeTaxType
     */
    public function testGetTradeTaxTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType
         */
        $tax = self::$objectHelper->GetTradeTaxType("category", "type", 100, 19, 19, "reason", "reasoncode", 100, 10, new \DateTime(), "duedatecode");
        
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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeTaxType
     */
    public function testGetTradeTaxTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType
         */
        $tax = self::$objectHelper->GetTradeTaxType(null, null, null, null, null, null, null, null, null, null, null);
        $this->assertNull($tax);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeAllowanceChargeType
     */
    public function testGetTradeAllowanceChargeTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAllowanceChargeType
         */
        $allowancecharge = self::$objectHelper->GetTradeAllowanceChargeType(10, true, "taxtype", "taxcategory", 19.0, 1, 2.0, 1.0, 1.0, "C62", "reasoncode", "reason");

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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeAllowanceChargeType
     */
    public function testGetTradeAllowanceChargeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAllowanceChargeType
         */
        $allowancecharge = self::$objectHelper->GetTradeAllowanceChargeType(null, null, null, null, null, null, null, null, null, null, null, null);
        $this->assertNull($allowancecharge);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetLogisticsServiceChargeType
     */
    public function testGetLogisticsServiceChargeTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LogisticsServiceChargeType
         */
        $logcharge = self::$objectHelper->GetLogisticsServiceChargeType("description", 10.0, ["taxtype"], ["taxcategpry"], [19]);
        $this->assertEquals("description", $logcharge->getDescription());
        $this->assertEquals(10.0, $logcharge->getAppliedAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetLogisticsServiceChargeType
     */
    public function testGetLogisticsServiceChargeTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LogisticsServiceChargeType
         */
        $logcharge = self::$objectHelper->GetLogisticsServiceChargeType(null, null, null, null, null);
        $this->assertNull($logcharge);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementHeaderMonetarySummationType
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementHeaderMonetarySummationTypeOnly
     */
    public function testGetTradeSettlementHeaderMonetarySummationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementHeaderMonetarySummationType
         */
        $summation = self::$objectHelper->GetTradeSettlementHeaderMonetarySummationType(119, 100, 100, 1, 2, 99, 99 * 0.19, 0.0, 10);
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
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementHeaderMonetarySummationType
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementHeaderMonetarySummationTypeOnly
     */
    public function testGetTradeSettlementHeaderMonetarySummationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementHeaderMonetarySummationType
         */
        $summation = self::$objectHelper->GetTradeSettlementHeaderMonetarySummationType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($summation);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementHeaderMonetarySummationTypeOnly
     */
    public function testGetTradeSettlementHeaderMonetarySummationTypeOnly()
    {
        $summation = self::$objectHelper->GetTradeSettlementHeaderMonetarySummationTypeOnly();
        $this->assertNotNull($summation);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeAccountingAccountType
     */
    public function testGetTradeAccountingAccountTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAccountingAccountType
         */
        $accaccount = self::$objectHelper->GetTradeAccountingAccountType("accid", "acctype");
        $this->assertEquals("accid", $accaccount->getID());
        $this->assertEquals("acctype", $accaccount->getTypeCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeAccountingAccountType
     */
    public function testGetTradeAccountingAccountTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAccountingAccountType
         */
        $accaccount = self::$objectHelper->GetTradeAccountingAccountType(null, null);
        $this->assertNull($accaccount);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDocumentLineDocumentType
     */
    public function testGetDocumentLineDocumentTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DocumentLineDocumentType
         */
        $doclinedoctype = self::$objectHelper->GetDocumentLineDocumentType("lineid");
        $this->assertEquals("lineid", $doclinedoctype->getLineID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetDocumentLineDocumentType
     */
    public function testGetDocumentLineDocumentTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DocumentLineDocumentType
         */
        $doclinedoctype = self::$objectHelper->GetDocumentLineDocumentType(null);
        $this->assertNull($doclinedoctype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetSupplyChainTradeLineItemType
     */
    public function testGetSupplyChainTradeLineItemTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainTradeLineItemType
         */
        $line = self::$objectHelper->GetSupplyChainTradeLineItemType("lineid", "linestatuscode", "linestatusreasoncode");
        $this->assertNotNull($line);
        $this->assertEquals("lineid", $line->getAssociatedDocumentLineDocument()->getLineID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetSupplyChainTradeLineItemType
     */
    public function testGetSupplyChainTradeLineItemTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainTradeLineItemType
         */
        $line = self::$objectHelper->GetSupplyChainTradeLineItemType(null, null, null);
        $this->assertNull($line);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeProductType
     */
    public function testGetTradeProductTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeProductType
         */
        $product = self::$objectHelper->GetTradeProductType("name", "description", "sellerid", "buyerid", "globalidtype", "globalid");
        $this->assertEquals("name", $product->getName());
        $this->assertEquals("description", $product->getDescription());
        $this->assertEquals("sellerid", $product->getSellerAssignedID());
        $this->assertEquals("buyerid", $product->getBuyerAssignedID());
        $this->assertEquals("globalidtype", $product->getGlobalID()->getSchemeID());
        $this->assertEquals("globalid", $product->getGlobalID());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeProductType
     */
    public function testGetTradeProductTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeProductType
         */
        $product = self::$objectHelper->GetTradeProductType(null, null, null, null, null, null);
        $this->assertNull($product);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradePriceType
     */
    public function testGetTradePriceTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePriceType
         */
        $price = self::$objectHelper->GetTradePriceType(1.0, 2.0, "C62");
        $this->assertEquals(1.0, $price->getChargeAmount()->value());
        $this->assertEquals(2.0, $price->getBasisQuantity()->value());
        $this->assertEquals("C62", $price->getBasisQuantity()->getUnitCode());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradePriceType
     */
    public function testGetTradePriceTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePriceType
         */
        $price = self::$objectHelper->GetTradePriceType(null, null, null);
        $this->assertNull($price);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementLineMonetarySummationType
     */
    public function testGetTradeSettlementLineMonetarySummationTypeAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementLineMonetarySummationType
         */
        $summation = self::$objectHelper->GetTradeSettlementLineMonetarySummationType(1.0, 2.0);
        $this->assertEquals(1.0, $summation->getLineTotalAmount()->value());
        $this->assertEquals(2.0, $summation->getTotalAllowanceChargeAmount()->value());
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetTradeSettlementLineMonetarySummationType
     */
    public function testGetTradeSettlementLineMonetarySummationTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementLineMonetarySummationType
         */
        $summation = self::$objectHelper->GetTradeSettlementLineMonetarySummationType(null, null);
        $this->assertNull($summation);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::ToDateTime
     */
    public function testToDateTimeGeneral()
    {
        $this->assertEquals("20200202", self::$objectHelper->ToDateTime("20200202", "102")->format("Ymd"));
        $this->assertNull(self::$objectHelper->ToDateTime("", "102"));
        $this->assertNull(self::$objectHelper->ToDateTime("20200202", ""));
        $this->assertNull(self::$objectHelper->ToDateTime(null, "102"));
        $this->assertNull(self::$objectHelper->ToDateTime("20200202", null));
        $this->assertNull(self::$objectHelper->ToDateTime("", ""));
        $this->assertNull(self::$objectHelper->ToDateTime(null, null));
        $this->assertNull(self::$objectHelper->ToDateTime("", null));
        $this->assertNull(self::$objectHelper->ToDateTime(null, ""));
        $this->assertNull(self::$objectHelper->ToDateTime(null, null));
        $this->expectException(ZugferdUnknownDateFormat::class);
        $this->assertNull(self::$objectHelper->ToDateTime("20200202", "999"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::ToDateTime
     */
    public function testToDateTime101()
    {
        $this->assertEquals("20200202", self::$objectHelper->ToDateTime("200202", "101")->format("Ymd"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::ToDateTime
     */
    public function testToDateTime201()
    {
        $this->assertEquals("2002021031", self::$objectHelper->ToDateTime("2002021031", "201")->format("ymdHi"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::ToDateTime
     */
    public function testToDateTime202()
    {
        $this->assertEquals("200202103145", self::$objectHelper->ToDateTime("200202103145", "202")->format("ymdHis"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::ToDateTime
     */
    public function testToDateTime203()
    {
        $this->assertEquals("202002021031", self::$objectHelper->ToDateTime("202002021031", "203")->format("YmdHi"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::ToDateTime
     */
    public function testToDateTime204()
    {
        $this->assertEquals("20200202103145", self::$objectHelper->ToDateTime("20200202103145", "204")->format("YmdHis"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::CreateClassInstance
     */
    public function testCreateClassInstance()
    {
        $instance = self::$objectHelper->CreateClassInstance('ram\TradeProductType');
        $this->assertNotNull($instance);
        $instance = self::$objectHelper->CreateClassInstance('ram\LogisticsServiceChargeType');
        $this->assertNotNull($instance);
    }
}
