<?php

namespace horstoeko\zugferd;

use Closure;
use DateTime;
use Exception;
use SimpleXMLElement;

/**
 * Class representing the document reader for incoming documents
 */
class ZugferdDocumentReader extends ZugferdDocument
{
    /**
     * Undocumented variable
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
     * @var string
     */
    private $binarydatadirectory = "";

    /**
     * Set the directory where the attached binary data from
     * additional referenced documents are temporary stored
     *
     * @param string $binarydatadirectory
     */
    public function setBinaryDataDirectory(string $binarydatadirectory)
    {
        $this->binarydatadirectory = "";

        if ($binarydatadirectory) {
            if (is_dir($binarydatadirectory) && is_writable($binarydatadirectory)) {
                $this->binarydatadirectory = $binarydatadirectory;
            }
        }
    }

    /**
     * Guess the profile type of a xml file
     *
     * @codeCoverageIgnore
     *
     * @param string $xmlfilename The filename to read invoice data from
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public static function readAndGuessFromFile(string $xmlfilename): ZugferdDocumentReader
    {
        if (!file_exists($xmlfilename)) {
            throw new Exception("File {$xmlfilename} does not exist...");
        }

        return self::readAndGuessFromContent(file_get_contents($xmlfilename));
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @codeCoverageIgnore
     *
     * @param string $xmlcontent The XML content as a string to read the invoice data from
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public static function readAndGuessFromContent(string $xmlcontent): ZugferdDocumentReader
    {
        $xmldocument = new SimpleXMLElement($xmlcontent);
        $typeelement = $xmldocument->xpath('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (!is_array($typeelement) || !isset($typeelement[0])) {
            throw new Exception('Coult not determaine the profile...');
        }

        foreach (ZugferdProfiles::PROFILEDEF as $profile => $profiledef) {
            if ($typeelement[0] == $profiledef["contextparameter"]) {
                return (new static($profile))->readContent($xmlcontent);
            }
        }

        throw new Exception('Could not determine the profile...');
    }

    /**
     * Read content of a zuferd/xrechnung xml from a file
     *
     * @codeCoverageIgnore
     *
     * @param string $xmlfilename The filename to read invoice data from
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    private function readFile(string $xmlfilename): ZugferdDocumentReader
    {
        if (!file_exists($xmlfilename)) {
            throw new Exception("File {$xmlfilename} does not exist...");
        }

        return $this->readContent(file_get_contents($xmlfilename));
    }

    /**
     * Read content of a zuferd/xrechnung xml from a string
     *
     * @codeCoverageIgnore
     *
     * @param string $xmlcontent The XML content as a string to read the invoice data from
     * @return ZugferdDocumentReader
     */
    private function readContent(string $xmlcontent): ZugferdDocumentReader
    {
        $this->invoiceObject = $this->serializer->deserialize($xmlcontent, 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\rsm\CrossIndustryInvoice', 'xml');
        return $this;
    }

    /**
     * Read general information about the document
     *
     * @param string|null $documentno Returns the document no issued by the seller
     * @param string|null $documenttypecode Returns the type of the document, See \horstoeko\codelists\ZugferdInvoiceType for details
     * @param DateTime|null $documentdate Returns the data when the document was issued by the seller
     * @param string|null $invoiceCurrency Returns the code for the invoice currency
     * @param string|null $taxCurrency Returns the code for the currency of the VAT posting
     * @param string|null $documentname Returns the document type (free text)
     * @param string|null $documentlanguage Returns the language code in which the document was written
     * @param DateTime|null $effectiveSpecifiedPeriod Returns the contractual due date of the invoice
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentInformation(?string &$documentno, ?string &$documenttypecode, ?DateTime &$documentdate, ?string &$invoiceCurrency, ?string &$taxCurrency, ?string &$documentname, ?string &$documentlanguage, ?DateTime &$effectiveSpecifiedPeriod): ZugferdDocumentReader
    {
        $documentno = $this->getInvoiceValueByPath("getExchangedDocument.getID", "");
        $documenttypecode = $this->getInvoiceValueByPath("getExchangedDocument.getTypeCode.value", "");
        $documentdate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString.getFormat", "")
        );
        $invoiceCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");
        $taxCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getTaxCurrencyCode.value", "");
        $documentname = $this->getInvoiceValueByPath("getExchangedDocument.getName.value", "");
        $documentlanguages = $this->getInvoiceValueByPath("getExchangedDocument.getLanguageID", []);
        $documentlanguage = (isset($documentlanguages[0]) ? $this->objectHelper->TryCallByPathAndReturn($documentlanguages[0], "value") : "");
        $effectiveSpecifiedPeriod = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString.getFormat", "")
        );
        return $this;
    }

    /**
     * Read general payment information
     *
     * @param string|null $creditorReferenceID Returns the identifier of the creditor (SEPA)
     * @param string|null $paymentReference Returns the Usage (SEPA)
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
     * @param boolean|null $copyindicator Returns true if this document is a copy from the original document
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
     * @param boolean|null $testdocumentindicator Returns true if this document is only for test purposes
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
     * @param float|null $grandTotalAmount Returns the total invoice amount including sales tax
     * @param float|null $duePayableAmount Returns the Payment amount due
     * @param float|null $lineTotalAmount Returns the sum of the net amounts of all invoice lines
     * @param float|null $chargeTotalAmount Returns the sum of the surcharges at document level
     * @param float|null $allowanceTotalAmount Returns the sum of the discounts at document level
     * @param float|null $taxBasisTotalAmount Returns the total invoice amount excluding sales tax
     * @param float|null $taxTotalAmount Returns the total amount of the invoice sales tax, total tax amount in the booking currency
     * @param float|null $roundingAmount Returns the rounding amount
     * @param float|null $totalPrepaidAmount Returns the alreay payed amout
     * @return ZugferdDocumentReader
     */
    public function getDocumentSummation(?float &$grandTotalAmount, ?float &$duePayableAmount, ?float &$lineTotalAmount, ?float &$chargeTotalAmount, ?float &$allowanceTotalAmount, ?float &$taxBasisTotalAmount, ?float &$taxTotalAmount, ?float &$roundingAmount, ?float &$totalPrepaidAmount): ZugferdDocumentReader
    {
        $invoiceCurrencyCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");

        $grandTotalAmountElement = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getGrandTotalAmount", 0);
        if (is_array($grandTotalAmountElement)) {
            foreach ($grandTotalAmountElement as $grandTotalAmountElementItem) {
                $grandTotalAmountCurrencyCode = $this->objectHelper->TryCallAndReturn($grandTotalAmountElementItem, "getCurrencyID") ?? "";
                if ($grandTotalAmountCurrencyCode == $invoiceCurrencyCode || $grandTotalAmountCurrencyCode == "") {
                    $grandTotalAmount = $this->objectHelper->TryCallAndReturn($grandTotalAmountElementItem, "value") ?? 0;
                    break;
                }
            }
        } else {
            $grandTotalAmount = $this->objectHelper->TryCallAndReturn($grandTotalAmountElement, "value") ?? 0;
        }

        $taxBasisTotalAmountElement = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxBasisTotalAmount", 0);
        if (is_array($taxBasisTotalAmountElement)) {
            foreach ($taxBasisTotalAmountElement as $taxBasisTotalAmountElementItem) {
                $taxBasisTotalAmountCurrencyCode = $this->objectHelper->TryCallAndReturn($taxBasisTotalAmountElementItem, "getCurrencyID") ?? "";
                if ($taxBasisTotalAmountCurrencyCode == $invoiceCurrencyCode || $taxBasisTotalAmountCurrencyCode == "") {
                    $taxBasisTotalAmount = $this->objectHelper->TryCallAndReturn($taxBasisTotalAmountElementItem, "value") ?? 0;
                    break;
                }
            }
        } else {
            $taxBasisTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxBasisTotalAmount.value", 0);
        }

        $taxTotalAmountElement = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxTotalAmount", 0);
        if (is_array($taxTotalAmountElement)) {
            foreach ($taxTotalAmountElement as $taxTotalAmountElementItem) {
                $taxTotalAmountCurrencyCode = $this->objectHelper->TryCallAndReturn($taxTotalAmountElementItem, "getCurrencyID") ?? "";
                if ($taxTotalAmountCurrencyCode == $invoiceCurrencyCode || $taxTotalAmountCurrencyCode == "") {
                    $taxTotalAmount = $this->objectHelper->TryCallAndReturn($taxTotalAmountElementItem, "value") ?? 0;
                    break;
                }
            }
        } else {
            $taxTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxBasisTotalAmount.value", 0);
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
     * @param array|null $notes Returns an array with all document notes. Each array element
     * contains an assiociative array containing the following keys: _contentcode_, _subjectcode_ and
     * _content_
     * @return ZugferdDocumentReader
     */
    public function getDocumentNotes(?array &$notes): ZugferdDocumentReader
    {
        $notes = $this->getInvoiceValueByPath("getExchangedDocument.getIncludedNote", []);
        $notes = $this->convertToArray($notes, [
            "contentcode" => ["getContentCode.value", ""],
            "subjectcode" => ["getSubjectCode.value", ""],
            "content" => ["getContent.value", ""],
        ]);

        return $this;
    }

    /**
     * Get detailed information about the seller (=service provider)
     *
     * @param string|null $name 
     * The full formal name under which the seller is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param array|null $id 
     * An identifier of the seller. In many systems, seller identification
     * is key information. Multiple seller IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param string|null $description 
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
     * __Note:__ The Seller's ID identification scheme is a unique identifier 
     * assigned to a seller by a global registration organization
     *
     * @param array|null $globalID 
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
     * __Note:__ The local identification (defined by the seller's address) of the seller for tax purposes or a reference that 
     * enables the seller to indicate his reporting status for tax purposes. This information may have an impact on how the buyer 
     * pays the bill (such as regarding social security contributions). So e.g. in some countries, if the seller is not reported 
     * for tax, the buyer will withhold the tax amount and pay it on behalf of the seller
     *
     * @param array|null $taxreg 
     * Array of sales tax identification numbers of the seller indexed by __FC__ for _Tax number of the seller_ and __VA__
     * for _Sales tax identification number of the seller_
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
     * @param array|null $subdivision 
     * The sellers state
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of seller trade party
     *
     * @param string|null $legalorgid 
     * An identifier issued by an official registrar that identifies the
     * seller as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, 
     * it should be known to the buyer and seller
     * @param string|null $legalorgtype The identifier for the identification scheme of the legal 
     * registration of the seller. If the identification scheme is used, it must be selected from 
     * ISO/IEC 6523 list
     * @param string|null $legalorgname A name by which the seller is known, if different from the seller's name 
     * (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Get detailed information on the seller's contact person
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get detailed information about the buyer (service recipient)
     *
     * @param string|null $name 
     * The full name of the buyer
     * @param array|null $id 
     * An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be 
     * assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, 
     * it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param string|null $description 
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
     * __Note:__ The buyers's ID identification scheme is a unique identifier 
     * assigned to a buyer by a global registration organization
     *
     * @param array|null $globalID 
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
     * __Note:__ The local identification (defined by the buyer's address) of the buyer for tax purposes or a reference that 
     * enables the buyer to indicate his reporting status for tax purposes.
     *
     * @param array|null $taxreg 
     * Array of sales tax identification numbers of the buyer indexed by __VA__ for _Sales tax identification number of the buyer_
     * Only the code __VA__ is permitted as an identification scheme
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
     * @param array|null $subdivision 
     * The buyers state
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of buyer trade party
     *
     * @param string|null $legalorgid 
     * An identifier issued by an official registrar that identifies the
     * buyer as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, 
     * it should be known to the buyer and buyer
     * @param string|null $legalorgtype The identifier for the identification scheme of the legal 
     * registration of the buyer. If the identification scheme is used, it must be selected from 
     * ISO/IEC 6523 list
     * @param string|null $legalorgname A name by which the buyer is known, if different from the buyers name 
     * (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Get contact information of buyer trade party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentBuyerContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get detailed information about the seller's tax agent
     *
     * @param string|null $name 
     * The full name of the seller's tax agent
     * @param array|null $id 
     * An identifier of the sellers tax agent.
     * @param string|null $description 
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
     * @param array|null $globalID 
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
     * __Note:__ The local identification (defined by the sellers tax agent address) of the tax agent for tax purposes 
     * or a reference that enables the sellers tax agent to indicate his reporting status for tax purposes.
     *
     * @param array|null $taxreg 
     * Array of sales tax identification numbers of the sellers tax agent indexed by __VA__ for _Sales tax identification 
     * number of the tax agent. _ Only the code __VA__ is permitted as an identification scheme
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
     * @param array|null $subdivision 
     * The sellers tax agent state
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of sellers tax agent
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Get contact information of sellers tax agent
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentSellerTaxRepresentativeContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerTaxRepresentativeTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get detailed information on the product end user (general information)
     *
     * @param string|null $name 
     * The full formal name under which the product end user is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param array|null $id 
     * An identifier of the product end user. In many systems, product end user identification
     * is key information. Multiple product end user IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to all trade
     * parties, e.g. a previously exchanged
     * @param string|null $description 
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
     * __Note:__ The product end users ID identification scheme is a unique identifier 
     * assigned to a product end user by a global registration organization
     *
     * @param array|null $globalID 
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
     * @param array|null $taxreg 
     * Array of sales tax identification numbers of the product end user indexed by __FC__ for _Tax number of the product end user_ and __VA__
     * for _Sales tax identification number of the product end user_
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
     * @param array|null $subdivision 
     * The product end users state
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Get the legal organisation of product end user
     *
     * @param string|null $legalorgid 
     * An identifier issued by an official registrar that identifies the
     * product end user as a legal entity or legal person. If no identification scheme ($legalorgtype) is provided, 
     * it should be known to all trade parties
     * @param string|null $legalorgtype The identifier for the identification scheme of the legal 
     * registration of the product end user. If the identification scheme is used, it must be selected from 
     * ISO/IEC 6523 list
     * @param string|null $legalorgname A name by which the product end user is known, if different from the product 
     * end users name (also known as the company name)
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Get detailed information on the product end user's contact person
     *
     * @param string|null $contactpersonname
     * Contact point for a legal entity,
     * such as a personal name of the contact person
     * @param string|null $contactdepartmentname
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $contactphoneno
     * Detailed information on the product end user's phone number
     * @param string|null $contactfaxno
     * Detailed information on the product end user's fax number
     * @param string|null $contactemailadd
     * Detailed information on the product end user's email address
     * @return ZugferdDocumentReader
     */
    public function getDocumentProductEndUserContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getProductEndUserTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get detailed information on the different ship-to party
     *
     * @param string|null $name 
     * The name of the party to whom the goods are being delivered or for whom the services are being 
     * performed. Must be used if the recipient of the goods or services is not the same as the buyer.
     * @param array|null $id 
     * An identifier for the place where the goods are delivered or where the services are provided.
     * Multiple IDs can be assigned or specified. They can be differentiated by using different 
     * identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. 
     * a previously exchanged identifier assigned by the buyer or seller.
     * @param string|null $description 
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
     * @param array|null $globalID 
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
     * @param array|null $taxreg 
     * Array of sales tax identification numbers of the party indexed by __FC__ for _Tax number of the party_ and __VA__
     * for _Sales tax identification number of the party_
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
     * __Note__: In the event of a collection, the delivery address corresponds to the collection address. In order
     * to meet the legal requirements, a sufficient number of components of the address must be entered.
     * Synonym: detailed information on the address of the recipient of the goods
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
     * @param array|null $subdivision 
     * The party's state
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Ship-To trade party
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Get detailed information on the contact person of the goods recipient
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipToContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipToTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get Ultimate Ship-To information
     *
     * @param string|null $name
     * @param array|null $id
     * @param string|null $description
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipTo(?string &$name, ?array &$id, ?string &$description): ZugferdDocumentReader
    {
        $name = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getName.value", "");
        $id = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getID", []);
        $description = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDescription.value", "");

        $id = $this->convertToArray($id, ["id" => "value"]);

        return $this;
    }

    /**
     * Get document Ultimate Ship-To global ids
     *
     * @param array|null $globalID
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Tax registration of Ultimate Ship-To Trade party
     *
     * @param array|null $taxreg
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Address of Ultimate Ship-To trade party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param array|null $subdivision
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Ultimate Ship-To trade party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Contact information of Ultimate Ship-To trade party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateShipToContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getUltimateShipToTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get Ship-From information
     *
     * @param string|null $name
     * @param array|null $id
     * @param string|null $description
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
     * Get document Ship-From global ids
     *
     * @param array|null $globalID
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Tax registration of Ship-From Trade party
     *
     * @param array|null $taxreg
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Address of Ship-From trade party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param array|null $subdivision
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Ship-From trade party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Contact information of Ship-From trade party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentReader
     */
    public function getDocumentShipFromContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getShipFromTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get Invoicer information
     *
     * @param string|null $name
     * @param array|null $id
     * @param string|null $description
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
     * Get document Invoicer global ids
     *
     * @param array|null $globalID
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Tax registration of Invoicer Trade party
     *
     * @param array|null $taxreg
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Address of Invoicer trade party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param array|null $subdivision
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Invoicer trade party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Contact information of Invoicer trade party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoicerContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoicerTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get Invoicee information
     *
     * @param string|null $name
     * @param array|null $id
     * @param string|null $description
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
     * Get document Invoicee global ids
     *
     * @param array|null $globalID
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Tax registration of Invoicee Trade party
     *
     * @param array|null $taxreg
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Address of Invoicee trade party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param array|null $subdivision
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Invoicee trade party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Contact information of Invoicee trade party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentReader
     */
    public function getDocumentInvoiceeContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceeTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get Payee information
     *
     * @param string|null $name
     * @param array|null $id
     * @param string|null $description
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
     * Get document Payee global ids
     *
     * @param array|null $globalID
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeGlobalId(?array &$globalID): ZugferdDocumentReader
    {
        $globalID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getGlobalID", []);
        $globalID = $this->convertToAssociativeArray($globalID, "getSchemeID", "value");

        return $this;
    }

    /**
     * Tax registration of Payee Trade party
     *
     * @param array|null $taxreg
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeTaxRegistration(?array &$taxreg): ZugferdDocumentReader
    {
        $taxreg = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedTaxRegistration", []);
        $taxreg = $this->convertToAssociativeArray($taxreg, "getID.getSchemeID", "getID.value");

        return $this;
    }

    /**
     * Address of Payee trade party
     *
     * @param string|null $lineone
     * @param string|null $linetwo
     * @param string|null $linethree
     * @param string|null $postcode
     * @param string|null $city
     * @param string|null $country
     * @param array|null $subdivision
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeAddress(?string &$lineone, ?string &$linetwo, ?string &$linethree, ?string &$postcode, ?string &$city, ?string &$country, ?array &$subdivision): ZugferdDocumentReader
    {
        $lineone = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineOne", "");
        $linetwo = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineTwo", "");
        $linethree = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getLineThree", "");
        $postcode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getPostcodeCode", "");
        $city = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCityName", "");
        $country = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCountryID.value", "");
        $subdivision = $this->convertToArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getPostalTradeAddress.getCountrySubDivisionName", []), ["value"]);

        return $this;
    }

    /**
     * Legal organisation of Payee trade party
     *
     * @param string|null $legalorgid
     * @param string|null $legalorgtype
     * @param string|null $legalorgname
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeLegalOrganisation(?string &$legalorgid, ?string &$legalorgtype, ?string &$legalorgname): ZugferdDocumentReader
    {
        $legalorgid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getID.value", "");
        $legalorgtype = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getID.getSchemeID", "");
        $legalorgname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getSpecifiedLegalOrganization.getTradingBusinessName", "");

        return $this;
    }

    /**
     * Contact information of Payee trade party
     *
     * @param string|null $contactpersonname
     * @param string|null $contactdepartmentname
     * @param string|null $contactphoneno
     * @param string|null $contactfaxno
     * @param string|null $contactemailadd
     * @return ZugferdDocumentReader
     */
    public function getDocumentPayeeContact(?string &$contactpersonname, ?string &$contactdepartmentname, ?string &$contactphoneno, ?string &$contactfaxno, ?string &$contactemailadd): ZugferdDocumentReader
    {
        $contactpersonname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact.getPersonName", "");
        $contactdepartmentname = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact.getDepartmentName", "");
        $contactphoneno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact.getTelephoneUniversalCommunication.getCompleteNumber", "");
        $contactfaxno = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact.getFaxUniversalCommunication.getCompleteNumber", "");
        $contactemailadd = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPayeeTradeParty.getDefinedTradeContact.getEmailURIUniversalCommunication.getURIID", "");

        return $this;
    }

    /**
     * Get detailed information on the delivery conditions
     *
     * @param string|null $code
     * @return ZugferdDocumentReader
     */
    public function getDocumentDeliveryTerms(?string &$code): ZugferdDocumentReader
    {
        $code = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getApplicableTradeDeliveryTerms.setDeliveryTypeCode.value", "");

        return $this;
    }

    /**
     * Get Details of the associated confirmation of the order
     *
     * @param string|null $issuerassignedid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentSellerOrderReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getSellerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get the details of the related order
     *
     * @param string|null $issuerassignedid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentBuyerOrderReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Get the details of a related contract document
     *
     * @param string|null $issuerassignedid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentContractReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getContractReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
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
     * Documents justifying the invoice. Use ZugferdDocumentReader::firstDocumentAdditionalReferencedDocument and
     * ZugferdDocumentReader::nextDocumentAdditionalReferencedDocument to seek between multiple additional referenced
     * documents
     *
     * @param string|null $issuerassignedid
     * @param string|null $typecode
     * @param string|null $uriid
     * @param array|null $name
     * @param string|null $reftypecode
     * @param DateTime|null $issueddate
     * @param string|null $binarydatafilename
     * @return ZugferdDocumentReader
     * @throws Exception
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
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );
        $binarydatafilename = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.getFilename", "");
        $binarydata = $this->getInvoiceValueByPathFrom($addRefDoc, "getAttachmentBinaryObject.value", "");
        if ($binarydatafilename && $binarydata && $this->binarydatadirectory) {
            $binarydatafilename = join(DIRECTORY_SEPARATOR, array($this->binarydatadirectory, $binarydatafilename));
            file_put_contents($binarydatafilename, base64_decode($binarydata));
        } else {
            $binarydatafilename = "";
        }

        return $this;
    }

    /**
     * Get all additional referenced documents
     *
     * @param array|null $refdocs
     * @return ZugferdDocumentReader
     */
    public function getDocumentAdditionalReferencedDocuments(?array &$refdocs): ZugferdDocumentReader
    {
        $refdocs = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getAdditionalReferencedDocument", []);
        $refdocs = $this->convertToArray($refdocs, [
            "IssuerAssignedID" => ["getIssuerAssignedID.value", ""],
            "URIID" => ["getURIID.value", ""],
            "LineID" => ["getLineID.value", ""],
            "TypeCode" => ["getTypeCode.value", ""],
            "ReferenceTypeCode" => ["getReferenceTypeCode.value", ""],
            "FormattedIssueDateTime" => ["getFormattedIssueDateTime.getDateTimeString.value", ""],
        ]);

        return $this;
    }

    /**
     * Get Details of a project reference
     *
     * @param string|null $id
     * @param string|null $name
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
     * Details of the ultimate customer order
     *
     * @param string|null $issuerassignedid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentUltimateCustomerOrderReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $addRefDoc = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeAgreement.getUltimateCustomerOrderReferencedDocument", []);
        $addRefDoc = $addRefDoc[$this->documentUltimateCustomerOrderReferencedDocumentPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Details of the ultimate customer order
     *
     * @param array|null $refdocs
     * @return ZugferdDocumentReader
     */
    public function getDocumentUltimateCustomerOrderReferencedDocuments(?array $refdocs): ZugferdDocumentReader
    {
        //!! TODO
        return $this;
    }

    /**
     * Detailed information on the actual delivery
     *
     * @param DateTime|null $date
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentSupplyChainEvent(?DateTime &$date): ZugferdDocumentReader
    {
        $date = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime.getDateTimeString.getformat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentDespatchAdviceReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentReceivingAdviceReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated delivery note
     *
     * @param string|null $issuerassignedid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentDeliveryNoteReferencedDocument(?string &$issuerassignedid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $issuerassignedid = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getIssuerAssignedID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first payment means of the document
     *
     * @return boolean
     */
    public function firstGetDocumentPaymentMeans(): bool
    {
        $this->documentPaymentMeansPointer = 0;
        $paymentMeans = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));
        return isset($paymentMeans[$this->documentPaymentMeansPointer]);
    }

    /**
     * Seek to the next payment means of the document
     *
     * @return boolean
     */
    public function nextGetDocumentPaymentMeans(): bool
    {
        $this->documentPaymentMeansPointer++;
        $paymentMeans = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));
        return isset($paymentMeans[$this->documentPaymentMeansPointer]);
    }

    /**
     * Get current payment means
     *
     * @param string|null $typecode
     * @param string|null $information
     * @param string|null $cardType
     * @param string|null $cardId
     * @param string|null $cardHolderName
     * @param string|null $buyerIban
     * @param string|null $payeeIban
     * @param string|null $payeeAccountName
     * @param string|null $payeePropId
     * @param string|null $payeeBic
     * @return ZugferdDocumentReader
     */
    public function getDocumentPaymentMeans(?string &$typecode, ?string &$information, ?string &$cardType, ?string &$cardId, ?string &$cardHolderName, ?string &$buyerIban, ?string &$payeeIban, ?string &$payeeAccountName, ?string &$payeePropId, ?string &$payeeBic): ZugferdDocumentReader
    {
        $paymentMeans = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementPaymentMeans", []));
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
     *
     * @return boolean
     */
    public function firstDocumentTax(): bool
    {
        $this->documentTaxPointer = 0;
        $taxes = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getApplicableTradeTax", []));
        return isset($taxes[$this->documentTaxPointer]);
    }

    /**
     * Seek to the next document tax
     *
     * @return boolean
     */
    public function nextDocumentTax(): bool
    {
        $this->documentTaxPointer++;
        $taxes = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getApplicableTradeTax", []));
        return isset($taxes[$this->documentTaxPointer]);
    }

    /**
     * Get current tax
     *
     * @param string|null $categoryCode
     * @param string|null $typeCode
     * @param float|null $basisAmount
     * @param float|null $calculatedAmount
     * @param float|null $rateApplicablePercent
     * @param string|null $exemptionReason
     * @param string|null $exemptionReasonCode
     * @param float|null $lineTotalBasisAmount
     * @param float|null $allowanceChargeBasisAmount
     * @param DateTime|null $taxPointDate
     * @param string|null $dueDateTypeCode
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentTax(?string &$categoryCode, ?string &$typeCode, ?float &$basisAmount, ?float &$calculatedAmount, ?float &$rateApplicablePercent, ?string &$exemptionReason, ?string &$exemptionReasonCode, ?float &$lineTotalBasisAmount, ?float &$allowanceChargeBasisAmount, ?DateTime &$taxPointDate, ?string &$dueDateTypeCode): ZugferdDocumentReader
    {
        $taxes = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getApplicableTradeTax", []));
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
        $taxPointDate = $this->objectHelper->ToDateTime(
            $this->objectHelper->TryCallByPathAndReturn($taxes, "getTaxPointDate.getDateString.value"),
            $this->objectHelper->TryCallByPathAndReturn($taxes, "getTaxPointDate.getDateString.getFormat")
        );
        $dueDateTypeCode = $this->getInvoiceValueByPathFrom($taxes, "getDueDateTypeCode.value", "");

        return $this;
    }

    /**
     * Gets the billing period
     *
     * @param DateTime|null $startdate
     * @param DateTime|null $endDate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentBillingPeriod(?DateTime &$startdate, ?DateTime &$endDate): ZugferdDocumentReader
    {
        $startdate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.getFormat", null)
        );
        $endDate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Get allowances/charges at document level
     *
     * @param array|null $allowanceCharge
     * @return ZugferdDocumentReader
     */
    public function getDocumentAllowanceCharges(?array &$allowanceCharge): ZugferdDocumentReader
    {
        $allowanceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeAllowanceCharge", []);
        $allowanceCharge = $this->convertToArray($allowanceCharge, [
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
                return $this->objectHelper->ToDateTime(
                    $this->objectHelper->TryCallByPathAndReturn($item, "getCategoryTradeTax.getTaxPointDate.getDateString.value"),
                    $this->objectHelper->TryCallByPathAndReturn($item, "getCategoryTradeTax.getTaxPointDate.getDateString.getFormat")
                );
            },
            "taxduedatetypecode" => ["getCategoryTradeTax.getDueDateTypeCode.value", ""],
            "taxrateapplicablepercent" => ["getCategoryTradeTax.getRateApplicablePercent.value", 0.0],
        ]);

        return $this;
    }

    /**
     * Seek to the first documents allowance charge
     * Returns true if the first position is available, otherwise false
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
     * Seek to the next documents allowance charge
     * Returns true if a other position is available, otherwise false
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
     * Get currently seeked documents allowance charge position
     *
     * @param float|null $actualAmount
     * @param boolean|null $isCharge
     * @param string|null $taxCategoryCode
     * @param string|null $taxTypeCode
     * @param float|null $rateApplicablePercent
     * @param float|null $sequence
     * @param float|null $calculationPercent
     * @param float|null $basisAmount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
     * @param string|null $reasonCode
     * @param string|null $reason
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
     * Get currently seeked documents logistic service charge
     *
     * @param string|null $description
     * @param float|null $appliedAmount
     * @param array|null $taxTypeCodes
     * @param array|null $taxCategpryCodes
     * @param array|null $rateApplicablePercents
     * @return ZugferdDocumentReader
     */
    public function getDocumentLogisticsServiceCharge(?string &$description, ?float &$appliedAmount, ?array &$taxTypeCodes = null, ?array &$taxCategpryCodes = null, ?array &$rateApplicablePercents = null): ZugferdDocumentReader
    {
        $serviceCharge = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedLogisticsServiceCharge", []);
        $serviceCharge = $serviceCharge[$this->documentLogisticServiceChargePointer];

        $description = $this->getInvoiceValueByPathFrom($serviceCharge, "getDescription.value", "");
        $appliedAmount = $this->getInvoiceValueByPathFrom($serviceCharge, "getAppliedAmount.value", 0.0);
        $appliedTradeTax = $this->getInvoiceValueByPathFrom($serviceCharge, "getAppliedTradeTax", []);
        $taxTypeCodes = $this->convertToArray($appliedTradeTax, [
            "typecode" => ["getTypeCode.value", ""],
        ]);
        $taxCategpryCodes = $this->convertToArray($appliedTradeTax, [
            "categorycode" => ["getCategoryCode.value", ""],
        ]);
        $rateApplicablePercents = $this->convertToArray($appliedTradeTax, [
            "percent" => ["getRateApplicablePercent.value", 0.0],
        ]);

        return $this;
    }

    /**
     * Get all documents payment terms
     *
     * @param array|null $paymentTerms
     * @return ZugferdDocumentReader
     */
    public function getDocumentPaymentTerms(?array &$paymentTerms): ZugferdDocumentReader
    {
        $paymentTerms = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []);
        $paymentTerms = $this->convertToArray($paymentTerms, [
            "description" => ["getDescription.value", ""],
            "duedate" => function ($item) {
                return $this->objectHelper->ToDateTime(
                    $this->objectHelper->TryCallByPathAndReturn($item, "getDueDateDateTime.getDateTimeString.value"),
                    $this->objectHelper->TryCallByPathAndReturn($item, "getDueDateDateTime.getDateTimeString.getFormat")
                );
            },
            "directdebitmandateid" => ["getDirectDebitMandateID.value", ""],
            "partialpaymentamount" => ["getPartialPaymentAmount.value", 0.0],
        ]);

        return $this;
    }

    /**
     * Seek to the first documents payment terms position
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function firstDocumentPaymentTerms(): bool
    {
        $this->documentPaymentTermsPointer = 0;
        $paymentTerms = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        return isset($paymentTerms[$this->documentPaymentTermsPointer]);
    }

    /**
     * Seek to the next documents payment terms position
     * Returns true if a other position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPaymentTerms(): bool
    {
        $this->documentPaymentTermsPointer++;
        $paymentTerms = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        return isset($paymentTerms[$this->documentPaymentTermsPointer]);
    }

    /**
     * Get current payment term
     *
     * @param string|null $description
     * @param DateTime|null $dueDate
     * @param string|null $directDebitMandateID
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPaymentTerm(?string &$description, ?DateTime &$dueDate, ?string &$directDebitMandateID): ZugferdDocumentReader
    {
        $paymentTerms = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        $paymentTerms = $paymentTerms[$this->documentPaymentTermsPointer];

        $description = $this->getInvoiceValueByPathFrom($paymentTerms, "getDescription.value", "");
        $dueDate = $this->objectHelper->ToDateTime(
            $this->objectHelper->TryCallByPathAndReturn($paymentTerms, "getDueDateDateTime.getDateTimeString.value"),
            $this->objectHelper->TryCallByPathAndReturn($paymentTerms, "getDueDateDateTime.getDateTimeString.getFormat")
        );
        $directDebitMandateID = $this->getInvoiceValueByPathFrom($paymentTerms, "getDirectDebitMandateID.value", "");

        return $this;
    }

    /**
     * Get discount terms of the current payment term
     *
     * @param float|null $calculationPercent
     * @param DateTime|null $basisDateTime
     * @param float|null $basisPeriodMeasureValue
     * @param string|null $basisPeriodMeasureUnitCode
     * @param float|null $basisAmount
     * @param float|null $actualDiscountAmount
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDiscountTermsFromPaymentTerm(?float &$calculationPercent, ?DateTime &$basisDateTime, ?float &$basisPeriodMeasureValue, ?string &$basisPeriodMeasureUnitCode, ?float &$basisAmount, ?float &$actualDiscountAmount): ZugferdDocumentReader
    {
        $paymentTerms = $this->objectHelper->EnsureArray($this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradePaymentTerms", []));
        $paymentTerms = $paymentTerms[$this->documentPaymentTermsPointer];

        $calculationPercent = $this->getInvoiceValueByPathFrom($paymentTerms, "getApplicableTradePaymentDiscountTerms.getCalculationPercent.value", 0.0);
        $basisDateTime = $this->objectHelper->ToDateTime(
            $this->objectHelper->TryCallByPathAndReturn($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisDateTime.getDateTimeString.value"),
            $this->objectHelper->TryCallByPathAndReturn($paymentTerms, "getApplicableTradePaymentDiscountTerms.getBasisDateTime.getDateTimeString.getFormat")
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
     *
     * @return boolean
     */
    public function firstDocumentPosition(): bool
    {
        $this->positionPointer = 0;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        return isset($tradeLineItem[$this->positionPointer]);
    }

    /**
     * Seek to the next document position
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPosition(): bool
    {
        $this->positionPointer++;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        return isset($tradeLineItem[$this->positionPointer]);
    }

    /**
     * Get general information of the current position
     *
     * @param string|null $lineid
     * @param string|null $lineStatusCode
     * @param string|null $lineStatusReasonCode
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionGenerals(?string &$lineid, ?string &$lineStatusCode, ?string &$lineStatusReasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineID", "");
        $lineStatusCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineStatusCode", "");
        $lineStatusReasonCode = $this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getLineStatusReasonCode", "");

        return $this;
    }

    /**
     * Seek to the first document position
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function firstDocumentPositionNote(): bool
    {
        $this->positionNotePointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemNote = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getIncludedNote", []));

        return isset($tradeLineItemNote[$this->positionNotePointer]);
    }

    /**
     * Seek to the next document position
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPositionNote(): bool
    {
        $this->positionNotePointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $tradeLineItemNote = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getIncludedNote", []));

        return isset($tradeLineItemNote[$this->positionNotePointer]);
    }

    /**
     * Get position note of the current position
     *
     * @param string|null $content
     * @param string|null $contentCode
     * @param string|null $subjectCode
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionNote(?string &$content, ?string &$contentCode, ?string &$subjectCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $tradeLineItemNote = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getAssociatedDocumentLineDocument.getIncludedNote", []));
        $tradeLineItemNote = $tradeLineItemNote[$this->positionNotePointer];

        $content = $this->getInvoiceValueByPathFrom($tradeLineItemNote, "getContent.value", "");
        $contentCode = $this->getInvoiceValueByPathFrom($tradeLineItemNote, "getContentCode.value", "");
        $subjectCode = $this->getInvoiceValueByPathFrom($tradeLineItemNote, "getSubjectCode.value", "");

        return $this;
    }

    /**
     * Get product details of the current position
     *
     * @param string|null $name
     * @param string|null $description
     * @param string|null $sellerAssignedID
     * @param string|null $buyerAssignedID
     * @param string|null $globalIDType
     * @param string|null $globalID
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
     * Details of the related order of the current position
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionBuyerOrderReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getBuyerOrderReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Details of the related contract of the current position
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionContractReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getContractReferencedDocument.getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Seek to the first documents position additional referenced document
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function firstDocumentPositionAdditionalReferencedDocument(): bool
    {
        $this->positionAddRefDocPointer = 0;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $addRefDoc = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));
        return isset($addRefDoc[$this->positionAddRefDocPointer]);
    }

    /**
     * Seek to the next documents position additional referenced document
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPositionAdditionalReferencedDocument(): bool
    {
        $this->positionAddRefDocPointer++;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $addRefDoc = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));
        return isset($addRefDoc[$this->positionAddRefDocPointer]);
    }

    /**
     * Details of an additional Document reference on a position
     * Detailangaben zu einer zusätzlichen Dokumentenreferenz auf Positionsebene
     *
     * @param string|null $issuerassignedid
     * @param string|null $typecode
     * @param string|null $uriid
     * @param string|null $lineid
     * @param string|null $name
     * @param string|null $reftypecode
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionAdditionalReferencedDocument(?string &$issuerassignedid, ?string &$typecode, ?string &$uriid, ?string &$lineid, ?string &$name, ?string &$reftypecode, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $addRefDoc = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getAdditionalReferencedDocument", []));
        $addRefDoc = $addRefDoc[$this->positionAddRefDocPointer];

        $typecode = $this->getInvoiceValueByPathFrom($addRefDoc, "getTypeCode.value", "");
        $issuerassignedid = $this->getInvoiceValueByPathFrom($addRefDoc, "getIssuerAssignedID.value", "");
        $reftypecode = $this->getInvoiceValueByPathFrom($addRefDoc, "getReferenceTypeCode.value", "");
        $uriid = $this->getInvoiceValueByPathFrom($addRefDoc, "getURIID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($addRefDoc, "getLineID.value", "");
        $name = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($addRefDoc, "getName.value", ""));
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($addRefDoc, "getFormattedIssueDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    //TODO: DocumentPositionUltimateCustomerOrderReferencedDocument

    /**
     * Get documents position gross price
     *
     * @param float|null $amount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
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
     *
     * @return boolean
     */
    public function firstDocumentPositionGrossPriceAllowanceCharge(): bool
    {
        $this->positionGrossPriceAllowanceChargePointer = 0;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getAppliedTradeAllowanceCharge", []));
        return isset($allowanceCharge[$this->positionGrossPriceAllowanceChargePointer]);
    }

    /**
     * Seek to the next documents position gross price allowance charge position
     * Returns true if a other position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPositionGrossPriceAllowanceCharge(): bool
    {
        $this->positionGrossPriceAllowanceChargePointer++;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getAppliedTradeAllowanceCharge", []));
        return isset($allowanceCharge[$this->positionGrossPriceAllowanceChargePointer]);
    }

    /**
     * Detailed information on surcharges and discounts
     * Detailinformationen zu Zu- und Abschlägen
     *
     * @param float|null $actualAmount
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionGrossPriceAllowanceCharge(?float &$actualAmount, ?bool &$isCharge, ?float &$calculationPercent, ?float &$basisAmount, ?string &$reason, ?string &$taxTypeCode, ?string &$taxCategoryCode, ?float &$rateApplicablePercent, ?float &$sequence, ?float &$basisQuantity, ?string &$basisQuantityUnitCode, ?string &$reasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeAgreement.getGrossPriceProductTradePrice.getAppliedTradeAllowanceCharge", []));
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
     * Detailed information on the net price of the item
     * Detailinformationen zum Nettopreis des Artikels
     *
     * @param float|null $amount
     * @param float|null $basisQuantity
     * @param string|null $basisQuantityUnitCode
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
     * Enthaltene Steuer für B2C auf Positionsebene
     *
     * @param string|null $categoryCode
     * @param string|null $typeCode
     * @param float|null $rateApplicablePercent
     * @param float|null $calculatedAmount
     * @param string|null $exemptionReason
     * @param string|null $exemptionReasonCode
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
     * @param float|null $billedQuantity
     * @param string|null $billedQuantityUnitCode
     * @param float|null $chargeFreeQuantity
     * @param string|null $chargeFreeQuantityUnitCpde
     * @param float|null $packageQuantity
     * @param string|null $packageQuantityUnitCode
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
     * Detailed information on the actual delivery on item level
     *
     * @param DateTime|null $date
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionSupplyChainEvent(?DateTime &$date): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $date = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getActualDeliverySupplyChainEvent.getOccurrenceDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on position level
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionDespatchAdviceReferencedDocument(?string &$issuerassignedid, ?string &$lineid = null, ?DateTime &$issueddate = null): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDespatchAdviceReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated shipping notification on position level
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionReceivingAdviceReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getReceivingAdviceReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Detailed information on the associated delivery note on position level
     *
     * @param string|null $issuerassignedid
     * @param string|null $lineid
     * @param DateTime|null $issueddate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionDeliveryNoteReferencedDocument(?string &$issuerassignedid, ?string &$lineid, ?DateTime &$issueddate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $issuerassignedid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getIssuerAssignedID.value", "");
        $lineid = $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getLineID.value", "");
        $issueddate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime.getDateTimeString.value", ""),
            $this->getInvoiceValueByPath("getSpecifiedLineTradeDelivery.getDeliveryNoteReferencedDocument.getFormattedIssueDateTime,getDateTimeString.getFormat", "")
        );

        return $this;
    }

    /**
     * Seek to the first document position tax
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function firstDocumentPositionTax(): bool
    {
        $this->positionTaxPointer = 0;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $taxes = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getApplicableTradeTax", []));

        return isset($taxes[$this->positionTaxPointer]);
    }

    /**
     * Seek to the next document position tax
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPositionTax(): bool
    {
        $this->positionTaxPointer++;

        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $taxes = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getApplicableTradeTax", []));

        return isset($taxes[$this->positionTaxPointer]);
    }

    /**
     * A group of business terms that contains information about the sales tax that applies to
     * the goods and services invoiced on the relevant invoice line
     *
     * @param string|null $categoryCode
     * @param string|null $typeCode
     * @param float|null $rateApplicablePercent
     * @param float|null $calculatedAmount
     * @param string|null $exemptionReason
     * @param string|null $exemptionReasonCode
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionTax(?string &$categoryCode, ?string &$typeCode, ?float &$rateApplicablePercent, ?float &$calculatedAmount, ?string &$exemptionReason, ?string &$exemptionReasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $taxes = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getApplicableTradeTax", []));
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
     * Gets the billing period on position level
     *
     * @param DateTime|null $startdate
     * @param DateTime|null $endDate
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public function getDocumentPositionBillingPeriod(?DateTime &$startdate, ?DateTime &$endDate): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $startdate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getStartDateTime.getDateTimeString.getFormat", null)
        );
        $endDate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.value", null),
            $this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getBillingSpecifiedPeriod.getEndDateTime.getDateTimeString.getFormat", null)
        );

        return $this;
    }

    /**
     * Seek to the first documents position allowance charge position
     * Returns true if the first position is available, otherwise false
     *
     * @return boolean
     */
    public function firstDocumentPositionAllowanceCharge(): bool
    {
        $this->positionAllowanceChargePointer = 0;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));
        return isset($allowanceCharge[$this->positionAllowanceChargePointer]);
    }

    /**
     * Seek to the next documents position gross price allowance charge position
     * Returns true if a other position is available, otherwise false
     *
     * @return boolean
     */
    public function nextDocumentPositionAllowanceCharge(): bool
    {
        $this->positionAllowanceChargePointer++;
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];
        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));
        return isset($allowanceCharge[$this->positionAllowanceChargePointer]);
    }

    /**
     * Detailed information on surcharges and discounts on position level
     * Detailinformationen zu Zu- und Abschlägen
     *
     * @param float|null $actualAmount
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
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAllowanceCharge(?float &$actualAmount, ?bool &$isCharge, ?float &$calculationPercent, ?float &$basisAmount, ?string &$reason, ?string &$taxTypeCode, ?string &$taxCategoryCode, ?float &$rateApplicablePercent, ?float &$sequence, ?float &$basisQuantity, ?string &$basisQuantityUnitCode, ?string &$reasonCode): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));
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
     * Detailinformationen zu Zu- und Abschlägen
     *
     * @param float|null $actualAmount
     * @param boolean|null $isCharge
     * @param float|null $calculationPercent
     * @param float|null $basisAmount
     * @param string|null $reasonCode
     * @param string|null $reason
     * @return ZugferdDocumentReader
     */
    public function getDocumentPositionAllowanceCharge2(?float &$actualAmount, ?bool &$isCharge, ?float &$calculationPercent, ?float &$basisAmount, ?string &$reasonCode, ?string &$reason): ZugferdDocumentReader
    {
        $tradeLineItem = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getIncludedSupplyChainTradeLineItem", []);
        $tradeLineItem = $tradeLineItem[$this->positionPointer];

        $allowanceCharge = $this->objectHelper->EnsureArray($this->getInvoiceValueByPathFrom($tradeLineItem, "getSpecifiedLineTradeSettlement.getSpecifiedTradeAllowanceCharge", []));
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
     * Get Line summation for item level
     *
     * @param float|null $lineTotalAmount
     * @param float|null $totalAllowanceChargeAmount
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

    //TODO: Seeker for documents position TradeAccountingAccount

    /**
     * Function to return a value from $invoiceObject by path
     *
     * @codeCoverageIgnore
     *
     * @param string $methods
     * @param mixed $defaultValue
     * @return mixed
     */
    private function getInvoiceValueByPath(string $methods, $defaultValue)
    {
        return $this->getInvoiceValueByPathFrom($this->invoiceObject, $methods, $defaultValue);
    }

    /**
     * Function to return a value from $from by path
     *
     * @codeCoverageIgnore
     *
     * @param object $from
     * @param string $methods
     * @param mixed $defaultValue
     * @return mixed
     */
    private function getInvoiceValueByPathFrom(object $from, string $methods, $defaultValue)
    {
        return $this->objectHelper->TryCallByPathAndReturn($from, $methods) ?? $defaultValue;
    }

    /**
     * Convert to array
     *
     * @codeCoverageIgnore
     *
     * @param mixed $value
     * @param array $methods
     * @return array
     */
    private function convertToArray($value, array $methods)
    {
        $result = [];
        $isFlat = count($methods) == 1;
        $value = $this->objectHelper->EnsureArray($value);

        foreach ($value as $valueKey => $valueItem) {
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
                    $itemValue = $this->objectHelper->TryCallByPathAndReturn($valueItem, $method) ?? $defaultValue;
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
     * @param mixed $value
     * @param string $methodKey
     * @param string $methodValue
     * @return array
     */
    private function convertToAssociativeArray($value, string $methodKey, string $methodValue)
    {
        $result = [];
        $value = $this->objectHelper->EnsureArray($value);

        foreach ($value as $valueKey => $valueItem) {
            $theValueForKey = $this->objectHelper->TryCallByPathAndReturn($valueItem, $methodKey);
            $theValueForValue = $this->objectHelper->TryCallByPathAndReturn($valueItem, $methodValue);

            if (!ZugferdObjectHelper::IsNullOrEmpty($theValueForKey) && !ZugferdObjectHelper::IsNullOrEmpty($theValueForValue)) {
                $result[$theValueForKey] = $theValueForValue;
            }
        }

        return $result;
    }
}
