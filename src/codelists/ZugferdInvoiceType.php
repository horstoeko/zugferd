<?php

namespace horstoeko\zugferd\codelists;

class ZugferdInvoiceType
{
    /**
     * Document/message for providing debit information
     * related to financial adjustments to the relevant party.
     */
    public const DEBITNOTERELATEDTOFINANCIALADJUSTMENTS = "84";

    /**
     * Self billed credit note (261)
     * is a Credit Note
     *
     * A document which indicates that the customer
     * is claiming credit in a self billing environment
     */
    public const SELFBILLEDCREDITNOTE = "261";

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
     * Invoice information for accounting purposes (751)
     * is an Invoice
     *
     * Buchungshilfe - KEINE Rechnung
     *
     * Für die Profile BASIC WL und MINIMUM darf ausschließlich dieser
     * Code 751 "Buchungshilfe - KEINE Rechnung" verwendet werden,
     * da diese Profile in DE steuerrechtlich keine Rechnungen darstellen!
     *
     * For the BASIC WL and MINIMUM profiles only this code 751 "Booking
     * aid - NO invoice" may be used, since these profiles do not represent
     * invoices for tax purposes in DE!
     */
    public const INVOICEINFORMATION = "751";

    /**
     * Corrected invoice (1380)
     * is an Invoice
     *
     * Old ZUGFeRD variant, use Corrected Invoice (384) instead
     */
    public const CORRECTIONOLD = "1380";
}
