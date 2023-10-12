<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use horstoeko\stringmanagement\PathUtils;
use horstoeko\zugferd\jms\ZugferdTypesHandler;
use JMS\Serializer\Exception\RuntimeException as ExceptionRuntimeException;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use stdClass;

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
     * @return null|stdClass
     * @throws ExceptionRuntimeException
     */
    public function toJsonObject(): ?\stdClass
    {
        $jsonObject = json_decode($this->toJsonString());

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
        $this->serializerBuilder = SerializerBuilder::create();

        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->document->getProfileDefinition()["name"],
                'qdt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\qdt',
                $this->document->getProfileDefinition()["name"]
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->document->getProfileDefinition()["name"],
                'ram'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\ram',
                $this->document->getProfileDefinition()["name"]
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->document->getProfileDefinition()["name"],
                'rsm'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\rsm',
                $this->document->getProfileDefinition()["name"]
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->document->getProfileDefinition()["name"],
                'udt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\udt',
                $this->document->getProfileDefinition()["name"]
            )
        );

        $this->serializerBuilder->addDefaultListeners();
        $this->serializerBuilder->addDefaultHandlers();

        $this->serializerBuilder->configureHandlers(
            function (HandlerRegistryInterface $handler) {
                $handler->registerSubscribingHandler(new BaseTypesHandler());
                $handler->registerSubscribingHandler(new XmlSchemaDateHandler());
                $handler->registerSubscribingHandler(new ZugferdTypesHandler());
            }
        );

        $this->serializer = $this->serializerBuilder->build();

        return $this;
    }
}
