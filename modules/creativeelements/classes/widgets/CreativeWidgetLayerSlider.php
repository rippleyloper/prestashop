<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

class CreativeWidgetLayerSlider
{
    public static $require = 'layerslider';

    /**
     * @var string widget id
     */
    public $id_base = 'LayerSlider';

    /**
     * @var string widget name
     */
    public $name;

    /**
     * @var string widget icon
     */
    public $icon = 'slider-push';

    public $editMode = false;

    public function __construct()
    {
        $this->name = CreativeElements\__('Creative Slider', 'elementor');
        $this->context = Context::getContext();

        if (isset($this->context->controller->controller_name) && $this->context->controller->controller_name == 'CreativeEditor') {
            $this->editMode = true;
        }
    }

    public function getForm()
    {
        $options = array(0 => CreativeElements\__('- Select Slider -', 'elementor'));

        if ($this->editMode) {
            $sliders = $this->getSliders();

            if ($sliders) {
                foreach ($sliders as $slider) {
                    $options[$slider['id']] = "#{$slider['id']} - " . $slider['name'];
                }
            }
        }
        return array(
            'section_pswidget_options' => array(
                'label' => CreativeElements\__('Creative Slider', 'elementor'),
                'type' => 'section',
            ),
            'slider' => array(
                'label' => CreativeElements\__('Slider', 'elementor'),
                'type' => 'select',
                'default' => '0',
                'section' => 'section_pswidget_options',
                'options' => $options,
            ),
        );
    }

    public function getSliders()
    {
        $table = _DB_PREFIX_ . 'layerslider';
        return Db::getInstance()->executeS("SELECT id, name, slug FROM $table WHERE flag_hidden = 0 AND flag_deleted = 0 ORDER BY date_m DESC LIMIT 100");
    }

    public function parseOptions($optionsSource, $preview = false)
    {
        $slider = '';
        $sliderId = empty($optionsSource['slider']) ? 0 : (int) $optionsSource['slider'];
        $previewId = \Tools::getValue('render') == 'widget' ? $sliderId : 0;

        if ($sliderId) {
            $mod = Module::getInstanceByName('layerslider');

            if (Validate::isLoadedObject($mod)) {
                $mod->_prehook();
                $slider = $mod->generateSlider($sliderId);
            }
        }

        return array(
            'slider' => $slider,
            'previewId' => $previewId,
        );
    }
}
