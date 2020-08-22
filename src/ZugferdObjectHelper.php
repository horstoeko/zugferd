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
        $idType = $this->CreateClassInstanceIf('udt\IDType', $value, $value);

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
        return $this->CreateClassInstanceIf('udt\TextType', $value, $value);
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
        return $this->CreateClassInstanceIf('udt\CodeType', $value, $value);
    }

    /**
     * Get indicator type
     *
     * @param bool|null $value
     * @return object|null
     */
    public function GetIndicatorType(?bool $value): ?object
    {
        $indicator = $this->CreateClassInstanceIf('udt\IndicatorType', null, $value === true);

        $this->TryCall($indicator, 'setIndicator', $value);

        return $indicator;
    }

    /**
     * Get Note type
     *
     * @param string $content
     * @param string|null $contentCode
     * @param string|null $subjectCode
     * @return void
     */
    public function GetNoteType(string $content, ?string $contentCode, ?string $subjectCode): ?object
    {
        $note = $this->CreateClassInstanceIf('ram\NoteType', null, $content);

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
        if ($datetime == null) {
            return null;
        }

        $date2 = $this->CreateClassInstance('qdt\FormattedDateTimeType\DateTimeStringAType');
        $this->TryCall($date2, "value", $datetime->format("Y-m-d"));
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
        if ($datetime == null) {
            return null;
        }

        $date2 = $this->CreateClassInstance('udt\DateTimeType\DateTimeStringAType');
        $this->TryCall($date2, "value", $datetime->format("Y-m-d"));
        $this->TryCall($date2, "setFormat", "102");

        $date = $this->CreateClassInstance('udt\DateTimeType');
        $this->TryCall($date, "setDateTimeString", $date2);

        return $date;
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
        $period = $this->CreateClassInstanceIf('ram\SpecifiedPeriodType', null, (($startdate && $endDate) || $completedate));
        
        $this->TryCall($period, 'setDescription', $description);
        $this->TryCall($period, 'getStartDateTime', $this->GetDateTimeType($startdate));
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
        $binaryobject = $this->CreateClassInstance('udt\BinaryObjectType');

        $this->TryCall($binaryobject, "value", $binarydata);
        $this->TryCall($binaryobject, "setMimeCode", $mimetype);
        $this->TryCall($binaryobject, "setFilename", $filename);

        return $binaryobject;
    }

    /**
     * Get a reference document object
     *
     * @param string $issuerassignedid
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $typecode
     * @param string|array|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return object|null
     */
    public function GetReferencedDocumentType(string $issuerassignedid, ?string $uriid, ?string $lineid, ?string $typecode, $name, ?string $reftypecode, ?\DateTime $issueddate, ?string $binarydatafilename): ?object
    {
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
     * @param string|null $ID
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @param string $name
     * @param string|null $description
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailaddr
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return object|null
     */
    public function GetTradeParty(?string $ID, ?string $globalID, ?string $globalIDType, string $name, ?string $description, ?string $lineone, ?string $linetwo, ?string $linethree, ?string $postcode, ?string $city, ?string $country, ?string $subdivision, ?string $legalorgid, ?string $legalorgtype, ?string $legalorgname, ?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailaddr, ?string $taxregtype, ?string $taxregid): ?object
    {
        $tradeParty = $this->CreateClassInstance('ram\TradePartyType');
        $address = $this->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $legalorg = $this->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $contact = $this->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr);
        $taxreg = $this->GetTaxRegistrationType($taxregtype, $taxregid);

        $this->TryCall($tradeParty, "addToID", $this->GetIdType($ID));
        $this->TryCall($tradeParty, "addToGlobalID", $this->GetIdType($globalID, $globalIDType));
        $this->TryCall($tradeParty, "setName", $this->GetTextType($name));
        $this->TryCall($tradeParty, "setDescription", $this->GetTextType($description));
        $this->TryCall($tradeParty, "setPostalTradeAddress", $address);
        $this->TryCall($tradeParty, "setSpecifiedLegalOrganization", $legalorg);
        $this->TryCall($tradeParty, "setDefinedTradeContact", $contact);
        $this->TryCall($tradeParty, "addToSpecifiedTaxRegistration", $taxreg);

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
        $contact = $this->CreateClassInstance('ram\TradeContactType', $contactpersonname);
        $contactphone = $this->GetUniversalCommunicationType($contactphoneno, null);
        $contactfax = $this->GetUniversalCommunicationType($contactfaxno, null);
        $contactemail = $this->GetUniversalCommunicationType(null, $contactemailaddr);

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
    public function GetUniversalCommunicationType(?string $number, ?string $uriid, string $urischeme = "SMTP"): ?object
    {
        $communication = $this->CreateClassInstanceIf('ram\UniversalCommunicationType', null, $number || $uriid);

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
        $taxreg = $this->CreateClassInstanceIf('ram\TaxRegistrationType', null, $taxregtype && $taxregid);

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
        $deliveryterms = $this->CreateClassInstanceIf('ram\TradeDeliveryTermsType', null, $code);

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
        $procuringproject = $this->CreateClassInstanceIf('ram\ProcuringProjectType', null, $id && $name);

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
        $supplychainevent = $this->CreateClassInstanceIf('ram\SupplyChainEventType', null, $date);

        $this->TryCall($supplychainevent, "setOccurrenceDateTime", $this->GetDateTimeType($date));

        return $supplychainevent;
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
     * Creates an instance of a class needed by $invoiceObject if $condition is true
     *
     * @param string $classname
     * @param boolean $condition
     * @return object|null
     */
    public function CreateClassInstanceIf($classname, $constructorvalue = null, $condition = true): ?object
    {
        if (!$condition) {
            return null;
        }
        return $this->CreateClassInstance($classname, $constructorvalue);
    }

    /**
     * Tries to call a method
     *
     * @param object $instance
     * @param string $method
     * @param mixed $value
     * @return ZugferdObjectHelper
     */
    public function TryCall($instance, $method, $value)
    {
        if (!$instance) {
            return $this;
        }
        if (!$method) {
            return $this;
        }
        if (!$value) {
            return $this;
        }
        if (method_exists($instance, $method)) {
            $instance->$method($value);
        }
        return $this;
    }

    public function EnsureStringArray($input): array
    {
        if (is_array($input)) {
            return $input;
        }
        return [(string) $input];
    }
}
