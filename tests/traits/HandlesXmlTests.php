<?php

namespace horstoeko\zugferd\tests\traits;

trait HandlesXmlTests
{
    /**
     * @var \horstoeko\zugferd\ZugferdDocumentBuilder|\horstoeko\zugferd\quick\ZugferdQuickDescriptor
     */
    protected static $document;

    /**
     * Cache for latest rendered XML
     *
     * @var \SimpleXMLElement
     */
    protected $latestXml;

    /**
     * Dont render xml content
     *
     * @var boolean
     */
    protected $renderingOfXmlDisabled = false;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->EnableRenderXmlContent();
    }

    /**
     * Dummy Test
     *
     * @return void
     */
    public function testDummy()
    {
        $this->assertTrue(true);
    }

    /**
     * Get XML-Object from documents content
     *
     * @return \SimpleXMLElement
     */
    protected function getXml(): \SimpleXMLElement
    {
        if ($this->renderingOfXmlDisabled === false) {
            $this->latestXml = new \SimpleXMLElement((self::$document)->getContent());
        }

        return $this->latestXml;
    }

    /**
     * Disable rendering of test content
     *
     * @return void
     */
    protected function disableRenderXmlContent()
    {
        $this->latestXml = new \SimpleXMLElement((self::$document)->getContent());
        $this->renderingOfXmlDisabled = true;
    }

    /**
     * Disable rendering of test content
     *
     * @return void
     */
    protected function enableRenderXmlContent()
    {
        $this->renderingOfXmlDisabled = false;
    }

    /**
     * Assert a xpath with $expected value
     *
     * @param  string $xpath
     * @param  string $expected
     * @return void
     */
    protected function assertXPathValue(string $xpath, string $expected): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey(0, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[0]);
    }

    /**
     * Assert a xpath with $expected value in a multiple element resultset
     *
     * @param  string  $xpath
     * @param  integer $index
     * @param  string  $expected
     * @return void
     */
    protected function assertXPathValueWithIndex(string $xpath, int $index, string $expected): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey($index, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[$index]);
    }

    /**
     * Assert a xpath with $expected value in a multiple element resultset
     *
     * @param  string  $xpath
     * @param  integer $index
     * @param  string  $expected
     * @return void
     */
    protected function assertXPathValueStartsWithIndex(string $xpath, int $index, string $expected): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey($index, $xmlvalue);
        $this->assertEquals($expected, substr($xmlvalue[$index], 0, strlen($expected)));
    }

    /**
     * Assert a xpath with $expected value and an expected attribute value
     *
     * @param  string $xpath
     * @param  string $expected
     * @param  string $expectedAttribute
     * @param  string $expectedAttributeValue
     * @return void
     */
    protected function assertXPathValueWithAttribute(string $xpath, string $expected, string $expectedAttribute, string $expectedAttributeValue): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey(0, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[0]);
        $this->assertNotNull($xmlvalue[0]->attributes()[$expectedAttribute]);
        $this->assertNotNull($xmlvalue[0]->attributes()[$expectedAttribute][0]);
        $this->assertEquals($expectedAttributeValue, $xmlvalue[0]->attributes()[$expectedAttribute][0]);
    }

    /**
     * Assert a xpath with $expected value in a multiple resule and an expected attribute value
     *
     * @param  string $xpath
     * @param  string $expected
     * @param  string $expectedAttribute
     * @param  string $expectedAttributeValue
     * @return void
     */
    protected function assertXPathValueWithIndexAndAttribute(string $xpath, int $index, string $expected, string $expectedAttribute, string $expectedAttributeValue): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey($index, $xmlvalue);
        $this->assertEquals($expected, $xmlvalue[$index]);
        $this->assertNotNull($xmlvalue[$index]->attributes()[$expectedAttribute]);
        $this->assertNotNull($xmlvalue[$index]->attributes()[$expectedAttribute][0]);
        $this->assertEquals($expectedAttributeValue, $xmlvalue[$index]->attributes()[$expectedAttribute][0]);
    }

    /**
     * Assert a xpath with $expected value in a multiple resule and an expected attribute value
     *
     * @param  string $xpath
     * @param  string $expected
     * @param  string $expectedAttribute
     * @param  string $expectedAttributeValue
     * @return void
     */
    protected function assertXPathValueStartsWithIndexAndAttribute(string $xpath, int $index, string $expected, string $expectedAttribute, string $expectedAttributeValue): void
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayHasKey($index, $xmlvalue);
        $this->assertEquals($expected, substr($xmlvalue[$index], 0, strlen($expected)));
        $this->assertNotNull($xmlvalue[$index]->attributes()[$expectedAttribute]);
        $this->assertNotNull($xmlvalue[$index]->attributes()[$expectedAttribute][0]);
        $this->assertEquals($expectedAttributeValue, $xmlvalue[$index]->attributes()[$expectedAttribute][0]);
    }

    /**
     * Test that an xml element does not exist
     *
     * @param  string $xpath
     * @return void
     */
    protected function assertXPathExists(string $xpath)
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertNotEmpty($xmlvalue);
    }

    /**
     * Test that an xml element does not exist
     *
     * @param  string $xpath
     * @return void
     */
    protected function assertXPathNotExists(string $xpath)
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertEmpty($xmlvalue);
    }

    /**
     * Test that an xml element does not exist at index
     *
     * @param  string  $xpath
     * @param  integer $index
     * @return void
     */
    protected function assertXPathNotExistsWithIndex(string $xpath, int $index)
    {
        $xml = $this->getXml();
        $xmlvalue = $xml->xpath($xpath);
        $this->assertArrayNotHasKey($index, $xmlvalue);
    }

    public function debugWriteFile(): void
    {
        (self::$document)->writeFile(getcwd() . "/myfile_dbg.xml");
    }
}
