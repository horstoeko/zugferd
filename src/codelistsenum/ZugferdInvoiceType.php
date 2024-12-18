<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the different invoice types
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdInvoiceType: int
{

    /**
     * Debit note related to goods or services (80)
     * is an Invoice
     */
    case DEBITNOTERELATEDTOGOODSSERVICES = 80;

    /**
     * Credit note related to goods or services (81)
     * is a Credit Note
     */
    case CREDITNOTERELATEDTOGOODSSERVICES = 81;

    /**
     * Metered services invoice (82)
     * is an Invoice
     */
    case METEREDSERVICESINVOICE = 82;

    /**
     * Credit note related to financial adjustments (83)
     * is a Credit Note
     */
    case CREDITNOTERELATEDTOFINANCIALADJUSTMENTS = 83;

    /**
     * Debit note related to financial adjustments (84)
     * is an Invoice
     */
    case DEBITNOTERELATEDTOFINANCIALADJUSTMENTS = 84;

    /**
     * Invoicing data sheet (130)
     * is an Invoice
     */
    case INVOICINGDATASHEET = 130;

    /**
     * Direct payment valuation (202)
     * is an Invoice
     */
    case DIRECTPAYMENTVALUATION = 202;

    /**
     * Provisional payment valuation (203)
     * is an Invoice
     */
    case PROVISIONALPAYMENTVALUATION = 203;

    /**
     * Payment valuation (204)
     * is an Invoice
     */
    case PAYMENTVALUATION = 204;

    /**
     * Interim application for payment (211)
     * is an Invoice
     */
    case INTERIMAPPLICATIONFORPAYMENT = 211;

    /**
     * Self billed credit note (261)
     * is a Credit Note
     *
     * A document which indicates that the customer
     * is claiming credit in a self billing environment
     */
    case SELFBILLEDCREDITNOTE = 261;

    /**
     * Consolidated credit note - goods and services (262)
     * is a Credit Note
     */
    case CONSOLIDATEDCREDITNOTESGOODSERVICES = 262;

    /**
     * Price variation invoice (295)
     * is an Invoice
     */
    case PRICEVARIATIONINVOICE = 295;

    /**
     * Credit note for price variation (296)
     * is a Credit Note
     */
    case CREDITNOTEPRICEVARIATION = 296;

    /**
     * Delcredere credit note (308)
     * is a Credit Note
     */
    case DELCREDERECREDITNOTE = 308;

    /**
     * Proforma invoice (325)
     * is an Invoice
     */
    case PROFORMAINVOICE = 325;

    /**
     * Partial invoice (326)
     * is an Invoice
     *
     * Teilrechnung
     */
    case PARTIALINVOICE = 326;

    /**
     * Commercial invoice (380)
     * is an Invoice
     *
     * This is the main invoice type
     *
     * Handelsrechnung
     */
    case INVOICE = 380;

    /**
     * Credit note (381)
     * is a Credit Note
     *
     * This is the main credit note type
     *
     * Gutschriftanzeige
     */
    case CREDITNOTE = 381;

    /**
     * Debit note (383)
     * is an Invoice
     *
     * Belastungsanzeige
     */
    case DEBITNOTE = 383;

    /**
     * Corrected invoice (384)
     * is an Invoice
     *
     * Rechnungskorrektur
     */
    case CORRECTION = 384;

    /**
     * Consolidated invoice (385)
     * is an Invoice
     */
    case CONSOLIDATEDINVOICE = 385;

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
    case PREPAYMENTINVOICE = 386;

    /**
     * Hire invoice (387)
     * is an Invoice
     */
    case HIREINVOICE = 387;

    /**
     * Tax invoice (388)
     * is an Invoice
     */
    case TAXINVOICE = 388;

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
    case SELFBILLEDINVOICE = 389;

    /**
     * Delcredere invoice (390)
     * is an Invoice
     */
    case DELCREDEREINVOICE = 390;

    /**
     * Factored invoice (393)
     * is an Invoice
     */
    case FACTOREDINVOICE = 393;

    /**
     * Lease invoice (394)
     * is an Invoice
     */
    case LEASEINVOICE = 394;

    /**
     * Consignment invoice (395)
     * is an Invoice
     */
    case CONSIGNMENTINVOICE = 395;

    /**
     * Factored credit note (396)
     * is a Credit Note
     */
    case FACTOREDCREDITNOTE = 396;

    /**
     * Optical Character Reading (OCR) payment credit note (420)
     * is a Credit Note
     */
    case OCRPAYMENTCREDITNOTE = 420;

    /**
     * Debit advice (456)
     * is an Invoice
     */
    case DEBITADVICE = 456;

    /**
     * Reversal of debit (457)
     * is an Invoice
     */
    case REVERSALOFDEBIT = 457;

    /**
     * Reversal of credit (458)
     * is a Credit Note
     */
    case REVERSALOFCREDIT = 458;

    /**
     * Self billed debit note (527)
     * is an Invoice
     */
    case SELFBILLEDDEBITNOTE = 527;

    /**
     * Insurer's invoice (575)
     * is an Invoice
     */
    case INSURERSINVOICE = 575;

    /**
     * Forwarder's invoice (623)
     * is an Invoice
     */
    case FORWARDERSINVOICE = 623;

    /**
     * Port charges documents (633)
     * is an Invoice
     */
    case PORTCHARGESDOCUMENTS = 633;

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
    case INVOICEINFORMATION = 751;

    /**
     * Freight invoice (780)
     * is an Invoice
     */
    case FREIGHTINVOICE = 780;

    /**
     * Customs invoice (935)
     * is an Invoice
     */
    case CUSTOMSINVOICE = 935;

    /**
     * Corrected invoice (1380)
     * is an Invoice
     *
     * Old ZUGFeRD variant, use Corrected Invoice (384) instead
     */
    case CORRECTIONOLD = 1380;
}
