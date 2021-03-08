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

class WidgetSocialIcons extends WidgetBase
{
    public function getName()
    {
        return 'social-icons';
    }

    public function getTitle()
    {
        return __('Social Icons', 'elementor');
    }

    public function getIcon()
    {
        return 'social-icons';
    }

    public function getCategories()
    {
        return array('general-elements');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_social_icon',
            array(
                'label' => __('Social Icons', 'elementor'),
            )
        );

        $this->addControl(
            'social_icon_list',
            array(
                'label' => __('Social Icons', 'elementor'),
                'type' => ControlsManager::REPEATER,
                'default' => array(
                    array(
                        'social' => 'fa fa-facebook',
                    ),
                    array(
                        'social' => 'fa fa-twitter',
                    ),
                    array(
                        'social' => 'fa fa-google-plus',
                    ),
                ),
                'fields' => array(
                    array(
                        'name' => 'social',
                        'label' => __('Icon', 'elementor'),
                        'type' => ControlsManager::ICON,
                        'label_block' => true,
                        'default' => 'fa fa-wordpress',
                        'include' => array(
                            'fa fa-behance',
                            'fa fa-bitbucket',
                            'fa fa-codepen',
                            'fa fa-delicious',
                            'fa fa-digg',
                            'fa fa-dribbble',
                            'fa fa-facebook',
                            'fa fa-flickr',
                            'fa fa-foursquare',
                            'fa fa-github',
                            'fa fa-google-plus',
                            'fa fa-instagram',
                            'fa fa-jsfiddle',
                            'fa fa-linkedin',
                            'fa fa-medium',
                            'fa fa-pinterest',
                            'fa fa-product-hunt',
                            'fa fa-reddit',
                            'fa fa-snapchat',
                            'fa fa-soundcloud',
                            'fa fa-stack-overflow',
                            'fa fa-tumblr',
                            'fa fa-twitch',
                            'fa fa-twitter',
                            'fa fa-vimeo',
                            'fa fa-wordpress',
                            'fa fa-youtube',
                        ),
                    ),
                    array(
                        'name' => 'link',
                        'label' => __('Link', 'elementor'),
                        'type' => ControlsManager::URL,
                        'label_block' => true,
                        'default' => array(
                            'url' => '',
                            'is_external' => 'true',
                        ),
                        'placeholder' => __('http://your-link.com', 'elementor'),
                    ),
                ),
                'title_field' => '<i class="{{ social }}"></i> {{{ social.replace( \'fa fa-\', \'\' ).replace( \'-\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}',
            )
        );

        $this->addControl(
            'shape',
            array(
                'label' => __('Shape', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'rounded',
                'options' => array(
                    'rounded' => __('Rounded', 'elementor'),
                    'square' => __('Square', 'elementor'),
                    'circle' => __('Circle', 'elementor'),
                ),
                'prefix_class' => 'elementor-shape-',
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
                ),
                'default' => 'center',
                'selectors' => array(
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
            'section_social_style',
            array(
                'label' => __('Icon', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'icon_color',
            array(
                'label' => __('Icon Color', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default' => __('Official Color', 'elementor'),
                    'custom' => __('Custom', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'icon_primary_color',
            array(
                'label' => __('Primary Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'condition' => array(
                    'icon_color' => 'custom',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-social-icon' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'icon_secondary_color',
            array(
                'label' => __('Secondary Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'condition' => array(
                    'icon_color' => 'custom',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-social-icon' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'icon_size',
            array(
                'label' => __('Icon Size', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 6,
                        'max' => 300,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'icon_padding',
            array(
                'label' => __('Icon Padding', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ),
                'default' => array(
                    'unit' => 'em',
                ),
                'range' => array(
                    'em' => array(
                        'min' => 0,
                    ),
                ),
            )
        );

        $icon_spacing = is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

        $this->addControl(
            'icon_spacing',
            array(
                'label' => __('Icon Spacing', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-social-icon:not(:last-child)' => $icon_spacing,
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .elementor-social-icon',
            )
        );

        $this->addControl(
            'border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        ?>
        <div class="elementor-social-icons-wrapper">
            <?php foreach ($this->getSettings('social_icon_list') as $item) : ?>
                <?php
                $social = str_replace('fa fa-', '', $item['social']);
                $target = $item['link']['is_external'] ? ' target="_blank"' : '';
                ?>
                <a class="elementor-icon elementor-social-icon elementor-social-icon-<?php echo esc_attr($social); ?>" href="<?php echo esc_attr($item['link']['url']); ?>"<?php echo $target; ?>>
                    <i class="<?php echo $item['social']; ?>"></i>
                </a>
            <?php endforeach;?>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-social-icons-wrapper">
            <# _.each( settings.social_icon_list, function( item ) {
                var link = item.link ? item.link.url : '',
                    social = item.social.replace( 'fa fa-', '' ); #>
                <a class="elementor-icon elementor-social-icon elementor-social-icon-{{ social }}" href="{{ link }}">
                    <i class="{{ item.social }}"></i>
                </a>
            <# } ); #>
        </div>
        <?php
    }
}
