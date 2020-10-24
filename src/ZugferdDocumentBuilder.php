<?php

namespace horstoeko\zugferd;

use DateTime;

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
     * @var object
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
     * @param int $profile
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
    protected function onBeforeGetContent()
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
        $this->onBeforeGetContent();
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
     * @param string $documentno
     * The document no issued by the seller
     * @param string $documenttypecode
     * The type of the document, See \horstoeko\codelists\ZugferdInvoiceType for details
     * @param DateTime $documentdate Date of invoice
     * The date when the document was issued by the seller
     * @param string $invoiceCurrency Code for the invoice currency
     * The code for the invoice currency
     * @param string|null $documentname Document Type
     * The document type (free text)
     * @param string|null $documentlanguage Language indicator
     * The language code in which the document was written
     * @param DateTime|null $effectiveSpecifiedPeriod
     * The contractual due date of the invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInformation(string $documentno, string $documenttypecode, DateTime $documentdate, string $invoiceCurrency, ?string $documentname = null, ?string $documentlanguage = null, ?DateTime $effectiveSpecifiedPeriod = null): ZugferdDocumentBuilder
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
     * @param string|null $creditorReferenceID
     * Identifier of the creditor
     * @param string|null $paymentReference
     * Intended use for payment
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
     * @param float|null $taxTotalAmount Total amount of the invoice sales tax, Total tax amount in the booking currency
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
     * Sets a foreign currency (code) with the tax amount. The exchange rate
     * is calculated by tax amounts
     *
     * @param string $foreignCurrencyCode Foreign currency code
     * @param float $foreignTaxAmount Tax total amount in the foreign currency
     * @return ZugferdDocumentBuilder
     */
    public function setForeignCurrency(string $foreignCurrencyCode, float $foreignTaxAmount): ZugferdDocumentBuilder
    {
        $invoiceCurrencyCode = $this->objectHelper->TryCallByPathAndReturn($this->headerTradeSettlement, "getInvoiceCurrencyCode.value");

        if (is_null($invoiceCurrencyCode)) {
            return $this;
        }

        $documentSummation = $this->objectHelper->tryCallByPathAndReturn($this->headerTradeSettlement, "getSpecifiedTradeSettlementHeaderMonetarySummation");

        if (is_null($documentSummation)) {
            return $this;
        }

        $taxTotalAmounts = $this->objectHelper->tryCallByPathAndReturn($documentSummation, "getTaxTotalAmount") ?? [];
        $taxTotalAmountInvoice = null;
        $taxTotalAmountForeign = null;

        foreach ($taxTotalAmounts as $taxTotalAmount) {
            if ($this->objectHelper->tryCallAndReturn($taxTotalAmount, "getCurrencyID") == $invoiceCurrencyCode) {
                $taxTotalAmountInvoice = $taxTotalAmount;
            }
            if ($this->objectHelper->tryCallAndReturn($taxTotalAmount, "getCurrencyID") == $foreignCurrencyCode) {
                $taxTotalAmountForeign = $taxTotalAmount;
            }
        }

        if (is_null($taxTotalAmountInvoice)) {
            return $this;
        }

        $invoiceTaxAmount = $this->objectHelper->tryCallByPathAndReturn($taxTotalAmountInvoice, "value") ?? 0;

        if ($invoiceTaxAmount == 0) {
            return $this;
        }

        if (is_null($taxTotalAmountForeign)) {
            $taxTotalAmountForeign = $this->objectHelper->getAmountType($foreignTaxAmount, $foreignCurrencyCode);
            $this->objectHelper->tryCall($documentSummation, "addToTaxTotalAmount", $taxTotalAmountForeign);
        } else {
            $this->objectHelper->tryCallByPath($taxTotalAmountForeign, "value", $foreignTaxAmount);
            $this->objectHelper->tryCallByPath($taxTotalAmountForeign, "setCurrencyID", $foreignCurrencyCode);
        }

        $exchangeRate = round($foreignTaxAmount / $invoiceTaxAmount, 5);

        $this->objectHelper->TryCall($this->headerTradeSettlement, "setTaxCurrencyCode", $this->objectHelper->GetIdType($foreignCurrencyCode));
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setTaxApplicableTradeCurrencyExchange", $this->objectHelper->getTaxApplicableTradeCurrencyExchangeType($invoiceCurrencyCode, $foreignCurrencyCode, $exchangeRate));
        return $this;
    }

    /**
     * Add a note to the docuzment
     *
     * @param string $content Free text on the invoice
     * @param string|null $contentCode Free text at document level
     * @param string|null $subjectCode Code to qualify the free text for the invoice
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
     * @param string $name The full formal name under which the seller is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param string|null $id
     * An identifier of the seller. In many systems, seller identification
     * is key information. Multiple seller IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param string|null $description
     * Further legal information that is relevant for the seller
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
     * __Notes__
     *
     * - The Seller's ID identification scheme is a unique identifier
     *   assigned to a seller by a global registration organization
     *
     * @param string|null $globalID
     * The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a
     * global registration organization.
     * @param string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param string|null $lineone
     * The main line in the sellers address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the seller's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the seller's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the seller's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The sellers state
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
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * seller as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer and seller
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the seller. If the identification scheme is used, it must be selected from
     * ISO/IEC 6523 list
     * @param string|null $legalorgname
     * A name by which the seller is known, if different from the seller's name (also known as
     * the company name). Note: This may be used if different from the seller's name.
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
     * @param string|null $contactpersonname
     * Contact point for a legal entity,
     * such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the seller's phone number
     * @param string|null $contactfaxno
     * Detailed information on the seller's fax number
     * @param string|null $contactemailadd
     * Detailed information on the seller's email address
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
     * @param string $name
     * The full name of the buyer
     * @param string|null $id
     * An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be
     * assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given,
     * it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param string|null $description
     * Further legal information about the buyer
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerTradeParty", $buyerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the buyer
     *
     * @param string|null $globalID
     * The buyers's identifier identification scheme is an identifier uniquely assigned to a buyer by a
     * global registration organization.
     * @param string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
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
     * @param string|null $taxregtype
     * Type of tax number of the buyers
     * @param string|null $taxregid
     * Tax number of the buyers or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($buyerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets detailed information on the business address of the buyer
     *
     * @param string|null $lineone
     * The main line in the buyers address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the buyers address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the buyers address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the buyers address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The buyers state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($buyerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the buyer party
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * buyer as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer and buyer
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the buyer. If the identification scheme is used, it must be selected from
     * ISO/IEC 6523 list
     * @param string|null $legalorgname
     * A name by which the buyer is known, if different from the buyers name
     * (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($buyerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the buyer party
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the buyer's phone number
     * @param string|null $contactfaxno
     * Detailed information on the buyer's fax number
     * @param string|null $contactemailadd
     * Detailed information on the buyer's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
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
     * The full name of the seller's tax agent
     * @param string|null $id
     * An identifier of the sellers tax agent.
     * @param string|null $description
     * Further legal information that is relevant for the sellers tax agent
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeTradeParty(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTaxRepresentativeTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Tax representative party
     *
     * @param string|null $globalID
     * The seller's tax agent identifier identification scheme is an identifier uniquely assigned to a seller by a
     * global registration organization.
     * @param string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
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
    public function addDocumentSellerTaxRepresentativeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
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
     * The main line in the sellers tax agent address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the sellers tax agent address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the sellers tax agent address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the sellers tax agent address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The sellers tax agent state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
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
     * An identifier issued by an official registrar that identifies the seller tax agent as
     * a legal entity or legal person.
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the sellers tax
     * agent. If the identification scheme is used, it must be selected from  ISO/IEC 6523 list
     * @param string|null $legalorgname
     * A name by which the sellers tax agent is known, if different from the  sellers tax agent
     * name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
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
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the seller's phone number
     * @param string|null $contactfaxno
     * Detailed information on the seller's fax number
     * @param string|null $contactemailadd
     * Detailed information on the seller's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($taxrepresentativeTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the product end user (general information)
     *
     * @param string $name
     * The full formal name under which the product end user is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param string|null $id
     * An identifier of the product end user. In many systems, product end user identification
     * is key information. Multiple product end user IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to all trade
     * parties, e.g. a previously exchanged
     * @param string|null $description
     * Further legal information that is relevant for the product end user
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUser(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setProductEndUserTradeParty", $productEndUserTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Product Enduser Trade Party
     *
     * @param string|null $globalID
     * The identifier is uniquely assigned to a party by a global registration organization.
     * @param string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $this->objectHelper->TryCall($productEndUserTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Product Enduser Trade Party
     *
     * The local identification (defined by the party's address) of the party for tax purposes or a reference that enables the party
     * to indicate his reporting status for tax purposes The sales tax identification number of the party
     * Note: This information may affect how the buyer the invoice settled (such as in relation to social security contributions). So
     * e.g. In some countries, if the party is not reported for tax, the buyer will withhold the tax amount and pay it on behalf of the
     * party. Sales tax number with a prefixed country code. A supplier registered as subject to VAT must provide his sales tax
     * identification number, unless he uses a tax agent.
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
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
     * The main line in the product end users address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the product end users address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The product end users state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
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
     * An identifier issued by an official registrar that identifies the
     * product end user as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to all trade parties
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the product end user. If the identification scheme is used, it must be selected from
     * ISO/IEC 6523 list
     * @param string|null $legalorgname
     * A name by which the product end user is known, if different from the product
     * end users name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
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
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the product end user's phone number
     * @param string|null $contactfaxno
     * Detailed information on the product end user's fax number
     * @param string|null $contactemailadd
     * Detailed information on the product end user's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
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
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param string|null $id
     * An identifier for the place where the goods are delivered or where the services are provided.
     * Multiple IDs can be assigned or specified. They can be differentiated by using different
     * identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param string|null $globalID
     * Global identifier of the goods recipient
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $this->objectHelper->TryCall($shipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
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
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
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
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype The identifier for the identification scheme of the legal
     * registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     * 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname A name by which the party is known, if different from the party's name
     * (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
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
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($shipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string $name
     * Name or company name of the different end recipient
     * @param string|null $id
     * Identification of the different end recipient. Multiple IDs can be assigned or specified. They can be
     * differentiated by using different identification schemes.
     * @param string|null $description
     * Further legal information that is relevant for the different end recipient
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $globalID
     * Global identifier of the goods recipient
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box. For major customer addresses, this field must be filled with "-".
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($UltimateShipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set detailed information of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string $name
     * The name of the party
     * @param string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFrom(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setShipFromTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $globalID
     * Global identifier of the goods recipient
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $this->objectHelper->TryCall($shipFromTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($shipFromTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($shipFromTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($shipFromTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
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
     * The name of the party
     * @param string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoicerTradeParty", $invoicerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Invoicer Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $globalID
     * Global identifier of the goods recipient
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $this->objectHelper->TryCall($invoicerTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Invoicer Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($invoicerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($invoicerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,* 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($invoicerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($invoicerTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set detailed information on the different invoice recipient,
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string $name
     * The name of the party
     * @param string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoiceeTradeParty", $invoiceeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Invoicee Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $globalID
     * Global identification number
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $this->objectHelper->TryCall($invoiceeTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Invoicer Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($invoiceeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($invoiceeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($invoiceeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($invoiceeTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set detailed information about the payee, i.e. about the place that receives the payment.
     * The role of the payee may also be performed by a party other than the seller, e.g. by a factoring service.
     *
     * @param string $name
     * The name of the party. Must be used if the payee is not the same as the seller. However, the name of the
     * payee may match the name of the seller.
     * @param string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->GetTradeParty($name, $id, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setPayeeTradeParty", $payeeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the payee trade party
     *
     * @param string|null $globalID
     * Global identification number
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $this->objectHelper->TryCall($payeeTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to payee trade party
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $taxreg = $this->objectHelper->GetTaxRegistrationType($taxregtype, $taxregid);
        $this->objectHelper->TryCall($payeeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the payee trade party
     *
     * @param string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($payeeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the payee trade party
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $legalorg = $this->objectHelper->GetLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->objectHelper->TryCall($payeeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the payee trade party
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->objectHelper->TryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($payeeTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set information on the delivery conditions
     *
     * __Note__
     *  - This is only available in the EXTENDED profile
     *
     * @param string|null $code
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDeliveryTerms(?string $code): ZugferdDocumentBuilder
    {
        $deliveryterms = $this->objectHelper->GetTradeDeliveryTermsType($code);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setApplicableTradeDeliveryTerms", $deliveryterms);
        return $this;
    }

    /**
     * Set details of the associated order confirmation
     *
     * @param string $issuerassignedid
     * An identifier issued by the seller for a referenced sales order (Order confirmation number)
     * @param DateTime|null $issueddate
     * Order confirmation date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerOrderReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $sellerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSellerOrderReferencedDocument", $sellerorderrefdoc);
        return $this;
    }

    /**
     * Set details of the related buyer order
     *
     * @param string $issuerassignedid
     * An identifier issued by the buyer for a referenced order (order number)
     * @param DateTime|null $issueddate
     * Date of order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerOrderReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
        return $this;
    }

    /**
     * Set details of the associated contract
     *
     * @param string $issuerassignedid
     * The contract reference should be assigned once in the context of the specific trade relationship and for a
     * defined period of time (contract number)
     * @param DateTime|null $issueddate
     * Contract date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentContractReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setContractReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Set information about billing documents that provide evidence of claims made in the bill
     *
     * __Notes__
     *  - The documents justifying the invoice can be used to reference a document number, which should be
     *    known to the recipient, as well as an external document (referenced by a URL) or an embedded document (such
     *    as a timesheet as a PDF file). The option of linking to an external document is e.g. required when it comes
     *    to large attachments and / or sensitive information, e.g. for personal services, which must be separated
     *    from the bill
     *  - Use ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument and
     *    ZugferdDocumentReader::nextDocumentAdditionalReferencedDocument to seek between multiple additional referenced
     *    documents
     *
     * @param string $issuerassignedid
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param string $typecode
     * Type of referenced document (See codelist UNTDID 1001)
     *  - Code 916 "reference paper" is used to reference the identification of the document on which the invoice is based
     *  - Code 50 "Price / sales catalog response" is used to reference the tender or the lot
     *  - Code 130 "invoice data sheet" is used to reference an identifier for an object specified by the seller.
     * @param string|null $uriid
     * The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource
     * including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document
     * must be used if the buyer needs additional information to support the amounts billed. External documents are not part
     * of the invoice. Access to external documents can involve certain risks.
     * @param string|array|null $name
     * A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param string|null $reftypecode
     * The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the
     * recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected
     * from UNTDID 1153 in accordance with the code list entries.
     * @param DateTime|null $issueddate
     * Document date
     * @param string|null $binarydatafilename
     * Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentAdditionalReferencedDocument(string $issuerassignedid, string $typecode, ?string $uriid = null, $name = null, ?string $reftypecode = null, ?DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, $uriid, null, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "addToAdditionalReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Set a Reference to the previous invoice
     *
     * __Note__: To be used if:
     *  - a previous invoice is corrected
     *  - reference is made to previous partial invoices from a final invoice
     *  - Reference is made to previous invoices for advance payments from a final invoice
     *
     * @param string $issuerassignedid
     * Number of the previous invoice
     * @param DateTime|null $issueddate
     * Date of the previous invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $invoicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setInvoiceReferencedDocument", $invoicerefdoc);
        return $this;
    }

    /**
     * Set Details of a project reference
     *
     * @param string $id
     * Project Data
     * @param string $name
     * Project Name
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProcuringProject(string $id, string $name): ZugferdDocumentBuilder
    {
        $procuringproject = $this->objectHelper->GetProcuringProjectType($id, $name);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "setSpecifiedProcuringProject", $procuringproject);
        return $this;
    }

    /**
     * Add a reference of the ultimate customer order
     *
     * @param string $issuerassignedid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateCustomerOrderReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeAgreement, "addToUltimateCustomerOrderReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Set detailed information on the actual delivery
     *
     * @param DateTime|null $date
     * Actual delivery time
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSupplyChainEvent(?DateTime $date): ZugferdDocumentBuilder
    {
        $supplyChainevent = $this->objectHelper->GetSupplyChainEventType($date);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);
        return $this;
    }

    /**
     * Set detailed information on the associated shipping notification
     *
     * @param string $issuerassignedid
     * Shipping notification reference
     * @param DateTime|null $issueddate
     * Shipping notification date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDespatchAdviceReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $despatchddvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Set detailed information on the associated goods receipt notification
     *
     * @param string $issuerassignedid
     * An identifier for a referenced goods receipt notification (Goods receipt number)
     * @param DateTime|null $issueddate
     * Goods receipt date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentReceivingAdviceReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $receivingadvicerefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Set detailed information on the associated delivery note
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string $issuerassignedid
     * Delivery receipt number
     * @param DateTime|null $issueddate
     * Delivery receipt date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDeliveryNoteReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $deliverynoterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($this->headerTradeDelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }

    /**
     * Add detailed information on the payment method
     *
     * __Notes__
     *  - The SpecifiedTradeSettlementPaymentMeans element can only be repeated for each bank account if
     *    several bank accounts are to be transferred for transfers. The code for the payment method in the Typecode
     *    element must therefore not differ in the repetitions. The elements ApplicableTradeSettlementFinancialCard
     *    and PayerPartyDebtorFinancialAccount must not be specified for bank transfers.
     *
     * @param string $typecode
     * The expected or used means of payment, expressed as a code. The entries from the UNTDID 4461 code list
     * must be used. A distinction should be made between SEPA and non-SEPA payments as well as between credit
     * payments, direct debits, card payments and other means of payment In particular, the following codes can
     * be used:
     *  - 10: cash
     *  - 20: check
     *  - 30: transfer
     *  - 42: Payment to bank account
     *  - 48: Card payment
     *  - 49: direct debit
     *  - 57: Standing order
     *  - 58: SEPA Credit Transfer
     *  - 59: SEPA Direct Debit
     *  - 97: Report
     * @param string|null $information
     * The expected or used means of payment expressed in text form, e.g. cash, bank transfer, direct debit,
     * credit card, etc.
     * @param string|null $cardType
     * The type of the card
     * @param string|null $cardId
     * The primary account number (PAN) to which the card used for payment belongs. In accordance with card
     * payment security standards, an invoice should never contain a full payment card master account number.
     * The following specification of the PCI Security Standards Council currently applies: The first 6 and
     * last 4 digits at most are to be displayed
     * @param string|null $cardHolderName
     * Name of the payment card holder
     * @param string|null $buyerIban
     * Direct debit: ID of the account to be debited
     * @param string|null $payeeIban
     * Transfer: A unique identifier for the financial account held with a payment service provider to which
     * the payment should be made, e.g. Use an IBAN (in the case of a SEPA payment) for a national ProprietaryID
     * account number
     * @param string|null $payeeAccountName
     * The name of the payment account held with a payment service provider to which the payment should be made.
     * Information only required if different from the name of the payee / seller
     * @param string|null $payeePropId
     * National account number (not for SEPA)
     * @param string|null $payeeBic
     * Seller's banking institution, An identifier for the payment service provider with whom the payment account
     * is managed, such as the BIC or a national bank code, if required. No identification scheme is to be used.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMean(string $typecode, ?string $information = null, ?string $cardType = null, ?string $cardId = null, ?string $cardHolderName = null, ?string $buyerIban = null, ?string $payeeIban = null, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null): ZugferdDocumentBuilder
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
     * Add a VAT breakdown (at document level)
     *
     * @param string $categoryCode
     * Coded description of a sales tax category
     *
     * The following entries from UNTDID 5305 are used (details in brackets):
     *  - Standard rate (sales tax is due according to the normal procedure)
     *  - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *  - Tax exempt (USt./IGIC/IPSI)
     *  - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *  - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *  - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *  - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *  - Canary Islands general indirect tax (IGIC tax applies)
     *  - IPSI (tax for Ceuta / Melilla) applies.
     *
     * The codes for the VAT category are as follows:
     *  - S = sales tax is due at the normal rate
     *  - Z = goods to be taxed according to the zero rate
     *  - E = tax exempt
     *  - AE = reversal of tax liability
     *  - K = VAT is not shown for intra-community deliveries
     *  - G = tax not levied due to export outside the EU
     *  - O = Outside the tax scope
     *  - L = IGIC (Canary Islands)
     *  - M = IPSI (Ceuta / Melilla)
     * @param string $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param float $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param float $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param float|null $rateApplicablePercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @param string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @param string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @param float|null $lineTotalBasisAmount
     * Tax rate goods amount
     * @param float|null $allowanceChargeBasisAmount
     * Total amount of surcharges and deductions of the tax rate at document level
     * @param DateTime|null $taxPointDate
     * Specification of a date, in accordance with the sales tax guideline, on which the sales tax
     * for the seller and for the buyer becomes relevant for accounting, insofar as this date can be
     * determined and differs from the invoice date
     * Note: The tax collection date for VAT purposes is usually the date the goods were delivered or
     * the service was completed (the base tax date). There are a few variations. For further information,
     * please refer to Article 226 (7) of Council Directive 2006/112 / EC. This element is required
     * if the date set for the sales tax return differs from the invoice date. Both the buyer and the
     * seller should use the delivery date for VAT returns, if provided by the seller.
     * This is not used in Germany. Instead, the delivery and service date must be specified.
     * @param string|null $dueDateTypeCode
     * The code for the date on which sales tax becomes relevant for the seller and the buyer.
     * The code must distinguish between the following entries from UNTDID 2005:
     *  - date of issue of the invoice document
     *  - actual delivery date
     *  - Date of payment.
     *
     * The VAT Collection Date Code is used when the VAT Collection Date is not known for VAT purposes
     * when the invoice is issued.
     *
     * The semantic values cited in the standard, which are represented by the values 3, 35, 432 in
     * UNTDID2005, are mapped to the following values of UNTDID2475, which is the relevant code list
     * supported by CII 16B:
     *  - 5: date of issue of the invoice
     *  - 29: Delivery date, current status
     *  - 72: Paid to date
     *
     * In Germany, the date of delivery and service is decisive.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentTax(string $categoryCode, string $typeCode, float $basisAmount, float $calculatedAmount, ?float $rateApplicablePercent = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null, ?float $lineTotalBasisAmount = null, ?float $allowanceChargeBasisAmount = null, ?DateTime $taxPointDate = null, ?string $dueDateTypeCode = null): ZugferdDocumentBuilder
    {
        $tax = $this->objectHelper->GetTradeTaxType($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToApplicableTradeTax", $tax);
        return $this;
    }

    /**
     * Add a VAT breakdown (at document level) in a more simple way
     *
     * @param string $categoryCode
     * Coded description of a sales tax category
     *
     * The following entries from UNTDID 5305 are used (details in brackets):
     *  - Standard rate (sales tax is due according to the normal procedure)
     *  - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *  - Tax exempt (USt./IGIC/IPSI)
     *  - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *  - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *  - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *  - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *  - Canary Islands general indirect tax (IGIC tax applies)
     *  - IPSI (tax for Ceuta / Melilla) applies.
     *
     * The codes for the VAT category are as follows:
     *  - S = sales tax is due at the normal rate
     *  - Z = goods to be taxed according to the zero rate
     *  - E = tax exempt
     *  - AE = reversal of tax liability
     *  - K = VAT is not shown for intra-community deliveries
     *  - G = tax not levied due to export outside the EU
     *  - O = Outside the tax scope
     *  - L = IGIC (Canary Islands)
     *  - M = IPSI (Ceuta / Melilla)
     * @param string $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param float $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param float $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param float|null $rateApplicablePercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentTaxSimple(string $categoryCode, string $typeCode, float $basisAmount, float $calculatedAmount, ?float $rateApplicablePercent = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent);
    }

    /**
     * Get detailed information on the billing period
     *
     * @param DateTime|null $startdate
     * Start of the billing period
     * @param DateTime|null $endDate
     * End of the billing period
     * @param string|null $description
     * Further information of the billing period
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBillingPeriod(?DateTime $startdate, ?DateTime $endDate, ?string $description): ZugferdDocumentBuilder
    {
        $period = $this->objectHelper->GetSpecifiedPeriodType($startdate, $endDate, null, $description);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "setBillingSpecifiedPeriod", $period);
        return $this;
    }

    /**
     * Add information about surcharges and charges applicable to the bill as a whole, Deductions,
     * such as for withheld taxes may also be specified in this group
     *
     * @param float $actualAmount
     * Amount of the surcharge or discount at document level
     * @param boolean $isCharge
     * Switch that indicates whether the following data refer to an allowance or a discount, true means that
     * this an charge
     * @param string $taxCategoryCode
     * A coded indication of which sales tax category applies to the surcharge or deduction at document level
     *
     * The following entries from UNTDID 5305 are used (details in brackets):
     *  - Standard rate (sales tax is due according to the normal procedure)
     *  - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *  - Tax exempt (USt./IGIC/IPSI)
     *  - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *  - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *  - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *  - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *  - Canary Islands general indirect tax (IGIC tax applies)
     *  - IPSI (tax for Ceuta / Melilla) applies.
     *
     * The codes for the VAT category are as follows:
     *  - S = sales tax is due at the normal rate
     *  - Z = goods to be taxed according to the zero rate
     *  - E = tax exempt
     *  - AE = reversal of tax liability
     *  - K = VAT is not shown for intra-community deliveries
     *  - G = tax not levied due to export outside the EU
     *  - O = Outside the tax scope
     *  - L = IGIC (Canary Islands)
     *  - M = IPSI (Ceuta/Melilla)
     * @param string $taxTypeCode
     * Code for the VAT category of the surcharge or charge at document level. Note: Fixed value = "VAT"
     * @param float $rateApplicablePercent
     * VAT rate for the surcharge or discount on document level. Note: The code of the sales tax category
     * and the category-specific sales tax rate must correspond to one another. The value to be given is
     * the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param float|null $sequence
     * Calculation order
     * @param float|null $calculationPercent
     * Percentage surcharge or discount at document level
     * @param float|null $basisAmount
     * The base amount that may be used in conjunction with the percentage of the surcharge or discount
     * at document level to calculate the amount of the discount at document level
     * @param float|null $basisQuantity
     * Basismenge des Rabatts
     * @param string|null $basisQuantityUnitCode
     * Einheit der Preisbasismenge
     *  - Codeliste: Rec. N°20 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     *  - Codeliste: Rec. N°21 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     * @param string|null $reasonCode
     * The reason given as a code for the surcharge or discount at document level. Note: Use entries from
     * the UNTDID 5189 code list. The code of the reason for the surcharge or discount at document level
     * and the reason for the surcharge or discount at document level must correspond to each other
     *
     * Code list: UNTDID 7161 Complete list, code list: UNTDID 5189 Restricted
     * Include PEPPOL subset:
     *  - 41 - Bonus for works ahead of schedule
     *  - 42 - Other bonus
     *  - 60 - Manufacturer’s consumer discount
     *  - 62 - Due to military status
     *  - 63 - Due to work accident
     *  - 64 - Special agreement
     *  - 65 - Production error discount
     *  - 66 - New outlet discount
     *  - 67 - Sample discount
     *  - 68 - End-of-range discount
     *  - 70 - Incoterm discount
     *  - 71 - Point of sales threshold allowance
     *  - 88 - Material surcharge/deduction
     *  - 95 - Discount
     *  - 100 - Special rebate
     *  - 102 - Fixed long term
     *  - 103 - Temporary
     *  - 104 - Standard
     *  - 105 - Yearly turnover
     * @param string|null $reason
     * The reason given in text form for the surcharge or discount at document level
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentAllowanceCharge(float $actualAmount, bool $isCharge, string $taxCategoryCode, string $taxTypeCode, float $rateApplicablePercent, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ZugferdDocumentBuilder
    {
        $allowanceCharge = $this->objectHelper->GetTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);
        return $this;
    }

    /**
     * Add a logistical service fees (On document level)
     *
     * @param string $description
     * Identification of the service fee
     * @param float $appliedAmount
     * Amount of the service fee
     * @param array|null $taxTypeCodes
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param array|null $taxCategpryCodes
     * Coded description of a sales tax category
     *
     * The following entries from UNTDID 5305 are used (details in brackets):
     *  - Standard rate (sales tax is due according to the normal procedure)
     *  - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *  - Tax exempt (USt./IGIC/IPSI)
     *  - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *  - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *  - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *  - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *  - Canary Islands general indirect tax (IGIC tax applies)
     *  - IPSI (tax for Ceuta / Melilla) applies.
     *
     * The codes for the VAT category are as follows:
     *  - S = sales tax is due at the normal rate
     *  - Z = goods to be taxed according to the zero rate
     *  - E = tax exempt
     *  - AE = reversal of tax liability
     *  - K = VAT is not shown for intra-community deliveries
     *  - G = tax not levied due to export outside the EU
     *  - O = Outside the tax scope
     *  - L = IGIC (Canary Islands)
     *  - M = IPSI (Ceuta / Melilla)
     * @param array|null $rateApplicablePercents
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentLogisticsServiceCharge(string $description, float $appliedAmount, ?array $taxTypeCodes = null, ?array $taxCategpryCodes = null, ?array $rateApplicablePercents = null): ZugferdDocumentBuilder
    {
        $logcharge = $this->objectHelper->GetLogisticsServiceChargeType($description, $appliedAmount, $taxTypeCodes, $taxCategpryCodes, $rateApplicablePercents);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToSpecifiedLogisticsServiceCharge", $logcharge);
        return $this;
    }

    /**
     * Add a payment term
     *
     * @param string|null $description
     * A text description of the payment terms that apply to the payment amount due (including a
     * description of possible penalties). Note: This element can contain multiple lines and
     * multiple conditions.
     * @param DateTime|null $dueDate
     * The date by which payment is due Note: The payment due date reflects the net payment due
     * date. In the case of partial payments, this indicates the first due date of a net payment.
     * The corresponding description of more complex payment terms can be given in BT-20.
     * @param string|null $directDebitMandateID
     * Unique identifier assigned by the payee to reference the direct debit authorization.
     * __Note:__ Used to inform the buyer in advance about a SEPA direct debit. __Synonym:__ mandate reference for SEPA
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentTerm(?string $description = null, ?DateTime $dueDate = null, ?string $directDebitMandateID = null): ZugferdDocumentBuilder
    {
        $paymentTerms = $this->objectHelper->GetTradePaymentTermsType($description, $dueDate, $directDebitMandateID);
        $this->objectHelper->TryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradePaymentTerms", "setSpecifiedTradePaymentTerms"], $paymentTerms);
        $this->currentPaymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * Add discount Terms to last added payment term
     *
     * @param float|null $calculationPercent
     * Percentage of the down payment
     * @param DateTime|null $basisDateTime
     * Due date reference date
     * @param float|null $basisPeriodMeasureValue
     * Due period
     * @param string|null $basisPeriodMeasureUnitCode
     * Due period, unit
     * @param float|null $basisAmount
     * Base amount of the down payment
     * @param float|null $actualDiscountAmount
     * Amount of the down payment
     * @return ZugferdDocumentBuilder
     */
    public function addDiscountTermsToPaymentTerms(?float $calculationPercent = null, ?DateTime $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $actualDiscountAmount = null): ZugferdDocumentBuilder
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
    public function addDocumentReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode): ZugferdDocumentBuilder
    {
        $account = $this->objectHelper->GetTradeAccountingAccountType($id, $typeCode);
        $this->objectHelper->TryCall($this->headerTradeSettlement, "addToReceivableSpecifiedTradeAccountingAccount", $account);
        return $this;
    }

    /**
     * Adds a new position (line) to document
     *
     * @param string $lineid
     * A unique identifier for the relevant item within the invoice (item number)
     * @param string|null $lineStatusCode
     * Indicates whether the invoice item contains prices that must be taken into account when
     * calculating the invoice amount, or whether it only contains information.
     * The following code should be used: TYPE_LINE
     * @param string|null $lineStatusReasonCode
     * Adds the type to specify whether the invoice line is:
     *  - detail (normal position)
     *  - Subtotal
     *  - Information only
     *
     * If the $lineStatusCode field is used, the LineStatusReasonCode field must use the following codes:
     *  - detail
     *  - grouping
     *  - information
     * @return ZugferdDocumentBuilder
     */
    public function addNewPosition(string $lineid, ?string $lineStatusCode = null, ?string $lineStatusReasonCode = null): ZugferdDocumentBuilder
    {
        $position = $this->objectHelper->GetSupplyChainTradeLineItemType($lineid, $lineStatusCode, $lineStatusReasonCode);
        $this->objectHelper->TryCall($this->headerSupplyChainTradeTransaction, "addToIncludedSupplyChainTradeLineItem", $position);
        $this->currentPosition = $position;
        return $this;
    }

    /**
     * Add detailed information on the free text on the position
     *
     * @param string $content
     * A free text that contains unstructured information that is relevant to the invoice item
     * @param string|null $contentCode
     * Text modules agreed bilaterally, which are transmitted here as code.
     * @param string|null $subjectCode
     * Free text for the position (code for the type)
     * __Codelist:__ UNTDID 4451
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNote(string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
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
     * A name of the item (item name)
     * @param string|null $description
     * A description of the item, the item description makes it possible to describe the item and its
     * properties in more detail than is possible with the item name.
     * @param string|null $sellerAssignedID
     * An identifier assigned to the item by the seller
     * @param string|null $buyerAssignedID
     * An identifier assigned to the item by the buyer. The article number of the buyer is a clear,
     * bilaterally agreed identification of the product. It can, for example, be the customer article
     * number or the article number assigned by the manufacturer.
     * @param string|null $globalIDType
     * The scheme for $globalID
     * @param string|null $globalID
     * Identification of an article according to the registered scheme (Global identifier of the product,
     * GTIN, ...)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionProductDetails(string $name, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null): ZugferdDocumentBuilder
    {
        $product = $this->objectHelper->GetTradeProductType($name, $description, $sellerAssignedID, $buyerAssignedID, $globalIDType, $globalID);
        $this->objectHelper->TryCall($this->currentPosition, "setSpecifiedTradeProduct", $product);
        return $this;
    }

    /**
     * Set details of the related buyer order position
     *
     * @param string $issuerassignedid
     * An identifier issued by the buyer for a referenced order (order number)
     * @param string $lineid
     * An identifier for a position within an order placed by the buyer. Note: Reference is made to the order
     * reference at the document level.
     * @param DateTime|null $issueddate
     * Date of order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionBuyerOrderReferencedDocument(string $issuerassignedid, string $lineid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
        return $this;
    }

    /**
     * Set details of the related contract position
     *
     * @param string $issuerassignedid
     * The contract reference should be assigned once in the context of the specific trade relationship and for a
     * defined period of time (contract number)
     * @param string $lineid
     * Identifier of the according contract position
     * @param DateTime|null $issueddate
     * Contract date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionContractReferencedDocument(string $issuerassignedid, string $lineid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setContractReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Add an additional Document reference on a position
     *
     * __Notes__
     *  - The documents justifying the invoice can be used to reference a document number, which should be
     *    known to the recipient, as well as an external document (referenced by a URL) or an embedded document (such
     *    as a timesheet as a PDF file). The option of linking to an external document is e.g. required when it comes
     *    to large attachments and / or sensitive information, e.g. for personal services, which must be separated
     *    from the bill
     *  - Use ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument and
     *    ZugferdDocumentReader::nextDocumentAdditionalReferencedDocument to seek between multiple additional referenced
     *    documents
     *
     * @param string $issuerassignedid
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param string $typecode
     * Type of referenced document (See codelist UNTDID 1001)
     *  - Code 916 "reference paper" is used to reference the identification of the document on which the invoice is based
     *  - Code 50 "Price / sales catalog response" is used to reference the tender or the lot
     *  - Code 130 "invoice data sheet" is used to reference an identifier for an object specified by the seller.
     * @param string|null $uriid
     * The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource
     * including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document
     * must be used if the buyer needs additional information to support the amounts billed. External documents are not part
     * of the invoice. Access to external documents can involve certain risks.
     * @param string|null $lineid
     * The referenced position identifier in the additional document
     * @param string|null $name
     * A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param string|null $reftypecode
     * The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the
     * recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected
     * from UNTDID 1153 in accordance with the code list entries.
     * @param DateTime|null $issueddate
     * Document date
     * @param string|null $binarydatafilename
     * Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionAdditionalReferencedDocument(string $issuerassignedid, string $typecode, ?string $uriid = null, ?string $lineid = null, ?string $name = null, ?string $reftypecode = null, ?DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "addToAdditionalReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Add a referennce to a ultimate customer order referenced document
     *
     * @param string $issuerassignedid
     * @param string $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateCustomerOrderReferencedDocument(string $issuerassignedid, string $lineid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $ultimaterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "addToUltimateCustomerOrderReferencedDocument", $ultimaterefdoc);
        return $this;
    }

    /**
     * Set the unit price excluding sales tax before deduction of the discount on the item price.
     *
     * @param float $amount
     * The unit price excluding sales tax before deduction of the discount on the item price.
     * Note: If the price is shown according to the net calculation, the price must also be shown
     * according to the gross calculation.
     * @param float|null $basisQuantity
     * The number of item units for which the price applies (price base quantity)
     * @param string|null $basisQuantityUnitCode
     * The unit code of the number of item units for which the price applies (price base quantity)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionGrossPrice(float $amount, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $grossPrice = $this->objectHelper->GetTradePriceType($amount, $basisQuantity, $basisQuantityUnitCode);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setGrossPriceProductTradePrice", $grossPrice);
        return $this;
    }

    /**
     * Detailed information on surcharges and discounts on item gross price
     *
     * @param float $actualAmount
     * Discount on the item price. The total discount subtracted from the gross price to calculate the
     * net price. Note: Only applies if the discount is given per unit and is not included in the gross price.
     * @param boolean|null $isCharge
     * Switch for surcharge/discount, if true then its an charge
     * @param float|null $calculationPercent
     * Discount/surcharge in percent. Up to level EN16931, only the final result of the discount (ActualAmount)
     * is transferred
     * @param float|null $basisAmount
     * Base amount of the discount/surcharge
     * @param string|null $reason
     * Reason for surcharge/discount (free text)
     * @param string|null $taxTypeCode
     * @param string|null $taxCategoryCode
     * @param float|null $rateApplicablePercent
     * @param float|null $sequence
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @param string|null $reasonCode
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionGrossPriceAllowanceCharge(float $actualAmount, ?bool $isCharge = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?string $reason = null, ?string $taxTypeCode = null, ?string $taxCategoryCode = null, ?float $rateApplicablePercent = null, ?float $sequence = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null): ZugferdDocumentBuilder
    {
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $grossPrice = $this->objectHelper->TryCallAndReturn($positionagreement, "getGrossPriceProductTradePrice");
        $allowanceCharge = $this->objectHelper->GetTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->objectHelper->TryCallAll($grossPrice, ["addToAppliedTradeAllowanceCharge", "setAppliedTradeAllowanceCharge"], $allowanceCharge);
        return $this;
    }

    /**
     * Set detailed information on the net price of the item
     *
     * @param float $amount
     * Net price of the item
     * @param float|null $basisQuantity
     * Base quantity at the item price
     * @param string|null $basisQuantityUnitCode
     * Code of the unit of measurement of the base quantity at the item price
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNetPrice(float $amount, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $netPrice = $this->objectHelper->GetTradePriceType($amount, $basisQuantity, $basisQuantityUnitCode);
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->objectHelper->TryCall($positionagreement, "setNetPriceProductTradePrice", $netPrice);
        return $this;
    }

    /**
     * Tax included for B2C on position level
     *
     * @param string $categoryCode
     * Coded description of a sales tax category
     *
     * The following entries from UNTDID 5305 are used (details in brackets):
     *  - Standard rate (sales tax is due according to the normal procedure)
     *  - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *  - Tax exempt (USt./IGIC/IPSI)
     *  - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *  - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *  - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *  - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *  - Canary Islands general indirect tax (IGIC tax applies)
     *  - IPSI (tax for Ceuta / Melilla) applies.
     *
     * The codes for the VAT category are as follows:
     *  - S = sales tax is due at the normal rate
     *  - Z = goods to be taxed according to the zero rate
     *  - E = tax exempt
     *  - AE = reversal of tax liability
     *  - K = VAT is not shown for intra-community deliveries
     *  - G = tax not levied due to export outside the EU
     *  - O = Outside the tax scope
     *  - L = IGIC (Canary Islands)
     *  - M = IPSI (Ceuta / Melilla)
     * @param string $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param float $rateApplicablePercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @param float|null $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @param string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNetPriceTax(string $categoryCode, string $typeCode, float $rateApplicablePercent, ?float $calculatedAmount = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionagreement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $netPrice = $this->objectHelper->TryCallAndReturn($positionagreement, "getNetPriceProductTradePrice");
        $tax = $this->objectHelper->GetTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);
        $this->objectHelper->TryCall($netPrice, "setIncludedTradeTax", $tax);
        return $this;
    }

    /**
     * Set the position Quantity
     *
     * @param float $billedQuantity
     * The quantity of individual items (goods or services) billed in the relevant line
     * @param string $billedQuantityUnitCode
     * The unit of measure applicable to the amount billed. Note: The unit of measurement must be taken from the
     * lists from UN / ECE Recommendation No. 20 "Codes for Units of Measure Used in International Trade" and
     * UN / ECE Recommendation No. 21 "Codes for Passengers, Types of Cargo, Packages and Packaging Materials
     * (with Complementary Codes for Package Names)" using the UN / ECE Rec No. 20 Intro 2.a) can be selected.
     * It should be noted that in most cases it is not necessary for buyers and sellers to fully implement these
     * lists in their software. Sellers only need to support the entities necessary for their goods and services;
     * Buyers only need to verify that the units used in the invoice match those in other documents (such as in
     * Contracts, catalogs, orders and shipping notifications) match the units used.
     * @param float|null $chargeFreeQuantity
     * Quantity, free of charge
     * @param string|null $chargeFreeQuantityUnitCpde
     * Unit of measure code for the quantity free of charge
     * @param float|null $packageQuantity
     * Number of packages
     * @param string|null $packageQuantityUnitCode
     * Unit of measure code for number of packages
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionQuantity(float $billedQuantity, string $billedQuantityUnitCode, ?float $chargeFreeQuantity = null, ?string $chargeFreeQuantityUnitCpde = null, ?float $packageQuantity = null, ?string $packageQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $this->objectHelper->TryCall($positiondelivery, "setBilledQuantity", $this->objectHelper->GetQuantityType($billedQuantity, $billedQuantityUnitCode));
        $this->objectHelper->TryCall($positiondelivery, "setChargeFreeQuantity", $this->objectHelper->GetQuantityType($chargeFreeQuantity, $chargeFreeQuantityUnitCpde));
        $this->objectHelper->TryCall($positiondelivery, "setPackageQuantity", $this->objectHelper->GetQuantityType($packageQuantity, $packageQuantityUnitCode));
        return $this;
    }

    /**
     * Set detailed information on the different ship-to party at item level
     *
     * @param string $name
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param string|null $id
     * An identifier for the place where the goods are delivered or where the services are provided.
     * Multiple IDs can be assigned or specified. They can be differentiated by using different
     * identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
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
     * The identifier is uniquely assigned to a party by a global registration organization.
     * @param string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $this->objectHelper->TryCall($shipToTradeParty, "addToGlobalID", $this->objectHelper->GetIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * The local identification (defined by the party's address) of the party for tax purposes or a reference that enables the party
     * to indicate his reporting status for tax purposes The sales tax identification number of the party
     * Note: This information may affect how the buyer the invoice settled (such as in relation to social security contributions). So
     * e.g. In some countries, if the party is not reported for tax, the buyer will withhold the tax amount and pay it on behalf of the
     * party. Sales tax number with a prefixed country code. A supplier registered as subject to VAT must provide his sales tax
     * identification number, unless he uses a tax agent.
     *
     * @param string|null $taxregtype
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
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
     * The main line in the product end users address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the product end users address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The product end users state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $address = $this->objectHelper->GetTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->objectHelper->TryCall($shipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party on item level
     *
     * @param string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype
     * registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     * 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname A name by which the party is known, if different from the party's name
     * (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
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
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->objectHelper->TryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $contact = $this->objectHelper->GetTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->objectHelper->TryCall($shipToTradeParty, "setDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param string $name
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param string|null $id
     * An identifier for the party Multiple IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
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
     * Global identifier of the parfty
     * @param string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
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
     * Type of tax number of the party
     * @param string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
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
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
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
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param string|null $legalorgtype The identifier for the identification scheme of the legal
     * registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     * 0060 : DUNS, 0177 : ODETTE
     * @param string|null $legalorgname A name by which the party is known, if different from the party's name
     * (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
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
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
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
     * @param DateTime|null $date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionSupplyChainEvent(?DateTime $date): ZugferdDocumentBuilder
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
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionDespatchAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?DateTime $issueddate = null): ZugferdDocumentBuilder
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
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionReceivingAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?DateTime $issueddate = null): ZugferdDocumentBuilder
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
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionDeliveryNoteReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $deliverynoterefdoc = $this->objectHelper->GetReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->objectHelper->TryCall($positiondelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }

    /**
     * Add information about the sales tax that applies to the goods and services invoiced
     * in the relevant invoice line
     *
     * @param string $categoryCode
     * Coded description of a sales tax category
     *
     * The following entries from UNTDID 5305 are used (details in brackets):
     *  - Standard rate (sales tax is due according to the normal procedure)
     *  - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *  - Tax exempt (USt./IGIC/IPSI)
     *  - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *  - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *  - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *  - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *  - Canary Islands general indirect tax (IGIC tax applies)
     *  - IPSI (tax for Ceuta / Melilla) applies.
     *
     * The codes for the VAT category are as follows:
     *  - S = sales tax is due at the normal rate
     *  - Z = goods to be taxed according to the zero rate
     *  - E = tax exempt
     *  - AE = reversal of tax liability
     *  - K = VAT is not shown for intra-community deliveries
     *  - G = tax not levied due to export outside the EU
     *  - O = Outside the tax scope
     *  - L = IGIC (Canary Islands)
     *  - M = IPSI (Ceuta / Melilla)
     * @param string $typeCode
     * In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be
     * specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for
     * the tax type must then be taken from the code list UNTDID 5153.
     * @param float $rateApplicablePercent
     * The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales
     * tax category and the category-specific sales tax rate  must correspond to one another. The value to be
     * given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param float|null $calculatedAmount
     * Tax amount. Information only for taxes that are not VAT.
     * @param string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @param string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionTax(string $categoryCode, string $typeCode, float $rateApplicablePercent, ?float $calculatedAmount = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $tax = $this->objectHelper->GetTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);
        $this->objectHelper->TryCallAll($positionsettlement, ["addToApplicableTradeTax", "setApplicableTradeTax"], $tax);
        return $this;
    }

    /**
     * Set information about the period relevant for the invoice item.
     * Note: Also known as the invoice line delivery period.
     *
     * @param DateTime|null $startdate
     * Start of the billing period
     * @param DateTime|null $endDate
     * End of the billing period
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionBillingPeriod(?DateTime $startdate, ?DateTime $endDate): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $period = $this->objectHelper->GetSpecifiedPeriodType($startdate, $endDate, null, null);
        $this->objectHelper->TryCall($positionsettlement, "setBillingSpecifiedPeriod", $period);
        return $this;
    }

    /**
     * Add surcharges and discounts on position level
     *
     * @param float $actualAmount
     * The surcharge/discount amount excluding sales tax
     * @param boolean $isCharge
     * Switch that indicates whether the following data refer to an allowance or a discount,
     * true means that
     * @param float|null $calculationPercent
     * The percentage that may be used in conjunction with the base invoice line discount
     * amount to calculate the invoice line discount amount
     * @param float|null $basisAmount
     * The base amount that may be used in conjunction with the invoice line discount percentage
     * to calculate the invoice line discount amount
     * @param string|null $reasonCode
     * The reason given as a code for the invoice line discount
     *
     * __Notes__
     *  - Use entries from the UNTDID 5189 code list (discounts) or the UNTDID 7161 code list
     *    (surcharges). The invoice line discount reason code and the invoice line discount reason must
     *    match.
     *  - In the case of a discount, the code list UNTDID 5189 must be used.
     *  - In the event of a surcharge, the code list UNTDID 7161 must be used.
     *
     * In particular, the following codes can be used:
     *  - AA = Advertising
     *  - ABL = Additional packaging
     *  - ADR = Other services
     *  - ADT = Pick-up
     *  - FC = Freight service
     *  - FI = Financing
     *  - LA = Labelling
     *
     * Include PEPPOL subset:
     *  - 41 - Bonus for works ahead of schedule
     *  - 42 - Other bonus
     *  - 60 - Manufacturer’s consumer discount
     *  - 62 - Due to military status
     *  - 63 - Due to work accident
     *  - 64 - Special agreement
     *  - 65 - Production error discount
     *  - 66 - New outlet discount
     *  - 67 - Sample discount
     *  - 68 - End-of-range discount
     *  - 70 - Incoterm discount
     *  - 71 - Point of sales threshold allowance
     *  - 88 - Material surcharge/deduction
     *  - 95 - Discount
     *  - 100 - Special rebate
     *  - 102 - Fixed long term
     *  - 103 - Temporary
     *  - 104 - Standard
     *  - 105 - Yearly turnover
     *
     * Codelists: UNTDID 7161 (Complete list), UNTDID 5189 (Restricted)
     * @param string|null $reason
     * The reason given in text form for the invoice item discount/surcharge
     *
     * __Notes__
     *  - The invoice line discount reason code (BT-140) and the invoice line discount reason
     *    (BT-139) must show the same allowance type.
     *  - Each line item discount (BG-27) must include a corresponding line discount reason
     *    (BT-139) or an appropriate line discount reason code (BT-140), or both.
     *  - The code for the reason for the charge at the invoice line level (BT-145) and the
     *    reason for the invoice line discount (BT-144) must show the same discount type
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionAllowanceCharge(float $actualAmount, bool $isCharge, ?float $calculationPercent = null, ?float $basisAmount = null, ?string $reasonCode = null, ?string $reason = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $allowanceCharge = $this->objectHelper->GetTradeAllowanceChargeType($actualAmount, $isCharge, null, null, null, null, $calculationPercent, $basisAmount, null, null, $reasonCode, $reason);
        $this->objectHelper->TryCall($positionsettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);
        return $this;
    }

    /**
     * Set information on item totals
     *
     * @param float $lineTotalAmount
     * The total amount of the invoice item.
     * __Note:__ This is the "net" amount, that is, excluding sales tax, but including all surcharges
     * and discounts applicable to the item level, as well as other taxes.
     * @param float|null $totalAllowanceChargeAmount
     * Total amount of item surcharges and discounts
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionLineSummation(float $lineTotalAmount, ?float $totalAllowanceChargeAmount = null): ZugferdDocumentBuilder
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
    public function addDocumentPositionReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->objectHelper->TryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $account = $this->objectHelper->GetTradeAccountingAccountType($id, $typeCode);
        $this->objectHelper->TryCall($positionsettlement, "addToReceivableSpecifiedTradeAccountingAccount", $account);
        return $this;
    }
}
