<?php
/**
 * This file contains accounting helper model.
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Model
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */
namespace Endereco\OxidClient\Model;

use OxidEsales\Eshop\Core\Registry;

/**
 * Accounting
 *
 * This class creates transaction listing. It's also responsible for billing open
 * transactions against endereco-service (doAccounting method)
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Model
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */
class Accounting
{
    /**
     * Send doAccounting to endereco service.
     *
     * @return void
     */
    public static function doAccounting()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        try {
            $tidsArray = (isset($_SESSION['endereco']))? $_SESSION['endereco']:array();

            $hasTransactions = false;

            foreach ($tidsArray as $session_tid => $counter) {
                if ('not_set' === $session_tid) {
                    continue;
                }

                if (0 < $counter) {
                    $hasTransactions = true;
                    self::accountTid($session_tid);
                }
            }

            if ($hasTransactions) {
                self::convertTid($session_tid);
            }


            unset($_SESSION['endereco']);
        } catch (\Exception $e) {
            // Do nothing on error.
        }
        return;
    }

    /**
     * Send doConversion for separate tids.
     *
     * @return void
     */
    public static function convertTid()
    {
        $data = array(
            'jsonrpc' => '2.0',
            'method'  => 'doConversion',
        );
        $data_string = json_encode($data);
        $oConfig = Registry::getConfig();
        $sOxId = $oConfig->getShopId();
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
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // 4 seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); // 4 seconds
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                    'X-Transaction-Id: ' . 'not_required',
                    'X-Transaction-Referer: ' . $oConfig->getTopActiveView()->getClassName(),
                    'X-Agent: ' . $shopInfo,
                    'Content-Length: ' . strlen($data_string))
            );
            curl_exec($ch);

            $ch_error = curl_errno($ch);
            curl_close($ch);

            // Timeout error. Service is not working.
            if (28 === $ch_error) {
                return;
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
        return;
    }

    /**
     * Send doAccouting for separate tids.
     *
     * @param string $tid Transaction id.
     *
     * @return void;
     */
    public static function accountTid($tid)
    {
        $data = array(
            'jsonrpc' => '2.0',
            'method'  => 'doAccounting',
        );
        $transactionId = $tid;
        $data_string = json_encode($data);

        $oConfig = Registry::getConfig();
        $sOxId = $oConfig->getShopId();
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
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // 4 seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); // 4 seconds
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                    'X-Transaction-Id: ' . $transactionId,
                    'X-Transaction-Referer: ' . $oConfig->getTopActiveView()->getClassName(),
                    'X-Agent: ' . $shopInfo,
                    'Content-Length: ' . strlen($data_string))
            );
            curl_exec($ch);
            $ch_error = curl_errno($ch);

            // Timeout error. Service is not working.
            if (28 === $ch_error) {
                return;
            }

            // Could not connect and havent tried http yet.
            if ((0 !== $ch_error) && !$tried_http) {
                // Try replacing https with http, maybe ssl is dead for some reason.
                $api_url = str_replace('https://', 'http://', $api_url);
                $tried_http = true;
                continue;
            }
            curl_close($ch);

            break;
        }

        return;
    }

    /**
     *  Send doAccontung request to all open transactions and reset counter.
     *
     * @param string $tid Transaction ID.
     *
     */
    public static function countTransaction($tid)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['endereco'])) {
            $_SESSION['endereco'] = array();
        }

        if (!isset($_SESSION['endereco'][$tid])) {
            $_SESSION['endereco'][$tid] = 1;
        } else {
            $_SESSION['endereco'][$tid] = $_SESSION['endereco'][$tid] + 1;
        }
    }
}
