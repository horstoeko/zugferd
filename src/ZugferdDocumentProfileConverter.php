<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use horstoeko\zugferd\exception\ZugferdFileNotFoundException;
use horstoeko\zugferd\exception\ZugferdFileNotReadableException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileIdException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileParameterException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;
use JMS\Serializer\Exception\InvalidArgumentException;
use JMS\Serializer\Exception\RuntimeException;

/**
 * Class representing a converter to change a document's profile to another profile
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdDocumentProfileConverter extends ZugferdDocument
{
    /**
     * The source
     *
     * @var string
     */
    protected $fromContent;

    /**
     * The new profile ID
     *
     * @var int
     */
    protected $newProfileId;

    /**
     * Path to the profile id
     */
    protected const PATH_1 = 'getExchangedDocumentContext.getGuidelineSpecifiedDocumentContextParameter.setID';

    /**
     * Path to the context parameter
     */
    protected const PATH_2 = 'getExchangedDocumentContext.setBusinessProcessSpecifiedDocumentContextParameter';

    /**
     * Path to the context parameter id
     */
    protected const PATH_3 = 'getExchangedDocumentContext.getBusinessProcessSpecifiedDocumentContextParameter.setID';

    /**
     * Convert from file to file
     *
     * @param  string $fromFilename
     * @param  string $toFile
     * @param  int    $newProfileId
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    public static function fromFileToFile(string $fromFilename, string $toFile, int $newProfileId): void
    {
        static::fromFile($fromFilename, $newProfileId)->convertToFile($toFile);
    }

    /**
     * Convert from file to string
     *
     * @param  string $fromFilename
     * @param  int    $newProfileId
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    public static function fromFileToString(string $fromFilename, int $newProfileId): string
    {
        return static::fromFile($fromFilename, $newProfileId)->convertToString();
    }

    /**
     * Convert from content to file
     *
     * @param  string $fromContent
     * @param  string $toFile
     * @param  int    $newProfileId
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    public static function fromContentToFile(string $fromContent, string $toFile, int $newProfileId): void
    {
        static::fromContent($fromContent, $newProfileId)->convertToFile($toFile);
    }

    /**
     * Convert from content to string
     *
     * @param  string $fromContent
     * @param  int    $newProfileId
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     * @throws ZugferdUnknownXmlContentException
     */
    public static function fromContentToString(string $fromContent, int $newProfileId): string
    {
        return static::fromContent($fromContent, $newProfileId)->convertToString();
    }

    /**
     * Create an instance by filename
     *
     * @param  string $fromFilename
     * @param  int    $newProfileId
     * @return ZugferdDocumentProfileConverter
     * @throws ZugferdFileNotFoundException
     * @throws ZugferdFileNotReadableException
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     */
    protected static function fromFile(string $fromFilename, int $newProfileId): ZugferdDocumentProfileConverter
    {
        if (!file_exists($fromFilename)) {
            throw new ZugferdFileNotFoundException($fromFilename);
        }

        $fromContent = file_get_contents($fromFilename);

        if ($fromContent === false) {
            throw new ZugferdFileNotReadableException($fromFilename);
        }

        return static::fromContent($fromContent, $newProfileId);
    }

    /**
     * Create an instance by cpntent
     *
     * @param  string $fromContent
     * @param  int    $newProfileId
     * @return ZugferdDocumentProfileConverter
     * @throws ZugferdUnknownXmlContentException
     * @throws ZugferdUnknownProfileException
     */
    protected static function fromContent(string $fromContent, int $newProfileId): ZugferdDocumentProfileConverter
    {
        $fromProfileId = ZugferdProfileResolver::resolveProfileId($fromContent);

        $profileConverter = new static($fromProfileId);
        $profileConverter->setFromContent($fromContent);
        $profileConverter->setNewProfileId($newProfileId);

        return $profileConverter;
    }

    /**
     * Set the destination (the new) profile id
     *
     * @param  int $newProfileId
     * @return ZugferdDocumentProfileConverter
     */
    protected function setNewProfileId(int $newProfileId): ZugferdDocumentProfileConverter
    {
        $this->newProfileId = $newProfileId;

        return $this;
    }

    /**
     * Set the source-content
     *
     * @param  string $fromContent
     * @return ZugferdDocumentProfileConverter
     */
    protected function setFromContent(string $fromContent): ZugferdDocumentProfileConverter
    {
        $this->fromContent = $fromContent;

        return $this;
    }

    /**
     * Convert and save to file
     *
     * @param  string $toFile
     * @return ZugferdDocumentProfileConverter
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     */
    protected function convertToFile(string $toFile): ZugferdDocumentProfileConverter
    {
        file_put_contents($toFile, $this->convert()->convertToString());

        return $this;
    }

    /**
     * Convert and get xml content as string
     *
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     */
    protected function convertToString(): string
    {
        return $this->convert()->serializeAsXml();
    }

    /**
     * Internal conversion method
     *
     * @return ZugferdDocumentProfileConverter
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws ZugferdUnknownProfileIdException
     * @throws ZugferdUnknownProfileParameterException
     */
    protected function convert(): ZugferdDocumentProfileConverter
    {
        $this->initProfile($this->newProfileId);
        $this->initObjectHelper();
        $this->initSerialzer();
        $this->deserialize($this->fromContent);
        $this->updateProfileInInvoiceObject();

        return $this;
    }

    /**
     * Update profile parameters in the internal invoice object
     *
     * @return void
     * @throws ZugferdUnknownProfileIdException
     */
    protected function updateProfileInInvoiceObject()
    {
        $profileDef = ZugferdProfileResolver::resolveProfileDefById($this->newProfileId);

        $this->getObjectHelper()->tryCallByPath(
            $this->getInvoiceObject(),
            static::PATH_1,
            $this->getObjectHelper()->getIdType($profileDef['contextparameter'])
        );

        if ($profileDef['businessprocess']) {
            $this->getObjectHelper()->tryCallByPath(
                $this->getInvoiceObject(),
                static::PATH_2,
                $this->getObjectHelper()->createClassInstance('ram\DocumentContextParameterType')
            );
            $this->getObjectHelper()->tryCallByPath(
                $this->getInvoiceObject(),
                static::PATH_3,
                $this->getObjectHelper()->getIdType($profileDef['businessprocess'])
            );
        }
    }
}
