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

class WidgetVideo extends WidgetBase
{
    protected $_current_instance = array();

    public function getName()
    {
        return 'video';
    }

    public function getTitle()
    {
        return __('Video', 'elementor');
    }

    public function getIcon()
    {
        return 'youtube';
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_video',
            array(
                'label' => __('Video', 'elementor'),
            )
        );

        $this->addControl(
            'video_type',
            array(
                'label' => __('Video Type', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'youtube',
                'options' => array(
                    'youtube' => __('YouTube', 'elementor'),
                    'vimeo' => __('Vimeo', 'elementor'),
                    //'hosted' => __( 'HTML5 Video', 'elementor' ),
                ),
            )
        );

        $this->addControl(
            'link',
            array(
                'label' => __('Link', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Enter your YouTube link', 'elementor'),
                'default' => 'https://www.youtube.com/watch?v=9uOETcuFjbE',
                'label_block' => true,
                'condition' => array(
                    'video_type' => 'youtube',
                ),
            )
        );

        $this->addControl(
            'vimeo_link',
            array(
                'label' => __('Vimeo Link', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Enter your Vimeo link', 'elementor'),
                'default' => 'https://vimeo.com/235215203',
                'label_block' => true,
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'hosted_link',
            array(
                'label' => __('Link', 'elementor'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Enter your video link', 'elementor'),
                'default' => '',
                'label_block' => true,
                'condition' => array(
                    'video_type' => 'hosted',
                ),
            )
        );

        $this->addControl(
            'aspect_ratio',
            array(
                'label' => __('Aspect Ratio', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    '169' => '16:9',
                    '43' => '4:3',
                    '32' => '3:2',
                ),
                'default' => '169',
                'prefix_class' => 'elementor-aspect-ratio-',
            )
        );

        $this->addControl(
            'heading_youtube',
            array(
                'label' => __('Video Options', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            )
        );

        // YouTube
        $this->addControl(
            'yt_autoplay',
            array(
                'label' => __('Autoplay', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'no' => __('No', 'elementor'),
                    'yes' => __('Yes', 'elementor'),
                ),
                'condition' => array(
                    'video_type' => 'youtube',
                ),
                'default' => 'no',
            )
        );

        $this->addControl(
            'yt_rel',
            array(
                'label' => __('Suggested Videos', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'no' => __('Hide', 'elementor'),
                    'yes' => __('Show', 'elementor'),
                ),
                'default' => 'no',
                'condition' => array(
                    'video_type' => 'youtube',
                ),
            )
        );

        $this->addControl(
            'yt_controls',
            array(
                'label' => __('Player Control', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'yes' => __('Show', 'elementor'),
                    'no' => __('Hide', 'elementor'),
                ),
                'default' => 'yes',
                'condition' => array(
                    'video_type' => 'youtube',
                ),
            )
        );

        $this->addControl(
            'yt_showinfo',
            array(
                'label' => __('Player Title & Actions', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'yes' => __('Show', 'elementor'),
                    'no' => __('Hide', 'elementor'),
                ),
                'default' => 'yes',
                'condition' => array(
                    'video_type' => 'youtube',
                ),
            )
        );

        // Vimeo
        $this->addControl(
            'vimeo_autoplay',
            array(
                'label' => __('Autoplay', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'no' => __('No', 'elementor'),
                    'yes' => __('Yes', 'elementor'),
                ),
                'default' => 'no',
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'vimeo_loop',
            array(
                'label' => __('Loop', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'no' => __('No', 'elementor'),
                    'yes' => __('Yes', 'elementor'),
                ),
                'default' => 'no',
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'vimeo_title',
            array(
                'label' => __('Intro Title', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'yes' => __('Show', 'elementor'),
                    'no' => __('Hide', 'elementor'),
                ),
                'default' => 'yes',
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'vimeo_portrait',
            array(
                'label' => __('Intro Portrait', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'yes' => __('Show', 'elementor'),
                    'no' => __('Hide', 'elementor'),
                ),
                'default' => 'yes',
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'vimeo_byline',
            array(
                'label' => __('Intro Byline', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'yes' => __('Show', 'elementor'),
                    'no' => __('Hide', 'elementor'),
                ),
                'default' => 'yes',
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'vimeo_color',
            array(
                'label' => __('Controls Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'condition' => array(
                    'video_type' => 'vimeo',
                ),
            )
        );

        $this->addControl(
            'view',
            array(
                'label' => __('View', 'elementor'),
                'type' => ControlsManager::HIDDEN,
                'default' => 'youtube',
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_image_overlay',
            array(
                'label' => __('Image Overlay', 'elementor'),
                'type' => ControlsManager::SECTION,
            )
        );

        $this->addControl(
            'show_image_overlay',
            array(
                'label' => __('Image Overlay', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'no',
                'options' => array(
                    'no' => __('Hide', 'elementor'),
                    'yes' => __('Show', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'image_overlay',
            array(
                'label' => __('Image', 'elementor'),
                'type' => ControlsManager::MEDIA,
                'default' => array(
                    'url' => Utils::getPlaceholderImageSrc(),
                ),
                'condition' => array(
                    'show_image_overlay' => 'yes',
                ),
            )
        );

        $this->addControl(
            'show_play_icon',
            array(
                'label' => __('Play Icon', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
                'condition' => array(
                    'show_image_overlay' => 'yes',
                    'image_overlay[url]!' => '',
                ),
            )
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettings();

        if ('hosted' !== $settings['video_type']) {
            $video_link = 'youtube' === $settings['video_type'] ? $settings['link'] : $settings['vimeo_link'];
            if (empty($video_link)) {
                return;
            }

            $video_html = $this->videoParser($video_link, $this->getEmbedSettings());
        }
        ?>
        <div class="elementor-video-wrapper">
            <?php echo $video_html;?>
            <?php if ($this->hasImageOverlay()) : ?>
                <div class="elementor-custom-embed-image-overlay" style="background-image: url(<?php echo Helper::getMediaLink($settings['image_overlay']['url']); ?>);">
                    <?php if ('yes' === $settings['show_play_icon']) : ?>
                        <div class="elementor-custom-embed-play">
                            <i class="fa fa-play-circle"></i>
                        </div>
                    <?php endif;?>
                </div>
            <?php endif;?>
        </div>
        <?php
    }

    protected function videoParser($url, $settings, $wdth = 320, $hth = 320)
    {
        $params = '';
        if (strpos($url, 'youtube.com') !== false) {
            if (isset($settings['autoplay']) && $settings['autoplay']) {
                $params .= '?autoplay=1';
            } else {
                $params .= '?autoplay=0';
            }
            if (!$settings['rel']) {
                $params .= '&rel=0';
            }
            if (!$settings['controls']) {
                $params .= '&controls=0';
            }
            if (!$settings['showinfo']) {
                $params .= '&showinfo=0';
            }
            $step1 = explode('v=', $url);
            $step2 = explode('&amp;', $step1[1]);
            $iframe = '<iframe width="' . $wdth . '" height="' . $hth . '" src="https://www.youtube.com/embed/' . $step2[0] . $params . '" frameborder="0" allowfullscreen></iframe>';
        } else if (strpos($url, 'vimeo') !== false) {
            if (isset($settings['autoplay']) && $settings['autoplay']) {
                $params .= '?autoplay=1';
            } else {
                $params .= '?autoplay=0';
            }
            if ($settings['loop']) {
                $params .= '&loop=1';
            }
            if (!$settings['title']) {
                $params .= '&title=0';
            }
            if (!$settings['portrait']) {
                $params .= '&portrait=0';
            }
            if (!$settings['byline']) {
                $params .= '&byline=0';
            }
            if ($settings['color'] != '') {
                $params .= '&color=' . $settings['color'];
            }
            $id = preg_replace("/[^\/]+\D|(\/)/", "", rtrim($url, "/"));
            $embedurl = "https://player.vimeo.com/video/" . $id;
            $iframe = '<iframe src="' . $embedurl . $params . '"  width="' . $wdth . '" height="' . $hth . '"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        }
        return $iframe;
    }

    public function getEmbedSettings()
    {
        $settings = $this->getSettings();
        $params = array();

        if ('youtube' === $settings['video_type']) {
            $youtube_options = array('autoplay', 'rel', 'controls', 'showinfo');

            foreach ($youtube_options as $option) {
                if ('autoplay' === $option && $this->hasImageOverlay()) {
                    continue;
                }

                $value = ('yes' === $settings['yt_' . $option]) ? '1' : '0';
                $params[$option] = $value;
            }

            $params['wmode'] = 'opaque';
        }

        if ('vimeo' === $settings['video_type']) {
            $vimeo_options = array('autoplay', 'loop', 'title', 'portrait', 'byline');

            foreach ($vimeo_options as $option) {
                if ('autoplay' === $option && $this->hasImageOverlay()) {
                    continue;
                }

                $value = ('yes' === $settings['vimeo_' . $option]) ? '1' : '0';
                $params[$option] = $value;
            }

            $params['color'] = str_replace('#', '', $settings['vimeo_color']);
        }

        return $params;
    }

    protected function hasImageOverlay()
    {
        $settings = $this->getSettings();
        return !empty($settings['image_overlay']['url']) && 'yes' === $settings['show_image_overlay'];
    }

    protected function _contentTemplate()
    {
    }
}
