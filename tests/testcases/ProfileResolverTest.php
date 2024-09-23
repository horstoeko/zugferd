<?php

namespace horstoeko\zugferd\tests\testcases;

use \horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdProfileResolver;
use horstoeko\zugferd\exception\ZugferdUnknownProfileIdException;

class ProfileResolverTest extends TestCase
{
    /**
     * Internal helper - returns the EN16931 Header
     *
     * @return string
     */
    private function deliverEn16931Header(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100" xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100" xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10" xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<rsm:ExchangedDocumentContext>
<ram:GuidelineSpecifiedDocumentContextParameter>
<ram:ID>urn:cen.eu:en16931:2017</ram:ID>
</ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
</rsm:CrossIndustryInvoice>
HDR;
    }

    /**
     * Internal helper - returns unknown profile
     *
     * @return string
     */
    private function deliverUnknownProfile(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100" xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100" xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10" xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<rsm:ExchangedDocumentContext>
<ram:GuidelineSpecifiedDocumentContextParameter>
<ram:ID>unknown</ram:ID>
</ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
</rsm:CrossIndustryInvoice>
HDR;
    }

    /**
     * Internal helper - returns unknown profile
     *
     * @return string
     */
    private function deliverInvalidXml(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100" xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100" xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10" xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
</rsm:CrossIndustryInvoice>
HDR;
    }

    public function testResolveEn16931()
    {
        $resolved = ZugferdProfileResolver::resolve($this->deliverEn16931Header());

        $this->assertIsArray($resolved);
        $this->assertArrayHasKey(0, $resolved);
        $this->assertArrayHasKey(1, $resolved);
        $this->assertIsInt($resolved[0]);
        $this->assertIsArray($resolved[1]);
        $this->assertArrayHasKey("name", $resolved[1]);
        $this->assertArrayHasKey("altname", $resolved[1]);
        $this->assertArrayHasKey("description", $resolved[1]);
        $this->assertArrayHasKey("contextparameter", $resolved[1]);
        $this->assertArrayHasKey("businessprocess", $resolved[1]);
        $this->assertArrayHasKey("attachmentfilename", $resolved[1]);
        $this->assertArrayHasKey("xmpname", $resolved[1]);
        $this->assertArrayHasKey("xsdfilename", $resolved[1]);
        $this->assertArrayHasKey("schematronfilename", $resolved[1]);

        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, $resolved[0]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved[1]["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved[1]["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved[1]["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved[1]["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved[1]["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved[1]["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved[1]["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved[1]["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved[1]["schematronfilename"]);
    }

    public function testResolveProfileIdEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveProfileId($this->deliverEn16931Header());

        $this->assertIsInt($resolved);
        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, $resolved);
    }

    public function testResolveProfileDefEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverEn16931Header());

        $this->assertIsArray($resolved);
        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveUnknownProfile()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A context parameter was found, but the content of "unknown" is not a valid profile');

        ZugferdProfileResolver::resolveProfileId($this->deliverUnknownProfile());
    }

    public function testResolveInvalidXml()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The XML does not match the requirements for an XML in CII-Syntax');

        ZugferdProfileResolver::resolveProfileId($this->deliverInvalidXml());
    }

    public function testResolveProfileByIdEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveById(ZugferdProfiles::PROFILE_EN16931);

        $this->assertIsArray($resolved);
        $this->assertArrayHasKey(0, $resolved);
        $this->assertArrayHasKey(1, $resolved);
        $this->assertIsInt($resolved[0]);
        $this->assertIsArray($resolved[1]);
        $this->assertArrayHasKey("name", $resolved[1]);
        $this->assertArrayHasKey("altname", $resolved[1]);
        $this->assertArrayHasKey("description", $resolved[1]);
        $this->assertArrayHasKey("contextparameter", $resolved[1]);
        $this->assertArrayHasKey("businessprocess", $resolved[1]);
        $this->assertArrayHasKey("attachmentfilename", $resolved[1]);
        $this->assertArrayHasKey("xmpname", $resolved[1]);
        $this->assertArrayHasKey("xsdfilename", $resolved[1]);
        $this->assertArrayHasKey("schematronfilename", $resolved[1]);

        $this->assertEquals(ZugferdProfiles::PROFILE_EN16931, $resolved[0]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved[1]["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved[1]["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved[1]["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved[1]["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved[1]["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved[1]["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved[1]["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved[1]["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved[1]["schematronfilename"]);
    }

    public function testResolveProfileDefByIdEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDefById(ZugferdProfiles::PROFILE_EN16931);

        $this->assertIsArray($resolved);
        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveProfileDefByIdUnknown()
    {
        $this->expectException(ZugferdUnknownProfileIdException::class);
        $this->expectExceptionMessage('The profile id -1 is uknown');

        ZugferdProfileResolver::resolveProfileDefById(-1);
    }
}
