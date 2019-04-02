<?php
/**
 * This file contains endereco widget that put neccesary code to header.
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Component\Widget
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

namespace Endereco\OxidClient\Component\Widget;

 /**
  * IncludeWidget
  *
  * Renders a piece of html in the header including all Endereco-SDK constructors
  * and creating variable configuration for them.
  *
  * PHP Version 7
  *
  * @package   Endereco\OxidClient\Component\Widget
  * @author    Ilja Weber <ilja.weber@mobilemojo.de>
  * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
  *            (https://www.mobilemojo.de/)
  * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
  *            version 3 (GPLv3)
  * @link      https://www.endereco.de/
  */
class IncludeWidget extends \OxidEsales\Eshop\Application\Component\Widget\WidgetController
{
    /**
     * @var string Widget template
     */
    protected $_sThisTemplate = 'enderecoincludewidget.tpl';


    /**
     * Getter for protected property.
     *
     * @return string
     */
    public function getThisTemplate()
    {
        return $this->_sThisTemplate;
    }

    /**
     * Render
     *
     * @return string Template name.
     */
    public function render()
    {
        parent::render();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['endereco']);

        $oConfig = $this->getConfig();
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        if (!$sOxId) {
            $sOxId = $oConfig->getShopId();
        }
        $this->_aViewData['enderecocstrs'] = array();

        $sql = "SELECT `OXVARNAME`, DECODE( `OXVARVALUE`, ? ) AS `OXVARVALUE` FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:enderecoclientox'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sql,
            array($oConfig->getConfigParam('sConfigKey'), $sOxId)
        );

        foreach ($resultSet as $result) {
            $this->_aViewData['enderecocstrs'][$result[0]] = $result[1];
        }

        $this->_aViewData['enderecotexts'] = array(
            'ENDERECOCLIENTOX_ADDRESSCHECK_HEAD' => 'Adresse prüfen',
            'ENDERECOCLIENTOX_ADDRESSCHECK_BTN' => 'Adresse übernehmen',
            'ENDERECOCLIENTOX_ADDRESSCHECK_AREA1' => 'Ihre Eingabe:',
            'ENDERECOCLIENTOX_ADDRESSCHECK_AREA2' => 'Unsere Vorschläge:',
        );

        return $this->getThisTemplate();
    }
}
