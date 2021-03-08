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

class ElementSection extends ElementBase
{
    protected static $_edit_tools;

    private static $presets = array();

    protected static function getDefaultEditTools()
    {
        return array(
            'duplicate' => array(
                'title' => __('Duplicate', 'elementor'),
                'icon' => 'files-o',
            ),
            'save' => array(
                'title' => __('Save', 'elementor'),
                'icon' => 'floppy-o',
            ),
            'remove' => array(
                'title' => __('Remove', 'elementor'),
                'icon' => 'times',
            ),
        );
    }

    public function getName()
    {
        return 'section';
    }

    public function getTitle()
    {
        return __('Section', 'elementor');
    }

    public function getIcon()
    {
        return 'columns';
    }

    public static function getPresets($columns_count = null, $preset_index = null)
    {
        if (!self::$presets) {
            self::initPresets();
        }

        $presets = self::$presets;

        if (null !== $columns_count) {
            $presets = $presets[$columns_count];
        }

        if (null !== $preset_index) {
            $presets = $presets[$preset_index];
        }

        return $presets;
    }

    public static function initPresets()
    {
        $additional_presets = array(
            2 => array(
                array(
                    'preset' => array(33, 66),
                ),
                array(
                    'preset' => array(66, 33),
                ),
            ),
            3 => array(
                array(
                    'preset' => array(25, 25, 50),
                ),
                array(
                    'preset' => array(50, 25, 25),
                ),
                array(
                    'preset' => array(25, 50, 25),
                ),
                array(
                    'preset' => array(16, 66, 16),
                ),
            ),
        );

        foreach (range(1, 10) as $columns_count) {
            self::$presets[$columns_count] = array(
                array(
                    'preset' => array(),
                ),
            );

            $preset_unit = floor(1 / $columns_count * 100);

            for ($i = 0; $i < $columns_count; $i++) {
                self::$presets[$columns_count][0]['preset'][] = $preset_unit;
            }

            if (!empty($additional_presets[$columns_count])) {
                self::$presets[$columns_count] = array_merge(self::$presets[$columns_count], $additional_presets[$columns_count]);
            }

            foreach (self::$presets[$columns_count] as $preset_index => &$preset) {
                $preset['key'] = $columns_count . $preset_index;
            }
        }
    }

    public function getConfig($item = null)
    {
        $config = parent::getConfig($item);

        $config['presets'] = self::getPresets();

        return $config;
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_layout',
            array(
                'label' => __('Layout', 'elementor'),
                'tab' => ControlsManager::TAB_LAYOUT,
            )
        );

        $this->addControl(
            'stretch_section',
            array(
                'label' => __('Stretch Section', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'elementor'),
                'label_off' => __('No', 'elementor'),
                'return_value' => 'section-stretched',
                'prefix_class' => 'elementor-',
                'force_render' => true,
                'hide_in_inner' => true,
                'description' => __('Stretch the section to the full width of the page using JS.', 'elementor') .
                    sprintf(' <a href="%s" target="_blank">%s</a>', 'https://go.elementor.com/stretch-section/', __('Learn more.', 'elementor')),
            )
        );

        $this->addControl(
            'layout',
            array(
                'label' => __('Content Width', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'boxed',
                'options' => array(
                    'boxed' => __('Boxed', 'elementor'),
                    'full_width' => __('Full Width', 'elementor'),
                ),
                'prefix_class' => 'elementor-section-',
            )
        );

        $this->addControl(
            'content_width',
            array(
                'label' => __('Content Width', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 500,
                        'max' => 1600,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'layout' => array('boxed'),
                ),
                'show_label' => false,
                'separator' => 'none',
            )
        );

        $this->addControl(
            'gap',
            array(
                'label' => __('Columns Gap', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => __('Default', 'elementor'),
                    'no' => __('No Gap', 'elementor'),
                    'narrow' => __('Narrow', 'elementor'),
                    'extended' => __('Extended', 'elementor'),
                    'wide' => __('Wide', 'elementor'),
                    'wider' => __('Wider', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'height',
            array(
                'label' => __('Height', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => __('Default', 'elementor'),
                    'full' => __('Fit To Screen', 'elementor'),
                    'min-height' => __('Min Height', 'elementor'),
                ),
                'prefix_class' => 'elementor-section-height-',
                'hide_in_inner' => true,
            )
        );

        $this->addControl(
            'custom_height',
            array(
                'label' => __('Minimum Height', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 400,
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1440,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-container' => 'min-height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'height' => array('min-height'),
                ),
                'hide_in_inner' => true,
            )
        );

        $this->addControl(
            'height_inner',
            array(
                'label' => __('Height', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => __('Default', 'elementor'),
                    'min-height' => __('Min Height', 'elementor'),
                ),
                'prefix_class' => 'elementor-section-height-',
                'hide_in_top' => true,
            )
        );

        $this->addControl(
            'custom_height_inner',
            array(
                'label' => __('Minimum Height', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => 400,
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1440,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-container' => 'min-height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'height_inner' => array('min-height'),
                ),
                'hide_in_top' => true,
            )
        );

        $this->addControl(
            'column_position',
            array(
                'label' => __('Column Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'middle',
                'options' => array(
                    'stretch' => __('Stretch', 'elementor'),
                    'top' => __('Top', 'elementor'),
                    'middle' => __('Middle', 'elementor'),
                    'bottom' => __('Bottom', 'elementor'),
                ),
                'prefix_class' => 'elementor-section-items-',
                'condition' => array(
                    'height' => array('full', 'min-height'),
                ),
            )
        );

        $this->addControl(
            'content_position',
            array(
                'label' => __('Content Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => __('Default', 'elementor'),
                    'top' => __('Top', 'elementor'),
                    'middle' => __('Middle', 'elementor'),
                    'bottom' => __('Bottom', 'elementor'),
                ),
                'prefix_class' => 'elementor-section-content-',
            )
        );

        $this->addControl(
            'structure',
            array(
                'label' => __('Structure', 'elementor'),
                'type' => ControlsManager::STRUCTURE,
                'default' => '10',
            )
        );

        $this->endControlsSection();

        // Section background
        $this->startControlsSection(
            'section_background',
            array(
                'label' => __('Background', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addGroupControl(
            GroupControlBackground::getType(),
            array(
                'name' => 'background',
                'types' => array('classic', 'video'),
            )
        );

        $this->endControlsSection();

        // Background Overlay
        $this->startControlsSection(
            'background_overlay_section',
            array(
                'label' => __('Background Overlay', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => array(
                    'background_background' => array('classic', 'video'),
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBackground::getType(),
            array(
                'name' => 'background_overlay',
                'selector' => '{{WRAPPER}} > .elementor-background-overlay',
                'condition' => array(
                    'background_background' => array('classic', 'gradient', 'video'),
                ),
            )
        );

        $this->addControl(
            'background_overlay_opacity',
            array(
                'label' => __('Opacity (%)', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => .5,
                ),
                'range' => array(
                    'px' => array(
                        'max' => 1,
                        'step' => 0.01,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-background-overlay' => 'opacity: {{SIZE}};',
                ),
                'condition' => array(
                    'background_overlay_background' => array('classic'),
                ),
            )
        );

        $this->endControlsSection();

        // Section border
        $this->startControlsSection(
            'section_border',
            array(
                'label' => __('Border', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'border',
            )
        );

        $this->addControl(
            'border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}}, {{WRAPPER}} > .elementor-background-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBoxShadow::getType(),
            array(
                'name' => 'box_shadow',
            )
        );

        $this->endControlsSection();

        // Section Typography
        $this->startControlsSection(
            'section_typo',
            array(
                'label' => __('Typography', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'heading_color',
            array(
                'label' => __('Heading Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} > .elementor-container .elementor-heading-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} > .elementor-container' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} > .elementor-container a' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} > .elementor-container a:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} > .elementor-container' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->endControlsSection();

        // Section Advanced
        $this->startControlsSection(
            'section_advanced',
            array(
                'label' => __('Advanced', 'elementor'),
                'tab' => ControlsManager::TAB_ADVANCED,
            )
        );

        $this->addResponsiveControl(
            'margin',
            array(
                'label' => __('Margin', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'allowed_dimensions' => 'vertical',
                'placeholder' => array(
                    'top' => '',
                    'right' => 'auto',
                    'bottom' => '',
                    'left' => 'auto',
                ),
                'selectors' => array(
                    '{{WRAPPER}}' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
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
                    '{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            '_section_responsive',
            array(
                'label' => __('Responsive', 'elementor'),
                'tab' => ControlsManager::TAB_ADVANCED,
            )
        );

        $this->addControl(
            'reverse_order_mobile',
            array(
                'label' => __('Reverse Columns', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => __('Yes', 'elementor'),
                'label_off' => __('No', 'elementor'),
                'return_value' => 'reverse-mobile',
                'description' => __('Reverse column order - When on mobile, the column order is reversed, so the last column appears on top and vice versa.', 'elementor'),
            )
        );

        $this->addControl(
            'heading_visibility',
            array(
                'label' => __('Visibility', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            )
        );

        $this->addControl(
            'responsive_description',
            array(
                'raw' => __('Attention: The display settings (show/hide for mobile, tablet or desktop) will only take effect once you are on the preview or live page, and not while you\'re in editing mode in Elementor.', 'elementor'),
                'type' => ControlsManager::RAW_HTML,
                'classes' => 'elementor-descriptor',
            )
        );

        $this->addControl(
            'hide_desktop',
            array(
                'label' => __('Hide On Desktop', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => __('Hide', 'elementor'),
                'label_off' => __('Show', 'elementor'),
                'return_value' => 'hidden-desktop',
            )
        );

        $this->addControl(
            'hide_tablet',
            array(
                'label' => __('Hide On Tablet', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => __('Hide', 'elementor'),
                'label_off' => __('Show', 'elementor'),
                'return_value' => 'hidden-tablet',
            )
        );

        $this->addControl(
            'hide_mobile',
            array(
                'label' => __('Hide On Mobile', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => __('Hide', 'elementor'),
                'label_off' => __('Show', 'elementor'),
                'return_value' => 'hidden-phone',
            )
        );

        $this->endControlsSection();
    }

    protected function _renderSettings()
    {
        ?>
        <div class="elementor-element-overlay"></div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <# if ( 'video' === settings.background_background ) {
            var videoLink = settings.background_video_link;

            if ( videoLink ) {
                var videoID = elementor.helpers.getYoutubeIDFromURL( settings.background_video_link ); #>

                <div class="elementor-background-video-container elementor-hidden-phone">
                    <# if ( videoID ) { #>
                        <div class="elementor-background-video" data-video-id="{{ videoID }}"></div>
                    <# } else { #>
                        <video class="elementor-background-video" src="{{ videoLink }}" autoplay loop muted></video>
                    <# } #>
                </div>
            <# }

            if ( settings.background_video_fallback ) { #>
                <div class="elementor-background-video-fallback" style="background-image: url({{ settings.background_video_fallback.url }})"></div>
            <# }
        }

        if ( 'classic' === settings.background_overlay_background ) { #>
            <div class="elementor-background-overlay"></div>
        <# } #>
        <div class="elementor-container elementor-column-gap-{{ settings.gap }}" <# if ( settings.getRenderAttributeString ) { #>{{{ settings.getRenderAttributeString( 'wrapper' ) }}} <# } #> >
            <div class="elementor-row"></div>
        </div>
        <?php
    }

    public function beforeRender()
    {
        $section_type = $this->getData('isInner') ? 'inner' : 'top';

        $this->addRenderAttribute('wrapper', 'class', array(
            'elementor-section',
            'elementor-element',
            'elementor-element-' . $this->getId(),
            'elementor-' . $section_type . '-section',
        ));

        $settings = $this->getSettings();

        foreach ($this->getClassControls() as $control) {
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

        $this->addRenderAttribute('wrapper', 'data-element_type', $this->getName());
        ?>
        <div <?php echo $this->getRenderAttributeString('wrapper'); ?>>
            <?php if ('video' === $settings['background_background'] && $settings['background_video_link']) : ?>
                <?php $video_id = Utils::getYoutubeIdFromUrl($settings['background_video_link'])?>
                <div class="elementor-background-video-container elementor-hidden-phone">
                    <?php if ($video_id) : ?>
                        <div class="elementor-background-video" data-video-id="<?php echo $video_id; ?>"></div>
                    <?php else : ?>
                        <video class="elementor-background-video elementor-html5-video" src="<?php echo $settings['background_video_link'] ?>" autoplay loop muted></video>
                    <?php endif;?>
                </div>
            <?php endif;?>

            <?php if ('classic' === $settings['background_overlay_background']) : ?>
                <div class="elementor-background-overlay"></div>
            <?php endif;?>
            <div class="elementor-container elementor-column-gap-<?php echo esc_attr($settings['gap']); ?>">
                <div class="elementor-row">
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
        return Plugin::instance()->elements_manager->getElementTypes('column');
    }
}
