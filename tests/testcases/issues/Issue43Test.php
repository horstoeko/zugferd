<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;

class Issue43Test extends TestCase
{
    use HandlesXmlTests;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_XRECHNUNG_2_2);
    }

    /**
     * @return void
     * @issue  43
     */
    public function testIssue(): void
    {
        $date = "05.05.24";
        $duedate = "05.06.24";
        $invoice = "Invoice123";

        self::$document->setDocumentInformation(
            $invoice,
            ZugferdInvoiceType::INVOICE,
            \DateTime::createFromFormat("d.m.y", $date),
            "EUR",
            $invoice,
            null,
            \DateTime::createFromFormat("d.m.y", $duedate)
        );

        self::$document->addDocumentPaymentTerm('PaymentTerm', \DateTime::createFromFormat("d.m.y", $duedate), "MandateId");

        $this->assertXPathValueWithAttribute('/rsm:CrossIndustryInvoice/rsm:ExchangedDocument/ram:IssueDateTime/udt:DateTimeString', "20240505", "format", "102");
        $this->assertXPathValueWithIndexAndAttribute('/rsm:CrossIndustryInvoice/rsm:SupplyChainTradeTransaction/ram:ApplicableHeaderTradeSettlement/ram:SpecifiedTradePaymentTerms/ram:DueDateDateTime/udt:DateTimeString', 0, "20240605", "format", "102");
    }
}
