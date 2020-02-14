<?php
/**
 * This file contains metadata..
 *
 * PHP Version 7
 *
 * @package   Endereco\OxidClient\Meta
 * @author    Ilja Weber <ilja.weber@mobilemojo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 *            (https://www.mobilemojo.de/)
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License,
 *            version 3 (GPLv3)
 * @link      https://www.endereco.de/
 */

$sMetadataVersion = '2.0';

$aModule = array(
    'id'           => 'enderecoclientox',
    'title'        => 'Endereco AMS',
    'description' => array(
        'en' => 'Adddressvalidation + Correction for Webshops',
        'de' => 'Adressvalidierung + Korrekturvorschläge für Webshops',
    ),
    'thumbnail'    => 'endereco.png',
    'version'      => '3.3.1',
    'author'       => 'endereco',
    'email'        => 'info@endereco.de',
    'url'          => 'www.endereco.de',
    'events'       => array(
        'onActivate'   => '\Endereco\OxidClient\Core\Installer::onActivate',
        'onDeactivate' => '\Endereco\OxidClient\Core\Installer::onDeactivate',
    ),
    'controllers'  => array(
        'enderecocontroller' => \Endereco\OxidClient\Controller\FrontendController::class,
        'enderecocountrycontroller' =>  \Endereco\OxidClient\Controller\FrontendCountryController::class,
        'enderecoconnectioncontroller' => \Endereco\OxidClient\Controller\FrontendConnectionController::class,
        'enderecoincludewidget' => \Endereco\OxidClient\Component\Widget\IncludeWidget::class,
        'enderecosettings' => \Endereco\OxidClient\Controller\Admin\Settings::class,
    ),
    'templates' => array(
        'enderecoclientox_settings.tpl' => 'endereco/enderecoclientox/application/views/admin/tpl/enderecoclientox_settings.tpl',
        'enderecoincludewidget.tpl' => 'endereco/enderecoclientox/application/views/widget/enderecoincludewidget.tpl',
    ),
    'blocks' => array(
        array('template' => 'layout/base.tpl', 'block' => 'base_js', 'file' => 'enderecosdk.tpl'),
        array('template' => 'form/fieldset/user_billing.tpl', 'block' => 'form_user_billing_country', 'file' => 'enderecowidget.tpl'),
    ),
    'extend' => array(
        \OxidEsales\Eshop\Application\Model\User::class => \Endereco\OxidClient\Model\User::class,
    ),
    'settings' => array(
        array('group' => 'main', 'name' => 'sCONNSTATUS', 'type' => 'str', 'value' => '0'),
        array('group' => 'main', 'name' => 'sAPIKEY', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'sSERVICEURL', 'type' => 'str', 'value' => 'https://endereco-service.de/rpc/v1'),
        array('group' => 'main', 'name' => 'bKEEPSETTINGS', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'main', 'name' => 'bSTATUSINDICATOR', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'main', 'name' => 'bADDRESSSERVICE', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'main', 'name' => 'bADDRESSALWAYSCHECK', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'main', 'name' => 'bEMAILSERVICE', 'type' => 'bool','value' => 'true'),
        array('group' => 'main', 'name' => 'bNAMESERVICE', 'type' => 'bool','value' => 'true'),
        array('group' => 'main', 'name' => 'bPHONESERVICE', 'type' => 'bool','value' => 'true'),
        array('group' => 'main', 'name' => 'sPHONEFORMAT', 'type' => 'str', 'value' => '8'),
        array('group' => 'main', 'name' => 'sADDRESSSERVCOLOR31', 'type' => 'str', 'value' => '#009EC0'),
        array('group' => 'main', 'name' => 'sADDRESSSERVCOLOR32', 'type' => 'str', 'value' => '#0089a7'),
        array('group' => 'main', 'name' => 'sADDRESSSERVCOLOR2', 'type' => 'str', 'value' => '#fc6621'),
        array('group' => 'main', 'name' => 'sSUCCESSCOLOR', 'type' => 'str', 'value' => '#5cb85c'),
        array('group' => 'main', 'name' => 'sWARNINGCOLOR', 'type' => 'str', 'value' => '#f0ad4e'),
    )
);
