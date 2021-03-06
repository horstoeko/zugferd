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
use \horstoeko\zugferd\ZugferdObjectHelper;
use \horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoiceType;
use \horstoeko\zugferd\jms\ZugferdTypesHandler;
use \JMS\Serializer\Handler\HandlerRegistryInterface;
use \JMS\Serializer\SerializerBuilder;
use \JMS\Serializer\SerializerInterface;

/**
 * Class representing the document basics
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocument
{
    /**
     * @internal
     * Internal profile id (see ZugferdProfiles.php)
     * @var integer
     */
    public $profile = -1;

    /**
     * @internal
     * Internal profile definition (see ZugferdProfiles.php)
     * @var array
     */
    public $profiledef = [];

    /**
     * @internal
     * Serializer builder
     * @var SerializerBuilder
     */
    protected $serializerBuilder;

    /**
     * @internal
     * Serializer
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @internal
     * The internal invoice object
     * @var CrossIndustryInvoiceType
     */
    protected $invoiceObject = null;

    /**
     * @internal
     * Object Helper
     * @var ZugferdObjectHelper
     */
    protected $objectHelper = null;

    /**
     * Constructor
     *
     * @param integer $profile
     * The ID of the profile of the document
     *
     * @codeCoverageIgnore
     */
    public function __construct(int $profile)
    {
        $this->initProfile($profile);
        $this->initObjectHelper();
        $this->initSerialzer();
    }

    /**
     * @internal
     *
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
     * @internal
     *
     * Sets the internal profile definitions
     *
     * @param integer $profile
     * The internal id of the profile (see ZugferdProfiles.php)
     *
     * @return ZugferdDocument
     */
    private function initProfile(int $profile): ZugferdDocument
    {
        $this->profile = $profile;
        $this->profiledef = ZugferdProfiles::PROFILEDEF[$profile];

        return $this;
    }

    /**
     * @internal
     *
     * Build the internal object helper
     * @codeCoverageIgnore
     *
     * @return ZugferdDocument
     */
    private function initObjectHelper(): ZugferdDocument
    {
        $this->objectHelper = new ZugferdObjectHelper($this->profile);

        return $this;
    }

    /**
     * @internal
     *
     * Build the internal serialzer
     * @codeCoverageIgnore
     *
     * @return ZugferdDocument
     */
    private function initSerialzer(): ZugferdDocument
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
            $handler->registerSubscribingHandler(new ZugferdTypesHandler());
        });

        $this->serializer = $this->serializerBuilder->build();

        return $this;
    }
}
