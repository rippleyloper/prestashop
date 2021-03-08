<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:28:11
  from '/var/www/html/ps_dev/admin0178uoq0b/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085a1b8e8c21_39109549',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f9f8e963206bc4516bed26c1cdedca6a5efee28' => 
    array (
      0 => '/var/www/html/ps_dev/admin0178uoq0b/themes/default/template/content.tpl',
      1 => 1610114440,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085a1b8e8c21_39109549 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div>
<?php }
}
