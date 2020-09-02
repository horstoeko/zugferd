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
     * @param string|null $documentno
     * @param string|null $documenttypecode
     * @param \DateTime|null $documentdate
     * @param \DateTime|null $duedate
     * @param string|null $invoiceCurrency
     * @param string|null $documentname
     * @param string|null $documentlanguage
     * @param \DateTime|null $effectiveSpecifiedPeriod
     * @return ZugferdDocumentReader
     */
    public function GetDocumentInformation(?string &$documentno, ?string &$documenttypecode, ?\DateTime &$documentdate, ?\DateTime &$duedate, ?string &$invoiceCurrency, ?string &$documentname, ?string &$documentlanguage, ?\DateTime &$effectiveSpecifiedPeriod): ZugferdDocumentReader
    {
        $documentno = $this->getInvoiceValueByPath("getExchangedDocument.getID", "");
        $documenttypecode = $this->getInvoiceValueByPath("getExchangedDocument.getTypeCode.value", "");
        $documentdate = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getIssueDateTime.getDateTimeString.getFormat", "")
        );
        $invoiceCurrency = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");
        $documentname = $this->getInvoiceValueByPath("getExchangedDocument.getName.value", "");
        $documentlanguages = $this->getInvoiceValueByPath("getExchangedDocument.getLanguageID", []);
        $documentlanguage = (isset($documentlanguages[0]) ? $this->objectHelper->TryCallByPathAndReturn($documentlanguages[0], "value") : "");
        $effectiveSpecifiedPeriod = $this->objectHelper->ToDateTime(
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString", ""),
            $this->getInvoiceValueByPath("getExchangedDocument.getEffectiveSpecifiedPeriod.getDateTimeString.getFormat", "")
        );
        return $this;
    }

    /**
     * Read general payment information
     *
     * @param string|null $creditorReferenceID
     * @param string|null $paymentReference
     * @return ZugferdDocumentReader
     */
    public function GetDocumentGeneralPaymentInformation(?string &$creditorReferenceID, ?string &$paymentReference): ZugferdDocumentReader
    {
        $creditorReferenceID = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getCreditorReferenceID.value", "");
        $paymentReference = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getPaymentReference.value", "") ?? "";
        return $this;
    }

    /**
     * Read copy indicator
     *
     * @param boolean|null $copyindicator
     * @return ZugferdDocumentReader
     */
    public function GetIsDocumentCopy(?bool &$copyindicator): ZugferdDocumentReader
    {
        $copyindicator = $this->getInvoiceValueByPath("getExchangedDocument.getCopyIndicator.getIndicator", false);
        return $this;
    }

    /**
     * Read a test document indicator
     *
     * @param boolean|null $testdocumentindicator
     * @return ZugferdDocumentReader
     */
    public function GetIsTestDocument(?bool &$testdocumentindicator): ZugferdDocumentReader
    {
        $testdocumentindicator = $this->getInvoiceValueByPath("getExchangedDocumentContext.getTestIndicator.getIndicator", false);
        return $this;
    }

    /**
     * Read Document money summation
     *
     * @param float|null $grandTotalAmount
     * @param float|null $duePayableAmount
     * @param float|null $lineTotalAmount
     * @param float|null $chargeTotalAmount
     * @param float|null $allowanceTotalAmount
     * @param float|null $taxBasisTotalAmount
     * @param float|null $taxTotalAmount
     * @param float|null $roundingAmount
     * @param float|null $totalPrepaidAmount
     * @return ZugferdDocumentReader
     */
    public function GetDocumentSummation(?float &$grandTotalAmount, ?float &$duePayableAmount, ?float &$lineTotalAmount, ?float &$chargeTotalAmount, ?float &$allowanceTotalAmount, ?float &$taxBasisTotalAmount, ?float &$taxTotalAmount, ?float &$roundingAmount, ?float &$totalPrepaidAmount): ZugferdDocumentReader
    {
        $invoiceCurrencyCode = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getInvoiceCurrencyCode.value", "");

        $grandTotalAmountElement = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getGrandTotalAmount", 0);
        if (is_array($grandTotalAmountElement)) {
            foreach($grandTotalAmountElement as $grandTotalAmountElementItem)
            {
                $grandTotalAmountCurrencyCode = $this->objectHelper->TryCallAndReturn($grandTotalAmountElementItem, "getCurrencyID") ?? "";
                if ($grandTotalAmountCurrencyCode == $invoiceCurrencyCode || $grandTotalAmountCurrencyCode == "") {
                    $grandTotalAmount = $this->objectHelper->TryCallAndReturn($grandTotalAmountElementItem, "value") ?? 0;
                    break;
                }
            }
        } else {
            $grandTotalAmount = $this->objectHelper->TryCallAndReturn($grandTotalAmountElement, "value") ?? 0;
        }

        $duePayableAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getDuePayableAmount.value", 0);
        $lineTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getLineTotalAmount.value", 0);
        $chargeTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getChargeTotalAmount.value", 0);
        $allowanceTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getAllowanceTotalAmount.value", 0);

        $taxBasisTotalAmountElement = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxBasisTotalAmount", 0);
        if (is_array($taxBasisTotalAmountElement)) {
            foreach($taxBasisTotalAmountElement as $taxBasisTotalAmountElementItem)
            {
                $taxBasisTotalAmountCurrencyCode = $this->objectHelper->TryCallAndReturn($taxBasisTotalAmountElementItem, "getCurrencyID") ?? "";
                if ($taxBasisTotalAmountCurrencyCode == $invoiceCurrencyCode || $taxBasisTotalAmountCurrencyCode == "") {
                    $taxBasisTotalAmount = $this->objectHelper->TryCallAndReturn($taxBasisTotalAmountElementItem, "value") ?? 0;
                    break;
                }
            }
        } else {
            $taxBasisTotalAmount = $this->getInvoiceValueByPath("getSupplyChainTradeTransaction.getApplicableHeaderTradeSettlement.getSpecifiedTradeSettlementHeaderMonetarySummation.getTaxBasisTotalAmount.value", 0);
        }

        return $this;
    }

    /**
     * Function to return a value from $invoiceObject by path
     *
     * @param string $methods
     * @param mixed $defaultValue
     * @return mixed
     */
    private function getInvoiceValueByPath(string $methods, $defaultValue)
    {
        return $this->objectHelper->TryCallByPathAndReturn($this->invoiceObject, $methods) ?? $defaultValue;
    }
}
