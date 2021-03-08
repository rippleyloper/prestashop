<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:31
  from '/var/www/html/ps_dev/modules/ttcompare/views/templates/hook/product-compare-header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600855435e22e7_93843448',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5204df65f44a7633e0eb820056d41f5935ce956e' => 
    array (
      0 => '/var/www/html/ps_dev/modules/ttcompare/views/templates/hook/product-compare-header.tpl',
      1 => 1610129322,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600855435e22e7_93843448 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['comparator_max_item']->value) {?>
	<li>
		<a class="bt_compare" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['compareUrl']->value, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Compare','mod'=>'ttcompare'),$_smarty_tpl ) );?>
" rel="nofollow">
			<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Compare','mod'=>'ttcompare'),$_smarty_tpl ) );?>
 (<span class="total-compare-val"><?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['compared_products']->value), ENT_QUOTES, 'UTF-8');?>
</span>)</span>
		</a>
		<input type="hidden" name="compare_product_count" class="compare_product_count" value="<?php echo htmlspecialchars(count($_smarty_tpl->tpl_vars['compared_products']->value), ENT_QUOTES, 'UTF-8');?>
" />
	</li>
<?php }
}
}
