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

class WidgetSpacer extends WidgetBase
{
    public function getName()
    {
        return 'spacer';
    }

    public function getTitle()
    {
        return __('Spacer', 'elementor');
    }

    public function getCategories()
    {
        return array('basic');
    }

    public function getIcon()
    {
        return 'spacer';
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_spacer',
            array(
                'label' => __('Spacer', 'elementor'),
            )
        );

        $this->addResponsiveControl(
            'space',
            array(
                'label' => __('Space (PX)', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 50,
                ),
                'range' => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 600,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-spacer-inner' => 'height: {{SIZE}}{{UNIT}};',
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
        ?>
        <div class="elementor-spacer">
            <div class="elementor-spacer-inner"></div>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-spacer">
            <div class="elementor-spacer-inner"></div>
        </div>
        <?php
    }
}
