<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

use \Exception;
use \SimpleXMLElement;
use \horstoeko\zugferd\ZugferdProfiles;

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
        $xmldocument = new SimpleXMLElement($xmlContent);
        $typeelement = $xmldocument->xpath('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (!is_array($typeelement) || !isset($typeelement[0])) {
            throw new Exception('Could not determine the profile...');
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

        throw new Exception('Could not determine the profile...');
    }

    /**
     * Resolve profile id by the content of $xmlContent
     *
     * @param string $xmlContent
     * @return int
     * @throws Exception
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
     * @throws Exception
     */
    public static function resolveProfileDef(string $xmlContent): array
    {
        return static::resolve($xmlContent)[1];
    }
}