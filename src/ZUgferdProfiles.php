<?php

namespace horstoeko\zugferd;

use horstoeko\zugferd\ZugferdDocumentBasicProfile;
use horstoeko\zugferd\ZugferdDocumentBasicWLProfile;
use horstoeko\zugferd\ZugferdDocumentEn16931Profile;
use horstoeko\zugferd\ZugferdDocumentExtendedProfile;

class ZUgferdProfiles
{
    const PROFILE_BASIC = 0;
    const PROFILE_BASICWL = 1;
    const PROFILE_EN16931 = 2;
    const PROFILE_EXTENDED = 3;

    const PROFILEDEF = [
        self::PROFILE_BASIC => [
            'name' => 'basic',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic',
        ],
        self::PROFILE_BASICWL => [
            'name' => 'basicwl',
            'contextparameter' => 'urn:cen.eu:en16931:2017#compliant#urn:factur-x.eu:1p0:basic',
        ],
        self::PROFILE_EN16931 => [
            'name' => 'en16931',
            'contextparameter' => 'urn:cen.eu:en16931:2017',
        ],
        self::PROFILE_EXTENDED => [
            'name' => 'extended',
            'contextparameter' => 'urn:cen.eu:en16931:2017#conformant#urn:factur-x.eu:1p0:extended',
        ],
    ];
}
