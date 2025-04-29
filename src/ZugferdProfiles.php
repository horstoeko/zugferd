<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd;

/**
 * Class representing the document profiles
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
class ZugferdProfiles
{
    /**
     * Internal constant that identifies the BASIC profile
     */
    public const PROFILE_BASIC = 0;

    /**
     * Internal constant that identifies the BASIC WL profile
     */
    public const PROFILE_BASICWL = 1;

    /**
     * Internal constant that identifies the EN16931 profile
     */
    public const PROFILE_EN16931 = 2;

    /**
     * Internal constant that identifies the EXTENDED profile
     */
    public const PROFILE_EXTENDED = 3;

    /**
     * Internal constant that identifies the XRECHNUNG profile (germany only)
     */
    public const PROFILE_XRECHNUNG = 4;

    /**
     * Internal constant that identifies the XRECHNUNG profile version 2.0 (germany only)
     */
    public const PROFILE_XRECHNUNG_2 = 5;

    /**
     * Internal constant that identifies the XRECHNUNG profile version 2.1 (germany only)
     */
    public const PROFILE_XRECHNUNG_2_1 = 6;

    /**
     * Internal constant that identifies the XRECHNUNG profile version 2.2 (germany only)
     */
    public const PROFILE_XRECHNUNG_2_2 = 7;

    /**
     * Internal constant that identifies the MINIMUM profile
     */
    public const PROFILE_MINIMUM = 8;

    /**
     * Internal constant that identifies the XRECHNUNG profile version 2.3 (germany only)
     */
    public const PROFILE_XRECHNUNG_2_3 = 9;

    /**
     * Internal constant that identifies the XRECHNUNG profile version 2.3 (germany only)
     */
    public const PROFILE_XRECHNUNG_3 = 10;

    /**
     * The definitions of the several profiles
     */
    public const PROFILEDEF = [
        self::PROFILE_BASIC => [
            'name' => 'basic',
            'altname' => 'BASIC',
            'description' => 'The BASIC profile is a subset of EN 16931-1 and can be used for simple VAT-compliant invoices.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic',
            'alternativecontextparameters' => ['urn:cen.eu:en16931:2017#compliant#urn:zugferd.de:2p0:basic'],
            'businessprocess' => null,
            'attachmentfilename' => 'factur-x.xml',
            'xmpname' => 'BASIC',
            'xmpversion' => '1.0',
            'xsdfilename' => 'FACTUR-X_BASIC.xsd',
            'schematronfilename' => 'FACTUR-X_BASIC.sch',
            'xsltfilename' => 'FACTUR-X_BASIC.xslt'
        ],
        self::PROFILE_BASICWL => [
            'name' => 'basicwl',
            'altname' => 'BASIC WL',
            'description' => 'The BASIC WL profile does not contain any invoice items and therefore cannot display any VAT-compliant ' .
                'invoices. However, it contains all the information at document level that is required to post the invoice. ' .
                'It is therefore a booking aid.',
            'contextparameter' => 'urn:factur-x.eu:1p0:basicwl',
            'alternativecontextparameters' => ['urn:zugferd.de:2p0:basicwl'],
            'businessprocess' => null,
            'attachmentfilename' => 'factur-x.xml',
            'xmpname' => 'BASIC WL',
            'xmpversion' => '1.0',
            'xsdfilename' => 'FACTUR-X_BASIC-WL.xsd',
            'schematronfilename' => 'FACTUR-X_BASIC-WL.sch',
            'xsltfilename' => 'FACTUR-X_BASIC-WL.xslt'
        ],
        self::PROFILE_EN16931 => [
            'name' => 'en16931',
            'altname' => 'EN 16931 (COMFORT)',
            'description' => 'The EN 16931 (COMFORT) profile completely maps the EN 16931-1 and focuses on the core elements ' .
                'of an electronic invoice.',
            'contextparameter' => 'urn:cen.eu:en16931:2017',
            'alternativecontextparameters' => [],
            'businessprocess' => null,
            'attachmentfilename' => 'factur-x.xml',
            'xmpname' => 'EN 16931',
            'xmpversion' => '1.0',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => 'FACTUR-X_EN16931.xslt'
        ],
        self::PROFILE_EXTENDED => [
            'name' => 'extended',
            'altname' => 'EXTENDED',
            'description' => 'The EXTENDED profile is an extension of EN 16931-1 to support more complex business processes (invoices ' .
                'in which several deliveries / delivery locations are billed, structured payment conditions, further information at ' .
                'item level to support warehousing, etc.)',
            'contextparameter' => 'urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended',
            'alternativecontextparameters' => ['urn:cen.eu:en16931:2017#conformant#urn:zugferd.de:2p0:extended'],
            'businessprocess' => 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0',
            'attachmentfilename' => 'factur-x.xml',
            'xmpname' => 'EXTENDED',
            'xmpversion' => '1.0',
            'xsdfilename' => 'FACTUR-X_EXTENDED.xsd',
            'schematronfilename' => 'FACTUR-X_EXTENDED.sch',
            'xsltfilename' => 'FACTUR-X_EXTENDED.xslt'
        ],
        self::PROFILE_XRECHNUNG => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_1.2',
            'alternativecontextparameters' => [],
            'businessprocess' => null,
            'attachmentfilename' => 'xrechnung.xml',
            'xmpname' => 'XRECHNUNG',
            'xmpversion' => '1.2',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => "FACTUR-X_EN16931.xslt"
        ],
        self::PROFILE_XRECHNUNG_2 => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_2.0',
            'alternativecontextparameters' => [],
            'businessprocess' => null,
            'attachmentfilename' => 'xrechnung.xml',
            'xmpname' => 'XRECHNUNG',
            'xmpversion' => '2.0',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => "FACTUR-X_EN16931.xslt"
        ],
        self::PROFILE_XRECHNUNG_2_1 => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_2.1',
            'alternativecontextparameters' => [],
            'businessprocess' => null,
            'attachmentfilename' => 'xrechnung.xml',
            'xmpname' => 'XRECHNUNG',
            'xmpversion' => '2.1',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => "FACTUR-X_EN16931.xslt"
        ],
        self::PROFILE_XRECHNUNG_2_2 => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_2.2',
            'alternativecontextparameters' => [],
            'businessprocess' => null,
            'attachmentfilename' => 'xrechnung.xml',
            'xmpname' => 'XRECHNUNG',
            'xmpversion' => '2.2',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => "FACTUR-X_EN16931.xslt"
        ],
        self::PROFILE_MINIMUM => [
            'name' => 'minimum',
            'altname' => 'MINIMUM',
            'description' => 'The MINIMUM profile includes the main information about the purchaser and vendor, the total invoice amount, and the total sales tax (VAT).' .
                'Only the purchaser s reference can be given at item level. A breakdown of the sales tax (VAT) is not supported. It is therefore a booking aid.',
            'contextparameter' => 'urn:factur-x.eu:1p0:minimum',
            'alternativecontextparameters' => ['urn:zugferd.de:2p0:minimum'],
            'businessprocess' => null,
            'attachmentfilename' => 'factur-x.xml',
            'xmpname' => 'MINIMUM',
            'xmpversion' => '1.0',
            'xsdfilename' => 'FACTUR-X_MINIMUM.xsd',
            'schematronfilename' => 'FACTUR-X_MINIMUM.sch',
            'xsltfilename' => 'FACTUR-X_MINIMUM.xslt'
        ],
        self::PROFILE_XRECHNUNG_2_3 => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_2.3',
            'alternativecontextparameters' => [],
            'businessprocess' => null,
            'attachmentfilename' => 'xrechnung.xml',
            'xmpname' => 'XRECHNUNG',
            'xmpversion' => '2.3',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => "FACTUR-X_EN16931.xslt"
        ],
        self::PROFILE_XRECHNUNG_3 => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xeinkauf.de:kosit:xrechnung_3.0',
            'alternativecontextparameters' => [],
            'businessprocess' => 'urn:fdc:peppol.eu:2017:poacc:billing:01:1.0',
            'attachmentfilename' => 'xrechnung.xml',
            'xmpname' => 'XRECHNUNG',
            'xmpversion' => '3.0',
            'xsdfilename' => 'FACTUR-X_EN16931.xsd',
            'schematronfilename' => 'FACTUR-X_EN16931.sch',
            'xsltfilename' => "FACTUR-X_EN16931.xslt"
        ],
    ];
}
