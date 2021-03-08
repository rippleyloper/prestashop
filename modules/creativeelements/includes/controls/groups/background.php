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

class GroupControlBackground extends GroupControlBase
{
    public static function getType()
    {
        return 'background';
    }

    protected function _getChildDefaultArgs()
    {
        return array(
            'types' => array('classic'),
        );
    }

    protected function _getControls($args)
    {
        $available_types = array(
            'classic' => array(
                'title' => _x('Classic', 'Background Control', 'elementor'),
                'icon' => 'paint-brush',
            ),
            'video' => array(
                'title' => _x('Background Video', 'Background Control', 'elementor'),
                'icon' => 'video-camera',
            ),
        );

        $choose_types = array(
            'none' => array(
                'title' => _x('None', 'Background Control', 'elementor'),
                'icon' => 'ban',
            ),
        );

        foreach ($args['types'] as $type) {
            if (isset($available_types[$type])) {
                $choose_types[$type] = $available_types[$type];
            }
        }

        $controls = array();

        $controls['background'] = array(
            'label' => _x('Background Type', 'Background Control', 'elementor'),
            'type' => ControlsManager::CHOOSE,
            'default' => $args['default'],
            'options' => $choose_types,
            'label_block' => true,
        );

        // Background:color
        if (in_array('classic', $args['types'])) {
            $controls['color'] = array(
                'label' => _x('Color', 'Background Control', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'title' => _x('Background Color', 'Background Control', 'elementor'),
                'selectors' => array(
                    $args['selector'] => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'background' => array('classic'),
                ),
            );
        }
        // End Background:color

        // Background:image
        if (in_array('classic', $args['types'])) {
            $controls['image'] = array(
                'label' => _x('Image', 'Background Control', 'elementor'),
                'type' => ControlsManager::MEDIA,
                'title' => _x('Background Image', 'Background Control', 'elementor'),
                'separator' => '',
                'selectors' => array(
                    $args['selector'] => 'background-image: url("{{URL}}");',
                ),
                'condition' => array(
                    'background' => array('classic'),
                ),
            );

            $controls['position'] = array(
                'label' => _x('Position', 'Background Control', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => _x('None', 'Background Control', 'elementor'),
                    'top left' => _x('Top Left', 'Background Control', 'elementor'),
                    'top center' => _x('Top Center', 'Background Control', 'elementor'),
                    'top right' => _x('Top Right', 'Background Control', 'elementor'),
                    'center left' => _x('Center Left', 'Background Control', 'elementor'),
                    'center center' => _x('Center Center', 'Background Control', 'elementor'),
                    'center right' => _x('Center Right', 'Background Control', 'elementor'),
                    'bottom left' => _x('Bottom Left', 'Background Control', 'elementor'),
                    'bottom center' => _x('Bottom Center', 'Background Control', 'elementor'),
                    'bottom right' => _x('Bottom Right', 'Background Control', 'elementor'),
                ),
                'separator' => '',
                'selectors' => array(
                    $args['selector'] => 'background-position: {{VALUE}};',
                ),
                'condition' => array(
                    'background' => array('classic'),
                    'image[url]!' => '',
                ),
            );

            $controls['attachment'] = array(
                'label' => _x('Attachment', 'Background Control', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => _x('None', 'Background Control', 'elementor'),
                    'scroll' => _x('Scroll', 'Background Control', 'elementor'),
                    'fixed' => _x('Fixed', 'Background Control', 'elementor'),
                ),
                'separator' => '',
                'selectors' => array(
                    $args['selector'] => 'background-attachment: {{VALUE}};',
                ),
                'condition' => array(
                    'background' => array('classic'),
                    'image[url]!' => '',
                ),
            );

            $controls['repeat'] = array(
                'label' => _x('Repeat', 'Background Control', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => _x('None', 'Background Control', 'elementor'),
                    'no-repeat' => _x('No-repeat', 'Background Control', 'elementor'),
                    'repeat' => _x('Repeat', 'Background Control', 'elementor'),
                    'repeat-x' => _x('Repeat-x', 'Background Control', 'elementor'),
                    'repeat-y' => _x('Repeat-y', 'Background Control', 'elementor'),
                ),
                'separator' => '',
                'selectors' => array(
                    $args['selector'] => 'background-repeat: {{VALUE}};',
                ),
                'condition' => array(
                    'background' => array('classic'),
                    'image[url]!' => '',
                ),
            );

            $controls['size'] = array(
                'label' => _x('Size', 'Background Control', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => _x('None', 'Background Control', 'elementor'),
                    'auto' => _x('Auto', 'Background Control', 'elementor'),
                    'cover' => _x('Cover', 'Background Control', 'elementor'),
                    'contain' => _x('Contain', 'Background Control', 'elementor'),
                ),
                'separator' => '',
                'selectors' => array(
                    $args['selector'] => 'background-size: {{VALUE}};',
                ),
                'condition' => array(
                    'background' => array('classic'),
                    'image[url]!' => '',
                ),
            );
        }
        // End Background:image

        // Background:video
        $controls['video_link'] = array(
            'label' => _x('Video Link', 'Background Control', 'elementor'),
            'type' => ControlsManager::TEXT,
            'placeholder' => 'https://www.youtube.com/watch?v=9uOETcuFjbE',
            'description' => __('Insert YouTube link or video file (mp4 is recommended)', 'elementor'),
            'label_block' => true,
            'default' => '',
            'condition' => array(
                'background' => array('video'),
            ),
        );

        $controls['video_fallback'] = array(
            'label' => _x('Background Fallback', 'Background Control', 'elementor'),
            'description' => __('This cover image will replace the background video on mobile or tablet.', 'elementor'),
            'type' => ControlsManager::MEDIA,
            'label_block' => true,
            'condition' => array(
                'background' => array('video'),
            ),
            'selectors' => array(
                $args['selector'] => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
            ),
        );
        // End Background:video

        return $controls;
    }
}
