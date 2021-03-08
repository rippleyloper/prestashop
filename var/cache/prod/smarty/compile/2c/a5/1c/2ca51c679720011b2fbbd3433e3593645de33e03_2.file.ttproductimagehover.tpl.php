<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:25
  from '/var/www/html/ps_dev/modules/ttproductimagehover/views/templates/hook/ttproductimagehover.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553de7f829_56202511',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2ca51c679720011b2fbbd3433e3593645de33e03' => 
    array (
      0 => '/var/www/html/ps_dev/modules/ttproductimagehover/views/templates/hook/ttproductimagehover.tpl',
      1 => 1610129323,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553de7f829_56202511 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['home_image']->value) {?>
	<img class="second_image img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['home_image']->value, ENT_QUOTES, 'UTF-8');?>
" data-full-size-image-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['large_image']->value, ENT_QUOTES, 'UTF-8');?>
" alt="" />
<?php }
}
}
