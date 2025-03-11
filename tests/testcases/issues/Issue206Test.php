<?php

namespace horstoeko\zugferd\tests\testcases\issues;

use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentReader;

class Issue206Test extends TestCase
{
    public function testDateTimeString(): void
    {
        $document = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/../../assets/issues/xml_issue_206.xml');
        $document->getDocumentInformation(
            $documentNo,
            $documentTypeCode,
            $documentDate,
            $invoiceCurrency,
            $taxCurrency,
            $documentName,
            $documentLanguage,
            $effectiveSpecifiedPeriod
        );

        $this->assertEquals((\DateTime::createFromFormat('Ymd', '20200305'))->format('Ymd'), $documentDate->format('Ymd'));
    }
}
