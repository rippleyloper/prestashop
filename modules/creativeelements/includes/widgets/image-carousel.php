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

class WidgetImageCarousel extends WidgetBase
{
    public function getName()
    {
        return 'image-carousel';
    }

    public function getTitle()
    {
        return __('Image Carousel', 'elementor');
    }

    public function getIcon()
    {
        return 'slider-push';
    }

    public function getCategories()
    {
        return array('general-elements');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_image_carousel',
            array(
                'label' => __('Carousel Items', 'elementor'),
            )
        );

        $this->addControl(
            'carousel',
            array(
                'type' => ControlsManager::REPEATER,
                'default' => array(
                    array(
                        'image' =>array(
                            'url' => Utils::getPlaceholderImageSrc(),
                        ),
                    ),
                ),
                'fields' => array(
                    array(
                        'name' => 'image',
                        'label' => __('Choose Image', 'elementor'),
                        'type' => ControlsManager::MEDIA,
                        'seo' => true,
                        'default' => array(
                            'url' => Utils::getPlaceholderImageSrc(),
                        ),
                    ),
                    array(
                        'name' => 'link',
                        'label' => __('Link', 'elementor'),
                        'type' => ControlsManager::URL,
                        'label_block' => true,
                        'placeholder' => __('http://your-link.com', 'elementor'),
                    ),
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
            'section_additional_options',
            array(
                'label' => __('Carousel Settings', 'elementor'),
                'type' => ControlsManager::SECTION,
            )
        );

        $slides_to_show = range(1, 10);
        $slides_to_show = array_combine($slides_to_show, $slides_to_show);

        $this->addResponsiveControl(
            'slides_to_show',
            array(
                'label' => __('Slides to Show', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array('' => __('Default', 'elementor')) + $slides_to_show,
            )
        );

        $this->addControl(
            'slides_to_scroll',
            array(
                'label' => __('Slides to Scroll', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '2',
                'options' => $slides_to_show,
                'condition' => array(
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->addControl(
            'image_stretch',
            array(
                'label' => __('Image Stretch', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'no',
                'options' => array(
                    'no' => __('No', 'elementor'),
                    'yes' => __('Yes', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'navigation',
            array(
                'label' => __('Navigation', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'both',
                'options' => array(
                    'both' => __('Arrows and Dots', 'elementor'),
                    'arrows' => __('Arrows', 'elementor'),
                    'dots' => __('Dots', 'elementor'),
                    'none' => __('None', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'additional_options',
            array(
                'label' => __('Additional Options', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            )
        );

        $this->addControl(
            'pause_on_hover',
            array(
                'label' => __('Pause on Hover', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'autoplay',
            array(
                'label' => __('Autoplay', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'autoplay_speed',
            array(
                'label' => __('Autoplay Speed', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'default' => 5000,
            )
        );

        $this->addControl(
            'infinite',
            array(
                'label' => __('Infinite Loop', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'effect',
            array(
                'label' => __('Effect', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'slide',
                'options' => array(
                    'slide' => __('Slide', 'elementor'),
                    'fade' => __('Fade', 'elementor'),
                ),
                'condition' => array(
                    'slides_to_show' => '1',
                ),
            )
        );

        $this->addControl(
            'speed',
            array(
                'label' => __('Animation Speed', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'default' => 500,
            )
        );

        $this->addControl(
            'direction',
            array(
                'label' => __('Direction', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'ltr',
                'options' => array(
                    'ltr' => __('Left', 'elementor'),
                    'rtl' => __('Right', 'elementor'),
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_navigation',
            array(
                'label' => __('Navigation', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => array(
                    'navigation' => array('arrows', 'dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'heading_style_arrows',
            array(
                'label' => __('Arrows', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'arrows_position',
            array(
                'label' => __('Arrows Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'inside',
                'options' => array(
                    'inside' => __('Inside', 'elementor'),
                    'outside' => __('Outside', 'elementor'),
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'arrows_size',
            array(
                'label' => __('Arrows Size', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 60,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'arrows_color',
            array(
                'label' => __('Arrows Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );
        $this->addControl(
            'arrows_bg_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper  .slick-slider .slick-prev, {{WRAPPER}} .elementor-image-carousel-wrapper  .slick-slider .slick-next' => 'background: {{VALUE}};',
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'heading_style_dots',
            array(
                'label' => __('Dots', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'dots_position',
            array(
                'label' => __('Dots Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'outside',
                'options' => array(
                    'outside' => __('Outside', 'elementor'),
                    'inside' => __('Inside', 'elementor'),
                ),
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'dots_size',
            array(
                'label' => __('Dots Size', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 5,
                        'max' => 10,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'dots_color',
            array(
                'label' => __('Dots Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_image',
            array(
                'label' => __('Image', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'image_spacing',
            array(
                'label' => __('Spacing', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    '' => __('Default', 'elementor'),
                    'custom' => __('Custom', 'elementor'),
                ),
                'default' => '',
                'condition' => array(
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->addControl(
            'image_spacing_custom',
            array(
                'label' => __('Image Spacing', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'size' => 20,
                ),
                'show_label' => false,
                'selectors' => array(
                    '{{WRAPPER}} .slick-list' => 'margin-left: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slick-slide .slick-slide-inner' => 'padding-left: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'image_spacing' => 'custom',
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-slide-image',
            )
        );

        $this->addControl(
            'image_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-slide-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();
    }

    public function onImport(&$widget)
    {
        // Compatibility fix with WP image-carousel
        if (isset($widget['settings']['carousel'][0]['url'])) {
            $carousel = array();
            $import_images = Plugin::instance()->templates_manager->getImportImagesInstance();

            foreach ($widget['settings']['carousel'] as &$img) {
                $image = $import_images->import($img);

                $carousel[] = array(
                    '_imported' => true,
                    '_id' => Utils::generateRandomString(),
                    'image' => $image ? $image : array(
                        'id' => 0,
                        'url' => Utils::getPlaceholderImageSrc(),
                    ),
                );
            }

            $widget['settings']['carousel'] = $carousel;
        }

        return $widget;
    }

    protected function render()
    {
        $settings = $this->getSettings();

        if (empty($settings['carousel'])) {
            return;
        }

        $slides = array();

        foreach ($settings['carousel'] as &$item) {
            $image_src = Helper::getMediaLink($item['image']['url']);
            $image_html = sprintf(
                '<img src="%s" title="%s" alt="%s" class="slick-slide-image" />',
                esc_attr($image_src),
                ControlMedia::getImageTitle($item['image']),
                ControlMedia::getImageAlt($item['image'])
            );

            if (!empty($item['link']['url'])) {
                $target = $item['link']['is_external'] ? ' target="_blank"' : '';

                $image_html = sprintf('<a href="%s"%s>%s</a>', $item['link']['url'], $target, $image_html);
            }

            $slides[] = '<div><div class="slick-slide-inner">' . $image_html . '</div></div>';
        }

        if (empty($slides)) {
            return;
        }

        $is_slideshow = '1' === $settings['slides_to_show'];
        $is_rtl = ('rtl' === $settings['direction']);
        $direction = $is_rtl ? 'rtl' : 'ltr';
        $show_dots = (in_array($settings['navigation'], array('dots', 'both')));
        $show_arrows = (in_array($settings['navigation'], array('arrows', 'both')));

        $slick_options = array(
            'slidesToShow' => empty($settings['slides_to_show']) ? 3 : absint($settings['slides_to_show']),
            'slidesToShowTablet' => empty($settings['slides_to_show_tablet']) ? 2 : absint($settings['slides_to_show_tablet']),
            'slidesToShowMobile' => empty($settings['slides_to_show_mobile']) ? 1 : absint($settings['slides_to_show_mobile']),
            'autoplaySpeed' => absint($settings['autoplay_speed']),
            'autoplay' => ('yes' === $settings['autoplay']),
            'infinite' => ('yes' === $settings['infinite']),
            'pauseOnHover' => ('yes' === $settings['pause_on_hover']),
            'speed' => absint($settings['speed']),
            'arrows' => $show_arrows,
            'dots' => $show_dots,
            'rtl' => $is_rtl,
        );

        $carousel_classes = array('elementor-image-carousel');

        if ($show_arrows) {
            $carousel_classes[] = 'slick-arrows-' . $settings['arrows_position'];
        }

        if ($show_dots) {
            $carousel_classes[] = 'slick-dots-' . $settings['dots_position'];
        }

        if ('yes' === $settings['image_stretch']) {
            $carousel_classes[] = 'slick-image-stretch';
        }

        if (!$is_slideshow) {
            $slick_options['slidesToScroll'] = absint($settings['slides_to_scroll']);
        } else {
            $slick_options['fade'] = ('fade' === $settings['effect']);
        }

        ?>
        <div class="elementor-image-carousel-wrapper elementor-slick-slider" dir="<?php echo $direction; ?>">
            <div class="<?php echo implode(' ', $carousel_classes); ?>" data-slider_options='<?php echo json_encode($slick_options); ?>'>
                <?php echo implode('', $slides); ?>
            </div>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
    }
}
