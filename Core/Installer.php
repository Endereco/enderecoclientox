<?php
/**
 * This file contains endereco installer.
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Core
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

namespace Endereco\OxidClient\Core;

 use OxidEsales\Eshop\Core\DatabaseProvider;
 use OxidEsales\Eshop\Core\Registry;

 /**
  * Installer
  *
  * Class that takes care of installation and deinstallation procedure of
  * endereco client module
  *
  * PHP Version 7
  *
  * @package   Endereco\OxidClient\Core
  * @author    Ilja Weber <ilja.weber@mobilemojo.de>
  * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
  *            (https://www.mobilemojo.de/)
  * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
  *            version 3 (GPLv3)
  * @link      https://www.endereco.de/
  */
class Installer
{
    /**
     *  A procedure to execute once the module is activated
     */
    public static function onActivate()
    {
        $oConfig = Registry::getConfig();
        $sOxId = $oConfig->getShopId();

        $sql = "SELECT `OXVARNAME`, DECODE( `OXVARVALUE`, ? ) AS `OXVARVALUE` FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:enderecoclientox'";
        $resultSet = DatabaseProvider::getDb()->getAll(
            $sql,
            array($oConfig->getConfigParam('sConfigKey'), $sOxId)
        );

        // Set default values
        // TODO: test and possibly remove in the next release.
        if (0 === count($resultSet)) {
            $oConfig->saveShopConfVar('str', 'sCONNSTATUS', '0', $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('str', 'sAPIKEY', '', $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('str', 'sSERVICEURL', 'https://endereco-service.de/rpc/v1', $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('bool', 'bKEEPSETTINGS', true, $sOxId, 'module:enderecoclientox');

            $oConfig->saveShopConfVar('bool', 'bSTATUSINDICATOR', true, $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('bool', 'bADDRESSSERVICE', true, $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('bool', 'bADDRESSALWAYSCHECK', true, $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('bool', 'bEMAILSERVICE', true, $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('bool', 'bNAMESERVICE', true, $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('bool', 'bPHONESERVICE', true, $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('str', 'sPHONEFORMAT', '8', $sOxId, 'module:enderecoclientox');

            // AddressCheck.
            $oConfig->saveShopConfVar('str', 'sADDRESSSERVCOLOR31', '#009EC0', $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('str', 'sADDRESSSERVCOLOR32', '#0089a7', $sOxId, 'module:enderecoclientox');

            // Input Assistant.
            $oConfig->saveShopConfVar('str', 'sADDRESSSERVCOLOR2', '#fc6621', $sOxId, 'module:enderecoclientox');

            // Status Indicator.
            $oConfig->saveShopConfVar('str', 'sSUCCESSCOLOR', '#5cb85c', $sOxId, 'module:enderecoclientox');
            $oConfig->saveShopConfVar('str', 'sWARNINGCOLOR', '#f0ad4e', $sOxId, 'module:enderecoclientox');
        }
    }

    /**
     * Deactivation routine.
     */
    public static function onDeactivate()
    {
        $oConfig = Registry::getConfig();
        $sOxId = $oConfig->getShopId();

        $keepAfterDeactivation = $oConfig->getShopConfVar('bKEEPSETTINGS', $sOxId, 'module:enderecoclientox');

        if (!$keepAfterDeactivation) {
            DatabaseProvider::getDB()->execute("DELETE FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:enderecoclientox-persist'", array($sOxId)); // TODO: clean up DB, remove this in next update.
            DatabaseProvider::getDB()->execute("DELETE FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:enderecoclientox'", array($sOxId));
        }

        self::cleanTmp();
    }

    /**
     * Clean temp folder content.
     *
     * @param string $sClearFolderPath Sub-folder path to delete from. Should be a full, valid path inside temp folder.
     *
     * @return boolean
     */
    public static function cleanTmp($sClearFolderPath = '')
    {
        $sTempFolderPath = realpath(Registry::getConfig()->getConfigParam('sCompileDir'));

        if (!empty($sClearFolderPath) &&
            ( strpos($sClearFolderPath, $sTempFolderPath) !== false ) &&
            is_dir($sClearFolderPath)
        ) {
            $sFolderPath = $sClearFolderPath;
        } elseif (empty($sClearFolderPath)) {
            $sFolderPath = $sTempFolderPath;
        } else {
            return false;
        }

        $hDir = opendir($sFolderPath);

        if (!empty($hDir)) {
            while (false !== ($sFileName = readdir($hDir))) {
                $sFilePath = $sFolderPath . '/' . $sFileName;

                if (!in_array($sFileName, array('.', '..', '.htaccess')) &&
                    is_file($sFilePath)
                ) {
                    @unlink($sFilePath);
                } elseif (('smarty' === $sFileName) && is_dir($sFilePath)) {
                    self::cleanTmp($sFilePath);
                }
            }
        }

        return true;
    }
}
