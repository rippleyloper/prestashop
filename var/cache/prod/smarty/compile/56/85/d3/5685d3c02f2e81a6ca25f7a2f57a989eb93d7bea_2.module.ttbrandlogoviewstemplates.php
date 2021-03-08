<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:30
  from 'module:ttbrandlogoviewstemplates' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600855424829d1_29603125',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5685d3c02f2e81a6ca25f7a2f57a989eb93d7bea' => 
    array (
      0 => 'module:ttbrandlogoviewstemplates',
      1 => 1610129318,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600855424829d1_29603125 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('tt_cnt', "1");
$_smarty_tpl->_assignInScope('tt_total', "0");
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brands']->value, 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>
	<?php $_smarty_tpl->_assignInScope('tt_total', $_smarty_tpl->tpl_vars['tt_total']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

 <section class="brands container">
	<h1 class="h1 products-section-title text-uppercase tt-title">
		<?php if ($_smarty_tpl->tpl_vars['display_link_brand']->value) {?><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page_link']->value, ENT_QUOTES, 'UTF-8');?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Brands','mod'=>'ttbrandlogo'),$_smarty_tpl ) );?>
"><?php }?>
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Brands','mod'=>'ttbrandlogo'),$_smarty_tpl ) );?>

		<?php if ($_smarty_tpl->tpl_vars['display_link_brand']->value) {?></a><?php }?>
	</h1>
	<?php if ($_smarty_tpl->tpl_vars['tt_total']->value > 5) {?>
	<div class="customNavigation">
		<a class="btn prev ttbrandlogo_prev"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Prev','mod'=>'ttbrandlogo'),$_smarty_tpl ) );?>
</a>
		<a class="btn next ttbrandlogo_next"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Next','mod'=>'ttbrandlogo'),$_smarty_tpl ) );?>
</a>
	</div>
	<?php }?> 
	<div class="products">
			<?php if ($_smarty_tpl->tpl_vars['brands']->value) {?>
	 <ul id="ttbrandlogo-carousel" class="product_list">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brands']->value, 'brand', false, NULL, 'brand_list', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['brand']->value) {
?>
	<li>
	<div class="brand-image">
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['brand']->value['id_manufacturer'],$_smarty_tpl->tpl_vars['brand']->value['link_rewrite']), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
			<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getManufacturerImageLink($_smarty_tpl->tpl_vars['brand']->value['id_manufacturer']), ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value['name'], ENT_QUOTES, 'UTF-8');?>
" />
		</a>
	</div>
	<?php if ($_smarty_tpl->tpl_vars['brandname']->value) {?>
		<h1 class="h3 product-title" itemprop="name">
			<a class="product-name" itemprop="url"  href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getmanufacturerLink($_smarty_tpl->tpl_vars['brand']->value['id_manufacturer'],$_smarty_tpl->tpl_vars['brand']->value['link_rewrite']), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value['name'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['brand']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a>
		</h1>
	<?php }?>
	</li>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</ul>
	<?php } else { ?>
	<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No brand','mod'=>'ttbrandlogo'),$_smarty_tpl ) );?>
</p>
	<?php }?>
	</div>
</section><?php }
}
