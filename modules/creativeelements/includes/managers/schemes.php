<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com, Elementor.com
 * @copyright 2019 WebshopWorks & Elementor
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CreativeElements;

defined('_PS_VERSION_') or exit;

class SchemesManager
{
    /**
     * @var SchemeBase[]
     */
    protected $_registered_schemes = array();

    private static $_enabled_schemes;

    private static $_schemes_types = array(
        'color',
        'typography',
        'color-picker',
    );

    public function registerScheme($scheme_class)
    {
        if (!class_exists($scheme_class)) {
            return new \PrestaShopException('scheme_class_name_not_exists');
        }

        $scheme_instance = new $scheme_class();

        if (!$scheme_instance instanceof SchemeBase) {
            return new \PrestaShopException('wrong_instance_scheme');
        }

        $this->_registered_schemes[$scheme_instance::getType()] = $scheme_instance;

        return true;
    }

    public function unregisterScheme($id)
    {
        if (!isset($this->_registered_schemes[$id])) {
            return false;
        }
        unset($this->_registered_schemes[$id]);
        return true;
    }

    public function getRegisteredSchemes()
    {
        return $this->_registered_schemes;
    }

    public function getRegisteredSchemesData()
    {
        $data = array();

        foreach ($this->getRegisteredSchemes() as $scheme) {
            $data[$scheme::getType()] = array(
                'title' => $scheme->getTitle(),
                'disabled_title' => $scheme->getDisabledTitle(),
                'items' => $scheme->getScheme(),
            );
        }

        return $data;
    }

    public function getSchemesDefaults()
    {
        $data = array();

        foreach ($this->getRegisteredSchemes() as $scheme) {
            $data[$scheme::getType()] = array(
                'title' => $scheme->getTitle(),
                'items' => $scheme->getDefaultScheme(),
            );
        }

        return $data;
    }

    public function getSystemSchemes()
    {
        $data = array();

        foreach ($this->getRegisteredSchemes() as $scheme) {
            $data[$scheme::getType()] = $scheme->getSystemSchemes();
        }

        return $data;
    }

    public function getScheme($id)
    {
        $schemes = $this->getRegisteredSchemes();

        if (!isset($schemes[$id])) {
            return false;
        }
        return $schemes[$id];
    }

    public function getSchemeValue($scheme_type, $scheme_value)
    {
        $scheme = $this->getScheme($scheme_type);
        if (!$scheme) {
            return false;
        }

        return $scheme->getSchemeValue()[$scheme_value];
    }

    public function ajaxApplyScheme()
    {
        if (!\Tools::getIsset('scheme_name')) {
            wp_send_json_error();
        }

        $scheme_obj = $this->getScheme(\Tools::getValue('scheme_name'));
        if (!$scheme_obj) {
            wp_send_json_error();
        }
        $data = empty(${'_POST'}['data']) ? '' : ${'_POST'}['data'];
        $posted = json_decode(html_entity_decode($data), true);
        $scheme_obj->saveScheme($posted);

        wp_send_json_success();
    }

    public function printSchemesTemplates()
    {
        foreach ($this->getRegisteredSchemes() as $scheme) {
            $scheme->printTemplate();
        }
    }

    public static function getEnabledSchemes()
    {
        if (null === self::$_enabled_schemes) {
            $enabled_schemes = array();

            foreach (self::$_schemes_types as $schemes_type) {
                if ('yes' === get_option('elementor_disable_' . $schemes_type . '_schemes')) {
                    continue;
                }
                $enabled_schemes[] = $schemes_type;
            }
            //self::$_enabled_schemes = apply_filters('elementor/schemes/enabled_schemes', $enabled_schemes);
            self::$_enabled_schemes = $enabled_schemes;
        }
        return self::$_enabled_schemes;
    }

    private function registerDefaultSchemes()
    {
        include _CE_PATH_ . 'includes/interfaces/scheme.php';
        include _CE_PATH_ . 'includes/schemes/base.php';

        foreach (self::$_schemes_types as $schemes_type) {
            include _CE_PATH_ . 'includes/schemes/' . $schemes_type . '.php';

            $this->registerScheme(__NAMESPACE__ . '\Scheme' . str_replace('-', '', $schemes_type));
        }
    }

    public function __construct()
    {
        $this->registerDefaultSchemes();
    }
}
