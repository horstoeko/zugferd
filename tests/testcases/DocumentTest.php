<?php

namespace horstoeko\zugferd\tests\testcases;

use \ReflectionClass;
use \ReflectionProperty;
use \horstoeko\zugferd\tests\TestCase;
use \horstoeko\zugferd\ZugferdProfiles;
use \horstoeko\zugferd\ZugferdDocument;

class DocumentTest extends TestCase
{
    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationBasic(): void
    {
        $doc = new ZugferdDocument(ZugferdProfiles::PROFILE_BASIC);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_BASIC, $doc->profileId);
        $this->assertArrayHasKey("contextparameter", $doc->profileDefinition);
        $this->assertArrayHasKey("name", $doc->profileDefinition);
        $this->assertEquals("urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic", $doc->profileDefinition["contextparameter"]);
        $this->assertEquals("basic", $doc->profileDefinition["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationBasicWl(): void
    {
        $doc = new ZugferdDocument(ZugferdProfiles::PROFILE_BASICWL);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_BASICWL, $doc->profileId);
        $this->assertArrayHasKey("contextparameter", $doc->profileDefinition);
        $this->assertArrayHasKey("name", $doc->profileDefinition);
        $this->assertEquals("urn:factur-x.eu:1p0:basicwl", $doc->profileDefinition["contextparameter"]);
        $this->assertEquals("basicwl", $doc->profileDefinition["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationEn16931(): void
    {
        $doc = new ZugferdDocument(ZugferdProfiles::PROFILE_EN16931);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, $doc->profileId);
        $this->assertArrayHasKey("contextparameter", $doc->profileDefinition);
        $this->assertArrayHasKey("name", $doc->profileDefinition);
        $this->assertEquals("urn:cen.eu:en16931:2017", $doc->profileDefinition["contextparameter"]);
        $this->assertEquals("en16931", $doc->profileDefinition["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     */
    public function testDocumentCreationExtended(): void
    {
        $doc = new ZugferdDocument(ZugferdProfiles::PROFILE_EXTENDED);
        $this->assertNotNull($doc);
        $this->assertEquals(ZugferdProfiles::PROFILE_EXTENDED, $doc->profileId);
        $this->assertArrayHasKey("contextparameter", $doc->profileDefinition);
        $this->assertArrayHasKey("name", $doc->profileDefinition);
        $this->assertEquals("urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended", $doc->profileDefinition["contextparameter"]);
        $this->assertEquals("extended", $doc->profileDefinition["name"]);
    }

    /**
     * @covers \horstoeko\zugferd\ZugferdDocument::__construct
     * @covers \horstoeko\zugferd\ZugferdDocument::initSerialzer()
     */
    public function testDocumentInternals(): void
    {
        $doc = new ZugferdDocument(ZugferdProfiles::PROFILE_EXTENDED);
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'serializerBuilder');
        $this->assertNotNull($property->getValue($doc));
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'serializer');
        $this->assertNotNull($property->getValue($doc));
        $property = $this->getPrivateProperty('horstoeko\zugferd\ZugferdDocument', 'invoiceObject');
        $this->assertNull($property->getValue($doc));
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
