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

class WidgetTestimonial extends WidgetBase
{
    public function getName()
    {
        return 'testimonial';
    }

    public function getTitle()
    {
        return __('Testimonial', 'elementor');
    }

    public function getIcon()
    {
        return 'testimonial';
    }

    public function getCategories()
    {
        return array('general-elements');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_testimonial',
            array(
                'label' => __('Testimonial', 'elementor'),
            )
        );

        $this->addControl(
            'testimonial_content',
            array(
                'label' => __('Content', 'elementor'),
                'type' => ControlsManager::TEXTAREA,
                'rows' => '10',
                'default' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'),
            )
        );

        $this->addControl(
            'testimonial_image',
            array(
                'label' => __('Add Image', 'elementor'),
                'type' => ControlsManager::MEDIA,
                'seo' => true,
                'default' => array(
                    'url' => Utils::getPlaceholderImageSrc(),
                ),
            )
        );

        $this->addControl(
            'testimonial_name',
            array(
                'label' => __('Name', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => 'John Doe',
            )
        );

        $this->addControl(
            'testimonial_job',
            array(
                'label' => __('Job', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => 'Designer',
            )
        );

        $this->addControl(
            'testimonial_image_position',
            array(
                'label' => __('Image Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'aside',
                'options' => array(
                    'aside' => __('Aside', 'elementor'),
                    'top' => __('Top', 'elementor'),
                ),
                'condition' => array(
                    'testimonial_image[url]!' => '',
                ),
                'separator' => 'before',
            )
        );

        $this->addControl(
            'testimonial_alignment',
            array(
                'label' => __('Alignment', 'elementor'),
                'type' => ControlsManager::CHOOSE,
                'default' => 'center',
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

        // Content
        $this->startControlsSection(
            'section_style_testimonial_content',
            array(
                'label' => __('Content', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'content_content_color',
            array(
                'label' => __('Content Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ),
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'content_typography',
                'label' => __('Typography', 'elementor'),
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            )
        );

        $this->endControlsSection();

        // Image
        $this->startControlsSection(
            'section_style_testimonial_image',
            array(
                'label' => __('Image', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'image_size',
            array(
                'label' => __('Image Size', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'size_units' => array('px'),
                'range' => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 200,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
            )
        );

        $this->addControl(
            'image_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();

        // Name
        $this->startControlsSection(
            'section_style_testimonial_name',
            array(
                'label' => __('Name', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'name_text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ),
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-testimonial-name' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'name_typography',
                'label' => __('Typography', 'elementor'),
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            )
        );

        $this->endControlsSection();

        // Job
        $this->startControlsSection(
            'section_style_testimonial_job',
            array(
                'label' => __('Job', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'job_text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ),
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'job_typography',
                'label' => __('Typography', 'elementor'),
                'scheme' => SchemeTypography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettings();

        if (empty($settings['testimonial_name']) || empty($settings['testimonial_content'])) {
            return;
        }

        $has_image = false;
        if ('' !== $settings['testimonial_image']['url']) {
            $image_url = Helper::getMediaLink($settings['testimonial_image']['url']);
            $has_image = ' elementor-has-image';
        }

        $testimonial_alignment = $settings['testimonial_alignment'] ? ' elementor-testimonial-text-align-' . $settings['testimonial_alignment'] : '';
        $testimonial_image_position = $settings['testimonial_image_position'] ? ' elementor-testimonial-image-position-' . $settings['testimonial_image_position'] : '';
        ?>
        <div class="elementor-testimonial-wrapper<?php echo $testimonial_alignment; ?>">

            <?php if (!empty($settings['testimonial_content'])) : ?>
                <div class="elementor-testimonial-content">
                        <?php echo $settings['testimonial_content']; ?>
                </div>
            <?php endif;?>

            <div class="elementor-testimonial-meta<?php echo ($has_image ? $has_image : '') . $testimonial_image_position; ?>">
                <div class="elementor-testimonial-meta-inner">
                    <?php if (isset($image_url)) : ?>
                        <div class="elementor-testimonial-image">
                            <img src="<?php echo esc_attr($image_url); ?>" alt="<?php echo esc_attr(ControlMedia::getImageAlt($settings['testimonial_image'])); ?>" />
                        </div>
                    <?php endif;?>

                    <div class="elementor-testimonial-details">
                        <?php if (!empty($settings['testimonial_name'])) : ?>
                            <div class="elementor-testimonial-name">
                                <?php echo $settings['testimonial_name']; ?>
                            </div>
                        <?php endif;?>

                        <?php if (!empty($settings['testimonial_job'])) : ?>
                            <div class="elementor-testimonial-job">
                                <?php echo $settings['testimonial_job']; ?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <#
        var imageUrl = false, hasImage = '';
        if ( '' !== settings.testimonial_image.url ) {
            hasImage = ' elementor-has-image';
            imageUrl = settings.testimonial_image.url;

            if ( ! /^(https?:)?\/\//i.test( imageUrl ) ) {
                imageUrl = elementor.config.home_url + imageUrl;
            }
        }

        var testimonial_alignment = settings.testimonial_alignment ? ' elementor-testimonial-text-align-' + settings.testimonial_alignment : '';
        var testimonial_image_position = settings.testimonial_image_position ? ' elementor-testimonial-image-position-' + settings.testimonial_image_position : '';
        #>
        <div class="elementor-testimonial-wrapper{{ testimonial_alignment }}">

            <# if ( '' !== settings.testimonial_content ) { #>
                <div class="elementor-testimonial-content">
                    {{{ settings.testimonial_content }}}
                </div>
            <# } #>

            <div class="elementor-testimonial-meta{{ hasImage }}{{ testimonial_image_position }}">
                <div class="elementor-testimonial-meta-inner">
                    <# if ( imageUrl ) { #>
                    <div class="elementor-testimonial-image">
                        <img src="{{ imageUrl }}" alt="testimonial" />
                    </div>
                    <# } #>

                    <div class="elementor-testimonial-details">

                        <# if ( '' !== settings.testimonial_name ) { #>
                        <div class="elementor-testimonial-name">
                            {{{ settings.testimonial_name }}}
                        </div>
                        <# } #>

                        <# if ( '' !== settings.testimonial_job ) { #>
                        <div class="elementor-testimonial-job">
                            {{{ settings.testimonial_job }}}
                        </div>
                        <# } #>

                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
