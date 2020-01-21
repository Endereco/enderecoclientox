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

use Endereco\OxidClient\Model\Accounting;

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
        session_write_close();
        $oConfig = $this->getConfig();
        $sOxId = $oConfig->getShopId();

        $data = json_decode(file_get_contents('php://input'), true);

        // Correct language
        if (isset($data['params']['language'])) {
            $oLang = \OxidEsales\Eshop\Core\Registry::getLang();
            $sLang = $oLang->getLanguageAbbr();
            $data['params']['language'] = $sLang;
        }

        $data_string = json_encode($data);

        if ($_SERVER['HTTP_X_TRANSACTION_ID']) {
            $tid = $_SERVER['HTTP_X_TRANSACTION_ID'];
        } else {
            $tid = 'not_set';
        }

        // (Shop Version; active Theme)
        $oTheme = oxNew(\OxidEsales\Eshop\Core\Theme::class);
        $activeTheme = $oTheme->getActiveThemeId();
        $shopVersion = \OxidEsales\Eshop\Core\ShopVersion::getVersion();
        $oFacts = new \OxidEsales\Facts\Facts();
        $shopEdition = $oFacts->getEdition();
        $moduleVersions = $oConfig->getConfigParam('aModuleVersions');
        $shopInfo = 'client:enderecoclientox '.$moduleVersions['enderecoclientox'].', shop:OXID eShop '.$shopEdition.' '.$shopVersion.', theme:'.$activeTheme;

        $api_url = $oConfig->getShopConfVar('sSERVICEURL', $sOxId, 'module:enderecoclientox');
        $tried_http = false;
        $result = '';

        while (true) {
            $ch = curl_init($api_url);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6); // 6 seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 6); // 6 seconds
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                    'X-Transaction-Id: ' . $tid,
                    'X-Transaction-Referer: ' . $_SERVER['HTTP_X_TRANSACTION_REFERER'],
                    'X-Agent: ' . $shopInfo,
                    'Content-Length: ' . strlen($data_string))
            );

            $result = curl_exec($ch);
            $ch_info = curl_getinfo($ch);
            $ch_error = curl_errno($ch);

            // Timeout error. Service is not working.
            if (28 === $ch_error) {
                curl_close($ch);
                echo '';
                die();
            }

            // Could not connect and havent tried http yet.
            if ((0 !== $ch_error) && !$tried_http) {
                // Try replacing https with http, maybe ssl is dead for some reason.
                $api_url = str_replace('https://', 'http://', $api_url);
                $tried_http = true;
                continue;
            }

            break;
        }

        curl_close($ch);

        if ('' !== $result) {
            $resultData = json_decode($result, true);

            if (isset($resultData['cmd']) && isset($resultData['cmd']['use_tid'])) {
                $tid = $resultData['cmd']['use_tid'];
            }

            if (isset($resultData['result'])) {
                Accounting::countTransaction($tid);
            }
        }

        echo $result;
        die();
    }
}
