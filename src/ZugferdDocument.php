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
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
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
    private $profileId = -1;

    /**
     * @internal
     * @var      array  Internal profile definition
     */
    private $profileDefinition = [];

    /**
     * @internal
     * @var      SerializerBuilder  Serializer builder
     */
    private $serializerBuilder;

    /**
     * @internal
     * @var      SerializerInterface    Serializer
     */
    private $serializer;

    /**
     * @internal
     * @var      CrossIndustryInvoiceType   The internal invoice object
     */
    private $invoiceObject = null;

    /**
     * @internal
     * @var      ZugferdObjectHelper    Object Helper
     */
    private $objectHelper = null;

    /**
     * Constructor
     *
     * @param integer $profile
     * The ID of the profile of the document
     */
    final protected function __construct(int $profile)
    {
        $this->initProfile($profile);
        $this->initObjectHelper();
        $this->initSerialzer();
    }

    /**
     * Returns the internal invoice object (created by the
     * serializer). This is used e.g. in the validator
     *
     * @return \horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\minimum\rsm\CrossIndustryInvoice
     */
    public function getInvoiceObject()
    {
        return $this->invoiceObject;
    }


    /**
     * Sets the internal invoice object
     *
     * @param \horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\minimum\rsm\CrossIndustryInvoice $invoiceObject
     * @return self
     */
    public function setInvoiceObject($invoiceObject): self
    {
        $this->invoiceObject = $invoiceObject;
        return $this;
    }

    /**
     * Create a new instance of the internal invoice object
     *
     * @return \horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\minimum\rsm\CrossIndustryInvoice
     */
    protected function createInvoiceObject()
    {
        $this->invoiceObject = $this->getObjectHelper()->getCrossIndustryInvoice();

        return $this->invoiceObject;
    }

    /**
     * Get the instance of the internal serializuer
     *
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * Get object helper instance
     *
     * @return \horstoeko\zugferd\ZugferdObjectHelper
     */
    public function getObjectHelper()
    {
        return $this->objectHelper;
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
     * Get a parameter from profile definition
     *
     * @param  string $parameterName
     * @return mixed
     */
    public function getProfileDefinitionParameter(string $parameterName)
    {
        $profileDefinition = $this->getProfileDefinition();

        if (is_array($profileDefinition) && isset($profileDefinition[$parameterName])) {
            return $profileDefinition[$parameterName];
        }

        throw new ZugferdUnknownProfileParameterException($parameterName);
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
     *
     * @return ZugferdDocument
     */
    private function initSerialzer(): ZugferdDocument
    {
        $this->serializerBuilder = SerializerBuilder::create();

        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter("name"),
                'qdt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\qdt',
                $this->getProfileDefinitionParameter("name")
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter("name"),
                'ram'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\ram',
                $this->getProfileDefinitionParameter("name")
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter("name"),
                'rsm'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\rsm',
                $this->getProfileDefinitionParameter("name")
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter("name"),
                'udt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\udt',
                $this->getProfileDefinitionParameter("name")
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

    /**
     * Deserialize XML content to internal invoice object
     *
     * @param  string $xmlContent
     * @return \horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\basicwl\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice|\horstoeko\zugferd\entities\minimum\rsm\CrossIndustryInvoice
     */
    public function deserialize($xmlContent)
    {
        $this->invoiceObject = $this->getSerializer()->deserialize($xmlContent, 'horstoeko\zugferd\entities\\' . $this->getProfileDefinitionParameter("name") . '\rsm\CrossIndustryInvoice', 'xml');

        return $this->invoiceObject;
    }

    /**
     * Serialize internal invoice object as XML
     *
     * @return string
     */
    public function serializeAsXml(): string
    {
        return $this->getSerializer()->serialize($this->getInvoiceObject(), 'xml');
    }

    /**
     * Serialize internal invoice object as JSON
     *
     * @return string
     */
    public function serializeAsJson(): string
    {
        return $this->getSerializer()->serialize($this->getInvoiceObject(), 'json');
    }
}
