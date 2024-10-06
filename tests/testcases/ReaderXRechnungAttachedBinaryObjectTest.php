<?php

namespace horstoeko\zugferd\tests\testcases;

use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

class ReaderXRechnungAttachedBinaryObjectTest extends TestCase
{
    /**
     * @var ZugferdDocumentReader
     */
    protected static $document;

    public static function setUpBeforeClass(): void
    {
        self::$document = ZugferdDocumentReader::readAndGuessFromFile(dirname(__FILE__) . "/../assets/xml_xrechnung_2.xml");
    }

    public function testDocumentProfile(): void
    {
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EN16931, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASIC, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_BASICWL, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_EXTENDED, self::$document->getProfileId());
        $this->assertNotEquals(ZugferdProfiles::PROFILE_XRECHNUNG, self::$document->getProfileId());
        $this->assertEquals(ZugferdProfiles::PROFILE_XRECHNUNG_2, self::$document->getProfileId());
    }

    public function testDocumentGetters(): void
    {
        $this->assertNotNull(self::$document->getInvoiceObject());
        $this->assertNotNull(self::$document->getSerializer());
        $this->assertNotNull(self::$document->getObjectHelper());
        $this->assertEquals('en16931', self::$document->getProfileDefinitionParameter('name'));
        $this->assertEquals('XRECHNUNG', self::$document->getProfileDefinitionParameter('altname'));
        $this->assertEquals('urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_2.0', self::$document->getProfileDefinitionParameter('contextparameter'));
        $this->assertEquals('xrechnung.xml', self::$document->getProfileDefinitionParameter('attachmentfilename'));
        $this->assertEquals('EN 16931', self::$document->getProfileDefinitionParameter('xmpname'));
        $this->expectNoticeOrWarningExt(
            function () {
                self::$document->getProfileDefinitionParameter('unknownparameter');
            }
        );
    }

    public function testDocumentGenerals(): void
    {
        self::$document->getDocumentInformation($documentno, $documenttypecode, $documentdate, $invoiceCurrency, $taxCurrency, $documentname, $documentlanguage, $effectiveSpecifiedPeriod);
        $this->assertEquals('123456789', $documentno);
        $this->assertEquals(ZugferdInvoiceType::INVOICE, $documenttypecode);
        $this->assertNotNull($documentdate);
        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20180605'))->format('Ymd'), $documentdate->format('Ymd'));
        $this->assertEquals("EUR", $invoiceCurrency);
        $this->assertEquals("", $taxCurrency);
        $this->assertEquals("", $documentname);
        $this->assertEquals("", $documentlanguage);
        $this->assertNull($effectiveSpecifiedPeriod);
    }

    public function testFirstDocumentAdditionalReferencedDocument(): void
    {
        $this->assertTrue((self::$document)->firstDocumentAdditionalReferencedDocument());
    }

    public function testGetDocumentAdditionalReferencedDocumentNoDirectorySet(): void
    {
        self::$document->getDocumentAdditionalReferencedDocument($issuerassignedid, $typecode, $uriid, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->assertEquals("01_15_Anhang_01.pdf", $issuerassignedid);
        $this->assertEquals("916", $typecode);
        $this->assertArrayHasKey(0, $name);
        $this->assertArrayNotHasKey(1, $name);
        $this->assertEquals("Aufschlüsselung der einzelnen Leistungspositionen", $name[0]);
        $this->assertEquals("", $binarydatafilename);
        $this->assertFalse(file_exists($binarydatafilename));
    }

    public function testGetDocumentAdditionalReferencedDocument(): void
    {
        self::$document->setBinaryDataDirectory(dirname(__FILE__));
        self::$document->getDocumentAdditionalReferencedDocument($issuerassignedid, $typecode, $uriid, $name, $reftypecode, $issueddate, $binarydatafilename);
        $this->assertEquals("01_15_Anhang_01.pdf", $issuerassignedid);
        $this->assertEquals("916", $typecode);
        $this->assertArrayHasKey(0, $name);
        $this->assertArrayNotHasKey(1, $name);
        $this->assertEquals("Aufschlüsselung der einzelnen Leistungspositionen", $name[0]);
        $this->assertNotEquals("", $binarydatafilename);
        $this->assertEquals(dirname(__FILE__) . DIRECTORY_SEPARATOR . "01_15_Anhang_01.pdf", $binarydatafilename);
        $this->assertTrue(file_exists($binarydatafilename));
        $this->assertEquals(150128, filesize($binarydatafilename));
        $this->assertEquals("%PDF", substr(file_get_contents($binarydatafilename), 0, 4));
        @unlink($binarydatafilename);
    }

    public function testNextDocumentAdditionalReferencedDocument(): void
    {
        $this->assertFalse((self::$document)->nextDocumentAdditionalReferencedDocument());
    }
}
