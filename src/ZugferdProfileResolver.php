<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use SimpleXMLElement;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
use horstoeko\zugferd\exception\ZugferdUnknownProfileIdException;
use horstoeko\zugferd\exception\ZugferdUnknownXmlContentException;

/**
 * Class representing the profile resolver
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdProfileResolver
{
    /**
     * Resolve profile id and profile definition by the content of $xmlContent
     *
     * @param string $xmlContent
     * @return array
     */
    public static function resolve(string $xmlContent): array
    {
        try {
            $xmldocument = new SimpleXMLElement($xmlContent);
            $typeelement = $xmldocument->xpath('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');
        } catch (\Throwable $e) {
            throw new ZugferdUnknownXmlContentException();
        }

        if (!is_array($typeelement) || !isset($typeelement[0])) {
            throw new ZugferdUnknownXmlContentException();
        }

        /**
         * @var int $profile
         * @var array $profiledef
         */
        foreach (ZugferdProfiles::PROFILEDEF as $profile => $profiledef) {
            if ($typeelement[0] == $profiledef["contextparameter"]) {
                return [$profile, $profiledef];
            }
        }

        throw new ZugferdUnknownProfileException((string)$typeelement[0]);
    }

    /**
     * Resolve profile id by the content of $xmlContent
     *
     * @param string $xmlContent
     * @return int
     */
    public static function resolveProfileId(string $xmlContent): int
    {
        return static::resolve($xmlContent)[0];
    }

    /**
     * Resolve profile definition by the content of $xmlContent
     *
     * @param string $xmlContent
     * @return array
     */
    public static function resolveProfileDef(string $xmlContent): array
    {
        return static::resolve($xmlContent)[1];
    }

    /**
     * Resolve profile id and profile definition by it's id
     *
     * @param integer $profileId
     * @return array
     */
    public static function resolveById(int $profileId): array
    {
        if (!isset(ZugferdProfiles::PROFILEDEF[$profileId])) {
            throw new ZugferdUnknownProfileIdException($profileId);
        }

        return [$profileId, ZugferdProfiles::PROFILEDEF[$profileId]];
    }

    /**
     * Resolve profile profile definition by it's id
     *
     * @param int $profileId
     * @return array
     */
    public static function resolveProfileDefById(int $profileId): array
    {
        $resolved = static::resolveById($profileId);

        return $resolved[1];
    }
}
