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

class WidgetGoogleMaps extends WidgetBase
{
    public function getName()
    {
        return 'google_maps';
    }

    public function getTitle()
    {
        return __('Google Maps', 'elementor');
    }

    public function getIcon()
    {
        return 'google-maps';
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_map',
            array(
                'label' => __('Map', 'elementor'),
            )
        );

        $default_address = __('London Eye, London, United Kingdom', 'elementor');
        $this->addControl(
            'address',
            array(
                'label' => __('Address', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => $default_address,
                'default' => $default_address,
                'label_block' => true,
            )
        );

        $this->addControl(
            'zoom',
            array(
                'label' => __('Zoom Level', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 10,
                ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 20,
                    ),
                ),
            )
        );

        $this->addControl(
            'height',
            array(
                'label' => __('Height', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 300,
                ),
                'range' => array(
                    'px' => array(
                        'min' => 40,
                        'max' => 1440,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'prevent_scroll',
            array(
                'label' => __('Prevent Scroll', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    '' => __('No', 'elementor'),
                    'yes' => __('Yes', 'elementor'),
                ),
                'selectors' => array(
                    '{{WRAPPER}} iframe' => 'pointer-events: none;',
                ),
            )
        );

        $this->addControl(
            'view',
            array(
                'label' => __('View', 'elementor'),
                'type' => ControlsManager::HIDDEN,
                'default' => 'traditional',
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettings();

        if (empty($settings['address'])) {
            return;
        }

        if (0 === absint($settings['zoom']['size'])) {
            $settings['zoom']['size'] = 10;
        }

        printf(
            '<div class="elementor-custom-embed"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near"></iframe></div>',
            urlencode($settings['address']),
            absint($settings['zoom']['size'])
        );
    }

    protected function _contentTemplate()
    {
    }
}
