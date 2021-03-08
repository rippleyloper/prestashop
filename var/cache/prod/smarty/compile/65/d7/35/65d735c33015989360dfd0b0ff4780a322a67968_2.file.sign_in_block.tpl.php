<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:22
  from '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/sign_in_block.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553a05cea4_94081660',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '65d735c33015989360dfd0b0ff4780a322a67968' => 
    array (
      0 => '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/sign_in_block.tpl',
      1 => 1610117952,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553a05cea4_94081660 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['enable_header_login_popup']->value) {?>
    <div id="login-and-register-popup-sign" class="white-popup mfp-with-anim mfp-hide popup_type_login_and_register <?php if (!$_smarty_tpl->tpl_vars['header_both_popups']->value) {?>header_single_popup<?php }?>">
        <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    </div>
<?php }
}
}
