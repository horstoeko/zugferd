<?php

/**
 * This file is a part of horstoeko/zugferd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace horstoeko\zugferd\codelistsenum;

/**
 * Class representing the Unit codes
 *
 * @category Zugferd
 * @package  Zugferd
 * @author   D. Erling <horstoeko@erling.com.de>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/horstoeko/zugferd
 */
enum ZugferdUnitCodes: string
{

    /**
     * group
     */
    case REC20_GROUP = '10';

    /**
     * outfit
     */
    case REC20_OUTFIT = '11';

    /**
     * ration
     */
    case REC20_RATION = '13';

    /**
     * shot
     */
    case REC20_SHOT = '14';

    /**
     * stick, military
     */
    case REC20_STICK_MILITARY = '15';

    /**
     * twenty foot container
     */
    case REC20_TWENTY_FOOT_CONTAINER = '20';

    /**
     * forty foot container
     */
    case REC20_FORTY_FOOT_CONTAINER = '21';

    /**
     * decilitre per gram
     */
    case REC20_DECILITRE_PER_GRAM = '22';

    /**
     * gram per cubic centimetre
     */
    case REC20_GRAM_PER_CUBIC_CENTIMETRE = '23';

    /**
     * theoretical pound
     */
    case REC20_THEORETICAL_POUND = '24';

    /**
     * gram per square centimetre
     */
    case REC20_GRAM_PER_SQUARE_CENTIMETRE = '25';

    /**
     * theoretical ton
     */
    case REC20_THEORETICAL_TON = '27';

    /**
     * kilogram per square metre
     */
    case REC20_KILOGRAM_PER_SQUARE_METRE = '28';

    /**
     * kilopascal square metre per gram
     */
    case REC20_KILOPASCAL_SQUARE_METRE_PER_GRAM = '33';

    /**
     * kilopascal per millimetre
     */
    case REC20_KILOPASCAL_PER_MILLIMETRE = '34';

    /**
     * millilitre per square centimetre second
     */
    case REC20_MILLILITRE_PER_SQUARE_CENTIMETRE_SECOND = '35';

    /**
     * ounce per square foot
     */
    case REC20_OUNCE_PER_SQUARE_FOOT = '37';

    /**
     * ounce per square foot per 0,01inch
     */
    case REC20_OUNCE_PER_SQUARE_FOOT_PER_001INCH = '38';

    /**
     * millilitre per second
     */
    case REC20_MILLILITRE_PER_SECOND = '40';

    /**
     * millilitre per minute
     */
    case REC20_MILLILITRE_PER_MINUTE = '41';

    /**
     * sitas
     */
    case REC20_SITAS = '56';

    /**
     * mesh
     */
    case REC20_MESH = '57';

    /**
     * net kilogram
     */
    case REC20_NET_KILOGRAM = '58';

    /**
     * part per million
     */
    case REC20_PART_PER_MILLION = '59';

    /**
     * percent weight
     */
    case REC20_PERCENT_WEIGHT = '60';

    /**
     * part per billion (US)
     */
    case REC20_PART_PER_BILLION_US = '61';

    /**
     * millipascal
     */
    case REC20_MILLIPASCAL = '74';

    /**
     * milli-inch
     */
    case REC20_MILLIINCH = '77';

    /**
     * pound per square inch absolute
     */
    case REC20_POUND_PER_SQUARE_INCH_ABSOLUTE = '80';

    /**
     * henry
     */
    case REC20_HENRY = '81';

    /**
     * foot pound-force
     */
    case REC20_FOOT_POUNDFORCE = '85';

    /**
     * pound per cubic foot
     */
    case REC20_POUND_PER_CUBIC_FOOT = '87';

    /**
     * poise
     */
    case REC20_POISE = '89';

    /**
     * stokes
     */
    case REC20_STOKES = '91';

    /**
     * fixed rate
     */
    case REC20_FIXED_RATE = '1I';

    /**
     * radian per second
     */
    case REC20_RADIAN_PER_SECOND = '2A';

    /**
     * radian per second squared
     */
    case REC20_RADIAN_PER_SECOND_SQUARED = '2B';

    /**
     * roentgen
     */
    case REC20_ROENTGEN = '2C';

    /**
     * volt AC
     */
    case REC20_VOLT_AC = '2G';

    /**
     * volt DC
     */
    case REC20_VOLT_DC = '2H';

    /**
     * British thermal unit (international table) per hour
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_HOUR = '2I';

    /**
     * cubic centimetre per second
     */
    case REC20_CUBIC_CENTIMETRE_PER_SECOND = '2J';

    /**
     * cubic foot per hour
     */
    case REC20_CUBIC_FOOT_PER_HOUR = '2K';

    /**
     * cubic foot per minute
     */
    case REC20_CUBIC_FOOT_PER_MINUTE = '2L';

    /**
     * centimetre per second
     */
    case REC20_CENTIMETRE_PER_SECOND = '2M';

    /**
     * decibel
     */
    case REC20_DECIBEL = '2N';

    /**
     * kilobyte
     */
    case REC20_KILOBYTE = '2P';

    /**
     * kilobecquerel
     */
    case REC20_KILOBECQUEREL = '2Q';

    /**
     * kilocurie
     */
    case REC20_KILOCURIE = '2R';

    /**
     * megagram
     */
    case REC20_MEGAGRAM = '2U';

    /**
     * metre per minute
     */
    case REC20_METRE_PER_MINUTE = '2X';

    /**
     * milliroentgen
     */
    case REC20_MILLIROENTGEN = '2Y';

    /**
     * millivolt
     */
    case REC20_MILLIVOLT = '2Z';

    /**
     * megajoule
     */
    case REC20_MEGAJOULE = '3B';

    /**
     * manmonth
     */
    case REC20_MANMONTH = '3C';

    /**
     * centistokes
     */
    case REC20_CENTISTOKES = '4C';

    /**
     * microlitre
     */
    case REC20_MICROLITRE = '4G';

    /**
     * micrometre (micron)
     */
    case REC20_MICROMETRE_MICRON = '4H';

    /**
     * milliampere
     */
    case REC20_MILLIAMPERE = '4K';

    /**
     * megabyte
     */
    case REC20_MEGABYTE = '4L';

    /**
     * milligram per hour
     */
    case REC20_MILLIGRAM_PER_HOUR = '4M';

    /**
     * megabecquerel
     */
    case REC20_MEGABECQUEREL = '4N';

    /**
     * microfarad
     */
    case REC20_MICROFARAD = '4O';

    /**
     * newton per metre
     */
    case REC20_NEWTON_PER_METRE = '4P';

    /**
     * ounce inch
     */
    case REC20_OUNCE_INCH = '4Q';

    /**
     * ounce foot
     */
    case REC20_OUNCE_FOOT = '4R';

    /**
     * picofarad
     */
    case REC20_PICOFARAD = '4T';

    /**
     * pound per hour
     */
    case REC20_POUND_PER_HOUR = '4U';

    /**
     * ton (US) per hour
     */
    case REC20_TON_US_PER_HOUR = '4W';

    /**
     * kilolitre per hour
     */
    case REC20_KILOLITRE_PER_HOUR = '4X';

    /**
     * barrel (US) per minute
     */
    case REC20_BARREL_US_PER_MINUTE = '5A';

    /**
     * batch
     */
    case REC20_BATCH = '5B';

    /**
     * MMSCF/day
     */
    case REC20_MMSCF_DAY = '5E';

    /**
     * hydraulic horse power
     */
    case REC20_HYDRAULIC_HORSE_POWER = '5J';

    /**
     * ampere square metre per joule second
     */
    case REC20_AMPERE_SQUARE_METRE_PER_JOULE_SECOND = 'A10';

    /**
     * angstrom
     */
    case REC20_ANGSTROM = 'A11';

    /**
     * astronomical unit
     */
    case REC20_ASTRONOMICAL_UNIT = 'A12';

    /**
     * attojoule
     */
    case REC20_ATTOJOULE = 'A13';

    /**
     * barn
     */
    case REC20_BARN = 'A14';

    /**
     * barn per electronvolt
     */
    case REC20_BARN_PER_ELECTRONVOLT = 'A15';

    /**
     * barn per steradian electronvolt
     */
    case REC20_BARN_PER_STERADIAN_ELECTRONVOLT = 'A16';

    /**
     * barn per steradian
     */
    case REC20_BARN_PER_STERADIAN = 'A17';

    /**
     * becquerel per kilogram
     */
    case REC20_BECQUEREL_PER_KILOGRAM = 'A18';

    /**
     * becquerel per cubic metre
     */
    case REC20_BECQUEREL_PER_CUBIC_METRE = 'A19';

    /**
     * ampere per centimetre
     */
    case REC20_AMPERE_PER_CENTIMETRE = 'A2';

    /**
     * British thermal unit (international table) per second square foot
     * degree Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SECOND_SQUARE_FOOT_DEGREE_RANKINE = 'A20';

    /**
     * British thermal unit (international table) per pound degree Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_POUND_DEGREE_RANKINE = 'A21';

    /**
     * British thermal unit (international table) per second foot degree
     * Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SECOND_FOOT_DEGREE_RANKINE = 'A22';

    /**
     * British thermal unit (international table) per hour square foot degree
     * Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_HOUR_SQUARE_FOOT_DEGREE_RANKINE = 'A23';

    /**
     * candela per square metre
     */
    case REC20_CANDELA_PER_SQUARE_METRE = 'A24';

    /**
     * coulomb metre
     */
    case REC20_COULOMB_METRE = 'A26';

    /**
     * coulomb metre squared per volt
     */
    case REC20_COULOMB_METRE_SQUARED_PER_VOLT = 'A27';

    /**
     * coulomb per cubic centimetre
     */
    case REC20_COULOMB_PER_CUBIC_CENTIMETRE = 'A28';

    /**
     * coulomb per cubic metre
     */
    case REC20_COULOMB_PER_CUBIC_METRE = 'A29';

    /**
     * ampere per millimetre
     */
    case REC20_AMPERE_PER_MILLIMETRE = 'A3';

    /**
     * coulomb per cubic millimetre
     */
    case REC20_COULOMB_PER_CUBIC_MILLIMETRE = 'A30';

    /**
     * coulomb per kilogram second
     */
    case REC20_COULOMB_PER_KILOGRAM_SECOND = 'A31';

    /**
     * coulomb per mole
     */
    case REC20_COULOMB_PER_MOLE = 'A32';

    /**
     * coulomb per square centimetre
     */
    case REC20_COULOMB_PER_SQUARE_CENTIMETRE = 'A33';

    /**
     * coulomb per square metre
     */
    case REC20_COULOMB_PER_SQUARE_METRE = 'A34';

    /**
     * coulomb per square millimetre
     */
    case REC20_COULOMB_PER_SQUARE_MILLIMETRE = 'A35';

    /**
     * cubic centimetre per mole
     */
    case REC20_CUBIC_CENTIMETRE_PER_MOLE = 'A36';

    /**
     * cubic decimetre per mole
     */
    case REC20_CUBIC_DECIMETRE_PER_MOLE = 'A37';

    /**
     * cubic metre per coulomb
     */
    case REC20_CUBIC_METRE_PER_COULOMB = 'A38';

    /**
     * cubic metre per kilogram
     */
    case REC20_CUBIC_METRE_PER_KILOGRAM = 'A39';

    /**
     * ampere per square centimetre
     */
    case REC20_AMPERE_PER_SQUARE_CENTIMETRE = 'A4';

    /**
     * cubic metre per mole
     */
    case REC20_CUBIC_METRE_PER_MOLE = 'A40';

    /**
     * ampere per square metre
     */
    case REC20_AMPERE_PER_SQUARE_METRE = 'A41';

    /**
     * curie per kilogram
     */
    case REC20_CURIE_PER_KILOGRAM = 'A42';

    /**
     * deadweight tonnage
     */
    case REC20_DEADWEIGHT_TONNAGE = 'A43';

    /**
     * decalitre
     */
    case REC20_DECALITRE = 'A44';

    /**
     * decametre
     */
    case REC20_DECAMETRE = 'A45';

    /**
     * decitex
     */
    case REC20_DECITEX = 'A47';

    /**
     * degree Rankine
     */
    case REC20_DEGREE_RANKINE = 'A48';

    /**
     * ampere square metre
     */
    case REC20_AMPERE_SQUARE_METRE = 'A5';

    /**
     * electronvolt
     */
    case REC20_ELECTRONVOLT = 'A53';

    /**
     * electronvolt per metre
     */
    case REC20_ELECTRONVOLT_PER_METRE = 'A54';

    /**
     * electronvolt square metre
     */
    case REC20_ELECTRONVOLT_SQUARE_METRE = 'A55';

    /**
     * electronvolt square metre per kilogram
     */
    case REC20_ELECTRONVOLT_SQUARE_METRE_PER_KILOGRAM = 'A56';

    /**
     * 8-part cloud cover
     */
    case REC20_8PART_CLOUD_COVER = 'A59';

    /**
     * ampere per square metre kelvin squared
     */
    case REC20_AMPERE_PER_SQUARE_METRE_KELVIN_SQUARED = 'A6';

    /**
     * exajoule
     */
    case REC20_EXAJOULE = 'A68';

    /**
     * farad per metre
     */
    case REC20_FARAD_PER_METRE = 'A69';

    /**
     * ampere per square millimetre
     */
    case REC20_AMPERE_PER_SQUARE_MILLIMETRE = 'A7';

    /**
     * femtojoule
     */
    case REC20_FEMTOJOULE = 'A70';

    /**
     * femtometre
     */
    case REC20_FEMTOMETRE = 'A71';

    /**
     * foot per second squared
     */
    case REC20_FOOT_PER_SECOND_SQUARED = 'A73';

    /**
     * foot pound-force per second
     */
    case REC20_FOOT_POUNDFORCE_PER_SECOND = 'A74';

    /**
     * freight ton
     */
    case REC20_FREIGHT_TON = 'A75';

    /**
     * gal
     */
    case REC20_GAL = 'A76';

    /**
     * ampere second
     */
    case REC20_AMPERE_SECOND = 'A8';

    /**
     * gigacoulomb per cubic metre
     */
    case REC20_GIGACOULOMB_PER_CUBIC_METRE = 'A84';

    /**
     * gigaelectronvolt
     */
    case REC20_GIGAELECTRONVOLT = 'A85';

    /**
     * gigahertz
     */
    case REC20_GIGAHERTZ = 'A86';

    /**
     * gigaohm
     */
    case REC20_GIGAOHM = 'A87';

    /**
     * gigaohm metre
     */
    case REC20_GIGAOHM_METRE = 'A88';

    /**
     * gigapascal
     */
    case REC20_GIGAPASCAL = 'A89';

    /**
     * rate
     */
    case REC20_RATE = 'A9';

    /**
     * gigawatt
     */
    case REC20_GIGAWATT = 'A90';

    /**
     * gon
     */
    case REC20_GON = 'A91';

    /**
     * gram per cubic metre
     */
    case REC20_GRAM_PER_CUBIC_METRE = 'A93';

    /**
     * gram per mole
     */
    case REC20_GRAM_PER_MOLE = 'A94';

    /**
     * gray
     */
    case REC20_GRAY = 'A95';

    /**
     * gray per second
     */
    case REC20_GRAY_PER_SECOND = 'A96';

    /**
     * hectopascal
     */
    case REC20_HECTOPASCAL = 'A97';

    /**
     * henry per metre
     */
    case REC20_HENRY_PER_METRE = 'A98';

    /**
     * bit
     */
    case REC20_BIT = 'A99';

    /**
     * ball
     */
    case REC20_BALL = 'AA';

    /**
     * bulk pack
     */
    case REC20_BULK_PACK = 'AB';

    /**
     * acre
     */
    case REC20_ACRE = 'ACR';

    /**
     * activity
     */
    case REC20_ACTIVITY = 'ACT';

    /**
     * byte
     */
    case REC20_BYTE = 'AD';

    /**
     * ampere per metre
     */
    case REC20_AMPERE_PER_METRE = 'AE';

    /**
     * additional minute
     */
    case REC20_ADDITIONAL_MINUTE = 'AH';

    /**
     * average minute per call
     */
    case REC20_AVERAGE_MINUTE_PER_CALL = 'AI';

    /**
     * fathom
     */
    case REC20_FATHOM = 'AK';

    /**
     * access line
     */
    case REC20_ACCESS_LINE = 'AL';

    /**
     * ampere hour
     */
    case REC20_AMPERE_HOUR = 'AMH';

    /**
     * ampere
     */
    case REC20_AMPERE = 'AMP';

    /**
     * year
     */
    case REC20_YEAR = 'ANN';

    /**
     * troy ounce or apothecary ounce
     */
    case REC20_TROY_OUNCE_OR_APOTHECARY_OUNCE = 'APZ';

    /**
     * anti-hemophilic factor (AHF) unit
     */
    case REC20_ANTIHEMOPHILIC_FACTOR_AHF_UNIT = 'AQ';

    /**
     * assortment
     */
    case REC20_ASSORTMENT = 'AS';

    /**
     * alcoholic strength by mass
     */
    case REC20_ALCOHOLIC_STRENGTH_BY_MASS = 'ASM';

    /**
     * alcoholic strength by volume
     */
    case REC20_ALCOHOLIC_STRENGTH_BY_VOLUME = 'ASU';

    /**
     * standard atmosphere
     */
    case REC20_STANDARD_ATMOSPHERE = 'ATM';

    /**
     * american wire gauge
     */
    case REC20_AMERICAN_WIRE_GAUGE = 'AWG';

    /**
     * assembly
     */
    case REC20_ASSEMBLY = 'AY';

    /**
     * British thermal unit (international table) per pound
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_POUND = 'AZ';

    /**
     * barrel (US) per day
     */
    case REC20_BARREL_US_PER_DAY = 'B1';

    /**
     * bit per second
     */
    case REC20_BIT_PER_SECOND = 'B10';

    /**
     * joule per kilogram kelvin
     */
    case REC20_JOULE_PER_KILOGRAM_KELVIN = 'B11';

    /**
     * joule per metre
     */
    case REC20_JOULE_PER_METRE = 'B12';

    /**
     * joule per square metre
     */
    case REC20_JOULE_PER_SQUARE_METRE = 'B13';

    /**
     * joule per metre to the fourth power
     */
    case REC20_JOULE_PER_METRE_TO_THE_FOURTH_POWER = 'B14';

    /**
     * joule per mole
     */
    case REC20_JOULE_PER_MOLE = 'B15';

    /**
     * joule per mole kelvin
     */
    case REC20_JOULE_PER_MOLE_KELVIN = 'B16';

    /**
     * credit
     */
    case REC20_CREDIT = 'B17';

    /**
     * joule second
     */
    case REC20_JOULE_SECOND = 'B18';

    /**
     * digit
     */
    case REC20_DIGIT = 'B19';

    /**
     * joule square metre per kilogram
     */
    case REC20_JOULE_SQUARE_METRE_PER_KILOGRAM = 'B20';

    /**
     * kelvin per watt
     */
    case REC20_KELVIN_PER_WATT = 'B21';

    /**
     * kiloampere
     */
    case REC20_KILOAMPERE = 'B22';

    /**
     * kiloampere per square metre
     */
    case REC20_KILOAMPERE_PER_SQUARE_METRE = 'B23';

    /**
     * kiloampere per metre
     */
    case REC20_KILOAMPERE_PER_METRE = 'B24';

    /**
     * kilobecquerel per kilogram
     */
    case REC20_KILOBECQUEREL_PER_KILOGRAM = 'B25';

    /**
     * kilocoulomb
     */
    case REC20_KILOCOULOMB = 'B26';

    /**
     * kilocoulomb per cubic metre
     */
    case REC20_KILOCOULOMB_PER_CUBIC_METRE = 'B27';

    /**
     * kilocoulomb per square metre
     */
    case REC20_KILOCOULOMB_PER_SQUARE_METRE = 'B28';

    /**
     * kiloelectronvolt
     */
    case REC20_KILOELECTRONVOLT = 'B29';

    /**
     * batting pound
     */
    case REC20_BATTING_POUND = 'B3';

    /**
     * gibibit
     */
    case REC20_GIBIBIT = 'B30';

    /**
     * kilogram metre per second
     */
    case REC20_KILOGRAM_METRE_PER_SECOND = 'B31';

    /**
     * kilogram metre squared
     */
    case REC20_KILOGRAM_METRE_SQUARED = 'B32';

    /**
     * kilogram metre squared per second
     */
    case REC20_KILOGRAM_METRE_SQUARED_PER_SECOND = 'B33';

    /**
     * kilogram per cubic decimetre
     */
    case REC20_KILOGRAM_PER_CUBIC_DECIMETRE = 'B34';

    /**
     * kilogram per litre
     */
    case REC20_KILOGRAM_PER_LITRE = 'B35';

    /**
     * barrel, imperial
     */
    case REC20_BARREL_IMPERIAL = 'B4';

    /**
     * kilojoule per kelvin
     */
    case REC20_KILOJOULE_PER_KELVIN = 'B41';

    /**
     * kilojoule per kilogram
     */
    case REC20_KILOJOULE_PER_KILOGRAM = 'B42';

    /**
     * kilojoule per kilogram kelvin
     */
    case REC20_KILOJOULE_PER_KILOGRAM_KELVIN = 'B43';

    /**
     * kilojoule per mole
     */
    case REC20_KILOJOULE_PER_MOLE = 'B44';

    /**
     * kilomole
     */
    case REC20_KILOMOLE = 'B45';

    /**
     * kilomole per cubic metre
     */
    case REC20_KILOMOLE_PER_CUBIC_METRE = 'B46';

    /**
     * kilonewton
     */
    case REC20_KILONEWTON = 'B47';

    /**
     * kilonewton metre
     */
    case REC20_KILONEWTON_METRE = 'B48';

    /**
     * kiloohm
     */
    case REC20_KILOOHM = 'B49';

    /**
     * kiloohm metre
     */
    case REC20_KILOOHM_METRE = 'B50';

    /**
     * kilosecond
     */
    case REC20_KILOSECOND = 'B52';

    /**
     * kilosiemens
     */
    case REC20_KILOSIEMENS = 'B53';

    /**
     * kilosiemens per metre
     */
    case REC20_KILOSIEMENS_PER_METRE = 'B54';

    /**
     * kilovolt per metre
     */
    case REC20_KILOVOLT_PER_METRE = 'B55';

    /**
     * kiloweber per metre
     */
    case REC20_KILOWEBER_PER_METRE = 'B56';

    /**
     * light year
     */
    case REC20_LIGHT_YEAR = 'B57';

    /**
     * litre per mole
     */
    case REC20_LITRE_PER_MOLE = 'B58';

    /**
     * lumen hour
     */
    case REC20_LUMEN_HOUR = 'B59';

    /**
     * lumen per square metre
     */
    case REC20_LUMEN_PER_SQUARE_METRE = 'B60';

    /**
     * lumen per watt
     */
    case REC20_LUMEN_PER_WATT = 'B61';

    /**
     * lumen second
     */
    case REC20_LUMEN_SECOND = 'B62';

    /**
     * lux hour
     */
    case REC20_LUX_HOUR = 'B63';

    /**
     * lux second
     */
    case REC20_LUX_SECOND = 'B64';

    /**
     * megaampere per square metre
     */
    case REC20_MEGAAMPERE_PER_SQUARE_METRE = 'B66';

    /**
     * megabecquerel per kilogram
     */
    case REC20_MEGABECQUEREL_PER_KILOGRAM = 'B67';

    /**
     * gigabit
     */
    case REC20_GIGABIT = 'B68';

    /**
     * megacoulomb per cubic metre
     */
    case REC20_MEGACOULOMB_PER_CUBIC_METRE = 'B69';

    /**
     * cycle
     */
    case REC20_CYCLE = 'B7';

    /**
     * megacoulomb per square metre
     */
    case REC20_MEGACOULOMB_PER_SQUARE_METRE = 'B70';

    /**
     * megaelectronvolt
     */
    case REC20_MEGAELECTRONVOLT = 'B71';

    /**
     * megagram per cubic metre
     */
    case REC20_MEGAGRAM_PER_CUBIC_METRE = 'B72';

    /**
     * meganewton
     */
    case REC20_MEGANEWTON = 'B73';

    /**
     * meganewton metre
     */
    case REC20_MEGANEWTON_METRE = 'B74';

    /**
     * megaohm
     */
    case REC20_MEGAOHM = 'B75';

    /**
     * megaohm metre
     */
    case REC20_MEGAOHM_METRE = 'B76';

    /**
     * megasiemens per metre
     */
    case REC20_MEGASIEMENS_PER_METRE = 'B77';

    /**
     * megavolt
     */
    case REC20_MEGAVOLT = 'B78';

    /**
     * megavolt per metre
     */
    case REC20_MEGAVOLT_PER_METRE = 'B79';

    /**
     * joule per cubic metre
     */
    case REC20_JOULE_PER_CUBIC_METRE = 'B8';

    /**
     * gigabit per second
     */
    case REC20_GIGABIT_PER_SECOND = 'B80';

    /**
     * reciprocal metre squared reciprocal second
     */
    case REC20_RECIPROCAL_METRE_SQUARED_RECIPROCAL_SECOND = 'B81';

    /**
     * inch per linear foot
     */
    case REC20_INCH_PER_LINEAR_FOOT = 'B82';

    /**
     * metre to the fourth power
     */
    case REC20_METRE_TO_THE_FOURTH_POWER = 'B83';

    /**
     * microampere
     */
    case REC20_MICROAMPERE = 'B84';

    /**
     * microbar
     */
    case REC20_MICROBAR = 'B85';

    /**
     * microcoulomb
     */
    case REC20_MICROCOULOMB = 'B86';

    /**
     * microcoulomb per cubic metre
     */
    case REC20_MICROCOULOMB_PER_CUBIC_METRE = 'B87';

    /**
     * microcoulomb per square metre
     */
    case REC20_MICROCOULOMB_PER_SQUARE_METRE = 'B88';

    /**
     * microfarad per metre
     */
    case REC20_MICROFARAD_PER_METRE = 'B89';

    /**
     * microhenry
     */
    case REC20_MICROHENRY = 'B90';

    /**
     * microhenry per metre
     */
    case REC20_MICROHENRY_PER_METRE = 'B91';

    /**
     * micronewton
     */
    case REC20_MICRONEWTON = 'B92';

    /**
     * micronewton metre
     */
    case REC20_MICRONEWTON_METRE = 'B93';

    /**
     * microohm
     */
    case REC20_MICROOHM = 'B94';

    /**
     * microohm metre
     */
    case REC20_MICROOHM_METRE = 'B95';

    /**
     * micropascal
     */
    case REC20_MICROPASCAL = 'B96';

    /**
     * microradian
     */
    case REC20_MICRORADIAN = 'B97';

    /**
     * microsecond
     */
    case REC20_MICROSECOND = 'B98';

    /**
     * microsiemens
     */
    case REC20_MICROSIEMENS = 'B99';

    /**
     * bar [unit of pressure]
     */
    case REC20_BAR_UNIT_OF_PRESSURE = 'BAR';

    /**
     * base box
     */
    case REC20_BASE_BOX = 'BB';

    /**
     * board foot
     */
    case REC20_BOARD_FOOT = 'BFT';

    /**
     * brake horse power
     */
    case REC20_BRAKE_HORSE_POWER = 'BHP';

    /**
     * billion (EUR)
     */
    case REC20_BILLION_EUR = 'BIL';

    /**
     * dry barrel (US)
     */
    case REC20_DRY_BARREL_US = 'BLD';

    /**
     * barrel (US)
     */
    case REC20_BARREL_US = 'BLL';

    /**
     * hundred board foot
     */
    case REC20_HUNDRED_BOARD_FOOT = 'BP';

    /**
     * beats per minute
     */
    case REC20_BEATS_PER_MINUTE = 'BPM';

    /**
     * becquerel
     */
    case REC20_BECQUEREL = 'BQL';

    /**
     * British thermal unit (international table)
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE = 'BTU';

    /**
     * bushel (US)
     */
    case REC20_BUSHEL_US = 'BUA';

    /**
     * bushel (UK)
     */
    case REC20_BUSHEL_UK = 'BUI';

    /**
     * call
     */
    case REC20_CALL = 'C0';

    /**
     * millifarad
     */
    case REC20_MILLIFARAD = 'C10';

    /**
     * milligal
     */
    case REC20_MILLIGAL = 'C11';

    /**
     * milligram per metre
     */
    case REC20_MILLIGRAM_PER_METRE = 'C12';

    /**
     * milligray
     */
    case REC20_MILLIGRAY = 'C13';

    /**
     * millihenry
     */
    case REC20_MILLIHENRY = 'C14';

    /**
     * millijoule
     */
    case REC20_MILLIJOULE = 'C15';

    /**
     * millimetre per second
     */
    case REC20_MILLIMETRE_PER_SECOND = 'C16';

    /**
     * millimetre squared per second
     */
    case REC20_MILLIMETRE_SQUARED_PER_SECOND = 'C17';

    /**
     * millimole
     */
    case REC20_MILLIMOLE = 'C18';

    /**
     * mole per kilogram
     */
    case REC20_MOLE_PER_KILOGRAM = 'C19';

    /**
     * millinewton
     */
    case REC20_MILLINEWTON = 'C20';

    /**
     * kibibit
     */
    case REC20_KIBIBIT = 'C21';

    /**
     * millinewton per metre
     */
    case REC20_MILLINEWTON_PER_METRE = 'C22';

    /**
     * milliohm metre
     */
    case REC20_MILLIOHM_METRE = 'C23';

    /**
     * millipascal second
     */
    case REC20_MILLIPASCAL_SECOND = 'C24';

    /**
     * milliradian
     */
    case REC20_MILLIRADIAN = 'C25';

    /**
     * millisecond
     */
    case REC20_MILLISECOND = 'C26';

    /**
     * millisiemens
     */
    case REC20_MILLISIEMENS = 'C27';

    /**
     * millisievert
     */
    case REC20_MILLISIEVERT = 'C28';

    /**
     * millitesla
     */
    case REC20_MILLITESLA = 'C29';

    /**
     * microvolt per metre
     */
    case REC20_MICROVOLT_PER_METRE = 'C3';

    /**
     * millivolt per metre
     */
    case REC20_MILLIVOLT_PER_METRE = 'C30';

    /**
     * milliwatt
     */
    case REC20_MILLIWATT = 'C31';

    /**
     * milliwatt per square metre
     */
    case REC20_MILLIWATT_PER_SQUARE_METRE = 'C32';

    /**
     * milliweber
     */
    case REC20_MILLIWEBER = 'C33';

    /**
     * mole
     */
    case REC20_MOLE = 'C34';

    /**
     * mole per cubic decimetre
     */
    case REC20_MOLE_PER_CUBIC_DECIMETRE = 'C35';

    /**
     * mole per cubic metre
     */
    case REC20_MOLE_PER_CUBIC_METRE = 'C36';

    /**
     * kilobit
     */
    case REC20_KILOBIT = 'C37';

    /**
     * mole per litre
     */
    case REC20_MOLE_PER_LITRE = 'C38';

    /**
     * nanoampere
     */
    case REC20_NANOAMPERE = 'C39';

    /**
     * nanocoulomb
     */
    case REC20_NANOCOULOMB = 'C40';

    /**
     * nanofarad
     */
    case REC20_NANOFARAD = 'C41';

    /**
     * nanofarad per metre
     */
    case REC20_NANOFARAD_PER_METRE = 'C42';

    /**
     * nanohenry
     */
    case REC20_NANOHENRY = 'C43';

    /**
     * nanohenry per metre
     */
    case REC20_NANOHENRY_PER_METRE = 'C44';

    /**
     * nanometre
     */
    case REC20_NANOMETRE = 'C45';

    /**
     * nanoohm metre
     */
    case REC20_NANOOHM_METRE = 'C46';

    /**
     * nanosecond
     */
    case REC20_NANOSECOND = 'C47';

    /**
     * nanotesla
     */
    case REC20_NANOTESLA = 'C48';

    /**
     * nanowatt
     */
    case REC20_NANOWATT = 'C49';

    /**
     * neper
     */
    case REC20_NEPER = 'C50';

    /**
     * neper per second
     */
    case REC20_NEPER_PER_SECOND = 'C51';

    /**
     * picometre
     */
    case REC20_PICOMETRE = 'C52';

    /**
     * newton metre second
     */
    case REC20_NEWTON_METRE_SECOND = 'C53';

    /**
     * newton metre squared per kilogram squared
     */
    case REC20_NEWTON_METRE_SQUARED_PER_KILOGRAM_SQUARED = 'C54';

    /**
     * newton per square metre
     */
    case REC20_NEWTON_PER_SQUARE_METRE = 'C55';

    /**
     * newton per square millimetre
     */
    case REC20_NEWTON_PER_SQUARE_MILLIMETRE = 'C56';

    /**
     * newton second
     */
    case REC20_NEWTON_SECOND = 'C57';

    /**
     * newton second per metre
     */
    case REC20_NEWTON_SECOND_PER_METRE = 'C58';

    /**
     * octave
     */
    case REC20_OCTAVE = 'C59';

    /**
     * ohm centimetre
     */
    case REC20_OHM_CENTIMETRE = 'C60';

    /**
     * ohm metre
     */
    case REC20_OHM_METRE = 'C61';

    /**
     * one
     */
    case REC20_ONE = 'C62';

    /**
     * parsec
     */
    case REC20_PARSEC = 'C63';

    /**
     * pascal per kelvin
     */
    case REC20_PASCAL_PER_KELVIN = 'C64';

    /**
     * pascal second
     */
    case REC20_PASCAL_SECOND = 'C65';

    /**
     * pascal second per cubic metre
     */
    case REC20_PASCAL_SECOND_PER_CUBIC_METRE = 'C66';

    /**
     * pascal second per metre
     */
    case REC20_PASCAL_SECOND_PER_METRE = 'C67';

    /**
     * petajoule
     */
    case REC20_PETAJOULE = 'C68';

    /**
     * phon
     */
    case REC20_PHON = 'C69';

    /**
     * centipoise
     */
    case REC20_CENTIPOISE = 'C7';

    /**
     * picoampere
     */
    case REC20_PICOAMPERE = 'C70';

    /**
     * picocoulomb
     */
    case REC20_PICOCOULOMB = 'C71';

    /**
     * picofarad per metre
     */
    case REC20_PICOFARAD_PER_METRE = 'C72';

    /**
     * picohenry
     */
    case REC20_PICOHENRY = 'C73';

    /**
     * kilobit per second
     */
    case REC20_KILOBIT_PER_SECOND = 'C74';

    /**
     * picowatt
     */
    case REC20_PICOWATT = 'C75';

    /**
     * picowatt per square metre
     */
    case REC20_PICOWATT_PER_SQUARE_METRE = 'C76';

    /**
     * pound-force
     */
    case REC20_POUNDFORCE = 'C78';

    /**
     * kilovolt ampere hour
     */
    case REC20_KILOVOLT_AMPERE_HOUR = 'C79';

    /**
     * millicoulomb per kilogram
     */
    case REC20_MILLICOULOMB_PER_KILOGRAM = 'C8';

    /**
     * rad
     */
    case REC20_RAD = 'C80';

    /**
     * radian
     */
    case REC20_RADIAN = 'C81';

    /**
     * radian square metre per mole
     */
    case REC20_RADIAN_SQUARE_METRE_PER_MOLE = 'C82';

    /**
     * radian square metre per kilogram
     */
    case REC20_RADIAN_SQUARE_METRE_PER_KILOGRAM = 'C83';

    /**
     * radian per metre
     */
    case REC20_RADIAN_PER_METRE = 'C84';

    /**
     * reciprocal angstrom
     */
    case REC20_RECIPROCAL_ANGSTROM = 'C85';

    /**
     * reciprocal cubic metre
     */
    case REC20_RECIPROCAL_CUBIC_METRE = 'C86';

    /**
     * reciprocal cubic metre per second
     */
    case REC20_RECIPROCAL_CUBIC_METRE_PER_SECOND = 'C87';

    /**
     * reciprocal electron volt per cubic metre
     */
    case REC20_RECIPROCAL_ELECTRON_VOLT_PER_CUBIC_METRE = 'C88';

    /**
     * reciprocal henry
     */
    case REC20_RECIPROCAL_HENRY = 'C89';

    /**
     * coil group
     */
    case REC20_COIL_GROUP = 'C9';

    /**
     * reciprocal joule per cubic metre
     */
    case REC20_RECIPROCAL_JOULE_PER_CUBIC_METRE = 'C90';

    /**
     * reciprocal kelvin or kelvin to the power minus one
     */
    case REC20_RECIPROCAL_KELVIN_OR_KELVIN_TO_THE_POWER_MINUS_ONE = 'C91';

    /**
     * reciprocal metre
     */
    case REC20_RECIPROCAL_METRE = 'C92';

    /**
     * reciprocal square metre
     */
    case REC20_RECIPROCAL_SQUARE_METRE = 'C93';

    /**
     * reciprocal minute
     */
    case REC20_RECIPROCAL_MINUTE = 'C94';

    /**
     * reciprocal mole
     */
    case REC20_RECIPROCAL_MOLE = 'C95';

    /**
     * reciprocal pascal or pascal to the power minus one
     */
    case REC20_RECIPROCAL_PASCAL_OR_PASCAL_TO_THE_POWER_MINUS_ONE = 'C96';

    /**
     * reciprocal second
     */
    case REC20_RECIPROCAL_SECOND = 'C97';

    /**
     * reciprocal second per metre squared
     */
    case REC20_RECIPROCAL_SECOND_PER_METRE_SQUARED = 'C99';

    /**
     * carrying capacity in metric ton
     */
    case REC20_CARRYING_CAPACITY_IN_METRIC_TON = 'CCT';

    /**
     * candela
     */
    case REC20_CANDELA = 'CDL';

    /**
     * degree Celsius
     */
    case REC20_DEGREE_CELSIUS = 'CEL';

    /**
     * hundred
     */
    case REC20_HUNDRED = 'CEN';

    /**
     * card
     */
    case REC20_CARD = 'CG';

    /**
     * centigram
     */
    case REC20_CENTIGRAM = 'CGM';

    /**
     * coulomb per kilogram
     */
    case REC20_COULOMB_PER_KILOGRAM = 'CKG';

    /**
     * hundred leave
     */
    case REC20_HUNDRED_LEAVE = 'CLF';

    /**
     * centilitre
     */
    case REC20_CENTILITRE = 'CLT';

    /**
     * square centimetre
     */
    case REC20_SQUARE_CENTIMETRE = 'CMK';

    /**
     * cubic centimetre
     */
    case REC20_CUBIC_CENTIMETRE = 'CMQ';

    /**
     * centimetre
     */
    case REC20_CENTIMETRE = 'CMT';

    /**
     * hundred pack
     */
    case REC20_HUNDRED_PACK = 'CNP';

    /**
     * cental (UK)
     */
    case REC20_CENTAL_UK = 'CNT';

    /**
     * coulomb
     */
    case REC20_COULOMB = 'COU';

    /**
     * content gram
     */
    case REC20_CONTENT_GRAM = 'CTG';

    /**
     * metric carat
     */
    case REC20_METRIC_CARAT = 'CTM';

    /**
     * content ton (metric)
     */
    case REC20_CONTENT_TON_METRIC = 'CTN';

    /**
     * curie
     */
    case REC20_CURIE = 'CUR';

    /**
     * hundred pound (cwt) / hundred weight (US)
     */
    case REC20_HUNDRED_POUND_CWT___HUNDRED_WEIGHT_US = 'CWA';

    /**
     * hundred weight (UK)
     */
    case REC20_HUNDRED_WEIGHT_UK = 'CWI';

    /**
     * kilowatt hour per hour
     */
    case REC20_KILOWATT_HOUR_PER_HOUR = 'D03';

    /**
     * lot  [unit of weight]
     */
    case REC20_LOT__UNIT_OF_WEIGHT = 'D04';

    /**
     * reciprocal second per steradian
     */
    case REC20_RECIPROCAL_SECOND_PER_STERADIAN = 'D1';

    /**
     * siemens per metre
     */
    case REC20_SIEMENS_PER_METRE = 'D10';

    /**
     * mebibit
     */
    case REC20_MEBIBIT = 'D11';

    /**
     * siemens square metre per mole
     */
    case REC20_SIEMENS_SQUARE_METRE_PER_MOLE = 'D12';

    /**
     * sievert
     */
    case REC20_SIEVERT = 'D13';

    /**
     * sone
     */
    case REC20_SONE = 'D15';

    /**
     * square centimetre per erg
     */
    case REC20_SQUARE_CENTIMETRE_PER_ERG = 'D16';

    /**
     * square centimetre per steradian erg
     */
    case REC20_SQUARE_CENTIMETRE_PER_STERADIAN_ERG = 'D17';

    /**
     * metre kelvin
     */
    case REC20_METRE_KELVIN = 'D18';

    /**
     * square metre kelvin per watt
     */
    case REC20_SQUARE_METRE_KELVIN_PER_WATT = 'D19';

    /**
     * reciprocal second per steradian metre squared
     */
    case REC20_RECIPROCAL_SECOND_PER_STERADIAN_METRE_SQUARED = 'D2';

    /**
     * square metre per joule
     */
    case REC20_SQUARE_METRE_PER_JOULE = 'D20';

    /**
     * square metre per kilogram
     */
    case REC20_SQUARE_METRE_PER_KILOGRAM = 'D21';

    /**
     * square metre per mole
     */
    case REC20_SQUARE_METRE_PER_MOLE = 'D22';

    /**
     * pen gram (protein)
     */
    case REC20_PEN_GRAM_PROTEIN = 'D23';

    /**
     * square metre per steradian
     */
    case REC20_SQUARE_METRE_PER_STERADIAN = 'D24';

    /**
     * square metre per steradian joule
     */
    case REC20_SQUARE_METRE_PER_STERADIAN_JOULE = 'D25';

    /**
     * square metre per volt second
     */
    case REC20_SQUARE_METRE_PER_VOLT_SECOND = 'D26';

    /**
     * steradian
     */
    case REC20_STERADIAN = 'D27';

    /**
     * terahertz
     */
    case REC20_TERAHERTZ = 'D29';

    /**
     * terajoule
     */
    case REC20_TERAJOULE = 'D30';

    /**
     * terawatt
     */
    case REC20_TERAWATT = 'D31';

    /**
     * terawatt hour
     */
    case REC20_TERAWATT_HOUR = 'D32';

    /**
     * tesla
     */
    case REC20_TESLA = 'D33';

    /**
     * tex
     */
    case REC20_TEX = 'D34';

    /**
     * megabit
     */
    case REC20_MEGABIT = 'D36';

    /**
     * tonne per cubic metre
     */
    case REC20_TONNE_PER_CUBIC_METRE = 'D41';

    /**
     * tropical year
     */
    case REC20_TROPICAL_YEAR = 'D42';

    /**
     * unified atomic mass unit
     */
    case REC20_UNIFIED_ATOMIC_MASS_UNIT = 'D43';

    /**
     * var
     */
    case REC20_VAR = 'D44';

    /**
     * volt squared per kelvin squared
     */
    case REC20_VOLT_SQUARED_PER_KELVIN_SQUARED = 'D45';

    /**
     * volt - ampere
     */
    case REC20_VOLT__AMPERE = 'D46';

    /**
     * volt per centimetre
     */
    case REC20_VOLT_PER_CENTIMETRE = 'D47';

    /**
     * volt per kelvin
     */
    case REC20_VOLT_PER_KELVIN = 'D48';

    /**
     * millivolt per kelvin
     */
    case REC20_MILLIVOLT_PER_KELVIN = 'D49';

    /**
     * kilogram per square centimetre
     */
    case REC20_KILOGRAM_PER_SQUARE_CENTIMETRE = 'D5';

    /**
     * volt per metre
     */
    case REC20_VOLT_PER_METRE = 'D50';

    /**
     * volt per millimetre
     */
    case REC20_VOLT_PER_MILLIMETRE = 'D51';

    /**
     * watt per kelvin
     */
    case REC20_WATT_PER_KELVIN = 'D52';

    /**
     * watt per metre kelvin
     */
    case REC20_WATT_PER_METRE_KELVIN = 'D53';

    /**
     * watt per square metre
     */
    case REC20_WATT_PER_SQUARE_METRE = 'D54';

    /**
     * watt per square metre kelvin
     */
    case REC20_WATT_PER_SQUARE_METRE_KELVIN = 'D55';

    /**
     * watt per square metre kelvin to the fourth power
     */
    case REC20_WATT_PER_SQUARE_METRE_KELVIN_TO_THE_FOURTH_POWER = 'D56';

    /**
     * watt per steradian
     */
    case REC20_WATT_PER_STERADIAN = 'D57';

    /**
     * watt per steradian square metre
     */
    case REC20_WATT_PER_STERADIAN_SQUARE_METRE = 'D58';

    /**
     * weber per metre
     */
    case REC20_WEBER_PER_METRE = 'D59';

    /**
     * roentgen per second
     */
    case REC20_ROENTGEN_PER_SECOND = 'D6';

    /**
     * weber per millimetre
     */
    case REC20_WEBER_PER_MILLIMETRE = 'D60';

    /**
     * minute [unit of angle]
     */
    case REC20_MINUTE_UNIT_OF_ANGLE = 'D61';

    /**
     * second [unit of angle]
     */
    case REC20_SECOND_UNIT_OF_ANGLE = 'D62';

    /**
     * book
     */
    case REC20_BOOK = 'D63';

    /**
     * round
     */
    case REC20_ROUND = 'D65';

    /**
     * number of words
     */
    case REC20_NUMBER_OF_WORDS = 'D68';

    /**
     * inch to the fourth power
     */
    case REC20_INCH_TO_THE_FOURTH_POWER = 'D69';

    /**
     * joule square metre
     */
    case REC20_JOULE_SQUARE_METRE = 'D73';

    /**
     * kilogram per mole
     */
    case REC20_KILOGRAM_PER_MOLE = 'D74';

    /**
     * megacoulomb
     */
    case REC20_MEGACOULOMB = 'D77';

    /**
     * megajoule per second
     */
    case REC20_MEGAJOULE_PER_SECOND = 'D78';

    /**
     * microwatt
     */
    case REC20_MICROWATT = 'D80';

    /**
     * microtesla
     */
    case REC20_MICROTESLA = 'D81';

    /**
     * microvolt
     */
    case REC20_MICROVOLT = 'D82';

    /**
     * millinewton metre
     */
    case REC20_MILLINEWTON_METRE = 'D83';

    /**
     * microwatt per square metre
     */
    case REC20_MICROWATT_PER_SQUARE_METRE = 'D85';

    /**
     * millicoulomb
     */
    case REC20_MILLICOULOMB = 'D86';

    /**
     * millimole per kilogram
     */
    case REC20_MILLIMOLE_PER_KILOGRAM = 'D87';

    /**
     * millicoulomb per cubic metre
     */
    case REC20_MILLICOULOMB_PER_CUBIC_METRE = 'D88';

    /**
     * millicoulomb per square metre
     */
    case REC20_MILLICOULOMB_PER_SQUARE_METRE = 'D89';

    /**
     * rem
     */
    case REC20_REM = 'D91';

    /**
     * second per cubic metre
     */
    case REC20_SECOND_PER_CUBIC_METRE = 'D93';

    /**
     * second per cubic metre radian
     */
    case REC20_SECOND_PER_CUBIC_METRE_RADIAN = 'D94';

    /**
     * joule per gram
     */
    case REC20_JOULE_PER_GRAM = 'D95';

    /**
     * decare
     */
    case REC20_DECARE = 'DAA';

    /**
     * ten day
     */
    case REC20_TEN_DAY = 'DAD';

    /**
     * day
     */
    case REC20_DAY = 'DAY';

    /**
     * dry pound
     */
    case REC20_DRY_POUND = 'DB';

    /**
     * degree [unit of angle]
     */
    case REC20_DEGREE_UNIT_OF_ANGLE = 'DD';

    /**
     * decade
     */
    case REC20_DECADE = 'DEC';

    /**
     * decigram
     */
    case REC20_DECIGRAM = 'DG';

    /**
     * decagram
     */
    case REC20_DECAGRAM = 'DJ';

    /**
     * decilitre
     */
    case REC20_DECILITRE = 'DLT';

    /**
     * cubic decametre
     */
    case REC20_CUBIC_DECAMETRE = 'DMA';

    /**
     * square decimetre
     */
    case REC20_SQUARE_DECIMETRE = 'DMK';

    /**
     * standard kilolitre
     */
    case REC20_STANDARD_KILOLITRE = 'DMO';

    /**
     * cubic decimetre
     */
    case REC20_CUBIC_DECIMETRE = 'DMQ';

    /**
     * decimetre
     */
    case REC20_DECIMETRE = 'DMT';

    /**
     * decinewton metre
     */
    case REC20_DECINEWTON_METRE = 'DN';

    /**
     * dozen piece
     */
    case REC20_DOZEN_PIECE = 'DPC';

    /**
     * dozen pair
     */
    case REC20_DOZEN_PAIR = 'DPR';

    /**
     * displacement tonnage
     */
    case REC20_DISPLACEMENT_TONNAGE = 'DPT';

    /**
     * dram (US)
     */
    case REC20_DRAM_US = 'DRA';

    /**
     * dram (UK)
     */
    case REC20_DRAM_UK = 'DRI';

    /**
     * dozen roll
     */
    case REC20_DOZEN_ROLL = 'DRL';

    /**
     * dry ton
     */
    case REC20_DRY_TON = 'DT';

    /**
     * decitonne
     */
    case REC20_DECITONNE = 'DTN';

    /**
     * pennyweight
     */
    case REC20_PENNYWEIGHT = 'DWT';

    /**
     * dozen
     */
    case REC20_DOZEN = 'DZN';

    /**
     * dozen pack
     */
    case REC20_DOZEN_PACK = 'DZP';

    /**
     * newton per square centimetre
     */
    case REC20_NEWTON_PER_SQUARE_CENTIMETRE = 'E01';

    /**
     * megawatt hour per hour
     */
    case REC20_MEGAWATT_HOUR_PER_HOUR = 'E07';

    /**
     * megawatt per hertz
     */
    case REC20_MEGAWATT_PER_HERTZ = 'E08';

    /**
     * milliampere hour
     */
    case REC20_MILLIAMPERE_HOUR = 'E09';

    /**
     * degree day
     */
    case REC20_DEGREE_DAY = 'E10';

    /**
     * mille
     */
    case REC20_MILLE = 'E12';

    /**
     * kilocalorie (international table)
     */
    case REC20_KILOCALORIE_INTERNATIONAL_TABLE = 'E14';

    /**
     * kilocalorie (thermochemical) per hour
     */
    case REC20_KILOCALORIE_THERMOCHEMICAL_PER_HOUR = 'E15';

    /**
     * million Btu(IT) per hour
     */
    case REC20_MILLION_BTUIT_PER_HOUR = 'E16';

    /**
     * cubic foot per second
     */
    case REC20_CUBIC_FOOT_PER_SECOND = 'E17';

    /**
     * tonne per hour
     */
    case REC20_TONNE_PER_HOUR = 'E18';

    /**
     * ping
     */
    case REC20_PING = 'E19';

    /**
     * megabit per second
     */
    case REC20_MEGABIT_PER_SECOND = 'E20';

    /**
     * shares
     */
    case REC20_SHARES = 'E21';

    /**
     * TEU
     */
    case REC20_TEU = 'E22';

    /**
     * tyre
     */
    case REC20_TYRE = 'E23';

    /**
     * active unit
     */
    case REC20_ACTIVE_UNIT = 'E25';

    /**
     * dose
     */
    case REC20_DOSE = 'E27';

    /**
     * air dry ton
     */
    case REC20_AIR_DRY_TON = 'E28';

    /**
     * strand
     */
    case REC20_STRAND = 'E30';

    /**
     * square metre per litre
     */
    case REC20_SQUARE_METRE_PER_LITRE = 'E31';

    /**
     * litre per hour
     */
    case REC20_LITRE_PER_HOUR = 'E32';

    /**
     * foot per thousand
     */
    case REC20_FOOT_PER_THOUSAND = 'E33';

    /**
     * gigabyte
     */
    case REC20_GIGABYTE = 'E34';

    /**
     * terabyte
     */
    case REC20_TERABYTE = 'E35';

    /**
     * petabyte
     */
    case REC20_PETABYTE = 'E36';

    /**
     * pixel
     */
    case REC20_PIXEL = 'E37';

    /**
     * megapixel
     */
    case REC20_MEGAPIXEL = 'E38';

    /**
     * dots per inch
     */
    case REC20_DOTS_PER_INCH = 'E39';

    /**
     * gross kilogram
     */
    case REC20_GROSS_KILOGRAM = 'E4';

    /**
     * part per hundred thousand
     */
    case REC20_PART_PER_HUNDRED_THOUSAND = 'E40';

    /**
     * kilogram-force per square millimetre
     */
    case REC20_KILOGRAMFORCE_PER_SQUARE_MILLIMETRE = 'E41';

    /**
     * kilogram-force per square centimetre
     */
    case REC20_KILOGRAMFORCE_PER_SQUARE_CENTIMETRE = 'E42';

    /**
     * joule per square centimetre
     */
    case REC20_JOULE_PER_SQUARE_CENTIMETRE = 'E43';

    /**
     * kilogram-force metre per square centimetre
     */
    case REC20_KILOGRAMFORCE_METRE_PER_SQUARE_CENTIMETRE = 'E44';

    /**
     * milliohm
     */
    case REC20_MILLIOHM = 'E45';

    /**
     * kilowatt hour per cubic metre
     */
    case REC20_KILOWATT_HOUR_PER_CUBIC_METRE = 'E46';

    /**
     * kilowatt hour per kelvin
     */
    case REC20_KILOWATT_HOUR_PER_KELVIN = 'E47';

    /**
     * service unit
     */
    case REC20_SERVICE_UNIT = 'E48';

    /**
     * working day
     */
    case REC20_WORKING_DAY = 'E49';

    /**
     * accounting unit
     */
    case REC20_ACCOUNTING_UNIT = 'E50';

    /**
     * job
     */
    case REC20_JOB = 'E51';

    /**
     * run foot
     */
    case REC20_RUN_FOOT = 'E52';

    /**
     * test
     */
    case REC20_TEST = 'E53';

    /**
     * trip
     */
    case REC20_TRIP = 'E54';

    /**
     * use
     */
    case REC20_USE = 'E55';

    /**
     * well
     */
    case REC20_WELL = 'E56';

    /**
     * zone
     */
    case REC20_ZONE = 'E57';

    /**
     * exabit per second
     */
    case REC20_EXABIT_PER_SECOND = 'E58';

    /**
     * exbibyte
     */
    case REC20_EXBIBYTE = 'E59';

    /**
     * pebibyte
     */
    case REC20_PEBIBYTE = 'E60';

    /**
     * tebibyte
     */
    case REC20_TEBIBYTE = 'E61';

    /**
     * gibibyte
     */
    case REC20_GIBIBYTE = 'E62';

    /**
     * mebibyte
     */
    case REC20_MEBIBYTE = 'E63';

    /**
     * kibibyte
     */
    case REC20_KIBIBYTE = 'E64';

    /**
     * exbibit per metre
     */
    case REC20_EXBIBIT_PER_METRE = 'E65';

    /**
     * exbibit per square metre
     */
    case REC20_EXBIBIT_PER_SQUARE_METRE = 'E66';

    /**
     * exbibit per cubic metre
     */
    case REC20_EXBIBIT_PER_CUBIC_METRE = 'E67';

    /**
     * gigabyte per second
     */
    case REC20_GIGABYTE_PER_SECOND = 'E68';

    /**
     * gibibit per metre
     */
    case REC20_GIBIBIT_PER_METRE = 'E69';

    /**
     * gibibit per square metre
     */
    case REC20_GIBIBIT_PER_SQUARE_METRE = 'E70';

    /**
     * gibibit per cubic metre
     */
    case REC20_GIBIBIT_PER_CUBIC_METRE = 'E71';

    /**
     * kibibit per metre
     */
    case REC20_KIBIBIT_PER_METRE = 'E72';

    /**
     * kibibit per square metre
     */
    case REC20_KIBIBIT_PER_SQUARE_METRE = 'E73';

    /**
     * kibibit per cubic metre
     */
    case REC20_KIBIBIT_PER_CUBIC_METRE = 'E74';

    /**
     * mebibit per metre
     */
    case REC20_MEBIBIT_PER_METRE = 'E75';

    /**
     * mebibit per square metre
     */
    case REC20_MEBIBIT_PER_SQUARE_METRE = 'E76';

    /**
     * mebibit per cubic metre
     */
    case REC20_MEBIBIT_PER_CUBIC_METRE = 'E77';

    /**
     * petabit
     */
    case REC20_PETABIT = 'E78';

    /**
     * petabit per second
     */
    case REC20_PETABIT_PER_SECOND = 'E79';

    /**
     * pebibit per metre
     */
    case REC20_PEBIBIT_PER_METRE = 'E80';

    /**
     * pebibit per square metre
     */
    case REC20_PEBIBIT_PER_SQUARE_METRE = 'E81';

    /**
     * pebibit per cubic metre
     */
    case REC20_PEBIBIT_PER_CUBIC_METRE = 'E82';

    /**
     * terabit
     */
    case REC20_TERABIT = 'E83';

    /**
     * terabit per second
     */
    case REC20_TERABIT_PER_SECOND = 'E84';

    /**
     * tebibit per metre
     */
    case REC20_TEBIBIT_PER_METRE = 'E85';

    /**
     * tebibit per cubic metre
     */
    case REC20_TEBIBIT_PER_CUBIC_METRE = 'E86';

    /**
     * tebibit per square metre
     */
    case REC20_TEBIBIT_PER_SQUARE_METRE = 'E87';

    /**
     * bit per metre
     */
    case REC20_BIT_PER_METRE = 'E88';

    /**
     * bit per square metre
     */
    case REC20_BIT_PER_SQUARE_METRE = 'E89';

    /**
     * reciprocal centimetre
     */
    case REC20_RECIPROCAL_CENTIMETRE = 'E90';

    /**
     * reciprocal day
     */
    case REC20_RECIPROCAL_DAY = 'E91';

    /**
     * cubic decimetre per hour
     */
    case REC20_CUBIC_DECIMETRE_PER_HOUR = 'E92';

    /**
     * kilogram per hour
     */
    case REC20_KILOGRAM_PER_HOUR = 'E93';

    /**
     * kilomole per second
     */
    case REC20_KILOMOLE_PER_SECOND = 'E94';

    /**
     * mole per second
     */
    case REC20_MOLE_PER_SECOND = 'E95';

    /**
     * degree per second
     */
    case REC20_DEGREE_PER_SECOND = 'E96';

    /**
     * millimetre per degree Celcius metre
     */
    case REC20_MILLIMETRE_PER_DEGREE_CELCIUS_METRE = 'E97';

    /**
     * degree Celsius per kelvin
     */
    case REC20_DEGREE_CELSIUS_PER_KELVIN = 'E98';

    /**
     * hectopascal per bar
     */
    case REC20_HECTOPASCAL_PER_BAR = 'E99';

    /**
     * each
     */
    case REC20_EACH = 'EA';

    /**
     * electronic mail box
     */
    case REC20_ELECTRONIC_MAIL_BOX = 'EB';

    /**
     * equivalent gallon
     */
    case REC20_EQUIVALENT_GALLON = 'EQ';

    /**
     * bit per cubic metre
     */
    case REC20_BIT_PER_CUBIC_METRE = 'F01';

    /**
     * kelvin per kelvin
     */
    case REC20_KELVIN_PER_KELVIN = 'F02';

    /**
     * kilopascal per bar
     */
    case REC20_KILOPASCAL_PER_BAR = 'F03';

    /**
     * millibar per bar
     */
    case REC20_MILLIBAR_PER_BAR = 'F04';

    /**
     * megapascal per bar
     */
    case REC20_MEGAPASCAL_PER_BAR = 'F05';

    /**
     * poise per bar
     */
    case REC20_POISE_PER_BAR = 'F06';

    /**
     * pascal per bar
     */
    case REC20_PASCAL_PER_BAR = 'F07';

    /**
     * milliampere per inch
     */
    case REC20_MILLIAMPERE_PER_INCH = 'F08';

    /**
     * kelvin per hour
     */
    case REC20_KELVIN_PER_HOUR = 'F10';

    /**
     * kelvin per minute
     */
    case REC20_KELVIN_PER_MINUTE = 'F11';

    /**
     * kelvin per second
     */
    case REC20_KELVIN_PER_SECOND = 'F12';

    /**
     * slug
     */
    case REC20_SLUG = 'F13';

    /**
     * gram per kelvin
     */
    case REC20_GRAM_PER_KELVIN = 'F14';

    /**
     * kilogram per kelvin
     */
    case REC20_KILOGRAM_PER_KELVIN = 'F15';

    /**
     * milligram per kelvin
     */
    case REC20_MILLIGRAM_PER_KELVIN = 'F16';

    /**
     * pound-force per foot
     */
    case REC20_POUNDFORCE_PER_FOOT = 'F17';

    /**
     * kilogram square centimetre
     */
    case REC20_KILOGRAM_SQUARE_CENTIMETRE = 'F18';

    /**
     * kilogram square millimetre
     */
    case REC20_KILOGRAM_SQUARE_MILLIMETRE = 'F19';

    /**
     * pound inch squared
     */
    case REC20_POUND_INCH_SQUARED = 'F20';

    /**
     * pound-force inch
     */
    case REC20_POUNDFORCE_INCH = 'F21';

    /**
     * pound-force foot per ampere
     */
    case REC20_POUNDFORCE_FOOT_PER_AMPERE = 'F22';

    /**
     * gram per cubic decimetre
     */
    case REC20_GRAM_PER_CUBIC_DECIMETRE = 'F23';

    /**
     * kilogram per kilomol
     */
    case REC20_KILOGRAM_PER_KILOMOL = 'F24';

    /**
     * gram per hertz
     */
    case REC20_GRAM_PER_HERTZ = 'F25';

    /**
     * gram per day
     */
    case REC20_GRAM_PER_DAY = 'F26';

    /**
     * gram per hour
     */
    case REC20_GRAM_PER_HOUR = 'F27';

    /**
     * gram per minute
     */
    case REC20_GRAM_PER_MINUTE = 'F28';

    /**
     * gram per second
     */
    case REC20_GRAM_PER_SECOND = 'F29';

    /**
     * kilogram per day
     */
    case REC20_KILOGRAM_PER_DAY = 'F30';

    /**
     * kilogram per minute
     */
    case REC20_KILOGRAM_PER_MINUTE = 'F31';

    /**
     * milligram per day
     */
    case REC20_MILLIGRAM_PER_DAY = 'F32';

    /**
     * milligram per minute
     */
    case REC20_MILLIGRAM_PER_MINUTE = 'F33';

    /**
     * milligram per second
     */
    case REC20_MILLIGRAM_PER_SECOND = 'F34';

    /**
     * gram per day kelvin
     */
    case REC20_GRAM_PER_DAY_KELVIN = 'F35';

    /**
     * gram per hour kelvin
     */
    case REC20_GRAM_PER_HOUR_KELVIN = 'F36';

    /**
     * gram per minute kelvin
     */
    case REC20_GRAM_PER_MINUTE_KELVIN = 'F37';

    /**
     * gram per second kelvin
     */
    case REC20_GRAM_PER_SECOND_KELVIN = 'F38';

    /**
     * kilogram per day kelvin
     */
    case REC20_KILOGRAM_PER_DAY_KELVIN = 'F39';

    /**
     * kilogram per hour kelvin
     */
    case REC20_KILOGRAM_PER_HOUR_KELVIN = 'F40';

    /**
     * kilogram per minute kelvin
     */
    case REC20_KILOGRAM_PER_MINUTE_KELVIN = 'F41';

    /**
     * kilogram per second kelvin
     */
    case REC20_KILOGRAM_PER_SECOND_KELVIN = 'F42';

    /**
     * milligram per day kelvin
     */
    case REC20_MILLIGRAM_PER_DAY_KELVIN = 'F43';

    /**
     * milligram per hour kelvin
     */
    case REC20_MILLIGRAM_PER_HOUR_KELVIN = 'F44';

    /**
     * milligram per minute kelvin
     */
    case REC20_MILLIGRAM_PER_MINUTE_KELVIN = 'F45';

    /**
     * milligram per second kelvin
     */
    case REC20_MILLIGRAM_PER_SECOND_KELVIN = 'F46';

    /**
     * newton per millimetre
     */
    case REC20_NEWTON_PER_MILLIMETRE = 'F47';

    /**
     * pound-force per inch
     */
    case REC20_POUNDFORCE_PER_INCH = 'F48';

    /**
     * rod [unit of distance]
     */
    case REC20_ROD_UNIT_OF_DISTANCE = 'F49';

    /**
     * micrometre per kelvin
     */
    case REC20_MICROMETRE_PER_KELVIN = 'F50';

    /**
     * centimetre per kelvin
     */
    case REC20_CENTIMETRE_PER_KELVIN = 'F51';

    /**
     * metre per kelvin
     */
    case REC20_METRE_PER_KELVIN = 'F52';

    /**
     * millimetre per kelvin
     */
    case REC20_MILLIMETRE_PER_KELVIN = 'F53';

    /**
     * milliohm per metre
     */
    case REC20_MILLIOHM_PER_METRE = 'F54';

    /**
     * ohm per mile (statute mile)
     */
    case REC20_OHM_PER_MILE_STATUTE_MILE = 'F55';

    /**
     * ohm per kilometre
     */
    case REC20_OHM_PER_KILOMETRE = 'F56';

    /**
     * milliampere per pound-force per square inch
     */
    case REC20_MILLIAMPERE_PER_POUNDFORCE_PER_SQUARE_INCH = 'F57';

    /**
     * reciprocal bar
     */
    case REC20_RECIPROCAL_BAR = 'F58';

    /**
     * milliampere per bar
     */
    case REC20_MILLIAMPERE_PER_BAR = 'F59';

    /**
     * degree Celsius per bar
     */
    case REC20_DEGREE_CELSIUS_PER_BAR = 'F60';

    /**
     * kelvin per bar
     */
    case REC20_KELVIN_PER_BAR = 'F61';

    /**
     * gram per day bar
     */
    case REC20_GRAM_PER_DAY_BAR = 'F62';

    /**
     * gram per hour bar
     */
    case REC20_GRAM_PER_HOUR_BAR = 'F63';

    /**
     * gram per minute bar
     */
    case REC20_GRAM_PER_MINUTE_BAR = 'F64';

    /**
     * gram per second bar
     */
    case REC20_GRAM_PER_SECOND_BAR = 'F65';

    /**
     * kilogram per day bar
     */
    case REC20_KILOGRAM_PER_DAY_BAR = 'F66';

    /**
     * kilogram per hour bar
     */
    case REC20_KILOGRAM_PER_HOUR_BAR = 'F67';

    /**
     * kilogram per minute bar
     */
    case REC20_KILOGRAM_PER_MINUTE_BAR = 'F68';

    /**
     * kilogram per second bar
     */
    case REC20_KILOGRAM_PER_SECOND_BAR = 'F69';

    /**
     * milligram per day bar
     */
    case REC20_MILLIGRAM_PER_DAY_BAR = 'F70';

    /**
     * milligram per hour bar
     */
    case REC20_MILLIGRAM_PER_HOUR_BAR = 'F71';

    /**
     * milligram per minute bar
     */
    case REC20_MILLIGRAM_PER_MINUTE_BAR = 'F72';

    /**
     * milligram per second bar
     */
    case REC20_MILLIGRAM_PER_SECOND_BAR = 'F73';

    /**
     * gram per bar
     */
    case REC20_GRAM_PER_BAR = 'F74';

    /**
     * milligram per bar
     */
    case REC20_MILLIGRAM_PER_BAR = 'F75';

    /**
     * milliampere per millimetre
     */
    case REC20_MILLIAMPERE_PER_MILLIMETRE = 'F76';

    /**
     * pascal second per kelvin
     */
    case REC20_PASCAL_SECOND_PER_KELVIN = 'F77';

    /**
     * inch of water
     */
    case REC20_INCH_OF_WATER = 'F78';

    /**
     * inch of mercury
     */
    case REC20_INCH_OF_MERCURY = 'F79';

    /**
     * water horse power
     */
    case REC20_WATER_HORSE_POWER = 'F80';

    /**
     * bar per kelvin
     */
    case REC20_BAR_PER_KELVIN = 'F81';

    /**
     * hectopascal per kelvin
     */
    case REC20_HECTOPASCAL_PER_KELVIN = 'F82';

    /**
     * kilopascal per kelvin
     */
    case REC20_KILOPASCAL_PER_KELVIN = 'F83';

    /**
     * millibar per kelvin
     */
    case REC20_MILLIBAR_PER_KELVIN = 'F84';

    /**
     * megapascal per kelvin
     */
    case REC20_MEGAPASCAL_PER_KELVIN = 'F85';

    /**
     * poise per kelvin
     */
    case REC20_POISE_PER_KELVIN = 'F86';

    /**
     * volt per litre minute
     */
    case REC20_VOLT_PER_LITRE_MINUTE = 'F87';

    /**
     * newton centimetre
     */
    case REC20_NEWTON_CENTIMETRE = 'F88';

    /**
     * newton metre per degree
     */
    case REC20_NEWTON_METRE_PER_DEGREE = 'F89';

    /**
     * newton metre per ampere
     */
    case REC20_NEWTON_METRE_PER_AMPERE = 'F90';

    /**
     * bar litre per second
     */
    case REC20_BAR_LITRE_PER_SECOND = 'F91';

    /**
     * bar cubic metre per second
     */
    case REC20_BAR_CUBIC_METRE_PER_SECOND = 'F92';

    /**
     * hectopascal litre per second
     */
    case REC20_HECTOPASCAL_LITRE_PER_SECOND = 'F93';

    /**
     * hectopascal cubic metre per second
     */
    case REC20_HECTOPASCAL_CUBIC_METRE_PER_SECOND = 'F94';

    /**
     * millibar litre per second
     */
    case REC20_MILLIBAR_LITRE_PER_SECOND = 'F95';

    /**
     * millibar cubic metre per second
     */
    case REC20_MILLIBAR_CUBIC_METRE_PER_SECOND = 'F96';

    /**
     * megapascal litre per second
     */
    case REC20_MEGAPASCAL_LITRE_PER_SECOND = 'F97';

    /**
     * megapascal cubic metre per second
     */
    case REC20_MEGAPASCAL_CUBIC_METRE_PER_SECOND = 'F98';

    /**
     * pascal litre per second
     */
    case REC20_PASCAL_LITRE_PER_SECOND = 'F99';

    /**
     * degree Fahrenheit
     */
    case REC20_DEGREE_FAHRENHEIT = 'FAH';

    /**
     * farad
     */
    case REC20_FARAD = 'FAR';

    /**
     * fibre metre
     */
    case REC20_FIBRE_METRE = 'FBM';

    /**
     * thousand cubic foot
     */
    case REC20_THOUSAND_CUBIC_FOOT = 'FC';

    /**
     * hundred cubic metre
     */
    case REC20_HUNDRED_CUBIC_METRE = 'FF';

    /**
     * micromole
     */
    case REC20_MICROMOLE = 'FH';

    /**
     * failures in time
     */
    case REC20_FAILURES_IN_TIME = 'FIT';

    /**
     * flake ton
     */
    case REC20_FLAKE_TON = 'FL';

    /**
     * foot
     */
    case REC20_FOOT = 'FOT';

    /**
     * pound per square foot
     */
    case REC20_POUND_PER_SQUARE_FOOT = 'FP';

    /**
     * foot per minute
     */
    case REC20_FOOT_PER_MINUTE = 'FR';

    /**
     * foot per second
     */
    case REC20_FOOT_PER_SECOND = 'FS';

    /**
     * square foot
     */
    case REC20_SQUARE_FOOT = 'FTK';

    /**
     * cubic foot
     */
    case REC20_CUBIC_FOOT = 'FTQ';

    /**
     * pascal cubic metre per second
     */
    case REC20_PASCAL_CUBIC_METRE_PER_SECOND = 'G01';

    /**
     * centimetre per bar
     */
    case REC20_CENTIMETRE_PER_BAR = 'G04';

    /**
     * metre per bar
     */
    case REC20_METRE_PER_BAR = 'G05';

    /**
     * millimetre per bar
     */
    case REC20_MILLIMETRE_PER_BAR = 'G06';

    /**
     * square inch per second
     */
    case REC20_SQUARE_INCH_PER_SECOND = 'G08';

    /**
     * square metre per second kelvin
     */
    case REC20_SQUARE_METRE_PER_SECOND_KELVIN = 'G09';

    /**
     * stokes per kelvin
     */
    case REC20_STOKES_PER_KELVIN = 'G10';

    /**
     * gram per cubic centimetre bar
     */
    case REC20_GRAM_PER_CUBIC_CENTIMETRE_BAR = 'G11';

    /**
     * gram per cubic decimetre bar
     */
    case REC20_GRAM_PER_CUBIC_DECIMETRE_BAR = 'G12';

    /**
     * gram per litre bar
     */
    case REC20_GRAM_PER_LITRE_BAR = 'G13';

    /**
     * gram per cubic metre bar
     */
    case REC20_GRAM_PER_CUBIC_METRE_BAR = 'G14';

    /**
     * gram per millilitre bar
     */
    case REC20_GRAM_PER_MILLILITRE_BAR = 'G15';

    /**
     * kilogram per cubic centimetre bar
     */
    case REC20_KILOGRAM_PER_CUBIC_CENTIMETRE_BAR = 'G16';

    /**
     * kilogram per litre bar
     */
    case REC20_KILOGRAM_PER_LITRE_BAR = 'G17';

    /**
     * kilogram per cubic metre bar
     */
    case REC20_KILOGRAM_PER_CUBIC_METRE_BAR = 'G18';

    /**
     * newton metre per kilogram
     */
    case REC20_NEWTON_METRE_PER_KILOGRAM = 'G19';

    /**
     * US gallon per minute
     */
    case REC20_US_GALLON_PER_MINUTE = 'G2';

    /**
     * pound-force foot per pound
     */
    case REC20_POUNDFORCE_FOOT_PER_POUND = 'G20';

    /**
     * cup [unit of volume]
     */
    case REC20_CUP_UNIT_OF_VOLUME = 'G21';

    /**
     * peck
     */
    case REC20_PECK = 'G23';

    /**
     * tablespoon (US)
     */
    case REC20_TABLESPOON_US = 'G24';

    /**
     * teaspoon (US)
     */
    case REC20_TEASPOON_US = 'G25';

    /**
     * stere
     */
    case REC20_STERE = 'G26';

    /**
     * cubic centimetre per kelvin
     */
    case REC20_CUBIC_CENTIMETRE_PER_KELVIN = 'G27';

    /**
     * litre per kelvin
     */
    case REC20_LITRE_PER_KELVIN = 'G28';

    /**
     * cubic metre per kelvin
     */
    case REC20_CUBIC_METRE_PER_KELVIN = 'G29';

    /**
     * Imperial gallon per minute
     */
    case REC20_IMPERIAL_GALLON_PER_MINUTE = 'G3';

    /**
     * millilitre per kelvin
     */
    case REC20_MILLILITRE_PER_KELVIN = 'G30';

    /**
     * kilogram per cubic centimetre
     */
    case REC20_KILOGRAM_PER_CUBIC_CENTIMETRE = 'G31';

    /**
     * ounce (avoirdupois) per cubic yard
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_CUBIC_YARD = 'G32';

    /**
     * gram per cubic centimetre kelvin
     */
    case REC20_GRAM_PER_CUBIC_CENTIMETRE_KELVIN = 'G33';

    /**
     * gram per cubic decimetre kelvin
     */
    case REC20_GRAM_PER_CUBIC_DECIMETRE_KELVIN = 'G34';

    /**
     * gram per litre kelvin
     */
    case REC20_GRAM_PER_LITRE_KELVIN = 'G35';

    /**
     * gram per cubic metre kelvin
     */
    case REC20_GRAM_PER_CUBIC_METRE_KELVIN = 'G36';

    /**
     * gram per millilitre kelvin
     */
    case REC20_GRAM_PER_MILLILITRE_KELVIN = 'G37';

    /**
     * kilogram per cubic centimetre kelvin
     */
    case REC20_KILOGRAM_PER_CUBIC_CENTIMETRE_KELVIN = 'G38';

    /**
     * kilogram per litre kelvin
     */
    case REC20_KILOGRAM_PER_LITRE_KELVIN = 'G39';

    /**
     * kilogram per cubic metre kelvin
     */
    case REC20_KILOGRAM_PER_CUBIC_METRE_KELVIN = 'G40';

    /**
     * square metre per second bar
     */
    case REC20_SQUARE_METRE_PER_SECOND_BAR = 'G41';

    /**
     * microsiemens per centimetre
     */
    case REC20_MICROSIEMENS_PER_CENTIMETRE = 'G42';

    /**
     * microsiemens per metre
     */
    case REC20_MICROSIEMENS_PER_METRE = 'G43';

    /**
     * nanosiemens per centimetre
     */
    case REC20_NANOSIEMENS_PER_CENTIMETRE = 'G44';

    /**
     * nanosiemens per metre
     */
    case REC20_NANOSIEMENS_PER_METRE = 'G45';

    /**
     * stokes per bar
     */
    case REC20_STOKES_PER_BAR = 'G46';

    /**
     * cubic centimetre per day
     */
    case REC20_CUBIC_CENTIMETRE_PER_DAY = 'G47';

    /**
     * cubic centimetre per hour
     */
    case REC20_CUBIC_CENTIMETRE_PER_HOUR = 'G48';

    /**
     * cubic centimetre per minute
     */
    case REC20_CUBIC_CENTIMETRE_PER_MINUTE = 'G49';

    /**
     * gallon (US) per hour
     */
    case REC20_GALLON_US_PER_HOUR = 'G50';

    /**
     * litre per second
     */
    case REC20_LITRE_PER_SECOND = 'G51';

    /**
     * cubic metre per day
     */
    case REC20_CUBIC_METRE_PER_DAY = 'G52';

    /**
     * cubic metre per minute
     */
    case REC20_CUBIC_METRE_PER_MINUTE = 'G53';

    /**
     * millilitre per day
     */
    case REC20_MILLILITRE_PER_DAY = 'G54';

    /**
     * millilitre per hour
     */
    case REC20_MILLILITRE_PER_HOUR = 'G55';

    /**
     * cubic inch per hour
     */
    case REC20_CUBIC_INCH_PER_HOUR = 'G56';

    /**
     * cubic inch per minute
     */
    case REC20_CUBIC_INCH_PER_MINUTE = 'G57';

    /**
     * cubic inch per second
     */
    case REC20_CUBIC_INCH_PER_SECOND = 'G58';

    /**
     * milliampere per litre minute
     */
    case REC20_MILLIAMPERE_PER_LITRE_MINUTE = 'G59';

    /**
     * volt per bar
     */
    case REC20_VOLT_PER_BAR = 'G60';

    /**
     * cubic centimetre per day kelvin
     */
    case REC20_CUBIC_CENTIMETRE_PER_DAY_KELVIN = 'G61';

    /**
     * cubic centimetre per hour kelvin
     */
    case REC20_CUBIC_CENTIMETRE_PER_HOUR_KELVIN = 'G62';

    /**
     * cubic centimetre per minute kelvin
     */
    case REC20_CUBIC_CENTIMETRE_PER_MINUTE_KELVIN = 'G63';

    /**
     * cubic centimetre per second kelvin
     */
    case REC20_CUBIC_CENTIMETRE_PER_SECOND_KELVIN = 'G64';

    /**
     * litre per day kelvin
     */
    case REC20_LITRE_PER_DAY_KELVIN = 'G65';

    /**
     * litre per hour kelvin
     */
    case REC20_LITRE_PER_HOUR_KELVIN = 'G66';

    /**
     * litre per minute kelvin
     */
    case REC20_LITRE_PER_MINUTE_KELVIN = 'G67';

    /**
     * litre per second kelvin
     */
    case REC20_LITRE_PER_SECOND_KELVIN = 'G68';

    /**
     * cubic metre per day kelvin
     */
    case REC20_CUBIC_METRE_PER_DAY_KELVIN = 'G69';

    /**
     * cubic metre per hour kelvin
     */
    case REC20_CUBIC_METRE_PER_HOUR_KELVIN = 'G70';

    /**
     * cubic metre per minute kelvin
     */
    case REC20_CUBIC_METRE_PER_MINUTE_KELVIN = 'G71';

    /**
     * cubic metre per second kelvin
     */
    case REC20_CUBIC_METRE_PER_SECOND_KELVIN = 'G72';

    /**
     * millilitre per day kelvin
     */
    case REC20_MILLILITRE_PER_DAY_KELVIN = 'G73';

    /**
     * millilitre per hour kelvin
     */
    case REC20_MILLILITRE_PER_HOUR_KELVIN = 'G74';

    /**
     * millilitre per minute kelvin
     */
    case REC20_MILLILITRE_PER_MINUTE_KELVIN = 'G75';

    /**
     * millilitre per second kelvin
     */
    case REC20_MILLILITRE_PER_SECOND_KELVIN = 'G76';

    /**
     * millimetre to the fourth power
     */
    case REC20_MILLIMETRE_TO_THE_FOURTH_POWER = 'G77';

    /**
     * cubic centimetre per day bar
     */
    case REC20_CUBIC_CENTIMETRE_PER_DAY_BAR = 'G78';

    /**
     * cubic centimetre per hour bar
     */
    case REC20_CUBIC_CENTIMETRE_PER_HOUR_BAR = 'G79';

    /**
     * cubic centimetre per minute bar
     */
    case REC20_CUBIC_CENTIMETRE_PER_MINUTE_BAR = 'G80';

    /**
     * cubic centimetre per second bar
     */
    case REC20_CUBIC_CENTIMETRE_PER_SECOND_BAR = 'G81';

    /**
     * litre per day bar
     */
    case REC20_LITRE_PER_DAY_BAR = 'G82';

    /**
     * litre per hour bar
     */
    case REC20_LITRE_PER_HOUR_BAR = 'G83';

    /**
     * litre per minute bar
     */
    case REC20_LITRE_PER_MINUTE_BAR = 'G84';

    /**
     * litre per second bar
     */
    case REC20_LITRE_PER_SECOND_BAR = 'G85';

    /**
     * cubic metre per day bar
     */
    case REC20_CUBIC_METRE_PER_DAY_BAR = 'G86';

    /**
     * cubic metre per hour bar
     */
    case REC20_CUBIC_METRE_PER_HOUR_BAR = 'G87';

    /**
     * cubic metre per minute bar
     */
    case REC20_CUBIC_METRE_PER_MINUTE_BAR = 'G88';

    /**
     * cubic metre per second bar
     */
    case REC20_CUBIC_METRE_PER_SECOND_BAR = 'G89';

    /**
     * millilitre per day bar
     */
    case REC20_MILLILITRE_PER_DAY_BAR = 'G90';

    /**
     * millilitre per hour bar
     */
    case REC20_MILLILITRE_PER_HOUR_BAR = 'G91';

    /**
     * millilitre per minute bar
     */
    case REC20_MILLILITRE_PER_MINUTE_BAR = 'G92';

    /**
     * millilitre per second bar
     */
    case REC20_MILLILITRE_PER_SECOND_BAR = 'G93';

    /**
     * cubic centimetre per bar
     */
    case REC20_CUBIC_CENTIMETRE_PER_BAR = 'G94';

    /**
     * litre per bar
     */
    case REC20_LITRE_PER_BAR = 'G95';

    /**
     * cubic metre per bar
     */
    case REC20_CUBIC_METRE_PER_BAR = 'G96';

    /**
     * millilitre per bar
     */
    case REC20_MILLILITRE_PER_BAR = 'G97';

    /**
     * microhenry per kiloohm
     */
    case REC20_MICROHENRY_PER_KILOOHM = 'G98';

    /**
     * microhenry per ohm
     */
    case REC20_MICROHENRY_PER_OHM = 'G99';

    /**
     * gallon (US) per day
     */
    case REC20_GALLON_US_PER_DAY = 'GB';

    /**
     * gigabecquerel
     */
    case REC20_GIGABECQUEREL = 'GBQ';

    /**
     * gram, dry weight
     */
    case REC20_GRAM_DRY_WEIGHT = 'GDW';

    /**
     * pound per gallon (US)
     */
    case REC20_POUND_PER_GALLON_US = 'GE';

    /**
     * gram per metre (gram per 100 centimetres)
     */
    case REC20_GRAM_PER_METRE_GRAM_PER_100_CENTIMETRES = 'GF';

    /**
     * gram of fissile isotope
     */
    case REC20_GRAM_OF_FISSILE_ISOTOPE = 'GFI';

    /**
     * great gross
     */
    case REC20_GREAT_GROSS = 'GGR';

    /**
     * gill (US)
     */
    case REC20_GILL_US = 'GIA';

    /**
     * gram, including container
     */
    case REC20_GRAM_INCLUDING_CONTAINER = 'GIC';

    /**
     * gill (UK)
     */
    case REC20_GILL_UK = 'GII';

    /**
     * gram, including inner packaging
     */
    case REC20_GRAM_INCLUDING_INNER_PACKAGING = 'GIP';

    /**
     * gram per millilitre
     */
    case REC20_GRAM_PER_MILLILITRE = 'GJ';

    /**
     * gram per litre
     */
    case REC20_GRAM_PER_LITRE = 'GL';

    /**
     * dry gallon (US)
     */
    case REC20_DRY_GALLON_US = 'GLD';

    /**
     * gallon (UK)
     */
    case REC20_GALLON_UK = 'GLI';

    /**
     * gallon (US)
     */
    case REC20_GALLON_US = 'GLL';

    /**
     * gram per square metre
     */
    case REC20_GRAM_PER_SQUARE_METRE = 'GM';

    /**
     * milligram per square metre
     */
    case REC20_MILLIGRAM_PER_SQUARE_METRE = 'GO';

    /**
     * milligram per cubic metre
     */
    case REC20_MILLIGRAM_PER_CUBIC_METRE = 'GP';

    /**
     * microgram per cubic metre
     */
    case REC20_MICROGRAM_PER_CUBIC_METRE = 'GQ';

    /**
     * gram
     */
    case REC20_GRAM = 'GRM';

    /**
     * grain
     */
    case REC20_GRAIN = 'GRN';

    /**
     * gross
     */
    case REC20_GROSS = 'GRO';

    /**
     * gigajoule
     */
    case REC20_GIGAJOULE = 'GV';

    /**
     * gigawatt hour
     */
    case REC20_GIGAWATT_HOUR = 'GWH';

    /**
     * henry per kiloohm
     */
    case REC20_HENRY_PER_KILOOHM = 'H03';

    /**
     * henry per ohm
     */
    case REC20_HENRY_PER_OHM = 'H04';

    /**
     * millihenry per kiloohm
     */
    case REC20_MILLIHENRY_PER_KILOOHM = 'H05';

    /**
     * millihenry per ohm
     */
    case REC20_MILLIHENRY_PER_OHM = 'H06';

    /**
     * pascal second per bar
     */
    case REC20_PASCAL_SECOND_PER_BAR = 'H07';

    /**
     * microbecquerel
     */
    case REC20_MICROBECQUEREL = 'H08';

    /**
     * reciprocal year
     */
    case REC20_RECIPROCAL_YEAR = 'H09';

    /**
     * reciprocal hour
     */
    case REC20_RECIPROCAL_HOUR = 'H10';

    /**
     * reciprocal month
     */
    case REC20_RECIPROCAL_MONTH = 'H11';

    /**
     * degree Celsius per hour
     */
    case REC20_DEGREE_CELSIUS_PER_HOUR = 'H12';

    /**
     * degree Celsius per minute
     */
    case REC20_DEGREE_CELSIUS_PER_MINUTE = 'H13';

    /**
     * degree Celsius per second
     */
    case REC20_DEGREE_CELSIUS_PER_SECOND = 'H14';

    /**
     * square centimetre per gram
     */
    case REC20_SQUARE_CENTIMETRE_PER_GRAM = 'H15';

    /**
     * square decametre
     */
    case REC20_SQUARE_DECAMETRE = 'H16';

    /**
     * square hectometre
     */
    case REC20_SQUARE_HECTOMETRE = 'H18';

    /**
     * cubic hectometre
     */
    case REC20_CUBIC_HECTOMETRE = 'H19';

    /**
     * cubic kilometre
     */
    case REC20_CUBIC_KILOMETRE = 'H20';

    /**
     * blank
     */
    case REC20_BLANK = 'H21';

    /**
     * volt square inch per pound-force
     */
    case REC20_VOLT_SQUARE_INCH_PER_POUNDFORCE = 'H22';

    /**
     * volt per inch
     */
    case REC20_VOLT_PER_INCH = 'H23';

    /**
     * volt per microsecond
     */
    case REC20_VOLT_PER_MICROSECOND = 'H24';

    /**
     * percent per kelvin
     */
    case REC20_PERCENT_PER_KELVIN = 'H25';

    /**
     * ohm per metre
     */
    case REC20_OHM_PER_METRE = 'H26';

    /**
     * degree per metre
     */
    case REC20_DEGREE_PER_METRE = 'H27';

    /**
     * microfarad per kilometre
     */
    case REC20_MICROFARAD_PER_KILOMETRE = 'H28';

    /**
     * microgram per litre
     */
    case REC20_MICROGRAM_PER_LITRE = 'H29';

    /**
     * square micrometre (square micron)
     */
    case REC20_SQUARE_MICROMETRE_SQUARE_MICRON = 'H30';

    /**
     * ampere per kilogram
     */
    case REC20_AMPERE_PER_KILOGRAM = 'H31';

    /**
     * ampere squared second
     */
    case REC20_AMPERE_SQUARED_SECOND = 'H32';

    /**
     * farad per kilometre
     */
    case REC20_FARAD_PER_KILOMETRE = 'H33';

    /**
     * hertz metre
     */
    case REC20_HERTZ_METRE = 'H34';

    /**
     * kelvin metre per watt
     */
    case REC20_KELVIN_METRE_PER_WATT = 'H35';

    /**
     * megaohm per kilometre
     */
    case REC20_MEGAOHM_PER_KILOMETRE = 'H36';

    /**
     * megaohm per metre
     */
    case REC20_MEGAOHM_PER_METRE = 'H37';

    /**
     * megaampere
     */
    case REC20_MEGAAMPERE = 'H38';

    /**
     * megahertz kilometre
     */
    case REC20_MEGAHERTZ_KILOMETRE = 'H39';

    /**
     * newton per ampere
     */
    case REC20_NEWTON_PER_AMPERE = 'H40';

    /**
     * newton metre watt to the power minus 0,5
     */
    case REC20_NEWTON_METRE_WATT_TO_THE_POWER_MINUS_05 = 'H41';

    /**
     * pascal per metre
     */
    case REC20_PASCAL_PER_METRE = 'H42';

    /**
     * siemens per centimetre
     */
    case REC20_SIEMENS_PER_CENTIMETRE = 'H43';

    /**
     * teraohm
     */
    case REC20_TERAOHM = 'H44';

    /**
     * volt second per metre
     */
    case REC20_VOLT_SECOND_PER_METRE = 'H45';

    /**
     * volt per second
     */
    case REC20_VOLT_PER_SECOND = 'H46';

    /**
     * watt per cubic metre
     */
    case REC20_WATT_PER_CUBIC_METRE = 'H47';

    /**
     * attofarad
     */
    case REC20_ATTOFARAD = 'H48';

    /**
     * centimetre per hour
     */
    case REC20_CENTIMETRE_PER_HOUR = 'H49';

    /**
     * reciprocal cubic centimetre
     */
    case REC20_RECIPROCAL_CUBIC_CENTIMETRE = 'H50';

    /**
     * decibel per kilometre
     */
    case REC20_DECIBEL_PER_KILOMETRE = 'H51';

    /**
     * decibel per metre
     */
    case REC20_DECIBEL_PER_METRE = 'H52';

    /**
     * kilogram per bar
     */
    case REC20_KILOGRAM_PER_BAR = 'H53';

    /**
     * kilogram per cubic decimetre kelvin
     */
    case REC20_KILOGRAM_PER_CUBIC_DECIMETRE_KELVIN = 'H54';

    /**
     * kilogram per cubic decimetre bar
     */
    case REC20_KILOGRAM_PER_CUBIC_DECIMETRE_BAR = 'H55';

    /**
     * kilogram per square metre second
     */
    case REC20_KILOGRAM_PER_SQUARE_METRE_SECOND = 'H56';

    /**
     * inch per two pi radiant
     */
    case REC20_INCH_PER_TWO_PI_RADIANT = 'H57';

    /**
     * metre per volt second
     */
    case REC20_METRE_PER_VOLT_SECOND = 'H58';

    /**
     * square metre per newton
     */
    case REC20_SQUARE_METRE_PER_NEWTON = 'H59';

    /**
     * cubic metre per cubic metre
     */
    case REC20_CUBIC_METRE_PER_CUBIC_METRE = 'H60';

    /**
     * millisiemens per centimetre
     */
    case REC20_MILLISIEMENS_PER_CENTIMETRE = 'H61';

    /**
     * millivolt per minute
     */
    case REC20_MILLIVOLT_PER_MINUTE = 'H62';

    /**
     * milligram per square centimetre
     */
    case REC20_MILLIGRAM_PER_SQUARE_CENTIMETRE = 'H63';

    /**
     * milligram per gram
     */
    case REC20_MILLIGRAM_PER_GRAM = 'H64';

    /**
     * millilitre per cubic metre
     */
    case REC20_MILLILITRE_PER_CUBIC_METRE = 'H65';

    /**
     * millimetre per year
     */
    case REC20_MILLIMETRE_PER_YEAR = 'H66';

    /**
     * millimetre per hour
     */
    case REC20_MILLIMETRE_PER_HOUR = 'H67';

    /**
     * millimole per gram
     */
    case REC20_MILLIMOLE_PER_GRAM = 'H68';

    /**
     * picopascal per kilometre
     */
    case REC20_PICOPASCAL_PER_KILOMETRE = 'H69';

    /**
     * picosecond
     */
    case REC20_PICOSECOND = 'H70';

    /**
     * percent per month
     */
    case REC20_PERCENT_PER_MONTH = 'H71';

    /**
     * percent per hectobar
     */
    case REC20_PERCENT_PER_HECTOBAR = 'H72';

    /**
     * percent per decakelvin
     */
    case REC20_PERCENT_PER_DECAKELVIN = 'H73';

    /**
     * watt per metre
     */
    case REC20_WATT_PER_METRE = 'H74';

    /**
     * decapascal
     */
    case REC20_DECAPASCAL = 'H75';

    /**
     * gram per millimetre
     */
    case REC20_GRAM_PER_MILLIMETRE = 'H76';

    /**
     * module width
     */
    case REC20_MODULE_WIDTH = 'H77';

    /**
     * French gauge
     */
    case REC20_FRENCH_GAUGE = 'H79';

    /**
     * rack unit
     */
    case REC20_RACK_UNIT = 'H80';

    /**
     * millimetre per minute
     */
    case REC20_MILLIMETRE_PER_MINUTE = 'H81';

    /**
     * big point
     */
    case REC20_BIG_POINT = 'H82';

    /**
     * litre per kilogram
     */
    case REC20_LITRE_PER_KILOGRAM = 'H83';

    /**
     * gram millimetre
     */
    case REC20_GRAM_MILLIMETRE = 'H84';

    /**
     * reciprocal week
     */
    case REC20_RECIPROCAL_WEEK = 'H85';

    /**
     * piece
     */
    case REC20_PIECE = 'H87';

    /**
     * megaohm kilometre
     */
    case REC20_MEGAOHM_KILOMETRE = 'H88';

    /**
     * percent per ohm
     */
    case REC20_PERCENT_PER_OHM = 'H89';

    /**
     * percent per degree
     */
    case REC20_PERCENT_PER_DEGREE = 'H90';

    /**
     * percent per ten thousand
     */
    case REC20_PERCENT_PER_TEN_THOUSAND = 'H91';

    /**
     * percent per one hundred thousand
     */
    case REC20_PERCENT_PER_ONE_HUNDRED_THOUSAND = 'H92';

    /**
     * percent per hundred
     */
    case REC20_PERCENT_PER_HUNDRED = 'H93';

    /**
     * percent per thousand
     */
    case REC20_PERCENT_PER_THOUSAND = 'H94';

    /**
     * percent per volt
     */
    case REC20_PERCENT_PER_VOLT = 'H95';

    /**
     * percent per bar
     */
    case REC20_PERCENT_PER_BAR = 'H96';

    /**
     * percent per inch
     */
    case REC20_PERCENT_PER_INCH = 'H98';

    /**
     * percent per metre
     */
    case REC20_PERCENT_PER_METRE = 'H99';

    /**
     * hank
     */
    case REC20_HANK = 'HA';

    /**
     * hectobar
     */
    case REC20_HECTOBAR = 'HBA';

    /**
     * hundred boxes
     */
    case REC20_HUNDRED_BOXES = 'HBX';

    /**
     * hundred count
     */
    case REC20_HUNDRED_COUNT = 'HC';

    /**
     * hundred kilogram, dry weight
     */
    case REC20_HUNDRED_KILOGRAM_DRY_WEIGHT = 'HDW';

    /**
     * head
     */
    case REC20_HEAD = 'HEA';

    /**
     * hectogram
     */
    case REC20_HECTOGRAM = 'HGM';

    /**
     * hundred cubic foot
     */
    case REC20_HUNDRED_CUBIC_FOOT = 'HH';

    /**
     * hundred international unit
     */
    case REC20_HUNDRED_INTERNATIONAL_UNIT = 'HIU';

    /**
     * hundred kilogram, net mass
     */
    case REC20_HUNDRED_KILOGRAM_NET_MASS = 'HKM';

    /**
     * hectolitre
     */
    case REC20_HECTOLITRE = 'HLT';

    /**
     * mile per hour (statute mile)
     */
    case REC20_MILE_PER_HOUR_STATUTE_MILE = 'HM';

    /**
     * million cubic metre
     */
    case REC20_MILLION_CUBIC_METRE = 'HMQ';

    /**
     * hectometre
     */
    case REC20_HECTOMETRE = 'HMT';

    /**
     * hectolitre of pure alcohol
     */
    case REC20_HECTOLITRE_OF_PURE_ALCOHOL = 'HPA';

    /**
     * hertz
     */
    case REC20_HERTZ = 'HTZ';

    /**
     * hour
     */
    case REC20_HOUR = 'HUR';

    /**
     * inch pound (pound inch)
     */
    case REC20_INCH_POUND_POUND_INCH = 'IA';

    /**
     * person
     */
    case REC20_PERSON = 'IE';

    /**
     * inch
     */
    case REC20_INCH = 'INH';

    /**
     * square inch
     */
    case REC20_SQUARE_INCH = 'INK';

    /**
     * cubic inch
     */
    case REC20_CUBIC_INCH = 'INQ';

    /**
     * international sugar degree
     */
    case REC20_INTERNATIONAL_SUGAR_DEGREE = 'ISD';

    /**
     * inch per second
     */
    case REC20_INCH_PER_SECOND = 'IU';

    /**
     * international unit per gram
     */
    case REC20_INTERNATIONAL_UNIT_PER_GRAM = 'IUG';

    /**
     * inch per second squared
     */
    case REC20_INCH_PER_SECOND_SQUARED = 'IV';

    /**
     * percent per millimetre
     */
    case REC20_PERCENT_PER_MILLIMETRE = 'J10';

    /**
     * per mille per psi
     */
    case REC20_PER_MILLE_PER_PSI = 'J12';

    /**
     * degree API
     */
    case REC20_DEGREE_API = 'J13';

    /**
     * degree Baume (origin scale)
     */
    case REC20_DEGREE_BAUME_ORIGIN_SCALE = 'J14';

    /**
     * degree Baume (US heavy)
     */
    case REC20_DEGREE_BAUME_US_HEAVY = 'J15';

    /**
     * degree Baume (US light)
     */
    case REC20_DEGREE_BAUME_US_LIGHT = 'J16';

    /**
     * degree Balling
     */
    case REC20_DEGREE_BALLING = 'J17';

    /**
     * degree Brix
     */
    case REC20_DEGREE_BRIX = 'J18';

    /**
     * degree Fahrenheit hour square foot per British thermal unit
     * (thermochemical)
     */
    case REC20_DEGREE_FAHRENHEIT_HOUR_SQUARE_FOOT_PER_BRITISH_THERMAL_UNIT_THERMOCHEMICAL = 'J19';

    /**
     * joule per kilogram
     */
    case REC20_JOULE_PER_KILOGRAM = 'J2';

    /**
     * degree Fahrenheit per kelvin
     */
    case REC20_DEGREE_FAHRENHEIT_PER_KELVIN = 'J20';

    /**
     * degree Fahrenheit per bar
     */
    case REC20_DEGREE_FAHRENHEIT_PER_BAR = 'J21';

    /**
     * degree Fahrenheit hour square foot per British thermal unit
     * (international table)
     */
    case REC20_DEGREE_FAHRENHEIT_HOUR_SQUARE_FOOT_PER_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE = 'J22';

    /**
     * degree Fahrenheit per hour
     */
    case REC20_DEGREE_FAHRENHEIT_PER_HOUR = 'J23';

    /**
     * degree Fahrenheit per minute
     */
    case REC20_DEGREE_FAHRENHEIT_PER_MINUTE = 'J24';

    /**
     * degree Fahrenheit per second
     */
    case REC20_DEGREE_FAHRENHEIT_PER_SECOND = 'J25';

    /**
     * reciprocal degree Fahrenheit
     */
    case REC20_RECIPROCAL_DEGREE_FAHRENHEIT = 'J26';

    /**
     * degree Oechsle
     */
    case REC20_DEGREE_OECHSLE = 'J27';

    /**
     * degree Rankine per hour
     */
    case REC20_DEGREE_RANKINE_PER_HOUR = 'J28';

    /**
     * degree Rankine per minute
     */
    case REC20_DEGREE_RANKINE_PER_MINUTE = 'J29';

    /**
     * degree Rankine per second
     */
    case REC20_DEGREE_RANKINE_PER_SECOND = 'J30';

    /**
     * degree Twaddell
     */
    case REC20_DEGREE_TWADDELL = 'J31';

    /**
     * micropoise
     */
    case REC20_MICROPOISE = 'J32';

    /**
     * microgram per kilogram
     */
    case REC20_MICROGRAM_PER_KILOGRAM = 'J33';

    /**
     * microgram per cubic metre kelvin
     */
    case REC20_MICROGRAM_PER_CUBIC_METRE_KELVIN = 'J34';

    /**
     * microgram per cubic metre bar
     */
    case REC20_MICROGRAM_PER_CUBIC_METRE_BAR = 'J35';

    /**
     * microlitre per litre
     */
    case REC20_MICROLITRE_PER_LITRE = 'J36';

    /**
     * baud
     */
    case REC20_BAUD = 'J38';

    /**
     * British thermal unit (mean)
     */
    case REC20_BRITISH_THERMAL_UNIT_MEAN = 'J39';

    /**
     * British thermal unit (international table) foot per hour square foot
     * degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_FOOT_PER_HOURSQUARE_FOOT_DEGREE_FAHRENHEIT = 'J40';

    /**
     * British thermal unit (international table) inch per hour square foot
     * degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_INCH_PER_HOUR_SQUAREFOOT_DEGREE_FAHRENHEIT = 'J41';

    /**
     * British thermal unit (international table) inch per second
     * square foot degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_INCH_PER_SECOND_SQUAREFOOT_DEGREE_FAHRENHEIT = 'J42';

    /**
     * British thermal unit (international table) per pound degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_POUND_DEGREE_FAHRENHEIT = 'J43';

    /**
     * British thermal unit (international table) per minute
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_MINUTE = 'J44';

    /**
     * British thermal unit (international table) per second
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SECOND = 'J45';

    /**
     * British thermal unit (thermochemical) foot per hour square foot
     * degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_FOOT_PER_HOUR_SQUAREFOOT_DEGREE_FAHRENHEIT = 'J46';

    /**
     * British thermal unit (thermochemical) per hour
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_HOUR = 'J47';

    /**
     * British thermal unit (thermochemical) inch per hour square foot
     * degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_INCH_PER_HOUR_SQUAREFOOT_DEGREE_FAHRENHEIT = 'J48';

    /**
     * British thermal unit (thermochemical) inch per second square foot
     * degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_INCH_PER_SECONDSQUARE_FOOT_DEGREE_FAHRENHEIT = 'J49';

    /**
     * British thermal unit (thermochemical) per pound degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_POUND_DEGREE_FAHRENHEIT = 'J50';

    /**
     * British thermal unit (thermochemical) per minute
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_MINUTE = 'J51';

    /**
     * British thermal unit (thermochemical) per second
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_SECOND = 'J52';

    /**
     * coulomb square metre per kilogram
     */
    case REC20_COULOMB_SQUARE_METRE_PER_KILOGRAM = 'J53';

    /**
     * megabaud
     */
    case REC20_MEGABAUD = 'J54';

    /**
     * watt second
     */
    case REC20_WATT_SECOND = 'J55';

    /**
     * bar per bar
     */
    case REC20_BAR_PER_BAR = 'J56';

    /**
     * barrel (UK petroleum)
     */
    case REC20_BARREL_UK_PETROLEUM = 'J57';

    /**
     * barrel (UK petroleum) per minute
     */
    case REC20_BARREL_UK_PETROLEUM_PER_MINUTE = 'J58';

    /**
     * barrel (UK petroleum) per day
     */
    case REC20_BARREL_UK_PETROLEUM_PER_DAY = 'J59';

    /**
     * barrel (UK petroleum) per hour
     */
    case REC20_BARREL_UK_PETROLEUM_PER_HOUR = 'J60';

    /**
     * barrel (UK petroleum) per second
     */
    case REC20_BARREL_UK_PETROLEUM_PER_SECOND = 'J61';

    /**
     * barrel (US petroleum) per hour
     */
    case REC20_BARREL_US_PETROLEUM_PER_HOUR = 'J62';

    /**
     * barrel (US petroleum) per second
     */
    case REC20_BARREL_US_PETROLEUM_PER_SECOND = 'J63';

    /**
     * bushel (UK) per day
     */
    case REC20_BUSHEL_UK_PER_DAY = 'J64';

    /**
     * bushel (UK) per hour
     */
    case REC20_BUSHEL_UK_PER_HOUR = 'J65';

    /**
     * bushel (UK) per minute
     */
    case REC20_BUSHEL_UK_PER_MINUTE = 'J66';

    /**
     * bushel (UK) per second
     */
    case REC20_BUSHEL_UK_PER_SECOND = 'J67';

    /**
     * bushel (US dry) per day
     */
    case REC20_BUSHEL_US_DRY_PER_DAY = 'J68';

    /**
     * bushel (US dry) per hour
     */
    case REC20_BUSHEL_US_DRY_PER_HOUR = 'J69';

    /**
     * bushel (US dry) per minute
     */
    case REC20_BUSHEL_US_DRY_PER_MINUTE = 'J70';

    /**
     * bushel (US dry) per second
     */
    case REC20_BUSHEL_US_DRY_PER_SECOND = 'J71';

    /**
     * centinewton metre
     */
    case REC20_CENTINEWTON_METRE = 'J72';

    /**
     * centipoise per kelvin
     */
    case REC20_CENTIPOISE_PER_KELVIN = 'J73';

    /**
     * centipoise per bar
     */
    case REC20_CENTIPOISE_PER_BAR = 'J74';

    /**
     * calorie (mean)
     */
    case REC20_CALORIE_MEAN = 'J75';

    /**
     * calorie (international table) per gram degree Celsius
     */
    case REC20_CALORIE_INTERNATIONAL_TABLE_PER_GRAM_DEGREE_CELSIUS = 'J76';

    /**
     * calorie (thermochemical) per centimetre second degree Celsius
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_CENTIMETRE_SECOND_DEGREE_CELSIUS = 'J78';

    /**
     * calorie (thermochemical) per gram degree Celsius
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_GRAM_DEGREE_CELSIUS = 'J79';

    /**
     * calorie (thermochemical) per minute
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_MINUTE = 'J81';

    /**
     * calorie (thermochemical) per second
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_SECOND = 'J82';

    /**
     * clo
     */
    case REC20_CLO = 'J83';

    /**
     * centimetre per second kelvin
     */
    case REC20_CENTIMETRE_PER_SECOND_KELVIN = 'J84';

    /**
     * centimetre per second bar
     */
    case REC20_CENTIMETRE_PER_SECOND_BAR = 'J85';

    /**
     * cubic centimetre per cubic metre
     */
    case REC20_CUBIC_CENTIMETRE_PER_CUBIC_METRE = 'J87';

    /**
     * cubic decimetre per day
     */
    case REC20_CUBIC_DECIMETRE_PER_DAY = 'J90';

    /**
     * cubic decimetre per cubic metre
     */
    case REC20_CUBIC_DECIMETRE_PER_CUBIC_METRE = 'J91';

    /**
     * cubic decimetre per minute
     */
    case REC20_CUBIC_DECIMETRE_PER_MINUTE = 'J92';

    /**
     * cubic decimetre per second
     */
    case REC20_CUBIC_DECIMETRE_PER_SECOND = 'J93';

    /**
     * ounce (UK fluid) per day
     */
    case REC20_OUNCE_UK_FLUID_PER_DAY = 'J95';

    /**
     * ounce (UK fluid) per hour
     */
    case REC20_OUNCE_UK_FLUID_PER_HOUR = 'J96';

    /**
     * ounce (UK fluid) per minute
     */
    case REC20_OUNCE_UK_FLUID_PER_MINUTE = 'J97';

    /**
     * ounce (UK fluid) per second
     */
    case REC20_OUNCE_UK_FLUID_PER_SECOND = 'J98';

    /**
     * ounce (US fluid) per day
     */
    case REC20_OUNCE_US_FLUID_PER_DAY = 'J99';

    /**
     * joule per kelvin
     */
    case REC20_JOULE_PER_KELVIN = 'JE';

    /**
     * megajoule per kilogram
     */
    case REC20_MEGAJOULE_PER_KILOGRAM = 'JK';

    /**
     * megajoule per cubic metre
     */
    case REC20_MEGAJOULE_PER_CUBIC_METRE = 'JM';

    /**
     * pipeline joint
     */
    case REC20_PIPELINE_JOINT = 'JNT';

    /**
     * joule
     */
    case REC20_JOULE = 'JOU';

    /**
     * hundred metre
     */
    case REC20_HUNDRED_METRE = 'JPS';

    /**
     * number of jewels
     */
    case REC20_NUMBER_OF_JEWELS = 'JWL';

    /**
     * kilowatt demand
     */
    case REC20_KILOWATT_DEMAND = 'K1';

    /**
     * ounce (US fluid) per hour
     */
    case REC20_OUNCE_US_FLUID_PER_HOUR = 'K10';

    /**
     * ounce (US fluid) per minute
     */
    case REC20_OUNCE_US_FLUID_PER_MINUTE = 'K11';

    /**
     * ounce (US fluid) per second
     */
    case REC20_OUNCE_US_FLUID_PER_SECOND = 'K12';

    /**
     * foot per degree Fahrenheit
     */
    case REC20_FOOT_PER_DEGREE_FAHRENHEIT = 'K13';

    /**
     * foot per hour
     */
    case REC20_FOOT_PER_HOUR = 'K14';

    /**
     * foot pound-force per hour
     */
    case REC20_FOOT_POUNDFORCE_PER_HOUR = 'K15';

    /**
     * foot pound-force per minute
     */
    case REC20_FOOT_POUNDFORCE_PER_MINUTE = 'K16';

    /**
     * foot per psi
     */
    case REC20_FOOT_PER_PSI = 'K17';

    /**
     * foot per second degree Fahrenheit
     */
    case REC20_FOOT_PER_SECOND_DEGREE_FAHRENHEIT = 'K18';

    /**
     * foot per second psi
     */
    case REC20_FOOT_PER_SECOND_PSI = 'K19';

    /**
     * kilovolt ampere reactive demand
     */
    case REC20_KILOVOLT_AMPERE_REACTIVE_DEMAND = 'K2';

    /**
     * reciprocal cubic foot
     */
    case REC20_RECIPROCAL_CUBIC_FOOT = 'K20';

    /**
     * cubic foot per degree Fahrenheit
     */
    case REC20_CUBIC_FOOT_PER_DEGREE_FAHRENHEIT = 'K21';

    /**
     * cubic foot per day
     */
    case REC20_CUBIC_FOOT_PER_DAY = 'K22';

    /**
     * cubic foot per psi
     */
    case REC20_CUBIC_FOOT_PER_PSI = 'K23';

    /**
     * gallon (UK) per day
     */
    case REC20_GALLON_UK_PER_DAY = 'K26';

    /**
     * gallon (UK) per hour
     */
    case REC20_GALLON_UK_PER_HOUR = 'K27';

    /**
     * gallon (UK) per second
     */
    case REC20_GALLON_UK_PER_SECOND = 'K28';

    /**
     * kilovolt ampere reactive hour
     */
    case REC20_KILOVOLT_AMPERE_REACTIVE_HOUR = 'K3';

    /**
     * gallon (US liquid) per second
     */
    case REC20_GALLON_US_LIQUID_PER_SECOND = 'K30';

    /**
     * gram-force per square centimetre
     */
    case REC20_GRAMFORCE_PER_SQUARE_CENTIMETRE = 'K31';

    /**
     * gill (UK) per day
     */
    case REC20_GILL_UK_PER_DAY = 'K32';

    /**
     * gill (UK) per hour
     */
    case REC20_GILL_UK_PER_HOUR = 'K33';

    /**
     * gill (UK) per minute
     */
    case REC20_GILL_UK_PER_MINUTE = 'K34';

    /**
     * gill (UK) per second
     */
    case REC20_GILL_UK_PER_SECOND = 'K35';

    /**
     * gill (US) per day
     */
    case REC20_GILL_US_PER_DAY = 'K36';

    /**
     * gill (US) per hour
     */
    case REC20_GILL_US_PER_HOUR = 'K37';

    /**
     * gill (US) per minute
     */
    case REC20_GILL_US_PER_MINUTE = 'K38';

    /**
     * gill (US) per second
     */
    case REC20_GILL_US_PER_SECOND = 'K39';

    /**
     * standard acceleration of free fall
     */
    case REC20_STANDARD_ACCELERATION_OF_FREE_FALL = 'K40';

    /**
     * grain per gallon (US)
     */
    case REC20_GRAIN_PER_GALLON_US = 'K41';

    /**
     * horsepower (boiler)
     */
    case REC20_HORSEPOWER_BOILER = 'K42';

    /**
     * horsepower (electric)
     */
    case REC20_HORSEPOWER_ELECTRIC = 'K43';

    /**
     * inch per degree Fahrenheit
     */
    case REC20_INCH_PER_DEGREE_FAHRENHEIT = 'K45';

    /**
     * inch per psi
     */
    case REC20_INCH_PER_PSI = 'K46';

    /**
     * inch per second degree Fahrenheit
     */
    case REC20_INCH_PER_SECOND_DEGREE_FAHRENHEIT = 'K47';

    /**
     * inch per second psi
     */
    case REC20_INCH_PER_SECOND_PSI = 'K48';

    /**
     * reciprocal cubic inch
     */
    case REC20_RECIPROCAL_CUBIC_INCH = 'K49';

    /**
     * kilobaud
     */
    case REC20_KILOBAUD = 'K50';

    /**
     * kilocalorie (mean)
     */
    case REC20_KILOCALORIE_MEAN = 'K51';

    /**
     * kilocalorie (international table) per hour metre degree Celsius
     */
    case REC20_KILOCALORIE_INTERNATIONAL_TABLE_PER_HOUR_METRE_DEGREE_CELSIUS = 'K52';

    /**
     * kilocalorie (thermochemical)
     */
    case REC20_KILOCALORIE_THERMOCHEMICAL = 'K53';

    /**
     * kilocalorie (thermochemical) per minute
     */
    case REC20_KILOCALORIE_THERMOCHEMICAL_PER_MINUTE = 'K54';

    /**
     * kilocalorie (thermochemical) per second
     */
    case REC20_KILOCALORIE_THERMOCHEMICAL_PER_SECOND = 'K55';

    /**
     * kilomole per hour
     */
    case REC20_KILOMOLE_PER_HOUR = 'K58';

    /**
     * kilomole per cubic metre kelvin
     */
    case REC20_KILOMOLE_PER_CUBIC_METRE_KELVIN = 'K59';

    /**
     * kilolitre
     */
    case REC20_KILOLITRE = 'K6';

    /**
     * kilomole per cubic metre bar
     */
    case REC20_KILOMOLE_PER_CUBIC_METRE_BAR = 'K60';

    /**
     * kilomole per minute
     */
    case REC20_KILOMOLE_PER_MINUTE = 'K61';

    /**
     * litre per litre
     */
    case REC20_LITRE_PER_LITRE = 'K62';

    /**
     * reciprocal litre
     */
    case REC20_RECIPROCAL_LITRE = 'K63';

    /**
     * pound (avoirdupois) per degree Fahrenheit
     */
    case REC20_POUND_AVOIRDUPOIS_PER_DEGREE_FAHRENHEIT = 'K64';

    /**
     * pound (avoirdupois) square foot
     */
    case REC20_POUND_AVOIRDUPOIS_SQUARE_FOOT = 'K65';

    /**
     * pound (avoirdupois) per day
     */
    case REC20_POUND_AVOIRDUPOIS_PER_DAY = 'K66';

    /**
     * pound per foot hour
     */
    case REC20_POUND_PER_FOOT_HOUR = 'K67';

    /**
     * pound per foot second
     */
    case REC20_POUND_PER_FOOT_SECOND = 'K68';

    /**
     * pound (avoirdupois) per cubic foot degree Fahrenheit
     */
    case REC20_POUND_AVOIRDUPOIS_PER_CUBIC_FOOT_DEGREE_FAHRENHEIT = 'K69';

    /**
     * pound (avoirdupois) per cubic foot psi
     */
    case REC20_POUND_AVOIRDUPOIS_PER_CUBIC_FOOT_PSI = 'K70';

    /**
     * pound (avoirdupois) per gallon (UK)
     */
    case REC20_POUND_AVOIRDUPOIS_PER_GALLON_UK = 'K71';

    /**
     * pound (avoirdupois) per hour degree Fahrenheit
     */
    case REC20_POUND_AVOIRDUPOIS_PER_HOUR_DEGREE_FAHRENHEIT = 'K73';

    /**
     * pound (avoirdupois) per hour psi
     */
    case REC20_POUND_AVOIRDUPOIS_PER_HOUR_PSI = 'K74';

    /**
     * pound (avoirdupois) per cubic inch degree Fahrenheit
     */
    case REC20_POUND_AVOIRDUPOIS_PER_CUBIC_INCH_DEGREE_FAHRENHEIT = 'K75';

    /**
     * pound (avoirdupois) per cubic inch psi
     */
    case REC20_POUND_AVOIRDUPOIS_PER_CUBIC_INCH_PSI = 'K76';

    /**
     * pound (avoirdupois) per psi
     */
    case REC20_POUND_AVOIRDUPOIS_PER_PSI = 'K77';

    /**
     * pound (avoirdupois) per minute
     */
    case REC20_POUND_AVOIRDUPOIS_PER_MINUTE = 'K78';

    /**
     * pound (avoirdupois) per minute degree Fahrenheit
     */
    case REC20_POUND_AVOIRDUPOIS_PER_MINUTE_DEGREE_FAHRENHEIT = 'K79';

    /**
     * pound (avoirdupois) per minute psi
     */
    case REC20_POUND_AVOIRDUPOIS_PER_MINUTE_PSI = 'K80';

    /**
     * pound (avoirdupois) per second
     */
    case REC20_POUND_AVOIRDUPOIS_PER_SECOND = 'K81';

    /**
     * pound (avoirdupois) per second degree Fahrenheit
     */
    case REC20_POUND_AVOIRDUPOIS_PER_SECOND_DEGREE_FAHRENHEIT = 'K82';

    /**
     * pound (avoirdupois) per second psi
     */
    case REC20_POUND_AVOIRDUPOIS_PER_SECOND_PSI = 'K83';

    /**
     * pound per cubic yard
     */
    case REC20_POUND_PER_CUBIC_YARD = 'K84';

    /**
     * pound-force per square foot
     */
    case REC20_POUNDFORCE_PER_SQUARE_FOOT = 'K85';

    /**
     * pound-force per square inch degree Fahrenheit
     */
    case REC20_POUNDFORCE_PER_SQUARE_INCH_DEGREE_FAHRENHEIT = 'K86';

    /**
     * psi cubic inch per second
     */
    case REC20_PSI_CUBIC_INCH_PER_SECOND = 'K87';

    /**
     * psi litre per second
     */
    case REC20_PSI_LITRE_PER_SECOND = 'K88';

    /**
     * psi cubic metre per second
     */
    case REC20_PSI_CUBIC_METRE_PER_SECOND = 'K89';

    /**
     * psi cubic yard per second
     */
    case REC20_PSI_CUBIC_YARD_PER_SECOND = 'K90';

    /**
     * pound-force second per square foot
     */
    case REC20_POUNDFORCE_SECOND_PER_SQUARE_FOOT = 'K91';

    /**
     * pound-force second per square inch
     */
    case REC20_POUNDFORCE_SECOND_PER_SQUARE_INCH = 'K92';

    /**
     * reciprocal psi
     */
    case REC20_RECIPROCAL_PSI = 'K93';

    /**
     * quart (UK liquid) per day
     */
    case REC20_QUART_UK_LIQUID_PER_DAY = 'K94';

    /**
     * quart (UK liquid) per hour
     */
    case REC20_QUART_UK_LIQUID_PER_HOUR = 'K95';

    /**
     * quart (UK liquid) per minute
     */
    case REC20_QUART_UK_LIQUID_PER_MINUTE = 'K96';

    /**
     * quart (UK liquid) per second
     */
    case REC20_QUART_UK_LIQUID_PER_SECOND = 'K97';

    /**
     * quart (US liquid) per day
     */
    case REC20_QUART_US_LIQUID_PER_DAY = 'K98';

    /**
     * quart (US liquid) per hour
     */
    case REC20_QUART_US_LIQUID_PER_HOUR = 'K99';

    /**
     * cake
     */
    case REC20_CAKE = 'KA';

    /**
     * katal
     */
    case REC20_KATAL = 'KAT';

    /**
     * kilocharacter
     */
    case REC20_KILOCHARACTER = 'KB';

    /**
     * kilobar
     */
    case REC20_KILOBAR = 'KBA';

    /**
     * kilogram of choline chloride
     */
    case REC20_KILOGRAM_OF_CHOLINE_CHLORIDE = 'KCC';

    /**
     * kilogram drained net weight
     */
    case REC20_KILOGRAM_DRAINED_NET_WEIGHT = 'KDW';

    /**
     * kelvin
     */
    case REC20_KELVIN = 'KEL';

    /**
     * kilogram
     */
    case REC20_KILOGRAM = 'KGM';

    /**
     * kilogram per second
     */
    case REC20_KILOGRAM_PER_SECOND = 'KGS';

    /**
     * kilogram of hydrogen peroxide
     */
    case REC20_KILOGRAM_OF_HYDROGEN_PEROXIDE = 'KHY';

    /**
     * kilohertz
     */
    case REC20_KILOHERTZ = 'KHZ';

    /**
     * kilogram per millimetre width
     */
    case REC20_KILOGRAM_PER_MILLIMETRE_WIDTH = 'KI';

    /**
     * kilogram, including container
     */
    case REC20_KILOGRAM_INCLUDING_CONTAINER = 'KIC';

    /**
     * kilogram, including inner packaging
     */
    case REC20_KILOGRAM_INCLUDING_INNER_PACKAGING = 'KIP';

    /**
     * kilosegment
     */
    case REC20_KILOSEGMENT = 'KJ';

    /**
     * kilojoule
     */
    case REC20_KILOJOULE = 'KJO';

    /**
     * kilogram per metre
     */
    case REC20_KILOGRAM_PER_METRE = 'KL';

    /**
     * lactic dry material percentage
     */
    case REC20_LACTIC_DRY_MATERIAL_PERCENTAGE = 'KLK';

    /**
     * kilolux
     */
    case REC20_KILOLUX = 'KLX';

    /**
     * kilogram of methylamine
     */
    case REC20_KILOGRAM_OF_METHYLAMINE = 'KMA';

    /**
     * kilometre per hour
     */
    case REC20_KILOMETRE_PER_HOUR = 'KMH';

    /**
     * square kilometre
     */
    case REC20_SQUARE_KILOMETRE = 'KMK';

    /**
     * kilogram per cubic metre
     */
    case REC20_KILOGRAM_PER_CUBIC_METRE = 'KMQ';

    /**
     * kilometre
     */
    case REC20_KILOMETRE = 'KMT';

    /**
     * kilogram of nitrogen
     */
    case REC20_KILOGRAM_OF_NITROGEN = 'KNI';

    /**
     * kilonewton per square metre
     */
    case REC20_KILONEWTON_PER_SQUARE_METRE = 'KNM';

    /**
     * kilogram named substance
     */
    case REC20_KILOGRAM_NAMED_SUBSTANCE = 'KNS';

    /**
     * knot
     */
    case REC20_KNOT = 'KNT';

    /**
     * milliequivalence caustic potash per gram of product
     */
    case REC20_MILLIEQUIVALENCE_CAUSTIC_POTASH_PER_GRAM_OF_PRODUCT = 'KO';

    /**
     * kilopascal
     */
    case REC20_KILOPASCAL = 'KPA';

    /**
     * kilogram of potassium hydroxide (caustic potash)
     */
    case REC20_KILOGRAM_OF_POTASSIUM_HYDROXIDE_CAUSTIC_POTASH = 'KPH';

    /**
     * kilogram of potassium oxide
     */
    case REC20_KILOGRAM_OF_POTASSIUM_OXIDE = 'KPO';

    /**
     * kilogram of phosphorus pentoxide (phosphoric anhydride)
     */
    case REC20_KILOGRAM_OF_PHOSPHORUS_PENTOXIDE_PHOSPHORIC_ANHYDRIDE = 'KPP';

    /**
     * kiloroentgen
     */
    case REC20_KILOROENTGEN = 'KR';

    /**
     * kilogram of substance 90 % dry
     */
    case REC20_KILOGRAM_OF_SUBSTANCE_90__DRY = 'KSD';

    /**
     * kilogram of sodium hydroxide (caustic soda)
     */
    case REC20_KILOGRAM_OF_SODIUM_HYDROXIDE_CAUSTIC_SODA = 'KSH';

    /**
     * kit
     */
    case REC20_KIT = 'KT';

    /**
     * kilotonne
     */
    case REC20_KILOTONNE = 'KTN';

    /**
     * kilogram of uranium
     */
    case REC20_KILOGRAM_OF_URANIUM = 'KUR';

    /**
     * kilovolt - ampere
     */
    case REC20_KILOVOLT__AMPERE = 'KVA';

    /**
     * kilovar
     */
    case REC20_KILOVAR = 'KVR';

    /**
     * kilovolt
     */
    case REC20_KILOVOLT = 'KVT';

    /**
     * kilogram per millimetre
     */
    case REC20_KILOGRAM_PER_MILLIMETRE = 'KW';

    /**
     * kilowatt hour
     */
    case REC20_KILOWATT_HOUR = 'KWH';

    /**
     * Kilowatt hour per normalized cubic metre
     */
    case REC20_KILOWATT_HOUR_PER_NORMALIZED_CUBIC_METRE = 'KWN';

    /**
     * kilogram of tungsten trioxide
     */
    case REC20_KILOGRAM_OF_TUNGSTEN_TRIOXIDE = 'KWO';

    /**
     * Kilowatt hour per standard cubic metre
     */
    case REC20_KILOWATT_HOUR_PER_STANDARD_CUBIC_METRE = 'KWS';

    /**
     * kilowatt
     */
    case REC20_KILOWATT = 'KWT';

    /**
     * millilitre per kilogram
     */
    case REC20_MILLILITRE_PER_KILOGRAM = 'KX';

    /**
     * quart (US liquid) per minute
     */
    case REC20_QUART_US_LIQUID_PER_MINUTE = 'L10';

    /**
     * quart (US liquid) per second
     */
    case REC20_QUART_US_LIQUID_PER_SECOND = 'L11';

    /**
     * metre per second kelvin
     */
    case REC20_METRE_PER_SECOND_KELVIN = 'L12';

    /**
     * metre per second bar
     */
    case REC20_METRE_PER_SECOND_BAR = 'L13';

    /**
     * square metre hour degree Celsius per kilocalorie (international table)
     */
    case REC20_SQUARE_METRE_HOUR_DEGREE_CELSIUS_PER_KILOCALORIE_INTERNATIONAL_TABLE = 'L14';

    /**
     * millipascal second per kelvin
     */
    case REC20_MILLIPASCAL_SECOND_PER_KELVIN = 'L15';

    /**
     * millipascal second per bar
     */
    case REC20_MILLIPASCAL_SECOND_PER_BAR = 'L16';

    /**
     * milligram per cubic metre kelvin
     */
    case REC20_MILLIGRAM_PER_CUBIC_METRE_KELVIN = 'L17';

    /**
     * milligram per cubic metre bar
     */
    case REC20_MILLIGRAM_PER_CUBIC_METRE_BAR = 'L18';

    /**
     * millilitre per litre
     */
    case REC20_MILLILITRE_PER_LITRE = 'L19';

    /**
     * litre per minute
     */
    case REC20_LITRE_PER_MINUTE = 'L2';

    /**
     * reciprocal cubic millimetre
     */
    case REC20_RECIPROCAL_CUBIC_MILLIMETRE = 'L20';

    /**
     * cubic millimetre per cubic metre
     */
    case REC20_CUBIC_MILLIMETRE_PER_CUBIC_METRE = 'L21';

    /**
     * mole per hour
     */
    case REC20_MOLE_PER_HOUR = 'L23';

    /**
     * mole per kilogram kelvin
     */
    case REC20_MOLE_PER_KILOGRAM_KELVIN = 'L24';

    /**
     * mole per kilogram bar
     */
    case REC20_MOLE_PER_KILOGRAM_BAR = 'L25';

    /**
     * mole per litre kelvin
     */
    case REC20_MOLE_PER_LITRE_KELVIN = 'L26';

    /**
     * mole per litre bar
     */
    case REC20_MOLE_PER_LITRE_BAR = 'L27';

    /**
     * mole per cubic metre kelvin
     */
    case REC20_MOLE_PER_CUBIC_METRE_KELVIN = 'L28';

    /**
     * mole per cubic metre bar
     */
    case REC20_MOLE_PER_CUBIC_METRE_BAR = 'L29';

    /**
     * mole per minute
     */
    case REC20_MOLE_PER_MINUTE = 'L30';

    /**
     * milliroentgen aequivalent men
     */
    case REC20_MILLIROENTGEN_AEQUIVALENT_MEN = 'L31';

    /**
     * nanogram per kilogram
     */
    case REC20_NANOGRAM_PER_KILOGRAM = 'L32';

    /**
     * ounce (avoirdupois) per day
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_DAY = 'L33';

    /**
     * ounce (avoirdupois) per hour
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_HOUR = 'L34';

    /**
     * ounce (avoirdupois) per minute
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_MINUTE = 'L35';

    /**
     * ounce (avoirdupois) per second
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_SECOND = 'L36';

    /**
     * ounce (avoirdupois) per gallon (UK)
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_GALLON_UK = 'L37';

    /**
     * ounce (avoirdupois) per gallon (US)
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_GALLON_US = 'L38';

    /**
     * ounce (avoirdupois) per cubic inch
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_CUBIC_INCH = 'L39';

    /**
     * ounce (avoirdupois)-force
     */
    case REC20_OUNCE_AVOIRDUPOISFORCE = 'L40';

    /**
     * ounce (avoirdupois)-force inch
     */
    case REC20_OUNCE_AVOIRDUPOISFORCE_INCH = 'L41';

    /**
     * picosiemens per metre
     */
    case REC20_PICOSIEMENS_PER_METRE = 'L42';

    /**
     * peck (UK)
     */
    case REC20_PECK_UK = 'L43';

    /**
     * peck (UK) per day
     */
    case REC20_PECK_UK_PER_DAY = 'L44';

    /**
     * peck (UK) per hour
     */
    case REC20_PECK_UK_PER_HOUR = 'L45';

    /**
     * peck (UK) per minute
     */
    case REC20_PECK_UK_PER_MINUTE = 'L46';

    /**
     * peck (UK) per second
     */
    case REC20_PECK_UK_PER_SECOND = 'L47';

    /**
     * peck (US dry) per day
     */
    case REC20_PECK_US_DRY_PER_DAY = 'L48';

    /**
     * peck (US dry) per hour
     */
    case REC20_PECK_US_DRY_PER_HOUR = 'L49';

    /**
     * peck (US dry) per minute
     */
    case REC20_PECK_US_DRY_PER_MINUTE = 'L50';

    /**
     * peck (US dry) per second
     */
    case REC20_PECK_US_DRY_PER_SECOND = 'L51';

    /**
     * psi per psi
     */
    case REC20_PSI_PER_PSI = 'L52';

    /**
     * pint (UK) per day
     */
    case REC20_PINT_UK_PER_DAY = 'L53';

    /**
     * pint (UK) per hour
     */
    case REC20_PINT_UK_PER_HOUR = 'L54';

    /**
     * pint (UK) per minute
     */
    case REC20_PINT_UK_PER_MINUTE = 'L55';

    /**
     * pint (UK) per second
     */
    case REC20_PINT_UK_PER_SECOND = 'L56';

    /**
     * pint (US liquid) per day
     */
    case REC20_PINT_US_LIQUID_PER_DAY = 'L57';

    /**
     * pint (US liquid) per hour
     */
    case REC20_PINT_US_LIQUID_PER_HOUR = 'L58';

    /**
     * pint (US liquid) per minute
     */
    case REC20_PINT_US_LIQUID_PER_MINUTE = 'L59';

    /**
     * pint (US liquid) per second
     */
    case REC20_PINT_US_LIQUID_PER_SECOND = 'L60';

    /**
     * slug per day
     */
    case REC20_SLUG_PER_DAY = 'L63';

    /**
     * slug per foot second
     */
    case REC20_SLUG_PER_FOOT_SECOND = 'L64';

    /**
     * slug per cubic foot
     */
    case REC20_SLUG_PER_CUBIC_FOOT = 'L65';

    /**
     * slug per hour
     */
    case REC20_SLUG_PER_HOUR = 'L66';

    /**
     * slug per minute
     */
    case REC20_SLUG_PER_MINUTE = 'L67';

    /**
     * slug per second
     */
    case REC20_SLUG_PER_SECOND = 'L68';

    /**
     * tonne per kelvin
     */
    case REC20_TONNE_PER_KELVIN = 'L69';

    /**
     * tonne per bar
     */
    case REC20_TONNE_PER_BAR = 'L70';

    /**
     * tonne per day
     */
    case REC20_TONNE_PER_DAY = 'L71';

    /**
     * tonne per day kelvin
     */
    case REC20_TONNE_PER_DAY_KELVIN = 'L72';

    /**
     * tonne per day bar
     */
    case REC20_TONNE_PER_DAY_BAR = 'L73';

    /**
     * tonne per hour kelvin
     */
    case REC20_TONNE_PER_HOUR_KELVIN = 'L74';

    /**
     * tonne per hour bar
     */
    case REC20_TONNE_PER_HOUR_BAR = 'L75';

    /**
     * tonne per cubic metre kelvin
     */
    case REC20_TONNE_PER_CUBIC_METRE_KELVIN = 'L76';

    /**
     * tonne per cubic metre bar
     */
    case REC20_TONNE_PER_CUBIC_METRE_BAR = 'L77';

    /**
     * tonne per minute
     */
    case REC20_TONNE_PER_MINUTE = 'L78';

    /**
     * tonne per minute kelvin
     */
    case REC20_TONNE_PER_MINUTE_KELVIN = 'L79';

    /**
     * tonne per minute bar
     */
    case REC20_TONNE_PER_MINUTE_BAR = 'L80';

    /**
     * tonne per second
     */
    case REC20_TONNE_PER_SECOND = 'L81';

    /**
     * tonne per second kelvin
     */
    case REC20_TONNE_PER_SECOND_KELVIN = 'L82';

    /**
     * tonne per second bar
     */
    case REC20_TONNE_PER_SECOND_BAR = 'L83';

    /**
     * ton (UK shipping)
     */
    case REC20_TON_UK_SHIPPING = 'L84';

    /**
     * ton long per day
     */
    case REC20_TON_LONG_PER_DAY = 'L85';

    /**
     * ton (US shipping)
     */
    case REC20_TON_US_SHIPPING = 'L86';

    /**
     * ton short per degree Fahrenheit
     */
    case REC20_TON_SHORT_PER_DEGREE_FAHRENHEIT = 'L87';

    /**
     * ton short per day
     */
    case REC20_TON_SHORT_PER_DAY = 'L88';

    /**
     * ton short per hour degree Fahrenheit
     */
    case REC20_TON_SHORT_PER_HOUR_DEGREE_FAHRENHEIT = 'L89';

    /**
     * ton short per hour psi
     */
    case REC20_TON_SHORT_PER_HOUR_PSI = 'L90';

    /**
     * ton short per psi
     */
    case REC20_TON_SHORT_PER_PSI = 'L91';

    /**
     * ton (UK long) per cubic yard
     */
    case REC20_TON_UK_LONG_PER_CUBIC_YARD = 'L92';

    /**
     * ton (US short) per cubic yard
     */
    case REC20_TON_US_SHORT_PER_CUBIC_YARD = 'L93';

    /**
     * ton-force (US short)
     */
    case REC20_TONFORCE_US_SHORT = 'L94';

    /**
     * common year
     */
    case REC20_COMMON_YEAR = 'L95';

    /**
     * sidereal year
     */
    case REC20_SIDEREAL_YEAR = 'L96';

    /**
     * yard per degree Fahrenheit
     */
    case REC20_YARD_PER_DEGREE_FAHRENHEIT = 'L98';

    /**
     * yard per psi
     */
    case REC20_YARD_PER_PSI = 'L99';

    /**
     * pound per cubic inch
     */
    case REC20_POUND_PER_CUBIC_INCH = 'LA';

    /**
     * lactose excess percentage
     */
    case REC20_LACTOSE_EXCESS_PERCENTAGE = 'LAC';

    /**
     * pound
     */
    case REC20_POUND = 'LBR';

    /**
     * troy pound (US)
     */
    case REC20_TROY_POUND_US = 'LBT';

    /**
     * litre per day
     */
    case REC20_LITRE_PER_DAY = 'LD';

    /**
     * leaf
     */
    case REC20_LEAF = 'LEF';

    /**
     * linear foot
     */
    case REC20_LINEAR_FOOT = 'LF';

    /**
     * labour hour
     */
    case REC20_LABOUR_HOUR = 'LH';

    /**
     * link
     */
    case REC20_LINK = 'LK';

    /**
     * linear metre
     */
    case REC20_LINEAR_METRE = 'LM';

    /**
     * length
     */
    case REC20_LENGTH = 'LN';

    /**
     * lot  [unit of procurement]
     */
    case REC20_LOT__UNIT_OF_PROCUREMENT = 'LO';

    /**
     * liquid pound
     */
    case REC20_LIQUID_POUND = 'LP';

    /**
     * litre of pure alcohol
     */
    case REC20_LITRE_OF_PURE_ALCOHOL = 'LPA';

    /**
     * layer
     */
    case REC20_LAYER = 'LR';

    /**
     * lump sum
     */
    case REC20_LUMP_SUM = 'LS';

    /**
     * ton (UK) or long ton (US)
     */
    case REC20_TON_UK_OR_LONG_TON_US = 'LTN';

    /**
     * litre
     */
    case REC20_LITRE = 'LTR';

    /**
     * metric ton, lubricating oil
     */
    case REC20_METRIC_TON_LUBRICATING_OIL = 'LUB';

    /**
     * lumen
     */
    case REC20_LUMEN = 'LUM';

    /**
     * lux
     */
    case REC20_LUX = 'LUX';

    /**
     * linear yard
     */
    case REC20_LINEAR_YARD = 'LY';

    /**
     * milligram per litre
     */
    case REC20_MILLIGRAM_PER_LITRE = 'M1';

    /**
     * reciprocal cubic yard
     */
    case REC20_RECIPROCAL_CUBIC_YARD = 'M10';

    /**
     * cubic yard per degree Fahrenheit
     */
    case REC20_CUBIC_YARD_PER_DEGREE_FAHRENHEIT = 'M11';

    /**
     * cubic yard per day
     */
    case REC20_CUBIC_YARD_PER_DAY = 'M12';

    /**
     * cubic yard per hour
     */
    case REC20_CUBIC_YARD_PER_HOUR = 'M13';

    /**
     * cubic yard per psi
     */
    case REC20_CUBIC_YARD_PER_PSI = 'M14';

    /**
     * cubic yard per minute
     */
    case REC20_CUBIC_YARD_PER_MINUTE = 'M15';

    /**
     * cubic yard per second
     */
    case REC20_CUBIC_YARD_PER_SECOND = 'M16';

    /**
     * kilohertz metre
     */
    case REC20_KILOHERTZ_METRE = 'M17';

    /**
     * gigahertz metre
     */
    case REC20_GIGAHERTZ_METRE = 'M18';

    /**
     * Beaufort
     */
    case REC20_BEAUFORT = 'M19';

    /**
     * reciprocal megakelvin or megakelvin to the power minus one
     */
    case REC20_RECIPROCAL_MEGAKELVIN_OR_MEGAKELVIN_TO_THE_POWER_MINUS_ONE = 'M20';

    /**
     * reciprocal kilovolt - ampere reciprocal hour
     */
    case REC20_RECIPROCAL_KILOVOLT__AMPERE_RECIPROCAL_HOUR = 'M21';

    /**
     * millilitre per square centimetre minute
     */
    case REC20_MILLILITRE_PER_SQUARE_CENTIMETRE_MINUTE = 'M22';

    /**
     * newton per centimetre
     */
    case REC20_NEWTON_PER_CENTIMETRE = 'M23';

    /**
     * ohm kilometre
     */
    case REC20_OHM_KILOMETRE = 'M24';

    /**
     * percent per degree Celsius
     */
    case REC20_PERCENT_PER_DEGREE_CELSIUS = 'M25';

    /**
     * gigaohm per metre
     */
    case REC20_GIGAOHM_PER_METRE = 'M26';

    /**
     * megahertz metre
     */
    case REC20_MEGAHERTZ_METRE = 'M27';

    /**
     * kilogram per kilogram
     */
    case REC20_KILOGRAM_PER_KILOGRAM = 'M29';

    /**
     * reciprocal volt - ampere reciprocal second
     */
    case REC20_RECIPROCAL_VOLT__AMPERE_RECIPROCAL_SECOND = 'M30';

    /**
     * kilogram per kilometre
     */
    case REC20_KILOGRAM_PER_KILOMETRE = 'M31';

    /**
     * pascal second per litre
     */
    case REC20_PASCAL_SECOND_PER_LITRE = 'M32';

    /**
     * millimole per litre
     */
    case REC20_MILLIMOLE_PER_LITRE = 'M33';

    /**
     * newton metre per square metre
     */
    case REC20_NEWTON_METRE_PER_SQUARE_METRE = 'M34';

    /**
     * millivolt - ampere
     */
    case REC20_MILLIVOLT__AMPERE = 'M35';

    /**
     * 30-day month
     */
    case REC20_30DAY_MONTH = 'M36';

    /**
     * actual/360
     */
    case REC20_ACTUAL_360 = 'M37';

    /**
     * kilometre per second squared
     */
    case REC20_KILOMETRE_PER_SECOND_SQUARED = 'M38';

    /**
     * centimetre per second squared
     */
    case REC20_CENTIMETRE_PER_SECOND_SQUARED = 'M39';

    /**
     * monetary value
     */
    case REC20_MONETARY_VALUE = 'M4';

    /**
     * yard per second squared
     */
    case REC20_YARD_PER_SECOND_SQUARED = 'M40';

    /**
     * millimetre per second squared
     */
    case REC20_MILLIMETRE_PER_SECOND_SQUARED = 'M41';

    /**
     * mile (statute mile) per second squared
     */
    case REC20_MILE_STATUTE_MILE_PER_SECOND_SQUARED = 'M42';

    /**
     * mil
     */
    case REC20_MIL = 'M43';

    /**
     * revolution
     */
    case REC20_REVOLUTION = 'M44';

    /**
     * degree [unit of angle] per second squared
     */
    case REC20_DEGREE_UNIT_OF_ANGLE_PER_SECOND_SQUARED = 'M45';

    /**
     * revolution per minute
     */
    case REC20_REVOLUTION_PER_MINUTE = 'M46';

    /**
     * circular mil
     */
    case REC20_CIRCULAR_MIL = 'M47';

    /**
     * square mile (based on U.S. survey foot)
     */
    case REC20_SQUARE_MILE_BASED_ON_US_SURVEY_FOOT = 'M48';

    /**
     * chain (based on U.S. survey foot)
     */
    case REC20_CHAIN_BASED_ON_US_SURVEY_FOOT = 'M49';

    /**
     * microcurie
     */
    case REC20_MICROCURIE = 'M5';

    /**
     * furlong
     */
    case REC20_FURLONG = 'M50';

    /**
     * foot (U.S. survey)
     */
    case REC20_FOOT_US_SURVEY = 'M51';

    /**
     * mile (based on U.S. survey foot)
     */
    case REC20_MILE_BASED_ON_US_SURVEY_FOOT = 'M52';

    /**
     * metre per pascal
     */
    case REC20_METRE_PER_PASCAL = 'M53';

    /**
     * metre per radiant
     */
    case REC20_METRE_PER_RADIANT = 'M55';

    /**
     * shake
     */
    case REC20_SHAKE = 'M56';

    /**
     * mile per minute
     */
    case REC20_MILE_PER_MINUTE = 'M57';

    /**
     * mile per second
     */
    case REC20_MILE_PER_SECOND = 'M58';

    /**
     * metre per second pascal
     */
    case REC20_METRE_PER_SECOND_PASCAL = 'M59';

    /**
     * metre per hour
     */
    case REC20_METRE_PER_HOUR = 'M60';

    /**
     * inch per year
     */
    case REC20_INCH_PER_YEAR = 'M61';

    /**
     * kilometre per second
     */
    case REC20_KILOMETRE_PER_SECOND = 'M62';

    /**
     * inch per minute
     */
    case REC20_INCH_PER_MINUTE = 'M63';

    /**
     * yard per second
     */
    case REC20_YARD_PER_SECOND = 'M64';

    /**
     * yard per minute
     */
    case REC20_YARD_PER_MINUTE = 'M65';

    /**
     * yard per hour
     */
    case REC20_YARD_PER_HOUR = 'M66';

    /**
     * acre-foot (based on U.S. survey foot)
     */
    case REC20_ACREFOOT_BASED_ON_US_SURVEY_FOOT = 'M67';

    /**
     * cord (128 ft3)
     */
    case REC20_CORD_128_FT3 = 'M68';

    /**
     * cubic mile (UK statute)
     */
    case REC20_CUBIC_MILE_UK_STATUTE = 'M69';

    /**
     * micro-inch
     */
    case REC20_MICROINCH = 'M7';

    /**
     * ton, register
     */
    case REC20_TON_REGISTER = 'M70';

    /**
     * cubic metre per pascal
     */
    case REC20_CUBIC_METRE_PER_PASCAL = 'M71';

    /**
     * bel
     */
    case REC20_BEL = 'M72';

    /**
     * kilogram per cubic metre pascal
     */
    case REC20_KILOGRAM_PER_CUBIC_METRE_PASCAL = 'M73';

    /**
     * kilogram per pascal
     */
    case REC20_KILOGRAM_PER_PASCAL = 'M74';

    /**
     * kilopound-force
     */
    case REC20_KILOPOUNDFORCE = 'M75';

    /**
     * poundal
     */
    case REC20_POUNDAL = 'M76';

    /**
     * kilogram metre per second squared
     */
    case REC20_KILOGRAM_METRE_PER_SECOND_SQUARED = 'M77';

    /**
     * pond
     */
    case REC20_POND = 'M78';

    /**
     * square foot per hour
     */
    case REC20_SQUARE_FOOT_PER_HOUR = 'M79';

    /**
     * stokes per pascal
     */
    case REC20_STOKES_PER_PASCAL = 'M80';

    /**
     * square centimetre per second
     */
    case REC20_SQUARE_CENTIMETRE_PER_SECOND = 'M81';

    /**
     * square metre per second pascal
     */
    case REC20_SQUARE_METRE_PER_SECOND_PASCAL = 'M82';

    /**
     * denier
     */
    case REC20_DENIER = 'M83';

    /**
     * pound per yard
     */
    case REC20_POUND_PER_YARD = 'M84';

    /**
     * ton, assay
     */
    case REC20_TON_ASSAY = 'M85';

    /**
     * pfund
     */
    case REC20_PFUND = 'M86';

    /**
     * kilogram per second pascal
     */
    case REC20_KILOGRAM_PER_SECOND_PASCAL = 'M87';

    /**
     * tonne per month
     */
    case REC20_TONNE_PER_MONTH = 'M88';

    /**
     * tonne per year
     */
    case REC20_TONNE_PER_YEAR = 'M89';

    /**
     * million Btu per 1000 cubic foot
     */
    case REC20_MILLION_BTU_PER_1000_CUBIC_FOOT = 'M9';

    /**
     * kilopound per hour
     */
    case REC20_KILOPOUND_PER_HOUR = 'M90';

    /**
     * pound per pound
     */
    case REC20_POUND_PER_POUND = 'M91';

    /**
     * pound-force foot
     */
    case REC20_POUNDFORCE_FOOT = 'M92';

    /**
     * newton metre per radian
     */
    case REC20_NEWTON_METRE_PER_RADIAN = 'M93';

    /**
     * kilogram metre
     */
    case REC20_KILOGRAM_METRE = 'M94';

    /**
     * poundal foot
     */
    case REC20_POUNDAL_FOOT = 'M95';

    /**
     * poundal inch
     */
    case REC20_POUNDAL_INCH = 'M96';

    /**
     * dyne metre
     */
    case REC20_DYNE_METRE = 'M97';

    /**
     * kilogram centimetre per second
     */
    case REC20_KILOGRAM_CENTIMETRE_PER_SECOND = 'M98';

    /**
     * gram centimetre per second
     */
    case REC20_GRAM_CENTIMETRE_PER_SECOND = 'M99';

    /**
     * megavolt ampere reactive hour
     */
    case REC20_MEGAVOLT_AMPERE_REACTIVE_HOUR = 'MAH';

    /**
     * megalitre
     */
    case REC20_MEGALITRE = 'MAL';

    /**
     * megametre
     */
    case REC20_MEGAMETRE = 'MAM';

    /**
     * megavar
     */
    case REC20_MEGAVAR = 'MAR';

    /**
     * megawatt
     */
    case REC20_MEGAWATT = 'MAW';

    /**
     * thousand standard brick equivalent
     */
    case REC20_THOUSAND_STANDARD_BRICK_EQUIVALENT = 'MBE';

    /**
     * thousand board foot
     */
    case REC20_THOUSAND_BOARD_FOOT = 'MBF';

    /**
     * millibar
     */
    case REC20_MILLIBAR = 'MBR';

    /**
     * microgram
     */
    case REC20_MICROGRAM = 'MC';

    /**
     * millicurie
     */
    case REC20_MILLICURIE = 'MCU';

    /**
     * air dry metric ton
     */
    case REC20_AIR_DRY_METRIC_TON = 'MD';

    /**
     * milligram
     */
    case REC20_MILLIGRAM = 'MGM';

    /**
     * megahertz
     */
    case REC20_MEGAHERTZ = 'MHZ';

    /**
     * square mile (statute mile)
     */
    case REC20_SQUARE_MILE_STATUTE_MILE = 'MIK';

    /**
     * thousand
     */
    case REC20_THOUSAND = 'MIL';

    /**
     * minute [unit of time]
     */
    case REC20_MINUTE_UNIT_OF_TIME = 'MIN';

    /**
     * million
     */
    case REC20_MILLION = 'MIO';

    /**
     * million international unit
     */
    case REC20_MILLION_INTERNATIONAL_UNIT = 'MIU';

    /**
     * milliard
     */
    case REC20_MILLIARD = 'MLD';

    /**
     * millilitre
     */
    case REC20_MILLILITRE = 'MLT';

    /**
     * square millimetre
     */
    case REC20_SQUARE_MILLIMETRE = 'MMK';

    /**
     * cubic millimetre
     */
    case REC20_CUBIC_MILLIMETRE = 'MMQ';

    /**
     * millimetre
     */
    case REC20_MILLIMETRE = 'MMT';

    /**
     * kilogram, dry weight
     */
    case REC20_KILOGRAM_DRY_WEIGHT = 'MND';

    /**
     * month
     */
    case REC20_MONTH = 'MON';

    /**
     * megapascal
     */
    case REC20_MEGAPASCAL = 'MPA';

    /**
     * cubic metre per hour
     */
    case REC20_CUBIC_METRE_PER_HOUR = 'MQH';

    /**
     * cubic metre per second
     */
    case REC20_CUBIC_METRE_PER_SECOND = 'MQS';

    /**
     * metre per second squared
     */
    case REC20_METRE_PER_SECOND_SQUARED = 'MSK';

    /**
     * square metre
     */
    case REC20_SQUARE_METRE = 'MTK';

    /**
     * cubic metre
     */
    case REC20_CUBIC_METRE = 'MTQ';

    /**
     * metre
     */
    case REC20_METRE = 'MTR';

    /**
     * metre per second
     */
    case REC20_METRE_PER_SECOND = 'MTS';

    /**
     * megavolt - ampere
     */
    case REC20_MEGAVOLT__AMPERE = 'MVA';

    /**
     * megawatt hour (1000 kW.h)
     */
    case REC20_MEGAWATT_HOUR_1000KWH = 'MWH';

    /**
     * pen calorie
     */
    case REC20_PEN_CALORIE = 'N1';

    /**
     * pound foot per second
     */
    case REC20_POUND_FOOT_PER_SECOND = 'N10';

    /**
     * pound inch per second
     */
    case REC20_POUND_INCH_PER_SECOND = 'N11';

    /**
     * Pferdestaerke
     */
    case REC20_PFERDESTAERKE = 'N12';

    /**
     * centimetre of mercury (0 ºC)
     */
    case REC20_CENTIMETRE_OF_MERCURY_0_C = 'N13';

    /**
     * centimetre of water (4 ºC)
     */
    case REC20_CENTIMETRE_OF_WATER_4_C = 'N14';

    /**
     * foot of water (39.2 ºF)
     */
    case REC20_FOOT_OF_WATER_392_F = 'N15';

    /**
     * inch of mercury (32 ºF)
     */
    case REC20_INCH_OF_MERCURY_32_F = 'N16';

    /**
     * inch of mercury (60 ºF)
     */
    case REC20_INCH_OF_MERCURY_60_F = 'N17';

    /**
     * inch of water (39.2 ºF)
     */
    case REC20_INCH_OF_WATER_392_F = 'N18';

    /**
     * inch of water (60 ºF)
     */
    case REC20_INCH_OF_WATER_60_F = 'N19';

    /**
     * kip per square inch
     */
    case REC20_KIP_PER_SQUARE_INCH = 'N20';

    /**
     * poundal per square foot
     */
    case REC20_POUNDAL_PER_SQUARE_FOOT = 'N21';

    /**
     * ounce (avoirdupois) per square inch
     */
    case REC20_OUNCE_AVOIRDUPOIS_PER_SQUARE_INCH = 'N22';

    /**
     * conventional metre of water
     */
    case REC20_CONVENTIONAL_METRE_OF_WATER = 'N23';

    /**
     * gram per square millimetre
     */
    case REC20_GRAM_PER_SQUARE_MILLIMETRE = 'N24';

    /**
     * pound per square yard
     */
    case REC20_POUND_PER_SQUARE_YARD = 'N25';

    /**
     * poundal per square inch
     */
    case REC20_POUNDAL_PER_SQUARE_INCH = 'N26';

    /**
     * foot to the fourth power
     */
    case REC20_FOOT_TO_THE_FOURTH_POWER = 'N27';

    /**
     * cubic decimetre per kilogram
     */
    case REC20_CUBIC_DECIMETRE_PER_KILOGRAM = 'N28';

    /**
     * cubic foot per pound
     */
    case REC20_CUBIC_FOOT_PER_POUND = 'N29';

    /**
     * print point
     */
    case REC20_PRINT_POINT = 'N3';

    /**
     * cubic inch per pound
     */
    case REC20_CUBIC_INCH_PER_POUND = 'N30';

    /**
     * kilonewton per metre
     */
    case REC20_KILONEWTON_PER_METRE = 'N31';

    /**
     * poundal per inch
     */
    case REC20_POUNDAL_PER_INCH = 'N32';

    /**
     * pound-force per yard
     */
    case REC20_POUNDFORCE_PER_YARD = 'N33';

    /**
     * poundal second per square foot
     */
    case REC20_POUNDAL_SECOND_PER_SQUARE_FOOT = 'N34';

    /**
     * poise per pascal
     */
    case REC20_POISE_PER_PASCAL = 'N35';

    /**
     * newton second per square metre
     */
    case REC20_NEWTON_SECOND_PER_SQUARE_METRE = 'N36';

    /**
     * kilogram per metre second
     */
    case REC20_KILOGRAM_PER_METRE_SECOND = 'N37';

    /**
     * kilogram per metre minute
     */
    case REC20_KILOGRAM_PER_METRE_MINUTE = 'N38';

    /**
     * kilogram per metre day
     */
    case REC20_KILOGRAM_PER_METRE_DAY = 'N39';

    /**
     * kilogram per metre hour
     */
    case REC20_KILOGRAM_PER_METRE_HOUR = 'N40';

    /**
     * gram per centimetre second
     */
    case REC20_GRAM_PER_CENTIMETRE_SECOND = 'N41';

    /**
     * poundal second per square inch
     */
    case REC20_POUNDAL_SECOND_PER_SQUARE_INCH = 'N42';

    /**
     * pound per foot minute
     */
    case REC20_POUND_PER_FOOT_MINUTE = 'N43';

    /**
     * pound per foot day
     */
    case REC20_POUND_PER_FOOT_DAY = 'N44';

    /**
     * cubic metre per second pascal
     */
    case REC20_CUBIC_METRE_PER_SECOND_PASCAL = 'N45';

    /**
     * foot poundal
     */
    case REC20_FOOT_POUNDAL = 'N46';

    /**
     * inch poundal
     */
    case REC20_INCH_POUNDAL = 'N47';

    /**
     * watt per square centimetre
     */
    case REC20_WATT_PER_SQUARE_CENTIMETRE = 'N48';

    /**
     * watt per square inch
     */
    case REC20_WATT_PER_SQUARE_INCH = 'N49';

    /**
     * British thermal unit (international table) per square foot hour
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SQUARE_FOOT_HOUR = 'N50';

    /**
     * British thermal unit (thermochemical) per square foot hour
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_SQUARE_FOOT_HOUR = 'N51';

    /**
     * British thermal unit (thermochemical) per square foot minute
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_SQUARE_FOOT_MINUTE = 'N52';

    /**
     * British thermal unit (international table) per square foot second
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SQUARE_FOOT_SECOND = 'N53';

    /**
     * British thermal unit (thermochemical) per square foot second
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_SQUARE_FOOT_SECOND = 'N54';

    /**
     * British thermal unit (international table) per square inch second
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SQUARE_INCH_SECOND = 'N55';

    /**
     * calorie (thermochemical) per square centimetre minute
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_SQUARE_CENTIMETRE_MINUTE = 'N56';

    /**
     * calorie (thermochemical) per square centimetre second
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_SQUARE_CENTIMETRE_SECOND = 'N57';

    /**
     * British thermal unit (international table) per cubic foot
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_CUBIC_FOOT = 'N58';

    /**
     * British thermal unit (thermochemical) per cubic foot
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_CUBIC_FOOT = 'N59';

    /**
     * British thermal unit (international table) per degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_DEGREE_FAHRENHEIT = 'N60';

    /**
     * British thermal unit (thermochemical) per degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_DEGREE_FAHRENHEIT = 'N61';

    /**
     * British thermal unit (international table) per degree Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_DEGREE_RANKINE = 'N62';

    /**
     * British thermal unit (thermochemical) per degree Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_DEGREE_RANKINE = 'N63';

    /**
     * British thermal unit (thermochemical) per pound degree Rankine
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_POUND_DEGREE_RANKINE = 'N64';

    /**
     * kilocalorie (international table) per gram kelvin
     */
    case REC20_KILOCALORIE_INTERNATIONAL_TABLE_PER_GRAM_KELVIN = 'N65';

    /**
     * British thermal unit (39 ºF)
     */
    case REC20_BRITISH_THERMAL_UNIT_39_F = 'N66';

    /**
     * British thermal unit (59 ºF)
     */
    case REC20_BRITISH_THERMAL_UNIT_59_F = 'N67';

    /**
     * British thermal unit (60 ºF)
     */
    case REC20_BRITISH_THERMAL_UNIT_60_F = 'N68';

    /**
     * calorie (20 ºC)
     */
    case REC20_CALORIE_20_C = 'N69';

    /**
     * quad (1015 BtuIT)
     */
    case REC20_QUAD_1015_BTUIT = 'N70';

    /**
     * therm (EC)
     */
    case REC20_THERM_EC = 'N71';

    /**
     * therm (U.S.)
     */
    case REC20_THERM_US = 'N72';

    /**
     * British thermal unit (thermochemical) per pound
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_POUND = 'N73';

    /**
     * British thermal unit (international table) per hour square foot degree
     * Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_HOUR_SQUARE_FOOT_DEGREE_FAHRENHEIT = 'N74';

    /**
     * British thermal unit (thermochemical) per hour square foot degree
     * Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_HOUR_SQUARE_FOOT_DEGREE_FAHRENHEIT = 'N75';

    /**
     * British thermal unit (international table) per second square foot
     * degree Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SECOND_SQUARE_FOOT_DEGREE_FAHRENHEIT = 'N76';

    /**
     * British thermal unit (thermochemical) per second square foot degree
     * Fahrenheit
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_SECOND_SQUARE_FOOT_DEGREE_FAHRENHEIT = 'N77';

    /**
     * kilowatt per square metre kelvin
     */
    case REC20_KILOWATT_PER_SQUARE_METRE_KELVIN = 'N78';

    /**
     * kelvin per pascal
     */
    case REC20_KELVIN_PER_PASCAL = 'N79';

    /**
     * watt per metre degree Celsius
     */
    case REC20_WATT_PER_METRE_DEGREE_CELSIUS = 'N80';

    /**
     * kilowatt per metre kelvin
     */
    case REC20_KILOWATT_PER_METRE_KELVIN = 'N81';

    /**
     * kilowatt per metre degree Celsius
     */
    case REC20_KILOWATT_PER_METRE_DEGREE_CELSIUS = 'N82';

    /**
     * metre per degree Celcius metre
     */
    case REC20_METRE_PER_DEGREE_CELCIUS_METRE = 'N83';

    /**
     * degree Fahrenheit hour per British thermal unit (international table)
     */
    case REC20_DEGREE_FAHRENHEIT_HOUR_PER_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE = 'N84';

    /**
     * degree Fahrenheit hour per British thermal unit (thermochemical)
     */
    case REC20_DEGREE_FAHRENHEIT_HOUR_PER_BRITISH_THERMAL_UNIT_THERMOCHEMICAL = 'N85';

    /**
     * degree Fahrenheit second per British thermal unit (international
     * table)
     */
    case REC20_DEGREE_FAHRENHEIT_SECOND_PER_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE = 'N86';

    /**
     * degree Fahrenheit second per British thermal unit (thermochemical)
     */
    case REC20_DEGREE_FAHRENHEIT_SECOND_PER_BRITISH_THERMAL_UNIT_THERMOCHEMICAL = 'N87';

    /**
     * degree Fahrenheit hour square foot per British thermal unit
     * (international table) inch
     */
    case REC20_DEGREE_FAHRENHEIT_HOUR_SQUARE_FOOT_PER_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_INCH = 'N88';

    /**
     * degree Fahrenheit hour square foot per British thermal unit
     * (thermochemical) inch
     */
    case REC20_DEGREE_FAHRENHEIT_HOUR_SQUARE_FOOT_PER_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_INCH = 'N89';

    /**
     * kilofarad
     */
    case REC20_KILOFARAD = 'N90';

    /**
     * reciprocal joule
     */
    case REC20_RECIPROCAL_JOULE = 'N91';

    /**
     * picosiemens
     */
    case REC20_PICOSIEMENS = 'N92';

    /**
     * ampere per pascal
     */
    case REC20_AMPERE_PER_PASCAL = 'N93';

    /**
     * franklin
     */
    case REC20_FRANKLIN = 'N94';

    /**
     * ampere minute
     */
    case REC20_AMPERE_MINUTE = 'N95';

    /**
     * biot
     */
    case REC20_BIOT = 'N96';

    /**
     * gilbert
     */
    case REC20_GILBERT = 'N97';

    /**
     * volt per pascal
     */
    case REC20_VOLT_PER_PASCAL = 'N98';

    /**
     * picovolt
     */
    case REC20_PICOVOLT = 'N99';

    /**
     * milligram per kilogram
     */
    case REC20_MILLIGRAM_PER_KILOGRAM = 'NA';

    /**
     * number of articles
     */
    case REC20_NUMBER_OF_ARTICLES = 'NAR';

    /**
     * number of cells
     */
    case REC20_NUMBER_OF_CELLS = 'NCL';

    /**
     * newton
     */
    case REC20_NEWTON = 'NEW';

    /**
     * message
     */
    case REC20_MESSAGE = 'NF';

    /**
     * nil
     */
    case REC20_NIL = 'NIL';

    /**
     * number of international units
     */
    case REC20_NUMBER_OF_INTERNATIONAL_UNITS = 'NIU';

    /**
     * load
     */
    case REC20_LOAD = 'NL';

    /**
     * Normalised cubic metre
     */
    case REC20_NORMALISED_CUBIC_METRE = 'NM3';

    /**
     * nautical mile
     */
    case REC20_NAUTICAL_MILE = 'NMI';

    /**
     * number of packs
     */
    case REC20_NUMBER_OF_PACKS = 'NMP';

    /**
     * number of parts
     */
    case REC20_NUMBER_OF_PARTS = 'NPT';

    /**
     * net ton
     */
    case REC20_NET_TON = 'NT';

    /**
     * newton metre
     */
    case REC20_NEWTON_METRE = 'NU';

    /**
     * part per thousand
     */
    case REC20_PART_PER_THOUSAND = 'NX';

    /**
     * panel
     */
    case REC20_PANEL = 'OA';

    /**
     * ozone depletion equivalent
     */
    case REC20_OZONE_DEPLETION_EQUIVALENT = 'ODE';

    /**
     * ODS Grams
     */
    case REC20_ODS_GRAMS = 'ODG';

    /**
     * ODS Kilograms
     */
    case REC20_ODS_KILOGRAMS = 'ODK';

    /**
     * ODS Milligrams
     */
    case REC20_ODS_MILLIGRAMS = 'ODM';

    /**
     * ohm
     */
    case REC20_OHM = 'OHM';

    /**
     * ounce per square yard
     */
    case REC20_OUNCE_PER_SQUARE_YARD = 'ON';

    /**
     * ounce (avoirdupois)
     */
    case REC20_OUNCE_AVOIRDUPOIS = 'ONZ';

    /**
     * oscillations per minute
     */
    case REC20_OSCILLATIONS_PER_MINUTE = 'OPM';

    /**
     * overtime hour
     */
    case REC20_OVERTIME_HOUR = 'OT';

    /**
     * fluid ounce (US)
     */
    case REC20_FLUID_OUNCE_US = 'OZA';

    /**
     * fluid ounce (UK)
     */
    case REC20_FLUID_OUNCE_UK = 'OZI';

    /**
     * percent
     */
    case REC20_PERCENT = 'P1';

    /**
     * coulomb per metre
     */
    case REC20_COULOMB_PER_METRE = 'P10';

    /**
     * kiloweber
     */
    case REC20_KILOWEBER = 'P11';

    /**
     * gamma
     */
    case REC20_GAMMA = 'P12';

    /**
     * kilotesla
     */
    case REC20_KILOTESLA = 'P13';

    /**
     * joule per second
     */
    case REC20_JOULE_PER_SECOND = 'P14';

    /**
     * joule per minute
     */
    case REC20_JOULE_PER_MINUTE = 'P15';

    /**
     * joule per hour
     */
    case REC20_JOULE_PER_HOUR = 'P16';

    /**
     * joule per day
     */
    case REC20_JOULE_PER_DAY = 'P17';

    /**
     * kilojoule per second
     */
    case REC20_KILOJOULE_PER_SECOND = 'P18';

    /**
     * kilojoule per minute
     */
    case REC20_KILOJOULE_PER_MINUTE = 'P19';

    /**
     * pound per foot
     */
    case REC20_POUND_PER_FOOT = 'P2';

    /**
     * kilojoule per hour
     */
    case REC20_KILOJOULE_PER_HOUR = 'P20';

    /**
     * kilojoule per day
     */
    case REC20_KILOJOULE_PER_DAY = 'P21';

    /**
     * nanoohm
     */
    case REC20_NANOOHM = 'P22';

    /**
     * ohm circular-mil per foot
     */
    case REC20_OHM_CIRCULARMIL_PER_FOOT = 'P23';

    /**
     * kilohenry
     */
    case REC20_KILOHENRY = 'P24';

    /**
     * lumen per square foot
     */
    case REC20_LUMEN_PER_SQUARE_FOOT = 'P25';

    /**
     * phot
     */
    case REC20_PHOT = 'P26';

    /**
     * footcandle
     */
    case REC20_FOOTCANDLE = 'P27';

    /**
     * candela per square inch
     */
    case REC20_CANDELA_PER_SQUARE_INCH = 'P28';

    /**
     * footlambert
     */
    case REC20_FOOTLAMBERT = 'P29';

    /**
     * lambert
     */
    case REC20_LAMBERT = 'P30';

    /**
     * stilb
     */
    case REC20_STILB = 'P31';

    /**
     * candela per square foot
     */
    case REC20_CANDELA_PER_SQUARE_FOOT = 'P32';

    /**
     * kilocandela
     */
    case REC20_KILOCANDELA = 'P33';

    /**
     * millicandela
     */
    case REC20_MILLICANDELA = 'P34';

    /**
     * Hefner-Kerze
     */
    case REC20_HEFNERKERZE = 'P35';

    /**
     * international candle
     */
    case REC20_INTERNATIONAL_CANDLE = 'P36';

    /**
     * British thermal unit (international table) per square foot
     */
    case REC20_BRITISH_THERMAL_UNIT_INTERNATIONAL_TABLE_PER_SQUARE_FOOT = 'P37';

    /**
     * British thermal unit (thermochemical) per square foot
     */
    case REC20_BRITISH_THERMAL_UNIT_THERMOCHEMICAL_PER_SQUARE_FOOT = 'P38';

    /**
     * calorie (thermochemical) per square centimetre
     */
    case REC20_CALORIE_THERMOCHEMICAL_PER_SQUARE_CENTIMETRE = 'P39';

    /**
     * langley
     */
    case REC20_LANGLEY = 'P40';

    /**
     * decade (logarithmic)
     */
    case REC20_DECADE_LOGARITHMIC = 'P41';

    /**
     * pascal squared second
     */
    case REC20_PASCAL_SQUARED_SECOND = 'P42';

    /**
     * bel per metre
     */
    case REC20_BEL_PER_METRE = 'P43';

    /**
     * pound mole
     */
    case REC20_POUND_MOLE = 'P44';

    /**
     * pound mole per second
     */
    case REC20_POUND_MOLE_PER_SECOND = 'P45';

    /**
     * pound mole per minute
     */
    case REC20_POUND_MOLE_PER_MINUTE = 'P46';

    /**
     * kilomole per kilogram
     */
    case REC20_KILOMOLE_PER_KILOGRAM = 'P47';

    /**
     * pound mole per pound
     */
    case REC20_POUND_MOLE_PER_POUND = 'P48';

    /**
     * newton square metre per ampere
     */
    case REC20_NEWTON_SQUARE_METRE_PER_AMPERE = 'P49';

    /**
     * five pack
     */
    case REC20_FIVE_PACK = 'P5';

    /**
     * weber metre
     */
    case REC20_WEBER_METRE = 'P50';

    /**
     * mol per kilogram pascal
     */
    case REC20_MOL_PER_KILOGRAM_PASCAL = 'P51';

    /**
     * mol per cubic metre pascal
     */
    case REC20_MOL_PER_CUBIC_METRE_PASCAL = 'P52';

    /**
     * unit pole
     */
    case REC20_UNIT_POLE = 'P53';

    /**
     * milligray per second
     */
    case REC20_MILLIGRAY_PER_SECOND = 'P54';

    /**
     * microgray per second
     */
    case REC20_MICROGRAY_PER_SECOND = 'P55';

    /**
     * nanogray per second
     */
    case REC20_NANOGRAY_PER_SECOND = 'P56';

    /**
     * gray per minute
     */
    case REC20_GRAY_PER_MINUTE = 'P57';

    /**
     * milligray per minute
     */
    case REC20_MILLIGRAY_PER_MINUTE = 'P58';

    /**
     * microgray per minute
     */
    case REC20_MICROGRAY_PER_MINUTE = 'P59';

    /**
     * nanogray per minute
     */
    case REC20_NANOGRAY_PER_MINUTE = 'P60';

    /**
     * gray per hour
     */
    case REC20_GRAY_PER_HOUR = 'P61';

    /**
     * milligray per hour
     */
    case REC20_MILLIGRAY_PER_HOUR = 'P62';

    /**
     * microgray per hour
     */
    case REC20_MICROGRAY_PER_HOUR = 'P63';

    /**
     * nanogray per hour
     */
    case REC20_NANOGRAY_PER_HOUR = 'P64';

    /**
     * sievert per second
     */
    case REC20_SIEVERT_PER_SECOND = 'P65';

    /**
     * millisievert per second
     */
    case REC20_MILLISIEVERT_PER_SECOND = 'P66';

    /**
     * microsievert per second
     */
    case REC20_MICROSIEVERT_PER_SECOND = 'P67';

    /**
     * nanosievert per second
     */
    case REC20_NANOSIEVERT_PER_SECOND = 'P68';

    /**
     * rem per second
     */
    case REC20_REM_PER_SECOND = 'P69';

    /**
     * sievert per hour
     */
    case REC20_SIEVERT_PER_HOUR = 'P70';

    /**
     * millisievert per hour
     */
    case REC20_MILLISIEVERT_PER_HOUR = 'P71';

    /**
     * microsievert per hour
     */
    case REC20_MICROSIEVERT_PER_HOUR = 'P72';

    /**
     * nanosievert per hour
     */
    case REC20_NANOSIEVERT_PER_HOUR = 'P73';

    /**
     * sievert per minute
     */
    case REC20_SIEVERT_PER_MINUTE = 'P74';

    /**
     * millisievert per minute
     */
    case REC20_MILLISIEVERT_PER_MINUTE = 'P75';

    /**
     * microsievert per minute
     */
    case REC20_MICROSIEVERT_PER_MINUTE = 'P76';

    /**
     * nanosievert per minute
     */
    case REC20_NANOSIEVERT_PER_MINUTE = 'P77';

    /**
     * reciprocal square inch
     */
    case REC20_RECIPROCAL_SQUARE_INCH = 'P78';

    /**
     * pascal square metre per kilogram
     */
    case REC20_PASCAL_SQUARE_METRE_PER_KILOGRAM = 'P79';

    /**
     * millipascal per metre
     */
    case REC20_MILLIPASCAL_PER_METRE = 'P80';

    /**
     * kilopascal per metre
     */
    case REC20_KILOPASCAL_PER_METRE = 'P81';

    /**
     * hectopascal per metre
     */
    case REC20_HECTOPASCAL_PER_METRE = 'P82';

    /**
     * standard atmosphere per metre
     */
    case REC20_STANDARD_ATMOSPHERE_PER_METRE = 'P83';

    /**
     * technical atmosphere per metre
     */
    case REC20_TECHNICAL_ATMOSPHERE_PER_METRE = 'P84';

    /**
     * torr per metre
     */
    case REC20_TORR_PER_METRE = 'P85';

    /**
     * psi per inch
     */
    case REC20_PSI_PER_INCH = 'P86';

    /**
     * cubic metre per second square metre
     */
    case REC20_CUBIC_METRE_PER_SECOND_SQUARE_METRE = 'P87';

    /**
     * rhe
     */
    case REC20_RHE = 'P88';

    /**
     * pound-force foot per inch
     */
    case REC20_POUNDFORCE_FOOT_PER_INCH = 'P89';

    /**
     * pound-force inch per inch
     */
    case REC20_POUNDFORCE_INCH_PER_INCH = 'P90';

    /**
     * perm (0 ºC)
     */
    case REC20_PERM_0_C = 'P91';

    /**
     * perm (23 ºC)
     */
    case REC20_PERM_23_C = 'P92';

    /**
     * byte per second
     */
    case REC20_BYTE_PER_SECOND = 'P93';

    /**
     * kilobyte per second
     */
    case REC20_KILOBYTE_PER_SECOND = 'P94';

    /**
     * megabyte per second
     */
    case REC20_MEGABYTE_PER_SECOND = 'P95';

    /**
     * reciprocal volt
     */
    case REC20_RECIPROCAL_VOLT = 'P96';

    /**
     * reciprocal radian
     */
    case REC20_RECIPROCAL_RADIAN = 'P97';

    /**
     * pascal to the power sum of stoichiometric numbers
     */
    case REC20_PASCAL_TO_THE_POWER_SUM_OF_STOICHIOMETRIC_NUMBERS = 'P98';

    /**
     * mole per cubiv metre to the power sum of stoichiometric numbers
     */
    case REC20_MOLE_PER_CUBIV_METRE_TO_THE_POWER_SUM_OF_STOICHIOMETRIC_NUMBERS = 'P99';

    /**
     * pascal
     */
    case REC20_PASCAL = 'PAL';

    /**
     * pad
     */
    case REC20_PAD = 'PD';

    /**
     * proof litre
     */
    case REC20_PROOF_LITRE = 'PFL';

    /**
     * proof gallon
     */
    case REC20_PROOF_GALLON = 'PGL';

    /**
     * pitch
     */
    case REC20_PITCH = 'PI';

    /**
     * degree Plato
     */
    case REC20_DEGREE_PLATO = 'PLA';

    /**
     * pound per inch of length
     */
    case REC20_POUND_PER_INCH_OF_LENGTH = 'PO';

    /**
     * page per inch
     */
    case REC20_PAGE_PER_INCH = 'PQ';

    /**
     * pair
     */
    case REC20_PAIR = 'PR';

    /**
     * pound-force per square inch
     */
    case REC20_POUNDFORCE_PER_SQUARE_INCH = 'PS';

    /**
     * dry pint (US)
     */
    case REC20_DRY_PINT_US = 'PTD';

    /**
     * pint (UK)
     */
    case REC20_PINT_UK = 'PTI';

    /**
     * liquid pint (US)
     */
    case REC20_LIQUID_PINT_US = 'PTL';

    /**
     * portion
     */
    case REC20_PORTION = 'PTN';

    /**
     * joule per tesla
     */
    case REC20_JOULE_PER_TESLA = 'Q10';

    /**
     * erlang
     */
    case REC20_ERLANG = 'Q11';

    /**
     * octet
     */
    case REC20_OCTET = 'Q12';

    /**
     * octet per second
     */
    case REC20_OCTET_PER_SECOND = 'Q13';

    /**
     * shannon
     */
    case REC20_SHANNON = 'Q14';

    /**
     * hartley
     */
    case REC20_HARTLEY = 'Q15';

    /**
     * natural unit of information
     */
    case REC20_NATURAL_UNIT_OF_INFORMATION = 'Q16';

    /**
     * shannon per second
     */
    case REC20_SHANNON_PER_SECOND = 'Q17';

    /**
     * hartley per second
     */
    case REC20_HARTLEY_PER_SECOND = 'Q18';

    /**
     * natural unit of information per second
     */
    case REC20_NATURAL_UNIT_OF_INFORMATION_PER_SECOND = 'Q19';

    /**
     * second per kilogramm
     */
    case REC20_SECOND_PER_KILOGRAMM = 'Q20';

    /**
     * watt square metre
     */
    case REC20_WATT_SQUARE_METRE = 'Q21';

    /**
     * second per radian cubic metre
     */
    case REC20_SECOND_PER_RADIAN_CUBIC_METRE = 'Q22';

    /**
     * weber to the power minus one
     */
    case REC20_WEBER_TO_THE_POWER_MINUS_ONE = 'Q23';

    /**
     * reciprocal inch
     */
    case REC20_RECIPROCAL_INCH = 'Q24';

    /**
     * dioptre
     */
    case REC20_DIOPTRE = 'Q25';

    /**
     * one per one
     */
    case REC20_ONE_PER_ONE = 'Q26';

    /**
     * newton metre per metre
     */
    case REC20_NEWTON_METRE_PER_METRE = 'Q27';

    /**
     * kilogram per square metre pascal second
     */
    case REC20_KILOGRAM_PER_SQUARE_METRE_PASCAL_SECOND = 'Q28';

    /**
     * microgram per hectogram
     */
    case REC20_MICROGRAM_PER_HECTOGRAM = 'Q29';

    /**
     * pH (potential of Hydrogen)
     */
    case REC20_PH_POTENTIAL_OF_HYDROGEN = 'Q30';

    /**
     * kilojoule per gram
     */
    case REC20_KILOJOULE_PER_GRAM = 'Q31';

    /**
     * femtolitre
     */
    case REC20_FEMTOLITRE = 'Q32';

    /**
     * picolitre
     */
    case REC20_PICOLITRE = 'Q33';

    /**
     * nanolitre
     */
    case REC20_NANOLITRE = 'Q34';

    /**
     * megawatts per minute
     */
    case REC20_MEGAWATTS_PER_MINUTE = 'Q35';

    /**
     * square metre per cubic metre
     */
    case REC20_SQUARE_METRE_PER_CUBIC_METRE = 'Q36';

    /**
     * Standard cubic metre per day
     */
    case REC20_STANDARD_CUBIC_METRE_PER_DAY = 'Q37';

    /**
     * Standard cubic metre per hour
     */
    case REC20_STANDARD_CUBIC_METRE_PER_HOUR = 'Q38';

    /**
     * Normalized cubic metre per day
     */
    case REC20_NORMALIZED_CUBIC_METRE_PER_DAY = 'Q39';

    /**
     * Normalized cubic metre per hour
     */
    case REC20_NORMALIZED_CUBIC_METRE_PER_HOUR = 'Q40';

    /**
     * Joule per normalised cubic metre
     */
    case REC20_JOULE_PER_NORMALISED_CUBIC_METRE = 'Q41';

    /**
     * Joule per standard cubic metre
     */
    case REC20_JOULE_PER_STANDARD_CUBIC_METRE = 'Q42';

    /**
     * meal
     */
    case REC20_MEAL = 'Q3';

    /**
     * page - facsimile
     */
    case REC20_PAGE__FACSIMILE = 'QA';

    /**
     * quarter (of a year)
     */
    case REC20_QUARTER_OF_A_YEAR = 'QAN';

    /**
     * page - hardcopy
     */
    case REC20_PAGE__HARDCOPY = 'QB';

    /**
     * quire
     */
    case REC20_QUIRE = 'QR';

    /**
     * dry quart (US)
     */
    case REC20_DRY_QUART_US = 'QTD';

    /**
     * quart (UK)
     */
    case REC20_QUART_UK = 'QTI';

    /**
     * liquid quart (US)
     */
    case REC20_LIQUID_QUART_US = 'QTL';

    /**
     * quarter (UK)
     */
    case REC20_QUARTER_UK = 'QTR';

    /**
     * pica
     */
    case REC20_PICA = 'R1';

    /**
     * thousand cubic metre
     */
    case REC20_THOUSAND_CUBIC_METRE = 'R9';

    /**
     * running or operating hour
     */
    case REC20_RUNNING_OR_OPERATING_HOUR = 'RH';

    /**
     * ream
     */
    case REC20_REAM = 'RM';

    /**
     * room
     */
    case REC20_ROOM = 'ROM';

    /**
     * pound per ream
     */
    case REC20_POUND_PER_REAM = 'RP';

    /**
     * revolutions per minute
     */
    case REC20_REVOLUTIONS_PER_MINUTE = 'RPM';

    /**
     * revolutions per second
     */
    case REC20_REVOLUTIONS_PER_SECOND = 'RPS';

    /**
     * revenue ton mile
     */
    case REC20_REVENUE_TON_MILE = 'RT';

    /**
     * square foot per second
     */
    case REC20_SQUARE_FOOT_PER_SECOND = 'S3';

    /**
     * square metre per second
     */
    case REC20_SQUARE_METRE_PER_SECOND = 'S4';

    /**
     * half year (6 months)
     */
    case REC20_HALF_YEAR_6_MONTHS = 'SAN';

    /**
     * score
     */
    case REC20_SCORE = 'SCO';

    /**
     * scruple
     */
    case REC20_SCRUPLE = 'SCR';

    /**
     * second [unit of time]
     */
    case REC20_SECOND_UNIT_OF_TIME = 'SEC';

    /**
     * set
     */
    case REC20_SET = 'SET';

    /**
     * segment
     */
    case REC20_SEGMENT = 'SG';

    /**
     * siemens
     */
    case REC20_SIEMENS = 'SIE';

    /**
     * Standard cubic metre
     */
    case REC20_STANDARD_CUBIC_METRE = 'SM3';

    /**
     * mile (statute mile)
     */
    case REC20_MILE_STATUTE_MILE = 'SMI';

    /**
     * square
     */
    case REC20_SQUARE = 'SQ';

    /**
     * square, roofing
     */
    case REC20_SQUARE_ROOFING = 'SQR';

    /**
     * strip
     */
    case REC20_STRIP = 'SR';

    /**
     * stick
     */
    case REC20_STICK = 'STC';

    /**
     * stone (UK)
     */
    case REC20_STONE_UK = 'STI';

    /**
     * stick, cigarette
     */
    case REC20_STICK_CIGARETTE = 'STK';

    /**
     * standard litre
     */
    case REC20_STANDARD_LITRE = 'STL';

    /**
     * ton (US) or short ton (UK/US)
     */
    case REC20_TON_US_OR_SHORT_TON_UK_US = 'STN';

    /**
     * straw
     */
    case REC20_STRAW = 'STW';

    /**
     * skein
     */
    case REC20_SKEIN = 'SW';

    /**
     * shipment
     */
    case REC20_SHIPMENT = 'SX';

    /**
     * syringe
     */
    case REC20_SYRINGE = 'SYR';

    /**
     * telecommunication line in service
     */
    case REC20_TELECOMMUNICATION_LINE_IN_SERVICE = 'T0';

    /**
     * thousand piece
     */
    case REC20_THOUSAND_PIECE = 'T3';

    /**
     * kiloampere hour (thousand ampere hour)
     */
    case REC20_KILOAMPERE_HOUR_THOUSAND_AMPERE_HOUR = 'TAH';

    /**
     * total acid number
     */
    case REC20_TOTAL_ACID_NUMBER = 'TAN';

    /**
     * thousand square inch
     */
    case REC20_THOUSAND_SQUARE_INCH = 'TI';

    /**
     * metric ton, including container
     */
    case REC20_METRIC_TON_INCLUDING_CONTAINER = 'TIC';

    /**
     * metric ton, including inner packaging
     */
    case REC20_METRIC_TON_INCLUDING_INNER_PACKAGING = 'TIP';

    /**
     * tonne kilometre
     */
    case REC20_TONNE_KILOMETRE = 'TKM';

    /**
     * kilogram of imported meat, less offal
     */
    case REC20_KILOGRAM_OF_IMPORTED_MEAT_LESS_OFFAL = 'TMS';

    /**
     * tonne (metric ton)
     */
    case REC20_TONNE_METRIC_TON = 'TNE';

    /**
     * ten pack
     */
    case REC20_TEN_PACK = 'TP';

    /**
     * teeth per inch
     */
    case REC20_TEETH_PER_INCH = 'TPI';

    /**
     * ten pair
     */
    case REC20_TEN_PAIR = 'TPR';

    /**
     * thousand cubic metre per day
     */
    case REC20_THOUSAND_CUBIC_METRE_PER_DAY = 'TQD';

    /**
     * trillion (EUR)
     */
    case REC20_TRILLION_EUR = 'TRL';

    /**
     * ten set
     */
    case REC20_TEN_SET = 'TST';

    /**
     * ten thousand sticks
     */
    case REC20_TEN_THOUSAND_STICKS = 'TTS';

    /**
     * treatment
     */
    case REC20_TREATMENT = 'U1';

    /**
     * tablet
     */
    case REC20_TABLET = 'U2';

    /**
     * telecommunication line in service average
     */
    case REC20_TELECOMMUNICATION_LINE_IN_SERVICE_AVERAGE = 'UB';

    /**
     * telecommunication port
     */
    case REC20_TELECOMMUNICATION_PORT = 'UC';

    /**
     * volt - ampere per kilogram
     */
    case REC20_VOLT__AMPERE_PER_KILOGRAM = 'VA';

    /**
     * volt
     */
    case REC20_VOLT = 'VLT';

    /**
     * percent volume
     */
    case REC20_PERCENT_VOLUME = 'VP';

    /**
     * wet kilo
     */
    case REC20_WET_KILO = 'W2';

    /**
     * watt per kilogram
     */
    case REC20_WATT_PER_KILOGRAM = 'WA';

    /**
     * wet pound
     */
    case REC20_WET_POUND = 'WB';

    /**
     * cord
     */
    case REC20_CORD = 'WCD';

    /**
     * wet ton
     */
    case REC20_WET_TON = 'WE';

    /**
     * weber
     */
    case REC20_WEBER = 'WEB';

    /**
     * week
     */
    case REC20_WEEK = 'WEE';

    /**
     * wine gallon
     */
    case REC20_WINE_GALLON = 'WG';

    /**
     * watt hour
     */
    case REC20_WATT_HOUR = 'WHR';

    /**
     * working month
     */
    case REC20_WORKING_MONTH = 'WM';

    /**
     * standard
     */
    case REC20_STANDARD = 'WSD';

    /**
     * watt
     */
    case REC20_WATT = 'WTT';

    /**
     * Gunter's chain
     */
    case REC20_GUNTERS_CHAIN = 'X1';

    /**
     * square yard
     */
    case REC20_SQUARE_YARD = 'YDK';

    /**
     * cubic yard
     */
    case REC20_CUBIC_YARD = 'YDQ';

    /**
     * yard
     */
    case REC20_YARD = 'YRD';

    /**
     * hanging container
     */
    case REC20_HANGING_CONTAINER = 'Z11';

    /**
     * page
     */
    case REC20_PAGE = 'ZP';

    /**
     * mutually defined
     */
    case REC20_MUTUALLY_DEFINED = 'ZZ';

    /**
     * Drum, steel
     */
    case REC21_DRUM_STEEL = 'X1A';

    /**
     * Drum, aluminium
     */
    case REC21_DRUM_ALUMINIUM = 'X1B';

    /**
     * Drum, plywood
     */
    case REC21_DRUM_PLYWOOD = 'X1D';

    /**
     * Container, flexible
     */
    case REC21_CONTAINER_FLEXIBLE = 'X1F';

    /**
     * Drum, fibre
     */
    case REC21_DRUM_FIBRE = 'X1G';

    /**
     * Drum, wooden
     */
    case REC21_DRUM_WOODEN = 'X1W';

    /**
     * Barrel, wooden
     */
    case REC21_BARREL_WOODEN = 'X2C';

    /**
     * Jerrican, steel
     */
    case REC21_JERRICAN_STEEL = 'X3A';

    /**
     * Jerrican, plastic
     */
    case REC21_JERRICAN_PLASTIC = 'X3H';

    /**
     * Bag, super bulk
     */
    case REC21_BAG_SUPER_BULK = 'X43';

    /**
     * Bag, polybag
     */
    case REC21_BAG_POLYBAG = 'X44';

    /**
     * Box, steel
     */
    case REC21_BOX_STEEL = 'X4A';

    /**
     * Box, aluminium
     */
    case REC21_BOX_ALUMINIUM = 'X4B';

    /**
     * Box, natural wood
     */
    case REC21_BOX_NATURAL_WOOD = 'X4C';

    /**
     * Box, plywood
     */
    case REC21_BOX_PLYWOOD = 'X4D';

    /**
     * Box, reconstituted wood
     */
    case REC21_BOX_RECONSTITUTED_WOOD = 'X4F';

    /**
     * Box, fibreboard
     */
    case REC21_BOX_FIBREBOARD = 'X4G';

    /**
     * Box, plastic
     */
    case REC21_BOX_PLASTIC = 'X4H';

    /**
     * Bag, woven plastic
     */
    case REC21_BAG_WOVEN_PLASTIC = 'X5H';

    /**
     * Bag, textile
     */
    case REC21_BAG_TEXTILE = 'X5L';

    /**
     * Bag, paper
     */
    case REC21_BAG_PAPER = 'X5M';

    /**
     * Composite packaging, plastic receptacle
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE = 'X6H';

    /**
     * Composite packaging, glass receptacle
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE = 'X6P';

    /**
     * Case, car
     */
    case REC21_CASE_CAR = 'X7A';

    /**
     * Case, wooden
     */
    case REC21_CASE_WOODEN = 'X7B';

    /**
     * Pallet, wooden
     */
    case REC21_PALLET_WOODEN = 'X8A';

    /**
     * Crate, wooden
     */
    case REC21_CRATE_WOODEN = 'X8B';

    /**
     * Bundle, wooden
     */
    case REC21_BUNDLE_WOODEN = 'X8C';

    /**
     * Intermediate bulk container, rigid plastic
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC = 'XAA';

    /**
     * Receptacle, fibre
     */
    case REC21_RECEPTACLE_FIBRE = 'XAB';

    /**
     * Receptacle, paper
     */
    case REC21_RECEPTACLE_PAPER = 'XAC';

    /**
     * Receptacle, wooden
     */
    case REC21_RECEPTACLE_WOODEN = 'XAD';

    /**
     * Aerosol
     */
    case REC21_AEROSOL = 'XAE';

    /**
     * Pallet, modular, collars 80cms * 60cms
     */
    case REC21_PALLET_MODULAR_COLLARS_80CMS__60CMS = 'XAF';

    /**
     * Pallet, shrinkwrapped
     */
    case REC21_PALLET_SHRINKWRAPPED = 'XAG';

    /**
     * Pallet, 100cms * 110cms
     */
    case REC21_PALLET_100CMS__110CMS = 'XAH';

    /**
     * Clamshell
     */
    case REC21_CLAMSHELL = 'XAI';

    /**
     * Cone
     */
    case REC21_CONE = 'XAJ';

    /**
     * Ball
     */
    case REC21_BALL = 'XAL';

    /**
     * Ampoule, non-protected
     */
    case REC21_AMPOULE_NONPROTECTED = 'XAM';

    /**
     * Ampoule, protected
     */
    case REC21_AMPOULE_PROTECTED = 'XAP';

    /**
     * Atomizer
     */
    case REC21_ATOMIZER = 'XAT';

    /**
     * Capsule
     */
    case REC21_CAPSULE = 'XAV';

    /**
     * Belt
     */
    case REC21_BELT = 'XB4';

    /**
     * Barrel
     */
    case REC21_BARREL = 'XBA';

    /**
     * Bobbin
     */
    case REC21_BOBBIN = 'XBB';

    /**
     * Bottlecrate / bottlerack
     */
    case REC21_BOTTLECRATE___BOTTLERACK = 'XBC';

    /**
     * Board
     */
    case REC21_BOARD = 'XBD';

    /**
     * Bundle
     */
    case REC21_BUNDLE = 'XBE';

    /**
     * Balloon, non-protected
     */
    case REC21_BALLOON_NONPROTECTED = 'XBF';

    /**
     * Bag
     */
    case REC21_BAG = 'XBG';

    /**
     * Bunch
     */
    case REC21_BUNCH = 'XBH';

    /**
     * Bin
     */
    case REC21_BIN = 'XBI';

    /**
     * Bucket
     */
    case REC21_BUCKET = 'XBJ';

    /**
     * Basket
     */
    case REC21_BASKET = 'XBK';

    /**
     * Bale, compressed
     */
    case REC21_BALE_COMPRESSED = 'XBL';

    /**
     * Basin
     */
    case REC21_BASIN = 'XBM';

    /**
     * Bale, non-compressed
     */
    case REC21_BALE_NONCOMPRESSED = 'XBN';

    /**
     * Bottle, non-protected, cylindrical
     */
    case REC21_BOTTLE_NONPROTECTED_CYLINDRICAL = 'XBO';

    /**
     * Balloon, protected
     */
    case REC21_BALLOON_PROTECTED = 'XBP';

    /**
     * Bottle, protected cylindrical
     */
    case REC21_BOTTLE_PROTECTED_CYLINDRICAL = 'XBQ';

    /**
     * Bar
     */
    case REC21_BAR = 'XBR';

    /**
     * Bottle, non-protected, bulbous
     */
    case REC21_BOTTLE_NONPROTECTED_BULBOUS = 'XBS';

    /**
     * Bolt
     */
    case REC21_BOLT = 'XBT';

    /**
     * Butt
     */
    case REC21_BUTT = 'XBU';

    /**
     * Bottle, protected bulbous
     */
    case REC21_BOTTLE_PROTECTED_BULBOUS = 'XBV';

    /**
     * Box, for liquids
     */
    case REC21_BOX_FOR_LIQUIDS = 'XBW';

    /**
     * Box
     */
    case REC21_BOX = 'XBX';

    /**
     * Board, in bundle/bunch/truss
     */
    case REC21_BOARD_IN_BUNDLE_BUNCH_TRUSS = 'XBY';

    /**
     * Bars, in bundle/bunch/truss
     */
    case REC21_BARS_IN_BUNDLE_BUNCH_TRUSS = 'XBZ';

    /**
     * Can, rectangular
     */
    case REC21_CAN_RECTANGULAR = 'XCA';

    /**
     * Crate, beer
     */
    case REC21_CRATE_BEER = 'XCB';

    /**
     * Churn
     */
    case REC21_CHURN = 'XCC';

    /**
     * Can, with handle and spout
     */
    case REC21_CAN_WITH_HANDLE_AND_SPOUT = 'XCD';

    /**
     * Creel
     */
    case REC21_CREEL = 'XCE';

    /**
     * Coffer
     */
    case REC21_COFFER = 'XCF';

    /**
     * Cage
     */
    case REC21_CAGE = 'XCG';

    /**
     * Chest
     */
    case REC21_CHEST = 'XCH';

    /**
     * Canister
     */
    case REC21_CANISTER = 'XCI';

    /**
     * Coffin
     */
    case REC21_COFFIN = 'XCJ';

    /**
     * Cask
     */
    case REC21_CASK = 'XCK';

    /**
     * Coil
     */
    case REC21_COIL = 'XCL';

    /**
     * Card
     */
    case REC21_CARD = 'XCM';

    /**
     * Container, not otherwise specified as transport equipment
     */
    case REC21_CONTAINER_NOT_OTHERWISE_SPECIFIED_AS_TRANSPORT_EQUIPMENT = 'XCN';

    /**
     * Carboy, non-protected
     */
    case REC21_CARBOY_NONPROTECTED = 'XCO';

    /**
     * Carboy, protected
     */
    case REC21_CARBOY_PROTECTED = 'XCP';

    /**
     * Cartridge
     */
    case REC21_CARTRIDGE = 'XCQ';

    /**
     * Crate
     */
    case REC21_CRATE = 'XCR';

    /**
     * Case
     */
    case REC21_CASE = 'XCS';

    /**
     * Carton
     */
    case REC21_CARTON = 'XCT';

    /**
     * Cup
     */
    case REC21_CUP = 'XCU';

    /**
     * Cover
     */
    case REC21_COVER = 'XCV';

    /**
     * Cage, roll
     */
    case REC21_CAGE_ROLL = 'XCW';

    /**
     * Can, cylindrical
     */
    case REC21_CAN_CYLINDRICAL = 'XCX';

    /**
     * Cylinder
     */
    case REC21_CYLINDER = 'XCY';

    /**
     * Canvas
     */
    case REC21_CANVAS = 'XCZ';

    /**
     * Crate, multiple layer, plastic
     */
    case REC21_CRATE_MULTIPLE_LAYER_PLASTIC = 'XDA';

    /**
     * Crate, multiple layer, wooden
     */
    case REC21_CRATE_MULTIPLE_LAYER_WOODEN = 'XDB';

    /**
     * Crate, multiple layer, cardboard
     */
    case REC21_CRATE_MULTIPLE_LAYER_CARDBOARD = 'XDC';

    /**
     * Cage, Commonwealth Handling Equipment Pool  (CHEP)
     */
    case REC21_CAGE_COMMONWEALTH_HANDLING_EQUIPMENT_POOL__CHEP = 'XDG';

    /**
     * Box, Commonwealth Handling Equipment Pool (CHEP), Eurobox
     */
    case REC21_BOX_COMMONWEALTH_HANDLING_EQUIPMENT_POOL_CHEP_EUROBOX = 'XDH';

    /**
     * Drum, iron
     */
    case REC21_DRUM_IRON = 'XDI';

    /**
     * Demijohn, non-protected
     */
    case REC21_DEMIJOHN_NONPROTECTED = 'XDJ';

    /**
     * Crate, bulk, cardboard
     */
    case REC21_CRATE_BULK_CARDBOARD = 'XDK';

    /**
     * Crate, bulk, plastic
     */
    case REC21_CRATE_BULK_PLASTIC = 'XDL';

    /**
     * Crate, bulk, wooden
     */
    case REC21_CRATE_BULK_WOODEN = 'XDM';

    /**
     * Dispenser
     */
    case REC21_DISPENSER = 'XDN';

    /**
     * Demijohn, protected
     */
    case REC21_DEMIJOHN_PROTECTED = 'XDP';

    /**
     * Drum
     */
    case REC21_DRUM = 'XDR';

    /**
     * Tray, one layer no cover, plastic
     */
    case REC21_TRAY_ONE_LAYER_NO_COVER_PLASTIC = 'XDS';

    /**
     * Tray, one layer no cover, wooden
     */
    case REC21_TRAY_ONE_LAYER_NO_COVER_WOODEN = 'XDT';

    /**
     * Tray, one layer no cover, polystyrene
     */
    case REC21_TRAY_ONE_LAYER_NO_COVER_POLYSTYRENE = 'XDU';

    /**
     * Tray, one layer no cover, cardboard
     */
    case REC21_TRAY_ONE_LAYER_NO_COVER_CARDBOARD = 'XDV';

    /**
     * Tray, two layers no cover, plastic tray
     */
    case REC21_TRAY_TWO_LAYERS_NO_COVER_PLASTIC_TRAY = 'XDW';

    /**
     * Tray, two layers no cover, wooden
     */
    case REC21_TRAY_TWO_LAYERS_NO_COVER_WOODEN = 'XDX';

    /**
     * Tray, two layers no cover, cardboard
     */
    case REC21_TRAY_TWO_LAYERS_NO_COVER_CARDBOARD = 'XDY';

    /**
     * Bag, plastic
     */
    case REC21_BAG_PLASTIC = 'XEC';

    /**
     * Case, with pallet base
     */
    case REC21_CASE_WITH_PALLET_BASE = 'XED';

    /**
     * Case, with pallet base, wooden
     */
    case REC21_CASE_WITH_PALLET_BASE_WOODEN = 'XEE';

    /**
     * Case, with pallet base, cardboard
     */
    case REC21_CASE_WITH_PALLET_BASE_CARDBOARD = 'XEF';

    /**
     * Case, with pallet base, plastic
     */
    case REC21_CASE_WITH_PALLET_BASE_PLASTIC = 'XEG';

    /**
     * Case, with pallet base, metal
     */
    case REC21_CASE_WITH_PALLET_BASE_METAL = 'XEH';

    /**
     * Case, isothermic
     */
    case REC21_CASE_ISOTHERMIC = 'XEI';

    /**
     * Envelope
     */
    case REC21_ENVELOPE = 'XEN';

    /**
     * Flexibag
     */
    case REC21_FLEXIBAG = 'XFB';

    /**
     * Crate, fruit
     */
    case REC21_CRATE_FRUIT = 'XFC';

    /**
     * Crate, framed
     */
    case REC21_CRATE_FRAMED = 'XFD';

    /**
     * Flexitank
     */
    case REC21_FLEXITANK = 'XFE';

    /**
     * Firkin
     */
    case REC21_FIRKIN = 'XFI';

    /**
     * Flask
     */
    case REC21_FLASK = 'XFL';

    /**
     * Footlocker
     */
    case REC21_FOOTLOCKER = 'XFO';

    /**
     * Filmpack
     */
    case REC21_FILMPACK = 'XFP';

    /**
     * Frame
     */
    case REC21_FRAME = 'XFR';

    /**
     * Foodtainer
     */
    case REC21_FOODTAINER = 'XFT';

    /**
     * Cart, flatbed
     */
    case REC21_CART_FLATBED = 'XFW';

    /**
     * Bag, flexible container
     */
    case REC21_BAG_FLEXIBLE_CONTAINER = 'XFX';

    /**
     * Bottle, gas
     */
    case REC21_BOTTLE_GAS = 'XGB';

    /**
     * Girder
     */
    case REC21_GIRDER = 'XGI';

    /**
     * Container, gallon
     */
    case REC21_CONTAINER_GALLON = 'XGL';

    /**
     * Receptacle, glass
     */
    case REC21_RECEPTACLE_GLASS = 'XGR';

    /**
     * Tray, containing horizontally stacked flat items
     */
    case REC21_TRAY_CONTAINING_HORIZONTALLY_STACKED_FLAT_ITEMS = 'XGU';

    /**
     * Bag, gunny
     */
    case REC21_BAG_GUNNY = 'XGY';

    /**
     * Girders, in bundle/bunch/truss
     */
    case REC21_GIRDERS_IN_BUNDLE_BUNCH_TRUSS = 'XGZ';

    /**
     * Basket, with handle, plastic
     */
    case REC21_BASKET_WITH_HANDLE_PLASTIC = 'XHA';

    /**
     * Basket, with handle, wooden
     */
    case REC21_BASKET_WITH_HANDLE_WOODEN = 'XHB';

    /**
     * Basket, with handle, cardboard
     */
    case REC21_BASKET_WITH_HANDLE_CARDBOARD = 'XHC';

    /**
     * Hogshead
     */
    case REC21_HOGSHEAD = 'XHG';

    /**
     * Hanger
     */
    case REC21_HANGER = 'XHN';

    /**
     * Hamper
     */
    case REC21_HAMPER = 'XHR';

    /**
     * Package, display, wooden
     */
    case REC21_PACKAGE_DISPLAY_WOODEN = 'XIA';

    /**
     * Package, display, cardboard
     */
    case REC21_PACKAGE_DISPLAY_CARDBOARD = 'XIB';

    /**
     * Package, display, plastic
     */
    case REC21_PACKAGE_DISPLAY_PLASTIC = 'XIC';

    /**
     * Package, display, metal
     */
    case REC21_PACKAGE_DISPLAY_METAL = 'XID';

    /**
     * Package, show
     */
    case REC21_PACKAGE_SHOW = 'XIE';

    /**
     * Package, flow
     */
    case REC21_PACKAGE_FLOW = 'XIF';

    /**
     * Package, paper wrapped
     */
    case REC21_PACKAGE_PAPER_WRAPPED = 'XIG';

    /**
     * Drum, plastic
     */
    case REC21_DRUM_PLASTIC = 'XIH';

    /**
     * Package, cardboard, with bottle grip-holes
     */
    case REC21_PACKAGE_CARDBOARD_WITH_BOTTLE_GRIPHOLES = 'XIK';

    /**
     * Tray, rigid, lidded stackable (CEN TS 14482:2002)
     */
    case REC21_TRAY_RIGID_LIDDED_STACKABLE_CEN_TS_144822002 = 'XIL';

    /**
     * Ingot
     */
    case REC21_INGOT = 'XIN';

    /**
     * Ingots, in bundle/bunch/truss
     */
    case REC21_INGOTS_IN_BUNDLE_BUNCH_TRUSS = 'XIZ';

    /**
     * Bag, jumbo
     */
    case REC21_BAG_JUMBO = 'XJB';

    /**
     * Jerrican, rectangular
     */
    case REC21_JERRICAN_RECTANGULAR = 'XJC';

    /**
     * Jug
     */
    case REC21_JUG = 'XJG';

    /**
     * Jar
     */
    case REC21_JAR = 'XJR';

    /**
     * Jutebag
     */
    case REC21_JUTEBAG = 'XJT';

    /**
     * Jerrican, cylindrical
     */
    case REC21_JERRICAN_CYLINDRICAL = 'XJY';

    /**
     * Keg
     */
    case REC21_KEG = 'XKG';

    /**
     * Kit
     */
    case REC21_KIT = 'XKI';

    /**
     * Luggage
     */
    case REC21_LUGGAGE = 'XLE';

    /**
     * Log
     */
    case REC21_LOG = 'XLG';

    /**
     * Lot
     */
    case REC21_LOT = 'XLT';

    /**
     * Lug
     */
    case REC21_LUG = 'XLU';

    /**
     * Liftvan
     */
    case REC21_LIFTVAN = 'XLV';

    /**
     * Logs, in bundle/bunch/truss
     */
    case REC21_LOGS_IN_BUNDLE_BUNCH_TRUSS = 'XLZ';

    /**
     * Crate, metal
     */
    case REC21_CRATE_METAL = 'XMA';

    /**
     * Bag, multiply
     */
    case REC21_BAG_MULTIPLY = 'XMB';

    /**
     * Crate, milk
     */
    case REC21_CRATE_MILK = 'XMC';

    /**
     * Container, metal
     */
    case REC21_CONTAINER_METAL = 'XME';

    /**
     * Receptacle, metal
     */
    case REC21_RECEPTACLE_METAL = 'XMR';

    /**
     * Sack, multi-wall
     */
    case REC21_SACK_MULTIWALL = 'XMS';

    /**
     * Mat
     */
    case REC21_MAT = 'XMT';

    /**
     * Receptacle, plastic wrapped
     */
    case REC21_RECEPTACLE_PLASTIC_WRAPPED = 'XMW';

    /**
     * Matchbox
     */
    case REC21_MATCHBOX = 'XMX';

    /**
     * Not available
     */
    case REC21_NOT_AVAILABLE = 'XNA';

    /**
     * Unpacked or unpackaged
     */
    case REC21_UNPACKED_OR_UNPACKAGED = 'XNE';

    /**
     * Unpacked or unpackaged, single unit
     */
    case REC21_UNPACKED_OR_UNPACKAGED_SINGLE_UNIT = 'XNF';

    /**
     * Unpacked or unpackaged, multiple units
     */
    case REC21_UNPACKED_OR_UNPACKAGED_MULTIPLE_UNITS = 'XNG';

    /**
     * Nest
     */
    case REC21_NEST = 'XNS';

    /**
     * Net
     */
    case REC21_NET = 'XNT';

    /**
     * Net, tube, plastic
     */
    case REC21_NET_TUBE_PLASTIC = 'XNU';

    /**
     * Net, tube, textile
     */
    case REC21_NET_TUBE_TEXTILE = 'XNV';

    /**
     * Pallet, CHEP 40 cm x 60 cm
     */
    case REC21_PALLET_CHEP_40_CM_X_60_CM = 'XOA';

    /**
     * Pallet, CHEP 80 cm x 120 cm
     */
    case REC21_PALLET_CHEP_80_CM_X_120_CM = 'XOB';

    /**
     * Pallet, CHEP 100 cm x 120 cm
     */
    case REC21_PALLET_CHEP_100_CM_X_120_CM = 'XOC';

    /**
     * Pallet, AS 4068-1993
     */
    case REC21_PALLET_AS_40681993 = 'XOD';

    /**
     * Pallet, ISO T11
     */
    case REC21_PALLET_ISO_T11 = 'XOE';

    /**
     * Platform, unspecified weight or dimension
     */
    case REC21_PLATFORM_UNSPECIFIED_WEIGHT_OR_DIMENSION = 'XOF';

    /**
     * Block
     */
    case REC21_BLOCK = 'XOK';

    /**
     * Octabin
     */
    case REC21_OCTABIN = 'XOT';

    /**
     * Container, outer
     */
    case REC21_CONTAINER_OUTER = 'XOU';

    /**
     * Pan
     */
    case REC21_PAN = 'XP2';

    /**
     * Packet
     */
    case REC21_PACKET = 'XPA';

    /**
     * Pallet, box Combined open-ended box and pallet
     */
    case REC21_PALLET_BOX_COMBINED_OPENENDED_BOX_AND_PALLET = 'XPB';

    /**
     * Parcel
     */
    case REC21_PARCEL = 'XPC';

    /**
     * Pallet, modular, collars 80cms * 100cms
     */
    case REC21_PALLET_MODULAR_COLLARS_80CMS__100CMS = 'XPD';

    /**
     * Pallet, modular, collars 80cms * 120cms
     */
    case REC21_PALLET_MODULAR_COLLARS_80CMS__120CMS = 'XPE';

    /**
     * Pen
     */
    case REC21_PEN = 'XPF';

    /**
     * Plate
     */
    case REC21_PLATE = 'XPG';

    /**
     * Pitcher
     */
    case REC21_PITCHER = 'XPH';

    /**
     * Pipe
     */
    case REC21_PIPE = 'XPI';

    /**
     * Punnet
     */
    case REC21_PUNNET = 'XPJ';

    /**
     * Package
     */
    case REC21_PACKAGE = 'XPK';

    /**
     * Pail
     */
    case REC21_PAIL = 'XPL';

    /**
     * Plank
     */
    case REC21_PLANK = 'XPN';

    /**
     * Pouch
     */
    case REC21_POUCH = 'XPO';

    /**
     * Piece
     */
    case REC21_PIECE = 'XPP';

    /**
     * Receptacle, plastic
     */
    case REC21_RECEPTACLE_PLASTIC = 'XPR';

    /**
     * Pot
     */
    case REC21_POT = 'XPT';

    /**
     * Tray
     */
    case REC21_TRAY = 'XPU';

    /**
     * Pipes, in bundle/bunch/truss
     */
    case REC21_PIPES_IN_BUNDLE_BUNCH_TRUSS = 'XPV';

    /**
     * Pallet
     */
    case REC21_PALLET = 'XPX';

    /**
     * Plates, in bundle/bunch/truss
     */
    case REC21_PLATES_IN_BUNDLE_BUNCH_TRUSS = 'XPY';

    /**
     * Planks, in bundle/bunch/truss
     */
    case REC21_PLANKS_IN_BUNDLE_BUNCH_TRUSS = 'XPZ';

    /**
     * Drum, steel, non-removable head
     */
    case REC21_DRUM_STEEL_NONREMOVABLE_HEAD = 'XQA';

    /**
     * Drum, steel, removable head
     */
    case REC21_DRUM_STEEL_REMOVABLE_HEAD = 'XQB';

    /**
     * Drum, aluminium, non-removable head
     */
    case REC21_DRUM_ALUMINIUM_NONREMOVABLE_HEAD = 'XQC';

    /**
     * Drum, aluminium, removable head
     */
    case REC21_DRUM_ALUMINIUM_REMOVABLE_HEAD = 'XQD';

    /**
     * Drum, plastic, non-removable head
     */
    case REC21_DRUM_PLASTIC_NONREMOVABLE_HEAD = 'XQF';

    /**
     * Drum, plastic, removable head
     */
    case REC21_DRUM_PLASTIC_REMOVABLE_HEAD = 'XQG';

    /**
     * Barrel, wooden, bung type
     */
    case REC21_BARREL_WOODEN_BUNG_TYPE = 'XQH';

    /**
     * Barrel, wooden, removable head
     */
    case REC21_BARREL_WOODEN_REMOVABLE_HEAD = 'XQJ';

    /**
     * Jerrican, steel, non-removable head
     */
    case REC21_JERRICAN_STEEL_NONREMOVABLE_HEAD = 'XQK';

    /**
     * Jerrican, steel, removable head
     */
    case REC21_JERRICAN_STEEL_REMOVABLE_HEAD = 'XQL';

    /**
     * Jerrican, plastic, non-removable head
     */
    case REC21_JERRICAN_PLASTIC_NONREMOVABLE_HEAD = 'XQM';

    /**
     * Jerrican, plastic, removable head
     */
    case REC21_JERRICAN_PLASTIC_REMOVABLE_HEAD = 'XQN';

    /**
     * Box, wooden, natural wood, ordinary
     */
    case REC21_BOX_WOODEN_NATURAL_WOOD_ORDINARY = 'XQP';

    /**
     * Box, wooden, natural wood, with sift proof walls
     */
    case REC21_BOX_WOODEN_NATURAL_WOOD_WITH_SIFT_PROOF_WALLS = 'XQQ';

    /**
     * Box, plastic, expanded
     */
    case REC21_BOX_PLASTIC_EXPANDED = 'XQR';

    /**
     * Box, plastic, solid
     */
    case REC21_BOX_PLASTIC_SOLID = 'XQS';

    /**
     * Rod
     */
    case REC21_ROD = 'XRD';

    /**
     * Ring
     */
    case REC21_RING = 'XRG';

    /**
     * Rack, clothing hanger
     */
    case REC21_RACK_CLOTHING_HANGER = 'XRJ';

    /**
     * Rack
     */
    case REC21_RACK = 'XRK';

    /**
     * Reel
     */
    case REC21_REEL = 'XRL';

    /**
     * Roll
     */
    case REC21_ROLL = 'XRO';

    /**
     * Rednet
     */
    case REC21_REDNET = 'XRT';

    /**
     * Rods, in bundle/bunch/truss
     */
    case REC21_RODS_IN_BUNDLE_BUNCH_TRUSS = 'XRZ';

    /**
     * Sack
     */
    case REC21_SACK = 'XSA';

    /**
     * Slab
     */
    case REC21_SLAB = 'XSB';

    /**
     * Crate, shallow
     */
    case REC21_CRATE_SHALLOW = 'XSC';

    /**
     * Spindle
     */
    case REC21_SPINDLE = 'XSD';

    /**
     * Sea-chest
     */
    case REC21_SEACHEST = 'XSE';

    /**
     * Sachet
     */
    case REC21_SACHET = 'XSH';

    /**
     * Skid
     */
    case REC21_SKID = 'XSI';

    /**
     * Case, skeleton
     */
    case REC21_CASE_SKELETON = 'XSK';

    /**
     * Slipsheet
     */
    case REC21_SLIPSHEET = 'XSL';

    /**
     * Sheetmetal
     */
    case REC21_SHEETMETAL = 'XSM';

    /**
     * Spool
     */
    case REC21_SPOOL = 'XSO';

    /**
     * Sheet, plastic wrapping
     */
    case REC21_SHEET_PLASTIC_WRAPPING = 'XSP';

    /**
     * Case, steel
     */
    case REC21_CASE_STEEL = 'XSS';

    /**
     * Sheet
     */
    case REC21_SHEET = 'XST';

    /**
     * Suitcase
     */
    case REC21_SUITCASE = 'XSU';

    /**
     * Envelope, steel
     */
    case REC21_ENVELOPE_STEEL = 'XSV';

    /**
     * Shrinkwrapped
     */
    case REC21_SHRINKWRAPPED = 'XSW';

    /**
     * Sleeve
     */
    case REC21_SLEEVE = 'XSY';

    /**
     * Sheets, in bundle/bunch/truss
     */
    case REC21_SHEETS_IN_BUNDLE_BUNCH_TRUSS = 'XSZ';

    /**
     * Tablet
     */
    case REC21_TABLET = 'XT1';

    /**
     * Tub
     */
    case REC21_TUB = 'XTB';

    /**
     * Tea-chest
     */
    case REC21_TEACHEST = 'XTC';

    /**
     * Tube, collapsible
     */
    case REC21_TUBE_COLLAPSIBLE = 'XTD';

    /**
     * Tyre
     */
    case REC21_TYRE = 'XTE';

    /**
     * Tank container, generic
     */
    case REC21_TANK_CONTAINER_GENERIC = 'XTG';

    /**
     * Tierce
     */
    case REC21_TIERCE = 'XTI';

    /**
     * Tank, rectangular
     */
    case REC21_TANK_RECTANGULAR = 'XTK';

    /**
     * Tub, with lid
     */
    case REC21_TUB_WITH_LID = 'XTL';

    /**
     * Tin
     */
    case REC21_TIN = 'XTN';

    /**
     * Tun
     */
    case REC21_TUN = 'XTO';

    /**
     * Trunk
     */
    case REC21_TRUNK = 'XTR';

    /**
     * Truss
     */
    case REC21_TRUSS = 'XTS';

    /**
     * Bag, tote
     */
    case REC21_BAG_TOTE = 'XTT';

    /**
     * Tube
     */
    case REC21_TUBE = 'XTU';

    /**
     * Tube, with nozzle
     */
    case REC21_TUBE_WITH_NOZZLE = 'XTV';

    /**
     * Pallet, triwall
     */
    case REC21_PALLET_TRIWALL = 'XTW';

    /**
     * Tank, cylindrical
     */
    case REC21_TANK_CYLINDRICAL = 'XTY';

    /**
     * Tubes, in bundle/bunch/truss
     */
    case REC21_TUBES_IN_BUNDLE_BUNCH_TRUSS = 'XTZ';

    /**
     * Uncaged
     */
    case REC21_UNCAGED = 'XUC';

    /**
     * Unit
     */
    case REC21_UNIT = 'XUN';

    /**
     * Vat
     */
    case REC21_VAT = 'XVA';

    /**
     * Bulk, gas (at 1031 mbar and 15°C)
     */
    case REC21_BULK_GAS_AT_1031_MBAR_AND_15C = 'XVG';

    /**
     * Vial
     */
    case REC21_VIAL = 'XVI';

    /**
     * Vanpack
     */
    case REC21_VANPACK = 'XVK';

    /**
     * Bulk, liquid
     */
    case REC21_BULK_LIQUID = 'XVL';

    /**
     * Bulk, solid, large particles (“nodules”)
     */
    case REC21_BULK_SOLID_LARGE_PARTICLES_NODULES = 'XVO';

    /**
     * Vacuum-packed
     */
    case REC21_VACUUMPACKED = 'XVP';

    /**
     * Bulk, liquefied gas (at abnormal temperature/pressure)
     */
    case REC21_BULK_LIQUEFIED_GAS_AT_ABNORMAL_TEMPERATURE_PRESSURE = 'XVQ';

    /**
     * Vehicle
     */
    case REC21_VEHICLE = 'XVN';

    /**
     * Bulk, solid, granular particles (“grains”)
     */
    case REC21_BULK_SOLID_GRANULAR_PARTICLES_GRAINS = 'XVR';

    /**
     * Bulk, scrap metal
     */
    case REC21_BULK_SCRAP_METAL = 'XVS';

    /**
     * Bulk, solid, fine particles (“powders”)
     */
    case REC21_BULK_SOLID_FINE_PARTICLES_POWDERS = 'XVY';

    /**
     * Intermediate bulk container
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER = 'XWA';

    /**
     * Wickerbottle
     */
    case REC21_WICKERBOTTLE = 'XWB';

    /**
     * Intermediate bulk container, steel
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_STEEL = 'XWC';

    /**
     * Intermediate bulk container, aluminium
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_ALUMINIUM = 'XWD';

    /**
     * Intermediate bulk container, metal
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_METAL = 'XWF';

    /**
     * Intermediate bulk container, steel, pressurised > 10 kpa
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_STEEL_PRESSURISED__10_KPA = 'XWG';

    /**
     * Intermediate bulk container, aluminium, pressurised > 10 kpa
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_ALUMINIUM_PRESSURISED__10_KPA = 'XWH';

    /**
     * Intermediate bulk container, metal, pressure 10 kpa
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_METAL_PRESSURE_10_KPA = 'XWJ';

    /**
     * Intermediate bulk container, steel, liquid
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_STEEL_LIQUID = 'XWK';

    /**
     * Intermediate bulk container, aluminium, liquid
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_ALUMINIUM_LIQUID = 'XWL';

    /**
     * Intermediate bulk container, metal, liquid
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_METAL_LIQUID = 'XWM';

    /**
     * Intermediate bulk container, woven plastic, without coat/liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_WOVEN_PLASTIC_WITHOUT_COAT_LINER = 'XWN';

    /**
     * Intermediate bulk container, woven plastic, coated
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_WOVEN_PLASTIC_COATED = 'XWP';

    /**
     * Intermediate bulk container, woven plastic, with liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_WOVEN_PLASTIC_WITH_LINER = 'XWQ';

    /**
     * Intermediate bulk container, woven plastic, coated and liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_WOVEN_PLASTIC_COATED_AND_LINER = 'XWR';

    /**
     * Intermediate bulk container, plastic film
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_PLASTIC_FILM = 'XWS';

    /**
     * Intermediate bulk container, textile with out coat/liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_TEXTILE_WITH_OUT_COAT_LINER = 'XWT';

    /**
     * Intermediate bulk container, natural wood, with inner liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_NATURAL_WOOD_WITH_INNER_LINER = 'XWU';

    /**
     * Intermediate bulk container, textile, coated
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_TEXTILE_COATED = 'XWV';

    /**
     * Intermediate bulk container, textile, with liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_TEXTILE_WITH_LINER = 'XWW';

    /**
     * Intermediate bulk container, textile, coated and liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_TEXTILE_COATED_AND_LINER = 'XWX';

    /**
     * Intermediate bulk container, plywood, with inner liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_PLYWOOD_WITH_INNER_LINER = 'XWY';

    /**
     * Intermediate bulk container, reconstituted wood, with inner liner
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RECONSTITUTED_WOOD_WITH_INNER_LINER = 'XWZ';

    /**
     * Bag, woven plastic, without inner coat/liner
     */
    case REC21_BAG_WOVEN_PLASTIC_WITHOUT_INNER_COAT_LINER = 'XXA';

    /**
     * Bag, woven plastic, sift proof
     */
    case REC21_BAG_WOVEN_PLASTIC_SIFT_PROOF = 'XXB';

    /**
     * Bag, woven plastic, water resistant
     */
    case REC21_BAG_WOVEN_PLASTIC_WATER_RESISTANT = 'XXC';

    /**
     * Bag, plastics film
     */
    case REC21_BAG_PLASTICS_FILM = 'XXD';

    /**
     * Bag, textile, without inner coat/liner
     */
    case REC21_BAG_TEXTILE_WITHOUT_INNER_COAT_LINER = 'XXF';

    /**
     * Bag, textile, sift proof
     */
    case REC21_BAG_TEXTILE_SIFT_PROOF = 'XXG';

    /**
     * Bag, textile, water resistant
     */
    case REC21_BAG_TEXTILE_WATER_RESISTANT = 'XXH';

    /**
     * Bag, paper, multi-wall
     */
    case REC21_BAG_PAPER_MULTIWALL = 'XXJ';

    /**
     * Bag, paper, multi-wall, water resistant
     */
    case REC21_BAG_PAPER_MULTIWALL_WATER_RESISTANT = 'XXK';

    /**
     * Composite packaging, plastic receptacle in steel drum
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_STEEL_DRUM = 'XYA';

    /**
     * Composite packaging, plastic receptacle in steel crate box
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_STEEL_CRATE_BOX = 'XYB';

    /**
     * Composite packaging, plastic receptacle in aluminium drum
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_ALUMINIUM_DRUM = 'XYC';

    /**
     * Composite packaging, plastic receptacle in aluminium crate
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_ALUMINIUM_CRATE = 'XYD';

    /**
     * Composite packaging, plastic receptacle in wooden box
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_WOODEN_BOX = 'XYF';

    /**
     * Composite packaging, plastic receptacle in plywood drum
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_PLYWOOD_DRUM = 'XYG';

    /**
     * Composite packaging, plastic receptacle in plywood box
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_PLYWOOD_BOX = 'XYH';

    /**
     * Composite packaging, plastic receptacle in fibre drum
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_FIBRE_DRUM = 'XYJ';

    /**
     * Composite packaging, plastic receptacle in fibreboard box
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_FIBREBOARD_BOX = 'XYK';

    /**
     * Composite packaging, plastic receptacle in plastic drum
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_PLASTIC_DRUM = 'XYL';

    /**
     * Composite packaging, plastic receptacle in solid plastic box
     */
    case REC21_COMPOSITE_PACKAGING_PLASTIC_RECEPTACLE_IN_SOLID_PLASTIC_BOX = 'XYM';

    /**
     * Composite packaging, glass receptacle in steel drum
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_STEEL_DRUM = 'XYN';

    /**
     * Composite packaging, glass receptacle in steel crate box
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_STEEL_CRATE_BOX = 'XYP';

    /**
     * Composite packaging, glass receptacle in aluminium drum
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_ALUMINIUM_DRUM = 'XYQ';

    /**
     * Composite packaging, glass receptacle in aluminium crate
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_ALUMINIUM_CRATE = 'XYR';

    /**
     * Composite packaging, glass receptacle in wooden box
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_WOODEN_BOX = 'XYS';

    /**
     * Composite packaging, glass receptacle in plywood drum
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_PLYWOOD_DRUM = 'XYT';

    /**
     * Composite packaging, glass receptacle in wickerwork hamper
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_WICKERWORK_HAMPER = 'XYV';

    /**
     * Composite packaging, glass receptacle in fibre drum
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_FIBRE_DRUM = 'XYW';

    /**
     * Composite packaging, glass receptacle in fibreboard box
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_FIBREBOARD_BOX = 'XYX';

    /**
     * Composite packaging, glass receptacle in expandable plastic pack
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_EXPANDABLE_PLASTIC_PACK = 'XYY';

    /**
     * Composite packaging, glass receptacle in solid plastic pack
     */
    case REC21_COMPOSITE_PACKAGING_GLASS_RECEPTACLE_IN_SOLID_PLASTIC_PACK = 'XYZ';

    /**
     * Intermediate bulk container, paper, multi-wall
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_PAPER_MULTIWALL = 'XZA';

    /**
     * Bag, large
     */
    case REC21_BAG_LARGE = 'XZB';

    /**
     * Intermediate bulk container, paper, multi-wall, water resistant
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_PAPER_MULTIWALL_WATER_RESISTANT = 'XZC';

    /**
     * Intermediate bulk container, rigid plastic, with structural equipment,
     * solids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC_WITH_STRUCTURAL_EQUIPMENT_SOLIDS = 'XZD';

    /**
     * Intermediate bulk container, rigid plastic, freestanding, solids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC_FREESTANDING_SOLIDS = 'XZF';

    /**
     * Intermediate bulk container, rigid plastic, with structural equipment,
     * pressurised
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC_WITH_STRUCTURAL_EQUIPMENT_PRESSURISED = 'XZG';

    /**
     * Intermediate bulk container, rigid plastic, freestanding, pressurised
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC_FREESTANDING_PRESSURISED = 'XZH';

    /**
     * Intermediate bulk container, rigid plastic, with structural equipment,
     * liquids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC_WITH_STRUCTURAL_EQUIPMENT_LIQUIDS = 'XZJ';

    /**
     * Intermediate bulk container, rigid plastic, freestanding, liquids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RIGID_PLASTIC_FREESTANDING_LIQUIDS = 'XZK';

    /**
     * Intermediate bulk container, composite, rigid plastic, solids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE_RIGID_PLASTIC_SOLIDS = 'XZL';

    /**
     * Intermediate bulk container, composite, flexible plastic, solids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE_FLEXIBLE_PLASTIC_SOLIDS = 'XZM';

    /**
     * Intermediate bulk container, composite, rigid plastic, pressurised
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE_RIGID_PLASTIC_PRESSURISED = 'XZN';

    /**
     * Intermediate bulk container, composite, flexible plastic, pressurised
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE_FLEXIBLE_PLASTIC_PRESSURISED = 'XZP';

    /**
     * Intermediate bulk container, composite, rigid plastic, liquids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE_RIGID_PLASTIC_LIQUIDS = 'XZQ';

    /**
     * Intermediate bulk container, composite, flexible plastic, liquids
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE_FLEXIBLE_PLASTIC_LIQUIDS = 'XZR';

    /**
     * Intermediate bulk container, composite
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_COMPOSITE = 'XZS';

    /**
     * Intermediate bulk container, fibreboard
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_FIBREBOARD = 'XZT';

    /**
     * Intermediate bulk container, flexible
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_FLEXIBLE = 'XZU';

    /**
     * Intermediate bulk container, metal, other than steel
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_METAL_OTHER_THAN_STEEL = 'XZV';

    /**
     * Intermediate bulk container, natural wood
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_NATURAL_WOOD = 'XZW';

    /**
     * Intermediate bulk container, plywood
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_PLYWOOD = 'XZX';

    /**
     * Intermediate bulk container, reconstituted wood
     */
    case REC21_INTERMEDIATE_BULK_CONTAINER_RECONSTITUTED_WOOD = 'XZY';

    /**
     * Mutually defined
     */
    case REC21_MUTUALLY_DEFINED = 'XZZ';
}
