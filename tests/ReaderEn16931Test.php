<?php

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentReader;

class ReaderEn16931Tests extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected $document;

    public function setUp(): void
    {
        $this->document = ZugferdDocumentReader::ReadAndGuessFromFile(dirname(__FILE__) . "/data/en16931_einfach.xml");
    }

    public function testProfile()
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, $this->document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, $this->document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, $this->document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, $this->document->profile);
    }

    public function testGenerals()
    {
        $this->document->GetDocumentInformation($documentno, $documenttypecode, $documentdate, $duedate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('471102', $documentno);
        $this->assertEquals('380', $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $documentdate->format('Ymd'));
    }
}
