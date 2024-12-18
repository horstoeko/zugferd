<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the Charge codes
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdChargeCodes: string
{

    /**
     * Advertising
     */
    case ADVERTISING = "AA";

    /**
     * Telecommunication
     */
    case TELECOMMUNICATION = "AAA";

    /**
     * Technical modification
     */
    case TECHNICAL_MODIFICATION = "AAC";

    /**
     * Job-order production
     */
    case JOBORDER_PRODUCTION = "AAD";

    /**
     * Outlays
     */
    case OUTLAYS = "AAE";

    /**
     * Off-premises
     */
    case OFFPREMISES = "AAF";

    /**
     * Additional processing
     */
    case ADDITIONAL_PROCESSING = "AAH";

    /**
     * Attesting
     */
    case ATTESTING = "AAI";

    /**
     * Acceptance
     */
    case ACCEPTANCE = "AAS";

    /**
     * Rush delivery
     */
    case RUSH_DELIVERY = "AAT";

    /**
     * Special construction
     */
    case SPECIAL_CONSTRUCTION = "AAV";

    /**
     * Airport facilities
     */
    case AIRPORT_FACILITIES = "AAY";

    /**
     * Concession
     */
    case CONCESSION = "AAZ";

    /**
     * Compulsory storage
     */
    case COMPULSORY_STORAGE = "ABA";

    /**
     * Fuel removal
     */
    case FUEL_REMOVAL = "ABB";

    /**
     * Into plane
     */
    case INTO_PLANE = "ABC";

    /**
     * Overtime
     */
    case OVERTIME = "ABD";

    /**
     * Tooling
     */
    case TOOLING = "ABF";

    /**
     * Miscellaneous
     */
    case MISCELLANEOUS = "ABK";

    /**
     * Additional packaging
     */
    case ADDITIONAL_PACKAGING = "ABL";

    /**
     * Dunnage
     */
    case DUNNAGE = "ABN";

    /**
     * Containerisation
     */
    case CONTAINERISATION = "ABR";

    /**
     * Carton packing
     */
    case CARTON_PACKING = "ABS";

    /**
     * Hessian wrapped
     */
    case HESSIAN_WRAPPED = "ABT";

    /**
     * Polyethylene wrap packing
     */
    case POLYETHYLENE_WRAP_PACKING = "ABU";

    /**
     * Miscellaneous treatment
     */
    case MISCELLANEOUS_TREATMENT = "ACF";

    /**
     * Enamelling treatment
     */
    case ENAMELLING_TREATMENT = "ACG";

    /**
     * Heat treatment
     */
    case HEAT_TREATMENT = "ACH";

    /**
     * Plating treatment
     */
    case PLATING_TREATMENT = "ACI";

    /**
     * Painting
     */
    case PAINTING = "ACJ";

    /**
     * Polishing
     */
    case POLISHING = "ACK";

    /**
     * Priming
     */
    case PRIMING = "ACL";

    /**
     * Preservation treatment
     */
    case PRESERVATION_TREATMENT = "ACM";

    /**
     * Fitting
     */
    case FITTING = "ACS";

    /**
     * Consolidation
     */
    case CONSOLIDATION = "ADC";

    /**
     * Bill of lading
     */
    case BILL_OF_LADING = "ADE";

    /**
     * Airbag
     */
    case AIRBAG = "ADJ";

    /**
     * Transfer
     */
    case TRANSFER = "ADK";

    /**
     * Slipsheet
     */
    case SLIPSHEET = "ADL";

    /**
     * Binding
     */
    case BINDING = "ADM";

    /**
     * Repair or replacement of broken returnable package
     */
    case REPAIR_OR_REPLACEMENT_OF_BROKEN_RETURNABLE_PACKAGE = "ADN";

    /**
     * Efficient logistics
     */
    case EFFICIENT_LOGISTICS = "ADO";

    /**
     * Merchandising
     */
    case MERCHANDISING = "ADP";

    /**
     * Product mix
     */
    case PRODUCT_MIX = "ADQ";

    /**
     * Other services
     */
    case OTHER_SERVICES = "ADR";

    /**
     * Pick-up
     */
    case PICKUP = "ADT";

    /**
     * Chronic illness
     */
    case CHRONIC_ILLNESS = "ADW";

    /**
     * New product introduction
     */
    case NEW_PRODUCT_INTRODUCTION = "ADY";

    /**
     * Direct delivery
     */
    case DIRECT_DELIVERY = "ADZ";

    /**
     * Diversion
     */
    case DIVERSION = "AEA";

    /**
     * Disconnect
     */
    case DISCONNECT = "AEB";

    /**
     * Distribution
     */
    case DISTRIBUTION = "AEC";

    /**
     * Handling of hazardous cargo
     */
    case HANDLING_OF_HAZARDOUS_CARGO = "AED";

    /**
     * Rents and leases
     */
    case RENTS_AND_LEASES = "AEF";

    /**
     * Location differential
     */
    case LOCATION_DIFFERENTIAL = "AEH";

    /**
     * Aircraft refueling
     */
    case AIRCRAFT_REFUELING = "AEI";

    /**
     * Fuel shipped into storage
     */
    case FUEL_SHIPPED_INTO_STORAGE = "AEJ";

    /**
     * Cash on delivery
     */
    case CASH_ON_DELIVERY = "AEK";

    /**
     * Small order processing service
     */
    case SMALL_ORDER_PROCESSING_SERVICE = "AEL";

    /**
     * Clerical or administrative services
     */
    case CLERICAL_OR_ADMINISTRATIVE_SERVICES = "AEM";

    /**
     * Guarantee
     */
    case GUARANTEE = "AEN";

    /**
     * Collection and recycling
     */
    case COLLECTION_AND_RECYCLING = "AEO";

    /**
     * Copyright fee collection
     */
    case COPYRIGHT_FEE_COLLECTION = "AEP";

    /**
     * Veterinary inspection service
     */
    case VETERINARY_INSPECTION_SERVICE = "AES";

    /**
     * Pensioner service
     */
    case PENSIONER_SERVICE = "AET";

    /**
     * Medicine free pass holder
     */
    case MEDICINE_FREE_PASS_HOLDER = "AEU";

    /**
     * Environmental protection service
     */
    case ENVIRONMENTAL_PROTECTION_SERVICE = "AEV";

    /**
     * Environmental clean-up service
     */
    case ENVIRONMENTAL_CLEANUP_SERVICE = "AEW";

    /**
     * National cheque processing service outside account area
     */
    case NATIONAL_CHEQUE_PROCESSING_SERVICE_OUTSIDE_ACCOUNT_AREA = "AEX";

    /**
     * National payment service outside account area
     */
    case NATIONAL_PAYMENT_SERVICE_OUTSIDE_ACCOUNT_AREA = "AEY";

    /**
     * National payment service within account area
     */
    case NATIONAL_PAYMENT_SERVICE_WITHIN_ACCOUNT_AREA = "AEZ";

    /**
     * Adjustments
     */
    case ADJUSTMENTS = "AJ";

    /**
     * Authentication
     */
    case AUTHENTICATION = "AU";

    /**
     * Cataloguing
     */
    case CATALOGUING = "CA";

    /**
     * Cartage
     */
    case CARTAGE = "CAB";

    /**
     * Certification
     */
    case CERTIFICATION = "CAD";

    /**
     * Certificate of conformance
     */
    case CERTIFICATE_OF_CONFORMANCE = "CAE";

    /**
     * Certificate of origin
     */
    case CERTIFICATE_OF_ORIGIN = "CAF";

    /**
     * Cutting
     */
    case CUTTING = "CAI";

    /**
     * Consular service
     */
    case CONSULAR_SERVICE = "CAJ";

    /**
     * Customer collection
     */
    case CUSTOMER_COLLECTION = "CAK";

    /**
     * Payroll payment service
     */
    case PAYROLL_PAYMENT_SERVICE = "CAL";

    /**
     * Cash transportation
     */
    case CASH_TRANSPORTATION = "CAM";

    /**
     * Home banking service
     */
    case HOME_BANKING_SERVICE = "CAN";

    /**
     * Bilateral agreement service
     */
    case BILATERAL_AGREEMENT_SERVICE = "CAO";

    /**
     * Insurance brokerage service
     */
    case INSURANCE_BROKERAGE_SERVICE = "CAP";

    /**
     * Cheque generation
     */
    case CHEQUE_GENERATION = "CAQ";

    /**
     * Preferential merchandising location
     */
    case PREFERENTIAL_MERCHANDISING_LOCATION = "CAR";

    /**
     * Crane
     */
    case CRANE = "CAS";

    /**
     * Special colour service
     */
    case SPECIAL_COLOUR_SERVICE = "CAT";

    /**
     * Sorting
     */
    case SORTING = "CAU";

    /**
     * Battery collection and recycling
     */
    case BATTERY_COLLECTION_AND_RECYCLING = "CAV";

    /**
     * Product take back fee
     */
    case PRODUCT_TAKE_BACK_FEE = "CAW";

    /**
     * Quality control released
     */
    case QUALITY_CONTROL_RELEASED = "CAX";

    /**
     * Quality control held
     */
    case QUALITY_CONTROL_HELD = "CAY";

    /**
     * Quality control embargo
     */
    case QUALITY_CONTROL_EMBARGO = "CAZ";

    /**
     * Car loading
     */
    case CAR_LOADING = "CD";

    /**
     * Cleaning
     */
    case CLEANING = "CG";

    /**
     * Cigarette stamping
     */
    case CIGARETTE_STAMPING = "CS";

    /**
     * Count and recount
     */
    case COUNT_AND_RECOUNT = "CT";

    /**
     * Layout/design
     */
    case LAYOUT_DESIGN = "DAB";

    /**
     * Assortment allowance
     */
    case ASSORTMENT_ALLOWANCE = "DAC";

    /**
     * Driver assigned unloading
     */
    case DRIVER_ASSIGNED_UNLOADING = "DAD";

    /**
     * Debtor bound
     */
    case DEBTOR_BOUND = "DAF";

    /**
     * Dealer allowance
     */
    case DEALER_ALLOWANCE = "DAG";

    /**
     * Allowance transferable to the consumer
     */
    case ALLOWANCE_TRANSFERABLE_TO_THE_CONSUMER = "DAH";

    /**
     * Growth of business
     */
    case GROWTH_OF_BUSINESS = "DAI";

    /**
     * Introduction allowance
     */
    case INTRODUCTION_ALLOWANCE = "DAJ";

    /**
     * Multi-buy promotion
     */
    case MULTIBUY_PROMOTION = "DAK";

    /**
     * Partnership
     */
    case PARTNERSHIP = "DAL";

    /**
     * Return handling
     */
    case RETURN_HANDLING = "DAM";

    /**
     * Minimum order not fulfilled charge
     */
    case MINIMUM_ORDER_NOT_FULFILLED_CHARGE = "DAN";

    /**
     * Point of sales threshold allowance
     */
    case POINT_OF_SALES_THRESHOLD_ALLOWANCE = "DAO";

    /**
     * Wholesaling discount
     */
    case WHOLESALING_DISCOUNT = "DAP";

    /**
     * Documentary credits transfer commission
     */
    case DOCUMENTARY_CREDITS_TRANSFER_COMMISSION = "DAQ";

    /**
     * Delivery
     */
    case DELIVERY = "DL";

    /**
     * Engraving
     */
    case ENGRAVING = "EG";

    /**
     * Expediting
     */
    case EXPEDITING = "EP";

    /**
     * Exchange rate guarantee
     */
    case EXCHANGE_RATE_GUARANTEE = "ER";

    /**
     * Fabrication
     */
    case FABRICATION = "FAA";

    /**
     * Freight equalization
     */
    case FREIGHT_EQUALIZATION = "FAB";

    /**
     * Freight extraordinary handling
     */
    case FREIGHT_EXTRAORDINARY_HANDLING = "FAC";

    /**
     * Freight service
     */
    case FREIGHT_SERVICE = "FC";

    /**
     * Filling/handling
     */
    case FILLING_HANDLING = "FH";

    /**
     * Financing
     */
    case FINANCING = "FI";

    /**
     * Grinding
     */
    case GRINDING = "GAA";

    /**
     * Hose
     */
    case HOSE = "HAA";

    /**
     * Handling
     */
    case HANDLING = "HD";

    /**
     * Hoisting and hauling
     */
    case HOISTING_AND_HAULING = "HH";

    /**
     * Installation
     */
    case INSTALLATION = "IAA";

    /**
     * Installation and warranty
     */
    case INSTALLATION_AND_WARRANTY = "IAB";

    /**
     * Inside delivery
     */
    case INSIDE_DELIVERY = "ID";

    /**
     * Inspection
     */
    case INSPECTION = "IF";

    /**
     * Installation and training
     */
    case INSTALLATION_AND_TRAINING = "IR";

    /**
     * Invoicing
     */
    case INVOICING = "IS";

    /**
     * Koshering
     */
    case KOSHERING = "KO";

    /**
     * Carrier count
     */
    case CARRIER_COUNT = "L1";

    /**
     * Labelling
     */
    case LABELLING = "LA";

    /**
     * Labour
     */
    case LABOUR = "LAA";

    /**
     * Repair and return
     */
    case REPAIR_AND_RETURN = "LAB";

    /**
     * Legalisation
     */
    case LEGALISATION = "LF";

    /**
     * Mounting
     */
    case MOUNTING = "MAE";

    /**
     * Mail invoice
     */
    case MAIL_INVOICE = "MI";

    /**
     * Mail invoice to each location
     */
    case MAIL_INVOICE_TO_EACH_LOCATION = "ML";

    /**
     * Non-returnable containers
     */
    case NONRETURNABLE_CONTAINERS = "NAA";

    /**
     * Outside cable connectors
     */
    case OUTSIDE_CABLE_CONNECTORS = "OA";

    /**
     * Invoice with shipment
     */
    case INVOICE_WITH_SHIPMENT = "PA";

    /**
     * Phosphatizing (steel treatment)
     */
    case PHOSPHATIZING_STEEL_TREATMENT = "PAA";

    /**
     * Packing
     */
    case PACKING = "PC";

    /**
     * Palletizing
     */
    case PALLETIZING = "PL";

    /**
     * Repacking
     */
    case REPACKING = "RAB";

    /**
     * Repair
     */
    case REPAIR = "RAC";

    /**
     * Returnable container
     */
    case RETURNABLE_CONTAINER = "RAD";

    /**
     * Restocking
     */
    case RESTOCKING = "RAF";

    /**
     * Re-delivery
     */
    case REDELIVERY = "RE";

    /**
     * Refurbishing
     */
    case REFURBISHING = "RF";

    /**
     * Rail wagon hire
     */
    case RAIL_WAGON_HIRE = "RH";

    /**
     * Loading
     */
    case LOADING = "RV";

    /**
     * Salvaging
     */
    case SALVAGING = "SA";

    /**
     * Shipping and handling
     */
    case SHIPPING_AND_HANDLING = "SAA";

    /**
     * Special packaging
     */
    case SPECIAL_PACKAGING = "SAD";

    /**
     * Stamping
     */
    case STAMPING = "SAE";

    /**
     * Consignee unload
     */
    case CONSIGNEE_UNLOAD = "SAI";

    /**
     * Shrink-wrap
     */
    case SHRINKWRAP = "SG";

    /**
     * Special handling
     */
    case SPECIAL_HANDLING = "SH";

    /**
     * Special finish
     */
    case SPECIAL_FINISH = "SM";

    /**
     * Set-up
     */
    case SETUP = "SU";

    /**
     * Tank renting
     */
    case TANK_RENTING = "TAB";

    /**
     * Testing
     */
    case TESTING = "TAC";

    /**
     * Transportation - third party billing
     */
    case TRANSPORTATION__THIRD_PARTY_BILLING = "TT";

    /**
     * Transportation by vendor
     */
    case TRANSPORTATION_BY_VENDOR = "TV";

    /**
     * Drop yard
     */
    case DROP_YARD = "V1";

    /**
     * Drop dock
     */
    case DROP_DOCK = "V2";

    /**
     * Warehousing
     */
    case WAREHOUSING = "WH";

    /**
     * Combine all same day shipment
     */
    case COMBINE_ALL_SAME_DAY_SHIPMENT = "XAA";

    /**
     * Split pick-up
     */
    case SPLIT_PICKUP = "YY";

    /**
     * Mutually defined
     */
    case MUTUALLY_DEFINED = "ZZZ";
}
