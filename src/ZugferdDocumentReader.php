<?php

namespace horstoeko\zugferd;

/**
 * Class representing the document reader for incoming documents
 */
class ZugferdDocumentReader extends ZugferdDocument
{

    /**
     * Guess the profile type of a xml file
     *
     * @param string $xmlfilename
     * @return ZugferdDocument
     * @throws Exception
     */
    public static function ReadAndGuessFromFile(string $xmlfilename): ZugferdDocumentReader
    {
        if (!file_exists($xmlfilename)) {
            throw new \Exception("File {$xmlfilename} does not exist...");
        }

        return self::ReadAndGuessFromContent(file_get_contents($xmlfilename));
    }

    /**
     * Guess the profile type of the readden xml document
     *
     * @param string $xmlcontent
     * @return ZugferdDocumentReader
     * @throws Exception
     */
    public static function ReadAndGuessFromContent(string $xmlcontent): ZugferdDocumentReader
    {
        $xmldocument = new \SimpleXMLElement($xmlcontent);
        $typeelement = $xmldocument->xpath('/rsm:CrossIndustryInvoice/rsm:ExchangedDocumentContext/ram:GuidelineSpecifiedDocumentContextParameter/ram:ID');

        if (!is_array($typeelement) || !isset($typeelement[0])) {
            throw new \Exception('Coult not determaine the profile...');
        }

        foreach (ZugferdProfiles::PROFILEDEF as $profile => $profiledef) {
            if ($typeelement[0] == $profiledef["contextparameter"]) {
                return (new self($profile))->ReadContent($xmlcontent);
            }
        }

        throw new \Exception('Could not determine the profile...');
    }

    /**
     * Read content of a zuferd/xrechnung xml from a string
     *
     * @param string $xmlcontent
     * @return ZugferdDocumentReader
     */
    public function ReadContent(string $xmlcontent): ZugferdDocumentReader
    {
        $this->invoiceObject = $this->serializer->deserialize($xmlcontent, 'horstoeko\zugferd\entities\\' . $this->profiledef["name"] . '\rsm\CrossIndustryInvoice', 'xml');
        return $this;
    }

    /**
     * Read content of a zuferd/xrechnung xml from a file
     *
     * @param string $xmlfilename
     * @return ZugferdDocumentReader
     */
    public function ReadFile(string $xmlfilename): ZugferdDocumentReader
    {
        if (!file_exists($xmlfilename)) {
            throw new \Exception("File {$xmlfilename} does not exist...");
        }

        return $this->ReadContent(file_get_contents($xmlfilename));
    }

    /**
     * Read general information about the document
     *
     * @param string $documentno
     * @param string $documenttypecode
     * @param \DateTime $documentdate
     * @param \DateTime $duedate
     * @param string $invoiceCurrency
     * @param string $documentname
     * @param string $documentlanguage
     * @param \DateTime $effectiveSpecifiedPeriod
     * @return ZugferdDocumentReader
     */
    public function GetDocumentInformation(?string &$documentno, ?string &$documenttypecode, ?\DateTime &$documentdate, ?\DateTime &$duedate, ?string &$invoiceCurrency, ?string &$documentname, ?string &$documentlanguage, ?\DateTime &$effectiveSpecifiedPeriod): ZugferdDocumentReader
    {
        $documentno = $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, "getExchangedDocument.getID");
        $documenttypecode = $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, "getExchangedDocument.getTypeCode.value");
        $documentdate = $this->objectHelper->ToDateTime(
            $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, "getExchangedDocument.getIssueDateTime.getDateTimeString") ?? "",
            $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, "getExchangedDocument.getIssueDateTime.getDateTimeString.getFormat") ?? ""
        );
        $invoiceCurrency = $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, "getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value");
        return $this;
    }
}
