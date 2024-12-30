<?php

use horstoeko\zugferd\ZugferdDocumentReader;

require __DIR__ . "/../vendor/autoload.php";

require __DIR__ . "/00_ExampleHelpers.php";

// First we try to load the invoice document from a XML file
// This will recognize the correctnes and the profile

$documentReader = ZugferdDocumentReader::readAndGuessFromFile(__DIR__ . '/assets/03_ZugferdDocumentReader_ImportFile_XRECHNUNG3.xml');

// Optionally you can load the document from XML stream (string)
// Note: We simulate the XML stream (string) by calling file_get_contents.

$xmlContent = file_get_contents(__DIR__ . '/assets/03_ZugferdDocumentReader_ImportFile_XRECHNUNG3.xml');

$documentReader = ZugferdDocumentReader::readAndGuessFromContent($xmlContent);

// If no problems have occurred up to this point (invalid XML, unknown profile, etc.), then the document is now available
// for us to read out

// First we resolve the general invoice information.

$documentReader->getDocumentInformation(
    $documentNo,
    $documentTypeCode,
    $documentDate,
    $documentCurrency,
    $documentTaxCurrency,
    $documentName,
    $documentLanguage,
    $effectiveSpecifiedPeriod
);

$documentReader->getDocumentSupplyChainEvent(
    $documentDeliveryDate
);

writeNewLineToCli();
writeLnToCli("Document Information");
writeLnToCli("--------------------------------------------------------------------------------");
writeLnToCli(" - Profile ............ %s", $documentReader->getProfileDefinitionParameter("name"));
writeLnToCli(" - Profile Context .... %s", $documentReader->getProfileDefinitionParameter("contextparameter"));
writeLnToCli(" - Document No ........ %s", $documentNo);
writeLnToCli(" - Document Type ...... %s", $documentTypeCode);
writeLnToCli(" - Document Date ...... %s", $documentDate->format("Y-m-d"));
writeLnToCli(" - Invoice currency: .. %s", $documentCurrency);
writeLnToCli(" - Tax currency ....... %s", $documentTaxCurrency);
writeLnToCli(" - Delivery date ...... %s", $documentDeliveryDate->format("Y-m-d"));

// Now let's get information about the seller. In addition to the methods listed here,
// there are a few more available, but these are rarely required

$documentReader->getDocumentSeller(
    $sellerName,
    $sellerIds,
    $sellerDescription
);

$documentReader->getDocumentSellerGlobalId(
    $sellerGlobalIds
);

$documentReader->getDocumentSellerTaxRegistration(
    $sellerTaxRegistations
);

$documentReader->getDocumentSellerAddress(
    $sellerAddressLineOne,
    $sellerAddressLineTwo,
    $sellerAddressLineThree,
    $sellerAddressPostCode,
    $sellerAddressCity,
    $sellerAddressCountry,
    $sellerAddressSubDivisions
);

$documentReader->getDocumentSellerCommunication(
    $sellerCommunicationUriScheme,
    $sellerCommunicationUri
);

writeNewLineToCli();
writeLnToCli("Seller Information");
writeLnToCli("--------------------------------------------------------------------------------");
writeLnToCli('%s', $sellerName);
writeLnToCli('%s', $sellerAddressLineOne);
writeLnToCli('%s', $sellerAddressLineTwo);
writeLnToCli('%s', $sellerAddressLineThree);
writeLnToCli('%s %s %s', $sellerAddressCountry, $sellerAddressPostCode, $sellerAddressCity);
writeLnToCli('%s %s', $sellerCommunicationUriScheme, $sellerCommunicationUri);
writeLnToCli('%s', implode(PHP_EOL, $sellerAddressSubDivisions));
writeNewLineToCli();
writeLnToCli('%s', implodeAssocArray(", ", $sellerTaxRegistations));
writeNewLineToCli();
writeLnToCli('Seller identifications: %s', implode(",", $sellerIds));
writeLnToCli('Seller global identifications: %s', implodeAssocArray(",", $sellerGlobalIds));

// We now want to read out the contact information of our seller. Theoretically, there can be more than one contact,
// which is why we have to iterate over the transmitted contacts:

writeNewLineToCli();
writeLnToCli("  Seller contact Information");
writeLnToCli("  ------------------------------------------------------------------------------");

if ($documentReader->firstDocumentSellerContact()) {
    do {
        $documentReader->getDocumentSellerContact(
            $sellerContactPersonname,
            $sellerContactDepartmentname,
            $sellerContactPhoneNo,
            $sellerContactFaxNo,
            $sellerContactEmailAddress
        );
        writeLnToCli('  %s', $sellerContactPersonname);
        writeLnToCli('  %s', $sellerContactDepartmentname);
        writeLnToCli('  %s', $sellerContactPhoneNo);
        writeLnToCli('  %s', $sellerContactFaxNo);
        writeLnToCli('  %s', $sellerContactEmailAddress);
        writeNewLineToCli();
    } while ($documentReader->nextDocumentSellerContact());
} else {
    writeLnToCli('  No contact information found');
}

// Now let's get information about the buyer. In addition to the methods listed here,
// there are a few more available, but these are rarely required

$documentReader->getDocumentBuyer(
    $buyerName,
    $buyerIds,
    $buyerDescription
);

$documentReader->getDocumentBuyerGlobalId(
    $buyerGlobalIds
);

$documentReader->getDocumentBuyerTaxRegistration(
    $buyerTaxRegistations
);

$documentReader->getDocumentBuyerAddress(
    $buyerAddressLineOne,
    $buyerAddressLineTwo,
    $buyerAddressLineThree,
    $buyerAddressPostCode,
    $buyerAddressCity,
    $buyerAddressCountry,
    $buyerAddressSubDivisions
);

$documentReader->getDocumentbuyerCommunication(
    $buyerCommunicationUriScheme,
    $buyerCommunicationUri
);

writeNewLineToCli();
writeLnToCli("Buyer Information");
writeLnToCli("--------------------------------------------------------------------------------");
writeLnToCli('%s', $buyerName);
writeLnToCli('%s', $buyerAddressLineOne);
writeLnToCli('%s', $buyerAddressLineTwo);
writeLnToCli('%s', $buyerAddressLineThree);
writeLnToCli('%s %s %s', $buyerAddressCountry, $buyerAddressPostCode, $buyerAddressCity);
writeLnToCli('%s', implode(PHP_EOL, $buyerAddressSubDivisions));
writeLnToCli('%s %s', $buyerCommunicationUriScheme, $buyerCommunicationUri);
writeNewLineToCli();
writeLnToCli('%s', implodeAssocArray(", ", $buyerTaxRegistations));
writeNewLineToCli();
writeLnToCli('Buyer identifications: %s', implode(",", $buyerIds));
writeLnToCli('Buyer global identifications: %s', implodeAssocArray(",", $buyerGlobalIds));

// We now want to read out the contact information of our buyer. Theoretically, there can be more than one contact,
// which is why we have to iterate over the transmitted contacts:

writeNewLineToCli();
writeLnToCli("  Buyer contact Information");
writeLnToCli("  ------------------------------------------------------------------------------");

if ($documentReader->firstDocumentBuyerContact()) {
    do {
        $documentReader->getDocumentBuyerContact(
            $buyerContactPersonname,
            $buyerContactDepartmentname,
            $buyerContactPhoneNo,
            $buyerContactFaxNo,
            $buyerContactEmailAddress
        );
        writeLnToCli('  %s', $buyerContactPersonname);
        writeLnToCli('  %s', $buyerContactDepartmentname);
        writeLnToCli('  %s', $buyerContactPhoneNo);
        writeLnToCli('  %s', $buyerContactFaxNo);
        writeLnToCli('  %s', $buyerContactEmailAddress);
        writeNewLineToCli();
    } while ($documentReader->nextDocumentBuyerContact());
} else {
    writeLnToCli('  No contact information found');
}

// Next we want to load and show the different shipping location

$documentReader->getDocumentShipTo(
    $shipToName,
    $shipToIds,
    $shipToDescription
);

$documentReader->getDocumentShipToGlobalId(
    $shipToGlobalIds
);

$documentReader->getDocumentShipToTaxRegistration(
    $shipToTaxRegistations
);

$documentReader->getDocumentShipToAddress(
    $shipToAddressLineOne,
    $shipToAddressLineTwo,
    $shipToAddressLineThree,
    $shipToAddressPostCode,
    $shipToAddressCity,
    $shipToAddressCountry,
    $shipToAddressSubDivisions
);

writeNewLineToCli();
writeLnToCli("Shipping location Information");
writeLnToCli("--------------------------------------------------------------------------------");
writeLnToCli('%s', $shipToName);
writeLnToCli('%s', $shipToAddressLineOne);
writeLnToCli('%s', $shipToAddressLineTwo);
writeLnToCli('%s', $shipToAddressLineThree);
writeLnToCli('%s %s %s', $shipToAddressCountry, $shipToAddressPostCode, $shipToAddressCity);
writeLnToCli('%s', implode(PHP_EOL, $shipToAddressSubDivisions));
writeNewLineToCli();
writeLnToCli('%s', implodeAssocArray(", ", $shipToTaxRegistations));
writeNewLineToCli();
writeLnToCli('Shipping location identifications: %s', implode(",", $shipToIds));
writeLnToCli('Shipping location global identifications: %s', implodeAssocArray(",", $shipToGlobalIds));

// We now want to read out the contact information of our shipping location. Theoretically, there can be more than one contact,
// which is why we have to iterate over the transmitted contacts:

writeNewLineToCli();
writeLnToCli("  Shipping location contact Information");
writeLnToCli("  ------------------------------------------------------------------------------");

if ($documentReader->firstDocumentShipToContact()) {
    do {
        $documentReader->getDocumentShipToContact(
            $shipToContactPersonname,
            $shipToContactDepartmentname,
            $shipToContactPhoneNo,
            $shipToContactFaxNo,
            $shipToContactEmailAddress
        );
        writeLnToCli('  %s', $shipToContactPersonname);
        writeLnToCli('  %s', $shipToContactDepartmentname);
        writeLnToCli('  %s', $shipToContactPhoneNo);
        writeLnToCli('  %s', $shipToContactFaxNo);
        writeLnToCli('  %s', $ShipToContactEmailAddress);
        writeNewLineToCli();
    } while ($documentReader->nextDocumentShipToContact());
} else {
    writeLnToCli('  No contact information found');
}

// Let's get the document positions. There are several method names starting with getDocumentPosition*. The methods listed
// here are the most frequently used. We have to use a loop to iterate over the position, similar how we retrieved the party contacts.

writeNewLineToCli();
writeLnToCli("Document positions");
writeLnToCli("--------------------------------------------------------------------------------");

if ($documentReader->firstDocumentPosition()) {
    do {
        // Get the general information of the position

        $documentReader->getDocumentPositionGenerals(
            $positionLineId,
            $positionLineStatusCode,
            $positionLineStatusReasonCode
        );

        // Get the product information

        $documentReader->getDocumentPositionProductDetails(
            $positionProductName,
            $positionProductDescription,
            $positionProductSellerAssignedID,
            $positionProductBuyerAssignedID,
            $positionProductGlobalIDType,
            $positionProductGlobalID
        );

        // Get the net unit price

        $documentReader->getDocumentPositionNetPrice(
            $positionNetUnitPrice,
            $positionBasisQuantity,
            $positionBasisQuantityUnitCode
        );

        // Get the position invoiced quantity

        $documentReader->getDocumentPositionQuantity(
            $positionBilledQuantity,
            $positionBilledQuantityUnitCode,
            $positionChargeFreeQuantity,
            $positionChargeFreeQuantityUnitCpde,
            $positionPackageQuantity,
            $positionPackageQuantityUnitCode
        );

        // Get the position amount summation

        $documentReader->getDocumentPositionLineSummationSimple(
            $positionTotalNetAmount
        );

        // Write the position information to CLI

        writeLnToCli('  Position %s', $positionLineId);
        writeLnToCli("  ------------------------------------------------------------------------------");
        writeLnToCli('  %s', $positionProductName);
        writeLnToCli('  %s', $positionProductDescription);
        writeLnToCli('  Unit Price        %s %s', number_format($positionNetUnitPrice, 2), $documentCurrency);
        writeLnToCli('  Quantity/Unit     %s %s', number_format($positionBilledQuantity, 5), $positionBilledQuantityUnitCode);
        writeLnToCli('  Line Amount       %s %s', number_format($positionTotalNetAmount, 2), $documentCurrency);

        // Get the tax information of the position.
        // According to the data model, several tax rates could also be assigned per item. In Germany, for example, this
        // is not permitted. We must also use the appropriate first/next method here

        if ($documentReader->firstDocumentPositionTax()) {
            $documentReader->getDocumentPositionTax(
                $positionTaxCategoryCode,
                $positionTaxTypeCode,
                $positionTaxRateApplicablePercent,
                $positionTaxCalculatedAmount,
                $positionTaxExemptionReason,
                $positionTaxExemptionReasonCode
            );

            writeLnToCli('  Tax category      %s', $positionTaxCategoryCode);
            writeLnToCli('  Tax type          %s', $positionTaxTypeCode);
            writeLnToCli('  Tax percent       %s %%', number_format($positionTaxRateApplicablePercent, 2));
        }

        writeNewLineToCli();
    } while ($documentReader->nextDocumentPosition());
} else {
    writeLnToCli('No document positions found');
}

// Finally, we determine the VAT statement and the total amounts of the document.
// As there could be several tax rates per invoice here, we have to work with the appropriate first/next methods again:

// Get the VAT statement

writeNewLineToCli();
writeLnToCli("VAT Statement");
writeLnToCli("--------------------------------------------------------------------------------");

if ($documentReader->firstDocumentTax()) {
    writeLnToCli("  Tax Category         Tax Type             Tax percent");
    writeLnToCli("  ------------------------------------------------------------------------------");
    do {
        $documentReader->getDocumentTax(
            $documentTaxcategoryCode,
            $documentTaxTypeCode,
            $documentTaxBasisAmount,
            $documentTaxCalculatedAmount,
            $documentTaxRateApplicablePercent,
            $documentTaxExemptionReason,
            $documentTaxExemptionReasonCode,
            $documentTaxLineTotalBasisAmount,
            $documentTaxAllowanceChargeBasisAmount,
            $documentTaxTaxPointDate,
            $documentTaxDueDateTypeCode
        );

        writeLnToCli(
            '  %s %s %s',
            str_pad($documentTaxcategoryCode, 20, " ", STR_PAD_RIGHT),
            str_pad($documentTaxTypeCode, 20, " ", STR_PAD_RIGHT),
            str_pad(number_format($documentTaxRateApplicablePercent, 2), 10, " ", STR_PAD_RIGHT),
        );
    } while ($documentReader->nextDocumentTax());
} else {
    writeLnToCli('  No tax information found');
}

// Get the document totals (summation)

writeNewLineToCli();
writeLnToCli("Document totals");
writeLnToCli("--------------------------------------------------------------------------------");

$documentReader->getDocumentSummation(
    $documentGrandTotalAmount,
    $documentDuePayableAmount,
    $documentLineTotalAmount,
    $documentChargeTotalAmount,
    $documentAllowanceTotalAmount,
    $documentTaxBasisTotalAmount,
    $documentTaxTotalAmount,
    $documentRoundingAmount,
    $documentTotalPrepaidAmount
);

writeLnToCli('Total Net Amount          %s %s', str_pad(number_format($documentLineTotalAmount, 2), 10, " ", STR_PAD_LEFT), $documentCurrency);
writeLnToCli('Total Tax Basis Amount    %s %s', str_pad(number_format($documentTaxBasisTotalAmount, 2), 10, " ", STR_PAD_LEFT), $documentCurrency);
writeLnToCli('Total Tax Amount          %s %s', str_pad(number_format($documentTaxTotalAmount, 2), 10, " ", STR_PAD_LEFT), $documentCurrency);
writeLnToCli('Total Gross Amount        %s %s', str_pad(number_format($documentGrandTotalAmount, 2), 10, " ", STR_PAD_LEFT), $documentCurrency);
writeLnToCli('Amount already paid       %s %s', str_pad(number_format($documentTotalPrepaidAmount, 2), 10, " ", STR_PAD_LEFT), $documentCurrency);
writeLnToCli('Amount to pay             %s %s', str_pad(number_format($documentDuePayableAmount, 2), 10, " ", STR_PAD_LEFT), $documentCurrency);
