<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing the Duty or tax or fee categories
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDutyTaxFeeCategories
{
    /**
     * Standard rate
     */
    public const STANDARD_RATE = "S";

    /**
     * Zero rated goods
     */
    public const ZERO_RATED_GOODS = "Z";

    /**
     * Exempt from tax
     */
    public const EXEMPT_FROM_TAX = "E";

    /**
     * VAT Reverse charge
     */
    public const VAT_REVERSE_CHARGE = "AE";

    /**
     * VAT exempt for EEA intra-community supply of goods and services
     */
    public const VAT_EXEMPT_FOR_EEA_INTRACOMMUNITY_SUPPLY_OF_GOODS_AND_SERVICES = "K";

    /**
     * Free export item, tax not charged
     */
    public const FREE_EXPORT_ITEM_TAX_NOT_CHARGED = "G";

    /**
     * Service outside scope of tax
     */
    public const SERVICE_OUTSIDE_SCOPE_OF_TAX = "O";

    /**
     * Canary Islands general indirect tax
     */
    public const CANARY_ISLANDS_GENERAL_INDIRECT_TAX = "L";

    /**
     * Tax for production, services and importation in Ceuta and Melilla
     */
    public const TAX_FOR_PRODUCTION_SERVICES_AND_IMPORTATION_IN_CEUTA_AND_MELILLA = "M";
}
