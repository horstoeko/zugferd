<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\ZUgferdProfiles;

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

        return $result;
    }

    /**
     * TradeParty creator
     *
     * @return object
     */
    public function GetTradeParty($ID, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactemailaddr): object
    {
        $tradeParty = $this->CreateClassInstance('ram\TradePartyType');
        $address = $this->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $legalorg = $this->GetLegalOrganization($legalorgid, $legalorgname);
        $contact = $this->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactemailaddr);

        $this->TryCall($tradeParty, "addToID", $this->GetIdType($ID));
        $this->TryCall($tradeParty, "addToGlobalID", $this->GetIdType($globalID, $globalIDType));
        $this->TryCall($tradeParty, "setName", $this->GetTextType($name));
        $this->TryCall($tradeParty, "setDescription", $this->GetTextType($description));
        $this->TryCall($tradeParty, "setPostalTradeAddress", $address);
        $this->TryCall($tradeParty, "setSpecifiedLegalOrganization", $legalorg);
        $this->TryCall($tradeParty, "setDefinedTradeContact", $contact);

        return $tradeParty;
    }

    public function GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision)
    {
        $address = $this->CreateClassInstance('ram\TradeAddressType');

        $this->TryCall($address, "setLineOne", $this->GetTextType($lineone));
        $this->TryCall($address, "setLineTwo", $this->GetTextType($linetwo));
        $this->TryCall($address, "setLineThree", $this->GetTextType($linethree));
        $this->TryCall($address, "setPostcodeCode", $this->GetCodeType($postcode));
        $this->TryCall($address, "setCityName", $this->GetTextType($city));
        $this->TryCall($address, "setCountryID", $this->GetCodeType($country));
        $this->TryCall($address, "setCountrySubDivisionName", $this->GetTextType($subdivision));

        return $address;
    }

    public function GetLegalOrganization($legalorgid, $legalorgname)
    {
        $legalorg = $this->CreateClassInstance('ram\LegalOrganizationType', $legalorgname);

        $this->TryCall($legalorg, "setID", $this->GetIdType($legalorgid));
        $this->TryCall($legalorg, "setTradingBusinessName", $this->GetTextType($legalorgname));

        return $legalorg;
    }

    public function GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactemailaddr)
    {
        $contact = $this->CreateClassInstance('ram\TradeContactType', $contactpersonname);
        $contactphone = $this->GetUniversalCommunicationType($contactphoneno);
        $contactemail = $this->GetUniversalCommunicationType($contactemailaddr);

        $this->TryCall($contact, "setPersonName", $this->GetTextType($contactpersonname));
        $this->TryCall($contact, "setDepartmentName", $this->GetTextType($contactdepartmentname));
        $this->TryCall($contact, "setTelephoneUniversalCommunication", $contactphone);
        $this->TryCall($contact, "setEmailURIUniversalCommunication", $contactemail);

        return $contact;
    }

    public function GetUniversalCommunicationType($value)
    {
        $communication = $this->CreateClassInstanceIf('ram\UniversalCommunicationType', $value);

        $this->TryCall($communication, "setCompleteNumber", $this->GetTextType($value));

        return $communication;
    }

    /**
     * Creates an instance of a class needed by $invoiceObject
     *
     * @param string $className
     * @return object|null
     */
    public function CreateClassInstance($classname): object
    {
        $className = 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\\' . $classname;

        if (!class_exists($className)) {
            return null;
        }

        return new $className;
    }

    /**
     * Creates an instance of a class needed by $invoiceObject if $condition is true
     *
     * @param string $classname
     * @param boolean $condition
     * @return object|null
     */
    public function CreateClassInstanceIf($classname, $condition = true)
    {
        if (!$condition) {
            return null;
        }
        return $this->CreateClassInstance($classname);
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

    /**
     * Creates an instance of IDType
     *
     * @param string $value
     * @param string $schemeId
     * @return object
     */
    public function GetIdType($value, $schemeId = ""): ?object
    {
        if (!$value) {
            return null;
        }
        $className = 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\\udt\IDType';
        $idType = new $className($value);
        if ($schemeId) {
            $idType->setSchemeID($schemeId);
        }
        return $idType;
    }

    /**
     * Creates an instance of TextType
     *
     * @param string $value
     * @param string $schemeId
     * @return object
     */
    public function GetTextType($value): ?object
    {
        if (!$value) {
            return null;
        }
        $className = 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\\udt\TextType';
        $textType = new $className($value);
        return $textType;
    }

    /**
     * Creates an instance of CodeType
     *
     * @param string $value
     * @param string $schemeId
     * @return object
     */
    public function GetCodeType($value): ?object
    {
        if (!$value) {
            return null;
        }
        $className = 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\\udt\CodeType';
        $textType = new $className($value);
        return $textType;
    }
}
