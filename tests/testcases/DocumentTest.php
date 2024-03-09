<?php

namespace horstoeko\zugferd\tests\testcases;

use \ReflectionClass;
use \ReflectionProperty;
use \horstoeko\zugferd\tests\TestCase;
use \horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class DocumentTest extends TestCase
{
    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationMinimum(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_MINIMUM);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_MINIMUM, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:factur-x.eu:1p0:minimum", $doc->getProfileDefinition()["contextparameter"]);
        $this->assertEquals("minimum", $doc->getProfileDefinition()["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationBasic(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_BASIC);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_BASIC, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic", $doc->getProfileDefinition()["contextparameter"]);
        $this->assertEquals("basic", $doc->getProfileDefinition()["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationBasicWl(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_BASICWL);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_BASICWL, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:factur-x.eu:1p0:basicwl", $doc->getProfileDefinition()["contextparameter"]);
        $this->assertEquals("basicwl", $doc->getProfileDefinition()["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationEn16931(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EN16931);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:cen.eu:en16931:2017", $doc->getProfileDefinition()["contextparameter"]);
        $this->assertEquals("en16931", $doc->getProfileDefinition()["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationExtended(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended", $doc->getProfileDefinition()["contextparameter"]);
        $this->assertEquals("extended", $doc->getProfileDefinition()["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     * @covers \horstoeko\zugferd\ZugferdDocument::initSerialzer()
     */
    public function testDocumentInternals(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'serializerBuilder');
        $this->assertNotNull($property->getValue($doc));
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'serializer');
        $this->assertNotNull($property->getValue($doc));
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'invoiceObject');
        $this->assertNotNull($property->getValue($doc));
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'objectHelper');
        $this->assertNotNull($property->getValue($doc));
    }

    /**
     * Access to private properties
     *
     * @param  string $className
     * @param  string $propertyName
     * @return ReflectionProperty
     */
    public function getPrivateProperty($className, $propertyName): ReflectionProperty
    {
        $reflector = new ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        return $property;
    }
}
