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

class Frontend
{
    private $_enqueue_google_fonts = array();
    private $_enqueue_google_early_access_fonts = array();

    private $_is_frontend_mode = false;

    /**
     * @var Stylesheet
     */
    private $stylesheet;

    public function init()
    {
        $this->_is_frontend_mode = true;

        $this->_initStylesheet();
    }

    private function _initStylesheet()
    {
        $this->stylesheet = new Stylesheet();

        $breakpoints = Responsive::getBreakpoints();

        $this->stylesheet
            ->addDevice('mobile', $breakpoints['md'] - 1)
            ->addDevice('tablet', $breakpoints['lg'] - 1);
    }

    protected function _printSections($sections_data)
    {
        foreach ($sections_data as $section_data) {
            $section = new ElementSection($section_data);

            $section->printElement();
        }
    }

    public function enqueueScripts()
    {
        $suffix = defined('_PS_MODE_DEV_') && _PS_MODE_DEV_ ? '' : '.min';

        wp_register_script(
            'waypoints',
            _CE_ASSETS_URL_ . 'lib/waypoints/waypoints' . $suffix . '.js',
            array(
                'jquery',
            ),
            '2.0.2',
            true
        );

        wp_register_script(
            'jquery-numerator',
            _CE_ASSETS_URL_ . 'lib/jquery-numerator/jquery-numerator' . $suffix . '.js',
            array(
                'jquery',
            ),
            '0.2.0',
            true
        );

        wp_register_script(
            'jquery-slick',
            _CE_ASSETS_URL_ . 'lib/slick/slick' . $suffix . '.js',
            array(
                'jquery',
            ),
            '1.6.0',
            true
        );

        wp_register_script(
            'elementor-frontend',
            _CE_ASSETS_URL_ . 'js/frontend' . $suffix . '.js',
            array(
                'waypoints',
                'jquery-numerator',
                'jquery-slick',
            ),
            _CE_VERSION_,
            true
        );
        wp_enqueue_script('elementor-frontend');

        wp_localize_script(
            'elementor-frontend',
            'elementorFrontendConfig',
            array(
                'isEditMode' => Plugin::instance()->editor->isEditMode(),
                'stretchedSectionContainer' => get_option('elementor_stretched_section_container', ''),
                'is_rtl' => !empty(\Context::getContext()->language->is_rtl),
            )
        );
    }

    public function printCss()
    {
        $container_width = absint(get_option('elementor_container_width'));
        if (!empty($container_width)) {
            $this->stylesheet->addRules('.elementor-section.elementor-section-boxed > .elementor-container', 'max-width:' . $container_width . 'px');
        }

        $this->_parseSchemesCssCode();

        $css_code = $this->stylesheet;

        if (empty($css_code)) {
            return;
        }
        ?>
        <style id="elementor-frontend-stylesheet"><?php echo $css_code; ?></style>
        <?php
        while (!empty(Helper::$enqueue_css)) {
            echo array_pop(Helper::$enqueue_css);
        }
        $this->printGoogleFonts();
    }

    public function printGoogleFonts()
    {
        // Enqueue used fonts
        if (!empty($this->_enqueue_google_fonts)) {
            foreach ($this->_enqueue_google_fonts as &$font) {
                $font = str_replace(' ', '+', $font) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
            }

            $fonts_url = sprintf('https://fonts.googleapis.com/css?family=%s', implode('|', $this->_enqueue_google_fonts));

            $subsets = array(
                'ru' => 'cyrillic',
                'bg' => 'cyrillic',
                'he' => 'hebrew',
                'el' => 'greek',
                'vi' => 'vietnamese',
                'uk' => 'cyrillic',
            );
            $locale = \Context::getContext()->language->iso_code;

            if (isset($subsets[$locale])) {
                $fonts_url .= '&subset=' . $subsets[$locale];
            }

            echo '<link rel="stylesheet" type="text/css" href="' . $fonts_url . '">';
            $this->_enqueue_google_fonts = array();
        }

        if (!empty($this->_enqueue_google_early_access_fonts)) {
            foreach ($this->_enqueue_google_early_access_fonts as $current_font) {
                printf('<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/%s.css">', \Tools::strtolower(str_replace(' ', '', $current_font)));
            }
            $this->_enqueue_google_early_access_fonts = array();
        }
    }

    public function addEnqueueFont($font)
    {
        switch (Fonts::getFontType($font)) {
            case Fonts::GOOGLE:
                if (!in_array($font, $this->_enqueue_google_fonts)) {
                    $this->_enqueue_google_fonts[] = $font;
                }
                break;

            case Fonts::EARLYACCESS:
                if (!in_array($font, $this->_enqueue_google_early_access_fonts)) {
                    $this->_enqueue_google_early_access_fonts[] = $font;
                }
                break;
        }
    }

    protected function _parseSchemesCssCode()
    {
        foreach (Plugin::instance()->widgets_manager->getWidgetTypes() as $widget) {
            foreach ($widget->getSchemeControls() as $control) {
                $scheme_value = Plugin::instance()->schemes_manager->getSchemeValue($control['scheme']['type'], $control['scheme']['value']);
                if (empty($scheme_value)) {
                    continue;
                }

                if (!empty($control['scheme']['key'])) {
                    $scheme_value = $scheme_value[$control['scheme']['key']];
                }

                if (empty($scheme_value)) {
                    continue;
                }

                $element_unique_class = 'elementor-widget-' . $widget->getName();
                $control_obj = Plugin::instance()->controls_manager->getControl($control['type']);

                if (ControlsManager::FONT === $control_obj->getType()) {
                    $this->addEnqueueFont($scheme_value);
                }

                foreach ($control['selectors'] as $selector => $css_property) {
                    $output_selector = str_replace('{{WRAPPER}}', '.' . $element_unique_class, $selector);
                    $output_css_property = $control_obj->getReplacedStyleValues($css_property, $scheme_value);

                    $this->stylesheet->addRules($output_selector, $output_css_property);
                }
            }
        }
    }

    /*
    public function applyBuilderInContent($content)
    {
        if (!$this->_is_frontend_mode) {
            return $content;
        }

        $builder_content = $this->getBuilderContent();

        if (!empty($builder_content)) {
            $content = $builder_content;
        }

        // Add the filter again for other `the_content` calls
        // add_filter('the_content', array($this, 'apply_builder_in_content'));

        return $content;
    }
    */

    public function getBuilderContent($post_id, $lang_id, $data, $with_css = false)
    {
        // $data = Plugin::instance()->db->get_plain_editor($post_id);
        // $edit_mode = Plugin::instance()->db->get_edit_mode($post_id);

        // if (empty($data) || 'builder' !== $edit_mode) {
        //     return '';
        // }

        $css_file = new PostCssFile($post_id, $lang_id);
        $css_file->enqueue();

        ob_start();
        ?>
        <?php if ($with_css) : ?>
            <style><?php $css_file->getCss(); ?></style>
        <?php endif ?>

        <div class="elementor elementor-<?php echo $post_id; ?>">
            <div id="elementor-inner">
                <div id="elementor-section-wrap">
                    <?php $this->_printSections($data);?>
                </div>
            </div>
        </div>
        <?php

        // return apply_filters('elementor/frontend/the_content', ob_get_clean());
        return ob_get_clean();
    }

    /*
    public function getBuilderContentForDisplay($post_id)
    {
        // Avoid recursion
        if (get_the_ID() === (int) $post_id) {
            $content = '';
            if (Plugin::instance()->editor->isEditMode()) {
                $content = '<div class="elementor-alert elementor-alert-danger">' . __('Invalid Data: The Template ID cannot be the same as the currently edited template. Please choose a different one.', 'elementor') . '</div>';
            }

            return $content;
        }

        // Set edit mode as false, so don't render settings and etc. use the $is_edit_mode to indicate if we need the css inline
        $is_edit_mode = Plugin::instance()->editor->isEditMode();
        Plugin::instance()->editor->setEditMode(false);

        $content = $this->getBuilderContent($post_id, $is_edit_mode);

        // Restore edit mode state
        Plugin::instance()->editor->setEditMode($is_edit_mode);

        return $content;
    }
    */

    public function __construct()
    {
        $this->init();
    }
}
