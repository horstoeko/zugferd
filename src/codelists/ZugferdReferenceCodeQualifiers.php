<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelists;

/**
 * Class representing list of reference code qualifiers
 * Name of list: UNTDID 1153 Reference code qualifier
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 * @see      https://www.xrepository.de/details/urn:xoev-de:kosit:codeliste:untdid.1153
 */
class ZugferdReferenceCodeQualifiers
{
	/**
	 * Accident reference number (APP)
	 *
	 * Reference number assigned to an accident.
	 */
	public const ACCI_REFE_NUMB = 'APP';

	/**
	 * Account number (ADE)
	 *
	 * Identification number of an account.
	 */
	public const ACCO_NUMB = 'ADE';

	/**
	 * Account party's bank reference (AGC)
	 *
	 * Reference number of the account party's bank.
	 */
	public const ACCO_PART_BANK_REFE = 'AGC';

	/**
	 * Account party's reference (AFN)
	 *
	 * Reference of the account party.
	 */
	public const ACCO_PART_REFE = 'AFN';

	/**
	 * Account payable number (AV)
	 *
	 * Reference number assigned by accounts payable department to the account of
	 * a specific creditor.
	 */
	public const ACCO_PAYA_NUMB = 'AV';

	/**
	 * Account servicing bank's reference number (ANA)
	 *
	 * Reference number of the account servicing bank.
	 */
	public const ACCO_SERV_BANK_REFE_NUMB = 'ANA';

	/**
	 * Accounting entry (AWQ)
	 *
	 * Accounting entry to which this item is related.
	 */
	public const ACCO_ENTR = 'AWQ';

	/**
	 * Accounting file reference (AOD)
	 *
	 * Reference of an accounting file.
	 */
	public const ACCO_FILE_REFE = 'AOD';

	/**
	 * Accounting transmission number (ASU)
	 *
	 * A number used to identify the transmission of an accounting book entry.
	 */
	public const ACCO_TRAN_NUMB = 'ASU';

	/**
	 * Accounts receivable number (AP)
	 *
	 * Reference number assigned by accounts receivable department to the account
	 * of a specific debtor.
	 */
	public const ACCO_RECE_NUMB = 'AP';

	/**
	 * Action authorization number (AKO)
	 *
	 * A reference number authorizing an action.
	 */
	public const ACTI_AUTH_NUMB = 'AKO';

	/**
	 * Activite Principale Exercee (APE) identifier (AQQ)
	 *
	 * The French industry code for the main activity of a company.
	 */
	public const ACTI_PRIN_EXER_APE_IDEN = 'AQQ';

	/**
	 * Additional reference number (ACD)
	 *
	 * [1010] Reference number provided in addition to another given reference.
	 */
	public const ADDI_REFE_NUMB = 'ACD';

	/**
	 * Addressee reference (ACF)
	 *
	 * A reference number of an addressee.
	 */
	public const ADDR_REFE = 'ACF';

	/**
	 * Administrative Reference Code (AWT)
	 *
	 * Reference number assigned by Customs to a ‘shipment of excise goods’.
	 */
	public const ADMI_REFE_CODE = 'AWT';

	/**
	 * Advise through bank's reference (AMP)
	 *
	 * Financial institution through which the advising bank is to advise the
	 * documentary credit.
	 */
	public const ADVI_THRO_BANK_REFE = 'AMP';

	/**
	 * Advising bank's reference (AWD)
	 *
	 * Reference number of the advising bank.
	 */
	public const ADVI_BANK_REFE = 'AWD';

	/**
	 * Agency clause number (AJE)
	 *
	 * A number indicating a clause applicable to a particular agency.
	 */
	public const AGEN_CLAU_NUMB = 'AJE';

	/**
	 * Agent's bank reference (AGD)
	 *
	 * Reference number issued by the agent's bank.
	 */
	public const AGEN_BANK_REFE = 'AGD';

	/**
	 * Agent's reference (AGE)
	 *
	 * Reference number of the agent.
	 */
	public const AGEN_REFE = 'AGE';

	/**
	 * AGERD (Aerospace Ground Equipment Requirement Data) number (ALU)
	 *
	 * Identifies the equipment required to conduct maintenance.
	 */
	public const AGER_AERO_GROU_EQUI_REQU_DATA_NUMB = 'ALU';

	/**
	 * Agreement number (AJS)
	 *
	 * A number specifying an agreement between parties.
	 */
	public const AGRE_NUMB = 'AJS';

	/**
	 * Agreement to pay number (AGA)
	 *
	 * A number that identifies an agreement to pay.
	 */
	public const AGRE_TO_PAY_NUMB = 'AGA';

	/**
	 * Air cargo transfer manifest (AC)
	 *
	 * A number assigned to an air cargo list of goods to be transferred.
	 */
	public const AIR_CARG_TRAN_MANI = 'AC';

	/**
	 * Air waybill number (AWB)
	 *
	 * Reference number assigned to an air waybill, see: 1001 = 740.
	 */
	public const AIR_WAYB_NUMB = 'AWB';

	/**
	 * Airlines flight identification number (AF)
	 *
	 * (8028) Identification of a commercial flight by carrier code and number as
	 * assigned by the airline (IATA).
	 */
	public const AIRL_FLIG_IDEN_NUMB = 'AF';

	/**
	 * Allocated seat (SEA)
	 *
	 * Reference to a seat allocated to a passenger.
	 */
	public const ALLO_SEAT = 'SEA';

	/**
	 * Allotment identification (Air) (ABY)
	 *
	 * Reference assigned to guarantied capacity on one or more specific flights
	 * on specific date(s) to third parties as agents and other airlines.
	 */
	public const ALLO_IDEN_AIR = 'ABY';

	/**
	 * Analysis number/test number (ADD)
	 *
	 * Number given to a specific analysis or test operation.
	 */
	public const ANAL_NUMB_NUMB = 'ADD';

	/**
	 * Animal farm licence number (CFF)
	 *
	 * Veterinary licence number allocated by a national authority to an animal
	 * farm.
	 */
	public const ANIM_FARM_LICE_NUMB = 'CFF';

	/**
	 * Anti-dumping case number (ABC)
	 *
	 * Reference issued by a Customs administration pertaining to a past or
	 * current investigation of goods "dumped" at a price lower than the
	 * exporter's domestic market price.
	 */
	public const ANTI_CASE_NUMB = 'ABC';

	/**
	 * Applicable coefficient identification number (APT)
	 *
	 * The identification number of the coefficient which is applicable.
	 */
	public const APPL_COEF_IDEN_NUMB = 'APT';

	/**
	 * Applicable instructions or standards (AEH)
	 *
	 * Instructions or standards applicable for the whole message or a message
	 * line item. These instructions or standards may be published by a neutral
	 * organization or authority or another party concerned.
	 */
	public const APPL_INST_OR_STAN = 'AEH';

	/**
	 * Applicant's bank reference (AFQ)
	 *
	 * Reference number of the applicant's bank.
	 */
	public const APPL_BANK_REFE = 'AFQ';

	/**
	 * Applicant's reference (AGF)
	 *
	 * Reference number of the applicant.
	 */
	public const APPL_REFE = 'AGF';

	/**
	 * Application for financial support reference number (AUK)
	 *
	 * Reference number assigned to an application for financial support.
	 */
	public const APPL_FOR_FINA_SUPP_REFE_NUMB = 'AUK';

	/**
	 * Application reference number (AGK)
	 *
	 * A number that identifies an application reference.
	 */
	public const APPL_REFE_NUMB = 'AGK';

	/**
	 * Appropriation number (AKP)
	 *
	 * The number identifying a type of funding for a specific purpose
	 * (appropriation).
	 */
	public const APPR_NUMB = 'AKP';

	/**
	 * Article number (ABU)
	 *
	 * A number that identifies an article.
	 */
	public const ARTI_NUMB = 'ABU';

	/**
	 * Assembly number (AEB)
	 *
	 * A number that identifies an assembly.
	 */
	public const ASSE_NUMB = 'AEB';

	/**
	 * Associated invoices (AFL)
	 *
	 * A number that identifies associated invoices.
	 */
	public const ASSO_INVO = 'AFL';

	/**
	 * Assuming company (ASC)
	 *
	 * A number that identifies an assuming company.
	 */
	public const ASSU_COMP = 'ASC';

	/**
	 * ATA carnet number (ACG)
	 *
	 * Reference number assigned to an ATA carnet.
	 */
	public const ATA_CARN_NUMB = 'ACG';

	/**
	 * Authorisation for repair reference (APV)
	 *
	 * Reference of the authorisation for repair.
	 */
	public const AUTH_FOR_REPA_REFE = 'APV';

	/**
	 * Authority issued equipment identification (AHB)
	 *
	 * Identification issued by an authority, e.g. government, airport authority.
	 */
	public const AUTH_ISSU_EQUI_IDEN = 'AHB';

	/**
	 * Authorization for expense (AFE) number (AE)
	 *
	 * A number that identifies an authorization for expense (AFE).
	 */
	public const AUTH_FOR_EXPE_AFE_NUMB = 'AE';

	/**
	 * Authorization number (ANJ)
	 *
	 * A number which uniquely identifies an authorization.
	 */
	public const AUTH_NUMB = 'ANJ';

	/**
	 * Authorization number for exception to dangerous goods regulations (ALF)
	 *
	 * Reference number allocated by an authority. This number contains an
	 * approval concerning exceptions on the existing dangerous goods regulations.
	 */
	public const AUTH_NUMB_FOR_EXCE_TO_DANG_GOOD_REGU = 'ALF';

	/**
	 * Authorization to meet competition number (AU)
	 *
	 * A number assigned by a requestor to an offer incoming following request for
	 * quote.
	 */
	public const AUTH_TO_MEET_COMP_NUMB = 'AU';

	/**
	 * Bankgiro reference (ATL)
	 *
	 * Reference of the Bankgiro.
	 */
	public const BANK_REFE = 'ATL';

	/**
	 * Bank's batch interbank transaction reference number (AAH)
	 *
	 * Reference number allocated by the bank to a batch of different underlying
	 * interbank transactions.
	 */
	public const BANK_BATC_INTE_TRAN_REFE_NUMB = 'AAH';

	/**
	 * Bank's common transaction reference number (AII)
	 *
	 * Bank's reference number allocated by the bank to different underlying
	 * individual transactions.
	 */
	public const BANK_COMM_TRAN_REFE_NUMB = 'AII';

	/**
	 * Bank's documentary procedure reference (ATG)
	 *
	 * Reference allocated by the bank to a documentary procedure.
	 */
	public const BANK_DOCU_PROC_REFE = 'ATG';

	/**
	 * Bank's individual interbank transaction reference number (AAI)
	 *
	 * Reference number allocated by the bank to one specific interbank
	 * transaction.
	 */
	public const BANK_INDI_INTE_TRAN_REFE_NUMB = 'AAI';

	/**
	 * Bank's individual transaction reference number (AIK)
	 *
	 * Bank's reference number allocated by the bank to one specific transaction.
	 */
	public const BANK_INDI_TRAN_REFE_NUMB = 'AIK';

	/**
	 * Banker's acceptance (ACX)
	 *
	 * Reference number for banker's acceptance issued by the accepting financial
	 * institution.
	 */
	public const BANK_ACCE = 'ACX';

	/**
	 * Bankruptcy procedure number (AQZ)
	 *
	 * A number identifying a bankruptcy procedure.
	 */
	public const BANK_PROC_NUMB = 'AQZ';

	/**
	 * Bar coded label serial number (LS)
	 *
	 * The serial number on a bar code label.
	 */
	public const BAR_CODE_LABE_SERI_NUMB = 'LS';

	/**
	 * Batch number/lot number (BT)
	 *
	 * [7338] Reference number assigned by manufacturer to a series of similar
	 * products or goods produced under similar conditions.
	 */
	public const BATC_NUMB_NUMB = 'BT';

	/**
	 * Battery and accumulator producer registration number (BTP)
	 *
	 * Registration number of producer of batteries and accumulators.
	 */
	public const BATT_AND_ACCU_PROD_REGI_NUMB = 'BTP';

	/**
	 * Beginning job sequence number (AQN)
	 *
	 * The number designating the beginning of the job sequence.
	 */
	public const BEGI_JOB_SEQU_NUMB = 'AQN';

	/**
	 * Beginning meter reading actual (BA)
	 *
	 * Meter reading at the beginning of an invoicing period.
	 */
	public const BEGI_METE_READ_ACTU = 'BA';

	/**
	 * Beginning meter reading estimated (BE)
	 *
	 * Meter reading at the beginning of an invoicing period where an actual
	 * reading is not available.
	 */
	public const BEGI_METE_READ_ESTI = 'BE';

	/**
	 * Beneficiary's bank reference (AFS)
	 *
	 * Reference number of the beneficiary's bank.
	 */
	public const BENE_BANK_REFE = 'AFS';

	/**
	 * Beneficiary's reference (AFO)
	 *
	 * Reference of the beneficiary.
	 */
	public const BENE_REFE = 'AFO';

	/**
	 * Bid number (BD)
	 *
	 * Number assigned by a submitter of a bid to his bid.
	 */
	public const BID_NUMB = 'BD';

	/**
	 * Bill of lading number (BM)
	 *
	 * Reference number assigned to a bill of lading, see: 1001 = 705.
	 */
	public const BILL_OF_LADI_NUMB = 'BM';

	/**
	 * Bill of quantities number (AFX)
	 *
	 * Reference number assigned to a bill of quantities.
	 */
	public const BILL_OF_QUAN_NUMB = 'AFX';

	/**
	 * Blanket order number (BO)
	 *
	 * Reference number assigned by the order issuer to a blanket order.
	 */
	public const BLAN_ORDE_NUMB = 'BO';

	/**
	 * Blended with number (BW)
	 *
	 * The batch/lot/package number a product is blended with.
	 */
	public const BLEN_WITH_NUMB = 'BW';

	/**
	 * Book number (ART)
	 *
	 * A number assigned to identify a book.
	 */
	public const BOOK_NUMB = 'ART';

	/**
	 * Bordereau number (AFC)
	 *
	 * Reference number assigned to a bordereau, see: 1001 = 787.
	 */
	public const BORD_NUMB = 'AFC';

	/**
	 * Broker or sales office number (BR)
	 *
	 * A number that identifies a broker or sales office.
	 */
	public const BROK_OR_SALE_OFFI_NUMB = 'BR';

	/**
	 * Broker reference 3 (AVK)
	 *
	 * Third reference of a broker.
	 */
	public const BROK_REFE = 'AVK';

	/**
	 * Budget chapter (ASD)
	 *
	 * A reference to the chapter in a budget.
	 */
	public const BUDG_CHAP = 'ASD';

	/**
	 * Bureau signing (statement reference) (ADI)
	 *
	 * A statement reference that identifies a bureau signing.
	 */
	public const BURE_SIGN_STAT_REFE = 'ADI';

	/**
	 * Buyer's catalogue number (AMW)
	 *
	 * Identification of a catalogue maintained by a buyer.
	 */
	public const BUYE_CATA_NUMB = 'AMW';

	/**
	 * Buyer's contract number (BC)
	 *
	 * Reference number assigned by buyer to a contract.
	 */
	public const BUYE_CONT_NUMB = 'BC';

	/**
	 * Buyer's debtor number (DB)
	 *
	 * Reference number assigned to a debtor.
	 */
	public const BUYE_DEBT_NUMB = 'DB';

	/**
	 * Buyer's fund number (AWW)
	 *
	 * A reference number indicating the fund number used by the buyer.
	 */
	public const BUYE_FUND_NUMB = 'AWW';

	/**
	 * Buyer's item number (ADA)
	 *
	 * [7304] Reference number assigned by the buyer to an item.
	 */
	public const BUYE_ITEM_NUMB = 'ADA';

	/**
	 * CAD file layer convention (ANF)
	 *
	 * Reference number identifying a layer convention for a file in a Computer
	 * Aided Design (CAD) environment.
	 */
	public const CAD_FILE_LAYE_CONV = 'ANF';

	/**
	 * Cadastro Geral do Contribuinte (CGC) (ASW)
	 *
	 * Brazilian taxpayer number.
	 */
	public const CADA_GERA_DO_CONT_CGC = 'ASW';

	/**
	 * Calendar (AOJ)
	 *
	 * A calendar reference number.
	 */
	public const CALENDAR = 'AOJ';

	/**
	 * Call off order number (COF)
	 *
	 * A number that identifies a call off order.
	 */
	public const CALL_OFF_ORDE_NUMB = 'COF';

	/**
	 * Canadian excise entry number (AMN)
	 *
	 * An excise entry number assigned by the Canadian Customs.
	 */
	public const CANA_EXCI_ENTR_NUMB = 'AMN';

	/**
	 * Cargo acceptance order reference number (ACA)
	 *
	 * Reference assigned to the cargo acceptance order.
	 */
	public const CARG_ACCE_ORDE_REFE_NUMB = 'ACA';

	/**
	 * Cargo control number (XC)
	 *
	 * Reference used to identify and control a carrier and consignment from
	 * initial entry into a country until release of the cargo by Customs.
	 */
	public const CARG_CONT_NUMB = 'XC';

	/**
	 * Cargo manifest number (AFB)
	 *
	 * [1037] Reference number assigned to a cargo manifest.
	 */
	public const CARG_MANI_NUMB = 'AFB';

	/**
	 * Carrier's agent reference number (AAY)
	 *
	 * Reference number assigned by the carriers agent to a transaction.
	 */
	public const CARR_AGEN_REFE_NUMB = 'AAY';

	/**
	 * Carrier's reference number (CN)
	 *
	 * Reference number assigned by carrier to a consignment.
	 */
	public const CARR_REFE_NUMB = 'CN';

	/**
	 * Case number (AMH)
	 *
	 * Number assigned to a case.
	 */
	public const CASE_NUMB = 'AMH';

	/**
	 * Case of need party's reference (ANO)
	 *
	 * Reference number of the case of need party.
	 */
	public const CASE_OF_NEED_PART_REFE = 'ANO';

	/**
	 * Catalogue sequence number (AKS)
	 *
	 * A number which uniquely identifies an item within a catalogue according to
	 * a standard numbering system.
	 */
	public const CATA_SEQU_NUMB = 'AKS';

	/**
	 * Catastrophe number (ADG)
	 *
	 * A number that identifies a catastrophe.
	 */
	public const CATA_NUMB = 'ADG';

	/**
	 * Category of work reference (AWH)
	 *
	 * A reference identifying a category of work.
	 */
	public const CATE_OF_WORK_REFE = 'AWH';

	/**
	 * CD-ROM (ASY)
	 *
	 * Identity number of the Compact Disk Read Only Memory (CD-ROM).
	 */
	public const CDROM = 'ASY';

	/**
	 * Cedent's claim number (APD)
	 *
	 * To identify the number assigned to the claim by the ceding company.
	 */
	public const CEDE_CLAI_NUMB = 'APD';

	/**
	 * Ceding company (CEC)
	 *
	 * Company selling obligations to a third party.
	 */
	public const CEDI_COMP = 'CEC';

	/**
	 * Ceiling formula reference number (APJ)
	 *
	 * The reference number which identifies a formula for determining a ceiling.
	 */
	public const CEIL_FORM_REFE_NUMB = 'APJ';

	/**
	 * Central secretariat log number (AQE)
	 *
	 * The reference log number assigned by the central secretariat for the Data
	 * Maintenance Request (DMR).
	 */
	public const CENT_SECR_LOG_NUMB = 'AQE';

	/**
	 * Central secretariat log number, child Data Maintenance Request (DMR) (AQG)
	 *
	 * The reference log number assigned by the central secretariat for the child
	 * Data Maintenance Request (DMR).
	 */
	public const CENT_SECR_LOG_NUMB_CHIL_DATA_MAIN_REQU_DMR = 'AQG';

	/**
	 * Central secretariat log number, parent Data Maintenance Request (DMR) (AQF)
	 *
	 * The reference log number assigned by the central secretariat for the parent
	 * Data Maintenance Request (DMR).
	 */
	public const CENT_SECR_LOG_NUMB_PARE_DATA_MAIN_REQU_DMR = 'AQF';

	/**
	 * Certificate of conformity (AID)
	 *
	 * Certificate certifying the conformity to predefined definitions.
	 */
	public const CERT_OF_CONF = 'AID';

	/**
	 * Chamber of Commerce registration number (AHO)
	 *
	 * The registration number by which a company/organization is known to the
	 * Chamber of Commerce.
	 */
	public const CHAM_OF_COMM_REGI_NUMB = 'AHO';

	/**
	 * Charge card account number (AIU)
	 *
	 * Number to identify charge card account.
	 */
	public const CHAR_CARD_ACCO_NUMB = 'AIU';

	/**
	 * Charges note document attachment indicator (CNO)
	 *
	 * [1070] Indication that a charges note has been established and attached to
	 * a transport contract document or not.
	 */
	public const CHAR_NOTE_DOCU_ATTA_INDI = 'CNO';

	/**
	 * Checking number (CKN)
	 *
	 * Number assigned by checking party to one specific check action.
	 */
	public const CHEC_NUMB = 'CKN';

	/**
	 * Cheque number (CK)
	 *
	 * Unique number assigned to one specific cheque.
	 */
	public const CHEQ_NUMB = 'CK';

	/**
	 * Circular publication number (AJF)
	 *
	 * A number specifying a circular publication.
	 */
	public const CIRC_PUBL_NUMB = 'AJF';

	/**
	 * Civil action number (AAX)
	 *
	 * A reference number identifying the civil action.
	 */
	public const CIVI_ACTI_NUMB = 'AAX';

	/**
	 * Clave Unica de Identificacion Tributaria (CUIT) (ATU)
	 *
	 * Tax identification number in Argentina.
	 */
	public const CLAV_UNIC_DE_IDEN_TRIB_CUIT = 'ATU';

	/**
	 * Clearing reference (ANX)
	 *
	 * Reference allocated by a clearing procedure.
	 */
	public const CLEA_REFE = 'ANX';

	/**
	 * Cold roll number (ACQ)
	 *
	 * Number attributed to a cold roll coil.
	 */
	public const COLD_ROLL_NUMB = 'ACQ';

	/**
	 * Collecting bank's reference (ANP)
	 *
	 * Reference number of the collecting bank.
	 */
	public const COLL_BANK_REFE = 'ANP';

	/**
	 * Collection advice document identifier (ACN)
	 *
	 * [1030] Reference number to identify a collection advice document.
	 */
	public const COLL_ADVI_DOCU_IDEN = 'ACN';

	/**
	 * Collection instrument number (ATN)
	 *
	 * To identify the number of an instrument used to remit funds to a
	 * beneficiary.
	 */
	public const COLL_INST_NUMB = 'ATN';

	/**
	 * Collection reference (AUD)
	 *
	 * A reference identifying a collection.
	 */
	public const COLL_REFE = 'AUD';

	/**
	 * Commercial account summary reference number (APQ)
	 *
	 * A reference number identifying a commercial account summary.
	 */
	public const COMM_ACCO_SUMM_REFE_NUMB = 'APQ';

	/**
	 * Commodity number (AED)
	 *
	 * A number that identifies a commodity.
	 */
	public const COMM_NUMB = 'AED';

	/**
	 * Common transaction reference number (AIH)
	 *
	 * Reference number applicable to different underlying individual
	 * transactions.
	 */
	public const COMM_TRAN_REFE_NUMB = 'AIH';

	/**
	 * Companies Registry Office (CRO) number (ARC)
	 *
	 * Identifies the reference number assigned by the Companies Registry Office
	 * (CRO).
	 */
	public const COMP_REGI_OFFI_CRO_NUMB = 'ARC';

	/**
	 * Company / syndicate reference 2 (ADK)
	 *
	 * Second reference of a company/syndicate.
	 */
	public const COMP_SYND_REFE = 'ADK';

	/**
	 * Company issued equipment ID (AGP)
	 *
	 * Owner/operator, non-government issued equipment reference number.
	 */
	public const COMP_ISSU_EQUI_ID = 'AGP';

	/**
	 * Company trading account number (AWX)
	 *
	 * A reference number identifying a company trading account.
	 */
	public const COMP_TRAD_ACCO_NUMB = 'AWX';

	/**
	 * Company/place registration number (XA)
	 *
	 * Company registration and place as legally required.
	 */
	public const COMP_REGI_NUMB = 'XA';

	/**
	 * Completed units payment request reference (ANB)
	 *
	 * A reference to a payment request for completed units.
	 */
	public const COMP_UNIT_PAYM_REQU_REFE = 'ANB';

	/**
	 * Compliance code number (AIA)
	 *
	 * Number assigned to indicate regulatory compliance.
	 */
	public const COMP_CODE_NUMB = 'AIA';

	/**
	 * Condition of purchase document number (CP)
	 *
	 * Reference number identifying the conditions of purchase relevant to a
	 * purchase.
	 */
	public const COND_OF_PURC_DOCU_NUMB = 'CP';

	/**
	 * Condition of sale document number (CS)
	 *
	 * Reference number identifying the conditions of sale relevant to a sale.
	 */
	public const COND_OF_SALE_DOCU_NUMB = 'CS';

	/**
	 * Connected location (AWN)
	 *
	 * Reference of a connected location.
	 */
	public const CONN_LOCA = 'AWN';

	/**
	 * Connecting point to central grid (AUV)
	 *
	 * Reference to a connecting point to a central grid.
	 */
	public const CONN_POIN_TO_CENT_GRID = 'AUV';

	/**
	 * Consignor's further order (CFO)
	 *
	 * Reference of an order given by the consignor after departure of the means
	 * of transport.
	 */
	public const CONS_FURT_ORDE = 'CFO';

	/**
	 * Consolidated invoice number (AIZ)
	 *
	 * Invoice number into which other invoices are consolidated.
	 */
	public const CONS_INVO_NUMB = 'AIZ';

	/**
	 * Consignee's order number (CG)
	 *
	 * A number that identifies a consignee's order.
	 */
	public const CONS_ORDE_NUMB = 'CG';

	/**
	 * Consignee's reference (ANT)
	 *
	 * Reference number of the consignee.
	 */
	public const CONS_REFE = 'ANT';

	/**
	 * Consignment contract number (AXP)
	 *
	 * Reference number identifying a consignment contract.
	 */
	public const CONS_CONT_NUMB = 'AXP';

	/**
	 * Consignment identifier, carrier assigned (BN)
	 *
	 * [1016] Reference number assigned by a carrier of its agent to identify a
	 * specific consignment such as a booking reference number when cargo space is
	 * reserved prior to loading.
	 */
	public const CONS_IDEN_CARR_ASSI = 'BN';

	/**
	 * Consignment identifier, consignor assigned (CU)
	 *
	 * [1140] Reference number assigned by the consignor to identify a particular
	 * consignment.
	 */
	public const CONS_IDEN_CONS_ASSI = 'CU';

	/**
	 * Consignment identifier, freight forwarder assigned (FF)
	 *
	 * [1460] Reference number assigned by the freight forwarder to identify a
	 * particular consignment.
	 */
	public const CONS_IDEN_FREI_FORW_ASSI = 'FF';

	/**
	 * Consignment information (AVL)
	 *
	 * Code identifying that the reference number given applies to the consignment
	 * information segment group in the referred message .
	 */
	public const CONS_INFO = 'AVL';

	/**
	 * Consignment receipt identifier (REN)
	 *
	 * [1150] Reference number assigned to identify a consignment upon its arrival
	 * at its destination.
	 */
	public const CONS_RECE_IDEN = 'REN';

	/**
	 * Consignment stock contract (AUF)
	 *
	 * Reference identifying a consignment stock contract.
	 */
	public const CONS_STOC_CONT = 'AUF';

	/**
	 * Consolidated orders' reference (AUP)
	 *
	 * A reference number to identify orders which have been, or shall be
	 * consolidated.
	 */
	public const CONS_ORDE_REFE = 'AUP';

	/**
	 * Constraint notation (AOX)
	 *
	 * Identifies a reference to a constraint notation.
	 */
	public const CONS_NOTA = 'AOX';

	/**
	 * Consumption data request number (AMF)
	 *
	 * A number which identifies a request for consumption data.
	 */
	public const CONS_DATA_REQU_NUMB = 'AMF';

	/**
	 * Container disposition order reference number (AKA)
	 *
	 * Reference assigned to the empty container disposition order.
	 */
	public const CONT_DISP_ORDE_REFE_NUMB = 'AKA';

	/**
	 * Container operators reference number (CV)
	 *
	 * Reference number assigned by the party operating or controlling the
	 * transport container to a transaction or consignment.
	 */
	public const CONT_OPER_REFE_NUMB = 'CV';

	/**
	 * Container prefix (AKB)
	 *
	 * The first part of the unique identification of a container formed by an
	 * alpha code identifying the owner of the container.
	 */
	public const CONT_PREF = 'AKB';

	/**
	 * Container work order reference number (ADO)
	 *
	 * Reference number assigned by the principal to the work order for a (set of)
	 * container(s).
	 */
	public const CONT_WORK_ORDE_REFE_NUMB = 'ADO';

	/**
	 * Container/equipment receipt number (ER)
	 *
	 * Number of the Equipment Interchange Receipt issued for full or empty
	 * equipment received.
	 */
	public const CONT_RECE_NUMB = 'ER';

	/**
	 * Contract breakdown reference (APR)
	 *
	 * A reference which identifies a specific breakdown of a contract.
	 */
	public const CONT_BREA_REFE = 'APR';

	/**
	 * Contract document addendum identifier (AAD)
	 *
	 * [1318] Reference number to identify an addendum to a contract.
	 */
	public const CONT_DOCU_ADDE_IDEN = 'AAD';

	/**
	 * Contract number (CT)
	 *
	 * [1296] Reference number of a contract concluded between parties.
	 */
	public const CONT_NUMB = 'CT';

	/**
	 * Contract party reference number (AGB)
	 *
	 * Reference number assigned to a party for a particular contract.
	 */
	public const CONT_PART_REFE_NUMB = 'AGB';

	/**
	 * Contractor registration number (APS)
	 *
	 * A reference number used to identify a contractor.
	 */
	public const CONT_REGI_NUMB = 'APS';

	/**
	 * Contractor request reference (APO)
	 *
	 * Reference identifying a request made by a contractor.
	 */
	public const CONT_REQU_REFE = 'APO';

	/**
	 * Converted Postgiro number (ATO)
	 *
	 * To identify the reference number of a giro payment having been converted to
	 * a Postgiro account.
	 */
	public const CONV_POST_NUMB = 'ATO';

	/**
	 * Cooperation contract number (CZ)
	 *
	 * Number issued by a party concerned given to a contract on cooperation of
	 * two or more parties.
	 */
	public const COOP_CONT_NUMB = 'CZ';

	/**
	 * Cost account (AOU)
	 *
	 * A cost control account reference.
	 */
	public const COST_ACCO = 'AOU';

	/**
	 * Cost accounting document (CAY)
	 *
	 * The reference to a cost accounting document.
	 */
	public const COST_ACCO_DOCU = 'CAY';

	/**
	 * Cost centre (AWE)
	 *
	 * A number identifying a cost centre.
	 */
	public const COST_CENT = 'AWE';

	/**
	 * Cost centre alignment number (ATP)
	 *
	 * Number used in the financial management process to align cost allocations.
	 */
	public const COST_CENT_ALIG_NUMB = 'ATP';

	/**
	 * Costa Rican judicial number (ARD)
	 *
	 * A number assigned by the government to a business in Costa Rica.
	 */
	public const COST_RICA_JUDI_NUMB = 'ARD';

	/**
	 * Credit memo number (CM)
	 *
	 * Reference number assigned by issuer to a credit memo.
	 */
	public const CRED_MEMO_NUMB = 'CM';

	/**
	 * Credit note number (CD)
	 *
	 * [1113] Reference number assigned to a credit note.
	 */
	public const CRED_NOTE_NUMB = 'CD';

	/**
	 * Credit rating agency's reference number (AGH)
	 *
	 * Reference number assigned by a credit rating agency to a debtor.
	 */
	public const CRED_RATI_AGEN_REFE_NUMB = 'AGH';

	/**
	 * Creditor's reference number (AHL)
	 *
	 * Reference number of the party to whom a debt is owed.
	 */
	public const CRED_REFE_NUMB = 'AHL';

	/**
	 * Current invoice number (OH)
	 *
	 * Reference number identifying the current invoice.
	 */
	public const CURR_INVO_NUMB = 'OH';

	/**
	 * Customer catalogue number (CH)
	 *
	 * Number identifying a catalogue for customer's usage.
	 */
	public const CUST_CATA_NUMB = 'CH';

	/**
	 * Customer material specification number (ACJ)
	 *
	 * Number for a material specification given by customer.
	 */
	public const CUST_MATE_SPEC_NUMB = 'ACJ';

	/**
	 * Customer process specification number (AEF)
	 *
	 * Retrieval number for a process specification defined by customer.
	 */
	public const CUST_PROC_SPEC_NUMB = 'AEF';

	/**
	 * Customer reference number (CR)
	 *
	 * Reference number assigned by the customer to a transaction.
	 */
	public const CUST_REFE_NUMB = 'CR';

	/**
	 * Customer reference number assigned to previous balance of payment
	 * information (ALC)
	 *
	 * Identification number of the previous balance of payments information from
	 * customer message.
	 */
	public const CUST_REFE_NUMB_ASSI_TO_PREV_BALA_OF_PAYM_INFO = 'ALC';

	/**
	 * Customer specification number (AEG)
	 *
	 * Retrieval number for a specification defined by customer.
	 */
	public const CUST_SPEC_NUMB = 'AEG';

	/**
	 * Customer travel service identifier (AVI)
	 *
	 * A reference identifying a travel service to a customer.
	 */
	public const CUST_TRAV_SERV_IDEN = 'AVI';

	/**
	 * Customer's common transaction reference number (AIL)
	 *
	 * Customer's reference number allocated by the customer to different
	 * underlying individual transactions.
	 */
	public const CUST_COMM_TRAN_REFE_NUMB = 'AIL';

	/**
	 * Customer's documentary procedure reference (ATH)
	 *
	 * Reference allocated by a customer to a documentary procedure.
	 */
	public const CUST_DOCU_PROC_REFE = 'ATH';

	/**
	 * Customer's individual transaction reference number (AIJ)
	 *
	 * Customer's reference number allocated by the customer to one specific
	 * transaction.
	 */
	public const CUST_INDI_TRAN_REFE_NUMB = 'AIJ';

	/**
	 * Customer's unit inventory number (AEN)
	 *
	 * Number assigned by customer to a unique unit for inventory purposes.
	 */
	public const CUST_UNIT_INVE_NUMB = 'AEN';

	/**
	 * Customs binding ruling number (AUQ)
	 *
	 * Binding ruling number issued by customs.
	 */
	public const CUST_BIND_RULI_NUMB = 'AUQ';

	/**
	 * Customs decision request number (ABG)
	 *
	 * Reference issued by Customs pertaining to a pending tariff classification
	 * decision requested by an importer or agent.
	 */
	public const CUST_DECI_REQU_NUMB = 'ABG';

	/**
	 * Customs guarantee number (ABL)
	 *
	 * Reference assigned to a Customs guarantee.
	 */
	public const CUST_GUAR_NUMB = 'ABL';

	/**
	 * Customs item number (AFD)
	 *
	 * Number (1496 in CST) assigned by the declarant to an item.
	 */
	public const CUST_ITEM_NUMB = 'AFD';

	/**
	 * Customs non-binding ruling number (AUR)
	 *
	 * Non-binding ruling number issued by customs.
	 */
	public const CUST_NONB_RULI_NUMB = 'AUR';

	/**
	 * Customs pre-approval ruling number (AUZ)
	 *
	 * Pre-approval ruling number issued by Customs.
	 */
	public const CUST_PREA_RULI_NUMB = 'AUZ';

	/**
	 * Customs preference inquiry number (AIP)
	 *
	 * The number assigned by Customs to a preference inquiry.
	 */
	public const CUST_PREF_INQU_NUMB = 'AIP';

	/**
	 * Customs release code (AHZ)
	 *
	 * A code associated to a requirement that must be presented to gain the
	 * release of goods by Customs.
	 */
	public const CUST_RELE_CODE = 'AHZ';

	/**
	 * Customs tariff number (ABD)
	 *
	 * (7357) Code number of the goods in accordance with the tariff nomenclature
	 * system of classification in use where the Customs declaration is made.
	 */
	public const CUST_TARI_NUMB = 'ABD';

	/**
	 * Customs transhipment number (AIO)
	 *
	 * Approval number issued by Customs for cargo to be transhipped under Customs
	 * control.
	 */
	public const CUST_TRAN_NUMB = 'AIO';

	/**
	 * Customs valuation decision number (ABA)
	 *
	 * Reference by an importing party to a previous decision made by a Customs
	 * administration regarding the valuation of goods.
	 */
	public const CUST_VALU_DECI_NUMB = 'ABA';

	/**
	 * Dangerous Goods information (AVN)
	 *
	 * Code identifying that the reference number given applies to the dangerous
	 * goods information segment group in the referred message.
	 */
	public const DANG_GOOD_INFO = 'AVN';

	/**
	 * Dangerous goods security number (ALG)
	 *
	 * Reference number allocated by an authority in order to control the
	 * dangerous goods on board of a specific means of transport for dangerous
	 * goods security purposes.
	 */
	public const DANG_GOOD_SECU_NUMB = 'ALG';

	/**
	 * Dangerous goods transport licence number (ALH)
	 *
	 * Licence number allocated by an authority as to the permission of carrying
	 * dangerous goods by a specific means of transport.
	 */
	public const DANG_GOOD_TRAN_LICE_NUMB = 'ALH';

	/**
	 * Data structure tag (AQD)
	 *
	 * The tag assigned to a data structure.
	 */
	public const DATA_STRU_TAG = 'AQD';

	/**
	 * Debit account number (DAN)
	 *
	 * Reference number assigned by issuer to a debit account.
	 */
	public const DEBI_ACCO_NUMB = 'DAN';

	/**
	 * Debit card number (AAF)
	 *
	 * A reference number identifying a debit card.
	 */
	public const DEBI_CARD_NUMB = 'AAF';

	/**
	 * Debit letter number (CED)
	 *
	 * Reference number identifying the letter of debit document.
	 */
	public const DEBI_LETT_NUMB = 'CED';

	/**
	 * Debit note number (DL)
	 *
	 * [1117] Reference number assigned by issuer to a debit note.
	 */
	public const DEBI_NOTE_NUMB = 'DL';

	/**
	 * Debit reference number (AOI)
	 *
	 * The reference number of a debit instruction.
	 */
	public const DEBI_REFE_NUMB = 'AOI';

	/**
	 * Debtor's reference number (AHM)
	 *
	 * Reference number of the party who owes an amount of money.
	 */
	public const DEBT_REFE_NUMB = 'AHM';

	/**
	 * Declarant's Customs identity number (ABP)
	 *
	 * Reference to the party whose posted bond or security is being declared in
	 * order to accept responsibility for a goods declaration and the applicable
	 * duties and taxes.
	 */
	public const DECL_CUST_IDEN_NUMB = 'ABP';

	/**
	 * Declarant's reference number (ABE)
	 *
	 * Unique reference number assigned to a document or a message by the
	 * declarant for identification purposes.
	 */
	public const DECL_REFE_NUMB = 'ABE';

	/**
	 * Defense priorities allocation system priority rating (AJQ)
	 *
	 * A reference indicating a priority rating assigned to allocate resources for
	 * defense purchases.
	 */
	public const DEFE_PRIO_ALLO_SYST_PRIO_RATI = 'AJQ';

	/**
	 * Deferment approval number (DA)
	 *
	 * Number assigned by authorities to a party to approve deferment of payment
	 * of tax or duties.
	 */
	public const DEFE_APPR_NUMB = 'DA';

	/**
	 * Delivery note number (DQ)
	 *
	 * [1033] Reference number assigned by the issuer to a delivery note.
	 */
	public const DELI_NOTE_NUMB = 'DQ';

	/**
	 * Delivery number (transport) (AEL)
	 *
	 * Reference number by which a haulier/carrier will announce himself at the
	 * container terminal or depot when delivering equipment.
	 */
	public const DELI_NUMB_TRAN = 'AEL';

	/**
	 * Delivery order number (AAJ)
	 *
	 * Reference number assigned by issuer to a delivery order.
	 */
	public const DELI_ORDE_NUMB = 'AAJ';

	/**
	 * Delivery route reference (AUS)
	 *
	 * A reference to the route of the delivery.
	 */
	public const DELI_ROUT_REFE = 'AUS';

	/**
	 * Delivery schedule number (AAN)
	 *
	 * Reference number assigned by buyer to a delivery schedule.
	 */
	public const DELI_SCHE_NUMB = 'AAN';

	/**
	 * Delivery verification certificate (AGL)
	 *
	 * Formal identification of delivery verification certificate which is a
	 * formal document from Customs etc. confirming that physical goods have been
	 * delivered. It may be needed to support a tax reclaim based on an invoice.
	 */
	public const DELI_VERI_CERT = 'AGL';

	/**
	 * Department (AOQ)
	 *
	 * Section of an organisation.
	 */
	public const DEPARTMENT = 'AOQ';

	/**
	 * Department number (AMV)
	 *
	 * Number assigned to a department within an organization.
	 */
	public const DEPA_NUMB = 'AMV';

	/**
	 * Department of transportation bond number (AIB)
	 *
	 * Number of a bond assigned by the department of transportation.
	 */
	public const DEPA_OF_TRAN_BOND_NUMB = 'AIB';

	/**
	 * Deposit reference number (ANL)
	 *
	 * A reference number identifying a deposit.
	 */
	public const DEPO_REFE_NUMB = 'ANL';

	/**
	 * Despatch advice number (AAK)
	 *
	 * [1035] Reference number assigned by issuing party to a despatch advice.
	 */
	public const DESP_ADVI_NUMB = 'AAK';

	/**
	 * Despatch note (post parcels) number (AEZ)
	 *
	 * (1128) Reference number assigned to a despatch note (post parcels), see:
	 * 1001 = 750.
	 */
	public const DESP_NOTE_POST_PARC_NUMB = 'AEZ';

	/**
	 * Despatch note document identifier (AAU)
	 *
	 * [1128] Reference number to identify a Despatch Note.
	 */
	public const DESP_NOTE_DOCU_IDEN = 'AAU';

	/**
	 * Direct debit reference (AKJ)
	 *
	 * Reference number assigned to the direct debit operation.
	 */
	public const DIRE_DEBI_REFE = 'AKJ';

	/**
	 * Direct payment valuation number (AFT)
	 *
	 * Reference number assigned to a direct payment valuation.
	 */
	public const DIRE_PAYM_VALU_NUMB = 'AFT';

	/**
	 * Direct payment valuation request number (AFU)
	 *
	 * Reference number assigned to a direct payment valuation request.
	 */
	public const DIRE_PAYM_VALU_REQU_NUMB = 'AFU';

	/**
	 * Dispensation reference (ASA)
	 *
	 * A reference number assigned to an official exemption from a law or
	 * obligation.
	 */
	public const DISP_REFE = 'ASA';

	/**
	 * Dispute number (AGG)
	 *
	 * Reference number to a dispute notice.
	 */
	public const DISP_NUMB = 'AGG';

	/**
	 * Distributor invoice number (DI)
	 *
	 * Reference number assigned by issuer to a distributor invoice.
	 */
	public const DIST_INVO_NUMB = 'DI';

	/**
	 * Dock receipt number (DR)
	 *
	 * Number of the cargo receipt submitted when cargo is delivered to a marine
	 * terminal.
	 */
	public const DOCK_RECE_NUMB = 'DR';

	/**
	 * Docket number (AAW)
	 *
	 * A reference number identifying the docket.
	 */
	public const DOCK_NUMB = 'AAW';

	/**
	 * Document identifier (DM)
	 *
	 * [1004] Reference number identifying a specific document.
	 */
	public const DOCU_IDEN = 'DM';

	/**
	 * Document line identifier (LI)
	 *
	 * [1156] To identify a line of a document.
	 */
	public const DOCU_LINE_IDEN = 'LI';

	/**
	 * Document page identifier (ARO)
	 *
	 * [1212] To identify a page number.
	 */
	public const DOCU_PAGE_IDEN = 'ARO';

	/**
	 * Document reference, internal (CAW)
	 *
	 * Internal reference to a document.
	 */
	public const DOCU_REFE_INTE = 'CAW';

	/**
	 * Document reference, original (AWR)
	 *
	 * The original reference of a document.
	 */
	public const DOCU_REFE_ORIG = 'AWR';

	/**
	 * Document volume number (ARS)
	 *
	 * The number of a document volume.
	 */
	public const DOCU_VOLU_NUMB = 'ARS';

	/**
	 * Documentary credit amendment number (AWC)
	 *
	 * Number of the amendment of the documentary credit.
	 */
	public const DOCU_CRED_AMEN_NUMB = 'AWC';

	/**
	 * Documentary credit identifier (AAC)
	 *
	 * [1172] Reference number to identify a documentary credit.
	 */
	public const DOCU_CRED_IDEN = 'AAC';

	/**
	 * Documentary payment reference (AOA)
	 *
	 * Reference of the documentary payment.
	 */
	public const DOCU_PAYM_REFE = 'AOA';

	/**
	 * Domestic flight number (AGQ)
	 *
	 * Airline flight number assigned to a flight originating and terminating
	 * within the same country.
	 */
	public const DOME_FLIG_NUMB = 'AGQ';

	/**
	 * Domestic inventory management code (ALB)
	 *
	 * Code to identify the management of domestic inventory.
	 */
	public const DOME_INVE_MANA_CODE = 'ALB';

	/**
	 * Drawee's reference (ANN)
	 *
	 * Reference number of the drawee.
	 */
	public const DRAW_REFE = 'ANN';

	/**
	 * Drawing list number (AEQ)
	 *
	 * Reference number identifying a drawing list.
	 */
	public const DRAW_LIST_NUMB = 'AEQ';

	/**
	 * Drawing number (AAL)
	 *
	 * Reference number identifying a specific product drawing.
	 */
	public const DRAW_NUMB = 'AAL';

	/**
	 * Dun and Bradstreet Canada's 8 digit Standard Industrial Classification
	 * (SIC) code (AQP)
	 *
	 * Dun and Bradstreet Canada's 8 digit Standard Industrial Classification
	 * (SIC) code identifying activities of the company.
	 */
	public const DUN_AND_BRAD_CANA__DIGI_STAN_INDU_CLAS_SIC_CODE = 'AQP';

	/**
	 * Dun and Bradstreet US 8 digit Standard Industrial Classification (SIC) code (AQR)
	 *
	 * Dun and Bradstreet United States' 8 digit Standard Industrial
	 * Classification (SIC) code identifying activities of the company.
	 */
	public const DUN_AND_BRAD_US__DIGI_STAN_INDU_CLAS_SIC_CODE = 'AQR';

	/**
	 * Duty free products receipt authorisation number (ASF)
	 *
	 * Authorisation number allocated for the receipt of duty free products.
	 */
	public const DUTY_FREE_PROD_RECE_AUTH_NUMB = 'ASF';

	/**
	 * Duty free products security number (ASE)
	 *
	 * A security number allocated for duty free products.
	 */
	public const DUTY_FREE_PROD_SECU_NUMB = 'ASE';

	/**
	 * Duty memo number (ACY)
	 *
	 * Reference number assigned by customs to a duty memo.
	 */
	public const DUTY_MEMO_NUMB = 'ACY';

	/**
	 * Economic Operators Registration and Identification Number (EORI) (AVY)
	 *
	 * Number assigned by an authority to an economic operator.
	 */
	public const ECON_OPER_REGI_AND_IDEN_NUMB_EORI = 'AVY';

	/**
	 * Electrical and electronic equipment producer registration number (EEP)
	 *
	 * Registration number of producer of electrical and electronic equipment.
	 */
	public const ELEC_AND_ELEC_EQUI_PROD_REGI_NUMB = 'EEP';

	/**
	 * Embargo number (EN)
	 *
	 * Number assigned to specific goods or a family of goods in a classification
	 * of embargo measures.
	 */
	public const EMBA_NUMB = 'EN';

	/**
	 * Embargo permit number (EB)
	 *
	 * Reference number assigned by issuer to an embargo permit.
	 */
	public const EMBA_PERM_NUMB = 'EB';

	/**
	 * Employer identification number of service bureau (AGS)
	 *
	 * Reference number assigned by a service/processing bureau to an employer.
	 */
	public const EMPL_IDEN_NUMB_OF_SERV_BURE = 'AGS';

	/**
	 * Employer's identification number (EI)
	 *
	 * Number issued by an authority to identify an employer.
	 */
	public const EMPL_IDEN_NUMB = 'EI';

	/**
	 * Empty container bill number (AEW)
	 *
	 * Reference number assigned to an empty container bill, see: 1001 = 708.
	 */
	public const EMPT_CONT_BILL_NUMB = 'AEW';

	/**
	 * End item number (AJU)
	 *
	 * A number specifying the end item applicable to a subordinate item.
	 */
	public const END_ITEM_NUMB = 'AJU';

	/**
	 * End use authorization number (ABB)
	 *
	 * Reference issued by a Customs administration authorizing a preferential
	 * rate of duty if a product is used for a specified purpose, see: 1001 = 990.
	 */
	public const END_USE_AUTH_NUMB = 'ABB';

	/**
	 * Ending job sequence number (JE)
	 *
	 * A number that identifies the ending job sequence.
	 */
	public const ENDI_JOB_SEQU_NUMB = 'JE';

	/**
	 * Ending meter reading actual (EA)
	 *
	 * Meter reading at the end of an invoicing period.
	 */
	public const ENDI_METE_READ_ACTU = 'EA';

	/**
	 * Ending meter reading estimated (EE)
	 *
	 * Meter reading at the end of an invoicing period where an actual reading is
	 * not available.
	 */
	public const ENDI_METE_READ_ESTI = 'EE';

	/**
	 * Enquiry number (AAV)
	 *
	 * Reference number assigned to an enquiry.
	 */
	public const ENQU_NUMB = 'AAV';

	/**
	 * Entity reference number, previous (AUX)
	 *
	 * The previous reference number assigned to an entity.
	 */
	public const ENTI_REFE_NUMB_PREV = 'AUX';

	/**
	 * Entry flagging (CAU)
	 *
	 * Reference to a flagging of entries.
	 */
	public const ENTR_FLAG = 'CAU';

	/**
	 * Entry point assessment log number (AQA)
	 *
	 * The reference log number assigned by an entry point assessment group for
	 * the DMR.
	 */
	public const ENTR_POIN_ASSE_LOG_NUMB = 'AQA';

	/**
	 * Entry point assessment log number, child DMR (AQC)
	 *
	 * The reference log number assigned by an entry point assessment group for a
	 * child Data Maintenance Request (DMR).
	 */
	public const ENTR_POIN_ASSE_LOG_NUMB_CHIL_DMR = 'AQC';

	/**
	 * Entry point assessment log number, parent DMR (AQB)
	 *
	 * The reference log number assigned by an entry point assessment group for
	 * the parent Data Maintenance Request (DMR).
	 */
	public const ENTR_POIN_ASSE_LOG_NUMB_PARE_DMR = 'AQB';

	/**
	 * Equipment number (EQ)
	 *
	 * Number assigned by the manufacturer to specific equipment.
	 */
	public const EQUI_NUMB = 'EQ';

	/**
	 * Equipment owner reference number (APC)
	 *
	 * Reference number issued by the owner of the equipment.
	 */
	public const EQUI_OWNE_REFE_NUMB = 'APC';

	/**
	 * Equipment sequence number (SQ)
	 *
	 * (1492) A temporary reference number identifying a particular piece of
	 * equipment within a series of pieces of equipment.
	 */
	public const EQUI_SEQU_NUMB = 'SQ';

	/**
	 * Equipment transport charge number (ACZ)
	 *
	 * Reference assigned to a specific equipment transportation charge.
	 */
	public const EQUI_TRAN_CHAR_NUMB = 'ACZ';

	/**
	 * Error position (AWL)
	 *
	 * Reference to the position of an error in a message.
	 */
	public const ERRO_POSI = 'AWL';

	/**
	 * Estimate order reference number (ACV)
	 *
	 * Reference number assigned by the ordering party of the estimate order.
	 */
	public const ESTI_ORDE_REFE_NUMB = 'ACV';

	/**
	 * ETERMS reference (AOY)
	 *
	 * Identifies a reference to the ICC (International Chamber of Commerce)
	 * ETERMS(tm) repository of electronic commerce trading terms and conditions.
	 */
	public const ETER_REFE = 'AOY';

	/**
	 * Eur 1 certificate number (AEE)
	 *
	 * Reference number assigned to a Eur 1 certificate.
	 */
	public const EUR__CERT_NUMB = 'AEE';

	/**
	 * European Value Added Tax identification (CAX)
	 *
	 * Value Added Tax identification number according to European regulation.
	 */
	public const EURO_VALU_ADDE_TAX_IDEN = 'CAX';

	/**
	 * Event reference number (AIV)
	 *
	 * [1007] Reference number identifying an event.
	 */
	public const EVEN_REFE_NUMB = 'AIV';

	/**
	 * Exceptional transport authorisation number (ATT)
	 *
	 * Authorisation number for exceptional transport (using specific equipment,
	 * out of gauge, materials and/or specific routing).
	 */
	public const EXCE_TRAN_AUTH_NUMB = 'ATT';

	/**
	 * Excess transportation number (ET)
	 *
	 * (1041) Number assigned to excess transport.
	 */
	public const EXCE_TRAN_NUMB = 'ET';

	/**
	 * Export clearance instruction reference number (ABR)
	 *
	 * Reference number of the clearance instructions given by the consignor
	 * through different means.
	 */
	public const EXPO_CLEA_INST_REFE_NUMB = 'ABR';

	/**
	 * Export control classification number (AVJ)
	 *
	 * Number identifying the classification of goods covered by an export
	 * licence.
	 */
	public const EXPO_CONT_CLAS_NUMB = 'AVJ';

	/**
	 * Export Control Commodity number (ECCN) (AFE)
	 *
	 * Reference number to relevant item within Commodity Control List covering
	 * actual products change functionality.
	 */
	public const EXPO_CONT_COMM_NUMB_ECCN = 'AFE';

	/**
	 * Export declaration (ED)
	 *
	 * Number assigned by the exporter to his export declaration number submitted
	 * to an authority.
	 */
	public const EXPO_DECL = 'ED';

	/**
	 * Export establishment number (AIC)
	 *
	 * Number to identify export establishment.
	 */
	public const EXPO_ESTA_NUMB = 'AIC';

	/**
	 * Export permit identifier (EX)
	 *
	 * [1208] Reference number to identify an export licence or permit.
	 */
	public const EXPO_PERM_IDEN = 'EX';

	/**
	 * Exporter's reference number (ERN)
	 *
	 * Reference to a party exporting goods.
	 */
	public const EXPO_REFE_NUMB = 'ERN';

	/**
	 * External object reference (ATS)
	 *
	 * A reference identifying an external object.
	 */
	public const EXTE_OBJE_REFE = 'ATS';

	/**
	 * Federal supply schedule item number (AJV)
	 *
	 * A number specifying an item listed in a federal supply schedule.
	 */
	public const FEDE_SUPP_SCHE_ITEM_NUMB = 'AJV';

	/**
	 * File conversion journal (ANI)
	 *
	 * Reference number identifying a journal recording details about conversion
	 * operations between file formats.
	 */
	public const FILE_CONV_JOUR = 'ANI';

	/**
	 * File identification number (AQY)
	 *
	 * A number assigned to identify a file.
	 */
	public const FILE_IDEN_NUMB = 'AQY';

	/**
	 * File line identifier (FI)
	 *
	 * Number assigned by the file issuer or sender to identify a specific line.
	 */
	public const FILE_LINE_IDEN = 'FI';

	/**
	 * File version number (FV)
	 *
	 * Number given to a version of an identified file.
	 */
	public const FILE_VERS_NUMB = 'FV';

	/**
	 * Final sequence number (FS)
	 *
	 * A number that identifies the final sequence.
	 */
	public const FINA_SEQU_NUMB = 'FS';

	/**
	 * Financial cancellation reference number (ATA)
	 *
	 * Reference number of a financial cancellation.
	 */
	public const FINA_CANC_REFE_NUMB = 'ATA';

	/**
	 * Financial management reference (ALY)
	 *
	 * A financial management reference.
	 */
	public const FINA_MANA_REFE = 'ALY';

	/**
	 * Financial phase reference (ARW)
	 *
	 * A reference which identifies a specific financial phase.
	 */
	public const FINA_PHAS_REFE = 'ARW';

	/**
	 * Financial settlement party's reference number (AMX)
	 *
	 * Reference number of the party who is responsible for the financial
	 * settlement.
	 */
	public const FINA_SETT_PART_REFE_NUMB = 'AMX';

	/**
	 * Financial transaction reference number (ANU)
	 *
	 * Reference number of the financial transaction.
	 */
	public const FINA_TRAN_REFE_NUMB = 'ANU';

	/**
	 * Firm booking reference number (AXE)
	 *
	 * A reference number identifying a previous firm booking.
	 */
	public const FIRM_BOOK_REFE_NUMB = 'AXE';

	/**
	 * First financial institution's transaction reference (AVA)
	 *
	 * Identifies the reference given to the individual transaction by the
	 * financial institution that is the transaction's point of entry into the
	 * interbank transaction chain.
	 */
	public const FIRS_FINA_INST_TRAN_REFE = 'AVA';

	/**
	 * Fiscal number (FC)
	 *
	 * Tax payer's number. Number assigned to individual persons as well as to
	 * corporates by a public institution; this number is different from the VAT
	 * registration number.
	 */
	public const FISC_NUMB = 'FC';

	/**
	 * Flat rack container bundle identification number (ATW)
	 *
	 * Reference number assigned to a bundle of flat rack containers.
	 */
	public const FLAT_RACK_CONT_BUND_IDEN_NUMB = 'ATW';

	/**
	 * Flow reference number (FLW)
	 *
	 * Number given to a usual sender which has regular expeditions of the same
	 * goods, to the same destination, defining all general conditions of the
	 * transport.
	 */
	public const FLOW_REFE_NUMB = 'FLW';

	/**
	 * Foreign exchange (FO)
	 *
	 * Exchange of two currencies at an agreed rate.
	 */
	public const FORE_EXCH = 'FO';

	/**
	 * Foreign exchange contract number (FX)
	 *
	 * Reference number identifying a foreign exchange contract.
	 */
	public const FORE_EXCH_CONT_NUMB = 'FX';

	/**
	 * Foreign military sales number (AJP)
	 *
	 * A number specifying a sale to a foreign military.
	 */
	public const FORE_MILI_SALE_NUMB = 'AJP';

	/**
	 * Foreign resident identification number (ASX)
	 *
	 * Number assigned by a government agency to identify a foreign resident.
	 */
	public const FORE_RESI_IDEN_NUMB = 'ASX';

	/**
	 * Formal report number (ASP)
	 *
	 * A number uniquely identifying a formal report.
	 */
	public const FORM_REPO_NUMB = 'ASP';

	/**
	 * Formal statement reference (ASH)
	 *
	 * A reference to a formal statement.
	 */
	public const FORM_STAT_REFE = 'ASH';

	/**
	 * Formula reference number (AXM)
	 *
	 * The reference number which identifies a formula.
	 */
	public const FORM_REFE_NUMB = 'AXM';

	/**
	 * Forwarding order number (AKT)
	 *
	 * Reference number assigned to the forwarding order by the ordering customer.
	 */
	public const FORW_ORDE_NUMB = 'AKT';

	/**
	 * Framework Agreement Number (AVV)
	 *
	 * A reference to an agreement between one or more contracting authorities and
	 * one or more economic operators, the purpose of which is to establish the
	 * terms governing contracts to be awarded during a given period, in
	 * particular with regard to price and, where appropriate, the quantity
	 * envisaged.
	 */
	public const FRAM_AGRE_NUMB = 'AVV';

	/**
	 * Free zone identifier (FT)
	 *
	 * Identifier to specify the territory of a State where any goods introduced
	 * are generally regarded, insofar as import duties and taxes are concerned,
	 * as being outside the Customs territory and are not subject to usual Customs
	 * control (CCC).
	 */
	public const FREE_ZONE_IDEN = 'FT';

	/**
	 * Freight bill number (FN)
	 *
	 * Reference number assigned by issuing party to a freight bill.
	 */
	public const FREI_BILL_NUMB = 'FN';

	/**
	 * Freight Forwarder number (AHY)
	 *
	 * An identification code of a Freight Forwarder.
	 */
	public const FREI_FORW_NUMB = 'AHY';

	/**
	 * Functional work group (AOO)
	 *
	 * A reference to identify a functional group performing work.
	 */
	public const FUNC_WORK_GROU = 'AOO';

	/**
	 * Fund account number (ASQ)
	 *
	 * Account number of fund.
	 */
	public const FUND_ACCO_NUMB = 'ASQ';

	/**
	 * Fund code number (AHD)
	 *
	 * Reference number to identify appropriation and branch chargeable for item.
	 */
	public const FUND_CODE_NUMB = 'AHD';

	/**
	 * General cargo consignment reference number (AKR)
	 *
	 * Reference number identifying a particular general cargo (non-containerised
	 * or break bulk) consignment.
	 */
	public const GENE_CARG_CONS_REFE_NUMB = 'AKR';

	/**
	 * General declaration number (GDN)
	 *
	 * Number of the declaration of incoming goods out of a vessel.
	 */
	public const GENE_DECL_NUMB = 'GDN';

	/**
	 * General order number (OR)
	 *
	 * Customs number assigned to imported merchandise that has been left
	 * unclaimed and subsequently moved to a Customs bonded warehouse for storage.
	 */
	public const GENE_ORDE_NUMB = 'OR';

	/**
	 * General purpose message reference number (APG)
	 *
	 * A reference number identifying a general purpose message.
	 */
	public const GENE_PURP_MESS_REFE_NUMB = 'APG';

	/**
	 * Goods and Services Tax identification number (AMT)
	 *
	 * Identifier assigned to an entity by a tax authority for Goods and Services
	 * Tax (GST) related purposes.
	 */
	public const GOOD_AND_SERV_TAX_IDEN_NUMB = 'AMT';

	/**
	 * Goods declaration document identifier, Customs (ABT)
	 *
	 * [1426] Reference number, assigned or accepted by Customs, to identify a
	 * goods declaration.
	 */
	public const GOOD_DECL_DOCU_IDEN_CUST = 'ABT';

	/**
	 * Goods declaration number (AAE)
	 *
	 * Reference number assigned to a goods declaration.
	 */
	public const GOOD_DECL_NUMB = 'AAE';

	/**
	 * Goods item information (AVM)
	 *
	 * Code identifying that the reference number given applies to the goods item
	 * information segment group in the referred message.
	 */
	public const GOOD_ITEM_INFO = 'AVM';

	/**
	 * Government agency reference number (AEA)
	 *
	 * Coded reference number that pertains to the business of a government
	 * agency.
	 */
	public const GOVE_AGEN_REFE_NUMB = 'AEA';

	/**
	 * Government bill of lading (AKH)
	 *
	 * Bill of lading as defined by the government.
	 */
	public const GOVE_BILL_OF_LADI = 'AKH';

	/**
	 * Government contract number (GC)
	 *
	 * Number assigned to a specific government/public contract.
	 */
	public const GOVE_CONT_NUMB = 'GC';

	/**
	 * Government quality assurance and control level Number (AMI)
	 *
	 * A number which identifies the level of quality assurance and control
	 * required by the government for an article.
	 */
	public const GOVE_QUAL_ASSU_AND_CONT_LEVE_NUMB = 'AMI';

	/**
	 * Government reference number (GN)
	 *
	 * A number that identifies a government reference.
	 */
	public const GOVE_REFE_NUMB = 'GN';

	/**
	 * Grid operator's customer reference number (CAZ)
	 *
	 * A number, assigned by a grid operator, to reference a customer.
	 */
	public const GRID_OPER_CUST_REFE_NUMB = 'CAZ';

	/**
	 * Group accounting (ADT)
	 *
	 * A number that identifies group accounting.
	 */
	public const GROU_ACCO = 'ADT';

	/**
	 * Group reference number (AST)
	 *
	 * The reference number identifying a group.
	 */
	public const GROU_REFE_NUMB = 'AST';

	/**
	 * Guarantee number (ATM)
	 *
	 * Number of a guarantee.
	 */
	public const GUAR_NUMB = 'ATM';

	/**
	 * Handling and movement reference number (AWZ)
	 *
	 * A reference number identifying a previously transmitted cargo/goods
	 * handling and movement message.
	 */
	public const HAND_AND_MOVE_REFE_NUMB = 'AWZ';

	/**
	 * Harmonised system number (HS)
	 *
	 * Number specifying the goods classification under the Harmonised Commodity
	 * Description and Coding System of the Customs Co-operation Council (CCC).
	 */
	public const HARM_SYST_NUMB = 'HS';

	/**
	 * Hash value (AVW)
	 *
	 * Contains the hash value of a related document.
	 */
	public const HASH_VALU = 'AVW';

	/**
	 * Hastening number (AMD)
	 *
	 * A number which uniquely identifies a request to hasten an action.
	 */
	public const HAST_NUMB = 'AMD';

	/**
	 * Hot roll number (ACP)
	 *
	 * Number attributed to a hot roll coil.
	 */
	public const HOT_ROLL_NUMB = 'ACP';

	/**
	 * House bill of lading number (BH)
	 *
	 * [1039] Reference number assigned to a house bill of lading.
	 */
	public const HOUS_BILL_OF_LADI_NUMB = 'BH';

	/**
	 * House waybill number (HWB)
	 *
	 * Reference number assigned to a house waybill, see: 1001 = 703.
	 */
	public const HOUS_WAYB_NUMB = 'HWB';

	/**
	 * Hygienic Certificate number, national (AWS)
	 *
	 * Nationally set Hygienic Certificate number, such as sanitary,
	 * epidemiologic.
	 */
	public const HYGI_CERT_NUMB_NATI = 'AWS';

	/**
	 * IATA Cargo Agent CASS Address number (CAS)
	 *
	 * Code issued by IATA to identify agent locations for CASS billing purposes.
	 */
	public const IATA_CARG_AGEN_CASS_ADDR_NUMB = 'CAS';

	/**
	 * IATA cargo agent code number (ICA)
	 *
	 * Code issued by IATA identify each IATA Cargo Agent whose name is entered on
	 * the Cargo Agency List.
	 */
	public const IATA_CARG_AGEN_CODE_NUMB = 'ICA';

	/**
	 * Image reference (AUI)
	 *
	 * A reference number identifying an image.
	 */
	public const IMAG_REFE = 'AUI';

	/**
	 * Immediate exportation no. for in bond movement (AFK)
	 *
	 * A number that identifies the immediate exportation number for an in bond
	 * movement.
	 */
	public const IMME_EXPO_NO_FOR_IN_BOND_MOVE = 'AFK';

	/**
	 * Immediate transportation no. for in bond movement (AFI)
	 *
	 * A number that identifies immediate transportation for in bond movement.
	 */
	public const IMME_TRAN_NO_FOR_IN_BOND_MOVE = 'AFI';

	/**
	 * Implementation version number (AOZ)
	 *
	 * Identifies a version number of an implementation.
	 */
	public const IMPL_VERS_NUMB = 'AOZ';

	/**
	 * Import clearance instruction reference number (ABS)
	 *
	 * Reference number of the import clearance instructions given by the
	 * consignor/consignee through different means.
	 */
	public const IMPO_CLEA_INST_REFE_NUMB = 'ABS';

	/**
	 * Import permit identifier (IP)
	 *
	 * [1107] Reference number to identify an import licence or permit.
	 */
	public const IMPO_PERM_IDEN = 'IP';

	/**
	 * Importer reference number (ABQ)
	 *
	 * Reference number assigned by the importer to identify a particular shipment
	 * for his own purposes.
	 */
	public const IMPO_REFE_NUMB = 'ABQ';

	/**
	 * Importer's letter of credit reference (AUG)
	 *
	 * Letter of credit reference issued by importer.
	 */
	public const IMPO_LETT_OF_CRED_REFE = 'AUG';

	/**
	 * Imputation account (ARV)
	 *
	 * An account to which an amount is to be posted.
	 */
	public const IMPU_ACCO = 'ARV';

	/**
	 * In bond number (IB)
	 *
	 * Customs assigned number that is used to control the movement of imported
	 * cargo prior to its formal Customs clearing.
	 */
	public const IN_BOND_NUMB = 'IB';

	/**
	 * Incorporated legal reference (APA)
	 *
	 * Identifies a legal reference which is deemed incorporated by reference.
	 */
	public const INCO_LEGA_REFE = 'APA';

	/**
	 * Individual transaction reference number (AIM)
	 *
	 * Reference number applying to one specific transaction.
	 */
	public const INDI_TRAN_REFE_NUMB = 'AIM';

	/**
	 * Initial sample inspection report number (II)
	 *
	 * Inspection report number given to the initial sample inspection.
	 */
	public const INIT_SAMP_INSP_REPO_NUMB = 'II';

	/**
	 * Inland transport order number (ADN)
	 *
	 * Reference number assigned by the principal to the transport order for
	 * inland carriage.
	 */
	public const INLA_TRAN_ORDE_NUMB = 'ADN';

	/**
	 * Institut Belgo-Luxembourgeois de Codification (IBLC) number (ATR)
	 *
	 * An identification number assigned by the Luxembourg National Bank to a
	 * business in Luxembourg.
	 */
	public const INST_BELG_DE_CODI_IBLC_NUMB = 'ATR';

	/**
	 * Institute of Security and Future Market Development (ISFMD) serial number (AQX)
	 *
	 * A number used to identify a public but not publicly traded company.
	 */
	public const INST_OF_SECU_AND_FUTU_MARK_DEVE_ISFM_SERI_NUMB = 'AQX';

	/**
	 * Instruction for returns number (AXB)
	 *
	 * A reference number identifying a previously communicated instruction for
	 * return message.
	 */
	public const INST_FOR_RETU_NUMB = 'AXB';

	/**
	 * Instruction to despatch reference number (AXA)
	 *
	 * A reference number identifying a previously transmitted instruction to
	 * despatch message.
	 */
	public const INST_TO_DESP_REFE_NUMB = 'AXA';

	/**
	 * Insurance certificate reference number (ICE)
	 *
	 * A number that identifies an insurance certificate reference.
	 */
	public const INSU_CERT_REFE_NUMB = 'ICE';

	/**
	 * Insurance contract reference number (ICO)
	 *
	 * A number that identifies an insurance contract reference.
	 */
	public const INSU_CONT_REFE_NUMB = 'ICO';

	/**
	 * Insurer assigned reference number (AMM)
	 *
	 * A unique reference number assigned by the insurer.
	 */
	public const INSU_ASSI_REFE_NUMB = 'AMM';

	/**
	 * Integrated logistic support cross reference number (AMU)
	 *
	 * Provides the identification of the reference which allows cross referencing
	 * of items between different areas of integrated logistics support.
	 */
	public const INTE_LOGI_SUPP_CROS_REFE_NUMB = 'AMU';

	/**
	 * Interchange number new (INN)
	 *
	 * Number assigned by the interchange sender to identify one specific
	 * interchange. This number points to the actual interchange.
	 */
	public const INTE_NUMB_NEW = 'INN';

	/**
	 * Interchange number old (INO)
	 *
	 * Number assigned by the interchange sender to identify one specific
	 * interchange. This number points to the previous interchange.
	 */
	public const INTE_NUMB_OLD = 'INO';

	/**
	 * Intermediary broker (INB)
	 *
	 * A number that identifies an intermediary broker.
	 */
	public const INTE_BROK = 'INB';

	/**
	 * Internal customer number (IT)
	 *
	 * Number assigned by a seller, supplier etc. to identify a customer within
	 * his enterprise.
	 */
	public const INTE_CUST_NUMB = 'IT';

	/**
	 * Internal data process number (AWG)
	 *
	 * A number identifying an internal data process.
	 */
	public const INTE_DATA_PROC_NUMB = 'AWG';

	/**
	 * Internal order number (IL)
	 *
	 * Number assigned to an order for internal handling/follow up.
	 */
	public const INTE_ORDE_NUMB = 'IL';

	/**
	 * Internal vendor number (IA)
	 *
	 * Number identifying the company-internal vending department/unit.
	 */
	public const INTE_VEND_NUMB = 'IA';

	/**
	 * International assessment log number (AQH)
	 *
	 * The reference log number assigned to a Data Maintenance Request (DMR)
	 * changed in international assessment.
	 */
	public const INTE_ASSE_LOG_NUMB = 'AQH';

	/**
	 * International assessment log number, child Data Maintenance Request (DMR) (AQJ)
	 *
	 * The reference log number assigned to a Data Maintenance Request (DMR)
	 * changed in international assessment that is a child to the current DMR.
	 */
	public const INTE_ASSE_LOG_NUMB_CHIL_DATA_MAIN_REQU_DMR = 'AQJ';

	/**
	 * International assessment log number, parent Data Maintenance Request (DMR) (AQI)
	 *
	 * The reference log number assigned to a Data Maintenance Request (DMR)
	 * changed in international assessment that is a parent to the current DMR.
	 */
	public const INTE_ASSE_LOG_NUMB_PARE_DATA_MAIN_REQU_DMR = 'AQI';

	/**
	 * International flight number (AGR)
	 *
	 * Airline flight number assigned to a flight originating and terminating
	 * across national borders.
	 */
	public const INTE_FLIG_NUMB = 'AGR';

	/**
	 * International Standard Industrial Classification (ISIC) code (AUY)
	 *
	 * A code specifying an international standard industrial classification.
	 */
	public const INTE_STAN_INDU_CLAS_ISIC_CODE = 'AUY';

	/**
	 * Intra-plant routing (ABV)
	 *
	 * To define routing within a plant.
	 */
	public const INTR_ROUT = 'ABV';

	/**
	 * Inventory report reference number (API)
	 *
	 * A reference number identifying an inventory report.
	 */
	public const INVE_REPO_REFE_NUMB = 'API';

	/**
	 * Inventory report request number (AVD)
	 *
	 * Reference number assigned to a request for an inventory report.
	 */
	public const INVE_REPO_REQU_NUMB = 'AVD';

	/**
	 * Investment reference number (ASB)
	 *
	 * A reference to a specific investment.
	 */
	public const INVE_REFE_NUMB = 'ASB';

	/**
	 * Invoice document identifier (IV)
	 *
	 * [1334] Reference number to identify an invoice.
	 */
	public const INVO_DOCU_IDEN = 'IV';

	/**
	 * Invoice number suffix (IS)
	 *
	 * A number added at the end of an invoice number.
	 */
	public const INVO_NUMB_SUFF = 'IS';

	/**
	 * Invoicing data sheet reference number (APH)
	 *
	 * A reference number identifying an invoicing data sheet.
	 */
	public const INVO_DATA_SHEE_REFE_NUMB = 'APH';

	/**
	 * Iron charge number (ACO)
	 *
	 * Number attributed to the iron charge for the production of steel products.
	 */
	public const IRON_CHAR_NUMB = 'ACO';

	/**
	 * Issued prescription identification (AUC)
	 *
	 * The identification of the issued prescription.
	 */
	public const ISSU_PRES_IDEN = 'AUC';

	/**
	 * Issuing bank's reference (AFR)
	 *
	 * Reference number of the issuing bank.
	 */
	public const ISSU_BANK_REFE = 'AFR';

	/**
	 * Job number (JB)
	 *
	 * [1043] Identifies a piece of work.
	 */
	public const JOB_NUMB = 'JB';

	/**
	 * Joint venture reference number (AHN)
	 *
	 * Reference number assigned to a joint venture agreement.
	 */
	public const JOIN_VENT_REFE_NUMB = 'AHN';

	/**
	 * Judgment number (ATC)
	 *
	 * A reference number identifying the legal decision.
	 */
	public const JUDG_NUMB = 'ATC';

	/**
	 * Kamer Van Koophandel (KVK) number (ATQ)
	 *
	 * An identification number assigned by the Dutch Chamber of Commerce to a
	 * business in the Netherlands.
	 */
	public const KAME_VAN_KOOP_KVK_NUMB = 'ATQ';

	/**
	 * Laboratory registration number (AHH)
	 *
	 * Reference number is the official registration number of the laboratory.
	 */
	public const LABO_REGI_NUMB = 'AHH';

	/**
	 * Last received banking status message reference (ATF)
	 *
	 * Reference number of the latest received banking status message.
	 */
	public const LAST_RECE_BANK_STAT_MESS_REFE = 'ATF';

	/**
	 * Latest accounting entry record reference (AWP)
	 *
	 * Code identifying the reference of the latest accounting entry record.
	 */
	public const LATE_ACCO_ENTR_RECO_REFE = 'AWP';

	/**
	 * Lease contract reference (AKV)
	 *
	 * Reference number of the lease contract.
	 */
	public const LEAS_CONT_REFE = 'AKV';

	/**
	 * Letter of credit number (LC)
	 *
	 * Reference number identifying the letter of credit document.
	 */
	public const LETT_OF_CRED_NUMB = 'LC';

	/**
	 * Lloyd's claims office reference (ADW)
	 *
	 * A number that identifies a Lloyd's claims office.
	 */
	public const LLOY_CLAI_OFFI_REFE = 'ADW';

	/**
	 * Load planning number (LO)
	 *
	 * The reference that identifies the load planning number.
	 */
	public const LOAD_PLAN_NUMB = 'LO';

	/**
	 * Loading authorisation identifier (LAN)
	 *
	 * [4092] Identifier assigned to the loading authorisation granted by the
	 * forwarding location e.g. railway or airport, when the consignment is
	 * subject to traffic limitations.
	 */
	public const LOAD_AUTH_IDEN = 'LAN';

	/**
	 * Loan (ADC)
	 *
	 * Reference number for loan allocated by lending financial institution.
	 */
	public const LOAN = 'ADC';

	/**
	 * Local Reference Number (AVZ)
	 *
	 * Number assigned by a national customs authority to an Entry Summary
	 * Declaration.
	 */
	public const LOCA_REFE_NUMB = 'AVZ';

	/**
	 * Lockbox (LB)
	 *
	 * Type of cash management system offered by financial institutions to provide
	 * for collection of customers 'receivables'.
	 */
	public const LOCKBOX = 'LB';

	/**
	 * Loss/event number (ACU)
	 *
	 * To reference to the unique number that is assigned to each major loss
	 * hitting the reinsurance industry.
	 */
	public const LOSS_NUMB = 'ACU';

	/**
	 * Lower number in range (LAR)
	 *
	 * Lower number in a range of numbers.
	 */
	public const LOWE_NUMB_IN_RANG = 'LAR';

	/**
	 * Mailing reference number (MRN)
	 *
	 * Identifies the party designated by the importer to receive certain customs
	 * correspondence in lieu of its being mailed directly to the importer.
	 */
	public const MAIL_REFE_NUMB = 'MRN';

	/**
	 * Major force program number (AHF)
	 *
	 * Reference number according to Major Force Program (US).
	 */
	public const MAJO_FORC_PROG_NUMB = 'AHF';

	/**
	 * Mandate Reference (AVS)
	 *
	 * Reference to a specific mandate given by the relevant party for underlying
	 * business or action.
	 */
	public const MAND_REFE = 'AVS';

	/**
	 * Manual processing authority number (AHV)
	 *
	 * Number allocated to allow the manual processing of an entity.
	 */
	public const MANU_PROC_AUTH_NUMB = 'AHV';

	/**
	 * Manufacturer defined repair rates reference (APW)
	 *
	 * Reference assigned by a manufacturer to their repair rates.
	 */
	public const MANU_DEFI_REPA_RATE_REFE = 'APW';

	/**
	 * Manufacturer's material safety data sheet number (MSS)
	 *
	 * A number that identifies a manufacturer's material safety data sheet.
	 */
	public const MANU_MATE_SAFE_DATA_SHEE_NUMB = 'MSS';

	/**
	 * Manufacturer's part number (MF)
	 *
	 * Reference number assigned by the manufacturer to his product or part.
	 */
	public const MANU_PART_NUMB = 'MF';

	/**
	 * Manufacturing order number (MH)
	 *
	 * Reference number assigned by manufacturer for a given production quantity
	 * of products.
	 */
	public const MANU_ORDE_NUMB = 'MH';

	/**
	 * Manufacturing quality agreement number (AUL)
	 *
	 * Reference number of a manufacturing quality agreement.
	 */
	public const MANU_QUAL_AGRE_NUMB = 'AUL';

	/**
	 * Marketing plan identification number (MPIN) (AUW)
	 *
	 * Number identifying a marketing plan.
	 */
	public const MARK_PLAN_IDEN_NUMB_MPIN = 'AUW';

	/**
	 * Marking/label reference (AFF)
	 *
	 * Reference where marking/label information derives from.
	 */
	public const MARK_REFE = 'AFF';

	/**
	 * Master account number (ASS)
	 *
	 * A reference number identifying a master account.
	 */
	public const MAST_ACCO_NUMB = 'ASS';

	/**
	 * Master air waybill number (MWB)
	 *
	 * Reference number assigned to a master air waybill, see: 1001 = 741.
	 */
	public const MAST_AIR_WAYB_NUMB = 'MWB';

	/**
	 * Master bill of lading number (MB)
	 *
	 * Reference number assigned to a master bill of lading, see: 1001 = 704.
	 */
	public const MAST_BILL_OF_LADI_NUMB = 'MB';

	/**
	 * Master label number (AAT)
	 *
	 * Identifies the master label number of any package type.
	 */
	public const MAST_LABE_NUMB = 'AAT';

	/**
	 * Master solicitation procedures, terms, and conditions number (AJM)
	 *
	 * A number indicating a master solicitation containing procedures, terms and
	 * conditions.
	 */
	public const MAST_SOLI_PROC_TERM_AND_COND_NUMB = 'AJM';

	/**
	 * Matching of entries, balanced (CAT)
	 *
	 * Reference to a balanced matching of entries.
	 */
	public const MATC_OF_ENTR_BALA = 'CAT';

	/**
	 * Matching of entries, unbalanced (CAV)
	 *
	 * Reference to an unbalanced matching of entries.
	 */
	public const MATC_OF_ENTR_UNBA = 'CAV';

	/**
	 * Matured certificate of deposit (ADB)
	 *
	 * Reference number for certificate of deposit allocated by issuing financial
	 * institution.
	 */
	public const MATU_CERT_OF_DEPO = 'ADB';

	/**
	 * Meat cutting plant approval number (AVH)
	 *
	 * Veterinary licence number allocated by a national authority to a meat
	 * cutting plant.
	 */
	public const MEAT_CUTT_PLAN_APPR_NUMB = 'AVH';

	/**
	 * Meat processing establishment registration number (AHS)
	 *
	 * Registration number allocated to a registered meat packing establishment by
	 * the local quarantine and inspection authority.
	 */
	public const MEAT_PROC_ESTA_REGI_NUMB = 'AHS';

	/**
	 * Member number (AGU)
	 *
	 * Reference number assigned to a person as a member of a group of persons or
	 * a service scheme.
	 */
	public const MEMB_NUMB = 'AGU';

	/**
	 * Message batch number (ALL)
	 *
	 * A number identifying a batch of messages.
	 */
	public const MESS_BATC_NUMB = 'ALL';

	/**
	 * Message design group number (AQL)
	 *
	 * Reference number for a message design group.
	 */
	public const MESS_DESI_GROU_NUMB = 'AQL';

	/**
	 * Message recipient (MR)
	 *
	 * A number that identifies the message recipient.
	 */
	public const MESS_RECI = 'MR';

	/**
	 * Message sender (MS)
	 *
	 * A number that identifies the message sender.
	 */
	public const MESS_SEND = 'MS';

	/**
	 * Meter reading at the beginning of the delivery (AKK)
	 *
	 * Meter reading at the beginning of the delivery.
	 */
	public const METE_READ_AT_THE_BEGI_OF_THE_DELI = 'AKK';

	/**
	 * Meter reading at the end of delivery (AKL)
	 *
	 * Meter reading at the end of the delivery.
	 */
	public const METE_READ_AT_THE_END_OF_DELI = 'AKL';

	/**
	 * Meter unit number (MG)
	 *
	 * Number identifying a unique meter unit.
	 */
	public const METE_UNIT_NUMB = 'MG';

	/**
	 * Metered services consumption report number (AXC)
	 *
	 * A reference number identifying a previously communicated metered services
	 * consumption report.
	 */
	public const METE_SERV_CONS_REPO_NUMB = 'AXC';

	/**
	 * Metering point (AVE)
	 *
	 * Reference to a metering point.
	 */
	public const METE_POIN = 'AVE';

	/**
	 * Military Interdepartmental Purchase Request (MIPR) number (AJO)
	 *
	 * A number indicating an interdepartmental purchase request used by the
	 * military.
	 */
	public const MILI_INTE_PURC_REQU_MIPR_NUMB = 'AJO';

	/**
	 * Ministerial certificate of homologation (AIE)
	 *
	 * Certificate of approval for components which are subject to legal
	 * restrictions and must be approved by the government.
	 */
	public const MINI_CERT_OF_HOMO = 'AIE';

	/**
	 * Model (ALX)
	 *
	 * (7242) A reference used to identify a model.
	 */
	public const MODEL = 'ALX';

	/**
	 * Motor vehicle identification number (VT)
	 *
	 * (8213) Reference identifying a motor vehicle used for transport. Normally
	 * is the vehicle registration number.
	 */
	public const MOTO_VEHI_IDEN_NUMB = 'VT';

	/**
	 * Movement reference number (AVX)
	 *
	 * Number assigned by customs referencing receipt of an Entry Summary
	 * Declaration.
	 */
	public const MOVE_REFE_NUMB = 'AVX';

	/**
	 * Municipality assigned business registry number (AAR)
	 *
	 * A reference number assigned by a municipality to identify a business.
	 */
	public const MUNI_ASSI_BUSI_REGI_NUMB = 'AAR';

	/**
	 * Mutually defined reference number (ZZZ)
	 *
	 * Number based on party agreement.
	 */
	public const MUTU_DEFI_REFE_NUMB = 'ZZZ';

	/**
	 * Named bank's reference (ANM)
	 *
	 * Reference number of the named bank.
	 */
	public const NAME_BANK_REFE = 'ANM';

	/**
	 * National government business identification number (ARA)
	 *
	 * A business identification number which is assigned by a national
	 * government.
	 */
	public const NATI_GOVE_BUSI_IDEN_NUMB = 'ARA';

	/**
	 * Net area (AWJ)
	 *
	 * Reference to an area of a net.
	 */
	public const NET_AREA = 'AWJ';

	/**
	 * Net area supplier reference (AUT)
	 *
	 * A reference identifying a supplier within a net area.
	 */
	public const NET_AREA_SUPP_REFE = 'AUT';

	/**
	 * Next rental agreement number (AMB)
	 *
	 * Number to identify the next rental agreement.
	 */
	public const NEXT_RENT_AGRE_NUMB = 'AMB';

	/**
	 * Next rental agreement reason number (ALJ)
	 *
	 * Number to identify the reason for the next rental agreement.
	 */
	public const NEXT_RENT_AGRE_REAS_NUMB = 'ALJ';

	/**
	 * Nomenclature Activity Classification Economy (NACE) identifier (AQS)
	 *
	 * A European industry classification code used to identify the activity of a
	 * company.
	 */
	public const NOME_ACTI_CLAS_ECON_NACE_IDEN = 'AQS';

	/**
	 * Nomination number (AHG)
	 *
	 * Reference number assigned by a shipper to a request/ commitment-to-ship on
	 * a pipeline system.
	 */
	public const NOMI_NUMB = 'AHG';

	/**
	 * Non-negotiable maritime transport document number (AEX)
	 *
	 * Reference number assigned to a sea waybill, see: 1001 = 712.
	 */
	public const NONN_MARI_TRAN_DOCU_NUMB = 'AEX';

	/**
	 * Norme Activite Francaise (NAF) identifier (AQT)
	 *
	 * A French industry classification code assigned by the French government to
	 * identify the activity of a company.
	 */
	public const NORM_ACTI_FRAN_NAF_IDEN = 'AQT';

	/**
	 * North American hazardous goods classification number (NA)
	 *
	 * Reference to materials designated as hazardous for purposes of
	 * transportation in North American commerce.
	 */
	public const NORT_AMER_HAZA_GOOD_CLAS_NUMB = 'NA';

	/**
	 * Nota Fiscal (NF)
	 *
	 * Nota Fiscal is a registration number for shipments / deliveries within
	 * Brazil, issued by the local tax authorities and mandated for each shipment.
	 */
	public const NOTA_FISC = 'NF';

	/**
	 * NOTIfication for COLlection number (NOTICOL) (ALZ)
	 *
	 * A reference assigned by a consignor to a notification document which
	 * indicates the availability of goods for collection.
	 */
	public const NOTI_FOR_COLL_NUMB_NOTI = 'ALZ';

	/**
	 * Number of temporary importation document (AGM)
	 *
	 * Number assigned by customs to identify consignment in transit.
	 */
	public const NUMB_OF_TEMP_IMPO_DOCU = 'AGM';

	/**
	 * Numero de Identificacion Tributaria (NIT) (ARE)
	 *
	 * A number assigned by the government to a business in some Latin American
	 * countries.
	 */
	public const NUME_DE_IDEN_TRIB_NIT = 'ARE';

	/**
	 * Offer number (AAG)
	 *
	 * (1332) Reference number assigned by issuing party to an offer.
	 */
	public const OFFE_NUMB = 'AAG';

	/**
	 * Order acknowledgement document identifier (AAA)
	 *
	 * [1018] Reference number identifying the acknowledgement of an order.
	 */
	public const ORDE_ACKN_DOCU_IDEN = 'AAA';

	/**
	 * Order document identifier, buyer assigned (ON)
	 *
	 * [1022] Identifier assigned by the buyer to an order.
	 */
	public const ORDE_DOCU_IDEN_BUYE_ASSI = 'ON';

	/**
	 * Order number (vendor) (VN)
	 *
	 * Reference number assigned by supplier to a buyer's purchase order.
	 */
	public const ORDE_NUMB_VEND = 'VN';

	/**
	 * Order shipment grouping reference (CBB)
	 *
	 * A reference number identifying the grouping of purchase orders into one
	 * shipment.
	 */
	public const ORDE_SHIP_GROU_REFE = 'CBB';

	/**
	 * Order status enquiry number (AXD)
	 *
	 * A reference number to a previously sent order status enquiry.
	 */
	public const ORDE_STAT_ENQU_NUMB = 'AXD';

	/**
	 * Ordering customer consignment reference number (ADL)
	 *
	 * Reference number assigned to the consignment by the ordering customer.
	 */
	public const ORDE_CUST_CONS_REFE_NUMB = 'ADL';

	/**
	 * Ordering customer's second reference number (AKI)
	 *
	 * Ordering customer's second reference number.
	 */
	public const ORDE_CUST_SECO_REFE_NUMB = 'AKI';

	/**
	 * Organisation breakdown structure (AOM)
	 *
	 * A structure reference that identifies the breakdown of an organisation.
	 */
	public const ORGA_BREA_STRU = 'AOM';

	/**
	 * Original certificate number (AIR)
	 *
	 * Number giving reference to an original certificate number.
	 */
	public const ORIG_CERT_NUMB = 'AIR';

	/**
	 * Original filing number (ARN)
	 *
	 * A number assigned to the original filing.
	 */
	public const ORIG_FILI_NUMB = 'ARN';

	/**
	 * Original Mandate Reference (AVR)
	 *
	 * Reference to a specific related original mandate given by the relevant
	 * party for underlying business or action in case of reference or mandate
	 * change.
	 */
	public const ORIG_MAND_REFE = 'AVR';

	/**
	 * Original purchase order (OP)
	 *
	 * Reference to the order previously sent.
	 */
	public const ORIG_PURC_ORDE = 'OP';

	/**
	 * Original submitter log number (APX)
	 *
	 * A control number assigned by the original submitter.
	 */
	public const ORIG_SUBM_LOG_NUMB = 'APX';

	/**
	 * Original submitter, child Data Maintenance Request (DMR) log number (APZ)
	 *
	 * A Data Maintenance Request (DMR) original submitter's reference log number
	 * for a child DMR.
	 */
	public const ORIG_SUBM_CHIL_DATA_MAIN_REQU_DMR_LOG_NUMB = 'APZ';

	/**
	 * Original submitter, parent Data Maintenance Request (DMR) log number (APY)
	 *
	 * A Data Maintenance Request (DMR) original submitter's reference log number
	 * for the parent DMR.
	 */
	public const ORIG_SUBM_PARE_DATA_MAIN_REQU_DMR_LOG_NUMB = 'APY';

	/**
	 * Originator's reference (ABO)
	 *
	 * A unique reference assigned by the originator.
	 */
	public const ORIG_REFE = 'ABO';

	/**
	 * Outerpackaging unit identification (ACI)
	 *
	 * Identifying marks on packing units contained within an outermost shipping
	 * unit.
	 */
	public const OUTE_UNIT_IDEN = 'ACI';

	/**
	 * Package number (CW)
	 *
	 * (7070) Reference number identifying a package or carton within a
	 * consignment.
	 */
	public const PACK_NUMB = 'CW';

	/**
	 * Packaging specification number (AHA)
	 *
	 * Reference number of documentation specifying the technical detail of
	 * packaging requirements.
	 */
	public const PACK_SPEC_NUMB = 'AHA';

	/**
	 * Packaging unit identification (ACH)
	 *
	 * Identifying marks on packing units.
	 */
	public const PACK_UNIT_IDEN = 'ACH';

	/**
	 * Packing list number (PK)
	 *
	 * [1014] Reference number assigned to a packing list.
	 */
	public const PACK_LIST_NUMB = 'PK';

	/**
	 * Packing plant number (AIQ)
	 *
	 * Number to identify packing establishment.
	 */
	public const PACK_PLAN_NUMB = 'AIQ';

	/**
	 * Paragraph (AJJ)
	 *
	 * A reference indicating a paragraph cited as the source of information.
	 */
	public const PARAGRAPH = 'AJJ';

	/**
	 * Parent file (AND)
	 *
	 * Identifies the parent file in a structure of related files.
	 */
	public const PARE_FILE = 'AND';

	/**
	 * Part reference indicator in a drawing (AJA)
	 *
	 * To designate the number which provides a cross reference between parts
	 * contained in a drawing and a parts catalogue.
	 */
	public const PART_REFE_INDI_IN_A_DRAW = 'AJA';

	/**
	 * Partial shipment identifier (AAP)
	 *
	 * [1310] Identifier of a shipment which is part of an order.
	 */
	public const PART_SHIP_IDEN = 'AAP';

	/**
	 * Party information message reference (ASG)
	 *
	 * Reference identifying a party information message.
	 */
	public const PART_INFO_MESS_REFE = 'ASG';

	/**
	 * Party reference (AUB)
	 *
	 * The reference to a party.
	 */
	public const PART_REFE = 'AUB';

	/**
	 * Party sequence number (APM)
	 *
	 * Reference identifying a party sequence number.
	 */
	public const PART_SEQU_NUMB = 'APM';

	/**
	 * Passenger reservation number (AVF)
	 *
	 * Number assigned by the travel supplier to identify the passenger
	 * reservation.
	 */
	public const PASS_RESE_NUMB = 'AVF';

	/**
	 * Passport number (AIG)
	 *
	 * Number assigned to a passport.
	 */
	public const PASS_NUMB = 'AIG';

	/**
	 * Password (ASO)
	 *
	 * Code used for authentication purposes.
	 */
	public const PASSWORD = 'ASO';

	/**
	 * Patron number (ARF)
	 *
	 * A number assigned by the government to a business in some Latin American
	 * countries. Note that "Patron" is a Spanish word, it is not a person who
	 * gives financial or other support.
	 */
	public const PATR_NUMB = 'ARF';

	/**
	 * Payer's financial institution account number (PB)
	 *
	 * Originated company account number (ACH transfer), check, draft or wire.
	 */
	public const PAYE_FINA_INST_ACCO_NUMB = 'PB';

	/**
	 * Payee's financial institution transit routing No. (RT)
	 *
	 * RDFI Transit routing number (ACH transfer).
	 */
	public const PAYE_FINA_INST_TRAN_ROUT_NO = 'RT';

	/**
	 * Payer's reference number (AHK)
	 *
	 * Reference number of the party who pays.
	 */
	public const PAYE_REFE_NUMB = 'AHK';

	/**
	 * Payer's financial institution transit routing No.(ACH transfers) (RR)
	 *
	 * ODFI (ACH transfer).
	 */
	public const PAYE_FINA_INST_TRAN_ROUT_NOAC_TRAN = 'RR';

	/**
	 * Payment in advance request reference (ANC)
	 *
	 * A reference to a request for payment in advance.
	 */
	public const PAYM_IN_ADVA_REQU_REFE = 'ANC';

	/**
	 * Payment instalment reference number (APB)
	 *
	 * A reference number given to a payment instalment to identify a specific
	 * instance of payment of a debt which can be paid at specified intervals.
	 */
	public const PAYM_INST_REFE_NUMB = 'APB';

	/**
	 * Payment order number (AEK)
	 *
	 * A number that identifies a payment order.
	 */
	public const PAYM_ORDE_NUMB = 'AEK';

	/**
	 * Payment plan reference (AMJ)
	 *
	 * A number which uniquely identifies a payment plan.
	 */
	public const PAYM_PLAN_REFE = 'AMJ';

	/**
	 * Payment reference (PQ)
	 *
	 * Reference number assigned to a payment.
	 */
	public const PAYM_REFE = 'PQ';

	/**
	 * Payment valuation number (AFY)
	 *
	 * Reference number assigned to a payment valuation.
	 */
	public const PAYM_VALU_NUMB = 'AFY';

	/**
	 * Payroll deduction advice reference (AXR)
	 *
	 * A reference number identifying a payroll deduction advice.
	 */
	public const PAYR_DEDU_ADVI_REFE = 'AXR';

	/**
	 * Payroll number (AGZ)
	 *
	 * Reference number assigned to the payroll of an organisation.
	 */
	public const PAYR_NUMB = 'AGZ';

	/**
	 * Performed prescription identification (AUH)
	 *
	 * The identification of the prescription that has been carried into effect.
	 */
	public const PERF_PRES_IDEN = 'AUH';

	/**
	 * Person registration number (AVP)
	 *
	 * A number assigned to an individual.
	 */
	public const PERS_REGI_NUMB = 'AVP';

	/**
	 * Personal identity card number (ARJ)
	 *
	 * An identity card number assigned to a person.
	 */
	public const PERS_IDEN_CARD_NUMB = 'ARJ';

	/**
	 * Phone number (AWV)
	 *
	 * A sequence of digits used to call from one telephone line to another in a
	 * public telephone network.
	 */
	public const PHON_NUMB = 'AWV';

	/**
	 * Physical inventory recount reference number (ALN)
	 *
	 * A reference to a re-count of physically held inventory.
	 */
	public const PHYS_INVE_RECO_REFE_NUMB = 'ALN';

	/**
	 * Physical medium (ASZ)
	 *
	 * Identifies the physical medium.
	 */
	public const PHYS_MEDI = 'ASZ';

	/**
	 * Pick-up sheet number (AWU)
	 *
	 * Reference number assigned to a pick-up sheet.
	 */
	public const PICK_SHEE_NUMB = 'AWU';

	/**
	 * Picture of a generic product (ASL)
	 *
	 * Reference identifying a picture of a generic product.
	 */
	public const PICT_OF_A_GENE_PROD = 'ASL';

	/**
	 * Picture of actual product (ASK)
	 *
	 * Reference identifying the picture of an actual product.
	 */
	public const PICT_OF_ACTU_PROD = 'ASK';

	/**
	 * Pilotage services exemption number (AVO)
	 *
	 * Number identifying the permit to not use pilotage services.
	 */
	public const PILO_SERV_EXEM_NUMB = 'AVO';

	/**
	 * Pipeline number (AMZ)
	 *
	 * Number to identify a pipeline.
	 */
	public const PIPE_NUMB = 'AMZ';

	/**
	 * Place of packing approval number (AVQ)
	 *
	 * Approval Number of the place where goods are packaged.
	 */
	public const PLAC_OF_PACK_APPR_NUMB = 'AVQ';

	/**
	 * Place of positioning reference (AUA)
	 *
	 * Identifies the reference pertaining to the place of positioning.
	 */
	public const PLAC_OF_POSI_REFE = 'AUA';

	/**
	 * Planning package (AOT)
	 *
	 * A reference for a planning package of work.
	 */
	public const PLAN_PACK = 'AOT';

	/**
	 * Plant number (PE)
	 *
	 * A number that identifies a plant.
	 */
	public const PLAN_NUMB = 'PE';

	/**
	 * Plot file (ANH)
	 *
	 * Reference number indicating that the file is a plot file.
	 */
	public const PLOT_FILE = 'ANH';

	/**
	 * Policy form number (AWI)
	 *
	 * Number assigned to a policy form.
	 */
	public const POLI_FORM_NUMB = 'AWI';

	/**
	 * Policy number (AKZ)
	 *
	 * Number assigned to a policy.
	 */
	public const POLI_NUMB = 'AKZ';

	/**
	 * Post-entry reference (AEJ)
	 *
	 * Reference to a message related to a post-entry.
	 */
	public const POST_REFE = 'AEJ';

	/**
	 * Pre-agreement number (AXN)
	 *
	 * A reference number identifying a pre-agreement.
	 */
	public const PREA_NUMB = 'AXN';

	/**
	 * Premium rate table (AMO)
	 *
	 * Identifies the premium rate table.
	 */
	public const PREM_RATE_TABL = 'AMO';

	/**
	 * Presenting bank's reference (ANS)
	 *
	 * Reference number of the presenting bank.
	 */
	public const PRES_BANK_REFE = 'ANS';

	/**
	 * Previous banking status message reference (ATE)
	 *
	 * Message reference number of the previous banking status message being
	 * responded to.
	 */
	public const PREV_BANK_STAT_MESS_REFE = 'ATE';

	/**
	 * Previous cargo control number (XP)
	 *
	 * Where a consignment is deconsolidated and/or transferred to the control of
	 * another carrier or freight forwarder (e.g. housebill, abstract) this
	 * references the previous (e.g. master) cargo control number.
	 */
	public const PREV_CARG_CONT_NUMB = 'XP';

	/**
	 * Previous credit advice reference number (ALD)
	 *
	 * Reference number of the previous "Credit advice" message.
	 */
	public const PREV_CRED_ADVI_REFE_NUMB = 'ALD';

	/**
	 * Previous delivery instruction number (AIF)
	 *
	 * The identification of a previous delivery instruction.
	 */
	public const PREV_DELI_INST_NUMB = 'AIF';

	/**
	 * Previous delivery schedule number (ALM)
	 *
	 * A reference number identifying a previous delivery schedule.
	 */
	public const PREV_DELI_SCHE_NUMB = 'ALM';

	/**
	 * Previous highest schedule number (SH)
	 *
	 * Number of the latest schedule of a previous period (ODETTE DELINS).
	 */
	public const PREV_HIGH_SCHE_NUMB = 'SH';

	/**
	 * Previous invoice number (OI)
	 *
	 * Reference number identifying a previously issued invoice.
	 */
	public const PREV_INVO_NUMB = 'OI';

	/**
	 * Previous member number (AGV)
	 *
	 * Reference number previously assigned to a member.
	 */
	public const PREV_MEMB_NUMB = 'AGV';

	/**
	 * Previous rental agreement number (ALI)
	 *
	 * Number to identify the previous rental agreement number.
	 */
	public const PREV_RENT_AGRE_NUMB = 'ALI';

	/**
	 * Previous request for metered reading reference number (AMA)
	 *
	 * Number to identify a previous request for a recording or reading of a
	 * measuring device.
	 */
	public const PREV_REQU_FOR_METE_READ_REFE_NUMB = 'AMA';

	/**
	 * Previous scheme/plan number (AGX)
	 *
	 * Reference number previously assigned to a service scheme or plan.
	 */
	public const PREV_SCHE_NUMB = 'AGX';

	/**
	 * Previous tax control number (ALT)
	 *
	 * A reference number identifying a previous tax control number.
	 */
	public const PREV_TAX_CONT_NUMB = 'ALT';

	/**
	 * Price list number (PL)
	 *
	 * Reference number assigned to a price list.
	 */
	public const PRIC_LIST_NUMB = 'PL';

	/**
	 * Price list version number (PI)
	 *
	 * A number that identifies the version of a price list.
	 */
	public const PRIC_LIST_VERS_NUMB = 'PI';

	/**
	 * Price quote number (PR)
	 *
	 * Reference number assigned by the seller to a quote.
	 */
	public const PRIC_QUOT_NUMB = 'PR';

	/**
	 * Price variation formula reference number (APK)
	 *
	 * The reference number which identifies a price variation formula.
	 */
	public const PRIC_VARI_FORM_REFE_NUMB = 'APK';

	/**
	 * Price/sales catalogue response reference number (APF)
	 *
	 * A reference number identifying a response to a price/sales catalogue.
	 */
	public const PRIC_CATA_RESP_REFE_NUMB = 'APF';

	/**
	 * Primary reference (AES)
	 *
	 * A number that identifies the primary reference.
	 */
	public const PRIM_REFE = 'AES';

	/**
	 * Prime contractor contract number (PF)
	 *
	 * Reference number assigned by the client to the contract of the prime
	 * contractor.
	 */
	public const PRIM_CONT_CONT_NUMB = 'PF';

	/**
	 * Principal reference number (ACL)
	 *
	 * A number that identifies the principal reference.
	 */
	public const PRIN_REFE_NUMB = 'ACL';

	/**
	 * Principal's bank reference (ANR)
	 *
	 * Reference number of the principal's bank.
	 */
	public const PRIN_BANK_REFE = 'ANR';

	/**
	 * Principal's reference (AOH)
	 *
	 * Reference number of the principal.
	 */
	public const PRIN_REFE = 'AOH';

	/**
	 * Prior contractor registration number (ARY)
	 *
	 * A previous reference number used to identify a contractor.
	 */
	public const PRIO_CONT_REGI_NUMB = 'ARY';

	/**
	 * Prior Data Universal Number System (DUNS) number (ARB)
	 *
	 * A previously assigned Data Universal Number System (DUNS) number.
	 */
	public const PRIO_DATA_UNIV_NUMB_SYST_DUNS_NUMB = 'ARB';

	/**
	 * Prior policy number (AKY)
	 *
	 * The number of the prior policy.
	 */
	public const PRIO_POLI_NUMB = 'AKY';

	/**
	 * Prior purchase order number (PW)
	 *
	 * Reference number of a purchase order previously sent to the supplier.
	 */
	public const PRIO_PURC_ORDE_NUMB = 'PW';

	/**
	 * Prior trading partner identification number (ASN)
	 *
	 * Code specifying an identification number previously assigned to a trading
	 * partner.
	 */
	public const PRIO_TRAD_PART_IDEN_NUMB = 'ASN';

	/**
	 * Processing plant number (AIS)
	 *
	 * Number to identify processing plant.
	 */
	public const PROC_PLAN_NUMB = 'AIS';

	/**
	 * Procurement budget number (ALA)
	 *
	 * A number which uniquely identifies a procurement budget against which
	 * commitments or invoices can be allocated.
	 */
	public const PROC_BUDG_NUMB = 'ALA';

	/**
	 * Product certification number (AXO)
	 *
	 * Number assigned by a governing body (or their agents) to a product which
	 * certifies compliance with a standard.
	 */
	public const PROD_CERT_NUMB = 'AXO';

	/**
	 * Product change authority number (AKQ)
	 *
	 * Number which authorises a change in form, fit or function of a product.
	 */
	public const PROD_CHAN_AUTH_NUMB = 'AKQ';

	/**
	 * Product characteristics directory (AVB)
	 *
	 * A reference to a product characteristics directory.
	 */
	public const PROD_CHAR_DIRE = 'AVB';

	/**
	 * Product data file number (ASV)
	 *
	 * The number of a product data file.
	 */
	public const PROD_DATA_FILE_NUMB = 'ASV';

	/**
	 * Product inquiry number (AXF)
	 *
	 * A reference number identifying a previously communicated product inquiry.
	 */
	public const PROD_INQU_NUMB = 'AXF';

	/**
	 * Product reservation number (AEO)
	 *
	 * Number assigned by seller to identify reservation of specified products.
	 */
	public const PROD_RESE_NUMB = 'AEO';

	/**
	 * Product sourcing agreement number (AIN)
	 *
	 * Reference number assigned to a product sourcing agreement.
	 */
	public const PROD_SOUR_AGRE_NUMB = 'AIN';

	/**
	 * Product specification reference number (AXQ)
	 *
	 * Number assigned by the issuer to his product specification.
	 */
	public const PROD_SPEC_REFE_NUMB = 'AXQ';

	/**
	 * Production code (PC)
	 *
	 * Number assigned by the manufacturer to a specified article or batch to
	 * identify the manufacturing date etc. for subsequent reference.
	 */
	public const PROD_CODE = 'PC';

	/**
	 * Profile number (AMG)
	 *
	 * Reference number allocated to a discrete set of criteria.
	 */
	public const PROF_NUMB = 'AMG';

	/**
	 * Proforma invoice document identifier (AAB)
	 *
	 * [1088] Reference number to identify a proforma invoice.
	 */
	public const PROF_INVO_DOCU_IDEN = 'AAB';

	/**
	 * Project number (AEP)
	 *
	 * Reference number assigned to a project.
	 */
	public const PROJ_NUMB = 'AEP';

	/**
	 * Project specification number (AER)
	 *
	 * Reference number identifying a project specification.
	 */
	public const PROJ_SPEC_NUMB = 'AER';

	/**
	 * Promotion deal number (PD)
	 *
	 * Number assigned by a vendor to a special promotion activity.
	 */
	public const PROM_DEAL_NUMB = 'PD';

	/**
	 * Proof of delivery reference number (ASI)
	 *
	 * A reference number identifying a proof of delivery which is generated by
	 * the goods recipient.
	 */
	public const PROO_OF_DELI_REFE_NUMB = 'ASI';

	/**
	 * Proposed purchase order reference number (AUJ)
	 *
	 * A reference number assigned to a proposed purchase order.
	 */
	public const PROP_PURC_ORDE_REFE_NUMB = 'AUJ';

	/**
	 * Public filing registration number (ARP)
	 *
	 * A number assigned at the time of registration of a public filing.
	 */
	public const PUBL_FILI_REGI_NUMB = 'ARP';

	/**
	 * Publication issue number (ARM)
	 *
	 * A number assigned to identify a publication issue.
	 */
	public const PUBL_ISSU_NUMB = 'ARM';

	/**
	 * Purchase for export Customs agreement number (ATB)
	 *
	 * A number assigned by a Customs authority allowing the purchase of goods
	 * free of tax because they are to be exported immediately after the purchase.
	 */
	public const PURC_FOR_EXPO_CUST_AGRE_NUMB = 'ATB';

	/**
	 * Purchase order change number (PP)
	 *
	 * Reference number assigned by a buyer for a revision of a purchase order.
	 */
	public const PURC_ORDE_CHAN_NUMB = 'PP';

	/**
	 * Purchase order number suffix (PS)
	 *
	 * A number added at the end of a purchase order number.
	 */
	public const PURC_ORDE_NUMB_SUFF = 'PS';

	/**
	 * Purchase order response number (POR)
	 *
	 * Reference number assigned by the seller to an order response.
	 */
	public const PURC_ORDE_RESP_NUMB = 'POR';

	/**
	 * Purchaser's request reference (APN)
	 *
	 * Reference identifying a request made by the purchaser.
	 */
	public const PURC_REQU_REFE = 'APN';

	/**
	 * Purchasing activity clause number (AJC)
	 *
	 * A number indicating a clause applicable to a purchasing activity.
	 */
	public const PURC_ACTI_CLAU_NUMB = 'AJC';

	/**
	 * Quantity valuation number (AFV)
	 *
	 * Reference number assigned to a quantity valuation.
	 */
	public const QUAN_VALU_NUMB = 'AFV';

	/**
	 * Quantity valuation request number (AFW)
	 *
	 * Reference number assigned to a quantity valuation request.
	 */
	public const QUAN_VALU_REQU_NUMB = 'AFW';

	/**
	 * Quarantine/treatment status reference number (AHT)
	 *
	 * Coded quarantine/treatment status of a container and its cargo and packing
	 * materials, generated by a shipping company based upon declarations
	 * presented by a shipper.
	 */
	public const QUAR_STAT_REFE_NUMB = 'AHT';

	/**
	 * Quota number (ABJ)
	 *
	 * Reference number allocated by a government authority to identify a quota.
	 */
	public const QUOT_NUMB = 'ABJ';

	/**
	 * Rail waybill number (WY)
	 *
	 * The number on a rail waybill.
	 */
	public const RAIL_WAYB_NUMB = 'WY';

	/**
	 * Rail/road routing code (RC)
	 *
	 * International Western and Eastern European route code used in all rail
	 * organizations and specified in the international tariffs (rail tariffs)
	 * known by the customers.
	 */
	public const RAIL_ROUT_CODE = 'RC';

	/**
	 * Railway consignment note number (RCN)
	 *
	 * Reference number assigned to a rail consignment note, see: 1001 = 720.
	 */
	public const RAIL_CONS_NOTE_NUMB = 'RCN';

	/**
	 * Railway wagon number (ACR)
	 *
	 * (8260) Registered identification initials and numbers of railway wagon.
	 * Synonym: Rail car number.
	 */
	public const RAIL_WAGO_NUMB = 'ACR';

	/**
	 * Rate code number (AWA)
	 *
	 * Number assigned by a buyer to rate a product.
	 */
	public const RATE_CODE_NUMB = 'AWA';

	/**
	 * Rate note number (AHX)
	 *
	 * Reference assigned to a specific rate.
	 */
	public const RATE_NOTE_NUMB = 'AHX';

	/**
	 * Receiver's file reference number (AOF)
	 *
	 * File reference number assigned by the receiver.
	 */
	public const RECE_FILE_REFE_NUMB = 'AOF';

	/**
	 * Receiving advice number (ALO)
	 *
	 * A reference number to a receiving advice.
	 */
	public const RECE_ADVI_NUMB = 'ALO';

	/**
	 * Receiving bank's authorization number (ANW)
	 *
	 * Authorization number of the receiving bank.
	 */
	public const RECE_BANK_AUTH_NUMB = 'ANW';

	/**
	 * Receiving Bankgiro number (ATJ)
	 *
	 * Number of the receiving Bankgiro.
	 */
	public const RECE_BANK_NUMB = 'ATJ';

	/**
	 * Receiving party's member identification (AGY)
	 *
	 * Identification used by the receiving party for a member of a service scheme
	 * or group of persons.
	 */
	public const RECE_PART_MEMB_IDEN = 'AGY';

	/**
	 * Reference number assigned by third party (ANK)
	 *
	 * Reference number assigned by a third party.
	 */
	public const REFE_NUMB_ASSI_BY_THIR_PART = 'ANK';

	/**
	 * Reference number of a request for metered reading (AMC)
	 *
	 * Number to identify a request for a recording or reading of a measuring
	 * device to be taken.
	 */
	public const REFE_NUMB_OF_A_REQU_FOR_METE_READ = 'AMC';

	/**
	 * Reference number quoted on statement (AGN)
	 *
	 * Reference number quoted on the statement sent to the beneficiary for
	 * information purposes.
	 */
	public const REFE_NUMB_QUOT_ON_STAT = 'AGN';

	/**
	 * Reference number to previous message (ACW)
	 *
	 * Reference number assigned to the message which was previously issued (e.g.
	 * in the case of a cancellation, the primary reference of the message to be
	 * cancelled will be quoted in this element).
	 */
	public const REFE_NUMB_TO_PREV_MESS = 'ACW';

	/**
	 * Reference to account servicing bank's message (APL)
	 *
	 * Reference to the account servicing bank's message.
	 */
	public const REFE_TO_ACCO_SERV_BANK_MESS = 'APL';

	/**
	 * Referred product for chemical analysis (AIY)
	 *
	 * A product number identifying the product which is used for chemical
	 * analysis considered valid for a group of products.
	 */
	public const REFE_PROD_FOR_CHEM_ANAL = 'AIY';

	/**
	 * Referred product for mechanical analysis (AIX)
	 *
	 * A product number identifying the product which is used for mechanical
	 * analysis considered valid for a group of products.
	 */
	public const REFE_PROD_FOR_MECH_ANAL = 'AIX';

	/**
	 * Regiristo Federal de Contribuyentes (ARQ)
	 *
	 * A federal tax identification number assigned by the Mexican tax authority.
	 */
	public const REGI_FEDE_DE_CONT = 'ARQ';

	/**
	 * Registered capital reference (ALV)
	 *
	 * Registered capital reference of a company.
	 */
	public const REGI_CAPI_REFE = 'ALV';

	/**
	 * Registered contractor activity type (AQU)
	 *
	 * Reference number identifying the type of registered contractor activity.
	 */
	public const REGI_CONT_ACTI_TYPE = 'AQU';

	/**
	 * Registration number of previous Customs declaration (AEI)
	 *
	 * Registration number of the Customs declaration lodged for the previous
	 * Customs procedure.
	 */
	public const REGI_NUMB_OF_PREV_CUST_DECL = 'AEI';

	/**
	 * Registro Informacion Fiscal (RIF) number (ARG)
	 *
	 * A number assigned by the government to a business in some Latin American
	 * countries.
	 */
	public const REGI_INFO_FISC_RIF_NUMB = 'ARG';

	/**
	 * Registro Unico de Contribuyente (RUC) number (ARH)
	 *
	 * A number assigned by the government to a business in some Latin American
	 * countries.
	 */
	public const REGI_UNIC_DE_CONT_RUC_NUMB = 'ARH';

	/**
	 * Registro Unico Tributario (RUT) (ATV)
	 *
	 * Tax identification number in Chile.
	 */
	public const REGI_UNIC_TRIB_RUT = 'ATV';

	/**
	 * Reinsurer's claim number (APE)
	 *
	 * To identify the number assigned to the claim by the reinsurer.
	 */
	public const REIN_CLAI_NUMB = 'APE';

	/**
	 * Related document number (ACE)
	 *
	 * Reference number identifying a related document.
	 */
	public const RELA_DOCU_NUMB = 'ACE';

	/**
	 * Related party (AWO)
	 *
	 * Reference of a related party.
	 */
	public const RELA_PART = 'AWO';

	/**
	 * Release number (RE)
	 *
	 * Reference number assigned to identify a release of a set of rules,
	 * conventions, conditions, etc.
	 */
	public const RELE_NUMB = 'RE';

	/**
	 * Remittance advice number (RA)
	 *
	 * A number that identifies a remittance advice.
	 */
	public const REMI_ADVI_NUMB = 'RA';

	/**
	 * Remitting bank's reference (ANQ)
	 *
	 * Reference number of the remitting bank.
	 */
	public const REMI_BANK_REFE = 'ANQ';

	/**
	 * Repair data request number (AME)
	 *
	 * A number which uniquely identifies a request for data about repairs.
	 */
	public const REPA_DATA_REQU_NUMB = 'AME';

	/**
	 * Repair estimate number (ABF)
	 *
	 * A number identifying a repair estimate.
	 */
	public const REPA_ESTI_NUMB = 'ABF';

	/**
	 * Replaced meter unit number (AMK)
	 *
	 * Number identifying the replaced meter unit.
	 */
	public const REPL_METE_UNIT_NUMB = 'AMK';

	/**
	 * Replacing part number (ABM)
	 *
	 * New part number which replaces the existing part number.
	 */
	public const REPL_PART_NUMB = 'ABM';

	/**
	 * Replenishment purchase order number (AFH)
	 *
	 * Purchase order number specified by the buyer for the assignment to vendor's
	 * replenishment orders in a vendor managed inventory program.
	 */
	public const REPL_PURC_ORDE_NUMB = 'AFH';

	/**
	 * Replenishment purchase order range end number (AML)
	 *
	 * Ending number of a range of purchase order numbers assigned by the buyer to
	 * vendor's replenishment orders.
	 */
	public const REPL_PURC_ORDE_RANG_END_NUMB = 'AML';

	/**
	 * Replenishment purchase order range start number (AKM)
	 *
	 * Starting number of a range of purchase order numbers assigned by the buyer
	 * to vendor's replenishment orders.
	 */
	public const REPL_PURC_ORDE_RANG_STAR_NUMB = 'AKM';

	/**
	 * Report number (ADY)
	 *
	 * Reference to a report to Customs by a carrier at the point of entry,
	 * encompassing both conveyance and consignment information.
	 */
	public const REPO_NUMB = 'ADY';

	/**
	 * Reporting form number (ALE)
	 *
	 * Reference number assigned to the reporting form.
	 */
	public const REPO_FORM_NUMB = 'ALE';

	/**
	 * Request for cancellation number (AET)
	 *
	 * A number that identifies a request for cancellation.
	 */
	public const REQU_FOR_CANC_NUMB = 'AET';

	/**
	 * Request for quote number (AHU)
	 *
	 * Reference number assigned by the requestor to a request for quote.
	 */
	public const REQU_FOR_QUOT_NUMB = 'AHU';

	/**
	 * Request number (AGI)
	 *
	 * The reference number of a request.
	 */
	public const REQU_NUMB = 'AGI';

	/**
	 * Reservation office identifier (LRC)
	 *
	 * Reference to the office where a reservation was made.
	 */
	public const RESE_OFFI_IDEN = 'LRC';

	/**
	 * Reservation station indentifier (AVT)
	 *
	 * Reference to the station where a reservation was made.
	 */
	public const RESE_STAT_INDE = 'AVT';

	/**
	 * Reserved goods identifier (AWY)
	 *
	 * A reference number identifying goods in stock which have been reserved for
	 * a party.
	 */
	public const RESE_GOOD_IDEN = 'AWY';

	/**
	 * Returnable container reference number (ALP)
	 *
	 * A reference number identifying a returnable container.
	 */
	public const RETU_CONT_REFE_NUMB = 'ALP';

	/**
	 * Returns notice number (ALQ)
	 *
	 * A reference number to a returns notice.
	 */
	public const RETU_NOTI_NUMB = 'ALQ';

	/**
	 * Road consignment note number (CMR)
	 *
	 * Reference number assigned to a road consignment note, see: 1001 = 730.
	 */
	public const ROAD_CONS_NOTE_NUMB = 'CMR';

	/**
	 * Safe custody number (ASR)
	 *
	 * The number of a file or portfolio kept for safe custody on behalf of
	 * clients.
	 */
	public const SAFE_CUST_NUMB = 'ASR';

	/**
	 * Safe deposit box number (ATI)
	 *
	 * Number of the safe deposit box.
	 */
	public const SAFE_DEPO_BOX_NUMB = 'ATI';

	/**
	 * Sales department number (SD)
	 *
	 * A number that identifies a sales department.
	 */
	public const SALE_DEPA_NUMB = 'SD';

	/**
	 * Sales forecast number (ALR)
	 *
	 * A reference number identifying a sales forecast.
	 */
	public const SALE_FORE_NUMB = 'ALR';

	/**
	 * Sales office number (SM)
	 *
	 * A number that identifies a sales office.
	 */
	public const SALE_OFFI_NUMB = 'SM';

	/**
	 * Sales person number (SA)
	 *
	 * Identification number of a sales person.
	 */
	public const SALE_PERS_NUMB = 'SA';

	/**
	 * Sales region number (SB)
	 *
	 * A number that identifies a sales region.
	 */
	public const SALE_REGI_NUMB = 'SB';

	/**
	 * Sales report number (ALS)
	 *
	 * A reference number identifying a sales report.
	 */
	public const SALE_REPO_NUMB = 'ALS';

	/**
	 * Scan line (SP)
	 *
	 * A number that identifies a scan line.
	 */
	public const SCAN_LINE = 'SP';

	/**
	 * Scheme/plan number (AGW)
	 *
	 * Reference number assigned to a service scheme or plan.
	 */
	public const SCHE_NUMB = 'AGW';

	/**
	 * Second beneficiary's reference (AFP)
	 *
	 * Reference of the second beneficiary.
	 */
	public const SECO_BENE_REFE = 'AFP';

	/**
	 * Secondary Customs reference (AFM)
	 *
	 * A number that identifies the secondary customs reference.
	 */
	public const SECO_CUST_REFE = 'AFM';

	/**
	 * Secretariat number (ATD)
	 *
	 * A reference number identifying a secretariat.
	 */
	public const SECR_NUMB = 'ATD';

	/**
	 * Secure delivery terms and conditions agreement reference (ADX)
	 *
	 * A reference to a secure delivery terms and conditions agreement. A secured
	 * delivery agreement is an agreement containing terms and conditions to
	 * secure deliveries in case of failure in the production or logistics process
	 * of the supplier.
	 */
	public const SECU_DELI_TERM_AND_COND_AGRE_REFE = 'ADX';

	/**
	 * Seller's catalogue number (ABN)
	 *
	 * Identification number assigned to a seller's catalogue.
	 */
	public const SELL_CATA_NUMB = 'ABN';

	/**
	 * Sellers reference number (SS)
	 *
	 * Reference number assigned to a transaction by the seller.
	 */
	public const SELL_REFE_NUMB = 'SS';

	/**
	 * Sender's clause number (AQO)
	 *
	 * The number that identifies the sender's clause.
	 */
	public const SEND_CLAU_NUMB = 'AQO';

	/**
	 * Sender's file reference number (AOE)
	 *
	 * File reference number assigned by the sender.
	 */
	public const SEND_FILE_REFE_NUMB = 'AOE';

	/**
	 * Sender's reference to the original message (AGO)
	 *
	 * The reference provided by the sender of the original message.
	 */
	public const SEND_REFE_TO_THE_ORIG_MESS = 'AGO';

	/**
	 * Sending bank's reference number (ANY)
	 *
	 * Reference number of the sending bank.
	 */
	public const SEND_BANK_REFE_NUMB = 'ANY';

	/**
	 * Sending Bankgiro number (ATK)
	 *
	 * Number of the sending Bankgiro.
	 */
	public const SEND_BANK_NUMB = 'ATK';

	/**
	 * Serial number (SE)
	 *
	 * Identification number of an item which distinguishes this specific item out
	 * of an number of identical items.
	 */
	public const SERI_NUMB = 'SE';

	/**
	 * Serial shipping container code (AXI)
	 *
	 * Reference number identifying a logistic unit.
	 */
	public const SERI_SHIP_CONT_CODE = 'AXI';

	/**
	 * Service category reference (AWM)
	 *
	 * Reference identifying the service category.
	 */
	public const SERV_CATE_REFE = 'AWM';

	/**
	 * Service group identification number (AGT)
	 *
	 * Identification used for a group of services.
	 */
	public const SERV_GROU_IDEN_NUMB = 'AGT';

	/**
	 * Service provider (AWK)
	 *
	 * Reference of the service provider.
	 */
	public const SERV_PROV = 'AWK';

	/**
	 * Service relation number (AXH)
	 *
	 * A reference number identifying the relationship between a service provider
	 * and a service client, e.g., treatment of a patient in a hospital, usage by
	 * a member of a library facility, etc.
	 */
	public const SERV_RELA_NUMB = 'AXH';

	/**
	 * Ship from (SF)
	 *
	 * A number that identifies a ship from location.
	 */
	public const SHIP_FROM = 'SF';

	/**
	 * Ship notice/manifest number (MA)
	 *
	 * The number assigned to a ship notice or manifest.
	 */
	public const SHIP_NOTI_NUMB = 'MA';

	/**
	 * Ship's stay reference number (ATZ)
	 *
	 * (1099) Reference number assigned by a port authority to the stay of a
	 * vessel in the port.
	 */
	public const SHIP_STAY_REFE_NUMB = 'ATZ';

	/**
	 * Shipment reference number (SRN)
	 *
	 * [1065] Reference number assigned to a shipment.
	 */
	public const SHIP_REFE_NUMB = 'SRN';

	/**
	 * Shipowner's authorization number (ADM)
	 *
	 * Reference number assigned by the shipowner as an authorization number to
	 * transport certain goods (such as hazardous goods, cool or reefer goods).
	 */
	public const SHIP_AUTH_NUMB = 'ADM';

	/**
	 * Shipping label serial number (LA)
	 *
	 * The serial number on a shipping label.
	 */
	public const SHIP_LABE_SERI_NUMB = 'LA';

	/**
	 * Shipping note number (AEV)
	 *
	 * [1123] Reference number assigned to a shipping note.
	 */
	public const SHIP_NOTE_NUMB = 'AEV';

	/**
	 * Shipping unit identification (ACC)
	 *
	 * Identifying marks on the outermost unit that is used to transport
	 * merchandise.
	 */
	public const SHIP_UNIT_IDEN = 'ACC';

	/**
	 * SID (Shipper's identifying number for shipment) (SI)
	 *
	 * A number that identifies the SID (shipper's identification) number for a
	 * shipment.
	 */
	public const SID_SHIP_IDEN_NUMB_FOR_SHIP = 'SI';

	/**
	 * Signal code number (AHE)
	 *
	 * Reference number to identify a signal.
	 */
	public const SIGN_CODE_NUMB = 'AHE';

	/**
	 * Single transaction sequence number (AGJ)
	 *
	 * A number that identifies a single transaction sequence.
	 */
	public const SING_TRAN_SEQU_NUMB = 'AGJ';

	/**
	 * Site specific procedures, terms, and conditions number (AJL)
	 *
	 * A number indicating a set of site specific procedures, terms and
	 * conditions.
	 */
	public const SITE_SPEC_PROC_TERM_AND_COND_NUMB = 'AJL';

	/**
	 * Situation number (AFZ)
	 *
	 * Common reference number given to documents concerning a determined period
	 * of works.
	 */
	public const SITU_NUMB = 'AFZ';

	/**
	 * Slaughter plant number (AIT)
	 *
	 * Number to identify slaughter plant.
	 */
	public const SLAU_PLAN_NUMB = 'AIT';

	/**
	 * Slaughterhouse approval number (AVG)
	 *
	 * Veterinary licence number allocated by a national authority to a
	 * slaughterhouse.
	 */
	public const SLAU_APPR_NUMB = 'AVG';

	/**
	 * Social security number (ARR)
	 *
	 * An identification number assigned to an individual by the social security
	 * administration.
	 */
	public const SOCI_SECU_NUMB = 'ARR';

	/**
	 * Software editor reference (AUM)
	 *
	 * Reference identifying the software editor.
	 */
	public const SOFT_EDIT_REFE = 'AUM';

	/**
	 * Software quality reference (AUO)
	 *
	 * Reference allocated to the software by a quality assurance agency.
	 */
	public const SOFT_QUAL_REFE = 'AUO';

	/**
	 * Software reference (AUN)
	 *
	 * Reference identifying the software.
	 */
	public const SOFT_REFE = 'AUN';

	/**
	 * Source document internal reference (AOG)
	 *
	 * Reference number assigned to a source document for internal usage.
	 */
	public const SOUR_DOCU_INTE_REFE = 'AOG';

	/**
	 * Special budget account number (APU)
	 *
	 * The number of a special budget account.
	 */
	public const SPEC_BUDG_ACCO_NUMB = 'APU';

	/**
	 * Special instructions number (AJK)
	 *
	 * A number indicating a citation used for special instructions.
	 */
	public const SPEC_INST_NUMB = 'AJK';

	/**
	 * Specification number (SZ)
	 *
	 * Number assigned by the issuer to his specification.
	 */
	public const SPEC_NUMB = 'SZ';

	/**
	 * Split delivery number (AXG)
	 *
	 * A reference number identifying a split delivery.
	 */
	public const SPLI_DELI_NUMB = 'AXG';

	/**
	 * Standard Carrier Alpha Code (SCAC) number (AAZ)
	 *
	 * For maritime shipments, this code qualifies a Standard Alpha Carrier Code
	 * (SCAC) as issued by the United Stated National Motor Traffic Association
	 * Inc.
	 */
	public const STAN_CARR_ALPH_CODE_SCAC_NUMB = 'AAZ';

	/**
	 * Standard Industry Classification (SIC) number (AJT)
	 *
	 * A number specifying a standard industry classification.
	 */
	public const STAN_INDU_CLAS_SIC_NUMB = 'AJT';

	/**
	 * Standard number of inspection document (ALW)
	 *
	 * Code identifying the standard number of the inspection document supplied.
	 */
	public const STAN_NUMB_OF_INSP_DOCU = 'ALW';

	/**
	 * Standard's code number (GD)
	 *
	 * Number to identify a specific parameter within a standardization
	 * description (e.g. M5 for screws or DIN A4 for paper).
	 */
	public const STAN_CODE_NUMB = 'GD';

	/**
	 * Standard's number (GA)
	 *
	 * Number to identify a standardization description (e.g. ISO 9375).
	 */
	public const STAN_NUMB = 'GA';

	/**
	 * Standard's version number (AMY)
	 *
	 * The version number assigned to a standard.
	 */
	public const STAN_VERS_NUMB = 'AMY';

	/**
	 * State or province assigned entity identification (AQW)
	 *
	 * Reference number of an entity assigned by a state or province.
	 */
	public const STAT_OR_PROV_ASSI_ENTI_IDEN = 'AQW';

	/**
	 * Statement number (ADP)
	 *
	 * A reference number identifying a statement.
	 */
	public const STAT_NUMB = 'ADP';

	/**
	 * Statement of work (AOR)
	 *
	 * A reference number for a statement of work.
	 */
	public const STAT_OF_WORK = 'AOR';

	/**
	 * Station reference number (STA)
	 *
	 * International UIC code assigned to every European rail station (CIM
	 * convention).
	 */
	public const STAT_REFE_NUMB = 'STA';

	/**
	 * Statistic Bundes Amt (SBA) identifier (AQV)
	 *
	 * A German industry classification code issued by Statistic Bundes Amt (SBA)
	 * to identify the activity of a company.
	 */
	public const STAT_BUND_AMT_SBA_IDEN = 'AQV';

	/**
	 * Status report number (AQK)
	 *
	 * (1125) The reference number for a status report.
	 */
	public const STAT_REPO_NUMB = 'AQK';

	/**
	 * Stock adjustment number (ARZ)
	 *
	 * A number identifying a stock adjustment.
	 */
	public const STOC_ADJU_NUMB = 'ARZ';

	/**
	 * Stock exchange company identifier (ARU)
	 *
	 * A reference assigned by the stock exchange to a company.
	 */
	public const STOC_EXCH_COMP_IDEN = 'ARU';

	/**
	 * Stock keeping unit number (ABW)
	 *
	 * A number that identifies the stock keeping unit.
	 */
	public const STOC_KEEP_UNIT_NUMB = 'ABW';

	/**
	 * Sub file (ANE)
	 *
	 * Identifies the sub file in a structure of related files.
	 */
	public const SUB_FILE = 'ANE';

	/**
	 * Sub-house bill of lading number (ABH)
	 *
	 * Reference assigned to a sub-house bill of lading.
	 */
	public const SUBH_BILL_OF_LADI_NUMB = 'ABH';

	/**
	 * Substitute air waybill number (AEY)
	 *
	 * Reference number assigned to a substitute air waybill, see: 1001 = 743.
	 */
	public const SUBS_AIR_WAYB_NUMB = 'AEY';

	/**
	 * Suffix (AJY)
	 *
	 * A reference to specify a suffix added to the end of a basic identifier.
	 */
	public const SUFFIX = 'AJY';

	/**
	 * Supplier's control number (AEU)
	 *
	 * Reference to a file regarding a control of the supplier carried out on
	 * departure of the goods.
	 */
	public const SUPP_CONT_NUMB = 'AEU';

	/**
	 * Supplier's credit claim reference number (ASJ)
	 *
	 * A reference number identifying a supplier's credit claim.
	 */
	public const SUPP_CRED_CLAI_REFE_NUMB = 'ASJ';

	/**
	 * Supplier's customer reference number (AVC)
	 *
	 * A number, assigned by a supplier, to reference a customer.
	 */
	public const SUPP_CUST_REFE_NUMB = 'AVC';

	/**
	 * Swap order number (SW)
	 *
	 * Number assigned by the seller to a swap order (see definition of DE 1001,
	 * code 229).
	 */
	public const SWAP_ORDE_NUMB = 'SW';

	/**
	 * Symbol number (AEC)
	 *
	 * A number that identifies a symbol.
	 */
	public const SYMB_NUMB = 'AEC';

	/**
	 * Systeme Informatique pour le Repertoire des ENtreprises (SIREN) number (ARK)
	 *
	 * An identification number known as a SIREN assigned to a business in France.
	 */
	public const SYST_INFO_POUR_LE_REPE_DES_ENTR_SIRE_NUMB = 'ARK';

	/**
	 * Systeme Informatique pour le Repertoire des ETablissements (SIRET) number (ARL)
	 *
	 * An identification number known as a SIRET assigned to a business location
	 * in France.
	 */
	public const SYST_INFO_POUR_LE_REPE_DES_ETAB_SIRE_NUMB = 'ARL';

	/**
	 * Tariff number (AFG)
	 *
	 * A number that identifies a tariff.
	 */
	public const TARI_NUMB = 'AFG';

	/**
	 * Tax exemption licence number (TL)
	 *
	 * Number assigned by the tax authorities to a party indicating its tax
	 * exemption authorization. This number could relate to a specified business
	 * type, a specified local area or a class of products.
	 */
	public const TAX_EXEM_LICE_NUMB = 'TL';

	/**
	 * Tax payment identifier (ABI)
	 *
	 * [1168] Reference number identifying a payment of a duty or tax e.g. under a
	 * transit procedure.
	 */
	public const TAX_PAYM_IDEN = 'ABI';

	/**
	 * Tax registration number (AHP)
	 *
	 * The registration number by which a company/organization is identified with
	 * the tax administration.
	 */
	public const TAX_REGI_NUMB = 'AHP';

	/**
	 * Team assignment number (CST)
	 *
	 * Team number assigned to a group that is responsible for working a
	 * particular transaction.
	 */
	public const TEAM_ASSI_NUMB = 'CST';

	/**
	 * Technical document number (AJW)
	 *
	 * A number specifying a technical document.
	 */
	public const TECH_DOCU_NUMB = 'AJW';

	/**
	 * Technical order number (AJX)
	 *
	 * A reference to an order that specifies a technical change.
	 */
	public const TECH_ORDE_NUMB = 'AJX';

	/**
	 * Technical phase reference (ARX)
	 *
	 * A reference which identifies a specific technical phase.
	 */
	public const TECH_PHAS_REFE = 'ARX';

	/**
	 * Technical regulation (ANG)
	 *
	 * Reference number identifying a technical regulation.
	 */
	public const TECH_REGU = 'ANG';

	/**
	 * Telex message number (TE)
	 *
	 * Reference number identifying a telex message.
	 */
	public const TELE_MESS_NUMB = 'TE';

	/**
	 * Terminal operator's consignment reference (TCR)
	 *
	 * Reference assigned to a consignment by the terminal operator.
	 */
	public const TERM_OPER_CONS_REFE = 'TCR';

	/**
	 * Test report number (TP)
	 *
	 * Reference number identifying a test report document relevant to the
	 * product.
	 */
	public const TEST_REPO_NUMB = 'TP';

	/**
	 * Test specification number (AXJ)
	 *
	 * A reference number identifying a test specification.
	 */
	public const TEST_SPEC_NUMB = 'AXJ';

	/**
	 * Text Element Identifier deletion reference (ABX)
	 *
	 * The reference used within a given TEI (Text Element Identifier) which is to
	 * be deleted.
	 */
	public const TEXT_ELEM_IDEN_DELE_REFE = 'ABX';

	/**
	 * Third bank's reference (AKN)
	 *
	 * Reference number of the third bank.
	 */
	public const THIR_BANK_REFE = 'AKN';

	/**
	 * Through bill of lading number (AFA)
	 *
	 * Reference number assigned to a through bill of lading, see: 1001 = 761.
	 */
	public const THRO_BILL_OF_LADI_NUMB = 'AFA';

	/**
	 * Ticket control number (CBA)
	 *
	 * Reference giving access to all the details associated with the ticket.
	 */
	public const TICK_CONT_NUMB = 'CBA';

	/**
	 * Time series reference (AUU)
	 *
	 * Reference to a time series.
	 */
	public const TIME_SERI_REFE = 'AUU';

	/**
	 * TIR carnet number (TI)
	 *
	 * Reference number assigned to a TIR carnet.
	 */
	public const TIR_CARN_NUMB = 'TI';

	/**
	 * Tokyo SHOKO Research (TSR) business identifier (ARI)
	 *
	 * A number assigned to a business by TSR.
	 */
	public const TOKY_SHOK_RESE_TSR_BUSI_IDEN = 'ARI';

	/**
	 * Tooling contract number (AXL)
	 *
	 * A reference number of the tooling contract.
	 */
	public const TOOL_CONT_NUMB = 'AXL';

	/**
	 * TRACES party identification (AXS)
	 *
	 * The party identification number used in the European Union's Trade Control
	 * and Expert System (TRACES).
	 */
	public const TRAC_PART_IDEN = 'AXS';

	/**
	 * Trader account number (ADZ)
	 *
	 * Number assigned by a Customs authority which uniquely identifies a trader
	 * (i.e. importer, exporter or declarant) for Customs purposes.
	 */
	public const TRAD_ACCO_NUMB = 'ADZ';

	/**
	 * Trading partner identification number (ASM)
	 *
	 * Code specifying an identification assigned to an entity with whom one
	 * conducts trade.
	 */
	public const TRAD_PART_IDEN_NUMB = 'ASM';

	/**
	 * Training flight number (AHC)
	 *
	 * Non-revenue producing airline flight for training purposes.
	 */
	public const TRAI_FLIG_NUMB = 'AHC';

	/**
	 * Transaction reference number (TN)
	 *
	 * Reference applied to a transaction between two or more parties over a
	 * defined life cycle; e.g. number applied by importer or broker to obtain
	 * release from Customs, may then used to control declaration through final
	 * accounting (synonyms: declaration, entry number).
	 */
	public const TRAN_REFE_NUMB = 'TN';

	/**
	 * Transfer number (TF)
	 *
	 * An extra number assigned to goods or a container which functions as a
	 * reference number or as an authorization number to get the goods or
	 * container released from a certain party.
	 */
	public const TRAN_NUMB = 'TF';

	/**
	 * Transit (onward carriage) guarantee (bond) number (ABK)
	 *
	 * Reference number to identify the guarantee or security provided for Customs
	 * transit operation (CCC).
	 */
	public const TRAN_ONWA_CARR_GUAR_BOND_NUMB = 'ABK';

	/**
	 * Transport contract document identifier (AAS)
	 *
	 * [1188] Reference number to identify a document evidencing a transport
	 * contract.
	 */
	public const TRAN_CONT_DOCU_IDEN = 'AAS';

	/**
	 * Transport contract reference number (AHI)
	 *
	 * Reference number of a transport contract.
	 */
	public const TRAN_CONT_REFE_NUMB = 'AHI';

	/**
	 * Transport costs reference number (AKW)
	 *
	 * Reference number of the transport costs.
	 */
	public const TRAN_COST_REFE_NUMB = 'AKW';

	/**
	 * Transport equipment acceptance order reference (ATX)
	 *
	 * Reference number assigned to an order to accept transport equipment that is
	 * to be delivered by an inland carrier to a specified facility.
	 */
	public const TRAN_EQUI_ACCE_ORDE_REFE = 'ATX';

	/**
	 * Transport equipment gross mass verification order reference (VOR)
	 *
	 * Reference number identifying the order for obtaining a Verified Gross Mass
	 * (weight) of a packed transport equipment as per SOLAS Chapter VI,
	 * Regulation 2, paragraphs 4-6.
	 */
	public const TRAN_EQUI_GROS_MASS_VERI_ORDE_REFE = 'VOR';

	/**
	 * Transport equipment gross mass verification reference number (VGR)
	 *
	 * Reference number identifying the documentation of a transport equipment
	 * gross mass (weight) verification.
	 */
	public const TRAN_EQUI_GROS_MASS_VERI_REFE_NUMB = 'VGR';

	/**
	 * Transport equipment identifier (AAQ)
	 *
	 * [8260] To identify a piece if transport equipment e.g. container or unit
	 * load device.
	 */
	public const TRAN_EQUI_IDEN = 'AAQ';

	/**
	 * Transport equipment release order reference (ATY)
	 *
	 * Reference number assigned to an order to release transport equipment which
	 * is to be picked up by an inland carrier from a specified facility.
	 */
	public const TRAN_EQUI_RELE_ORDE_REFE = 'ATY';

	/**
	 * Transport equipment return reference (AKC)
	 *
	 * Reference known at the address to return equipment to.
	 */
	public const TRAN_EQUI_RETU_REFE = 'AKC';

	/**
	 * Transport equipment seal identifier (SN)
	 *
	 * [9308] The identification number of a seal affixed to a piece of transport
	 * equipment.
	 */
	public const TRAN_EQUI_SEAL_IDEN = 'SN';

	/**
	 * Transport equipment stripping order (AKX)
	 *
	 * Reference number assigned to the order to strip goods from transport
	 * equipment.
	 */
	public const TRAN_EQUI_STRI_ORDE = 'AKX';

	/**
	 * Transport equipment stuffing order (AKF)
	 *
	 * Reference number assigned to the order to stuff goods in transport
	 * equipment.
	 */
	public const TRAN_EQUI_STUF_ORDE = 'AKF';

	/**
	 * Transport equipment survey reference (AKD)
	 *
	 * Reference number assigned by the ordering party to the transport equipment
	 * survey order.
	 */
	public const TRAN_EQUI_SURV_REFE = 'AKD';

	/**
	 * Transport equipment survey reference number (AKU)
	 *
	 * Reference number known at the address where the transport equipment will be
	 * or has been surveyed.
	 */
	public const TRAN_EQUI_SURV_REFE_NUMB = 'AKU';

	/**
	 * Transport equipment survey report number (AKE)
	 *
	 * Reference number used by a party to identify its transport equipment survey
	 * report.
	 */
	public const TRAN_EQUI_SURV_REPO_NUMB = 'AKE';

	/**
	 * Transport instruction number (TIN)
	 *
	 * Reference number identifying a transport instruction.
	 */
	public const TRAN_INST_NUMB = 'TIN';

	/**
	 * Transport means journey identifier (CRN)
	 *
	 * [8028] To identify a journey of a means of transport, for example voyage
	 * number, flight number, trip number.
	 */
	public const TRAN_MEAN_JOUR_IDEN = 'CRN';

	/**
	 * Transport route (AEM)
	 *
	 * A predefined and identified sequence of points where goods are collected,
	 * agreed between partners, e.g. the party in charge of organizing the
	 * transport and the parties where goods will be collected. The same
	 * collecting points may be included in different transport routes, but in a
	 * different sequence.
	 */
	public const TRAN_ROUT = 'AEM';

	/**
	 * Transport section reference number (AIW)
	 *
	 * A number identifying a transport section.
	 */
	public const TRAN_SECT_REFE_NUMB = 'AIW';

	/**
	 * Transport status report number (AXK)
	 *
	 * [1125] A reference number identifying a transport status report.
	 */
	public const TRAN_STAT_REPO_NUMB = 'AXK';

	/**
	 * Transportation account number (AJZ)
	 *
	 * An account number to be charged or credited for transportation.
	 */
	public const TRAN_ACCO_NUMB = 'AJZ';

	/**
	 * Transportation Control Number (TCN) (AOW)
	 *
	 * A number assigned for transportation purposes.
	 */
	public const TRAN_CONT_NUMB_TCN = 'AOW';

	/**
	 * Transportation exportation no. for in bond movement (AFJ)
	 *
	 * A number that identifies the transportation exportation number for an in
	 * bond movement.
	 */
	public const TRAN_EXPO_NO_FOR_IN_BOND_MOVE = 'AFJ';

	/**
	 * Travel service (AUE)
	 *
	 * Reference identifying a travel service.
	 */
	public const TRAV_SERV = 'AUE';

	/**
	 * Treaty number (ADF)
	 *
	 * A number that identifies a treaty.
	 */
	public const TREA_NUMB = 'ADF';

	/**
	 * Trucker's bill of lading (TB)
	 *
	 * A cargo list/description issued by a motor carrier of freight.
	 */
	public const TRUC_BILL_OF_LADI = 'TB';

	/**
	 * U.S. Code of Federal Regulations (CFR) (AJB)
	 *
	 * A reference indicating a citation from the U.S. Code of Federal Regulations
	 * (CFR).
	 */
	public const US_CODE_OF_FEDE_REGU_CFR = 'AJB';

	/**
	 * U.S. Defense Federal Acquisition Regulation Supplement (AJD)
	 *
	 * A reference indicating a citation from the U.S. Defense Federal Acquisition
	 * Regulation Supplement.
	 */
	public const US_DEFE_FEDE_ACQU_REGU_SUPP = 'AJD';

	/**
	 * U.S. Department of Veterans Affairs Acquisition Regulation (AJN)
	 *
	 * A reference indicating a citation from the U.S. Department of Veterans
	 * Affairs Acquisition Regulation.
	 */
	public const US_DEPA_OF_VETE_AFFA_ACQU_REGU = 'AJN';

	/**
	 * U.S. Federal Acquisition Regulation (AJG)
	 *
	 * A reference indicating a citation from the U.S. Federal Acquisition
	 * Regulation.
	 */
	public const US_FEDE_ACQU_REGU = 'AJG';

	/**
	 * U.S. Federal Information Resources Management Regulation (AJI)
	 *
	 * A reference indicating a citation from U.S. Federal Information Resources
	 * Management Regulation.
	 */
	public const US_FEDE_INFO_RESO_MANA_REGU = 'AJI';

	/**
	 * U.S. General Services Administration Regulation (AJH)
	 *
	 * A reference indicating a citation from U.S. General Services Administration
	 * Regulation.
	 */
	public const US_GENE_SERV_ADMI_REGU = 'AJH';

	/**
	 * Ultimate customer's order number (UO)
	 *
	 * The originator's order number as forwarded in a sequence of parties
	 * involved.
	 */
	public const ULTI_CUST_ORDE_NUMB = 'UO';

	/**
	 * Ultimate customer's reference number (UC)
	 *
	 * The originator's reference number as forwarded in a sequence of parties
	 * involved.
	 */
	public const ULTI_CUST_REFE_NUMB = 'UC';

	/**
	 * Uniform Resource Identifier (URI)
	 *
	 * A string of characters used to identify a name of a resource on the
	 * worldwide web.
	 */
	public const UNIF_RESO_IDEN = 'URI';

	/**
	 * Unique claims reference number of the sender (ACT)
	 *
	 * A number that identifies the unique claims reference of the sender.
	 */
	public const UNIQ_CLAI_REFE_NUMB_OF_THE_SEND = 'ACT';

	/**
	 * Unique consignment reference number (UCN)
	 *
	 * [1202] Unique reference identifying a particular consignment of goods.
	 * Synonym: UCR, UCRN.
	 */
	public const UNIQ_CONS_REFE_NUMB = 'UCN';

	/**
	 * Unique goods shipment identifier (AVU)
	 *
	 * Unique identifier assigned to a shipment of goods linking trade, tracking
	 * and transport information.
	 */
	public const UNIQ_GOOD_SHIP_IDEN = 'AVU';

	/**
	 * Unique market reference (ADQ)
	 *
	 * A number that identifies a unique market.
	 */
	public const UNIQ_MARK_REFE = 'ADQ';

	/**
	 * United Nations Dangerous Goods identifier (UN)
	 *
	 * [7124] United Nations Dangerous Goods Identifier (UNDG) is the unique
	 * serial number assigned within the United Nations to substances and articles
	 * contained in a list of the dangerous goods most commonly carried.
	 */
	public const UNIT_NATI_DANG_GOOD_IDEN = 'UN';

	/**
	 * Upper number of range (UAR)
	 *
	 * Upper number in a range of numbers.
	 */
	public const UPPE_NUMB_OF_RANG = 'UAR';

	/**
	 * US Customs Service (USCS) entry code (AQM)
	 *
	 * An entry number assigned by the United States (US) customs service.
	 */
	public const US_CUST_SERV_USCS_ENTR_CODE = 'AQM';

	/**
	 * US government agency number (ACB)
	 *
	 * A number that identifies a United States Government agency.
	 */
	public const US_GOVE_AGEN_NUMB = 'ACB';

	/**
	 * US, Department of Transportation bond surety code (AMQ)
	 *
	 * A bond surety code assigned by the United States Department of
	 * Transportation (DOT).
	 */
	public const US_DEPA_OF_TRAN_BOND_SURE_CODE = 'AMQ';

	/**
	 * US, Federal Communications Commission (FCC) import condition number (AMS)
	 *
	 * A number known as the United States Federal Communications Commission (FCC)
	 * import condition number applying to certain types of regulated
	 * communications equipment.
	 */
	public const US_FEDE_COMM_COMM_FCC_IMPO_COND_NUMB = 'AMS';

	/**
	 * US, Food and Drug Administration establishment indicator (AMR)
	 *
	 * An establishment indicator assigned by the United States Food and Drug
	 * Administration.
	 */
	public const US_FOOD_AND_DRUG_ADMI_ESTA_INDI = 'AMR';

	/**
	 * VAT registration number (VA)
	 *
	 * Unique number assigned by the relevant tax authority to identify a party
	 * for use in relation to Value Added Tax (VAT).
	 */
	public const VAT_REGI_NUMB = 'VA';

	/**
	 * Vehicle Identification Number (VIN) (AKG)
	 *
	 * The identification number which uniquely distinguishes one vehicle from
	 * another through the lifespan of the vehicle.
	 */
	public const VEHI_IDEN_NUMB_VIN = 'AKG';

	/**
	 * Vehicle licence number (ABZ)
	 *
	 * Number of the licence issued for a vehicle by an agency of government.
	 */
	public const VEHI_LICE_NUMB = 'ABZ';

	/**
	 * Vendor contract number (VC)
	 *
	 * Number assigned by the vendor to a contract.
	 */
	public const VEND_CONT_NUMB = 'VC';

	/**
	 * Vendor ID number (VR)
	 *
	 * A number that identifies a vendor's identification.
	 */
	public const VEND_ID_NUMB = 'VR';

	/**
	 * Vendor order number suffix (VS)
	 *
	 * The suffix for a vendor order number.
	 */
	public const VEND_ORDE_NUMB_SUFF = 'VS';

	/**
	 * Vendor product number (VP)
	 *
	 * Number assigned by vendor to another manufacturer's product.
	 */
	public const VEND_PROD_NUMB = 'VP';

	/**
	 * Vessel identifier (VM)
	 *
	 * (8123) Reference identifying a vessel.
	 */
	public const VESS_IDEN = 'VM';

	/**
	 * Voucher number (VV)
	 *
	 * Reference number identifying a voucher.
	 */
	public const VOUC_NUMB = 'VV';

	/**
	 * Voyage number (VON)
	 *
	 * (8028) Reference number assigned to the voyage of the vessel.
	 */
	public const VOYA_NUMB = 'VON';

	/**
	 * Wage determination number (AJR)
	 *
	 * A number specifying a wage determination.
	 */
	public const WAGE_DETE_NUMB = 'AJR';

	/**
	 * Warehouse entry number (WE)
	 *
	 * Entry number under which imported merchandise was placed in a Customs
	 * bonded warehouse.
	 */
	public const WARE_ENTR_NUMB = 'WE';

	/**
	 * Warehouse receipt number (WR)
	 *
	 * A number identifying a warehouse receipt.
	 */
	public const WARE_RECE_NUMB = 'WR';

	/**
	 * Warehouse storage location number (WS)
	 *
	 * A number identifying a warehouse storage location.
	 */
	public const WARE_STOR_LOCA_NUMB = 'WS';

	/**
	 * Waybill number (AAM)
	 *
	 * Reference number assigned to a waybill, see: 1001 = 700.
	 */
	public const WAYB_NUMB = 'AAM';

	/**
	 * Weight agreement number (WM)
	 *
	 * A number identifying a weight agreement.
	 */
	public const WEIG_AGRE_NUMB = 'WM';

	/**
	 * Well number (WN)
	 *
	 * A number assigned to a shaft sunk into the ground.
	 */
	public const WELL_NUMB = 'WN';

	/**
	 * Wool identification number (AHQ)
	 *
	 * Shipping Identification Mark (SIM) allocated to a wool consignment by a
	 * shipping company.
	 */
	public const WOOL_IDEN_NUMB = 'AHQ';

	/**
	 * Wool tax reference number (AHR)
	 *
	 * Reference or indication of the payment of wool tax.
	 */
	public const WOOL_TAX_REFE_NUMB = 'AHR';

	/**
	 * Work breakdown structure (AOL)
	 *
	 * A structure reference that identifies the breakdown of work for a project.
	 */
	public const WORK_BREA_STRU = 'AOL';

	/**
	 * Work item quantity determination (AWF)
	 *
	 * A reference assigned to a work item quantity determination.
	 */
	public const WORK_ITEM_QUAN_DETE = 'AWF';

	/**
	 * Work order (AOV)
	 *
	 * Reference number for an order to do work.
	 */
	public const WORK_ORDE = 'AOV';

	/**
	 * Work package (AOS)
	 *
	 * A reference for a detailed package of work.
	 */
	public const WORK_PACK = 'AOS';

	/**
	 * Work shift (AOK)
	 *
	 * A work shift reference number.
	 */
	public const WORK_SHIF = 'AOK';

	/**
	 * Work task charge number (AON)
	 *
	 * A reference assigned to a specific work task charge.
	 */
	public const WORK_TASK_CHAR_NUMB = 'AON';

	/**
	 * Work team (AOP)
	 *
	 * A reference to identify a team performing work.
	 */
	public const WORK_TEAM = 'AOP';

	/**
	 * Returns an array of all available codes
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	final public static function getAllCodes(): array
	{
		return [
		    static::ACCI_REFE_NUMB,
		    static::ACCO_NUMB,
		    static::ACCO_PART_BANK_REFE,
		    static::ACCO_PART_REFE,
		    static::ACCO_PAYA_NUMB,
		    static::ACCO_SERV_BANK_REFE_NUMB,
		    static::ACCO_ENTR,
		    static::ACCO_FILE_REFE,
		    static::ACCO_TRAN_NUMB,
		    static::ACCO_RECE_NUMB,
		    static::ACTI_AUTH_NUMB,
		    static::ACTI_PRIN_EXER_APE_IDEN,
		    static::ADDI_REFE_NUMB,
		    static::ADDR_REFE,
		    static::ADMI_REFE_CODE,
		    static::ADVI_THRO_BANK_REFE,
		    static::ADVI_BANK_REFE,
		    static::AGEN_CLAU_NUMB,
		    static::AGEN_BANK_REFE,
		    static::AGEN_REFE,
		    static::AGER_AERO_GROU_EQUI_REQU_DATA_NUMB,
		    static::AGRE_NUMB,
		    static::AGRE_TO_PAY_NUMB,
		    static::AIR_CARG_TRAN_MANI,
		    static::AIR_WAYB_NUMB,
		    static::AIRL_FLIG_IDEN_NUMB,
		    static::ALLO_SEAT,
		    static::ALLO_IDEN_AIR,
		    static::ANAL_NUMB_NUMB,
		    static::ANIM_FARM_LICE_NUMB,
		    static::ANTI_CASE_NUMB,
		    static::APPL_COEF_IDEN_NUMB,
		    static::APPL_INST_OR_STAN,
		    static::APPL_BANK_REFE,
		    static::APPL_REFE,
		    static::APPL_FOR_FINA_SUPP_REFE_NUMB,
		    static::APPL_REFE_NUMB,
		    static::APPR_NUMB,
		    static::ARTI_NUMB,
		    static::ASSE_NUMB,
		    static::ASSO_INVO,
		    static::ASSU_COMP,
		    static::ATA_CARN_NUMB,
		    static::AUTH_FOR_REPA_REFE,
		    static::AUTH_ISSU_EQUI_IDEN,
		    static::AUTH_FOR_EXPE_AFE_NUMB,
		    static::AUTH_NUMB,
		    static::AUTH_NUMB_FOR_EXCE_TO_DANG_GOOD_REGU,
		    static::AUTH_TO_MEET_COMP_NUMB,
		    static::BANK_REFE,
		    static::BANK_BATC_INTE_TRAN_REFE_NUMB,
		    static::BANK_COMM_TRAN_REFE_NUMB,
		    static::BANK_DOCU_PROC_REFE,
		    static::BANK_INDI_INTE_TRAN_REFE_NUMB,
		    static::BANK_INDI_TRAN_REFE_NUMB,
		    static::BANK_ACCE,
		    static::BANK_REFE,
		    static::BANK_PROC_NUMB,
		    static::BAR_CODE_LABE_SERI_NUMB,
		    static::BATC_NUMB_NUMB,
		    static::BATT_AND_ACCU_PROD_REGI_NUMB,
		    static::BEGI_JOB_SEQU_NUMB,
		    static::BEGI_METE_READ_ACTU,
		    static::BEGI_METE_READ_ESTI,
		    static::BENE_BANK_REFE,
		    static::BENE_REFE,
		    static::BID_NUMB,
		    static::BILL_OF_LADI_NUMB,
		    static::BILL_OF_QUAN_NUMB,
		    static::BLAN_ORDE_NUMB,
		    static::BLEN_WITH_NUMB,
		    static::BOOK_NUMB,
		    static::BORD_NUMB,
		    static::BROK_OR_SALE_OFFI_NUMB,
		    static::BROK_REFE,
		    static::BROK_REFE,
		    static::BROK_REFE,
		    static::BUDG_CHAP,
		    static::BURE_SIGN_STAT_REFE,
		    static::BUYE_CATA_NUMB,
		    static::BUYE_CONT_NUMB,
		    static::BUYE_DEBT_NUMB,
		    static::BUYE_FUND_NUMB,
		    static::BUYE_ITEM_NUMB,
		    static::CAD_FILE_LAYE_CONV,
		    static::CADA_GERA_DO_CONT_CGC,
		    static::CALENDAR,
		    static::CALL_OFF_ORDE_NUMB,
		    static::CANA_EXCI_ENTR_NUMB,
		    static::CARG_ACCE_ORDE_REFE_NUMB,
		    static::CARG_CONT_NUMB,
		    static::CARG_MANI_NUMB,
		    static::CARR_AGEN_REFE_NUMB,
		    static::CARR_REFE_NUMB,
		    static::CASE_NUMB,
		    static::CASE_OF_NEED_PART_REFE,
		    static::CATA_SEQU_NUMB,
		    static::CATA_NUMB,
		    static::CATE_OF_WORK_REFE,
		    static::CDROM,
		    static::CEDE_CLAI_NUMB,
		    static::CEDI_COMP,
		    static::CEIL_FORM_REFE_NUMB,
		    static::CENT_SECR_LOG_NUMB,
		    static::CENT_SECR_LOG_NUMB_CHIL_DATA_MAIN_REQU_DMR,
		    static::CENT_SECR_LOG_NUMB_PARE_DATA_MAIN_REQU_DMR,
		    static::CERT_OF_CONF,
		    static::CHAM_OF_COMM_REGI_NUMB,
		    static::CHAR_CARD_ACCO_NUMB,
		    static::CHAR_NOTE_DOCU_ATTA_INDI,
		    static::CHEC_NUMB,
		    static::CHEQ_NUMB,
		    static::CIRC_PUBL_NUMB,
		    static::CIVI_ACTI_NUMB,
		    static::CLAV_UNIC_DE_IDEN_TRIB_CUIT,
		    static::CLEA_REFE,
		    static::COLD_ROLL_NUMB,
		    static::COLL_BANK_REFE,
		    static::COLL_ADVI_DOCU_IDEN,
		    static::COLL_INST_NUMB,
		    static::COLL_REFE,
		    static::COMM_ACCO_SUMM_REFE_NUMB,
		    static::COMM_NUMB,
		    static::COMM_TRAN_REFE_NUMB,
		    static::COMP_REGI_OFFI_CRO_NUMB,
		    static::COMP_SYND_REFE,
		    static::COMP_SYND_REFE,
		    static::COMP_ISSU_EQUI_ID,
		    static::COMP_TRAD_ACCO_NUMB,
		    static::COMP_REGI_NUMB,
		    static::COMP_UNIT_PAYM_REQU_REFE,
		    static::COMP_CODE_NUMB,
		    static::COND_OF_PURC_DOCU_NUMB,
		    static::COND_OF_SALE_DOCU_NUMB,
		    static::CONN_LOCA,
		    static::CONN_POIN_TO_CENT_GRID,
		    static::CONS_FURT_ORDE,
		    static::CONS_INVO_NUMB,
		    static::CONS_ORDE_NUMB,
		    static::CONS_REFE,
		    static::CONS_CONT_NUMB,
		    static::CONS_IDEN_CARR_ASSI,
		    static::CONS_IDEN_CONS_ASSI,
		    static::CONS_IDEN_CONS_ASSI,
		    static::CONS_IDEN_FREI_FORW_ASSI,
		    static::CONS_INFO,
		    static::CONS_RECE_IDEN,
		    static::CONS_STOC_CONT,
		    static::CONS_FURT_ORDE,
		    static::CONS_INVO_NUMB,
		    static::CONS_ORDE_REFE,
		    static::CONS_NOTA,
		    static::CONS_DATA_REQU_NUMB,
		    static::CONT_DISP_ORDE_REFE_NUMB,
		    static::CONT_OPER_REFE_NUMB,
		    static::CONT_PREF,
		    static::CONT_WORK_ORDE_REFE_NUMB,
		    static::CONT_RECE_NUMB,
		    static::CONT_BREA_REFE,
		    static::CONT_DOCU_ADDE_IDEN,
		    static::CONT_NUMB,
		    static::CONT_PART_REFE_NUMB,
		    static::CONT_REGI_NUMB,
		    static::CONT_REQU_REFE,
		    static::CONV_POST_NUMB,
		    static::COOP_CONT_NUMB,
		    static::COST_ACCO,
		    static::COST_ACCO_DOCU,
		    static::COST_CENT,
		    static::COST_CENT_ALIG_NUMB,
		    static::COST_RICA_JUDI_NUMB,
		    static::CRED_MEMO_NUMB,
		    static::CRED_NOTE_NUMB,
		    static::CRED_RATI_AGEN_REFE_NUMB,
		    static::CRED_REFE_NUMB,
		    static::CRED_REFE_NUMB,
		    static::CURR_INVO_NUMB,
		    static::CUST_CATA_NUMB,
		    static::CUST_MATE_SPEC_NUMB,
		    static::CUST_PROC_SPEC_NUMB,
		    static::CUST_REFE_NUMB,
		    static::CUST_REFE_NUMB_ASSI_TO_PREV_BALA_OF_PAYM_INFO,
		    static::CUST_SPEC_NUMB,
		    static::CUST_TRAV_SERV_IDEN,
		    static::CUST_COMM_TRAN_REFE_NUMB,
		    static::CUST_DOCU_PROC_REFE,
		    static::CUST_INDI_TRAN_REFE_NUMB,
		    static::CUST_UNIT_INVE_NUMB,
		    static::CUST_BIND_RULI_NUMB,
		    static::CUST_DECI_REQU_NUMB,
		    static::CUST_GUAR_NUMB,
		    static::CUST_ITEM_NUMB,
		    static::CUST_NONB_RULI_NUMB,
		    static::CUST_PREA_RULI_NUMB,
		    static::CUST_PREF_INQU_NUMB,
		    static::CUST_RELE_CODE,
		    static::CUST_TARI_NUMB,
		    static::CUST_TRAN_NUMB,
		    static::CUST_VALU_DECI_NUMB,
		    static::DANG_GOOD_INFO,
		    static::DANG_GOOD_SECU_NUMB,
		    static::DANG_GOOD_TRAN_LICE_NUMB,
		    static::DATA_STRU_TAG,
		    static::DEBI_ACCO_NUMB,
		    static::DEBI_CARD_NUMB,
		    static::DEBI_LETT_NUMB,
		    static::DEBI_NOTE_NUMB,
		    static::DEBI_REFE_NUMB,
		    static::DEBT_REFE_NUMB,
		    static::DECL_CUST_IDEN_NUMB,
		    static::DECL_REFE_NUMB,
		    static::DEFE_PRIO_ALLO_SYST_PRIO_RATI,
		    static::DEFE_APPR_NUMB,
		    static::DELI_NOTE_NUMB,
		    static::DELI_NUMB_TRAN,
		    static::DELI_ORDE_NUMB,
		    static::DELI_ROUT_REFE,
		    static::DELI_SCHE_NUMB,
		    static::DELI_VERI_CERT,
		    static::DEPARTMENT,
		    static::DEPA_NUMB,
		    static::DEPA_OF_TRAN_BOND_NUMB,
		    static::DEPO_REFE_NUMB,
		    static::DESP_ADVI_NUMB,
		    static::DESP_NOTE_POST_PARC_NUMB,
		    static::DESP_NOTE_DOCU_IDEN,
		    static::DIRE_DEBI_REFE,
		    static::DIRE_PAYM_VALU_NUMB,
		    static::DIRE_PAYM_VALU_REQU_NUMB,
		    static::DISP_REFE,
		    static::DISP_NUMB,
		    static::DIST_INVO_NUMB,
		    static::DOCK_RECE_NUMB,
		    static::DOCK_NUMB,
		    static::DOCU_IDEN,
		    static::DOCU_LINE_IDEN,
		    static::DOCU_PAGE_IDEN,
		    static::DOCU_REFE_INTE,
		    static::DOCU_REFE_ORIG,
		    static::DOCU_VOLU_NUMB,
		    static::DOCU_CRED_AMEN_NUMB,
		    static::DOCU_CRED_IDEN,
		    static::DOCU_PAYM_REFE,
		    static::DOME_FLIG_NUMB,
		    static::DOME_INVE_MANA_CODE,
		    static::DRAW_REFE,
		    static::DRAW_LIST_NUMB,
		    static::DRAW_NUMB,
		    static::DUN_AND_BRAD_CANA__DIGI_STAN_INDU_CLAS_SIC_CODE,
		    static::DUN_AND_BRAD_US__DIGI_STAN_INDU_CLAS_SIC_CODE,
		    static::DUTY_FREE_PROD_RECE_AUTH_NUMB,
		    static::DUTY_FREE_PROD_SECU_NUMB,
		    static::DUTY_MEMO_NUMB,
		    static::ECON_OPER_REGI_AND_IDEN_NUMB_EORI,
		    static::ELEC_AND_ELEC_EQUI_PROD_REGI_NUMB,
		    static::EMBA_NUMB,
		    static::EMBA_PERM_NUMB,
		    static::EMPL_IDEN_NUMB_OF_SERV_BURE,
		    static::EMPL_IDEN_NUMB,
		    static::EMPT_CONT_BILL_NUMB,
		    static::END_ITEM_NUMB,
		    static::END_USE_AUTH_NUMB,
		    static::ENDI_JOB_SEQU_NUMB,
		    static::ENDI_METE_READ_ACTU,
		    static::ENDI_METE_READ_ESTI,
		    static::ENQU_NUMB,
		    static::ENTI_REFE_NUMB_PREV,
		    static::ENTR_FLAG,
		    static::ENTR_POIN_ASSE_LOG_NUMB,
		    static::ENTR_POIN_ASSE_LOG_NUMB_CHIL_DMR,
		    static::ENTR_POIN_ASSE_LOG_NUMB_PARE_DMR,
		    static::EQUI_NUMB,
		    static::EQUI_OWNE_REFE_NUMB,
		    static::EQUI_SEQU_NUMB,
		    static::EQUI_TRAN_CHAR_NUMB,
		    static::ERRO_POSI,
		    static::ESTI_ORDE_REFE_NUMB,
		    static::ETER_REFE,
		    static::EUR__CERT_NUMB,
		    static::EURO_VALU_ADDE_TAX_IDEN,
		    static::EVEN_REFE_NUMB,
		    static::EXCE_TRAN_AUTH_NUMB,
		    static::EXCE_TRAN_NUMB,
		    static::EXPO_CLEA_INST_REFE_NUMB,
		    static::EXPO_CONT_CLAS_NUMB,
		    static::EXPO_CONT_COMM_NUMB_ECCN,
		    static::EXPO_DECL,
		    static::EXPO_ESTA_NUMB,
		    static::EXPO_PERM_IDEN,
		    static::EXPO_REFE_NUMB,
		    static::EXPO_REFE_NUMB,
		    static::EXTE_OBJE_REFE,
		    static::FEDE_SUPP_SCHE_ITEM_NUMB,
		    static::FILE_CONV_JOUR,
		    static::FILE_IDEN_NUMB,
		    static::FILE_LINE_IDEN,
		    static::FILE_VERS_NUMB,
		    static::FINA_SEQU_NUMB,
		    static::FINA_CANC_REFE_NUMB,
		    static::FINA_MANA_REFE,
		    static::FINA_PHAS_REFE,
		    static::FINA_SETT_PART_REFE_NUMB,
		    static::FINA_TRAN_REFE_NUMB,
		    static::FIRM_BOOK_REFE_NUMB,
		    static::FIRS_FINA_INST_TRAN_REFE,
		    static::FISC_NUMB,
		    static::FLAT_RACK_CONT_BUND_IDEN_NUMB,
		    static::FLOW_REFE_NUMB,
		    static::FORE_EXCH,
		    static::FORE_EXCH_CONT_NUMB,
		    static::FORE_MILI_SALE_NUMB,
		    static::FORE_RESI_IDEN_NUMB,
		    static::FORM_REPO_NUMB,
		    static::FORM_STAT_REFE,
		    static::FORM_REFE_NUMB,
		    static::FORW_ORDE_NUMB,
		    static::FRAM_AGRE_NUMB,
		    static::FREE_ZONE_IDEN,
		    static::FREI_BILL_NUMB,
		    static::FREI_FORW_NUMB,
		    static::FUNC_WORK_GROU,
		    static::FUND_ACCO_NUMB,
		    static::FUND_CODE_NUMB,
		    static::GENE_CARG_CONS_REFE_NUMB,
		    static::GENE_DECL_NUMB,
		    static::GENE_ORDE_NUMB,
		    static::GENE_PURP_MESS_REFE_NUMB,
		    static::GOOD_AND_SERV_TAX_IDEN_NUMB,
		    static::GOOD_DECL_DOCU_IDEN_CUST,
		    static::GOOD_DECL_NUMB,
		    static::GOOD_ITEM_INFO,
		    static::GOVE_AGEN_REFE_NUMB,
		    static::GOVE_BILL_OF_LADI,
		    static::GOVE_CONT_NUMB,
		    static::GOVE_QUAL_ASSU_AND_CONT_LEVE_NUMB,
		    static::GOVE_REFE_NUMB,
		    static::GRID_OPER_CUST_REFE_NUMB,
		    static::GROU_ACCO,
		    static::GROU_REFE_NUMB,
		    static::GUAR_NUMB,
		    static::HAND_AND_MOVE_REFE_NUMB,
		    static::HARM_SYST_NUMB,
		    static::HASH_VALU,
		    static::HAST_NUMB,
		    static::HOT_ROLL_NUMB,
		    static::HOUS_BILL_OF_LADI_NUMB,
		    static::HOUS_WAYB_NUMB,
		    static::HYGI_CERT_NUMB_NATI,
		    static::IATA_CARG_AGEN_CASS_ADDR_NUMB,
		    static::IATA_CARG_AGEN_CODE_NUMB,
		    static::IMAG_REFE,
		    static::IMME_EXPO_NO_FOR_IN_BOND_MOVE,
		    static::IMME_TRAN_NO_FOR_IN_BOND_MOVE,
		    static::IMPL_VERS_NUMB,
		    static::IMPO_CLEA_INST_REFE_NUMB,
		    static::IMPO_PERM_IDEN,
		    static::IMPO_REFE_NUMB,
		    static::IMPO_LETT_OF_CRED_REFE,
		    static::IMPU_ACCO,
		    static::IN_BOND_NUMB,
		    static::INCO_LEGA_REFE,
		    static::INDI_TRAN_REFE_NUMB,
		    static::INIT_SAMP_INSP_REPO_NUMB,
		    static::INLA_TRAN_ORDE_NUMB,
		    static::INST_BELG_DE_CODI_IBLC_NUMB,
		    static::INST_OF_SECU_AND_FUTU_MARK_DEVE_ISFM_SERI_NUMB,
		    static::INST_FOR_RETU_NUMB,
		    static::INST_TO_DESP_REFE_NUMB,
		    static::INSU_CERT_REFE_NUMB,
		    static::INSU_CONT_REFE_NUMB,
		    static::INSU_ASSI_REFE_NUMB,
		    static::INTE_LOGI_SUPP_CROS_REFE_NUMB,
		    static::INTE_NUMB_NEW,
		    static::INTE_NUMB_OLD,
		    static::INTE_BROK,
		    static::INTE_CUST_NUMB,
		    static::INTE_DATA_PROC_NUMB,
		    static::INTE_ORDE_NUMB,
		    static::INTE_VEND_NUMB,
		    static::INTE_ASSE_LOG_NUMB,
		    static::INTE_ASSE_LOG_NUMB_CHIL_DATA_MAIN_REQU_DMR,
		    static::INTE_ASSE_LOG_NUMB_PARE_DATA_MAIN_REQU_DMR,
		    static::INTE_FLIG_NUMB,
		    static::INTE_STAN_INDU_CLAS_ISIC_CODE,
		    static::INTR_ROUT,
		    static::INVE_REPO_REFE_NUMB,
		    static::INVE_REPO_REQU_NUMB,
		    static::INVE_REFE_NUMB,
		    static::INVO_DOCU_IDEN,
		    static::INVO_NUMB_SUFF,
		    static::INVO_DATA_SHEE_REFE_NUMB,
		    static::IRON_CHAR_NUMB,
		    static::ISSU_PRES_IDEN,
		    static::ISSU_BANK_REFE,
		    static::JOB_NUMB,
		    static::JOIN_VENT_REFE_NUMB,
		    static::JUDG_NUMB,
		    static::KAME_VAN_KOOP_KVK_NUMB,
		    static::LABO_REGI_NUMB,
		    static::LAST_RECE_BANK_STAT_MESS_REFE,
		    static::LATE_ACCO_ENTR_RECO_REFE,
		    static::LEAS_CONT_REFE,
		    static::LETT_OF_CRED_NUMB,
		    static::LLOY_CLAI_OFFI_REFE,
		    static::LOAD_PLAN_NUMB,
		    static::LOAD_AUTH_IDEN,
		    static::LOAN,
		    static::LOCA_REFE_NUMB,
		    static::LOCKBOX,
		    static::LOSS_NUMB,
		    static::LOWE_NUMB_IN_RANG,
		    static::MAIL_REFE_NUMB,
		    static::MAJO_FORC_PROG_NUMB,
		    static::MAND_REFE,
		    static::MANU_PROC_AUTH_NUMB,
		    static::MANU_DEFI_REPA_RATE_REFE,
		    static::MANU_MATE_SAFE_DATA_SHEE_NUMB,
		    static::MANU_PART_NUMB,
		    static::MANU_ORDE_NUMB,
		    static::MANU_QUAL_AGRE_NUMB,
		    static::MARK_PLAN_IDEN_NUMB_MPIN,
		    static::MARK_REFE,
		    static::MAST_ACCO_NUMB,
		    static::MAST_AIR_WAYB_NUMB,
		    static::MAST_BILL_OF_LADI_NUMB,
		    static::MAST_LABE_NUMB,
		    static::MAST_SOLI_PROC_TERM_AND_COND_NUMB,
		    static::MATC_OF_ENTR_BALA,
		    static::MATC_OF_ENTR_UNBA,
		    static::MATU_CERT_OF_DEPO,
		    static::MEAT_CUTT_PLAN_APPR_NUMB,
		    static::MEAT_PROC_ESTA_REGI_NUMB,
		    static::MEMB_NUMB,
		    static::MESS_BATC_NUMB,
		    static::MESS_DESI_GROU_NUMB,
		    static::MESS_RECI,
		    static::MESS_SEND,
		    static::METE_READ_AT_THE_BEGI_OF_THE_DELI,
		    static::METE_READ_AT_THE_END_OF_DELI,
		    static::METE_UNIT_NUMB,
		    static::METE_SERV_CONS_REPO_NUMB,
		    static::METE_POIN,
		    static::MILI_INTE_PURC_REQU_MIPR_NUMB,
		    static::MINI_CERT_OF_HOMO,
		    static::MODEL,
		    static::MOTO_VEHI_IDEN_NUMB,
		    static::MOVE_REFE_NUMB,
		    static::MUNI_ASSI_BUSI_REGI_NUMB,
		    static::MUTU_DEFI_REFE_NUMB,
		    static::NAME_BANK_REFE,
		    static::NATI_GOVE_BUSI_IDEN_NUMB,
		    static::NET_AREA,
		    static::NET_AREA_SUPP_REFE,
		    static::NEXT_RENT_AGRE_NUMB,
		    static::NEXT_RENT_AGRE_REAS_NUMB,
		    static::NOME_ACTI_CLAS_ECON_NACE_IDEN,
		    static::NOMI_NUMB,
		    static::NONN_MARI_TRAN_DOCU_NUMB,
		    static::NORM_ACTI_FRAN_NAF_IDEN,
		    static::NORT_AMER_HAZA_GOOD_CLAS_NUMB,
		    static::NOTA_FISC,
		    static::NOTI_FOR_COLL_NUMB_NOTI,
		    static::NUMB_OF_TEMP_IMPO_DOCU,
		    static::NUME_DE_IDEN_TRIB_NIT,
		    static::OFFE_NUMB,
		    static::ORDE_ACKN_DOCU_IDEN,
		    static::ORDE_DOCU_IDEN_BUYE_ASSI,
		    static::ORDE_NUMB_VEND,
		    static::ORDE_SHIP_GROU_REFE,
		    static::ORDE_STAT_ENQU_NUMB,
		    static::ORDE_CUST_CONS_REFE_NUMB,
		    static::ORDE_CUST_SECO_REFE_NUMB,
		    static::ORGA_BREA_STRU,
		    static::ORIG_CERT_NUMB,
		    static::ORIG_FILI_NUMB,
		    static::ORIG_MAND_REFE,
		    static::ORIG_PURC_ORDE,
		    static::ORIG_SUBM_LOG_NUMB,
		    static::ORIG_SUBM_CHIL_DATA_MAIN_REQU_DMR_LOG_NUMB,
		    static::ORIG_SUBM_PARE_DATA_MAIN_REQU_DMR_LOG_NUMB,
		    static::ORIG_REFE,
		    static::OUTE_UNIT_IDEN,
		    static::PACK_NUMB,
		    static::PACK_SPEC_NUMB,
		    static::PACK_UNIT_IDEN,
		    static::PACK_LIST_NUMB,
		    static::PACK_PLAN_NUMB,
		    static::PARAGRAPH,
		    static::PARE_FILE,
		    static::PART_REFE_INDI_IN_A_DRAW,
		    static::PART_SHIP_IDEN,
		    static::PART_INFO_MESS_REFE,
		    static::PART_REFE,
		    static::PART_SEQU_NUMB,
		    static::PASS_RESE_NUMB,
		    static::PASS_NUMB,
		    static::PASSWORD,
		    static::PATR_NUMB,
		    static::PAYE_FINA_INST_ACCO_NUMB,
		    static::PAYE_FINA_INST_TRAN_ROUT_NO,
		    static::PAYE_REFE_NUMB,
		    static::PAYE_FINA_INST_ACCO_NUMB,
		    static::PAYE_FINA_INST_TRAN_ROUT_NOAC_TRAN,
		    static::PAYE_REFE_NUMB,
		    static::PAYM_IN_ADVA_REQU_REFE,
		    static::PAYM_INST_REFE_NUMB,
		    static::PAYM_ORDE_NUMB,
		    static::PAYM_PLAN_REFE,
		    static::PAYM_REFE,
		    static::PAYM_VALU_NUMB,
		    static::PAYR_DEDU_ADVI_REFE,
		    static::PAYR_NUMB,
		    static::PERF_PRES_IDEN,
		    static::PERS_REGI_NUMB,
		    static::PERS_IDEN_CARD_NUMB,
		    static::PHON_NUMB,
		    static::PHYS_INVE_RECO_REFE_NUMB,
		    static::PHYS_MEDI,
		    static::PICK_SHEE_NUMB,
		    static::PICT_OF_A_GENE_PROD,
		    static::PICT_OF_ACTU_PROD,
		    static::PILO_SERV_EXEM_NUMB,
		    static::PIPE_NUMB,
		    static::PLAC_OF_PACK_APPR_NUMB,
		    static::PLAC_OF_POSI_REFE,
		    static::PLAN_PACK,
		    static::PLAN_NUMB,
		    static::PLOT_FILE,
		    static::POLI_FORM_NUMB,
		    static::POLI_NUMB,
		    static::POST_REFE,
		    static::PREA_NUMB,
		    static::PREM_RATE_TABL,
		    static::PRES_BANK_REFE,
		    static::PREV_BANK_STAT_MESS_REFE,
		    static::PREV_CARG_CONT_NUMB,
		    static::PREV_CRED_ADVI_REFE_NUMB,
		    static::PREV_DELI_INST_NUMB,
		    static::PREV_DELI_SCHE_NUMB,
		    static::PREV_HIGH_SCHE_NUMB,
		    static::PREV_INVO_NUMB,
		    static::PREV_MEMB_NUMB,
		    static::PREV_RENT_AGRE_NUMB,
		    static::PREV_REQU_FOR_METE_READ_REFE_NUMB,
		    static::PREV_SCHE_NUMB,
		    static::PREV_TAX_CONT_NUMB,
		    static::PRIC_LIST_NUMB,
		    static::PRIC_LIST_VERS_NUMB,
		    static::PRIC_QUOT_NUMB,
		    static::PRIC_VARI_FORM_REFE_NUMB,
		    static::PRIC_CATA_RESP_REFE_NUMB,
		    static::PRIM_REFE,
		    static::PRIM_CONT_CONT_NUMB,
		    static::PRIN_REFE_NUMB,
		    static::PRIN_BANK_REFE,
		    static::PRIN_REFE,
		    static::PRIO_CONT_REGI_NUMB,
		    static::PRIO_DATA_UNIV_NUMB_SYST_DUNS_NUMB,
		    static::PRIO_POLI_NUMB,
		    static::PRIO_PURC_ORDE_NUMB,
		    static::PRIO_TRAD_PART_IDEN_NUMB,
		    static::PROC_PLAN_NUMB,
		    static::PROC_BUDG_NUMB,
		    static::PROD_CERT_NUMB,
		    static::PROD_CHAN_AUTH_NUMB,
		    static::PROD_CHAR_DIRE,
		    static::PROD_DATA_FILE_NUMB,
		    static::PROD_INQU_NUMB,
		    static::PROD_RESE_NUMB,
		    static::PROD_SOUR_AGRE_NUMB,
		    static::PROD_SPEC_REFE_NUMB,
		    static::PROD_CODE,
		    static::PROF_NUMB,
		    static::PROF_INVO_DOCU_IDEN,
		    static::PROJ_NUMB,
		    static::PROJ_SPEC_NUMB,
		    static::PROM_DEAL_NUMB,
		    static::PROO_OF_DELI_REFE_NUMB,
		    static::PROP_PURC_ORDE_REFE_NUMB,
		    static::PUBL_FILI_REGI_NUMB,
		    static::PUBL_ISSU_NUMB,
		    static::PURC_FOR_EXPO_CUST_AGRE_NUMB,
		    static::PURC_ORDE_CHAN_NUMB,
		    static::PURC_ORDE_NUMB_SUFF,
		    static::PURC_ORDE_RESP_NUMB,
		    static::PURC_REQU_REFE,
		    static::PURC_ACTI_CLAU_NUMB,
		    static::QUAN_VALU_NUMB,
		    static::QUAN_VALU_REQU_NUMB,
		    static::QUAR_STAT_REFE_NUMB,
		    static::QUOT_NUMB,
		    static::RAIL_WAYB_NUMB,
		    static::RAIL_ROUT_CODE,
		    static::RAIL_CONS_NOTE_NUMB,
		    static::RAIL_WAGO_NUMB,
		    static::RATE_CODE_NUMB,
		    static::RATE_NOTE_NUMB,
		    static::RECE_FILE_REFE_NUMB,
		    static::RECE_ADVI_NUMB,
		    static::RECE_BANK_AUTH_NUMB,
		    static::RECE_BANK_NUMB,
		    static::RECE_PART_MEMB_IDEN,
		    static::REFE_NUMB_ASSI_BY_THIR_PART,
		    static::REFE_NUMB_OF_A_REQU_FOR_METE_READ,
		    static::REFE_NUMB_QUOT_ON_STAT,
		    static::REFE_NUMB_TO_PREV_MESS,
		    static::REFE_TO_ACCO_SERV_BANK_MESS,
		    static::REFE_PROD_FOR_CHEM_ANAL,
		    static::REFE_PROD_FOR_MECH_ANAL,
		    static::REGI_FEDE_DE_CONT,
		    static::REGI_CAPI_REFE,
		    static::REGI_CONT_ACTI_TYPE,
		    static::REGI_NUMB_OF_PREV_CUST_DECL,
		    static::REGI_INFO_FISC_RIF_NUMB,
		    static::REGI_UNIC_DE_CONT_RUC_NUMB,
		    static::REGI_UNIC_TRIB_RUT,
		    static::REIN_CLAI_NUMB,
		    static::RELA_DOCU_NUMB,
		    static::RELA_PART,
		    static::RELE_NUMB,
		    static::REMI_ADVI_NUMB,
		    static::REMI_BANK_REFE,
		    static::REPA_DATA_REQU_NUMB,
		    static::REPA_ESTI_NUMB,
		    static::REPL_METE_UNIT_NUMB,
		    static::REPL_PART_NUMB,
		    static::REPL_PURC_ORDE_NUMB,
		    static::REPL_PURC_ORDE_RANG_END_NUMB,
		    static::REPL_PURC_ORDE_RANG_STAR_NUMB,
		    static::REPO_NUMB,
		    static::REPO_FORM_NUMB,
		    static::REQU_FOR_CANC_NUMB,
		    static::REQU_FOR_QUOT_NUMB,
		    static::REQU_NUMB,
		    static::RESE_OFFI_IDEN,
		    static::RESE_STAT_INDE,
		    static::RESE_GOOD_IDEN,
		    static::RETU_CONT_REFE_NUMB,
		    static::RETU_NOTI_NUMB,
		    static::ROAD_CONS_NOTE_NUMB,
		    static::SAFE_CUST_NUMB,
		    static::SAFE_DEPO_BOX_NUMB,
		    static::SALE_DEPA_NUMB,
		    static::SALE_FORE_NUMB,
		    static::SALE_OFFI_NUMB,
		    static::SALE_PERS_NUMB,
		    static::SALE_REGI_NUMB,
		    static::SALE_REPO_NUMB,
		    static::SCAN_LINE,
		    static::SCHE_NUMB,
		    static::SECO_BENE_REFE,
		    static::SECO_CUST_REFE,
		    static::SECR_NUMB,
		    static::SECU_DELI_TERM_AND_COND_AGRE_REFE,
		    static::SELL_CATA_NUMB,
		    static::SELL_REFE_NUMB,
		    static::SEND_CLAU_NUMB,
		    static::SEND_FILE_REFE_NUMB,
		    static::SEND_REFE_TO_THE_ORIG_MESS,
		    static::SEND_BANK_REFE_NUMB,
		    static::SEND_BANK_NUMB,
		    static::SERI_NUMB,
		    static::SERI_SHIP_CONT_CODE,
		    static::SERV_CATE_REFE,
		    static::SERV_GROU_IDEN_NUMB,
		    static::SERV_PROV,
		    static::SERV_RELA_NUMB,
		    static::SHIP_FROM,
		    static::SHIP_NOTI_NUMB,
		    static::SHIP_STAY_REFE_NUMB,
		    static::SHIP_REFE_NUMB,
		    static::SHIP_AUTH_NUMB,
		    static::SHIP_LABE_SERI_NUMB,
		    static::SHIP_NOTE_NUMB,
		    static::SHIP_UNIT_IDEN,
		    static::SID_SHIP_IDEN_NUMB_FOR_SHIP,
		    static::SIGN_CODE_NUMB,
		    static::SING_TRAN_SEQU_NUMB,
		    static::SITE_SPEC_PROC_TERM_AND_COND_NUMB,
		    static::SITU_NUMB,
		    static::SLAU_PLAN_NUMB,
		    static::SLAU_APPR_NUMB,
		    static::SOCI_SECU_NUMB,
		    static::SOFT_EDIT_REFE,
		    static::SOFT_QUAL_REFE,
		    static::SOFT_REFE,
		    static::SOUR_DOCU_INTE_REFE,
		    static::SPEC_BUDG_ACCO_NUMB,
		    static::SPEC_INST_NUMB,
		    static::SPEC_NUMB,
		    static::SPLI_DELI_NUMB,
		    static::STAN_CARR_ALPH_CODE_SCAC_NUMB,
		    static::STAN_INDU_CLAS_SIC_NUMB,
		    static::STAN_NUMB_OF_INSP_DOCU,
		    static::STAN_CODE_NUMB,
		    static::STAN_NUMB,
		    static::STAN_VERS_NUMB,
		    static::STAT_OR_PROV_ASSI_ENTI_IDEN,
		    static::STAT_NUMB,
		    static::STAT_OF_WORK,
		    static::STAT_REFE_NUMB,
		    static::STAT_BUND_AMT_SBA_IDEN,
		    static::STAT_REPO_NUMB,
		    static::STOC_ADJU_NUMB,
		    static::STOC_EXCH_COMP_IDEN,
		    static::STOC_KEEP_UNIT_NUMB,
		    static::SUB_FILE,
		    static::SUBH_BILL_OF_LADI_NUMB,
		    static::SUBS_AIR_WAYB_NUMB,
		    static::SUFFIX,
		    static::SUPP_CONT_NUMB,
		    static::SUPP_CRED_CLAI_REFE_NUMB,
		    static::SUPP_CUST_REFE_NUMB,
		    static::SWAP_ORDE_NUMB,
		    static::SYMB_NUMB,
		    static::SYST_INFO_POUR_LE_REPE_DES_ENTR_SIRE_NUMB,
		    static::SYST_INFO_POUR_LE_REPE_DES_ETAB_SIRE_NUMB,
		    static::TARI_NUMB,
		    static::TAX_EXEM_LICE_NUMB,
		    static::TAX_PAYM_IDEN,
		    static::TAX_REGI_NUMB,
		    static::TEAM_ASSI_NUMB,
		    static::TECH_DOCU_NUMB,
		    static::TECH_ORDE_NUMB,
		    static::TECH_PHAS_REFE,
		    static::TECH_REGU,
		    static::TELE_MESS_NUMB,
		    static::TERM_OPER_CONS_REFE,
		    static::TEST_REPO_NUMB,
		    static::TEST_SPEC_NUMB,
		    static::TEXT_ELEM_IDEN_DELE_REFE,
		    static::THIR_BANK_REFE,
		    static::THRO_BILL_OF_LADI_NUMB,
		    static::TICK_CONT_NUMB,
		    static::TIME_SERI_REFE,
		    static::TIR_CARN_NUMB,
		    static::TOKY_SHOK_RESE_TSR_BUSI_IDEN,
		    static::TOOL_CONT_NUMB,
		    static::TRAC_PART_IDEN,
		    static::TRAD_ACCO_NUMB,
		    static::TRAD_PART_IDEN_NUMB,
		    static::TRAI_FLIG_NUMB,
		    static::TRAN_REFE_NUMB,
		    static::TRAN_NUMB,
		    static::TRAN_ONWA_CARR_GUAR_BOND_NUMB,
		    static::TRAN_CONT_DOCU_IDEN,
		    static::TRAN_CONT_REFE_NUMB,
		    static::TRAN_COST_REFE_NUMB,
		    static::TRAN_EQUI_ACCE_ORDE_REFE,
		    static::TRAN_EQUI_GROS_MASS_VERI_ORDE_REFE,
		    static::TRAN_EQUI_GROS_MASS_VERI_REFE_NUMB,
		    static::TRAN_EQUI_IDEN,
		    static::TRAN_EQUI_RELE_ORDE_REFE,
		    static::TRAN_EQUI_RETU_REFE,
		    static::TRAN_EQUI_SEAL_IDEN,
		    static::TRAN_EQUI_STRI_ORDE,
		    static::TRAN_EQUI_STUF_ORDE,
		    static::TRAN_EQUI_SURV_REFE,
		    static::TRAN_EQUI_SURV_REFE_NUMB,
		    static::TRAN_EQUI_SURV_REPO_NUMB,
		    static::TRAN_INST_NUMB,
		    static::TRAN_MEAN_JOUR_IDEN,
		    static::TRAN_ROUT,
		    static::TRAN_SECT_REFE_NUMB,
		    static::TRAN_STAT_REPO_NUMB,
		    static::TRAN_ACCO_NUMB,
		    static::TRAN_CONT_NUMB_TCN,
		    static::TRAN_EXPO_NO_FOR_IN_BOND_MOVE,
		    static::TRAV_SERV,
		    static::TREA_NUMB,
		    static::TRUC_BILL_OF_LADI,
		    static::US_CODE_OF_FEDE_REGU_CFR,
		    static::US_DEFE_FEDE_ACQU_REGU_SUPP,
		    static::US_DEPA_OF_VETE_AFFA_ACQU_REGU,
		    static::US_FEDE_ACQU_REGU,
		    static::US_FEDE_INFO_RESO_MANA_REGU,
		    static::US_GENE_SERV_ADMI_REGU,
		    static::ULTI_CUST_ORDE_NUMB,
		    static::ULTI_CUST_REFE_NUMB,
		    static::UNIF_RESO_IDEN,
		    static::UNIQ_CLAI_REFE_NUMB_OF_THE_SEND,
		    static::UNIQ_CONS_REFE_NUMB,
		    static::UNIQ_GOOD_SHIP_IDEN,
		    static::UNIQ_MARK_REFE,
		    static::UNIT_NATI_DANG_GOOD_IDEN,
		    static::UPPE_NUMB_OF_RANG,
		    static::US_CUST_SERV_USCS_ENTR_CODE,
		    static::US_GOVE_AGEN_NUMB,
		    static::US_DEPA_OF_TRAN_BOND_SURE_CODE,
		    static::US_FEDE_COMM_COMM_FCC_IMPO_COND_NUMB,
		    static::US_FOOD_AND_DRUG_ADMI_ESTA_INDI,
		    static::VAT_REGI_NUMB,
		    static::VEHI_IDEN_NUMB_VIN,
		    static::VEHI_LICE_NUMB,
		    static::VEND_CONT_NUMB,
		    static::VEND_ID_NUMB,
		    static::VEND_ORDE_NUMB_SUFF,
		    static::VEND_PROD_NUMB,
		    static::VESS_IDEN,
		    static::VOUC_NUMB,
		    static::VOYA_NUMB,
		    static::WAGE_DETE_NUMB,
		    static::WARE_ENTR_NUMB,
		    static::WARE_RECE_NUMB,
		    static::WARE_STOR_LOCA_NUMB,
		    static::WAYB_NUMB,
		    static::WEIG_AGRE_NUMB,
		    static::WELL_NUMB,
		    static::WOOL_IDEN_NUMB,
		    static::WOOL_TAX_REFE_NUMB,
		    static::WORK_BREA_STRU,
		    static::WORK_ITEM_QUAN_DETE,
		    static::WORK_ORDE,
		    static::WORK_PACK,
		    static::WORK_SHIF,
		    static::WORK_TASK_CHAR_NUMB,
		    static::WORK_TEAM,
		];
	}


	/**
	 * Returns an array of code descriptions indexed by code
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	final public static function getAllCodeDescriptions(): array
	{
		return [
		    static::ACCI_REFE_NUMB => 'Accident reference number',
		    static::ACCO_NUMB => 'Account number',
		    static::ACCO_PART_BANK_REFE => 'Account party\'s bank reference',
		    static::ACCO_PART_REFE => 'Account party\'s reference',
		    static::ACCO_PAYA_NUMB => 'Account payable number',
		    static::ACCO_SERV_BANK_REFE_NUMB => 'Account servicing bank\'s reference number',
		    static::ACCO_ENTR => 'Accounting entry',
		    static::ACCO_FILE_REFE => 'Accounting file reference',
		    static::ACCO_TRAN_NUMB => 'Accounting transmission number',
		    static::ACCO_RECE_NUMB => 'Accounts receivable number',
		    static::ACTI_AUTH_NUMB => 'Action authorization number',
		    static::ACTI_PRIN_EXER_APE_IDEN => 'Activite Principale Exercee (APE) identifier',
		    static::ADDI_REFE_NUMB => 'Additional reference number',
		    static::ADDR_REFE => 'Addressee reference',
		    static::ADMI_REFE_CODE => 'Administrative Reference Code',
		    static::ADVI_THRO_BANK_REFE => 'Advise through bank\'s reference',
		    static::ADVI_BANK_REFE => 'Advising bank\'s reference',
		    static::AGEN_CLAU_NUMB => 'Agency clause number',
		    static::AGEN_BANK_REFE => 'Agent\'s bank reference',
		    static::AGEN_REFE => 'Agent\'s reference',
		    static::AGER_AERO_GROU_EQUI_REQU_DATA_NUMB => 'AGERD (Aerospace Ground Equipment Requirement Data) number',
		    static::AGRE_NUMB => 'Agreement number',
		    static::AGRE_TO_PAY_NUMB => 'Agreement to pay number',
		    static::AIR_CARG_TRAN_MANI => 'Air cargo transfer manifest',
		    static::AIR_WAYB_NUMB => 'Air waybill number',
		    static::AIRL_FLIG_IDEN_NUMB => 'Airlines flight identification number',
		    static::ALLO_SEAT => 'Allocated seat',
		    static::ALLO_IDEN_AIR => 'Allotment identification (Air)',
		    static::ANAL_NUMB_NUMB => 'Analysis number/test number',
		    static::ANIM_FARM_LICE_NUMB => 'Animal farm licence number',
		    static::ANTI_CASE_NUMB => 'Anti-dumping case number',
		    static::APPL_COEF_IDEN_NUMB => 'Applicable coefficient identification number',
		    static::APPL_INST_OR_STAN => 'Applicable instructions or standards',
		    static::APPL_BANK_REFE => 'Applicant\'s bank reference',
		    static::APPL_REFE => 'Applicant\'s reference',
		    static::APPL_FOR_FINA_SUPP_REFE_NUMB => 'Application for financial support reference number',
		    static::APPL_REFE_NUMB => 'Application reference number',
		    static::APPR_NUMB => 'Appropriation number',
		    static::ARTI_NUMB => 'Article number',
		    static::ASSE_NUMB => 'Assembly number',
		    static::ASSO_INVO => 'Associated invoices',
		    static::ASSU_COMP => 'Assuming company',
		    static::ATA_CARN_NUMB => 'ATA carnet number',
		    static::AUTH_FOR_REPA_REFE => 'Authorisation for repair reference',
		    static::AUTH_ISSU_EQUI_IDEN => 'Authority issued equipment identification',
		    static::AUTH_FOR_EXPE_AFE_NUMB => 'Authorization for expense (AFE) number',
		    static::AUTH_NUMB => 'Authorization number',
		    static::AUTH_NUMB_FOR_EXCE_TO_DANG_GOOD_REGU => 'Authorization number for exception to dangerous goods regulations',
		    static::AUTH_TO_MEET_COMP_NUMB => 'Authorization to meet competition number',
		    static::BANK_REFE => 'Bank reference',
		    static::BANK_BATC_INTE_TRAN_REFE_NUMB => 'Bank\'s batch interbank transaction reference number',
		    static::BANK_COMM_TRAN_REFE_NUMB => 'Bank\'s common transaction reference number',
		    static::BANK_DOCU_PROC_REFE => 'Bank\'s documentary procedure reference',
		    static::BANK_INDI_INTE_TRAN_REFE_NUMB => 'Bank\'s individual interbank transaction reference number',
		    static::BANK_INDI_TRAN_REFE_NUMB => 'Bank\'s individual transaction reference number',
		    static::BANK_ACCE => 'Banker\'s acceptance',
		    static::BANK_REFE => 'Bankgiro reference',
		    static::BANK_PROC_NUMB => 'Bankruptcy procedure number',
		    static::BAR_CODE_LABE_SERI_NUMB => 'Bar coded label serial number',
		    static::BATC_NUMB_NUMB => 'Batch number/lot number',
		    static::BATT_AND_ACCU_PROD_REGI_NUMB => 'Battery and accumulator producer registration number',
		    static::BEGI_JOB_SEQU_NUMB => 'Beginning job sequence number',
		    static::BEGI_METE_READ_ACTU => 'Beginning meter reading actual',
		    static::BEGI_METE_READ_ESTI => 'Beginning meter reading estimated',
		    static::BENE_BANK_REFE => 'Beneficiary\'s bank reference',
		    static::BENE_REFE => 'Beneficiary\'s reference',
		    static::BID_NUMB => 'Bid number',
		    static::BILL_OF_LADI_NUMB => 'Bill of lading number',
		    static::BILL_OF_QUAN_NUMB => 'Bill of quantities number',
		    static::BLAN_ORDE_NUMB => 'Blanket order number',
		    static::BLEN_WITH_NUMB => 'Blended with number',
		    static::BOOK_NUMB => 'Book number',
		    static::BORD_NUMB => 'Bordereau number',
		    static::BROK_OR_SALE_OFFI_NUMB => 'Broker or sales office number',
		    static::BROK_REFE => 'Broker reference 1',
		    static::BROK_REFE => 'Broker reference 2',
		    static::BROK_REFE => 'Broker reference 3',
		    static::BUDG_CHAP => 'Budget chapter',
		    static::BURE_SIGN_STAT_REFE => 'Bureau signing (statement reference)',
		    static::BUYE_CATA_NUMB => 'Buyer\'s catalogue number',
		    static::BUYE_CONT_NUMB => 'Buyer\'s contract number',
		    static::BUYE_DEBT_NUMB => 'Buyer\'s debtor number',
		    static::BUYE_FUND_NUMB => 'Buyer\'s fund number',
		    static::BUYE_ITEM_NUMB => 'Buyer\'s item number',
		    static::CAD_FILE_LAYE_CONV => 'CAD file layer convention',
		    static::CADA_GERA_DO_CONT_CGC => 'Cadastro Geral do Contribuinte (CGC)',
		    static::CALENDAR => 'Calendar',
		    static::CALL_OFF_ORDE_NUMB => 'Call off order number',
		    static::CANA_EXCI_ENTR_NUMB => 'Canadian excise entry number',
		    static::CARG_ACCE_ORDE_REFE_NUMB => 'Cargo acceptance order reference number',
		    static::CARG_CONT_NUMB => 'Cargo control number',
		    static::CARG_MANI_NUMB => 'Cargo manifest number',
		    static::CARR_AGEN_REFE_NUMB => 'Carrier\'s agent reference number',
		    static::CARR_REFE_NUMB => 'Carrier\'s reference number',
		    static::CASE_NUMB => 'Case number',
		    static::CASE_OF_NEED_PART_REFE => 'Case of need party\'s reference',
		    static::CATA_SEQU_NUMB => 'Catalogue sequence number',
		    static::CATA_NUMB => 'Catastrophe number',
		    static::CATE_OF_WORK_REFE => 'Category of work reference',
		    static::CDROM => 'CD-ROM',
		    static::CEDE_CLAI_NUMB => 'Cedent\'s claim number',
		    static::CEDI_COMP => 'Ceding company',
		    static::CEIL_FORM_REFE_NUMB => 'Ceiling formula reference number',
		    static::CENT_SECR_LOG_NUMB => 'Central secretariat log number',
		    static::CENT_SECR_LOG_NUMB_CHIL_DATA_MAIN_REQU_DMR => 'Central secretariat log number, child Data Maintenance Request (DMR)',
		    static::CENT_SECR_LOG_NUMB_PARE_DATA_MAIN_REQU_DMR => 'Central secretariat log number, parent Data Maintenance Request (DMR)',
		    static::CERT_OF_CONF => 'Certificate of conformity',
		    static::CHAM_OF_COMM_REGI_NUMB => 'Chamber of Commerce registration number',
		    static::CHAR_CARD_ACCO_NUMB => 'Charge card account number',
		    static::CHAR_NOTE_DOCU_ATTA_INDI => 'Charges note document attachment indicator',
		    static::CHEC_NUMB => 'Checking number',
		    static::CHEQ_NUMB => 'Cheque number',
		    static::CIRC_PUBL_NUMB => 'Circular publication number',
		    static::CIVI_ACTI_NUMB => 'Civil action number',
		    static::CLAV_UNIC_DE_IDEN_TRIB_CUIT => 'Clave Unica de Identificacion Tributaria (CUIT)',
		    static::CLEA_REFE => 'Clearing reference',
		    static::COLD_ROLL_NUMB => 'Cold roll number',
		    static::COLL_BANK_REFE => 'Collecting bank\'s reference',
		    static::COLL_ADVI_DOCU_IDEN => 'Collection advice document identifier',
		    static::COLL_INST_NUMB => 'Collection instrument number',
		    static::COLL_REFE => 'Collection reference',
		    static::COMM_ACCO_SUMM_REFE_NUMB => 'Commercial account summary reference number',
		    static::COMM_NUMB => 'Commodity number',
		    static::COMM_TRAN_REFE_NUMB => 'Common transaction reference number',
		    static::COMP_REGI_OFFI_CRO_NUMB => 'Companies Registry Office (CRO) number',
		    static::COMP_SYND_REFE => 'Company / syndicate reference 1',
		    static::COMP_SYND_REFE => 'Company / syndicate reference 2',
		    static::COMP_ISSU_EQUI_ID => 'Company issued equipment ID',
		    static::COMP_TRAD_ACCO_NUMB => 'Company trading account number',
		    static::COMP_REGI_NUMB => 'Company/place registration number',
		    static::COMP_UNIT_PAYM_REQU_REFE => 'Completed units payment request reference',
		    static::COMP_CODE_NUMB => 'Compliance code number',
		    static::COND_OF_PURC_DOCU_NUMB => 'Condition of purchase document number',
		    static::COND_OF_SALE_DOCU_NUMB => 'Condition of sale document number',
		    static::CONN_LOCA => 'Connected location',
		    static::CONN_POIN_TO_CENT_GRID => 'Connecting point to central grid',
		    static::CONS_FURT_ORDE => 'Consignee\'s further order',
		    static::CONS_INVO_NUMB => 'Consignee\'s invoice number',
		    static::CONS_ORDE_NUMB => 'Consignee\'s order number',
		    static::CONS_REFE => 'Consignee\'s reference',
		    static::CONS_CONT_NUMB => 'Consignment contract number',
		    static::CONS_IDEN_CARR_ASSI => 'Consignment identifier, carrier assigned',
		    static::CONS_IDEN_CONS_ASSI => 'Consignment identifier, consignee assigned',
		    static::CONS_IDEN_CONS_ASSI => 'Consignment identifier, consignor assigned',
		    static::CONS_IDEN_FREI_FORW_ASSI => 'Consignment identifier, freight forwarder assigned',
		    static::CONS_INFO => 'Consignment information',
		    static::CONS_RECE_IDEN => 'Consignment receipt identifier',
		    static::CONS_STOC_CONT => 'Consignment stock contract',
		    static::CONS_FURT_ORDE => 'Consignor\'s further order',
		    static::CONS_INVO_NUMB => 'Consolidated invoice number',
		    static::CONS_ORDE_REFE => 'Consolidated orders\' reference',
		    static::CONS_NOTA => 'Constraint notation',
		    static::CONS_DATA_REQU_NUMB => 'Consumption data request number',
		    static::CONT_DISP_ORDE_REFE_NUMB => 'Container disposition order reference number',
		    static::CONT_OPER_REFE_NUMB => 'Container operators reference number',
		    static::CONT_PREF => 'Container prefix',
		    static::CONT_WORK_ORDE_REFE_NUMB => 'Container work order reference number',
		    static::CONT_RECE_NUMB => 'Container/equipment receipt number',
		    static::CONT_BREA_REFE => 'Contract breakdown reference',
		    static::CONT_DOCU_ADDE_IDEN => 'Contract document addendum identifier',
		    static::CONT_NUMB => 'Contract number',
		    static::CONT_PART_REFE_NUMB => 'Contract party reference number',
		    static::CONT_REGI_NUMB => 'Contractor registration number',
		    static::CONT_REQU_REFE => 'Contractor request reference',
		    static::CONV_POST_NUMB => 'Converted Postgiro number',
		    static::COOP_CONT_NUMB => 'Cooperation contract number',
		    static::COST_ACCO => 'Cost account',
		    static::COST_ACCO_DOCU => 'Cost accounting document',
		    static::COST_CENT => 'Cost centre',
		    static::COST_CENT_ALIG_NUMB => 'Cost centre alignment number',
		    static::COST_RICA_JUDI_NUMB => 'Costa Rican judicial number',
		    static::CRED_MEMO_NUMB => 'Credit memo number',
		    static::CRED_NOTE_NUMB => 'Credit note number',
		    static::CRED_RATI_AGEN_REFE_NUMB => 'Credit rating agency\'s reference number',
		    static::CRED_REFE_NUMB => 'Credit reference number',
		    static::CRED_REFE_NUMB => 'Creditor\'s reference number',
		    static::CURR_INVO_NUMB => 'Current invoice number',
		    static::CUST_CATA_NUMB => 'Customer catalogue number',
		    static::CUST_MATE_SPEC_NUMB => 'Customer material specification number',
		    static::CUST_PROC_SPEC_NUMB => 'Customer process specification number',
		    static::CUST_REFE_NUMB => 'Customer reference number',
		    static::CUST_REFE_NUMB_ASSI_TO_PREV_BALA_OF_PAYM_INFO => 'Customer reference number assigned to previous balance of payment information',
		    static::CUST_SPEC_NUMB => 'Customer specification number',
		    static::CUST_TRAV_SERV_IDEN => 'Customer travel service identifier',
		    static::CUST_COMM_TRAN_REFE_NUMB => 'Customer\'s common transaction reference number',
		    static::CUST_DOCU_PROC_REFE => 'Customer\'s documentary procedure reference',
		    static::CUST_INDI_TRAN_REFE_NUMB => 'Customer\'s individual transaction reference number',
		    static::CUST_UNIT_INVE_NUMB => 'Customer\'s unit inventory number',
		    static::CUST_BIND_RULI_NUMB => 'Customs binding ruling number',
		    static::CUST_DECI_REQU_NUMB => 'Customs decision request number',
		    static::CUST_GUAR_NUMB => 'Customs guarantee number',
		    static::CUST_ITEM_NUMB => 'Customs item number',
		    static::CUST_NONB_RULI_NUMB => 'Customs non-binding ruling number',
		    static::CUST_PREA_RULI_NUMB => 'Customs pre-approval ruling number',
		    static::CUST_PREF_INQU_NUMB => 'Customs preference inquiry number',
		    static::CUST_RELE_CODE => 'Customs release code',
		    static::CUST_TARI_NUMB => 'Customs tariff number',
		    static::CUST_TRAN_NUMB => 'Customs transhipment number',
		    static::CUST_VALU_DECI_NUMB => 'Customs valuation decision number',
		    static::DANG_GOOD_INFO => 'Dangerous Goods information',
		    static::DANG_GOOD_SECU_NUMB => 'Dangerous goods security number',
		    static::DANG_GOOD_TRAN_LICE_NUMB => 'Dangerous goods transport licence number',
		    static::DATA_STRU_TAG => 'Data structure tag',
		    static::DEBI_ACCO_NUMB => 'Debit account number',
		    static::DEBI_CARD_NUMB => 'Debit card number',
		    static::DEBI_LETT_NUMB => 'Debit letter number',
		    static::DEBI_NOTE_NUMB => 'Debit note number',
		    static::DEBI_REFE_NUMB => 'Debit reference number',
		    static::DEBT_REFE_NUMB => 'Debtor\'s reference number',
		    static::DECL_CUST_IDEN_NUMB => 'Declarant\'s Customs identity number',
		    static::DECL_REFE_NUMB => 'Declarant\'s reference number',
		    static::DEFE_PRIO_ALLO_SYST_PRIO_RATI => 'Defense priorities allocation system priority rating',
		    static::DEFE_APPR_NUMB => 'Deferment approval number',
		    static::DELI_NOTE_NUMB => 'Delivery note number',
		    static::DELI_NUMB_TRAN => 'Delivery number (transport)',
		    static::DELI_ORDE_NUMB => 'Delivery order number',
		    static::DELI_ROUT_REFE => 'Delivery route reference',
		    static::DELI_SCHE_NUMB => 'Delivery schedule number',
		    static::DELI_VERI_CERT => 'Delivery verification certificate',
		    static::DEPARTMENT => 'Department',
		    static::DEPA_NUMB => 'Department number',
		    static::DEPA_OF_TRAN_BOND_NUMB => 'Department of transportation bond number',
		    static::DEPO_REFE_NUMB => 'Deposit reference number',
		    static::DESP_ADVI_NUMB => 'Despatch advice number',
		    static::DESP_NOTE_POST_PARC_NUMB => 'Despatch note (post parcels) number',
		    static::DESP_NOTE_DOCU_IDEN => 'Despatch note document identifier',
		    static::DIRE_DEBI_REFE => 'Direct debit reference',
		    static::DIRE_PAYM_VALU_NUMB => 'Direct payment valuation number',
		    static::DIRE_PAYM_VALU_REQU_NUMB => 'Direct payment valuation request number',
		    static::DISP_REFE => 'Dispensation reference',
		    static::DISP_NUMB => 'Dispute number',
		    static::DIST_INVO_NUMB => 'Distributor invoice number',
		    static::DOCK_RECE_NUMB => 'Dock receipt number',
		    static::DOCK_NUMB => 'Docket number',
		    static::DOCU_IDEN => 'Document identifier',
		    static::DOCU_LINE_IDEN => 'Document line identifier',
		    static::DOCU_PAGE_IDEN => 'Document page identifier',
		    static::DOCU_REFE_INTE => 'Document reference, internal',
		    static::DOCU_REFE_ORIG => 'Document reference, original',
		    static::DOCU_VOLU_NUMB => 'Document volume number',
		    static::DOCU_CRED_AMEN_NUMB => 'Documentary credit amendment number',
		    static::DOCU_CRED_IDEN => 'Documentary credit identifier',
		    static::DOCU_PAYM_REFE => 'Documentary payment reference',
		    static::DOME_FLIG_NUMB => 'Domestic flight number',
		    static::DOME_INVE_MANA_CODE => 'Domestic inventory management code',
		    static::DRAW_REFE => 'Drawee\'s reference',
		    static::DRAW_LIST_NUMB => 'Drawing list number',
		    static::DRAW_NUMB => 'Drawing number',
		    static::DUN_AND_BRAD_CANA__DIGI_STAN_INDU_CLAS_SIC_CODE => 'Dun and Bradstreet Canada\'s 8 digit Standard Industrial Classification (SIC) code',
		    static::DUN_AND_BRAD_US__DIGI_STAN_INDU_CLAS_SIC_CODE => 'Dun and Bradstreet US 8 digit Standard Industrial Classification (SIC) code',
		    static::DUTY_FREE_PROD_RECE_AUTH_NUMB => 'Duty free products receipt authorisation number',
		    static::DUTY_FREE_PROD_SECU_NUMB => 'Duty free products security number',
		    static::DUTY_MEMO_NUMB => 'Duty memo number',
		    static::ECON_OPER_REGI_AND_IDEN_NUMB_EORI => 'Economic Operators Registration and Identification Number (EORI)',
		    static::ELEC_AND_ELEC_EQUI_PROD_REGI_NUMB => 'Electrical and electronic equipment producer registration number',
		    static::EMBA_NUMB => 'Embargo number',
		    static::EMBA_PERM_NUMB => 'Embargo permit number',
		    static::EMPL_IDEN_NUMB_OF_SERV_BURE => 'Employer identification number of service bureau',
		    static::EMPL_IDEN_NUMB => 'Employer\'s identification number',
		    static::EMPT_CONT_BILL_NUMB => 'Empty container bill number',
		    static::END_ITEM_NUMB => 'End item number',
		    static::END_USE_AUTH_NUMB => 'End use authorization number',
		    static::ENDI_JOB_SEQU_NUMB => 'Ending job sequence number',
		    static::ENDI_METE_READ_ACTU => 'Ending meter reading actual',
		    static::ENDI_METE_READ_ESTI => 'Ending meter reading estimated',
		    static::ENQU_NUMB => 'Enquiry number',
		    static::ENTI_REFE_NUMB_PREV => 'Entity reference number, previous',
		    static::ENTR_FLAG => 'Entry flagging',
		    static::ENTR_POIN_ASSE_LOG_NUMB => 'Entry point assessment log number',
		    static::ENTR_POIN_ASSE_LOG_NUMB_CHIL_DMR => 'Entry point assessment log number, child DMR',
		    static::ENTR_POIN_ASSE_LOG_NUMB_PARE_DMR => 'Entry point assessment log number, parent DMR',
		    static::EQUI_NUMB => 'Equipment number',
		    static::EQUI_OWNE_REFE_NUMB => 'Equipment owner reference number',
		    static::EQUI_SEQU_NUMB => 'Equipment sequence number',
		    static::EQUI_TRAN_CHAR_NUMB => 'Equipment transport charge number',
		    static::ERRO_POSI => 'Error position',
		    static::ESTI_ORDE_REFE_NUMB => 'Estimate order reference number',
		    static::ETER_REFE => 'ETERMS reference',
		    static::EUR__CERT_NUMB => 'Eur 1 certificate number',
		    static::EURO_VALU_ADDE_TAX_IDEN => 'European Value Added Tax identification',
		    static::EVEN_REFE_NUMB => 'Event reference number',
		    static::EXCE_TRAN_AUTH_NUMB => 'Exceptional transport authorisation number',
		    static::EXCE_TRAN_NUMB => 'Excess transportation number',
		    static::EXPO_CLEA_INST_REFE_NUMB => 'Export clearance instruction reference number',
		    static::EXPO_CONT_CLAS_NUMB => 'Export control classification number',
		    static::EXPO_CONT_COMM_NUMB_ECCN => 'Export Control Commodity number (ECCN)',
		    static::EXPO_DECL => 'Export declaration',
		    static::EXPO_ESTA_NUMB => 'Export establishment number',
		    static::EXPO_PERM_IDEN => 'Export permit identifier',
		    static::EXPO_REFE_NUMB => 'Export reference number',
		    static::EXPO_REFE_NUMB => 'Exporter\'s reference number',
		    static::EXTE_OBJE_REFE => 'External object reference',
		    static::FEDE_SUPP_SCHE_ITEM_NUMB => 'Federal supply schedule item number',
		    static::FILE_CONV_JOUR => 'File conversion journal',
		    static::FILE_IDEN_NUMB => 'File identification number',
		    static::FILE_LINE_IDEN => 'File line identifier',
		    static::FILE_VERS_NUMB => 'File version number',
		    static::FINA_SEQU_NUMB => 'Final sequence number',
		    static::FINA_CANC_REFE_NUMB => 'Financial cancellation reference number',
		    static::FINA_MANA_REFE => 'Financial management reference',
		    static::FINA_PHAS_REFE => 'Financial phase reference',
		    static::FINA_SETT_PART_REFE_NUMB => 'Financial settlement party\'s reference number',
		    static::FINA_TRAN_REFE_NUMB => 'Financial transaction reference number',
		    static::FIRM_BOOK_REFE_NUMB => 'Firm booking reference number',
		    static::FIRS_FINA_INST_TRAN_REFE => 'First financial institution\'s transaction reference',
		    static::FISC_NUMB => 'Fiscal number',
		    static::FLAT_RACK_CONT_BUND_IDEN_NUMB => 'Flat rack container bundle identification number',
		    static::FLOW_REFE_NUMB => 'Flow reference number',
		    static::FORE_EXCH => 'Foreign exchange',
		    static::FORE_EXCH_CONT_NUMB => 'Foreign exchange contract number',
		    static::FORE_MILI_SALE_NUMB => 'Foreign military sales number',
		    static::FORE_RESI_IDEN_NUMB => 'Foreign resident identification number',
		    static::FORM_REPO_NUMB => 'Formal report number',
		    static::FORM_STAT_REFE => 'Formal statement reference',
		    static::FORM_REFE_NUMB => 'Formula reference number',
		    static::FORW_ORDE_NUMB => 'Forwarding order number',
		    static::FRAM_AGRE_NUMB => 'Framework Agreement Number',
		    static::FREE_ZONE_IDEN => 'Free zone identifier',
		    static::FREI_BILL_NUMB => 'Freight bill number',
		    static::FREI_FORW_NUMB => 'Freight Forwarder number',
		    static::FUNC_WORK_GROU => 'Functional work group',
		    static::FUND_ACCO_NUMB => 'Fund account number',
		    static::FUND_CODE_NUMB => 'Fund code number',
		    static::GENE_CARG_CONS_REFE_NUMB => 'General cargo consignment reference number',
		    static::GENE_DECL_NUMB => 'General declaration number',
		    static::GENE_ORDE_NUMB => 'General order number',
		    static::GENE_PURP_MESS_REFE_NUMB => 'General purpose message reference number',
		    static::GOOD_AND_SERV_TAX_IDEN_NUMB => 'Goods and Services Tax identification number',
		    static::GOOD_DECL_DOCU_IDEN_CUST => 'Goods declaration document identifier, Customs',
		    static::GOOD_DECL_NUMB => 'Goods declaration number',
		    static::GOOD_ITEM_INFO => 'Goods item information',
		    static::GOVE_AGEN_REFE_NUMB => 'Government agency reference number',
		    static::GOVE_BILL_OF_LADI => 'Government bill of lading',
		    static::GOVE_CONT_NUMB => 'Government contract number',
		    static::GOVE_QUAL_ASSU_AND_CONT_LEVE_NUMB => 'Government quality assurance and control level Number',
		    static::GOVE_REFE_NUMB => 'Government reference number',
		    static::GRID_OPER_CUST_REFE_NUMB => 'Grid operator\'s customer reference number',
		    static::GROU_ACCO => 'Group accounting',
		    static::GROU_REFE_NUMB => 'Group reference number',
		    static::GUAR_NUMB => 'Guarantee number',
		    static::HAND_AND_MOVE_REFE_NUMB => 'Handling and movement reference number',
		    static::HARM_SYST_NUMB => 'Harmonised system number',
		    static::HASH_VALU => 'Hash value',
		    static::HAST_NUMB => 'Hastening number',
		    static::HOT_ROLL_NUMB => 'Hot roll number',
		    static::HOUS_BILL_OF_LADI_NUMB => 'House bill of lading number',
		    static::HOUS_WAYB_NUMB => 'House waybill number',
		    static::HYGI_CERT_NUMB_NATI => 'Hygienic Certificate number, national',
		    static::IATA_CARG_AGEN_CASS_ADDR_NUMB => 'IATA Cargo Agent CASS Address number',
		    static::IATA_CARG_AGEN_CODE_NUMB => 'IATA cargo agent code number',
		    static::IMAG_REFE => 'Image reference',
		    static::IMME_EXPO_NO_FOR_IN_BOND_MOVE => 'Immediate exportation no. for in bond movement',
		    static::IMME_TRAN_NO_FOR_IN_BOND_MOVE => 'Immediate transportation no. for in bond movement',
		    static::IMPL_VERS_NUMB => 'Implementation version number',
		    static::IMPO_CLEA_INST_REFE_NUMB => 'Import clearance instruction reference number',
		    static::IMPO_PERM_IDEN => 'Import permit identifier',
		    static::IMPO_REFE_NUMB => 'Importer reference number',
		    static::IMPO_LETT_OF_CRED_REFE => 'Importer\'s letter of credit reference',
		    static::IMPU_ACCO => 'Imputation account',
		    static::IN_BOND_NUMB => 'In bond number',
		    static::INCO_LEGA_REFE => 'Incorporated legal reference',
		    static::INDI_TRAN_REFE_NUMB => 'Individual transaction reference number',
		    static::INIT_SAMP_INSP_REPO_NUMB => 'Initial sample inspection report number',
		    static::INLA_TRAN_ORDE_NUMB => 'Inland transport order number',
		    static::INST_BELG_DE_CODI_IBLC_NUMB => 'Institut Belgo-Luxembourgeois de Codification (IBLC) number',
		    static::INST_OF_SECU_AND_FUTU_MARK_DEVE_ISFM_SERI_NUMB => 'Institute of Security and Future Market Development (ISFMD) serial number',
		    static::INST_FOR_RETU_NUMB => 'Instruction for returns number',
		    static::INST_TO_DESP_REFE_NUMB => 'Instruction to despatch reference number',
		    static::INSU_CERT_REFE_NUMB => 'Insurance certificate reference number',
		    static::INSU_CONT_REFE_NUMB => 'Insurance contract reference number',
		    static::INSU_ASSI_REFE_NUMB => 'Insurer assigned reference number',
		    static::INTE_LOGI_SUPP_CROS_REFE_NUMB => 'Integrated logistic support cross reference number',
		    static::INTE_NUMB_NEW => 'Interchange number new',
		    static::INTE_NUMB_OLD => 'Interchange number old',
		    static::INTE_BROK => 'Intermediary broker',
		    static::INTE_CUST_NUMB => 'Internal customer number',
		    static::INTE_DATA_PROC_NUMB => 'Internal data process number',
		    static::INTE_ORDE_NUMB => 'Internal order number',
		    static::INTE_VEND_NUMB => 'Internal vendor number',
		    static::INTE_ASSE_LOG_NUMB => 'International assessment log number',
		    static::INTE_ASSE_LOG_NUMB_CHIL_DATA_MAIN_REQU_DMR => 'International assessment log number, child Data Maintenance Request (DMR)',
		    static::INTE_ASSE_LOG_NUMB_PARE_DATA_MAIN_REQU_DMR => 'International assessment log number, parent Data Maintenance Request (DMR)',
		    static::INTE_FLIG_NUMB => 'International flight number',
		    static::INTE_STAN_INDU_CLAS_ISIC_CODE => 'International Standard Industrial Classification (ISIC) code',
		    static::INTR_ROUT => 'Intra-plant routing',
		    static::INVE_REPO_REFE_NUMB => 'Inventory report reference number',
		    static::INVE_REPO_REQU_NUMB => 'Inventory report request number',
		    static::INVE_REFE_NUMB => 'Investment reference number',
		    static::INVO_DOCU_IDEN => 'Invoice document identifier',
		    static::INVO_NUMB_SUFF => 'Invoice number suffix',
		    static::INVO_DATA_SHEE_REFE_NUMB => 'Invoicing data sheet reference number',
		    static::IRON_CHAR_NUMB => 'Iron charge number',
		    static::ISSU_PRES_IDEN => 'Issued prescription identification',
		    static::ISSU_BANK_REFE => 'Issuing bank\'s reference',
		    static::JOB_NUMB => 'Job number',
		    static::JOIN_VENT_REFE_NUMB => 'Joint venture reference number',
		    static::JUDG_NUMB => 'Judgment number',
		    static::KAME_VAN_KOOP_KVK_NUMB => 'Kamer Van Koophandel (KVK) number',
		    static::LABO_REGI_NUMB => 'Laboratory registration number',
		    static::LAST_RECE_BANK_STAT_MESS_REFE => 'Last received banking status message reference',
		    static::LATE_ACCO_ENTR_RECO_REFE => 'Latest accounting entry record reference',
		    static::LEAS_CONT_REFE => 'Lease contract reference',
		    static::LETT_OF_CRED_NUMB => 'Letter of credit number',
		    static::LLOY_CLAI_OFFI_REFE => 'Lloyd\'s claims office reference',
		    static::LOAD_PLAN_NUMB => 'Load planning number',
		    static::LOAD_AUTH_IDEN => 'Loading authorisation identifier',
		    static::LOAN => 'Loan',
		    static::LOCA_REFE_NUMB => 'Local Reference Number',
		    static::LOCKBOX => 'Lockbox',
		    static::LOSS_NUMB => 'Loss/event number',
		    static::LOWE_NUMB_IN_RANG => 'Lower number in range',
		    static::MAIL_REFE_NUMB => 'Mailing reference number',
		    static::MAJO_FORC_PROG_NUMB => 'Major force program number',
		    static::MAND_REFE => 'Mandate Reference',
		    static::MANU_PROC_AUTH_NUMB => 'Manual processing authority number',
		    static::MANU_DEFI_REPA_RATE_REFE => 'Manufacturer defined repair rates reference',
		    static::MANU_MATE_SAFE_DATA_SHEE_NUMB => 'Manufacturer\'s material safety data sheet number',
		    static::MANU_PART_NUMB => 'Manufacturer\'s part number',
		    static::MANU_ORDE_NUMB => 'Manufacturing order number',
		    static::MANU_QUAL_AGRE_NUMB => 'Manufacturing quality agreement number',
		    static::MARK_PLAN_IDEN_NUMB_MPIN => 'Marketing plan identification number (MPIN)',
		    static::MARK_REFE => 'Marking/label reference',
		    static::MAST_ACCO_NUMB => 'Master account number',
		    static::MAST_AIR_WAYB_NUMB => 'Master air waybill number',
		    static::MAST_BILL_OF_LADI_NUMB => 'Master bill of lading number',
		    static::MAST_LABE_NUMB => 'Master label number',
		    static::MAST_SOLI_PROC_TERM_AND_COND_NUMB => 'Master solicitation procedures, terms, and conditions number',
		    static::MATC_OF_ENTR_BALA => 'Matching of entries, balanced',
		    static::MATC_OF_ENTR_UNBA => 'Matching of entries, unbalanced',
		    static::MATU_CERT_OF_DEPO => 'Matured certificate of deposit',
		    static::MEAT_CUTT_PLAN_APPR_NUMB => 'Meat cutting plant approval number',
		    static::MEAT_PROC_ESTA_REGI_NUMB => 'Meat processing establishment registration number',
		    static::MEMB_NUMB => 'Member number',
		    static::MESS_BATC_NUMB => 'Message batch number',
		    static::MESS_DESI_GROU_NUMB => 'Message design group number',
		    static::MESS_RECI => 'Message recipient',
		    static::MESS_SEND => 'Message sender',
		    static::METE_READ_AT_THE_BEGI_OF_THE_DELI => 'Meter reading at the beginning of the delivery',
		    static::METE_READ_AT_THE_END_OF_DELI => 'Meter reading at the end of delivery',
		    static::METE_UNIT_NUMB => 'Meter unit number',
		    static::METE_SERV_CONS_REPO_NUMB => 'Metered services consumption report number',
		    static::METE_POIN => 'Metering point',
		    static::MILI_INTE_PURC_REQU_MIPR_NUMB => 'Military Interdepartmental Purchase Request (MIPR) number',
		    static::MINI_CERT_OF_HOMO => 'Ministerial certificate of homologation',
		    static::MODEL => 'Model',
		    static::MOTO_VEHI_IDEN_NUMB => 'Motor vehicle identification number',
		    static::MOVE_REFE_NUMB => 'Movement reference number',
		    static::MUNI_ASSI_BUSI_REGI_NUMB => 'Municipality assigned business registry number',
		    static::MUTU_DEFI_REFE_NUMB => 'Mutually defined reference number',
		    static::NAME_BANK_REFE => 'Named bank\'s reference',
		    static::NATI_GOVE_BUSI_IDEN_NUMB => 'National government business identification number',
		    static::NET_AREA => 'Net area',
		    static::NET_AREA_SUPP_REFE => 'Net area supplier reference',
		    static::NEXT_RENT_AGRE_NUMB => 'Next rental agreement number',
		    static::NEXT_RENT_AGRE_REAS_NUMB => 'Next rental agreement reason number',
		    static::NOME_ACTI_CLAS_ECON_NACE_IDEN => 'Nomenclature Activity Classification Economy (NACE) identifier',
		    static::NOMI_NUMB => 'Nomination number',
		    static::NONN_MARI_TRAN_DOCU_NUMB => 'Non-negotiable maritime transport document number',
		    static::NORM_ACTI_FRAN_NAF_IDEN => 'Norme Activite Francaise (NAF) identifier',
		    static::NORT_AMER_HAZA_GOOD_CLAS_NUMB => 'North American hazardous goods classification number',
		    static::NOTA_FISC => 'Nota Fiscal',
		    static::NOTI_FOR_COLL_NUMB_NOTI => 'NOTIfication for COLlection number (NOTICOL)',
		    static::NUMB_OF_TEMP_IMPO_DOCU => 'Number of temporary importation document',
		    static::NUME_DE_IDEN_TRIB_NIT => 'Numero de Identificacion Tributaria (NIT)',
		    static::OFFE_NUMB => 'Offer number',
		    static::ORDE_ACKN_DOCU_IDEN => 'Order acknowledgement document identifier',
		    static::ORDE_DOCU_IDEN_BUYE_ASSI => 'Order document identifier, buyer assigned',
		    static::ORDE_NUMB_VEND => 'Order number (vendor)',
		    static::ORDE_SHIP_GROU_REFE => 'Order shipment grouping reference',
		    static::ORDE_STAT_ENQU_NUMB => 'Order status enquiry number',
		    static::ORDE_CUST_CONS_REFE_NUMB => 'Ordering customer consignment reference number',
		    static::ORDE_CUST_SECO_REFE_NUMB => 'Ordering customer\'s second reference number',
		    static::ORGA_BREA_STRU => 'Organisation breakdown structure',
		    static::ORIG_CERT_NUMB => 'Original certificate number',
		    static::ORIG_FILI_NUMB => 'Original filing number',
		    static::ORIG_MAND_REFE => 'Original Mandate Reference',
		    static::ORIG_PURC_ORDE => 'Original purchase order',
		    static::ORIG_SUBM_LOG_NUMB => 'Original submitter log number',
		    static::ORIG_SUBM_CHIL_DATA_MAIN_REQU_DMR_LOG_NUMB => 'Original submitter, child Data Maintenance Request (DMR) log number',
		    static::ORIG_SUBM_PARE_DATA_MAIN_REQU_DMR_LOG_NUMB => 'Original submitter, parent Data Maintenance Request (DMR) log number',
		    static::ORIG_REFE => 'Originator\'s reference',
		    static::OUTE_UNIT_IDEN => 'Outerpackaging unit identification',
		    static::PACK_NUMB => 'Package number',
		    static::PACK_SPEC_NUMB => 'Packaging specification number',
		    static::PACK_UNIT_IDEN => 'Packaging unit identification',
		    static::PACK_LIST_NUMB => 'Packing list number',
		    static::PACK_PLAN_NUMB => 'Packing plant number',
		    static::PARAGRAPH => 'Paragraph',
		    static::PARE_FILE => 'Parent file',
		    static::PART_REFE_INDI_IN_A_DRAW => 'Part reference indicator in a drawing',
		    static::PART_SHIP_IDEN => 'Partial shipment identifier',
		    static::PART_INFO_MESS_REFE => 'Party information message reference',
		    static::PART_REFE => 'Party reference',
		    static::PART_SEQU_NUMB => 'Party sequence number',
		    static::PASS_RESE_NUMB => 'Passenger reservation number',
		    static::PASS_NUMB => 'Passport number',
		    static::PASSWORD => 'Password',
		    static::PATR_NUMB => 'Patron number',
		    static::PAYE_FINA_INST_ACCO_NUMB => 'Payee\'s financial institution account number',
		    static::PAYE_FINA_INST_TRAN_ROUT_NO => 'Payee\'s financial institution transit routing No.',
		    static::PAYE_REFE_NUMB => 'Payee\'s reference number',
		    static::PAYE_FINA_INST_ACCO_NUMB => 'Payer\'s financial institution account number',
		    static::PAYE_FINA_INST_TRAN_ROUT_NOAC_TRAN => 'Payer\'s financial institution transit routing No.(ACH transfers)',
		    static::PAYE_REFE_NUMB => 'Payer\'s reference number',
		    static::PAYM_IN_ADVA_REQU_REFE => 'Payment in advance request reference',
		    static::PAYM_INST_REFE_NUMB => 'Payment instalment reference number',
		    static::PAYM_ORDE_NUMB => 'Payment order number',
		    static::PAYM_PLAN_REFE => 'Payment plan reference',
		    static::PAYM_REFE => 'Payment reference',
		    static::PAYM_VALU_NUMB => 'Payment valuation number',
		    static::PAYR_DEDU_ADVI_REFE => 'Payroll deduction advice reference',
		    static::PAYR_NUMB => 'Payroll number',
		    static::PERF_PRES_IDEN => 'Performed prescription identification',
		    static::PERS_REGI_NUMB => 'Person registration number',
		    static::PERS_IDEN_CARD_NUMB => 'Personal identity card number',
		    static::PHON_NUMB => 'Phone number',
		    static::PHYS_INVE_RECO_REFE_NUMB => 'Physical inventory recount reference number',
		    static::PHYS_MEDI => 'Physical medium',
		    static::PICK_SHEE_NUMB => 'Pick-up sheet number',
		    static::PICT_OF_A_GENE_PROD => 'Picture of a generic product',
		    static::PICT_OF_ACTU_PROD => 'Picture of actual product',
		    static::PILO_SERV_EXEM_NUMB => 'Pilotage services exemption number',
		    static::PIPE_NUMB => 'Pipeline number',
		    static::PLAC_OF_PACK_APPR_NUMB => 'Place of packing approval number',
		    static::PLAC_OF_POSI_REFE => 'Place of positioning reference',
		    static::PLAN_PACK => 'Planning package',
		    static::PLAN_NUMB => 'Plant number',
		    static::PLOT_FILE => 'Plot file',
		    static::POLI_FORM_NUMB => 'Policy form number',
		    static::POLI_NUMB => 'Policy number',
		    static::POST_REFE => 'Post-entry reference',
		    static::PREA_NUMB => 'Pre-agreement number',
		    static::PREM_RATE_TABL => 'Premium rate table',
		    static::PRES_BANK_REFE => 'Presenting bank\'s reference',
		    static::PREV_BANK_STAT_MESS_REFE => 'Previous banking status message reference',
		    static::PREV_CARG_CONT_NUMB => 'Previous cargo control number',
		    static::PREV_CRED_ADVI_REFE_NUMB => 'Previous credit advice reference number',
		    static::PREV_DELI_INST_NUMB => 'Previous delivery instruction number',
		    static::PREV_DELI_SCHE_NUMB => 'Previous delivery schedule number',
		    static::PREV_HIGH_SCHE_NUMB => 'Previous highest schedule number',
		    static::PREV_INVO_NUMB => 'Previous invoice number',
		    static::PREV_MEMB_NUMB => 'Previous member number',
		    static::PREV_RENT_AGRE_NUMB => 'Previous rental agreement number',
		    static::PREV_REQU_FOR_METE_READ_REFE_NUMB => 'Previous request for metered reading reference number',
		    static::PREV_SCHE_NUMB => 'Previous scheme/plan number',
		    static::PREV_TAX_CONT_NUMB => 'Previous tax control number',
		    static::PRIC_LIST_NUMB => 'Price list number',
		    static::PRIC_LIST_VERS_NUMB => 'Price list version number',
		    static::PRIC_QUOT_NUMB => 'Price quote number',
		    static::PRIC_VARI_FORM_REFE_NUMB => 'Price variation formula reference number',
		    static::PRIC_CATA_RESP_REFE_NUMB => 'Price/sales catalogue response reference number',
		    static::PRIM_REFE => 'Primary reference',
		    static::PRIM_CONT_CONT_NUMB => 'Prime contractor contract number',
		    static::PRIN_REFE_NUMB => 'Principal reference number',
		    static::PRIN_BANK_REFE => 'Principal\'s bank reference',
		    static::PRIN_REFE => 'Principal\'s reference',
		    static::PRIO_CONT_REGI_NUMB => 'Prior contractor registration number',
		    static::PRIO_DATA_UNIV_NUMB_SYST_DUNS_NUMB => 'Prior Data Universal Number System (DUNS) number',
		    static::PRIO_POLI_NUMB => 'Prior policy number',
		    static::PRIO_PURC_ORDE_NUMB => 'Prior purchase order number',
		    static::PRIO_TRAD_PART_IDEN_NUMB => 'Prior trading partner identification number',
		    static::PROC_PLAN_NUMB => 'Processing plant number',
		    static::PROC_BUDG_NUMB => 'Procurement budget number',
		    static::PROD_CERT_NUMB => 'Product certification number',
		    static::PROD_CHAN_AUTH_NUMB => 'Product change authority number',
		    static::PROD_CHAR_DIRE => 'Product characteristics directory',
		    static::PROD_DATA_FILE_NUMB => 'Product data file number',
		    static::PROD_INQU_NUMB => 'Product inquiry number',
		    static::PROD_RESE_NUMB => 'Product reservation number',
		    static::PROD_SOUR_AGRE_NUMB => 'Product sourcing agreement number',
		    static::PROD_SPEC_REFE_NUMB => 'Product specification reference number',
		    static::PROD_CODE => 'Production code',
		    static::PROF_NUMB => 'Profile number',
		    static::PROF_INVO_DOCU_IDEN => 'Proforma invoice document identifier',
		    static::PROJ_NUMB => 'Project number',
		    static::PROJ_SPEC_NUMB => 'Project specification number',
		    static::PROM_DEAL_NUMB => 'Promotion deal number',
		    static::PROO_OF_DELI_REFE_NUMB => 'Proof of delivery reference number',
		    static::PROP_PURC_ORDE_REFE_NUMB => 'Proposed purchase order reference number',
		    static::PUBL_FILI_REGI_NUMB => 'Public filing registration number',
		    static::PUBL_ISSU_NUMB => 'Publication issue number',
		    static::PURC_FOR_EXPO_CUST_AGRE_NUMB => 'Purchase for export Customs agreement number',
		    static::PURC_ORDE_CHAN_NUMB => 'Purchase order change number',
		    static::PURC_ORDE_NUMB_SUFF => 'Purchase order number suffix',
		    static::PURC_ORDE_RESP_NUMB => 'Purchase order response number',
		    static::PURC_REQU_REFE => 'Purchaser\'s request reference',
		    static::PURC_ACTI_CLAU_NUMB => 'Purchasing activity clause number',
		    static::QUAN_VALU_NUMB => 'Quantity valuation number',
		    static::QUAN_VALU_REQU_NUMB => 'Quantity valuation request number',
		    static::QUAR_STAT_REFE_NUMB => 'Quarantine/treatment status reference number',
		    static::QUOT_NUMB => 'Quota number',
		    static::RAIL_WAYB_NUMB => 'Rail waybill number',
		    static::RAIL_ROUT_CODE => 'Rail/road routing code',
		    static::RAIL_CONS_NOTE_NUMB => 'Railway consignment note number',
		    static::RAIL_WAGO_NUMB => 'Railway wagon number',
		    static::RATE_CODE_NUMB => 'Rate code number',
		    static::RATE_NOTE_NUMB => 'Rate note number',
		    static::RECE_FILE_REFE_NUMB => 'Receiver\'s file reference number',
		    static::RECE_ADVI_NUMB => 'Receiving advice number',
		    static::RECE_BANK_AUTH_NUMB => 'Receiving bank\'s authorization number',
		    static::RECE_BANK_NUMB => 'Receiving Bankgiro number',
		    static::RECE_PART_MEMB_IDEN => 'Receiving party\'s member identification',
		    static::REFE_NUMB_ASSI_BY_THIR_PART => 'Reference number assigned by third party',
		    static::REFE_NUMB_OF_A_REQU_FOR_METE_READ => 'Reference number of a request for metered reading',
		    static::REFE_NUMB_QUOT_ON_STAT => 'Reference number quoted on statement',
		    static::REFE_NUMB_TO_PREV_MESS => 'Reference number to previous message',
		    static::REFE_TO_ACCO_SERV_BANK_MESS => 'Reference to account servicing bank\'s message',
		    static::REFE_PROD_FOR_CHEM_ANAL => 'Referred product for chemical analysis',
		    static::REFE_PROD_FOR_MECH_ANAL => 'Referred product for mechanical analysis',
		    static::REGI_FEDE_DE_CONT => 'Regiristo Federal de Contribuyentes',
		    static::REGI_CAPI_REFE => 'Registered capital reference',
		    static::REGI_CONT_ACTI_TYPE => 'Registered contractor activity type',
		    static::REGI_NUMB_OF_PREV_CUST_DECL => 'Registration number of previous Customs declaration',
		    static::REGI_INFO_FISC_RIF_NUMB => 'Registro Informacion Fiscal (RIF) number',
		    static::REGI_UNIC_DE_CONT_RUC_NUMB => 'Registro Unico de Contribuyente (RUC) number',
		    static::REGI_UNIC_TRIB_RUT => 'Registro Unico Tributario (RUT)',
		    static::REIN_CLAI_NUMB => 'Reinsurer\'s claim number',
		    static::RELA_DOCU_NUMB => 'Related document number',
		    static::RELA_PART => 'Related party',
		    static::RELE_NUMB => 'Release number',
		    static::REMI_ADVI_NUMB => 'Remittance advice number',
		    static::REMI_BANK_REFE => 'Remitting bank\'s reference',
		    static::REPA_DATA_REQU_NUMB => 'Repair data request number',
		    static::REPA_ESTI_NUMB => 'Repair estimate number',
		    static::REPL_METE_UNIT_NUMB => 'Replaced meter unit number',
		    static::REPL_PART_NUMB => 'Replacing part number',
		    static::REPL_PURC_ORDE_NUMB => 'Replenishment purchase order number',
		    static::REPL_PURC_ORDE_RANG_END_NUMB => 'Replenishment purchase order range end number',
		    static::REPL_PURC_ORDE_RANG_STAR_NUMB => 'Replenishment purchase order range start number',
		    static::REPO_NUMB => 'Report number',
		    static::REPO_FORM_NUMB => 'Reporting form number',
		    static::REQU_FOR_CANC_NUMB => 'Request for cancellation number',
		    static::REQU_FOR_QUOT_NUMB => 'Request for quote number',
		    static::REQU_NUMB => 'Request number',
		    static::RESE_OFFI_IDEN => 'Reservation office identifier',
		    static::RESE_STAT_INDE => 'Reservation station indentifier',
		    static::RESE_GOOD_IDEN => 'Reserved goods identifier',
		    static::RETU_CONT_REFE_NUMB => 'Returnable container reference number',
		    static::RETU_NOTI_NUMB => 'Returns notice number',
		    static::ROAD_CONS_NOTE_NUMB => 'Road consignment note number',
		    static::SAFE_CUST_NUMB => 'Safe custody number',
		    static::SAFE_DEPO_BOX_NUMB => 'Safe deposit box number',
		    static::SALE_DEPA_NUMB => 'Sales department number',
		    static::SALE_FORE_NUMB => 'Sales forecast number',
		    static::SALE_OFFI_NUMB => 'Sales office number',
		    static::SALE_PERS_NUMB => 'Sales person number',
		    static::SALE_REGI_NUMB => 'Sales region number',
		    static::SALE_REPO_NUMB => 'Sales report number',
		    static::SCAN_LINE => 'Scan line',
		    static::SCHE_NUMB => 'Scheme/plan number',
		    static::SECO_BENE_REFE => 'Second beneficiary\'s reference',
		    static::SECO_CUST_REFE => 'Secondary Customs reference',
		    static::SECR_NUMB => 'Secretariat number',
		    static::SECU_DELI_TERM_AND_COND_AGRE_REFE => 'Secure delivery terms and conditions agreement reference',
		    static::SELL_CATA_NUMB => 'Seller\'s catalogue number',
		    static::SELL_REFE_NUMB => 'Sellers reference number',
		    static::SEND_CLAU_NUMB => 'Sender\'s clause number',
		    static::SEND_FILE_REFE_NUMB => 'Sender\'s file reference number',
		    static::SEND_REFE_TO_THE_ORIG_MESS => 'Sender\'s reference to the original message',
		    static::SEND_BANK_REFE_NUMB => 'Sending bank\'s reference number',
		    static::SEND_BANK_NUMB => 'Sending Bankgiro number',
		    static::SERI_NUMB => 'Serial number',
		    static::SERI_SHIP_CONT_CODE => 'Serial shipping container code',
		    static::SERV_CATE_REFE => 'Service category reference',
		    static::SERV_GROU_IDEN_NUMB => 'Service group identification number',
		    static::SERV_PROV => 'Service provider',
		    static::SERV_RELA_NUMB => 'Service relation number',
		    static::SHIP_FROM => 'Ship from',
		    static::SHIP_NOTI_NUMB => 'Ship notice/manifest number',
		    static::SHIP_STAY_REFE_NUMB => 'Ship\'s stay reference number',
		    static::SHIP_REFE_NUMB => 'Shipment reference number',
		    static::SHIP_AUTH_NUMB => 'Shipowner\'s authorization number',
		    static::SHIP_LABE_SERI_NUMB => 'Shipping label serial number',
		    static::SHIP_NOTE_NUMB => 'Shipping note number',
		    static::SHIP_UNIT_IDEN => 'Shipping unit identification',
		    static::SID_SHIP_IDEN_NUMB_FOR_SHIP => 'SID (Shipper\'s identifying number for shipment)',
		    static::SIGN_CODE_NUMB => 'Signal code number',
		    static::SING_TRAN_SEQU_NUMB => 'Single transaction sequence number',
		    static::SITE_SPEC_PROC_TERM_AND_COND_NUMB => 'Site specific procedures, terms, and conditions number',
		    static::SITU_NUMB => 'Situation number',
		    static::SLAU_PLAN_NUMB => 'Slaughter plant number',
		    static::SLAU_APPR_NUMB => 'Slaughterhouse approval number',
		    static::SOCI_SECU_NUMB => 'Social security number',
		    static::SOFT_EDIT_REFE => 'Software editor reference',
		    static::SOFT_QUAL_REFE => 'Software quality reference',
		    static::SOFT_REFE => 'Software reference',
		    static::SOUR_DOCU_INTE_REFE => 'Source document internal reference',
		    static::SPEC_BUDG_ACCO_NUMB => 'Special budget account number',
		    static::SPEC_INST_NUMB => 'Special instructions number',
		    static::SPEC_NUMB => 'Specification number',
		    static::SPLI_DELI_NUMB => 'Split delivery number',
		    static::STAN_CARR_ALPH_CODE_SCAC_NUMB => 'Standard Carrier Alpha Code (SCAC) number',
		    static::STAN_INDU_CLAS_SIC_NUMB => 'Standard Industry Classification (SIC) number',
		    static::STAN_NUMB_OF_INSP_DOCU => 'Standard number of inspection document',
		    static::STAN_CODE_NUMB => 'Standard\'s code number',
		    static::STAN_NUMB => 'Standard\'s number',
		    static::STAN_VERS_NUMB => 'Standard\'s version number',
		    static::STAT_OR_PROV_ASSI_ENTI_IDEN => 'State or province assigned entity identification',
		    static::STAT_NUMB => 'Statement number',
		    static::STAT_OF_WORK => 'Statement of work',
		    static::STAT_REFE_NUMB => 'Station reference number',
		    static::STAT_BUND_AMT_SBA_IDEN => 'Statistic Bundes Amt (SBA) identifier',
		    static::STAT_REPO_NUMB => 'Status report number',
		    static::STOC_ADJU_NUMB => 'Stock adjustment number',
		    static::STOC_EXCH_COMP_IDEN => 'Stock exchange company identifier',
		    static::STOC_KEEP_UNIT_NUMB => 'Stock keeping unit number',
		    static::SUB_FILE => 'Sub file',
		    static::SUBH_BILL_OF_LADI_NUMB => 'Sub-house bill of lading number',
		    static::SUBS_AIR_WAYB_NUMB => 'Substitute air waybill number',
		    static::SUFFIX => 'Suffix',
		    static::SUPP_CONT_NUMB => 'Supplier\'s control number',
		    static::SUPP_CRED_CLAI_REFE_NUMB => 'Supplier\'s credit claim reference number',
		    static::SUPP_CUST_REFE_NUMB => 'Supplier\'s customer reference number',
		    static::SWAP_ORDE_NUMB => 'Swap order number',
		    static::SYMB_NUMB => 'Symbol number',
		    static::SYST_INFO_POUR_LE_REPE_DES_ENTR_SIRE_NUMB => 'Systeme Informatique pour le Repertoire des ENtreprises (SIREN) number',
		    static::SYST_INFO_POUR_LE_REPE_DES_ETAB_SIRE_NUMB => 'Systeme Informatique pour le Repertoire des ETablissements (SIRET) number',
		    static::TARI_NUMB => 'Tariff number',
		    static::TAX_EXEM_LICE_NUMB => 'Tax exemption licence number',
		    static::TAX_PAYM_IDEN => 'Tax payment identifier',
		    static::TAX_REGI_NUMB => 'Tax registration number',
		    static::TEAM_ASSI_NUMB => 'Team assignment number',
		    static::TECH_DOCU_NUMB => 'Technical document number',
		    static::TECH_ORDE_NUMB => 'Technical order number',
		    static::TECH_PHAS_REFE => 'Technical phase reference',
		    static::TECH_REGU => 'Technical regulation',
		    static::TELE_MESS_NUMB => 'Telex message number',
		    static::TERM_OPER_CONS_REFE => 'Terminal operator\'s consignment reference',
		    static::TEST_REPO_NUMB => 'Test report number',
		    static::TEST_SPEC_NUMB => 'Test specification number',
		    static::TEXT_ELEM_IDEN_DELE_REFE => 'Text Element Identifier deletion reference',
		    static::THIR_BANK_REFE => 'Third bank\'s reference',
		    static::THRO_BILL_OF_LADI_NUMB => 'Through bill of lading number',
		    static::TICK_CONT_NUMB => 'Ticket control number',
		    static::TIME_SERI_REFE => 'Time series reference',
		    static::TIR_CARN_NUMB => 'TIR carnet number',
		    static::TOKY_SHOK_RESE_TSR_BUSI_IDEN => 'Tokyo SHOKO Research (TSR) business identifier',
		    static::TOOL_CONT_NUMB => 'Tooling contract number',
		    static::TRAC_PART_IDEN => 'TRACES party identification',
		    static::TRAD_ACCO_NUMB => 'Trader account number',
		    static::TRAD_PART_IDEN_NUMB => 'Trading partner identification number',
		    static::TRAI_FLIG_NUMB => 'Training flight number',
		    static::TRAN_REFE_NUMB => 'Transaction reference number',
		    static::TRAN_NUMB => 'Transfer number',
		    static::TRAN_ONWA_CARR_GUAR_BOND_NUMB => 'Transit (onward carriage) guarantee (bond) number',
		    static::TRAN_CONT_DOCU_IDEN => 'Transport contract document identifier',
		    static::TRAN_CONT_REFE_NUMB => 'Transport contract reference number',
		    static::TRAN_COST_REFE_NUMB => 'Transport costs reference number',
		    static::TRAN_EQUI_ACCE_ORDE_REFE => 'Transport equipment acceptance order reference',
		    static::TRAN_EQUI_GROS_MASS_VERI_ORDE_REFE => 'Transport equipment gross mass verification order reference',
		    static::TRAN_EQUI_GROS_MASS_VERI_REFE_NUMB => 'Transport equipment gross mass verification reference number',
		    static::TRAN_EQUI_IDEN => 'Transport equipment identifier',
		    static::TRAN_EQUI_RELE_ORDE_REFE => 'Transport equipment release order reference',
		    static::TRAN_EQUI_RETU_REFE => 'Transport equipment return reference',
		    static::TRAN_EQUI_SEAL_IDEN => 'Transport equipment seal identifier',
		    static::TRAN_EQUI_STRI_ORDE => 'Transport equipment stripping order',
		    static::TRAN_EQUI_STUF_ORDE => 'Transport equipment stuffing order',
		    static::TRAN_EQUI_SURV_REFE => 'Transport equipment survey reference',
		    static::TRAN_EQUI_SURV_REFE_NUMB => 'Transport equipment survey reference number',
		    static::TRAN_EQUI_SURV_REPO_NUMB => 'Transport equipment survey report number',
		    static::TRAN_INST_NUMB => 'Transport instruction number',
		    static::TRAN_MEAN_JOUR_IDEN => 'Transport means journey identifier',
		    static::TRAN_ROUT => 'Transport route',
		    static::TRAN_SECT_REFE_NUMB => 'Transport section reference number',
		    static::TRAN_STAT_REPO_NUMB => 'Transport status report number',
		    static::TRAN_ACCO_NUMB => 'Transportation account number',
		    static::TRAN_CONT_NUMB_TCN => 'Transportation Control Number (TCN)',
		    static::TRAN_EXPO_NO_FOR_IN_BOND_MOVE => 'Transportation exportation no. for in bond movement',
		    static::TRAV_SERV => 'Travel service',
		    static::TREA_NUMB => 'Treaty number',
		    static::TRUC_BILL_OF_LADI => 'Trucker\'s bill of lading',
		    static::US_CODE_OF_FEDE_REGU_CFR => 'U.S. Code of Federal Regulations (CFR)',
		    static::US_DEFE_FEDE_ACQU_REGU_SUPP => 'U.S. Defense Federal Acquisition Regulation Supplement',
		    static::US_DEPA_OF_VETE_AFFA_ACQU_REGU => 'U.S. Department of Veterans Affairs Acquisition Regulation',
		    static::US_FEDE_ACQU_REGU => 'U.S. Federal Acquisition Regulation',
		    static::US_FEDE_INFO_RESO_MANA_REGU => 'U.S. Federal Information Resources Management Regulation',
		    static::US_GENE_SERV_ADMI_REGU => 'U.S. General Services Administration Regulation',
		    static::ULTI_CUST_ORDE_NUMB => 'Ultimate customer\'s order number',
		    static::ULTI_CUST_REFE_NUMB => 'Ultimate customer\'s reference number',
		    static::UNIF_RESO_IDEN => 'Uniform Resource Identifier',
		    static::UNIQ_CLAI_REFE_NUMB_OF_THE_SEND => 'Unique claims reference number of the sender',
		    static::UNIQ_CONS_REFE_NUMB => 'Unique consignment reference number',
		    static::UNIQ_GOOD_SHIP_IDEN => 'Unique goods shipment identifier',
		    static::UNIQ_MARK_REFE => 'Unique market reference',
		    static::UNIT_NATI_DANG_GOOD_IDEN => 'United Nations Dangerous Goods identifier',
		    static::UPPE_NUMB_OF_RANG => 'Upper number of range',
		    static::US_CUST_SERV_USCS_ENTR_CODE => 'US Customs Service (USCS) entry code',
		    static::US_GOVE_AGEN_NUMB => 'US government agency number',
		    static::US_DEPA_OF_TRAN_BOND_SURE_CODE => 'US, Department of Transportation bond surety code',
		    static::US_FEDE_COMM_COMM_FCC_IMPO_COND_NUMB => 'US, Federal Communications Commission (FCC) import condition number',
		    static::US_FOOD_AND_DRUG_ADMI_ESTA_INDI => 'US, Food and Drug Administration establishment indicator',
		    static::VAT_REGI_NUMB => 'VAT registration number',
		    static::VEHI_IDEN_NUMB_VIN => 'Vehicle Identification Number (VIN)',
		    static::VEHI_LICE_NUMB => 'Vehicle licence number',
		    static::VEND_CONT_NUMB => 'Vendor contract number',
		    static::VEND_ID_NUMB => 'Vendor ID number',
		    static::VEND_ORDE_NUMB_SUFF => 'Vendor order number suffix',
		    static::VEND_PROD_NUMB => 'Vendor product number',
		    static::VESS_IDEN => 'Vessel identifier',
		    static::VOUC_NUMB => 'Voucher number',
		    static::VOYA_NUMB => 'Voyage number',
		    static::WAGE_DETE_NUMB => 'Wage determination number',
		    static::WARE_ENTR_NUMB => 'Warehouse entry number',
		    static::WARE_RECE_NUMB => 'Warehouse receipt number',
		    static::WARE_STOR_LOCA_NUMB => 'Warehouse storage location number',
		    static::WAYB_NUMB => 'Waybill number',
		    static::WEIG_AGRE_NUMB => 'Weight agreement number',
		    static::WELL_NUMB => 'Well number',
		    static::WOOL_IDEN_NUMB => 'Wool identification number',
		    static::WOOL_TAX_REFE_NUMB => 'Wool tax reference number',
		    static::WORK_BREA_STRU => 'Work breakdown structure',
		    static::WORK_ITEM_QUAN_DETE => 'Work item quantity determination',
		    static::WORK_ORDE => 'Work order',
		    static::WORK_PACK => 'Work package',
		    static::WORK_SHIF => 'Work shift',
		    static::WORK_TASK_CHAR_NUMB => 'Work task charge number',
		    static::WORK_TEAM => 'Work team',
		];
	}


	/**
	 * Returns true if a code exists in the list, otherwise false
	 *
	 * @param string $code
	 * @return boolean
	 * @codeCoverageIgnore
	 */
	final public static function checkCodeExists(string $code): bool
	{
		return isset(static::getAllCodes()[$code]);
	}


	/**
	 * Returns the description of a code. If code is not found an empty string is returned
	 *
	 * @param string $code
	 * @return string
	 * @codeCoverageIgnore
	 */
	final public static function getCodeDescription(string $code): string
	{
		if (static::checkCodeExists($code) === true) {
		    return static::getAllCodeDescriptions()[$code];
		}

		return "";
	}
}
