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

class WidgetTabs extends WidgetBase
{
    public function getName()
    {
        return 'tabs';
    }

    public function getTitle()
    {
        return __('Tabs', 'elementor');
    }

    public function getIcon()
    {
        return 'tabs';
    }

    public function getCategories()
    {
        return array('general-elements');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_tabs',
            array(
                'label' => __('Tabs', 'elementor'),
            )
        );

        $this->addControl(
            'tabs',
            array(
                'label' => __('Tabs Items', 'elementor'),
                'type' => ControlsManager::REPEATER,
                'default' => array(
                    array(
                        'tab_title' => __('Tab #1', 'elementor'),
                        'tab_content' => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor'),
                    ),
                    array(
                        'tab_title' => __('Tab #2', 'elementor'),
                        'tab_content' => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor'),
                    ),
                ),
                'fields' => array(
                    array(
                        'name' => 'tab_title',
                        'label' => __('Title & Content', 'elementor'),
                        'type' => ControlsManager::TEXT,
                        'default' => __('Tab Title', 'elementor'),
                        'placeholder' => __('Tab Title', 'elementor'),
                        'label_block' => true,
                    ),
                    array(
                        'name' => 'tab_content',
                        'label' => __('Content', 'elementor'),
                        'default' => __('Tab Content', 'elementor'),
                        'type' => ControlsManager::WYSIWYG,
                        'show_label' => false,
                    ),
                ),
                'title_field' => '{{{ tab_title }}}',
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
            'section_tabs_style',
            array(
                'label' => __('Tabs Style', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'border_width',
            array(
                'label' => __('Border Width', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 1,
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 10,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active > span:before' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active > span:after' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active > span' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tab-content' => 'border-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'border_color',
            array(
                'label' => __('Border Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active > span:before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active > span:after' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active > span' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tab-content' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'background_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-tab-title.active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-tabs .elementor-tab-content' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'tab_color',
            array(
                'label' => __('Title Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-tab-title' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ),
                'separator' => 'before',
            )
        );

        $this->addControl(
            'tab_active_color',
            array(
                'label' => __('Active Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-tabs .elementor-tabs-wrapper .elementor-tab-title.active' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-title > span',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_tab_content',
            array(
                'label' => __('Tab Content', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'content_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
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
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $tabs = $this->getSettings('tabs');
        ?>
        <div class="elementor-tabs">
            <?php $counter = 1; ?>
            <div class="elementor-tabs-wrapper">
                <?php foreach ($tabs as $item) : ?>
                    <div class="elementor-tab-title" data-tab="<?php echo $counter++; ?>"><span><?php echo $item['tab_title']; ?></span></div>
                <?php endforeach; ?>
            </div>

            <?php $counter = 1; ?>
            <div class="elementor-tabs-content-wrapper">
                <?php foreach ($tabs as $item) : ?>
                    <div class="elementor-tab-content elementor-clearfix" data-tab="<?php echo $counter++; ?>"><?php echo $this->parseTextEditor($item['tab_content']); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-tabs" data-active-tab="{{ editSettings.activeItemIndex ? editSettings.activeItemIndex : 0 }}">
            <#
            if ( settings.tabs ) {
                var counter = 1; #>
                <div class="elementor-tabs-wrapper">
                    <#
                    _.each( settings.tabs, function( item ) { #>
                        <div class="elementor-tab-title" data-tab="{{ counter }}"><span>{{{ item.tab_title }}}</span></div>
                    <#
                        counter++;
                    } ); #>
                </div>

                <# counter = 1; #>
                <div class="elementor-tabs-content-wrapper">
                    <#
                    _.each( settings.tabs, function( item ) { #>
                        <div class="elementor-tab-content elementor-clearfix elementor-repeater-item-{{ item._id }}" data-tab="{{ counter }}">{{{ item.tab_content }}}</div>
                    <#
                    counter++;
                    } ); #>
                </div>
            <# } #>
        </div>
        <?php
    }
}