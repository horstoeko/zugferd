<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the Item type identification codes
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdItemTypeIdentificationCodes: string
{

    /**
     * Product version number
     */
    case UNTDID_7143_AA = 'AA';

    /**
     * Assembly
     */
    case UNTDID_7143_AB = 'AB';

    /**
     * HIBC (Health Industry Bar Code)
     */
    case UNTDID_7143_AC = 'AC';

    /**
     * Cold roll number
     */
    case UNTDID_7143_AD = 'AD';

    /**
     * Hot roll number
     */
    case UNTDID_7143_AE = 'AE';

    /**
     * Slab number
     */
    case UNTDID_7143_AF = 'AF';

    /**
     * Software revision number
     */
    case UNTDID_7143_AG = 'AG';

    /**
     * UPC (Universal Product Code) Consumer package code (1-5-5)
     */
    case UNTDID_7143_AH = 'AH';

    /**
     * UPC (Universal Product Code) Consumer package code (1-5-5-
     */
    case UNTDID_7143_AI = 'AI';

    /**
     * Sample number
     */
    case UNTDID_7143_AJ = 'AJ';

    /**
     * Pack number
     */
    case UNTDID_7143_AK = 'AK';

    /**
     * UPC (Universal Product Code) Shipping container code (1-2-
     */
    case UNTDID_7143_AL = 'AL';

    /**
     * UPC (Universal Product Code)/EAN (European article number)
     */
    case UNTDID_7143_AM = 'AM';

    /**
     * UPC (Universal Product Code) suffix
     */
    case UNTDID_7143_AN = 'AN';

    /**
     * State label code
     */
    case UNTDID_7143_AO = 'AO';

    /**
     * Heat number
     */
    case UNTDID_7143_AP = 'AP';

    /**
     * Coupon number
     */
    case UNTDID_7143_AQ = 'AQ';

    /**
     * Resource number
     */
    case UNTDID_7143_AR = 'AR';

    /**
     * Work task number
     */
    case UNTDID_7143_AS = 'AS';

    /**
     * Price look up number
     */
    case UNTDID_7143_AT = 'AT';

    /**
     * NSN (North Atlantic Treaty Organization Stock Number)
     */
    case UNTDID_7143_AU = 'AU';

    /**
     * Refined product code
     */
    case UNTDID_7143_AV = 'AV';

    /**
     * Exhibit
     */
    case UNTDID_7143_AW = 'AW';

    /**
     * End item
     */
    case UNTDID_7143_AX = 'AX';

    /**
     * Federal supply classification
     */
    case UNTDID_7143_AY = 'AY';

    /**
     * Engineering data list
     */
    case UNTDID_7143_AZ = 'AZ';

    /**
     * Milestone event number
     */
    case UNTDID_7143_BA = 'BA';

    /**
     * Lot number
     */
    case UNTDID_7143_BB = 'BB';

    /**
     * National drug code 4-4-2 format
     */
    case UNTDID_7143_BC = 'BC';

    /**
     * National drug code 5-3-2 format
     */
    case UNTDID_7143_BD = 'BD';

    /**
     * National drug code 5-4-1 format
     */
    case UNTDID_7143_BE = 'BE';

    /**
     * National drug code 5-4-2 format
     */
    case UNTDID_7143_BF = 'BF';

    /**
     * National drug code
     */
    case UNTDID_7143_BG = 'BG';

    /**
     * Part number
     */
    case UNTDID_7143_BH = 'BH';

    /**
     * Local Stock Number (LSN)
     */
    case UNTDID_7143_BI = 'BI';

    /**
     * Next higher assembly number
     */
    case UNTDID_7143_BJ = 'BJ';

    /**
     * Data category
     */
    case UNTDID_7143_BK = 'BK';

    /**
     * Control number
     */
    case UNTDID_7143_BL = 'BL';

    /**
     * Special material identification code
     */
    case UNTDID_7143_BM = 'BM';

    /**
     * Locally assigned control number
     */
    case UNTDID_7143_BN = 'BN';

    /**
     * Buyer's colour
     */
    case UNTDID_7143_BO = 'BO';

    /**
     * Buyer's part number
     */
    case UNTDID_7143_BP = 'BP';

    /**
     * Variable measure product code
     */
    case UNTDID_7143_BQ = 'BQ';

    /**
     * Financial phase
     */
    case UNTDID_7143_BR = 'BR';

    /**
     * Contract breakdown
     */
    case UNTDID_7143_BS = 'BS';

    /**
     * Technical phase
     */
    case UNTDID_7143_BT = 'BT';

    /**
     * Dye lot number
     */
    case UNTDID_7143_BU = 'BU';

    /**
     * Daily statement of activities
     */
    case UNTDID_7143_BV = 'BV';

    /**
     * Periodical statement of activities within a bilaterally
     */
    case UNTDID_7143_BW = 'BW';

    /**
     * Calendar week statement of activities
     */
    case UNTDID_7143_BX = 'BX';

    /**
     * Calendar month statement of activities
     */
    case UNTDID_7143_BY = 'BY';

    /**
     * Original equipment number
     */
    case UNTDID_7143_BZ = 'BZ';

    /**
     * Industry commodity code
     */
    case UNTDID_7143_CC = 'CC';

    /**
     * Commodity grouping
     */
    case UNTDID_7143_CG = 'CG';

    /**
     * Colour number
     */
    case UNTDID_7143_CL = 'CL';

    /**
     * Contract number
     */
    case UNTDID_7143_CR = 'CR';

    /**
     * Customs article number
     */
    case UNTDID_7143_CV = 'CV';

    /**
     * Drawing revision number
     */
    case UNTDID_7143_DR = 'DR';

    /**
     * Drawing
     */
    case UNTDID_7143_DW = 'DW';

    /**
     * Engineering change level
     */
    case UNTDID_7143_EC = 'EC';

    /**
     * Material code
     */
    case UNTDID_7143_EF = 'EF';

    /**
     * International Article Numbering Association (EAN)
     */
    case UNTDID_7143_EN = 'EN';

    /**
     * Fish species
     */
    case UNTDID_7143_FS = 'FS';

    /**
     * Buyer's internal product group code
     */
    case UNTDID_7143_GB = 'GB';

    /**
     * National product group code
     */
    case UNTDID_7143_GN = 'GN';

    /**
     * General specification number
     */
    case UNTDID_7143_GS = 'GS';

    /**
     * Harmonised system
     */
    case UNTDID_7143_HS = 'HS';

    /**
     * ISBN (International Standard Book Number)
     */
    case UNTDID_7143_IB = 'IB';

    /**
     * Buyer's item number
     */
    case UNTDID_7143_IN = 'IN';

    /**
     * ISSN (International Standard Serial Number)
     */
    case UNTDID_7143_IS = 'IS';

    /**
     * Buyer's style number
     */
    case UNTDID_7143_IT = 'IT';

    /**
     * Buyer's size code
     */
    case UNTDID_7143_IZ = 'IZ';

    /**
     * Machine number
     */
    case UNTDID_7143_MA = 'MA';

    /**
     * Manufacturer's (producer's) article number
     */
    case UNTDID_7143_MF = 'MF';

    /**
     * Model number
     */
    case UNTDID_7143_MN = 'MN';

    /**
     * Product/service identification number
     */
    case UNTDID_7143_MP = 'MP';

    /**
     * Batch number
     */
    case UNTDID_7143_NB = 'NB';

    /**
     * Customer order number
     */
    case UNTDID_7143_ON = 'ON';

    /**
     * Part number description
     */
    case UNTDID_7143_PD = 'PD';

    /**
     * Purchaser's order line number
     */
    case UNTDID_7143_PL = 'PL';

    /**
     * Purchase order number
     */
    case UNTDID_7143_PO = 'PO';

    /**
     * Promotional variant number
     */
    case UNTDID_7143_PV = 'PV';

    /**
     * Buyer's qualifier for size
     */
    case UNTDID_7143_QS = 'QS';

    /**
     * Returnable container number
     */
    case UNTDID_7143_RC = 'RC';

    /**
     * Release number
     */
    case UNTDID_7143_RN = 'RN';

    /**
     * Run number
     */
    case UNTDID_7143_RU = 'RU';

    /**
     * Record keeping of model year
     */
    case UNTDID_7143_RY = 'RY';

    /**
     * Supplier's article number
     */
    case UNTDID_7143_SA = 'SA';

    /**
     * Standard group of products (mixed assortment)
     */
    case UNTDID_7143_SG = 'SG';

    /**
     * SKU (Stock keeping unit)
     */
    case UNTDID_7143_SK = 'SK';

    /**
     * Serial number
     */
    case UNTDID_7143_SN = 'SN';

    /**
     * RSK number
     */
    case UNTDID_7143_SRS = 'SRS';

    /**
     * IFLS (Institut Francais du Libre Service) 5 digit product
     */
    case UNTDID_7143_SRT = 'SRT';

    /**
     * IFLS (Institut Francais du Libre Service) 9 digit product
     */
    case UNTDID_7143_SRU = 'SRU';

    /**
     * GS1 Global Trade Item Number
     */
    case UNTDID_7143_SRV = 'SRV';

    /**
     * EDIS (Energy Data Identification System)
     */
    case UNTDID_7143_SRW = 'SRW';

    /**
     * Slaughter number
     */
    case UNTDID_7143_SRX = 'SRX';

    /**
     * Official animal number
     */
    case UNTDID_7143_SRY = 'SRY';

    /**
     * Harmonized tariff schedule
     */
    case UNTDID_7143_SRZ = 'SRZ';

    /**
     * Supplier's supplier article number
     */
    case UNTDID_7143_SS = 'SS';

    /**
     * 46 Level DOT Code
     */
    case UNTDID_7143_SSA = 'SSA';

    /**
     * Airline Tariff 6D
     */
    case UNTDID_7143_SSB = 'SSB';

    /**
     * Title 49 Code of Federal Regulations
     */
    case UNTDID_7143_SSC = 'SSC';

    /**
     * International Civil Aviation Administration code
     */
    case UNTDID_7143_SSD = 'SSD';

    /**
     * Hazardous Materials ID DOT
     */
    case UNTDID_7143_SSE = 'SSE';

    /**
     * Endorsement
     */
    case UNTDID_7143_SSF = 'SSF';

    /**
     * Air Force Regulation 71-4
     */
    case UNTDID_7143_SSG = 'SSG';

    /**
     * Breed
     */
    case UNTDID_7143_SSH = 'SSH';

    /**
     * Chemical Abstract Service (CAS) registry number
     */
    case UNTDID_7143_SSI = 'SSI';

    /**
     * Engine model designation
     */
    case UNTDID_7143_SSJ = 'SSJ';

    /**
     * Institutional Meat Purchase Specifications (IMPS) Number
     */
    case UNTDID_7143_SSK = 'SSK';

    /**
     * Price Look-Up code (PLU)
     */
    case UNTDID_7143_SSL = 'SSL';

    /**
     * International Maritime Organization (IMO) Code
     */
    case UNTDID_7143_SSM = 'SSM';

    /**
     * Bureau of Explosives 600-A (rail)
     */
    case UNTDID_7143_SSN = 'SSN';

    /**
     * United Nations Dangerous Goods List
     */
    case UNTDID_7143_SSO = 'SSO';

    /**
     * International Code of Botanical Nomenclature (ICBN)
     */
    case UNTDID_7143_SSP = 'SSP';

    /**
     * International Code of Zoological Nomenclature (ICZN)
     */
    case UNTDID_7143_SSQ = 'SSQ';

    /**
     * International Code of Nomenclature for Cultivated Plants
     */
    case UNTDID_7143_SSR = 'SSR';

    /**
     * Distributor’s article identifier
     */
    case UNTDID_7143_SSS = 'SSS';

    /**
     * Norwegian Classification system ENVA
     */
    case UNTDID_7143_SST = 'SST';

    /**
     * Supplier assigned classification
     */
    case UNTDID_7143_SSU = 'SSU';

    /**
     * Mexican classification system AMECE
     */
    case UNTDID_7143_SSV = 'SSV';

    /**
     * German classification system CCG
     */
    case UNTDID_7143_SSW = 'SSW';

    /**
     * Finnish classification system EANFIN
     */
    case UNTDID_7143_SSX = 'SSX';

    /**
     * Canadian classification system ICC
     */
    case UNTDID_7143_SSY = 'SSY';

    /**
     * French classification system IFLS5
     */
    case UNTDID_7143_SSZ = 'SSZ';

    /**
     * Style number
     */
    case UNTDID_7143_ST = 'ST';

    /**
     * Dutch classification system CBL
     */
    case UNTDID_7143_STA = 'STA';

    /**
     * Japanese classification system JICFS
     */
    case UNTDID_7143_STB = 'STB';

    /**
     * European Union dairy subsidy eligibility classification
     */
    case UNTDID_7143_STC = 'STC';

    /**
     * GS1 Spain classification system
     */
    case UNTDID_7143_STD = 'STD';

    /**
     * GS1 Poland classification system
     */
    case UNTDID_7143_STE = 'STE';

    /**
     * Federal Agency on Technical Regulating and Metrology of the
     */
    case UNTDID_7143_STF = 'STF';

    /**
     * Efficient Consumer Response (ECR) Austria classification
     */
    case UNTDID_7143_STG = 'STG';

    /**
     * GS1 Italy classification system
     */
    case UNTDID_7143_STH = 'STH';

    /**
     * CPV (Common Procurement Vocabulary)
     */
    case UNTDID_7143_STI = 'STI';

    /**
     * IFDA (International Foodservice Distributors Association)
     */
    case UNTDID_7143_STJ = 'STJ';

    /**
     * AHFS (American Hospital Formulary Service) pharmacologic -
     */
    case UNTDID_7143_STK = 'STK';

    /**
     * ATC (Anatomical Therapeutic Chemical) classification system
     */
    case UNTDID_7143_STL = 'STL';

    /**
     * CLADIMED (Classification des Dispositifs Médicaux)
     */
    case UNTDID_7143_STM = 'STM';

    /**
     * CMDR (Canadian Medical Device Regulations) classification
     */
    case UNTDID_7143_STN = 'STN';

    /**
     * CNDM (Classificazione Nazionale dei Dispositivi Medici)
     */
    case UNTDID_7143_STO = 'STO';

    /**
     * UK DM&D (Dictionary of Medicines & Devices) standard coding
     */
    case UNTDID_7143_STP = 'STP';

    /**
     * eCl@ss
     */
    case UNTDID_7143_STQ = 'STQ';

    /**
     * EDMA (European Diagnostic Manufacturers Association)
     */
    case UNTDID_7143_STR = 'STR';

    /**
     * EGAR (European Generic Article Register)
     */
    case UNTDID_7143_STS = 'STS';

    /**
     * GMDN (Global Medical Devices Nomenclature)
     */
    case UNTDID_7143_STT = 'STT';

    /**
     * GPI (Generic Product Identifier)
     */
    case UNTDID_7143_STU = 'STU';

    /**
     * HCPCS (Healthcare Common Procedure Coding System)
     */
    case UNTDID_7143_STV = 'STV';

    /**
     * ICPS (International Classification for Patient Safety)
     */
    case UNTDID_7143_STW = 'STW';

    /**
     * MedDRA (Medical Dictionary for Regulatory Activities)
     */
    case UNTDID_7143_STX = 'STX';

    /**
     * Medical Columbus
     */
    case UNTDID_7143_STY = 'STY';

    /**
     * NAPCS (North American Product Classification System)
     */
    case UNTDID_7143_STZ = 'STZ';

    /**
     * NHS (National Health Services) eClass
     */
    case UNTDID_7143_SUA = 'SUA';

    /**
     * US FDA (Food and Drug Administration) Product Code
     */
    case UNTDID_7143_SUB = 'SUB';

    /**
     * SNOMED CT (Systematized Nomenclature of Medicine-Clinical
     */
    case UNTDID_7143_SUC = 'SUC';

    /**
     * UMDNS (Universal Medical Device Nomenclature System)
     */
    case UNTDID_7143_SUD = 'SUD';

    /**
     * GS1 Global Returnable Asset Identifier, non-serialised
     */
    case UNTDID_7143_SUE = 'SUE';

    /**
     * IMEI
     */
    case UNTDID_7143_SUF = 'SUF';

    /**
     * Waste Type (EMSA)
     */
    case UNTDID_7143_SUG = 'SUG';

    /**
     * Ship's store classification type
     */
    case UNTDID_7143_SUH = 'SUH';

    /**
     * Emergency fire code
     */
    case UNTDID_7143_SUI = 'SUI';

    /**
     * Emergency spillage code
     */
    case UNTDID_7143_SUJ = 'SUJ';

    /**
     * IMDG packing group
     */
    case UNTDID_7143_SUK = 'SUK';

    /**
     * MARPOL Code IBC
     */
    case UNTDID_7143_SUL = 'SUL';

    /**
     * IMDG subsidiary risk class
     */
    case UNTDID_7143_SUM = 'SUM';

    /**
     * Transport group number
     */
    case UNTDID_7143_TG = 'TG';

    /**
     * Taxonomic Serial Number
     */
    case UNTDID_7143_TSN = 'TSN';

    /**
     * IMDG main hazard class
     */
    case UNTDID_7143_TSO = 'TSO';

    /**
     * EU Combined Nomenclature
     */
    case UNTDID_7143_TSP = 'TSP';

    /**
     * Therapeutic classification number
     */
    case UNTDID_7143_TSQ = 'TSQ';

    /**
     * European Waste Catalogue
     */
    case UNTDID_7143_TSR = 'TSR';

    /**
     * Price grouping code
     */
    case UNTDID_7143_TSS = 'TSS';

    /**
     * UNSPSC
     */
    case UNTDID_7143_TST = 'TST';

    /**
     * Ultimate customer's article number
     */
    case UNTDID_7143_UA = 'UA';

    /**
     * UPC (Universal product code)
     */
    case UNTDID_7143_UP = 'UP';

    /**
     * Vendor item number
     */
    case UNTDID_7143_VN = 'VN';

    /**
     * Vendor's (seller's) part number
     */
    case UNTDID_7143_VP = 'VP';

    /**
     * Vendor's supplemental item number
     */
    case UNTDID_7143_VS = 'VS';

    /**
     * Vendor specification number
     */
    case UNTDID_7143_VX = 'VX';

    /**
     * Mutually defined
     */
    case UNTDID_7143_ZZZ = 'ZZZ';
}
