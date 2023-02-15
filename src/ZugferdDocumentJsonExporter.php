<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use \GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use \GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use \horstoeko\zugferd\jms\ZugferdTypesHandler;
use \JMS\Serializer\Handler\HandlerRegistryInterface;
use \JMS\Serializer\SerializerBuilder;
use \JMS\Serializer\SerializerInterface;
use RuntimeException;

/**
 * Class representing the export of a zugferd document
 * in JSON format
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentJsonExporter
{
    /**
     * The instance to the zugferd document
     *
     * @var ZugferdDocument
     */
    private $document = null;

    /**
     * @internal
     * Serializer builder
     * @var      SerializerBuilder
     */
    private $serializerBuilder;

    /**
     * @internal
     * Serializer
     * @var      SerializerInterface
     */
    private $serializer;

    /**
     * Constructor
     *
     * @param ZugferdDocument $document
     *
     * @codeCoverageIgnore
     */
    public function __construct(ZugferdDocument $document)
    {
        $this->document = $document;
        $this->initSerialzer();
    }

    /**
     * Returns the invoice object as a json string
     *
     * @return string
     */
    public function toJsonString(): string
    {
        return $this->serializer->serialize($this->document->getInvoiceObject(), 'json');
    }

    /**
     * Returns the invoice object as a json object
     *
     * @return string
     * @throws RuntimeException
     */
    public function toJsonObject(): object
    {
        $jsonObject = json_decode($this->toJsonString());

        if ($jsonObject === null) {
            throw new \RuntimeException("Invalid JSON");
        }

        return $jsonObject;
    }

    /**
     * Returns the invoice object as a pretty printed json string
     *
     * @return string|boolean
     */
    public function toPrettyJsonString()
    {
        return json_encode($this->toJsonObject(), JSON_PRETTY_PRINT);
    }

    /**
     * @internal
     *
     * Build the internal serialzer
     *
     * @return ZugferdDocumentJsonExporter
     *
     * @codeCoverageIgnore
     */
    private function initSerialzer(): ZugferdDocumentJsonExporter
    {
        $serializerBuilder = SerializerBuilder::create();
        $this->serializerBuilder = $serializerBuilder;
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->document->profileDefinition["name"] . '/qdt', 'horstoeko\zugferd\entities\\' . $this->document->profileDefinition["name"] . '\qdt');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->document->profileDefinition["name"] . '/ram', 'horstoeko\zugferd\entities\\' . $this->document->profileDefinition["name"] . '\ram');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->document->profileDefinition["name"] . '/rsm', 'horstoeko\zugferd\entities\\' . $this->document->profileDefinition["name"] . '\rsm');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->document->profileDefinition["name"] . '/udt', 'horstoeko\zugferd\entities\\' . $this->document->profileDefinition["name"] . '\udt');
        $this->serializerBuilder->addDefaultListeners();
        $this->serializerBuilder->configureHandlers(
            function (HandlerRegistryInterface $handler) use ($serializerBuilder) {
                $serializerBuilder->addDefaultHandlers();
                $handler->registerSubscribingHandler(new BaseTypesHandler());
                $handler->registerSubscribingHandler(new XmlSchemaDateHandler());
                $handler->registerSubscribingHandler(new ZugferdTypesHandler());
            }
        );

        $this->serializer = $this->serializerBuilder->build();

        return $this;
    }
}
