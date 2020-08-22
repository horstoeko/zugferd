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
        return $this;
    }

    /**
     * Seller
     *
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $name
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
    public function SetSeller($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid)
    {
        $sellerTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTradeParty", $sellerTradeParty);
        return $this;
    }

    /**
     * Buyer
     *
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $name
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
    public function SetBuyer($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid, $buyerrefno)
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
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $name
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
    public function SetSellerTaxRepresentativeTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid)
    {
        $sellerTaxRepresentativeTradeParty = $this->objectHelper->GetTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);
        return $this;
    }

    /**
     * Detailed information on the deviating Consumer
     *
     * @param string $id
     * @param string $globalID
     * @param string $globalIDType
     * @param string $name
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
    public function SetProductEndUserTradeParty($id, $globalID, $globalIDType, $name, $description, $lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision, $legalorgid, $legalorgtype, $legalorgname, $contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailaddr, $taxregtype, $taxregid)
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
    public function SetDeliveryTerms($code)
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
     * @param string|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @return void
     */
    public function SetSellerOrderReferencedDocument($issuerassignedid, $uriid = null, $lineid = null, $typecode = null, $name = null, $reftypecode = null, ?\DateTime $issueddate = null)
    {
        $sellerorderrefdoc = $this->objectHelper->ReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate);
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
     * @param string|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @return void
     */
    public function SetBuyerOrderReferencedDocument($issuerassignedid, $uriid = null, $lineid = null, $typecode = null, $name = null, $reftypecode = null, ?\DateTime $issueddate = null)
    {
        $buyerorderrefdoc = $this->objectHelper->ReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate);
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
     * @param string|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @return void
     */
    public function SetContractReferencedDocument($issuerassignedid, $uriid = null, $lineid = null, $typecode = null, $name = null, $reftypecode = null, ?\DateTime $issueddate = null)
    {
        $contractrefdoc = $this->objectHelper->ReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setContractReferencedDocument", $contractrefdoc);
        return $this;
    }
}
