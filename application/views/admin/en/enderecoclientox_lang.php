<?php
/**
 * This file contains translations.
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Translations
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

$sLangName  = "English";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = array(
    'charset' => 'UTF-8',
    'ENDERECOCLIENTOX_MAIN' => 'Endereco',
    'ENDERECOCLIENTOX_HOME' => 'Address validation',
    'ENDERECOCLIENTOX_SETTINGS' => 'Settings',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE1' => 'General settings:',
    'ENDERECOCLIENTOX_SETTINGS_API_KEY' => 'API-Key:',
    'ENDERECOCLIENTOX_SETTINGS_KEEP' => 'Save settings after deactivation',
    'ENDERECOCLIENTOX_HELP_API_KEY' => 'API-Key is a passcode, you receive from www.endereco.de service provider.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS' => 'Status:',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK' => 'Ok',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG' => ' - The connection to Endereco-Server was successfully established.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP' => 'You are now connected to Endereco server',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL' => 'Error',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG' => ' - Connection to Endereco-Server failed. Please check API-Key.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP' => 'Connection failed. Please check the API-Key. If you have no API-Key, make sure to contact Endereco service provider at info@endereco.de.',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT' => 'Service Endpoint:',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_LIVE' => 'Live-System',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_SANDBOX' => 'Sandbox-System',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_STAGING' => 'Development-System',
    'ENDERECOCLIENTOX_HELP_SOURCE' => 'Use live system for normal operations and staging system for development and testing.',
    'ENDERECOCLIENTOX_SETTINGS_HEADLINE2' => 'Services (activate/deactivate):',

    'ENDERECOCLIENTOX_SETTINGS_STATUSINDICATOR' => 'Statusindicator:',
    'ENDERECOCLIENTOX_HELP_STATUSINDICATOR' => 'Highlights fields with preselected colorcode to indicate whether the input is correct or not.',

    'ENDERECOCLIENTOX_SETTINGS_POSTCODEA' => 'Postcode autocomplete:',
    'ENDERECOCLIENTOX_HELP_POSTCODEAUTOCOMPLETE' => 'While activated, this service provides the user with a postcode and related city name suggestions upon typed digits. Selected data will be automatically populated into the corresponding address fields.',

    'ENDERECOCLIENTOX_SETTINGS_CITYNAMEA' => 'Cityname Autocomplete:',
    'ENDERECOCLIENTOX_HELP_CITYNAMEAUTOCOMPLETE' => 'While activated, this service provides the user with a postcode and related city name suggestions upon inserted letters. Selected data will be automatically populated into the corresponding address fields.',

    'ENDERECOCLIENTOX_SETTINGS_STREETA' => 'Streetname Autocomplete:',
    'ENDERECOCLIENTOX_HELP_STREETAUTOCOMPLETE' => 'While activated, this service provides the user with a street name suggestions upon inserted letters, available for chosen Postcode + City combination.',

    'ENDERECOCLIENTOX_SETTINGS_EMAILCHECK' => 'E-Mail Check:',
    'ENDERECOCLIENTOX_HELP_EMAILCHECK' => 'While activated,  eMail Check verifies the syntax, availability and deliverability of an entered eMail Address. It also checks whether it is a one-time or spam eMail Address.',

    'ENDERECOCLIENTOX_SETTINGS_NAMECHECK' => 'Salutation Check:',
    'ENDERECOCLIENTOX_HELP_NAMECHECK' => 'While activated,  eMail Check verifies the syntax, availability and deliverability of an entered eMail Address. It also checks whether it is a one-time or spam eMail Address.',

    'ENDERECOCLIENTOX_SETTINGS_PREPHONECHECK' => 'Prephone check (Number formatting):',
    'ENDERECOCLIENTOX_HELP_PREPHONECHECK' => 'White activated, this service verifies whether an inserted area code exists and formats the number in accordance to chosen format.',

    'ENDERECOCLIENTOX_SETTINGS_ADDRESSSERVICE' => 'Address-Service:',
    'ENDERECOCLIENTOX_HELP_ADDRESSSERVICE' => 'inputassistant and addresscheck.',
    'ENDERECOCLIENTOX_SETTINGS_ALWAYSCHECK' => 'Check addresses of existing customers (once)',
    'ENDERECOCLIENTOX_HELP_ALWAYSCHECK' => 'Checks the addresses of already registered customers, marks checked customers with a cookie to prevent double checking.',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR1' => 'Color of selected dropdown elements.',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR2' => 'Input color',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR3' => 'Pop-Up color (normal/active)',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR4' => 'Pop-Up secondary color (normal/active)',

    'ENDERECOCLIENTOX_SETTINGS_EMAILSERVICE' => 'E-Mail-Service',
    'ENDERECOCLIENTOX_HELP_EMAILSERVICE' => 'Checks if E-Mail can be delivered.',

    'ENDERECOCLIENTOX_SETTINGS_PHONESERVICE' => 'Phone-Service',
    'ENDERECOCLIENTOX_HELP_PHONESERVICE' => 'Formats the phone number according to specified format.',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT' => 'Format:',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_0' => 'as entered',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_1' => 'national telephone numbers, only Digits',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_2' => 'national telephone numbers, / as a Divider',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_3' => 'national telephone numbers, - as a Divider',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_4' => 'national telephone numbers according to DIN 5008',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_5' => 'national telephone numbers according to E.123',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_6' => 'international telephone numbers, only Digits',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_7' => 'international telephone numbers, - as a Divider',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_8' => 'international telephone numbers according to DIN 5008',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_9' => 'international telephone numbers according to E.123',

    'ENDERECOCLIENTOX_HELP_PHONEFORMAT' => 'This service converts inserted telephone numbers according to the choosen format.',

    'ENDERECOCLIENTOX_SETTINGS_NAMESERVICE' => 'Salutation-Service',
    'ENDERECOCLIENTOX_HELP_NAMESERVICE' => 'Checks if selected salutation is right (if possible).',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE3' => 'Colors',

    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL1' => 'Default',
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL2' => 'Mouseover',
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL3' => 'Text',

    'ENDERECOCLIENTOX_SETTINGS_PRIMARYCOLOR' => 'Main color:',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORTEXT' => '',

    'ENDERECOCLIENTOX_SETTINGS_SECONDARYCOLOR' => 'Secondary color:',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORTEXT' => '',

    'ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR' => 'Color for warning:',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORTEXT' => '',

    'ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR' => 'Color for success:',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORTEXT' => '',

    'SHOP_MODULE_GROUP_main' => 'General settings',
    'SHOP_MODULE_sCONNSTATUS' => 'Status',
    'SHOP_MODULE_sAPIKEY' => 'API-Key',
    'SHOP_MODULE_sSERVICEURL' => 'Service Endpoint',
    'SHOP_MODULE_bKEEPSETTINGS' => 'Save settings after deactivation',
    'SHOP_MODULE_bSTATUSINDICATOR' => 'Statusindicator',
    'SHOP_MODULE_bADDRESSSERVICE' => 'Address-Service',
    'SHOP_MODULE_bADDRESSALWAYSCHECK' => 'Check addresses of existing customers (once)',
    'SHOP_MODULE_bEMAILSERVICE' => 'E-Mail-Service',
    'SHOP_MODULE_bNAMESERVICE' => 'Salutation-Service',
    'SHOP_MODULE_bPHONESERVICE' => 'Phone-Service',
    'SHOP_MODULE_sPHONEFORMAT' => 'Format',
    'SHOP_MODULE_sADDRESSSERVCOLOR31' => 'Pop-Up color (normal)',
    'SHOP_MODULE_sADDRESSSERVCOLOR32' => 'Pop-Up color (active)',
    'SHOP_MODULE_sADDRESSSERVCOLOR2' => 'Input color',
    'SHOP_MODULE_sSUCCESSCOLOR' => 'Color for success',
    'SHOP_MODULE_sWARNINGCOLOR' => 'Color for warning',
);
