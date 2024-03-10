<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DateTime;
use DOMDocument;
use DOMXPath;

/**
 * Class representing the document builder for outgoing documents
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
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
     * Receive the content as XML string
     *
     * @return string
     * @see https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
     */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Creates a new ZugferdDocumentBuilder with profile $profile
     *
     * @codeCoverageIgnore
     *
     * @param  integer $profileId
     * @return ZugferdDocumentBuilder
     */
    public static function createNew(int $profileId): ZugferdDocumentBuilder
    {
        return (new static($profileId))->initNewDocument();
    }

    /**
     * Initialized a new document with profile settings
     *
     * @return ZugferdDocumentBuilder
     */
    public function initNewDocument(): ZugferdDocumentBuilder
    {
        $this->createInvoiceObject();

        $this->headerTradeAgreement = $this->getInvoiceObject()->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement();
        $this->headerTradeDelivery = $this->getInvoiceObject()->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery();
        $this->headerTradeSettlement = $this->getInvoiceObject()->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement();
        $this->headerSupplyChainTradeTransaction = $this->getInvoiceObject()->getSupplyChainTradeTransaction();

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

        return $this->serializeAsXml();
    }

    /**
     * Write the content of a invoice object to a DOMDocument instance
     *
     * @return DOMDocument
     */
    public function getContentAsDomDocument(): DOMDocument
    {
        $domDocument = new DOMDocument();
        $domDocument->loadXML($this->getContent());

        return $domDocument;
    }

    /**
     * Write the content of a invoice object to a DOMXpath instance
     *
     * @return DOMXpath
     */
    public function getContentAsDomXPath(): DOMXpath
    {
        $domXPath = new DOMXPath($this->getContentAsDomDocument());

        return $domXPath;
    }

    /**
     * Write the content of a CrossIndustryInvoice object to a file
     *
     * @param  string $xmlfilename
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
     * @param string        $documentno
     * The document no issued by the seller
     * @param string        $documenttypecode
     * The type of the document, See \horstoeko\codelists\ZugferdInvoiceType for details
     * @param DateTime      $documentdate             Date of invoice
     *                                                The date when
     *                                                the document
     *                                                was issued by
     *                                                the seller

     * @param string        $invoiceCurrency          Code for the invoice currency
     *                                                The code for the invoice
     *                                                currency

     * @param string|null   $documentname             Document Type
     *                                                The document
     *                                                type (free
     *                                                text)

     * @param string|null   $documentlanguage         Language indicator
     *                                                The language code
     *                                                in which the
     *                                                document was
     *                                                written

     * @param  DateTime|null $effectiveSpecifiedPeriod
     * The contractual due date of the invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInformation(string $documentno, string $documenttypecode, DateTime $documentdate, string $invoiceCurrency, ?string $documentname = null, ?string $documentlanguage = null, ?DateTime $effectiveSpecifiedPeriod = null): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setID", $this->getObjectHelper()->getIdType($documentno));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setName", $this->getObjectHelper()->getTextType($documentname));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setTypeCode", $this->getObjectHelper()->getDocumentCodeType($documenttypecode));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setIssueDateTime", $this->getObjectHelper()->getDateTimeType($documentdate));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "addToLanguageID", $this->getObjectHelper()->getIdType($documentlanguage));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setEffectiveSpecifiedPeriod", $this->getObjectHelper()->getSpecifiedPeriodType(null, null, $effectiveSpecifiedPeriod, null));

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoiceCurrencyCode", $this->getObjectHelper()->getIdType($invoiceCurrency));

        return $this;
    }

    /**
     * Set general payment information
     *
     * @param  string|null $creditorReferenceID
     * Identifier of the creditor
     * @param  string|null $paymentReference
     * Intended use for payment
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentGeneralPaymentInformation(?string $creditorReferenceID = null, ?string $paymentReference = null): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setCreditorReferenceID", $this->getObjectHelper()->getIdType($creditorReferenceID));
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setPaymentReference", $this->getObjectHelper()->getIdType($paymentReference));
        return $this;
    }

    /**
     * Mark document as a copy from the original one
     *
     * @return ZugferdDocumentBuilder
     */
    public function setIsDocumentCopy(): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setCopyIndicator", $this->getObjectHelper()->getIndicatorType(true));
        return $this;
    }

    /**
     * Mark document as a test document
     *
     * @return ZugferdDocumentBuilder
     */
    public function setIsTestDocument(): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocumentContext(), "setTestIndicator", $this->getObjectHelper()->getIndicatorType(true));
        return $this;
    }

    /**
     * Document money summation
     *
     * @param  float      $grandTotalAmount     Total invoice amount including sales tax
     * @param  float      $duePayableAmount     Payment amount due
     * @param  float|null $lineTotalAmount      Sum of the net amounts of all invoice items
     * @param  float|null $chargeTotalAmount    Sum of the surcharges at document level
     * @param  float|null $allowanceTotalAmount Sum of the discounts at document level
     * @param  float|null $taxBasisTotalAmount  Total invoice amount excluding sales tax
     * @param  float|null $taxTotalAmount       Total amount of the invoice sales tax, Total tax amount in the booking currency
     * @param  float|null $roundingAmount       Rounding amount
     * @param  float|null $totalPrepaidAmount   Prepayment amount
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSummation(float $grandTotalAmount, float $duePayableAmount, ?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxBasisTotalAmount = null, ?float $taxTotalAmount = null, ?float $roundingAmount = null, ?float $totalPrepaidAmount = null): ZugferdDocumentBuilder
    {
        $summation = $this->getObjectHelper()->getTradeSettlementHeaderMonetarySummationType($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setSpecifiedTradeSettlementHeaderMonetarySummation", $summation);
        $taxTotalAmount = $this->getObjectHelper()->tryCallAndReturn($summation, "getTaxTotalAmount");
        $invoiceCurrencyCode = $this->getObjectHelper()->tryCallByPathAndReturn($this->headerTradeSettlement, "getInvoiceCurrencyCode.value");
        $this->getObjectHelper()->tryCall($this->getObjectHelper()->ensureArray($taxTotalAmount)[0], 'setCurrencyID', $invoiceCurrencyCode);
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
     * @param  string $foreignCurrencyCode Foreign currency code
     * @param  float  $foreignTaxAmount    Tax total amount in the foreign currency
     * @return ZugferdDocumentBuilder
     */
    public function setForeignCurrency(string $foreignCurrencyCode, float $foreignTaxAmount): ZugferdDocumentBuilder
    {
        $invoiceCurrencyCode = $this->getObjectHelper()->tryCallByPathAndReturn($this->headerTradeSettlement, "getInvoiceCurrencyCode.value");

        if (is_null($invoiceCurrencyCode)) {
            return $this;
        }

        $documentSummation = $this->getObjectHelper()->tryCallByPathAndReturn($this->headerTradeSettlement, "getSpecifiedTradeSettlementHeaderMonetarySummation");

        if (is_null($documentSummation)) {
            return $this;
        }

        $taxTotalAmounts = $this->getObjectHelper()->tryCallByPathAndReturn($documentSummation, "getTaxTotalAmount") ?? [];
        $taxTotalAmountInvoice = null;
        $taxTotalAmountForeign = null;

        foreach ($taxTotalAmounts as $taxTotalAmount) {
            if ($this->getObjectHelper()->tryCallAndReturn($taxTotalAmount, "getCurrencyID") == $invoiceCurrencyCode) {
                $taxTotalAmountInvoice = $taxTotalAmount;
            }
            if ($this->getObjectHelper()->tryCallAndReturn($taxTotalAmount, "getCurrencyID") == $foreignCurrencyCode) {
                $taxTotalAmountForeign = $taxTotalAmount;
            }
        }

        if (is_null($taxTotalAmountInvoice)) {
            return $this;
        }

        $invoiceTaxAmount = $this->getObjectHelper()->tryCallByPathAndReturn($taxTotalAmountInvoice, "value") ?? 0;

        if ($invoiceTaxAmount == 0) {
            return $this;
        }

        if (is_null($taxTotalAmountForeign)) {
            $taxTotalAmountForeign = $this->getObjectHelper()->getAmountType($foreignTaxAmount, $foreignCurrencyCode);
            $this->getObjectHelper()->tryCall($documentSummation, "addToTaxTotalAmount", $taxTotalAmountForeign);
        } else {
            $this->getObjectHelper()->tryCallByPath($taxTotalAmountForeign, "value", $foreignTaxAmount);
            $this->getObjectHelper()->tryCallByPath($taxTotalAmountForeign, "setCurrencyID", $foreignCurrencyCode);
        }

        $exchangeRate = round($foreignTaxAmount / $invoiceTaxAmount, 5);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setTaxCurrencyCode", $this->getObjectHelper()->getIdType($foreignCurrencyCode));
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setTaxApplicableTradeCurrencyExchange", $this->getObjectHelper()->getTaxApplicableTradeCurrencyExchangeType($invoiceCurrencyCode, $foreignCurrencyCode, $exchangeRate));
        return $this;
    }

    /**
     * Add a note to the docuzment
     *
     * @param  string      $content     Free text on the invoice
     * @param  string|null $contentCode Free text at document level
     * @param  string|null $subjectCode Code to qualify the free text for the invoice
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentNote(string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
    {
        $note = $this->getObjectHelper()->getNoteType($content, $contentCode, $subjectCode);
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "addToIncludedNote", $note);
        return $this;
    }

    /**
     * An identifier assigned by the buyer and used for internal routing.
     *
     * __Note__: The reference is specified by the buyer (e.g. contact details, department, office ID, project code),
     * but stated by the seller on the invoice.
     *
     * __Note__: The route ID must be specified in the Buyer Reference (BT-10) in the XRechnung. According to the XRechnung
     * standard, two syntaxes are permitted for displaying electronic invoices: Universal Business Language (UBL) and UN/CEFACT
     * Cross Industry Invoice (CII).
     *
     * @param  string $buyerreference
     * An identifier assigned by the buyer and used for internal routing
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerReference(string $buyerreference): ZugferdDocumentBuilder
    {
        $reference = $this->getObjectHelper()->getTextType($buyerreference);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setBuyerReference", $reference);
        return $this;
    }

    /**
     * Set the routing-id (needed for German XRechnung)
     * This is an alias-method for setDocumentBuyerReference
     *
     * __Note__: The route ID must be specified in the Buyer Reference (BT-10) in the XRechnung. According to the XRechnung
     * standard, two syntaxes are permitted for displaying electronic invoices: Universal Business Language (UBL) and UN/CEFACT
     * Cross Industry Invoice (CII).
     *
     * @param  string $routingId
     * The routing ID
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentRoutingId(string $routingId): ZugferdDocumentBuilder
    {
        return $this->setDocumentBuyerReference($routingId);
    }

    /**
     * Detailed information about the seller (=service provider)
     *
     * @param  string      $name
     * The full formal name under which the seller is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise
     * acting as person(s)
     * @param  string|null $id
     * An identifier of the seller. In many systems, seller identification
     * is key information. Multiple seller IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param  string|null $description
     * Further legal information that is relevant for the seller
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSeller(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSellerTradeParty", $sellerTradeParty);
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
     * @param  string|null $globalID
     * The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a
     * global registration organization.
     * @param  string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $this->getObjectHelper()->tryCall($sellerTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
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
     * @param  string|null $taxregtype Type of tax number of the seller
     * @param  string|null $taxregid   Tax number of the seller or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($sellerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets detailed information on the business address of the seller
     *
     * @param  string|null $lineone
     * The main line in the sellers address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the seller's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the seller's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the seller's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The sellers state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($sellerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set Organization details
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * seller as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer and seller
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the seller. If the identification scheme is used, it must be selected from
     * ISO/IEC 6523 list
     * @param  string|null $legalorgname
     * A name by which the seller is known, if different from the seller's name (also known as
     * the company name). Note: This may be used if different from the seller's name.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($sellerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set detailed information on the seller's contact person
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity,
     * such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the seller's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the seller's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the seller's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($sellerTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add additional detailed information on the seller's contact person. Only supported
     * in EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity,
     * such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the seller's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the seller's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the seller's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($sellerTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set Sellers electronic communication information
     *
     * @param  string|null $uriScheme
     * @param  string|null $uri
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerCommunication(?string $uriScheme, ?string $uri): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $communication = $this->getObjectHelper()->getUniversalCommunicationType(null, $uri, $uriScheme);
        $this->getObjectHelper()->tryCall($sellerTradeParty, "setURIUniversalCommunication", $communication);
        return $this;
    }

    /**
     * Detailed information about the buyer (service recipient)
     *
     * @param  string      $name
     * The full name of the buyer
     * @param  string|null $id
     * An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be
     * assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given,
     * it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param  string|null $description
     * Further legal information about the buyer
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setBuyerTradeParty", $buyerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the buyer
     *
     * @param  string|null $globalID
     * The buyers's identifier identification scheme is an identifier uniquely assigned to a buyer by a
     * global registration organization.
     * @param  string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $this->getObjectHelper()->tryCall($buyerTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
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
     * @param  string|null $taxregtype
     * Type of tax number of the buyers
     * @param  string|null $taxregid
     * Tax number of the buyers or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($buyerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets detailed information on the business address of the buyer
     *
     * @param  string|null $lineone
     * The main line in the buyers address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the buyers address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the buyers address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the buyers address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The buyers state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($buyerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the buyer party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * buyer as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer and buyer
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the buyer. If the identification scheme is used, it must be selected from
     * ISO/IEC 6523 list
     * @param  string|null $legalorgname
     * A name by which the buyer is known, if different from the buyers name
     * (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($buyerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the buyer party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the buyer's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the buyer's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the buyer's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($buyerTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add additional contact of the buyer party. This only supported in the
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the buyer's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the buyer's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the buyer's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($buyerTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set Buyers electronic communication information
     *
     * @param  string|null $uriScheme
     * @param  string|null $uri
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerCommunication(?string $uriScheme, ?string $uri): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $communication = $this->getObjectHelper()->getUniversalCommunicationType(null, $uri, $uriScheme);
        $this->getObjectHelper()->tryCall($buyerTradeParty, "setURIUniversalCommunication", $communication);
        return $this;
    }

    /**
     * Sets the sellers tax representative trade party
     *
     * @param  string      $name
     * The full name of the seller's tax agent
     * @param  string|null $id
     * An identifier of the sellers tax agent.
     * @param  string|null $description
     * Further legal information that is relevant for the sellers tax agent
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeTradeParty(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTaxRepresentativeTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Tax representative party
     *
     * @param  string|null $globalID
     * The seller's tax agent identifier identification scheme is an identifier uniquely assigned to a seller by a
     * global registration organization.
     * @param  string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to tax representative party
     *
     * @param  string|null $taxregtype
     * @param  string|null $taxregid
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the tax representative party
     *
     * @param  string|null $lineone
     * The main line in the sellers tax agent address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the sellers tax agent address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the sellers tax agent address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the sellers tax agent address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The sellers tax agent state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the tax representative party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the seller tax agent as
     * a legal entity or legal person.
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the sellers tax
     * agent. If the identification scheme is used, it must be selected from  ISO/IEC 6523 list
     * @param  string|null $legalorgname
     * A name by which the sellers tax agent is known, if different from the  sellers tax agent
     * name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the tax representative party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the seller's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the seller's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the seller's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($taxrepresentativeTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the tax representative party. This is only supported in
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the seller's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the seller's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the seller's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the product end user (general information)
     *
     * @param  string      $name
     * The full formal name under which the product end user is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param  string|null $id
     * An identifier of the product end user. In many systems, product end user identification
     * is key information. Multiple product end user IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to all trade
     * parties, e.g. a previously exchanged
     * @param  string|null $description
     * Further legal information that is relevant for the product end user
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUser(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setProductEndUserTradeParty", $productEndUserTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Product Enduser Trade Party
     *
     * @param  string|null $globalID
     * The identifier is uniquely assigned to a party by a global registration organization.
     * @param  string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
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
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Product Enduser party
     *
     * @param  string|null $lineone
     * The main line in the product end users address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the product end users address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The product end users state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Product Enduser party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * product end user as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to all trade parties
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the product end user. If the identification scheme is used, it must be selected from
     * ISO/IEC 6523 list
     * @param  string|null $legalorgname
     * A name by which the product end user is known, if different from the product
     * end users name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Product Enduser party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the product end user's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the product end user's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the product end user's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($productEndUserTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the Product Enduser party. This is only supported in
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the product end user's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the product end user's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the product end user's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Ship-To
     *
     * @param  string      $name
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  string|null $id
     * An identifier for the place where the goods are delivered or where the services are provided.
     * Multiple IDs can be assigned or specified. They can be differentiated by using different
     * identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param  string|null $globalID
     * Global identifier of the goods recipient
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype The identifier for the identification scheme of the legal
     *                                   registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     *                                   0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname A name by which the party is known, if different from the party's name
     *                                   (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Ship-To party. All formerly assigned contacts will be
     * overwritten
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($shipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add a contact to the Ship-To party. This is actually only possible in
     * the EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string      $name
     * Name or company name of the different end recipient
     * @param  string|null $id
     * Identification of the different end recipient. Multiple IDs can be assigned or specified. They can be
     * differentiated by using different identification schemes.
     * @param  string|null $description
     * Further legal information that is relevant for the different end recipient
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $globalID
     * Global identifier of the goods recipient
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box. For major customer addresses, this field must be filled with "-".
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the different end recipient
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the different end recipient
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($UltimateShipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the different end recipient. This is only supported in the
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set detailed information of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string      $name
     * The name of the party
     * @param  string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFrom(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setShipFromTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $globalID
     * Global identifier of the goods recipient
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $this->getObjectHelper()->tryCall($shipFromTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($shipFromTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($shipFromTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($shipFromTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the deviating consignor party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($shipFromTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the deviating consignor party. This is only supported in the
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($shipFromTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Invoicer (Rechnungssteller)
     *
     * @param  string      $name
     * The name of the party
     * @param  string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoicerTradeParty", $invoicerTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Invoicer Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $globalID
     * Global identifier of the goods recipient
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Invoicer Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($invoicerTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,* 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($invoicerTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($invoicerTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the ultimate Ship-from party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set detailed information on the different invoice recipient,
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string      $name
     * The name of the party
     * @param  string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoiceeTradeParty", $invoiceeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Invoicee Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $globalID
     * Global identification number
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Invoicer Trade Party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the ultimate Ship-from party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($invoiceeTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the ultimate Ship-from party. This is only supported in the
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set detailed information about the payee, i.e. about the place that receives the payment.
     * The role of the payee may also be performed by a party other than the seller, e.g. by a factoring service.
     *
     * @param  string      $name
     * The name of the party. Must be used if the payee is not the same as the seller. However, the name of the
     * payee may match the name of the seller.
     * @param  string|null $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setPayeeTradeParty", $payeeTradeParty);
        return $this;
    }

    /**
     * Add a global id for the payee trade party
     *
     * @param  string|null $globalID
     * Global identification number
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $this->getObjectHelper()->tryCall($payeeTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to payee trade party
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($payeeTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the payee trade party
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($payeeTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the payee trade party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal registration of the party. In particular,
     * the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($payeeTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the payee trade party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($payeeTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the payee trade party. Note this is only supported in the
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($payeeTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Set information on the delivery conditions
     *
     * __Note__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $code
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDeliveryTerms(?string $code): ZugferdDocumentBuilder
    {
        $deliveryterms = $this->getObjectHelper()->getTradeDeliveryTermsType($code);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setApplicableTradeDeliveryTerms", $deliveryterms);
        return $this;
    }

    /**
     * Set details of the associated order confirmation
     *
     * @param  string        $issuerassignedid
     * An identifier issued by the seller for a referenced sales order (Order confirmation number)
     * @param  DateTime|null $issueddate
     * Order confirmation date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerOrderReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $sellerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSellerOrderReferencedDocument", $sellerorderrefdoc);
        return $this;
    }

    /**
     * Set details of the related buyer order
     *
     * @param  string        $issuerassignedid
     * An identifier issued by the buyer for a referenced order (order number)
     * @param  DateTime|null $issueddate
     * Date of order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerOrderReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
        return $this;
    }

    /**
     * Set details of the associated contract
     *
     * @param  string        $issuerassignedid
     * The contract reference should be assigned once in the context of the specific trade relationship and for a
     * defined period of time (contract number)
     * @param  DateTime|null $issueddate
     * Contract date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentContractReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setContractReferencedDocument", $contractrefdoc);
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
     * @param  string            $issuerassignedid
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string            $typecode
     * Type of referenced document (See codelist UNTDID 1001)
     *  - Code 916 "reference paper" is used to reference the identification of the document on which the invoice is based
     *  - Code 50 "Price / sales catalog response" is used to reference the tender or the lot
     *  - Code 130 "invoice data sheet" is used to reference an identifier for an object specified by the seller.
     * @param  string|null       $uriid
     * The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource
     * including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document
     * must be used if the buyer needs additional information to support the amounts billed. External documents are not part
     * of the invoice. Access to external documents can involve certain risks.
     * @param  string|array|null $name
     * A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null       $reftypecode
     * The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the
     * recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected
     * from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTime|null     $issueddate
     * Document date
     * @param  string|null       $binarydatafilename
     * Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentAdditionalReferencedDocument(string $issuerassignedid, string $typecode, ?string $uriid = null, $name = null, ?string $reftypecode = null, ?DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, $uriid, null, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "addToAdditionalReferencedDocument", $additionalrefdoc);
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
     * @param  string        $issuerassignedid
     * Number of the previous invoice
     * @param  DateTime|null $issueddate
     * Date of the previous invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $invoicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoiceReferencedDocument", $invoicerefdoc);
        return $this;
    }

    /**
     * Set Details of a project reference
     *
     * @param  string $id
     * Project Data
     * @param  string $name
     * Project Name
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProcuringProject(string $id, string $name): ZugferdDocumentBuilder
    {
        $procuringproject = $this->getObjectHelper()->getProcuringProjectType($id, $name);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSpecifiedProcuringProject", $procuringproject);
        return $this;
    }

    /**
     * Add a reference of the ultimate customer order
     *
     * @param  string        $issuerassignedid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateCustomerOrderReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "addToUltimateCustomerOrderReferencedDocument", $additionalrefdoc);
        return $this;
    }

    /**
     * Set detailed information on the actual delivery
     *
     * @param  DateTime|null $date
     * Actual delivery time
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSupplyChainEvent(?DateTime $date): ZugferdDocumentBuilder
    {
        $supplyChainevent = $this->getObjectHelper()->getSupplyChainEventType($date);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);
        return $this;
    }

    /**
     * Set detailed information on the associated shipping notification
     *
     * @param  string        $issuerassignedid
     * Shipping notification reference
     * @param  DateTime|null $issueddate
     * Shipping notification date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDespatchAdviceReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $despatchddvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Set detailed information on the associated goods receipt notification
     *
     * @param  string        $issuerassignedid
     * An identifier for a referenced goods receipt notification (Goods receipt number)
     * @param  DateTime|null $issueddate
     * Goods receipt date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentReceivingAdviceReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $receivingadvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Set detailed information on the associated delivery note
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string        $issuerassignedid
     * Delivery receipt number
     * @param  DateTime|null $issueddate
     * Delivery receipt date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDeliveryNoteReferencedDocument(string $issuerassignedid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $deliverynoterefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, null, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
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
     * @param  string      $typecode
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
     * @param  string|null $information
     * The expected or used means of payment expressed in text form, e.g. cash, bank transfer, direct debit,
     * credit card, etc.
     * @param  string|null $cardType
     * The type of the card
     * @param  string|null $cardId
     * The primary account number (PAN) to which the card used for payment belongs. In accordance with card
     * payment security standards, an invoice should never contain a full payment card master account number.
     * The following specification of the PCI Security Standards Council currently applies: The first 6 and
     * last 4 digits at most are to be displayed
     * @param  string|null $cardHolderName
     * Name of the payment card holder
     * @param  string|null $buyerIban
     * Direct debit: ID of the account to be debited
     * @param  string|null $payeeIban
     * Transfer: A unique identifier for the financial account held with a payment service provider to which
     * the payment should be made, e.g. Use an IBAN (in the case of a SEPA payment) for a national ProprietaryID
     * account number
     * @param  string|null $payeeAccountName
     * The name of the payment account held with a payment service provider to which the payment should be made.
     * Information only required if different from the name of the payee / seller
     * @param  string|null $payeePropId
     * National account number (not for SEPA)
     * @param  string|null $payeeBic
     * Seller's banking institution, An identifier for the payment service provider with whom the payment account
     * is managed, such as the BIC or a national bank code, if required. No identification scheme is to be used.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMean(string $typecode, ?string $information = null, ?string $cardType = null, ?string $cardId = null, ?string $cardHolderName = null, ?string $buyerIban = null, ?string $payeeIban = null, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null): ZugferdDocumentBuilder
    {
        $cardId = substr($cardId ?? "", -4);

        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType($typecode, $information);
        $financialCard = $this->getObjectHelper()->getTradeSettlementFinancialCardType($cardType, $cardId, $cardHolderName);
        $buyerfinancialaccount = $this->getObjectHelper()->getDebtorFinancialAccountType($buyerIban);
        $payeefinancialaccount = $this->getObjectHelper()->getCreditorFinancialAccountType($payeeIban, $payeeAccountName, $payeePropId);
        $payeefinancialInstitution = $this->getObjectHelper()->getCreditorFinancialInstitutionType($payeeBic);

        $this->getObjectHelper()->tryCall($paymentMeans, "setApplicableTradeSettlementFinancialCard", $financialCard);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayerPartyDebtorFinancialAccount", $buyerfinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeePartyCreditorFinancialAccount", $payeefinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeeSpecifiedCreditorFinancialInstitution", $payeefinancialInstitution);

        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradeSettlementPaymentMeans", "setSpecifiedTradeSettlementPaymentMeans"], $paymentMeans);

        return $this;
    }

    /**
     * Sets the document payment means to _SEPA Credit Transfer_
     * German translation: _Überweisung_
     *
     * @param  string      $payeeIban
     * Transfer: A unique identifier for the financial account held with a payment service provider to which
     * the payment should be made, e.g. Use an IBAN (in the case of a SEPA payment) for a national ProprietaryID
     * account number
     * @param  string|null $payeeAccountName
     * The name of the payment account held with a payment service provider to which the payment should be made.
     * Information only required if different from the name of the payee / seller
     * @param  string|null $payeePropId
     * National account number (not for SEPA)
     * @param  string|null $payeeBic
     * Seller's banking institution, An identifier for the payment service provider with whom the payment account
     * is managed, such as the BIC or a national bank code, if required. No identification scheme is to be used.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToCreditTransfer(string $payeeIban, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType("58");
        $payeefinancialaccount = $this->getObjectHelper()->getCreditorFinancialAccountType($payeeIban, $payeeAccountName, $payeePropId);
        $payeefinancialInstitution = $this->getObjectHelper()->getCreditorFinancialInstitutionType($payeeBic);

        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeePartyCreditorFinancialAccount", $payeefinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeeSpecifiedCreditorFinancialInstitution", $payeefinancialInstitution);

        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradeSettlementPaymentMeans", "setSpecifiedTradeSettlementPaymentMeans"], $paymentMeans);

        return $this;
    }

    /**
     * Sets the document payment means to _SEPA Direct Debit_
     *
     * @param  string $buyerIban
     * Direct debit: ID of the account to be debited
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToDirectDebit(string $buyerIban): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType("59");
        $buyerfinancialaccount = $this->getObjectHelper()->getDebtorFinancialAccountType($buyerIban);

        $this->getObjectHelper()->tryCall($paymentMeans, "setPayerPartyDebtorFinancialAccount", $buyerfinancialaccount);

        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradeSettlementPaymentMeans", "setSpecifiedTradeSettlementPaymentMeans"], $paymentMeans);

        return $this;
    }

    /**
     * Sets the document payment means to _Payment card_
     *
     * @param  string      $cardType
     * The type of the card, such as VISA, American Express, Master Card.
     * @param  string      $cardId
     * The primary account number (PAN) to which the card used for payment belongs. In accordance with card
     * payment security standards, an invoice should never contain a full payment card master account number.
     * The following specification of the PCI Security Standards Council currently applies: The first 6 and
     * last 4 digits at most are to be displayed
     * @param  string|null $cardHolderName
     * Name of the payment card holder
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToPaymentCard(string $cardType, string $cardId, ?string $cardHolderName = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType("48");
        $financialCard = $this->getObjectHelper()->getTradeSettlementFinancialCardType($cardType, $cardId, $cardHolderName);

        $this->getObjectHelper()->tryCall($paymentMeans, "setApplicableTradeSettlementFinancialCard", $financialCard);

        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradeSettlementPaymentMeans", "setSpecifiedTradeSettlementPaymentMeans"], $paymentMeans);

        return $this;
    }

    /**
     * Add a VAT breakdown (at document level)
     *
     * @param  string        $categoryCode
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
     * @param  string        $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float         $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float         $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param  float|null    $rateApplicablePercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @param  string|null   $exemptionReason
     * Reason for tax exemption (free text)
     * @param  string|null   $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @param  float|null    $lineTotalBasisAmount
     * Tax rate goods amount
     * @param  float|null    $allowanceChargeBasisAmount
     * Total amount of surcharges and deductions of the tax rate at document level
     * @param  DateTime|null $taxPointDate
     * Specification of a date, in accordance with the sales tax guideline, on which the sales tax
     * for the seller and for the buyer becomes relevant for accounting, insofar as this date can be
     * determined and differs from the invoice date
     * Note: The tax collection date for VAT purposes is usually the date the goods were delivered or
     * the service was completed (the base tax date). There are a few variations. For further information,
     * please refer to Article 226 (7) of Council Directive 2006/112 / EC. This element is required
     * if the date set for the sales tax return differs from the invoice date. Both the buyer and the
     * seller should use the delivery date for VAT returns, if provided by the seller.
     * This is not used in Germany. Instead, the delivery and service date must be specified.
     * @param  string|null   $dueDateTypeCode
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
        $tax = $this->getObjectHelper()->getTradeTaxType($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToApplicableTradeTax", $tax);
        return $this;
    }

    /**
     * Add a VAT breakdown (at document level) in a more simple way
     *
     * @param  string     $categoryCode
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
     * @param  string     $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float      $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float      $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param  float|null $rateApplicablePercent
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
     * @param  DateTime|null $startdate
     * Start of the billing period
     * @param  DateTime|null $endDate
     * End of the billing period
     * @param  string|null   $description
     * Further information of the billing period
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBillingPeriod(?DateTime $startdate, ?DateTime $endDate, ?string $description): ZugferdDocumentBuilder
    {
        $period = $this->getObjectHelper()->getSpecifiedPeriodType($startdate, $endDate, null, $description);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setBillingSpecifiedPeriod", $period);
        return $this;
    }

    /**
     * Add information about surcharges and charges applicable to the bill as a whole, Deductions,
     * such as for withheld taxes may also be specified in this group
     *
     * @param  float       $actualAmount
     * Amount of the surcharge or discount at document level
     * @param  boolean     $isCharge
     * Switch that indicates whether the following data refer to an surcharge or a discount, true means that
     * this an charge
     * @param  string      $taxCategoryCode
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
     * @param  string      $taxTypeCode
     * Code for the VAT category of the surcharge or charge at document level. Note: Fixed value = "VAT"
     * @param  float       $rateApplicablePercent
     * VAT rate for the surcharge or discount on document level. Note: The code of the sales tax category
     * and the category-specific sales tax rate must correspond to one another. The value to be given is
     * the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null  $sequence
     * Calculation order
     * @param  float|null  $calculationPercent
     * Percentage surcharge or discount at document level
     * @param  float|null  $basisAmount
     * The base amount that may be used in conjunction with the percentage of the surcharge or discount
     * at document level to calculate the amount of the discount at document level
     * @param  float|null  $basisQuantity
     * Basismenge des Rabatts
     * @param  string|null $basisQuantityUnitCode
     * Einheit der Preisbasismenge
     *  - Codeliste: Rec. N°20 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     *  - Codeliste: Rec. N°21 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     * @param  string|null $reasonCode
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
     * @param  string|null $reason
     * The reason given in text form for the surcharge or discount at document level
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentAllowanceCharge(float $actualAmount, bool $isCharge, string $taxCategoryCode, string $taxTypeCode, float $rateApplicablePercent, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ZugferdDocumentBuilder
    {
        $allowanceCharge = $this->getObjectHelper()->getTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);
        return $this;
    }

    /**
     * Add a logistical service fees (On document level)
     *
     * @param  string     $description
     * Identification of the service fee
     * @param  float      $appliedAmount
     * Amount of the service fee
     * @param  array|null $taxTypeCodes
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  array|null $taxCategpryCodes
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
     * @param  array|null $rateApplicablePercents
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentLogisticsServiceCharge(string $description, float $appliedAmount, ?array $taxTypeCodes = null, ?array $taxCategpryCodes = null, ?array $rateApplicablePercents = null): ZugferdDocumentBuilder
    {
        $logcharge = $this->getObjectHelper()->getLogisticsServiceChargeType($description, $appliedAmount, $taxTypeCodes, $taxCategpryCodes, $rateApplicablePercents);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedLogisticsServiceCharge", $logcharge);
        return $this;
    }

    /**
     * Add a payment term
     *
     * @param  string|null   $description
     * A text description of the payment terms that apply to the payment amount due (including a
     * description of possible penalties). Note: This element can contain multiple lines and
     * multiple conditions.
     * @param  DateTime|null $dueDate
     * The date by which payment is due Note: The payment due date reflects the net payment due
     * date. In the case of partial payments, this indicates the first due date of a net payment.
     * The corresponding description of more complex payment terms can be given in BT-20.
     * @param  string|null   $directDebitMandateID
     * Unique identifier assigned by the payee to reference the direct debit authorization.
     * __Note:__ Used to inform the buyer in advance about a SEPA direct debit. __Synonym:__ mandate reference for SEPA
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentTerm(?string $description = null, ?DateTime $dueDate = null, ?string $directDebitMandateID = null): ZugferdDocumentBuilder
    {
        $paymentTerms = $this->getObjectHelper()->getTradePaymentTermsType($description, $dueDate, $directDebitMandateID);
        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradePaymentTerms", "setSpecifiedTradePaymentTerms"], $paymentTerms);
        $this->currentPaymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * Add discount Terms to last added payment term
     *
     * @param  float|null    $calculationPercent
     * Percentage of the down payment
     * @param  DateTime|null $basisDateTime
     * Due date reference date
     * @param  float|null    $basisPeriodMeasureValue
     * Due period
     * @param  string|null   $basisPeriodMeasureUnitCode
     * Due period, unit
     * @param  float|null    $basisAmount
     * Base amount of the down payment
     * @param  float|null    $actualDiscountAmount
     * Amount of the down payment
     * @return ZugferdDocumentBuilder
     */
    public function addDiscountTermsToPaymentTerms(?float $calculationPercent = null, ?DateTime $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $actualDiscountAmount = null): ZugferdDocumentBuilder
    {
        $discountTerms = $this->getObjectHelper()->getTradePaymentDiscountTermsType($basisDateTime, $basisPeriodMeasureValue, $basisPeriodMeasureUnitCode, $basisAmount, $calculationPercent, $actualDiscountAmount);
        $this->getObjectHelper()->tryCall($this->currentPaymentTerms, "setApplicableTradePaymentDiscountTerms", $discountTerms);
        return $this;
    }

    /**
     * Add an AccountingAccount
     * Detailinformationen zur Buchungsreferenz
     *
     * @param  string      $id
     * @param  string|null $typeCode
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode): ZugferdDocumentBuilder
    {
        $account = $this->getObjectHelper()->getTradeAccountingAccountType($id, $typeCode);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToReceivableSpecifiedTradeAccountingAccount", $account);
        return $this;
    }

    /**
     * Adds a new position (line) to document
     *
     * @param  string      $lineid
     * A unique identifier for the relevant item within the invoice (item number)
     * @param  string|null $lineStatusCode
     * Indicates whether the invoice item contains prices that must be taken into account when
     * calculating the invoice amount, or whether it only contains information.
     * The following code should be used: TYPE_LINE
     * @param  string|null $lineStatusReasonCode
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
        $position = $this->getObjectHelper()->getSupplyChainTradeLineItemType($lineid, $lineStatusCode, $lineStatusReasonCode);
        $this->getObjectHelper()->tryCall($this->headerSupplyChainTradeTransaction, "addToIncludedSupplyChainTradeLineItem", $position);
        $this->currentPosition = $position;
        return $this;
    }

    /**
     * Adds a new text-only position (line) to document
     *
     * @param  string      $lineid
     * A unique identifier for the relevant item within the invoice (item number)
     * @param  string|null $lineStatusCode
     * Indicates whether the invoice item contains prices that must be taken into account when
     * calculating the invoice amount, or whether it only contains information.
     * The following code should be used: TYPE_LINE
     * @param  string|null $lineStatusReasonCode
     * Adds the type to specify whether the invoice line is:
     *  - detail (normal position)
     *  - Subtotal
     *  - Information only
     * If the $lineStatusCode field is used, the LineStatusReasonCode field must use the following codes:
     *  - detail
     *  - grouping
     *  - information
     * @return ZugferdDocumentBuilder
     */
    public function addNewTextPosition(string $lineid, ?string $lineStatusCode = null, ?string $lineStatusReasonCode = null): ZugferdDocumentBuilder
    {
        $position = $this->getObjectHelper()->getSupplyChainTradeLineItemType($lineid, $lineStatusCode, $lineStatusReasonCode, true);
        $this->getObjectHelper()->tryCall($this->headerSupplyChainTradeTransaction, "addToIncludedSupplyChainTradeLineItem", $position);
        $this->currentPosition = $position;
        return $this;
    }

    /**
     * Add detailed information on the free text on the position
     *
     * @param  string      $content
     * A free text that contains unstructured information that is relevant to the invoice item
     * @param  string|null $contentCode
     * Text modules agreed bilaterally, which are transmitted here as code.
     * @param  string|null $subjectCode
     * Free text for the position (code for the type)
     * __Codelist:__ UNTDID 4451
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNote(string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
    {
        $linedoc = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getAssociatedDocumentLineDocument");
        $note = $this->getObjectHelper()->getNoteType($content, $contentCode, $subjectCode);
        $this->getObjectHelper()->tryCallAll($linedoc, ["addToIncludedNote", "setIncludedNote"], $note);
        return $this;
    }

    /**
     * Adds product details to the last created position (line) in the document
     *
     * @param  string      $name
     * A name of the item (item name)
     * @param  string|null $description
     * A description of the item, the item description makes it possible to describe the item and its
     * properties in more detail than is possible with the item name.
     * @param  string|null $sellerAssignedID
     * An identifier assigned to the item by the seller
     * @param  string|null $buyerAssignedID
     * An identifier assigned to the item by the buyer. The article number of the buyer is a clear,
     * bilaterally agreed identification of the product. It can, for example, be the customer article
     * number or the article number assigned by the manufacturer.
     * @param  string|null $globalIDType
     * The scheme for $globalID
     * @param  string|null $globalID
     * Identification of an article according to the registered scheme (Global identifier of the product,
     * GTIN, ...)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionProductDetails(string $name, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->getTradeProductType($name, $description, $sellerAssignedID, $buyerAssignedID, $globalIDType, $globalID);
        $this->getObjectHelper()->tryCall($this->currentPosition, "setSpecifiedTradeProduct", $product);
        return $this;
    }

    /**
     * Add extra characteristics to the formerly added product.
     * Contains information about the characteristics of the goods and services invoiced
     *
     * @param  string      $description
     * The name of the attribute or property of the product such as "Colour"
     * @param  string      $value
     * The value of the attribute or property of the product such as "Red"
     * @param  string|null $typecode
     * Type of product property (code). The codes must be taken from the
     * UNTDID 6313 codelist. Available only in the Extended-Profile
     * @param  float|null  $valueMeasure
     * Value of the product property (numerical measurand)
     * @param  string|null $valueMeasureUnitCode
     * Unit of measurement of the measurand
     *  - Codeliste: Rec. N°20 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     *  - Codeliste: Rec. N°21 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionProductCharacteristic(string $description, string $value, ?string $typecode = null, ?float $valueMeasure = null, ?string $valueMeasureUnitCode = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $productCharacteristic = $this->getObjectHelper()->getProductCharacteristicType($typecode, $description, $valueMeasure, $valueMeasureUnitCode, $value);
        $this->getObjectHelper()->tryCall($product, "addToApplicableProductCharacteristic", $productCharacteristic);
        return $this;
    }

    /**
     * Add detailed information on product classification
     *
     * @param  string      $classCode
     * A code for classifying the item by type or nature or essence or condition.
     * __Note__: Classification codes are used to group similar items for different purposes, such as public
     * procurement (using the Common Procurement Vocabulary [CPV]), e-commerce (UNSPSC), etc.
     * @param  string|null $className
     * Classification name
     * @param  string|null $listID
     * The identifier for the identification scheme of the identifier of the article classification
     * __Note__: The identification scheme must be selected from the entries from UNTDID 7143.
     * @param  string|null $listVersionID
     * The version of the identification scheme
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionProductClassification(string $classCode, ?string $className = null, ?string $listID = null, ?string $listVersionID = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $productClassification = $this->getObjectHelper()->getProductClassificationType($classCode, $className, $listID, $listVersionID);
        $this->getObjectHelper()->tryCall($product, "addToDesignatedProductClassification", $productClassification);
        return $this;
    }

    /**
     * Sets the detailed information on the product origin
     *
     * @param  string $country
     * The code indicating the country the goods came from
     * __Note__: The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance
     * Agency “Codes for the representation of names of countries and their subdivisions”.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionProductOriginTradeCountry(string $country): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $productTradeCounty = $this->getObjectHelper()->getTradeCountryType($country);
        $this->getObjectHelper()->tryCall($product, "setOriginTradeCountry", $productTradeCounty);
        return $this;
    }

    /**
     * Add detailed information on included products. This information relates to the
     * product that has just been added
     *
     * @param  string      $name
     * Item name
     * @param  string|null $description
     * Item description
     * @param  string|null $sellerAssignedID
     * Item number of the seller
     * @param  string|null $buyerAssignedID
     * Item number of the buyer
     * __Note__: The identifier of the product is a unique, bilaterally agreed identification of the
     * product. It can, for example, be the customer article number or the article number assigned by
     * the manufacturer.
     * @param  string|null $globalID
     * Global identifier of the product
     * __Note__: The global identifier of the product is a label uniquely assigned by the manufacturer,
     * which is based on the rules of a global registration organization.
     * @param  string|null $globalIDType
     * Type of global item number
     * In particular, the following codes can be used:
     *  * 0021: SWIFT
     *  * 0088: EAN
     *  * 0060: DUNS
     *  * 0177: ODETTE
     * @param  float|null  $unitQuantity
     * Included quantity
     * @param  string|null $unitCode
     * Unit of measurement of the included quantity
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionReferencedProduct(string $name, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalID = null, ?string $globalIDType = null, ?float $unitQuantity = null, ?string $unitCode = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $referencedProduct = $this->getObjectHelper()->getReferencedProductType($globalID, $globalIDType, $sellerAssignedID, $buyerAssignedID, $name, $description, $unitQuantity, $unitCode);
        $this->getObjectHelper()->tryCall($product, "addToIncludedReferencedProduct", $referencedProduct);
        return $this;
    }

    /**
     * Set details of the related buyer order position
     *
     * @param  string        $issuerassignedid
     * An identifier issued by the buyer for a referenced order (order number)
     * @param  string        $lineid
     * An identifier for a position within an order placed by the buyer. Note: Reference is made to the order
     * reference at the document level.
     * @param  DateTime|null $issueddate
     * Date of order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionBuyerOrderReferencedDocument(string $issuerassignedid, string $lineid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->getObjectHelper()->tryCall($positionagreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);
        return $this;
    }

    /**
     * Set details of the related contract position
     *
     * @param  string        $issuerassignedid
     * The contract reference should be assigned once in the context of the specific trade relationship and for a
     * defined period of time (contract number)
     * @param  string        $lineid
     * Identifier of the according contract position
     * @param  DateTime|null $issueddate
     * Contract date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionContractReferencedDocument(string $issuerassignedid, string $lineid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->getObjectHelper()->tryCall($positionagreement, "setContractReferencedDocument", $contractrefdoc);
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
     * @param  string        $issuerassignedid
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string        $typecode
     * Type of referenced document (See codelist UNTDID 1001)
     *  - Code 916 "reference paper" is used to reference the identification of the document on which the invoice is based
     *  - Code 50 "Price / sales catalog response" is used to reference the tender or the lot
     *  - Code 130 "invoice data sheet" is used to reference an identifier for an object specified by the seller.
     * @param  string|null   $uriid
     * The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource
     * including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document
     * must be used if the buyer needs additional information to support the amounts billed. External documents are not part
     * of the invoice. Access to external documents can involve certain risks.
     * @param  string|null   $lineid
     * The referenced position identifier in the additional document
     * @param  string|null   $name
     * A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null   $reftypecode
     * The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the
     * recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected
     * from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTime|null $issueddate
     * Document date
     * @param  string|null   $binarydatafilename
     * Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionAdditionalReferencedDocument(string $issuerassignedid, string $typecode, ?string $uriid = null, ?string $lineid = null, ?string $name = null, ?string $reftypecode = null, ?DateTime $issueddate = null, ?string $binarydatafilename = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, $uriid, $lineid, $typecode, $name, $reftypecode, $issueddate, $binarydatafilename);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->getObjectHelper()->tryCall($positionagreement, "addToAdditionalReferencedDocument", $contractrefdoc);
        return $this;
    }

    /**
     * Add a referennce to a ultimate customer order referenced document
     *
     * @param  string        $issuerassignedid
     * @param  string        $lineid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateCustomerOrderReferencedDocument(string $issuerassignedid, string $lineid, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $ultimaterefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->getObjectHelper()->tryCall($positionagreement, "addToUltimateCustomerOrderReferencedDocument", $ultimaterefdoc);
        return $this;
    }

    /**
     * Set the unit price excluding sales tax before deduction of the discount on the item price.
     *
     * @param  float       $amount
     * The unit price excluding sales tax before deduction of the discount on the item price.
     * Note: If the price is shown according to the net calculation, the price must also be shown
     * according to the gross calculation.
     * @param  float|null  $basisQuantity
     * The number of item units for which the price applies (price base quantity)
     * @param  string|null $basisQuantityUnitCode
     * The unit code of the number of item units for which the price applies (price base quantity)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionGrossPrice(float $amount, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $grossPrice = $this->getObjectHelper()->getTradePriceType($amount, $basisQuantity, $basisQuantityUnitCode);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->getObjectHelper()->tryCall($positionagreement, "setGrossPriceProductTradePrice", $grossPrice);
        return $this;
    }

    /**
     * Detailed information on surcharges and discounts on item gross price
     *
     * @param  float       $actualAmount
     * Discount on the item price. The total discount subtracted from the gross price to calculate the
     * net price. Note: Only applies if the discount is given per unit and is not included in the gross price.
     * @param  boolean     $isCharge
     * Switch for surcharge/discount, if true then its an charge
     * @param  float|null  $calculationPercent
     * Discount/surcharge in percent. Up to level EN16931, only the final result of the discount (ActualAmount)
     * is transferred
     * @param  float|null  $basisAmount
     * Base amount of the discount/surcharge
     * @param  string|null $reason
     * Reason for surcharge/discount (free text)
     * @param  string|null $taxTypeCode
     * @param  string|null $taxCategoryCode
     * @param  float|null  $rateApplicablePercent
     * @param  float|null  $sequence
     * @param  float|null  $basisQuantity
     * @param  string|null $basisQuantityUnitCode
     * @param  string|null $reasonCode
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionGrossPriceAllowanceCharge(float $actualAmount, bool $isCharge, ?float $calculationPercent = null, ?float $basisAmount = null, ?string $reason = null, ?string $taxTypeCode = null, ?string $taxCategoryCode = null, ?float $rateApplicablePercent = null, ?float $sequence = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null): ZugferdDocumentBuilder
    {
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $grossPrice = $this->getObjectHelper()->tryCallAndReturn($positionagreement, "getGrossPriceProductTradePrice");
        $allowanceCharge = $this->getObjectHelper()->getTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);
        $this->getObjectHelper()->tryCallAll($grossPrice, ["addToAppliedTradeAllowanceCharge", "setAppliedTradeAllowanceCharge"], $allowanceCharge);
        return $this;
    }

    /**
     * Set detailed information on the net price of the item
     *
     * @param  float       $amount
     * Net price of the item
     * @param  float|null  $basisQuantity
     * Base quantity at the item price
     * @param  string|null $basisQuantityUnitCode
     * Code of the unit of measurement of the base quantity at the item price
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNetPrice(float $amount, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $netPrice = $this->getObjectHelper()->getTradePriceType($amount, $basisQuantity, $basisQuantityUnitCode);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $this->getObjectHelper()->tryCall($positionagreement, "setNetPriceProductTradePrice", $netPrice);
        return $this;
    }

    /**
     * Tax included for B2C on position level
     *
     * @param  string      $categoryCode
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
     * @param  string      $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float       $rateApplicablePercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @param  float       $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param  string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @param  string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNetPriceTax(string $categoryCode, string $typeCode, float $rateApplicablePercent, float $calculatedAmount, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");
        $netPrice = $this->getObjectHelper()->tryCallAndReturn($positionagreement, "getNetPriceProductTradePrice");
        $tax = $this->getObjectHelper()->getTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);
        $this->getObjectHelper()->tryCall($netPrice, "setIncludedTradeTax", $tax);
        return $this;
    }

    /**
     * Set the position Quantity
     *
     * @param  float       $billedQuantity
     * The quantity of individual items (goods or services) billed in the relevant line
     * @param  string      $billedQuantityUnitCode
     * The unit of measure applicable to the amount billed. Note: The unit of measurement must be taken from the
     * lists from UN / ECE Recommendation No. 20 "Codes for Units of Measure Used in International Trade" and
     * UN / ECE Recommendation No. 21 "Codes for Passengers, Types of Cargo, Packages and Packaging Materials
     * (with Complementary Codes for Package Names)" using the UN / ECE Rec No. 20 Intro 2.a) can be selected.
     * It should be noted that in most cases it is not necessary for buyers and sellers to fully implement these
     * lists in their software. Sellers only need to support the entities necessary for their goods and services;
     * Buyers only need to verify that the units used in the invoice match those in other documents (such as in
     * Contracts, catalogs, orders and shipping notifications) match the units used.
     * @param  float|null  $chargeFreeQuantity
     * Quantity, free of charge
     * @param  string|null $chargeFreeQuantityUnitCpde
     * Unit of measure code for the quantity free of charge
     * @param  float|null  $packageQuantity
     * Number of packages
     * @param  string|null $packageQuantityUnitCode
     * Unit of measure code for number of packages
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionQuantity(float $billedQuantity, string $billedQuantityUnitCode, ?float $chargeFreeQuantity = null, ?string $chargeFreeQuantityUnitCpde = null, ?float $packageQuantity = null, ?string $packageQuantityUnitCode = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $this->getObjectHelper()->tryCall($positiondelivery, "setBilledQuantity", $this->getObjectHelper()->getQuantityType($billedQuantity, $billedQuantityUnitCode));
        $this->getObjectHelper()->tryCall($positiondelivery, "setChargeFreeQuantity", $this->getObjectHelper()->getQuantityType($chargeFreeQuantity, $chargeFreeQuantityUnitCpde));
        $this->getObjectHelper()->tryCall($positiondelivery, "setPackageQuantity", $this->getObjectHelper()->getQuantityType($packageQuantity, $packageQuantityUnitCode));
        return $this;
    }

    /**
     * Set detailed information on the different ship-to party at item level
     *
     * @param  string      $name
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  string|null $id
     * An identifier for the place where the goods are delivered or where the services are provided.
     * Multiple IDs can be assigned or specified. They can be differentiated by using different
     * identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($positiondelivery, "setShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param  string|null $globalID
     * The identifier is uniquely assigned to a party by a global registration organization.
     * @param  string|null $globalIDType
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
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
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param  string|null $lineone
     * The main line in the product end users address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the product end users address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the product end users address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The product end users state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party on item level
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype
     * registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     * 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname A name by which the party is known, if different from the party's name
     *                                   (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Ship-To party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($shipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact to the Ship-To party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param  string      $name
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  string|null $id
     * An identifier for the party Multiple IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipTo(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);
        $this->getObjectHelper()->tryCall($positiondelivery, "setUltimateShipToTradeParty", $shipToTradeParty);
        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param  string|null $globalID
     * Global identifier of the parfty
     * @param  string|null $globalIDType
     * Type of global identification number, must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));
        return $this;
    }

    /**
     * Add Tax registration to Ship-To Trade party
     *
     * @param  string|null $taxregtype
     * Type of tax number of the party
     * @param  string|null $taxregid
     * Tax number of the party or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToTaxRegistration(?string $taxregtype = null, ?string $taxregid = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $taxreg = $this->getObjectHelper()->getTaxRegistrationType($taxregtype, $taxregid);
        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxreg);
        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param  string|null $lineone
     * The main line in the party's address. This is usually the street name and house number or
     * the post office box
     * @param  string|null $linetwo
     * Line 2 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $linethree
     * Line 3 of the party's address. This is an additional address line in an address that can be
     * used to provide additional details in addition to the main line
     * @param  string|null $postcode
     * Identifier for a group of properties, such as a zip code
     * @param  string|null $city
     * Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param  string|null $subdivision
     * The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToAddress(?string $lineone = null, ?string $linetwo = null, ?string $linethree = null, ?string $postcode = null, ?string $city = null, ?string $country = null, ?string $subdivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineone, $linetwo, $linethree, $postcode, $city, $country, $subdivision);
        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "setPostalTradeAddress", $address);
        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the
     * party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided,
     * it should be known to the buyer or seller party
     * @param  string|null $legalorgtype The identifier for the identification scheme of the legal
     *                                   registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     *                                   0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname A name by which the party is known, if different from the party's name
     *                                   (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToLegalOrganisation(?string $legalorgid, ?string $legalorgtype, ?string $legalorgname): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $legalorg = $this->getObjectHelper()->getLegalOrganization($legalorgid, $legalorgtype, $legalorgname);
        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalorg);
        return $this;
    }

    /**
     * Set contact of the Ship-To party
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCallIfMethodExists($ultimateShipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);
        return $this;
    }

    /**
     * Add an additional contact of the Ship-To party. This is only supported in the
     * EXTENDED profile
     *
     * @param  string|null $contactpersonname
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactphoneno
     * Detailed information on the party's phone number
     * @param  string|null $contactfaxno
     * Detailed information on the party's fax number
     * @param  string|null $contactemailadd
     * Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToContact(?string $contactpersonname, ?string $contactdepartmentname, ?string $contactphoneno, ?string $contactfaxno, ?string $contactemailadd): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactpersonname, $contactdepartmentname, $contactphoneno, $contactfaxno, $contactemailadd);
        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "addToDefinedTradeContact", $contact);
        return $this;
    }

    /**
     * Detailed information on the actual delivery on item level
     *
     * @param  DateTime|null $date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionSupplyChainEvent(?DateTime $date): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $supplyChainevent = $this->getObjectHelper()->getSupplyChainEventType($date);
        $this->getObjectHelper()->tryCall($positiondelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on item level
     *
     * @param  string        $issuerassignedid
     * @param  string|null   $lineid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionDespatchAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $despatchddvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($positiondelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on item level
     *
     * @param  string        $issuerassignedid
     * @param  string|null   $lineid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionReceivingAdviceReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $receivingadvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($positiondelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);
        return $this;
    }

    /**
     * Detailed information on the associated delivery note on item level
     *
     * @param  string        $issuerassignedid
     * @param  string|null   $lineid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionDeliveryNoteReferencedDocument(string $issuerassignedid, ?string $lineid = null, ?DateTime $issueddate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $deliverynoterefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerassignedid, null, $lineid, null, null, null, $issueddate, null);
        $this->getObjectHelper()->tryCall($positiondelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);
        return $this;
    }

    /**
     * Add information about the sales tax that applies to the goods and services invoiced
     * in the relevant invoice line
     *
     * @param  string      $categoryCode
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
     * @param  string      $typeCode
     * In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be
     * specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for
     * the tax type must then be taken from the code list UNTDID 5153.
     * @param  float       $rateApplicablePercent
     * The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales
     * tax category and the category-specific sales tax rate  must correspond to one another. The value to be
     * given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null  $calculatedAmount
     * Tax amount. Information only for taxes that are not VAT.
     * @param  string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @param  string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionTax(string $categoryCode, string $typeCode, float $rateApplicablePercent, ?float $calculatedAmount = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $tax = $this->getObjectHelper()->getTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);
        $this->getObjectHelper()->tryCallAll($positionsettlement, ["addToApplicableTradeTax", "setApplicableTradeTax"], $tax);
        return $this;
    }

    /**
     * Set information about the period relevant for the invoice item.
     * Note: Also known as the invoice line delivery period.
     *
     * @param  DateTime|null $startdate
     * Start of the billing period
     * @param  DateTime|null $endDate
     * End of the billing period
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionBillingPeriod(?DateTime $startdate, ?DateTime $endDate): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $period = $this->getObjectHelper()->getSpecifiedPeriodType($startdate, $endDate, null, null);
        $this->getObjectHelper()->tryCall($positionsettlement, "setBillingSpecifiedPeriod", $period);
        return $this;
    }

    /**
     * Add surcharges and discounts on position level
     *
     * @param  float       $actualAmount
     * The surcharge/discount amount excluding sales tax
     * @param  boolean     $isCharge
     * Switch that indicates whether the following data refer to an allowance or a discount,
     * true means that
     * @param  float|null  $calculationPercent
     * The percentage that may be used in conjunction with the base invoice line discount
     * amount to calculate the invoice line discount amount
     * @param  float|null  $basisAmount
     * The base amount that may be used in conjunction with the invoice line discount percentage
     * to calculate the invoice line discount amount
     * @param  string|null $reasonCode
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
     * @param  string|null $reason
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
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $allowanceCharge = $this->getObjectHelper()->getTradeAllowanceChargeType($actualAmount, $isCharge, null, null, null, null, $calculationPercent, $basisAmount, null, null, $reasonCode, $reason);
        $this->getObjectHelper()->tryCall($positionsettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);
        return $this;
    }

    /**
     * Set information on item totals
     *
     * @param  float      $lineTotalAmount
     * The total amount of the invoice item.
     * __Note:__ This is the "net" amount, that is, excluding sales tax, but including all surcharges
     * and discounts applicable to the item level, as well as other taxes.
     * @param  float|null $totalAllowanceChargeAmount
     * Total amount of item surcharges and discounts
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionLineSummation(float $lineTotalAmount, ?float $totalAllowanceChargeAmount = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $summation = $this->getObjectHelper()->getTradeSettlementLineMonetarySummationType($lineTotalAmount, $totalAllowanceChargeAmount);
        $this->getObjectHelper()->tryCall($positionsettlement, "setSpecifiedTradeSettlementLineMonetarySummation", $summation);
        return $this;
    }

    /**
     * Add an AccountingAccount on item level
     * Detailinformationen zur Buchungsreferenz
     *
     * @param  string      $id
     * @param  string|null $typeCode
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $account = $this->getObjectHelper()->getTradeAccountingAccountType($id, $typeCode);
        $this->getObjectHelper()->tryCallAll($positionsettlement, ["addToReceivableSpecifiedTradeAccountingAccount", "setReceivableSpecifiedTradeAccountingAccount"], $account);
        return $this;
    }
}
