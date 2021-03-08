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

class WidgetTexteditor extends WidgetBase
{
    public function getName()
    {
        return 'text-editor';
    }

    public function getTitle()
    {
        return __('Text Editor', 'elementor');
    }

    public function getIcon()
    {
        return 'align-left';
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_editor',
            array(
                'label' => __('Text Editor', 'elementor'),
            )
        );

        $this->addControl(
            'editor',
            array(
                'label' => '',
                'type' => ControlsManager::WYSIWYG,
                'default' => '<p>' . __('I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor') . '</p>',
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style',
            array(
                'label' => __('Text Editor', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
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
                'selectors' => array(
                    '{{WRAPPER}} .elementor-text-editor' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $editor_content = $this->getSettings('editor');

        $editor_content = $this->parseTextEditor($editor_content);
        ?>
        <div class="elementor-text-editor elementor-clearfix rte-content"><?php echo $editor_content; ?></div>
        <?php
    }

    public function renderPlainContent()
    {
        // In plain mode, render without shortcode
        echo $this->getSettings('editor');
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-text-editor elementor-clearfix rte-content">{{{ settings.editor }}}</div>
        <?php
    }
}
