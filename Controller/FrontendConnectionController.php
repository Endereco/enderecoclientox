<?php
/**
 * This file contains endereco controller that is used to deliver country codes.
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
  * FrontendConnectionController
  *
  * Returns connection status..
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
class FrontendConnectionController extends \OxidEsales\Eshop\Application\Controller\FrontendController
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
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');

        // Check connection
        $data = array(
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'readinessCheck',
        );
        $data_string = json_encode($data);

        $api_url = $oConfig->getShopConfVar('sSERVICEURL', $sOxId, 'module:enderecoclientox');
        $tried_http = false;
        $result = '';

        // (Shop Version; active Theme)
        $oTheme = oxNew(\OxidEsales\Eshop\Core\Theme::class);
        $activeTheme = $oTheme->getActiveThemeId();
        $shopVersion = \OxidEsales\Eshop\Core\ShopVersion::getVersion();
        $oFacts = new \OxidEsales\Facts\Facts();
        $shopEdition = $oFacts->getEdition();
        $moduleVersions = $oConfig->getConfigParam('aModuleVersions');
        $shopInfo = 'client:enderecoclientox '.$moduleVersions['enderecoclientox'].', shop:OXID eShop '.$shopEdition.' '.$shopVersion.', theme:'.$activeTheme;

        while (true) {
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // 2 seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); // 2 seconds
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                    'X-Transaction-Id: ' . 'not_required',
                    'X-Transaction-Referer: ' . $_SERVER['HTTP_X_TRANSACTION_REFERER'],
                    'X-Agent: ' . $shopInfo,
                    'Content-Length: ' . strlen($data_string))
            );

            $result = curl_exec($ch);
            $ch_error = curl_errno($ch);

            // Could not connect and havent tried http yet.
            if ((0 !== $ch_error) && !$tried_http) {
                // Try replacing https with http, maybe ssl is dead for some reason.
                $api_url = str_replace('https://', 'http://', $api_url);
                $tried_http = true;
                continue;
            }

            // Still connection error?. Break then.
            if (0 !== $ch_error) {
                echo 'no_connection';
                break;
            }

            break;
        }

        curl_close($ch);

        if ('' !== $result) {
            echo 'connection_ok';
        }

        die();
    }
}
