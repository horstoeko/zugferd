<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use Closure;
use DateTime;
use horstoeko\stringmanagement\FileUtils;
use horstoeko\stringmanagement\PathUtils;
use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use horstoeko\zugferd\exception\ZugferdUnknownDateFormatException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use horstoeko\zugferd\ZugferdProfileResolver;
use JMS\Serializer\Exception\RuntimeException;

/**
 * Class representing the document reader for incoming XML-Documents with
 * XML data in BASIC-, EN16931- and EXTENDED profile
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentReader extends ZugferdDocument
{
    /**
     * Internal pointer for documents additional documents
     *
     * @var integer
     */
    private $documentAddRefDocPointer = 0;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $documentUltimateCustomerOrderReferencedDocumentPointer = 0;

    /**
     * Internal pointer for documents allowance charges
     *
     * @var integer
     */
    private $documentAllowanceChargePointer = 0;

    /**
     * Internal pointer for documents logistic service charges
     *
     * @var integer
     */
    private $documentLogisticServiceChargePointer = 0;

    /**
     * Internal pointer for documents payment terms
     *
     * @var integer
     */
    private $documentPaymentTermsPointer = 0;

    /**
     * Internal pointer for document payment means
     *
     * @var integer
     */
    private $documentPaymentMeansPointer = 0;

    /**
     * Internal pointer for the document taxes
     *
     * @var integer
     */
    private $documentTaxPointer = 0;

    /**
     * Internal pointer for seller contacts
     *
     * @var integer
     */
    private $documentSellerContactPointer = 0;

    /**
     * Internal pointer for byuer contacts
     *
     * @var integer
     */
    private $documentBuyerContactPointer = 0;

    /**
     * Internal pointer for seller tax representativ party contacts
     *
     * @var integer
     */
    private $documentSellerTaxRepresentativeContactPointer = 0;

    /**
     * Internal pointer for product enduser contacts
     *
     * @var integer
     */
    private $documentProductEndUserContactPointer = 0;

    /**
     * Internal pointer for Ship-To contacts
     *
     * @var integer
     */
    private $documentShipToContactPointer = 0;

    /**
     * Internal pointer for Ultimate-Ship-To contacts
     *
     * @var integer
     */
    private $documentUltimateShipToContactPointer = 0;

    /**
     * Internal pointer for Ship-From contacts
     *
     * @var integer
     */
    private $documentShipFromContactPointer = 0;

    /**
     * Internal pointer for invoicer contacts
     *
     * @var integer
     */
    private $documentInvoicerContactPointer = 0;

    /**
     * Internal pointer for invoicee contacts
     *
     * @var integer
     */
    private $documentInvoiceeContactPointer = 0;

    /**
     * Internal pointer for payee contacts
     *
     * @var integer
     */
    private $documentPayeeContactPointer = 0;

    /**
     * Internal pointer for documents invoice reference documents
     *
     * @var integer
     */
    private $documentInvRefDocPointer = 0;

    /**
     * Internal pointer for documents trade accounting accounts
     *
     * @var integer
     */
    private $documentTradeAccountingAccountPointer = 0;

    /**
     * Internal pointer for the position
     *
     * @var integer
     */
    private $positionPointer = 0;

    /**
     * Internal pointer for the position note
     *
     * @var integer
     */
    private $positionNotePointer = 0;

    /**
     * Internal pointer for the position's gross price allowances/charges
     *
     * @var integer
     */
    private $positionGrossPriceAllowanceChargePointer = 0;

    /**
     * Internal pointer for the position taxes
     *
     * @var integer
     */
    private $positionTaxPointer = 0;

    /**
     * Internal pointer for the position's allowances/charges
     *
     * @var integer
     */
    private $positionAllowanceChargePointer = 0;

    /**
     * Internal pointer for the position's additional referenced document
     *
     * @var integer
     */
    private $positionAddRefDocPointer = 0;

    /**
     * Internal pointer for the position's additional referenced document (Object reference)
     *
     * @var integer
     */
    private $positionAddRefObjDocPointer = 0;

    /**
     * Internal pointer for the positions product characteristics
     *
     * @var integer
     */
    private $positionProductCharacteristicPointer = 0;

    /**
     * Internal pointer for the positions product classification
     *
     * @var integer
     */
    private $positionProductClassificationPointer = 0;

    /**
     * Internal pointer for the positions referenced product
     *
     * @var integer
     */
    private $positionReferencedProductPointer = 0;

    /**
     * @var string
     */
    private $binarydatadirectory = "";

    /**
     * Guess the profile type of a xml file.
     *
     * @param  string $xmlFilename
     * @return ZugferdDocumentReader
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws RuntimeException
     */
    public static function readAndGuessFromFile(string $xmlFilename): ZugferdDocumentReader
    {
        if (!file_exists($xmlFilename)) {
            throw new ZugferdFileNotFoundException($xmlFilename);
        }

        $xmlContent = file_get_contents($xmlFilename);

        if ($xmlContent === false) {
            throw new ZugferdFileNotReadableException($xmlFilename);
        }

        return self::readAndGuessFromContent($xmlContent);
    }

    /**
     * Guess the profile type of the readden xml document.
     *
     * @param  string $xmlContent The XML content as a string to read the invoice data from
     * @return ZugferdDocumentReader
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileParameterException
     * @throws RuntimeException
     */
    public static function readAndGuessFromContent(string $xmlContent): ZugferdDocumentReader
    {
        $profileId = ZugferdProfileResolver::resolveProfileId($xmlContent);

        return (new static($profileId))->readContent($xmlContent);
    }

    /**
     * Set the directory where the attached binary data from additional referenced documents are temporary stored.
     *
     * @param  string $binaryDataDirectory
     * @return ZugferdDocumentReader
     */
    public function setBinaryDataDirectory(string $binaryDataDirectory): ZugferdDocumentReader
    {
        if ($binaryDataDirectory !== '' && $binaryDataDirectory !== '0' && is_dir($binaryDataDirectory)) {
            $this->binarydatadirectory = $binaryDataDirectory;
        }

        return $this;
    }

    /**
     * Read content of a zuferd/xrechnung xml from a string.
     *
     * @param  string $xmlContent The XML content as a string to read the invoice data from
     * @return ZugferdDocumentReader
     * @throws ZugferdUnknownProfileParameterException
     * @throws RuntimeException
     */
    protected function readContent(string $xmlContent): ZugferdDocumentReader
    {
        $this->deserialize($xmlContent);

        return $this;
    }

    /**
     * Read general information about the document.
     *
     * @param  string|null   $documentNo               __BT-1, From MINIMUM__ The document no issued by the seller
     * @param  string|null   $documentTypeCode         __BT-3, From MINIMUM__ The type of the document, See \horstoeko\codelists\ZugferdInvoiceType for details
     * @param  DateTime|null $documentDate             __BT-2, From MINIMUM__ Date of invoice. The date when the document was issued by the seller
     * @param  string|null   $invoiceCurrency          __BT-5, From MINIMUM__ Code for the invoice currency
     * @param  string|null   $taxCurrency              __BT-6, From BASIC WL__ Code for the currency of the VAT entry
     * @param  string|null   $documentName             __BT-X-2, From EXTENDED__ Document Type. The documenttype (free text)
     * @param  string|null   $documentLanguage         __BT-X-4, From EXTENDED__ Language indicator. The language code in which the document was written
     * @param  DateTime|null $effectiveSpecifiedPeriod __BT-X-6-000, From EXTENDED__ The contractual due date of the invoice
     * @return ZugferdDocumentReader
     * @throws ZugferdUnknownDateFormatException
     */
    public function getDocumentInformation(?string &$documentNo, ?string &$documentTypeCode, ?DateTime &$documentDate, ?string &$invoiceCurrency, ?string &$taxCurrency, ?string &$documentName, ?string &$documentLanguage, ?DateTime &$effectiveSpecifiedPeriod): ZugferdDocumentReader
    {
        $documentNo = $this->getInvoiceValueByPath("getExchangedDocument.getID.value", "");
        $documentTypeCode = $this->getInvoiceValueByPath("getExchangedDocument.getTypeCode.value", "");
        $documentDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString.getFormat", "")
        );
        $invoiceCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");
        $taxCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getTaxCurrencyCode.value", "");
        $documentName = $this->getInvoiceValueByPath("getExchangedDocument.getName.value", "");
        $documentLanguage = $this->getInvoiceValueByPath("getExchangedDocument.getLanguageID.value", "");
        $effectiveSpecifiedPeriod = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Read general payment information.
     *
     * @param  string|null $creditorReferenceID __BT-90, From BASIC WL__ Identifier of the creditor
     * @param  string|null $paymentReference    __BT-83, From BASIC WL__ Intended use for payment
     * @return ZugferdDocumentReader
     */
    public function getDocumentGeneralPaymentInformation(?string &$creditorReferenceID, ?string &$paymentReference): ZugferdDocumentReader
    {
        $creditorReferenceID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getCreditorReferenceID.value", "");
        $paymentReference = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPaymentReference.value", "") ?? "";

        return $this;
    }

    /**
     * Get the identifier assigned by the buyer and used for internal routing.
     *
     * @param  string|null $buyerReference __BT-10, From MINIMUM__ An identifier assigned by the buyer and used for internal routing
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerReference(?string &$buyerReference): ZugferdDocumentReader
    {
        $buyerReference = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerReference.value", "");

        return $this;
    }

    /**
     * Get the routing-id (needed for German XRechnung).
     *
     * This is an alias-method for getDocumentBuyerReference.
     *
     * @param  string $routingId __BT-10, From MINIMUM__ An identifier assigned by the buyer and used for internal routing
     * @return ZugferdDocumentReader
     */
    public function getDocumentRoutingId(string $routingId): ZugferdDocumentReader
    {
        return $this->getDocumentBuyerReference($routingId);
    }

    /**
     * Get the copy-identifier.
     *
     * @param  boolean|null $copyIndicator __BT-X-3-00, BT-X-3, From EXTENDED__ Returns true if this document is a copy from the original document
     * @return ZugferdDocumentReader
     */
    public function getIsDocumentCopy(?bool &$copyIndicator): ZugferdDocumentReader
    {
        $copyIndicator = $this->getInvoiceValueByPath("getExchangedDocument.getCopyIndicator.getIndicator", false);

        return $this;
    }

    /**
     * Get the test-docukent-identifier.
     *
     * @param  boolean|null $testDocumentIndicator Returns true if this document is only for test purposes
     * @return ZugferdDocumentReader
     */
    public function getIsTestDocument(?bool &$testDocumentIndicator): ZugferdDocumentReader
    {
        $testDocumentIndicator = $this->getInvoiceValueByPath("getExchangedDocumentContext.getTestIndicator.getIndicator", false);

        return $this;
    }

    /**
     * Retrieve document notes.
     *
     * @param  array|null $notes __BT-22, From BASIC WL__, __BT-X-5, From EXTENDED__, __BT-21, From BASIC WL__ Returns an array with all document notes. Each array element contains an assiociative array containing the following keys: _contentcode_, _subjectcode_ and _content_
     * @return ZugferdDocumentReader
     */
    public function getDocumentNotes(?array &$notes): ZugferdDocumentReader
    {
        $notes = $this->getInvoiceValueByPath("getExchangedDocument.getIncludedNote", []);
        $notes = $this->convertToArray(
            $notes,
            [
                "contentcode" => ["getContentCode.value", ""],
                "subjectcode" => ["getSubjectCode.value", ""],
                "content" => ["getContent.value", ""],
            ]
        );

        return $this;
    }

    /**
     * Get detailed information about the seller (=service provider).
     *
     * @param  string|null $name        __BT-27, From MINIMUM__ The full formal name under which the seller is registered in the National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param  array|null  $id          __BT-29, From BASIC WL__ An array of identifiers of the seller. In many systems, seller identification is key information. Multiple seller IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param  string|null $description __BT-33, From EN 16931__ Further legal information that is relevant for the seller
     * @return ZugferdDocumentReader
     */
    public function getDocumentSeller(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifiers of the seller.
     *
     * @param  array|null $globalID __BT-29/BT-29-0/BT-29-1, From BASIC WL__ Array of the sellers global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on the seller's tax information.
     *
     * @param  array|null $taxReg _BT-31/32, From MINIMUM/EN 16931__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of seller trade party.
     *
     * @param  string|null $lineOne     __BT-35, From BASIC WL__ The main line in the sellers address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-36, From BASIC WL__ Line 2 of the seller's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-162, From BASIC WL__ Line 3 of the seller's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-38, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-37, From BASIC WL__ Usual name of the city or municipality in which the seller's address is located
     * @param  string|null $country     __BT-40, From MINIMUM__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-39, From BASIC WL__ The sellers state
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of seller trade party.
     *
     * @param  string|null $legalOrgId   __BT-30, From MINIMUM__ An identifier issued by an official registrar that identifies the seller as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer and seller
     * @param  string|null $legalOrgType __BT-30-1, From MINIMUM__ The identifier for the identification scheme of the legal registration of the seller. If the identification scheme is used, it must be selected from ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-28, From BASIC WL__ A name by which the seller is known, if different from the seller's name (also known as the company name). Note: This may be used if different from the seller's name.
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first seller contact of the document. Returns true if a first seller contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact.
     *
     * @return boolean
     */
    public function firstDocumentSellerContact(): bool
    {
        $this->documentSellerContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentSellerContactPointer]);
    }

    /**
     * Seek to the next available seller contact of the document. Returns true if another seller contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact.
     *
     * @return boolean
     */
    public function nextDocumentSellerContact(): bool
    {
        $this->documentSellerContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentSellerContactPointer]);
    }

    /**
     * Get detailed information on the seller's contact person.
     *
     * @param  string|null $contactPersonname     __BT-41, From EN 16931__ Such as personal name, name of contact person or department or office
     * @param  string|null $contactDepartmentname __BT-41-0, From EN 16931__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $contactPhoneNo        __BT-42, From EN 16931__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-107, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-43, From EN 16931__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerContact(?string &$contactPersonname, ?string &$contactDepartmentname, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentSellerContactPointer];

        $contactPersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the seller's electronic communication information.
     *
     * @param  string|null $uriScheme __BT-34-1, From BASIC WL__ The identifier for the identification scheme of the seller's electronic address
     * @param  string|null $uri       __BT-34, From BASIC WL__ Specifies the electronic address of the seller to which the response to the invoice can be sent at application level
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerCommunication(?string &$uriScheme, ?string &$uri): ZugferdDocumentReader
    {
        $uri = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getURIUniversalCommunication.getURIID.value", "");
        $uriScheme = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getURIUniversalCommunication.getURIID.getSchemeID", "");

        return $this;
    }

    /**
     * Get detailed information about the buyer (service recipient).
     *
     * @param  string|null $name        __BT-44, From MINIMUM__ The full name of the buyer
     * @param  array|null  $id          __BT-46, From BASIC WL__ An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param  string|null $description __BT-X-334, From EXTENDED__ Further legal information about the buyer
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyer(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifiers of the buyer.
     *
     * @param  array|null $globalID __BT-46-0, BT-46-1, From BASIC WL__ Array of the buyers global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on the buyer's tax information.
     *
     * @param  array|null $taxReg _BT-48, From MINIMUM/EN 16931__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of buyer trade party.
     *
     * @param  string|null $lineOne     __BT-50, From BASIC WL__ The main line in the buyers address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-51, From BASIC WL__ Line 2 of the buyers address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-163, From BASIC WL__ Line 3 of the buyers address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-53, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-52, From BASIC WL__ Usual name of the city or municipality in which the buyers address is located
     * @param  string|null $country     __BT-55, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-54, From BASIC WL__ The buyers state
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of buyer trade party.
     *
     * @param  string|null $legalOrgId   __BT-47, From MINIMUM__ An identifier issued by an official registrar that identifies the buyer as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer and buyer
     * @param  string|null $legalOrgType __BT-47-1, From MINIMUM__ The identifier for the identification scheme of the legal registration of the buyer. If the identification scheme is used, it must be selected from ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-45, From EN 16931__ A name by which the buyer is known, if different from the buyers name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first buyer contact of the document. Returns true if a first buyer contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentBuyerContact
     *
     * @return boolean
     */
    public function firstDocumentBuyerContact(): bool
    {
        $this->documentBuyerContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentBuyerContactPointer]);
    }

    /**
     * Seek to the next available Buyer contact of the document. Returns true if another Buyer contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentBuyerContact.
     *
     * @return boolean
     */
    public function nextDocumentBuyerContact(): bool
    {
        $this->documentBuyerContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentBuyerContactPointer]);
    }

    /**
     * Get contact information of buyer trade party.
     *
     * @param  string|null $contactPersonName     __BT-56, From EN 16931__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-56-0, From EN 16931__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-57, From EN 16931__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-115, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-58, From EN 16931__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentBuyerContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the seller's electronic communication information.
     *
     * @param  string|null $uriScheme __BT-49-1, From BASIC WL__ The identifier for the identification scheme of the buyer's electronic address
     * @param  string|null $uri       __BT-49, From BASIC WL__ Specifies the buyer's electronic address to which the invoice is sent
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerCommunication(?string &$uriScheme, ?string &$uri): ZugferdDocumentReader
    {
        $uri = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getURIUniversalCommunication.getURIID.value", "");
        $uriScheme = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getURIUniversalCommunication.getURIID.getSchemeID", "");

        return $this;
    }

    /**
     * Get detailed information about the seller's tax agent.
     *
     * @param  string|null $name        __BT-62, From BASIC WL__ The full name of the seller's tax agent
     * @param  array|null  $id          __BT-X-116, From EXTENDED__ An array of identifiers of the sellers tax agent.
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the sellers tax agent
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentative(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get document seller tax agent global ids.
     *
     * @param  array|null $globalID __BT-X-117/BT-X-117-1, From EXTENDED__ Returns an array of the seller's tax agent identifiers indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on the seller's tax agent tax information.
     *
     * @param  array|null $taxReg __BT-63/BT-63-0, From BASIC WL__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of sellers tax agent.
     *
     * @param  string|null $lineOne     __BT-64, From BASIC WL__ The main line in the sellers tax agent address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-65, From BASIC WL__ Line 2 of the sellers tax agent address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-164, From BASIC WL__ Line 3 of the sellers tax agent address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-67, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-66, From BASIC WL__ Usual name of the city or municipality in which the sellers tax agent address is located
     * @param  string|null $country     __BT-69, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-68, From BASIC WL__ The sellers tax agent state
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of sellers tax agent.
     *
     * @param  string|null $legalOrgId   __BT-, From __ An identifier issued by an official registrar that identifies the seller tax agent as a legal entity or legal person.
     * @param  string|null $legalOrgType __BT-, From __ The identifier for the identification scheme of the legal registration of the sellers tax agent. If the identification scheme is used, it must be selected from  ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-, From __ A name by which the sellers tax agent is known, if different from the  sellers tax agent name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first seller tax representative contact of the document. Returns true if a first Seller Tax Representative contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentSellerTaxRepresentativeContact.
     *
     * @return boolean
     */
    public function firstDocumentSellerTaxRepresentativeContact(): bool
    {
        $this->documentSellerTaxRepresentativeContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentSellerTaxRepresentativeContactPointer]);
    }

    /**
     * Seek to the next available seller tax representative contact of the document. Returns true if another seller contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact.
     *
     * @return boolean
     */
    public function nextDocumentSellerTaxRepresentativeContact(): bool
    {
        $this->documentSellerTaxRepresentativeContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentSellerTaxRepresentativeContactPointer]);
    }

    /**
     * Get contact information of sellers tax agent.
     *
     * @param  string|null $contactPersonName     __BT-X-120, From EXTENDED__ Such as personal name, name of contact person or department or office
     * @param  string|null $contactDepartmentName __BT-X-121, From EXTENDED__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $contactPhoneNo        __BT-X-122, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-123, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-124, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentSellerTaxRepresentativeContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the product end user (general information).
     *
     * @param  string      $name        __BT-X-128, From EXTENDED__ Name/company name of the end user
     * @param  array|null  $id          __BT-X-126, From EXTENDED__ An array of identifiers of the product end user
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the product end user
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUser(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifier of the product end user.
     *
     * @param  array|null $globalID __BT-X-127/BT-X-127-0, From EXTENDED__ Array of the product end users global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on the tax number of the product end user.
     *
     * @param  array|null $taxReg __BT-, From __ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of product end user.
     *
     * @param  string|null $lineOne     __BT-X-397, From EXTENDED__ The main line in the product end users address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-398, From EXTENDED__ Line 2 of the product end users address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-399, From EXTENDED__ Line 3 of the product end users address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-396, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-400, From EXTENDED__ Usual name of the city or municipality in which the product end users address is located
     * @param  string|null $country     __BT-X-401, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-X-402, From EXTENDED__ The product end users state
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of product end user.
     *
     * @param  string|null $legalOrgId   __BT-X-129, From EXTENDED__ An identifier issued by an official registrar that identifies the product end user as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to all trade parties
     * @param  string|null $legalOrgType __BT-X-129-0, From EXTENDED__The identifier for the identification scheme of the legal registration of the product end user. If the identification scheme is used, it must be selected from ISO/IEC 6523 list
     * @param  string|null $legalOrgName __BT-X-130, From EXTENDED__ A name by which the product end user is known, if different from the product end users name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first product end-user contact of the document. Returns true if a first product end-user contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentProductEndUserContact.
     *
     * @return boolean
     */
    public function firstDocumentProductEndUserContactContact(): bool
    {
        $this->documentProductEndUserContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentProductEndUserContactPointer]);
    }

    /**
     * Seek to the next available product end-user contact of the document. Returns true if another product end-user contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentProductEndUserContact.
     *
     * @return boolean
     */
    public function nextDocumentProductEndUserContactContact(): bool
    {
        $this->documentProductEndUserContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentProductEndUserContactPointer]);
    }

    /**
     * Get detailed information on the product end user's contact person.
     *
     * @param  string|null $contactPersonName     __BT-X-131, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-132, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-133, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-134, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-135, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentProductEndUserContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the Ship-To party.
     *
     * @param  string|null $name        __BT-70, From BASIC WL__ The name of the party to whom the goods are being delivered or for whom the services are being performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  array|null  $id          __BT-71, From BASIC WL__ An array of identifiers
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipTo(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifier for the Ship-To party.
     *
     * @param  array|null $globalID __BT-71-0/BT-71-1, From BASIC WL__ Array of global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the Ship-To party.
     *
     * @param  array|null $taxReg __BT-X-161/BT-X-161-0, From EXTENDED__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the postal address of the Ship-To party.
     *
     * @param  string|null $lineOne     __BT-75, From BASIC WL__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-76, From BASIC WL__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-165, From BASIC WL__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-78, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-77, From BASIC WL__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-80, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-79, From BASIC WL__ The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Ship-To trade party.
     *
     * @param  string|null $legalOrgid   __BT-X-153, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-153-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-154, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToLegalOrganisation(?string &$legalOrgid, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first Ship-To contact of the document. Returns true if a first ship-to contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentShipToContact.
     *
     * @return boolean
     */
    public function firstDocumentShipToContact(): bool
    {
        $this->documentShipToContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentShipToContactPointer]);
    }

    /**
     * Seek to the next available ship-to contact of the document. Returns true if another ship-to contact is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentShipToContact.
     *
     * @return boolean
     */
    public function nextDocumentShipToContact(): bool
    {
        $this->documentShipToContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentShipToContactPointer]);
    }

    /**
     * Get detailed information on the contact person of the goods recipient.
     *
     * @param  string|null $contactPersonName     __BT-X-155, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-156, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-157, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-158, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-159, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentShipToContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the different end recipient.
     *
     * @param  string|null $name        __BT-X-164, From EXTENDED__ Name or company name of the different end recipient
     * @param  array|null  $id          __BT-X-162, From EXTENDED__ An array of identifiers
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the different end recipient
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipTo(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getID.value", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifiers of the different end recipient party.
     *
     * @param  array|null $globalID __BT-X-163/BT-X-163-0, From EXTENDED__ Array of global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the different end recipient party.
     *
     * @param  array|null $taxReg __BT-X-180/BT-X-180-0, From EXTENDED__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get detailed information on the address of the different end recipient party.
     *
     * @param  string|null $lineOne     __BT-X-173, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box. For major customer addresses, this field must be filled with "-".
     * @param  string|null $lineTwo     __BT-X-174, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-175, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-172, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-176, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-177, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-X-178, From EXTENDED__ The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get detailed information about the Legal organisation of the different end recipient party.
     *
     * @param  string|null $legalOrgId   __BT-X-165, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-165-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-166, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact person of the different end recipient party. Returns true if a first contact person of the different end recipient party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentUltimateShipToContact.
     *
     * @return boolean
     */
    public function firstDocumentUltimateShipToContact(): bool
    {
        $this->documentUltimateShipToContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentUltimateShipToContactPointer]);
    }

    /**
     * Seek to the next available contact person of the different end recipient party. Returns true if another contact person of the different end recipient party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentUltimateShipToContact.
     *
     * @return boolean
     */
    public function nextDocumentUltimateShipToContact(): bool
    {
        $this->documentUltimateShipToContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentUltimateShipToContactPointer]);
    }

    /**
     * Get detailed information on the contact person of the different end recipient party.
     *
     * @param  string|null $contactPersonName     __BT-X-167, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-168, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-169, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-170, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-171, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentUltimateShipToContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information of the deviating consignor party.
     *
     * @param  string|null $name        __BT-X-183, From EXTENDED__ The name of the party
     * @param  array|null  $id          __BT-X-181, From EXTENDED__ An array of identifiers
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFrom(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifier of the deviating consignor party.
     *
     * @param  array|null $globalID __BT-X-182/BT-X-182-0, From EXTENDED__ Array of global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the deviating consignor party.
     *
     * @param  array|null $taxReg __BT-, From __ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the deviating consignor party.
     *
     * @param  string|null $lineOne     __BT-X-192, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-193, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-194, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-191, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-195, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-196, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-X-197, From EXTENDED__ The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCountryID.value.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the deviating consignor party.
     *
     * @param  string|null $legalOrgId   __BT-X-184, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-184-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-185, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the deviating consignor party of the document. Returns true if a first contact information of the deviating consignor party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentShipFromContact.
     *
     * @return boolean
     */
    public function firstDocumentShipFromContact(): bool
    {
        $this->documentShipFromContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentShipFromContactPointer]);
    }

    /**
     * Seek to the next available contact information of the deviating consignor party of the document. Returns true if another contact information of the deviating consignor party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentShipFromContact.
     *
     * @return boolean
     */
    public function nextDocumentShipFromContact(): bool
    {
        $this->documentShipFromContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentShipFromContactPointer]);
    }

    /**
     * Get contact information of the deviating consignor party.
     *
     * @param  string|null $contactPersonName     __BT-X-186, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-187, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-188, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-189, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-190, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentShipFromContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information of the invoicer party.
     *
     * @param  string      $name        __BT-X-207, From EXTENDED__ The name of the party
     * @param  array|null  $id          __BT-X-205, From EXTENDED__ An array of identifiers
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicer(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifier of the invoicer party.
     *
     * @param  array|null $globalID __BT-X-206/BT-X-206-0, From EXTENDED__ Array of global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the invoicer party.
     *
     * @param  array|null $taxReg __BT-, From __ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the invoicer party.
     *
     * @param  string|null $lineOne     __BT-X-216, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-217, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-218, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-215, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-219, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-220, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”
     * @param  array|null  $subDivision __BT-X-221, From EXTENDED__ The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the invoicer party.
     *
     * @param  string|null $legalOrgId   __BT-X-208, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-208-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,* 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-209, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the invoicer party of the document. Returns true if a first contact information of the invoicer party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentInvoicerContact.
     *
     * @return boolean
     */
    public function firstDocumentInvoicerContact(): bool
    {
        $this->documentInvoicerContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentInvoicerContactPointer]);
    }

    /**
     * Seek to the next available contact information of the invoicer party of the document. Returns true if another contact information of the invoicer party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentInvoicerContact.
     *
     * @return boolean
     */
    public function nextDocumentInvoicerContact(): bool
    {
        $this->documentInvoicerContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentInvoicerContactPointer]);
    }

    /**
     * Get contact information of the invoicer party.
     *
     * @param  string|null $contactPersonName     __BT-X-210, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-211, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-212, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-213, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-214, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentInvoicerContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the different invoice recipient party.
     *
     * @param  string      $name        __BT-X-226, From EXTENDED__ The name of the party
     * @param  array|null  $id          __BT-X-224, From EXTENDED__ An array of identifiers
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicee(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifier of the different invoice recipient party.
     *
     * @param  array|null $globalID __BT-X-225/BT-X-225-0, From EXTENDED__ Array of global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the different invoice recipient party.
     *
     * @param  array|null $taxReg __BT-X-242/BT-X-242-0, From EXTENDED__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the different invoice recipient party.
     *
     * @param  string|null $lineOne     __BT-X-235, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-236, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-237, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-234, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-238, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-239, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their
     *                                  subdivisions”
     * @param  array|null  $subDivision __BT-X-240, From EXTENDED__ The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the different invoice recipient party.
     *
     * @param  string|null $legalOrgId   __BT-X-227, From EXTENDED__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-X-227-0, From EXTENDED__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-228, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the different invoice recipient party of the document. Returns true if a first contact information of the different invoice recipient party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentInvoiceeContact.
     *
     * @return boolean
     */
    public function firstDocumentInvoiceeContact(): bool
    {
        $this->documentInvoiceeContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentInvoiceeContactPointer]);
    }

    /**
     * Seek to the next available contact information of the different invoice recipient party of the document. Returns true if another contact information of the different invoice recipient party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentInvoiceeContact.
     *
     * @return boolean
     */
    public function nextDocumentInvoiceeContact(): bool
    {
        $this->documentInvoiceeContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentInvoiceeContactPointer]);
    }

    /**
     * Get contact information of the different invoice recipient party.
     *
     * @param  string|null $contactPersonName     __BT-X-229, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-230, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-231, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-232, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-233, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentInvoiceeContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information about the payee, i.e. about the place that receives the payment.
     * The role of the payee may also be performed by a party other than the seller, e.g. by a factoring service.
     *
     * @param  string      $name        __BT-59, From BASIC WL__ The name of the party. Must be used if the payee is not the same as the seller. However, the name of the payee may match the name of the seller.
     * @param  array|null  $id          __BT-60, From BASIC WL__ An array of identifiers
     * @param  string|null $description __BT-, From __ Further legal information that is relevant for the party
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayee(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get global identifier of the payee party.
     *
     * @param  array|null $globalID __BT-60-0/BT-60-1, From BASIC WL__ Array of global ids indexed by the identification scheme.
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the payee party.
     *
     * @param  array|null $taxReg __BT-X-257/BT-X-257-0, From EXTENDED__ Array of tax numbers indexed by the schemeid (VA, FC, etc.)
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeTaxRegistration(?array &$taxReg): ZugferdDocumentReader
    {
        $taxReg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedTaxRegistration", []);
        $taxReg = $this->convertToAssociativeArray($taxReg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the payee party.
     *
     * @param  string|null $lineOne     __BT-X-250, From EXTENDED__ The main line in the party's address. This is usually the street name and house number or the post office box
     * @param  string|null $lineTwo     __BT-X-251, From EXTENDED__ Line 2 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $lineThree   __BT-X-252, From EXTENDED__ Line 3 of the party's address. This is an additional address line in an address that can be used to provide additional details in addition to the main line
     * @param  string|null $postCode    __BT-X-249, From EXTENDED__ Identifier for a group of properties, such as a zip code
     * @param  string|null $city        __BT-X-253, From EXTENDED__ Usual name of the city or municipality in which the party's address is located
     * @param  string|null $country     __BT-X-254, From EXTENDED__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their
     *                                  subdivisions”
     * @param  array|null  $subDivision __BT-X-255, From EXTENDED__ The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeAddress(?string &$lineOne, ?string &$lineTwo, ?string &$lineThree, ?string &$postCode, ?string &$city, ?string &$country, ?array &$subDivision): ZugferdDocumentReader
    {
        $lineOne = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $lineTwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $lineThree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subDivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the payee party.
     *
     * @param  string|null $legalOrgId   __BT-61, From BASIC WL__ An identifier issued by an official registrar that identifies the party as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or seller party
     * @param  string|null $legalOrgType __BT-61-1, From BASIC WL__ The identifier for the identification scheme of the legal registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalOrgName __BT-X-243, From EXTENDED__ A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeLegalOrganisation(?string &$legalOrgId, ?string &$legalOrgType, ?string &$legalOrgName): ZugferdDocumentReader
    {
        $legalOrgId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalOrgType = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalOrgName = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the payee party of the document. Returns true if a first contact information of the payee party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentPayeeContact.
     *
     * @return boolean
     */
    public function firstDocumentPayeeContact(): bool
    {
        $this->documentPayeeContactPointer = 0;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentPayeeContactPointer]);
    }

    /**
     * Seek to the next available contact information of the payee party of the document. Returns true if another contact information of the payee party is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentPayeeContact.
     *
     * @return boolean
     */
    public function nextDocumentPayeeContact(): bool
    {
        $this->documentPayeeContactPointer++;

        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact", []));

        return isset($contacts[$this->documentPayeeContactPointer]);
    }

    /**
     * Get contact information of the payee party.
     *
     * @param  string|null $contactPersonName     __BT-X-244, From EXTENDED__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $contactDepartmentName __BT-X-245, From EXTENDED__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $contactPhoneNo        __BT-X-246, From EXTENDED__ A telephone number for the contact point
     * @param  string|null $contactFaxNo          __BT-X-247, From EXTENDED__ A fax number of the contact point
     * @param  string|null $contactEmailAddress   __BT-X-248, From EXTENDED__ An e-mail address of the contact point
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeContact(?string &$contactPersonName, ?string &$contactDepartmentName, ?string &$contactPhoneNo, ?string &$contactFaxNo, ?string &$contactEmailAddress): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact", []));

        $contact = $contacts[$this->documentPayeeContactPointer];

        $contactPersonName = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactDepartmentName = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactPhoneNo = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactFaxNo = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactEmailAddress = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the delivery conditions.
     *
     * @param  string|null $code __BT-X-145, From EXTENDED__ The code indicating the type of delivery for these commercial delivery terms. To be selected from the entries in the list UNTDID 4053 + INCOTERMS
     * @return ZugferdDocumentReader
     */
    public function getDocumentDeliveryTerms(?string &$code): ZugferdDocumentReader
    {
        $code = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getApplicableTradeDeliveryTerms.getDeliveryTypeCode.value", "");

        return $this;
    }

    /**
     * Get details of the associated order confirmation.
     *
     * @param  string|null   $issuerAssignedId __BT-14, From EN 16931__ An identifier issued by the seller for a referenced sales order (Order confirmation number)
     * @param  DateTime|null $issueDate        __BT-X-146, From EXTENDED__ Order confirmation date
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerOrderReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get details of the related buyer order.
     *
     * @param  string|null   $issuerAssignedId __BT-13, From MINIMUM__ An identifier issued by the buyer for a referenced order (order number)
     * @param  DateTime|null $issueDate        __BT-X-147, From EXTENDED__ Date of order
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerOrderReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get details of the associated offer.
     *
     * @param  string|null   $issuerAssignedId __BT-X-403, From EXTENDED__ Offer number
     * @param  DateTime|null $issueDate        __BT-X-404, From EXTENDED__ Date of offer
     * @return ZugferdDocumentReader
     */
    public function getDocumentQuotationReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getQuotationReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getQuotationReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getQuotationReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get details of the associated contract.
     *
     * @param  string|null   $issuerAssignedId __BT-12, From BASIC WL__ The contract reference should be assigned once in the context of the specific trade relationship and for a defined period of time (contract number)
     * @param  DateTime|null $issueDate        __BT-X-26, From EXTENDED__ Contract date
     * @return ZugferdDocumentReader
     */
    public function getDocumentContractReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get first additional referenced document for the document. Returns true if an additional referenced document is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentAdditionalReferencedDocument.
     *
     * @return boolean
     */
    public function firstDocumentAdditionalReferencedDocument(): bool
    {
        $this->documentAddRefDocPointer = 0;

        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);

        return isset($addRefDoc[$this->documentAddRefDocPointer]);
    }

    /**
     * Get next additional referenced document for the document. Returns true when another additional referenced document is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentAdditionalReferencedDocument.
     *
     * @return boolean
     */
    public function nextDocumentAdditionalReferencedDocument(): bool
    {
        $this->documentAddRefDocPointer++;

        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);

        return isset($addRefDoc[$this->documentAddRefDocPointer]);
    }

    /**
     * Get information about billing documents that provide evidence of claims made in the bill.
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
     * @param  string        $issuerAssignedId   __BT-122, From EN 16931__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string        $typeCode           __BT-122-0, From EN 16931__ Type of referenced document (See codelist UNTDID 1001)
     *                                           - Code 916 "reference paper" is used to reference the identification of the
     *                                           document on which the invoice is based - Code 50 "Price / sales catalog response"
     *                                           is used to reference the tender or the lot - Code 130 "invoice data sheet" is used
     *                                           to reference an identifier for an object specified by the seller.
     * @param  string|null   $uriId              __BT-124, From EN 16931__ A means of locating the resource, including the primary access method intended for it, e.g. http:// or ftp://. The storage location of the external document must be used if the buyer requires further information as
     *                                           supporting documents for the invoiced amounts. External documents are not part of the invoice. Invoice processing should be possible without access to external documents. Access to external documents can entail certain risks.
     * @param  array|null    $name               __BT-123, From EN 16931__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null   $refTypeCode        __BT-, From __ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTime|null $issueDate          __BT-X-149, From EXTENDED__ Document date
     * @param  string|null   $binaryDataFilename __BT-125, From EN 16931__ Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentReader
     */
    public function getDocumentAdditionalReferencedDocument(?string &$issuerAssignedId, ?string &$typeCode, ?string &$uriId, ?array &$name, ?string &$refTypeCode, ?DateTime &$issueDate, ?string &$binaryDataFilename): ZugferdDocumentReader
    {
        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);
        $addRefDoc = $addRefDoc[$this->documentAddRefDocPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($addRefDoc, "getTypeCode.value", "");
        $uriId = $this->getInvoiceValueByPathFrom($addRefDoc, "getURIID.value", "");
        $name = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($addRefDoc, "getName.value", null));
        $refTypeCode = $this->getInvoiceValueByPathFrom($addRefDoc, "getReferenceTypeCode.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        $binaryDataFilename = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.getFilename", "");
        $binarydata = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.value", "");

        if (
            StringUtils::stringIsNullOrEmpty($binaryDataFilename) === false
            && StringUtils::stringIsNullOrEmpty($binarydata) === false
            && StringUtils::stringIsNullOrEmpty($this->binarydatadirectory) === false
        ) {
            $binaryDataFilename = PathUtils::combinePathWithFile($this->binarydatadirectory, $binaryDataFilename);
            FileUtils::base64ToFile($binarydata, $binaryDataFilename);
        } else {
            $binaryDataFilename = "";
        }

        return $this;
    }

    /**
     * Get all additional referenced documents.
     *
     * @param  array|null $refDocs Array contains all additional referenced documents, but without extracting attached binary objects. If you want to access attached binary objects you have to use ZugferdDocumentReader::getDocumentAdditionalReferencedDocument
     * @return ZugferdDocumentReader
     */
    public function getDocumentAdditionalReferencedDocuments(?array &$refDocs): ZugferdDocumentReader
    {
        $refDocs = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);
        $refDocs = $this->convertToArray(
            $refDocs,
            [
                "IssuerAssignedID" => ["getIssuerAssignedID.value", ""],
                "URIID" => ["getURIID.value", ""],
                "LineID" => ["getLineID.value", ""],
                "TypeCode" => ["getTypeCode.value", ""],
                "ReferenceTypeCode" => ["getReferenceTypeCode.value", ""],
                "FormattedIssueDateTime" => ["getFormattedIssueDateTime.getDateTimeString.value", ""],
            ]
        );

        return $this;
    }

    /**
     * Get first reference to the previous invoice. Returns true if an invoice reference document is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentInvoiceReferencedDocument.
     *
     * @return boolean
     */
    public function firstDocumentInvoiceReferencedDocument(): bool
    {
        $this->documentInvRefDocPointer = 0;

        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceReferencedDocument", []);

        return isset($addRefDoc[$this->documentInvRefDocPointer]);
    }

    /**
     * Get next reference to the previous invoice Returns true when another invoice reference document is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentInvoiceReferencedDocument.
     *
     * @return boolean
     */
    public function nextDocumentInvoiceReferencedDocument(): bool
    {
        $this->documentInvRefDocPointer++;

        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceReferencedDocument", []);

        return isset($addRefDoc[$this->documentInvRefDocPointer]);
    }

    /**
     * Get reference to the previous invoice.
     *
     * @param string        $issuerAssignedId __BT-25, From BASIC WL__ The identification of an invoice previously sent by the seller
     * @param string|null   $typeCode         __BT-X-555, From EXTENDED__ Type of previous invoice (code)
     * @param DateTime|null $issueDate        __BT-26, From BASIC WL__ Date of the previous invoice
     */
    public function getDocumentInvoiceReferencedDocument(?string &$issuerAssignedId, ?string &$typeCode, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $invoiceRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceReferencedDocument", []);
        $invoiceRefDoc = $invoiceRefDoc[$this->documentInvRefDocPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getIssuerAssignedID.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getTypeCode.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get all references to the previous invoice.
     *
     * @param  array|null $invoiceRefDocs
     * Array contains all invoice referenced documents, but without extracting attached binary objects. If you
     * want to access attached binary objects you have to use ZugferdDocumentReader::getDocumentInvoiceReferencedDocument
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceReferencedDocuments(?array &$invoiceRefDocs): ZugferdDocumentReader
    {
        $invoiceRefDocs = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceReferencedDocument", []);
        $invoiceRefDocs = $this->convertToArray(
            $invoiceRefDocs,
            [
                "IssuerAssignedID" => ["getIssuerAssignedID.value", ""],
                "TypeCode" => ["getTypeCode.value", ""],
                "FormattedIssueDateTime" => ["getFormattedIssueDateTime.getDateTimeString.value", ""],
            ]
        );

        return $this;
    }

    /**
     * Get Details of a project reference.
     *
     * @param  string|null $id   __BT-11, From EN 16931__ The identifier of the project to which the invoice relates
     * @param  string|null $name __BT-11-0, From EN 16931__  The name of the project to which the invoice relates
     * @return ZugferdDocumentReader
     */
    public function getDocumentProcuringProject(?string &$id, ?string &$name): ZugferdDocumentReader
    {
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSpecifiedProcuringProject.getID.value", "");
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSpecifiedProcuringProject.getName.value", "");

        return $this;
    }

    /**
     * Get first additional referenced document for the document. Returns true if the first position is available, otherwise false.
     * Use wuth getDocumentUltimateCustomerOrderReferencedDocument.
     *
     * @return boolean
     */
    public function firstDocumentUltimateCustomerOrderReferencedDocument(): bool
    {
        $this->documentUltimateCustomerOrderReferencedDocumentPointer = 0;

        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getUltimateCustomerOrderReferencedDocument", []);

        return isset($addRefDoc[$this->documentUltimateCustomerOrderReferencedDocumentPointer]);
    }

    /**
     * Get next additional referenced document for the document. Returns true if the first position is available, otherwise false
     * Use wuth getDocumentUltimateCustomerOrderReferencedDocument.
     *
     * @return boolean
     */
    public function nextDocumentUltimateCustomerOrderReferencedDocument(): bool
    {
        $this->documentUltimateCustomerOrderReferencedDocumentPointer++;

        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getUltimateCustomerOrderReferencedDocument", []);

        return isset($addRefDoc[$this->documentUltimateCustomerOrderReferencedDocumentPointer]);
    }

    /**
     * Get details of the ultimate customer order.
     *
     * @param  string|null   $issuerAssignedId __BT-X-150, From EXTENDED__ Order number of the end customer
     * @param  DateTime|null $issueDate        __BT-X-151, From EXTENDED__ Date of the order issued by the end customer
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateCustomerOrderReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getUltimateCustomerOrderReferencedDocument", []);
        $addRefDoc = $addRefDoc[$this->documentUltimateCustomerOrderReferencedDocumentPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Details of the ultimate customer order.
     *
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateCustomerOrderReferencedDocuments(/*?array $refdocs*/): ZugferdDocumentReader
    {
        // TODO: Implemente method getDocumentUltimateCustomerOrderReferencedDocuments
        return $this;
    }

    /**
     * Get detailed information on the actual delivery.
     *
     * @param  DateTime|null $date __BT-72, From BASIC WL__ Actual delivery time
     * @return ZugferdDocumentReader
     */
    public function getDocumentSupplyChainEvent(?DateTime &$date): ZugferdDocumentReader
    {
        $date = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime.getDateTimeString.getformat", "")
        );

        return $this;
    }

    /**
     * Get detailed information on the associated shipping notification.
     *
     * @param  string|null   $issuerAssignedId __BT-16, From BASIC WL__ Shipping notification reference
     * @param  DateTime|null $issueDate        __BT-X-200, From EXTENDED__ Shipping notification date
     * @return ZugferdDocumentReader
     */
    public function getDocumentDespatchAdviceReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get detailed information on the associated goods receipt notification.
     *
     * @param  string|null   $issuerAssignedId __BT-15, From EN 16931__ An identifier for a referenced goods receipt notification (Goods receipt number)
     * @param  DateTime|null $issueDate        __BT-X-201, From EXTENDED__ Goods receipt date
     * @return ZugferdDocumentReader
     */
    public function getDocumentReceivingAdviceReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get detailed information on the associated delivery note.
     *
     * @param  string        $issuerAssignedId __BT-X-202, From EXTENDED__ Delivery slip number
     * @param  DateTime|null $issueDate        __BT-X-203, From EXTENDED__ Delivery slip date
     * @return ZugferdDocumentReader
     */
    public function getDocumentDeliveryNoteReferencedDocument(?string &$issuerAssignedId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $issuerAssignedId = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getIssuerAssignedID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first payment means of the document. Returns true if a first payment mean is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentMeans.
     *
     * @return boolean
     */
    public function firstGetDocumentPaymentMeans(): bool
    {
        $this->documentPaymentMeansPointer = 0;

        $paymentMeans = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));

        return isset($paymentMeans[$this->documentPaymentMeansPointer]);
    }

    /**
     * Seek to the next payment means of the document. Returns true if another payment mean is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentMeans
     *
     * @return boolean
     */
    public function nextGetDocumentPaymentMeans(): bool
    {
        $this->documentPaymentMeansPointer++;

        $paymentMeans = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));

        return isset($paymentMeans[$this->documentPaymentMeansPointer]);
    }

    /**
     * Get detailed information on the payment method.
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPaymentMeans(?string &$typeCode, ?string &$information, ?string &$cardType, ?string &$cardId, ?string &$cardHolderName, ?string &$buyerIban, ?string &$payeeIban, ?string &$payeeAccountName, ?string &$payeePropId, ?string &$payeeBic): ZugferdDocumentReader
    {
        $paymentMeans = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));
        $paymentMeans = $paymentMeans[$this->documentPaymentMeansPointer];

        $typeCode = $this->getInvoiceValueByPathFrom($paymentMeans, "getTypeCode.value", "");
        $information = $this->getInvoiceValueByPathFrom($paymentMeans, "getInformation.value", "");
        $cardType = $this->getInvoiceValueByPathFrom($paymentMeans, "getApplicableTradeSettlementFinancialCard.getID.getSchemeID", "");
        $cardId = $this->getInvoiceValueByPathFrom($paymentMeans, "getApplicableTradeSettlementFinancialCard.getID.value", "");
        $cardHolderName = $this->getInvoiceValueByPathFrom($paymentMeans, "getApplicableTradeSettlementFinancialCard.getCardholderName.value", "");
        $buyerIban = $this->getInvoiceValueByPathFrom($paymentMeans, "getPayerPartyDebtorFinancialAccount.getIBANID.value", "");
        $payeeIban = $this->getInvoiceValueByPathFrom($paymentMeans, "getPayeePartyCreditorFinancialAccount.getIBANID.value", "");
        $payeeAccountName = $this->getInvoiceValueByPathFrom($paymentMeans, "getPayeePartyCreditorFinancialAccount.getAccountName.value", "");
        $payeePropId = $this->getInvoiceValueByPathFrom($paymentMeans, "getPayeePartyCreditorFinancialAccount.getProprietaryID.value", "");
        $payeeBic = $this->getInvoiceValueByPathFrom($paymentMeans, "getPayeeSpecifiedCreditorFinancialInstitution.getBICID.value", "");

        return $this;
    }

    /**
     * Seek to the first document tax. Returns true if a first tax (at document level) is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentTax.
     *
     * @return boolean
     */
    public function firstDocumentTax(): bool
    {
        $this->documentTaxPointer = 0;

        $taxes = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getApplicableTradeTax", []));

        return isset($taxes[$this->documentTaxPointer]);
    }

    /**
     * Seek to the next document tax. Returns true if another tax (at document level) is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentTax.
     *
     * @return boolean
     */
    public function nextDocumentTax(): bool
    {
        $this->documentTaxPointer++;

        $taxes = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getApplicableTradeTax", []));

        return isset($taxes[$this->documentTaxPointer]);
    }

    /**
     * Get current VAT breakdown (at document level).
     *
     * @param string|null   $categoryCode               __BT-118, From BASIC WL__ Coded description of a sales tax category
     * @param string|null   $typeCode                   __BT-118-0, From BASIC WL__ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param float|null    $basisAmount                __BT-116, From BASIC WL__ Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param float|null    $calculatedAmount           __BT-117, From BASIC WL__ The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying the amount to be taxed according to the sales tax category by the sales tax rate applicable for the sales tax category concerned
     * @param float|null    $rateApplicablePercent      __BT-119, From BASIC WL__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param string|null   $exemptionReason            __BT-120, From BASIC WL__ Reason for tax exemption (free text)
     * @param string|null   $exemptionReasonCode        __BT-121, From BASIC WL__ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility.
     * @param float|null    $lineTotalBasisAmount       __BT-X-262, From EXTENDED__ An amount used as the basis for calculating sales tax, duty or customs duty
     * @param float|null    $allowanceChargeBasisAmount __BT-X-263, From EXTENDED__ Total amount Additions and deductions to the tax rate at document level
     * @param DateTime|null $taxPointDate               __BT-7-00, From EN 16931__ Date on which tax is due. This is not used in Germany. Instead, the delivery and service date must be specified.
     * @param string|null   $dueDateTypeCode            __BT-8, From BASIC WL__ The code for the date on which the VAT becomes relevant for settlement for the seller and for the buyer
     */
    public function getDocumentTax(?string &$categoryCode, ?string &$typeCode, ?float &$basisAmount, ?float &$calculatedAmount, ?float &$rateApplicablePercent, ?string &$exemptionReason, ?string &$exemptionReasonCode, ?float &$lineTotalBasisAmount, ?float &$allowanceChargeBasisAmount, ?DateTime &$taxPointDate, ?string &$dueDateTypeCode): ZugferdDocumentReader
    {
        $taxes = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getApplicableTradeTax", []));
        $taxes = $taxes[$this->documentTaxPointer];

        $categoryCode = $this->getInvoiceValueByPathFrom($taxes, "getCategoryCode.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($taxes, "getTypeCode.value", "");
        $basisAmount = $this->getInvoiceValueByPathFrom($taxes, "getBasisAmount.value", 0.0);
        $calculatedAmount = $this->getInvoiceValueByPathFrom($taxes, "getCalculatedAmount.value", 0.0);
        $rateApplicablePercent = $this->getInvoiceValueByPathFrom($taxes, "getRateApplicablePercent.value", 0.0);
        $exemptionReason = $this->getInvoiceValueByPathFrom($taxes, "getExemptionReason.value", "");
        $exemptionReasonCode = $this->getInvoiceValueByPathFrom($taxes, "getExemptionReasonCode.value", "");
        $lineTotalBasisAmount = $this->getInvoiceValueByPathFrom($taxes, "getLineTotalBasisAmount.value", 0.0);
        $allowanceChargeBasisAmount = $this->getInvoiceValueByPathFrom($taxes, "getAllowanceChargeBasisAmount.value", 0.0);
        $taxPointDate = $this->getObjectHelper()->toDateTime(
            $this->getObjectHelper()->tryCallByPathAndReturn($taxes, "getTaxPointDate.getDateString.value"),
            $this->getObjectHelper()->tryCallByPathAndReturn($taxes, "getTaxPointDate.getDateString.getFormat")
        );
        $dueDateTypeCode = $this->getInvoiceValueByPathFrom($taxes, "getDueDateTypeCode.value", "");

        return $this;
    }

    /**
     * Get detailed information on the billing period.
     *
     * @param  DateTime|null $startDate __BT-73, From BASIC WL__ Start of the billing period
     * @param  DateTime|null $endDate   __BT-74, From BASIC WL__ End of the billing period
     * @return ZugferdDocumentReader
     */
    public function getDocumentBillingPeriod(?DateTime &$startDate, ?DateTime &$endDate): ZugferdDocumentReader
    {
        $startDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.getFormat", null)
        );
        $endDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Get information about surcharges and charges applicable to the bill as a whole, Deductions, such as for withheld taxes may also be specified in this group.
     *
     * @param  array|null $allowanceCharge
     * @return ZugferdDocumentReader
     */
    public function getDocumentAllowanceCharges(?array &$allowanceCharge): ZugferdDocumentReader
    {
        $allowanceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeAllowanceCharge", []);
        $allowanceCharge = $this->convertToArray(
            $allowanceCharge,
            [
                "chargeindicator" => ["getChargeIndicator.getIndicator", false],
                "sequencenumeric" => ["getSequenceNumeric.value", 0],
                "calculationpercent" => ["getCalculationPercent.value", 0.0],
                "basisamount" => ["getBasisAmount.value", 0.0],
                "basisquantity" => ["getBasisQuantity.value", 0.0],
                "actualAmount" => ["getActualAmount.value", 0.0],
                "reasoncode" => ["getReasonCode.value", ""],
                "reason" => ["getReason.value", ""],
                "taxcalculatedamount" => ["getCategoryTradeTax.getCalculatedAmount.value", 0.0],
                "taxtypecode" => ["getCategoryTradeTax.getTypeCode.value", ""],
                "taxexemptionreason" => ["getCategoryTradeTax.getExemptionReason.value", ""],
                "taxbasisamount" => ["getCategoryTradeTax.getBasisAmount.value", 0.0],
                "taxlinetotalbasisamount" => ["getCategoryTradeTax.getLineTotalBasisAmount.value", 0.0],
                "taxallowancechargebasisamount" => ["getCategoryTradeTax.getAllowanceChargeBasisAmount.value", 0.0],
                "taxcategorycode" => ["getCategoryTradeTax.getCategoryCode.value", ""],
                "taxexemptionreasoncode" => ["getCategoryTradeTax.getExemptionReasonCode.value", ""],
                "taxpointdate" => function ($item) {
                    return $this->getObjectHelper()->toDateTime(
                        $this->getObjectHelper()->tryCallByPathAndReturn($item, "getCategoryTradeTax.getTaxPointDate.getDateString.value"),
                        $this->getObjectHelper()->tryCallByPathAndReturn($item, "getCategoryTradeTax.getTaxPointDate.getDateString.getFormat")
                    );
                },
                "taxduedatetypecode" => ["getCategoryTradeTax.getDueDateTypeCode.value", ""],
                "taxrateapplicablepercent" => ["getCategoryTradeTax.getRateApplicablePercent.value", 0.0],
            ]
        );

        return $this;
    }

    /**
     * Seek to the first documents allowance charge. Returns true if the first position is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentAllowanceCharge.
     *
     * @return boolean
     */
    public function firstDocumentAllowanceCharge(): bool
    {
        $this->documentAllowanceChargePointer = 0;

        $allowanceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeAllowanceCharge", []);

        return isset($allowanceCharge[$this->documentAllowanceChargePointer]);
    }

    /**
     * Seek to the next documents allowance charge. Returns true if a other position is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentAllowanceCharge.
     *
     * @return boolean
     */
    public function nextDocumentAllowanceCharge(): bool
    {
        $this->documentAllowanceChargePointer++;

        $allowanceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeAllowanceCharge", []);

        return isset($allowanceCharge[$this->documentAllowanceChargePointer]);
    }

    /**
     * Get information about the currently seeked surcharges and charges applicable to the bill as a whole, Deductions, such as for withheld taxes may also be specified in this group.
     *
     * @param  float|null   $actualAmount          __BT-92/BT-99, From BASIC WL__ Amount of the surcharge or discount at document level
     * @param  boolean|null $isCharge              __BT-20-1/BT-21-1, From BASIC WL__ Switch that indicates whether the following data refer to an surcharge or a discount, true means that this an charge
     * @param  string|null  $taxCategoryCode       __BT-95/BT-102, From BASIC WL__ A coded indication of which sales tax category applies to the surcharge or deduction at document level
     * @param  string|null  $taxTypeCode           __BT-95-0/BT-102-0, From BASIC WL__ Code for the VAT category of the surcharge or charge at document level. Note: Fixed value = "VAT"
     * @param  float|null   $rateApplicablePercent __BT-96/BT-103, From BASIC WL__ VAT rate for the surcharge or discount on document level. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null   $sequence              __BT-X-265, From EXTENDED__ Calculation order
     * @param  float|null   $calculationPercent    __BT-94/BT-101, From BASIC WL__ Percentage surcharge or discount at document level
     * @param  float|null   $basisAmount           __BT-93/BT-100, From BASIC WL__ The base amount that may be used in conjunction with the percentage of the surcharge or discount at document level to calculate the amount of the discount at document level
     * @param  float|null   $basisQuantity         __BT-X-266, From EXTENDED__ Base quantity of the discount
     * @param  string|null  $basisQuantityUnitCode __BT-X-267, From EXTENDED__ Unit of the price base quantity
     * @param  string|null  $reasonCode            __BT-98/BT-105, From BASIC WL__ The reason given as a code for the surcharge or discount at document level. Note: Use entries from the UNTDID 5189 code list. The code of the reason for the surcharge or discount at document level and the reason for the surcharge or discount at document level must correspond to each other
     * @param  string|null  $reason                __BT-97/BT-104, From BASIC WL__ The reason given in text form for the surcharge or discount at document level
     * @return ZugferdDocumentReader
     */
    public function getDocumentAllowanceCharge(?float &$actualAmount, ?bool &$isCharge, ?string &$taxCategoryCode, ?string &$taxTypeCode, ?float &$rateApplicablePercent, ?float &$sequence, ?float &$calculationPercent, ?float &$basisAmount, ?float &$basisQuantity, ?string &$basisQuantityUnitCode, ?string &$reasonCode, ?string &$reason): ZugferdDocumentReader
    {
        $allowanceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeAllowanceCharge", []);
        $allowanceCharge = $allowanceCharge[$this->documentAllowanceChargePointer];

        $actualAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getActualAmount.value", 0.0);
        $isCharge = $this->getInvoiceValueByPathFrom($allowanceCharge, "getChargeIndicator.getIndicator", false);
        $taxCategoryCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getCategoryCode.value", "");
        $taxTypeCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getTypeCode.value", "");
        $rateApplicablePercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getRateApplicablePercent.value", 0.0);
        $sequence = $this->getInvoiceValueByPathFrom($allowanceCharge, "getSequenceNumeric.value", 0);
        $calculationPercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCalculationPercent.value", 0.0);
        $basisAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisAmount.value", 0.0);
        $basisQuantity = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisQuantity.value", 0.0);
        $basisQuantityUnitCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisQuantity.getUnitCode", "");
        $reasonCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReasonCode.value", "");
        $reason = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReason.value", "");

        return $this;
    }

    /**
     * Seek to the first documents service charge position. Returns true if the first position is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentLogisticsServiceCharge.
     *
     * @return boolean
     */
    public function firstDocumentLogisticsServiceCharge(): bool
    {
        $this->documentLogisticServiceChargePointer = 0;

        $serviceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedLogisticsServiceCharge", []);

        return isset($serviceCharge[$this->documentLogisticServiceChargePointer]);
    }

    /**
     * Seek to the next documents service charge position. Returns true if a other position is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentLogisticsServiceCharge.
     *
     * @return boolean
     */
    public function nextDocumentLogisticsServiceCharge(): bool
    {
        $this->documentLogisticServiceChargePointer++;

        $serviceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedLogisticsServiceCharge", []);

        return isset($serviceCharge[$this->documentLogisticServiceChargePointer]);
    }

    /**
     * Get currently seeked logistical service fees (On document level).
     *
     * @param  string|null $description            __BT-X-271, From EXTENDED__ Identification of the service fee
     * @param  float|null  $appliedAmount          __BT-X-272, From EXTENDED__ Amount of the service fee
     * @param  array|null  $taxTypeCodes           __BT-X-273-0, From EXTENDED__ Code of the Tax type. Note: Fixed value = "VAT"
     * @param  array|null  $taxCategoryCodes       __BT-X-273, From EXTENDED__ Code of the VAT category
     * @param  array|null  $rateApplicablePercents __BT-X-274, From EXTENDED__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentReader
     */
    public function getDocumentLogisticsServiceCharge(?string &$description, ?float &$appliedAmount, ?array &$taxTypeCodes, ?array &$taxCategoryCodes, ?array &$rateApplicablePercents): ZugferdDocumentReader
    {
        $serviceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedLogisticsServiceCharge", []);
        $serviceCharge = $serviceCharge[$this->documentLogisticServiceChargePointer];

        $description = $this->getInvoiceValueByPathFrom($serviceCharge, "getDescription.value", "");
        $appliedAmount = $this->getInvoiceValueByPathFrom($serviceCharge, "getAppliedAmount.value", 0.0);
        $appliedTradeTax = $this->getInvoiceValueByPathFrom($serviceCharge, "getAppliedTradeTax", []);
        $taxTypeCodes = $this->convertToArray(
            $appliedTradeTax,
            [
                "typecode" => ["getTypeCode.value", ""],
            ]
        );
        $taxCategoryCodes = $this->convertToArray(
            $appliedTradeTax,
            [
                "categorycode" => ["getCategoryCode.value", ""],
            ]
        );
        $rateApplicablePercents = $this->convertToArray(
            $appliedTradeTax,
            [
                "percent" => ["getRateApplicablePercent.value", 0.0],
            ]
        );

        return $this;
    }

    /**
     * Get all documents payment terms.
     *
     * @param  array|null $paymentTerms
     * @return ZugferdDocumentReader
     */
    public function getDocumentPaymentTerms(?array &$paymentTerms): ZugferdDocumentReader
    {
        $paymentTerms = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []);
        $paymentTerms = $this->convertToArray(
            $paymentTerms,
            [
                "description" => ["getDescription.value", ""],
                "duedate" => function ($item) {
                    return $this->getObjectHelper()->toDateTime(
                        $this->getObjectHelper()->tryCallByPathAndReturn($item, "getDueDateDateTime.getDateTimeString.value"),
                        $this->getObjectHelper()->tryCallByPathAndReturn($item, "getDueDateDateTime.getDateTimeString.getFormat")
                    );
                },
                "directdebitmandateid" => ["getDirectDebitMandateID.value", ""],
                "partialpaymentamount" => ["getPartialPaymentAmount.value", 0.0],
            ]
        );

        return $this;
    }

    /**
     * Seek to the first documents payment terms position. Returns true if the first position is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentTerm.
     *
     * @return boolean
     */
    public function firstDocumentPaymentTerms(): bool
    {
        $this->documentPaymentTermsPointer = 0;

        $paymentTerms = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));

        return isset($paymentTerms[$this->documentPaymentTermsPointer]);
    }

    /**
     * Seek to the next documents payment terms position. Returns true if a other position is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentTerm.
     *
     * @return boolean
     */
    public function nextDocumentPaymentTerms(): bool
    {
        $this->documentPaymentTermsPointer++;

        $paymentTerms = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));

        return isset($paymentTerms[$this->documentPaymentTermsPointer]);
    }

    /**
     * Get currently seeked payment term.
     *
     * @param  string|null   $description          __BT-20, From _BASIC WL__ A text description of the payment terms that apply to the payment amount due (including a description of possible penalties). Note: This element can contain multiple lines and multiple conditions.
     * @param  DateTime|null $dueDate              __BT-9, From BASIC WL__ The date by which payment is due Note: The payment due date reflects the net payment due date. In the case of partial payments, this indicates the first due date of a net payment. The corresponding description of more complex payment terms can be given in BT-20.
     * @param  string|null   $directDebitMandateID __BT-89, From BASIC WL__ Unique identifier assigned by the payee to reference the direct debit authorization.
     * @return ZugferdDocumentReader
     */
    public function getDocumentPaymentTerm(?string &$description, ?DateTime &$dueDate, ?string &$directDebitMandateID): ZugferdDocumentReader
    {
        $paymentTerms = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        $paymentTerms = $paymentTerms[$this->documentPaymentTermsPointer];

        $description = $this->getInvoiceValueByPathFrom($paymentTerms, "getDescription.value", "");
        $dueDate = $this->getObjectHelper()->toDateTime(
            $this->getObjectHelper()->tryCallByPathAndReturn($paymentTerms, "getDueDateDateTime.getDateTimeString.value"),
            $this->getObjectHelper()->tryCallByPathAndReturn($paymentTerms, "getDueDateDateTime.getDateTimeString.getFormat")
        );
        $directDebitMandateID = $this->getInvoiceValueByPathFrom($paymentTerms, "getDirectDebitMandateID.value", "");

        return $this;
    }

    /**
     * Get detailed information on payment discounts.
     *
     * @param  float|null    $calculationPercent         __BT-X-286, From EXTENDED__ Percentage of the down payment
     * @param  DateTime|null $basisDateTime              __BT-X-282, From EXTENDED__ Due date reference date
     * @param  float|null    $basisPeriodMeasureValue    __BT-X-284, From EXTENDED__ Maturity period (basis)
     * @param  string|null   $basisPeriodMeasureUnitCode __BT-X-284, From EXTENDED__ Maturity period (unit)
     * @param  float|null    $basisAmount                __BT-X-284, From EXTENDED__ Base amount of the payment discount
     * @param  float|null    $actualDiscountAmount       __BT-X-287, From EXTENDED__ Amount of the payment discount
     * @return ZugferdDocumentReader
     */
    public function getDiscountTermsFromPaymentTerm(?float &$calculationPercent, ?DateTime &$basisDateTime, ?float &$basisPeriodMeasureValue, ?string &$basisPeriodMeasureUnitCode, ?float &$basisAmount, ?float &$actualDiscountAmount): ZugferdDocumentReader
    {
        $paymentTerms = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        $paymentTerms = $paymentTerms[$this->documentPaymentTermsPointer];

        $calculationPercent = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentDiscountTerms.getCalculationPercent.value", 0.0);
        $basisDateTime = $this->getObjectHelper()->toDateTime(
            $this->getObjectHelper()->tryCallByPathAndReturn($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisDateTime.getDateTimeString.value"),
            $this->getObjectHelper()->tryCallByPathAndReturn($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisDateTime.getDateTimeString.getFormat")
        );
        $basisPeriodMeasureValue = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisPeriodMeasure.value", 0.0);
        $basisPeriodMeasureUnitCode = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisPeriodMeasure.getUnitCode", "");
        $basisAmount = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisAmount.value", 0.0);
        $actualDiscountAmount = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentDiscountTerms.getActualDiscountAmount.value", 0.0);

        return $this;
    }

    /**
     * Get detailed information on payment penalties.
     *
     * @param  float|null    $calculationPercent         __BT-X-280, From EXTENDED__ Percentage of the payment surcharge
     * @param  DateTime|null $basisDateTime              __BT-X-276, From EXTENDED__ Due date reference date
     * @param  float|null    $basisPeriodMeasureValue    __BT-X-277, From EXTENDED__ Maturity period (basis)
     * @param  string|null   $basisPeriodMeasureUnitCode __BT-X-277, From EXTENDED__ Maturity period (unit)
     * @param  float|null    $basisAmount                __BT-X-279, From EXTENDED__ Basic amount of the payment surcharge
     * @param  float|null    $actualPenaltyAmount        __BT-X-281, From EXTENDED__ Amount of the payment surcharge
     * @return ZugferdDocumentReader
     */
    public function getPenaltyTermsFromPaymentTerm(?float &$calculationPercent, ?DateTime &$basisDateTime, ?float &$basisPeriodMeasureValue, ?string &$basisPeriodMeasureUnitCode, ?float &$basisAmount, ?float &$actualPenaltyAmount): ZugferdDocumentReader
    {
        $paymentTerms = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        $paymentTerms = $paymentTerms[$this->documentPaymentTermsPointer];

        $calculationPercent = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getCalculationPercent.value", 0.0);
        $basisDateTime = $this->getObjectHelper()->toDateTime(
            $this->getObjectHelper()->tryCallByPathAndReturn($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getBasisDateTime.getDateTimeString.value"),
            $this->getObjectHelper()->tryCallByPathAndReturn($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getBasisDateTime.getDateTimeString.getFormat")
        );
        $basisPeriodMeasureValue = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getBasisPeriodMeasure.value", 0.0);
        $basisPeriodMeasureUnitCode = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getBasisPeriodMeasure.getUnitCode", "");
        $basisAmount = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getBasisAmount.value", 0.0);
        $actualPenaltyAmount = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentPenaltyTerms.getActualPenaltyAmount.value", 0.0);

        return $this;
    }

    /**
     * Seek to the first trade accounting account of the document. Returns true if a first account is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact.
     *
     * @return boolean
     */
    public function firstDocumentReceivableSpecifiedTradeAccountingAccount(): bool
    {
        $this->documentTradeAccountingAccountPointer = 0;

        $acccounts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getReceivableSpecifiedTradeAccountingAccount", []));

        return isset($acccounts[$this->documentTradeAccountingAccountPointer]);
    }

    /**
     * Seek to the next trade accounting account of the document. Returns true if another account is available, otherwise false.
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact.
     *
     * @return boolean
     */
    public function nextDocumentReceivableSpecifiedTradeAccountingAccount(): bool
    {
        $this->documentTradeAccountingAccountPointer++;

        $acccounts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getReceivableSpecifiedTradeAccountingAccount", []));

        return isset($acccounts[$this->documentTradeAccountingAccountPointer]);
    }

    /**
     * Get information on the booking reference (on document level).
     *
     * @param  null|string &$id       __BT-19, From BASIC WL__ Posting reference of the byuer. If required, this reference shall be provided by the Buyer to the Seller prior to the issuing of the Invoice.
     * @param  null|string &$typeCode __BT-X-290, From EXTENDED__ Type of the posting reference
     * @return ZugferdDocumentReader
     */
    public function getDocumentReceivableSpecifiedTradeAccountingAccount(?string &$id, ?string &$typeCode): ZugferdDocumentReader
    {
        $acccounts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getReceivableSpecifiedTradeAccountingAccount", []));
        $acccounts = $acccounts[$this->documentTradeAccountingAccountPointer];

        $id = $this->getInvoiceValueByPathFrom($acccounts, "getId.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($acccounts, "getTypeCode.value", "");

        return $this;
    }

    /**
     * Read Document money summation.
     *
     * @param  float|null $grandTotalAmount     __BT-112, From MINIMUM__ Total invoice amount including sales tax
     * @param  float|null $duePayableAmount     __BT-115, From MINIMUM__ Payment amount due
     * @param  float|null $lineTotalAmount      __BT-106, From BASIC WL__ Sum of the net amounts of all invoice items
     * @param  float|null $chargeTotalAmount    __BT-108, From BASIC WL__ Sum of the surcharges at document level
     * @param  float|null $allowanceTotalAmount __BT-107, From BASIC WL__ Sum of the discounts at document level
     * @param  float|null $taxBasisTotalAmount  __BT-109, From MINIMUM__ Total invoice amount excluding sales tax
     * @param  float|null $taxTotalAmount       __BT-110/111, From MINIMUM/BASIC WL__ if BT-6 is not null $taxTotalAmount = BT-111. Total amount of the invoice sales tax, Total tax amount in the booking currency
     * @param  float|null $roundingAmount       __BT-114, From EN 16931__ Rounding amount
     * @param  float|null $totalPrepaidAmount   __BT-113, From BASIC WL__ Prepayment amount
     * @return ZugferdDocumentReader
     */
    public function getDocumentSummation(?float &$grandTotalAmount, ?float &$duePayableAmount, ?float &$lineTotalAmount, ?float &$chargeTotalAmount, ?float &$allowanceTotalAmount, ?float &$taxBasisTotalAmount, ?float &$taxTotalAmount, ?float &$roundingAmount, ?float &$totalPrepaidAmount): ZugferdDocumentReader
    {
        $invoiceCurrencyCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");
        $grandTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getGrandTotalAmount.value", 0);
        $taxBasisTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxBasisTotalAmount.value", 0);
        $taxTotalAmountElement = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxTotalAmount", []);

        foreach ($taxTotalAmountElement as $taxTotalAmountElementItem) {
            $taxTotalAmountCurrencyCode = $this->getObjectHelper()->tryCallAndReturn($taxTotalAmountElementItem, "getCurrencyID") ?? "";
            if ($taxTotalAmountCurrencyCode == $invoiceCurrencyCode || $taxTotalAmountCurrencyCode == "") {
                $taxTotalAmount = $this->getObjectHelper()->tryCallAndReturn($taxTotalAmountElementItem, "value") ?? 0;
                break;
            }
        }

        $duePayableAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getDuePayableAmount.value", 0);
        $lineTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getLineTotalAmount.value", 0);
        $chargeTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getChargeTotalAmount.value", 0);
        $allowanceTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getAllowanceTotalAmount.value", 0);
        $roundingAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getRoundingAmount.value", 0);
        $totalPrepaidAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTotalPrepaidAmount.value", 0);

        return $this;
    }

    /**
     * Seek to the first document position. Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionGenerals.
     *
     * @return boolean
     */
    public function firstDocumentPosition(): bool
    {
        $this->positionPointer = 0;

        $this->positionNotePointer = 0;
        $this->positionGrossPriceAllowanceChargePointer = 0;
        $this->positionTaxPointer = 0;
        $this->positionAllowanceChargePointer = 0;
        $this->positionAddRefDocPointer = 0;
        $this->positionAddRefObjDocPointer = 0;
        $this->positionProductCharacteristicPointer = 0;
        $this->positionProductClassificationPointer = 0;
        $this->positionReferencedProductPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);

        return isset($tradeLineItem[$this->positionPointer]);
    }

    /**
     * Seek to the next document position. Returns true if another position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionGenerals.
     *
     * @return boolean
     */
    public function nextDocumentPosition(): bool
    {
        $this->positionPointer++;

        $this->positionNotePointer = 0;
        $this->positionGrossPriceAllowanceChargePointer = 0;
        $this->positionTaxPointer = 0;
        $this->positionAllowanceChargePointer = 0;
        $this->positionAddRefDocPointer = 0;
        $this->positionAddRefObjDocPointer = 0;
        $this->positionProductCharacteristicPointer = 0;
        $this->positionProductClassificationPointer = 0;
        $this->positionReferencedProductPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);

        return isset($tradeLineItem[$this->positionPointer]);
    }

    /**
     * Get general information of the current position.
     *
     * @param  string      $lineId               __BT-126, From BASIC__ Identification of the invoice item
     * @param  string|null $lineStatusCode       __BT-X-7, From EXTENDED__ Indicates whether the invoice item contains prices that must be taken into account when calculating the invoice amount or whether only information is included.
     * @param  string|null $lineStatusReasonCode __BT-X-8, From EXTENDED__ Adds the type to specify whether the invoice line is:
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionGenerals(?string &$lineId, ?string &$lineStatusCode, ?string &$lineStatusReasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineID.value", "");
        $lineStatusCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineStatusCode.value", "");
        $lineStatusReasonCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineStatusReasonCode.value", "");

        return $this;
    }

    /**
     * Seek to the first document position. Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionNote.
     *
     * @return boolean
     */
    public function firstDocumentPositionNote(): bool
    {
        $this->positionNotePointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemNote = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getIncludedNote", []));

        return isset($tradeLineItemNote[$this->positionNotePointer]);
    }

    /**
     * Seek to the next document position. Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionNote.
     *
     * @return boolean
     */
    public function nextDocumentPositionNote(): bool
    {
        $this->positionNotePointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemNote = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getIncludedNote", []));

        return isset($tradeLineItemNote[$this->positionNotePointer]);
    }

    /**
     * Get detailed information on the free text on the position.
     *
     * @param  string      $content     __BT-127, From BASIC__ A free text that contains unstructured information that is relevant to the invoice item
     * @param  string|null $contentCode __BT-X-9, From EXTENDED__ A code to classify the content of the free text of the invoice. The code is agreed bilaterally and must have the same meaning as BT-127.
     * @param  string|null $subjectCode __BT-X-10, From EXTENDED__ Code for qualifying the free text for the invoice item (Codelist UNTDID 4451)
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionNote(?string &$content, ?string &$contentCode, ?string &$subjectCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemNote = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getIncludedNote", []));
        $tradeLineItemNote = $tradeLineItemNote[$this->positionNotePointer];

        $content = $this->getInvoiceValueByPathFrom($tradeLineItemNote, "getContent.value", "");
        $contentCode = $this->getInvoiceValueByPathFrom($tradeLineItemNote, "getContentCode.value", "");
        $subjectCode = $this->getInvoiceValueByPathFrom($tradeLineItemNote, "getSubjectCode.value", "");

        return $this;
    }

    /**
     * Get information about the goods and services billed.
     *
     * @param  string|null $name             __BT-153, From BASIC__ A name of the item (item name)
     * @param  string|null $description      __BT-154, From EN 16931__ A description of the item, the item description makes it possible to describe the item and its properties in more detail than is possible with the item name.
     * @param  string|null $sellerAssignedID __BT-155, From EN 16931__ An identifier assigned to the item by the seller
     * @param  string|null $buyerAssignedID  __BT-156, From EN 16931__ An identifier assigned to the item by the buyer. The article number of the buyer is a clear, bilaterally agreed identification of the product. It can, for example, be the customer article number or the article number assigned by the manufacturer.
     * @param  string|null $globalIDType     __BT-157-1, From BASIC__ The scheme for $globalID
     * @param  string|null $globalID         __BT-157, From BASIC__ Identification of an article according to the registered scheme (Global identifier of the product, GTIN, ...)
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionProductDetails(?string &$name, ?string &$description, ?string &$sellerAssignedID, ?string &$buyerAssignedID, ?string &$globalIDType, ?string &$globalID): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $name = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getName.value", "");
        $description = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getDescription.value", "");
        $sellerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getSellerAssignedID.value", "");
        $buyerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getBuyerAssignedID.value", "");
        $globalIDType = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getGlobalID.getSchemeID", "");
        $globalID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getGlobalID.value", "");

        return $this;
    }

    /**
     * Get information about the goods and services billed (Enhanced, with Model, Brand, etc.).
     *
     * @param  string|null $name               __BT-153, From BASIC__ A name of the item (item name)
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionProductDetailsExt(?string &$name, ?string &$description, ?string &$sellerAssignedID, ?string &$buyerAssignedID, ?string &$globalIDType, ?string &$globalID, ?string &$industryAssignedID, ?string &$modelID, ?string &$batchID, ?string &$brandName, ?string &$modelName): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $name = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getName.value", "");
        $description = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getDescription.value", "");
        $sellerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getSellerAssignedID.value", "");
        $buyerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getBuyerAssignedID.value", "");
        $globalIDType = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getGlobalID.getSchemeID", "");
        $globalID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getGlobalID.value", "");
        $industryAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getIndustryAssignedID.value", "");
        $modelID = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getModelID.value", "");
        $batchIDs = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getBatchID", "");
        $batchID = isset($batchIDs[0]) ? $this->getObjectHelper()->tryCallAndReturn($batchIDs[0], "value") : "";
        $brandName = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getBrandName.value", "");
        $modelName = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getModelName.value", "");

        return $this;
    }

    /**
     * Seek to the first document position's product characteristic. Returns true if the first position propduct characteristic is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionProductCharacteristic.
     *
     * @return boolean
     */
    public function firstDocumentPositionProductCharacteristic(): bool
    {
        $this->positionProductCharacteristicPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemProductCharacteristic = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getApplicableProductCharacteristic", []));

        return isset($tradeLineItemProductCharacteristic[$this->positionProductCharacteristicPointer]);
    }

    /**
     * Seek to the next document position's product characteristic. Returns true if more position propduct characteristics are available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionProductCharacteristic.
     *
     * @return boolean
     */
    public function nextDocumentPositionProductCharacteristic(): bool
    {
        $this->positionProductCharacteristicPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemProductCharacteristic = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getApplicableProductCharacteristic", []));

        return isset($tradeLineItemProductCharacteristic[$this->positionProductCharacteristicPointer]);
    }

    /**
     * Get extra characteristics to the formerly added product. Contains information about the characteristics of the goods and services invoiced.
     *
     * @param  string      $description          __BT-160, From EN 16931__ The name of the attribute or property of the product such as "Colour"
     * @param  string      $value                __BT-161, From EN 16931__ The value of the attribute or property of the product such as "Red"
     * @param  string|null $typeCode             __BT-X-11, From EXTENDED__ Type of product characteristic (code). The codes must be taken from the UNTDID 6313 codelist.
     * @param  float|null  $valueMeasure         __BT-X-12, From EXTENDED__ Value of the product property (numerical measured variable)
     * @param  string|null $valueMeasureUnitCode __BT-X-12-0, From EXTENDED__ Unit of measurement code
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionProductCharacteristic(?string &$description, ?string &$value, ?string &$typeCode, ?float &$valueMeasure, ?string &$valueMeasureUnitCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemProductCharacteristic = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getApplicableProductCharacteristic", []));
        $tradeLineItemProductCharacteristic = $tradeLineItemProductCharacteristic[$this->positionProductCharacteristicPointer];

        $description = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getDescription.value", "");
        $value = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getValue.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getTypeCode.value", "");
        $valueMeasure = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getValueMeasure.value", 0.0);
        $valueMeasureUnitCode = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getValueMeasure.getUnitCode", "");

        return $this;
    }

    /**
     * Seek to the first document position's product classification. Returns true if the first position propduct classification is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionProductClassification.
     *
     * @return boolean
     */
    public function firstDocumentPositionProductClassification(): bool
    {
        $this->positionProductClassificationPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemProductClassification = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getDesignatedProductClassification", []));

        return isset($tradeLineItemProductClassification[$this->positionProductClassificationPointer]);
    }

    /**
     * Seek to the next document position's product classification. Returns true if more position propduct classifications are available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionProductClassification.
     *
     * @return boolean
     */
    public function nextDocumentPositionProductClassification(): bool
    {
        $this->positionProductClassificationPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemProductClassification = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getDesignatedProductClassification", []));

        return isset($tradeLineItemProductClassification[$this->positionProductClassificationPointer]);
    }

    /**
     * Get detailed information on product classification.
     *
     * @param  string      $classCode     __BT-158, From EN 16931__ Item classification identifier. Classification codes are used for grouping similar items that can serve different purposes, such as public procurement (according to the Common Procurement Vocabulary ([CPV]), e-commerce (UNSPSC), etc.
     * @param  string|null $className     __BT-X-138, From EXTENDED__ Name with which an article can be classified according to type or quality.
     * @param  string|null $listID        __BT-158-1, From EN 16931__ The identifier for the identification scheme of the item classification identifier. The identification scheme must be selected from the entries in UNTDID 7143 [6].
     * @param  string|null $listVersionID __BT-158-2, From EN 16931__ The version of the identification scheme
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionProductClassification(?string &$classCode, ?string &$className, ?string &$listID, ?string &$listVersionID): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemProductClassification = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getDesignatedProductClassification", []));
        $tradeLineItemProductClassification = $tradeLineItemProductClassification[$this->positionProductClassificationPointer];

        $classCode = $this->getInvoiceValueByPathFrom($tradeLineItemProductClassification, "getClassCode.value", "");
        $className = $this->getInvoiceValueByPathFrom($tradeLineItemProductClassification, "getClassName.value", "");
        $listID = $this->getInvoiceValueByPathFrom($tradeLineItemProductClassification, "getClassCode.getListID", "");
        $listVersionID = $this->getInvoiceValueByPathFrom($tradeLineItemProductClassification, "getClassCode.getListVersionID", "");

        return $this;
    }

    /**
     * Seek to the first document position's referenced product. Returns true if the first position referenced product is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionReferencedProduct.
     *
     * @return boolean
     */
    public function firstDocumentPositionReferencedProduct(): bool
    {
        $this->positionReferencedProductPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemReferencedProduct = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getIncludedReferencedProduct", []));

        return isset($tradeLineItemReferencedProduct[$this->positionReferencedProductPointer]);
    }

    /**
     * Seek to the next document position's referenced product. Returns true if more position referenced products are available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionReferencedProduct.
     *
     * @return boolean
     */
    public function nextDocumentPositionReferencedProduct(): bool
    {
        $this->positionReferencedProductPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemReferencedProduct = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getIncludedReferencedProduct", []));

        return isset($tradeLineItemReferencedProduct[$this->positionReferencedProductPointer]);
    }

    /**
     * Get detailed information on included products. This information relates to the product that has just been added.
     *
     * @param  string      $name               __BT-X-18, From EXTENDED__ Name of the referenced product contained
     * @param  string|null $description        __BT-X-19, From EXTENDED__ Description of the included referenced product
     * @param  string|null $sellerAssignedID   __BT-X-16, From EXTENDED__ ID assigned by the seller of the contained referenced product
     * @param  string|null $buyerAssignedID    __BT-X-17, From EXTENDED__ ID of the referenced product assigned by the buyer
     * @param  array|null  $globalID           __BT-X-15, From EXTENDED__ Array of global ids of the referenced product indexed by the identification scheme.
     * @param  float|null  $unitQuantity       __BT-X-20, From EXTENDED__ Quantity of the referenced product contained
     * @param  string|null $unitCode           __BT-X-20-1, From EXTENDED__ Unit code of Quantity of the referenced product contained
     * @param  string|null $industryAssignedID __BT-X-309, From EXTENDED__ ID of the referenced product contained assigned by the industry
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionReferencedProduct(?string &$name, ?string &$description, ?string &$sellerAssignedID, ?string &$buyerAssignedID, ?array &$globalID, ?float &$unitQuantity, ?string &$unitCode, ?string &$industryAssignedID): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemReferencedProduct = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getIncludedReferencedProduct", []));
        $tradeLineItemReferencedProduct = $tradeLineItemReferencedProduct[$this->positionReferencedProductPointer];

        $name = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getName.value", "");
        $description = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getDescription.value", "");
        $sellerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getSellerAssignedID.value", "");
        $buyerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getBuyerAssignedID.value", "");
        $industryAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getIndustryAssignedID.value", "");
        $unitQuantity = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getUnitQuantity.value", 0);
        $unitCode = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getUnitQuantity.getUnitCode", "");
        $globalID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Sets the detailed information on the product origin.
     *
     * @param  string|null $country __BT-159, From EN 16931__ The code indicating the country the goods came from. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their subdivisions”.
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionProductOriginTradeCountry(?string &$country): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $country = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getOriginTradeCountry.getID.value", "");

        return $this;
    }

    /**
     * Get details of a related sales order reference.
     *
     * @param  string|null   $issuerAssignedId __BT-X-537, From EXTENDED__ Document number of a sales order reference
     * @param  string|null   $lineId           __BT-X-538, From EXTENDED__ An identifier for a position within a sales order.
     * @param  DateTime|null $issueDate        __BT-X-539, From EXTENDED__ Date of sales order
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionSellerOrderReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getSellerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getSellerOrderReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Get details of the related buyer order position.
     *
     * @param  string|null   $issuerAssignedId __BT-X-21, From EXTENDED__ An identifier issued by the buyer for a referenced order (order number)
     * @param  string|null   $lineId           __BT-132, From EN 16931__ An identifier for a position within an order placed by the buyer. Note: Reference is made to the order reference at the document level.
     * @param  DateTime|null $issueDate        __BT-X-22, From EXTENDED__ Date of order
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionBuyerOrderReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Get details of the associated offer position.
     *
     * @param  string|null   $issuerAssignedId __BT-X-310, From EXTENDED__ Offer number
     * @param  string|null   $lineId           __BT-X-311, From EXTENDED__ Position identifier within the offer
     * @param  DateTime|null $issueDate        __BT-X-312, From EXTENDED__ Date of offder
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionQuotationReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getQuotationReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getQuotationReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getQuotationReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getQuotationReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Get details of the related contract position.
     *
     * @param  string|null   $issuerAssignedId __BT-X-24, From EXTENDED__ The contract reference should be assigned once in the context of the specific trade relationship and for a defined period of time (contract number)
     * @param  string|null   $lineId           __BT-X-25, From EXTENDED__ Identifier of the according contract position
     * @param  DateTime|null $issueDate        __BT-X-26, From EXTENDED__ Contract date
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionContractReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Seek to the first documents position additional referenced document. Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAdditionalReferencedDocument.
     *
     * @return boolean
     */
    public function firstDocumentPositionAdditionalReferencedDocument(): bool
    {
        $this->positionAddRefDocPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));

        return isset($addRefDoc[$this->positionAddRefDocPointer]);
    }

    /**
     * Seek to the next documents position additional referenced document. Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAdditionalReferencedDocument.
     *
     * @return boolean
     */
    public function nextDocumentPositionAdditionalReferencedDocument(): bool
    {
        $this->positionAddRefDocPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));

        return isset($addRefDoc[$this->positionAddRefDocPointer]);
    }

    /**
     * Details of an additional Document reference (on position level).
     *
     * - The documents justifying the invoice can be used to reference a document number, which should be
     *   known to the recipient, as well as an external document (referenced by a URL) or an embedded document (such
     *   as a timesheet as a PDF file). The option of linking to an external document is e.g. required when it comes
     *   to large attachments and / or sensitive information, e.g. for personal services, which must be separated
     *   from the bill
     * - Use ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument and
     *   ZugferdDocumentReader::nextDocumentAdditionalReferencedDocument to seek between multiple additional referenced
     *   documents
     *
     * @param  string|null   $issuerAssignedId   __BT-X-27, From EXTENDED__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string|null   $typeCode           __BT-X-30, From EXTENDED__ Type of referenced document (See codelist UNTDID 1001)
     * @param  string|null   $uriId              __BT-X-28, From EXTENDED__ The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document must be used if the buyer needs additional information to support the amounts billed. External documents are not part of the invoice. Access to external documents can involve certain risks.
     * @param  string|null   $lineId             __BT-X-29, From EXTENDED__ The referenced position identifier in the additional document
     * @param  array|null    $name               __BT-X-299, From EXTENDED__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null   $refTypeCode        __BT-X-32, From EXTENDED__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTime|null $issueDate          __BT-X-33, From EXTENDED__ Document date
     * @param  string|null   $binaryDataFilename __BT-X-31, From EXTENDED__ Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAdditionalReferencedDocument(?string &$issuerAssignedId, ?string &$typeCode, ?string &$uriId, ?string &$lineId, ?array &$name, ?string &$refTypeCode, ?DateTime &$issueDate, ?string &$binaryDataFilename): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));
        $addRefDoc = $addRefDoc[$this->positionAddRefDocPointer];

        $typeCode = $this->getInvoiceValueByPathFrom($addRefDoc, "getTypeCode.value", "");
        $issuerAssignedId = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $refTypeCode = $this->getInvoiceValueByPathFrom($addRefDoc, "getReferenceTypeCode.value", "");
        $uriId = $this->getInvoiceValueByPathFrom($addRefDoc, "getURIID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($addRefDoc, "getLineID.value", "");
        $name = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($addRefDoc, "getName.value", null));
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        $binaryDataFilename = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.getFilename", "");
        $binarydata = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.value", "");

        if (
            StringUtils::stringIsNullOrEmpty($binaryDataFilename) === false
            && StringUtils::stringIsNullOrEmpty($binarydata) === false
            && StringUtils::stringIsNullOrEmpty($this->binarydatadirectory) === false
        ) {
            $binaryDataFilename = PathUtils::combinePathWithFile($this->binarydatadirectory, $binaryDataFilename);
            FileUtils::base64ToFile($binarydata, $binaryDataFilename);
        } else {
            $binaryDataFilename = "";
        }

        return $this;
    }

    //TODO: DocumentPositionUltimateCustomerOrderReferencedDocument

    /**
     * Get the unit price excluding sales tax before deduction of the discount on the item price.
     *
     * @param  float       $amount                __BT-148, From BASIC__ The unit price excluding sales tax before deduction of the discount on the item price. If the price is shown according to the net calculation, the price must also be shown according to the gross calculation.
     * @param  float|null  $basisQuantity         __BT-149-1, From BASIC__ The number of item units for which the price applies (price base quantity)
     * @param  string|null $basisQuantityUnitCode __BT-150-1, From BASIC__ The unit code of the number of item units for which the price applies (price base quantity)
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionGrossPrice(?float &$amount, ?float &$basisQuantity, ?string &$basisQuantityUnitCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $amount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getChargeAmount.value", 0.0);
        $basisQuantity = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getBasisQuantity.value", 0.0);
        $basisQuantityUnitCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getBasisQuantity.getUnitCode", "");

        return $this;
    }

    /**
     * Seek to the first documents position gross price allowance charge position. Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionGrossPriceAllowanceCharge.
     *
     * @return boolean
     */
    public function firstDocumentPositionGrossPriceAllowanceCharge(): bool
    {
        $this->positionGrossPriceAllowanceChargePointer = 0;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getAppliedTradeAllowanceCharge", []));
        return isset($allowanceCharge[$this->positionGrossPriceAllowanceChargePointer]);
    }

    /**
     * Seek to the next documents position gross price allowance charge position. Returns true if a other position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionGrossPriceAllowanceCharge.
     *
     * @return boolean
     */
    public function nextDocumentPositionGrossPriceAllowanceCharge(): bool
    {
        $this->positionGrossPriceAllowanceChargePointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getAppliedTradeAllowanceCharge", []));

        return isset($allowanceCharge[$this->positionGrossPriceAllowanceChargePointer]);
    }

    /**
     * Get Detailed information on surcharges and discounts on item gross price.
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionGrossPriceAllowanceCharge(?float &$actualAmount, ?bool &$isCharge, ?float &$calculationPercent, ?float &$basisAmount, ?string &$reason, ?string &$taxTypeCode, ?string &$taxCategoryCode, ?float &$rateApplicablePercent, ?float &$sequence, ?float &$basisQuantity, ?string &$basisQuantityUnitCode, ?string &$reasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getAppliedTradeAllowanceCharge", []));
        $allowanceCharge = $allowanceCharge[$this->positionGrossPriceAllowanceChargePointer];

        $actualAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getActualAmount.value", 0.0);
        $isCharge = $this->getInvoiceValueByPathFrom($allowanceCharge, "getChargeIndicator.getIndicator", false);
        $calculationPercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCalculationPercent.value", 0.0);
        $basisAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisAmount.value", 0.0);
        $reason = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReason.value", "");
        $taxTypeCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getTypeCode.value", "");
        $taxCategoryCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getCategoryCode.value", "");
        $rateApplicablePercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getRateApplicablePercent.value", 0.0);
        $sequence = $this->getInvoiceValueByPathFrom($allowanceCharge, "getSequenceNumeric.value", 0.0);
        $basisQuantity = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisQuantity.value", 0.0);
        $basisQuantityUnitCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisQuantity.getUnitCode", "");
        $reasonCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReasonCode.value", "");

        return $this;
    }

    /**
     * Get detailed information on the net price of the item.
     *
     * @param  float       $amount                __BT-146, From BASIC__ Net price of the item
     * @param  float|null  $basisQuantity         __BT-149, From BASIC__ Base quantity at the item price
     * @param  string|null $basisQuantityUnitCode __BT-150, From BASIC__ Code of the unit of measurement of the base quantity at the item price
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionNetPrice(?float &$amount, ?float &$basisQuantity, ?string &$basisQuantityUnitCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $amount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getChargeAmount.value", 0.0);
        $basisQuantity = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getBasisQuantity.value", 0.0);
        $basisQuantityUnitCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getBasisQuantity.getUnitCode", "");

        return $this;
    }

    /**
     * Tax included for B2C on position level.
     *
     * @param  string|null $categoryCode          __BT-, From __ Coded description of a sales tax category
     * @param  string|null $typeCode              __BT-, From __ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float|null  $rateApplicablePercent __BT-, From __ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null  $calculatedAmount      __BT-, From __ The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying the amount to be taxed according to the sales tax category by the sales tax rate applicable for the sales tax category concerned
     * @param  string|null $exemptionReason       __BT-, From __ Reason for tax exemption (free text)
     * @param  string|null $exemptionReasonCode   __BT-, From __ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility.
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionNetPriceTax(?string &$categoryCode, ?string &$typeCode, ?float &$rateApplicablePercent, ?float &$calculatedAmount, ?string &$exemptionReason, ?string &$exemptionReasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $categoryCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getIncludedTradeTax.getCategoryCode.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getIncludedTradeTax.getTypeCode.value", "");
        $rateApplicablePercent = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getIncludedTradeTax.getRateApplicablePercent.value", 0.0);
        $calculatedAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getIncludedTradeTax.getCalculatedAmount.value", 0.0);
        $exemptionReason = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getIncludedTradeTax.getExemptionReason.value", "");
        $exemptionReasonCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getNetPriceProductTradePrice.getIncludedTradeTax.getExemptionReasonCode.value", "");

        return $this;
    }

    /**
     * Get the position Quantity.
     *
     * @param  float|null  $billedQuantity             __BT-129, From BASIC__ The quantity of individual items (goods or services) billed in the relevant line
     * @param  string|null $billedQuantityUnitCode     __BT-130, From BASIC__ The unit of measure applicable to the amount billed
     * @param  float|null  $chargeFreeQuantity         __BT-X-46, From EXTENDED__ Quantity, free of charge
     * @param  string|null $chargeFreeQuantityUnitCpde __BT-X-46-0, From EXTENDED__ Unit of measure code for the quantity free of charge
     * @param  float|null  $packageQuantity            __BT-X-47, From EXTENDED__ Number of packages
     * @param  string|null $packageQuantityUnitCode    __BT-X-47-0, From EXTENDED__ Unit of measure code for number of packages
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionQuantity(?float &$billedQuantity, ?string &$billedQuantityUnitCode, ?float &$chargeFreeQuantity, ?string &$chargeFreeQuantityUnitCpde, ?float &$packageQuantity, ?string &$packageQuantityUnitCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $billedQuantity = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getBilledQuantity.value", 0.0);
        $billedQuantityUnitCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getBilledQuantity.getUnitCode", "");
        $chargeFreeQuantity = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getChargeFreeQuantity.value", 0.0);
        $chargeFreeQuantityUnitCpde = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getChargeFreeQuantity.getUnitCode", "");
        $packageQuantity = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getPackageQuantity.value", 0.0);
        $packageQuantityUnitCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getPackageQuantity.getUnitCode", "");

        return $this;
    }

    //TODO: GetDocumentPositionShipTo
    //TODO: GetDocumentPositionUltimateShipTo

    /**
     * Get detailed information on the actual delivery (on position level).
     *
     * @param  DateTime|null $date __BT-X-85, From EXTENDED__ Actual delivery date
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionSupplyChainEvent(?DateTime &$date): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $date = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get detailed information on the associated shipping notification (on position level).
     *
     * @param  string|null   $issuerAssignedId __BT-X-86, From EXTENDED__ Shipping notification number
     * @param  string|null   $lineId           __BT-X-87, From EXTENDED__ Shipping notification position
     * @param  DateTime|null $issueDate        __BT-X-88, From EXTENDED__ Date of Shipping notification number
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionDespatchAdviceReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification (on position level).
     *
     * @param  string|null   $issuerAssignedId __BT-X-89, From EXTENDED__ Goods receipt number
     * @param  string|null   $lineId           __BT-X-90, From EXTENDED__ Goods receipt position
     * @param  DateTime|null $issueDate        __BT-X-91, From EXTENDED__ Date of Goods receipt
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionReceivingAdviceReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated delivery note on position level.
     *
     * @param  string|null   $issuerAssignedId __BT-X-92, From EXTENDED__ Delivery note number
     * @param  string|null   $lineId           __BT-X-93, From EXTENDED__ Delivery note position
     * @param  DateTime|null $issueDate        __BT-X-94, From EXTENDED__ Date of Delivery note
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionDeliveryNoteReferencedDocument(?string &$issuerAssignedId, ?string &$lineId, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getIssuerAssignedID.value", "");
        $lineId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getLineID.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first document position tax. Returns true if the first tax position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionTax.
     *
     * @return boolean
     */
    public function firstDocumentPositionTax(): bool
    {
        $this->positionTaxPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $taxes = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getApplicableTradeTax", []));

        return isset($taxes[$this->positionTaxPointer]);
    }

    /**
     * Seek to the next document position tax. Returns true if another tax position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionTax.
     *
     * @return boolean
     */
    public function nextDocumentPositionTax(): bool
    {
        $this->positionTaxPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $taxes = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getApplicableTradeTax", []));

        return isset($taxes[$this->positionTaxPointer]);
    }

    /**
     * Get information about the sales tax that applies to the goods and services invoiced in the relevant invoice line.
     *
     * @param  string|null $categoryCode          __BT-151, From BASIC__ Coded description of a sales tax category
     * @param  string|null $typeCode              __BT-151-0, From BASIC__ In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for the tax type must then be taken from the code list UNTDID 5153.
     * @param  float|null  $rateApplicablePercent __BT-152, From BASIC__ The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales tax category and the category-specific sales tax rate  must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null  $calculatedAmount      __BT-, From __ Tax amount. Information only for taxes that are not VAT (Obsolete)
     * @param  string|null $exemptionReason       __BT-, From __ Reason for tax exemption (free text) (Obsolete)
     * @param  string|null $exemptionReasonCode   __BT-, From __ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility. (Obsolete)
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionTax(?string &$categoryCode, ?string &$typeCode, ?float &$rateApplicablePercent, ?float &$calculatedAmount, ?string &$exemptionReason, ?string &$exemptionReasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $taxes = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getApplicableTradeTax", []));
        $taxes = $taxes[$this->positionTaxPointer];

        $categoryCode = $this->getInvoiceValueByPathFrom($taxes, "getCategoryCode.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($taxes, "getTypeCode.value", "");
        $rateApplicablePercent = $this->getInvoiceValueByPathFrom($taxes, "getRateApplicablePercent.value", 0.0);
        $calculatedAmount = $this->getInvoiceValueByPathFrom($taxes, "getCalculatedAmount.value", 0.0);
        $exemptionReason = $this->getInvoiceValueByPathFrom($taxes, "getExemptionReason.value", "");
        $exemptionReasonCode = $this->getInvoiceValueByPathFrom($taxes, "getExemptionReasonCode.value", "");

        return $this;
    }

    /**
     * Get information about the period relevant for the invoice item. Also known as the invoice line delivery period.
     *
     * @param  DateTime|null $startDate __BT-134, From BASIC__ Start of the billing period
     * @param  DateTime|null $endDate   __BT-135, From BASIC__ End of the billing period
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionBillingPeriod(?DateTime &$startDate, ?DateTime &$endDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $startDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.getFormat", null)
        );
        $endDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Seek to the first allowance charge (on position level). Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAllowanceCharge.
     *
     * @return boolean
     */
    public function firstDocumentPositionAllowanceCharge(): bool
    {
        $this->positionAllowanceChargePointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));

        return isset($allowanceCharge[$this->positionAllowanceChargePointer]);
    }

    /**
     * Seek to the next allowance charge (on position level). Returns true if another position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAllowanceCharge.
     *
     * @return boolean
     */
    public function nextDocumentPositionAllowanceCharge(): bool
    {
        $this->positionAllowanceChargePointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));

        return isset($allowanceCharge[$this->positionAllowanceChargePointer]);
    }

    /**
     * Detailed information on currentley seeked surcharges and discounts on position level.
     *
     * @param  float|null   $actualAmount          __BT-136/BT-141, From BASIC__ The surcharge/discount amount excluding sales tax
     * @param  boolean|null $isCharge              __BT-27-1/BT-28-1, From BASIC__ (true for BT-/ and false for /BT-) Switch that indicates whether the following data refer to an allowance or a discount, true means that it is a surcharge
     * @param  float|null   $calculationPercent    __BT-138, From BASIC__ The percentage that may be used in conjunction with the base invoice line discount amount to calculate the invoice line discount amount
     * @param  float|null   $basisAmount           __BT-137, From EN 16931__ The base amount that may be used in conjunction with the invoice line discount percentage to calculate the invoice line discount amount
     * @param  string|null  $reason                __BT-139/BT-144, From BASIC__ The reason given in text form for the invoice item discount/surcharge
     * @param  string|null  $taxTypeCode
     * @param  string|null  $taxCategoryCode
     * @param  float|null   $rateApplicablePercent
     * @param  float|null   $sequence
     * @param  float|null   $basisQuantity
     * @param  string|null  $basisQuantityUnitCode
     * @param  string|null  $reasonCode            __BT-140/BT-145, From BASIC__ The reason given as a code for the invoice line discount
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAllowanceCharge(?float &$actualAmount, ?bool &$isCharge, ?float &$calculationPercent, ?float &$basisAmount, ?string &$reason, ?string &$taxTypeCode, ?string &$taxCategoryCode, ?float &$rateApplicablePercent, ?float &$sequence, ?float &$basisQuantity, ?string &$basisQuantityUnitCode, ?string &$reasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));
        $allowanceCharge = $allowanceCharge[$this->positionAllowanceChargePointer];

        $actualAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getActualAmount.value", 0.0);
        $isCharge = $this->getInvoiceValueByPathFrom($allowanceCharge, "getChargeIndicator.getIndicator", false);
        $calculationPercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCalculationPercent.value", 0.0);
        $basisAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisAmount.value", 0.0);
        $reason = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReason.value", "");
        $taxTypeCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getTypeCode.value", "");
        $taxCategoryCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getCategoryCode.value", "");
        $rateApplicablePercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCategoryTradeTax.getRateApplicablePercent.value", 0.0);
        $sequence = $this->getInvoiceValueByPathFrom($allowanceCharge, "getSequenceNumeric.value", 0.0);
        $basisQuantity = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisQuantity.value", 0.0);
        $basisQuantityUnitCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisQuantity.getUnitCode", "");
        $reasonCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReasonCode.value", "");

        return $this;
    }

    /**
     * Detailed information on surcharges and discounts on position level (on a simple way).
     * This is the simplified version of ZugferdDocumentReader::getDocumentPositionAllowanceCharge.
     *
     * @param  float|null   $actualAmount       __BT-136/BT-141, From BASIC__ The surcharge/discount amount excluding sales tax
     * @param  boolean|null $isCharge           __BT-27-1/BT-28-1, From BASIC__ (true for BT-/ and false for /BT-) Switch that indicates whether the following data refer to an allowance or a discount, true means that it is a surcharge
     * @param  float|null   $calculationPercent __BT-138, From BASIC__ The percentage that may be used in conjunction with the base invoice line discount amount to calculate the invoice line discount amount
     * @param  float|null   $basisAmount        __BT-137, From EN 16931__ The base amount that may be used in conjunction with the invoice line discount percentage to calculate the invoice line discount amount
     * @param  string|null  $reasonCode         __BT-140/BT-145, From BASIC__ The reason given as a code for the invoice line discount
     * @param  string|null  $reason             __BT-139/BT-144, From BASIC__ The reason given in text form for the invoice item discount/surcharge
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAllowanceCharge2(?float &$actualAmount, ?bool &$isCharge, ?float &$calculationPercent, ?float &$basisAmount, ?string &$reasonCode, ?string &$reason): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));
        $allowanceCharge = $allowanceCharge[$this->positionAllowanceChargePointer];

        $actualAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getActualAmount.value", 0.0);
        $isCharge = $this->getInvoiceValueByPathFrom($allowanceCharge, "getChargeIndicator.getIndicator", false);
        $calculationPercent = $this->getInvoiceValueByPathFrom($allowanceCharge, "getCalculationPercent.value", 0.0);
        $basisAmount = $this->getInvoiceValueByPathFrom($allowanceCharge, "getBasisAmount.value", 0.0);
        $reason = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReason.value", "");
        $reasonCode = $this->getInvoiceValueByPathFrom($allowanceCharge, "getReasonCode.value", "");

        return $this;
    }

    /**
     * Get detailed information on item totals.
     *
     * @param      float|null $lineTotalAmount            __BT-131, From BASIC__ The total amount of the invoice item.
     * @param      float|null $totalAllowanceChargeAmount __BT-, From __ Total amount of item surcharges and discounts
     * @return     ZugferdDocumentReader
     * @deprecated 1.0.88
     */
    public function getDocumentPositionLineSummation(?float &$lineTotalAmount, ?float &$totalAllowanceChargeAmount): ZugferdDocumentReader
    {
        $totalAllowanceChargeAmount = 0.0;

        $this->getDocumentPositionLineSummationSimple($lineTotalAmount);

        return $this;
    }

    /**
     * Get detailed information on item totals.
     *
     * @param  float $lineTotalAmount __BT-131, From BASIC__ The total amount of the invoice item.
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionLineSummationSimple(?float &$lineTotalAmount): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $lineTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getLineTotalAmount.value", 0.0);

        return $this;
    }

    /**
     * Get detailed information on item totals (with support for EXTENDED profile).
     *
     * @param  float $lineTotalAmount            __BT-131, From BASIC__ The total amount of the invoice item
     * @param  float $chargeTotalAmount          __BT-X-327, From EXTENDED__ Total amount of item surcharges
     * @param  float $allowanceTotalAmount       __BT-X-328, From EXTENDED__ Total amount of item discounts
     * @param  float $taxTotalAmount             __BT-X-329, From EXTENDED__ Total amount of item taxes
     * @param  float $grandTotalAmount           __BT-X-330, From EXTENDED__ Total gross amount of the item
     * @param  float $totalAllowanceChargeAmount __BT-X-98, From EXTENDED__ Total amount of item surcharges and discounts
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionLineSummationExt(?float &$lineTotalAmount, ?float &$chargeTotalAmount, ?float &$allowanceTotalAmount, ?float &$taxTotalAmount, ?float &$grandTotalAmount, ?float &$totalAllowanceChargeAmount): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $lineTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getLineTotalAmount.value", 0.0);
        $chargeTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getChargeTotalAmount.value", 0.0);
        $allowanceTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getAllowanceTotalAmount.value", 0.0);
        $taxTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getTaxTotalAmount.value", 0.0);
        $grandTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getGrandTotalAmount.value", 0.0);
        $totalAllowanceChargeAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getTotalAllowanceChargeAmount.value", 0.0);

        return $this;
    }

    /**
     * Get a Reference to the previous invoice (on position level).
     *
     * @param  string|null   $issuerAssignedId __BT-X-331, From EXTENDED__ The identification of an invoice previously sent by the seller
     * @param  string|null   $lineid           __BT-X-540, From EXTENDED__ Identification of the invoice item
     * @param  string|null   $typeCode         __BT-X-332, From EXTENDED__ Type of previous invoice (code)
     * @param  DateTime|null $issueDate        __BT-X-333, From EXTENDED__ Date of the previous invoice
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionInvoiceReferencedDocument(?string &$issuerAssignedId, ?string &$lineid, ?string &$typeCode, ?DateTime &$issueDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerAssignedId = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getInvoiceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getInvoiceReferencedDocument.getLineID.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getInvoiceReferencedDocument.getTypeCode.value", "");
        $issueDate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getInvoiceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getInvoiceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first documents position additional referenced document (Object detection at the level of the accounting position). Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAdditionalReferencedObjDocument.
     *
     * @return boolean
     */
    public function firstDocumentPositionAdditionalReferencedObjDocument(): bool
    {
        $this->positionAddRefObjDocPointer = 0;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getAdditionalReferencedDocument", []));

        return isset($addRefDoc[$this->positionAddRefObjDocPointer]);
    }

    /**
     * Seek to the next documents position additional referenced document (Object detection at the level of the accounting position). Returns true if the first position is available, otherwise false.
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAdditionalReferencedObjDocument.
     *
     * @return boolean
     */
    public function nextDocumentPositionAdditionalReferencedObjDocument(): bool
    {
        $this->positionAddRefObjDocPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getAdditionalReferencedDocument", []));

        return isset($addRefDoc[$this->positionAddRefObjDocPointer]);
    }

    /**
     * Get additional Document reference on a position (Object detection).
     *
     * @param  string|null $issuerAssignedId __BT-128, From EN 16931__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string|null $typeCode         __BT-128-0, From EN 16931__ Type of referenced document (See codelist UNTDID 1001)
     * @param  string|null $refTypeCode      __BT-128-1, From EN 16931__ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAdditionalReferencedObjDocument(?string &$issuerAssignedId, ?string &$typeCode, ?string &$refTypeCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getAdditionalReferencedDocument", []));
        $addRefDoc = $addRefDoc[$this->positionAddRefObjDocPointer];

        $typeCode = $this->getInvoiceValueByPathFrom($addRefDoc, "getTypeCode.value", "");
        $issuerAssignedId = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $refTypeCode = $this->getInvoiceValueByPathFrom($addRefDoc, "getReferenceTypeCode.value", "");

        return $this;
    }

    /**
     * Get information on the booking reference (on position level).
     *
     * @param  null|string &$id       __BT-133, From EN 16931__ Posting reference of the byuer. If required, this reference shall be provided by the Buyer to the Seller prior to the issuing of the Invoice.
     * @param  null|string &$typeCode __BT-X-99, From EXTENDED__ Type of the posting reference
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionReceivableSpecifiedTradeAccountingAccount(?string &$id, ?string &$typeCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $id = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getReceivableSpecifiedTradeAccountingAccount.getId.value", "");
        $typeCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getReceivableSpecifiedTradeAccountingAccount.getTypeCode.value", "");

        return $this;
    }

    /**
     * Function to return a value from $invoiceObject by path
     *
     * @param  string $methods
     * @param  mixed  $defaultValue
     * @return mixed
     */
    private function getInvoiceValueByPath(string $methods, $defaultValue)
    {
        return $this->getInvoiceValueByPathFrom($this->getInvoiceObject(), $methods, $defaultValue);
    }

    /**
     * Function to return a value from $from by path
     *
     * @param  object|null $from
     * @param  string      $methods
     * @param  mixed       $defaultValue
     * @return mixed
     */
    private function getInvoiceValueByPathFrom(?object $from, string $methods, $defaultValue)
    {
        return $this->getObjectHelper()->tryCallByPathAndReturn($from, $methods) ?? $defaultValue;
    }

    /**
     * Convert to array
     *
     * @param  mixed $value
     * @param  array $methods
     * @return array
     */
    private function convertToArray($value, array $methods)
    {
        $result = [];
        $isFlat = count($methods) == 1;
        $value = $this->getObjectHelper()->ensureArray($value);

        foreach ($value as $valueItem) {
            $resultItem = [];

            foreach ($methods as $methodKey => $method) {
                if (is_array($method)) {
                    $defaultValue = $method[1];
                    $method = $method[0];
                } else {
                    $defaultValue = null;
                }

                if ($method instanceof Closure) {
                    $itemValue = $method($valueItem);
                } else {
                    $itemValue = $this->getObjectHelper()->tryCallByPathAndReturn($valueItem, $method) ?? $defaultValue;
                }

                if ($isFlat) {
                    $result[] = $itemValue;
                } else {
                    $resultItem[$methodKey] = $itemValue;
                }
            }

            if (!$isFlat) {
                $result[] = $resultItem;
            }
        }

        return $result;
    }

    /**
     * Convert to associative array
     *
     * @param  mixed  $value
     * @param  string $methodKey
     * @param  string $methodValue
     * @return array
     */
    private function convertToAssociativeArray($value, string $methodKey, string $methodValue)
    {
        $result = [];
        $value = $this->getObjectHelper()->ensureArray($value);

        foreach ($value as $valueItem) {
            $theValueForKey = $this->getObjectHelper()->tryCallByPathAndReturn($valueItem, $methodKey);
            $theValueForValue = $this->getObjectHelper()->tryCallByPathAndReturn($valueItem, $methodValue);

            if (!ZugferdObjectHelper::isNullOrEmpty($theValueForKey) && !ZugferdObjectHelper::isNullOrEmpty($theValueForValue)) {
                $result[$theValueForKey] = $theValueForValue;
            }
        }

        return $result;
    }
}
