<?php

namespace horstoeko\zugferd;

use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\BaseTypesHandler;
use GoetasWebservices\Xsd\XsdToPhpRuntime\Jms\Handler\XmlSchemaDateHandler;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class ZugferdDocument
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

    /**
     * The internal invoice object
     *
     * @var object
     */
    protected $invoiceObject = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $serializerBuilder = SerializerBuilder::create();
        $this->serializerBuilder = $serializerBuilder;

        $this->initSerializerBuilder();

        $this->serializerBuilder->addDefaultListeners();
        $this->serializerBuilder->configureHandlers(function (HandlerRegistryInterface $handler) use ($serializerBuilder) {
            $serializerBuilder->addDefaultHandlers();
            $handler->registerSubscribingHandler(new BaseTypesHandler());
            $handler->registerSubscribingHandler(new XmlSchemaDateHandler());
        });

        $this->serializer = $this->serializerBuilder->build();
    }

    /**
     * Initialize the serializerBuilder
     *
     * @return void
     */
    protected function initSerializerBuilder()
    {
        throw new \Exception('You must implement the method initSerializerBuilder in derived classes of ZugferdDocument');
    }

    /**
     * Returns the classname of the invoice object type
     *
     * @return string
     */
    protected function getInvoiceObjectClass()
    {
        throw new \Exception('You must implement the method getInvoiceObjectClass in derived classes of ZugferdDocument');
    }

    /**
     * Read content of a zuferd/xrechnung xml from a string
     *
     * @param string $xmlcontent
     * @return object
     */
    public function ReadContent($xmlcontent)
    {
        $this->invoiceObject = $this->serializer->deserialize($xmlcontent, $this->getInvoiceObjectClass(), 'xml');
        return $this->invoiceObject;
    }

    /**
     * Read content of a zuferd/xrechnung xml from a file
     *
     * @param string $xmlfilename
     * @return \horstoeko\zugferd\rsm\CrossIndustryInvoice
     */
    public function ReadFile($xmlfilename)
    {
        if (!file_exists($xmlfilename)) {
            throw new \Exception("File {$xmlfilename} does not exist...");
        }

        return $this->ReadContent(file_get_contents($xmlfilename));
    }
    
    /**
     * Write the content of a CrossIndustryInvoice object to a string
     *
     * @return string
     */
    public function WriteContent(): string
    {
        return $this->serializer->serialize($this->invoiceObject, 'xml');
    }

    /**
     * Write the content of a CrossIndustryInvoice object to a file
     *
     * @param CrossIndustryInvoice $invoice
     * @param string $xmlfilename
     * @return void
     */
    public function WriteFile(string $xmlfilename)
    {
        $xmlcontent = $this->WriteContent();
        file_put_contents($xmlfilename, $xmlcontent);
    }
}
