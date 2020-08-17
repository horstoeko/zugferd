<?php

namespace horstoeko\zugferd;

use \GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use \GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use \JMS\Serializer\Handler\HandlerRegistryInterface;
use \JMS\Serializer\SerializerBuilder;

class ZugferdBase
{
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

    public function __construct()
    {
        $serializerBuilder = SerializerBuilder::create();
        $serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/qdt', 'horstoeko\zugferd\qdt');
        $serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/ram', 'horstoeko\zugferd\ram');
        $serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/rsm', 'horstoeko\zugferd\rsm');
        $serializerBuilder->addMetadataDir(dirname(__FILE__) . '/yaml/udt', 'horstoeko\zugferd\udt');
        $serializerBuilder->addDefaultListeners();
        $serializerBuilder->configureHandlers(function (HandlerRegistryInterface $handler) use ($serializerBuilder) {
            $serializerBuilder->addDefaultHandlers();
            $handler->registerSubscribingHandler(new BaseTypesHandler());
            $handler->registerSubscribingHandler(new XmlSchemaDateHandler());
        });
        $serializer = $serializerBuilder->build();

        $this->serializerBuilder = $serializerBuilder;
        $this->serializer = $serializer;
    }
}
