<?php

namespace horstoeko\zugferd\tests\testcases;

use Throwable;
use SimpleXMLElement;
use horstoeko\zugferd\tests\TestCase;
use horstoeko\zugferd\ZugferdProfiles;
use horstoeko\zugferd\ZugferdProfileResolver;
use horstoeko\zugferd\exception\ZugferdUnknownProfileException;
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
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
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
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
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
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
</rsm:CrossIndustryInvoice>
HDR;
    }

    private function deliverOldZF20BasicProfile(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<rsm:ExchangedDocumentContext>
<ram:GuidelineSpecifiedDocumentContextParameter>
<ram:ID>urn:cen.eu:en16931:2017#compliant#urn:zugferd.de:2p0:basic</ram:ID>
</ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
</rsm:CrossIndustryInvoice>
HDR;
    }

    private function deliverOldZF20BasicWlProfile(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<rsm:ExchangedDocumentContext>
<ram:GuidelineSpecifiedDocumentContextParameter>
<ram:ID>urn:zugferd.de:2p0:basicwl</ram:ID>
</ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
</rsm:CrossIndustryInvoice>
HDR;
    }

    private function deliverOldZF20MinimumProfile(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<rsm:ExchangedDocumentContext>
<ram:GuidelineSpecifiedDocumentContextParameter>
<ram:ID>urn:zugferd.de:2p0:minimum</ram:ID>
</ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
</rsm:CrossIndustryInvoice>
HDR;
    }

    private function deliverOldZF20ExtendedProfile(): string
    {
        return <<<HDR
<?xml version="1.0" encoding="UTF-8"?>
<rsm:CrossIndustryInvoice xmlns:rsm="urn:un:unece:uncefact:data:standard:CrossIndustryInvoice:100"
 xmlns:a="urn:un:unece:uncefact:data:standard:QualifiedDataType:100"
 xmlns:qdt="urn:un:unece:uncefact:data:standard:QualifiedDataType:10"
 xmlns:ram="urn:un:unece:uncefact:data:standard:ReusableAggregateBusinessInformationEntity:100"
 xmlns:xs="http://www.w3.org/2001/XMLSchema"
 xmlns:udt="urn:un:unece:uncefact:data:standard:UnqualifiedDataType:100"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<rsm:ExchangedDocumentContext>
<ram:GuidelineSpecifiedDocumentContextParameter>
<ram:ID>urn:cen.eu:en16931:2017#conformant#urn:zugferd.de:2p0:extended</ram:ID>
</ram:GuidelineSpecifiedDocumentContextParameter>
</rsm:ExchangedDocumentContext>
</rsm:CrossIndustryInvoice>
HDR;
    }

    private function deliverStringWhichIsNotXml(): string
    {
        return "This is not a XML";
    }

    public function testResolveEn16931()
    {
        $resolved = ZugferdProfileResolver::resolve($this->deliverEn16931Header());

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
        $this->assertArrayHasKey("xmpversion", $resolved[1]);
        $this->assertArrayHasKey("xsdfilename", $resolved[1]);
        $this->assertArrayHasKey("schematronfilename", $resolved[1]);

        $this->assertSame(ZugferdProfiles::PROFILE_EN16931, $resolved[0]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved[1]["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved[1]["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved[1]["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved[1]["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved[1]["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved[1]["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved[1]["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpversion'], $resolved[1]["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved[1]["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved[1]["schematronfilename"]);
    }

    public function testResolveProfileIdEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveProfileId($this->deliverEn16931Header());

        $this->assertSame(ZugferdProfiles::PROFILE_EN16931, $resolved);
    }

    public function testResolveProfileDefEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverEn16931Header());

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveProfileDefOldZF20Basic()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverOldZF20BasicProfile());

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASIC]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveProfileDefOldZF20BasicWl()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverOldZF20BasicWlProfile());

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_BASICWL]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveProfileDefOldZF20Minimum()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverOldZF20MinimumProfile());

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_MINIMUM]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveProfileDefOldZF20Extended()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverOldZF20ExtendedProfile());

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EXTENDED]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveUnknownProfile()
    {
        $this->expectException(ZugferdUnknownProfileException::class);
        $this->expectExceptionMessage('Cannot determain the profile by unknown');

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
        $this->assertArrayHasKey("xmpversion", $resolved[1]);
        $this->assertArrayHasKey("xsdfilename", $resolved[1]);
        $this->assertArrayHasKey("schematronfilename", $resolved[1]);

        $this->assertSame(ZugferdProfiles::PROFILE_EN16931, $resolved[0]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved[1]["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved[1]["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved[1]["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved[1]["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved[1]["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved[1]["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved[1]["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpversion'], $resolved[1]["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved[1]["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved[1]["schematronfilename"]);
    }

    public function testResolveProfileDefByIdEn16931()
    {
        $resolved = ZugferdProfileResolver::resolveProfileDefById(ZugferdProfiles::PROFILE_EN16931);

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved["schematronfilename"]);
    }

    public function testResolveProfileDefByIdUnknown()
    {
        $this->expectException(ZugferdUnknownProfileIdException::class);
        $this->expectExceptionMessage('The profile id -1 is uknown');

        ZugferdProfileResolver::resolveProfileDefById(-1);
    }

    public function testResolveNotXml()
    {
        // Test clear LibXml Errors, when error previously occourred (See issue #133)

        $prevUseInternalErrors = \libxml_use_internal_errors(true);

        try {
            libxml_clear_errors();
            $xmldocument = new SimpleXMLElement($this->deliverStringWhichIsNotXml());
        } catch (Throwable $throwable) {
            // Do nothing
        } finally {
            libxml_use_internal_errors($prevUseInternalErrors);
        }

        $resolved = ZugferdProfileResolver::resolveProfileDef($this->deliverEn16931Header());

        $this->assertArrayHasKey("name", $resolved);
        $this->assertArrayHasKey("altname", $resolved);
        $this->assertArrayHasKey("description", $resolved);
        $this->assertArrayHasKey("contextparameter", $resolved);
        $this->assertArrayHasKey("businessprocess", $resolved);
        $this->assertArrayHasKey("attachmentfilename", $resolved);
        $this->assertArrayHasKey("xmpname", $resolved);
        $this->assertArrayHasKey("xmpversion", $resolved);
        $this->assertArrayHasKey("xsdfilename", $resolved);
        $this->assertArrayHasKey("schematronfilename", $resolved);

        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['name'], $resolved["name"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['altname'], $resolved["altname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['description'], $resolved["description"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['contextparameter'], $resolved["contextparameter"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['businessprocess'], $resolved["businessprocess"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['attachmentfilename'], $resolved["attachmentfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpname'], $resolved["xmpname"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xmpversion'], $resolved["xmpversion"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['xsdfilename'], $resolved["xsdfilename"]);
        $this->assertEquals(ZugferdProfiles::PROFILEDEF[ZugferdProfiles::PROFILE_EN16931]['schematronfilename'], $resolved["schematronfilename"]);
    }
}
