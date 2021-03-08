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

class WidgetButton extends WidgetBase
{
    public function getName()
    {
        return 'button';
    }

    public function getTitle()
    {
        return __('Button', 'elementor');
    }

    public function getIcon()
    {
        return 'button';
    }

    public static function getButtonSizes()
    {
        return array(
            'xs' => __('Extra Small', 'elementor'),
            'sm' => __('Small', 'elementor'),
            'md' => __('Medium', 'elementor'),
            'lg' => __('Large', 'elementor'),
            'xl' => __('Extra Large', 'elementor'),
        );
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_button',
            array(
                'label' => __('Button', 'elementor'),
            )
        );

        $this->addControl(
            'button_type',
            array(
                'label' => __('Type', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => __('Default', 'elementor'),
                    'info' => __('Info', 'elementor'),
                    'success' => __('Success', 'elementor'),
                    'warning' => __('Warning', 'elementor'),
                    'danger' => __('Danger', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'text',
            array(
                'label' => __('Text', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => __('Click me', 'elementor'),
                'placeholder' => __('Click me', 'elementor'),
            )
        );

        $this->addControl(
            'link',
            array(
                'label' => __('Link', 'elementor'),
                'type' => ControlsManager::URL,
                'placeholder' => 'http://your-link.com',
                'default' => array(
                    'url' => '#',
                ),
            )
        );

        $this->addResponsiveControl(
            'align',
            array(
                'label' => __('Alignment', 'elementor'),
                'type' => ControlsManager::CHOOSE,
                'options' => array(
                    'left' => array(
                        'title' => __('Left', 'elementor'),
                        'icon' => 'align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'elementor'),
                        'icon' => 'align-center',
                    ),
                    'right' => array(
                        'title' => __('Right', 'elementor'),
                        'icon' => 'align-right',
                    ),
                    'justify' => array(
                        'title' => __('Justified', 'elementor'),
                        'icon' => 'align-justify',
                    ),
                ),
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            )
        );

        $this->addControl(
            'size',
            array(
                'label' => __('Size', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'sm',
                'options' => self::getButtonSizes(),
            )
        );

        $this->addControl(
            'icon',
            array(
                'label' => __('Icon', 'elementor'),
                'type' => ControlsManager::ICON,
                'label_block' => true,
                'default' => '',
            )
        );

        $this->addControl(
            'icon_align',
            array(
                'label' => __('Icon Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'left',
                'options' => array(
                    'left' => __('Before', 'elementor'),
                    'right' => __('After', 'elementor'),
                ),
                'condition' => array(
                    'icon!' => '',
                ),
            )
        );

        $this->addControl(
            'icon_indent',
            array(
                'label' => __('Icon Spacing', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'icon!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
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

        $this->startControlsSection(
            'section_style',
            array(
                'label' => __('Button', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'button_text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'typography',
                'label' => __('Typography', 'elementor'),
                'scheme' => SchemeTypography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-button',
            )
        );

        $this->addControl(
            'background_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'border',
                'label' => __('Border', 'elementor'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-button',
            )
        );

        $this->addControl(
            'border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'text_padding',
            array(
                'label' => __('Text Padding', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_hover',
            array(
                'label' => __('Button Hover', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'hover_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'button_background_hover_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'button_hover_border_color',
            array(
                'label' => __('Border Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'condition' => array(
                    'border_border!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'hover_animation',
            array(
                'label' => __('Animation', 'elementor'),
                'type' => ControlsManager::HOVER_ANIMATION,
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettings();

        $this->addRenderAttribute('wrapper', 'class', 'elementor-button-wrapper');

        if (!empty($settings['link']['url'])) {
            $this->addRenderAttribute('button', 'href', $settings['link']['url']);
            $this->addRenderAttribute('button', 'class', 'elementor-button-link');

            if (!empty($settings['link']['is_external'])) {
                $this->addRenderAttribute('button', 'target', '_blank');
            }
        }

        $this->addRenderAttribute('button', 'class', 'elementor-button');

        if (!empty($settings['size'])) {
            $this->addRenderAttribute('button', 'class', 'elementor-size-' . $settings['size']);
        }

        if (!empty($settings['button_type'])) {
            $this->addRenderAttribute('button', 'class', 'elementor-button-' . $settings['button_type']);
        }

        if ($settings['hover_animation']) {
            $this->addRenderAttribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }

        $this->addRenderAttribute('content-wrapper', 'class', 'elementor-button-content-wrapper');
        $this->addRenderAttribute('icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align']);
        $this->addRenderAttribute('icon-align', 'class', 'elementor-button-icon');

        ?>
        <div <?php echo $this->getRenderAttributeString('wrapper'); ?>>
            <a <?php echo $this->getRenderAttributeString('button'); ?>>
                <span <?php echo $this->getRenderAttributeString('content-wrapper'); ?>>
                    <?php if (!empty($settings['icon'])) : ?>
                        <span <?php echo $this->getRenderAttributeString('icon-align'); ?>>
                            <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
                        </span>
                    <?php endif;?>
                    <span class="elementor-button-text"><?php echo $settings['text']; ?></span>
                </span>
            </a>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-button-wrapper">
            <a class="elementor-button elementor-button-{{ settings.button_type }} elementor-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}">
                <span class="elementor-button-content-wrapper">
                    <# if ( settings.icon ) { #>
                    <span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
                        <i class="{{ settings.icon }}"></i>
                    </span>
                    <# } #>
                    <span class="elementor-button-text">{{{ settings.text }}}</span>
                </span>
            </a>
        </div>
        <?php
    }
}
