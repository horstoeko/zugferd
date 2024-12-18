<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

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
enum ZugferdElectronicAddressScheme: string
{

    /**
     * O.F.T.P. (ODETTE File Transfer Protocol)
     */
    case UNECE3155_AN = "AN";

    /**
     * X.400 address for mail text
     */
    case UNECE3155_AQ = "AQ";

    /**
     * AS2 exchange
     */
    case UNECE3155_AS = "AS";

    /**
     * File Transfer Protocol
     */
    case UNECE3155_AU = "AU";

    /**
     * Electronic mail (SMTP)
     */
    case UNECE3155_EM = "EM";

    /**
     * System Information et Repertoire des Entreprise et des Etablissements: SIRENE
     */
    case ICD_0002 = "0002";

    /**
     * Organisationsnummer
     */
    case ICD_0007 = "0007";

    /**
     * SIRET-CODE
     */
    case ICD_0009 = "0009";

    /**
     * LY-tunnus
     */
    case ICD_0037 = "0037";

    /**
     * Data Universal Numbering System (D-U-N-S Number)
     */
    case ICD_0060 = "0060";

    /**
     * EAN Location Code
     */
    case ICD_0088 = "0088";

    /**
     * DANISH CHAMBER OF COMMERCE Scheme (EDIRA compliant)
     */
    case ICD_0096 = "0096";

    /**
     * FTI - Ediforum Italia, (EDIRA compliant)
     */
    case ICD_0097 = "0097";

    /**
     * Vereniging van Kamers van Koophandel en Fabrieken in Nederland (Association of Chambers of Commerce and Industry in the Netherlands), Scheme (EDIRA compliant)
     */
    case ICD_0106 = "0106";

    /**
     * Directorates of the European Commission
     */
    case ICD_0130 = "0130";

    /**
     * SIA Object Identifiers
     */
    case ICD_0135 = "0135";

    /**
     * SECETI Object Identifiers
     */
    case ICD_0142 = "0142";

    /**
     * Australian Business Number (ABN) Scheme
     */
    case ICD_0151 = "0151";

    /**
     * Numéro d'identification suisse des enterprises (IDE), Swiss Unique Business Identification Number (UIDB)
     */
    case ICD_0183 = "0183";

    /**
     * DIGSTORG
     */
    case ICD_0184 = "0184";

    /**
     * Dutch Originator's Identification Number
     */
    case ICD_0190 = "0190";

    /**
     * Centre of Registers and Information Systems of the Ministry of Justice
     */
    case ICD_0191 = "0191";

    /**
     * Enhetsregisteret ved Bronnoysundregisterne
     */
    case ICD_0192 = "0192";

    /**
     * UBL.BE party identifier
     */
    case ICD_0193 = "0193";

    /**
     * KOIOS Open Technical Dictionary
     */
    case ICD_0194 = "0194";

    /**
     * Singapore UEN identifier
     */
    case ICD_0195 = "0195";

    /**
     * Kennitala - Iceland legal id for individuals and legal entities
     */
    case ICD_0196 = "0196";

    /**
     * ERSTORG
     */
    case ICD_0198 = "0198";

    /**
     * Legal Entity Identifier (LEI)
     */
    case ICD_0199 = "0199";

    /**
     * Legal entity code (Lithuania)
     */
    case ICD_0200 = "0200";

    /**
     * Codice Univoco Unità Organizzativa iPA
     */
    case ICD_0201 = "0201";

    /**
     * Indirizzo di Posta Elettronica Certificata
     */
    case ICD_0202 = "0202";

    /**
     * eDelivery Network Participant identifier
     */
    case ICD_0203 = "0203";

    /**
     * Leitweg-ID
     */
    case ICD_0204 = "0204";

    /**
     * Numero d'entreprise / ondernemingsnummer / Unternehmensnummer
     */
    case ICD_0208 = "0208";

    /**
     * GS1 identification keys
     */
    case ICD_0209 = "0209";

    /**
     * CODICE FISCALE
     */
    case ICD_0210 = "0210";

    /**
     * PARTITA IVA
     */
    case ICD_0211 = "0211";

    /**
     * Finnish Organization Identifier
     */
    case ICD_0212 = "0212";

    /**
     * Finnish Organization Value Add Tax Identifier
     */
    case ICD_0213 = "0213";

    /**
     * Danish Ministry of the Interior and Health
     */
    case PEPPOL_9901 = "9901";

    /**
     * The Danish Commerce and Companies Agency
     */
    case PEPPOL_9902 = "9902";

    /**
     * Danish Ministry of Taxation, Central Customs and Tax Administration
     */
    case PEPPOL_9904 = "9904";

    /**
     * Danish VANS providers
     */
    case PEPPOL_9905 = "9905";

    /**
     * Ufficio responsabile gestione partite IVA
     */
    case PEPPOL_9906 = "9906";

    /**
     * TAX Authority
     */
    case PEPPOL_9907 = "9907";

    /**
     * Hungary VAT number
     */
    case PEPPOL_9910 = "9910";

    /**
     * Business Registers Network
     */
    case PEPPOL_9913 = "9913";

    /**
     * Österreichische Umsatzsteuer-Identifikationsnummer
     */
    case PEPPOL_9914 = "9914";

    /**
     * Österreichisches Verwaltungs bzw. Organisationskennzeichen
     */
    case PEPPOL_9915 = "9915";

    /**
     * Kennitala - Iceland legal id for organizations and individuals
     */
    case PEPPOL_9917 = "9917";

    /**
     * SOCIETY FOR WORLDWIDE INTERBANK FINANCIAL, TELECOMMUNICATION S.W.I.F.T
     */
    case PEPPOL_9918 = "9918";

    /**
     * Kennziffer des Unternehmensregisters
     */
    case PEPPOL_9919 = "9919";

    /**
     * Agencia Española de Administración Tributaria
     */
    case PEPPOL_9920 = "9920";

    /**
     * Indice delle Pubbliche Amministrazioni
     */
    case PEPPOL_9921 = "9921";

    /**
     * Andorra VAT number
     */
    case PEPPOL_9922 = "9922";

    /**
     * Albania VAT number
     */
    case PEPPOL_9923 = "9923";

    /**
     * Bosnia and Herzegovina VAT number
     */
    case PEPPOL_9924 = "9924";

    /**
     * Belgium VAT number
     */
    case PEPPOL_9925 = "9925";

    /**
     * Bulgaria VAT number
     */
    case PEPPOL_9926 = "9926";

    /**
     * Switzerland VAT number
     */
    case PEPPOL_9927 = "9927";

    /**
     * Cyprus VAT number
     */
    case PEPPOL_9928 = "9928";

    /**
     * Czech Republic VAT number
     */
    case PEPPOL_9929 = "9929";

    /**
     * Germany VAT number
     */
    case PEPPOL_9930 = "9930";

    /**
     * Estonia VAT number
     */
    case PEPPOL_9931 = "9931";

    /**
     * United Kingdom VAT number
     */
    case PEPPOL_9932 = "9932";

    /**
     * Greece VAT number
     */
    case PEPPOL_9933 = "9933";

    /**
     * Croatia VAT number
     */
    case PEPPOL_9934 = "9934";

    /**
     * Ireland VAT number
     */
    case PEPPOL_9935 = "9935";

    /**
     * Liechtenstein VAT number
     */
    case PEPPOL_9936 = "9936";

    /**
     * Lithuania VAT number
     */
    case PEPPOL_9937 = "9937";

    /**
     * Luxemburg VAT number
     */
    case PEPPOL_9938 = "9938";

    /**
     * Latvia VAT number
     */
    case PEPPOL_9939 = "9939";

    /**
     * Monaco VAT number
     */
    case PEPPOL_9940 = "9940";

    /**
     * Montenegro VAT number
     */
    case PEPPOL_9941 = "9941";

    /**
     * Macedonia, the former Yugoslav Republic of VAT number
     */
    case PEPPOL_9942 = "9942";

    /**
     * Malta VAT number
     */
    case PEPPOL_9943 = "9943";

    /**
     * Netherlands VAT number
     */
    case PEPPOL_9944 = "9944";

    /**
     * Poland VAT number
     */
    case PEPPOL_9945 = "9945";

    /**
     * Portugal VAT number
     */
    case PEPPOL_9946 = "9946";

    /**
     * Romania VAT number
     */
    case PEPPOL_9947 = "9947";

    /**
     * Serbia VAT number
     */
    case PEPPOL_9948 = "9948";

    /**
     * Slovenia VAT number
     */
    case PEPPOL_9949 = "9949";

    /**
     * Slovakia VAT number
     */
    case PEPPOL_9950 = "9950";

    /**
     * San Marino VAT number
     */
    case PEPPOL_9951 = "9951";

    /**
     * Turkey VAT number
     */
    case PEPPOL_9952 = "9952";

    /**
     * Holy See (Vatican City State) VAT number
     */
    case PEPPOL_9953 = "9953";

    /**
     * Swedish VAT number
     */
    case PEPPOL_9955 = "9955";

    /**
     * Belgian Crossroad Bank of Enterprises
     */
    case PEPPOL_9956 = "9956";

    /**
     * French VAT number
     */
    case PEPPOL_9957 = "9957";

    /**
     * German Leitweg ID
     */
    case PEPPOL_9958 = "9958";
}
