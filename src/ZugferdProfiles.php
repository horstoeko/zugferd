<?php

namespace horstoeko\zugferd;

/**
 * Class representing the document profiles
 */
class ZugferdProfiles
{
    const PROFILE_BASIC = 0;
    const PROFILE_BASICWL = 1;
    const PROFILE_EN16931 = 2;
    const PROFILE_EXTENDED = 3;
    const PROFILE_XRECHNUNG = 4;

    const PROFILEDEF = [
        self::PROFILE_BASIC => [
            'name' => 'basic',
            'altname' => 'BASIC',
            'description' => 'The BASIC profile is a subset of EN 16931-1 and can be used for simple VAT-compliant invoices.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic',
        ],
        self::PROFILE_BASICWL => [
            'name' => 'basicwl',
            'altname' => 'BASIC WL',
            'description' => 'The BASIC WL profile does not contain any invoice items and therefore cannot display any VAT-compliant ' .
                'invoices. However, it contains all the information at document level that is required to post the invoice. ' .
                'It is therefore a booking aid.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic',
        ],
        self::PROFILE_EN16931 => [
            'name' => 'en16931',
            'altname' => 'EN 16931 (COMFORT)',
            'description' => 'The EN 16931 (COMFORT) profile completely maps the EN 16931-1 and focuses on the core elements ' .
                'of an electronic invoice.',
            'contextparameter' => 'urn:cen.eu:en16931:2017',
        ],
        self::PROFILE_EXTENDED => [
            'name' => 'extended',
            'altname' => 'EXTENDED',
            'description' => 'The EXTENDED profile is an extension of EN 16931-1 to support more complex business processes (invoices ' .
                'in which several deliveries / delivery locations are billed, structured payment conditions, further information at ' .
                'item level to support warehousing, etc.)',
            'contextparameter' => 'urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended',
        ],
        self::PROFILE_XRECHNUNG => [
            'name' => 'en16931',
            'altname' => 'XRECHNUNG',
            'description' => 'The reference profile is based on the CIUS XRechnung, which is maintained by KoSIT. It represents an ' .
                'extension of EN 16931-1 with its own business rules, the national German laws and regulations. It is therefore more ' .
                'specific than the EN 16931 (COMFORT) profile.',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:xoev-de:kosit:standard:xrechnung_1.2',
        ],
    ];
}
