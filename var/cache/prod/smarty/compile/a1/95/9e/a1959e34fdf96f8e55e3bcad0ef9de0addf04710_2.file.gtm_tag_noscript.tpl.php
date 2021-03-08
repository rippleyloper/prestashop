<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:11:33
  from '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/hook/gtm_tag_noscript.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008563538cd28_61094398',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1959e34fdf96f8e55e3bcad0ef9de0addf04710' => 
    array (
      0 => '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/hook/gtm_tag_noscript.tpl',
      1 => 1611158743,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008563538cd28_61094398 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $_smarty_tpl->tpl_vars['gtm_id']->value;?>
&nojscript=true"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --><?php }
}
