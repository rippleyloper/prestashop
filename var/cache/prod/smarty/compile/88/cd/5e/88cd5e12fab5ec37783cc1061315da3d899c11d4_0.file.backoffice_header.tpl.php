<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:09
  from '/var/www/html/ps_dev/modules/creativeelements/views/templates/hook/backoffice_header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008552ddda3e6_88768910',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '88cd5e12fab5ec37783cc1061315da3d899c11d4' => 
    array (
      0 => '/var/www/html/ps_dev/modules/creativeelements/views/templates/hook/backoffice_header.tpl',
      1 => 1610992939,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008552ddda3e6_88768910 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>.icon-AdminParentCreativeElements:before { content: ""; }</style>
<?php if (!empty($_smarty_tpl->tpl_vars['edit_width_ce']->value)) {
echo '<script'; ?>
 type="text/html" id="tmpl-btn-edit-with-ce">
	<a href="<?php echo $_smarty_tpl->tpl_vars['edit_width_ce']->value;?>
" class="btn pointer btn-edit-with-ce"><i class="material-icons">explicit</i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Edit with Creative Elements','mod'=>'creativeelements'),$_smarty_tpl ) );?>
</a>
<?php echo '</script'; ?>
>
<?php }
}
}
