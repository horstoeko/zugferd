<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the Allowance codes
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdAllowanceCodes: int
{

    /**
     * Bonus for works ahead of schedule
     */
    case BONUS_FOR_WORKS_AHEAD_OF_SCHEDULE = 41;

    /**
     * Other bonus
     */
    case OTHER_BONUS = 42;

    /**
     * Manufacturer’s consumer discount
     */
    case MANUFACTURERS_CONSUMER_DISCOUNT = 60;

    /**
     * Due to military status
     */
    case DUE_TO_MILITARY_STATUS = 62;

    /**
     * Due to work accident
     */
    case DUE_TO_WORK_ACCIDENT = 63;

    /**
     * Special agreement
     */
    case SPECIAL_AGREEMENT = 64;

    /**
     * Production error discount
     */
    case PRODUCTION_ERROR_DISCOUNT = 65;

    /**
     * New outlet discount
     */
    case NEW_OUTLET_DISCOUNT = 66;

    /**
     * Sample discount
     */
    case SAMPLE_DISCOUNT = 67;

    /**
     * End-of-range discount
     */
    case ENDOFRANGE_DISCOUNT = 68;

    /**
     * Incoterm discount
     */
    case INCOTERM_DISCOUNT = 70;

    /**
     * Point of sales threshold allowance
     */
    case POINT_OF_SALES_THRESHOLD_ALLOWANCE = 71;

    /**
     * Material surcharge/deduction
     */
    case MATERIAL_SURCHARGE_DEDUCTION = 88;

    /**
     * Discount
     */
    case DISCOUNT = 95;

    /**
     * Special rebate
     */
    case SPECIAL_REBATE = 100;

    /**
     * Fixed long term
     */
    case FIXED_LONG_TERM = 102;

    /**
     * Temporary
     */
    case TEMPORARY = 103;

    /**
     * Standard
     */
    case STANDARD = 104;

    /**
     * Yearly turnover
     */
    case YEARLY_TURNOVER = 105;
}
