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
    'ENDERECOCLIENTOX_HELP_API_KEY' => 'API-Key ist der Schlüssel, den Sie von Endereco Dienstleister bekommen haben.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS' => 'Status:',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK' => 'Ok',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG' => ' - Die Verbindung zum Endereco-Server wurde erfolgreich hergestellt.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP' => 'Sie sind jetzt mit Endereco-Server verbunden und können die gebuchten Dienste nutzen.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL' => 'Fehler',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG' => ' - Die Verbindung zum Endereco-Server konnte nicht hergestellt werden. Prüfen Sie das API-Key.',
    'ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP' => 'Verbindung zum Endereco-Server fehlgeschlagen. Bitte überprüfen Sie den API-Schlüssel. Wenn Sie keinen API-Schlüssel haben, kontaktieren Sie uns unter info@endereco.de',

    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT' => 'Service-Endpunkt:',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_LIVE' => 'Live-System',
    'ENDERECOCLIENTOX_SETTINGS_ENDPOINT_SANDBOX' => 'Test-System',
    'ENDERECOCLIENTOX_HELP_SOURCE' => 'Ihnen stehen zwei Systeme zur Verfügung, Live und Testing. Die Änderungen, die auf das Live-System angewendet werden, wirken sich auf Ihre E-Commerce-Plattform aus. Stellen Sie sicher, dass Sie zuerst Tests im Testsystem durchführen.',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE2' => 'Dienste (aktivieren/deaktivieren):',

    'ENDERECOCLIENTOX_SETTINGS_STATUSINDICATOR' => 'Statusanzeige:',
    'ENDERECOCLIENTOX_HELP_STATUSINDICATOR' => 'Wählen Sie bitte aus, ob Sie den Status für die eingegebenen Daten anzeigen möchten. Wenn deaktiviert, werden weder Warnung- noch Erfolgszeichen angezeigt.',

    'ENDERECOCLIENTOX_SETTINGS_POSTCODEA' => 'PLZ-Vervollständigung:',
    'ENDERECOCLIENTOX_HELP_POSTCODEAUTOCOMPLETE' => 'Anhand der eingegebenen Zahlen werden für den Nutzer die Vorschläge für PLZ und zugehörigen Ort generiert. Ausgewählte Daten werden dann automatisch in die entsprechenden Adressfelder eingefügt.',

    'ENDERECOCLIENTOX_SETTINGS_CITYNAMEA' => 'Ortsname-Vervollständigung:',
    'ENDERECOCLIENTOX_HELP_CITYNAMEAUTOCOMPLETE' => 'Anhand der eingegebenen Buchstaben werden für den Nutzer die Vorschläge für Ort und zugehörigen PLZ generiert. Ausgewählte Daten werden dann automatisch in die entsprechenden Adressfelder eingefügt.',

    'ENDERECOCLIENTOX_SETTINGS_STREETA' => 'Straßenname-Vervollständigung:',
    'ENDERECOCLIENTOX_HELP_STREETAUTOCOMPLETE' => 'Anhand der eingegebenen Buchstaben werden dem Nutzer die Starßennamen angezeigt, die in der ausgewählten PLZ + Ort Combination verfügbar sind.',

    'ENDERECOCLIENTOX_SETTINGS_EMAILCHECK' => 'eMail-Prüfung:',
    'ENDERECOCLIENTOX_HELP_EMAILCHECK' => 'Dieser Dienst überprüft die Syntax, Zustellbarkeit und Existenz eingegebener eMail-Adresse. Außerdem wird geprüft, ob es sich um eine Wegwerf oder SPam-Adresse handelt.',

    'ENDERECOCLIENTOX_SETTINGS_NAMECHECK' => 'Anrede-Prüfung:',
    'ENDERECOCLIENTOX_HELP_NAMECHECK' => 'Dieser Dienst überprüft, ob die gewählte Anrede zu dem Vornamen passt.',

    'ENDERECOCLIENTOX_SETTINGS_PREPHONECHECK' => 'Vorwahl-Prüfung (Nummerformatierung):',
    'ENDERECOCLIENTOX_HELP_PREPHONECHECK' => 'Dieser Dienst prüft, ob die Vorwahl existiert und formatiert die Nummern nach dem gewählten Format',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT' => 'Formatierung:',

    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_0' => 'wie Eingabe',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_1' => 'nationale Rufnummer nur Zahlen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_2' => 'nationale Rufnummer, / als Trennzeichen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_3' => 'nationale Rufnummer, - als Trennzeichen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_4' => 'nationale Rufnummer nach DIN 5008',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_5' => 'nationale Rufnummer nach E.123',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_6' => 'internationale Rufnummer nur Zahlen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_7' => 'internationale Rufnummer, - als Trennzeichen',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_8' => 'internationale Rufnummer nach DIN 5008',
    'ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_9' => 'internationale Rufnummer nach E.123',

    'ENDERECOCLIENTOX_HELP_PHONEFORMAT' => 'Dieser Dienst konvertiert die Telefonnummern nach dem gewählten Format.',

    'ENDERECOCLIENTOX_SETTINGS_ADDRESSCHECK' => 'Adress-Prüfung:',
    'ENDERECOCLIENTOX_HELP_ADDRESSCHECK' => 'Dieser Dienst führt die letzte Überprüfung der eingegebenen Adressinformationen durch. Bei potenziellen Fehlern zeigt die Adress-Prüfung eine Reihe von möglichen korrekten Adressen an, die Nutzer eventuell meinte.',

    'ENDERECOCLIENTOX_SETTINGS_HEADLINE3' => 'Farben:', /*Hier kann man schreiben: Es besteht die Möglichkeit die Anzeigefarben für die Texte, Datenfelder, Highlights, Hinweise als auch für Warnung- und Erfolgszeichen zu ändern.*/

    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL1' => 'default',
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL2' => 'mouseover', /*Wie in Englishe Datei: ICh verstehe nicht, wann diese Farbe auftaucht.*/
    'ENDERECOCLIENTOX_SETTINGS_COLOR_COL3' => 'text',

    'ENDERECOCLIENTOX_SETTINGS_PRIMARYCOLOR' => 'Hauptfarbe:',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLOR' => 'Lorem ipsum', /*die ganzen HELP für einzelnen Farben würde ich weglassen.*/
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_PRIMARYCOLORTEXT' => 'Lorem ipsum',

    'ENDERECOCLIENTOX_SETTINGS_SECONDARYCOLOR' => 'Sekundäre Farbe:',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLOR' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SECONDARYCOLORTEXT' => 'Lorem ipsum',

    'ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR' => 'Farbe der Warnung:',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLOR' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_WARNINGCOLORTEXT' => 'Lorem ipsum',

    'ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR' => 'Farbe des Erfolgs:',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLOR' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORHOVER' => 'Lorem ipsum',
    'ENDERECOCLIENTOX_HELP_SUCCESSCOLORTEXT' => 'Lorem ipsum',
);
