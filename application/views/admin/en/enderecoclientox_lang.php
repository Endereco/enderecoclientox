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
    'ENDERECOCLIENTOX_HELP_API_KEY' => 'API-Key is a passcode, you receive from your Endereco service provider.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS' => 'Status:',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK' => 'Ok',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG' => ' - The connection to Endereco-Server was successfully established.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP' => 'You are now connected to Endereco server and can start using services available',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL' => 'Error',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG' => ' - Connection to Endereco-Server failed. Please, check the API-Key.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP' => 'Connection failed. Please check the API-Key. If you have no API-Key, make sure to contact Endereco service provider at info@endereco.de.',

    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT' => 'Service Endpoint:',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_LIVE' => 'Live System',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_SANDBOX' => 'Testing System',
    'ENDERECOCLIENTOX_HELP_SOURCE' => 'There are two systems available to you, Live and Testing. The changes that are applied to Live system will affect your eCommerce platform. Make sure to perform tests in the testing system first.',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE2' => 'Services (activate/deactivate):',

    'ENDERECOCLIENTOX_SETTINGS_STATUSINDICATOR' => 'Status:',
    'ENDERECOCLIENTOX_HELP_STATUSINDICATOR' => 'Choose whether you want to display status for the data inserted or not. When deactivated, neither warning nor success sign will be displayed.',

    'ENDERECOCLIENTOX_SETTINGS_POSTCODEA' => 'Postcode Autocomplete:',
    'ENDERECOCLIENTOX_HELP_POSTCODEAUTOCOMPLETE' => 'While activated, this service provides the user with a postcode and related city name suggestions upon typed digits. Selected data will be automatically populated into the corresponding address fields.',

    'ENDERECOCLIENTOX_SETTINGS_CITYNAMEA' => 'City name Autocomplete:',
    'ENDERECOCLIENTOX_HELP_CITYNAMEAUTOCOMPLETE' => 'While activated, this service provides the user with a postcode and related city name suggestions upon inserted letters. Selected data will be automatically populated into the corresponding address fields.',

    'ENDERECOCLIENTOX_SETTINGS_STREETA' => 'Street name Autocomplete:',
    'ENDERECOCLIENTOX_HELP_STREETAUTOCOMPLETE' => 'While activated, this service provides the user with a street name suggestions upon inserted letters, available for chosen Postcode + City combination.',

    'ENDERECOCLIENTOX_SETTINGS_EMAILCHECK' => 'eMail Check:',
    'ENDERECOCLIENTOX_HELP_EMAILCHECK' => 'While activated,  eMail Check verifies the syntax, availability and deliverability of an entered eMail-Address. It also checks whether it is a one-time or spam eMail Address.',

    'ENDERECOCLIENTOX_SETTINGS_NAMECHECK' => 'Salutation Check:',
    'ENDERECOCLIENTOX_HELP_NAMECHECK' => 'While activated, this service verifies whether chosen salutation corresponds to the first name.',

    'ENDERECOCLIENTOX_SETTINGS_PREPHONECHECK' => 'Area code check (Number formatting):',
    'ENDERECOCLIENTOX_HELP_PREPHONECHECK' => 'White activated, this service verifies whether an inserted area code exists and formats the number in accordance to chosen format.',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT' => 'Formatting:',

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

    'ENDERECOCLIENTOX_HELP_PHONEFORMAT' => 'This service converts inserted telephone number according to the chosen format.',

    'ENDERECOCLIENTOX_SETTINGS_ADDRESSCHECK' => 'Address check:',
    'ENDERECOCLIENTOX_HELP_ADDRESSCHECK' => 'While activated, this service performs the last check upon entered address information. In case of potential errors, the service will providea number of possible correct addresses that might be meant by the user.',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE3' => 'Colors:', /*Hier kann mann schreiben: "IT is possible to change the displayed colors for text, data fields, hints as well as warning und success sign"*/

    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL1' => 'default',
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL2' => 'mouseover', /*Ich vertehe diese Farbe nicht. Wann taucht sie auf?*/
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL3' => 'text',

    'ENDERECOCLIENTOX_SETTINGS_PRIMARYCOLOR' => 'Main color:',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLOR' => 'Lorem ipsum', /*Ich würde die Erklärungen für einzelne farben lassen*/
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORTEXT' => 'Lorem ipsum',

    'ENDERECOCLIENTOX_SETTINGS_SECONDARYCOLOR' => 'Secondary color:',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLOR' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORTEXT' => 'Lorem ipsum',

    'ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR' => 'Color for warning:',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLOR' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORTEXT' => 'Lorem ipsum',

    'ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR' => 'Color for success:',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLOR' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORTEXT' => 'Lorem ipsum',
);
