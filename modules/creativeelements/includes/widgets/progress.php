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

class WidgetProgress extends WidgetBase
{
    public function getName()
    {
        return 'progress';
    }

    public function getTitle()
    {
        return __('Progress Bar', 'elementor');
    }

    public function getIcon()
    {
        return 'skill-bar';
    }

    public function getCategories()
    {
        return array('general-elements');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_progress',
            array(
                'label' => __('Progress Bar', 'elementor'),
            )
        );

        $this->addControl(
            'title',
            array(
                'label' => __('Title', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Enter your title', 'elementor'),
                'default' => __('My Skill', 'elementor'),
                'label_block' => true,
            )
        );

        $this->addControl(
            'progress_type',
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
            'percent',
            array(
                'label' => __('Percentage', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 50,
                    'unit' => '%',
                ),
                'label_block' => true,
            )
        );

        $this->addControl(
            'display_percentage',
            array(
                'label' => __('Display Percentage', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'show',
                'options' => array(
                    'show' => __('Show', 'elementor'),
                    'hide' => __('Hide', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'inner_text',
            array(
                'label' => __('Inner Text', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('e.g. Web Designer', 'elementor'),
                'default' => __('Web Designer', 'elementor'),
                'label_block' => true,
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
            'section_progress_style',
            array(
                'label' => __('Progress Bar', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'bar_color',
            array(
                'label' => __('Bar Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-bar' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'bar_bg_color',
            array(
                'label' => __('Bar Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-progress-wrapper' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'bar_inline_color',
            array(
                'label' => __('Inner Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-inner-text' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_title',
            array(
                'label' => __('Title Style', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'title_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-title' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .elementor-title',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettings();

        $html = '';

        $this->addRenderAttribute('wrapper', 'class', 'elementor-progress-wrapper');

        if (!empty($settings['progress_type'])) {
            $this->addRenderAttribute('wrapper', 'class', 'progress-' . $settings['progress_type']);
        }

        if (!empty($settings['title'])) {
            $html .= '<span class="elementor-title">' . $settings['title'] . '</span>';
        }

        $html .= '<div ' . $this->getRenderAttributeString('wrapper') . ' role="timer">';

        $html .= '<span class="elementor-progress-bar" data-max="' . $settings['percent']['size'] . '"></span>';

        if (!empty($settings['inner_text'])) {
            $data_inner = ' data-inner="' . $settings['inner_text'] . '"';
        } else {
            $data_inner = '';
        }

        $html .= '<span class="elementor-progress-inner-text"' . $data_inner . '>';

        $html .= '<span class="elementor-progress-text"></span>';

        if ('hide' !== $settings['display_percentage']) {
            $html .= '<span class="elementor-progress-percentage"></span>';
        }

        $html .= '</span></div>';

        echo $html;
    }

    protected function _contentTemplate()
    {
        ?>
        <#
        var html = '';

        if ( '' !== settings.title ) {
            html += '<span class="elementor-title">' + settings.title + '</span>';
        }

        html += '<div class="elementor-progress-wrapper progress-' + settings.progress_type + '" role="timer">';

        html += '<span class="elementor-progress-bar" data-max="' + settings.percent.size + '"></span>';

        if ( '' !== settings.sub_title ) {
            var data_inner = ' data-inner="' + settings.inner_text + '"';
        } else {
            var data_inner = '';
        }

        html += '<span class="elementor-progress-inner-text"' + data_inner + '>';
        html += '<span class="elementor-progress-text"></span>';

        if ( 'hide' !== settings.display_percentage ) {
            html += '<span class="elementor-progress-percentage"></span>';
        }

        html += '</span></div>';

        print( html );
        #>
        <?php
    }
}
