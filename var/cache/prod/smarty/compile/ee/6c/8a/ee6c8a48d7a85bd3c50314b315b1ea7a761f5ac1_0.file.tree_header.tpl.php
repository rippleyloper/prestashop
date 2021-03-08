<?php
/* Smarty version 3.1.33, created on 2021-01-22 09:49:07
  from '/var/www/html/ps_dev/admin0178uoq0b/themes/default/template/helpers/tree/tree_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600ac9c35579d1_57898530',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ee6c8a48d7a85bd3c50314b315b1ea7a761f5ac1' => 
    array (
      0 => '/var/www/html/ps_dev/admin0178uoq0b/themes/default/template/helpers/tree/tree_header.tpl',
      1 => 1610114460,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600ac9c35579d1_57898530 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="tree-panel-heading-controls clearfix">
	<?php if (isset($_smarty_tpl->tpl_vars['title']->value)) {?><i class="icon-tag"></i>&nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>$_smarty_tpl->tpl_vars['title']->value),$_smarty_tpl ) );
}?>
	<?php if (isset($_smarty_tpl->tpl_vars['toolbar']->value)) {
echo $_smarty_tpl->tpl_vars['toolbar']->value;
}?>
</div>
<?php }
}
