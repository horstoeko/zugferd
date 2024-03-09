<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

/**
 * Class representing the validator for documents
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdValidator
{
    /**
     * The invoice document reference
     *
     * @var ZugferdDocument
     */
    private $document;

    /**
     * Constructor
     *
     * @codeCoverageIgnore
     * @param ZugferdDocument $document
     */
    public function __construct(ZugferdDocument $document)
    {
        $this->document = $document;
    }
}