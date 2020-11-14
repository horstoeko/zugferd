<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\quick;

use DateTime;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;
use horstoeko\zugferd\ZugferdProfiles;

/**
 * Class representing the document descriptor for outgoing documents.
 * Creating them in a simple and common way in EN16931 profile
 * This class is slightly inspired by the invoicedescriptor of the
 * https://github.com/stephanstapel/ZUGFeRD-csharp project
 * This class contains only basic functionality
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdQuickDescriptor extends ZugferdDocumentBuilder
{
    private const VT_TAXCATEGORY = 0;
    private const VT_TAXTYPE = 1;
    private const VT_TAXPERCENT = 2;
    private const VT_LINETOTALBASISAMOUNT = 3;
    private const VT_ALLOWANCEAMOUNT = 4;
    private const VT_CHARGEAMOUNT = 5;
    private const VT_ALLOWANCECHARGEAMOUNT = 6;
    private const VT_BASISAMOUNT = 7;
    private const VT_CALCULATEDAMOUNT = 8;
    private const VT_LOGSERVICECHARGE = 9;

    /**
     * Used for internal vat summation
     *
     * @var array
     */
    protected $vatBreakdown = [];

    /**
     * Internal storage for the prepaid amount. Will be used
     * in summation calculation
     *
     * @var float
     */
    protected $totalPrepaidAmount = 0.0;

    /**
     * Returns the profile of the descriptor
     *
     * @return integer
     */
    protected static function getProfile(): int
    {
        return ZugferdProfiles::PROFILE_EN16931;
    }

    /**
     * Creates a new ZugferdDocumentBuilder with profile EN16931
     *
     * @codeCoverageIgnore
     *
     * @return ZugferdQuickDescriptor
     */
    public static function doCreateNew(): ZugferdQuickDescriptor
    {
        return (new static(static::getProfile()));
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    protected function onBeforeGetContent()
    {
        $this->doCalcTotals();
    }

    /**
     * Create a new invoice
     *
     * @param string $invoiceNo
     * The document no issued by the seller
     * @param \DateTime $invoiceDate
     * The date when the document was issued by the seller
     * @param string $currency
     * The code for the invoice currency
     * @param string@null $invoiceNoAsReference
     * Intended use for payment. If null the number of the invoice is used
     * @return ZugferdQuickDescriptor
     */
    public function doCreateInvoice(string $invoiceNo, \DateTime $invoiceDate, string $currency, ?string $invoiceNoReferenceq = null): ZugferdQuickDescriptor
    {
        $this->setDocumentInformation($invoiceNo, ZugferdInvoiceType::INVOICE, $invoiceDate, $currency);
        $this->setDocumentGeneralPaymentInformation(null, $invoiceNoReferenceq ?? $invoiceNo);
        return $this;
    }

    /**
     * Create a new credit memo
     *
     * @param string $creditMemoNo
     * The document no issued by the seller
     * @param \DateTime $invoiceDate
     * The date when the document was issued by the seller
     * @param string $currency
     * The code for the invoice currency
     * @param string|null $invoiceNoAsReference
     * Intended use for refund. If null the number of the credit memo is used
     * @return ZugferdQuickDescriptor
     */
    public function doCreateCreditMemo(string $creditMemoNo, \DateTime $invoiceDate, string $currency, string $creditMemoNoReference = ""): ZugferdQuickDescriptor
    {
        $this->setDocumentInformation($creditMemoNo, ZugferdInvoiceType::CREDITNOTE, $invoiceDate, $currency);
        $this->setDocumentGeneralPaymentInformation(null, $creditMemoNoReference ?? $creditMemoNo);
        return $this;
    }

    /**
     * Add a payment term
     *
     * @param string $description
     * A text description of the payment terms that apply to the payment amount due (including a
     * description of possible penalties). Note: This element can contain multiple lines and
     * multiple conditions.
     * @param DateTime|null $dueDate
     * The date by which payment is due Note: The payment due date reflects the net payment due
     * date. In the case of partial payments, this indicates the first due date of a net payment.
     * The corresponding description of more complex payment terms can be given in BT-20.
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentTerms(string $description, ?DateTime $dueDate = null): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentTerm($description, $dueDate);
        return $this;
    }

    /**
     * Set payment means to "direct debit"
     *
     * If $isSEPA is true code __31__ wil be useed for payment means code.
     * If $isSEPA is false code __59__ wil be useed for payment means code.
     *
     * @param boolean $isSEPA
     * Is it a SEPA transaction or not
     * @param string $buyerIban
     * Direct debit: ID of the account to be debited
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentMeansForDebitTransfer(bool $isSEPA, string $buyerIban): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentMean($isSEPA === false ? ZugferdPaymentMeans::UNTDID_4461_31 : ZugferdPaymentMeans::UNTDID_4461_59, null, null, null, null, $buyerIban, null, null, null, null);
        return $this;
    }

    /**
     * Set payment means to "debit transfer"
     *
     * If $isSEPA is true code __58__ wil be useed for payment means code.
     * If $isSEPA is false code __30__ wil be useed for payment means code.
     *
     * @param boolean $isSEPA
     * Is it a SEPA transaction or not
     * @param string $payeeIban
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
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentMeansForCreditTransfer(bool $isSEPA, string $payeeIban, ?string $payeeAccountName = null, ?string $payeePropId = null, ?string $payeeBic = null): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentMean($isSEPA === false ? ZugferdPaymentMeans::UNTDID_4461_30 : ZugferdPaymentMeans::UNTDID_4461_58, null, null, null, null, null, $payeeIban, $payeeAccountName, $payeePropId, $payeeBic);
        return $this;
    }

    /**
     * Set payment means to "Bank Card"
     *
     * @param string $cardType
     * The type of the card
     * @param string $cardId
     * The primary account number (PAN) to which the card used for payment belongs. In accordance with card
     * payment security standards, an invoice should never contain a full payment card master account number.
     * The following specification of the PCI Security Standards Council currently applies: The first 6 and
     * last 4 digits at most are to be displayed
     * @param string $cardHolderName
     * Name of the payment card holder
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentMeansForBankCard(string $cardType, string $cardId, string $cardHolderName): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_48, null, $cardType, $cardId, $cardHolderName, null, null, null, null, null);
        return $this;
    }

    /**
     * Set payment means to "Credit Card"
     *
     * @param string $cardType
     * The type of the card
     * @param string $cardId
     * The primary account number (PAN) to which the card used for payment belongs. In accordance with card
     * payment security standards, an invoice should never contain a full payment card master account number.
     * The following specification of the PCI Security Standards Council currently applies: The first 6 and
     * last 4 digits at most are to be displayed
     * @param string $cardHolderName
     * Name of the payment card holder
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentMeansForCreditCard(string $cardType, string $cardId, string $cardHolderName): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_54, null, $cardType, $cardId, $cardHolderName, null, null, null, null, null);
        return $this;
    }

    /**
     * Set payment means to "Debit Card"
     *
     * @param string $cardType
     * The type of the card
     * @param string $cardId
     * The primary account number (PAN) to which the card used for payment belongs. In accordance with card
     * payment security standards, an invoice should never contain a full payment card master account number.
     * The following specification of the PCI Security Standards Council currently applies: The first 6 and
     * last 4 digits at most are to be displayed
     * @param string $cardHolderName
     * Name of the payment card holder
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentMeansForDebitCard(string $cardType, string $cardId, string $cardHolderName): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentMean(ZugferdPaymentMeans::UNTDID_4461_55, null, $cardType, $cardId, $cardHolderName, null, null, null, null, null);
        return $this;
    }

    /**
     * Add note to the document
     *
     * @param string $note
     * Free text on the invoice
     * @param string|null $subjectCode
     * Code to qualify the free text for the invoice
     * @param string|null $contentCode
     * Free text at document level
     * @return ZugferdQuickDescriptor
     */
    public function doAddNote(string $note, ?string $subjectCode = null, ?string $contentCode = null): ZugferdQuickDescriptor
    {
        $this->addDocumentNote($note, $contentCode, $subjectCode);
        return $this;
    }

    /**
     * Set details of the related buyer order
     *
     * @param string $orderNo
     * An identifier issued by the buyer for a referenced order (order number)
     * @param DateTime $orderDate
     * Date of order
     * @return ZugferdQuickDescriptor
     */
    public function doSetBuyerOrderReferenceDocument(string $orderNo, DateTime $orderDate): ZugferdQuickDescriptor
    {
        $this->setDocumentBuyerOrderReferencedDocument($orderNo, $orderDate);
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
     * @param string $issuerAssignedID
     * The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for
     * an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param DateTime|null $issueDateTime
     * Document date
     * @param string|null $typeCode
     * Type of referenced document (See codelist UNTDID 1001)
     *  - Code 916 "reference paper" is used to reference the identification of the document on which the invoice is based
     *  - Code 50 "Price / sales catalog response" is used to reference the tender or the lot
     *  - Code 130 "invoice data sheet" is used to reference an identifier for an object specified by the seller.
     * @param string|null $name
     * A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param string|null $referenceTypeCode
     * The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the
     * recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected
     * from UNTDID 1153 in accordance with the code list entries.
     * @param string|null $filename
     * Contains a file name of an attachment document embedded as a binary object
     * @return ZugferdQuickDescriptor
     */
    public function doAddAdditionalReferencedDocument(string $issuerAssignedID, ?DateTime $issueDateTime = null, ?string $typeCode = null, ?string $name = null, ?string $referenceTypeCode = null, ?string $filename = null): ZugferdQuickDescriptor
    {
        $this->addDocumentAdditionalReferencedDocument($issuerAssignedID, $typeCode, null, $name, $referenceTypeCode, $issueDateTime, $filename);
        return $this;
    }

    /**
     * Set detailed information on the associated delivery note
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param string $deliveryNoteNo
     * Delivery receipt number
     * @param DateTime $deliveryNoteDate
     * Delivery receipt date
     * @return ZugferdQuickDescriptor
     */
    public function doSetDeliveryNoteReferenceDocument(string $deliveryNoteNo, DateTime $deliveryNoteDate): ZugferdQuickDescriptor
    {
        $this->setDocumentDeliveryNoteReferencedDocument($deliveryNoteNo, $deliveryNoteDate);
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
     * @param string $id
     * Number of the previous invoice
     * @param DateTime|null $issueDateTime
     * Date of the previous invoice
     * @return ZugferdQuickDescriptor
     */
    public function doSetInvoiceReferencedDocument(string $id, ?DateTime $issueDateTime = null): ZugferdQuickDescriptor
    {
        $this->setDocumentInvoiceReferencedDocument($id, $issueDateTime);
        return $this;
    }

    /**
     * Set Details of a project reference
     *
     * @param string $id
     * Project Data
     * @param string $name
     * Project Name
     * @return ZugferdQuickDescriptor
     */
    public function doSetSpecifiedProcuringProject(string $id, string $name): ZugferdQuickDescriptor
    {
        $this->setDocumentProcuringProject($id, $name);
        return $this;
    }

    /**
     * Detailed information about the buyer (service recipient)
     *
     * @param string $name
     * The full name of the buyer
     * @param string $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string $city
     * Usual name of the city or municipality in which the buyers address is located
     * @param string $street
     * The main line in the buyers address. This is usually the street name and house number or
     * the post office box
     * @param string $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string $buyerReference
     * An identifier assigned by the buyer and used for internal routing
     * @param string $id
     * An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be
     * assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given,
     * it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param string|null $globalID
     * The buyers's identifier identification scheme is an identifier uniquely assigned to a buyer by a
     * global registration organization.
     * @param string|null $globalIDscheme
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdQuickDescriptor
     */
    public function doSetBuyer(string $name, string $postcode, string $city, string $street, string $country, ?string $buyerReference = null, ?string $id = null, ?string $globalID = null, ?string $globalIDscheme = null): ZugferdQuickDescriptor
    {
        $this->setDocumentBuyer($name, $id);
        $this->setDocumentBuyerAddress($street, null, null, $postcode, $city, $country, null);
        $this->addDocumentBuyerGlobalId($globalID, $globalIDscheme);
        if ($buyerReference != null) {
            $this->setDocumentBuyerReference($buyerReference);
        }
        return $this;
    }

    /**
     * Set contact of the buyer party
     *
     * @param string $name
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $orgunit
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $emailAddress
     * Detailed information on the buyer's phone number
     * @param string|null $phoneno
     * Detailed information on the buyer's phone number
     * @param string|null $faxno
     * Detailed information on the buyer's fax number
     * @return ZugferdQuickDescriptor
     */
    public function doSetBuyerContact(string $name, ?string $orgunit = null, ?string $emailAddress = null, ?string $phoneno = null, ?string $faxno = null): ZugferdQuickDescriptor
    {
        $this->setDocumentBuyerContact($name, $orgunit, $phoneno, $faxno, $emailAddress);
        return $this;
    }

    /**
     * Add detailed information on the buyers's tax information
     *
     * The local identification (defined by the buyer's address) of the buyer for tax purposes or a reference that enables the buyer
     * to indicate his reporting status for tax purposes The sales tax identification number of the buyer
     * Note: This information may affect how the buyer the invoice settled (such as in relation to social security contributions). So
     * e.g. In some countries, if the buyer is not reported for tax, the buyer will withhold the tax amount and pay it on behalf of the
     * buyer. Sales tax number with a prefixed country code. A supplier registered as subject to VAT must provide his sales tax
     * identification number, unless he uses a tax agent.
     *
     * @param string $no
     * Tax number of the buyers
     * @param string $schemeID
     * Tax number of the buyers or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdQuickDescriptor
     */
    public function doAddBuyerTaxRegistration(string $no, string $schemeID): ZugferdQuickDescriptor
    {
        $this->addDocumentBuyerTaxRegistration($no, $schemeID);
        return $this;
    }

    /**
     * Detailed information about the seller (=service provider)
     *
     * @param string $name
     * The full formal name under which the seller is registered in the
     * National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param string $postcode
     * Identifier for a group of properties, such as a zip code
     * @param string $city
     * Usual name of the city or municipality in which the seller's address is located
     * @param string $street
     * The main line in the sellers address. This is usually the street name and house number or
     * the post office box
     * @param string $country
     * Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax
     * is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the
     * representation of names of countries and their subdivisions”
     * @param string|null $id
     * An identifier of the seller. In many systems, seller identification
     * is key information. Multiple seller IDs can be assigned or specified. They can be differentiated
     * by using different identification schemes. If no scheme is given, it should be known to the buyer
     * and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param string|null $globalID
     * The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a
     * global registration organization.
     * @param string|null $globalIDscheme
     * If the identifier is used for the identification scheme, it must be selected from the entries in
     * the list published by the ISO / IEC 6523 Maintenance Agency.
     * @return ZugferdQuickDescriptor
     */
    public function doSetSeller(string $name, string $postcode, string $city, string $street, string $country, ?string $id = null, ?string $globalID = null, ?string $globalIDscheme = null): ZugferdQuickDescriptor
    {
        $this->setDocumentSeller($name, $id);
        $this->setDocumentSellerAddress($street, null, null, $postcode, $city, $country, null);
        $this->addDocumentSellerGlobalId($globalID, $globalIDscheme);
        return $this;
    }

    /**
     * Set contact of the seller party
     *
     * @param string $name
     * Contact point for a legal entity, such as a personal name of the contact person
     * @param string|null $orgunit
     * Contact point for a legal entity, such as a name of the department or office
     * @param string|null $emailAddress
     * Detailed information on the seller's phone number
     * @param string|null $phoneno
     * Detailed information on the seller's phone number
     * @param string|null $faxno
     * Detailed information on the seller's fax number
     * @return ZugferdQuickDescriptor
     */
    public function doSetSellerContact(string $name, ?string $orgunit = null, ?string $emailAddress = null, ?string $phoneno = null, ?string $faxno = null): ZugferdQuickDescriptor
    {
        $this->setDocumentSellerContact($name, $orgunit, $phoneno, $faxno, $emailAddress);
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
     * @param string $no
     * Tax number of the seller
     * @param string $schemeID
     * Tax number of the seller or sales tax identification number of the (FC = Tax number, VA = Sales tax number)
     * @return ZugferdQuickDescriptor
     */
    public function doAddSellerTaxRegistration(string $no, string $schemeID): ZugferdQuickDescriptor
    {
        $this->addDocumentSellerTaxRegistration($no, $schemeID);
        return $this;
    }

    /**
     * Add a new text position
     *
     * @param string $lineId
     * A unique identifier for the relevant item within the invoice (item number)
     * @param string $comment
     * A free text that contains unstructured information that is relevant to the invoice item
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeLineCommentItem(string $lineId, string $comment): ZugferdQuickDescriptor
    {
        $this->addNewTextPosition($lineId);
        $this->setDocumentPositionNote($comment);
        return $this;
    }

    /**
     * Adds a new position (line) to document
     *
     * @param string $lineId
     * A unique identifier for the relevant item within the invoice (item number)
     * @param string $productName
     * A name of the item (item name)
     * @param float $unitPrice
     * Net price of the item
     * @param float $quantity
     * The quantity of individual items (goods or services) billed in the relevant line
     * @param string $unitCode
     * The unit of measure applicable to the amount billed. Note: The unit of measurement must be taken from the
     * lists from UN / ECE Recommendation No. 20 "Codes for Units of Measure Used in International Trade" and
     * UN / ECE Recommendation No. 21 "Codes for Passengers, Types of Cargo, Packages and Packaging Materials
     * (with Complementary Codes for Package Names)" using the UN / ECE Rec No. 20 Intro 2.a) can be selected.
     * It should be noted that in most cases it is not necessary for buyers and sellers to fully implement these
     * lists in their software. Sellers only need to support the entities necessary for their goods and services;
     * Buyers only need to verify that the units used in the invoice match those in other documents (such as in
     * Contracts, catalogs, orders and shipping notifications) match the units used.
     * @param float $allowanceChargeAmount
     * The surcharge/discount amount excluding sales tax. If negative then its an allowance, if positive then
     * it's a charge
     * @param string $allowanceChargeReason
     * The reason given in text form for the invoice item discount/surcharge
     * @param string $taxCategoryCode
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
     * @param string $taxTypeCode
     * In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be
     * specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for
     * the tax type must then be taken from the code list UNTDID 5153.
     * @param float $taxPercent
     * The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales
     * tax category and the category-specific sales tax rate  must correspond to one another. The value to be
     * given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeLineItem(string $lineId, string $productName, float $unitPrice, float $quantity, string $unitCode, float $allowanceChargeAmount, string $allowanceChargeReason, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        $hasChargeAmountIsAllowance = $allowanceChargeAmount != 0.0;
        $allowanceChargeAmountIsAllowance = $allowanceChargeAmount < 0.0;
        $allowanceAmount = $allowanceChargeAmountIsAllowance === true ? abs($allowanceChargeAmount) : 0.0;
        $chargeAmount = $allowanceChargeAmountIsAllowance === false ? abs($allowanceChargeAmount) : 0.0;
        $allowanceChargeAmount = abs($allowanceChargeAmount);
        $lineTotalAmount = $unitPrice * $quantity + $chargeAmount - $allowanceAmount;

        $this->addNewPosition($lineId);
        $this->setDocumentPositionProductDetails($productName);
        $this->setDocumentPositionNetPrice($unitPrice);
        $this->setDocumentPositionQuantity($quantity, $unitCode);
        $this->addDocumentPositionTax($taxCategoryCode, $taxTypeCode, $taxPercent);
        $this->setDocumentPositionLineSummation($lineTotalAmount);

        if ($hasChargeAmountIsAllowance == true) {
            $this->addDocumentPositionAllowanceCharge($allowanceChargeAmount, $allowanceChargeAmountIsAllowance === false, null, null, null, $allowanceChargeReason);
        }

        $this->addToInternalVatBuffer(
            $taxCategoryCode,
            $taxTypeCode,
            $taxPercent,
            $lineTotalAmount,
            0.0,
            0.0,
            0.0
        );

        return $this;
    }

    /**
     * Adds a new position (line) to document with a surcharge amount
     *
     * @param string $lineId
     * A unique identifier for the relevant item within the invoice (item number)
     * @param string $productName
     * A name of the item (item name)
     * @param float $unitPrice
     * Net price of the item
     * @param float $chargeTotalAmount
     * The surcharge amount excluding sales tax
     * @param string $chargeReason
     * The reason given in text form for the invoice item discount/surcharge
     *
     * @param float $quantity
     * The quantity of individual items (goods or services) billed in the relevant line
     * @param string $unitCode
     * The unit of measure applicable to the amount billed. Note: The unit of measurement must be taken from the
     * lists from UN / ECE Recommendation No. 20 "Codes for Units of Measure Used in International Trade" and
     * UN / ECE Recommendation No. 21 "Codes for Passengers, Types of Cargo, Packages and Packaging Materials
     * (with Complementary Codes for Package Names)" using the UN / ECE Rec No. 20 Intro 2.a) can be selected.
     * It should be noted that in most cases it is not necessary for buyers and sellers to fully implement these
     * lists in their software. Sellers only need to support the entities necessary for their goods and services;
     * Buyers only need to verify that the units used in the invoice match those in other documents (such as in
     * Contracts, catalogs, orders and shipping notifications) match the units used.
     * @param string $taxCategoryCode
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
     * @param string $taxTypeCode
     * In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be
     * specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for
     * the tax type must then be taken from the code list UNTDID 5153.
     * @param float $taxPercent
     * The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales
     * tax category and the category-specific sales tax rate  must correspond to one another. The value to be
     * given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeLineItemWithSurcharge(string $lineId, string $productName, float $unitPrice, float $chargeAmount, string $chargeReason, float $quantity, string $unitCode, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        $this->doAddTradeLineItem($lineId, $productName, $unitPrice, $quantity, $unitCode, abs($chargeAmount), $chargeReason, $taxCategoryCode, $taxTypeCode, $taxPercent);
        return $this;
    }

    /**
     * Adds a new position (line) to document with a surcharge amount
     *
     * @param string $lineId
     * A unique identifier for the relevant item within the invoice (item number)
     * @param string $productName
     * A name of the item (item name)
     * @param float $unitPrice
     * Net price of the item
     * @param float $discountAmount
     * The discount amount excluding sales tax
     * @param string $discountReason
     * The reason given in text form for the invoice item discount/surcharge
     * @param float $quantity
     * The quantity of individual items (goods or services) billed in the relevant line
     * @param string $unitCode
     * The unit of measure applicable to the amount billed. Note: The unit of measurement must be taken from the
     * lists from UN / ECE Recommendation No. 20 "Codes for Units of Measure Used in International Trade" and
     * UN / ECE Recommendation No. 21 "Codes for Passengers, Types of Cargo, Packages and Packaging Materials
     * (with Complementary Codes for Package Names)" using the UN / ECE Rec No. 20 Intro 2.a) can be selected.
     * It should be noted that in most cases it is not necessary for buyers and sellers to fully implement these
     * lists in their software. Sellers only need to support the entities necessary for their goods and services;
     * Buyers only need to verify that the units used in the invoice match those in other documents (such as in
     * Contracts, catalogs, orders and shipping notifications) match the units used.
     * @param string $taxCategoryCode
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
     * @param string $taxTypeCode
     * In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be
     * specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for
     * the tax type must then be taken from the code list UNTDID 5153.
     * @param float $taxPercent
     * The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales
     * tax category and the category-specific sales tax rate  must correspond to one another. The value to be
     * given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeLineItemWithDiscount(string $lineId, string $productName, float $unitPrice, float $discountAmount, string $discountReason, float $quantity, string $unitCode, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        $this->doAddTradeLineItem($lineId, $productName, $unitPrice, $quantity, $unitCode, -abs($discountAmount), $discountReason, $taxCategoryCode, $taxTypeCode, $taxPercent);
        return $this;
    }

    /**
     * Add a logistical service fees (On document level)
     *
     * __Notes__
     *  - This is only available in the EXTENDED profile
     *
     * @param float $amount
     * Amount of the service fee
     * @param string $description
     * Identification of the service fee
     * @param string $taxTypeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param string $taxCategoryCode
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
     * @param float $taxPercent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddLogisticsServiceCharge(float $amount, string $description, string $taxTypeCode, string $taxCategoryCode, float $taxPercent): ZugferdQuickDescriptor
    {
        $this->addDocumentLogisticsServiceCharge($description, $amount, [$taxTypeCode], [$taxCategoryCode], [$taxPercent]);

        $this->addToInternalVatBuffer(
            $taxCategoryCode,
            $taxTypeCode,
            $taxPercent,
            0.0,
            0.0,
            0.0,
            $amount
        );

        return $this;
    }

    /**
     * Add information about surcharges and charges applicable to the bill as a whole, Deductions,
     * such as for withheld taxes may also be specified in this group
     *
     * @param float $actualAmount
     * Amount of the surcharge or discount at document level
     * @param string $reason
     * @param string $taxCategoryCode
     * @param string $taxTypeCode
     * @param float $taxPercent
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeAllowanceCharge(float $actualAmount, string $reason, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        if ($actualAmount == 0.0) {
            return $this;
        }

        $allowanceChargeAmountIsAllowance = $actualAmount < 0.0;
        $allowanceAmount = $allowanceChargeAmountIsAllowance === true ? abs($actualAmount) : 0.0;
        $chargeAmount = $allowanceChargeAmountIsAllowance === false ? abs($actualAmount) : 0.0;

        $this->addDocumentAllowanceCharge(abs($actualAmount), $allowanceChargeAmountIsAllowance == false, $taxCategoryCode, $taxTypeCode, $taxPercent, null, null, null, null, null, null, $reason);

        $this->addToInternalVatBuffer(
            $taxCategoryCode,
            $taxTypeCode,
            $taxPercent,
            0.0,
            $chargeAmount,
            $allowanceAmount,
            0.0
        );

        return $this;
    }

    /**
     * Add a VAT breakdown (at document level)
     *
     * @param float $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param float $percent
     * The sales tax rate, expressed as the percentage applicable to the sales tax category in
     * question. Note: The code of the sales tax category and the category-specific sales tax rate
     * must correspond to one another. The value to be given is the percentage. For example, the
     * value 20 is given for 20% (and not 0.2)
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
     * @param string|null $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param float|null $allowanceChargeBasisAmount
     * Total amount of surcharges and deductions of the tax rate at document level
     * @param string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @param string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @return ZugferdQuickDescriptor
     */
    public function doAddApplicableTradeTax(float $basisAmount, float $percent, string $categoryCode, ?string $typeCode = null, ?float $allowanceChargeBasisAmount = null, ?string $exemptionReasonCode = null, ?string $exemptionReason = null): ZugferdQuickDescriptor
    {
        $this->addDocumentTax($categoryCode, $typeCode ?? "VAT", $basisAmount, round(0.01 * $percent * $basisAmount, 2), $percent, $exemptionReason, $exemptionReasonCode);
        return $this;
    }

    /**
     * Add a VAT breakdown (at document level)
     *
     * @param float $basisAmount
     * Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param float $calculatedAmount
     * The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying
     * the amount to be taxed according to the sales tax category by the sales tax rate applicable
     * for the sales tax category concerned
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
     * @param string|null $typeCode
     * Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param float|null $allowanceChargeBasisAmount
     * Total amount of surcharges and deductions of the tax rate at document level
     * @param string|null $exemptionReasonCode
     * Reason given in code form for the exemption of the amount from VAT. Note: Code list issued
     * and maintained by the Connecting Europe Facility.
     * @param string|null $exemptionReason
     * Reason for tax exemption (free text)
     * @return ZugferdQuickDescriptor
     */
    public function doAddApplicableTradeTax2(float $basisAmount, float $calculatedAmount, string $categoryCode, ?string $typeCode = null, ?float $allowanceChargeBasisAmount = null, ?string $exemptionReasonCode = null, ?string $exemptionReason = null): ZugferdQuickDescriptor
    {
        $this->addDocumentTax($categoryCode, $typeCode ?? "VAT", $basisAmount, $calculatedAmount, round($calculatedAmount * 100.0 / $basisAmount, 2), $exemptionReason, $exemptionReasonCode);
        return $this;
    }

    /**
     * Sets the prepaid amount
     *
     * @param float $totalPrepaidAmount
     * @return ZugferdQuickDescriptor
     */
    public function doSetPrepaidAmount(float $totalPrepaidAmount = 0.0): ZugferdQuickDescriptor
    {
        $this->totalPrepaidAmount = $totalPrepaidAmount;
        return $this;
    }

    /**
     * Writes the vat breakdowns and the summation of the document
     *
     * @return ZugferdQuickDescriptor
     */
    protected function doCalcTotals(): ZugferdQuickDescriptor
    {
        $this->writeVatBreakDown();
        $this->setDocumentSummation(
            $this->summarizeVatTableElement(self::VT_BASISAMOUNT) + $this->summarizeVatTableElement(self::VT_CALCULATEDAMOUNT),
            $this->summarizeVatTableElement(self::VT_BASISAMOUNT) + $this->summarizeVatTableElement(self::VT_CALCULATEDAMOUNT) - $this->totalPrepaidAmount,
            $this->summarizeVatTableElement(self::VT_LINETOTALBASISAMOUNT),
            $this->summarizeVatTableElement(self::VT_CHARGEAMOUNT) + $this->summarizeVatTableElement(self::VT_LOGSERVICECHARGE),
            $this->summarizeVatTableElement(self::VT_ALLOWANCEAMOUNT),
            $this->summarizeVatTableElement(self::VT_BASISAMOUNT),
            $this->summarizeVatTableElement(self::VT_CALCULATEDAMOUNT),
            0.0,
            $this->totalPrepaidAmount
        );
        return $this;
    }

    /**
     * Insert into internal vat table for later using, e.g. when creating
     * the vat breakdown
     *
     * @param string $taxCategoryCode
     * @param string $taxTypeCode
     * @param float $taxPercent
     * @param float $lineTotalAmount
     * @param float $chargeAmount
     * @param float $allowanceAmount
     * @return void
     */
    protected function addToInternalVatBuffer(string $taxCategoryCode, string $taxTypeCode, float $taxPercent, float $lineTotalAmount, float $chargeAmount, float $allowanceAmount, float $logisticServiceCharge)
    {
        $vatGroup = md5($taxCategoryCode . "_" . $taxTypeCode . "_" . number_format($taxPercent, 10, '_', '__'));

        if (!isset($this->vatBreakdown[$vatGroup])) {
            $this->vatBreakdown[$vatGroup] = [
                self::VT_TAXCATEGORY => $taxCategoryCode,
                self::VT_TAXTYPE => $taxTypeCode,
                self::VT_TAXPERCENT => $taxPercent,
                self::VT_LINETOTALBASISAMOUNT => 0.0,
                self::VT_ALLOWANCEAMOUNT => 0.0,
                self::VT_CHARGEAMOUNT => 0.0,
                self::VT_ALLOWANCECHARGEAMOUNT => 0.0,
                self::VT_CALCULATEDAMOUNT => 0.0,
                self::VT_LOGSERVICECHARGE => 0.0
            ];
        }

        $this->vatBreakdown[$vatGroup][self::VT_LINETOTALBASISAMOUNT] += $lineTotalAmount;
        $this->vatBreakdown[$vatGroup][self::VT_ALLOWANCEAMOUNT] += $allowanceAmount;
        $this->vatBreakdown[$vatGroup][self::VT_CHARGEAMOUNT] += $chargeAmount;
        $this->vatBreakdown[$vatGroup][self::VT_LOGSERVICECHARGE] += $logisticServiceCharge;
        $this->vatBreakdown[$vatGroup][self::VT_ALLOWANCECHARGEAMOUNT] =
            $this->vatBreakdown[$vatGroup][self::VT_CHARGEAMOUNT] -
            $this->vatBreakdown[$vatGroup][self::VT_ALLOWANCEAMOUNT] +
            $this->vatBreakdown[$vatGroup][self::VT_LOGSERVICECHARGE];
        $this->vatBreakdown[$vatGroup][self::VT_BASISAMOUNT] =
            $this->vatBreakdown[$vatGroup][self::VT_LINETOTALBASISAMOUNT] +
            $this->vatBreakdown[$vatGroup][self::VT_ALLOWANCECHARGEAMOUNT];
        $this->vatBreakdown[$vatGroup][self::VT_CALCULATEDAMOUNT] =
            round(
                $this->vatBreakdown[$vatGroup][self::VT_BASISAMOUNT] *
                $this->vatBreakdown[$vatGroup][self::VT_TAXPERCENT] / 100.0, 2);
    }

    /**
     * Writes the document vat breakdown from the internal vat buffer
     *
     * @return void
     */
    protected function writeVatBreakDown(): void
    {
        foreach ($this->vatBreakdown as $item) {
            $this->addDocumentTax(
                $item[self::VT_TAXCATEGORY],
                $item[self::VT_TAXTYPE],
                $item[self::VT_BASISAMOUNT],
                $item[self::VT_CALCULATEDAMOUNT],
                $item[self::VT_TAXPERCENT],
                null,
                null,
                $item[self::VT_LINETOTALBASISAMOUNT],
                $item[self::VT_ALLOWANCECHARGEAMOUNT]
            );
        }
    }

    /**
     * Summarizes an array element in the internal vat table
     *
     * @param integer $index
     * @return float
     */
    protected function summarizeVatTableElement(int $index): float
    {
        $sum = 0.0;

        foreach ($this->vatBreakdown as $item) {
            $sum += $item[$index];
        }

        return $sum;
    }
}
