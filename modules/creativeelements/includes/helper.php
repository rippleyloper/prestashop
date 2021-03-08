<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

namespace CreativeElements;

defined('_PS_VERSION_') or exit;

use Tools;
use Context;
use Db;
use Configuration;
use Shop;
use Translate;

class Helper
{
    public static $actions = array();

    public static $styles = array();

    public static $scripts = array();

    public static $head_styles = array();

    public static $head_scripts = array();

    public static $body_scripts = array();

    public static $enqueue_css = array();

    public static $productHooks = array(
        'displayfooterproduct',
        'displayproductadditionalinfo',
        'displayproductlistreviews',
        'displayproductpriceblock',
        'displayafterproductthumbs',
        'displayleftcolumnproduct',
        'displayrightcolumnproduct',
    );

    public static function getMediaLink($url, $force = false)
    {
        if ($url && !preg_match('~^(https?:)?//~i', $url)) {
            $url = __PS_BASE_URI__ . $url;

            if (_MEDIA_SERVER_1_ || $force) {
                $url = \Context::getContext()->link->getMediaLink($url);
            }
        }
        return $url;
    }

    public static function getTemplatePreviewLink($id)
    {
        $context = Context::getContext();
        return $context->link->getModuleLink('creativeelements', 'preview', array(
            'id' => $id,
            'id_employee' => $context->employee->id,
            'adtoken' => Tools::getAdminTokenLite('AdminCreativePage'),
        ), true);
    }

    public static function registerStylesheet($hander, $path, $attrs = array())
    {
        $controller = Context::getContext()->controller;
        if (method_exists($controller, 'registerStylesheet')) {
            if (isset($attrs['version']) && !Configuration::get('PS_CSS_THEME_CACHE')) {
                $attrs['server'] = 'remote';
                $path = __PS_BASE_URI__ . "$path?v={$attrs['version']}";
            }
            $controller->registerStylesheet($hander, $path, $attrs);
        } else {
            $path = __PS_BASE_URI__ . $path . (isset($attrs['version']) ? "?v={$attrs['version']}" : '');
            $controller->css_files[$path] = isset($attrs['media']) ? $attrs['media'] : 'all';
        }
    }

    public static function registerJavascript($hander, $path, $attrs = array())
    {
        $controller = Context::getContext()->controller;
        if (method_exists($controller, 'registerJavascript')) {
            if (isset($attrs['version']) && !Configuration::get('PS_JS_THEME_CACHE')) {
                $attrs['server'] = 'remote';
                $path = __PS_BASE_URI__ . "$path?v={$attrs['version']}";
            }
            $controller->registerJavascript($hander, $path, $attrs);
        } else {
            $path = __PS_BASE_URI__ . $path . (isset($attrs['version']) ? "?v={$attrs['version']}" : '');
            $controller->js_files[] = $path;
        }
    }
}

function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
{
    $p = (int) $priority;

    if (!isset(Helper::$actions[$tag])) {
        Helper::$actions[$tag] = array();
    }
    if (!isset(Helper::$actions[$tag][$p])) {
        Helper::$actions[$tag][$p] = array();
    }
    Helper::$actions[$tag][$p][] = $function_to_add;
}

function do_action($tag, $arg = '')
{
    $args = func_get_args();
    do_action_ref_array(array_shift($args), $args);
}

function do_action_ref_array($tag, array $args = array())
{
    if (isset(Helper::$actions[$tag])) {
        $priorities = array_keys(Helper::$actions[$tag]);
        sort($priorities, SORT_NUMERIC);

        foreach ($priorities as $p) {
            foreach (Helper::$actions[$tag][$p] as &$callback) {
                if (is_string($callback) && $callback[0] != '\\') {
                    $callback = __NAMESPACE__ . '\\' . $callback;
                }
                if (is_array($callback) && strpos($callback[1], '_') !== false) {
                    $callback[1] = str_replace('_', '', $callback[1]);
                }
                call_user_func_array($callback, $args);
            }
        }
    }
}

function wp_register_style($handle, $src, $deps = array(), $ver = false, $media = 'all')
{
    if (!isset(Helper::$styles[$handle])) {
        Helper::$styles[$handle] = array(
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media,
        );
    }
    return true;
}

function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all')
{
    empty($src) or wp_register_style($handle, $src, $deps, $ver, $media);

    if (!empty(Helper::$styles[$handle]) && empty(Helper::$head_styles[$handle])) {
        foreach (Helper::$styles[$handle]['deps'] as $dep) {
            wp_enqueue_style($dep);
        }

        Helper::$head_styles[$handle] = &Helper::$styles[$handle];
        unset(Helper::$styles[$handle]);
    }
}

function wp_register_script($handle, $src, $deps = array(), $ver = false, $in_footer = false)
{
    if (!isset(Helper::$scripts[$handle])) {
        Helper::$scripts[$handle] = array(
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'head' => !$in_footer,
            'l10n' => array(),
        );
    }
    return true;
}

function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false)
{
    empty($src) or wp_register_script($handle, $src, $deps, $ver, $in_footer);

    if (!empty(Helper::$scripts[$handle]) && empty(Helper::$head_scripts[$handle]) && empty(Helper::$body_scripts[$handle])) {
        foreach (Helper::$scripts[$handle]['deps'] as $dep) {
            wp_enqueue_script($dep);
        }

        if (Helper::$scripts[$handle]['head']) {
            Helper::$head_scripts[$handle] = &Helper::$scripts[$handle];
        } else {
            Helper::$body_scripts[$handle] = &Helper::$scripts[$handle];
        }
        unset(Helper::$scripts[$handle]);
    }
}

function wp_localize_script($handle, $object_name, $l10n)
{
    if (isset(Helper::$scripts[$handle])) {
        Helper::$scripts[$handle]['l10n'][$object_name] = $l10n;
    } elseif (isset(Helper::$head_scripts[$handle])) {
        Helper::$head_scripts[$handle]['l10n'][$object_name] = $l10n;
    } elseif (isset(Helper::$body_scripts[$handle])) {
        Helper::$body_scripts[$handle]['l10n'][$object_name] = $l10n;
    }
}

function wp_enqueue_scripts()
{
    wp_enqueue_script('jquery', _PS_JS_DIR_ . 'jquery/jquery-' . _PS_JQUERY_VERSION_ . '.min.js');
    wp_enqueue_script('jquery-ui', _CE_ASSETS_URL_ . 'lib/jquery/jquery-ui.min.js', array('jquery'), '1.11.4', true);

    wp_register_script('underscore', _CE_ASSETS_URL_ . 'lib/underscore/underscore.min.js', array(), '1.8.3', true);
    wp_register_script('backbone', _CE_ASSETS_URL_ . 'lib/backbone/backbone.min.js', array('jquery', 'underscore'), '1.2.3', true);

    do_action('wp_enqueue_scripts');
}

function wp_print_styles()
{
    while ($args = array_shift(Helper::$head_styles)) {
        if ($args['ver']) {
            $args['src'] .= (Tools::strpos($args['src'], '?') === false ? '?' : '&') . 'v=' . $args['ver'];
        }
        echo '<link rel="stylesheet" href="' . $args['src'] . '" type="text/css" media="' . $args['media'] . '" />' . PHP_EOL;
    }
}

function wp_print_head_scripts()
{
    while ($args = array_shift(Helper::$head_scripts)) {
        _print_script($args);
    }
}

function wp_print_footer_scripts()
{
    while ($args = array_shift(Helper::$body_scripts)) {
        _print_script($args);
    }
}

function _print_script(&$args)
{
    if (!empty($args['l10n'])) {
        echo '<script>' . PHP_EOL;
        foreach ($args['l10n'] as $key => &$value) {
            if ('ElementorConfig' === $key) {
                echo "var $key = {\n";
                foreach ($value as $k => &$v) {
                    $prop = json_encode($k);
                    $json = json_encode($v);
                    echo "\t$prop: $json,\n";
                }
                echo '};' . PHP_EOL;
            } else {
                $json = json_encode($value);
                echo "var $key = $json;\n";
            }
        }
        echo '</script>' . PHP_EOL;
    }
    if ($args['ver']) {
        $args['src'] .= (Tools::strpos($args['src'], '?') === false ? '?' : '&') . 'v=' . $args['ver'];
    }
    echo '<script src="' . $args['src'] . '"></script>' . PHP_EOL;
}

function set_transient($transient, $value, $expiration = 0, $lang = 0, $shop = null)
{
    $expiration = (int) $expiration;
    $tr_timeout = '_tr_to_' . $transient;
    $tr_option = '_tr_' . $transient;

    if (false === get_option($tr_option, false, $lang, $shop)) {
        if ($expiration) {
            update_option($tr_timeout, time() + $expiration, $lang, $shop);
        }
        $result = update_option($tr_option, $value, $lang, $shop);
    } else {
        $update = true;
        if ($expiration) {
            if (false === get_option($tr_timeout, false, $lang, $shop)) {
                update_option($tr_timeout, time() + $expiration, $lang, $shop);
                $result = update_option($tr_option, $value, $lang, $shop);
                $update = false;
            } else {
                update_option($tr_timeout, time() + $expiration, $lang, $shop);
            }
        }
        if ($update) {
            $result = update_option($tr_option, $value, $lang, $shop);
        }
    }

    return $result;
}

function get_transient($transient, $lang = 0, $shop = null)
{
    $tr_option = '_tr_' . $transient;
    $tr_timeout = '_tr_to_' . $transient;
    $timeout = get_option($tr_timeout, false, $lang, $shop);

    if (false !== $timeout && $timeout < time()) {
        delete_option($tr_option, $lang, $shop);
        delete_option($tr_timeout, $lang, $shop);
        return false;
    }
    return get_option($tr_option, false, $lang, $shop);
}

function get_post_meta($id, $key = '', $lang = null, $shop = null)
{
    $context = Context::getContext();
    $table = _DB_PREFIX_ . 'creativepage_meta';
    $id = (int) $id;
    $lang = $lang === null ? $context->language->id : (int) $lang;
    $shop = $shop === null ? $context->shop->id : (int) $shop;
    $key = preg_replace('~\W+~', '', $key);
    $res = Db::getInstance()->getValue("SELECT meta_value FROM $table WHERE id = $id AND id_lang = $lang AND id_shop = $shop AND meta_key = '$key'");
    return $res === false ? $res : json_decode($res, true);
}

function update_post_meta($id, $key, $value, $lang = null, $shop = null)
{
    $context = Context::getContext();
    $db = Db::getInstance();
    return $db->insert(
        'creativepage_meta',
        array(
            'id' => (int) $id,
            'id_lang' => $lang === null ? $context->language->id : (int) $lang,
            'id_shop' => $shop === null ? $context->shop->id : (int) $shop,
            'meta_key' => preg_replace('~\W+~', '', $key),
            'meta_value' => $db->escape(json_encode($value), true),
            'date_upd' => date('Y-m-d H:i:s'),
        ),
        false,
        true,
        Db::REPLACE
    );
}

function delete_post_meta($id, $key, $lang = 0, $shop = null)
{
    $context = Context::getContext();
    $id = (int) $id;
    $lang = empty($lang) ? $context->language->id : (int) $lang;
    $shop = $shop === null ? $context->shop->id : (int) $shop;
    return Db::getInstance()->delete('creativepage_meta', "id = $id AND id_lang = $lang AND id_shop = $shop", 1);
}

function _e($text, $domain = '')
{
    echo translate($text);
}

function __($text, $domain = '')
{
    return translate($text);
}

function _x($text, $context, $domain = '')
{
    $ctx = str_replace(' ', '_', \Tools::strtolower($context));
    return translate($text, $ctx);
}

function translate($text, $ctx = '')
{
    return Tools::getIsset('en') ? $text : call_user_func('strip' . 'slashes', Translate::getModuleTranslation('creativeelements', $text, $ctx, null, true));
}

function esc_attr_e($text, $domain = '')
{
    echo Tools::getIsset('en') ? Tools::safeOutput($text) : Translate::getModuleTranslation('creativeelements', $text, '');
}

function esc_attr($text)
{
    return Tools::safeOutput($text);
}

function wp_parse_args($args, $defaults = '')
{
    if (is_object($args)) {
        $r = get_object_vars($args);
    } elseif (is_array($args)) {
        $r = &$args;
    } else {
        parse_str($args, $r);
    }

    if (is_array($defaults)) {
        return array_merge($defaults, $r);
    }
    return $r;
}

function map_deep($value, $callback)
{
    if (is_array($value)) {
        foreach ($value as $index => $item) {
            $value[$index] = map_deep($item, $callback);
        }
    } elseif (is_object($value)) {
        $object_vars = get_object_vars($value);
        foreach ($object_vars as $property_name => $property_value) {
            $value->$property_name = map_deep($property_value, $callback);
        }
    } else {
        $value = call_user_func($callback, $value);
    }
    return $value;
}

function esc_url($url, $protocols = null, $_context = 'display')
{
    if ('' == $url) {
        return $url;
    }
    $url = str_replace(' ', '%20', $url);
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff]|i', '', $url);
    if ('' === $url) {
        return $url;
    }
    $url = str_replace(';//', '://', $url);
    if (strpos($url, ':') === false && !in_array($url[0], array('/', '#', '?')) &&
        !preg_match('/^[a-z0-9-]+?\.php/i', $url)) {
        $url = 'http://' . $url;
    }
    return $url;
}

function wp_send_json_success($data = null)
{
    @header('Content-Type: application/json; charset=utf-8');
    $response = array('success' => true);
    if (isset($data)) {
        $response['data'] = $data;
    }
    die(json_encode($response));
}

function wp_send_json_error($data = null)
{
    @header('Content-Type: application/json; charset=utf-8');
    $response = array('success' => false);
    if (isset($data)) {
        $response['data'] = $data;
    }
    die(json_encode($response));
}

function absint($num)
{
    return abs((int) $num);
}

function is_rtl()
{
    return !empty(Context::getContext()->language->is_rtl);
}

function get_option($option, $default = false, $lang = 0, $shop = null)
{
    $res = get_post_meta(0, $option, $lang, $shop);
    return $res === false ? $default : $res;
}

function update_option($option, $value, $lang = 0, $shop = null)
{
    return update_post_meta(0, $option, $value, $lang, $shop);
}

function delete_option($option, $lang = 0, $shop = null)
{
    return delete_post_meta(0, $option, $lang, $shop);
}

function wp_remote_post($url, array $args = array())
{
    $http = array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'user_agent' => $_SERVER['SERVER_SOFTWARE'],
        'content' => empty($args['body']) ? '' : http_build_query($args['body']),
        'max_redirects' => 5,
        'timeout' => empty($args['timeout']) ? 5 : $args['timeout'],
    );

    if (ini_get('allow_url_fopen')) {
        return Tools::file_get_contents($url, false, stream_context_create(array('http' => $http)), $http['timeout']);
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => (array) $http['header'],
        CURLOPT_USERAGENT => $http['user_agent'],
        CURLOPT_POSTFIELDS => $http['content'],
        CURLOPT_MAXREDIRS => $http['max_redirects'],
        CURLOPT_TIMEOUT => $http['timeout'],
        CURLOPT_RETURNTRANSFER => 1,
    ));
    $resp = curl_exec($ch);
    curl_close($ch);

    return $resp;
}

function wp_remote_get($url, array $args = array())
{
    $http = array(
        'method' => 'GET',
        'user_agent' => $_SERVER['SERVER_SOFTWARE'],
        'max_redirects' => 5,
        'timeout' => empty($args['timeout']) ? 5 : $args['timeout'],
    );

    if (!empty($args['body'])) {
        $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($args['body']);
    }

    if (ini_get('allow_url_fopen')) {
        return Tools::file_get_contents($url, false, stream_context_create(array('http' => $http)), $http['timeout']);
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_USERAGENT => $http['user_agent'],
        CURLOPT_MAXREDIRS => $http['max_redirects'],
        CURLOPT_TIMEOUT => $http['timeout'],
        CURLOPT_RETURNTRANSFER => 1,
    ));
    $resp = curl_exec($ch);
    curl_close($ch);

    return $resp;
}

function _doing_it_wrong($function, $message = '', $version = '')
{
    die(Tools::displayError($function . ' was called incorrectly. ' . $message . ' ' . $version));
}

function is_wp_error($error)
{
    return $error instanceof \PrestaShopException;
}
