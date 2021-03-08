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

class WidgetCounter extends WidgetBase
{
    public function getName()
    {
        return 'counter';
    }

    public function getTitle()
    {
        return __('Counter', 'elementor');
    }

    public function getIcon()
    {
        return 'counter';
    }

    public function getCategories()
    {
        return array('general-elements');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_counter',
            array(
                'label' => __('Counter', 'elementor'),
            )
        );

        $this->addControl(
            'starting_number',
            array(
                'label' => __('Starting Number', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'min' => 0,
                'default' => 0,
            )
        );

        $this->addControl(
            'ending_number',
            array(
                'label' => __('Ending Number', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'min' => 1,
                'default' => 100,
            )
        );

        $this->addControl(
            'prefix',
            array(
                'label' => __('Number Prefix', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => '',
                'placeholder' => 1,
            )
        );

        $this->addControl(
            'suffix',
            array(
                'label' => __('Number Suffix', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => '',
                'placeholder' => __('Plus', 'elementor'),
            )
        );

        $this->addControl(
            'duration',
            array(
                'label' => __('Animation Duration', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'default' => 2000,
                'min' => 100,
                'step' => 100,
            )
        );

        $this->addControl(
            'title',
            array(
                'label' => __('Title', 'elementor'),
                'type' => ControlsManager::TEXT,
                'label_block' => true,
                'default' => __('Cool Number', 'elementor'),
                'placeholder' => __('Cool Number', 'elementor'),
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

        $this->startControlsSection(
            'section_number',
            array(
                'label' => __('Number', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'number_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-counter-number-wrapper' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'typography_number',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-counter-number-wrapper',
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_title',
            array(
                'label' => __('Title', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'title_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-counter-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'typography_title',
                'scheme' => SchemeTypography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-counter-title',
            )
        );

        $this->endControlsSection();
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-counter">
            <div class="elementor-counter-number-wrapper">
                <#
                var prefix = '',
                    suffix = '';

                if ( settings.prefix ) {
                    prefix = '<span class="elementor-counter-number-prefix">' + settings.prefix + '</span>';
                }

                var duration = '<span class="elementor-counter-number" data-duration="' + settings.duration + '" data-to_value="' + settings.ending_number + '">' + settings.starting_number + '</span>';

                if ( settings.suffix ) {
                    suffix = '<span class="elementor-counter-number-suffix">' + settings.suffix + '</span>';
                }

                print( prefix + duration + suffix );
                #>
            </div>
            <# if ( settings.title ) { #>
                <div class="elementor-counter-title">{{{ settings.title }}}</div>
            <# } #>
        </div>
        <?php
    }

    public function render()
    {
        $settings = $this->getSettings();
        ?>
        <div class="elementor-counter">
            <div class="elementor-counter-number-wrapper">
                <?php
                $prefix = $suffix = '';

                if ($settings['prefix']) {
                    $prefix = '<span class="elementor-counter-number-prefix">' . $settings['prefix'] . '</span>';
                }

                $duration = '<span class="elementor-counter-number" data-duration="' . $settings['duration'] . '" data-to_value="' . $settings['ending_number'] . '">' . $settings['starting_number'] . '</span>';

                if ($settings['suffix']) {
                    $suffix = '<span class="elementor-counter-number-suffix">' . $settings['suffix'] . '</span>';
                }

                echo $prefix . $duration . $suffix;
                ?>
            </div>
            <?php if ($settings['title']) : ?>
                <div class="elementor-counter-title"><?php echo $settings['title']; ?></div>
            <?php endif;?>
        </div>
        <?php
    }
}
