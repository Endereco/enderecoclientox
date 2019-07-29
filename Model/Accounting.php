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
        try {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['endereco'])) {
                $tidsArray = $_SESSION['endereco'];
            } else {
                $tidsArray = array();
            }

            $data = array(
                'jsonrpc' => '2.0',
                'method'  => 'doAccounting',
            );

            $data_string = json_encode($data);
            $hasTransactions = false;
            $transactionId = "";

            if ($tidsArray) {
                $oConfig = \OxidEsales\Eshop\Core\Registry::getConfig();
                $sOxId = $oConfig->getShopId();
                $api_url = $oConfig->getShopConfVar('sSERVICEURL', $sOxId, 'module:enderecoclientox-persist');
                $tried_http = false;
                $result = '';

                foreach ($tidsArray as $session_tid => $counter) {
                    if (0 < $counter) {
                        $hasTransactions = true;
                        $transactionId = $session_tid;

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
                                    'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox-persist')),
                                    'X-Transaction-Id: ' . $session_tid,
                                    'X-Transaction-Referer: ' . $_SERVER['HTTP_REFERER'],
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

                            break;
                        }
                    }
                }

                curl_close($ch);

                unset($_SESSION['endereco']);
            }
        } catch (\Exception $e) {
            // Do nothing on error.
        }
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
