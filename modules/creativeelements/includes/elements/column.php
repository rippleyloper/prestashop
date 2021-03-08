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

class ElementColumn extends ElementBase
{
    protected static $_edit_tools;

    protected static function getDefaultEditTools()
    {
        return array(
            'duplicate' => array(
                'title' => __('Duplicate', 'elementor'),
                'icon' => 'files-o',
            ),
            'add' => array(
                'title' => __('Add', 'elementor'),
                'icon' => 'plus',
            ),
            'remove' => array(
                'title' => __('Remove', 'elementor'),
                'icon' => 'times',
            ),
        );
    }

    public function getName()
    {
        return 'column';
    }

    public function getTitle()
    {
        return __('Column', 'elementor');
    }

    public function getIcon()
    {
        return 'columns';
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_style',
            array(
                'label' => __('Background & Border', 'elementor'),
                'type' => ControlsManager::SECTION,
            )
        );

        $this->addGroupControl(
            GroupControlBackground::getType(),
            array(
                'name' => 'background',
                'selector' => '{{WRAPPER}} > .elementor-element-populated',
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'border',
                'selector' => '{{WRAPPER}} > .elementor-element-populated',
            )
        );

        $this->addControl(
            'border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-element-populated' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBoxShadow::getType(),
            array(
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} > .elementor-element-populated',
            )
        );

        $this->endControlsSection();

        // Section Typography
        $this->startControlsSection(
            'section_typo',
            array(
                'label' => __('Typography', 'elementor'),
                'type' => ControlsManager::SECTION,
            )
        );

        $this->addControl(
            'heading_color',
            array(
                'label' => __('Heading Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-element-populated .elementor-heading-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'color_text',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-element-populated' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'color_link',
            array(
                'label' => __('Link Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-element-populated a' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'color_link_hover',
            array(
                'label' => __('Link Hover Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-element-populated a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'text_align',
            array(
                'label' => __('Text Align', 'elementor'),
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
                    '{{WRAPPER}} > .elementor-element-populated' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->endControlsSection();

        // Section Advanced
        $this->startControlsSection(
            'section_advanced',
            array(
                'label' => __('Advanced', 'elementor'),
                'type' => ControlsManager::SECTION,
                'tab' => ControlsManager::TAB_ADVANCED,
            )
        );

        $this->addResponsiveControl(
            'margin',
            array(
                'label' => __('Margin', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-element-populated' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addResponsiveControl(
            'padding',
            array(
                'label' => __('Padding', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-element-populated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'animation',
            array(
                'label' => __('Entrance Animation', 'elementor'),
                'type' => ControlsManager::ANIMATION,
                'default' => '',
                'prefix_class' => 'animated ',
                'label_block' => true,
            )
        );

        $this->addControl(
            'animation_duration',
            array(
                'label' => __('Animation Duration', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    'slow' => __('Slow', 'elementor'),
                    '' => __('Normal', 'elementor'),
                    'fast' => __('Fast', 'elementor'),
                ),
                'prefix_class' => 'animated-',
                'condition' => array(
                    'animation!' => '',
                ),
            )
        );

        $this->addControl(
            'css_classes',
            array(
                'label' => __('CSS Classes', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => '',
                'prefix_class' => '',
                'label_block' => true,
                'title' => __('Add your custom class WITHOUT the dot. e.g: my-class', 'elementor'),
            )
        );

        $this->endControlsSection();

        // Section Responsive
        $this->startControlsSection(
            'section_responsive',
            array(
                'label' => __('Responsive', 'elementor'),
                'tab' => ControlsManager::TAB_ADVANCED,
            )
        );

        $responsive_points = array(
            'screen_sm' => array(
                'title' => __('Mobile Width', 'elementor'),
                'class_prefix' => 'elementor-sm-',
                'classes' => '',
                'description' => '',
            ),
        );

        foreach ($responsive_points as $point_name => $point_data) {
            $this->addControl(
                $point_name,
                array(
                    'label' => $point_data['title'],
                    'type' => ControlsManager::SELECT,
                    'default' => 'default',
                    'options' => array(
                        'default' => __('Default', 'elementor'),
                        'custom' => __('Custom', 'elementor'),
                    ),
                    'description' => $point_data['description'],
                    'classes' => $point_data['classes'],
                )
            );

            $this->addControl(
                $point_name . '_width',
                array(
                    'label' => __('Column Width', 'elementor'),
                    'type' => ControlsManager::SELECT,
                    'options' => array(
                        '10' => '10%',
                        '11' => '11%',
                        '12' => '12%',
                        '14' => '14%',
                        '16' => '16%',
                        '20' => '20%',
                        '25' => '25%',
                        '30' => '30%',
                        '33' => '33%',
                        '40' => '40%',
                        '50' => '50%',
                        '60' => '60%',
                        '66' => '66%',
                        '70' => '70%',
                        '75' => '75%',
                        '80' => '80%',
                        '83' => '83%',
                        '90' => '90%',
                        '100' => '100%',
                    ),
                    'default' => '100',
                    'condition' => array(
                        $point_name => array('custom'),
                    ),
                    'prefix_class' => $point_data['class_prefix'],
                )
            );
        }
    }

    protected function _renderSettings()
    {
        ?>
        <div class="elementor-element-overlay">
            <div class="column-title"></div>
            <div class="elementor-editor-element-settings elementor-editor-column-settings">
                <ul class="elementor-editor-element-settings-list elementor-editor-column-settings-list">
                    <li class="elementor-editor-element-setting elementor-editor-element-trigger">
                        <a href="#" title="<?php _e('Drag Column', 'elementor');?>"><?php _e('Column', 'elementor');?></a>
                    </li>
                    <?php foreach (self::getEditTools() as $edit_tool_name => $edit_tool) : ?>
                        <li class="elementor-editor-element-setting elementor-editor-element-<?php echo $edit_tool_name; ?>">
                            <a href="#" title="<?php _e($edit_tool['title']); ?>">
                                <span class="elementor-screen-only"><?php _e($edit_tool['title']); ?></span>
                                <i class="fa fa-<?php echo $edit_tool['icon']; ?>"></i>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
                <ul class="elementor-editor-element-settings-list  elementor-editor-section-settings-list">
                    <li class="elementor-editor-element-setting elementor-editor-element-trigger">
                        <a href="#" title="<?php _e('Drag Section', 'elementor');?>"><?php _e('Section', 'elementor');?></a>
                    </li>
                    <?php foreach (ElementSection::getEditTools() as $edit_tool_name => $edit_tool) : ?>
                        <li class="elementor-editor-element-setting elementor-editor-element-<?php echo $edit_tool_name; ?>">
                            <a href="#" title="<?php _e($edit_tool['title']); ?>">
                                <span class="elementor-screen-only"><?php _e($edit_tool['title']); ?></span>
                                <i class="fa fa-<?php echo $edit_tool['icon']; ?>"></i>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-column-wrap">
            <div class="elementor-widget-wrap"></div>
        </div>
        <?php
    }

    public function beforeRender()
    {
        $is_inner = $this->getData('isInner');

        $column_type = !empty($is_inner) ? 'inner' : 'top';

        $settings = $this->getSettings();

        $this->addRenderAttribute('wrapper', 'class', array(
            'elementor-column',
            'elementor-element',
            'elementor-element-' . $this->getId(),
            'elementor-col-' . $settings['_column_size'],
            'elementor-' . $column_type . '-column',
        ));

        foreach (self::getClassControls() as $control) {
            if (empty($settings[$control['name']])) {
                continue;
            }

            if (!$this->isControlVisible($control)) {
                continue;
            }

            $this->addRenderAttribute('wrapper', 'class', $control['prefix_class'] . $settings[$control['name']]);
        }

        if (!empty($settings['animation'])) {
            $this->addRenderAttribute('wrapper', 'data-animation', $settings['animation']);
        }

        $this->addRenderAttribute('wrapper', 'data-element_type', self::getName());
        ?>
        <div <?php echo $this->getRenderAttributeString('wrapper'); ?>>
            <div class="elementor-column-wrap<?php echo $this->getChildren() ? ' elementor-element-populated' : '' ?>">
                <div class="elementor-widget-wrap">
        <?php
    }

    public function afterRender()
    {
        ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _getChildType(array $element_data)
    {
        if ('section' === $element_data['elType']) {
            return Plugin::instance()->elements_manager->getElementTypes('section');
        }

        return Plugin::instance()->widgets_manager->getWidgetTypes($element_data['widgetType']);
    }
}
