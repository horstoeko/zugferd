<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;

class Issue268Test extends TestCase
{
    public function testBTX27(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268.xml');

        $this->assertFalse($document->firstDocumentPositionAdditionalReferencedDocument());
    }

    public function testBT128(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268.xml');

        $this->assertTrue($document->firstDocumentPositionAdditionalReferencedObjDocument());

        $document->getDocumentPositionAdditionalReferencedObjDocument($issuerAssignedId, $typeCode, $refTypeCode);

        $this->assertSame("WAT PL 120", $issuerAssignedId);
        $this->assertSame("130", $typeCode);
        $this->assertSame("ABZ", $refTypeCode);

        $this->assertFalse($document->nextDocumentPositionAdditionalReferencedObjDocument());
    }

    public function testBTX331(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268.xml');

        $this->assertTrue($document->firstDocumentPositionAdditionalReferencedObjDocument());

        $document->getDocumentPositionInvoiceReferencedDocument($issuerAssignedId, $lineid, $typeCode, $issueDate);

        $this->assertSame("", $issuerAssignedId);
        $this->assertSame("", $lineid);
        $this->assertSame("", $typeCode);
        $this->assertNotInstanceOf(\DateTime::class, $issueDate);
    }

    public function testBTX27Extended(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268_extended.xml');

        $this->assertTrue($document->firstDocumentPositionAdditionalReferencedDocument());

        $document->getDocumentPositionAdditionalReferencedDocument($issuerAssignedId, $typeCode, $uriId, $lineId, $name, $refTypeCode, $issueDate, $binaryDataFilename);

        $this->assertSame("WAT PL 120", $issuerAssignedId);
        $this->assertSame("130", $typeCode);
        $this->assertSame("ABZ", $refTypeCode);

        $this->assertFalse($document->nextDocumentPositionAdditionalReferencedDocument());
    }

    public function testBT128Extended(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268_extended.xml');

        $this->assertTrue($document->firstDocumentPositionAdditionalReferencedObjDocument());

        $document->getDocumentPositionAdditionalReferencedObjDocument($issuerAssignedId, $typeCode, $refTypeCode);

        $this->assertSame("WAT PL 120", $issuerAssignedId);
        $this->assertSame("130", $typeCode);
        $this->assertSame("ABZ", $refTypeCode);

        $this->assertTrue($document->nextDocumentPositionAdditionalReferencedObjDocument());

        $document->getDocumentPositionAdditionalReferencedObjDocument($issuerAssignedId, $typeCode, $refTypeCode);

        $this->assertSame("WAT PL 120 (2)", $issuerAssignedId);
        $this->assertSame("130 (2)", $typeCode);
        $this->assertSame("ABZ (2)", $refTypeCode);

        $this->assertFalse($document->nextDocumentPositionAdditionalReferencedObjDocument());
    }

    public function testBTX331Extended(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268_extended.xml');

        $this->assertTrue($document->firstDocumentPositionAdditionalReferencedObjDocument());

        $document->getDocumentPositionInvoiceReferencedDocument($issuerAssignedId, $lineid, $typeCode, $issueDate);

        $this->assertSame("INV-1", $issuerAssignedId);
        $this->assertSame("1", $lineid);
        $this->assertSame("71", $typeCode);
        $this->assertInstanceOf(\DateTime::class, $issueDate);
    }
}
