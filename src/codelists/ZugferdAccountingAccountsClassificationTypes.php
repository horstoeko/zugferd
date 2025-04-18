<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing Accounting Account classifications
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdAccountingAccountsClassificationTypes
{
    /**
     * The code indicates a general chart of accounts
     */
    public const GENERAL_ACCOUNT_CHART_OF_ACCOUNTS = '1';

    /**
     * The code indicates a cost chart of accounts
     */
    public const COST_ACCOUNTING_CHART_OF_ACCOUNTS = '2';

    /**
     * The code indicates a budget chart of accounts
     */
    public const BUDGETARY_ACCOUNT_CHART_OF_ACCOUNTS = '3';

    /**
     * The code indicates a payable chart of accounts
     */
    public const PAYABLE_ACCOUNT_CHART_OF_ACCOUNTS = '4';

    /**
     * The code indicates a receivable chart of accounts
     */
    public const RECEIVABLE_ACCOUNT_CHART_OF_ACCOUNTS = '5';

    /**
     * The code indicates a job chart of accounts
     */
    public const JOB_ACCOUNT_CHART_OF_ACCOUNTS = '6';

    /**
     * The code indicates a building site chart of accounts
     */
    public const BUILDING_SITE_ACCOUNT_CHART_OF_ACCOUNTS = '7';
}
