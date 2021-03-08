<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:22
  from '/var/www/html/ps_dev/modules/creativeelements/views/templates/hook/creative_page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553a844ca9_22403878',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ecfab35f4c38d0da1c9eced65f4b86bc37c06422' => 
    array (
      0 => '/var/www/html/ps_dev/modules/creativeelements/views/templates/hook/creative_page.tpl',
      1 => 1610992939,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553a844ca9_22403878 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('ver', $_smarty_tpl->tpl_vars['creative_elements']->value->getVersion());?>
<div class="elementor elementor-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['creativepage_id']->value), ENT_QUOTES, 'UTF-8');?>
" data-version="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ver']->value, ENT_QUOTES, 'UTF-8');?>
">
	<div id="elementor-inner">
		<div id="elementor-section-wrap">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['creativepage_data']->value, 'section_data');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['section_data']->value) {
?>
			<?php $_smarty_tpl->_subTemplateRender((@constant('_PS_MODULE_DIR_')).('creativeelements/views/templates/hook/element_section.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('this'=>CreativeElements::factory('ElementSection',$_smarty_tpl->tpl_vars['section_data']->value)), 0, true);
?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</div>
	</div>
</div>
<?php }
}
