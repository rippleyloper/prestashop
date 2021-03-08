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
$context = Context::getContext();
$link = new Link();
if (Tools::getValue("oauth_token") && Tools::getValue("oauth_verifier")) {
    $context->cookie->__set('oauth_token_bac', Tools::getValue("oauth_token"));
    $context->cookie->__set('oauth_verifier', Tools::getValue("oauth_verifier"));
}

$twitter_url_callback = urlencode(
    Tools::getHTTPHost(true).__PS_BASE_URI__.'modules/'.
    $hipopup->name.'/helper/twitterconnect.php'
);


$oauth_nonce = md5(uniqid(rand(), true));
$oauth_timestamp = time();
$oauth_base_text = "GET&";
$oauth_base_text .= urlencode('https://api.twitter.com/oauth/request_token')."&";
$oauth_base_text .= urlencode("oauth_callback=".$twitter_url_callback."&");
$oauth_base_text .= urlencode("oauth_consumer_key=".$hipopup->sc_twitter_key."&");
$oauth_base_text .= urlencode("oauth_nonce=".$oauth_nonce."&");
$oauth_base_text .= urlencode("oauth_signature_method=HMAC-SHA1&");
$oauth_base_text .= urlencode("oauth_timestamp=".$oauth_timestamp."&");
$oauth_base_text .= urlencode("oauth_version=1.0");

$key = $hipopup->sc_twitter_secret."&";
$oauth_signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $key, true));

$url1 = 'https://api.twitter.com/oauth/request_token';
$url1 .= '?oauth_callback='.$twitter_url_callback;
$url1 .= '&oauth_consumer_key='.$hipopup->sc_twitter_key;
$url1 .= '&oauth_nonce='.$oauth_nonce;
$url1 .= '&oauth_signature='.urlencode($oauth_signature);
$url1 .= '&oauth_signature_method=HMAC-SHA1';
$url1 .= '&oauth_timestamp='.$oauth_timestamp;
$url1 .= '&oauth_version=1.0';

$response = Tools::file_get_contents($url1);
parse_str($response, $result);
$context->cookie->__set('oauth_token', $oauth_token = $result['oauth_token']);
$context->cookie->__set('oauth_token_secret', $oauth_token_secret = $result['oauth_token_secret']);
$url1 = 'https://api.twitter.com/oauth/authorize';
$url1 .= '?oauth_token='.$oauth_token;


if ((Tools::getValue("oauth_token")
    && Tools::getValue("oauth_verifier"))
    || (isset($context->cookie->oauth_token_bac)
    && isset($context->cookie->oauth_verifier))) {
    if (isset($context->cookie->oauth_token_bac) && isset($context->cookie->oauth_verifier)) {
        $oauth_token = $context->cookie->oauth_token_bac;
        $oauth_verifier = $context->cookie->oauth_verifier;
    } else {
        $oauth_token = Tools::getValue('oauth_token_bac');
        $oauth_verifier = Tools::getValue('oauth_verifier');
    }
    $oauth_token_secret = $context->cookie->oauth_token_secret;
    $oauth_base_text = "GET&";
    $oauth_base_text .= urlencode('https://api.twitter.com/oauth/access_token')."&";
    $oauth_base_text .= urlencode("oauth_consumer_key=".$hipopup->sc_twitter_key."&");
    $oauth_base_text .= urlencode("oauth_nonce=".$oauth_nonce."&");
    $oauth_base_text .= urlencode("oauth_signature_method=HMAC-SHA1&");
    $oauth_base_text .= urlencode("oauth_token=".$oauth_token."&");
    $oauth_base_text .= urlencode("oauth_timestamp=".$oauth_timestamp."&");
    $oauth_base_text .= urlencode("oauth_verifier=".$oauth_verifier."&");
    $oauth_base_text .= urlencode("oauth_version=1.0");

    $key = $hipopup->sc_twitter_secret."&".$oauth_token_secret;
    $oauth_signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $key, true));
    $url = 'https://api.twitter.com/oauth/access_token';
    $url .= '?oauth_nonce='.$oauth_nonce;
    $url .= '&oauth_signature_method=HMAC-SHA1';
    $url .= '&oauth_timestamp='.$oauth_timestamp;
    $url .= '&oauth_consumer_key='.$hipopup->sc_twitter_key;
    $url .= '&oauth_token='.urlencode($oauth_token);
    $url .= '&oauth_verifier='.urlencode($oauth_verifier);
    $url .= '&oauth_signature='.urlencode($oauth_signature);
    $url .= '&oauth_version=1.0';

    if (!$response = Tools::file_get_contents($url)) {
        Tools::redirect($url1);
    }
    parse_str($response, $result);
    if (!isset($result['oauth_token'])) {
        Tools::redirect($url1);
    }
    $oauth_nonce = md5(uniqid(rand(), true));
    $oauth_timestamp = time();
    $oauth_token = $result['oauth_token'];
    $oauth_token_secret = $result['oauth_token_secret'];
    $screen_name = $result['screen_name'];

    $oauth_base_text = "GET&";
    $oauth_base_text .= urlencode('https://api.twitter.com/1.1/users/show.json').'&';
    $oauth_base_text .= urlencode('oauth_consumer_key='.$hipopup->sc_twitter_key.'&');
    $oauth_base_text .= urlencode('oauth_nonce='.$oauth_nonce.'&');
    $oauth_base_text .= urlencode('oauth_signature_method=HMAC-SHA1&');
    $oauth_base_text .= urlencode('oauth_timestamp='.$oauth_timestamp."&");
    $oauth_base_text .= urlencode('oauth_token='.$oauth_token."&");
    $oauth_base_text .= urlencode('oauth_version=1.0&');
    $oauth_base_text .= urlencode('screen_name=' . $screen_name);

    $key = $hipopup->sc_twitter_secret . '&' . $oauth_token_secret;
    $signature = base64_encode(hash_hmac("sha1", $oauth_base_text, $key, true));
    $url = 'https://api.twitter.com/1.1/users/show.json';
    $url .= '?oauth_consumer_key='.$hipopup->sc_twitter_key;
    $url .= '&oauth_nonce=' . $oauth_nonce;
    $url .= '&oauth_signature=' . urlencode($signature);
    $url .= '&oauth_signature_method=HMAC-SHA1';
    $url .= '&oauth_timestamp=' . $oauth_timestamp;
    $url .= '&oauth_token=' . urlencode($oauth_token);
    $url .= '&oauth_version=1.0';
    $url .= '&screen_name=' . $screen_name;
    $response = Tools::file_get_contents($url);
    $user_data = Tools::jsonDecode($response);

    $email = '';
    $user_name = explode(" ", $user_data->name);
    $first_name = !empty($user_name)?preg_replace('/\PL/u', '', $user_name[0]):'';
    $last_name = !empty($user_name) && isset($user_name[1])?preg_replace('/\PL/u', '', $user_name[1]):'';

    $activate_url = $link->getModuleLink('hipopupnotification', 'connect').(Configuration::get('PS_REWRITING_SETTINGS') ? '?' : '&' ).'content_only=1&activate=twitter&email='.$email.'&user_data_id='.$user_data->id.'&user_fname='.$first_name.'&user_lname='.$last_name.'&name_status=no_full&screen_name='.$screen_name;
    if ($first_name == '' || $last_name == '' || $email == '') {
        Tools::redirect($activate_url.'&full_info=false&popup=1');
    } else {
        Tools::redirect($activate_url.'&full_info=true&popup=1');
    }
} else {
    Tools::redirect($url1);
}
