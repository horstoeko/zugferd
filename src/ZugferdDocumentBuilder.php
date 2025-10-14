<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use DateTimeInterface;
use DOMXPath;
use DOMDocument;
use horstoeko\zugferd\codelists\ZugferdDocumentType;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;
use horstoeko\zugferd\exception\ZugferdUnsupportedMimetype;
use horstoeko\zugferd\codelists\ZugferdReferenceCodeQualifiers;

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
    protected $headerTradeAgreement;

    /**
     * HeaderTradeDelivery
     *
     * @var object
     */
    protected $headerTradeDelivery;

    /**
     * HeaderTradeSettlement
     *
     * @var object
     */
    protected $headerTradeSettlement;

    /**
     * SupplyChainTradeTransactionType
     *
     * @var object
     */
    protected $headerSupplyChainTradeTransaction;

    /**
     * Last added payment terms
     *
     * @var object
     */
    protected $currentPaymentTerms;

    /**
     * Last added position (line) to the docuemnt
     *
     * @var object
     */
    protected $currentPosition;

    /**
     * Receive the content as XML string
     *
     * @return string
     * @see    https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
     */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Creates a new ZugferdDocumentBuilder with profile $profile
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
        return new DOMXPath($this->getContentAsDomDocument());
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
     * Set main information about this document.
     *
     * @param  string                 $documentNo               __BT-1, From MINIMUM__ The document no issued by the seller
     * @param  string                 $documentTypeCode         __BT-3, From MINIMUM__ The type of the document, See \horstoeko\codelists\ZugferdInvoiceType for details
     * @param  DateTimeInterface      $documentDate             __BT-2, From MINIMUM__ Date of invoice. The date when the document was issued by the seller
     * @param  string                 $invoiceCurrency          __BT-5, From MINIMUM__ Code for the invoice currency
     * @param  string|null            $documentName             __BT-X-2, From EXTENDED__ Document Type. The documenttype (free text)
     * @param  string|null            $documentLanguage         __BT-X-4, From EXTENDED__ Language indicator. The language code in which the document was written
     * @param  DateTimeInterface|null $effectiveSpecifiedPeriod __BT-X-6-000, From EXTENDED__ The contractual due date of the invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInformation(string $documentNo, string $documentTypeCode, DateTimeInterface $documentDate, string $invoiceCurrency, ?string $documentName = null, ?string $documentLanguage = null, ?DateTimeInterface $effectiveSpecifiedPeriod = null): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setID", $this->getObjectHelper()->getIdType($documentNo));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setName", $this->getObjectHelper()->getTextType($documentName));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setTypeCode", $this->getObjectHelper()->getDocumentCodeType($documentTypeCode));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setIssueDateTime", $this->getObjectHelper()->getDateTimeType($documentDate));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "addToLanguageID", $this->getObjectHelper()->getIdType($documentLanguage));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setEffectiveSpecifiedPeriod", $this->getObjectHelper()->getSpecifiedPeriodType(null, null, $effectiveSpecifiedPeriod, null));

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoiceCurrencyCode", $this->getObjectHelper()->getIdType($invoiceCurrency));

        return $this;
    }

    /**
     * Set general payment information.
     *
     * @param  string|null $creditorReferenceID __BT-90, From BASIC WL__ Identifier of the creditor
     * @param  string|null $paymentReference    __BT-83, From BASIC WL__ Intended use for payment
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentGeneralPaymentInformation(?string $creditorReferenceID = null, ?string $paymentReference = null): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setCreditorReferenceID", $this->getObjectHelper()->getIdType($creditorReferenceID));
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setPaymentReference", $this->getObjectHelper()->getIdType($paymentReference));

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
     * @param  string $buyerReference __BT-10, From MINIMUM__ An identifier assigned by the buyer and used for internal routing
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerReference(?string $buyerReference): ZugferdDocumentBuilder
    {
        $reference = $this->getObjectHelper()->getTextType($buyerReference);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setBuyerReference", $reference);

        return $this;
    }

    /**
     * Set the routing-id (needed for German XRechnung).
     *
     * This is an alias-method for setDocumentBuyerReference
     *
     * __Note__: The route ID must be specified in the Buyer Reference (BT-10) in the XRechnung.
     *
     * @param  string $routingId __BT-10, From MINIMUM__ An identifier assigned by the buyer and used for internal routing
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentRoutingId(string $routingId): ZugferdDocumentBuilder
    {
        return $this->setDocumentBuyerReference($routingId);
    }

    /**
     * Set grouping of business process information.
     *
     * @param  string $id __BT-23, From MINIMUM__ Identifies the context of a business process where the transaction is taking place, thus allowing the buyer to process the invoice in an appropriate manner.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBusinessProcess(string $id): ZugferdDocumentBuilder
    {
        if ($this->getObjectHelper()->isNullOrEmpty($id)) {
            return $this;
        }

        $busProcessCtxParameter = $this->getObjectHelper()->createClassInstance('ram\DocumentContextParameterType');

        $this->getObjectHelper()->tryCall($busProcessCtxParameter, 'setID', $this->getObjectHelper()->getIdType($id));
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocumentContext(), 'setBusinessProcessSpecifiedDocumentContextParameter', $busProcessCtxParameter);

        return $this;
    }

    /**
     * Mark document as a copy from the original one __(BT-X-3-00, BT-X-3, From EXTENDED)__
     *
     * @return ZugferdDocumentBuilder
     */
    public function setIsDocumentCopy(): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "setCopyIndicator", $this->getObjectHelper()->getIndicatorType(true));

        return $this;
    }

    /**
     * Mark document as a test document.
     *
     * @return ZugferdDocumentBuilder
     */
    public function setIsTestDocument(): ZugferdDocumentBuilder
    {
        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocumentContext(), "setTestIndicator", $this->getObjectHelper()->getIndicatorType(true));

        return $this;
    }

    /**
     * Sets a foreign currency (code) with the tax amount. The exchange rate
     * is calculated by tax amounts
     *
     * @param  string     $foreignCurrencyCode __BT-6, From BASIC WL__ Foreign currency code
     * @param  float      $foreignTaxAmount    __BT-X-260, From EXTENDED__ Tax total amount in the foreign currency
     * @param  float|null $exchangeRate        __BT-X-260, From EXTENDED__ Exchange Rate
     * @return ZugferdDocumentBuilder
     */
    public function setForeignCurrency(string $foreignCurrencyCode, float $foreignTaxAmount, ?float $exchangeRate = null): ZugferdDocumentBuilder
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

        $calculatedExchangeRate = $exchangeRate;

        if (is_null($calculatedExchangeRate)) {
            $calculatedExchangeRate = round($foreignTaxAmount / $invoiceTaxAmount, 5);
        }

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setTaxCurrencyCode", $this->getObjectHelper()->getIdType($foreignCurrencyCode));
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setTaxApplicableTradeCurrencyExchange", $this->getObjectHelper()->getTaxApplicableTradeCurrencyExchangeType($invoiceCurrencyCode, $foreignCurrencyCode, $calculatedExchangeRate));

        return $this;
    }

    /**
     * Add a note to the docuzment
     *
     * @param  string      $content     __BT-22, From BASIC WL__ A free text containing unstructured information that is relevant to the invoice as a whole
     * @param  string|null $contentCode __BT-X-5, From EXTENDED__ A code to classify the content of the free text of the invoice
     * @param  string|null $subjectCode __BT-21, From BASIC WL__ The qualification of the free text for the invoice from BT-22
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentNote(string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
    {
        $note = $this->getObjectHelper()->getNoteType($content, $contentCode, $subjectCode);

        $this->getObjectHelper()->tryCall($this->getInvoiceObject()->getExchangedDocument(), "addToIncludedNote", $note);

        return $this;
    }

    /**
     * Detailed information about the seller (=service provider)
     *
     * @param  string      $name        __BT-27, From MINIMUM__ The full formal name under which the seller is registered in the National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param  string|null $id          __BT-29, From BASIC WL__ An identifier of the seller. In many systems, seller identification is key information. Multiple seller IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param  string|null $description __BT-33, From EN 16931__ Further legal information that is relevant for the seller
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSeller(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSellerTradeParty", $sellerTradeParty);

        return $this;
    }

    /**
     * Add an id to the document seller
     *
     * @param  string $id __BT-29, From BASIC WL__ An identifier of the seller. In many systems, seller identification is key information. Multiple seller IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerId(string $id): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");

        $this->getObjectHelper()->tryCall($sellerTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

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
     * @param  string|null $globalID     __BT-29/BT-29-0, From BASIC WL__ The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a global registration organization.
     * @param  string|null $globalIDType __BT-29-1, From BASIC WL__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string|null $taxRegType __BT-31-0/BT-32-0, From MINIMUM/EN 16931__ Type of tax number of the seller (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-31/32, From MINIMUM/EN 16931__ Tax number of the seller or sales tax identification number of the seller
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($sellerTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Add information about the seller's VAT Registration Number (Umsatzsteueridentnummer)
     *
     * @param  string|null $vatRegNo __BT-31, From MINIMUM/EN 16931__ VAT Registration Number (Umsatzsteueridentnummer)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerVATRegistrationNumber(?string $vatRegNo = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentSellerTaxRegistration(ZugferdReferenceCodeQualifiers::VAT_REGI_NUMB, $vatRegNo);
    }

    /**
     * Add information about the seller's Tax Number (Steuernummer)
     *
     * @param  string|null $taxNo __BT-32, From MINIMUM/EN 16931__ Tax Number (Steuernummer)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxNumber(?string $taxNo = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentSellerTaxRegistration(ZugferdReferenceCodeQualifiers::FISC_NUMB, $taxNo);
    }

    /**
     * Sets detailed information on the business address of the seller
     *
     * @param  string|null $lineOne     __BT-35, From BASIC WL__ The main line in the sellers address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-36, From BASIC WL__ Line 2 of the seller's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-162, From BASIC WL__ Line 3 of the seller's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-38, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-37, From BASIC WL__ Usual name of the city or municipality in which the seller's address is located
     * @param  string|null $country     __BT-40, From MINIMUM__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-39, From BASIC WL__ The sellers state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($sellerTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set Organization details
     *
     * @param  string|null $legalOrgId   __BT-30, From MINIMUM__ An identifier issued by an official registrar that identifies the seller as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer and seller
     * @param  string|null $legalOrgType __BT-30-1, From MINIMUM__ The identifier for the identification scheme of the legal registration of the seller. If the identification scheme is used, it must be selected from ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-28, From BASIC WL__ A name by which the seller is known, if different from the seller's name (also known as the company name). Note: This may be used if different from the seller's name.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($sellerTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set detailed information on the seller's contact person
     *
     * @param  string|null $contactPersonName     __BT-41, From EN 16931__ Such as personal name, name of contact person or department or office
     * @param  string|null $contactDepartmentName __BT-41-0, From EN 16931__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $contactPhoneNo        __BT-42, From EN 16931__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-107, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-43, From EN 16931__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($sellerTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the seller party (EXTENDED Profile only)
     *
     * @param  string|null $contactPersonName     __BT-41, From EN 16931__ Such as personal name, name of contact person or department or office
     * @param  string|null $contactDepartmentName __BT-41-0, From EN 16931__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $contactPhoneNo        __BT-42, From EN 16931__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-107, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-43, From EN 16931__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $sellerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($sellerTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Set the seller's electronic communication information
     *
     * @param  string|null $uriScheme __BT-34-1, From BASIC WL__ The identifier for the identification scheme of the seller's electronic address
     * @param  string|null $uri       __BT-34, From BASIC WL__ Specifies the electronic address of the seller to which the response to the invoice can be sent at application level
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
     * @param  string      $name        __BT-44, From MINIMUM__ The full name of the buyer
     * @param  string|null $id          __BT-46, From BASIC WL__ An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param  string|null $description __BT-X-334, From EXTENDED__ Further legal information about the buyer
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setBuyerTradeParty", $buyerTradeParty);

        return $this;
    }

    /**
     * Add an id to the document buyer
     *
     * @param  string $id __BT-46, From BASIC WL__ An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerId(string $id): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");

        $this->getObjectHelper()->tryCall($buyerTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id for the buyer
     *
     * @param  string|null $globalID     __BT-46-0, From BASIC WL__ The buyers's identifier identification scheme is an identifier uniquely assigned to a buyer by a global registration organization.
     * @param  string|null $globalIDType __BT-46-1, From BASIC WL__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string|null $taxRegType __BT-48-0, From BASIC WL__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-48, From BASIC WL__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($buyerTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Add information about the buyers's VAT Registration Number (Umsatzsteueridentnummer)
     *
     * @param  string|null $vatRegNo __BT-48, From MINIMUM/EN 16931__ VAT Registration Number (Umsatzsteueridentnummer)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerVATRegistrationNumber(?string $vatRegNo = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentBuyerTaxRegistration(ZugferdReferenceCodeQualifiers::VAT_REGI_NUMB, $vatRegNo);
    }

    /**
     * Add information about the buyer's Tax Number (Steuernummer)
     *
     * @param  string|null $taxNo __BT-48, From MINIMUM/EN 16931__ Tax Number (Steuernummer)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerTaxNumber(?string $taxNo = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentBuyerTaxRegistration(ZugferdReferenceCodeQualifiers::FISC_NUMB, $taxNo);
    }

    /**
     * Sets detailed information on the business address of the buyer
     *
     * @param  string|null $lineOne     __BT-50, From BASIC WL__ The main line in the buyers address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-51, From BASIC WL__ Line 2 of the buyers address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-163, From BASIC WL__ Line 3 of the buyers address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-53, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-52, From BASIC WL__ Usual name of the city or municipality in which the buyers address is located
     * @param  string|null $country     __BT-55, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-54, From BASIC WL__ The buyers state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($buyerTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the buyer party
     *
     * @param  string|null $legalOrgId   __BT-47, From MINIMUM__ An identifier issued by an official registrar that identifies the buyer as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer and buyer
     * @param  string|null $legalOrgType __BT-47-1, From MINIMUM__ The identifier for the identification scheme of the legal registration of the buyer. If the identification scheme is used, it must be selected from ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-45, From EN 16931__ A name by which the buyer is known, if different from the buyers name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($buyerTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the buyer party
     *
     * @param  string|null $contactPersonName     __BT-56, From EN 16931__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-56-0, From EN 16931__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-57, From EN 16931__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-115, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-58, From EN 16931__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($buyerTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the buyer party contact person (EXTENDED Profile only)
     *
     * @param  string|null $contactPersonName     __BT-56, From EN 16931__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-56-0, From EN 16931__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-57, From EN 16931__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-115, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-58, From EN 16931__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentBuyerContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $buyerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getBuyerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($buyerTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Set the buyers's electronic communication information
     *
     * @param  string|null $uriScheme __BT-49-1, From BASIC WL__ The identifier for the identification scheme of the buyer's electronic address
     * @param  string|null $uri       __BT-49, From BASIC WL__ Specifies the buyer's electronic address to which the invoice is sent
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
     * Sets the Information about the seller's tax representative
     *
     * @param  string      $name        __BT-62, From BASIC WL__ The full name of the seller's tax agent
     * @param  string|null $id          __BT-X-116, From EXTENDED__ An identifier of the sellers tax agent.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the sellers tax agent
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeTradeParty(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $sellerTaxRepresentativeTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSellerTaxRepresentativeTradeParty", $sellerTaxRepresentativeTradeParty);

        return $this;
    }

    /**
     * Add a global id for the seller's Tax representative party
     *
     * @param  string|null $globalID     __BT-X-117, From EXTENDED__ The seller's tax agent identifier identification scheme is an identifier uniquely assigned to a seller by a global registration organization.
     * @param  string|null $globalIDType __BT-X-117-1, From EXTENDED__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");

        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));

        return $this;
    }

    /**
     * Add Tax registration to seller's tax representative party
     *
     * @param  string|null $taxRegType __BT-63-0, From BASIC WL__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-63, From BASIC WL__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the seller's tax representative party
     *
     * @param  string|null $lineOne     __BT-64, From BASIC WL__ The main line in the sellers tax agent address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-65, From BASIC WL__ Line 2 of the sellers tax agent address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-164, From BASIC WL__ Line 3 of the sellers tax agent address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-67, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-66, From BASIC WL__ Usual name of the city or municipality in which the sellers tax agent address is located
     * @param  string|null $country     __BT-69, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-68, From BASIC WL__ The sellers tax agent state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the seller's tax representative party
     *
     * @param  string|null $legalOrgId   __BT-, From __ An identifier issued by an official registrar that identifies the seller tax agent as a legal entity or legal person.
     * @param  string|null $legalOrgType __BT-, From __ The identifier for the identification scheme of the legal registration of the sellers tax agent. If the identification scheme is used, it must be selected from  ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-, From __ A name by which the sellers tax agent is known, if different from the  sellers tax agent name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set detailed information on the seller's tax representative party contact person
     *
     * @param  string|null $contactPersonName     __BT-X-120, From EXTENDED__ Such as personal name, name of contact person or department or office
     * @param  string|null $contactDepartmentName __BT-X-121, From EXTENDED__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $contactPhoneNo        __BT-X-122, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-123, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-124, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerTaxRepresentativeContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($taxrepresentativeTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the seller's tax representative party (EXTENDED Profile only)
     *
     * @param  string|null $contactPersonName     __BT-X-120, From EXTENDED__ Such as personal name, name of contact person or department or office
     * @param  string|null $contactDepartmentName __BT-X-121, From EXTENDED__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $contactPhoneNo        __BT-X-122, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-123, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-124, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentSellerTaxRepresentativeContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $taxrepresentativeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getSellerTaxRepresentativeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($taxrepresentativeTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Detailed information on the deviating end user (general informaton)
     *
     * @param  string      $name        __BT-X-128, From EXTENDED__ Name/company name of the end user
     * @param  string|null $id          __BT-X-126, From EXTENDED__ An identifier of the product end user
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the product end user
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUser(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setProductEndUserTradeParty", $productEndUserTradeParty);

        return $this;
    }

    /**
     * Add a Global identifier of the deviating end user
     *
     * @param  string|null $globalID     __BT-X-127, From EXTENDED__ The identifier is uniquely assigned to a party by a global registration organization.
     * @param  string|null $globalIDType __BT-X-127-0, From EXTENDED__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");

        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));

        return $this;
    }

    /**
     * Add Tax registration to the deviating end user
     *
     * @param  string|null $taxRegType __BT-, From __ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-, From __ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the Product Enduser party
     *
     * @param  string|null $lineOne     __BT-X-397, From EXTENDED__ The main line in the product end users address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-398, From EXTENDED__ Line 2 of the product end users address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-399, From EXTENDED__ Line 3 of the product end users address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-396, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-400, From EXTENDED__ Usual name of the city or municipality in which the product end users address is located
     * @param  string|null $country     __BT-X-401, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-X-402, From EXTENDED__ The product end users state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the Product Enduser party
     *
     * @param  string|null $legalOrgId   __BT-X-129, From EXTENDED__ An identifier issued by an official registrar that identifies the product end user as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to all trade parties
     * @param  string|null $legalOrgType __BT-X-129-0, From EXTENDED__The identifier for the identification scheme of the legal registration of the product end user. If the identification scheme is used, it must be selected from ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-X-130, From EXTENDED__ A name by which the product end user is known, if different from the product end users name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the Product Enduser party
     *
     * @param  string|null $contactPersonName     __BT-X-131, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-132, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-133, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-134, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-135, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProductEndUserContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($productEndUserTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the Product Enduser party (EXTENDED Profile only)
     *
     * @param  string|null $contactPersonName     __BT-X-131, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-132, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-133, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-134, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-135, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentProductEndUserContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $productEndUserTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeAgreement, "getProductEndUserTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($productEndUserTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Ship-To
     *
     * @param  string|null $name        __BT-70, From BASIC WL__ The name of the party to whom the goods are being delivered or for whom the services are being performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  string|null $id          __BT-71, From BASIC WL__ An identifier for the place where the goods are delivered or where the services are provided. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipTo(?string $name = null, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->getTradePartyAllowEmpty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setShipToTradeParty", $shipToTradeParty);

        return $this;
    }

    /**
     * Add an id to the Ship-to Trade Party
     *
     * @param  string $id __BT-71, From BASIC WL__ An identifier for the place where the goods are delivered or where the services are provided. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipTolId(string $id): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");

        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party
     *
     * @param  string|null $globalID     __BT-71-0, From BASIC WL__ Global identifier of the goods recipient
     * @param  string|null $globalIDType __BT-71-1, From BASIC WL__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string|null $taxRegType __BT-X-161-0, From EXTENDED__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-X-161, From EXTENDED__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party
     *
     * @param  string|null $lineOne     __BT-75, From BASIC WL__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-76, From BASIC WL__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-165, From BASIC WL__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-78, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-77, From BASIC WL__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-80, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-79, From BASIC WL__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party
     *
     * @param  string|null $legalOrgId   __BT-X-153, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-153-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-154, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the Ship-To party
     *
     * @param  string|null $contactPersonName     __BT-X-155, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-156, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-157, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-158, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-159, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($shipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the Ship-To party
     *
     * @param  string|null $contactPersonName     __BT-X-155, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-156, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-157, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-158, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-159, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Detailed information on the different end recipient
     *
     * @param  string|null $name        __BT-X-164, From EXTENDED__ Name or company name of the different end recipient
     * @param  string|null $id          __BT-X-162, From EXTENDED__ Identification of the different end recipient. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the different end recipient
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipTo(?string $name = null, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->getTradePartyAllowEmpty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setUltimateShipToTradeParty", $shipToTradeParty);

        return $this;
    }

    /**
     * Add an id to the different end recipient
     *
     * @param  string $id __BT-X-162, From EXTENDED__ Identification of the different end recipient. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToId(string $id): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");

        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id for the different end recipient
     *
     * @param  string|null $globalID     __BT-X-163, From EXTENDED__ Global identifier of the different end recipient
     * @param  string|null $globalIDType __BT-X-163-0, From EXTENDED__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");

        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));

        return $this;
    }

    /**
     * Add Tax registration to the different end recipient
     *
     * @param  string|null $taxRegType __BT-X-180-0, From EXTENDED__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-X-180, From EXTENDED__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the different end recipient
     *
     * @param  string|null $lineOne     __BT-X-173, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box. For major customer addresses, this field must be filled with "-".
     * @param  string|null $lineTwo     __BT-X-174, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-175, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-172, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-176, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-177, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-X-178, From EXTENDED__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the different end recipient
     *
     * @param  string|null $legalOrgId   __BT-X-165, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-165-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-166, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the different end recipient
     *
     * @param  string|null $contactPersonName     __BT-X-167, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-168, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-169, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-170, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-171, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentUltimateShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($UltimateShipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the different end recipient.
     *
     * @param  string|null $contactPersonName     __BT-X-167, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-168, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-169, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-170, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-171, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $UltimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($UltimateShipToTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Set detailed information of the deviating consignor party
     *
     * @param  string|null $name        __BT-X-183, From EXTENDED__ The name of the party
     * @param  string|null $id          __BT-X-181, From EXTENDED__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFrom(?string $name = null, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $shipToTradeParty = $this->getObjectHelper()->getTradePartyAllowEmpty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setShipFromTradeParty", $shipToTradeParty);

        return $this;
    }

    /**
     * Add an id to the deviating consignor party
     *
     * @param  string $id __BT-X-181, From EXTENDED__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromId(string $id): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");

        $this->getObjectHelper()->tryCall($shipFromTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id for the deviating consignor party
     *
     * @param  string|null $globalID     __BT-X-182, From EXTENDED__ Global identifier of the goods recipient
     * @param  string|null $globalIDType __BT-X-182-0, From EXTENDED__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string|null $taxRegType __BT-, From __ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-, From __ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($shipFromTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the deviating consignor party
     *
     * @param  string|null $lineOne     __BT-X-192, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-193, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-194, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-191, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-195, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-196, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-X-197, From EXTENDED__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($shipFromTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the deviating consignor party
     *
     * @param  string|null $legalOrgId   __BT-X-184, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-184-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-185, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($shipFromTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the deviating consignor party
     *
     * @param  string|null $contactPersonName     __BT-X-186, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-187, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-188, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-189, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-190, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentShipFromContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($shipFromTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the deviating consignor party
     *
     * @param  string|null $contactPersonName     __BT-X-186, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-187, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-188, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-189, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-190, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentShipFromContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $shipFromTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeDelivery, "getShipFromTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($shipFromTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Detailed information about the Invoicer Party
     *
     * @param  string      $name        __BT-X-207, From EXTENDED__ The name of the party
     * @param  string|null $id          __BT-X-205, From EXTENDED__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicer(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoicerTradeParty", $invoicerTradeParty);

        return $this;
    }

    /**
     * Add an id to the Invoicer Party
     *
     * @param  string $id __BT-X-205, From EXTENDED__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerId(string $id): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");

        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id to the Invoicer Party
     *
     * @param  string|null $globalID     __BT-X-206, From EXTENDED__ Global identifier of the goods recipient
     * @param  string|null $globalIDType __BT-X-206-0, From EXTENDED__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");

        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));

        return $this;
    }

    /**
     * Add Tax registration to Invoicer Party
     *
     * @param  string|null $taxRegType __BT-, From __ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-, From __ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the Invoicer Party
     *
     * @param  string|null $lineOne     __BT-X-216, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-217, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-218, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-215, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-219, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-220, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-X-221, From EXTENDED__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($invoicerTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the Invoicer Party
     *
     * @param  string|null $legalOrgId   __BT-X-208, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-208-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,* 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-209, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($invoicerTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the Invoicer Party
     *
     * @param  string|null $contactPersonName     __BT-X-210, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-211, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-212, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-213, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-214, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicerContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($invoicerTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the Invoicer Party
     *
     * @param  string|null $contactPersonName     __BT-X-210, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-211, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-212, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-213, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-214, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicerContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $invoicerTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoicerTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($invoicerTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Set detailed information on the different invoice recipient
     *
     * @param  string      $name        __BT-X-226, From EXTENDED__ The name of the party
     * @param  string|null $id          __BT-X-224, From EXTENDED__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoicee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setInvoiceeTradeParty", $invoiceeTradeParty);

        return $this;
    }

    /**
     * Add an id to the Invoicee Party
     *
     * @param  string $id __BT-X-224, From EXTENDED__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeId(string $id): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");

        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id for the Invoicee Party
     *
     * @param  string|null $globalID     __BT-X-225, From EXTENDED__ Global identification number
     * @param  string|null $globalIDType __BT-X-225-0, From EXTENDED__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeGlobalId(?string $globalID = null, ?string $globalIDType = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");

        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToGlobalID", $this->getObjectHelper()->getIdType($globalID, $globalIDType));

        return $this;
    }

    /**
     * Add Tax registration to the Invoicee Party
     *
     * @param  string|null $taxRegType __BT-X-242-0, From EXTENDED__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-X-242, From EXTENDED__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the Invoicee Party
     *
     * @param  string|null $lineOne     __BT-X-235, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-236, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-237, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-234, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-238, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-239, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-X-240, From EXTENDED__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the Invoicee Party
     *
     * @param  string|null $legalOrgId   __BT-X-227, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-227-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-228, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the Invoicee Party
     *
     * @param  string|null $contactPersonName     __BT-X-229, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-230, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-231, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-232, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-233, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceeContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($invoiceeTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the Invoicee Party
     *
     * @param  string|null $contactPersonName     __BT-X-229, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-230, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-231, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-232, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-233, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceeContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $invoiceeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getInvoiceeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($invoiceeTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Set detailed information about the payee, i.e. about the place that receives the payment.
     * The role of the payee may also be performed by a party other than the seller, e.g. by a factoring service.
     *
     * @param  string      $name        __BT-59, From BASIC WL__ The name of the party. Must be used if the payee is not the same as the seller. However, the name of the payee may match the name of the seller.
     * @param  string|null $id          __BT-60, From BASIC WL__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayee(string $name, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->getTradeParty($name, $id, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setPayeeTradeParty", $payeeTradeParty);

        return $this;
    }

    /**
     * Add an id to the payee trade party
     *
     * @param  string $id __BT-60, From BASIC WL__ An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeId(string $id): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");

        $this->getObjectHelper()->tryCall($payeeTradeParty, "addToID", $this->getObjectHelper()->getIdType($id));

        return $this;
    }

    /**
     * Add a global id for the payee trade party
     *
     * @param  string|null $globalID     __BT-60-0, From BASIC WL__ Global identification number
     * @param  string|null $globalIDType __BT-60-1, From BASIC WL__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string|null $taxRegType __BT-X-257-0, From EXTENDED__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-X-257, From EXTENDED Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($payeeTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the payee trade party
     *
     * @param  string|null $lineOne     __BT-X-250, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-251, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-252, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-249, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-253, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-254, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT-X-255, From EXTENDED__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($payeeTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the payee trade party
     *
     * @param  string|null $legalOrgId   __BT-61, From BASIC WL__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-61-1, From BASIC WL__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-243, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($payeeTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the payee trade party
     *
     * @param  string|null $contactPersonName     __BT-X-244, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-245, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-246, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-247, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-248, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPayeeContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($payeeTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an (additional) contact to the payee trade party
     *
     * @param  string|null $contactPersonName     __BT-X-244, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-245, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-246, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-247, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-248, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPayeeContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $payeeTradeParty = $this->getObjectHelper()->tryCallAndReturn($this->headerTradeSettlement, "getPayeeTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($payeeTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Set information on the delivery conditions
     *
     * @param  string|null $code __BT-X-145, From EXTENDED__ The code indicating the type of delivery for these commercial delivery terms. To be selected from the entries in the list UNTDID 4053 + INCOTERMS
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDeliveryTerms(?string $code): ZugferdDocumentBuilder
    {
        $deliveryterms = $this->getObjectHelper()->getTradeDeliveryTermsType($code);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setApplicableTradeDeliveryTerms", $deliveryterms);

        return $this;
    }

    /**
     * Set details of the associated order confirmation.
     *
     * @param  string                 $issuerAssignedId __BT-14, From EN 16931__ An identifier issued by the seller for a referenced sales order (Order confirmation number)
     * @param  DateTimeInterface|null $issueDate        __BT-X-146, From EXTENDED__ Order confirmation date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSellerOrderReferencedDocument(string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $sellerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSellerOrderReferencedDocument", $sellerorderrefdoc);

        return $this;
    }

    /**
     * Set details of the related buyer order.
     *
     * @param  string                 $issuerAssignedId __BT-13, From MINIMUM__ An identifier issued by the buyer for a referenced order (order number)
     * @param  DateTimeInterface|null $issueDate        __BT-X-147, From EXTENDED__ Date of order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBuyerOrderReferencedDocument(?string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);

        return $this;
    }

    /**
     * Set details of the associated offer
     *
     * @param  string                 $issuerAssignedId __BT-X-403, From EXTENDED__ Offer number
     * @param  DateTimeInterface|null $issueDate        __BT-X-404, From EXTENDED__ Date of offer
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentQuotationReferencedDocument(?string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $quotationrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setQuotationReferencedDocument", $quotationrefdoc);

        return $this;
    }

    /**
     * Set details of the associated contract
     *
     * @param  string                 $issuerAssignedId __BT-12, From BASIC WL__ The contract reference should be assigned once in the context of the specific trade relationship and for a defined period of time (contract number)
     * @param  DateTimeInterface|null $issueDate        __BT-X-26, From EXTENDED__ Contract date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentContractReferencedDocument(?string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

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
     *
     * @param  string                 $issuerAssignedId   __BT-122, From EN 16931__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string                 $typeCode           __BT-122-0, From EN 16931__ Type of referenced document (See codelist UNTDID 1001)
     *                                                    - Code 916 "reference paper" is used to reference the identification of the
     *                                                    document on which the invoice is based - Code 50 "Price / sales catalog response"
     *                                                    is used to reference the tender or the lot - Code 130 "invoice data sheet" is used
     *                                                    to reference an identifier for an object specified by the seller.
     * @param  string|null            $uriId              __BT-124, From EN 16931__ A means of locating the resource, including the primary access method intended for it, e.g. http:// or ftp://. The storage location of the external document must be used if the buyer requires further information as
     *                                                    supporting documents for the invoiced amounts. External documents are not part of the invoice. Invoice processing should be possible without access to external documents. Access to external documents can entail certain risks.
     * @param  string|array|null      $name               __BT-123, From EN 16931__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null            $refTypeCode        __BT-18-1, From ENN 16931__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTimeInterface|null $issueDate          __BT-X-149, From EXTENDED__ Document date
     * @param  string|null            $binaryDataFilename __BT-125, From EN 16931__ Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentAdditionalReferencedDocument(string $issuerAssignedId, string $typeCode, ?string $uriId = null, $name = null, ?string $refTypeCode = null, ?DateTimeInterface $issueDate = null, ?string $binaryDataFilename = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, $uriId, null, $typeCode, $name, $refTypeCode, $issueDate, $binaryDataFilename);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "addToAdditionalReferencedDocument", $additionalrefdoc);

        return $this;
    }

    /**
     * Add an invoice supporting additional document reference with an URL which specifies the location where the information can be found
     * The invoice supporting documents can be used to reference a document number, which should be known to the recipient, as well as an external document (referenced by a URL).
     * The option of linking to an external document is required, for example, when large attachments and/or sensitive information, e.g. for personal services, are involved,
     * which must be separated from the invoice.
     *
     * @param  string            $issuerAssignedId __BT-122, From EN 16931__ Identification of the document supporting the invoice
     * @param  string            $uriId            __BT-124, From EN 16931__ A means of locating the resource, including the primary access method intended for it, e.g. http:// or ftp://. The storage location of the external document must be used if the buyer requires further information as
     * @param  string|array|null $name             __BT-123, From EN 16931__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceSupportingDocumentWithUri(string $issuerAssignedId, string $uriId, $name = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentAdditionalReferencedDocument($issuerAssignedId, ZugferdDocumentType::RELATED_DOCUMENT, $uriId, $name);
    }

    /**
     * Add an invoice supporting additional document reference with an URL which specifies the location where the information can be found
     * The invoice supporting documents can be used to reference both a document number, which should be known to the recipient, and an embedded file (such as a timesheet as a PDF file).
     *
     * @param  string            $issuerAssignedId   __BT-122, From EN 16931__ Identification of the document supporting the invoice
     * @param  string            $binaryDataFilename __BT-125, From EN 16931__ Contains a file name of an attachment document embedded as a binary object
     * @param  string|array|null $name               __BT-123, From EN 16931__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @return ZugferdDocumentBuilder
     * @throws ZugferdUnsupportedMimetype
     */
    public function addDocumentInvoiceSupportingDocumentWithFile(string $issuerAssignedId, string $binaryDataFilename, $name = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentAdditionalReferencedDocument($issuerAssignedId, ZugferdDocumentType::RELATED_DOCUMENT, null, $name, null, null, $binaryDataFilename);
    }

    /**
     * Add a tender or lot document reference
     *
     * @param  string $issuerAssignedId __BT-122, From EN 16931__ Tender or lot reference
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentTenderOrLotReferenceDocument(string $issuerAssignedId): ZugferdDocumentBuilder
    {
        return $this->addDocumentAdditionalReferencedDocument($issuerAssignedId, ZugferdDocumentType::VALIDATED_PRICED_TENDER);
    }

    /**
     * Add details of the calculated object
     *
     * @param  string $issuerAssignedId __BT-122, From EN 16931__ Depending on the application, this can be a subscription number, a telephone number, a meter reading, a vehicle, a person, etc.
     * @param  string $refTypeCode      __BT-18-1, From ENN 16931__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoicedObjectReferenceDocument(string $issuerAssignedId, string $refTypeCode): ZugferdDocumentBuilder
    {
        return $this->addDocumentAdditionalReferencedDocument($issuerAssignedId, ZugferdDocumentType::INVOICING_DATA_SHEET, null, null, $refTypeCode);
    }

    /**
     * Set a Reference to the previous invoice
     *
     * To be used if:
     *  - a previous invoice is corrected
     *  - reference is made from a final invoice to previous partial invoices
     *  - reference is made from a final invoice to previous invoices for advance payments.     *
     *
     * @param  string                 $issuerAssignedId __BT-25, From BASIC WL__ The identification of an invoice previously sent by the seller
     * @param  string|null            $typeCode         __BT-X-555, From EXTENDED__ Type of previous invoice (code)
     * @param  DateTimeInterface|null $issueDate        __BT-26, From BASIC WL__ Date of the previous invoice
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentInvoiceReferencedDocument(string $issuerAssignedId, ?string $typeCode = null, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $invoicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, $typeCode, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCallIfMethodExists($this->headerTradeSettlement, "addToInvoiceReferencedDocument", "setInvoiceReferencedDocument", [$invoicerefdoc], $invoicerefdoc);

        return $this;
    }

    /**
     * Add a Reference to the previous invoice
     *
     * To be used if:
     *  - a previous invoice is corrected
     *  - reference is made from a final invoice to previous partial invoices
     *  - reference is made from a final invoice to previous invoices for advance payments.     *
     *
     * @param  string                 $issuerAssignedId __BT-25, From BASIC WL__ The identification of an invoice previously sent by the seller
     * @param  string|null            $typeCode         __BT-X-555, From EXTENDED__ Type of previous invoice (code)
     * @param  DateTimeInterface|null $issueDate        __BT-26, From BASIC WL__ Date of the previous invoice
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentInvoiceReferencedDocument(string $issuerAssignedId, ?string $typeCode = null, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $invoicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, $typeCode, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToInvoiceReferencedDocument", $invoicerefdoc);

        return $this;
    }

    /**
     * Set Details of a project reference
     *
     * @param  string $id   __BT-11, From EN 16931__ The identifier of the project to which the invoice relates
     * @param  string $name __BT-11-0, From EN 16931__  The name of the project to which the invoice relates
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentProcuringProject(string $id, string $name = "Project Reference"): ZugferdDocumentBuilder
    {
        $procuringproject = $this->getObjectHelper()->getProcuringProjectType($id, $name);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "setSpecifiedProcuringProject", $procuringproject);

        return $this;
    }

    /**
     * Details of the associated end customer order
     *
     * @param  string                 $issuerAssignedId __BT-X-150, From EXTENDED__ Order number of the end customer
     * @param  DateTimeInterface|null $issueDate        __BT-X-151, From EXTENDED__ Date of the order issued by the end customer
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentUltimateCustomerOrderReferencedDocument(string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $additionalrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeAgreement, "addToUltimateCustomerOrderReferencedDocument", $additionalrefdoc);

        return $this;
    }

    /**
     * Set detailed information on the actual delivery
     *
     * @param  DateTimeInterface|null $date __BT-72, From BASIC WL__ Actual delivery time
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSupplyChainEvent(?DateTimeInterface $date): ZugferdDocumentBuilder
    {
        $supplyChainevent = $this->getObjectHelper()->getSupplyChainEventType($date);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);

        return $this;
    }

    /**
     * Set Detailed information on the actual delivery
     *
     * @param  string                 $issuerAssignedId __BT-16, From BASIC WL__ Shipping notification reference
     * @param  DateTimeInterface|null $issueDate        __BT-X-200, From EXTENDED__ Shipping notification date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDespatchAdviceReferencedDocument(?string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $despatchddvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);

        return $this;
    }

    /**
     * Set detailed information on the associated goods receipt notification
     *
     * @param  string                 $issuerAssignedId __BT-15, From EN 16931__ An identifier for a referenced goods receipt notification (Goods receipt number)
     * @param  DateTimeInterface|null $issueDate        __BT-X-201, From EXTENDED__ Goods receipt date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentReceivingAdviceReferencedDocument(string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $receivingadvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);

        return $this;
    }

    /**
     * Set detailed information on the associated delivery bill
     *
     * @param  string                 $issuerAssignedId __BT-X-202, From EXTENDED__ Delivery slip number
     * @param  DateTimeInterface|null $issueDate        __BT-X-203, From EXTENDED__ Delivery slip date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentDeliveryNoteReferencedDocument(string $issuerAssignedId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $deliverynoterefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($this->headerTradeDelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);

        return $this;
    }

    /**
     * Add detailed information on the payment method
     *
     * __Notes__
     *
     * The SpecifiedTradeSettlementPaymentMeans element can only be repeated for each bank account if
     * several bank accounts are to be transferred for transfers. The code for the payment method in the Typecode
     * element must therefore not differ in the repetitions. The elements ApplicableTradeSettlementFinancialCard
     * and PayerPartyDebtorFinancialAccount must not be specified for bank transfers.
     *
     * @param  string      $typeCode         __BT-81, From BASIC WL__ The expected or used means of payment, expressed as a code. The entries from the UNTDID 4461 code list must be used. A distinction should be made between SEPA and non-SEPA payments as well as between credit payments, direct debits, card payments and other means of payment In particular, the following codes can be used:
     *                                       - 10: cash
     *                                       - 20: check
     *                                       - 30: transfer
     *                                       - 42: Payment to bank account
     *                                       - 48: Card payment
     *                                       - 49: direct debit
     *                                       - 57: Standing order
     *                                       - 58: SEPA Credit Transfer
     *                                       - 59: SEPA Direct Debit
     *                                       - 97: Report
     * @param  string|null $information      __BT-82, From EN 16931__ The expected or used means of payment expressed in text form, e.g. cash, bank transfer, direct debit, credit card, etc.
     * @param  string|null $cardType         __BT-, From __ The type of the card
     * @param  string|null $cardId           __BT-87, From EN 16931__ The primary account number (PAN) to which the card used for payment belongs. In accordance with card payment security standards, an invoice should never contain a full payment card master account number. The following specification of the PCI Security Standards Council currently applies: The first 6 and last 4 digits at most are to be displayed
     * @param  string|null $cardHolderName   __BT-88, From EN 16931__ Name of the payment card holder
     * @param  string|null $buyerIban        __BT-91, From BASIC WL__ The account to be debited by the direct debit
     * @param  string|null $payeeIban        __BT-84, From BASIC WL__ A unique identifier for the financial account held with a payment service provider to which the payment should be made
     * @param  string|null $payeeAccountName __BT-85, From BASIC WL__ The name of the payment account held with a payment service provider to which the payment should be made
     * @param  string|null $payeePropId      __BT-84-0, From BASIC WL__ National account number (not for SEPA)
     * @param  string|null $payeeBic         __BT-86, From EN 16931__ An identifier for the payment service provider with which the payment account is held
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMean(string $typeCode, ?string $information = null, ?string $cardType = null, ?string $cardId = null, ?string $cardHolderName = null, ?string $buyerIban = null, ?string $payeeIban = null, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType($typeCode, $information);
        $financialCard = $this->getObjectHelper()->getTradeSettlementFinancialCardType($cardType, $cardId, $cardHolderName);
        $buyerfinancialaccount = $this->getObjectHelper()->getDebtorFinancialAccountType($buyerIban);
        $payeefinancialaccount = $this->getObjectHelper()->getCreditorFinancialAccountType($payeeIban, $payeeAccountName, $payeePropId);
        $payeefinancialInstitution = $this->getObjectHelper()->getCreditorFinancialInstitutionType($payeeBic);

        $this->getObjectHelper()->tryCall($paymentMeans, "setApplicableTradeSettlementFinancialCard", $financialCard);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayerPartyDebtorFinancialAccount", $buyerfinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeePartyCreditorFinancialAccount", $payeefinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeeSpecifiedCreditorFinancialInstitution", $payeefinancialInstitution);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        return $this;
    }

    /**
     * Sets the document payment means to _SEPA Credit Transfer_
     *
     * @param  string      $payeeIban        __BT-84, From BASIC WL__ A unique identifier for the financial account held with a payment service provider to which the payment should be made
     * @param  string|null $payeeAccountName __BT-85, From BASIC WL__ The name of the payment account held with a payment service provider to which the payment should be made
     * @param  string|null $payeePropId      __BT-BT-84-0, From BASIC WL__ National account number (not for SEPA)
     * @param  string|null $payeeBic         __BT-86, From EN 16931__ An identifier for the payment service provider with which the payment account is held
     * @param  string|null $paymentReference __BT-83, From BASIC WL__ A text value used to link the payment to the invoice issued by the seller
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToCreditTransfer(string $payeeIban, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null, ?string $paymentReference = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType(ZugferdPaymentMeans::UNTDID_4461_58);
        $payeefinancialaccount = $this->getObjectHelper()->getCreditorFinancialAccountType($payeeIban, $payeeAccountName, $payeePropId);
        $payeefinancialInstitution = $this->getObjectHelper()->getCreditorFinancialInstitutionType($payeeBic);

        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeePartyCreditorFinancialAccount", $payeefinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeeSpecifiedCreditorFinancialInstitution", $payeefinancialInstitution);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        if (!is_null($paymentReference)) {
            $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setPaymentReference", $this->getObjectHelper()->getIdType($paymentReference));
        }

        return $this;
    }

    /**
     * Sets the document payment means to _Non-SEPA Credit Transfer_
     *
     * @param  string      $payeeIban        __BT-84, From BASIC WL__ A unique identifier for the financial account held with a payment service provider to which the payment should be made
     * @param  string|null $payeeAccountName __BT-85, From BASIC WL__ The name of the payment account held with a payment service provider to which the payment should be made
     * @param  string|null $payeePropId      __BT-BT-84-0, From BASIC WL__ National account number (not for SEPA)
     * @param  string|null $payeeBic         __BT-86, From EN 16931__ An identifier for the payment service provider with which the payment account is held
     * @param  string|null $paymentReference __BT-83, From BASIC WL__ A text value used to link the payment to the invoice issued by the seller
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToCreditTransferNonSepa(string $payeeIban, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null, ?string $paymentReference = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType(ZugferdPaymentMeans::UNTDID_4461_30);
        $payeefinancialaccount = $this->getObjectHelper()->getCreditorFinancialAccountType($payeeIban, $payeeAccountName, $payeePropId);
        $payeefinancialInstitution = $this->getObjectHelper()->getCreditorFinancialInstitutionType($payeeBic);

        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeePartyCreditorFinancialAccount", $payeefinancialaccount);
        $this->getObjectHelper()->tryCall($paymentMeans, "setPayeeSpecifiedCreditorFinancialInstitution", $payeefinancialInstitution);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        if (!is_null($paymentReference)) {
            $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setPaymentReference", $this->getObjectHelper()->getIdType($paymentReference));
        }

        return $this;
    }

    /**
     * Sets the document payment means to _SEPA Direct Debit_
     *
     * @param  string      $buyerIban           __BT-91, From BASIC WL__ The account to be debited by the direct debit
     * @param  string|null $creditorReferenceID __BT-90, From BASIC WL__ Unique bank identifier of the payee or the seller assigned by the bank of the payee or the seller
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToDirectDebit(string $buyerIban, ?string $creditorReferenceID = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType(ZugferdPaymentMeans::UNTDID_4461_59);
        $buyerfinancialaccount = $this->getObjectHelper()->getDebtorFinancialAccountType($buyerIban);

        $this->getObjectHelper()->tryCall($paymentMeans, "setPayerPartyDebtorFinancialAccount", $buyerfinancialaccount);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        if (!is_null($creditorReferenceID)) {
            $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setCreditorReferenceID", $this->getObjectHelper()->getIdType($creditorReferenceID));
        }

        return $this;
    }

    /**
     * Sets the document payment means to _Non-SEPA Direct Debit_
     *
     * @param  string      $buyerIban           __BT-91, From BASIC WL__ The account to be debited by the direct debit
     * @param  string|null $creditorReferenceID __BT-90, From BASIC WL__ Unique bank identifier of the payee or the seller assigned by the bank of the payee or the seller
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToDirectDebitNonSepa(string $buyerIban, ?string $creditorReferenceID = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType(ZugferdPaymentMeans::UNTDID_4461_49);
        $buyerfinancialaccount = $this->getObjectHelper()->getDebtorFinancialAccountType($buyerIban);

        $this->getObjectHelper()->tryCall($paymentMeans, "setPayerPartyDebtorFinancialAccount", $buyerfinancialaccount);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        if (!is_null($creditorReferenceID)) {
            $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setCreditorReferenceID", $this->getObjectHelper()->getIdType($creditorReferenceID));
        }

        return $this;
    }

    /**
     * Sets the document payment means to _Payment card_
     *
     * @param  string      $cardType       __BT-, From __ The type of the card
     * @param  string      $cardId         __BT-87, From EN 16931__ The primary account number (PAN) to which the card used for payment belongs. In accordance with card payment security standards, an invoice should never contain a full payment card master account number. The following specification of the PCI Security Standards Council currently applies: The first 6 and last 4 digits at most are to be displayed
     * @param  string|null $cardHolderName __BT-88, From EN 16931__ Name of the payment card holder
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentMeanToPaymentCard(string $cardType, string $cardId, ?string $cardHolderName = null): ZugferdDocumentBuilder
    {
        $paymentMeans = $this->getObjectHelper()->getTradeSettlementPaymentMeansType(ZugferdPaymentMeans::UNTDID_4461_48);
        $financialCard = $this->getObjectHelper()->getTradeSettlementFinancialCardType($cardType, $cardId, $cardHolderName);

        $this->getObjectHelper()->tryCall($paymentMeans, "setApplicableTradeSettlementFinancialCard", $financialCard);
        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeSettlementPaymentMeans", $paymentMeans);

        return $this;
    }

    /**
     * Add a VAT breakdown (at document level)
     *
     * @param  string                 $categoryCode               __BT-118, From BASIC WL__ Coded description of a sales tax category
     *                                                            The following entries from UNTDID 5305 are used (details in
     *                                                            brackets): - Standard rate (sales tax is due according to the
     *                                                            normal procedure) - Goods to be taxed according to the zero rate
     *                                                            (sales tax is charged with a percentage of zero) - Tax exempt
     *                                                            (USt./IGIC/IPSI) - Reversal of the tax liability (the rules for
     *                                                            reversing the tax liability at USt./IGIC/IPSI apply) - VAT exempt
     *                                                            for intra-community deliveries of goods (USt./IGIC/IPSI not levied
     *                                                            due to rules on intra-community deliveries) - Free export item, tax
     *                                                            not levied (VAT / IGIC/IPSI not levied due to export outside the
     *                                                            EU) - Services outside the tax scope (sales are not subject to VAT
     *                                                            / IGIC/IPSI) - Canary Islands general indirect tax (IGIC tax
     *                                                            applies) - IPSI (tax for Ceuta / Melilla) applies. The codes for
     *                                                            the VAT category are as follows: - S = sales tax is due at the
     *                                                            normal rate - Z = goods to be taxed according to the zero rate - E
     *                                                            = tax exempt - AE = reversal of tax liability - K = VAT is not
     *                                                            shown for intra-community deliveries - G = tax not levied due to
     *                                                            export outside the EU - O = Outside the tax scope - L = IGIC
     *                                                            (Canary Islands) - M = IPSI (Ceuta / Melilla)
     * @param  string                 $typeCode                   __BT-118-0, From BASIC WL__ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float                  $basisAmount                __BT-116, From BASIC WL__ Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float                  $calculatedAmount           __BT-117, From BASIC WL__ The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying the amount to be taxed according to the sales tax category by the sales tax rate applicable for the sales tax category concerned
     * @param  float|null             $rateApplicablePercent      __BT-119, From BASIC WL__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  string|null            $exemptionReason            __BT-120, From BASIC WL__ Reason for tax exemption (free text)
     * @param  string|null            $exemptionReasonCode        __BT-121, From BASIC WL__ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility.
     * @param  float|null             $lineTotalBasisAmount       __BT-X-262, From EXTENDED__ An amount used as the basis for calculating sales tax, duty or customs duty
     * @param  float|null             $allowanceChargeBasisAmount __BT-X-263, From EXTENDED__ Total amount Additions and deductions to the tax rate at document level
     * @param  DateTimeInterface|null $taxPointDate               __BT-7-00, From EN 16931__ Date on which tax is due. This is not used in Germany. Instead, the delivery and service date must be specified.
     * @param  string|null            $dueDateTypeCode            __BT-8, From BASIC WL__ The code for the date on which the VAT becomes relevant for settlement for the seller and for the buyer
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentTax(string $categoryCode, string $typeCode, float $basisAmount, float $calculatedAmount, ?float $rateApplicablePercent = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null, ?float $lineTotalBasisAmount = null, ?float $allowanceChargeBasisAmount = null, ?DateTimeInterface $taxPointDate = null, ?string $dueDateTypeCode = null): ZugferdDocumentBuilder
    {
        $tax = $this->getObjectHelper()->getTradeTaxType($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, $lineTotalBasisAmount, $allowanceChargeBasisAmount, $taxPointDate, $dueDateTypeCode);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToApplicableTradeTax", $tax);

        return $this;
    }

    /**
     * Add a VAT breakdown (at document level) in a more simple way
     *
     * @param  string     $categoryCode          __BT-118, From BASIC WL__ Coded description of a sales tax category
     *                                           The following entries from UNTDID 5305 are used (details in
     *                                           brackets): - Standard rate (sales tax is due according to the
     *                                           normal procedure) - Goods to be taxed according to the zero rate
     *                                           (sales tax is charged with a percentage of zero) - Tax exempt
     *                                           (USt./IGIC/IPSI) - Reversal of the tax liability (the rules for
     *                                           reversing the tax liability at USt./IGIC/IPSI apply) - VAT exempt
     *                                           for intra-community deliveries of goods (USt./IGIC/IPSI not levied
     *                                           due to rules on intra-community deliveries) - Free export item, tax
     *                                           not levied (VAT / IGIC/IPSI not levied due to export outside the
     *                                           EU) - Services outside the tax scope (sales are not subject to VAT
     *                                           / IGIC/IPSI) - Canary Islands general indirect tax (IGIC tax
     *                                           applies) - IPSI (tax for Ceuta / Melilla) applies. The codes for
     *                                           the VAT category are as follows: - S = sales tax is due at the
     *                                           normal rate - Z = goods to be taxed according to the zero rate - E
     *                                           = tax exempt - AE = reversal of tax liability - K = VAT is not
     *                                           shown for intra-community deliveries - G = tax not levied due to
     *                                           export outside the EU - O = Outside the tax scope - L = IGIC
     *                                           (Canary Islands) - M = IPSI (Ceuta / Melilla)
     * @param  string     $typeCode              __BT-118-0, From BASIC WL__ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float      $basisAmount           __BT-116, From BASIC WL__ Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float      $calculatedAmount      __BT-117, From BASIC WL__ The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying the amount to be taxed according to the sales tax category by the sales tax rate applicable for the sales tax category concerned
     * @param  float|null $rateApplicablePercent __BT-119, From BASIC WL__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentTaxSimple(string $categoryCode, string $typeCode, float $basisAmount, float $calculatedAmount, ?float $rateApplicablePercent = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentTax($categoryCode, $typeCode, $basisAmount, $calculatedAmount, $rateApplicablePercent);
    }

    /**
     * Get detailed information on the billing period
     *
     * @param  DateTimeInterface|null $startDate   __BT-73, From BASIC WL__ Start of the billing period
     * @param  DateTimeInterface|null $endDate     __BT-74, From BASIC WL__ End of the billing period
     * @param  string|null            $description __BT-X-264, From EXTENDED__ Further information of the billing period (Obsolete)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentBillingPeriod(?DateTimeInterface $startDate, ?DateTimeInterface $endDate, ?string $description): ZugferdDocumentBuilder
    {
        $period = $this->getObjectHelper()->getSpecifiedPeriodType($startDate, $endDate, null, $description);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setBillingSpecifiedPeriod", $period);

        return $this;
    }

    /**
     * Add information about surcharges and charges applicable to the bill as a whole, Deductions,
     * such as for withheld taxes may also be specified in this group
     *
     * @param float       $actualAmount          __BT-92/BT-99, From BASIC WL__ Amount of the surcharge or discount at document level
     * @param boolean     $isCharge              __BT-20-1/BT-21-1, From BASIC WL__ Switch that indicates whether the following data refer to an surcharge or a discount, true means that this an charge
     * @param string      $taxCategoryCode       __BT-95/BT-102, From BASIC WL__ A coded indication of which sales tax category applies to the surcharge or deduction at document level
     *
     *                                           The following entries from UNTDID 5305 are used (details in brackets):
     *                                           - Standard rate (sales tax is due according to the normal procedure)
     *                                           - Goods to be taxed according to the zero rate (sales tax is charged with a percentage of zero)
     *                                           - Tax exempt (USt./IGIC/IPSI)
     *                                           - Reversal of the tax liability (the rules for reversing the tax liability at USt./IGIC/IPSI apply)
     *                                           - VAT exempt for intra-community deliveries of goods (USt./IGIC/IPSI not levied due to rules on intra-community deliveries)
     *                                           - Free export item, tax not levied (VAT / IGIC/IPSI not levied due to export outside the EU)
     *                                           - Services outside the tax scope (sales are not subject to VAT / IGIC/IPSI)
     *                                           - Canary Islands general indirect tax (IGIC tax applies)
     *                                           - IPSI (tax for Ceuta / Melilla) applies.
     *
     *                                           The codes for the VAT category are as follows:
     *                                           - S = sales tax is due at the normal rate
     *                                           - Z = goods to be taxed according to the zero rate
     *                                           - E = tax exempt
     *                                           - AE = reversal of tax liability
     *                                           - K = VAT is not shown for intra-community deliveries
     *                                           - G = tax not levied due to export outside the EU
     *                                           - O = Outside the tax scope
     *                                           - L = IGIC (Canary Islands)
     *                                           - M = IPSI (Ceuta/Melilla)
     *
     * @param string      $taxTypeCode           __BT-95-0/BT-102-0, From BASIC WL__ Code for the VAT category of the surcharge or charge at document level. Note: Fixed value = "VAT"
     * @param float       $rateApplicablePercent __BT-96/BT-103, From BASIC WL__ VAT rate for the surcharge or discount on document level. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param float|null  $sequence              __BT-X-265, From EXTENDED__ Calculation order
     * @param float|null  $calculationPercent    __BT-94/BT-101, From BASIC WL__ Percentage surcharge or discount at document level
     * @param float|null  $basisAmount           __BT-93/BT-100, From BASIC WL__ The base amount that may be used in conjunction with the percentage of the surcharge or discount at document level to calculate the amount of the discount at document level
     * @param float|null  $basisQuantity         __BT-X-266, From EXTENDED__ Base quantity of the discount
     * @param string|null $basisQuantityUnitCode __BT-X-267, From EXTENDED__ Unit of the price base quantity
     * @param string|null $reasonCode            __BT-98/BT-105, From BASIC WL__ The reason given as a code for the surcharge or discount at document level. Note: Use entries from the UNTDID 5189 code list. The code of the reason for the surcharge or discount at document level and the reason for the surcharge or discount at document level must correspond to each other
     *
     *                                           Code list: UNTDID 7161 Complete list, code list: UNTDID 5189 Restricted
     *                                           Include PEPPOL subset:
     *                                           - 41 - Bonus for works ahead of schedule
     *                                           - 42 - Other bonus
     *                                           - 60 - Manufacturer’s consumer discount
     *                                           - 62 - Due to military status
     *                                           - 63 - Due to work accident
     *                                           - 64 - Special agreement
     *                                           - 65 - Production error discount
     *                                           - 66 - New outlet discount
     *                                           - 67 - Sample discount
     *                                           - 68 - End-of-range discount
     *                                           - 70 - Incoterm discount
     *                                           - 71 - Point of sales threshold allowance
     *                                           - 88 - Material surcharge/deduction
     *                                           - 95 - Discount
     *                                           - 100 - Special rebate
     *                                           - 102 - Fixed long term
     *                                           - 103 - Temporary
     *                                           - 104 - Standard
     *                                           - 105 - Yearly turnover
     *
     * @param  string|null $reason                __BT-97/BT-104, From BASIC WL__ The reason given in text form for the surcharge or discount at document level
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentAllowanceCharge(float $actualAmount, bool $isCharge, string $taxCategoryCode, string $taxTypeCode, ?float $rateApplicablePercent, ?float $sequence = null, ?float $calculationPercent = null, ?float $basisAmount = null, ?float $basisQuantity = null, ?string $basisQuantityUnitCode = null, ?string $reasonCode = null, ?string $reason = null): ZugferdDocumentBuilder
    {
        $allowanceCharge = $this->getObjectHelper()->getTradeAllowanceChargeType($actualAmount, $isCharge, $taxTypeCode, $taxCategoryCode, $rateApplicablePercent, $sequence, $calculationPercent, $basisAmount, $basisQuantity, $basisQuantityUnitCode, $reasonCode, $reason);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedTradeAllowanceCharge", $allowanceCharge);

        return $this;
    }

    /**
     * Add detailed information on logistics service fees
     *
     * @param  string     $description            __BT-X-271, From EXTENDED__ Identification of the service fee
     * @param  float      $appliedAmount          __BT-X-272, From EXTENDED__ Amount of the service fee
     * @param  array|null $taxTypeCodes           __BT-X-273-0, From EXTENDED__ Code of the Tax type. Note: Fixed value = "VAT"
     * @param  array|null $taxCategoryCodes       __BT-X-273, From EXTENDED__ Code of the VAT category
     * @param  array|null $rateApplicablePercents __BT-X-274, From EXTENDED__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentLogisticsServiceCharge(string $description, float $appliedAmount, ?array $taxTypeCodes = null, ?array $taxCategoryCodes = null, ?array $rateApplicablePercents = null): ZugferdDocumentBuilder
    {
        $logcharge = $this->getObjectHelper()->getLogisticsServiceChargeType($description, $appliedAmount, $taxTypeCodes, $taxCategoryCodes, $rateApplicablePercents);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "addToSpecifiedLogisticsServiceCharge", $logcharge);

        return $this;
    }

    /**
     * Add a payment term
     *
     * @param  string|null            $description          __BT-20, From _BASIC WL__ A text description of the payment terms that apply to the payment amount due (including a description of possible penalties). Note: This element can contain multiple lines and multiple conditions.
     * @param  DateTimeInterface|null $dueDate              __BT-9, From BASIC WL__ The date by which payment is due Note: The payment due date reflects the net payment due date. In the case of partial payments, this indicates the first due date of a net payment. The corresponding description of more complex payment terms can be given in BT-20.
     * @param  string|null            $directDebitMandateID __BT-89, From BASIC WL__ Unique identifier assigned by the payee to reference the direct debit authorization.
     * @param  float|null             $partialPaymentAmount __BT-X-275, From EXTENDED__ Amount of the partial payment
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentTerm(?string $description = null, ?DateTimeInterface $dueDate = null, ?string $directDebitMandateID = null, ?float $partialPaymentAmount = null): ZugferdDocumentBuilder
    {
        $paymentTerms = $this->getObjectHelper()->getTradePaymentTermsType($description, $dueDate, $directDebitMandateID, $partialPaymentAmount);

        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToSpecifiedTradePaymentTerms", "setSpecifiedTradePaymentTerms"], $paymentTerms);

        $this->currentPaymentTerms = $paymentTerms;

        return $this;
    }

    /**
     * Add discount Terms to last added payment term
     *
     * @param  float|null             $calculationPercent         __BT-X-286, From EXTENDED__ Percentage of the down payment
     * @param  DateTimeInterface|null $basisDateTime              __BT-X-282, From EXTENDED__ Due date reference date
     * @param  float|null             $basisPeriodMeasureValue    __BT-X-283, From EXTENDED__ Maturity period (basis)
     * @param  string|null            $basisPeriodMeasureUnitCode __BT-X-284, From EXTENDED__ Maturity period (unit)
     * @param  float|null             $basisAmount                __BT-X-285, From EXTENDED__ Base amount of the payment discount
     * @param  float|null             $actualDiscountAmount       __BT-X-287, From EXTENDED__ Amount of the payment discount
     * @return ZugferdDocumentBuilder
     */
    public function addDiscountTermsToPaymentTerms(?float $calculationPercent = null, ?DateTimeInterface $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $actualDiscountAmount = null): ZugferdDocumentBuilder
    {
        $discountTerms = $this->getObjectHelper()->getTradePaymentDiscountTermsType($basisDateTime, $basisPeriodMeasureValue, $basisPeriodMeasureUnitCode, $basisAmount, $calculationPercent, $actualDiscountAmount);

        $this->getObjectHelper()->tryCall($this->currentPaymentTerms, "setApplicableTradePaymentDiscountTerms", $discountTerms);

        return $this;
    }

    /**
     * Add penalty Terms to last added payment term
     *
     * @param  float|null             $calculationPercent         __BT-X-280, From EXTENDED__ Percentage of the payment surcharge
     * @param  DateTimeInterface|null $basisDateTime              __BT-X-276, From EXTENDED__ Due date reference date
     * @param  float|null             $basisPeriodMeasureValue    __BT-X-277, From EXTENDED__ Maturity period (basis)
     * @param  string|null            $basisPeriodMeasureUnitCode __BT-X-278, From EXTENDED__ Maturity period (unit)
     * @param  float|null             $basisAmount                __BT-X-279, From EXTENDED__ Basic amount of the payment surcharge
     * @param  float|null             $actualPenaltyAmount        __BT-X-281, From EXTENDED__ Amount of the payment surcharge
     * @return ZugferdDocumentBuilder
     */
    public function addPenaltyTermsToPaymentTerms(?float $calculationPercent = null, ?DateTimeInterface $basisDateTime = null, ?float $basisPeriodMeasureValue = null, ?string $basisPeriodMeasureUnitCode = null, ?float $basisAmount = null, ?float $actualPenaltyAmount = null): ZugferdDocumentBuilder
    {
        $penaltyTerms = $this->getObjectHelper()->getTradePaymentPenaltyTermsType($basisDateTime, $basisPeriodMeasureValue, $basisPeriodMeasureUnitCode, $basisAmount, $calculationPercent, $actualPenaltyAmount);

        $this->getObjectHelper()->tryCall($this->currentPaymentTerms, "setApplicableTradePaymentPenaltyTerms", $penaltyTerms);

        return $this;
    }

    /**
     * Add a payment term in XRechnung-Style (in the Form #SKONTO#TAGE=14#PROZENT=1.00#BASISBETRAG=2.53#)
     *
     * @param  string                 $description                __BT-20, From _EN 16931 XRECHNUNG__ Text to add
     * @param  int[]                  $paymentDiscountDays        __BT-20, BR-DE-18, From _EN 16931 XRECHNUNG__ Array of Payment discount days (array of integer)
     * @param  float[]                $paymentDiscountPercents    __BT-20, BR-DE-18, From _EN 16931 XRECHNUNG__ Array of Payment discount percents (array of decimal)
     * @param  float[]                $paymentDiscountBaseAmounts __BT-20, BR-DE-18, From _EN 16931 XRECHNUNG__ Array of Payment discount base amounts (array of decimal)
     * @param  DateTimeInterface|null $dueDate                    __BT-9, From EN 16931 XRECHNUNG__ The date by which payment is due Note: The payment due date reflects the net payment due date. In the case of partial payments, this indicates the first due date of a net payment. The corresponding description of more complex payment terms can be given in BT-20.
     * @param  string|null            $directDebitMandateID       __BT-89, From EN 16931 XRECHNUNG__ Unique identifier assigned by the payee to reference the direct debit authorization.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPaymentTermXRechnung(string $description, array $paymentDiscountDays = [], array $paymentDiscountPercents = [], array $paymentDiscountBaseAmounts = [], ?DateTimeInterface $dueDate = null, ?string $directDebitMandateID = null): ZugferdDocumentBuilder
    {
        $paymentTermsDescription = [];

        if ($this->getObjectHelper()->isNullOrEmpty($description)) {
            return $this;
        }

        $paymentDiscountDays = array_filter(
            $paymentDiscountDays,
            function ($k) use ($paymentDiscountPercents) {
                return isset($paymentDiscountPercents[$k]);
            },
            ARRAY_FILTER_USE_KEY
        );

        if ($paymentDiscountDays === []) {
            return $this->addDocumentPaymentTerm(trim($description), $dueDate, $directDebitMandateID);
        }

        foreach ($paymentDiscountDays as $paymentDiscountDayIndex => $paymentDiscountDay) {
            $paymentTermsDescription[] =
                sprintf(
                    isset($paymentDiscountBaseAmounts[$paymentDiscountDayIndex])
                        ? "#SKONTO#TAGE=%s#PROZENT=%s#BASISBETRAG=%s#"
                        : "#SKONTO#TAGE=%s#PROZENT=%s#",
                    number_format($paymentDiscountDay, 0, ".", ""),
                    number_format($paymentDiscountPercents[$paymentDiscountDayIndex] ?? 0.0, 2, ".", ""),
                    number_format($paymentDiscountBaseAmounts[$paymentDiscountDayIndex] ?? 0.0, 2, ".", "")
                );
        }

        return $this->addDocumentPaymentTerm(
            trim(sprintf("%s\n%s", implode("\n", $paymentTermsDescription), $description)),
            $dueDate,
            $directDebitMandateID
        );
    }

    /**
     * Add information on the booking reference
     *
     * @param  string      $id       __BT-19, From BASIC WL__ Posting reference of the byuer. If required, this reference shall be provided by the Buyer to the Seller prior to the issuing of the Invoice.
     * @param  string|null $typeCode __BT-X-290, From EXTENDED__ Type of the posting reference. Allowed values: 1 = Financial, 2 = Subsidiary, 3 = Budget, 4 = Cost Accounting, 5 = Payable, 6 = Job Cost Accounting
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode = null): ZugferdDocumentBuilder
    {
        $account = $this->getObjectHelper()->getTradeAccountingAccountType($id, $typeCode);

        $this->getObjectHelper()->tryCallAll($this->headerTradeSettlement, ["addToReceivableSpecifiedTradeAccountingAccount", "setReceivableSpecifiedTradeAccountingAccount"], $account);

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
     * Document money summation
     *
     * @param  float      $grandTotalAmount     __BT-112, From MINIMUM__ Total invoice amount including sales tax
     * @param  float      $duePayableAmount     __BT-115, From MINIMUM__ Payment amount due
     * @param  float|null $lineTotalAmount      __BT-106, From BASIC WL__ Sum of the net amounts of all invoice items
     * @param  float|null $chargeTotalAmount    __BT-108, From BASIC WL__ Sum of the surcharges at document level
     * @param  float|null $allowanceTotalAmount __BT-107, From BASIC WL__ Sum of the discounts at document level
     * @param  float|null $taxBasisTotalAmount  __BT-109, From MINIMUM__ Total invoice amount excluding sales tax
     * @param  float|null $taxTotalAmount       __BT-110/111, From MINIMUM/BASIC WL__ if BT-6 is not null $taxTotalAmount = BT-111. Total amount of the invoice sales tax, Total tax amount in the booking currency
     * @param  float|null $roundingAmount       __BT-114, From EN 16931__ Rounding amount
     * @param  float|null $totalPrepaidAmount   __BT-113, From BASIC WL__ Prepayment amount
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentSummation(float $grandTotalAmount, float $duePayableAmount, ?float $lineTotalAmount = null, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxBasisTotalAmount = null, ?float $taxTotalAmount = null, ?float $roundingAmount = null, ?float $totalPrepaidAmount = null): ZugferdDocumentBuilder
    {
        $summation = $this->getObjectHelper()->getTradeSettlementHeaderMonetarySummationType($grandTotalAmount, $duePayableAmount, $lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxBasisTotalAmount, $taxTotalAmount, $roundingAmount, $totalPrepaidAmount);

        $this->getObjectHelper()->tryCall($this->headerTradeSettlement, "setSpecifiedTradeSettlementHeaderMonetarySummation", $summation);

        $taxTotalAmount = $this->getObjectHelper()->ensureArray($this->getObjectHelper()->tryCallAndReturn($summation, "getTaxTotalAmount"));

        if (isset($taxTotalAmount[0])) {
            $invoiceCurrencyCode = $this->getObjectHelper()->tryCallByPathAndReturn($this->headerTradeSettlement, "getInvoiceCurrencyCode.value");
            $this->getObjectHelper()->tryCall($taxTotalAmount[0], 'setCurrencyID', $invoiceCurrencyCode);
        }

        return $this;
    }

    /**
     * Adds a new position (line) to document
     *
     * @param string      $lineid               __BT-126, From BASIC__ Identification of the invoice item
     * @param string|null $lineStatusCode       __BT-X-7, From EXTENDED__ Indicates whether the invoice item contains prices that must be taken into account when calculating the invoice amount or whether only information is included.
     * @param string|null $lineStatusReasonCode __BT-X-8, From EXTENDED__ Adds the type to specify whether the invoice line is:
     *
     *                                          - DETAIL: detail (normal position)
     *                                          - GROUP: Subtotal
     *                                          - INFORMATION: Information only
     *
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
     * @param      string      $lineid               __BT-126, From BASIC__ Identification of the invoice item
     * @param      string|null $lineStatusCode       __BT-X-7, From EXTENDED__ Indicates whether the invoice item contains prices that must be taken into account when calculating the invoice amount or whether only information is included.
     * @param      string|null $lineStatusReasonCode __BT-X-8, From EXTENDED__ Adds the type to specify whether the invoice line is:
     * @return     ZugferdDocumentBuilder
     * @deprecated 1.0.75
     */
    public function addNewTextPosition(string $lineid, ?string $lineStatusCode = null, ?string $lineStatusReasonCode = null): ZugferdDocumentBuilder
    {
        $position = $this->getObjectHelper()->getSupplyChainTradeLineItemType($lineid, $lineStatusCode, $lineStatusReasonCode, true);

        $this->getObjectHelper()->tryCall($this->headerSupplyChainTradeTransaction, "addToIncludedSupplyChainTradeLineItem", $position);

        $this->currentPosition = $position;

        return $this;
    }

    /**
     * Add detailed information on the free text on the position.
     *
     * @param  string      $content     __BT-127, From BASIC__ A free text that contains unstructured information that is relevant to the invoice item
     * @param  string|null $contentCode __BT-X-9, From EXTENDED__ A code to classify the content of the free text of the invoice. The code is agreed bilaterally and must have the same meaning as BT-127.
     * @param  string|null $subjectCode __BT-X-10, From EXTENDED__ Code for qualifying the free text for the invoice item (Codelist UNTDID 4451)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionNote(?string $content, ?string $contentCode = null, ?string $subjectCode = null): ZugferdDocumentBuilder
    {
        $linedoc = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getAssociatedDocumentLineDocument");
        $note = $this->getObjectHelper()->getNoteType($content, $contentCode, $subjectCode);

        $this->getObjectHelper()->tryCallAll($linedoc, ["addToIncludedNote", "setIncludedNote"], $note);

        return $this;
    }

    /**
     * Adds product details to the last created position (line) in the document.
     *
     * @param  string      $name               __BT-153, From BASIC__ A name of the item (item name)
     * @param  string|null $description        __BT-154, From EN 16931__ A description of the item, the item description makes it possible to describe the item and its properties in more detail than is possible with the item name.
     * @param  string|null $sellerAssignedID   __BT-155, From EN 16931__ An identifier assigned to the item by the seller
     * @param  string|null $buyerAssignedID    __BT-156, From EN 16931__ An identifier assigned to the item by the buyer. The article number of the buyer is a clear, bilaterally agreed identification of the product. It can, for example, be the customer article number or the article number assigned by the manufacturer.
     * @param  string|null $globalIDType       __BT-157-1, From BASIC__ The scheme for $globalID
     * @param  string|null $globalID           __BT-157, From BASIC__ Identification of an article according to the registered scheme (Global identifier of the product, GTIN, ...)
     * @param  string|null $industryAssignedID __BT-X-309, From EXTENDED__ ID assigned by the industry to the contained referenced product
     * @param  string|null $modelID            __BT-X-533, From EXTENDED__ A unique model identifier for this product
     * @param  string|null $batchID            __BT-X-534. From EXTENDED__ Identification of the batch (lot) of the product
     * @param  string|null $brandName          __BT-X-535. From EXTENDED__ The brand name, expressed as text, for this product
     * @param  string|null $modelName          __BT-X-536. From EXTENDED__ Model designation of the product
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionProductDetails(string $name, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalIDType = null, ?string $globalID = null, ?string $industryAssignedID = null, ?string $modelID = null, ?string $batchID = null, ?string $brandName = null, ?string $modelName = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->getTradeProductType($name, $description, $sellerAssignedID, $buyerAssignedID, $globalIDType, $globalID, $industryAssignedID, $modelID, $batchID, $brandName, $modelName);

        $this->getObjectHelper()->tryCall($this->currentPosition, "setSpecifiedTradeProduct", $product);

        return $this;
    }

    /**
     * Add extra characteristics to the formerly added product.
     * Contains information about the characteristics of the goods and services invoiced.
     *
     * @param  string      $description          __BT-160, From EN 16931__ The name of the attribute or property of the product such as "Colour"
     * @param  string      $value                __BT-161, From EN 16931__ The value of the attribute or property of the product such as "Red"
     * @param  string|null $typeCode             __BT-X-11, From EXTENDED__ Type of product characteristic (code). The codes must be taken from the UNTDID 6313 codelist.
     * @param  float|null  $valueMeasure         __BT-X-12, From EXTENDED__ Value of the product property (numerical measured variable)
     * @param  string|null $valueMeasureUnitCode __BT-X-12-0, From EXTENDED__ Unit of measurement code
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionProductCharacteristic(string $description, string $value, ?string $typeCode = null, ?float $valueMeasure = null, ?string $valueMeasureUnitCode = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $productCharacteristic = $this->getObjectHelper()->getProductCharacteristicType($typeCode, $description, $valueMeasure, $valueMeasureUnitCode, $value);

        $this->getObjectHelper()->tryCall($product, "addToApplicableProductCharacteristic", $productCharacteristic);

        return $this;
    }

    /**
     * Add detailed information on product classification.
     *
     * @param  string      $classCode     __BT-158, From EN 16931__ Item classification identifier. Classification codes are used for grouping similar items that can serve different purposes, such as public procurement (according to the Common Procurement Vocabulary ([CPV]), e-commerce (UNSPSC), etc.
     * @param  string|null $className     __BT-X-138, From EXTENDED__ Name with which an article can be classified according to type or quality.
     * @param  string|null $listId        __BT-158-1, From EN 16931__ The identifier for the identification scheme of the item classification identifier. The identification scheme must be selected from the entries in UNTDID 7143 [6].
     * @param  string|null $listVersionId __BT-158-2, From EN 16931__ The version of the identification scheme
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionProductClassification(string $classCode, ?string $className = null, ?string $listId = null, ?string $listVersionId = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $productClassification = $this->getObjectHelper()->getProductClassificationType($classCode, $className, $listId, $listVersionId);

        $this->getObjectHelper()->tryCall($product, "addToDesignatedProductClassification", $productClassification);

        return $this;
    }

    /**
     * Add detailed information on included products. This information relates to the product that has just been added.
     *
     * @param  string      $name               __BT-X-18, From EXTENDED__ Name of the referenced product contained
     * @param  string|null $description        __BT-X-19, From EXTENDED__ Description of the included referenced product
     * @param  string|null $sellerAssignedID   __BT-X-16, From EXTENDED__ ID assigned by the seller of the contained referenced product
     * @param  string|null $buyerAssignedID    __BT-X-17, From EXTENDED__ ID of the referenced product assigned by the buyer
     * @param  string|null $globalID           __BT-X-15, From EXTENDED__ Global ID of the referenced product contained
     * @param  string|null $globalIDType       __BT-X-15-1, From EXTENDED__ Identification of the scheme
     * @param  float|null  $unitQuantity       __BT-X-20, From EXTENDED__ Quantity of the referenced product contained
     * @param  string|null $unitCode           __BT-X-20-1, From EXTENDED__ Unit code of Quantity of the referenced product contained
     * @param  string|null $industryAssignedID __BT-X-309, From EXTENDED__ ID of the referenced product contained assigned by the industry
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionReferencedProduct(string $name, ?string $description = null, ?string $sellerAssignedID = null, ?string $buyerAssignedID = null, ?string $globalID = null, ?string $globalIDType = null, ?float $unitQuantity = null, ?string $unitCode = null, ?string $industryAssignedID = null): ZugferdDocumentBuilder
    {
        $product = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedTradeProduct");
        $referencedProduct = $this->getObjectHelper()->getReferencedProductType($globalID, $globalIDType, $sellerAssignedID, $buyerAssignedID, $industryAssignedID, $name, $description, $unitQuantity, $unitCode);

        $this->getObjectHelper()->tryCall($product, "addToIncludedReferencedProduct", $referencedProduct);

        return $this;
    }

    /**
     * Sets the detailed information on the product origin.
     *
     * @param  string $country __BT-159, From EN 16931__ The code indicating the country the goods came from. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”.
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
     * Set details of a sales order reference.
     *
     * @param  string                 $issuerAssignedId __BT-X-537, From EXTENDED__ Document number of a sales order reference
     * @param  string                 $lineId           __BT-X-538, From EXTENDED__ An identifier for a position within a sales order.
     * @param  DateTimeInterface|null $issueDate        __BT-X-539, From EXTENDED__ Date of sales order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionSellerOrderReferencedDocument(string $issuerAssignedId, string $lineId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $sellerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");

        $this->getObjectHelper()->tryCall($positionagreement, "setSellerOrderReferencedDocument", $sellerorderrefdoc);

        return $this;
    }

    /**
     * Set details of the related buyer order position.
     *
     * @param  string                 $issuerAssignedId __BT-X-21, From EXTENDED__ An identifier issued by the buyer for a referenced order (order number)
     * @param  string                 $lineId           __BT-132, From EN 16931__ An identifier for a position within an order placed by the buyer. Note: Reference is made to the order reference at the document level.
     * @param  DateTimeInterface|null $issueDate        __BT-X-22, From EXTENDED__ Date of order
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionBuyerOrderReferencedDocument(string $issuerAssignedId, string $lineId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $buyerorderrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");

        $this->getObjectHelper()->tryCall($positionagreement, "setBuyerOrderReferencedDocument", $buyerorderrefdoc);

        return $this;
    }

    /**
     * Set details of the associated offer position.
     *
     * @param  string                 $issuerAssignedId __BT-X-310, From EXTENDED__ Offer number
     * @param  string                 $lineId           __BT-X-311, From EXTENDED__ Position identifier within the offer
     * @param  DateTimeInterface|null $issueDate        __BT-X-312, From EXTENDED__ Date of offder
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionQuotationReferencedDocument(string $issuerAssignedId, string $lineId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $quotationrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");

        $this->getObjectHelper()->tryCall($positionagreement, "setQuotationReferencedDocument", $quotationrefdoc);

        return $this;
    }

    /**
     * Set details of the related contract position.
     *
     * @param  string                 $issuerAssignedId __BT-X-24, From EXTENDED__ The contract reference should be assigned once in the context of the specific trade relationship and for a defined period of time (contract number)
     * @param  string                 $lineId           __BT-X-25, From EXTENDED__ Identifier of the according contract position
     * @param  DateTimeInterface|null $issueDate        __BT-X-26, From EXTENDED__ Contract date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionContractReferencedDocument(string $issuerAssignedId, string $lineId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $contractrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");

        $this->getObjectHelper()->tryCall($positionagreement, "setContractReferencedDocument", $contractrefdoc);

        return $this;
    }

    /**
     * Add an additional Document reference on a position.
     *
     * The documents justifying the invoice can be used to reference a document number, which should be
     * known to the recipient, as well as an external document (referenced by a URL) or an embedded document (such
     * as a timesheet as a PDF file). The option of linking to an external document is e.g. required when it comes
     * to large attachments and / or sensitive information, e.g. for personal services, which must be separated
     * from the bill
     *
     * @param  string                 $issuerAssignedId   __BT-X-27, From EXTENDED__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string                 $typeCode           __BT-X-30, From EXTENDED__ Type of referenced document (See codelist UNTDID 1001)
     * @param  string|null            $uriId              __BT-X-28, From EXTENDED__ The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document must be used if the buyer needs additional information to support the amounts billed. External documents are not part of the invoice. Access to external documents can involve certain risks.
     * @param  string|null            $lineId             __BT-X-29, From EXTENDED__ The referenced position identifier in the additional document
     * @param  string|null            $name               __BT-X-299, From EXTENDED__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null            $refTypeCode        __BT-X-32, From EXTENDED__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTimeInterface|null $issueDate          __BT-X-33, From EXTENDED__ Document date
     * @param  string|null            $binaryDataFilename __BT-X-31, From EXTENDED__ Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionAdditionalReferencedDocument(string $issuerAssignedId, string $typeCode, ?string $uriId = null, ?string $lineId = null, ?string $name = null, ?string $refTypeCode = null, ?DateTimeInterface $issueDate = null, ?string $binaryDataFilename = null): ZugferdDocumentBuilder
    {
        $addrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, $uriId, $lineId, $typeCode, $name, $refTypeCode, $issueDate, $binaryDataFilename);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");

        $this->getObjectHelper()->tryCall($positionagreement, "addToAdditionalReferencedDocument", $addrefdoc);

        return $this;
    }

    /**
     * Add a referennce of a associated end customer order.
     *
     * @param  string                 $issuerAssignedId __BT-X-43, From EXTENDED__ Order number of the end customer
     * @param  string                 $lineId           __BT-X-44, From EXTENDED__ Order item (end customer)
     * @param  DateTimeInterface|null $issueDate        __BT-X-45, From EXTENDED__ Document date of end customer order
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateCustomerOrderReferencedDocument(string $issuerAssignedId, string $lineId, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $ultimaterefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);
        $positionagreement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeAgreement");

        $this->getObjectHelper()->tryCall($positionagreement, "addToUltimateCustomerOrderReferencedDocument", $ultimaterefdoc);

        return $this;
    }

    /**
     * Set the unit price excluding sales tax before deduction of the discount on the item price.
     *
     * @param  float       $amount                __BT-148, From BASIC__ The unit price excluding sales tax before deduction of the discount on the item price. If the price is shown according to the net calculation, the price must also be shown according to the gross calculation.
     * @param  float|null  $basisQuantity         __BT-149-1, From BASIC__ The number of item units for which the price applies (price base quantity)
     * @param  string|null $basisQuantityUnitCode __BT-150-1, From BASIC__ The unit code of the number of item units for which the price applies (price base quantity)
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
     * Detailed information on surcharges and discounts on item gross price.
     *
     * @param  float       $actualAmount          __BT-147, From BASIC__ Discount on the item price. The total discount subtracted from the gross price to calculate the net price. Note: Only applies if the discount is given per unit and is not included in the gross price.
     * @param  boolean     $isCharge              __BT-147-02, From BASIC__ Switch for surcharge/discount, if true then its an charge
     * @param  float|null  $calculationPercent    __BT-X-34, From EXTENDED__Discount/surcharge in percent. Up to level EN16931, only the final result of the discount (ActualAmount) is transferred
     * @param  float|null  $basisAmount           __BT-X-35, From EXTENDED__ Base amount of the discount/surcharge
     * @param  string|null $reason                __BT-X-36, From EXTENDED__ Reason for surcharge/discount (free text)
     * @param  string|null $taxTypeCode           __BT-, From BASIC__
     * @param  string|null $taxCategoryCode       __BT-, From BASIC__
     * @param  float|null  $rateApplicablePercent __BT-, From BASIC__
     * @param  float|null  $sequence              __BT-, From BASIC__
     * @param  float|null  $basisQuantity         __BT-, From BASIC__
     * @param  string|null $basisQuantityUnitCode __BT-, From BASIC__
     * @param  string|null $reasonCode            __BT-X-313, From EXTENDED__ Reason code for surcharge/discount
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
     * Set detailed information on the net price of the item.
     *
     * @param  float       $amount                __BT-146, From BASIC__ Net price of the item
     * @param  float|null  $basisQuantity         __BT-149, From BASIC__ Base quantity at the item price
     * @param  string|null $basisQuantityUnitCode __BT-150, From BASIC__ Code of the unit of measurement of the base quantity at the item price
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
     * Tax included for B2C on position level.
     *
     * @param  string      $categoryCode          __BT-, From __ Coded description of a sales tax category
     * @param  string      $typeCode              __BT-, From __ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float       $rateApplicablePercent __BT-, From __ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float       $calculatedAmount      __BT-, From __ The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying the amount to be taxed according to the sales tax category by the sales tax rate applicable for the sales tax category concerned
     * @param  string|null $exemptionReason       __BT-, From __ Reason for tax exemption (free text)
     * @param  string|null $exemptionReasonCode   __BT-, From __ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility.
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
     * Set the position Quantity.
     *
     * @param  float       $billedQuantity             __BT-129, From BASIC__ The quantity of individual items (goods or services) billed in the relevant line
     * @param  string      $billedQuantityUnitCode     __BT-130, From BASIC__ The unit of measure applicable to the amount billed
     * @param  float|null  $chargeFreeQuantity         __BT-X-46, From EXTENDED__ Quantity, free of charge
     * @param  string|null $chargeFreeQuantityUnitCpde __BT-X-46-0, From EXTENDED__ Unit of measure code for the quantity free of charge
     * @param  float|null  $packageQuantity            __BT-X-47, From EXTENDED__ Number of packages
     * @param  string|null $packageQuantityUnitCode    __BT-X-47-0, From EXTENDED__ Unit of measure code for number of packages
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
     * Set detailed information on the different ship-to party at position level.
     *
     * @param  string|null $name        __BT-X-50, From EXTENDED__ The name of the party to whom the goods are being delivered or for whom the services are being performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  string|null $id          __BT-X-48, From EXTENDED__ An identifier for the place where the goods are delivered or where the services are provided. Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party (Obsolete)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipTo(?string $name = null, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->getTradePartyAllowEmpty($name, $id, $description);

        $this->getObjectHelper()->tryCall($positiondelivery, "setShipToTradeParty", $shipToTradeParty);

        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party at position level.
     *
     * @param  string|null $globalID     __BT-X-49, From EXTENDED__ The identifier is uniquely assigned to a party by a global registration organization.
     * @param  string|null $globalIDType __BT-X-49-0, From EXTENDED__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * Add Tax registration to Ship-To Trade party at position level.
     *
     * @param  string|null $taxRegType __BT-X-66-0, From EXTENDED__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-X-66, From EXTENDED__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party at position level.
     *
     * @param  string|null $lineOne     __BG-X-59, From EXTENDED__ The main line in the product end users address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BG-X-60, From EXTENDED__ Line 2 of the product end users address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BG-X-61, From EXTENDED__ Line 3 of the product end users address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BG-X-58, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BG-X-62, From EXTENDED__ Usual name of the city or municipality in which the product end users address is located
     * @param  string|null $country     __BG-X-63, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BG-X-64, From EXTENDED__ The product end users state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party on position level.
     *
     * @param  string|null $legalOrgId   __BT-X-51, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-51-0, From EXTENDED__ Registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-52, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the Ship-To party on position level.
     *
     * @param  string|null $contactPersonName     __BT-X-54, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-54-1, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-55, From EXTENDED__ Detailed information on the party's phone number
     * @param  string|null $contactFaxNo          __BT-X-56, From EXTENDED__ Detailed information on the party's fax number
     * @param  string|null $contactEmailAddress   __BT-X-57, From EXTENDED__ Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($shipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an additional contact to the Ship-To party on position level.
     *
     * @param  string|null $contactPersonName     __BT-X-54, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-54-1, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-55, From EXTENDED__ Detailed information on the party's phone number
     * @param  string|null $contactFaxNo          __BT-X-56, From EXTENDED__ Detailed information on the party's fax number
     * @param  string|null $contactEmailAddress   __BT-X-57, From EXTENDED__ Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($shipToTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Detailed information on the different end recipient on position level.
     *
     * @param  string|null $name        __BT-X-69, From EXTENDED__ The name of the party to whom the goods are being delivered or for whom the services are being performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  string|null $id          __BT-X-67, From EXTENDED__ An identifier for the party Multiple IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party (Obsolete)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipTo(?string $name = null, ?string $id = null, ?string $description = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $shipToTradeParty = $this->getObjectHelper()->getTradePartyAllowEmpty($name, $id, $description);

        $this->getObjectHelper()->tryCall($positiondelivery, "setUltimateShipToTradeParty", $shipToTradeParty);

        return $this;
    }

    /**
     * Add a global id for the Ship-to Trade Party on position level.
     *
     * @param  string|null $globalID     __BT-X-68, From EXTENDED__ Global identifier of the parfty
     * @param  string|null $globalIDType __BT-X-68-0, From EXTENDED__ Type of global identification number, must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * Add Tax registration to Ship-To Trade party on position level.
     *
     * @param  string|null $taxRegType __BT-X-84-0, From EXTENDED__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string|null $taxRegId   __BT-X-84, From EXTENDED__ Tax number or sales tax identification number
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToTaxRegistration(?string $taxRegType = null, ?string $taxRegId = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $taxReg = $this->getObjectHelper()->getTaxRegistrationType($taxRegType, $taxRegId);

        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "addToSpecifiedTaxRegistration", $taxReg);

        return $this;
    }

    /**
     * Sets the postal address of the Ship-To party on position level.
     *
     * @param  string|null $lineOne     __BT_X-77, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT_X-78, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT_X-79, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT_X-76, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT_X-80, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT_X-81, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  string|null $subDivision __BT_X-82, From EXTENDED__ The party's state
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToAddress(?string $lineOne = null, ?string $lineTwo = null, ?string $lineThree = null, ?string $postCode = null, ?string $city = null, ?string $country = null, ?string $subDivision = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $address = $this->getObjectHelper()->getTradeAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "setPostalTradeAddress", $address);

        return $this;
    }

    /**
     * Set legal organisation of the Ship-To party on position level.
     *
     * @param  string|null $legalOrgId   __BT_X-70, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT_X-70-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT_X-71, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToLegalOrganisation(?string $legalOrgId, ?string $legalOrgType, ?string $legalOrgName): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $legalOrg = $this->getObjectHelper()->getLegalOrganization($legalOrgId, $legalOrgType, $legalOrgName);

        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "setSpecifiedLegalOrganization", $legalOrg);

        return $this;
    }

    /**
     * Set contact of the Ship-To party on position level.
     *
     * @param  string|null $contactPersonName     __BT_X-72, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT_X-72-1, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT_X-73, From EXTENDED__ Detailed information on the party's phone number
     * @param  string|null $contactFaxNo          __BT_X-74, From EXTENDED__ Detailed information on the party's fax number
     * @param  string|null $contactEmailAddress   __BT_X-75, From EXTENDED__ Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionUltimateShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCallIfMethodExists($ultimateShipToTradeParty, "addToDefinedTradeContact", "setDefinedTradeContact", [$contact], $contact);

        return $this;
    }

    /**
     * Add an additional contact of the Ship-To party on position level.
     *
     * @param  string|null $contactPersonName     __BT_X-72, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT_X-72-1, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT_X-73, From EXTENDED__ Detailed information on the party's phone number
     * @param  string|null $contactFaxNo          __BT_X-74, From EXTENDED__ Detailed information on the party's fax number
     * @param  string|null $contactEmailAddress   __BT_X-75, From EXTENDED__ Detailed information on the party's email address
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionUltimateShipToContact(?string $contactPersonName, ?string $contactDepartmentName, ?string $contactPhoneNo, ?string $contactFaxNo, ?string $contactEmailAddress): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $ultimateShipToTradeParty = $this->getObjectHelper()->tryCallAndReturn($positiondelivery, "getUltimateShipToTradeParty");
        $contact = $this->getObjectHelper()->getTradeContact($contactPersonName, $contactDepartmentName, $contactPhoneNo, $contactFaxNo, $contactEmailAddress);

        $this->getObjectHelper()->tryCall($ultimateShipToTradeParty, "addToDefinedTradeContact", $contact);

        return $this;
    }

    /**
     * Detailed information on the actual delivery on position level.
     *
     * @param  DateTimeInterface|null $date __BT-X-85, From EXTENDED__ Actual delivery date
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionSupplyChainEvent(?DateTimeInterface $date): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $supplyChainevent = $this->getObjectHelper()->getSupplyChainEventType($date);

        $this->getObjectHelper()->tryCall($positiondelivery, "setActualDeliverySupplyChainEvent", $supplyChainevent);

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on position level.
     *
     * @param  string                 $issuerAssignedId __BT-X-86, From EXTENDED__ Shipping notification number
     * @param  string|null            $lineId           __BT-X-87, From EXTENDED__ Shipping notification position
     * @param  DateTimeInterface|null $issueDate        __BT-X-88, From EXTENDED__ Date of Shipping notification number
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionDespatchAdviceReferencedDocument(string $issuerAssignedId, ?string $lineId = null, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $despatchddvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($positiondelivery, "setDespatchAdviceReferencedDocument", $despatchddvicerefdoc);

        return $this;
    }

    /**
     * Detailed information on the associated goods receipt notification.
     *
     * @param  string                 $issuerAssignedId __BT-X-89, From EXTENDED__ Goods receipt number
     * @param  string|null            $lineId           __BT-X-90, From EXTENDED__ Goods receipt position
     * @param  DateTimeInterface|null $issueDate        __BT-X-91, From EXTENDED__ Date of Goods receipt
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionReceivingAdviceReferencedDocument(string $issuerAssignedId, ?string $lineId = null, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $receivingadvicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($positiondelivery, "setReceivingAdviceReferencedDocument", $receivingadvicerefdoc);

        return $this;
    }

    /**
     * Detailed information on the associated delivery bill on position level.
     *
     * @param  string                 $issuerAssignedId __BT-X-92, From EXTENDED__ Delivery note number
     * @param  string|null            $lineId           __BT-X-93, From EXTENDED__ Delivery note position
     * @param  DateTimeInterface|null $issueDate        __BT-X-94, From EXTENDED__ Date of Delivery note
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionDeliveryNoteReferencedDocument(string $issuerAssignedId, ?string $lineId = null, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $positiondelivery = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeDelivery");
        $deliverynoterefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineId, null, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($positiondelivery, "setDeliveryNoteReferencedDocument", $deliverynoterefdoc);

        return $this;
    }

    /**
     * Add information about the sales tax that applies to the goods and services invoiced in the relevant invoice line.
     *
     * @param  string      $categoryCode          __BT-151, From BASIC__ Coded description of a sales tax category
     * @param  string      $typeCode              __BT-151-0, From BASIC__ In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for the tax type must then be taken from the code list UNTDID 5153.
     * @param  float       $rateApplicablePercent __BT-152, From BASIC__ The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales tax category and the category-specific sales tax rate  must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null  $calculatedAmount      __BT-, From __ Tax amount. Information only for taxes that are not VAT (Obsolete)
     * @param  string|null $exemptionReason       __BT-, From __ Reason for tax exemption (free text) (Obsolete)
     * @param  string|null $exemptionReasonCode   __BT-, From __ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility. (Obsolete)
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionTax(string $categoryCode, string $typeCode, ?float $rateApplicablePercent, ?float $calculatedAmount = null, ?string $exemptionReason = null, ?string $exemptionReasonCode = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $tax = $this->getObjectHelper()->getTradeTaxType($categoryCode, $typeCode, null, $calculatedAmount, $rateApplicablePercent, $exemptionReason, $exemptionReasonCode, null, null, null, null);

        $this->getObjectHelper()->tryCallAll($positionsettlement, ["addToApplicableTradeTax", "setApplicableTradeTax"], $tax);

        return $this;
    }

    /**
     * Set information about the period relevant for the invoice item. Also known as the invoice line delivery period.
     *
     * @param  DateTimeInterface|null $startDate __BT-134, From BASIC__ Start of the billing period
     * @param  DateTimeInterface|null $endDate   __BT-135, From BASIC__ End of the billing period
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionBillingPeriod(?DateTimeInterface $startDate, ?DateTimeInterface $endDate): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $period = $this->getObjectHelper()->getSpecifiedPeriodType($startDate, $endDate, null, null);

        $this->getObjectHelper()->tryCall($positionsettlement, "setBillingSpecifiedPeriod", $period);

        return $this;
    }

    /**
     * Add surcharges and discounts on position level.
     *
     * @param  float       $actualAmount       __BT-136/BT-141, From BASIC__ The surcharge/discount amount excluding sales tax
     * @param  boolean     $isCharge           __BT-27-1/BT-28-1, From BASIC__ (true for BT-/ and false for /BT-) Switch that indicates whether the following data refer to an allowance or a discount, true means that it is a surcharge
     * @param  float|null  $calculationPercent __BT-138, From BASIC__ The percentage that may be used in conjunction with the base invoice line discount amount to calculate the invoice line discount amount
     * @param  float|null  $basisAmount        __BT-137, From EN 16931__ The base amount that may be used in conjunction with the invoice line discount percentage to calculate the invoice line discount amount
     * @param  string|null $reasonCode         __BT-140/BT-145, From BASIC__ The reason given as a code for the invoice line discount
     * @param  string|null $reason             __BT-139/BT-144, From BASIC__ The reason given in text form for the invoice item discount/surcharge
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
     * Set information on item totals.
     *
     * @param  float $lineTotalAmount __BT-131, From BASIC__ The total amount of the invoice item.
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionLineSummation(float $lineTotalAmount): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $summation = $this->getObjectHelper()->getTradeSettlementLineMonetarySummationType($lineTotalAmount);

        $this->getObjectHelper()->tryCall($positionsettlement, "setSpecifiedTradeSettlementLineMonetarySummation", $summation);

        return $this;
    }

    /**
     * Set information on item totals (with support for EXTENDED profile).
     *
     * @param  float $lineTotalAmount            __BT-131, From BASIC__ The total amount of the invoice item
     * @param  float $chargeTotalAmount          __BT-X-327, From EXTENDED__ Total amount of item surcharges
     * @param  float $allowanceTotalAmount       __BT-X-328, From EXTENDED__ Total amount of item discounts
     * @param  float $taxTotalAmount             __BT-X-329, From EXTENDED__ Total amount of item taxes
     * @param  float $grandTotalAmount           __BT-X-330, From EXTENDED__ Total gross amount of the item
     * @param  float $totalAllowanceChargeAmount __BT-X-98, From EXTENDED__ Total amount of item surcharges and discounts
     * @return ZugferdDocumentBuilder
     */
    public function setDocumentPositionLineSummationExt(float $lineTotalAmount, ?float $chargeTotalAmount = null, ?float $allowanceTotalAmount = null, ?float $taxTotalAmount = null, ?float $grandTotalAmount = null, ?float $totalAllowanceChargeAmount = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $summation = $this->getObjectHelper()->getTradeSettlementLineMonetarySummationType($lineTotalAmount, $chargeTotalAmount, $allowanceTotalAmount, $taxTotalAmount, $grandTotalAmount, $totalAllowanceChargeAmount);

        $this->getObjectHelper()->tryCall($positionsettlement, "setSpecifiedTradeSettlementLineMonetarySummation", $summation);

        return $this;
    }

    /**
     * Add a Reference to the previous invoice (on position level).
     *
     * To be used if:
     *  - a previous invoice is corrected
     *  - reference is made from a final invoice to previous partial invoices
     *  - reference is made from a final invoice to previous invoices for advance payments.     *
     *
     * @param  string                 $issuerAssignedId __BT-X-331, From EXTENDED__ The identification of an invoice previously sent by the seller
     * @param  string                 $lineid           __BT-X-540, From EXTENDED__ Identification of the invoice item
     * @param  string|null            $typeCode         __BT-X-332, From EXTENDED__ Type of previous invoice (code)
     * @param  DateTimeInterface|null $issueDate        __BT-X-333, From EXTENDED__ Date of the previous invoice
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionInvoiceReferencedDocument(string $issuerAssignedId, string $lineid, ?string $typeCode = null, ?DateTimeInterface $issueDate = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $invoicerefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, $lineid, $typeCode, null, null, $issueDate, null);

        $this->getObjectHelper()->tryCall($positionsettlement, "setInvoiceReferencedDocument", $invoicerefdoc);

        return $this;
    }

    /**
     * Add an additional Document reference on a position (Object detection).
     *
     * @param      string      $issuerAssignedId __BT-128, From EN 16931__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param      string      $typeCode         __BT-128-0, From EN 16931__ Type of referenced document (See codelist UNTDID 1001)
     * @param      string|null $refTypeCode      __BT-128-1, From EN 16931__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @return     ZugferdDocumentBuilder
     * @deprecated v1.0.110 Please use addDocumentPositionAdditionalReferencedObjDocument instead
     */
    public function addDocumentPositionAdditionalReferencedDocumentObj(string $issuerAssignedId, string $typeCode, ?string $refTypeCode = null): ZugferdDocumentBuilder
    {
        return $this->addDocumentPositionAdditionalReferencedObjDocument($issuerAssignedId, $typeCode, $refTypeCode);
    }

    /**
     * Add an additional Document reference on a position (Object detection).
     *
     * @param  string      $issuerAssignedId __BT-128, From EN 16931__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string      $typeCode         __BT-128-0, From EN 16931__ Type of referenced document (See codelist UNTDID 1001)
     * @param  string|null $refTypeCode      __BT-128-1, From EN 16931__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionAdditionalReferencedObjDocument(string $issuerAssignedId, string $typeCode, ?string $refTypeCode = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $addrefdoc = $this->getObjectHelper()->getReferencedDocumentType($issuerAssignedId, null, null, $typeCode, null, $refTypeCode, null, null);

        $this->getObjectHelper()->tryCallAll($positionsettlement, ["addToAdditionalReferencedDocument", "setAdditionalReferencedDocument"], $addrefdoc);

        return $this;
    }

    /**
     * Add an AccountingAccount on position level.
     *
     * @param  string      $id       __BT-133, From EN 16931__ Posting reference of the byuer. If required, this reference shall be provided by the Buyer to the Seller prior to the issuing of the Invoice.
     * @param  string|null $typeCode __BT-X-99, From EXTENDED__ Type of the posting reference. Allowed values: 1 = Financial, 2 = Subsidiary, 3 = Budget, 4 = Cost Accounting, 5 = Payable, 6 = Job Cost Accounting
     * @return ZugferdDocumentBuilder
     */
    public function addDocumentPositionReceivableSpecifiedTradeAccountingAccount(string $id, ?string $typeCode = null): ZugferdDocumentBuilder
    {
        $positionsettlement = $this->getObjectHelper()->tryCallAndReturn($this->currentPosition, "getSpecifiedLineTradeSettlement");
        $account = $this->getObjectHelper()->getTradeAccountingAccountType($id, $typeCode);

        $this->getObjectHelper()->tryCallAll($positionsettlement, ["addToReceivableSpecifiedTradeAccountingAccount", "setReceivableSpecifiedTradeAccountingAccount"], $account);

        return $this;
    }
}
