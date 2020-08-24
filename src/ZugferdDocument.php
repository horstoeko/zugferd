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
     * Constructor
     */
    public function __construct(int $profile)
    {
        $this->profile = $profile;
        $this->profiledef = ZUgferdProfiles::PROFILEDEF[$profile];

        $this->initSerialzer();
    }

    /**
     * Build the internal serialzer
     *
     * @return void
     */
    private function initSerialzer()
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

    /**
     * Guess the profile type of a xml file
     *
     * @param string $xmlfilename
     * @return ZugferdDocument
     * @throws Exception
     */
    public static function ReadAndGuessFromFile(string $xmlfilename): ZugferdDocument
    {
        if (!file_exists($xmlfilename)) {
            throw new \Exception("File {$xmlfilename} does not exist...");
        }

        return self::ReadAndGuessFromContent(file_get_contents($xmlfilename));
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @param string $xmlcontent
     * @return ZugferdDocument
     * @throws Exception
     */
    public static function ReadAndGuessFromContent(string $xmlcontent): ZugferdDocument
    {
        $xmldocument = new \SimpleXMLElement($xmlcontent);
        $typeelement = $xmldocument->xpath('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (!is_array($typeelement) || !isset($typeelement[0])) {
            throw new \Exception('Coult not determaine the profile...');
        }

        foreach (ZUgferdProfiles::PROFILEDEF as $profile => $profiledef) {
            if ($typeelement[0] == $profiledef["contextparameter"]) {
                return (new self($profile))->ReadContent($xmlcontent);
            }
        }

        throw new \Exception('Could not determine the profile...');
    }

    /**
     * Read content of a zuferd/xrechnung xml from a string
     *
     * @param string $xmlcontent
     * @return ZugferdDocument
     */
    public function ReadContent(string $xmlcontent): ZugferdDocument
    {
        $this->invoiceObject = $this->serializer->deserialize($xmlcontent, 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\rsm\CrossIndustryInvoice', 'xml');
        return $this;
    }

    /**
     * Read content of a zuferd/xrechnung xml from a file
     *
     * @param string $xmlfilename
     * @return ZugferdDocument
     */
    public function ReadFile(string $xmlfilename): ZugferdDocument
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
    public function GetContent(): string
    {
        return $this->serializer->serialize($this->invoiceObject, 'xml');
    }

    /**
     * Write the content of a CrossIndustryInvoice object to a file
     *
     * @param string $xmlfilename
     * @return ZugferdDocument
     */
    public function WriteFile(string $xmlfilename): ZugferdDocument
    {
        file_put_contents($xmlfilename, $this->GetContent());
        return $this;
    }

    /**
     * Getters and setters for internal variables
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        switch (strtolower($name)) {
            case "profile":
                return $this->profile;
            case "profiledef":
                return $this->profiledef;
            case "profilename":
                return $this->profiledef["name"];
            case "profilecontextparameter":
                return $this->profiledef["contextparameter"];
        }
    }
}
