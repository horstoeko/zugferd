<?php

namespace horstoeko\zugferd\tests\testcases;

use DateTime;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdObjectHelper;
use horstoeko\zugferd\exception\ZugferdUnknownDateFormatException;

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

    public function testGetDocumentCodeTypeEmpty(): void
    {
        $codeType = self::$objectHelper->getDocumentCodeType();
        $this->assertNull($codeType);
    }

    public function testGetDocumentCodeTypeNotEmpty(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\DocumentCodeType
         */
        $codeType = self::$objectHelper->getDocumentCodeType("380");
        $this->assertNotNull($codeType);
        $this->assertEquals("380", $codeType->value());
    }

    public function testGetIdTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("abc");
        $this->assertEquals("abc", $idtype->value());
        $this->assertEquals("", $idtype->getSchemeID());
    }

    public function testGetIdTypeWithValueAndScheme(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("abc", "0088");
        $this->assertEquals("abc", $idtype->value());
        $this->assertEquals("0088", $idtype->getSchemeID());
    }

    public function testGetIdTypeAllEmpty(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("", "");
        $this->assertNull($idtype);
    }

    public function testGetIdTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType(null, null);
        $this->assertNull($idtype);
    }

    public function testGetIdTypeEmptyValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("");
        $this->assertNull($idtype);
    }

    public function testGetIdTypeNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType(null);
        $this->assertNull($idtype);
    }

    public function testGetIdTypeEmptyValueWithScheme(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IDType
         */
        $idtype = self::$objectHelper->getIdType("", "0088");
        $this->assertNull($idtype);
    }

    public function testGetTextTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getTextType("test");
        $this->assertEquals("test", $texttype->value());
    }

    public function testGetTextTypeAllEmpty(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getTextType("");
        $this->assertNull($texttype);
    }

    public function testGetTextTypeNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getTextType(null);
        $this->assertNull($texttype);
    }

    public function testGetCodeTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getCodeType("test");
        $this->assertEquals("test", $texttype->value());
    }

    public function testGetCodeType2WithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\CodeType
         */
        $texttype = self::$objectHelper->getCodeType2("test");
        $this->assertEquals("test", $texttype->value());
        $this->assertNull($texttype->getListID());
        $this->assertNull($texttype->getListVersionID());

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\CodeType
         */
        $texttype = self::$objectHelper->getCodeType2("test", "listid");
        $this->assertEquals("test", $texttype->value());
        $this->assertEquals("listid", $texttype->getListID());
        $this->assertNull($texttype->getListVersionID());

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\CodeType
         */
        $texttype = self::$objectHelper->getCodeType2("test", "listid", "listversion");
        $this->assertEquals("test", $texttype->value());
        $this->assertEquals("listid", $texttype->getListID());
        $this->assertEquals("listversion", $texttype->getListVersionID());

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\CodeType
         */
        $texttype = self::$objectHelper->getCodeType2();
        $this->assertNull($texttype);
    }

    public function testGetCodeTypeAllEmpty(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getCodeType("");
        $this->assertNull($texttype);
    }

    public function testGetCodeTypeNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\TextType
         */
        $texttype = self::$objectHelper->getCodeType(null);
        $this->assertNull($texttype);
    }

    public function testGetIndicatorTypeWithTrueValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->getIndicatorType(true);
        $this->assertTrue($indicatortype->getIndicator());
    }

    public function testGetIndicatorTypeWithFalseValue(): void
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

    public function testGetIndicatorTypeNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\IndicatorType
         */
        $indicatortype = self::$objectHelper->getIndicatorType(null);
        $this->assertNull($indicatortype);
    }

    public function testGetNoteTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType("content", "contentcode", "subjectcode");
        $this->assertEquals("content", $notetype->getContent());
        $this->assertEquals("subjectcode", $notetype->getSubjectCode()->value());
        $this->assertEquals("contentcode", $notetype->getContentCode()->value());
    }

    public function testGetNoteTypeAllNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType(null, null, null);
        $this->assertNull($notetype);
    }

    public function testGetNoteTypeWithEmptyContent(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType("", "", "");
        $this->assertNull($notetype);
    }

    public function testGetNoteTypeWithEmptyContentButWithSubjectCode(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\NoteType
         */
        $notetype = self::$objectHelper->getNoteType("", "", "subjectcode");
        $this->assertNull($notetype);
    }

    public function testGetFormattedDateTimeType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
         */
        $datetimetype = self::$objectHelper->getFormattedDateTimeType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateTimeString());
        $this->assertEquals("102", $datetimetype->getDateTimeString()->getFormat());
    }

    public function testGetFormattedDateTimeTypeWithNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\FormattedDateTimeType
         */
        $datetimetype = self::$objectHelper->getFormattedDateTimeType(null);
        $this->assertNull($datetimetype);
    }

    public function testGetDateTimeType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType
         */
        $datetimetype = self::$objectHelper->getDateTimeType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateTimeString());
        $this->assertEquals("102", $datetimetype->getDateTimeString()->getFormat());
    }

    public function testGetDateTimeTypeWithNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateTimeType
         */
        $datetimetype = self::$objectHelper->getDateTimeType(null);
        $this->assertNull($datetimetype);
    }

    public function testGetDateType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateType
         */
        $datetimetype = self::$objectHelper->getDateType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $datetimetype->getDateString());
        $this->assertEquals("102", $datetimetype->getDateString()->getFormat());
    }

    public function testGetDateTypeWithNullValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\DateType
         */
        $datetimetype = self::$objectHelper->getDateType(null);
        $this->assertNull($datetimetype);
    }

    public function testGetAmountTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(100.0);
        $this->assertEqualsWithDelta(100.0, $amounttype->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("", $amounttype->getCurrencyID());
    }

    public function testGetAmountTypeWithValueAndCurrency(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(100.0, "EUR");
        $this->assertEqualsWithDelta(100.0, $amounttype->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("EUR", $amounttype->getCurrencyID());
    }

    public function testGetAmountTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(null, null);
        $this->assertNull($amounttype);
    }

    public function testGetAmountTypeWithValueAndEmptyCurrency(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(100, "");
        $this->assertEqualsWithDelta(100.0, $amounttype->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("", $amounttype->getCurrencyID());
    }

    public function testGetAmountTypeWithNullValueAndCurrency(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\AmountType
         */
        $amounttype = self::$objectHelper->getAmountType(null, "EUR");
        $this->assertNull($amounttype);
    }

    public function testGetPercentTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $percenttype = self::$objectHelper->getPercentType(100.0);
        $this->assertEqualsWithDelta(100.0, $percenttype->value(), PHP_FLOAT_EPSILON);
    }

    public function testGetPercentTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $percenttype = self::$objectHelper->getPercentType(null);
        $this->assertNull($percenttype);
    }

    public function testGetQuantityTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(100.0);
        $this->assertEqualsWithDelta(100.0, $quantitytype->value(), PHP_FLOAT_EPSILON);
    }

    public function testGetQuantityTypeWithValueAndUnitCode(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(100.0, "C62");
        $this->assertEqualsWithDelta(100.0, $quantitytype->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("C62", $quantitytype->getUnitCode());
    }

    public function testGetQuantityTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(null, null);
        $this->assertNull($quantitytype);
    }

    public function testGetQuantityTypeWithNullValueAndUnitCode(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\QuantityType
         */
        $quantitytype = self::$objectHelper->getQuantityType(null, "C62");
        $this->assertNull($quantitytype);
    }

    public function testGetMeasureTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(100.0);
        $this->assertEqualsWithDelta(100.0, $measuretype->value(), PHP_FLOAT_EPSILON);
    }

    public function testGetMeasureTypeWithValueAndUnitCode(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(100.0, "DAY");
        $this->assertEqualsWithDelta(100.0, $measuretype->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("DAY", $measuretype->getUnitCode());
    }

    public function testGetMeasureTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(null, null);
        $this->assertNull($measuretype);
    }

    public function testGetMeasureTypeWithNullValueAndUnitCode(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\MeasureType
         */
        $measuretype = self::$objectHelper->getMeasureType(null, "DAY");
        $this->assertNull($measuretype);
    }

    public function testGetNumericTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $numerictype = self::$objectHelper->getNumericType(100.0);
        $this->assertEquals(100, $numerictype->value());
    }

    public function testGetNumericTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $numerictype = self::$objectHelper->getNumericType(null);
        $this->assertNull($numerictype);
    }

    public function testGetTaxCategoryCodeTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\TaxCategoryCodeType
         */
        $taxcategorycodetype = self::$objectHelper->getTaxCategoryCodeType("VAT");
        $this->assertEquals("VAT", $taxcategorycodetype->value());
    }

    public function testGetTaxCategoryCodeTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\TaxCategoryCodeType
         */
        $taxcategorycodetype = self::$objectHelper->getTaxCategoryCodeType(null);
        $this->assertNull($taxcategorycodetype);
    }

    public function testGetTaxTypeCodeTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->getTaxTypeCodeType("S");
        $this->assertEquals("S", $taxtypecodetype->value());
    }

    public function testGetTaxTypeCodeTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\TaxTypeCodeType
         */
        $taxtypecodetype = self::$objectHelper->getTaxTypeCodeType(null);
        $this->assertNull($taxtypecodetype);
    }

    public function testGetTimeReferenceCodeTypeWithValue(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\TimeReferenceCodeType
         */
        $timereferencecodetype = self::$objectHelper->getTimeReferenceCodeType("REF");
        $this->assertEquals("REF", $timereferencecodetype->value());
    }

    public function testGetTimeReferenceCodeTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\TimeReferenceCodeType
         */
        $timereferencecodetype = self::$objectHelper->getTimeReferenceCodeType(null);
        $this->assertNull($timereferencecodetype);
    }

    public function testGetSpecifiedPeriodTypeAllValues(): void
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

    public function testGetSpecifiedPeriodTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SpecifiedPeriodType
         */
        $periodtype = self::$objectHelper->getSpecifiedPeriodType(null, null, null, null);
        $this->assertNull($periodtype);
    }

    public function testGetBinaryObjectTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType("data", "application/pdf", "mypdf.pdf");
        $this->assertEquals("data", $binaryobject->value());
        $this->assertEquals("application/pdf", $binaryobject->getMimeCode());
        $this->assertEquals("mypdf.pdf", $binaryobject->getFilename());
    }

    public function testGetBinaryObjectTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType(null, null, null);
        $this->assertNull($binaryobject);
    }

    public function testGetBinaryObjectTypeDataNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType(null, "application/pdf", "mypdf.pdf");
        $this->assertNull($binaryobject);
    }

    public function testGetBinaryObjectTypeMimeTypeNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType("data", null, "mypdf.pdf");
        $this->assertNull($binaryobject);
    }

    public function testGetBinaryObjectTypeFilenameNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\BinaryObjectType
         */
        $binaryobject = self::$objectHelper->getBinaryObjectType("data", "application/pdf", null);
        $this->assertNull($binaryobject);
    }

    public function testGetReferencedDocumentTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
         */
        $refdoctype = self::$objectHelper->getReferencedDocumentType("issuerid", "uriid", "lineid", "typecode", "name", "reftypcode", new \DateTime(), __DIR__ . "/../assets/xml_en16931_2.xml");
        $this->assertEquals("issuerid", $refdoctype->getIssuerAssignedID()->value());
        $this->assertEquals("uriid", $refdoctype->getURIID()->value());
        $this->assertEquals("lineid", $refdoctype->getLineID()->value());
        $this->assertEquals("typecode", $refdoctype->getTypeCode());
        $this->assertEquals("name", $refdoctype->getName());
        $this->assertEquals("reftypcode", $refdoctype->getReferenceTypeCode());
        $this->assertEquals((new \DateTime())->format("Ymd"), $refdoctype->getFormattedIssueDateTime()->getDateTimeString());
        $this->assertEquals("102", $refdoctype->getFormattedIssueDateTime()->getDateTimeString()->getFormat());
    }

    public function testGetReferencedDocumentTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedDocumentType
         */
        $refdoctype = self::$objectHelper->getReferencedDocumentType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($refdoctype);
    }

    public function testCrossIndustryInvoice(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice
         */
        $crossindusty = self::$objectHelper->getCrossIndustryInvoice();
        $this->assertNotNull($crossindusty);
    }

    public function testGetTradePartyAllValues(): void
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

    public function testGetTradePartyNullValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->getTradeParty(null, null, null);
        $this->assertNull($tradeparty);
    }

    public function testGetTradePartyAllValuesWithAllowEmpty(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->getTradePartyAllowEmpty("name", "id", "description");
        $this->assertEquals("name", $tradeparty->getName());
        $this->assertIsArray($tradeparty->getID());
        $this->assertArrayHasKey(0, $tradeparty->getID());
        $this->assertEquals("id", $tradeparty->getID()[0]);
        $this->assertEquals("description", $tradeparty->getDescription());
    }

    public function testGetTradePartyNullValuesWithAllowEmpty(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePartyType
         */
        $tradeparty = self::$objectHelper->getTradePartyAllowEmpty(null, null, null);
        $this->assertNotNull($tradeparty);
        $this->assertNull($tradeparty->getName());
        $this->assertEquals("", $tradeparty->getName());
        $this->assertIsArray($tradeparty->getID());
        $this->assertArrayNotHasKey(0, $tradeparty->getID());
        $this->assertNull($tradeparty->getDescription());
        $this->assertEquals("", $tradeparty->getDescription());
    }

    public function testGetTradeAddressAllValues(): void
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
        $this->assertEquals("county", $tradeaddress->getCountrySubDivisionName());
    }

    public function testGetTradeAddressAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAddressType
         */
        $tradeaddress = self::$objectHelper->getTradeAddress(null, null, null, null, null, null, null);
        $this->assertNull($tradeaddress);
    }

    public function testGetLegalOrganizationAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LegalOrganizationType
         */
        $legalorg = self::$objectHelper->getLegalOrganization("orgid", "orgtype", "orgname");
        $this->assertEquals("orgid", $legalorg->getID());
        $this->assertEquals("orgtype", $legalorg->getID()->getSchemeID());
        $this->assertEquals("orgname", $legalorg->getTradingBusinessName());
    }

    public function testGetLegalOrganizationAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LegalOrganizationType
         */
        $legalorg = self::$objectHelper->getLegalOrganization(null, null, null);
        $this->assertNull($legalorg);
    }

    public function testGetTradeContactAllValues(): void
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

    public function testGetTradeContactAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeContactType
         */
        $tradecontact = self::$objectHelper->getTradeContact(null, null, null, null, null, null);
        $this->assertNull($tradecontact);
    }

    public function testGetUniversalCommunicationTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType
         */
        $commtype = self::$objectHelper->getUniversalCommunicationType("number", "uriid", "smtp");
        $this->assertEquals("number", $commtype->getCompleteNumber());
        $this->assertEquals("uriid", $commtype->getURIID());
        $this->assertEquals("smtp", $commtype->getURIID()->getSchemeID());
    }

    public function testGetUniversalCommunicationTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\UniversalCommunicationType
         */
        $commtype = self::$objectHelper->getUniversalCommunicationType(null, null, null);
        $this->assertNull($commtype);
    }

    public function testGetTaxRegistrationTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType("taxregtype", "taxid");
        $this->assertEquals("taxregtype", $taxregtype->getID()->getSchemeID());
        $this->assertEquals("taxid", $taxregtype->getID());
    }

    public function testGetTaxRegistrationTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType(null, null);
        $this->assertNull($taxregtype);
    }

    public function testGetTaxRegistrationTypeIdNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType("taxregtype", null);
        $this->assertNull($taxregtype);
    }

    public function testGetTaxRegistrationTypeTypeNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TaxRegistrationType
         */
        $taxregtype = self::$objectHelper->getTaxRegistrationType(null, "taxid");
        $this->assertNull($taxregtype);
    }

    public function testGetTradeDeliveryTermsTypeCodeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\DeliveryTermsCodeType
         */
        $devterms = self::$objectHelper->getTradeDeliveryTermsCodeType('code');
        $this->assertEquals("code", $devterms->value());
    }

    public function testGetTradeDeliveryTermsTypeCodeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\qdt\DeliveryTermsCodeType
         */
        $devterms = self::$objectHelper->getTradeDeliveryTermsCodeType(null);
        $this->assertNull($devterms);
    }

    public function testGetTradeDeliveryTermsTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType
         */
        $devterms = self::$objectHelper->getTradeDeliveryTermsType('code');
        $this->assertEquals("code", $devterms->getDeliveryTypeCode());
    }

    public function testGetTradeDeliveryTermsTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeDeliveryTermsType
         */
        $devterms = self::$objectHelper->getTradeDeliveryTermsType(null);
        $this->assertNull($devterms);
    }

    public function testGetProcuringProjectTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType("projectid", "projectname");
        $this->assertEquals("projectid", $project->getID());
        $this->assertEquals("projectname", $project->getName());
    }

    public function testGetProcuringProjectTypeIdNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType(null, "projectname");
        $this->assertNull($project);
    }

    public function testGetProcuringProjectTypeNameNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType("projectid", null);
        $this->assertNull($project);
    }

    public function testGetProcuringProjectTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProcuringProjectType
         */
        $project = self::$objectHelper->getProcuringProjectType(null, null);
        $this->assertNull($project);
    }

    public function testGetSupplyChainEventTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType
         */
        $supplychainevent = self::$objectHelper->getSupplyChainEventType(new \DateTime());
        $this->assertEquals((new \DateTime())->format("Ymd"), $supplychainevent->getOccurrenceDateTime()->getDateTimeString());
        $this->assertEquals("102", $supplychainevent->getOccurrenceDateTime()->getDateTimeString()->getFormat());
    }

    public function testGetSupplyChainEventTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainEventType
         */
        $supplychainevent = self::$objectHelper->getSupplyChainEventType(null);
        $this->assertNull($supplychainevent);
    }

    public function testGetTradeSettlementFinancialCardTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType
         */
        $fincard = self::$objectHelper->getTradeSettlementFinancialCardType("type", "6759 6498 2643 8453", "name");
        $this->assertEquals("type", $fincard->getID()->getSchemeID());
        $this->assertEquals("6759 68453", $fincard->getID());
        $this->assertEquals("name", $fincard->getCardholderName());
    }

    public function testGetTradeSettlementFinancialCardTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementFinancialCardType
         */
        $fincard = self::$objectHelper->getTradeSettlementFinancialCardType(null, null, null);
        $this->assertNull($fincard);
    }

    public function testGetDebtorFinancialAccountTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType
         */
        $finacc = self::$objectHelper->getDebtorFinancialAccountType("iban");
        $this->assertEquals("iban", $finacc->getIBANID());
    }

    public function testGetDebtorFinancialAccountTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DebtorFinancialAccountType
         */
        $finacc = self::$objectHelper->getDebtorFinancialAccountType(null);
        $this->assertNull($finacc);
    }

    public function testGetCreditorFinancialAccountTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType
         */
        $finacc = self::$objectHelper->getCreditorFinancialAccountType("iban", "accname", "propid");
        $this->assertEquals("iban", $finacc->getIBANID());
        $this->assertEquals("accname", $finacc->getAccountName());
        $this->assertEquals("propid", $finacc->getProprietaryID());
    }

    public function testGetCreditorFinancialAccountTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialAccountType
         */
        $finacc = self::$objectHelper->getCreditorFinancialAccountType(null, null, null);
        $this->assertNull($finacc);
    }

    public function testGetCreditorFinancialInstitutionTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType
         */
        $fininst = self::$objectHelper->getCreditorFinancialInstitutionType("bic");
        $this->assertEquals("bic", $fininst->getBICID());
    }

    public function testGetCreditorFinancialInstitutionTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\CreditorFinancialInstitutionType
         */
        $fininst = self::$objectHelper->getCreditorFinancialInstitutionType(null);
        $this->assertNull($fininst);
    }

    public function testGetTradeSettlementPaymentMeansTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType
         */
        $paymentmeans = self::$objectHelper->getTradeSettlementPaymentMeansType("code", "info");
        $this->assertEquals("code", $paymentmeans->getTypeCode());
    }

    public function testGetTradeSettlementPaymentMeansTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementPaymentMeansType
         */
        $paymentmeans = self::$objectHelper->getTradeSettlementPaymentMeansType(null, null);
        $this->assertNull($paymentmeans);
    }

    public function testGetTradePaymentTermsTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentTermsType
         */
        $paymentterms = self::$objectHelper->getTradePaymentTermsType("description", new \DateTime(), "mandate");
        $this->assertEquals((new \DateTime())->format("Ymd"), $paymentterms->getDueDateDateTime()->getDateTimeString());
        $this->assertEquals("102", $paymentterms->getDueDateDateTime()->getDateTimeString()->getFormat());
    }

    public function testGetTradePaymentTermsTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentTermsType
         */
        $paymentmeans = self::$objectHelper->getTradePaymentTermsType(null, null, null);
        $this->assertNull($paymentmeans);
    }

    public function testGetTradePaymentDiscountTermsTypeAllValues(): void
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

    public function testGetTradePaymentDiscountTermsTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentDiscountTermsType
         */
        $discountterms = self::$objectHelper->getTradePaymentDiscountTermsType(null, null, null, null, null, null);
        $this->assertNull($discountterms);
    }

    public function testGetTradePaymentPenaltyTermsTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentPenaltyTermsType
         */
        $penaltyterms = self::$objectHelper->getTradePaymentPenaltyTermsType(new \DateTime(), 2, "DAY", 1, 1, 1);

        /**
         * @var \horstoeko\zugferd\entities\extended\udt\PercentType
         */
        $calculationpercent = $penaltyterms->getCalculationPercent();

        $this->assertEquals((new \DateTime())->format("Ymd"), $penaltyterms->getBasisDateTime()->getDateTimeString());
        $this->assertEquals("102", $penaltyterms->getBasisDateTime()->getDateTimeString()->getFormat());
        $this->assertEquals(2, $penaltyterms->getBasisPeriodMeasure()->value());
        $this->assertEquals("DAY", $penaltyterms->getBasisPeriodMeasure()->getUnitCode());
        $this->assertEquals(1, $penaltyterms->getBasisAmount()->value());
        $this->assertEquals(1, $calculationpercent->value());
        $this->assertEquals(1, $penaltyterms->getActualPenaltyAmount()->value());
    }

    public function testGetTradePaymentPenaltyTermsTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePaymentPenaltyTermsType
         */
        $penaltyterms = self::$objectHelper->getTradePaymentPenaltyTermsType(null, null, null, null, null, null);
        $this->assertNull($penaltyterms);
    }

    public function testGetTradeTaxTypeAllValues(): void
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
        $this->assertEqualsWithDelta(100.0, $tax->getBasisAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(19.0, $tax->getCalculatedAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(19.0, $rateapplicablepercent->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("reasoncode", $tax->getExemptionReasonCode());
        $this->assertEquals("reason", $tax->getExemptionReason());
        $this->assertEquals(100, $tax->getLineTotalBasisAmount()->value());
        $this->assertEquals(10, $tax->getAllowanceChargeBasisAmount()->value());
    }

    public function testGetTradeTaxTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeTaxType
         */
        $tax = self::$objectHelper->getTradeTaxType(null, null, null, null, null, null, null, null, null, null, null);
        $this->assertNull($tax);
    }

    public function testGetTradeAllowanceChargeTypeAllValues(): void
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
         * @var \horstoeko\zugferd\entities\extended\udt\NumericType
         */
        $sequenceNumeric = $allowancecharge->getCalculationPercent();

        $this->assertEqualsWithDelta(10.0, $allowancecharge->getActualAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertTrue($allowancecharge->getChargeIndicator()->getIndicator());
        $this->assertEquals("taxtype", $allowancecharge->getCategoryTradeTax()->getTypeCode());
        $this->assertEquals("taxcategory", $allowancecharge->getCategoryTradeTax()->getCategoryCode());
        $this->assertEqualsWithDelta(19.0, $rateapplicablepercent->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals(2, $sequenceNumeric->value());
        $this->assertEqualsWithDelta(2.0, $calculationpercent->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(1.0, $allowancecharge->getBasisQuantity()->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("C62", $allowancecharge->getBasisQuantity()->getUnitCode());
        $this->assertEquals("reason", $allowancecharge->getReason());
        $this->assertEquals("reasoncode", $allowancecharge->getReasonCode());
    }

    public function testGetTradeAllowanceChargeTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAllowanceChargeType
         */
        $allowancecharge = self::$objectHelper->getTradeAllowanceChargeType(null, null, null, null, null, null, null, null, null, null, null, null);
        $this->assertNull($allowancecharge);
    }

    public function testGetLogisticsServiceChargeTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LogisticsServiceChargeType
         */
        $logcharge = self::$objectHelper->getLogisticsServiceChargeType("description", 10.0, ["taxtype"], ["taxcategpry"], [19]);
        $this->assertEquals("description", $logcharge->getDescription());
        $this->assertEqualsWithDelta(10.0, $logcharge->getAppliedAmount()->value(), PHP_FLOAT_EPSILON);
    }

    public function testGetLogisticsServiceChargeTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\LogisticsServiceChargeType
         */
        $logcharge = self::$objectHelper->getLogisticsServiceChargeType(null, null, null, null, null);
        $this->assertNull($logcharge);
    }

    public function testGetTradeSettlementHeaderMonetarySummationTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementHeaderMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementHeaderMonetarySummationType(119, 100, 100, 1, 2, 99, 99 * 0.19, 0.0, 10);
        $this->assertEqualsWithDelta(119.0, $summation->getGrandTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(100.0, $summation->getDuePayableAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(100.0, $summation->getLineTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(1.0, $summation->getChargeTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(2.0, $summation->getAllowanceTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(99.0, $summation->getTaxBasisTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertIsArray($summation->getTaxTotalAmount());
        $this->assertArrayHasKey(0, $summation->getTaxTotalAmount());
        $this->assertEquals(99.0 * 0.19, $summation->getTaxTotalAmount()[0]->value());
        $this->assertEqualsWithDelta(0.0, $summation->getRoundingAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(10.0, $summation->getTotalPrepaidAmount()->value(), PHP_FLOAT_EPSILON);
    }

    public function testGetTradeSettlementHeaderMonetarySummationTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementHeaderMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementHeaderMonetarySummationType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($summation);
    }

    public function testGetTradeSettlementHeaderMonetarySummationTypeOnly(): void
    {
        $summation = self::$objectHelper->getTradeSettlementHeaderMonetarySummationTypeOnly();
        $this->assertNotNull($summation);
    }

    public function testGetTradeAccountingAccountTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAccountingAccountType
         */
        $accaccount = self::$objectHelper->getTradeAccountingAccountType("accid", "acctype");
        $this->assertEquals("accid", $accaccount->getID());
        $this->assertEquals("acctype", $accaccount->getTypeCode());
    }

    public function testGetTradeAccountingAccountTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeAccountingAccountType
         */
        $accaccount = self::$objectHelper->getTradeAccountingAccountType(null, null);
        $this->assertNull($accaccount);
    }

    public function testGetDocumentLineDocumentTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DocumentLineDocumentType
         */
        $doclinedoctype = self::$objectHelper->getDocumentLineDocumentType("lineid");
        $this->assertEquals("lineid", $doclinedoctype->getLineID());
    }

    public function testGetDocumentLineDocumentTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\DocumentLineDocumentType
         */
        $doclinedoctype = self::$objectHelper->getDocumentLineDocumentType(null);
        $this->assertNull($doclinedoctype);
    }

    public function testGetSupplyChainTradeLineItemTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainTradeLineItemType
         */
        $line = self::$objectHelper->getSupplyChainTradeLineItemType("lineid", "linestatuscode", "linestatusreasoncode");
        $this->assertNotNull($line);
        $this->assertEquals("lineid", $line->getAssociatedDocumentLineDocument()->getLineID());
    }

    public function testGetSupplyChainTradeLineItemTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\SupplyChainTradeLineItemType
         */
        $line = self::$objectHelper->getSupplyChainTradeLineItemType(null, null, null);
        $this->assertNull($line);
    }

    public function testGetTradeProductTypeAllValues(): void
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

    public function testGetTradeProductTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeProductType
         */
        $product = self::$objectHelper->getTradeProductType(null, null, null, null, null, null);
        $this->assertNull($product);
    }

    public function testGetProductCharacteristicType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProductCharacteristicType
         */
        $productCharacteristic = self::$objectHelper->getProductCharacteristicType("typecode", "description", 10.2, "valuemeasureunit", "value");
        $this->assertEquals("description", $productCharacteristic->getDescription());
        $this->assertEquals("value", $productCharacteristic->getValue());
        $this->assertEqualsWithDelta(10.2, $productCharacteristic->getValueMeasure()->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("valuemeasureunit", $productCharacteristic->getValueMeasure()->getUnitCode());
        $this->assertEquals("typecode", $productCharacteristic->getTypeCode()->value());
    }

    public function testGetProductClassificationType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProductClassificationType
         */
        $productClassification = self::$objectHelper->getProductClassificationType("classcode", "classname", "listid", "listversionid");
        $this->assertEquals("classcode", $productClassification->getClassCode()->value());
        $this->assertEquals("listid", $productClassification->getClassCode()->getListID());
        $this->assertEquals("listversionid", $productClassification->getClassCode()->getListVersionID());
        $this->assertEquals("classname", $productClassification->getClassName());

        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ProductCharacteristicType
         */
        $productCharacteristic = self::$objectHelper->getProductCharacteristicType();
        $this->assertNull($productCharacteristic);
    }

    public function testGetReferencedProductType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedProductType
         */
        $referencedProduct = self::$objectHelper->getReferencedProductType("globalid", "globalidtype", "sellerid", "buyerid", "industryid", "name", "description", 10, "C62");
        $this->assertEquals("globalid", $referencedProduct->getGlobalID()[0]->value());
        $this->assertEquals("globalidtype", $referencedProduct->getGlobalID()[0]->getSchemeID());
        $this->assertEquals("sellerid", $referencedProduct->getSellerAssignedID()->value());
        $this->assertEquals("buyerid", $referencedProduct->getBuyerAssignedID()->value());
        $this->assertEquals("industryid", $referencedProduct->getIndustryAssignedID()->value());
        $this->assertEquals("name", $referencedProduct->getName());
        $this->assertEquals("description", $referencedProduct->getDescription());
        $this->assertEquals(10, $referencedProduct->getUnitQuantity()->value());
        $this->assertEquals("C62", $referencedProduct->getUnitQuantity()->getUnitCode());

        /**
         * @var \horstoeko\zugferd\entities\extended\ram\ReferencedProductType
         */
        $referencedProduct = self::$objectHelper->getReferencedProductType(null, null, null, null, null, null, null, null, null);
        $this->assertNull($referencedProduct);
    }

    public function testGetTradePriceTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePriceType
         */
        $price = self::$objectHelper->getTradePriceType(1.0, 2.0, "C62");
        $this->assertEqualsWithDelta(1.0, $price->getChargeAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(2.0, $price->getBasisQuantity()->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("C62", $price->getBasisQuantity()->getUnitCode());
    }

    public function testGetTradePriceTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradePriceType
         */
        $price = self::$objectHelper->getTradePriceType(null, null, null);
        $this->assertNull($price);
    }

    public function testGetTradeSettlementLineMonetarySummationTypeAllValues(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementLineMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementLineMonetarySummationType(1.0, 6.0, 3.0, 4.0, 5.0, 2.0);
        $this->assertEqualsWithDelta(1.0, $summation->getLineTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(6.0, $summation->getChargeTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(3.0, $summation->getAllowanceTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(4.0, $summation->getTaxTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(5.0, $summation->getGrandTotalAmount()->value(), PHP_FLOAT_EPSILON);
        $this->assertEqualsWithDelta(2.0, $summation->getTotalAllowanceChargeAmount()->value(), PHP_FLOAT_EPSILON);
    }

    public function testGetTradeSettlementLineMonetarySummationTypeAllNull(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeSettlementLineMonetarySummationType
         */
        $summation = self::$objectHelper->getTradeSettlementLineMonetarySummationType();
        $this->assertNull($summation);
    }

    public function testToDateTimeGeneral(): void
    {
        $this->assertEquals("20200202", self::$objectHelper->toDateTime("20200202", "102")->format("Ymd"));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime("", "102"));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime("20200202", ""));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime(null, "102"));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime("20200202", null));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime("", ""));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime(null, null));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime("", null));
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime(null, ""));
        $this->assertNull(self::$objectHelper->toDateTime(null, null));
        $this->expectException(ZugferdUnknownDateFormatException::class);
        $this->expectExceptionMessage("Invalid date format 999");
        $this->assertNotInstanceOf(\DateTime::class, self::$objectHelper->toDateTime("20200202", "999"));
    }

    public function testToDateTime101(): void
    {
        $this->assertEquals("20200202", self::$objectHelper->toDateTime("200202", "101")->format("Ymd"));
    }

    public function testToDateTime201(): void
    {
        $this->assertEquals("2002021031", self::$objectHelper->toDateTime("2002021031", "201")->format("ymdHi"));
    }

    public function testToDateTime202(): void
    {
        $this->assertEquals("200202103145", self::$objectHelper->toDateTime("200202103145", "202")->format("ymdHis"));
    }

    public function testToDateTime203(): void
    {
        $this->assertEquals("202002021031", self::$objectHelper->toDateTime("202002021031", "203")->format("YmdHi"));
    }

    public function testToDateTime204(): void
    {
        $this->assertEquals("20200202103145", self::$objectHelper->toDateTime("20200202103145", "204")->format("YmdHis"));
    }

    public function testGetRateType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\RateType
         */
        $rateType = self::$objectHelper->getRateType(10);
        $this->assertEquals(10, $rateType->value());
    }

    public function testGetTaxApplicableTradeCurrencyExchangeType(): void
    {
        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeCurrencyExchangeType
         */
        $currencyExchangeType = self::$objectHelper->getTaxApplicableTradeCurrencyExchangeType("EUR", "USD", 10.0, DateTime::createFromFormat("Ymd", "20180305"));
        $this->assertNotNull($currencyExchangeType);
        $this->assertEquals("EUR", $currencyExchangeType->getSourceCurrencyCode());
        $this->assertEquals("USD", $currencyExchangeType->getTargetCurrencyCode());
        /**
         * @var \horstoeko\zugferd\entities\extended\udt\RateType
         */
        $rate = $currencyExchangeType->getConversionRate();
        $this->assertEqualsWithDelta(10.0, $rate->value(), PHP_FLOAT_EPSILON);
        $this->assertEquals("20180305", $currencyExchangeType->getConversionRateDateTime()->getDateTimeString()->value());
        $this->assertEquals("102", $currencyExchangeType->getConversionRateDateTime()->getDateTimeString()->getFormat());

        /**
         * @var \horstoeko\zugferd\entities\extended\ram\TradeCurrencyExchangeType
         */
        $currencyExchangeType = self::$objectHelper->getTaxApplicableTradeCurrencyExchangeType(null, null, null, null);
        $this->assertNull($currencyExchangeType);
    }

    public function testCreateClassInstance(): void
    {
        $instance = self::$objectHelper->createClassInstance('ram\TradeProductType');
        $this->assertNotNull($instance);
        $instance = self::$objectHelper->createClassInstance('ram\LogisticsServiceChargeType');
        $this->assertNotNull($instance);
    }
}
