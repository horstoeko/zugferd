<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\rsm\CrossIndustryInvoice;
use horstoeko\zugferd\ZugferdBase;

class ZugferdWriter extends ZugferdBase
{
    /**
     * Write the content of a CrossIndustryInvoice object to a string
     *
     * @param CrossIndustryInvoice $invoice
     * @return string
     */
    public function WriteToString(CrossIndustryInvoice $invoice): string
    {
        return $this->serializer->serialize($invoice, 'xml');
    }

    /**
     * Write the content of a CrossIndustryInvoice object to a file
     *
     * @param CrossIndustryInvoice $invoice
     * @param string $xmlfilename
     * @return void
     */
    public function WriteToFile(CrossIndustryInvoice $invoice, string $xmlfilename)
    {
        $xmlcontent = $this->WriteToString($invoice);
        file_put_contents($xmlfilename, $xmlcontent);
    }
}
