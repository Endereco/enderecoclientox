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
    'version'      => '3.2.2',
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
);
