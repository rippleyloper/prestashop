<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

defined('_PS_VERSION_') or exit;

class CreativeWidgetModule
{
    /**
     * @var string widget id
     */
    public $id_base = 'module';

    /**
     * @var string widget name
     */
    public $name;

    /**
     * @var string widget icon
     */
    public $icon = 'navigation-horizontal';

    public $editMode = false;

    /**
     * @var Context
     */
    public $context;

    public $exclude = array('creativeelements');

    public function __construct()
    {
        $this->name = CreativeElements\__('Module', 'elementor');
        $this->context = Context::getContext();

        if (isset($this->context->controller->controller_name) && $this->context->controller->controller_name == 'CreativeEditor') {
            $this->editMode = true;
        }
    }

    public function getForm()
    {
        $availableModules = array(CreativeElements\__('- Select Module -', 'elementor'));

        if ($this->editMode) {
            $availableModules += $this->getModuleOptions();
        }

        return array(
            'section_pswidget_options' => array(
                'label' => CreativeElements\__('Widget Settings', 'elementor'),
                'type' => 'section',
            ),
            'module' => array(
                'label' => CreativeElements\__('Module', 'elementor'),
                'type' => 'select',
                'label_block' => true,
                'default' => '0',
                'description' => CreativeElements\__('Only those modules are available which implements the WidgetInterface', 'elementor'),
                'section' => 'section_pswidget_options',
                'options' => $availableModules,
            ),
        );
    }

    public function parseOptions($optionsSource, $preview = false)
    {
        $content = empty($optionsSource['module']) ? '' : $this->renderModule('displayCreativeWidget', array(), $optionsSource['module']);

        return array(
            'content' => $content,
        );
    }

    public function getModuleOptions()
    {
        $table = _DB_PREFIX_ . 'module';
        $exclude = implode("','", $this->exclude);
        $rows = Db::getInstance()->executeS(
            "SELECT m.name FROM $table AS m " . Shop::addSqlAssociation('module', 'm') .
            " WHERE m.active = 1 AND m.name NOT IN ('$exclude')"
        );

        $modules = array();
        foreach ($rows as $row) {
            try {
                $mod = Module::getInstanceByName($row['name']);

                if (Validate::isLoadedObject($mod) && method_exists($mod, 'renderWidget')) {
                    $modules[$mod->name] = $mod->displayName;
                }
            } catch (Exception $ex) {
                // TODO
            }
        }
        return $modules;
    }

    public function renderModule($hook_name, $hook_args = array(), $module = null)
    {
        $res = '';
        try {
            $mod = Module::getInstanceByName($module);

            if (Validate::isLoadedObject($mod) && method_exists($mod, 'renderWidget')) {
                $res = $mod->renderWidget($hook_name, $hook_args);
            }
        } catch (Exception $ex) {
            // TODO
        }
        return $res;
    }
}
