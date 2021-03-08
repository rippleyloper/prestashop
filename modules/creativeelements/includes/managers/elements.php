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

class ElementsManager
{
    /**
     * @var Element_Base[]
     */
    private $_element_types;

    private $_categories;

    public function __construct()
    {
        $this->requireFiles();

        // add_action('wp_ajax_elementor_save_builder', array($this, 'ajax_save_builder'));
    }

    public function getCategories()
    {
        if (null === $this->_categories) {
            $this->initCategories();
        }

        return $this->_categories;
    }

    public function addCategory($category_name, $category_properties, $offset = null)
    {
        if (null === $this->_categories) {
            $this->initCategories();
        }

        if (null === $offset) {
            $this->_categories[$category_name] = $category_properties;
        }

        $this->_categories = array_slice($this->_categories, 0, $offset, true) +
        array($category_name => $category_properties) +
        array_slice($this->_categories, $offset, null, true);
    }

    public function registerElementType(ElementBase $element)
    {
        $this->_element_types[$element->getName()] = $element;

        return true;
    }

    public function unregisterElementType($name)
    {
        if (!isset($this->_element_types[$name])) {
            return false;
        }

        unset($this->_element_types[$name]);

        return true;
    }

    public function getElementTypes($element_name = null)
    {
        if (is_null($this->_element_types)) {
            $this->_initElements();
        }

        if ($element_name) {
            return isset($this->_element_types[$element_name]) ? $this->_element_types[$element_name] : null;
        }

        return $this->_element_types;
    }

    public function getElementTypesConfig()
    {
        $config = array();

        foreach ($this->getElementTypes() as $element) {
            $config[$element->getName()] = $element->getConfig();
        }

        return $config;
    }

    public function renderElementsContent()
    {
        foreach ($this->getElementTypes() as $element_type) {
            $element_type->printTemplate();
        }
    }

    private function _initElements()
    {
        $this->_element_types = array();

        foreach (array('section', 'column') as $element_name) {
            $class_name = __NAMESPACE__ . '\Element' . $element_name;

            $this->registerElementType(new $class_name());
        }

        // do_action('elementor/elements/elements_registered');
    }

    private function initCategories()
    {
        $this->_categories = array(
            'basic' => array(
                'title' => __('Basic', 'elementor'),
                'icon' => 'font',
            ),
            'general-elements' => array(
                'title' => __('General Elements', 'elementor'),
                'icon' => 'font',
            ),
            // 'pojo' => array(
            //     'title' => __('Pojo Themes', 'elementor'),
            //     'icon' => 'pojome',
            // ),
            'prestashop' => array(
                'title' => __('PrestaShop', 'elementor'),
                'icon' => 'wordpress',
            ),
        );
    }

    private function requireFiles()
    {
        require_once _CE_PATH_ . 'includes/base/element-base.php';

        require _CE_PATH_ . 'includes/elements/column.php';
        require _CE_PATH_ . 'includes/elements/section.php';
        require _CE_PATH_ . 'includes/elements/repeater.php';
    }
}
