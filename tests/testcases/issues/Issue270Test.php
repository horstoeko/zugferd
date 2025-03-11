<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;

class Issue270Test extends TestCase
{
    public function testDocumentReceivableSpecifiedTradeAccountingAccount(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268.xml');

        $this->assertTrue($document->firstDocumentReceivableSpecifiedTradeAccountingAccount());

        $document->getDocumentReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("567", $accountId);
        $this->assertSame("", $accountType);

        $this->assertFalse($document->nextDocumentReceivableSpecifiedTradeAccountingAccount());
    }

    public function testDocumentPositionReceivableSpecifiedTradeAccountingAccount(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268.xml');

        $this->assertTrue($document->firstDocumentPosition());

        $document->getDocumentPositionReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("567", $accountId);
        $this->assertSame("", $accountType);

        $this->assertTrue($document->nextDocumentPosition());

        $document->getDocumentPositionReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("567", $accountId);
        $this->assertSame("", $accountType);

        $this->assertTrue($document->nextDocumentPosition());

        $document->getDocumentPositionReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("740", $accountId);
        $this->assertSame("", $accountType);
    }

    public function testDocumentReceivableSpecifiedTradeAccountingAccountExtended(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268_extended.xml');

        $this->assertTrue($document->firstDocumentReceivableSpecifiedTradeAccountingAccount());

        $document->getDocumentReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("567", $accountId);
        $this->assertSame("1", $accountType);

        $this->assertTrue($document->nextDocumentReceivableSpecifiedTradeAccountingAccount());

        $document->getDocumentReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("740", $accountId);
        $this->assertSame("2", $accountType);

        $this->assertFalse($document->nextDocumentReceivableSpecifiedTradeAccountingAccount());
    }

    public function testDocumentPositionReceivableSpecifiedTradeAccountingAccountExtended(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_268_extended.xml');

        $this->assertTrue($document->firstDocumentPosition());

        $document->getDocumentPositionReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("567", $accountId);
        $this->assertSame("1", $accountType);

        $this->assertTrue($document->nextDocumentPosition());

        $document->getDocumentPositionReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("567", $accountId);
        $this->assertSame("2", $accountType);

        $this->assertTrue($document->nextDocumentPosition());

        $document->getDocumentPositionReceivableSpecifiedTradeAccountingAccount($accountId, $accountType);

        $this->assertSame("740", $accountId);
        $this->assertSame("3", $accountType);
    }
}
