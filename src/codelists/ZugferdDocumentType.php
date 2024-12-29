<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing list of document name codes
 * Name of list: UNTDID 1001 Document name code
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 * @see      https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.1001
 */
class ZugferdDocumentType
{
    /**
     * A claim for parts and/or labour charges (290)
     *
     * A claim for parts and/or labour charges incurred .
     */
    public const A_CLAIM_FOR_PARTS_ANDOR_LABOUR_CHARGES = '290';

    /**
     * Accounting statement (832)
     *
     * Document specifying an accounting statement.
     */
    public const ACCOUNTING_STATEMENT = '832';

    /**
     * Accounting voucher (526)
     *
     * A document/message justifying an accounting entry.
     */
    public const ACCOUNTING_VOUCHER = '526';

    /**
     * Acknowledgement message (312)
     *
     * Message providing acknowledgement information at the business application
     * level concerning the processing of a message.
     */
    public const ACKNOWLEDGEMENT_MESSAGE = '312';

    /**
     * Acknowledgement of change of supplier (414)
     *
     * Acknowledgement of the change of supplier.
     */
    public const ACKNOWLEDGEMENT_OF_CHANGE_OF_SUPPLIER = '414';

    /**
     * Acknowledgement of order (320)
     *
     * Document/message acknowledging an undertaking to fulfil an order and
     * confirming conditions or acceptance of conditions.
     */
    public const ACKNOWLEDGEMENT_OF_ORDER = '320';

    /**
     * Acknowledgment of receipt (767)
     *
     * Document/message confirming a receipt to the sending party.
     */
    public const ACKNOWLEDGMENT_OF_RECEIPT = '767';

    /**
     * Advice of an amendment of a documentary credit (198)
     *
     * Advice of an amendment of a documentary credit.
     */
    public const ADVICE_OF_AN_AMENDMENT_OF_A_DOCUMENTARY_CREDIT = '198';

    /**
     * Advice of collection (790)
     *
     * (1030) Document that is joined to the transport or sent by separate means,
     * giving to the departure rail organization the proof that the cash-on
     * delivery amount has been encashed by the arrival rail organization before
     * reimbursement of the consignor.
     */
    public const ADVICE_OF_COLLECTION = '790';

    /**
     * Advice of distribution of documents (370)
     *
     * Document/message in which the party responsible for the issue of a set of
     * trade documents specifies the various recipients of originals and copies of
     * these documents, with an indication of the number of copies distributed to
     * each of them.
     */
    public const ADVICE_OF_DISTRIBUTION_OF_DOCUMENTS = '370';

    /**
     * Advice report (769)
     *
     * Document reporting advice.
     */
    public const ADVICE_REPORT = '769';

    /**
     * Advising items to be booked to a financial account (141)
     *
     * A document and/or message advising of items which have to be booked to a
     * financial account.
     */
    public const ADVISING_ITEMS_TO_BE_BOOKED_TO_A_FINANCIAL_ACCOUNT = '141';

    /**
     * AEO Certificate Full (891)
     *
     * Certificate issued to business that fulfils specified criteria to both AEO
     * Certificate of Security and/or Safety and AEO Certificate of Conformity or
     * Compliance by a national AEO recognized program (e.g. AEO-Customs
     * Simplifications/Security and Safety (AEOC/AEOS) - Regulation(EU) No
     * 952/2013).
     */
    public const AEO_CERTIFICATE_FULL = '891';

    /**
     * AEO Certificate of Conformity or Compliance (879)
     *
     * Certificate issued to business that fulfils specified criteria for
     * compliance with tax and customs obligations, as well as financial solvency
     * by a national AEO recognized program (e.g. AEO-Customs Simplifications
     * (AEOC) - Regulation (EU) No 952/2013).
     */
    public const AEO_CERTIFICATE_OF_CONFORMITY_OR_COMPLIANCE = '879';

    /**
     * AEO Certificate of Security and/or Safety (878)
     *
     * Certificate issued to business that fulfils specified criteria applied to
     * the security and safety of the logistics chain in the flow of foreign trade
     * operations by a national AEO recognized program (e.g. AEO-Security and
     * Safety (AEOS) - Regulation (EU) No 952/2013).
     */
    public const AEO_CERTIFICATE_OF_SECURITY_ANDOR_SAFETY = '878';

    /**
     * Agreement to pay (212)
     *
     * Document/message in which the debtor expresses the intention to pay.
     */
    public const AGREEMENT_TO_PAY = '212';

    /**
     * Air waybill (740)
     *
     * Document/message made out by or on behalf of the shipper which evidences
     * the contract between the shipper and carrier(s) for carriage of goods over
     * routes of the carrier(s) and which is identified by the airline prefix
     * issuing the document plus a serial (IATA).
     */
    public const AIR_WAYBILL = '740';

    /**
     * Amicable agreement (846)
     *
     * Document specifying an amicable agreement.
     */
    public const AMICABLE_AGREEMENT = '846';

    /**
     * Announcement for returns (732)
     *
     * A message by which a party announces to another party details of goods for
     * return due to specified reasons (e.g. returns for repair, returns because
     * of damage, etc).
     */
    public const ANNOUNCEMENT_FOR_RETURNS = '732';

    /**
     * Application acknowledgement and error report (294)
     *
     * A message used by an application to acknowledge reception of a message
     * and/or to report any errors.
     */
    public const APPLICATION_ACKNOWLEDGEMENT_AND_ERROR_REPORT = '294';

    /**
     * Application error and acknowledgement (305)
     *
     * A message to inform a message issuer that a previously sent message has
     * been received by the addressee's application, or that a previously sent
     * message has been rejected by the addressee's application.
     */
    public const APPLICATION_ERROR_AND_ACKNOWLEDGEMENT = '305';

    /**
     * Application error message (313)
     *
     * Message indicating that a message was rejected due to errors encountered at
     * the application level.
     */
    public const APPLICATION_ERROR_MESSAGE = '313';

    /**
     * Application for banker's draft (412)
     *
     * Application by a customer to his bank to issue a banker's draft stating the
     * amount and currency of the draft, the name of the payee and the place and
     * country of payment.
     */
    public const APPLICATION_FOR_BANKERS_DRAFT = '412';

    /**
     * Application for banker's guarantee (429)
     *
     * Document/message whereby a customer requests his bank to issue a guarantee
     * in favour of a nominated party in another country, stating the amount and
     * currency and the specific conditions of the guarantee.
     */
    public const APPLICATION_FOR_BANKERS_GUARANTEE = '429';

    /**
     * Application for designation of berthing places (317)
     *
     * Document to apply for designation of berthing places.
     */
    public const APPLICATION_FOR_DESIGNATION_OF_BERTHING_PLACES = '317';

    /**
     * Application for documentary credit (996)
     *
     * Message with application for opening of a documentary credit.
     */
    public const APPLICATION_FOR_DOCUMENTARY_CREDIT = '996';

    /**
     * Application for exchange allocation (925)
     *
     * Document/message whereby an importer/buyer requests the competent body to
     * allocate an amount of foreign exchange to be transferred to an
     * exporter/seller in payment for goods.
     */
    public const APPLICATION_FOR_EXCHANGE_ALLOCATION = '925';

    /**
     * Application for goods control certificate (840)
     *
     * Document/message submitted to a competent body by party requesting a Goods
     * control certificate to be issued in accordance with national or
     * international standards, or conforming to legislation in the importing
     * country, or as specified in the contract.
     */
    public const APPLICATION_FOR_GOODS_CONTROL_CERTIFICATE = '840';

    /**
     * Application for inspection certificate (855)
     *
     * Document/message submitted to a competent body by a party requesting an
     * Inspection certificate to be issued in accordance with national or
     * international standards, or conforming to legislation in the country in
     * which it is required, or as specified in the contract.
     */
    public const APPLICATION_FOR_INSPECTION_CERTIFICATE = '855';

    /**
     * Application for phytosanitary certificate (850)
     *
     * Document/message submitted to a competent body by party requesting a
     * Phytosanitary certificate to be issued.
     */
    public const APPLICATION_FOR_PHYTOSANITARY_CERTIFICATE = '850';

    /**
     * Application for shifting from the designated place in port (318)
     *
     * Document to apply for shifting from the designated place in port.
     */
    public const APPLICATION_FOR_SHIFTING_FROM_THE_DESIGNATED_PLACE_IN_PORT = '318';

    /**
     * Application for usage of berth or mooring facilities (316)
     *
     * Document to apply for usage of berth or mooring facilities.
     */
    public const APPLICATION_FOR_USAGE_OF_BERTH_OR_MOORING_FACILITIES = '316';

    /**
     * Application for vessel's entering into port area in night-time (353)
     *
     * Document to apply for vessel's entering into port area in night-time.
     */
    public const APPLICATION_FOR_VESSELS_ENTERING_INTO_PORT_AREA_IN_NIGHTTIME = '353';

    /**
     * Approved unpriced bill of quantity (216)
     *
     * Document/message providing an approved detailed, quantity based
     * specification (bill of quantity), in an unpriced form.
     */
    public const APPROVED_UNPRICED_BILL_OF_QUANTITY = '216';

    /**
     * Arrival information (98)
     *
     * Message reporting the arrival details of goods or cargo.
     */
    public const ARRIVAL_INFORMATION = '98';

    /**
     * Arrival notice (goods) (781)
     *
     * Notification from the carrier to the consignee in writing, by telephone or
     * by any other means (express letter, message, telegram, etc.) informing him
     * that a consignment addressed to him is being or will shortly be held at his
     * disposal at a specified point in the place of destination.
     */
    public const ARRIVAL_NOTICE_GOODS = '781';

    /**
     * Assessment report (818)
     *
     * Document reporting an assessment.
     */
    public const ASSESSMENT_REPORT = '818';

    /**
     * ATA carnet (955)
     *
     * International Customs document (Admission Temporaire / Temporary Admission)
     * which, issued under the terms of the ATA Convention (1961), incorporates an
     * internationally valid guarantee and may be used, in lieu of national
     * Customs documents and as security for import duties and taxes, to cover the
     * temporary admission of goods and, where appropriate, the transit of goods.
     * If accepted for controlling the temporary export and reimport of goods,
     * international guarantee does not apply (CCC).
     */
    public const ATA_CARNET = '955';

    /**
     * Audio (859)
     *
     * Document consisting of an audio recording (e.g. a telephone conversation or
     * alike).
     */
    public const AUDIO = '859';

    /**
     * Authorisation to plan and ship orders (173)
     *
     * Document or message that authorises receiver to plan and ship orders based
     * on information in this message.
     */
    public const AUTHORISATION_TO_PLAN_AND_SHIP_ORDERS = '173';

    /**
     * Authorisation to plan and suggest orders (172)
     *
     * Document or message that authorises receiver to plan orders, based on
     * information in this message, and send these orders as suggestions to the
     * sender.
     */
    public const AUTHORISATION_TO_PLAN_AND_SUGGEST_ORDERS = '172';

    /**
     * Bailment contract (148)
     *
     * A document authorizing the bailing of goods.
     */
    public const BAILMENT_CONTRACT = '148';

    /**
     * Balance confirmation (182)
     *
     * Confirmation of a balance at an entry date.
     */
    public const BALANCE_CONFIRMATION = '182';

    /**
     * Bank to bank funds transfer (247)
     *
     * The message is a bank to bank funds transfer.
     */
    public const BANK_TO_BANK_FUNDS_TRANSFER = '247';

    /**
     * Banker's draft (485)
     *
     * Draft drawn in favour of a third party either by one bank on another bank,
     * or by a branch of a bank on its head office (or vice versa) or upon another
     * branch of the same bank. In either case, the draft should comply with the
     * specifications laid down for cheques in the country in which it is to be
     * payable.
     */
    public const BANKERS_DRAFT = '485';

    /**
     * Banker's guarantee (430)
     *
     * Document/message in which a bank undertakes to pay out a limited amount of
     * money to a designated party, on conditions stated therein (other than those
     * laid down in the Uniform Customs Practice).
     */
    public const BANKERS_GUARANTEE = '430';

    /**
     * Banking status (46)
     *
     * A banking status document and/or message.
     */
    public const BANKING_STATUS = '46';

    /**
     * Basic agreement (149)
     *
     * A document indicating an agreement containing basic terms and conditions
     * applicable to future contracts between two parties.
     */
    public const BASIC_AGREEMENT = '149';

    /**
     * Bayplan/stowage plan, full (658)
     *
     * A full bayplan containing all occupied and/or blocked stowage locations.
     */
    public const BAYPLANSTOWAGE_PLAN_FULL = '658';

    /**
     * Bayplan/stowage plan, partial (659)
     *
     * A partial bayplan. containing only a selected part of the available stowage
     * locations.
     */
    public const BAYPLANSTOWAGE_PLAN_PARTIAL = '659';

    /**
     * Bill of exchange (490)
     *
     * Document/message, issued and signed in conformity with the applicable
     * legislation, which contains an unconditional order whereby the drawer
     * directs the drawee to pay a definite sum of money to the payee or to his
     * order, on demand or at a definite time, against the surrender of the
     * document itself.
     */
    public const BILL_OF_EXCHANGE = '490';

    /**
     * Bill of lading (705)
     *
     * Negotiable document/message which evidences a contract of carriage by sea
     * and the taking over or loading of goods by carrier, and by which carrier
     * undertakes to deliver goods against surrender of the document. A provision
     * in the document that goods are to be delivered to the order of a named
     * person, or to order, or to bearer, constitutes such an undertaking.
     */
    public const BILL_OF_LADING = '705';

    /**
     * Bill of lading copy (707)
     *
     * A copy of the bill of lading issued by a transport company.
     */
    public const BILL_OF_LADING_COPY = '707';

    /**
     * Bill of lading original (706)
     *
     * The original of the bill of lading issued by a transport company. When
     * issued by the maritime industry it could signify ownership of the cargo.
     */
    public const BILL_OF_LADING_ORIGINAL = '706';

    /**
     * Binding customer agreement for contract (772)
     *
     * Document which is a binding agreement from the customer for a contract,
     * such as an insurance contract.
     */
    public const BINDING_CUSTOMER_AGREEMENT_FOR_CONTRACT = '772';

    /**
     * Binding offer (771)
     *
     * Document which is a binding offer from one party to another.
     */
    public const BINDING_OFFER = '771';

    /**
     * Blanket order (221)
     *
     * Usage of document/message for general order purposes with later split into
     * quantities and delivery dates and maybe delivery locations.
     */
    public const BLANKET_ORDER = '221';

    /**
     * Booking confirmation (770)
     *
     * Document/message issued by a carrier to confirm that space has been
     * reserved for a consignment in means of transport.
     */
    public const BOOKING_CONFIRMATION = '770';

    /**
     * Booking request (335)
     *
     * Document/message issued by a supplier to a carrier requesting space to be
     * reserved for a specified consignment, indicating desirable conveyance,
     * despatch time, etc.
     */
    public const BOOKING_REQUEST = '335';

    /**
     * Bordereau (787)
     *
     * Document/message used in road transport, listing the cargo carried on a
     * road vehicle, often referring to appended copies of Road consignment note.
     */
    public const BORDEREAU = '787';

    /**
     * Buy America certificate of compliance (168)
     *
     * A document certifying that more than 50 percent of the cost of an item is
     * attributed to US origin.
     */
    public const BUY_AMERICA_CERTIFICATE_OF_COMPLIANCE = '168';

    /**
     * Calculation note (844)
     *
     * Document detailing a calculation, such as an invoice calculation or a costs
     * calculation.
     */
    public const CALCULATION_NOTE = '844';

    /**
     * Call for tender (754)
     *
     * A document/message used by a buyer to define the procurement procedure and
     * request suppliers to participate.
     */
    public const CALL_FOR_TENDER = '754';

    /**
     * Call off order (226)
     *
     * Document/message to provide split quantities and delivery dates referring
     * to a previous blanket order.
     */
    public const CALL_OFF_ORDER = '226';

    /**
     * Call-off delivery (76)
     *
     * Document/message to provide split quantities and delivery dates referring
     * to a previous delivery instruction.
     */
    public const CALLOFF_DELIVERY = '76';

    /**
     * Calling forward notice (775)
     *
     * Instructions for release or delivery of goods.
     */
    public const CALLING_FORWARD_NOTICE = '775';

    /**
     * Campaign price/sales catalogue (234)
     *
     * A price/sales catalogue containing special prices which are valid only for
     * a specified period or under specified conditions.
     */
    public const CAMPAIGN_PRICESALES_CATALOGUE = '234';

    /**
     * Cargo acceptance order (170)
     *
     * Order to accept cargo to be delivered by a carrier.
     */
    public const CARGO_ACCEPTANCE_ORDER = '170';

    /**
     * Cargo analysis voyage report (260)
     *
     * An analysis of the cargo for a voyage.
     */
    public const CARGO_ANALYSIS_VOYAGE_REPORT = '260';

    /**
     * Cargo declaration (arrival) (933)
     *
     * Generic term, sometimes referred to as Freight declaration, applied to the
     * documents providing the particulars required by the Customs concerning the
     * cargo (freight) carried by commercial means of transport (CCC).
     */
    public const CARGO_DECLARATION_ARRIVAL = '933';

    /**
     * Cargo declaration (departure) (833)
     *
     * Generic term, sometimes referred to as Freight declaration, applied to the
     * documents providing the particulars required by the Customs concerning the
     * cargo (freight) carried by commercial means of transport (CCC).
     */
    public const CARGO_DECLARATION_DEPARTURE = '833';

    /**
     * Cargo manifest (785)
     *
     * Listing of goods comprising the cargo carried in a means of transport or in
     * a transport-unit. The cargo manifest gives the commercial particulars of
     * the goods, such as transport document numbers, consignors, consignees,
     * shipping marks, number and kind of packages and descriptions and quantities
     * of the goods.
     */
    public const CARGO_MANIFEST = '785';

    /**
     * Cargo movement event log (259)
     *
     * A document detailing times and dates of events pertaining to a cargo
     * movement.
     */
    public const CARGO_MOVEMENT_EVENT_LOG = '259';

    /**
     * Cargo movement voyage summary (314)
     *
     * A consolidated voyage summary which contains the information in a
     * certificate of analysis, a voyage analysis and a cargo movement time log
     * for a voyage.
     */
    public const CARGO_MOVEMENT_VOYAGE_SUMMARY = '314';

    /**
     * Cargo release notification (99)
     *
     * Message/document sent by the cargo handler indicating that the cargo has
     * moved from a Customs controlled premise.
     */
    public const CARGO_RELEASE_NOTIFICATION = '99';

    /**
     * Cargo status (34)
     *
     * Message identifying the status of cargo.
     */
    public const CARGO_STATUS = '34';

    /**
     * Cargo vessel discharge order (145)
     *
     * Order that the containers or cargo specified are to be discharged from a
     * vessel.
     */
    public const CARGO_VESSEL_DISCHARGE_ORDER = '145';

    /**
     * Cargo vessel loading order (146)
     *
     * Order that specified cargo, containers or groups of containers are to be
     * loaded in or on a vessel.
     */
    public const CARGO_VESSEL_LOADING_ORDER = '146';

    /**
     * Cargo/goods handling and movement message (738)
     *
     * A message from a party to a warehouse, distribution centre, or logistics
     * service provider identifying the handling services and where required the
     * movement of specified goods, limited to warehouses within the jurisdiction
     * of the distribution centre or log.
     */
    public const CARGOGOODS_HANDLING_AND_MOVEMENT_MESSAGE = '738';

    /**
     * Cartage order (local transport) (343)
     *
     * Document/message giving instructions regarding local transport of goods,
     * e.g. from the premises of an enterprise to those of a carrier undertaking
     * further transport.
     */
    public const CARTAGE_ORDER_LOCAL_TRANSPORT = '343';

    /**
     * Cash pool financial statement (306)
     *
     * A financial statement for a cash pool.
     */
    public const CASH_POOL_FINANCIAL_STATEMENT = '306';

    /**
     * Casing sanitary certificate (93)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that casing products comply with the requirements set by
     * the importing country.
     */
    public const CASING_SANITARY_CERTIFICATE = '93';

    /**
     * Certificate (16)
     *
     * Document by means of which the documentary credit applicant specifies the
     * conditions for the certificate and by whom the certificate is to be issued.
     */
    public const CERTIFICATE = '16';

    /**
     * Certificate of analysis (1)
     *
     * Certificate providing the values of an analysis.
     */
    public const CERTIFICATE_OF_ANALYSIS = '1';

    /**
     * Certificate of compliance with standards of the World Organization for
     * Animal Health (OIE) (648)
     *
     * A certification that the products have been treated in a way consistent
     * with the standards set by the World Organization for Animal Health (OIE).
     */
    public const CERTIFICATE_OF_COMPLIANCE_WITH_STANDARDS_OF_THE_WORLD_ORGANIZATION_FOR_ANIMAL_HEALTH_OIE = '648';

    /**
     * Certificate of conformity (2)
     *
     * Certificate certifying the conformity to predefined definitions.
     */
    public const CERTIFICATE_OF_CONFORMITY = '2';

    /**
     * Certificate of disembarkation permission (487)
     *
     * Document or message issuing permission to disembark.
     */
    public const CERTIFICATE_OF_DISEMBARKATION_PERMISSION = '487';

    /**
     * Certificate of food item transport readiness (642)
     *
     * A certificate to verify readiness of a transport or transport area such as
     * a reservoir or hold to transport food items.
     */
    public const CERTIFICATE_OF_FOOD_ITEM_TRANSPORT_READINESS = '642';

    /**
     * Certificate of origin (861)
     *
     * Document/message identifying goods, in which the authority or body
     * authorized to issue it certifies expressly that the goods to which the
     * certificate relates originate in a specific country. The word "country" may
     * include a group of countries, a region or a part of a country. This
     * certificate may also include a declaration by the manufacturer, producer,
     * supplier, exporter or other competent person.
     */
    public const CERTIFICATE_OF_ORIGIN = '861';

    /**
     * Certificate of origin form GSP (865)
     *
     * Specific form of certificate of origin for goods qualifying for
     * preferential treatment under the generalized system of preferences
     * (includes a combined declaration of origin and certificate, form A).
     */
    public const CERTIFICATE_OF_ORIGIN_FORM_GSP = '865';

    /**
     * Certificate of origin, application for (860)
     *
     * Document/message submitted to a competent body by an interested party
     * requesting a Certificate of origin to be issued in accordance with relevant
     * criteria, and on the basis of evidence of the origin of the goods.
     */
    public const CERTIFICATE_OF_ORIGIN_APPLICATION_FOR = '860';

    /**
     * Certificate of paid insurance premium (835)
     *
     * Document certifying the payment of the insurance premium.
     */
    public const CERTIFICATE_OF_PAID_INSURANCE_PREMIUM = '835';

    /**
     * Certificate of quality (3)
     *
     * Certificate certifying the quality of goods, services etc.
     */
    public const CERTIFICATE_OF_QUALITY = '3';

    /**
     * Certificate of quantity (19)
     *
     * Certificate certifying the quantity of goods, services etc.
     */
    public const CERTIFICATE_OF_QUANTITY = '19';

    /**
     * Certificate of refrigerated transport equipment inspection (639)
     *
     * Inspection document shows that the container, the cooling devices and
     * measured temperature is in good working condition.
     */
    public const CERTIFICATE_OF_REFRIGERATED_TRANSPORT_EQUIPMENT_INSPECTION = '639';

    /**
     * Certificate of registry (798)
     *
     * Official certificate stating the vessel's registry.
     */
    public const CERTIFICATE_OF_REGISTRY = '798';

    /**
     * Certificate of sealing of export meat lockers (33)
     *
     * Document / message issued by the authority in the exporting country
     * evidencing the sealing of export meat lockers.
     */
    public const CERTIFICATE_OF_SEALING_OF_EXPORT_MEAT_LOCKERS = '33';

    /**
     * Certificate of shipment (375)
     *
     * (1109) Certificate providing confirmation that a consignment has been
     * shipped.
     */
    public const CERTIFICATE_OF_SHIPMENT = '375';

    /**
     * Certificate of suitability for transport of grains and legumes (638)
     *
     * Certificate of inspection for the vessel stating its readiness and
     * suitability for transporting grains and legumes.
     */
    public const CERTIFICATE_OF_SUITABILITY_FOR_TRANSPORT_OF_GRAINS_AND_LEGUMES = '638';

    /**
     * Certificate of sustainability (753)
     *
     * Document/message issued by a competent body certifying sustainability.
     */
    public const CERTIFICATE_OF_SUSTAINABILITY = '753';

    /**
     * Certified cost and price data (159)
     *
     * A document indicating cost and price data whose accuracy has been
     * certified.
     */
    public const CERTIFIED_COST_AND_PRICE_DATA = '159';

    /**
     * Certified inspection and test results (162)
     *
     * A certification as to the accuracy of inspection and test results.
     */
    public const CERTIFIED_INSPECTION_AND_TEST_RESULTS = '162';

    /**
     * Certified list of ingredients (634)
     *
     * A document legalized from a competent authority that shows the components
     * of the product (food additive, detergent, disinfectant and sanitizer).
     */
    public const CERTIFIED_LIST_OF_INGREDIENTS = '634';

    /**
     * Chargeback (68)
     *
     * Document/message issued by a factor to a seller or to another factor to
     * indicate that the rest of the amounts of one or more invoices uncollectable
     * from buyers are charged back to clear the invoice(s) off the ledger.
     */
    public const CHARGEBACK = '68';

    /**
     * Charges note (789)
     *
     * Document used by the rail organization to indicate freight charges or
     * additional charges in each case where the departure station is not able to
     * calculate the charges for the total voyage (e.g. tariff not yet updated,
     * part of voyage not covered by the tariff). This document must be considered
     * as joined to the transport.
     */
    public const CHARGES_NOTE = '789';

    /**
     * Civil liability for oil certificate (794)
     *
     * Document declaring a ship owner's liability for oil propelling or carried
     * on a vessel.
     */
    public const CIVIL_LIABILITY_FOR_OIL_CERTIFICATE = '794';

    /**
     * Civil status document (768)
     *
     * Document which confirms the civil status of a person.
     */
    public const CIVIL_STATUS_DOCUMENT = '768';

    /**
     * Claim history certificate (831)
     *
     * Document which certifies the history of claims.
     */
    public const CLAIM_HISTORY_CERTIFICATE = '831';

    /**
     * Claim notification (817)
     *
     * Document notifying a claim.
     */
    public const CLAIM_NOTIFICATION = '817';

    /**
     * Close of claim (827)
     *
     * Document reporting the closing of a claim file.
     */
    public const CLOSE_OF_CLAIM = '827';

    /**
     * Closing statement of an account (56)
     *
     * Last statement of a period containing the interest calculation and the
     * final balance of the last entry date.
     */
    public const CLOSING_STATEMENT_OF_AN_ACCOUNT = '56';

    /**
     * Co-insurance ceding bordereau (329)
     *
     * The document or message contains a bordereau describing co-insurance ceding
     * information.
     */
    public const COINSURANCE_CEDING_BORDEREAU = '329';

    /**
     * Code change request (273)
     *
     * Request a change to an existing code.
     */
    public const CODE_CHANGE_REQUEST = '273';

    /**
     * Collateral account (70)
     *
     * Document message issued by a factor to indicate the movements of invoices,
     * credit notes and payments of a seller's account.
     */
    public const COLLATERAL_ACCOUNT = '70';

    /**
     * Collection order (447)
     *
     * Document/message whereby a bank is instructed (or requested) to handle
     * financial and/or commercial documents in order to obtain acceptance and/or
     * payment, or to deliver documents on such other terms and conditions as may
     * be specified.
     */
    public const COLLECTION_ORDER = '447';

    /**
     * Collection payment advice (425)
     *
     * Document/message whereby a bank advises that a collection has been paid,
     * giving details and methods of funds disposal.
     */
    public const COLLECTION_PAYMENT_ADVICE = '425';

    /**
     * Combined certificate of value and origin (17)
     *
     * Document identifying goods in which the issuing authority expressly
     * certifies that the goods originate in a specific country or part of, or
     * group of countries. It also states the price and/or cost of the goods with
     * the purpose of determining the customs origin.
     */
    public const COMBINED_CERTIFICATE_OF_VALUE_AND_ORIGIN = '17';

    /**
     * Combined transport bill of lading/multimodal bill of lading (766)
     *
     * Document which evidences a multimodal transport contract, the taking in
     * charge of the goods by the multimodal transport operator, and an
     * undertaking by him to deliver the goods in accordance with the terms of the
     * contract.
     */
    public const COMBINED_TRANSPORT_BILL_OF_LADINGMULTIMODAL_BILL_OF_LADING = '766';

    /**
     * Combined transport document (generic) (764)
     *
     * Negotiable or non-negotiable document evidencing a contract for the
     * performance and/or procurement of performance of combined transport of
     * goods and bearing on its face either the heading "Negotiable combined
     * transport document issued subject to Uniform Rules for a Combined Transport
     * Document (ICC Brochure No. 298)" or the heading "Non-negotiable Combined
     * Transport Document issued subject to Uniform Rules for a Combined Transport
     * Document (ICC Brochure No. 298)".
     */
    public const COMBINED_TRANSPORT_DOCUMENT_GENERIC = '764';

    /**
     * Commercial account summary (731)
     *
     * A message enabling the transmission of commercial data concerning payments
     * made and outstanding items on an account over a period of time.
     */
    public const COMMERCIAL_ACCOUNT_SUMMARY = '731';

    /**
     * Commercial account summary response (397)
     *
     * A document providing a response to a previously sent commercial account
     * summary message.
     */
    public const COMMERCIAL_ACCOUNT_SUMMARY_RESPONSE = '397';

    /**
     * Commercial dispute (67)
     *
     * Document/message issued by a party (usually the buyer) to indicate that one
     * or more invoices or one or more credit notes are disputed for payment.
     */
    public const COMMERCIAL_DISPUTE = '67';

    /**
     * Commercial invoice (380)
     *
     * (1334) Document/message claiming payment for goods or services supplied
     * under conditions agreed between seller and buyer.
     */
    public const COMMERCIAL_INVOICE = '380';

    /**
     * Commercial invoice which includes a packing list (331)
     *
     * Commercial transaction (invoice) will include a packing list.
     */
    public const COMMERCIAL_INVOICE_WHICH_INCLUDES_A_PACKING_LIST = '331';

    /**
     * Commission note (382)
     *
     * (1111) Document/message in which a seller specifies the amount of
     * commission, the percentage of the invoice amount, or some other basis for
     * the calculation of the commission to which a sales agent is entitled.
     */
    public const COMMISSION_NOTE = '382';

    /**
     * Communication from opposite party (845)
     *
     * Document containing a communication from the opposite party, such as in
     * legal action.
     */
    public const COMMUNICATION_FROM_OPPOSITE_PARTY = '845';

    /**
     * Composite data element change request (277)
     *
     * Request a change to an existing composite data element.
     */
    public const COMPOSITE_DATA_ELEMENT_CHANGE_REQUEST = '277';

    /**
     * Composite data element request (276)
     *
     * Requesting a new composite data element.
     */
    public const COMPOSITE_DATA_ELEMENT_REQUEST = '276';

    /**
     * Consignment despatch advice (748)
     *
     * Document/message by means of which the supplier informs the buyer about the
     * despatch of goods ordered on consignment (goods to be delivered into stock
     * with agreement on payment when goods are sold out of this stock).
     */
    public const CONSIGNMENT_DESPATCH_ADVICE = '748';

    /**
     * Consignment invoice (395)
     *
     * Commercial invoice that covers a transaction other than one involving a
     * sale.
     */
    public const CONSIGNMENT_INVOICE = '395';

    /**
     * Consignment order (227)
     *
     * Order to deliver goods into stock with agreement on payment when goods are
     * sold out of this stock.
     */
    public const CONSIGNMENT_ORDER = '227';

    /**
     * Consignment status report (77)
     *
     * Message covers information about the consignment status.
     */
    public const CONSIGNMENT_STATUS_REPORT = '77';

    /**
     * Consignment unpack report (88)
     *
     * A document code to indicate that the message being transmitted is a
     * consignment unpack report only.
     */
    public const CONSIGNMENT_UNPACK_REPORT = '88';

    /**
     * Consolidated credit note - goods and services (262)
     *
     * Credit note for goods and services that covers multiple transactions
     * involving more than one invoice.
     */
    public const CONSOLIDATED_CREDIT_NOTE_GOODS_AND_SERVICES = '262';

    /**
     * Consolidated invoice (385)
     *
     * Commercial invoice that covers multiple transactions involving more than
     * one vendor.
     */
    public const CONSOLIDATED_INVOICE = '385';

    /**
     * Consular invoice (870)
     *
     * Document/message to be prepared by an exporter in his country and presented
     * to a diplomatic representation of the importing country for endorsement and
     * subsequently to be presented by the importer in connection with the import
     * of the goods described therein.
     */
    public const CONSULAR_INVOICE = '870';

    /**
     * Container discharge list (25)
     *
     * Message/document itemising containers to be discharged from vessel.
     */
    public const CONTAINER_DISCHARGE_LIST = '25';

    /**
     * Container list (235)
     *
     * Document or message issued by party identifying the containers for which
     * they are responsible.
     */
    public const CONTAINER_LIST = '235';

    /**
     * Container manifest (unit packing list) (788)
     *
     * Document/message specifying the contents of particular freight containers
     * or other transport units, prepared by the party responsible for their
     * loading into the container or unit.
     */
    public const CONTAINER_MANIFEST_UNIT_PACKING_LIST = '788';

    /**
     * Container off-hire notice (169)
     *
     * Notice to return leased containers.
     */
    public const CONTAINER_OFFHIRE_NOTICE = '169';

    /**
     * Container stripping order (183)
     *
     * Order to unload goods from a container.
     */
    public const CONTAINER_STRIPPING_ORDER = '183';

    /**
     * Container stuffing order (184)
     *
     * Order to stuff specified goods or consignments in a container.
     */
    public const CONTAINER_STUFFING_ORDER = '184';

    /**
     * Container transfer note (976)
     *
     * Document for the carriage of containers. Syn: transfer note.
     */
    public const CONTAINER_TRANSFER_NOTE = '976';

    /**
     * Contract (315)
     *
     * (1296) Document/message evidencing an agreement between the seller and the
     * buyer for the supply of goods or services; its effects are equivalent to
     * those of an order followed by an acknowledgement of order.
     */
    public const CONTRACT = '315';

    /**
     * Contract bill of quantities - BOQ (207)
     *
     * Document/message providing a formal specification identifying quantities
     * and prices that are the basis of a contract for a construction project. BOQ
     * means: Bill of quantity.
     */
    public const CONTRACT_BILL_OF_QUANTITIES_BOQ = '207';

    /**
     * Contract clauses (776)
     *
     * Document specifying the clauses applying to a contract.
     */
    public const CONTRACT_CLAUSES = '776';

    /**
     * Contract Funds Status Report (CFSR) (161)
     *
     * A report to provide the status of funds applicable to the contract.
     */
    public const CONTRACT_FUNDS_STATUS_REPORT_CFSR = '161';

    /**
     * Contract price and delivery quote (365)
     *
     * Document/message confirming contractual price conditions and contractual
     * delivery conditions under which goods are offered.
     */
    public const CONTRACT_PRICE_AND_DELIVERY_QUOTE = '365';

    /**
     * Contract price quote (364)
     *
     * Document/message confirming contractual price conditions under which goods
     * are offered.
     */
    public const CONTRACT_PRICE_QUOTE = '364';

    /**
     * Contract security classification specification (166)
     *
     * A document that indicates the specification contains the security and
     * classification requirements for a contract.
     */
    public const CONTRACT_SECURITY_CLASSIFICATION_SPECIFICATION = '166';

    /**
     * Control document T5 (823)
     *
     * Control document (export declaration) used particularly in case of
     * re-sending without use with only VAT collection, refusal, unconformity with
     * contract etc.
     */
    public const CONTROL_DOCUMENT_T = '823';

    /**
     * Convention on International Trade in Endangered Species of Wild Fauna and
     * Flora (CITES) Certificate (626)
     *
     * A certificate used in the trade of endangered species in accordance with
     * the CITES convention.
     */
    public const CONVENTION_ON_INTERNATIONAL_TRADE_IN_ENDANGERED_SPECIES_OF_WILD_FAUNA_AND_FLORA_CITES_CERTIFICATE = '626';

    /**
     * Conveyance declaration (874)
     *
     * Declaration of the conveyance to a public authority.
     */
    public const CONVEYANCE_DECLARATION = '874';

    /**
     * Conveyance declaration (arrival) (185)
     *
     * Declaration to the public authority upon arrival of the conveyance.
     */
    public const CONVEYANCE_DECLARATION_ARRIVAL = '185';

    /**
     * Conveyance declaration (combined) (187)
     *
     * Combined declaration of arrival and departure to the public authority.
     */
    public const CONVEYANCE_DECLARATION_COMBINED = '187';

    /**
     * Conveyance declaration (departure) (186)
     *
     * Declaration to the public authority upon departure of the conveyance.
     */
    public const CONVEYANCE_DECLARATION_DEPARTURE = '186';

    /**
     * Copy accounting voucher (534)
     *
     * To indicate that the document/message justifying an accounting entry is a
     * copy.
     */
    public const COPY_ACCOUNTING_VOUCHER = '534';

    /**
     * Corporate superannuation contributions advice (26)
     *
     * Document/message providing contributions advice used for corporate
     * superannuation schemes.
     */
    public const CORPORATE_SUPERANNUATION_CONTRIBUTIONS_ADVICE = '26';

    /**
     * Corporate superannuation member maintenance message (28)
     *
     * Member maintenance message used for corporate superannuation schemes.
     */
    public const CORPORATE_SUPERANNUATION_MEMBER_MAINTENANCE_MESSAGE = '28';

    /**
     * Corrected invoice (384)
     *
     * Commercial invoice that includes revised information differing from an
     * earlier submission of the same invoice.
     */
    public const CORRECTED_INVOICE = '384';

    /**
     * Cost data summary (158)
     *
     * A document indicating a summary of cost data.
     */
    public const COST_DATA_SUMMARY = '158';

    /**
     * Cost performance report (304)
     *
     * A report to convey cost performance data for a project or contract.
     */
    public const COST_PERFORMANCE_REPORT = '304';

    /**
     * Cost Performance Report (CPR) format 5 (180)
     *
     * A report identifying the cost performance on a contract that summarizes
     * cost or schedule variances (format 5 - explanations and problem analysis).
     */
    public const COST_PERFORMANCE_REPORT_CPR_FORMAT = '180';

    /**
     * Cost Schedule Status Report (CSSR) (176)
     *
     * A report providing the status of the cost and schedule applicable to a
     * contract.
     */
    public const COST_SCHEDULE_STATUS_REPORT_CSSR = '176';

    /**
     * Court judgment (854)
     *
     * Document specifying a judgment of a court.
     */
    public const COURT_JUDGMENT = '854';

    /**
     * Cover note (580)
     *
     * Document/message issued by an insurer (insurance broker, agent, etc.) to
     * notify the insured that his insurance have been carried out.
     */
    public const COVER_NOTE = '580';

    /**
     * Coverage confirmation note (773)
     *
     * Document confirming that insurance coverage is granted.
     */
    public const COVERAGE_CONFIRMATION_NOTE = '773';

    /**
     * Credit advice (454)
     *
     * Document/message sent by an account servicing institution to one of its
     * account owners, to inform the account owner of an entry which has been or
     * will be credited to its account for a specified amount on the date
     * indicated.
     */
    public const CREDIT_ADVICE = '454';

    /**
     * Credit cover (65)
     *
     * Document/message issued either by a factor to give a credit cover on a
     * buyer, or by a seller to request a factor's credit cover.
     */
    public const CREDIT_COVER = '65';

    /**
     * Credit note (381)
     *
     * (1113) Document/message for providing credit information to the relevant
     * party.
     */
    public const CREDIT_NOTE = '381';

    /**
     * Credit note for price variation (296)
     *
     * A credit note which is issued against a price variation invoice.
     */
    public const CREDIT_NOTE_FOR_PRICE_VARIATION = '296';

    /**
     * Credit note related to financial adjustments (83)
     *
     * Document message for providing credit information related to financial
     * adjustments to the relevant party, e.g., bonuses.
     */
    public const CREDIT_NOTE_RELATED_TO_FINANCIAL_ADJUSTMENTS = '83';

    /**
     * Credit note related to goods or services (81)
     *
     * Document message used to provide credit information related to a
     * transaction for goods or services to the relevant party.
     */
    public const CREDIT_NOTE_RELATED_TO_GOODS_OR_SERVICES = '81';

    /**
     * Crew list declaration (250)
     *
     * Declaration regarding crew members aboard the conveyance.
     */
    public const CREW_LIST_DECLARATION = '250';

    /**
     * Crew's effects declaration (744)
     *
     * Declaration to Customs regarding the personal effects of crew members
     * aboard the conveyance; equivalent to IMO FAL 4.
     */
    public const CREWS_EFFECTS_DECLARATION = '744';

    /**
     * Cross docking despatch advice (398)
     *
     * Document by means of which the supplier or consignor informs the buyer,
     * consignee or the distribution centre about the despatch of goods for cross
     * docking.
     */
    public const CROSS_DOCKING_DESPATCH_ADVICE = '398';

    /**
     * Cross docking services order (237)
     *
     * A document or message to order cross docking services.
     */
    public const CROSS_DOCKING_SERVICES_ORDER = '237';

    /**
     * Current account (66)
     *
     * Document/message issued by a factor to indicate the money movements of a
     * seller's or another factor's account with him.
     */
    public const CURRENT_ACCOUNT = '66';

    /**
     * Customer payment order(s) (248)
     *
     * The message contains customer payment order(s).
     */
    public const CUSTOMER_PAYMENT_ORDERS = '248';

    /**
     * Customs clearance notice (132)
     *
     * Notification of customs clearance of cargo or items of transport equipment.
     */
    public const CUSTOMS_CLEARANCE_NOTICE = '132';

    /**
     * Customs crew and conveyance (336)
     *
     * Document/message contains information regarding the crew list and
     * conveyance.
     */
    public const CUSTOMS_CREW_AND_CONVEYANCE = '336';

    /**
     * Customs declaration (post parcels) (936)
     *
     * Document/message which, according to Article 106 of the "Agreement
     * concerning Postal Parcels" under the UPU Convention, must accompany post
     * parcels and in which the contents of such parcels are specified.
     */
    public const CUSTOMS_DECLARATION_POST_PARCELS = '936';

    /**
     * Customs declaration for cargo examination (333)
     *
     * Declaration provided to customs for cargo examination.
     */
    public const CUSTOMS_DECLARATION_FOR_CARGO_EXAMINATION = '333';

    /**
     * Customs declaration for cargo examination, alternate (334)
     *
     * Alternate declaration provided to customs for cargo examination.
     */
    public const CUSTOMS_DECLARATION_FOR_CARGO_EXAMINATION_ALTERNATE = '334';

    /**
     * Customs declaration for TIR Carnet goods (587)
     *
     * A Customs declaration in which goods move under cover of TIR Carnets.
     */
    public const CUSTOMS_DECLARATION_FOR_TIR_CARNET_GOODS = '587';

    /**
     * Customs declaration with commercial and item detail (914)
     *
     * CUSDEC transmission that includes data from both the commercial detail and
     * item detail sections of the message.
     */
    public const CUSTOMS_DECLARATION_WITH_COMMERCIAL_AND_ITEM_DETAIL = '914';

    /**
     * Customs declaration without commercial detail (913)
     *
     * CUSDEC transmission that does not include data from the commercial detail
     * section of the message.
     */
    public const CUSTOMS_DECLARATION_WITHOUT_COMMERCIAL_DETAIL = '913';

    /**
     * Customs declaration without item detail (915)
     *
     * CUSDEC transmission that does not include data from the item detail section
     * of the message.
     */
    public const CUSTOMS_DECLARATION_WITHOUT_ITEM_DETAIL = '915';

    /**
     * Customs delivery note (932)
     *
     * Document/message whereby a Customs authority releases goods under its
     * control to be placed at the disposal of the party concerned. Synonym:
     * Customs release note.
     */
    public const CUSTOMS_DELIVERY_NOTE = '932';

    /**
     * Customs documents expiration notice (133)
     *
     * Notice specifying expiration of Customs documents relating to cargo or
     * items of transport equipment.
     */
    public const CUSTOMS_DOCUMENTS_EXPIRATION_NOTICE = '133';

    /**
     * Customs immediate release declaration (931)
     *
     * Document/message issued by an importer notifying Customs that goods have
     * been removed from an importing means of transport to the importer's
     * premises under a Customs-approved arrangement for immediate release, or
     * requesting authorization to do so.
     */
    public const CUSTOMS_IMMEDIATE_RELEASE_DECLARATION = '931';

    /**
     * Customs invoice (935)
     *
     * Document/message required by the Customs in an importing country in which
     * an exporter states the invoice or other price (e.g. selling price, price of
     * identical goods), and specifies costs for freight, insurance and packing,
     * etc., terms of delivery and payment, for the purpose of determining the
     * Customs value in the importing country of goods consigned to that country.
     */
    public const CUSTOMS_INVOICE = '935';

    /**
     * Customs manifest (85)
     *
     * Message/document identifying a customs manifest. The document itemises a
     * list of cargo prepared by shipping companies from bills of landing and
     * presented to customs for formal report of cargo.
     */
    public const CUSTOMS_MANIFEST = '85';

    /**
     * Customs summary declaration with commercial detail, alternate (337)
     *
     * Alternate Customs declaration summary with commercial transaction details.
     */
    public const CUSTOMS_SUMMARY_DECLARATION_WITH_COMMERCIAL_DETAIL_ALTERNATE = '337';

    /**
     * Customs summary declaration without commercial detail, alternate (355)
     *
     * Alternate Customs declaration summary without any commercial transaction
     * details.
     */
    public const CUSTOMS_SUMMARY_DECLARATION_WITHOUT_COMMERCIAL_DETAIL_ALTERNATE = '355';

    /**
     * Damage certification (49)
     *
     * Official certification that damages to the goods to be transported have
     * been discovered.
     */
    public const DAMAGE_CERTIFICATION = '49';

    /**
     * Dangerous goods declaration (890)
     *
     * (1115) Document/message issued by a consignor in accordance with applicable
     * conventions or regulations, describing hazardous goods or materials for
     * transport purposes, and stating that the latter have been packed and
     * labelled in accordance with the provisions of the relevant conventions or
     * regulations.
     */
    public const DANGEROUS_GOODS_DECLARATION = '890';

    /**
     * Dangerous goods list (298)
     *
     * Listing of all details of dangerous goods carried.
     */
    public const DANGEROUS_GOODS_LIST = '298';

    /**
     * Dangerous Goods Notification for non-tanker vessel (523)
     *
     * Dangerous Goods Notification for a vessel carrying cargo other than bulk
     * liquid cargo.
     */
    public const DANGEROUS_GOODS_NOTIFICATION_FOR_NONTANKER_VESSEL = '523';

    /**
     * Dangerous Goods Notification for Tanker vessel (522)
     *
     * Dangerous Goods Notification for a vessel carrying liquid cargo in bulk.
     */
    public const DANGEROUS_GOODS_NOTIFICATION_FOR_TANKER_VESSEL = '522';

    /**
     * Data Plot Sheet (415)
     *
     * Document/Message providing technical description and information of the
     * crop production.
     */
    public const DATA_PLOT_SHEET = '415';

    /**
     * Data protection regulations statement (868)
     *
     * Document specifying the terms of data protection regulations.
     */
    public const DATA_PROTECTION_REGULATIONS_STATEMENT = '868';

    /**
     * Debit advice (456)
     *
     * Advice on a debit.
     */
    public const DEBIT_ADVICE = '456';

    /**
     * Debit note (383)
     *
     * Document/message for providing debit information to the relevant party.
     */
    public const DEBIT_NOTE = '383';

    /**
     * Debit note related to financial adjustments (84)
     *
     * Document/message for providing debit information related to financial
     * adjustments to the relevant party.
     */
    public const DEBIT_NOTE_RELATED_TO_FINANCIAL_ADJUSTMENTS = '84';

    /**
     * Debit note related to goods or services (80)
     *
     * Debit information related to a transaction for goods or services to the
     * relevant party.
     */
    public const DEBIT_NOTE_RELATED_TO_GOODS_OR_SERVICES = '80';

    /**
     * Declaration for radioactive material (654)
     *
     * A declaration to be presented to the competent authority when radioactive
     * material moves cross-border.
     */
    public const DECLARATION_FOR_RADIOACTIVE_MATERIAL = '654';

    /**
     * Declaration of final beneficiary (813)
     *
     * Declaration document to identify the final beneficiary of an asset.
     */
    public const DECLARATION_OF_FINAL_BENEFICIARY = '813';

    /**
     * Declaration of origin (862)
     *
     * Appropriate statement as to the origin of the goods, made in connection
     * with their exportation by the manufacturer, producer, supplier, exporter or
     * other competent person on the Commercial invoice or any other document
     * relating to the goods (CCC).
     */
    public const DECLARATION_OF_ORIGIN = '862';

    /**
     * Declaration regarding the inward and outward movement of vessel (349)
     *
     * Document to declare inward and outward movement of a vessel.
     */
    public const DECLARATION_REGARDING_THE_INWARD_AND_OUTWARD_MOVEMENT_OF_VESSEL = '349';

    /**
     * Delcredere credit note (308)
     *
     * A credit note sent to the party paying on behalf of a number of buyers.
     */
    public const DELCREDERE_CREDIT_NOTE = '308';

    /**
     * Delcredere invoice (390)
     *
     * An invoice sent to the party paying for a number of buyers.
     */
    public const DELCREDERE_INVOICE = '390';

    /**
     * Delivery forecast (236)
     *
     * A message which enables the transmission of delivery or product forecasting
     * requirements.
     */
    public const DELIVERY_FORECAST = '236';

    /**
     * Delivery instructions (240)
     *
     * (1174) Document/message giving instruction regarding the delivery of goods.
     */
    public const DELIVERY_INSTRUCTIONS = '240';

    /**
     * Delivery just-in-time (242)
     *
     * Usage of DELJIT-message.
     */
    public const DELIVERY_JUSTINTIME = '242';

    /**
     * Delivery note (270)
     *
     * Paper document attached to a consignment informing the receiving party
     * about contents of this consignment.
     */
    public const DELIVERY_NOTE = '270';

    /**
     * Delivery notice (goods) (784)
     *
     * Notification in writing, sent by the carrier to the sender, to inform him
     * at his request of the actual date of delivery of the goods.
     */
    public const DELIVERY_NOTICE_GOODS = '784';

    /**
     * Delivery notice (rail transport) (746)
     *
     * Document/message created by the consignor or by the departure station,
     * joined to the transport or sent to the consignee, giving the possibility to
     * the consignee or the arrival station to attest the delivery of the goods.
     * The document must be returned to the consignor or to the departure station.
     */
    public const DELIVERY_NOTICE_RAIL_TRANSPORT = '746';

    /**
     * Delivery order (640)
     *
     * Document/message issued by a party entitled to authorize the release of
     * goods specified therein to a named consignee, to be retained by the
     * custodian of the goods.
     */
    public const DELIVERY_ORDER = '640';

    /**
     * Delivery point list. (440)
     *
     * A list of delivery point addresses.
     */
    public const DELIVERY_POINT_LIST = '440';

    /**
     * Delivery quote (362)
     *
     * Document/message confirming delivery conditions under which goods are
     * offered.
     */
    public const DELIVERY_QUOTE = '362';

    /**
     * Delivery release (245)
     *
     * Document/message issued by a buyer releasing the despatch of goods after
     * receipt of the Ready for despatch advice from the seller.
     */
    public const DELIVERY_RELEASE = '245';

    /**
     * Delivery schedule (241)
     *
     * Usage of DELFOR-message.
     */
    public const DELIVERY_SCHEDULE = '241';

    /**
     * Delivery schedule response (291)
     *
     * A message providing a response to a previously transmitted delivery
     * schedule.
     */
    public const DELIVERY_SCHEDULE_RESPONSE = '291';

    /**
     * Delivery verification certificate (901)
     *
     * Document/message whereby an official authority (Customs or governmental)
     * certifies that goods have been delivered.
     */
    public const DELIVERY_VERIFICATION_CERTIFICATE = '901';

    /**
     * Derat document (796)
     *
     * Document certifying that a ship is free of rats, valid to a specified date.
     */
    public const DERAT_DOCUMENT = '796';

    /**
     * Deratting exemption certificate (488)
     *
     * Document certifying that the object was free of rats when inspected and
     * that it is exempt from a deratting statement.
     */
    public const DERATTING_EXEMPTION_CERTIFICATE = '488';

    /**
     * Despatch advice (351)
     *
     * Document/message by means of which the seller or consignor informs the
     * consignee about the despatch of goods.
     */
    public const DESPATCH_ADVICE = '351';

    /**
     * Despatch note (post parcels) (750)
     *
     * Document/message which, according to Article 106 of the "Agreement
     * concerning Postal Parcels" under the UPU convention, is to accompany post
     * parcels.
     */
    public const DESPATCH_NOTE_POST_PARCELS = '750';

    /**
     * Despatch note model T2 (822)
     *
     * Ascertainment that the declared goods were originally produced in an
     * European Union (EU) country.
     */
    public const DESPATCH_NOTE_MODEL_T = '822';

    /**
     * Despatch note model T2L (825)
     *
     * Ascertainment that the declared goods were originally produced in an
     * European Union (EU) country. May only be used for goods that are loaded on
     * one single means of transport in one single departure point for one single
     * delivery point.
     */
    public const DESPATCH_NOTE_MODEL_TL = '825';

    /**
     * Despatch order (350)
     *
     * Document/message issued by a supplier initiating the despatch of goods to a
     * buyer (consignee).
     */
    public const DESPATCH_ORDER = '350';

    /**
     * Direct debit authorisation (838)
     *
     * Document giving the addressee the right to debit from an account of the
     * authorizing party.
     */
    public const DIRECT_DEBIT_AUTHORISATION = '838';

    /**
     * Direct delivery (transport) (494)
     *
     * Document/message ordering the direct delivery of goods/consignment from one
     * means of transport into another means of transport in one movement.
     */
    public const DIRECT_DELIVERY_TRANSPORT = '494';

    /**
     * Direct payment valuation (202)
     *
     * Document/message addressed, for instance, by a general contractor to the
     * owner, in order that a direct payment be made to a subcontractor.
     */
    public const DIRECT_PAYMENT_VALUATION = '202';

    /**
     * Direct payment valuation request (201)
     *
     * Request to establish a direct payment valuation.
     */
    public const DIRECT_PAYMENT_VALUATION_REQUEST = '201';

    /**
     * Document for establishing the Customs Status of goods for San Marino
     * (T2LSM) (586)
     *
     * Form establishing the Community status of goods ("T2L" under European
     * Legislation) in the context of trade between the EU and San Marino.
     * ("T2LSM" under EU Legislation).
     */
    public const DOCUMENT_FOR_ESTABLISHING_THE_CUSTOMS_STATUS_OF_GOODS_FOR_SAN_MARINO_TLSM = '586';

    /**
     * Document response (Customs) (962)
     *
     * Document response message to permit the transfer of data from Customs to
     * the transmitter of the previous message.
     */
    public const DOCUMENT_RESPONSE_CUSTOMS = '962';

    /**
     * Documentary credit (465)
     *
     * Document/message in which a bank states that it has issued a documentary
     * credit under which the beneficiary is to obtain payment, acceptance or
     * negotiation on compliance with certain terms and conditions and against
     * presentation of stipulated documents and such drafts as may be specified.
     * The credit may or may not be confirmed by another bank.
     */
    public const DOCUMENTARY_CREDIT = '465';

    /**
     * Documentary credit acceptance advice (427)
     *
     * Document/message whereby a bank advises acceptance under a documentary
     * credit.
     */
    public const DOCUMENTARY_CREDIT_ACCEPTANCE_ADVICE = '427';

    /**
     * Documentary credit amendment (469)
     *
     * Document/message whereby a bank notifies a beneficiary of the details of an
     * amendment to the terms and conditions of a documentary credit.
     */
    public const DOCUMENTARY_CREDIT_AMENDMENT = '469';

    /**
     * Documentary credit amendment information (197)
     *
     * Documentary credit amendment information.
     */
    public const DOCUMENTARY_CREDIT_AMENDMENT_INFORMATION = '197';

    /**
     * Documentary credit amendment notification (468)
     *
     * Document/message whereby a bank advises that the terms and conditions of a
     * documentary credit have been amended.
     */
    public const DOCUMENTARY_CREDIT_AMENDMENT_NOTIFICATION = '468';

    /**
     * Documentary credit application (460)
     *
     * Document/message whereby a bank is requested to issue a documentary credit
     * on the conditions specified therein.
     */
    public const DOCUMENTARY_CREDIT_APPLICATION = '460';

    /**
     * Documentary credit collection instruction (195)
     *
     * Instruction for the collection of the documentary credit.
     */
    public const DOCUMENTARY_CREDIT_COLLECTION_INSTRUCTION = '195';

    /**
     * Documentary credit issuance information (200)
     *
     * Provides information on documentary credit issuance.
     */
    public const DOCUMENTARY_CREDIT_ISSUANCE_INFORMATION = '200';

    /**
     * Documentary credit letter of indemnity (431)
     *
     * Document/message in which a beneficiary of a documentary credit accepts
     * responsibility for non-compliance with the terms and conditions of the
     * credit, and undertakes to refund the money received under the credit, with
     * interest and charges accrued.
     */
    public const DOCUMENTARY_CREDIT_LETTER_OF_INDEMNITY = '431';

    /**
     * Documentary credit negotiation advice (428)
     *
     * Document/message whereby a bank advises negotiation under a documentary
     * credit.
     */
    public const DOCUMENTARY_CREDIT_NEGOTIATION_ADVICE = '428';

    /**
     * Documentary credit notification (466)
     *
     * Document/message issued by an advising bank in order to transmit a
     * documentary credit to a beneficiary, or to another advising bank.
     */
    public const DOCUMENTARY_CREDIT_NOTIFICATION = '466';

    /**
     * Documentary credit payment advice (426)
     *
     * Document/message whereby a bank advises payment under a documentary credit.
     */
    public const DOCUMENTARY_CREDIT_PAYMENT_ADVICE = '426';

    /**
     * Documentary credit transfer advice (467)
     *
     * Document/message whereby a bank advises that (part of) a documentary credit
     * is being or has been transferred in favour of a second beneficiary.
     */
    public const DOCUMENTARY_CREDIT_TRANSFER_ADVICE = '467';

    /**
     * Documents presentation form (448)
     *
     * Document/message whereby a draft or similar instrument and/or commercial
     * documents are presented to a bank for acceptance, discounting, negotiation,
     * payment or collection, whether or not against a documentary credit.
     */
    public const DOCUMENTS_PRESENTATION_FORM = '448';

    /**
     * Draft bill of quantity (194)
     *
     * Document/message providing a draft bill of quantity, issued in an unpriced
     * form.
     */
    public const DRAFT_BILL_OF_QUANTITY = '194';

    /**
     * Drawing (174)
     *
     * The document or message is a drawing.
     */
    public const DRAWING = '174';

    /**
     * Driving licence (international) (41)
     *
     * An official document giving a native of one country permission to drive a
     * vehicle in certain other countries.
     */
    public const DRIVING_LICENCE_INTERNATIONAL = '41';

    /**
     * Driving licence (national) (40)
     *
     * An official document giving permission to drive a vehicle in a given
     * country.
     */
    public const DRIVING_LICENCE_NATIONAL = '40';

    /**
     * Drug shelf life study report (647)
     *
     * A document containing results from the study which determines the shelf
     * life, namely the time period of storage at a specified condition within
     * which a drug substance or drug product still meets its established
     * specifications; its identity, strength, quality and purity.
     */
    public const DRUG_SHELF_LIFE_STUDY_REPORT = '647';

    /**
     * Duty suspended goods (974)
     *
     * Document giving details for the carriage of excisable goods on a
     * duty-suspended basis.
     */
    public const DUTY_SUSPENDED_GOODS = '974';

    /**
     * EC carnet (953)
     *
     * EC customs transit document issued by EC customs authorities for transit
     * and/or temporary user of goods within the EC.
     */
    public const EC_CARNET = '953';

    /**
     * EDI associated object administration message (344)
     *
     * A message giving additional information about the exchange of an EDI
     * associated object.
     */
    public const EDI_ASSOCIATED_OBJECT_ADMINISTRATION_MESSAGE = '344';

    /**
     * Embargo permit (941)
     *
     * Document/message giving the permission to export specified goods.
     */
    public const EMBARGO_PERMIT = '941';

    /**
     * Empty container bill (708)
     *
     * Bill of lading indicating an empty container.
     */
    public const EMPTY_CONTAINER_BILL = '708';

    /**
     * Empty container disposition order (144)
     *
     * Order to make available empty containers.
     */
    public const EMPTY_CONTAINER_DISPOSITION_ORDER = '144';

    /**
     * End use authorization (990)
     *
     * Document issued by Customs granting the end-use Customs procedure.
     */
    public const END_USE_AUTHORIZATION = '990';

    /**
     * Enquiry (210)
     *
     * Document/message issued by a party interested in the purchase of goods
     * specified therein and indicating particular, desirable conditions regarding
     * delivery terms, etc., addressed to a prospective supplier with a view to
     * obtaining an offer.
     */
    public const ENQUIRY = '210';

    /**
     * Error response (Customs) (963)
     *
     * Error response message to permit the transfer of data from Customs to the
     * transmitter of the previous message.
     */
    public const ERROR_RESPONSE_CUSTOMS = '963';

    /**
     * Escort official recognition (723)
     *
     * Document/message which gives right to the owner to exert all functions
     * normally transferred to a guard in a train by which an escorted consignment
     * is transported.
     */
    public const ESCORT_OFFICIAL_RECOGNITION = '723';

    /**
     * Estimated priced bill of quantity (193)
     *
     * An estimate based upon a detailed, quantity based specification (bill of
     * quantity).
     */
    public const ESTIMATED_PRICED_BILL_OF_QUANTITY = '193';

    /**
     * EU Customs declaration for External Community Transit (T1) (578)
     *
     * Customs declaration for goods under the external Community/common transit
     * procedure. This applies to "non-Community goods" ("T1" under EU legislation
     * and EC-EFTA "Transit Convention").
     */
    public const EU_CUSTOMS_DECLARATION_FOR_EXTERNAL_COMMUNITY_TRANSIT_T = '578';

    /**
     * EU Customs declaration for internal Community Transit (T2) (579)
     *
     * Customs declaration for goods under the internal Community/common transit
     * procedure. This applies to "Community goods" ("T2" under EU legislation and
     * EC-EFTA "Transit Convention").
     */
    public const EU_CUSTOMS_DECLARATION_FOR_INTERNAL_COMMUNITY_TRANSIT_T = '579';

    /**
     * EU Customs declaration for internal transit to San Marino (T2SM) (582)
     *
     * Customs declaration for goods under the internal Community transit
     * procedure between the Community and San Marino. ("T2SM" under EU
     * Legislation).
     */
    public const EU_CUSTOMS_DECLARATION_FOR_INTERNAL_TRANSIT_TO_SAN_MARINO_TSM = '582';

    /**
     * EU Customs declaration for mixed consignments (T) (583)
     *
     * Customs declaration for goods under the Community/common transit procedure
     * for mixed consignments (i.e. consignments that comprise goods of different
     * statuses, like "T1" and "T2") ("T" under EU Legislation).
     */
    public const EU_CUSTOMS_DECLARATION_FOR_MIXED_CONSIGNMENTS_T = '583';

    /**
     * EU Customs declaration for non-fiscal area internal Community Transit (T2F) (581)
     *
     * Declaration for goods under the internal Community transit procedure in the
     * context of trade between the "VAT" territory of EU Member States and EU
     * territories where the VAT rules do not apply, such as Canary islands, some
     * French overseas territories, the Channel islands and the Aaland islands,
     * and between those territories. ("T2F" under EU Legislation).
     */
    public const EU_CUSTOMS_DECLARATION_FOR_NONFISCAL_AREA_INTERNAL_COMMUNITY_TRANSIT_TF = '581';

    /**
     * EU Document for establishing the Community status of goods (T2L) (584)
     *
     * Form establishing the Community status of goods ("T2L" under EU
     * Legislation).
     */
    public const EU_DOCUMENT_FOR_ESTABLISHING_THE_COMMUNITY_STATUS_OF_GOODS_TL = '584';

    /**
     * EU Document for establishing the Community status of goods for certain
     * fiscal purposes (T2LF) (585)
     *
     * Form establishing the Community status of goods in the context of trade
     * between the "VAT" territory of EU Member States and EU territories where
     * the VAT rules do not apply, such as Canary islands, some French overseas
     * territories, the Channel islands and the Aaland islands, and between those
     * territories ("T2LF" under EU Legislation).
     */
    public const EU_DOCUMENT_FOR_ESTABLISHING_THE_COMMUNITY_STATUS_OF_GOODS_FOR_CERTAIN_FISCAL_PURPOSES_TLF = '585';

    /**
     * EUR 1 certificate of origin (954)
     *
     * Customs certificate used in preferential goods interchanges between EC
     * countries and EC external countries.
     */
    public const EUR__CERTIFICATE_OF_ORIGIN = '954';

    /**
     * European Single Procurement Document (759)
     *
     * A document/message containing a self-declaration by the supplier, providing
     * preliminary evidence during the tendering phase.
     */
    public const EUROPEAN_SINGLE_PROCUREMENT_DOCUMENT = '759';

    /**
     * European Single Procurement Document request (756)
     *
     * A document/message requesting a self-declaration from the supplier,
     * providing preliminary evidence during the tendering phase.
     */
    public const EUROPEAN_SINGLE_PROCUREMENT_DOCUMENT_REQUEST = '756';

    /**
     * Exceptional order (400)
     *
     * An order which falls outside the framework of an agreement.
     */
    public const EXCEPTIONAL_ORDER = '400';

    /**
     * Exchange control declaration (import) (927)
     *
     * Document/message completed by an importer/buyer as a means for the
     * competent body to control that a trade transaction for which foreign
     * exchange has been allocated has been executed and that money has been
     * transferred in accordance with the conditions of payment and the exchange
     * control regulations in force.
     */
    public const EXCHANGE_CONTROL_DECLARATION_IMPORT = '927';

    /**
     * Exchange control declaration, export (812)
     *
     * Document/message completed by an exporter/seller as a means whereby the
     * competent body may control that the amount of foreign exchange accrued from
     * a trade transaction is repatriated in accordance with the conditions of
     * payment and exchange control regulations in force.
     */
    public const EXCHANGE_CONTROL_DECLARATION_EXPORT = '812';

    /**
     * Excise certificate (100)
     *
     * Certificate asserting that the goods have been submitted to the excise
     * authorities before departure from the exporting country or before delivery
     * in case of import traffic.
     */
    public const EXCISE_CERTIFICATE = '100';

    /**
     * Exclusive brokerage mandate (869)
     *
     * Document expressing the mandate of a client for a service only by the
     * mandated broker.
     */
    public const EXCLUSIVE_BROKERAGE_MANDATE = '869';

    /**
     * Export licence (811)
     *
     * Permit issued by a government authority permitting exportation of a
     * specified commodity subject to specified conditions as quantity, country of
     * destination, etc. Synonym: Embargo permit.
     */
    public const EXPORT_LICENCE = '811';

    /**
     * Export licence, application for (810)
     *
     * Application for a permit issued by a government authority permitting
     * exportation of a specified commodity subject to specified conditions as
     * quantity, country of destination, etc.
     */
    public const EXPORT_LICENCE_APPLICATION_FOR = '810';

    /**
     * Export price certificate (645)
     *
     * A certification executed by the competent authority from country of
     * exportation stating the export price of the goods.
     */
    public const EXPORT_PRICE_CERTIFICATE = '645';

    /**
     * Extended credit advice (455)
     *
     * Document/message sent by an account servicing institution to one of its
     * account owners, to inform the account owner of an entry that has been or
     * will be credited to its account for a specified amount on the date
     * indicated. It provides extended commercial information concerning the
     * relevant remittance advice.
     */
    public const EXTENDED_CREDIT_ADVICE = '455';

    /**
     * Extended payment order (451)
     *
     * Document/message containing information needed to initiate the payment. It
     * may cover the financial settlement for several commercial trade
     * transactions, which it is possible to specify in a special payments detail
     * part. It is an instruction to the ordered bank to arrange for the payment
     * of one specified amount to the beneficiary.
     */
    public const EXTENDED_PAYMENT_ORDER = '451';

    /**
     * Extra-Community trade statistical declaration (47)
     *
     * Document/message in which a declarant provides information about
     * extra-Community trade of goods required by the body responsible for the
     * collection of trade statistics. Trade by a country in the European Union
     * with a country outside the European Union.
     */
    public const EXTRACOMMUNITY_TRADE_STATISTICAL_DECLARATION = '47';

    /**
     * Factored credit note (396)
     *
     * Credit note related to assigned invoice(s).
     */
    public const FACTORED_CREDIT_NOTE = '396';

    /**
     * Factored invoice (393)
     *
     * Invoice assigned to a third party for collection.
     */
    public const FACTORED_INVOICE = '393';

    /**
     * Farmyard manure analysis (417)
     *
     * Farmyard manure analysis document.
     */
    public const FARMYARD_MANURE_ANALYSIS = '417';

    /**
     * Federal label approval (11)
     *
     * A pre-approved document relating to federal label approval requirements.
     */
    public const FEDERAL_LABEL_APPROVAL = '11';

    /**
     * Final construction invoice (877)
     *
     * Invoice concluding all previous partial invoices and partial final
     * construction invoices in the context of a specific construction project.
     */
    public const FINAL_CONSTRUCTION_INVOICE = '877';

    /**
     * Final payment request based on completion of work (218)
     *
     * The final payment request of a series of payment requests submitted upon
     * completion of all the work.
     */
    public const FINAL_PAYMENT_REQUEST_BASED_ON_COMPLETION_OF_WORK = '218';

    /**
     * First sample test report (8)
     *
     * Document/message describes the test report of the first sample.
     */
    public const FIRST_SAMPLE_TEST_REPORT = '8';

    /**
     * Food grade certificate (637)
     *
     * A document that shows that the product (food additive, detergent,
     * disinfectant and sanitizer) is suitable to be used in the food industry.
     */
    public const FOOD_GRADE_CERTIFICATE = '637';

    /**
     * Food packaging contact certificate (643)
     *
     * A document legalized from a competent authority that shows that the food
     * packaging product is safe to come into contact with food.
     */
    public const FOOD_PACKAGING_CONTACT_CERTIFICATE = '643';

    /**
     * Foreign exchange permit (926)
     *
     * Document/message issued by the competent body authorizing an importer/buyer
     * to transfer an amount of foreign exchange to an exporter/seller in payment
     * for goods.
     */
    public const FOREIGN_EXCHANGE_PERMIT = '926';

    /**
     * Forwarder's advice to exporter (622)
     *
     * Document/message issued by a freight forwarder informing an exporter of the
     * action taken in fulfillment of instructions received.
     */
    public const FORWARDERS_ADVICE_TO_EXPORTER = '622';

    /**
     * Forwarder's advice to import agent (621)
     *
     * Document/message issued by a freight forwarder in an exporting country
     * advising his counterpart in an importing country about the forwarding of
     * goods described therein.
     */
    public const FORWARDERS_ADVICE_TO_IMPORT_AGENT = '621';

    /**
     * Forwarder's bill of lading (716)
     *
     * Non-negotiable document issued by a freight forwarder evidencing a contract
     * for the carriage of goods by sea and the taking over or loading of the
     * goods by the freight forwarder, and by which the freight forwarder
     * undertakes to deliver the goods to the consignee named in the document.
     */
    public const FORWARDERS_BILL_OF_LADING = '716';

    /**
     * Forwarder's certificate of receipt (624)
     *
     * Non-negotiable document issued by a forwarder to certify that he has
     * assumed control of a specified consignment, with irrevocable instructions
     * to send it to the consignee indicated in the document or to hold it at his
     * disposal. E.g. FIATA-FCR.
     */
    public const FORWARDERS_CERTIFICATE_OF_RECEIPT = '624';

    /**
     * Forwarder's certificate of transport (763)
     *
     * Negotiable document/message issued by a forwarder to certify that he has
     * taken charge of a specified consignment for despatch and delivery in
     * accordance with the consignor's instructions, as indicated in the document,
     * and that he accepts responsibility for delivery of the goods to the holder
     * of the document through the intermediary of a delivery agent of his choice.
     * E.g. FIATA-FCT.
     */
    public const FORWARDERS_CERTIFICATE_OF_TRANSPORT = '763';

    /**
     * Forwarder's invoice (623)
     *
     * Invoice issued by a freight forwarder specifying services rendered and
     * costs incurred and claiming payment therefore.
     */
    public const FORWARDERS_INVOICE = '623';

    /**
     * Forwarder's warehouse receipt (631)
     *
     * Document/message issued by a forwarder acting as Warehouse Keeper
     * acknowledging receipt of goods placed in a warehouse, and stating or
     * referring to the conditions which govern the warehousing and the release of
     * goods. The document contains detailed provisions regarding the rights of
     * holders-by-endorsement, transfer of ownership, etc. E.g. FIATA-FWR.
     */
    public const FORWARDERS_WAREHOUSE_RECEIPT = '631';

    /**
     * Forwarder’s credit note (532)
     *
     * Document/message for providing credit information to the relevant party.
     */
    public const FORWARDERS_CREDIT_NOTE = '532';

    /**
     * Forwarder’s invoice discrepancy report (553)
     *
     * Document/message reporting invoice discrepancies indentified by the
     * forwarder.
     */
    public const FORWARDERS_INVOICE_DISCREPANCY_REPORT = '553';

    /**
     * Forwarding instructions (610)
     *
     * Document/message issued to a freight forwarder, giving instructions
     * regarding the action to be taken by the forwarder for the forwarding of
     * goods described therein.
     */
    public const FORWARDING_INSTRUCTIONS = '610';

    /**
     * Framework Agreement (539)
     *
     * An agreement between one or more contracting authorities and one or more
     * economic operators, the purpose of which is to establish the terms
     * governing contracts to be awarded during a given period, in particular with
     * regard to price and, where appropriate, the quantity envisaged.
     */
    public const FRAMEWORK_AGREEMENT = '539';

    /**
     * Free pass (42)
     *
     * A document giving free access to a service.
     */
    public const FREE_PASS = '42';

    /**
     * Free Sale Certificate in the Country of Origin (627)
     *
     * A certificate confirming that a specified product is free for sale in the
     * country of origin.
     */
    public const FREE_SALE_CERTIFICATE_IN_THE_COUNTRY_OF_ORIGIN = '627';

    /**
     * Freight invoice (780)
     *
     * Document/message issued by a transport operation specifying freight costs
     * and charges incurred for a transport operation and stating conditions of
     * payment.
     */
    public const FREIGHT_INVOICE = '780';

    /**
     * Freight manifest (786)
     *
     * Document/message containing the same information as a cargo manifest, and
     * additional details on freight amounts, charges, etc.
     */
    public const FREIGHT_MANIFEST = '786';

    /**
     * Fumigation certificate (267)
     *
     * Certificate attesting that fumigation has been performed.
     */
    public const FUMIGATION_CERTIFICATE = '267';

    /**
     * Gate pass (655)
     *
     * Document/message authorizing goods specified therein to be brought out of a
     * fenced-in port or terminal area.
     */
    public const GATE_PASS = '655';

    /**
     * General cargo summary manifest report (87)
     *
     * A document code to indicate that the message being transmitted is summary
     * manifest information for general cargo.
     */
    public const GENERAL_CARGO_SUMMARY_MANIFEST_REPORT = '87';

    /**
     * General message (719)
     *
     * Document/message providing agreed textual information.
     */
    public const GENERAL_MESSAGE = '719';

    /**
     * General response (Customs) (961)
     *
     * General response message to permit the transfer of data from Customs to the
     * transmitter of the previous message.
     */
    public const GENERAL_RESPONSE_CUSTOMS = '961';

    /**
     * General terms and conditions (774)
     *
     * Document specifying general terms and conditions.
     */
    public const GENERAL_TERMS_AND_CONDITIONS = '774';

    /**
     * Good Manufacturing Practice (GMP) Certificate (538)
     *
     * Certificate that guarantees quality manufacturing and processing of food
     * products, medications, cosmetics, etc.
     */
    public const GOOD_MANUFACTURING_PRACTICE_GMP_CERTIFICATE = '538';

    /**
     * Goods control certificate (841)
     *
     * Document/message issued by a competent body evidencing the quality of the
     * goods described therein, in accordance with national or international
     * standards, or conforming to legislation in the importing country, or as
     * specified in the contract.
     */
    public const GOODS_CONTROL_CERTIFICATE = '841';

    /**
     * Goods declaration for Customs transit (950)
     *
     * Document/message by which the sender declares goods for Customs transit
     * according to Annex E.1 (concerning Customs transit) to the Kyoto convention
     * (CCC).
     */
    public const GOODS_DECLARATION_FOR_CUSTOMS_TRANSIT = '950';

    /**
     * Goods declaration for exportation (830)
     *
     * Document/message by which goods are declared for export Customs clearance,
     * conforming to the layout key set out at Appendix I to Annex C.1 concerning
     * outright exportation to the Kyoto convention (CCC). Within a Customs union,
     * "for despatch" may have the same meaning as "for exportation".
     */
    public const GOODS_DECLARATION_FOR_EXPORTATION = '830';

    /**
     * Goods declaration for home use (930)
     *
     * Document/message by which goods are declared for import Customs clearance
     * according to Annex B.1 (concerning clearance for home use) to the Kyoto
     * convention (CCC).
     */
    public const GOODS_DECLARATION_FOR_HOME_USE = '930';

    /**
     * Goods declaration for importation (929)
     *
     * Document/message by which goods are declared for import Customs clearance
     * [sister entry of 830].
     */
    public const GOODS_DECLARATION_FOR_IMPORTATION = '929';

    /**
     * Goods receipt (632)
     *
     * Document/message to acknowledge the receipt of goods and in addition may
     * indicate receiving conditions.
     */
    public const GOODS_RECEIPT = '632';

    /**
     * Goods receipt, carriage (702)
     *
     * Document/message issued by a carrier or a carrier's agent, acknowledging
     * receipt for carriage of goods specified therein on conditions stated or
     * referred to in the document, enabling the carrier to issue a transport
     * document.
     */
    public const GOODS_RECEIPT_CARRIAGE = '702';

    /**
     * Government contract (991)
     *
     * Document/message describing a contract with a government authority.
     */
    public const GOVERNMENT_CONTRACT = '991';

    /**
     * Grant (151)
     *
     * A document indicating the granting of funds.
     */
    public const GRANT = '151';

    /**
     * Group insurance rules (778)
     *
     * Document stating the rules of a group insurance contract.
     */
    public const GROUP_INSURANCE_RULES = '778';

    /**
     * Group pension commitment information (816)
     *
     * Information document for the group pension commitment to an individual
     * person.
     */
    public const GROUP_PENSION_COMMITMENT_INFORMATION = '816';

    /**
     * Guarantee of cost acceptance (826)
     *
     * Document certifying the guarantee of the document issuer that he will pay
     * for costs of the addressee, e.g. the costs for repairing a vehicle.
     */
    public const GUARANTEE_OF_COST_ACCEPTANCE = '826';

    /**
     * Halal Slaughtering Certificate (589)
     *
     * A certificate verifying that meat has been produced from slaughter in
     * accordance with Islamic laws and practices.
     */
    public const HALAL_SLAUGHTERING_CERTIFICATE = '589';

    /**
     * Handling order (650)
     *
     * Document/message issued by a cargo handling organization (port
     * administration, terminal operator, etc.) for the removal or other handling
     * of goods under their care.
     */
    public const HANDLING_ORDER = '650';

    /**
     * Health certificate (636)
     *
     * A document legalized from a competent authority that shows that the product
     * has been tested microbiologically and is free from any pathogens and fit
     * for human consumption and/or declares that the product is in compliance
     * with sanitary and phytosanitary measures.
     */
    public const HEALTH_CERTIFICATE = '636';

    /**
     * Healthcare discharge report, final (309)
     *
     * Final discharge report by healthcare provider.
     */
    public const HEALTHCARE_DISCHARGE_REPORT_FINAL = '309';

    /**
     * Healthcare discharge report, preliminary (358)
     *
     * Preliminary discharge report by healthcare provider.
     */
    public const HEALTHCARE_DISCHARGE_REPORT_PRELIMINARY = '358';

    /**
     * Heat Treatment Certificate (625)
     *
     * A certificate verifying the heat treatment of the product is in conformance
     * with international standards to ensure the product’s healthiness and/or
     * shows the mode of heat treatment indicating the temperature and the amount
     * of time the product or raw material used in the product was treated (such
     * as milk).
     */
    public const HEAT_TREATMENT_CERTIFICATE = '625';

    /**
     * Hire invoice (387)
     *
     * Document/message for invoicing the hiring of human resources or renting
     * goods or equipment.
     */
    public const HIRE_INVOICE = '387';

    /**
     * Hire order (232)
     *
     * Document/message for hiring human resources or renting goods or equipment.
     */
    public const HIRE_ORDER = '232';

    /**
     * Horsemeat sanitary certificate (92)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that horsemeat products comply with the requirements set
     * by the importing country.
     */
    public const HORSEMEAT_SANITARY_CERTIFICATE = '92';

    /**
     * House bill of lading (714)
     *
     * The bill of lading issued not by the carrier but by the freight
     * forwarder/consolidator known by the carrier.
     */
    public const HOUSE_BILL_OF_LADING = '714';

    /**
     * House waybill (703)
     *
     * The document made out by an agent/consolidator which evidences the contract
     * between the shipper and the agent/consolidator for the arrangement of
     * carriage of goods.
     */
    public const HOUSE_WAYBILL = '703';

    /**
     * Identification match (449)
     *
     * Message related to conducting a search for an identification match.
     */
    public const IDENTIFICATION_MATCH = '449';

    /**
     * Identity card (36)
     *
     * Official document to identify a person.
     */
    public const IDENTITY_CARD = '36';

    /**
     * Image (858)
     *
     * Document consisting of an image.
     */
    public const IMAGE = '858';

    /**
     * Impending arrival (96)
     *
     * Notification of impending arrival details for vessel.
     */
    public const IMPENDING_ARRIVAL = '96';

    /**
     * Implementation guideline (302)
     *
     * A document specifying the criterion and format for exchanging information
     * in an electronic data interchange syntax.
     */
    public const IMPLEMENTATION_GUIDELINE = '302';

    /**
     * Import licence (911)
     *
     * Document/message issued by the competent body in accordance with import
     * regulations in force, by which authorization is granted to a named party to
     * import either a limited quantity of designated articles or an unlimited
     * quantity of such articles during a limited period, under conditions
     * specified in the document.
     */
    public const IMPORT_LICENCE = '911';

    /**
     * Import licence, application for (910)
     *
     * Document/message in which an interested party applies to the competent body
     * for authorization to import either a limited quantity of articles subject
     * to import restrictions, or an unlimited quantity of such articles during a
     * limited period, and specifies the kind of articles, their origin and value,
     * etc.
     */
    public const IMPORT_LICENCE_APPLICATION_FOR = '910';

    /**
     * Indefinite delivery definite quantity contract (153)
     *
     * A document indicating a contract calling for indefinite deliveries of
     * definite quantities.
     */
    public const INDEFINITE_DELIVERY_DEFINITE_QUANTITY_CONTRACT = '153';

    /**
     * Indefinite delivery indefinite quantity contract (152)
     *
     * A document indicating a contract calling for the indefinite deliveries of
     * indefinite quantities of goods.
     */
    public const INDEFINITE_DELIVERY_INDEFINITE_QUANTITY_CONTRACT = '152';

    /**
     * Industry superannuation contributions advice (27)
     *
     * Document/message providing contributions advice used for superannuation
     * schemes which are industry wide.
     */
    public const INDUSTRY_SUPERANNUATION_CONTRIBUTIONS_ADVICE = '27';

    /**
     * Industry superannuation member maintenance message (29)
     *
     * Member maintenance message used for industry wide superannuation schemes.
     */
    public const INDUSTRY_SUPERANNUATION_MEMBER_MAINTENANCE_MESSAGE = '29';

    /**
     * Inedible sanitary certificate (95)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that inedible products comply with the requirements set
     * by the importing country.
     */
    public const INEDIBLE_SANITARY_CERTIFICATE = '95';

    /**
     * Infrastructure condition (413)
     *
     * Information about components in an infrastructure.
     */
    public const INFRASTRUCTURE_CONDITION = '413';

    /**
     * Inland waterway bill of lading (711)
     *
     * Negotiable transport document made out to a named person, to order or to
     * bearer, signed by the carrier and handed to the sender after receipt of the
     * goods.
     */
    public const INLAND_WATERWAY_BILL_OF_LADING = '711';

    /**
     * Inquiry (251)
     *
     * This is a request for information.
     */
    public const INQUIRY = '251';

    /**
     * Inquiry mandate (871)
     *
     * Document expressing the mandate of a client for an inquiry service by the
     * mandated provider.
     */
    public const INQUIRY_MANDATE = '871';

    /**
     * Inspection certificate (856)
     *
     * Document/message issued by a competent body evidencing that the goods
     * described therein have been inspected in accordance with national or
     * international standards, in conformity with legislation in the country in
     * which the inspection is required, or as specified in the contract.
     */
    public const INSPECTION_CERTIFICATE = '856';

    /**
     * Inspection report (293)
     *
     * A message informing a party of the results of an inspection.
     */
    public const INSPECTION_REPORT = '293';

    /**
     * Inspection request (292)
     *
     * A message requesting a party to inspect items.
     */
    public const INSPECTION_REQUEST = '292';

    /**
     * Instruction for returns (733)
     *
     * A message by which a party informs another party whether and how goods
     * shall be returned.
     */
    public const INSTRUCTION_FOR_RETURNS = '733';

    /**
     * Instruction to collect (297)
     *
     * A message instructing a party to collect goods.
     */
    public const INSTRUCTION_TO_COLLECT = '297';

    /**
     * Instructions for bank transfer (409)
     *
     * Document/message containing instructions from a customer to his bank to pay
     * an amount in a specified currency to a nominated party in another country
     * by a method either specified (e.g. teletransmission, air mail) or left to
     * the discretion of the bank.
     */
    public const INSTRUCTIONS_FOR_BANK_TRANSFER = '409';

    /**
     * Insurance certificate (520)
     *
     * Document/message issued to the insured certifying that insurance has been
     * effected and that a policy has been issued. Such a certificate for a
     * particular cargo is primarily used when good are insured under the terms of
     * a floating or an open policy; at the request of the insured it can be
     * exchanged for a policy.
     */
    public const INSURANCE_CERTIFICATE = '520';

    /**
     * Insurance declaration sheet (bordereau) (550)
     *
     * A document/message used when an insured reports to his insurer details of
     * individual shipments which are covered by an insurance contract - an open
     * cover or a floating policy - between the parties.
     */
    public const INSURANCE_DECLARATION_SHEET_BORDEREAU = '550';

    /**
     * Insurance policy (530)
     *
     * Document/message issued by the insurer evidencing an agreement to insure
     * and containing the conditions of the agreement concluded whereby the
     * insurer undertakes for a specific fee to indemnify the insured for the
     * losses arising out of the perils and accidents specified in the contract.
     */
    public const INSURANCE_POLICY = '530';

    /**
     * Insured party payment report (836)
     *
     * Report about payments done towards an insured party.
     */
    public const INSURED_PARTY_PAYMENT_REPORT = '836';

    /**
     * Insured status report (815)
     *
     * Document reporting (e.g. annually) to the insured the actual details of an
     * insurance contract.
     */
    public const INSURED_STATUS_REPORT = '815';

    /**
     * Insurer's invoice (575)
     *
     * Document/message issued by an insurer specifying the cost of an insurance
     * which has been effected and claiming payment therefore.
     */
    public const INSURERS_INVOICE = '575';

    /**
     * Interim application for payment (211)
     *
     * Document/message containing a provisional assessment in support of a
     * request for payment for completed work for a construction contract.
     */
    public const INTERIM_APPLICATION_FOR_PAYMENT = '211';

    /**
     * Interim International Ship Security Certificate (537)
     *
     * An interim certificate on ship security issued basis under the
     * International code for the Security of Ships and of Port facilities (ISPS
     * code).
     */
    public const INTERIM_INTERNATIONAL_SHIP_SECURITY_CERTIFICATE = '537';

    /**
     * Intermediate handling cross docking despatch advice (464)
     *
     * Document by means of which the supplier or consignor informs the buyer,
     * consignee or the distribution centre about the despatch of products which
     * will be moved across a dock, de-consolidated and re-consolidated according
     * to final delivery location requirements.
     */
    public const INTERMEDIATE_HANDLING_CROSS_DOCKING_DESPATCH_ADVICE = '464';

    /**
     * Intermediate handling cross docking order (402)
     *
     * An order requesting the supply of products which will be moved across a
     * dock, de-consolidated and re-consolidated according to the final delivery
     * location requirements.
     */
    public const INTERMEDIATE_HANDLING_CROSS_DOCKING_ORDER = '402';

    /**
     * Internal transport order (150)
     *
     * Document/message giving instructions about the transport of goods within an
     * enterprise.
     */
    public const INTERNAL_TRANSPORT_ORDER = '150';

    /**
     * International Ship Security Certificate (536)
     *
     * A certificate on ship security issued based on the International code for
     * the Security of Ships and of Port facilities (ISPS code).
     */
    public const INTERNATIONAL_SHIP_SECURITY_CERTIFICATE = '536';

    /**
     * INTRASTAT declaration (896)
     *
     * Document/message in which a declarant provides information about goods
     * required by the body responsible for the collection of trade statistics.
     */
    public const INTRASTAT_DECLARATION = '896';

    /**
     * Introductory letter (867)
     *
     * A letter of introduction attached to, or accompanying another document such
     * as an insurance policy.
     */
    public const INTRODUCTORY_LETTER = '867';

    /**
     * Inventory adjustment status report (263)
     *
     * A message detailing statuses related to the adjustment of inventory.
     */
    public const INVENTORY_ADJUSTMENT_STATUS_REPORT = '263';

    /**
     * Inventory movement advice (78)
     *
     * Advice of inventory movements.
     */
    public const INVENTORY_MOVEMENT_ADVICE = '78';

    /**
     * Inventory report (35)
     *
     * A message specifying information relating to held inventories.
     */
    public const INVENTORY_REPORT = '35';

    /**
     * Inventory status advice (79)
     *
     * Advice of stock on hand.
     */
    public const INVENTORY_STATUS_ADVICE = '79';

    /**
     * Invitation to tender (755)
     *
     * A document/message used by a buyer to define the procurement procedure and
     * request specific suppliers to participate.
     */
    public const INVITATION_TO_TENDER = '755';

    /**
     * Invoice information for accounting purposes (751)
     *
     * A document / message containing accounting related information such as
     * monetary summations, seller id and VAT information. This may not be a
     * complete invoice according to legal requirements. For instance the line
     * item information might be excluded.
     */
    public const INVOICE_INFORMATION_FOR_ACCOUNTING_PURPOSES = '751';

    /**
     * Invoicing data sheet (130)
     *
     * Document/message issued within an enterprise containing data about goods
     * sold, to be used as the basis for the preparation of an invoice.
     */
    public const INVOICING_DATA_SHEET = '130';

    /**
     * Items booked to a financial account report (338)
     *
     * A message reporting items which have been booked to a financial account.
     */
    public const ITEMS_BOOKED_TO_A_FINANCIAL_ACCOUNT_REPORT = '338';

    /**
     * Kanban schedule (288)
     *
     * Message to describe a Kanban schedule.
     */
    public const KANBAN_SCHEDULE = '288';

    /**
     * Lease invoice (394)
     *
     * Usage of INVOIC-message for goods in leasing contracts.
     */
    public const LEASE_INVOICE = '394';

    /**
     * Lease order (223)
     *
     * Document/message for goods in leasing contracts.
     */
    public const LEASE_ORDER = '223';

    /**
     * Legal action (848)
     *
     * Document specifying a legal action at court.
     */
    public const LEGAL_ACTION = '848';

    /**
     * Legal statement of an account (54)
     *
     * A statement of an account containing the booked items as in the ledger of
     * the account servicing financial institution.
     */
    public const LEGAL_STATEMENT_OF_AN_ACCOUNT = '54';

    /**
     * Letter of indemnity for non-surrender of bill of lading (715)
     *
     * Document/message issued by a commercial party or a bank of an insurance
     * company accepting responsibility to the beneficiary of the indemnity in
     * accordance with the terms thereof.
     */
    public const LETTER_OF_INDEMNITY_FOR_NONSURRENDER_OF_BILL_OF_LADING = '715';

    /**
     * Letter of intent (215)
     *
     * Document/message by means of which a buyer informs a seller that the buyer
     * intends to enter into contractual negotiations.
     */
    public const LETTER_OF_INTENT = '215';

    /**
     * Life insurance payroll deductions advice (30)
     *
     * Payroll deductions advice used in the life insurance industry.
     */
    public const LIFE_INSURANCE_PAYROLL_DEDUCTIONS_ADVICE = '30';

    /**
     * Listing statement of an account (55)
     *
     * A statement from the account servicing financial institution containing
     * items pending to be booked.
     */
    public const LISTING_STATEMENT_OF_AN_ACCOUNT = '55';

    /**
     * Loadline document (795)
     *
     * Document specifying the limit of a ship's legal submersion under various
     * conditions.
     */
    public const LOADLINE_DOCUMENT = '795';

    /**
     * Loss statement (819)
     *
     * Document specifying the value of a loss.
     */
    public const LOSS_STATEMENT = '819';

    /**
     * Low risk country formal letter (652)
     *
     * An official letter issued by an import authority granted to the importer of
     * goods from a low risk country which allows the importer to place its
     * products in the local market with certain favorable considerations.
     */
    public const LOW_RISK_COUNTRY_FORMAL_LETTER = '652';

    /**
     * Low value payment order(s) (249)
     *
     * The message contains low value payment order(s) only.
     */
    public const LOW_VALUE_PAYMENT_ORDERS = '249';

    /**
     * Make or buy plan (156)
     *
     * A document indicating a plan that identifies which items will be made and
     * which items will be bought.
     */
    public const MAKE_OR_BUY_PLAN = '156';

    /**
     * Manufacturer raised consignment order (726)
     *
     * Document/message providing details of a consignment order which has been
     * raised by a manufacturer.
     */
    public const MANUFACTURER_RAISED_CONSIGNMENT_ORDER = '726';

    /**
     * Manufacturer raised order (725)
     *
     * Document/message providing details of an order which has been raised by a
     * manufacturer.
     */
    public const MANUFACTURER_RAISED_ORDER = '725';

    /**
     * Manufacturing instructions (110)
     *
     * Document/message issued within an enterprise to initiate the manufacture of
     * goods to be offered for sale.
     */
    public const MANUFACTURING_INSTRUCTIONS = '110';

    /**
     * Manufacturing license (651)
     *
     * A license granted by a competent authority to a manufacturer for production
     * of specific products.
     */
    public const MANUFACTURING_LICENSE = '651';

    /**
     * Manufacturing specification (167)
     *
     * A document indicating the specification of how an item is to be
     * manufactured.
     */
    public const MANUFACTURING_SPECIFICATION = '167';

    /**
     * Maritime declaration of health (797)
     *
     * Document certifying the health condition on board a vessel, valid to a
     * specified date.
     */
    public const MARITIME_DECLARATION_OF_HEALTH = '797';

    /**
     * Master air waybill (741)
     *
     * Document/message made out by or on behalf of the agent/consolidator which
     * evidences the contract between the agent/consolidator and carrier(s) for
     * carriage of goods over routes of the carrier(s) for a consignment
     * consisting of goods originated by more than one shipper (IATA).
     */
    public const MASTER_AIR_WAYBILL = '741';

    /**
     * Master bill of lading (704)
     *
     * A bill of lading issued by the master of a vessel (in actuality the owner
     * or charterer of the vessel). It could cover a number of house bills.
     */
    public const MASTER_BILL_OF_LADING = '704';

    /**
     * Mate's receipt (713)
     *
     * Document/message issued by a ship's officer to acknowledge that a specified
     * consignment has been received on board a vessel, and the apparent condition
     * of the goods; enabling the carrier to issue a Bill of lading.
     */
    public const MATES_RECEIPT = '713';

    /**
     * Material inspection and receiving report (163)
     *
     * A report that is both an inspection report for materials and a receiving
     * document.
     */
    public const MATERIAL_INSPECTION_AND_RECEIVING_REPORT = '163';

    /**
     * Means of transport advice (97)
     *
     * Message reporting the means of transport used to carry goods or cargo.
     */
    public const MEANS_OF_TRANSPORT_ADVICE = '97';

    /**
     * Means of transportation availability information (403)
     *
     * Information giving the various availabilities of a means of transportation.
     */
    public const MEANS_OF_TRANSPORTATION_AVAILABILITY_INFORMATION = '403';

    /**
     * Means of transportation schedule information (404)
     *
     * Information giving the various schedules of a means of transportation.
     */
    public const MEANS_OF_TRANSPORTATION_SCHEDULE_INFORMATION = '404';

    /**
     * Meat and meat by-products sanitary certificate (89)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that meat or meat by-products comply with the
     * requirements set by the importing country.
     */
    public const MEAT_AND_MEAT_BYPRODUCTS_SANITARY_CERTIFICATE = '89';

    /**
     * Meat food products sanitary certificate (90)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that meat food products comply with the requirements set
     * by the importing country.
     */
    public const MEAT_FOOD_PRODUCTS_SANITARY_CERTIFICATE = '90';

    /**
     * Medical certificate (842)
     *
     * Document certifying a medical condition.
     */
    public const MEDICAL_CERTIFICATE = '842';

    /**
     * Message in development request (281)
     *
     * Requesting a Message in Development (MiD).
     */
    public const MESSAGE_IN_DEVELOPMENT_REQUEST = '281';

    /**
     * Metered services consumption report (742)
     *
     * Document/message providing metered consumption details.
     */
    public const METERED_SERVICES_CONSUMPTION_REPORT = '742';

    /**
     * Metered services consumption report supporting an invoice (739)
     *
     * Document/message providing metered consumption details supporiting an
     * invoice.
     */
    public const METERED_SERVICES_CONSUMPTION_REPORT_SUPPORTING_AN_INVOICE = '739';

    /**
     * Metered services invoice (82)
     *
     * Document/message claiming payment for the supply of metered services (e.g.,
     * gas, electricity, etc.) supplied to a fixed meter whose consumption is
     * measured over a period of time.
     */
    public const METERED_SERVICES_INVOICE = '82';

    /**
     * Metering point information response (391)
     *
     * Response to a request for information about a metering point.
     */
    public const METERING_POINT_INFORMATION_RESPONSE = '391';

    /**
     * Military Identification Card (528)
     *
     * The official document used for military personnel on travel orders,
     * substituting a passport.
     */
    public const MILITARY_IDENTIFICATION_CARD = '528';

    /**
     * Mill certificate (12)
     *
     * Certificate certifying a specific quality of agricultural products.
     */
    public const MILL_CERTIFICATE = '12';

    /**
     * Modification of existing message (282)
     *
     * Requesting a change to an existing message.
     */
    public const MODIFICATION_OF_EXISTING_MESSAGE = '282';

    /**
     * Movement certificate A.TR.1 (18)
     *
     * Specific form of transit declaration issued by the exporter (movement
     * certificate).
     */
    public const MOVEMENT_CERTIFICATE_ATR = '18';

    /**
     * Multidrop order (147)
     *
     * One purchase order that contains the orders of two or more vendors and the
     * associated delivery points for each.
     */
    public const MULTIDROP_ORDER = '147';

    /**
     * Multimodal transport document (generic) (765)
     *
     * Document/message which evidences a multimodal transport contract, the
     * taking in charge of the goods by the multimodal transport operator, and an
     * undertaking by him to deliver the goods in accordance with the terms of the
     * contract. (International Convention on Multimodal Transport of Goods).
     */
    public const MULTIMODAL_TRANSPORT_DOCUMENT_GENERIC = '765';

    /**
     * Multimodal/combined transport document (generic) (760)
     *
     * A transport document used when more than one mode of transportation is
     * involved in the movement of cargo. It is a contract of carriage and receipt
     * of the cargo for a multimodal transport. It indicates the place where the
     * responsible transport company in the move takes responsibility for the
     * cargo, the place where the responsibility of this transport company in the
     * move ends and the conveyances involved.
     */
    public const MULTIMODALCOMBINED_TRANSPORT_DOCUMENT_GENERIC = '760';

    /**
     * Multiple direct debit (486)
     *
     * Document/message containing a direct debit to credit one or more accounts
     * and to debit one or more debtors.
     */
    public const MULTIPLE_DIRECT_DEBIT = '486';

    /**
     * Multiple direct debit request (484)
     *
     * Document/message containing a direct debit request to credit one or more
     * accounts and to debit one or more debtors.
     */
    public const MULTIPLE_DIRECT_DEBIT_REQUEST = '484';

    /**
     * Multiple payment order (452)
     *
     * Document/message containing a payment order to debit one or more accounts
     * and to credit one or more beneficiaries.
     */
    public const MULTIPLE_PAYMENT_ORDER = '452';

    /**
     * Name/product plate (328)
     *
     * Plates on goods identifying and describing an article.
     */
    public const NAMEPRODUCT_PLATE = '328';

    /**
     * NATO transit document (977)
     *
     * Customs transit document for the carriage of shipments of the NATO armed
     * forces under Customs supervision.
     */
    public const NATO_TRANSIT_DOCUMENT = '977';

    /**
     * New code request (272)
     *
     * Requesting a new code.
     */
    public const NEW_CODE_REQUEST = '272';

    /**
     * New message request (280)
     *
     * Request for a new message (NMR).
     */
    public const NEW_MESSAGE_REQUEST = '280';

    /**
     * Non-negotiable maritime transport document (generic) (712)
     *
     * Non-negotiable document which evidences a contract for the carriage of
     * goods by sea and the taking over or loading of the goods by the carrier,
     * and by which the carrier undertakes to deliver the goods to the consignee
     * named in the document. E.g. Sea waybill. Remark: Synonymous with "straight"
     * or "non-negotiable Bill of lading" used in certain countries, e.g. Canada.
     */
    public const NONNEGOTIABLE_MARITIME_TRANSPORT_DOCUMENT_GENERIC = '712';

    /**
     * Non-pre-authorised direct debit request(s) (244)
     *
     * The message contains non-pre-authorised direct debit request(s).
     */
    public const NONPREAUTHORISED_DIRECT_DEBIT_REQUESTS = '244';

    /**
     * Non-pre-authorised direct debit(s) (238)
     *
     * The message contains non-pre-authorised direct debit(s).
     */
    public const NONPREAUTHORISED_DIRECT_DEBITS = '238';

    /**
     * Notice of circumstances preventing delivery (goods) (782)
     *
     * Request made by the carrier to the sender, or, as the case may be, the
     * consignee, for instructions as to the disposal of the consignment when
     * circumstances prevent delivery and the return of the goods has not been
     * requested by the consignor in the transport document.
     */
    public const NOTICE_OF_CIRCUMSTANCES_PREVENTING_DELIVERY_GOODS = '782';

    /**
     * Notice of circumstances preventing transport (goods) (783)
     *
     * Request made by the carrier to the sender, or, the consignee as the case
     * may be, for instructions as to the disposal of the goods when circumstances
     * prevent transport before departure or en route, after acceptance of the
     * consignment concerned.
     */
    public const NOTICE_OF_CIRCUMSTANCES_PREVENTING_TRANSPORT_GOODS = '783';

    /**
     * Notice that circumstances prevent payment of delivered goods (453)
     *
     * Message used to inform a supplier that delivered goods cannot be paid due
     * to circumstances which prevent payment.
     */
    public const NOTICE_THAT_CIRCUMSTANCES_PREVENT_PAYMENT_OF_DELIVERED_GOODS = '453';

    /**
     * Notification of balance responsible entity change (434)
     *
     * Notification of a change of balance responsible entity.
     */
    public const NOTIFICATION_OF_BALANCE_RESPONSIBLE_ENTITY_CHANGE = '434';

    /**
     * Notification of change of supplier (392)
     *
     * A notification of a change of supplier.
     */
    public const NOTIFICATION_OF_CHANGE_OF_SUPPLIER = '392';

    /**
     * Notification of emergency shifting from the designated place in port (354)
     *
     * Document to notify shifting from designated place in port once secured at
     * the designated place.
     */
    public const NOTIFICATION_OF_EMERGENCY_SHIFTING_FROM_THE_DESIGNATED_PLACE_IN_PORT = '354';

    /**
     * Notification of meter change (408)
     *
     * Notification about the change of a meter.
     */
    public const NOTIFICATION_OF_METER_CHANGE = '408';

    /**
     * Notification of metering point identification change (410)
     *
     * Notification of the change of metering point identification.
     */
    public const NOTIFICATION_OF_METERING_POINT_IDENTIFICATION_CHANGE = '410';

    /**
     * Notification of usage of berth or mooring facilities (352)
     *
     * Document to notify usage of berth or mooring facilities.
     */
    public const NOTIFICATION_OF_USAGE_OF_BERTH_OR_MOORING_FACILITIES = '352';

    /**
     * Notification to grid operator of contract termination (432)
     *
     * Notification to the grid operator regarding the termination of a contract.
     */
    public const NOTIFICATION_TO_GRID_OPERATOR_OF_CONTRACT_TERMINATION = '432';

    /**
     * Notification to grid operator of metering point changes (433)
     *
     * Notification to the grid operator about changes regarding a metering point.
     */
    public const NOTIFICATION_TO_GRID_OPERATOR_OF_METERING_POINT_CHANGES = '433';

    /**
     * Notification to supplier of contract termination (406)
     *
     * Notification to the supplier regarding the termination of a contract.
     */
    public const NOTIFICATION_TO_SUPPLIER_OF_CONTRACT_TERMINATION = '406';

    /**
     * Notification to supplier of metering point changes (407)
     *
     * Notification to the supplier about changes regarding a metering point.
     */
    public const NOTIFICATION_TO_SUPPLIER_OF_METERING_POINT_CHANGES = '407';

    /**
     * Offer / quotation (310)
     *
     * (1332) Document/message which, with a view to concluding a contract, sets
     * out the conditions under which the goods are offered.
     */
    public const OFFER_QUOTATION = '310';

    /**
     * Operating instructions (327)
     *
     * Document/message describing instructions for operation.
     */
    public const OPERATING_INSTRUCTIONS = '327';

    /**
     * Optical Character Reading (OCR) payment (322)
     *
     * Payment effected by an Optical Character Reading (OCR) document.
     */
    public const OPTICAL_CHARACTER_READING_OCR_PAYMENT = '322';

    /**
     * Optical Character Reading (OCR) payment credit note (420)
     *
     * Payment credit note effected by an Optical Character Reading (OCR)
     * document.
     */
    public const OPTICAL_CHARACTER_READING_OCR_PAYMENT_CREDIT_NOTE = '420';

    /**
     * Order (220)
     *
     * Document/message by means of which a buyer initiates a transaction with a
     * seller involving the supply of goods or services as specified, according to
     * conditions set out in an offer, or otherwise known to the buyer.
     */
    public const ORDER = '220';

    /**
     * Order status enquiry (347)
     *
     * A message enquiring the status of previously sent orders.
     */
    public const ORDER_STATUS_ENQUIRY = '347';

    /**
     * Order status report (348)
     *
     * A message reporting the status of previously sent orders.
     */
    public const ORDER_STATUS_REPORT = '348';

    /**
     * Original accounting voucher (533)
     *
     * To indicate that the document/message justifying an accounting entry is
     * original.
     */
    public const ORIGINAL_ACCOUNTING_VOUCHER = '533';

    /**
     * Out of court settlement (847)
     *
     * Document which specifies an out of court settlement.
     */
    public const OUT_OF_COURT_SETTLEMENT = '847';

    /**
     * Package response (Customs) (964)
     *
     * Package response message to permit the transfer of data from Customs to the
     * transmitter of the previous message.
     */
    public const PACKAGE_RESPONSE_CUSTOMS = '964';

    /**
     * Packaging material composition report (644)
     *
     * A document that shows the main structure that composes the packaging
     * material.
     */
    public const PACKAGING_MATERIAL_COMPOSITION_REPORT = '644';

    /**
     * Packing instructions (140)
     *
     * Document/message within an enterprise giving instructions on how goods are
     * to be packed.
     */
    public const PACKING_INSTRUCTIONS = '140';

    /**
     * Packing list (271)
     *
     * Document/message specifying the distribution of goods in individual
     * packages (in trade environment the despatch advice message is used for the
     * packing list).
     */
    public const PACKING_LIST = '271';

    /**
     * Partial construction invoice (875)
     *
     * Partial invoice in the context of a specific construction project.
     */
    public const PARTIAL_CONSTRUCTION_INVOICE = '875';

    /**
     * Partial final construction invoice (876)
     *
     * Invoice concluding all previous partial construction invoices of a
     * completed partial rendered service in the context of a specific
     * construction project.
     */
    public const PARTIAL_FINAL_CONSTRUCTION_INVOICE = '876';

    /**
     * Partial invoice (326)
     *
     * Document/message specifying details of an incomplete invoice.
     */
    public const PARTIAL_INVOICE = '326';

    /**
     * Party credit information (377)
     *
     * Document/message providing data concerning the credit information of a
     * party.
     */
    public const PARTY_CREDIT_INFORMATION = '377';

    /**
     * Party information (10)
     *
     * Document/message providing basic data concerning a party.
     */
    public const PARTY_INFORMATION = '10';

    /**
     * Party payment behaviour information (378)
     *
     * Document/message providing data concerning the payment behaviour of a
     * party.
     */
    public const PARTY_PAYMENT_BEHAVIOUR_INFORMATION = '378';

    /**
     * Passenger list (745)
     *
     * Declaration to Customs regarding passengers aboard the conveyance;
     * equivalent to IMO FAL 6.
     */
    public const PASSENGER_LIST = '745';

    /**
     * Passport (39)
     *
     * An official document giving permission to travel in foreign countries.
     */
    public const PASSPORT = '39';

    /**
     * Payment bond (357)
     *
     * A document that guarantees the payment of monies.
     */
    public const PAYMENT_BOND = '357';

    /**
     * Payment card (461)
     *
     * The document is a credit, guarantee or charge card.
     */
    public const PAYMENT_CARD = '461';

    /**
     * Payment or performance bond (165)
     *
     * A document indicating a bond that guarantees the payment of monies or a
     * performance.
     */
    public const PAYMENT_OR_PERFORMANCE_BOND = '165';

    /**
     * Payment order (450)
     *
     * Document/message containing information needed to initiate the payment. It
     * may cover the financial settlement for one or more commercial trade
     * transactions. A payment order is an instruction to the ordered bank to
     * arrange for the payment of one specified amount to the beneficiary.
     */
    public const PAYMENT_ORDER = '450';

    /**
     * Payment receipt confirmation (834)
     *
     * Document confirming the receipt of a payment.
     */
    public const PAYMENT_RECEIPT_CONFIRMATION = '834';

    /**
     * Payment request for completed units (219)
     *
     * A request for payment for completed units.
     */
    public const PAYMENT_REQUEST_FOR_COMPLETED_UNITS = '219';

    /**
     * Payment valuation (204)
     *
     * Document/message establishing the financial elements of a situation of
     * works.
     */
    public const PAYMENT_VALUATION = '204';

    /**
     * Payment valuation for unscheduled items (217)
     *
     * A payment valuation for unscheduled items.
     */
    public const PAYMENT_VALUATION_FOR_UNSCHEDULED_ITEMS = '217';

    /**
     * Payroll deductions advice (747)
     *
     * A message sent by a party (usually an employer or its representative) to a
     * service providing organisation, to detail payroll deductions paid on behalf
     * of its employees to the service providing organisation.
     */
    public const PAYROLL_DEDUCTIONS_ADVICE = '747';

    /**
     * Performance bond (356)
     *
     * A document that guarantees performance.
     */
    public const PERFORMANCE_BOND = '356';

    /**
     * Pharmaceutical sanitary certificate (94)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that pharmaceutical products comply with the
     * requirements set by the importing country.
     */
    public const PHARMACEUTICAL_SANITARY_CERTIFICATE = '94';

    /**
     * Physician report (839)
     *
     * Report issued by a medical doctor.
     */
    public const PHYSICIAN_REPORT = '839';

    /**
     * Phytosanitary certificate (851)
     *
     * A message/doucment consistent with the model for certificates of the IPPC,
     * attesting that a consignment meets phytosanitary import requirements.
     */
    public const PHYTOSANITARY_CERTIFICATE = '851';

    /**
     * Phytosanitary Re-export Certificate (657)
     *
     * A message/document consistent with the model for re-export phytosanitary
     * certificates of the IPPC, attesting that a consignment meets phytosanitary
     * import requirements.
     */
    public const PHYTOSANITARY_REEXPORT_CERTIFICATE = '657';

    /**
     * Pick-up notice (171)
     *
     * Notice specifying the pick-up of released cargo or containers from a
     * certain address.
     */
    public const PICKUP_NOTICE = '171';

    /**
     * Plan for provision of health service (371)
     *
     * Document containing a plan for provision of health service.
     */
    public const PLAN_FOR_PROVISION_OF_HEALTH_SERVICE = '371';

    /**
     * Plant Passport (752)
     *
     * Document/message issued by a competent body certifying the phytosanitary
     * status of plants or plant products for international trade.
     */
    public const PLANT_PASSPORT = '752';

    /**
     * Port authority waste disposal report (482)
     *
     * Document/message sent by a port authority to another port authority for
     * reporting information on waste disposal.
     */
    public const PORT_AUTHORITY_WASTE_DISPOSAL_REPORT = '482';

    /**
     * Port charges documents (633)
     *
     * Documents/messages specifying services rendered, storage and handling
     * costs, demurrage and other charges due to the owner of goods described
     * therein.
     */
    public const PORT_CHARGES_DOCUMENTS = '633';

    /**
     * Post receipt (13)
     *
     * Document/message which evidences the transport of goods by post (e.g. mail,
     * parcel, etc.).
     */
    public const POST_RECEIPT = '13';

    /**
     * Poultry sanitary certificate (91)
     *
     * Document or message issued by the competent authority in the exporting
     * country evidencing that poultry products comply with the requirements set
     * by the importing country.
     */
    public const POULTRY_SANITARY_CERTIFICATE = '91';

    /**
     * Pre-authorised direct debit request(s) (243)
     *
     * The message contains pre-authorised direct debit request(s).
     */
    public const PREAUTHORISED_DIRECT_DEBIT_REQUESTS = '243';

    /**
     * Pre-authorised direct debit(s) (214)
     *
     * The message contains pre-authorised direct debit(s).
     */
    public const PREAUTHORISED_DIRECT_DEBITS = '214';

    /**
     * Pre-packed cross docking consignment order (898)
     *
     * A consignment order requesting the supply of products packed according to
     * the final delivery point which will be moved across a dock in a
     * distribution centre without further handling.
     */
    public const PREPACKED_CROSS_DOCKING_CONSIGNMENT_ORDER = '898';

    /**
     * Pre-packed cross docking despatch advice (463)
     *
     * Document by means of which the supplier or consignor informs the buyer,
     * consignee or distribution centre about the despatch of products packed
     * according to the final delivery point requirements which will be moved
     * across a dock in a distribution centre without further handling.
     */
    public const PREPACKED_CROSS_DOCKING_DESPATCH_ADVICE = '463';

    /**
     * Pre-packed cross docking order (401)
     *
     * An order requesting the supply of products packed according to the final
     * delivery point which will be moved across a dock in a distribution centre
     * without further handling.
     */
    public const PREPACKED_CROSS_DOCKING_ORDER = '401';

    /**
     * Preadvice of a credit (435)
     *
     * Preadvice indicating a credit to happen in the future.
     */
    public const PREADVICE_OF_A_CREDIT = '435';

    /**
     * Preference certificate of origin (864)
     *
     * Document/message describing a certificate of origin meeting the
     * requirements for preferential treatment.
     */
    public const PREFERENCE_CERTIFICATE_OF_ORIGIN = '864';

    /**
     * Preliminary credit assessment (64)
     *
     * Document/message issued either by a factor to indicate his preliminary
     * credit assessment on a buyer, or by a seller to request a factor's
     * preliminary credit assessment on a buyer.
     */
    public const PRELIMINARY_CREDIT_ASSESSMENT = '64';

    /**
     * Preliminary sales report (323)
     *
     * Preliminary sales report sent before all the information is available.
     */
    public const PRELIMINARY_SALES_REPORT = '323';

    /**
     * Prepayment invoice (386)
     *
     * An invoice to pay amounts for goods and services in advance; these amounts
     * will be subtracted from the final invoice.
     */
    public const PREPAYMENT_INVOICE = '386';

    /**
     * Prescription (372)
     *
     * Instructions for the dispensing and use of medicine or remedy.
     */
    public const PRESCRIPTION = '372';

    /**
     * Prescription dispensing report (374)
     *
     * Document containing information of products dispensed according to a
     * prescription.
     */
    public const PRESCRIPTION_DISPENSING_REPORT = '374';

    /**
     * Prescription request (373)
     *
     * Request to issue a prescription for medicine or remedy.
     */
    public const PRESCRIPTION_REQUEST = '373';

    /**
     * Previous correspondence (653)
     *
     * Correspondence previously exchanged.
     */
    public const PREVIOUS_CORRESPONDENCE = '653';

    /**
     * Previous Customs document/message (998)
     *
     * Indication of the previous Customs document/message concerning the same
     * transaction.
     */
    public const PREVIOUS_CUSTOMS_DOCUMENTMESSAGE = '998';

    /**
     * Previous transport document (499)
     *
     * Identification of the previous transport document.
     */
    public const PREVIOUS_TRANSPORT_DOCUMENT = '499';

    /**
     * Price and delivery quote (363)
     *
     * Document/message confirming price and delivery conditions under which goods
     * are offered.
     */
    public const PRICE_AND_DELIVERY_QUOTE = '363';

    /**
     * Price and delivery quote, ship and debit (369)
     *
     * Document/message from a supplier to a distributor confirming price
     * conditions and delivery conditions under which goods can be sold by a
     * distributor to the end-customer specified on the quote with compensation
     * for loss of inventory value.
     */
    public const PRICE_AND_DELIVERY_QUOTE_SHIP_AND_DEBIT = '369';

    /**
     * Price and delivery quote, specified end-customer (367)
     *
     * Document/message confirming price conditions and delivery conditions under
     * which goods are offered, provided that they are sold to the end-customer
     * specified on the quote.
     */
    public const PRICE_AND_DELIVERY_QUOTE_SPECIFIED_ENDCUSTOMER = '367';

    /**
     * Price negotiation result (52)
     *
     * A document providing the result of price negotiations.
     */
    public const PRICE_NEGOTIATION_RESULT = '52';

    /**
     * Price quote (361)
     *
     * Document/message confirming price conditions under which goods are offered.
     */
    public const PRICE_QUOTE = '361';

    /**
     * Price quote, ship and debit (368)
     *
     * Document/message from a supplier to a distributor confirming price
     * conditions under which goods can be sold by a distributor to the
     * end-customer specified on the quote with compensation for loss of inventory
     * value.
     */
    public const PRICE_QUOTE_SHIP_AND_DEBIT = '368';

    /**
     * Price quote, specified end-customer (366)
     *
     * Document/message confirming price conditions under which goods are offered,
     * provided that they are sold to the end-customer specified on the quote.
     */
    public const PRICE_QUOTE_SPECIFIED_ENDCUSTOMER = '366';

    /**
     * Price variation invoice (295)
     *
     * An invoice which requests payment for the difference in price between an
     * original invoice and the result of the application of a price variation
     * formula.
     */
    public const PRICE_VARIATION_INVOICE = '295';

    /**
     * Price/sales catalogue (9)
     *
     * A document/message to enable the transmission of information regarding
     * pricing and catalogue details for goods and services offered by a seller to
     * a buyer.
     */
    public const PRICESALES_CATALOGUE = '9';

    /**
     * Price/sales catalogue containing commercial information (728)
     *
     * A price/sales catalogue message containing only commercial terms or
     * conditions data.
     */
    public const PRICESALES_CATALOGUE_CONTAINING_COMMERCIAL_INFORMATION = '728';

    /**
     * Price/sales catalogue not containing commercial information (727)
     *
     * A price/sales catalogue message containing no commercial information, such
     * as prices, terms or conditions.
     */
    public const PRICESALES_CATALOGUE_NOT_CONTAINING_COMMERCIAL_INFORMATION = '727';

    /**
     * Price/sales catalogue response (51)
     *
     * A document providing a response to a previously sent price/sales catalogue.
     */
    public const PRICESALES_CATALOGUE_RESPONSE = '51';

    /**
     * Priced alternate tender bill of quantity (192)
     *
     * A priced tender based upon an alternate specification.
     */
    public const PRICED_ALTERNATE_TENDER_BILL_OF_QUANTITY = '192';

    /**
     * Priced tender BOQ (209)
     *
     * Document/message providing a detailed, quantity based specification,
     * updated with prices to form a tender submission for a construction
     * contract. BOQ means: Bill of quantity.
     */
    public const PRICED_TENDER_BOQ = '209';

    /**
     * Pro-forma accounting voucher (535)
     *
     * To indicate that the document/message justifying an accounting entry is
     * pro-forma.
     */
    public const PROFORMA_ACCOUNTING_VOUCHER = '535';

    /**
     * Process data report (7)
     *
     * Reports on events during production process.
     */
    public const PROCESS_DATA_REPORT = '7';

    /**
     * Product data message (289)
     *
     * A message to submit master data, a set of data that is rarely changed, to
     * identify and describe products a supplier offers to their (potential)
     * customer or buyer.
     */
    public const PRODUCT_DATA_MESSAGE = '289';

    /**
     * Product data response (721)
     *
     * Document/message responding to a previously received Product Data
     * document/message.
     */
    public const PRODUCT_DATA_RESPONSE = '721';

    /**
     * Product performance report (5)
     *
     * Report specifying the performance values of products.
     */
    public const PRODUCT_PERFORMANCE_REPORT = '5';

    /**
     * Product specification report (6)
     *
     * Report providing specification values of products.
     */
    public const PRODUCT_SPECIFICATION_REPORT = '6';

    /**
     * Production facility license (649)
     *
     * A license granted by a competent authority to a production facility for
     * manufacturing specific products.
     */
    public const PRODUCTION_FACILITY_LICENSE = '649';

    /**
     * Proforma invoice (325)
     *
     * Document/message serving as a preliminary invoice, containing - on the
     * whole - the same information as the final invoice, but not actually
     * claiming payment.
     */
    public const PROFORMA_INVOICE = '325';

    /**
     * Progressive discharge report (181)
     *
     * Document or message progressively issued by the container terminal operator
     * in charge of discharging a vessel identifying containers that have been
     * discharged from a specific vessel at that point in time.
     */
    public const PROGRESSIVE_DISCHARGE_REPORT = '181';

    /**
     * Project master plan (253)
     *
     * A high level, all encompassing master plan to complete a project.
     */
    public const PROJECT_MASTER_PLAN = '253';

    /**
     * Project master schedule (191)
     *
     * A high level, all encompassing master schedule of activities to complete a
     * project.
     */
    public const PROJECT_MASTER_SCHEDULE = '191';

    /**
     * Project plan (254)
     *
     * A plan for project work to be completed.
     */
    public const PROJECT_PLAN = '254';

    /**
     * Project planning available resources (256)
     *
     * Available resources for project planning purposes.
     */
    public const PROJECT_PLANNING_AVAILABLE_RESOURCES = '256';

    /**
     * Project planning calendar (257)
     *
     * Work calendar information for project planning purposes.
     */
    public const PROJECT_PLANNING_CALENDAR = '257';

    /**
     * Project production plan (189)
     *
     * A project plan for the production of goods.
     */
    public const PROJECT_PRODUCTION_PLAN = '189';

    /**
     * Project recovery plan (188)
     *
     * A project plan for recovery after a delay or problem resolution.
     */
    public const PROJECT_RECOVERY_PLAN = '188';

    /**
     * Project schedule (255)
     *
     * A schedule of project activities to be completed.
     */
    public const PROJECT_SCHEDULE = '255';

    /**
     * Promissory note (491)
     *
     * Document/message, issued and signed in conformity with the applicable
     * legislation, which contains an unconditional promise whereby the maker
     * undertakes to pay a definite sum of money to the payee or to his order, on
     * demand or at a definite time, against the surrender of the document itself.
     */
    public const PROMISSORY_NOTE = '491';

    /**
     * Proof of delivery (737)
     *
     * A message by which a consignee provides for a carrier proof of delivery of
     * a consignment.
     */
    public const PROOF_OF_DELIVERY = '737';

    /**
     * Proof of transit declaration (975)
     *
     * A document providing proof that a transit declaration has been accepted.
     */
    public const PROOF_OF_TRANSIT_DECLARATION = '975';

    /**
     * Provisional payment valuation (203)
     *
     * Document/message establishing a provisional payment valuation.
     */
    public const PROVISIONAL_PAYMENT_VALUATION = '203';

    /**
     * Public price certificate (646)
     *
     * A certification executed by the competent authority from country of
     * production stating the price of the goods to the general public.
     */
    public const PUBLIC_PRICE_CERTIFICATE = '646';

    /**
     * Purchase order (105)
     *
     * Document/message issued within an enterprise to initiate the purchase of
     * articles, materials or services required for the production or manufacture
     * of goods to be offered for sale or otherwise supplied to customers.
     */
    public const PURCHASE_ORDER = '105';

    /**
     * Purchase order change request (230)
     *
     * Change to an purchase order already sent.
     */
    public const PURCHASE_ORDER_CHANGE_REQUEST = '230';

    /**
     * Purchase Order Financing Request (892)
     *
     * Document enabling the Financing Requestor to initiate the financing process
     * by the First Agent.
     */
    public const PURCHASE_ORDER_FINANCING_REQUEST = '892';

    /**
     * Purchase Order Financing Request Cancellation (894)
     *
     * Document enabling the Financing Requestor to request the First Agent to
     * cancel a previously sent purchase order financing request.
     */
    public const PURCHASE_ORDER_FINANCING_REQUEST_CANCELLATION = '894';

    /**
     * Purchase Order Financing Request Status (893)
     *
     * Document enabling the First Agent to notify the Financing Requestor of the
     * status of a purchase order financing request or the status of a purchase
     * order financing cancellation request previously sent by the Financial
     * Requestor itself.
     */
    public const PURCHASE_ORDER_FINANCING_REQUEST_STATUS = '893';

    /**
     * Purchase order response (231)
     *
     * Response to an purchase order already received.
     */
    public const PURCHASE_ORDER_RESPONSE = '231';

    /**
     * Purchasing specification (164)
     *
     * A document indicating a specification used to purchase an item.
     */
    public const PURCHASING_SPECIFICATION = '164';

    /**
     * Quality data message (20)
     *
     * Usage of QALITY-message.
     */
    public const QUALITY_DATA_MESSAGE = '20';

    /**
     * Quantity valuation (205)
     *
     * Document/message providing a confirmed assessment, by quantity, of the
     * completed work for a construction contract.
     */
    public const QUANTITY_VALUATION = '205';

    /**
     * Quantity valuation request (206)
     *
     * Document/message providing an initial assessment, by quantity, of the
     * completed work for a construction contract.
     */
    public const QUANTITY_VALUATION_REQUEST = '206';

    /**
     * Query (21)
     *
     * Request information based on defined criteria.
     */
    public const QUERY = '21';

    /**
     * Questionnaire (779)
     *
     * Document consisting of a series of questions.
     */
    public const QUESTIONNAIRE = '779';

    /**
     * Quota prior allocation certificate (966)
     *
     * Document/message issued by the competent body for prior allocation of a
     * quota.
     */
    public const QUOTA_PRIOR_ALLOCATION_CERTIFICATE = '966';

    /**
     * Rail consignment note (generic term) (720)
     *
     * Transport document constituting a contract for the carriage of goods
     * between the sender and the carrier (the railway). For international rail
     * traffic, this document must conform to the model prescribed by the
     * international conventions concerning carriage of goods by rail, e.g. CIM
     * Convention, SMGS Convention.
     */
    public const RAIL_CONSIGNMENT_NOTE_GENERIC_TERM = '720';

    /**
     * Rail consignment note forwarder copy (972)
     *
     * Document which is a copy of the rail consignment note printed especially
     * for the need of the forwarder.
     */
    public const RAIL_CONSIGNMENT_NOTE_FORWARDER_COPY = '972';

    /**
     * Re-Entry Permit (529)
     *
     * A permit to re-enter a country.
     */
    public const REENTRY_PERMIT = '529';

    /**
     * Re-sending consignment note (824)
     *
     * Rail consignment note prepared by the consignor for the facilitation of an
     * eventual return to the origin of the goods.
     */
    public const RESENDING_CONSIGNMENT_NOTE = '824';

    /**
     * Ready for despatch advice (345)
     *
     * Document/message issued by a supplier informing a buyer that goods ordered
     * are ready for despatch.
     */
    public const READY_FOR_DESPATCH_ADVICE = '345';

    /**
     * Ready for transshipment despatch advice (462)
     *
     * Document to advise that the goods ordered are ready for transshipment.
     */
    public const READY_FOR_TRANSSHIPMENT_DESPATCH_ADVICE = '462';

    /**
     * Reassignment (69)
     *
     * Document/message issued by a factor to a seller or to another factor to
     * reassign an invoice or credit note previously assigned to him.
     */
    public const REASSIGNMENT = '69';

    /**
     * Receipt (Customs) (917)
     *
     * Receipt for Customs duty/tax/fee paid.
     */
    public const RECEIPT_CUSTOMS = '917';

    /**
     * Recharging document (724)
     *
     * Fictitious transport document regarding a previous transport, enabling a
     * carrier's agent to give to another carrier's agent (in a different country)
     * the possibility to collect charges relating to the original transport (rail
     * environment).
     */
    public const RECHARGING_DOCUMENT = '724';

    /**
     * Reefer connection order (489)
     *
     * Order to connect a reefer container to a reefer point.
     */
    public const REEFER_CONNECTION_ORDER = '489';

    /**
     * Refugee Permit (531)
     *
     * Document identifying a refugee recognized by a country.
     */
    public const REFUGEE_PERMIT = '531';

    /**
     * Refusal of claim (828)
     *
     * Document stating the refusal of a claim.
     */
    public const REFUSAL_OF_CLAIM = '828';

    /**
     * Regional appellation certificate (863)
     *
     * Certificate drawn up in accordance with the rules laid down by an authority
     * or approved body, certifying that the goods described therein qualify for a
     * designation specific to the given region (e.g. champagne, port wine,
     * Parmesan cheese).
     */
    public const REGIONAL_APPELLATION_CERTIFICATE = '863';

    /**
     * Registration change (300)
     *
     * Code specifying the modification of previously submitted registration
     * information.
     */
    public const REGISTRATION_CHANGE = '300';

    /**
     * Registration document (101)
     *
     * An official document providing registration details.
     */
    public const REGISTRATION_DOCUMENT = '101';

    /**
     * Registration renewal (299)
     *
     * Code specifying the continued validity of previously submitted registration
     * information.
     */
    public const REGISTRATION_RENEWAL = '299';

    /**
     * Rejected direct debit(s) (239)
     *
     * The message contains rejected direct debit(s).
     */
    public const REJECTED_DIRECT_DEBITS = '239';

    /**
     * Related document (916)
     *
     * Document that has a relationship with the stated document/message.
     */
    public const RELATED_DOCUMENT = '916';

    /**
     * Remittance advice (481)
     *
     * Document/message advising of the remittance of payment.
     */
    public const REMITTANCE_ADVICE = '481';

    /**
     * Repair order (225)
     *
     * Document/message to order repair of goods.
     */
    public const REPAIR_ORDER = '225';

    /**
     * Report of transactions for information only (342)
     *
     * A message reporting transactions for information only.
     */
    public const REPORT_OF_TRANSACTIONS_FOR_INFORMATION_ONLY = '342';

    /**
     * Report of transactions which need further information from the receiver (339)
     *
     * A message reporting transactions which need further information from the
     * receiver.
     */
    public const REPORT_OF_TRANSACTIONS_WHICH_NEED_FURTHER_INFORMATION_FROM_THE_RECEIVER = '339';

    /**
     * Request for an amendment of a documentary credit (196)
     *
     * Request for an amendment of a documentary credit.
     */
    public const REQUEST_FOR_AN_AMENDMENT_OF_A_DOCUMENTARY_CREDIT = '196';

    /**
     * Request for contract price and delivery quote (445)
     *
     * Document/message requesting contractual price conditions and contractual
     * delivery conditions under which goods are offered.
     */
    public const REQUEST_FOR_CONTRACT_PRICE_AND_DELIVERY_QUOTE = '445';

    /**
     * Request for contract price quote (444)
     *
     * Document/message requesting contractual price conditions under which goods
     * are offered.
     */
    public const REQUEST_FOR_CONTRACT_PRICE_QUOTE = '444';

    /**
     * Request for delivery instructions (330)
     *
     * Document/message issued by a supplier requesting instructions from the
     * buyer regarding the details of the delivery of goods ordered.
     */
    public const REQUEST_FOR_DELIVERY_INSTRUCTIONS = '330';

    /**
     * Request for delivery quote (442)
     *
     * Document/message requesting delivery conditions under which goods are
     * offered.
     */
    public const REQUEST_FOR_DELIVERY_QUOTE = '442';

    /**
     * Request for financial cancellation (213)
     *
     * The message is a request for financial cancellation.
     */
    public const REQUEST_FOR_FINANCIAL_CANCELLATION = '213';

    /**
     * Request for metering point information (379)
     *
     * Message to request information about a metering point.
     */
    public const REQUEST_FOR_METERING_POINT_INFORMATION = '379';

    /**
     * Request for payment (71)
     *
     * Document/message issued by a creditor to a debtor to request payment of one
     * or more invoices past due.
     */
    public const REQUEST_FOR_PAYMENT = '71';

    /**
     * Request for price and delivery quote (443)
     *
     * Document/message requesting price and delivery conditions under which goods
     * are offered.
     */
    public const REQUEST_FOR_PRICE_AND_DELIVERY_QUOTE = '443';

    /**
     * Request for price and delivery quote, ship and debit (439)
     *
     * Document/message from a distributor to a supplier requesting price
     * conditions and delivery conditions under which goods can be sold by the
     * distributor to the end-customer specified on the request for quote with
     * compensation for loss of inventory value.
     */
    public const REQUEST_FOR_PRICE_AND_DELIVERY_QUOTE_SHIP_AND_DEBIT = '439';

    /**
     * Request for price and delivery quote, specified end-user (437)
     *
     * Document/message requesting price conditions and delivery conditions under
     * which goods are offered, provided that they are sold to the end-customer
     * specified on the request for quote.
     */
    public const REQUEST_FOR_PRICE_AND_DELIVERY_QUOTE_SPECIFIED_ENDUSER = '437';

    /**
     * Request for price quote (360)
     *
     * Document/message requesting price conditions under which goods are offered.
     */
    public const REQUEST_FOR_PRICE_QUOTE = '360';

    /**
     * Request for price quote, ship and debit (438)
     *
     * Document/message from a distributor to a supplier requesting price
     * conditions under which goods can be sold by the distributor to the
     * end-customer specified on the request for quote with compensation for loss
     * of inventory value.
     */
    public const REQUEST_FOR_PRICE_QUOTE_SHIP_AND_DEBIT = '438';

    /**
     * Request for price quote, specified end-customer (446)
     *
     * Document/message requesting price conditions under which goods are offered,
     * provided that they are sold to the end-customer specified on the request
     * for quote.
     */
    public const REQUEST_FOR_PRICE_QUOTE_SPECIFIED_ENDCUSTOMER = '446';

    /**
     * Request for provision of a health service (359)
     *
     * Document containing request for provision of a health service.
     */
    public const REQUEST_FOR_PROVISION_OF_A_HEALTH_SERVICE = '359';

    /**
     * Request for quote (311)
     *
     * Document/message requesting a quote on specified goods or services.
     */
    public const REQUEST_FOR_QUOTE = '311';

    /**
     * Request for statistical data (75)
     *
     * Request for one or more items or data sets of statistical data.
     */
    public const REQUEST_FOR_STATISTICAL_DATA = '75';

    /**
     * Request for transfer (303)
     *
     * Document/message is a request for transfer.
     */
    public const REQUEST_FOR_TRANSFER = '303';

    /**
     * Requirements contract (154)
     *
     * A document indicating a requirements contract that authorizes the filling
     * of all purchase requirements during a specified contract period.
     */
    public const REQUIREMENTS_CONTRACT = '154';

    /**
     * Resale information (656)
     *
     * Document/message providing information on a resale.
     */
    public const RESALE_INFORMATION = '656';

    /**
     * Residence permit (717)
     *
     * A document authorizing residence.
     */
    public const RESIDENCE_PERMIT = '717';

    /**
     * Response to a trade statistics message (37)
     *
     * Document/message in which the competent national authorities provide a
     * declarant with an acceptance or a rejection about a received declaration
     * for European statistical purposes.
     */
    public const RESPONSE_TO_A_TRADE_STATISTICS_MESSAGE = '37';

    /**
     * Response to an amendment of a documentary credit (199)
     *
     * Response to an amendment of a documentary credit.
     */
    public const RESPONSE_TO_AN_AMENDMENT_OF_A_DOCUMENTARY_CREDIT = '199';

    /**
     * Response to previous banking status message (252)
     *
     * A response to a previously sent banking status message.
     */
    public const RESPONSE_TO_PREVIOUS_BANKING_STATUS_MESSAGE = '252';

    /**
     * Response to query (22)
     *
     * Document/message returned as an answer to a question.
     */
    public const RESPONSE_TO_QUERY = '22';

    /**
     * Response to registration (301)
     *
     * Code specifying a response to an occurrence of a registration message.
     */
    public const RESPONSE_TO_REGISTRATION = '301';

    /**
     * Restow (24)
     *
     * Message/document identifying containers that have been unloaded and then
     * reloaded onto the same means of transport.
     */
    public const RESTOW = '24';

    /**
     * Returns advice (729)
     *
     * Document/message by means of which the buyer informs the seller about the
     * despatch of returned goods.
     */
    public const RETURNS_ADVICE = '729';

    /**
     * Reversal of credit (458)
     *
     * Reversal of credit accounting entry by bank.
     */
    public const REVERSAL_OF_CREDIT = '458';

    /**
     * Reversal of debit (457)
     *
     * Reversal of debit accounting entry by bank.
     */
    public const REVERSAL_OF_DEBIT = '457';

    /**
     * Risk analysis (872)
     *
     * Document specifying the analysis of risks.
     */
    public const RISK_ANALYSIS = '872';

    /**
     * Road consignment note (730)
     *
     * Transport document/message which evidences a contract between a carrier and
     * a sender for the carriage of goods by road (generic term). Remark: For
     * international road traffic, this document must contain at least the
     * particulars prescribed by the convention on the contract for the
     * international carriage of goods by road (CMR).
     */
    public const ROAD_CONSIGNMENT_NOTE = '730';

    /**
     * Road list-SMGS (722)
     *
     * Accounting document, one copy of which is drawn up for each consignment
     * note; it accompanies the consignment over the whole route and is a rail
     * transport document.
     */
    public const ROAD_LISTSMGS = '722';

    /**
     * Rush order (224)
     *
     * Document/message for urgent ordering.
     */
    public const RUSH_ORDER = '224';

    /**
     * Safety and hazard data sheet (53)
     *
     * Document or message to supply advice on a dangerous or hazardous material
     * to industrial customers so as to enable them to take measures to protect
     * their employees and the environment from any potential harmful effects from
     * these material.
     */
    public const SAFETY_AND_HAZARD_DATA_SHEET = '53';

    /**
     * Safety of equipment certificate (793)
     *
     * Document certifying the safety of a ship's equipment to a specified date.
     */
    public const SAFETY_OF_EQUIPMENT_CERTIFICATE = '793';

    /**
     * Safety of radio certificate (792)
     *
     * Document certifying the safety of a ship's radio facilities to a specified
     * date.
     */
    public const SAFETY_OF_RADIO_CERTIFICATE = '792';

    /**
     * Safety of ship certificate (791)
     *
     * Document certifying a ship's safety to a specified date.
     */
    public const SAFETY_OF_SHIP_CERTIFICATE = '791';

    /**
     * Sales data report (735)
     *
     * A message enabling companies to exchange or report electronically, basic
     * sales data related to products or services, including the corresponding
     * location, time period, product identification, pricing and quantity
     * information. It enables the recipient to p.
     */
    public const SALES_DATA_REPORT = '735';

    /**
     * Sales forecast report (734)
     *
     * A message enabling companies to exchange or report electronically, basic
     * sales forecast data related to products or services, including the
     * corresponding location, time period, product identification, pricing and
     * quantity information. It enables the recip.
     */
    public const SALES_FORECAST_REPORT = '734';

    /**
     * Sample order (228)
     *
     * Document/message to order samples.
     */
    public const SAMPLE_ORDER = '228';

    /**
     * Sanitary certificate (852)
     *
     * Document/message issued by the competent authority in the exporting country
     * evidencing that alimentary and animal products, including dead animals, are
     * fit for human consumption, and giving details, when relevant, of controls
     * undertaken.
     */
    public const SANITARY_CERTIFICATE = '852';

    /**
     * Sea waybill (710)
     *
     * Non-negotiable document which evidences a contract for the carriage of
     * goods by sea and the taking over of the goods by the carrier, and by which
     * the carrier undertakes to deliver the goods to the consignee named in the
     * document.
     */
    public const SEA_WAYBILL = '710';

    /**
     * Seaman’s book (718)
     *
     * A national identity document issued to professional seamen that contains a
     * record of their rank and service career.
     */
    public const SEAMANS_BOOK = '718';

    /**
     * Season ticket (43)
     *
     * A document giving access to a service for a determined period of time.
     */
    public const SEASON_TICKET = '43';

    /**
     * Segment change request (279)
     *
     * Requesting a change to an existing segment.
     */
    public const SEGMENT_CHANGE_REQUEST = '279';

    /**
     * Segment request (278)
     *
     * Request a new segment.
     */
    public const SEGMENT_REQUEST = '278';

    /**
     * Self billed credit note (261)
     *
     * A document which indicates that the customer is claiming credit in a self
     * billing environment.
     */
    public const SELF_BILLED_CREDIT_NOTE = '261';

    /**
     * Self billed debit note (527)
     *
     * A document which indicates that the customer is claiming debit in a self
     * billing environment.
     */
    public const SELF_BILLED_DEBIT_NOTE = '527';

    /**
     * Self-billed invoice (389)
     *
     * An invoice the invoicee is producing instead of the seller.
     */
    public const SELFBILLED_INVOICE = '389';

    /**
     * Sequenced delivery schedule (307)
     *
     * Message to describe a sequence of product delivery.
     */
    public const SEQUENCED_DELIVERY_SCHEDULE = '307';

    /**
     * Service directory definition (286)
     *
     * Document/message defining the contents of a service directory set or parts
     * thereof.
     */
    public const SERVICE_DIRECTORY_DEFINITION = '286';

    /**
     * Settlement of a letter of credit (246)
     *
     * Settlement of a letter of credit.
     */
    public const SETTLEMENT_OF_A_LETTER_OF_CREDIT = '246';

    /**
     * Ship Security Plan (552)
     *
     * Ship Security Plan (SSP) is a document prepared in terms of the ISPS Code
     * to contribute to the prevention of illegal acts against the ship and its
     * crew.
     */
    public const SHIP_SECURITY_PLAN = '552';

    /**
     * Ship's stores declaration (799)
     *
     * Declaration to Customs regarding the contents of the ship's stores
     * (equivalent to IMO FAL 3) i.e. goods intended for consumption by
     * passengers/crew on board vessels, aircraft or trains, whether or not sold
     * or landed; goods necessary for operation/maintenance of conveyance,
     * including fuel/lubricants, excluding spare parts/equipment (IMO).
     */
    public const SHIPS_STORES_DECLARATION = '799';

    /**
     * Shipper's letter of instructions (air) (341)
     *
     * Document/message issued by a consignor in which he gives details of a
     * consignment of goods that enables an airline or its agent to prepare an air
     * waybill.
     */
    public const SHIPPERS_LETTER_OF_INSTRUCTIONS_AIR = '341';

    /**
     * Shipping instructions (340)
     *
     * (1121) Document/message advising details of cargo and exporter's
     * requirements for its physical movement.
     */
    public const SHIPPING_INSTRUCTIONS = '340';

    /**
     * Shipping note (630)
     *
     * (1123) Document/message provided by the shipper or his agent to the
     * carrier, multimodal transport operator, terminal or other receiving
     * authority, giving information about export consignments offered for
     * transport, and providing for the necessary receipts and declarations of
     * liability. Sometimes a multipurpose cargo handling document also fulfilling
     * the functions of document 632, 633, 650 and 655.
     */
    public const SHIPPING_NOTE = '630';

    /**
     * Simple data element change request (275)
     *
     * Request a change to an existing simple data element.
     */
    public const SIMPLE_DATA_ELEMENT_CHANGE_REQUEST = '275';

    /**
     * Simple data element request (274)
     *
     * Requesting a new simple data element.
     */
    public const SIMPLE_DATA_ELEMENT_REQUEST = '274';

    /**
     * Single administrative document (960)
     *
     * A set of documents, replacing the various (national) forms for Customs
     * declaration within the EC, implemented on 01-01-1988.
     */
    public const SINGLE_ADMINISTRATIVE_DOCUMENT = '960';

    /**
     * Soil analysis (416)
     *
     * Soil analysis document.
     */
    public const SOIL_ANALYSIS = '416';

    /**
     * Spare parts order (233)
     *
     * Document/message to order spare parts.
     */
    public const SPARE_PARTS_ORDER = '233';

    /**
     * Special requirements permit related to the transport of cargo (521)
     *
     * A permit related to a transport document granting the transport of cargo
     * under the conditions as specifically required.
     */
    public const SPECIAL_REQUIREMENTS_PERMIT_RELATED_TO_THE_TRANSPORT_OF_CARGO = '521';

    /**
     * Specific contract conditions (777)
     *
     * Document specifying the individual conditions or clauses applying to a
     * specific contract.
     */
    public const SPECIFIC_CONTRACT_CONDITIONS = '777';

    /**
     * Spot order (222)
     *
     * Document/message ordering the remainder of a production's batch.
     */
    public const SPOT_ORDER = '222';

    /**
     * Standing inquiry on complete product information (736)
     *
     * A product inquiry which stands until it is cancelled. It requests not only
     * the updates since last time, but always the complete product information of
     * a data supplier. This means that within the standing request every time a
     * complete download of the respe.
     */
    public const STANDING_INQUIRY_ON_COMPLETE_PRODUCT_INFORMATION = '736';

    /**
     * Standing inquiry on product information (376)
     *
     * A product inquiry which stands until it is cancelled.
     */
    public const STANDING_INQUIRY_ON_PRODUCT_INFORMATION = '376';

    /**
     * Standing order (258)
     *
     * An order to supply fixed quantities of products at fixed regular intervals.
     */
    public const STANDING_ORDER = '258';

    /**
     * Statement of account message (493)
     *
     * Usage of STATAC-message.
     */
    public const STATEMENT_OF_ACCOUNT_MESSAGE = '493';

    /**
     * Statistical and other administrative internal documents (190)
     *
     * Documents/messages issued within an enterprise for the for the purpose of
     * collection of production and other internal statistics, and for other
     * administration purposes.
     */
    public const STATISTICAL_AND_OTHER_ADMINISTRATIVE_INTERNAL_DOCUMENTS = '190';

    /**
     * Statistical data (74)
     *
     * Transmission of one or more items of data or data sets.
     */
    public const STATISTICAL_DATA = '74';

    /**
     * Statistical definitions (73)
     *
     * Transmission of one or more statistical definitions.
     */
    public const STATISTICAL_DEFINITIONS = '73';

    /**
     * Statistical document, export (895)
     *
     * Document/message in which an exporter provides information about exported
     * goods required by the body responsible for the collection of international
     * trade statistics.
     */
    public const STATISTICAL_DOCUMENT_EXPORT = '895';

    /**
     * Statistical document, import (995)
     *
     * Document/message describing an import document that is used for statistical
     * purposes.
     */
    public const STATISTICAL_DOCUMENT_IMPORT = '995';

    /**
     * Status information (23)
     *
     * Information regarding the status of a related message.
     */
    public const STATUS_INFORMATION = '23';

    /**
     * Status report (287)
     *
     * Message covers information about the status.
     */
    public const STATUS_REPORT = '287';

    /**
     * Storage capacity offer (554)
     *
     * Offering of capacity to store goods.
     */
    public const STORAGE_CAPACITY_OFFER = '554';

    /**
     * Storage capacity request (576)
     *
     * Request for capacity to store goods.
     */
    public const STORAGE_CAPACITY_REQUEST = '576';

    /**
     * Stores requisition (120)
     *
     * Document/message issued within an enterprise ordering the taking out of
     * stock of goods.
     */
    public const STORES_REQUISITION = '120';

    /**
     * Subcontractor plan (157)
     *
     * A document indicating a plan that identifies the manufacturer's
     * subcontracting strategy for a specific contract.
     */
    public const SUBCONTRACTOR_PLAN = '157';

    /**
     * Substitute air waybill (743)
     *
     * A temporary air waybill which contains only limited information because of
     * the absence of the original.
     */
    public const SUBSTITUTE_AIR_WAYBILL = '743';

    /**
     * Summary sales report (346)
     *
     * Sales report containing summaries for several earlier sent sales reports.
     */
    public const SUMMARY_SALES_REPORT = '346';

    /**
     * Summons (849)
     *
     * Document specifying a summons to court.
     */
    public const SUMMONS = '849';

    /**
     * Supplementary document for application for cargo operation of dangerous
     * goods (319)
     *
     * Supplementary document to apply for cargo operation of dangerous goods.
     */
    public const SUPPLEMENTARY_DOCUMENT_FOR_APPLICATION_FOR_CARGO_OPERATION_OF_DANGEROUS_GOODS = '319';

    /**
     * Supplementary document for application for transport of dangerous goods (321)
     *
     * Supplementary document to apply for transport of dangerous goods.
     */
    public const SUPPLEMENTARY_DOCUMENT_FOR_APPLICATION_FOR_TRANSPORT_OF_DANGEROUS_GOODS = '321';

    /**
     * Sustainability data request (900)
     *
     * Document/message requesting information based on defined criteria regarding
     * sustainability.
     */
    public const SUSTAINABILITY_DATA_REQUEST = '900';

    /**
     * Sustainability data response (902)
     *
     * Document/Message returned as an answer to a question regarding
     * sustainability.
     */
    public const SUSTAINABILITY_DATA_RESPONSE = '902';

    /**
     * Sustainability Inspection request (903)
     *
     * Document/message requesting a sustainability inspection.
     */
    public const SUSTAINABILITY_INSPECTION_REQUEST = '903';

    /**
     * Sustainability Inspection response (904)
     *
     * Document/message reporting the results of a sustainability inspection.
     */
    public const SUSTAINABILITY_INSPECTION_RESPONSE = '904';

    /**
     * Swap order (229)
     *
     * Document/message informing buyer or seller of the replacement of goods
     * previously ordered.
     */
    public const SWAP_ORDER = '229';

    /**
     * Tanker bill of lading (709)
     *
     * Document which evidences a transport of liquid bulk cargo.
     */
    public const TANKER_BILL_OF_LADING = '709';

    /**
     * Task order (155)
     *
     * A document indicating an order that tasks a contractor to perform a
     * specified function.
     */
    public const TASK_ORDER = '155';

    /**
     * Tax calculation/confirmation response (Customs) (965)
     *
     * Tax calculation/confirmation response message to permit the transfer of
     * data from Customs to the transmitter of the previous message.
     */
    public const TAX_CALCULATIONCONFIRMATION_RESPONSE_CUSTOMS = '965';

    /**
     * Tax declaration (general) (938)
     *
     * Document/message containing a general tax declaration.
     */
    public const TAX_DECLARATION_GENERAL = '938';

    /**
     * Tax declaration (value added tax) (937)
     *
     * Document/message in which an importer states the pertinent information
     * required by the competent body for assessment of value-added tax.
     */
    public const TAX_DECLARATION_VALUE_ADDED_TAX = '937';

    /**
     * Tax demand (940)
     *
     * Document/message containing the demand of tax.
     */
    public const TAX_DEMAND = '940';

    /**
     * Tax invoice (388)
     *
     * An invoice for tax purposes.
     */
    public const TAX_INVOICE = '388';

    /**
     * Tax notification (102)
     *
     * Used to specify that the message is a tax notification.
     */
    public const TAX_NOTIFICATION = '102';

    /**
     * Tender (758)
     *
     * A document/message used by a supplier to bid in a procurement procedure.
     */
    public const TENDER = '758';

    /**
     * Tendering price/sales catalogue (762)
     *
     * A document/message providing information regarding pricing and catalogue
     * details for goods and/or services to be offered as part of a tender.
     */
    public const TENDERING_PRICESALES_CATALOGUE = '762';

    /**
     * Tendering price/sales catalogue request (757)
     *
     * A document/message requesting information regarding pricing and catalogue
     * details for goods and/or services to be offered as part of a tender.
     */
    public const TENDERING_PRICESALES_CATALOGUE_REQUEST = '757';

    /**
     * Test report (4)
     *
     * Report providing the results of a test session.
     */
    public const TEST_REPORT = '4';

    /**
     * Thermographic reading report (641)
     *
     * A report of temperature readings over a period.
     */
    public const THERMOGRAPHIC_READING_REPORT = '641';

    /**
     * Third party payment report (837)
     *
     * Report about payments done towards a third party.
     */
    public const THIRD_PARTY_PAYMENT_REPORT = '837';

    /**
     * Through bill of lading (761)
     *
     * Bill of lading which evidences a contract of carriage from one place to
     * another in separate stages of which at least one stage is a sea transit,
     * and by which the issuing carrier accepts responsibility for the carriage as
     * set forth in the through bill of lading.
     */
    public const THROUGH_BILL_OF_LADING = '761';

    /**
     * TIF form (951)
     *
     * International Customs transit document by which the sender declares goods
     * for carriage by rail in accordance with the provisions of the 1952
     * International Convention to facilitate the crossing of frontiers for goods
     * carried by rail (TIF Convention of UIC).
     */
    public const TIF_FORM = '951';

    /**
     * TIR carnet (952)
     *
     * International Customs document (International Transit by Road), issued by a
     * guaranteeing association approved by the Customs authorities, under the
     * cover of which goods are carried, in most cases under Customs seal, in road
     * vehicles and/or containers in compliance with the requirements of the
     * Customs TIR Convention of the International Transport of Goods under cover
     * of TIR Carnets (UN/ECE).
     */
    public const TIR_CARNET = '952';

    /**
     * Traceability event declaration (899)
     *
     * Document/message declaring a traceability event.
     */
    public const TRACEABILITY_EVENT_DECLARATION = '899';

    /**
     * Tracking number assignment report (283)
     *
     * Report of assigned tracking numbers.
     */
    public const TRACKING_NUMBER_ASSIGNMENT_REPORT = '283';

    /**
     * Trade data (332)
     *
     * Document/message is for trade data.
     */
    public const TRADE_DATA = '332';

    /**
     * Transfrontier waste shipment authorization (978)
     *
     * Document containing the authorization from the relevant authority for the
     * international carriage of waste. Syn: Transfrontier waste shipment permit.
     */
    public const TRANSFRONTIER_WASTE_SHIPMENT_AUTHORIZATION = '978';

    /**
     * Transfrontier waste shipment movement document (979)
     *
     * Document certified by the carriers and the consignee to be used for the
     * international carriage of waste.
     */
    public const TRANSFRONTIER_WASTE_SHIPMENT_MOVEMENT_DOCUMENT = '979';

    /**
     * Transit certificate of approval (897)
     *
     * Certificate of approval for the transport of goods under customs seal
     */
    public const TRANSIT_CERTIFICATE_OF_APPROVAL = '897';

    /**
     * Transit Conveyor Document (971)
     *
     * Document for a course of transit used for a carrier who is neither the
     * carrier at the beginning nor the arrival. The transit carrier can directly
     * invoice the expenses for its part of the transport.
     */
    public const TRANSIT_CONVEYOR_DOCUMENT = '971';

    /**
     * Transit license (628)
     *
     * Document/message issued by the competent body in accordance with transit
     * regulations in force, by which authorization is granted to a party to move
     * articles under customs procedure.
     */
    public const TRANSIT_LICENSE = '628';

    /**
     * Transport capacity offer (551)
     *
     * Offering of capacity for the transport of goods for a date and a route.
     */
    public const TRANSPORT_CAPACITY_OFFER = '551';

    /**
     * Transport capacity request (577)
     *
     * Request for capacity for the transport of goods for a date and a route.
     */
    public const TRANSPORT_CAPACITY_REQUEST = '577';

    /**
     * Transport cargo release order (129)
     *
     * Order to release cargo or items of transport equipment to a specified
     * party.
     */
    public const TRANSPORT_CARGO_RELEASE_ORDER = '129';

    /**
     * Transport departure report (124)
     *
     * Report of the departure of a means of transport from a particular facility.
     */
    public const TRANSPORT_DEPARTURE_REPORT = '124';

    /**
     * Transport discharge instruction (118)
     *
     * Instruction to unload specified cargo, containers or transport equipment
     * from a means of transport.
     */
    public const TRANSPORT_DISCHARGE_INSTRUCTION = '118';

    /**
     * Transport discharge report (119)
     *
     * Report on cargo, containers or transport equipment unloaded from a
     * particular means of transport.
     */
    public const TRANSPORT_DISCHARGE_REPORT = '119';

    /**
     * Transport emergency card (324)
     *
     * Official document specifying, for a given dangerous goods item, information
     * such as nature of hazard, protective devices, actions to be taken in case
     * of accident, spillage or fire and first aid to be given.
     */
    public const TRANSPORT_EMERGENCY_CARD = '324';

    /**
     * Transport empty equipment advice (125)
     *
     * Advice that an item or items of empty transport equipment are available for
     * return.
     */
    public const TRANSPORT_EMPTY_EQUIPMENT_ADVICE = '125';

    /**
     * Transport equipment acceptance order (126)
     *
     * Order to accept items of transport equipment which are to be delivered by
     * an inland carrier (rail, road or barge) to a specified facility.
     */
    public const TRANSPORT_EQUIPMENT_ACCEPTANCE_ORDER = '126';

    /**
     * Transport equipment damage report (106)
     *
     * Report of damaged items of transport equipment that have been returned.
     */
    public const TRANSPORT_EQUIPMENT_DAMAGE_REPORT = '106';

    /**
     * Transport equipment delivery notice (405)
     *
     * Notification regarding the delivery of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_DELIVERY_NOTICE = '405';

    /**
     * Transport equipment direct interchange report (103)
     *
     * Report on the movement of containers or other items of transport equipment
     * being exchanged, establishing relevant rental periods.
     */
    public const TRANSPORT_EQUIPMENT_DIRECT_INTERCHANGE_REPORT = '103';

    /**
     * Transport equipment empty release instruction (108)
     *
     * Instruction to release an item of empty transport equipment to a specified
     * party or parties.
     */
    public const TRANSPORT_EQUIPMENT_EMPTY_RELEASE_INSTRUCTION = '108';

    /**
     * Transport equipment gross mass verification message (749)
     *
     * Message containing information regarding gross mass verification of
     * transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_GROSS_MASS_VERIFICATION_MESSAGE = '749';

    /**
     * Transport equipment impending arrival advice (104)
     *
     * Advice that containers or other items of transport equipment may be
     * expected to be delivered to a certain location.
     */
    public const TRANSPORT_EQUIPMENT_IMPENDING_ARRIVAL_ADVICE = '104';

    /**
     * Transport equipment maintenance and repair notice (143)
     *
     * Report of transport equipment which has been repaired or has had
     * maintenance performed.
     */
    public const TRANSPORT_EQUIPMENT_MAINTENANCE_AND_REPAIR_NOTICE = '143';

    /**
     * Transport equipment maintenance and repair work authorisation (123)
     *
     * Authorisation to have transport equipment repaired or to have maintenance
     * performed.
     */
    public const TRANSPORT_EQUIPMENT_MAINTENANCE_AND_REPAIR_WORK_AUTHORISATION = '123';

    /**
     * Transport equipment maintenance and repair work estimate advice (107)
     *
     * Advice providing estimates of transport equipment maintenance and repair
     * costs.
     */
    public const TRANSPORT_EQUIPMENT_MAINTENANCE_AND_REPAIR_WORK_ESTIMATE_ADVICE = '107';

    /**
     * Transport equipment maintenance and repair work estimate order (142)
     *
     * Order to draw up an estimate of the costs of maintenance or repair of
     * transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_MAINTENANCE_AND_REPAIR_WORK_ESTIMATE_ORDER = '142';

    /**
     * Transport equipment movement instruction (264)
     *
     * Instruction to perform one or more different movements of transport
     * equipment.
     */
    public const TRANSPORT_EQUIPMENT_MOVEMENT_INSTRUCTION = '264';

    /**
     * Transport equipment movement report (265)
     *
     * Report on one or more different movements of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_MOVEMENT_REPORT = '265';

    /**
     * Transport equipment movement report, partial (873)
     *
     * A partial transport equipment movement report, containing only a selected
     * part of the movements of transport equipment for a vessel in a port.
     */
    public const TRANSPORT_EQUIPMENT_MOVEMENT_REPORT_PARTIAL = '873';

    /**
     * Transport equipment off-hire report (58)
     *
     * Report on the movement of containers or other items of transport equipment
     * to record physical movement activity and establish the end of a rental
     * period.
     */
    public const TRANSPORT_EQUIPMENT_OFFHIRE_REPORT = '58';

    /**
     * Transport equipment off-hire request (136)
     *
     * Request to terminate the lease on an item of transport equipment at a
     * specified time.
     */
    public const TRANSPORT_EQUIPMENT_OFFHIRE_REQUEST = '136';

    /**
     * Transport equipment on-hire order (135)
     *
     * Order to release empty items of transport equipment for on-hire to a
     * lessee, and authorising collection by or on behalf of a specified party.
     */
    public const TRANSPORT_EQUIPMENT_ONHIRE_ORDER = '135';

    /**
     * Transport equipment on-hire report (57)
     *
     * Report on the movement of containers or other items of transport equipment
     * to record physical movement activity and establish the beginning of a
     * rental period.
     */
    public const TRANSPORT_EQUIPMENT_ONHIRE_REPORT = '57';

    /**
     * Transport equipment on-hire request (134)
     *
     * Request for transport equipment to be made available for hire.
     */
    public const TRANSPORT_EQUIPMENT_ONHIRE_REQUEST = '134';

    /**
     * Transport equipment packing instruction (131)
     *
     * Instruction to pack cargo into a container or other item of transport
     * equipment.
     */
    public const TRANSPORT_EQUIPMENT_PACKING_INSTRUCTION = '131';

    /**
     * Transport equipment pick-up availability confirmation (115)
     *
     * Confirmation that an item of transport equipment is available for
     * collection.
     */
    public const TRANSPORT_EQUIPMENT_PICKUP_AVAILABILITY_CONFIRMATION = '115';

    /**
     * Transport equipment pick-up availability request (114)
     *
     * Request for confirmation that an item of transport equipment will be
     * available for collection.
     */
    public const TRANSPORT_EQUIPMENT_PICKUP_AVAILABILITY_REQUEST = '114';

    /**
     * Transport equipment pick-up report (116)
     *
     * Report that an item of transport equipment has been collected.
     */
    public const TRANSPORT_EQUIPMENT_PICKUP_REPORT = '116';

    /**
     * Transport equipment profile report (436)
     *
     * Report on the profile of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_PROFILE_REPORT = '436';

    /**
     * Transport equipment shift report (117)
     *
     * Report on the movement of containers or other items of transport within a
     * facility.
     */
    public const TRANSPORT_EQUIPMENT_SHIFT_REPORT = '117';

    /**
     * Transport equipment special service instruction (127)
     *
     * Instruction to perform a specified service or services on an item or items
     * of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_SPECIAL_SERVICE_INSTRUCTION = '127';

    /**
     * Transport equipment status change report (266)
     *
     * Report on one or more changes of status associated with an item or items of
     * transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_STATUS_CHANGE_REPORT = '266';

    /**
     * Transport equipment stock report (128)
     *
     * Report on the number of items of transport equipment stored at one or more
     * locations.
     */
    public const TRANSPORT_EQUIPMENT_STOCK_REPORT = '128';

    /**
     * Transport equipment survey order (137)
     *
     * Order to perform a survey on specified items of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_SURVEY_ORDER = '137';

    /**
     * Transport equipment survey order response (138)
     *
     * Response to an order to conduct a survey of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_SURVEY_ORDER_RESPONSE = '138';

    /**
     * Transport equipment survey report (139)
     *
     * Survey report of specified items of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_SURVEY_REPORT = '139';

    /**
     * Transport equipment unpacking instruction (112)
     *
     * Instruction to unpack specified cargo from specified containers or other
     * items of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_UNPACKING_INSTRUCTION = '112';

    /**
     * Transport equipment unpacking report (113)
     *
     * Report on the completion of unpacking specified containers or other items
     * of transport equipment.
     */
    public const TRANSPORT_EQUIPMENT_UNPACKING_REPORT = '113';

    /**
     * Transport loading instruction (121)
     *
     * Instruction to load cargo, containers or transport equipment onto a means
     * of transport.
     */
    public const TRANSPORT_LOADING_INSTRUCTION = '121';

    /**
     * Transport loading report (122)
     *
     * Report on completion of loading cargo, containers or other transport
     * equipment onto a means of transport.
     */
    public const TRANSPORT_LOADING_REPORT = '122';

    /**
     * Transport Means Security Report (588)
     *
     * A document reporting the security status and related information of a means
     * of transport.
     */
    public const TRANSPORT_MEANS_SECURITY_REPORT = '588';

    /**
     * Transport movement gate in report (109)
     *
     * Report on the inward movement of cargo, containers or other items of
     * transport equipment which have been delivered to a facility by an inland
     * carrier.
     */
    public const TRANSPORT_MOVEMENT_GATE_IN_REPORT = '109';

    /**
     * Transport movement gate out report (111)
     *
     * Report on the outward movement of cargo, containers or other items of
     * transport equipment (either full or empty) which have been picked up by an
     * inland carrier.
     */
    public const TRANSPORT_MOVEMENT_GATE_OUT_REPORT = '111';

    /**
     * Transport routing information (441)
     *
     * Document specifying the routes for transport between locations.
     */
    public const TRANSPORT_ROUTING_INFORMATION = '441';

    /**
     * Transport status report (44)
     *
     * (1125) A message to report the transport status and/or change in the
     * transport status (i.e. event) between agreed parties.
     */
    public const TRANSPORT_STATUS_REPORT = '44';

    /**
     * Transport status request (45)
     *
     * (1127) A message to request a transport status report (e.g. through the
     * national multimodal status report message IFSTA).
     */
    public const TRANSPORT_STATUS_REQUEST = '45';

    /**
     * Transshipment despatch advice (399)
     *
     * Document by means of which the supplier or consignor informs the buyer,
     * consignee or the distribution centre about the despatch of goods for
     * transshipment.
     */
    public const TRANSSHIPMENT_DESPATCH_ADVICE = '399';

    /**
     * Travel ticket (459)
     *
     * The document is a ticket giving access to a travel service.
     */
    public const TRAVEL_TICKET = '459';

    /**
     * Treatment - nil outturn (59)
     *
     * No shortage, surplus or damaged outturn resulting from container vessel
     * unpacking.
     */
    public const TREATMENT_NIL_OUTTURN = '59';

    /**
     * Treatment - personal effect (62)
     *
     * Cargo consists of personal effects.
     */
    public const TREATMENT_PERSONAL_EFFECT = '62';

    /**
     * Treatment - timber (63)
     *
     * Cargo consists of timber.
     */
    public const TREATMENT_TIMBER = '63';

    /**
     * Treatment - time-up underbond (60)
     *
     * Movement type indicator: goods are moved under customs control for
     * warehousing due to being time-up.
     */
    public const TREATMENT_TIMEUP_UNDERBOND = '60';

    /**
     * Treatment - underbond by sea (61)
     *
     * Movement type indicator: goods are to move by sea under customs control to
     * a customs office where formalities will be completed.
     */
    public const TREATMENT_UNDERBOND_BY_SEA = '61';

    /**
     * Underbond approval (32)
     *
     * A message/document issuing Customs approval to move cargo from one Customs
     * control point to another.
     */
    public const UNDERBOND_APPROVAL = '32';

    /**
     * Underbond request (31)
     *
     * A Message/document requesting to move cargo from one Customs control point
     * to another.
     */
    public const UNDERBOND_REQUEST = '31';

    /**
     * United Nations standard message request (285)
     *
     * Requesting a United Nations Standard Message (UNSM).
     */
    public const UNITED_NATIONS_STANDARD_MESSAGE_REQUEST = '285';

    /**
     * Universal (multipurpose) transport document (701)
     *
     * Document/message evidencing a contract of carriage covering the movement of
     * goods by any mode of transport, or combination of modes, for national as
     * well as international transport, under any applicable international
     * convention or national law and under the conditions of carriage of any
     * carrier or transport operator undertaking or arranging the transport
     * referred to in the document.
     */
    public const UNIVERSAL_MULTIPURPOSE_TRANSPORT_DOCUMENT = '701';

    /**
     * Unpriced bill of quantity (208)
     *
     * Document/message providing a detailed, quantity based specification, issued
     * in an unpriced form to invite tender prices.
     */
    public const UNPRICED_BILL_OF_QUANTITY = '208';

    /**
     * Unship permit (72)
     *
     * A message or document issuing permission to unship cargo.
     */
    public const UNSHIP_PERMIT = '72';

    /**
     * US, FATCA statement (814)
     *
     * Statement regarding the Foreign Account Tax Compliance Act (FATCA) of the
     * United States of America.
     */
    public const US_FATCA_STATEMENT = '814';

    /**
     * User directory definition (284)
     *
     * Document/message defining the contents of a user directory set or parts
     * thereof.
     */
    public const USER_DIRECTORY_DEFINITION = '284';

    /**
     * Utilities time series message (411)
     *
     * The Utilities time series message is sent between responsible parties in a
     * utilities infrastructure for the purpose of reporting time series and
     * connected technical and/or administrative information.
     */
    public const UTILITIES_TIME_SERIES_MESSAGE = '411';

    /**
     * Vaccination certificate (38)
     *
     * Official document proving immunisation against certain diseases.
     */
    public const VACCINATION_CERTIFICATE = '38';

    /**
     * Validated priced tender (50)
     *
     * A validated priced tender.
     */
    public const VALIDATED_PRICED_TENDER = '50';

    /**
     * Valuation report (829)
     *
     * Document reporting a valuation.
     */
    public const VALUATION_REPORT = '829';

    /**
     * Value declaration (934)
     *
     * Document/message in which a declarant (importer) states the invoice or
     * other price (e.g. selling price, price of identical goods), and specifies
     * costs for freight, insurance and packing, etc., terms of delivery and
     * payment, any relationship with the trading partner, etc., for the purpose
     * of determining the Customs value of goods imported.
     */
    public const VALUE_DECLARATION = '934';

    /**
     * Vehicle aboard document (857)
     *
     * Document which must be aboard the vehicle.
     */
    public const VEHICLE_ABOARD_DOCUMENT = '857';

    /**
     * Vessel unpack report (86)
     *
     * A document code to indicate that the message being transmitted identifies
     * all short and surplus cargoes off-loaded from a vessel at a specified
     * discharging port.
     */
    public const VESSEL_UNPACK_REPORT = '86';

    /**
     * Veterinary certificate (853)
     *
     * Document/message issued by the competent authority in the exporting country
     * evidencing that live animals or birds are not infested or infected with
     * disease, and giving details regarding their provenance, and of vaccinations
     * and other treatment to which they have been subjected.
     */
    public const VETERINARY_CERTIFICATE = '853';

    /**
     * Veterinary quarantine certificate (629)
     *
     * A certification that livestock or animal products, that are either imported
     * or entering free zones, are kept under health supervision for a time period
     * determined by veterinary quarantine instructions.
     */
    public const VETERINARY_QUARANTINE_CERTIFICATE = '629';

    /**
     * Video (866)
     *
     * Document consisting of a video.
     */
    public const VIDEO = '866';

    /**
     * Visa (483)
     *
     * An endorsement on a passport or any other recognised travel document
     * indicating that it has been examined and found correct, especially as
     * permitting the holder to enter or leave a country.
     */
    public const VISA = '483';

    /**
     * Wage determination (160)
     *
     * A document indicating a determination of the wages to be paid.
     */
    public const WAGE_DETERMINATION = '160';

    /**
     * Wagon report (970)
     *
     * Document which contains consignment information concerning the wagons and
     * their lading in a case of a multiple wagon consignment.
     */
    public const WAGON_REPORT = '970';

    /**
     * Warehouse warrant (635)
     *
     * Negotiable receipt document, issued by a Warehouse Keeper to a person
     * placing goods in a warehouse and conferring title to the goods stored.
     */
    public const WAREHOUSE_WARRANT = '635';

    /**
     * Waste disposal report (470)
     *
     * Document/message sent by a shipping agent to an authority for reporting
     * information on waste disposal.
     */
    public const WASTE_DISPOSAL_REPORT = '470';

    /**
     * Waybill (700)
     *
     * Non-negotiable document evidencing the contract for the transport of cargo.
     */
    public const WAYBILL = '700';

    /**
     * WCO Cargo Report Export, Air or Maritime (419)
     *
     * Declaration, in accordance with the WCO Customs Data Model, to Customs
     * concerning the export of cargo carried by commercial means of transport
     * over water or through the air, e.g. vessel or aircraft.
     */
    public const WCO_CARGO_REPORT_EXPORT_AIR_OR_MARITIME = '419';

    /**
     * WCO Cargo Report Export, Rail or Road (418)
     *
     * Declaration, in accordance with the WCO Customs Data Model, to Customs
     * concerning the export of cargo carried by commercial means of transport
     * over land, e.g. truck or train.
     */
    public const WCO_CARGO_REPORT_EXPORT_RAIL_OR_ROAD = '418';

    /**
     * WCO Cargo Report Import, Air or Maritime (422)
     *
     * Declaration, in accordance with the WCO Customs Data Model, to Customs
     * concerning the import of cargo carried by commercial means of transport
     * over water or through the air, e.g. vessel or aircraft.
     */
    public const WCO_CARGO_REPORT_IMPORT_AIR_OR_MARITIME = '422';

    /**
     * WCO Cargo Report Import, Rail or Road (421)
     *
     * Declaration, in accordance with the WCO Customs Data Model, to Customs
     * concerning the import of cargo carried by commercial means of transport
     * over land, e.g. truck or train.
     */
    public const WCO_CARGO_REPORT_IMPORT_RAIL_OR_ROAD = '421';

    /**
     * WCO Conveyance Arrival Report (524)
     *
     * Declaration, in accordance with the WCO Customs Data Model, to Customs
     * regarding the conveyance arriving in a Customs territory.
     */
    public const WCO_CONVEYANCE_ARRIVAL_REPORT = '524';

    /**
     * WCO Conveyance Departure Report (525)
     *
     * Declaration, in accordance with the WCO Customs Data Model, to Customs
     * regarding the conveyance departing a Customs territory.
     */
    public const WCO_CONVEYANCE_DEPARTURE_REPORT = '525';

    /**
     * WCO first step of two-step export declaration (424)
     *
     * First part of a simplified declaration, in accordance with the WCO Customs
     * Data Model, to Customs by which goods are declared for Customs export
     * procedure based on the 1999 Kyoto Convention.
     */
    public const WCO_FIRST_STEP_OF_TWOSTEP_EXPORT_DECLARATION = '424';

    /**
     * WCO first step of two-step import declaration (497)
     *
     * First part of a simplified declaration, in accordance with the WCO Customs
     * Data Model, to Customs by which goods are declared for Customs import
     * procedure based on the 1999 Kyoto Convention.
     */
    public const WCO_FIRST_STEP_OF_TWOSTEP_IMPORT_DECLARATION = '497';

    /**
     * WCO one-step export declaration (423)
     *
     * Single step declaration, in accordance with the WCO Customs Data Model, to
     * Customs by which goods are declared for a Customs export procedure based on
     * the 1999 Kyoto Convention.
     */
    public const WCO_ONESTEP_EXPORT_DECLARATION = '423';

    /**
     * WCO one-step import declaration (496)
     *
     * Single step declaration, in accordance with the WCO Customs Data Model, to
     * Customs by which goods are declared for Customs import procedure based on
     * the 1999 Kyoto Convention.
     */
    public const WCO_ONESTEP_IMPORT_DECLARATION = '496';

    /**
     * WCO second step of two-step export declaration (495)
     *
     * Second part of a simplified declaration, in accordance with the WCO Customs
     * Data Model, to Customs by which goods are declared for Customs export
     * procedure based on the 1999 Kyoto Convention.
     */
    public const WCO_SECOND_STEP_OF_TWOSTEP_EXPORT_DECLARATION = '495';

    /**
     * WCO second step of two-step import declaration (498)
     *
     * Second part of a simplified declaration, in accordance with the WCO Customs
     * Data Model, to Customs by which goods are declared for Customs import
     * procedure based on the 1999 Kyoto Convention.
     */
    public const WCO_SECOND_STEP_OF_TWOSTEP_IMPORT_DECLARATION = '498';

    /**
     * Weight certificate (14)
     *
     * Certificate certifying the weight of goods.
     */
    public const WEIGHT_CERTIFICATE = '14';

    /**
     * Weight list (15)
     *
     * Document/message specifying the weight of goods.
     */
    public const WEIGHT_LIST = '15';

    /**
     * Wine certificate (268)
     *
     * Certificate attesting to the quality, origin or appellation of wine.
     */
    public const WINE_CERTIFICATE = '268';

    /**
     * Witness report (843)
     *
     * Document containing a report of a witness.
     */
    public const WITNESS_REPORT = '843';

    /**
     * Wool health certificate (269)
     *
     * Certificate attesting that wool is free from specified risks to human or
     * animal health.
     */
    public const WOOL_HEALTH_CERTIFICATE = '269';

    /**
     * Written instructions in conformance with ADR article number 10385 (48)
     *
     * Written instructions relating to dangerous goods and defined in the
     * European Agreement of Dangerous Transport by Road known as ADR (Accord
     * europeen relatif au transport international des marchandises Dangereuses
     * par Route).
     */
    public const WRITTEN_INSTRUCTIONS_IN_CONFORMANCE_WITH_ADR_ARTICLE_NUMBER = '48';
}
