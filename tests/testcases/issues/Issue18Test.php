<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\tests\traits\HandlesXmlTests;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class Issue18Test extends TestCase
{
    use HandlesXmlTests;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentBuilder::CreateNew(ZugferdProfiles::PROFILE_XRECHNUNG_3);
    }

    /**
     * @return void
     * @issue  #18
     */
    public function testBusinessProcessSpecifiedDocumentContextParameter(): void
    {
        $invoiceObject = $this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject');
        $this->assertInstanceOf('horstoeko\zugferd\entities\en16931\rsm\CrossIndustryInvoice', $this->invokePrivateMethodFromObject(self::$document, 'getInvoiceObject'));
        $this->assertEquals('urn:cen.eu:en16931:2017#compliant#urn:xeinkauf.de:kosit:xrechnung_3.0', $invoiceObject->getExchangedDocumentContext()->getGuidelineSpecifiedDocumentContextParameter()->getId());
        $this->assertEquals('urn:fdc:peppol.eu:2017:poacc:billing:01:1.0', $invoiceObject->getExchangedDocumentContext()->getBusinessProcessSpecifiedDocumentContextParameter()->getId());
    }
}
