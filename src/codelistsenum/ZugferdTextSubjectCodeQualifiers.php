<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the Text subject code qualifiers
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdTextSubjectCodeQualifiers: string
{

    /**
     * Goods item description
     */
    case UNTDID_4451_AAA = 'AAA';

    /**
     * Payment term
     */
    case UNTDID_4451_AAB = 'AAB';

    /**
     * Dangerous goods additional information
     */
    case UNTDID_4451_AAC = 'AAC';

    /**
     * Dangerous goods technical name
     */
    case UNTDID_4451_AAD = 'AAD';

    /**
     * Acknowledgement description
     */
    case UNTDID_4451_AAE = 'AAE';

    /**
     * Rate additional information
     */
    case UNTDID_4451_AAF = 'AAF';

    /**
     * Party instructions
     */
    case UNTDID_4451_AAG = 'AAG';

    /**
     * General information
     */
    case UNTDID_4451_AAI = 'AAI';

    /**
     * Additional conditions of sale/purchase
     */
    case UNTDID_4451_AAJ = 'AAJ';

    /**
     * Price conditions
     */
    case UNTDID_4451_AAK = 'AAK';

    /**
     * Goods dimensions in characters
     */
    case UNTDID_4451_AAL = 'AAL';

    /**
     * Equipment re-usage restrictions
     */
    case UNTDID_4451_AAM = 'AAM';

    /**
     * Handling restriction
     */
    case UNTDID_4451_AAN = 'AAN';

    /**
     * Error description (free text)
     */
    case UNTDID_4451_AAO = 'AAO';

    /**
     * Response (free text)
     */
    case UNTDID_4451_AAP = 'AAP';

    /**
     * Package content's description
     */
    case UNTDID_4451_AAQ = 'AAQ';

    /**
     * Terms of delivery
     */
    case UNTDID_4451_AAR = 'AAR';

    /**
     * Bill of lading remarks
     */
    case UNTDID_4451_AAS = 'AAS';

    /**
     * Mode of settlement information
     */
    case UNTDID_4451_AAT = 'AAT';

    /**
     * Consignment invoice information
     */
    case UNTDID_4451_AAU = 'AAU';

    /**
     * Clearance invoice information
     */
    case UNTDID_4451_AAV = 'AAV';

    /**
     * Letter of credit information
     */
    case UNTDID_4451_AAW = 'AAW';

    /**
     * License information
     */
    case UNTDID_4451_AAX = 'AAX';

    /**
     * Certification statements
     */
    case UNTDID_4451_AAY = 'AAY';

    /**
     * Additional export information
     */
    case UNTDID_4451_AAZ = 'AAZ';

    /**
     * Tariff statements
     */
    case UNTDID_4451_ABA = 'ABA';

    /**
     * Medical history
     */
    case UNTDID_4451_ABB = 'ABB';

    /**
     * Conditions of sale or purchase
     */
    case UNTDID_4451_ABC = 'ABC';

    /**
     * Contract document type
     */
    case UNTDID_4451_ABD = 'ABD';

    /**
     * Additional terms and/or conditions (documentary credit)
     */
    case UNTDID_4451_ABE = 'ABE';

    /**
     * Instructions or information about standby documentary
     */
    case UNTDID_4451_ABF = 'ABF';

    /**
     * Instructions or information about partial shipment(s)
     */
    case UNTDID_4451_ABG = 'ABG';

    /**
     * Instructions or information about transhipment(s)
     */
    case UNTDID_4451_ABH = 'ABH';

    /**
     * Additional handling instructions documentary credit
     */
    case UNTDID_4451_ABI = 'ABI';

    /**
     * Domestic routing information
     */
    case UNTDID_4451_ABJ = 'ABJ';

    /**
     * Chargeable category of equipment
     */
    case UNTDID_4451_ABK = 'ABK';

    /**
     * Government information
     */
    case UNTDID_4451_ABL = 'ABL';

    /**
     * Onward routing information
     */
    case UNTDID_4451_ABM = 'ABM';

    /**
     * Accounting information
     */
    case UNTDID_4451_ABN = 'ABN';

    /**
     * Discrepancy information
     */
    case UNTDID_4451_ABO = 'ABO';

    /**
     * Confirmation instructions
     */
    case UNTDID_4451_ABP = 'ABP';

    /**
     * Method of issuance
     */
    case UNTDID_4451_ABQ = 'ABQ';

    /**
     * Documents delivery instructions
     */
    case UNTDID_4451_ABR = 'ABR';

    /**
     * Additional conditions
     */
    case UNTDID_4451_ABS = 'ABS';

    /**
     * Information/instructions about additional amounts covered
     */
    case UNTDID_4451_ABT = 'ABT';

    /**
     * Deferred payment termed additional
     */
    case UNTDID_4451_ABU = 'ABU';

    /**
     * Acceptance terms additional
     */
    case UNTDID_4451_ABV = 'ABV';

    /**
     * Negotiation terms additional
     */
    case UNTDID_4451_ABW = 'ABW';

    /**
     * Document name and documentary requirements
     */
    case UNTDID_4451_ABX = 'ABX';

    /**
     * Instructions/information about revolving documentary credit
     */
    case UNTDID_4451_ABZ = 'ABZ';

    /**
     * Documentary requirements
     */
    case UNTDID_4451_ACA = 'ACA';

    /**
     * Additional information
     */
    case UNTDID_4451_ACB = 'ACB';

    /**
     * Factor assignment clause
     */
    case UNTDID_4451_ACC = 'ACC';

    /**
     * Reason
     */
    case UNTDID_4451_ACD = 'ACD';

    /**
     * Dispute
     */
    case UNTDID_4451_ACE = 'ACE';

    /**
     * Additional attribute information
     */
    case UNTDID_4451_ACF = 'ACF';

    /**
     * Absence declaration
     */
    case UNTDID_4451_ACG = 'ACG';

    /**
     * Aggregation statement
     */
    case UNTDID_4451_ACH = 'ACH';

    /**
     * Compilation statement
     */
    case UNTDID_4451_ACI = 'ACI';

    /**
     * Definitional exception
     */
    case UNTDID_4451_ACJ = 'ACJ';

    /**
     * Privacy statement
     */
    case UNTDID_4451_ACK = 'ACK';

    /**
     * Quality statement
     */
    case UNTDID_4451_ACL = 'ACL';

    /**
     * Statistical description
     */
    case UNTDID_4451_ACM = 'ACM';

    /**
     * Statistical definition
     */
    case UNTDID_4451_ACN = 'ACN';

    /**
     * Statistical name
     */
    case UNTDID_4451_ACO = 'ACO';

    /**
     * Statistical title
     */
    case UNTDID_4451_ACP = 'ACP';

    /**
     * Off-dimension information
     */
    case UNTDID_4451_ACQ = 'ACQ';

    /**
     * Unexpected stops information
     */
    case UNTDID_4451_ACR = 'ACR';

    /**
     * Principles
     */
    case UNTDID_4451_ACS = 'ACS';

    /**
     * Terms and definition
     */
    case UNTDID_4451_ACT = 'ACT';

    /**
     * Segment name
     */
    case UNTDID_4451_ACU = 'ACU';

    /**
     * Simple data element name
     */
    case UNTDID_4451_ACV = 'ACV';

    /**
     * Scope
     */
    case UNTDID_4451_ACW = 'ACW';

    /**
     * Message type name
     */
    case UNTDID_4451_ACX = 'ACX';

    /**
     * Introduction
     */
    case UNTDID_4451_ACY = 'ACY';

    /**
     * Glossary
     */
    case UNTDID_4451_ACZ = 'ACZ';

    /**
     * Functional definition
     */
    case UNTDID_4451_ADA = 'ADA';

    /**
     * Examples
     */
    case UNTDID_4451_ADB = 'ADB';

    /**
     * Cover page
     */
    case UNTDID_4451_ADC = 'ADC';

    /**
     * Dependency (syntax) notes
     */
    case UNTDID_4451_ADD = 'ADD';

    /**
     * Code value name
     */
    case UNTDID_4451_ADE = 'ADE';

    /**
     * Code list name
     */
    case UNTDID_4451_ADF = 'ADF';

    /**
     * Clarification of usage
     */
    case UNTDID_4451_ADG = 'ADG';

    /**
     * Composite data element name
     */
    case UNTDID_4451_ADH = 'ADH';

    /**
     * Field of application
     */
    case UNTDID_4451_ADI = 'ADI';

    /**
     * Type of assets and liabilities
     */
    case UNTDID_4451_ADJ = 'ADJ';

    /**
     * Promotion information
     */
    case UNTDID_4451_ADK = 'ADK';

    /**
     * Meter condition
     */
    case UNTDID_4451_ADL = 'ADL';

    /**
     * Meter reading information
     */
    case UNTDID_4451_ADM = 'ADM';

    /**
     * Type of transaction reason
     */
    case UNTDID_4451_ADN = 'ADN';

    /**
     * Type of survey question
     */
    case UNTDID_4451_ADO = 'ADO';

    /**
     * Carrier's agent counter information
     */
    case UNTDID_4451_ADP = 'ADP';

    /**
     * Description of work item on equipment
     */
    case UNTDID_4451_ADQ = 'ADQ';

    /**
     * Message definition
     */
    case UNTDID_4451_ADR = 'ADR';

    /**
     * Booked item information
     */
    case UNTDID_4451_ADS = 'ADS';

    /**
     * Source of document
     */
    case UNTDID_4451_ADT = 'ADT';

    /**
     * Note
     */
    case UNTDID_4451_ADU = 'ADU';

    /**
     * Fixed part of segment clarification text
     */
    case UNTDID_4451_ADV = 'ADV';

    /**
     * Characteristics of goods
     */
    case UNTDID_4451_ADW = 'ADW';

    /**
     * Additional discharge instructions
     */
    case UNTDID_4451_ADX = 'ADX';

    /**
     * Container stripping instructions
     */
    case UNTDID_4451_ADY = 'ADY';

    /**
     * CSC (Container Safety Convention) plate information
     */
    case UNTDID_4451_ADZ = 'ADZ';

    /**
     * Cargo remarks
     */
    case UNTDID_4451_AEA = 'AEA';

    /**
     * Temperature control instructions
     */
    case UNTDID_4451_AEB = 'AEB';

    /**
     * Text refers to expected data
     */
    case UNTDID_4451_AEC = 'AEC';

    /**
     * Text refers to received data
     */
    case UNTDID_4451_AED = 'AED';

    /**
     * Section clarification text
     */
    case UNTDID_4451_AEE = 'AEE';

    /**
     * Information to the beneficiary
     */
    case UNTDID_4451_AEF = 'AEF';

    /**
     * Information to the applicant
     */
    case UNTDID_4451_AEG = 'AEG';

    /**
     * Instructions to the beneficiary
     */
    case UNTDID_4451_AEH = 'AEH';

    /**
     * Instructions to the applicant
     */
    case UNTDID_4451_AEI = 'AEI';

    /**
     * Controlled atmosphere
     */
    case UNTDID_4451_AEJ = 'AEJ';

    /**
     * Take off annotation
     */
    case UNTDID_4451_AEK = 'AEK';

    /**
     * Price variation narrative
     */
    case UNTDID_4451_AEL = 'AEL';

    /**
     * Documentary credit amendment instructions
     */
    case UNTDID_4451_AEM = 'AEM';

    /**
     * Standard method narrative
     */
    case UNTDID_4451_AEN = 'AEN';

    /**
     * Project narrative
     */
    case UNTDID_4451_AEO = 'AEO';

    /**
     * Radioactive goods, additional information
     */
    case UNTDID_4451_AEP = 'AEP';

    /**
     * Bank-to-bank information
     */
    case UNTDID_4451_AEQ = 'AEQ';

    /**
     * Reimbursement instructions
     */
    case UNTDID_4451_AER = 'AER';

    /**
     * Reason for amending a message
     */
    case UNTDID_4451_AES = 'AES';

    /**
     * Instructions to the paying and/or accepting and/or
     */
    case UNTDID_4451_AET = 'AET';

    /**
     * Interest instructions
     */
    case UNTDID_4451_AEU = 'AEU';

    /**
     * Agent commission
     */
    case UNTDID_4451_AEV = 'AEV';

    /**
     * Remitting bank instructions
     */
    case UNTDID_4451_AEW = 'AEW';

    /**
     * Instructions to the collecting bank
     */
    case UNTDID_4451_AEX = 'AEX';

    /**
     * Collection amount instructions
     */
    case UNTDID_4451_AEY = 'AEY';

    /**
     * Internal auditing information
     */
    case UNTDID_4451_AEZ = 'AEZ';

    /**
     * Constraint
     */
    case UNTDID_4451_AFA = 'AFA';

    /**
     * Comment
     */
    case UNTDID_4451_AFB = 'AFB';

    /**
     * Semantic note
     */
    case UNTDID_4451_AFC = 'AFC';

    /**
     * Help text
     */
    case UNTDID_4451_AFD = 'AFD';

    /**
     * Legend
     */
    case UNTDID_4451_AFE = 'AFE';

    /**
     * Batch code structure
     */
    case UNTDID_4451_AFF = 'AFF';

    /**
     * Product application
     */
    case UNTDID_4451_AFG = 'AFG';

    /**
     * Customer complaint
     */
    case UNTDID_4451_AFH = 'AFH';

    /**
     * Probable cause of fault
     */
    case UNTDID_4451_AFI = 'AFI';

    /**
     * Defect description
     */
    case UNTDID_4451_AFJ = 'AFJ';

    /**
     * Repair description
     */
    case UNTDID_4451_AFK = 'AFK';

    /**
     * Review comments
     */
    case UNTDID_4451_AFL = 'AFL';

    /**
     * Title
     */
    case UNTDID_4451_AFM = 'AFM';

    /**
     * Description of amount
     */
    case UNTDID_4451_AFN = 'AFN';

    /**
     * Responsibilities
     */
    case UNTDID_4451_AFO = 'AFO';

    /**
     * Supplier
     */
    case UNTDID_4451_AFP = 'AFP';

    /**
     * Purchase region
     */
    case UNTDID_4451_AFQ = 'AFQ';

    /**
     * Affiliation
     */
    case UNTDID_4451_AFR = 'AFR';

    /**
     * Borrower
     */
    case UNTDID_4451_AFS = 'AFS';

    /**
     * Line of business
     */
    case UNTDID_4451_AFT = 'AFT';

    /**
     * Financial institution
     */
    case UNTDID_4451_AFU = 'AFU';

    /**
     * Business founder
     */
    case UNTDID_4451_AFV = 'AFV';

    /**
     * Business history
     */
    case UNTDID_4451_AFW = 'AFW';

    /**
     * Banking arrangements
     */
    case UNTDID_4451_AFX = 'AFX';

    /**
     * Business origin
     */
    case UNTDID_4451_AFY = 'AFY';

    /**
     * Brand names' description
     */
    case UNTDID_4451_AFZ = 'AFZ';

    /**
     * Business financing details
     */
    case UNTDID_4451_AGA = 'AGA';

    /**
     * Competition
     */
    case UNTDID_4451_AGB = 'AGB';

    /**
     * Construction process details
     */
    case UNTDID_4451_AGC = 'AGC';

    /**
     * Construction specialty
     */
    case UNTDID_4451_AGD = 'AGD';

    /**
     * Contract information
     */
    case UNTDID_4451_AGE = 'AGE';

    /**
     * Corporate filing
     */
    case UNTDID_4451_AGF = 'AGF';

    /**
     * Customer information
     */
    case UNTDID_4451_AGG = 'AGG';

    /**
     * Copyright notice
     */
    case UNTDID_4451_AGH = 'AGH';

    /**
     * Contingent debt
     */
    case UNTDID_4451_AGI = 'AGI';

    /**
     * Conviction details
     */
    case UNTDID_4451_AGJ = 'AGJ';

    /**
     * Equipment
     */
    case UNTDID_4451_AGK = 'AGK';

    /**
     * Workforce description
     */
    case UNTDID_4451_AGL = 'AGL';

    /**
     * Exemption
     */
    case UNTDID_4451_AGM = 'AGM';

    /**
     * Future plans
     */
    case UNTDID_4451_AGN = 'AGN';

    /**
     * Interviewee conversation information
     */
    case UNTDID_4451_AGO = 'AGO';

    /**
     * Intangible asset
     */
    case UNTDID_4451_AGP = 'AGP';

    /**
     * Inventory
     */
    case UNTDID_4451_AGQ = 'AGQ';

    /**
     * Investment
     */
    case UNTDID_4451_AGR = 'AGR';

    /**
     * Intercompany relations information
     */
    case UNTDID_4451_AGS = 'AGS';

    /**
     * Joint venture
     */
    case UNTDID_4451_AGT = 'AGT';

    /**
     * Loan
     */
    case UNTDID_4451_AGU = 'AGU';

    /**
     * Long term debt
     */
    case UNTDID_4451_AGV = 'AGV';

    /**
     * Location
     */
    case UNTDID_4451_AGW = 'AGW';

    /**
     * Current legal structure
     */
    case UNTDID_4451_AGX = 'AGX';

    /**
     * Marital contract
     */
    case UNTDID_4451_AGY = 'AGY';

    /**
     * Marketing activities
     */
    case UNTDID_4451_AGZ = 'AGZ';

    /**
     * Merger
     */
    case UNTDID_4451_AHA = 'AHA';

    /**
     * Marketable securities
     */
    case UNTDID_4451_AHB = 'AHB';

    /**
     * Business debt
     */
    case UNTDID_4451_AHC = 'AHC';

    /**
     * Original legal structure
     */
    case UNTDID_4451_AHD = 'AHD';

    /**
     * Employee sharing arrangements
     */
    case UNTDID_4451_AHE = 'AHE';

    /**
     * Organization details
     */
    case UNTDID_4451_AHF = 'AHF';

    /**
     * Public record details
     */
    case UNTDID_4451_AHG = 'AHG';

    /**
     * Price range
     */
    case UNTDID_4451_AHH = 'AHH';

    /**
     * Qualifications
     */
    case UNTDID_4451_AHI = 'AHI';

    /**
     * Registered activity
     */
    case UNTDID_4451_AHJ = 'AHJ';

    /**
     * Criminal sentence
     */
    case UNTDID_4451_AHK = 'AHK';

    /**
     * Sales method
     */
    case UNTDID_4451_AHL = 'AHL';

    /**
     * Educational institution information
     */
    case UNTDID_4451_AHM = 'AHM';

    /**
     * Status details
     */
    case UNTDID_4451_AHN = 'AHN';

    /**
     * Sales
     */
    case UNTDID_4451_AHO = 'AHO';

    /**
     * Spouse information
     */
    case UNTDID_4451_AHP = 'AHP';

    /**
     * Educational degree information
     */
    case UNTDID_4451_AHQ = 'AHQ';

    /**
     * Shareholding information
     */
    case UNTDID_4451_AHR = 'AHR';

    /**
     * Sales territory
     */
    case UNTDID_4451_AHS = 'AHS';

    /**
     * Accountant's comments
     */
    case UNTDID_4451_AHT = 'AHT';

    /**
     * Exemption law location
     */
    case UNTDID_4451_AHU = 'AHU';

    /**
     * Share classifications
     */
    case UNTDID_4451_AHV = 'AHV';

    /**
     * Forecast
     */
    case UNTDID_4451_AHW = 'AHW';

    /**
     * Event location
     */
    case UNTDID_4451_AHX = 'AHX';

    /**
     * Facility occupancy
     */
    case UNTDID_4451_AHY = 'AHY';

    /**
     * Import and export details
     */
    case UNTDID_4451_AHZ = 'AHZ';

    /**
     * Additional facility information
     */
    case UNTDID_4451_AIA = 'AIA';

    /**
     * Inventory value
     */
    case UNTDID_4451_AIB = 'AIB';

    /**
     * Education
     */
    case UNTDID_4451_AIC = 'AIC';

    /**
     * Event
     */
    case UNTDID_4451_AID = 'AID';

    /**
     * Agent
     */
    case UNTDID_4451_AIE = 'AIE';

    /**
     * Domestically agreed financial statement details
     */
    case UNTDID_4451_AIF = 'AIF';

    /**
     * Other current asset description
     */
    case UNTDID_4451_AIG = 'AIG';

    /**
     * Other current liability description
     */
    case UNTDID_4451_AIH = 'AIH';

    /**
     * Former business activity
     */
    case UNTDID_4451_AII = 'AII';

    /**
     * Trade name use
     */
    case UNTDID_4451_AIJ = 'AIJ';

    /**
     * Signing authority
     */
    case UNTDID_4451_AIK = 'AIK';

    /**
     * Guarantee
     */
    case UNTDID_4451_AIL = 'AIL';

    /**
     * Holding company operation
     */
    case UNTDID_4451_AIM = 'AIM';

    /**
     * Consignment routing
     */
    case UNTDID_4451_AIN = 'AIN';

    /**
     * Letter of protest
     */
    case UNTDID_4451_AIO = 'AIO';

    /**
     * Question
     */
    case UNTDID_4451_AIP = 'AIP';

    /**
     * Party information
     */
    case UNTDID_4451_AIQ = 'AIQ';

    /**
     * Area boundaries description
     */
    case UNTDID_4451_AIR = 'AIR';

    /**
     * Advertisement information
     */
    case UNTDID_4451_AIS = 'AIS';

    /**
     * Financial statement details
     */
    case UNTDID_4451_AIT = 'AIT';

    /**
     * Access instructions
     */
    case UNTDID_4451_AIU = 'AIU';

    /**
     * Liquidity
     */
    case UNTDID_4451_AIV = 'AIV';

    /**
     * Credit line
     */
    case UNTDID_4451_AIW = 'AIW';

    /**
     * Warranty terms
     */
    case UNTDID_4451_AIX = 'AIX';

    /**
     * Division description
     */
    case UNTDID_4451_AIY = 'AIY';

    /**
     * Reporting instruction
     */
    case UNTDID_4451_AIZ = 'AIZ';

    /**
     * Examination result
     */
    case UNTDID_4451_AJA = 'AJA';

    /**
     * Laboratory result
     */
    case UNTDID_4451_AJB = 'AJB';

    /**
     * Allowance/charge information
     */
    case UNTDID_4451_ALC = 'ALC';

    /**
     * X-ray result
     */
    case UNTDID_4451_ALD = 'ALD';

    /**
     * Pathology result
     */
    case UNTDID_4451_ALE = 'ALE';

    /**
     * Intervention description
     */
    case UNTDID_4451_ALF = 'ALF';

    /**
     * Summary of admittance
     */
    case UNTDID_4451_ALG = 'ALG';

    /**
     * Medical treatment course detail
     */
    case UNTDID_4451_ALH = 'ALH';

    /**
     * Prognosis
     */
    case UNTDID_4451_ALI = 'ALI';

    /**
     * Instruction to patient
     */
    case UNTDID_4451_ALJ = 'ALJ';

    /**
     * Instruction to physician
     */
    case UNTDID_4451_ALK = 'ALK';

    /**
     * All documents
     */
    case UNTDID_4451_ALL = 'ALL';

    /**
     * Medicine treatment
     */
    case UNTDID_4451_ALM = 'ALM';

    /**
     * Medicine dosage and administration
     */
    case UNTDID_4451_ALN = 'ALN';

    /**
     * Availability of patient
     */
    case UNTDID_4451_ALO = 'ALO';

    /**
     * Reason for service request
     */
    case UNTDID_4451_ALP = 'ALP';

    /**
     * Purpose of service
     */
    case UNTDID_4451_ALQ = 'ALQ';

    /**
     * Arrival conditions
     */
    case UNTDID_4451_ARR = 'ARR';

    /**
     * Service requester's comment
     */
    case UNTDID_4451_ARS = 'ARS';

    /**
     * Authentication
     */
    case UNTDID_4451_AUT = 'AUT';

    /**
     * Requested location description
     */
    case UNTDID_4451_AUU = 'AUU';

    /**
     * Medicine administration condition
     */
    case UNTDID_4451_AUV = 'AUV';

    /**
     * Patient information
     */
    case UNTDID_4451_AUW = 'AUW';

    /**
     * Precautionary measure
     */
    case UNTDID_4451_AUX = 'AUX';

    /**
     * Service characteristic
     */
    case UNTDID_4451_AUY = 'AUY';

    /**
     * Planned event comment
     */
    case UNTDID_4451_AUZ = 'AUZ';

    /**
     * Expected delay comment
     */
    case UNTDID_4451_AVA = 'AVA';

    /**
     * Transport requirements comment
     */
    case UNTDID_4451_AVB = 'AVB';

    /**
     * Temporary approval condition
     */
    case UNTDID_4451_AVC = 'AVC';

    /**
     * Customs Valuation Information
     */
    case UNTDID_4451_AVD = 'AVD';

    /**
     * Value Added Tax (VAT) margin scheme
     */
    case UNTDID_4451_AVE = 'AVE';

    /**
     * Maritime Declaration of Health
     */
    case UNTDID_4451_AVF = 'AVF';

    /**
     * Passenger baggage information
     */
    case UNTDID_4451_BAG = 'BAG';

    /**
     * Maritime Declaration of Health
     */
    case UNTDID_4451_BAH = 'BAH';

    /**
     * Additional product information address
     */
    case UNTDID_4451_BAI = 'BAI';

    /**
     * Information to be printed on despatch advice
     */
    case UNTDID_4451_BAJ = 'BAJ';

    /**
     * Missing goods remarks
     */
    case UNTDID_4451_BAK = 'BAK';

    /**
     * Non-acceptance information
     */
    case UNTDID_4451_BAL = 'BAL';

    /**
     * Returns information
     */
    case UNTDID_4451_BAM = 'BAM';

    /**
     * Sub-line item information
     */
    case UNTDID_4451_BAN = 'BAN';

    /**
     * Test information
     */
    case UNTDID_4451_BAO = 'BAO';

    /**
     * External link
     */
    case UNTDID_4451_BAP = 'BAP';

    /**
     * VAT exemption reason
     */
    case UNTDID_4451_BAQ = 'BAQ';

    /**
     * Processing Instructions
     */
    case UNTDID_4451_BAR = 'BAR';

    /**
     * Relay Instructions
     */
    case UNTDID_4451_BAS = 'BAS';

    /**
     * Transport contract document clause
     */
    case UNTDID_4451_BLC = 'BLC';

    /**
     * Instruction to prepare the patient
     */
    case UNTDID_4451_BLD = 'BLD';

    /**
     * Medicine treatment comment
     */
    case UNTDID_4451_BLE = 'BLE';

    /**
     * Examination result comment
     */
    case UNTDID_4451_BLF = 'BLF';

    /**
     * Service request comment
     */
    case UNTDID_4451_BLG = 'BLG';

    /**
     * Prescription reason
     */
    case UNTDID_4451_BLH = 'BLH';

    /**
     * Prescription comment
     */
    case UNTDID_4451_BLI = 'BLI';

    /**
     * Clinical investigation comment
     */
    case UNTDID_4451_BLJ = 'BLJ';

    /**
     * Medicinal specification comment
     */
    case UNTDID_4451_BLK = 'BLK';

    /**
     * Economic contribution comment
     */
    case UNTDID_4451_BLL = 'BLL';

    /**
     * Status of a plan
     */
    case UNTDID_4451_BLM = 'BLM';

    /**
     * Random sample test information
     */
    case UNTDID_4451_BLN = 'BLN';

    /**
     * Period of time
     */
    case UNTDID_4451_BLO = 'BLO';

    /**
     * Legislation
     */
    case UNTDID_4451_BLP = 'BLP';

    /**
     * Security measures requested
     */
    case UNTDID_4451_BLQ = 'BLQ';

    /**
     * Transport contract document remark
     */
    case UNTDID_4451_BLR = 'BLR';

    /**
     * Previous port of call security information
     */
    case UNTDID_4451_BLS = 'BLS';

    /**
     * Security information
     */
    case UNTDID_4451_BLT = 'BLT';

    /**
     * Waste information
     */
    case UNTDID_4451_BLU = 'BLU';

    /**
     * B2C marketing information, short description
     */
    case UNTDID_4451_BLV = 'BLV';

    /**
     * B2B marketing information, long description
     */
    case UNTDID_4451_BLW = 'BLW';

    /**
     * B2C marketing information, long description
     */
    case UNTDID_4451_BLX = 'BLX';

    /**
     * Product ingredients
     */
    case UNTDID_4451_BLY = 'BLY';

    /**
     * Location short name
     */
    case UNTDID_4451_BLZ = 'BLZ';

    /**
     * Packaging material information
     */
    case UNTDID_4451_BMA = 'BMA';

    /**
     * Filler material information
     */
    case UNTDID_4451_BMB = 'BMB';

    /**
     * Ship-to-ship activity information
     */
    case UNTDID_4451_BMC = 'BMC';

    /**
     * Package material description
     */
    case UNTDID_4451_BMD = 'BMD';

    /**
     * Consumer level package marking
     */
    case UNTDID_4451_BME = 'BME';

    /**
     * Customs clearance instructions
     */
    case UNTDID_4451_CCI = 'CCI';

    /**
     * Customs clearance instructions export
     */
    case UNTDID_4451_CEX = 'CEX';

    /**
     * Change information
     */
    case UNTDID_4451_CHG = 'CHG';

    /**
     * Customs clearance instruction import
     */
    case UNTDID_4451_CIP = 'CIP';

    /**
     * Clearance place requested
     */
    case UNTDID_4451_CLP = 'CLP';

    /**
     * Loading remarks
     */
    case UNTDID_4451_CLR = 'CLR';

    /**
     * Order information
     */
    case UNTDID_4451_COI = 'COI';

    /**
     * Customer remarks
     */
    case UNTDID_4451_CUR = 'CUR';

    /**
     * Customs declaration information
     */
    case UNTDID_4451_CUS = 'CUS';

    /**
     * Damage remarks
     */
    case UNTDID_4451_DAR = 'DAR';

    /**
     * Document issuer declaration
     */
    case UNTDID_4451_DCL = 'DCL';

    /**
     * Delivery information
     */
    case UNTDID_4451_DEL = 'DEL';

    /**
     * Delivery instructions
     */
    case UNTDID_4451_DIN = 'DIN';

    /**
     * Documentation instructions
     */
    case UNTDID_4451_DOC = 'DOC';

    /**
     * Duty declaration
     */
    case UNTDID_4451_DUT = 'DUT';

    /**
     * Effective used routing
     */
    case UNTDID_4451_EUR = 'EUR';

    /**
     * First block to be printed on the transport contract
     */
    case UNTDID_4451_FBC = 'FBC';

    /**
     * Government bill of lading information
     */
    case UNTDID_4451_GBL = 'GBL';

    /**
     * Entire transaction set
     */
    case UNTDID_4451_GEN = 'GEN';

    /**
     * Further information concerning GGVS par. 7
     */
    case UNTDID_4451_GS7 = 'GS7';

    /**
     * Consignment handling instruction
     */
    case UNTDID_4451_HAN = 'HAN';

    /**
     * Hazard information
     */
    case UNTDID_4451_HAZ = 'HAZ';

    /**
     * Consignment information for consignee
     */
    case UNTDID_4451_ICN = 'ICN';

    /**
     * Insurance instructions
     */
    case UNTDID_4451_IIN = 'IIN';

    /**
     * Invoice mailing instructions
     */
    case UNTDID_4451_IMI = 'IMI';

    /**
     * Commercial invoice item description
     */
    case UNTDID_4451_IND = 'IND';

    /**
     * Insurance information
     */
    case UNTDID_4451_INS = 'INS';

    /**
     * Invoice instruction
     */
    case UNTDID_4451_INV = 'INV';

    /**
     * Information for railway purpose
     */
    case UNTDID_4451_IRP = 'IRP';

    /**
     * Inland transport details
     */
    case UNTDID_4451_ITR = 'ITR';

    /**
     * Testing instructions
     */
    case UNTDID_4451_ITS = 'ITS';

    /**
     * Location Alias
     */
    case UNTDID_4451_LAN = 'LAN';

    /**
     * Line item
     */
    case UNTDID_4451_LIN = 'LIN';

    /**
     * Loading instruction
     */
    case UNTDID_4451_LOI = 'LOI';

    /**
     * Miscellaneous charge order
     */
    case UNTDID_4451_MCO = 'MCO';

    /**
     * Maritime Declaration of Health
     */
    case UNTDID_4451_MDH = 'MDH';

    /**
     * Additional marks/numbers information
     */
    case UNTDID_4451_MKS = 'MKS';

    /**
     * Order instruction
     */
    case UNTDID_4451_ORI = 'ORI';

    /**
     * Other service information
     */
    case UNTDID_4451_OSI = 'OSI';

    /**
     * Packing/marking information
     */
    case UNTDID_4451_PAC = 'PAC';

    /**
     * Payment instructions information
     */
    case UNTDID_4451_PAI = 'PAI';

    /**
     * Payables information
     */
    case UNTDID_4451_PAY = 'PAY';

    /**
     * Packaging information
     */
    case UNTDID_4451_PKG = 'PKG';

    /**
     * Packaging terms information
     */
    case UNTDID_4451_PKT = 'PKT';

    /**
     * Payment detail/remittance information
     */
    case UNTDID_4451_PMD = 'PMD';

    /**
     * Payment information
     */
    case UNTDID_4451_PMT = 'PMT';

    /**
     * Product information
     */
    case UNTDID_4451_PRD = 'PRD';

    /**
     * Price calculation formula
     */
    case UNTDID_4451_PRF = 'PRF';

    /**
     * Priority information
     */
    case UNTDID_4451_PRI = 'PRI';

    /**
     * Purchasing information
     */
    case UNTDID_4451_PUR = 'PUR';

    /**
     * Quarantine instructions
     */
    case UNTDID_4451_QIN = 'QIN';

    /**
     * Quality demands/requirements
     */
    case UNTDID_4451_QQD = 'QQD';

    /**
     * Quotation instruction/information
     */
    case UNTDID_4451_QUT = 'QUT';

    /**
     * Risk and handling information
     */
    case UNTDID_4451_RAH = 'RAH';

    /**
     * Regulatory information
     */
    case UNTDID_4451_REG = 'REG';

    /**
     * Return to origin information
     */
    case UNTDID_4451_RET = 'RET';

    /**
     * Receivables
     */
    case UNTDID_4451_REV = 'REV';

    /**
     * Consignment route
     */
    case UNTDID_4451_RQR = 'RQR';

    /**
     * Safety information
     */
    case UNTDID_4451_SAF = 'SAF';

    /**
     * Consignment documentary instruction
     */
    case UNTDID_4451_SIC = 'SIC';

    /**
     * Special instructions
     */
    case UNTDID_4451_SIN = 'SIN';

    /**
     * Ship line requested
     */
    case UNTDID_4451_SLR = 'SLR';

    /**
     * Special permission for transport, generally
     */
    case UNTDID_4451_SPA = 'SPA';

    /**
     * Special permission concerning the goods to be transported
     */
    case UNTDID_4451_SPG = 'SPG';

    /**
     * Special handling
     */
    case UNTDID_4451_SPH = 'SPH';

    /**
     * Special permission concerning package
     */
    case UNTDID_4451_SPP = 'SPP';

    /**
     * Special permission concerning transport means
     */
    case UNTDID_4451_SPT = 'SPT';

    /**
     * Subsidiary risk number (IATA/DGR)
     */
    case UNTDID_4451_SRN = 'SRN';

    /**
     * Special service request
     */
    case UNTDID_4451_SSR = 'SSR';

    /**
     * Supplier remarks
     */
    case UNTDID_4451_SUR = 'SUR';

    /**
     * Consignment tariff
     */
    case UNTDID_4451_TCA = 'TCA';

    /**
     * Consignment transport
     */
    case UNTDID_4451_TDT = 'TDT';

    /**
     * Transportation information
     */
    case UNTDID_4451_TRA = 'TRA';

    /**
     * Requested tariff
     */
    case UNTDID_4451_TRR = 'TRR';

    /**
     * Tax declaration
     */
    case UNTDID_4451_TXD = 'TXD';

    /**
     * Warehouse instruction/information
     */
    case UNTDID_4451_WHI = 'WHI';

    /**
     * Mutually defined
     */
    case UNTDID_4451_ZZZ = 'ZZZ';
}
