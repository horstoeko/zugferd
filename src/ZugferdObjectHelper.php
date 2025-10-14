<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DateTime;
use DateTimeInterface;
use horstoeko\mimedb\MimeDb;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\exception\ZugferdUnknownDateFormatException;
use horstoeko\zugferd\exception\ZugferdUnsupportedMimetype;
use horstoeko\zugferd\ZugferdProfileResolver;

/**
 * Class representing a collection of common helpers and class factories
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdObjectHelper
{
    /**
     * Internal profile id
     *
     * @var integer
     */
    public $profile = -1;

    /**
     * Internal profile definition
     *
     * @var array
     */
    public $profiledef = [];

    /**
     * A list of supported mimetypes by binaryattachments
     */
    public const SUPPORTEDTMIMETYPES = [
        "application/pdf",
        "image/png",
        "image/jpeg",
        "text/csv",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.oasis.opendocument.spreadsheet",
        "application/xml",
    ];

    /**
     * Constructor
     *
     * @param integer $profile
     */
    public function __construct(int $profile)
    {
        $this->profile = $profile;
        $this->profiledef = ZugferdProfileResolver::resolveProfileDefById($profile);
    }

    /**
     * Creates an instance of DocumentCodeType
     *
     * @param  string|null $value
     * @return object|null
     */
    public function getDocumentCodeType(?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->createClassInstance('qdt\DocumentCodeType', $value);
    }

    /**
     * Creates an instance of IDType
     *
     * @param  string|null $value
     * @param  string|null $schemeId
     * @return object
     */
    public function getIdType(?string $value = null, ?string $schemeId = null): ?object
    {
        if (self::isNullOrEmpty($value)) {
            return null;
        }

        $idType = $this->createClassInstance('udt\IDType', $value);

        $this->tryCall($idType, "setSchemeID", $schemeId);

        return $idType;
    }

    /**
     * Creates an instance of TextType
     *
     * @param  string|null $value
     * @return object
     */
    public function getTextType(?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->createClassInstance('udt\TextType', $value);
    }

    /**
     * Creates an instance of CodeType
     *
     * @param  string|null $value
     * @return object|null
     */
    public function getCodeType(?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->createClassInstance('udt\CodeType', $value);
    }

    /**
     * Creates an instance of CodeType with extended list
     * information
     *
     * @param  string|null $value
     * @param  string|null $listID
     * @param  string|null $listVersionID
     * @return object|null
     */
    public function getCodeType2(?string $value = null, ?string $listID = null, ?string $listVersionID = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $codeType = $this->createClassInstance('udt\CodeType', $value);

        $this->tryCall($codeType, 'setListID', $listID);
        $this->tryCall($codeType, 'setListVersionID', $listVersionID);

        return $codeType;
    }

    /**
     * Get indicator type
     *
     * @param  bool|null $value
     * @return object|null
     */
    public function getIndicatorType(?bool $value = null): ?object
    {
        if ($value === null) {
            return null;
        }

        $indicatorType = $this->createClassInstance('udt\IndicatorType');

        $this->tryCall($indicatorType, 'setIndicator', $value);

        return $indicatorType;
    }

    /**
     * Get Note type
     *
     * @param  string|null $content
     * @param  string|null $contentCode
     * @param  string|null $subjectCode
     * @return object|null
     */
    public function getNoteType(?string $content = null, ?string $contentCode = null, ?string $subjectCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        if (self::isNullOrEmpty($content)) {
            return null;
        }

        $noteType = $this->createClassInstance('ram\NoteType');

        $this->tryCall($noteType, 'setContentCode', $this->getCodeType($contentCode));
        $this->tryCall($noteType, 'setSubjectCode', $this->getCodeType($subjectCode));
        $this->tryCall($noteType, 'setContent', $this->getTextType($content));

        return $noteType;
    }

    /**
     * Get formatted issue date
     *
     * @param  DateTimeInterface|null $dateTime
     * @return object|null
     */
    public function getFormattedDateTimeType(?DateTimeInterface $dateTime = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $dateTimeStringAType = $this->createClassInstance('qdt\FormattedDateTimeType\DateTimeStringAType');
        $this->tryCall($dateTimeStringAType, "value", $dateTime->format("Ymd"));
        $this->tryCall($dateTimeStringAType, "setFormat", "102");

        $formattedDateTimeType = $this->createClassInstance('qdt\FormattedDateTimeType');
        $this->tryCall($formattedDateTimeType, "setDateTimeString", $dateTimeStringAType);

        return $formattedDateTimeType;
    }

    /**
     * Get formatted issue date
     *
     * @param  DateTimeInterface|null $dateTime
     * @return object|null
     */
    public function getDateTimeType(?DateTimeInterface $dateTime = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $dateTimeStringAType = $this->createClassInstance('udt\DateTimeType\DateTimeStringAType');
        $this->tryCall($dateTimeStringAType, "value", $dateTime->format("Ymd"));
        $this->tryCall($dateTimeStringAType, "setFormat", "102");

        $dateTimeType = $this->createClassInstance('udt\DateTimeType');
        $this->tryCall($dateTimeType, "setDateTimeString", $dateTimeStringAType);

        return $dateTimeType;
    }

    /**
     * Get date
     *
     * @param  DateTimeInterface|null $dateTime
     * @return object|null
     */
    public function getDateType(?DateTimeInterface $dateTime = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $dateStringAType = $this->createClassInstance('udt\DateType\DateStringAType');
        $this->tryCall($dateStringAType, "value", $dateTime->format("Ymd"));
        $this->tryCall($dateStringAType, "setFormat", "102");

        $dateType = $this->createClassInstance('udt\DateType');
        $this->tryCall($dateType, "setDateString", $dateStringAType);

        return $dateType;
    }

    /**
     * Representation of Amount
     *
     * @param  float|null  $value
     * @param  string|null $currencyCode
     * @return object|null
     */
    public function getAmountType(?float $value, ?string $currencyCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        if (self::isNullOrEmpty($value)) {
            return null;
        }

        $amountType = $this->createClassInstance('udt\AmountType');

        $this->tryCall($amountType, "value", $value);
        $this->tryCall($amountType, "setCurrencyID", $currencyCode);

        return $amountType;
    }

    /**
     * Representation of Percdnt
     *
     * @param  float|null $value
     * @return object|null
     */
    public function getPercentType(?float $value): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $percentType = $this->createClassInstance('udt\PercentType');

        $this->tryCall($percentType, "value", $value);

        return $percentType;
    }

    /**
     * Representation of Quantity
     *
     * @param  float|null  $value
     * @param  string|null $unitCode
     * @return object|null
     */
    public function getQuantityType(?float $value, ?string $unitCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        if (self::isNullOrEmpty($value)) {
            return null;
        }

        $quantityType = $this->createClassInstance('udt\QuantityType');

        $this->tryCall($quantityType, "value", $value);
        $this->tryCall($quantityType, "setUnitCode", $unitCode);

        return $quantityType;
    }

    /**
     * Representation of Quantity Measure
     *
     * @param  float|null  $value
     * @param  string|null $unitCode
     * @return object|null
     */
    public function getMeasureType(?float $value, ?string $unitCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        if (self::isNullOrEmpty($value)) {
            return null;
        }

        $measureType = $this->createClassInstance('udt\MeasureType');

        $this->tryCall($measureType, "value", $value);
        $this->tryCall($measureType, "setUnitCode", $unitCode);

        return $measureType;
    }

    /**
     * Get an instance of GetNumericType
     *
     * @param  float|null $value
     * @return object|null
     */
    public function getNumericType(?float $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $numericType = $this->createClassInstance('udt\NumericType');

        $this->tryCall($numericType, 'value', $value);

        return $numericType;
    }

    /**
     * Representation of Tax Category
     *
     * @param  string|null $taxCategoryCode
     * @return object|null
     */
    public function getTaxCategoryCodeType(?string $taxCategoryCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $taxCategoryCodeType = $this->createClassInstance('qdt\TaxCategoryCodeType');

        $this->tryCall($taxCategoryCodeType, "value", $taxCategoryCode);

        return $taxCategoryCodeType;
    }

    /**
     * Representation of Tax Type
     *
     * @param  string|null $taxTypeCode
     * @return object|null
     */
    public function getTaxTypeCodeType(?string $taxTypeCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $taxTypeCodeType = $this->createClassInstance('qdt\TaxTypeCodeType');

        $this->tryCall($taxTypeCodeType, "value", $taxTypeCode);

        return $taxTypeCodeType;
    }

    /**
     * Representation of Time Reference Code
     *
     * @param  string|null $value
     * @return object|null
     */
    public function getTimeReferenceCodeType(?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $timeReferenceCodeType = $this->createClassInstance('qdt\TimeReferenceCodeType');

        $this->tryCall($timeReferenceCodeType, "value", $value);

        return $timeReferenceCodeType;
    }

    /**
     * Get Specified Period type
     *
     * @param  DateTimeInterface|null $startDate
     * @param  DateTimeInterface|null $endDate
     * @param  DateTimeInterface|null $completeDate
     * @param  string|null            $description
     * @return object|null
     */
    public function getSpecifiedPeriodType(?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null, ?DateTimeInterface $completeDate = null, ?string $description = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $specifiedPeriodType = $this->createClassInstance('ram\SpecifiedPeriodType');

        $this->tryCall($specifiedPeriodType, 'setDescription', $this->getTextType($description));
        $this->tryCall($specifiedPeriodType, 'setStartDateTime', $this->getDateTimeType($startDate));
        $this->tryCall($specifiedPeriodType, 'setEndDateTime', $this->getDateTimeType($endDate));
        $this->tryCall($specifiedPeriodType, 'setCompleteDateTime', $this->getDateTimeType($completeDate));

        return $specifiedPeriodType;
    }

    /**
     * Get a BinaryObjectType object
     *
     * @param  string|null $binaryData
     * @param  string|null $mimetype
     * @param  string|null $filename
     * @return object|null
     */
    public function getBinaryObjectType(?string $binaryData = null, ?string $mimetype = null, ?string $filename = null): ?object
    {
        if (self::isNullOrEmpty($binaryData) || self::isNullOrEmpty($mimetype) || self::isNullOrEmpty($filename)) {
            return null;
        }

        $binaryObjectType = $this->createClassInstance('udt\BinaryObjectType');

        $this->tryCall($binaryObjectType, "value", $binaryData);
        $this->tryCall($binaryObjectType, "setMimeCode", $mimetype);
        $this->tryCall($binaryObjectType, "setFilename", $filename);

        return $binaryObjectType;
    }

    /**
     * Get a reference document object
     *
     * @param  string|null            $issuerAssignedId
     * @param  string|null            $uriId
     * @param  string|null            $lineId
     * @param  string|null            $typeCode
     * @param  string|array|null      $name
     * @param  string|null            $refTypeCode
     * @param  DateTimeInterface|null $issueDate
     * @param  string|null            $binaryDataFilename
     * @return object|null
     */
    public function getReferencedDocumentType(?string $issuerAssignedId = null, ?string $uriId = null, ?string $lineId = null, ?string $typeCode = null, $name = null, ?string $refTypeCode = null, ?DateTimeInterface $issueDate = null, ?string $binaryDataFilename = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $referencedDocumentType = $this->createClassInstance('ram\ReferencedDocumentType', $issuerAssignedId);

        $this->tryCall($referencedDocumentType, 'setIssuerAssignedID', $this->getIdType($issuerAssignedId));
        $this->tryCall($referencedDocumentType, 'setURIID', $this->getIdType($uriId));
        $this->tryCall($referencedDocumentType, 'setLineID', $this->getIdType($lineId));
        $this->tryCall($referencedDocumentType, 'setTypeCode', $this->getCodeType($typeCode));
        $this->tryCall($referencedDocumentType, 'setReferenceTypeCode', $this->getCodeType($refTypeCode));
        $this->tryCall($referencedDocumentType, 'setFormattedIssueDateTime', $this->getFormattedDateTimeType($issueDate));

        foreach ($this->ensureStringArray($name) as $name) {
            $this->tryCallAll($referencedDocumentType, ['addToName', 'setName'], $this->getTextType($name));
        }

        if (StringUtils::stringIsNullOrEmpty($binaryDataFilename) === false && FileUtils::fileExists($binaryDataFilename)) {
            $mimeDb = new MimeDb();
            $mimeTypes = $mimeDb->findAllMimeTypesByExtension(FileUtils::getFileExtension($binaryDataFilename));
            if (!is_null($mimeTypes)) {
                $mimeTypesSupported = array_intersect($mimeTypes, self::SUPPORTEDTMIMETYPES);
                if ($mimeTypesSupported !== []) {
                    $content = FileUtils::fileToBase64($binaryDataFilename);
                    $this->tryCall(
                        $referencedDocumentType,
                        'setAttachmentBinaryObject',
                        $this->getBinaryObjectType($content, $mimeTypesSupported[0], FileUtils::getFilenameWithExtension($binaryDataFilename))
                    );
                } else {
                    throw new ZugferdUnsupportedMimetype();
                }
            } else {
                throw new ZugferdUnsupportedMimetype();
            }
        }

        return $referencedDocumentType;
    }

    /**
     * Get instance of CountryID
     *
     * @param  string|null $id
     * @return object|null
     */
    public function getCountryIDType(?string $id = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->createClassInstance('qdt\CountryIDType', $id);
    }

    /**
     * Get instance of TradeCountry
     *
     * @param  string|null $id
     * @return object|null
     */
    public function getTradeCountryType(?string $id = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeCountryType = $this->createClassInstance('ram\TradeCountryType');

        $this->tryCall($tradeCountryType, 'setID', $this->getCountryIDType($id));

        return $tradeCountryType;
    }

    /**
     * Return the main invoice object
     *
     * @return \horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice
     */
    public function getCrossIndustryInvoice()
    {
        $crossIndustryInvoice = $this->createClassInstance('rsm\CrossIndustryInvoice');

        $crossIndustryInvoice->setExchangedDocumentContext($this->createClassInstance('ram\ExchangedDocumentContextType'));
        $crossIndustryInvoice->setExchangedDocument($this->createClassInstance('ram\ExchangedDocumentType'));
        $crossIndustryInvoice->setSupplyChainTradeTransaction($this->createClassInstance('ram\SupplyChainTradeTransactionType'));
        $crossIndustryInvoice->getExchangedDocumentContext()->setGuidelineSpecifiedDocumentContextParameter($this->createClassInstance('ram\DocumentContextParameterType'));
        $crossIndustryInvoice->getExchangedDocumentContext()->getGuidelineSpecifiedDocumentContextParameter()->setID($this->getIdType($this->profiledef['contextparameter']));
        if ($this->profiledef['businessprocess']) {
            $crossIndustryInvoice->getExchangedDocumentContext()->setBusinessProcessSpecifiedDocumentContextParameter($this->createClassInstance('ram\DocumentContextParameterType'));
            $crossIndustryInvoice->getExchangedDocumentContext()->getBusinessProcessSpecifiedDocumentContextParameter()->setID($this->getIdType($this->profiledef['businessprocess']));
        }

        $crossIndustryInvoice->getSupplyChainTradeTransaction()->setApplicableHeaderTradeAgreement($this->createClassInstance('ram\HeaderTradeAgreementType'));
        $crossIndustryInvoice->getSupplyChainTradeTransaction()->setApplicableHeaderTradeDelivery($this->createClassInstance('ram\HeaderTradeDeliveryType'));
        $crossIndustryInvoice->getSupplyChainTradeTransaction()->setApplicableHeaderTradeSettlement($this->createClassInstance('ram\HeaderTradeSettlementType'));

        return $crossIndustryInvoice;
    }

    /**
     * Tradeparty type
     *
     * @param  string|null $name
     * @param  string|null $id
     * @param  string|null $description
     * @return object|null
     */
    public function getTradeParty(?string $name = null, ?string $id = null, ?string $description = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->getTradePartyAllowEmpty($name, $id, $description);
    }

    /**
     * Tradeparty type (allow all nulls)
     *
     * @param  string|null $name
     * @param  string|null $id
     * @param  string|null $description
     * @return object|null
     */
    public function getTradePartyAllowEmpty(?string $name = null, ?string $id = null, ?string $description = null): ?object
    {
        $tradePartyType = $this->createClassInstance('ram\TradePartyType');

        $this->tryCall($tradePartyType, "addToID", $this->getIdType($id));
        $this->tryCall($tradePartyType, "setName", $this->getTextType($name));
        $this->tryCall($tradePartyType, "setDescription", $this->getTextType($description));

        return $tradePartyType;
    }

    /**
     * Address type
     *
     * @param  string|null $lineOne
     * @param  string|null $lineTwo
     * @param  string|null $lineThree
     * @param  string|null $postCode
     * @param  string|null $city
     * @param  string|null $country
     * @param  string|null $subDivision
     * @return object|null
     */
    public function getTradeAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeAddressType = $this->createClassInstance('ram\TradeAddressType');

        $this->tryCall($tradeAddressType, "setLineOne", $this->getTextType($lineOne));
        $this->tryCall($tradeAddressType, "setLineTwo", $this->getTextType($lineTwo));
        $this->tryCall($tradeAddressType, "setLineThree", $this->getTextType($lineThree));
        $this->tryCall($tradeAddressType, "setPostcodeCode", $this->getCodeType($postCode));
        $this->tryCall($tradeAddressType, "setCityName", $this->getTextType($city));
        $this->tryCall($tradeAddressType, "setCountryID", $this->getCountryIDType($country));
        $this->tryCall($tradeAddressType, "setCountrySubDivisionName", $this->getTextType($subDivision));

        return $tradeAddressType;
    }

    /**
     * Legal organization type
     *
     * @param  string|null $legalOrgId
     * @param  string|null $legalOrgType
     * @param  string|null $legalOrgName
     * @return object|null
     */
    public function getLegalOrganization(?string $legalOrgId = null, ?string $legalOrgType = null, ?string $legalOrgName = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $legalOrganizationType = $this->createClassInstance('ram\LegalOrganizationType', $legalOrgName);

        $this->tryCall($legalOrganizationType, "setID", $this->getIdType($legalOrgId, $legalOrgType));
        $this->tryCall($legalOrganizationType, "setTradingBusinessName", $this->getTextType($legalOrgName));

        return $legalOrganizationType;
    }

    /**
     * Contact type
     *
     * @param  string|null $contactPersonName
     * @param  string|null $contactDepartmentName
     * @param  string|null $contactPhoneNo
     * @param  string|null $contactFaxNo
     * @param  string|null $contactEmailAddress
     * @return object|null
     */
    public function getTradeContact(?string $contactPersonName = null, ?string $contactDepartmentName = null, ?string $contactPhoneNo = null, ?string $contactFaxNo = null, ?string $contactEmailAddress = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeContactType = $this->createClassInstance('ram\TradeContactType', $contactPersonName);

        $contactPhoneNo = $this->getUniversalCommunicationType($contactPhoneNo, null, null);
        $contactFaxNo = $this->getUniversalCommunicationType($contactFaxNo, null, null);
        $contactEmailAddress = $this->getUniversalCommunicationType(null, $contactEmailAddress);

        $this->tryCall($tradeContactType, "setPersonName", $this->getTextType($contactPersonName));
        $this->tryCall($tradeContactType, "setDepartmentName", $this->getTextType($contactDepartmentName));
        $this->tryCall($tradeContactType, "setTelephoneUniversalCommunication", $contactPhoneNo);
        $this->tryCall($tradeContactType, "setFaxUniversalCommunication", $contactFaxNo);
        $this->tryCall($tradeContactType, "setEmailURIUniversalCommunication", $contactEmailAddress);

        return $tradeContactType;
    }

    /**
     * Communication type
     *
     * @param  string|null $number
     * @param  string|null $uriId
     * @param  string|null $uriScheme
     * @return object|null
     */
    public function getUniversalCommunicationType(?string $number = null, ?string $uriId = null, ?string $uriScheme = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $communicationType = $this->createClassInstance('ram\UniversalCommunicationType');

        $this->tryCall($communicationType, "setCompleteNumber", $this->getTextType($number));
        $this->tryCall($communicationType, "setURIID", $this->getIdType($uriId, $uriScheme));

        return $communicationType;
    }

    /**
     * Tax registration type
     *
     * @param  string|null $taxRegType
     * @param  string|null $taxRegId
     * @return object|null
     */
    public function getTaxRegistrationType(?string $taxRegType = null, ?string $taxRegId = null): ?object
    {
        if (self::isNullOrEmpty($taxRegType)) {
            return null;
        }

        if (self::isNullOrEmpty($taxRegId)) {
            return null;
        }

        $taxRegistrationType = $this->createClassInstance('ram\TaxRegistrationType');

        $this->tryCall($taxRegistrationType, "setID", $this->getIdType($taxRegId, $taxRegType));

        return $taxRegistrationType;
    }

    /**
     * Delivery terms type
     *
     * @param  string|null $code
     * @return object|null
     */
    public function getTradeDeliveryTermsType(?string $code = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeDeliveryTermsType = $this->createClassInstance('ram\TradeDeliveryTermsType');

        $this->tryCall($tradeDeliveryTermsType, "setDeliveryTypeCode", $this->getTradeDeliveryTermsCodeType($code));

        return $tradeDeliveryTermsType;
    }

    /**
     * Delivery terms code type
     *
     * @param  string|null $code
     * @return object|null
     */
    public function getTradeDeliveryTermsCodeType(?string $code = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->createClassInstance('qdt\DeliveryTermsCodeType', $code);
    }

    /**
     * Procuring project type
     *
     * @param  string|null $id
     * @param  string|null $name
     * @return object|null
     */
    public function getProcuringProjectType(?string $id = null, ?string $name = null): ?object
    {
        if (self::isOneNullOrEmpty(func_get_args())) {
            return null;
        }

        $procuringProjectType = $this->createClassInstance('ram\ProcuringProjectType');

        $this->tryCall($procuringProjectType, "setID", $this->getIdType($id));
        $this->tryCall($procuringProjectType, "setName", $this->getTextType($name));

        return $procuringProjectType;
    }

    /**
     * Undocumented function
     *
     * @param  DateTimeInterface|null $date
     * @return object|null
     */
    public function getSupplyChainEventType(?DateTimeInterface $date = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $supplyChainEventType = $this->createClassInstance('ram\SupplyChainEventType');

        $this->tryCall($supplyChainEventType, "setOccurrenceDateTime", $this->getDateTimeType($date));

        return $supplyChainEventType;
    }

    /**
     * Get instance of TradeSettlementFinancialCardType
     *
     * @param  string|null $type
     * @param  string|null $id
     * @param  string|null $holderName
     * @return object|null
     */
    public function getTradeSettlementFinancialCardType(?string $type = null, ?string $id = null, ?string $holderName = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        // At the moment PCI Security Standards Council has defined that the first 6 digits and
        // last 4 digits are the maximum number of digits to be shown.

        $id = substr($id, 0, 6) . substr($id, -4);

        $tradeSettlementFinancialCardType = $this->createClassInstance('ram\TradeSettlementFinancialCardType');

        $this->tryCall($tradeSettlementFinancialCardType, "setID", $this->getIdType($id, $type));
        $this->tryCall($tradeSettlementFinancialCardType, "setCardholderName", $this->getTextType($holderName));

        return $tradeSettlementFinancialCardType;
    }

    /**
     * Get instance of DebtorFinancialAccountType
     *
     * @param  string|null $iban
     * @return object|null
     */
    public function getDebtorFinancialAccountType(?string $iban = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $debtorFinancialAccountType = $this->createClassInstance('ram\DebtorFinancialAccountType');

        $this->tryCall($debtorFinancialAccountType, "setIBANID", $this->getIdType($iban));

        return $debtorFinancialAccountType;
    }

    /**
     * Get instance of CreditorFinancialAccountType
     *
     * @param  string|null $iban
     * @param  string|null $accountName
     * @param  string|null $proprietaryId
     * @return object|null
     */
    public function getCreditorFinancialAccountType(?string $iban = null, ?string $accountName = null, ?string $proprietaryId = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $creditorFinancialAccountType = $this->createClassInstance('ram\CreditorFinancialAccountType');

        $this->tryCall($creditorFinancialAccountType, "setIBANID", $this->getIdType($iban));
        $this->tryCall($creditorFinancialAccountType, "setAccountName", $this->getTextType($accountName));
        $this->tryCall($creditorFinancialAccountType, "setProprietaryID", $this->getIdType($proprietaryId));

        return $creditorFinancialAccountType;
    }

    /**
     * Undocumented function
     *
     * @param  string|null $bic
     * @return object|null
     */
    public function getCreditorFinancialInstitutionType(?string $bic = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $creditorFinancialInstitutionType = $this->createClassInstance('ram\CreditorFinancialInstitutionType');

        $this->tryCall($creditorFinancialInstitutionType, "setBICID", $this->getIdType($bic));

        return $creditorFinancialInstitutionType;
    }

    /**
     * Get instance of TradeSettlementPaymentMeansType
     *
     * @param  string|null $typeCode
     * @param  string|null $information
     * @return object|null
     */
    public function getTradeSettlementPaymentMeansType(?string $typeCode = null, ?string $information = null): ?object
    {
        if (self::isNullOrEmpty($typeCode)) {
            return null;
        }

        $tradeSettlementPaymentMeansType = $this->createClassInstance('ram\TradeSettlementPaymentMeansType');

        $this->tryCall($tradeSettlementPaymentMeansType, "setTypeCode", $this->getCodeType($typeCode));
        $this->tryCall($tradeSettlementPaymentMeansType, "setInformation", $this->getTextType($information));

        return $tradeSettlementPaymentMeansType;
    }

    /**
     * Get instance of TradePaymentTermsType
     *
     * @param  null|string            $description
     * @param  null|DateTimeInterface $dueDate
     * @param  null|string            $directDebitMandateID
     * @param  null|float             $partialPaymentAmount
     * @return null|object
     */
    public function getTradePaymentTermsType(?string $description = null, ?DateTimeInterface $dueDate = null, ?string $directDebitMandateID = null, ?float $partialPaymentAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePaymentTermsType = $this->createClassInstance('ram\TradePaymentTermsType');

        $this->tryCall($tradePaymentTermsType, "setDescription", $this->getTextType($description));
        $this->tryCall($tradePaymentTermsType, "setDueDateDateTime", $this->getDateTimeType($dueDate));
        $this->tryCall($tradePaymentTermsType, "setDirectDebitMandateID", $this->getIdType($directDebitMandateID));
        $this->tryCall($tradePaymentTermsType, "setPartialPaymentAmount", $this->getAmountType($partialPaymentAmount));

        return $tradePaymentTermsType;
    }

    /**
     * Get instance of TradePaymentDiscountTermsType
     *
     * @param  DateTimeInterface|null $basisDateTime
     * @param  float|null             $basisPeriodMeasureValue
     * @param  string|null            $basisPeriodMeasureUnitCode
     * @param  float|null             $basisAmount
     * @param  float|null             $calculationPercent
     * @param  float|null             $actualDiscountAmount
     * @return object|null
     */
    public function getTradePaymentDiscountTermsType(?DateTimeInterface $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $calculationPercent = null, ?float $actualDiscountAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePaymentDiscountTermsType = $this->createClassInstance('ram\TradePaymentDiscountTermsType');

        $this->tryCall($tradePaymentDiscountTermsType, "setBasisDateTime", $this->getDateTimeType($basisDateTime));
        $this->tryCall($tradePaymentDiscountTermsType, "setBasisPeriodMeasure", $this->getMeasureType($basisPeriodMeasureValue, $basisPeriodMeasureUnitCode));
        $this->tryCall($tradePaymentDiscountTermsType, "setBasisAmount", $this->getAmountType($basisAmount));
        $this->tryCall($tradePaymentDiscountTermsType, "setCalculationPercent", $this->getPercentType($calculationPercent));
        $this->tryCall($tradePaymentDiscountTermsType, "setActualDiscountAmount", $this->getAmountType($actualDiscountAmount));

        return $tradePaymentDiscountTermsType;
    }

    /**
     * Get instance of TradePaymentPenaltyTermsType
     *
     * @param  DateTimeInterface|null $basisDateTime
     * @param  float|null             $basisPeriodMeasureValue
     * @param  string|null            $basisPeriodMeasureUnitCode
     * @param  float|null             $basisAmount
     * @param  float|null             $calculationPercent
     * @param  float|null             $actualPenaltyAmount
     * @return object|null
     */
    public function getTradePaymentPenaltyTermsType(?DateTimeInterface $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $calculationPercent = null, ?float $actualPenaltyAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePaymentDiscountTermsType = $this->createClassInstance('ram\TradePaymentPenaltyTermsType');

        $this->tryCall($tradePaymentDiscountTermsType, "setBasisDateTime", $this->getDateTimeType($basisDateTime));
        $this->tryCall($tradePaymentDiscountTermsType, "setBasisPeriodMeasure", $this->getMeasureType($basisPeriodMeasureValue, $basisPeriodMeasureUnitCode));
        $this->tryCall($tradePaymentDiscountTermsType, "setBasisAmount", $this->getAmountType($basisAmount));
        $this->tryCall($tradePaymentDiscountTermsType, "setCalculationPercent", $this->getPercentType($calculationPercent));
        $this->tryCall($tradePaymentDiscountTermsType, "setActualPenaltyAmount", $this->getAmountType($actualPenaltyAmount));

        return $tradePaymentDiscountTermsType;
    }

    /**
     * Get instance of TradeTaxType
     * Sales tax breakdown, Umsatzsteueraufschlüsselung
     *
     * @param  string|null            $categoryCode
     * @param  string|null            $typeCode
     * @param  float|null             $basisAmount
     * @param  float|null             $calculatedAmount
     * @param  float|null             $rateApplicablePercent
     * @param  string|null            $exemptionReason
     * @param  string|null            $exemptionReasonCode
     * @param  float|null             $lineTotalBasisAmount
     * @param  float|null             $allowanceChargeBasisAmount
     * @param  DateTimeInterface|null $taxPointDate
     * @param  string|null            $dueDateTypeCode
     * @return object|null
     */
    public function getTradeTaxType(?string $categoryCode = null, ?string $typeCode = null, ?float $basisAmount = null, ?float $calculatedAmount = null, ?float $rateApplicablePercent = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null, ?float $lineTotalBasisAmount = null, ?float $allowanceChargeBasisAmount = null, ?DateTimeInterface $taxPointDate = null, ?string $dueDateTypeCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeTaxType = $this->createClassInstance('ram\TradeTaxType');

        $this->tryCall($tradeTaxType, "setCalculatedAmount", $this->getAmountType($calculatedAmount));
        $this->tryCall($tradeTaxType, "setTypeCode", $this->getTaxTypeCodeType($typeCode));
        $this->tryCall($tradeTaxType, "setExemptionReason", $this->getTextType($exemptionReason));
        $this->tryCall($tradeTaxType, "setBasisAmount", $this->getAmountType($basisAmount));
        $this->tryCall($tradeTaxType, "setLineTotalBasisAmount", $this->getAmountType($lineTotalBasisAmount));
        $this->tryCall($tradeTaxType, "setAllowanceChargeBasisAmount", $this->getAmountType($allowanceChargeBasisAmount));
        $this->tryCall($tradeTaxType, "setCategoryCode", $this->getTaxCategoryCodeType($categoryCode));
        $this->tryCall($tradeTaxType, "setExemptionReasonCode", $this->getCodeType($exemptionReasonCode));
        $this->tryCall($tradeTaxType, "setTaxPointDate", $this->getDateType($taxPointDate));
        $this->tryCall($tradeTaxType, "setDueDateTypeCode", $this->getTimeReferenceCodeType($dueDateTypeCode));
        $this->tryCall($tradeTaxType, "setRateApplicablePercent", $this->getPercentType($rateApplicablePercent));

        return $tradeTaxType;
    }

    /**
     * Get Allowance/Charge type
     * Zu- und Abschläge
     *
     * @param  float|null   $actualAmount
     * @param  boolean|null $isCharge
     * @param  string|null  $taxTypeCode
     * @param  string|null  $taxCategoryCode
     * @param  float|null   $rateApplicablePercent
     * @param  float|null   $sequence
     * @param  float|null   $calculationPercent
     * @param  float|null   $basisAmount
     * @param  float|null   $basisQuantity
     * @param  string|null  $basisQuantityUnitCode
     * @param  string|null  $reasonCode
     * @param  string|null  $reason
     * @return object|null
     */
    public function getTradeAllowanceChargeType(?float $actualAmount = null, ?bool $isCharge = null, ?string $taxTypeCode = null, ?string $taxCategoryCode = null, ?float $rateApplicablePercent = null, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeAllowanceChargeType = $this->createClassInstance('ram\TradeAllowanceChargeType');

        $this->tryCall($tradeAllowanceChargeType, "setChargeIndicator", $this->getIndicatorType($isCharge));
        $this->tryCall($tradeAllowanceChargeType, "setSequenceNumeric", $this->getNumericType($sequence));
        $this->tryCall($tradeAllowanceChargeType, "setCalculationPercent", $this->getPercentType($calculationPercent));
        $this->tryCall($tradeAllowanceChargeType, "setBasisAmount", $this->getAmountType($basisAmount));
        $this->tryCall($tradeAllowanceChargeType, "setBasisQuantity", $this->getQuantityType($basisQuantity, $basisQuantityUnitCode));
        $this->tryCall($tradeAllowanceChargeType, "setActualAmount", $this->getAmountType($actualAmount));
        $this->tryCall($tradeAllowanceChargeType, "setReasonCode", $this->getCodeType($reasonCode));
        $this->tryCall($tradeAllowanceChargeType, "setReason", $this->getTextType($reason));

        if (!is_null($taxCategoryCode) && !is_null($taxTypeCode)) {
            $this->tryCall($tradeAllowanceChargeType, "setCategoryTradeTax", $this->getTradeTaxType($taxCategoryCode, $taxTypeCode, null, null, $rateApplicablePercent));
        }

        return $tradeAllowanceChargeType;
    }

    /**
     * Get instance of
     *
     * @param  string|null $description
     * @param  float|null  $appliedAmount
     * @param  array|null  $taxTypeCodes
     * @param  array|null  $taxCategoryCodes
     * @param  array|null  $rateApplicablePercents
     * @return object|null
     */
    public function getLogisticsServiceChargeType(?string $description = null, ?float $appliedAmount = null, ?array $taxTypeCodes = null, ?array $taxCategoryCodes = null, ?array $rateApplicablePercents = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $logisticsServiceChargeType = $this->createClassInstance('ram\LogisticsServiceChargeType');

        $this->tryCall($logisticsServiceChargeType, "setDescription", $this->getTextType($description));
        $this->tryCall($logisticsServiceChargeType, "setAppliedAmount", $this->getAmountType($appliedAmount));

        if (!is_null($taxCategoryCodes) && !is_null($taxTypeCodes) && !is_null($rateApplicablePercents)) {
            foreach ($rateApplicablePercents as $index => $rateApplicablePercent) {
                $taxBreakdown = $this->getTradeTaxType($taxCategoryCodes[$index], $taxTypeCodes[$index], null, null, $rateApplicablePercent);
                $this->tryCall($logisticsServiceChargeType, "addToAppliedTradeTax", $taxBreakdown);
            }
        }

        return $logisticsServiceChargeType;
    }

    /**
     * Get instance of TradeSettlementHeaderMonetarySummationType
     *
     * @param  float|null $grandTotalAmount
     * @param  float|null $duePayableAmount
     * @param  float|null $lineTotalAmount
     * @param  float|null $chargeTotalAmount
     * @param  float|null $allowanceTotalAmount
     * @param  float|null $taxBasisTotalAmount
     * @param  float|null $taxTotalAmount
     * @param  float|null $roundingAmount
     * @param  float|null $totalPrepaidAmount
     * @return object|null
     */
    public function getTradeSettlementHeaderMonetarySummationType(?float $grandTotalAmount = null, ?float $duePayableAmount = null, ?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxBasisTotalAmount = null, ?float $taxTotalAmount = null, ?float $roundingAmount = null, ?float $totalPrepaidAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeSettlementHeaderMonetarySummationType = $this->createClassInstance('ram\TradeSettlementHeaderMonetarySummationType');

        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setLineTotalAmount", $this->getAmountType($lineTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setChargeTotalAmount", $this->getAmountType($chargeTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setAllowanceTotalAmount", $this->getAmountType($allowanceTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setTaxBasisTotalAmount", $this->getAmountType($taxBasisTotalAmount));
        $this->tryCallAll($tradeSettlementHeaderMonetarySummationType, ["addToTaxTotalAmount", "setTaxTotalAmount"], $this->getAmountType($taxTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setRoundingAmount", $this->getAmountType($roundingAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setGrandTotalAmount", $this->getAmountType($grandTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setTotalPrepaidAmount", $this->getAmountType($totalPrepaidAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, "setDuePayableAmount", $this->getAmountType($duePayableAmount));

        return $tradeSettlementHeaderMonetarySummationType;
    }

    /**
     * Create summation class only
     *
     * @return object|null
     */
    public function getTradeSettlementHeaderMonetarySummationTypeOnly(): ?object
    {
        return $this->createClassInstance('ram\TradeSettlementHeaderMonetarySummationType');
    }

    /**
     * Get an instance of TradeAccountingAccountType
     *
     * @param  string|null $id
     * @param  string|null $typeCode
     * @return object|null
     */
    public function getTradeAccountingAccountType(?string $id = null, ?string $typeCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeAccountingAccountType = $this->createClassInstance('ram\TradeAccountingAccountType');

        $this->tryCall($tradeAccountingAccountType, "setID", $this->getIdType($id));
        $this->tryCall($tradeAccountingAccountType, "setTypeCode", $this->getCodeType($typeCode));

        return $tradeAccountingAccountType;
    }

    /**
     * Get Document line
     *
     * @param  string|null $lineId
     * @return object|null
     */
    public function getDocumentLineDocumentType(?string $lineId = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $documentLineDocumentType = $this->createClassInstance('ram\DocumentLineDocumentType');

        $this->tryCall($documentLineDocumentType, "setLineID", $this->getIdType($lineId));

        return $documentLineDocumentType;
    }

    /**
     * Get instance of SupplyChainTradeLineItemType
     *
     * @param  string|null $lineId
     * @param  string|null $lineStatusCode
     * @param  string|null $lineStatusReasonCode
     * @param  boolean     $isTextPosition
     * @return object|null
     */
    public function getSupplyChainTradeLineItemType(?string $lineId = null, ?string $lineStatusCode = null, ?string $lineStatusReasonCode = null, bool $isTextPosition = false): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $supplyChainTradeLineItemType = $this->createClassInstance('ram\SupplyChainTradeLineItemType');

        $doclinedoc = $this->getDocumentLineDocumentType($lineId);
        $lineTradeAgreementType = $this->createClassInstance('ram\LineTradeAgreementType');
        $lineTradeDeliveryType = $this->createClassInstance('ram\LineTradeDeliveryType');
        $lineTradeSettlementType = $this->createClassInstance('ram\LineTradeSettlementType');

        $this->tryCall($supplyChainTradeLineItemType, "setAssociatedDocumentLineDocument", $doclinedoc);
        $this->tryCall($doclinedoc, "setLineStatusCode", $this->getCodeType($lineStatusCode));
        $this->tryCall($doclinedoc, "setLineStatusReasonCode", $this->getCodeType($lineStatusReasonCode));
        if ($isTextPosition == false) {
            $this->tryCall($supplyChainTradeLineItemType, "setSpecifiedLineTradeAgreement", $lineTradeAgreementType);
            $this->tryCall($supplyChainTradeLineItemType, "setSpecifiedLineTradeDelivery", $lineTradeDeliveryType);
        }

        $this->tryCall($supplyChainTradeLineItemType, "setSpecifiedLineTradeSettlement", $lineTradeSettlementType);

        return $supplyChainTradeLineItemType;
    }

    /**
     * Get product specification
     *
     * @param  string|null $name
     * @param  string|null $description
     * @param  string|null $sellerAssignedID
     * @param  string|null $buyerAssignedID
     * @param  string|null $globalIDType
     * @param  string|null $globalID
     * @param  string|null $industryAssignedID
     * @param  string|null $modelID
     * @param  string|null $batchID
     * @param  string|null $brandName
     * @param  string|null $modelName
     * @return object|null
     */
    public function getTradeProductType(?string $name = null, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null, ?string $industryAssignedID = null, ?string $modelID = null, ?string $batchID = null, ?string $brandName = null, ?string $modelName = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeProductType = $this->createClassInstance('ram\TradeProductType');

        $this->tryCall($tradeProductType, "setGlobalID", $this->getIdType($globalID, $globalIDType));
        $this->tryCall($tradeProductType, "setSellerAssignedID", $this->getIdType($sellerAssignedID));
        $this->tryCall($tradeProductType, "setBuyerAssignedID", $this->getIdType($buyerAssignedID));
        $this->tryCall($tradeProductType, "setName", $this->getTextType($name));
        $this->tryCall($tradeProductType, "setDescription", $this->getTextType($description));
        $this->tryCall($tradeProductType, "setIndustryAssignedID", $this->getIdType($industryAssignedID));
        $this->tryCall($tradeProductType, "setModelID", $this->getIdType($modelID));
        $this->tryCall($tradeProductType, "addToBatchID", $this->getIdType($batchID));
        $this->tryCall($tradeProductType, "setBrandName", $this->getTextType($brandName));
        $this->tryCall($tradeProductType, "setModelName", $this->getTextType($modelName));

        return $tradeProductType;
    }

    /**
     * Get Product Characteristic
     *
     * @param  string|null $typeCode
     * @param  string|null $description
     * @param  float|null  $valueMeasure
     * @param  string|null $valueMeasureUnitCode
     * @param  string|null $value
     * @return object|null
     */
    public function getProductCharacteristicType(?string $typeCode = null, ?string $description = null, ?float $valueMeasure = null, ?string $valueMeasureUnitCode = null, ?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $productCharacteristicType = $this->createClassInstance('ram\ProductCharacteristicType');

        $this->tryCall($productCharacteristicType, "setTypeCode", $this->getCodeType($typeCode));
        $this->tryCall($productCharacteristicType, "setDescription", $this->getTextType($description));
        $this->tryCall($productCharacteristicType, "setValueMeasure", $this->getMeasureType($valueMeasure, $valueMeasureUnitCode));
        $this->tryCall($productCharacteristicType, "setValue", $this->getTextType($value));

        return $productCharacteristicType;
    }

    /**
     * Get Product Classification
     *
     * @param  string|null $classCode
     * @param  string|null $className
     * @param  string|null $listID
     * @param  string|null $listVersionID
     * @return object|null
     */
    public function getProductClassificationType(?string $classCode = null, ?string $className = null, ?string $listID = null, ?string $listVersionID = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $productClassificationType = $this->createClassInstance('ram\ProductClassificationType');

        $this->tryCall($productClassificationType, "setClassCode", $this->getCodeType2($classCode, $listID, $listVersionID));
        $this->tryCall($productClassificationType, "setClassName", $this->getTextType($className));

        return $productClassificationType;
    }

    /**
     * Get product reference product
     *
     * @param  string|null $globalID
     * @param  string|null $globalIDType
     * @param  string|null $sellerAssignedID
     * @param  string|null $buyerAssignedID
     * @param  string|null $industryAssignedID
     * @param  string|null $name
     * @param  string|null $description
     * @param  float|null  $unitQuantity
     * @param  string|null $unitCode
     * @return object|null
     */
    public function getReferencedProductType(?string $globalID, ?string $globalIDType, ?string $sellerAssignedID, ?string $buyerAssignedID, ?string $industryAssignedID, ?string $name, ?string $description, ?float $unitQuantity, ?string $unitCode): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $referencedProductType = $this->createClassInstance('ram\ReferencedProductType');

        $this->tryCallAll($referencedProductType, ["addToGlobalID", "setGlobalID"], $this->getIdType($globalID, $globalIDType));
        $this->tryCall($referencedProductType, "setSellerAssignedID", $this->getIdType($sellerAssignedID));
        $this->tryCall($referencedProductType, "setBuyerAssignedID", $this->getIdType($buyerAssignedID));
        $this->tryCall($referencedProductType, "setIndustryAssignedID", $this->getIdType($industryAssignedID));
        $this->tryCall($referencedProductType, "setName", $this->getTextType($name));
        $this->tryCall($referencedProductType, "setDescription", $this->getTextType($description));
        $this->tryCall($referencedProductType, "setUnitQuantity", $this->getQuantityType($unitQuantity, $unitCode));

        return $referencedProductType;
    }

    /**
     * Get trade price
     *
     * @param  float|null  $amount
     * @param  float|null  $basisQuantity
     * @param  string|null $basisQuantityUnitCode
     * @return object|null
     */
    public function getTradePriceType(?float $amount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePriceType = $this->createClassInstance('ram\TradePriceType');

        $this->tryCall($tradePriceType, "setChargeAmount", $this->getAmountType($amount));
        $this->tryCall($tradePriceType, "setBasisQuantity", $this->getQuantityType($basisQuantity, $basisQuantityUnitCode));

        return $tradePriceType;
    }

    /**
     * Get Line Summation
     *
     * @param  null|float $lineTotalAmount
     * @param  null|float $chargeTotalAmount
     * @param  null|float $allowanceTotalAmount
     * @param  null|float $taxTotalAmount
     * @param  null|float $grandTotalAmount
     * @param  null|float $totalAllowanceChargeAmount
     * @return null|object
     */
    public function getTradeSettlementLineMonetarySummationType(?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxTotalAmount = null, ?float $grandTotalAmount = null, ?float $totalAllowanceChargeAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeSettlementLineMonetarySummationType = $this->createClassInstance('ram\TradeSettlementLineMonetarySummationType');

        $this->tryCall($tradeSettlementLineMonetarySummationType, "setLineTotalAmount", $this->getAmountType($lineTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, "setChargeTotalAmount", $this->getAmountType($chargeTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, "setAllowanceTotalAmount", $this->getAmountType($allowanceTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, "setTaxTotalAmount", $this->getAmountType($taxTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, "setGrandTotalAmount", $this->getAmountType($grandTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, "setTotalAllowanceChargeAmount", $this->getAmountType($totalAllowanceChargeAmount));

        return $tradeSettlementLineMonetarySummationType;
    }

    /**
     * Undocumented function
     *
     * @param  string|null            $sourceCurrencyCode
     * @param  string|null            $targetCurrencyCode
     * @param  float|null             $rate
     * @param  DateTimeInterface|null $rateDateTime
     * @return object|null
     */
    public function getTaxApplicableTradeCurrencyExchangeType(?string $sourceCurrencyCode = null, ?string $targetCurrencyCode = null, ?float $rate = null, ?DateTimeInterface $rateDateTime = null): ?object
    {
        if (self::isOneNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeCurrencyExchangeType = $this->createClassInstance('ram\TradeCurrencyExchangeType');

        $this->tryCall($tradeCurrencyExchangeType, "setSourceCurrencyCode", $this->getIdType($sourceCurrencyCode));
        $this->tryCall($tradeCurrencyExchangeType, "setTargetCurrencyCode", $this->getIdType($targetCurrencyCode));
        $this->tryCall($tradeCurrencyExchangeType, "setConversionRate", $this->getRateType($rate));
        $this->tryCall($tradeCurrencyExchangeType, "setConversionRateDateTime", $this->getDateTimeType($rateDateTime));

        return $tradeCurrencyExchangeType;
    }

    /**
     * Create a datetime object
     *
     * @param  string|null $dateTimeString
     * @param  string|null $format
     * @return DateTime|null
     */
    public function toDateTime(?string $dateTimeString, ?string $format): ?DateTime
    {
        if (self::isNullOrEmpty($dateTimeString) || self::isNullOrEmpty($format)) {
            return null;
        }

        $dateTimeString = trim($dateTimeString);

        if ($format == "102") {
            return DateTime::createFromFormat("Ymd", $dateTimeString);
        }

        if ($format == "101") {
            return DateTime::createFromFormat("ymd", $dateTimeString);
        }

        if ($format == "201") {
            return DateTime::createFromFormat("ymdHi", $dateTimeString);
        }

        if ($format == "202") {
            return DateTime::createFromFormat("ymdHis", $dateTimeString);
        }

        if ($format == "203") {
            return DateTime::createFromFormat("YmdHi", $dateTimeString);
        }

        if ($format == "204") {
            return DateTime::createFromFormat("YmdHis", $dateTimeString);
        }

        if ($format == "610") {
            return DateTime::createFromFormat("Ym", $dateTimeString)->modify('first day of')->modify('midnight');
        }

        throw new ZugferdUnknownDateFormatException($format);
    }

    /**
     * Get Exchange rate type instance
     *
     * @param  float|null $rateValue
     * @return object|null
     */
    public function getRateType(?float $rateValue): ?object
    {
        $rateType = $this->createClassInstance('udt\RateType');

        $this->tryCall($rateType, "value", $rateValue);

        return $rateType;
    }

    /**
     * Creates an instance of a class needed by $invoiceObject
     *
     * @param  string $classname
     * @param  mixed  $constructorvalue
     * @return object|null
     */
    public function createClassInstance($classname, $constructorvalue = null): ?object
    {
        $className = 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\\' . $classname;

        if (!class_exists($className)) {
            return null;
        }

        return new $className($constructorvalue);
    }

    /**
     * Tries to call a method
     *
     * @param  object $instance
     * @param  string $method
     * @param  mixed  $value
     * @return ZugferdObjectHelper
     */
    public function tryCall($instance, string $method, $value): ZugferdObjectHelper
    {
        if (!$instance) {
            return $this;
        }

        if ($method === '') {
            return $this;
        }

        if (self::isNullOrEmpty($value)) {
            return $this;
        }

        if ($this->methodExists($instance, $method)) {
            $instance->$method($value);
        }

        return $this;
    }

    /**
     * Try call all methods
     *
     * @param  object   $instance
     * @param  string[] $methods
     * @param  mixed    $value
     * @return ZugferdObjectHelper
     */
    public function tryCallAll($instance, array $methods, $value): ZugferdObjectHelper
    {
        if (!$instance) {
            return $this;
        }

        if (self::isNullOrEmpty($value)) {
            return $this;
        }

        foreach ($methods as $method) {
            if ($this->methodExists($instance, $method)) {
                $instance->$method($value);
                return $this;
            }
        }

        return $this;
    }

    /**
     * Tries to call a method and return the returnvalue from call to $method
     * in object $instance
     *
     * @param  object $instance
     * @param  string $method
     * @return mixed
     */
    public function tryCallAndReturn($instance, string $method)
    {
        if (!$instance) {
            return null;
        }

        if ($method === '') {
            return null;
        }

        if ($this->methodExists($instance, $method)) {
            return $instance->$method();
        }

        return null;
    }

    /**
     * Try call methods in a form .object.method1.method2.method3
     *
     * @param  object $instance
     * @param  string $methods
     * @param  mixed  $value
     * @return void
     */
    public function tryCallByPath($instance, string $methods, $value)
    {
        $methods = explode(".", $methods);

        foreach ($methods as $index => $method) {
            if ($index == count($methods) - 1) {
                $this->tryCall($instance, $method, $value);
            } else {
                $instance = $this->tryCallAndReturn($instance, $method);
            }
        }
    }

    /**
     * Try call methods in a form .object.method1.method2.method3
     *
     * @param  object $instance
     * @param  string $methods
     * @return mixed
     */
    public function tryCallByPathAndReturn($instance, string $methods)
    {
        $result = null;
        $methods = explode(".", $methods);

        foreach ($methods as $method) {
            $result = $this->tryCallAndReturn($instance, $method);
            $instance = $result;
        }

        return $result;
    }

    /**
     * Call $method if exists, otherwise $method2 is calles with $value
     *
     * @param  object $instance
     * @param  string $methodToLookFor
     * @param  string $methodToCall
     * @param  mixed  $value
     * @param  mixed  $value2
     * @return ZugferdObjectHelper
     */
    public function tryCallIfMethodExists($instance, string $methodToLookFor, string $methodToCall, $value, $value2): ZugferdObjectHelper
    {
        if (!$instance) {
            return $this;
        }

        if ($methodToLookFor === '') {
            return $this;
        }

        if ($methodToCall === '') {
            return $this;
        }

        if (!$this->methodExists($instance, $methodToCall)) {
            return $this;
        }

        if ($this->methodExists($instance, $methodToLookFor)) {
            $instance->$methodToCall($value);
        } else {
            $instance->$methodToCall($value2);
        }

        return $this;
    }

    /**
     * Ensure that $input is an array
     *
     * @param  mixed $input
     * @return array
     */
    public function ensureStringArray($input): array
    {
        if (is_array($input)) {
            return $input;
        }

        return [(string)$input];
    }

    /**
     * Ensure array
     *
     * @param  mixed $value
     * @return array
     */
    public function ensureArray($value): array
    {
        if (!is_array($value)) {
            if (!is_null($value)) {
                return [$value];
            }

            return [];
        }

        return $value;
    }

    /**
     * Test if a value is null or empty
     *
     * @param  mixed $value
     * @return boolean
     */
    public static function isNullOrEmpty($value)
    {
        if ($value === null) {
            return true;
        }

        return !is_object($value) && (string)$value === "";
    }

    /**
     * Checks if all function arguments are null or empty
     *
     * @param  array $args
     * @return boolean
     */
    public static function isAllNullOrEmpty(array $args): bool
    {
        foreach ($args as $arg) {
            if ($arg instanceof DateTime) {
                return false;
            }

            if (!self::isNullOrEmpty($arg)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if all function arguments are null or empty
     *
     * @param  array $args
     * @return boolean
     */
    public static function isOneNullOrEmpty(array $args): bool
    {
        foreach ($args as $arg) {
            if ($arg instanceof DateTime) {
                if ($arg == null) {
                    return true;
                }
            } elseif (self::isNullOrEmpty($arg)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Wrapper for method_exists for use in PHP8
     *
     * @param  string|object $instance
     * @param  string        $method
     * @return boolean
     */
    public function methodExists($instance, $method): bool
    {
        if ($instance == null) {
            return false;
        }

        if (!is_object($instance) && !is_string($instance)) {
            return false;
        }

        return method_exists($instance, $method);
    }
}
