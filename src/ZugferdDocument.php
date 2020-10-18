<?php

namespace horstoeko\zugferd;

use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use horstoeko\zugferd\ZugferdObjectHelper;

/**
 * Class representing the document basics
 */
class ZugferdDocument
{
    /**
     * Internal profile id (see ZugferdProfiles.php)
     *
     * @var integer
     */
    public $profile = -1;

    /**
     * Internal profile definition (see ZugferdProfiles.php)
     *
     * @var array
     */
    public $profiledef = [];

    /**
     * Serializer builder
     *
     * @var SerializerBuilder
     */
    protected $serializerBuilder;

    /**
     * Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * The internal invoice object
     *
     * @var \horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoiceType
     */
    protected $invoiceObject = null;

    /**
     * Object Helper
     *
     * @var ZugferdObjectHelper
     */
    protected $objectHelper = null;

    /**
     * Constructor
     * @codeCoverageIgnore
     */
    public function __construct(int $profile)
    {
        $this->profile = $profile;
        $this->profiledef = ZugferdProfiles::PROFILEDEF[$profile];
        $this->objectHelper = new ZugferdObjectHelper($profile);

        $this->initSerialzer();
    }

    /**
     * Returns the internal invoice object (created by the
     * serializer). This is used e.g. in the validator
     *
     * @return object
     */
    public function getInvoiceObject()
    {
        return $this->invoiceObject;
    }

    /**
     * Build the internal serialzer
     * @codeCoverageIgnore
     * @return void
     */
    private function initSerialzer(): void
    {
        $serializerBuilder = SerializerBuilder::create();
        $this->serializerBuilder = $serializerBuilder;
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->profiledef["name"] . '/qdt', 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\qdt');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->profiledef["name"] . '/ram', 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\ram');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->profiledef["name"] . '/rsm', 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\rsm');
        $this->serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/' . $this->profiledef["name"] . '/udt', 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\udt');
        $this->serializerBuilder->addDefaultListeners();
        $this->serializerBuilder->configureHandlers(function (HandlerRegistryInterface $handler) use ($serializerBuilder) {
            $serializerBuilder->addDefaultHandlers();
            $handler->registerSubscribingHandler(new BaseTypesHandler());
            $handler->registerSubscribingHandler(new XmlSchemaDateHandler());
        });

        $this->serializer = $this->serializerBuilder->build();
    }
}
