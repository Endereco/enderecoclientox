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
  * FrontendCountryController
  *
  * Used to deliver country codes.
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
class FrontendCountryController extends \OxidEsales\Eshop\Application\Controller\FrontendController
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
        $returnArray = array();

        if ('getCountryCodes' === $data['method']) {
            $oCountry = oxNew('oxCountry');

            foreach ($data['params']['countryIds'] as $index => $countryId) {
                $oCountry->load($countryId);
                $returnArray[$index] = strtolower($oCountry->oxcountry__oxisoalpha2->value);
            }
        }

        $response = array(
            'jsonrpc' => '2.0',
            'id' => 1,
            'result' => array(
                'countryCodes' => $returnArray
            ),
        );

        echo json_encode($response);
        die();
    }
}
