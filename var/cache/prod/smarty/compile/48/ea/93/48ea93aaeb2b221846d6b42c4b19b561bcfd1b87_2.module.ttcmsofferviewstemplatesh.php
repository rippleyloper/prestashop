<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:26
  from 'module:ttcmsofferviewstemplatesh' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553ecc8841_25040009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48ea93aaeb2b221846d6b42c4b19b561bcfd1b87' => 
    array (
      0 => 'module:ttcmsofferviewstemplatesh',
      1 => 1610129321,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553ecc8841_25040009 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
	<div id="ttcmsoffer">
	  <?php echo $_smarty_tpl->tpl_vars['cms_infos']->value['text'];?>

	</div>
<?php }
}
}
