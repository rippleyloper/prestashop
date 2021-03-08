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

class PostCssFile
{
    const FILE_BASE_DIR = 'modules/creativeelements/views/css/pages';
    // %s: Base folder; %s: file prefix; %d: post_id
    const FILE_NAME_PATTERN = '%s/%s%d-%d-%d.css';
    const FILE_PREFIX = 'page-';

    const CSS_STATUS_FILE = 'file';
    const CSS_STATUS_INLINE = 'inline';
    const CSS_STATUS_EMPTY = 'empty';

    const META_KEY_CSS = '_elementor_css';

    protected $post_id;
    protected $lang_id;
    protected $shop_id;
    protected $is_build_with_elementor = true;
    protected $path;
    protected $url;
    protected $css = '';
    protected $fonts = array();

    /**
     * @var Stylesheet
     */
    protected $stylesheet_obj;
    protected $_columns_width;

    public function __construct($post_id, $lang_id, $shop_id = null)
    {
        $this->post_id = $post_id;
        $this->lang_id = $lang_id;
        $this->shop_id = (int) ($shop_id === null ? \Context::getContext()->shop->id : $shop_id);

        // Check if it's an Elementor post
        // $db = Plugin::instance()->db;

        // $data = $db->get_plain_editor($post_id);
        // $edit_mode = $db->get_edit_mode($post_id);

        // $this->is_build_with_elementor = (!empty($data) && 'builder' === $edit_mode);

        // if (!$this->is_build_with_elementor) {
        //     return;
        // }

        $this->setPathAndUrl();
        $this->initStylesheet();
    }

    public function update()
    {
        if (!$this->isBuildWithElementor()) {
            return;
        }

        $this->parseElementsCss();

        $meta = array(
            'version' => _CE_VERSION_,
            'time' => time(),
            'fonts' => array_unique($this->fonts),
        );

        if (empty($this->css)) {
            $this->delete();

            $meta['status'] = self::CSS_STATUS_EMPTY;
            $meta['css'] = '';
        } else {
            $file_created = false;

            if (is_writable(dirname($this->path))) {
                $file_created = file_put_contents($this->path, $this->css);
            }

            if ($file_created) {
                $meta['status'] = self::CSS_STATUS_FILE;
            } else {
                $meta['status'] = self::CSS_STATUS_INLINE;
                $meta['css'] = $this->css;
            }
        }

        $this->updateMeta($meta);
    }

    public function delete()
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }

    public function enqueue()
    {
        if (!$this->isBuildWithElementor()) {
            return;
        }

        $meta = $this->getMeta();
        $frontend = Plugin::instance()->frontend;

        if (self::CSS_STATUS_EMPTY === $meta['status']) {
            return;
        }

        if (version_compare(_CE_VERSION_, $meta['version'], '>')) {
            $this->update();
            // Refresh new meta
            $meta = $this->getMeta();
        }

        if (self::CSS_STATUS_INLINE === $meta['status']) {
            $css = '<style>' . $meta['css'] . '</style>';
        } else {
            $css = "<link type='text/css' href='{$this->url}?{$meta['time']}' rel='stylesheet'>";
        }

        Helper::$enqueue_css[] = $css;

        // Handle fonts
        if (!empty($meta['fonts'])) {
            foreach ($meta['fonts'] as $font) {
                $frontend->addEnqueueFont($font);
            }
        }
    }

    public function isBuildWithElementor()
    {
        return $this->is_build_with_elementor;
    }

    public function getElementUniqueSelector(ElementBase $element)
    {
        return '.elementor-' . $this->post_id . ' .elementor-element.elementor-element-' . $element->getId();
    }

    public function getCss()
    {
        if (empty($this->css)) {
            $this->parseElementsCss();
        }

        echo $this->css;
    }

    protected function initStylesheet()
    {
        $this->stylesheet_obj = new Stylesheet();

        $breakpoints = Responsive::getBreakpoints();

        $this->stylesheet_obj
            ->addDevice('mobile', $breakpoints['md'] - 1)
            ->addDevice('tablet', $breakpoints['lg'] - 1);
    }

    protected function setPathAndUrl()
    {
        $relative_path = sprintf(self::FILE_NAME_PATTERN, self::FILE_BASE_DIR, self::FILE_PREFIX, $this->post_id, $this->lang_id, $this->shop_id);
        $this->path = _PS_ROOT_DIR_ . '/' . $relative_path;
        $this->url = __PS_BASE_URI__ . $relative_path;
    }

    protected function getMeta()
    {
        $meta = get_post_meta($this->post_id, self::META_KEY_CSS, $this->lang_id, $this->shop_id);

        $defaults = array(
            'version' => '',
            'status' => '',
        );

        $meta = wp_parse_args($meta, $defaults);

        return $meta;
    }

    protected function updateMeta($meta)
    {
        return update_post_meta($this->post_id, self::META_KEY_CSS, $meta, $this->lang_id, $this->shop_id);
    }

    protected function parseElementsCss()
    {
        if (!$this->isBuildWithElementor()) {
            return;
        }

        // $data = Plugin::instance()->db->get_plain_editor($this->post_id);
        $elem = new \CreativePage($this->post_id, $this->lang_id, $this->shop_id);
        $data = (array) json_decode($elem->data, true);

        $css = '';

        foreach ($data as $section_data) {
            $section = new ElementSection($section_data);
            $this->renderStyles($section);
        }

        $css .= $this->stylesheet_obj;

        if (!empty($this->_columns_width)) {
            $css .= '@media (min-width: 768px) {';
            foreach ($this->_columns_width as $column_width) {
                $css .= $column_width;
            }
            $css .= '}';
        }

        $this->css = $css;
    }

    private function addElementStyleRules(ElementBase $element, $controls, $values, $placeholders, $replacements)
    {
        foreach ($controls as $control) {
            $control_value = $values[$control['name']];

            if (!empty($control['style_fields'])) {
                foreach ($control_value as $field_value) {
                    $this->addElementStyleRules(
                        $element,
                        $control['style_fields'],
                        $field_value,
                        array_merge($placeholders, array('{{CURRENT_ITEM}}')),
                        array_merge($replacements, array('.elementor-repeater-item-' . $field_value['_id']))
                    );
                }
            }

            if (!$element->isControlVisible($control, $values)) {
                continue;
            }

            $this->addControlStyleRules($control, $control_value, $placeholders, $replacements);
        }

        foreach ($element->getChildren() as $child_element) {
            $this->renderStyles($child_element);
        }
    }

    private function addControlStyleRules($control, $value, $placeholders, $replacements)
    {
        if (!is_numeric($value) && !is_float($value) && empty($value)) {
            return;
        }

        if (ControlsManager::FONT === $control['type']) {
            $this->fonts[] = $value;
        }

        $control_obj = Plugin::instance()->controls_manager->getControl($control['type']);

        if (!isset($control['selectors'])) {
            return;
        }

        foreach ($control['selectors'] as $selector => $css_property) {
            $parsed_css_property = $control_obj->getReplacedStyleValues($css_property, $value);

            if (!$parsed_css_property) {
                continue;
            }

            $parsed_selector = str_replace($placeholders, $replacements, $selector);

            $device = !empty($control['responsive']) ? $control['responsive'] : ElementBase::RESPONSIVE_DESKTOP;

            $this->stylesheet_obj->addRules($parsed_selector, $parsed_css_property, $device);
        }
    }

    private function renderStyles(ElementBase $element)
    {
        $element_settings = $element->getSettings();

        $this->addElementStyleRules($element, $element->getStyleControls(), $element_settings, array('{{WRAPPER}}'), array($this->getElementUniqueSelector($element)));

        if ('column' === $element->getName()) {
            if (!empty($element_settings['_inline_size'])) {
                $this->_columns_width[] = $this->getElementUniqueSelector($element) . '{width:' . $element_settings['_inline_size'] . '%;}';
            }
        }
    }
}
