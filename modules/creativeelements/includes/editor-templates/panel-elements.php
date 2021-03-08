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
?>
<script type="text/template" id="tmpl-elementor-panel-elements">
    <div id="elementor-panel-elements-languageselector-area"></div>
    <div id="elementor-panel-elements-search-area"></div>
    <div id="elementor-panel-elements-wrapper"></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-elements-category">
    <div class="panel-elements-category-title panel-elements-category-title-{{ name }}">{{{ title }}}</div>
    <div class="panel-elements-category-items"></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-element-search">
    <input id="elementor-panel-elements-search-input" placeholder="<?php _e('Search Widget...', 'elementor');?>" />
    <i class="fa fa-search"></i>
</script>

<script type="text/template" id="tmpl-elementor-element-library-element">
    <div class="elementor-element">
        <div class="icon">
            <i class="eicon-{{ icon }}"></i>
        </div>
        <div class="elementor-element-title-wrapper">
            <div class="title">{{{ title }}}</div>
        </div>
    </div>
</script>
