<?php

declare(strict_types=1);

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
use horstoeko\zugferd\entities\basic\rsm\CrossIndustryInvoice;
use horstoeko\zugferd\exception\ZugferdUnknownProfileIdException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use horstoeko\zugferd\jms\ZugferdTypesHandler;
use JMS\Serializer\Exception\InvalidArgumentException;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

/**
 * Class representing the document basics
 *
 * @category Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @see      https://github.com/horstoeko/zugferd
 *
 * @phpstan-import-type ZugferdProfileDefinition from ZugferdProfiles
 */
class ZugferdDocument
{
    /**
     * @var int Internal profile id
     */
    private $profileId = -1;

    /**
     * @var array{}|ZugferdProfileDefinition Internal profile definition
     */
    private $profileDefinition = [];

    /**
     * @var SerializerBuilder Serializer builder
     */
    private $serializerBuilder;

    /**
     * @var SerializerInterface Serializer
     */
    private $serializer;

    /**
     * @var CrossIndustryInvoice|entities\basicwl\rsm\CrossIndustryInvoice|entities\en16931\rsm\CrossIndustryInvoice|entities\extended\rsm\CrossIndustryInvoice|entities\minimum\rsm\CrossIndustryInvoice The internal invoice object
     */
    private $invoiceObject;

    /**
     * @var ZugferdObjectHelper Object Helper
     */
    private $objectHelper;

    /**
     * Constructor
     *
     * @param int $profile The ID of the profile of the document
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     */
    final protected function __construct(int $profile)
    {
        $this->initProfile($profile);
        $this->initObjectHelper();
        $this->initSerialzer();
    }

    /**
     * Returns the selected profile id
     *
     * @return int
     */
    public function getProfileId(): int
    {
        return $this->profileId;
    }

    /**
     * Returns the profile definition
     *
     * @return array{}|ZugferdProfileDefinition
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
     *
     * @throws ZugferdUnknownProfileParameterException
     */
    public function getProfileDefinitionParameter(string $parameterName)
    {
        $profileDefinition = $this->getProfileDefinition();

        if (isset($profileDefinition[$parameterName])) {
            return $profileDefinition[$parameterName];
        }

        throw new ZugferdUnknownProfileParameterException($parameterName);
    }

    /**
     * Deserialize XML content to internal invoice object
     *
     * @param  mixed                                                                                                                                                                                         $xmlContent
     * @return CrossIndustryInvoice|entities\basicwl\rsm\CrossIndustryInvoice|entities\en16931\rsm\CrossIndustryInvoice|entities\extended\rsm\CrossIndustryInvoice|entities\minimum\rsm\CrossIndustryInvoice
     *
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileParameterException
     */
    public function deserialize($xmlContent)
    {
        $this->invoiceObject = $this->getSerializer()->deserialize($xmlContent, 'horstoeko\zugferd\entities\\' . $this->getProfileDefinitionParameter('name') . '\rsm\CrossIndustryInvoice', 'xml');

        return $this->invoiceObject;
    }

    /**
     * Serialize internal invoice object as XML
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function serializeAsXml(): string
    {
        return $this->getSerializer()->serialize($this->getInvoiceObject(), 'xml');
    }

    /**
     * Serialize internal invoice object as JSON
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function serializeAsJson(): string
    {
        return $this->getSerializer()->serialize($this->getInvoiceObject(), 'json');
    }

    /**
     * Returns the internal invoice object (created by the serializer). This is used e.g. in the validator
     *
     * @return CrossIndustryInvoice|entities\basicwl\rsm\CrossIndustryInvoice|entities\en16931\rsm\CrossIndustryInvoice|entities\extended\rsm\CrossIndustryInvoice|entities\minimum\rsm\CrossIndustryInvoice
     */
    public function getInvoiceObject()
    {
        return $this->invoiceObject;
    }

    /**
     * Create a new instance of the internal invoice object
     *
     * @return CrossIndustryInvoice|entities\basicwl\rsm\CrossIndustryInvoice|entities\en16931\rsm\CrossIndustryInvoice|entities\extended\rsm\CrossIndustryInvoice|entities\minimum\rsm\CrossIndustryInvoice
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
    protected function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * Get object helper instance
     *
     * @return ZugferdObjectHelper
     */
    protected function getObjectHelper()
    {
        return $this->objectHelper;
    }

    /**
     * Sets the internal profile definitions
     *
     * @param  int             $profile
     * @return ZugferdDocument
     *
     * @throws ZugferdUnknownProfileIdException
     */
    protected function initProfile(int $profile): self
    {
        $this->profileId = $profile;
        $this->profileDefinition = ZugferdProfileResolver::resolveProfileDefById($profile);

        return $this;
    }

    /**
     * Build the internal object helper
     *
     * @return ZugferdDocument
     *
     * @throws ZugferdUnknownProfileIdException
     */
    protected function initObjectHelper(): self
    {
        $this->objectHelper = new ZugferdObjectHelper($this->profileId);

        return $this;
    }

    /**
     * Build the internal serialzer
     *
     * @return ZugferdDocument
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileParameterException
     */
    protected function initSerialzer(): self
    {
        $this->serializerBuilder = SerializerBuilder::create();

        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter('name'),
                'qdt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\qdt',
                $this->getProfileDefinitionParameter('name')
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter('name'),
                'ram'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\ram',
                $this->getProfileDefinitionParameter('name')
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter('name'),
                'rsm'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\rsm',
                $this->getProfileDefinitionParameter('name')
            )
        );
        $this->serializerBuilder->addMetadataDir(
            PathUtils::combineAllPaths(
                ZugferdSettings::getYamlDirectory(),
                $this->getProfileDefinitionParameter('name'),
                'udt'
            ),
            sprintf(
                'horstoeko\zugferd\entities\%s\udt',
                $this->getProfileDefinitionParameter('name')
            )
        );

        if (ZugferdSettings::hasSerializerCacheDirectory()) {
            $this->serializerBuilder->setCacheDir(ZugferdSettings::getSerializerCacheDirectory());
        }

        $this->serializerBuilder->addDefaultListeners();
        $this->serializerBuilder->addDefaultHandlers();

        $this->serializerBuilder->configureHandlers(
            static function (HandlerRegistryInterface $handler): void {
                $handler->registerSubscribingHandler(new BaseTypesHandler());
                $handler->registerSubscribingHandler(new XmlSchemaDateHandler());
                $handler->registerSubscribingHandler(new ZugferdTypesHandler());
            }
        );

        $this->serializer = $this->serializerBuilder->build();

        return $this;
    }
}
