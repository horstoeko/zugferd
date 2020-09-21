<?php

namespace horstoeko\zugferd\tests;

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdObjectHelper;

class ObjectHelperEn16931Test extends TestCase
{
    /**
     * @var ZugferdObjectHelper
     */
    protected static $objectHelper;

    public static function setUpBeforeClass(): void
    {
        self::$objectHelper = new ZugferdObjectHelper(ZugferdProfiles::PROFILE_EN16931);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetIdType
     */
    public function testGetIdTypeWithValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IDType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TextType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TextType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TextType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TextType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TextType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TextType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IndicatorType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IndicatorType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->GetIndicatorType(null);
        $this->assertNull($indicatortype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNoteType
     */
    public function testGetNoteTypeWithAllValues()
    {
        /**
         * @var \horstoeko\zugferd\entities\en16931\ram\NoteType
         */
        $notetype = self::$objectHelper->GetNoteType("content", "contentcode", "subjectcode");
        $this->assertEquals("content", $notetype->getContent());
        $this->assertEquals("subjectcode", $notetype->getSubjectCode()->value());
        $this->assertFalse(method_exists($notetype, "getContentCode"));
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNoteType
     */
    public function testGetNoteTypeWithAllNullValue()
    {
        /**
         * @var \horstoeko\zugferd\entities\en16931\ram\NoteType
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
         * @var \horstoeko\zugferd\entities\en16931\ram\NoteType
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
         * @var \horstoeko\zugferd\entities\en16931\ram\NoteType
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
         * @var \horstoeko\zugferd\entities\en16931\qdt\FormattedDateTimeType
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
         * @var \horstoeko\zugferd\entities\en16931\qdt\FormattedDateTimeType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\DateTimeType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\DateTimeType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\DateType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\DateType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\AmountType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\AmountType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\AmountType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\AmountType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\AmountType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\PercentType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\PercentType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\QuantityType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\QuantityType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\QuantityType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\QuantityType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\MeasureType
         */
        $measuretype = self::$objectHelper->GetMeasureType(100.0);
        $this->assertNull($measuretype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetMeasureType
     */
    public function testGetMeasureTypeWithValueAndUnitCode()
    {
        /**
         * @var \horstoeko\zugferd\entities\en16931\udt\MeasureType
         */
        $measuretype = self::$objectHelper->GetMeasureType(100.0, "DAY");
        $this->assertNull($measuretype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetMeasureType
     */
    public function testGetMeasureTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\en16931\udt\MeasureType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\MeasureType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\NumericType
         */
        $numerictype = self::$objectHelper->GetNumericType(100.0);
        $this->assertNull($numerictype);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdObjectHelper::GetNumericType
     */
    public function testGetNumericTypeAllNull()
    {
        /**
         * @var \horstoeko\zugferd\entities\en16931\udt\NumericType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TaxCategoryCodeType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TaxCategoryCodeType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TaxTypeCodeType
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
         * @var \horstoeko\zugferd\entities\en16931\udt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->GetTaxTypeCodeType(null);
        $this->assertNull($taxtypecodetype);
    }
}
