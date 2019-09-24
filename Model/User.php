<?php
/**
 * This file contains user model extension.
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
  * User
  *
  * Extends the functionality of user model adding some actions to onChangeUserData hook.
  * this function is called if user data have been successfully changed, which
  * makes it perfect to track conversion (and do Accounting).
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
class User extends User_parent
{
    /**
     * Method used for override.
     *
     * @param array $aInvAddress
     */
    protected function onChangeUserData($aInvAddress)
    {
        Accounting::doAccounting();
    }
}
