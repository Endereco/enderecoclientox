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

$sLangName  = "Deutsch";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = array(
    'charset' => 'UTF-8',
    'ENDERECOCLIENTOX_MAIN' => 'Endereco',
    'ENDERECOCLIENTOX_HOME' => 'Adressvalidierung',
    'ENDERECOCLIENTOX_SETTINGS' => 'Einstellungen',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE1' => 'Allgemeine Einstellungen:',
    'ENDERECOCLIENTOX_SETTINGS_API_KEY' => 'API-Key:',
    'ENDERECOCLIENTOX_SETTINGS_KEEP' => 'Einstellungen bei Modul-Deaktivierung speichern',
    'ENDERECOCLIENTOX_HELP_API_KEY' => 'Trage hier den API-Key ein, den du von Endereco erhalten hast',
    'ENDERECOCLIENTOX_SETTINGS_STATUS' => 'Status:',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK' => 'Ok',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG' => ' - Die Verbindung zum Endereco-Server wurde erfolgreich hergestellt.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP' => 'Du wurdest erfolgreich mit dem Endereco-Server verbunden. Die gebuchten Dienste können genutzt werden.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL' => 'Verbindungsfehler',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG' => ' - Die Verbindung zum Endereco-Server konnte nicht hergestellt werden. Prüfe deinen API-Key.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP' => 'Verbindung zum Endereco-Server fehlgeschlagen. Bitte überprüfe den API-Schlüssel. Kein API-Schlüssel? Kontaktiere uns unter info@endereco.de',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT' => 'Service-Endpunkt:',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_LIVE' => 'Live-System',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_STAGING' => 'Aktuelles Entwicklungs-System',
    'ENDERECOCLIENTOX_HELP_SOURCE' => 'Dir stehen zwei Systeme zur Verfügung, Live und Staging. Bitte Live-System nutzen. Staging-System nur für Entwicklung und Tests',
    'ENDERECOCLIENTOX_SETTINGS_HEADLINE2' => 'Dienste (aktivieren/deaktivieren):',

    'ENDERECOCLIENTOX_SETTINGS_STATUSINDICATOR' => 'Statusanzeige:',
    'ENDERECOCLIENTOX_HELP_STATUSINDICATOR' => 'Zeigt den Prüf-Status als Farbe für die eingegebenen Daten an.',
    'ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR' => 'Erfolgreich-geprüft-Farbe',
    'ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR' => 'Hinweis-Farbe',

    'ENDERECOCLIENTOX_SETTINGS_POSTCODEA' => 'PLZ-Vervollständigung:',
    'ENDERECOCLIENTOX_HELP_POSTCODEAUTOCOMPLETE' => 'Aktiviert Vorschläge für PLZ und den zugehörigen Ort.(Suggest) Ein ausgewählter Datensatz wird in die entsprechenden Adressfelder übernommen.',

    'ENDERECOCLIENTOX_SETTINGS_CITYNAMEA' => 'Ortsname-Vervollständigung:',
    'ENDERECOCLIENTOX_HELP_CITYNAMEAUTOCOMPLETE' => 'Aktiviert Vorschläge für Ort und die zugehörige PLZ.(Suggest) Ein ausgewählter Datensatz wird in die entsprechenden Adressfelder übernommen..',

    'ENDERECOCLIENTOX_SETTINGS_STREETA' => 'Straßenname-Vervollständigung:',
    'ENDERECOCLIENTOX_HELP_STREETAUTOCOMPLETE' => 'Aktiviert Vorschläge für Strassennamen (Suggest). Diese werden für die Eingaben aus Land und Ort zurückgeliefert. Ein ausgewählter Datensatz wird in die entsprechenden Adressfelder übernommen.',

    'ENDERECOCLIENTOX_SETTINGS_EMAILCHECK' => 'E-Mail-Prüfung:',
    'ENDERECOCLIENTOX_HELP_EMAILCHECK' => 'Dieser Dienst überprüft die Syntax, Zustellbarkeit und Existenz eingegebener E-Mail-Adressen',

    'ENDERECOCLIENTOX_SETTINGS_NAMECHECK' => 'Anrede-Prüfung:',
    'ENDERECOCLIENTOX_HELP_NAMECHECK' => 'Dieser Dienst überprüft, ob die gewählte Anrede zu eingegebenen Vornamen passt',

    'ENDERECOCLIENTOX_SETTINGS_PREPHONECHECK' => 'Vorwahl-Prüfung (Nummerformatierung):',
    'ENDERECOCLIENTOX_HELP_PREPHONECHECK' => 'Dieser Dienst prüft, ob die Vorwahl existiert und formatiert die Nummern in das gewünschten Format',

    'ENDERECOCLIENTOX_SETTINGS_ADDRESSSERVICE' => 'Adress-Services',
    'ENDERECOCLIENTOX_HELP_ADDRESSSERVICE' => 'Eingabeassistent und Adressenprüfung.',
    'ENDERECOCLIENTOX_SETTINGS_ALWAYSCHECK' => 'Adressen auch für Bestandskunden prüfen',
    'ENDERECOCLIENTOX_HELP_ALWAYSCHECK' => 'Prüft sowohl neue Adressen, als auch einmalig für Bestandskunden während des Checkouts',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR1' => 'Farbe der ausgewählten Dropdownelementen',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR2' => 'Farbe Suggest Übereinstimmungen',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR3' => 'Adress-Check Popup (normal/hoover)',
    'ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR4' => 'Pop-Up Sekundärfarbe (normal/hoover)',

    'ENDERECOCLIENTOX_SETTINGS_EMAILSERVICE' => 'E-Mail-Service',
    'ENDERECOCLIENTOX_HELP_EMAILSERVICE' => 'Prüft die Zustellbarkeit der E-Mail-Adressen, Syntax sowie die Domain',

    'ENDERECOCLIENTOX_SETTINGS_PHONESERVICE' => 'Telefon-Service',
    'ENDERECOCLIENTOX_HELP_PHONESERVICE' => 'Formatiert die eingegebene Telefonnummer nach normierten Standards.',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT' => 'Formatierung:',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_0' => 'Wie Eingabe',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_1' => 'nationale Rufnummer nur Zahlen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_2' => 'nationale Rufnummer, / als Trennzeichen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_3' => 'nationale Rufnummer, - als Trennzeichen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_4' => 'Vorwahl Rufnummer - national nach DIN 5008',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_5' => '0049VorwahlRufnummer, national nach E.123',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_6' => 'internationale Rufnummer nur Zahlen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_7' => '+49-Vorwahl-Rufnummer, international - als Trennzeichen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_8' => '+49 Vorwahl Rufnummer, International nach DIN 5008',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_9' => '+49 (Vorwahl) Rufnummer, International nach E.123',

    'ENDERECOCLIENTOX_HELP_PHONEFORMAT' => 'Dieser Dienst konvertiert die Telefonnummern ein gewünschtes Format.',

    'ENDERECOCLIENTOX_SETTINGS_NAMESERVICE' => 'Anredeprüfung',
    'ENDERECOCLIENTOX_HELP_NAMESERVICE' => 'Prüft, ob die ausgewählte Anrede zum eingegebenen Vornamen passt (bei Vornamen, die eindeutig sind.)',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE3' => 'Farben',

    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL1' => 'Default',
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL2' => 'Mouseover',
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL3' => 'Text',

    'ENDERECOCLIENTOX_SETTINGS_PRIMARYCOLOR' => 'Hauptfarbe',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORTEXT' => '',

    'ENDERECOCLIENTOX_SETTINGS_SECONDARYCOLOR' => 'Sekundärfarbe',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORTEXT' => '',

    'ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR' => 'Farbe für Hinweise',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORTEXT' => '',

    'ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR' => 'Farbe für korrekte Daten',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLOR' => '',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORHOVER' => '',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORTEXT' => '',
);
