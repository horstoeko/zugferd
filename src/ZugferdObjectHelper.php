<?php

declare(strict_types=1);

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DateTime;
use DateTimeInterface;
use finfo;
use horstoeko\mimedb\MimeDb;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice;
use horstoeko\zugferd\exception\ZugferdInvalidArgumentException;
use horstoeko\zugferd\exception\ZugferdUnknownDateFormatException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileIdException;
use horstoeko\zugferd\exception\ZugferdUnsupportedMimetype;
use ValueError;

/**
 * Class representing a collection of common helpers and class factories
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 *
 * @phpstan-import-type ZugferdProfileDefinition from ZugferdProfiles
 */
class ZugferdObjectHelper
{
    /**
     * A list of supported mimetypes by binaryattachments
     */
    public const SUPPORTEDTMIMETYPES = [
        'application/pdf',
        'image/png',
        'image/jpeg',
        'text/csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.oasis.opendocument.spreadsheet',
    ];

    /**
     * Internal profile id
     *
     * @var int
     */
    public $profile = -1;

    /**
     * Internal profile definition
     *
     * @var ZugferdProfileDefinition
     */
    public $profiledef;

    /**
     * Constructor
     *
     * @param int $profile
     *
     * @throws ZugferdUnknownProfileIdException
     */
    public function __construct(int $profile)
    {
        $this->profile = $profile;
        $this->profiledef = ZugferdProfileResolver::resolveProfileDefById($profile);
    }

    /**
     * Creates an instance of DocumentCodeType
     *
     * @param  null|string $value
     * @return null|object
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
     * @param  null|string $value
     * @param  null|string $schemeId
     * @return object
     */
    public function getIdType(?string $value = null, ?string $schemeId = null): ?object
    {
        if (self::isNullOrEmpty($value)) {
            return null;
        }

        $idType = $this->createClassInstance('udt\IDType', $value);

        $this->tryCall($idType, 'setSchemeID', $schemeId);

        return $idType;
    }

    /**
     * Creates an instance of TextType
     *
     * @param  null|string $value
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
     * @param  null|string $value
     * @return null|object
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
     * @param  null|string $value
     * @param  null|string $listID
     * @param  null|string $listVersionID
     * @return null|object
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
     * @param  null|bool   $value
     * @return null|object
     */
    public function getIndicatorType(?bool $value = null): ?object
    {
        if (null === $value) {
            return null;
        }

        $indicatorType = $this->createClassInstance('udt\IndicatorType');

        $this->tryCall($indicatorType, 'setIndicator', $value);

        return $indicatorType;
    }

    /**
     * Get Note type
     *
     * @param  null|string $content
     * @param  null|string $contentCode
     * @param  null|string $subjectCode
     * @return null|object
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
     * @param  null|DateTimeInterface $dateTime
     * @return null|object
     */
    public function getFormattedDateTimeType(?DateTimeInterface $dateTime = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $dateTimeStringAType = $this->createClassInstance('qdt\FormattedDateTimeType\DateTimeStringAType');
        $this->tryCall($dateTimeStringAType, 'value', $dateTime->format('Ymd'));
        $this->tryCall($dateTimeStringAType, 'setFormat', '102');

        $formattedDateTimeType = $this->createClassInstance('qdt\FormattedDateTimeType');
        $this->tryCall($formattedDateTimeType, 'setDateTimeString', $dateTimeStringAType);

        return $formattedDateTimeType;
    }

    /**
     * Get formatted issue date
     *
     * @param  null|DateTimeInterface $dateTime
     * @return null|object
     */
    public function getDateTimeType(?DateTimeInterface $dateTime = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $dateTimeStringAType = $this->createClassInstance('udt\DateTimeType\DateTimeStringAType');
        $this->tryCall($dateTimeStringAType, 'value', $dateTime->format('Ymd'));
        $this->tryCall($dateTimeStringAType, 'setFormat', '102');

        $dateTimeType = $this->createClassInstance('udt\DateTimeType');
        $this->tryCall($dateTimeType, 'setDateTimeString', $dateTimeStringAType);

        return $dateTimeType;
    }

    /**
     * Get date
     *
     * @param  null|DateTimeInterface $dateTime
     * @return null|object
     */
    public function getDateType(?DateTimeInterface $dateTime = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $dateStringAType = $this->createClassInstance('udt\DateType\DateStringAType');
        $this->tryCall($dateStringAType, 'value', $dateTime->format('Ymd'));
        $this->tryCall($dateStringAType, 'setFormat', '102');

        $dateType = $this->createClassInstance('udt\DateType');
        $this->tryCall($dateType, 'setDateString', $dateStringAType);

        return $dateType;
    }

    /**
     * Representation of Amount
     *
     * @param  null|float  $value
     * @param  null|string $currencyCode
     * @return null|object
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

        $this->tryCall($amountType, 'value', $value);
        $this->tryCall($amountType, 'setCurrencyID', $currencyCode);

        return $amountType;
    }

    /**
     * Representation of Percdnt
     *
     * @param  null|float  $value
     * @return null|object
     */
    public function getPercentType(?float $value): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $percentType = $this->createClassInstance('udt\PercentType');

        $this->tryCall($percentType, 'value', $value);

        return $percentType;
    }

    /**
     * Representation of Quantity
     *
     * @param  null|float  $value
     * @param  null|string $unitCode
     * @return null|object
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

        $this->tryCall($quantityType, 'value', $value);
        $this->tryCall($quantityType, 'setUnitCode', $unitCode);

        return $quantityType;
    }

    /**
     * Representation of Quantity Measure
     *
     * @param  null|float  $value
     * @param  null|string $unitCode
     * @return null|object
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

        $this->tryCall($measureType, 'value', $value);
        $this->tryCall($measureType, 'setUnitCode', $unitCode);

        return $measureType;
    }

    /**
     * Get an instance of GetNumericType
     *
     * @param  null|float  $value
     * @return null|object
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
     * @param  null|string $taxCategoryCode
     * @return null|object
     */
    public function getTaxCategoryCodeType(?string $taxCategoryCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $taxCategoryCodeType = $this->createClassInstance('qdt\TaxCategoryCodeType');

        $this->tryCall($taxCategoryCodeType, 'value', $taxCategoryCode);

        return $taxCategoryCodeType;
    }

    /**
     * Representation of Tax Type
     *
     * @param  null|string $taxTypeCode
     * @return null|object
     */
    public function getTaxTypeCodeType(?string $taxTypeCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $taxTypeCodeType = $this->createClassInstance('qdt\TaxTypeCodeType');

        $this->tryCall($taxTypeCodeType, 'value', $taxTypeCode);

        return $taxTypeCodeType;
    }

    /**
     * Representation of Time Reference Code
     *
     * @param  null|string $value
     * @return null|object
     */
    public function getTimeReferenceCodeType(?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $timeReferenceCodeType = $this->createClassInstance('qdt\TimeReferenceCodeType');

        $this->tryCall($timeReferenceCodeType, 'value', $value);

        return $timeReferenceCodeType;
    }

    /**
     * Get Specified Period type
     *
     * @param  null|DateTimeInterface $startDate
     * @param  null|DateTimeInterface $endDate
     * @param  null|DateTimeInterface $completeDate
     * @param  null|string            $description
     * @return null|object
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
     * @param  null|string $binaryData
     * @param  null|string $mimetype
     * @param  null|string $filename
     * @return null|object
     */
    public function getBinaryObjectType(?string $binaryData = null, ?string $mimetype = null, ?string $filename = null): ?object
    {
        if (self::isNullOrEmpty($binaryData) || self::isNullOrEmpty($mimetype) || self::isNullOrEmpty($filename)) {
            return null;
        }

        $binaryObjectType = $this->createClassInstance('udt\BinaryObjectType');

        $this->tryCall($binaryObjectType, 'value', $binaryData);
        $this->tryCall($binaryObjectType, 'setMimeCode', $mimetype);
        $this->tryCall($binaryObjectType, 'setFilename', $filename);

        return $binaryObjectType;
    }

    /**
     * Get a reference document object
     *
     * @param  null|string                    $issuerAssignedId
     * @param  null|string                    $uriId
     * @param  null|string                    $lineId
     * @param  null|string                    $typeCode
     * @param  null|array<int, string>|string $name
     * @param  null|string                    $refTypeCode
     * @param  null|DateTimeInterface         $issueDate
     * @param  null|string                    $binaryDataFilename
     * @param  null|string                    $base64EncodedData
     * @return null|object
     *
     * @throws ZugferdInvalidArgumentException
     * @throws ZugferdUnsupportedMimetype
     */
    public function getReferencedDocumentType(?string $issuerAssignedId = null, ?string $uriId = null, ?string $lineId = null, ?string $typeCode = null, $name = null, ?string $refTypeCode = null, ?DateTimeInterface $issueDate = null, ?string $binaryDataFilename = null, ?string $base64EncodedData = null): ?object
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

        foreach ($this->ensureStringArray($name) as $documentName) {
            $this->tryCallAll($referencedDocumentType, ['addToName', 'setName'], $this->getTextType($documentName));
        }

        $loadedFromBase64 = false;

        if (
            false === StringUtils::stringIsNullOrEmpty($binaryDataFilename)
            && false === StringUtils::stringIsNullOrEmpty($base64EncodedData)
        ) {
            $decodedData = base64_decode($base64EncodedData, true);

            if (false === $decodedData) {
                throw new ZugferdInvalidArgumentException('The data of ' . $binaryDataFilename . ' is not valid Base64-encoded data');
            }

            $finfo = new finfo();
            $mimetype = $finfo->buffer($decodedData, FILEINFO_MIME_TYPE);

            if (false === $mimetype) {
                throw new ZugferdUnsupportedMimetype('of ' . $binaryDataFilename);
            }

            $fileExtension = FileUtils::getFileExtension($binaryDataFilename);

            if ('text/plain' === $mimetype && 'csv' === strtolower($fileExtension)) {
                $mimetype = 'text/csv';
            }

            /**
             * PHP 8.0 may misdetect CSV files as "application/csv"; normalize to the standard "text/csv"
             */
            if (PHP_VERSION_ID >= 80000 && PHP_VERSION_ID < 80100 && 'application/csv' === $mimetype) {
                $mimetype = 'text/csv';
            }

            if (!in_array($mimetype, self::SUPPORTEDTMIMETYPES, true)) {
                throw new ZugferdUnsupportedMimetype($mimetype);
            }

            $fileExtension = (new MimeDb())->findFirstFileExtensionByMimeType($mimetype);

            if (is_null($fileExtension)) {
                throw new ZugferdUnsupportedMimetype($mimetype);
            }

            $this->tryCall(
                $referencedDocumentType,
                'setAttachmentBinaryObject',
                $this->getBinaryObjectType(
                    $base64EncodedData,
                    $mimetype,
                    FileUtils::getFilenameWithExtension(
                        FileUtils::changeFileExtension(
                            FileUtils::getFilenameWithExtension($binaryDataFilename),
                            $fileExtension,
                        ),
                    ),
                ),
            );
            $loadedFromBase64 = true;
        }

        if (
            false === $loadedFromBase64
            && false === StringUtils::stringIsNullOrEmpty($binaryDataFilename)
            && FileUtils::fileExists($binaryDataFilename)
        ) {
            $mimeDb = new MimeDb();
            $mimeTypes = $mimeDb->findAllMimeTypesByExtension(FileUtils::getFileExtension($binaryDataFilename));

            if (is_null($mimeTypes)) {
                throw new ZugferdUnsupportedMimetype('of ' . $binaryDataFilename);
            }

            $mimeTypesSupported = array_intersect($mimeTypes, self::SUPPORTEDTMIMETYPES);

            if ([] === $mimeTypesSupported) {
                throw new ZugferdUnsupportedMimetype(implode(', ', $mimeTypes));
            }

            $content = FileUtils::fileToBase64($binaryDataFilename);
            $this->tryCall(
                $referencedDocumentType,
                'setAttachmentBinaryObject',
                $this->getBinaryObjectType($content, $mimeTypesSupported[0], FileUtils::getFilenameWithExtension($binaryDataFilename))
            );
        }

        return $referencedDocumentType;
    }

    /**
     * Get instance of CountryID
     *
     * @param  null|string $id
     * @return null|object
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
     * @param  null|string $id
     * @return null|object
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
     * @return CrossIndustryInvoice|entities\basicwl\rsm\CrossIndustryInvoice|entities\en16931\rsm\CrossIndustryInvoice|entities\extended\rsm\CrossIndustryInvoice
     */
    public function getCrossIndustryInvoice()
    {
        $crossIndustryInvoice = $this->createClassInstance('rsm\CrossIndustryInvoice');

        $crossIndustryInvoice->setExchangedDocumentContext($this->createClassInstance('ram\ExchangedDocumentContextType'));
        $crossIndustryInvoice->setExchangedDocument($this->createClassInstance('ram\ExchangedDocumentType'));
        $crossIndustryInvoice->setSupplyChainTradeTransaction($this->createClassInstance('ram\SupplyChainTradeTransactionType'));
        $crossIndustryInvoice->getExchangedDocumentContext()->setGuidelineSpecifiedDocumentContextParameter($this->createClassInstance('ram\DocumentContextParameterType'));
        $crossIndustryInvoice->getExchangedDocumentContext()->getGuidelineSpecifiedDocumentContextParameter()->setID($this->getIdType($this->profiledef['contextparameter']));

        if (null !== $this->profiledef['businessprocess'] && '' !== $this->profiledef['businessprocess']) {
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
     * @param  null|string $name
     * @param  null|string $id
     * @param  null|string $description
     * @return null|object
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
     * @param  null|string $name
     * @param  null|string $id
     * @param  null|string $description
     * @return null|object
     */
    public function getTradePartyAllowEmpty(?string $name = null, ?string $id = null, ?string $description = null): ?object
    {
        $tradePartyType = $this->createClassInstance('ram\TradePartyType');

        $this->tryCall($tradePartyType, 'addToID', $this->getIdType($id));
        $this->tryCall($tradePartyType, 'setName', $this->getTextType($name));
        $this->tryCall($tradePartyType, 'setDescription', $this->getTextType($description));

        return $tradePartyType;
    }

    /**
     * Address type
     *
     * @param  null|string $lineOne
     * @param  null|string $lineTwo
     * @param  null|string $lineThree
     * @param  null|string $postCode
     * @param  null|string $city
     * @param  null|string $country
     * @param  null|string $subDivision
     * @return null|object
     */
    public function getTradeAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeAddressType = $this->createClassInstance('ram\TradeAddressType');

        $this->tryCall($tradeAddressType, 'setLineOne', $this->getTextType($lineOne));
        $this->tryCall($tradeAddressType, 'setLineTwo', $this->getTextType($lineTwo));
        $this->tryCall($tradeAddressType, 'setLineThree', $this->getTextType($lineThree));
        $this->tryCall($tradeAddressType, 'setPostcodeCode', $this->getCodeType($postCode));
        $this->tryCall($tradeAddressType, 'setCityName', $this->getTextType($city));
        $this->tryCall($tradeAddressType, 'setCountryID', $this->getCountryIDType($country));
        $this->tryCall($tradeAddressType, 'setCountrySubDivisionName', $this->getTextType($subDivision));

        return $tradeAddressType;
    }

    /**
     * Legal organization type
     *
     * @param  null|string $legalOrgId
     * @param  null|string $legalOrgType
     * @param  null|string $legalOrgName
     * @return null|object
     */
    public function getLegalOrganization(?string $legalOrgId = null, ?string $legalOrgType = null, ?string $legalOrgName = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $legalOrganizationType = $this->createClassInstance('ram\LegalOrganizationType', $legalOrgName);

        $this->tryCall($legalOrganizationType, 'setID', $this->getIdType($legalOrgId, $legalOrgType));
        $this->tryCall($legalOrganizationType, 'setTradingBusinessName', $this->getTextType($legalOrgName));

        return $legalOrganizationType;
    }

    /**
     * Contact type
     *
     * @param  null|string $contactPersonName
     * @param  null|string $contactDepartmentName
     * @param  null|string $contactPhoneNo
     * @param  null|string $contactFaxNo
     * @param  null|string $contactEmailAddress
     * @return null|object
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

        $this->tryCall($tradeContactType, 'setPersonName', $this->getTextType($contactPersonName));
        $this->tryCall($tradeContactType, 'setDepartmentName', $this->getTextType($contactDepartmentName));
        $this->tryCall($tradeContactType, 'setTelephoneUniversalCommunication', $contactPhoneNo);
        $this->tryCall($tradeContactType, 'setFaxUniversalCommunication', $contactFaxNo);
        $this->tryCall($tradeContactType, 'setEmailURIUniversalCommunication', $contactEmailAddress);

        return $tradeContactType;
    }

    /**
     * Communication type
     *
     * @param  null|string $number
     * @param  null|string $uriId
     * @param  null|string $uriScheme
     * @return null|object
     */
    public function getUniversalCommunicationType(?string $number = null, ?string $uriId = null, ?string $uriScheme = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $communicationType = $this->createClassInstance('ram\UniversalCommunicationType');

        $this->tryCall($communicationType, 'setCompleteNumber', $this->getTextType($number));
        $this->tryCall($communicationType, 'setURIID', $this->getIdType($uriId, $uriScheme));

        return $communicationType;
    }

    /**
     * Tax registration type
     *
     * @param  null|string $taxRegType
     * @param  null|string $taxRegId
     * @return null|object
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

        $this->tryCall($taxRegistrationType, 'setID', $this->getIdType($taxRegId, $taxRegType));

        return $taxRegistrationType;
    }

    /**
     * Delivery terms type
     *
     * @param  null|string $code
     * @return null|object
     */
    public function getTradeDeliveryTermsType(?string $code = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeDeliveryTermsType = $this->createClassInstance('ram\TradeDeliveryTermsType');

        $this->tryCall($tradeDeliveryTermsType, 'setDeliveryTypeCode', $this->getTradeDeliveryTermsCodeType($code));

        return $tradeDeliveryTermsType;
    }

    /**
     * Delivery terms code type
     *
     * @param  null|string $code
     * @return null|object
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
     * @param  null|string $id
     * @param  null|string $name
     * @return null|object
     */
    public function getProcuringProjectType(?string $id = null, ?string $name = null): ?object
    {
        if (self::isOneNullOrEmpty(func_get_args())) {
            return null;
        }

        $procuringProjectType = $this->createClassInstance('ram\ProcuringProjectType');

        $this->tryCall($procuringProjectType, 'setID', $this->getIdType($id));
        $this->tryCall($procuringProjectType, 'setName', $this->getTextType($name));

        return $procuringProjectType;
    }

    /**
     * Undocumented function
     *
     * @param  null|DateTimeInterface $date
     * @return null|object
     */
    public function getSupplyChainEventType(?DateTimeInterface $date = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $supplyChainEventType = $this->createClassInstance('ram\SupplyChainEventType');

        $this->tryCall($supplyChainEventType, 'setOccurrenceDateTime', $this->getDateTimeType($date));

        return $supplyChainEventType;
    }

    /**
     * Get instance of TradeSettlementFinancialCardType
     *
     * @param  null|string $type
     * @param  null|string $id
     * @param  null|string $holderName
     * @return null|object
     */
    public function getTradeSettlementFinancialCardType(?string $type = null, ?string $id = null, ?string $holderName = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        // At the moment PCI Security Standards Council has defined that the first 6 digits and
        // last 4 digits are the maximum number of digits to be shown.

        $id = strlen($id) > 4 ? substr($id, 0, 6) . substr($id, -4) : $id;

        $tradeSettlementFinancialCardType = $this->createClassInstance('ram\TradeSettlementFinancialCardType');

        $this->tryCall($tradeSettlementFinancialCardType, 'setID', $this->getIdType($id, $type));
        $this->tryCall($tradeSettlementFinancialCardType, 'setCardholderName', $this->getTextType($holderName));

        return $tradeSettlementFinancialCardType;
    }

    /**
     * Get instance of DebtorFinancialAccountType
     *
     * @param  null|string $iban
     * @return null|object
     */
    public function getDebtorFinancialAccountType(?string $iban = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $debtorFinancialAccountType = $this->createClassInstance('ram\DebtorFinancialAccountType');

        $this->tryCall($debtorFinancialAccountType, 'setIBANID', $this->getIdType($iban));

        return $debtorFinancialAccountType;
    }

    /**
     * Get instance of CreditorFinancialAccountType
     *
     * @param  null|string $iban
     * @param  null|string $accountName
     * @param  null|string $proprietaryId
     * @return null|object
     */
    public function getCreditorFinancialAccountType(?string $iban = null, ?string $accountName = null, ?string $proprietaryId = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $creditorFinancialAccountType = $this->createClassInstance('ram\CreditorFinancialAccountType');

        $this->tryCall($creditorFinancialAccountType, 'setIBANID', $this->getIdType($iban));
        $this->tryCall($creditorFinancialAccountType, 'setAccountName', $this->getTextType($accountName));
        $this->tryCall($creditorFinancialAccountType, 'setProprietaryID', $this->getIdType($proprietaryId));

        return $creditorFinancialAccountType;
    }

    /**
     * Undocumented function
     *
     * @param  null|string $bic
     * @return null|object
     */
    public function getCreditorFinancialInstitutionType(?string $bic = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $creditorFinancialInstitutionType = $this->createClassInstance('ram\CreditorFinancialInstitutionType');

        $this->tryCall($creditorFinancialInstitutionType, 'setBICID', $this->getIdType($bic));

        return $creditorFinancialInstitutionType;
    }

    /**
     * Get instance of TradeSettlementPaymentMeansType
     *
     * @param  null|string $typeCode
     * @param  null|string $information
     * @return null|object
     */
    public function getTradeSettlementPaymentMeansType(?string $typeCode = null, ?string $information = null): ?object
    {
        if (self::isNullOrEmpty($typeCode)) {
            return null;
        }

        $tradeSettlementPaymentMeansType = $this->createClassInstance('ram\TradeSettlementPaymentMeansType');

        $this->tryCall($tradeSettlementPaymentMeansType, 'setTypeCode', $this->getCodeType($typeCode));
        $this->tryCall($tradeSettlementPaymentMeansType, 'setInformation', $this->getTextType($information));

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

        $this->tryCall($tradePaymentTermsType, 'setDescription', $this->getTextType($description));
        $this->tryCall($tradePaymentTermsType, 'setDueDateDateTime', $this->getDateTimeType($dueDate));
        $this->tryCall($tradePaymentTermsType, 'setDirectDebitMandateID', $this->getIdType($directDebitMandateID));
        $this->tryCall($tradePaymentTermsType, 'setPartialPaymentAmount', $this->getAmountType($partialPaymentAmount));

        return $tradePaymentTermsType;
    }

    /**
     * Get instance of TradePaymentDiscountTermsType
     *
     * @param  null|DateTimeInterface $basisDateTime
     * @param  null|float             $basisPeriodMeasureValue
     * @param  null|string            $basisPeriodMeasureUnitCode
     * @param  null|float             $basisAmount
     * @param  null|float             $calculationPercent
     * @param  null|float             $actualDiscountAmount
     * @return null|object
     */
    public function getTradePaymentDiscountTermsType(?DateTimeInterface $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $calculationPercent = null, ?float $actualDiscountAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePaymentDiscountTermsType = $this->createClassInstance('ram\TradePaymentDiscountTermsType');

        $this->tryCall($tradePaymentDiscountTermsType, 'setBasisDateTime', $this->getDateTimeType($basisDateTime));
        $this->tryCall($tradePaymentDiscountTermsType, 'setBasisPeriodMeasure', $this->getMeasureType($basisPeriodMeasureValue, $basisPeriodMeasureUnitCode));
        $this->tryCall($tradePaymentDiscountTermsType, 'setBasisAmount', $this->getAmountType($basisAmount));
        $this->tryCall($tradePaymentDiscountTermsType, 'setCalculationPercent', $this->getPercentType($calculationPercent));
        $this->tryCall($tradePaymentDiscountTermsType, 'setActualDiscountAmount', $this->getAmountType($actualDiscountAmount));

        return $tradePaymentDiscountTermsType;
    }

    /**
     * Get instance of TradePaymentPenaltyTermsType
     *
     * @param  null|DateTimeInterface $basisDateTime
     * @param  null|float             $basisPeriodMeasureValue
     * @param  null|string            $basisPeriodMeasureUnitCode
     * @param  null|float             $basisAmount
     * @param  null|float             $calculationPercent
     * @param  null|float             $actualPenaltyAmount
     * @return null|object
     */
    public function getTradePaymentPenaltyTermsType(?DateTimeInterface $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $calculationPercent = null, ?float $actualPenaltyAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePaymentDiscountTermsType = $this->createClassInstance('ram\TradePaymentPenaltyTermsType');

        $this->tryCall($tradePaymentDiscountTermsType, 'setBasisDateTime', $this->getDateTimeType($basisDateTime));
        $this->tryCall($tradePaymentDiscountTermsType, 'setBasisPeriodMeasure', $this->getMeasureType($basisPeriodMeasureValue, $basisPeriodMeasureUnitCode));
        $this->tryCall($tradePaymentDiscountTermsType, 'setBasisAmount', $this->getAmountType($basisAmount));
        $this->tryCall($tradePaymentDiscountTermsType, 'setCalculationPercent', $this->getPercentType($calculationPercent));
        $this->tryCall($tradePaymentDiscountTermsType, 'setActualPenaltyAmount', $this->getAmountType($actualPenaltyAmount));

        return $tradePaymentDiscountTermsType;
    }

    /**
     * Get instance of TradeTaxType
     * Sales tax breakdown, Umsatzsteueraufschlüsselung
     *
     * @param  null|string            $categoryCode
     * @param  null|string            $typeCode
     * @param  null|float             $basisAmount
     * @param  null|float             $calculatedAmount
     * @param  null|float             $rateApplicablePercent
     * @param  null|string            $exemptionReason
     * @param  null|string            $exemptionReasonCode
     * @param  null|float             $lineTotalBasisAmount
     * @param  null|float             $allowanceChargeBasisAmount
     * @param  null|DateTimeInterface $taxPointDate
     * @param  null|string            $dueDateTypeCode
     * @return null|object
     */
    public function getTradeTaxType(?string $categoryCode = null, ?string $typeCode = null, ?float $basisAmount = null, ?float $calculatedAmount = null, ?float $rateApplicablePercent = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null, ?float $lineTotalBasisAmount = null, ?float $allowanceChargeBasisAmount = null, ?DateTimeInterface $taxPointDate = null, ?string $dueDateTypeCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeTaxType = $this->createClassInstance('ram\TradeTaxType');

        $this->tryCall($tradeTaxType, 'setCalculatedAmount', $this->getAmountType($calculatedAmount));
        $this->tryCall($tradeTaxType, 'setTypeCode', $this->getTaxTypeCodeType($typeCode));
        $this->tryCall($tradeTaxType, 'setExemptionReason', $this->getTextType($exemptionReason));
        $this->tryCall($tradeTaxType, 'setBasisAmount', $this->getAmountType($basisAmount));
        $this->tryCall($tradeTaxType, 'setLineTotalBasisAmount', $this->getAmountType($lineTotalBasisAmount));
        $this->tryCall($tradeTaxType, 'setAllowanceChargeBasisAmount', $this->getAmountType($allowanceChargeBasisAmount));
        $this->tryCall($tradeTaxType, 'setCategoryCode', $this->getTaxCategoryCodeType($categoryCode));
        $this->tryCall($tradeTaxType, 'setExemptionReasonCode', $this->getCodeType($exemptionReasonCode));
        $this->tryCall($tradeTaxType, 'setTaxPointDate', $this->getDateType($taxPointDate));
        $this->tryCall($tradeTaxType, 'setDueDateTypeCode', $this->getTimeReferenceCodeType($dueDateTypeCode));
        $this->tryCall($tradeTaxType, 'setRateApplicablePercent', $this->getPercentType($rateApplicablePercent));

        return $tradeTaxType;
    }

    /**
     * Get Allowance/Charge type
     * Zu- und Abschläge
     *
     * @param  null|float  $actualAmount
     * @param  null|bool   $isCharge
     * @param  null|string $taxTypeCode
     * @param  null|string $taxCategoryCode
     * @param  null|float  $rateApplicablePercent
     * @param  null|float  $sequence
     * @param  null|float  $calculationPercent
     * @param  null|float  $basisAmount
     * @param  null|float  $basisQuantity
     * @param  null|string $basisQuantityUnitCode
     * @param  null|string $reasonCode
     * @param  null|string $reason
     * @return null|object
     */
    public function getTradeAllowanceChargeType(?float $actualAmount = null, ?bool $isCharge = null, ?string $taxTypeCode = null, ?string $taxCategoryCode = null, ?float $rateApplicablePercent = null, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeAllowanceChargeType = $this->createClassInstance('ram\TradeAllowanceChargeType');

        $this->tryCall($tradeAllowanceChargeType, 'setChargeIndicator', $this->getIndicatorType($isCharge));
        $this->tryCall($tradeAllowanceChargeType, 'setSequenceNumeric', $this->getNumericType($sequence));
        $this->tryCall($tradeAllowanceChargeType, 'setCalculationPercent', $this->getPercentType($calculationPercent));
        $this->tryCall($tradeAllowanceChargeType, 'setBasisAmount', $this->getAmountType($basisAmount));
        $this->tryCall($tradeAllowanceChargeType, 'setBasisQuantity', $this->getQuantityType($basisQuantity, $basisQuantityUnitCode));
        $this->tryCall($tradeAllowanceChargeType, 'setActualAmount', $this->getAmountType($actualAmount));
        $this->tryCall($tradeAllowanceChargeType, 'setReasonCode', $this->getCodeType($reasonCode));
        $this->tryCall($tradeAllowanceChargeType, 'setReason', $this->getTextType($reason));

        if (!is_null($taxCategoryCode) && !is_null($taxTypeCode)) {
            $this->tryCall($tradeAllowanceChargeType, 'setCategoryTradeTax', $this->getTradeTaxType($taxCategoryCode, $taxTypeCode, null, null, $rateApplicablePercent));
        }

        return $tradeAllowanceChargeType;
    }

    /**
     * Get instance of
     *
     * @param  null|string             $description
     * @param  null|float              $appliedAmount
     * @param  null|array<int, string> $taxTypeCodes
     * @param  null|array<int, string> $taxCategoryCodes
     * @param  null|array<int, float>  $rateApplicablePercents
     * @return null|object
     */
    public function getLogisticsServiceChargeType(?string $description = null, ?float $appliedAmount = null, ?array $taxTypeCodes = null, ?array $taxCategoryCodes = null, ?array $rateApplicablePercents = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $logisticsServiceChargeType = $this->createClassInstance('ram\LogisticsServiceChargeType');

        $this->tryCall($logisticsServiceChargeType, 'setDescription', $this->getTextType($description));
        $this->tryCall($logisticsServiceChargeType, 'setAppliedAmount', $this->getAmountType($appliedAmount));

        if (!is_null($taxCategoryCodes) && !is_null($taxTypeCodes) && !is_null($rateApplicablePercents)) {
            foreach ($rateApplicablePercents as $index => $rateApplicablePercent) {
                $taxBreakdown = $this->getTradeTaxType($taxCategoryCodes[$index], $taxTypeCodes[$index], null, null, $rateApplicablePercent);
                $this->tryCall($logisticsServiceChargeType, 'addToAppliedTradeTax', $taxBreakdown);
            }
        }

        return $logisticsServiceChargeType;
    }

    /**
     * Get instance of TradeSettlementHeaderMonetarySummationType
     *
     * @param  null|float  $grandTotalAmount
     * @param  null|float  $duePayableAmount
     * @param  null|float  $lineTotalAmount
     * @param  null|float  $chargeTotalAmount
     * @param  null|float  $allowanceTotalAmount
     * @param  null|float  $taxBasisTotalAmount
     * @param  null|float  $taxTotalAmount
     * @param  null|float  $roundingAmount
     * @param  null|float  $totalPrepaidAmount
     * @return null|object
     */
    public function getTradeSettlementHeaderMonetarySummationType(?float $grandTotalAmount = null, ?float $duePayableAmount = null, ?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxBasisTotalAmount = null, ?float $taxTotalAmount = null, ?float $roundingAmount = null, ?float $totalPrepaidAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeSettlementHeaderMonetarySummationType = $this->createClassInstance('ram\TradeSettlementHeaderMonetarySummationType');

        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setLineTotalAmount', $this->getAmountType($lineTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setChargeTotalAmount', $this->getAmountType($chargeTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setAllowanceTotalAmount', $this->getAmountType($allowanceTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setTaxBasisTotalAmount', $this->getAmountType($taxBasisTotalAmount));
        $this->tryCallAll($tradeSettlementHeaderMonetarySummationType, ['addToTaxTotalAmount', 'setTaxTotalAmount'], $this->getAmountType($taxTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setRoundingAmount', $this->getAmountType($roundingAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setGrandTotalAmount', $this->getAmountType($grandTotalAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setTotalPrepaidAmount', $this->getAmountType($totalPrepaidAmount));
        $this->tryCall($tradeSettlementHeaderMonetarySummationType, 'setDuePayableAmount', $this->getAmountType($duePayableAmount));

        return $tradeSettlementHeaderMonetarySummationType;
    }

    /**
     * Create summation class only
     *
     * @return null|object
     */
    public function getTradeSettlementHeaderMonetarySummationTypeOnly(): ?object
    {
        return $this->createClassInstance('ram\TradeSettlementHeaderMonetarySummationType');
    }

    /**
     * Get an instance of TradeAccountingAccountType
     *
     * @param  null|string $id
     * @param  null|string $typeCode
     * @return null|object
     */
    public function getTradeAccountingAccountType(?string $id = null, ?string $typeCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeAccountingAccountType = $this->createClassInstance('ram\TradeAccountingAccountType');

        $this->tryCall($tradeAccountingAccountType, 'setID', $this->getIdType($id));
        $this->tryCall($tradeAccountingAccountType, 'setTypeCode', $this->getCodeType($typeCode));

        return $tradeAccountingAccountType;
    }

    /**
     * Get Document line
     *
     * @param  null|string $lineId
     * @return null|object
     */
    public function getDocumentLineDocumentType(?string $lineId = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $documentLineDocumentType = $this->createClassInstance('ram\DocumentLineDocumentType');

        $this->tryCall($documentLineDocumentType, 'setLineID', $this->getIdType($lineId));

        return $documentLineDocumentType;
    }

    /**
     * Get instance of SupplyChainTradeLineItemType
     *
     * @param  null|string $lineId
     * @param  null|string $lineStatusCode
     * @param  null|string $lineStatusReasonCode
     * @param  bool        $isTextPosition
     * @return null|object
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

        $this->tryCall($supplyChainTradeLineItemType, 'setAssociatedDocumentLineDocument', $doclinedoc);
        $this->tryCall($doclinedoc, 'setLineStatusCode', $this->getCodeType($lineStatusCode));
        $this->tryCall($doclinedoc, 'setLineStatusReasonCode', $this->getCodeType($lineStatusReasonCode));

        if (false === $isTextPosition) {
            $this->tryCall($supplyChainTradeLineItemType, 'setSpecifiedLineTradeAgreement', $lineTradeAgreementType);
            $this->tryCall($supplyChainTradeLineItemType, 'setSpecifiedLineTradeDelivery', $lineTradeDeliveryType);
        }

        $this->tryCall($supplyChainTradeLineItemType, 'setSpecifiedLineTradeSettlement', $lineTradeSettlementType);

        return $supplyChainTradeLineItemType;
    }

    /**
     * Get product specification
     *
     * @param  null|string $name
     * @param  null|string $description
     * @param  null|string $sellerAssignedID
     * @param  null|string $buyerAssignedID
     * @param  null|string $globalIDType
     * @param  null|string $globalID
     * @param  null|string $industryAssignedID
     * @param  null|string $modelID
     * @param  null|string $batchID
     * @param  null|string $brandName
     * @param  null|string $modelName
     * @return null|object
     */
    public function getTradeProductType(?string $name = null, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null, ?string $industryAssignedID = null, ?string $modelID = null, ?string $batchID = null, ?string $brandName = null, ?string $modelName = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeProductType = $this->createClassInstance('ram\TradeProductType');

        $this->tryCall($tradeProductType, 'setGlobalID', $this->getIdType($globalID, $globalIDType));
        $this->tryCall($tradeProductType, 'setSellerAssignedID', $this->getIdType($sellerAssignedID));
        $this->tryCall($tradeProductType, 'setBuyerAssignedID', $this->getIdType($buyerAssignedID));
        $this->tryCall($tradeProductType, 'setName', $this->getTextType($name));
        $this->tryCall($tradeProductType, 'setDescription', $this->getTextType($description));
        $this->tryCall($tradeProductType, 'setIndustryAssignedID', $this->getIdType($industryAssignedID));
        $this->tryCall($tradeProductType, 'setModelID', $this->getIdType($modelID));
        $this->tryCall($tradeProductType, 'addToBatchID', $this->getIdType($batchID));
        $this->tryCall($tradeProductType, 'setBrandName', $this->getTextType($brandName));
        $this->tryCall($tradeProductType, 'setModelName', $this->getTextType($modelName));

        return $tradeProductType;
    }

    /**
     * Get Product Characteristic
     *
     * @param  null|string $typeCode
     * @param  null|string $description
     * @param  null|float  $valueMeasure
     * @param  null|string $valueMeasureUnitCode
     * @param  null|string $value
     * @return null|object
     */
    public function getProductCharacteristicType(?string $typeCode = null, ?string $description = null, ?float $valueMeasure = null, ?string $valueMeasureUnitCode = null, ?string $value = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $productCharacteristicType = $this->createClassInstance('ram\ProductCharacteristicType');

        $this->tryCall($productCharacteristicType, 'setTypeCode', $this->getCodeType($typeCode));
        $this->tryCall($productCharacteristicType, 'setDescription', $this->getTextType($description));
        $this->tryCall($productCharacteristicType, 'setValueMeasure', $this->getMeasureType($valueMeasure, $valueMeasureUnitCode));
        $this->tryCall($productCharacteristicType, 'setValue', $this->getTextType($value));

        return $productCharacteristicType;
    }

    /**
     * Get Product Classification
     *
     * @param  null|string $classCode
     * @param  null|string $className
     * @param  null|string $listID
     * @param  null|string $listVersionID
     * @return null|object
     */
    public function getProductClassificationType(?string $classCode = null, ?string $className = null, ?string $listID = null, ?string $listVersionID = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $productClassificationType = $this->createClassInstance('ram\ProductClassificationType');

        $this->tryCall($productClassificationType, 'setClassCode', $this->getCodeType2($classCode, $listID, $listVersionID));
        $this->tryCall($productClassificationType, 'setClassName', $this->getTextType($className));

        return $productClassificationType;
    }

    /**
     * Get product reference product
     *
     * @param  null|string $globalID
     * @param  null|string $globalIDType
     * @param  null|string $sellerAssignedID
     * @param  null|string $buyerAssignedID
     * @param  null|string $industryAssignedID
     * @param  null|string $name
     * @param  null|string $description
     * @param  null|float  $unitQuantity
     * @param  null|string $unitCode
     * @return null|object
     */
    public function getReferencedProductType(?string $globalID, ?string $globalIDType, ?string $sellerAssignedID, ?string $buyerAssignedID, ?string $industryAssignedID, ?string $name, ?string $description, ?float $unitQuantity, ?string $unitCode): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $referencedProductType = $this->createClassInstance('ram\ReferencedProductType');

        $this->tryCallAll($referencedProductType, ['addToGlobalID', 'setGlobalID'], $this->getIdType($globalID, $globalIDType));
        $this->tryCall($referencedProductType, 'setSellerAssignedID', $this->getIdType($sellerAssignedID));
        $this->tryCall($referencedProductType, 'setBuyerAssignedID', $this->getIdType($buyerAssignedID));
        $this->tryCall($referencedProductType, 'setIndustryAssignedID', $this->getIdType($industryAssignedID));
        $this->tryCall($referencedProductType, 'setName', $this->getTextType($name));
        $this->tryCall($referencedProductType, 'setDescription', $this->getTextType($description));
        $this->tryCall($referencedProductType, 'setUnitQuantity', $this->getQuantityType($unitQuantity, $unitCode));

        return $referencedProductType;
    }

    /**
     * Get trade price
     *
     * @param  null|float  $amount
     * @param  null|float  $basisQuantity
     * @param  null|string $basisQuantityUnitCode
     * @return null|object
     */
    public function getTradePriceType(?float $amount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePriceType = $this->createClassInstance('ram\TradePriceType');

        $this->tryCall($tradePriceType, 'setChargeAmount', $this->getAmountType($amount));
        $this->tryCall($tradePriceType, 'setBasisQuantity', $this->getQuantityType($basisQuantity, $basisQuantityUnitCode));

        return $tradePriceType;
    }

    /**
     * Get Line Summation
     *
     * @param  null|float  $lineTotalAmount
     * @param  null|float  $chargeTotalAmount
     * @param  null|float  $allowanceTotalAmount
     * @param  null|float  $taxTotalAmount
     * @param  null|float  $grandTotalAmount
     * @param  null|float  $totalAllowanceChargeAmount
     * @return null|object
     */
    public function getTradeSettlementLineMonetarySummationType(?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxTotalAmount = null, ?float $grandTotalAmount = null, ?float $totalAllowanceChargeAmount = null): ?object
    {
        if (self::isAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeSettlementLineMonetarySummationType = $this->createClassInstance('ram\TradeSettlementLineMonetarySummationType');

        $this->tryCall($tradeSettlementLineMonetarySummationType, 'setLineTotalAmount', $this->getAmountType($lineTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, 'setChargeTotalAmount', $this->getAmountType($chargeTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, 'setAllowanceTotalAmount', $this->getAmountType($allowanceTotalAmount));
        $this->tryCallAll($tradeSettlementLineMonetarySummationType, ['addToTaxTotalAmount', 'setTaxTotalAmount'], $this->getAmountType($taxTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, 'setGrandTotalAmount', $this->getAmountType($grandTotalAmount));
        $this->tryCall($tradeSettlementLineMonetarySummationType, 'setTotalAllowanceChargeAmount', $this->getAmountType($totalAllowanceChargeAmount));

        return $tradeSettlementLineMonetarySummationType;
    }

    /**
     * Undocumented function
     *
     * @param  null|string            $sourceCurrencyCode
     * @param  null|string            $targetCurrencyCode
     * @param  null|float             $rate
     * @param  null|DateTimeInterface $rateDateTime
     * @return null|object
     */
    public function getTaxApplicableTradeCurrencyExchangeType(?string $sourceCurrencyCode = null, ?string $targetCurrencyCode = null, ?float $rate = null, ?DateTimeInterface $rateDateTime = null): ?object
    {
        if (self::isOneNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeCurrencyExchangeType = $this->createClassInstance('ram\TradeCurrencyExchangeType');

        $this->tryCall($tradeCurrencyExchangeType, 'setSourceCurrencyCode', $this->getIdType($sourceCurrencyCode));
        $this->tryCall($tradeCurrencyExchangeType, 'setTargetCurrencyCode', $this->getIdType($targetCurrencyCode));
        $this->tryCall($tradeCurrencyExchangeType, 'setConversionRate', $this->getRateType($rate));
        $this->tryCall($tradeCurrencyExchangeType, 'setConversionRateDateTime', $this->getDateTimeType($rateDateTime));

        return $tradeCurrencyExchangeType;
    }

    /**
     * Create a datetime object
     *
     * @param  null|string   $dateTimeString
     * @param  null|string   $format
     * @return null|DateTime
     *
     * @throws ValueError
     * @throws ZugferdUnknownDateFormatException
     */
    public function toDateTime(?string $dateTimeString, ?string $format): ?DateTime
    {
        if (self::isNullOrEmpty($dateTimeString) || self::isNullOrEmpty($format)) {
            return null;
        }

        $dateTimeString = trim($dateTimeString);

        if ('102' === $format) {
            return DateTime::createFromFormat('Ymd', $dateTimeString);
        }

        if ('101' === $format) {
            return DateTime::createFromFormat('ymd', $dateTimeString);
        }

        if ('201' === $format) {
            return DateTime::createFromFormat('ymdHi', $dateTimeString);
        }

        if ('202' === $format) {
            return DateTime::createFromFormat('ymdHis', $dateTimeString);
        }

        if ('203' === $format) {
            return DateTime::createFromFormat('YmdHi', $dateTimeString);
        }

        if ('204' === $format) {
            return DateTime::createFromFormat('YmdHis', $dateTimeString);
        }

        if ('610' === $format) {
            return DateTime::createFromFormat('Ym', $dateTimeString)->modify('first day of')->modify('midnight');
        }

        throw new ZugferdUnknownDateFormatException($format);
    }

    /**
     * Get Exchange rate type instance
     *
     * @param  null|float  $rateValue
     * @return null|object
     */
    public function getRateType(?float $rateValue): ?object
    {
        $rateType = $this->createClassInstance('udt\RateType');

        $this->tryCall($rateType, 'value', $rateValue);

        return $rateType;
    }

    /**
     * Creates an instance of a class needed by $invoiceObject
     *
     * @param  string      $classname
     * @param  mixed       $constructorvalue
     * @return null|object
     */
    public function createClassInstance($classname, $constructorvalue = null): ?object
    {
        $className = 'horstoeko\zugferd\entities\\' . $this->profiledef['name'] . '\\' . $classname;

        if (!class_exists($className)) {
            return null;
        }

        return new $className($constructorvalue);
    }

    /**
     * Tries to call a method
     *
     * @param  null|object         $instance
     * @param  string              $method
     * @param  mixed               $value
     * @return ZugferdObjectHelper
     */
    public function tryCall($instance, string $method, $value): self
    {
        if (!$instance) {
            return $this;
        }

        if ('' === $method) {
            return $this;
        }

        if (self::isNullOrEmpty($value)) {
            return $this;
        }

        if ($this->methodExists($instance, $method)) {
            call_user_func([$instance, $method], $value);
        }

        return $this;
    }

    /**
     * Try call all methods
     *
     * @param  null|object         $instance
     * @param  string[]            $methods
     * @param  mixed               $value
     * @return ZugferdObjectHelper
     */
    public function tryCallAll($instance, array $methods, $value): self
    {
        if (!$instance) {
            return $this;
        }

        if (self::isNullOrEmpty($value)) {
            return $this;
        }

        foreach ($methods as $method) {
            if ($this->methodExists($instance, $method)) {
                call_user_func([$instance, $method], $value);

                return $this;
            }
        }

        return $this;
    }

    /**
     * Tries to call a method and return the returnvalue from call to $method
     * in object $instance
     *
     * @param  mixed  $instance
     * @param  string $method
     * @return mixed
     */
    public function tryCallAndReturn($instance, string $method)
    {
        if (!is_object($instance)) {
            return null;
        }

        if ('' === $method) {
            return null;
        }

        if ($this->methodExists($instance, $method)) {
            return call_user_func([$instance, $method]);
        }

        return null;
    }

    /**
     * Try call methods in a form .object.method1.method2.method3
     *
     * @param  null|object $instance
     * @param  string      $methods
     * @param  mixed       $value
     * @return void
     */
    public function tryCallByPath($instance, string $methods, $value)
    {
        $methods = explode('.', $methods);

        foreach ($methods as $index => $method) {
            if ($index === count($methods) - 1) {
                $this->tryCall($instance, $method, $value);
            } else {
                $instance = $this->tryCallAndReturn($instance, $method);
            }
        }
    }

    /**
     * Try call methods in a form .object.method1.method2.method3
     *
     * @param  mixed  $instance
     * @param  string $methods
     * @return mixed
     */
    public function tryCallByPathAndReturn($instance, string $methods)
    {
        $result = null;
        $methods = explode('.', $methods);

        foreach ($methods as $method) {
            $result = $this->tryCallAndReturn($instance, $method);
            $instance = $result;
        }

        return $result;
    }

    /**
     * Call $method if exists, otherwise $method2 is calles with $value
     *
     * @param  null|object         $instance
     * @param  string              $methodToLookFor
     * @param  string              $methodToCall
     * @param  mixed               $value
     * @param  mixed               $value2
     * @return ZugferdObjectHelper
     */
    public function tryCallIfMethodExists($instance, string $methodToLookFor, string $methodToCall, $value, $value2): self
    {
        if (!$instance) {
            return $this;
        }

        if ('' === $methodToLookFor) {
            return $this;
        }

        if ('' === $methodToCall) {
            return $this;
        }

        if (!$this->methodExists($instance, $methodToCall)) {
            return $this;
        }

        if ($this->methodExists($instance, $methodToLookFor)) {
            call_user_func([$instance, $methodToCall], $value);
        } else {
            call_user_func([$instance, $methodToCall], $value2);
        }

        return $this;
    }

    /**
     * Ensure that $input is an array
     *
     * @param  null|array<int, string>|string $input
     * @return array<int, string>
     */
    public function ensureStringArray($input): array
    {
        if (is_array($input)) {
            return $input;
        }

        return [(string) $input];
    }

    /**
     * Ensure array
     *
     * @param  mixed               $value
     * @return array<mixed, mixed>
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
     * @return bool
     */
    public static function isNullOrEmpty($value)
    {
        if (null === $value) {
            return true;
        }

        // (string)false is "", but false is a value: the ?bool arguments of this helper
        // use null for "not supplied" and false for "supplied and false".
        if (is_bool($value)) {
            return false;
        }

        return !is_object($value) && '' === (string) $value;
    }

    /**
     * Checks if all function arguments are null or empty
     *
     * @param  array<int, mixed> $args
     * @return bool
     */
    public static function isAllNullOrEmpty(array $args): bool
    {
        foreach ($args as $arg) {
            if ($arg instanceof DateTimeInterface) {
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
     * @param  array<int, mixed> $args
     * @return bool
     */
    public static function isOneNullOrEmpty(array $args): bool
    {
        foreach ($args as $arg) {
            // A date is never null or empty, and isNullOrEmpty() would cast it to string.
            if ($arg instanceof DateTimeInterface) {
                continue;
            }

            if (self::isNullOrEmpty($arg)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Wrapper for method_exists for use in PHP8
     *
     * @param  null|object|string $instance
     * @param  string             $method
     * @return bool
     */
    public function methodExists($instance, $method): bool
    {
        if (null === $instance) {
            return false;
        }

        if (!is_object($instance) && !is_string($instance)) {
            return false;
        }

        return method_exists($instance, $method);
    }
}
