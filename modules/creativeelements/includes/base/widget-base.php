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

abstract class WidgetBase extends ElementBase
{
    protected $_has_template_content = true;

    public static function getType()
    {
        return 'widget';
    }

    protected static function getDefaultEditTools()
    {
        return array(
            'edit' => array(
                'title' => __('Edit', 'elementor'),
                'icon' => 'pencil',
            ),
            'duplicate' => array(
                'title' => __('Duplicate', 'elementor'),
                'icon' => 'files-o',
            ),
            'remove' => array(
                'title' => __('Remove', 'elementor'),
                'icon' => 'times',
            ),
        );
    }

    public function getIcon()
    {
        return 'apps';
    }

    public function __construct($data = array(), $args = array())
    {
        // do_action('elementor/element/before_construct', $this, $data, $args);
        // do_action('elementor/element/before_construct/' . $this->getName(), $this, $data, $args);

        parent::__construct($data, $args);

        // do_action('elementor/element/after_construct', $this);
        // do_action('elementor/element/after_construct/' . $this->getName(), $this);

        // First instance
        if (!$data) {
            // do_action('elementor/widget/' . $this->getName() . '/before_register_skins', $this);
            $this->_registerSkins();
            // do_action('elementor/widget/' . $this->getName() . '/after_register_skins', $this);
        }
    }

    public function startControlsSection($section_id, $args)
    {
        parent::startControlsSection($section_id, $args);

        static $is_first_section = true;

        if ($is_first_section) {
            $this->_registerSkinControl();

            $is_first_section = false;
        }
    }

    private function _registerSkinControl()
    {
        $skins = $this->getSkins();
        if (!empty($skins)) {
            $skin_options = array();

            if ($this->_has_template_content) {
                $skin_options[''] = __('Default', 'elementor');
            }

            foreach ($skins as $skin_id => $skin) {
                $skin_options[$skin_id] = $skin->getTitle();
            }

            // Get the first item for default value
            $default_value = array_keys($skin_options);
            $default_value = array_shift($default_value);

            if (1 >= sizeof($skin_options)) {
                $this->addControl(
                    '_skin',
                    array(
                        'label' => __('Skin', 'elementor'),
                        'type' => ControlsManager::HIDDEN,
                        'default' => $default_value,
                    )
                );
            } else {
                $this->addControl(
                    '_skin',
                    array(
                        'label' => __('Skin', 'elementor'),
                        'type' => ControlsManager::SELECT,
                        'default' => $default_value,
                        'options' => $skin_options,
                    )
                );
            }
        }
    }

    protected function _registerSkins()
    {
    }

    public function getConfig($item = null)
    {
        $config = parent::getConfig($item);

        $config['widget_type'] = $this->getName();

        return $config;
    }

    final public function printTemplate()
    {
        ob_start();
        $this->_contentTemplate();
        $contentTemplate = ob_get_clean();

        if (empty($contentTemplate)) {
            return;
        }
        ?>
        <script type="text/html" id="tmpl-elementor-<?php echo self::getType(); ?>-<?php echo esc_attr($this->getName()); ?>-content">
            <?php self::_renderSettings();?>
            <div class="elementor-widget-container">
                <?php echo $contentTemplate; ?>
            </div>
        </script>
        <?php
    }

    protected function _renderSettings()
    {
        ?>
        <div class="elementor-editor-element-settings elementor-editor-<?php echo esc_attr(static::getType()); ?>-settings elementor-editor-<?php echo esc_attr($this->getName()); ?>-settings">
            <ul class="elementor-editor-element-settings-list">
                <?php foreach (self::getEditTools() as $edit_tool_name => $edit_tool) : ?>
                    <li class="elementor-editor-element-setting elementor-editor-element-<?php echo $edit_tool_name; ?>">
                        <a href="#" title="<?php _e($edit_tool['title']); ?>">
                            <span class="elementor-screen-only"><?php _e($edit_tool['title']); ?></span>
                            <i class="fa fa-<?php echo $edit_tool['icon']; ?>"></i>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php
    }

    protected function parseTextEditor($content)
    {
        return $content;
    }

    public function renderContent()
    {
        if (Plugin::instance()->editor->isEditMode()) {
            $this->_renderSettings();
        }
        ?>
        <div class="elementor-widget-container">
            <?php
            ob_start();

            $skin = $this->getCurrentSkin();
            if ($skin) {
                $skin->setParent($this);
                $skin->render();
            } else {
                $this->render();
            }

            // echo apply_filters('elementor/widget/render_content', ob_get_clean(), $this);
            echo ob_get_clean();
            ?>
        </div>
        <?php
    }

    public function renderPlainContent()
    {
        $this->renderContent();
    }

    public function beforeRender()
    {
        $this->addRenderAttribute('_wrapper', 'class', array(
            'elementor-widget',
            'elementor-element',
            'elementor-element-' . $this->getId(),
            'elementor-widget-' . $this->getName(),
        ));

        $settings = $this->getSettings();

        foreach (self::getClassControls() as $control) {
            if (empty($settings[$control['name']])) {
                continue;
            }

            if (!$this->isControlVisible($control)) {
                continue;
            }

            $this->addRenderAttribute('_wrapper', 'class', $control['prefix_class'] . $settings[$control['name']]);
        }

        if (!empty($settings['_animation'])) {
            $this->addRenderAttribute('_wrapper', 'data-animation', $settings['_animation']);
        }

        $skin_type = !empty($settings['_skin']) ? $settings['_skin'] : 'default';

        $this->addRenderAttribute('_wrapper', 'data-element_type', $this->getName() . '.' . $skin_type);
        ?>
        <div <?php echo $this->getRenderAttributeString('_wrapper'); ?>>
        <?php
    }

    public function afterRender()
    {
        ?>
        </div>
        <?php
    }

    public function getRawData($with_html_content = false)
    {
        $data = parent::getRawData($with_html_content);

        unset($data['isInner']);

        $data['widgetType'] = $this->getData('widgetType');

        if ($with_html_content) {
            ob_start();

            $this->renderContent();

            $data['htmlCache'] = ob_get_clean();
        }

        return $data;
    }

    protected function _printContent()
    {
        $this->renderContent();
    }

    protected function getDefaultData()
    {
        $data = parent::getDefaultData();

        $data['widgetType'] = '';

        return $data;
    }

    protected function _getChildType(array $element_data)
    {
        return Plugin::instance()->elements_manager->getElementTypes('section');
    }

    public function addSkin(SkinBase $skin)
    {
        Plugin::instance()->skins_manager->addSkin($this, $skin);
    }

    public function getSkin($skin_id)
    {
        $skins = $this->getSkins();
        if (isset($skins[$skin_id])) {
            return $skins[$skin_id];
        }

        return false;
    }

    public function getCurrentSkinId()
    {
        return $this->getSettings('_skin');
    }

    public function getCurrentSkin()
    {
        return $this->getSkin($this->getCurrentSkinId());
    }

    public function removeSkin($skin_id)
    {
        return Plugin::instance()->skins_manager->removeSkin($this, $skin_id);
    }

    /**
     * @return Skin_Base[]
     */
    public function getSkins()
    {
        return Plugin::instance()->skins_manager->getSkins($this);
    }
}
