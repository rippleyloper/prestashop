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

class WidgetEmailSubscription extends WidgetBase
{
    public function getName()
    {
        return 'email-subscription';
    }

    public function getTitle()
    {
        return __('Email Subscription', 'elementor');
    }

    public function getIcon()
    {
        return 'email-field';
    }

    public function getCategories()
    {
        return array('prestashop');
    }

    public function getModuleLink()
    {
        if (empty($this->context->employee->id)) {
            return '#';
        }
        return $this->context->link->getAdminLink('AdminModules') . '&configure=ps_emailsubscription';
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_email_subscription',
            array(
                'label' => __('Email Subscription', 'elementor'),
            )
        );

        $this->addControl(
            'configure_module',
            array(
                'raw' =>
                    '<a class="elementor-button elementor-button-default" href="' . $this->getModuleLink() . '" target="_blank">' .
                        '<i class="fa fa-external-link"></i> ' . __('Configure Module', 'elementor') .
                    '</a>',
                'type' => ControlsManager::RAW_HTML,
                'classes' => 'elementor-control-descriptor',
            )
        );

        $this->addControl(
            'placeholder',
            array(
                'label' => __('Input Placeholder', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Your email address', 'Shop.Forms.Labels'),
            )
        );

        $this->addControl(
            'button',
            array(
                'label' => __('Button', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Subscribe', 'Shop.Theme.Actions'),
            )
        );

        $this->addControl(
            'button_spacing',
            array(
                'label' => __('Spacing', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'size_units' => array('px', '%'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'size' => '0',
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'margin-right: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'input_height',
            array(
                'label' => __('Height', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'size_units' => array('px', 'em', 'rem'),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 200,
                    ),
                ),
                'default' => array(
                    'size' => '40',
                    'unit' => 'px',
                ),
                'separator' => '',
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'border: none; vertical-align: middle; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} button.elementor-button' => 'border: none; vertical-align: middle; height: {{SIZE}}{{UNIT}};',
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
            'icon',
            array(
                'label' => __('Button Icon', 'elementor'),
                'type' => ControlsManager::ICON,
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
                'separator' => '',
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
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'icon!' => '',
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
            'section_input_style',
            array(
                'label' => __('Input', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'input_text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '#7a7a7a',
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addResponsiveControl(
            'input_width',
            array(
                'label' => __('Width', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'size_units' => array('px', '%'),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 1600,
                    ),
                ),
                'responsive' => true,
                'default' => array(
                    'size' => '300',
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'max-width: 100%; width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addResponsiveControl(
            'input_align',
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
                ),
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'input_typography',
                'label' => __('Typography', 'elementor'),
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} input[name=email]',
            )
        );

        $this->addControl(
            'input_background_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'input_border',
                'label' => __('Border', 'elementor'),
                'default' => array(
                    'border' => 'solid',
                    'width' => array(
                        'top' => '1',
                        'right' => '1',
                        'bottom' => '1',
                        'left' => '1',
                        'unit' => 'px',
                    ),
                    'color' => 'rgba(0, 0, 0, 0.25)',
                ),
                'selector' => '{{WRAPPER}} input[name=email]',
            )
        );

        $this->addControl(
            'input_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'default' => array(
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'input_padding',
            array(
                'label' => __('Text Padding', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'default' => array(
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} input[name=email]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_button_style',
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
                    '{{WRAPPER}} button.elementor-button' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'button_typography',
                'label' => __('Typography', 'elementor'),
                'scheme' => SchemeTypography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} button.elementor-button',
            )
        );

        $this->addControl(
            'button_background_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '#2fb5d2',
                'selectors' => array(
                    '{{WRAPPER}} button.elementor-button' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'button_border',
                'label' => __('Border', 'elementor'),
                'selector' => '{{WRAPPER}} button.elementor-button',
            )
        );

        $this->addControl(
            'button_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'default' => array(
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} button.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'button_padding',
            array(
                'label' => __('Text Padding', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'default' => array(
                    'top' => '10',
                    'right' => '20',
                    'bottom' => '10',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ),
                'selectors' => array(
                    '{{WRAPPER}} button.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_button_hover',
            array(
                'label' => __('Button Hover', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'button_hover_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} button.elementor-button:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'button_background_hover_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '#2592a9',
                'selectors' => array(
                    '{{WRAPPER}} button.elementor-button:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'button_hover_border_color',
            array(
                'label' => __('Border Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'condition' => array(
                    'button_border_border!' => '',
                ),
                'selectors' => array(
                    '{{WRAPPER}} button.elementor-button:hover' => 'border-color: {{VALUE}};',
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
        $module = \Module::getInstanceByName('ps_emailsubscription');

        $vars = $module->getWidgetVariables();
        $vars['settings'] = $this->getSettings();

        $this->context->smarty->assign($vars);

        echo $this->context->smarty->fetch(_CE_PATH_ . 'views/templates/front/widgets/ps_emailsubscription.tpl');
    }

    protected function _contentTemplate()
    {
    }

    public function __construct($data = array(), $args = array())
    {
        $this->context = \Context::getContext();
        parent::__construct($data, $args);
    }
}
