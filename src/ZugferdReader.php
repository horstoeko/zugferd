<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\ZugferdBase;

class ZugferdReader extends ZugferdBase
{
    /**
     * Read content of a zuferd/xrechnung xml from a string
     *
     * @param string $xmlcontent
     * @return \horstoeko\zugferd\rsm\CrossIndustryInvoice
     */
    public function ReadContent($xmlcontent)
    {
        return $this->serializer->deserialize($xmlcontent, 'horstoeko\zugferd\rsm\CrossIndustryInvoice', 'xml');
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
}
