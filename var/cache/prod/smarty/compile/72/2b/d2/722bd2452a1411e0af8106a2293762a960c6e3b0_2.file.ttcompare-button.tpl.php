<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:26
  from '/var/www/html/ps_dev/modules/ttcompare/views/templates/hook/ttcompare-button.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553e786009_83372300',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '722bd2452a1411e0af8106a2293762a960c6e3b0' => 
    array (
      0 => '/var/www/html/ps_dev/modules/ttcompare/views/templates/hook/ttcompare-button.tpl',
      1 => 1610129322,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553e786009_83372300 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="compare">
	<a class="add_to_compare btn btn-primary<?php if ($_smarty_tpl->tpl_vars['added']->value) {?> checked<?php }?>" href="#" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_product']->value, ENT_QUOTES, 'UTF-8');?>
" data-dismiss="modal" title="<?php if ($_smarty_tpl->tpl_vars['added']->value) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove from Compare','mod'=>'ttcompare'),$_smarty_tpl ) );
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to Compare','mod'=>'ttcompare'),$_smarty_tpl ) );
}?>">
		<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to Compare','mod'=>'ttcompare'),$_smarty_tpl ) );?>
</span>
	</a>
</div>
<?php }
}
