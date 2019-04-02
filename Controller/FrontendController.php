<?php
/**
 * This file contains endereco controller that handles ajax requests from endereco client
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Controller
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

namespace Endereco\OxidClient\Controller;

 /**
  * FrontendController
  *
  * Controller class for AJAX handling. Handler all Endereco-SDK requests.
  *
  * PHP Version 7
  *
  * @package   Endereco\OxidClient\Controller
  * @author    Ilja Weber <ilja.weber@mobilemojo.de>
  * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
  *            (https://www.mobilemojo.de/)
  * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
  *            version 3 (GPLv3)
  * @link      https://www.endereco.de/
  */
class FrontendController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     *  This function returns the json string with data
     *
     *  The JavaScript App is sending requests to endereco controller. Those
     *  requests land here first. After adding so crucial data to the request
     *  it gets sent to endereco proxy, which returns a result.
     *  This result is returned to the JavaScript App in the end.
     */
    public function render()
    {
        $oConfig = $this->getConfig();
        $sOxId = $oConfig->getShopId();

        $data = json_decode(file_get_contents('php://input'), true);

        // Correct language
        if (isset($data['params']['language'])) {
            $oLang = \OxidEsales\Eshop\Core\Registry::getLang();
            $sLang = $oLang->getLanguageAbbr();
            $data['params']['language'] = $sLang;
        }

        // Correct country
        if (isset($data['params']['country'])) {
            if ('' == $data['params']['country'] || 'de' == $data['params']['country']) {
                $data['params']['country'] = 'de';
            } else {
                $oCountry = oxNew('oxCountry');
                $oCountry->load($data['params']['country']);
                $data['params']['country'] = strtolower($oCountry->oxcountry__oxisoalpha2->value);
            }
        }

        $data_string = json_encode($data);

        $ch = curl_init($oConfig->getShopConfVar('sSERVICEURL', $sOxId, 'module:enderecoclientox'));

        if ($_SERVER['HTTP_X_TRANSACTION_ID']) {
            $tid = $_SERVER['HTTP_X_TRANSACTION_ID'];
        } else {
            $tid = 'not_set';
        }

        \Endereco\OxidClient\Model\Accounting::countTransaction($tid);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                'X-Transaction-Id: ' . $tid,
                'X-Transaction-Referer: ' . $_SERVER['HTTP_X_TRANSACTION_REFERER'],
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
        echo $result;
        die();
    }
}
