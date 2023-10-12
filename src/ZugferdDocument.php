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
use horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoiceType;
use horstoeko\zugferd\jms\ZugferdTypesHandler;
use horstoeko\zugferd\ZugferdObjectHelper;
use horstoeko\zugferd\ZugferdProfileResolver;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

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
     * @var      integer    Internal profile id
     */
    public $profileId = -1;

    /**
     * @internal
     * @var      array  Internal profile definition
     */
    public $profileDefinition = [];

    /**
     * @internal
     * @var      SerializerBuilder  Serializer builder
     */
    protected $serializerBuilder;

    /**
     * @internal
     * @var      SerializerInterface    Serializer
     */
    protected $serializer;

    /**
     * @internal
     * @var      CrossIndustryInvoiceType   The internal invoice object
     */
    protected $invoiceObject = null;

    /**
     * @internal
     * @var      ZugferdObjectHelper    Object Helper
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
     * Returns the selected profile id
     *
     * @return integer
     */
    public function getProfileId(): int
    {
        return $this->profileId;
    }

    /**
     * Returns the profile definition
     *
     * @return array
     */
    public function getProfileDefinition(): array
    {
        return $this->profileDefinition;
    }

    /**
     * @internal
     *
     * Sets the internal profile definitions
     *
     * @param integer $profile
     * The internal id of the profile
     *
     * @return ZugferdDocument
     */
    private function initProfile(int $profile): ZugferdDocument
    {
        $this->profileId = $profile;
        $this->profileDefinition = ZugferdProfileResolver::resolveProfileDefById($profile);

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
        $this->objectHelper = new ZugferdObjectHelper($this->profileId);

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
        $this->serializerBuilder = SerializerBuilder::create();

        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinition()["name"],
                'qdt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\qdt',
                $this->getProfileDefinition()["name"]
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinition()["name"],
                'ram'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\ram',
                $this->getProfileDefinition()["name"]
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinition()["name"],
                'rsm'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\rsm',
                $this->getProfileDefinition()["name"]
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinition()["name"],
                'udt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\udt',
                $this->getProfileDefinition()["name"]
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
