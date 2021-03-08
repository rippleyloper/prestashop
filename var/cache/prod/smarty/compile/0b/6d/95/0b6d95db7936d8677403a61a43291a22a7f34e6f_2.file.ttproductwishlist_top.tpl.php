<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:31
  from '/var/www/html/ps_dev/modules/ttproductwishlist/views/templates/hook/ttproductwishlist_top.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600855436f7291_35432237',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0b6d95db7936d8677403a61a43291a22a7f34e6f' => 
    array (
      0 => '/var/www/html/ps_dev/modules/ttproductwishlist/views/templates/hook/ttproductwishlist_top.tpl',
      1 => 1610129324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600855436f7291_35432237 (Smarty_Internal_Template $_smarty_tpl) {
?>
<li>
    <a class="wishtlist_top" href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getModuleLink('ttproductwishlist','mywishlist',array(),true),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Wishlists','mod'=>'ttproductwishlist'),$_smarty_tpl ) );?>
" rel="nofollow">
        <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Wishlists','mod'=>'ttproductwishlist'),$_smarty_tpl ) );?>
 (<span class="cart-wishlist-number"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['count_product']->value, ENT_QUOTES, 'UTF-8');?>
</span>)</span>
    </a>
</li>
<?php }
}
