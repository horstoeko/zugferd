<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\quick;

use DateTime;
use horstoeko\stringmanagement\StringUtils;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdPaymentMeans;
use horstoeko\zugferd\ZugferdProfiles;

/**
 * Class representing the base class of all document descriptors.
 *
 * Creating them in a simple and common way in EN16931 profile
 * This class is slightly inspired by the invoicedescriptor of the
 * __https://github.com/stephanstapel/ZUGFeRD-csharp__ project
 *
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
     * Internal flag to see if the totals are alread calculated
     *
     * @var boolean
     */
    protected $totalsAreCalculated = false;

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
     * @return ZugferdQuickDescriptor
     */
    public static function doCreateNew(): ZugferdQuickDescriptor
    {
        return static::createNew(static::getProfile());
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
     * @param  string      $invoiceNo          __BT-1, From MINIMUM__ The document no issued by the seller
     * @param  \DateTime   $invoiceDate        __BT-2, From MINIMUM__ Date of invoice. The date when the document was issued by the seller
     * @param  string      $currency           __BT-5, From MINIMUM__ Code for the invoice currency
     * @param  string|null $invoiceNoReference __BT-83, From BASIC WL__ Intended use for payment
     * @return ZugferdQuickDescriptor
     */
    public function doCreateInvoice(string $invoiceNo, \DateTime $invoiceDate, string $currency, ?string $invoiceNoReference = null): ZugferdQuickDescriptor
    {
        $this->setDocumentInformation($invoiceNo, ZugferdInvoiceType::INVOICE, $invoiceDate, $currency);
        $this->setDocumentGeneralPaymentInformation(null, $invoiceNoReference ?? $invoiceNo);
        return $this;
    }

    /**
     * Create a new credit memo
     *
     * @param  string    $creditMemoNo          __BT-1, From MINIMUM__ The document no issued by the seller
     * @param  \DateTime $invoiceDate           __BT-2, From MINIMUM__ Date of invoice. The date when the document was issued by the seller
     * @param  string    $currency              __BT-5, From MINIMUM__ Code for the invoice currency
     * @param  string    $creditMemoNoReference __BT-83, From BASIC WL__ Intended use for refund. If null the number of the credit memo is used
     * @return ZugferdQuickDescriptor
     */
    public function doCreateCreditMemo(string $creditMemoNo, \DateTime $invoiceDate, string $currency, string $creditMemoNoReference = ""): ZugferdQuickDescriptor
    {
        $this->setDocumentInformation($creditMemoNo, ZugferdInvoiceType::CREDITNOTE, $invoiceDate, $currency);
        $this->setDocumentGeneralPaymentInformation(null, StringUtils::stringIsNullOrEmpty($creditMemoNoReference) ? $creditMemoNo : $creditMemoNoReference);
        return $this;
    }

    /**
     * Add a payment term
     *
     * @param  string|null   $description __BT-20, From _BASIC WL__ A text description of the payment terms that apply to the payment amount due (including a description of possible penalties). Note: This element can contain multiple lines and multiple conditions.
     * @param  DateTime|null $dueDate     __BT-9, From BASIC WL__ The date by which payment is due Note: The payment due date reflects the net payment due date. In the case of partial payments, this indicates the first due date of a net payment. The corresponding description of more complex payment terms can be given in BT-20.
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
     * @param  boolean $isSEPA    __BT-81, From BASIC WL__ The expected or used means of payment, expressed as a code. The entries from the UNTDID 4461 code list must be used. A distinction should be made between SEPA and non-SEPA payments as well as between credit payments, direct debits, card payments and other means of payment In particular, the following codes can be used:
     * @param  string  $buyerIban __BT-91, From BASIC WL__ The account to be debited by the direct debit
     * @return ZugferdQuickDescriptor
     */
    public function doSetPaymentMeansForDebitTransfer(bool $isSEPA, string $buyerIban): ZugferdQuickDescriptor
    {
        $this->addDocumentPaymentMean($isSEPA === false ? ZugferdPaymentMeans::UNTDID_4461_31 : ZugferdPaymentMeans::UNTDID_4461_59, null, null, null, null, $buyerIban, null, null, null, null);
        return $this;
    }

    /**
     * Set payment means to "credit transfer"
     *
     * If $isSEPA is true code __58__ wil be useed for payment means code.
     * If $isSEPA is false code __30__ wil be useed for payment means code.
     *
     * @param  boolean     $isSEPA           __BT-81, From BASIC WL__ The expected or used means of payment, expressed as a code. The entries from the UNTDID 4461 code list must be used. A distinction should be made between SEPA and non-SEPA payments as well as between credit payments, direct debits, card payments and other means of payment In particular, the following codes can be used:
     * @param  string      $payeeIban        __BT-84, From BASIC WL__ A unique identifier for the financial account held with a payment service provider to which the payment should be made
     * @param  string|null $payeeAccountName __BT-85, From BASIC WL__ The name of the payment account held with a payment service provider to which the payment should be made
     * @param  string|null $payeePropId      __BT-BT-84-0, From BASIC WL__ National account number (not for SEPA)
     * @param  string|null $payeeBic         __BT-86, From EN 16931__ An identifier for the payment service provider with which the payment account is held
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
     * @param  string $cardType       __BT-, From __ The type of the card
     * @param  string $cardId         __BT-87, From EN 16931__ The primary account number (PAN) to which the card used for payment belongs. In accordance with card payment security standards, an invoice should never contain a full payment card master account number. The following specification of the PCI Security Standards Council currently applies: The first 6 and last 4 digits at most are to be displayed
     * @param  string $cardHolderName __BT-88, From EN 16931__ Name of the payment card holder
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
     * @param  string $cardType       __BT-, From __ The type of the card
     * @param  string $cardId         __BT-87, From EN 16931__ The primary account number (PAN) to which the card used for payment belongs. In accordance with card payment security standards, an invoice should never contain a full payment card master account number. The following specification of the PCI Security Standards Council currently applies: The first 6 and last 4 digits at most are to be displayed
     * @param  string $cardHolderName __BT-88, From EN 16931__ Name of the payment card holder
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
     * @param  string $cardType       __BT-, From __ The type of the card
     * @param  string $cardId         __BT-87, From EN 16931__ The primary account number (PAN) to which the card used for payment belongs. In accordance with card payment security standards, an invoice should never contain a full payment card master account number. The following specification of the PCI Security Standards Council currently applies: The first 6 and last 4 digits at most are to be displayed
     * @param  string $cardHolderName __BT-88, From EN 16931__ Name of the payment card holder
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
     * @param  string      $note        __BT-22, From BASIC WL__ A free text containing unstructured information that is relevant to the invoice as a whole
     * @param  string|null $subjectCode __BT-21, From BASIC WL__ The qualification of the free text for the invoice from BT-22
     * @param  string|null $contentCode __BT-X-5, From EXTENDED__ A code to classify the content of the free text of the invoice
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
     * @param  string   $orderNo   __BT-13, From MINIMUM__ An identifier issued by the buyer for a referenced order (order number)
     * @param  DateTime $orderDate __BT-X-147, From EXTENDED__ Date of order
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
     *
     * @param  string        $issuerAssignedID  __BT-122, From EN 16931__ The identifier of the tender or lot to which the invoice relates, or an identifier specified by the seller for an object on which the invoice is based, or an identifier of the document on which the invoice is based.
     * @param  DateTime|null $issueDateTime     __BT-X-149, From EXTENDED__ Document date
     * @param  string|null   $typeCode          __BT-122-0, From EN 16931__ Type of referenced document (See codelist UNTDID 1001)
     *                                          - Code 916 "reference paper" is used to reference the identification of the
     *                                          document on which the invoice is based - Code 50 "Price / sales catalog response"
     *                                          is used to reference the tender or the lot - Code 130 "invoice data sheet" is used
     *                                          to reference an identifier for an object specified by the seller.
     * @param  string|null   $name              __BT-123, From EN 16931__ A description of the document, e.g. Hourly billing, usage or consumption report, etc.
     * @param  string|null   $referenceTypeCode __BT-, From __ The identifier for the identification scheme of the identifier of the item invoiced. If it is not clear to the recipient which scheme is used for the identifier, an identifier of the scheme should be used, which must be selected from UNTDID 1153 in accordance with the code list entries.
     * @param  string|null   $filename          __BT-125, From EN 16931__ Contains a file name of an attachment document embedded as a binary object
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
     * @param  string   $deliveryNoteNo   __BT-X-202, From EXTENDED__ Delivery slip number
     * @param  DateTime $deliveryNoteDate __BT-X-203, From EXTENDED__ Delivery slip date
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
     * @param  string        $id            __BT-25, From BASIC WL__ The identification of an invoice previously sent by the seller
     * @param  DateTime|null $issueDateTime __BT-26, From BASIC WL__ Date of the previous invoice
     * @return ZugferdQuickDescriptor
     */
    public function doSetInvoiceReferencedDocument(string $id, ?DateTime $issueDateTime = null): ZugferdQuickDescriptor
    {
        $this->setDocumentInvoiceReferencedDocument($id, null, $issueDateTime);
        return $this;
    }

    /**
     * Set Details of a project reference
     *
     * @param  string $id   __BT-11, From EN 16931__ The identifier of the project to which the invoice relates
     * @param  string $name __BT-11-0, From EN 16931__  The name of the project to which the invoice relates
     * @return ZugferdQuickDescriptor
     */
    public function doSetSpecifiedProcuringProject(string $id, string $name): ZugferdQuickDescriptor
    {
        $this->setDocumentProcuringProject($id, $name);
        return $this;
    }

    /**
     * Set detailed information on the actual delivery
     *
     * @param  DateTime|null $date __BT-72, From BASIC WL__ Actual delivery time
     * @return ZugferdQuickDescriptor
     */
    public function doSetSupplyChainEvent(?DateTime $date): ZugferdQuickDescriptor
    {
        $this->setDocumentSupplyChainEvent($date);
        return $this;
    }

    /**
     * Detailed information about the buyer (service recipient)
     *
     * @param  string      $name           __BT-44, From MINIMUM__ The full name of the buyer
     * @param  string      $postcode       __BT-53, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string      $city           __BT-52, From BASIC WL__ Usual name of the city or municipality in which the buyers address is located
     * @param  string      $street         __BT-50, From BASIC WL__ The main line in the buyers address. This is usually the street name and house number or the post office box
     * @param  string      $country        __BT-55, From BASIC WL__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their
     *                                     subdivisions”
     * @param  string      $buyerReference __BT-10, From MINIMUM__ An identifier assigned by the buyer and used for internal routing
     * @param  string      $id             __BT-46, From BASIC WL__ An identifier of the buyer. In many systems, buyer identification is key information. Multiple buyer IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and buyer, e.g. a previously exchanged, seller-assigned identifier of the buyer
     * @param  string|null $globalID       __BT-46-0, From BASIC WL__ The buyers's identifier identification scheme is an identifier uniquely assigned to a buyer by a global registration organization.
     * @param  string|null $globalIDscheme __BT-46-1, From BASIC WL__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string      $name         __BT-56, From EN 16931__ Contact point for a legal entity, such as a personal name of the contact person
     * @param  string|null $orgunit      __BT-56-0, From EN 16931__ Contact point for a legal entity, such as a name of the department or office
     * @param  string|null $emailAddress __BT-58, From EN 16931__ An e-mail address of the contact point
     * @param  string|null $phoneno      __BT-57, From EN 16931__ A telephone number for the contact point
     * @param  string|null $faxno        __BT-X-115, From EXTENDED__ A fax number of the contact point
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
     * The local identification (defined by the buyers's address) of the buyers for tax purposes or a reference that enables the buyers
     * to indicate his reporting status for tax purposes The sales tax identification number of the buyers
     * Note: This information may affect how the buyer the invoice settled (such as in relation to social security contributions). So
     * e.g. In some countries, if the buyers is not reported for tax, the buyer will withhold the tax amount and pay it on behalf of the
     * buyers. Sales tax number with a prefixed country code. A supplier registered as subject to VAT must provide his sales tax
     * identification number, unless he uses a tax agent.
     *
     * @param  string $no       __BT-48-0, From BASIC WL__ Type of tax number (FC = Tax number, VA = Sales tax identification number)
     * @param  string $schemeID __BT-48, From BASIC WL__ Tax number or sales tax identification number
     * @return ZugferdQuickDescriptor
     */
    public function doAddBuyerTaxRegistration(string $no, string $schemeID): ZugferdQuickDescriptor
    {
        $this->addDocumentBuyerTaxRegistration($schemeID, $no);
        return $this;
    }

    /**
     * Set Buyers electronic communication information
     *
     * @param  string $uri       __BT-49, From BASIC WL__ Specifies the buyer's electronic address to which the invoice is sent
     * @param  string $uriScheme __BT-49-1, From BASIC WL__ The identifier for the identification scheme of the buyer's electronic address (Default: EM)
     * @return ZugferdQuickDescriptor
     */
    public function doSetBuyerElectronicCommunication(string $uri, string $uriScheme = "EM"): ZugferdQuickDescriptor
    {
        $this->setDocumentBuyerCommunication($uriScheme, $uri);
        return $this;
    }

    /**
     * Detailed information about the seller (=service provider)
     *
     * @param  string      $name           __BT-27, From MINIMUM__ The full formal name under which the seller is registered in the National Register of Legal Entities, Taxable Person or otherwise acting as person(s)
     * @param  string      $postcode       __BT-38, From BASIC WL__ Identifier for a group of properties, such as a zip code
     * @param  string      $city           __BT-37, From BASIC WL__ Usual name of the city or municipality in which the seller's address is located
     * @param  string      $street         __BT-35, From BASIC WL__ The main line in the sellers address. This is usually the street name and house number or the post office box
     * @param  string      $country        __BT-40, From MINIMUM__ Code used to identify the country. If no tax agent is specified, this is the country in which the sales tax is due. The lists of approved countries are maintained by the EN ISO 3166-1 Maintenance Agency “Codes for the representation of names of countries and their
     *                                     subdivisions”
     * @param  string|null $id             __BT-29, From BASIC WL__ An identifier of the seller. In many systems, seller identification is key information. Multiple seller IDs can be assigned or specified. They can be differentiated by using different identification schemes. If no scheme is given, it should be known to the buyer and seller, e.g. a previously exchanged, buyer-assigned identifier of the seller
     * @param  string|null $globalID       __BT-29/BT-29-0, From BASIC WL__ The seller's identifier identification scheme is an identifier uniquely assigned to a seller by a global registration organization.
     * @param  string|null $globalIDscheme __BT-29-1, From BASIC WL__ If the identifier is used for the identification scheme, it must be selected from the entries in the list published by the ISO / IEC 6523 Maintenance Agency.
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
     * @param  string      $name         __BT-41, From EN 16931__ Such as personal name, name of contact person or department or office
     * @param  string|null $orgunit      __BT-41-0, From EN 16931__ If a contact person is specified, either the name or the department must be transmitted.
     * @param  string|null $emailAddress __BT-43, From EN 16931__ An e-mail address of the contact point
     * @param  string|null $phoneno      __BT-42, From EN 16931__ A telephone number for the contact point
     * @param  string|null $faxno        __BT-X-107, From EXTENDED__ A fax number of the contact point
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
     * @param  string $no       __BT-31/32, From MINIMUM/EN 16931__ Tax number of the seller or sales tax identification number of the seller
     * @param  string $schemeID __BT-31-0/BT-32-0, From MINIMUM/EN 16931__ Type of tax number of the seller (FC = Tax number, VA = Sales tax identification number)
     * @return ZugferdQuickDescriptor
     */
    public function doAddSellerTaxRegistration(string $no, string $schemeID): ZugferdQuickDescriptor
    {
        $this->addDocumentSellerTaxRegistration($no, $schemeID);
        return $this;
    }

    /**
     * Set Sellers electronic communication information
     *
     * @param  string $uri       __BT-34, From BASIC WL__ Specifies the electronic address of the seller to which the response to the invoice can be sent at application level
     * @param  string $uriScheme __BT-34-1, From BASIC WL__ The identifier for the identification scheme of the seller's electronic address (Default: EM)
     * @return ZugferdQuickDescriptor
     */
    public function doSetSellerElectronicCommunication(string $uri, string $uriScheme = "EM"): ZugferdQuickDescriptor
    {
        $this->setDocumentSellerCommunication($uriScheme, $uri);
        return $this;
    }

    /**
     * Add a new text position
     *
     * @param      string $lineId  __BT-126, From BASIC__ Identification of the invoice item
     * @param      string $comment __BT-127, From BASIC__ A free text that contains unstructured information that is relevant to the invoice item
     * @return     ZugferdQuickDescriptor
     * @deprecated 1.0.75
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
     * @param  string $lineId                __BT-126, From BASIC__ Identification of the invoice item
     * @param  string $productName           __BT-153, From BASIC__ A name of the item (item name)
     * @param  float  $unitPrice             __BT-146, From BASIC__ Net price of the item
     * @param  float  $quantity              __BT-129, From BASIC__ The quantity of individual items (goods or services) billed in the relevant line
     * @param  string $unitCode              __BT-130, From BASIC__ The unit of measure applicable to the amount billed
     * @param  float  $allowanceChargeAmount __BT-136/BT-141, From BASIC__ The surcharge/discount amount excluding sales tax
     * @param  string $allowanceChargeReason __BT-139/BT-144, From BASIC__ The reason given in text form for the invoice item discount/surcharge
     * @param  string $taxCategoryCode       __BT-151, From BASIC__ Coded description of a sales tax category
     * @param  string $taxTypeCode           __BT-151-0, From BASIC__ In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for the tax type must then be taken from the code list
     *                                       UNTDID 5153.
     * @param  float  $taxPercent            __BT-152, From BASIC__ The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales tax category and the category-specific sales tax rate  must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeLineItem(string $lineId, string $productName, float $unitPrice, float $quantity, string $unitCode, float $allowanceChargeAmount, string $allowanceChargeReason, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        $hasChargeAmountIsAllowance = $allowanceChargeAmount != 0.0;
        $allowanceChargeAmountIsAllowance = $allowanceChargeAmount < 0.0;
        $allowanceAmount = $allowanceChargeAmountIsAllowance ? abs($allowanceChargeAmount) : 0.0;
        $chargeAmount = $allowanceChargeAmountIsAllowance === false ? abs($allowanceChargeAmount) : 0.0;
        $allowanceChargeAmount = abs($allowanceChargeAmount);
        $lineTotalAmount = round($unitPrice * $quantity + $chargeAmount - $allowanceAmount, 2);

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
     * Add detailed information on the free text on the position
     *
     * @param  string $content __BT-127, From BASIC__ A free text that contains unstructured information that is relevant to the invoice item
     * @return ZugferdQuickDescriptor
     */
    public function doSetDocumentPositionNote(string $content): ZugferdQuickDescriptor
    {
        $this->setDocumentPositionNote($content);

        return $this;
    }

    /**
     * Adds a new position (line) to document with a surcharge amount
     *
     * @param  string $lineId          __BT-126, From BASIC__ Identification of the invoice item
     * @param  string $productName     __BT-153, From BASIC__ A name of the item (item name)
     * @param  float  $unitPrice       __BT-146, From BASIC__ Net price of the item
     * @param  float  $quantity        __BT-129, From BASIC__ The quantity of individual items (goods or services) billed in the relevant line
     * @param  string $unitCode        __BT-130, From BASIC__ The unit of measure applicable to the amount billed
     * @param  float  $chargeAmount    __BT-136/BT-141, From BASIC__ The surcharge amount excluding sales tax
     * @param  string $chargeReason    __BT-139/BT-144, From BASIC__ The reason given in text form for the invoice item surcharge
     * @param  string $taxCategoryCode __BT-151, From BASIC__ Coded description of a sales tax category
     * @param  string $taxTypeCode     __BT-151-0, From BASIC__ In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for the tax type must then be taken from the code list
     *                                 UNTDID 5153.
     * @param  float  $taxPercent      __BT-152, From BASIC__ The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales tax category and the category-specific sales tax rate  must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeLineItemWithSurcharge(string $lineId, string $productName, float $unitPrice, float $chargeAmount, string $chargeReason, float $quantity, string $unitCode, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        $this->doAddTradeLineItem($lineId, $productName, $unitPrice, $quantity, $unitCode, abs($chargeAmount), $chargeReason, $taxCategoryCode, $taxTypeCode, $taxPercent);
        return $this;
    }

    /**
     * Adds a new position (line) to document with a discount amount
     *
     * @param  string $lineId          __BT-126, From BASIC__ Identification of the invoice item
     * @param  string $productName     __BT-153, From BASIC__ A name of the item (item name)
     * @param  float  $unitPrice       __BT-146, From BASIC__ Net price of the item
     * @param  float  $quantity        __BT-129, From BASIC__ The quantity of individual items (goods or services) billed in the relevant line
     * @param  string $unitCode        __BT-130, From BASIC__ The unit of measure applicable to the amount billed
     * @param  float  $discountAmount  __BT-136/BT-141, From BASIC__ The discount amount excluding sales tax
     * @param  string $discountReason  __BT-139/BT-144, From BASIC__ The reason given in text form for the invoice item discount
     * @param  string $taxCategoryCode __BT-151, From BASIC__ Coded description of a sales tax category
     * @param  string $taxTypeCode     __BT-151-0, From BASIC__ In EN 16931 only the tax type “sales tax” with the code “VAT” is supported. Should other types of tax be specified, such as an insurance tax or a mineral oil tax the EXTENDED profile must be used. The code for the tax type must then be taken from the code list
     *                                 UNTDID 5153.
     * @param  float  $taxPercent      __BT-152, From BASIC__ The VAT rate applicable to the item invoiced and expressed as a percentage. Note: The code of the sales tax category and the category-specific sales tax rate  must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
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
     * @param  float  $amount          __BT-X-272, From EXTENDED__ Amount of the service fee
     * @param  string $description     __BT-X-271, From EXTENDED__ Identification of the service fee
     * @param  string $taxTypeCode     __BT-X-273-0, From EXTENDED__ Code of the Tax type. Note: Fixed value = "VAT"
     * @param  string $taxCategoryCode __BT-X-273, From EXTENDED__ Code of the VAT category
     * @param  float  $taxPercent      __BT-X-274, From EXTENDED__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
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
     * @param  float  $actualAmount    __BT-92/BT-99, From BASIC WL__ Amount of the surcharge or discount at document level
     * @param  string $reason          __BT-97/BT-104, From BASIC WL__ The reason given in text form for the surcharge or discount at document level
     * @param  string $taxCategoryCode __BT-95/BT-102, From BASIC WL__ A coded indication of which sales tax category applies to the surcharge or deduction at document level
     * @param  string $taxTypeCode     __BT-95-0/BT-102-0, From BASIC WL__ Code for the VAT category of the surcharge or charge at document level. Note: Fixed value = "VAT"
     * @param  float  $taxPercent      __BT-96/BT-103, From BASIC WL__ VAT rate for the surcharge or discount on document level. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @return ZugferdQuickDescriptor
     */
    public function doAddTradeAllowanceCharge(float $actualAmount, string $reason, string $taxCategoryCode, string $taxTypeCode, float $taxPercent): ZugferdQuickDescriptor
    {
        if ($actualAmount == 0.0) {
            return $this;
        }

        $allowanceChargeAmountIsAllowance = $actualAmount < 0.0;
        $allowanceAmount = $allowanceChargeAmountIsAllowance ? abs($actualAmount) : 0.0;
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
     * @param  float       $basisAmount                __BT-116, From BASIC WL__ Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float       $percent                    __BT-119, From BASIC WL__ The sales tax rate, expressed as the percentage applicable to the sales tax category in question. Note: The code of the sales tax category and the category-specific sales tax rate must correspond to one another. The value to be given is the percentage. For example, the value 20 is given for 20% (and not 0.2)
     * @param  string      $categoryCode               __BT-118, From BASIC WL__ Coded description of a sales tax category
     * @param  string|null $typeCode                   __BT-118-0, From BASIC WL__ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float|null  $allowanceChargeBasisAmount __BT-X-263, From EXTENDED__ Total amount Additions and deductions to the tax rate at document level
     * @param  string|null $exemptionReasonCode        __BT-121, From BASIC WL__ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility.
     * @param  string|null $exemptionReason            __BT-120, From BASIC WL__ Reason for tax exemption (free text)
     * @return ZugferdQuickDescriptor
     */
    public function doAddApplicableTradeTax(float $basisAmount, float $percent, string $categoryCode, ?string $typeCode = null, ?float $allowanceChargeBasisAmount = null, ?string $exemptionReasonCode = null, ?string $exemptionReason = null): ZugferdQuickDescriptor
    {
        $this->addDocumentTax($categoryCode, $typeCode ?? "VAT", $basisAmount, round(0.01 * $percent * $basisAmount, 2), $percent, $exemptionReason, $exemptionReasonCode, null, $allowanceChargeBasisAmount);
        return $this;
    }

    /**
     * Add a VAT breakdown (at document level)
     *
     * @param  float       $basisAmount                __BT-116, From BASIC WL__ Tax base amount, Each sales tax breakdown must show a category-specific tax base amount.
     * @param  float       $calculatedAmount           __BT-117, From BASIC WL__ The total amount to be paid for the relevant VAT category. Note: Calculated by multiplying the amount to be taxed according to the sales tax category by the sales tax rate applicable for the sales tax category concerned
     * @param  string      $categoryCode               __BT-118, From BASIC WL__ Coded description of a sales tax category
     * @param  string|null $typeCode                   __BT-118-0, From BASIC WL__ Coded description of a sales tax category. Note: Fixed value = "VAT"
     * @param  float|null  $allowanceChargeBasisAmount __BT-X-263, From EXTENDED__ Total amount Additions and deductions to the tax rate at document level
     * @param  string|null $exemptionReasonCode        __BT-121, From BASIC WL__ Reason given in code form for the exemption of the amount from VAT. Note: Code list issued and maintained by the Connecting Europe Facility.
     * @param  string|null $exemptionReason            __BT-120, From BASIC WL__ Reason for tax exemption (free text)
     * @return ZugferdQuickDescriptor
     */
    public function doAddApplicableTradeTax2(float $basisAmount, float $calculatedAmount, string $categoryCode, ?string $typeCode = null, ?float $allowanceChargeBasisAmount = null, ?string $exemptionReasonCode = null, ?string $exemptionReason = null): ZugferdQuickDescriptor
    {
        $this->addDocumentTax($categoryCode, $typeCode ?? "VAT", $basisAmount, $calculatedAmount, round($calculatedAmount * 100.0 / $basisAmount, 2), $exemptionReason, $exemptionReasonCode, null, $allowanceChargeBasisAmount);
        return $this;
    }

    /**
     * Sets the prepaid amount
     *
     * @param  float $totalPrepaidAmount __BT-113, From BASIC WL__ Prepayment amount
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
        if ($this->totalsAreCalculated !== false) {
            return $this;
        }

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

        $this->totalsAreCalculated = true;

        return $this;
    }

    /**
     * Insert into internal vat table for later using, e.g. when creating
     * the vat breakdown
     *
     * @param  string $taxCategoryCode
     * @param  string $taxTypeCode
     * @param  float  $taxPercent
     * @param  float  $lineTotalAmount
     * @param  float  $chargeAmount
     * @param  float  $allowanceAmount
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
                    $this->vatBreakdown[$vatGroup][self::VT_TAXPERCENT] / 100.0,
                2
            );
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
     * @param  integer $index
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
