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
     * Seller
     *
     * @param string $name
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function SetSeller($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTradeParty", $sellerTradeParty);
        return $this;
    }

    /**
     * Buyer
     *
     * @param string $name
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @param string $buyerrefno
     * @return ZugferdDocumentBuilder
     */
    public function SetBuyer($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null, $buyerrefno): ZugferdDocumentBuilder
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
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function SetSellerTaxRepresentativeTradeParty($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null): ZugferdDocumentBuilder
    {
        $sellerTaxRepresentativeTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);
        return $this;
    }

    /**
     * Detailed information on the deviating Consumer
     *
     * @param string $name
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function SetProductEndUserTradeParty($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setProductEndUserTradeParty", $productEndUserTradeParty);
        return $this;
    }

    /**
     * Set the delivery terms
     *
     * @param string $code
     * @return ZugferdDocumentBuilder
     */
    public function SetDeliveryTerms($code): ZugferdDocumentBuilder
    {
        $deliveryterms = $this->objectHelper->GetTradeDeliveryTermsType($code);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setApplicableTradeDeliveryTerms", $deliveryterms);
        return $this;
    }

    /**
     * Details of the associated confirmation of the order
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
    public function SetSellerOrderReferencedDocument($issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $sellerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerOrderReferencedDocument", $sellerorderrefdoc);
        return $this;
    }

    /**
     * Details of the related order
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
    public function SetBuyerOrderReferencedDocument($issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
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
    public function SetContractReferencedDocument($issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
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
    public function AddAdditionalReferencedDocument($issuerassignedid, $uriid = null, $lineid = null, $typecode = null, $name = null, $reftypecode = null, ?\DateTime $issueddate = null, $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename = null);
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
    public function SetProcuringProject($id, $name): ZugferdDocumentBuilder
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
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function SetShipTo($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param string $name
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function SetUltimateShipTo($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param string $name
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $description
     * @param string $lineone
     * @param string $linetwo
     * @param string $linethree
     * @param string $postcode
     * @param string $city
     * @param string $country
     * @param string $subdivision
     * @param string $legalorgid
     * @param string $legalorgtype
     * @param string $legalorgname
     * @param string $contactpersonname
     * @param string $contactdepartmentname
     * @param string $contactphoneno
     * @param string $contactfaxno
     * @param string $contactemailaddr
     * @param string $taxregtype
     * @param string $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function SetShipFrom($name, $id = null, $globalID = null, $globalIDType = null, $description = null, $lineone = null, $linetwo = null, $linethree = null, $postcode = null, $city = null, $country = null, $subdivision = null, $legalorgid = null, $legalorgtype = null, $legalorgname = null, $contactpersonname = null, $contactdepartmentname = null, $contactphoneno = null, $contactfaxno = null, $contactemailaddr = null, $taxregtype = null, $taxregid = null): ZugferdDocumentBuilder
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
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $typecode
     * @param string|array|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return ZugferdDocumentBuilder
     */
    public function SetDespatchAdviceReferencedDocument($issuerassignedid, $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $despatchddvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
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
    public function SetReceivingAdviceReferencedDocument($issuerassignedid, $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $receivingadvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated delivery note
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
    public function SetDeliveryNoteReferencedDocument($issuerassignedid, $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $deliverynoterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }
}
