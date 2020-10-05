<?php

namespace horstoeko\zugferd;

/**
 * Class representing the document builder for outgoing documents
 */
class ZugferdDocumentBuilder extends ZugferdDocument
{
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
     * SupplyChainTradeTransactionType
     *
     * @var [type]
     */
    protected $headerSupplyChainTradeTransaction = null;

    /**
     * Last added payment terms
     *
     * @var object
     */
    protected $currentPaymentTerms = null;

    /**
     * Last added position (line) to the docuemnt
     *
     * @var object
     */
    protected $currentPosition = null;

    /**
     * Constructor
     * 
     * @codeCoverageIgnore
     */
    public function __construct(int $profile)
    {
        parent::__construct($profile);

        $this->initNewDocument();
    }

    /**
     * Creates a new ZugferdDocumentBuilder with profile $profile
     *
     * @codeCoverageIgnore
     *
     * @param integer $profile
     * @return ZugferdDocumentBuilder
     */
    public static function createNew(int $profile): ZugferdDocumentBuilder
    {
        return (new static($profile));
    }

    /**
     * Initialized a new document with profile settings
     *
     * @return ZugferdDocumentBuilder
     */
    public function initNewDocument(): ZugferdDocumentBuilder
    {
        $this->invoiceObject = $this->objectHelper->GetCrossIndustryInvoice();
        $this->headerTradeAgreement = $this->invoiceObject->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement();
        $this->headerTradeDelivery = $this->invoiceObject->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery();
        $this->headerTradeSettlement = $this->invoiceObject->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement();
        $this->headerSupplyChainTradeTransaction = $this->invoiceObject->getSupplyChainTradeTransaction();
        return $this;
    }

    /**
     * This method can be overridden in derived class
     * It is called before a XML is written
     *
     * @return void
     */
    protected function OnBeforeGetContent()
    {
        // Do nothing
    }

    /**
     * Write the content of a CrossIndustryInvoice object to a string
     *
     * @return string
     */
    public function getContent(): string
    {
        $this->OnBeforeGetContent();
        return $this->serializer->serialize($this->invoiceObject, 'xml');
    }

    /**
     * Write the content of a CrossIndustryInvoice object to a file
     *
     * @param string $xmlfilename
     * @return ZugferdDocument
     */
    public function writeFile(string $xmlfilename): ZugferdDocument
    {
        file_put_contents($xmlfilename, $this->getContent());
        return $this;
    }

    /**
     * Set main information about this document
     *
     * @param string $documentno The invoice no.
     * @param string $documenttypecode Code for the invoice type
     * @param \DateTime $documentdate Date of invoice
     * @param string $invoiceCurrency Code for the invoice currency
     * @param string|null $documentname Document Type
     * @param string|null $documentlanguage Language indicator
     * @param \DateTime|null $effectiveSpecifiedPeriod Contractual due date of the invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInformation(string $documentno, string $documenttypecode, \DateTime $documentdate, string $invoiceCurrency, ?string $documentname = null, ?string $documentlanguage = null, ?\DateTime $effectiveSpecifiedPeriod = null): ZugferdDocumentBuilder
    {
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setID", $this->objectHelper->GetIdType($documentno));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setName", $this->objectHelper->GetTextType($documentname));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setTypeCode", $this->objectHelper->GetCodeType($documenttypecode));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setIssueDateTime", $this->objectHelper->GetDateTimeType($documentdate));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "addToLanguageID", $this->objectHelper->GetIdType($documentlanguage));
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setEffectiveSpecifiedPeriod", $this->objectHelper->GetSpecifiedPeriodType(null, null, $effectiveSpecifiedPeriod, null));

        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoiceCurrencyCode", $this->objectHelper->GetIdType($invoiceCurrency));

        return $this;
    }

    /**
     * Set general payment information
     *
     * @param string|null $creditorReferenceID Identifier of the creditor
     * @param string|null $paymentReference Intended use for payment
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentGeneralPaymentInformation(?string $creditorReferenceID = null, ?string $paymentReference = null): ZugferdDocumentBuilder
    {
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setCreditorReferenceID", $this->objectHelper->GetIdType($creditorReferenceID));
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setPaymentReference", $this->objectHelper->GetIdType($paymentReference));
        return $this;
    }

    /**
     * Mark document as a copy from the original one
     *
     * @return ZugferdDocumentBuilder
     */
    public function setIsDocumentCopy(): ZugferdDocumentBuilder
    {
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "setCopyIndicator", $this->objectHelper->GetIndicatorType(true));
        return $this;
    }

    /**
     * Mark document as a test document
     *
     * @return ZugferdDocumentBuilder
     */
    public function setIsTestDocument(): ZugferdDocumentBuilder
    {
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocumentContext(), "setTestIndicator", $this->objectHelper->GetIndicatorType(true));
        return $this;
    }

    /**
     * Document money summation
     *
     * @param float $grandTotalAmount Total invoice amount including sales tax
     * @param float $duePayableAmount Payment amount due
     * @param float|null $lineTotalAmount Sum of the net amounts of all invoice items
     * @param float|null $chargeTotalAmount Sum of the surcharges at document level
     * @param float|null $allowanceTotalAmount Sum of the discounts at document level
     * @param float|null $taxBasisTotalAmount Total invoice amount excluding sales tax
     * @param float|null $taxTotalAmount Total amount of the invoice sales tax, total tax amount in the booking currency
     * @param float|null $roundingAmount Rounding amount
     * @param float|null $totalPrepaidAmount Prepayment amount
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSummation(float $grandTotalAmount, float $duePayableAmount, ?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxBasisTotalAmount = null, ?float $taxTotalAmount = null, ?float $roundingAmount = null, ?float $totalPrepaidAmount = null): ZugferdDocumentBuilder
    {
        $summation = $this->objectHelper->GetTradeSettlementHeaderMonetarySummationType($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setSpecifiedTradeSettlementHeaderMonetarySummation", $summation);
        $taxTotalAmount = $this->objectHelper->TryCallAndReturn($summation, "getTaxTotalAmount");
        $invoiceCurrencyCode = $this->objectHelper->TryCallByPathAndReturn($this->headerTradeSettlement, "getInvoiceCurrencyCode.value");
        $this->objectHelper->TryCall($this->objectHelper->EnsureArray($taxTotalAmount)[0], 'setCurrencyID', $invoiceCurrencyCode);
        return $this;
    }

    /**
     * Initilize the main document summation
     *
     * @return ZugferdDocumentBuilder
     */
    public function initDocumentSummation(): ZugferdDocumentBuilder
    {
        $this->setDocumentSummation(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
        return $this;
    }

    /**
     * Add a note to the docuzment
     *
     * @param string $content Free text on the invoice
     * @param string|null $contentCode Free text at document level
     * @param string|null $subjectCode Code to qualify the free text for the invoice
     * 
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentNote(string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
    {
        $note = $this->objectHelper->GetNoteType($content, $contentCode, $subjectCode);
        $this->objectHelper->TryCall($this->invoiceObject->getExchangedDocument(), "addToIncludedNote", $note);
        return $this;
    }

    /**
     * Detailed information about the seller (=service provider)
     *
     * @param string $name The full formal name under which the seller is registered in the national register of
     * legal entities or taxable persons, or otherwise acts as persons
     * @param string|null $id In many systems, the clerk identification is key information. Multiple seller IDs can be 
     * assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, 
     * it should be known to the buyer and seller, e.g. a previously exchanged ID of the seller assigned by the buyer.
     * @param string|null $description Further legal information that is relevant for the seller
     * 
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSeller(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTradeParty", $sellerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the seller
     *
     * @param string|null $globalID The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a 
     * global registration organization.
     * @param string|null $globalIDType If the identifier is used for the identification scheme, it must be selected from the entries in 
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * 
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $this->objectHelper->TryCall($sellerTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add detailed information on the seller's tax information
     * 
     * The local identification (defined by the seller's address) of the seller for tax purposes or a reference that enables the seller 
     * to indicate his reporting status for tax purposes The sales tax identification number of the seller 
     * Note: This information may affect how the buyer the invoice settled (such as in relation to social security contributions). So 
     * e.g. In some countries, if the seller is not reported for tax, the buyer will withhold the tax amount and pay it on behalf of the 
     * seller. Sales tax number with a prefixed country code. A supplier registered as subject to VAT must provide his sales tax 
     * identification number, unless he uses a tax agent.
     *
     * @param string|null $taxregtype Type of tax number of the seller
     * @param string|null $taxregid Tax number of the seller or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * 
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($sellerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets detailed information on the business address of the seller
     *
     * @param string|null $lineone Address Line 1, Enter the street or post office box. For major customer addresses, this field must be filled with "-".
     * @param string|null $linetwo Address Line 2
     * @param string|null $linethree Address Line 3
     * @param string|null $postcode Post Code
     * @param string|null $city City
     * @param string|null $country Country (ISO 3166-1) Only the alpha-2 representation may be used
     * @param string|null $subdivision State
     * 
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($sellerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set Organization details
     *
     * @param string|null $legalorgid An identifier issued by an official registrar that identifies the seller as a legal entity 
     * or legal entity. If no identification scheme is given, it should be known to the buyer and seller
     * @param string|null $legalorgtype The identifier for the identification scheme The identifier of the legal registration of 
     * the seller Note: If the identification scheme is used, it must be selected from the entries in the 
     * list published by the ISO / IEC 6523 Maintenance Agency.
     * @param string|null $legalorgname A name by which the seller is known, if different from the seller's name (also known as
     * the company name). Note: This may be used if different from the seller's name.
     * 
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($sellerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set detailed information on the seller's contact person
     *
     * @param string|null $contactpersonname A point of contact for a legal entity or legal person,
     * such as Personal name, designation of the contact person
     * @param string|null $contactdepartmentname A point of contact for a legal entity or legal person
     * such as Name of the department or office
     * @param string|null $contactphoneno Seller's phone number 
     * @param string|null $contactfaxno Detailed information on the seller's fax number
     * @param string|null $contactemailadd Detailed information about the email address of the seller
     * 
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($sellerTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information about the buyer (service recipient)
     *
     * @param string $name The full name of the buyer
     * @param string|null $id An identifier of the buyer, note: If no scheme is given, it should be known to the 
     * buyer and seller, e.g. a previously exchanged, seller-assigned identifier of the buyer.
     * @param string|null $description Further legal information that is relevant for the seller
     * 
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentBuyer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerTradeParty", $buyerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the buyer
     *
     * @param string|null $globalID The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a 
     * global registration organization.
     * @param string|null $globalIDType If the identifier is used for the identification scheme, it must be selected from the entries in 
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * 
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentBuyerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $this->objectHelper->TryCall($buyerTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add detailed information on the buyers's tax information
     * 
     * The local identification (defined by the buyers's address) of the buyers for tax purposes or a reference that enables the buyers 
     * to indicate his reporting status for tax purposes The sales tax identification number of the buyers 
     * Note: This information may affect how the buyer the invoice settled (such as in relation to social security contributions). So 
     * e.g. In some countries, if the buyers is not reported for tax, the buyer will withhold the tax amount and pay it on behalf of the 
     * buyers. Sales tax number with a prefixed country code. A supplier registered as subject to VAT must provide his sales tax 
     * identification number, unless he uses a tax agent.
     *
     * @param string|null $taxregtype Type of tax number of the buyers
     * @param string|null $taxregid Tax number of the buyers or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * 
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentBuyerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($buyerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets detailed information on the business address of the buyer
     *
     * @param string|null $lineone Address Line 1, Enter the street or post office box. For major customer addresses, this field must be filled with "-".
     * @param string|null $linetwo Address Line 2
     * @param string|null $linethree Address Line 3
     * @param string|null $postcode Post Code
     * @param string|null $city City
     * @param string|null $country Country (ISO 3166-1) Only the alpha-2 representation may be used
     * @param string|null $subdivision State
     * 
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentBuyerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($buyerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the buyer party
     *
     * @param string|null $legalorgid An identifier issued by an official registrar that identifies the buyer as a legal entity 
     * or legal entity. If no identification scheme is given, it should be known to the buyer and buyer
     * @param string|null $legalorgtype The identifier for the identification scheme The identifier of the legal registration of 
     * the buyer Note: If the identification scheme is used, it must be selected from the entries in the 
     * list published by the ISO / IEC 6523 Maintenance Agency.
     * @param string|null $legalorgname A name by which the buyer is known, if different from the buyer's name (also known as
     * the company name). Note: This may be used if different from the buyer's name.
     * 
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentBuyerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($buyerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the buyer party
     *
     * @param string|null $contactpersonname A point of contact for a legal entity or legal person,
     * such as Personal name, designation of the contact person
     * @param string|null $contactdepartmentname A point of contact for a legal entity or legal person
     * such as Name of the department or office
     * @param string|null $contactphoneno buyer's phone number 
     * @param string|null $contactfaxno Detailed information on the buyer's fax number
     * @param string|null $contactemailadd Detailed information about the email address of the buyer
     * 
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentBuyerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($buyerTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Sets the sellers tax representative trade party
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentSellerTaxRepresentativeTradeParty(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTaxRepresentativeTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Tax representative party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentSellerTaxRepresentativeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $this->objectHelper->TryCall($taxrepresentativeTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to tax representative party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentSellerTaxRepresentativeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($taxrepresentativeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the tax representative party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentSellerTaxRepresentativeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($taxrepresentativeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the tax representative party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentSellerTaxRepresentativeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($taxrepresentativeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the tax representative party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentSellerTaxRepresentativeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($taxrepresentativeTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the deviating Consumer
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentProductEndUser(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setProductEndUserTradeParty", $productEndUserTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Product Enduser Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentProductEndUserGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $this->objectHelper->TryCall($productEndUserTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Product Enduser Trade Party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentProductEndUserTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($productEndUserTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Product Enduser party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentProductEndUserAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($productEndUserTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Product Enduser party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentProductEndUserLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($productEndUserTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Product Enduser party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentProductEndUserContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($productEndUserTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Ship-To
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $this->objectHelper->TryCall($shipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($shipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($shipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($shipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Ship-To party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($shipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentUltimateShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentUltimateShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-To party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentUltimateShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-To party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentUltimateShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-To party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Ship-From Tradeparty
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipFrom(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipFromTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-from Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentShipFromGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $this->objectHelper->TryCall($shipFromTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-from Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentShipFromTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($shipFromTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipFromAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($shipFromTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipFromLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($shipFromTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentShipFromContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($shipFromTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Invoicer (Rechnungssteller)
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoicer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoicerTradeParty", $invoicerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Invoicer Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentInvoicerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $this->objectHelper->TryCall($invoicerTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-from Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentInvoicerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($invoicerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoicerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($invoicerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoicerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($invoicerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoicerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($invoicerTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Invoicee,
     * Detailed information on the different invoice recipient,
     * Detailinformationen zum abweichenden Rechnungsempfänger
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoicee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoiceeTradeParty", $invoiceeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Invoicee Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentInvoiceeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $this->objectHelper->TryCall($invoiceeTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-from Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentInvoiceeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($invoiceeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoiceeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($invoiceeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoiceeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($invoiceeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoiceeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($invoiceeTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Payee,
     * Detailed information on the different invoice payee,
     * Zahlungsempfänger
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPayee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setPayeeTradeParty", $payeeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Payee Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPayeeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $this->objectHelper->TryCall($payeeTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-from Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPayeeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($payeeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPayeeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($payeeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPayeeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($payeeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPayeeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($payeeTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set the delivery terms
     *
     * @param string|null $code
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentDeliveryTerms(?string $code): ZugferdDocumentBuilder
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
    public function SetDocumentSellerOrderReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
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
    public function SetDocumentBuyerOrderReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
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
    public function SetDocumentContractReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setContractReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Documents justifying the invoice
     * Rechnungsbegründende Unterlagen
     *
     * @param string $issuerassignedid
     * @param string $typecode
     * @param string|null $uriid
     * @param string|array|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentAdditionalReferencedDocument(string $issuerassignedid, string $typecode, ?string $uriid = null, $name = null, ?string $reftypecode = null, ?\DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, $uriid, null, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "addToAdditionalReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Details of the related order
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentInvoiceReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $invoicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoiceReferencedDocument", $invoicerefdoc);
        return $this;
    }

    /**
     * Set Details of a project reference
     *
     * @param string $id
     * @param string $name
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentProcuringProject(string $id, string $name): ZugferdDocumentBuilder
    {
        $procuringproject = $this->objectHelper->GetProcuringProjectType($id, $name);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSpecifiedProcuringProject", $procuringproject);
        return $this;
    }

    /**
     * Details of the ultimate customer order
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
    public function AddDocumentUltimateCustomerOrderReferencedDocument($issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "addToUltimateCustomerOrderReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Detailed information on the actual delivery
     *
     * @param \DateTime|null $date
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentSupplyChainEvent(?\DateTime $date): ZugferdDocumentBuilder
    {
        $supplyChainevent = $this->objectHelper->GetSupplyChainEventType($date);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentDespatchAdviceReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $despatchddvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentReceivingAdviceReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $receivingadvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated delivery note
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentDeliveryNoteReferencedDocument(string $issuerassignedid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $deliverynoterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }

    /**
     * Add new payment means
     *
     * @param string $typecode
     * @param string|null $information
     * @param string|null $cardType
     * @param string|null $cardId
     * @param string|null $cardHolderName
     * @param string|null $buyerIban
     * @param string|null $payeeIban
     * @param string|null $payeeAccountName
     * @param string|null $payeePropId
     * @param string|null $payeeBic
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPaymentMean(string $typecode, ?string $information = null, ?string $cardType = null, ?string $cardId = null, ?string $cardHolderName = null, ?string $buyerIban = null, ?string $payeeIban = null, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->objectHelper->GetTradeSettlementPaymentMeansType($typecode, $information);
        $financialCard = $this->objectHelper->GetTradeSettlementFinancialCardType($cardType, $cardId, $cardHolderName);
        $buyerfinancialaccount = $this->objectHelper->GetDebtorFinancialAccountType($buyerIban);
        $payeefinancialaccount = $this->objectHelper->GetCreditorFinancialAccountType($payeeIban, $payeeAccountName, $payeePropId);
        $payeefinancialInstitution = $this->objectHelper->GetCreditorFinancialInstitutionType($payeeBic);

        $this->objectHelper->TryCall($paymentMeans, "setApplicableTradeSettlementFinancialCard", $financialCard);
        $this->objectHelper->TryCall($paymentMeans, "setPayerPartyDebtorFinancialAccount", $buyerfinancialaccount);
        $this->objectHelper->TryCall($paymentMeans, "setPayeePartyCreditorFinancialAccount", $payeefinancialaccount);
        $this->objectHelper->TryCall($paymentMeans, "setPayeeSpecifiedCreditorFinancialInstitution", $payeefinancialInstitution);

        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        return $this;
    }

    /**
     * Add Tax
     *
     * @param string $categoryCode
     * @param string $typeCode
     * @param float $basisAmount
     * @param float $calculatedAmount
     * @param float|null $rateApplicablePercent
     * @param string|null $exemptionReason
     * @param string|null $exemptionReasonCode
     * @param float|null $lineTotalBasisAmount
     * @param float|null $allowanceChargeBasisAmount
     * @param \DateTime|null $taxPointDate
     * @param string|null $dueDateTypeCode
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentTax(string $categoryCode, string $typeCode, float $basisAmount = 0, float $calculatedAmount = 0, ?float $rateApplicablePercent = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null, ?float $lineTotalBasisAmount = null, ?float $allowanceChargeBasisAmount = null, ?\DateTime $taxPointDate = null, ?string $dueDateTypeCode = null): ZugferdDocumentBuilder
    {
        $tax = $this->objectHelper->GetTradeTaxType($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToApplicableTradeTax", $tax);
        return $this;
    }

    /**
     * Add Tax in a simple way
     *
     * @param string $categoryCode
     * @param string $typeCode
     * @param float $basisAmount
     * @param float $calculatedAmount
     * @param float|null $rateApplicablePercent
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentTaxSimple(string $categoryCode, string $typeCode, float $basisAmount = 0, float $calculatedAmount = 0, ?float $rateApplicablePercent = null): ZugferdDocumentBuilder
    {
        return $this->AddDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent);
    }

    /**
     * Sets the billing period
     *
     * @param \DateTime|null $startdate
     * @param \DateTime|null $endDate
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentBillingPeriod(?\DateTime $startdate, ?\DateTime $endDate, ?string $description): ZugferdDocumentBuilder
    {
        $period = $this->objectHelper->GetSpecifiedPeriodType($startdate, $endDate, null, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setBillingSpecifiedPeriod", $period);
        return $this;
    }

    /**
     * Add a allowance/charge at document level
     *
     * @param float $actualAmount
     * @param boolean $isCharge
     * @param string $taxCategoryCode
     * @param string $taxTypeCode
     * @param float $rateApplicablePercent
     * @param float|null $sequence
     * @param float|null $calculationPercent
     * @param float|null $basisAmount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @param string|null $reasonCode
     * @param string|null $reason
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentAllowanceCharge(float $actualAmount, bool $isCharge, string $taxCategoryCode, string $taxTypeCode, float $rateApplicablePercent, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ZugferdDocumentBuilder
    {
        $allowanceCharge = $this->objectHelper->GetTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);
        return $this;
    }

    /**
     * Add a logistic service charge
     *
     * @param string $description
     * @param float $appliedAmount
     * @param array|null $taxTypeCodes
     * @param array|null $taxCategpryCodes
     * @param array|null $rateApplicablePercents
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentLogisticsServiceCharge(string $description, float $appliedAmount, ?array $taxTypeCodes = null, ?array $taxCategpryCodes = null, ?array $rateApplicablePercents = null): ZugferdDocumentBuilder
    {
        $logcharge = $this->objectHelper->GetLogisticsServiceChargeType($description, $appliedAmount, $taxTypeCodes, $taxCategpryCodes, $rateApplicablePercents);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToSpecifiedLogisticsServiceCharge", $logcharge);
        return $this;
    }

    /**
     * Add a payment term
     *
     * @param string|null $description
     * @param \DateTime|null $dueDate
     * @param string|null $directDebitMandateID
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPaymentTerm(?string $description = null, ?\DateTime $dueDate = null, ?string $directDebitMandateID = null): ZugferdDocumentBuilder
    {
        $paymentTerms = $this->objectHelper->GetTradePaymentTermsType($description, $dueDate, $directDebitMandateID);
        $this->objectHelper->TryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradePaymentTerms", "setSpecifiedTradePaymentTerms"], $paymentTerms);
        $this->currentPaymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * Add discount Terms to last added payment term
     *
     * @param float $calculationPercent
     * @param \DateTime|null $basisDateTime
     * @param float|null $basisPeriodMeasureValue
     * @param string|null $basisPeriodMeasureUnitCode
     * @param float|null $basisAmount
     * @param float|null $actualDiscountAmount
     * @return ZugferdDocumentBuilder
     */
    public function AddDiscountTermsToPaymentTerms(float $calculationPercent = null, ?\DateTime $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $actualDiscountAmount = null): ZugferdDocumentBuilder
    {
        $discountTerms = $this->objectHelper->GetTradePaymentDiscountTermsType($basisDateTime, $basisPeriodMeasureValue, $basisPeriodMeasureUnitCode, $basisAmount, $calculationPercent, $actualDiscountAmount);
        $this->objectHelper->TryCall($this->currentPaymentTerms, "setApplicableTradePaymentDiscountTerms", $discountTerms);
        return $this;
    }

    /**
     * Add an AccountingAccount
     * Detailinformationen zur Buchungsreferenz
     *
     * @param string $id
     * @param string|null $typeCode
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode): ZugferdDocumentBuilder
    {
        $account = $this->objectHelper->GetTradeAccountingAccountType($id, $typeCode);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToReceivableSpecifiedTradeAccountingAccount", $account);
        return $this;
    }

    /**
     * Adds a new position (line) to document
     *
     * @param string $lineid
     * @param string|null $lineStatusCode
     * @param string|null $lineStatusReasonCode
     * @return ZugferdDocumentBuilder
     */
    public function AddNewPosition(string $lineid, ?string $lineStatusCode = null, ?string $lineStatusReasonCode = null): ZugferdDocumentBuilder
    {
        $position = $this->objectHelper->GetSupplyChainTradeLineItemType($lineid, $lineStatusCode, $lineStatusReasonCode);
        $this->objectHelper->TryCall($this->headerSupplyChainTradeTransaction, "addToIncludedSupplyChainTradeLineItem", $position);
        $this->currentPosition = $position;
        return $this;
    }

    /**
     * Set note on a document position (line)
     *
     * @param string $content
     * @param string|null $contentCode
     * @param string|null $subjectCode
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionNote(string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
    {
        $linedoc = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getAssociatedDocumentLineDocument");
        $note = $this->objectHelper->GetNoteType($content, $contentCode, $subjectCode);
        $this->objectHelper->TryCallAll($linedoc, ["addToIncludedNote", "setIncludedNote"], $note);
        return $this;
    }

    /**
     * Adds product details to the last created position (line) in the document
     *
     * @param string $name
     * @param string|null $description
     * @param string|null $sellerAssignedID
     * @param string|null $buyerAssignedID
     * @param string|null $globalIDType
     * @param string|null $globalID
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionProductDetails(string $name, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null): ZugferdDocumentBuilder
    {
        $product = $this->objectHelper->GetTradeProductType($name, $description, $sellerAssignedID, $buyerAssignedID, $globalIDType, $globalID);
        $this->objectHelper->TryCall($this->currentPosition, "setSpecifiedTradeProduct", $product);
        return $this;
    }

    /**
     * Details of the related order
     *
     * @param string $issuerassignedid
     * @param string $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionBuyerOrderReferencedDocument(string $issuerassignedid, string $lineid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
        return $this;
    }

    /**
     * Details of the related contract on the position
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionContractReferencedDocument(string $issuerassignedid, string $lineid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setContractReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Details of an additional Document reference on a position
     * Detailangaben zu einer zusätzlichen Dokumentenreferenz auf Positionsebene
     *
     * @param string $issuerassignedid
     * @param string $typecode
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $name
     * @param string|null $reftypecode
     * @param \DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionAdditionalReferencedDocument(string $issuerassignedid, string $typecode, ?string $uriid = null, ?string $lineid = null, ?string $name = null, ?string $reftypecode = null, ?\DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "addToAdditionalReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Ultimate Customer Order Referenced Document
     * Dokument mit Bezug zur endgültigen Kundenbestellung
     *
     * @param string $issuerassignedid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionUltimateCustomerOrderReferencedDocument(string $issuerassignedid, string $lineid, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $ultimaterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "addToUltimateCustomerOrderReferencedDocument", $ultimaterefdoc);
        return $this;
    }

    /**
     * Detailed information on the gross price of the item
     * Detailinformationen zum Bruttopreis des Artikels
     *
     * @param float $amount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionGrossPrice(float $amount, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $grossPrice = $this->objectHelper->GetTradePriceType($amount, $basisQuantity, $basisQuantityUnitCode);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setGrossPriceProductTradePrice", $grossPrice);
        return $this;
    }

    /**
     * Detailed information on surcharges and discounts
     * Detailinformationen zu Zu- und Abschlägen
     *
     * @param float $actualAmount
     * @param boolean|null $isCharge
     * @param float|null $calculationPercent
     * @param float|null $basisAmount
     * @param string|null $reason
     * @param string|null $taxTypeCode
     * @param string|null $taxCategoryCode
     * @param float|null $rateApplicablePercent
     * @param float|null $sequence
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @param string|null $reasonCode
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionGrossPriceAllowanceCharge(float $actualAmount, ?bool $isCharge = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?string $reason = null, ?string $taxTypeCode = null, ?string $taxCategoryCode = null, ?float $rateApplicablePercent = null, ?float $sequence = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null): ZugferdDocumentBuilder
    {
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $grossPrice = $this->objectHelper->TryCallAndReturn($positionagreement, "getGrossPriceProductTradePrice");
        $allowanceCharge = $this->objectHelper->GetTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->objectHelper->TryCallAll($grossPrice, ["addToAppliedTradeAllowanceCharge", "setAppliedTradeAllowanceCharge"], $allowanceCharge);
        return $this;
    }

    /**
     * Detailed information on the net price of the item
     * Detailinformationen zum Nettopreis des Artikels
     *
     * @param float $amount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionNetPrice(float $amount, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $netPrice = $this->objectHelper->GetTradePriceType($amount, $basisQuantity, $basisQuantityUnitCode);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setNetPriceProductTradePrice", $netPrice);
        return $this;
    }

    /**
     * Tax included for B2C on position level
     * Enthaltene Steuer für B2C auf Positionsebene
     *
     * @param float $amount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionNetPriceTax(string $categoryCode, string $typeCode, float $rateApplicablePercent, ?float $calculatedAmount = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $netPrice = $this->objectHelper->TryCallAndReturn($positionagreement, "getNetPriceProductTradePrice");
        $tax = $this->objectHelper->GetTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);
        $this->objectHelper->TryCall($netPrice, "setIncludedTradeTax", $tax);
        return $this;
    }

    /**
     * Sets the position Quantity
     *
     * @param float $billedQuantity
     * @param string $billedQuantityUnitCode
     * @param float|null $chargeFreeQuantity
     * @param string|null $chargeFreeQuantityUnitCpde
     * @param float|null $packageQuantity
     * @param string|null $packageQuantityUnitCode
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionQuantity(float $billedQuantity, string $billedQuantityUnitCode, ?float $chargeFreeQuantity = null, ?string $chargeFreeQuantityUnitCpde = null, ?float $packageQuantity = null, ?string $packageQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $this->objectHelper->TryCall($positiondelivery, "setBilledQuantity", $this->objectHelper->GetQuantityType($billedQuantity, $billedQuantityUnitCode));
        $this->objectHelper->TryCall($positiondelivery, "setChargeFreeQuantity", $this->objectHelper->GetQuantityType($chargeFreeQuantity, $chargeFreeQuantityUnitCpde));
        $this->objectHelper->TryCall($positiondelivery, "setPackageQuantity", $this->objectHelper->GetQuantityType($packageQuantity, $packageQuantityUnitCode));
        return $this;
    }

    /**
     * Detailed information on the different ship-to party at item level
     * Detailinformationen zum abweichenden Warenempfänger auf Positionsebene
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($positiondelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $this->objectHelper->TryCall($shipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($shipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($shipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($shipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Ship-To party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($shipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     * Detailinformationen zum abweichenden Endempfänger
     *
     * @param string $name
     * @param string|null $id
     * @param string|null $description
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionUltimateShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($positiondelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param string|null $globalID
     * @param string|null $globalIDType
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $this->objectHelper->TryCall($ultimateShipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param string|null $taxregtype
     * @param string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionUltimateShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($ultimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param string|null $subdivision
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionUltimateShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($ultimateShipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionUltimateShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($ultimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Ship-To party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($ultimateShipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the actual delivery on item level
     *
     * @param \DateTime|null $date
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionSupplyChainEvent(?\DateTime $date): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $supplyChainevent = $this->objectHelper->GetSupplyChainEventType($date);
        $this->objectHelper->TryCall($positiondelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on item level
     *
     * @param string $issuerassignedid
     * @param string|null $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionDespatchAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $despatchddvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($positiondelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on item level
     *
     * @param string $issuerassignedid
     * @param string|null $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionReceivingAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $receivingadvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($positiondelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated delivery note on item level
     *
     * @param string $issuerassignedid
     * @param string|null $lineid
     * @param \DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionDeliveryNoteReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?\DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $deliverynoterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($positiondelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }

    /**
     * A group of business terms that contains information about the sales tax that applies to
     * the goods and services invoiced on the relevant invoice line
     *
     * @param string $categoryCode Information only for taxes that are not VAT.
     * @param string $typeCode In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for the tax type must then be taken from the code list UNTDID 5153.
     * @param float $rateApplicablePercent The code of the VAT category applicable to the item invoiced
     * @param float|null $calculatedAmount
     * @param string|null $exemptionReason
     * @param string|null $exemptionReasonCode
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionTax(string $categoryCode, string $typeCode, float $rateApplicablePercent, ?float $calculatedAmount = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $tax = $this->objectHelper->GetTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);
        $this->objectHelper->TryCallAll($positionsettlement, ["addToApplicableTradeTax", "setApplicableTradeTax"], $tax);
        return $this;
    }

    /**
     * Sets the billing period on item level
     *
     * @param \DateTime|null $startdate
     * @param \DateTime|null $endDate
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionBillingPeriod(?\DateTime $startdate, ?\DateTime $endDate): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $period = $this->objectHelper->GetSpecifiedPeriodType($startdate, $endDate, null, null);
        $this->objectHelper->TryCall($positionsettlement, "setBillingSpecifiedPeriod", $period);
        return $this;
    }

    /**
     * Add a allowance/charge at item level
     *
     * @param float $actualAmount
     * @param boolean $isCharge
     * @param float|null $calculationPercent
     * @param float|null $basisAmount
     * @param string|null $reasonCode
     * @param string|null $reason
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionAllowanceCharge(float $actualAmount, bool $isCharge, ?float $calculationPercent = null, ?float $basisAmount = null, ?string $reasonCode = null, ?string $reason = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $allowanceCharge = $this->objectHelper->GetTradeAllowanceChargeType($actualAmount, $isCharge, null, null, null, null, $calculationPercent, $basisAmount, null, null, $reasonCode, $reason);
        $this->objectHelper->TryCall($positionsettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);
        return $this;
    }

    /**
     * Set Line summation for item level
     *
     * @param float $lineTotalAmount
     * @param float|null $totalAllowanceChargeAmount
     * @return ZugferdDocumentBuilder
     */
    public function SetDocumentPositionLineSummation(float $lineTotalAmount, ?float $totalAllowanceChargeAmount = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $summation = $this->objectHelper->GetTradeSettlementLineMonetarySummationType($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->objectHelper->TryCall($positionsettlement, "setSpecifiedTradeSettlementLineMonetarySummation", $summation);
        return $this;
    }

    /**
     * Add an AccountingAccount on item level
     * Detailinformationen zur Buchungsreferenz
     *
     * @param string $id
     * @param string|null $typeCode
     * @return ZugferdDocumentBuilder
     */
    public function AddDocumentPositionReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $account = $this->objectHelper->GetTradeAccountingAccountType($id, $typeCode);
        $this->objectHelper->TryCall($positionsettlement, "addToReceivableSpecifiedTradeAccountingAccount", $account);
        return $this;
    }
}
