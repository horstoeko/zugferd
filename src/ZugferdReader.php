<?php

namespace horstoeko\zugferd;

use \GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use \GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use \JMS\Serializer\Handler\HandlerRegistryInterface;
use \JMS\Serializer\SerializerBuilder;

class ZugferdReader
{
    /**
     * Read content of a zuferd/xrechnung xml file
     *
     * @param string $xmlcontent
     * @return \horstoeko\zugferd\rsm\CrossIndustryInvoice
     */
    public static function ReadContent($xmlcontent)
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
        $object = $serializer->deserialize($xmlcontent, 'horstoeko\zugferd\rsm\CrossIndustryInvoice', 'xml');
        return $object;
    }
}
