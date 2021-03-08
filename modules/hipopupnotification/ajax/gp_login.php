<?php
/**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*/

include(dirname(__FILE__).'/../../../config/config.inc.php');
include(dirname(__FILE__).'/../../../init.php');

$hipopup = Module::getInstanceByName('hipopupnotification');

if (Tools::getValue('secure_key') != $hipopup->secure_key) {
    die(Tools::jsonEncode(array('error' => $hipopup->l('Hack Attempt!'))));
}

$link = new Link();
$id_token = Tools::getValue('id_token');
$url = 'https://oauth2.googleapis.com/tokeninfo?id_token='.$id_token;
$user_json_data = Tools::file_get_contents($url);
$user_data = Tools::jsonDecode($user_json_data);

if (isset($user_data->error) && !isset($user_data->sub)) {
    die(Tools::jsonEncode(array(
        'error' => $user_data->error,
        'error_description' => $user_data->error_description
    )));
}

$first_name = preg_replace('/\PL/u', '', $user_data->given_name);
$last_name = preg_replace('/\PL/u', '', $user_data->family_name);
$email = $user_data->email;
$id_user = $user_data->sub;

if(!$last_name) {
    $first_name = $last_name;
}

$activate_url = $link->getModuleLink('hipopupnotification', 'connect').(Configuration::get('PS_REWRITING_SETTINGS') ? '?' : '&' ).'content_only=1&activate=google&email='.$email.'&user_data_id='.$id_user.'&user_fname='.$first_name.'&user_lname='.$last_name.'&name_status=full';

if ($first_name == '' || $last_name == '' || $email == '') {
    die(Tools::jsonEncode(array('activate_die_url' => $activate_url.'&full_info=false&popup=0')));
} else {
    Tools::redirect($activate_url.'&full_info=true&popup=0');
}
