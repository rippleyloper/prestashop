<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:30
  from 'module:ttcmsbannerviewstemplates' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085542607421_07371404',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '34ed13751d29713658e645fa03796bb2a62c2d17' => 
    array (
      0 => 'module:ttcmsbannerviewstemplates',
      1 => 1610129320,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085542607421_07371404 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
	<div id="ttcmsbanner" class="col-sm-8">
	  <?php echo $_smarty_tpl->tpl_vars['cms_infos']->value['text'];?>

	</div>
<?php }
}
}
