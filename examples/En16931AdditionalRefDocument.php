<?php

use horstoeko\zugferd\ZugferdDocumentReader;

require dirname(__FILE__) . "/../vendor/autoload.php";

$invoiceFile = dirname(__FILE__) . '/Invoice_2.xml';

$document = ZugferdDocumentReader::readAndGuessFromFile($invoiceFile);

// This is important - if you don't call this an attached file will not get extracted
// The directory you set must exist
$document->setBinaryDataDirectory('/tmp');

if ($document->firstDocumentAdditionalReferencedDocument()) {
    do {
        $document->getDocumentAdditionalReferencedDocument(
            $issuerassignedid,
            $typecode,
            $uriid,
            $name,
            $reftypecode,
            $issueddate,
            $binarydatafilename
        );

        // Information about the document
        echo "Issuer Assigned ID ........... " . $issuerassignedid . PHP_EOL;
        echo "Issued Date .................. " . $issueddate . PHP_EOL;
        echo "Type Code .................... " . $typecode . PHP_EOL;
        echo "URI .......................... " . $uriid . PHP_EOL;
        echo "Name ......................... " . $name[0] . PHP_EOL;
        echo "Ref. Type Code ............... " . $reftypecode . PHP_EOL;

        // $binarydatafilename contains the full filename. In this example /tmp/01_15_Anhang_01.pdf
        echo "The attachment is stored in .. " . $binarydatafilename . PHP_EOL;

    } while ($document->nextDocumentAdditionalReferencedDocument());
}
