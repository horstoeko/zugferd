<?php

use PHPUnit\Framework\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class ReaderEn16931Tests extends TestCase
{
    /**
     * @var ZugferdDocumentReader;
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::ReadAndGuessFromFile(dirname(__FILE__) . "/data/en16931_einfach.xml");
    }

    public function testProfile()
    {
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->profile);
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->profile);
    }

    public function testGenerals()
    {
        self::$document->GetDocumentInformation($documentno, $documenttypecode, $documentdate, $duedate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('471102', $documentno);
        $this->assertEquals('380', $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180305'))->format('Ymd'), $documentdate->format('Ymd'));
    }
}
