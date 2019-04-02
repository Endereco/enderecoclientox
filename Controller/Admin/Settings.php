<?php
/**
 * This file contains settings controller.
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Controller\Admin
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

namespace Endereco\OxidClient\Controller\Admin;

 /**
  * Settings
  *
  * Controller class for settings page.
  *
  * PHP Version 7
  *
  * @package   Endereco\OxidClient\Controller\Admin
  * @author    Ilja Weber <ilja.weber@mobilemojo.de>
  * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
  *            (https://www.mobilemojo.de/)
  * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
  *            version 3 (GPLv3)
  * @link      https://www.endereco.de/
  */
class Settings extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'enderecoclientox_settings.tpl';

    /**
     * Executes parent method parent::render()
     *
     * @return string
     */
    public function render()
    {
        $oConfig = $this->getConfig();
        parent::render();

        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        if (!$sOxId) {
            $sOxId = $oConfig->getShopId();
        }

        $this->_aViewData['oxid'] =  $sOxId;

        $this->_aViewData['cstrs'] = array();

        $sql = "SELECT `OXVARNAME`, DECODE( `OXVARVALUE`, ? ) AS `OXVARVALUE` FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:enderecoclientox'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sql,
            array($oConfig->getConfigParam('sConfigKey'), $sOxId)
        );

        foreach ($resultSet as $result) {
            $this->_aViewData['cstrs'][$result[0]] = $result[1];
        }

        return $this->_sThisTemplate;
    }

    /**
     * Saves changed modules configuration parameters.
     *
     * @return void
     */
    public function save()
    {
        $oConfig = $this->getConfig();
        $checkboxes = array(
            'bPOSTCODEAUTOCOMPLETE',
            'bSTATUSINDICATOR',
            'bCITYNAMEAUTOCOMPLETE',
            'bSTREETAUTOCOMPLETE',
            'bEMAILCHECK',
            'bNAMECHECK',
            'bPREPHONECHECK',
            'bADDRESSCHECK'
        );

        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        $aConfStrs = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('cstrs');

        if (is_array($aConfStrs)) {
            foreach ($aConfStrs as $sVarName => $sVarVal) {
                $oConfig->saveShopConfVar('str', $sVarName, $sVarVal, $sOxId, 'module:enderecoclientox');
            }
        }

        foreach ($checkboxes as $checkboxname) {
            if (!isset($aConfStrs[$checkboxname])) {
                $oConfig->saveShopConfVar('str', $checkboxname, '0', $sOxId, 'module:enderecoclientox');
            }
        }

        // Check connection
        $data = array(
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'nameCheck',
            'params' => array(
                'name' => 'Brunhilde'
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init($aConfStrs['sSERVICEURL']);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'X-Auth-Key: ' . trim($aConfStrs['sAPIKEY']),
                'X-Transaction-Id: ' . 'connection_check',
                'X-Transaction-Referer: ' . 'endereco_settings_page',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        $resultArray = json_decode($result, true);

        if (isset($resultArray['result'])) {
            $oConfig->saveShopConfVar('str', 'sCONNSTATUS', '1', $sOxId, 'module:enderecoclientox');
        } else {
            $oConfig->saveShopConfVar('str', 'sCONNSTATUS', '0', $sOxId, 'module:enderecoclientox');
        }

        return;
    }
}
