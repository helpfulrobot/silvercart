<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Config
 */

// write country AD
if (!SilvercartCountry::get()->filter("ISO2", "AD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AD";
    $country->ISO3      = "AND";
    $country->FIPS      = "AN";
    $country->ISON      = "20";
    $country->Title     = _t("SilvercartCountry.TITLE_AD");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AE
if (!SilvercartCountry::get()->filter("ISO2", "AE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AE";
    $country->ISO3      = "ARE";
    $country->FIPS      = "AE";
    $country->ISON      = "784";
    $country->Title     = _t("SilvercartCountry.TITLE_AE");
    $country->Continent = "AS";
    $country->Currency  = "AED";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AF
if (!SilvercartCountry::get()->filter("ISO2", "AF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AF";
    $country->ISO3      = "AFG";
    $country->FIPS      = "AF";
    $country->ISON      = "4";
    $country->Title     = _t("SilvercartCountry.TITLE_AF");
    $country->Continent = "AS";
    $country->Currency  = "AFN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AG
if (!SilvercartCountry::get()->filter("ISO2", "AG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AG";
    $country->ISO3      = "ATG";
    $country->FIPS      = "AC";
    $country->ISON      = "28";
    $country->Title     = _t("SilvercartCountry.TITLE_AG");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AI
if (!SilvercartCountry::get()->filter("ISO2", "AI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AI";
    $country->ISO3      = "AIA";
    $country->FIPS      = "AV";
    $country->ISON      = "660";
    $country->Title     = _t("SilvercartCountry.TITLE_AI");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AL
if (!SilvercartCountry::get()->filter("ISO2", "AL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AL";
    $country->ISO3      = "ALB";
    $country->FIPS      = "AL";
    $country->ISON      = "8";
    $country->Title     = _t("SilvercartCountry.TITLE_AL");
    $country->Continent = "EU";
    $country->Currency  = "ALL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AM
if (!SilvercartCountry::get()->filter("ISO2", "AM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AM";
    $country->ISO3      = "ARM";
    $country->FIPS      = "AM";
    $country->ISON      = "51";
    $country->Title     = _t("SilvercartCountry.TITLE_AM");
    $country->Continent = "AS";
    $country->Currency  = "AMD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AN
if (!SilvercartCountry::get()->filter("ISO2", "AN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AN";
    $country->ISO3      = "ANT";
    $country->FIPS      = "NT";
    $country->ISON      = "530";
    $country->Title     = _t("SilvercartCountry.TITLE_AN");
    $country->Continent = "NA";
    $country->Currency  = "ANG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AO
if (!SilvercartCountry::get()->filter("ISO2", "AO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AO";
    $country->ISO3      = "AGO";
    $country->FIPS      = "AO";
    $country->ISON      = "24";
    $country->Title     = _t("SilvercartCountry.TITLE_AO");
    $country->Continent = "AF";
    $country->Currency  = "AOA";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AQ
if (!SilvercartCountry::get()->filter("ISO2", "AQ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AQ";
    $country->ISO3      = "ATA";
    $country->FIPS      = "AY";
    $country->ISON      = "10";
    $country->Title     = _t("SilvercartCountry.TITLE_AQ");
    $country->Continent = "AN";
    $country->Currency  = "";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AR
if (!SilvercartCountry::get()->filter("ISO2", "AR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AR";
    $country->ISO3      = "ARG";
    $country->FIPS      = "AR";
    $country->ISON      = "32";
    $country->Title     = _t("SilvercartCountry.TITLE_AR");
    $country->Continent = "SA";
    $country->Currency  = "ARS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AS
if (!SilvercartCountry::get()->filter("ISO2", "AS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AS";
    $country->ISO3      = "ASM";
    $country->FIPS      = "AQ";
    $country->ISON      = "16";
    $country->Title     = _t("SilvercartCountry.TITLE_AS");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AT
if (!SilvercartCountry::get()->filter("ISO2", "AT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AT";
    $country->ISO3      = "AUT";
    $country->FIPS      = "AU";
    $country->ISON      = "40";
    $country->Title     = _t("SilvercartCountry.TITLE_AT");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AU
if (!SilvercartCountry::get()->filter("ISO2", "AU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AU";
    $country->ISO3      = "AUS";
    $country->FIPS      = "AS";
    $country->ISON      = "36";
    $country->Title     = _t("SilvercartCountry.TITLE_AU");
    $country->Continent = "OC";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AW
if (!SilvercartCountry::get()->filter("ISO2", "AW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AW";
    $country->ISO3      = "ABW";
    $country->FIPS      = "AA";
    $country->ISON      = "533";
    $country->Title     = _t("SilvercartCountry.TITLE_AW");
    $country->Continent = "NA";
    $country->Currency  = "AWG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AX
if (!SilvercartCountry::get()->filter("ISO2", "AX")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AX";
    $country->ISO3      = "ALA";
    $country->FIPS      = "";
    $country->ISON      = "248";
    $country->Title     = _t("SilvercartCountry.TITLE_AX");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country AZ
if (!SilvercartCountry::get()->filter("ISO2", "AZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "AZ";
    $country->ISO3      = "AZE";
    $country->FIPS      = "AJ";
    $country->ISON      = "31";
    $country->Title     = _t("SilvercartCountry.TITLE_AZ");
    $country->Continent = "AS";
    $country->Currency  = "AZN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BA
if (!SilvercartCountry::get()->filter("ISO2", "BA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BA";
    $country->ISO3      = "BIH";
    $country->FIPS      = "BK";
    $country->ISON      = "70";
    $country->Title     = _t("SilvercartCountry.TITLE_BA");
    $country->Continent = "EU";
    $country->Currency  = "BAM";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BB
if (!SilvercartCountry::get()->filter("ISO2", "BB")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BB";
    $country->ISO3      = "BRB";
    $country->FIPS      = "BB";
    $country->ISON      = "52";
    $country->Title     = _t("SilvercartCountry.TITLE_BB");
    $country->Continent = "NA";
    $country->Currency  = "BBD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BD
if (!SilvercartCountry::get()->filter("ISO2", "BD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BD";
    $country->ISO3      = "BGD";
    $country->FIPS      = "BG";
    $country->ISON      = "50";
    $country->Title     = _t("SilvercartCountry.TITLE_BD");
    $country->Continent = "AS";
    $country->Currency  = "BDT";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BE
if (!SilvercartCountry::get()->filter("ISO2", "BE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BE";
    $country->ISO3      = "BEL";
    $country->FIPS      = "BE";
    $country->ISON      = "56";
    $country->Title     = _t("SilvercartCountry.TITLE_BE");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BF
if (!SilvercartCountry::get()->filter("ISO2", "BF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BF";
    $country->ISO3      = "BFA";
    $country->FIPS      = "UV";
    $country->ISON      = "854";
    $country->Title     = _t("SilvercartCountry.TITLE_BF");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BG
if (!SilvercartCountry::get()->filter("ISO2", "BG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BG";
    $country->ISO3      = "BGR";
    $country->FIPS      = "BU";
    $country->ISON      = "100";
    $country->Title     = _t("SilvercartCountry.TITLE_BG");
    $country->Continent = "EU";
    $country->Currency  = "BGN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BH
if (!SilvercartCountry::get()->filter("ISO2", "BH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BH";
    $country->ISO3      = "BHR";
    $country->FIPS      = "BA";
    $country->ISON      = "48";
    $country->Title     = _t("SilvercartCountry.TITLE_BH");
    $country->Continent = "AS";
    $country->Currency  = "BHD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BI
if (!SilvercartCountry::get()->filter("ISO2", "BI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BI";
    $country->ISO3      = "BDI";
    $country->FIPS      = "BY";
    $country->ISON      = "108";
    $country->Title     = _t("SilvercartCountry.TITLE_BI");
    $country->Continent = "AF";
    $country->Currency  = "BIF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BJ
if (!SilvercartCountry::get()->filter("ISO2", "BJ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BJ";
    $country->ISO3      = "BEN";
    $country->FIPS      = "BN";
    $country->ISON      = "204";
    $country->Title     = _t("SilvercartCountry.TITLE_BJ");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BL
if (!SilvercartCountry::get()->filter("ISO2", "BL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BL";
    $country->ISO3      = "BLM";
    $country->FIPS      = "TB";
    $country->ISON      = "652";
    $country->Title     = _t("SilvercartCountry.TITLE_BL");
    $country->Continent = "NA";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BM
if (!SilvercartCountry::get()->filter("ISO2", "BM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BM";
    $country->ISO3      = "BMU";
    $country->FIPS      = "BD";
    $country->ISON      = "60";
    $country->Title     = _t("SilvercartCountry.TITLE_BM");
    $country->Continent = "NA";
    $country->Currency  = "BMD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BN
if (!SilvercartCountry::get()->filter("ISO2", "BN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BN";
    $country->ISO3      = "BRN";
    $country->FIPS      = "BX";
    $country->ISON      = "96";
    $country->Title     = _t("SilvercartCountry.TITLE_BN");
    $country->Continent = "AS";
    $country->Currency  = "BND";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BO
if (!SilvercartCountry::get()->filter("ISO2", "BO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BO";
    $country->ISO3      = "BOL";
    $country->FIPS      = "BL";
    $country->ISON      = "68";
    $country->Title     = _t("SilvercartCountry.TITLE_BO");
    $country->Continent = "SA";
    $country->Currency  = "BOB";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BQ
if (!SilvercartCountry::get()->filter("ISO2", "BQ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BQ";
    $country->ISO3      = "BES";
    $country->FIPS      = "";
    $country->ISON      = "535";
    $country->Title     = _t("SilvercartCountry.TITLE_BQ");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BR
if (!SilvercartCountry::get()->filter("ISO2", "BR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BR";
    $country->ISO3      = "BRA";
    $country->FIPS      = "BR";
    $country->ISON      = "76";
    $country->Title     = _t("SilvercartCountry.TITLE_BR");
    $country->Continent = "SA";
    $country->Currency  = "BRL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BS
if (!SilvercartCountry::get()->filter("ISO2", "BS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BS";
    $country->ISO3      = "BHS";
    $country->FIPS      = "BF";
    $country->ISON      = "44";
    $country->Title     = _t("SilvercartCountry.TITLE_BS");
    $country->Continent = "NA";
    $country->Currency  = "BSD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BT
if (!SilvercartCountry::get()->filter("ISO2", "BT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BT";
    $country->ISO3      = "BTN";
    $country->FIPS      = "BT";
    $country->ISON      = "64";
    $country->Title     = _t("SilvercartCountry.TITLE_BT");
    $country->Continent = "AS";
    $country->Currency  = "BTN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BV
if (!SilvercartCountry::get()->filter("ISO2", "BV")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BV";
    $country->ISO3      = "BVT";
    $country->FIPS      = "BV";
    $country->ISON      = "74";
    $country->Title     = _t("SilvercartCountry.TITLE_BV");
    $country->Continent = "AN";
    $country->Currency  = "NOK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BW
if (!SilvercartCountry::get()->filter("ISO2", "BW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BW";
    $country->ISO3      = "BWA";
    $country->FIPS      = "BC";
    $country->ISON      = "72";
    $country->Title     = _t("SilvercartCountry.TITLE_BW");
    $country->Continent = "AF";
    $country->Currency  = "BWP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BY
if (!SilvercartCountry::get()->filter("ISO2", "BY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BY";
    $country->ISO3      = "BLR";
    $country->FIPS      = "BO";
    $country->ISON      = "112";
    $country->Title     = _t("SilvercartCountry.TITLE_BY");
    $country->Continent = "EU";
    $country->Currency  = "BYR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country BZ
if (!SilvercartCountry::get()->filter("ISO2", "BZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "BZ";
    $country->ISO3      = "BLZ";
    $country->FIPS      = "BH";
    $country->ISON      = "84";
    $country->Title     = _t("SilvercartCountry.TITLE_BZ");
    $country->Continent = "NA";
    $country->Currency  = "BZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CA
if (!SilvercartCountry::get()->filter("ISO2", "CA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CA";
    $country->ISO3      = "CAN";
    $country->FIPS      = "CA";
    $country->ISON      = "124";
    $country->Title     = _t("SilvercartCountry.TITLE_CA");
    $country->Continent = "NA";
    $country->Currency  = "CAD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CC
if (!SilvercartCountry::get()->filter("ISO2", "CC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CC";
    $country->ISO3      = "CCK";
    $country->FIPS      = "CK";
    $country->ISON      = "166";
    $country->Title     = _t("SilvercartCountry.TITLE_CC");
    $country->Continent = "AS";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CD
if (!SilvercartCountry::get()->filter("ISO2", "CD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CD";
    $country->ISO3      = "COD";
    $country->FIPS      = "CG";
    $country->ISON      = "180";
    $country->Title     = _t("SilvercartCountry.TITLE_CD");
    $country->Continent = "AF";
    $country->Currency  = "CDF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CF
if (!SilvercartCountry::get()->filter("ISO2", "CF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CF";
    $country->ISO3      = "CAF";
    $country->FIPS      = "CT";
    $country->ISON      = "140";
    $country->Title     = _t("SilvercartCountry.TITLE_CF");
    $country->Continent = "AF";
    $country->Currency  = "XAF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CG
if (!SilvercartCountry::get()->filter("ISO2", "CG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CG";
    $country->ISO3      = "COG";
    $country->FIPS      = "CF";
    $country->ISON      = "178";
    $country->Title     = _t("SilvercartCountry.TITLE_CG");
    $country->Continent = "AF";
    $country->Currency  = "XAF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CH
if (!SilvercartCountry::get()->filter("ISO2", "CH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CH";
    $country->ISO3      = "CHE";
    $country->FIPS      = "SZ";
    $country->ISON      = "756";
    $country->Title     = _t("SilvercartCountry.TITLE_CH");
    $country->Continent = "EU";
    $country->Currency  = "CHF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CI
if (!SilvercartCountry::get()->filter("ISO2", "CI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CI";
    $country->ISO3      = "CIV";
    $country->FIPS      = "IV";
    $country->ISON      = "384";
    $country->Title     = _t("SilvercartCountry.TITLE_CI");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CK
if (!SilvercartCountry::get()->filter("ISO2", "CK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CK";
    $country->ISO3      = "COK";
    $country->FIPS      = "CW";
    $country->ISON      = "184";
    $country->Title     = _t("SilvercartCountry.TITLE_CK");
    $country->Continent = "OC";
    $country->Currency  = "NZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CL
if (!SilvercartCountry::get()->filter("ISO2", "CL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CL";
    $country->ISO3      = "CHL";
    $country->FIPS      = "CI";
    $country->ISON      = "152";
    $country->Title     = _t("SilvercartCountry.TITLE_CL");
    $country->Continent = "SA";
    $country->Currency  = "CLP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CM
if (!SilvercartCountry::get()->filter("ISO2", "CM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CM";
    $country->ISO3      = "CMR";
    $country->FIPS      = "CM";
    $country->ISON      = "120";
    $country->Title     = _t("SilvercartCountry.TITLE_CM");
    $country->Continent = "AF";
    $country->Currency  = "XAF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CN
if (!SilvercartCountry::get()->filter("ISO2", "CN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CN";
    $country->ISO3      = "CHN";
    $country->FIPS      = "CH";
    $country->ISON      = "156";
    $country->Title     = _t("SilvercartCountry.TITLE_CN");
    $country->Continent = "AS";
    $country->Currency  = "CNY";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CO
if (!SilvercartCountry::get()->filter("ISO2", "CO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CO";
    $country->ISO3      = "COL";
    $country->FIPS      = "CO";
    $country->ISON      = "170";
    $country->Title     = _t("SilvercartCountry.TITLE_CO");
    $country->Continent = "SA";
    $country->Currency  = "COP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CR
if (!SilvercartCountry::get()->filter("ISO2", "CR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CR";
    $country->ISO3      = "CRI";
    $country->FIPS      = "CS";
    $country->ISON      = "188";
    $country->Title     = _t("SilvercartCountry.TITLE_CR");
    $country->Continent = "NA";
    $country->Currency  = "CRC";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CS
if (!SilvercartCountry::get()->filter("ISO2", "CS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CS";
    $country->ISO3      = "SCG";
    $country->FIPS      = "YI";
    $country->ISON      = "891";
    $country->Title     = _t("SilvercartCountry.TITLE_CS");
    $country->Continent = "EU";
    $country->Currency  = "RSD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CU
if (!SilvercartCountry::get()->filter("ISO2", "CU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CU";
    $country->ISO3      = "CUB";
    $country->FIPS      = "CU";
    $country->ISON      = "192";
    $country->Title     = _t("SilvercartCountry.TITLE_CU");
    $country->Continent = "NA";
    $country->Currency  = "CUP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CV
if (!SilvercartCountry::get()->filter("ISO2", "CV")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CV";
    $country->ISO3      = "CPV";
    $country->FIPS      = "CV";
    $country->ISON      = "132";
    $country->Title     = _t("SilvercartCountry.TITLE_CV");
    $country->Continent = "AF";
    $country->Currency  = "CVE";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CW
if (!SilvercartCountry::get()->filter("ISO2", "CW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CW";
    $country->ISO3      = "CUW";
    $country->FIPS      = "UC";
    $country->ISON      = "531";
    $country->Title     = _t("SilvercartCountry.TITLE_CW");
    $country->Continent = "NA";
    $country->Currency  = "ANG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CX
if (!SilvercartCountry::get()->filter("ISO2", "CX")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CX";
    $country->ISO3      = "CXR";
    $country->FIPS      = "KT";
    $country->ISON      = "162";
    $country->Title     = _t("SilvercartCountry.TITLE_CX");
    $country->Continent = "AS";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CY
if (!SilvercartCountry::get()->filter("ISO2", "CY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CY";
    $country->ISO3      = "CYP";
    $country->FIPS      = "CY";
    $country->ISON      = "196";
    $country->Title     = _t("SilvercartCountry.TITLE_CY");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country CZ
if (!SilvercartCountry::get()->filter("ISO2", "CZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "CZ";
    $country->ISO3      = "CZE";
    $country->FIPS      = "EZ";
    $country->ISON      = "203";
    $country->Title     = _t("SilvercartCountry.TITLE_CZ");
    $country->Continent = "EU";
    $country->Currency  = "CZK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country DE
if (!SilvercartCountry::get()->filter("ISO2", "DE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "DE";
    $country->ISO3      = "DEU";
    $country->FIPS      = "GM";
    $country->ISON      = "276";
    $country->Title     = _t("SilvercartCountry.TITLE_DE");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country DJ
if (!SilvercartCountry::get()->filter("ISO2", "DJ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "DJ";
    $country->ISO3      = "DJI";
    $country->FIPS      = "DJ";
    $country->ISON      = "262";
    $country->Title     = _t("SilvercartCountry.TITLE_DJ");
    $country->Continent = "AF";
    $country->Currency  = "DJF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country DK
if (!SilvercartCountry::get()->filter("ISO2", "DK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "DK";
    $country->ISO3      = "DNK";
    $country->FIPS      = "DA";
    $country->ISON      = "208";
    $country->Title     = _t("SilvercartCountry.TITLE_DK");
    $country->Continent = "EU";
    $country->Currency  = "DKK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country DM
if (!SilvercartCountry::get()->filter("ISO2", "DM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "DM";
    $country->ISO3      = "DMA";
    $country->FIPS      = "DO";
    $country->ISON      = "212";
    $country->Title     = _t("SilvercartCountry.TITLE_DM");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country DO
if (!SilvercartCountry::get()->filter("ISO2", "DO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "DO";
    $country->ISO3      = "DOM";
    $country->FIPS      = "DR";
    $country->ISON      = "214";
    $country->Title     = _t("SilvercartCountry.TITLE_DO");
    $country->Continent = "NA";
    $country->Currency  = "DOP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country DZ
if (!SilvercartCountry::get()->filter("ISO2", "DZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "DZ";
    $country->ISO3      = "DZA";
    $country->FIPS      = "AG";
    $country->ISON      = "12";
    $country->Title     = _t("SilvercartCountry.TITLE_DZ");
    $country->Continent = "AF";
    $country->Currency  = "DZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country EC
if (!SilvercartCountry::get()->filter("ISO2", "EC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "EC";
    $country->ISO3      = "ECU";
    $country->FIPS      = "EC";
    $country->ISON      = "218";
    $country->Title     = _t("SilvercartCountry.TITLE_EC");
    $country->Continent = "SA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country EE
if (!SilvercartCountry::get()->filter("ISO2", "EE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "EE";
    $country->ISO3      = "EST";
    $country->FIPS      = "EN";
    $country->ISON      = "233";
    $country->Title     = _t("SilvercartCountry.TITLE_EE");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country EG
if (!SilvercartCountry::get()->filter("ISO2", "EG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "EG";
    $country->ISO3      = "EGY";
    $country->FIPS      = "EG";
    $country->ISON      = "818";
    $country->Title     = _t("SilvercartCountry.TITLE_EG");
    $country->Continent = "AF";
    $country->Currency  = "EGP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country EH
if (!SilvercartCountry::get()->filter("ISO2", "EH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "EH";
    $country->ISO3      = "ESH";
    $country->FIPS      = "WI";
    $country->ISON      = "732";
    $country->Title     = _t("SilvercartCountry.TITLE_EH");
    $country->Continent = "AF";
    $country->Currency  = "MAD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ER
if (!SilvercartCountry::get()->filter("ISO2", "ER")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ER";
    $country->ISO3      = "ERI";
    $country->FIPS      = "ER";
    $country->ISON      = "232";
    $country->Title     = _t("SilvercartCountry.TITLE_ER");
    $country->Continent = "AF";
    $country->Currency  = "ERN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ES
if (!SilvercartCountry::get()->filter("ISO2", "ES")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ES";
    $country->ISO3      = "ESP";
    $country->FIPS      = "SP";
    $country->ISON      = "724";
    $country->Title     = _t("SilvercartCountry.TITLE_ES");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ET
if (!SilvercartCountry::get()->filter("ISO2", "ET")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ET";
    $country->ISO3      = "ETH";
    $country->FIPS      = "ET";
    $country->ISON      = "231";
    $country->Title     = _t("SilvercartCountry.TITLE_ET");
    $country->Continent = "AF";
    $country->Currency  = "ETB";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country FI
if (!SilvercartCountry::get()->filter("ISO2", "FI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "FI";
    $country->ISO3      = "FIN";
    $country->FIPS      = "FI";
    $country->ISON      = "246";
    $country->Title     = _t("SilvercartCountry.TITLE_FI");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country FJ
if (!SilvercartCountry::get()->filter("ISO2", "FJ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "FJ";
    $country->ISO3      = "FJI";
    $country->FIPS      = "FJ";
    $country->ISON      = "242";
    $country->Title     = _t("SilvercartCountry.TITLE_FJ");
    $country->Continent = "OC";
    $country->Currency  = "FJD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country FK
if (!SilvercartCountry::get()->filter("ISO2", "FK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "FK";
    $country->ISO3      = "FLK";
    $country->FIPS      = "FK";
    $country->ISON      = "238";
    $country->Title     = _t("SilvercartCountry.TITLE_FK");
    $country->Continent = "SA";
    $country->Currency  = "FKP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country FM
if (!SilvercartCountry::get()->filter("ISO2", "FM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "FM";
    $country->ISO3      = "FSM";
    $country->FIPS      = "FM";
    $country->ISON      = "583";
    $country->Title     = _t("SilvercartCountry.TITLE_FM");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country FO
if (!SilvercartCountry::get()->filter("ISO2", "FO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "FO";
    $country->ISO3      = "FRO";
    $country->FIPS      = "FO";
    $country->ISON      = "234";
    $country->Title     = _t("SilvercartCountry.TITLE_FO");
    $country->Continent = "EU";
    $country->Currency  = "DKK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country FR
if (!SilvercartCountry::get()->filter("ISO2", "FR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "FR";
    $country->ISO3      = "FRA";
    $country->FIPS      = "FR";
    $country->ISON      = "250";
    $country->Title     = _t("SilvercartCountry.TITLE_FR");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GA
if (!SilvercartCountry::get()->filter("ISO2", "GA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GA";
    $country->ISO3      = "GAB";
    $country->FIPS      = "GB";
    $country->ISON      = "266";
    $country->Title     = _t("SilvercartCountry.TITLE_GA");
    $country->Continent = "AF";
    $country->Currency  = "XAF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GB
if (!SilvercartCountry::get()->filter("ISO2", "GB")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GB";
    $country->ISO3      = "GBR";
    $country->FIPS      = "UK";
    $country->ISON      = "826";
    $country->Title     = _t("SilvercartCountry.TITLE_GB");
    $country->Continent = "EU";
    $country->Currency  = "GBP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GD
if (!SilvercartCountry::get()->filter("ISO2", "GD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GD";
    $country->ISO3      = "GRD";
    $country->FIPS      = "GJ";
    $country->ISON      = "308";
    $country->Title     = _t("SilvercartCountry.TITLE_GD");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GE
if (!SilvercartCountry::get()->filter("ISO2", "GE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GE";
    $country->ISO3      = "GEO";
    $country->FIPS      = "GG";
    $country->ISON      = "268";
    $country->Title     = _t("SilvercartCountry.TITLE_GE");
    $country->Continent = "AS";
    $country->Currency  = "GEL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GF
if (!SilvercartCountry::get()->filter("ISO2", "GF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GF";
    $country->ISO3      = "GUF";
    $country->FIPS      = "FG";
    $country->ISON      = "254";
    $country->Title     = _t("SilvercartCountry.TITLE_GF");
    $country->Continent = "SA";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GG
if (!SilvercartCountry::get()->filter("ISO2", "GG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GG";
    $country->ISO3      = "GGY";
    $country->FIPS      = "GK";
    $country->ISON      = "831";
    $country->Title     = _t("SilvercartCountry.TITLE_GG");
    $country->Continent = "EU";
    $country->Currency  = "GBP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GH
if (!SilvercartCountry::get()->filter("ISO2", "GH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GH";
    $country->ISO3      = "GHA";
    $country->FIPS      = "GH";
    $country->ISON      = "288";
    $country->Title     = _t("SilvercartCountry.TITLE_GH");
    $country->Continent = "AF";
    $country->Currency  = "GHS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GI
if (!SilvercartCountry::get()->filter("ISO2", "GI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GI";
    $country->ISO3      = "GIB";
    $country->FIPS      = "GI";
    $country->ISON      = "292";
    $country->Title     = _t("SilvercartCountry.TITLE_GI");
    $country->Continent = "EU";
    $country->Currency  = "GIP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GL
if (!SilvercartCountry::get()->filter("ISO2", "GL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GL";
    $country->ISO3      = "GRL";
    $country->FIPS      = "GL";
    $country->ISON      = "304";
    $country->Title     = _t("SilvercartCountry.TITLE_GL");
    $country->Continent = "NA";
    $country->Currency  = "DKK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GM
if (!SilvercartCountry::get()->filter("ISO2", "GM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GM";
    $country->ISO3      = "GMB";
    $country->FIPS      = "GA";
    $country->ISON      = "270";
    $country->Title     = _t("SilvercartCountry.TITLE_GM");
    $country->Continent = "AF";
    $country->Currency  = "GMD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GN
if (!SilvercartCountry::get()->filter("ISO2", "GN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GN";
    $country->ISO3      = "GIN";
    $country->FIPS      = "GV";
    $country->ISON      = "324";
    $country->Title     = _t("SilvercartCountry.TITLE_GN");
    $country->Continent = "AF";
    $country->Currency  = "GNF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GP
if (!SilvercartCountry::get()->filter("ISO2", "GP")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GP";
    $country->ISO3      = "GLP";
    $country->FIPS      = "GP";
    $country->ISON      = "312";
    $country->Title     = _t("SilvercartCountry.TITLE_GP");
    $country->Continent = "NA";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GQ
if (!SilvercartCountry::get()->filter("ISO2", "GQ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GQ";
    $country->ISO3      = "GNQ";
    $country->FIPS      = "EK";
    $country->ISON      = "226";
    $country->Title     = _t("SilvercartCountry.TITLE_GQ");
    $country->Continent = "AF";
    $country->Currency  = "XAF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GR
if (!SilvercartCountry::get()->filter("ISO2", "GR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GR";
    $country->ISO3      = "GRC";
    $country->FIPS      = "GR";
    $country->ISON      = "300";
    $country->Title     = _t("SilvercartCountry.TITLE_GR");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GS
if (!SilvercartCountry::get()->filter("ISO2", "GS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GS";
    $country->ISO3      = "SGS";
    $country->FIPS      = "SX";
    $country->ISON      = "239";
    $country->Title     = _t("SilvercartCountry.TITLE_GS");
    $country->Continent = "AN";
    $country->Currency  = "GBP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GT
if (!SilvercartCountry::get()->filter("ISO2", "GT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GT";
    $country->ISO3      = "GTM";
    $country->FIPS      = "GT";
    $country->ISON      = "320";
    $country->Title     = _t("SilvercartCountry.TITLE_GT");
    $country->Continent = "NA";
    $country->Currency  = "GTQ";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GU
if (!SilvercartCountry::get()->filter("ISO2", "GU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GU";
    $country->ISO3      = "GUM";
    $country->FIPS      = "GQ";
    $country->ISON      = "316";
    $country->Title     = _t("SilvercartCountry.TITLE_GU");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GW
if (!SilvercartCountry::get()->filter("ISO2", "GW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GW";
    $country->ISO3      = "GNB";
    $country->FIPS      = "PU";
    $country->ISON      = "624";
    $country->Title     = _t("SilvercartCountry.TITLE_GW");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country GY
if (!SilvercartCountry::get()->filter("ISO2", "GY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "GY";
    $country->ISO3      = "GUY";
    $country->FIPS      = "GY";
    $country->ISON      = "328";
    $country->Title     = _t("SilvercartCountry.TITLE_GY");
    $country->Continent = "SA";
    $country->Currency  = "GYD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country HK
if (!SilvercartCountry::get()->filter("ISO2", "HK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "HK";
    $country->ISO3      = "HKG";
    $country->FIPS      = "HK";
    $country->ISON      = "344";
    $country->Title     = _t("SilvercartCountry.TITLE_HK");
    $country->Continent = "AS";
    $country->Currency  = "HKD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country HM
if (!SilvercartCountry::get()->filter("ISO2", "HM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "HM";
    $country->ISO3      = "HMD";
    $country->FIPS      = "HM";
    $country->ISON      = "334";
    $country->Title     = _t("SilvercartCountry.TITLE_HM");
    $country->Continent = "AN";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country HN
if (!SilvercartCountry::get()->filter("ISO2", "HN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "HN";
    $country->ISO3      = "HND";
    $country->FIPS      = "HO";
    $country->ISON      = "340";
    $country->Title     = _t("SilvercartCountry.TITLE_HN");
    $country->Continent = "NA";
    $country->Currency  = "HNL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country HR
if (!SilvercartCountry::get()->filter("ISO2", "HR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "HR";
    $country->ISO3      = "HRV";
    $country->FIPS      = "HR";
    $country->ISON      = "191";
    $country->Title     = _t("SilvercartCountry.TITLE_HR");
    $country->Continent = "EU";
    $country->Currency  = "HRK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country HT
if (!SilvercartCountry::get()->filter("ISO2", "HT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "HT";
    $country->ISO3      = "HTI";
    $country->FIPS      = "HA";
    $country->ISON      = "332";
    $country->Title     = _t("SilvercartCountry.TITLE_HT");
    $country->Continent = "NA";
    $country->Currency  = "HTG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country HU
if (!SilvercartCountry::get()->filter("ISO2", "HU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "HU";
    $country->ISO3      = "HUN";
    $country->FIPS      = "HU";
    $country->ISON      = "348";
    $country->Title     = _t("SilvercartCountry.TITLE_HU");
    $country->Continent = "EU";
    $country->Currency  = "HUF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ID
if (!SilvercartCountry::get()->filter("ISO2", "ID")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ID";
    $country->ISO3      = "IDN";
    $country->FIPS      = "ID";
    $country->ISON      = "360";
    $country->Title     = _t("SilvercartCountry.TITLE_ID");
    $country->Continent = "AS";
    $country->Currency  = "IDR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IE
if (!SilvercartCountry::get()->filter("ISO2", "IE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IE";
    $country->ISO3      = "IRL";
    $country->FIPS      = "EI";
    $country->ISON      = "372";
    $country->Title     = _t("SilvercartCountry.TITLE_IE");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IL
if (!SilvercartCountry::get()->filter("ISO2", "IL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IL";
    $country->ISO3      = "ISR";
    $country->FIPS      = "IS";
    $country->ISON      = "376";
    $country->Title     = _t("SilvercartCountry.TITLE_IL");
    $country->Continent = "AS";
    $country->Currency  = "ILS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IM
if (!SilvercartCountry::get()->filter("ISO2", "IM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IM";
    $country->ISO3      = "IMN";
    $country->FIPS      = "IM";
    $country->ISON      = "833";
    $country->Title     = _t("SilvercartCountry.TITLE_IM");
    $country->Continent = "EU";
    $country->Currency  = "GBP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IN
if (!SilvercartCountry::get()->filter("ISO2", "IN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IN";
    $country->ISO3      = "IND";
    $country->FIPS      = "IN";
    $country->ISON      = "356";
    $country->Title     = _t("SilvercartCountry.TITLE_IN");
    $country->Continent = "AS";
    $country->Currency  = "INR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IO
if (!SilvercartCountry::get()->filter("ISO2", "IO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IO";
    $country->ISO3      = "IOT";
    $country->FIPS      = "IO";
    $country->ISON      = "86";
    $country->Title     = _t("SilvercartCountry.TITLE_IO");
    $country->Continent = "AS";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IQ
if (!SilvercartCountry::get()->filter("ISO2", "IQ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IQ";
    $country->ISO3      = "IRQ";
    $country->FIPS      = "IZ";
    $country->ISON      = "368";
    $country->Title     = _t("SilvercartCountry.TITLE_IQ");
    $country->Continent = "AS";
    $country->Currency  = "IQD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IR
if (!SilvercartCountry::get()->filter("ISO2", "IR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IR";
    $country->ISO3      = "IRN";
    $country->FIPS      = "IR";
    $country->ISON      = "364";
    $country->Title     = _t("SilvercartCountry.TITLE_IR");
    $country->Continent = "AS";
    $country->Currency  = "IRR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IS
if (!SilvercartCountry::get()->filter("ISO2", "IS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IS";
    $country->ISO3      = "ISL";
    $country->FIPS      = "IC";
    $country->ISON      = "352";
    $country->Title     = _t("SilvercartCountry.TITLE_IS");
    $country->Continent = "EU";
    $country->Currency  = "ISK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country IT
if (!SilvercartCountry::get()->filter("ISO2", "IT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "IT";
    $country->ISO3      = "ITA";
    $country->FIPS      = "IT";
    $country->ISON      = "380";
    $country->Title     = _t("SilvercartCountry.TITLE_IT");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country JE
if (!SilvercartCountry::get()->filter("ISO2", "JE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "JE";
    $country->ISO3      = "JEY";
    $country->FIPS      = "JE";
    $country->ISON      = "832";
    $country->Title     = _t("SilvercartCountry.TITLE_JE");
    $country->Continent = "EU";
    $country->Currency  = "GBP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country JM
if (!SilvercartCountry::get()->filter("ISO2", "JM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "JM";
    $country->ISO3      = "JAM";
    $country->FIPS      = "JM";
    $country->ISON      = "388";
    $country->Title     = _t("SilvercartCountry.TITLE_JM");
    $country->Continent = "NA";
    $country->Currency  = "JMD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country JO
if (!SilvercartCountry::get()->filter("ISO2", "JO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "JO";
    $country->ISO3      = "JOR";
    $country->FIPS      = "JO";
    $country->ISON      = "400";
    $country->Title     = _t("SilvercartCountry.TITLE_JO");
    $country->Continent = "AS";
    $country->Currency  = "JOD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country JP
if (!SilvercartCountry::get()->filter("ISO2", "JP")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "JP";
    $country->ISO3      = "JPN";
    $country->FIPS      = "JA";
    $country->ISON      = "392";
    $country->Title     = _t("SilvercartCountry.TITLE_JP");
    $country->Continent = "AS";
    $country->Currency  = "JPY";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KE
if (!SilvercartCountry::get()->filter("ISO2", "KE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KE";
    $country->ISO3      = "KEN";
    $country->FIPS      = "KE";
    $country->ISON      = "404";
    $country->Title     = _t("SilvercartCountry.TITLE_KE");
    $country->Continent = "AF";
    $country->Currency  = "KES";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KG
if (!SilvercartCountry::get()->filter("ISO2", "KG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KG";
    $country->ISO3      = "KGZ";
    $country->FIPS      = "KG";
    $country->ISON      = "417";
    $country->Title     = _t("SilvercartCountry.TITLE_KG");
    $country->Continent = "AS";
    $country->Currency  = "KGS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KH
if (!SilvercartCountry::get()->filter("ISO2", "KH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KH";
    $country->ISO3      = "KHM";
    $country->FIPS      = "CB";
    $country->ISON      = "116";
    $country->Title     = _t("SilvercartCountry.TITLE_KH");
    $country->Continent = "AS";
    $country->Currency  = "KHR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KI
if (!SilvercartCountry::get()->filter("ISO2", "KI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KI";
    $country->ISO3      = "KIR";
    $country->FIPS      = "KR";
    $country->ISON      = "296";
    $country->Title     = _t("SilvercartCountry.TITLE_KI");
    $country->Continent = "OC";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KM
if (!SilvercartCountry::get()->filter("ISO2", "KM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KM";
    $country->ISO3      = "COM";
    $country->FIPS      = "CN";
    $country->ISON      = "174";
    $country->Title     = _t("SilvercartCountry.TITLE_KM");
    $country->Continent = "AF";
    $country->Currency  = "KMF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KN
if (!SilvercartCountry::get()->filter("ISO2", "KN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KN";
    $country->ISO3      = "KNA";
    $country->FIPS      = "SC";
    $country->ISON      = "659";
    $country->Title     = _t("SilvercartCountry.TITLE_KN");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KP
if (!SilvercartCountry::get()->filter("ISO2", "KP")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KP";
    $country->ISO3      = "PRK";
    $country->FIPS      = "KN";
    $country->ISON      = "408";
    $country->Title     = _t("SilvercartCountry.TITLE_KP");
    $country->Continent = "AS";
    $country->Currency  = "KPW";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KR
if (!SilvercartCountry::get()->filter("ISO2", "KR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KR";
    $country->ISO3      = "KOR";
    $country->FIPS      = "KS";
    $country->ISON      = "410";
    $country->Title     = _t("SilvercartCountry.TITLE_KR");
    $country->Continent = "AS";
    $country->Currency  = "KRW";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KW
if (!SilvercartCountry::get()->filter("ISO2", "KW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KW";
    $country->ISO3      = "KWT";
    $country->FIPS      = "KU";
    $country->ISON      = "414";
    $country->Title     = _t("SilvercartCountry.TITLE_KW");
    $country->Continent = "AS";
    $country->Currency  = "KWD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KY
if (!SilvercartCountry::get()->filter("ISO2", "KY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KY";
    $country->ISO3      = "CYM";
    $country->FIPS      = "CJ";
    $country->ISON      = "136";
    $country->Title     = _t("SilvercartCountry.TITLE_KY");
    $country->Continent = "NA";
    $country->Currency  = "KYD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country KZ
if (!SilvercartCountry::get()->filter("ISO2", "KZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "KZ";
    $country->ISO3      = "KAZ";
    $country->FIPS      = "KZ";
    $country->ISON      = "398";
    $country->Title     = _t("SilvercartCountry.TITLE_KZ");
    $country->Continent = "AS";
    $country->Currency  = "KZT";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LA
if (!SilvercartCountry::get()->filter("ISO2", "LA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LA";
    $country->ISO3      = "LAO";
    $country->FIPS      = "LA";
    $country->ISON      = "418";
    $country->Title     = _t("SilvercartCountry.TITLE_LA");
    $country->Continent = "AS";
    $country->Currency  = "LAK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LB
if (!SilvercartCountry::get()->filter("ISO2", "LB")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LB";
    $country->ISO3      = "LBN";
    $country->FIPS      = "LE";
    $country->ISON      = "422";
    $country->Title     = _t("SilvercartCountry.TITLE_LB");
    $country->Continent = "AS";
    $country->Currency  = "LBP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LC
if (!SilvercartCountry::get()->filter("ISO2", "LC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LC";
    $country->ISO3      = "LCA";
    $country->FIPS      = "ST";
    $country->ISON      = "662";
    $country->Title     = _t("SilvercartCountry.TITLE_LC");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LI
if (!SilvercartCountry::get()->filter("ISO2", "LI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LI";
    $country->ISO3      = "LIE";
    $country->FIPS      = "LS";
    $country->ISON      = "438";
    $country->Title     = _t("SilvercartCountry.TITLE_LI");
    $country->Continent = "EU";
    $country->Currency  = "CHF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LK
if (!SilvercartCountry::get()->filter("ISO2", "LK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LK";
    $country->ISO3      = "LKA";
    $country->FIPS      = "CE";
    $country->ISON      = "144";
    $country->Title     = _t("SilvercartCountry.TITLE_LK");
    $country->Continent = "AS";
    $country->Currency  = "LKR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LR
if (!SilvercartCountry::get()->filter("ISO2", "LR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LR";
    $country->ISO3      = "LBR";
    $country->FIPS      = "LI";
    $country->ISON      = "430";
    $country->Title     = _t("SilvercartCountry.TITLE_LR");
    $country->Continent = "AF";
    $country->Currency  = "LRD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LS
if (!SilvercartCountry::get()->filter("ISO2", "LS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LS";
    $country->ISO3      = "LSO";
    $country->FIPS      = "LT";
    $country->ISON      = "426";
    $country->Title     = _t("SilvercartCountry.TITLE_LS");
    $country->Continent = "AF";
    $country->Currency  = "LSL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LT
if (!SilvercartCountry::get()->filter("ISO2", "LT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LT";
    $country->ISO3      = "LTU";
    $country->FIPS      = "LH";
    $country->ISON      = "440";
    $country->Title     = _t("SilvercartCountry.TITLE_LT");
    $country->Continent = "EU";
    $country->Currency  = "LTL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LU
if (!SilvercartCountry::get()->filter("ISO2", "LU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LU";
    $country->ISO3      = "LUX";
    $country->FIPS      = "LU";
    $country->ISON      = "442";
    $country->Title     = _t("SilvercartCountry.TITLE_LU");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LV
if (!SilvercartCountry::get()->filter("ISO2", "LV")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LV";
    $country->ISO3      = "LVA";
    $country->FIPS      = "LG";
    $country->ISON      = "428";
    $country->Title     = _t("SilvercartCountry.TITLE_LV");
    $country->Continent = "EU";
    $country->Currency  = "LVL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country LY
if (!SilvercartCountry::get()->filter("ISO2", "LY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "LY";
    $country->ISO3      = "LBY";
    $country->FIPS      = "LY";
    $country->ISON      = "434";
    $country->Title     = _t("SilvercartCountry.TITLE_LY");
    $country->Continent = "AF";
    $country->Currency  = "LYD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MA
if (!SilvercartCountry::get()->filter("ISO2", "MA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MA";
    $country->ISO3      = "MAR";
    $country->FIPS      = "MO";
    $country->ISON      = "504";
    $country->Title     = _t("SilvercartCountry.TITLE_MA");
    $country->Continent = "AF";
    $country->Currency  = "MAD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MC
if (!SilvercartCountry::get()->filter("ISO2", "MC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MC";
    $country->ISO3      = "MCO";
    $country->FIPS      = "MN";
    $country->ISON      = "492";
    $country->Title     = _t("SilvercartCountry.TITLE_MC");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MD
if (!SilvercartCountry::get()->filter("ISO2", "MD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MD";
    $country->ISO3      = "MDA";
    $country->FIPS      = "MD";
    $country->ISON      = "498";
    $country->Title     = _t("SilvercartCountry.TITLE_MD");
    $country->Continent = "EU";
    $country->Currency  = "MDL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ME
if (!SilvercartCountry::get()->filter("ISO2", "ME")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ME";
    $country->ISO3      = "MNE";
    $country->FIPS      = "MJ";
    $country->ISON      = "499";
    $country->Title     = _t("SilvercartCountry.TITLE_ME");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MF
if (!SilvercartCountry::get()->filter("ISO2", "MF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MF";
    $country->ISO3      = "MAF";
    $country->FIPS      = "RN";
    $country->ISON      = "663";
    $country->Title     = _t("SilvercartCountry.TITLE_MF");
    $country->Continent = "NA";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MG
if (!SilvercartCountry::get()->filter("ISO2", "MG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MG";
    $country->ISO3      = "MDG";
    $country->FIPS      = "MA";
    $country->ISON      = "450";
    $country->Title     = _t("SilvercartCountry.TITLE_MG");
    $country->Continent = "AF";
    $country->Currency  = "MGA";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MH
if (!SilvercartCountry::get()->filter("ISO2", "MH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MH";
    $country->ISO3      = "MHL";
    $country->FIPS      = "RM";
    $country->ISON      = "584";
    $country->Title     = _t("SilvercartCountry.TITLE_MH");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MK
if (!SilvercartCountry::get()->filter("ISO2", "MK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MK";
    $country->ISO3      = "MKD";
    $country->FIPS      = "MK";
    $country->ISON      = "807";
    $country->Title     = _t("SilvercartCountry.TITLE_MK");
    $country->Continent = "EU";
    $country->Currency  = "MKD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ML
if (!SilvercartCountry::get()->filter("ISO2", "ML")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ML";
    $country->ISO3      = "MLI";
    $country->FIPS      = "ML";
    $country->ISON      = "466";
    $country->Title     = _t("SilvercartCountry.TITLE_ML");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MM
if (!SilvercartCountry::get()->filter("ISO2", "MM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MM";
    $country->ISO3      = "MMR";
    $country->FIPS      = "BM";
    $country->ISON      = "104";
    $country->Title     = _t("SilvercartCountry.TITLE_MM");
    $country->Continent = "AS";
    $country->Currency  = "MMK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MN
if (!SilvercartCountry::get()->filter("ISO2", "MN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MN";
    $country->ISO3      = "MNG";
    $country->FIPS      = "MG";
    $country->ISON      = "496";
    $country->Title     = _t("SilvercartCountry.TITLE_MN");
    $country->Continent = "AS";
    $country->Currency  = "MNT";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MO
if (!SilvercartCountry::get()->filter("ISO2", "MO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MO";
    $country->ISO3      = "MAC";
    $country->FIPS      = "MC";
    $country->ISON      = "446";
    $country->Title     = _t("SilvercartCountry.TITLE_MO");
    $country->Continent = "AS";
    $country->Currency  = "MOP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MP
if (!SilvercartCountry::get()->filter("ISO2", "MP")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MP";
    $country->ISO3      = "MNP";
    $country->FIPS      = "CQ";
    $country->ISON      = "580";
    $country->Title     = _t("SilvercartCountry.TITLE_MP");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MQ
if (!SilvercartCountry::get()->filter("ISO2", "MQ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MQ";
    $country->ISO3      = "MTQ";
    $country->FIPS      = "MB";
    $country->ISON      = "474";
    $country->Title     = _t("SilvercartCountry.TITLE_MQ");
    $country->Continent = "NA";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MR
if (!SilvercartCountry::get()->filter("ISO2", "MR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MR";
    $country->ISO3      = "MRT";
    $country->FIPS      = "MR";
    $country->ISON      = "478";
    $country->Title     = _t("SilvercartCountry.TITLE_MR");
    $country->Continent = "AF";
    $country->Currency  = "MRO";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MS
if (!SilvercartCountry::get()->filter("ISO2", "MS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MS";
    $country->ISO3      = "MSR";
    $country->FIPS      = "MH";
    $country->ISON      = "500";
    $country->Title     = _t("SilvercartCountry.TITLE_MS");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MT
if (!SilvercartCountry::get()->filter("ISO2", "MT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MT";
    $country->ISO3      = "MLT";
    $country->FIPS      = "MT";
    $country->ISON      = "470";
    $country->Title     = _t("SilvercartCountry.TITLE_MT");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MU
if (!SilvercartCountry::get()->filter("ISO2", "MU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MU";
    $country->ISO3      = "MUS";
    $country->FIPS      = "MP";
    $country->ISON      = "480";
    $country->Title     = _t("SilvercartCountry.TITLE_MU");
    $country->Continent = "AF";
    $country->Currency  = "MUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MV
if (!SilvercartCountry::get()->filter("ISO2", "MV")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MV";
    $country->ISO3      = "MDV";
    $country->FIPS      = "MV";
    $country->ISON      = "462";
    $country->Title     = _t("SilvercartCountry.TITLE_MV");
    $country->Continent = "AS";
    $country->Currency  = "MVR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MW
if (!SilvercartCountry::get()->filter("ISO2", "MW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MW";
    $country->ISO3      = "MWI";
    $country->FIPS      = "MI";
    $country->ISON      = "454";
    $country->Title     = _t("SilvercartCountry.TITLE_MW");
    $country->Continent = "AF";
    $country->Currency  = "MWK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MX
if (!SilvercartCountry::get()->filter("ISO2", "MX")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MX";
    $country->ISO3      = "MEX";
    $country->FIPS      = "MX";
    $country->ISON      = "484";
    $country->Title     = _t("SilvercartCountry.TITLE_MX");
    $country->Continent = "NA";
    $country->Currency  = "MXN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MY
if (!SilvercartCountry::get()->filter("ISO2", "MY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MY";
    $country->ISO3      = "MYS";
    $country->FIPS      = "MY";
    $country->ISON      = "458";
    $country->Title     = _t("SilvercartCountry.TITLE_MY");
    $country->Continent = "AS";
    $country->Currency  = "MYR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country MZ
if (!SilvercartCountry::get()->filter("ISO2", "MZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "MZ";
    $country->ISO3      = "MOZ";
    $country->FIPS      = "MZ";
    $country->ISON      = "508";
    $country->Title     = _t("SilvercartCountry.TITLE_MZ");
    $country->Continent = "AF";
    $country->Currency  = "MZN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NA
if (!SilvercartCountry::get()->filter("ISO2", "NA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NA";
    $country->ISO3      = "NAM";
    $country->FIPS      = "WA";
    $country->ISON      = "516";
    $country->Title     = _t("SilvercartCountry.TITLE_NA");
    $country->Continent = "AF";
    $country->Currency  = "NAD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NC
if (!SilvercartCountry::get()->filter("ISO2", "NC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NC";
    $country->ISO3      = "NCL";
    $country->FIPS      = "NC";
    $country->ISON      = "540";
    $country->Title     = _t("SilvercartCountry.TITLE_NC");
    $country->Continent = "OC";
    $country->Currency  = "XPF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NE
if (!SilvercartCountry::get()->filter("ISO2", "NE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NE";
    $country->ISO3      = "NER";
    $country->FIPS      = "NG";
    $country->ISON      = "562";
    $country->Title     = _t("SilvercartCountry.TITLE_NE");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NF
if (!SilvercartCountry::get()->filter("ISO2", "NF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NF";
    $country->ISO3      = "NFK";
    $country->FIPS      = "NF";
    $country->ISON      = "574";
    $country->Title     = _t("SilvercartCountry.TITLE_NF");
    $country->Continent = "OC";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NG
if (!SilvercartCountry::get()->filter("ISO2", "NG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NG";
    $country->ISO3      = "NGA";
    $country->FIPS      = "NI";
    $country->ISON      = "566";
    $country->Title     = _t("SilvercartCountry.TITLE_NG");
    $country->Continent = "AF";
    $country->Currency  = "NGN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NI
if (!SilvercartCountry::get()->filter("ISO2", "NI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NI";
    $country->ISO3      = "NIC";
    $country->FIPS      = "NU";
    $country->ISON      = "558";
    $country->Title     = _t("SilvercartCountry.TITLE_NI");
    $country->Continent = "NA";
    $country->Currency  = "NIO";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NL
if (!SilvercartCountry::get()->filter("ISO2", "NL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NL";
    $country->ISO3      = "NLD";
    $country->FIPS      = "NL";
    $country->ISON      = "528";
    $country->Title     = _t("SilvercartCountry.TITLE_NL");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NO
if (!SilvercartCountry::get()->filter("ISO2", "NO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NO";
    $country->ISO3      = "NOR";
    $country->FIPS      = "NO";
    $country->ISON      = "578";
    $country->Title     = _t("SilvercartCountry.TITLE_NO");
    $country->Continent = "EU";
    $country->Currency  = "NOK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NP
if (!SilvercartCountry::get()->filter("ISO2", "NP")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NP";
    $country->ISO3      = "NPL";
    $country->FIPS      = "NP";
    $country->ISON      = "524";
    $country->Title     = _t("SilvercartCountry.TITLE_NP");
    $country->Continent = "AS";
    $country->Currency  = "NPR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NR
if (!SilvercartCountry::get()->filter("ISO2", "NR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NR";
    $country->ISO3      = "NRU";
    $country->FIPS      = "NR";
    $country->ISON      = "520";
    $country->Title     = _t("SilvercartCountry.TITLE_NR");
    $country->Continent = "OC";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NU
if (!SilvercartCountry::get()->filter("ISO2", "NU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NU";
    $country->ISO3      = "NIU";
    $country->FIPS      = "NE";
    $country->ISON      = "570";
    $country->Title     = _t("SilvercartCountry.TITLE_NU");
    $country->Continent = "OC";
    $country->Currency  = "NZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country NZ
if (!SilvercartCountry::get()->filter("ISO2", "NZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "NZ";
    $country->ISO3      = "NZL";
    $country->FIPS      = "NZ";
    $country->ISON      = "554";
    $country->Title     = _t("SilvercartCountry.TITLE_NZ");
    $country->Continent = "OC";
    $country->Currency  = "NZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country OM
if (!SilvercartCountry::get()->filter("ISO2", "OM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "OM";
    $country->ISO3      = "OMN";
    $country->FIPS      = "MU";
    $country->ISON      = "512";
    $country->Title     = _t("SilvercartCountry.TITLE_OM");
    $country->Continent = "AS";
    $country->Currency  = "OMR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PA
if (!SilvercartCountry::get()->filter("ISO2", "PA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PA";
    $country->ISO3      = "PAN";
    $country->FIPS      = "PM";
    $country->ISON      = "591";
    $country->Title     = _t("SilvercartCountry.TITLE_PA");
    $country->Continent = "NA";
    $country->Currency  = "PAB";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PE
if (!SilvercartCountry::get()->filter("ISO2", "PE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PE";
    $country->ISO3      = "PER";
    $country->FIPS      = "PE";
    $country->ISON      = "604";
    $country->Title     = _t("SilvercartCountry.TITLE_PE");
    $country->Continent = "SA";
    $country->Currency  = "PEN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PF
if (!SilvercartCountry::get()->filter("ISO2", "PF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PF";
    $country->ISO3      = "PYF";
    $country->FIPS      = "FP";
    $country->ISON      = "258";
    $country->Title     = _t("SilvercartCountry.TITLE_PF");
    $country->Continent = "OC";
    $country->Currency  = "XPF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PG
if (!SilvercartCountry::get()->filter("ISO2", "PG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PG";
    $country->ISO3      = "PNG";
    $country->FIPS      = "PP";
    $country->ISON      = "598";
    $country->Title     = _t("SilvercartCountry.TITLE_PG");
    $country->Continent = "OC";
    $country->Currency  = "PGK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PH
if (!SilvercartCountry::get()->filter("ISO2", "PH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PH";
    $country->ISO3      = "PHL";
    $country->FIPS      = "RP";
    $country->ISON      = "608";
    $country->Title     = _t("SilvercartCountry.TITLE_PH");
    $country->Continent = "AS";
    $country->Currency  = "PHP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PK
if (!SilvercartCountry::get()->filter("ISO2", "PK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PK";
    $country->ISO3      = "PAK";
    $country->FIPS      = "PK";
    $country->ISON      = "586";
    $country->Title     = _t("SilvercartCountry.TITLE_PK");
    $country->Continent = "AS";
    $country->Currency  = "PKR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PL
if (!SilvercartCountry::get()->filter("ISO2", "PL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PL";
    $country->ISO3      = "POL";
    $country->FIPS      = "PL";
    $country->ISON      = "616";
    $country->Title     = _t("SilvercartCountry.TITLE_PL");
    $country->Continent = "EU";
    $country->Currency  = "PLN";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PM
if (!SilvercartCountry::get()->filter("ISO2", "PM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PM";
    $country->ISO3      = "SPM";
    $country->FIPS      = "SB";
    $country->ISON      = "666";
    $country->Title     = _t("SilvercartCountry.TITLE_PM");
    $country->Continent = "NA";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PN
if (!SilvercartCountry::get()->filter("ISO2", "PN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PN";
    $country->ISO3      = "PCN";
    $country->FIPS      = "PC";
    $country->ISON      = "612";
    $country->Title     = _t("SilvercartCountry.TITLE_PN");
    $country->Continent = "OC";
    $country->Currency  = "NZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PR
if (!SilvercartCountry::get()->filter("ISO2", "PR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PR";
    $country->ISO3      = "PRI";
    $country->FIPS      = "RQ";
    $country->ISON      = "630";
    $country->Title     = _t("SilvercartCountry.TITLE_PR");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PS
if (!SilvercartCountry::get()->filter("ISO2", "PS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PS";
    $country->ISO3      = "PSE";
    $country->FIPS      = "WE";
    $country->ISON      = "275";
    $country->Title     = _t("SilvercartCountry.TITLE_PS");
    $country->Continent = "AS";
    $country->Currency  = "ILS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PT
if (!SilvercartCountry::get()->filter("ISO2", "PT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PT";
    $country->ISO3      = "PRT";
    $country->FIPS      = "PO";
    $country->ISON      = "620";
    $country->Title     = _t("SilvercartCountry.TITLE_PT");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PW
if (!SilvercartCountry::get()->filter("ISO2", "PW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PW";
    $country->ISO3      = "PLW";
    $country->FIPS      = "PS";
    $country->ISON      = "585";
    $country->Title     = _t("SilvercartCountry.TITLE_PW");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country PY
if (!SilvercartCountry::get()->filter("ISO2", "PY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "PY";
    $country->ISO3      = "PRY";
    $country->FIPS      = "PA";
    $country->ISON      = "600";
    $country->Title     = _t("SilvercartCountry.TITLE_PY");
    $country->Continent = "SA";
    $country->Currency  = "PYG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country QA
if (!SilvercartCountry::get()->filter("ISO2", "QA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "QA";
    $country->ISO3      = "QAT";
    $country->FIPS      = "QA";
    $country->ISON      = "634";
    $country->Title     = _t("SilvercartCountry.TITLE_QA");
    $country->Continent = "AS";
    $country->Currency  = "QAR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country RE
if (!SilvercartCountry::get()->filter("ISO2", "RE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "RE";
    $country->ISO3      = "REU";
    $country->FIPS      = "RE";
    $country->ISON      = "638";
    $country->Title     = _t("SilvercartCountry.TITLE_RE");
    $country->Continent = "AF";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country RO
if (!SilvercartCountry::get()->filter("ISO2", "RO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "RO";
    $country->ISO3      = "ROU";
    $country->FIPS      = "RO";
    $country->ISON      = "642";
    $country->Title     = _t("SilvercartCountry.TITLE_RO");
    $country->Continent = "EU";
    $country->Currency  = "RON";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country RS
if (!SilvercartCountry::get()->filter("ISO2", "RS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "RS";
    $country->ISO3      = "SRB";
    $country->FIPS      = "RI";
    $country->ISON      = "688";
    $country->Title     = _t("SilvercartCountry.TITLE_RS");
    $country->Continent = "EU";
    $country->Currency  = "RSD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country RU
if (!SilvercartCountry::get()->filter("ISO2", "RU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "RU";
    $country->ISO3      = "RUS";
    $country->FIPS      = "RS";
    $country->ISON      = "643";
    $country->Title     = _t("SilvercartCountry.TITLE_RU");
    $country->Continent = "EU";
    $country->Currency  = "RUB";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country RW
if (!SilvercartCountry::get()->filter("ISO2", "RW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "RW";
    $country->ISO3      = "RWA";
    $country->FIPS      = "RW";
    $country->ISON      = "646";
    $country->Title     = _t("SilvercartCountry.TITLE_RW");
    $country->Continent = "AF";
    $country->Currency  = "RWF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SA
if (!SilvercartCountry::get()->filter("ISO2", "SA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SA";
    $country->ISO3      = "SAU";
    $country->FIPS      = "SA";
    $country->ISON      = "682";
    $country->Title     = _t("SilvercartCountry.TITLE_SA");
    $country->Continent = "AS";
    $country->Currency  = "SAR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SB
if (!SilvercartCountry::get()->filter("ISO2", "SB")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SB";
    $country->ISO3      = "SLB";
    $country->FIPS      = "BP";
    $country->ISON      = "90";
    $country->Title     = _t("SilvercartCountry.TITLE_SB");
    $country->Continent = "OC";
    $country->Currency  = "SBD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SC
if (!SilvercartCountry::get()->filter("ISO2", "SC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SC";
    $country->ISO3      = "SYC";
    $country->FIPS      = "SE";
    $country->ISON      = "690";
    $country->Title     = _t("SilvercartCountry.TITLE_SC");
    $country->Continent = "AF";
    $country->Currency  = "SCR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SD
if (!SilvercartCountry::get()->filter("ISO2", "SD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SD";
    $country->ISO3      = "SDN";
    $country->FIPS      = "SU";
    $country->ISON      = "729";
    $country->Title     = _t("SilvercartCountry.TITLE_SD");
    $country->Continent = "AF";
    $country->Currency  = "SDG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SE
if (!SilvercartCountry::get()->filter("ISO2", "SE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SE";
    $country->ISO3      = "SWE";
    $country->FIPS      = "SW";
    $country->ISON      = "752";
    $country->Title     = _t("SilvercartCountry.TITLE_SE");
    $country->Continent = "EU";
    $country->Currency  = "SEK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SG
if (!SilvercartCountry::get()->filter("ISO2", "SG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SG";
    $country->ISO3      = "SGP";
    $country->FIPS      = "SN";
    $country->ISON      = "702";
    $country->Title     = _t("SilvercartCountry.TITLE_SG");
    $country->Continent = "AS";
    $country->Currency  = "SGD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SH
if (!SilvercartCountry::get()->filter("ISO2", "SH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SH";
    $country->ISO3      = "SHN";
    $country->FIPS      = "SH";
    $country->ISON      = "654";
    $country->Title     = _t("SilvercartCountry.TITLE_SH");
    $country->Continent = "AF";
    $country->Currency  = "SHP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SI
if (!SilvercartCountry::get()->filter("ISO2", "SI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SI";
    $country->ISO3      = "SVN";
    $country->FIPS      = "SI";
    $country->ISON      = "705";
    $country->Title     = _t("SilvercartCountry.TITLE_SI");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SJ
if (!SilvercartCountry::get()->filter("ISO2", "SJ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SJ";
    $country->ISO3      = "SJM";
    $country->FIPS      = "SV";
    $country->ISON      = "744";
    $country->Title     = _t("SilvercartCountry.TITLE_SJ");
    $country->Continent = "EU";
    $country->Currency  = "NOK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SK
if (!SilvercartCountry::get()->filter("ISO2", "SK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SK";
    $country->ISO3      = "SVK";
    $country->FIPS      = "LO";
    $country->ISON      = "703";
    $country->Title     = _t("SilvercartCountry.TITLE_SK");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SL
if (!SilvercartCountry::get()->filter("ISO2", "SL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SL";
    $country->ISO3      = "SLE";
    $country->FIPS      = "SL";
    $country->ISON      = "694";
    $country->Title     = _t("SilvercartCountry.TITLE_SL");
    $country->Continent = "AF";
    $country->Currency  = "SLL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SM
if (!SilvercartCountry::get()->filter("ISO2", "SM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SM";
    $country->ISO3      = "SMR";
    $country->FIPS      = "SM";
    $country->ISON      = "674";
    $country->Title     = _t("SilvercartCountry.TITLE_SM");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SN
if (!SilvercartCountry::get()->filter("ISO2", "SN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SN";
    $country->ISO3      = "SEN";
    $country->FIPS      = "SG";
    $country->ISON      = "686";
    $country->Title     = _t("SilvercartCountry.TITLE_SN");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SO
if (!SilvercartCountry::get()->filter("ISO2", "SO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SO";
    $country->ISO3      = "SOM";
    $country->FIPS      = "SO";
    $country->ISON      = "706";
    $country->Title     = _t("SilvercartCountry.TITLE_SO");
    $country->Continent = "AF";
    $country->Currency  = "SOS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SR
if (!SilvercartCountry::get()->filter("ISO2", "SR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SR";
    $country->ISO3      = "SUR";
    $country->FIPS      = "NS";
    $country->ISON      = "740";
    $country->Title     = _t("SilvercartCountry.TITLE_SR");
    $country->Continent = "SA";
    $country->Currency  = "SRD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SS
if (!SilvercartCountry::get()->filter("ISO2", "SS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SS";
    $country->ISO3      = "SSD";
    $country->FIPS      = "OD";
    $country->ISON      = "728";
    $country->Title     = _t("SilvercartCountry.TITLE_SS");
    $country->Continent = "AF";
    $country->Currency  = "SSP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ST
if (!SilvercartCountry::get()->filter("ISO2", "ST")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ST";
    $country->ISO3      = "STP";
    $country->FIPS      = "TP";
    $country->ISON      = "678";
    $country->Title     = _t("SilvercartCountry.TITLE_ST");
    $country->Continent = "AF";
    $country->Currency  = "STD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SV
if (!SilvercartCountry::get()->filter("ISO2", "SV")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SV";
    $country->ISO3      = "SLV";
    $country->FIPS      = "ES";
    $country->ISON      = "222";
    $country->Title     = _t("SilvercartCountry.TITLE_SV");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SX
if (!SilvercartCountry::get()->filter("ISO2", "SX")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SX";
    $country->ISO3      = "SXM";
    $country->FIPS      = "NN";
    $country->ISON      = "534";
    $country->Title     = _t("SilvercartCountry.TITLE_SX");
    $country->Continent = "NA";
    $country->Currency  = "ANG";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SY
if (!SilvercartCountry::get()->filter("ISO2", "SY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SY";
    $country->ISO3      = "SYR";
    $country->FIPS      = "SY";
    $country->ISON      = "760";
    $country->Title     = _t("SilvercartCountry.TITLE_SY");
    $country->Continent = "AS";
    $country->Currency  = "SYP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country SZ
if (!SilvercartCountry::get()->filter("ISO2", "SZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "SZ";
    $country->ISO3      = "SWZ";
    $country->FIPS      = "WZ";
    $country->ISON      = "748";
    $country->Title     = _t("SilvercartCountry.TITLE_SZ");
    $country->Continent = "AF";
    $country->Currency  = "SZL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TC
if (!SilvercartCountry::get()->filter("ISO2", "TC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TC";
    $country->ISO3      = "TCA";
    $country->FIPS      = "TK";
    $country->ISON      = "796";
    $country->Title     = _t("SilvercartCountry.TITLE_TC");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TD
if (!SilvercartCountry::get()->filter("ISO2", "TD")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TD";
    $country->ISO3      = "TCD";
    $country->FIPS      = "CD";
    $country->ISON      = "148";
    $country->Title     = _t("SilvercartCountry.TITLE_TD");
    $country->Continent = "AF";
    $country->Currency  = "XAF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TF
if (!SilvercartCountry::get()->filter("ISO2", "TF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TF";
    $country->ISO3      = "ATF";
    $country->FIPS      = "FS";
    $country->ISON      = "260";
    $country->Title     = _t("SilvercartCountry.TITLE_TF");
    $country->Continent = "AN";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TG
if (!SilvercartCountry::get()->filter("ISO2", "TG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TG";
    $country->ISO3      = "TGO";
    $country->FIPS      = "TO";
    $country->ISON      = "768";
    $country->Title     = _t("SilvercartCountry.TITLE_TG");
    $country->Continent = "AF";
    $country->Currency  = "XOF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TH
if (!SilvercartCountry::get()->filter("ISO2", "TH")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TH";
    $country->ISO3      = "THA";
    $country->FIPS      = "TH";
    $country->ISON      = "764";
    $country->Title     = _t("SilvercartCountry.TITLE_TH");
    $country->Continent = "AS";
    $country->Currency  = "THB";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TJ
if (!SilvercartCountry::get()->filter("ISO2", "TJ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TJ";
    $country->ISO3      = "TJK";
    $country->FIPS      = "TI";
    $country->ISON      = "762";
    $country->Title     = _t("SilvercartCountry.TITLE_TJ");
    $country->Continent = "AS";
    $country->Currency  = "TJS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TK
if (!SilvercartCountry::get()->filter("ISO2", "TK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TK";
    $country->ISO3      = "TKL";
    $country->FIPS      = "TL";
    $country->ISON      = "772";
    $country->Title     = _t("SilvercartCountry.TITLE_TK");
    $country->Continent = "OC";
    $country->Currency  = "NZD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TL
if (!SilvercartCountry::get()->filter("ISO2", "TL")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TL";
    $country->ISO3      = "TLS";
    $country->FIPS      = "TT";
    $country->ISON      = "626";
    $country->Title     = _t("SilvercartCountry.TITLE_TL");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TM
if (!SilvercartCountry::get()->filter("ISO2", "TM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TM";
    $country->ISO3      = "TKM";
    $country->FIPS      = "TX";
    $country->ISON      = "795";
    $country->Title     = _t("SilvercartCountry.TITLE_TM");
    $country->Continent = "AS";
    $country->Currency  = "TMT";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TN
if (!SilvercartCountry::get()->filter("ISO2", "TN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TN";
    $country->ISO3      = "TUN";
    $country->FIPS      = "TS";
    $country->ISON      = "788";
    $country->Title     = _t("SilvercartCountry.TITLE_TN");
    $country->Continent = "AF";
    $country->Currency  = "TND";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TO
if (!SilvercartCountry::get()->filter("ISO2", "TO")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TO";
    $country->ISO3      = "TON";
    $country->FIPS      = "TN";
    $country->ISON      = "776";
    $country->Title     = _t("SilvercartCountry.TITLE_TO");
    $country->Continent = "OC";
    $country->Currency  = "TOP";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TR
if (!SilvercartCountry::get()->filter("ISO2", "TR")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TR";
    $country->ISO3      = "TUR";
    $country->FIPS      = "TU";
    $country->ISON      = "792";
    $country->Title     = _t("SilvercartCountry.TITLE_TR");
    $country->Continent = "AS";
    $country->Currency  = "TRY";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TT
if (!SilvercartCountry::get()->filter("ISO2", "TT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TT";
    $country->ISO3      = "TTO";
    $country->FIPS      = "TD";
    $country->ISON      = "780";
    $country->Title     = _t("SilvercartCountry.TITLE_TT");
    $country->Continent = "NA";
    $country->Currency  = "TTD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TV
if (!SilvercartCountry::get()->filter("ISO2", "TV")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TV";
    $country->ISO3      = "TUV";
    $country->FIPS      = "TV";
    $country->ISON      = "798";
    $country->Title     = _t("SilvercartCountry.TITLE_TV");
    $country->Continent = "OC";
    $country->Currency  = "AUD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TW
if (!SilvercartCountry::get()->filter("ISO2", "TW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TW";
    $country->ISO3      = "TWN";
    $country->FIPS      = "TW";
    $country->ISON      = "158";
    $country->Title     = _t("SilvercartCountry.TITLE_TW");
    $country->Continent = "AS";
    $country->Currency  = "TWD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country TZ
if (!SilvercartCountry::get()->filter("ISO2", "TZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "TZ";
    $country->ISO3      = "TZA";
    $country->FIPS      = "TZ";
    $country->ISON      = "834";
    $country->Title     = _t("SilvercartCountry.TITLE_TZ");
    $country->Continent = "AF";
    $country->Currency  = "TZS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country UA
if (!SilvercartCountry::get()->filter("ISO2", "UA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "UA";
    $country->ISO3      = "UKR";
    $country->FIPS      = "UP";
    $country->ISON      = "804";
    $country->Title     = _t("SilvercartCountry.TITLE_UA");
    $country->Continent = "EU";
    $country->Currency  = "UAH";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country UG
if (!SilvercartCountry::get()->filter("ISO2", "UG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "UG";
    $country->ISO3      = "UGA";
    $country->FIPS      = "UG";
    $country->ISON      = "800";
    $country->Title     = _t("SilvercartCountry.TITLE_UG");
    $country->Continent = "AF";
    $country->Currency  = "UGX";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country UM
if (!SilvercartCountry::get()->filter("ISO2", "UM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "UM";
    $country->ISO3      = "UMI";
    $country->FIPS      = "";
    $country->ISON      = "581";
    $country->Title     = _t("SilvercartCountry.TITLE_UM");
    $country->Continent = "OC";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country US
if (!SilvercartCountry::get()->filter("ISO2", "US")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "US";
    $country->ISO3      = "USA";
    $country->FIPS      = "US";
    $country->ISON      = "840";
    $country->Title     = _t("SilvercartCountry.TITLE_US");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country UY
if (!SilvercartCountry::get()->filter("ISO2", "UY")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "UY";
    $country->ISO3      = "URY";
    $country->FIPS      = "UY";
    $country->ISON      = "858";
    $country->Title     = _t("SilvercartCountry.TITLE_UY");
    $country->Continent = "SA";
    $country->Currency  = "UYU";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country UZ
if (!SilvercartCountry::get()->filter("ISO2", "UZ")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "UZ";
    $country->ISO3      = "UZB";
    $country->FIPS      = "UZ";
    $country->ISON      = "860";
    $country->Title     = _t("SilvercartCountry.TITLE_UZ");
    $country->Continent = "AS";
    $country->Currency  = "UZS";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VA
if (!SilvercartCountry::get()->filter("ISO2", "VA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VA";
    $country->ISO3      = "VAT";
    $country->FIPS      = "VT";
    $country->ISON      = "336";
    $country->Title     = _t("SilvercartCountry.TITLE_VA");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VC
if (!SilvercartCountry::get()->filter("ISO2", "VC")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VC";
    $country->ISO3      = "VCT";
    $country->FIPS      = "VC";
    $country->ISON      = "670";
    $country->Title     = _t("SilvercartCountry.TITLE_VC");
    $country->Continent = "NA";
    $country->Currency  = "XCD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VE
if (!SilvercartCountry::get()->filter("ISO2", "VE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VE";
    $country->ISO3      = "VEN";
    $country->FIPS      = "VE";
    $country->ISON      = "862";
    $country->Title     = _t("SilvercartCountry.TITLE_VE");
    $country->Continent = "SA";
    $country->Currency  = "VEF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VG
if (!SilvercartCountry::get()->filter("ISO2", "VG")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VG";
    $country->ISO3      = "VGB";
    $country->FIPS      = "VI";
    $country->ISON      = "92";
    $country->Title     = _t("SilvercartCountry.TITLE_VG");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VI
if (!SilvercartCountry::get()->filter("ISO2", "VI")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VI";
    $country->ISO3      = "VIR";
    $country->FIPS      = "VQ";
    $country->ISON      = "850";
    $country->Title     = _t("SilvercartCountry.TITLE_VI");
    $country->Continent = "NA";
    $country->Currency  = "USD";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VN
if (!SilvercartCountry::get()->filter("ISO2", "VN")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VN";
    $country->ISO3      = "VNM";
    $country->FIPS      = "VM";
    $country->ISON      = "704";
    $country->Title     = _t("SilvercartCountry.TITLE_VN");
    $country->Continent = "AS";
    $country->Currency  = "VND";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country VU
if (!SilvercartCountry::get()->filter("ISO2", "VU")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "VU";
    $country->ISO3      = "VUT";
    $country->FIPS      = "NH";
    $country->ISON      = "548";
    $country->Title     = _t("SilvercartCountry.TITLE_VU");
    $country->Continent = "OC";
    $country->Currency  = "VUV";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country WF
if (!SilvercartCountry::get()->filter("ISO2", "WF")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "WF";
    $country->ISO3      = "WLF";
    $country->FIPS      = "WF";
    $country->ISON      = "876";
    $country->Title     = _t("SilvercartCountry.TITLE_WF");
    $country->Continent = "OC";
    $country->Currency  = "XPF";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country WS
if (!SilvercartCountry::get()->filter("ISO2", "WS")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "WS";
    $country->ISO3      = "WSM";
    $country->FIPS      = "WS";
    $country->ISON      = "882";
    $country->Title     = _t("SilvercartCountry.TITLE_WS");
    $country->Continent = "OC";
    $country->Currency  = "WST";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country XK
if (!SilvercartCountry::get()->filter("ISO2", "XK")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "XK";
    $country->ISO3      = "XKX";
    $country->FIPS      = "KV";
    $country->ISON      = "0";
    $country->Title     = _t("SilvercartCountry.TITLE_XK");
    $country->Continent = "EU";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country YE
if (!SilvercartCountry::get()->filter("ISO2", "YE")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "YE";
    $country->ISO3      = "YEM";
    $country->FIPS      = "YM";
    $country->ISON      = "887";
    $country->Title     = _t("SilvercartCountry.TITLE_YE");
    $country->Continent = "AS";
    $country->Currency  = "YER";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country YT
if (!SilvercartCountry::get()->filter("ISO2", "YT")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "YT";
    $country->ISO3      = "MYT";
    $country->FIPS      = "MF";
    $country->ISON      = "175";
    $country->Title     = _t("SilvercartCountry.TITLE_YT");
    $country->Continent = "AF";
    $country->Currency  = "EUR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ZA
if (!SilvercartCountry::get()->filter("ISO2", "ZA")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ZA";
    $country->ISO3      = "ZAF";
    $country->FIPS      = "SF";
    $country->ISON      = "710";
    $country->Title     = _t("SilvercartCountry.TITLE_ZA");
    $country->Continent = "AF";
    $country->Currency  = "ZAR";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ZM
if (!SilvercartCountry::get()->filter("ISO2", "ZM")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ZM";
    $country->ISO3      = "ZMB";
    $country->FIPS      = "ZA";
    $country->ISON      = "894";
    $country->Title     = _t("SilvercartCountry.TITLE_ZM");
    $country->Continent = "AF";
    $country->Currency  = "ZMK";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}
// write country ZW
if (!SilvercartCountry::get()->filter("ISO2", "ZW")->exists()) {
    $country = new SilvercartCountry();
    $country->ISO2      = "ZW";
    $country->ISO3      = "ZWE";
    $country->FIPS      = "ZI";
    $country->ISON      = "716";
    $country->Title     = _t("SilvercartCountry.TITLE_ZW");
    $country->Continent = "AF";
    $country->Currency  = "ZWL";
    $country->Locale    = Translatable::get_current_locale();
    $country->write();
}

$translatorsByPrio = i18n::get_translators();
foreach ($translatorsByPrio as $priority => $translators) {
    foreach ($translators as $name => $translator) {
        $adapter = $translator->getAdapter();
        $languages = $adapter->getList();
        foreach ($languages as $language) {
            $locale = i18n::get_locale_from_lang($language);
            if ($country->hasLanguage($locale)) {
                continue;
            }
            $data = $adapter->getMessages($language);
            foreach (SilvercartCountry::get() as $country) {
                $key    = 'TITLE_' . strtoupper($country->ISO2);
                if (array_key_exists('SilvercartCountry.' . $key, $data)) {
                    $translation = new SilvercartCountryLanguage();
                    $translation->Locale    = $locale;
                    $translation->Title     = $data['SilvercartCountry.' . $key];
                    $translation->write();
                    $country->SilvercartCountryLanguages()->add($translation);
                }
            }
        }
    }
}