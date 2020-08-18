<?php

namespace horstoeko\zugferd;

class ZugferdReader
{
    /**
     * Load from file
     *
     * @param string $xmlfilename
     * @return ZugferdDocument
     */
    public static function ReadFile($xmlfilename)
    {
        if (!file_exists($xmlfilename)) {
            throw new \Exception("File {$xmlfilename} does not exist...");
        }

        return self::ReadContent(file_get_contents($xmlfilename));
    }

    /**
     * Load from string
     *
     * @param string $xmlcontent
     * @return ZugferdDocument
     * @throws Exception
     */
    public static function ReadContent($xmlcontent): ZugferdDocument
    {
        $document = self::guessProfile($xmlcontent);
        $document->ReadContent($xmlcontent);
        return $document;
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @param string $xmlcontent
     * @return ZugferdDocument
     */
    private static function guessProfile(string $xmlcontent): ZugferdDocument
    {
        $xmldocument = new \SimpleXMLElement($xmlcontent);
        $typeelement = $xmldocument->xpath('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (is_array($typeelement) && isset($typeelement[0])) {
            if ($typeelement[0] == 'urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended') {
                return new ZugferdDocumentExtendedProfile();
            } else if ($typeelement[0] == 'urn:cen.eu:en16931:2017') {
                return new ZugferdDocumentEn16931Profile();
            } else if ($typeelement[0] == 'urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic') {
                return new ZugferdDocumentBasicProfile();
            }
        }

        throw new \Exception('Coult not determaine the profile...');
    }

}
