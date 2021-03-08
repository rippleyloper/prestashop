<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:25
  from 'module:ttspecialsviewstemplatesh' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553da982e2_76813771',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '32930509ca8147d3108f45aa8704d57734ba7ab1' => 
    array (
      0 => 'module:ttspecialsviewstemplatesh',
      1 => 1610129324,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 1,
  ),
),false)) {
function content_6008553da982e2_76813771 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('tt_cnt', "1");
$_smarty_tpl->_assignInScope('tt_total', "0");
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>
	<?php $_smarty_tpl->_assignInScope('tt_total', $_smarty_tpl->tpl_vars['tt_total']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<section class="ttspecial-products clearfix col-sm-4">
  <h3 class="tt-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Special Products','mod'=>'ttspecials'),$_smarty_tpl ) );?>
</h3>
  <div class="ttspecial-list">
  <div class="row">
  <div class="products">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>
      <?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </div>
  </div>
  </div>
  <?php if ($_smarty_tpl->tpl_vars['tt_total']->value > 4) {?>
	<div class="customNavigation">
		<a class="btn prev ttspecial_prev"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Prev','mod'=>'ttspecials'),$_smarty_tpl ) );?>
</a>
		<a class="btn next ttspecial_next"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Next','mod'=>'ttspecials'),$_smarty_tpl ) );?>
</a>
	</div>
 <?php }?>
   <div class="allproduct"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['allSpecialProductsLink']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All sale products','mod'=>'ttspecials'),$_smarty_tpl ) );?>
</a></div>
</section><?php }
}
