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
use horstoeko\zugferd\ZugferdProfileResolver;

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
     * Guess the profile type of a xml file
     *
     * @codeCoverageIgnore
     *
     * @param  string $xmlfilename The filename to read invoice data from
     * @return ZugferdDocumentReader
     */
    public static function readAndGuessFromFile(string $xmlfilename): ZugferdDocumentReader
    {
        if (!file_exists($xmlfilename)) {
            throw new ZugferdFileNotFoundException($xmlfilename);
        }

        return self::readAndGuessFromContent(file_get_contents($xmlfilename));
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @codeCoverageIgnore
     *
     * @param  string $xmlcontent The XML content as a string to read the invoice data from
     * @return ZugferdDocumentReader
     */
    public static function readAndGuessFromContent(string $xmlcontent): ZugferdDocumentReader
    {
        $profileId = ZugferdProfileResolver::resolveProfileId($xmlcontent);

        return (new static($profileId))->readContent($xmlcontent);
    }

    /**
     * Set the directory where the attached binary data from
     * additional referenced documents are temporary stored
     *
     * @param  string $binarydatadirectory
     * @return ZugferdDocumentReader
     */
    public function setBinaryDataDirectory(string $binarydatadirectory): ZugferdDocumentReader
    {
        if ($binarydatadirectory) {
            if (is_dir($binarydatadirectory)) {
                $this->binarydatadirectory = $binarydatadirectory;
            }
        }

        return $this;
    }

    /**
     * Read content of a zuferd/xrechnung xml from a string
     *
     * @codeCoverageIgnore
     *
     * @param  string $xmlcontent The XML content as a string to read the invoice data from
     * @return ZugferdDocumentReader
     */
    private function readContent(string $xmlcontent): ZugferdDocumentReader
    {
        $this->deserialize($xmlcontent);

        return $this;
    }

    /**
     * Read general information about the document
     *
     * @param  string|null   $documentno               Returns the document no issued by the seller
     * @param  string|null   $documenttypecode         Returns the type of the document, See \horstoeko\codelists\ZugferdInvoiceType for details
     * @param  DateTime|null $documentdate             Returns the date when the document was issued by the seller
     * @param  string|null   $invoiceCurrency          Returns the code for the invoice currency
     * @param  string|null   $taxCurrency              Returns the code for the currency of the VAT posting
     * @param  string|null   $documentname             Returns the document type (free text)
     * @param  string|null   $documentlanguage         Returns the language code in which the document was written
     * @param  DateTime|null $effectiveSpecifiedPeriod Returns the contractual due date of the invoice
     * @return ZugferdDocumentReader
     */
    public function getDocumentInformation(?string &$documentno, ?string &$documenttypecode, ?DateTime &$documentdate, ?string &$invoiceCurrency, ?string &$taxCurrency, ?string &$documentname, ?string &$documentlanguage, ?DateTime &$effectiveSpecifiedPeriod): ZugferdDocumentReader
    {
        $documentno = $this->getInvoiceValueByPath("getExchangedDocument.getID", "");
        $documenttypecode = $this->getInvoiceValueByPath("getExchangedDocument.getTypeCode.value", "");
        $documentdate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString.getFormat", "")
        );
        $invoiceCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");
        $taxCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getTaxCurrencyCode.value", "");
        $documentname = $this->getInvoiceValueByPath("getExchangedDocument.getName.value", "");
        $documentlanguages = $this->getInvoiceValueByPath("getExchangedDocument.getLanguageID", []);
        $documentlanguage = (isset($documentlanguages[0]) ? $this->getObjectHelper()->tryCallByPathAndReturn($documentlanguages[0], "value") : "");
        $effectiveSpecifiedPeriod = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString.getFormat", "")
        );
        return $this;
    }

    /**
     * Read general payment information
     *
     * @param  string|null $creditorReferenceID
     * Returns the identifier of the creditor (SEPA)
     * @param  string|null $paymentReference
     * Returns the Usage (SEPA)
     * @return ZugferdDocumentReader
     */
    public function getDocumentGeneralPaymentInformation(?string &$creditorReferenceID, ?string &$paymentReference): ZugferdDocumentReader
    {
        $creditorReferenceID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getCreditorReferenceID.value", "");
        $paymentReference = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPaymentReference.value", "") ?? "";
        return $this;
    }

    /**
     * Read copy indicator
     *
     * @param  boolean|null $copyindicator
     * Returns true if this document is a copy from the original document
     * @return ZugferdDocumentReader
     */
    public function getIsDocumentCopy(?bool &$copyindicator): ZugferdDocumentReader
    {
        $copyindicator = $this->getInvoiceValueByPath("getExchangedDocument.getCopyIndicator.getIndicator", false);
        return $this;
    }

    /**
     * Read a test document indicator
     *
     * @param  boolean|null $testdocumentindicator
     * Returns true if this document is only for test purposes
     * @return ZugferdDocumentReader
     */
    public function getIsTestDocument(?bool &$testdocumentindicator): ZugferdDocumentReader
    {
        $testdocumentindicator = $this->getInvoiceValueByPath("getExchangedDocumentContext.getTestIndicator.getIndicator", false);
        return $this;
    }

    /**
     * Read Document money summation
     *
     * @param  float|null $grandTotalAmount
     * Returns the total invoice amount including sales tax
     * @param  float|null $duePayableAmount
     * Returns the Payment amount due
     * @param  float|null $lineTotalAmount
     * Returns the sum of the net amounts of all invoice lines
     * @param  float|null $chargeTotalAmount
     * Returns the sum of the surcharges at document level
     * @param  float|null $allowanceTotalAmount
     * Returns the sum of the discounts at document level
     * @param  float|null $taxBasisTotalAmount
     * Returns the total invoice amount excluding sales tax
     * @param  float|null $taxTotalAmount
     * Returns the total amount of the invoice sales tax, total tax amount in the booking currency
     * @param  float|null $roundingAmount
     * Returns the rounding amount
     * @param  float|null $totalPrepaidAmount
     * Returns the alreay payed amout
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
     * Retrieve document notes
     *
     * @param  array|null $notes Returns an array with all document notes. Each array element
     *                           contains an assiociative array containing the following keys: _contentcode_, _subjectcode_ and
     *                           _content_
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
     * Get the identifier assigned by the buyer and used for internal routing.
     *
     * __Note__: The reference is specified by the buyer (e.g. contact details, department, office ID, project code),
     * but stated by the seller on the invoice.
     *
     * @param  string|null $buyerreference
     * An identifier assigned by the buyer and used for internal routing
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerReference(?string &$buyerreference): ZugferdDocumentReader
    {
        $buyerreference = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerReference.value", "");
        return $this;
    }

    /**
     * Get detailed information about the seller (=service provider)
     *
     * @param  string|null $name
     * The full formal name under which the seller is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param  array|null  $id
     * An identifier of the seller. In many systems, seller identification
     * is key information. Multiple seller IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param  string|null $description
     * Further legal information that is relevant for the seller
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
     * Get global identifier of the seller.
     *
     * __Notes__
     *
     * - The Seller's ID identification scheme is a unique identifier
     *   assigned to a seller by a global registration organization
     *
     * @param  array|null $globalID
     * Array of the sellers global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
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
     * __Notes__
     *  - The local identification (defined by the seller's address) of the seller for tax purposes or a reference that
     *    enables the seller to indicate his reporting status for tax purposes. This information may have an impact on how the buyer
     *    pays the bill (such as regarding social security contributions). So e.g. in some countries, if the seller is not reported
     *    for tax, the buyer will withhold the tax amount and pay it on behalf of the seller
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of seller trade party
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
     * @param  array|null  $subdivision
     * The sellers state
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of seller trade party
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
     * A name by which the seller is known, if different from the seller's name
     * (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first seller contact of the document.
     * Returns true if a first seller contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact
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
     * Seek to the next available first seller contact of the document.
     * Returns true if another seller contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact
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
     * Get detailed information on the seller's contact person
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentSellerContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information about the buyer (service recipient)
     *
     * @param  string|null $name
     * The full name of the buyer
     * @param  array|null  $id
     * An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be
     * assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given,
     * it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param  string|null $description
     * Further legal information about the buyer
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
     * Get global identifier of the buyer.
     *
     * __Notes__
     *  - The buyers's ID identification scheme is a unique identifier
     *    assigned to a buyer by a global registration organization
     *
     * @param  array|null $globalID
     * Array of the buyers global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
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
     * __Notes__
     *  - The local identification (defined by the buyer's address) of the buyer for tax purposes or a reference that
     *    enables the buyer to indicate his reporting status for tax purposes.
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of buyer trade party
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
     * @param  array|null  $subdivision
     * The buyers state
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of buyer trade party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first buyer contact of the document.
     * Returns true if a first buyer contact is available, otherwise false
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
     * Seek to the next available first Buyer contact of the document.
     * Returns true if another Buyer contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentBuyerContact
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
     * Get contact information of buyer trade party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentBuyerContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information about the seller's tax agent
     *
     * @param  string|null $name
     * The full name of the seller's tax agent
     * @param  array|null  $id
     * An identifier of the sellers tax agent.
     * @param  string|null $description
     * Further legal information that is relevant for the sellers tax agent
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
     * Get document seller tax agent global ids
     *
     * @param  array|null $globalID
     * Returns an array of the seller's tax agent identifier. Identification scheme is an identifier uniquely
     * assigned to a seller's tax agent by a global registration organization. The array key is the scheme id. The scheme results from the
     * list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme codes are used:
     * 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
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
     * __Notes__
     *  - The local identification (defined by the sellers tax agent address) of the tax agent for tax purposes
     *    or a reference that enables the sellers tax agent to indicate his reporting status for tax purposes.
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of sellers tax agent
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
     * @param  array|null  $subdivision
     * The sellers tax agent state
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of sellers tax agent
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first Seller Tax Representative contact of the document.
     * Returns true if a first Seller Tax Representative contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentSellerTaxRepresentativeContact
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
     * Seek to the next available first seller contact of the document.
     * Returns true if another seller contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentSellerContact
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
     * Get contact information of sellers tax agent
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentSellerTaxRepresentativeContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the product end user (general information)
     *
     * @param  string|null $name
     * The full formal name under which the product end user is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param  array|null  $id
     * An identifier of the product end user. In many systems, product end user identification
     * is key information. Multiple product end user IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to all trade
     * parties, e.g. a previously exchanged
     * @param  string|null $description
     * Further legal information that is relevant for the product end user
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
     * __Notes__
     *  - The product end users ID identification scheme is a unique identifier
     *    assigned to a product end user by a global registration organization
     *
     * @param  array|null $globalID
     * Array of the product end users global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on the tax number of the product end user
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address of product end user
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
     * @param  array|null  $subdivision
     * The product end users state
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of product end user
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first product end-user contact of the document.
     * Returns true if a first product end-user contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentProductEndUserContact
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
     * Seek to the next available first product end-user contact of the document.
     * Returns true if another product end-user contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentProductEndUserContact
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
     * Get detailed information on the product end user's contact person
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentProductEndUserContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the different ship-to party
     *
     * @param  string|null $name
     * The name of the party to whom the goods are being delivered or for whom the services are being
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param  array|null  $id
     * An identifier for the place where the goods are delivered or where the services are provided.
     * Multiple IDs can be assigned or specified. They can be differentiated by using different
     * identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
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
     * Get global identifier for the delivery location
     *
     * @param  array|null $globalID
     * Array of the delivery location's global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the goods recipient
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get the address to which the invoiced goods are delivered or to which the invoiced services are provided.
     *
     * __Notes__
     *  - In the event of a collection, the delivery address corresponds to the collection address. In order
     *    to meet the legal requirements, a sufficient number of components of the address must be entered.
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
     * @param  array|null  $subdivision
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Ship-To trade party
     *
     * @param  string|null $legalorgid
     * An identifier issued by an official registrar that identifies the party as a legal entity or legal
     * person. If no identification scheme ($legalorgtype) is provided, it should be known to the buyer or
     * seller party
     * @param  string|null $legalorgtype
     * The identifier for the identification scheme of the legal
     * registration of the party. In particular, the following scheme codes are used: 0021 : SWIFT, 0088 : EAN,
     * 0060 : DUNS, 0177 : ODETTE
     * @param  string|null $legalorgname
     * A name by which the party is known, if different from the party's name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first Ship-To contact of the document.
     * Returns true if a first ship-to contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentShipToContact
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
     * Seek to the next available first ship-to contact of the document.
     * Returns true if another ship-to contact is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentShipToContact
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
     * Get detailed information on the contact person of the goods recipient
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentShipToContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get detailed information on the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $name
     * Name or company name of the different end recipient
     * @param  array|null  $id
     * Identification of the different end recipient. Multiple IDs can be assigned or specified. They can be
     * differentiated by using different identification schemes.
     * @param  string|null $description
     * Further legal information that is relevant for the different end recipient
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
     * Get global identifiers of the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $globalID
     * Array of the party's global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the different end recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get detailed information on the address of the different end recipient party
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
     * @param  array|null  $subdivision
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get detailed information about the Legal organisation of the different end recipient party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact person of the different end recipient party
     * Returns true if a first contact person of the different end recipient party
     * is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentUltimateShipToContact
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
     * Seek to the next available contact person of the different end recipient party.
     * Returns true if another contact person of the different end recipient party
     * is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentUltimateShipToContact
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
     * Get detailed information on the contact person of the different end recipient party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentUltimateShipToContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $name
     * The name of the party
     * @param  array|null  $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
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
     * Get global identifier of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $globalID
     * Array of the party's global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the deviating consignor party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the deviating consignor party
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
     * @param  array|null  $subdivision
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCountryID.value.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the deviating consignor party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the deviating consignor party of the document.
     * Returns true if a first contact information of the deviating consignor party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentShipFromContact
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
     * Seek to the next available first contact information of the deviating consignor party of the document.
     * Returns true if another contact information of the deviating consignor party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentShipFromContact
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
     * Get contact information of the deviating consignor party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentShipFromContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information of the invoicer party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $name
     * The name of the party
     * @param  array|null  $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
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
     * Get global identifier of the invoicer party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $globalID
     * Array of the party's global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the invoicer party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the invoicer party
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
     * @param  array|null  $subdivision
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the invoicer party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the invoicer party of the document.
     * Returns true if a first contact information of the invoicer party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentInvoicerContact
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
     * Seek to the next available contact information of the invoicer party of the document.
     * Returns true if another contact information of the invoicer party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentInvoicerContact
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
     * Get contact information of the invoicer party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentInvoicerContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the different invoice recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $name
     * The name of the party
     * @param  array|null  $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
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
     * Get global identifier of the different invoice recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $globalID
     * Array of the party's global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the different invoice recipient party
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the different invoice recipient party
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
     * @param  array|null  $subdivision
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the different invoice recipient party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the different invoice recipient party of the document.
     * Returns true if a first contact information of the different invoice recipient party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentInvoiceeContact
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
     * Seek to the next available first contact information of the different invoice recipient party of the document.
     * Returns true if another contact information of the different invoice recipient party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentInvoiceeContact
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
     * Get contact information of the different invoice recipient party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentInvoiceeContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information about the payee, i.e. about the place that receives the payment.
     * The role of the payee may also be performed by a party other than the seller, e.g. by a factoring service.
     *
     * @param  string|null $name
     * The name of the party. Must be used if the payee is not the same as the seller. However, the name of the
     * payee may match the name of the seller.
     * @param  array|null  $id
     * An identifier for the party. Multiple IDs can be assigned or specified. They can be differentiated by using
     * different identification schemes. If no scheme is given, it should  be known to the buyer and seller, e.g.
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param  string|null $description
     * Further legal information that is relevant for the party
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
     * Get global identifier of the payee party
     *
     * @param  array|null $globalID
     * Array of the party's global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Get detailed information on tax details of the payee party
     *
     * @param  array|null $taxreg
     * Array of tax numbers indexed by __FC__ for _Tax number_ and __VA__ for _Sales tax identification number_
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Get Detailed information on the address of the payee party
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
     * @param  array|null  $subdivision
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineOne.value", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineTwo.value", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineThree.value", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getPostcodeCode.value", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCityName.value", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get information about the legal organisation of the payee party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName.value", "");

        return $this;
    }

    /**
     * Seek to the first contact information of the payee party of the document.
     * Returns true if a first contact information of the payee party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentPayeeContact
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
     * Seek to the next available first contact information of the payee party of the document.
     * Returns true if another contact information of the payee party is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentPayeeContact
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
     * Get contact information of the payee party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contacts = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact", []));
        $contact = $contacts[$this->documentPayeeContactPointer];
        $contactpersonname = $this->getInvoiceValueByPathFrom($contact, "getPersonName.value", "");
        $contactdepartmentname = $this->getInvoiceValueByPathFrom($contact, "getDepartmentName.value", "");
        $contactphoneno = $this->getInvoiceValueByPathFrom($contact, "getTelephoneUniversalCommunication.getCompleteNumber.value", "");
        $contactfaxno = $this->getInvoiceValueByPathFrom($contact, "getFaxUniversalCommunication.getCompleteNumber.value", "");
        $contactemailadd = $this->getInvoiceValueByPathFrom($contact, "getEmailURIUniversalCommunication.getURIID.value", "");

        return $this;
    }

    /**
     * Get detailed information on the delivery conditions
     *
     * __Note__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null $code
     * Delivery condition (code)
     * @return ZugferdDocumentReader
     */
    public function getDocumentDeliveryTerms(?string &$code): ZugferdDocumentReader
    {
        $code = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getApplicableTradeDeliveryTerms.setDeliveryTypeCode.value", "");

        return $this;
    }

    /**
     * Get details of the associated order confirmation
     *
     * @param  string|null   $issuerassignedid
     * An identifier issued by the seller for a referenced sales order (Order confirmation number)
     * @param  DateTime|null $issueddate
     * Order confirmation date
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerOrderReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get details of the related buyer order
     *
     * @param  string|null   $issuerassignedid
     * An identifier issued by the buyer for a referenced order (order number)
     * @param  DateTime|null $issueddate
     * Date of order
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerOrderReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get details of the associated contract
     *
     * @param  string|null   $issuerassignedid
     * The contract reference should be assigned once in the context of the specific trade relationship and for a
     * defined period of time (contract number)
     * @param  DateTime|null $issueddate
     * Contract date
     * @return ZugferdDocumentReader
     */
    public function getDocumentContractReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get first additional referenced document for the document
     * Returns true if an additional referenced document is available, otherwise false
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
     * Get next additional referenced document for the document
     * Returns true when another additional referenced document is available, otherwise false
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
     * Get information about billing documents that provide evidence of claims made in the bill
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
     * @param  string|null   $issuerassignedid
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string|null   $typecode
     * Type of referenced document (See codelist UNTDID 1001)
     *  - Code 916 "reference paper" is used to reference the identification of the document on which the invoice is based
     *  - Code 50 "Price / sales catalog response" is used to reference the tender or the lot
     *  - Code 130 "invoice data sheet" is used to reference an identifier for an object specified by the seller.
     * @param  string|null   $uriid
     * The Uniform Resource Locator (URL) at which the external document is available. A means of finding the resource
     * including the primary access method intended for it, e.g. http: // or ftp: //. The location of the external document
     * must be used if the buyer needs additional information to support the amounts billed. External documents are not part
     * of the invoice. Access to external documents can involve certain risks.
     * @param  array|null    $name
     * A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null   $reftypecode
     * The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the
     * recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected
     * from UNTDID 1153 in accordance with the code list entries.
     * @param  DateTime|null $issueddate
     * Document date
     * @param  string|null   $binarydatafilename
     * Contains a file name of an attachment document embedded as a binary object or sent with the invoice. Where the
     * binary attached file is stored can be controlled by using the methud ZugferdDocumentReader::setBinaryDataDirectory()
     * @return ZugferdDocumentReader
     */
    public function getDocumentAdditionalReferencedDocument(?string &$issuerassignedid, ?string &$typecode, ?string &$uriid = null, ?array &$name = null, ?string &$reftypecode = null, ?DateTime &$issueddate = null, ?string &$binarydatafilename = null): ZugferdDocumentReader
    {
        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);
        $addRefDoc = $addRefDoc[$this->documentAddRefDocPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $typecode = $this->getInvoiceValueByPathFrom($addRefDoc, "getTypeCode.value", "");
        $uriid = $this->getInvoiceValueByPathFrom($addRefDoc, "getURIID.value", "");
        $name = $this->convertToArray($this->getInvoiceValueByPathFrom($addRefDoc, "getName", []), ["value"]);
        $reftypecode = $this->getInvoiceValueByPathFrom($addRefDoc, "getReferenceTypeCode.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );
        $binarydatafilename = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.getFilename", "");
        $binarydata = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.value", "");
        if (
            StringUtils::stringIsNullOrEmpty($binarydatafilename) === false
            && StringUtils::stringIsNullOrEmpty($binarydata) === false
            && StringUtils::stringIsNullOrEmpty($this->binarydatadirectory) === false
        ) {
            $binarydatafilename = PathUtils::combinePathWithFile($this->binarydatadirectory, $binarydatafilename);
            FileUtils::base64ToFile($binarydata, $binarydatafilename);
        } else {
            $binarydatafilename = "";
        }

        return $this;
    }

    /**
     * Get all additional referenced documents
     *
     * @param  array|null $refdocs
     * Array contains all additional referenced documents, but without extracting attached binary objects. If you
     * want to access attached binary objects you have to use ZugferdDocumentReader::getDocumentAdditionalReferencedDocument
     * @return ZugferdDocumentReader
     */
    public function getDocumentAdditionalReferencedDocuments(?array &$refdocs): ZugferdDocumentReader
    {
        $refdocs = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);
        $refdocs = $this->convertToArray(
            $refdocs,
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
     * Get first reference to the previous invoice
     * Returns true if an invoice reference document is available, otherwise false
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
     * Get next reference to the previous invoice
     * Returns true when another invoice reference document is available, otherwise false
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
     * Get reference to the previous invoice
     *
     * @param  string|null   $issuerassignedid
     * __BT-X-331__ Reference to the previous invoice
     * @param  string|null   $typecode
     * __BT-X-332__ Type of previous invoice (code)
     * @param  DateTime|null $issueddate
     * __BT-X-333-00__ Document date
     */
    public function getDocumentInvoiceReferencedDocument(?string &$issuerassignedid, ?string &$typecode, ?DateTime &$issueddate = null): ZugferdDocumentReader
    {
        $invoiceRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceReferencedDocument", []);
        $invoiceRefDoc = $invoiceRefDoc[$this->documentInvRefDocPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getIssuerAssignedID.value", "");
        $typecode = $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getTypeCode.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($invoiceRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get all references to the previous invoice
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
     * Get Details of a project reference
     *
     * @param  string|null $id
     * Project Data
     * @param  string|null $name
     * Project Name
     * @return ZugferdDocumentReader
     */
    public function getDocumentProcuringProject(?string &$id, ?string &$name): ZugferdDocumentReader
    {
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSpecifiedProcuringProject.getID.value", "");
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSpecifiedProcuringProject.getName.value", "");

        return $this;
    }

    /**
     * Get first additional referenced document for the document
     * Returns true if the first position is available, otherwise false
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
     * Get next additional referenced document for the document
     * Returns true if the first position is available, otherwise false
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
     * Get details of the ultimate customer order
     *
     * @param  string|null   $issuerassignedid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateCustomerOrderReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getUltimateCustomerOrderReferencedDocument", []);
        $addRefDoc = $addRefDoc[$this->documentUltimateCustomerOrderReferencedDocumentPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Details of the ultimate customer order
     *
     * @param  array|null $refdocs
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateCustomerOrderReferencedDocuments(?array $refdocs): ZugferdDocumentReader
    {
        // TODO: Implemente method getDocumentUltimateCustomerOrderReferencedDocuments
        return $this;
    }

    /**
     * Get detailed information on the actual delivery
     *
     * @param  DateTime|null $date
     * Actual delivery time. In Germany, the delivery and service date is a mandatory requirement on invoices.
     * This can be done here or at item level.
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
     * Get detailed information on the associated shipping notification
     *
     * @param  string|null   $issuerassignedid
     * Shipping notification reference
     * @param  DateTime|null $issueddate
     * Shipping notification date
     * @return ZugferdDocumentReader
     */
    public function getDocumentDespatchAdviceReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get detailed information on the associated goods receipt notification
     *
     * @param  string|null   $issuerassignedid
     * An identifier for a referenced goods receipt notification (Goods receipt number)
     * @param  DateTime|null $issueddate
     * Goods receipt date
     * @return ZugferdDocumentReader
     */
    public function getDocumentReceivingAdviceReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get detailed information on the associated delivery note
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param  string|null   $issuerassignedid
     * Delivery receipt number
     * @param  DateTime|null $issueddate
     * Delivery receipt date
     * @return ZugferdDocumentReader
     */
    public function getDocumentDeliveryNoteReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first payment means of the document.
     * Returns true if a first payment mean is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentMeans
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
     * Seek to the next payment means of the document
     * Returns true if another payment mean is available, otherwise false
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
     * Get detailed information on the payment method
     *
     * __Notes__
     *  - The SpecifiedTradeSettlementPaymentMeans element can only be repeated for each bank account if
     *    several bank accounts are to be transferred for transfers. The code for the payment method in the Typecode
     *    element must therefore not differ in the repetitions. The elements ApplicableTradeSettlementFinancialCard
     *    and PayerPartyDebtorFinancialAccount must not be specified for bank transfers.
     *
     * @param  string|null $typecode
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPaymentMeans(?string &$typecode, ?string &$information, ?string &$cardType, ?string &$cardId, ?string &$cardHolderName, ?string &$buyerIban, ?string &$payeeIban, ?string &$payeeAccountName, ?string &$payeePropId, ?string &$payeeBic): ZugferdDocumentReader
    {
        $paymentMeans = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));
        $paymentMeans = $paymentMeans[$this->documentPaymentMeansPointer];

        $typecode = $this->getInvoiceValueByPathFrom($paymentMeans, "getTypeCode.value", "");
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
     * Seek to the first document tax
     * Returns true if a first tax (at document level) is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentTax
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
     * Seek to the next document tax
     * Returns true if another tax (at document level) is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentTax
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
     * Get current VAT breakdown (at document level)
     *
     * @param  string|null   $categoryCode
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
     * @param  string|null   $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float|null    $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float|null    $calculatedAmount
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
     * @return ZugferdDocumentReader
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
     * Get detailed information on the billing period
     *
     * @param  DateTime|null $startdate
     * Start of the billing period
     * @param  DateTime|null $endDate
     * End of the billing period
     * @return ZugferdDocumentReader
     */
    public function getDocumentBillingPeriod(?DateTime &$startdate, ?DateTime &$endDate): ZugferdDocumentReader
    {
        $startdate = $this->getObjectHelper()->toDateTime(
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
     * Get information about surcharges and charges applicable to the bill as a whole, Deductions, such as for
     * withheld taxes may also be specified in this group
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
     * Seek to the first documents allowance charge. Returns true if the first position is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentAllowanceCharge
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
     * Seek to the next documents allowance charge. Returns true if a other position is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentAllowanceCharge
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
     * Get information about the currently seeked surcharges and charges applicable to the
     * bill as a whole, Deductions, such as for withheld taxes may also be specified in this group
     *
     * @param  float|null   $actualAmount
     * Amount of the surcharge or discount at document level
     * @param  boolean|null $isCharge
     * Switch that indicates whether the following data refer to an allowance or a discount, true means that
     * this an charge
     * @param  string|null  $taxCategoryCode
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
     * @param  string|null  $taxTypeCode
     * Code for the VAT category of the surcharge or charge at document level. Note: Fixed value = "VAT"
     * @param  float|null   $rateApplicablePercent
     * VAT rate for the surcharge or discount on document level. Note: The code of the sales tax category
     * and the category-specific sales tax rate must correspond to one another. The value to be given is
     * the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  float|null   $sequence
     * Calculation order
     * @param  float|null   $calculationPercent
     * Percentage surcharge or discount at document level
     * @param  float|null   $basisAmount
     * The base amount that may be used in conjunction with the percentage of the surcharge or discount
     * at document level to calculate the amount of the discount at document level
     * @param  float|null   $basisQuantity
     * Basismenge des Rabatts
     * @param  string|null  $basisQuantityUnitCode
     * Einheit der Preisbasismenge
     *  - Codeliste: Rec. N°20 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     *  - Codeliste: Rec. N°21 Vollständige Liste, In Recommendation N°20 Intro 2.a ist beschrieben, dass
     *    beide Listen kombiniert anzuwenden sind.
     * @param  string|null  $reasonCode
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
     * @param  string|null  $reason
     * The reason given in text form for the surcharge or discount at document level
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
     * Seek to the first documents service charge position
     * Returns true if the first position is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentLogisticsServiceCharge
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
     * Seek to the next documents service charge position
     * Returns true if a other position is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentLogisticsServiceCharge
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
     * Get currently seeked logistical service fees (On document level)
     *
     * @param  string|null $description
     * Identification of the service fee
     * @param  float|null  $appliedAmount
     * Amount of the service fee
     * @param  array|null  $taxTypeCodes
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  array|null  $taxCategoryCodes
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
     * @param  array|null  $rateApplicablePercents
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @return ZugferdDocumentReader
     */
    public function getDocumentLogisticsServiceCharge(?string &$description, ?float &$appliedAmount, ?array &$taxTypeCodes = null, ?array &$taxCategoryCodes = null, ?array &$rateApplicablePercents = null): ZugferdDocumentReader
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
     * Get all documents payment terms
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
     * Seek to the first documents payment terms position
     * Returns true if the first position is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentTerm
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
     * Seek to the next documents payment terms position
     * Returns true if a other position is available, otherwise false
     * You may use this together with ZugferdDocumentReader::getDocumentPaymentTerm
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
     * Get currently seeked payment term
     * This controlled by firstDocumentPaymentTerms and nextDocumentPaymentTerms methods
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
     * Get detailed information on payment discounts
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
     * Seek to the first document position
     * Returns true if the first position is available, otherwise false
     * You may use it together with getDocumentPositionGenerals
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
        $this->positionProductCharacteristicPointer = 0;
        $this->positionProductClassificationPointer = 0;
        $this->positionReferencedProductPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        return isset($tradeLineItem[$this->positionPointer]);
    }

    /**
     * Seek to the next document position
     * Returns true if another position is available, otherwise false
     * You may use it together with getDocumentPositionGenerals
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

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        return isset($tradeLineItem[$this->positionPointer]);
    }

    /**
     * Get general information of the current position
     *
     * @param  string|null $lineid
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionGenerals(?string &$lineid, ?string &$lineStatusCode, ?string &$lineStatusReasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineID.value", "");
        $lineStatusCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineStatusCode.value", "");
        $lineStatusReasonCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineStatusReasonCode.value", "");

        return $this;
    }

    /**
     * Seek to the first document position
     * Returns true if the first position is available, otherwise false
     * You may use it together with getDocumentPositionNote
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
     * Seek to the next document position
     * Returns true if the first position is available, otherwise false
     * You may use it together with getDocumentPositionNote
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
     * Get detailed information on the free text on the position
     *
     * @param  string|null $content
     * A free text that contains unstructured information that is relevant to the invoice item
     * @param  string|null $contentCode
     * Text modules agreed bilaterally, which are transmitted here as code.
     * @param  string|null $subjectCode
     * Free text for the position (code for the type)
     * __Codelist:__ UNTDID 4451
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
     * Get information about the goods and services billed
     *
     * @param  string|null $name
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
     * Get information about the goods and services billed (Enhanced, with Model, Brand, etc.)
     *
     * @param  string|null $name
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
     * @param  string|null $industryAssignedID
     * D assigned by the industry to the contained referenced product
     * @param  string|null $modelID
     * A unique model identifier for this product
     * @param  string|null $batchID
     * Identification of the batch (lot) of the product
     * @param  string|null $brandName
     * The brand name, expressed as text, for this product
     * @param  string|null $modelName
     * Model designation of the product
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
     * Get details of the related buyer order position
     *
     * @param  string|null   $issuerassignedid
     * An identifier issued by the buyer for a referenced order (order number)
     * @param  string|null   $lineid
     * An identifier for a position within an order placed by the buyer. Note: Reference is made to the order
     * reference at the document level.
     * @param  DateTime|null $issueddate
     * Date of order
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionBuyerOrderReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getLineID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Get details of the related contract position
     *
     * @param  string|null   $issuerassignedid
     * The contract reference should be assigned once in the context of the specific trade relationship and for a
     * defined period of time (contract number)
     * @param  string|null   $lineid
     * Identifier of the according contract position
     * @param  DateTime|null $issueddate
     * Contract date
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionContractReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getLineID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Seek to the first documents position additional referenced document
     * Returns true if the first position is available, otherwise false
     * You may use it together with getDocumentPositionAdditionalReferencedDocument
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
     * Seek to the next documents position additional referenced document
     * Returns true if the first position is available, otherwise false
     * You may use it together with getDocumentPositionAdditionalReferencedDocument
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
     * Details of an additional Document reference (on position level)
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
     * @param  string|null   $issuerassignedid
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  string|null   $typecode
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAdditionalReferencedDocument(?string &$issuerassignedid, ?string &$typecode, ?string &$uriid, ?string &$lineid, ?string &$name, ?string &$reftypecode, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));
        $addRefDoc = $addRefDoc[$this->positionAddRefDocPointer];

        $typecode = $this->getInvoiceValueByPathFrom($addRefDoc, "getTypeCode.value", "");
        $issuerassignedid = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $reftypecode = $this->getInvoiceValueByPathFrom($addRefDoc, "getReferenceTypeCode.value", "");
        $uriid = $this->getInvoiceValueByPathFrom($addRefDoc, "getURIID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($addRefDoc, "getLineID.value", "");
        $name = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($addRefDoc, "getName.value", ""));
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    //TODO: DocumentPositionUltimateCustomerOrderReferencedDocument

    /**
     * Get the unit price excluding sales tax before deduction of the discount on the item price.
     *
     * @param  float|null  $amount
     * The unit price excluding sales tax before deduction of the discount on the item price.
     * Note: If the price is shown according to the net calculation, the price must also be shown
     * according to the gross calculation.
     * @param  float|null  $basisQuantity
     * The number of item units for which the price applies (price base quantity)
     * @param  string|null $basisQuantityUnitCode
     * The unit code of the number of item units for which the price applies (price base quantity)
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
     * Seek to the first documents position gross price allowance charge position
     * Returns true if the first position is available, otherwise false
     * You may use it together with getDocumentPositionGrossPriceAllowanceCharge
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
     * Seek to the next documents position gross price allowance charge position
     * Returns true if a other position is available, otherwise false
     * You may use it together with getDocumentPositionGrossPriceAllowanceCharge
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
     * Get detailed information on surcharges and discounts
     *
     * @param  float|null   $actualAmount
     * Discount on the item price. The total discount subtracted from the gross price to calculate the
     * net price. Note: Only applies if the discount is given per unit and is not included in the gross price.
     * @param  boolean|null $isCharge
     * Switch for surcharge/discount, if true then its an charge
     * @param  float|null   $calculationPercent
     * Discount/surcharge in percent. Up to level EN16931, only the final result of the discount (ActualAmount)
     * is transferred
     * @param  float|null   $basisAmount
     * Base amount of the discount/surcharge
     * @param  string|null  $reason
     * Reason for surcharge/discount (free text)
     * @param  string|null  $taxTypeCode
     * @param  string|null  $taxCategoryCode
     * @param  float|null   $rateApplicablePercent
     * @param  float|null   $sequence
     * @param  float|null   $basisQuantity
     * @param  string|null  $basisQuantityUnitCode
     * @param  string|null  $reasonCode
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
     * Get detailed information on the net price of the item
     *
     * @param  float|null  $amount
     * Net price of the item
     * @param  float|null  $basisQuantity
     * Base quantity at the item price
     * @param  string|null $basisQuantityUnitCode
     * Code of the unit of measurement of the base quantity at the item price
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
     * Tax included for B2C on position level
     *
     * @param  string|null $categoryCode
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
     * @param  string|null $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float|null  $rateApplicablePercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @param  float|null  $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
     * @param  string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @param  string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
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
     * Get the position Quantity
     *
     * @param  float|null  $billedQuantity
     * The quantity of individual items (goods or services) billed in the relevant line
     * @param  string|null $billedQuantityUnitCode
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
     * Get detailed information on the actual delivery (on position level)
     *
     * @param  DateTime|null $date
     * Actual delivery time. In Germany, the delivery and service date is a mandatory requirement on invoices.
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
     * Get detailed information on the associated shipping notification (on position level)
     *
     * @param  string|null   $issuerassignedid
     * Shipping notification reference
     * @param  string|null   $lineid
     * Shipping notification position reference date
     * @param  DateTime|null $issueddate
     * Shipping notification date
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionDespatchAdviceReferencedDocument(?string &$issuerassignedid, ?string &$lineid = null, ?DateTime &$issueddate = null): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getLineID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification (on position level)
     *
     * @param  string|null   $issuerassignedid
     * @param  string|null   $lineid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionReceivingAdviceReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getLineID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated delivery note on position level
     *
     * @param  string|null   $issuerassignedid
     * @param  string|null   $lineid
     * @param  DateTime|null $issueddate
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionDeliveryNoteReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getLineID.value", "");
        $issueddate = $this->getObjectHelper()->toDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first document position tax
     * Returns true if the first tax position is available, otherwise false
     * You may use it together with ZugferdDocumentReader::getDocumentPositionTax
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
     * Seek to the next document position tax
     * Returns true if another tax position is available, otherwise false
     * You may use it together with ZugferdDocumentReader::getDocumentPositionTax
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
     * Get information about the sales tax that applies to the goods and services invoiced
     * in the relevant invoice line
     *
     * @param  string|null $categoryCode
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
     * @param  string|null $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. If other types of tax are
     * to be specified, such as an insurance tax or a mineral oil tax, the EXTENDED profile must be used. The
     * code for the tax type must then be taken from the code list UNTDID 5153.
     * @param  float|null  $rateApplicablePercent
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
     * Get information about the period relevant for the invoice item.
     * Note: Also known as the invoice line delivery period.
     *
     * @param  DateTime|null $startdate
     * Start of the billing period
     * @param  DateTime|null $endDate
     * End of the billing period
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionBillingPeriod(?DateTime &$startdate, ?DateTime &$endDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $startdate = $this->getObjectHelper()->toDateTime(
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
     * Seek to the first allowance charge (on position level)
     * Returns true if the first position is available, otherwise false
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAllowanceCharge
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
     * Seek to the next allowance charge (on position level)
     * Returns true if another position is available, otherwise false
     * You may use it together with ZugferdDocumentReader::getDocumentPositionAllowanceCharge
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
     * Detailed information on currentley seeked surcharges and discounts on position level
     *
     * @param  float|null   $actualAmount
     * The surcharge / discount amount excluding sales tax
     * @param  boolean|null $isCharge
     * Switch that indicates whether the following data refer to an allowance or a discount,
     * true means that
     * @param  float|null   $calculationPercent
     * The percentage that may be used in conjunction with the base invoice line discount
     * amount to calculate the invoice line discount amount
     * @param  float|null   $basisAmount
     * The base amount that may be used in conjunction with the invoice line discount percentage
     * to calculate the invoice line discount amount
     * @param  string|null  $reason
     * The reason given in text form for the invoice item discount/surcharge
     *
     * __Notes__
     *  - The invoice line discount reason code (BT-140) and the invoice line discount reason
     *    (BT-139) must show the same allowance type.
     *  - Each line item discount (BG-27) must include a corresponding line discount reason
     *    (BT-139) or an appropriate line discount reason code (BT-140), or both.
     *  - The code for the reason for the charge at the invoice line level (BT-145) and the
     *    reason for the invoice line discount (BT-144) must show the same discount type
     * @param  string|null  $taxTypeCode
     * Not used, this is only a dummy
     * @param  string|null  $taxCategoryCode
     * Not used, this is only a dummy
     * @param  float|null   $rateApplicablePercent
     * Not used, this is only a dummy
     * @param  float|null   $sequence
     * Not used, this is only a dummy
     * @param  float|null   $basisQuantity
     * Not used, this is only a dummy
     * @param  string|null  $basisQuantityUnitCode
     * Not used, this is only a dummy
     * @param  string|null  $reasonCode
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
     * Detailed information on surcharges and discounts on position level (on a simple way)
     * This is the simplified version of ZugferdDocumentReader::getDocumentPositionAllowanceCharge
     *
     * @param  float|null   $actualAmount
     * The surcharge / discount amount excluding sales tax
     * @param  boolean|null $isCharge
     * Switch that indicates whether the following data refer to an allowance or a discount,
     * true means that
     * @param  float|null   $calculationPercent
     * The percentage that may be used in conjunction with the base invoice line discount
     * amount to calculate the invoice line discount amount
     * @param  float|null   $basisAmount
     * The base amount that may be used in conjunction with the invoice line discount percentage
     * to calculate the invoice line discount amount
     * @param  string|null  $reasonCode
     * The reason given as a code for the invoice line discount
     *
     * __Notes__
     *
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
     * @param  string|null  $reason
     * The reason given in text form for the invoice item discount / surcharge
     *
     * __Notes__
     *  - The invoice line discount reason code (BT-140) and the invoice line discount reason
     *    (BT-139) must show the same allowance type.
     *  - Each line item discount (BG-27) must include a corresponding line discount reason
     *    or an appropriate line discount reason code (BT-140), or both.
     *  - The code for the reason for the charge at the invoice line level (BT-145) and the
     *    reason for the invoice line discount (BT-144) must show the same discount type
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
     * Get detailed information on item totals
     *
     * @param  float|null $lineTotalAmount
     * The total amount of the invoice item.
     * __Note:__ This is the "net" amount, that is, excluding sales tax, but including all surcharges
     * and discounts applicable to the item level, as well as other taxes.
     * @param  float|null $totalAllowanceChargeAmount
     * Total amount of item surcharges and discounts
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionLineSummation(?float &$lineTotalAmount, ?float &$totalAllowanceChargeAmount): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $lineTotalAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getLineTotalAmount.value", 0.0);
        $totalAllowanceChargeAmount = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeSettlementLineMonetarySummation.getTotalAllowanceChargeAmount.value", 0.0);

        return $this;
    }

    /**
     * Seek to the first document position's product characteristic
     * Returns true if the first position propduct characteristic is available, otherwise false
     * You may use it together with getDocumentPositionProductCharacteristic
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
     * Seek to the next document position's product characteristic
     * Returns true if more position propduct characteristics are available, otherwise false
     * You may use it together with getDocumentPositionProductCharacteristic
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
     * Get extra characteristics to the formerly added product.
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionProductCharacteristic(?string &$description, ?string &$value, ?string &$typecode, ?float &$valueMeasure, ?string &$valueMeasureUnitCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $tradeLineItemProductCharacteristic = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getApplicableProductCharacteristic", []));
        $tradeLineItemProductCharacteristic = $tradeLineItemProductCharacteristic[$this->positionProductCharacteristicPointer];

        $description = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getDescription.value", "");
        $value = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getValue.value", "");
        $typecode = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getTypeCode.value", "");
        $valueMeasure = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getValueMeasure.value", 0.0);
        $valueMeasureUnitCode = $this->getInvoiceValueByPathFrom($tradeLineItemProductCharacteristic, "getValueMeasure.getUnitCode", "");

        return $this;
    }

    /**
     * Seek to the first document position's product classification
     * Returns true if the first position propduct classification is available, otherwise false
     * You may use it together with getDocumentPositionProductClassification
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
     * Seek to the next document position's product classification
     * Returns true if more position propduct classifications are available, otherwise false
     * You may use it together with getDocumentPositionProductClassification
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
     * Get detailed information on product classification
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
     * Seek to the first document position's referenced product
     * Returns true if the first position referenced product is available, otherwise false
     * You may use it together with getDocumentPositionReferencedProduct
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
     * Seek to the next document position's referenced product
     * Returns true if more position referenced products are available, otherwise false
     * You may use it together with getDocumentPositionReferencedProduct
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
     * Get detailed information on included products. This information relates to the
     * product that has just been added
     *
     * @param  string $name
     * Item name
     * @param  string $description
     * Item description
     * @param  string $sellerAssignedID
     * Item number of the seller
     * @param  string $buyerAssignedID
     * Item number of the buyer
     * __Note__: The identifier of the product is a unique, bilaterally agreed identification of the
     * product. It can, for example, be the customer article number or the article number assigned by
     * the manufacturer.
     * @param  array $globalID
     * Array of the global ids indexed by the identification scheme. The identification scheme results
     * from the list published by the ISO/IEC 6523 Maintenance Agency. In particular, the following scheme
     * codes are used: 0021 : SWIFT, 0088 : EAN, 0060 : DUNS, 0177 : ODETTE
     * @param  float  $unitQuantity
     * Included quantity
     * @param  string $unitCode
     * Unit of measurement of the included quantity
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionReferencedProduct(?string &$name, ?string &$description, ?string &$sellerAssignedID, ?string &$buyerAssignedID, ?array &$globalID, ?float &$unitQuantity, ?string &$unitCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $tradeLineItemReferencedProduct = $this->getObjectHelper()->ensureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedTradeProduct.getIncludedReferencedProduct", []));
        $tradeLineItemReferencedProduct = $tradeLineItemReferencedProduct[$this->positionReferencedProductPointer];

        $name = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getName.value", "");
        $description = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getDescription.value", "");
        $sellerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getSellerAssignedID.value", "");
        $buyerAssignedID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getBuyerAssignedID.value", "");
        $unitQuantity = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getUnitQuantity.value", 0);
        $unitCode = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getUnitQuantity.getUnitCode", "");
        $globalID = $this->getInvoiceValueByPathFrom($tradeLineItemReferencedProduct, "getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    //TODO: Seeker for documents position TradeAccountingAccount

    /**
     * Function to return a value from $invoiceObject by path
     *
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
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

                if ($isFlat === true) {
                    $result[] = $itemValue;
                } else {
                    $resultItem[$methodKey] = $itemValue;
                }
            }

            if ($isFlat !== true) {
                $result[] = $resultItem;
            }
        }

        return $result;
    }

    /**
     * Convert to associative array
     *
     * @codeCoverageIgnore
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
