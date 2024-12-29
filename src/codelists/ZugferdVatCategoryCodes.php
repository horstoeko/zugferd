<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing list of duty or tax or fee category codes
 * Name of list: UNTDID 5305 Duty or tax or fee category code
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 * @see      https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.5305_3
 */
class ZugferdVatCategoryCodes
{
    /**
     * Canary Islands general indirect tax (L)
     *
     * Impuesto General Indirecto Canario (IGIC) is an indirect tax levied on
     * goods and services supplied in the Canary Islands (Spain) by traders and
     * professionals, as well as on import of goods.
     */
    public const CANA_ISLA_GENE_INDI_TAX = 'L';

    /**
     * Duty paid by supplier (C)
     *
     * Duty associated with shipment of goods is paid by the supplier; customer
     * receives goods with duty paid.
     */
    public const DUTY_PAID_BY_SUPP = 'C';

    /**
     * Exempt for resale (AB)
     *
     * A tax category code indicating the item is tax exempt when the item is
     * bought for future resale.
     */
    public const EXEM_FOR_RESA = 'AB';

    /**
     * Exempt from tax (E)
     *
     * Code specifying that taxes are not applicable.
     */
    public const EXEM_FROM_TAX = 'E';

    /**
     * Free export item, tax not charged (G)
     *
     * Code specifying that the item is free export and taxes are not charged.
     */
    public const FREE_EXPO_ITEM_TAX_NOT_CHAR = 'G';

    /**
     * Higher rate (H)
     *
     * Code specifying a higher rate of duty or tax or fee.
     */
    public const HIGH_RATE = 'H';

    /**
     * Lower rate (AA)
     *
     * Tax rate is lower than standard rate.
     */
    public const LOWE_RATE = 'AA';

    /**
     * Mixed tax rate (A)
     *
     * Code specifying that the rate is based on mixed tax.
     */
    public const MIXE_TAX_RATE = 'A';

    /**
     * Services outside scope of tax (O)
     *
     * Code specifying that taxes are not applicable to the services.
     */
    public const SERV_OUTS_SCOP_OF_TAX = 'O';

    /**
     * Standard rate (S)
     *
     * Code specifying the standard rate.
     */
    public const STAN_RATE = 'S';

    /**
     * Tax for production, services and importation in Ceuta and Melilla (M)
     *
     * Impuesto sobre la Producción, los Servicios y la Importación (IPSI) is an
     * indirect municipal tax, levied on the production, processing and import of
     * all kinds of movable tangible property, the supply of services and the
     * transfer of immovable property located in the cities of Ceuta and Melilla.
     */
    public const TAX_FOR_PROD_SERV_AND_IMPO_IN_CEUT_AND_MELI = 'M';

    /**
     * Transferred (VAT) (B)
     *
     * VAT not to be paid to the issuer of the invoice but directly to relevant
     * tax authority.
     */
    public const TRAN_VAT = 'B';

    /**
     * Value Added Tax (VAT) due from a previous invoice (AD)
     *
     * A code to indicate that the Value Added Tax (VAT) amount of a previous
     * invoice is to be paid.
     */
    public const VALU_ADDE_TAX_VAT_DUE_FROM_A_PREV_INVO = 'AD';

    /**
     * Value Added Tax (VAT) margin scheme - collector’s items and antiques (J)
     *
     * Indication that the VAT margin scheme for collector’s items and antiques
     * is applied.
     */
    public const VALU_ADDE_TAX_VAT_MARG_SCHE_COLL_ITEM_AND_ANTI = 'J';

    /**
     * Value Added Tax (VAT) margin scheme - second-hand goods (F)
     *
     * Indication that the VAT margin scheme for second-hand goods is applied.
     */
    public const VALU_ADDE_TAX_VAT_MARG_SCHE_SECO_GOOD = 'F';

    /**
     * Value Added Tax (VAT) margin scheme - travel agents (D)
     *
     * Indication that the VAT margin scheme for travel agents is applied.
     */
    public const VALU_ADDE_TAX_VAT_MARG_SCHE_TRAV_AGEN = 'D';

    /**
     * Value Added Tax (VAT) margin scheme - works of art Margin scheme — Works
     * of art (I)
     *
     * Indication that the VAT margin scheme for works of art is applied.
     */
    public const VALU_ADDE_TAX_VAT_MARG_SCHE_WORK_OF_ART_MARG_SCHE_WORK_OF_ART = 'I';

    /**
     * Value Added Tax (VAT) not now due for payment (AC)
     *
     * A code to indicate that the Value Added Tax (VAT) amount which is due on
     * the current invoice is to be paid on receipt of a separate VAT payment
     * request.
     */
    public const VALU_ADDE_TAX_VAT_NOT_NOW_DUE_FOR_PAYM = 'AC';

    /**
     * VAT exempt for EEA intra-community supply of goods and services (K)
     *
     * A tax category code indicating the item is VAT exempt due to an
     * intra-community supply in the European Economic Area.
     */
    public const VAT_EXEM_FOR_EEA_INTR_SUPP_OF_GOOD_AND_SERV = 'K';

    /**
     * VAT Reverse Charge (AE)
     *
     * Code specifying that the standard VAT rate is levied from the invoicee.
     */
    public const VAT_REVE_CHAR = 'AE';

    /**
     * Zero rated goods (Z)
     *
     * Code specifying that the goods are at a zero rate.
     */
    public const ZERO_RATE_GOOD = 'Z';
}
