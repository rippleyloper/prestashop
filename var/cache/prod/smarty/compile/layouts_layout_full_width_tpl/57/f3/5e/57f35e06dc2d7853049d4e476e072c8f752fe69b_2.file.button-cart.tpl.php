<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:16:59
  from '/var/www/html/ps_dev/themes/PRS01/templates/catalog/_partials/customize/button-cart.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008577b54c065_76671892',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '57f35e06dc2d7853049d4e476e072c8f752fe69b' => 
    array (
      0 => '/var/www/html/ps_dev/themes/PRS01/templates/catalog/_partials/customize/button-cart.tpl',
      1 => 1610129333,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008577b54c065_76671892 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="product-add-to-cart">
	<?php if (!$_smarty_tpl->tpl_vars['configuration']->value['is_catalog']) {?>
		<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['cart'], ENT_QUOTES, 'UTF-8');?>
" method="post" class="add-to-cart-or-refresh">
			<div class="product-quantity" style="display:none;">
				<input type="number" name="id_product" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" class="product_page_product_id">
				<input type="number" name="id_customization" value="0" class="product_customization_id">
				<input type="hidden" name="token" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['static_token']->value, ENT_QUOTES, 'UTF-8');?>
" class="tt-token">
				<input type="number" name="qty" class="quantity_wanted input-group" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');?>
" min="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');?>
"/>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity'] > 0 && $_smarty_tpl->tpl_vars['product']->value['quantity'] >= $_smarty_tpl->tpl_vars['product']->value['minimal_quantity'] || $_smarty_tpl->tpl_vars['product']->value['allow_oosp']) {?>
				<button class="button ajax_add_to_cart_button add-to-cart btn btn-default" data-button-action="add-to-cart" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to cart'),$_smarty_tpl ) );?>
" <?php if (!$_smarty_tpl->tpl_vars['product']->value['add_to_cart_url']) {?>
              disabled
            <?php }?>>
					<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add to cart','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>
</span>
				</button>
			<?php } else { ?>
				<button class="button ajax_add_to_cart_button add-to-cart-disable btn btn-default" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Out of stock'),$_smarty_tpl ) );?>
">
				<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'out of stock'),$_smarty_tpl ) );?>
</span>
			</button>
			<?php }?>
		</form>
	<?php }?>
</div>

<?php }
}
