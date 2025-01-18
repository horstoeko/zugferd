<?php

namespace horstoeko\zugferd\tests\testcases;

use ReflectionClass;
use ReflectionProperty;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class DocumentTest extends TestCase
{
    public function testDocumentCreationMinimum(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_MINIMUM);
        $this->assertSame(ZugferdProfiles::PROFILE_MINIMUM, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:factur-x.eu:1p0:minimum", $doc->getProfileDefinitionParameter("contextparameter"));
        $this->assertEquals("minimum", $doc->getProfileDefinitionParameter("name"));
    }

    public function testDocumentCreationBasic(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_BASIC);
        $this->assertSame(ZugferdProfiles::PROFILE_BASIC, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic", $doc->getProfileDefinitionParameter("contextparameter"));
        $this->assertEquals("basic", $doc->getProfileDefinitionParameter("name"));
    }

    public function testDocumentCreationBasicWl(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_BASICWL);
        $this->assertSame(ZugferdProfiles::PROFILE_BASICWL, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:factur-x.eu:1p0:basicwl", $doc->getProfileDefinitionParameter("contextparameter"));
        $this->assertEquals("basicwl", $doc->getProfileDefinitionParameter("name"));
    }

    public function testDocumentCreationEn16931(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EN16931);
        $this->assertSame(ZugferdProfiles::PROFILE_EN16931, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:cen.eu:en16931:2017", $doc->getProfileDefinitionParameter("contextparameter"));
        $this->assertEquals("en16931", $doc->getProfileDefinitionParameter("name"));
    }

    public function testDocumentCreationExtended(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);
        $this->assertSame(ZugferdProfiles::PROFILE_EXTENDED, $doc->getProfileId());
        $this->assertArrayHasKey("contextparameter", $doc->getProfileDefinition());
        $this->assertArrayHasKey("name", $doc->getProfileDefinition());
        $this->assertEquals("urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended", $doc->getProfileDefinitionParameter("contextparameter"));
        $this->assertEquals("extended", $doc->getProfileDefinitionParameter("name"));
    }

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

    public function testDocumentGetters(): void
    {
        $doc = ZugferdDocumentBuilder::createNew(ZugferdProfiles::PROFILE_EXTENDED);

        $this->assertNotNull($this->invokePrivateMethodFromObject($doc, 'getInvoiceObject'));
        $this->assertInstanceOf('horstoeko\zugferd\entities\extended\rsm\CrossIndustryInvoice', $this->invokePrivateMethodFromObject($doc, 'getInvoiceObject'));
        $this->assertNotNull($this->invokePrivateMethodFromObject($doc, 'getSerializer'));
        $this->assertInstanceOf(\JMS\Serializer\Serializer::class, $this->invokePrivateMethodFromObject($doc, 'getSerializer'));
        $this->assertNotNull($this->invokePrivateMethodFromObject($doc, 'getObjectHelper'));
        $this->assertInstanceOf('horstoeko\zugferd\ZugferdObjectHelper', $this->invokePrivateMethodFromObject($doc, 'getObjectHelper'));
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
