<?php

declare(strict_types=1);

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use JMS\Serializer\Exception\RuntimeException;
use stdClass;

/**
 * Class representing the export of a zugferd document
 * in JSON format
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentJsonExporter
{
    /**
     * The instance to the zugferd document
     *
     * @var ZugferdDocument
     */
    private $document;

    /**
     * Constructor
     *
     * @param ZugferdDocument $document
     */
    public function __construct(ZugferdDocument $document)
    {
        $this->document = $document;
    }

    /**
     * Returns the invoice object as a json string
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function toJsonString(): string
    {
        return $this->document->serializeAsJson();
    }

    /**
     * Returns the invoice object as a json object
     *
     * @return null|stdClass
     *
     * @throws RuntimeException
     */
    public function toJsonObject(): ?stdClass
    {
        return json_decode($this->toJsonString());
    }

    /**
     * Returns the invoice object as a pretty printed json string
     *
     * @return bool|string
     *
     * @throws RuntimeException
     */
    public function toPrettyJsonString()
    {
        return json_encode($this->toJsonObject(), JSON_PRETTY_PRINT);
    }
}
