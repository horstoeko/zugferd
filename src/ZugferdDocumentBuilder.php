<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\ZugferdObjectHelper;

class ZugferdDocumentBuilder extends ZugferdDocument
{
    /**
     * Object Helper
     *
     * @var ZugferdObjectHelper
     */
    protected $objectHelper = null;

    /**
     * HeaderTradeAgreement
     *
     * @var object
     */
    protected $headerTradeAgreement = null;

    /**
     * HeaderTradeDelivery
     *
     * @var object
     */
    protected $headerTradeDelivery = null;

    /**
     * HeaderTradeSettlement
     *
     * @var object
     */
    protected $headerTradeSettlement = null;

    /**
     * Constructor
     */
    public function __construct(int $profile)
    {
        parent::__construct($profile);

        $this->objectHelper = new ZugferdObjectHelper($profile);

        $this->InitNewDocument();
    }

    /**
     * Creates a new ZugferdDocumentBuilder with profile $profile
     *
     * @param integer $profile
     * @return ZugferdDocumentBuilder
     */
    public static function CreateNew(int $profile): ZugferdDocumentBuilder
    {
        return (new self($profile))->InitNewDocument();
    }

    /**
     * Initialized a new document with profile settings
     *
     * @return ZugferdDocumentBuilder
     */
    public function InitNewDocument(): ZugferdDocumentBuilder
    {
        $this->invoiceObject = $this->objectHelper->GetCrossIndustryInvoice();
        $this->headerTradeAgreement = $this->invoiceObject->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement();
        $this->headerTradeDelivery = $this->invoiceObject->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery();
        $this->headerTradeSettlement = $this->invoiceObject->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement();
        return $this;
    }

    /**
     * Set main information about this document
     *
     * @param string $documentno
     * @param string $documenttypecode
     * @param \DateTime $documentdate
     * @param string|null $documentname
     * @param boolean|null $copyindicator
     * @param string|null $documentlanguage
     * @param \DateTime|null $effectiveSpecifiedPeriod
     * @return void
     */
    public function SetDocumentInformation(string $documentno, string $documenttypecode, \DateTime $documentdate, ?string $documentname = null, ?bool $copyindicator = null, ?string $documentlanguage = null, ?\DateTime $effectiveSpecifiedPeriod)
    {
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setID", $this->objectHelper->GetIdType($documentno));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setName", $this->objectHelper->GetTextType($documentname));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setTypeCode", $this->objectHelper->GetCodeType($documenttypecode));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setIssueDateTime", $this->objectHelper->GetDateTimeType($documentdate));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setCopyIndicator", $this->objectHelper->GetIndicatorType($copyindicator));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "addToLanguageID", $this->objectHelper->GetIdType($documentlanguage));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setEffectiveSpecifiedPeriod", $this->objectHelper->GetSpecifiedPeriodType(null, null, $effectiveSpecifiedPeriod, null));
    }

    /**
     * Add a note to the docuzment
     *
     * @param string $content
     * @param string|null $contentCode
     * @param string|null $subjectCode
     * @return void
     */
    public function AddDocumentNote(string $content, ?string $contentCode = null, ?string $subjectCode = null)
    {
        $note = $this->objectHelper->GetNoteType($content, $contentCode, $subjectCode);
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "addToIncludedNote", $note);
    }

    /**
     * Seller
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @return ZugferdDocumentBuilder
     */
    public function SetSeller(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTradeParty", $sellerTradeParty);
        return $this;
    }

    /**
     * Buyer
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @param string|null $buyerrefno
     * @return ZugferdDocumentBuilder
     */
    public function SetBuyer(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null, ?string $buyerrefno): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $buyerReference = $this->objectHelper->GetCodeType($buyerrefno);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerTradeParty", $buyerTradeParty);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerReference", $buyerReference);
        return $this;
    }

    /**
     * Tax agent of the seller
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @return ZugferdDocumentBuilder
     */
    public function SetSellerTaxRepresentativeTradeParty(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $sellerTaxRepresentativeTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);
        return $this;
    }

    /**
     * Detailed information on the deviating Consumer
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @return ZugferdDocumentBuilder
     */
    public function SetProductEndUserTradeParty(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setProductEndUserTradeParty", $productEndUserTradeParty);
        return $this;
    }

    /**
     * Set the delivery terms
     *
     * @param string|null $code
     * @return ZugferdDocumentBuilder
     */
    public function SetDeliveryTerms(?string $code): ZugferdDocumentBuilder
    {
        $deliveryterms = $this->objectHelper->GetTradeDeliveryTermsType($code);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setApplicableTradeDeliveryTerms", $deliveryterms);
        return $this;
    }

    /**
     * Details of the associated confirmation of the order
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetSellerOrderReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $sellerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerOrderReferencedDocument", $sellerorderrefdoc);
        return $this;
    }

    /**
     * Details of the related order
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetBuyerOrderReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
        return $this;
    }

    /**
     * Details of the associated contract
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetContractReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setContractReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Details of the associated contract
     *
     * @param string $issuerassignedid
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $typecode
     * @param string|array|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return ZugferdDocumentBuilder
     */
    public function AddAdditionalReferencedDocument(string $issuerassignedid, ?string $uriid = null, ?string $lineid = null, ?string $typecode = null, $name = null, ?string $reftypecode = null, ?\DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "addToAdditionalReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $id
     * @param string $name
     * @return ZugferdDocumentBuilder
     */
    public function SetProcuringProject(string $id, string $name): ZugferdDocumentBuilder
    {
        $procuringproject = $this->objectHelper->GetProcuringProjectType($id, $name);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSpecifiedProcuringProject", $procuringproject);
        return $this;
    }

    /**
     * Details of the associated contract
     *
     * @param string $issuerassignedid
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $typecode
     * @param string|array|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return ZugferdDocumentBuilder
     */
    public function AddUltimateCustomerOrderReferencedDocument($issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "addToAdditionalReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Ship-To
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @return ZugferdDocumentBuilder
     */
    public function SetShipTo(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @return ZugferdDocumentBuilder
     */
    public function SetUltimateShipTo(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $globalID
     * @param string|null $globalIDType
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
     * @return ZugferdDocumentBuilder
     */
    public function SetShipFrom(string $name, ?string $id = null, ?string $globalID = null, ?string $globalIDType = null, ?string $description = null, ?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null, ?string $legalorgid = null, ?string $legalorgtype = null, ?string $legalorgname = null, ?string $contactpersonname = null, ?string $contactdepartmentname = null, ?string $contactphoneno = null, ?string $contactfaxno = null, ?string $contactemailaddr = null, ?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipFromTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Detailed information on the actual delivery
     *
     * @param \DateTime|null $date
     * @return ZugferdDocumentBuilder
     */
    public function SetSupplyChainEvent(?\DateTime $date): ZugferdDocumentBuilder
    {
        $supplyChainevent = $this->objectHelper->GetSupplyChainEventType($date);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
     *
     * @param string $issuerassignedid
     * @param string|null $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDespatchAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $despatchddvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
     *
     * @param string $issuerassignedid
     * @param string|null $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetReceivingAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $receivingadvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated delivery note
     *
     * @param string $issuerassignedid
     * @param string|null $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDeliveryNoteReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $deliverynoterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }
}
