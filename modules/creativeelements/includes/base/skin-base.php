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

abstract class SkinBase
{
    /**
     * @var Widget_Base|null
     */
    protected $parent = null;

    /**
     * Skin_Base constructor.
     *
     * @param Widget_Base $parent
     */
    public function __construct(Widget_Base $parent)
    {
        $this->parent = $parent;

        $this->_registerControlsActions();
    }

    abstract public function getId();

    abstract public function getTitle();

    abstract public function render();

    public function _contentTemplate()
    {
    }

    protected function _registerControlsActions()
    {
    }

    protected function getControlId($control_base_id)
    {
        $skin_id = str_replace('-', '_', $this->getId());
        return $skin_id . '_' . $control_base_id;
    }

    public function getInstanceValue($control_base_id)
    {
        $control_id = $this->getControlId($control_base_id);
        return $this->parent->get_settings($control_id);
    }

    public function addControl($id, $args)
    {
        return $this->parent->addControl($this->getControlId($id), $args);
    }

    final public function addGroupControl($group_name, $args = array())
    {
        $args['name'] = $this->getControlId($args['name']);

        $this->parent->addGroupControl($group_name, $args);
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}
