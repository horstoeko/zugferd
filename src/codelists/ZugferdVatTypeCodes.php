<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing list of duty or tax or fee type name code
 * Name of list: UNTDID 5153 Duty or tax or fee type name code
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 * @see      https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.5305_3
 */
class ZugferdVatTypeCodes
{
    /**
     * Value added tax (VAT)
     *
     * A tax on domestic or imported goods applied to the value added
     * at each stage in the production/distribution cycle.
     */
    public const VALUE_ADDED_TAX = 'VAT';
}
