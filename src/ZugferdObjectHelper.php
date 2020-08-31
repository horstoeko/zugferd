<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\ZUgferdProfiles;
use MimeTyper\Repository\MimeDbRepository;

class ZugferdObjectHelper
{
    /**
     * Internal profile id (see ZugferdProfiles.php)
     *
     * @var integer
     */
    public $profile = -1;

    /**
     * Internal profile definition (see ZugferdProfiles.php)
     *
     * @var array
     */
    public $profiledef = [];

    /**
     * Constructor
     *
     * @param integer $profile
     */
    public function __construct(int $profile)
    {
        $this->profile = $profile;
        $this->profiledef = ZUgferdProfiles::PROFILEDEF[$profile];
    }

    /**
     * Creates an instance of IDType
     *
     * @param string|null $value
     * @param string|null $schemeId
     * @return object
     */
    public function GetIdType(?string $value, ?string $schemeId = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $idType = $this->CreateClassInstance('udt\IDType', $value);

        $this->TryCall($idType, "setSchemeID", $schemeId);

        return $idType;
    }

    /**
     * Creates an instance of TextType
     *
     * @param string|null $value
     * @return object
     */
    public function GetTextType(?string $value): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->CreateClassInstance('udt\TextType', $value);
    }

    /**
     * Creates an instance of CodeType
     *
     * @param string $value
     * @param string $schemeId
     * @return object
     */
    public function GetCodeType(?string $value): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        return $this->CreateClassInstance('udt\CodeType', $value);
    }

    /**
     * Get indicator type
     *
     * @param bool|null $value
     * @return object|null
     */
    public function GetIndicatorType(?bool $value): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $indicator = $this->CreateClassInstance('udt\IndicatorType');

        $this->TryCall($indicator, 'setIndicator', $value);

        return $indicator;
    }

    /**
     * Get Note type
     *
     * @param string|null $content
     * @param string|null $contentCode
     * @param string|null $subjectCode
     * @return void
     */
    public function GetNoteType(?string $content, ?string $contentCode, ?string $subjectCode): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $note = $this->CreateClassInstance('ram\NoteType');

        $this->TryCall($note, 'setContentCode', $this->GetCodeType($contentCode));
        $this->TryCall($note, 'setSubjectCode', $this->GetCodeType($subjectCode));
        $this->TryCall($note, 'setContent', $this->GetTextType($content));

        return $note;
    }

    /**
     * Get formatted issue date
     *
     * @param \DateTime|null $datetime
     * @return object|null
     */
    public function GetFormattedDateTimeType(?\DateTime $datetime): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $date2 = $this->CreateClassInstance('qdt\FormattedDateTimeType\DateTimeStringAType');
        $this->TryCall($date2, "value", $datetime->format("Ymd"));
        $this->TryCall($date2, "setFormat", "102");

        $date = $this->CreateClassInstance('qdt\FormattedDateTimeType');
        $this->TryCall($date, "setDateTimeString", $date2);

        return $date;
    }

    /**
     * Get formatted issue date
     *
     * @param \DateTime|null $datetime
     * @return object|null
     */
    public function GetDateTimeType(?\DateTime $datetime): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $date2 = $this->CreateClassInstance('udt\DateTimeType\DateTimeStringAType');
        $this->TryCall($date2, "value", $datetime->format("Ymd"));
        $this->TryCall($date2, "setFormat", "102");

        $date = $this->CreateClassInstance('udt\DateTimeType');
        $this->TryCall($date, "setDateTimeString", $date2);

        return $date;
    }

    /**
     * Get date
     *
     * @param \DateTime|null $datetime
     * @return object|null
     */
    public function GetDateType(?\DateTime $datetime): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $date2 = $this->CreateClassInstance('udt\DateType\DateStringAType');
        $this->TryCall($date2, "value", $datetime->format("Ymd"));
        $this->TryCall($date2, "setFormat", "102");

        $date = $this->CreateClassInstance('udt\DateType');
        $this->TryCall($date, "setDateString", $date2);

        return $date;
    }

    /**
     * Representation of Amount
     *
     * @param float|null $value
     * @param string|null $currencyCode
     * @return object|null
     */
    public function GetAmountType(?float $value = 0, ?string $currencyCode = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $amount = $this->CreateClassInstance('udt\AmountType');

        $this->TryCall($amount, "value", $value);
        $this->TryCall($amount, "setCurrencyID", $currencyCode);

        return $amount;
    }

    /**
     * Representation of Percdnt
     *
     * @param float|null $value
     * @return object|null
     */
    public function GetPercentType(?float $value = 0): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $amount = $this->CreateClassInstance('udt\PercentType');

        $this->TryCall($amount, "value", $value);

        return $amount;
    }

    /**
     * Representation of Quantity
     *
     * @param float|null $value
     * @param string|null $unitCode
     * @return object|null
     */
    public function GetQuantityType(?float $value = 0, ?string $unitCode = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $amount = $this->CreateClassInstance('udt\QuantityType');

        $this->TryCall($amount, "value", $value);
        $this->TryCall($amount, "setUnitCode", $unitCode);

        return $amount;
    }

    /**
     * Representation of Quantity Measure
     *
     * @param float|null $value
     * @param string|null $unitCode
     * @return object|null
     */
    public function GetMeasureType(?float $value = 0, ?string $unitCode = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $measure = $this->CreateClassInstance('udt\MeasureType');

        $this->TryCall($measure, "value", $value);
        $this->TryCall($measure, "setUnitCode", $unitCode);

        return $measure;
    }

    /**
     * Get an instance of GetNumericType
     *
     * @param float|null $number
     * @return object|null
     */
    public function GetNumericType(?float $value = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $numericType = $this->CreateClassInstance('udt\NumericType');

        $this->TryCall($numericType, 'value', $value);

        return $numericType;
    }

    /**
     * Representation of Tax Category
     *
     * @param string|null $categoryCode
     * @return object|null
     */
    public function GetTaxCategoryCodeType(?string $taxCategoryCode): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $category = $this->CreateClassInstance('qdt\TaxCategoryCodeType');

        $this->TryCall($category, "value", $taxCategoryCode);

        return $category;
    }

    /**
     * Representation of Tax Type
     *
     * @param string|null $taxTypeCode
     * @return object|null
     */
    public function GetTaxTypeCodeType(?string $taxTypeCode): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $category = $this->CreateClassInstance('qdt\TaxTypeCodeType');

        $this->TryCall($category, "value", $taxTypeCode);

        return $category;
    }

    /**
     * Representation of Time Reference Code
     *
     * @param string|null $timerefCode
     * @return object|null
     */
    public function GetTimeReferenceCodeType(?string $value): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $category = $this->CreateClassInstance('qdt\TimeReferenceCodeType');

        $this->TryCall($category, "value", $value);

        return $category;
    }

    /**
     * Get Specified Period type
     *
     * @param \DateTime|null $startdate
     * @param \DateTime|null $endDate
     * @param \DateTime|null $completedate
     * @param string|null $description
     * @return object|null
     */
    public function GetSpecifiedPeriodType(?\DateTime $startdate, ?\DateTime $endDate, ?\DateTime $completedate, ?string $description): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $period = $this->CreateClassInstance('ram\SpecifiedPeriodType');

        $this->TryCall($period, 'setDescription', $this->GetTextType($description));
        $this->TryCall($period, 'setStartDateTime', $this->GetDateTimeType($startdate));
        $this->TryCall($period, 'setEndDateTime', $this->GetDateTimeType($endDate));
        $this->TryCall($period, 'setCompleteDateTime', $this->GetDateTimeType($completedate));

        return $period;
    }

    /**
     * Get a BinaryObjectType object
     *
     * @param string $value
     * @param string $mimetype
     * @param string $filename
     * @return object|null
     */
    public function GetBinaryObjectType(string $binarydata, string $mimetype, string $filename): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $binaryobject = $this->CreateClassInstance('udt\BinaryObjectType');

        $this->TryCall($binaryobject, "value", $binarydata);
        $this->TryCall($binaryobject, "setMimeCode", $mimetype);
        $this->TryCall($binaryobject, "setFilename", $filename);

        return $binaryobject;
    }

    /**
     * Get a reference document object
     *
     * @param string|null $issuerassignedid
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $typecode
     * @param string|array|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return object|null
     */
    public function GetReferencedDocumentType(?string $issuerassignedid, ?string $uriid, ?string $lineid, ?string $typecode, $name, ?string $reftypecode, ?\DateTime $issueddate, ?string $binarydatafilename): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $refdoctype = $this->CreateClassInstance('ram\ReferencedDocumentType', $issuerassignedid);

        $this->TryCall($refdoctype, 'setIssuerAssignedID', $this->GetIdType($issuerassignedid));
        $this->TryCall($refdoctype, 'setURIID', $this->GetIdType($uriid));
        $this->TryCall($refdoctype, 'setLineID', $this->GetIdType($lineid));
        $this->TryCall($refdoctype, 'setTypeCode', $this->GetCodeType($typecode));
        $this->TryCall($refdoctype, 'setReferenceTypeCode', $this->GetCodeType($reftypecode));
        $this->TryCall($refdoctype, 'setFormattedIssueDateTime', $this->GetFormattedDateTimeType($issueddate));

        foreach ($this->EnsureStringArray($name) as $name) {
            $this->TryCall($refdoctype, 'addToName', $this->GetTextType($name));
        }

        if ($binarydatafilename) {
            if (file_exists($binarydatafilename) && is_readable($binarydatafilename)) {
                $mimetyper = new MimeDbRepository();
                $content = base64_encode(file_get_contents($binarydatafilename));
                $pathParts = pathinfo($binarydatafilename);
                $this->TryCall(
                    $refdoctype,
                    'setAttachmentBinaryObject',
                    $this->GetBinaryObjectType($content, $mimetyper->findType($pathParts["extension"]), $pathParts["basename"]));
            }
        }

        return $refdoctype;
    }

    /**
     * Undocumented function
     *
     * @return \horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoiceType|\horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoiceType|\horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoiceType|\horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoiceType
     */
    public function GetCrossIndustryInvoice()
    {
        $result = $this->CreateClassInstance('rsm\CrossIndustryInvoice');
        $result->setExchangedDocumentContext($this->CreateClassInstance('ram\ExchangedDocumentContextType'));
        $result->setExchangedDocument($this->CreateClassInstance('ram\ExchangedDocumentType'));
        $result->setSupplyChainTradeTransaction($this->CreateClassInstance('ram\SupplyChainTradeTransactionType'));
        $result->getExchangedDocumentContext()->setGuidelineSpecifiedDocumentContextParameter($this->CreateClassInstance('ram\DocumentContextParameterType'));
        $result->getExchangedDocumentContext()->getGuidelineSpecifiedDocumentContextParameter()->setID($this->GetIdType($this->profiledef['contextparameter']));
        $result->getSupplyChainTradeTransaction()->setApplicableHeaderTradeAgreement($this->CreateClassInstance('ram\HeaderTradeAgreementType'));
        $result->getSupplyChainTradeTransaction()->setApplicableHeaderTradeDelivery($this->CreateClassInstance('ram\HeaderTradeDeliveryType'));
        $result->getSupplyChainTradeTransaction()->setApplicableHeaderTradeSettlement($this->CreateClassInstance('ram\HeaderTradeSettlementType'));

        return $result;
    }

    /**
     * Tradeparty type
     *
     * @param string $name
     * @param string|null $ID
     * @param string|null $description
     * @return object|null
     */
    public function GetTradeParty(string $name, ?string $ID, ?string $description): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradeParty = $this->CreateClassInstance('ram\TradePartyType');

        $this->TryCall($tradeParty, "addToID", $this->GetIdType($ID));
        $this->TryCall($tradeParty, "setName", $this->GetTextType($name));
        $this->TryCall($tradeParty, "setDescription", $this->GetTextType($description));

        return $tradeParty;
    }

    /**
     * Address type
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return object|null
     */
    public function GetTradeAddress(?string $lineone, ?string $linetwo, ?string $linethree, ?string $postcode, ?string $city, ?string $country, ?string $subdivision): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $address = $this->CreateClassInstance('ram\TradeAddressType');

        $this->TryCall($address, "setLineOne", $this->GetTextType($lineone));
        $this->TryCall($address, "setLineTwo", $this->GetTextType($linetwo));
        $this->TryCall($address, "setLineThree", $this->GetTextType($linethree));
        $this->TryCall($address, "setPostcodeCode", $this->GetCodeType($postcode));
        $this->TryCall($address, "setCityName", $this->GetTextType($city));
        $this->TryCall($address, "setCountryID", $this->GetCodeType($country));
        $this->TryCall($address, "addToCountrySubDivisionName", $this->GetTextType($subdivision));

        return $address;
    }

    /**
     * Legal organization type
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return object|null
     */
    public function GetLegalOrganization(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $legalorg = $this->CreateClassInstance('ram\LegalOrganizationType', $legalorgname);

        $this->TryCall($legalorg, "setID", $this->GetIdType($legalorgid, $legalorgtype));
        $this->TryCall($legalorg, "setTradingBusinessName", $this->GetTextType($legalorgname));

        return $legalorg;
    }

    /**
     * Contact type
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailaddr
     * @return object|null
     */
    public function GetTradeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailaddr): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $contact = $this->CreateClassInstance('ram\TradeContactType', $contactpersonname);
        $contactphone = $this->GetUniversalCommunicationType($contactphoneno, null, null);
        $contactfax = $this->GetUniversalCommunicationType($contactfaxno, null, null);
        $contactemail = $this->GetUniversalCommunicationType(null, $contactemailaddr, "SMTP");

        $this->TryCall($contact, "setPersonName", $this->GetTextType($contactpersonname));
        $this->TryCall($contact, "setDepartmentName", $this->GetTextType($contactdepartmentname));
        $this->TryCall($contact, "setTelephoneUniversalCommunication", $contactphone);
        $this->TryCall($contact, "setFaxUniversalCommunication", $contactfax);
        $this->TryCall($contact, "setEmailURIUniversalCommunication", $contactemail);

        return $contact;
    }

    /**
     * Communication type
     *
     * @param string|null $number
     * @param string|null $uriid
     * @param string $urischeme
     * @return object|null
     */
    public function GetUniversalCommunicationType(?string $number, ?string $uriid, ?string $urischeme = "SMTP"): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $communication = $this->CreateClassInstance('ram\UniversalCommunicationType');

        $this->TryCall($communication, "setCompleteNumber", $this->GetTextType($number));
        $this->TryCall($communication, "setURIID", $this->GetIdType($uriid, $urischeme));

        return $communication;
    }

    /**
     * Tax registration type
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return object|null
     */
    public function GetTaxRegistrationType(?string $taxregtype, ?string $taxregid): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $taxreg = $this->CreateClassInstance('ram\TaxRegistrationType');

        $this->TryCall($taxreg, "setID", $this->GetIdType($taxregid, $taxregtype));

        return $taxreg;
    }

    /**
     * Delivery terms type
     *
     * @param string|null $code
     * @return object|null
     */
    public function GetTradeDeliveryTermsType(?string $code): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $deliveryterms = $this->CreateClassInstance('ram\TradeDeliveryTermsType');

        $this->TryCall($deliveryterms, "setDeliveryTypeCode", $this->GetCodeType($code));

        return $deliveryterms;
    }

    /**
     * Procuring project type
     *
     * @param string|null $id
     * @param string|null $name
     * @return object|null
     */
    public function GetProcuringProjectType(?string $id, ?string $name): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $procuringproject = $this->CreateClassInstance('ram\ProcuringProjectType');

        $this->TryCall($procuringproject, "setID", $this->GetIdType($id));
        $this->TryCall($procuringproject, "setName", $this->GetTextType($name));

        return $procuringproject;
    }

    /**
     * Undocumented function
     *
     * @param \DateTime|null $date
     * @return object|null
     */
    public function GetSupplyChainEventType(?\DateTime $date): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $supplychainevent = $this->CreateClassInstance('ram\SupplyChainEventType');

        $this->TryCall($supplychainevent, "setOccurrenceDateTime", $this->GetDateTimeType($date));

        return $supplychainevent;
    }

    /**
     * Get instance of TradeSettlementFinancialCardType
     *
     * @param string|null $type
     * @param string|null $id
     * @param string|null $holderName
     * @return object|null
     */
    public function GetTradeSettlementFinancialCardType(?string $type, ?string $id, ?string $holderName): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $card = $this->CreateClassInstance('ram\TradeSettlementFinancialCardType');

        $this->TryCall($card, "setID", $this->GetIdType($id, $type));
        $this->TryCall($card, "setCardholderName", $this->GetTextType($holderName));

        return $card;
    }

    /**
     * Get instance of DebtorFinancialAccountType
     *
     * @param string|null $iban
     * @return object|null
     */
    public function GetDebtorFinancialAccountType(?string $iban): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $card = $this->CreateClassInstance('ram\DebtorFinancialAccountType');

        $this->TryCall($card, "setIBANID", $this->GetIdType($iban));

        return $card;
    }

    /**
     * Get instance of CreditorFinancialAccountType
     *
     * @param string|null $iban
     * @param string|null $accountName
     * @param string|null $proprietaryID
     * @return object|null
     */
    public function GetCreditorFinancialAccountType(?string $iban, ?string $accountName, ?string $proprietaryID): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $account = $this->CreateClassInstance('ram\CreditorFinancialAccountType');

        $this->TryCall($account, "setIBANID", $this->GetIdType($iban));
        $this->TryCall($account, "setAccountName", $this->GetTextType($accountName));
        $this->TryCall($account, "setProprietaryID", $this->GetIdType($proprietaryID));

        return $account;
    }

    /**
     * Undocumented function
     *
     * @param string|null $bic
     * @return object|null
     */
    public function GetCreditorFinancialInstitutionType(?string $bic): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $institution = $this->CreateClassInstance('ram\CreditorFinancialInstitutionType');

        $this->TryCall($institution, "setBICID", $this->GetIdType($bic));

        return $institution;
    }

    /**
     * Get instance of TradeSettlementPaymentMeansType
     *
     * @return objeect|null
     */
    public function GetTradeSettlementPaymentMeansType(string $code, ?string $information): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $paymentMeans = $this->CreateClassInstance('ram\TradeSettlementPaymentMeansType');

        $this->TryCall($paymentMeans, "setTypeCode", $this->GetCodeType($code));
        $this->TryCall($paymentMeans, "setInformation", $this->GetTextType($information));

        return $paymentMeans;
    }

    /**
     * Get instance of TradePaymentTermsType
     *
     * @param string|null $description
     * @param \DateTime|null $dueDate
     * @param string|null $directDebitMandateID
     * @return object|null
     */
    public function GetTradePaymentTermsType(?string $description = null, ?\DateTime $dueDate = null, ?string $directDebitMandateID = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $paymentTerms = $this->CreateClassInstance('ram\TradePaymentTermsType');

        $this->TryCall($paymentTerms, "setDescription", $this->GetTextType($description));
        $this->TryCall($paymentTerms, "setDueDateDateTime", $this->GetDateTimeType($dueDate));
        $this->TryCall($paymentTerms, "setDirectDebitMandateID", $this->GetIdType($directDebitMandateID));

        return $paymentTerms;
    }

    /**
     * Get instance of TradePaymentDiscountTermsType
     *
     * @param \DateTime|null $basisDateTime
     * @param float|null $basisPeriodMeasureValue
     * @param string|null $basisPeriodMeasureUnitCode
     * @param float|null $basisAmount
     * @param float|null $calculationPercent
     * @param float|null $actualDiscountAmount
     * @return object|null
     */
    public function GetTradePaymentDiscountTermsType(?\DateTime $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $calculationPercent = null, ?float $actualDiscountAmount = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $discountTerms = $this->CreateClassInstance('ram\TradePaymentDiscountTermsType');

        $this->TryCall($discountTerms, "setBasisDateTime", $this->GetDateTimeType($basisDateTime));
        $this->TryCall($discountTerms, "setBasisPeriodMeasure", $this->GetMeasureType($basisPeriodMeasureValue, $basisPeriodMeasureUnitCode));
        $this->TryCall($discountTerms, "setBasisAmount", $this->GetAmountType($basisAmount));
        $this->TryCall($discountTerms, "setCalculationPercent", $this->GetPercentType($calculationPercent));
        $this->TryCall($discountTerms, "setActualDiscountAmount", $this->GetAmountType($actualDiscountAmount));

        return $discountTerms;
    }

    /**
     * Get instance of TradeTaxType
     * Sales tax breakdown, Umsatzsteueraufschlüsselung
     *
     * @param string|null $categoryCode
     * @param string|null $typeCode
     * @param float|null $basisAmount
     * @param float|null $calculatedAmount
     * @param string|null $exemptionReasonCode
     * @param string|null $exemptionReason
     * @param float|null $lineTotalBasisAmount
     * @param float|null $allowanceChargeBasisAmount
     * @param \DateTime|null $taxPointDate
     * @param string|null $dueDateTypeCode
     * @param string|null $rateApplicablePercent
     * @return object|null
     */
    public function GetTradeTaxType(?string $categoryCode = null, ?string $typeCode = null, ?float $basisAmount = null, ?float $calculatedAmount = null, ?float $rateApplicablePercent = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null, ?float $lineTotalBasisAmount = null, ?float $allowanceChargeBasisAmount = null, ?\DateTime $taxPointDate = null, ?string $dueDateTypeCode = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $taxBreakdown = $this->CreateClassInstance('ram\TradeTaxType');

        $this->TryCall($taxBreakdown, "setCalculatedAmount", $this->GetAmountType($calculatedAmount));
        $this->TryCall($taxBreakdown, "setTypeCode", $this->GetTaxTypeCodeType($typeCode));
        $this->TryCall($taxBreakdown, "setExemptionReason", $this->GetTextType($exemptionReason));
        $this->TryCall($taxBreakdown, "setBasisAmount", $this->GetAmountType($basisAmount));
        $this->TryCall($taxBreakdown, "setLineTotalBasisAmount", $this->GetAmountType($lineTotalBasisAmount));
        $this->TryCall($taxBreakdown, "setAllowanceChargeBasisAmount", $this->GetAmountType($allowanceChargeBasisAmount));
        $this->TryCall($taxBreakdown, "setCategoryCode", $this->GetTaxCategoryCodeType($categoryCode));
        $this->TryCall($taxBreakdown, "setExemptionReasonCode", $this->GetCodeType($exemptionReasonCode));
        $this->TryCall($taxBreakdown, "setTaxPointDate", $this->GetDateType($taxPointDate));
        $this->TryCall($taxBreakdown, "setDueDateTypeCode", $this->GetTimeReferenceCodeType($dueDateTypeCode));
        $this->TryCall($taxBreakdown, "setRateApplicablePercent", $this->GetPercentType($rateApplicablePercent));

        return $taxBreakdown;
    }

    /**
     * Get Allowance/Charge type
     * Zu- und Abschläge
     *
     * @param float|null $actualAmount
     * @param boolean|null $isCharge
     * @param string|null $taxTypeCode
     * @param string|null $taxCategoryCode
     * @param float|null $rateApplicablePercent
     * @param float|null $sequence
     * @param float|null $calculationPercent
     * @param float|null $basisAmount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @param string|null $reasonCode
     * @param string|null $reason
     * @return object|null
     */
    public function GetTradeAllowanceChargeType(?float $actualAmount = null, ?bool $isCharge = null, ?string $taxTypeCode = null, ?string $taxCategoryCode = null, ?float $rateApplicablePercent = null, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $allowanceCharge = $this->CreateClassInstance('ram\TradeAllowanceChargeType');

        $this->TryCall($allowanceCharge, "setChargeIndicator", $this->GetIndicatorType($isCharge));
        $this->TryCall($allowanceCharge, "setSequenceNumeric", $this->GetNumericType($sequence));
        $this->TryCall($allowanceCharge, "setCalculationPercent", $this->GetPercentType($calculationPercent));
        $this->TryCall($allowanceCharge, "setBasisAmount", $this->GetAmountType($basisAmount));
        $this->TryCall($allowanceCharge, "setBasisQuantity", $this->GetQuantityType($basisQuantity, $basisQuantityUnitCode));
        $this->TryCall($allowanceCharge, "setActualAmount", $this->GetAmountType($actualAmount));
        $this->TryCall($allowanceCharge, "setReasonCode", $this->GetCodeType($reasonCode));
        $this->TryCall($allowanceCharge, "setReason", $this->GetTextType($reason));

        if (!is_null($taxCategoryCode) && !is_null($taxTypeCode) && !is_null($rateApplicablePercent)) {
            $this->TryCall($allowanceCharge, "setCategoryTradeTax", $this->GetTradeTaxType($taxCategoryCode, $taxTypeCode, null, null, $rateApplicablePercent));
        }

        return $allowanceCharge;
    }

    /**
     * Get instance of
     *
     * @param string|null $description
     * @param float|null $appliedAmount
     * @param array|null $taxTypeCodes
     * @param array|null $taxCategpryCodes
     * @param array|null $rateApplicablePercents
     * @return object|null
     */
    public function GetLogisticsServiceChargeType(?string $description = null, ?float $appliedAmount = null, ?array $taxTypeCodes = null, ?array $taxCategpryCodes = null, ?array $rateApplicablePercents = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $logCharge = $this->CreateClassInstance('ram\LogisticsServiceChargeType');

        $this->TryCall($logCharge, "setDescription", $this->GetTextType($description));
        $this->TryCall($logCharge, "setAppliedAmount", $this->GetAmountType($appliedAmount));

        if (!is_null($taxCategpryCodes) && !is_null($taxTypeCodes) && !is_null($rateApplicablePercents)) {
            foreach ($rateApplicablePercents as $index => $rateApplicablePercent) {
                $taxBreakdown = $this->GetTradeTaxType($taxCategpryCodes[$index], $taxTypeCodes[$index], null, null, $rateApplicablePercent);
                $this->TryCall($logCharge, "addToAppliedTradeTax", $taxBreakdown);
            }
        }

        return $logCharge;
    }

    /**
     * Get instance of TradeSettlementHeaderMonetarySummationType
     *
     * @param float|null $grandTotalAmount
     * @param float|null $duePayableAmount
     * @param float|null $lineTotalAmount
     * @param float|null $chargeTotalAmount
     * @param float|null $allowanceTotalAmount
     * @param float|null $taxBasisTotalAmount
     * @param float|null $taxTotalAmount
     * @param float|null $roundingAmount
     * @param float|null $totalPrepaidAmount
     * @return object|null
     */
    public function GetTradeSettlementHeaderMonetarySummationType(?float $grandTotalAmount = null, ?float $duePayableAmount = null, ?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxBasisTotalAmount = null, ?float $taxTotalAmount = null, ?float $roundingAmount = null, ?float $totalPrepaidAmount = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $summation = $this->CreateClassInstance('ram\TradeSettlementHeaderMonetarySummationType');

        $this->TryCall($summation, "setLineTotalAmount", $this->GetAmountType($lineTotalAmount));
        $this->TryCall($summation, "setChargeTotalAmount", $this->GetAmountType($chargeTotalAmount));
        $this->TryCall($summation, "setAllowanceTotalAmount", $this->GetAmountType($allowanceTotalAmount));
        $this->TryCallAll($summation, ["addToTaxBasisTotalAmount", "setTaxBasisTotalAmount"], $this->GetAmountType($taxBasisTotalAmount));
        $this->TryCallAll($summation, ["addToTaxTotalAmount", "setTaxTotalAmount"], $this->GetAmountType($taxTotalAmount));
        $this->TryCall($summation, "setRoundingAmount", $this->GetAmountType($roundingAmount));
        $this->TryCallAll($summation, ["addToGrandTotalAmount", "setGrandTotalAmount"], $this->GetAmountType($grandTotalAmount));
        $this->TryCall($summation, "setTotalPrepaidAmount", $this->GetAmountType($totalPrepaidAmount));
        $this->TryCall($summation, "setDuePayableAmount", $this->GetAmountType($duePayableAmount));

        return $summation;
    }

    /**
     * Get an instance of TradeAccountingAccountType
     *
     * @param string|null $id
     * @param string|null $typeCode
     * @return object|null
     */
    public function GetTradeAccountingAccountType(?string $id = null, ?string $typeCode): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $account = $this->CreateClassInstance('ram\TradeAccountingAccountType');

        $this->TryCall($account, "setID", $this->GetIdType($id));
        $this->TryCall($account, "setTypeCode", $this->GetCodeType($typeCode));

        return $account;
    }

    /**
     * Get Document line
     *
     * @param string|null $lineid
     * @return object|null
     */
    public function GetDocumentLineDocumentType(?string $lineid = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $doclinedoc = $this->CreateClassInstance('ram\DocumentLineDocumentType');

        $this->TryCall($doclinedoc, "setLineID", $this->GetIdType($lineid));

        return $doclinedoc;
    }

    /**
     * Get instance of SupplyChainTradeLineItemType
     *
     * @param string|null $lineid
     * @param string|null $lineStatusCode
     * @param string|null $lineStatusReasonCode
     * @return object|null
     */
    public function GetSupplyChainTradeLineItemType(?string $lineid = null, ?string $lineStatusCode = null, ?string $lineStatusReasonCode = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $line = $this->CreateClassInstance('ram\SupplyChainTradeLineItemType');
        $doclinedoc = $this->GetDocumentLineDocumentType($lineid);
        $lineAgreement = $this->CreateClassInstance('ram\LineTradeAgreementType');
        $lineDelivery = $this->CreateClassInstance('ram\LineTradeDeliveryType');
        $lineSettlement = $this->CreateClassInstance('ram\LineTradeSettlementType');

        $this->TryCall($line, "setAssociatedDocumentLineDocument", $doclinedoc);
        $this->TryCall($doclinedoc, "setLineStatusCode", $this->GetCodeType($lineStatusCode));
        $this->TryCall($doclinedoc, "setLineStatusReasonCode", $this->GetCodeType($lineStatusReasonCode));
        $this->TryCall($line, "setSpecifiedLineTradeAgreement", $lineAgreement);
        $this->TryCall($line, "setSpecifiedLineTradeDelivery", $lineDelivery);
        $this->TryCall($line, "setSpecifiedLineTradeSettlement", $lineSettlement);

        return $line;
    }

    /**
     * Get product specification
     *
     * @param string $name
     * @param string|null $description
     * @param string|null $sellerAssignedID
     * @param string|null $buyerAssignedID
     * @param string|null $globalIDType
     * @param string|null $globalID
     * @return object|null
     */
    public function GetTradeProductType(?string $name = null, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $product = $this->CreateClassInstance('ram\TradeProductType');

        $this->TryCall($product, "setGlobalID", $this->GetIdType($globalID, $globalIDType));
        $this->TryCall($product, "setSellerAssignedID", $this->GetIdType($sellerAssignedID));
        $this->TryCall($product, "setBuyerAssignedID", $this->GetIdType($buyerAssignedID));
        $this->TryCall($product, "setName", $this->GetTextType($name));
        $this->TryCall($product, "setDescription", $this->GetTextType($description));

        return $product;
    }

    /**
     * Get trade price
     *
     * @param float|null $amount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @return object|null
     */
    public function GetTradePriceType(?float $amount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $tradePrice = $this->CreateClassInstance('ram\TradePriceType');

        $this->TryCall($tradePrice, "setChargeAmount", $this->GetAmountType($amount));
        $this->TryCall($tradePrice, "setBasisQuantity", $this->GetQuantityType($basisQuantity, $basisQuantityUnitCode));

        return $tradePrice;
    }

    /**
     * Get Line Summation
     *
     * @param float|null $lineTotalAmount
     * @param float|null $totalAllowanceChargeAmount
     * @return object|null
     */
    public function GetTradeSettlementLineMonetarySummationType(?float $lineTotalAmount = null, ?float $totalAllowanceChargeAmount = null): ?object
    {
        if (self::IsAllNullOrEmpty(func_get_args())) {
            return null;
        }

        $summation = $this->CreateClassInstance('ram\TradeSettlementLineMonetarySummationType');

        $this->TryCall($summation, "setLineTotalAmount", $this->GetAmountType($lineTotalAmount));
        $this->TryCall($summation, "setTotalAllowanceChargeAmount", $this->GetAmountType($totalAllowanceChargeAmount));

        return $summation;
    }

    /**
     * Creates an instance of a class needed by $invoiceObject
     *
     * @param string $className
     * @param mixed $constructorvalue
     * @return object|null
     */
    public function CreateClassInstance($classname, $constructorvalue = null): ?object
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
     * @param object $instance
     * @param string $method
     * @param mixed $value
     * @return ZugferdObjectHelper
     */
    public function TryCall($instance, $method, $value): ZugferdObjectHelper
    {
        if (!$instance) {
            return $this;
        }
        if (!$method) {
            return $this;
        }
        if (is_null($value)) {
            return $this;
        }
        if (method_exists($instance, $method)) {
            $instance->$method($value);
        }
        return $this;
    }

    /**
     * Try call all methods
     *
     * @param object $instance
     * @param string[] $methods
     * @param mixed $value
     * @return ZugferdObjectHelper
     */
    public function TryCallAll($instance, array $methods, $value): ZugferdObjectHelper
    {
        if (!$instance) {
            return $this;
        }
        if (is_null($value)) {
            return $this;
        }
        foreach ($methods as $method) {
            if (method_exists($instance, $method)) {
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
     * @param object $instance
     * @param string $method
     * @return mixed
     */
    public function TryCallAndReturn($instance, $method)
    {
        if (!$instance) {
            return null;
        }
        if (!$method) {
            return null;
        }
        if (method_exists($instance, $method)) {
            return $instance->$method();
        }
        return null;
    }

    /**
     * Try call methods in a form .object.method1.method2.method3
     *
     * @param [type] $instance
     * @param string $methods
     * @return void
     */
    public function TryCallByPath($instance, string $methods, $value)
    {
        $methods = explode(".", $methods);

        foreach ($methods as $index => $method) {
            if ($index == count($methods) - 1) {
                $this->TryCall($instance, $method, $value);
            } else {
                $instance = $this->TryCallAndReturn($instance, $method, $value);
            }
        }
    }

    /**
     * Try call methods in a form .object.method1.method2.method3
     *
     * @param object $instance
     * @param string $methods
     * @return mixed
     */
    public function TryCallByPathAndReturn($instance, string $methods)
    {
        $result = null;
        $methods = explode(".", $methods);

        foreach ($methods as $method) {
            $result = $this->TryCallAndReturn($instance, $method);
            $instance = $result;
        }

        return $result;
    }

    /**
     * Ensure that $input is an array
     *
     * @param mixed $input
     * @return array
     */
    public function EnsureStringArray($input): array
    {
        if (is_array($input)) {
            return $input;
        }
        return [(string) $input];
    }

    /**
     * Test if a value is null or empty
     *
     * @param mixed $value
     * @return boolean
     */
    public static function IsNullOrEmpty($value)
    {
        if (is_null($value) || $value === null) {
            return true;
        }
        if ((string) $value === "") {
            return true;
        }
        return false;
    }

    /**
     * Checks if all function arguments are null or empty
     *
     * @param array $args
     * @return boolean
     */
    public static function IsAllNullOrEmpty(array $args): bool
    {
        foreach ($args as $arg) {
            if ($arg instanceof \DateTime) {
                if (!is_null($arg)) {
                    return false;
                }
            } else {
                if (!self::IsNullOrEmpty($arg)) {
                    return false;
                }
            }
        }
        return true;
    }
}
