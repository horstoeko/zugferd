<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing the different invoice types
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */

class ZugferdInvoiceType
{
    /**
     * Debit note related to goods or services (80)
     * is an Invoice
     */
    public const DEBITNOTERELATEDTOGOODSSERVICES = "80";

    /**
     * Credit note related to goods or services (81)
     * is a Credit Note
     */
    public const CREDITNOTERELATEDTOGOODSSERVICES = "81";

    /**
     * Metered services invoice (82)
     * is an Invoice
     */
    public const METEREDSERVICESINVOICE = "82";

    /**
     * Credit note related to financial adjustments (83)
     * is a Credit Note
     */
    public const CREDITNOTERELATEDTOFINANCIALADJUSTMENTS = "83";

    /**
     * Debit note related to financial adjustments (84)
     * is an Invoice
     */
    public const DEBITNOTERELATEDTOFINANCIALADJUSTMENTS = "84";

    /**
     * Invoicing data sheet (130)
     * is an Invoice
     */
    public const INVOICINGDATASHEET = "130";

    /**
     * Direct payment valuation (202)
     * is an Invoice
     */
    public const DIRECTPAYMENTVALUATION = "202";

    /**
     * Provisional payment valuation (203)
     * is an Invoice
     */
    public const PROVISIONALPAYMENTVALUATION = "203";

    /**
     * Payment valuation (204)
     * is an Invoice
     */
    public const PAYMENTVALUATION = "204";

    /**
     * Interim application for payment (211)
     * is an Invoice
     */
    public const INTERIMAPPLICATIONFORPAYMENT = "211";

    /**
     * Self billed credit note (261)
     * is a Credit Note
     *
     * A document which indicates that the customer
     * is claiming credit in a self billing environment
     */
    public const SELFBILLEDCREDITNOTE = "261";

    /**
     * Consolidated credit note - goods and services (262)
     * is a Credit Note
     */
    public const CONSOLIDATEDCREDITNOTESGOODSERVICES = "262";

    /**
     * Price variation invoice (295)
     * is an Invoice
     */
    public const PRICEVARIATIONINVOICE = "295";

    /**
     * Credit note for price variation (296)
     * is a Credit Note
     */
    public const CREDITNOTEPRICEVARIATION = "296";

    /**
     * Delcredere credit note (308)
     * is a Credit Note
     */
    public const DELCREDERECREDITNOTE = "308";

    /**
     * Proforma invoice (325)
     * is an Invoice
     */
    public const PROFORMAINVOICE = "325";

    /**
     * Partial invoice (326)
     * is an Invoice
     *
     * Teilrechnung
     */
    public const PARTIALINVOICE = "326";

    /**
     * Commercial invoice (380)
     * is an Invoice
     *
     * This is the main invoice type
     *
     * Handelsrechnung
     */
    public const INVOICE = "380";

    /**
     * Credit note (381)
     * is a Credit Note
     *
     * This is the main credit note type
     *
     * Gutschriftanzeige
     */
    public const CREDITNOTE = "381";

    /**
     * Debit note (383)
     * is an Invoice
     *
     * Belastungsanzeige
     */
    public const DEBITNOTE = "383";

    /**
     * Corrected invoice (384)
     * is an Invoice
     *
     * Rechnungskorrektur
     */
    public const CORRECTION = "384";

    /**
     * Consolidated invoice (385)
     * is an Invoice
     */
    public const CONSOLIDATEDINVOICE = "385";

    /**
     * Prepayment invoice (386)
     * is an Invoice
     *
     * Vorauszahlungsrechnung
     * Eine Rechnung, die Vorauszahlung für Produkte anfordert.
     * Die darin enthaltenen Beträge werden in der Schlussrechnung
     * abgezogen.
     *
     * An invoice requesting prepayment for products.
     * The amounts contained therein will be deducted from the final
     * invoice.
     */
    public const PREPAYMENTINVOICE = "386";

    /**
     * Hire invoice (387)
     * is an Invoice
     */
    public const HIREINVOICE = "387";

    /**
     * Tax invoice (388)
     * is an Invoice
     */
    public const TAXINVOICE = "388";

    /**
     * Self-billed invoice (389)
     * is an Invoice
     *
     * Gutschrift (Selbst ausgestellte Rechnung)
     * Gutschrift im Gutschriftverfahren
     *
     * Eine Rechnung, die der Zahlungspflichtige selbst ausstellt
     * anstelle des Verkäufers.
     *
     * An invoice that the debtor issues himself instead of the
     * seller.
     */
    public const SELFBILLEDINVOICE = "389";

    /**
     * Delcredere invoice (390)
     * is an Invoice
     */
    public const DELCREDEREINVOICE = "390";

    /**
     * Factored invoice (393)
     * is an Invoice
     */
    public const FACTOREDINVOICE = "393";

    /**
     * Lease invoice (394)
     * is an Invoice
     */
    public const LEASEINVOICE = "394";

    /**
     * Consignment invoice (395)
     * is an Invoice
     */
    public const CONSIGNMENTINVOICE = "395";

    /**
     * Factored credit note (396)
     * is a Credit Note
     */
    public const FACTOREDCREDITNOTE = "396";

    /**
     * Optical Character Reading (OCR) payment credit note (420)
     * is a Credit Note
     */
    public const OCRPAYMENTCREDITNOTE = "420";

    /**
     * Debit advice (456)
     * is an Invoice
     */
    public const DEBITADVICE = "456";

    /**
     * Reversal of debit (457)
     * is an Invoice
     */
    public const REVERSALOFDEBIT = "457";

    /**
     * Reversal of credit (458)
     * is a Credit Note
     */
    public const REVERSALOFCREDIT = "458";

    /**
     * Self billed debit note (527)
     * is an Invoice
     */
    public const SELFBILLEDDEBITNOTE = "527";

    /**
     * Insurer's invoice (575)
     * is an Invoice
     */
    public const INSURERSINVOICE = "575";

    /**
     * Forwarder's invoice (623)
     * is an Invoice
     */
    public const FORWARDERSINVOICE = "623";

    /**
     * Port charges documents (633)
     * is an Invoice
     */
    public const PORTCHARGESDOCUMENTS = "633";

    /**
     * Invoice information for accounting purposes (751)
     * is an Invoice
     *
     * Buchungshilfe - KEINE Rechnung
     *
     * Für die Profile BASIC WL und MINIMUM darf ausschließlich dieser
     * Code 751 "Buchungshilfe - KEINE Rechnung" verwendet werden, da diese
     * Profile in DE steuerrechtlich keine Rechnungen darstellen!
     *
     * For the BASIC WL and MINIMUM profiles only this code 751 "Booking
     * aid - NO invoice" may be used, since these profiles do not represent
     * invoices for tax purposes in DE!
     */
    public const INVOICEINFORMATION = "751";

    /**
     * Freight invoice (780)
     * is an Invoice
     */
    public const FREIGHTINVOICE = "780";

    /**
     * Customs invoice (935)
     * is an Invoice
     */
    public const CUSTOMSINVOICE = "935";

    /**
     * Corrected invoice (1380)
     * is an Invoice
     *
     * Old ZUGFeRD variant, use Corrected Invoice (384) instead
     */
    public const CORRECTIONOLD = "1380";
}
