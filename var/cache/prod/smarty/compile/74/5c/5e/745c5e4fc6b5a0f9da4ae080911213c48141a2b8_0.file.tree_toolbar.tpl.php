<?php
/* Smarty version 3.1.33, created on 2021-01-22 09:49:07
  from '/var/www/html/ps_dev/admin0178uoq0b/themes/default/template/helpers/tree/tree_toolbar.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600ac9c3234346_20170338',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '745c5e4fc6b5a0f9da4ae080911213c48141a2b8' => 
    array (
      0 => '/var/www/html/ps_dev/admin0178uoq0b/themes/default/template/helpers/tree/tree_toolbar.tpl',
      1 => 1610114458,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600ac9c3234346_20170338 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="tree-actions pull-right">
	<?php if (isset($_smarty_tpl->tpl_vars['actions']->value)) {?>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['actions']->value, 'action');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['action']->value) {
?>
		<?php echo $_smarty_tpl->tpl_vars['action']->value->render();?>

	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	<?php }?>
</div>
<?php }
}
