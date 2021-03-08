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

abstract class ControlBaseUnits extends ControlBaseMultiple
{
    public function getDefaultValue()
    {
        return array(
            'unit' => 'px',
        );
    }

    protected function getDefaultSettings()
    {
        return array(
            'size_units' => array('px'),
            'range' => array(
                'px' => array(
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ),
                'em' => array(
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ),
                'rem' => array(
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ),
                '%' => array(
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ),
                'deg' => array(
                    'min' => 0,
                    'max' => 360,
                    'step' => 1,
                ),
            ),
        );
    }

    protected function printUnitsTemplate()
    {
        ?>
        <# if ( data.size_units.length > 1 ) { #>
        <div class="elementor-units-choices">
            <# _.each( data.size_units, function( unit ) { #>
            <input id="elementor-choose-{{ data._cid + data.name + unit }}" type="radio" name="elementor-choose-{{ data.name }}" data-setting="unit" value="{{ unit }}">
            <label class="elementor-units-choices-label" for="elementor-choose-{{ data._cid + data.name + unit }}">{{{ unit }}}</label>
            <# } ); #>
        </div>
        <# } #>
        <?php
    }
}
