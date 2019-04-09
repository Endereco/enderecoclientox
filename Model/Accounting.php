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
     *  Send doAccontung request to all open transactions and reset counter.
     */
    public static function doAccounting()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $data = array(
            'jsonrpc' => '2.0',
            'method'  => 'doAccounting',
        );

        $data_string = json_encode($data);
        $transactions = $_SESSION['endereco'];
        $hasTransactions = false;
        $transactionId = "";

        if ($transactions) {
            $oConfig = \OxidEsales\Eshop\Core\Registry::getConfig();
            $sOxId = $oConfig->getShopId();

            $ch = curl_init($oConfig->getShopConfVar('sSERVICEURL', $sOxId, 'module:enderecoclientox'));
            foreach ($transactions as $session_tid => $counter) {
                if (0 < $counter) {
                    $hasTransactions = true;
                    $transactionId = $session_tid;

                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // 4 seconds
                    curl_setopt($ch, CURLOPT_TIMEOUT, 4); // 4 seconds
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                            'X-Transaction-Id: ' . $session_tid,
                            'X-Transaction-Referer: ' . $_SERVER['HTTP_REFERER'],
                            'Content-Length: ' . strlen($data_string))
                    );
                    curl_exec($ch);
                }
            }

            if ($hasTransactions) {
                $data = array(
                    'jsonrpc' => '2.0',
                    'method'  => 'doConversion',
                );

                $data_string = json_encode($data);

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // 4 seconds
                curl_setopt($ch, CURLOPT_TIMEOUT, 4); // 4 seconds
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'X-Auth-Key: ' . trim($oConfig->getShopConfVar('sAPIKEY', $sOxId, 'module:enderecoclientox')),
                        'X-Transaction-Id: ' . $transactionId,
                        'X-Transaction-Referer: ' . $_SERVER['HTTP_REFERER'],
                        'Content-Length: ' . strlen($data_string))
                );
                curl_exec($ch);
            }

            unset($_SESSION['endereco']);

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
