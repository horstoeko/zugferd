<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the Payment means
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdPaymentMeans: int
{

    /**
     * Instrument not defined
     */
    case UNTDID_4461_1 = 1;

    /**
     * Automated clearing house credit
     */
    case UNTDID_4461_2 = 2;

    /**
     * Automated clearing house debit
     */
    case UNTDID_4461_3 = 3;

    /**
     * ACH demand debit reversal
     */
    case UNTDID_4461_4 = 4;

    /**
     * ACH demand credit reversal
     */
    case UNTDID_4461_5 = 5;

    /**
     * ACH demand credit
     */
    case UNTDID_4461_6 = 6;

    /**
     * ACH demand debit
     */
    case UNTDID_4461_7 = 7;

    /**
     * Hold
     */
    case UNTDID_4461_8 = 8;

    /**
     * National or regional clearing
     */
    case UNTDID_4461_9 = 9;

    /**
     * In cash
     */
    case UNTDID_4461_10 = 10;

    /**
     * ACH savings credit reversal
     */
    case UNTDID_4461_11 = 11;

    /**
     * ACH savings debit reversal
     */
    case UNTDID_4461_12 = 12;

    /**
     * ACH savings credit
     */
    case UNTDID_4461_13 = 13;

    /**
     * ACH savings debit
     */
    case UNTDID_4461_14 = 14;

    /**
     * Bookentry credit
     */
    case UNTDID_4461_15 = 15;

    /**
     * Bookentry debit
     */
    case UNTDID_4461_16 = 16;

    /**
     * ACH demand cash concentration/disbursement (CCD) credit
     */
    case UNTDID_4461_17 = 17;

    /**
     * ACH demand cash concentration/disbursement (CCD) debit
     */
    case UNTDID_4461_18 = 18;

    /**
     * ACH demand corporate trade payment (CTP) credit
     */
    case UNTDID_4461_19 = 19;

    /**
     * Cheque
     */
    case UNTDID_4461_20 = 20;

    /**
     * Banker's draft
     */
    case UNTDID_4461_21 = 21;

    /**
     * Certified banker's draft
     */
    case UNTDID_4461_22 = 22;

    /**
     * Bank cheque (issued by a banking or similar establishment)
     */
    case UNTDID_4461_23 = 23;

    /**
     * Bill of exchange awaiting acceptance
     */
    case UNTDID_4461_24 = 24;

    /**
     * Certified cheque
     */
    case UNTDID_4461_25 = 25;

    /**
     * Local cheque
     */
    case UNTDID_4461_26 = 26;

    /**
     * ACH demand corporate trade payment (CTP) debit
     */
    case UNTDID_4461_27 = 27;

    /**
     * ACH demand corporate trade exchange (CTX) credit
     */
    case UNTDID_4461_28 = 28;

    /**
     * ACH demand corporate trade exchange (CTX) debit
     */
    case UNTDID_4461_29 = 29;

    /**
     * Credit transfer
     */
    case UNTDID_4461_30 = 30;

    /**
     * Debit transfer
     */
    case UNTDID_4461_31 = 31;

    /**
     * ACH demand cash concentration/disbursement plus (CCD+)
     */
    case UNTDID_4461_32 = 32;

    /**
     * ACH demand cash concentration/disbursement plus (CCD+)
     */
    case UNTDID_4461_33 = 33;

    /**
     * ACH prearranged payment and deposit (PPD)
     */
    case UNTDID_4461_34 = 34;

    /**
     * ACH savings cash concentration/disbursement (CCD) credit
     */
    case UNTDID_4461_35 = 35;

    /**
     * ACH savings cash concentration/disbursement (CCD) debit
     */
    case UNTDID_4461_36 = 36;

    /**
     * ACH savings corporate trade payment (CTP) credit
     */
    case UNTDID_4461_37 = 37;

    /**
     * ACH savings corporate trade payment (CTP) debit
     */
    case UNTDID_4461_38 = 38;

    /**
     * ACH savings corporate trade exchange (CTX) credit
     */
    case UNTDID_4461_39 = 39;

    /**
     * ACH savings corporate trade exchange (CTX) debit
     */
    case UNTDID_4461_40 = 40;

    /**
     * ACH savings cash concentration/disbursement plus (CCD+)
     */
    case UNTDID_4461_41 = 41;

    /**
     * Payment to bank account
     */
    case UNTDID_4461_42 = 42;

    /**
     * ACH savings cash concentration/disbursement plus (CCD+)
     */
    case UNTDID_4461_43 = 43;

    /**
     * Accepted bill of exchange
     */
    case UNTDID_4461_44 = 44;

    /**
     * Referenced home-banking credit transfer
     */
    case UNTDID_4461_45 = 45;

    /**
     * Interbank debit transfer
     */
    case UNTDID_4461_46 = 46;

    /**
     * Home-banking debit transfer
     */
    case UNTDID_4461_47 = 47;

    /**
     * Bank card
     */
    case UNTDID_4461_48 = 48;

    /**
     * Direct debit
     */
    case UNTDID_4461_49 = 49;

    /**
     * Payment by postgiro
     */
    case UNTDID_4461_50 = 50;

    /**
     * FR, norme 6 97-Telereglement CFONB (French Organisation for
     */
    case UNTDID_4461_51 = 51;

    /**
     * Urgent commercial payment
     */
    case UNTDID_4461_52 = 52;

    /**
     * Urgent Treasury Payment
     */
    case UNTDID_4461_53 = 53;

    /**
     * Credit card
     */
    case UNTDID_4461_54 = 54;

    /**
     * Debit card
     */
    case UNTDID_4461_55 = 55;

    /**
     * Bankgiro
     */
    case UNTDID_4461_56 = 56;

    /**
     * Standing agreement
     */
    case UNTDID_4461_57 = 57;

    /**
     * SEPA credit transfer
     */
    case UNTDID_4461_58 = 58;

    /**
     * SEPA direct debit
     */
    case UNTDID_4461_59 = 59;

    /**
     * Promissory note
     */
    case UNTDID_4461_60 = 60;

    /**
     * Promissory note signed by the debtor
     */
    case UNTDID_4461_61 = 61;

    /**
     * Promissory note signed by the debtor and endorsed by a bank
     */
    case UNTDID_4461_62 = 62;

    /**
     * Promissory note signed by the debtor and endorsed by a
     */
    case UNTDID_4461_63 = 63;

    /**
     * Promissory note signed by a bank
     */
    case UNTDID_4461_64 = 64;

    /**
     * Promissory note signed by a bank and endorsed by another
     */
    case UNTDID_4461_65 = 65;

    /**
     * Promissory note signed by a third party
     */
    case UNTDID_4461_66 = 66;

    /**
     * Promissory note signed by a third party and endorsed by a
     */
    case UNTDID_4461_67 = 67;

    /**
     * Online payment service
     */
    case UNTDID_4461_68 = 68;

    /**
     * Transfer Advice
     */
    case UNTDID_4461_69 = 69;

    /**
     * Bill drawn by the creditor on the debtor
     */
    case UNTDID_4461_70 = 70;

    /**
     * Bill drawn by the creditor on a bank
     */
    case UNTDID_4461_74 = 74;

    /**
     * Bill drawn by the creditor, endorsed by another bank
     */
    case UNTDID_4461_75 = 75;

    /**
     * Bill drawn by the creditor on a bank and endorsed by a
     */
    case UNTDID_4461_76 = 76;

    /**
     * Bill drawn by the creditor on a third party
     */
    case UNTDID_4461_77 = 77;

    /**
     * Bill drawn by creditor on third party, accepted and
     */
    case UNTDID_4461_78 = 78;

    /**
     * Not transferable banker's draft
     */
    case UNTDID_4461_91 = 91;

    /**
     * Not transferable local cheque
     */
    case UNTDID_4461_92 = 92;

    /**
     * Reference giro
     */
    case UNTDID_4461_93 = 93;

    /**
     * Urgent giro
     */
    case UNTDID_4461_94 = 94;

    /**
     * Free format giro
     */
    case UNTDID_4461_95 = 95;

    /**
     * Requested method for payment was not used
     */
    case UNTDID_4461_96 = 96;

    /**
     * Clearing between partners
     */
    case UNTDID_4461_97 = 97;
}
