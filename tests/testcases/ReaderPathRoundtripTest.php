<?php

namespace horstoeko\zugferd\tests\testcases;

use DateTime;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\codelists\ZugferdUnitCodes;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use horstoeko\zugferd\ZugferdDocumentReader;
use horstoeko\zugferd\ZugferdProfiles;

/**
 * Round-trip guard for entity paths in ZugferdDocumentReader which no fixture populated.
 *
 * The reader addresses the generated entity graph through hand written path strings and
 * falls back to the default value whenever a path does not resolve, so a broken path is
 * silent. Every field below used to read back as null or "" although the builder wrote
 * it, and the existing tests asserted exactly that absent value - which is why the
 * breakage survived:
 *
 *   - EffectiveSpecifiedPeriod was read from a nonexistent "getDateTimeString", while the
 *     builder writes it to CompleteDateTime
 *   - the ShipFrom country was read through a doubled ".value.value"
 *   - the UltimateShipTo ids were read with a ".value" appended to an id collection
 *   - the line item despatch/receiving/delivery dates were read from the document root
 *     instead of the line item, and their format segment was separated by a comma
 *
 * make/checkreaderpaths.php prevents the paths from breaking again structurally; this
 * test pins the values that actually have to come back.
 */
class ReaderPathRoundtripTest extends TestCase
{
    /** @var ZugferdDocumentReader */
    private static $reader;

    /**
     * Build one EXTENDED document carrying every affected field and read it back.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        $builder = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);

        $builder
            ->setDocumentInformation(
                "R-2024-1",
                ZugferdInvoiceType::INVOICE,
                DateTime::createFromFormat("Ymd", "20240301"),
                "EUR",
                "Rechnung",
                "de",
                DateTime::createFromFormat("Ymd", "20240331")
            )
            ->setDocumentSeller("Lieferant GmbH")
            ->setDocumentBuyer("Kunden AG", "GE2020211")
            ->setDocumentShipFrom("Lager Sued")
            ->setDocumentShipFromAddress("Lagerstrasse 1", null, null, "80333", "Muenchen", "FR")
            ->setDocumentUltimateShipTo("Endkunde GmbH")
            ->addDocumentUltimateShipToId("END-CUST-42")
            ->addNewPosition("1")
            ->setDocumentPositionProductDetails("Produkt")
            ->setDocumentPositionNetPrice(10.0)
            ->setDocumentPositionQuantity(1.0, ZugferdUnitCodes::REC20_PIECE)
            ->setDocumentPositionSupplyChainEvent(DateTime::createFromFormat("Ymd", "20240302"))
            ->setDocumentPositionDespatchAdviceReferencedDocument("DESP-1", "1", DateTime::createFromFormat("Ymd", "20240303"))
            ->setDocumentPositionReceivingAdviceReferencedDocument("RECV-1", "1", DateTime::createFromFormat("Ymd", "20240304"))
            ->setDocumentPositionDeliveryNoteReferencedDocument("DELN-1", "1", DateTime::createFromFormat("Ymd", "20240305"));

        self::$reader = ZugferdDocumentReader::readAndGuessFromContent($builder->getContent());
    }

    /**
     * BT-X-6-000. The builder writes EffectiveSpecifiedPeriod/CompleteDateTime
     *
     * @return void
     */
    public function testEffectiveSpecifiedPeriodSurvivesTheRoundtrip(): void
    {
        self::$reader->getDocumentInformation(
            $documentNo,
            $documentTypeCode,
            $documentDate,
            $invoiceCurrency,
            $taxCurrency,
            $documentName,
            $documentLanguage,
            $effectiveSpecifiedPeriod
        );

        $this->assertInstanceOf(DateTime::class, $effectiveSpecifiedPeriod);
        $this->assertSame("20240331", $effectiveSpecifiedPeriod->format("Ymd"));
    }

    /**
     * BT-X-196. Used to be read through a doubled ".value.value"
     *
     * @return void
     */
    public function testShipFromCountrySurvivesTheRoundtrip(): void
    {
        self::$reader->getDocumentShipFromAddress($lineOne, $lineTwo, $lineThree, $postCode, $city, $country, $subDivision);

        $this->assertSame("Lagerstrasse 1", $lineOne);
        $this->assertSame("Muenchen", $city);
        $this->assertSame("FR", $country);
    }

    /**
     * BT-X-162. Used to be read with a ".value" appended to the id collection
     *
     * @return void
     */
    public function testUltimateShipToIdSurvivesTheRoundtrip(): void
    {
        self::$reader->getDocumentUltimateShipTo($name, $id, $description);

        $this->assertSame("Endkunde GmbH", $name);
        // convertToArray flattens when the map has a single entry, same as getDocumentShipTo
        $this->assertSame(["END-CUST-42"], $id);
    }

    /**
     * BT-X-85. The format segment was separated by a comma instead of a dot
     *
     * @return void
     */
    public function testPositionSupplyChainEventDateSurvivesTheRoundtrip(): void
    {
        $this->assertTrue(self::$reader->firstDocumentPosition());

        self::$reader->getDocumentPositionSupplyChainEvent($date);

        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertSame("20240302", $date->format("Ymd"));
    }

    /**
     * BT-X-86 / BT-X-91 / BT-X-94. All three were read from the document root
     *
     * @dataProvider positionReferencedDocumentProvider
     *
     * @param  string $method
     * @param  string $expectedIssuerAssignedId
     * @param  string $expectedIssueDate
     * @return void
     */
    public function testPositionReferencedDocumentDatesSurviveTheRoundtrip(string $method, string $expectedIssuerAssignedId, string $expectedIssueDate): void
    {
        $this->assertTrue(self::$reader->firstDocumentPosition());

        // Initialised up front: the getters take them by reference, which a dynamic
        // method call does not convey to static analysis
        $issuerAssignedId = null;
        $lineId = null;
        $issueDate = null;

        self::$reader->$method($issuerAssignedId, $lineId, $issueDate);

        $this->assertSame($expectedIssuerAssignedId, $issuerAssignedId);
        $this->assertSame("1", $lineId);
        $this->assertInstanceOf(DateTime::class, $issueDate, sprintf('%s() lost the issue date', $method));
        $this->assertSame($expectedIssueDate, $issueDate->format("Ymd"));
    }

    /**
     * @return array<string,array{0:string,1:string,2:string}>
     */
    public function positionReferencedDocumentProvider(): array
    {
        return [
            'despatch advice' => ['getDocumentPositionDespatchAdviceReferencedDocument', 'DESP-1', '20240303'],
            'receiving advice' => ['getDocumentPositionReceivingAdviceReferencedDocument', 'RECV-1', '20240304'],
            'delivery note' => ['getDocumentPositionDeliveryNoteReferencedDocument', 'DELN-1', '20240305'],
        ];
    }
}
