<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing EAS : Electronice Address Scheme
 * For BT-34-1, BT-49-1
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   L. Ollivault
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */

class ZugferdElectronicAddressScheme
{
    /**
     * O.F.T.P. (ODETTE File Transfer Protocol)
     */
    const UNECE3155_AN = "AN";

    /**
     * X.400 address for mail text
     */
    const UNECE3155_AQ = "AQ";

    /**
     * AS2 exchange
     */
    const UNECE3155_AS = "AS";

    /**
     * File Transfer Protocol
     */
    const UNECE3155_AU = "AU";

    /**
     * Electronic mail (SMTP)
     */
    const UNECE3155_EM = "EM";

    /**
     * System Information et Repertoire des Entreprise et des Etablissements: SIRENE
     */
    const ICD_0002 = "0002";

    /**
     * Organisationsnummer
     */
    const ICD_0007 = "0007";

    /**
     * SIRET-CODE
     */
    const ICD_0009 = "0009";

    /**
     * LY-tunnus
     */
    const ICD_0037 = "0037";

    /**
     * Data Universal Numbering System (D-U-N-S Number)
     */
    const ICD_0060 = "0060";

    /**
     * EAN Location Code
     */
    const ICD_0088 = "0088";

    /**
     * DANISH CHAMBER OF COMMERCE Scheme (EDIRA compliant)
     */
    const ICD_0096 = "0096";

    /**
     * FTI - Ediforum Italia, (EDIRA compliant)
     */
    const ICD_0097 = "0097";

    /**
     * Vereniging van Kamers van Koophandel en Fabrieken in Nederland (Association of Chambers of Commerce and Industry in the Netherlands), Scheme (EDIRA compliant)
     */
    const ICD_0106 = "0106";

    /**
     * Directorates of the European Commission
     */
    const ICD_0130 = "0130";

    /**
     * SIA Object Identifiers
     */
    const ICD_0135 = "0135";

    /**
     * SECETI Object Identifiers
     */
    const ICD_0142 = "0142";

    /**
     * Australian Business Number (ABN) Scheme
     */
    const ICD_0151 = "0151";

    /**
     * Numéro d'identification suisse des enterprises (IDE), Swiss Unique Business Identification Number (UIDB)
     */
    const ICD_0183 = "0183";

    /**
     * DIGSTORG
     */
    const ICD_0184 = "0184";

    /**
     * Dutch Originator's Identification Number
     */
    const ICD_0190 = "0190";

    /**
     * Centre of Registers and Information Systems of the Ministry of Justice
     */
    const ICD_0191 = "0191";

    /**
     * Enhetsregisteret ved Bronnoysundregisterne
     */
    const ICD_0192 = "0192";

    /**
     * UBL.BE party identifier
     */
    const ICD_0193 = "0193";

    /**
     * KOIOS Open Technical Dictionary
     */
    const ICD_0194 = "0194";

    /**
     * Singapore UEN identifier
     */
    const ICD_0195 = "0195";

    /**
     * Kennitala - Iceland legal id for individuals and legal entities
     */
    const ICD_0196 = "0196";

    /**
     * ERSTORG
     */
    const ICD_0198 = "0198";

    /**
     * Legal Entity Identifier (LEI)
     */
    const ICD_0199 = "0199";

    /**
     * Legal entity code (Lithuania)
     */
    const ICD_0200 = "0200";

    /**
     * Codice Univoco Unità Organizzativa iPA
     */
    const ICD_0201 = "0201";

    /**
     * Indirizzo di Posta Elettronica Certificata
     */
    const ICD_0202 = "0202";

    /**
     * eDelivery Network Participant identifier
     */
    const ICD_0203 = "0203";

    /**
     * Leitweg-ID
     */
    const ICD_0204 = "0204";

    /**
     * Numero d'entreprise / ondernemingsnummer / Unternehmensnummer
     */
    const ICD_0208 = "0208";

    /**
     * GS1 identification keys
     */
    const ICD_0209 = "0209";

    /**
     * CODICE FISCALE
     */
    const ICD_0210 = "0210";

    /**
     * PARTITA IVA
     */
    const ICD_0211 = "0211";

    /**
     * Finnish Organization Identifier
     */
    const ICD_0212 = "0212";

    /**
     * Finnish Organization Value Add Tax Identifier
     */
    const ICD_0213 = "0213";

    /**
     * Danish Ministry of the Interior and Health
     */
    const PEPPOL_9901 = "9901";

    /**
     * The Danish Commerce and Companies Agency
     */
    const PEPPOL_9902 = "9902";

    /**
     * Danish Ministry of Taxation, Central Customs and Tax Administration
     */
    const PEPPOL_9904 = "9904";

    /**
     * Danish VANS providers
     */
    const PEPPOL_9905 = "9905";

    /**
     * Ufficio responsabile gestione partite IVA
     */
    const PEPPOL_9906 = "9906";

    /**
     * TAX Authority
     */
    const PEPPOL_9907 = "9907";

    /**
     * Hungary VAT number
     */
    const PEPPOL_9910 = "9910";

    /**
     * Business Registers Network
     */
    const PEPPOL_9913 = "9913";

    /**
     * Österreichische Umsatzsteuer-Identifikationsnummer
     */
    const PEPPOL_9914 = "9914";

    /**
     * Österreichisches Verwaltungs bzw. Organisationskennzeichen
     */
    const PEPPOL_9915 = "9915";

    /**
     * Kennitala - Iceland legal id for organizations and individuals
     */
    const PEPPOL_9917 = "9917";

    /**
     * SOCIETY FOR WORLDWIDE INTERBANK FINANCIAL, TELECOMMUNICATION S.W.I.F.T
     */
    const PEPPOL_9918 = "9918";

    /**
     * Kennziffer des Unternehmensregisters
     */
    const PEPPOL_9919 = "9919";

    /**
     * Agencia Española de Administración Tributaria
     */
    const PEPPOL_9920 = "9920";

    /**
     * Indice delle Pubbliche Amministrazioni
     */
    const PEPPOL_9921 = "9921";

    /**
     * Andorra VAT number
     */
    const PEPPOL_9922 = "9922";

    /**
     * Albania VAT number
     */
    const PEPPOL_9923 = "9923";

    /**
     * Bosnia and Herzegovina VAT number
     */
    const PEPPOL_9924 = "9924";

    /**
     * Belgium VAT number
     */
    const PEPPOL_9925 = "9925";

    /**
     * Bulgaria VAT number
     */
    const PEPPOL_9926 = "9926";

    /**
     * Switzerland VAT number
     */
    const PEPPOL_9927 = "9927";

    /**
     * Cyprus VAT number
     */
    const PEPPOL_9928 = "9928";

    /**
     * Czech Republic VAT number
     */
    const PEPPOL_9929 = "9929";

    /**
     * Germany VAT number
     */
    const PEPPOL_9930 = "9930";

    /**
     * Estonia VAT number
     */
    const PEPPOL_9931 = "9931";

    /**
     * United Kingdom VAT number
     */
    const PEPPOL_9932 = "9932";

    /**
     * Greece VAT number
     */
    const PEPPOL_9933 = "9933";

    /**
     * Croatia VAT number
     */
    const PEPPOL_9934 = "9934";

    /**
     * Ireland VAT number
     */
    const PEPPOL_9935 = "9935";

    /**
     * Liechtenstein VAT number
     */
    const PEPPOL_9936 = "9936";

    /**
     * Lithuania VAT number
     */
    const PEPPOL_9937 = "9937";

    /**
     * Luxemburg VAT number
     */
    const PEPPOL_9938 = "9938";

    /**
     * Latvia VAT number
     */
    const PEPPOL_9939 = "9939";

    /**
     * Monaco VAT number
     */
    const PEPPOL_9940 = "9940";

    /**
     * Montenegro VAT number
     */
    const PEPPOL_9941 = "9941";

    /**
     * Macedonia, the former Yugoslav Republic of VAT number
     */
    const PEPPOL_9942 = "9942";

    /**
     * Malta VAT number
     */
    const PEPPOL_9943 = "9943";

    /**
     * Netherlands VAT number
     */
    const PEPPOL_9944 = "9944";

    /**
     * Poland VAT number
     */
    const PEPPOL_9945 = "9945";

    /**
     * Portugal VAT number
     */
    const PEPPOL_9946 = "9946";

    /**
     * Romania VAT number
     */
    const PEPPOL_9947 = "9947";

    /**
     * Serbia VAT number
     */
    const PEPPOL_9948 = "9948";

    /**
     * Slovenia VAT number
     */
    const PEPPOL_9949 = "9949";

    /**
     * Slovakia VAT number
     */
    const PEPPOL_9950 = "9950";

    /**
     * San Marino VAT number
     */
    const PEPPOL_9951 = "9951";

    /**
     * Turkey VAT number
     */
    const PEPPOL_9952 = "9952";

    /**
     * Holy See (Vatican City State) VAT number
     */
    const PEPPOL_9953 = "9953";

    /**
     * Swedish VAT number
     */
    const PEPPOL_9955 = "9955";

    /**
     * Belgian Crossroad Bank of Enterprises
     */
    const PEPPOL_9956 = "9956";

    /**
     * French VAT number
     */
    const PEPPOL_9957 = "9957";

    /**
     * German Leitweg ID
     */
    const PEPPOL_9958 = "9958";
}
