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

class GroupControlImageSize extends GroupControlBase
{
    public static function getType()
    {
        return 'image-size';
    }

    /**
     * @param array $settings [ image => [ id => '', url => '' ], image_size => '', hover_animation => '' ]
     *
     * @return string
     */
    public static function getAttachmentImageHtml($settings, $image = 'image')
    {
        $id = $settings[$image]['id'];
        $url = $settings[$image]['url'];

        // Old version of image settings
        if (!isset($settings['image_size'])) {
            $settings['image_size'] = '';
        }

        $image_class = !empty($settings['hover_animation']) ? 'elementor-animation-' . $settings['hover_animation'] : '';
        $image_src = Helper::getMediaLink($url);
        $image_class_html = !empty($image_class) ? ' class="' . $image_class . '"' : '';

        $html = sprintf(
            '<img src="%s" title="%s" alt="%s"%s />',
            esc_attr($image_src),
            ControlMedia::getImageTitle($settings[$image]),
            ControlMedia::getImageAlt($settings[$image]),
            $image_class_html
        );

        return $html;
    }

    protected function _getChildDefaultArgs()
    {
        return array(
            'include' => array(),
            'exclude' => array(),
        );
    }

    private function _getImageSizes()
    {
        return array();
    }

    protected function _getControls($args)
    {
        $controls = array();

        $image_sizes = $this->_getImageSizes();

        if (!empty($args['default']) && isset($image_sizes[$args['default']])) {
            $default_value = $args['default'];
        } else {
            // Get the first item for default value
            $default_value = array_keys($image_sizes);
            $default_value = array_shift($default_value);
        }

        $controls['size'] = array(
            'label' => _x('Image Size', 'Image Size Control', 'elementor'),
            'type' => ControlsManager::SELECT,
            'options' => $image_sizes,
            'default' => $default_value,
            'label_block' => false,
        );

        if (isset($image_sizes['custom'])) {
            $controls['custom_dimension'] = array(
                'label' => _x('Image Dimension', 'Image Size Control', 'elementor'),
                'type' => ControlsManager::IMAGE_DIMENSIONS,
                'description' => __('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'elementor'),
                'condition' => array(
                    'size' => array('custom'),
                ),
                'separator' => 'none',
            );
        }

        return $controls;
    }

    public static function getAttachmentImageSrc($attachment_id, $group_name, $instance)
    {
        return false;
    }
}
